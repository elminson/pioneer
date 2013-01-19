<?

#region errors
define("US_ERROR_USERINITIALIZATIONFAILED", "The User initialization failed. ");
define("US_ERROR_USERCACHEINITFAILED", "Failed to crate cache from User. ");
define("US_ERROR_USERCACHELOADFAILED", "Failed to load cache from database. ");
define("US_ERROR_GROUPINITFAILED", "Failed to load group info. ");

define("US_ERROR_TYPEERROR", "The value is a wrong type. ");
define("US_ERROR_INVALIDUSER", "The value is a wrong type. ");
define("US_ERROR_INVALIDKEY", "The key is invalid. ");

define("US_ERROR_INVALID_OPERATION", "This operation is not valid. Please refer to the user manual.");
define("US_ERROR_CLASSISNOTMULTIINSTACE", "This class can not be initialized more than once.");


#endregion

define("US_USERS_TABLE", "sys_umusers");
define("US_GROUPS_TABLE", "sys_umgroups");
define("US_USERS_GROUPS_TABLE", "sys_umusersgroups");

define("US_RETURN_ROW_DATA", 0);
define("US_RETURN_CONVERTED_DATA", 1);

define("US_SECTION_STRUCTURE", "structure");
define("US_SECTION_DATA", "data");
define("US_SECTION_INTERFACE", "interface");
define("US_SECTION_MODULES", "modules");
define("US_SECTION_TOOLS", "tools");

// define("US_ROLE_ALLOWALL", "allow all");
// define("US_ROLE_DENYALL", "deny all");

define("US_ROLE_ALLOW", 1);
define("US_ROLE_DENY", 0);

define("US_SECURITY_SERIALIZATION_SESSION", "serialized to session");
define("US_SECURITY_SERIALIZATION_COOKIE", "serialized to cookie");
define("US_SECURITY_SERIALIZATION_FILE", "serialized to file");

define("US_CACHE_PATH", "_system/_cache/security/");
define("US_GROUPS_CACHE", "grouplist.cache");
define("US_USERS_CACHE", "userlist.cache");
define("US_CUSTOMROLES_CACHE", "roles.cache");


class SecuritySystemInfoCache {
		 
	static $instance = null;

	public $storage_path;
	
	public $roles;
	public $operations;
	
	public $operations_tree;
	
	public function __construct($storage_path = "/_system/_cache/security/") {
		$this->storage_path = $storage_path;
        
		$this->Load();	
	}
    
    public function __destruct() {
        $this->Dispose();
    }
    
    public function Dispose() {
         @$this->roles->Clear();
         @$this->operations->Clear();
         @$this->operations_tree->Clear();
    }
	
	public function Store() {
		global $core;
		
		$roles = serialize($this->roles);
		$operations = serialize($this->operations);
		$tree = serialize($this->operations_tree);
		
		$core->fs->writefile($this->storage_path."roles.cache", $roles, SITE);
		$core->fs->writefile($this->storage_path."operations.cache", $operations, SITE);
		$core->fs->writefile($this->storage_path."optree.cache", $tree, SITE);
        
        unset($roles);
        unset($operations);
        unset($tree);
		
	}
	
	public function Load() {
		global $core;
	
        if($core->fs->fileexists($this->storage_path."roles.cache", SITE))
			$this->roles = unserialize($core->fs->readfile($this->storage_path."roles.cache", SITE));
		else
			$this->roles = new Roles();
		
		if($core->fs->fileexists($this->storage_path."operations.cache", SITE))
			$this->operations = unserialize($core->fs->readfile($this->storage_path."operations.cache", SITE));
		else
			$this->operations = new Operations();

		if($core->fs->fileexists($this->storage_path."optree.cache", SITE))
			$this->operations_tree = unserialize($core->fs->readfile($this->storage_path."optree.cache", SITE));
		else
			$this->operations_tree = null;
			
	}
	
