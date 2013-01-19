<?php

/**
	* class designTemplates
	*
	* Description for class designTemplates
	*
	* @author:
	*/				

class Repository extends Collection  {

    static $cache;
    static $loaded;
    
	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	private $table;
	
	function Repository() {
		$this->table = sys_table("repository");
		parent::__construct();
        
        Repository::$loaded = new ArrayList();
	}
    
    static function Cache() {
        global $core;
        Repository::$cache = new Collection();
        $rs = $core->dbe->ExecuteReader("select * from sys_repository order by repository_name");
        while ($r = $rs->Read())
            Repository::$cache->add(strtolower($r->repository_name), $r);
    }
	
	static function Enum($field = "name") {
		global $core;
		$c = new Repository();
		$field = "repository_".$field;
        foreach(Repository::$cache as $r)
			$c->add(strtolower($r->$field), new Library($r));
		return $c;
	}    
	
	//////////////////////////////////////////////////////////////////////////
	/// @access deprecated
	/// must use 
	/// $l = new Library($name);
	/// $l->Run();
	public static function Load($name) {
        if(is_null(Repository::$loaded)) Repository::$loaded = new ArrayList();
        if(Repository::$loaded->Exists(to_lower($name)))
            return;
        
        Repository::$loaded->Add(to_lower($name));
		$lib = new Library(Repository::$cache->$name);
		return $lib->Run();
	}

	public static function LoadBatch($names) {
		global $core;
        if(is_null(Repository::$loaded)) Repository::$loaded = new ArrayList();
        
		if(is_string($names)) {
			$nnn = new ArrayList();
			$nnn->FromString($names, ",");
		}
		else 
			$nnn = $names;
	
        foreach($nnn as $name) {
            if(!Repository::$loaded->Exists(to_lower($name))) {
                Repository::$loaded->Add(to_lower($name));
                $lib = new Library(Repository::$cache->$name);
                $lib->Run();
            }
        }
                        
    }
	
	public static function URL($name, $querystring = null) {
		$lib = new Library($name);
		return $lib->Url($querystring);
	}	
	
	public static function Tag($name, $querystring = null) {
		$lib = new Library($name);
		return $lib->Tag($querystring);
	}	

	static function Get($id){
		return new library($id);
	}
	
	public function ToXML($criteria){ //array(id1, id2, ...) //name1, name2
		if (is_array($criteria)){
			$libs = new collection();
			foreach ($criteria as $crit)
				$libs->add($crit, new Library($crit));
		} else {
			$libs = Repository::Enum();
		}
		
		$ret = "<repository>";
		foreach ($libs as $lib)
			$ret .= $lib->ToXML();
		$ret .= "</repository>";
		return $ret;
	}
	
	public function FromXML($el){
		$childs = $el->childNodes;
		foreach ($childs as $pair){
			$lib = new Library();
			$lib->FromXML($pair);
			$lib->id = -1;
			$this->Add($lib->name, $lib);
		}
	}
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("interface.repository.add", "Add the repository"));
		$operations->Add(new Operation("interface.repository.delete", "Delete the repository"));
		$operations->Add(new Operation("interface.repository.edit", "Edit the repository"));
		return $operations;
	}
	
	public function Save() {
		foreach($this as $l)
			$l->Save();
	}
    
    public function ToPHPScript() {
        $code = '/* Dumping repository */'."\n\n";
        foreach($this as $lib) {
            $code .= $lib->ToPhpScript()."\n";
        }
        return $code;
    }
}

class Library extends Object {
	
	private $_table;
	
