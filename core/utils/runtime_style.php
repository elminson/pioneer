<?
	global $core;
	
    if(!$core->rq->location || count($_GET) == 0) {
        exit;
    }
    
	$templates = explode(",", $core->rq->location);
	foreach($templates as $t) {
		$tt = explode(".", $t);
		$template = Template::FromId($tt[2], $tt[0]);
?>
/* stylesheet for the template <?=$template->name?> */
<?
		$code = load_from_file($template->styles);
		$code = eval(convert_php_context($code));
	}
?>