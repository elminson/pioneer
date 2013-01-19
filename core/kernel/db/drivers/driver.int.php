<?php
  
  interface IDbDriver {
      
        public function Connect($server, $user, $password, $database, $persistence = true);
        public function Disconnect();

        public function fetch_object($resource);
        public function fetch_array($resource);
        public function fetch_field($resource, $index);
        public function num_rows($resource);
        public function num_fields($resource);
        public function insert_id($tablename = "");
        public function affected($resource);
        public function free_result($resource);  
        public function excape_string($string);
        
        public function CreateCountQuery($query);
        public function AppendLimitCondition($query, $page, $pagesize);
        
        public function SetAutoincrement($table, $idfield);
        public function Query($query);
        public function UpdateBinaryField($table, $idfield, $id, $field, $value);
        public function Error();
        public function TruncateTable($table);

        public function ListTables();
        public function ListFields($table);
        public function CountRows($table);
        public function EscapeFieldNames($fields);
        public function EscapeFieldValue($field, $value);

        public function AddField($table, $column, $type, $null = true, $default = null);
        public function AlterField2($table, $column, $columnNew, $type, $null = true, $default = null);
        public function AlterField($table, $column, $type, $null = true, $default = null);
        public function RemoveField($table, $column);
        
        public function CreateTable($name, $fields, $indices, $ads, $temp = false, $return = false);
        public function DropTable($table, $return = false);
        
        public function BeginTrans();
        public function CompleteTrans();
        public function FailTrans();
      
        public function SystemTypes();
        public function Type2System();
      
  }
  
  
?>