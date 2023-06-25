<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<link rel="stylesheet" href="<?=$outlogin_skin_url?>/style.css">

<!-- 로그인 후 외부로그인 시작 -->
<section id="ol_after" class="ol">
    <header id="ol_after_hd">
        <h2>나의 회원정보</h2>
        <strong><?=$nick?>님</strong>
        <? if ($is_admin == 'super' || $is_auth) { ?><a href="<?=G4_ADMIN_URL?>" class="btn_admin">관리자 모드</a><? } ?>
    </header>
    <ul id="ol_after_private">
        <li id="ol_after_memo">
            <a href="<?=G4_BBS_URL?>/memo.php" target="_blank" class="win_memo">
                <span class="sound_only">안 읽은 </span>쪽지
                <strong><?=$memo_not_read?></strong>
            </a>
        </li>
        <li id="ol_after_pt">
            <a href="<?=G4_BBS_URL?>/point.php" target="_blank" class="win_point">
                포인트
                <strong><?=$point?></strong>
            </a>
        </li>
        <li id="ol_after_scrap">
            <a href="<?=G4_BBS_URL?>/scrap.php" target="_blank" class="win_scrap">스크랩</a>
        </li>
    </ul>
    <footer id="ol_after_ft">
        <a href="<?=G4_BBS_URL?>/member_confirm.php?url=register_form.php" id="ol_after_info">정보수정</a>
        <a href="<?=G4_BBS_URL?>/logout.php" id="ol_after_logout">로그아웃</a>
    </footer>
</section>

<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?=G4_BBS_URL?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- 로그인 후 외부로그인 끝 -->
