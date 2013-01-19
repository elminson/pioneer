<?php

/* TODO: Add code here */

class Notice {
    
    private $mailsender;
    
    private $_keyword;
    private $_id;
    
    public $securitycache;
    
    public $error = false;
    
    public function Notice($notice_IdOrKeyOrData = null) {
        global $core;
        
        $this->_id = -1;
        
        if(is_null($core)) {
            trigger_error("Can not initialize notices class - core object not found");
            return null;
        }
        
//        if(!$this->CheckTables()) {
//            if(!$this->CreateTables())
//                return null;
//        }    

        if(!class_exists("mailsender")) {
            trigger_error("Notice initialization failed: Module requires the mailsender class", E_USER_ERROR);
            return null;
        }        
        
        $this->mailsender = new mailsender();
        if(!is_null($notice_IdOrKeyOrData)) {
            if(!is_object($notice_IdOrKeyOrData)) {
                
                if(is_numeric($notice_IdOrKeyOrData)) {
                    $notice_IdOrKeyOrData = "notice_id = ".$notice_IdOrKeyOrData;
                }
                else if(is_string($notice_IdOrKeyOrData)) {
                    $notice_IdOrKeyOrData = "notice_keyword = '".$notice_IdOrKeyOrData."'";
                }
                
                $dbe = $core->dbe;
                $r = $dbe->ExecuteReader("select * from sys_notices where ".$notice_IdOrKeyOrData);
                if($r->count() > 0) {
                    $result = $r->Read();
                }
                else {
                    $this->error = true;
                    return;
                }
                $this->mailsender->subject = $result->notice_subject;
                $this->mailsender->encoding = $result->notice_encoding;
                $this->mailsender->templ = $result->notice_body;
                $this->_keyword = $result->notice_keyword;
                $this->_id = $result->notice_id;
                $this->securitycache = $result->notice_securitycache;
            }
            else {
                $this->mailsender->subject = $notice_IdOrKeyOrData->notice_subject;
                $this->mailsender->encoding = $notice_IdOrKeyOrData->notice_encoding;
                $this->mailsender->templ = $notice_IdOrKeyOrData->notice_body;
                $this->_keyword = $notice_IdOrKeyOrData->notice_keyword;
                $this->_id = $notice_IdOrKeyOrData->notice_id;
                $this->securitycache = $notice_IdOrKeyOrData->notice_securitycache;
            }
            
            if(!($this->securitycache instanceof Hashtable)) {
                $this->securitycache = _unserialize($this->securitycache);
                if($this->securitycache === false || is_null($this->securitycache)) $this->securitycache = new Hashtable();
            }
            
            
        }    
        
    }
    
    function __get($property) {
        
        switch($property) {
            case "keyword":
                return $this->_keyword;
            case "id":
                return $this->_id;
            case "body":
                return $this->mailsender->templ;
            case "completeBody":
                return $this->mailsender->getBody();
            case "mailsender":
                return $this->mailsender;
            default:
                return @$this->mailsender->$property;
        }
        return null;
    }

    function __set($property, $value) {
        switch($property) {
            case "keyword":
                $this->_keyword = $value;
                break;
            case "id":
                $this->_id = $value;
                break;
            case "body":
                $this->mailsender->templ = $value;
                break;
            case "subject":
                $this->mailsender->subject = $value;
                break;
            default:
                @$this->mailsender->$property = $value;
        }
    }

    function AddObject($object, $splitter = ":") {
        $vars = get_object_vars($object);
        foreach($vars as $key => $value)
            $this->mailsender->addrule($splitter.$key.$splitter, $value);
    }
    
    function AddVar($key, $value) {
        $this->mailsender->addrule($key, $value);
    }

    function RemoveVar($key) {
        $this->mailsender->removerule($key);
    }
    
    function AddAddress($address) {
        $this->mailsender->addaddress($address);
    }
    
    public function AddAttachment($path, $name = "", $encoding = "base64", $type = "application/octet-stream") {
        $this->mailsender->AddAttachment($path, $name, $encoding, $type);
    }    

    function Sender($address) {
        $this->mailsender->from  = $address;
    }
    
    function Send() {
        global $USE_MAIL_QUEUEING;
        return $this->mailsender->Send((is_null($USE_MAIL_QUEUEING) ? $USE_MAIL_QUEUEING : true));
    }
    
