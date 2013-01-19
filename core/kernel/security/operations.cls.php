<?php

class Operations extends collection {

	public function __construct() {
		parent::__construct();
	}
    
    public function __destruct() {
        parent::__destruct();
    }
    
	public function Add(Operation $v) {
		parent::add($v->name, $v);
	}

	public function Merge($from) {
		foreach($from as $value) {
			$this->Add($value);
		}
	}

	private function SplitLevel($levels, $tolevel) {
        $l = array_splice($levels, 0, count($levels));
        $l = array_splice($l, 0, $tolevel+1);
        $s = join(".", $l);
		return $s.".";
	}
	
	private function CreateLevel($parent, $part, $level = 0) {
		$keys = $part->Keys();
		foreach($keys as $k) {
			$kp = preg_split("/\./", $k);
			if(count($kp) > $level + 1) {
				$item = $parent->Add($kp[$level], new Hashtable());
				// $this->CreateLevel($item, $part->Part('preg_match("/'.$this->SplitLevel($kp, $level).'.*/", $key) > 0'), $level+1);
                $sl = $this->SplitLevel($kp, $level);
                $sc = strlen($sl);
                $this->CreateLevel($item, $part->Part('substr($key, 0, '.$sc.') == "'.$sl.'"'), $level+1);
			}
			else
				$item = $parent->Add($kp[$level], $kp[$level]);
		}
	}
	
	public function CreateTree() {
		
		$c = clone $this;
        // $c->Sort();

        $tree = new Hashtable();

        $keys = $c->Keys();

        foreach($keys as $k) {
            $kp = preg_split("/\./", $k);
            if(count($kp) > 1) { 
                $parent = $tree;
                for($i=0; $i<count($kp); $i++) {
                    if(!$parent->Exists($kp[$i]))
                        $parent->Add($kp[$i], $i == count($kp)-1 ? $kp[$i] : new Hashtable());
                    $parent = $parent->Item($kp[$i]);
                    if(!($parent instanceOf Hashtable))
                        break;
                }                    
            }
            else
                $item = $tree->Add($kp[0], $kp[0]);
        }
        
/*
		
		$tree = new Hashtable();

		$keys = $c->Keys();
		foreach($keys as $k) {
			$kp = preg_split("/\./", $k);
			if(count($kp) > 1) {     
                $t = time();
				$item = $tree->Add($kp[0], new Hashtable());
				//$this->CreateLevel($item, $c->Part('preg_match("/'.$kp[0].'\..*'.'/", $key) > 0'), 1);
                $this->CreateLevel($item, $c->Part('substr($key, 0, strlen("'.$kp[0].'")) == "'.$kp[0].'"'), 1);
                out(time() - $t);
                exit;
			}
			else
				$item = $tree->Add($kp[0], $kp[0]);
		}
*/
		return $tree;
		
	}
	
}

class Operation {
	public $name;
	public $description;
	
	public function __construct($name, $description = null) {
		$this->name = $name;
		$this->description = $description;
	}
}


?>