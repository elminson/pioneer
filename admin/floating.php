<?
	header("Content-type: text/html; charset=utf-8");
	
	// HTTP/1.1
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	
	// HTTP/1.0
	header("Pragma: no-cache");
	
	define("MODE_ADMIN", "MODE_ADMIN");

	set_time_limit(999999);

	include(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME'])."/autoexec.inc.php");

	$section = $core->rq->postback_section;
	if(is_null($section))
		$section = "general";

	include_once("classes/postbackform.cls.php");
	include_once("classes/".$section.".cls.php");
	
	$classname = $section."PageForm";

	$postback = new $classname();
	$postback->encbinary = true;
	$postback->floating = true;
	$postback->Process();

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$postback->lang->document_title?></title>
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
<?=$postback->RenderBlock("form_head")?>
<table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0" class="float">
  <tr>
    <td id="top"><table width="100%" cellpadding="0" cellspacing="0" border="0" background="images/v5/floating/ttl-bg.jpg">
        <tr>
            <td class='float-subtitle'>
                <?=$postback->RenderBlock("subtitle")?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?=$postback->RenderBlock("toolbar")?>
            </td>
        </tr>
        <tr>
            <td id="idEditorBar" colspan="2">
                <?=$postback->RenderBlock("editor_bar")?>
            </td>
        </tr>
        </table>
      </td>
    </tr>
	<tr>
		<td height="100%">
			<div class="resize" id="divResizeMain">
				<div class="resize-container">
					<?=$postback->RenderBlock("content"); ?>
				</div>
			</div>
		
		</td>
	</tr>	
	<tr>
		<td class="bottom_toolbar" id="bottom">
			<?=$postback->RenderBlock("toolbar_bottom"); ?>
		</td>
	</tr>
</table>
<?=$postback->RenderBlock("form_footer")?>
</body>
</html>
