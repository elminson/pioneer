<?

function sys_table($t){
	return SYSTABLE_PREFIX."_".$t;
}

class DBEngine {

	private $mIDENTITYCOL;
	
	private $_tables;
	private $_tablefields;
    
    private $_driver;   
    
    private $_scheme;

	public function DBEngine($driver) {
		
        $this->mIDENTITYCOL = "Id";
        $this->_driver = $driver;
        $this->_scheme = new PioneerScheme($this);
        
	}

	public function __destruct() {
		// ...
		$this->_driver->Disconnect();
		
	}

	public function Initialize(){
        
	}
	
	public function __get($prop) {
		switch($prop) {
            case "driver":
                return $this->_driver;
			case "queried":
				return $this->_driver->queryCache;
			case "cached":
				return $this->_driver->resourceCache;
            case "scheme":
                return $this->_scheme;
		}
	}
	
	public function connect($server, $database, $user, $password, $persistence = true) {
        $this->_driver->Connect($server, $database, $user, $password, $persistence);
        $this->CreateDefaultSchema();
	}
	
	public function disconnect() {
		$this->_driver->Disconnect();
	}
	
	/*private members*/
	public function fetch_object($r) {
		return $this->_driver->fetch_object($r);
	}

	public function fetch_array($r) {
		return $this->_driver->fetch_array($r);
	}

	public function fetch_field($r, $i) {
		return $this->_driver->fetch_field($r, $i);
	}
	
	public function num_rows($r) {
		return $this->_driver->num_rows($r);
	}

	public function num_fields($r) {
		return $this->_driver->num_fields($r);
	}

    public function free_result($r) {
        return $this->_driver->free_result($r);
    }
	
	/*public memebers*/
	public function Query($q) {
        return $this->_driver->Query($q);
	}

	public function InsertId($query = false) {
		/*if($query) {
			$q = "SELECT LAST_INSERT_ID() as id";
			$r = $this->Query($q);
			$rr = $this->fetch_object($r);
			return $rr->id;
		}
		else {*/
		return $this->_driver->insert_id();
		/*}*/
	}
	
	public function Affected($res = null){
		return $this->_driver->affected($res);
	}

	public function Error() {
		return $this->_driver->Error();
	}

    public function RecordCount($query) {
        $cntQuery = $this->_driver->CreateCountQuery($query);
        $r = $this->_driver->Query($cntQuery);
        $rr = $this->_driver->fetch_object($r);
        return $rr->cnt;
    }
    
	public function QueryPage($q, $identity = "", $page, $pagesize) {
		$affected = $this->RecordCount($q);
        
        $q = $this->_driver->AppendLimitCondition($q, $page, $pagesize);

		$recordset = $this->Execute($q, $identity, false);
		$recordset->affected = $affected;
		return $recordset;
	}
    
    public function AppendLimitCondition($q, $page, $pagesize) {
        return $this->_driver->AppendLimitCondition($q, $page, $pagesize);
    }

    public function ExecuteReader($q, $page = -1, $pagesize = 10) {
        if($page > 0) {
            $affected = $this->RecordCount($q);
            $q = $this->_driver->AppendLimitCondition($q, $page, $pagesize);
            $reader = new DataReader($this->Query($q), $this->_driver);
            $reader->affected = $affected;
        }
        else {
            $reader = new DataReader($this->Query($q), $this->_driver);
        }
            
        return $reader;
    }
    
	public function Execute($q, $identity = "", $noreturn = false) {
		if(!$noreturn) {
			$tmp = new Recordset($this->Query($q), $identity) or die("Could not execute a query : ".$this->error());
			$tmp->affected = $tmp->Count();
			return $tmp;
		}
		else {
			$ret = $this->query($q);
			if(!$ret)
				return false;
			else
				return true;
		}
	}

	public function Get($table, $field, $idfield, $id) {
		if(!is_array($field)) {
			if(is_integer($id))
				$q = "select $field from $table where $idfield=$id";
			else
				$q = "select $field from $table where $idfield='$id'";
		}
		else {
			$qs = "select ";
			$qe = " from $table where $idfield='$id'";

			for($i=0; $i<count($field); $i++) {
				$q = $q. $fields[$i] . " ,";
			}
			$q = substr($q, 0, strlen($q)-1);

			$q = $qs.$q.$qe;
		}

		$tmp = $this->query($q);
		if($tmp) {
			$res = $this->fetch_object($tmp);
			if(!is_array($field) && $field != "*"){
				return $res->$field;
			} else {
				return $res;
			}
		}
		else
			return false;
	}

