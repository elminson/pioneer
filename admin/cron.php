<?
	// HTTP/1.1
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	
	// HTTP/1.0
	header("Pragma: no-cache");
	
	define("MODE_ADMIN", "MODE_ADMIN");

	set_time_limit(999999);

	include($_SERVER["DOCUMENT_ROOT"]."/autoexec.inc.php");

	$rp = new systemrestore();
	$rp->setDroptables(true);	
	$dumpname = $rp->createRestorePoint();	
	
	if(is_null($core->sts->SYSTEM_RESTORE_CRON_MAX))
		$core->sts->SYSTEM_RESTORE_CRON_MAX = 10;
	
	$rp->clean_points($core->sts->SYSTEM_RESTORE_CRON_MAX);
	
	exit();
?>