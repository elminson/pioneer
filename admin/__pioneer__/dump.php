<?
    
    header("Content-type: text/html; charset=utf-8");
    
    // HTTP/1.1
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    
    // HTTP/1.0
    header("Pragma: no-cache");
    
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    
    define("MODE_ADMIN", "MODE_ADMIN");

    set_time_limit(999999);

    include(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME'])."/autoexec.inc.php");
    
    
    
    $driver = $core->rq->driver;
    $server = $core->rq->server;
    $db = $core->rq->db;
    $user = $core->rq->user;
    $password = $core->rq->password;
    
    $drv = $this->driver."Driver";
    
    $sys = new systemrestore();
    $sys->DumpDatabase(new $drv(), $server, $db, $user, $password);
    
    
?>