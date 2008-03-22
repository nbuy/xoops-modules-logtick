<?php
# Logtick main page
# $Id: category.php,v 1.2 2008/03/22 05:34:39 nobu Exp $

include '../../mainfile.php';
include 'functions.php';

$myts =& MyTextSanitizer::getInstance();

if (!is_object($xoopsUser)) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}
$uid = $xoopsUser->getVar('uid');
$catid = isset($_GET['catid'])?intval($_GET['catid']):0;
$editid = array();
if (isset($_POST['cname'])) {
    $catid = intval($_POST['catid']);
    $cname = trim($myts->stripSlashesGPC($_POST['cname']));
    $qname = $xoopsDB->quoteString($cname);
    $qdesc = $xoopsDB->quoteString($myts->stripSlashesGPC($_POST['description']));
    if (empty($cname)) {
	redirect_header('index.php', 1, _MD_CATEGORY_NOTDEFINED);
    } elseif ($catid) {
	$xoopsDB->query("UPDATE ".TCAT." SET cname=$qname, description=$qdesc WHERE catid=$catid AND cuid=$uid");
    } else {
	$xoopsDB->query("INSERT INTO ".TCAT."(cuid,cname, description) VALUES ($uid, $qname, $qdesc)");
	$catid = $xoopsDB->getInsertID($res);
	$xoopsDB->query("INSERT INTO ".TUC."(uidref,catref) VALUES ($uid, $catid)");
    }
    $editid[$catid] = " store";
    $catid = 0;
}
elseif (isset($_POST['adds'])) {
    $adds = array_map('intval', $_POST['adds']);
    $values = array();
    foreach ($adds as $id) {
	$values[] = "($uid, $id)";
	$editid[$id] = " store";
    }
    $xoopsDB->query("DELETE FROM ".TUC." WHERE uidref=$uid AND catref IN (".join(',', $adds).")");
    $xoopsDB->query("INSERT INTO ".TUC."(uidref,catref) VALUES".join(',', $values));
}
elseif (isset($_POST['dels'])) {
    $dels = array_map('intval', $_POST['dels']);
    var_dump($dels);
    $xoopsDB->query("DELETE FROM ".TUC." WHERE uidref=$uid AND catref IN (".join(',', $dels).")");
    echo $xoopsDB->error();
}

if ($catid) {
    $res = $xoopsDB->query("SELECT * FROM ".TCAT." WHERE catid=$catid AND cuid=$uid");
    if (!$res || $xoopsDB->getRowsNum($res)==0) { // invalid category ID
	redirect_header('category.php', 3, _NOPERM);
	exit;
    }
    $cat = $xoopsDB->fetchArray($res);
    $editid[$catid] = " edit";
} else {
    $cat = array('catid'=>0, 'cname'=>'', 'description'=>'');
}

include XOOPS_ROOT_PATH.'/header.php';

$xoopsOption['template_main'] = 'logtick_category.html';

set_logtick_breadcrumbs(array(_MD_CATEGORY_EDIT=>'category.php'));

$xoopsTpl->assign('edit', $cat);
$xoopsTpl->assign('uid', $uid);
$cats = lt_get_categories($uid, 1);
foreach ($editid as $id => $mark) {
    if (isset($cats[$id])) $cats[$id]['class'] = $mark;
}
$xoopsTpl->assign('categories', $cats);

// not selected categories
$res = $xoopsDB->query("SELECT c.* FROM ".TCAT." c LEFT JOIN ".TUC." ON uidref=$uid AND catref=catid WHERE catref IS NULL ORDER BY cname");
$rests = array();
while ($data = $xoopsDB->fetchArray($res)) {
    $id = $data['catid'];
    $data['cname'] = htmlspecialchars($data['cname']);
    $rests[$id]=$data;
}
$xoopsTpl->assign('restcats', $rests);

include XOOPS_ROOT_PATH.'/footer.php';
?>
