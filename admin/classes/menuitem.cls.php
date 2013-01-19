<?php

class StartMenu { 
    
    public $items;
    public $buttons;
    
    private $_postback_sections = array();
    
    public function __construct() {
        $this->items = array();
        $this->buttons = array();
        
        $this->_postback_sections = array(
            'development.structure' => "struct",
            'development.storages' => "struct",
            'tools.blobs' => "struct",
            'tools.notices' => "struct",
            'development.designtemplates' => "devs",
            'development.repository' => "devs",
            'tools.modules' => "devs", 
            'tools.usersex' =>  "instruments",
            'tools.settings' => "instruments",
            'tools.systemrestore' =>  "instruments",
            'tools.script' => "instruments",
            'tools.statistics' => "stats",
            'tools.sitestats' => "stats",
            'tools.access_log' => "stats",
            'tools.access_log' => "stats",
            'tools.error_log' => "stats", 
            'tools.error_log' => "stats",
            'modules.' => 'mods'
        );
    
    }
    
    public function RenderItems() {
        
        $left = '';
        $right = '';
        
        foreach($this->items as $item) {
            
            if($item->name == "sep") {
                $left .= '<div class="sep"><img src="images/v5/startmenu/1x1.gif" /></div>';
                continue;
            }
            
            $itml = '<div class="item" onmouseover="javascript: fl_up(event, this);" id="'.$item->name.'"><table cellpadding="0" cellspacing="0"><tr>';
            $itml .= '<td class="ic">'.$item->CreateIconImage($item->icon).'</td>';
            $itml .= '<td>';
            $itml .= $item->title;
            $itml .= '</td>';
            $itml .= '<td class="ar"><img src="images/v5/startmenu/arrow.png" /></td>';
            $itml .= '</tr></table></div>';
            
            $left .= $itml;
            
            if(count($item->children) > 0) {
                
                $itmr = '<div class="itemr" style="display: none" id="'.$item->name.'_childs"><div class="it"><span>'.$item->title.'</span></div><div class="ic">';
                
                foreach($item->children as $child) {
                    if($child->name == "sep") {
                        $itmr .= '<div class="sep"><img src="images/v5/startmenu/1x1.gif" /></div>';
                        continue;
                    }
                    
                    $itmr .= '<table cellpadding="0" cellspacing="0"><tr>';
                    $itmr .= '<td class="icn">'.(!is_null($child->icon) ? $child->CreateIconImage($child->icon) : '').'</td>';
                    $itmr .= '<td>';
                    $itmr .= '<a href="'.$child->link.'" '.($child->link_target != null ? 'target="'.$child->link_target.'"' : "").'>';
                    $itmr .= $child->title;
                    $itmr .= '</a>';
                    $itmr .= '<span>'.$child->description.'</span>';
                    $itmr .= '</td></tr></table>';
                   
                }
                
                $itmr .= '</div></div>';
                $right .= $itmr;
            }
            
            
            
        }
        
        return array($left, $right);
    }
    
    function RenderButtons() {
        $ret = '';
            
        foreach($this->buttons as $button) {
            $ret .= '<div class="btn"><table cellpadding="0" cellspacing="0" class="bt"><tr><td class="bl">&nbsp;</td><td class="bm"><table><tr>';
            $ret .= '<td>'.$button->icon.'</td>';
            $ret .= '<td><a href="'.$button->link.'">'.$button->title.'</a></td>';
            $ret .= '</tr></table></td><td class="br"></td></tr></table></div>';
        }
            
        return $ret;
    }
    
    public function Render() {
        
        $ret = '';
        
        $items = $this->RenderItems();
        $left = $items[0];
        $right = $items[1];
        
        $buttons = $this->RenderButtons();
        
        $ret .= '
            <style type="text/css">
                @import url("images/v5/startmenu/styles.css");
            </style>
            <script type="text/javascript" src="images/v5/startmenu/scripts.js"></script>
            <table class="startmenu" cellpadding="0" cellspacing="0" style="display: none" id="startmenu" onclick="javascript: stop_clickevent(event)">
                <tr><td class="t" colspan="3">
                    <table cellpadding="0" cellspacing="0"><tr><td class="l">&nbsp;</td><td class="m">&nbsp;</td><td class="r">&nbsp;</td></tr></table>
                </td></tr> 
                <tr><td class="ml"><img src="images/v5/startmenu/1x1.gif" /></td><td class="mm">
                
                    <table class="items" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="left">
                                '.$left.'
                            </td>
                            <td class="right">
                                '.$right.'
                            </td>
                        </tr>
                    </table>
                
                </td><td class="mr"><img src="images/v5/startmenu/1x1.gif" /></td></tr>
                <tr><td class="b" colspan="3">
                    <table cellpadding="0" cellspacing="0"><tr><td class="l">&nbsp;</td><td class="m">'.$buttons.'</td><td class="r">&nbsp;</td></tr></table>
                </td></tr> 
            </table>
        ';
        
        return $ret;
        
    }
    
