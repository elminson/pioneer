<?php

class FileListExControl extends Control {
	
	public $blob_operations;
	
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $blob_operations = null) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = $blob_operations;
		
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
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
		if($value instanceof FileList)
			$value = $value->ToString();

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
							var opt = document.createElement("OPTION");
							hf.value += h+";\n";
							opt.innerHTML=h; 
							opt.value=h;
							try{
								hfselector.options.add(opt);
							}
							catch(ex) {
								hfselector.appendChild(opt);
							}
						}
					}
					else {
						hf.value += href+";\n";
						var opt = document.createElement("OPTION");
						opt.innerHTML=href;
						opt.value=href;
						try{
							hfselector.options.add(opt);
						}
						catch(ex) {
							hfselector.appendChild(opt);
						}
					}
				}
				
				function '.$this->name.'_deleteFile() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					var selected = hfselector.selectedIndex;
					selected = hfselector.options[selected];
					hfselector.removeChild(selected);
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
					}
				}

				function '.$this->name.'_selectFile() {
					var hf = document.getElementById("'.$this->name.'");
					src = "'.$selectUrl.'";
					wnd = window.open(src, "selectfile", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
					wnd.opener = window;
				}

				function '.$this->name.'_descriptFile() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(hfselector.selectedIndex < 0)
						return;
					var selected = hfselector.selectedIndex;
					selected = hfselector.options[selected];
					var v = selected.innerHTML.split(":");
					if(v.length > 1) { v = v[1]; } else { v = ""; }
					var ret = window.prompt("Input description of the file please", v);
					if(ret != undefined) {
						if(ret == "")
							selected.innerHTML = selected.value;
						else
							selected.innerHTML = selected.value+":"+ret;
					}
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
					}
				}
				
				
				function  '.$this->name.'_upItem() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(hfselector.selectedIndex < 0)
						return;
					var selected = hfselector.selectedIndex;
					var arr = new Array();
					for(var i=0; i<hfselector.options.length; i++) {
						arr[arr.length] = hfselector.options[i];
					}
					var removed = arr.splice(selected, 1);
					arr.splice(selected-1, 0, removed[0]);
					hfselector.innerHTML = "";
					for(var i=0; i<arr.length; i++) {
                        try{
                            hfselector.options.add(arr[i]);
                        }
                        catch(ex) {
                            hfselector.appendChild(arr[i]);
                        }                        
					}
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
					}
				}

				function  '.$this->name.'_downItem() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(hfselector.selectedIndex < 0)
						return;
					var selected = hfselector.selectedIndex;
					var arr = new Array();
					for(var i=0; i<hfselector.options.length; i++) {
						arr[arr.length] = hfselector.options[i];
					}
					var removed = arr.splice(selected, 1);
					arr.splice(selected+1, 0, removed[0]);
					hfselector.innerHTML = "";
					for(var i=0; i<arr.length; i++) {
                        try{
                            hfselector.options.add(arr[i]);
                        }
                        catch(ex) {
                            hfselector.appendChild(arr[i]);
                        }                        
					}
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
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
					$v = trim($vv[0], "\n\r");
					$v1 = ":".$vv[1];
				}
				else {
					$v = trim($v, "\r\n");
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
						<img src="/admin/images/1x1.gif" width="15" height="10" />
						<a href="javascript: '.$this->name.'_upItem();"><img src="images/icons/op_moveup.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_downItem();"><img src="images/icons/op_movedown.gif" border="0" hspace="2"></a>
					</td>
				</tr>
				<tr>
					<td>
						<select name="'.$this->name.'selector" id="'.$this->name.'selector" size="5" style="width: 98%; height: 120px; font-size: 11px; font-family: courier new" ondblclick="javascript: '.$this->name.'_descriptFile();">
						'.$values.'
						</select>
						<textarea name="'.$this->name.'" id="'.$this->name.'" style="width: 98%; height: 70px; display: none" wrap="On">'.$value.'</textarea>
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
		
        if($this->value instanceof FileList)
            $this->value = $this->value->ToString();
		$files = explode(";", str_replace("\r", "", str_replace("\n", "", $this->value)));
		if(!is_array($files)) $files = array($this->value);
		foreach($files as $file) {
			if(trim($file) != "") {
				$filev = explode(":", $file);
				if(!$core->fs->fileexists($filev[0])) {
					$this->isValid = false;
					$errofile = $file;
					break;
				}
			}
		}
		if(!$this->isValid)
			$this->message = "Invalid file: path=".$errofile;
		
		return $this->isValid;
	}
		
}
?>