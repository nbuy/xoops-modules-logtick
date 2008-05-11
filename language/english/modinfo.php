<?php
// $Id: modinfo.php,v 1.1 2008/05/11 05:19:20 nobu Exp $
// Module Info

// The name of this module
define("_MI_LOGTICK_NAME","Logtick");

// A brief description of this module
define("_MI_LOGTICK_DESC","Logging short comment with working time");

// Sub Menu
define("_MI_LOGTICK_SUMMARY", "Summary");
define("_MI_LOGTICK_CATEGORY", "Category");

// Admin Menu
define("_MI_LOGTICK_ADMIN", "Logtick Admin");
define("_MI_LOGTICK_HELP", "about Logtick");

// A brief template of this module
define("_MI_LOGTICK_RESULT_TPL", "Show log table");
define("_MI_LOGTICK_INDEX_TPL", "Logtick Main view");
define("_MI_LOGTICK_CATEGORY_TPL", "Category management");
define("_MI_LOGTICK_EDITLOG_TPL", "Edit registerd info");
define("_MI_LOGTICK_SUMMARY_TPL", "Log summary");

// A brief configration of this module

// Configs
define("_MI_LOGTICK_TIMESPANS","Time span list");
define("_MI_LOGTICK_TIMESPANS_DESC","'<tt>Label=time-unit</tt>' seperation with comma");
define("_MI_LOGTICK_TIMESPANS_DEF","None=0,30min,1hour,2hours,3hours,4hours,5hours,6hours,7hours,1day=8h,2days=16h,3days=24h,4days=32h,1week=40h");

define("_MI_LOGTICK_TIMEFORMAT","Display Time formst");
define("_MI_LOGTICK_TIMEFORMAT_DEF","1d=H:i,14d=m-d H:i,0=Y-m-d H:i");
define("_MI_LOGTICK_TIMEFORMAT_DESC","Present display time format in PHP date style, '<tt>Past-time=date-format</tt>' seperation with comma.<div>Example: <tt>"._MI_LOGTICK_TIMEFORMAT_DEF."</tt></div>");

define("_MI_LOGTICK_LOCALCSS","Local Style");
define("_MI_LOGTICK_LOCALCSS_DESC","Module local style(CSS) setting");
define("_MI_LOGTICK_LOCALCSS_DEF","tr.edit td { background-color: #ccf; }
tr.store td, tr.new td { background-color: #fcc;  font-weight: bold; }");

define("_MI_LOGTICK_MAXLIST","Rows in a page");
define("_MI_LOGTICK_MAXLIST_DESC","Display log information lines in a page");

define("_MI_LOGTICK_NEWENTRY","Upcomming display time");
define("_MI_LOGTICK_NEWENTRY_DESC","Show upcomming comment display with 'new' style in seconds (0: not adding)");

define("_MI_LOGTICK_BOUND","Boundary time");
define("_MI_LOGTICK_BOUND_DESC","Summary bounding time in a day, this month start date, display switch date in a month. Example: \"05:00,5,10\" a day start 5 oclock, mean before 5 oclock is previus day. This month start 5th day, 4th day include previus month, until 10th day display previus month in a default");
define("_MI_LOGTICK_BOUND_DEF","05:00,1,10");

define("_MI_LOGTICK_INTERVAL","Auto reload interval");
define("_MI_LOGTICK_INTERVAL_DESC","Reload log display interval seconds (0: no update)");

// A brief blocks of this module
define("_MI_LOGTICK_BLOCK_MINIFORM","Logtick form");
define("_MI_LOGTICK_BLOCK_LOGS","Display log");

// for altsys
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Templates');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Blocks/Permissions');
    define('_MD_A_MYMENU_MYPREFERENCES','Preferences');
}
?>