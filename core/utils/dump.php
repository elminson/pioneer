<?
    
    
    $driver = $core->rq->driver;
    $server = $core->rq->server;
    $db = $core->rq->db;
    $user = $core->rq->user;
    $password = $core->rq->password;
    
    if(!$driver || !$server || !$db || !$user || !$password)
        exit;
    
    $sys = new systemrestore();
    $sys->DumpDatabase($driver, $server, $db, $user, $password);
    
    
?>