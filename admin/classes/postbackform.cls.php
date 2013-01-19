<?php

require_once("menuitem.cls.php");
require_once("popups.cls.php");

/**
	* class PostBackForm
	*
	* Description for class PostBackForm
	*
	* @author:
	*/
class PostBackForm extends IEventDispatcher {

	private $_section = "main";
	private $_action = "main";
	private $_command = "view";
    
    private $menu = null;
    private $favorites = null;

	// form properties
	private $action;
	private $method;
	public $encbinary = true;
	
	private $_rowsonpage;
	
	private $_postback_vars = null;

	private $callbackRenderContent;
	
	protected $page_blocks;	
	
	public $current_user;
	
	public $lang;
	
	public $iconpack;
	
	function PostBackForm($section = "main", $action = "main", $formaction = "", $formmethod = "post") {
		global $core;

		$this->RegisterEvent("postbackform.createtoolbar");
		$this->RegisterEvent("postbackform.languages.init");
		$this->RegisterEvent("postbackform.icons.init");
		$this->RegisterEvent("postbackform.postback.init");
		$this->RegisterEvent("postbackform.rendercontent.before");
		$this->RegisterEvent("postbackform.rendercontent.after");

		// page section & action
		$this->_action = $action;
		$this->_section = $section;

		$this->current_user = $core->security->currentUser;
		if($this->current_user->isNobody() && $section != "general") {
			$core->rq->redirect("?postback_section=general&postback_action=main&postback_command=loginform");
		}

		$lang = "en";
		if(!is_null($core->rq->section_langauge)) {
			$lang = $core->rq->section_langauge;
			include("lang/".$lang.".cls.php");
			$l = "\$this->lang = new $lang();";
			eval($l);
		}
		else {
			include("lang/en.cls.php");
			$l = "\$this->lang = new en();";
			eval($l);
		}


		$this->iconpack = new IconPack("default", "/images/icons");
		
		$this->DispatchEvent("postbackform.languages.init", collection::create("language", $lang));
		$this->DispatchEvent("postbackform.icons.init", collection::create());
		
		// form properties
		$this->action = $formaction;
		$this->method = $formmethod;
		
		$this->_rowsonpage = $core->sts->SETTING_PAGESIZE;

		$this->_postback_vars = new collection();

		$this->page_blocks = new collection();

        $this->menu = new StartMenu();
        $this->favorites = new FavoritesMenu();
        
        require_once("menu.req.php");
        require_once("favorites.req.php");
        
		// init the postback from request
		$this->init_postback();
	}
	
	private function init_postback() {
		global $core;
		if($core->rq->postback_section != '')
			$this->_section = $core->rq->postback_section;
		if($core->rq->postback_action != '')
			$this->_action = $core->rq->postback_action;
		if($core->rq->postback_command != '')
			$this->_command = $core->rq->postback_command;
		if($core->rq->postback_rowsonpage != null && $core->rq->postback_rowsonpage != '') {
			$this->_rowsonpage = $core->rq->postback_rowsonpage;
			$core->sts->SETTING_PAGESIZE = $this->_rowsonpage;
		}
		
		$post = $core->rq->postback_vars;
		if(!is_null($post) && $post != "")
			$this->_postback_vars = collection::Deserialize(base64_decode($post));

		$this->DispatchEvent("postbackform.postback.init", collection::create());
	}

	function post_vars($prefix) {
		global $core;
		$ret = new collection();
		$request = $core->rq->get_collection(VAR_REQUEST);
		foreach($request as $rkey => $ritem) {
			if( substr($rkey, 0, strlen($prefix)) == $prefix)
				$ret->add($rkey, $ritem);
		}
		return $ret;

	}

	function __get($nm) {
		global $core;
		$val = false;
		switch($nm) {
			case "command":
				$val = $this->_command;
				break;
			case "section":
				$val = $this->_section;
				break;
			case "action":
				$val = $this->_action;
				break;
			case "rowsonpage":
				$val = $this->_rowsonpage;
				break;
			default:
				$val = $core->rq->$nm;
		}
		return $val;
	}
	
	function UseExternalInterface() {
		return true;
	}
	
	function RenderBlock($name) {
		return $this->page_blocks->$name;
	}
	
	function Out($name, $content, $position = OUT_AFTER) {
		$b = @$this->page_blocks->$name;
		if($position == OUT_AFTER)		
			$b .= $content;
		else
			$b = $content.$b;
		$this->page_blocks->add($name, $b);
	}

