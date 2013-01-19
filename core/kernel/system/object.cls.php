<?

class Object extends IEventDispatcher {
	
	protected $_data;
    protected $_original;
    
	protected $_prefix = "";
	
	public function __construct($data = null, $prefix = "") {
		if(is_null($data))
			$this->_data = new stdClass();
		else {
			if($data instanceof Object) {
				$this->_data = $data->Data();
				$this->_prefix = $data->prefix;
			}
			else 
				$this->_data = $data;
		}
        
        if($this->_data)
            $this->_data = (object)array_change_key_case((array)$this->_data);

		if($prefix != '' && substr($prefix, strlen($prefix)-1, 1) != "_") $prefix = $prefix."_";
		$this->_prefix = $prefix;
		
		if(!is_empty($this->_prefix)) {
			// crop the object to match prefix
			$this->_data = crop_object_fields($this->_data, '/'.$this->_prefix.'/');
		}
        
        $this->_original = clone($this->_data);
		
	}
    
    public function __destruct() {
        unset($this->_data);
    }
    
	public function fname($name){
		return $this->_prefix.$name;
	}
	
	public function fromfname($name){
		return substr($name, strlen($this->_prefix));
	}

	public function Clear() {
		$this->_data = new stdClass();
	}
	
	public function __get($nm) {
        
        $nm = strtolower($nm);
        
		if($nm == "self")
			return $this;
			
		if($nm == "prefix")
			return $this->_prefix;
		
        if($nm == "original")
            return $this->_original;
        
		if($this->_prefix != '' && strpos($nm, $this->_prefix) === false) {
			$nm = $this->_prefix.$nm;
		}
		
		return $this->TypeExchange($nm, TYPEEXCHANGE_MODE_GET);

    }
	
	public function __set($nm, $value) {
		if(@strpos($nm, $this->_prefix) === false)
			$nm = $this->_prefix.$nm; // || strpos($nm, $this->_prefix) > 0
			
		$this->TypeExchange($nm, TYPEEXCHANGE_MODE_SET, $value);
	}
	
	protected function TypeExchange($prop, $mode = TYPEEXCHANGE_MODE_GET, $value = null) {
		if($mode == TYPEEXCHANGE_MODE_GET)
			return @$this->_data->$prop;
		else
			@$this->_data->$prop = $value;
	}
	
    public function isPropertyChanged($property) {
        $property = $this->fname($property);
        return @$this->_data->$property != @$this->_original->$property;
    }
    
	public function Delete($nm) {											    
		$nm = $this->_prefix.$nm;
		unset($this->_data->$nm);
	}
	
	public function Data() {
		return $this->_data;
	}
	
	public function ToCollection($withprefis = true) {
		if($withprefis)
			return Collection::Create($this->_data);
		else {
			$ret = new Collection();
			$arr = get_object_vars($this->_data);
			foreach($arr as $key => $value)
				$ret->Add($this->fname($key), $value);
			return $ret;
		}
	}
	
	public function ToArray($withprefix = true) {
		if($withprefix)
			return get_object_vars($this->_data);
		else {
			$ret = array();
			$arr = get_object_vars($this->_data);
			foreach($arr as $key => $value)
				$ret[$this->fname($key)] = $value;
			return $ret;
		}
	}
	
	public function ToXMLAttribute($props = array()) {
		$ret = "";
		foreach($props as $prop) {
			$ret .= ' '.$prop.'="'.$this->$prop.'"';
		}
		return $ret;
	}
	
	public function ToXMLNode($document, $nodeName = "object", $propsToAttribute = array(), $tocdata = array(), $exception = array()) {
		$frag = $document->createDocumentFragment();
		$frag->appendXML($this->ToXML($nodeName, $propsToAttribute, $tocdata, $exception));
		return $frag;
	}
	
	public function ToXML($nodeName = "object", $propsToAttribute = array(), $tocdata = array(), $exception = array()) {
		$attrs = $this->ToXMLAttribute($propsToAttribute);
		$ret = '<'.$nodeName.(!is_empty($attrs) ? ' '.$attrs : '').' prefix="'.$this->_prefix.'">';
		$array = $this->ToArray(false);
		foreach($array as $key => $value) {
			if(!in_array($key, $propsToAttribute) && !in_array($key, $exception)) {
				if(is_object($value)) {
					if(method_exists($value, "ToXML"))
						$value = $value->ToXML();
					else
						$value = '<'.$key.' state="serialized"><![CDATA['.serialize($value).']]></'.$key.'>';
					
					$ret .= $value;
				} 
				else if(is_array($value)) {
					$ret .= '<'.$key.' state="serialized"><![CDATA['.serialize($value).']]></'.$key.'>';
				}
				else {
					$value = load_from_file($value);
					if(in_array($key, $tocdata))
						$value = '<![CDATA['.$value.']]>';
					$ret .= '<'.$key.'>'.$value.'</'.$key.'>';
				}
			}
		}
		$ret .= '</'.$nodeName.'>';
		return $ret;
	}
	
	public function FromXMLAttributes($node) {
		$attributes = $node->attributes;
		foreach($attributes as $attribute) {
			$name = $attribute->nodeName;
			$value = $attribute->nodeValue;
			if($name != "prefix")
				$this->$name = $value;
		}
	}
	
