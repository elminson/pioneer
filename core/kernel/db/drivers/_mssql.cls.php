<?

/**
* для корректной работы UTF-8
* 
* /etc/freetds/freetds.conf поставить 
* tds version = 8.0
* 
* в php.ini
* в секции [MSSQL]
* 
* mssql.charset = "UTF-8"
* 
*/

    require_once('driver.int.php');
    
    class MsSqlDriver implements IDbDriver {
        
        public static $types = array(
            'longvarchar' => 'nvarchar(255)',
            'mediumvarchar' => 'nvarchar(100)',
            'shortvarchar' => 'nvarchar(50)',
            'varchar3' => 'nvarchar(3)',
            'varchar2' => 'nvarchar(2)',
            'bigint' => 'bigint',
            'real' => 'float',
            'datetime' => 'datetime',
            'timestamp' => 'datetime',
            'boolean' => 'bit',
            'longtext' => 'ntext',
            'mediumtext' => 'ntext',
            'tinytext' => 'ntext',
            'blob' => 'varbinary(max)',
            'autoincrement' => 'bigint'
        );
        
        private $_connection;
        private $_resourceCache;
        private $_queryCache;
        
        private $_server;
        private $_user;
        private $_password;
        private $_database;    
        private $_persistence;
		
		public $idName;
        
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
                $this->persistence = $persistence;
				
                if($persistence)
                    $this->_connection = mssql_pconnect($server, $user, $password) or die("Could not connect to server: ".$this->Error());
                else                
                    $this->_connection = mssql_connect($server, $user, $password) or die("Could not connect to server: ".$this->Error());
                
                mssql_select_db($database, $this->_connection) or die("Could not connect from database: ".$this->Error());
                
				/*mssql_min_error_severity(1);
				mssql_min_message_severity(1);*/
				
                /*$this->Query("set names utf8");
                $this->Query("set character_set_client='utf8'");
                $this->Query("set character_set_results='utf8'");
                $this->Query("set collation_connection='utf8_unicode_ci'");*/
                
            }            
        }
        
        public function Disconnect() {
            foreach($this->_resourceCache as $resource) {
                @mssql_free_result($resource);
            }                       
            @mssql_close($this->_connection);
            unset($this->_resourceCache);
            $this->_resourceCache = array();
        }
        public function fetch_object($resource) {
            return mssql_fetch_object($resource);
        }
        public function fetch_array($resource) {
            return mssql_fetch_array($resource);
        }
        public function fetch_field($resource, $index) {
            return mssql_fetch_field($resource, $index);
        }
        public function num_rows($resource) {
            //if(!is_resource($resource))
            //  iout(debug_backtrace());
            return mssql_num_rows($resource);
        }
        public function num_fields($resource) {
            return mssql_num_fields($resource);
        }
        public function insert_id($tablename = "") {
            $q = "SELECT @@IDENTITY as id";
            $r = $this->Query($q);
            $rr = $this->fetch_object($r);
            return $rr->id;
        }
        public function affected($resource) {
            return mssql_rows_affected($resource);
        }        
        public function free_result($resource) {
            @mssql_free_result($resource);
        }
        public function excape_string($string) {
            ///
        }

        public function CreateCountQuery($query) {
            $s = preg_replace('/(order by ([^\s]+\s?(asc|desc)?))/mi', '', $query);
			$s = "select count(*) as cnt from (".$s.") devtbl";
			return $s;
        }
        
        public function AppendLimitCondition($query, $page, $pagesize) {
			$orderby = '';
			if (preg_match('/order by ([^\s]+\s?(asc|desc)?)/mi', $query, $m)){
				$orderby = $m[0];
                $orderby1 = $m[0];
				$s = preg_replace('/(order by ([^\s]+\s?(asc|desc)?))/mi', '', $query);
			}
            else {
                $s = $query;
                $orderby = '';
                $orderby1 = 'order by SCOPE_IDENTITY()';
            }
			
			$s = "select * from (select (ROW_NUMBER() over (".$orderby1.")) as __rn, * from (".$s.") as tbl) as tbl where __rn between "
				.(($page-1)*$pagesize)." and ".($page*$pagesize).' '.$orderby;

			return $s;
            //return $query." LIMIT ".(($page-1)*$pagesize).", ".$pagesize;
        }
        
        public function Query($query) {
            global $SERVICE_MODE;
            $time = microtime(true);

            // convert to windows-1251
            // $query = $this->val($query);
            
            try {
                $tmp = @mssql_query($query, $this->_connection);
                if(!$tmp) {
                    out($query, mssql_get_last_message()); //, debug_backtrace()
                }
            }
            catch(Exception $e) {
                out($query, mssql_get_last_message()); //, debug_backtrace()
            }
            
            /*if(!is_empty($this->Error())) {
                out($query, $this->Error()); //, debug_backtrace()
                //exit;
            }*/
            
            $time = (microtime(true) - $time)*1000;

            if($SERVICE_MODE == 'developing') {
                $this->_queryCache[] = array(
                        "query" => $query, 
                        "interval" => $time, 
                        "time" => microtime(true)
                );       
            }
            
            
            $this->_resourceCache[] = $tmp;
            
            return $tmp;
        }

        public function SetAutoincrement($table, $idfield) {
            $result = $this->Query("select max(".$idfield.") as m from ".$table."");
            $r = $this->fetch_object($result);
            $this->Query("DBCC CHECKIDENT('".$table."', RESEED, ".($r->m ? $r->m : 1).");");
            $this->free_result($result);
        }

        public function UpdateBinaryField($table, $idfield, $id, $field, $value) {
            // должно работать 
            $ret = ($this->Query("update $table set $field=0x".bin2hex($value)." where $idfield='$id'") !== false);
            return $ret;
        }
        
        public function CountRows($table) {
            global $core;
            $res = $this->Query('select count(*) as Rows from '.$table);
            $result = $this->fetch_object($res);
            return $result->Rows;
        }  
        
        public function Error() {
            return mssql_get_last_message();
        }
        
        public function TruncateTable($table) {
            return $this->Query('truncate table '.$table);
        }
        
        public function BeginTrans() {
            // $this->Query("BEGIN TRANSACTION;");
        }
        public function CompleteTrans(){
            // $this->Query("COMMIT");
        }
        public function FailTrans(){
            // $this->Query("ROLLBACK");
        }
        
        public function ListTables() {
            // USE '.$this->_database.'; 
            return $this->Query('SELECT name as Tables_in_'.$this->_database.' FROM sys.Tables;');
        }
      
        public function ListFields($table) {
            return $this->Query('select name as field, is_nullable as [null], (select top 1 cast(name as varchar) from sys.types where system_type_id=sys.all_columns.system_type_id) as type, cast(object_definition(default_object_id) as varchar) as [default], \'\' as extra, \'\' as [key] from sys.all_columns where object_id = (select top 1 object_id from sys.tables where cast(name as varchar)=\''.$table.'\')');
        }       
        
        function AddField($table, $column, $type, $null = true, $default = null) {
            //return ($this->query("ALTER TABLE ".$table." ADD COLUMN ".$column." ".MsSqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")." ".(!is_null($default) ? " DEFAULT '".$default."'" : "")) !== false);
            // ALTER TABLE [dbo].[test] ADD [c] varchar(255) NULL
            return $this->Query('ALTER TABLE [dbo].['.$table.'] ADD ['.$column.'] '.MsSqlDriver::$types[strtolower($type)].' '.($null ? "NULL" : "NOT NULL")) !== false;
        }

        function AlterField2($table, $column, $columnNew, $type, $null = true, $default = null) {
            //return ($this->query("ALTER TABLE ".$table." CHANGE COLUMN ".$column." ".$columnNew." ".MsSqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")." ".(!is_null($default) ? " DEFAULT '".$default."'" : "")) !== false);
            $b = true;
            if($column != $columnNew) {
                $b = $this->Query('EXEC sp_rename N\'[dbo].['.$table.'].['.$column.']\', N\''.$columnNew.'\', \'COLUMN\'');
            }
            if(!$b)
                $b = $this->query("ALTER TABLE [dbo].[".$table."] ALTER COLUMN [".$column."] ".MsSqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")) !== false;
            if(!$b && !is_null($default)) {
                $this->Query('ALTER TABLE [dbo].['.$table.'] ADD DEFAULT \''.$default.'\' FOR ['.$column.']');
            }
        }

        function AlterField($table, $column, $type, $null = true, $default = null) {
            $b = $this->query("ALTER TABLE [dbo].[".$table."] ALTER COLUMN [".$column."] ".MsSqlDriver::$types[strtolower($type)]." ".($null ? "NULL" : "NOT NULL")) !== false;
            if(!$b && !is_null($default)) {
                $this->Query('ALTER TABLE [dbo].['.$table.'] ADD DEFAULT \''.$default.'\' FOR ['.$column.']');
            }
        }
        
        function RemoveField($table, $column) {
            return ($this->query("ALTER TABLE [dbo].[".$table."] DROP COLUMN [".$column."]") !== false);
        }
        
        public function CreateTableAs($name, $query, $temp = false) {
            return $this->Query('CREATE TABLE '.($temp ? '#' : '').$name.' '.$query);
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
            
            /*$pksetted = false;*/
            
            $defaults = '';
            $ind = '';
            $query = 'CREATE TABLE [dbo].[' . ($temp ? '#' : '') . $name.']('."\n";
            foreach($fields as $fn => $field) {
                if(preg_match('/default\s([^\s]*)/i', $field['additional'], $matches)) {
                    $field['additional'] = preg_replace('/default\s([^\s]*)/i', '', $field['additional']);
                    $defaults .= 'ALTER TABLE [dbo].['.$name.'] ADD '.$matches[0].' FOR ['.$fn.'];'."\n";
                    
                }
                $query .= '['.$fn.'] '.MsSqlDriver::$types[strtolower($field['type'])].' '.$field['additional'].($field['type'] == 'autoincrement' ? ' NOT NULL IDENTITY(1,1) NOT FOR REPLICATION' : '').','."\n";
            }

            foreach($indices as $fn => $index) {
                if(!empty($index['constraint'])) {
                    if($index['constraint'] == 'UNIQUE')
                        $ind .= 'CREATE UNIQUE INDEX ['.$fn.'] ON [dbo].['.$name.'] ('.$this->EscapeFieldNames($index['fields']).') ON [PRIMARY]'.";\n";
                    else if($index['constraint'] == 'PRIMARY KEY')   /*&& !$pksetted*/
                        $query .= 'CONSTRAINT ['.$fn.'] PRIMARY KEY ('.$this->EscapeFieldNames($index['fields']).'),'."\n";
                    else
                        $ind .= 'CREATE INDEX ['.$fn.'] ON [dbo].['.$name.'] ('.$this->EscapeFieldNames($index['fields']).') ON [PRIMARY]'.";\n";
                }                
            }
            
            $query .= ') 
                ON [PRIMARY];';
            

            // $query = substr($query, 0, strlen($query) - 2);
            $query .= $ind."\n".$defaults.$ads.'';

            return $return ? $query : $this->Query($query) !== false;
        }
        
        public function DropTable($table, $return = false) {
            $q = 'DROP TABLE [dbo].['.$table.']';
            return $return ? $q : ($this->Query($q) !== false);
        }

        public function EscapeFieldNames($fields) {
            return '['.str_replace(',', '],[', $fields).']';
        }
        
        public function EscapeFieldValue($field, $value) {
            switch($field->type) {
                case 'timestamp':
                case 'date':
                    if((is_null($value) || $value == 'null' || $value == '1970-01-01 00:00:00') && $field->null == 'NO') 
                        $value = time();

                    if(is_numeric($value)) 
                        $value = date('Y-m-d H:i:s', $value); //'FROM_UNIXTIME('.$value.')';
                    else
                        $value = "'".$value."'";
                        
                    return $value;
            }
            if(is_null($value))
                return 'null';
            else if($value === 'true')
                return '\'1\'';
            else if($value === 'false')
                return '\'0\'';
            else {    
                return '\''.db_prepare2($value).'\'';
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
            $ret->add("TEXT", "LONGTEXT");
            $ret->add("MEMO", "LONGTEXT");
            $ret->add("HTML", "LONGTEXT");
            $ret->add("BLOB", "BIGINT");
            $ret->add("BLOB LIST", "LONGTEXT");
            $ret->add("CHECK", "BOOLEAN");
            $ret->add("NUMERIC", "REAL");
            $ret->add("DATETIME", "DATETIME");
            $ret->add("FILE", "LONGTEXT");
            $ret->add("FILE LIST", "LONGTEXT");
            $ret->add("MULTISELECT", "LONGTEXT");      
            return $ret;
        }
        
        public static function val($value){
            out($value);
			return iconv('utf-8', 'windows-1251', $value);
		}
    }
?>
