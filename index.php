<?php
# Logtick main page
# $Id: index.php,v 1.2 2007/11/24 09:49:13 nobu Exp $

include '../../mainfile.php';
include 'functions.php';

$myts =& MyTextSanitizer::getInstance();

$uid = isset($_GET['uid'])?$myts->stripSlashesGPC($_GET['uid']):'';
$catid = isset($_GET['catid'])?$myts->stripSlashesGPC($_GET['catid']):'';
$after = isset($_GET['after'])?intval($_GET['after']):0;

if ($after || isset($_GET['uids'])) {
    $uids = isset($_GET['uids'])?array_map('intval', $_GET['uids']):array();
    $uid = join(',', $uids);
    if (!isset($_SESSION['logtick']['uids']) || $_SESSION['logtick']['uids']!=$uid) {
	$_SESSION['logtick']['uids'] = $uid;
	$after = 1;
    }
}

if ($after || isset($_GET['cats'])) {
    $cats = isset($_GET['cats'])?array_map('intval', $_GET['cats']):array();
    $catid = join(',', $cats);
    if (!isset($_SESSION['logtick']['cats']) || $_SESSION['logtick']['cats']!=$catid) {
	$_SESSION['logtick']['cats'] = $catid;
	$after = 1;
    }
}

if ($after) utf8out(show_list($uid, $catid, $after));

include XOOPS_ROOT_PATH.'/header.php';

$xoopsOption['template_main'] = 'logtick_index.html';
set_logtick_breadcrumbs();

//$res = $xoopsDB->query("SELECT uid, uname FROM ".$xoopsDB->prefix('users').
//	  " WHERE uid IN (SELECT luid FROM ".TLOG." GROUP BY luid)");
$res = $xoopsDB->query("SELECT uid, uname FROM ".$xoopsDB->prefix('users').
		       " WHERE uid IN (".get_exists_ids(TLOG, 'luid').")");
$users=array();
if ($res && $xoopsDB->getRowsNum($res)) {
    if (isset($_SESSION['logtick']['uids']) && empty($uid)) $uid = $_SESSION['logtick']['uids'];
    $uids = split(',', $uid);
    while ($user=$xoopsDB->fetchArray($res)) {
	$user['uname'] = htmlspecialchars($user['uname']);
	$user['checked'] = in_array($user['uid'], $uids);
	$users[] = $user;
    }
}

$res = $xoopsDB->query("SELECT catid, cname FROM ".TCAT.
		       " WHERE catid IN (".get_exists_ids(TLOG, 'pcat').")");
$categ = array();
if ($res && $xoopsDB->getRowsNum($res)) {
    if (isset($_SESSION['logtick']['cats']) && empty($catid)) $catid = $_SESSION['logtick']['cats'];
    $cats = split(',', $catid);
    while ($cat=$xoopsDB->fetchArray($res)) {
	$cat['cname'] = htmlspecialchars($cat['cname']);
	$cat['checked'] = in_array($cat['catid'], $cats);
	$categ[] = $cat;
    }
}

// input form
$xoopsTpl->assign('mycategories', lt_get_categories());
$xoopsTpl->assign('timespans', lt_split_options($xoopsModuleConfig['timespans']));

$xoopsTpl->assign('users', $users);
$xoopsTpl->assign('categories', $categ);
$xoopsTpl->assign('interval', $xoopsModuleConfig['interval']);

$modurl = XOOPS_URL.'/modules/'.basename(dirname(__FILE__));
$xoopsTpl->assign('logresult', show_list($uid, $catid));
$xoopsTpl->assign("xoops_js", $xoopsTpl->get_template_vars('xoops_js')."\n//--></script><script type='text/javascript' src='$modurl/logtick.js'><!--");
$xoopsTpl->assign('now', time());

include XOOPS_ROOT_PATH.'/footer.php';

function get_exists_ids($table, $idname) {
    global $xoopsDB;
    $res = $xoopsDB->query("SELECT $idname FROM $table GROUP BY $idname");
    $ids = array();
    while(list($u) = $xoopsDB->fetchRow($res)) {
	$ids[] = $u;
    }
    return count($ids)?join(',', $ids):'NULL';
}
?>
