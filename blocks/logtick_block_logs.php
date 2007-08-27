<?php
# $Id: logtick_block_logs.php,v 1.1 2007/08/27 02:42:20 nobu Exp $

function b_logtick_logs_show($options)
{
    global $xoopsDB, $xoopsUser;
    $uid = $options[0];
    if (preg_match('/^\d+(,\d+)+$/', $uid)) { // show multiple user log
	$cond = "WHERE luid IN ($uid)";
	$disp = true;
    } elseif ($uid=='user') {	// show a user log
	if (!is_object($xoopsUser)) return false;
	$cond = "WHERE luid=".$xoopsUser->getVar('uid');
	$disp = false;
    } elseif ($uid) {		// show a user log
	$cond = "WHERE luid=$uid";
	$disp = false;
    } else {			// show any user log
	$cond = '';
	$disp = true;
    }
    $tlog = $xoopsDB->prefix('logtick_log');
    $tcat = $xoopsDB->prefix('logtick_cat');
    $users = $xoopsDB->prefix('users');
    $ord = "ORDER BY mtime DESC";

    $res = $xoopsDB->query("SELECT l.*, cname, uname, user_avatar FROM $tlog l LEFT JOIN $tcat ON pcat=catid LEFT JOIN $users ON luid=uid $cond ORDER BY mtime DESC", intval($options[1]));
    $logs = array();
    if ($res && $xoopsDB->getRowsNum($res)) {
	$myts =& MyTextSanitizer::getInstance();
	$now = time();
	while ($data = $xoopsDB->fetchArray($res)) {
	    $span = $data['lspan'];
	    if ($span==1800) $span = ':30';
	    else $span = intval($span/3600);
	    $data['span'] = $span;
	    $past = $now-$data['mtime'];
	    $data['mdate'] = formatTimestamp($data['mtime'], ($past<86400?_BL_LOGTICK_FMTS:($past<17280000?_BL_LOGTICK_FMTM:_BL_LOGTICK_FMTL)));
	    $data['comment'] = $myts->displayTarea($data['comment']);
	    $data['cname'] = htmlspecialchars($data['cname']);
	    $logs[] = $data;
	}
    }
    $url= XOOPS_URL."/modules/".basename(dirname(dirname(__FILE__)));
    return array('showuser'=>$disp, 'logs'=>$logs, 'module_url'=>$url);
}

function b_logtick_logs_edit($options)
{
    $uid = htmlspecialchars($options[0]);
    return _BL_LOGTICK_UID." <input name='options[0]' value='$uid'/><small>".
	_BL_LOGTICK_UID_DESC."</small><br/>".
	_BL_LOGTICK_ITEMS." <input name='options[1]' value='$options[1]' size='4'/>";
}
?>
