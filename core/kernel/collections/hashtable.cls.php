<?php

class Hashtable extends ListBase {
	
	public function __construct($data = null) {
		parent::__construct();
		
		switch (gettype($data)){
			case "array" :
				foreach($data as $k => $v)
					$this->Add($k, $v);
				break;
			case "object" :
				switch (to_lower(get_class($data))){
					case "collection" : case "arraylist" :
						foreach($data as $k => $v)
							$this->Add($k, $v);
						break;
					default : 
						$this->_data = $data;
						$this->_keys = array_keys(get_object_vars($data));
				}
				break;
			default : return;
		}
	}
	
	public static function Create() {
		$c = func_num_args();
		$args = func_get_args();
		if(count($args) == 0)
			return new Hashtable();
			
		if(is_array($args[0])) {
			$tmp = new Hashtable($args[0]);
		}
		else if(is_object($args[0])) {
				$tmp = new Hashtable($args[0]);
			}
			else {
				$tmp = new Hashtable();
				for($i=0; $i<$c; $i+=2) {
					$tmp->Add($args[$i], $args[$i+1]);
				}
			}
		return $tmp;
	}
	
	public function Data() {
		return $this->_data;
	}
	
	public function Append($list){
		foreach ($list as $k => $v)
			$this->Add($k, $v);
	}
	
	public function Part($expression) {
		$c = new Hashtable();
		foreach($this as $key => $value) {
			$e = "\$b = ".$expression.";";
			eval($e);
			if($b)
				$c->Add($key, $value);
		}
		return $c;
	}
	
	public function Search($value, $key = null){
		$ret = array();
		foreach ($this as $k => $v){
			switch (gettype($v)){
				case "object" :
					if (is_array($key)){
						foreach ($key as $kk)
							if ($v->$kk == $value)
								$ret[] = $v;
					} else {
						if ($key != null)
							if ($v->$key == $value)
								$ret[] = $v;
					}
					break;
				case "array":
					if (is_array($key)){
						foreach ($key as $kk)
							if ($v[$key] == $value)
								$ret[] = $v;
					} else {
						if ($key != null)
							if ($v[$key] == $value)
								$ret[] = $v;
					}
					break;
				default :
					if ($v == $value)
						$ret[] = $v;
					break;
			}
		}

		$count = count($ret);
		if ($count == 0)
			return;

		return ($count > 1) ? $ret : $ret[0];
	}	
	
	
	public function ToString($spl = ",", $kspl = ":", $key = ""){
		if ($this->Count() == 0 || is_empty($spl))
			return "";
			
		$ret = "";
		$i = 0;
		foreach ($this as $k => $v){
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
			$value = str_replace($kspl, "--0123456789--", $value);
			$value = str_replace($spl, "--9876543210--", $value);
			$ret .= ($i == 0 ? "" : $spl).((is_empty($kspl)) ? "" : $k.$kspl).$value;
			$i++;
		}
		return $ret;
	}
	
	public function FromString($data, $spl = ",", $kspl = ":", $callback = ""){
		if (is_empty($data) || is_empty($spl) || is_empty($kspl))
			return $this->Clear();
		
		$dt = explode($spl, $data);
		foreach ($dt as $t){
			$inf = explode($kspl, $t);
			$key = "";
			switch (count($inf)){
				case 0 :
					return;
				case 1 :
					$value = $inf[0];
					break;
				case 2 :
					$key = $inf[0];
					$value = $inf[1];
					break;
			}
			if(!is_empty($key)) {
				$value = str_replace("--0123456789--", $kspl, $value);
				$value = str_replace("--9876543210--", $spl, $value);
				if (!is_empty($callback))
					$value = call_user_func($callback, $inf);
				$this->add($key, $value);
			}
		}
	}
	
	public function NewKey($rel = -1){
		$p = ($rel == -1) ? $this->Count() : $rel;
		if ($this->Exists("k".$p))
			return $this->NewKey($p + 1);
		return "k".$p;
	}
	
	public function FromXML($oXMLDoc) {
	    $firstElement = $oXMLDoc->childNodes;
	    $i = 0;
	    foreach($firstElement as $pair) {
            $key = $pair->childNodes->item(0)->childNodes->item(0)->data;
            $value = $pair->childNodes->item(1)->childNodes->item(0);
            if($value != null) {
                if($value->nodeName == "hashtable") {
                    $v = new Hashtable();
                    $v->FromXML($value);
                    $value = $v;
                }
                else {
                    $value = $value->data;
                }
            }
            $this->Add($key, $value);
	    }
	}	
	
	// alias form FromXML
	public function from_xml($oXMLDoc) {
		$this->FromXML($oXMLDoc);
	}	
	
}

?>