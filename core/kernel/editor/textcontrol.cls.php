<?php

class TextExControl extends Control {

	public $isPassword;
	
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $isPassword = false) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "textbox";
		if(is_empty($this->styles))
			$this->styles = "width: 100%";
		$this->isPassword = $isPassword;
	}
	
	public function Render() {
		if(!is_empty($this->values))
			return $this->RenderSelect();
		return '<input class="'.$this->class.'" style="'.$this->styles.'; " type="'.($this->isPassword ? 'password' : 'text').'" name="'.$this->name.'" value="'.hide_char($this->value, "\"").'" '.($this->disabled ? ' disabled="disabled"' : '').' '.$this->attributes.'>';
		// . ($this->showRequired && $this->required ? CONTROL_REQUIRED : '')
	}
	
	public function Validate() {
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) {  
			if(!is_string($this->value))
				$this->message = "Value of this field must be a string";
			if(strlen($this->value) > 255)
				$this->message = "Value of this field must be less than 255 characters";
			
			$this->isValid = is_string($this->value) && strlen($this->value) <= 255;
		}
		return $this->isValid;
	}
	
}


?>