<?


class CollectionBaseIterator implements Iterator {
	private $_class;
	private $_current = 0;
	
	public function __construct($class = null) {
		$this->_class = $class;
	}
	
	public function rewind() {
		$this->_current = 0;
		if(method_exists($this->_class, "Key"))
			return $this->_class->Key($this->_current);
		else
			return $this->_current;
	}
	
	public function current() {
		if($this->valid())
			return $this->_class->Item($this->_current);
		else	
			return false;
	}
	
	public function key() {
		if(method_exists($this->_class, "Key"))
			return $this->_class->Key($this->_current);
		else
			return $this->_current;		
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


class CollectionBase implements IteratorAggregate {
	
	protected $m_Storage;
	protected $_keyPair = false;
	
	protected $_locked = false;
	
	public function __construct($keyPair = false) {
		$this->_keyPair = $keyPair;
		$this->m_Storage = array();
	}
	
    public function Dispose() {
        array_splice($this->m_Storage, 0, 0);
    }
	
	public function getIterator() {
		return new CollectionBaseIterator($this);
	}
	
	public function Index($key) {
		if(is_string($key)) {
			$key_index = array_keys(array_keys($this->m_Storage), to_lower($key));
			return is_null(@$key_index[0]) ? false : @$key_index[0];
		}
		else
			return $key;
	}
	
	public function Key($index) {
		if(!$this->_keyPair)
			return $index;
		else {
			switch(gettype($index)) {
				case "integer":
					if(is_array($this->m_Storage)) {
						$keys = array_keys($this->m_Storage);
						if($index < count($keys))
							return to_lower($keys[$index]);
						else
							return null;
					}
					else
						return null;
				case "string":
					return to_lower($index);
					break;
				default:
					return "";
					break;
			}
		}
	}
	
	public function Item($index) {
        return @$this->m_Storage[$this->Key($index)];
	}
	
	public function First() {
		if($this->Count() > 0)
			return $this->Item(0);
		return false;
	}
	
	public function Last() {
		if($this->Count() > 0)
			return $this->Item($this->Count() - 1);
		return false;
	}
	
	public function Exists($key) {
		if(is_string($key))
			$key = to_lower($key);
		else
			$key = $this->Key($key);
		return @array_key_exists($key, $this->m_Storage);
	}

	public function Contains($value){
		return in_array($value, $this->m_Storage);
	}
	
	public function Keys() {
		return array_keys($this->m_Storage);
	}
	
	public function Items() {
		return array_values($this->m_Storage);
	}

	public function Clear() {
		if($this->_locked)
			return;
		@array_splice($this->m_Storage, 0, count($this->m_Storage));
	}
	
	public function Count() {
		$c = count($this->m_Storage);
		if(empty($c))
			return 0;
		return (int)$c;
	}
	
	public function IsEmpty() {
		return $this->Count() == 0;
	}
	
	public function ToArray(){
		return array_merge(array(), $this->m_Storage);
	}
	
	public function Serialize(){
		return serialize($this->m_Storage);
	}
	
	public function Lock(){
		$this->_locked = true;
	}
	
	public function Unlock(){
		$this->_locked = false;
	}
	
	public function ToXML() {
		$tagName = to_lower(get_class($this));
		$ret = "<".$tagName.">";
		foreach($this->m_Storage as $key => $value) {
			
			if(is_object($value)) {
				if(method_exists($value, "ToXML"))
					$value = $value->ToXML();
				else {
					$value = @serialize($value);
				}
			}
			else
				$value = prepare_attribute(htmlspecialchars($value));
			
			if($this->_keyPair)
				$ret .= "<pair><key>".$key."</key><value>".$value."</value></pair>";
			else
				$ret .= "<value>".$value."</value>";
		}
		
		$ret .= "</".$tagName.">";
		return $ret;
	}
	
	// alias for ToXml
	public function to_xml() {
		return $this->ToXml();
	}
    
    public function Shuffle() {
        shuffle($this->m_Storage);
    }
	
}

?>