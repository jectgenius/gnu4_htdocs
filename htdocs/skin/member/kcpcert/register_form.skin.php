<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<script src="<?=G4_JS_URL?>/jquery.register_form.js"></script>

<form name="fregisterform" id="fregisterform"action="<?=$register_action_url?>" onsubmit="return fregisterform_submit(this);" method="post"  enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="url" value="<?=$urlencode?>">
<input type="hidden" name="agree" value="<?=$agree?>">
<input type="hidden" name="agree2" value="<?=$agree2?>">
<? if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?=$member['mb_sex']?>"><? } ?>
<? if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G4_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 별명수정일이 지나지 않았다면 ?>
<input type="hidden" name="mb_nick_default" value="<?=$member['mb_nick']?>">
<input type="hidden" name="mb_nick" value="<?=$member['mb_nick']?>">
<? } ?>

<table class="frm_tbl">
<caption>사이트 이용정보 입력</caption>
<tr>
    <th scope="row"><label for="reg_mb_id">아이디<strong class="sound_only">필수</strong></label></th>
    <td>
        <input type="text" name="mb_id" value="<?=$member['mb_id']?>" id="reg_mb_id"<?=$required?> <?=$readonly?> class="frm_input minlength_3 <?=$required?> <?=$readonly?>" maxlength="20">
        <span id="msg_mb_id"></span>
        <span class="frm_info">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</span>
    </td>
</tr>
<tr>
    <th scope="row"><label for="reg_mb_password">패스워드<strong class="sound_only">필수</strong></label></th>
    <td><input type="password" name="mb_password" id="reg_mb_password" <?=$required?> class="frm_input minlength_3 <?=$required?>" maxlength="20"></td>
</tr>
<tr>
    <th scope="row"><label for="reg_mb_password_re">패스워드 확인<strong class="sound_only">필수</strong></label></th>
    <td><input type="password" name="mb_password_re" id="reg_mb_password_re" <?=$required?> class="frm_input minlength_3 <?=$required?>" maxlength="20"></td>
</tr>
</table>

<table class="frm_tbl">
<caption>개인정보 입력</caption>
<tr>
    <th scope="row"><label for="reg_mb_name">이름<strong class="sound_only">필수</strong></label></th>
    <td>
        <input name="mb_name" value="<?=$member['mb_name']?>" id="reg_mb_name" <?=$required?> <?=$readonly?> class="frm_input hangul nospace <?=$required?> <?=$readonly?>" size="10">
        <? if ($w=='') { echo "<span class=\"frm_info\">공백없이 한글만 입력하세요.</span>"; } ?>
    </td>
</tr>
<? if ($req_nick) { ?>
<tr>
    <th scope="row"><label for="reg_mb_nick">별명<strong class="sound_only">필수</strong></label></th>
    <td>
        <input type="hidden" name="mb_nick_default" value="<?=isset($member['mb_nick'])?$member['mb_nick']:'';?>">
        <input type="text" name="mb_nick" value="<?=isset($member['mb_nick'])?$member['mb_nick']:'';?>" id="reg_mb_nick" required class="frm_input required nospace" size="10" maxlength="20" >
        <span id="msg_mb_nick"></span>
        <span class="frm_info">
            공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)<br>
            별명을 바꾸시면 앞으로 <?=(int)$config['cf_nick_modify']?>일 이내에는 변경 할 수 없습니다.
        </span>
    </td>
</tr>
<? } ?>

<tr>
    <th scope="row"><label for="reg_mb_email">E-mail<? if ($config['cf_use_email_certify']) {?><strong class="sound_only">필수</strong><?}?></label></th>
    <td>
        <input type="hidden" name="old_email" value="<?=$member['mb_email']?>">
        <input type="text" name="mb_email" value='<?=isset($member['mb_email'])?$member['mb_email']:'';?>' <?=$config['cf_use_email_certify']?"required":"";?> id="reg_mb_email" class="frm_input email <?=$config['cf_use_email_certify']?"required":"";?>" size="50" maxlength="100">
        <? if ($config['cf_use_email_certify']) { ?>
        <span class="frm_info">
            <? if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; } ?>
            <? if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; } ?>
        </span>
        <? } ?>
    </td>
</tr>

<? if ($config['cf_use_homepage']) { ?>
<tr>
    <th scope="row"><label for="reg_mb_homepage">홈페이지<? if ($config['cf_req_homepage']){?><strong class="sound_only">필수</strong><?}?></label></th>
    <td><input type="text" name="mb_homepage" value="<?=$member['mb_homepage']?>" id="reg_mb_homepage" class="frm_input <?=$config['cf_req_homepage']?"required":"";?>" size="50" maxlength="255"<?=$config['cf_req_homepage']?"required":"";?>></td>
</tr>
<? } ?>

<? if ($config['cf_use_tel']) { ?>
<tr>
    <th scope="row"><label for="reg_mb_tel">전화번호<? if ($config['cf_req_tel']) {?><strong class="sound_only">필수</strong><?}?></label></th>
    <td><input type="text" name="mb_tel" value="<?=$member['mb_tel']?>" id="reg_mb_tel" class="frm_input <?=$config['cf_req_tel']?"required":"";?>" maxlength="20" <?=$config['cf_req_tel']?"required":"";?>></td>
</tr>
<? } ?>

