<?php
// $Id: xoops_version.php,v 1.2 2007/11/24 09:49:13 nobu Exp $
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$modversion = array('name' => _MI_LOGTICK_NAME,
		    'version' => 0.1,
		    'description' => _MI_LOGTICK_DESC,
		    'credits' => "Nobuhiro Yasutomi",
		    'author' => "Nobuhiro Yasutomi",
		    'help' => "help.html",
		    'license' => "GPL see LICENSE",
		    'official' => 0,
		    'image' => "logtick_slogo.png",
		    'dirname' => basename(dirname(__FILE__)));

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
//$modversion['sqlfile']['postgresql'] = "sql/pgsql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][] = "logtick_cat";
$modversion['tables'][] = "logtick_log";
$modversion['tables'][] = "logtick_usercat";

// OnUpdate - upgrade DATABASE 
//$modversion['onUpdate'] = "onupdate.php";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;
global $xoopsUser;
if (is_object($xoopsUser)) {
    $modversion['sub'][]=array('name'=>_MI_LOGTICK_LOGGER,
			       'url'=>"logger.php");
    $modversion['sub'][]=array('name'=>_MI_LOGTICK_CATEGORY,
			       'url'=>"category.php");
}
$modversion['sub'][]=array('name'=>_MI_LOGTICK_SUMMARY,
			   'url'=>"summary.php");
// Templates
$modversion['templates'][1] =
    array('file' => 'logtick_result.html',
	  'description' => _MI_LOGTICK_RESULT_TPL);

$modversion['templates'][] =
    array('file' => 'logtick_index.html',
	  'description' => _MI_LOGTICK_INDEX_TPL);

$modversion['templates'][] =
    array('file' => 'logtick_category.html',
	  'description' => _MI_LOGTICK_CATEGORY_TPL);

$modversion['templates'][] =
    array('file' => 'logtick_logger.html',
	  'description' => _MI_LOGTICK_LOGGER_TPL);

$modversion['templates'][] =
    array('file' => 'logtick_editlog.html',
	  'description' => _MI_LOGTICK_EDITLOG_TPL);

$modversion['templates'][] =
    array('file' => 'logtick_summary.html',
	  'description' => _MI_LOGTICK_SUMMARY_TPL);

// Blocks
$modversion['blocks'][1]=
    array('file' => 'logtick_block_miniform.php',
	  'name' => _MI_LOGTICK_BLOCK_MINIFORM,
	  'description' => '',
	  'show_func' => "b_logtick_miniform_show",
	  'edit_func' => "b_logtick_miniform_edit",
	  'template' => 'logtick_block_miniform.html');

$modversion['blocks'][]=
    array('file' => 'logtick_block_logs.php',
	  'name' => _MI_LOGTICK_BLOCK_LOGS,
	  'description' => '',
	  'clone' => true,
	  'show_func' => "b_logtick_logs_show",
	  'edit_func' => "b_logtick_logs_edit",
	  'template' => 'logtick_block_logs.html',
	  'options'=>'|5');

// Config

$modversion['hasconfig'] = 1;

$modversion['config'][]=array(
    'name' => 'timespans',
    'title' => '_MI_LOGTICK_TIMESPANS',
    'description' => '_MI_LOGTICK_TIMESPANS_DESC',
    'formtype' => 'text',
    'valuetype' => 'string',
    'default' => _MI_LOGTICK_TIMESPANS_DEF);
$modversion['config'][]=array(
    'name' => 'timeformat',
    'title' => '_MI_LOGTICK_TIMEFORMAT',
    'description' => '_MI_LOGTICK_TIMEFORMAT_DESC',
    'formtype' => 'text',
    'valuetype' => 'string',
    'default' => _MI_LOGTICK_TIMEFORMAT_DEF);
$modversion['config'][]=array(
    'name' => 'localcss',
    'title' => '_MI_LOGTICK_LOCALCSS',
    'description' => '_MI_LOGTICK_LOCALCSS_DESC',
    'formtype' => 'textarea',
    'valuetype' => 'string',
    'default' => _MI_LOGTICK_LOCALCSS_DEF);

$modversion['config'][]=array(
    'name' => 'maxlist',
    'title' => '_MI_LOGTICK_MAXLIST',
    'description' => '_MI_LOGTICK_MAXLIST_DESC',
    'formtype' => 'text',
    'valuetype' => 'int',
    'default' => 100);

$modversion['config'][]=array(
    'name' => 'newentry',
    'title' => '_MI_LOGTICK_NEWENTRY',
    'description' => '_MI_LOGTICK_NEWENTRY_DESC',
    'formtype' => 'text',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][]=array(
    'name' => 'bound',
    'title' => '_MI_LOGTICK_BOUND',
    'description' => '_MI_LOGTICK_BOUND_DESC',
    'formtype' => 'text',
    'valuetype' => 'strings',
    'default' => _MI_LOGTICK_BOUND_DEF);

$modversion['config'][]=array(
    'name' => 'interval',
    'title' => '_MI_LOGTICK_INTERVAL',
    'description' => '_MI_LOGTICK_INTERVAL_DESC',
    'formtype' => 'text',
    'valuetype' => 'int',
    'default' => 60);

?>
