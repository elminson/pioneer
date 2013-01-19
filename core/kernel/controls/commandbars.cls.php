<?php

class CommandBarContainer {
	
	public $name;
	public $content;
	public $postback;
	
	public function __construct($name, $content = "") {
		$this->name = $name;
		$this->content = $content;
	}
	
	public function Render() {
		return '<td>'.$this->content.'</td>';
	}
	
}

class CommandBarPopupContainer extends CommandBarContainer {
	
	public function __construct($name, $title, $content = "", $size = null, $openUp = false, $openLeft = false) {
		parent::__construct($name);
		
		$popup = new Popup($name, $title, $content, $size, $openUp, $openLeft);
		$this->content = $popup->Render();
	}
	
}

class CommandBarFilterPopupContainer extends CommandBarContainer {
	
	public function __construct($name, $filter, $lang, $command, $openUp = false, $openLeft = false) {
		parent::__construct($name);
		
		$popup = new FilterPopup($name, $filter, $lang, $command, $openUp, $openLeft);
		$this->content = $popup->Render();
	}
	
}

class CommandBarSortPopupContainer extends CommandBarContainer {
	
	public $popup;
	
	public function __construct($name, $fld_name, $fld_order, $pagerargs, $lang, $storages, $postbackto, $openUp = false, $openLeft = false) {
		parent::__construct($name);
		
		$this->popup = new SortPopup($name, $fld_name, $fld_order, $pagerargs, $lang, $storages, $postbackto, $openUp, $openLeft);
		$this->content = $this->popup->Render();
	}
	
}

class CommandBarLabelContainer extends CommandBarContainer {
	
	public function __construct($name, $label) {
		parent::__construct($name, $label);
	}

}

class CommandBarButtonContainer extends CommandBarContainer {
	
	public function __construct($name, $type, $label, $command, $method = "post", $className = COMMANDBAR_BUTTON_LONG) {
		parent::__construct($name, $label);
		$this->content = "<input type=\"".$type."\" name=\"".$this->name."\" value=\"".$label."\" onclick=\"return PostBack('".$command."', 'post')\" class=\"".($className == COMMANDBAR_BUTTON_LONG ? "small-button-long" : "small-button")."\" />";
	}

}

class CommandBarJButtonContainer extends CommandBarContainer {
	
	public function __construct($name, $type, $label, $action = "", $className = COMMANDBAR_BUTTON_LONG) {
		parent::__construct($name, $label);
		$this->content = "<input type=\"".$type."\" name=\"".$this->name."\" value=\"".$label."\" onclick=\"".$action."\" class=\"".($className == COMMANDBAR_BUTTON_LONG ? "small-button-long" : "small-button")."\" />";
	}

}



class CommandBarStoragesListContainer extends CommandBarContainer {
	
	public $storages, $storage, $postbackto, $disabled;
	
 	public function __construct($name, $storages, $storage, $postbackto, $disabled = false) {
		$this->name = $name;
		$this->storages = $storages;
		$this->storage = $storage; 
		$this->postbackto = $postbackto;
		$this->disabled = $disabled;
	}
	
	public function Render() {
		
		$this->content = "<select name=".$this->name." id=".$this->name." class=select-box style='width:120px;' onchange=\"return PostBack('".$this->postbackto."', 'get')\" ".($this->disabled ? " disabled" : "").">";
		foreach($this->storages as $st)
			$this->content .= "<option value='".$st->id."' ".((!is_null($this->storage) ? $this->storage->id == $st->id ? "selected" : "" : "")).">".$st->name."</option>";
		$this->content .= "<option value='-1' ".(is_null($this->storage) ? "selected" : "").">".$this->postback->lang->modules_title."</option>";
		$this->content .= "</select>";
		
		return parent::Render();		
	}
	
	
}

class CommandBarListContainer extends CommandBarContainer {
    
    public $list, $selected, $postbackto, $disabled;
    
     public function __construct($name, $list, $selected, $postbackto, $disabled = false) {
        $this->name = $name;
        $this->list = $list;
        $this->selected = $selected;
        $this->postbackto = $postbackto;
        $this->disabled = $disabled;
    }
    
    public function Render() {
        
        $this->content = "<select name=".$this->name." id=".$this->name." class=select-box style='width:120px;' onchange=\"return PostBack('".$this->postbackto."', 'get')\" ".($this->disabled ? " disabled" : "").">";
        foreach($this->list as $item)
            $this->content .= "<option value='".$item['value']."' ".((!is_empty($this->selected) ? $this->selected == $item['value'] ? "selected" : "" : "")).">".$item['text']."</option>";
        
        $this->content .= "</select>";
        
        return parent::Render();        
    }
    
    
}


class CommandBarNodesTreeContainer extends CommandBarContainer {
	
 	public function __construct($name, $branch, $selectedFolder, $postbackto) {
		$this->name = $name;

		$this->content = '
				<select name="sf_id" class="select-box" style="width:200px" onchange="javascript: PostBack(\''.$postbackto.'\', \'get\', null, null, null, createArray(\'fld_name\', \'\', \'fld_order\', \'\'));">
			';

			foreach($branch as $folder) {
				$pad = intval($folder->level-1)*4;
				$selected = $folder->id == $selectedFolder->id ? ' selected' : '';
		$this->content .= '
					<option value="'.$folder->id.'" '.$selected.'>'.str_repeat("&nbsp;", $pad).$folder->description.'</option>
		';
			}
		$this->content .= '
				</select>
		';
	}
	
}