	public function RecreateCacheDatabase() {
		
        $this->operations->Clear();
        
		$global = new Operations();
		$global->Add(new Operation("structure.enter", "Add site"));
		$global->Add(new Operation("storages.enter", "Delete site"));
		$global->Add(new Operation("interface.enter", "Edit site properties"));
		$global->Add(new Operation("blobs.enter", "List the site content"));
		$global->Add(new Operation("notices.enter", "Add children"));
		$global->Add(new Operation("statistics.enter", "Delete children"));
		$global->Add(new Operation("settings.enter", "Edit children"));
		$global->Add(new Operation("sysrestore.enter", "Publish the entire site"));
		$global->Add(new Operation("usermanagement.enter", "Unpublish the entire site"));
        $global->Add(new Operation("modules.enter", "Unpublish the entire site"));
		$this->operations->Merge($global);
		
		$this->operations->Merge(Site::getOperations());
		$this->operations->Merge(Folder::getOperations());
		$this->operations->Merge(Storages::getOperations());
		$this->operations->Merge(Storage::getOperations());
		$this->operations->Merge(designTemplates::getOperations());
		$this->operations->Merge(Repository::getOperations());
		$this->operations->Merge(BlobCategories::getOperations());
		$this->operations->Merge(BlobCategory::getOperations());
		$this->operations->Merge(Notices::getOperations());
		$this->operations->Merge(Notice::getOperations());
		$this->operations->Merge(Statistics::getOperations());
		$this->operations->Merge(Settings::getOperations());
		$this->operations->Merge(Setting::getOperations());
		$this->operations->Merge(systemrestore::getOperations());
		$this->operations->Merge(SecurityEx::getOperations());
        $this->operations->Merge(CModuleManager::getOperations());
		
		// roles
		$administrator = new Role("system_administrator", "System administrator");
		$administrator->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_ALLOW),
					new RoleOperation("interface.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_ALLOW),
					new RoleOperation("notices.*", US_ROLE_ALLOW),
					new RoleOperation("statistics.*", US_ROLE_ALLOW),
					new RoleOperation("settings.*", US_ROLE_ALLOW),
					new RoleOperation("sysrestore.*", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.*", US_ROLE_ALLOW),
                    new RoleOperation("modules.*", US_ROLE_ALLOW)
		));

		$backupAdministrator = new Role("backup_administrator", "Backup administrator");
		$backupAdministrator->Add(new RoleOperation("sysrestore.*", US_ROLE_ALLOW));

		$manager = new Role("manager", "Data manager");
		$manager->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_DENY),
					new RoleOperation("structure.enter", US_ROLE_ALLOW),
					new RoleOperation("structure.folders.publications.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_DENY),
					new RoleOperation("storages.enter", US_ROLE_ALLOW),
					new RoleOperation("storages.storage.data.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_DENY),
					new RoleOperation("blobs.enter", US_ROLE_ALLOW),
					new RoleOperation("blobs.items.*", US_ROLE_ALLOW),
                    new RoleOperation("modules.*", US_ROLE_ALLOW)
		));

		$powermanager = new Role("power_manager", "Powered manager");
		$powermanager->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_DENY),
					new RoleOperation("structure.enter", US_ROLE_ALLOW),
					new RoleOperation("structure.folders.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_DENY),
					new RoleOperation("storages.enter", US_ROLE_ALLOW),
					new RoleOperation("storages.storage.data.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_ALLOW),
					new RoleOperation("statistics.*", US_ROLE_ALLOW),
					new RoleOperation("settings.*", US_ROLE_DENY),
					new RoleOperation("settings.edit", US_ROLE_ALLOW),
					new RoleOperation("notices.*", US_ROLE_DENY),
					new RoleOperation("notices.notice.*", US_ROLE_DENY),
					new RoleOperation("notices.enter", US_ROLE_ALLOW),
					new RoleOperation("notices.send", US_ROLE_ALLOW), 
					new RoleOperation("notices.edit", US_ROLE_ALLOW),
                    new RoleOperation("modules.*", US_ROLE_ALLOW)
		));

		$usermanager = new Role("user_manager", "User manager");
		$usermanager->AddRange(array(
					new RoleOperation("usermanagement.*", US_ROLE_DENY),
					new RoleOperation("usermanagement.enter", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.users.*", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.groups.*", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.permissions.*", US_ROLE_ALLOW)
		));

		$developer = new Role("developer", "Site developer");
		$developer->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_ALLOW),
					new RoleOperation("interface.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_ALLOW),
					new RoleOperation("notices.*", US_ROLE_ALLOW),
					new RoleOperation("statistics.*", US_ROLE_ALLOW),
					new RoleOperation("settings.*", US_ROLE_ALLOW),
					new RoleOperation("sysrestore.*", US_ROLE_ALLOW),
					new RoleOperation("modules.*", US_ROLE_ALLOW)
		));

        
        // $this->roles->Clear();
        
		$this->roles->Add($administrator);
		$this->roles->Add($backupAdministrator);
		$this->roles->Add($manager);
		$this->roles->Add($powermanager);
		$this->roles->Add($developer);
		$this->roles->Add($usermanager);
		
        
		$this->operations_tree = $this->operations->CreateTree();
		
		$this->Store();
		
		
	}
	
}

