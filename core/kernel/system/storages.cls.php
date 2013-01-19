<?php

/**
	* class storages
	*
	* Description for class storages
	*
	* @author:
	*/

class StringSelector {
    private $_list;
    public function  __construct($string) {
        $this->_list = array();
        $arr = explode(',', $string);
        $i = 0;
        foreach($arr as $a) {
            $this->_list['a'.$i++] = $a;
        }
    }
    
    public function Create($string) {
        return new StringSelector($string);
    }
    
    public function ToString($withKeys = true, $splitter = "\n") {
        $ret = '';
        foreach($this as $k => $v) {
            $ret .= ($withKeys ? $v.':' : '').$v.$splitter;
        }
        return trim($ret, $splitter);
    }

    public function ToPHPScript() {
        return 'StringSelector::Create("'.$this->ToString(false, ",").'")->ToString()';
    }
    
    public function ToArray() {
        return $this->_list;
    }

    public function Item($index) {
        return $this->_list['a'.$index];
    }    
    
}    
    
class NumericSelector {
    private $_list;
    public function  __construct($string) {
        $this->_list = array();
        $arr = explode(',', $string);
        $i = 0;
        foreach($arr as $a) {
            $this->_list['a'.$i++] = $a;
        }
    }
    
    public function Create($string) {
        return new NumericSelector($string);
    }
    
    public function ToString($withKeys = true, $splitter = "\n") {
        $ret = '';
        foreach($this->_list as $k => $v) {
            if(is_empty($v))
                continue;
            $ret .= ($withKeys ? substr($k, 1).':' : '').$v.$splitter;
        }
        return trim($ret, $splitter);
    }

    public function ToPHPScript() {
        return 'NumericSelector::Create("'.$this->ToString(false, ",").'")->ToString()';
    }
    
    public function ToArray() {
        return $this->_list;
    }

    public function Item($index) {
        return $this->_list['a'.$index];
    }
    
    
}

class Selector {
    
    private $_list;
    
    public function  __construct($string) {
        $this->_list = array();
        $arr = explode(';', $string);
        foreach($arr as $a) {
            if(is_empty(trim($a)))
                continue;
            $b = explode(':', $a);
            $this->_list[$b[0]] = $b[1];
        }
    }
    
    public function Create($string) {
        return new Selector($string);
    }
    
    public function ToString($withKeys = true, $splitter = "\n") {
        $ret = '';
        foreach($this->_list as $k => $v) {
            $ret .= ($withKeys ? $k.':' : '').$v.$splitter;
        }
        return trim($ret, $splitter);
    }
    
    public function ToPHPScript() {
        return 'Selector::Create("'.$this->ToString(true, ",").'")->ToString()';
    }

    public function ToArray() {
        return $this->_list;
    }
    
    public function Item($index) {
        return $this->_list[$index];
    }
    
}

class TableInfo extends Object {

/*    SELECT relname, reltuples 
    FROM pg_class r JOIN pg_namespace n ON (relnamespace = n.oid) 
    WHERE relkind = 'r' AND n.nspname = 'public';

    SELECT reltuples 
        FROM pg_class r 
        WHERE relkind = 'r' AND relname = 'sys_blobs';
*/
    
    public function __construct($table = null) {
        parent::__construct(null, 'tableinfo_');
        
        global $core;
        $this->name = $table;
        $this->rows = $core->dbe->CountRows($table);
        /*
        $this->engine = $r->Engine;
        $this->version = $r->Version;
        $this->rowformat = $r->Row_format;
        $this->avgrowlength = $r->Avg_row_length;
        $this->datalength = $r->Data_length;
        $this->maxdatalength = $r->Max_data_length;
        $this->indexlength = $r->Index_length;
        $this->datafree = $r->Data_free;
        $this->autoincrement = $r->Auto_increment;
        $this->createtime = $r->Create_time;
        $this->updatetime = $r->Update_time;
        $this->checktime = $r->Check_time;
        $this->collation = $r->Collation;
        $this->checksum = $r->Checksum;
        $this->createoptions = $r->Create_options;
        $this->comment = $r->Comment;*/
                                                             
    }
    
}
    
class Lookup extends Object {

