<?php
// service settings
//$PAGE_CACHE = true;
//$PAGE_CACHE_EXCLUSSIONS = array('authorize');
// $PAGE_CACHE = true;

// service settings
$SERVICE_MODE = "developing";
//$SERVICE_MODE = "release";

// security settings
// $SECURITY_MODE = "simple";
$SECURITY_MODE = "embeded";

// session enabled
$SESSION_ENABLED = true;
// $SESSION_ENABLED = true;

// session enabled
// $MODULE_ENABLED = false;
$MODULE_ENABLED = true;

// Site full path
$SITE_PATH = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']).'/';

// Path to PIONEER.Core
$CORE_PATH = $SITE_PATH."core/";

// PIONEER.Core linked file
$CORE_FILE = 'core_linked.pkg.php';

// Path to phpRAC.Admin
$ADMIN_PATH = $SITE_PATH."admin/";

// mail queue path
$MAIL_QUEUE = $SITE_PATH.'_system/_cache/queue/';

// use mail queueing
$USE_MAIL_QUEUEING = false;


// Database settings
// ---------------------------------
// please set up the database settings here after running install.php from admin directory
//$DRIVER = 'mysql';
//$SERVER = "localhost";
//$DATABASE = "max";
//$USER = "root";
//$PASSWORD = "";
$DRIVER = 'mysql';
$SERVER = "max108.mysql"; //localhost //max108.local
$DATABASE = "max108_db";
$USER = "max108_mysql";
$PASSWORD = "1d8ier9v";


// Blob viewer path
$BLOB_VIEWER = "/core/utils/blob.php";

// RUNTIME styles
$RS_LOADER     = "/core/utils/runtime_style.php";

// blob viewer settings
$NA_IMAGE = "/images/na.jpg";

// Language settings
$LANGUAGE = "ru";
$ADMIN_LANGUAGE = "ru";

// Admin CSS
$admin_html_styles["style"] = "/adminstyles.php";
$admin_html_styles["xml"] = "/adminstyles_xml.php";

// ob settings
$OB_ENCODING = "";
$OB_ENABLED = false;

define('FOLDER404', 'e404');

?>