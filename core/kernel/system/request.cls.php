<?php


class RequestedFile {

    public $name;
    public $ext;
    public $mimetype;
    public $error;
    public $size;
    public $tmp_path;


    function __construct($arrFILE) {

        $this->name = $arrFILE["name"];       
        $ret = preg_split("/\./i", $this->name);
        if(count($ret) > 1 )
            $this->ext = $ret[count($ret) - 1];

        $this->mimetype = $arrFILE["type"];
        $this->tmp_path = $arrFILE["tmp_name"];
        $this->error = $arrFILE["error"];
        $this->size = $arrFILE["size"];

    }
    
    public function __get($prop) {
        switch($prop) {
            case "isValid":
                return !is_empty($this->name);
        }
    }
    
    function __destruct(){
        $this->Dispose();
        
    }
    
    public function Dispose() {
        @unlink($this->tmp_path);
    }

    /*
    public function ToDB($table, $field, $id, $insert) {
        global $core;
        
        $bin = $this->binary();

        if($insert)
            $id = $core->dbe->insert($table);

        $core->dbe->setbin($table, "blobs_id", $id, $field, $bin);
    }
    */
    
    function Out() {
        header("ContentType: ".$this->mimetype);
        echo $this->Binary();
    }

    function Binary() {
        global $core;
        
        $size = $core->fs->FileSize($this->tmp_path, -1);
        /*
        if(!$core->CanCheckMemory() && $size > 204800)
            return false;
        
        if(!$core->CheckMemoryUsage($size)) {
            return false;
        }
        */
        
        return $core->fs->ReadFile($this->tmp_path, -1);
    }

    function MoveTo($path) {
        global $core;
        return $core->fs->MoveFile($this->tmp_path, $path);
    }
    
    public function save($path) { deprecate(); }
    public function is_valid() { deprecate(); return !empty($this->name); }
    function to_db($table, $field, $id, $insert) { deprecate(); $this->ToDB($table, $field, $id, $insert); }

        

}

/**
    * class Request
    *
    * Description for class Request
    *
    * @author:
    */
class Request {

    private $_postFiles;

    function __construct() {
        $this->_postFiles = array();
    }
    
    public function RegisterEvents(){
        
    }
    
    public function RegisterEventHandlers(){
        
    }
    
/*    public function Initialize(){

        //remove slashes if it needed
        if(ini_get("magic_quotes_gpc") == "1") {
            foreach($_POST as $k => $v) {
                $_POST[$k] = stripslashes($v);
            }
        }
    }
*/    
    private function rgStripslashes($obj){
        if (is_array($obj)){
            foreach($obj as $k => $v) {
                $obj[$k] = $this->rgStripslashes($v);
            }
            return $obj;
        } else {
            return stripslashes($obj);
        }
    }
    
    public function Initialize(){

        //remove slashes if it needed
        if(ini_get("magic_quotes_gpc") == "1") {
            if(isset($_POST)) {
                foreach($_POST as $k => $v) {
                    $_POST[$k] = $this->rgStripslashes($v);
                }
            }
            
            if(isset($_GET)) {
                foreach($_GET as $k => $v) {
                    $_GET[$k] = $this->rgStripslashes($v);
                }
            }
            
            if(isset($_COOKIE)) {
                foreach($_COOKIE as $k => $v) {
                    $_COOKIE[$k] = $this->rgStripslashes($v);
                }
            }
        }
    }
    
    public function Dispose() {
        foreach($this->_postFiles as $f) {
            if(method_exists($f, "Dispose"))
                $f->Dispose();
        }
    }
    
    public function count() {
        return count($_GET) + count($_POST) + count($_FILES);
    }                                         