    public function __construct($table="", $fields="", $id = "", $show = "", $condition = "", $order = "", $fullquery = "") {
        parent::__construct(null, 'default_');
        
        $this->table = $table;
        $this->fields = $fields;
        $this->id = $id;
        $this->show = $show;
        $this->condition = $condition;
        $this->order = $order;
        $this->fullquery = $fullquery;                                                                 
    }
    
    public function __get($prop) {
        if($prop == 'isValid') {
            return !is_empty($this->table) && 
                    !is_empty($this->fields) && 
                    !is_empty($this->id) && 
                    !is_empty($this->show);
        }
        return parent::__get($prop);
    }
    
    public function Exec() {
        global $core;
        $query = (!is_empty($this->fullquery)) ? $this->fullquery : "SELECT ".$this->fields." FROM ".$this->table."".(is_empty($this->condition) ? "" : " where ".$this->condition).(is_empty($this->order) ? '' : ' order by '.$this->order);
        return $core->dbe->ExecuteReader($query);
    }
    
    public function Create($table, $fields, $id = "", $show = "", $condition = "", $order = "", $fullquery = "")  {
        return new Lookup($table, $fields, $id, $show, $condition, $order, $fullquery);
    }
    
    public function ToString() {
        return $this->table.":".$this->fields.":".$this->id.":".$this->show.":".$this->condition.":".$this->order.":".$this->fullquery;
    }
    
    public function ToPHPScript() {
        return 'Lookup::Create("'.$this->table.'", "'.$this->fields.'", "'.$this->id.'", "'.$this->show.'", "'.$this->condition.'", "'.$this->fullquery.'")->ToString()';
    }
    
}

class Field extends Object {

	private $_storage;

	public function __construct($storage, $rrow = null) {
		parent::__construct($rrow, "storage_field_");
		$this->_storage = $storage;
		$this->storage_id = @$this->_storage->id;
		$this->field_old = $this->field;
	}
    
    public static function Create($storage, $name, $field, $type, $default, $required, $showintemplate, $lookup, $onetomany, $values, $group) {
        $f = new Field($storage);
        $f->name = $name;
        $f->field = $field;
        $f->type = $type;
        $f->default = $default;
        $f->required = $required ? 1 : 0;
        $f->showintemplate = $showintemplate ? 1 : 0;
        $f->lookup = $lookup;
        $f->onetomany = $onetomany;
        $f->values = $values;
        $f->group = $group;
        $storage->fields->Add($f);
        return $f;
    }

	public function SplitLookup() {
		$q = $this->lookup;
		if(is_empty($q))
			return false;
			
		$a = explode(":", $q);
        // temp - change old style lookups
        if(count($a) == 6) {
            $b = $a;
            $a[0] = $b[0];
            $a[1] = $b[1];
            $a[2] = $b[2];
            $a[3] = $b[3];
            $a[4] = $b[4];
            $a[5] = '';
            $a[6] = $b[5];
        }
            
		return new Lookup($a[0], $a[1], $a[2], $a[3], $a[4], $a[5], $a[6]);
	}
    
    public function GetValues() {
        if(is_empty($this->values))
            return false;
        
        $values = $this->values;
        $c = new Collection();
        $c->FromString($values, "\n", ":");
        $k = $c->Keys();
        if(is_numeric($k[0])) { // it is numeric selector
            return new Selector(trim(str_replace("\r", "", str_replace("\n", ";", $values)), ";"));
            //return new NumericSelector($s->ToString(true, ","));
        }
        else {
            // check if it is string selector
            return new Selector(str_replace("\r", ";", str_replace("\n", ";", $values)));
        }
                         
    }
	
	public function __get($prop) {
		if($prop == "isMultilink")
			return $this->onetomany != "" && $this->onetomany != "0";
		else if($prop == "isLookup")
			return !is_empty($this->lookup);
        else if($prop == "storage")
            return $this->_storage;
		else
			return parent::__get($prop);
	}
    
    public function __set($prop, $value) {
        switch($prop){ 
            case "storage":
                $this->_storage = $value;
            default: 
                parent::__set($prop, $value);
        }
    }