class UserListCache extends collection {
	
	function __construct(){
		parent::__construct();
	}
	
	public function Add($value) {
		if(!$value)
			return false;
		
		if($value instanceof User)
			$name = $value->name;
		else
			$name = $value;

		
		parent::Add($name, $name);

		$this->StoreCache();
	}
	
	public function Delete($value) {
		if(!$value)
			return false;		

		if($value instanceof User)
			$name = $value->name;
		else
			$name = $value;

		if(parent::exists($name)) {
			parent::Delete($name);
			User::Delete($name);
		}
		$this->StoreCache();
	}
	
	public function Item($key) {
		$key = $this->Key($key);
		if(!$this->exists($key))
			return false;
		return User::Load($key);
	}
	
	public function StoreCache() {
		global $core;		
		// $cache = serialize($this);
		// $core->fs->writefile(US_CACHE_PATH.US_USERS_CACHE, $cache);
	}
	
	public static function LoadCache() {
		global $core;
		$list = new UserListCache();
		$rs = $core->dbe->ExecuteReader("select users_name from ".US_USERS_TABLE);
		while($data = $rs->Read()) {
			$list->Add($data->users_name, $data->users_name);
		}
		return $list;
	}
	
}

class GroupListCache extends collection {
	
	function __construct(){
		parent::__construct();
	}
	
	public function Item($key) {
		$key = $this->Key($key);
		if(!$this->exists($key))
			return false;    
		return Group::Load($key);
	}
	
	public function Add($value) {
		if(!$value)
			return false;
		
		if($value instanceof Group)
			$name = $value->name;
		else
			$name = $value;

		parent::Add($name, $name);
		
		$this->StoreCache();
	}
	
	public function Delete($value) {
		if(!$value)
			return false;		
		
		if($value instanceof Group)
			$name = $value->name;
		else
			$name = $value;

		if(parent::exists($name)) {
			parent::Delete($name);
			Group::Delete($name);
		}		
		
		$this->StoreCache();
	}
	
	public function StoreCache() {
		global $core;		
		//$cache = serialize($this);
		//$core->fs->writefile(US_CACHE_PATH.US_GROUPS_CACHE, $cache);
	}
	
	public static function LoadCache() {
		global $core;
		$list = new GroupListCache();
		$rs = $core->dbe->ExecuteReader("select groups_name from ".US_GROUPS_TABLE);
		while($data = $rs->Read()) {
			$list->Add($data->groups_name, $data->groups_name);
		}
		return $list;
	}
	
}

class SecurityEx extends IEventDispatcher {
	
	static $instance = null;
															  
	static $users = null;
	static $groups = null;
	
	public $systemInfo;
	public $serialization;
	private $_currentUser = null;
    private $_supervisor = null;
	
	// static $supervisor = null;
	
