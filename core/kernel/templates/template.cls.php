<?php

/**
	* class template
	*
	* Description for class template
	*
	* @author:
	*/

class TemplateCache {

	static $db;
	static $path;
	static $table;
	static $enabled;
	
	private $_data;
	private $_etag;
	private $_modified;
	private $_cachename;
	private $_cached;
	
	private $_content;
	
	private $_template;
	private $_params;
	private $_operation;
	
	public function __construct($template, $data, $params, $operation) {
		global $core;

		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_ENABLED"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_ENABLED", "check", "false", null, true, "System template cache settings"));

		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_DB"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_DB", "check", "false", null, true, "System template cache settings"));
			
		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_PATH"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_PATH", "text", "/_system/_cache/templates/", null, true, "System template cache settings"));

		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_TABLE"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_TABLE", "text", "sys_template_cache", null, true, "System template cache settings"));

		if($core->sts->SETTING_TEMPLATECACHE_DB == "true") {
			if(!$core->dbe->tableexists($core->sts->SETTING_TEMPLATECACHE_TABLE)) {
                $core->dbe->CreateTable('sys_template_cache', array(
                      'hash' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                      'datemodified' => array('type' => 'datetime', 'additional' => ' default NULL'),
                      'cache' => array('type' => 'longtext', 'additional' => '')
                ), array(
                    'sys_template_cache_hash' => array('fields' => 'hash', 'constraint' => 'PRIMARY KEY')
                ), '');
			}
		}
		
		if(is_null(TemplateCache::$enabled))
			TemplateCache::$enabled = $core->sts->SETTING_TEMPLATECACHE_ENABLED == "true" ? true : false;
		
		if(is_null(TemplateCache::$path))
			TemplateCache::$path = $core->sts->SETTING_TEMPLATECACHE_PATH;

		if(is_null(TemplateCache::$table))
			TemplateCache::$table = $core->sts->SETTING_TEMPLATECACHE_TABLE;

		if(is_null(TemplateCache::$db))
			TemplateCache::$db = $core->sts->SETTING_TEMPLATECACHE_DB;

		if(TemplateCache::$db != "true") {
			if(!$core->fs->DirExists(TemplateCache::$path)) {
				$core->fs->CreateDir(TemplateCache::$path);
			}
		}		
		
		$this->_data = $data;
		$this->_template = $template;
		$this->_params = $params;
		$this->_operation = $operation;
		
		$this->LoadInfo();
	}
	
	public function LoadInfo() {
		global $core;
		
		$dt = $this->_data;
		if($dt instanceOf Publication)
			$dt = is_null($dt->datarow) ? $dt->module : $dt->datarow;
		$this->_etag = md5(
				$this->_template->id."_".
				$this->_data->id."_".
				$dt->id."_".
				CleanCacheFromURL()
			);
		
		$cf = $core->nav->folder;
        if(!$cf)
            $cf = $core->nav->site;
		
		$this->_cachename = TemplateCache::$path.'/'.$this->_etag.'.cache';
		if(TemplateCache::$db == "true") {
			$rs = $core->dbe->ExecuteReader("select * from ".TemplateCache::$table." where hash='".$this->_etag."'");
			$this->_exists = ($rs->Count() > 0);
			if($this->_data instanceOf Publication)
				$this->_modified = strtotime($this->_data->modifieddate);
			else
				$this->_modified = strtotime($cf->datemodified);
			if($this->_exists) {
				$row = $rs->Read();
				$this->_cached = strtotime($row->datemodified);
				$this->_content = $row->cache;
			}
			else { 
				$this->_cached = 0;
				$this->_content = null;
			}
		}
		else {
			$this->_exists = $core->fs->FileExists($this->_cachename);
			if($this->_data instanceOf Publication)
				$this->_modified = strtotime($this->_data->modifieddate);
			else
				$this->_modified = strtotime($cf->datemodified);
			
			if($this->_exists)
				$this->_cached = $core->fs->FileLastModified($this->_cachename);
			else 
				$this->_cached = 0;
		}
		
		if(!is_empty($this->_template->cachecheck)) {
			$arr = explode(",", $this->_template->cachecheck);
			foreach($arr as $f) {
				$f = Site::Fetch($f);
				if($this->_modified < strtotime($f->datemodified))
					$this->_modified = strtotime($f->datemodified);
			}
		}
		
	}
	
	private function _getContent() {
		global $core;
		if(TemplateCache::$db == "true") { 
			return $this->_content;
		}
		else {
			return $core->fs->ReadFile($this->_cachename);
		}
	}
	
	public function Process() {
		global $core;

		if(!TemplateCache::$enabled)
			return $this->_template->Render($this->_operation, $this->_data, $this->_params);
		
		$isGet = isset($_GET['recache']);
		if($this->_cached < $this->_modified || $isGet) {
			// create cache and return
			$body = $this->_template->Render($this->_operation, $this->_data, $this->_params);
			if(TemplateCache::$db == "true") {
				$data = Hashtable::Create("hash", $this->_etag, "datemodified", strftime("%Y-%m-%d %H:%M:%S", time()), "cache", $body);
				if($this->_exists) {
					$core->dbe->Update(TemplateCache::$table, "hash", $this->_etag, $data);
				}
				else {
					$core->dbe->Insert(TemplateCache::$table, $data);
				}
			}
			else {
				$core->fs->DeleteFile($this->_cachename);
				$core->fs->WriteFile($this->_cachename, $body);
			}
			return $body;
		}
		else {
			// read cache and return
			return $this->_getContent();
		}		
	}

}

