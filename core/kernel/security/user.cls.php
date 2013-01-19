<?php

class GroupList extends arraylist {
	
	public $user;
	
	function __construct($user, $data = null){
		parent::__construct($data);
		
		$this->user = $user;
		$rs = UsersGroupsList::Groups($this->user, true);
		while($g = $rs->FetchNext()) {
			parent::Add($g->ug_group);
		}		
	}
    
    public function __destruct() {
        parent::__destruct();
    }    
	
	public function Add(Group $value, $index = -1) {
		if($value) {
			$g = $value->name;
			if(!parent::Contains($g)) {
				parent::Add($g, $index);
				UsersGroupsList::AttachToGroup(array($this->user), $value);
			}
		}
	}
	
	public function AddRange($values) {
		if($values) {
			foreach($values as $value) {
				if($value instanceof Group){
					$g = $value->name;
					if(!parent::Contains($g)) {
						parent::Add($g);
						UsersGroupsList::AttachToGroup(array($this->user), $value);
					}
				}
			}
		}
	}
	
	public function Delete(Group $value) {
		$index = parent::IndexOf($value->name);
		parent::Delete($index);
		UsersGroupsList::DetachFromGroup(array($this->user), $value);
	}
	
	public function DeleteRange($values) {
		foreach($values as $value) {
			$index = parent::IndexOf($value->name);
			if($index !== false) {
				parent::Delete($index);
				UsersGroupsList::DetachFromGroup(array($this->user), $value);
			}
		}
	}

	public function Item($index) {
		$g = parent::Item($index);
		return Group::Load($g);
	}
	
	public function FromString($data, $spl = ",", $callback = ""){
		if (is_empty($data))
			return $this->Clear();
		$data = explode($spl, $data);
		foreach($data as $item) {
			if (!is_empty($callback))
				$item = call_user_func($callback, $item);
			
			$this->Add(Group::Load($item));
			
		}
	}

	public function Clear() {
		UsersGroupsList::DetachFromGroup(array($this->user), null);
		parent::Clear();
	}
	
	public function Search($value, $key = null){
		$ret = array();
		foreach ($this as $k => $v){
			if (strtolower($v->name) == strtolower($value))
				$ret[] = $v;
		}
		return $ret;
	}
	
	
	
}

class User {
	
	private $_data;
	
	private $_callbacks;
	
	/*role*/
	
	public function __construct($u = null) {        
		if($u == null)
			$this->_data = new stdClass();
		else {
			
			$uclass = strtolower(get_class($u));
			switch($uclass) {
				case "stdclass":
					$this->_data = $u;
					break;
                case "object":
					$this->_data = $u->Data();
					break;
				case "collection": 
					$this->_data = $u->to_object();
					break;
				default: 
					//trigger_error(US_ERROR_USERINITIALIZATIONFAILED.US_ERROR_TYPEERROR, E_USER_ERROR);
			}
		}
		
		if($this->_data) {
			if(!($this->groups instanceof GroupList)) {
				$this->groups = new GroupList($this);
			}
			if(!($this->roles instanceof ArrayList))  {
				$r = $this->roles;
				$this->roles = new ArrayList();
			    $this->roles->FromString($r);
			}

            if(!($this->profile instanceof Hashtable)) {
                if(!is_null($this->profile))
                    $this->profile = new Hashtable(@unserialize($this->profile));
                else
                    $this->profile = new Hashtable();
            }
            $this->password = Encryption::Decrypt($this->name, $this->password);
            
        }
            
        $this->_callbacks = new Hashtable();        
    }
    
    public function __destruct() {
        if(!is_null($this->_callbacks))
            $this->_callbacks->Clear();
        unset($this->_data);
    }
        
	public function RegisterCallback($event, $callback) {
		$this->_callbacks->Add($event, $callback);
	}
	
	public function getRowData() {
		return $this->_data;
	}
	
	public function __get($property) {
		$property = "users_".$property;
        if(property_exists($this->_data, $property))
		    return @$this->_data->$property;
        else
            return false;
	}
	
	public function __set($property, $value) {
		$property = "users_".$property;
		@$this->_data->$property = $value;
	}
	
	public function Login($password) {
		return SecurityEx::$instance->Login($this, $password);
	}
	
	public function Logout() {
		SecurityEx::$instance->Logout();
	}
	
	public function isNobody() {
		return $this->name == "nobody";
	}
	
    public function isSupervisor() {
        return $this->name == "supervisor";
    }

	public function Save() {
		global $core;
		
		if(strtolower($this->name) == "supervisor") {
			return;
		}
		
		$d = clone $this->_data;
		$d->users_password = Encryption::Encrypt($d->users_name, $d->users_password);
		$d->users_roles = $d->users_roles->ToString();
		$data = Collection::Create($d);
		$data->Delete("users_groups");
		$data->users_profile = serialize($data->users_profile->Data());
		if(!User::Exists($this->name)) {
			$core->dbe->insert(US_USERS_TABLE, $data);
			SecurityEx::$users->Add($this->name);
		}
		else {
			$data->Delete("users_name");
			$core->dbe->set(US_USERS_TABLE, "users_name", $this->name, $data);
		}
	}
	
	public static function Load($name) {
		global $core;
		if($name == "supervisor") {
			return SecurityEx::$instance->Supervisor();
		}
		
		$rs = $core->dbe->ExecuteReader("select * from ".US_USERS_TABLE." where users_name='".$name."'", "users_name");
		if($rs->HasRows()) {
			return new User($rs->Read());
		}
		else {
			trigger_error(US_ERROR_USERCACHELOADFAILED.US_ERROR_INVALIDKEY, E_USER_ERROR);
			return null;
		}   
	}
	
	public static function Exists($name) {
		global $core;
		$rs = $core->dbe->ExecuteReader("select count(users_name) as c from ".US_USERS_TABLE." where users_name='".$name."'", "c");
		$count = $rs->Read();
		return $count->c > 0;
	}
	
	public static function Delete($user) {
		$name = $user;
		if($user instanceof User) {
			$name = $user->name;
		}
		
		global $core;
		
		$core->dbe->query("delete from sys_umusers where users_name='".$name."'");
		UsersGroupsList::DetachFromGroup(array($name), null);
		
		SecurityEx::$users->Delete($name);
		
	}
	
}

?>