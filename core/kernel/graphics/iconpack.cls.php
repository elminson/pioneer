<?php

/**
	* class IconPack
	*
	* Description for class IconPack
	*
	* @author:
	*/
class IconPack extends collection  {

	public $iconpack_path;
	public $iconpack_url;
	public $name;

	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	function IconPack($name = null, $pack_path = null) {
		parent::__construct();
		$this->init($name, $pack_path);
	}
    
    private function _getIconLocation($name = null, $pack_path = null) {
        global $core;
        
        if(is_empty($name)) $name = "default";
        if(is_empty($pack_path)) $pack_path = "/images/icons";
        
        $realpath = $core->fs->mappath("/images/icons", ADMIN);
        if($core->fs->DirExists($realpath."/".$name, ADMIN)) {
            $this->iconpack_path = $realpath."/".$name;
            $this->iconpack_url = "/admin/images/icons/".$name;
        }
        else {
            $realpath = $core->fs->mappath("/resources/icons", SITE);
            if($core->fs->DirExists($realpath."/".$name, SITE)) {
                $this->iconpack_path = $realpath."/".$name;
                $this->iconpack_url = "/resources/icons/".$name;
            }
            else {
                $realpath = $core->fs->mappath("/utils/images/", CORE);
                if($core->fs->DirExists($realpath."/".$name, CORE)) {
                    $this->iconpack_path = $realpath."/".$name;
                    $this->iconpack_url = "/core/utils/images/".$name;
                }
            }
        }
        // out( $this->iconpack_path, $this->iconpack_url);
    }
	
	private function init($name = null, $pack_path = null){
		global $core;
		
		$this->_getIconLocation($name, $pack_path);
                                                                      
		$icons = @file_get_contents($this->iconpack_path."/icons.conf");
		if($icons) {
			$iconrows = explode("\n", $icons);
			foreach($iconrows as $icon) {
				if(trim($icon) != "") {
					list($name, $file) = explode("=", $icon);
					$this->add($name, $this->iconpack_url."/".$file);
				}
			}
		}
	}
	
	public function Save() {
		
		$content = "";
		foreach($this as $icon => $c) {
			$content .= $icon."=".(substr($c, strlen($this->iconpack_url."/")))."\n";
		}
		
		touch($this->iconpack_path."/icons.conf");
		$icons = file_put_contents($this->iconpack_path."/icons.conf", $content);
	}
	
	public function IconFromPack($str) {
		if(substr($str, 0, strlen("iconpack(")) == "iconpack(" ) {
			$str = substr($str, strlen("iconpack("));
			$str = trim(substr($str, 0, strlen($str) - 1), "\n");
			$str = trim($str, "\r");
			$str = $this->$str;
			$str = trim($str, "\r");
			$str = trim($str, "\n");
			return $str;
			
		}
		return $str;
	}
	