	function Library($data = null){
		global $core;

		$this->_table = sys_table("repository");
		
		if(is_null($data)) {
			parent::__construct(null, "repository_");
			return;
		}
		
		if (is_object($data)){
			parent::__construct($data, "repository_");
			return;
		}
		
		global $BLOB_VIEWER, $RS_LOADER;		
		
		if($data == "blob" && !is_null($BLOB_VIEWER)) {
			parent::__construct(null, "repository_");
			$this->id = 999;
			$this->name = "blob";
			$this->type = PHP_CODE;
			$this->code = @$core->fs->readfile(substr($BLOB_VIEWER,5), CORE);
		}		
		elseif($data == "runtime_style" && !is_null($RS_LOADER)) {
			parent::__construct(null, "repository_");
            
			$this->id = 1999;
			$this->name = "runtime_style";
			$this->type = HTML_CSS;
			$this->code = $core->fs->readfile(substr($RS_LOADER,5), CORE);
		}		
		else {
			if (is_numeric($data)){
                $row = Repository::$cache->Item(Repository::$cache->IndexOf($data, 'repository_id'));
			} else if (is_string($data)){
                $row = Repository::$cache->$data;
			} else {
				parent::__construct(null, "repository_");
				return;
			}
			
			
			if (!$row) {
				parent::__construct(null, "repository_");
				return;
			}
			
			parent::__construct($row, "repository_");
		}
        
		
	}
	
