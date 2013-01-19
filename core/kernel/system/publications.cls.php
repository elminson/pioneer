<?php


class Publication extends IEventDispatcher {

#region Properties

	private $pdata;
	public $datarow;
	public $module;
	public $error;
	
	/*custom properties no relational table fields*/
	private $_properties; /* class Properties */

#endregion

	function __construct($l, $dt = null) {
		global $core;
		$this->error = false;
		
		if(is_numeric($l)) {
			$r = $core->dbe->ExecuteReader("select * from ".sys_table("links")." where link_id='".$l."'");
			$this->pdata = $r->Read();
			if (is_null($this->pdata)) {
				$this->error = true;
				$dt = null;
			}
		}
		else
			$this->pdata = $l;
           
		$this->init($dt);
		
		$this->RegisterEvent("publication.save");
		$this->RegisterEvent("publication.saving");
		$this->RegisterEvent("publication.discarding");
		$this->RegisterEvent("publication.discard");
	}
	
	public function __get($nm) {
		$lprop = "link_".$nm;

		if($nm == "properties") {
			$this->_loadProperties();
			return $this->_properties;
		}
		
		if($nm == "link_properties") {
			return $this->pdata->link_propertiesvalues;
		}
                  
		$value = @$this->pdata->$lprop;
		if(is_null($value)) {
			/*if the property not found in standart fields, try find it in properties*/
			$this->_loadProperties();
			$prop = $this->_properties->$nm;
			if($prop) {
				if($prop->type == "blob") {
					global $core;
					return new blob(intval(@$prop->value));
				}
				else {
					return @$prop->value;
				}
			}				
			return null;
		}
		return $value;
	}

	public function __set($nm, $val) {
		$lprop = "link_".$nm;
		
        if(!is_null(@$this->pdata->$lprop)) {
			if($nm == "template" && ($this->_properties instanceof PublicationProperties)) {
				$this->_properties->Clear();
				@$this->pdata->link_propertiesvalues = null;
			}
			@$this->pdata->$lprop = $val;
			return;
		}
		else {
			$this->_loadProperties();	
			if($this->_properties->Exists($nm))
				$this->_properties->$nm->value = $value;
		}

	}

	public function Publications($criteria = "", $order = "", $page = -1, $pagesize = 10, $joins = "") {
		return new Publications($this, $criteria, $order, $page, $pagesize, $joins);
	}

	public function FetchPublications($storageList = null /* array() | storageid or name */, $crit = "", $order = "", $page = -1, $pagesize = 10) {
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);
        
		$order = ($order != "") ? $order : "link_order";

