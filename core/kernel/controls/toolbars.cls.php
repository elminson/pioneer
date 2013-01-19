<?php

class ToolbarButton {
	
	public $postbackform;
	public $name;
	public $image;
	public $text;
	public $alignment;
	
	public function __construct($name, $image = "", $text = "", $alignment = TOOLBAR_BUTTON_LEFT) {
		$this->name = $name;
		$this->image = $image;
		$this->text = $text;
		$this->alignment = $alignment;
	}
	
	public function Render() {
		return "Please derive the class and implement this function";
	}
	
}

class ToolbarImageButton extends ToolbarButton {

	public $command;
	public $method;
	public $section;
	public $action;
	public $message;
	public $movetopage;
	public $floating;
	public $width;
	public $height;
	public $resizablel;
	public $except;
	
	public function __construct($name, $image, $text, $alignment = TOOLBAR_BUTTON_LEFT, $command = null, $method = null, $section = null, $action = null, $message = null, $movetopage = 1) {
		parent::__construct($name, $image, $text, $alignment);
		$this->command = $command;
		$this->method = $method;
		$this->section = $section;
		$this->action = $action;
		$this->message = $message;
		$this->movetopage = $movetopage;
	}
	
	public function Render() {
		return '
			<div class="toolbar-button'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'">
				<a title="'.$this->text.'" href="'.$this->postbackform->CreatePostBack($this->command, $this->section, $this->action, $this->method, $this->message, $this->movetopage).'">'.$this->postbackform->iconpack->CreateIconImage($this->image, $this->text, 28, 28).'</a>
			</div>';
	}
	
}

class ToolbarImageFButton extends ToolbarImageButton  {
	
	public $floating;
	public $width;
	public $height;
	public $resizable;
	public $except;
	
	public function __construct($name, $image, $text, $alignment = TOOLBAR_BUTTON_LEFT, $command = null, $method = null, $section = null, $action = null, $message = null, $width = 600, $height = 400, $resizable = true, $except = null) {
		parent::__construct($name, $image, $text, $alignment, $command, $method, $section, $action, $message, 0);
		$this->width = $width;
		$this->height = $height;
		$this->resizable = $resizable;
		$this->except = $except;
	}
	
	public function Render() {
		return '
			<div class="toolbar-button'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'"><a title="'.$this->text.'" href="'.$this->postbackform->CreateFloatingPostBack($this->command, $this->section, $this->action, $this->method, $this->message, $this->width, $this->height, $this->resizable, $this->except).'">'.$this->postbackform->iconpack->CreateIconImage($this->image, $this->text, 28, 28).'</a></div>
		';
	}
	
}

class ToolbarComboButton extends ToolbarButton  {
    
    public $items;
    public $inputname;
    public $attributes;
    public $change;
    
    public function __construct($name, $items, $alignment = TOOLBAR_BUTTON_LEFT, $inputname, $attributes, $change = null) {
        parent::__construct($name, '', '', $alignment);
        $this->items = $items;
        $this->inputname = $inputname;
        $this->attributes = $attributes;
        $this->change = $change;
    }
    
    public function Render() {
        $ret = '
            <div class="toolbar-button'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'">
                <select name="'.$this->inputname.'" "'.$this->attributes.' '.(!is_empty($this->change) ? 'onchange="javascript: '.$this->change.'"' : '').'>
        ';
                foreach($this->items as $value) {
                    /* $value = array('value', 'text') */
                    $ret .= '<option value="'.$value['value'].'">'.$value['text'].'</option>';
                }
        $ret .= '
                </select>
            </div>
        ';
        return $ret;
    }
    
}

class ToolbarTextboxButton extends ToolbarButton  {
    
    public $items;
    public $inputname;
    public $attrs;
    public $css;
    
    public function __construct($name, $value, $alignment = TOOLBAR_BUTTON_LEFT, $inputname = '', $attrs = '', $css = '') {
        parent::__construct($name, '', '', $alignment);
        $this->value = $value;
        $this->inputname = $inputname;
        $this->attrs = $attrs;
        $this->css = $css;
    }
    
    public function Render() {
        $ret = '
            <div class="toolbar-button tbtext'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'">
                <input type="text" name="'.$this->inputname.'" "'.$this->attrs.' '.(!is_empty($this->css) ? 'style="'.$this->css.'"' : '').' value="'.$this->value.'" />
            </div>
        ';
        return $ret;
    }
    
}

class ToolbarPagerButton extends ToolbarButton {
	
	public $page;
	public $pagesize;
	public $affected;
	public $link;
	
	public function __construct($name, $page, $pagesize, $affected, $link) {
		parent::__construct($name, "", "", TOOLBAR_BUTTON_LEFT);
		$this->page = $page;
		$this->pagesize = $pagesize;
		$this->link = $link;
		$this->affected = $affected;
	}
	
	public function Render() {
		return '<div class="toolbar-free-content tbpager">'.$this->postbackform->Pager($this->page, $this->pagesize, $this->affected, $this->link, false).'</div>';
	}
	
}

class ToolbarSeparator extends ToolbarButton {
	
	public function __construct($name) {
		parent::__construct($name);
		$this->name = $name;
	}
	
	public function Render() {
		return '
				<!-- Tool bar item: separator -->
				<div class="tbseparator"><img src="images/new/spacer1x1.gif" width="1" height="1"></div>
		';
	}
}

class ToolbarLabel extends ToolbarButton {
    
    private $_text;
    
    public function __construct($name, $text) {
        parent::__construct($name);
        $this->name = $name;
        $this->_text = $text;
    }
    
    public function Render() {
        return '
                <div class="tblabel">'.$this->_text.'</div>
        ';
    }
}

class ToolbarButtonList extends Collection {
	
	private $postback;
	
	public function __construct($postback) {
		$this->postback = $postback;
		parent::__construct();
	}
	
	public function Add($button) {
		if($button instanceof ToolbarButton) {
			$button->postbackform = $this->postback;
			parent::Add($button->name, $button);
		}
		else {
			die("Error creating toolbar");
		}
	}
	
	public function Delete($button) {
		if(is_string($button))
			parent::Delete($button);
		else if($button instanceof ToolbarButton) {
			parent::Delete($button->name);
		}
	}
	
}

class Toolbar {
	
	private $_buttons;
	private $_postback;
	
	public function __construct($postbackform) {
		$this->_postback = $postbackform;
		$this->_buttons = new ToolbarButtonList($this->_postback);
	}
	
	public function __get($prop) {
		switch(strtolower($prop)) {
			case "buttons":
				return $this->_buttons;
			default:
				return null;
		}
	}
	
	public function Render($outto = null) {
		
		$tools = $this->_buttons;
		$args = $this->_postback->DispatchEvent("postbackform.createtoolbar", Hashtable::Create("buttons", $tools));
		if($args)
			if(@$args->buttons)
				$this->_buttons = $args->buttons;
	
		$ret = '
				<div class="toolbar">
					<div class="toolbar-left"></div>
		';
		foreach($this->_buttons as $button)
			$ret .= $button->Render();
		
		$ret .= '</div>';
		if($outto)
			$this->_postback->Out($outto, $ret, OUT_AFTER);

		return $ret;
	}
	
}

?>