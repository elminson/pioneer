<?php

class CodeCollector {
	
	private $_corepath;
	private $_adminpath;
	
	private $_files;
	private $_code;
	private $_tables;
	
	public function __construct() {
		global $CORE_PATH, $ADMIN_PATH;
		
		$this->_corepath = $CORE_PATH;
		$this->_adminpath = $ADMIN_PATH;
		
		$this->_files = new ArrayList();
		$this->_code = new ArrayList();
		$this->_tables = new ArrayList();
		
	}
	
	public function __get($prop) {
		switch($prop) {
			case "tables":
				return $this->_tables;
			case "files":
				return $this->_files;
			case "codes":
				return $this->_codes;
		}
	} 
	
	public function Collect() {
		global $core;
		
		$includes = file_get_contents($this->_corepath."core.inc.php");
		preg_match_all("/include_once\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1])) {
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
		}
		
		preg_match_all("/include\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1]))
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
		
		preg_match_all("/require\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1]))
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
		
		preg_match_all("/require_once\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1]))
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
			
		$adminfiles = $core->fs->ListFiles($this->_adminpath);
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath.$file->file);
		}
		
		$adminfiles = $core->fs->ListFiles($this->_adminpath."classes");
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath."classes/".$file->file);
		}
		
		$adminfiles = $core->fs->ListFiles($this->_adminpath."classes/lang");
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath."classes/lang/".$file->file);
		}

		$adminfiles = $core->fs->ListFiles($this->_adminpath."classes/scripts");
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath."classes/scripts/".$file->file);
		}
		
		$tables = $core->dbe->Tables();
		foreach($tables as $table) {
			if(substr($table, 0, 4) == "sys_") {
				$query = $core->dbe->ExecuteReader("SHOW CREATE TABLE ".$table."")->Read();
				$name = "Create Table";
				$this->_tables->Add($query->$name);
			}
		}
		
	}
	
	
}

class Integrity {
	
	private $_collector;
	
	public function __construct() {
		$this->_collector = new CodeCollector();
	}
	
	public function Calc() {
		$md5s = new ArrayList();
		$this->_collector->Collect();
		foreach($this->_collector->tables as $table) {
			$md5s->Add(md5($table));
		}

		foreach($this->_collector->files as $file) {
			$md5s->Add(md5_file($file));
		}
		
		return md5($md5s->ToString(""));
	}
	              
    public function createSchema() {
        
        
        
    }
    
}



?>