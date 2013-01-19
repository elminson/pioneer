<?php


class NavigatorCache {
    
    private $_paths;
    private $_data;
    private $_domains;
    
    public function __construct() {
        global $SYSTEM_USE_MEMORY_CACHE;
        $this->_data = new Collection();
        $this->_paths = new Collection();
        $this->_domains = new Collection();
    }
    
    public function Add($key, $item) {
        
        if(is_numeric($key)) {
            $this->_data->Add('id'.$key, $item);
        }
        else {
            if(!$this->_data->Exists('id'.$item->tree_id))
                $this->_data->Add('id'.$item->tree_id, $item);
            $this->_paths->Add($key, 'id'.$item->tree_id);
            
        }
        
        if($item->tree_level == 1)
            $this->_domains->Add($item->tree_domain, 'id'.$item->tree_id);
    }
    
    public function Delete($key) {
        if(is_numeric($key)) {
            $item = $this->Item($key);
            $this->_data->Delete('id'.$item->tree_id);
            $this->_paths->Delete($this->_paths->IndexOfFirst('id'.$item->tree_id));
        }
        else {
            $id = $this->_paths->Item($key);
            $this->_data->Delete($id);
            $this->_paths->Delete($key);
        }
    }
    
    public function Path($key) {
        
        //$t = microtime(true);
        $index = $this->_paths->IndexOfFirst('id'.$key);
        //$t = (microtime(true) - $t)*1000;
        //out('index of node', $t);
        
        //$t = microtime(true);
        $r = $this->_paths->Key($index);
        //$t = (microtime(true) - $t)*1000;
        //out('path by index', $t);
        
        return $r;
    }
    
    public function Domain($domain) {
        $domain = str_replace('www.', '', $domain);
        return $this->_data->Item($this->_domains->Item($domain));
    }
    
    public function Item($key) {
        if(is_numeric($key))
            return $this->_data->Item('id'.$key);
        else {
            return $this->_data->Item($this->_paths->Item($key));
        }
    }
    
    public function Clear() {
        $this->_data->Clear();
        $this->_paths->Clear();
        $this->_domains->Clear();
    }
    
    public function ByName($name) {
        $ret = new ArrayList();
        foreach($this->_paths as $key => $item) {
            $path = explode('/', $key);
            if( $path[count($path) - 1] == $name )
                $ret->Add($this->_data->Item($item));
        }
        return $ret;
    }    
    
    public function PrecacheTree() {
        global $core;
        
        $this->Clear();
        
        /*$startTime = microtime(true);*/
        
        $last = null;
        $cpath = array();
        $dbt = new dbtree("sys_tree", "tree");
        $results = $core->dbe->ExecuteReader('select *, (select count(*) from sys_links where link_parent_storage_id=0 and link_parent_id=sys_tree.tree_id) as tree_publications from sys_tree where tree_level > 0 order by tree_left_key');
                                                                                                                                             
        /*$startTime2 = microtime(true);*/
        while($result = $results->Read()) {
            $obj = $result; //$result->tree_level > 1 ? new Folder($dbt, $result) : new Site($result);
            if(!is_null($last)) {
                if(!$this->_IsChildOf($obj, $last)) {
                    if($last->tree_level == $obj->tree_level)
                        array_splice($cpath, count($cpath) - 1, 1);
                    else if($last->tree_level > $obj->tree_level) {
                        array_splice($cpath, count($cpath) - ($last->tree_level - $obj->tree_level + 1), ($last->tree_level - $obj->tree_level + 1));
                    }
                }
            }
            $cpath[] = $obj->tree_name;
            
            $this->Add($obj->tree_id, $obj);
            $this->Add(join("/", $cpath), $obj);
            
            if($obj->tree_level == 1) {
                
                $domains = explode(';', $obj->tree_domain);
                foreach($domains as $d) {
                    $this->_domains->Add($d, 'id'.$obj->tree_id);
                }
            }
            
            $last = $obj;
        }

        /*$time = ((microtime(true) - $startTime) * 1000);
        $time2 = (($startTime2 - $startTime) * 1000);*/
        
        //out($time, $time2, $this);
            
    }
    
    private function _IsChildOf($p, $f, $self = true){
        if(is_null($f))
            return false;
        
        if($self)
            return $f->tree_left_key >= $p->tree_left_key && $f->tree_right_key <= $p->tree_right_key;
        else
            return $f->tree_left_key > $p->tree_left_key && $f->tree_right_key < $p->tree_right_key;
    }
    
    public function Nodes($published_only = false) {
        $ret = new Branch();
        foreach($this->_data as $o) {
            if($o->tree_published && $published_only || !$published_only)
                $ret->Add('id'.$o->tree_id, Navigator::InitNode($o));
        }
        return $ret;
    }
    
    public function Sites($t = BYNAME) {
        $ret = new Collection();
        foreach($this->_data as $item) {
            if($item->tree_level == 1) {
                $ret->Add($t == BYNAME ? $item->tree_name : $item->tree_domain, Navigator::InitNode($item));
            }
        }
        return $ret;
    }
    
    public function Children($parent, $published_only = false) {
        $ret = new Branch();  
        $index = $this->_paths->IndexOfFirst('id'.$parent->tree_id);
        $o = $this->_data->Item($index);
        while($this->_IsChildOf($parent, $o)) {
            if($o->tree_level == $parent->tree_level + 1) {
                if($o->tree_published && $published_only || !$published_only) {
                    $ret->Add($o->tree_name, Navigator::InitNode($o));
                }
            }
            $o = $this->_data->Item(++$index);
        }
        return $ret;
    }
    
    public function Branch($parent, $published_only = false) {

        $ret = new Branch();
        $index = $this->_paths->IndexOfFirst('id'.$parent->tree_id);
        $o = $this->_data->Item($index);
        while($this->_IsChildOf($parent, $o)) {
            if($o->tree_published && $published_only || !$published_only)
                $ret->Add($o->tree_id, Navigator::InitNode($o));
            $o = $this->_data->Item(++$index);
        }
        return $ret;
    }

    // неправильно работает, надо поправить     
    public function Ajar($parent, $published_only = false, $forseLevels = 1) {

        $path = $this->Path($parent->tree_id);
        $parents = explode('/', $path);
        
        $p = '';
        $ret = new Collection();
        foreach($parents as $item) {
            $p = (is_empty($p) ? '' : $p.'/').$item;
            $o = $this->Item($p);
            $ret->Add($o->tree_name, Navigator::InitNode($o));
        }       
        $index = $this->_paths->IndexOfFirst('id'.$parent->tree_id);

        $o = $this->_data->Item($index);
        while($this->_IsChildOf($parent, $this->_data->Item($index))) {
            if($o->tree_level == $parent->tree_level + 1) {
                if($o->tree_published && $published_only || !$published_only)
                    $ret->Add($o->tree_name, Navigator::InitNode($o));
            }
            $o = $this->_data->Item(++$index);
        }
        return $ret;
    }

    public function Parents($node) {
        
        $path = $this->Path($node->tree_id);
        $parents = explode('/', $path);
        
        $p = '';
        $ret = new Collection();
        foreach($parents as $item) {
            $p = (is_empty($p) ? '' : $p.'/').$item;
            $o = $this->Item($p);
            $ret->Add($o->tree_name, $o);
        }
        return $ret;        
    }
    
}

class Navigator extends IEventDispatcher {

    static $cache = null;
    
    
    private $_dbt;
    
    private $_querypath;
    private $_folder;
    private $_fobj;
    private $_publication;
    private $_pobj;
    private $_site;
    private $_storage;
    private $_dataid;
    private $_datarow;
    
    public $e404 = false;
    