	public function Save() {
		global $core;

		if(!is_null($this->_storage) && $this->_storage->id > 0) {
		
			//$core->dbe->StartTrans();
		
			$this->storage_id = $this->_storage->id;
			
			$types = $core->dbe->Type2System();
			$data = collection::create($this->data());
			$data->Delete("storage_field_id");
            
            $fields = $core->dbe->Fields($this->_storage->table);
            
			if($this->id == -1 || is_null($this->id)) {
				$data->Delete("storage_field_id");
				$data->Delete("storage_field_field_old");
				$this->id = $core->dbe->insert("sys_storage_fields", $data);
				if($this->id < 0) {
					//$core->dbe->FailTrans();
					return;
				}
				$c = Collection::Create("storage_field_order", $this->id);
				$core->dbe->set("sys_storage_fields", "storage_field_id", $this->id, $c);
				$this->order = $this->id;
				$t = $types->Item($this->type);
                
                if(!$core->dbe->AddField($this->_storage->table, $this->_storage->table."_".$this->field, $t, $this->required == 1 ? false : true, ($t == "LONGTEXT" || $t == "DATETIME") || is_empty($this->default) ? null : $this->default)){
					//$core->dbe->FailTrans();
                    out($core->dbe->error());
					return;
				}
			}
			else { 
				$data->Delete("storage_field_id");
				$data->Delete("storage_field_field_old");	

				$core->dbe->set("sys_storage_fields", "storage_field_id", $this->id, $data);
				$t = strtolower($types->Item($this->type));
                $default = $this->default;
                if($t == 'longtext') {
                    $default = null;
                }
                else if($t == 'bigint' || $t == 'real') {
                    if($this->required == 1 && is_empty($default))
                        $default = 0;
                    else
                        $default = null;
                }
				
                if(!$fields->Exists($this->_storage->table."_".$this->field)) {
                    $core->dbe->AddField($this->_storage->table, $this->_storage->table."_".$this->field, $t, $this->required == 1 ? false : true, ($t == "LONGTEXT" || $t == "DATETIME") || is_empty($this->default) ? null : $this->default);
                }
                else {
                    $core->dbe->AlterField2($this->_storage->table, $this->_storage->table."_".$this->field_old, $this->_storage->table."_".$this->field, $t, $this->required == 1 ? false : true, ($t == "LONGTEXT" || $t == "DATETIME") || is_empty($this->default) ? null : $this->default);
                }
			}
			
			//$core->dbe->CompleteTrans();
		}
	}

	public function Delete() {
		global $core;
		if(!is_null($this->_storage)) {
			//$core->dbe->StartTrans();
			if(!$core->dbe->query("delete from sys_storage_fields where storage_field_id=".$this->id)) {
				//$core->dbe->FailTrans();
				return;
			}
			if(!$core->dbe->RemoveField($this->_storage->table, $this->_storage->table."_".$this->field)) {
				//$core->dbe->FailTrans();
				return;
			}
			//$core->dbe->CompleteTrans();
		}
	}
	
	public function MoveUp() {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_storage_fields 
								  where storage_field_storage_id=".$this->_storage->id." and storage_field_order<".$this->order." 
								  order by storage_field_order desc 
								  limit 1");
		if($r->count() > 0){
			$rr = $r->Read();
			$c = Collection::Create("storage_field_order", $this->order);
			$this->order = $rr->storage_field_order;
			$core->dbe->set("sys_storage_fields", "storage_field_id", $rr->storage_field_id, $c);
			$this->Save();
		}
	}

	public function MoveDown() {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_storage_fields where 
								  storage_field_storage_id=".$this->_storage->id." and storage_field_order>".$this->order." 
								  order by storage_field_order limit 1");
		if($r->count() > 0){
			$rr = $r->Read();
			$c = Collection::Create("storage_field_order", $this->order);
			$this->order = $rr->storage_field_order;
			$core->dbe->set("sys_storage_fields", "storage_field_id", $rr->storage_field_id, $c);
			$this->Save();
		}
	}
	
	public function ToXML() {
		parent::ToXML("field", array(), array(), array("id"));
	}
	
	public function FromXML($node) {
		parent::FromXML($node);
		$this->_storage = new Storage($this->storage_id);
	}
    