<tr>
    <th scope="row"><label for="reg_mb_hp">핸드폰번호<strong class="sound_only">필수</strong></label></th>
    <td>
        <input type="hidden" name="kcpcert_no" value="">
        <input type="hidden" name="kcpcert_time" value="<?=$member['mb_hp_certify']?>">
        <input type="hidden" name="old_mb_hp" value="<?=$member['mb_hp']?>">
        <input type="text" name="mb_hp" value="<?=$member['mb_hp']?>" id="reg_mb_hp" required class="frm_input required" maxlength="20">
        <button type="button" id="win_kcpcert" class="btn_frmline">휴대폰인증</button>
        <noscript>휴대폰인증을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>
    </td>
</tr>

<? if ($config['cf_use_addr']) {
    $zip_href = G4_BBS_URL.'/zip.php?frm_name=fregisterform&amp;frm_zip1=mb_zip1&amp;frm_zip2=mb_zip2&amp;frm_addr1=mb_addr1&amp;frm_addr2=mb_addr2';
?>
<tr>
    <th scope="row">
        주소
        <? if ($config['cf_req_addr']) {?><strong class="sound_only">필수</strong><? } ?>
    </th>
    <td>
        <input type="text" name="mb_zip1"value="<?=$member['mb_zip1']?>" id="reg_mb_zip1" title="우편번호 앞자리" class="frm_input <?=$config['cf_req_addr']?"required":"";?>" size="2" maxlength="3" <?=$config['cf_req_addr']?"required":"";?> >
         -
        <input type="text" name="mb_zip2" value="<?=$member['mb_zip2']?>" id="reg_mb_zip2" title="우편번호 뒷자리" class="frm_input <?=$config['cf_req_addr']?"required":"";?>" size="2" maxlength="3" <?=$config['cf_req_addr']?"required":"";?>>
        <a href="<? echo $zip_href; ?>" target="_blank" id="reg_zip_find" class="btn_frmline win_zip_find">주소찾기</a>
        <input type="text" name="mb_addr1" value="<?=$member['mb_addr1']?>" id="reg_mb_addr1" title="행정구역주소" class="frm_input frm_address <?=$config['cf_req_addr']?"required":"";?>" size="50" <?=$config['cf_req_addr']?"required":"";?>>
        <input type="text" name="mb_addr2" value="<?=$member['mb_addr2']?>" id="reg_mb_addr2" title="상세주소" class="frm_input frm_address <?=$config['cf_req_addr']?"required":"";?>" size="50" <?=$config['cf_req_addr']?"required":"";?>>
    </td>
</tr>
<? } ?>
</table>

<table class="frm_tbl">
<caption>기타 개인설정</caption>
<? if ($config['cf_use_signature']) { ?>
<tr>
    <th scope="row"><label for="reg_mb_signature">서명<? if ($config['cf_req_signature']){?><strong class="sound_only">필수</strong><?}?></label></th>
    <td><textarea name="mb_signature" id="reg_mb_signature" class="<?=$config['cf_req_signature']?"required":"";?>" <?=$config['cf_req_signature']?"required":"";?>><?=$member['mb_signature']?></textarea></td>
</tr>
<? } ?>

<? if ($config['cf_use_profile']) { ?>
<tr>
    <th scope="row"><label for="reg_mb_profile">자기소개</label></th>
    <td><textarea name="mb_profile" id="reg_mb_profile" class="<?=$config['cf_req_profile']?"required":"";?>" <?=$config['cf_req_profile']?"required":"";?>><?=$member['mb_profile']?></textarea></td>
</tr>
<? } ?>

<? if ($member['mb_level'] >= $config['cf_icon_level']) { ?>
<tr>
    <th scope="row"><label for="reg_mb_icon">회원아이콘</label></th>
    <td>
        <input type="file" name="mb_icon" id="reg_mb_icon" class="frm_input">
        <? if ($w == 'u' && file_exists($mb_icon)) { ?>
        <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
        <label for="del_mb_icon">삭제</label>
        <? } ?>
        <span class="frm_info">
            이미지 크기는 가로 <?=$config['cf_member_icon_width']?>픽셀, 세로 <?=$config['cf_member_icon_height']?>픽셀 이하로 해주세요.<br>
            gif만 가능하며 용량 <?=number_format($config['cf_member_icon_size'])?>바이트 이하만 등록됩니다.
        </span>
    </td>
</tr>
<? } ?>

<tr>
    <th scope="row"><label for="reg_mb_mailling">메일링서비스</label></th>
    <td>
        <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?=($w=='' || $member['mb_mailling'])?'checked':'';?>>
        정보 메일을 받겠습니다.
    </td>
</tr>

<? if ($config['cf_use_hp']) { ?>
<tr>
    <th scope="row"><label for="reg_mb_sms">SMS 수신여부</label></th>
    <td>
        <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?=($w=='' || $member['mb_sms'])?'checked':'';?>>
        핸드폰 문자메세지를 받겠습니다.
    </td>
</tr>
<? } ?>

