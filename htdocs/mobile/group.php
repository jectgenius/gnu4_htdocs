<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G4_MOBILE_PATH.'/_head.php');
?>

<!-- 메인화면 최신글 시작 -->
<?
//  최신글
$sql = " select bo_table, bo_subject from {$g4[board_table]} where gr_id = '{$gr_id}' and bo_list_level <= '{$member[mb_level]}' order by bo_table ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 스킨은 입력하지 않을 경우 관리자 > 환경설정의 최신글 스킨경로를 기본 스킨으로 합니다.

    // 사용방법
    // latest(스킨, 게시판아이디, 출력라인, 글자수);
    echo latest('basic', $row['bo_table'], 5, 70);
}
?>
<!-- 메인화면 최신글 끝 -->

<?
include_once(G4_MOBILE_PATH.'/_tail.php');
?>
