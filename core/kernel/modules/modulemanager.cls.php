<?
	class CModuleManager {
		
		//language resources, delta order
		
		private static $_instance;
		private $_modules;
		public static $types = array("Системный", "Пользовательский");
		
		const SYS_TABLE = "sys_modules";
		const SYS_TABLE_ID = "module_id";
		
		private function CModuleManager(){
			  
		}
        
        public function Dispose() {
            $this->_modules->Clear();
        }
		
		function __get($key){
			switch ($key){
				case "activemodules" :
					return clone $this->_modules;
				case "modules" : 
					return CModuleManager::Enum("", "", false);
				default :
			}
		}
		
		function __set($key, $value){
			
		}
		
		public static function Instance() {
			if (!isset(self::$_instance)) {
				$c = __CLASS__;
				self::$_instance = new $c;
			}
			return self::$_instance;
		}
		
		public function __clone() {
			
		}
		
		public function RegisterEvents(){
			
		}
		
		public function RegisterEventHandlers(){
			
		}
		
		public function Initialize(){
			
			$this->_modules = new collection();
			//$modules = CModuleManager::Enum("module_state = '".MODULE_ENABLED."' or module_state = '".MODULE_INSTALLED."'");
			
			global $core;
			
			$ex = $core->isAdmin ? "" : " and module_type = '1'";
			
			$modules = CModuleManager::Enum("module_state = '".MODULE_ENABLED."' or module_state = '".MODULE_CREATED."'".$ex);
			
			// iout($modules);
			if (!$modules)
				return;
			
			while ($mod = $modules->FetchNext()){
				$inst = $this->CreateInstance($mod);
				
				if (!($inst instanceof CModule))
					continue;
				
				$this->_modules->Add($inst->entry, $inst);
				
				if (method_exists($inst, "RegisterEvents"))
					$inst->RegisterEvents();
				
				if (method_exists($inst, "RegisterEventHandlers"))
					$inst->RegisterEventHandlers();
				
				$libs = $inst->libraries;
				foreach ($libs as $l){
					$lib = new Library($l);
					$lib->Run();
				}
				
				$inst->Initialize();
			}
		}
		
		public function GetData(){
			return clone $this->_modules;
		}
		
		//create empty module
		public static function NewModule(){
			return new CModule(-1);
		}
		
		//save module full data
		public static function Save($mod, $iid = -1){
			if (is_empty($mod))
				return;
			
			global $core;
			
			if (!($mod instanceof CModule))
				$mod = new CModule($mod);
			
			$id = $mod->id;
			$data = $mod->GetData(false);
			if (!$data)
				return;

            $data->delete("module_id");
				
			if ($id == -1){
				$rs = $core->dbe->ExecuteReader("select module_order from ".self::SYS_TABLE." order by module_order DESC");
				if ($rs->Count() > 0)
					$data->module_order = $rs->Read()->module_order + 1;
				$mod->order = $data->module_order;
                if($iid > 0) {
                    $data->add("module_id", $iid);
                }
				
                $id = $core->dbe->insert(self::SYS_TABLE, $data);
				if ($id && $iid < 0)
					$mod->id = $id;
                else
                    $mod->id = $iid;
                    
			} else
				$core->dbe->set(self::SYS_TABLE, self::SYS_TABLE_ID, $id, $data);
		}
		
		//delete module
		public static function Delete($ini, $version = ""){
			global $core;
			
			$mod = ($ini instanceof CModule) ? $ini : new CModule($ini, $version);
			
			if (!$mod->IsValid())
				return;
				
			if ($mod->templates->Count() > 0){
				$tpls = $mod->templates;
				foreach ($tpls as $t){
					$t->Delete();
				}
			}
			if ($mod->libraries->Count() > 0){
				$libs = $mod->libraries;
				foreach ($libs as $l) {
					$lib = new Library($l);
					$lib->Delete();
				}
			}
			if ($mod->storages->Count() > 0){
				$st = new storages();
				foreach ($mod->storages as $s) {
					$ss = new Storage($s);
					$ss->Delete();
				}
			}
			$pubs = $mod->Publications();
			if ($pubs)
				foreach ($pubs as $pub)
					$pub->Discard();
			$res = $core->dbe->delete(self::SYS_TABLE, self::SYS_TABLE_ID, $mod->id);
		}
		
		//get next module order
		public static function NewOrder(){
			global $core;
			
			$rs = $core->dbe->ExecuteReader("select module_order from ".self::SYS_TABLE." order by module_order DESC limit 2");
			if ($rs->Count() < 2)
				return 0;
			
			$al = $rs->ReadAll();
			$max = $al->Item(0)->module_order;
			$min = $al->Item(1)->module_order;
			
			return $max + abs($min - $max);
		}
		
		public function CreateInstance($ini){
			if (is_empty($ini))
				return;
			
			global $core;
			
			$mod = new CModule($ini);
			if (!$mod->IsValid())
				return;
			
			$inst = null;
			if ($this->_modules)
				foreach ($this->_modules as $item)
					if ($item->id == $mod->id)
						return $item;
			
			$inst = null;
			
			$code = load_from_file($mod->code);
			
			// $ret = "";
			
            $context = new OutputContext($mod->entry);

			$code = convert_php_context($code);
            
            eval($code);    
			
			$iname = $mod->entry;
			
			if(!class_exists($iname))
				return;
			
			$inst = new $iname();
			$inst->ConstructorInitialize($mod);
            $inst->Initialize();
			
			if ($inst->state == MODULE_CREATED){
				$inst->Install();
				$inst->state = MODULE_ENABLED; //MODULE_DISABLED
				$inst->Save();
			}
            
			
			return $inst;
		}
		
		public static function Uninstall($ini){
			global $core;
			try {
				//$mod = ($ini instanceof CModule) ? $ini : new CModule($ini);
				//$inst = CModuleManager::CreateInstance($ini);
				$inst = $core->mm->CreateInstance($ini);
				if (!$inst)
					return;
					
				//$core->dbe->StartTrans();
				
				$inst->Uninstall();
				CModuleManager::Delete($inst);
				
				//$core->dbe->CompleteTrans();
				
			} catch (exception $ex){
				//$core->dbe->FailTrans();
			}
		}
		
		public static function Enum($condition = "", $order = "", $raw = true){
			global $core;
			$res = $core->dbe->ExecuteReader("SELECT * FROM ".self::SYS_TABLE."".
				((!is_empty($condition)) ? " WHERE ".$condition : "").
				" ORDER BY module_order".((!is_empty($order)) ? ", ".$order : ""), 
				self::SYS_TABLE_ID);
				
			if (!$res->HasRows())
				return;
				
			if ($raw)
				return $res;
				
			$m = new Collection();
			while ($item = $res->Read())
				$m->add($item->module_entry, new CModule($item));
			
			return $m;
		}
        
        public static function getOperations() {
            $operaions = new Operations();
            
            $modules = CModuleManager::Instance()->activemodules;
            foreach($modules as $module) {
                if(method_exists($module, "getOperations"))
                    $operaions->Merge($module->getOperations());
            }
    
            return $operaions;
        }
        
        public function ToPHPScript() {
            $ret = '/* Dumping modules */'."\n\n"; 
            foreach($this->activemodules as $module) {
                $ret .= $module->ToPhpScript();
            }
            return $ret;
        }
        
	}
	
?>
