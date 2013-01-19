<?

	class CEvent {
		
		private $_sender;
		private $_name;
		protected $_propagation;
		
		function CEvent($sender, $name){
			$this->_sender = $sender;
			$this->_name = $name;
			$this->_propagation = true;
		}
		
		function __get($key){
			switch (strtolower($key)){
				case "name" :
					return $this->_name;
				case "propagation" :
					return $this->_propagation;
				case "sender" :
					return $this->_sender;
				default : 
					return $this->getProperty($key);
			}
		}
		
		function __set($key, $value){
			switch (strtolower($key)){
				default : 
					$this->setProperty($key, $value);
					break;
			}
		}
		
		public function StopPropagation(){
			$this->_propagation = false;
		}
		
		public function Bubble($target, $method = "Dispatch", $args = null){
			if (!is_object($target))
				if (is_empty($target) || !function_exists(@strval($target)))
					return false;
				else
					return $target($this, $args);
					
			if (method_exists($target, @strval($method)))
				return $target->$method($this, $args);
		}
		
		public function Dispose(){
			unset($this);
		}
		
		protected function getProperty($key){
			return;
		}
		
		protected function setProperty($key, $value){
			return;
		}
	}
	
?>