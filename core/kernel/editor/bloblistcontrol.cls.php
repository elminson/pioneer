<?php

class BloblistExControl extends Control {

    static $scriptsRendered;
    
	public $blob_operations;

	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);

		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
		
	}
	
	function getBlobOperations($operation, $prefix, $field) {
		switch($operation) {
			case "add":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle=bloblist_complete&return=html';
				break;
			case "edit":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=edit&return=html&handle=bloblist_complete';
				break;
			case "select":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler=bloblist_complete&multiselect=true';
				break;
		}
	}
    
    public function RenderScripts($script = "") {
    
        $objHandler = $this->blob_operations["handlerObject"];
        $f = $this->blob_operations["function"];
        
        $addUrl = $objHandler->$f("add", "", $this->name);
        $editUrl = $objHandler->$f("edit", "", $this->name);
        $selectUrl = $objHandler->$f("select", "", $this->name);

        $script .= '
            <script language="javascript">
                // Blob list scripts
                // <!--
                                  
                
                function  bloblist_complete(name, operation, html, id) {
                
                    var objectlist = document.getElementById("id"+name+"viewtable");
                    var obj = document.getElementById(name);
                    switch(operation) {
                        case "add":
                        
                            var row = objectlist.insertRow(objectlist.rows.length);
                            if(window.browserType == "IE")
                                row.setAttribute("onclick", new Function("javascript: return setRowCheck(this);"));
                            else
                                row.setAttribute("onclick", "javascript: return setRowCheck(this);");
                            row.setAttribute("id", name+"view_"+id+"row");
                            var cell = row.insertCell(row.cells.length);
                            cell.innerHTML = html;
                            var cell = row.insertCell(row.cells.length);
                            cell.innerHTML = "<input type=\"checkbox\" name=\""+name+"view_"+id+"\" value=\""+id+"\" hilitable=1>";
                            
                            var arr = new Array();
                            if(obj.value != "")
                                arr = obj.value.split(",");
                            arr[arr.length] = id;
                            obj.value = arr.join(",");
                            
                            break;
                        case "edit":
                            var row = document.getElementById(name+"view_"+id+"row");
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
                                row.setAttribute("id", name+"view_"+h[0]+"row");
                                var cell = row.insertCell(row.cells.length);
                                cell.innerHTML = h[1];
                                var cell = row.insertCell(row.cells.length);
                                cell.innerHTML = "<input type=\"checkbox\" name=\""+name+"view_"+h[0]+"\" value=\""+h[0]+"\" hilitable=1>";
                                arr[arr.length] = h[0];
                            }
                            obj.value = arr.join(",");
                            break;
                    }
                    
                
                }
                
                function  addItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    src = "'.$addUrl.'&field="+name;
                    wnd = window.open(src, "additem", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }
                
                function  editItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    src = "'.$editUrl.'&field="+name;
                    var selectedItems = countSelectedChecks(hf);
                    if(selectedItems.length > 1) {
                        alert("'.@$this->args->texts['em_multipleedit'].'");
                        return;
                    }
                    
                    if(selectedItems.length == 0) {
                        alert("'.@$this->args->texts['em_noselection'].'");
                        return;
                    }
                    
                    wnd = window.open(src+"&edit="+selectedItems[0].value, "edititem", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }
                
                function  deleteItem(name) {
                
                    if(window.confirm("Are you sure to remove blob from list?")) {

                        var hf = document.getElementById("id"+name+"viewtable");
                        var selectedItems = countSelectedChecks(hf);
                        var obj = document.getElementById(name);
                    
                        var arr = new Array();
                        if(obj.value != "")
                            arr = obj.value.split(",");

                        for(var i=0; i<selectedItems.length;i++) {
                            var j = -1;
                            var r = selectedItems[i].parentNode.parentNode;
                            arr.splice(r.rowIndex, 1);
                            hf.deleteRow(r.rowIndex);
                        }
                        
                        obj.value = arr.join(",");
                    
                    }
                }
                
                function  selectItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    src = "'.$selectUrl.'&field="+name;
                    wnd = window.open(src, "selectitem", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }

                function  upItem(name) {
                
                    var hf = document.getElementById("id"+name+"viewtable");
                    var selectedItems = countSelectedChecks(hf);
                    var obj = document.getElementById(name);
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
                    var r = selected.parentNode.parentNode;
                    j = r.rowIndex;
                    if(j >= 0) {
                        val = arr[j];
                        arr.splice(j, 1);
                        arr.splice(j-1, 0, val);
                    }
                    
                    obj.value = arr.join(",");
                    
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

                function  downItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    var selectedItems = countSelectedChecks(hf);
                    var obj = document.getElementById(name);
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
                    var r = selected.parentNode.parentNode;
                    var j = r.rowIndex;
                    
                    /*for(j=0; j<arr.length;j++) {
                        if(j == selected.getAttribute("index"))
                            break;
                    }*/
                    if(j >= 0 && j < arr.length) {
                        val = arr[j];
                        arr.splice(j, 1);
                        arr.splice(j+1, 0, val);
                    }
                    obj.value = arr.join(",");
                    
                    
                    //var r = selected.parentNode.parentNode;
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
                // -->
                // Blob list scripts
            </script>
        ';

        
        
        return parent::RenderScripts($script);
    } 
	
	public function Render() {
		global $core;
		$ret = "";
		
		$required = $this->required;
		$value = $this->value;
		
		
		if(!($value instanceof BlobList))
			$value = new BlobList($value);

        $ret .= $this->RenderScripts();
        $ret .= '
			
			<table width="100%">
				<tr>
				<td>
					<a href="javascript: addItem(\''.$this->name.'\');"><img src="images/icons/op_add.gif" border="0" hspace="2"></a>
					<a href="javascript: editItem(\''.$this->name.'\');"><img src="images/icons/op_edit.gif" border="0" hspace="2"></a>
					<a href="javascript: deleteItem(\''.$this->name.'\');"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
					<a href="javascript: selectItem(\''.$this->name.'\');"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
					<img src="/admin/images/1x1.gif" width="15" height="10" />
					<a href="javascript: upItem(\''.$this->name.'\');"><img src="images/icons/op_moveup.gif" border="0" hspace="2"></a>
					<a href="javascript: downItem(\''.$this->name.'\');"><img src="images/icons/op_movedown.gif" border="0" hspace="2"></a>
				</td>
				</tr>
				<tr>
				<td>
					<textarea name="'.$this->name.'" id="'.$this->name.'" style="display: none">'.$value->ToString().'</textarea>
		';
		$ret .= RenderVerticalCheckboxes($this->name.'view', $value, "100%", "300px", $required);
		$ret .= '
				</td>
				</tr>
			</table>
		';

		
		return $ret;
	}	
}

?>