		return new Publications($this, $criteria, $order, $page, $pagesize);
	}
	
	public function MoveTo($parent) {
		$this->parent_id = $parent->id;
		$this->parent_storage_id = 0;
		$this->Save();
	}
	
	public function CopyTo($parent) {
		$pps = $this->Publications();
		$newNode = $this->_CopySingleNode($parent);
		if($pps->Count() > 0) {
			while($pp = $pps->FetchNext()) {
				$pp->CopyTo($newNode);
			}
		}
		return $newNode;
	}
	
	private function _CopySingleNode($parent) {
		$cp = clone $this->pdata;
		$cp = crop_object_fields($cp, "/link_.*/i");
		$p = new Publication($cp);
		$p->id = -1;
		$p->order = null;
		$p->parent_id = $parent->id;
		$p->Save();
		return $p;
	}
	
	public function Discard() {
		global $core;
		
		/*event discard for publications*/
		$args = $this->DispatchEvent("publication.discarding", collection::create("publication", $this));
		if (@$args->cancel === true)
			return;
		
		$pubs = $this->Publications();
		while($pub = $pubs->FetchNext()) {
			$pub->Discard();
		}
		
		$this->SetModified();
		
		$core->dbe->delete(sys_table("links"), "link_id", $this->id);
		
		/*event discard for publications*/
		$this->DispatchEvent("publication.discard", collection::create("publication", $this));
	}

	public function Save() {
		global $core;
		
		/*event save for publications*/
		$args = $this->DispatchEvent("publication.saving", collection::create("publication", $this, "publicationdata", $this->pdata));
		if (@$args->cancel === true)
			return;
		else if(@$args->apply === true)  
			$this->pdata = $args->publicationdata;
		
		$data = collection::create($this->pdata);
		if($this->_properties instanceof PublicationProperties) {
			$data->link_propertiesvalues = serialize($this->_properties->get_array());
		}
		else
			$data->link_propertiesvalues = "";
		
		if (is_null($data->link_template))
			$data->link_template = "";

		$data->link_modifieddate = strftime("%Y-%m-%d %H:%M:%S", time());
		if (@$data->link_id > 0){
			$data->Delete("link_id");
			$core->dbe->set(sys_table("links"), "link_id", $this->pdata->link_id, $data);
			$is_new = 0;
		} else {
			//iout($data);
			//exit;
			if (!is_numeric($data->link_parent_id) || !is_numeric($data->link_parent_storage_id) ||
				!is_numeric($data->link_child_storage_id) || !is_numeric($data->link_child_id))
				return;
			
			$data->Delete("link_id");
			$data->Delete("link_order");
			$data->Delete("link_child_count");
			$id = $core->dbe->insert(sys_table("links"), $data);
			//iout($data); exit;	
			$core->dbe->set(sys_table("links"), "link_id", $id, new collection(array("link_order" => $id)));
			$this->pdata->link_id = $id;
			
			$this->init();
			$is_new = 1;
			///$this->pdata->link_id = $id;
		}

		$this->SetModified();
		
		/*event save for publications*/
		$this->DispatchEvent("publication.save", collection::create("publication", $this, 'isnew', $is_new));
        
	}
    
    public function Next() {
        global $core;
        $r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order > ".$this->pdata->link_order." order by link_order", 1, 1);
        $rr = $r->Read();
        if($rr)
            return new Publication($rr->link_id);
        return null;
    }

    public function Previous() {
        global $core;
        $r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order < ".$this->pdata->link_order." order by link_order desc", 1, 1);
        $rr = $r->Read();
        if($rr)
            return new Publication($rr->link_id);
        return null;
    }

	public function FindFolder() {
		global $core;
		
		$p = $this->Parent();
		while($p instanceof Publication) {
			$p = $p->Parent();
		}
		
		return $p;
	}
	
	public function Parent(){
		global $core;
		
		if ($this->parent_storage_id == 0) {
			return Site::Fetch($this->parent_id);
		} else {
			$l = $this->pdata;
			$r = $core->dbe->ExecuteReader("select * from sys_links where link_id='".$l->link_parent_id."'", 1, 1);
			if(!$r->HasRows())
				return null;
			return new Publication($r->Read());
		}
	}

	// modifies the parent publications and folders modification date
	public function SetModified() {
		$s = $this->id.",";
		$p = $this->Parent();
		
		while($p instanceof Publication) {
			$s .= $p->id.",";
			$p = $p->Parent();
		}
		$s = "in (".rtrim($s, ",").")";
		
		global $core;
		$core->dbe->query("update sys_links set link_modifieddate='".strftime("%Y-%m-%d %H:%M:%S", time())."' where link_id ".$s);
		
		if ($p) ///
			$p->SetModified();
	}

	public function Out($template = "", $user_params = null, $operation = OPERATION_ITEM) {
		$template = $this->getTemplate($template);
		return $template->Out($operation, $this, $user_params);
	}

	public function URL($s = null, $args = null){
		if(is_null($s)) {
			$s = $this->FindFolder();
		}
		
		return $s->URL($this, $args);
	}
	
	public function MoveUp() {
		global $core;

		$r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order < ".$this->pdata->link_order." order by link_order desc", 1, 1);
		$rr = $r->Read();
		$p2 = new Publication($rr->link_id);

		Publications::ChangeOrder($this, $p2);

	}
	
	public function MoveDown() {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order > ".$this->pdata->link_order." order by link_order", 1, 1);
		$rr = $r->Read();
		if($rr) {
			$p1 = new Publication($rr->link_id);
			Publications::ChangeOrder($p1, $this);
		}
	}
	
	public function getTemplate($template = null) {
		return template::create(is_empty($template) ? $this->template : $template, $this->object_type == 1 ? $this->module : $this->datarow->storage);
	}
	
	public function ToCollection() {
		$res = new collection();
		$res->add("publication", collection::create($this->pdata));
		$res->add("datarow", collection::create($this->datarow->data()));
		$res->add("module", ($this->module ? $this->module->GetData() : ''));
		$res->add("output", $this->Out(TEMPLATE_ADMIN, null, false));
		
		$pubs = $this->Publications();
		if($pubs->Count() > 0) {
			$res->add("publications", $pubs->ToCollection());
		}
		return $res;
	}
	
	public function ToXML($withBranch = false){
		$ret = "\n<publication>";
		
		$data = collection::create($this->pdata);
		$data->FromObject(crop_object_fields($data->ToArray(), "/link_.*/i"), true);
		$data->Delete("link_child_count");
		
		$ret .= "\n".$data->ToXML();
		
		$args = $this->DispatchEvent("publication.toxml.processxml", collection::create("xml", $c));
		if (!is_empty(@$args->xml))
			$ret .= $args->xml;
			
		if ($withBranch)
			$ret .= $this->Publications()->ToXML($withBranch);
			
		$ret .= "\n</publication>";
		return $ret;
	}
	
	public function FromXML($el, $parent){
		$p = null;
		
		foreach ($el->childNodes as $pair){
			
			$args = $this->DispatchEvent("publication.from_xml.processdata", collection::create("element", $pair));
			
			if ($pair->tagName == "collection"){
				$c = new collection();
				$c->FromXML($pair);
				$c->FromObject(crop_object_fields($c->ToArray(), "/link_.*/i"), true);
				
				$c->link_parent_id = (is_numeric($parent)) ? $parent : $parent->id;
				
				if ($parent instanceof Folder)
					$c->link_parent_storage_id = 0;
				else if ($parent instanceof Publication)
					$c->link_parent_storage_id = 1;
				
				$args = $this->DispatchEvent("publication.from_xml.setdata", collection::create("data", $c));
				if (!is_empty(@$args->data))
					$c = $args->data;
				
				$c->Delete("link_id");
				$c->Delete("link_child_count");
				
				$this->pdata = $c->ToObject();
				
				$this->Save();
			} else {
				$p = $pair;
			}
		}
		if ($p){
			$pubs = new Publications($this);
			$pubs->FromXML($p);
		}
	}
	
