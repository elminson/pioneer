<?

class Statistics {
    
    private $statstable;
    private $statsarchtable;
    private $createstatement;
    private $createstatement1;
    
    function Statistics() {
        
    }
    
    public function RegisterEvents(){
        
    }
    
    public function RegisterEventHandlers(){
        
    }
    
    public function Dispose() {
        
    }
    
    public function Initialize(){
        global $core;
        
        $this->statstable = sys_table("statistics");
        $this->statsarchtable = sys_table("statsarchive");
        
        if(!$core->dbe->tableexists($this->statstable)){
            $core->dbe->CreateTable($this->statstable, array(
                    'stats_date' => array('type' => 'double', 'additional' => ' NOT NULL default \'0\''),
                    'stats_site' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_folder' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_publication' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_country_code' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_country_code3' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_country_name' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_region' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_city' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_remoteaddress' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_localaddress' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_session' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_os' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_os_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser_type' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_referer_domain' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_referer_query' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
                    'stats_querystring' => array('type' => 'longtext', 'additional' => ' NOT NULL'), 
                    'stats_cookie' => array('type' => 'longtext', 'additional' => ' NOT NULL')
                )
            , array(), '');
        }

        if(!$core->dbe->tableexists($this->statsarchtable)){
            $core->dbe->CreateTable($this->statsarchtable, array(
                    'stats_date' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_archive' => array('type' => 'longtext', 'additional' => '')
                )
            , array(), '');
        }
    }
    
    function Store($site, $folder, $publication) {
        global $core;
        
        if(is_object($publication))
            $publication = $publication->id;

        $svars = $core->rq->get_collection(VAR_SERVER);
        $binfo = $core->browserInfo;
        $cookie = $core->rq->get_collection(VAR_COOKIE);

        $uri = $svars->script_uri;
        if(preg_match("/\/admin/", $uri) > 0)
            return;
        
        $c = new Hashtable();
        $c->FromString($svars->query_string, "&", "=");
        $c->Delete("folder");
        $c->Delete("publication");
        $querystring = $c->ToString("&", "=");
        
        $data = new collection();
        $data->stats_date = microtime(true);
        $data->stats_site = $site->id;
        $data->stats_folder = $folder->id;
        $data->stats_publication = is_empty($publication) ? 0 : $publication;
        $data->stats_remoteaddress = remoteip();
        $data->stats_localaddress = localip();
        $geoInfo = Geo::RecordByIP($data->stats_remoteaddress);
        $data->stats_country_code = $geoInfo->country_code;
        $data->stats_country_code3 = $geoInfo->country_code3;
        $data->stats_country_name = $geoInfo->country_name;
        $data->stats_region = $geoInfo->region;
        $data->stats_city = $geoInfo->city;
        $data->stats_session = session_id();
        $data->stats_browser = $binfo->name;
        $data->stats_browser_version = $binfo->version;
        $data->stats_browser_type = $binfo->type;
        $data->stats_os = $binfo->os;
        $data->stats_os_version = $binfo->os_version;
        
        $referer1 = $svars->http_referer;
        $referer = preg_split("/\//", $referer1);
        if(count($referer) > 3) {
            $domain = @$referer[2];
            $query = substr($referer1, strlen($referer[0]."/".$referer[1]."/".$referer[2]));
            $data->stats_referer_domain = $domain;
            $data->stats_referer_query = $query;
        } else {
            $data->stats_referer_domain = "";
            $data->stats_referer_query = "";
        }
        $data->stats_querystring = $querystring;
        $data->stats_cookie = $cookie->ToString();

        $core->dbe->insert($this->statstable, $data);

    }
    
    function Clear($datestart = 0, $dateend = 9999999999) {
        global $core;
        $core->dbe->query("delete from ".$this->statstable." where stats_date > ".$datestart." and stats_date < ".$dateend);
    }
    
    public static function getOperations() {
        $operations = new Operations();
        $operations->Add(new Operation("statistics.view", "View statistics"));
        $operations->Add(new Operation("statistics.clear", "Clear statistics"));
        $operations->Add(new Operation("statistics.logs.view", "View server logs"));
        $operations->Add(new Operation("statistics.logs.clear", "Clear server logs"));
        return $operations;
    }
    
