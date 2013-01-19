<?php

class UsersGroupsList {
	
	public function __construct() {
		
	}
	
	public static function IsAttached($user, $group) {
		global $core;
		
		if($user instanceof User)
			$user = $user->name;
		if($group instanceof Group)
			$group = $group->name;
		
		$rs = $core->dbe->ExecuteReader("select count(*) as c from ".US_USERS_GROUPS_TABLE." where ug_user='".$user."' and ug_group='".$group."'");
		$c = $rs->Read();
		if($c !== false)
			return $c->c > 0;
		else 
			return false;
	}
	
	public static function AttachToGroup($users, $group) {
		global $core;
		
		if($group instanceof Group)
			$group = $group->name;
			
		foreach($users as $user) {
			if($user instanceof User)
				$user = $user->name;
			if(!UsersGroupsList::IsAttached($user, $group)) {
				$data = new Collection();
				$data->ug_user = $user;
				$data->ug_group = $group;
				$core->dbe->insert(US_USERS_GROUPS_TABLE, $data);
			}			
		}
	}
	
	public static function DetachFromGroup($users = null, $group = null) {
		global $core;
		if($group instanceof Group)
			$group = $group->name;
		if(is_null($users)){
			$core->dbe->query("delete from ".US_USERS_GROUPS_TABLE." where ug_group='".$group."'");
		}
		else{ 
			foreach($users as $user) {
				if($user instanceof User)
					$user = $user->name;
                if($user !== false)
				    $core->dbe->query("delete from ".US_USERS_GROUPS_TABLE." where ug_user='".$user."'".($group !== false ? " and ug_group='".$group."'" : ""));
			}
		}
	}
	
	public static function Users($group, $returnRowData = false) {
		global $core;

		if($group instanceof Group)
			$group = $group->name;
		
		$rs = $core->dbe->ExecuteReader("select * from ".US_USERS_GROUPS_TABLE." where ug_group='".$group."'");
		if($returnRowData)
			return $rs;
		
		$ret = new ArrayList();
		while($c = $rs->Read()) {
			$ret->Add(User::Load($c->ug_user));
		}
		return $ret;
	}
	
	public static function Groups($user, $returnRowData = false) {
		global $core;

		if($user instanceof User)
			$user = $user->name;
		
		$rs = $core->dbe->ExecuteReader("select * from ".US_USERS_GROUPS_TABLE." where ug_user='".$user."'");
		if($returnRowData)
			return $rs;
		
		$ret = new ArrayList();
		while($c = $rs->Read()) {
			$ret->Add(Group::Load($c->ug_group));
		}
		return $ret;
		
	}
	
}

?>