    function Save() {
        global $core;
        
        $data = new collection();
        $data->add("notice_keyword", $this->_keyword);
        $data->add("notice_subject", $this->mailsender->subject);
        $data->add("notice_encoding", $this->mailsender->encoding);
        $data->add("notice_body", $this->mailsender->templ);
        $data->add("notice_securitycache", _serialize($this->securitycache));
        
        if(is_empty($this->_id) || $this->_id < 0)
            $this->_id = $core->dbe->insert("sys_notices", $data);
        else 
            $core->dbe->set("sys_notices", "notice_id", $this->_id, $data);
        
    }
    
    function Delete() {
        global $core;
        
        $core->dbe->delete("sys_notices", "notice_id", $this->_id);
    }
    
    public static function getOperations() {
        $operations = new Operations();
        $operations->Add(new Operation("notices.notice.delete", "Delete the notice"));
        $operations->Add(new Operation("notices.notice.edit", "Edit the notice"));
        $operations->Add(new Operation("notices.notice.send", "Send notice"));
        return $operations;
    }    
    
    public function createSecurityBathHierarchy($suboperation) {
        return array( 
                        array("object" => new Notices(), "operation" => "notices.".$suboperation), 
                        array("object" => $this, "operation" => "notices.notice.".$suboperation)
                     );
    }
    
}


class Notices {
    
    public $securitycache;
    
    function Notices() {
        global $core;
        
        if(is_null($core)) {
            trigger_error("Can not initialize notices class - core object not found");
            return null;
        }
        
        if(!$this->CheckTables()) {
            if(!$this->CreateTables())
                return null;
        }    

        if(!class_exists("mailsender")) {
            trigger_error("Notice initizalization failed: Module requires the mailsender class", E_USER_ERROR);
            return null;
        }
        
        $this->securitycache = new Hashtable();
    }

    /* module initializetion functions */
    function CheckTables() {
        global $core;
        
        $dbe = $core->dbe;
        return $dbe->tableexists(sys_table("notices"));
    }

    function CreateTables() {
        global $core;
        
        $dbe = $core->dbe;
        
        if(!$core->dbe->CreateTable('sys_notices', array(
            'notice_id' => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            'notice_keyword' => array('type' =>'longvarchar', 'additional' =>' NOT NULL default \'NEW_NOTICE\''),
            'notice_subject' => array('type' => 'tinytext', 'additional' => ' NOT NULL'),
            'notice_encoding' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''), 
            'notice_body'  => array('type' => 'longtext', 'additional' => ' NOT NULL')
        ), array(
            'notive_id' => array('fields' => 'notice_id', 'constraint' => 'PRIMARY KEY'),
            'notice_keyword' => array('fields' => 'notice_keyword', 'constraint' => 'UNIQUE')
        )) ) {
            trigger_error("Can not initialize notices class - table creation failed.", E_USER_ERROR);
            return false;
        }
    }
    
    function Get($key) {
        return new Notice($key);
    }
    
    static function Load($key) {
        $nn = new Notices();
        return $nn->Get($key);
    }
    
    static function Send($notice, $to, $from, $arrRules) {
        $nn = new Notices();
        $n = $nn->Get($notice);
        $n->AddAddress($to);
        $n->from = $from;
        
        foreach($arrRules as $k => $v)
            $n->AddVar($k, $v);
            
        $n->Send();
    }
    
    static function Remove($key) {
        $nn = new Notice($key);
        $nn->Delete();
    }
    
    static function Exists($id) {
        $n = new Notice($id);
        if($n->error)
            return false;
        return true;
    }
    
    static function Enumerate() {
        global $core;
        
        $retCol = new collection();
        $nn = new Notices();
        $dbe = $core->dbe;
        $list = $dbe->ExecuteReader("select * from sys_notices order by notice_keyword", "notice_keyword");
        while($nd = $list->Read()) {
            $retCol->Add($nd->notice_keyword, new Notice($nd));
        }
        return $retCol;
    }
    
    public static function getOperations() {
        $operations = new Operations();
        $operations->Add(new Operation("notices.add", "Add a notice"));
        $operations->Add(new Operation("notices.delete", "Delete the notice"));
        $operations->Add(new Operation("notices.edit", "Edit the notice"));
        $operations->Add(new Operation("notices.send", "Send notice"));
        return $operations;
    }    
    
    public function createSecurityBathHierarchy($suboperation) {
        return array( 
                        array("object" => $this, "operation" => "notices.".$suboperation)
                     );
    }
    
    
}

?>