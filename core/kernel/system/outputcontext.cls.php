<?php

class OutputBlock {
	
	private $_content;
	private $_name;
	
	public function __construct($name) {
		$this->_name = $name;
		$this->_content = new ArrayList();
	}
	
	public function __get($property) {
		switch($property) {
			case "name":
				return $this->_name;
			case "content": 
				return $this->ToString("");
			case "empty":
				return $this->_content->Count() == 0;
		}
	}
	
	public function Out($content) {
		$this->_content->Add($content);
	}
	
	public function Clear() {
		$this->_content->Clear();
	}

	private function ToString() {
		$ret = "";
		foreach($this->_content as $str) {
			$ret .= $str;
		}
		return $ret;
	}
	
}

class OutputContext {
	
	private $_name;
	private $_content;
	private $_currentblock;
	
	public function __construct($name = null, $type = CONTEXT_STANDART) {
		$this->_name = $name;
		$this->_content = new Collection();
		$this->_currentblock = null;
	}
	
	public function Test() {
		out($this->_content->Keys());
	}
	
	public function __get($property) {
		switch($property) {
			case "name":
				return $this->_name;
			case "content": 
				return $this->ToString();
			case "empty":
				return $this->_content->Count() == 0;
			default: 
				if($this->_content->Item($property) instanceof OutputBlock)
					return $this->_content->Item($property)->content;
				else
					return $this->_content->Item($property);
		}
	}
	
	public function GetBlock($name) {
		return $this->_content->Item($name);
	}
	
	private function ToString() {
		$ret = "";

		foreach($this->_content as $str) {
			if($str instanceof OutputBlock) {
				$ret .= $str->content;
			}
			else {
				$ret .= $str;
			}
		}

		return $ret;
	}
	
	public function Out($content, $block = null) {
		if(is_null($block) && !is_null($this->_currentblock))
			$block = $this->_currentblock;
		
		if(!is_null($block)) {
			if($this->_content->Exists($block))
				$b = $this->_content->$block;
			else
				$b = new OutputBlock($block);
			$b->Out($content);
			
			$this->_content->Add($block, $b);
		}
		else {
			$this->_content->Add($block, $content);
		}
		
	}
	
	public function Roolback($block = null) {
		if(is_null($block))
			return;
		$out = $this->$block;
		$this->_content->Delete($block);
		return $out;
	}
	
	public function RoolbackLast() {
		$block = $this->_content->Key($this->_content->Count()-1);
		$out = $this->$block;
		$this->_content->Delete($block);
		return $out;
	}

	public function Clear() {
		$this->_content->Clear();
	}
	
	public function StartBlockOutput($block) {
		$this->_currentblock = $block;
	}

	public function EndBlockOutput() {
		$this->_currentblock = null;
	}

}

?>