    public function Copy($storage = null) {
        if(is_null($storage))
            $storage = $this->_storage;
        $f = new Field($storage);
        $f->name = $this->name;
        $f->field = $this->field;
        $f->type = $this->type;
        $f->default = $this->default;
        $f->required = $this->required;
        $f->showintemplate = $this->showintemplate;
        $f->lookup = $this->lookup;
        $f->onetomany = $this->onetomany;
        $f->values = $this->values;
        $f->group = $this->group;
        return $f;
    }

    public function ToPHPScript($fieldProperty, $storageProperty) {
        $lookup = $this->SplitLookup();
        if($lookup)
            $lookup = $lookup->ToPHPScript();
        else
            $lookup = '""';
        
        $values = $this->GetValues();
        if($values)
            $values = $values->ToPHPScript();
        else
            $values = '""';
        return $fieldProperty.' = Field::Create('.$storageProperty.', "'.$this->name.'", "'.$this->field.'", "'.to_lower($this->type).'", "'.$this->default.'", '.($this->required ? 'true' : 'false').', '.($this->showintemplate ? 'true' : 'false').', '.$lookup.', "'.$this->onetomany.'", '.$values.', "'.$this->group.'", "'.$this->order.'");'."\n";
    }
    
}

class Fields extends Collection {
	
	private $_storage;
    private $_group;
	
	public function __construct($storage, $group = null) {
		parent::__construct();
		$this->_storage = $storage;
        $this->_group = $group;
		$this->_loadFields();
	}

	private function _loadFields() {
		global $core;
		$rr = $core->dbe->ExecuteReader("select * from sys_storage_fields where storage_field_storage_id=".$this->_storage->id.(!is_null($this->_group) ? " and storage_field_group='".$this->_group."'" : "")." order by storage_field_order", "storage_field_field");
		while($rrow = $rr->Read()) {
			parent::Add($rrow->storage_field_field, new Field($this->_storage, $rrow->Data()));
		}
	}
	
	public function NewField() {
		return new Field($this->_storage);
	}
	
	public function Add(Field $value) {
		parent::Add($value->field, $value);
		$value->Save();
	}
	
	public function Delete($key) {
		if(!($key instanceof Field))
			$key = parent::Item($key);
		$key->Delete();
		parent::Delete($key->field);
	}

	public function Save() {
		foreach($this as $field) {
			$field->Save();
		}
	}
	
	public function ToXML() {
		$ret = '<fields storage="'.$this->_storage->id.'">';
		foreach($this as $value) {
			$ret .= $value->ToXML();
		}
		$ret .= '</fields>';
		return $ret;
	}
	
	public function FromXML($node) {
		$this->_storage = new Storage($node->getAttribute("storage"));
		$childs = $node->childNodes;
		foreach($childs as $pair) {
			if($pair->nodeName == "field") {
				$f = new Field();
				$f->FromXML($pair);
				parent::Add($f->field, $f);
			}
		}
	}
    
    public function ToPHPScript($storageProperty) {
        $ret = '';
        foreach($this as $item) {
            $ret .= $item->ToPHPScript('$field'.$item->field, $storageProperty);
        }
        return $ret;
    }
    
}

class FieldGroups extends Collection {
    
    private $_storage;
    
    public function __construct($storage) {
        parent::__construct();
        $this->_storage = $storage;
        
        $this->_loadGroups();
        $this->Lock();
    }         
    
    private function _loadGroups() {
        global $core;
        $rr = $core->dbe->ExecuteReader("select distinct storage_field_group from sys_storage_fields where storage_field_storage_id=".$this->_storage->id, "storage_field_group");
        while($rrow = $rr->Read()) {
            if($rrow->storage_field_group == "" || is_null($rrow->storage_field_group))
                $rrow->storage_field_group = "default";
            parent::Add($rrow->storage_field_group, new Fields($this->_storage, $rrow->storage_field_group));
        }
    }                

}

class Storage extends Object {

	static $fields;
    static $fieldgroups;

	private $_fields;
	private $_templates;
    private $_fieldgroups;
    
    private $_tableInfo;

