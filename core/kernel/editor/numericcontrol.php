<?php

class NumericExControl extends Control {
	
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value == (int)$value ? (int)$value : $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "textbox";
		if(is_empty($this->styles))
			$this->styles = "width: 200px; text-align: right";
	}
	
	public function Render() {
		if(!is_empty($this->values))
			return $this->RenderSelect();
		return '<input class="'.$this->class.'" style="'.$this->styles.';" type="text" name="'.$this->name.'" value="'.$this->value.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.'>';
	}
	
	public function Validate() {
		if($this->required && (is_empty($this->value) && $this->value != 0)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) { 
			if(!is_numeric($this->value))
				$this->message = "This field must contain a numeric value";
			$this->isValid = is_numeric($this->value);
		}
		return $this->isValid;
	}
	
}

?>