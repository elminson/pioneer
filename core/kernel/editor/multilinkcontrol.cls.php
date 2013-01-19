<?php

class MultilinkFieldExControl extends Control {

	public $blob_operations;

	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);

		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
		
	}
	
	function getBlobOperations($operation, $field, $storage, $data = null) {
		switch($operation) {
			case "select":
				$datas= "";
				if(!is_null($data))
					$datas = $data->Values();
				return 'floating.php?postback_section=publications&postback_action=multilink&postback_command=select&handler='.$field.'_multilink_complete&storage_id='.$storage->table.'&data_ids='.$datas;
			case "add":
				return 'floating.php?postback_section=publications&postback_action=multilink&postback_command=add&handler='.$field.'_multilink_complete&storage_id='.$storage->table;
			case "edit":
				return 'floating.php?postback_section=publications&postback_action=multilink&postback_command=edit&handler='.$field.'_multilink_complete&storage_id='.$storage->table;
		}
	}
	
	public function Render() {
		global $core;
		$ret = "";
		
		$required = $this->required;
		$value = $this->value;
		
		if($this->args->type != "memo") {
			$ret .= "-- invalid multilink --";
		}
		else { 
			
			$s = storages::get($this->multilink);
			if(!is_null($s)) {
				
				if(!($value instanceof MultilinkField))
					$value = new MultilinkField($s, $value);

				$objHandler = $this->blob_operations["handlerObject"];
				$f = $this->blob_operations["function"];
				
	 			$selectUrl = $objHandler->$f("select", $this->name, $s, $value);
				$addUrl = $objHandler->$f("add", $this->name, $s);
				$editUrl = $objHandler->$f("edit", $this->name, $s);

				$ret .= '
				
					<script>
					
						function  '.$this->name.'_multilink_complete(operation, html, id) {
							var objectlist = document.getElementById("id'.$this->name.'viewtable");
							var obj = document.getElementById("'.$this->name.'");
							switch(operation) {
								case "add":
									var row = objectlist.insertRow(objectlist.rows.length);
									if(window.browserType == "IE")
										row.setAttribute("onclick", new Function("javascript: return setRowCheck(this);"));
									else
										row.setAttribute("onclick", "javascript: return setRowCheck(this);");
									row.setAttribute("id", "'.$this->name.'view_"+id+"row");
									var cell = row.insertCell(row.cells.length);
									cell.innerHTML = html;
									var cell = row.insertCell(row.cells.length);
									cell.innerHTML = "<input type=\"checkbox\" name=\"'.$this->name.'view_"+id+"\" value=\""+id+"\" hilitable=1>";
									
									var arr = new Array();
									if(obj.value != "")
										arr = obj.value.split(",");
									arr[arr.length] = id;
									obj.value = arr.join(",");
									
									break;
								case "edit":
									var row = document.getElementById("'.$this->name.'view_"+id+"row");
									row.cells[0].innerHTML = html;
									break;
								case "select":
									var arr = new Array();
									if(obj.value != "")
										arr = obj.value.split(",");
										
									for(var i=0; i<html.length; i++) {
										var h=html[i];
										var row = objectlist.insertRow(objectlist.rows.length);
										if(window.browserType == "IE")
											row.setAttribute("onclick", new Function("javascript: return setRowCheck(this);"));
										else
											row.setAttribute("onclick", "javascript: return setRowCheck(this);");
										row.setAttribute("id", "'.$this->name.'view_"+h[0]+"row");
										var cell = row.insertCell(row.cells.length);
										cell.innerHTML = h[1];
										var cell = row.insertCell(row.cells.length);
										cell.innerHTML = "<input type=\"checkbox\" name=\"'.$this->name.'view_"+h[0]+"\" value=\""+h[0]+"\" hilitable=1>";
									
										arr[arr.length] = h[0];
										
									}
									
									obj.value = arr.join(",");
									
									break;
							}
							
						
						}
						
						function  '.$this->name.'_addItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							src = "'.$addUrl.'";
							wnd = window.open(src, "", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
							wnd.opener = window;
						}
						
						function  '.$this->name.'_editItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							src = "'.$editUrl.'";
							var selectedItems = countSelectedChecks(hf);
							if(selectedItems.length > 1) {
								alert("'.@$this->args->texts['em_multipleedit'].'");
								return;
							}
							
							if(selectedItems.length == 0) {
								alert("'.@$this->args->texts['em_noselection'].'");
								return;
							}
							
							wnd = window.open(src+"&data_id="+selectedItems[0].value, "", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
							wnd.opener = window;
						}
						
						function  '.$this->name.'_deleteItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							var selectedItems = countSelectedChecks(hf);
							var obj = document.getElementById("'.$this->name.'");
							
							var arr = new Array();
							if(obj.value != "")
								arr = obj.value.split(",");

							for(var i=0; i<selectedItems.length;i++) {
								var j = -1;
								for(j=0; j<arr.length;j++) {
									if(arr[j] == selectedItems[i].value)
										break;
								}
								if(j >= 0)
									arr.splice(j, 1);
								
								hf.deleteRow(selectedItems[i].parentNode.parentNode.rowIndex);
							}
							obj.value = arr.join(",");
						}
						
						function  '.$this->name.'_selectItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							src = "'.$selectUrl.'";
							wnd = window.open(src, "", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
							wnd.opener = window;							
						}

						function  '.$this->name.'_upItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							var selectedItems = countSelectedChecks(hf);
							var obj = document.getElementById("'.$this->name.'");
							if(selectedItems.length > 1) {
								alert("'.@$this->args->texts['em_multipleedit'].'");
								return;
							}
							if(selectedItems.length == 0) {
								alert("'.@$this->args->texts['em_noselection'].'");
								return;
							}
							var arr = new Array();
							if(obj.value != "")
								arr = obj.value.split(",");
							var selected = selectedItems[0];
							var j = -1;
							for(j=0; j<arr.length;j++) {
								if(arr[j] == selected.value)
									break;
							}
							if(j >= 0) {
								val = arr[j];
								arr.splice(j, 1);
								arr.splice(j-1, 0, val);
							}
							
							obj.value = arr.join(",");
							var r = selected.parentNode.parentNode;
							var row = hf.insertRow(r.rowIndex-1);
							row.setAttribute("id", r.id);
							row.setAttribute("onclick", r.getAttribute("onclick"));
							var cell = row.insertCell(row.cells.length);
							cell.innerHTML = r.cells[0].innerHTML;
							var cell = row.insertCell(row.cells.length);
							cell.innerHTML = r.cells[1].innerHTML;
							
							hf.deleteRow(r.rowIndex);
							
							setRowCheck(row, true);
						}

						function  '.$this->name.'_downItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							var selectedItems = countSelectedChecks(hf);
							var obj = document.getElementById("'.$this->name.'");
							if(selectedItems.length > 1) {
								alert("'.@$this->args->texts['em_multipleedit'].'");
								return;
							}
							if(selectedItems.length == 0) {
								alert("'.@$this->args->texts['em_noselection'].'");
								return;
							}
							var arr = new Array();
							if(obj.value != "")
								arr = obj.value.split(",");
							var selected = selectedItems[0];
							var j = -1;
							for(j=0; j<arr.length;j++) {
								if(arr[j] == selected.value)
									break;
							}
							if(j >= 0 && j < arr.length) {
								val = arr[j];
								arr.splice(j, 1);
								arr.splice(j+1, 0, val);
							}
							obj.value = arr.join(",");
							var r = selected.parentNode.parentNode;
							if(r.rowIndex+1 < hf.rows.length) {
								var row = hf.insertRow(r.rowIndex+2);
								row.setAttribute("id", r.id);
								row.setAttribute("onclick", r.getAttribute("onclick"));
								var cell = row.insertCell(row.cells.length);
								cell.innerHTML = r.cells[0].innerHTML;
								var cell = row.insertCell(row.cells.length);
								cell.innerHTML = r.cells[1].innerHTML;
								hf.deleteRow(r.rowIndex);
								
								setRowCheck(row, true);
								
							}
							
						}
						
					</script>
					
					<table width="100%">
						<tr>
						<td>
							<a href="javascript: '.$this->name.'_addItem();"><img src="images/icons/op_add.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_editItem();"><img src="images/icons/op_edit.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_deleteItem();"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_selectItem();"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
							<img src="/admin/images/1x1.gif" width="15" height="10" />
							<a href="javascript: '.$this->name.'_upItem();"><img src="images/icons/op_moveup.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_downItem();"><img src="images/icons/op_movedown.gif" border="0" hspace="2"></a>
						</td>
						</tr>
						<tr>
						<td>
							<textarea name="'.$this->name.'" id="'.$this->name.'" style="display: none">'.$value->Values().'</textarea>
				';
				$ret .= RenderVerticalCheckboxes($this->name.'view', $value, "100%", "300px", $required);
				$ret .= '
						</td>
						</tr>
					</table>
				';

			}
			else {
				$ret .= "-- invalid multilink --";
			}
			
		}
		
		return $ret;
	}	
}

?>