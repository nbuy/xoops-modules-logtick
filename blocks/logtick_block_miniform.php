<?php
# $Id: logtick_block_miniform.php,v 1.1 2007/08/27 02:42:20 nobu Exp $

function b_logtick_miniform_show($options)
{
    global $xoopsDB, $xoopsUser, $xoopsTpl;
    if (!is_object($xoopsUser)) return false;
    $uid = $xoopsUser->getVar('uid');
    $tcat = $xoopsDB->prefix('logtick_cat');
    $tuc = $xoopsDB->prefix('logtick_usercat');
    $ord = "ORDER BY weight, cname";

    $res = $xoopsDB->query("SELECT catid, cname FROM $tcat, $tuc WHERE uidref=$uid AND catref=catid $ord");
    $cat = array();
    if ($res && $xoopsDB->getRowsNum($res)) {
	while (list($id, $name) = $xoopsDB->fetchRow($res)) {
	    $cat[$id] = $name;
	}
    }
    $url= XOOPS_URL."/modules/".basename(dirname(dirname(__FILE__)));
    if (!empty($xoopsTpl)) {
	$js = $xoopsTpl->get_template_vars('xoops_js');
	if (!preg_match('/\/logtic.js/', $js)) {
	    $js .= "\n//--></script><script type='text/javascript' src='$url/logtick.js'><!--";
	    $xoopsTpl->assign('xoops_js', $js);
	}
    }
    return array("categories"=>$cat, 'module_url'=>$url, 'options'=>$options);
}

function b_logtick_miniform_edit($options)
{
}
?>
