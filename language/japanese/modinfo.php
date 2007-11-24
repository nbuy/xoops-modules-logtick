<?php
// $Id: modinfo.php,v 1.2 2007/11/24 09:49:13 nobu Exp $
// Module Info

// The name of this module
define("_MI_LOGTICK_NAME","ちょいログ");

// A brief description of this module
define("_MI_LOGTICK_DESC","ちょっとした作業記録を行う");

// Sub Menu
define("_MI_LOGTICK_LOGGER", "ログ入力");
define("_MI_LOGTICK_SUMMARY", "ログ集計");
define("_MI_LOGTICK_CATEGORY", "カテゴリ");

// Admin Menu
define("_MI_LOGTICK_ADMIN", "ちょいログ管理");
define("_MI_LOGTICK_HELP", "logtickについて");

// A brief template of this module
define("_MI_LOGTICK_RESULT_TPL", "ログの表示テーブル");
define("_MI_LOGTICK_INDEX_TPL", "ちょいログ");
define("_MI_LOGTICK_CATEGORY_TPL", "カテゴリ管理");
define("_MI_LOGTICK_LOGGER_TPL", "利用者ログフォーム");
define("_MI_LOGTICK_EDITLOG_TPL", "登録内容の編集フォーム");
define("_MI_LOGTICK_SUMMARY_TPL", "ログ集計");

// A brief configration of this module

// Configs
define("_MI_LOGTICK_TIMESPANS","作業時間選択肢");
define("_MI_LOGTICK_TIMESPANS_DESC","'<tt>ラベル=時間単位</tt>' をカンマならびで指定する");
define("_MI_LOGTICK_TIMESPANS_DEF","なし=0,30分=30m,1時間=1h,2時間=2h,3時間=3h,4時間=4h,5時間=5h,6時間=6h,7時間=7h,1日=8h,2日=16h,3日=24h,4日=32h,1週=40h");

define("_MI_LOGTICK_TIMEFORMAT_DEF","1d=h:i,14d=m-d h:i,0=Y-m-d h:i");
define("_MI_LOGTICK_TIMEFORMAT","時間表現形式");
define("_MI_LOGTICK_TIMEFORMAT_DESC","PHP date 形式で'<tt>経過時間=date書式</tt>' のカンマならびで指定する。<div>例: <tt>"._MI_LOGTICK_TIMEFORMAT_DEF."</tt></div>");

define("_MI_LOGTICK_LOCALCSS","スタイル指定");
define("_MI_LOGTICK_LOCALCSS_DESC","表示用のスタイル指定");
define("_MI_LOGTICK_LOCALCSS_DEF","tr.edit td { background-color: #ccf; }
tr.store td, tr.new td { background-color: #fcc;  font-weight: bold; }");

define("_MI_LOGTICK_MAXLIST","一覧表示の最大数");
define("_MI_LOGTICK_MAXLIST_DESC","1ページに表示するログの数を指定する");

define("_MI_LOGTICK_NEWENTRY","新着表示時間");
define("_MI_LOGTICK_NEWENTRY_DESC","新着属性を指定する時間範囲を秒数で指定する (0: 表示しない)");

define("_MI_LOGTICK_BOUND","境界時間");
define("_MI_LOGTICK_BOUND_DESC","集計用の境界時間および月初日、デフォルト表示切り替え日を指定する。例: \"05:00,5,10\" で午前5時以前は前日として扱い 5日から今月として扱う。");
define("_MI_LOGTICK_BOUND_DEF","05:00,1,10");

define("_MI_LOGTICK_INTERVAL","自動更新間隔");
define("_MI_LOGTICK_INTERVAL_DESC","みんなのログ表示の自動更新する際の待ち時間を秒数で指定する (0: 更新しない)");

// A brief blocks of this module
define("_MI_LOGTICK_BLOCK_MINIFORM","ログ記録フォーム");
define("_MI_LOGTICK_BLOCK_LOGS","ログ表示");

/*
// Notifications
define("_MI_LOGTICK_GLOBAL_NOTIFY","全フォーム");
define("_MI_LOGTICK_FORM_NOTIFY","個別フォーム");
define("_MI_LOGTICK_MESSAGE_NOTIFY","個別問合せ");

define("_MI_LOGTICK_NEWPOST_NOTIFY","問合せがありました");
define("_MI_LOGTICK_NEWPOST_NOTIFY_CAP","お問合せを通知する");
define("_MI_LOGTICK_NEWPOST_SUBJECT","問合せが送信されました");

define("_MI_LOGTICK_STATUS_NOTIFY","状態の変更");
define("_MI_LOGTICK_STATUS_NOTIFY_CAP","状況が変更されたら通知する");
define("_MI_LOGTICK_STATUS_SUBJECT","状態変更:[{X_MODULE}]{FORM_NAME}");
*/

// for altsys 
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','テンプレート管理');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','ブロック/アクセス管理');
    define('_MD_A_MYMENU_MYPREFERENCES','一般設定');
}
?>