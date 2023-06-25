<?
if (!defined('_GNUBOARD_')) exit;

include_once(G4_LIB_PATH.'/visit.lib.php');

if (empty($fr_date)) $fr_date = G4_TIME_YMD;
if (empty($to_date)) $to_date = G4_TIME_YMD;

$qstr = "fr_date=".$fr_date."&amp;to_date=".$to_date;
?>

<ul class="anchor">
    <li><a href="./visit_list.php">접속자</a></li>
    <li><a href="./visit_domain.php">도메인</a></li>
    <li><a href="./visit_browser.php">브라우저</a></li>
    <li><a href="./visit_os.php">운영체제</a></li>
    <li><a href="./visit_hour.php">시간</a></li>
    <li><a href="./visit_week.php">요일</a></li>
    <li><a href="./visit_date.php">일</a></li>
    <li><a href="./visit_month.php">월</a></li>
    <li><a href="./visit_year.php">년</a></li>
</ul>

<form name="fvisit" id="fvisit" method="get">
<fieldset>
    <legend>기간별 접속자집계 검색</legend>
    <input type="text" name="fr_date" value="<?=$fr_date?>" id="fr_date" class="frm_input" size="11" maxlength="10"> 부터
    <input type="text" name="to_date" value="<?=$to_date?>" id="to_date"class="frm_input" size="11" maxlength="10"> 까지
    <input type="submit" value="검색" class="btn_submit">
</fieldset>
</form>

<script>
function fvisit_submit(act)
{
    var f = document.fvisit;
    f.action = act;
    f.submit();
}
</script>
