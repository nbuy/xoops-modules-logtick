<?php
# Logtick common functions
# $Id: functions.php,v 1.2 2008/03/22 05:34:39 nobu Exp $

if (!defined('XOOPS_ROOT_PATH')) die('illigal call');

define("TCAT", $xoopsDB->prefix('logtick_cat'));
define("TUC",  $xoopsDB->prefix('logtick_usercat'));
define("TLOG", $xoopsDB->prefix('logtick_log'));

define("LT_STYLE_NORMAL", 0);
define("LT_STYLE_OWNER", 1);
define("LT_STYLE_MINI", 2);

function lt_get_categories($uid=0, $detail=false) {
    global $xoopsDB, $xoopsUser;

    $myts =& MyTextSanitizer::getInstance();
    
    if ($uid==0 && is_object($xoopsUser)) $uid = $xoopsUser->getVar('uid');
    $res = $xoopsDB->query("SELECT c.* FROM ".TCAT." c, ".TUC." WHERE uidref=$uid AND catref=catid ORDER BY weight, cname");
    $ret = array();
    if (empty($res) || $xoopsDB->getRowsNum($res) == 0) return $ret;
    while ($data = $xoopsDB->fetchArray($res)) {
	$id = $data['catid'];
	$data['cname'] = htmlspecialchars($data['cname']);
	$data['description'] = $myts->displayTarea($data['description']);
	if ($detail) $ret[$id]=$data;
	else $ret[$id] = $data['cname'];
    }
    return $ret;
}

function lt_split_options($str) {
    $ret = array();
    if (empty($str)) return $ret;
    foreach (explode(',', $str) as $ln) {
	list($lab, $val) = preg_split('/=/', $ln, 2);
	$ret[$val] = $lab;
    }
    return $ret;
}

global $span_formats;
$span_formats = array('(\d+)d'=>3600*24, '(\d+)h'=>3600, '(\d+)m'=>60);
function span2sec($str) {
    global $span_formats;
    if (is_numeric($str)) return $str;
    $span = 0;
    foreach ($span_formats as $reg=>$sec) {
	if (preg_match("/^$reg/", $str, $d)) {
	    $span += intval($d[1])*$sec;
	    $str = preg_replace('/^$reg\\w*\\s*/', '', $str);
	    if (empty($str)) return $span;
	}
    }
    return $span;
}

class pastTime {

    function pastTime($fmt='') {
	$this->now = time();
	$this->rules = $this->getRules($fmt);
	$this->spans = $this->getRules(_MD_SPAN_EDIT_SEC);
    }

    function getRules($formats='') {
	global $xoopsModuleConfig;
	if (empty($formats)) $formats = $xoopsModuleConfig['timeformat'];
	if (empty($formats)) return array(0=>'m'); // default formats
	$ret = array();
	foreach (explode(',', $formats) as $rule) {
	    list($span, $fmt) = preg_split('/=/', $rule, 2);
	    $span = span2sec($span);
	    if (empty($ret[$span])) $ret[$span]=$fmt;
	}
	return $ret;
    }

    function getDate($stamp=0) {
	$past = $stamp?$this->now - $stamp:0;
	foreach ($this->rules as $span => $fmt) {
	    if (!$span || $past < $span) return formatTimestamp($stamp, $fmt);
	}
	return formatTimestamp($stamp);
    }

    function getSpan($sec) {
	$span = "";
	foreach ($this->spans as $t=>$fmt) {
	    $v = intval($sec/$t);
	    if ($v) $span .= sprintf($fmt, $v);
	    $sec = $sec % $t;
	}
	return $span;
    }
}

