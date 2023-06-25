<?
include_once('./kcpcert_config.php');

// UTF-8 ȯ�濡�� �ؽ� ������ ������ ���� ���� �ڵ�
setlocale(LC_CTYPE, 'ko_KR.euc-kr');

$req_tx        = "";

$site_cd       = "";
$ordr_idxx     = "";

$year          = "";
$month         = "";
$day           = "";
$user_name     = "";
$sex_code      = "";
$local_code    = "";

$up_hash       = "";
/*------------------------------------------------------------------------*/
/*  :: ��ü �Ķ���� �����                                               */
/*------------------------------------------------------------------------*/

$ct_cert = new C_CT_CLI;
$ct_cert->mf_clear();

// utf-8�� �Ѿ post ���� euc-kr �� ����
$_POST = array_map("iconv_euckr", $_POST);

// request �� �Ѿ�� �� ó��
$key = array_keys($_POST);
$sbParam ="";

for($i=0; $i<count($key); $i++)
{
    $nmParam = $key[$i];
    $valParam = $_POST[$nmParam];

    if ( $nmParam == "site_cd" )
    {
        $site_cd = f_get_parm_str ( $valParam );
    }

    if ( $nmParam == "req_tx" )
    {
        $req_tx = f_get_parm_str ( $valParam );
    }

    if ( $nmParam == "ordr_idxx" )
    {
        $ordr_idxx = f_get_parm_str ( $valParam );
    }

    if ( $nmParam == "user_name" )
    {
        $user_name = f_get_parm_str ( $valParam );
    }

    if ( $nmParam == "year" )
    {
        $year = f_get_parm_int ( $valParam );
    }

    if ( $nmParam == "month" )
    {
        $month = f_get_parm_int ( $valParam );
    }

    if ( $nmParam == "day" )
    {
        $day = f_get_parm_int ( $valParam );
    }

    if ( $nmParam == "sex_code" )
    {
        $sex_code = f_get_parm_str ( $valParam );
    }

    if ( $nmParam == "local_code" )
    {
        $local_code = f_get_parm_str ( $valParam );
    }

    // ����â���� �ѱ�� form ������ ���� �ʵ�
    $sbParam .= "<input type='hidden' name='" . $nmParam . "' value='" . f_get_parm_str( $valParam ) . "'/>";
}

if ( $req_tx == "cert" )
{
    // !!up_hash ������ ������ ���� ����
    // year , month , day �� ��� �ִ� ��� "00" , "00" , "00" ���� ������ �˴ϴ�
    // �׿��� ���� ���� ��� ""(null) �� �����Ͻø� �˴ϴ�.
    // up_hash ������ ������ site_cd �� ordr_idxx �� �ʼ� ���Դϴ�.
    $hash_data = $site_cd                  .
                 $ordr_idxx                .
                 $user_name                .
                 f_get_parm_int ( $year  ) .
                 f_get_parm_int ( $month ) .
                 f_get_parm_int ( $day   ) .
                 $sex_code                 .
                 $local_code;

    $up_hash = $ct_cert->make_hash_data( $home_dir, $hash_data );

    // ����â���� �ѱ�� form ������ ���� �ʵ� ( up_hash )
    $sbParam .= "<input type='hidden' name='up_hash' value='" . $up_hash . "'/>";
}

$ct_cert->mf_clear();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
        <title>*** KCP Online Payment System [PHP Version] ***</title>
        <script type="text/javascript">
            window.onload=function()
            {
                var frm = document.form_auth;

                // ���� ��û �� ȣ�� �Լ�
                if ( frm.req_tx.value == "cert" )
                {
                    opener.document.form_auth.veri_up_hash.value = frm.up_hash.value; // up_hash ������ ������ ���� �ʵ�

                    frm.action="<?=$cert_url?>";
                    frm.submit();
                }
            }
        </script>
    </head>
    <body oncontextmenu="return false;" ondragstart="return false;" onselectstart="return false;">
        <form name="form_auth" method="post">
            <?= $sbParam ?>
        </form>
    </body>
</html>