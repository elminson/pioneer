<?php

class Property {
	
	public $name;
	public $type;
	public $description;
	public $value;
	public $defaultValue;
	
	public $set;
	
	public function __construct($name, $type, $description, $value, $defaultValue) {
		$this->name = $name;
		$this->type = $type;
		preg_match("/combo\((.*)\)/i", $this->type, $matches);
		if(count($matches) > 0) {
			$this->set = new Hashtable();
			$this->set->FromString($matches[1], ";", "|");
			$this->type = "combo";
		}
		$this->description = $description;
		$this->value = $value;
		$this->defaultValue = $defaultValue;
        
        if(is_null($this->value))
            $this->value = $this->defaultValue;
	}
    
}

class Properties extends Collection {
	
	function __construct($arr = array()) {
		parent::__construct($arr);
	}
	
	public function Add($prop, $key = null) {
		parent::Add(is_null($key) ? $prop->name : $key, $prop);
	}
	
	public function Delete($prop) {
		if($prop instanceof Property || $prop instanceof PropertyFolder)
			$prop = $prop->name;
		parent::Delete($prop);	
	}
	
	public function Merge($from) {
		trigger_error("You can't use this function", E_USER_ERROR);
	}

	public function Append($array1) {
		trigger_error("You can't use this function", E_USER_ERROR);
	}

	public function Dublicate() {
		trigger_error("You can't use this function", E_USER_ERROR);
	}

	
}

class FolderProperties extends Properties {

	protected $_propertiesList; /*string*/
	protected $_propertiesListO; /*hashtable*/

	function __construct($sf) {
		/*get the properties list in string format*/
		$this->_propertiesList = $sf->tree_properties;
		$this->_propertiesListO = new Hashtable();

		if(!is_empty($this->_propertiesList)) {
			if($sf instanceof Folder) {
				$path = $sf->Path();
				$path->Delete($path->Count()-1);
				for($i=$path->Count()-1; $i >= 0; $i--) {
					$folder = $path->Item($i);
					$this->_propertiesList = str_replace("[inherit]", $folder->tree_properties, $this->_propertiesList);
				}
			}	
			
		}		
		$this->_propertiesListO->FromString($this->_propertiesList, "\n", ":");
    
        $arr = @_unserialize($sf->propertiesvalues);
		
        if(is_array($arr)){
             foreach($arr as $k=>$ar){
                 $brr = explode(',',$this->_propertiesListO->$k);
                 if (isset($brr[1])){
				 	$arr[$k]->description = $brr[1];
				 }
             }
        }else        
            $arr = array();
            
        parent::__construct($arr);
        
		$this->_CheckProperties();
		
	}
		
	private function _CheckProperties() {
		$keys = $this->_propertiesListO->Keys();
		foreach($keys as $k) {
			if(!$this->Exists($k)) {
				$pp = explode(",", $this->_propertiesListO->$k);
				$p = new Property($k, $pp[0], $pp[1], null, @$pp[2]);
				$this->Add($p);
			}
		}
        
		$keys = $this->Keys();
		foreach($keys as $k) {
			if(!$this->_propertiesListO->Exists($k)) {
				$this->Delete($k);
			}
		}
		
	}
	
}

class PublicationProperties extends Properties {

	protected $_propertiesList; /*string*/
	protected $_propertiesListO; /*hashtable*/

	public $combined = false;
	
	function __construct($pub, $t = null) {

		/*get the properties list in string format*/
		/*
		$template = $pub->template;
		$type = $pub->object_type == 1 ? TEMPLATE_MODULE : TEMPLATE_STORAGE;
		$t = new phptemplate($type == TEMPLATE_MODULE ? null : $pub->datarow->storage, $type);
		$ts = $t->enum();
		$template = $ts->item($template);
		*/
		
		if(!is_null($t))
			$template = $t;
		else
			$template = $pub->getTemplate();
		
		if($template->composite == 1) {
			$this->combined = true;
			$arr = unserialize($pub->link_properties);
			if(!$arr)
				$arr = null;
			
			if(!is_array($arr)) {
				parent::__construct();
				
				$subtemplates = $template->SubTemplates();
				foreach($subtemplates as $k => $subs) {
					$this->Add(new PropertyFolder($subs->name, $pub, $subs), $k);
				}
				
			}
			else {
				parent::__construct($arr);	
				
				$subtemplates = $template->SubTemplates();
				$this->_propertiesList = new Hashtable();
				
				foreach($subtemplates as $k => $st) {
					$this->_propertiesList->Add($k, @$subtemplates->$k->properties);
				}
				
				$this->_propertiesListO = new Hashtable();
				
				foreach($subtemplates as $k => $st) {
					$this->_propertiesListO->Add($k, new Hashtable());
					$this->_propertiesListO->$k->FromString($this->_propertiesList->$k, "\n", ":");
				}
				
				$this->_CheckProperties();
				
			}
		}
		else {
			$this->_propertiesList = $template->properties;
			$arr = unserialize($pub->link_properties);
			if(!is_array($arr))
				$arr = array();
			
			parent::__construct($arr);

			$this->_propertiesListO = new Hashtable();
			$this->_propertiesListO->FromString($this->_propertiesList, "\n", ":");
			$this->_CheckProperties();

		}		
		
	}
		
	private function _CheckProperties() {

		if($this->combined) {
			
			$kkkkk = $this->_propertiesListO->Keys();
			foreach($kkkkk as $kkk) {
				$tttt = $this->_propertiesListO->$kkk;
				$ttttlist = $this->$kkk ? $this->$kkk : new Collection();
				
				$keys = $tttt->Keys();
				foreach($keys as $k) {
					if(!$ttttlist->Exists($k)) {
						$pp = explode(",", $tttt->$k);
						$p = new Property($k, $pp[0], $pp[1], null, @$pp[2]);
						$ttttlist->Add($k, $p);
					}
				}
				
				$keys = $ttttlist->Keys();
				foreach($keys as $k) {
					if(!$tttt->Exists($k)) {
						$ttttlist->Delete($k);
					}
				}			

			}
		}
		else {
			$keys = $this->_propertiesListO->Keys();
			foreach($keys as $k) {
				if(!$this->Exists($k)) {
					$pp = explode(",", $this->_propertiesListO->$k);
					$p = new Property($k, $pp[0], $pp[1], null, @$pp[2]);
					$this->Add($p);
				}
			}
			
			$keys = $this->Keys();
			foreach($keys as $k) {
				if(!$this->_propertiesListO->Exists($k)) {
					$this->Delete($k);
				}
			}
		}	
		
	}
	
}


class PropertyFolder extends PublicationProperties {
    
    public $name;
    
    public function __construct($name, $pub, $t) {
        $this->name = $name;
        parent::__construct($pub, $t);
    }
    
}

?>