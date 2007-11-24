<?php
# Logtick summary page
# $Id: summary.php,v 1.2 2007/11/24 09:49:13 nobu Exp $

include '../../mainfile.php';
include 'functions.php';

$myts =& MyTextSanitizer::getInstance();

if (isset($_GET['uid'])) {
    $uid = $myts->stripSlashesGPC($_GET['uid']);
} elseif (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
} else $uid = '';
list($year, $month, $day) = split('-', formatTimestamp(time(), 'Y-m-d'));
list($bday, $bmon, $bdef) = split(',', $xoopsModuleConfig['bound']);
list($hour, $min) = explode(':', $bday);

$years = array();
for ($i=0; $i<10; $i++) {
    $y = $year-$i;
    $years[$y] = date(_MD_DISP_YEAR, mktime(0,0,0, 1,1,$y));
}
$months = array();
for ($m=1; $m<=12; $m++) {
    $months[$m] = date(_MD_DISP_MONTH, mktime(0,0,0, $m,1));
}
$days = array();
for ($d=1; $d<=31; $d++) {
    $days[$d] = date(_MD_DISP_DAY, mktime(0,0,0, 1,$d));
}

if (isset($_GET['y'])) $year = intval($_GET['y']);
if (isset($_GET['m'])) $month = intval($_GET['m']);
if (isset($_GET['d'])) $day = intval($_GET['d']);
if (!isset($_GET['m']) && !isset($_GET['d']) && $day<$bdef) $month--;
if (!isset($_GET['d']) && time()<mktime($hour, $min)) $day--;

include XOOPS_ROOT_PATH.'/header.php';

$xoopsOption['template_main'] = 'logtick_summary.html';

if (preg_match('/^\d+$/', $uid)) {
    $title =  sprintf(_MD_LOGTICK_SUMMARY, xoops_getLinkedUnameFromId($uid));
} else $title = _MD_LOGTICK_SUM;
set_logtick_breadcrumbs(array(strip_tags($title)=>'summary.php'));

$xoopsTpl->assign('title', $title);

$sums = array();
get_summary($sums, $uid);
$labs = array(_MD_SUM_TOTAL);
if (is_numeric($uid)) $cond = "luid=$uid";
elseif (preg_match('/^\d+(,\d+)+$/', $uid))  $cond = "luid IN ($uid)";
else $cond = "1";

$res = $xoopsDB->query("SELECT min(mtime),max(mtime),1 FROM ".TLOG." WHERE $cond GROUP BY 3");
list($stime, $ltime) = $xoopsDB->fetchRow($res);
$legends = array();
$legends[_MD_SUM_TOTAL] = legend_range($stime, $ltime);

$smonth = mktime($hour, $min, 0, $month, $bmon, $year);
$lmonth = mktime($hour, $min, 0, $month+1, $bmon, $year);
get_summary($sums, $uid, $smonth, $lmonth);
$labs[] = $lab = formatTimestamp($smonth,_MD_SUM_MONTH);
$legends[$lab] = legend_range($smonth, $lmonth);

$sday = mktime($hour, $min, 0, $month, $day, $year);
$lday = mktime($hour, $min, 0, $month, $day+1, $year);
get_summary($sums, $uid, $sday, $lday);
$labs[] = $lab = formatTimestamp($sday,_MD_SUM_DAY);
$legends[$lab] = legend_range($sday, $lday);
$labs = array_reverse($labs, true);

$xoopsTpl->assign('sums', $sums);
$xoopsTpl->assign('labels', $labs);
$xoopsTpl->assign('legends', $legends);

$xoopsTpl->assign(array('years'=>$years, 'months'=>$months,'days'=>$days,
			'year'=>$year, 'month'=>$month, 'day'=>$day,
			'timestamp'=>formatTimestamp(time(), "m")));

include XOOPS_ROOT_PATH.'/footer.php';

function get_summary(&$ret, $uid, $start=0, $last=0) {
    global $xoopsDB, $myts, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    if (preg_match('/^\d+(,\d+)+$/', $uid)) { // show multiple user log
	$cond = "luid IN ($uid)";
	$disp = true;
    } elseif ($uid) {		// show a user log
	$cond = "luid=$uid";
	$disp = false;
    } else {			// show any user log
	$cond = "1";
	$disp = true;
    }
    if ($start) $cond .= " AND mtime>=$start";
    if ($last) $cond .= " AND mtime<$last";
    $res = $xoopsDB->query("SELECT pcat,cname, sum(lspan) spansum FROM ".TLOG." LEFT JOIN ".TCAT." ON catid=pcat WHERE $cond GROUP BY cname");
    $nmax = count($ret)?max(array_map('count', $ret)):0;
    if ($xoopsDB->getRowsNum($res)) {
	$fmts = array(_MD_FMT_DAY=>28800,
		      _MD_FMT_HOUR=>3600,
		      _MD_FMT_MIN=>60);
	while ($data = $xoopsDB->fetchArray($res)) {
	    $data['cname'] = htmlspecialchars($data['cname']);
	    $sec = $data['spansum'];
	    $span = "";
	    foreach ($fmts as $fmt=>$sval) {
		$a = intval($sec/$sval);
		$sec = $sec % $sval;
		if ($a) $span .= sprintf($fmt, $a);
	    }
	    if (empty($span)) continue;
	    $cname = htmlspecialchars($data['cname']);
	    $ret[$cname][$nmax] = $span;
	}
    }
    return $ret;
}

function legend_range($s, $e) {
    return sprintf(_MD_RANGE_DATE, formatTimestamp($s, 'm'), formatTimestamp($e-1, 'm'));
}
?>
