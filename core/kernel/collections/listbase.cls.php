<?php

class ListIterator implements Iterator {
	
	private $_class;
	private $_current = 0;
	
	public function __construct($class = null) {
		$this->_class = $class;
	}
	
	public function rewind() {
		$this->_current = 0;
		return $this->_class->Key($this->_current);
	}
	
	public function current() {
		if($this->valid())
			return $this->_class->Item($this->_current);
		else	
			return false;
	}
	
	public function key() {
		return $this->_class->Key($this->_current);
	}
	
	public function next() {
		$this->_current++;
		if($this->valid())
			return $this->_class->Item($this->_current);
		else	
			return false;
	}
	
	public function valid() {
		return $this->_current >= 0 && $this->_current < $this->_class->Count();
	}

}

class ListBase implements IteratorAggregate {
	
	protected $_data;	// stdClass based
	protected $_keys;
	
	public function __construct() {
		$this->_data = new stdClass();
		$this->_keys = array();
	}
	
	public function __get($key) {
        switch($key) {
            case 'count':
                return $this->Count();
            case 'first':
                return $this->Item(0);
            case 'last':
                return $this->Item($this->Count() - 1);
            default: 
                return $this->Item($key); 
        }
	}
	
	public function __set($key, $value) {
		$this->Add($key, $value);
	}
	
	public function Keys() {
		return $this->_keys;
	}
	
	public function Clear() {
        
        foreach($this->_keys as $k)
            unset($this->_data->$k);
		$this->_data = new stdClass();
		array_splice($this->_keys, 0, count($this->_keys));
		
	}
	
	public function Contains($value){
		$array = get_object_vars($this->_data);
		return in_array($value, $array);
	}
	
	public function Key($index) {
		if(is_integer($index)) {
			$keys = @$this->Keys();
			if($index >= 0 && $index < count($keys))
				return $keys[$index];
			return false;
		}
		else 
			return to_lower($index);
	}
	
	public function Items() {
		$ret = array();
		$keys = $this->Keys();
		foreach($keys as $k) {
			$ret[] = $this->Item($k);
		}
		return $ret;
	}
	
	public function Exists($key) {
		return in_array(to_lower($key), $this->_keys);
	}
	
	public function Item($key) {
		$key = $this->Key($key);
		if(!$this->Exists($key))
			return false;
		return $this->_data->$key;
	}
	
	public function Add($key, $value) {
        if(is_null($key))
            iout($key, $value, debug_backtrace());
		$key = $this->Key($key);
		$this->_data->$key = $value;
		if(!$this->Exists($key))
			$this->_keys[] = $key;
		
		return @$this->_data->$key;
	}
	
	function Delete($key) {
		if(is_numeric($key))
			$key = $this->Key($key);
		if($this->Exists($key)) {
			unset($this->_data->$key);
			array_splice($this->_keys, array_search($key, $this->_keys), 1);
		}
	}
	
	public function Count() {
		return count($this->_keys);
	}
	
	public function getIterator() {
		return new ListIterator($this);
	}
	
	public function ToXML() {
		$tagName = to_lower(get_class($this));
		$ret = "<".$tagName.">";
		$ar = get_object_vars($this->_data);
		foreach($ar as $key => $value) {
			if(is_object($value)) {
				if(method_exists($value, "ToXML"))
					$value = $value->ToXML();
				else {
					$value = @serialize($value);
				}
			}
			else
				$valuse = prepare_attribute(htmlspecialchars($value));
			
			$ret .= "<pair><key>".$key."</key><value>".$value."</value></pair>";
		}
		
		$ret .= "</".$tagName.">";
		return $ret;
	}
	
	// alias for ToXml
	public function to_xml() {
		return $this->ToXml();
	}	
}

?>