<?
    header("Content-type: text/html; charset=utf-8");
    
    // HTTP/1.1
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    
    // HTTP/1.0
    header("Pragma: no-cache");
    
    define("MODE_ADMIN", "MODE_ADMIN");

    set_time_limit(999999);

    include($_SERVER["DOCUMENT_ROOT"]."/autoexec.inc.php");
    
    $operation = "";
    if(!is_null($core->rq->operation))
        $operation = $core->rq->operation;

?>
<HTML>
<HEAD>
<TITLE>phpRAC Installation</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="styles.css" rel="stylesheet" type="text/css">
</HEAD>    
<BODY leftmargin=0 topmargin=0>
<br />
<fieldset style="width: 90%; margin-top: 20px; margin-left: 5%" align=center>

<?    
    switch($operation) {
        default:
        case '':
?>
            <legend><strong>Pioneer database installation</strong></legend>
            <a href="?operation=start">Start</a>

<?        
            break;
        case 'start':
            if(!$core->dbe->scheme->CreateScheme()) {
?>
            Error: <?=$core->dbe->Error()?>
<?        
            }
            else {
                redirect('?operation=complete');
            }
            break;
        case 'complete':
?>
        <legend><strong>Install complete</strong></legend>
        <br>
        <table border="0" align="center" cellpadding="0" cellspacing="0" width="90%">
        <tr>
            <td class="message-text" align="left" style="font-size:12px;">
                Installation successful.<br>
                Your first developer user name is <strong class="warning-title">admin</strong>,
                <br>
                password is <strong class="warning-title">admin</strong>.<br>
                Try login on <a href="/admin/" style="color: #f00">autorization page</a>.</span>
                <br><br>
                <span style="color:#f00; font-weight:bold">Warning: </span>
                <span style="color: #f00;">Remember to edit the config.inc.php from the root of your site, there are system configuration. It must be set before you try to login. </span>
            </td>
        </tr>
        </table>
        <br>
<?        
             break;
    }
    
?>

</fieldset>
<div style="text-align:center; font-size: 10px; margin-top: 20px; color: #c0c0c0">
	Copyright 2006 <a href="http://www.e-time.ru" style="color: #c0c0c0; font-size:10px;">E-Time</a>
</div>

</BODY>
