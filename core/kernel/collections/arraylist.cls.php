<?php

class ArrayList extends CollectionBase {
	
	function __construct($data = null){
		// means that the keys is not used
		parent::__construct(false);
		
		switch (gettype($data)){
			case "array" :
				$this->m_Storage = array_values($data);
				break;
			case "string" :
				$this->m_Storage = ArrayList::Create($data);
				break;
			case "object" :
				switch (strtolower(get_class($data))){
					case "collection" : case "arraylist" :
						$this->m_Storage = $data->values();
						break;
					default : 
						$this->m_Storage = array_values(get_object_vars($data));
				}
				break;
			default : return;
		}
	}
	
	function __destruct(){
		self::Clear();
	}
    
    public function __get($prop) {
        switch($prop) {
            case "first":
                return $this->Item(0);
            case "last":
                return $this->Item($this->Count()-1);
            default:
                return false; 
        }
    }
	
	public function Add($value, $index = -1){
		if ($this->_locked)
			return;
			       
		if ($index == -1)
			$this->m_Storage[] = $value;
		else
			if (is_numeric($index))
				$this->m_Storage[$index] = $value;
	}
	
	public function AddRange($values){
		if ($this->_locked)
			return;
			
		$this->m_Storage = array_merge($this->m_Storage, $values);
	}
	
	public function Append($list){
		if ($this->_locked)
			return;
			
		foreach ($list as $v)
			$this->Add($v);
	}
	
	public function Delete($index){
		if ($this->_locked)
			return;
		
		if (!array_key_exists($index, $this->m_Storage)) //!isset($this->m_Storage[$index])
			return;
		
		unset($this->m_Storage[$index]);
		
		$this->m_Storage = array_values($this->m_Storage);
	}
	
	public function DeleteRange($startindex, $count){
		if ($this->_locked)
			return;
			
		array_splice($this->m_Storage, $startindex, $count);
	}
	
	public function Insert($data, $index){
		if ($this->_locked)
			return;
			
		array_splice($this->m_Storage, $index, 0, array($data));
		/*$bpart = array_slice($this->m_Storage, 0, $index);
		$epart = array_slice($this->m_Storage, $index);
		$this->m_Storage = array_merge(array_merge($bpart, $data), $epart);*/
		
		return $this->m_Storage;
	}

	public function IndexOf($value, $strict = true){
		
		$res = array_search($value, $this->m_Storage, $strict);
		if($res === false)
			return false;
		return is_array($res) ? $res[0] : $res;
		// return is_array($res) ? $res : array($res);
		
		/*
		$tcount = $this->Count();
		
		if (is_empty($startindex))
			$startindex = 0;
		
		if (is_empty($count))
			$count = $tcount;
		
		if ($count > $tcount - $startindex) 
			$count = $tcount - $startindex;
		
		for ($i = $startindex; $i < $startindex + $count; $i++){
			switch (gettype($this->m_Storage[$i])){
				case "object" :
					
					if (is_empty($key))
						continue;
						
					if ($this->m_Storage[$i]->$key === $value)
						return $i;
					
					break;
				default :
					if ($this->m_Storage[$i] == $value)
						return $i;
			}
		}
		
		return false;
		*/
	}
    
    public function Map($expressoin) {
    
        for($i=0;$i<$this->Count();$i++) {
            $value = $this->m_Storage[$i];
            eval($expressoin);
            $this->m_Storage[$i] = $value;
        }
        
    }
	
	public function Exists($value, $strict = false){
		return array_search($value, $this->m_Storage, $strict) !== false;
	}
	
	public function Search($key, $value, $strict = false){
		$ret = array();
		foreach ($this as $v){
			switch (gettype($v)){
				case "object" :
					if (($strict) ? @$v->$key === $value : @$v->$key == $value)
						$ret[] = $v;
					break;
				default :
					if (($strict) ? $v === $value : $v == $value)
						$ret[] = $v;
					break;
			}
		}
		
		$count = count($ret);
		if ($count == 0)
			return;
		
		return ($count > 1) ? $ret : $ret[0];
	}
	
	public function Sort($k, $sorttype = SORT_ASC) {
		$keys = array();
		$rows = array();
		foreach ($this->m_Storage as $row) {
			if(is_object($row))
				$keys[] = $row->$k;
			else
				$keys[] = $row[$k];
			$rows[] = $row;
		}
		return array_multisort($keys, $sorttype, $rows, SORT_ASC, $this->m_Storage);
	}
	
	
	/************************/
	