function show_list($uid, $catid="", $after=0, $style=LT_STYLE_OWNER) {
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsUser;
    require_once XOOPS_ROOT_PATH.'/class/template.php';
    require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
    $myts =& MyTextSanitizer::getInstance();

    $tpl = new XoopsTpl;
    $title = _MD_LOGTICK_TITLE;
    if (preg_match('/^\d+(,\d+)+$/', $uid)) { // show multiple user log
	$cond = "luid IN ($uid)";
	$disp = true;
    } elseif ($uid) {		// show a user log
	$cond = "luid=$uid";
	$title =  sprintf(_MD_LOGTICK_USER, xoops_getLinkedUnameFromId($uid));
	$disp = false;
    } else {			// show any user log
	$cond = '1';
	$disp = true;
    }

    $now = time();
    $timestamp = _MD_SHOW_TIMESTAMP." ".formatTimestamp($now, "m")."<!-- now: <{$now}> -->";
    $tpl->assign(array('now'=>$now, 'timestamp'=>$timestamp,
		       'anonymous'=>$xoopsConfig['anonymous'],
		       'showuser'=>$disp, 'title'=>$title));
    if (preg_match('/^\d+(,\d+)+$/', $catid)) { // show multiple categories
	$cond .= " AND pcat IN ($catid)";
    } elseif ($catid) {		// show a category
	$cond .= " AND pcat=$catid";
    }
    $users = $xoopsDB->prefix('users');

    $res = $xoopsDB->query("SELECT count(*) FROM ".TLOG." WHERE $cond");
    list($count) = $xoopsDB->fetchRow($res);
    $start = isset($_GET['start'])?intval($_GET['start']):0;
    $max = $xoopsModuleConfig['maxlist'];
    $args = array();
    if ($uid) $args[] = "uid=$uid";
    if ($catid) $args[] = "catid=$catid";
    $nav = new XoopsPageNav($count, $max, $start, "start", join("&", $args));

    $euid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
    $upnew = $xoopsModuleConfig['newentry'];
    if ($euid) {
	$cond = "($cond) OR (luid=$euid AND ($now-ltime)<=$upnew)";
    }
    $tpl->assign(array('pagenav'=>$nav->renderNav(), 'count'=>$count, 'maxpage'=>intval(($count+$max-1)/$max), 'current'=>intval($start/$max)+1));
    $res = $xoopsDB->query("SELECT l.*, cname, uname, user_avatar FROM ".TLOG." l LEFT JOIN ".TCAT." ON pcat=catid LEFT JOIN $users ON luid=uid WHERE $cond ORDER BY mtime DESC", $max, $start);
    $logs = array();
    if ($xoopsDB->getRowsNum($res)) {
	$ptime = new pastTime();
	while ($data = $xoopsDB->fetchArray($res)) {
	    if ($after) {	// check newer
		if ($after>$data['ltime']) return $timestamp;
		$after = 0;
	    }
	    $data['span'] = $ptime->getSpan($data['lspan']);
	    if (($now - $data['ltime'])<$upnew) $data['class'] = ' new';
	    $data['mdate'] = $ptime->getDate($data['mtime']);
	    $data['comment'] = $myts->displayTarea($data['comment']);
	    if ($style == LT_STYLE_OWNER && $data['luid']==$euid) {
		$data['comment'] .= " [<a href='editlog.php?logid=".$data['logid']."'>"._EDIT."</a>]";
	    }
	    $data['cname'] = htmlspecialchars($data['cname']);
	    $logs[] = $data;
	}
    }
    $tpl->assign('logs', $logs);
    return $tpl->fetch('db:logtick_result.html');
}

function set_logtick_breadcrumbs($paths=array()) {
    global $xoopsModule, $xoopsModuleConfig, $xoopsTpl;
    $module =& $xoopsModule;
    $modurl = XOOPS_URL."/modules/".$module->getVar('dirname');
    $breadcrumbs =
	array(array('name'=>$module->getVar('name'), 'url'=>"$modurl/"));
    $xoopsTpl->assign('localcss', $xoopsModuleConfig['localcss']);
    foreach ($paths as $lab=>$path) {
	if (preg_match('/^\//', $path)) $path = XOOPS_URL.$path;
	elseif (!preg_match('/^https?:\//i', $path)) $path = "$modurl/$path";
	$breadcrumbs[] = array('name'=>htmlspecialchars($lab), 'url' => $path);
    }
    if (!empty($xoopsTpl)) {
	$xoopsTpl->assign('xoops_breadcrumbs', $breadcrumbs);
	$xoopsTpl->assign('module_url', $modurl);
	$xoopsTpl->assign('localcss', $xoopsModuleConfig['localcss']);
    }
    return $breadcrumbs;
}

function utf8out($text) {
    header("Content-Type: text/html; charset=UTF-8");
    echo mb_convert_encoding($text, "UTF-8", _CHARSET);
    exit;
}
?>
