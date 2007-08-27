<?php
# Logtick main page
# $Id: editlog.php,v 1.1 2007/08/27 02:42:20 nobu Exp $

include '../../mainfile.php';
include 'functions.php';

if (!is_object($xoopsUser)) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}

$myts =& MyTextSanitizer::getInstance();

$logid = intval($_GET['logid']);

if (isset($_POST['store'])) {
    $logid = intval($_POST['logid']);
    $values = array();
    $values[] = 'comment='.$xoopsDB->quoteString(trim($myts->stripSlashesGPC($_POST['comment'])));
    $values[] = 'pcat='.intval($_POST['catid']);
    $values[] = 'mtime='.userTimeToServerTime(strtotime($_POST['mdate']));
    $values[] = 'lspan='.span2sec($myts->stripSlashesGPC($_POST['span']));
    $res = $xoopsDB->query("UPDATE ".TLOG." SET ".join(',', $values)." WHERE logid=".$logid);
    echo $xoopsDB->error();
    redirect_header('logger.php', 1, _MD_LOGTICK_STORED);
    exit;
} else if (isset($_POST['delete'])) {
    $logid = intval($_POST['logid']);
    $res = $xoopsDB->query("DELETE FROM ".TLOG." WHERE logid=$logid");
    redirect_header('logger.php', 1, _MD_LOGTICK_DELETED);
    exit;
}

include XOOPS_ROOT_PATH.'/header.php';

$xoopsOption['template_main'] = 'logtick_editlog.html';

set_logtick_breadcrumbs(array(_MD_LOGTICK_EDITLOG=>'logger.php'));

$res = $xoopsDB->query("SELECT * FROM ".TLOG." WHERE logid=$logid");
$data = $xoopsDB->fetchArray($res);

$ptime = new pastTime();
$data['comment'] = htmlspecialchars($data['comment']);
$data['lspan'] = htmlspecialchars($data['lspan']);
$spans = lt_split_options($xoopsModuleConfig['timespans']);
$span = $data['lspan'];
foreach (array_keys($spans) as $v) {
    if (span2sec($v)==$span) {
	$data['span'] = $v;
	break;
    }
}
if (!isset($data['span'])) {
    $spans[$lspan] = $ptime->getSpan($lspan);
    $data['span'] = $span;
}
$data['ldate'] = formatTimestamp($data['ltime']);
$data['mdate'] = formatTimestamp($data['mtime']);
$xoopsTpl->assign('log', $data);
$xoopsTpl->assign('categories', lt_get_categories());
$xoopsTpl->assign('timespans', $spans);

include XOOPS_ROOT_PATH.'/footer.php';
?>