    public function getStatsByDate($time = null, $type = STATS_ALL, $period = STATS_TODAY, $getbots = false) {
        
        global $core;
        
         $now = $time;
        if(is_null($now))
            $now = time();
        
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        
        /*
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
        */
        
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$now."))";
        
        $r = $core->dbe->ExecuteReader("select count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where);
        if($r->Count() > 0) {
            $ret = Hashtable::Create($r->Read()->Data());
            $r = $core->dbe->ExecuteReader("select count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." and stats_browser_type='bot'");
            if($r->Count() > 0)
                $ret->bots = $r->Read()->Data();
            else {
                $ret->bots = new stdClass();
                $ret->bots->hits = 0;
                $ret->bots->hosts = 0;
                $ret->bots->sessions = 0;
            }        
            return $ret;
        }
        else
            return null;
    }
    
    public function getStatsByPage($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        
        $now = $time;
        if(is_null($now))
            $now = time();
        
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
            
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$now."))";
        $r = $core->dbe->ExecuteReader("select stats_site, stats_folder, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_site, stats_folder");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
        
    }
        
    public function getStatsByReferer($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        
        $now = $time;
        if(is_null($now))
            $now = time();
        
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
            
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$now."))";
        $r = $core->dbe->ExecuteReader("select stats_referer_domain, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_referer_domain");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
        
    }

    public function getStatsByBrowser($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        
        $now = $time;
        if(is_null($now))
            $now = time();
        
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
            
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$now."))";
        $r = $core->dbe->ExecuteReader("select stats_browser, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_browser");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
        
    }

    public function getStatsByOS($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        
        $now = $time;
        if(is_null($now))
            $now = time();
        
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
            
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$now."))";
        $r = $core->dbe->executeReader("select stats_os, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_os");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
        
    }

    public function getStatsByRegions($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        
        $now = $time;
        if(is_null($now))
            $now = time();
        
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
            
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$now."))";
        $r = $core->dbe->executeReader("select stats_country_code, stats_country_name, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_country_code, stats_country_name");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
        
    }
    
    public function getStatsBySearchQuery($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        
        $now = $time;
        if(is_null($now))
            $now = time();
        
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
            
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$now.")) and stats_querystring REGEXP '^q=[^&]*$'";
        global $INDEX_SEARCHFOLDER;
        
        $rrr = '';
        $rs = $core->dbe->executeReader("select distinct tree_id from sys_tree where tree_name='".$INDEX_SEARCHFOLDER."'");
        while($rr = $rs->Read()) {
            $rrr .= ",".$rr->tree_id;
        }
        
        if($rrr != "")
            $where .= " and stats_folder in (".substr($rrr, 1).")";
        
        $r = $core->dbe->executeReader("select stats_querystring, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_querystring");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
        
    }
    

    public function GetStatsArchive($time = null) {
        global $core;
        
        $tdstart = strtotime(strftime("%d.%m.%Y", time()));
        $dstart = strtotime(strftime("%d.%m.%Y", $time));
        if($tdstart == $dstart) {
            // it is today and not realy need to archive this
            return $this->GetCompleteStats($time);
        }
        
        $where = "DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$time."))";
        $r = $core->dbe->executeReader("select * from ".$this->statsarchtable." where ".$where);
        return @unserialize($r->Read()->stats_archive);
    }
    
    public function ArchiveAll($completedata = null) {
        global $core;
        $r = $core->dbe->ExecuteReader("select distinct UNIX_TIMESTAMP(DATE(UNIX_TIMESTAMP(stats_date))) as dd from ".$this->statstable." where not DATE(UNIX_TIMESTAMP(stats_date) = DATE(UNIX_TIMESTAMP(".time().")))");
        while($rr = $r->Read()) {
            if($rr->dd > 0)
                $this->ArchiveDayStats($rr->dd+86300);  
        }
    }

    public function GetCompleteStats($time) {
        $completedata = new Collection();
        $completedata->Add("daystats", $this->getStatsByDate($time ,STATS_ALL, STATS_TODAY));
        //$completedata->Add("yesterdaystats", $this->getStatsByDate($time-86400,STATS_ALL, STATS_TODAY));
        //$completedata->Add("weekstats", $this->getStatsByDate($time,STATS_ALL, STATS_LASTWEEK));
        //$completedata->Add("monthstats", $this->getStatsByDate($time,STATS_ALL, STATS_LASTMONTH));
        $completedata->Add("pages", $this->getStatsByPage($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("domains", $this->getStatsByReferer($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("browsers", $this->getStatsByBrowser($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("os", $this->getStatsByOS($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("regions", $this->getStatsByRegions($time, STATS_ALL, STATS_TODAY));
        global $INDEX_ANALIZESEARCHQUERIES;
        if($INDEX_ANALIZESEARCHQUERIES) {
            $completedata->Add("search", $this->getStatsBySearchQuery($time, STATS_ALL, STATS_TODAY));
        }
        
        return $completedata;
    }
    
    public function ArchiveDayStats($time = null, $completedata = null) {
        global $core;

        if(is_null($completedata)) {
            $completedata = $this->GetCompleteStats($time);
        }

        //$core->dbe->StartTrans();
        
        $completedata = serialize($completedata);
        $data = new collection();
        $data->stats_date = $time;
        $data->stats_archive = $completedata;
        $core->dbe->insert($this->statsarchtable, $data);
        
        $core->dbe->Query("delete from ".$this->statstable." where DATE(UNIX_TIMESTAMP(stats_date)) = DATE(UNIX_TIMESTAMP(".$time."))");
        
        //$core->dbe->CompleteTrans();
        return true;
    }


    public function GetStats($date, $period = STATS_LASTWEEK) {
        
        $istatPeriod = 8;
        if($period == STATS_LASTMONTH) {
            $istatPeriod = 31;
        }
        
        $todays = new Hashtable();
        for($i=1; $i<$istatPeriod; $i++) {
            $name = "today".$i;
            $todays->$name  = $this->GetStatsArchive($date-86400*$i);
        }
        
        $ret = new Hashtable();
        $ret->hits = 0;
        $ret->hosts = 0;
        $ret->sessions = 0;
        $ret->bots = new Hashtable();
        $ret->bots->sessions = 0;
        $ret->bots->sessions = 0;
        $ret->bots->sessions = 0;
        for($i=1; $i<$istatPeriod; $i++) {
            $name = "today".$i;
            $todays->$name  = $this->GetStatsArchive($date-86400*$i);
            $ret->hits += @$todays->$name->daystats->hits;
            $ret->hosts += @$todays->$name->daystats->hosts;
            $ret->sessions += @$todays->$name->daystats->sessions;
            $ret->bots->hits += @$todays->$name->daystats->bots->hits;
            $ret->bots->hosts += @$todays->$name->daystats->bots->hosts;
            $ret->bots->sessions += @$todays->$name->daystats->bots->sessions;
        }
        
        return $ret;
    }
    
}

?>