	function Process() {

		$lastmodified = $this->datemodified;
		if(!$lastmodified)
			$lastmodified = time()+1;
		$etag = '"'.md5($this->name."?".$_SERVER["QUERY_STRING"]).'"';
		if(!modified_since($lastmodified)) {
			header("HTTP/1.0 304 Not Modified");
			header("Content-Length: 0");
			header("ETag: {$etag}");
			return;
		}

		$body = $this->Run(true);
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastmodified)." GMT");
		header("Expires: ".gmdate("D, d M Y H:i:s", $lastmodified + 86400)." GMT");
		header("Cache-Control: post-check=0, pre-check=0, must-revalidate, public");
		// header("Content-type: text/css; charset=utf-8");
		header("Content-Length: ".strlen($body) + 3);
		header("ETag: {$etag}");
		header("Pragma: !invalid");
		echo $body;
        exit;
	}
	
	function is_valid() {
		return count($this->ToArray()) > 0;
	}
	
	function __get($key){
		global $core;
		if($key == "ext") {
			switch($this->type) {
				case PHP_CODE: return "php";
				case HTML_SCRIPT: return "js";
				case HTML_CSS: return "css";
				case HTML_XSLT: return "xslt";
				case HTML_XML: return "xml";
				default:
					return "php";
			}
		} else if($key == "datemodified") {
			if(substr($this->code, 0, 9) == "LOADFILE:") {
				$datemodified = $core->fs->FileLastModified(strtolower(substr($this->code, 9, strlen($this->code))));
				$this->datemodified = db_datetime($datemodified);
				$this->Save(false);
			}
			else  {
                if(property_exists($this->_data, "repository_datemodified"))
				    $datemodified = strtotime($this->_data->repository_datemodified);
                else
                    $datemodified = false;
            }
			return $datemodified;
		} if($key == "cacheexpired") { // cache modified
			if($this->CacheExists())
				return $this->datemodified >= $core->fs->FileLastModified($this->CacheName());
			else
				return true;
		} else if($key == 'isValid') {
            return !is_null($this->id);
        }
		
		return parent::__get($key);
	}
    
    public static function Create($name, $type, $code, $datemodified = null) {
        $l = new Library();
        $l->name = $name;
        $l->type = $type;
        $l->code = $code;
        $l->datemodified = db_datetime(!$datemodified ? time() : $datemodified);
        $l->Save();
        return $l;
    }
	
	public function Save($changeMod = true){
		global $core;
		
		if($changeMod)
			$this->datemodified = db_datetime(time());
			
		$data = $this->ToCollection();
		$data->Delete("repository_id");
        $data->repository_name = strtolower($data->repository_name);
		if(is_empty($this->id) || $this->id == -1)
			$this->id = $core->dbe->insert($this->_table, $data);
		else {
			$core->dbe->set($this->_table, "repository_id", $this->id, $data);
		}

        // clear code cache
        $core->fs->DeleteFile('/_system/_cache/code/'.md5('library_'.$this->id."_".$this->name).'.php', SITE);
	}
	
	public function Run($tofile = false, $addheader = true){
		global $core;
		
		if (is_null($this->_data))
			return "";
		
		$ret = "";
        
        $context = new OutputContext($this->name);
        
        
        
		switch($this->type) {
			case PHP_CODE:
				if($this->code != "") {                         
                    $code = code_cache('/_system/_cache/code/'.md5('library_'.$this->id."_".$this->name).'.php', $this->code);       
					//$code = convert_php_context($this->code);
					eval($code);
				}
				break;
			case HTML_CSS:
				if($tofile) {
					if($this->code != "") {    
						$code = "<".'?'."\n".($addheader ? 'header("content-type: text/css; charset=utf-8", false);' : '').' $context = new OutputContext("'.$this->name.'"); '."\n".'?'.'>'.load_from_file($this->code);
						$code = convert_php_context($code);
						eval($code);                       
					}
				}
				else {
					if(!function_exists($this->name)) {    
						$code = "function ".$this->name."(\$args) {\n\$ret = <<<FUNCT\n\n<style type=text/css>\n";
						$code .= load_from_file($this->code);
						$code .= "\n</style>\n\nFUNCT;\n\nreturn \$ret;\n}\n";
						eval($code);
					}				
				}
				break;
			case HTML_XML:
				if($tofile) {
					if($this->code != "") {
						$code = "<".'?'."\n".($addheader ? 'header("content-type: text/xml; charset=utf-8", false);' : '').' $context = new OutputContext("'.$this->name.'"); $context->Out("<'.'?xml version=\'1.0\' encoding=\'utf-8\' standalone=\'yes\' ?".'.'">");'."\n".'?'.'>'.load_from_file($this->code);
						$code = convert_php_context($code);
						eval($code);
					}
				}
/*				else {
					if(!function_exists($this->name)) {
						$code = "function ".$this->name."(\$args) {\n\$ret = <<<FUNCT\n\n<style type=text/css>\n";
						$code .= $this->code;
						$code .= "\n</style>\n\nFUNCT;\n\nreturn \$ret;\n}\n";
						eval($code);
					}				
				}*/
				break;
			case HTML_SCRIPT:
				if($tofile) {
					$code = "<"."?\n".($addheader ? 'header("Content-Type: text/javascript; charset=utf-8");' : '').' $context = new OutputContext("'.$this->name.'"); '."\n?".">".load_from_file($this->code);
					$code = convert_php_context($code);
					eval($code);
				}
				else {
					if(!function_exists($this->name)) {
						$code = "function ".$this->name."(\$args) {\n\$ret = <<<FUNCT\n\n<script language=javascript type=text/javascript>\n";
						$code .= load_from_file($this->code);
						$code .= "\n</script>\n\nFUNCT;\n\nreturn \$ret;\n}\n";
						eval($code);
					}				
				}
				break;
			case HTML_XSLT:
			
				break;
		}
		return ($context->empty ? $ret : $context->content);
	}
	
	public function CacheExists() {
		global $core;
		return $core->fs->FileExists($this->CacheName());
	}
	
	public function Cache() {
		global $core;
		$core->fs->WriteFile($this->CacheName(), $this->Run(true, false));
	}
	
	public function CacheName() {
		global $core;
		$path = "/_system/_cache/repository/";
		if(!$core->fs->DirExists($path))
			$core->fs->CreateDir($path);
		
		if($this->type != PHP_CODE)
			return $path.to_lower($this->name.".".$this->ext);
		return "";
	}
	
	public function Tag($querystring = null) {
		switch($this->type) {
			case PHP_CODE:
				return '';
			case HTML_CSS:
				return '<link rel="stylesheet" type="text/css" href="'.$this->Url($querystring).'" />'."\n";
			case HTML_SCRIPT:
				return '<script type="text/javascript" src="'.$this->Url($querystring).'"></script>'."\n";
			default: 
				return '';
		}
	}
	
	public function Url($querystring = null) {
		global $core, $SERVICE_MODE;
        
        if($SERVICE_MODE == 'developing')
            return '/'.$this->name.'.php';
        
		switch($this->type) {
			case PHP_CODE:
				$rule = $core->sts->USE_MOD_REWRITE;
				if($rule == "") {
					if($querystring != null)
						$rule = "/?fr=%s&%s";
					else
						$rule = "/?fr=%s";
				}
				else {
					if($querystring != null)
						$rule = "/%s.php?%s";
					else
						$rule = "/%s.php";
				}
				if($querystring != null)
					return sprintf($rule, $this->name, $querystring);
				else
					return sprintf($rule, $this->name);
				break;
			default:
				if($querystring != null) {
					$rule = $core->sts->USE_MOD_REWRITE;
					if($rule == "") {
						if($querystring != null)
							$rule = "/?fr=%s&%s";
						else
							$rule = "/?fr=%s";
					}
					return sprintf($rule, $this->name, $querystring);
				}
				else {
					if($this->cacheexpired)
						$this->Cache();
					return $this->CacheName();
				}
				break;
		}
		return "";
	}
	
	public function Delete() {
		global $core;
		return $core->dbe->delete("sys_repository", "repository_name", $this->name);
	}
	
	public function ToXML(){
		return parent::ToXML("library", array(), array("code"), array("id"));
	}
    
    public function ToPHPScript() {
        return '
            /* Dumping library '.$this->name.' */
            $l = new Library("'.$this->name.'");
            if($l->isValid) 
                $l->Delete();
            Library::Create("'.$this->name.'", "'.$this->type.'", hex2bin("'.bin2hex(load_from_file($this->code)).'"), "'.$this->datemodified.'");
        ';
    }
	
}

