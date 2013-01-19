<?php
/**
 * class Core
 * includes database connection, request pasrsing and etc.
 */
 
class Core {
	
	public $serviceMode;
	public $securityMode;
	public $sessionEnabled;
	public $moduleEnabled;
	
    public $driver;
	public $server;
	public $database;
	public $user;
	public $password;
	
	public $sitePath;
	public $corePath;
	public $adminPath;
	public $mysqlBinDir;
	public $blobViewerUrl;
	public $Language;
	public $obenabled;
	public $obenconding;
	
	public $browserInfo;
	
	public $dbe;
	public $sts;
	public $rq;
	public $fs;	
	public $debug;
    public $nav;
	/**                     
	 * DEPRECATED (DO NOT USE)
	 */
	public $security;
	public $ob;
	public $stats;
	public $ed;
	public $ie;
	
	public $isAdmin;
	
	/**
		* Constructor.  
		*
		* @param
		*		server = ""
		*		$database = ""
		*		$user = ""
		*		$password = ""
		* @return 
		*/
	public function Core($server = "", $database = "", $user = "", $password = "", $driver = 'mysql') {
		
		global $SERVICE_MODE, $SECURITY_MODE, $SESSION_ENABLED, $MODULE_ENABLED;
		
        if(@$argc > 0) {
            // /mobile/ key=value key=value key=value...
            
            $_SERVER['SCRIPT_FILENAME'] = getcwd().'/'.__FILE__;
            $_SERVER['REQUEST_URI']=$argv[2];
            $_SERVER['REDIRECT_URL']=$argv[2];
            $_SERVER['SERVER_NAME']=$argv[1];
            $_SERVER['SERVER_PORT']=80;
            $_SERVER['SCRIPT_NAME']=__FILE__;
            for($i=3;$i<$argc;$i++){
            // key=value
                $kv = explode("=", $argv[$i]);
                $_GET[$kv[0]] = $kv[1];
            }

            if(strstr($_SERVER['REDIRECT_URL'], '.php') !== false) {
                preg_match("/\/(.*)\.php/i", $_SERVER['REDIRECT_URL'], $matches);
                if(count($matches) > 0) {
                    $_GET['fr'] = $matches[1];

                }
            }
            
        }        
        
		$this->isAdmin = false;
		
		if(substr($_SERVER["SCRIPT_NAME"], 0, 6) == "/admin") {
			$this->serviceMode = DEVELOPING;
			
			if(isset($SERVICE_MODE)) 
				$this->serviceMode = $SERVICE_MODE;
			
			$this->securityMode = SECURITYMODE_EMBEDED;	
			$this->sessionEnabled = true;
			$this->moduleEnabled = true;
			$this->isAdmin = true;
		}
		else {
			
			if(isset($SERVICE_MODE)) 
				$this->serviceMode = $SERVICE_MODE;
			else
				$this->serviceMode = DEVELOPING;

			if(isset($SECURITY_MODE))
				$this->securityMode = $SECURITY_MODE;
			else
				$this->securityMode = SECURITYMODE_EMBEDED;	

			if(isset($SESSION_ENABLED))
				$this->sessionEnabled = $SESSION_ENABLED;
			else
				$this->sessionEnabled = true;
				
			if(isset($MODULE_ENABLED)) 
				$this->moduleEnabled = $MODULE_ENABLED;
			else
				$this->moduleEnabled = true;
				
		}
			
		if($this->sessionEnabled)
			@session_start();		
		
        $this->driver = $driver;
		$this->server = $server;
		$this->database = $database;
		$this->user = $user;
		$this->password = $password;
		
	}
	
	private function _detectBrowserInfo() {
		$this->browserInfo = new Object();
		$this->browserInfo->name = browser_detection('browser');
		$this->browserInfo->version = browser_detection('number');
		$this->browserInfo->os = browser_detection( 'os' );
		$this->browserInfo->os_version = browser_detection( 'os_number' );
		$this->browserInfo->type = browser_detection( 'type' );
		$this->browserInfo->isIE6 = ($this->browserInfo->name == "ie" && $this->browserInfo->version < 7);
        $this->browserInfo->isIE7 = ($this->browserInfo->name == "ie" && $this->browserInfo->version == 7);
        $this->browserInfo->isIE = ($this->browserInfo->isIE6 || $this->browserInfo->isIE7);
        $this->browserInfo->isOpera = ($this->browserInfo->name == "op");
	}
	
