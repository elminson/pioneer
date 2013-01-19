<?
	
	include_once(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME'])."/autoexec.inc.php");
	
	global $NA_IMAGE;
	global $core;

    if(count($_GET) == 0)
        exit;
    
	$blobid = $core->rq->blobid;
	$mode = $core->rq->mode;
	$recache = $core->rq->recache;	
    
	$w = $core->rq->w;
	if(!$w) $w = 0;
	
    $h = $core->rq->h;
	if(!$h) $h = 0;
    
    $filter = $core->rq->filter;
    if(!$filter) $filter = null;
	/*
	$d = $core->rq->d == null ? false : true;
	$na = ($core->rq->na == null) ? $NA_IMAGE : $core->rq->na;
	$overlay = $core->rq->overlay;
	$modifydate = time();
	if (!is_numeric($blobid))
		$blobid = base64_decode($blobid);
	*/
	
	// /resources/blobs/access123.jpg
	// blob.php?blobid=access123
	if (stripos($blobid, "access") === 0){
        
        $font = '';
        $bf = preg_split('/\*/i', $blobid);
        if(count($bf) > 0) {
            $blobid = $bf[0];
            $font = base64_decode(@$bf[1]);
        }        
        
        $fpath = '';
        $fsize = 0;
        $fs = explode(";", $font);
        if(count($fs) > 0) {
            $fpath = @$fs[0];
            $fsize = @$fs[1];
        }
        else {
            $fpath = $font;
        }
        
        $font = null;
        if(!is_empty($fpath))
            $font = new Font('', $fpath, $fsize);
        
		$code = new AccessCode(substr($blobid, 6), $font);
		echo $code->Stream();
		exit;
	}

	//out($core->bm->options($blobid));
	$b = new Blob(intval($blobid));
        
	//$b->ClearCache();
	$size = $b->size->TransformTo(new Size($w, $h));
	$modifydate = $b->modified;
	$mimetype = $b->mimetype;
	
	if (!modified_since($modifydate)) {
		header("HTTP/1.0 304 Not Modified");
		header("Content-Length: 0");
		exit();
	}
	
    $b->UpdateAccessTime();
    $b->filter = $filter;
	$data = $b->ReadCache($size, $recache == "true" ? true : false);
	
    //if(!$b->mimetype->isCapable)
    //    $mode = "download";
    
	header("Content-Type: ".$mimetype->mime); 
	if ($mode != "nodownload")
	    header('Content-Disposition: attachment; filename='.basename($b->filename)); //
    
	header('Expires: '.(30*60*60*24));
	header('Cache-Control: max-age='.(30*60*60*24).', public');
	header('Content-Length: '.strlen($data));
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", strtotime($modifydate))." GMT");

	echo $data;
?>