class Template extends Object {
	
	private $_pref;
	private $_storage;
	
	private $_cname;
	
	private $_subitems;
	
	private $_list = null;
    
    public $dontcache = false;
    
	public function __construct($data = null, $type = TEMPLATE_STORAGE, $storage = null, $list = null) {
		$this->_pref = $type;
		$this->_storage = $storage;
		$this->_list = $list;
		$this->_cname = "";

		parent::__construct($data, $this->_pref."_templates_");
		
		$this->RegisterEvent("template.create");
		$this->RegisterEvent("template.saveing");
		$this->RegisterEvent("template.saved");
		$this->RegisterEvent("template.deleting");
		$this->RegisterEvent("template.deleted");
		$this->RegisterEvent("template.rendering");
		$this->RegisterEvent("template.rendered");
		$this->RegisterEvent("template.getbody");		
		$this->RegisterEvent("template.body.convertion");
		$this->RegisterEvent("template.body.converted");
		$this->RegisterEvent("template.standart.rendering");
		$this->RegisterEvent("template.standart.rendered");
		$this->RegisterEvent("template.module.rendering");
		$this->RegisterEvent("template.module.rendered");
		$this->RegisterEvent("template.standart.field.rendering");
		$this->RegisterEvent("template.standart.field.rendered");
	
		$this->DispatchEvent("template.create", Hashtable::Create());
	}
	
	public static function Create($name, $storage = null) {
		if($storage instanceof CModule)
			$type = TEMPLATE_MODULE;
		else {
			if(!($storage instanceof storage))
				$storage = storages::get($storage);
			$type = TEMPLATE_STORAGE;
		}
		
		$t = new Templates($storage, $type);
		// $template = $t->Item($name == "" ? TEMPLATE_DEFAULT : $name);
		$n = $name == "" ? TEMPLATE_DEFAULT : $name;
		if($t->Exists($n))
			return $t->Item($n);
		else
			return new Template(null, $type, $storage);
			
	}
    
    public static function CreateTemplate($storage, $type, $name, $description, $composite, $list, $styles, $properties, $cache, $cachecheck) {
        $t = new Template(null, $type, $storage);
        $t->name = strtolower($name);
        $t->description = $description;
        $t->list = html_entity_decode($list, HTML_ENTITIES, "utf-8");
        $t->properties = $properties;
        $t->styles = $styles;
        $t->composite = ($composite ? 1 : 0);
        $t->cache = ($cache ? 1 : 0);
        $t->cachecheck = $cachecheck;
        $t->Save();
        return $t;
    }
	
	public static function FromId($id, $type) {
		global $core;
		$table = "sys_".$type."_templates";
		$idd = $type."_templates_id";
		$sname = $type."_templates_".$type."_id";
		$rs = $core->dbe->ExecuteReader("select * from ".$table." where ".$idd."='".$id."'");
		if($rs->count() > 0){
			$r = $rs->Read();
			if($type == TEMPLATE_STORAGE)
				return new Template($r, $type, storages::get($r->$sname));
			else
				return new Template($r, $type, new CModule($r->$sname));
		}
			
	}
	
	public function Storage() {
		return $this->_storage;
	}
	
	public function Data() {
		return $this->_data;
	}
	
	public function get_collection($loadFiles = true) {
		$d = clone $this->_data;
		if($loadFiles) {
			$lname = $this->_pref."_templates_list";
			$d->$lname = $this->getBody();
		}
		return collection::create($d);
	}
	
	public function __get($field) {
		$f = $this->_pref."_templates_".$field;
		return @$this->_data->$f;
	}
	
	public function __set($field, $value) {
		$f = $this->_pref."_templates_".$field;
		@$this->_data->$f = $value;
	}
	