    public function __construct() {
        Navigator::$cache = new NavigatorCache();
        Navigator::$cache->PrecacheTree();
        
        $this->_dbt = new dbtree("sys_tree", "tree_");
        $this->_GetCurrentSite();
        $this->_GetCurrentFolder();
        
    }
    
    private function _GetCurrentFolder() {
        global $core;
        if($core->isAdmin)
            return;
        
        $this->DispatchEvent('navigator.getcurrentfolder.start', new Hashtable('navigator', $this));
        
        $path = $core->rq->REQUEST_URI;
        $path = str_replace(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']),'',$path);
        
        if(strstr($path, '?') !== false) {
            $parts = explode("?", $path);
            $path = $parts[0];
            $queryString = $parts[1];
            if(count($_GET) == 0) {
                $qs = explode("&", $queryString);
                foreach($qs as $v) {
                    $qss = explode("=", $v);
                    $_GET[$qss[0]] = $qss[1];
                }
            }
        }
//        out($path);
        /*$path = trim($path, "/");
//        out($path);

        if(preg_match('/\/([^\/]+)\.html/', $path, $matches) > 0) {
            $this->_publication = $matches[1];
            $path = str_replace($matches[0], '', $path);
        }
        if(preg_match('/\/([A-z]+)_(\d+)\.html/', $path, $matches) > 0) {
            $this->_storage = $matches[1];
            $this->_dataid = $matches[2];
            $path = str_replace($matches[0], '', $path);
        }*/
		$path = trim($path, "/");
        if(preg_match('/\/(\d+)\.html/', $path, $matches) > 0) {
            $this->_publication = $matches[1];
            $path = str_replace($matches[0], '', $path);
        }
        if(preg_match('/\/([A-z]+)_(\d+)\.html/', $path, $matches) > 0) {
            $this->_storage = $matches[1];
            $this->_dataid = $matches[2];
            $path = str_replace($matches[0], '', $path);
        }        
        
        $this->_querypath = $path;
        if(!is_empty($this->_querypath)) {
            $this->_fobj = $this->FindByPath($this->_site->name.'/'.$this->_querypath);
            if(is_null($this->_fobj))
                $this->_fobj = $this->FindByPath($this->_site->name.'/'.FOLDER404);
        }
        
        $this->DispatchEvent('navigator.getcurrentfolder.complete', new Hashtable('navigator', $this));
        
    }
    
    private function _GetCurrentSite() {

        $site_name = @$_SERVER["SERVER_NAME"];
        $site_port = @$_SERVER["SERVER_PORT"];
        
        $this->_site = new Site(Navigator::$cache->Domain($site_name), null);
        if(is_null($this->_site->id)) {
            $sites = Site::EnumSites(BYDOMAIN);
            if($sites->count() > 0)
                $this->_site = $sites->Item(0);
        }

        return $this->_site;
    }
    
    public function FindByPath($path = null) {
        
        if(is_null($path))
            $path = $this->_querypath;

        if(is_array($path))
            $path = join("/", $path);
        
        $path = trim($path, '/');
        
        $o = Navigator::$cache->Item($path);
        if(is_null($o))
            return null;
            
        return Navigator::InitNode($o);

    }
        
    public static function Fetch($id) {
        global $core;
        return $core->nav->FindByPath($id);
    }     
    
    public static function FolderExists($id) {
        global $core;
        return !is_null($core->nav->FindByPath($id)); 
    }
    
    public static function CheckFolderName($name, $parent = null) {
        if(is_null($parent)) {
            $sites = Navigator::$cache->Sites();
            return !$sites->Exists($name);
        }
        else {
            $sublinks = Navigator::$cache->Children($parent);
            return !$sublinks->Exists($name);
        }
    }
    
    public function Url($folder, $publication = null, $storage = null, $args = null, $lang = null) {
        global $core;
        global $page;
        global $glanguage;
        global $MULTILANGUAL;
        
        if(!is_null($args))        
            if(is_array($args))
                $args = Collection::Create($args);
                
        if(is_null($lang) && $MULTILANGUAL) {
            $lang = @$args->lang;
            if(is_null($lang))
                $lang = $glanguage;
            else {
                $args->Delete("lang");
            }
        }
        
        if($folder instanceof Site) {
            $r = 'http://'.$folder->domain;
        }
        else {
        
            $r = $folder->path;
            if(!is_null($publication)) {
                if ($publication->datarow->hid)
					$r .= $publication->datarow->hid.'.html';
				else 
					$r .= $publication->id.'.html';
            } else {
                if(!is_null($storage))
                    $r .= $storage[0].'_'.$storage[1].".html";
            }
                    
            if(!is_null($page))
                $r .= '?page='.$page;
                
            if(!is_null($lang))
                $r = '/'.$lang.'/'.$r;    
                
        }
                
        if(!is_null($args)) {
            $a = "";
            foreach($args as $k => $v) { 
                if($k == "lang" && !is_null($lang))
                    continue;
                $a .= "&".$k."=".urlencode($v);
            }
            $r .= (is_null($page) ? '?' : '&').substr($a, 1);
        }        
               
        return $r;
            
    }
        
    public function __get($property) {
        switch($property) {
            case "datarow":       
                if(is_null($this->_datarow)) {
                    if(!is_empty($this->_storage) && !is_empty($this->_dataid) && Storages::IsExists($this->_storage))
                        $this->_datarow = new DataRow(new Storage($this->_storage), $this->_dataid);
                }
                return $this->_datarow;
            case "folder":              
                return $this->_fobj;
            case "site":  
                return $this->_site;
            case "path":
                return $this->_folder;
            case "query":
                return $this->_querypath;
            case "publication":
                if(is_null($this->_pobj) && !is_null($this->_publication)) {
                    
                    if(is_numeric($this->_publication)) {
                        if(!Publications::Exists($this->_publication))
                            return null;
                        $this->_pobj = new Publication($this->_publication);
                    }
                    else {
                        
                        // <storage>_hid
                        
                        $filter = array();
                        
                        $storages = Storages::Enum();
                        foreach($storages as $s) {
                            if($s->fields->Exists('hid'))
                                $filter[$s->table] = $s->table.'_hid=\''.$this->_publication.'\'' ;
                        }
                        
                        // array( 
                        //  'table' => 'table_hid=\''.$this->_publication.'\''
                        // )
                        
                        $pubs = $this->folder->Publications($filter);
                        if($pubs->Count() > 0) {
                            $this->_pobj = $pubs->FetchNext();
                        }
                        else {
                            return null;
                        }
                    }
                    
                }

                return $this->_pobj;
        }
        return null;
    }
    
    public function __set($property, $value) {
        switch($property) {
            case "datarow":
                $this->_datarow = $value;
                $this->_storage = $value->storage->name;
                $this->_dataid = $value->id;
                break;
            case "folder":              
                $this->_fobj = $value;
                break;
            case "site":  
                $this->_site = $value;
                break;
            case "publication":  
                if(is_numeric($value)) {
                    $this->_publication = $value;
                }
                else {
                    $this->_publication = $value->id;
                    $this->_pobj = $value;
                }
                break;
        }        
    }
    
    static function InitNode($dtr) {
        if(!$dtr)
            return false;
        return $dtr->tree_level == 1 ? new Site($dtr, null) : new Folder(null, $dtr);
    }
    
}

class Folder extends IEventDispatcher {

#region Properties

    public $dbt;
    private $folder = null;
    private $folderpath = null;
    private $tree_children = -1;
    private $_stringPath;
    private $_stringFullPath;
    
#endregion

    /*custom properties no relational table fields*/
    private $_properties; /* class Properties */

