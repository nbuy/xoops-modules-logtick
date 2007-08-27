<?php
// $Id: menu.php,v 1.1 2007/08/27 02:42:20 nobu Exp $

$adminmenu[]=array('title' => _MI_LOGTICK_ADMIN,
		    'link' => "admin/index.php");
$adminmenu[]=array('title' => _MI_LOGTICK_HELP,
		    'link' => "admin/help.php");

$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYTPLSADMIN,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin');
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYBLOCKSADMIN,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin');
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYPREFERENCES,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences');
?>