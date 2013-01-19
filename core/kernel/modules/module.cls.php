<?
    class CModule extends IEventDispatcher {

        protected $_data;
        protected $_icons;
        protected $_prefix;
        protected $_datascheme;
        
        function CModule($ini, $version = "") { //id, name or data
            global $core;
            
            if (is_empty($ini)){
                $this->_data = new collection();
                return;
            }

            $this->ConstructorInitialize($ini, $version);
            
            /*if (!$this->_data instanceof collection)
                $this->createSchema();*/
            
            $this->_prefix = strtolower($this->entry);
            
        }
        
        function __get($key){
            if (!($this->_data instanceof collection))
                return;
                
            switch (strtolower($key)){
                case "prefix" :
                    return $this->_prefix;
                case "admincompat" :
                    if (!($this->_data->module_admincompat instanceof arraylist))
                        $this->loadAdminCompat();
                    return $this->_data->module_admincompat;
                case "compat" :
                    if (!($this->_data->module_compat instanceof arraylist))
                        $this->loadCompat();
                    return $this->_data->module_compat;
                case "libraries" :
                    if (!($this->_data->module_libraries instanceof arraylist))
                        $this->loadLibraries();
                    return $this->_data->module_libraries;
                case "storages" :
                    if (!($this->_data->module_storages instanceof arraylist))
                        $this->loadStorages();
                    return $this->_data->module_storages;
                case "templates" :
                    if (!($this->_data->module_templates instanceof Templates))
                        $this->loadTemplates();
                    return $this->_data->module_templates;
                case "icons" :
                    if(!($this->_icons instanceof IconPack))
                        $this->_icons = new IconPack($this->_data->module_iconpack);
                        //$this->_icons = new IconPack($this->iconpack, "/images/icons");
                    
                    return $this->_icons;
                case 'datascheme':
                    return $this->_datascheme;
                default :
                    $name = $this->fname($key);
                    
                    if (!$this->_data->exists($name))
                        return $this->getProperty($key);
                    
                    return $this->_data->$name;
            }
        }
        
        function __set($key, $value){
            if ($key == "compat" || $key == "storages" || $key == "libraries" 
                || $key == "templates" || !($this->_data instanceof collection))
                return;
                
            $name = $this->fname($key);

            if (!$this->_data->exists($name)){
                $this->setProperty($key, $value);
                return;
            }
            
            $this->_data->$name = $value;
        }
        
        public function Initialize(){
            global $core;
            $this->_datascheme = new PioneerScheme($core->dbe);
            
        }
        
        public function ConstructorInitialize($ini, $version = ""){
            
            if (!is_object($ini)){
                if (intval($ini) == -1)
                    $this->createSchema();
                else
                    $this->load($ini, $version);
            } else {
                $this->load($ini, $version);
            }
        }
        
        public function Create($order, $state, $entry, $title, $description, $version, $admincompat, $compat, $code, $storages, $libraries, $type, $haseditor, $publicated, $favorite, $iconpackname, $id = -1) {
            $mod = new CModule(-1);
            $mod->publicated = $publicated;
            $mod->favorite = $favorite;
            $mod->haseditor = $haseditor;
            $mod->type = $type;
            $mod->entry = $entry;
            $mod->title = $title;
            $mod->description = $description;
            $mod->version = $version;
            $mod->code = $code;
            $mod->iconpack = $iconpackname;
            
            $mod->admincompat->Clear();
            $mod->compat->Clear();
            $mod->libraries->Clear();
            $mod->storages->Clear();
            
            $mod->admincompat->FromString($admincompat);
            $mod->compat->FromString($compat);
            $mod->libraries->FromString($libraries);
            $mod->storages->FromString($storages);
            
            $mod->Save($id);            
            return $mod;
        }
        
        /* information interface members */
        public function IsValid(){
            return $this->_data->Count() > 0;
        }
        
        public function GetData($raw = true){
            if (!($this->_data instanceof collection))
                return;
                
            $this->admincompat;
            $this->compat;
            $this->libraries;
            $this->storages;
            if ($raw)
                return clone $this->_data;
            
            $data = clone $this->_data;
            $data->module_admincompat = $data->module_admincompat->ToString();
            $data->module_compat = $data->module_compat->ToString();
            $data->module_libraries = $data->module_libraries->ToString();
            $data->module_storages = $data->module_storages->ToString();
            return $data;
        }
        
        /* visual interface members */
        public function Out($template = TEMPLATE_DEFAULT, $user_params = null, $operation = OPERATION_LIST){
            if ($this->_data->module_state != MODULE_ENABLED)
                return "";
            $t = template::create($template, $this);
            return $t->Out($operation, $this, $user_params);
        }
        
        /* link interface members */
        public function Publications(){
            global $core;
            
            $r = $core->dbe->ExecuteReader("
                select * from sys_links 
                    where link_child_storage_id = ".$this->_data->module_id." and link_object_type = 1 
                    order by link_order
            ");
            if (!$r)
                return;
                
            $c = new collection();
            while($rr = $r->Read())
                $c->add("p".$rr->link_id, new Publication($rr, $this));
            return $c;
        }
        
        public function ToXML($exportdata = false, $update_info = null, $head = ""){
            /*$doc = new DomDocument();
            $doc->LoadXml($xml);
            $doc->normalize();
            $el = $doc->documentElement;*/
            
            $ret = "<module>";
            if (!is_empty($update_info)){
                $ret .= "<update><version>".$update_info."</version></update>";
            }
            if (!is_empty($head))
                $ret .= $head;
            
            $this->templates;
            $this->libraries;
            $this->storages;
            $this->compat;
            $this->admincompat;
            
            $pt = $this->templates;
            $rep = new repository();
            $st = new storages();
            foreach ($this->_data as $k => $v){
                switch ($k){
                    case "module_libraries" :
                        $ret .= $rep->ToXML($this->libraries->get_array());
                        break;
                    case "module_storages" :
                        $ret .= $st->ToXML($this->storages->get_array());
                        break;
                    case "module_templates" :
                        //$ret .= $pt->to_xml();
                        $ret .= $pt->ToXML();
                        break;
                    case "module_compat" :
                        $ret .= "<compat>".$this->compat->ToXML()."</compat>";
                        break;
                    case "module_admincompat" :
                        $ret .= "<admincompat>".$this->admincompat->ToXML()."</admincompat>";
                        break;
                    case "module_code" :
                        if (substr(trim($v), 0, 9) == "LOADFILE:"){
                            global $core;
                            //$v = addslashes($core->fs->readfile(substr(trim($v), 9, strlen(trim($v))), SITE));
                            $v = $core->fs->readfile(substr(trim($v), 9, strlen(trim($v))), SITE);
                        }
                        $prop = $this->fromfname($k);
                        $ret .= "<".$prop."><![CDATA[".$v."]]></".$prop.">";
                        break;
                    case "module_iconpack" :
                        $ret .= "<resources>".$this->icons->ToXML()."</resources>";
                        break;
                    default :
                        $prop = $this->fromfname($k);
                        $ret .= "<".$prop.">".$v."</".$prop.">";
                }
            }
            
            if ($exportdata && $this->storages->Count() > 0){
                $ret .= "<data>";
                foreach ($this->storages as $storage){
                    $s = storages::get($storage);
                    $drs = new DataRows($s);
                    $drs->Load();
                    $ret .= $drs->to_xml();
                }
                $ret .= "</data>";
            }
            
            $ret .= "</module>";
            return $ret;
        }
        
        public function to_xml($exportdata = false, $update_info = null, $head = ""){
            return $this->ToXML($exportdata, $update_info, $head);
        }
        
        public function FromXML($el){
            $vls = array(); $dataNode = null; $tplNode = null;
            
            $rep = new Repository();
            $stgs = new storages();
            $pt = new Templates(null, TEMPLATE_MODULE);
            
            $childs = $el->childNodes;
            foreach ($childs as $pair){
                switch ($pair->nodeName){
                    case "repository" :
                        $rep->FromXML($pair);
                        foreach($rep as $l)
                            $this->libraries->Add($l->name);
                        // $vls[] = "module_libraries = '".$this->_data->module_libraries."'";
                        break;
                    case "storages" :
                        //check table exists
                        $stgs->FromXML($pair);
                        foreach ($stgs as $s)
                            $this->storages->Add($s->table);
                        // $this->_data->module_storages = substr($this->_data->module_storages, 1);
                        //$vls[] = "module_storages = '".$this->_data->module_storages."'";
                        break;
                    case "templates" :
                        $pt->FromXML($pair);
                        break;
                    case "compat" :
                        $a = new arraylist();
                        $a->FromXML($pair->childNodes->item(0));
                        $this->compat->Append($a);
                        // $vls[] = "module_compat = '".$this->_data->module_compat."'";
                        break;
                    case "admincompat" :
                        $a = new arraylist();
                        $a->FromXML($pair->childNodes->item(0));
                        $this->admincompat->Append($a);
                        // $vls[] = "module_admincompat = '".$this->_data->module_admincompat."'";
                        break;
                    case "data" :
                        $dataNode = $pair;
                        break;
                    case "order" :
                    case "state" :
                        break;
                    case "resources" :
                        if($pair->childNodes->length > 0)
                            if($pair->childNodes->item(0)->childNodes->length > 0)
                                $this->icons->FromXML($pair->childNodes->item(0));        
                        break;
                    default :
                        $name = $this->fname($pair->nodeName);
                        if (!$this->_data->exists($name))
                            continue;
                        
                        $this->_data->$name = $pair->nodeValue;
                        if ($name != "module_id" && $name != "module_order" && $name != "module_state")
                            $vls[] = $name." = '".addslashes($this->_data->$name)."'";
                        break;
                }
            }
            
            //$mods = CModuleManager::Enum(implode(" and ", $vls)); //check only entryPoint
            //if ($mods)
                //return;
            
            $this->id = -1;
            

            global $core;
            $this->Save();
            iout($this);
            exit;
            

            foreach($pt as $t) {
                $t->module_id = $this->id;
                $this->templates->Add($t);
            }
                
            
            $pt->Save();
            
            $rep->Save();
            
            $stgs->Save();
            
            if ($dataNode){
                $childs = $dataNode->childNodes;
                foreach ($childs as $pair){
                    $stname = $pair->getAttribute("storage");
                    if (is_empty($stname))
                        continue;
                    
                    $st = storages::get($stname);
                    
                    $drs = new DataRows($st);
                    $drs->from_xml($pair);
                }
            }
            
            
        }
        
        public function from_xml($el){
            $this->FromXML($el);
        }
        
        /* misc members */
        protected function fname($field, $table = ""){
            $table = (is_empty($table)) ? "module" : $this->tname($table);
            return $table."_".$field;
        }
        
        protected function tname($table){
            return "module_".$this->_prefix."_".$table;
        }
        
        protected function fromfname($field, $table = ""){
            $sub = (is_empty($table)) ? "module_" : $this->tname($table)."_";
            if (strpos($field, $sub) === false)
                return $table;
            
            return substr($field, strlen($sub));
        }
        
        protected function fromtname($table){
            $sub = "module_".$this->_prefix."_";
            if (strpos($table, $sub) === false)
                return $table;
                
            return substr($table, strlen($sub));
        }
        
        private function createSchema(){
            $this->_data = new collection();
            $this->_data->add("module_id", -1);
            $this->_data->add("module_order", 0);
            $this->_data->add("module_state", 0); //
            $this->_data->add("module_entry", "");
            $this->_data->add("module_title", "");
            $this->_data->add("module_description", "");
            $this->_data->add("module_version", "");
            $this->_data->add("module_code", "");
            $this->_data->add("module_type", 0);
            $this->_data->add("module_favorite", 0);
            $this->_data->add("module_haseditor", 0);
            $this->_data->add("module_publicated", 0);
            $this->_data->add("module_iconpack", 0);
        }
        
        private function loadAdminCompat(){
            $t = $this->_data->module_admincompat;
            $this->_data->module_admincompat = new arraylist();
            $this->_data->module_admincompat->FromString($t);
        }
        
        private function loadCompat(){
            $t = $this->_data->module_compat;
            $this->_data->module_compat = new arraylist();
            $this->_data->module_compat->FromString($t);
        }
        
        private function loadStorages(){
            $t = $this->_data->module_storages;
            $this->_data->module_storages = new arraylist();
            $this->_data->module_storages->FromString($t);
            //$this->_data->module_storages->add($name, storages::get($name));
        }
        
        private function loadLibraries(){
            $t = $this->_data->module_libraries;
            $this->_data->module_libraries = new arraylist();
            $this->_data->module_libraries->FromString($t);
            //$this->_data->module_libraries->add($name, new Library($name));
        }
        
        private function loadTemplates(){
            $this->_data->add("module_templates", new Templates($this, TEMPLATE_MODULE));
        }
        
        /* main functionality members */
        private function load($ini, $version = "") {
            global $core;

            if (is_object($ini)){
                if ($ini instanceof CModule){
                    $this->_data = $ini->GetData();
                    return;
                }
                if ($ini instanceof collection){
                    if (!is_empty($ini->module_id))
                        $this->_data = $ini;
                } else if (!is_empty($ini->module_id)) { 
                    $this->_data = Collection::Create($ini instanceOf Object ? $ini->Data() : $ini);
                }
                
                return;
            }
            
            if (is_numeric($ini))
                $ex = "module_id = ".$ini;
            else if (is_string($ini))
                $ex = is_empty($version) 
                    ? "module_entry = '".$ini."' ORDER BY module_version DESC LIMIT 1"
                    : "module_entry = '".$ini."' AND module_version = '".$version."' LIMIT 1";
            else
                return;
            
            $rs = $core->dbe->ExecuteReader("SELECT * FROM ".CModuleManager::SYS_TABLE." WHERE ".$ex, "module_id");
            if (!$rs->HasRows())
                return false;
            
            $data = $rs->Read();
            //$data->module_code = stripslashes($data->module_code);
            $data->module_code = $data->module_code;
            //$t = stripslashes($data->module_compat);
            $t = $data->module_compat;
            $data->module_compat = new arraylist();
            $data->module_compat->FromString($t);
            //$t = stripslashes($data->module_libraries);
            $t = $data->module_libraries;
            $data->module_libraries = new arraylist();
            $data->module_libraries->FromString($t);
            //$t = stripslashes($data->module_storages);
            $t = $data->module_storages;
            $data->module_storages = new arraylist();
            $data->module_storages->FromString($t);

            $this->_data = $data->ToCollection();
            
            
        }
        
        public function Loaded() {
        }
        
        public function Save($id = -1){
            if ($this->_data instanceof collection)
                CModuleManager::Save($this, $id);
        }
        
        public function Delete(){
            if ($this->_data instanceof collection)
                CModuleManager::Delete($this);
        }
        
        /* inheritance members */
        public function GetBlock($name){
            
        }
        
        public function Install(){ 
            
        }
        
        public function Uninstall(){ 
            
        }
        
        public function RegisterEvents(){
            
        }
        
        public function RegisterEventHandlers(){
            
        }
        
        protected function Render($args = null){
            
        }
        
        protected function getProperty($key){
            return;
        }
        
        protected function setProperty($key, $value){
            return;
        }
        
        public function ToPHPScript() {
            $ret = '/* Dumping module '.$this->table.' */'."\n";
            
            $storages = ''; foreach($this->storages as $s) $storages .= ','.$s->table; $storages = substr($storages, 1); 
            $libraries = ''; foreach($this->libraries as $l) $libraries .= ','.$l->name; $libraries = substr($libraries, 1); 
            
            $ret = '
                $module'.$this->entry.' = $core->mm->activemodules->Item("'.$this->entry.'");
                if(!is_null($module'.$this->entry.')) $module'.$this->entry.'->Delete();
                $module'.$this->entry.' = CModule::Create('.$this->order.', '.$this->state.', "'.$this->entry.'", "'.$this->title.'", "'.$this->description.'", "'.$this->version.'", "'.$this->admincompat->ToString().'", "'.$this->compat->ToString().'", hex2bin("'.bin2hex(load_from_file($this->code)).'"), "'.$storages.'", "'.$libraries.'", "'.$this->type.'", '.($this->haseditor ? 1 : 0).', '.($this->publicated ? 1 : 0).', '.($this->favorite ? 1 : 0).', "'.$this->_data->iconpack.'", '.$this->id.');
                $module'.$this->entry.' = $core->mm->CreateInstance($module'.$this->entry.'->id);
                //$module'.$this->entry.'->Install();
                '.$this->templates->ToPHPScript('$module'.$this->entry).'
                ';
            
            return $ret;
            
        }
        
    }
    
?>