    public function __construct($dbt, $name = null) {
        $this->dbt = $dbt;
        if(is_null($this->dbt))
            $this->dbt = new dbtree('sys_tree', 'tree');
            
        if(!is_null($name)) {
            $this->Load($name);
        }
        else {
            $this->folder = new Object();
        }
        $this->RegisterEvent("folder.save");
    }

    public function Load($name) {
        global $core;

        if(is_numeric($name)) {            
            $this->folder = Navigator::$cache->Item($name);
        }
        else if(is_string($name)) {
            // $path
            $this->folder = Navigator::$cache->Item($name);
        }
        else if(is_object($name)) {
            $this->folder = $name;
        }
        else {
            $this->folder = new Object();
        }

        $this->tree_children = -1;
        $this->folderpath = null;
        
    }

    public function __get($field) {
        
        if(is_null($this->folder))
            return null;
        
        $args = $this->DispatchEvent("folder.property.get", Hashtable::Create("field", $field, "data", $this->folder));
        
        if(@$args->cancel === true) {
            return @$args->value;
        }

        if($field == "children") {
            if($this->tree_children < 0) {
                if ($this->folder == null)
                    $this->tree_children = 0;
                else {
                    $this->tree_children = $this->Children()->count();// $this->dbt->Branch(@$this->folder->tree_id)->count() - 1;
                }
                
            }
            return $this->tree_children;
        }
        
        if($field == "children_published") {
            $ch = $this->Children();
            $co = 0;
            foreach($ch as $c){
                if($c->published) $co++;
            }
            return $co;
        }
        
        if($field == "properties") {
			$this->_loadProperties();
            return $this->_properties;
        }
        
        if($field == "path") {
            $this->_getStringPath();
            return $this->_stringPath;
        }

        if($field == "fullpath") {
            $this->_getFullStringPath();
            return $this->_stringFullPath;
        }

        /*returning a string properties*/
        if($field == "tree_properties") {
            return @$this->folder->tree_properties;
        }
        
        $nm = $field;
        if(strpos($nm, 'tree_') === false)
            $nm = "tree_".strtolower($nm);
        
        $vars = $this->folder->ToArray();
        if(@array_key_exists($nm, $vars)) {
            if($nm == "tree_securitycache") {
                if(!($this->folder->$nm instanceof Hashtable)) { //means that it is not deserialized yet or null
                    $this->folder->$nm = @_unserialize($this->folder->$nm);
                    if($this->folder->$nm === false || is_null($this->folder->$nm))
                        $this->folder->$nm = new Hashtable();    
                    return $this->folder->$nm;
                }
                else { 
                    return $this->folder->$nm;
                }
            }
            else {
                return $this->folder->$nm;
            }
        }
        else {
            /*if the property not found in standart fields, try find it in properties*/
            $this->_loadProperties();
            $prop = $this->_properties->$field;
            
            
            if($prop) {
                if($prop->type == "blob") {
                    global $core;
                    return new Blob(intval(@$prop->value));
                }
                else {
                    return @$prop->value;
                }
            }
            return null;
        }
    }
                                          
    public function __set($field, $value) {
        $this->_loadProperties();
        
        $args = $this->DispatchEvent("folder.property.set", Hashtable::Create("field", $field, "value", $value, "data", $this->folder));
        if(@$args->cancel === true) {
            return;
        }
        
        if($this->_properties->Exists($field))
            $this->_properties->$field->value = $value;
        else {
            $nm = "tree_".$field;
            $this->folder->$nm = $value;
        }
    }
    
    private function _getStringPath() {
        $this->_stringPath = Navigator::$cache->Path($this->tree_id);
        
        $this->_stringPath = explode('/', $this->_stringPath);
        array_splice($this->_stringPath, 0, 1);
        $this->_stringPath = '/'.implode('/', $this->_stringPath).'/';
        
        /*$this->_stringPath = '';
        $p = $this->Path();
        $p->Delete(0);
        foreach($p as $i) {
            $this->_stringPath .= '/'.$i->name;
        }
        $this->_stringPath .= '/';*/
        
    }

    private function _getFullStringPath() {
        $this->_stringFullPath = Navigator::$cache->Path($this->tree_id);
    }

    public function actualTemplate() {
        $tname = "";
        if($this->template > 0)
            $tname = $this->template;
        else {
            
            $this->get_path();
            if(!is_null($this->folderpath)) {
                $i=-1;
                for($i=$this->folderpath->count()-1; $i >= 0; $i--) {
                    if((int)$this->folderpath->item($i)->tree_template > 0) {
                        $tname = $this->folderpath->item($i)->tree_template;
                        break;
                    }
                }

            }
            
        }
        
        return $tname;
    }

    public function IsChildOf($f, $self = true){
        if(is_null($f))
            return false;
        if($self)
            return $this->left_key >= $f->left_key && $this->right_key <= $f->right_key;
        else
            return $this->left_key > $f->left_key && $this->right_key < $f->right_key;
    }

    public function Parent() {
        $this->get_path();
        $r = $this->folderpath->item($this->folderpath->count()-2);
        if($r->tree_level == 1)
            return new Site($r, null);
        else
            return new Folder($this->dbt, $r);
    }

    public function SetModified($date = null) {
        global $core;
        if(is_null($date))
            $date = strftime("%Y-%m-%d %H:%M:%S", time());

        $s = ""; //implode(",", $this->folderpath->get_array());
        $this->get_path();
        foreach($this->folderpath as $f) {
            $s .= $f->tree_id.",";
        }
        $s = "in (".rtrim($s, ",").")";
        $core->dbe->Query("update sys_tree set tree_datemodified='".$date."' where tree_id ".$s);
    }

    public function Children($published_only = false) {
        
        return Navigator::$cache->Children($this, $published_only);
        
        /*$childs = $this->dbt->Branch($this->id, '', array("and" => array("tree_level > ".$this->level, "tree_level < ".($this->level+2))));
        $childs->disconnect();
        $rChilds = new Branch();
        //$child = $childs->FetchNext();
        while($child = $childs->FetchNext()) {
            if($published_only) {
                if($child->tree_published)
                    $rChilds->add($child->tree_name, new Folder($this->dbt, $child));   
            }
            else
                $rChilds->add($child->tree_name, new Folder($this->dbt, $child));
        }
        return $rChilds; */
    }

    public function Child($id, $published_only = false, $path = false) {
        
        $p = Navigator::$cache->Path($this->id);
        $o = Navigator::$cache->Item($p.'/'.$id);
        if(is_null($o))
            return null;

        if($published_only && !$o->tree_published)
            return null;
            
        $n = Navigator::InitNode($o);
        
        return $n;
        
        /*        if(!$path) {
                    $childs = $this->dbt->Branch($this->id, '', array("and" => array(is_numeric($id) ? "tree_id=".$id : "tree_name='".strtolower($id)."'", "tree_level > ".$this->level, "tree_level < ".($this->level+2))));
                    if($childs->Count() > 0)
                        return new Folder($this->dbt, $childs->FetchNext());
                    return null;
                } else {            
                    $id = trim($id, "/");
                    $items = preg_split("/\//", $id);
                    
                    $folder = $this;
                    foreach($items as $item) {
                        $c = $folder->Child($item, $published_only);
                        if(is_null($c))
                            return null;
                        $folder = $c;
                    }
                    return  $folder;            
                }
        */
    }

    public function ChildBy($path, $published_only = false) {
        return $this->Child($path, $published_only, true);
    }

    public function Remove() {
        $this->SetModified();
        
        $branch = $this->Branch();
        foreach($branch as $item)
            $item->Publications()->Clear();
            
        $this->Publications()->Clear();
        
        $this->dbt->DeleteAll($this->id);
    }
    
