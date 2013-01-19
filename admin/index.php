<?

    header("Content-type: text/html; charset=utf-8");
	
	// HTTP/1.1
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	
	// HTTP/1.0
	header("Pragma: no-cache");
	
	define("MODE_ADMIN", "MODE_ADMIN");

	set_time_limit(999999);
    
    date_default_timezone_set('Europe/Moscow');

    
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
	include(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME'])."/autoexec.inc.php");
    
    $section = $core->rq->postback_section;
	if(is_null($section))
		$section = "general";

	include_once("classes/postbackform.cls.php");
	include_once("classes/".$section.".cls.php");
	
	$classname = $section."PageForm";
	
	$postback = new $classname();
	$postback->encbinary = true;
	$postback->Process();
    
    $title = $postback->RenderBlock("title");
    $subtitle = $postback->RenderBlock("subtitle");
    
//    exit;

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$subtitle." | ".$title." | "?><?=$postback->lang->document_title?></title>
<link href="styles/v5.css" rel="stylesheet" type="text/css" >
<link href="styles/forms.css" rel="stylesheet" type="text/css" >
<link href="styles/resizer.css" rel="stylesheet" type="text/css" >
<link href="styles/toolbars.css" rel="stylesheet" type="text/css" >
<link href="styles/commandbars.css" rel="stylesheet" type="text/css" >
<link href="styles/templates.css" rel="stylesheet" type="text/css" >
<link href="styles/controls/datetime.css" rel="stylesheet" type="text/css" >

<? echo $postback->RenderBlock("scripts") ?>
<? echo $postback->RenderBlock("styles") ?>

</head>

    <body>
        <?=$postback->RenderBlock('menu')?>
        
        <?=$postback->RenderBlock("form_head")?>   

        <?
            if($postback->UseExternalInterface()) {
        ?>

        <table id="root" cellpadding="0" cellspacing="0">
            <tr><td id="top">
                
                <table cellpadding="0" cellspacing="0" id="topbar">
                    <tr><td id="start"><a href="#"><img src="images/1x1.gif" border="0" width="55" height="65" alt="Start" onclick="javascript: startmenu_show(event, 2, 30);" /></a></td><td width="100%">
                         <table cellpadding="0" cellspacing="0" id="captionbar">
                            <tr><td id="caption">
                                <table cellpadding="0" cellspacing="0">
                                <tr><td id="sn"><img src="images/v5/tttl.png" /></td><td id="text">
                                    <?=$title?>: <?=$subtitle?>
                                </td></tr>
                                </table>
                            </td></tr>
                            <tr><td id="favorites">
                                <table cellpadding="0" cellspacing="0">
                                <tr><td id="tb">
                                    <?
                                        echo $postback->RenderBlock("favorites");
                                    ?>
                                </td><td id="userinfo">
                                     <?=$postback->lang->welcome_message?> <strong><?=$postback->current_user->name?></strong>.<br />
                                     Ваш статус в системе: <strong><?=$postback->current_user->IsSupervisor() ? "Superuser" : @$core->security->systemInfo->roles->Item(@$postback->current_user->roles->Item(0))->description?></strong><br />
                                     База данных: <strong><?=$DATABASE?></strong>
                                </td><td style="vertical-align: middle;">
                                     <a href="<?=$postback->CreatePostBack('logout', 'general', 'main', 'post')?>"><img src="images/v5/logout.png" /></a>
                                </td></tr>
                                </table>
                            </td></tr>
                         </table>
                    </td></tr>
                    <tr><td colspan="2">
                        <?=$postback->RenderBlock("toolbar")?>
                    </td></tr>
                    <?
                        $cammandbar = $postback->RenderBlock("toolbar_bottom");
                        if(trim($cammandbar) != "") {
                    ?>
                    <tr><td colspan="2">
                        <?=$cammandbar?>
                    </td></tr>
                    <?
                        }
                    ?>
                    
                </table>
                
            </td></tr>
            <tr><td id="middle">
                                
                
                <div class="resize" id="divResizeMain">
                    <div class="resize-container">
              
                    <? echo $postback->RenderBlock("content"); ?>
                    
                    </div>
                </div>
                
            </td></tr>
            <tr><td id="bottom">
                <table cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td><td class="e-time"><a target="_blank" href="http://www.e-time.ru"><img src="images/1x1.gif" /></a></td></tr></table>
            </td></tr>                    
        </table>
        <?
        }
        else {
            echo $postback->RenderBlock("content");
        }
        ?>
        <?=$postback->RenderBlock("form_footer")?>
   </body>
</html>