	public function Set($table, $idfield, $id, $data) {
		return $this->Update($table, $idfield, $id, $data);
	}

	public function Update($table, $idfield, $id, $data, $setautoincrement = false) {   //id -> may by array
		if (is_array($id)){
			$qe = "where $idfield in ('".implode("', '", $id)."')";
		} else {
			$qe = "where $idfield='$id'";
		}
		
		$qs = "update $table set ";

        $fields = $this->Fields($table);
		$sql_set = '';
		$dt = $data;
		foreach($dt as $k=>$v) {
			if(is_null($v))
				$sql_set .= ','.$this->_driver->EscapeFieldNames($k).'=null';				
			else
				$sql_set .= ','.$this->_driver->EscapeFieldNames($k).'='.$this->_driver->EscapeFieldValue($fields->$k, $v);
		}

		$sql_set=substr($sql_set, 1);
		$sql_set = $qs." ".$sql_set." ".$qe;
		
		$ret = ($this->query($sql_set) !== false);
        
        if($setautoincrement) {
            $this->_driver->SetAutoincrement($table, $idfield);
        }
        
        return $ret;
	}
    
    public function SetAutoincrement($table, $idfield) {
        return $this->_driver->SetAutoincrement($table, $idfield);
    }

	public function SetBin($table, $idfield, $id, $field, $value) {
        return $this->_driver->UpdateBinaryField($table, $idfield, $id, $field, $value);
	}
    
	public function Delete($table, $idfield, $id) {
		$q = "delete from ".$table." where ".$idfield."='".$id."'";
		return ($this->query($q) !== false);
	}

	public function Insert($table, $data = null) {
		if($data != null) {
			$fld_names = "";
			$fld_values = "";
			if($data != null) {  
                $fields = $this->Fields($table);
            	$fld_names = implode(',', $data->keys());
				foreach($data as $k => $v) {
                    $fld_values .= ','.$this->_driver->EscapeFieldValue($fields->$k, $v);
				}
				$fld_values = substr($fld_values, 1);
			}
			$q = "insert into ".$table."(".$this->_driver->EscapeFieldNames($fld_names).") values(".$fld_values.")";
		}
		else
			$q = "insert into ".$table." default values";
	    
		$tmp = $this->query($q);
		if($tmp !== false)
			return $this->_driver->insert_id($table);
		else {
			return false;
		}
	
	}
    
	public function Exists($table, $field, $value) {
		if(is_numeric($value))
			$rs = $this->query("SELECT count(*) as c FROM ".$table." WHERE (".$field." = ".$value.")");
		else
			$rs = $this->query("SELECT count(*) as c FROM ".$table." WHERE (".$field." = '".$value."')");
		$r = $this->fetch_object($rs);
		return ($r->c > 0);
	}

	public function TableExists($table, $recache = false) {
		return $this->Tables($recache)->Exists($table);
	}

	public function TableEmpty($table) {
		global $core;
		
		$rs = $this->query("select count(*) as size from ".$table."");
		$r = $this->fetch_object($rs);
		
		return (intval($r->size) == 0);
	}
    
    public function CountRows($table) {
        return $this->_driver->CountRows($table);
    }
        
    public function TruncateTable($table) {
        return $this->_driver->TruncateTable($table);
    }
	
	function Max($table, $field) {
		$rs = $this->query("select max(".$field.") as m from ".$table);
		$r = $this->fetch_object($rs);
		return $r->m;
	}

	/*transactions*/
	function CompleteTrans() {
        $this->_driver->CompleteTrans();
	}

	function FailTrans() {
        $this->_driver->FailTrans();
	}

	function StartTrans() {
        $this->_driver->BeginTrans();
	}
	
	/*structure functions*/
	public function Tables($recache = false) {
        
        if(is_null($this->_tables))
            $this->_tables = new Hashtable();
        
/*        if($recache)
            iout(debug_backtrace());
*/        
        if($this->_tables->Count() == 0 || $recache) {
            $tables = $this->_driver->ListTables();
		    while($r = $this->_driver->fetch_object($tables)) {
                $name = "Tables_in_".$this->_driver->database;
                $value = @$r->$name;
                if(!$value) {
                    $name = strtolower($name);
                    $value = @$r->$name;
                }
			    $this->_tables->Add($value, $value);
		    }
        }
		return $this->_tables;
	}
	