#region Privates
	
	private function init($dt = null){
		global $core;
		
		if(is_null($dt)){
			if ($this->pdata->link_object_type == "1"){
				$modules = $core->mm->modules;
				$this->module = $modules->search($this->pdata->link_child_storage_id, "id"); //
			} else {
				$storage = new Storage($this->pdata->link_child_storage_id); 
				if(!is_null($storage)) {
					$dtr = new DataRows($storage);
          
					$dtr->Load("", $storage->table."_id='".$this->child_id."'", "");
					$this->datarow = $dtr->FetchNext();
				} else {
					$this->datarow = null;
				}
			}
		} else {
			if ($dt instanceof CModule)
				$this->module = $dt;
			else
				$this->datarow = $dt;
		}
	}

	private function _loadProperties() {
		if(!($this->_properties instanceof PublicationProperties)) {
			$this->_properties = new PublicationProperties($this);
		}
	}

#endregion	
	
#region Aliases

	public function to_xml($withBranch = false){ return $this->ToXML($withBranch); }
	
	public function from_xml($el, $parent){ $this->FromXML($el, $parent); }
	
	public function get_collection() { return $this->ToCollection(); }

#endregion	

    public function ToPHPScript() {
        
        $ret = '';
        
        if($this->datarow) {
            
            $table = $this->datarow->storage->table;
            $id = $this->datarow->id;
            
            return '
                $p = new stdClass();
                $p->link_id = -1;
                $p->link_order = 0;
                $p->link_object_type = 0;
                $p->link_child_storage_id = Storages::Get(\''.$table.'\')->id;
                $p->link_child_id = '.$id.';
                $p->link_template = "'.$this->pdata->link_template.'";
                $p->link_propertiesvalues = \''.$this->pdata->link_propertiesvalues.'\';
                $p->link_modifieddate = \''.$this->pdata->link_modifieddate.'\';
                $p->link_parent_storage_id = '.$this->pdata->link_parent_storage_id.';
                $p->link_parent_id = '.$this->pdata->link_parent_id.';
                $p = new Publication($p);
                $p->Save();
            ';
            
        }
        else if($this->module) {
            $entry = $this->module->entry;
            
            return '
                $p = new stdClass();
                $p->link_id = -1;
                $p->link_order = 0;
                $p->link_object_type = 1;
                $p->link_child_storage_id = $core->mm->modules->'.$entry.'->id;
                $p->link_child_id = 0;
                $p->link_template = "'.$this->pdata->link_template.'";
                $p->link_propertiesvalues = \''.$this->pdata->link_propertiesvalues.'\';
                $p->link_modifieddate = \''.$this->pdata->link_modifieddate.'\';
                $p->link_parent_storage_id = '.$this->pdata->link_parent_storage_id.';
                $p->link_parent_id = '.$this->pdata->link_parent_id.';
                $p = new Publication($p);
                $p->Save();
            ';
        }
        
        return '';
        
    }

}

