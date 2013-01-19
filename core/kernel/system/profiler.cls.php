<?php

class Situation extends Object {
	public $profiler;
	
	public function __construct($obj = null) {
		parent::__construct($obj, "situation_");
	}
	
	public function __set($prop, $value){
		parent::__set($prop, $value);
		$this->profiler->user->Save();
	}
}

class Profiler extends Collection {
	
	public $user;
	
	public function __construct($user) {
		parent::__construct();
		$this->user = $user;
	}
	
    public function __get($prop) {

        if(!$this->Exists($prop)) {
            $this->AddSituation($prop);
        }
        
        $v = parent::__get($prop);
        if(!($v instanceof Situation)) {
            $this->Delete($prop);
            $this->AddSituation($prop);
        }
            
        return parent::__get($prop);
    }
    
	public function AddSituation($name) {
		$sit = parent::Add($name, new Situation());
		$sit->profiler = $this;
		$sit->name = $name;
        return $sit;
	}
	
	public function Delete($name) {
		parent::Delete($name);
		$this->user->Save();
	}
	
	public function Merge($from) { deprecate(); }
    
    public function Clear() {
        parent::Clear();
        $this->user->Save();
    }
	
}

?>