	public function Fields($table, $recache = false) {
		
		if(!$this->_tablefields)
			$this->_tablefields = new Collection();

		if($this->_tablefields->Exists($table) && !$recache)
			return $this->_tablefields->Item($table);
		
		$ret = new collection();
		$r = $this->_driver->ListFields($table);
		while($rr = $this->fetch_array($r)) {
			$field = new Collection($rr);
			$ret->add($field->field, $field);
		}
		$this->_tablefields->Add($table, $ret);
		
		return $ret;
	}
	
	public function AddField($table, $column, $type, $null = true, $default = null) {
        return $this->_driver->AddField($table, $column, $type, $null, $default);
	}

	public function AlterField2($table, $column, $columnNew, $type, $null = true, $default = null) {
        return $this->_driver->AlterField2($table, $column, $columnNew, $type, $null, $default);
	}

	public function AlterField($table, $column, $type, $null = true, $default = null) {
        return $this->_driver->AlterField($table, $column, $type, $null, $default);
	}
	
	public function RemoveField($table, $column) {
        return $this->_driver->RemoveField($table, $column);
	}
    
    public function CreateTable($name, $fields, $indices, $ads, $temp = false, $return = false) {
        $v = $this->_driver->CreateTable($name, $fields, $indices, $ads, $temp, $return);
        $this->Tables(true);
        return $v;
    }
    
    public function CreateTableAs($name, $query, $temp = false, $fields=false) {
        $v = $this->_driver->CreateTableAs($name, $query, $temp, $fields);
        $this->Tables(true);
        return $v;
    }

    public function DropTable($name, $return = false) {
        if($this->TableExists($name))
            return $this->_driver->DropTable($name, $return);
        return false;
    }
    
    public function PrepareRowData($table, $row) {
        return $this->_driver->PrepareRowData($this->Fields($table), $row);
    }
    
	// get system stypes
    function SystemTypes() {
        return $this->driver->SystemTypes();
    }

    function Type2System() {
        return $this->driver->Type2System();
    }

