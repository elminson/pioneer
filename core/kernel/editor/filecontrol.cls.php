<?php

class FileExControl extends Control {
	
	public $blob_operations;
	
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $blob_operations = null) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = $blob_operations;
		
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
		
		$this->RegisterEvent("fileexcontrol.validate");
	}
	
	function getBlobOperations($operation, $prefix, $field) {
		switch($operation) {
			case "select":
				return 'floating.php?postback_section=publications&postback_action=files&postback_command=select&handler='.$field.'_selectFile_complete';
				break;
		}
	}

	public function Render() {
		
		global $core;
		$ret = "";
		
		$value = $this->value;
		if($value instanceof FileView)
			$value = $value->Src().":".$value->alt;

		$objHandler = $this->blob_operations["handlerObject"];
		$f = $this->blob_operations["function"];
		
		$selectUrl = $objHandler->$f("select", $this->args->editor, $this->name);
			
		$ret .= '
		
			<script>
				function '.$this->name.'_selectFile_complete(window, id, alt, img, filename, type_id, category, w, h, href, handler, hname) {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(href.join) {
						for(var i=0; i<href.length; i++) {
							h = href[i];
							hf.value=h;
						}
					}
					else {
						hf.value = href;
					}
				}
				
				function '.$this->name.'_deleteFile() {
					var hf = document.getElementById("'.$this->name.'");
					hf.value = "";
				}

				function '.$this->name.'_selectFile() {
					var hf = document.getElementById("'.$this->name.'");
					src = "'.$selectUrl.'";
					wnd = window.open(src, "selectfile", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
					wnd.opener = window;
				}

				function '.$this->name.'_descriptFile() {
					var hf = document.getElementById("'.$this->name.'");
					var selval = "";
					var v = hf.value.split(":");
					if(v.length > 1) { selval = v[0]; v = v[1]; } else { selval = v; v = ""; }
					var ret = window.prompt("Input description of the file please", v);
					if(ret != undefined) {
						if(ret == "")						
							hf.value = selval;
						else
							hf.value = selval+":"+ret;
					}
				}
				
			</script>
		
		';
		
		$valuess = explode(";", str_replace_ex($value, "\n\r", ""));
		$values = '';
		foreach($valuess as $v) {
			if(strlen(trim($v)) > 0) {
				$vv = explode(':', $v);
				if(count($vv) > 1) {
					$v = $vv[0];
					$v1 = ":".$vv[1];
				}
				else {
					$v = $v;
					$v1 = "";
				}
				
				$values .= '<option value="'.$v.'">'.$v.$v1.'</option>';
			}
		}
		
		
		$ret .= '
			<table width="100%">
				<tr>
					<td>
						<a href="javascript: '.$this->name.'_descriptFile();"><img src="images/icons/op_import.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_deleteFile();"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_selectFile();"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" readonly="readonly" name="'.$this->name.'" id="'.$this->name.'" value="'.$value.'" style="width: 100%;">
					</td>
				</tr>
			</table>
		';		
		
		return $ret;
		
	}
	
	public function Validate() {
		global $core;
		$this->isValid = true;
		$errofile = "";
		
		$file = $this->value;
		
		$args = $this->DispatchEvent("fileexcontrol.validate", collection::create("data", $file));
		if (@$args->cancel === true)
			return;
		else if (!is_empty(@$args->data))
			$file = $args->data;
		
		if(trim($file) != "" && trim($file) != ":") {
			$filev = explode(":", $file);
			if(!$core->fs->fileexists($filev[0])) {
				$this->isValid = false;
				$errofile = $file;
			}
		}

		if(!$this->isValid)
			$this->message = "Invalid file: path=".$errofile;
		
		return $this->isValid;
	}
	
}


?>