class CommandBarBlobsCategoriesContainer extends CommandBarContainer {
	
	public $onchange;
	public $categories;
	public $selectedCategory;
	
	public function __construct($name, $categories, $selectedCategory, $onchange = "this.form.submit();") {
		parent::__construct($name);
		$this->onchange = $onchange;
		$this->categories = $categories;
		$this->selectedCategory = $selectedCategory;
	}
	
	public function Render() {
		$this->content = '
						<select name="'.$this->name.'" onChange="'.$this->onchange.'">
							<option value="-1"></option>
		';
		$this->content .= $this->postback->RenderBlobCategoriesOptions($this->categories, $this->selectedCategory);
		$this->content .= '
						</select>
		';		
		
		return parent::Render();
	}
	
}

class CommandBarFileContainer extends CommandBarContainer {
	
	public $onchange;
	public $startPath;
	public $selectedPath;
	
	public function __construct($name, $startPath, $selectedPath, $onchange = "this.form.submit();") {
		parent::__construct($name);
		$this->onchange = $onchange;
		$this->startPath = $startPath;
		$this->selectedPath = $selectedPath;
	}
	
	public function Render() {
		$this->content = '
						<select name="'.$this->name.'" onChange="'.$this->onchange.'">
							<option value="">..</option>
		';
		$this->content .= $this->RenderDirectories();
		$this->content .= '
						</select>
		';		
		
		return parent::Render();
	}
	
	public function RenderDirectories($path = "", $level = 0) {
		global $core;
		$ret = '';
		$dirs = $core->fs->list_dir($this->startPath.$path);
		foreach($dirs as $dir) {
			$selected = $this->selectedPath == $this->startPath.$path.$dir.'/' ? ' selected="selected"' : '';
			$ret .= '<option value="'.$this->startPath.$path.$dir.'/" '.$selected.'>'.str_repeat("&nbsp;&nbsp;&nbsp;", $level).$dir.'</option>';
			$ret .= $this->RenderDirectories($path.$dir.'/', $level+1);
		}
		return $ret;
	}
	
}

class CommandBarBlobsSortContainer extends CommandBarContainer {
	
	public function __construct($name, $sort, $onchange = "this.form.submit();") {
		parent::__construct($name);
		
		$this->content = '
				<select name="sort" onChange="this.form.submit();">
					<option value="blobs_id" '.($sort == "blobs_id" ? "selected" : "").'>Id</option>
					<option value="blobs_filename" '.($sort == "blobs_filename" ? "selected" : "").'>Filename</option>
					<option value="blobs_length" '.($sort == "blobs_length" ? "selected" : "").'>Filesize</option>
					<option value="blobs_alt" '.($sort == "blobs_alt" ? "selected" : "").'>Alt</option>
				</select>
		';		
	}
	
}

class CommandBarTabContainer extends CommandBarContainer {

    public function __construct($name, $buttons) {
        parent::__construct($name);
        
        $this->content = '<div class="tab_container">';
        
        foreach($buttons as $value) {
            // $value = array("text", "onclick", "selected")
            $this->content .= '<input type="button" class="tab_button'.($value[2] ? ' selected' : '').'" onclick="'.$value[1].'" value="'.$value[0].'"'.($value[2] ? ' disabled="disabled"' : '').' />';
        }
        
        $this->content .= '</div>';
        
    }
    
}


class CommandBarContainerList extends Collection {
	
	private $postback;
	
	public function __construct($postback) {
		$this->postback = $postback;
		parent::__construct();
	}
	
	public function Add($container) {
		if($container instanceof CommandBarContainer) {
			$container->postback = $this->postback;
			parent::Add($container->name, $container);
		}
		else {
			die("Error creating commandbar");
		}
	}
	
	public function Delete($container) {
		if(is_string($container))
			parent::Delete($container);
		else if($container instanceof CommandBarContainer) {
			parent::Delete($container->name);
		}
	}
	
}

class CommandBar {
	
	private $_postback;
	private $_containers;
	
	public function __construct($postback) {
		$this->_postback = $postback;
		$this->_containers = new CommandBarContainerList($this->_postback);
	}
	
	public function __get($prop) {
		switch(strtolower($prop)) {
			case "containers":
				return $this->_containers;
			default:
				return null;
		}
	}
	
	public function Render($outto = null) {

		$args = $this->_postback->DispatchEvent("postbackform.createcommandbar", Hashtable::Create("containers", $this->_containers));
		if($args)
			if(@$args->containers)
				$this->_containers = $args->containers;

        $ret = '';
        if($this->_containers->Count() > 0) {
		    $ret .= '
			    <div class="commandbar-container"><table cellpadding=0 cellspacing=0 border=0 class="commandbar">
				    <tr>
		    ';
		    foreach($this->_containers as $container)
			    $ret .= $container->Render();
		    $ret .= '
				    </tr>
			    </table></div>
		    ';
        }
		
		if($outto)
			$this->_postback->Out($outto, $ret, OUT_AFTER);

		return $ret;
	}
	
}

?>