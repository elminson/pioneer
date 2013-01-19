 <?php

/**
	* class ModulesPageForm
	*
	* Description for class ModulesPageForm
	*
	* @author:
	*/
	
class ModulesPageForm extends PostBackForm {
	
	/**
		* Constructor.
		*
		* @param
		* @return
		*/
	function ModulesPageForm() {
		parent::__construct("modules", "main", "/admin/index.php", "get");
		
		if(is_null($this->lang))
			$this->lang = new stdClass();
	}

	public function RenderContent() {
		return $this->RenderDevelopment();
	}

	public function MenuVisible() {
		return !$this->floating;
	}

	function RenderDevelopment() {
		global $core;
		
		if (is_empty($this->action))
			return;
			
		/*
			$ret .= "<div class=\"warning\">".$this->lang->modules_initialize_error."</div>";
			return $ret."</div>";
		*/
		
		$modules = $core->mm->activemodules;
		if (!$modules->exists($this->action))
			return;
		
		$modules = $core->mm->activemodules;
		
		$mod = $modules->{$this->action};
		/*if (!$mod->haseditor)
			return;*/
		
		$this->Out("subtitle", $mod->title, OUT_AFTER);
		
		$ret = "<div class=\"module\">";
		$ret .= $mod->Render($this);
		return $ret."</div>";
	}

	function RenderTitle() {
		// $ret = "<div align=right><h1 class='action-title'>";
		$ret = $this->lang->modules_title;
		//$ret .= "</h1></div>";
		return $ret;
	}

}
?>