<? if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G4_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능 ?>
<tr>
    <th scope="row"><label for="reg_mb_open">정보공개</label></th>
    <td>
        <input type="hidden" name="mb_open_default" value="<?=$member['mb_open']?>">
        <input type="checkbox" name="mb_open" value="1" id="reg_mb_open" <?=($w=='' || $member['mb_open'])?'checked':'';?>>
        다른분들이 나의 정보를 볼 수 있도록 합니다.
        <span class="frm_info">
            정보공개를 바꾸시면 앞으로 <?=(int)$config['cf_open_modify']?>일 이내에는 변경이 안됩니다.
        </span>
    </td>
</tr>
<? } else { ?>
<tr>
    <th scope="row">정보공개</th>
    <td>
        <input type="hidden" name="mb_open" value="<?=$member['mb_open']?>">
        <span class="frm_info">
            정보공개는 수정후 <?=(int)$config['cf_open_modify']?>일 이내, <?=date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G4_SERVER_TIME+$config['cf_open_modify']*86400);?> 까지는 변경이 안됩니다.<br>
            이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
        </span>
    </td>
</tr>
<? } ?>

<? if ($w == "" && $config['cf_use_recommend']) { ?>
<tr>
    <th scope="row"><label for="reg_mb_recommend">추천인아이디</label></th>
    <td><input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input"></td>
</tr>
<? } ?>

<tr>
    <th scope="row">자동등록방지</th>
    <td><?=$captcha_html?></td>
</tr>
</table>

<div class="btn_confirm">
    <input type="submit" value="<?=$w==''?'회원가입':'정보수정';?>" class="btn_submit" accesskey="s">
    <a href="<?=G4_URL?>/" class="btn_cancel">취소</a>
</div>
</form>

<? // 휴대폰인증 form
include_once(G4_BBS_PATH.'/kcp/kcpcert_form.php');
?>

<script>
$(function() {
    $("#reg_zip_find").css("display", "inline-block");
    $("#reg_mb_zip1, #reg_mb_zip2, #reg_mb_addr1").attr("readonly", true);

    // 휴대폰인증
    $('#win_kcpcert').click(function() {
        var name = document.fregisterform.mb_name.value;
        auth_type_check(name);
        return false;
    });
});

// submit 최종 폼체크
function fregisterform_submit(f)
{
    // 회원아이디 검사
    if (f.w.value == "") {
        var msg = reg_mb_id_check();
        if (msg) {
            alert(msg);
            f.mb_id.select();
            return false;
        }
    }

    if (f.w.value == '') {
        if (f.mb_password.value.length < 3) {
            alert('패스워드를 3글자 이상 입력하십시오.');
            f.mb_password.focus();
            return false;
        }
    }

    if (f.mb_password.value != f.mb_password_re.value) {
        alert('패스워드가 같지 않습니다.');
        f.mb_password_re.focus();
        return false;
    }

    if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 3) {
            alert('패스워드를 3글자 이상 입력하십시오.');
            f.mb_password_re.focus();
            return false;
        }
    }

    // 이름 검사
    if (f.w.value=='') {
        if (f.mb_name.value.length < 1) {
            alert('이름을 입력하십시오.');
            f.mb_name.focus();
            return false;
        }

        var pattern = /([^가-힣\x20])/i;
        if (pattern.test(f.mb_name.value)) {
            alert('이름은 한글로 입력하십시오.');
            f.mb_name.select();
            return false;
        }
    }

    // 별명 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        var msg = reg_mb_nick_check();
        if (msg) {
            alert(msg);
            f.reg_mb_nick.select();
            return false;
        }
    }

    // E-mail 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
        var msg = reg_mb_email_check();
        if (msg) {
            alert(msg);
            f.reg_mb_email.select();
            return false;
        }
    }

    // 휴대폰번호 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_hp.defaultValue != f.mb_hp.value)) {
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
    }

    // 휴대폰인증 검사
    if(f.kcpcert_time.value == "") {
        alert("휴대폰 본인인증을 해주세요.");
        return false;
    }

    // 휴대폰번호 변경 검사
    if(f.w.value == "u") {
        var patt = /[^0-9]/g;
        var old_hp = f.old_mb_hp.value.replace(patt, "");
        var mb_hp = f.mb_hp.value.replace(patt, "");

        if(old_hp != mb_hp) {
            if(f.kcpcert_no.value == "") {
                f.kcpcert_time.value = "";
                alert("휴대폰번호가 변경됐습니다. 휴대폰 본인인증을 해주세요.");
                return false;
            }
        }
    }

    if (typeof f.mb_icon != 'undefined') {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif)$/i)) {
                alert('회원아이콘이 gif 파일이 아닙니다.');
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != 'undefined') {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert('본인을 추천할 수 없습니다.');
            f.mb_recommend.focus();
            return false;
        }
    }

    <? echo chk_captcha_js(); ?>

    return true;
}
</script>
