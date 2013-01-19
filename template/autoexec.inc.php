<?
	//print_r($_SERVER);
	
/*if(isset($_SERVER['argv'])) {
	$_SERVER['SCRIPT_NAME'] = $_SERVER['argv'][0];
    $_SERVER['SERVER_NAME'] = $_SERVER['argv'][1];

    $_SERVER['SCRIPT_FILENAME'] = $_SERVER['PWD'].'/'.$_SERVER['SCRIPT_NAME'];
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['PWD'];
    
    for($i=2; $i<count($_SERVER['argv']); $i++) {
        $arg = $_SERVER['argv'][$i];
        $arg = explode('=', $arg);
        $_GET[$arg[0]] = $arg[1];
    }
    
}*/
// configuration file
include("config.inc.php");

/*including core*/
if($SERVICE_MODE == 'developing')
    include($CORE_PATH."core.inc.php");
else {
    include_once($CORE_PATH.$CORE_FILE);
}



error_reporting(E_ALL);
ini_set("display_error", "ALL");
	
/*initializing*/
$core = new Core();
$core->sitePath = $SITE_PATH;
$core->corePath = $CORE_PATH;
$core->adminPath = $ADMIN_PATH;
$core->blobViewerUrl = $BLOB_VIEWER;
$core->Language = $LANGUAGE;
$core->obenconding = $OB_ENCODING;
$core->obenabled = $OB_ENABLED;
$core->mysqlBinDir = "c:\mysql\bin";
$core->initialize($SERVER, $DATABASE, $USER, $PASSWORD, $DRIVER);
@$core->dbe->execute("set names utf8");
$core->rq->section_langauge = $ADMIN_LANGUAGE;

?>