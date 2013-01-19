<?php

class CheckExControl extends Control {
	
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "select-box";
		if(is_empty($this->styles))
			$this->styles = "";
	}
	
	public function Render() {
		$ret = "";

		$checked = $this->value == 1 ? " checked" : "";
		
		if(!$this->required) {
			$ret .= '
					<select name="'.$this->name.'" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.'>
					';
			
			$isnull = is_null($this->value);
			if(!$this->required)
				$ret .= '
						<option value="" '.($isnull ? 'selected' : '').'>Not selected</option>
						';
			
			$selected = false;
			if(!is_null($this->value))
				$selected = $this->value == 1 ? true : false;
			
			$ret .= '
					<option value="1" '.($selected ? 'selected' : '').'>Checked</option>
					<option value="0" '.(!$selected ? 'selected' : '').'>Unckecked</option>
					';	
			$ret .= '
					</select>
					';
		}
		else {
			$ret .= '
                <input type="hidden" name="'.$this->name.'" value="'.$this->value.'" />
				<input type="checkbox" name="'.$this->name.'_check" '.$checked.' '.($this->disabled ? 'disabled="disabled"' : '').'  '.$this->attributes.' onclick="javascript: this.form.elements[\''.$this->name.'\'].value=this.checked ? 1 : 0;" />
			';
		}
		return $ret;	
	}
	
	public function Validate() {
		$value = $this->value;
		$this->isValid = ($value == 1 || $value == 0 || (is_null($value) && !$this->required));
		if(!$this->isValid)
			$this->message = "This field must contain a true or false value";
		return $this->isValid;
	}
	
}

?>