    public function CreateDefaultSchema() {
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs", array(
            "blobs_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "blobs_alt" => array('type' => 'longvarchar', 'additional' => ' NULL'), 
            "blobs_category" => array('type' => 'longvarchar', 'additional' => ' NULL'), 
            "blobs_filename" => array('type' => 'longvarchar', 'additional' => ' NULL'), 
            "blobs_type" => array('type' => 'shortvarchar', 'additional' => ' NULL'), 
            "blobs_parent" => array('type' => 'bigint', 'additional' => ' DEFAULT -1 NOT NULL'), 
            "blobs_isfolder" => array('type' => 'boolean' , 'additional' => 'DEFAULT \'0\' NOT NULL'), 
            "blobs_bsize" => array('type' => 'bigint', 'additional' => ' DEFAULT 0'), 
            "blobs_securitycache" => array('type' => 'longtext', 'additional' => ' NULL'), 
            "blobs_lastaccessed" => array('type' => 'timestamp', 'additional' => ' NULL'), 
            "blobs_width" => array('type' => 'bigint', 'additional' => ' NULL'), 
            "blobs_height" => array('type' => 'bigint', 'additional' => ' NULL'), 
            "blobs_modified" => array('type' => 'timestamp', 'additional' => ' NULL')
        ), array(
            "sys_blobs_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "blobs_id")
        ), ""));
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs_cache", array(
            "blobs_cache_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "blobs_cache_blobs_id" => array('type' => 'bigint', 'additional' => 'DEFAULT 0'), 
            "blobs_cache_date" => array('type' => 'timestamp', 'additional' => 'DEFAULT CURRENT_TIMESTAMP'), 
            "blobs_cache_width" => array('type' => 'bigint', 'additional' => 'DEFAULT 0'), 
            "blobs_cache_height" => array('type' => 'bigint', 'additional' => 'DEFAULT 0'), 
            "blobs_cache_data" => array('type' => 'blob', 'additional' => ' NULL')
        ), array(
            "sys_blobs_cache_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "blobs_cache_id")
        ), ""));
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs_categories", array(
            "category_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "category_parent" => array('type' => 'bigint', 'additional' => 'DEFAULT -1'), 
            "category_description" => array('type' => 'longvarchar', 'additional' => 'DEFAULT \'\''), 
            "category_securitycache" => array('type' => 'longtext', 'additional' => ' NULL')
        ), array(
            "category_id" => array("constraint" => "PRIMARY KEY", "fields" => "category_id")
        ), ""));
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs_data", array(
            "blobs_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "blobs_data" => array('type' => 'blob', 'additional' => ' NULL')
        ), array(
            "sys_blobs_data_id" => array("constraint" => "UNIQUE", "fields" => "blobs_id")
        ), ""));
    
        $this->_scheme->Add(new PioneerSchemeTable("sys_index", array(
            "index_site" => array('type' => 'bigint', 'additional' => ' NOT NULL'),
            "index_folder" => array('type' => 'bigint', 'additional' => ' NOT NULL'), 
            "index_publication" => array('type' => 'bigint', 'additional' => ' NOT NULL'),
            "index_word" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL'),
            "index_language" => array('type' => 'varchar2', 'additional' => ' NOT NULL')
        ), array(
            "sys_index_word" => array("constraint" => "", "fields" => "index_word")
        ), ""));
          
        $this->_scheme->Add(new PioneerSchemeTable("sys_index_words", array(
            "index_word_id" => array('type' => 'autoincrement', 'additional' => ''),
            "index_word" => array('type' => 'longvarchar', 'additional' => ' NOT NULL')
        ), array(
            "sys_index_words_word_id" => array("constraint" => "PRIMARY KEY", "fields" => "index_word_id"),
            "sys_index_words_word" => array("constraint" => "", "fields" => "index_word")
        ), ""));
    
        $this->_scheme->Add(new PioneerSchemeTable("sys_languages", array(
            "language_id" => array('type' => 'varchar2', 'additional' => ' NOT NULL'),
            "language_view" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL')
        ), array(
            "sys_languages_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "language_id")
        ), ""));
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_links", array(
            "link_id" => array('type' => 'autoincrement', 'additional' => ''),
            "link_parent_storage_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_parent_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_child_storage_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_child_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_creationdate" => array('type' => 'timestamp', 'additional' => ' NOT NULL DEFAULT CURRENT_TIMESTAMP'),
            "link_order" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_template" => array('type' => 'longvarchar', 'additional' => ' NULL'),
            "link_object_type" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_propertiesvalues" => array('type' => 'longtext', 'additional' => ' NULL'),
            "link_modifieddate" => array('type' => 'timestamp', 'additional' => ' NULL')
        ), array(
            "sys_links_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "link_id"),
            "sys_links_order" => array("constraint" => "", "fields" => "link_order")
        ), ""));
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_module_templates", array(
            "module_templates_id" => array('type' => 'autoincrement', 'additional' => ''),
            "module_templates_name" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "module_templates_module_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_templates_list" => array('type' => 'longtext', 'additional' => ' NULL'),
            "module_templates_properties" => array('type' => 'longtext', 'additional' => ' NULL'),
            "module_templates_styles" => array('type' => 'longtext', 'additional' => ' NULL'),
            "module_templates_composite" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_templates_description" => array('type' => 'longvarchar', 'additional' => ' NULL'),
            "module_templates_cache" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_templates_cachecheck" => array('type' => 'longvarchar', 'additional' => ' NULL')
        ), array(
            "sys_module_templates_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "module_templates_id"),
            "sys_module_templates_name" => array("constraint" => "", "fields" => "module_templates_name")
        ), ""));  
                     
        $this->_scheme->Add(new PioneerSchemeTable("sys_modules", array(
            "module_id" => array('type' => 'autoincrement', 'additional' => ''),
            "module_order" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_state" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_entry" => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
            "module_title" => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
            "module_description" => array('type' => 'longtext', 'additional' => ' NULL'),
            "module_version" => array('type' => 'shortvarchar', 'additional' => ' NOT NULL DEFAULT \'1.0\''),
            "module_admincompat" => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            "module_compat" => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            "module_code" => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            "module_storages" => array('type' => 'longtext', 'additional' => ' NULL'),
            "module_libraries" => array('type' => 'longtext', 'additional' => ' NULL'),
            "module_type" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_haseditor" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_publicated" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_favorite" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_iconpack" => array('type' => 'longvarchar', 'additional' => ' NULL')
        ), array(
            "sys_modules_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "module_entry"),
            "sys_modules_entry" => array("constraint" => "UNIQUE", "fields" => "module_id")
        ), "")); 
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_notices", array(
            "notice_id" => array('type' => 'autoincrement', 'additional' => ''),
            "notice_keyword" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "notice_subject" => array('type' => 'longtext', 'additional' => ' NULL'),
            "notice_encoding" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "notice_body" => array('type' => 'longtext', 'additional' => ' NULL'),
            "notice_securitycache" => array('type' => 'longtext', 'additional' => ' NULL')
        ), array(
            "sys_notices_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "notice_id"),
            "sys_notices_keyword" => array("constraint" => "UNIQUE", "fields" => "notice_keyword")
        ), "")); 

        $this->_scheme->Add(new PioneerSchemeTable("sys_repository", array(
            "repository_id" => array('type' => 'autoincrement', 'additional' => ''),
            "repository_name" => array('type' => 'longvarchar', 'additional' => ' NULL'),
            "repository_type" => array('type' => 'shortvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "repository_code" => array('type' => 'longtext', 'additional' => ' NULL'),
            "repository_datemodified" => array('type' => 'longtext', 'additional' => ' NULL')
        ), array(
            "sys_repository_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "repository_id"),
            "sys_repository_name" => array("constraint" => "UNIQUE", "fields" => "repository_name")
        ), "")); 
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_resources", array(
            "resource_id" => array('type' => 'autoincrement', 'additional' => ''),
            "resource_name" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "resource_language" => array('type' => 'varchar2', 'additional' => ' NOT NULL DEFAULT \'en\''),
            "resource_value" => array('type' => 'longtext', 'additional' => ' NULL')
        ), array(
            "sys_resources_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "resource_id")
        ), "")); 
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_settings", array(
            "setting_id" => array('type' => 'autoincrement', 'additional' => ''),
            "setting_name" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "setting_value" => array('type' => 'longtext', 'additional' => ' NULL'),
            "setting_type" => array('type' => 'shortvarchar', 'additional' => ' NOT NULL DEFAULT \'memo\''),
            "setting_securitycache" => array('type' => 'longtext', 'additional' => ' NULL'),
            "setting_issystem" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "setting_category" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL DEFAULT \'\'')
        ), array(
            "sys_settings_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "setting_id"),
            "sys_settings_name" => array("constraint" => "UNIQUE", "fields" => "setting_name")
        ), "")); 
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_statistics", array(
                'stats_date' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
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
        , array(
            "sys_statistics_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "stats_date"),
        ), ''));        
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_statsarchive", array(
                'stats_date' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_archive' => array('type' => 'longtext', 'additional' => ' NULL')
            )
        , array(
            "sys_statsarchive_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "stats_date")
        ), ''));                
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_storage_fields", array(
                'storage_field_id' => array('type' => 'autoincrement', 'additional' => ''),
                'storage_field_storage_id' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'storage_field_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_field_field' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_field_type' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'text\''),
                'storage_field_default' => array('type' => 'longvarchar', 'additional' => ' DEFAULT NULL'),
                'storage_field_required' => array('type' => 'boolean', 'additional' => ' NOT NULL default \'0\''),
                'storage_field_showintemplate' => array('type' => 'boolean', 'additional' => ' NOT NULL default \'1\''),
                'storage_field_lookup' => array('type' => 'longtext', 'additional' => ' NULL'),
                'storage_field_order' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'storage_field_values' => array('type' => 'longtext', 'additional' => ' NULL'),
                'storage_field_group' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_field_onetomany' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_field_comment' => array('type' => 'longtext', 'additional' => ' NOT NULL default \'\'')
            )
        , array(
            "sys_storage_fields_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "storage_field_id"),
            "sys_storage_fields_field" => array("constraint" => "UNIQUE", "fields" => "storage_field_storage_id,storage_field_field"),
            "sys_storage_fields_name" => array("constraint" => "", "fields" => "storage_field_name"),
            "sys_storage_fields_storage" => array("constraint" => "", "fields" => "storage_field_storage_id")
        ), ''));  
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_storage_templates", array(
                'storage_templates_id' => array('type' => 'autoincrement', 'additional' => ''),
                'storage_templates_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_templates_storage_id' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'storage_templates_list' => array('type' => 'longtext', 'additional' => ' NULL'),
                'storage_templates_properties' => array('type' => 'longtext', 'additional' => ' NULL'),
                'storage_templates_composite' => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
                'storage_templates_styles' => array('type' => 'longtext', 'additional' => ' NULL'),
                'storage_templates_description' => array('type' => 'longvarchar', 'additional' => ' NULL'),
                'storage_templates_cache' => array('type' => 'boolean', 'additional' => ' NOT NULL default \'0\''),
                'storage_templates_cachecheck' => array('type' => 'longvarchar', 'additional' => ' NULL')
            )
        , array(
            "sys_storage_templates_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "storage_templates_id"),
            "sys_storage_templates_unique" => array("constraint" => "UNIQUE", "fields" => "storage_templates_storage_id,storage_templates_name"),
            "sys_storage_templates_name" => array("constraint" => "", "fields" => "storage_templates_name")
        ), ''));  
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_storages", array(
                'storage_id' => array('type' => 'autoincrement', 'additional' => ''),
                'storage_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
                'storage_table' => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
                'storage_securitycache' => array('type' => 'longtext', 'additional' => ' NULL'),
                'storage_color' => array('type' => 'shortvarchar', 'additional' => ' NULL'),
                'storage_group' => array('type' => 'longvarchar', 'additional' => ' NULL'),
                'storage_istree' => array('type' => 'boolean', 'additional' => ' not null default \'0\'')
            )
        , array(
            "sys_storages_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "storage_id"),
            "sys_storages_table" => array("constraint" => "UNIQUE", "fields" => "storage_table")
        ), ''));  
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_templates", array(
                'templates_id' => array('type' => 'autoincrement', 'additional' => ''),
                'templates_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
                'templates_head' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
                'templates_body' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_repositories' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_head_title' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_head_metakeywords' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_head_metadescription' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_head_baseurl' => array('type' => 'longvarchar', 'additional' => ' NULL'),
                'templates_head_styles' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_head_scripts' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_head_aditionaltags' => array('type' => 'longtext', 'additional' => ' NULL'),
                'templates_html_doctype' => array('type' => 'longtext', 'additional' => ' NULL')
            )
        , array(
            "sys_templates_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "templates_id"),
            "sys_templates_name" => array("constraint" => "UNIQUE", "fields" => "templates_id")
        ), ''));  
        
        $this->_scheme->Add(new PioneerSchemeTable("sys_tree", array(
                'tree_id' => array('type' => 'autoincrement', 'additional' => ''),
                'tree_left_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                'tree_right_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                'tree_level' => array('type' => 'bigint', 'additional' => 'NOT NULL DEFAULT 0'),
                'tree_sid' => array('type' => 'real', 'additional' => 'NULL DEFAULT 0'),
                'tree_published' => array('type' => 'boolean', 'additional' => 'NOT NULL DEFAULT \'0\''),
                'tree_name' => array('type' => 'longvarchar', 'additional' => ' NULL DEFAULT \'\''),
                'tree_keyword' => array('type' => 'longvarchar', 'additional' => 'NULL DEFAULT \'\''),
                'tree_template' => array('type' => 'bigint', 'additional' => 'NULL'),
                'tree_notes' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_datecreated' => array('type' => 'timestamp', 'additional' => 'NULL DEFAULT CURRENT_TIMESTAMP'),
                'tree_datemodified' => array('type' => 'timestamp', 'additional' => 'NULL'),
                'tree_description' => array('type' => 'longvarchar', 'additional' => 'NULL'),
                'tree_language' => array('type' => 'varchar2', 'additional' => 'NULL'),
                'tree_domain' => array('type' => 'longvarchar', 'additional' => 'NULL'),
                'tree_header_description' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_header_keywords' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_header_shortcuticon' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_header_basehref' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_header_inlinestyles' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_header_inlinescripts' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_header_aditionaltags' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_header_statictitle' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_properties' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_propertiesvalues' => array('type' => 'longtext', 'additional' => 'NULL'),
                'tree_securitycache' => array('type' => 'longtext', 'additional' => 'NULL')
            )
        , array(
            "sys_tree_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "tree_id"),
            "sys_tree_levels" => array("constraint" => "", "fields" => "tree_left_key,tree_right_key,tree_level"),
            "sys_tree_name" => array("constraint" => "", "fields" => "tree_name")
        ), ''));  
        
        $this->_scheme->Add(new PioneerSchemeTable('sys_umusers', array(
            'users_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
            'users_created' => array('type' => 'timestamp', 'additional' => ' NULL default CURRENT_TIMESTAMP'),
            'users_modified' => array('type' => 'timestamp', 'additional' => ' NULL'),
            'users_password' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            'users_lastlogindate' => array('type' => 'timestamp', 'additional' => ' NULL'),
            'users_lastloginfrom' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
            'users_roles' => array('type' => 'longtext', 'additional' => ' NULL'),
            'users_profile' => array('type' => 'longtext', 'additional' => ' NULL'),
        ), array(
            'users_name' => array('fields' => 'users_name', 'constraint' => 'PRIMARY KEY')
        ), ''));        
        
        $this->_scheme->Add(new PioneerSchemeTable('sys_umgroups', array(
            'groups_name' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\''),
            'groups_description' => array('type' => 'tinytext', 'additional' => ' NULL')
        ), array(
            'groups_name' => array('fields' => 'groups_name', 'constraint' => 'PRIMARY KEY')
        ), ''));
        
        $this->_scheme->Add(new PioneerSchemeTable('sys_umusersgroups', array(
            'ug_user' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\''),
            'ug_group' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\'')
        ), array(
            /*'user_group' => array('fields' => 'ug_user,ug_group', 'constraint' => 'PRIMARY KEY')*/
        ), ''));
                 // out($this->_scheme->GetScheme());
        
    }
    
    function ExecuteBatchFile($content, $ignoreerrors = false) { // $content = array() or file url
        
        $file_content = $content;
        if($core->fs->FileExists($content))
            $file_content = $core->fs->SplitFile($content);
            
        $query = "";
        foreach($file_content as $sql_line) {
            $tsl = trim($sql_line);
            
            if (($tsl != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "#")) {
                $query .= $sql_line;
                if(preg_match("/;\s*$/", $sql_line)) {
                    $result = $core->dbe->query($connection, $dbtype, $query);
                    if (!$result && !$ignoreerrors) {
                        return false;
                    }
                    $query = "";
                }
            }
        }
        return true;
    }        
    
    
}

