<?php

define("WEB_TEMPLATE_FILE", 0);
define("WEB_TEMPLATE_STRING", 1);



class WebTemplate {
	
	private $_documentElement = null;
	private $_templateData = null;
	private $_templateString = null;
	
	public function __construct($templateData = "", $type = WEB_TEMPLATE_STRING) {
		if(is_string($templateData)) {
			$this->_templateData = new DomDocument();
			if($type == WEB_TEMPLATE_STRING) {
				$this->_templateString = $templateData;
				$this->_templateData->loadXML($templateData);
			}
			else {
				$this->_templateString = file_get_contents($templateData);
				$this->_templateData->load($templateData);
			}
			$this->_documentElement = $this->_templateData->documentElement;
		}
		else { 
			$this->_documentElement = $templateData;
			$this->_templateData = $this->_documentElement->ownerDocument;
			$this->_templateString = null;
		}
	}
	
	public function __get($prop) {
		switch($prop) {
			case "documentElement":
				return $this->_documentElement;
			case "document":
				return $this->_templateData;
			case "xml":
				return $this->_templateString;
		}
	}
	
	public function Parse($control) {
		$params = $this->_documentElement->getElementsByTagName("params")->item(0);
		$data = $this->_documentElement->getElementsByTagName("children")->item(0);
		
		if($params) {
			$paramsChildren = $params->childNodes;
			foreach($paramsChildren as $value) {
				if($value->nodeType == 1) {
					$name = $value->tagName;
					$control->$name = $value->childNodes->item(0)->data;
				}
			}
		}
		if($data) {		
			$dataChildren = $data->childNodes;
			foreach($dataChildren as $c) {
				$class = WebControl::FromXML($c);
				if($class)
					$control->Controls->Add($class);
			}
		}		
	}
	
	public function AttachChildren($webTemplate) {
		$frag = $this->_templateData->createDocumentFragment();
		if(is_string($webTemplate))
			$frag->appendXML("<children>".$webTemplate."</children>");
		else
			$frag->appendXML($webTemplate->xml);
		$this->_documentElement->appendChild($frag);
	}
	
}

?>