	/* changes 2006 12 10*/
	public function __construct($info = null) {
		global $core, $SYSTEM_USE_MEMORY_CACHE;	
		
        if($SYSTEM_USE_MEMORY_CACHE) {
		    if(!Storage::$fieldgroups)
			    Storage::$fieldgroups = new Collection();

            if(!Storage::$fields)
                Storage::$fields = new Collection();

		    if(!Storages::$cache) {
			    Storages::$cache = new Collection();
			    Storages::$cache->id = new Collection();
			    Storages::$cache->table = new Collection();
		    }
        }
		
		if(!is_object($info) && !is_null($info)) { // means that the info arg is given by the name or id
			
			$subcache = !is_numeric($info) ? "table" : "id";
			if( Storages::IsCached($info) ) {
				$info = Storages::$cache->$subcache->Item(!is_numeric($info) ? strtolower($info) : "id".$info);
			}
			else {
				if(is_numeric($info))
					$r = $core->dbe->ExecuteReader("select * from sys_storages where storage_id=".$info);
				else {
					$r = $core->dbe->ExecuteReader("select * from sys_storages where storage_table='".strtolower($info)."'");
				}
				
				if($r->Count() > 0)
					$info = $r->Read();
				else
					$info = null; 
			}
		}
	
		parent::__construct($info, "storage_");
		
		if(is_null($this->id)) {
			$this->id = -1;
			//$this->sid = uniqueid();
			$this->_fields = null;
            $this->_fieldgroups = null;  
			$this->_templates = null;
		}
		
		if(!($this->securitycache instanceof Hashtable)) {
			$this->securitycache = _unserialize($this->securitycache);
			if(!($this->securitycache instanceof Hashtable))
				$this->securitycache = new Hashtable();
		}
		
        if($SYSTEM_USE_MEMORY_CACHE) {
		    Storages::$cache->id->Add("id".$this->id, $info);
		    Storages::$cache->table->Add(strtolower($this->table), $info);
        }
		
	}
    
    public static function Create($name, $table, $color, $group, $istree, $id = -1) {
        $s = new Storage();
        $s->name = $name;
        $s->table = strtolower($table);
        $s->color = $color;
        $s->group = $group;
        $s->istree = $istree;
        $s->Save($id);
        return $s;
    }
	
	private function _loadFields() {
		global $core;
		if(!is_null(Storage::$fields) && Storage::$fields->Exists($this->table))
			$this->_fields = Storage::$fields->Item($this->table);
		else {
			$this->_fields = new Fields($this);
            if(!is_null(Storage::$fields))
			    Storage::$fields->Add($this->table, $this->_fields);
		}
	}
    
    private function _loadFieldGroups() {
        global $core;
        if(!is_null(Storage::$fieldgroups) && Storage::$fieldgroups->Exists($this->table))
            $this->_fieldgroups = Storage::$fieldgroups->Item($this->table);
        else {
            $this->_fieldgroups = new FieldGroups($this);
            if(!is_null(Storage::$fieldgroups))
                Storage::$fieldgroups->Add($this->table, $this->_fieldgroups);
        }
    }
    
    private function _loadTableStats() {
        if(!$this->_tableInfo)
            $this->_tableInfo = Storages::TableStats()->Item($this->table);
    }
        
	public function __get($nm) {

		switch($nm) {
			case "isValid" :
				return Storages::IsValid($this);
			case "templates":
				if(!($this->_templates instanceof Templates))
					$this->_templates = new Templates($this, TEMPLATE_STORAGE);
				return $this->_templates;
			case "fields":
				if(!($this->_fields instanceof Fields))
					$this->_loadFields();
				return $this->_fields;
            case "fieldgroups":
                if(!($this->_fieldgroups instanceof FieldGroups))
                    $this->_loadFieldGroups();
                return $this->_fieldgroups;
            case "tableInfo":
                $this->_loadTableStats();
                return $this->_tableInfo;
			default:
				return parent::__get($nm);
		}
		
		return null;
	}

	public function fname($nm) {
		if($this->id > 0)
			return $this->table."_".$nm;
		else
			return $nm;
	}

	public function fromfname($nm) {
		if($this->id > 0)
			return substr($nm, strlen($this->table."_"));
		else 
			return $nm;
	}

