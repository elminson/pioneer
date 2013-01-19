<?php

/**
	* class path
	*
	* Description for class path
	*
	* @author:
	*/
class path  {

	private $spath;
	private $cpath;

	/**
		* Constructor.  
		*
		* @param 
		* @return 
		*/
	function path() {
		$ks = array_keys($_GET);
		if(count($ks) > 0) {
			$this->spath = $ks[0];
			if(substr($this->spath, strlen($this->spath)-1, 1) == "/")
				$this->spath = substr($this->spath, 0, strlen($this->spath)-1);
			$this->parse();
		}
		else
			$this->cpath = new collection();
	}
	
	public function parse() {
		if(!is_null($this->spath))
			$this->cpath = new collection(explode("/", $this->spath));
		else
			$this->cpath = new collection();
		
	}
	
	public function __get($nm) {
		if($this->cpath->exists($nm)) 
			return $this->cpath->item($nm);
		else
			return null;
	}
	
	public function __set($nm, $val) {
		if($this->cpath->exists($nm)) {
			$this->cpath->add($nm, $val);
		}
	}
	
	public function item($k) {
		return $this->cpath->item($k);
	}
	
	public function last() {
		return $this->cpath->item($this->cpath->count()-1);
	}
	
	public function count() {
		return $this->cpath->count();
	}
	
	public function remove($k) {
		$this->cpath->remove($k);
	}
	
	public function join($c, $sep) {
		$ret = "";
		if($c > $this->cpath->count()) $c = $this->cpath->count()-1;
		for($i=0; $i<$c; $i++) {
			$ret .= $this->cpath->item($i).$sep;
		}
		return $ret;
	}	
	
}

?>