	public function Save() {
		global $core;
		
		$args = $this->DispatchEvent("template.saveing", Hashtable::Create());
		if(@$args->cancel === true)
			return $this->id;
		
		$tp = $this->_pref."_id";
		$this->$tp = $this->_storage->id;
		
		$c = $this->get_collection(false);
		$idname = $this->_pref."_templates_id";
        
        $namename = $this->_pref."_templates_name";
        $c->$namename = strtolower($c->$namename);
        
        // clear code cache
        $core->fs->DeleteFile('/_system/_cache/code/'.md5($this->_pref."_".strval($this->_storage->id)."_".strval($this->id)).'.php', SITE);
        
		$id = $c->$idname;
		$c->Delete($idname);
		if($id == -1 || is_empty($id)){
			$id = $core->dbe->insert("sys_".$this->_pref."_templates", $c);
		} else {
			$core->dbe->set("sys_".$this->_pref."_templates", $this->_pref."_templates_id", $id, $c);
		}

		$this->id = $id;
		if(!is_null($this->_list)) {
			$this->_list->setModified();
		}

		$this->DispatchEvent("template.saved", Hashtable::Create());
		
		return $id;
	}
	
	public function Delete() {
		global $core;

		$args = $this->DispatchEvent("template.deleting", Hashtable::Create());
		if(@$args->cancel === true)
			return ;
		
		$core->dbe->delete("sys_".$this->_pref."_templates", $this->_pref."_templates_id", $this->id);
		if(!is_null($this->_list)) {
			$this->_list->setModified();
		}
		
		$this->DispatchEvent("template.deleted", Hashtable::Create());
		
	}
	
	public function SubTemplates() {
		if(is_null($this->_subitems)) {
			$body = $this->list;
			$s = new Hashtable();
			$s->FromString($body, "\n", ":");
			
			$this->_subitems = new Hashtable();
			
			$ppp = new Templates($this->_storage, $this->_pref);
			foreach($s as $k => $v) {
				$vv = $ppp->item(trim($v, "\r"));
				if(!is_null($vv) && $vv !== false)
					$this->_subitems->Add(strtolower($k), $vv);
			}

		}
		return $this->_subitems;
	}
	
    public function IsInFile() { return substr($this->list, 0, 9) == "LOADFILE:"; }
    
	public function getBody() {
		global $core;
		
		$args = $this->DispatchEvent("template.body.convertion", Hashtable::Create("body", $this->list));
		if(@$args->cancel === true)
			return @$args->body;
        
		// $body = convert_php_context(load_from_file($this->list));
        if(!$this->dontcache)
            $body = code_cache('/_system/_cache/code/'.md5($this->_pref."_".strval($this->_storage->id)."_".strval($this->id)).'.php', $this->list);
        else
            $body = convert_php_context(load_from_file($this->list));
        
		$args = $this->DispatchEvent("template.body.converted", Hashtable::Create("body", $body));
		if(@$args->apply === true)
			$body = @$args->body;

		return $body;
	}
	
	public static function getText($text = "toolbar_browse_publications_info", $id = null, $storage = "", $creationdate = null, $templates = null, $publication = null, $template = null) {
		global $postback;
		$uniq = "unique: %s, created: %s, template: %s";
		if(!is_null($postback))
			$uniq = $postback->lang->$text;
			
		if(!is_null($template)) {
			$args = $template->DispatchEvent("template.gettext", Hashtable::Create("text", $uniq, "id", $id, "storage", $storage, "creationdate", $creationdate, "templates", $templates, "publication", $publication));
			if(@$args->cancel === true)
				return @$args->text;
		}

		return sprintf($uniq, $id, $storage, $creationdate, $templates);
	}
	
	public function Out($operation = OPERATION_LIST, $data = null, $params = null) {
		global $core;
		$args = $this->DispatchEvent("template.rendering", Hashtable::Create("operation", $operation, "data", $data, "params", $params));
		if(@$args->cancel === true)
			return @$args->output;
		
		if($operation == OPERATION_ADMIN)
			return $this->ActiveOut($data, $params);
		
		if($this->_pref == TEMPLATE_STORAGE && (int)$this->composite === 1) {
			$subs = $this->SubTemplates();
			
			$ctempl = $subs->$operation;			
			
			if($ctempl === false)
				$ctempl = $subs->list;
			
			if ($ctempl == false)
				return;
			return $ctempl->Out($operation, $data, $params);
		}

		// временная мера
		global $runtimeStyles;
		if(!is_null($runtimeStyles) && $this->id && !is_empty($this->styles))
			$runtimeStyles->Add($this->_pref.".".$this->_storage->id.".".$this->id, $this->_pref.".".$this->_storage->id.".".$this->id);
		
		$body = "";
		if($this->cache) {
			$tc = new TemplateCache($this, $data, $params, $operation);
			$content = $tc->Process();
		}
		else 
			$content = $this->Render($operation, $data, $params);

		//global $context;
//		if(is_null($context))
			return $content;

	//	$context->Out($content, $this->_cname);
		
		return "";
	}
	
