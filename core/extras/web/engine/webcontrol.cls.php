<?php

class WebControl {
	
	protected $_templateData;
	protected $_controls;
	protected $_name;
	
	public function __construct($name, $templateData = null) {

		$this->_name = $name;
		$this->_controls = new WebControlCollection();

		$this->DispatchEvent("control.creating");
		
		$this->_templateData = $templateData;
		if($this->_templateData instanceof WebTemplate)
			$this->PreCreateControls();
		
		$this->DispatchEvent("control.created");
	}

	protected function PreCreateControls() {
		$this->DispatchEvent("control.controls.loading");
		$this->_templateData->Parse($this);
		$this->DispatchEvent("control.controls.loaded");
	}
	
	public function __get($prop) {
		switch($prop) {
			case "Controls":
				return $this->_controls;
			case "name":
				return $this->_name;
		}
	}

	public function __set($prop, $value) {
//		switch($prop) {
//			case "Controls":
//				return $this->_controls;
//			case "name":
//				return $this->_name;
//		}
	}

	
	static function FromXML($xmlNode) {
		if($xmlNode->nodeType == 4) 
			return new WebLiteralControl("", $xmlNode->data);
		else {
			if($xmlNode->nodeType != 3) {
				if(strtolower($xmlNode->nodeName) == "literal" || $xmlNode->getAttribute("type") == "literal") {
					$name = "Web".($xmlNode->nodeName)."Control";
					$controlName = $xmlNode->getAttribute("name");
					return new $name($controlName, $xmlNode->childNodes->item(0)->data);
				}
				else {
					$name = "Web".($xmlNode->nodeName)."Control";
					$controlName = $xmlNode->getAttribute("name");
					return new $name($controlName, new WebTemplate($xmlNode));
				}
			}
			else {
				return null;
			}
		}
	}
	
	public function DispatchEvent($name, $data = null) {
		if($name instanceof WebEvent)
			$eventObj = $name;
		else
			$eventObj = new WebEvent($name, $data);
		$handler = "__on".str_replace(".", "", $eventObj->name);	
		if(property_exists($this, "__on".$handler)) {
			$this->$handler($eventObj);
		}
		
		if($eventObj->canceled)
			return $eventObj;
		
		if($eventObj->bubbles)
			$eventObj->Bubble($this->_controls);
		
		return $eventObj;
	}
	
	public function Render() {
		$content = "";
		foreach($this->_controls as $control) {
			$content .= $control->Render();
		}
		return $content;
	}
		
	
}

?>