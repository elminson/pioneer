<?php

class Control extends IEventDispatcher {

    static $scriptsRendered;
    
	public $name;
	public $value;
	public $class;
	public $styles;
	public $required;
	public $args;
	public $disabled;
	public $attributes;
	public $values;

	public $lookup;
	public $multilink;
	
	public $message;
	public $isValid;
	
	public $showRequired;

	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		$this->showRequired = true;
		$this->name = $name;
		$this->value = $value;
		$this->class = $className;
		$this->styles = $styles;
		$this->required = $required;
		$this->args = $args;
		$this->values = null;
		$this->isValid = true;
		$this->message = "";
		if(is_null($this->args))
			$this->args = new Collection();
			
		$this->disabled = $this->args->disabled;
		if(is_null($this->disabled))
			$this->disabled = false;
			
		Control::$scriptsRendered = false;
		$this->attributes = $this->args->attributes;
			
	}

    function CheckValue() {
        $this->value = str_replace('</textarea>', '&lt/textarea>', $this->value);
    }
    
    public function RenderScripts($script = "") {
        $b = false;
        eval("\$b = ".get_class($this)."::\$scriptsRendered;");
        if(!$b) {
            eval(get_class($this)."::\$scriptsRendered = true;");
            return $script;
        }
        return "";
    }
	
	public function valueOf() {
		global $core;
        $name = $this->name;
		if(!is_null($core->rq->$name))
			return $core->rq->$name;
		else {
			return null;
		}
	}
	
	public function Render() {
		return "";
	}
	
	protected function RenderSelect() {
		$values = $this->values;
		$result = new Collection();
		$r = explode("\n", $values);
		foreach($r as $v) {
            if(!is_empty(trim($v))) {
			    $v = explode(":", $v);
			    $vv = new stdClass();
			    $vv->id = trim($v[0]);
			    $vv->text = @trim($v[1]);
			    $result->Add(null, $vv);
            }
		}	
		return RenderSelectCheck($this->name, $this->value, "60%", $this->required == 0 ? false : true, $result, "id", "text");
	}
	
	public function Validate() {
		return $this->isValid;
	}
	
}

?>