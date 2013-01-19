<?php

/**
Class Role
holds a default and user created user roles (based on Pioneer structure)
*/
class Role extends ArrayList {
	
	public $name;
	public $description;
	
	public function __construct($name, $description = null) {
		parent::__construct();
		$this->name = $name;
		$this->description = $description;
	}      
    
    public function __destruct() {
        parent::__destruct();
    }
    
	public function Add(RoleOperation $v) {
		parent::Add($v);
	}
	
	public function AddRange($values) {
		foreach($values as $value)
			if(!($value instanceof RoleOperation))
				trigger_error(US_ERROR_TYPEERROR, E_USER_ERROR);
			else
				$this->Add($value);
	}
	
	public function ToString($spl = ",", $kspl = ":") {
		if ($this->Count() == 0 || is_empty($spl))
			return "";	
			
		$ret = "";
		$i = 0;
		foreach ($this as $v){
			$ret .= (($i == 0) ? "" : $spl).((is_empty($kspl)) ? "" : $v->operation.$kspl).$v->permission;
			$i++;
		}
		
		return $ret;
	}
	
	public function FromString($data, $spl = ",", $kspl = ":") {
		if (is_empty($data) || is_empty($spl) || is_empty($kspl))
			return $this->Clear();
		
		$dt = explode($spl, $data);
		foreach ($dt as $t){
			$inf = explode($kspl, $t);
			$key = "";
			switch (count($inf)){
				case 2 :
					$key = $inf[0];
					$value = $inf[1];
					break;
				default: 
					return;
			}
			$this->Add(new RoleOperation($key, $value));
		}		
	}
	
	
}

class Roles extends Collection {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function Add(Role $v) {
		parent::add($v->name, $v);
	}

}

class RoleOperation {

	public $permission;
	public $operation;

	public function __construct($operation = null, $permission = US_ROLE_DENY) {
		$this->operation = $operation;	
		$this->permission = $permission;
	}

}


?>