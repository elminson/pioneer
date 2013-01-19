<?php
    
    // require_once('driver.int.php');
    
    class PgSqlDriver implements IDbDriver {

        public static $types = array(
            'longvarchar' => 'VARCHAR(255)',
            'mediumvarchar' => 'VARCHAR(100)',
            'shortvarchar' => 'VARCHAR(50)',
            'varchar3' => 'VARCHAR(3)',
            'varchar2' => 'VARCHAR(2)',
            'bigint' => 'BIGINT',
            'real' => 'REAL',
            'datetime' => 'date',
            'timestamp' => 'timestamp',
            'boolean' => 'boolean',
            'longtext' => 'TEXT',
            'mediumtext' => 'TEXT',
            'tinytext' => 'TEXT',
            'blob' => 'BYTEA',
            'autoincrement' => 'BIGSERIAL'
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
                
                $connectionString = 'host='.$server.' user='.$user.' password='.$password.' dbname='.$database;
                $this->_connection = pg_pconnect($connectionString, $persistence) or die("Could not connect to server: ".$this->Error());
            }            
        }
        
        public function Disconnect() {
            foreach($this->_resourceCache as $resource) {
                @pg_free_result($resource);
            }                       
            @pg_close($this->_connection);
            unset($this->_resourceCache);
            $this->_resourceCache = array();
        }
        public function fetch_object($resource) {
            
            $obj = pg_fetch_object($resource);
            if(!is_null($obj) && $obj) {
                $props = array_keys(get_object_vars($obj));  
                for($i=0; $i<count($props); $i++) {
                    $field = $this->fetch_field($resource, $i);
                    $varName = $props[$i];
                    if($field->blob) {
                        $obj->$varName = pg_unescape_bytea($obj->$varName);
                    }
                    else if($field->type == 'bool') {
                        $obj->$varName = $obj->$varName == 't' ? true : false;
                    }
                }
            }       
            return $obj;
        }
        public function fetch_array($resource) {
            return pg_fetch_array($resource);
        }
        public function fetch_field($resource, $index) {
            
            /*stdClass Object
            (
                [name] => tree_id
                [table] => sys_tree
                [def] => 
                [max_length] => 0
                [not_null] => 1
                [primary_key] => 1
                [multiple_key] => 0
                [unique_key] => 0
                [numeric] => 1
                [blob] => 0
                [type] => int
                [unsigned] => 0
                [zerofill] => 0
            )*/
            $field = new stdClass();
            $field->name = pg_field_name($resource,$index);
            $field->type = pg_field_type($resource,$index);
            $field->table = pg_field_table($resource,$index);
            $field->max_length = pg_field_size($resource,$index);
            $field->not_null = !pg_field_is_null($resource,$index);
            $field->def = '';
            $field->primary_key = 0;
            $field->multiple_key = 0;
            $field->unique_key = 0;
            $field->numeric = in_array($field->type, array('bigint', 'int4', 'int8', 'int', 'real'));
            $field->blob = $field->type == 'bytea';
            
            return $field;
            
            
            
            //return pg_field_is_null($resource, $index);
        }
        public function num_rows($resource) {
            return pg_num_rows($resource);
        }
        public function num_fields($resource) {
            return pg_num_fields($resource);
        }
        public function insert_id($tablename = "") {
            $res = @pg_query("SELECT LASTVAL()");
            if(!is_resource($res))
                return false;
            if($this->num_rows($res) > 0) {
                $obj = pg_fetch_object($res);
                return $obj->lastval;
            }
            
            /*
            $res = pg_query("SELECT column_default as def FROM information_schema.columns where table_name='".$tablename."' and column_default like 'nextval%'");
            if($this->num_rows($res) > 0) {
                $opj = pg_fetch_object($res);
                $secName = $opj->def;
                preg_match('/nextval\(\'([^\']*)\'\:\:regclass\)/', $secName, $matches);
                if(count($matches) == 0)
                    return 0;
                $secName = $matches[1];
                $res = pg_query("SELECT last_value FROM ".$secName);    
                $r = pg_fetch_array($res);
                return $r[0];
            }
            else 
                return 0;*/
            
        }
        public function affected($resource) {
            if(is_resource($resource))
                return pg_affected_rows($resource);
            return false;
        }               
        public function free_result($resource) {
            if(is_resource($resource))
                pg_free_result($resource);
        }
        public function excape_string($string) {
            return pg_escape_string($string);
        }

        public function CreateCountQuery($query) {
            return "select count(*) as cnt from (".$query.") devtbl";
        }
        
        public function AppendLimitCondition($query, $page, $pagesize) {
            return $query." LIMIT ".$pagesize." offset ".(($page-1)*$pagesize);
        }
        
        public function SetAutoincrement($table, $idfield) {
            $this->Query("SELECT setval('".$table."_".$idfield."_seq', (select max(\"".$idfield."\") from ".$table."))");
        }
        
        public function Query($query) {
            global $SERVICE_MODE;
            
            $time = microtime(true);
            
            $tmp = @pg_query($this->_connection, $query);
            
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
        
        public function UpdateBinaryField($table, $idfield, $id, $field, $value) {
            return ($this->Query("update $table set $field='".pg_escape_bytea($this->_connection, $value)."' where $idfield='$id'") !== false);
        }      
        
        public function CountRows($table) {
            $res = $this->Query("SELECT reltuples as rows FROM pg_class r WHERE relkind = 'r' AND relname = '".$table."'");
            $result = $this->fetch_object($res);
            return $result->rows;
        }  
        
        public function Error() {
            return pg_last_error($this->_connection);
        }
        
        public function TruncateTable($table) {
            return $this->Query('truncate table '.$table);
        }
        
        public function BeginTrans() {
            $this->Query("BEGIN TRANSACTION");
        }
        public function CompleteTrans(){
            $this->Query("COMMIT");
        }
        public function FailTrans(){
            $this->Query("ROLLBACK");
        }
        
        public function ListTables() {
            return $this->Query("SELECT table_name as Tables_in_".$this->_database." FROM information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_catalog='".$this->_database."'");
        }
        
        public function ListFields($table) {
            $scheme = "";
            if(strstr($table, ".") !== false) {
                $t = preg_split("/\./i", $table);
                $scheme = $t[0];
                $table = $t[1];
            }
            return $this->Query("SELECT column_name as field, udt_name as \"Type\", is_nullable as \"Null\", null as \"Key\", column_default as \"Default\", null as Extra  FROM information_schema.columns WHERE table_name ='".$table."'".(!is_empty($scheme) ? " and table_schema ='".$scheme."'" : ""));
        }
      
        function AddField($table, $column, $type, $null = true, $default = null) {
            return ($this->query("ALTER TABLE ".$table." ADD COLUMN ".$column." ".PgSqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")." ".(!is_null($default) ? " DEFAULT '".$default."'" : "")) !== false);
        }

        private function _RenameField($table, $column, $columnNew) {
            return ($this->query("ALTER TABLE ".$table." RENAME COLUMN ".$column." to ".$columnNew) !== false);
        }
        
        function AlterField2($table, $column, $columnNew, $type, $null = true, $default = null) {  // null is not applicable
            
            if($columnNew == $column)
                return $this->AlterField($table, $column, $type, true, $default);
            
            $this->BeginTrans();
            
            $ret = $this->AddField($table, $columnNew, $type, true, $default) !== false;
            if($ret) $ret = $this->Query("update ".$table." set ".$columnNew." = CAST(".$column." as ".PgSqlDriver::$types[strtolower($type)].")") !== false;
            if($ret) $ret = $this->RemoveField($table, $column) !== false;

            if($ret) $this->CompleteTrans();
            else $this->FailTrans();
            
            return $ret;
        }

        function AlterField($table, $column, $type, $null = true, $default = null) { // null is not applicable
            $columnNew = $column."_temp";
            $this->BeginTrans();
            
            $ret = $this->AddField($table, $columnNew, $type, true, $default) !== false;
            if($ret) $ret = $this->Query("update ".$table." set ".$columnNew." = CAST(".$column." as ".PgSqlDriver::$types[strtolower($type)].")") !== false;
            if($ret) $ret = $this->RemoveField($table, $column) !== false;
            if($ret) $ret = $this->_RenameField($table, $columnNew, $column) !== false;
            
            if($ret) $this->CompleteTrans();
            else $this->FailTrans();
                
            return $ret;
        }
        
        function RemoveField($table, $column) {
            return ($this->query("ALTER TABLE ".$table." DROP COLUMN ".$column) !== false);
        }
        
        public function CreateTableAs($name, $query, $temp = false) {
            return $this->Query('CREATE '.($temp ? 'TEMP ' : '').'TABLE '.$name.' AS '.$query);
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
                        'constraint' => 'UNIQUE | PRIMARY KEY',
                        ''
                    )
                )
                
            );*/
            
            $query = "\n\n".'CREATE '.($temp ? 'TEMP ' : '').'TABLE "'.$name.'"('."\n";
            foreach($fields as $fn => $field) {
                $query .= '"'.$fn.'" '.PgSqlDriver::$types[strtolower($field['type'])].' '.$field['additional'].','."\n";
            }
            
            foreach($indices as $fn => $index) {
                if(!empty($index['constraint'])) {
                    $query .= 'CONSTRAINT "'.$fn.'" '.$index['constraint'].' ("'.str_replace(',', '","', $index['fields']).'"),'."\n";
                }
            }
            
            $query = substr($query, 0, strlen($query) - 2);
            $query .= ') '.$ads.';';
            
            foreach($indices as $fn => $index) {
                if(empty($index['constraint'])) {
                    $query .= 'CREATE INDEX "'.$fn.'" ON "public"."'.$name.'" USING btree ("'.str_replace(',', '","', $index['fields']).'");'."\n";
                }
            }
            
            return $return ? $query : $this->Query($query) !== false;
        }
        
        public function DropTable($table, $return = false) {
            $q = 'DROP TABLE "'.$table.'"';
            return $return ? $q : $this->Query($q) !== false;
        }        
      
        public function EscapeFieldNames($fields) {
            return '"'.str_replace(',', '","', $fields).'"';
        }

        public function EscapeFieldValue($field, $value) {
            
            if(is_null($value) || $value === 'null')
                return 'null';

            switch($field->type) {
                case 'timestamp':
                    if(is_null($value) || $value=='null') $value = time();
                    if(is_numeric($value)) $value = strftime("%Y-%m-%d %H:%M:%S", $value);
                    if($value == '0000-00-00 00:00:00') $value = '1970-01-01 00:00:00';
                    return "'".$value."'::timestamp";
                case 'date':
                    if(is_null($value) || $value=='null') $value = time();
                    if(is_numeric($value)) $value = strftime("%Y-%m-%d %H:%M:%S", $value);
                    if($value == '0000-00-00 00:00:00') $value = '1970-01-01 00:00:00';
                    return "'".$value."'::date";
                case 'int2':
                case 'int4':
                case 'int8':
                case 'float4':
                    return is_empty($value) ? 0 : $value;
                case 'bool':
                    return $value ? "true" : "false";
                case 'bytea':
                    if(substr($value, 0, 2) == '0x')
                        $value = hex2bin(substr($value, 2));
                    return "'".pg_escape_bytea($this->_connection, $value)."'";
            }
            
            return '\''.pg_escape_string($value).'\'';
        }
        
        private function PrepareField($field, $value) {
            
            if(is_null($value))
                return 'null';

            switch($field->type) {
                case 'timestamp':
                    if(is_null($value)) $value = time();
                    if(is_numeric($value)) $value = strftime("%Y-%m-%d %H:%M:%S", $value);
                    if($value == '0000-00-00 00:00:00') $value = '1970-01-01 00:00:00';
                    return $value;
                case 'date':
                    if(is_null($value)) $value = time();
                    if(is_numeric($value)) $value = strftime("%Y-%m-%d %H:%M:%S", $value);
                    if($value == '0000-00-00 00:00:00') $value = '1970-01-01 00:00:00';
                    return $value;
                case 'int2':
                case 'int4':
                case 'int8':
                    return is_empty($value) ? 0 : $value;
                case 'bool':
                    return $value ? "true" : "false";
                case 'bytea':
                    return pg_escape_bytea($this->_connection, $value);
            }
            
            return pg_escape_string($value);
        }
        
        public function PrepareRowData($fields, $row) {
            foreach($row as $key => $value)
                $row->$key = $this->PrepareField($fields->$key, $value);
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
            $ret->add("TEXT", "LONGVARCHAR");
            $ret->add("MEMO", "longtext");
            $ret->add("HTML", "longtext");
            $ret->add("BLOB", "BIGINT)");
            $ret->add("BLOB LIST", "longtext");
            $ret->add("CHECK", "BOOLEAN");
            $ret->add("NUMERIC", "REAL");
            $ret->add("DATETIME", "DATETIME");
            $ret->add("FILE", "longtext");
            $ret->add("FILE LIST", "longtext");
            $ret->add("MULTISELECT", "longtext");
            return $ret;
        }
        
        function CreateSchemeAddons() {
            $ret =  '
                CREATE FUNCTION public.unix_timestamp () RETURNS integer
                AS 
                $body$
                SELECT
                ROUND(EXTRACT( EPOCH FROM abstime(now()) ))::int4 AS result;
                $body$
                    LANGUAGE sql;

                CREATE FUNCTION public.unix_timestamp (timestamp with time zone) RETURNS integer
                AS 
                $body$
                SELECT
                ROUND(EXTRACT( EPOCH FROM ABSTIME($1) ))::int4 AS result;
                $body$
                    LANGUAGE sql;

                CREATE FUNCTION public.from_unixtime (bigint) RETURNS timestamp without time zone
                AS 
                $body$
                SELECT
                CAST($1 as integer)::abstime::timestamp without time zone AS result
                $body$
                    LANGUAGE sql;            
            ';
        }
        
        
    }

?>