class DesignTemplate extends Object {
    
    public function __construct($dt = null) {
        if(!is_object($dt) && !is_null($dt)) {
            global $core;
            $dtt = $core->dbe->ExecuteReader('select * from sys_templates where '.(is_numeric($dt) ? 'templates_id' : 'templates_name')." = '".strtolower($dt)."'");
            /*if($dtt->Count() == 0)
                trigger_error('can not find a design template by key');*/
            $dt = $dtt->Read();
        }
        parent::__construct($dt, "templates_");
    }
    
    public static function Create($name, $head, $body, $repositories, $title, $keywords, $description, $baseurl, $styles, $scripts, $additional, $doctype, $id = -1) { 
        // $header = Hahstable::Create(title, keywords, description, baseurl, styles, scripts, additional, doctype)
        $d = new DesignTemplate();
        $d->name = strtolower($name);
        $d->head = $head;
        $d->body = $body;
        $d->repositories = $repositories;
        $d->html_doctype = $doctype;
        $d->head_title = $title;
        $d->head_metakeywords = $keywords;
        $d->head_metadescription = $description;
        $d->head_baseurl = $baseurl;
        $d->head_styles = $styles;
        $d->head_scripts = $scripts;
        $d->head_aditionaltags = $additional;
        $d->Save($id);
        return $d;
    }
    
    public function Save($id = -1) {
        global $core;
        $data = $this->ToCollection();
        $data->Delete("templates_id");
        $data->templates_name = strtolower($data->templates_name);
        if(!is_null($this->id)) {
            $core->dbe->set(sys_table('templates'), "templates_id", $this->id, $data);
        }
        else {
            if($id >= 0)
                $data->Add('templates_id', $id);
            $iid = $core->dbe->insert(sys_table('templates'), $data); 
            if($id < 0)
                $this->id = $iid;
            else
                $this->id = $id;                
        }
            
        // delete code cache
        // $core->fs->DeleteFile('/_system/_cache/code/'.md5('designtemplate'."_".strval($this->id)).'.php', SITE);
    }
    
