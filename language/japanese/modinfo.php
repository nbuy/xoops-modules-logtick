<?php
// $Id: modinfo.php,v 1.2 2007/11/24 09:49:13 nobu Exp $
// Module Info

// The name of this module
define("_MI_LOGTICK_NAME","���礤��");

// A brief description of this module
define("_MI_LOGTICK_DESC","����äȤ�����ȵ�Ͽ��Ԥ�");

// Sub Menu
define("_MI_LOGTICK_LOGGER", "������");
define("_MI_LOGTICK_SUMMARY", "������");
define("_MI_LOGTICK_CATEGORY", "���ƥ���");

// Admin Menu
define("_MI_LOGTICK_ADMIN", "���礤������");
define("_MI_LOGTICK_HELP", "logtick�ˤĤ���");

// A brief template of this module
define("_MI_LOGTICK_RESULT_TPL", "����ɽ���ơ��֥�");
define("_MI_LOGTICK_INDEX_TPL", "���礤��");
define("_MI_LOGTICK_CATEGORY_TPL", "���ƥ������");
define("_MI_LOGTICK_LOGGER_TPL", "���Ѽԥ��ե�����");
define("_MI_LOGTICK_EDITLOG_TPL", "��Ͽ���Ƥ��Խ��ե�����");
define("_MI_LOGTICK_SUMMARY_TPL", "������");

// A brief configration of this module

// Configs
define("_MI_LOGTICK_TIMESPANS","��Ȼ��������");
define("_MI_LOGTICK_TIMESPANS_DESC","'<tt>��٥�=����ñ��</tt>' �򥫥�ޤʤ�Ӥǻ��ꤹ��");
define("_MI_LOGTICK_TIMESPANS_DEF","�ʤ�=0,30ʬ=30m,1����=1h,2����=2h,3����=3h,4����=4h,5����=5h,6����=6h,7����=7h,1��=8h,2��=16h,3��=24h,4��=32h,1��=40h");

define("_MI_LOGTICK_TIMEFORMAT_DEF","1d=h:i,14d=m-d h:i,0=Y-m-d h:i");
define("_MI_LOGTICK_TIMEFORMAT","����ɽ������");
define("_MI_LOGTICK_TIMEFORMAT_DESC","PHP date ������'<tt>�в����=date��</tt>' �Υ���ޤʤ�Ӥǻ��ꤹ�롣<div>��: <tt>"._MI_LOGTICK_TIMEFORMAT_DEF."</tt></div>");

define("_MI_LOGTICK_LOCALCSS","�����������");
define("_MI_LOGTICK_LOCALCSS_DESC","ɽ���ѤΥ����������");
define("_MI_LOGTICK_LOCALCSS_DEF","tr.edit td { background-color: #ccf; }
tr.store td, tr.new td { background-color: #fcc;  font-weight: bold; }");

define("_MI_LOGTICK_MAXLIST","����ɽ���κ����");
define("_MI_LOGTICK_MAXLIST_DESC","1�ڡ�����ɽ��������ο�����ꤹ��");

define("_MI_LOGTICK_NEWENTRY","����ɽ������");
define("_MI_LOGTICK_NEWENTRY_DESC","����°������ꤹ������ϰϤ��ÿ��ǻ��ꤹ�� (0: ɽ�����ʤ�)");

define("_MI_LOGTICK_BOUND","��������");
define("_MI_LOGTICK_BOUND_DESC","�����Ѥζ������֤���ӷ�������ǥե����ɽ���ڤ��ؤ�������ꤹ�롣��: \"05:00,5,10\" �Ǹ���5�������������Ȥ��ư��� 5�����麣��Ȥ��ư�����");
define("_MI_LOGTICK_BOUND_DEF","05:00,1,10");

define("_MI_LOGTICK_INTERVAL","��ư�����ֳ�");
define("_MI_LOGTICK_INTERVAL_DESC","�ߤ�ʤΥ�ɽ���μ�ư��������ݤ��Ԥ����֤��ÿ��ǻ��ꤹ�� (0: �������ʤ�)");

// A brief blocks of this module
define("_MI_LOGTICK_BLOCK_MINIFORM","����Ͽ�ե�����");
define("_MI_LOGTICK_BLOCK_LOGS","��ɽ��");

/*
// Notifications
define("_MI_LOGTICK_GLOBAL_NOTIFY","���ե�����");
define("_MI_LOGTICK_FORM_NOTIFY","���̥ե�����");
define("_MI_LOGTICK_MESSAGE_NOTIFY","������礻");

define("_MI_LOGTICK_NEWPOST_NOTIFY","��礻������ޤ���");
define("_MI_LOGTICK_NEWPOST_NOTIFY_CAP","����礻�����Τ���");
define("_MI_LOGTICK_NEWPOST_SUBJECT","��礻����������ޤ���");

define("_MI_LOGTICK_STATUS_NOTIFY","���֤��ѹ�");
define("_MI_LOGTICK_STATUS_NOTIFY_CAP","�������ѹ����줿�����Τ���");
define("_MI_LOGTICK_STATUS_SUBJECT","�����ѹ�:[{X_MODULE}]{FORM_NAME}");
*/

// for altsys 
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','�֥�å�/������������');
    define('_MD_A_MYMENU_MYPREFERENCES','��������');
}
?>