class Publications extends IEventDispatcher {

#region Properties

	private $links;

	private $pid;
	private $pstorage;

	private $storagesList;
	private $storages;
	
	private $disconnected;
	
	private $_initialParents;

#endregion

	public function __construct($sp, $criteria = "", $order = "", $page = -1, $pagesize = 10, $joins = "") {
		$this->disconnected = false;

		$this->_initialParents = $sp;
		
		if(is_array($sp) || $sp instanceof IteratorAggregate) {
			$this->pid = array();
			$this->pstorage = array();
			foreach($sp as $ss){
				$this->pid[] = $ss->id;
				if($ss instanceof Publication) {
					$this->pstorage[] = 1;
				}
				else if($ss instanceof Site || $ss instanceof Folder) {
					$this->pstorage[] = 0; //	it is a site or folder
				}
			}
		}
		else {
			if($sp instanceof Publication) {
				$this->pid = $sp->id;
				$this->pstorage = 1;
			}
			else if($sp instanceof Site || $sp instanceof Folder) {
				$this->pid = $sp->id;
				$this->pstorage = 0; //	it is a site or folder
			}
		}
		$this->storagesList = new storages();
		$this->storages = new collection();

        $this->Load($criteria, $order, $page, $pagesize, $joins);
        
		$this->RegisterEvent("publication.adding");
		$this->RegisterEvent("publication.add");

	}
	
	function __get($key){
		switch (strtolower($key)){
			case "disconnected" :
				return $this->disconnected;
			default :
		}
	}
	
	function __set($key, $value){
		
	}
	
	public function Count() {
		if($this->links != null)
			return $this->links->count();
		else
			return 0;
	}

	public function Affected() {
		if($this->links != null)
			return $this->links->affected;
		else
			return 0;
	}

	public function Load($criteria = "", $order = "", $page = -1, $pagesize = 10, $joins = ""){
		global $core;
		
        if(is_array($this->pid)) {
			$parents = array();
			for($i=0; $i<count($this->pid); $i++ ) {
				$parents[] = array("pid" => $this->pid[$i], "pstorage" => $this->pstorage[$i]);
			}
		}
		else {
			$parents = array(array("pid" => $this->pid, "pstorage" => $this->pstorage));
		}

		$q = Publications::_getPublicationsQuery($parents, $criteria, $order, $joins);

		$this->links = $core->dbe->ExecuteReader($q, $page, $pagesize);

	}

	public function FetchNext() {
		if($r = $this->links->FetchNext()) {
			if ($r->link_object_type == "1"){
				$obj = new CModule($r->link_child_storage_id);
			} else {
				$storage = new Storage($r->link_child_storage_id);
				$rr = crop_object_fields($r, "/".$storage->table."_.*/i");
				$obj = new DataRow($storage, $rr);
			}
			return new Publication($r, $obj);
		} else {
			$this->disconnected = true;
			return false;
		}
	}
	
	public function Add($dt, $parent = null) {
		global $core;

		if(is_array($this->pid) && $parent == null)
			return null;

		/*event save for publications*/
		$this->DispatchEvent("publication.adding", collection::create("publication", null, "datarow", $dt));
		
		$p = new stdClass();
		$p->link_id = -1;
		$p->link_order = 0;
		$p->link_object_type = ($dt instanceof CModule ? "1" : "0");
		$p->link_child_storage_id = ($dt instanceof CModule ? $dt->id : $dt->storage->id);
		$p->link_child_id = ($dt instanceof CModule ? 0 : $dt->id);
        $p->link_template = "";
        $p->link_propertiesvalues = null;
        $p->link_modifieddate = '0000-00-00 00:00:00';          
		
		if(is_array($this->pid)) {
			$p->link_parent_storage_id = ($parent instanceof Publication ? 1 : 0);
			$p->link_parent_id = $parent->id;
		}
		else {
			$p->link_parent_storage_id = $this->pstorage;
			$p->link_parent_id = $this->pid;
		}
		
		$p = new Publication($p, $dt);
		$p->Save();
		$p->SetModified();
		
		/*event add for publications*/
		$this->DispatchEvent("publication.add", collection::create("publication", $p));
		
		return $p;
	}

    public function Clear() {
	    global $core;
	    while($pub = $this->FetchNext())
			$pub->Discard();
	}