    public function SetData($data) {
        $this->published = $data->tree_published;
        $this->name = $data->tree_name;
        $this->keyword = $data->tree_keyword;
        $this->description = $data->tree_description;
        $this->template = $data->tree_template;
        $this->notes = $data->tree_notes;
        $this->properties = $data->tree_properties;
        $this->header_statictitle = $data->tree_header_statictitle;
        $this->header_inlinescripts = $data->tree_header_inlinescripts;
        $this->header_inlinestyles = $data->tree_header_inlinestyles;
        $this->header_basehref = $data->tree_header_basehref;
        $this->header_shortcuticon = $data->tree_header_shortcuticon;
        $this->header_keywords = $data->tree_header_keywords;
        $this->header_description = $data->tree_header_description;
        $this->header_aditionaltags = $data->tree_header_aditionaltags;
    }

    public function Save() {
        $data = new collection();
        $data->add("tree_published", $this->published ? 1 : 0);
        $data->add("tree_datemodified", strftime("%Y-%m-%d %H:%M:%S", time()));
        $data->add("tree_name", $this->name);
        $data->add("tree_keyword", $this->keyword);
        $data->add("tree_description", $this->description);
        $data->add("tree_template", $this->template);
        $data->add("tree_notes", $this->notes);
        $data->add("tree_properties", $this->tree_properties);
        if($this->properties instanceof FolderProperties)
            $data->add("tree_propertiesvalues", _serialize($this->properties->get_array()));
        else
            $data->add("tree_propertiesvalues", "");
        $data->add("tree_header_statictitle", $this->header_statictitle);
        $data->add("tree_header_inlinescripts", $this->header_inlinescripts);
        $data->add("tree_header_inlinestyles", $this->header_inlinestyles);
        $data->add("tree_header_basehref", $this->header_basehref);
        $data->add("tree_header_shortcuticon", $this->header_shortcuticon);
        $data->add("tree_header_keywords", $this->header_keywords);
        $data->add("tree_header_description", $this->header_description);
        $data->add("tree_header_aditionaltags", $this->header_aditionaltags);

        if($this->folder->tree_securitycache instanceof Hashtable)
            $data->Add("tree_securitycache", _serialize($this->folder->tree_securitycache));
        else
            $data->Add("tree_securitycache", $this->folder->tree_securitycache);

        $args = $this->DispatchEvent("folder.save", collection::create("folder", $this, "data", $data));
        if (@$args->cancel === true)
            return;
        else if (!is_empty(@$args->data))
                $data = $args->data;
                
        $this->dbt->Update($this->id, $data);
        
        Navigator::$cache->PrecacheTree();
        $this->SetModified();
    }

    public function InsertChild($folder) {
        $data = $folder->ToCollection();
        $data->Delete("tree_children");
        
        $id = $this->dbt->Insert($this->id, '', $data);

        Navigator::$cache->PrecacheTree();
        
        $folder->Load($id);
        
        $this->SetModified();
        
        return $folder;
    }
    
    public function Copy($to) { 
        $new = new Folder($this->dbt);
        $new->SetData($this->folder);
        $to->InsertChild($new);
        
        $childs = $this->Children();
        foreach($childs as $c) {
            if(!$c->Copy($new))
                return false;
        }
        
        return true;
    }
    
    public function MoveTo($sf) {
        if( $sf->id != $this->id && 
            !$sf->IsChildOf($this))
            $this->dbt->moveAll($this->id, $sf->id);
        else
            return false;
        return true;
    }

    public function MoveUp() {
        $p = $this->Parent();
        $c = $p->Children();
        $f1 = null;
        foreach($c as $f) {
            if($f->id == $this->id) {
                break;
            }
            $f1 = $f;
        }
        return $this->dbt->ChangePositionAll($this->id, $f1->id, 'before');
    }

    public function MoveDown() {
        $p = $this->Parent();
        $c = $p->Children();
        for($i=0; $i<$c->count();$i++) {
            if($c->item($i)->id == $this->id) {
                break;
            }
        }
        return $this->dbt->ChangePositionAll($this->id, $c->item($i+1)->id, 'after');
    }
    
    public function FetchPublications($storageList = null /* array() | storageid or name */, $crit = "", $order = "", $page = -1, $pagesize = 10) {
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);
        
        $order = ($order != "") ? $order : "link_order";
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }

    public function Publications($criteria = "", $order = "", $page = -1, $pagesize = 10) {
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }

    public function Uri($publication = null, $args = null) {
        $site = $this->Path()->Item(0);
        $surl = $site->Url();
        $furl = $this->Url($publication, $args);
        return $surl.$furl;
    }
    
    public function URL($p = null, $args = null, $lang = null, $storage = null){
        global $core;
        return $core->nav->Url($this, $p, $storage, $args, $lang);
    }

    public function ToCollection() {
        $col = collection::create($this->folder->data());
        $col->delete("nflag");
        $col->add("tree_children", $this->children);
        
        if(@$this->folder->tree_securitycache == null)
            $this->folder->tree_securitycache = new Hashtable();
            
        if($this->folder->tree_securitycache instanceof Hashtable)
            $col->Add("tree_securitycache", _serialize($this->folder->tree_securitycache));
        else
            $col->Add("tree_securitycache", $this->folder->tree_securitycache);
        // $this->dbt->Update($this->id, $col);
        return $col;
    }
    
    public function Path() {
    
        $this->get_path();
    
        $c = new Hashtable();
        foreach ($this->folderpath as $p){
        
            if($p->tree_level > 0) {
                if($p->tree_level > 1)
                    $f = new Folder($this->dbt, $p);
                else if($p->tree_level == 1)
                    $f = new Site($p, null);

                $c->add($p->tree_name, $f);
            }
        
        }
        return $c;
    }

    public function Ajar($published_only = false, $forseLevels = 1) {
        
        return Navigator::$cache->Ajar($this, $published_only, $forseLevels);
        
        /*$ret = new Branch();
        
        $condition = '';
        if($published_only) {
            $condition = array("and" => array("(SELECT count(distinct E.tree_published) FROM sys_tree E, sys_tree F WHERE F.tree_id = A.tree_id and E.tree_published=0 AND F.tree_left_key BETWEEN E.tree_left_key AND E.tree_right_key) = 0"));
        }

        $ajr = $this->dbt->Ajar($this->folder->tree_id, '', $condition);
        while($aj = $ajr->FetchNext()) {
            if($aj->tree_level == 1)
                $obj = new Site($aj, null);
            else
                $obj = new Folder($this->dbt, $aj);

            $ret->add($aj->tree_name, $obj);
        }
        return $ret;*/
    }

    public function Branch($folder = null, $published_only = false, $cond = '') {
        
        return Navigator::$cache->Branch($this, $published_only);
        
        /*$ret = new Branch();

        $condition = '';
        if(!is_null($folder)) {
            if(is_numeric($folder))
                $condition = array("and" => array("(tree_id = '".$folder."')"));
            else
                $condition = array("and" => array("(tree_name = '".$folder."')"));
        }
        else if($published_only) {
            $condition = array("and" => array("(SELECT count(distinct E.tree_published) FROM sys_tree E, sys_tree F WHERE F.tree_id = A.tree_id and E.tree_published=0 AND F.tree_left_key BETWEEN E.tree_left_key AND E.tree_right_key) = 0"));
        }
        
        if(!is_empty($cond)) {
            if(!is_empty($condition))
                $condition['and'][] = $cond;
            else
                $condition = array("and" => array($cond));
        }

        
        $ajr = $this->dbt->Branch($this->folder->tree_id, '', $condition);
        while($aj = $ajr->FetchNext()) {
            if($aj->tree_level == 1)
                $obj = new Site($aj, null);
            else
                $obj = new Folder($this->dbt, $aj);

            $ret->add($aj->tree_name, $obj);
        }
        return $ret;*/
    }
    
