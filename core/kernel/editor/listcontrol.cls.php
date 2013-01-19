<?php

class ListExControl extends Control {

	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->styles .= "width: 100%; height: 120px; overflow: auto; border: 1px solid #c0c0c0";
	}

	public function Render() {
		
		// $this->value array of values viewed values selected i.e. array($valuesselected, $valuesviewed)
		
		$valuesviewed = $this->value[0];
		$valuesselected = $this->value[1];
		
		$selectedvalues = "";
		foreach($valuesselected as $v) {
			if(is_object($v)) {
				$valueField = $this->args->valueField;
				$v = $v->$valueField;
			}
				
			$selectedvalues .= ",".$v;
		}
		$selectedvalues = substr($selectedvalues, 1);
		
		$ret = '
			<script>
				function '.$this->name.'_setCheck(obj, e) {
					
					var srcElement = null;
					if(window.browserType == "IE")
						srcElement = e.srcElement;
					else 
						srcElement = e.currentTarget;
					
					{
						if(srcElement.tagName != "INPUT")
							obj.childNodes[0].childNodes[0].checked = !obj.childNodes[0].childNodes[0].checked;

						obj.className = obj.childNodes[0].childNodes[0].checked ? "selected" : "normal";
					}
					
					var value = "";
					var i=1;
					var o = document.getElementById("id'.$this->name.'[0]");
					while(o != null) {
						value += o.checked ? o.value+"," : "";
						o = document.getElementById("id'.$this->name.'["+i+"]");
						i++;
					}
					value = value.substr(0, value.length-1);
					document.getElementById("id'.$this->name.'hidden").value = value;
				}
				</script>
				
				<div style="'.$this->styles.'">
				<input type="hidden" name="'.$this->name.'" value="'.$selectedvalues.'" id="id'.$this->name.'hidden" />
				<table width="100%">
		';
		
		$i = 0;
	
		foreach($valuesviewed as $value) {
			
			$title = $value;
			if(is_object($value)) {
				$titlefield = $this->args->titleField;
				$valuefield = $this->args->valueField;
				
				$title = $value->$titlefield;
				$value = $value->$valuefield;
			}

			$selected = ($valuesselected->IndexOf($value) !== false);
			$ret .= '<tr class="'.($selected ? 'selected' : 'normal').'" onclick="javascript: '.$this->name.'_setCheck(this, event)"><td width="20"><input type="checkbox" id="id'.$this->name.'['.$i.']" value="'.$value.'" '.($selected ? 'checked="checked"' : '').'></td><td>'.$title.'</td></tr>';
			$i++;
		}
		
		$ret .= '
				</table>
				</div>
		';
		$disstart = '';
		$disend = '';
		if($this->disabled) {
			$disstart = '<div disabled="disabled">';
			$disend = '</div>';
		}
		return $disstart.$ret.$disend;
	}	
	
}

?>