	public function Render($operation = OPERATION_LIST, $data = null, $params = null) { 
		global $core;
		global $gfolder;
		global $site;
		
		$folder = null;
		if(!is_null($core->nav->folder)) 
			$folder = $core->nav->folder;
        else
            $folder = $site;
		
		$this->_cname = $this->_pref."_".strval($this->_storage->id)."_".strval($this->id);
		$context = new OutputContext($this->_cname);

		$args = hashtable::create(
            "template", $this, 
            "folder", $folder, 
            "site", $site, 
            "userparams", is_null($params) ? new Hashtable() : $params
        );
        
		if($data instanceof Publication) {
			$args->Add("publication", $data);
			$this->_cname .= "_".$data->id;
			if (is_null($data->datarow)){
				$entry = $data->module->entry;
				if ($core->mm->activemodules->Exists($entry))
					$args->Add("module", $core->mm->activemodules->$entry);
				else
					$args->Add("module", $data->module);
			} else
				$args->Add("datarow", $data->datarow);
		}
		else if($data instanceof CModule) {
			$this->_cname .= "_".$data->id;
			$args->Add("module", $data);
		}
		else {
			$this->_cname .= "_".$data->id;
			$args->Add("datarow", $data);
		}
		
		$body = $this->getBody();
		
		$retargs = $this->DispatchEvent("template.getbody", Hashtable::Create("template", $this, "type", $this->_pref, "operation", $operation, "data", $data, "params", $params, "body", $body));
		if(@$retargs->apply === true)
			$body = $retargs->body;
            
		if(!is_empty($body)) {
            // $t = microtime(true);

            eval($body);
            
            // $t = (microtime(true) - $t)*1000;
            // out($this->name, $t);
		}
		
		$args = $this->DispatchEvent("template.rendered", Hashtable::Create("template", $this, "type", $this->_pref, "operation", $operation, "data", $data, "params", $params, "context", $context));
		if(@$args->apply === true) {
			$context->Clear();
			$context->Out($args->output);
		}

		$c = $context->content;
		
		unset($context);
		return $c;
	}
	
	private function ActiveOut($data = null, $params = null, $recursioncheck = null) {
		
		if(!is_null($params)) {
			if(@$params->Exists("admin_checkboxes") && @$params->admin_checkboxes === false) {
				$v = null;
				if($data instanceof Publication)
					$v = (is_null($data->module)) ? $data->datarow : $data->module;
				return $this->StandartOut(is_null($v) ? $data : $v, !is_null($v) ? $v : null);
			}
		}
		
		if($data instanceof Publication) {

			$rr = "";
			$rr .= "<table class='admin-template' style='border-bottom:1px solid #c0c0c0' cellpadding=4><tr>";
			$rr .= "<td class='unique' style='background-color: ".$this->Storage()->color.";' colspan=2>".Template::getText("toolbar_browse_publications_info", $data->id, (is_null($data->module) ? $data->datarow->storage->name : $data->module->title), std_hformat_date($data->creationdate, "d.m.Y H:i:s"), Templates::Visualize($data, $params), $data, $this)."</td></tr>
			<tr onclick='javascript: setRowCheck(this);' id='data".$data->id."'><td style='width: 100%'>";
			$v = (is_null($data->module)) ? $data->datarow : $data->module;
			$rr .= $this->StandartOut($v, $data, $recursioncheck); //
			$rr .= "</td><td class='checkbox'><input type=checkbox name=template_operation_id_".$data->id." value=".$data->id." class=checkbox hilitable=1></td></tr></table>";
		} 
		else {
			$rr = "";
			$rr .= "<table width='100%' class='admin-template' style='border-bottom:1px solid #c0c0c0' cellpadding='4'><tr><td><tr onclick='javascript: setRowCheck(this);' id='data".$data->id."'><td style='width: 100%;".($data->storage && $data->storage->istree ? 'padding-left: '.(($data->level-1) * 20).'px;' : '')."'>";
			$rr .= $this->StandartOut($data, null, $recursioncheck);
			$rr .= "</td><td valign='middle' width='20'><input type='checkbox' name='template_operation_id_".$data->id."' value='".$data->id."' class='checkbox' hilitable='1'></td></tr></table>";
		}
		return $rr;		
	}
	