	function CreateToggleButton($imageCollapse, $imageExpand, $texts, $width, $height, $objectIds, $initialState = "collapsed", $name = null) {

		if(is_null($name))
			$name = "id".str_random(10);
      
		$ret  = '<img class="toggle-button" state="'.$initialState.'" id="'.$name.'" src="'.($initialState != "collapsed" ? $this->IconFromPack($imageCollapse) : $this->IconFromPack($imageExpand)).'" alt="'.($initialState == "collapsed" ? $texts[0] : $texts[1]).'" width="'.$width.'" height="'.$height.'" onclick="javascript: toggle_'.$name.'(this)" />';
		$collapseCmd = '';
		$expandCmd = '';
		if($objectIds != "rows") {
			if(is_array($objectIds)) {
				foreach($objectIds as $id) {
					$collapseCmd .= 'document.getElementById("'.$id.'").style.display = "none";'."\n";
					$expandCmd .= 'document.getElementById("'.$id.'").style.display = "";'."\n";
				}
			}
			else {
				$collapseCmd .= 'document.getElementById("'.$objectIds.'").style.display = "none";'."\n";
				$expandCmd .= 'document.getElementById("'.$objectIds.'").style.display = "";'."\n";
			}
		}		
		$scripts = '
			
			<script language="javascript">
				if("'.$initialState.'" == "collapsed") {
					'.($objectIds != 'rows' ? '
					'.$collapseCmd.'
					' : '
					window.setTimeout("togglerows_'.$name.'(document.getElementById(\"'.$name.'\").parentNode.parentNode.parentNode.parentNode, 1, document.getElementById(\"'.$name.'\").parentNode.parentNode.parentNode.parentNode.rows.length-1, \"collapse\")", 100);
					').
					'
				}
				function toggle_'.$name.'(img) {
					var command = img.getAttribute("state") == "collapsed" ? "expand" : "collapse";
					if(command == "collapse") {
						img.setAttribute("state", "collapsed");
						img.src = "'.$this->IconFromPack($imageExpand).'";
						img.alt = "'.$texts[1].'";
						'.($objectIds != 'rows' ? '
						'.$collapseCmd.'
						' : '
						var table = img.parentNode.parentNode.parentNode;
						togglerows_'.$name.'(table, 1, table.rows.length-1, "collapse");
						').
						'
					}
					else if(command == "expand") {
						img.setAttribute("state", "expanded");
						img.src = "'.$this->IconFromPack($imageCollapse).'";
						img.alt = "'.$texts[0].'";
						'.($objectIds != 'rows' ? '
						'.$expandCmd.'
						' : '
						var table = img.parentNode.parentNode.parentNode;
						togglerows_'.$name.'(table, 1, table.rows.length-1, "expand");
						').
						'
					}
				}
				
				function togglerows_'.$name.'(table, start, end, command) {
					for(var i=start; i<=end; i++) {
						table.rows[i].style.display = command == "collapse" ? "none" : "";
					}
				}
			</script>
			
		';
		return $ret.$scripts;
	}
	
	function CreateIconImage($image, $text, $width, $height, $ad = "") {
		global $core;
		$image = $this->IconFromPack($image);
		switch($core->browserInfo->name) {
			case "ie":
				if($core->browserInfo->version > 6)
					$img = '<img src="'.$image.'" width="'.$width.'" height="'.$height.'" border="0" alt="'.$text.'" '.$ad.' />';	
				else
					$img = '<img src="images/new/spacer1x1.gif" width="'.$width.'" height="'.$height.'" style="background-image: url('.$image.')" class="png" border="0" alt="'.$text.'" '.$ad.' />';		
				break;
			case "moz":
			default:
				$img = '<img src="'.$image.'" width="'.$width.'" height="'.$height.'" border="0" alt="'.$text.'" '.$ad.' />';	
				break;
			
		}
		return $img;
	}
	
	public function ToXML(){
		global $core;
		
		$ret = "<iconpack>";
		$ret .= "<name>".$this->name."</name>";
		$ret .= "<icons>";
		foreach ($this as $k => $v){
			$v = substr($v, 6);
			$path = $core->fs->mappath($v, ADMIN);
			if (!$core->fs->fileexists($path))
				continue;
			
			$ret .= "<icon>";
			$ret .= "<name>".$k."</name>";
			$ret .= "<filename>".basename($v)."</filename>";
			$ret .= "<data><![CDATA[".bin2hex($core->fs->readfile($v, ADMIN))."]]></data>";
			$ret .= "</icon>";
		}
		$ret .= "</icons>";
		$ret .= "</iconpack>";
		
		return $ret;
	}
	
	public function FromXML($el){
		global $core;
		
		$iconpack = $el;
		$this->init($iconpack->childNodes->item(0)->nodeValue);
		
		if (!$core->fs->direxists($this->iconpack_path))
			$core->fs->createdir($this->iconpack_path);
		
		global $ADMIN_PATH;
		
		$childs = $iconpack->childNodes->item(1)->childNodes;
		foreach ($childs as $pair){
			switch ($pair->nodeName){
				case "icon" :
					$name = $pair->childNodes->item(0)->nodeValue;
					$filename = $pair->childNodes->item(1)->nodeValue;
					$this->Add($name, $this->iconpack_url."/".$filename);
					
					if ($core->fs->fileexists($this->iconpack_path."/".$filename, ADMIN))
						break;
					
					$data = hex2bin($pair->childNodes->item(2)->nodeValue);
					$core->fs->writefile($this->iconpack_path."/".$filename, $data, ADMIN);
					
					break;
				default :
			}
		}
		
		$this->save();
	}
	
	
}

?>
