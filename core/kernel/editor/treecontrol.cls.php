<?php

class TreeExControl extends Control {

	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		
		preg_match('/width:(.*);?/', $this->styles, $matches);
		$width = "";
		if(count($matches) == 0)
			$width = "width:100%;";
		preg_match('/height:(.*);?/', $this->styles, $matches);
		$height = "";
		if(count($matches) == 0)
			$height = "height:240px;";

		$this->styles .= $width.$height."overflow: auto; border: 1px solid #c0c0c0";
		
		if(is_null($this->args->notselected))
			$this->args->notselected = "";
		if(is_null($this->args->checked))
			$this->args->checked = "+";
		if(is_null($this->args->unchecked))
			$this->args->unchecked = "-";
			
		if(is_null($this->args->joinnames))
			$this->args->joinnames = true;
		
		if(is_null($this->args->parseselected))
			$this->args->parseselected = true;
	}

	private function RenderLevel($nodes, $selected, &$i, $l) {
		$ret = '
            <style>
                .treecontrol tr td {
                    border-bottom: 1px dashed #f2f2f2;
                }
            </style>
			<table width="100%" class="treecontrol">
		';
		$cf = $this->args->checkField;
		$vf = $this->args->valueField;
		foreach($nodes as $key => $node) {
			$tt = "";
			if(is_object($node))
				$tt	= ".*";
			
			if($this->args->joinnames)	
				$vv = $l.".".$key.$tt;
			else
				$vv = $key.$tt;
				
			$s = -1;
			$rr = $selected->Search($cf, $vv);
			if(!is_null($rr)) {
				$s = intval($rr->$vf);
			}
							
			$ret .= '
					<tr>
					<td width="40">
						<input type="hidden" value="'.$l.".".$key.$tt.'" id="id_operation_'.$this->name.'['.$i.']" up="0" />
						<select id="id_permission_'.$this->name.'['.$i.']" onchange="javascript: '.$this->name.'setAllowDeny();">
							<option value="">'.$this->args->notselected.'</option>
							<option value="1" '.($s === 1 ? 'selected="selected"' : '').'>'.$this->args->checked.'</option>
							<option value="0" '.($s === 0 ? 'selected="selected"' : '').'>'.$this->args->unchecked.'</option>
						</select>
					</td>
					<td class="selected">
						'.$key.'
					</td>
					</tr>				 
			';
			$i++;
			if(is_object($node))
				$ret .= '	
					<tr>
						<td width="40">
						</td>
						<td>
						'.$this->RenderLevel($node, $selected, $i, $l.".".$key).'
						</td>
					</tr>			 
				';
			
			
		}
		
		$ret .= '
				</table>		
		';
		return $ret;
	}

	public function Render() {
		
		// value is a array of 
		//		tree
		//		selected
		
		$tree = $this->value[0];
		$selected = $this->value[1];
		
		$selectedvalues = "";
		foreach($selected as $v) {
			$selectedvalues .= ",".$v->operation.":".$v->permission;
		}
		$selectedvalues = substr($selectedvalues, 1);
		
		$ret = '
			<script>
				function '.$this->name.'setAllowDeny() {
					
					var value = "";
					var i=1;
					var o = document.getElementById("id_operation_'.$this->name.'[0]");
					var v = document.getElementById("id_permission_'.$this->name.'[0]");
					while(o != null) {
						if(o.getAttribute("up") == 1)
							value += v.selectedIndex == 0 ? o.value+":1," : "";
						else {
							if(v.selectedIndex > 0)
								value += o.value+":"+(v.selectedIndex == 1 ? 1 : 0)+",";
						}
						o = document.getElementById("id_operation_'.$this->name.'["+i+"]");
						v = document.getElementById("id_permission_'.$this->name.'["+i+"]");
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
		$cf = $this->args->checkField;
		$vf = $this->args->valueField;
		foreach($tree as $key => $node) {

			$tt = "";
			if(is_object($node))
				$tt	= ".*";
			
			$vv = $key.$tt;
			$rr = $selected->Search($cf, $vv);
			$s=0;
			if(!is_null($rr)) {
				$s = intval($rr->$vf);
			}

			$ret .= '
					<tr>
					<td width="40">
						<input type="hidden" value="'.$key.$tt.'" id="id_operation_'.$this->name.'['.$i.']" up="1" />
						<select id="id_permission_'.$this->name.'['.$i.']" onchange="javascript: '.$this->name.'setAllowDeny(\'id_operation_'.$this->name.'['.$i.']\');">
							<option value="1" '.($s === 1 ? 'selected="selected"' : '').'>'.$this->args->checked.'</option>
							<option value="0" '.($s === 0 ? 'selected="selected"' : '').'>'.$this->args->unchecked.'</option>
						</select>
					</td>
					<td>
						'.$key.'
					</td>
					</tr>
			';
			$i++;
			if(is_object($node))
				$ret .= '	
					<tr>
						<td width="40">
						</td>
						<td>
							'.$this->RenderLevel($node, $selected, $i, $key).'
						</td>
					</tr>			 
				';
			
			
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