	private function StandartOut($data, $pub = null, $recursioncheck = null) {
		global $core;
        
		$args = $this->DispatchEvent("template.standart.rendering", Hashtable::Create("data", $data, "publication", $pub));
		if(@$args->cancel === true)
			return $args->output;
		
		$ret = "";
		if ($this->_storage instanceof CModule){
			$args = $this->DispatchEvent("template.module.rendering", Hashtable::Create("data", $data, "publication", $pub));
			if(@$args->cancel === true)
				return @$args->output;
				
			$ret = "<table cellpadding=0 cellspacing=2 border=0 class='template-content-table'>";
			$ret .= "<tr>";
			$ret .= "<td class='template-value'><b>".$this->_storage->title." (".$this->_storage->version.")"."</b><br>".$this->_storage->description."</td>";
			$ret .= "</tr>";
			$ret .= "</table>";
			
			$args = $this->DispatchEvent("template.module.rendered", Hashtable::Create("output", $ret, "data", $data, "publication", $pub));
			if(@$args->cancel === true)
				$ret = @$args->output;
			
			return $ret;
		}
		
		// $data->active = false;
		
		$folders = "";
		if(method_exists($data, "Publications")) {
                         
			$pubs = $data->Publications();
			if($pubs->Count() > 0) {
                $ff = array();
				foreach($pubs as $p) {
					$f = $p->FindFolder();
                    if(is_null(@$ff[$f->description]))
                        $ff[$f->description] = "";
                    $ff[$f->description] .= ",".$p->id;
				}
                foreach($ff as $f => $ps) {
                    $folders .= ",".$f."[".substr($ps, 1)."]";
                }
                $folders = substr($folders, 1);
			}
		}
        
		$ret .= "<table cellpadding=0 cellspacing=2 border=0 class='template-content-table'>";
		$ret .= "<tr>";
		$ret .= "<td class='template-field'>".Template::getText("toolbar_stoarge_data_id").":</td>";
		$ret .= "<td class='template-value'><strong>".$data->id." (".Template::getText("toolbar_stoarge_data_datecreated").": ".std_hformat_date($data->datecreated, "d.m.Y H:i:s").(!is_empty($folders) ? ",".Template::getText("toolbar_stoarge_data_publishedto").":&nbsp;".$folders : "").(@$data->storage->istree ? ", ".Template::getText("toolbar_stoarge_node_level").": ".@$data->level : "").")"."</strong></td>";
        $ret .= "</tr>";
		
		$fields = $this->_storage->fields;
		$i=0;
		foreach($fields as $field) {

			$args = $this->DispatchEvent("template.standart.field.rendering", Hashtable::Create("field", $field, "data", $data));
			if(!(@$args->cancel === true)) {
				if($field->showintemplate == 0)
					continue;
				
				$fname = $field->field;
				$fld = $field->name;
				$val = $data->$fname;
				

				if($field->lookup != "")
					$val = $this->ImplodeLookup($field, $val, $data);
				else if($field->onetomany != "" && $field->onetomany != "0")			
					$val = $this->ImplodeOneToMany($this->_storage, $field, $val, $data->id, $pub, $recursioncheck);
				else if($field->values != "")
					$val = $this->ImplodeValues($field, $val);
				else {
					switch(strtolower($field->type)) {
						case "text":
							$val = html_strip($val);
							break;
						case "file":
							$v = $val;
							if(!($v instanceof FileView))
								$v = new FileView($v);
                                
                            if($v->isValid) {
							    $src = $v->Src();
                                $filename = basename($src);
                                $size = size_to_string($core->fs->FileSize($src));
							    $v = '<a target="_blank" href="'.$src.'"><img src="'.$v->mimetype->icon.'" style="border: 0px;"></a>';
							    $val = '<table><tr><td>'.$v.'</td><td><b>File: </b>'.$filename.'<br /><b>Path: </b>'.$src.'<br/><b>Size:</b> '.$size.'</td></tr></table>';
                            }
                            else {
                                $val = "";
                            }
							break;
						case "numeric":
						case "datetime": {
							$val = $val;
							break;
						}
						case "bigdate": {
							$val = strftime("%Y-%m-%d %H:%M:%S", $val);
							break;
						}
						case "memo": {
							if($field->onetomany == "" || $field->onetomany == "0")
								$val =  wordwrap(FirstNWords(htmlentities($val, HTML_ENTITIES, "utf-8"), 50), 70, "<br>");
							break;
						}
						case "html": {
							$val = wordwrap(FirstNWords(htmlentities($val, HTML_ENTITIES, "utf-8"), 50), 70, "<br>");
							break;
						}
						case "check": {
							$val = ($val == 1 ? "checked" : "unchecked");
							break;
						}
						case "blob": {
							if($val)
								$val = $val->img(new Size(100, 75));
							else
								$val = "";
								
							break;
						}
						case "blob list": {
							
							if(!($val instanceof Bloblist))
								$val = new BlobList($val);
							
							$val = $this->ImplodeBlobList($this->_storage, $field, $val, $data->id, $pub, $recursioncheck);
							
							break;
						}
						case "file list": 
							if(!($val instanceof Filelist))
								$val = new Filelist($val);
							
							// сделать как блоб лист
							// $val = $this->ImplodeFileList($this->_storage, $field, $val, $data->id, $pub, $recursioncheck);
							
							$val = str_replace(";", "<br />", $val->ToString());
							break;
						
					}
				}
			}				
			
			$fout = "<tr>";
			$fout .= "<td class='template-field'>".$fld."</td>";
			$fout .= "<td class='template-value'>".$val."</td>";
			$fout .= "</tr>";					  
			
			$args = $this->DispatchEvent("template.standart.field.rendered", Hashtable::Create("output", $fout, "data", $data, "field", $field, "value", $val));
			if(@$args->apply === true)
				$fout = @$args->output;	
			
			$ret .= $fout;
				
		}
		$ret .=  "</table>";

		$args = $this->DispatchEvent("template.standart.rendered", Hashtable::Create("output", $ret, "data", $data, "publication", $pub));
		if(@$args->apply === true)
			$ret = @$args->output;
			
		return $ret;		
	}