	public function Out($template = "", $user_params = null, $create_checkbox = true) {
		$ret = "";
		$i = 0;
		if($this->Count() > 0) {
            if($user_params == null)
                $user_params = new collection();
            $user_params->Add("rendering_count", $this->Count());
			while($pub = $this->FetchNext()) {
				//$t = new phptemplate($pub->datarow->storage);
				$user_params->Add("rendering_index", $i);
				
				$ret .= $pub->Out($template, $user_params, OPERATION_LIST);
				
				if($user_params->cancel)
					break;
				
				$i ++;
			}
		}
		return $ret;
	}
	
	public function FetchAll(){
		$res = new Collection();
		while ($p = $this->FetchNext())
			$res->Add($p->id, $p);
		return $res;
	}
	
	public function ToCollection() {
		$res = new collection();
		while ($p = $this->FetchNext())
			$res->add("p".$p->id, $p->ToCollection());
		return $res;
	}
	
	public function ToXML($withBranch = false){
		if(is_array($this->pid))
			return "";
			
		$count = $this->Count();
		if ($count == 0)
			return;
			
		$ret = "\n<publications>";
		
		while ($pub = $this->FetchNext())
			$ret .= $pub->ToXML($withBranch);
		
		$args = $this->DispatchEvent("publications.toxml.processxml", collection::create("xml", $c));
		if (!is_empty(@$args->xml))
			$ret .= $args->xml;
			
		$ret .= "\n</publications>";
		return $ret;
	}
	
	public function FromXML($el){
		if(is_array($this->pid))
			return "";
	
	    foreach($el->childNodes as $pair) {
			
			$args = $this->DispatchEvent("publications.fromxml.processdata", collection::create("element", $pair));
			
			if ($pair->tagName == "publication"){
				$p = new Publication(null);
				$p->FromXML($pair, $this->pid);
			}
		}
		$this->Load();
	}

#region Statics

	static function FetchPublications($parents, $storageList = array() /* array() | storageid or name */, $crit = "", $order = "", $page = -1, $pagesize = 10) {
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);
		
		$order = ($order != "") ? $order : "link_order";

