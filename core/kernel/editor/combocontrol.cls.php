<?php

class ComboExControl extends Control {
    static $scriptsRendered;
    
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if($this->styles == "")
			$this->styles .= "width: 100%";
	}
    
    public function RenderScripts($script = "") {
        $script .= '
            <script language="javascript">
                function completeselect(obj, name) {
                    v = "";
                    for(var i=0; i<obj.options.length; i++){ 
                        if(obj.options[i].selected) { 
                            v = v + obj.options[i].value+","; 
                        } 
                    }
                    document.getElementById(name).value = v.substr(0, v.length-1);
                    return false;
                }
                
            </script>
        ';
        return parent::RenderScripts($script);
    }

	public function Render() {
		$valuesviewed = $this->value[0];
		$valuesselected = $this->value[1];
		$multiselect = @$this->args->multiselect; if(is_null($multiselect)) $multiselect = false;

		$ret = "";
		if($multiselect) {
            $ret .= $this->RenderScripts();
		    $ret .= '
			    <input type="hidden" name="'.$this->name.'" id="'.$this->name.'">
			    <select name="'.$this->name.'sel" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.' '.($multiselect ? ' size="10" multiple="yes" onchange="javascript: return completeselect(this, \''.$this->name.'\'); "' : '').'>
		    ';
		}
		else {
		    $ret .= '
			    <select name="'.$this->name.'" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.'>
		    ';
		}
		
		foreach($valuesviewed as $key => $v) {
			
			$title = $key;
			$value = $v;
			$padleft = "";
			$ss = "";
			if(is_object($value)) {
				$titlefield = $this->args->titleField;
				$valuefield = $this->args->valueField;
                $istree = $this->args->istree;
				
				$padleft = $this->args->padleftField;
				if(!is_empty($padleft)) {
					$val = $padleft ? $v->$padleft : 2;
                    $val = ($val - 1) < 0 ? 1 : $val;
					$padleft = str_repeat("&nbsp;", ($val-1) * $this->args->padleftMultiplier);
				}
				else {
					$padleft = "";
				}
				
				$title = $value->$titlefield;
				$value = $value->$valuefield;
				
				$ss = "";
				if($this->args->denyObject) {
					$b = false;
					$expression = "\$b = ".$this->args->denyExpression.";";
					eval($expression);
					if($b) {
						$ss = $this->args->denyStyle; 
					}
					
				}
				
			}
			
			$selected = ($valuesselected == $value);
			$ret .= '
					<option value="'.$value.'" '.($selected ? 'selected="selected"' : "").' style="'.$ss.'">'.$padleft.$title.'</option>
			';
		}
		
		$ret .= '
			</select>
		';
		return $ret;
	}	
	
}

?>