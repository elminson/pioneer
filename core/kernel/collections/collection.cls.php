<?php

class Collection extends CollectionBase {

    public function __construct($arr = array()) {
        parent::__construct(true);
        
        if(!is_array($arr))
            $arr = array();
        
        //$this->m_Storage = array_change_key_case($arr, CASE_LOWER);
        $this->m_Storage = array();
        foreach($arr as $key => $value) {
            $this->m_Storage[to_lower($key)] = $value;
        }
    }

    public function __destruct() {
        if(is_array($this->m_Storage))
            array_splice($this->m_Storage, 0, count($this->m_Storage));
    }

    public function __get($nm)
    {
        switch($nm) {
            case "first":
                return $this->Item(0);
            case "last":
                return $this->Item($this->Count() - 1);
            default:
                if ($this->exists($nm))
                    return $this->item($nm);
                else
                    return NULL;
        }
    }

    public function __set($nm, $val)
    {
        if (isset($this->m_Storage[$this->Key($nm)])) {
            $this->m_Storage[$this->Key($nm)] = $val;
        } else {
            $this->add($nm, $val);
        }
    }

    public function Add($k, $v) {
        if(is_null($k))
            $k = $this->NewKey();
        if(is_string($k))
            $k = to_lower($k);
        $this->m_Storage[$k] = $v;
        return $this->m_Storage[$k];
    }
    
    public function Insert($k, $v, $index) {
        if(is_null($k))
            $k = $this->NewKey();
        if(is_string($k))
            $k = to_lower($k);
        //$this->m_Storage[$k] = $v;
        array_splice($this->m_Storage, $index, 0, array($k => $v));
        return $this->m_Storage[$k];
    }

    public function Delete($k) {
        $index = @$this->Index($k);
        if($index !== false)
            if ($index >= 0 && !is_null($index))
                array_splice($this->m_Storage, $index, 1, array());
    }
    
    public function Merge($from) {
        foreach($from as $key => $value) {
            $this->Add($key, $value);
        }
    }

    public function Append($array1) {
        if(!is_array($array1))
            if(method_exists($array1, "get_array"))
                $array1 = $array1->get_array();
            
        if(!is_array($this->m_Storage))
            $this->m_Storage = array();

        $this->m_Storage = array_merge($this->m_Storage, $array1);
        
    }

    public function Dublicate() {
        $tmp = new collection();
        $tmp->Append($this->m_Storage);
        return $tmp;
    }

    public function Sort($k = null, $sorttype = SORT_ASC) {
        $keys = array();
        $rows = array();
        foreach ($this->m_Storage as $key => $row) {
            if(is_object($row))
                $keys[$key] = is_null($k) ? $key : $row->$k;
            else
                $keys[$key] = is_null($k) ? $key : $row[$k];
            $rows[$key] = $row;
        }
        return array_multisort($keys, $sorttype, $rows, SORT_ASC, $this->m_Storage);
    }
    
    public function Part($expression) {
        $c = new collection();
        foreach($this as $key => $value) {
            $e = "\$b = ".$expression.";";
            eval($e);
            if($b)
                $c->Add($key, $value);
        }
        
        return $c;
    }
    
    public function IndexOfFirst($value) {
        return $this->Index(array_search($value, $this->m_Storage));
    }
    
    public function IndexOf($value, $key = "", $startindex = "", $count = ""){
        $tcount = $this->Count();
        
        if (is_empty($startindex))
            $startindex = 0;
        
        if (is_empty($count))
            $count = $tcount;
        
        if ($count > $tcount - $startindex) 
            $count = $tcount - $startindex;
        
        foreach($this as $k => $v) {
            switch (gettype($v)){
                case "object" :
                    if (is_empty($key))
                        continue;
                    
                    if ($v->$key == $value)
                        return $this->Index($k);
                    
                    break;
                default :
                    if ($v == $value)
                        return $this->Index($k);
            }
        }
        
        return false;
    }
    