    public function FindItem($section, $action) {
        $t = @$this->items[$this->_postback_sections[$section.".".$action]];
        if(!$t)
            $t = @$this->items[$this->_postback_sections[$section."."]];
        return $t;
    }
    
}

class FavoritesMenu  {
    
    public $items;
        
    public function __construct() {
        $this->items = array();
    }
    
    function Render() {
        
        $ret = '
            <div id="favs">
            <table cellpadding="0" cellspacing="0"><tr>
        ';
        foreach($this->items as $menuitem) {
            $ret .= '<td>'.$menuitem->Render().'</td>';
        }
        $ret .= '
            </tr></table></div>
        ';    
        
        return $ret;
    }
    
}

class MenuItem {
	public $name;
	public $title;
	public $icon;
	public $link;
    public $description;
	
	public $floating = true;
	public $visible = true;
	public $enable = true;
	
	public $link_target = null;
	
	public $children;
	
	public function __construct($name, $title, $description, $icon, $link, $visible = true, $enable = true, $link_target = null) {
		$this->name = $name;
        $this->title = $title;
		$this->icon = $icon;			
		$this->link = $link;			
        $this->description = $description;
		
		$this->visible = $visible;
		$this->enable = $enable;
		$this->link_target = $link_target;
		
		$this->children = array();
	}
	
	function CreateIconImage($image, $text = '', $width = null, $height = null, $ad = "") {
		global $core;
        
        $attr = ($width ? 'width="'.$width.'"' : '').($height ? ' height="'.$height.'"' : '');
        
		switch($core->browserInfo->name) {
			case "ie":
				if($core->browserInfo->version > 6)
					$img = '<img src="'.$image.'" '.$attr.' border="0" alt="'.$text.'" '.$ad.' />';	
				else
					$img = '<img src="images/new/spacer1x1.gif" width="'.$width.'" height="'.$height.'" style="background-image: url('.$image.')" class="png" border="0" alt="'.$text.'" '.$ad.' />';		
				break;
			case "moz":
			default:
				$img = '<img src="'.$image.'" '.$attr.' border="0" alt="'.$text.'" />';	
				break;
			
		}
		return $img;
	}
	
	public function Render() {
		$ret = '';
		
		$ret .= '<table cellpadding="0" cellspacing="0" class="mi"><tr>';
        $ret .= '<td><a href="'.$this->link.'" '.($this->link_target != null ? 'target="'.$this->link_target.'"' : "").' title="'.$child->description.'">';
		$ret .= $this->CreateIconImage($this->icon).$this->title;
		$ret .= '</a></td>';
		$ret .= '</tr></table>';
		return $ret;
	}
}

class FavoritesMenuItem extends MenuItem {
    public $selected = false;
    
    public function Render() {
        $ret = '';
        
        $ret .= '<div class="mf-item" onmouseover="javascript: mf_up(event, this)">';
        $ret .= '<a'.($this->selected ? ' class="selected"' : '').' href="'.$this->link.'" '.($this->link_target != null ? 'target="'.$this->link_target.'"' : "").' title="'.$this->description.'">'.(!is_null($this->icon) ? $this->CreateIconImage($this->icon) : '').$this->title.'</a>';
        if(count($this->children) > 0)     {
            $ret .= '<div onmouseout="javascript: mf_down()" style="display: none">';
            foreach($this->children as $menuitem) {
                $ret .= $menuitem->Render();
            }
            $ret .= '</div>';
        }
        
        $ret .= '</div>';
        return $ret;
    }
    
    
}


    
?>