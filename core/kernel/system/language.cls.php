<?php

/**
	* class Language
	*
	* Description for class Language
	*
	* @author:
	*/
class Language  {

	private $lang;
	private $list;
	
	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	function Language() {
		$this->lang = array();
		
		$this->Load();
	}

	function Load() {
		global $core;
		$this->list = $core->dbe->ExecuteReader("select * from sys_languages")->ReadAll();
	}
	
	function __get($nm) {
		if (array_key_exists($nm, $this->lang))
			return $this->lang[$nm];
	}

	function __set($nm, $value) {
		$this->lang[$nm] = $value;
	}
	
	function get_list() {
		return $this->list->dublicate();
	}
	
	function get_collection() {
		return new collection($this->lang);
	}


}

?>