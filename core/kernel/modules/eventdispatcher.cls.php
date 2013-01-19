<?
	
	class IEventDispatcher {
		
		/*events*/		
		public function RegisterEvent($ename){
			global $core;
			
			$core->ed->RegisterEvents($ename);
		}
		
		public function UnregisterEvent($ename){
			global $core;
			
			$core->ed->UnregisterEvents($ename);
		}
		
		public function DispatchEvent($event, $args){
			global $core;

			return $core->ed->Dispatch(new CEvent($this, $event), $args);
		}
		
		/*handlers*/
		public function HandleEvent($ename, $listener){
			global $core;
			$core->ed->AddEventListener($ename, $listener, $this);
		}
		
		public function RemoveHandler($ename, $listener){
			global $core;
			
			$core->ed->RemoveEventListener($ename, $listener);
		}
	}
	
	class CEventDispatcher {
		
		private static $_instance;
		private $_events;
		
		private function CEventDispatcher(){
			$this->_events = new Collection();
		}
        
        public function Dispose() {
            $this->_events->Clear();
        }
		
		public static function Instance() {
			if (!isset(self::$_instance)) {
				$c = __CLASS__;
				self::$_instance = new $c;
			}

			return self::$_instance;
		}
		
		public function __clone() {
			
		}

		function __get($key){
			switch (strtolower($key)){
				default : 
					return;
			}
		}
		
		function __set($key, $value){
			switch (strtolower($key)){
				default : 
					break;
			}
		}
		
		public function RegisterEvents($enames){
			if (is_object($enames))
				return false;
			
			if (!is_array($enames) && !($enames instanceof IteratorAggregate))
				$enames = array($enames);
			
			foreach ($enames as $ename)
				if (!$this->_events->exists($ename))
					$this->_events->add($ename, null);
			
			return true;
		}
		
		public function UnregisterEvents(){
			$args = func_get_args();
			foreach ($args as $ename)
				$this->_events->delete($ename);
		}
		
		public function AddEventListener($ename, $listener = "Dispatch", $object = null){
			
			if (!is_object($object) && is_empty($listener))
					return false;

//			changed by spawn
//			if (!$this->_events->exists($ename))
//				return false;
			
			if (is_object($object)){
				$minfo = new stdClass();
				$minfo->listener = $listener;
				$minfo->object = $object;
			} else {
				if (!is_string($listener))
					return false;
					
				$minfo = $listener;
			}
			
			$e = $this->_events->$ename;
			
			if ($e == null){
				$l = new arraylist();
				$l->add($minfo);
				$this->_events->add($ename, $l);
				return true;
			}
				
			if ($e->contains($minfo))
				return false;
			
			$e->add($minfo);
			
			return true;
		}
		
		public function RemoveEventListener($ename, $listener){
			if (!$this->_events->exists($ename))
				return false;
			
			$e = $this->_events->$ename;
			if ($e == null)
				return false;
			
			return $e->delete($listener);
		}
		
		public function Dispatch($event, $args = null){
			
			if (!($event instanceof CEvent))
				return false;
			
			if (!$this->_events->exists($event->name))
				return false;
			
			$e = $this->_events->Item($event->name);
			if ($e == null)
				return false;
			
			$result = $args;
			foreach ($e as $item){
				if (is_object($item)){
					$object = $item->object;
					$listener = $item->listener;
					if (method_exists($object, @strval($listener))) {
						$result = $object->$listener($event, $result);
					}
				} else {
					if (function_exists(@strval($item)))
						$result = $item($event, $result);
				}
				
				if (!($result instanceof collection) && !($result instanceof Hashtable) )
					throw new Exception("event handlers must return args collection");
				
				if (!$event->propagation)
					break;
			}
			
			return $result;
		}
		
		public function HasEventListener($ename, $listener){
			if (!$this->_events->exists($ename))
				return false;
			
			$e = $this->_events->$ename;
			
			if ($e == null)
				return false;
			
			return $e->exists($listener);
		}
		
		public function RegisteredEvents(){
			if ($this->_events->count() == 0)
				return false;
				
			return $this->_events->keys();
		}
		
		public function RegisteredListeners($ename = ""){
			if ($this->_events->count() == 0)
				return false;
				
			if (is_empty($ename)){
				$keys = $this->_events->keys();
				$listeners = array();
				foreach ($keys as $k){
					$l = $this->RegisteredListeners($k);
					if ($l)
						$listeners = array_merge($listeners, $l->ToArray());
				}
				
				return $listeners;
			} else {
				if (!$this->_events->exists($ename))
					return false;
				
				$e = $this->_events->$ename;
				if ($e == null)
					return false;
				
				return $e->Copy();
			}
		}
	}

?>