	public function FromXML($node){
		$this->Clear();

		$this->_prefix = $node->getAttribute("prefix");
		$this->FromXMLAttributes($node);
		
		$nodes = $node->childNodes;
		foreach($nodes as $pair) {
			$name = $pair->nodeName;
			$type = $pair->childNodes->item(0)->nodeType;
			$value = null;
			switch($type) {
				case 1: // element i.e. object
					if($pair->getAttribute("serialized") !== false) {
						$value = unserialize($pair->childNodes->Item(0)-data);
						break;
					}
					$className = $pair->nodeName;
					if(class_exists($className)) {
						@$o = new $className();
						if(!$o)
							$o = new Object(null, $pair->getAttribute("prefix"));
					}
					else
						$o = new Object(null, $pair->getAttribute("prefix"));
						
					$value = $o->FromXML($pair);
					break;
				case 3: // text node
					$value = $pair->nodeValue;
					break;
				case 4: // cdata section
					$value = $pair->childNodes->item(0)->data;
					break;
				default:
					break;
			}
			$this->$name = $value;
		}
		
	}
	
	public function ToCreateScript($objectname, $proplist = array(), $exclude = array(), $newparams = array(), $class = null) {
		if(is_null($class))
			$class = get_class($this);
		$cf = "\n";
		$tab = "\t";
		$string = '';
		$string .= $tab.'$'.$objectname.' = new '.$class.'('.implode(',', $newparams).');'.$cf;
		$array = $this->ToArray(false);
		foreach($array as $prop => $value) {
			if((array_search($prop, $proplist) !== false || count($proplist) == 0) && array_search($prop, $exclude) === false) {
				$value = $this->_ValueToString($value);
				$string	.= $tab.$tab.'$'.$objectname.'->'.$prop.' = '.$value.';'.$cf;
			}
		}
		$string .= $tab.'$'.$objectname.'->Save();'.$cf;
		return $string;
	}
	
	private function _ValueToString($value) {
		if(is_null($value))
			return 'null';
		
		$type = gettype($value);
		switch($type) {
			case "string":
				return '"'.db_prepare(load_from_file($value)).'"';
			case "int":
				return $value;
			case "boolean":
				return $value ? 'true' : 'false';
			case "object":
				return null;
		}
	}

    public function Serialize() {
        $std = new stdClass();
        $std->className = get_class($this);
        $std->data = $this->_data;
        $std->prefix = $this->_prefix;
        return _serialize($std);
    }
    
    public static function Unserialize($data) {
        $data = @_unserialize($data);
        if(!$data)
            return new Object();
        
        if(!is_null(@$data->className) && class_exists($data->className)) {
            eval('$o = new '.$data->className.'($data->data, $data->prefix);');
        }
        else 
            $o = new Object($data->data, $data->prefix);
        
        return $o;
    }
	
	/* default aliases */
	public function to_xml(){
        deprecate();
		return $this->ToXML();
	}
	public function from_xml($el){
        deprecate();
		$this->FromXML($el);
	}
	public function from_collection($col) { 
        deprecate();
		return $this->FromCollection($col); 
	}
	public function get_collection() {
        deprecate();
		return $this->ToCollection();
	}

}

class XmlBased {
	
	protected $_data;
	protected $_document;
	
	public function __construct(&$document, $data = "xmlobject") {
		$this->_document = $document;
		$this->_data = is_string($data) ? $this->_document->createElement($data) : $data;
	}
    
    public function __destruct() {
        unset($this->_data);
    }
	
	public function __get($nm) {
		
		if($nm == "self")
			return $this;
		
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);
		
		if($data->hasAttribute($nm))
			return $data->getAttribute($nm);
		
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm)
					return $child->nodeValue;
		}
		return null;			
	}
	
	public function __set($nm, $value) {
		if($nm == "self")
			return;
		
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);

		if($data->hasAttribute($nm))
			$data->setAttribute($nm, $value);
		
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm) {
					if($value instanceof XmlBased)
						$child->appendChild($this->XmlToNode($value->ToXML()));
					else
						$child->nodeValue = $value;
					return;
				}
		}
		
		if($value instanceof XmlBased) {
			$data->appendChild($this->XmlToNode($value->ToXML()));
		}
		else {
			$newel = $this->_document->createElement($nm);
			$newel->nodeValue = $value;
			$data->appendChild($newel);
		}
		
	}
	
	public function Item($nm) {
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);
		
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm)
					return $child;
		}
		return null;			
	}
	
	public function Attribute($nm, $value) {
		$this->_data->setAttribute($nm, $value);
	}
	
	public function Delete($nm) {
	
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);

	
		if(!is_null($data->getAttribute($nm)))
			$data->removeAttribute($nm);
			
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm)
					$data->removeChild($child);
		}
	}
	
	public function Data() {
		return $this->_data;
	}
	
	public function ToXML() {
		return $this->_document->saveXML($this->_data);
	}
	
	public function FromXML($el){
		$this->_data = $el;
	}
	
	public function XmlToNode($string) {
		$frag = $this->_document->createDocumentFragment();
		$frag->appendXML($string);
		return $frag;
	}
    
}


?>
