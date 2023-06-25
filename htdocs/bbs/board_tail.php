<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 게시판 관리의 하단 내용
if ($board['bo_content_tail']) {
    echo stripslashes($board['bo_content_tail']); 
}

// 게시판 관리의 하단 이미지 경로
if ($board['bo_image_tail']) {
    echo '<img src="'.G4_DATA_PATH.'/file/'.$bo_table.'/'.$board['bo_image_tail'].'">';
}

// 게시판 관리의 하단 파일 경로
if (G4_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    include_once('./_tail.php');
} else if ($board['bo_include_tail']) {
    @include ($board['bo_include_tail']); 
}
?>