class PioneerSchemeTable extends Object {

    public function __construct($name, $fields = array(), $indices = array(), $ads = '', $temp = false, $engine = null) {
        parent::__construct();
        
        $this->name = $name;
        $this->fields = $fields;
        $this->indices = $indices;
        $this->ads = $ads;
        $this->temp = $temp;
        
        $this->_engine = $engine;
    }
    
    public function Check() {
        // check the table existance and vlidity
        if($this->_engine->TableExists($this->table))
            return false;
        
        $fields = $this->_engine->Fields($this->table);
        foreach($this->fields as $name => $f) {
            if(!$fields->Exists($name))
                return false;
        }
        
        return true;
    }
    
    public function CreateScheme($return = false) {
        if(is_null($this->_engine))
            return false;
        return $this->_engine->CreateTable($this->name, $this->fields, $this->indices, $this->ads, $this->temp, $return);
    }
    
    public function Drop($return = false) {
        if(is_null($this->_engine))
            return false;
        return $this->_engine->DropTable($this->name, $return);
    }
    
}

class PioneerScheme extends ArrayList {
    
    private $_engine;
    
    public function __construct($engine) {
        parent::__construct();
        $this->_engine = $engine;
    }
    
    public function Add(PioneerSchemeTable $table) {
        $table->_engine = $this->_engine;
        return parent::Add($table);
    }
    
