<?php

class MemoExControl extends Control {
	
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "textbox";
		if(is_empty($this->styles))
			$this->styles = "width: 100%; height: 120px;";
	}
    
    public function RenderScripts($script = "") {

        $script .= '
            <script language="javascript">
                // HTML Control scripts
                // <!--
                function evtMEMOProcessTab(e) {
                    if(!e)
                        e = window.event;

                    if(window.browserType == "IE") {
                        if(e.keyCode == 9) { 
                            var r = document.selection.createRange();
                            r.text = \'\t\'; 
                            r.collapse(false);
                            r.select();
                            return false;
                        }
                    }
                    else {
                        if(e.keyCode == 9) {
                            var obj = e.target;
                            start = obj.selectionStart;
                            obj.value = obj.value.substr(0,start)+\'\t\'+obj.value.substr(start);
                            obj.setSelectionRange(start+1, start+1);
                            obj.focus();
                            return false;
                        }
                    }
                }
                // -->
                // HTML Contol scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
    
	public function Render() {
        
		if(!is_empty($this->values))
			return $this->RenderSelect();
        $this->CheckValue();
		return 	$this->RenderScripts().'<textarea class="'.$this->class.'" style="'.$this->styles.'" name="'.$this->name.'" '.$this->attributes.' onkeydown="javascript: return evtMEMOProcessTab(event);">'.$this->value.'</textarea>'; 
	}
	
	public function Validate() {
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) { 
			if(!is_string($this->value))
				$this->message = "Value of this field must be a string";
			$this->isValid = is_string($this->value);
		}
		return $this->isValid;
	}
	
}

?>