    public function Delete() {
        global $core;
        // delete code cache
        // @$core->fs->DeleteFile('/_system/_cache/code/'.md5('designtemplate'."_".strval($this->id)).'.php', SITE);
        return $core->dbe->delete(sys_table('templates'), "templates_id", $this->id);
    }

    public function ToPHPScript() {
        return '
            /* Dumping design template '.$this->name.' */
            $d = new DesignTemplate("'.$this->name.'");
            if($d->isValid) 
                $d->Delete();
            $'.$this->name.' = DesignTemplate::Create("'.$this->name.'", hex2bin("'.bin2hex($this->head).'"), hex2bin("'.bin2hex(load_from_file($this->body)).'"), "'.$this->repositories.'", hex2bin("'.bin2hex($this->head_title).'"), hex2bin("'.bin2hex($this->head_metakeywords).'"), hex2bin("'.bin2hex($this->head_metadescription).'"), hex2bin("'.bin2hex($this->head_baseurl).'"), hex2bin("'.bin2hex($this->head_styles).'"), hex2bin("'.bin2hex($this->head_scripts).'"), hex2bin("'.bin2hex($this->head_aditionaltags).'"), hex2bin("'.bin2hex($this->html_doctype).'"), '.$this->id.');
        ';
    }
    
    public function __get($prop) {
        switch($prop) {
            case 'isValid':
                return !is_null($this->id);
        }
        return parent::__get($prop);
    }
    
}                        

class DesignTemplates extends IEventDispatcher  {

	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	private $table;
		
	function designTemplates() {
		$this->table = sys_table("templates");
	}
	
	function enum() {
		global $core;
        return $core->dbe->ExecuteReader("select * from ".$this->table);
	}
	
	function get_collection() {
		$ret = new collection();
		$rr = $this->enum();
		while($design = $rr->Read()) {
			$ret->add($design->templates_name, collection::create($design));
		}
		return $ret;
	}
	
	function from_id($tid) {
		global $core;

		$r = $core->dbe->ExecuteReader("select * from ".$this->table." where templates_id=".$tid);
		return $r->Read();
	}
	
	function save($name, $data) {
		global $core;
		
        $data->Delete('templates_id');
        
		return $core->dbe->set($this->table, "templates_name", $name, $data);
	}

	function delete($name) {
		global $core;
		
		return $core->dbe->delete($this->table, "templates_name", $name);
	}
	
	function create($data) {
		global $core;
		
		return $core->dbe->insert($this->table, $data);
	}
	
	function run($name, $args) {
		global $core;
		
		if(is_numeric($name))
			$name = $this->from_id($name)->templates_name;
		
		$r = $this->enum();
		$r->disconnect();
		
		$template = $r->item($name);
		
		$ret = "";
		
		eval($template->head);
		
		eval($template->body);
		
		return $ret;
	}

	public static function apply($name, $args) {
		global $core;
		global $runtimeStyles;
		global $context;
		
        $context = new OutputContext($name);
        $runtimeStyles = new Collection();

        $dt = new designTemplates();
        $template = new DesignTemplate($name);
        
		$site = $args->site;
		$folder = $args->folder;
		
		// $ret = "";
		$code = "";

		$code .= "\$context->Out(\"".addslashes($template->html_doctype)."\n\");\n";
		$code .= "\$context->Out(\"<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\">\n<head>\n\");\n";
		
		$code .= $dt->combine_libs($dt, $context, $template, $args->site, $args->folder);

		$code .= "\$context->StartBlockOutput(\"header\");\n";
		$code .= $dt->combine_header($dt, $context, $template, $args->site, $args->folder);
		$code .= "\$context->EndBlockOutput();\n";
		
		$code .= "\$context->Out(\"\n\n</head>\n\");\n";
		$code .= "\$context->Out(\"<body>\");\n";
		$code .= $dt->combine_html($dt, $context, $template, $args->site, $args->folder);
		$code .= "\$context->Out(\"\n</body>\n</html>\");\n"; //\n\n\n\n\n\n\n\n\n\n\n\n\n\n
		
		eval($code);
		
		if($runtimeStyles->Count() > 0) {
			$styles = "";
			foreach($runtimeStyles as $style) {
				$styles .= ",".$style;
			}
			$context->Out('<link href="/runtime_style.php?location='.substr($styles, 1).'" rel="stylesheet" type="text/css" />'."\n", "header");
		}
		
		return $context->content;
	}
	