	// checks if the storage in one to many link selected
	public function is_inlink() {
		global $core;
		$r = $core->dbe->ExecuteReader("select distinct storage_field_onetomany from sys_storage_fields where storage_field_onetomany <> ''");
		while($rr = $r->Read()) {
			$s = $rr->storage_field_onetomany;
			$ss = explode(":", $s);
			if($ss[0] == $this->id)
				return true;
		}
		return false;
	}
	
	public function ToCollection() {
		$c = new Collection();
		$c->add("name", $this->name);
		$c->add("table", $this->table);
		$c->add("id", $this->id);
		$c->add("sid", $this->sid);
        $c->add("istree", $this->istree);
		
		$f = new collection();
		foreach($this->fields as $key => $ff) {
			$f->add($key, collection::create($ff->data()));
		}
		$c->add("fields", $f);
		
		$templates = $this->templates;
		$t = new collection();
		foreach($templates as $tt)
			$t->add($tt->name, $tt->get_collection());
		
		$c->add("templates", $t);
		
		return $c;
	}
	
	public function FromCollection(collection $data){
		/*
		foreach ($data as $k => $v){
			if ($k == "fields"){

			} else if ($k == "templates"){
				
			} else {
				$this->$k = $v;
			}
		}
		$this->id = -1;
		
		foreach ($data->fields as $kk => $vv)
			$this->fields->Add(new Field($vv->to_object()));
		
		foreach ($data->templates as $k => $v) {
			$t = new Template($v->to_object(), TEMPLATE_STORAGE, $st);
			$t->Save();
		}
		*/
	}
	
	public function ToXML(){
		return parent::ToXML("storage", array(), array(), array("id", "securitycache"));
	}
	
	public function FromXML($node) {
		parent::FromXML($node);
	}
	
	public function Save($id = -1) {
		global $core;
		
		//$core->dbe->StartTrans();
        if($this->id == -1) {
			$data = collection::create($this->_data);
			$data->Delete("storage_id");
            if($id >= 0)
                $data->Add('storage_id', $id);
            $data->storage_istree = (is_empty($data->storage_istree) ? 0 : $data->storage_istree);
			$data->storage_table = strtolower($data->storage_table);
			$data->storage_securitycache = _serialize($data->storage_securitycache);
			$iid = $core->dbe->insert("sys_storages", $data);
            if($id < 0)
                $this->id = $iid;
            else
                $this->id = $id;
		}
		else {
			$data = collection::create($this->_data);
			$data->storage_securitycache = _serialize($data->storage_securitycache);
            $data->storage_istree = (is_empty($data->storage_istree) ? 0 : $data->storage_istree);
			$data->Delete("storage_table");
			$data->Delete("storage_id");
			$core->dbe->set("sys_storages", "storage_id", $this->id, $data);
		}  
		
		if(!$core->dbe->TableExists($this->table)) {
			$this->_createDefTable();
		}
		
		if($this->fields->Count() > 0)
			$this->fields->Save();

		if($this->templates->Count() > 0)
			$this->templates->Save();

		//$core->dbe->CompleteTrans();
		
	}
	