    public function Check() {
        foreach($this as $table) {
            if(!$table->Check())
                return false;
        }
        return true;
    }
    
    public function GetScheme() {
        $query = '';
        foreach($this as $table) {
            $query .= $table->CreateScheme(true);
        }
        return $query;
    }
    
    public function CreateScheme() {
        $this->_engine->StartTrans();
        
        foreach($this as $table) {
            if(!$table->CreateScheme()) {
                $this->_engine->FailTrans();
                return false;
            }
        }
        
        $this->_engine->CompleteTrans();
        return true;
    }
    
    public function InsertInitialData() {
        //$this->_engine->StartTrans();
        
        // create default settings
        Setting::Create('BLOB_CACHE_FOLDER', 'memo', '/assets/static', null, false, 'Blob manager settings | Настройки менеджера ресурсов')->Insert();
        Setting::Create('MAIL_SMTP', 'memo', 'island.grc.ru', null, false, 'System settings | Настройки системы')->Insert();
        Setting::Create('DEVELOPER_EMAIL', 'memo', 'mk@e-time.ru;spawn@e-time.ru', null, false, 'System settings | Настройки системы')->Insert();
        Setting::Create('COPYRIGHT', 'memo', 'Company copyright', null, false, 'User settings | Пользовательские настройки')->Insert();
        Setting::Create('USE_MOD_REWRITE', 'memo', 'default', NULL, false, 'System settings | Настройки системы')->Insert();
        Setting::Create('SYSTEM_RESTORE_CRON_MAX', 'memo', '5', NULL, false, 'System restore settings | Настройки системы восстановления')->Insert();
        Setting::Create('SETTING_COMPANY_EMAIL', 'memo', 'company@e.mail', null, false, 'User settings | Пользовательские настройки')->Insert();
        Setting::Create('SETTING_COMPANY_TITLE', 'memo', 'Company title', null, true, 'User settings | Пользовательские настройки')->Insert();
        Setting::Create('SETTING_PAGESIZE', 'memo', '10', null, false, 'System settings | Настройки системы')->Insert();

        DesignTemplate::Create('default', '', '<? echo phpinfo(); ?>', '', 'Default Site', '', '', '', '', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');
        
        $this->_engine->Insert('sys_tree', Collection::Create(
            'tree_left_key', 1, 
            'tree_right_key', 86, 
            'tree_level', 0, 
            'tree_sid', 0, 
            'tree_published', true, 
            'tree_name', 'root', 
            'tree_keyword', 'root', 
            'tree_template', 2, 
            'tree_notes', '', 
            'tree_datecreated', '2006-12-12 15:41:50', 
            'tree_datemodified', '2006-12-12 15:41:50', 
            'tree_description', 'root', 
            'tree_language', 'ru', 
            'tree_domain', 'root', 
            'tree_header_description', '', 
            'tree_header_keywords', '', 
            'tree_header_shortcuticon', '', 
            'tree_header_basehref', '', 
            'tree_header_inlinestyles', '', 
            'tree_header_inlinescripts', '', 
            'tree_header_aditionaltags', '', 
            'tree_header_statictitle', 'root', 
            'tree_properties', null,
            'tree_propertiesvalues', null,
            'tree_securitycache', null
        ));
        
        $this->_engine->Insert('sys_tree', Collection::Create(
            'tree_left_key', 7, 
            'tree_right_key', 85, 
            'tree_level', 1, 
            'tree_sid', 0, 
            'tree_published', true, 
            'tree_name', 'site', 
            'tree_keyword', 'site', 
            'tree_template', 1, 
            'tree_notes', '', 
            'tree_datecreated', '2006-12-12 15:41:50', 
            'tree_datemodified', '2006-12-12 15:41:50', 
            'tree_description', 'Default site', 
            'tree_language', 'ru', 
            'tree_domain', '', 
            'tree_header_description', '', 
            'tree_header_keywords', '', 
            'tree_header_shortcuticon', '', 
            'tree_header_basehref', '', 
            'tree_header_inlinestyles', '', 
            'tree_header_inlinescripts', '', 
            'tree_header_aditionaltags', '', 
            'tree_header_statictitle', 'Default site', 
            'tree_properties', null,
            'tree_propertiesvalues', null,
            'tree_securitycache', null
        ));
                                                                                                    
        $this->_engine->Insert('sys_umgroups', Collection::Create('groups_name', 'Administrators', 'groups_description', 'System administrators'));
        $this->_engine->Insert('sys_umusers', Collection::Create(
            'users_name', 'admin', 
            'users_password', '4b6dP/8=', 
            'users_lastlogindate', '01.01.2008', 
            'users_lastloginfrom', '93.80.180.159', 
            'users_roles', 'system_administrator'
        ));

        $this->_engine->Insert('sys_umusersgroups', Collection::Create('ug_user', 'admin', 'ug_group', 'Administrators'));
        
        //$this->_engine->CompleteTrans();
        return true;
    }
    
    public function Drop() {
        $this->_engine->StartTrans();
        foreach($this as $table) {
            if(!$table->Drop()) {
                $this->_engine->FailTrans();
                return false;
            }
        }
        $this->_engine->CompleteTrans();
        return true;
    }
    
    
    
}


?>