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

	$handle = $core->rq->handle;
	if(is_null($handle))
		$handle = "handle";

	$edit = $core->rq->edit;
	if($edit)
		$editb = $core->bm->blob($edit);
	else
		$editb = new collection();

	if($core->rq->upload) {
		
		
		$alt = "alt";
		$alt = $core->rq->$alt;
		$ff = "file";
		$f = $core->rq->$ff;
		if($f->error == 0) {
			$bBlob = $f->binary();
			$strPath = $f->name;
			$blobs_type = $f->ext;
		}
		else {
			$url = "url";
			$fUrl = $core->rq->$url;
			$bBlob = $core->bm->download($fUrl);

			$fname = basename($fUrl);
			$strPath = $fname;
			$af = preg_split("/\./", $fname);
			$blobs_type = @$af[1];
		}					  
		
		$category = $core->rq->category;
		if(!$category)
			$category = -1;
		
		if(!$edit) {
			$blobid = $core->bm->save_blob(-1, $bBlob, $strPath, $blobs_type, $todatabase = true);
			$core->bm->set_options($blobid, $strPath, $blobs_type, $alt, $category);
		}								
		else {
			$blobid = $core->bm->save_blob($edit, $bBlob, $strPath, $blobs_type, $todatabase = true);
			$core->bm->set_options($blobid, $strPath, $blobs_type, $alt, $category);
		}
	}

?>
		
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<link href='/admin/page.css' rel='stylesheet' type='text/css'>
<title>Add blob</title>

<script>
	function makeSelection(id, alt, img, filename, type_id, category, w, h, href) {
		//try {
			window.opener.field = window.field;
		//}
		//catch(e) {
		//}
		//try {
			window.opener.<?=$handle?>(id, alt, img, filename, type_id, category, w, h, href);
			window.close();
		//}
		//catch(e) {
		//}
		
	}
	
	<?
		if($core->rq->upload) {
			$b = $core->bm->blob($blobid);
			$w = 100;
			$h = 100;
			$b->size($w, $h);
	
	?>
	makeSelection(<?=$b->blobid?>, "<?=$b->alt?>", "<?=$b->src(100,100)?>", "<?=$b->path?>", "<?=$b->ext?>", "", "<?=$w?>", "<?=$h?>", "<?=$b->src(0,0)?>");
	<?
		}
	?>
	
	
</script>

</head>
<body style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; background-image: none;">
<table width=100% cellpadding=0 cellspacing=0 border=0 style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
	<tr>
		<?
			if($edit) {
		?>
		<td width="120" align="center" valign="middle">
		<?
		if($editb->is_image()) {
		?>
			<a target="_blank" href="<?=$editb->src(0,0)?>"><img src="<?=$editb->src(100, 100)?>" border="0" ></a>
		<?
		}
		else {
		?>	
			<a target="_blank"  href="<?=$editb->src(0,0)?>"><?=$editb->icon()?></a>
		<?
		}
		?>
			
		</td>
		<?}?>
		<td class=main-td style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
		
			<form method="post" enctype="multipart/form-data" style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
				<table cellpadding="3" cellspacing="3" border="0" align="center" style="margin: 10px 0px 0px 0px; vertical-align: middle;" width="100%">
					<tr>
						<td align="left" valign="top" nowrap width="70" class="section">File: </td>
						<td align="left" valign="top" nowrap><input id="input" name="file" type="file" value="" class="alter-input">
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" nowrap width="70" class="section">File (URL): </td>
						<td align="left" valign="top" nowrap><input id="file_url" name="url" type="text" value="" class="alter-input">
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" nowrap width="70" class="section">Alt: </td>
						<td align="left" valign="top" nowrap><input id="alt" name="alt" type="text" value="<?=$editb->alt?>" class="alter-input">
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" nowrap width="70" class="section">category: </td>
						<td align="left" valign="top" nowrap>
						<select name="category" class="alter-input">
							<?
								$cats = blobs::Categories(null, -1);
								foreach($cats as $cat) {
									$pad = str_repeat("&nbsp;", ($cat->level-1)*4);
									$selected = $editb->parent == $cat->id ? " selected" : "";
									echo '<option value="'.$cat->id.'" '.$selected.'>'.$pad.$cat->category.'</option>';
								}
							?>
						</select>
						</td>
					</tr>
				</table>
				<div style="padding-left: 5px;padding-top: 10px;">
					<input id="upload" name="upload" type="submit" value="upload" class="command-button">
					<input id="cancel" name="cancel" type="submit" value="cancel" class="command-button">
				</div>
			</form>
		</td>
	</tr>
</table>
</body>
</html>
