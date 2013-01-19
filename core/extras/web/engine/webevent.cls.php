<?php

class WebEvent {
		
	private $_event;
	private $_data;
	private $_bubbles;
	private $_canceled;
	private $_returnValue;
		
	public function __construct($event, $data) {
		$this->_event = $event;
		$this->_data = $data;
		$this->_bubbles = true;
		$this->_canceled = false;
		$this->_returnValue = null;
	}
	
	public function CancelBubble() {
		$this->_bubbles = false;
	}
	
	public function CancelEvent() {
		$this->_canceled = true;
	}
		
	public function __get($property) {
		switch($property) {
			case "name":
				return $this->_event;
			case "data":
				return $this->_data;
			case "canceled":
				return $this->_canceled;
			case "bubbles":
				return $this->_bubbles;
			case "returnValue":
				return $this->_returnValue;
		}
		return null;
	}	
	
	public function __set($property, $value) {
		switch($property) {
			case "name":
				global $WEB__EVENTS;
				if(in_array($value, $WEB__EVENTS))
					$this->_event = $value;				
				else
					trigger_error("Event not found in the global web events list.", E_WARNING);
			case "data":
				$this->_data = $value;
			case "canceled":
				if(is_bool($value))
					$this->_canceled = $value;
				else	
					trigger_error("Invalid value for this property.", E_WARNING);
			case "bubbles":
				if(is_bool($value))
					$this->_bubbles = $value;
				else
					trigger_error("Invalid value for this property.", E_WARNING);	
			case "returnValue":
				$this->_returnValue = $value;
		}
	}  
	
	public function Bubble($objects) {
		foreach($objects as $object) {
			if(method_exists($object, "DispatchEvent")) {
				$object->DispatchEvent($this);
				if($this->canceled)
					break;
			}
		}
	}	
}

?>