	public function __construct($systemCache = false, $serialization = US_SECURITY_SERIALIZATION_SESSION) {      
		if(!is_null(SecurityEx::$instance)) {
			throw new Exception(US_ERROR_CLASSISNOTMULTIINSTACE);
		}
        
        SecurityEx::$instance = $this;

		$this->_checkTables();
        
		$this->DispatchEvent("security.loading", null);
        
		$this->DispatchEvent("security.systeminfo.loading", null);
		if(!$systemCache)
			$this->systemInfo = new SecuritySystemInfoCache();
		else
			$this->systemInfo = $systemCache;
        
	    
		$args = $this->DispatchEvent("security.systeminfo.loaded", Collection::Create($this->systemInfo));
		if(!is_null(@$args->systemInfo))
			$this->systemInfo = $args->systemInfo;
        
		$this->serialization = $serialization;
		
		$this->DispatchEvent("security.usermanagement.loading", null);
		SecurityEx::$users = UserListCache::LoadCache();
		SecurityEx::$groups = GroupListCache::LoadCache();
		$this->DispatchEvent("security.usermanagement.loaded", null);
		
		$this->DispatchEvent("security.loaded", null);
        
	}

    private function _loadCurrent() {
        if(is_null($this->_currentUser)) {
            if(@$_SESSION['CURRENT_USER'] != null)
                $this->_currentUser = User::Load($_SESSION['CURRENT_USER']);
            else
                $this->_currentUser = $this->Nobody();
        }
    }
    
    private function _loadSupervisor() {
        $this->_supervisor = $this->Supervisor();
    }
        
    public function __get($prop) {
        switch($prop) {
            case "currentUser":
                $this->_loadCurrent();
                return $this->_currentUser;
            case "supervisor":
                $this->_loadSupervisor();
                return $this->_supervisor;
        }
    }
    
    public function __set($prop, $value) {
        switch($prop) {
            case "currentUser":
                $this->_currentUser = $value;
        }
    }

    public function Dispose() {
        // $this->systemInfo;
        SecurityEx::$users->Clear();
        SecurityEx::$groups->Clear();
    }
	
	public function RegisterEvents() {
		$this->RegisterEvent("security.initializing");
		$this->RegisterEvent("security.initialized");
		$this->RegisterEvent("security.loading");
		$this->RegisterEvent("security.loaded");
		$this->RegisterEvent("security.systeminfo.loading");
		$this->RegisterEvent("security.systeminfo.loaded");
		$this->RegisterEvent("security.usermanagement.loading");
		$this->RegisterEvent("security.usermanagement.loaded");
		$this->RegisterEvent("security.user.loggingin");
		$this->RegisterEvent("security.user.logged");
		$this->RegisterEvent("security.user.loggingout");
		$this->RegisterEvent("security.user.loggedout");
		$this->RegisterEvent("security.permissions.checking");
		$this->RegisterEvent("security.permissions.checked");
		$this->RegisterEvent("security.permissions.batch.checking");
		$this->RegisterEvent("security.permissions.batch.checked");
		$this->RegisterEvent("security.permissions.role.checking");
		$this->RegisterEvent("security.permissions.role.checked");
	}
	
	public function RegisterEventHandlers() {
		$this->DispatchEvent("security.initializing", null);

		// ToDo: 
		
		$this->DispatchEvent("security.initialized", null);
	}
	
	public function Initialize() {
		
		
		
	}
	
	public function Nobody() {
		$u = new User();
		$u->name = "nobody";
		$u->description = "Default uninitialized user";
		$u->password = "";
		return $u;
	}

	public function Supervisor() {
		$u = new User();
		$u->name = "supervisor";
		$u->description = "Super user";
		$u->password = Encryption::Decrypt("supervisor", "eogW/V/dQx5sRC8=");
		$u->roles->Add("system_administrator");
		return $u;
	}
	