    public function __get($nm) {
        switch($nm) {
            case "SESSIONID":
            case "sessionid":
            case "SessionId":
                return session_id();
                break;
            case "referer":
            case "REFERER":
                if(!is_null(@$_SERVER['HTTP_REFERER'])) return addslashes(@$_SERVER['HTTP_REFERER']);
                if(!is_null(@$_GET['referer'])) return addslashes(@$_GET['referer']);
                if(!is_null(@$_POST['referer'])) return addslashes(@$_POST['referer']);
                if(!is_null(@$_SESSION['referer'])) return addslashes(@$_SESSION['referer']);
                if(!is_null(@$_GET['REFERER'])) return addslashes(@$_GET['REFERER']);
                if(!is_null(@$_POST['REFERER'])) return addslashes(@$_POST['REFERER']);
                if(!is_null(@$_SESSION['REFERER'])) return addslashes(@$_SESSION['REFERER']);
                return null;
                break;
            case "currentUrl":
                //$qs = preg_replace("/folder=[^&]*&?/i", '', $_SERVER['QUERY_STRING']);
                //$qs = preg_replace("/publication=[^&]*&?/i", '', $qs);
                //return @$_SERVER['REQUEST_URI'].(!is_empty($qs) ? "?".$qs : '');
                return addslashes(@$_SERVER['REQUEST_URI']);
            case 'queryPost':
                return $this->get_collection(VAR_POST);
            case 'queryString':
                return $this->get_collection(VAR_GET);
            case 'queryFiles':
                return $this->get_collection(VAR_FILES);
            case 'serverSession':
                return $this->get_collection(VAR_SESSION);
            case 'serverCookie':
                return $this->get_collection(VAR_COOKIE);
            case 'serverVars':
                return $this->get_collection(VAR_SERVER);
            case 'remoteip':
                if($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR'] || $_SERVER['HTTP_X_FORWARDED_FOR'])
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
                return $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : ($_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : ($_SERVER['X_REAL_IP'] ? $_SERVER['X_REAL_IP'] : ($_SERVER['HTTP_FORWARDED'] ? $_SERVER['HTTP_FORWARDED'] : '')));
            default:
            
                global $argv;
                if(is_array($argv) && count($argv) > 1) {
                    
                    foreach($argv as $v) {
                        $v = explode('=', $v);
                        if($v[0] == $nm)
                            return $v[1];
                    }
                    
                    return false;
                }
                
            
                $return = array();
                if(array_key_exists($nm, $_POST)) {
                    $return = array_merge($return, (array)$_POST[$nm]);
                }
                if (array_key_exists($nm, $_GET)) {
                    $return = array_merge($return, (array)$_GET[$nm]);
                }
                if(array_key_exists($nm, $_FILES)) {
                    if(is_array($_FILES[$nm]['name'])) { 
                        foreach(array_keys($_FILES[$nm]['name']) as $i) {
                            $file = array();
                            $file['name'] = $_FILES[$nm]['name'][$i];
                            $file['type'] = $_FILES[$nm]['type'][$i];
                            $file['tmp_name'] = $_FILES[$nm]['tmp_name'][$i];
                            $file['error'] = $_FILES[$nm]['error'][$i];
                            $file['size'] = $_FILES[$nm]['size'][$i];
                            $file['name'] = $_FILES[$nm]['name'][$i];
                            $return[] = new RequestedFile($file);
                        }
                    }
                    else
                        $return = array_merge($return, array(new RequestedFile($_FILES[$nm])));
                    
                    $this->_postFiles[] = $return;
                }
                
                if (array_key_exists($nm, $_SESSION)) {
                    $return = array_merge($return, (array)($_SESSION[$nm]));
                }
                
                if (array_key_exists($nm, $_SERVER)) {
                    $return = array_merge($return, (array)($_SERVER[$nm]));
                }
                
                if (array_key_exists($nm, $_COOKIE)) {
                    $return = array_merge($return, (array)($_COOKIE[$nm]));
                }

                if(count($return) == 1) {
                    $return = $return[0];
                }
                else if(count($return) == 0) {
                    return null;
                }
                
                return $return;
        }
    }

    public function __set($nm, $val) {
        $_SESSION[$nm] = $val;
    }

    public function get($key){
        return (array_key_exists($key, $_GET)) ? $_GET[$key] : null;
    }
    
    public function post($key){
        return (array_key_exists($key, $_POST)) ? $_POST[$key] : null;
    }
    
    public function get_collection($what) {
        switch($what) {
            case VAR_SERVER:
                $ret = new collection($_SERVER);
                break;
            case VAR_SESSION:
                $ret = new collection($_SESSION);
                break;
            case VAR_REQUEST:
                //$ret = new collection($this->rdata->get_array());
                $ret = new collection();
                
                $keys = array_keys($_GET);
                for($i=0; $i<count($keys); $i++) {
                    $ret->add($keys[$i], $_GET[$keys[$i]]);
                }
                
                foreach($_POST as $k => $v) {
                    if(!$ret->exists($k))
                        $ret->add($k, $v);
                    else {
                        $vv = $ret->item($k).";".$v;
                        $ret->add($k, $vv);
                    }
                }                
                break;
            case VAR_GET:
                $ret = new collection($_GET);
                break;
            case VAR_POST:
                $ret = new collection($_POST);
                break;
            case VAR_FILES:
                $ret = new collection($_FILES);
                break;
            case VAR_COOKIE:
                $ret = new collection($_COOKIE);
                break;
            default:
                $ret = null;
        }
        return $ret;
    }

    public function replace($replace = array(), $remove = array()) {
        
        $get = $_GET;
        foreach($replace as $k => $v)
            $get[$k] = $v;
        
        foreach($remove as $v)
            unset($get[$v]);
        
        $url = '';
        foreach($get as $k => $v)
            $url .= '&'.$k.'='.$v;     
            
        $url = trim(substr($url, 1));
        if(!is_empty($url))
            return '?'.$url;
        return '';
        
    }
    
    public function redirect($url, $method = "get", $data = null) {
        switch($method) {
            case "post": {
                $fid = "formid".str_random(10);
                echo "<form action='".$url."' name='".$fid."' method='".$method."'>";
                if(!is_null($data)) {
                    for($i=0; $i<$data->count(); $i++) {
                        echo "<input type=hidden name='".$data->key($i)."' value='".$data->item($i)."'>";
                    }
                }
                echo "</form>";
                echo "<script language='javascript'>document.forms['".$fid."'].submit();;</script>";
                exit();
                break;
            }
            case "get": {
                echo "<script language='javascript'>location='".$url."';</script>";
                //exit();
                break;
            }
        }
    }

}

?>
