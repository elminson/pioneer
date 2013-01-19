<?php

class StringTable extends Hashtable {
	
	public $selectedLanguage = "";
	
	public function __construct() {
		parent::__construct();
	}	
	
	public function AddLanguage($langId) {
		parent::Add($langId, new Hashtable());
	}	
	
	public function RemoveLanguage($langId) {
		parent::Delete($langId);
	}
	
	public function __get($nm) {
		if($this->selectedLanguage == ''){
			return @$this->Item($nm);
		}
		else {
			$l = $this->selectedLanguage;
			return @$this->Item($l)->$nm;
		}
	}
}

?>