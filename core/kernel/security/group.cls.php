<?php



/**
Class Group 
Holds a user groups
saves to the database as relational table
*/
class UserList extends ArrayList {
	
	public $group;
	
	function __construct($group){
		parent::__construct(null);
		
		$this->group = $group;
		$rs = UsersGroupsList::Users($this->group, true);
		while($u = $rs->FetchNext()) {
			parent::Add($u->ug_user);
		}		
	}
    
    public function __destruct() {
        parent::__destruct();
    }
	
	public function Add(User $value, $index = -1) {
		if($value) {
			$u = $value->name;
			if(!parent::Contains($u)) {
				parent::Add($u, $index);
				UsersGroupsList::AttachToGroup(array($value), $this->group);
			}
		}
	}
	
	public function AddRange($values) {
		if($values) {
			foreach($values as $value) {
				if($value instanceof User){
					$u = $value->name;
					if(!parent::Contains($u)) {
						parent::Add($u);
						UsersGroupsList::AttachToGroup(array($value), $this->group);
					}
				}
			}
		}
	}
	
	public function Delete(User $value) {
		$index = parent::IndexOf($value->name);
		parent::Delete($index);
		UsersGroupsList::DetachFromGroup(array($value), $this->group);
	}
	
	public function DeleteRange($values) {
		foreach($values as $value) {
			$index = parent::IndexOf($value->name);
			if($index !== false) {
				parent::Delete($index);
				UsersGroupsList::DetachFromGroup(array($value), $this->group);
			}
		}
	}
	
	public function Item($index) {
		$u = parent::Item($index);
		return User::Load($u);
	}
	
	public function FromString($data, $spl = ",", $callback = ""){
		if (is_empty($data))
			return $this->Clear();
		$data = explode($spl, $data);
		foreach($data as $item) {
			if (!is_empty($callback))
				$item = call_user_func($callback, $item);
			$this->Add(User::Load($item));
		}
	}
	
	public function Clear() {
		UsersGroupsList::DetachFromGroup(null, $this->group);
		parent::Clear();
	}
	
	
}

class Group {
	
	private $_data;
	
	public function __construct($g = false) {
		if($g) {
			if($g instanceof stdClass)
				$this->_data = $g;
			else if($g instanceof Object)
				$this->_data = $g->Data();	
		}
		else
			$this->_data = new stdClass();
		
		
		if($this->_data) {
			$this->users = new UserList($this);
		}
	}
    
    public function __destruct() {
        unset($this->_data);
    } 
    
	public function getRowData() {
		return $this->_data;
	}
	
	public function __get($property) {
		$property = "groups_".$property;
		return @$this->_data->$property;
	}
	
	public function __set($property, $value) {
		$property = "groups_".$property;
		@$this->_data->$property = $value;
	}
	
	public static function Exists($name) {
		global $core;
        $r = $core->dbe->ExecuteReader("select count(*) as c from ".US_GROUPS_TABLE." where lower(groups_name)='".to_lower($name)."'");
		$uc = $r->Read();
		return $uc->c > 0;
	}
	
	public function Save() {
		global $core;
		
		$c = clone $this->_data;
		$data = Collection::Create($c);
		$data->Delete("groups_users");
		if(!Group::Exists($this->name)) {
			$core->dbe->insert(US_GROUPS_TABLE, $data);
			SecurityEx::$groups->Add($this->name);
		}
		else {
			$data->Delete("groups_name");
			$core->dbe->set(US_GROUPS_TABLE, "groups_name", $this->name, $data);
		}
		
	}
	
	public static function Load($name) {
		global $core;
		if(Group::Exists($name)) {
			$r = $core->dbe->ExecuteReader("select * from ".US_GROUPS_TABLE." where lower(groups_name)='".to_lower($name)."'");
			$uc = $r->Read();
			return new Group($uc);
		}
		else {
			//trigger_error(US_ERROR_USERCACHELOADFAILED.US_ERROR_INVALIDKEY, E_USER_ERROR);
		}
	}
	
	public static function Delete($group) {
		$name = $group;
		if($group instanceof Group) {
			$name = $group->name;
		}
		
		global $core;
		
		$core->dbe->query("delete from sys_umgroups where lower(groups_name)='".to_lower($name)."'");
		UsersGroupsList::DetachFromGroup(null, $name);
		SecurityEx::$groups->Delete($name);
		
	}
	
}


?>