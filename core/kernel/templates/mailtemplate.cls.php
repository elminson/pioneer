<?php


/**
	* class template
	*
	* Description for class template
	*
	* @author:
	*/
class mailtemplate extends collection {

	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	function mailtemplate() {
		parent::__construct();
	}
	
	public function apply($template) {
		
		$tmp = $template;
		
		for($i=0; $i < parent::count(); $i++) {
			$tmp = preg_replace("/".preg_quote(parent::key($i))."/", parent::item($i), $tmp);
			//$tmp = str_replace(strtoupper(parent::key($i)), parent::item($i), $tmp);
		}
		
		return $tmp;
	}
}


?>