	private function ImplodeValues($field, $val) {

        if($field->type == "multiselect") {
            if($val->Count() > 0) {
                $col = $val;
            }
            else {
                global $postback;
                $col = new Collection();
                $col->Add("0", $postback->lang->empty_lookup);
            }
            $val = join(",", $col->Items());
            return $val;
        }
        else {		
		    $vv = explode("\n", $field->values);
		    foreach($vv as $v) {
			    $vvv = explode(":", $v);
			    if($vvv[0] == $val)
				    return $vvv[1];
		    }
        }
		return "Not selected";
	}

	private function ImplodeLookup($field, $val, $data) {
		global $core;
        global $postback;

        if($field->type == "multiselect") {
            if($val->Count() > 0) {
                $lookup = $field->SplitLookup();
                $condition = $lookup->condition;
                eval('$condition = "'.$condition.'";');
                $query = (!is_empty($lookup->query)) ? $lookup->query : "SELECT ".$lookup->fields." FROM ".$lookup->table." where ".$lookup->id." in (".join(",", $val->Keys()).")".(is_empty($condition) ? '' : ' and '.$condition);
                $r = $core->dbe->ExecuteReader($query);
                $vvvs = "";
                $col = new Collection();
                while($row = $r->Read()) {
                    $show  = $lookup->show;
                    $id = $lookup->id;
                    $col->Add($row->$id, $row->$show);
                }
            }
            else {
                $col = new Collection();
                $col->Add("0", $postback->lang->empty_lookup);
            }
            $val = join(",", $col->Items());
        }
        else {
            
            $lookup = $field->SplitLookup();
            if(!$lookup->isValid)
                $val = @$postback->lang->incorrect_lookup; //incorrect lookup
            else {
                $condition = $lookup->condition;
                eval('$condition = "'.$condition.'";');

			    $error2 = false;
                if(is_empty($val))
                    $val = @$postback->lang->empty_lookup;
                else {
                    $fname = $data->storage->fname($field->field);
                    $query = (!is_empty($lookup->query)) ? $lookup->query : "select ".$lookup->fields." FROM ".$lookup->table." where ".$lookup->id." = '".$data->data()->$fname."'".(is_empty($condition) ? '' : ' and '.$condition);
			        $result = $core->dbe->ExecuteReader($query);
                    if($result->Count() == 0) {
                        $val = @$postback->lang->incorrect_lookup; //incorrect lookup
                    }
                    else {
                        $r = $result->Read();
                        
                        $show = $lookup->show;
                        $val = $r->$show;
                    }
                }
		    }
        }
		return $val;
	}
	
