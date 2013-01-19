<?php

/**
	* class ob
	*
	* Description for class ob
	*
	* @author:
	*/
class ob  {

	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	function ob() {
		
	}
	
	function __destruct() {
		global $core;
		if($core) {
			if($core->obenabled) {
				if($this->length() > 0)
					ob_end_flush();
			}
		}
	}
	
    public function Dispose() {
        
    }
    
	public function Initialize(){
		global $core;
		
		$handler = $this->getencodinghandler();
		
		if($core->obenabled) {
			if(!is_null($handler))
				ob_start($handler);
			else
				ob_start();
		}
	}
	
	public function getencodinghandler() {
		global $core;
		switch($core->obenconding) {
			case 'gzip':
				return 'ob_gzhandler';
			default:
				return null;
		}
	}
	
	public function flush() {
		ob_flush();
	}
	
	public function get($end = true) {
		$tmp = ob_get_contents();
		if($end)
			ob_end_clean();
		return $tmp;
		
	}
	
	public function length() {
		return ob_get_length();
	}
	
	public function clear() {
		ob_clean();
	}
}

?>