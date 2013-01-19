<?
$startTime0 = microtime(true);
	
    include_once("autoexec.inc.php");
    
    $startTime1 = microtime(true);

    $site_name = $_SERVER["SERVER_NAME"];
    $site_port = $_SERVER["SERVER_PORT"];
    /* временно */
    $gfolder = @$core->nav->folder->name;
    $gpublication = @$core->nav->publication->id;
    if($core->rq->reindex == "true") {
        out("Индексация");
        set_time_limit(99999);
        $core->ie->createIndexAll();
        out("завершена");
        exit;
    }
    
    $sessionchanged = (!$core->security->currentUser->isNobody());

    if($core->rq->fr != "") {
        $l = new Library($core->rq->fr);
        echo $l->Run(true);
    } else {
        
        $site = $core->nav->site;
        if(!is_null($core->nav->folder))
            $site->LoadFolder($core->nav->folder);
        header("Pragma: no-cache");
        
        /*store the stats*/
        //$core->stats->Store($site, is_null($site->folder) ? $site : $site->folder, $gpublication);
        $body = $site->render();
        echo $body;
        
        $startTime2 = microtime(true);
        
        $tm1 = (int)(($startTime1 - $startTime0) * 1000);
        $tm2 = (int)(($startTime2 - $startTime1) * 1000);
        $tm3 = (int)(($startTime2 - $startTime0) * 1000);
        
        //out($tm1, $tm2, $tm3);
            

    }

?>