<?php

class BlobExControl extends Control {
	
    static $scriptsRendered;
    
	public $blob_operations;
	
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $blob_operations = null) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = $blob_operations;
		
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
	}
	
	function getBlobOperations($operation, $prefix, $field) {
		switch($operation) {
			case "add":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle=Blob_complete';
				break;
			case "edit":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle=Blob_complete&edit=';
				break;
			case "select":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler=Blob_complete';
				break;
		}
	}

    public function RenderScripts($script = "") {

        $objHandler = $this->blob_operations["handlerObject"];
        $f = $this->blob_operations["function"];
        
        $addUrl = $objHandler->$f("add", "", $this->name);
        $editUrl = $objHandler->$f("edit", "", $this->name);
        $selectUrl = $objHandler->$f("select", "", $this->name);
        
        $script = '
            <script language="javascript">
                // Blob contol scripts
                // <!--
                function Blob_complete(name, window, blobid, alt, img) {
                    var hf = document.getElementById(name);
                    var container = document.getElementById("blob"+name);
                    container.innerHTML = "<img src=\'"+img+"\' alt=\'"+alt+"\' >";    
                    hf.value = blobid;
                }
                
                function addBlob(name) {
                    src = "'.$addUrl.'&field="+name;
                    wnd = window.open(src, "addblob", "status=0,help=0,resizable=0,scrollbars=0, width=420,height=280");
                    wnd.opener = window;
                }
                
                function editBlob(name) {
                    var hf = document.getElementById(name);
                    src = "'.$editUrl.'"+hf.value+"&field="+name;
                    wnd = window.open(src, "editblob", "status=0,help=0,resizable=0,scrollbars=0, width=480,height=280");
                    wnd.opener = window;
                }
                
                function selectBlob(name) {
                    var hf = document.getElementById(name);
                    src = "'.$selectUrl.'&field="+name;
                    wnd = window.open(src, "addblob", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }
                
                function deleteBlob(name) {
                    if(window.confirm("Are you sure to deselect blob?")) {
                        var hf = document.getElementById(name);
                        var container = document.getElementById("blob"+name);
                        container.innerHTML = "not selected";
                        hf.value = 0;
                    }
                }
                // -->
                // Blob contol scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
    
	public function Render() {
		
		global $core;
		$ret = "";
		$value = $this->value;
		
		
		if(!is_object($value))
			$value = new blob(intval($value));
		
		
		$ret .= $this->RenderScripts();
		
		$ret .= '<input type="hidden" name="'.$this->name.'" id="'.$this->name.'" value="'.($value->id).'">';
		
		$ret .= '
				<table>
					<tr>
						<td>
							<a href="javascript: addBlob(\''.$this->name.'\');"><img src="images/icons/op_add.gif" border="0" hspace="2"></a>
							<a href="javascript: deleteBlob(\''.$this->name.'\');"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
							<a href="javascript: editBlob(\''.$this->name.'\');"><img src="images/icons/op_edit.gif" border="0" hspace="2"></a>
							<a href="javascript: selectBlob(\''.$this->name.'\');"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
						</td>
					</tr>
					<tr>
						<td colspan="4" valign="middle" id="blob'.$this->name.'"  class="blob_value">
				';
		$ret .= $value->img(new Size(100, 100));
		$ret .= '
						</td>
					</tr>
				</table>
				';
		
		$disstart = '';
		$disend = '';
		if($this->disabled) {
			$disstart = '<div disabled="disabled">';
			$disend = '</div>';
		}
				
		return $disstart.$ret.$disend;		
		
		
	}
	
	public function Validate() {
	
		if($this->value instanceof Blob)
			$b = $this->value;
		else
			$b = new Blob((int)$this->value);
			
		if($this->required && is_null($b->id)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else {
			if(!is_null($b->id) && !$b->isValid)
				$this->message = "The selected blob does not exists.";
			$this->isValid = !(!is_null($b->id) && !$b->isValid);
		}
		return $this->isValid;
	}	
	
}

?>