<?php

class WebPage extends WebControl {
	
	public function __construct($name, $templateData = null) {
		parent::__construct($name, $templateData);
		$this->DispatchEvent("webpage.create");
	}
	
	protected function PreCreateControls() {
		$this->DispatchEvent("webpage.controls.loading");
		$this->_templateData->Parse($this);
		$this->DispatchEvent("webpage.controls.loaded");
	}
}

?>