    public function createSecurityBathHierarchy($suboperation) {
        $prefixFolder = "structure.folders.";
        $prefixSite = "structure.sites.";
        $operations = Folder::getOperations();
        $path = $this->Path();

        $tree = array();        
        foreach($path as $item){
            if($item instanceof Folder)
                $tree[] = array("object" => $item, "operation" => $prefixFolder.($item->name != $this->name ? "children." : "").$suboperation);
            else
                $tree[] = array("object" => $item, "operation" => $prefixSite."children.".$suboperation);
        }
        // $tree[] = array("object" => $this, "operation" => $prefixFolder.$suboperation);
        $tree = array_reverse($tree);
        return $tree;
    }
    
    public function Sibling(){
        
    }
    
    public function ToXML($withBranch = false){
        $ret = "\n<folder>";
        
        $c = $this->get_collection();
        $c->delete("tree_id");
        $c->delete("tree_left_key");
        $c->delete("tree_right_key");
        $c->delete("tree_level");
        $c->delete("tree_sid");
        $ret .= "\n".$c->ToXML();
        
        $args = $this->DispatchEvent("folder.toxml.processxml", collection::create("xml", $c));
        if (!is_empty(@$args->xml))
            $ret .= $args->xml;
            
        if ($withBranch){
            $br = $this->Branch();
            $br->delete($this->name);
            $ret .= $br->ToXML();
        }
            
        $ret .= "\n</folder>";
        return $ret;
    }
    
    public function FromXML($el, $parent){ //folder
        $p = null;
        
        foreach ($el->childNodes as $pair){
            $args = $this->DispatchEvent("folder.fromxml.processdata", collection::create("element", $pair));
            if ($pair->tagName == "collection"){
                $c = new collection();
                $c->FromXML($pair);
                $c->FromObject(crop_object_fields($c->get_array(), "/tree_.*/i"), true);
                
                $args = $this->DispatchEvent("folder.fromxml.setdata", collection::create("data", $c));
                if (!is_empty(@$args->data))
                    $c = $args->data;
                
                $this->folder = $c->ToObject();
                $parent->InsertChild($this);
            } else {
                $p = $pair;
            }
        }
        if ($p){
            $b = new Branch(array(), $this->dbt);
            $b->FromXML($p, $this);
        }
    }

#region Privates

    private function get_path() {
        
        $this->folderpath = Navigator::$cache->Parents($this);
        
        if(is_null($this->folderpath)) {
            $this->folderpath = $this->dbt->Parents($this->id, '', '', 'tree_name');
            $this->folderpath->disconnect();
        }        
    }

    private function _loadProperties() {
        if(!($this->_properties instanceof FolderProperties)) {
            $this->_properties = new FolderProperties($this);
        }
    }

#endregion

#region Aliases
    
    public function from_xml($el, $parent) { return $this->FromXml($el, $parent); }
    public function to_xml($withBranch = false) { return $this->ToXml($withBranch); }
    public function get_collection() { return $this->ToCollection(); }
    
#endregion

#region Statics

    public static function getOperations() {
        $operaions = new Operations();
    
        $operaions->Add(new Operation("structure.folders.delete", "Delete folder"));
        $operaions->Add(new Operation("structure.folders.edit", "Edit folder"));
        $operaions->Add(new Operation("structure.folders.changeposition", "Change the folder position"));
        $operaions->Add(new Operation("structure.folders.publications.add", "Create publications in this folder"));
        $operaions->Add(new Operation("structure.folders.publications.delete", "Remove publications from this folder"));
        $operaions->Add(new Operation("structure.folders.publications.edit", "Edit publications properties"));
        $operaions->Add(new Operation("structure.folders.publications.changeposition", "Change the publications position"));

        $operaions->Add(new Operation("structure.folders.children.add", "Add child folder"));
        $operaions->Add(new Operation("structure.folders.children.delete", "Delete children"));
        $operaions->Add(new Operation("structure.folders.children.edit", "Edit children"));
        $operaions->Add(new Operation("structure.folders.children.changeposition", "Change the child folder position"));
        $operaions->Add(new Operation("structure.folders.children.publications.add", "Create publications in child folders"));
        $operaions->Add(new Operation("structure.folders.children.publications.delete", "Remove publications from child folders"));
        $operaions->Add(new Operation("structure.folders.children.publications.edit", "Edit publications in child folders"));
        $operaions->Add(new Operation("structure.folders.children.publications.changeposition", "Change the publications position in child folders"));

        return $operaions;
    }
    
    public static function Create($parent, $published, $name, $description, $template = 0, $notes = "") {
        $dbt = new dbtree("sys_tree", "tree");
        $f = new Folder($dbt);
        $f->published = intval($published);
        $f->name = $name;
        $f->keyword = null;
        $f->description = $description;
        $f->template = $template;
        $f->notes = $notes;
        $f->properties = null;
        $f->header_statictitle = null;
        $f->header_inlinescripts = null;
        $f->header_inlinestyles = null;
        $f->header_basehref = null;
        $f->header_shortcuticon = null;
        $f->header_keywords = null;
        $f->header_description = null;
        $f->header_aditionaltags = null;
        $parent->InsertChild($f);
        return $f;
    }
    
#endregion

}

class Branch extends Collection {
    
#region Properties

    public $dbt;
    
#endregion        
    
    public function __construct($parent = null, $dbt = null){
        parent::__construct();
        $this->dbt = $dbt;
        if(!is_null($parent)) {
            $this->Merge($parent->Branch()->ToArray());
        }
    }
    
    public function FetchPublications($storageList = array() /* array() | storageid or name */, $crit = "", $order = "", $page = -1, $pagesize = 10){
        return Publications::FetchPublications($this, $storageList, $crit, $order, $page, $pagesize);
    }
    
    public function ToXml($levelTag = "folders", $itemTag = "folder", $itemCallback = null, $params = array()){
        $count = $this->Count();
        if ($count == 0)
            return;
        
        $attrs = " ";
        foreach($params as $k => $v) {
            $attrs .= $k.'="'.$v.'"';
        }
        
        $ret = "\n<".$levelTag.$attrs.">";
        
        $parents = new ArrayList();
        
        foreach ($this as $folder){
            if($parents->Count() == 0)
                $parents->Add($folder);
            else if($folder->level > $parents->Last()->level) {
                $parents->Add($folder);
                $ret .= "\n<".$levelTag.">";
            } else if($folder->level < $parents->Last()->level) {
                while($folder->level < $parents->Last()->level) {
                    $ret .= "\n</".$itemTag."></".$levelTag.">";
                    $parents->Delete($parents->Count() - 1);
                }
                $ret .= "</".$itemTag.">";
            } else {
                $parents->Delete($parents->Count() - 1);
                $parents->Add($folder);
                $ret .= "\n</".$itemTag.">";
            }
            
            $ret .= "\n<".$itemTag.">";
            
            $c = $folder->ToCollection();
            if(is_null($itemCallback)) {
                $c->delete("tree_id");
                $c->delete("tree_left_key");
                $c->delete("tree_right_key");
                $c->delete("tree_level");
                $c->delete("tree_sid");
                $ret .= $c->ToXML();
            }
            else {
                $ret .= $itemCallback($folder);
            }
        }
        
        $parents->Delete($parents->Count() - 1);
        while($parents->Count() > 0) {
            $parents->Delete($parents->Count() - 1);
            $ret .= "\n</".$itemTag.">\n</".$levelTag.">";
        }
        $ret .= "\n</".$itemTag.">";
        
        //$args = $this->DispatchEvent("branch.toxml.processxml", collection::create("xml", $c));
        //if (!is_empty(@$args->xml))
        //    $ret .= $args->xml;
        
        $ret .= "\n</".$levelTag.">";
        
        return $ret;
    }
    