	function Process() {
		
		if ($this->floating)
			$this->action = "floating.php";
	
		/*add main scripts to scripts block*/		
		$this->Out("scripts", "<script language=\"javascript\">\n".file_get_contents(dirname(__FILE__)."/scripts/listSelection.js")."\n</script>", OUT_AFTER);
		$this->Out("scripts", "<script language=\"javascript\">\n".file_get_contents(dirname(__FILE__)."/scripts/postbackform.js")."\n</script>", OUT_AFTER);
		$this->Out("scripts", "
				<script language=javascript>".
				file_get_contents(dirname(__FILE__)."/scripts/pageforms.js").
				"</script>"
			, OUT_AFTER);
		
		$this->Out("title", $this->RenderTitle(), OUT_AFTER);
		
		$this->Out("subtitle", $this->RenderSubTitle(), OUT_AFTER);
		
		$this->Out("favorites", $this->RenderFavoritesMenu(), OUT_AFTER);
        
        $this->Out("menu", $this->RenderMenu(), OUT_AFTER);
		
		$this->Out("form_head", "
				<form name='fPostBack' id='idfPostBack' ".
					(!empty($this->method) ? "method='".$this->method."'" : "")." ".
					(!empty($this->action) ? "action='".$this->action."'" : "")." ".
					(($this->encbinary) ? "enctype=\"multipart/form-data\"" : "")." ".">		
				<input type=hidden name=postback_command value='".$this->_command."'>
				<input type=hidden name=postback_action value='".$this->_action."'>
				<input type=hidden name=postback_section value='".$this->_section."'>
		", OUT_AFTER);
		
		$this->DispatchEvent("postbackform.rendercontent.before", Hashtable::Create());
		
		$this->Out("content", $this->RenderContent(), OUT_AFTER);

		$this->DispatchEvent("postbackform.rendercontent.after", Hashtable::Create());
		
		$this->Out("form_footer", "</form>", OUT_AFTER);
	}

	function RenderContent() {
		return "";
	}

	function RenderTitle() {
		return "";
	}

	function RenderSubTitle() {
		return "";
	}
	
	function RenderToolbar($tools, $type = null, $adcontent = null) {
		$this->Out("toolbar", $this->CreateToolBar($tools, $type, $adcontent), OUT_AFTER);
	}

	function RenderMenu() {
        return $this->menu->Render();
	}
    
    function RenderFavoritesMenu() {
        return $this->favorites->Render();
    }
	
	function RenderOrdersBar($storages, &$pagerargs, &$order, $postbackto, $container = false) {
		
		$fld_name = $this->fld_name;
		$fld_order = $this->fld_order;
		if($fld_name) {
			$pagerargs .= "&fld_name=".$fld_name."&fld_order=".$fld_order;
		}
		
		$toolbar_bottom = "";
		if($container)
			$toolbar_bottom .= "<table><tr>";
		$toolbar_bottom .= "<td>&nbsp;&nbsp;</td>";
		$toolbar_bottom .= "<td>";
		$toolbar_bottom .= $this->lang->development_select_order.": ";
		$toolbar_bottom .= "</td>";
		$toolbar_bottom .= "<td>";
		$toolbar_bottom .= "<select name=fld_name id=fld_name class=select-box style='width:150px;' onchange=\"return PostBack('".$postbackto."', 'get')\">";
		// $toolbar_bottom .= "<option value='' ".($fld_name == "" ? "selected" : "").">...</option>";
		foreach($storages as $storage) {
			if($storage instanceof Storage) {
				$toolbar_bottom .= "<option value='' ".($fld_name == $storage->fname("order") ? "selected" : "")." style='color: #c0c0c0'>".$storage->name."</option>";
				$fields = $storage->fields;
				foreach($fields as $field) {
					$toolbar_bottom .= "<option value='".$storage->fname($field->field)."' ".($fld_name == $storage->fname($field->field) ? "selected" : "").">&nbsp;&nbsp;&nbsp;".$field->name."</option>";
				}
			}
		}
		$toolbar_bottom .= "</select>";
		$toolbar_bottom .= "</td>";
		if($fld_name != "") {
			$toolbar_bottom .= "<td>";
			$toolbar_bottom .= "<select name=fld_order id=fld_order class=select-box style='width:35px;' onchange=\"return PostBack('".$postbackto."', 'get')\">";
			$toolbar_bottom .= "<option value='desc' ".($fld_order == "desc" ? "selected" : "").">/\</option>";
			$toolbar_bottom .= "<option value='asc' ".($fld_order == "asc" || $fld_order=="" ? "selected" : "").">\/</option>";
			$toolbar_bottom .= "</select>";
			$toolbar_bottom .= "</td>";
		}
				
		if($fld_name != "") {
			$order = $fld_name;
			if($fld_order != "")
				$order = $order." ".$fld_order;
		}

		if($container)
			$toolbar_bottom .= "</tr></table>";
		

		return $toolbar_bottom;
	}

	function RenderBlobCategoriesOptions($categories, $selected, $level=0) {
		$ret = "";
		foreach($categories as $category) {
			$pad = intval($level)*4;
			$red = $category->id == $selected->id ? 'style="color: #ff0000;"' : '';
			$s = $category->id == $selected->id ? ' selected' : '';
	$ret .= '
				<option value="'.$category->id.'" '.$red.' '.$s.'>'.str_repeat("&nbsp;", $pad).$category->description.'</option>
	';
			if($category->children)
				$ret .= $this->RenderBlobCategoriesOptions($category->Children(), $selected, $level+1);
		}
		return $ret;
	}

	public function RenderContentTableHeader() {
		return '<table border="0" cellspacing="0" cellpadding="10" class="content-table">';
	}
	
	public function RenderContentTableHeaderRow($tds, $hasIcon = true, $hasCheckbox = true, $checkboxTDContent = '&nbsp;', $width = null, $iconTDContent = '&nbsp;') {
		$ret = '
		<tr class="title">
		';
		if($hasIcon)
			$ret .= '
			<td class="icon">'.$iconTDContent.'</td>
			';
		$i = 0;
		foreach($tds as $td)
			$ret .= '
			<td nowrap="nowrap" '.(is_null($width) ? '' : ' width="'.$width[$i++].'"').'>'.$td.'</td>
			';
		if($hasCheckbox || $checkboxTDContent != '&nbsp;')
			$ret .= '
			<td class="checkbox" >'.$checkboxTDContent.'</td>
			';
		$ret .= '
		</tr>
		';
		return $ret;
	}
	
	public function RenderContentTableContentEmptyRow($text, $colcount, $hasicon, $hascheckbox) {
		$ret = '';
		if($hasicon) {
			$ret .= '<td class="border icon">&nbsp;</td>';
		}
		$ret .= '<td class="border" colspan="'.$colcount.'"><span class="small-text">'.$text.'</span></td>';
		if($hascheckbox)
			$ret .= '<td class="border checkbox">&nbsp;</td>';
		return $ret;
	}
	 
	public function RenderContentTableContentRow($icon, $firsttd, $link, $tds, $hasCheckbox = true, $id = null, $checkboxNamePrefix = "template_operation_id_", $level = 0, $islink = true, $width = null) {
		$ret = '<tr onclick="javascript:  setRowCheck(this);" class="normal" id="list-item-'.$id.'">';
	
		if($icon != null) {
			$ret .= '<td class="border icon">';
			$ret .= $this->iconpack->CreateIconImage($icon, "", 24, 24, 'align=absmiddle');
			$ret .= '</td>';
		}
	
		$ret .= '<td class="border" '.(is_null($width) ? '' : ' width="'.$width[0].'"').'>';
		if($hasCheckbox) {
			if ($islink)
				$ret .= '<a class="tree-link" href="'.$link.'">';
			$ret .= $firsttd[0];
			if ($islink)
				$ret .= '</a>';	
			if (count($firsttd) > 1){
				if($firsttd[1] != null) {
					$ret .= '<br><span class="small-text">'.$firsttd[1].'</span>';
				}
			}
		}
		else {
			$ret .= $firsttd[0];
			if (count($firsttd) > 1){
				if($firsttd[1] != null) {
					$ret .= '<br><span class="small-text">'.$firsttd[1].'</span>';
				}
			}
		}
		$ret .= '</td>';
		
		$i = 1;
		foreach($tds as $td) {
			$ret .= '<td class="border" '.(is_null($width) ? '' : ' width="'.$width[$i].'"').'>';			
			$ret .= is_empty($td) ? "&nbsp;" : $td;
			$ret .= '</td>';
			$i++;
		}
		
		$ret .= '<td class="border checkbox">';
		$ret .= $this->SetPostVar($checkboxNamePrefix.$id, $id, "checkbox", "hilitable=1 ".($hasCheckbox ? "" : " style='display:none'")).'&nbsp;';
		$ret .= "</td>";
		
		$ret .= '</tr>';
		return $ret;
	}	

	public function RenderContentTableFooter() {
		return '</table>';
	}
	
	public function RenderFormHeader() {
		return '<table class="content-table" cellpadding="0" cellspacing="0">';
	}
	
	public function RenderFormFooter() {
		return '</table>';
	}

	public function RenderFormRowStart() {
		return '<tr>';
	}

	public function RenderFormRowEnd() {
		return '</tr>';
	}

	public function RenderFormTitleCell($title, $titlewidth = "120") {
		return 
		'
			<td class="field" width="'.$titlewidth.'" ondblclick="javascript: hideRow(this);">
				'.$title.'
			</td>
		';
	}
	
	public function RenderFormControlCell($control, $prefix = "", $postfix = "") {
		$c = "";
		if(is_array($control)) {
			foreach($control as $ctrl) {
				$c .= $ctrl->Render();
			}
		}
		else {
			if(is_object($control))
				$c = $control->Render();
			else 
				$c = $control;
		}
		
		return 
		'
			<td class="value">
				'.$prefix.$c.$postfix.'
			</td>
		';
	}
	
	public function RenderFormRow($title, $name, $value, $required, $args, $type = "text", $password = false, $class = "", $styles = "", $titlewidth = "120") {
		$type = str_replace(" ", "", $type);
		$c = $type."ExControl";

		$control = new $c($name, $value, $required, $args, $class, $styles, $password);
		$ret = '
			<tr>
				<td class="field" width="'.$titlewidth.'" ondblclick="javascript: hideRow(this);">
					'.$title.($control->required ? CONTROL_REQUIRED : '').'
				</td>
				<td class="value">
					'.$control->Render().'
					'.(is_null($args) ? '' : ($args->description ? '<br /><span class="small-text">'.$args->description.'</span>' : '')).'
				</td>
			</tr>
		';
		return $ret;
	}
	
	function CreatePostBack($command, $section = null, $action = null, $method = null, $message = null, $page = null, $pre_actions = null) {
		if(is_null($section))
			$section = $this->_section;
		if(is_null($action))
			$action = $this->_action;
		if(is_null($command))
			$command = $this->_command;
		if(is_null($method))
			$method = $this->method;
		
		if(!is_null($page))
			$page = ", createArray('page', '".$page."')";
		else if($this->page)
			$page = ", createArray('page', '".$this->page."')";
		
		return "javascript: ".(($pre_actions == null) ? "" : $pre_actions." ")."PostBack('".$command."', '".$method."', '".$section."', '".$action."', ".(!is_null($message) ? "'".$message."'" : "null")." ".$page.");";
	}

	function CreateFloatingPostBack($command, $section, $action, $method, $message, $width, $height,$resizable,$except = null, $javascript = true) {
		return ($javascript ? 'javascript: ' : '')."PostBackToFloater('".$command."', '".$method."', '".$section."', '".$action."', ".(!is_null($message) ? "'".$message."'" : "null").", null, ".$width.", ".$height.", ".($resizable ? "true" : "false").", ".(!is_null($except) ? "'".$except."'" : "null").");";
	}

	function CreateLink($command, $section = null, $action = null, $method = null, $message = null) {
		if(is_null($section))
			$section = $this->_section;
		if(is_null($action))
			$action = $this->_action;
		if(is_null($command))
			$command = $this->_command;
		if(is_null($method))
			$method = $this->method;

		return "javascript: Relocate('".$this->action."?postback_command=".$command."&postback_section=".$section."&postback_action=".$action."');";
	}

	function DoExternalCommand($formaction, $section, $action, $command, $method = null, $data = null) {
		global $core;
		if(!is_null($data)) {
			$data->add("postback_command", $command);
			$data->add("postback_action", $action);
			$data->add("postback_section", $section);
		}
		if(is_null($method))
			$method = $this->method;

		$core->rq->redirect($formaction, $method, $data);
	}
	
	function DoPostBack($command, $method = null, $section = null, $action = null, $page = null) {
		
		if(is_null($section))
			$section = $this->_section;
		if(is_null($action))
			$action = $this->_action;
		if(is_null($method))
			$method = $this->method;
		if(!is_null($page))
			$page = ", createArray('page', '".$page."')";
		else if($this->page)
			$page = ", createArray('page', '".$this->page."')";
		
		// $ret = '<input type=hidden name="postback_vars" value="'.base64_encode($this->_postback_vars->Serialize()).'">';
		// $ret.

		return "<script language=javascript>PostBack('".$command."', '".$method."', '".$section."', '".$action."', null".$page.");</script>";
	}
	
	function DoFloatingPostBack($command, $method, $section, $action, $message, $width, $height,$resizable) {
		return "<script language=javascript>PostBackToFloater('".$command."', '".$method."', '".$section."', '".$action."', ".(!is_null($message) ? "'".$message."'" : "null").", null, ".$width.", ".$height.", ".($resizable ? "true" : "false").");</script>";
	}
	
	function SetPostVar($name, $value, $type = "hidden_extended", $attributes = "") {
		if($type == "hidden_extended")
			return "<textarea name='".$name."' style='display:none' ".$attributes.">".$value."</textarea>";
		else if($type == "textarea")
			return "<textarea name='".$name."' ".$attributes.">".$value."</textarea>";
		else
			return "<input type=".$type." name='".$name."' value='".$value."' ".$attributes.">";
	}

	function RenderScript($script) {
		return "<script language=javascript>\n".$script."\n</script>";
	}

	function CreateCommandBar($tools, $type = TOOLBAR_IMAGETEXT){
		$lf = "\n";
		$ret = "";
		
		/*
			$tools = array (
				array($text, $scriptCommandName, $image, $message),
				array($text, $scriptCommandName, $image, $message),
				...
				array($text, $scriptCommandName, $image, $message),
			)
		*/
		
		$ret .= '<table border="0" cellspacing="0" cellpadding="0">'.$lf;
		$ret .= '<tr>'.$lf;
		foreach($tools as $tool){
			@list($text, $scriptCommandName, $image, $message) = $tool;
			if($type & TOOLBAR_IMAGEONLY)
				$ret .= '<td align=center nowrap=nowrap>
					<a href="javascript: '.$scriptCommandName.'" class="tree-link">
					<img src="/admin/images/icons/'.$image.'" align=absmiddle border=0 alt="'.$text.'"></a></td>'.$lf;
			if($type & TOOLBAR_TEXTONLY)
				$ret .= '<td nowrap=nowrap>&nbsp;
					<a href="javascript: '.$scriptCommandName.'" class="tree-link">'.$text.'</a></td>'.$lf;
			if($type == TOOLBAR_IMAGETEXT)
				$ret .= '<td width=20 nowrap=nowrap>&nbsp;</td>'.$lf;
			else
				$ret .= '<td width=5><img width=5 height=1></td>'.$lf;
		}
		$ret .= '</tr>'.$lf;
		$ret .= '</table>'.$lf;
		
		return $ret;
	}
	
	function CreateToolBar($tools, $type = null, $addcontent = null) {
		$lf = "\n";
		$ret = "";
		
		$args = $this->DispatchEvent("postbackform.createtoolbar", Hashtable::create("tools", $tools));
		if ($args != false){
			if (!is_empty($args->tools))
				$tools = $args->tools;
			if (!is_empty($args->out))
				$ret .= $args->out;
		}
		
		if(is_null($type))
			$type = TOOLBAR_IMAGEONLY | TOOLBAR_TEXTONLY;

		$ret .= '
				<div class="toolbar">
					<div class="toolbar-left"></div>
		'.$lf;

		foreach($tools as $tool){
			@list($name, $image, $text, $command, $method, $section, $action, $message, $movetopage, $floating, $width, $height, $resizable, $except) = $tool;
			if($name == "separator") {
				$ret .= '<!-- Tool bar item: separator -->'.$lf;
				$ret .= '<div class="toolbar-button"><img src="images/new/spacer1x1.gif" width="10" height="1"></div>'.$lf;
			}
			else {
				// $image = $this->IconFromPack($image);
				
				$alignment = substr($name, 0, 1) == "!" ? "-right" : "";
				
				$ret .= '<!-- Tool bar item: '.$name.' -->'.$lf;
				if($floating) {
					if($type & TOOLBAR_IMAGEONLY)
						$ret .= '<div class="toolbar-button'.$alignment.'"><a title="'.$text.'" href="'.$this->CreateFloatingPostBack($command, $section, $action, $method, $message, $width, $height,$resizable,$except).'">'.$this->iconpack->CreateIconImage($image, $text, 28, 28).'</a></div>'.$lf;
					if($type & TOOLBAR_TEXTONLY)
						$ret .= '<div class="toolbar-button'.$alignment.'"><a title="'.$text.'" href="'.$this->CreateFloatingPostBack($command, $section, $action, $method, $message, $width, $height,$resizable,$except).'">'.$text.'</a></div>'.$lf;
				}
				else {
					if($type & TOOLBAR_IMAGEONLY)
						$ret .= '<div class="toolbar-button'.$alignment.'"><a title="'.$text.'" href="'.$this->CreatePostBack($command, $section, $action, $method, $message,$movetopage).'">'.$this->iconpack->CreateIconImage($image, $text, 28, 28).'</a></div>'.$lf;
					if($type & TOOLBAR_TEXTONLY)
						$ret .= '<div class="toolbar-button'.$alignment.'"><a title="'.$text.'" href="'.$this->CreatePostBack($command, $section, $action, $method, $message,$movetopage).'">'.$text.'</a></div>'.$lf;
				}
			}
		}
		if($addcontent != null)	{
			$ret .= $addcontent;
		}
		$ret .= '</div>'.$lf;
		return $ret;
	}

	function CreateSmallToolBar($tools, $type = null) {
		$lf = "\n";
		$ret = "";
		
		/*
			$tools = array (
				array($name, $image, $text, $command, $method, $section, $action, $message),
				array($name, $image, $text, $command, $method, $section, $action, $message),
				...
				array($name, $image, $text, $command, $method, $section, $action, $message)
			)
		*/
		
		if(is_null($type))
			$type = TOOLBAR_IMAGEONLY | TOOLBAR_TEXTONLY;
		
		$ret .= '<table border="0" cellspacing="0" cellpadding="0">'.$lf;
		$ret .= '<tr>'.$lf;
		foreach($tools as $tool){
			@list($name, $image, $text, $command, $method, $section, $action, $message, $movetopage, $floating, $width, $height, $resizable,$except) = $tool;
			$ret .= '<!-- Tool bar item: '.$name.' -->'.$lf;
			if($floating) {
				if($type & TOOLBAR_IMAGEONLY)
					$ret .= '<td align=center nowrap=nowrap><a title="'.$text.'" href="'.$this->CreateFloatingPostBack($command, $section, $action, $method, $message, $width, $height,$resizable,$except).'" class="tree-link"><img src="/admin/images/icons/'.$image.'" align=absmiddle border=0 alt="'.$text.'"></a></td>'.$lf;
				if($type & TOOLBAR_TEXTONLY)
					$ret .= '<td nowrap=nowrap>&nbsp;<a href="'.$this->CreateFloatingPostBack($command, $section, $action, $method, $message, $width, $height,$resizable,$except).'" class="tree-link">'.$text.'</a>&nbsp;&nbsp;</td>'.$lf;
				else
					$ret .= '<td width=5><img width=5 height=1></td>'.$lf;			
			}
			else {
				if($type & TOOLBAR_IMAGEONLY)
					$ret .= '<td align=center nowrap=nowrap><a title="'.$text.'" href="'.$this->CreatePostBack($command, $section, $action, $method, $message,$movetopage).'" class="tree-link"><img src="/admin/images/icons/'.$image.'" align=absmiddle border=0 alt="'.$text.'"></a></td>'.$lf;
				if($type & TOOLBAR_TEXTONLY)
					$ret .= '<td nowrap=nowrap>&nbsp;<a href="'.$this->CreatePostBack($command, $section, $action, $method, $message, $movetopage, $floating).'" class="tree-link">'.$text.'</a>&nbsp;&nbsp;</td>'.$lf;
				else
					$ret .= '<td width=5><img width=5 height=1></td>'.$lf;
			}
		}
		$ret .= '</tr>'.$lf;
		$ret .= '</table>'.$lf;
		return $ret;
	}

    function Pager($currentpage, $pagesize, $rows, $url, $adcontainer = true) {
		global $core;
        $ret = "";
        $i=0;

		$core->sts->SETTING_PAGESIZE = $pagesize;

        $pagecount = (int)($rows/$pagesize)+1;
	
		$ret .= ($adcontainer ? "<div class='toolbar-free-content'>" : "")."<table style='margin: 2px 0px 0px 0px'><tr><td nowrap=\"nowrap\">".$this->lang->rows."&nbsp;<strong>".$rows."</strong></td><td nowrap=\"nowrap\">".$this->lang->pages."&nbsp;</td><td>";
        if($currentpage > 1) {
			$ret .= "<a href='javascript: Relocate(\"".$url."&page=1\");'>".$this->iconpack->CreateIconImage('iconpack(navigate_first)', '', 20, 20, 'align="absmiddle"')."</a>&nbsp;&nbsp;";
            $ret .= "<a href='javascript: Relocate(\"".$url."&page=".($currentpage-1)."\");'>".$this->iconpack->CreateIconImage('iconpack(navigate_left)', '', 20, 20, 'align="absmiddle"')."</a>&nbsp;&nbsp;";
        }

		$pagestart = $currentpage - 3;
		if($pagestart < 0)
			$pagestart = 1;
		
		$pageend = $currentpage + 3;
		if($pageend > $pagecount)
			$pageend = $pagecount;
		
        for($i = $pagestart; $i < $pageend; $i++) {
            if($currentpage == $i)
                $ret .= "<b>".($i)."</b>&nbsp;|&nbsp;";
            else
                $ret .= "<a href='javascript: Relocate(\"".$url."&page=".($i)."\");'>".($i)."</a>&nbsp;|&nbsp;";
        }

        if($currentpage == $pageend)
            $ret .= "<b>".($pageend)."</b>";
        else
            $ret .= "<a href='javascript: Relocate(\"".$url."&page=".($pageend)."\");'>".($pageend)."</a>";

        if($currentpage < $pagecount) {
            $ret .= "&nbsp;&nbsp;<a href='javascript: Relocate(\"".$url."&page=".($currentpage+1)."\");'>".$this->iconpack->CreateIconImage('iconpack(navigate_right)', '', 20, 20, 'align="absmiddle"')."</a>";
	        $ret .= "&nbsp;&nbsp;<a href='javascript: Relocate(\"".$url."&page=".($pagecount)."\");'>".$this->iconpack->CreateIconImage('iconpack(navigate_last)', '', 20, 20, 'align="absmiddle"')."</a>";
	    }
	
	    $ret .= '</td><td nowrap="nowrap">&nbsp;&nbsp;'.$this->lang->rowsonpage.'&nbsp;</td><td><input type=text id="rowsonpage" name=postback_rowsonpage value="'.$pagesize.'" style="font-size: 10px; width: 25px;"></td><td><a href="javascript: Relocate(\''.$url.'&postback_rowsonpage=\'+document.getElementById(\'rowsonpage\').value);">'.
				$this->iconpack->CreateIconImage('iconpack(recycle)', '', 20, 20, 'align="absmiddle"').
				'</a></td></tr></table>';
	    
	    $ret .= ($adcontainer ? "</div>" : "");

        return $ret;
    }

	function ErrorMessage($msg, $title = "System message", $buttons = -1) {
		$ret  = "<div class='message-box'>";
		$ret .= "<table cellpadding=0 cellspacing=0 border=0>";
		$ret .= "<tr>";
		$ret .= "<td class='message-title'>".$title."</td>";
		$ret .= "</tr>";
		$ret .= "<tr><td class='message-text'>".$msg."</td></tr>";

		$this->Out("subtitle", $title, OUT_AFTER);

		$command = "<table><tr>";
		$cmdclass = $this->floating ? "small-button-long" : "command-button";
		switch($buttons) {
			case BTNS_OK_ONLY:
				$command .= "<td><input type=submit name=ok value=OK class='".$cmdclass."' onclick=\"PostBack('message_ok');\"></td>";
				break;
			case BTNS_OK_CANCEL:
				$command .= "<td><input type=submit name=ok value=OK class='".$cmdclass."' onclick=\"PostBack('message_ok');\"></td>";
				$command .= "<td><input type=submit name=cancel value=Cancel class='".$cmdclass."' onclick=\"PostBack('message_cancel');\"></td>";
				break;
			case BTNS_YES_NO:
				$command .= "<td><input type=submit name=ok value=OK class='".$cmdclass."' onclick=\"PostBack('message_yes');\"></td>";
				$command .= "<td><input type=submit name=cancel value=Cancel class='".$cmdclass."' onclick=\"PostBack('message_no');\"></td>";
				break;
			case BTNS_CLOSE:
				$command .= "<td><input type=submit name=ok value=OK class='".$cmdclass."' onclick=\"PostBack('message_close');\"></td>";
				break;
		}
		$command .= "</tr></table>"; 

		if($this->floating)
			$this->Out("toolbar_bottom", $command);
		else 
			$ret .= $command;

		$ret .= "</table></div>";

		return $ret;
	}
	
	public function ReloadOwner($args = null) {
		
		$urlargs = "";
		if(!is_null($args)) {
			if(is_array($args)) {
				foreach($args as $key => $value) 
					$urlargs .= $key."=".$value."&";
			}
			else {
				$urlargs = $args;
			}
		}
			
		return '<script language="javascript">ReloadFloatingOwnerWindow("'.$urlargs.'");</script>';
	}

	public function CloseMe($timeout = 0) {
		return '<script language="javascript">window.setTimeout("window.close();", '.$timeout.');</script>';
	}

	public function FocusMe() {
		return '<script language="javascript">top.onfocus = FocusMe;</script>';
	}
	
	public function SetPermissionsForm($item, $showGroups = true) {
		global $core;
		if($core->security->Check(/*check object*/ $item, 
								  /*$operation */ "usermanagement.persmissions.set"
								  /*, $core->security->currentUser*/)) {
			$ret = "";
			
			$users = SecurityEx::$users;
			$groups = SecurityEx::$groups;

			$cache = $item->securitycache;
			$className = get_class($item);
			
			$selected = $this->_rearangeObjectPermissionsCache($cache);
			
			$tree = $this->_createObjectPermissionsTreeTree($className, $users, $showGroups ? $groups : null);
			
			$ret .= $this->RenderFormHeader();
			$ret .= $this->RenderFormRow("User permissions", "permissions", array($tree, $selected), false, Collection::Create("checkField", "operation", "valueField", "permission"), "tree", true, "", "height:400px;");
			$ret .= $this->RenderFormFooter();
			
			$this->Out("toolbar_bottom", '
				<input type="submit" name="save_permissions" value="'.$this->lang->save.'" class=small-button-long onclick="return PostBack(\'save_permissions\', \'post\');">
				<input type="reset" name="cancel" value="'.$this->lang->cancel.'" class=small-button-long onclick="return PostBack(\'close\', \'post\');">
			');

			return $ret;
		}
		else
			return $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
	}
	
	function _rearangeObjectPermissionsCache($cache) {
		$out = new ArrayList();
		foreach($cache as $username => $userperm) {
			foreach($userperm as $perm) {
				$perm->operation = $username.".".$perm->operation;
				$out->Add($perm);
			}
		}
		return $out;
	}
	
	function _createObjectPermissionsTreeTree($className, $users, $groups = null) {
		$operations = null;
		$s = "\$operations = ".$className."::getOperations();";
		@eval($s);

		if(is_null($operations))
			return null;
		
		$tree = new Hashtable();
		if($groups != null) {
			foreach($groups as $k => $group) {
				$item = $tree->Add($group->name, new Hashtable());
				foreach($operations as $op) {
					$item->Add($op->name, $op->name);
				}
			}
		}

		foreach($users as $user) {
			$item = $tree->Add($user->name, new Hashtable());
			foreach($operations as $op) {
				$item->Add($op->name, $op->name);
			}
		}
		
		return $tree;
	}
    
    protected function checkSourceInFile($content){
        global $core;
        $content = trim($content);
        $info = new Object();
        $info->infile = (substr($content, 0, 9) == "LOADFILE:" ? true : false);
        $info->path = ($info->infile) ? substr($content, 9) : "";
        $c = ($info->infile) ? (($core->fs->fileexists($info->path)) ? $core->fs->readfile($info->path) : -1) : "";
        $info->content = $c;
        return $info;
    }
    
    protected function IOPath() {
        global $core;    
        $ret = new Object();
        $iopaths = $core->sts->IO_PATH;
        $iopaths = preg_split('/\r\n/', $iopaths);
        
        $ret->root = $iopaths[0];
        $ret->templates = $ret->root.$iopaths[1];
        $ret->designes = $ret->root.$iopaths[2];
        $ret->repository = $ret->root.$iopaths[3];
        $ret->modules = $ret->root.$iopaths[4];
        $ret->data = $ret->root.$iopaths[5];
        
        return $ret;
        
    }

	
}

?>