		return new Publications($parents, $criteria, $order, $page, $pagesize);
	}



	static function ClearDataLinks($storage_id, $data_id) {
		global $core;
		
		/* ????????? ???????? */
		$r = $core->dbe->ExecuteReader("select * from ".sys_table("links")." where (link_child_storage_id='".$storage_id."' and link_child_id='".$data_id."')", "link_id");
		while($rr = $r->Read()) {
			$p = new Publication($rr);
			$p->Discard();
		}

	}

	static function ChangeOrder($p1, $p2) {
		global $core;
		
		$id1 = $p1->id;
		$id2 = $p2->id;
		$order1 = $p1->order;
		$order2 = $p2->order;
		$core->dbe->Query("update sys_links set link_order=".$order1." where link_id=".$id2);
		$core->dbe->Query("update sys_links set link_order=".$order2." where link_id=".$id1);
		$p1->SetModified();
		$p2->SetModified();
	}

	static function PublishedStorages($parentid) {
		global $core;
		$storages = new ArrayList();
		$q1 = "select distinct link_child_storage_id, link_object_type from ".sys_table("links")." where link_parent_id=".$parentid;
		$r = $core->dbe->ExecuteReader($q1);
		while($rr = $r->Read()) {
			if($rr->link_object_type == 0)
				$storages->Add(storages::get($rr->link_child_storage_id));
			else 
				$storages->Add(new CModule($rr->link_child_storage_id));				
		}
		return $storages;
	}
    
    static function Exists($pid) {
        global $core;
        if(!is_numeric($pid)) $pid = 0;
        $r = $core->dbe->ExecuteReader("select count(*) as c from ".sys_table("links")." where link_id='".$pid."'");
        $row = $r->Read();
        return $row->c > 0;
    }
	
	public static function _getPublicationsQuery($parents = null,  /* array(array("pid" => parent_id, "pstorage" => pstorage), ...) */
												 $criteria = "", /* array("storage" => "where", ...) */
												 $order = "", 
												 $joins = "") {
		global $core;
		
        if($order == "")
			$order = "link_order";

        $crit = null;
		$ord = null;
		if(is_array($order)) {
			$ord = $order;
			$order = "";
		}
        if(is_array($criteria)) {
            $crit = $criteria;
            $criteria = "";
        }
		
		$pids = "";
		$pstorages = "";
		foreach($parents as $parent) {
			$pids .= ",".$parent["pid"];
			$pstorages .= ",".$parent["pstorage"];
		}
		$pids = substr($pids, 1);
		$pstorages = substr($pstorages, 1);
		$q1 = "select distinct storage_table, link_child_storage_id from ".sys_table("links").", sys_storages where link_parent_id in (".$pids.")  and link_parent_storage_id in (".$pstorages.") and (link_child_storage_id=sys_storages.storage_id)";
		$r = $core->dbe->ExecuteReader($q1);
        
		$q = "select *, (select count(link_id) from sys_links as l1 where l1.link_parent_id=sys_links.link_id and l1.link_parent_storage_id=1) as link_child_count from sys_links ";
		$where = "(link_parent_id in (".$pids.") and link_parent_storage_id in (".$pstorages.")) and ";
		
        if(is_array($ord)) 
            if(isset($ord['sys_links']))
                $order .= ','.$ord['sys_links'];
                
        while($rr = $r->Read()) {
			$q .= " left outer join ".$rr->storage_table." on ".$rr->storage_table."_id=link_child_id and link_child_storage_id=".$rr->link_child_storage_id." ";
			if(is_array($ord)) {
				if(isset($ord[$rr->storage_table]))
					$order .= ','.$ord[$rr->storage_table];
			}
            if(is_array($crit)) {
                if(isset($crit[$rr->storage_table]))
                    $criteria .= ' or '.$crit[$rr->storage_table]; // and
            }
		}
		if(substr($order, 0, 1) == ",")		
			$order = substr($order, 1);
			
		$q .= " left outer join sys_modules on module_id=link_child_storage_id and link_child_id=0";
		if ($joins != "")
			$q .= " ".$joins;
		
		if(!is_empty($order))
			$order = " order by ".$order;
		else
			$order = " order by link_order";
        if($criteria != "") { // and
            $criteria = substr($criteria, 0, 4) != " or " ? $criteria : substr($criteria, 4);
            $criteria = " and (".$criteria.")";
        }
        if(!is_null(@$crit["links"]) && !is_empty(@$crit["links"])){
            $criteria .= " and ".$crit["links"];
        }

	 	$q = $q." where ".substr($where, 0, strlen($where)-5).$criteria.$order;
		return $q;
	}
    
    public static function _getStoragesCriteria($storageList = null /* array() | storageid or name */, $crit = "") {
        global $core;
        $criteria = array();
        $criteria["links"] = "";
        foreach($storageList as $storage) {
            if(!is_numeric($storage)){
                
                $op = '=';
                if(substr($storage, 0, 1) == "-") {
                    $op = '<>'; 
                    $storage = substr($storage, 1);
                }
                
                if(Storages::IsExists($storage)) {
                    $storage = new Storage($storage);
                    $storage = $storage->id;
                    if($op == "=")
                    	$criteria["links"] .= " or (link_child_storage_id ".$op." ".$storage." and link_object_type=0)";
                    else
                    	$criteria["links"] .= " and (link_child_storage_id ".$op." ".$storage." and link_object_type=0)";
                }
                else {
                    $storage = $core->mm->modules->$storage;
                    $storage = $storage->id;
                    if($op == "=")
                    	$criteria["links"] .= " or (link_child_storage_id ".$op." ".$storage." and link_object_type=1)";
                    else
                    	$criteria["links"] .= " and (link_child_storage_id ".$op." ".$storage." and link_object_type=1)";
                }

            }
            else {
                if($storage >= 0){
                    //$criteria .= " or link_child_storage_id = ".$storage;
                    $criteria["links"] .= " or link_child_storage_id = ".$storage." and link_object_type=0";
                }
                else{
                    //$criteria .= " and link_child_storage_id <> ".$storage;
                    $criteria["links"] .= " and link_child_storage_id <> ".$storage." and link_object_type=0";
                }    
            }   
        }
        
        if(is_string($crit) && !is_empty($crit))
            $criteria["links"] .= " and ".$crit;

        if (!is_empty($criteria["links"])) {
            $criteria["links"] = "(". substr($criteria["links"], 4) . ")";
        }
        
        if(is_array($crit))
            $criteria = array_merge($criteria, $crit);        

        return $criteria;
    }
   
#endregion

#region Aliases

	function get_collection() { return $this->ToCollection(); }
	
	public function to_xml($withBranch = false){ return $this->ToXML($withBranch); }
	
	public function from_xml($el){
		$this->FromXML($el);
	}
#endregion	

}


?>