    public function FromXML($el, $parent){ //folders
        $this->Add($parent->name, $parent);
        foreach($el->childNodes as $pair) {
            
            $args = $this->DispatchEvent("branch.from_xml.processdata", collection::create("element", $pair));
            
            if ($pair->tagName == "folder"){
                $f = new Folder($this->dbt, null);
                $f->from_xml($pair, $parent);
                $this->Add($f->name, $f);
            }
        }
    }
    
    function SubBranch($parent) {
        $newBranch = new Branch();
        $index = $this->IndexOf($parent->id, "id");
        $newBranch->Add($parent->name, $parent);
        $i = $index;
        do {
            $tmp = $this->Item($this->Key(++$i));
            if(!is_null($tmp)) {
                if($tmp->level <= $parent->level)
                    break;
                $newBranch->Add($tmp->name, $tmp);
            }
        } while (!is_null($tmp));
        return $newBranch;
    }
    
    function NextSible($item) {
        $index = $this->IndexOf($item->id, "id");
        $i = $index;
        do {
            $tmp = $this->Item($this->Key(++$i));
            if(!is_null($tmp)) {
                if($tmp->level < $item->level) {
                    return null;
                }
                else if($tmp->level == $item->level) {
                    return $tmp;
                }
            }
        } while (!is_null($tmp));
        
        return null;
    }

#region Aliases
    
    // alias for FromXML
    public function from_xml($el, $parent){ $this->FromXML($el, $parent); }
    
    // alias for to_xml
    public function to_xml(){ $this->ToXML(); }

#endregion    
    
}

class Site extends IEventDispatcher  {

#region Properties        
    
    public $dbt;
    public $domain = "";
    public $site_id = -1;
    public $sNode = null;
    private $tree_children = -1;
    public $folder = null;
    public $error = false;
    
    /*custom properties no relational table fields*/
    private $_properties;
    
#endregion
    
    public function __construct($dns = null, $folder = null) {
        
        $this->dbt = new dbtree("sys_tree", "tree");
        $this->sNode = new Object();
        
        if(!is_null($dns)) {
            $this->Load($dns, $folder);
        }
        $this->RegisterEvent("site.save");
    }

    public function Load($dns, $folder = null) {
        global $core;
        if(is_object($dns))    {
            $this->domain = $dns->tree_domain;
            $this->sNode = $dns;
            $this->site_id = $dns->tree_id;
        }
        else {
            if(is_numeric($dns))
                $q = "select sys_tree.* from sys_tree where sys_tree.tree_id = '".$dns."'";
            else
                $q = "select sys_tree.* from sys_tree where sys_tree.tree_domain = '".$dns."'";
            
            $query = $core->dbe->ExecuteReader($q);
            if( $query->count() > 0 ) {
                $this->site_id = $query->Read()->tree_id;
                $this->sNode = $this->dbt->getNode($this->site_id);
                $this->domain = $dns;
                $this->error = false;
            }
            else {
                $this->error = true;
            }
        }

        $this->tree_children = -1;
                                                             
        $this->LoadFolder($folder);
    }

    public function LoadFolder($folder = null) {
        $this->folder = null;
        if(!is_null($folder)) {
            if(!is_object($folder)) {
                if(is_numeric($folder))
                    $folder = Site::Fetch($folder)->name;
            
                $branch = @$this->Branch();
                $this->folder = @$branch->$folder; // new Folder($this->dbt, $folder);
            }
            else 
                $this->folder = $folder;
        }                   
    }

    public function SetModified($date = null) {
        global $core;
        
        if(is_null($date))
            $date = strftime("%Y-%m-%d %H:%M:%S", time());
        $core->dbe->Query("update sys_tree set tree_datemodified='".$date."' where tree_id  = '".$this->id."'");
    }
    
    public function IsChildOf($f){
        return false;
    }
    
    public function MoveTo($sf) {
        if( $sf->id != $this->id && 
            !$sf->IsChildOf($this))
            $this->dbt->moveAll($this->id, $sf->id);
        else
            return false;
        return true;
    }

    public function MoveUp() {
        $c = Site::EnumSites(BYNAME); // $p->Children();
        $f1 = null;
        foreach($c as $f) {
            if($f->id == $this->id) {
                break;
            }
            $f1 = $f;
        }
        return $this->dbt->ChangePositionAll($this->id, $f1->id, 'before');
    }

    public function MoveDown() {
        $c = Site::EnumSites(BYNAME); // $p->Children();
        for($i=0; $i<$c->count();$i++) {
            if($c->item($i)->id == $this->id) {
                break;
            }
        }
        return $this->dbt->ChangePositionAll($this->id, $c->item($i+1)->id, 'after');
    }

    public function ToCollection() {
        $col = collection::create($this->sNode->data());
        $col->add("tree_children", $this->tree_children);
        return $col;
    }

    public function __get($field) {
        if(is_null($this->sNode))
            return null;

        $args = $this->DispatchEvent("site.property.get", Hashtable::Create("field", $field, "data", $this->sNode));
        if(@$args->cancel === true) {
            return @$args->value;
        }

        if($field == "children") {
            if($this->tree_children < 0)
                $this->tree_children = $this->Children()->Count(); //$this->dbt->Branch($this->site_id)->count() - 1;
            return $this->tree_children;
        }
        
        if($field == "properties") {
            $this->_loadProperties();
            return $this->_properties;
        }

        /*returning a string properties*/
        if($field == "tree_properties") {
            return $this->sNode->tree_properties;
        }

        $nm = $field;
        if(strpos($nm, 'tree_') === false)
            $nm = "tree_".strtolower($nm);

        $vars = $this->sNode->ToArray();
        if(array_key_exists($nm, $vars)) {
            
            if($nm == "tree_securitycache") {
                if(!($this->sNode->$nm instanceof Hashtable)) { //means that it is not deserialized yet or null
                    $this->sNode->$nm = @_unserialize($this->sNode->$nm);
                    if($this->sNode->$nm === false || is_null($this->sNode->$nm))
                        $this->sNode->$nm = new Hashtable();    
                    return $this->sNode->$nm;
                }
                else 
                    return $this->sNode->$nm;
            }
            else
                return $this->sNode->$nm;
        
        
            return $this->sNode->$nm;
        }
        else {
            /*if the property not found in standart fields, try find it in properties*/
            $this->_loadProperties();
            $prop = $this->_properties->$field;
            if($prop){
                if($prop->type == "blob") {
                    global $core;
                    return new Blob(intval(@$prop->value));
                }
                else {
                    return @$prop->value;
                }
            }
            return null;
        }
    }

    public function __set($field, $value) {
        $this->_loadProperties();

        $args = $this->DispatchEvent("site.property.set", Hashtable::Create("field", $field, "value", $value, "data", $this->sNode));
        if(@$args->cancel === true) {
            return;
        }
        
        if($this->_properties->Exists($field))
            $this->_properties->$field->value = $value;    
        else {
            $nm = "tree_".$field;
            $this->sNode->$nm = $value;
        }
    }

    public function Render($designName = null) {
        
        global $gpublication;
        global $glanguage;
        
        if(is_null($this->sNode))
            return null;
        
        if(!is_null($designName))
            $tname = $designName;
        else {
            if(!is_null($this->folder))
                $tname = $this->folder->actualTemplate();
            else
                $tname = $this->sNode->tree_template;
        }

        $f = $this->folder;
        if(is_null($f))
            $f = $this;

        $pub = null;
        if(!is_null($gpublication))
            $pub = new Publication($gpublication);

        return designTemplates::apply($tname, collection::create("dbt", $this->dbt, "site", $this, "folder", $f, "language", $glanguage, "publication", $pub));
    }