	private function _createDefTable() {
        global $core;
        
        if($this->istree) {
            if(!$core->dbe->CreateTable($this->table, array(
                    $this->table."_id" => array('type' => 'autoincrement', 'additional' => ''),
                    $this->table.'_left_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                    $this->table.'_right_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                    $this->table.'_level' => array('type' => 'bigint', 'additional' => 'NOT NULL DEFAULT 0'),
                    $this->table."_datecreated" => array('type' => 'timestamp', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                ), array(
                    $this->table."_id" => array('constraint' => 'PRIMARY KEY', 'fields' => $this->table.'_id'),
                    $this->table."_levels" => array("constraint" => "", "fields" => $this->table."_left_key,".$this->table."_right_key,".$this->table."_level")
                ), ''))  {
                trigger_error("Can not create default table for storage");
            }
        }
        else {
            if(!$core->dbe->CreateTable($this->table, array(
                    $this->table."_id" => array('type' => 'autoincrement', 'additional' => ''),
                    $this->table."_datecreated" => array('type' => 'timestamp', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                ), array(
                    $this->table."_id" => array('constraint' => 'PRIMARY KEY', 'fields' => $this->table.'_id')
                ), ''))  {
			    trigger_error("Can not create default table for storage");
            }
        }
	}
	
	public function Delete() {
		global $core;
		$id = $this->id;
		$table = $this->table;

		$core->dbe->query("delete from sys_links where link_child_storage_id=".$id);
		$core->dbe->query("delete from sys_storage_fields where storage_field_storage_id=".$id);
		$core->dbe->query("delete from sys_storages where storage_id=".$id);
        
		$core->dbe->DropTable($table);
        
	}
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("storages.storage.delete", "Delete storage"));
		$operations->Add(new Operation("storages.storage.edit", "Edit storage"));
		$operations->Add(new Operation("storages.storage.recompile", "Recompile storage"));
		$operations->Add(new Operation("storages.storage.fields.add", "Add field to storage"));
		$operations->Add(new Operation("storages.storage.fields.delete", "Delete storage field"));
		$operations->Add(new Operation("storages.storage.fields.edit", "Edit storage field"));
		$operations->Add(new Operation("storages.storage.templates.add", "Add storage template"));
		$operations->Add(new Operation("storages.storage.templates.edit", "Edit storage template"));
		$operations->Add(new Operation("storages.storage.templates.delete", "Delete storage template"));
		$operations->Add(new Operation("storages.storage.data.publish", "Publish from storage"));
		$operations->Add(new Operation("storages.storage.data.add", "Add data to storage"));
		$operations->Add(new Operation("storages.storage.data.delete", "Delete the storage data"));
		$operations->Add(new Operation("storages.storage.data.edit", "Edit the storage data"));
		return $operations;
	}
	
	public function createSecurityBathHierarchy($suboperation) {
		return array( 
						array("object" => new storages(), "operation" => "storages.".$suboperation), 
						array("object" => $this, "operation" => "storages.storage.".$suboperation)
				     );
	}
    
    public function ToPHPScript() {

        return '
            /* Dumping storage '.$this->table.' */
            $storage'.$this->table.' = new Storage("'.$this->table.'");
            if($storage'.$this->table.'->isValid)
                $storage'.$this->table.'->Delete();
            $storage'.$this->table.' = Storage::Create("'.$this->name.'", "'.$this->table.'", "'.$this->color.'", "'.$this->group.'", "'.$this->istree.'", '.$this->id.');
            '.$this->fields->ToPHPScript('$storage'.$this->table).'
            '.$this->templates->ToPHPScript('$storage'.$this->table).'
            ';
    }
    
    public function Copy($newTable = "", $copyFields = false, $copyTemplates = false, $copyData = false) {
        global $core;
        
        if(is_empty($newTable)) {
            $newTable = $this->table."_copy";
            if($core->dbe->TableExists($newTable))
                $newTable = $this->table."_copy_".str_random(4);
        }
        
        $s = new Storage();
        $s->name = $this->name;
        $s->table = $newTable;
        $s->color = $this->color;
        $s->group = $this->group;
        $s->istree = $this->istree;
        $s->Save();
        
        if($copyFields) {
            foreach($this->fields as $field) {
                $f = $field->Copy($s);
                $s->fields->Add($f);
            }
        }
        
        if($copyTemplates) {
            // copy templates
            
            $templates = $this->templates;
            foreach($templates as $t) {

                $new = Template::Create($t->name, $s);
                $new->name = $t->name;
                $new->list = load_from_file($t->list);
                $new->composite = $t->composite;
                $new->properties = $t->properties;
                $new->styles = load_from_file($t->styles);
                $new->description = $t->description;
                $new->cache = $t->cache;
                $new->cachecheck = $t->cachecheck;
                $new->Save();
                
            }
        }
        
        if($copyData && $copyFields) {
            // copy data
            $dtrs = new DataRows($this);
            $dtrs->Load();
            
            while($dtr = $dtrs->FetchNext()) {
                $dt = new DataRow($s, null);
                foreach($dtr->storage->fields as $f) {
                    $fname = $f->field;
                    $dt->$fname = $dtr->$fname;
                }
                $dt->Save();
            }
        }
        
        return $s;
    }
	
	static function Colors() {
		return array(
			"none" => "",
			"light-red" => "#e59a9a",
			"light-green" => "#9ae5b1",
			"light-blue" => "#9aace5"
		);
	}
	
}

class Storages extends Collection {

	static $cache;
    
    static $_tablestats;
    