	public function Login($userName, $password)	{
		
		$args = $this->DispatchEvent("security.user.loggingin", Collection::Create("username", $userName, "password", $password));
		if(@$args->cancel) 
			return @$args->logged;
	
		if($userName instanceof User)
			$currentUser = $userName;
		else {
			if(SecurityEx::$users->exists($userName) || $userName == "supervisor")
				$currentUser = User::Load($userName);
			else {
				$this->DispatchEvent("security.user.logged", Collection::Create("success", false));
				return false; 
			}
		}
		
		if($currentUser->password == $password) {
			$this->currentUser = $currentUser;
			
			$this->currentUser->LastLoginDate = time();
			$this->currentUser->LastLoginFrom = get_ip();
			
			$this->setLogged($this->currentUser);
			
			$this->currentUser->Save();
			
			$this->DispatchEvent("security.user.logged", Collection::Create("success", true));
			return true;
		}
		$this->currentUser = $this->Nobody();
		
		$this->DispatchEvent("security.user.logged", Collection::Create("success", false));
		return false;
	}
	
	public function Logout() {
		$this->DispatchEvent("security.user.loggingout", null);
		$this->setLoggedOut();
		$this->currentUser = $this->Nobody();		
		$this->DispatchEvent("security.user.loggedout", null);
	}

	public function setLogged($user) {
		global $core;
		$core->rq->CURRENT_USER = $user->name;
	}
	
	public function setLoggedOut() {
		global $core;
		$core->rq->CURRENT_USER = null;
	}
	
	private function _compareOperation($operation, $roleoperation) {
		$roleoperation = preg_quote($roleoperation);
		$roleoperation = str_replace("\*", "(.*?)", $roleoperation);
		return preg_match("/".$roleoperation."/", $operation) > 0;
	}
	
	/**
		Checks a permissions for objects array
		$objects - array	(
								array(
									"object" => $object,
									"operation" => $operation 
								), 
								... ,
								array(
									"object" => $object,
									"operation" => $operation 
								)
							)
	*/
	public function CheckBatch($objects, $user = null) {
		
		if(is_null($user))
			$user = $this->currentUser;
		
		$arg = $this->DispatchEvent("security.permissions.batch.checking", Hashtable::Create("objects", $objects, "user", $user));
		if(@$arg->cancel)
			return (boolean)($args->rights == 1);
		
		foreach($objects as $item) {
			$object = $item["object"];
			$operation = $item["operation"];
			
			if(($rights = $this->_checkOwnPermissions($object, $operation, $user)) > -1) {
				
				$args = $this->DispatchEvent("security.permissions.batch.checked", Hashtable::Create("objects", $objects, "user", $user, "rights", $rights));
				if(@$args->cancel)
					return (boolean)($args->rights == 1);
					
				return (boolean)($rights == 1);
			}
			
		}
		
		foreach($objects as $item) {
			$operation = $item["operation"];
			if(($rights = $this->_checkRolePermissions($operation, $user)) > -1) {
				$args = $this->DispatchEvent("security.permissions.batch.checked", Hashtable::Create("objects", $objects, "user", $user, "rights", $rights));
				if(@$args->cancel)
					return (boolean)($args->rights == 1);
				
				return (boolean)($rights == 1);
			}
				
		}
		
		$args = $this->DispatchEvent("security.permissions.batch.checked", Hashtable::Create("objects", $objects, "user", $user, "rights", $rights));
		if(@$args->cancel)
			return $args->rights;
			
		return (boolean)($rights == 1);
	}
						
	public function Check($object = null, $operation = "", $user = null) {
		if($operation == "")
			return false;
		
		if(is_null($user))
			$user = $this->currentUser;

		$arg = $this->DispatchEvent("security.permissions.checking", Hashtable::Create("object", $object, "operation", $operation, "user", $user));
		if(@$arg->cancel)
			return $args->rights;
		
		if($object != null) {
			if(($rights = $this->_checkOwnPermissions($object, $operation, $user)) < 0) {
				$rights = $this->_checkRolePermissions($operation, $user);
			}	
		}
		else
			$rights = $this->_checkRolePermissions($operation, $user);
		
		$args = $this->DispatchEvent("security.permissions.checked", Hashtable::Create("object", $object, "operation", $operation, "user", $user, "rights", $rights));
		if(@$args->cancel)
			return (boolean)($args->rights == 1);

		return (boolean)($rights == 1);
	}
	