    public function Children($published_only = false) {
        
        return Navigator::$cache->Children($this, $published_only);
        
        /*if(is_null($this->sNode))
            return null;

        $childs = $this->dbt->Branch($this->id, '', array("and" => array("tree_level > ".$this->level, "tree_level < ".($this->level+2))));
        $childs->disconnect();
        $rChilds = new collection();
        //$child = $childs->FetchNext();
        while($child = $childs->FetchNext()) {
            if($published_only) {
                if($child->tree_published)
                    $rChilds->add($child->tree_name, new Folder($this->dbt, $child));   
            }
            else
                $rChilds->add($child->tree_name, new Folder($this->dbt, $child));
        }
        return $rChilds;*/
    }
    
    public function Child($id, $published_only = false, $path = false) {
        
        $p = Navigator::$cache->Path($this->id);
        $o = Navigator::$cache->Item($p.'/'.$id);
        if(is_null($o))
            return null;
        
        if($published_only && $o->tree_published != 1)
            return null;
            
        return Navigator::InitNode($o);
        
        /*if(!$path) {
            $childs = $this->dbt->Branch($this->id, '', array("and" => array(is_numeric($id) ? "tree_id=".$id : "tree_name='".$id."'", "tree_level > ".$this->level, "tree_level < ".($this->level+2))));
            if($childs->Count() > 0)
                return new Folder($this->dbt, $childs->FetchNext());
            return null;
        } else {            
            $id = trim($id, "/");
            $items = preg_split("/\//", $id);
            
            $f = $this;
            foreach($items as $item) {
                $c = $f->Child($item, $published_only);
                if(is_null($c)) return null;
                $f = $c;
            }
            return  $f; 
        }*/

    }
    
    public function ChildBy($path, $published_only = false) {
        return $this->Child($path, $published_only, true);
    }
    
    public function Remove() {

        $branch = $this->Branch();
        foreach($branch as $item)
            $item->Publications()->Clear();
            
        $this->Publications()->Clear();
    
        $this->SetModified();
        
        $this->dbt->DeleteAll($this->id);

        Navigator::$cache->PrecacheTree();
    }

    public function SetData($data) {
        $this->published = $data->tree_published;
        $this->name = $data->tree_name;
        $this->domain = $data->tree_domain;
        $this->description = $data->tree_description;
        $this->language = $data->tree_language;
        $this->template = $data->tree_template;
        $this->properties = $data->tree_properties;
        $this->header_statictitle = $data->tree_header_statictitle;
        $this->header_inlinescripts = $data->tree_header_inlinescripts;
        $this->header_inlinestyles = $data->tree_header_inlinestyles;
        $this->header_basehref = $data->tree_header_basehref;
        $this->header_shortcuticon = $data->tree_header_shortcuticon;
        $this->header_keywords = $data->tree_header_keywords;
        $this->header_description = $data->tree_header_description;
        $this->header_aditionaltags = $data->tree_header_aditionaltags;
    }
    
    public function Save() {
        $data = new collection();
        $data->add("tree_published", $this->published ? 1 : 0);
        $data->add("tree_datemodified", strftime("%Y-%m-%d %H:%M:%S", time()));
        $data->add("tree_name", $this->name);
        $data->add("tree_domain", $this->domain);
        $data->add("tree_description", $this->description);
        $data->add("tree_language", $this->language);
        $data->add("tree_template", $this->template);
        $data->add("tree_properties", $this->tree_properties);
        $data->add("tree_notes", $this->notes);
        if($this->properties instanceof FolderProperties)
            $data->add("tree_propertiesvalues", _serialize($this->properties->get_array()));
        else
            $data->add("tree_propertiesvalues", "");
        $data->add("tree_header_statictitle", $this->header_statictitle);
        $data->add("tree_header_inlinescripts", $this->header_inlinescripts);
        $data->add("tree_header_inlinestyles", $this->header_inlinestyles);
        $data->add("tree_header_basehref", $this->header_basehref);
        $data->add("tree_header_shortcuticon", $this->header_shortcuticon);
        $data->add("tree_header_keywords", $this->header_keywords);
        $data->add("tree_header_description", $this->header_description);
        $data->add("tree_header_aditionaltags", $this->header_aditionaltags);

        if(!$this->sNode->tree_securitycache)
            $data->Add("tree_securitycache", "");
        else {
            if($this->sNode->tree_securitycache instanceof Hashtable) {
                $data->Add("tree_securitycache", _serialize($this->sNode->tree_securitycache));
            }
            else
                $data->Add("tree_securitycache", $this->sNode->tree_securitycache);        
        }

        $args = $this->DispatchEvent("site.save", collection::create("site", $this, "data", $data));
        if (@$args->cancel === true)
            return;
        else if (!is_empty(@$args->data))
                $data = $args->data;
        
        if(is_null($this->id)) {
            $root = Site::FetchRoot();
            $id = $this->dbt->Insert($root->tree_id, '', $data);
            $this->Load($id);
        }
        else
            $this->dbt->Update($this->id, $data);

        Navigator::$cache->PrecacheTree();
            
    }

    public function InsertChild($folder) {

        $data = $folder->tocollection();

        $data->Delete("tree_children");
        $id = $this->dbt->Insert($this->id, '', $data);
        
        Navigator::$cache->PrecacheTree();
        
        $folder->Load($id);
        
        $folder->SetModified();
        
        return $folder;
    }

    public function FetchPublications($storageList = null /* array() | storageid or name */, $crit = "", $order = "", $page = -1, $pagesize = 10) {
        
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);

