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

	$category = $core->rq->category;
	if(is_null($category))
		$category = -1;

	$sort = $core->rq->sort;
	if(is_null($sort))
		$sort = "blobs_id";

	$view = $core->rq->view;
	if(is_null($view))
		$view = "icons";
		
	$templates = array(
		"report" => '
			<div id="item<?=$this->blobid?>" style="float:left; width: 90%; height: 100px; margin: 10px 0px 0px 10px; border:1px solid #8DA1C5; padding:5px;" onclick="selectItem(this, <?=$this->blobid?>);">
				<table width="100%">
					<tr>
						<td width="100" height="100" align="center" valign="middle">
							<a target="_blank" href="<?=$this->src()?>"><?=$this->img(100, 100)?></a>
						<td>
						<table width="100%">
								<tr>
									<td width="46" class="section"><strong> ID: </strong></td>
									<td><?=$this->blobid?>
									</td>
								</tr>
								<tr>
									<td class="section"><strong> File: </strong></td>
									<td><?=$this->path?>
										&nbsp;(
										<?=$this->datalength?>
										bytes ) </td>
								</tr>
								<tr>
									<td class="section"><strong> Alt: </strong></td>
									<td><?=$this->alt?>
									</td>
								</tr>
							</table></td>
					</tr>
				</table>
			</div>		
			<script>
				window.items[window.items.length] = document.getElementById("item<?=$this->blobid?>");
			</script>
		',
		"icons" => '
			<div id="item<?=$this->blobid?>" style="float:left; width: 150px; height: 180px; margin: 10px 0px 0px 10px; border:1px solid #8DA1C5;padding:5px;" onclick="selectItem(this, <?=$this->blobid?>);">
				<table width="100%" style="float:left" height="130">
				<tr>
				<td width="100%" valign="middle" align="center">
					<a target="_blank" href="<?=$this->src()?>"><?=$this->img(100, 100)?></a>
				</td>
				</tr>
				</table>
				<div style="float:left; width: 150px;text-align:center">
				<strong>Id:</strong> <?=$this->blobid?><br />
				<strong> File: </strong><?=striplen($this->path,15)?><br />
				<strong> File size: </strong><?=$this->datalength?>&nbsp;bytes<br />
				<strong> Alt: </strong><?=$this->alt?>
				</div>
			</div>
			<script>
				window.items[window.items.length] = document.getElementById("item<?=$this->blobid?>");
			</script>
				
		'
	);

	function echoBlobs() {
		global $core;
		global $category, $view, $sort, $templates;
		
		$blobscount = $core->bm->enumBlobsCount($category);
		$blobs = $core->bm->enumBlobs($category, $sort);
		
		foreach($blobs as $blob) {
			echo $blob->Out($templates[$view], false);
		}
		
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="/admin/page.css" rel="stylesheet" type="text/css" />
<style>
	.normal {
	}
	
	.selected {
		background-color: #f2f2f2;
	}
</style>
<script>
	function Reload(id) {
		location = "?category="+id;
	}
	
	function unselectAll() {
		for(var i=0; i<window.items.length;i++){
			window.items[i].className = "normal";
		}
	}
	
	function makeSelection(id, alt, img, filename, type_id, category, w, h, href) {
		
		//try {
			<?
				$handler = "handle";
				if($core->rq->handler != "")
					$handler = $core->rq->handler;
			?>
			window.opener.<?=$handler?>(id, alt, img, filename, type_id, category, w, h, href);
			window.close();
		//}
		//catch(e) {
		//}
		
	}
	
	function selectItem(obj, id) {
		var selected = document.getElementById("selected");
		selected.value = id;
		unselectAll();
		obj.className = "selected";
	}
	
	function resizeDiv(e) {
		var div = document.getElementById("divResize");
		div.style.height = (document.body.clientHeight-95)+"px";
	}
	
	window.items = new Array();
	
	if(!document.all)   {
		window.onresize = resizeDiv;
		window.onload = resizeDiv;
	}
	
	<?
		if($core->rq->select && $core->rq->selected != -1) {
			$b = $core->bm->blob($core->rq->selected);
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
<body style="overflow:hidden">

<form>
<input type="hidden" name="selected" id="selected" value="-1">
<input type="hidden" name="handler" value="<?=$core->rq->handler?>">
<table width="100%" cellpadding=0 cellspacing=0 height="100%">
	<tr>
		<td height="25">
		</td>
	</tr>
	<tr>
		<td height="25">
			<table>
				<tr>
					<td class="section">
						Category: 
					</td>
					<td>
						<select name="category" onchange="this.form.submit();" style="width: 350px;">
							<?
								$cats = blobs::Categories(null, -1);
								foreach($cats as $cat) {
									$pad = str_repeat("&nbsp;", ($cat->level-1)*4);
									$selected = $category == $cat->id ? " selected" : "";
									echo '<option value="'.$cat->id.'" '.$selected.'>'.$pad.$cat->category.'</option>';
								}
							?>
						</select>
					</td>
					<td>
						&nbsp;
					</td>
					<td class="section">
						Sort:
					</td>
					<td>
						<select name="sort" onchange="this.form.submit();">
							<option value="blobs_id" <?=($sort == "blobs_id" ? "selected" : "")?>>Id</option>
							<option value="blobs_filename" <?=($sort == "blobs_filename" ? "selected" : "")?>>Filename</option>
							<option value="blobs_length" <?=($sort == "blobs_length" ? "selected" : "")?>>Filesize</option>
							<option value="blobs_alt" <?=($sort == "blobs_alt" ? "selected" : "")?>>Alt</option>
						</select>
					</td>
					<td>
						&nbsp;
					</td>
					<td class="section">
						View:
					</td>
					<td>
						<select name="view" onchange="this.form.submit();">
							<option value="report" <?=($view == "report" ? "selected" : "")?>>Report</option>
							<option value="icons" <?=($view == "icons" ? "selected" : "")?>>Icons</option>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<div style="border: 2px inset; background-color: #fff; overflow:auto; height:100%" id="divResize">
			<?
				echoBlobs();
			?>
			</div>
		</td>
	</tr>
	<tr>
		<td height="45">
			<table>
				<tr>
					<td>
						<input type="submit" name="select" value="Select"  class="command-button" />
					</td>
					<td>
						<input type="submit" name="close" value="Close"  class="command-button" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>

</body>
</html>