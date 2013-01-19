<?php

/**
	* class Settings
	*
	* Description for class Settings
	*
	* @author:
	*/
	
class Setting {
	
	public $name;
	public $type;
	public $value;
	public $securitycache;
	public $is_system;
	public $category;
	
	public function __construct($name = null, $type = null, $value = null, $securitycache = null, $is_system = 0, $category = null){
		
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
		$this->is_system = $is_system;
		$this->category = $category;
		$this->securitycache = $securitycache;
		
		if(!($this->securitycache instanceof Hashtable)) {
			$this->securitycache = _unserialize($this->securitycache);
			if($this->securitycache === false || is_null($this->securitycache)) $this->securitycache = new Hashtable();
		}
	}
	
	public function __get($name) {
        if(!is_null(@$this->$name))
			return $this->$name;
		else { 
			$nm = substr($name, strlen("setting_"));
			return $this->$nm;
		}
	}
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("settings.setting.delete", "Delete the setting"));
		$operations->Add(new Operation("settings.setting.edit", "Edit setting value"));
		return $operations;
	}
	
	public function createSecurityBathHierarchy($suboperation) {
		global $core;
		return array( 
			array("object" => $core->sts, "operation" => "settings.".$suboperation), 
			array("object" => $this, "operation" => "settings.setting.".$suboperation)
	    );
	}
    
    static function Create($name = null, $type = null, $value = null, $securitycache = null, $is_system = 0, $category = null) {
        return new Setting($name, $type, $value, $securitycache, $is_system, $category); 
    }
	
	public function Insert() {
        global $core;
        $core->dbe->insert('sys_settings', 
            new collection(array("setting_name" => $this->name, 
                                "setting_type" => $this->type,
                                "setting_value" => $this->value, 
                                "setting_issystem" => $this->is_system ? 1 : 0, 
                                "setting_category" => $this->category,
                                "setting_securitycache" => _serialize($this->securitycache))));
            
    }
    
}

class Settings extends Collection {
	private $table;
	private $nocache;
	
	public $securitycache;
	
	public function __construct() {
		parent::__construct();
		
		$this->table = sys_table("settings");
		$this->securitycache = new Hashtable();
	}	
    
    public function Dispose() {
        parent::Clear();
    }


	public function RegisterEvents(){
		
	}
	
	public function RegisterEventHandlers(){
		
	}
	
	public function Initialize($nocache = true) {
		$this->nocache = $nocache;
		if(!$this->nocache)
			$this->sync();
	}
	
	private function sync() {
		global $core;
		
		$rss = $core->dbe->ExecuteReader("select * from ".$this->table);
		while($v = $rss->Read()) {
			parent::add($v->setting_name, new Setting($v->setting_name, $v->setting_type, $v->setting_value, $v->setting_securitycache, $v->setting_issystem, $v->setting_category));
		}

	}

	public function remove($name) {
		global $core;
		
		$core->dbe->delete($this->table, "setting_name", $name);
		
		if(!$this->nocache)
			parent::Delete($name); //remove
		
	}
	
	public function add(Setting $v) {
		global $core;
		
		$core->dbe->insert($this->table, 
							new collection(array("setting_name" => $v->name, 
												"setting_type" => $v->type,
												"setting_value" => $v->value, 
												"setting_issystem" => $v->is_system ? 1 : 0, 
												"setting_category" => $v->category,
												"setting_securitycache" => _serialize($v->securitycache))));
        if(!$this->nocache)
			parent::add($v->name, $v);
	}
	
	public function exists($index) {
		if(!$this->nocache)
			return parent::exists($index);
		else {
			global $core;
			$settings = $core->dbe->ExecuteReader("select count(*) as c from ".$this->table." where setting_name='".$index."'");
			$s = $settings->Read();
			return $s->c > 0;
		}
	}
	
	public function __set($name, $v) {
		global $core;
		
		if($v instanceof Setting) {
			if($this->exists($name)) {
				$core->dbe->set($this->table, "setting_name", $name, new collection(array("setting_type" => $v->type, "setting_value" => $v->value, "setting_securitycache" => _serialize($v->securitycache), "setting_issystem" => $v->is_system, "setting_category" => $v->category)));
				if(!$this->nocache)
					parent::__set($name, $v);
			}
			else {
				$this->add($v);
			}
		}
		else {
			$core->dbe->set($this->table, "setting_name", $name, new collection(array("setting_value" => $v)));
			if(!$this->nocache)
				$this->item($name)->value = $v;
		}
	}
	
	public function item($index) {
		if(!$this->nocache) {
			return parent::item($index);
		}
		else {
			global $core;
			$settings = $core->dbe->ExecuteReader("select * from ".$this->table." where setting_name='".$index."'");
			if($settings->count() > 0)  {
				$s = $settings->Read();
				return new Setting($s->setting_name, $s->setting_type, $s->setting_value, $s->setting_securitycache, $s->setting_issystem, $s->setting_category);
			}
			else
				return null;
		}
	}
	
	public function __get($name) {
		if(!$this->nocache) {
			if(parent::exists($name)) {
				return parent::item(strtolower($name))->value;
			}
			else
				return null;
		}
		else {
			global $core;
			$settings = $core->dbe->ExecuteReader("select * from ".$this->table." where setting_name='".$name."'");
			if($settings->count() > 0)  {
				$s = $settings->Read();
				return $s->setting_value;
			}
			else
				return null;
		}
	}
	
	public function get_categories() {
		global $core;
		$ret = new ArrayList();
		$rss = $core->dbe->ExecuteReader("select distinct setting_category from ".$this->table);
		while($v = $rss->Read()) {
			$ret->Add($v->setting_category);
		}
		return $ret;
	}
	
	public function get_collection($category = null, $setting_type = -1) {
		global $core;
		$ret = new collection();			
		$crit = "";
		if(!is_null($category))
			$crit .= " where setting_category='".$category."'";
		if($setting_type >= 0)
			$crit .= " and setting_issystem='".$setting_type."'";
		$rss = $core->dbe->ExecuteReader("select * from ".$this->table.$crit." order by setting_issystem");
		while($v = $rss->Read()) {
			$ret->add($v->setting_name, new Setting($v->setting_name, $v->setting_type, $v->setting_value, $v->setting_securitycache, $v->setting_issystem, $v->setting_category));
		}
		return $ret;
	}
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("settings.add", "Add a setting"));
		$operations->Add(new Operation("settings.delete", "Delete the setting"));
		$operations->Add(new Operation("settings.edit", "Edit setting value"));
		return $operations;
	}

	public function createSecurityBathHierarchy($suboperation) {
		return array( 
						array("object" => $this, "operation" => "settings.".$suboperation)
				     );
	}
	
	
	
	
}

?>