        $order = ($order != "") ? $order : "link_order";
        
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }

    public function Publications($criteria = "", $order = "" ,$page = -1, $pagesize = 10) {
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }

    public function Uri($folder = null, $publication = null, $args = null) {
        $surl = $this->Url();
        $furl = '';
        if(!is_null($folder))
            $furl = $folder->Url($publication, $args);
        
        return $surl.$furl;
    }
    
    public function URL($p = null, $args = null, $lang = null, $storage = null) {
        global $core;
        return $core->nav->Url($this, $p, $storage, $args, $lang);
    }

    public function Ajar($published_only = false, $forseLevels = 1) {
        
        return Navigator::$cache->Ajar($this, $published_only, $forseLevels);
        
        /*$ret = new collection();
        $condition = '';
        if($published_only) {
            $condition = array("and" => array("(SELECT count(distinct E.tree_published) FROM sys_tree E, sys_tree F WHERE F.tree_id = A.tree_id and E.tree_published=0 AND F.tree_left_key BETWEEN E.tree_left_key AND E.tree_right_key) = 0"));
        }
        $ajr = $this->dbt->Ajar($this->sNode->tree_id, '', $condition);
        while($aj = $ajr->FetchNext()) {
            if($aj->tree_level == 1)
                $obj = new Site($aj, null);
            else
                $obj = new Folder($this->dbt, $aj);

            $ret->add($aj->tree_name, $obj);
        }
        return $ret;*/
    }

    public function Branch($folder = null, $published_only = false, $cond = '') {
        
        return Navigator::$cache->Branch($this, $published_only);
        
        
        $ret = new Branch();
    
        $condition = '';
        if(!is_null($folder)) {
            if(is_numeric($folder))
                $condition = array("and" => array("tree_id = '".$folder."'"));
            else
                $condition = array("and" => array("tree_name = '".$folder."'"));
        }
        else if($published_only) {
            $condition = array("and" => array("(SELECT count(distinct E.tree_published) FROM sys_tree E, sys_tree F  WHERE  F.tree_id = A.tree_id and E.tree_published=0 AND F.tree_left_key  BETWEEN E.tree_left_key AND E.tree_right_key) = 0"));
        }

        if(!is_empty($cond)) {
            if(!is_empty($condition))
                $condition['and'][] = $cond;
            else
                $condition = array("and" => array($cond));
        }

        $ajr = $this->dbt->Branch($this->sNode->tree_id, '', $condition);
        while($aj = $ajr->FetchNext()) {
            if($aj->tree_level == 1)
                $obj = new Site($aj, null);
            else
                $obj = new Folder($this->dbt, $aj);

            $ret->add($aj->tree_name, $obj);
        }
        return $ret;
    }

    public function createSecurityBathHierarchy($suboperation) {
        return array(array("object" => $this, "operation" => "structure.sites.".$suboperation));
    }

    public function ToXML($withBranch = false){
        $ret = "\n<site>";
        
        $c = $this->get_collection();
        $c->delete("tree_id");
        $c->delete("tree_left_key");
        $c->delete("tree_right_key");
        $c->delete("tree_level");
        $c->delete("tree_sid");
        
        $ret .= "\n".$c->ToXML();
        
        $args = $this->DispatchEvent("site.toxml.processxml", collection::create("xml", $c));
        if (!is_empty(@$args->xml))
            $ret .= $args->xml;
            
        if ($withBranch){
            $br = $this->Branch();
            $br->delete($this->name);
            $ret .= $br->ToXML();
        }
            
        $ret .= "\n</site>";
        return $ret;
    }

    public function FromXML($el){ //site
        $p = null;
        foreach ($el->childNodes as $pair){
            
            $args = $this->DispatchEvent("site.from_xml.processdata", collection::create("element", $pair));
            
            if ($pair->tagName == "collection"){
                $c = new Collection();
                $c->from_xml($pair);
                
                $args = $this->DispatchEvent("site.from_xml.setdata", collection::create("data", $c));
                if (!is_empty(@$args->data))
                    $c = $args->data;
                
                $this->sNode = $c->to_object();
                $this->Save();
            } else {
                $p = $pair;
            }
        }
        
        if ($p){
            $b = new Branch(array(), $this->dbt);
            $b->from_xml($p, $this);
        }
    }
    
#region Privates

    private function _loadProperties() {
        if(!($this->_properties instanceof FolderProperties))
            $this->_properties = new FolderProperties($this);
    }

#endregion    
    
#region Statics

    public static function FetchRoot() {
        $dbt = new dbtree("sys_tree", "tree");

        $root = $dbt->GetRootNode();
        return $root;
    }
    
    public static function FetchSite($name) {
        /*$dbt = new dbtree("sys_tree", "tree");
        $rr = $dbt->GetNode(-1, "tree_name='".$name."'"); */
        
        return Navigator::InitNode(Navigator::$cache->Item($name));
        
        global $core;                                                         
        $dtr = $core->dbe->ExecuteReader("select * from sys_tree where tree_name='".$name."' order by tree_level");
        $rr = $dtr->Read();
        if($rr) {             
            if($rr->tree_level == 1) {
                return new Site($rr);
            }       
        }
        
        return null;
        
    }
    
    public static function Fetch($id, $in_branch = null) {
        
        global $site, $MULTISITE;
        
        $dbt = new dbtree("sys_tree", "tree");
        
        $rr = false;
        if(is_numeric($id)) {
            $rr = Navigator::$cache->Item($id);
        }
        else if( is_string($id) ) {
            $ret = Navigator::$cache->ByName($id);
            $rr = $ret->First();
        }
        else if(is_object($id))
            $rr = $id;
        
        return Navigator::InitNode($rr);
    }

    public static function EnumSites($t = BYNAME) {

        return Navigator::$cache->Sites($t);
        
        /*$ret = new collection();
        $dbt = new dbtree("sys_tree", "tree");
        $treeRoot = $dbt->GetRootNode();

        $childs = $dbt->Ajar($treeRoot->tree_id);
        $childs->disconnect();
        foreach($childs as $child) {
            $k = ($t == BYNAME ? $child->tree_name : $child->tree_domain);
            $ret->add($k, new Site($child));
        }
        
        return $ret; */
    }

    public static function EnumTree($published_only = false) {
        return Navigator::$cache->Nodes($published_only);
        
        /*$ret = new Branch();
        $dbt = new dbtree("sys_tree", "tree");
        $treeRoot = $dbt->GetRootNode();
        
        $condition = '';
        if($published_only) {
            $condition = array("and" => array("(SELECT count(distinct E.tree_published) FROM sys_tree E, sys_tree F  WHERE  F.tree_id = A.tree_id and E.tree_published=0 AND F.tree_left_key  BETWEEN E.tree_left_key AND E.tree_right_key) = 0"));
        }

        $childs = $dbt->Branch($treeRoot->tree_id, '', $condition);
        $childs->FetchNext();
        while($child = $childs->FetchNext()) {
            if($child->tree_level == 1)
                $ret->add($child->tree_name.$child->tree_id, new Site($child));
            else
                $ret->add($child->tree_name.$child->tree_id, new Folder($dbt, $child));
        }

        return $ret;*/
        
    }

    public static function FolderExists($folder, $in_branch = null) {
        global $core;

        if(is_null($in_branch)) {
            return $core->dbe->exists(sys_table("tree"), ( is_numeric($folder) ? "tree_id" : "tree_name"), $folder);
        }
        else {
            if(is_numeric($folder)) {
                $folder = Site::Fetch($folder);
                if(is_null($folder))
                    return false;
                return $folder->IsChildOf($in_branch);
            }
            else {
                if(!is_object($in_branch))
                    $in_branch = Site::Fetch($in_branch);
                $in_branch = $in_branch->Branch($folder);
                return $in_branch->Count() > 0;
            }    
        }
    }

    public static function getOperations() {
        $operaions = new Operations();
        $operaions->Add(new Operation("structure.sites.add", "Add site"));
        $operaions->Add(new Operation("structure.sites.delete", "Delete site"));
        $operaions->Add(new Operation("structure.sites.edit", "Edit site properties"));
        $operaions->Add(new Operation("structure.sites.children.add", "Add children"));
        $operaions->Add(new Operation("structure.sites.children.delete", "Delete children"));
        $operaions->Add(new Operation("structure.sites.children.edit", "Edit children"));
        $operaions->Add(new Operation("structure.sites.publish", "Publish the entire site"));
        $operaions->Add(new Operation("structure.sites.unpublish", "Unpublish the entire site"));
        return $operaions;
    }
    
    public static function Create($published, $name, $domain, $description, $language, $template, $notes = "") {
        $site = new Site();
        $site->published = intval($published);
        $site->name = $name;
        $site->domain = $domain;
        $site->description = $description;
        $site->language = $language;
        $site->template = $template;
        $site->notes = $notes;
        $site->properties = null;
        $site->header_statictitle = null;
        $site->header_inlinescripts = null;
        $site->header_inlinestyles = null;
        $site->header_basehref = null;
        $site->header_shortcuticon = null;
        $site->header_keywords = null;
        $site->header_description = null;
        $site->header_aditionaltags = null;
        $site->Save();   
        return $site; 
    }
    
#endregion    

#region Aliases

    // alias form ToXML
    public function to_xml($withBranch = false){ return $this->ToXML($withBranch); }

    public function from_xml($el){ $this->FromXML($el); }

    // alias for ToCollection()
    public function get_collection() { return $this->ToCollection(); }

#endregion

}



?>