	private function ImplodeOneToMany($storage, $field, $val, $id, $pub = null, $recursioncheck = null) {
		
		if(!$recursioncheck)
			$recursioncheck = new ArrayList();
		
		// $val = "-- multilink field --";
		// return $val;
		
		if($val instanceof MultilinkField) {
			
			$ret = "";
			$rows = $val->Rows();
			if($rows->Count() > 0) {
				//$t = new Template($val->Storage());
				
				$rid = "toggle_".uniqid();
				$ret .= '<div class="template-onetomany-title"><a href="#"><img class="toggler-collapsed" src="images/new/spacer1x1.gif" width="16" height="16" onclick="javascript: var obj = document.getElementById(\''.$rid.'\'); obj.style.display = obj.style.display == \'\' ? \'none\' : \'\'; this.className = this.className == \'toggler-collapsed\' ? \'toggler-expanded\' : \'toggler-collapsed\'; return false; "></a>';
				
				$ret .= ' -- multilink field -- rows count: '.$rows->Count();
				$ret .= '</div>';
				$ret .= "<div style='display: none; padding: 2px; border: 1px solid #f2f2f2; height: 320px; overflow: auto;' id='".$rid."'>";
				while($row = $rows->FetchNext()) {
					if ($recursioncheck->Contains($row->id."_".$row->storage->id)){
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Recursion detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					
					if($recursioncheck->Count() > 1) {
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Too mach nesting detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					
					$recursioncheck->Add($row->id."_".$row->storage->id);
					$tt = new Template(null, TEMPLATE_STORAGE, $row->storage);
					$ret .= $tt->ActiveOut($row, Hashtable::Create("admin_checkboxes", false), $recursioncheck);
					$recursioncheck->Delete($recursioncheck->IndexOf($row->id."_".$row->storage->id));
					//$ret .= $row->Out(null, null, OPERATION_ADMIN);
					$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
				}
				$ret .= "</div>";
				$val = $ret;
			}
			else {
				global $postback;
				$val = @$postback->lang->empty_multilink;
			}
		}
		else {
			global $postback;
			$val = @$postback->lang->incorrect_multilink; //incorrect onetomany link
		}
		
		return $val;
		
	}
	
	private function ImplodeBlobList($storage, $field, $val, $id, $pub = null, $recursioncheck = null) {
		
		if(!$recursioncheck)
			$recursioncheck = new ArrayList();
		
		if($val instanceof BlobList) {
			
			$ret = "";
			$rows = $val->Rows();
			if($rows->Count() > 0) {

				$rid = "toggle_".uniqid();
				$ret .= '<div class="template-onetomany-title"><a href="#"><img class="toggler-collapsed" src="images/new/spacer1x1.gif" width="16" height="16" onclick="javascript: var obj = document.getElementById(\''.$rid.'\'); obj.style.display = obj.style.display == \'\' ? \'none\' : \'\'; this.className = this.className == \'toggler-collapsed\' ? \'toggler-expanded\' : \'toggler-collapsed\'; return false; "></a>';
				$ret .= ' -- blob list -- blobs count: '.$rows->Count();
				$ret .= '</div>';
				$ret .= "<div style='display: none; padding: 2px; border: 1px solid #f2f2f2; height: 320px; overflow: auto;' id='".$rid."'>";
				while($row = $rows->FetchNext()) {
					if ($recursioncheck->Contains($row->id)){
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Recursion detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					
					if($recursioncheck->Count() > 1) {
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Too mach nesting detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					
					$recursioncheck->Add($row->id);
					
					// $tt = new Template(null, TEMPLATE_STORAGE, $row->storage);
					// $ret .= $tt->ActiveOut($row, Hashtable::Create("admin_checkboxes", false), $recursioncheck);
					$ret .= $row->Out(TEMPLATE_ADMIN, Hashtable::Create("admin_checkboxes", false));
					
					$recursioncheck->Delete($recursioncheck->IndexOf($row->id));
					//$ret .= $row->Out(null, null, OPERATION_ADMIN);
					$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
				}
				$ret .= "</div>";
				$val = $ret;
			}
			else {
				global $postback;
				$val = @$postback->lang->empty_multilink;
			}
		}
		else {
			global $postback;
			$val = @$postback->lang->incorrect_multilink; //incorrect onetomany link
		}
		
		return $val;
		
	}	
	
	public function ToXML(){
		return parent::ToXML("template", array(), array("description", "list", "properties", "styles"), array("id"));
	}
	
	public function FromXML($node){
		parent::FromXML($node);
		$tp = $this->_pref."_id";
		if($this->_pref == TEMPLATE_STORAGE)
			$this->_storage = new Storage($this->$tp);
		else	
			$this->_storage = new CModule($this->$tp);
		// $this->setModified();
	}
    
    public function ToPHPScript($storageProperty) {
        return 'Template::CreateTemplate('.$storageProperty.', '.($this->_storage instanceOf Storage ? 'TEMPLATE_STORAGE' : 'TEMPLATE_MODULE').', "'.$this->name.'", hex2bin("'.bin2hex($this->description).'"), '.($this->composite ? 'true' : 'false').', hex2bin("'.bin2hex(load_from_file($this->list)).'"), hex2bin("'.bin2hex(load_from_file($this->styles)).'"), hex2bin("'.bin2hex($this->properties).'"), '.($this->cache ? 'true' : 'false').', "'.$this->cachecheck.'");'."\n";
    }
	
}

class Templates extends Collection {

	static $cache;

	private $type;
	private $storage;
	
	private $changed = true;
	
	public function __construct($storage = null, $type = TEMPLATE_STORAGE) {
		parent::__construct();

		if(!Templates::$cache)
			Templates::$cache = new Collection();

		$this->type = $type;
		$this->storage = $storage;
	}
	
	public function setModified() {
		$this->changed = true;
	}
	
	private function _reload() {
		global $core;
		if($this->changed) {
			$name = $this->type."_templates_name";
			$this->Clear();
			if(!Templates::$cache->Exists($this->type."_".$this->storage->id)) {
				$cache = new Collection();
				$t = $core->dbe->ExecuteReader("select * from sys_".$this->type."_templates where ".$this->type."_templates_".$this->type."_id=".$this->storage->id." order by ".$this->type."_templates_name");
				while($tt = $t->Read()) {
					$this->Add($tt->$name, new Template($tt, $this->type, $this->storage));
					$cache->Add($tt->$name, new Template($tt, $this->type, $this->storage));
				}
				Templates::$cache->Add($this->type."_".$this->storage->id, $cache);
			}
			else {
				$cache = Templates::$cache->Item($this->type."_".$this->storage->id);
				foreach($cache as $t) {
					$this->Add($t->name, $t);
				}
			}
			$this->setModified();
		}
	}

	public function Exists($key) {
		if($this->changed)
			$this->_reload();
		return parent::Exists($key);
	}
	
	public function Key($index) {
		if($this->changed)
			$this->_reload();
		return parent::Key($index);
	}
	
	public function Count() {
		if($this->changed)
			$this->_reload();
		return parent::Count();
	}
	
	public function Item($k) {
		if($this->changed)
			$this->_reload();
		return parent::Item($k);
	}
	
	public function getIterator() {
		if($this->changed)
			$this->_reload();
		return parent::getIterator();
	}
	
	public static function Visualize($p, $params) {
		
		global $postback;
		$default_text = "Default template";
		$empty_text = "Empty template";
		if(!is_empty($postback)) {
			$default_text = $postback->lang->development_storages_template_default;
			$empty_text = $postback->lang->development_storages_template_empty;
		}
		
		$t = new Templates($p->object_type == 1 ? $p->module : $p->datarow->storage, $p->object_type == 1 ? TEMPLATE_MODULE : TEMPLATE_STORAGE);
		$ret = "<select class='select-box' name='pub_template_".$p->id."' onchange='javascript: return PostBack(\"content\", \"post\", \"development\", \"structure\", null, createArray(\"pub_template\", this.options[this.selectedIndex].value, \"pub_id\", \"".$p->id."\", \"page\", \"".$params->page."\"))'>";
		$ret .= "<option value='' style='background-color: #D0D8E9'>".$default_text."</option>\n";
		$b = ($p->template == TEMPLATE_EMPTY);
		$ret .= "<option value='".TEMPLATE_EMPTY."' ".($b ? "selected" : "")." style='background-color: #D0D8E9'>".$empty_text."</option>\n";
		$nname = $t->type."_templates_name";
		foreach($t as $l) {
			//if($l->composite == 1 && $l->name != TEMPLATE_DEFAULT) {
			if($l->name != TEMPLATE_DEFAULT) {
				$b = ($p->template == $l->name);
				$composite = $l->composite == 1 ? " style='background-color: #D0D8E9'" : "";
				$ret .= "<option value='".$l->name."' ".($b ? "selected" : "")." ".$composite.">".(is_empty($l->description) ? $l->name : $l->description)."</option>\n";
			}
		}
		$ret .= "</select>";
		return $ret;
	}
	
	public function Save() {
		foreach($this as $template)
			$template->Save();
	}

	public function ToXML(){
		$ret = '<templates storage="'.$this->storage->id.'" type="'.$this->type.'">';
		foreach ($this as $tpl)
			$ret .= $tpl->ToXML();
		$ret .= "</templates>";
		return $ret;
	}
	
	public function FromXML($el){
		$this->type = $el->getAttribute("type");
		$this->storage = null;
		
		$childs = $el->childNodes;
		foreach ($childs as $pair){
			switch ($pair->nodeName){
				case "template" :
					$t = new Template(null, $this->type);
					$t->FromXML($pair);
					parent::Add($t->name, $t);
					break;
			}
		}
		$this->setModified();
	}
    
    public function ToPHPScript($storageProperty) {
        $ret = '';
        foreach($this as $item) {
            $ret .= $item->ToPHPScript($storageProperty);
        }
        return $ret;
    }    
	
}

?>