	private function combine_libs($dt, $context, $template, $site, $folder){
		$code = "";
		$code .= "\$dt->DispatchEvent(\"design.libraries.loading\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		if(!is_empty($template->repositories))
			$code .= "Repository::LoadBatch(\"".trim($template->repositories)."\");\n";
		$code .= "\$dt->DispatchEvent(\"design.libraries.loaded\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		return $code;
	}
	
	private function combine_header($dt, $context, $template, $site, $folder){
		$code = "";

		$code .= "\$dt->DispatchEvent(\"design.header.rendering\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		
        $code .= convert_php_context('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'); ///
		$code .= convert_php_context($template->head); ///
		
		$code .= "if(\$template->head_title != \"\") {\n";
			$code .= "\$context->Out(\"\n\t\t<title>\");";
			$code .= "eval(convert_php_context(\$template->head_title));";
			$code .= "\$context->Out(\"</title>\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_metakeywords != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<meta name=\\\"Keywords\\\" content=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_metakeywords));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_metadescription != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<meta name=\\\"description\\\" content=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_metadescription));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_shortcuticon != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<link rel=\\\"shortcut icon\\\" href=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_shortcuticon));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_baseurl != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<base href=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_baseur));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_styles != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<style type=\\\"text/css\\\">\");";
			$code .= "eval(convert_php_context(\$template->head_styles));";
			$code .= "\$context->Out(\"</style>\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_scripts != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<script language=\\\"javascript\\\">\");";
			$code .= "eval(convert_php_context(\$template->head_scripts));";
			$code .= "\$context->Out(\"</script>\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_aditionaltags != \"\") {\n";
			$code .= "eval(convert_php_context(\$template->head_aditionaltags));";
		$code .= "}\n";

		$code .= "\$dt->DispatchEvent(\"design.header.rendered\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		
		return $code;
	}
	
	public function combine_html($dt, $context, $template, $site, $folder) {
		global $core;
		
		$code = "";
		
		$code .= "\$dt->DispatchEvent(\"design.body.rendering\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		
        $code .= code_cache('/_system/_cache/code/'.md5('designtemplate'."_".strval($template->id)).'.php', $template->body);
        
        // $template->body = load_from_file($template->body);
		// $code .= convert_php_context($template->body);
        
//		if($core->rq->getkey == 1)
//			$code .= "\$context->Out(\n\"<!-- Westbazaar.ru - RAC Core 2.3 - 0C19570FAC104A37AC18B55CEA1F9E25 -->\n\");\n"; ///
		
		$code .= "\$dt->DispatchEvent(\"design.body.rendered\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		
		return $code;
	}
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("interface.designes.add", "Add the design template"));
		$operations->Add(new Operation("interface.designes.delete", "Delete the design template"));
		$operations->Add(new Operation("interface.designes.edit", "Edit the design template"));
		return $operations;
	}
	
    public function ToPHPScript() {
        $ret = '/* Dumping design templates */'."\n\n";
        $rps = new designTemplates();
        $rps = $rps->enum();
        while($d = $rps->FetchNext()) {
            $dd = new DesignTemplate($d);
            $ret .= $dd->ToPHPScript();
        }
        return $ret;
    }
    
}

?>
