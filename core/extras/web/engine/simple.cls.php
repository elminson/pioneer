<?php
/**
	Describe the simple web controls
*/


class WebLiteralControl extends WebControl {
	
	public function __construct($name, $templateData) { 
		parent::__construct($name, $templateData);
	}	
	
	public function __get($prop) {
		switch($prop) {
			case "html":
			case "text":
			case "data":
			case "htmlText":
			case "xml":
			case "xmlText":
				return $this->_templateData;
			default:
				return parent::__get($prop);
		}
	}
	
	public function __set($prop, $value) {
		switch($prop) {
			case "html":
			case "text":
			case "data":
			case "htmlText":
			case "xml":
			case "xmlText":
				$this->_templateData = $value;
			default:
				return parent::__set($prop, $value);
		}
	}

	public function Render() {
		return $this->_templateData;
	}
	
}

class WebFormControl extends WebControl {
	
	public $action;
	public $method;
	
	public function __construct($name, $templateData) { 
		parent::__construct($name, $templateData);
	}	
	
	public function Render() {
		$content = '<form action="'.$this->action.'" method="'.$this->method.'">';
		$content .= parent::Render();
		$content .= '</form>';
		return $content;
	}
	
}

class WebTextBoxControl extends WebControl {
	
	public function __construct($name, $templateData) { 
		parent::__construct($name, $templateData);
	}	
	
	public function Render() {
		return '<input type="text" name="'.$this->_name.'" value="" />';
	}
	
}

class WebPasswordControl extends WebControl {
	
	public function __construct($name, $templateData) { 
		parent::__construct($name, $templateData);
	}	
	
	public function Render() {
		return '<input type="password" name="'.$this->_name.'" value="" />';
	}
	
}

class WebButtonControl extends WebControl {

	public $type;
	public $text;
	
	public function __construct($name, $templateData) { 
		parent::__construct($name, $templateData);
	}	
	
	public function Render() {
		return '<input type="'.$this->type.'" name="'.$this->_name.'" value="'.$this->text.'" />';
	}
	
}

?>