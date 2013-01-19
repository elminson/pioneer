<?
             
    class DataReader {
        
        private $_res;
        private $_driver;
        private $_fo;
        private $_affected;
        
        private $_rows;
        private $_fields;
        private $_current;
        
        public function __construct($resource, IDbDriver $driver) {
            $this->_res = $resource;
            $this->_driver = $driver;
            
            $this->_current = 0;
            $this->_rows = $this->_driver->num_rows($this->_res);
            
            $this->_loadFields();
            
        }
        
        public function __get($property) {
            switch($property) {
                case 'affected' :
                    return $this->_affected;
                case 'count':
                    return $this->_rows;
                case 'fields':
                    return $this->_fo;
            }
        }
        
        public function __set($property, $value) {
            switch($property) {
                case 'affected' :
                    $this->_affected = $value;
                    break;
            }
        }
        
        private function _loadFields() {
            $this->_fields = $this->_driver->num_fields($this->_res);
            for($i=0; $i < $this->_fields; $i++) {
                $f = $this->_driver->fetch_field($this->_res, $i);
                $this->_fo[$f->name] = $f;
            }
            $this->_fo = array_change_key_case($this->_fo, CASE_LOWER);
        }
        
        public function __destruct() {
            $this->_driver->free_result($this->_res);
        }
        
        public function Count() {
            return $this->count;
        }
        
        public function HasRows() {
            return $this->_current < $this->_rows;
        }
        
        public function Read($asclass = '') {
            if($this->HasRows()) {
                $this->_current ++;
                if(is_empty($asclass)) $asclass = 'Object';
                return new $asclass($this->_driver->fetch_object($this->_res));
            }
            else
                return false;
        }
        
        public function ReadAll($key = null) {
            $tmp = (is_null($key) ? new arraylist() : new collection());
            while($row = $this->FetchNext()) {
                if(is_null($key))
                    $tmp->add($row);
                else
                    $tmp->add($row->$key, $row);
            }
            return $tmp;
        }
        
        /* alias, for backward compability */
        public function FetchNext($asclass = '') {
            return $this->Read($asclass);
        }
        
        
    }
    

?>
