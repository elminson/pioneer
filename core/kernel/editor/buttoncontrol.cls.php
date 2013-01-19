<?php

class ButtonExControl extends Control {

	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
	}
	
	public function Render() {
		return 
		'
			<input type="button" name="'.$this->name.'" value="'.$this->value.'" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.' />
		';
	}
	
}

?>