	private function _checkRolePermissions($operation, $user) {
		$roles = $user->roles;
		$permissions = new Collection();
		foreach($roles as $role) {
			$r = $this->systemInfo->roles->$role;
			if ($r == null)
				continue;
				
			foreach($r as $op)
				$permissions->Add($op->operation, $op->permission);
		}
		
		//$permissions->Sort();
		$rights = -1;
		foreach($permissions as $roleoperation => $permission) {
			if($this->_compareOperation($operation, $roleoperation)) {
				$rights = $permission;
			}
		}
		return $rights;
	}	
	
	private function _checkOwnPermissions($object, $operation, $user) {
		$permissions = new Collection();
		// append the user own permissions to the end of list
		if($object->securitycache->Count() > 0) {
			// check if the user or one of its groups is in the list
			foreach($object->securitycache as $key => $item) {
				if($user->name == $key) {
					foreach($item as $ro) {
						$permissions->Add($ro->operation, $ro->permission);
					}
					continue;
				}
				$founded = $user->groups->Search($key);
				if(count($founded) > 0) {
					foreach($item as $ro) {
						$permissions->Add($ro->operation, $ro->permission);
					}
					continue;
				}
			}
		}
		else {
			return -1;
		}
		
		if($permissions->Count() == 0) {
			return -1;
		}
		
		$rights = 0;
		foreach($permissions as $roleoperation => $permission) {
			if($this->_compareOperation($operation, $roleoperation)) {
				$rights  = $permission;
			}
		}
		return $rights;
	}

	public static function getOperations() {
		$operaions = new Operations();
		$operaions->Add(new Operation("usermanagement.users.add", "Add a new user"));
		$operaions->Add(new Operation("usermanagement.users.delete", "Delete the user"));
		$operaions->Add(new Operation("usermanagement.users.edit", "Edit main user info"));
		$operaions->Add(new Operation("usermanagement.groups.add", "Add a user group"));
		$operaions->Add(new Operation("usermanagement.groups.delete", "Delete the group"));
		$operaions->Add(new Operation("usermanagement.groups.edit", "Edit group properties"));
		$operaions->Add(new Operation("usermanagement.roles.create", "Create a role"));
		$operaions->Add(new Operation("usermanagement.roles.delete", "Remove the role"));
		$operaions->Add(new Operation("usermanagement.roles.edit", "Edit the role"));
		$operaions->Add(new Operation("usermanagement.persmissions.set", "Set the permissions"));
		$operaions->Add(new Operation("usermanagement.cache.recreate", "Edit the role"));
		return $operaions;
	}

	private function _checkTables() {
		global $core;
		if(!$core->dbe->tableexists("sys_umusers")) {
            
            $core->dbe->CreateTable('sys_umusers', array(
                'users_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'users_created' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_modified' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_password' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
                'users_lastlogindate' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_lastloginfrom' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_roles' => array('type' => 'longtext', 'additional' => ''),
                'users_profile' => array('type' => 'longtext', 'additional' => ''),
            ), array(
                'users_name' => array('fields' => 'users_name', 'constraint' => 'PRIMARY KEY')
            ), '');

        }
        if(!$core->dbe->tableexists("sys_umgroups")) {
            $core->dbe->CreateTable('sys_umgroups', array(
                'groups_name' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\''),
                'groups_description' => array('type' => 'tinytext', 'additional' => '')
            ), array(
                'groups_name' => array('fields' => 'groups_name', 'constraint' => 'PRIMARY KEY')
            ), '');
        }
        if(!$core->dbe->tableexists("sys_umusersgroups")) {
            $core->dbe->CreateTable('sys_umusersgroups', array(
                'user' => array('type' => 'varchar', 'additional' => 'NOT NULL default \'\''),
                'group' => array('type' => 'varchar', 'additional' => 'NOT NULL default \'\'')
            ), array(
                'user_group' => array('fields' => 'user,group', 'constraint' => 'PRIMARY KEY')
            ), '');
        }
	}

}



?>