	//depricated
	public function Implode($spl, $key = "", $all = true){
		$data = array();
		
		foreach ($this->m_Storage as $v){
			switch (gettype($v)){
				case "object" :
					if (@$v->$key)
						$data[] = $v->$key;
					break;
				default :
					if ($all)
						$data[] = $v;
					break;
			}
		}
		
		return implode($spl, $data);
	}
	
	public function Reverse(){
		if ($this->_locked)
			return;
			
		$this->m_Storage = array_reverse($this->m_Storage);
	}
    
	public function Fill($value, $count){
		if ($this->_locked)
			return;
			
		$this->m_Storage = array_merge($this->m_Storage, array_fill(0, $count, $value));
	}
	
	public function get_array(){
		return array_merge(array(), $this->m_Storage);
	}
	
	public function Copy(){
		return clone $this;
	}
	
	public function CopyRange($startindex, $count){
		$al = new CArrayList();

		$tcount = count($this->m_Storage);
		if ($count > $tcount - $startindex) 
			$count = $tcount - $startindex;

		$start = $startindex - $tcount;
		$ht->AddRange(array_slice($this->m_Storage, $start, $count));

		return $al;
	}
	
	public function Walk($handler){
		if ($this->_locked)
			return;
		
		$this->m_Storage = array_map($handler, $this->m_Storage);
	}
    
    public function Shuffle() {
        shuffle($this->m_Storage);
    }
	
	public function ToString($spl = ",", $key = ""){
		if (count($this->m_Storage) == 0)
			return "";
			
		$ret = "";
		$count = count($this->m_Storage);
		for ($i = 0; $i < $count; $i++){
			$v = $this->m_Storage[$i];
			switch (gettype($v)){
				case "object" :
					if(method_exists($v, "ToString")) {
						$value = $v->ToString();
					}
					else {
						if($key != "")
							$value = $v->$key;
						else 
							$value = get_class($v);
					}
					break;
				default :
					$value = $v;
			}
			$ret .= (($i == 0) ? "" : $spl).trim($value);
		}
		return $ret;
		//return implode($spl, $this->m_Storage);
	}
	
	public function FromString($data, $spl = ",", $callback = ""){
		if (is_empty($data) || is_null($data))
			return $this->Clear();
			
		$this->m_Storage = explode($spl, $data);
		$count = count($this->m_Storage);
		for ($i = 0; $i < $count; $i++)
			$this->m_Storage[$i] = trim($this->m_Storage[$i]);
		if (!is_empty($callback))
			for ($i = 0; $i < $count; $i++)
				$this->m_Storage[$i] = call_user_func($callback, $this->m_Storage[$i]);
	}
	
	public function FromCollection($c){
		foreach ($c as $item)
			$this->Add($item);
	}
	
	public function FromXML($el) {
	    $childs = $el->childNodes;
	    foreach($childs as $pair) {
            $type = @$pair->childNodes->item(0)->nodeType;
            $n = @$pair->childNodes->item(0);
            $value = null;
            switch ($type){
				case 1 : //element
					$cls = $n->nodeName;
					if (class_exists($cls)){
						$obj = new $cls();
						if (method_exists($obj, "FromXML")){
							$obj->FromXML($pair);
							$value = $obj;
						}
					}
					else {
						$value = unserialize($pair->nodeValue);
					}
					break;
				case 4 :
					$value = $n->childNodes->item(0)->data;
					break;
				case 3 : //text, cdata
					$value = $n->nodeValue;
					break;
				default : //empty
					$value = $n->nodeValue;
			}

			if ($value != null)
				$this->Add($value);
			
	    }
	}
	
	// alias for FromXML
	public function from_xml($el) {
		$this->FromXML($el);
	}
	
	/************************/
	
	public static function Deserialize($data){
		if (!is_empty($data))
			return new arraylist(@unserialize($data));
	}
	
	static function create($data){
		preg_match_all("/([^,]+)/", $data, $matches);
		$data = array();
		for ($i = 0; $i < count($matches[0]); $i++) 
			$data[] = trim($matches[1][$i]);
		return $data;
	}
	// deprecated
	public function Remove($k) {
		deprecate();
		$this->Delete($k);
	}
}

?>