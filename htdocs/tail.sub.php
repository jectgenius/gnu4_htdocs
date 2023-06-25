<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<? if ($is_admin == 'super') { ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?=get_microtime()-$begin_time;?><br></div> --><? } ?>

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $td_name = $(".td_name");
    var count = $td_name.length;

    $td_name.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->

<script>
$('.sv').removeClass('sv_js_off'); //js 사용 가능한지를 사이드뷰에 알려주는 역할

$(function(){
    var hide_menu = false;
    var mouse_event = false;
    var oldX = oldY = 0;

    $(document).mousemove(function(e) {
        if(oldX == 0) {
            oldX = e.pageX;
            oldY = e.pageY;
        }

        if(oldX != e.pageX || oldY != e.pageY) {
            mouse_event = true;
        }
    });

    // 주메뉴
    var $gnb = $(".gnb_1depth > a");
    $gnb.mouseover(function() {
        if(mouse_event) {
            $(".gnb_1depth").removeClass("gnb_1depth_over gnb_1depth_over2 gnb_1depth_on");
            $(this).parent().addClass("gnb_1depth_over gnb_1depth_on");
            menu_rearrange($(this).parent());
            hide_menu = false;
        }
    });

    $gnb.mouseout(function() {
        hide_menu = true;
    });

    $(".gnb_1depth li").mouseover(function() {
        hide_menu = false;
    });

    $(".gnb_1depth li").mouseout(function() {
        hide_menu = true;
    });

    $gnb.focusin(function() {
        $(".gnb_1depth").removeClass("gnb_1depth_over gnb_1depth_over2 gnb_1depth_on");
        $(this).parent().addClass("gnb_1depth_over gnb_1depth_on");
        menu_rearrange($(this).parent());
        hide_menu = false;
    });

    $gnb.focusout(function() {
        hide_menu = true;
    });

    $(".gnb_1depth ul a").focusin(function() {
        $(".gnb_1depth").removeClass("gnb_1depth_over gnb_1depth_over2 gnb_1depth_on");
        var $gnb_li = $(this).closest(".gnb_1depth").addClass("gnb_1depth_over gnb_1depth_on");
        menu_rearrange($(this).closest(".gnb_1depth"));
        hide_menu = false;
    });

    $(".gnb_1depth ul a").focusout(function() {
        hide_menu = true;
    });

    $(document).click(function() {
        if(hide_menu) {
            $(".gnb_1depth").removeClass("gnb_1depth_over gnb_1depth_over2 gnb_1depth_on");
        }
    });

    $(document).focusin(function() {
        if(hide_menu) {
            $(".gnb_1depth").removeClass("gnb_1depth_over gnb_1depth_over2 gnb_1depth_on");
        }
    });

    // 텍스트 리사이즈 카운트 쿠키있으면 실행
    var resize_act;
    var text_resize_count = parseInt(get_cookie("ck_font_resize_count"));
    if(!isNaN(text_resize_count)) {
        if(text_resize_count > 0)
            resize_act = "increase";
        else if(text_resize_count < 0)
            resize_act = "decrease";

        if(Math.abs(text_resize_count) > 0)
            font_resize2("container", resize_act, Math.abs(text_resize_count));
    }
});

function menu_rearrange(el)
{
    var width = $("#gnb_ul").width();
    var left = w1 = w2 = 0;
    var idx = $(".gnb_1depth").index(el);

    for(i=0; i<=idx; i++) {
        w1 = $(".gnb_1depth:eq("+i+")").outerWidth();
        w2 = $(".gnb_2depth > a:eq("+i+")").outerWidth(true);

        if((left + w2) > width) {
            el.removeClass("gnb_1depth_over").addClass("gnb_1depth_over2");
        }

        left += w1;
    }
}
</script>

</body>
</html>
<?
$tmp_sql = " select count(*) as cnt from {$g4['login_table']} where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
$tmp_row = sql_fetch($tmp_sql);

//sql_query(" lock table $g4['login_table'] write ", false);
if ($tmp_row['cnt']) {
    $tmp_sql = " update {$g4['login_table']} set mb_id = '{$member['mb_id']}', lo_datetime = '".G4_TIME_YMDHIS."', lo_location = '$lo_location', lo_url = '$lo_url' where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    sql_query($tmp_sql, FALSE);
} else {
    $tmp_sql = " insert into {$g4['login_table']} ( lo_ip, mb_id, lo_datetime, lo_location, lo_url ) values ( '{$_SERVER['REMOTE_ADDR']}', '{$member['mb_id']}', '".G4_TIME_YMDHIS."', '$lo_location',  '$lo_url' ) ";
    sql_query($tmp_sql, FALSE);

    // 시간이 지난 접속은 삭제한다
    sql_query(" delete from {$g4['login_table']} where lo_datetime < '".date("Y-m-d H:i:s", G4_SERVER_TIME - (60 * $config['cf_login_minutes']))."' ");

    // 부담(overhead)이 있다면 테이블 최적화
    //$row = sql_fetch(" SHOW TABLE STATUS FROM `$mysql_db` LIKE '$g4['login_table']' ");
    //if ($row['Data_free'] > 0) sql_query(" OPTIMIZE TABLE $g4['login_table'] ");
}
?>