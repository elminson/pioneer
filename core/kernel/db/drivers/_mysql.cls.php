<?php

    require_once('driver.int.php');
    
    class MySqlDriver implements IDbDriver {
        
        public static $types = array(
            'longvarchar' => 'VARCHAR(255)',
            'mediumvarchar' => 'VARCHAR(100)',
            'shortvarchar' => 'VARCHAR(50)',
            'varchar3' => 'VARCHAR(3)',
            'varchar2' => 'VARCHAR(2)',
            'bigint' => 'BIGINT(20)',
            'real' => 'FLOAT(27,3)',
            'datetime' => 'datetime',
            'timestamp' => 'timestamp',
            'boolean' => 'tinyint(1)',
            'longtext' => 'LONGTEXT',
            'mediumtext' => 'MEDIUMTEXT',
            'tinytext' => 'TINYTEXT',
            'blob' => 'LONGBLOB',
            'autoincrement' => 'BIGINT'
        );
        
        private $_connection;
        private $_resourceCache;
        private $_queryCache;
        
        private $_server;
        private $_user;
        private $_password;
        private $_database;    
        private $_persistence;
        
        public function __construct() {
            $this->_resourceCache = array();
            $this->_queryCache = array();
        }
        
        public function __get($property) {
            switch($property) {
                case 'database':
                    return $this->_database;
                case 'server':
                    return $this->_server;
                case 'user':
                    return $this->_user;
                case 'password':
                    return $this->_password;
                case 'connection':
                    return $this->_connection;
                case 'queryCache':
                    return $this->_queryCache;
                case 'resourceCache':
                    return $this->_resourceCache;
            }
        }
        
        public function Connect($server, $user, $password, $database, $persistence = true) {
            if(!empty($server)) {
                
                $this->_server = $server;
                $this->_database = $database;
                $this->_user = $user;
                $this->_password = $password;
                $this->_persistence = $persistence;
                            
                if($persistence)
                    $this->_connection = mysql_pconnect($server, $user, $password) or die("Could not connect to server: ".$this->Error());
                else                
                    $this->_connection = mysql_connect($server, $user, $password) or die("Could not connect to server: ".$this->Error());
                
                mysql_select_db($database, $this->_connection) or die("Could not connect from database: ".$this->Error());
                
                $this->Query("set names utf8");
                $this->Query("set character_set_client='utf8'");
                $this->Query("set character_set_results='utf8'");
                $this->Query("set collation_connection='utf8_unicode_ci'");
                
            }            
        }
        
        public function Disconnect() {
            foreach($this->_resourceCache as $resource) {
                @mysql_free_result($resource);
            }                       
            @mysql_close($this->_connection);
            unset($this->_resourceCache);
            $this->_resourceCache = array();
        }
        public function fetch_object($resource) {
            return mysql_fetch_object($resource);
        }
        public function fetch_array($resource) {
            return mysql_fetch_array($resource);
        }
        public function fetch_field($resource, $index) {
            return mysql_fetch_field($resource, $index);
        }
        public function num_rows($resource) {
            return mysql_num_rows($resource);
        }
        public function num_fields($resource) {
            return mysql_num_fields($resource);
        }
        public function insert_id($tablename = "") {
            $q = "SELECT LAST_INSERT_ID() as id";
            $r = $this->Query($q);
            $rr = $this->fetch_object($r);
            return $rr->id;
        }
        public function affected($resource) {
            return mysql_affected_rows($resource);
        }        
        public function free_result($resource) {
            mysql_free_result($resource);
        }
        public function excape_string($string) {
            return mysql_real_escape_string($string);
        }

        public function CreateCountQuery($query) {
            return "select count(*) as cnt from (".$query.") devtbl";
        }
        
        public function AppendLimitCondition($query, $page, $pagesize) {
            return $query." LIMIT ".(($page-1)*$pagesize).", ".$pagesize;
        }
        
        public function Query($query) {
            global $SERVICE_MODE;
            
            $time = microtime(true);

            $tmp = @mysql_query($query, $this->_connection);
            
            $time = (microtime(true) - $time)*1000;

            if($SERVICE_MODE == 'developing') {
                $this->_queryCache[] = array(
                        "query" => $query, 
                        "interval" => $time, 
                        "time" => microtime(true)
                );       
            }
            
            if(!is_empty($this->Error())) {
                out($query, $this->Error()); //, debug_backtrace()
                //exit;
            }
            
            $this->_resourceCache[] = $tmp;
            
            return $tmp;
        }

        public function SetAutoincrement($table, $idfield) {
            // null
        }

        public function UpdateBinaryField($table, $idfield, $id, $field, $value) {
            return ($this->Query("update $table set $field=0x".bin2hex($value)." where $idfield='$id'") !== false);
        }
        
        public function CountRows($table) {
            global $core;
            $res = mysql_query('SHOW TABLE STATUS LIKE \''.$table.'\'');
            $result = $this->fetch_object($res);
            return $result->Rows;
        }  
        
        public function Error() {
            return mysql_error();
        }
        
        public function TruncateTable($table) {
            return $this->Query('truncate table '.$table);
        }
        
        public function BeginTrans() {
            $this->Query("START TRANSACTION");
        }
        public function CompleteTrans(){
            $this->Query("COMMIT");
        }
        public function FailTrans(){
            $this->Query("ROLLBACK");
        }
        
        public function ListTables() {
            return $this->Query("SHOW TABLES FROM ".$this->_database);
        }
      
        public function ListFields($table) {
            return $this->Query("SHOW COLUMNS FROM ".$table);
        }       
        
        function AddField($table, $column, $type, $null = true, $default = null) {
            return ($this->query("ALTER TABLE ".$table." ADD COLUMN ".$column." ".MySqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")." ".(!is_null($default) ? " DEFAULT '".$default."'" : "")) !== false);
        }

        function AlterField2($table, $column, $columnNew, $type, $null = true, $default = null) {
            return ($this->query("ALTER TABLE ".$table." CHANGE COLUMN ".$column." ".$columnNew." ".MySqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")." ".(!is_null($default) ? " DEFAULT '".$default."'" : "")) !== false);
        }

        function AlterField($table, $column, $type, $null = true, $default = null) {
            return ($this->query("ALTER TABLE ".$table." CHANGE COLUMN ".$column." ".$column." ".MySqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")." ".(!is_null($default) ? " DEFAULT '".$default."'" : "")) !== false);
        }
        
        function RemoveField($table, $column) {
            return ($this->query("ALTER TABLE ".$table." DROP COLUMN ".$column) !== false);
        }
        
        public function CreateTableAs($name, $query, $temp = false) {
            return $this->Query('CREATE TABLE '.$name.' '.($temp ? 'type=memory' : '').' '.$query);
        }
        
        public function CreateTable($name, $fields, $indices, $ads, $temp = false, $return = false) {
        
            /* $fields = array(
                'name' => array(
                    'type' => '',
                    'additional' => ''
                )
                
                $indices = array(
                    'name' => array(
                        'fields' => ''
                        'unique' => true,
                        ''
                    )
                )
                
            );*/
            
            $query = 'CREATE TABLE '.($temp ? ' TYPE=MEMORY' : '').' `'.$name.'`('."\n";
            foreach($fields as $fn => $field) {
                $query .= '`'.$fn.'` '.MySqlDriver::$types[strtolower($field['type'])].' '.$field['additional'].($field['type'] == 'autoincrement' ? ' auto_increment' : '').','."\n";
            }
            
            foreach($indices as $fn => $index) {
                if(!empty($index['constraint'])) {
                    if($index['constraint'] == 'UNIQUE')
                        $query .= 'UNIQUE KEY '.$fn.' (`'.str_replace(',', '`,`', $index['fields']).'`),'."\n";
                    else if($index['constraint'] == 'PRIMARY KEY')
                        $query .= 'PRIMARY KEY '.$fn.' (`'.str_replace(',', '`,`', $index['fields']).'`),'."\n";
                    else
                        $query .= 'KEY '.$fn.' (`'.str_replace(',', '`,`', $index['fields']).'`),'."\n";
                }                
            }
            
            $query = substr($query, 0, strlen($query) - 2);
            $query .= ') '.$ads.';';
            
            return $return ? $query : $this->Query($query) !== false;
        }
        
        public function DropTable($table, $return = false) {
            $q = 'DROP TABLE `'.$table.'`';
            return $return ? $q : ($this->Query($q) !== false);
        }

        public function EscapeFieldNames($fields) {
            return '`'.str_replace(',', '`,`', $fields).'`';
        }
        
        public function EscapeFieldValue($field, $value) {
            switch($field->type) {
                case 'timestamp':
                case 'date':
                    if(is_null($value) && $field->required) 
                        $value = time();
                    if(is_numeric($value)) 
                        $value = 'FROM_UNIXTIME('.$value.')';
                    else
                        $value = "'".$value."'";
                    return $value;
            }
            if(is_null($value))
                return 'null';
            else {    
                return '\''.db_prepare($value).'\'';
            }
        }
        
        public function PrepareRowData($fields, $row) {
            return $row;
        }
        
        function SystemTypes() {
            $ret = new Hashtable();
            $ret->add("TEXT", "1: Text (max 255 letters)");
            $ret->add("MEMO", "2: Memo (unbounded)");
            $ret->add("HTML", "3: HTML (unbounded)");
            $ret->add("BLOB", "4: BLOB");
            $ret->add("BLOB LIST", "5: BLOB LIST");
            $ret->add("CHECK", "6: CHECK (true/false)");
            $ret->add("NUMERIC", "7: NUMERIC");
            $ret->add("DATETIME", "8: DATETIME");
            $ret->add("FILE", "9: FILE");
            $ret->add("FILE LIST", "10: FILE LIST");
            $ret->add("MULTISELECT", "11: MULTISELECT");
            return $ret;
        }

        function Type2System() {
            $ret = new Hashtable();
            $ret->add("TEXT", "VARCHAR(255)");
            $ret->add("MEMO", "LONGTEXT");
            $ret->add("HTML", "LONGTEXT");
            $ret->add("BLOB", "BIGINT(20)");
            $ret->add("BLOB LIST", "LONGTEXT");
            $ret->add("CHECK", "TINYINT(1)");
            $ret->add("NUMERIC", "FLOAT(27,3)");
            $ret->add("DATETIME", "DATETIME");
            $ret->add("FILE", "TINYTEXT");
            $ret->add("FILE LIST", "LONGTEXT");
            $ret->add("MULTISELECT", "LONGTEXT");
            return $ret;
        }
        
        
    }

?>