	public function initialize($server = "", $database = "", $user = "", $password = "", $driver = 'mysql') {
		
        global $SITE_PATH;
        chdir($SITE_PATH);
        
		$this->_detectBrowserInfo();

        if(!empty($driver)) $this->driver = $driver;
		if(!empty($server)) $this->server = $server;
		if(!empty($database)) $this->database = $database;
		if(!empty($user)) $this->user = $user;
		if(!empty($password)) $this->password = $password;
		
		// set the onExit event to correctly free core memory
		// register_shutdown_function("onExit");
		
		// Instancing
        $drv = $this->driver."Driver";
        
        $driver = new $drv();
		$this->dbe = new DBEngine($driver); // database
        $this->dbe->Connect($this->server, $this->user, $this->password, $this->database, true);
		//$this->dbe->connect($this->server, $this->database, $this->user, $this->password, true, $this->driver);
		// $this->dbe->setutf8();
		
        $tables = $this->dbe->Tables();
        if($tables->Count() == 0) {
            // this is a new Databse create a pioneer scheme
            $this->dbe->scheme->CreateScheme();
            $this->dbe->scheme->InsertInitialData();
        }   

		// Util
		
        /*if($this->serviceMode == DEVELOPING && @$this->checkIntegrity)
		    $this->checkDatabaseIntegrity(); // check intergrity & check for existence of some fields and tables, and creates it if not exist
		*/
        Repository::Cache();
        
		// Instancing
		if($this->serviceMode == DEVELOPING)
			$this->debug = new Debug();
		else
			$this->debug = null;
		
		$this->ed = CEventDispatcher::Instance(); // event dispatcher
		
		if($this->moduleEnabled)	
			$this->mm = CModuleManager::Instance(); // module manager
		
		$this->ob = new ob(); // buffering
		
		$this->rq = new Request(); // request vars
		
		$this->fs = new FileSystem(); // file system
		
		$this->sts = New Settings(); // get the settings from database

        $this->nav = new Navigator();
        
		if($this->securityMode == SECURITYMODE_EMBEDED)
			$this->security = new SecurityEx(); // security module
		else
			$this->security = null;

		$this->stats = new Statistics(); // statisctics
		
		$this->ie = new IndexEngine();
		
		// Registering events
		if (method_exists($this->ob, "RegisterEvents")) $this->ob->RegisterEvents();
		if (method_exists($this->rq, "RegisterEvents")) $this->rq->RegisterEvents();
		if (method_exists($this->fs, "RegisterEvents")) $this->fs->RegisterEvents();
		if (method_exists($this->dbe, "RegisterEvents")) $this->dbe->RegisterEvents();
		if (method_exists($this->sts, "RegisterEvents")) $this->sts->RegisterEvents();
		if($this->security) 
            if (method_exists($this->security, "RegisterEvents")) $this->security->RegisterEvents();
		if (method_exists($this->stats, "RegisterEvents")) $this->stats->RegisterEvents();
		if (method_exists($this->ie, "RegisterEvents")) $this->ie->RegisterEvents();
			
		// Registering event handlers
		if (method_exists($this->ob, "RegisterEventHandlers")) $this->ob->RegisterEventHandlers();
		if (method_exists($this->rq, "RegisterEventHandlers")) $this->rq->RegisterEventHandlers();
		if (method_exists($this->fs, "RegisterEventHandlers")) $this->fs->RegisterEventHandlers();
		if (method_exists($this->dbe, "RegisterEventHandlers")) $this->dbe->RegisterEventHandlers();
		if (method_exists($this->sts, "RegisterEventHandlers")) $this->sts->RegisterEventHandlers();
		if($this->security)
	 		if (method_exists($this->security, "RegisterEventHandlers")) $this->security->RegisterEventHandlers();
		if (method_exists($this->stats, "RegisterEventHandlers")) $this->stats->RegisterEventHandlers();
        if (method_exists($this->ie, "RegisterEventHandlers")) $this->ie->RegisterEventHandlers();
		
		// Initializing
		$this->ob->Initialize();
		$this->rq->Initialize();
		$this->fs->Initialize();
		$this->dbe->Initialize();
		$this->sts->Initialize(true);
		if($this->security)
			$this->security->Initialize();
		$this->stats->Initialize();
		
        if($this->moduleEnabled)
			$this->mm->Initialize();
		
        $this->ie->Initialize();
		
		$this->languages = new collection(); // resources
		$r = $this->dbe->ExecuteReader("select * from sys_languages");
		while($lang = $r->Read())
			$this->languages->add($lang->language_id, $lang->language_view);
		    
        
	}
	
	public function __destruct() {
	    $this->Dispose();
	}
	
	public function serialize($bload = false) {
		if(!is_object($this->rq))
			$this->rq = new Request();
		if(!$bload) {
	  		$this->rq->sitePath = $this->sitePath;
			$this->rq->blobViewerUrl = $this->blobViewerUrl;
			$this->rq->siteLanguage = $this->Language;
			$this->rq->obenabled = $this->obenabled;
			$this->rq->obenconding = $this->obenconding;
			$this->rq->server = $this->server;
			$this->rq->database = $this->database;
			$this->rq->user = $this->user;
			$this->rq->password = $this->password;
		}
		else {
			$this->server = $this->rq->server;
			$this->database = $this->rq->database;
			$this->user = $this->rq->user;
			$this->password = $this->rq->password;
	  		$this->sitePath = $this->rq->sitePath;
			$this->blobViewerUrl = $this->rq->blobViewerUrl;
			$this->Language = $this->rq->siteLanguage;
			$this->obenabled = $this->rq->obenabled;
			$this->obenconding = $this->rq->obenconding;
		}
	}
	
	public function get_database() {
		return $this->database;
	}
	
	public function abandone() {
		@session_destroy();
	}
	
	function Dispose() {
        
        unset($this->browserInfo);
        //$this->abandone();
        $this->dbe->disconnect();
        if($this->debug)
            $this->debug->Dispose();
        $this->ed->Dispose();
        if($this->mm) $this->mm->Dispose();
        $this->ob->Dispose();
        $this->rq->Dispose();
        $this->fs->Dispose();
        $this->sts->Dispose();
        if($this->security)
            $this->security->Dispose();
        $this->stats->Dispose();
        $this->ie->Dispose();
        
    }
                      
}
              
?>