	public $securitycache;

	function __construct() {
		$this->securitycache = new Hashtable();
		parent::__construct();
	}

    public static function Groups() {
        global $core;
        $data = new ArrayList();
        $r = $core->dbe->ExecuteReader("select distinct storage_group from sys_storages");
        while($row = $r->Read()) {
            $data->Add($row->storage_group);
        }
        return $data;
    }
    
	public static function Enum($group = null) {
		global $core;
		$data = new Storages();
        
        $where = (!is_null($group) ? " storage_group='".$group."'" : "");
        
        if(!is_empty($where))
            $where = " where".$where;
        
	    $r = $core->dbe->ExecuteReader("select * from sys_storages".$where);
        while($row = $r->Read()) {
			$data->Add($row->storage_table, new Storage($row));
		}
        
		return $data;
	}
	
	public static function IsCached($init) {
        global $SYSTEM_USE_MEMORY_CACHE;
        if($SYSTEM_USE_MEMORY_CACHE) {
            if(!Storages::$cache) {
                Storages::$cache = new Collection();
                Storages::$cache->id = new Collection();
                Storages::$cache->table = new Collection();
            }
            
		    $field = is_numeric($init) ? "id" : "table";
		    $ii = !is_numeric($init) ? $init : "id".$init;
		    return Storages::$cache->$field->Exists($ii);
        }
        else
            return false;
	}
	
	public static function IsExists($init){ //init -> id, table
		global $core;
		
		if(Storages::IsCached($init))
			return true;

		$field = is_numeric($init) ? "id" : "table";
		$r = $core->dbe->ExecuteReader("select * from sys_storages where storage_".$field." = '".strtolower($init)."'");
		return $r->Count() > 0;
	}
	
	public static function IsValid($storage){ //Storage, table name
		///fields, etc
		
		global $core;
		
		$table = $storage instanceof Storage ? $storage->table : $storage;

		$se = Storages::IsExists($table);
		$te = $core->dbe->TableExists($table); //, true

		return $se && $te;
	}
	
	public static function Get($id) {
		return new storage($id);
	}
    
    public static function TableStats() {
        if(!Storages::$_tablestats) {
            global $core;
            Storages::$_tablestats = new Hashtable();
        
            $tables = $core->dbe->Tables();
            foreach($tables as $table) {
                Storages::$_tablestats->Add($table, new TableInfo($table));
            }
        }
        return Storages::$_tablestats;
    }
    
	public function ToXML($criteria = null){
		$ret = "<storages>";
		
		if (is_array($criteria)){
			$sts = new Storages();
			foreach ($criteria as $crit)
				$sts->add($crit, storages::get($crit));
		} else {
			if($this->Count() == 0)
				$sts = Storages::Enum();
			else 
				$sts = $this;
		}
		
		foreach ($sts as $st) {
			$ret .= $st->ToXML();
		}
		
		$ret .= "</storages>";
		return $ret;
	}
	
	public function FromXML($node) {
		$childs = $node->childNodes;
		foreach ($childs as $pair){
			switch ($pair->nodeName){
				case "storage" :
					$s = new Storage();
					$s->FromXML($pair);
					$this->Add($s->table, $s);
					break;
			}
		}
	}
	
	public function Save() {
		foreach($this as $storage) {
			$storage->save();
		}
	}

	public function createSecurityBathHierarchy($suboperation) {
		return array(array("object" => $this, "operation" => "storages.".$suboperation));
	}
    
    public function ToPHPScript() {
        $ret = '';
        $list = Storages::Enum();
        foreach($list as $item) {
            $ret .= $list->ToPHPScript();
        }
        return $ret;
    }
	
	
#region Static	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("storages.add", "Add storage applied to all storages"));
		$operations->Add(new Operation("storages.delete", "Delete storage applied to all storages"));
		$operations->Add(new Operation("storages.edit", "Edit storage applied to all storages"));
		$operations->Add(new Operation("storages.recompile", "Recompile storage applied to all storages"));
		return $operations;
	}
#endregion	
	
#region Aliases		
	public function to_xml($criteria = null){ return $this->ToXML($criteria); }
	public function from_xml($el){ $this->FromXML($el); }
#endregion
	
}

?>