    public function Search($value, $key = null, $fromIndex = 0){
        $count = $this->Count();
        if ($fromIndex >= $count)
            return;
        
        $ret = array();
        //foreach ($this as $k => $v){
        for ($i = $fromIndex; $i < count($this->m_Storage); $i++){
            $k = $this->Key($i);
            $v = $this->Item($i);
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

    public function NewKey($rel = -1){
        $p = ($rel == -1) ? count($this->m_Storage) : $rel;
        if (array_key_exists("k".$p, $this->m_Storage))
            return $this->NewKey($p + 1);
        return "k".$p;
    }
        
    public static function Deserialize($data){
        if (!is_empty($data))
            return new Collection(@unserialize($data));
    }
    
    public static function Create() {
        $c = func_num_args();
        $args = func_get_args();
        if(count($args) == 0)
            return new collection();
        
        if(is_array($args[0])) {
            $tmp = new collection($args[0]);
        }
        else if(is_object($args[0])) {
                $tmp = new collection();
                $tmp->from_object($args[0] instanceOf Object ? $args[0]->Data() : $args[0]);
            }
            else {
                $tmp = new collection();
                for($i=0; $i<$c; $i+=2) {
                    $tmp->Add($args[$i], $args[$i+1]);
                }
            }
        return $tmp;
    }

#region "Converting function"    

    public function ToArray(){
        return $this->m_Storage;
    }
    
    //alias for ToArray
    public function get_array(){ return $this->ToArray(); }
    
    public function FromArray($row) {
        $row = array_change_key_case($row, CASE_LOWER);
        $keys = array_keys($row);
        for($i=0; $i<count($row);$i++) {
            $k = (is_int($keys[$i])) ? "k".$keys[$i] : $keys[$i];
            $this->m_Storage[$k] = $row[$i];
        }
    }
    
    //alias for FromArray
    public function set_array($row) { $this->FromArray($row); }
    
    public function FromObject($obj, $clear = false) {
        if ($clear)
            $this->Clear();
            
        $class_vars = get_object_vars($obj);
        foreach ($class_vars as $name => $value) {
            $this->Add($name, $value);
        }
        $this->m_Storage = array_change_key_case($this->m_Storage, CASE_LOWER);
    }
    
    // alias for FromObject
    public function from_object($obj, $clear = false) { $this->FromObject($obj, $clear); }
    
    public function ToObject(){
        $obj = new stdClass();
        foreach ($this->m_Storage as $k => $v)
            $obj->$k = $v;
        
        return $obj;
    }
    
    // alias for ToObject
    public function to_object(){ return $this->ToObject(); }    
    
    public function ToString($spl = ",", $kspl = ":", $key = ""){
        if (count($this->m_Storage) == 0 || is_empty($spl))
            return "";
            
        $ret = "";
        $i = 0;
        foreach ($this as $k => $v){
            switch (gettype($v)){
                case "object" :
                    $value = $v->$key;
                    break;
                default :
                    $value = $v;
            }
            $ret .= (($i == 0) ? "" : $spl).((is_empty($kspl)) ? "" : $k.$kspl).$value;
            $i++;
        }
        return $ret;
    }
    
    public function FromString($data, $spl = ",", $kspl = ":", $callback = ""){
        if (is_empty($data) || is_empty($spl) || is_empty($kspl))
            return $this->Clear();
        
        $value = '';
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
            
            if (!is_empty($callback))
                $value = call_user_func($callback, $inf);
            $this->add((is_empty($key)) ? $this->NewKey() : $key, $value);

        }
    }
    
    public function FromXML($oXMLDoc) {
        $firstElement = $oXMLDoc->childNodes;
        $i = 0;
        foreach($firstElement as $pair) {
            $key = $pair->childNodes->item(0)->childNodes->item(0)->data;
            $value = $pair->childNodes->item(1)->childNodes->item(0);
            if($value != null) {
                if($value->nodeName == "collection") {
                    $v = new collection();
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
    public function from_xml($oXMLDoc) { $this->FromXML($oXMLDoc); }

#endregion    

    
    
}

?>