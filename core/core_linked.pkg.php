<?
    define("WEBPAGE", 0);
    define("DEBUG_ENABLE_OUT", 128);
    define("DEBUG_ENABLE_BP", 64);
    define("DEBUG_SIMPLE_SET", 0);
    define("DEBUG_STANDART_SET", 1);
    define("DEBUG_DETAILED_SET", 2);
    if(!defined("LOG_ERROR"))
        define("LOG_ERROR", "error");
                if(!defined("LOG_MESSAGE"))
        define("LOG_MESSAGE", "");
    define("CONTEXT_STANDART", 0);
    define("CONTEXT_ENCODED", 1);
    define("CONTEXT_LASTBLOCK", 2);
    define("VAR_SERVER", 0);
    define("VAR_SESSION", 1);
    define("VAR_REQUEST", 2);
    define("VAR_GET", 6);
    define("VAR_POST", 4);
    define("VAR_FILES", 5);
    define("VAR_COOKIE", 3);
    define("TYPEEXCHANGE_MODE_SET", "__set"); 
    define("TYPEEXCHANGE_MODE_GET", "__get"); 
    define("MODE_READ", "rb9");
    define("MODE_WRITE", "wb9");
    define("MODE_APPEND", "ab9");
    define("MODE_CREATEWRITE", "wb9");
    define("SITE", 0);
    define("CORE", 1);    
    define("ADMIN", 2);
    define("STATS_ALL", 0);
    define("STATS_TODAY", 1);
    define("STATS_LASTWEEK", 2);
    define("STATS_LASTMONTH", 3);
    define("MODULE_CREATED", 0);
    define("MODULE_DISABLED", 2);
    define("MODULE_ENABLED", 4);
    define("TEMPLATE_STORAGE", "storage");
    define("TEMPLATE_MODULE", "module");
    define("TEMPLATE_COMPOSITE", 1);
    define("TEMPLATE_SIMPLE", 0);
    define("OPERATION_ADMIN", "admin");
    define("OPERATION_LIST", "list");
    define("OPERATION_ITEM", "item");
    define("OPERATION_EMAIL", "email");
    define("OPERATION_SEARCHRESULT", "searchresult");
    define("TEMPLATE_ADMIN", "TEMPLATE_ADMIN");
    define("TEMPLATE_DEFAULT", "TEMPLATE_DEFAULT");
    define("TEMPLATE_EMPTY", "TEMPLATE_EMPTY");
    define("IMG_WIDTH", "50");
    define("IMG_HEIGHT", "50");
    define("SETTING_SYSTEM", 1);
    define("SETTING_USER", 0);
    define("BLOBS_ALL", "all");
    define("EDITOR_NORMAL", "normal");
    define("EDITOR_VALIDATING", "validating");
    define("EDITOR_RENDERING", "rendering");
    define("EDITOR_SAVING", "saving");
    define("EDITOR_ERROR", "error");
    define("EDITOR_SAVED", "saved");
    define("EDITOR_ACTION_NONE", "");
    define("EDITOR_ACTION_SAVE", "save");
    define("EDITOR_ACTION_CANCEL", "cancel");
    define("EDITOR_ACTION_APPLY", "apply");
    define("EDITOR_ACTION_SUBACTION", "subaction");
    define("EDITOR_ACTION_SUBACTION_ADDMULTILINK", "addmultilink");
    define("EDITOR_ACTION_SUBACTION_REMOVEMULTILINK", "removemultilink");
    define("MOVEDOWN", "0");
    define("MOVEUP", "1");
    define("SYSTABLE_PREFIX", "sys");
    define("OBJECT_USERTABLE","U");
    define("OBJECT_SYSTABLE","S");
    define("OBJECT_FUNCTION","FN");
    define("OBJECT_PROCEDURE","P");
    define("OBJECT_PRIMARYKEY","PK");
    define("OBJECT_VIEW","V");
    define("OBJECT_DEFAULT","D");
    define("DB_OP_INSERT", "INSERT");
    define("DB_OP_DELETE", "DELETE");
    define("DB_OP_UPDATE", "UPDATE");
    define("DB_ENT_TABLE", "TABLE");
    define("DB_ENT_ROW", "ROW");
    define("DB_ENT_FIELD", "FIELD");
    define("PHP_CODE", "PHP_CODE");    
    define("HTML_CSS", "HTML_CSS");    
    define("HTML_SCRIPT", "HTML_SCRIPT");    
    define("HTML_OBJECT", "HTML_OBJECT");    
    define("HTML_XSLT", "HTML_XSLT");    
    define("HTML_XML", "HTML_XML");    
    define("ACCESS_LOG", 0);
    define("ERROR_LOG", 1);
    define("BYNAME", 0);
    define("BYDOMAIN", 1);
    define("FOLDER", 0);
    define("PUBLICATION", 1);
    define("VERTICAL", 0);
    define("HORIZONTAL", 1);
    define("OUTTO_COMMENT", 0);
    define("OUTTO_PAGE", 0);
    define("OUT_BEFORE", 1);
    define("OUT_AFTER", 0);
    define("BTNS_OK_ONLY", 0);
    define("BTNS_OK_CANCEL", 1);
    define("BTNS_YES_NO", 2);
    define("BTNS_CLOSE", 3);
    define("TOOLBAR_IMAGEONLY", 0x01);
    define("TOOLBAR_TEXTONLY", 0x02);
    define("TOOLBAR_IMAGETEXT", 0x03);
    define("TOOLBAR_BUTTON_LEFT", 0x01);
    define("TOOLBAR_BUTTON_RIGHT", 0x02);
    define("COMMANDBAR_BUTTON_LONG", 0x01);
    define("COMMANDBAR_BUTTON_SHORT", 0x02);
    define("DEVELOPING", "developing");
    define("RELEASE", "release");
    define("SECURITYMODE_SIMPLE", "simple");
    define("SECURITYMODE_EMBEDED", "embeded");
    define("CONTROL_REQUIRED", "<span class='required'>&nbsp;*</span>");
    define("ERROR", false);
    define("OK", true);
    define("MATE_DEFAULT", "1,1,1");
    define("MATE_BLUE", "76,101,128");
    define("DEPRECATED", "This functions are deprecated. If you see this message, please corrent the bug or if you don't have the permissions contact the developer team.");
    function deprecate() {
        iout(DEPRECATED, debug_backtrace());
    }
    function array_object_search(&$data, $key, $value){
        $result = array();
        for ($i = 0; $i < count($data); $i++)
            if ($data[$i]->$key == $value) $result[] = $i;
        return (count($result) > 0) ? $result : false;
    }
    function array_object_fsearch(&$data, $key, $value, $tol){
        $result = array();
        for ($i = 0; $i < count($data); $i++)
            if (($data[$i]->$key >= ($value - $tol)) && ($data[$i]->$key <= ($value + $tol))) $result[] = $i;
        return (count($result) > 0) ? $result : false;
    }
    function array_to_object($v) {
        $ret = new stdClass();
        foreach($v as $k => $o) {
            $ret->$k = $o;
        }
        return $ret;
    }
    function associate($arrayKeys, $arrayValues){
        if(count($arrayKeys) != count($arrayValues))
            return false;
        $ret = array();
        for($i=0; $i<count($arrayKeys); $i++) {
            $ret[trim($arrayKeys[$i])] = $arrayValues[$i];
        }
        return $ret;
    }
    function associateObj($arrayKeys, $arrayValues){
        if(count($arrayKeys) != count($arrayValues))
            return false;
        $ret = new stdClass();
        for($i=0; $i<count($arrayKeys); $i++) {
            $f = trim($arrayKeys[$i]);
            $ret->$f = $arrayValues[$i];
        }
        return $ret;
    }
    function xml_clean($value){
        $value = preg_replace("/\\r/mi", "", $value);
        $value = preg_replace("/\\n/mi", "", $value);
        return preg_replace("/>\s*</mi", "><", $value);
    }
    function make_seed()
    {
       list($usec, $sec) = explode(' ', microtime());
       return (float) $sec + ((float) $usec * 100000);
    }
    function round2($number, $pres = 2) {
        $num = round($number, $pres);
        if((int)$num != $num) {
            $parts = preg_split('/\./', $num);
            return $parts[0].'.'.$parts[1].($pres-strlen($parts[1])-1 > 0 ? str_repeat('0', $pres-strlen($parts[1])-1) : '');
        }
        else {
            return ($num.'.'.str_repeat('0', $pres));
        }
    }
	function random_numbers($min, $max, $count) {
        $ar = array();
        $int = ($max - $min)/$count;
        for($i=0; $i<$count; $i++) {
	        $next = ($i == $count - 1) ? $max : (int)($min + $int) - 1;
            $ar[] = int_random($min, $next);
            $min = $next + 1;
        }
        shuffle($ar);
        return $ar;
    }    
    function int_random($min, $max) {
        srand(make_seed());
        return rand($min, $max);
    }
    function str_random($l) {
        $j = 0;
        $tmp = "";
        $c = array();
        $i = 0;
        for($j = 1; $j <= $l; $j++) {
            $i = (int) int_random(0, 2.999999);
            $c[0] = chr((int) int_random(ord("A"), ord("Z")));
            $c[1] = chr((int) int_random(ord("a"), ord("z")));
            $c[2] = chr((int) int_random(ord("0"), ord("9")));
            $tmp = $tmp.$c[$i];
        }
        return $tmp;
    }
    function str_random_ex($l, $chars) {         $j = 0;
        $tmp = "";
        $c = array();
        $i = 0;
        for($j = 1; $j <= $l; $j++) {
            $i = (int) int_random(0, count($chars) - 0.000001);
            for($k=0; $k<count($chars);$k++) {
                $c[(int)$k] = chr((int) int_random(ord($chars[$k][0]), ord($chars[$k][1])));
            }
            $tmp = $tmp.$c[$i];
        }
        return $tmp;
    }
    function num_random($l) {
        $j = 0;
        $tmp = "";
        $c = array();
        $i = 0;
        for($j = 1; $j < $l; $j++) {
            $i = (int) int_random(0, 2.999999);
            $c[0] = chr((int) int_random(ord("0"), ord("9")));
            $c[1] = chr((int) int_random(ord("0"), ord("9")));
            $c[2] = chr((int) int_random(ord("0"), ord("9")));
            $tmp = $tmp.$c[$i];
        }
        return $tmp;
    }
    function char_random($l) {
        $tmp = "";
        $c = array();
        for($i = 0; $i < $l; $i++) {
            $j = (int) rand(0, 1);
            $c[0] = chr((int) int_random(ord("A"), ord("Z")));
            $c[1] = chr((int) int_random(ord("a"), ord("z")));
            $tmp = $tmp.$c[$j];
        }
        return $tmp;
    }
    function dec_random($l){
        return (int) int_random(0, pow(10, 4) - 1);
    }
    function db_datetime($time = null) {
        if(is_null($time)) $time = time();
        return strftime("%Y-%m-%d %H:%M:%S", $time);
    }
    function boolval($value)
    {
        return is_bool($value) ? ( $value ? "true" : "false" ) : "false";
    }
    function str2date($s) {
        $y = substr($s, 0, 4);
        $m = substr($s, 4, 2);
        $d = substr($s, 6, 2);
        $hh = substr($s, 8, 2);
        $mm = substr($s, 10, 2);
        $ss = substr($s, 12, 2);
        return mktime($hh, $mm, $ss, $m, $d, $y);
    }
    function weekday($date){
        if (!is_numeric($date))
            $date = @strtotime($date);
        if (!is_numeric($date))
            return;
        return date("w", $date);
    }
    function day($date){
        if (!is_numeric($date))
            $date = @strtotime($date);
        if (!is_numeric($date))
            return;
        return date("d", $date);
    }
    function month($date){
        if (!is_numeric($date))
            $date = @strtotime($date);
        if (!is_numeric($date))
            return;
        return date("m", $date);
    }
    function year($date){
        if (!is_numeric($date))
            $date = @strtotime($date);
        if (!is_numeric($date))
            return;
        return date("Y", $date);
    }
    function strftime_hday($day){
        $aday = array(1 => "Понедельник", 2 =>"Вторник", 3 => "Среда", 4 => "Четверг", 5 => "Пятница", 6 => "Суббота", 7 => "Воскресенье");
        if (array_key_exists($day, $aday))
            return $aday[$day];
    }
    function strftime_hmon($mon, $decl = true){
        if ($decl)
            $amon = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
        else
            $amon = array("январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
        if (array_key_exists($mon -1, $amon))
            return $amon[$mon - 1];
    }
    function strftime_h($time){
        if (is_numeric($time))
            $time = date("d.m.Y", $time);
        $amonth = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
        global $postback;
        if(!is_null($postback))
            $amonth = $postback->lang->amonth;
        $tms = preg_split("/\./", $time);
        $m = (int) $tms[1];    
        return ((int)$tms[0])." ".$amonth[$m-1]." ".$tms[2];
    }
    function std_hformat_date($datetime, $format = "d.m.Y"){
        return strftime_h(std_format_date($datetime, $format));
    }
    function std_format_date($datetime, $format = "d.m.Y"){
        $timestamp = $datetime;
        if (!is_numeric($datetime))
            $timestamp = strtotime($datetime);
        return date($format, $timestamp);
    }
    function htime_to_date($str){
        $amonth = array("января" => 1, "февраля" => 2, "марта" => 3, "апреля" => 4, "мая" => 5, "июня" => 6, "июля" => 7, "августа" => 8, "сентября" => 9, "октября" => 10, "ноября" => 11, "декабря" => 12);
        $tms = preg_split("/ /", $str);
        $time = $tms[3];
        $times = preg_split("/:/", $time);
        return mktime($times[0], $times[1], 0, $amonth[$tms[1]], $tms[0], $tms[2]);
    }
    function size_to_string($number, $range = 1024, $postfixes = array("bytes", "Kb", "Mb", "Gb", "Tb")){
        for($j=0; $j < count($postfixes); $j++) {
            if($number <= $range)
                break;
            else
                $number = $number/$range;
        }
        $number = round($number, 2);
        return $number." ".$postfixes[$j];
    }
    function time_to_string($number, $range = 60, $postfixes = array("sec.", "min.", "hours")){
        $hours = 0;
        $mins = 0;
        if($number >= 60) {
            $mins = $number % 60;             $number = (int)($number / 60);
            if($number >= 60) {
                $hours = $number % 60;
                $number = (int)($number / 60);
            }
        }
        $txt = "";
                $txt .= str_expand($hours, 2, "0").":";
                $txt .= str_expand($number, 2, "0").":";
                $txt .= str_expand($mins, 2, "0").":";
        $txt = ltrim($txt, "0");
        $txt = ltrim($txt, ":");
        return substr($txt, 0, strlen($txt)-1);
    }
    function format_sequence($secuence, $labels = array("год", "года", "лет"), $viewnumber = false) {
        $s = "";
        if($viewnumber)
            $s = $secuence." ";
        $ssecuence = strval($secuence);
        $sIntervalLastChar = substr($ssecuence, strlen($ssecuence)-1, 1);
        if((int)$secuence > 10 && (int)$secuence < 20)
            return $s.$labels[2];         else {
            switch(intval($sIntervalLastChar)) {
                case 1:
                    return $s.$labels[0];
                case 2:
                case 3:
                case 4:
                    return $s.$labels[1];
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                case 0:
                    return $s.$labels[2];
            }
        }
    }
    function safestrtotime($strInput) {
       $iVal = -1;
       for ($i=1900; $i<=1969; $i++) {
                      $strYear = (string)$i;
           if (!(strpos($strInput, $strYear)===false)) {
               $replYear = $strYear;
               $yearSkew = 1970 - $i;
               $strInput = str_replace($strYear, "1970", $strInput);
           };
       };
       $iVal = strtotime($strInput);
       if ($yearSkew > 0) {
           $numSecs = (60 * 60 * 24 * 365 * $yearSkew);
           $iVal = $iVal - $numSecs;
           $numLeapYears = 0;                   for ($j=$replYear; $j<=1969; $j++) {
               $thisYear = $j;
               $isLeapYear = false;
                              if (($thisYear % 4) == 0) {
                   $isLeapYear = true;
               };
                              if (($thisYear % 100) == 0) {
                   $isLeapYear = false;
               };
                              if (($thisYear % 1000) == 0) {
                   $isLeapYear = true;
               };
               if ($isLeapYear == true) {
                   $numLeapYears++;
               };
           };
           $iVal = $iVal - (60 * 60 * 24 * $numLeapYears);
       };
       return($iVal);
    }
    function format_db_date($fieldValue, $format = "d.m.Y h:i:s"){
        return date($format, strtotime($fieldValue));
    }
    function format_sql_date($format, $dtt){
        if(is_null($dtt))
            return null;
        $arDt = preg_split("/ |\/|:/", $dtt);
        for($i=0; $i<6; $i++) {
            $v = @$arDt[$i];
            if($v == null || $v == " ")
                $arDt[$i] = "00";
        }
        return preg_replace(array("/%d/", "/%m/", "/%Y/", "/%H/", "/%M/", "/%S/"), $arDt, $format);
    }
    function hex2bin($data)
    {
       $len = strlen($data);
       return pack("H" . $len, $data);
    }
    if(!function_exists("ip2long")) {
        function ip2long($ip) {
            $ip = explode(".",$ip);
            if (!is_numeric(join(NULL,$ip)) || count($ip) != 4) {
                return false;
            }
            else {
                return $ip[3]+256*$ip[2]+256*256*$ip[1]+256*256*256*$ip[0];
            }
        }
    }
    if(!function_exists("long2ip")) {
        function long2ip($long) {
                      if ($long < 0 || $long > 4294967295) return false;
           $ip = "";
           for ($i=3;$i>=0;$i--) {
               $ip .= (int)($long / pow(256,$i));
               $long -= (int)($long / pow(256,$i))*pow(256,$i);
               if ($i>0) $ip .= ".";
           }
           return $ip;
        }
    }
    function net_match($network, $ip) {
         $ip_arr = explode('/', $network);
         $network_long = ip2long($ip_arr[0]);
         $x = ip2long($ip_arr[1]);
         $mask =  long2ip($x) == $ip_arr[1] ? $x : 0xffffffff << (32 - $ip_arr[1]);
         $ip_long = ip2long($ip);
         return ($ip_long & $mask) == ($network_long & $mask);
    }
    function create_class($data){
        $result = new stdClass();
        foreach ($data as $k => $v)
            $result->$k = $v;
        return $result;
    }
    function newInstance($cname, $params = null, $iparams = null){
        $inst = null;
        if ($iparams != null){
            $vars = array();
            $i = 0;
            foreach ($iparams as $k => $v){
                $vars[] = "\$iparams[".$i."]";
                $i++;
            }
            $vars = implode(", ", $vars);
                        eval("\$inst = new ".$cname."(".$vars.");");
        } else {
            $inst = new $cname();
        }
        if ($params != null)
            foreach ($params as $k => $v)
                $inst->$k = $v;
        return $inst;
    }
    function handler_exist($handler){
        if (is_array($handler)){
            if (count($handler) < 2) return;
            return method_exists($handler[0], $handler[1]);
        } else {return function_exists($handler);}
    }
    function crop_object_fields($o, $pattern) {
        $ret = new stdClass();
        if (is_array($o)){
            $vars = $o;
        } else if($o instanceof Object) {
            $vars = $o->ToArray();
        } else {
            $vars = get_object_vars($o);
        }
        if($vars) {
            foreach($vars as $name => $var) {
                if(preg_match($pattern, $name) > 0) {
                    $ret->$name = $var;
                }
            }
        }
        return $o instanceof Object ? new Object($ret) : $ret;
    }
    function is_isntanceOf($object, $className) {
        $c = '$b = $object instanceOf '.$className.';';
        eval($c);
        return $b;
    }
    function is_empty($str){
        if(is_object($str))
            return false;
        $res = ($str === null || $str === "");
        return $res;
    }
    function is_guid($guid) {
        $sp1 = str_replace("#", "[0-9A-Fa-f]", "(########-####-####-####-############)");
        $s = preg_replace($sp1, "", $guid);
        return $s == "" || $s == "{}";
    }
    function is_date($value) {
        if(!$value)
            return false;
        if(is_null($value))
            return false;
        if(is_string($value))
            return @strtotime($value) !== false;
        else    
            return true;
    }
    function is_sid($sid) {
        return is_float($sid);
    }
    function is_email($email) {
        return preg_match('/^[A-z0-9][\w.-]*@[A-z0-9\w-.]+\.[A-z0-9]{2,6}$/', $email);
    }
    function is_missing($what) {
        return is_null($what) || empty($what);
    }
    function hide_quotes($str) {
        $str = str_replace("'", "[simple]", $str);
        $str = str_replace("\"", "[double]", $str);
        return $str;
    }
    function revert_quotes($str) {
        $str = str_replace("[simple]", "'", $str);
        $str = str_replace("[double]", "\"", $str);
        return $str;
    }
    function prepare_quotes($str){
        $str = str_replace("'", "\'", $str);
        $str = str_replace('"', '\"', $str);
        return $str;
    }    
    function hide_attribute($str, $quoters = true){
        if ($quoters)
            $str = preg_replace("/\'/", "&rsquo;", $str);
        $str = preg_replace("/\"/", "&quot;", $str);
        $str = preg_replace("/&amp;/", "&", $str);
        $str = preg_replace("/&/", "&amp;", $str);
        $str = preg_replace("/ /", "&nbsp;", $str); 
        return unescape($str);
    }
    function prepare_attribute($str, $quoters = true){
        if ($quoters)
            $str = preg_replace("/\'/", "&rsquo;", $str);
        $str = preg_replace("/\"/", "&quot", $str);
        $str = preg_replace("/&amp;/", "&", $str);
        $str = preg_replace("/&nbsp;/", " ", $str);
        $str = preg_replace("/&/", "&amp;", $str);
        return unescape($str);
    }
    function hide_char($str, $char = "\"") {
        return preg_replace("/".$char."/", hide_attribute($char), $str);
    }
    function html_encode_tags($str) {
        $str = preg_replace("/\"/", "&quot;", $str);
        $str = preg_replace("/&amp;/", "&", $str);
        $str = preg_replace("/&nbsp;/", " ", $str);
        $str = preg_replace("/&/", "&amp;", $str);
        $str = preg_replace("/</", "&lt;", $str);
        $str = preg_replace("/>/", "&gt;", $str);
        return $str;
    }
    function str_expand($s, $l, $c) {
        if( strlen($s) >= $l )
            return $s;
        else
            return str_repeat($c, $l - strlen($s)).$s;
    }
    function str_insertbychar($value, $what, $enc = "utf8"){
        $count = mb_strlen($value, $enc);
        $str = "";
        for ($i = 0; $i < $count; $i++){
            $piece = ($i == 0) ? "" : $what;
            $str .= $piece.mb_substr($value, $i, 1, $enc);
        }
        return $str;
    }
    function quote($value, $char){
        return sprintf("%s%s%s", $char, $value, $char);
    }
    function quote_ex($string, $rString, $multiplier){
        $char = str_repeat($rString, $multiplier);
        return $char.$string.$char;
    }
    function str_replace_ex($s, $spl, $repl) {
        if(!is_array($spl))
            return str_replace($spl, $repl, $s);
        $ss = $s;
        for($i=0; $i < count($spl); $i++)
            $ss = str_replace($spl[$i], $repl, $ss);
        return $ss;
    }
    function str_trim_length($str, $length, $ellipsis = "...") {
        if(mb_strlen($str, "utf-8") > $length)
            return mb_substr($str, 0, $length-3, "UTF-8").$ellipsis;
        else
            return $str;
    }
    function str_clip($str, $length) {
        return str_trim_length($str, $length);
    }
    function clip_filename($str, $length) {
        $strlen = mb_strlen($str, "utf-8");
        if($strlen <= $length)
            return $str;
        $cliplen = (int)(($length - 3)/2);
        return mb_substr($str, 0, $cliplen, "utf-8").'...'.mb_substr($str, $strlen - $cliplen - 1, $strlen, "utf-8");
    }
    function html_strip($html) {
        $search = array ('@<script[^>]*?>.*?</script>@sim',
                        '@<\!--(.*?)-->@sim',          
                        '@<[\/\!]*?[^<>]*?>@sim',      
                        '@([\r\n])[\s]+@',            
                        '@&(quot|#34);@i',            
                        '@&(amp|#38);@i',
                        '@&(nbsp|#160);@i',
                        '@&(iexcl|#161);@i',
                        '@&(cent|#162);@i',
                        '@&(pound|#163);@i',
                        '@&(copy|#169);@i',
                        '@&#(\d+);@e');               
        $replace = array ('',
                        '',
                        '',
                        '\1',
                        '"',
                        '&',
                        ' ',
                        chr(161),
                        chr(162),
                        chr(163),
                        chr(169),
                        'chr(\1)');
        $html = preg_replace($search, $replace, $html);
        return $html;
    }
    function html_clean($html) {
        return preg_replace(array(
            "/class=[\"|'][^\"']*[\"|']/",
            "/style=[\"|'][^\"']*[\"|']/",
            "/<a [^>]*>(.*?)<\/a>/im"
            ), array(
                "", 
                "",
                "\$1"
            ), $html);
    }
    function db_prepare($str) {
        $str = addslashes($str);
        $str = preg_replace("/\r\n/", "\\r\\n", $str);
        return $str;
    }
    function html_prepare($html) {
        $search = array ('@\"@si');
        $replace = array ('&quot;');
        return preg_replace($search, $replace, $html);
    }
    function FirstNWords($text, $n, $ellipsis = "...") {
        $text = trim($text);
        $a = preg_split("/ |,|\.|-|;|:|\(|\)|\{|\}|\[|\]/", $text);
        if (count($a) > 0) {
            if (count($a) == 1)
                return $text;
            else if(count($a) < $n)
                return $text;
            $l = 0;
            for($j=0; $j<$n;$j++) {
                $l = $l + mb_strlen($a[$j])+1;
            }
                        return substr($text, 0, $l).$ellipsis;
        }
        else {
            return substr($text, 0, $n);
        }
    }
    function trim_text($text, $length, $start = 0, $ellipsis = "..."){
        $tlen = strlen($text);
        if ($start >= $tlen)
            return $text;
        if ($length + $start > $tlen)
            $length = $tlen;
        $value = substr($text, $start, $length);
        $value = ($start != 0) ? $ellipsis.$value : $value;
        $value .= ($length + $start < $tlen) ? $ellipsis : "";
        return $value;
    }
    function striplen($text, $l){
        if (strlen($text) > $l+3) {
            return substr($text, 0, $l)."...";
        }
        else
            return $text;
    }
    function url($u){
        if(strtolower(substr($u, 0, 7)) != "http://")
            return "http://".$u;
        else
            return $u;
    }
    function add2url($args, $url = ""){         if (count($args) == 0)
            return "/".$url;
        $a = array();
        $query = array();
        $url = is_empty($url) ? $_SERVER["SCRIPT_URI"].substr($_SERVER["REQUEST_URI"], 1) : $url;
        $a = parse_url($url);
        $scheme = "";
        if (array_key_exists("scheme", $a))
            $scheme = $a["scheme"];
        $host = "";
        if (array_key_exists("host", $a))
            $host = $a["host"];
        $path = $a["path"];
        if (array_key_exists("query", $a))
            parse_str($a["query"], $query);
        $ext = array();
        foreach ($query as $k => $v)
            if (!is_numeric($k))
                $ext[$k] = $v;
        $args = array_merge($args, $ext);
                $rewr = "";
        $params = "";
        $fileExists = stripos($path, ".") === true;
                $rewrited_path = "";
        $p = explode("&", $path);
        foreach ($p as $v){
            list($key, $value) = explode("=", $v);
            if (($key == "folder" || $key == "publication") && !$fileExists)
                $rewrited_path .= "/".$value;
        }
        if ($rewrited_path)
            $path = $rewrited_path."/";
        foreach ($args as $k => $v){
            if (($k == "folder" || $k == "publication") && !$fileExists)
                $rewr .= "/".$v;
            else
                $params .= "&".$k."=".$v;
        }
        $piece = ($scheme ? $scheme."://" : "").$host;
        $piece .= $rewr;
        $piece .= (substr($path, 0, 1) == "/" ? "" : "/").$path;
        $piece .= "?".substr($params, 1);
                return $piece;
    }
    function escape($str) {  
        $str =  rawurlencode($str);  
        $str = str_replace(array('%40', '%2A', '%2B', '%2F'), array('@', '*', '+', '/'), $str);  
        return $str;  
    }
    function unescape($s)
    {
        $s = preg_replace_callback(
            '/% (?: u([A-F0-9]{1,4}) | ([A-F0-9]{1,2})) /sxi',
            '_unescapeCallback',
            $s
        );
        return $s;
    }
    function _unescapeCallback($p)
    {
        $c = '';
        if ($p[1])
            {
            $u = pack('n', $dec=hexdec($p[1]));
            $c = @iconv('UCS-2BE', 'windows-1251', $u);
            }
        return $c;
    }
    function split_fname($fn){
        $fn1 = "";
        $tmp = preg_split("/\./", basename($fn));
        for($i=0; $i < count($tmp)-1; $i++)
            $fn1 .= ".".$tmp[$i];
        return array(dirname($fn), substr($fn1, 1), $tmp[count($tmp)-1]);
    }
    function split_path($fn){
        $fn1 = "";
        $tmp = preg_split("/\./", basename($fn));
        for($i=0; $i < count($tmp)-1; $i++)
            $fn1 .= ".".$tmp[$i];
        return array("dir" => dirname($fn), "name" => substr($fn1, 1), "ext" => $tmp[count($tmp)-1]);
    }
    function convert_string($dest_charset, $what) {
        $enc = mb_detect_encoding($what);
        return mb_convert_encoding($what, $dest_charset, $enc);
    }
    function url_encode($url) {
        $url = preg_replace("/=/", ":", $url);
        $url = preg_replace("/&/", ";", $url);
        return $url;
    }
    function url_decode($url) {
        $url = preg_replace("/\:/", "=", $url);
        $url = preg_replace("/\;/", "&", $url);
        return $url;
    }
    function abbrivate($text){
        $c = "";
        $a = preg_split("/[-\. ;:\(\),]/i", $text);
        foreach($a as $b) {
            $c .= strtoupper(substr($b, 0, 1));
        }
        return $c;
    }
    function charCount($text) {
        return mb_strlen($text, "UTF-8");
    }
    function charAt($text, $i) {
        return mb_substr($text, $i, 1, "UTF-8");
    }
    function capital($text) {
        return to_upper(substring($text, 0, 1)).substring($text, 1);
    }
    function substring($text, $start, $length = null) {
        if(is_null($length))
            $length = len($text);
        return mb_substr($text, $start, $length, 'utf-8');
    }
    function len($text) {
        return mb_strlen($text, 'utf8');
    }
    function to_upper($text) {
        return mb_strtoupper($text, "UTF-8");
    }
    function to_lower($text) {
        return mb_strtolower($text, "UTF-8");
    }
    function insertHtmlBrakes($text) {
                return str_replace("\r", "<br />\n", $text);
    }                      
    function html2xhtml ($string)
    {
        $string = preg_replace ("/(<\/?)(\w+)([^>]*>)/e"
                               ,"'\\1'.strtolower('\\2').htmlatt2xhtml('\\3')"
                               ,$string
                               );
        $string = preg_replace ("/(<)(br|img|input|meta|link)([^>]*?)((?<!\/)>)/"
                               ,"\\1\\2\\3 />"
                               ,$string
                               );
        return $string;
    } 
    function htmlatt2xhtml ($string)
    {
        $string = stripslashes ($string);
        $string = stripslashes (preg_replace ("/\s(\w+=(?!\"|'))([^\s>]*)/e"
                                             ,"strtolower(' \\1').\"'\\2'\""
                                             ,$string
                                             ));
        $string = stripslashes (preg_replace ("/\s(\w+=)[\"|']([^\"|']+)([^\s>]*)/e"
                                             ,"strtolower(' \\1').hide_attribute(\"'\\2'\", false)"
                                             ,$string
                                             ));
        $string = stripslashes (preg_replace ("/(\s)(\w+)(\s|>)/e"
                                         ,"'\\1'.strtolower('\\2').'=\''.strtolower('\\2').'\'\\3'"
                                             ,$string
                                             ));
        $string = stripslashes (preg_replace ("/\s(\w+=)[\"|']([^\"|']+)([^\s>]*)/e"
                                             ,"strtolower(' \\1').prepare_attribute(\"'\\2'\", false)"
                                             ,$string
                                             ));
        return $string;
    }
    function smallzine_function ($string)
    {
        $string = str_replace('&', '&amp;', str_replace('"', '&quot;', preg_replace("/<([^>]*)>/e"
                                                         ,"'<'. str_replace('\"','\'',\"\\1\").'>'"
                                                         ,$string
                                                         )));
        return unescape($string);
    }
    function validate($html){
        global $HTML_RULES;
        if(is_array($HTML_RULES))
            foreach($HTML_RULES as $rule => $value) {
                $html = preg_replace($rule, $value, $html);
            }
        $html = html2xhtml($html);
        return $html;
    }
    function validateXHTML($html) {
        $arrTagsRemove = array();
        $arrTagsAdd = array();
        $arrTagsNotComplete = array("", "br", "br/", "img");
        preg_match_all("/<([^\s|>]*).*?>/", $html, $matches, PREG_SET_ORDER);
        if(count($matches) > 0) {
            foreach($matches as $match) {
                $m = $match[1];
                if(substr($m, 0, 1) != "/") {
                    if(array_search($m, $arrTagsNotComplete) == false) {
                        if(!isset($arrTagsRemove[$m]))
                            $arrTagsRemove[$m] = 0;
                        $arrTagsRemove[$m]++;
                    }
                }
            }
            foreach($matches as $match) {
                $m = $match[1];
                if(substr($m, 0, 1) == "/") {
                    $m = substr($m, 1);
                    if(array_search($m, $arrTagsNotComplete) == false) {
                        if(!isset($arrTagsRemove[$m]))
                            $arrTagsRemove[$m] = 0;
                        $arrTagsRemove[$m]--;
                    }
                }
            }
        }
        foreach($arrTagsRemove as $k => $v) {
            if($v > 0)
                $html .= str_repeat("</".$k.">", $v);
            else {
                if($v < 0) 
                    $html = str_repeat("<".$k.">", abs($v)).$html;
            }
        }
        return $html;
    }
    function out(){
        $args = func_get_args();
        $count = count($args);
        $result = array();
        for ($i = 0; $i < $count; $i++){
            switch (gettype($args[$i])){
                case "boolean" :
                    $result[] = cbool($args[$i]);
                    break;
                case "NULL" :
                    $result[] = "NULL";
                    break;
                default :
                    $result[] = print_r($args[$i], true);
            }
        }
        echo "<pre>\n" . implode(" : ", $result) . "\n</pre>";
    }
    function iout($what){
        $args = func_get_args();
        $count = count($args);
        $result = array();
        for ($i = 0; $i < $count; $i++){
            switch (gettype($args[$i])){
                case "boolean" :
                    $result[] = cbool($args[$i]);
                    break;
                case "NULL" :
                    $result[] = "NULL";
                    break;
                default :
                    $result[] = print_r($args[$i], true);
            }
        }
        $result = print_r($result, true);
        $clickevent = "onclick='javascript: iout_toggle(event);'";
        $result = preg_replace("/\s*?\[(.*)\] \=> (.*?)\n/mi", "\n<div class='legend' ".$clickevent.">[\$1] => \$2</div>\n", $result);
        $result = preg_replace("/(<div class='legend' ".preg_quote($clickevent).">.*<\/div>)\n\s*?\(/mi", "\n<div class='object'><div class='hilite'>\$1</div><div class='children' style='display: none'>\n", $result);
        $result = preg_replace("/\n\s*?\)\n/", "\n</div></div>\n", $result);
        $result = preg_replace("/Array\n\(\n/i", "\n<div class='result'><div class='object'><div class='legend' ".$clickevent.">IOUT - Result</div><div class='children'>\n", $result);
        echo '
            <style type="text/css">
                div.legend {
                    cursor: default;
                    cursor: expression("hand");
                    padding-top: 2px;
                    padding-bottom: 2px;
                }
                div.legend span {
                    margin-left: 5px;
                }
                div.object {
                    font-size: 12px;
                    font-family: courier new;
                }
                div.children {
                    margin-left: 50px;
                    padding-top: 1px;
                    padding-bottom: 1px;
                    border-left: 1px solid #f9f9f9;
                    min-height: 5px;
                    height: expression("5px");
                }
                div.result {
                    border: 1px solid #f2f2f2;
                    padding: 10px;
                }
                div.hilite {
                    color: #050;
                }
            </style>
            <script language="javascript">
                function iout_toggle(e) {
                    var parent = null;
                    if(e.srcElement)
                        parent = e.srcElement.parentElement;    
                    else {
                        parent = e.currentTarget.parentNode;
                    }
                    if(parent.className == "hilite") {
                        if(e.srcElement)
                            parent = parent.parentElement;
                        else
                            parent = parent.parentNode;
                        var children = parent.childNodes[1];
                        children.style.display = children.style.display == "" ? "none" : "";
                    }
                }
            </script>
        '.$result.'</div>';
    }
    function guidclear($guid) {
        return strtolower(str_replace("}", "", str_replace("{", "", str_replace("-", "", $guid))));
    }
    function guidmake($guid) {
        $sPart1 = substr($guid, 1, 8);
        $sPart2 = substr($guid, 9, 4);
        $sPart3 = substr($guid, 13, 4);
        $sPart4 = substr($guid, 17, 4);
        $sPart5 = substr($guid, 21);
        return "{".$sPart1."-".$sPart2."-".$sPart3."-".$sPart4."-".$sPart5."}";
    }
    function newid() {
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }
        else {
            mt_srand((double)microtime()*10000);              $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);            $uuid = chr(123)                    .substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12)
                    .chr(125);            return $uuid;         }
    }
    function ordto($ch){
        $aord = array(":" => "dbldot", "/" => "slash", "\\" => "backslash");
        if(array_key_exists($ch, $aord))
            return $aord[$ch];
        return $ch;
    }
    function image_text($text, $bc = "FFFFFF", $c = "c60925", $alignment = HORIZONTAL, $ord = false) {
        $ret = "";
        $dn = "/images/alphabet/".$bc."_".$c."/";
        $istrcount = strlen($text);
        for($i = 0; $i < $istrcount; $i++) {
            $t = ordto($text[$i]);
            if($ord)
                $t = ord($t);
            if($text[$i] == " ")
                $ret .= "<img src=\"".$dn."space.gif\" class=\"symbol\" alt=\"\" />".($alignment == VERTICAL ? "<br />" : "");
            else
                $ret .= "<img src=\"".$dn.$t.".gif\" class=\"symbol\" alt=\"\" />".($alignment == VERTICAL ? "<br />" : "");
        }
        return $ret;
    }
    function charsetCooser($name, $value, $classname = "", $style = "", $adtags = "") {
        $elShort = array(
            "windows-1251" => "Cyrillic Alphabet (Windows)",
            "utf-8" => "Universal Alphabet (UTF-8)",
            "big5" => "Chinese Traditional (Big5)", 
            "euc-kr" => "Korean (EUC)",
            "iso-8859-1" => "Western Alphabet",
            "iso-8859-2" => "Central European Alphabet (ISO)",
            "iso-8859-3" => "Latin 3 Alphabet (ISO)",
            "iso-8859-4" => "Baltic Alphabet (ISO)",
            "iso-8859-5" => "Cyrillic Alphabet (ISO)",
            "iso-8859-6" => "Arabic Alphabet (ISO)",
            "iso-8859-7" => "Greek Alphabet (ISO)",
            "iso-8859-8" => "Hebrew Alphabet (ISO)",
            "koi8-r" => "Cyrillic Alphabet (KOI8-R)",
            "shift-jis" => "Japanese (Shift-JIS)",
            "x-euc" => "Japanese (EUC)",
            "windows-1250" => "Central European Alphabet (Windows)",
            "windows-1252" => "Western Alphabet (Windows)",
            "windows-1253" => "Greek Alphabet (Windows)",
            "windows-1254" => "Turkish Alphabet",
            "windows-1255" => "Hebrew Alphabet (Windows)",
            "windows-1256" => "Arabic Alphabet (Windows)",
            "windows-1257" => "Baltic Alphabet (Windows)",
            "windows-1258" => "Vietnamese Alphabet (Windows)",
            "windows-874" => "Thai (Windows)"
        );
        $ret = '<select name="'.$name.'" class="'.$classname.'" style="'.$style.'" '.$adtags.'>';
        $ret .= '<option value="" '.($value=="" ? "selected" : "").'> - choose charset - </option>';
        foreach($elShort as $v => $e) {
            $ret .= '<option value="'.$v.'" '.($value==$v ? "selected" : "").'>'.$e.'</option>';
        }
        $ret .= '</select>';
        return $ret;    
    }
                    function getStyleScheet($fname, $additems = array()) {
        if (file_exists($fname))
            $content = file_get_contents($fname);
        else
            $content = file_get_contents("http://".$_SERVER['SERVER_NAME'].$fname);
        $content = str_replace("\n", "", $content);
        $content = str_replace("\r", "", $content);
        $content = str_replace("\n\r", "", $content);
        $re = "/\.([^\{|\.]*) \/\*([^\*]*)\*\/ ?\{/";
        preg_match_all($re, $content, $matches, PREG_PATTERN_ORDER);
        $arRet = array();
        for($i=0; $i<count($matches[1]); $i++) {
            $arRet[$matches[1][$i]] = $matches[2][$i]." (.".$matches[1][$i].")";
        }
        array_multisort($arRet, SORT_ASC, SORT_STRING);
        $arRet = array_merge($additems, $arRet);
        return $arRet;
    }
    function RenderVerticalCheck($name, $value, $width, $height, $required, $storage, $fields, $shows, $rows, $idfield, $classes = null ) {
        $ret = "";
        if(is_null($classes)) {
            $classes = array(
                "main-box" => "vertical-check-main-box",
                "title" => "vertical-check-title",
                "value" => "vertical-check-value",
                "row" => "vertical-check-row",
                "selectedrow" => "vertical-check-selected-row",
                "radio" => "vertical-check-radio"
            );
        }
        $classbox = $classes["main-box"];
        $classtitle = $classes["title"];
        $classvalue = $classes["value"];
        $classrow = $classes["row"];
        $classselectedrow = $classes["selectedrow"];
        $classradio = $classes["radio"];
        $ret .= '
        <script language="javascript">
            var var'.$name.'selected = null;
            function do'.$name.'Check(obj) {
                if(obj != var'.$name.'selected) {
                    if(var'.$name.'selected != null)
                        var'.$name.'selected.className = "'.$classrow.'";
                    var'.$name.'selected = obj;
                    if(var'.$name.'selected != null)
                        var'.$name.'selected.className = "'.$classselectedrow.'";
                }    
                if(var'.$name.'selected != null) {
                    var'.$name.'selected.rows[0].cells[0].childNodes[0].checked = true;
                    if(!document.all)
                        var'.$name.'selected.rows[0].cells[0].childNodes[1].checked = true;
                }
            }
        </script>
        <div id="id'.$name.'" style="width: '.$width.'; height: '.$height.';" class="'.$classbox.'">
        ';
        if (!$required){
            $crow = is_null($value) ? $classselectedrow : $classrow;
            $selected = is_null($value) ? " selected" : "";
            $id = is_null($value) ? " id='".$name."selected'" : "";
            $ret .= '
                <table cellpadding="2" cellspacing="1" width="100%" class="'.$crow.'" onclick="javascript: return do'.$name.'Check(this);" '.$id.'>
                    <tr>
                        <td width="20" class="'.$classradio.'">
                            <input type="radio" name="'.$name.'" value=""'.$selected.'>
                        </td>
                        <td class="'.$classvalue.'">
                            Not selected
                        </td>
                    </tr>
                </table>
            ';
        }
        foreach($rows as $row) {
            $crow = $row->$idfield == $value ? $classselectedrow : $classrow;
            $selected = $row->$idfield == $value ? " checked selected" : "";
            $id = $row->$idfield == $value ? " id='".$name."selected'" : "";
            $ret .= '
                <table cellpadding="2" cellspacing="1" width="100%" class="'.$crow.'" onclick="javascript: return do'.$name.'Check(this);" '.$id.'>
                    <tr>
                        <td width="20" class="'.$classradio.'">
                            <input type="radio" name="'.$name.'" value="'.$row->$idfield.'"'.$selected.'>
                        </td>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="1">
            ';
            foreach($shows as $field) {
                $fff = $storage->fromfname($field);
                $ff = $fields->$fff;
                $f = $field;
                $v = @$row->$f;
                $v = FirstNWords(html_strip($v), 10);
                if($ff->type == "blob") {
                    $v = new Blob($v);
                    $v = $v->Img(new Size(100, 75));
                }
                if(!is_null($v)) {
                    $ret .= '
                            <tr>
                                <td width="120" class="'.$classtitle.'">
                                    '.(is_null($ff) ? $field : str_clip($ff->name, 20)).'
                                <td>
                                <td class="'.$classvalue.'">
                                    '.$v.'
                                </td>
                            </tr>
                    ';
                }
            }
            $ret .= '
                            </table>
                        </td>
                    </tr>
                </table>
            ';
        }
        $ret .= '
            <script language="javascript">
                var'.$name.'selected = document.getElementById(\''.$name.'selected\');
            </script>
        </div>
        ';
        return $ret;    
    }
    function RenderSelectCheck($name, $value, $width, $required, $rows, $idfield, $show, $classes = null ) {
        if(is_null($classes)) {
            $classes = array(
                "select" => "select-check",
                "option" => "select-check-option"
            );
        }
        $classselect = $classes["select"];
        $classoption = $classes["option"];
        $ret = "";
        $ret .= '<select name="'.$name.'" class="'.$classselect.'" style="width: 60%;">';
        if (!$required){
            $selected = (is_empty($value)) ? " selected" : "";
            $ret .= "<option value='{null}' ".$selected." class='".$classoption."'>Not selected</option>";
        }
        foreach($rows as $row) {
            $leveled = !is_null(@$row->level) ? @str_repeat('&nbsp;', (@$row->level - 1)*10) : '';
            $selected = ($row->$idfield == $value) ? " selected" : "";
            $field_value = html_strip($row->$show);
            $field_value = FirstNWords(html_strip($field_value), 10);
            $ret .= '<option value="'.$row->$idfield.'" '.$selected.' class="'.$classoption.'">'.$leveled.$field_value.'</option>';
        }
        $ret .= '</select>';
        return $ret;
    }
    function RenderVerticalCheckboxes($name, $value, $width, $height, $required, $classes = null ) {
        $ret = "";
        $rows = $value->Rows();
        if(is_null($classes)) {
            $classes = array(
                "main-box" => "vertical-check-main-box",
                "title" => "vertical-check-title",
                "value" => "vertical-check-value",
                "row" => "vertical-check-row",
                "selectedrow" => "vertical-check-selected-row",
                "check" => "vertical-check-check"
            );
        }
        $classbox = $classes["main-box"];
        $classtitle = $classes["title"];
        $classvalue = $classes["value"];
        $classrow = $classes["row"];
        $classselectedrow = $classes["selectedrow"];
        $classradio = $classes["check"];
        $ret .= '
        <div id="id'.$name.'" style="width: '.$width.'; height: '.$height.';" class="'.$classbox.'">
            <table cellpadding="2" cellspacing="1" width="100%" id="id'.$name.'table">
        ';
        if($rows->count() > 0) {
            while($row = $rows->FetchNext()) {
                $ret .= '
                    <tr onclick="javascript: return setRowCheck(this);" id="'.$name.'_'.$row->id.'row">
                        <td>
                ';
                $ret .= $row->Out(null, Hashtable::Create("admin_checkboxes", false), OPERATION_ADMIN);
                $ret .= '
                        </td>
                        <td width="20" class="'.$classradio.'"><input type="checkbox" name="'.$name.'_'.$row->id.'" value="'.$row->id.'" hilitable=1></td>
                    </tr>
                ';
            }
        }
        $ret .= '
            </table>
        </div>
        ';
        return $ret;    
    }
    function generateValidationImage($rand) {
        $width = 120;
        $height = 40;
        $image = imagecreate($width, $height);
        $bgColor = imagecolorallocate ($image, 255, 255, 255);
        $textColor = imagecolorallocate ($image, 0, 0, 0);
                for ($i = 0; $i < 250; $i++) {
            $rx1 = rand(0,$width);
            $rx2 = rand(0,$width);
            $ry1 = rand(0,$height);
            $ry2 = rand(0,$height);
            $rcVal = rand(0,255);
            $rc1 = imagecolorallocate($image, 
                                        rand(0,255), 
                                        rand(0,255), 
                                        rand(100,255));
            imageline ($image, $rx1, $ry1, $rx2, $ry2, $rc1);
        }
        global $CORE_PATH;
        $font = imageloadfont($CORE_PATH."extras/fonts/anonymous.gdf");
        imagestring($image, $font, 3, 0, $rand, $textColor);
                header('Content-type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }
    function redirect($url) {
        header("Location: $url");
    }
    function JsRedirect($url, $after = -1 , $out = true){
        if($out) {
            if($after > 0)
                echo "<script language='javascript'>window.setTimeout('location=\"".$url."\"',".$after.");</script>";
            else
                echo "<script language='javascript'>location='".$url."'</script>";
        }
        else {
            if($after > 0)
                return "<script language='javascript'>window.setTimeout('location=\"".$url."\"',".$after.");</script>";
            else
                return "<script language='javascript'>location='".$url."'</script>";
        }
    }
    function sendNoCache(){
        header("Pragma: no-cache");
        header("Cache-control: no-cache");
    }
    function sendCharset($charset = "windows-1251"){
        header("Content-Type: text/html; charset=".$charset);
    }
    function jsSetCookie($name, $value, $expire, $path, $domain, $secure, $out = true) {
        $secure = ($secure) ? "true" : "false";
        $ret = '
            <script language="javascript">
                function Set_Cookie( name, value, expires, path, domain, secure ) 
                {
                    var today = new Date();
                    today.setTime( today.getTime() );
                    if ( expires )
                        expires = expires * 1000 * 60 * 60 * 24;
                    var expires_date = new Date( today.getTime() + (expires) );
                    document.cookie = name + "=" +escape( value ) +
                    ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
                    ( ( path ) ? ";path=" + path : "" ) + 
                    ( ( domain ) ? ";domain=" + domain : "" ) +
                    ( ( secure ) ? ";secure" : "" );
                }
                Set_Cookie("'.$name.'", "'.$value.'", '.$expire.', "'.$path.'", "'.$domain.'", '.$secure.');
            </script>
        ';
        if ($out)
            echo $ret;
        else 
            return $ret;
    }
    function remoteaddress() {
        return get_ip();
    }
    function get_ip($remote = false) {
        global $core;
        if($remote)
            return $core->rq->REMOTE_ADDR;
        $RemoteAddress = $core->rq->HTTP_X_REAL_IP;
        if(is_empty($RemoteAddress)) $RemoteAddress = $core->rq->HTTP_X_FORWARDED_FOR;
        if(is_empty($RemoteAddress)) $RemoteAddress = $core->rq->REMOTE_ADDR;
        return $RemoteAddress;
    }
    function remoteip() {
        return ip2long(get_ip(true));
    }
    function localip() {
        return ip2long(get_ip());
    }
    function modified_since($datemodified){
        if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            $mods = trim($_SERVER['HTTP_IF_MODIFIED_SINCE']);
            $modss = explode(";", $mods);
            if(count($modss) > 1)
                $mods = $modss[0];
            return @gmdate('D, d M Y H:i:s', $datemodified)." GMT" != $mods;
        }
        else
            return true;
    }
    function browser_detection( $which_test, $useragent = null ) {
        static $dom_browser, $safe_browser, $browser_user_agent, $os, $browser_name, $s_browser, $ie_version, 
        $version_number, $os_number, $b_repeat = false, $moz_version, $moz_version_number, $moz_rv, $moz_rv_full, $moz_release, 
        $type, $math_version_number;
        if(!is_null($useragent))
            $b_repeat = false;
        if ( !$b_repeat )
        {
                        $dom_browser = false;
            $type = 'bot';            $safe_browser = false;
            $os = '';
            $os_number = '';
            $a_os_data = '';
            $browser_name = '';
            $version_number = '';
            $math_version_number = '';
            $ie_version = '';
            $moz_version = '';
            $moz_version_number = '';
            $moz_rv = '';
            $moz_rv_full = '';
            $moz_release = '';
            $b_success = false;
                                    if(!is_null($useragent))
                $browser_user_agent = strtolower($useragent);
            else
                $browser_user_agent = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';
                        $a_browser_types[] = array( 'opera', true, 'op', 'bro' );
            $a_browser_types[] = array( 'omniweb', true, 'omni', 'bro' );            $a_browser_types[] = array( 'msie', true, 'ie', 'bro' );
            $a_browser_types[] = array( 'konqueror', true, 'konq', 'bro' );
            $a_browser_types[] = array( 'safari', true, 'saf', 'bro' );
                        $a_browser_types[] = array( 'gecko', true, 'moz', 'bro' );
            $a_browser_types[] = array( 'netpositive', false, 'netp', 'bbro' );            $a_browser_types[] = array( 'lynx', false, 'lynx', 'bbro' );             $a_browser_types[] = array( 'elinks ', false, 'elinks', 'bbro' );             $a_browser_types[] = array( 'elinks', false, 'elinks', 'bbro' );             $a_browser_types[] = array( 'links ', false, 'links', 'bbro' );             $a_browser_types[] = array( 'links', false, 'links', 'bbro' );             $a_browser_types[] = array( 'w3m', false, 'w3m', 'bbro' );             $a_browser_types[] = array( 'webtv', false, 'webtv', 'bbro' );            $a_browser_types[] = array( 'amaya', false, 'amaya', 'bbro' );            $a_browser_types[] = array( 'dillo', false, 'dillo', 'bbro' );            $a_browser_types[] = array( 'ibrowse', false, 'ibrowse', 'bbro' );            $a_browser_types[] = array( 'icab', false, 'icab', 'bro' );            $a_browser_types[] = array( 'crazy browser', true, 'ie', 'bro' );            $a_browser_types[] = array( 'sonyericssonp800', false, 'sonyericssonp800', 'bbro' );            
                        $a_browser_types[] = array( 'yandex', false, 'yandex', 'bot' );
            $a_browser_types[] = array( 'webalta crawler', false, 'altavista', 'bot' );
            $a_browser_types[] = array( 'googlebot', false, 'google', 'bot' );            $a_browser_types[] = array( 'mediapartners-google', false, 'adsense', 'bot' );            $a_browser_types[] = array( 'yahoo-verticalcrawler', false, 'yahoo', 'bot' );            $a_browser_types[] = array( 'yahoo! slurp', false, 'yahoo', 'bot' );             $a_browser_types[] = array( 'yahoo-mm', false, 'yahoomm', 'bot' );             $a_browser_types[] = array( 'inktomi', false, 'inktomi', 'bot' );             $a_browser_types[] = array( 'slurp', false, 'inktomi', 'bot' );             $a_browser_types[] = array( 'fast-webcrawler', false, 'fast', 'bot' );            $a_browser_types[] = array( 'msnbot', false, 'msn', 'bot' );            $a_browser_types[] = array( 'ask jeeves', false, 'ask', 'bot' );             $a_browser_types[] = array( 'teoma', false, 'ask', 'bot' );            $a_browser_types[] = array( 'scooter', false, 'scooter', 'bot' );            $a_browser_types[] = array( 'openbot', false, 'openbot', 'bot' );            $a_browser_types[] = array( 'ia_archiver', false, 'ia_archiver', 'bot' );            $a_browser_types[] = array( 'zyborg', false, 'looksmart', 'bot' );            $a_browser_types[] = array( 'almaden', false, 'ibm', 'bot' );            $a_browser_types[] = array( 'baiduspider', false, 'baidu', 'bot' );            $a_browser_types[] = array( 'psbot', false, 'psbot', 'bot' );            $a_browser_types[] = array( 'gigabot', false, 'gigabot', 'bot' );            $a_browser_types[] = array( 'naverbot', false, 'naverbot', 'bot' );            $a_browser_types[] = array( 'surveybot', false, 'surveybot', 'bot' );            $a_browser_types[] = array( 'boitho.com-dc', false, 'boitho', 'bot' );            $a_browser_types[] = array( 'objectssearch', false, 'objectsearch', 'bot' );            $a_browser_types[] = array( 'answerbus', false, 'answerbus', 'bot' );            $a_browser_types[] = array( 'sohu-search', false, 'sohu', 'bot' );            $a_browser_types[] = array( 'iltrovatore-setaccio', false, 'il-set', 'bot' );
                        $a_browser_types[] = array( 'w3c_validator', false, 'w3c', 'lib' );             $a_browser_types[] = array( 'wdg_validator', false, 'wdg', 'lib' );             $a_browser_types[] = array( 'libwww-perl', false, 'libwww-perl', 'lib' ); 
            $a_browser_types[] = array( 'jakarta commons-httpclient', false, 'jakarta', 'lib' );
            $a_browser_types[] = array( 'python-urllib', false, 'python-urllib', 'lib' ); 
                        $a_browser_types[] = array( 'getright', false, 'getright', 'dow' );
            $a_browser_types[] = array( 'wget', false, 'wget', 'dow' );
                        $a_browser_types[] = array( 'mozilla/4.', false, 'ns', 'bbro' );
            $a_browser_types[] = array( 'mozilla/3.', false, 'ns', 'bbro' );
            $a_browser_types[] = array( 'mozilla/2.', false, 'ns', 'bbro' );
            $moz_types = array( 'firebird', 'phoenix', 'firefox', 'galeon', 'k-meleon', 'camino', 'epiphany', 
            'netscape6', 'netscape', 'multizilla', 'rv' );
            for ($i = 0; $i < count($a_browser_types); $i++)
            {
                                $s_browser = $a_browser_types[$i][0];                if (stristr($browser_user_agent, $s_browser)) 
                {
                                                                                $safe_browser = true;
                                        $dom_browser = $a_browser_types[$i][1];                    $browser_name = $a_browser_types[$i][2];                    $type = $a_browser_types[$i][3];
                    switch ( $browser_name )
                    {
                                                                        case 'ns':
                            $safe_browser = false;
                            $version_number = browser_version( $browser_user_agent, 'mozilla' );
                            break;
                        case 'moz':
                                                        $moz_rv_full = browser_version( $browser_user_agent, 'rv' );
                                                        $moz_rv = substr( $moz_rv_full, 0, 3 );
                                                        for ( $i = 0; $i < count( $moz_types ); $i++ )
                            {
                                if ( stristr( $browser_user_agent, $moz_types[$i] ) ) 
                                {
                                    $moz_version = $moz_types[$i];
                                    $moz_version_number = browser_version( $browser_user_agent, $moz_version );
                                    break;
                                }
                            }
                                                                                    if ( !$moz_rv ) 
                            { 
                                $moz_rv = substr( $moz_version_number, 0, 3 ); 
                                $moz_rv_full = $moz_version_number; 
                            }
                                                        if ( $moz_version == 'rv' ) 
                            {
                                $moz_version = 'mozilla';
                            }
                                                        $version_number = $moz_rv;
                                                        $moz_release = browser_version( $browser_user_agent, 'gecko/' );
                            if ( ( $moz_release < 20020400 ) || ( $moz_rv < 1 ) )
                            {
                                $safe_browser = false;
                            }
                            break;
                        case 'ie':
                            $version_number = browser_version( $browser_user_agent, $s_browser );
                                                        if ( stristr( $browser_user_agent, 'mac') )
                            {
                                $ie_version = 'ieMac';
                            }
                                                        elseif ( $version_number >= 5 )
                            {
                                $ie_version = 'ie5x';
                            }
                            elseif ( ( $version_number > 3 ) && ( $version_number < 5 ) )
                            {
                                $dom_browser = false;
                                $ie_version = 'ie4';
                                                                $safe_browser = true; 
                            }
                            else
                            {
                                $ie_version = 'old';
                                $dom_browser = false;
                                $safe_browser = false; 
                            }
                            break;
                        case 'op':
                            $version_number = browser_version( $browser_user_agent, $s_browser );
                            if ( $version_number < 5 )                            {
                                $safe_browser = false; 
                            }
                            break;
                        case 'saf':
                            $version_number = browser_version( $browser_user_agent, $s_browser );
                            break;
                        case 'omni':
                            $s_browser = 'safari';
                            $browser_name = 'saf';
                            $version_number = browser_version( $browser_user_agent, 'applewebkit' );
                            break; 
                        default:
                            $version_number = browser_version( $browser_user_agent, $s_browser );
                            break;
                    }
                                        $b_success = true;
                    break;
                }
            }
                        if ( !$b_success ) 
            {
                                $s_browser = substr( $browser_user_agent, 0, strcspn( $browser_user_agent , '();') );
                                ereg('[^0-9][a-z]*-*\ *[a-z]*\ *[a-z]*', $s_browser, $r );
                $s_browser = $r[0];
                $version_number = browser_version( $browser_user_agent, $s_browser );
                                            }
                        $a_os_data = which_os( $browser_user_agent, $browser_name, $version_number );
            $os = $a_os_data[0];            $os_number = $a_os_data[1];
                                    $b_repeat = true;
                                    $m = array();
            if ( preg_match('/[0-9]*\.*[0-9]*/', $version_number, $m ) )
            {
                $math_version_number = $m[0]; 
                            }
        }
        switch ( $which_test )
        {
            case 'safe':                                                return $safe_browser; 
                break;
            case 'ie_version':                 return $ie_version;
                break;
            case 'moz_version':                $moz_array = array( $moz_version, $moz_version_number, $moz_rv, $moz_rv_full, $moz_release );
                return $moz_array;
                break;
            case 'dom':                return $dom_browser;
                break;
            case 'os':                return $os; 
                break;
            case 'os_number':                return $os_number;
                break;
            case 'browser':                return $browser_name; 
                break;
            case 'number':                return $version_number;
                break;
            case 'full':                $full_array = array( $browser_name, $version_number, $ie_version, $dom_browser, $safe_browser, 
                    $os, $os_number, $s_browser, $type, $math_version_number );
                return $full_array;
                break;
            case 'type':                return $type;
                break;
            case 'math_number':                return $math_version_number;
                break;
            default:
                break;
        }
    }
        function which_os ( $browser_string, $browser_name, $version_number  )
    {
                $os = '';
        $os_version = '';
        $a_mac = array( 'mac68k', 'macppc' );                $a_unix = array( 'unixware', 'solaris', 'sunos', 'sun4', 'sun5', 'suni86', 'sun', 
            'freebsd', 'openbsd', 'bsd' , 'irix5', 'irix6', 'irix', 'hpux9', 'hpux10', 'hpux11', 'hpux', 'hp-ux', 
            'aix1', 'aix2', 'aix3', 'aix4', 'aix5', 'aix', 'sco', 'unixware', 'mpras', 'reliant',
            'dec', 'sinix', 'unix' );
                $a_linux = array( 'kanotix', 'ubuntu', 'mepis', 'debian', 'suse', 'redhat', 'slackware', 'mandrake', 'gentoo', 'linux' );
        $a_linux_process = array ( 'i386', 'i586', 'i686' );                $a_os = array( 'beos', 'os2', 'amiga', 'webtv', 'mac', 'nt', 'win', $a_unix, $a_linux );
                for ( $i = 0; $i < count( $a_os ); $i++ )
        {
                        $s_os = $a_os[$i];
                                    if ( !is_array( $s_os ) && stristr( $browser_string, $s_os ) && !stristr( $browser_string, "linux" ) )
            {
                $os = $s_os;
                switch ( $os )
                {
                    case 'win':
                        if ( strstr( $browser_string, '95' ) )
                        {
                            $os_version = '95';
                        }
                        elseif ( ( strstr( $browser_string, '9x 4.9' ) ) || ( strstr( $browser_string, 'me' ) ) )
                        {
                            $os_version = 'me';
                        }
                        elseif ( strstr( $browser_string, '98' ) )
                        {
                            $os_version = '98';
                        }
                        elseif ( strstr( $browser_string, '2000' ) )                        {
                            $os_version = 5.0;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, 'xp' ) )                        {
                            $os_version = 5.1;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, '2003' ) )                        {
                            $os_version = 5.2;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, 'ce' ) )                        {
                            $os_version = 'ce';
                        }
                        break;
                    case 'nt':
                        if ( strstr( $browser_string, 'nt 5.2' ) )                        {
                            $os_version = 5.2;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, 'nt 5.1' ) || strstr( $browser_string, 'xp' ) )                        {
                            $os_version = 5.1;                        }
                        elseif ( strstr( $browser_string, 'nt 5' ) || strstr( $browser_string, '2000' ) )                        {
                            $os_version = 5.0;
                        }
                        elseif ( strstr( $browser_string, 'nt 4' ) )                        {
                            $os_version = 4;
                        }
                        elseif ( strstr( $browser_string, 'nt 3' ) )                        {
                            $os_version = 3;
                        }
                        break;
                    case 'mac':
                        if ( strstr( $browser_string, 'os x' ) ) 
                        {
                            $os_version = 10;
                        }
                                                                        elseif ( ( $browser_name == 'saf' ) || ( $browser_name == 'cam' ) || 
                            ( ( $browser_name == 'moz' ) && ( $version_number >= 1.3 ) ) || 
                            ( ( $browser_name == 'ie' ) && ( $version_number >= 5.2 ) ) )
                        {
                            $os_version = 10;
                        }
                        break;
                    default:
                        break;
                }
                break;
            }
                                    elseif ( is_array( $s_os ) && ( $i == ( count( $a_os ) - 2 ) ) )
            {
                for ($j = 0; $j < count($s_os); $j++)
                {
                    if ( stristr( $browser_string, $s_os[$j] ) )
                    {
                        $os = 'unix';                         $os_version = ( $s_os[$j] != 'unix' ) ? $s_os[$j] : '';                        break;
                    }
                }
            } 
                                    elseif ( is_array( $s_os ) && ( $i == ( count( $a_os ) - 1 ) ) )
            {
                for ($j = 0; $j < count($s_os); $j++)
                {
                    if ( stristr( $browser_string, $s_os[$j] ) )
                    {
                        $os = 'lin';
                                                                        $os_version = ( $s_os[$j] != 'linux' ) ? $s_os[$j] : '';
                        break;
                    }
                }
            } 
        }
                $os_data = array( $os, $os_version );
        return $os_data;
    }
            function browser_version( $browser_user_agent, $search_string )
    {
                $substring_length = 12;
                $browser_number = '';
                                $start_pos = 0;  
        for ( $i = 0; $i < 4; $i++ )
        {
                        if ( strpos( $browser_user_agent, $search_string, $start_pos ) !== false )
            {
                                $start_pos = strpos( $browser_user_agent, $search_string, $start_pos ) + strlen( $search_string );
                if ( $search_string != 'msie' )
                {
                    break;
                }
            }
            else 
            {
                break;
            }
        }
                        if ( $search_string != 'gecko/' ) 
        { 
            if ( $search_string == 'omniweb' )
            {
                $start_pos += 2;            }
            else
            {
                $start_pos++; 
            }
        }
                $browser_number = substr( $browser_user_agent, $start_pos, $substring_length );
                $browser_number = substr( $browser_number, 0, strcspn($browser_number, ' );') );
                        if ( !is_numeric( substr( $browser_number, 0, 1 ) ) )
        { 
            $browser_number = ''; 
        }
                return $browser_number;
    }
    function code_cache($cachefile, $original) {
        global $core, $CODECACHE;
        if(is_null($CODECACHE))
            $CODECACHE = true;
        $name = load_file_name($original);
        if($name != '') {
            if($core->fs->FileExists($cachefile, SITE) && ($core->fs->FileLastModified($name, SITE) > $core->fs->FileLastModified($cachefile, SITE)))
                $core->fs->DeleteFile($cachefile, SITE);
        }
        if($CODECACHE && $core->fs->FileExists($cachefile, SITE)) {
            return $core->fs->ReadFile($cachefile, SITE);
        }
        $code = convert_php_context(load_from_file($original));
        $core->fs->WriteFile($cachefile, $code, SITE);
        return $code;
    }
    function convert_php_file($file) {
        global $core;
        return convert_php($core->fs->readfile($file));
    }
    function convert_php_context($code, $contextFieldName = "\$context") {
        return convert_php($code, null, $contextFieldName);
    }
    function convert_php($code, $returnToVarName = "\$ret", $contextFieldName = "\$context") {
        if(strpos($code, "<?") === false || strpos($code, "LOADFILE:") === 0) {
                        if(strpos($code, $returnToVarName.".=") !== false || strpos($code, $returnToVarName." .=") !== false || strpos($code, "LOADFILE:") === 0)
                return $code;
            else 
                $code = "<?=\"".str_replace("\"", "\\\"", $code)."\"?".">";
        }
        $retNameStart = (is_null($returnToVarName) ? $contextFieldName."->Out(" : $returnToVarName." .= ");
        $retNameEnd = (is_null($returnToVarName) ? ");" : ";");
        $code = str_replace("&lt;?", "<"."?", $code);
        $code = str_replace("?&gt;", "?".">", $code);
        $retcode = "";
        $blocks = array();
        $lastpos = 0;
        $i = 1;
        $splitter = "<?";
        while(($ipos = strpos($code, $splitter)) !== false) {
            if($splitter == "?>")
                $blocks[] = "<?".substr($code, 0, $ipos)."?>";
            else
                $blocks[] = substr($code, 0, $ipos);
            $code = substr($code, $ipos + 2);
            $splitter =    ($splitter == "<?" ? "?>" : "<?");
        }
        $blocks[] = substr($code, $ipos);
        $blocks1 = array();
        foreach($blocks as $block) {
            if($block == "")
                continue;
            if(substr(trim($block), 0, 3) == "<?=") {
                $cc = trim(substr(trim($block), 3, strlen(trim($block)) - 5));
                if(substr($cc, strlen($cc)-1, 1) == ";")
                    $cc = substr($cc, 0, strlen($cc)-1);
                $blocks1[] = $retNameStart.$cc.$retNameEnd;
            }
            else if(substr(trim($block), 0, 2) == "<?")
                $blocks1[] = substr(trim($block), 2, strlen(trim($block)) - 4);
            else {
                $block = str_replace("\\","\\\\", $block);
                $block = str_replace("\"","\\\"", $block);
                $block = str_replace("\$","\\\$", $block);
                $blocks1[] = $retNameStart."\"".$block."\"".$retNameEnd;
            }
        }
        $retcode = "";
        foreach($blocks1 as $block) {
            if($block != "")
                $retcode .= $block;
        }
        return $retcode;
    }
    function datediff($time1, $time2){
        if($time1 == $time2)
            return 0;
        if($time1 < $time2) {
            $t = $time1;
            $time1 = $time2;
            $time2 = $t;
        }
        $y1 = (int) date("Y", $time1);
        $y2 = (int) date("Y", $time2);
        $diff = abs($y1 - $y2);
        list($d, $m, $Y, $H, $M1, $S) = explode(",", strftime("%d,%m,".$y2.",%H,%M,%S", $time1));
        $t2 = mktime($H,$M1,$S,$m,$d,$Y);
        if($time2 > $t2)
            $diff--;
        return $diff;
    }
    function load_file_name($content) {
        if(substr($content, 0, 9) == "LOADFILE:") return substr($content, 9);
        return '';
    }
    function load_from_file($content) {
        global $core;    
        if(substr($content, 0, 9) == "LOADFILE:") {
            $content = $core->fs->readfile(substr($content, 9));
        }
        return $content;
    }
    function Using($namespaceName) {
        global $CORE_PATH;
        $namespaceName = $CORE_PATH.str_replace("::", "/", $namespaceName);
        $files = array();
        $exts = array("php", "inc", "lib");
        if ($handle = opendir($namespaceName)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $s = explode(".", $file);
                    $type = $s[count($s) - 1];
                    if(in_array($type, $exts))
                        $files[] = $file;
                }
            }
            closedir($handle);
        }    
        foreach($files as $file) {
            include_once($namespaceName."/".$file);
        }
    }
    function LoadPEAR() {
        global $CORE_PATH;
        require_once($CORE_PATH."extras/PEAR/PEAR.php");
    }
    function LoadExtension($name, $path = "") {
        global $CORE_PATH;
        $path = $CORE_PATH."extras/".($path ? $path : $name)."/";
        LoadPEAR();
        require_once($path.$name.".ext.php");
    }
    function LoadNonPEAR($name, $path = "") {
        global $CORE_PATH;
        $path = $CORE_PATH."extras/".($path ? $path : $name)."/";
        require_once($path.$name.".ext.php");
    }
    function iif($condition, $truepart, $falsepart) {
        if($condition)
            return $truepart;
        else
            return $falsepart;
    }
    function uniqueid() {
        mt_srand((double)microtime()*10000);          $charid1 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);
        $charid2 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);
        $charid3 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);
        $charid4 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);
        list($usec, $sec) = explode(' ', microtime());
        return (floatval($charid1.$charid2.$charid3.$charid4) + $sec + $usec) * $usec;
    }
    function cbool($value){
        return boolval($value);
    }
    function timezone($time){
        global $_TIME_ZONE;
        return $time + ($_TIME_ZONE*60*60);
    }
    function timezoneundo($time){
        global $_TIME_ZONE;
        return $time - ($_TIME_ZONE*60*60);
    }
    function cout() {
        out(OUTTO_COMMENT);
    }
    function print_out($what) {
        out($what);
    }
    function xml_findbyname($element, $nodeName) {
        $elements = $element->childNodes;
        foreach($elements as $el) {
            if($el->nodeType == 1 && $el->nodeName == $nodeName) {
                return $el;
            }
        }
        return null;
    }
    function xml_countnode($document, $tagName) {
        $tags = $document->getElementsByTagName($tagName);
        return $tags->length;
    }
    function remove_end_slash($path) {
        $last = substr($path, strlen($path) - 1 , 1);
        if($last == '/' || $last == '\\')
            return substr($path, 0, strlen($path) - 1 );
        return $path;
    }
    function bold($html) {
        return "<span style='font-weight: bold'>".$html."</span>";
    }
    function underline($html) {
        return "<span style='text-decoration: underline'>".$html."</span>";
    }
    function italic($html) {
        return "<span style='font-variant: italic'>".$html."</span>";
    }
    function set_style($html, $style) {
        return '<span style="'.$style.'">'.$html.'</span>';
    }
    function rq($key){
        global $core;
        $value = $core->rq->$key;
        if (get_magic_quotes_gpc())
            $value = stripslashes($value);
        return mysql_real_escape_string($value);
    }
    function PostVars($prefix) {
        global $core;
        $ret = new collection();
        $request = $core->rq->get_collection(VAR_REQUEST);
        foreach($request as $rkey => $ritem)
            if( substr($rkey, 0, strlen($prefix)) == $prefix)
                $ret->add(substr($rkey, strlen($prefix)), $ritem);
        return $ret;
    }
    function CleanCacheFromURL() {
        $qs = $_SERVER["QUERY_STRING"];
        $qs = preg_replace("/(recache=[^&]*)/", "", $qs);
        $qs = preg_replace("/(\?$)/", "", $qs);
        $qs = preg_replace("/(&$)/", "", $qs);
        return $qs;
    }
    function semantic($i, &$words, &$fem, $f, &$_1_2, &$_1_19, &$des, &$hang, &$namerub, &$nametho, &$namemil, &$namemrd){ 
        $words=""; 
        $fl=0; 
        if($i >= 100){ 
            $jkl = intval($i / 100); 
            $words.=$hang[$jkl]; 
            $i%=100; 
        } 
        if($i >= 20){ 
            $jkl = intval($i / 10); 
            $words.=$des[$jkl]; 
            $i%=10; 
            $fl=1; 
        } 
        switch($i){ 
            case 1: 
                $fem=1; 
                break; 
            case 2: 
            case 3: 
            case 4: 
                $fem=2; 
                break; 
            default: 
                $fem=3; 
                break; 
        } 
        if( $i ){ 
            if( $i < 3 && $f > 0 ){ 
                if ( $f >= 2 ) { 
                    $words.=$_1_19[$i]; 
                } 
                else { 
                    $words.=$_1_2[$i]; 
                } 
            } 
            else { 
                $words.=$_1_19[$i]; 
            } 
        } 
    } 
    function num2str($L){ 
        $_1_2[1]="одна "; $_1_2[2]="две "; 
        $_1_19[1]="один "; $_1_19[2]="два "; $_1_19[3]="три "; $_1_19[4]="четыре "; $_1_19[5]="пять "; $_1_19[6]="шесть "; 
        $_1_19[7]="семь "; $_1_19[8]="восемь "; $_1_19[9]="девять "; $_1_19[10]="десять "; $_1_19[11]="одиннацать "; $_1_19[12]="двенадцать "; 
        $_1_19[13]="тринадцать "; $_1_19[14]="четырнадцать "; $_1_19[15]="пятнадцать "; $_1_19[16]="шестнадцать "; $_1_19[17]="семнадцать "; 
        $_1_19[18]="восемнадцать "; $_1_19[19]="девятнадцать "; 
        $des[2]="двадцать "; $des[3]="тридцать "; $des[4]="сорок "; $des[5]="пятьдесят "; 
        $des[6]="шестьдесят "; $des[7]="семьдесят "; $des[8]="восемдесят "; $des[9]="девяносто "; 
        $hang[1]="сто "; $hang[2]="двести "; $hang[3]="триста "; $hang[4]="четыреста "; $hang[5]="пятьсот "; 
        $hang[6]="шестьсот "; $hang[7]="семьсот "; $hang[8]="восемьсот "; $hang[9]="девятьсот "; 
        $namerub[1]="рубль "; $namerub[2]="рубля "; $namerub[3]="рублей "; 
        $nametho[1]="тысяча "; $nametho[2]="тысячи "; $nametho[3]="тысяч "; 
        $namemil[1]="миллион "; $namemil[2]="миллиона "; $namemil[3]="миллионов "; 
        $namemrd[1]="миллиард "; $namemrd[2]="миллиарда "; $namemrd[3]="миллиардов "; 
        $kopeek[1]="копейка "; $kopeek[2]="копейки "; $kopeek[3]="копеек "; 
        $s=" "; 
        $s1=" "; 
        $s2=" "; 
        $kop=intval( ( $L*100 - intval( $L )*100 )); 
        $L=intval($L); 
        if($L>=1000000000){ 
            $many=0; 
            semantic(intval($L / 1000000000),$s1,$many,3, $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd); 
            $s.=$s1.$namemrd[$many]; 
            $L%=1000000000; 
        } 
        if($L >= 1000000){ 
            $many=0; 
            semantic(intval($L / 1000000),$s1,$many,2, $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd); 
            $s.=$s1.$namemil[$many]; 
            $L%=1000000; 
            if($L==0){ 
                $s.="рублей "; 
            } 
        } 
        if($L >= 1000){ 
            $many=0; 
            semantic(intval($L / 1000),$s1,$many,1, $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd); 
            $s.=$s1.$nametho[$many]; 
            $L%=1000; 
            if($L==0){ 
                $s.="рублей "; 
            } 
        } 
        if($L != 0){ 
            $many=0; 
            semantic($L,$s1,$many,0, $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd); 
            $s.=$s1.$namerub[$many]; 
        } 
        if($kop > 0){ 
            $many=0; 
            semantic($kop,$s1,$many,1, $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd); 
            $s.=$s1.$kopeek[$many]; 
        } 
        else { 
            $s.=" 00 копеек"; 
        } 
        return $s; 
    }
    function html2rgb($color)
    {
        if ($color[0] == '#')
            $color = substr($color, 1);
        if (strlen($color) == 6)
            list($r, $g, $b) = array($color[0].$color[1],
                                     $color[2].$color[3],
                                     $color[4].$color[5]);
        elseif (strlen($color) == 3)
            list($r, $g, $b) = array($color[0], $color[1], $color[2]);
        else
            return false;
        $r = hexdec($r); 
        $g = hexdec($g); 
        $b = hexdec($b);
        return array($r, $g, $b);
    }    
    function rgb2html($r, $g=-1, $b=-1)
    {
        if (is_array($r) && sizeof($r) == 3)
            list($r, $g, $b) = $r;
        $r = intval($r); $g = intval($g);
        $b = intval($b);
        $r = dechex($r<0?0:($r>255?255:$r));
        $g = dechex($g<0?0:($g>255?255:$g));
        $b = dechex($b<0?0:($b>255?255:$b));
        $color = (strlen($r) < 2?'0':'').$r;
        $color .= (strlen($g) < 2?'0':'').$g;
        $color .= (strlen($b) < 2?'0':'').$b;
        return '#'.$color;
    }
    function rss_request($url, $timeout=1800) {
        $dest_file = $url;
        $xml = file_get_contents($dest_file);
        $xml = preg_replace("/\&[^amp;]/", "&amp;", $xml);
        $dom = DOMDocument::loadXML($xml);
                                $xpath = new DOMXPath($dom);
        $ns = array(''=>NULL);
        foreach($xpath->query("namespace::*") as $v) {
            if($v->localName!='xml') $ns[$v->localName] = $v->nodeValue;
        }
        if(in_array("http://www.w3.org/2005/Atom",$ns)) {
            $atom10 = true;
            unset($ns['xmlns']);
        } else $atom10 = false;
                $xml = simplexml_import_dom($dom);
                foreach($xml->attributes() as $k=>$v) $feed[$k] = (string)$v;
                        $rss1 = false;
        if($atom10) $top = $xml;
        else $top = $xml->channel;
        foreach($ns as $alias=>$uri) foreach($top->children($uri) as $key=>$val) {
            if($key=="item" || $key=="entry") continue;
            if($key=="items") {
                $rss1 = true; continue;
            }
            if(!$val->children()) {
                $feed[$key][0] = (string)$val;
                foreach($ns as $a=>$u) foreach($val->attributes($u) as $at=>$atv) {
                    $feed[$key][$at] = (string)$atv;
                }
            } else {
                foreach($val->children() as $k=>$v) {
                    $feed[$key][$k] = (string)$v;
                    foreach($v->attributes() as $at=>$atv) {
                        $feed[$k][$at] = (string)$atv;
                    }
                }
            }
        }
                        $i = 0;
        if($rss1) { $feed['_type']='rss1.0'; $items = $xml->item; }
        else if($atom10) { $feed['_type']='atom1.0'; $items = $xml->entry; }
        else {
            if($feed['version']=='2.0') $feed['_type']='rss2.0';
            else if($feed['version']=='0.91') $feed['_type']='rss0.91';
            $items = $xml->channel->item;
        }
        foreach($items as $key=>$val) {
            foreach($ns as $a=>$u) foreach($val->attributes($u) as $at=>$atv) {
                $feed[$i][$at] = (string)$atv;
            }
            foreach($ns as $alias=>$uri) {
                foreach($val->children($uri) as $k=>$v) {
                    $feed[$i][$k][0] = (string)$v;
                    foreach($v->attributes() as $at=>$atv) {
                        $at_val = (string)$atv;
                        if($atom10) {
                            $feed[$i][$k][$at][] = $at_val;
                                                        if($at_val=='xhtml' || $at_val=='html' || $at_val=='text') {
                                $tags = $v->children();
                                $feed[$i][$k]['text'] = $tags->asXML();
                            }
                        } else $feed[$i][$k][$at] = $at_val;
                    }
                } 
            }
            $i++;
        }
        return $feed;
    }
    function Humanize($price) {
        $rprice = "";
        $price = (string)$price;
        $prices = preg_split("/\.|\,/", $price);
        $price = $prices[0];
        $dec = @$prices[1];
        $len = strlen($price);
        $count = (int)($len/3);
        for($i=0; $i<$count; $i++) {
            $rprice = "&nbsp;".substr($price, $len-($i+1)*3, 3).$rprice;
        }
        $rprice = substr($price, 0, $len-$count*3).$rprice;
        return trim($rprice, "&nbsp;").(@$prices[1] ? ",".$prices[1] : '');
    }
    function translit($st) {
        $st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ_", "abvgdeeziyklmnoprstufh'iei");
        $st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_", "ABVGDEEZIYKLMNOPRSTUFH'IEI");
        $st=strtr($st, array( "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", 
                              "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                              "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH", 
                              "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                              "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye" ) );
        return $st;
    }
    function is_serialized($v) {
        $vv = @unserialize($v);
        if(is_array($vv) || is_object($vv))
            return true;
        return false;
    }
    function _serialize($obj) {
        return '0x'.bin2hex(serialize($obj));
    }
    function _unserialize($string) {
        if(substr($string, 0, 2) == '0x')
            $string = hex2bin(substr($string, 2));
        return unserialize($string);
    }
    function find_oneof($string, $needles = array()) {
        foreach($needles as $needle) {
            $ipos = stripos($string, $needle);
            if($ipos !== false)
                return $ipos;
        }
        return false;
    }
    function RemoveComments($string) {
        $newStr  = '';
        $tokens = token_get_all($string);
        foreach ($tokens as $token) {
            $commentTokens = array(T_COMMENT);
            if (defined('T_DOC_COMMENT'))
                $commentTokens[] = T_DOC_COMMENT;
            if (defined('T_ML_COMMENT'))
                $commentTokens[] = T_ML_COMMENT;
            if (is_array($token)) {
                if (in_array($token[0], $commentTokens))
                    continue;
                $token = $token[1];
            }
            $newStr .= $token;
        }
        $string = $newStr;
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/im", "\n", $string);
        return $string;
    }
    function ReadAndWriteFile($file, $handle) {
        global $CORE_FILE, $CORE_PATH;
        out('Writing a file '. $file .'...');
        $fc = file_get_contents($CORE_PATH.$file);
        $fc = RemoveComments($fc);
        fwrite($handle, $fc, strlen($fc));
    }
    function RecompileCore() {
        global $CORE_FILE, $CORE_PATH, $arrayClasses;
        out('Starting recompile...');
        if(file_exists($CORE_PATH.$CORE_FILE)) {
            out('Removing old file...');
            unlink($CORE_PATH.$CORE_FILE);
            out('Creating a new file...');
            touch($CORE_PATH.$CORE_FILE);
        }
        out('Start writing core cache file...');
        $handle = fopen($CORE_PATH.$CORE_FILE, "w");
        ReadAndWriteFile('kernel/utilities.inc.php', $handle);
        foreach($arrayClasses as $file => $classes) {
            ReadAndWriteFile($file, $handle);
        }
        ReadAndWriteFile('core.cls.php', $handle);
        fclose($handle);
        out('Complete...');
    }
    function TranslateByGOOGLE($text) {
        $text = urlencode($text);
        $ch = curl_init('http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=' . $text . '&langpair=en%7Cru&callback=foo&context=bar');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
        $text = curl_exec($ch);
        preg_match('|"translatedText":"(.*?)"|is', $text, $result);
        curl_close($ch);
        return $result['1'];
    }
    function curlConvertData($data) {
        $ret = '';
        foreach($data as $k => $value) {
            $ret .= '&'.$k.'='.urlencode($value);
        }
        $ret = substring($ret, 1);
        return $ret;
    }
    function curlPost($url, $timeout = 10, $user = "", $password = "", $secure = false, $postData = array()) {
        if(is_null($postData) || !is_array($postData)) {
            $postData = array();
        }
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, ($secure ? "https://" : "http://").$url); 
        curl_setopt($handle, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        if(!is_empty($user)){
            curl_setopt($handle, CURLOPT_USERPWD, $user.':'.$password);
            curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        }
        if($secure) {
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);                
                    }
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                "Connection: Keep-Alive"
            )
        );
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, curlConvertData($postData));
        $result = new Object();
        $result->data = curl_exec($handle);
        $result->status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle); 
        return $result;        
    }
    function transliterate ($string) {         $string = mb_ereg_replace("ж","zh",$string);
        $string = mb_ereg_replace("ё","yo",$string);
        $string = mb_ereg_replace("й","i",$string);
        $string = mb_ereg_replace("ю","yu",$string);
        $string = mb_ereg_replace("ь","'",$string);
        $string = mb_ereg_replace("ч","ch",$string);
        $string = mb_ereg_replace("щ","sh",$string);
        $string = mb_ereg_replace("ц","c",$string);
        $string = mb_ereg_replace("у","u",$string);
        $string = mb_ereg_replace("к","k",$string);
        $string = mb_ereg_replace("е","e",$string);
        $string = mb_ereg_replace("н","n",$string);
        $string = mb_ereg_replace("г","g",$string);
        $string = mb_ereg_replace("ш","sh",$string);
        $string = mb_ereg_replace("з","z",$string);
        $string = mb_ereg_replace("х","h",$string);
        $string = mb_ereg_replace("ъ","''",$string);
        $string = mb_ereg_replace("ф","f",$string);
        $string = mb_ereg_replace("ы","y",$string);
        $string = mb_ereg_replace("в","v",$string);
        $string = mb_ereg_replace("а","a",$string);
        $string = mb_ereg_replace("п","p",$string);
        $string = mb_ereg_replace("р","r",$string);
        $string = mb_ereg_replace("о","o",$string);
        $string = mb_ereg_replace("л","l",$string);
        $string = mb_ereg_replace("д","d",$string);
        $string = mb_ereg_replace("э","yе",$string);
        $string = mb_ereg_replace("я","ya",$string);
        $string = mb_ereg_replace("с","s",$string);
        $string = mb_ereg_replace("м","m",$string);
        $string = mb_ereg_replace("и","i",$string);
        $string = mb_ereg_replace("т","t",$string);
        $string = mb_ereg_replace("б","b",$string);
        $string = mb_ereg_replace("Ё","yo",$string);
        $string = mb_ereg_replace("Й","I",$string);
        $string = mb_ereg_replace("Ю","YU",$string);
        $string = mb_ereg_replace("Ч","CH",$string);
        $string = mb_ereg_replace("Ь","'",$string);
        $string = mb_ereg_replace("Щ","SH'",$string);
        $string = mb_ereg_replace("Ц","C",$string);
        $string = mb_ereg_replace("У","U",$string);
        $string = mb_ereg_replace("К","K",$string);
        $string = mb_ereg_replace("Е","E",$string);
        $string = mb_ereg_replace("Н","N",$string);
        $string = mb_ereg_replace("Г","G",$string);
        $string = mb_ereg_replace("Ш","SH",$string);
        $string = mb_ereg_replace("З","Z",$string);
        $string = mb_ereg_replace("Х","H",$string);
        $string = mb_ereg_replace("Ъ","''",$string);
        $string = mb_ereg_replace("Ф","F",$string);
        $string = mb_ereg_replace("Ы","Y",$string);
        $string = mb_ereg_replace("В","V",$string);
        $string = mb_ereg_replace("А","A",$string);
        $string = mb_ereg_replace("П","P",$string);
        $string = mb_ereg_replace("Р","R",$string);
        $string = mb_ereg_replace("О","O",$string);
        $string = mb_ereg_replace("Л","L",$string);
        $string = mb_ereg_replace("Д","D",$string);
        $string = mb_ereg_replace("Ж","Zh",$string);
        $string = mb_ereg_replace("Э","Ye",$string);
        $string = mb_ereg_replace("Я","Ja",$string);
        $string = mb_ereg_replace("С","S",$string);
        $string = mb_ereg_replace("М","M",$string);
        $string = mb_ereg_replace("И","I",$string);
        $string = mb_ereg_replace("Т","T",$string);
        $string = mb_ereg_replace("Б","B",$string);
        return $string;
    }
    class JavaScriptPacker {
                const IGNORE = '$1';
                private $_script = '';
        private $_encoding = 62;
        private $_fastDecode = true;
        private $_specialChars = false;
        private $LITERAL_ENCODING = array(
            'None' => 0,
            'Numeric' => 10,
            'Normal' => 62,
            'High ASCII' => 95
        );
        public function __construct($_script, $_encoding = 62, $_fastDecode = true, $_specialChars = false)
        {
            $this->_script = $_script . "\n";
            if (array_key_exists($_encoding, $this->LITERAL_ENCODING))
                $_encoding = $this->LITERAL_ENCODING[$_encoding];
            $this->_encoding = min((int)$_encoding, 95);
            $this->_fastDecode = $_fastDecode;    
            $this->_specialChars = $_specialChars;
        }
        public function pack() {
            $this->_addParser('_basicCompression');
            if ($this->_specialChars)
                $this->_addParser('_encodeSpecialChars');
            if ($this->_encoding)
                $this->_addParser('_encodeKeywords');
                        return $this->_pack($this->_script);
        }
                private function _pack($script) {
            for ($i = 0; isset($this->_parsers[$i]); $i++) {
                $script = call_user_func(array(&$this,$this->_parsers[$i]), $script);
            }
            return $script;
        }
                private $_parsers = array();
        private function _addParser($parser) {
            $this->_parsers[] = $parser;
        }
                private function _basicCompression($script) {
            $parser = new ParseMaster();
                        $parser->escapeChar = '\\';
                        $parser->add('/\'[^\'\\n\\r]*\'/', self::IGNORE);
            $parser->add('/"[^"\\n\\r]*"/', self::IGNORE);
                        $parser->add('/\\/\\/[^\\n\\r]*[\\n\\r]/', ' ');
            $parser->add('/\\/\\*[^*]*\\*+([^\\/][^*]*\\*+)*\\//', ' ');
                        $parser->add('/\\s+(\\/[^\\/\\n\\r\\*][^\\/\\n\\r]*\\/g?i?)/', '$2');             $parser->add('/[^\\w\\x24\\/\'"*)\\?:]\\/[^\\/\\n\\r\\*][^\\/\\n\\r]*\\/g?i?/', self::IGNORE);
                        if ($this->_specialChars) $parser->add('/;;;[^\\n\\r]+[\\n\\r]/');
                        $parser->add('/\\(;;\\)/', self::IGNORE);             $parser->add('/;+\\s*([};])/', '$2');
                        $script = $parser->exec($script);
                        $parser->add('/(\\b|\\x24)\\s+(\\b|\\x24)/', '$2 $3');
            $parser->add('/([+\\-])\\s+([+\\-])/', '$2 $3');
            $parser->add('/\\s+/', '');
                        return $parser->exec($script);
        }
        private function _encodeSpecialChars($script) {
            $parser = new ParseMaster();
                        $parser->add('/((\\x24+)([a-zA-Z$_]+))(\\d*)/',
                         array('fn' => '_replace_name')
            );
                        $regexp = '/\\b_[A-Za-z\\d]\\w*/';
                        $keywords = $this->_analyze($script, $regexp, '_encodePrivate');
                        $encoded = $keywords['encoded'];
            $parser->add($regexp,
                array(
                    'fn' => '_replace_encoded',
                    'data' => $encoded
                )
            );
            return $parser->exec($script);
        }
        private function _encodeKeywords($script) {
                        if ($this->_encoding > 62)
                $script = $this->_escape95($script);
                        $parser = new ParseMaster();
            $encode = $this->_getEncoder($this->_encoding);
                        $regexp = ($this->_encoding > 62) ? '/\\w\\w+/' : '/\\w+/';
                        $keywords = $this->_analyze($script, $regexp, $encode);
            $encoded = $keywords['encoded'];
                        $parser->add($regexp,
                array(
                    'fn' => '_replace_encoded',
                    'data' => $encoded
                )
            );
            if (empty($script)) return $script;
            else {
                                                                return $this->_bootStrap($parser->exec($script), $keywords);
            }
        }
        private function _analyze($script, $regexp, $encode) {
                                    $all = array();
            preg_match_all($regexp, $script, $all);
            $_sorted = array();             $_encoded = array();             $_protected = array();             $all = $all[0];             if (!empty($all)) {
                $unsorted = array();                 $protected = array();                 $value = array();                 $this->_count = array();                 $i = count($all); $j = 0;                                 do {
                    --$i;
                    $word = '$' . $all[$i];
                    if (!isset($this->_count[$word])) {
                        $this->_count[$word] = 0;
                        $unsorted[$j] = $word;
                                                                                                $values[$j] = call_user_func(array(&$this, $encode), $j);
                        $protected['$' . $values[$j]] = $j++;
                    }
                                        $this->_count[$word]++;
                } while ($i > 0);
                                                                                                                $i = count($unsorted);
                do {
                    $word = $unsorted[--$i];
                    if (isset($protected[$word]) ) {
                        $_sorted[$protected[$word]] = substr($word, 1);
                        $_protected[$protected[$word]] = true;
                        $this->_count[$word] = 0;
                    }
                } while ($i);
                                                                                                                                                                                usort($unsorted, array(&$this, '_sortWords'));
                $j = 0;
                                                do {
                    if (!isset($_sorted[$i]))
                        $_sorted[$i] = substr($unsorted[$j++], 1);
                    $_encoded[$_sorted[$i]] = $values[$i];
                } while (++$i < count($unsorted));
            }
            return array(
                'sorted'  => $_sorted,
                'encoded' => $_encoded,
                'protected' => $_protected);
        }
        private $_count = array();
        private function _sortWords($match1, $match2) {
            return $this->_count[$match2] - $this->_count[$match1];
        }
                private function _bootStrap($packed, $keywords) {
            $ENCODE = $this->_safeRegExp('$encode\\($count\\)');
                        $packed = "'" . $this->_escape($packed) . "'";
                        $ascii = min(count($keywords['sorted']), $this->_encoding);
            if ($ascii == 0) $ascii = 1;
                        $count = count($keywords['sorted']);
                        foreach ($keywords['protected'] as $i=>$value) {
                $keywords['sorted'][$i] = '';
            }
                        ksort($keywords['sorted']);
            $keywords = "'" . implode('|',$keywords['sorted']) . "'.explode('|')";
            $encode = ($this->_encoding > 62) ? '_encode95' : $this->_getEncoder($ascii);
            $encode = $this->_getJSFunction($encode);
            $encode = preg_replace('/_encoding/','$ascii', $encode);
            $encode = preg_replace('/arguments\\.callee/','$encode', $encode);
            $inline = '\\$count' . ($ascii > 10 ? '.toString(\\$ascii)' : '');
                        if ($this->_fastDecode) {
                                $decode = $this->_getJSFunction('_decodeBody');
                if ($this->_encoding > 62)
                    $decode = preg_replace('/\\\\w/', '[\\xa1-\\xff]', $decode);
                                elseif ($ascii < 36)
                    $decode = preg_replace($ENCODE, $inline, $decode);
                                                if ($count == 0)
                    $decode = preg_replace($this->_safeRegExp('($count)\\s*=\\s*1'), '$1=0', $decode, 1);
            }
                        $unpack = $this->_getJSFunction('_unpack');
            if ($this->_fastDecode) {
                                $this->buffer = $decode;
                $unpack = preg_replace_callback('/\\{/', array(&$this, '_insertFastDecode'), $unpack, 1);
            }
            $unpack = preg_replace('/"/', "'", $unpack);
            if ($this->_encoding > 62) {                                 $unpack = preg_replace('/\'\\\\\\\\b\'\s*\\+|\\+\s*\'\\\\\\\\b\'/', '', $unpack);
            }
            if ($ascii > 36 || $this->_encoding > 62 || $this->_fastDecode) {
                                $this->buffer = $encode;
                $unpack = preg_replace_callback('/\\{/', array(&$this, '_insertFastEncode'), $unpack, 1);
            } else {
                                $unpack = preg_replace($ENCODE, $inline, $unpack);
            }
                        $unpackPacker = new JavaScriptPacker($unpack, 0, false, true);
            $unpack = $unpackPacker->pack();
                        $params = array($packed, $ascii, $count, $keywords);
            if ($this->_fastDecode) {
                $params[] = 0;
                $params[] = '{}';
            }
            $params = implode(',', $params);
                        return 'eval(' . $unpack . '(' . $params . "))\n";
        }
        private $buffer;
        private function _insertFastDecode($match) {
            return '{' . $this->buffer . ';';
        }
        private function _insertFastEncode($match) {
            return '{$encode=' . $this->buffer . ';';
        }
                private function _getEncoder($ascii) {
            return $ascii > 10 ? $ascii > 36 ? $ascii > 62 ?
                   '_encode95' : '_encode62' : '_encode36' : '_encode10';
        }
                        private function _encode10($charCode) {
            return $charCode;
        }
                        private function _encode36($charCode) {
            return base_convert($charCode, 10, 36);
        }
                        private function _encode62($charCode) {
            $res = '';
            if ($charCode >= $this->_encoding) {
                $res = $this->_encode62((int)($charCode / $this->_encoding));
            }
            $charCode = $charCode % $this->_encoding;
            if ($charCode > 35)
                return $res . chr($charCode + 29);
            else
                return $res . base_convert($charCode, 10, 36);
        }
                        private function _encode95($charCode) {
            $res = '';
            if ($charCode >= $this->_encoding)
                $res = $this->_encode95($charCode / $this->_encoding);
            return $res . chr(($charCode % $this->_encoding) + 161);
        }
        private function _safeRegExp($string) {
            return '/'.preg_replace('/\$/', '\\\$', $string).'/';
        }
        private function _encodePrivate($charCode) {
            return "_" . $charCode;
        }
                private function _escape($script) {
            return preg_replace('/([\\\\\'])/', '\\\$1', $script);
        }
                private function _escape95($script) {
            return preg_replace_callback(
                '/[\\xa1-\\xff]/',
                array(&$this, '_escape95Bis'),
                $script
            );
        }
        private function _escape95Bis($match) {
            return '\x'.((string)dechex(ord($match)));
        }
        private function _getJSFunction($aName) {
            if (defined('self::JSFUNCTION'.$aName))
                return constant('self::JSFUNCTION'.$aName);
            else 
                return '';
        }
                                        const JSFUNCTION_unpack =
    'function($packed, $ascii, $count, $keywords, $encode, $decode) {
        while ($count--) {
            if ($keywords[$count]) {
                $packed = $packed.replace(new RegExp(\'\\\\b\' + $encode($count) + \'\\\\b\', \'g\'), $keywords[$count]);
            }
        }
        return $packed;
    }';
                const JSFUNCTION_decodeBody =
    '    if (!\'\'.replace(/^/, String)) {
            // decode all the values we need
            while ($count--) {
                $decode[$encode($count)] = $keywords[$count] || $encode($count);
            }
            // global replacement function
            $keywords = [function ($encoded) {return $decode[$encoded]}];
            // generic match
            $encode = function () {return \'\\\\w+\'};
            // reset the loop counter -  we are now doing a global replace
            $count = 1;
        }
    ';
                           const JSFUNCTION_encode10 =
    'function($charCode) {
        return $charCode;
    }';        
                           const JSFUNCTION_encode36 =
    'function($charCode) {
        return $charCode.toString(36);
    }';        
                        const JSFUNCTION_encode62 =
    'function($charCode) {
        return ($charCode < _encoding ? \'\' : arguments.callee(parseInt($charCode / _encoding))) +
        (($charCode = $charCode % _encoding) > 35 ? String.fromCharCode($charCode + 29) : $charCode.toString(36));
    }';
                        const JSFUNCTION_encode95 =
    'function($charCode) {
        return ($charCode < _encoding ? \'\' : arguments.callee($charCode / _encoding)) +
            String.fromCharCode($charCode % _encoding + 161);
    }'; 
    }
    class ParseMaster {
        public $ignoreCase = false;
        public $escapeChar = '';
                const EXPRESSION = 0;
        const REPLACEMENT = 1;
        const LENGTH = 2;
                private $GROUPS = '/\\(/';        private $SUB_REPLACE = '/\\$\\d/';
        private $INDEXED = '/^\\$\\d+$/';
        private $TRIM = '/([\'"])\\1\\.(.*)\\.\\1\\1$/';
        private $ESCAPE = '/\\\./';        private $QUOTE = '/\'/';
        private $DELETED = '/\\x01[^\\x01]*\\x01/';        
        public function add($expression, $replacement = '') {
                                    $length = 1 + preg_match_all($this->GROUPS, $this->_internalEscape((string)$expression), $out);
                        if (is_string($replacement)) {
                                if (preg_match($this->SUB_REPLACE, $replacement)) {
                                        if (preg_match($this->INDEXED, $replacement)) {
                                                $replacement = (int)(substr($replacement, 1)) - 1;
                    } else {                                                 $quote = preg_match($this->QUOTE, $this->_internalEscape($replacement))
                                 ? '"' : "'";
                        $replacement = array(
                            'fn' => '_backReferences',
                            'data' => array(
                                'replacement' => $replacement,
                                'length' => $length,
                                'quote' => $quote
                            )
                        );
                    }
                }
            }
                        if (!empty($expression)) $this->_add($expression, $replacement, $length);
            else $this->_add('/^$/', $replacement, $length);
        }
        public function exec($string) {
                        $this->_escaped = array();
                        $regexp = '/';
            foreach ($this->_patterns as $reg) {
                $regexp .= '(' . substr($reg[self::EXPRESSION], 1, -1) . ')|';
            }
            $regexp = substr($regexp, 0, -1) . '/';
            $regexp .= ($this->ignoreCase) ? 'i' : '';
            $string = $this->_escape($string, $this->escapeChar);
            $string = preg_replace_callback(
                $regexp,
                array(
                    &$this,
                    '_replacement'
                ),
                $string
            );
            $string = $this->_unescape($string, $this->escapeChar);
            return preg_replace($this->DELETED, '', $string);
        }
        public function reset() {
                        $this->_patterns = array();
        }
                private $_escaped = array();          private $_patterns = array();         
                private function _add() {
            $arguments = func_get_args();
            $this->_patterns[] = $arguments;
        }
                private function _replacement($arguments) {
            if (empty($arguments)) return '';
            $i = 1; $j = 0;
                        while (isset($this->_patterns[$j])) {
                $pattern = $this->_patterns[$j++];
                                if (isset($arguments[$i]) && ($arguments[$i] != '')) {
                    $replacement = $pattern[self::REPLACEMENT];
                    if (is_array($replacement) && isset($replacement['fn'])) {
                        if (isset($replacement['data'])) $this->buffer = $replacement['data'];
                        return call_user_func(array(&$this, $replacement['fn']), $arguments, $i);
                    } elseif (is_int($replacement)) {
                        return $arguments[$replacement + $i];
                    }
                    $delete = ($this->escapeChar == '' ||
                               strpos($arguments[$i], $this->escapeChar) === false)
                            ? '' : "\x01" . $arguments[$i] . "\x01";
                    return $delete . $replacement;
                                } else {
                    $i += $pattern[self::LENGTH];
                }
            }
        }
        private function _backReferences($match, $offset) {
            $replacement = $this->buffer['replacement'];
            $quote = $this->buffer['quote'];
            $i = $this->buffer['length'];
            while ($i) {
                $replacement = str_replace('$'.$i--, $match[$offset + $i], $replacement);
            }
            return $replacement;
        }
        private function _replace_name($match, $offset){
            $length = strlen($match[$offset + 2]);
            $start = $length - max($length - strlen($match[$offset + 3]), 0);
            return substr($match[$offset + 1], $start, $length) . $match[$offset + 4];
        }
        private function _replace_encoded($match, $offset) {
            return $this->buffer[$match[$offset]];
        }
                        private $buffer;
                private function _escape($string, $escapeChar) {
            if ($escapeChar) {
                $this->buffer = $escapeChar;
                return preg_replace_callback(
                    '/\\' . $escapeChar . '(.)' .'/',
                    array(&$this, '_escapeBis'),
                    $string
                );
            } else {
                return $string;
            }
        }
        private function _escapeBis($match) {
            $this->_escaped[] = $match[1];
            return $this->buffer;
        }
                private function _unescape($string, $escapeChar) {
            if ($escapeChar) {
                $regexp = '/'.'\\'.$escapeChar.'/';
                $this->buffer = array('escapeChar'=> $escapeChar, 'i' => 0);
                return preg_replace_callback
                (
                    $regexp,
                    array(&$this, '_unescapeBis'),
                    $string
                );
            } else {
                return $string;
            }
        }
        private function _unescapeBis() {
            if (isset($this->_escaped[$this->buffer['i']])
                && $this->_escaped[$this->buffer['i']] != '')
            {
                 $temp = $this->_escaped[$this->buffer['i']];
            } else {
                $temp = '';
            }
            $this->buffer['i']++;
            return $this->buffer['escapeChar'] . $temp;
        }
        private function _internalEscape($string) {
            return preg_replace($this->ESCAPE, '', $string);
        }
    }
    class Javascript {
        public static function Pack($script, $encoding = 62, $fastDecode = false, $specialChars = false) {
            $js = new JavaScriptPacker($script, $encoding, $fastDecode, $specialChars);
            return $js->pack();
        }
        public static function PackFile($from, $to, $encoding = 62, $fastDecode = false, $specialChars = false) {
            $script = FileInfo::ReadAll($from);
            $js = new JavaScriptPacker($script, $encoding, $fastDecode, $specialChars);
            $packed = $js->pack();
            FileInfo::WriteAll($to, $packed);
        }
    }
?>
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
?><?
	class IEventDispatcher {
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
?><?
class Object extends IEventDispatcher {
	protected $_data;
    protected $_original;
	protected $_prefix = "";
	public function __construct($data = null, $prefix = "") {
		if(is_null($data))
			$this->_data = new stdClass();
		else {
			if($data instanceof Object) {
				$this->_data = $data->Data();
				$this->_prefix = $data->prefix;
			}
			else 
				$this->_data = $data;
		}
		if($prefix != '' && substr($prefix, strlen($prefix)-1, 1) != "_") $prefix = $prefix."_";
		$this->_prefix = $prefix;
		if(!is_empty($this->_prefix)) {
						$this->_data = crop_object_fields($this->_data, '/'.$this->_prefix.'/');
		}
        $this->_original = clone($this->_data);
	}
    public function __destruct() {
        unset($this->_data);
    }
	public function fname($name){
		return $this->_prefix.$name;
	}
	public function fromfname($name){
		return substr($name, strlen($this->_prefix));
	}
	public function Clear() {
		$this->_data = new stdClass();
	}
	public function __get($nm) {
		if($nm == "self")
			return $this;
		if($nm == "prefix")
			return $this->_prefix;
		if($this->_prefix != '' && strpos($nm, $this->_prefix) === false) {
			$nm = $this->_prefix.$nm;
		}
		return $this->TypeExchange($nm, TYPEEXCHANGE_MODE_GET);
    }
	public function __set($nm, $value) {
		if(@strpos($nm, $this->_prefix) === false)
			$nm = $this->_prefix.$nm; 			
		$this->TypeExchange($nm, TYPEEXCHANGE_MODE_SET, $value);
	}
	protected function TypeExchange($prop, $mode = TYPEEXCHANGE_MODE_GET, $value = null) {
		if($mode == TYPEEXCHANGE_MODE_GET)
			return @$this->_data->$prop;
		else
			@$this->_data->$prop = $value;
	}
    public function isPropertyChanged($property) {
        $property = $this->fname($property);
        return @$this->_data->$property != @$this->_original->$property;
    }
	public function Delete($nm) {											    
		$nm = $this->_prefix.$nm;
		unset($this->_data->$nm);
	}
	public function Data() {
		return $this->_data;
	}
	public function ToCollection($withprefis = true) {
		if($withprefis)
			return Collection::Create($this->_data);
		else {
			$ret = new Collection();
			$arr = get_object_vars($this->_data);
			foreach($arr as $key => $value)
				$ret->Add($this->fname($key), $value);
			return $ret;
		}
	}
	public function ToArray($withprefix = true) {
		if($withprefix)
			return get_object_vars($this->_data);
		else {
			$ret = array();
			$arr = get_object_vars($this->_data);
			foreach($arr as $key => $value)
				$ret[$this->fname($key)] = $value;
			return $ret;
		}
	}
	public function ToXMLAttribute($props = array()) {
		$ret = "";
		foreach($props as $prop) {
			$ret .= ' '.$prop.'="'.$this->$prop.'"';
		}
		return $ret;
	}
	public function ToXMLNode($document, $nodeName = "object", $propsToAttribute = array(), $tocdata = array(), $exception = array()) {
		$frag = $document->createDocumentFragment();
		$frag->appendXML($this->ToXML($nodeName, $propsToAttribute, $tocdata, $exception));
		return $frag;
	}
	public function ToXML($nodeName = "object", $propsToAttribute = array(), $tocdata = array(), $exception = array()) {
		$attrs = $this->ToXMLAttribute($propsToAttribute);
		$ret = '<'.$nodeName.(!is_empty($attrs) ? ' '.$attrs : '').' prefix="'.$this->_prefix.'">';
		$array = $this->ToArray(false);
		foreach($array as $key => $value) {
			if(!in_array($key, $propsToAttribute) && !in_array($key, $exception)) {
				if(is_object($value)) {
					if(method_exists($value, "ToXML"))
						$value = $value->ToXML();
					else
						$value = '<'.$key.' state="serialized"><![CDATA['.serialize($value).']]></'.$key.'>';
					$ret .= $value;
				} 
				else if(is_array($value)) {
					$ret .= '<'.$key.' state="serialized"><![CDATA['.serialize($value).']]></'.$key.'>';
				}
				else {
					$value = load_from_file($value);
					if(in_array($key, $tocdata))
						$value = '<![CDATA['.$value.']]>';
					$ret .= '<'.$key.'>'.$value.'</'.$key.'>';
				}
			}
		}
		$ret .= '</'.$nodeName.'>';
		return $ret;
	}
	public function FromXMLAttributes($node) {
		$attributes = $node->attributes;
		foreach($attributes as $attribute) {
			$name = $attribute->nodeName;
			$value = $attribute->nodeValue;
			if($name != "prefix")
				$this->$name = $value;
		}
	}
	public function FromXML($node){
		$this->Clear();
		$this->_prefix = $node->getAttribute("prefix");
		$this->FromXMLAttributes($node);
		$nodes = $node->childNodes;
		foreach($nodes as $pair) {
			$name = $pair->nodeName;
			$type = $pair->childNodes->item(0)->nodeType;
			$value = null;
			switch($type) {
				case 1: 					if($pair->getAttribute("serialized") !== false) {
						$value = unserialize($pair->childNodes->Item(0)-data);
						break;
					}
					$className = $pair->nodeName;
					if(class_exists($className)) {
						@$o = new $className();
						if(!$o)
							$o = new Object(null, $pair->getAttribute("prefix"));
					}
					else
						$o = new Object(null, $pair->getAttribute("prefix"));
					$value = $o->FromXML($pair);
					break;
				case 3: 					$value = $pair->nodeValue;
					break;
				case 4: 					$value = $pair->childNodes->item(0)->data;
					break;
				default:
					break;
			}
			$this->$name = $value;
		}
	}
	public function ToCreateScript($objectname, $proplist = array(), $exclude = array(), $newparams = array(), $class = null) {
		if(is_null($class))
			$class = get_class($this);
		$cf = "\n";
		$tab = "\t";
		$string = '';
		$string .= $tab.'$'.$objectname.' = new '.$class.'('.implode(',', $newparams).');'.$cf;
		$array = $this->ToArray(false);
		foreach($array as $prop => $value) {
			if((array_search($prop, $proplist) !== false || count($proplist) == 0) && array_search($prop, $exclude) === false) {
				$value = $this->_ValueToString($value);
				$string	.= $tab.$tab.'$'.$objectname.'->'.$prop.' = '.$value.';'.$cf;
			}
		}
		$string .= $tab.'$'.$objectname.'->Save();'.$cf;
		return $string;
	}
	private function _ValueToString($value) {
		if(is_null($value))
			return 'null';
		$type = gettype($value);
		switch($type) {
			case "string":
				return '"'.db_prepare(load_from_file($value)).'"';
			case "int":
				return $value;
			case "boolean":
				return $value ? 'true' : 'false';
			case "object":
				return null;
		}
	}
    public function Serialize() {
        $std = new stdClass();
        $std->className = get_class($this);
        $std->data = $this->_data;
        $std->prefix = $this->_prefix;
        return _serialize($std);
    }
    public static function Unserialize($data) {
        $data = @_unserialize($data);
        if(!$data)
            return new Object();
        if(!is_null(@$data->className) && class_exists($data->className)) {
            eval('$o = new '.$data->className.'($data->data, $data->prefix);');
        }
        else 
            $o = new Object($data->data, $data->prefix);
        return $o;
    }
	public function to_xml(){
        deprecate();
		return $this->ToXML();
	}
	public function from_xml($el){
        deprecate();
		$this->FromXML($el);
	}
	public function from_collection($col) { 
        deprecate();
		return $this->FromCollection($col); 
	}
	public function get_collection() {
        deprecate();
		return $this->ToCollection();
	}
}
class XmlBased {
	protected $_data;
	protected $_document;
	public function __construct(&$document, $data = "xmlobject") {
		$this->_document = $document;
		$this->_data = is_string($data) ? $this->_document->createElement($data) : $data;
	}
    public function __destruct() {
        unset($this->_data);
    }
	public function __get($nm) {
		if($nm == "self")
			return $this;
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);
		if($data->hasAttribute($nm))
			return $data->getAttribute($nm);
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm)
					return $child->nodeValue;
		}
		return null;			
	}
	public function __set($nm, $value) {
		if($nm == "self")
			return;
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);
		if($data->hasAttribute($nm))
			$data->setAttribute($nm, $value);
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm) {
					if($value instanceof XmlBased)
						$child->appendChild($this->XmlToNode($value->ToXML()));
					else
						$child->nodeValue = $value;
					return;
				}
		}
		if($value instanceof XmlBased) {
			$data->appendChild($this->XmlToNode($value->ToXML()));
		}
		else {
			$newel = $this->_document->createElement($nm);
			$newel->nodeValue = $value;
			$data->appendChild($newel);
		}
	}
	public function Item($nm) {
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm)
					return $child;
		}
		return null;			
	}
	public function Attribute($nm, $value) {
		$this->_data->setAttribute($nm, $value);
	}
	public function Delete($nm) {
		$data = $this->_data;
		if($data instanceof DomDocumentFragment)
			$data = $data->childNodes->Item(0);
		if(!is_null($data->getAttribute($nm)))
			$data->removeAttribute($nm);
		$childs = $data->childNodes;
		foreach($childs as $child) {
			if($child->nodeType == 1)
				if($child->nodeName == $nm)
					$data->removeChild($child);
		}
	}
	public function Data() {
		return $this->_data;
	}
	public function ToXML() {
		return $this->_document->saveXML($this->_data);
	}
	public function FromXML($el){
		$this->_data = $el;
	}
	public function XmlToNode($string) {
		$frag = $this->_document->createDocumentFragment();
		$frag->appendXML($string);
		return $frag;
	}
}
?>
<?php
class OutputBlock {
	private $_content;
	private $_name;
	public function __construct($name) {
		$this->_name = $name;
		$this->_content = new ArrayList();
	}
	public function __get($property) {
		switch($property) {
			case "name":
				return $this->_name;
			case "content": 
				return $this->ToString("");
			case "empty":
				return $this->_content->Count() == 0;
		}
	}
	public function Out($content) {
		$this->_content->Add($content);
	}
	public function Clear() {
		$this->_content->Clear();
	}
	private function ToString() {
		$ret = "";
		foreach($this->_content as $str) {
			$ret .= $str;
		}
		return $ret;
	}
}
class OutputContext {
	private $_name;
	private $_content;
	private $_currentblock;
	public function __construct($name = null, $type = CONTEXT_STANDART) {
		$this->_name = $name;
		$this->_content = new Collection();
		$this->_currentblock = null;
	}
	public function Test() {
		out($this->_content->Keys());
	}
	public function __get($property) {
		switch($property) {
			case "name":
				return $this->_name;
			case "content": 
				return $this->ToString();
			case "empty":
				return $this->_content->Count() == 0;
			default: 
				if($this->_content->Item($property) instanceof OutputBlock)
					return $this->_content->Item($property)->content;
				else
					return $this->_content->Item($property);
		}
	}
	public function GetBlock($name) {
		return $this->_content->Item($name);
	}
	private function ToString() {
		$ret = "";
		foreach($this->_content as $str) {
			if($str instanceof OutputBlock) {
				$ret .= $str->content;
			}
			else {
				$ret .= $str;
			}
		}
		return $ret;
	}
	public function Out($content, $block = null) {
		if(is_null($block) && !is_null($this->_currentblock))
			$block = $this->_currentblock;
		if(!is_null($block)) {
			if($this->_content->Exists($block))
				$b = $this->_content->$block;
			else
				$b = new OutputBlock($block);
			$b->Out($content);
			$this->_content->Add($block, $b);
		}
		else {
			$this->_content->Add($block, $content);
		}
	}
	public function Roolback($block = null) {
		if(is_null($block))
			return;
		$out = $this->$block;
		$this->_content->Delete($block);
		return $out;
	}
	public function RoolbackLast() {
		$block = $this->_content->Key($this->_content->Count()-1);
		$out = $this->$block;
		$this->_content->Delete($block);
		return $out;
	}
	public function Clear() {
		$this->_content->Clear();
	}
	public function StartBlockOutput($block) {
		$this->_currentblock = $block;
	}
	public function EndBlockOutput() {
		$this->_currentblock = null;
	}
}
?>
<?php
class style{
	public $Color;
	public $Weight;
	public $Size;
	public $Style;
	public $Tag;
	public $Enable = true;
	function style($color, $weight, $size = ""){
		$this->Color = $color;
		$this->Weight = $weight;
		$this->Size = $size;
		$this->Style = "";
		$this->Tag = "span";
	}
	public function ToString($text, $attributes = ""){
		return (!$this->Enable) ? $text : 
			"<{$this->Tag} style='color: {$this->Color}; font-weight: {$this->Weight};" . 
			(($this->Size != "") ? " font-size: {$this->Size};" : "") . 
			(($this->Style != "") ? " font-style: {$this->Style};" : "") . 
			(($attributes != "") ? " {$Attributes}" : "") . 
			"'>{$text}</{$this->Tag}>";
	}
}
class debug{
	private $_items;
	private $_time0;
	private $_zone = 0;
	private $_buffer;
	public $Target = WEBPAGE;
	public $Out;
	public $Tol = 0;
	public $Hilite = true; 	public $Detailed = true;
	public $Relative = false;
	public $Stack = false;
	public $Roll = true;
	public $Styles;
	function debug(){
		$this->Out = DEBUG_ENABLE_OUT | DEBUG_ENABLE_BP;
		$this->_items = array();
		$this->_time0 = microtime(true);
		$this->Styles = array();
		$this->Styles["info"] = new style("#0000ff", "bold");
		$this->Styles["text"] = new style("#800080", "normal");
		$this->Styles["essence"] = new style("#800080", "bold");
		$this->Styles["line"] = new style("#008080", "normal");
		$this->Styles["string"] = new style("#008000", "normal");
		$this->Styles["integer"] = new style("#ff0000", "normal");
		$this->Styles["keyword"] = new style("#0000ff", "normal");
		$this->Styles["comment"] = new style("#808080", "normal");
		$this->Styles["extra"] = new style("#ff8000", "normal");
	}
    public function Dispose() {
        unset($this->Styles);
        unset($this->_items);
    }
	public function Initialize($set = DEBUG_STANDART_SET){
		switch ($set) {
			case DEBUG_SIMPLE_SET :
				break;
			case DEBUG_STANDART_SET :
				break;
			case DEBUG_DETAILED_SET :
				break;
		}
	}
	function __set($key, $value){
	}
	public function Start($zone){
		$this->buffer = $this->zone;
		$this->zone = $zone;
	}
	public function End(){
		$this->zone = $this->buffer;
	}
	private function item($track){
		$stack = debug_backtrace();
		$item = new stdClass();
		if (isset($track))
			$item->track = $track;
		$item->zone = $this->_zone;
		$item->line = $stack[1]["line"];
		$item->file = $stack[1]["file"];
		$item->stack = $stack;
		$item->time = microtime(true);
		return $item;
	}
	public function Bp($track = null){
		if (!($this->Out & DEBUG_ENABLE_BP))
			return;
		$this->_items[] = $this->item($track);
	}
	public function Info(){
		if (!($this->Out & DEBUG_ENABLE_BP))
			return;
		if (count($this->_items) > 0)
			$this->registerExtra();
		$args = func_get_args();
		$all = false;
		$acount = count($args);
		if ($acount == 0){
			$acount = count($this->_items);
			$all = true;
		}
		$last = array();
		for ($a = 0; $a < $acount; $a++){
			if ($all){
				if (in_array($this->_items[$a]->line, $last))
					continue; 				$line = $this->_items[$a]->line;
			} else {
				$line = $args[$a];
			}
			$last[] = $line;
			$bps = array();
			for ($i = 0; $i < count($this->_items); $i++)
				if (($this->_items[$i]->line >= ($line - $this->Tol))
					&& ($this->_items[$i]->line <= ($line + $this->Tol))
					&& ($this->_items[$i]->zone == $this->_zone))
						$bps[] = $i;
			$count = count($bps);
			if ($count == 0)
				continue;
			$item = new stdClass();
			$item->calls = array();
			$item->_items = array();
			$pstack = null; $ncall = 0;
			for ($i = 0; $i < $count; $i++){
				$bp = $this->_items[$bps[$i]];
				$bp->stack = array_values(array_slice($bp->stack, 2, count($bp->stack) - 1, true));
				if (count($pstack) != count($bp->stack)){
					$item->calls[] = $bp->stack;
					$ncall++;
				}
				$item->_items[$i]->call = $ncall;
				$item->_items[$i]->time = $bp->time;
				if (isset($bp->track))
					$item->_items[$i]->track = $bp->track;
				$pstack = $bp->stack;
			}
			$item->title->line = $this->_items[$bps[0]]->line;
			$item->title->file = $this->_items[$bps[0]]->file;
			$item->title->calls = $ncall;
			$item->title->bps = ($ncall == 0) ? 1 : $count / $ncall;
			$this->stdOut($item);
		}
	}
	private function formatArgs($args){
		$result = array();
		if (!is_array($args)) $args = array($args);
		foreach ($args as $k => $v){
			$value = htmlentities(print_r($v, true));
			$type = gettype($v);
			if ($type == "NULL") continue;
			switch ($type){
				case "integer" : case "float" : case "double" :
					$result[] = ((is_string($k)) ? $k . " = " : "") . $this->Styles["integer"]->toString($value);
					break;
				default : case "string" :
					$result[] = ((is_string($k)) ? $k . " = " : "") . $this->Styles["string"]->toString("'{$value}'");
					break;
				case "resource" :
					$result[] = ((is_string($k)) ? $k . " = " : "") . $this->Styles["text"]->toString($value);
					break;
				case "boolean" :
					$result[] = ((is_string($k)) ? $k . " = " : "") . $this->Styles["keyword"]->toString(cbool($value));
					break;
				case "array" : case "object" :
					break;
			}
		}
		return implode(", \r\n", $result);
	}
	private function parseFunctionInfo($call){
		$result = (isset($call['type']))
					? $this->Styles["keyword"]->toString("class ") .
					$this->Styles["line"]->toString($call['class']) .
					$this->Styles["keyword"]->toString((($call['type'] == "::") ? ", static" : ",") . " method ")
					: $this->Styles["keyword"]->toString("function ");
		return $result . $this->Styles["essence"]->toString($call['function']);
	}
	private function formatTitle($data){
		if ($data->title->calls == 0){
			$result = $this->formatBreakpoints(-1, $data, true);
		} else {
			$result =
				$this->Styles["line"]->toString("#{$data->title->line}: ") . "\r\n" .
				$this->Styles["integer"]->toString("{$data->title->bps} ") .
				$this->Styles["keyword"]->toString("breakpoints, ") . "\r\n" .
				$this->Styles["integer"]->toString("{$data->title->calls} ") .
				$this->Styles["keyword"]->toString("calls ") . "\r\n";
			if ($this->Detailed && $data->title->file != "")
				$result .= ", " .
					$this->Styles["keyword"]->toString("file ") .
					$this->Styles["string"]->toString("'{$data->title->file}' ") . "\r\n";
		}
		return $result;
	}
	private function formatStack($i, $data){
		$call = $data->calls[$i];
		$scount = count($call);
		if ($scount == 0) return "";
		$id = $data->title->line . $call[$scount - 1]['line'];
		$result = "<div style='margin: 0px 0px 0px 5px; cursor: hand; width: 50px;
			font-weight: bold; text-align: center; vertical-align: middle;" .
			(($this->Hilite) ? "color: #000000; background-color: #ffff00;" : "color: #000000; background-color: #ffffff;") .
			(($this->Roll) ? "" : " border: 1px solid #A9ABAB;" ) .
			"' onClick=\"javascript: roll(this, 'st_{$id}');\">stack</div>";
		$result .= "\r\n<div id='st_{$id}' style='margin: 0px 0px 0px 5px; display: " . (($this->Roll) ? "" : "none;") . "'>\r\n"; 
		for ($i = 0; $i < $scount; $i++){
			$result .=
				$this->Styles["line"]->toString("#{$call[$i]['line']}: ") . "\r\n" .
				$this->parseFunctionInfo($call[$i]) . "(" . ((isset($call[$i]['args'])) ? $this->formatArgs($call[$i]['args']) : "") . ")";
			if ($this->Detailed && $call[$i]['file'] != "")
				$result .= ", " .
					$this->Styles["keyword"]->toString("file ") .
					$this->Styles["string"]->toString("'{$call[$i]['file']}' ") . "\r\n<br>";
		}
		$result .= "\r\n</div>\r\n"; 		return $result;
	}
	private function formatBreakpoints($i, $data, $line = false){
		if (!$line){
			$call = $data->calls[$i];
			$scount = count($call);
			$id = $data->title->line . $data->calls[$i][$scount - 1]['line'];
			$result = "<div style='margin: 3px 0px 0px 5px; cursor: hand; width: 90px;
				font-weight: bold; text-align: center; vertical-align: middle;" .
				(($this->Hilite) ? "color: #ffffff; background-color: #ff0000;" : "color: #000000; background-color: #ffffff;") .
				(($this->Roll) ? "" : " border: 1px solid #A9ABAB;" ) .
				"' onClick=\"javascript: roll(this, 'bp_{$id}');\">breakpoints</div>";
			$result .= "\r\n<div id='bp_{$id}' style='margin: 0px 0px 0px 5px; display: " . (($this->Roll) ? "" : "none;") . "'>\r\n"; 		} else {
			$result = "\r\n<div style='margin: 3px 0px 3px 0px;'>";
		}
		$bps = array_object_search($data->_items, "call", $i + 1);
		$time0 = $this->_time0;
		$ptime0 = $time0;
		$bcount = count($bps);
		for ($k = 0; $k < $bcount; $k++){
			$bp = $data->_items[$bps[$k]];
						$time = sprintf("%01.3f", (($this->Relative) ? $bp->time - $ptime0 : $bp->time - $time0) * 1e3); 			$nbp = ($line) ? $data->title->line : $k + 1;
			$result .=
				(($this->Hilite) ? $this->Styles["line"]->toString("#{$nbp}: ") : "#{$nbp}: ") . "\r\n" .
				(($this->Hilite) ? $this->Styles["integer"]->toString("{$time} ") : "{$time} ") . "\r\n" .
				" milliseconds" .
				(isset($bp->track) ? " (" . $this->formatArgs($bp->track) . ")" : "") . "\r\n<br>";
			$ptime0 = $bp->time;
		}
		$result .= "\r\n</div>\r\n"; 
		return $result;
	}
	private function stdOut($data){
		switch ($this->Target){
			case WEBPAGE :
				if (!$this->Hilite)
					foreach ($this->Styles as $k => $v)
						$v->enable = false;
				$result = "<div style='margin: 5px 0px 0px 0px; font-family: Courier New, Courier, monospace;
							font-size: 12px; white-space: nowrap;'>\r\n"; 
								$result .= $this->formatTitle($data);
								$count = count($data->calls);
				for ($i = 0; $i < $count; $i++){
					$result .= "\r\n<div style='margin: 5px 0px 0px 20px; padding: 0px 0px 0px 0px;
						width: 300px; border-left: 1px solid #A9ABAB;'>
						\r\n<div style='border-top: 1px solid #A9ABAB; font-size: 5px; width: 5px;'></div>\r\n";
					if($this->Stack)
						$result .= $this->formatStack($i, $data); 					$result .= $this->formatBreakpoints($i, $data); 
					$result .= "\r\n<div style='border-bottom: 1px solid #A9ABAB; font-size: 5px; width: 5px;'></div>\r\n</div>\r\n";
				}
				$result .= "\r\n</div>\r\n"; 
				echo $result;
				break;
			case FILE :
								break;
			case DATABASE :
								break;
			case EMAIL :
								break;
		}
	}
	public function Out(){
		if (!($this->Out & DEBUG_ENABLE_OUT))
			return;
		$args = func_get_args();
		$count = count($args);
		for ($i = 0; $i < $count; $i++) cout($args[$i]);
	}
	public static function MemUsage() {
		return memory_get_usage();
	}
	private function registerExtra(){
		echo "
		<style>
			.html_tooltip {
				border: 1px solid #000000;
				background-color:#ffffe1;
				font-size:11px;
				font-family: Courier New;
				overflow:auto;
				width: 300px;
				height: 300px;
				text-align:left;
				padding:5px;
			}
		</style>
		<script language=\"javascript\">
			function HTMLToolTip(esrc, text) {
				this.html = text;
				this.absolutetop = function(el) {
					var top = 0;
					while(el) {
						top += el.offsetTop;
						el = el.offsetParent;
					}
					return top;
				}
				this.absoluteleft = function(el) {
					var left = 0;
					while(el) {
						left += el.offsetLeft;
						el = el.offsetParent;
					}
					return left;
				}
				this.visible = function() {
					return this.element.style.display == \"\";
				}
				this.show = function () {
					if(!this.visible())	 {
						window.tooltips[window.tooltips.length] = this;
						this.hideall();
						this.element.style.top = this.pX;
						this.element.style.left = this.pY;
						this.element.style.display = \"\";
						this.element.focus();
						if(window.tooltips == null)	window.tooltips = new Array();
						window.tooltips[window.tooltips.length] = this;
					}
				}
				this.hideall = function() {
					while(window.tooltips.length) {
						var tooltip = window.tooltips[0];
						tooltip.element.style.display = \"none\";
						window.tooltips.splice(0, 1);
					}
				}
				this.blur = function() {
					this.thisClass.hideall();
				}
				this.isMouseOver = function() {
					return this.mouseIsOver;
				}
				window.tooltips = new Array();
				this.pX = this.absolutetop(esrc) + esrc.offsetHeight;
				this.pY = this.absoluteleft(esrc);
				this.element = document.createElement(\"DIV\");
				this.element.thisClass = this;
				this.element.className = \"html_tooltip\";
				this.element.style.display = \"none\";
				this.element.style.position = \"absolute\";
				this.element.innerHTML = text;
				document.body.appendChild(this.element);
				this.element.onblur = this.blur;
			}
			function roll(obj, el){
				var el = document.getElementById(el);
				el.style.display = (el.style.display == \"\") ? 'none' : \"\";
				obj.style.border = (el.style.display == \"\") ? \"\" : \"1px solid #A9ABAB\";
			}
		</script>
			";
		}
	}
?>
<?php
class ob  {
	function ob() {
	}
	function __destruct() {
		global $core;
		if($core) {
			if($core->obenabled) {
				if($this->length() > 0)
					ob_end_flush();
			}
		}
	}
    public function Dispose() {
    }
	public function Initialize(){
		global $core;
		$handler = $this->getencodinghandler();
		if($core->obenabled) {
			if(!is_null($handler))
				ob_start($handler);
			else
				ob_start();
		}
	}
	public function getencodinghandler() {
		global $core;
		switch($core->obenconding) {
			case 'gzip':
				return 'ob_gzhandler';
			default:
				return null;
		}
	}
	public function flush() {
		ob_flush();
	}
	public function get($end = true) {
		$tmp = ob_get_contents();
		if($end)
			ob_end_clean();
		return $tmp;
	}
	public function length() {
		return ob_get_length();
	}
	public function clear() {
		ob_clean();
	}
}
?><?php
class systemrestore {
	private $_isDroptables;
	function systemrestore() {
				$this->setDroptables(false);
	}
	function setDroptables($state) {
		$this->_isDroptables = $state;
	}
	function isDroptables() {
		return $this->_isDroptables;
	}
    private function _dumpTable($gzfile, $table, $idfield = '') {
        global $core;
        $gzfile->write("\n\n");
        $gzfile->write('// dumping data for table '.$table."\n");
        $gzfile->write('$core->dbe->TruncateTable("'.$table.'");'."\n");
        $result = $core->dbe->ExecuteReader("SELECT * FROM ".$table);
        while($row = $result->Read()) {
            $row = $core->dbe->PrepareRowData($table, $row->Data());
            $row = bin2hex(serialize(get_object_vars($row)));
            $gzfile->write('$core->dbe->Insert("'.$table.'", Collection::Deserialize(hex2bin(\''.$row.'\')));'."\n");
        }
        if(!is_empty($idfield))
            $gzfile->write('$core->dbe->SetAutoincrement("'.$table.'", "'.$idfield.'");');
    }
    public function CreatePoint() {
        global $core;
        $dumpname = strftime("%Y%m%d%H%M%S", time()).".srp.gz";
        $gzfile = new GZFile($core->fs->mappath("/system_restore/".$dumpname), MODE_CREATEWRITE);
                set_time_limit(999999);
        $lf = "\r\n";
        $output  = "<"."?". $lf;
        $output .= "/*". $lf;
        $output .= " * Pioneer System Restore" . $lf;
        $output .= " * Pioneer version: 1.5.0".$lf;
        $output .= " * Host: " . $core->server . $lf;
        $output .= " * Generation Time: " . date("M j, Y \a\\t H:i") . $lf;
        $output .= " * PHP Version: " . phpversion() . $lf;
        $output .= " * Database : " . $core->database . "" . $lf;
        $output .= " */". $lf. $lf;
        $gzfile->write($output);
        $strgs = new Storages();
        $strgs = $strgs->Enum();
        foreach($strgs as $storage) {
            $gzfile->write($storage->ToPhpScript().$lf.$lf);
        }
        $gzfile->write(Repository::Enum()->ToPHPScript());
        $gzfile->write(designTemplates::ToPHPScript());
        $gzfile->write($core->mm->ToPHPScript());
        $this->_dumpTable($gzfile, 'sys_tree', 'tree_id');
        foreach($strgs as $storage) $this->_dumpTable($gzfile, $storage->table, $storage->table.'_id');
        foreach($core->dbe->scheme as $schemeTable) {
            $table = $schemeTable->name;
                if(in_array($table, array(
                    "sys_blobs_cache", "sys_statistics", "sys_index", "sys_index_words",                     "sys_templates", "sys_storages", "sys_storage_fields", "sys_storage_templates", "sys_repository", "sys_modules", "sys_module_templates"                    ))) 
                    continue;
                $this->_dumpTable($gzfile, $table);
        }
        foreach($core->mm->activemodules as $m) {
            if(!is_null($m->datascheme)) {
                foreach($m->datascheme as $st) {
                    $this->_dumpTable($gzfile, $st->name);
                }
            }
        }
        $gzfile->write("?".">". $lf);
        $gzfile->close();
        return $dumpname;
    }
    public function RestoreFrom($dumpname) {
        global $core;
        set_time_limit(999999);
        if(empty($dumpname) || $dumpname == "")
            return false;
        $uncompressed = $core->fs->mappath("/system_restore/".str_replace(".gz", "", $dumpname));
        if(strstr($dumpname, '.gz') !== false) {
            $gzfile = new GZFile($core->fs->mappath("/system_restore/".$dumpname), MODE_READ);
            $gzfile->uncompress($uncompressed);
            $gzfile->close();
        }        
        $core->dbe->StartTrans();
        require_once($uncompressed);
        $core->dbe->CompleteTrans();
        unlink($uncompressed);
        return true;
    }
    function Test() {
        global $core; 
        $file = strftime("%Y%m%d%H%M%S", time()).".srp.gz";
        $dumpname = $core->fs->MapPath("/system_restore/".$file);
        system('mysqldump --opt -u '.$core->user.' --password="'.$core->password.'" --hex-blob --default-character-set=utf8 --no-create-db --add-drop-table --database '.$core->database.' | gzip -9 > '.$dumpname);
        return $file;
        global $core;
        $script = '
/*
 *   Pioneer System Restore
 *   Pioneer version: 1.5.0
 *   Host: '.$core->server.'
 *   Generation Time: '.date("M j, Y \a\\t H:i").' 
 *   PHP Version: ' . phpversion().'
 *   Database : '.$core->database.'
 */
        ';
        $tables = $core->dbe->Tables();
        foreach($tables as $table) {
            if(substr($table, 0, 4) == 'sys_') {
                if(in_array($table, array("sys_blobs_cache", "sys_statistics", "sys_index", "sys_index_words"))) continue;
                $script .= "\n\n";
                $script .= '// dumping data for table '.$table."\n";
                $script .= '$core->dbe->TruncateTable($table);'."\n";
                $result = $core->dbe->ExecuteReader("SELECT * FROM ".$table);                 while($row = $result->Read()) {
                    $row = serialize(get_object_vars($row));
                    $script .= '$core->dbe->Insert("'.$table.'", Collection::Deserialize(\''.$row.'\'));'."\n";
                }
            }
        }
        $tables = $core->dbe->Tables();
        foreach($tables as $table) {
            if(substr($table, 0, 4) != 'sys_') {
                $script .= "\n\n";
                $script .= '// dumping data for table '.$table."\n";
                $script .= '$core->dbe->TruncateTable($table);'."\n";
                $result = $core->dbe->ExecuteReader("SELECT * FROM ".$table);                 while($row = $result->Read()) {
                    $row = serialize(get_object_vars($row));
                    $script .= '$core->dbe->Insert("'.$table.'", Collection::Deserialize(\''.$row.'\'));'."\n";
                }
            }
        }
        out($script);
        exit;
    }
	function createRestorePoint($multiFile = false, $partSize = 5 ) {
        global $core;
		$partSize = ($partSize * 1024)*1024;
		$max_execution_time = ini_get('max_execution_time');		
		ini_set('max_execution_time', '99999');
		$lf = "\r\n";
				$dumpname = strftime("%Y%m%d%H%M%S", time()).".srp.gz";
		$gzfile = new GZFile($core->fs->mappath("/system_restore/".($multiFile ? "part1." : "").$dumpname), MODE_CREATEWRITE);
		$result = $core->dbe->Tables();
		foreach($result as $tblval) {
						$result1 = $core->dbe->ExecuteReader("SHOW CREATE TABLE ".$tblval."");
			$ct = "Create Table";
			$tbl = $result1->Read();
			$createtable[$tbl->Table] = $tbl->$ct;
		}
				$output  = "#". $lf;
		$output .= "# Pioneer System Restore" . $lf;
		$output .= "# Pioneer version: 1.5.0".$lf;
		$output .= "# Host: " . $core->server . $lf;
		$output .= "# Generation Time: " . date("M j, Y \a\\t H:i") . $lf;
		$output .= "# PHP Version: " . phpversion() . $lf;
		$output .= "# Database : " . $core->database . "" . $lf;
		$output .= "#";
		$gzfile->write($output);
		$output = "";
        $partS = 0;
        $iFile = 1;
				foreach ($createtable as $tblval => $createtbl) {
			$output .= $lf . $lf . "# --------------------------------------------------------" . $lf . $lf;
			$output .= "#". $lf . "# Table structure for table $tblval" . $lf;
			$output .= "#" . $lf . $lf;
						if($this->isDroptables()) {
				$output .= "DROP TABLE IF EXISTS $tblval;" . $lf;
			}
			$output .= $createtbl.";" . $lf;
			if($tblval == "sys_blobs_cache" || $tblval == "sys_statistics" || $tblval == "sys_index" || $tblval == "sys_index_words")
				continue;
			$output .= $lf;
			$output .= "#". $lf . "# Dumping data for table $tblval". $lf . "#" . $lf;
			$result = $core->dbe->ExecuteReader("SELECT * FROM $tblval"); 			$i=0;
			while($row = $result->Read()) {
				$insertdump = $lf;
				$insertdump .= "INSERT INTO $tblval VALUES (";
				$arr = new collection();
				$arr->from_object($row);
				foreach($arr as $key => $value) {
					$f = $result->fields[$key];
					if(is_null($value))
						$insertdump .= "null,";
					else {
						if($f->blob || $f->type == "string"){
							if($value == '')
								$value = "''";
							else
								$value = "0x".bin2hex($value);
						}
						else {
							$value = addslashes($value);
							$value = str_replace("\n", '\r\n', $value);
							$value = str_replace("\r", '', $value);
							$value = "'".$value."'";
						}
						$insertdump .= $value.",";
					}
				}
				$output .= rtrim($insertdump,',') . ");";
				$i++;
				$gzfile->write($output);
                				$output = "";
			}
			$gzfile->write($output);
			$output = "";
            if($multiFile) {
                $partS = 0;
                $iFile++;
                $gzfile->Close();
                $gzfile = new GZFile($core->fs->mappath("/system_restore/".($multiFile ? "part".$iFile."." : "").$dumpname), MODE_CREATEWRITE);
            }
		}
		$gzfile->close();			
		return $dumpname;
	}
	function listPoints($sort = "file_name", $sortType = SORT_ASC) {
		global $core;
		return $core->fs->list_files("/system_restore/", array("srp", "gz"), null, $sort, $sortType);
	}
	function parse_mysql_dump($content , $ignoreerrors = false) {
		global $core;
				$file_content = $content;
		$query = "";
		foreach($file_content as $sql_line) {
			$tsl = trim($sql_line);
			if (($tsl != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "#")) {
				$query .= $sql_line;
				if(preg_match("/;\s*$/", $sql_line)) {
										$result = $core->dbe->query($query);
					if (!$result && !$ignoreerrors) {
						return false;
					}
					$query = "";
				}
			}
		}
		return true;
	}	
	function restoreFromRestorePoint($dumpname) {
		global $core;
		$memlimit = ini_get('memory_limit');
		ini_set('memory_limit', '300M');		
		$max_execution_time = ini_get('max_execution_time');		
		ini_set('max_execution_time', '99999');
		if(empty($dumpname) || $dumpname == "")
			return false;
		$gzfile = new GZFile($core->fs->mappath("/system_restore/".$dumpname), MODE_READ);
		$content = $gzfile->readall();
		$content = preg_split("/\n/", $content);
		$core->dbe->Query("START TRANSACTION");
		$r = $this->parse_mysql_dump($content, false);
		if($r)
			$core->dbe->Query("COMMIT");
		else
			$core->dbe->Query("ROLLBACK");
		$gzfile->close();
		ini_set('memory_limit', $memlimit);
		ini_set('max_execution_time', $max_execution_time);
		return $r;
	}
	function clean_points($maxcount) {
		global $core;
		$files = $this->listPoints("file_name", SORT_ASC);
		if($maxcount > -1) {
			if($files->count() > $maxcount) {
				$delcount = $files->count() -  $maxcount;
				for ($i=0; $i<$delcount; $i++) {
					$core->fs->deletefile("/system_restore/".$files->item($i)->file);
				}
			}
		}
	}
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("sysrestore.create", "Create a restore point"));
		$operations->Add(new Operation("sysrestore.restore", "Restore a system from backup"));
		$operations->Add(new Operation("sysrestore.setschedule", "Set the CRONTAB schedule"));
		return $operations;
	}
}
class SystemBackup {
	public function __construct() {
	}
	public function CreateDataBackupScript($storages = null, $dumpData = true) {
		if(is_null($storages))
			$storages = Storages::Enum();
		$string = '';
		$string .= '
		/*
		*	Pioneer Data Backup
		*/
		';
		foreach($storages as $storage) {
			$string .= $storage->ToCreateScript($storage->table, array('name', 'table', 'color'));
			$fields = $storage->fields;
			foreach($fields as $field) {
				$string .= $field->ToCreateScript('field', array('name', 'type', 'default', 'field', 'required', 'showintemplate', 'lookup', 'onetomany', 'values'), array(), array('$'.$storage->table));
			}
			$templates = $storage->templates;
			foreach($templates as $template) {
				$string .= $template->ToCreateScript('template', array('name', 'description', 'list', 'properties', 'styles', 'composite', 'cache', 'cachecheck'), array(), array('null', 'TEMPLATE_STORAGE', '$'.$storage->table));
			}
			if($dumpData) {
				$datarows = new DataRows($storage);
				$datarows->Load();
				while($dtr = $datarows->FetchNext()) {
					$string .= $dtr->ToCreateScript("data", array(), array(), array('$'.$storage->table));
				}
			}
		}
		return $string;
	}
	private function _CreateBlobCategoriesBackupScript($parent = null) {
		$string = '';
		$bs = new BlobCategories($parent);
		foreach($bs as $bc) {
			$string .= $bc->ToCreateScript('c'.$bc->id, array(), array("id"));
			$string .= $this->_CreateBlobCategoriesBackupScript($bc);
		}
		return $string;
	}
	public function CreateBlobsBackupScript() {
		$string = $this-> _CreateBlobCategoriesBackupScript();
		$bs = new Blobs(BLOBS_ALL);
		foreach($bs as $b) {
			$string .= $b->ToCreateScript('b'.$b->id, array(), array("id"));
			$string .= 'b'.$b->id.'->data->data = "'.db_prepare($b->data->data).'";'."\n";
			$string .= 'b'.$b->id.'->Save();'."\n";
		}
		return $string;
	}
}
?><?
class CollectionBaseIterator implements Iterator {
	private $_class;
	private $_current = 0;
	public function __construct($class = null) {
		$this->_class = $class;
	}
	public function rewind() {
		$this->_current = 0;
		if(method_exists($this->_class, "Key"))
			return $this->_class->Key($this->_current);
		else
			return $this->_current;
	}
	public function current() {
		if($this->valid())
			return $this->_class->Item($this->_current);
		else	
			return false;
	}
	public function key() {
		if(method_exists($this->_class, "Key"))
			return $this->_class->Key($this->_current);
		else
			return $this->_current;		
	}
	public function next() {
		$this->_current++;
		if($this->valid())
			return $this->_class->Item($this->_current);
		else	
			return false;
	}
	public function valid() {
		return $this->_current >= 0 && $this->_current < $this->_class->Count();
	}
}
class CollectionBase implements IteratorAggregate {
	protected $m_Storage;
	protected $_keyPair = false;
	protected $_locked = false;
	public function __construct($keyPair = false) {
		$this->_keyPair = $keyPair;
		$this->m_Storage = array();
	}
    public function Dispose() {
        array_splice($this->m_Storage, 0, 0);
    }
	public function getIterator() {
		return new CollectionBaseIterator($this);
	}
	public function Index($key) {
		if(is_string($key)) {
			$key_index = array_keys(array_keys($this->m_Storage), to_lower($key));
			return is_null(@$key_index[0]) ? false : @$key_index[0];
		}
		else
			return $key;
	}
	public function Key($index) {
		if(!$this->_keyPair)
			return $index;
		else {
			switch(gettype($index)) {
				case "integer":
					if(is_array($this->m_Storage)) {
						$keys = array_keys($this->m_Storage);
						if($index < count($keys))
							return to_lower($keys[$index]);
						else
							return null;
					}
					else
						return null;
				case "string":
					return to_lower($index);
					break;
				default:
					return "";
					break;
			}
		}
	}
	public function Item($index) {
        return @$this->m_Storage[$this->Key($index)];
	}
	public function First() {
		if($this->Count() > 0)
			return $this->Item(0);
		return false;
	}
	public function Last() {
		if($this->Count() > 0)
			return $this->Item($this->Count() - 1);
		return false;
	}
	public function Exists($key) {
		if(is_string($key))
			$key = to_lower($key);
		else
			$key = $this->Key($key);
		return @array_key_exists($key, $this->m_Storage);
	}
	public function Contains($value){
		return in_array($value, $this->m_Storage);
	}
	public function Keys() {
		return array_keys($this->m_Storage);
	}
	public function Items() {
		return array_values($this->m_Storage);
	}
	public function Clear() {
		if($this->_locked)
			return;
		@array_splice($this->m_Storage, 0, count($this->m_Storage));
	}
	public function Count() {
		$c = count($this->m_Storage);
		if(empty($c))
			return 0;
		return (int)$c;
	}
	public function IsEmpty() {
		return $this->Count() == 0;
	}
	public function ToArray(){
		return array_merge(array(), $this->m_Storage);
	}
	public function Serialize(){
		return serialize($this->m_Storage);
	}
	public function Lock(){
		$this->_locked = true;
	}
	public function Unlock(){
		$this->_locked = false;
	}
	public function ToXML() {
		$tagName = to_lower(get_class($this));
		$ret = "<".$tagName.">";
		foreach($this->m_Storage as $key => $value) {
			if(is_object($value)) {
				if(method_exists($value, "ToXML"))
					$value = $value->ToXML();
				else {
					$value = @serialize($value);
				}
			}
			else
				$value = prepare_attribute(htmlspecialchars($value));
			if($this->_keyPair)
				$ret .= "<pair><key>".$key."</key><value>".$value."</value></pair>";
			else
				$ret .= "<value>".$value."</value>";
		}
		$ret .= "</".$tagName.">";
		return $ret;
	}
		public function to_xml() {
		return $this->ToXml();
	}
    public function Shuffle() {
        shuffle($this->m_Storage);
    }
}
?><?php
class ListIterator implements Iterator {
	private $_class;
	private $_current = 0;
	public function __construct($class = null) {
		$this->_class = $class;
	}
	public function rewind() {
		$this->_current = 0;
		return $this->_class->Key($this->_current);
	}
	public function current() {
		if($this->valid())
			return $this->_class->Item($this->_current);
		else	
			return false;
	}
	public function key() {
		return $this->_class->Key($this->_current);
	}
	public function next() {
		$this->_current++;
		if($this->valid())
			return $this->_class->Item($this->_current);
		else	
			return false;
	}
	public function valid() {
		return $this->_current >= 0 && $this->_current < $this->_class->Count();
	}
}
class ListBase implements IteratorAggregate {
	protected $_data;		protected $_keys;
	public function __construct() {
		$this->_data = new stdClass();
		$this->_keys = array();
	}
	public function __get($key) {
        switch($key) {
            case 'count':
                return $this->Count();
            case 'first':
                return $this->Item(0);
            case 'last':
                return $this->Item($this->Count() - 1);
            default: 
                return $this->Item($key); 
        }
	}
	public function __set($key, $value) {
		$this->Add($key, $value);
	}
	public function Keys() {
		return $this->_keys;
	}
	public function Clear() {
        foreach($this->_keys as $k)
            unset($this->_data->$k);
		$this->_data = new stdClass();
		array_splice($this->_keys, 0, count($this->_keys));
	}
	public function Contains($value){
		$array = get_object_vars($this->_data);
		return in_array($value, $array);
	}
	public function Key($index) {
		if(is_integer($index)) {
			$keys = @$this->Keys();
			if($index >= 0 && $index < count($keys))
				return $keys[$index];
			return false;
		}
		else 
			return to_lower($index);
	}
	public function Items() {
		$ret = array();
		$keys = $this->Keys();
		foreach($keys as $k) {
			$ret[] = $this->Item($k);
		}
		return $ret;
	}
	public function Exists($key) {
		return in_array(to_lower($key), $this->_keys);
	}
	public function Item($key) {
		$key = $this->Key($key);
		if(!$this->Exists($key))
			return false;
		return $this->_data->$key;
	}
	public function Add($key, $value) {
        if(is_null($key))
            iout($key, $value, debug_backtrace());
		$key = $this->Key($key);
		$this->_data->$key = $value;
		if(!$this->Exists($key))
			$this->_keys[] = $key;
		return @$this->_data->$key;
	}
	function Delete($key) {
		if(is_numeric($key))
			$key = $this->Key($key);
		if($this->Exists($key)) {
			unset($this->_data->$key);
			array_splice($this->_keys, array_search($key, $this->_keys), 1);
		}
	}
	public function Count() {
		return count($this->_keys);
	}
	public function getIterator() {
		return new ListIterator($this);
	}
	public function ToXML() {
		$tagName = to_lower(get_class($this));
		$ret = "<".$tagName.">";
		$ar = get_object_vars($this->_data);
		foreach($ar as $key => $value) {
			if(is_object($value)) {
				if(method_exists($value, "ToXML"))
					$value = $value->ToXML();
				else {
					$value = @serialize($value);
				}
			}
			else
				$valuse = prepare_attribute(htmlspecialchars($value));
			$ret .= "<pair><key>".$key."</key><value>".$value."</value></pair>";
		}
		$ret .= "</".$tagName.">";
		return $ret;
	}
		public function to_xml() {
		return $this->ToXml();
	}	
}
?><?php
class ArrayList extends CollectionBase {
	function __construct($data = null){
				parent::__construct(false);
		switch (gettype($data)){
			case "array" :
				$this->m_Storage = array_values($data);
				break;
			case "string" :
				$this->m_Storage = ArrayList::Create($data);
				break;
			case "object" :
				switch (strtolower(get_class($data))){
					case "collection" : case "arraylist" :
						$this->m_Storage = $data->values();
						break;
					default : 
						$this->m_Storage = array_values(get_object_vars($data));
				}
				break;
			default : return;
		}
	}
	function __destruct(){
		self::Clear();
	}
    public function __get($prop) {
        switch($prop) {
            case "first":
                return $this->Item(0);
            case "last":
                return $this->Item($this->Count()-1);
            default:
                return false; 
        }
    }
	public function Add($value, $index = -1){
		if ($this->_locked)
			return;
		if ($index == -1)
			$this->m_Storage[] = $value;
		else
			if (is_numeric($index))
				$this->m_Storage[$index] = $value;
	}
	public function AddRange($values){
		if ($this->_locked)
			return;
		$this->m_Storage = array_merge($this->m_Storage, $values);
	}
	public function Append($list){
		if ($this->_locked)
			return;
		foreach ($list as $v)
			$this->Add($v);
	}
	public function Delete($index){
		if ($this->_locked)
			return;
		if (!array_key_exists($index, $this->m_Storage)) 			return;
		unset($this->m_Storage[$index]);
		$this->m_Storage = array_values($this->m_Storage);
	}
	public function DeleteRange($startindex, $count){
		if ($this->_locked)
			return;
		array_splice($this->m_Storage, $startindex, $count);
	}
	public function Insert($data, $index){
		if ($this->_locked)
			return;
		array_splice($this->m_Storage, $index, 0, array($data));
		return $this->m_Storage;
	}
	public function IndexOf($value, $strict = true){
		$res = array_search($value, $this->m_Storage, $strict);
		if($res === false)
			return false;
		return is_array($res) ? $res[0] : $res;
	}
    public function Map($expressoin) {
        for($i=0;$i<$this->Count();$i++) {
            $value = $this->m_Storage[$i];
            eval($expressoin);
            $this->m_Storage[$i] = $value;
        }
    }
	public function Exists($value, $strict = false){
		return array_search($value, $this->m_Storage, $strict) !== false;
	}
	public function Search($key, $value, $strict = false){
		$ret = array();
		foreach ($this as $v){
			switch (gettype($v)){
				case "object" :
					if (($strict) ? @$v->$key === $value : @$v->$key == $value)
						$ret[] = $v;
					break;
				default :
					if (($strict) ? $v === $value : $v == $value)
						$ret[] = $v;
					break;
			}
		}
		$count = count($ret);
		if ($count == 0)
			return;
		return ($count > 1) ? $ret : $ret[0];
	}
	public function Sort($k, $sorttype = SORT_ASC) {
		$keys = array();
		$rows = array();
		foreach ($this->m_Storage as $row) {
			if(is_object($row))
				$keys[] = $row->$k;
			else
				$keys[] = $row[$k];
			$rows[] = $row;
		}
		return array_multisort($keys, $sorttype, $rows, SORT_ASC, $this->m_Storage);
	}
		public function Implode($spl, $key = "", $all = true){
		$data = array();
		foreach ($this->m_Storage as $v){
			switch (gettype($v)){
				case "object" :
					if (@$v->$key)
						$data[] = $v->$key;
					break;
				default :
					if ($all)
						$data[] = $v;
					break;
			}
		}
		return implode($spl, $data);
	}
	public function Reverse(){
		if ($this->_locked)
			return;
		$this->m_Storage = array_reverse($this->m_Storage);
	}
	public function Fill($value, $count){
		if ($this->_locked)
			return;
		$this->m_Storage = array_merge($this->m_Storage, array_fill(0, $count, $value));
	}
	public function get_array(){
		return array_merge(array(), $this->m_Storage);
	}
	public function Copy(){
		return clone $this;
	}
	public function CopyRange($startindex, $count){
		$al = new CArrayList();
		$tcount = count($this->m_Storage);
		if ($count > $tcount - $startindex) 
			$count = $tcount - $startindex;
		$start = $startindex - $tcount;
		$ht->AddRange(array_slice($this->m_Storage, $start, $count));
		return $al;
	}
	public function Walk($handler){
		if ($this->_locked)
			return;
		$this->m_Storage = array_map($handler, $this->m_Storage);
	}
    public function Shuffle() {
        shuffle($this->m_Storage);
    }
	public function ToString($spl = ",", $key = ""){
		if (count($this->m_Storage) == 0)
			return "";
		$ret = "";
		$count = count($this->m_Storage);
		for ($i = 0; $i < $count; $i++){
			$v = $this->m_Storage[$i];
			switch (gettype($v)){
				case "object" :
					if(method_exists($v, "ToString")) {
						$value = $v->ToString();
					}
					else {
						if($key != "")
							$value = $v->$key;
						else 
							$value = get_class($v);
					}
					break;
				default :
					$value = $v;
			}
			$ret .= (($i == 0) ? "" : $spl).trim($value);
		}
		return $ret;
			}
	public function FromString($data, $spl = ",", $callback = ""){
		if (is_empty($data) || is_null($data))
			return $this->Clear();
		$this->m_Storage = explode($spl, $data);
		$count = count($this->m_Storage);
		for ($i = 0; $i < $count; $i++)
			$this->m_Storage[$i] = trim($this->m_Storage[$i]);
		if (!is_empty($callback))
			for ($i = 0; $i < $count; $i++)
				$this->m_Storage[$i] = call_user_func($callback, $this->m_Storage[$i]);
	}
	public function FromCollection($c){
		foreach ($c as $item)
			$this->Add($item);
	}
	public function FromXML($el) {
	    $childs = $el->childNodes;
	    foreach($childs as $pair) {
            $type = @$pair->childNodes->item(0)->nodeType;
            $n = @$pair->childNodes->item(0);
            $value = null;
            switch ($type){
				case 1 : 					$cls = $n->nodeName;
					if (class_exists($cls)){
						$obj = new $cls();
						if (method_exists($obj, "FromXML")){
							$obj->FromXML($pair);
							$value = $obj;
						}
					}
					else {
						$value = unserialize($pair->nodeValue);
					}
					break;
				case 4 :
					$value = $n->childNodes->item(0)->data;
					break;
				case 3 : 					$value = $n->nodeValue;
					break;
				default : 					$value = $n->nodeValue;
			}
			if ($value != null)
				$this->Add($value);
	    }
	}
		public function from_xml($el) {
		$this->FromXML($el);
	}
	public static function Deserialize($data){
		if (!is_empty($data))
			return new arraylist(@unserialize($data));
	}
	static function create($data){
		preg_match_all("/([^,]+)/", $data, $matches);
		$data = array();
		for ($i = 0; $i < count($matches[0]); $i++) 
			$data[] = trim($matches[1][$i]);
		return $data;
	}
		public function Remove($k) {
		deprecate();
		$this->Delete($k);
	}
}
?><?php
class Collection extends CollectionBase {
    public function __construct($arr = array()) {
        parent::__construct(true);
        if(!is_array($arr))
            $arr = array();
                $this->m_Storage = array();
        foreach($arr as $key => $value) {
            $this->m_Storage[to_lower($key)] = $value;
        }
    }
    public function __destruct() {
        if(is_array($this->m_Storage))
            array_splice($this->m_Storage, 0, count($this->m_Storage));
    }
    public function __get($nm)
    {
        switch($nm) {
            case "first":
                return $this->Item(0);
            case "last":
                return $this->Item($this->Count() - 1);
            default:
                if ($this->exists($nm))
                    return $this->item($nm);
                else
                    return NULL;
        }
    }
    public function __set($nm, $val)
    {
        if (isset($this->m_Storage[$this->Key($nm)])) {
            $this->m_Storage[$this->Key($nm)] = $val;
        } else {
            $this->add($nm, $val);
        }
    }
    public function Add($k, $v) {
        if(is_null($k))
            $k = $this->NewKey();
        if(is_string($k))
            $k = to_lower($k);
        $this->m_Storage[$k] = $v;
        return $this->m_Storage[$k];
    }
    public function Insert($k, $v, $index) {
        if(is_null($k))
            $k = $this->NewKey();
        if(is_string($k))
            $k = to_lower($k);
                array_splice($this->m_Storage, $index, 0, array($k => $v));
        return $this->m_Storage[$k];
    }
    public function Delete($k) {
        $index = @$this->Index($k);
        if($index !== false)
            if ($index >= 0 && !is_null($index))
                array_splice($this->m_Storage, $index, 1, array());
    }
    public function Merge($from) {
        foreach($from as $key => $value) {
            $this->Add($key, $value);
        }
    }
    public function Append($array1) {
        if(!is_array($array1))
            if(method_exists($array1, "get_array"))
                $array1 = $array1->get_array();
        if(!is_array($this->m_Storage))
            $this->m_Storage = array();
        $this->m_Storage = array_merge($this->m_Storage, $array1);
    }
    public function Dublicate() {
        $tmp = new collection();
        $tmp->Append($this->m_Storage);
        return $tmp;
    }
    public function Sort($k = null, $sorttype = SORT_ASC) {
        $keys = array();
        $rows = array();
        foreach ($this->m_Storage as $key => $row) {
            if(is_object($row))
                $keys[$key] = is_null($k) ? $key : $row->$k;
            else
                $keys[$key] = is_null($k) ? $key : $row[$k];
            $rows[$key] = $row;
        }
        return array_multisort($keys, $sorttype, $rows, SORT_ASC, $this->m_Storage);
    }
    public function Part($expression) {
        $c = new collection();
        foreach($this as $key => $value) {
            $e = "\$b = ".$expression.";";
            eval($e);
            if($b)
                $c->Add($key, $value);
        }
        return $c;
    }
    public function IndexOfFirst($value) {
        return $this->Index(array_search($value, $this->m_Storage));
    }
    public function IndexOf($value, $key = "", $startindex = "", $count = ""){
        $tcount = $this->Count();
        if (is_empty($startindex))
            $startindex = 0;
        if (is_empty($count))
            $count = $tcount;
        if ($count > $tcount - $startindex) 
            $count = $tcount - $startindex;
        foreach($this as $k => $v) {
            switch (gettype($v)){
                case "object" :
                    if (is_empty($key))
                        continue;
                    if ($v->$key == $value)
                        return $this->Index($k);
                    break;
                default :
                    if ($v == $value)
                        return $this->Index($k);
            }
        }
        return false;
    }
    public function Search($value, $key = null, $fromIndex = 0){
        $count = $this->Count();
        if ($fromIndex >= $count)
            return;
        $ret = array();
                for ($i = $fromIndex; $i < count($this->m_Storage); $i++){
            $k = $this->Key($i);
            $v = $this->Item($i);
            switch (gettype($v)){
                case "object" :
                    if (is_array($key)){
                        foreach ($key as $kk)
                            if ($v->$kk == $value)
                                $ret[] = $v;
                    } else {
                        if ($key != null)
                            if ($v->$key == $value)
                                $ret[] = $v;
                    }
                    break;
                case "array":
                    if (is_array($key)){
                        foreach ($key as $kk)
                            if ($v[$key] == $value)
                                $ret[] = $v;
                    } else {
                        if ($key != null)
                            if ($v[$key] == $value)
                                $ret[] = $v;
                    }
                    break;
                default :
                    if ($v == $value)
                        $ret[] = $v;
                    break;
            }
        }
        $count = count($ret);
        if ($count == 0)
            return;
        return ($count > 1) ? $ret : $ret[0];
    }
    public function NewKey($rel = -1){
        $p = ($rel == -1) ? count($this->m_Storage) : $rel;
        if (array_key_exists("k".$p, $this->m_Storage))
            return $this->NewKey($p + 1);
        return "k".$p;
    }
    public static function Deserialize($data){
        if (!is_empty($data))
            return new Collection(@unserialize($data));
    }
    public static function Create() {
        $c = func_num_args();
        $args = func_get_args();
        if(count($args) == 0)
            return new collection();
        if(is_array($args[0])) {
            $tmp = new collection($args[0]);
        }
        else if(is_object($args[0])) {
                $tmp = new collection();
                $tmp->from_object($args[0] instanceOf Object ? $args[0]->Data() : $args[0]);
            }
            else {
                $tmp = new collection();
                for($i=0; $i<$c; $i+=2) {
                    $tmp->Add($args[$i], $args[$i+1]);
                }
            }
        return $tmp;
    }
    public function ToArray(){
        return $this->m_Storage;
    }
        public function get_array(){ return $this->ToArray(); }
    public function FromArray($row) {
        $row = array_change_key_case($row, CASE_LOWER);
        $keys = array_keys($row);
        for($i=0; $i<count($row);$i++) {
            $k = (is_int($keys[$i])) ? "k".$keys[$i] : $keys[$i];
            $this->m_Storage[$k] = $row[$i];
        }
    }
        public function set_array($row) { $this->FromArray($row); }
    public function FromObject($obj, $clear = false) {
        if ($clear)
            $this->Clear();
        $class_vars = get_object_vars($obj);
        foreach ($class_vars as $name => $value) {
            $this->Add($name, $value);
        }
        $this->m_Storage = array_change_key_case($this->m_Storage, CASE_LOWER);
    }
        public function from_object($obj, $clear = false) { $this->FromObject($obj, $clear); }
    public function ToObject(){
        $obj = new stdClass();
        foreach ($this->m_Storage as $k => $v)
            $obj->$k = $v;
        return $obj;
    }
        public function to_object(){ return $this->ToObject(); }    
    public function ToString($spl = ",", $kspl = ":", $key = ""){
        if (count($this->m_Storage) == 0 || is_empty($spl))
            return "";
        $ret = "";
        $i = 0;
        foreach ($this as $k => $v){
            switch (gettype($v)){
                case "object" :
                    $value = $v->$key;
                    break;
                default :
                    $value = $v;
            }
            $ret .= (($i == 0) ? "" : $spl).((is_empty($kspl)) ? "" : $k.$kspl).$value;
            $i++;
        }
        return $ret;
    }
    public function FromString($data, $spl = ",", $kspl = ":", $callback = ""){
        if (is_empty($data) || is_empty($spl) || is_empty($kspl))
            return $this->Clear();
        $value = '';
        $dt = explode($spl, $data);
        foreach ($dt as $t){
            $inf = explode($kspl, $t);
            $key = "";
            switch (count($inf)){
                case 0 :
                    return;
                case 1 :
                    $value = $inf[0];
                    break;
                case 2 :
                    $key = $inf[0];
                    $value = $inf[1];
                    break;
            }
            if (!is_empty($callback))
                $value = call_user_func($callback, $inf);
            $this->add((is_empty($key)) ? $this->NewKey() : $key, $value);
        }
    }
    public function FromXML($oXMLDoc) {
        $firstElement = $oXMLDoc->childNodes;
        $i = 0;
        foreach($firstElement as $pair) {
            $key = $pair->childNodes->item(0)->childNodes->item(0)->data;
            $value = $pair->childNodes->item(1)->childNodes->item(0);
            if($value != null) {
                if($value->nodeName == "collection") {
                    $v = new collection();
                    $v->FromXML($value);
                    $value = $v;
                }
                else {
                    $value = $value->data;
                }
            }
            $this->Add($key, $value);
        }
    }    
        public function from_xml($oXMLDoc) { $this->FromXML($oXMLDoc); }
}
?><?php
class Hashtable extends ListBase {
	public function __construct($data = null) {
		parent::__construct();
		switch (gettype($data)){
			case "array" :
				foreach($data as $k => $v)
					$this->Add($k, $v);
				break;
			case "object" :
				switch (to_lower(get_class($data))){
					case "collection" : case "arraylist" :
						foreach($data as $k => $v)
							$this->Add($k, $v);
						break;
					default : 
						$this->_data = $data;
						$this->_keys = array_keys(get_object_vars($data));
				}
				break;
			default : return;
		}
	}
	public static function Create() {
		$c = func_num_args();
		$args = func_get_args();
		if(count($args) == 0)
			return new Hashtable();
		if(is_array($args[0])) {
			$tmp = new Hashtable($args[0]);
		}
		else if(is_object($args[0])) {
				$tmp = new Hashtable($args[0]);
			}
			else {
				$tmp = new Hashtable();
				for($i=0; $i<$c; $i+=2) {
					$tmp->Add($args[$i], $args[$i+1]);
				}
			}
		return $tmp;
	}
	public function Data() {
		return $this->_data;
	}
	public function Append($list){
		foreach ($list as $k => $v)
			$this->Add($k, $v);
	}
	public function Part($expression) {
		$c = new Hashtable();
		foreach($this as $key => $value) {
			$e = "\$b = ".$expression.";";
			eval($e);
			if($b)
				$c->Add($key, $value);
		}
		return $c;
	}
	public function Search($value, $key = null){
		$ret = array();
		foreach ($this as $k => $v){
			switch (gettype($v)){
				case "object" :
					if (is_array($key)){
						foreach ($key as $kk)
							if ($v->$kk == $value)
								$ret[] = $v;
					} else {
						if ($key != null)
							if ($v->$key == $value)
								$ret[] = $v;
					}
					break;
				case "array":
					if (is_array($key)){
						foreach ($key as $kk)
							if ($v[$key] == $value)
								$ret[] = $v;
					} else {
						if ($key != null)
							if ($v[$key] == $value)
								$ret[] = $v;
					}
					break;
				default :
					if ($v == $value)
						$ret[] = $v;
					break;
			}
		}
		$count = count($ret);
		if ($count == 0)
			return;
		return ($count > 1) ? $ret : $ret[0];
	}	
	public function ToString($spl = ",", $kspl = ":", $key = ""){
		if ($this->Count() == 0 || is_empty($spl))
			return "";
		$ret = "";
		$i = 0;
		foreach ($this as $k => $v){
			switch (gettype($v)){
				case "object" :
					if(method_exists($v, "ToString")) {
						$value = $v->ToString();
					}
					else {
						if($key != "")
							$value = $v->$key;
						else 
							$value = get_class($v);
					}
					break;
				default :
					$value = $v;
			}
			$value = str_replace($kspl, "--0123456789--", $value);
			$value = str_replace($spl, "--9876543210--", $value);
			$ret .= ($i == 0 ? "" : $spl).((is_empty($kspl)) ? "" : $k.$kspl).$value;
			$i++;
		}
		return $ret;
	}
	public function FromString($data, $spl = ",", $kspl = ":", $callback = ""){
		if (is_empty($data) || is_empty($spl) || is_empty($kspl))
			return $this->Clear();
		$dt = explode($spl, $data);
		foreach ($dt as $t){
			$inf = explode($kspl, $t);
			$key = "";
			switch (count($inf)){
				case 0 :
					return;
				case 1 :
					$value = $inf[0];
					break;
				case 2 :
					$key = $inf[0];
					$value = $inf[1];
					break;
			}
			if(!is_empty($key)) {
				$value = str_replace("--0123456789--", $kspl, $value);
				$value = str_replace("--9876543210--", $spl, $value);
				if (!is_empty($callback))
					$value = call_user_func($callback, $inf);
				$this->add($key, $value);
			}
		}
	}
	public function NewKey($rel = -1){
		$p = ($rel == -1) ? $this->Count() : $rel;
		if ($this->Exists("k".$p))
			return $this->NewKey($p + 1);
		return "k".$p;
	}
	public function FromXML($oXMLDoc) {
	    $firstElement = $oXMLDoc->childNodes;
	    $i = 0;
	    foreach($firstElement as $pair) {
            $key = $pair->childNodes->item(0)->childNodes->item(0)->data;
            $value = $pair->childNodes->item(1)->childNodes->item(0);
            if($value != null) {
                if($value->nodeName == "hashtable") {
                    $v = new Hashtable();
                    $v->FromXML($value);
                    $value = $v;
                }
                else {
                    $value = $value->data;
                }
            }
            $this->Add($key, $value);
	    }
	}	
		public function from_xml($oXMLDoc) {
		$this->FromXML($oXMLDoc);
	}	
}
?><?php
class Property {
	public $name;
	public $type;
	public $description;
	public $value;
	public $defaultValue;
	public $set;
	public function __construct($name, $type, $description, $value, $defaultValue) {
		$this->name = $name;
		$this->type = $type;
		preg_match("/combo\((.*)\)/i", $this->type, $matches);
		if(count($matches) > 0) {
			$this->set = new Hashtable();
			$this->set->FromString($matches[1], ";", "|");
			$this->type = "combo";
		}
		$this->description = $description;
		$this->value = $value;
		$this->defaultValue = $defaultValue;
        if(is_null($this->value))
            $this->value = $this->defaultValue;
	}
}
class Properties extends Collection {
	function __construct($arr = array()) {
		parent::__construct($arr);
	}
	public function Add($prop, $key = null) {
		parent::Add(is_null($key) ? $prop->name : $key, $prop);
	}
	public function Delete($prop) {
		if($prop instanceof Property || $prop instanceof PropertyFolder)
			$prop = $prop->name;
		parent::Delete($prop);	
	}
	public function Merge($from) {
		trigger_error("You can't use this function", E_USER_ERROR);
	}
	public function Append($array1) {
		trigger_error("You can't use this function", E_USER_ERROR);
	}
	public function Dublicate() {
		trigger_error("You can't use this function", E_USER_ERROR);
	}
}
class FolderProperties extends Properties {
	protected $_propertiesList; 
	protected $_propertiesListO; 
	function __construct($sf) {
		$this->_propertiesList = $sf->tree_properties;
		$this->_propertiesListO = new Hashtable();
		if(!is_empty($this->_propertiesList)) {
			if($sf instanceof Folder) {
				$path = $sf->Path();
				$path->Delete($path->Count()-1);
				for($i=$path->Count()-1; $i >= 0; $i--) {
					$folder = $path->Item($i);
					$this->_propertiesList = str_replace("[inherit]", $folder->tree_properties, $this->_propertiesList);
				}
			}	
		}		
		$this->_propertiesListO->FromString($this->_propertiesList, "\n", ":");
        $arr = @_unserialize($sf->propertiesvalues);
        if(is_array($arr)){
             foreach($arr as $k=>$ar){
                 $brr = explode(',',$this->_propertiesListO->$k);
                 $arr[$k]->description = $brr[1];
             }
        }else        
            $arr = array();
        parent::__construct($arr);
		$this->_CheckProperties();
	}
	private function _CheckProperties() {
		$keys = $this->_propertiesListO->Keys();
		foreach($keys as $k) {
			if(!$this->Exists($k)) {
				$pp = explode(",", $this->_propertiesListO->$k);
				$p = new Property($k, $pp[0], $pp[1], null, @$pp[2]);
				$this->Add($p);
			}
		}
		$keys = $this->Keys();
		foreach($keys as $k) {
			if(!$this->_propertiesListO->Exists($k)) {
				$this->Delete($k);
			}
		}
	}
}
class PublicationProperties extends Properties {
	protected $_propertiesList; 
	protected $_propertiesListO; 
	public $combined = false;
	function __construct($pub, $t = null) {
		if(!is_null($t))
			$template = $t;
		else
			$template = $pub->getTemplate();
		if($template->composite == 1) {
			$this->combined = true;
			$arr = unserialize($pub->link_properties);
			if(!$arr)
				$arr = null;
			if(!is_array($arr)) {
				parent::__construct();
				$subtemplates = $template->SubTemplates();
				foreach($subtemplates as $k => $subs) {
					$this->Add(new PropertyFolder($subs->name, $pub, $subs), $k);
				}
			}
			else {
				parent::__construct($arr);	
				$subtemplates = $template->SubTemplates();
				$this->_propertiesList = new Hashtable();
				foreach($subtemplates as $k => $st) {
					$this->_propertiesList->Add($k, @$subtemplates->$k->properties);
				}
				$this->_propertiesListO = new Hashtable();
				foreach($subtemplates as $k => $st) {
					$this->_propertiesListO->Add($k, new Hashtable());
					$this->_propertiesListO->$k->FromString($this->_propertiesList->$k, "\n", ":");
				}
				$this->_CheckProperties();
			}
		}
		else {
			$this->_propertiesList = $template->properties;
			$arr = unserialize($pub->link_properties);
			if(!is_array($arr))
				$arr = array();
			parent::__construct($arr);
			$this->_propertiesListO = new Hashtable();
			$this->_propertiesListO->FromString($this->_propertiesList, "\n", ":");
			$this->_CheckProperties();
		}		
	}
	private function _CheckProperties() {
		if($this->combined) {
			$kkkkk = $this->_propertiesListO->Keys();
			foreach($kkkkk as $kkk) {
				$tttt = $this->_propertiesListO->$kkk;
				$ttttlist = $this->$kkk ? $this->$kkk : new Collection();
				$keys = $tttt->Keys();
				foreach($keys as $k) {
					if(!$ttttlist->Exists($k)) {
						$pp = explode(",", $tttt->$k);
						$p = new Property($k, $pp[0], $pp[1], null, @$pp[2]);
						$ttttlist->Add($k, $p);
					}
				}
				$keys = $ttttlist->Keys();
				foreach($keys as $k) {
					if(!$tttt->Exists($k)) {
						$ttttlist->Delete($k);
					}
				}			
			}
		}
		else {
			$keys = $this->_propertiesListO->Keys();
			foreach($keys as $k) {
				if(!$this->Exists($k)) {
					$pp = explode(",", $this->_propertiesListO->$k);
					$p = new Property($k, $pp[0], $pp[1], null, @$pp[2]);
					$this->Add($p);
				}
			}
			$keys = $this->Keys();
			foreach($keys as $k) {
				if(!$this->_propertiesListO->Exists($k)) {
					$this->Delete($k);
				}
			}
		}	
	}
}
class PropertyFolder extends PublicationProperties {
    public $name;
    public function __construct($name, $pub, $t) {
        $this->name = $name;
        parent::__construct($pub, $t);
    }
}
?><?
?><?
    class CModule extends IEventDispatcher {
        protected $_data;
        protected $_icons;
        protected $_prefix;
        protected $_datascheme;
        function CModule($ini, $version = "") {             global $core;
            if (is_empty($ini)){
                $this->_data = new collection();
                return;
            }
            $this->ConstructorInitialize($ini, $version);
            $this->_prefix = strtolower($this->entry);
        }
        function __get($key){
            if (!($this->_data instanceof collection))
                return;
            switch (strtolower($key)){
                case "prefix" :
                    return $this->_prefix;
                case "admincompat" :
                    if (!($this->_data->module_admincompat instanceof arraylist))
                        $this->loadAdminCompat();
                    return $this->_data->module_admincompat;
                case "compat" :
                    if (!($this->_data->module_compat instanceof arraylist))
                        $this->loadCompat();
                    return $this->_data->module_compat;
                case "libraries" :
                    if (!($this->_data->module_libraries instanceof arraylist))
                        $this->loadLibraries();
                    return $this->_data->module_libraries;
                case "storages" :
                    if (!($this->_data->module_storages instanceof arraylist))
                        $this->loadStorages();
                    return $this->_data->module_storages;
                case "templates" :
                    if (!($this->_data->module_templates instanceof Templates))
                        $this->loadTemplates();
                    return $this->_data->module_templates;
                case "icons" :
                    if(!($this->_icons instanceof IconPack))
                        $this->_icons = new IconPack($this->_data->module_iconpack);
                    return $this->_icons;
                case 'datascheme':
                    return $this->_datascheme;
                default :
                    $name = $this->fname($key);
                    if (!$this->_data->exists($name))
                        return $this->getProperty($key);
                    return $this->_data->$name;
            }
        }
        function __set($key, $value){
            if ($key == "compat" || $key == "storages" || $key == "libraries" 
                || $key == "templates" || !($this->_data instanceof collection))
                return;
            $name = $this->fname($key);
            if (!$this->_data->exists($name)){
                $this->setProperty($key, $value);
                return;
            }
            $this->_data->$name = $value;
        }
        public function Initialize(){
            global $core;
            $this->_datascheme = new PioneerScheme($core->dbe);
        }
        public function ConstructorInitialize($ini, $version = ""){
            if (!is_object($ini)){
                if (intval($ini) == -1)
                    $this->createSchema();
                else
                    $this->load($ini, $version);
            } else {
                $this->load($ini, $version);
            }
        }
        public function Create($order, $state, $entry, $title, $description, $version, $admincompat, $compat, $code, $storages, $libraries, $type, $haseditor, $publicated, $favorite, $iconpackname) {
            $mod = new CModule(-1);
            $mod->publicated = $publicated;
            $mod->favorite = $favorite;
            $mod->haseditor = $haseditor;
            $mod->type = $type;
            $mod->entry = $entry;
            $mod->title = $title;
            $mod->description = $description;
            $mod->version = $version;
            $mod->code = $code;
            $mod->iconpack = $iconpackname;
            $mod->admincompat->Clear();
            $mod->compat->Clear();
            $mod->libraries->Clear();
            $mod->storages->Clear();
            $mod->admincompat->FromString($admincompat);
            $mod->compat->FromString($compat);
            $mod->libraries->FromString($libraries);
            $mod->storages->FromString($storages);
            $mod->Save();            
            return $mod;
        }
        public function IsValid(){
            return $this->_data->Count() > 0;
        }
        public function GetData($raw = true){
            if (!($this->_data instanceof collection))
                return;
            $this->admincompat;
            $this->compat;
            $this->libraries;
            $this->storages;
            if ($raw)
                return clone $this->_data;
            $data = clone $this->_data;
            $data->module_admincompat = $data->module_admincompat->ToString();
            $data->module_compat = $data->module_compat->ToString();
            $data->module_libraries = $data->module_libraries->ToString();
            $data->module_storages = $data->module_storages->ToString();
            return $data;
        }
        public function Out($template = TEMPLATE_DEFAULT, $user_params = null, $operation = OPERATION_LIST){
            if ($this->_data->module_state != MODULE_ENABLED)
                return "";
            $t = template::create($template, $this);
            return $t->Out($operation, $this, $user_params);
        }
        public function Publications(){
            global $core;
            $r = $core->dbe->ExecuteReader("
                select * from sys_links 
                    where link_child_storage_id = ".$this->_data->module_id." and link_object_type = 1 
                    order by link_order
            ");
            if (!$r)
                return;
            $c = new collection();
            while($rr = $r->Read())
                $c->add("p".$rr->link_id, new Publication($rr, $this));
            return $c;
        }
        public function ToXML($exportdata = false, $update_info = null, $head = ""){
            $ret = "<module>";
            if (!is_empty($update_info)){
                $ret .= "<update><version>".$update_info."</version></update>";
            }
            if (!is_empty($head))
                $ret .= $head;
            $this->templates;
            $this->libraries;
            $this->storages;
            $this->compat;
            $this->admincompat;
            $pt = $this->templates;
            $rep = new repository();
            $st = new storages();
            foreach ($this->_data as $k => $v){
                switch ($k){
                    case "module_libraries" :
                        $ret .= $rep->ToXML($this->libraries->get_array());
                        break;
                    case "module_storages" :
                        $ret .= $st->ToXML($this->storages->get_array());
                        break;
                    case "module_templates" :
                                                $ret .= $pt->ToXML();
                        break;
                    case "module_compat" :
                        $ret .= "<compat>".$this->compat->ToXML()."</compat>";
                        break;
                    case "module_admincompat" :
                        $ret .= "<admincompat>".$this->admincompat->ToXML()."</admincompat>";
                        break;
                    case "module_code" :
                        if (substr(trim($v), 0, 9) == "LOADFILE:"){
                            global $core;
                                                        $v = $core->fs->readfile(substr(trim($v), 9, strlen(trim($v))), SITE);
                        }
                        $prop = $this->fromfname($k);
                        $ret .= "<".$prop."><![CDATA[".$v."]]></".$prop.">";
                        break;
                    case "module_iconpack" :
                        $ret .= "<resources>".$this->icons->ToXML()."</resources>";
                        break;
                    default :
                        $prop = $this->fromfname($k);
                        $ret .= "<".$prop.">".$v."</".$prop.">";
                }
            }
            if ($exportdata && $this->storages->Count() > 0){
                $ret .= "<data>";
                foreach ($this->storages as $storage){
                    $s = storages::get($storage);
                    $drs = new DataRows($s);
                    $drs->Load();
                    $ret .= $drs->to_xml();
                }
                $ret .= "</data>";
            }
            $ret .= "</module>";
            return $ret;
        }
        public function to_xml($exportdata = false, $update_info = null, $head = ""){
            return $this->ToXML($exportdata, $update_info, $head);
        }
        public function FromXML($el){
            $vls = array(); $dataNode = null; $tplNode = null;
            $rep = new Repository();
            $stgs = new storages();
            $pt = new Templates(null, TEMPLATE_MODULE);
            $childs = $el->childNodes;
            foreach ($childs as $pair){
                switch ($pair->nodeName){
                    case "repository" :
                        $rep->FromXML($pair);
                        foreach($rep as $l)
                            $this->libraries->Add($l->name);
                                                break;
                    case "storages" :
                                                $stgs->FromXML($pair);
                        foreach ($stgs as $s)
                            $this->storages->Add($s->table);
                                                                        break;
                    case "templates" :
                        $pt->FromXML($pair);
                        break;
                    case "compat" :
                        $a = new arraylist();
                        $a->FromXML($pair->childNodes->item(0));
                        $this->compat->Append($a);
                                                break;
                    case "admincompat" :
                        $a = new arraylist();
                        $a->FromXML($pair->childNodes->item(0));
                        $this->admincompat->Append($a);
                                                break;
                    case "data" :
                        $dataNode = $pair;
                        break;
                    case "order" :
                    case "state" :
                        break;
                    case "resources" :
                        if($pair->childNodes->length > 0)
                            if($pair->childNodes->item(0)->childNodes->length > 0)
                                $this->icons->FromXML($pair->childNodes->item(0));        
                        break;
                    default :
                        $name = $this->fname($pair->nodeName);
                        if (!$this->_data->exists($name))
                            continue;
                        $this->_data->$name = $pair->nodeValue;
                        if ($name != "module_id" && $name != "module_order" && $name != "module_state")
                            $vls[] = $name." = '".addslashes($this->_data->$name)."'";
                        break;
                }
            }
            $this->id = -1;
            global $core;
            $this->Save();
            iout($this);
            exit;
            foreach($pt as $t) {
                $t->module_id = $this->id;
                $this->templates->Add($t);
            }
            $pt->Save();
            $rep->Save();
            $stgs->Save();
            if ($dataNode){
                $childs = $dataNode->childNodes;
                foreach ($childs as $pair){
                    $stname = $pair->getAttribute("storage");
                    if (is_empty($stname))
                        continue;
                    $st = storages::get($stname);
                    $drs = new DataRows($st);
                    $drs->from_xml($pair);
                }
            }
        }
        public function from_xml($el){
            $this->FromXML($el);
        }
        protected function fname($field, $table = ""){
            $table = (is_empty($table)) ? "module" : $this->tname($table);
            return $table."_".$field;
        }
        protected function tname($table){
            return "module_".$this->_prefix."_".$table;
        }
        protected function fromfname($field, $table = ""){
            $sub = (is_empty($table)) ? "module_" : $this->tname($table)."_";
            if (strpos($field, $sub) === false)
                return $table;
            return substr($field, strlen($sub));
        }
        protected function fromtname($table){
            $sub = "module_".$this->_prefix."_";
            if (strpos($table, $sub) === false)
                return $table;
            return substr($table, strlen($sub));
        }
        private function createSchema(){
            $this->_data = new collection();
            $this->_data->add("module_id", -1);
            $this->_data->add("module_order", 0);
            $this->_data->add("module_state", 0);             $this->_data->add("module_entry", "");
            $this->_data->add("module_title", "");
            $this->_data->add("module_description", "");
            $this->_data->add("module_version", "");
            $this->_data->add("module_code", "");
            $this->_data->add("module_type", 0);
            $this->_data->add("module_favorite", 0);
            $this->_data->add("module_haseditor", 0);
            $this->_data->add("module_publicated", 0);
            $this->_data->add("module_iconpack", 0);
        }
        private function loadAdminCompat(){
            $t = $this->_data->module_admincompat;
            $this->_data->module_admincompat = new arraylist();
            $this->_data->module_admincompat->FromString($t);
        }
        private function loadCompat(){
            $t = $this->_data->module_compat;
            $this->_data->module_compat = new arraylist();
            $this->_data->module_compat->FromString($t);
        }
        private function loadStorages(){
            $t = $this->_data->module_storages;
            $this->_data->module_storages = new arraylist();
            $this->_data->module_storages->FromString($t);
                    }
        private function loadLibraries(){
            $t = $this->_data->module_libraries;
            $this->_data->module_libraries = new arraylist();
            $this->_data->module_libraries->FromString($t);
                    }
        private function loadTemplates(){
            $this->_data->add("module_templates", new Templates($this, TEMPLATE_MODULE));
        }
        private function load($ini, $version = "") {
            global $core;
            if (is_object($ini)){
                if ($ini instanceof CModule){
                    $this->_data = $ini->GetData();
                    return;
                }
                if ($ini instanceof collection){
                    if (!is_empty($ini->module_id))
                        $this->_data = $ini;
                } else if (!is_empty($ini->module_id)) { 
                    $this->_data = Collection::Create($ini instanceOf Object ? $ini->Data() : $ini);
                }
                return;
            }
            if (is_numeric($ini))
                $ex = "module_id = ".$ini;
            else if (is_string($ini))
                $ex = is_empty($version) 
                    ? "module_entry = '".$ini."' ORDER BY module_version DESC LIMIT 1"
                    : "module_entry = '".$ini."' AND module_version = '".$version."' LIMIT 1";
            else
                return;
            $rs = $core->dbe->ExecuteReader("SELECT * FROM ".CModuleManager::SYS_TABLE." WHERE ".$ex, "module_id");
            if (!$rs->HasRows())
                return false;
            $data = $rs->Read();
                        $data->module_code = $data->module_code;
                        $t = $data->module_compat;
            $data->module_compat = new arraylist();
            $data->module_compat->FromString($t);
                        $t = $data->module_libraries;
            $data->module_libraries = new arraylist();
            $data->module_libraries->FromString($t);
                        $t = $data->module_storages;
            $data->module_storages = new arraylist();
            $data->module_storages->FromString($t);
            $this->_data = $data->ToCollection();
        }
        public function Loaded() {
        }
        public function Save(){
            if ($this->_data instanceof collection)
                CModuleManager::Save($this);
        }
        public function Delete(){
            if ($this->_data instanceof collection)
                CModuleManager::Delete($this);
        }
        public function GetBlock($name){
        }
        public function Install(){ 
        }
        public function Uninstall(){ 
        }
        public function RegisterEvents(){
        }
        public function RegisterEventHandlers(){
        }
        protected function Render($args = null){
        }
        protected function getProperty($key){
            return;
        }
        protected function setProperty($key, $value){
            return;
        }
        public function ToPHPScript() {
            $ret = '/* Dumping module '.$this->table.' */'."\n";
            $storages = ''; foreach($this->storages as $s) $storages .= ','.$s->table; $storages = substr($storages, 1); 
            $libraries = ''; foreach($this->libraries as $l) $libraries .= ','.$l->name; $libraries = substr($libraries, 1); 
            $ret = '
                $bkeepid = '.$this->id.';
                $module'.$this->entry.' = $core->mm->activemodules->Item("'.$this->entry.'");
                if(!is_null($module'.$this->entry.')) $module'.$this->entry.'->Delete();
                $module'.$this->entry.' = CModule::Create('.$this->order.', '.$this->state.', "'.$this->entry.'", "'.$this->title.'", "'.$this->description.'", "'.$this->version.'", "'.$this->admincompat->ToString().'", "'.$this->compat->ToString().'", hex2bin("'.bin2hex(load_from_file($this->code)).'"), "'.$storages.'", "'.$libraries.'", "'.$this->type.'", '.($this->haseditor ? 1 : 0).', '.($this->publicated ? 1 : 0).', '.($this->favorite ? 1 : 0).', "'.$this->_data->iconpack.'");
                $core->dbe->Update("sys_modules", "module_id", $module'.$this->entry.'->id, Collection::Create("module_id", $bkeepid), true);
                $module'.$this->entry.' = $core->mm->CreateInstance($bkeepid);
                $module'.$this->entry.'->Install();
                '.$this->templates->ToPHPScript('$module'.$this->entry).'
                ';
            return $ret;
        }
    }
?>
<?
	class CModuleManager {
		private static $_instance;
		private $_modules;
		public static $types = array("Системный", "Пользовательский");
		const SYS_TABLE = "sys_modules";
		const SYS_TABLE_ID = "module_id";
		private function CModuleManager(){
		}
        public function Dispose() {
            $this->_modules->Clear();
        }
		function __get($key){
			switch ($key){
				case "activemodules" :
					return clone $this->_modules;
				case "modules" : 
					return CModuleManager::Enum("", "", false);
				default :
			}
		}
		function __set($key, $value){
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
		public function RegisterEvents(){
		}
		public function RegisterEventHandlers(){
		}
		public function Initialize(){
			$this->_modules = new collection();
			global $core;
			$ex = $core->isAdmin ? "" : " and module_type = '1'";
			$modules = CModuleManager::Enum("module_state = '".MODULE_ENABLED."' or module_state = '".MODULE_CREATED."'".$ex);
						if (!$modules)
				return;
			while ($mod = $modules->FetchNext()){
				$inst = $this->CreateInstance($mod);
				if (!($inst instanceof CModule))
					continue;
				$this->_modules->Add($inst->entry, $inst);
				if (method_exists($inst, "RegisterEvents"))
					$inst->RegisterEvents();
				if (method_exists($inst, "RegisterEventHandlers"))
					$inst->RegisterEventHandlers();
				$libs = $inst->libraries;
				foreach ($libs as $l){
					$lib = new Library($l);
					$lib->Run();
				}
				$inst->Initialize();
			}
		}
		public function GetData(){
			return clone $this->_modules;
		}
				public static function NewModule(){
			return new CModule(-1);
		}
				public static function Save($mod){
			if (is_empty($mod))
				return;
			global $core;
			if (!($mod instanceof CModule))
				$mod = new CModule($mod);
			$id = $mod->id;
			$data = $mod->GetData(false);
			if (!$data)
				return;
			if ($id == -1){
				$rs = $core->dbe->ExecuteReader("select module_order from ".self::SYS_TABLE." order by module_order DESC limit 1");
				if ($rs->Count() > 0)
					$data->module_order = $rs->Read()->module_order + 1;
				$mod->order = $data->module_order;
				$data->delete("module_id");
				$id = $core->dbe->insert(self::SYS_TABLE, $data);
				if ($id)
					$mod->id = $id;
			} else
				$core->dbe->set(self::SYS_TABLE, self::SYS_TABLE_ID, $id, $data);
		}
				public static function Delete($ini, $version = ""){
			global $core;
			$mod = ($ini instanceof CModule) ? $ini : new CModule($ini, $version);
			if (!$mod->IsValid())
				return;
			if ($mod->templates->Count() > 0){
				$tpls = $mod->templates;
				foreach ($tpls as $t){
					$t->Delete();
				}
			}
			if ($mod->libraries->Count() > 0){
				$libs = $mod->libraries;
				foreach ($libs as $l) {
					$lib = new Library($l);
					$lib->Delete();
				}
			}
			if ($mod->storages->Count() > 0){
				$st = new storages();
				foreach ($mod->storages as $s) {
					$ss = new Storage($s);
					$ss->Delete();
				}
			}
			$pubs = $mod->Publications();
			if ($pubs)
				foreach ($pubs as $pub)
					$pub->Discard();
			$res = $core->dbe->delete(self::SYS_TABLE, self::SYS_TABLE_ID, $mod->id);
		}
				public static function NewOrder(){
			global $core;
			$rs = $core->dbe->ExecuteReader("select module_order from ".self::SYS_TABLE." order by module_order DESC limit 2");
			if ($rs->Count() < 2)
				return 0;
			$al = $rs->ReadAll();
			$max = $al->Item(0)->module_order;
			$min = $al->Item(1)->module_order;
			return $max + abs($min - $max);
		}
		public function CreateInstance($ini){
			if (is_empty($ini))
				return;
			global $core;
			$mod = new CModule($ini);
			if (!$mod->IsValid())
				return;
			$inst = null;
			if ($this->_modules)
				foreach ($this->_modules as $item)
					if ($item->id == $mod->id)
						return $item;
			$inst = null;
			$code = load_from_file($mod->code);
            $context = new OutputContext($mod->entry);
			$code = convert_php_context($code);
            eval($code);    
			$iname = $mod->entry;
			if(!class_exists($iname))
				return;
			$inst = new $iname();
			$inst->ConstructorInitialize($mod);
            $inst->Initialize();
			if ($inst->state == MODULE_CREATED){
				$inst->Install();
				$inst->state = MODULE_ENABLED; 				$inst->Save();
			}
			return $inst;
		}
		public static function Uninstall($ini){
			global $core;
			try {
												$inst = $core->mm->CreateInstance($ini);
				if (!$inst)
					return;
				$inst->Uninstall();
				CModuleManager::Delete($inst);
			} catch (exception $ex){
							}
		}
		public static function Enum($condition = "", $order = "", $raw = true){
			global $core;
			$res = $core->dbe->ExecuteReader("SELECT * FROM ".self::SYS_TABLE."".
				((!is_empty($condition)) ? " WHERE ".$condition : "").
				" ORDER BY module_order".((!is_empty($order)) ? ", ".$order : ""), 
				self::SYS_TABLE_ID);
			if (!$res->HasRows())
				return;
			if ($raw)
				return $res;
			$m = new Collection();
			while ($item = $res->Read())
				$m->add($item->module_entry, new CModule($item));
			return $m;
		}
        public static function getOperations() {
            $operaions = new Operations();
            $modules = CModuleManager::Instance()->activemodules;
            foreach($modules as $module) {
                if(method_exists($module, "getOperations"))
                    $operaions->Merge($module->getOperations());
            }
            return $operaions;
        }
        public function ToPHPScript() {
            $ret = '/* Dumping modules */'."\n\n"; 
            foreach($this->activemodules as $module) {
                $ret .= $module->ToPhpScript();
            }
            return $ret;
        }
	}
?>
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
?><?
class Recordset extends Collection {
	private $position;
	public $fields;
	public $resource;
	private $fetched_count;
	private $identity;
    public $affected = -1;
	public function __construct($r, $identity = "") {
		parent::__construct();
		global $core;
		$this->position = -1;
		$this->fields = array();
		$this->resource = $r;
		$this->fetched_count = 0;
		$this->identity = $identity;
		if($this->is_resource()) {
			$nf = $core->dbe->num_fields($this->resource);
			for($i=0; $i < $nf; $i++) {
				$f = $core->dbe->fetch_field($this->resource, $i);
				$this->fields[$f->name] = $f;
			}
			$this->fields = array_change_key_case($this->fields, CASE_LOWER);
		}
	}
    public function Dispose() {
        if($this->is_resource()) {
            global $core;
            $core->dbe->free_result($this->resource);
            unset($this->resource);
        }
    }
	public function __destruct() {
        $this->Dispose();
        parent::Dispose();
	}
	public function is_resource() {
		return isset($this->resource) && gettype($this->resource) == "resource";
	}
	public function Count() {
		global $core;
		if($this->connected()) {
			if($this->is_resource())
				return $core->dbe->num_rows($this->resource);
			else
				return 0;
		}
		else
			return count($this->get_array());
	}
	public function Connected() {
		return isset($this->resource);
	}
	public function Disconnect($copy = true, $page = -1, $pagesize = -1) {
		global $core;
		if(!$this->connected()) return false;
		if($copy && $this->is_resource()) {
            $paged = $page > 0 && $pagesize > 0;
            if($paged) {
                $i = 1;
                if($page > 1) {
                    while($retorno = $core->dbe->fetch_object($this->resource)) {
                        if($i >= ($page-1)*$pagesize)
                            break;
                        $i++;
                    }
                }
            }
            $i=0;
			while ($retorno = $core->dbe->fetch_object($this->resource)) {
				$ident = $this->identity;
				if(empty($ident))
					$ident = parent::count()+1;
				else
					$ident = $retorno->$ident;
				parent::add("row".$ident, $retorno);
                $i++;
                if($paged) {
                    if($i >= $pagesize)
                        break;
                }
			}
		}
		$this->Dispose();
		return true;
	}
    public function CopyFrom($r) {
		$this->fields = $r->fields;
		$this->append($r->get_array());
	}
	public function __get($col)
	{
		if($this->bof()) {
			$this->FetchNext();
		}
		if($this->eof()) {
			die ("Recordset is EOF");
		}
		$r = $this->item($this->position);
		if (isset($r->$col))
			return $r->$col;
		else
			return NULL;
	}
	public function __set($col, $val) {
		if($this->bof()) {
			$this->FetchNext();
		}
		if($this->eof()) {
			die ("Recordset is EOF");
		}
		$r = $this->item($this->position);
		$r->$col = $val;
	}
	public function Exists($k) {
		if(is_string($k))
			$k = strtolower($k);
		$k = "row".$k;
		return parent::exists($k);
	}
	public function Bof() {
		return $this->position < 0;
	}
	public function Eof() {
		return (boolean)($this->position > $this->count());
	}
	public function Rewind(){
		$this->position = -1;
	}
	public function Fetch($i) {
		global $core;
		if(is_string($i))
			$p = parent::_getindex("row".$i);
		else
			$p = $i;
		$ip = $this->position;
		if($i < $p && $this->is_resource()) {
			while ($retorno = $core->dbe->fetch_object($this->resource)) {
				$ident = $this->identity;
				if(empty($ident))
					$ident = parent::count()+1;
				else
					$ident = $retorno->$ident;
				parent::add("row".$ident, $retorno);
				if(++$ip<=$p)
					break;
			}
		}
		$this->position = $p;
		return $this->item($this->position);
	}
	public function FetchNext() {
		global $core;
		$this->position++;
		if($this->is_resource()) {
			if ($retorno = $core->dbe->fetch_object($this->resource)) {
				$ident = $this->identity;
				if(empty($ident))
					$ident = parent::count()+1;
				else
					$ident = $retorno->$ident;
				parent::add("row".$ident, $retorno);
			}
			else
				$this->disconnect(false);
		}
		if( $this->key($this->position) )
			return $this->item($this->position);
		else
			return false;
	}
	public function fetch_next() {
        deprecate();
		return $this->FetchNext();
	}
	public function Item($k) {
		if(gettype($k) == "integer") {
			$k = parent::Key($k);
			return parent::Item($k);
		}
		else {
			return parent::Item("row".$k);
		}
	}
	function CopyTo(&$arg, $idd = null) {
		while($row = $this->FetchNext()) {
			if ($idd == null)
				$arg->add($row);
			else
				$arg->add($row->$idd, $row);
		}
	}
	function FetchAll($idfield = "", $k_ex = ""){
		$tmp = ($idfield == "") ? new arraylist() : new collection();
		while($row = $this->FetchNext())
			if ($idfield == "")
				$tmp->add($row);
			else
				$tmp->add($k_ex.$row->{$idfield}, $row);
		return $tmp;
	}
}
?><?
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
        public function FetchNext($asclass = '') {
            return $this->Read($asclass);
        }
    }
?>
<?
function sys_table($t){
	return SYSTABLE_PREFIX."_".$t;
}
class DBEngine {
	private $mIDENTITYCOL;
	private $_tables;
	private $_tablefields;
    private $_driver;   
    private $_scheme;
	public function DBEngine($driver) {
        $this->mIDENTITYCOL = "Id";
        $this->_driver = $driver;
        $this->_scheme = new PioneerScheme($this);
	}
	public function __destruct() {
				$this->_driver->Disconnect();
	}
	public function Initialize(){
	}
	public function __get($prop) {
		switch($prop) {
            case "driver":
                return $this->_driver;
			case "queried":
				return $this->_driver->queryCache;
			case "cached":
				return $this->_driver->resourceCache;
            case "scheme":
                return $this->_scheme;
		}
	}
	public function connect($server, $database, $user, $password, $persistence = true) {
        $this->_driver->Connect($server, $database, $user, $password, $persistence);
        $this->CreateDefaultSchema();
	}
	public function disconnect() {
		$this->_driver->Disconnect();
	}
	public function fetch_object($r) {
		return $this->_driver->fetch_object($r);
	}
	public function fetch_array($r) {
		return $this->_driver->fetch_array($r);
	}
	public function fetch_field($r, $i) {
		return $this->_driver->fetch_field($r, $i);
	}
	public function num_rows($r) {
		return $this->_driver->num_rows($r);
	}
	public function num_fields($r) {
		return $this->_driver->num_fields($r);
	}
    public function free_result($r) {
        return $this->_driver->free_result($r);
    }
	public function Query($q) {
        return $this->_driver->Query($q);
	}
	public function InsertId($query = false) {
		return $this->_driver->insert_id();
	}
	public function Affected($res = null){
		return $this->_driver->affected($res);
	}
	public function Error() {
		return $this->_driver->Error();
	}
    public function RecordCount($query) {
        $cntQuery = $this->_driver->CreateCountQuery($query);
        $r = $this->_driver->Query($cntQuery);
        $rr = $this->_driver->fetch_object($r);
        return $rr->cnt;
    }
	public function QueryPage($q, $identity = "", $page, $pagesize) {
		$affected = $this->RecordCount($q);
        $q = $this->_driver->AppendLimitCondition($q, $page, $pagesize);
		$recordset = $this->Execute($q, $identity, false);
		$recordset->affected = $affected;
		return $recordset;
	}
    public function AppendLimitCondition($q, $page, $pagesize) {
        return $this->_driver->AppendLimitCondition($q, $page, $pagesize);
    }
    public function ExecuteReader($q, $page = -1, $pagesize = 10) {
        if($page > 0) {
            $affected = $this->RecordCount($q);
            $q = $this->_driver->AppendLimitCondition($q, $page, $pagesize);
            $reader = new DataReader($this->Query($q), $this->_driver);
            $reader->affected = $affected;
        }
        else {
            $reader = new DataReader($this->Query($q), $this->_driver);
        }
        return $reader;
    }
	public function Execute($q, $identity = "", $noreturn = false) {
		if(!$noreturn) {
			$tmp = new Recordset($this->Query($q), $identity) or die("Could not execute a query : ".$this->error());
			$tmp->affected = $tmp->Count();
			return $tmp;
		}
		else {
			$ret = $this->query($q);
			if(!$ret)
				return false;
			else
				return true;
		}
	}
	public function Get($table, $field, $idfield, $id) {
		if(!is_array($field)) {
			if(is_integer($id))
				$q = "select $field from $table where $idfield=$id";
			else
				$q = "select $field from $table where $idfield='$id'";
		}
		else {
			$qs = "select ";
			$qe = " from $table where $idfield='$id'";
			for($i=0; $i<count($field); $i++) {
				$q = $q. $fields[$i] . " ,";
			}
			$q = substr($q, 0, strlen($q)-1);
			$q = $qs.$q.$qe;
		}
		$tmp = $this->query($q);
		if($tmp) {
			$res = $this->fetch_object($tmp);
			if(!is_array($field) && $field != "*"){
				return $res->$field;
			} else {
				return $res;
			}
		}
		else
			return false;
	}
	public function Set($table, $idfield, $id, $data) {
		return $this->Update($table, $idfield, $id, $data);
	}
	public function Update($table, $idfield, $id, $data, $setautoincrement = false) {   		if (is_array($id)){
			$qe = "where $idfield in ('".implode("', '", $id)."')";
		} else {
			$qe = "where $idfield='$id'";
		}
		$qs = "update $table set ";
        $fields = $this->Fields($table);
		$sql_set = '';
		$dt = $data;
		foreach($dt as $k=>$v) {
			if(is_null($v))
				$sql_set .= ','.$this->_driver->EscapeFieldNames($k).'=null';				
			else
				$sql_set .= ','.$this->_driver->EscapeFieldNames($k).'='.$this->_driver->EscapeFieldValue($fields->$k, $v);
		}
		$sql_set=substr($sql_set, 1);
		$sql_set = $qs." ".$sql_set." ".$qe;
		$ret = ($this->query($sql_set) !== false);
        if($setautoincrement) {
            $this->_driver->SetAutoincrement($table, $idfield);
        }
        return $ret;
	}
    public function SetAutoincrement($table, $idfield) {
        return $this->_driver->SetAutoincrement($table, $idfield);
    }
	public function SetBin($table, $idfield, $id, $field, $value) {
        return $this->_driver->UpdateBinaryField($table, $idfield, $id, $field, $value);
	}
	public function Delete($table, $idfield, $id) {
		$q = "delete from ".$table." where ".$idfield."='".$id."'";
		return ($this->query($q) !== false);
	}
	public function Insert($table, $data = null) {
		if($data != null) {
			$fld_names = "";
			$fld_values = "";
			if($data != null) {  
                $fields = $this->Fields($table);
            	$fld_names = implode(',', $data->keys());
				foreach($data as $k => $v) {
                    $fld_values .= ','.$this->_driver->EscapeFieldValue($fields->$k, $v);
				}
				$fld_values = substr($fld_values, 1);
			}
			$q = "insert into ".$table."(".$this->_driver->EscapeFieldNames($fld_names).") values(".$fld_values.")";
		}
		else
			$q = "insert into ".$table." default values";
		$tmp = $this->query($q);
		if($tmp !== false)
			return $this->_driver->insert_id($table);
		else {
			return false;
		}
	}
	public function Exists($table, $field, $value) {
		if(is_numeric($value))
			$rs = $this->query("SELECT count(*) as c FROM ".$table." WHERE (".$field." = ".$value.")");
		else
			$rs = $this->query("SELECT count(*) as c FROM ".$table." WHERE (".$field." = '".$value."')");
		$r = $this->fetch_object($rs);
		return ($r->c > 0);
	}
	public function TableExists($table, $recache = false) {
		return $this->Tables($recache)->Exists($table);
	}
	public function TableEmpty($table) {
		global $core;
		$rs = $this->query("select count(*) as size from ".$table."");
		$r = $this->fetch_object($rs);
		return (intval($r->size) == 0);
	}
    public function CountRows($table) {
        return $this->_driver->CountRows($table);
    }
    public function TruncateTable($table) {
        return $this->_driver->TruncateTable($table);
    }
	function Max($table, $field) {
		$rs = $this->query("select max(".$field.") as m from ".$table);
		$r = $this->fetch_object($rs);
		return $r->m;
	}
	function CompleteTrans() {
		$this->Query("COMMIT");
	}
	function FailTrans() {
		$this->Query("ROLLBACK");
	}
	function StartTrans() {
		$this->Query("START TRANSACTION");
	}
	public function Tables($recache = false) {
        if(is_null($this->_tables))
            $this->_tables = new Hashtable();
        if($this->_tables->Count() == 0 || $recache) {
            $tables = $this->_driver->ListTables();
		    while($r = $this->_driver->fetch_object($tables)) {
                $name = "Tables_in_".$this->_driver->database;
                $value = @$r->$name;
                if(!$value) {
                    $name = strtolower($name);
                    $value = @$r->$name;
                }
			    $this->_tables->Add($value, $value);
		    }
        }
		return $this->_tables;
	}
	public function Fields($table, $recache = false) {
		if(!$this->_tablefields)
			$this->_tablefields = new Collection();
		if($this->_tablefields->Exists($table) && !$recache)
			return $this->_tablefields->Item($table);
		$ret = new collection();
		$r = $this->_driver->ListFields($table);
		while($rr = $this->fetch_array($r)) {
			$field = new Collection($rr);
			$ret->add($field->field, $field);
		}
		$this->_tablefields->Add($table, $ret);
		return $ret;
	}
	public function AddField($table, $column, $type, $null = true, $default = null) {
        return $this->_driver->AddField($table, $column, $type, $null, $default);
	}
	public function AlterField2($table, $column, $columnNew, $type, $null = true, $default = null) {
        return $this->_driver->AlterField2($table, $column, $columnNew, $type, $null, $default);
	}
	public function AlterField($table, $column, $type, $null = true, $default = null) {
        return $this->_driver->AlterField($table, $column, $type, $null, $default);
	}
	public function RemoveField($table, $column) {
        return $this->_driver->RemoveField($table, $column);
	}
    public function CreateTable($name, $fields, $indices, $ads, $temp = false, $return = false) {
        $v = $this->_driver->CreateTable($name, $fields, $indices, $ads, $temp, $return);
        $this->Tables(true);
        return $v;
    }
    public function CreateTableAs($name, $query, $temp = false) {
        $v = $this->_driver->CreateTableAs($name, $query, $temp);
        $this->Tables(true);
        return $v;
    }
    public function DropTable($name, $return = false) {
        if($this->TableExists($name))
            return $this->_driver->DropTable($name, $return);
        return false;
    }
    public function PrepareRowData($table, $row) {
        return $this->_driver->PrepareRowData($this->Fields($table), $row);
    }
	    function SystemTypes() {
        $ret = new collection();
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
        $ret->add("BIGDATE", "12: BIGDATE");
        return $ret;
    }
    function Type2System() {
        $ret = new collection();
        $ret->add("TEXT", "LONGVARCHAR");
        $ret->add("MEMO", "LONGTEXT");
        $ret->add("HTML", "LONGTEXT");
        $ret->add("BLOB", "BIGINT");
        $ret->add("BLOB LIST", "LONGTEXT");
        $ret->add("CHECK", "BOOLEAN");
        $ret->add("NUMERIC", "REAL");
        $ret->add("DATETIME", "TIMESTAMP");
        $ret->add("FILE", "TINYTEXT");
        $ret->add("FILE LIST", "LONGTEXT");
        $ret->add("MULTISELECT", "LONGTEXT");
        $ret->add("BIGDATE", "BIGINT");
        return $ret;
    }
    public function CreateDefaultSchema() {
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs", array(
            "blobs_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "blobs_alt" => array('type' => 'longvarchar', 'additional' => ''), 
            "blobs_category" => array('type' => 'longvarchar', 'additional' => ''), 
            "blobs_filename" => array('type' => 'longvarchar', 'additional' => ''), 
            "blobs_type" => array('type' => 'shortvarchar', 'additional' => ''), 
            "blobs_parent" => array('type' => 'bigint', 'additional' => ' DEFAULT -1 NOT NULL'), 
            "blobs_isfolder" => array('type' => 'boolean' , 'additional' => 'DEFAULT false NOT NULL'), 
            "blobs_bsize" => array('type' => 'bigint', 'additional' => ' DEFAULT 0'), 
            "blobs_securitycache" => array('type' => 'longtext', 'additional' => ''), 
            "blobs_lastaccessed" => array('type' => 'timestamp', 'additional' => ''), 
            "blobs_width" => array('type' => 'bigint', 'additional' => ''), 
            "blobs_height" => array('type' => 'bigint', 'additional' => ''), 
            "blobs_modified" => array('type' => 'timestamp', 'additional' => '')
        ), array(
            "sys_blobs_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "blobs_id")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs_cache", array(
            "blobs_cache_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "blobs_cache_blobs_id" => array('type' => 'bigint', 'additional' => 'DEFAULT 0'), 
            "blobs_cache_date" => array('type' => 'timestamp', 'additional' => 'DEFAULT CURRENT_TIMESTAMP'), 
            "blobs_cache_width" => array('type' => 'bigint', 'additional' => 'DEFAULT 0'), 
            "blobs_cache_height" => array('type' => 'bigint', 'additional' => 'DEFAULT 0'), 
            "blobs_cache_data" => array('type' => 'blob', 'additional' => '')
        ), array(
            "sys_blobs_cache_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "blobs_cache_id")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs_categories", array(
            "category_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "category_parent" => array('type' => 'bigint', 'additional' => 'DEFAULT -1'), 
            "category_description" => array('type' => 'longvarchar', 'additional' => 'DEFAULT \'New category\''), 
            "category_securitycache" => array('type' => 'longtext', 'additional' => '')
        ), array(
            "category_id" => array("constraint" => "PRIMARY KEY", "fields" => "category_id")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_blobs_data", array(
            "blobs_id" => array('type' => 'autoincrement', 'additional' => ''), 
            "blobs_data" => array('type' => 'blob', 'additional' => '')
        ), array(
            "sys_blobs_data_id" => array("constraint" => "UNIQUE", "fields" => "blobs_id")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_index", array(
            "index_site" => array('type' => 'bigint', 'additional' => ' NOT NULL'),
            "index_folder" => array('type' => 'bigint', 'additional' => ' NOT NULL'), 
            "index_publication" => array('type' => 'bigint', 'additional' => ' NOT NULL'),
            "index_word" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL'),
            "index_language" => array('type' => 'varchar2', 'additional' => ' NOT NULL')
        ), array(
            "sys_index_word" => array("constraint" => "", "fields" => "index_word")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_index_words", array(
            "index_word_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "index_word" => array('type' => 'longvarchar', 'additional' => ' NOT NULL')
        ), array(
            "sys_index_words_word_id" => array("constraint" => "PRIMARY KEY", "fields" => "index_word_id"),
            "sys_index_words_word" => array("constraint" => "", "fields" => "index_word")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_languages", array(
            "language_id" => array('type' => 'varchar2', 'additional' => ' NOT NULL'),
            "language_view" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL')
        ), array(
            "sys_languages_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "language_id")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_links", array(
            "link_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "link_parent_storage_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_parent_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_child_storage_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_child_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_creationdate" => array('type' => 'timestamp', 'additional' => ' NOT NULL DEFAULT CURRENT_TIMESTAMP'),
            "link_order" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_template" => array('type' => 'longvarchar', 'additional' => ' NULL'),
            "link_object_type" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "link_propertiesvalues" => array('type' => 'longtext', 'additional' => ''),
            "link_modifieddate" => array('type' => 'timestamp', 'additional' => '')
        ), array(
            "sys_links_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "link_id"),
            "sys_links_unique" => array("constraint" => "UNIQUE", "fields" => "link_parent_storage_id,link_parent_id,link_child_storage_id,link_child_id"),
            "sys_links_order" => array("constraint" => "", "fields" => "link_order")
        ), ""));
        $this->_scheme->Add(new PioneerSchemeTable("sys_module_templates", array(
            "module_templates_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "module_templates_name" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL DEFAULT \'new template\''),
            "module_templates_module_id" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_templates_list" => array('type' => 'longtext', 'additional' => ''),
            "module_templates_properties" => array('type' => 'longtext', 'additional' => ''),
            "module_templates_styles" => array('type' => 'longtext', 'additional' => ''),
            "module_templates_composite" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_templates_description" => array('type' => 'longvarchar', 'additional' => ''),
            "module_templates_cache" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_templates_cachecheck" => array('type' => 'longvarchar', 'additional' => '')
        ), array(
            "sys_module_templates_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "module_templates_id"),
            "sys_module_templates_name" => array("constraint" => "", "fields" => "module_templates_name")
        ), ""));  
        $this->_scheme->Add(new PioneerSchemeTable("sys_modules", array(
            "module_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "module_order" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_state" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_entry" => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
            "module_title" => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
            "module_description" => array('type' => 'longtext', 'additional' => ''),
            "module_version" => array('type' => 'shortvarchar', 'additional' => ' NOT NULL DEFAULT \'1.0\''),
            "module_admincompat" => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            "module_compat" => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            "module_code" => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            "module_storages" => array('type' => 'longtext', 'additional' => ''),
            "module_libraries" => array('type' => 'longtext', 'additional' => ''),
            "module_type" => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
            "module_haseditor" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_publicated" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_favorite" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "module_iconpack" => array('type' => 'longvarchar', 'additional' => '')
        ), array(
            "sys_modules_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "module_entry"),
            "sys_modules_entry" => array("constraint" => "UNIQUE", "fields" => "module_id")
        ), "")); 
        $this->_scheme->Add(new PioneerSchemeTable("sys_notices", array(
            "notice_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "notice_keyword" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'New notice\''),
            "notice_subject" => array('type' => 'longtext', 'additional' => ''),
            "notice_encoding" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "notice_body" => array('type' => 'longtext', 'additional' => ''),
            "notice_securitycache" => array('type' => 'longtext', 'additional' => '')
        ), array(
            "sys_notices_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "notice_id"),
            "sys_notices_keyword" => array("constraint" => "UNIQUE", "fields" => "notice_keyword")
        ), "")); 
        $this->_scheme->Add(new PioneerSchemeTable("sys_repository", array(
            "repository_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "repository_name" => array('type' => 'longvarchar', 'additional' => ''),
            "repository_type" => array('type' => 'shortvarchar', 'additional' => ' NOT NULL DEFAULT \'PHP_CODE\''),
            "repository_code" => array('type' => 'longtext', 'additional' => ''),
            "repository_datemodified" => array('type' => 'longtext', 'additional' => '')
        ), array(
            "sys_repository_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "repository_id"),
            "sys_repository_name" => array("constraint" => "UNIQUE", "fields" => "repository_name")
        ), "")); 
        $this->_scheme->Add(new PioneerSchemeTable("sys_resources", array(
            "resource_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "resource_name" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'\''),
            "resource_language" => array('type' => 'varchar2', 'additional' => ' NOT NULL DEFAULT \'en\''),
            "resource_value" => array('type' => 'longtext', 'additional' => '')
        ), array(
            "sys_resources_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "resource_id")
        ), "")); 
        $this->_scheme->Add(new PioneerSchemeTable("sys_settings", array(
            "setting_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
            "setting_name" => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'NEW SETTING\''),
            "setting_value" => array('type' => 'longtext', 'additional' => ' NULL'),
            "setting_type" => array('type' => 'shortvarchar', 'additional' => ' NOT NULL DEFAULT \'memo\''),
            "setting_securitycache" => array('type' => 'longtext', 'additional' => ' NULL'),
            "setting_issystem" => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
            "setting_category" => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL DEFAULT \'User settings\'')
        ), array(
            "sys_settings_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "setting_id"),
            "sys_settings_name" => array("constraint" => "UNIQUE", "fields" => "setting_name")
        ), "")); 
        $this->_scheme->Add(new PioneerSchemeTable("sys_statistics", array(
                'stats_date' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_site' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_folder' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_publication' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_country_code' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_country_code3' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_country_name' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_region' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_city' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_remoteaddress' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_localaddress' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_session' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_browser' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_browser_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_os' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_os_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_browser_type' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_browser_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_referer_domain' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                'stats_referer_query' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
                'stats_querystring' => array('type' => 'longtext', 'additional' => ' NOT NULL'), 
                'stats_cookie' => array('type' => 'longtext', 'additional' => ' NOT NULL')
            )
        , array(
            "sys_statistics_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "stats_date"),
        ), ''));        
        $this->_scheme->Add(new PioneerSchemeTable("sys_statsarchive", array(
                'stats_date' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'stats_archive' => array('type' => 'longtext', 'additional' => '')
            )
        , array(
            "sys_statsarchive_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "stats_date")
        ), ''));                
        $this->_scheme->Add(new PioneerSchemeTable("sys_storage_fields", array(
                'storage_field_id' => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                'storage_field_storage_id' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'storage_field_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_field_field' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_field_type' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'text\''),
                'storage_field_default' => array('type' => 'longvarchar', 'additional' => ' DEFAULT NULL'),
                'storage_field_required' => array('type' => 'boolean', 'additional' => ' NOT NULL default \'0\''),
                'storage_field_showintemplate' => array('type' => 'boolean', 'additional' => ' NOT NULL default \'1\''),
                'storage_field_lookup' => array('type' => 'longtext', 'additional' => ''),
                'storage_field_order' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'storage_field_values' => array('type' => 'longtext', 'additional' => ''),
                'storage_field_group' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'storage_field_onetomany' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\'')
            )
        , array(
            "sys_storage_fields_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "storage_field_id"),
            "sys_storage_fields_field" => array("constraint" => "UNIQUE", "fields" => "storage_field_storage_id,storage_field_field"),
            "sys_storage_fields_name" => array("constraint" => "", "fields" => "storage_field_name"),
            "sys_storage_fields_storage" => array("constraint" => "", "fields" => "storage_field_storage_id")
        ), ''));  
        $this->_scheme->Add(new PioneerSchemeTable("sys_storage_templates", array(
                'storage_templates_id' => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                'storage_templates_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'New storage template\''),
                'storage_templates_storage_id' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                'storage_templates_list' => array('type' => 'longtext', 'additional' => ''),
                'storage_templates_properties' => array('type' => 'longtext', 'additional' => ''),
                'storage_templates_composite' => array('type' => 'boolean', 'additional' => ' NOT NULL DEFAULT \'0\''),
                'storage_templates_styles' => array('type' => 'longtext', 'additional' => ''),
                'storage_templates_description' => array('type' => 'longvarchar', 'additional' => ''),
                'storage_templates_cache' => array('type' => 'boolean', 'additional' => ' NOT NULL default \'0\''),
                'storage_templates_cachecheck' => array('type' => 'longvarchar', 'additional' => '')
            )
        , array(
            "sys_storage_templates_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "storage_templates_id"),
            "sys_storage_templates_unique" => array("constraint" => "UNIQUE", "fields" => "storage_templates_storage_id,storage_templates_name"),
            "sys_storage_templates_name" => array("constraint" => "", "fields" => "storage_templates_name")
        ), ''));  
        $this->_scheme->Add(new PioneerSchemeTable("sys_storages", array(
                'storage_id' => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                'storage_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
                'storage_table' => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
                'storage_securitycache' => array('type' => 'longtext', 'additional' => ''),
                'storage_color' => array('type' => 'shortvarchar', 'additional' => ''),
                'storage_group' => array('type' => 'longvarchar', 'additional' => ''),
                'storage_istree' => array('type' => 'boolean', 'additional' => ' not null default \'0\'')
            )
        , array(
            "sys_storages_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "storage_id"),
            "sys_storages_table" => array("constraint" => "UNIQUE", "fields" => "storage_table")
        ), ''));  
        $this->_scheme->Add(new PioneerSchemeTable("sys_templates", array(
                'templates_id' => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                'templates_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL'),
                'templates_head' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
                'templates_body' => array('type' => 'longtext', 'additional' => ''),
                'templates_repositories' => array('type' => 'longtext', 'additional' => ''),
                'templates_head_title' => array('type' => 'longtext', 'additional' => ''),
                'templates_head_metakeywords' => array('type' => 'longtext', 'additional' => ''),
                'templates_head_metadescription' => array('type' => 'longtext', 'additional' => ''),
                'templates_head_baseurl' => array('type' => 'longvarchar', 'additional' => ''),
                'templates_head_styles' => array('type' => 'longtext', 'additional' => ''),
                'templates_head_scripts' => array('type' => 'longtext', 'additional' => ''),
                'templates_head_aditionaltags' => array('type' => 'longtext', 'additional' => ''),
                'templates_html_doctype' => array('type' => 'longtext', 'additional' => '')
            )
        , array(
            "sys_templates_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "templates_id"),
            "sys_templates_name" => array("constraint" => "UNIQUE", "fields" => "templates_id")
        ), ''));  
        $this->_scheme->Add(new PioneerSchemeTable("sys_tree", array(
                'tree_id' => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                'tree_left_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                'tree_right_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                'tree_level' => array('type' => 'bigint', 'additional' => 'NOT NULL DEFAULT 0'),
                'tree_sid' => array('type' => 'real', 'additional' => 'NOT NULL DEFAULT 0'),
                'tree_published' => array('type' => 'boolean', 'additional' => 'NOT NULL DEFAULT \'0\''),
                'tree_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'new tree item\''),
                'tree_keyword' => array('type' => 'longvarchar', 'additional' => ' NOT NULL DEFAULT \'newitem\''),
                'tree_template' => array('type' => 'bigint', 'additional' => ''),
                'tree_notes' => array('type' => 'longtext', 'additional' => ''),
                'tree_datecreated' => array('type' => 'timestamp', 'additional' => ''),
                'tree_datemodified' => array('type' => 'timestamp', 'additional' => ''),
                'tree_description' => array('type' => 'longvarchar', 'additional' => ''),
                'tree_language' => array('type' => 'varchar2', 'additional' => ''),
                'tree_domain' => array('type' => 'longvarchar', 'additional' => ''),
                'tree_header_description' => array('type' => 'longtext', 'additional' => ''),
                'tree_header_keywords' => array('type' => 'longtext', 'additional' => ''),
                'tree_header_shortcuticon' => array('type' => 'longtext', 'additional' => ''),
                'tree_header_basehref' => array('type' => 'longtext', 'additional' => ''),
                'tree_header_inlinestyles' => array('type' => 'longtext', 'additional' => ''),
                'tree_header_inlinescripts' => array('type' => 'longtext', 'additional' => ''),
                'tree_header_aditionaltags' => array('type' => 'longtext', 'additional' => ''),
                'tree_header_statictitle' => array('type' => 'longtext', 'additional' => ''),
                'tree_properties' => array('type' => 'longtext', 'additional' => ''),
                'tree_propertiesvalues' => array('type' => 'longtext', 'additional' => ''),
                'tree_securitycache' => array('type' => 'longtext', 'additional' => '')
            )
        , array(
            "sys_tree_pkey" => array("constraint" => "PRIMARY KEY", "fields" => "tree_id"),
            "sys_tree_levels" => array("constraint" => "", "fields" => "tree_left_key,tree_right_key,tree_level"),
            "sys_tree_name" => array("constraint" => "", "fields" => "tree_name")
        ), ''));  
        $this->_scheme->Add(new PioneerSchemeTable('sys_umusers', array(
            'users_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
            'users_created' => array('type' => 'timestamp', 'additional' => ' NULL default CURRENT_TIMESTAMP'),
            'users_modified' => array('type' => 'timestamp', 'additional' => ' NULL'),
            'users_password' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
            'users_lastlogindate' => array('type' => 'timestamp', 'additional' => ' NULL'),
            'users_lastloginfrom' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
            'users_roles' => array('type' => 'longtext', 'additional' => ''),
            'users_profile' => array('type' => 'longtext', 'additional' => ''),
        ), array(
            'users_name' => array('fields' => 'users_name', 'constraint' => 'PRIMARY KEY')
        ), ''));        
        $this->_scheme->Add(new PioneerSchemeTable('sys_umgroups', array(
            'groups_name' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\''),
            'groups_description' => array('type' => 'tinytext', 'additional' => '')
        ), array(
            'groups_name' => array('fields' => 'groups_name', 'constraint' => 'PRIMARY KEY')
        ), ''));
        $this->_scheme->Add(new PioneerSchemeTable('sys_umusersgroups', array(
            'ug_user' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\''),
            'ug_group' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\'')
        ), array(
        ), ''));
    }
    function ExecuteBatchFile($content, $ignoreerrors = false) {         
        $file_content = $content;
        if($core->fs->FileExists($content))
            $file_content = $core->fs->SplitFile($content);
        $query = "";
        foreach($file_content as $sql_line) {
            $tsl = trim($sql_line);
            if (($tsl != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "#")) {
                $query .= $sql_line;
                if(preg_match("/;\s*$/", $sql_line)) {
                    $result = $core->dbe->query($connection, $dbtype, $query);
                    if (!$result && !$ignoreerrors) {
                        return false;
                    }
                    $query = "";
                }
            }
        }
        return true;
    }        
}
class PioneerSchemeTable extends Object {
    public function __construct($name, $fields = array(), $indices = array(), $ads = '', $temp = false, $engine = null) {
        parent::__construct();
        $this->name = $name;
        $this->fields = $fields;
        $this->indices = $indices;
        $this->ads = $ads;
        $this->temp = $temp;
        $this->_engine = $engine;
    }
    public function Check() {
                if($this->_engine->TableExists($this->table))
            return false;
        $fields = $this->_engine->Fields($this->table);
        foreach($this->fields as $name => $f) {
            if(!$fields->Exists($name))
                return false;
        }
        return true;
    }
    public function CreateScheme($return = false) {
        if(is_null($this->_engine))
            return false;
        return $this->_engine->CreateTable($this->name, $this->fields, $this->indices, $this->ads, $this->temp, $return);
    }
    public function Drop($return = false) {
        if(is_null($this->_engine))
            return false;
        return $this->_engine->DropTable($this->name, $return);
    }
}
class PioneerScheme extends ArrayList {
    private $_engine;
    public function __construct($engine) {
        parent::__construct();
        $this->_engine = $engine;
    }
    public function Add(PioneerSchemeTable $table) {
        $table->_engine = $this->_engine;
        return parent::Add($table);
    }
    public function Check() {
        foreach($this as $table) {
            if(!$table->Check())
                return false;
        }
        return true;
    }
    public function GetScheme() {
        $query = '';
        foreach($this as $table) {
            $query .= $table->CreateScheme(true);
        }
        return $query;
    }
    public function CreateScheme() {
        $this->_engine->StartTrans();
        foreach($this as $table) {
            if(!$table->CreateScheme()) {
                $this->_engine->FailTrans();
                return false;
            }
        }
        $this->_engine->CompleteTrans();
        return true;
    }
    public function InsertInitialData() {
        $this->_engine->StartTrans();
                Setting::Create('BLOB_CACHE_FOLDER', 'memo', '/assets/static', null, false, 'Blob manager settings | Настройки менеджера ресурсов')->Insert();
        Setting::Create('MAIL_SMTP', 'memo', 'island.grc.ru', null, false, 'System settings | Настройки системы')->Insert();
        Setting::Create('DEVELOPER_EMAIL', 'memo', 'mk@e-time.ru;spawn@e-time.ru', null, false, 'System settings | Настройки системы')->Insert();
        Setting::Create('COPYRIGHT', 'memo', 'Company copyright', null, false, 'User settings | Пользовательские настройки')->Insert();
        Setting::Create('USE_MOD_REWRITE', 'memo', 'default', NULL, false, 'System settings | Настройки системы')->Insert();
        Setting::Create('SYSTEM_RESTORE_CRON_MAX', 'memo', '5', NULL, false, 'System restore settings | Настройки системы восстановления')->Insert();
        Setting::Create('SETTING_COMPANY_EMAIL', 'memo', 'company@e.mail', null, false, 'User settings | Пользовательские настройки')->Insert();
        Setting::Create('SETTING_COMPANY_TITLE', 'memo', 'Company title', null, true, 'User settings | Пользовательские настройки')->Insert();
        Setting::Create('SETTING_PAGESIZE', 'memo', '10', null, false, 'System settings | Настройки системы')->Insert();
        DesignTemplate::Create('default', '', '<? echo phpinfo(); ?>', '', 'Default Site', '', '', '', '', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');
        $this->_engine->Insert('sys_tree', Collection::Create(
            'tree_left_key', 1, 
            'tree_right_key', 86, 
            'tree_level', 0, 
            'tree_sid', 0, 
            'tree_published', true, 
            'tree_name', 'root', 
            'tree_keyword', 'root', 
            'tree_template', 2, 
            'tree_notes', '', 
            'tree_datecreated', '2006-12-12 15:41:50', 
            'tree_datemodified', '2006-12-12 15:41:50', 
            'tree_description', 'root', 
            'tree_language', 'ru', 
            'tree_domain', 'root', 
            'tree_header_description', '', 
            'tree_header_keywords', '', 
            'tree_header_shortcuticon', '', 
            'tree_header_basehref', '', 
            'tree_header_inlinestyles', '', 
            'tree_header_inlinescripts', '', 
            'tree_header_aditionaltags', '', 
            'tree_header_statictitle', 'root', 
            'tree_properties', null,
            'tree_propertiesvalues', null,
            'tree_securitycache', null
        ));
        $this->_engine->Insert('sys_tree', Collection::Create(
            'tree_left_key', 7, 
            'tree_right_key', 85, 
            'tree_level', 1, 
            'tree_sid', 0, 
            'tree_published', true, 
            'tree_name', 'site', 
            'tree_keyword', 'site', 
            'tree_template', 1, 
            'tree_notes', '', 
            'tree_datecreated', '2006-12-12 15:41:50', 
            'tree_datemodified', '2006-12-12 15:41:50', 
            'tree_description', 'Default site', 
            'tree_language', 'ru', 
            'tree_domain', '', 
            'tree_header_description', '', 
            'tree_header_keywords', '', 
            'tree_header_shortcuticon', '', 
            'tree_header_basehref', '', 
            'tree_header_inlinestyles', '', 
            'tree_header_inlinescripts', '', 
            'tree_header_aditionaltags', '', 
            'tree_header_statictitle', 'Default site', 
            'tree_properties', null,
            'tree_propertiesvalues', null,
            'tree_securitycache', null
        ));
        $this->_engine->Insert('sys_umgroups', Collection::Create('groups_name', 'Administrators', 'groups_description', 'System administrators'));
        $this->_engine->Insert('sys_umusers', Collection::Create(
            'users_name', 'admin', 
            'users_password', '4b6dP/8=', 
            'users_lastlogindate', '01.01.2008', 
            'users_lastloginfrom', '93.80.180.159', 
            'users_roles', 'system_administrator'
        ));
        $this->_engine->Insert('sys_umusersgroups', Collection::Create('ug_user', 'admin', 'ug_group', 'Administrators'));
        $this->_engine->CompleteTrans();
        return true;
    }
    public function Drop() {
        $this->_engine->StartTrans();
        foreach($this as $table) {
            if(!$table->Drop()) {
                $this->_engine->FailTrans();
                return false;
            }
        }
        $this->_engine->CompleteTrans();
        return true;
    }
}
?><?php
class dbtree {
	var $ERRORS = array();
	var $ERRORS_MES = array();
	var $table;
	var $table_id;
	var $table_left;
	var $table_right;
	var $table_level;
	var $res;
	var $db;
	function dbtree($table, $prefix) {
		$this->table = $table;
		$this->table_id = $prefix . '_id';
		$this->table_left = $prefix . '_left_key';
		$this->table_right = $prefix . '_right_key';
		$this->table_level = $prefix . '_level';
		unset($prefix, $table);
	}
	function Clear($data = array()) {
		global $core;
		if (!$core->dbe->Query('TRUNCATE ' . $this->table)) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		if (!$core->dbe->Query('DELETE FROM ' . $this->table)) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		$fld_names = '';
		$fld_values = '';
		if (!empty($data)) {
			$fld_names = implode(', ', array_keys($data)) . ', ';
			$fld_values = '\'' . implode('\', \'', array_values($data)) . '\', ';
		}
		$fld_names .= $this->table_left . ', ' . $this->table_right . ', ' . $this->table_level;
		$fld_values .= '1, 2, 0';
		if (!$core->dbe->Query('INSERT INTO ' . $this->table . ' (' . $fld_names . ') VALUES (' . $fld_values . ')')) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		return $core->dbe->InsertId();
	}
	function Update($ID, $data) {
		global $core;
		$sql_set = '';
		if($data instanceof collection)
			$data = $data->get_array();
		foreach($data as $k=>$v) 
			$sql_set .= ','.$k.'=\''.addslashes($v).'\'';
		return $core->dbe->Query('UPDATE '.$this->table.' SET '.substr($sql_set,1).' WHERE '.$this->table_id.'=\''.$ID.'\'', '', true);
	}
	function GetNodeInfo($section_id) {
		global $core;
		$sql = 'SELECT ' . $this->table_left . ', ' . $this->table_right . ', ' . $this->table_level . ' FROM ' . $this->table . ' WHERE ' . $this->table_id . ' = ' . (int)$section_id;
        $res = $core->dbe->ExecuteReader($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		if (0 == $res->Count()) {
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('no_element_in_tree') : 'no_element_in_tree';
			return FALSE;
		}
		$data = $res->Read();
		return array($data->{$this->table_left}, $data->{$this->table_right}, $data->{$this->table_level});
	}
	function GetNode($section_id = -1, $criteria = "", $joinWith = '') {
		global $core;
		if(!empty($joinWith)) {
			$joinWith = $this->_PrepareJoin($joinWith);
		}
		if($section_id >= 0)
			$sql = 'SELECT * FROM '.$this->table.$joinWith.' WHERE '.$this->table_id.'=\''.$section_id.'\'';
		else {
			$sql = 'SELECT * FROM '.$this->table.$joinWith.' WHERE '.$criteria;
		}
		$query = $core->dbe->ExecuteReader($sql, $this->table_id);
		if( $query->Count() == 1 ) {
			return $query->Read();
		}
		else {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
	}
	function GetRootNode() {
		global $core;
		$sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->table_level.'=\'0\'';
		$query = $core->dbe->ExecuteReader($sql, $this->table_id);
        if($query->Count() == 0) {
            $this->Clear();
            $query = $core->dbe->ExecuteReader($sql, $this->table_id);
        }
		if( $query->Count() == 1 ) {
			return $query->Read();
		}
		else {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
	}
	function GetParentInfo($section_id, $condition = '') {
		global $core;
		$node_info = $this->GetNodeInfo($section_id);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId, $rightId, $level) = $node_info;
		$level--;
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'SELECT * FROM ' . $this->table
			. ' WHERE ' . $this->table_left . ' < ' . $leftId
			. ' AND ' . $this->table_right . ' > ' . $rightId
			. ' AND ' . $this->table_level . ' = ' . $level
			. $condition
			. ' ORDER BY ' . $this->table_left;
				$res = $core->dbe->ExecuteReader($sql);
								if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		return $res->Read();
	}
	function GetInsertSQL($sql, $data) {
		global $core;
		if (empty($data)) {
			return '';
		}
		preg_match_all("~FROM\s+([^\s]*)~", $sql, $maches, PREG_PATTERN_ORDER);
		if (!isset($maches[1][0])) {
			return '';
		} else {
			$table = $maches[1][0];
		}
		if (!empty($data)) {
			$fld_names = implode(', ', array_keys($data));
			$fld_values = '\'' . implode('\', \'', array_values($data)) . '\'';
		}
		$sql1 = 'INSERT INTO ' . $table . ' (' . $fld_names . ') VALUES (' . $fld_values . ')';
		return $sql1;
	}
	function Insert($section_id, $condition = '', $data = array()) {
		global $core;
		$node_info = $this->GetNodeInfo($section_id);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId, $rightId, $level) = $node_info;
		if($data instanceof collection)
			$data = $data->get_array();
		$data[$this->table_left] = $rightId;
		$data[$this->table_right] = ($rightId + 1);
		$data[$this->table_level] = ($level + 1);
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'UPDATE ' . $this->table . ' SET '
			. $this->table_left . '=CASE WHEN ' . $this->table_left . '>' . $rightId . ' THEN ' . $this->table_left . '+2 ELSE ' . $this->table_left . ' END, '
			. $this->table_right . '=CASE WHEN ' . $this->table_right . '>=' . $rightId . ' THEN ' . $this->table_right . '+2 ELSE ' . $this->table_right . ' END '
			. 'WHERE ' . $this->table_right . '>=' . $rightId;
		$sql .= $condition;
		$core->dbe->StartTrans();
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->table_id . ' = -1';
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
				$sql = $this->GetInsertSQL($sql, $data);
		if (!empty($sql)) {
			$res = $core->dbe->Query($sql);
			if (FALSE === $res) {
				$this->ERRORS[] = array(2, 'SQL query error', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
				$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
				$core->dbe->FailTrans();
				return FALSE;
			}
		}
		$core->dbe->CompleteTrans();
		return $core->dbe->InsertId(true);
	}
	function InsertNear($ID, $condition = '', $data = array()) {
		global $core;
		$node_info = $this->GetNodeInfo($ID);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId, $rightId, $level) = $node_info;
		if($data instanceof collection)
			$data = $data->get_array();
		$data[$this->table_left] = ($rightId + 1);
		$data[$this->table_right] = ($rightId + 2);
		$data[$this->table_level] = ($level);
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'UPDATE ' . $this->table . ' SET '
			. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' > ' . $rightId . ' THEN ' . $this->table_left . ' + 2 ELSE ' . $this->table_left . ' END, '
			. $this->table_right . ' = CASE WHEN ' . $this->table_right . '> ' . $rightId . ' THEN ' . $this->table_right . ' + 2 ELSE ' . $this->table_right . ' END, '
			. 'WHERE ' . $this->table_right . ' > ' . $rightId;
		$sql .= $condition;
		$core->dbe->StartTrans();
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->table_id . ' = -1';
		$res = $core->dbe->ExecuteReader($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
				$sql = $this->GetInsertSQL($sql, $data);
		if (!empty($sql)) {
			$res = $core->dbe->ExecuteReader($sql);
			if (FALSE === $res) {
				$this->ERRORS[] = array(2, 'SQL query error', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
				$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
				$core->dbe->FailTrans();
				return FALSE;
			}
		}
		$core->dbe->CompleteTrans();
		return $core->dbe->InsertId();	}
	function MoveAll($ID, $newParentId, $condition = '') {
		global $core;
		$node_info = $this->GetNodeInfo($ID);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId, $rightId, $level) = $node_info;
		$node_info = $this->GetNodeInfo($newParentId);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftIdP, $rightIdP, $levelP) = $node_info;
		if ($ID == $newParentId || $leftId == $leftIdP || ($leftIdP >= $leftId && $leftIdP <= $rightId) || ($level == $levelP+1 && $leftId > $leftIdP && $rightId < $rightIdP)) {
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_move_tree') : 'cant_move_tree';
			return FALSE;
		}
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition);
		}
		if ($leftIdP < $leftId && $rightIdP > $rightId && $levelP < $level - 1) {
			$sql = 'UPDATE ' . $this->table . ' SET '
				. $this->table_level . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_level.sprintf('%+d', -($level-1)+$levelP) . ' ELSE ' . $this->table_level . ' END, '
				. $this->table_right . ' = CASE WHEN ' . $this->table_right . ' BETWEEN ' . ($rightId+1) . ' AND ' . ($rightIdP-1) . ' THEN ' . $this->table_right . '-' . ($rightId-$leftId+1) . ' '
				. 'WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_right . '+' . ((($rightIdP-$rightId-$level+$levelP)/2)*2+$level-$levelP-1) . ' ELSE ' . $this->table_right . ' END, '
				. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . ($rightId+1) . ' AND ' . ($rightIdP-1) . ' THEN ' . $this->table_left . '-' . ($rightId-$leftId+1) . ' '
				. 'WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_left . '+' . ((($rightIdP-$rightId-$level+$levelP)/2)*2+$level-$levelP-1) . ' ELSE ' . $this->table_left . ' END '
				. 'WHERE ' . $this->table_left . ' BETWEEN ' . ($leftIdP+1) . ' AND ' . ($rightIdP-1);
		} elseif ($leftIdP < $leftId) {
			$sql = 'UPDATE ' . $this->table . ' SET '
				. $this->table_level . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_level.sprintf('%+d', -($level-1)+$levelP) . ' ELSE ' . $this->table_level . ' END, '
				. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $rightIdP . ' AND ' . ($leftId-1) . ' THEN ' . $this->table_left . '+' . ($rightId-$leftId+1) . ' '
				. 'WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_left . '-' . ($leftId-$rightIdP) . ' ELSE ' . $this->table_left . ' END, '
				. $this->table_right . ' = CASE WHEN ' . $this->table_right . ' BETWEEN ' . $rightIdP . ' AND ' . $leftId . ' THEN ' . $this->table_right . '+' . ($rightId-$leftId+1) . ' '
				. 'WHEN ' . $this->table_right . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_right . '-' . ($leftId-$rightIdP) . ' ELSE ' . $this->table_right . ' END '
				. 'WHERE (' . $this->table_left . ' BETWEEN ' . $leftIdP . ' AND ' . $rightId. ' '
				. 'OR ' . $this->table_right . ' BETWEEN ' . $leftIdP . ' AND ' . $rightId . ')';
		} else {
			$sql = 'UPDATE ' . $this->table . ' SET '
				. $this->table_level . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_level.sprintf('%+d', -($level-1)+$levelP) . ' ELSE ' . $this->table_level . ' END, '
				. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $rightId . ' AND ' . $rightIdP . ' THEN ' . $this->table_left . '-' . ($rightId-$leftId+1) . ' '
				. 'WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_left . '+' . ($rightIdP-1-$rightId) . ' ELSE ' . $this->table_left . ' END, '
				. $this->table_right . ' = CASE WHEN ' . $this->table_right . ' BETWEEN ' . ($rightId+1) . ' AND ' . ($rightIdP-1) . ' THEN ' . $this->table_right . '-' . ($rightId-$leftId+1) . ' '
				. 'WHEN ' . $this->table_right . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_right . '+' . ($rightIdP-1-$rightId) . ' ELSE ' . $this->table_right . ' END '
				. 'WHERE (' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightIdP . ' '
				. 'OR ' . $this->table_right . ' BETWEEN ' . $leftId . ' AND ' . $rightIdP . ')';
		}
		$sql .= $condition;
		$core->dbe->StartTrans();
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$core->dbe->CompleteTrans();
		return TRUE;
	}
	function ChangePosition($id1, $id2) {
		global $core;
		$node_info = $this->GetNodeInfo($id1);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId1, $rightId1, $level1) = $node_info;
		$node_info = $this->GetNodeInfo($id2);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId2, $rightId2, $level2) = $node_info;
		$sql = 'UPDATE ' . $this->table . ' SET '
			. $this->table_left . ' = ' . $leftId2 .', '
			. $this->table_right . ' = ' . $rightId2 .', '
			. $this->table_level . ' = ' . $level2 .' '
			. 'WHERE ' . $this->table_id . ' = ' . (int)$id1;
		$core->dbe->StartTrans();
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$sql = 'UPDATE ' . $this->table . ' SET '
			. $this->table_left . ' = ' . $leftId1 .', '
			. $this->table_right . ' = ' . $rightId1 .', '
			. $this->table_level . ' = ' . $level1 .' '
			. 'WHERE ' . $this->table_id . ' = ' . (int)$id2;
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$core->dbe->CompleteTrans();
		return TRUE;
	}
	function ChangePositionAll($id1, $id2, $position = 'after', $condition = '') {
		global $core;
		$node_info = $this->GetNodeInfo($id1);
		if (FALSE === $node_info) {
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_change_position') : 'cant_change_position';
			return FALSE;
		}
		list($leftId1, $rightId1, $level1) = $node_info;
		$node_info = $this->GetNodeInfo($id2);
		if (FALSE === $node_info) {
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_change_position') : 'cant_change_position';
			return FALSE;
		}
		list($leftId2, $rightId2, $level2) = $node_info;
		if ($level1 <> $level2) {
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_change_position') : 'cant_change_position';
			return FALSE;
		}
		if ('before' == $position) {
			if ($leftId1 > $leftId2) {
				$sql = 'UPDATE ' . $this->table . ' SET '
					. $this->table_right . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_right . ' - ' . ($leftId1 - $leftId2) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . $leftId2 . ' AND ' . ($leftId1 - 1) . ' THEN ' . $this->table_right . ' +  ' . ($rightId1 - $leftId1 + 1) . ' ELSE ' . $this->table_right . ' END, '
					. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_left . ' - ' . ($leftId1 - $leftId2) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . $leftId2 . ' AND ' . ($leftId1 - 1) . ' THEN ' . $this->table_left . ' + ' . ($rightId1 - $leftId1 + 1) . ' ELSE ' . $this->table_left . ' END '
					. 'WHERE ' . $this->table_left . ' BETWEEN ' . $leftId2 . ' AND ' . $rightId1;
			} else {
				$sql = 'UPDATE ' . $this->table . ' SET '
					. $this->table_right . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_right . ' + ' . (($leftId2 - $leftId1) - ($rightId1 - $leftId1 + 1)) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . ($rightId1 + 1) . ' AND ' . ($leftId2 - 1) . ' THEN ' . $this->table_right . ' - ' . (($rightId1 - $leftId1 + 1)) . ' ELSE ' . $this->table_right . ' END, '
					. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_left . ' + ' . (($leftId2 - $leftId1) - ($rightId1 - $leftId1 + 1)) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . ($rightId1 + 1) . ' AND ' . ($leftId2 - 1) . ' THEN ' . $this->table_left . ' - ' . ($rightId1 - $leftId1 + 1) . ' ELSE ' . $this->table_left . ' END '
					. 'WHERE ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . ($leftId2 - 1);
			}
		}
		if ('after' == $position) {
			if ($leftId1 > $leftId2) {
				$sql = 'UPDATE ' . $this->table . ' SET '
					. $this->table_right . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_right . ' - ' . ($leftId1 - $leftId2 - ($rightId2 - $leftId2 + 1)) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . ($rightId2 + 1) . ' AND ' . ($leftId1 - 1) . ' THEN ' . $this->table_right . ' +  ' . ($rightId1 - $leftId1 + 1) . ' ELSE ' . $this->table_right . ' END, '
					. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_left . ' - ' . ($leftId1 - $leftId2 - ($rightId2 - $leftId2 + 1)) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . ($rightId2 + 1) . ' AND ' . ($leftId1 - 1) . ' THEN ' . $this->table_left . ' + ' . ($rightId1 - $leftId1 + 1) . ' ELSE ' . $this->table_left . ' END '
					. 'WHERE ' . $this->table_left . ' BETWEEN ' . ($rightId2 + 1) . ' AND ' . $rightId1;
			} else {
				$sql = 'UPDATE ' . $this->table . ' SET '
					. $this->table_right . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_right . ' + ' . ($rightId2 - $rightId1) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . ($rightId1 + 1) . ' AND ' . $rightId2 . ' THEN ' . $this->table_right . ' - ' . (($rightId1 - $leftId1 + 1)) . ' ELSE ' . $this->table_right . ' END, '
					. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId1 . ' THEN ' . $this->table_left . ' + ' . ($rightId2 - $rightId1) . ' '
					. 'WHEN ' . $this->table_left . ' BETWEEN ' . ($rightId1 + 1) . ' AND ' . $rightId2 . ' THEN ' . $this->table_left . ' - ' . ($rightId1 - $leftId1 + 1) . ' ELSE ' . $this->table_left . ' END '
					. 'WHERE ' . $this->table_left . ' BETWEEN ' . $leftId1 . ' AND ' . $rightId2;
			}
		}
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition);
		}
		$sql .= $condition;
		$core->dbe->StartTrans();
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$core->dbe->CompleteTrans();
		return TRUE;
	}
	function Delete($ID, $condition = '') {
		global $core;
		$node_info = $this->GetNodeInfo($ID);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId, $rightId) = $node_info;
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->table_id . ' = ' . (int)$ID;
		$core->dbe->StartTrans();
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$sql = 'UPDATE ' . $this->table . ' SET '
			. $this->table_level . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_level . ' - 1 ELSE ' . $this->table_level . ' END, '
			. $this->table_right . ' = CASE WHEN ' . $this->table_right . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_right . ' - 1 '
			. 'WHEN ' . $this->table_right . ' > ' . $rightId . ' THEN ' . $this->table_right . ' - 2 ELSE ' . $this->table_right . ' END, '
			. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId . ' THEN ' . $this->table_left . ' - 1 '
			. 'WHEN ' . $this->table_left . ' > ' . $rightId . ' THEN ' . $this->table_left . ' - 2 ELSE ' . $this->table_left . ' END '
			. 'WHERE ' . $this->table_right . ' > ' . $leftId;
		$sql .= $condition;
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$core->dbe->CompleteTrans();
		return TRUE;
	}
	function DeleteAll($ID, $condition = '') {
		global $core;
		$node_info = $this->GetNodeInfo($ID);
		if (FALSE === $node_info) {
			return FALSE;
		}
		list($leftId, $rightId) = $node_info;
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId;
		$core->dbe->StartTrans();
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$deltaId = (($rightId - $leftId) + 1);
		$sql = 'UPDATE ' . $this->table . ' SET '
			. $this->table_left . ' = CASE WHEN ' . $this->table_left . ' > ' . $leftId.' THEN ' . $this->table_left . ' - ' . $deltaId . ' ELSE ' . $this->table_left . ' END, '
			. $this->table_right . ' = CASE WHEN ' . $this->table_right . ' > ' . $leftId . ' THEN ' . $this->table_right . ' - ' . $deltaId . ' ELSE ' . $this->table_right . ' END '
			. 'WHERE ' . $this->table_right . ' > ' . $rightId;
		$sql .= $condition;
		$res = $core->dbe->Query($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$core->dbe->FailTrans();
			return FALSE;
		}
		$core->dbe->CompleteTrans();
		return TRUE;
	}
    function CountAll($ID, $condition = '') {
        global $core;
        $node_info = $this->GetNodeInfo($ID);
        if (FALSE === $node_info) {
            return FALSE;
        }
        list($leftId, $rightId) = $node_info;
        if (!empty($condition)) {
            $condition = $this->_PrepareCondition($condition);
        }
        $sql = 'SELECT count(*) as c FROM ' . $this->table . ' WHERE ' . $this->table_left . ' BETWEEN ' . $leftId . ' AND ' . $rightId;
        $res = $core->dbe->ExecuteReader($sql);
        if (FALSE === $res) {
            $this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
            $this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
            return FALSE;
        }
        $r = $res->Read();
        return $r->c;
    }
	function Full($fields, $condition = '', $indexKey = '', $joinWith = '', $page = -1, $pagesize = 10) {
		global $core;
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition, TRUE);
		}
		if(!empty($joinWith)) {
			$joinWith = $this->_PrepareJoin($joinWith);
		}
		if (is_array($fields)) {
			$fields = implode(', ', $fields);
		} else {
			$fields = '*';
		}
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table.' '.$joinWith;
		$sql .= $condition;
		$sql .= ' ORDER BY ' . $this->table_left;
		$res = $core->dbe->ExecuteReader($sql, $page, $pagesize);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		$this->res = $res;
		return $res;
	}
	public function GetPositionNumber($id, $condition = '') { 
		global $core;
		$node = $this->GetNodeInfo($id);
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition, false);
		}
		$sql = 'select count(*) as c from '.$this->table.' where '.$this->table_left.' < '.$node[0].$condition.' order by '.$this->table_left;
		$r = $core->dbe->ExecuteReader($sql);
		$rr = $r->Read();
		return $rr->c;
	}	
	function Branch($ID, $fields = '', $condition = '', $indexKey = '', $joinWith = '', $page = -1, $pagesize = 10) {
		global $core;
		if (is_array($fields)) {
            $fields[] = "*";
			$fields = 'A.' . implode(', A.', $fields);
            $fields = str_replace('A.(', '(', $fields);
            $fields = str_replace('A.exists(', 'exists(', $fields);
            $fields = str_replace('A.count(', 'count(', $fields);
            $fields = str_replace('A.concat(', 'concat(', $fields);
            $fields = str_replace('A. concat(', 'concat(', $fields);
            $fields = str_replace('A. (', '(', $fields);
		} else {
			$fields = 'A.*';
		}
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition, FALSE, 'A.');
		}
                $condition .= ' and A.'.$this->table_level.' > 0';
		if(!empty($joinWith)) {
			$joinWith = $this->_PrepareJoin($joinWith, 'A.');
		}
        		$sql = 'SELECT ' . $fields . ', CASE WHEN A.' . $this->table_left . ' + 1 < A.' . $this->table_right . ' THEN 1 ELSE 0 END AS nflag FROM ' . $this->table . ' A '.$joinWith.', ' . $this->table . ' B WHERE B.' . $this->table_id . ' = ' . (int)$ID . ' AND A.' . $this->table_left . ' >= B.' . $this->table_left . ' AND A.' . $this->table_right . ' <= B.' . $this->table_right;
		$sql .= $condition;
		$sql .= ' ORDER BY A.' . $this->table_left;
		$res = $core->dbe->ExecuteReader($sql, $page, $pagesize);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		$this->res = $res;
		return $res;
	}
	function Parents($ID, $fields = '', $condition = '', $field = '') {
		global $core;
		if (is_array($fields)) {
			$fields = 'A.' . implode(', A.', $fields);
            $fields = str_replace('A.(', '(', $fields);
            $fields = str_replace('A.exists(', 'exists(', $fields);
            $fields = str_replace('A.count(', 'count(', $fields);
            $fields = str_replace('A.concat(', 'concat(', $fields);
            $fields = str_replace('A. concat(', 'concat(', $fields);            
            $fields = str_replace('A. (', '(', $fields);
		} else {
			$fields = 'A.*';
		}
		if (!empty($condition)) {
			$condition = $this->_PrepareCondition($condition, FALSE, 'A.');
		}
		$sql = 'SELECT ' . $fields . ', CASE WHEN A.' . $this->table_left . ' + 1 < A.' . $this->table_right . ' THEN 1 ELSE 0 END AS nflag FROM ' . $this->table . ' A, ' . $this->table . ' B WHERE B.' . $this->table_id . ' = ' . (int)$ID . ' AND B.' . $this->table_left . ' BETWEEN A.' . $this->table_left . ' AND A.' . $this->table_right;
		$sql .= $condition;
		$sql .= ' ORDER BY A.' . $this->table_left;
		$res = $core->dbe->ExecuteReader($sql, $field);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		$this->res = $res;
		return $res;
	}
	function Ajar($ID, $fields = '', $condition = '', $page = -1, $pagesize = 10) {
		global $core;
		if (is_array($fields)) {
			$fields = 'A.' . implode(', A.', $fields);
            $fields = str_replace('A.(', '(', $fields);
            $fields = str_replace('A.exists(', 'exists(', $fields);
            $fields = str_replace('A.count(', 'count(', $fields);
            $fields = str_replace('A.concat(', 'concat(', $fields);
            $fields = str_replace('A. concat(', 'concat(', $fields);
            $fields = str_replace('A. (', '(', $fields);
        } else {
			$fields = 'A.*';
		}
		$condition1 = '';
		if (!empty($condition)) {
			$condition1 = $this->_PrepareCondition($condition, FALSE, 'B.');
		}
		$sql = 'SELECT A.' . $this->table_left . ', A.' . $this->table_right . ', A.' . $this->table_level . ' FROM ' . $this->table . ' A, ' . $this->table . ' B '
			. 'WHERE B.' . $this->table_id . ' = ' . (int)$ID . ' AND B.' . $this->table_left . ' BETWEEN A.' . $this->table_left . ' AND A.' . $this->table_right;
		$sql .= $condition1;
		$sql .= ' ORDER BY A.' . $this->table_left;
		$res = $core->dbe->ExecuteReader($sql);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		if (0 == $res->Count()) {
			$this->ERRORS_MES[] = _('no_element_in_tree');
			return FALSE;
		}
		$alen = $res->Count();
		$i = 0;
		if (is_array($fields)) {
			$fields = implode(', ', $fields);
		} else {
			$fields = '*';
		}
		if (!empty($condition)) {
			$condition1 = $this->_PrepareCondition($condition, FALSE);
		}
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table . ' A WHERE (' . $this->table_level . ' = 1';
		while ($row = $res->Read()) {
			if ((++$i == $alen) && ($row->{$this->table_left} + 1) == $row->{$this->table_right}) {
				break;
			}
			$sql .= ' OR (' . $this->table_level . ' = ' . ($row->{$this->table_level} + 1)
				. ' AND ' . $this->table_left . ' > ' . $row->{$this->table_left}
				. ' AND ' . $this->table_right . ' < ' . $row->{$this->table_right} . ')';
		}
		$sql .= ') ' . $condition1;
		$sql .= ' ORDER BY ' . $this->table_left;
        $res = $core->dbe->ExecuteReader($sql, $page, $pagesize);
		if (FALSE === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__ . '::' . __CLASS__ . '::' . __FUNCTION__ . '::' . __LINE__, 'SQL QUERY: ' . $sql, 'SQL ERROR: ' . $core->dbe->error());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return FALSE;
		}
		$this->res = $res;
		return $res;
	}
	function Count() {
		return $this->res->count();
	}
    function FetchNext() {
		return $this->res->Read();
	}
    function Read() {
        return $this->res->Read();
    }    
	function _PrepareCondition($condition, $where = FALSE, $prefix = '') {
		if (!is_array($condition)) {
			return $condition;
		}
		$sql = ' ';
		if (TRUE === $where) {
			$sql .= 'WHERE ' . $prefix;
		}
		$keys = array_keys($condition);
		for ($i = 0;$i < count($keys);$i++) {
			if (FALSE === $where || (TRUE === $where && $i > 0)) {
				$sql .= ' ' . strtoupper($keys[$i]) . ' ' . $prefix;
			}
			$sql .= implode(' ' . strtoupper($keys[$i]) . ' ' . $prefix, $condition[$keys[$i]]);
		}
		$sql = str_replace($prefix.'(', '(', $sql);
        $sql = str_replace($prefix.'exists(', 'exists(', $sql);
        $sql = str_replace($prefix.'count(', 'count(', $sql);
        $sql = str_replace('A.concat(', 'concat(', $sql);
        $sql = str_replace('A. concat(', 'concat(', $sql);
        $sql = str_replace('A. (', '(', $sql);
		return $sql;
	}
	public function _PrepareJoin($joinWith, $prefix = '') {
		if (!is_array($joinWith)) {
			return $joinWith;
		}
		$sql = ' ';
		foreach($joinWith as $joinType => $joinConditions) {
			foreach($joinConditions as $joinTable => $joinFields) {
				$sql .= ' '.strtoupper($joinType).' JOIN '.$joinTable.' ON '.$joinFields[0].' = '.$prefix.$joinFields[1];
			}
		}
		return $sql;
	}
}
?><?php
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
            @mysql_free_result($resource);
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
                out($query, $this->Error());                             }
            $this->_resourceCache[] = $tmp;
            return $tmp;
        }
        public function SetAutoincrement($table, $idfield) {
            $result = $this->Query("select max(`".$idfield."`) as m from `".$table."`");
            $r = $this->fetch_object($result);
            $this->Query("ALTER TABLE `".$table."` AUTO_INCREMENT = ".$r->m.";");
            $this->free_result($result);
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
            $query = 'CREATE' . ($temp ? ' TEMPORARY ' : '') . ' TABLE `'.$name.'`('."\n";
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
                    if((is_null($value) || $value == 'null' || $value == '1970-01-01 00:00:00') && $field->null == 'NO') 
                        $value = time();
                    if(is_numeric($value)) 
                        $value = 'FROM_UNIXTIME('.$value.')';
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
<?php
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
                out($query, $this->Error());                             }
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
        function AlterField2($table, $column, $columnNew, $type, $null = true, $default = null) {              
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
        function AlterField($table, $column, $type, $null = true, $default = null) {             $columnNew = $column."_temp";
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
            if(is_null($value))
                return 'null';
            switch($field->type) {
                case 'timestamp':
                    if(is_null($value)) $value = time();
                    if(is_numeric($value)) $value = strftime("%Y-%m-%d %H:%M:%S", $value);
                    if($value == '0000-00-00 00:00:00') $value = '1970-01-01 00:00:00';
                    return "'".$value."'::timestamp";
                case 'date':
                    if(is_null($value)) $value = time();
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
            $ret->add("TEXT", "VARCHAR(255)");
            $ret->add("MEMO", "TEXT");
            $ret->add("HTML", "TEXT");
            $ret->add("BLOB", "BIGINT)");
            $ret->add("BLOB LIST", "TEXT");
            $ret->add("CHECK", "BOOLEAN");
            $ret->add("NUMERIC", "REAL");
            $ret->add("DATETIME", "DATE");
            $ret->add("FILE", "TEXT");
            $ret->add("FILE LIST", "TEXT");
            $ret->add("MULTISELECT", "TEXT");
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
?><?php
class mailtemplate extends collection {
	function mailtemplate() {
		parent::__construct();
	}
	public function apply($template) {
		$tmp = $template;
		for($i=0; $i < parent::count(); $i++) {
			$tmp = preg_replace("/".preg_quote(parent::key($i))."/", parent::item($i), $tmp);
					}
		return $tmp;
	}
}
?><?php
class Repository extends Collection  {
    static $cache;
    static $loaded;
	private $table;
	function Repository() {
		$this->table = sys_table("repository");
		parent::__construct();
        Repository::$loaded = new ArrayList();
	}
    static function Cache() {
        global $core;
        Repository::$cache = new Collection();
        $rs = $core->dbe->ExecuteReader("select * from sys_repository order by repository_name");
        while ($r = $rs->Read())
            Repository::$cache->add(strtolower($r->repository_name), $r);
    }
	static function Enum($field = "name") {
		global $core;
		$c = new Repository();
		$field = "repository_".$field;
        foreach(Repository::$cache as $r)
			$c->add(strtolower($r->$field), new Library($r));
		return $c;
	}    
						public static function Load($name) {
        if(is_null(Repository::$loaded)) Repository::$loaded = new ArrayList();
        if(Repository::$loaded->Exists(to_lower($name)))
            return;
        Repository::$loaded->Add(to_lower($name));
		$lib = new Library(Repository::$cache->$name);
		return $lib->Run();
	}
	public static function LoadBatch($names) {
		global $core;
        if(is_null(Repository::$loaded)) Repository::$loaded = new ArrayList();
		if(is_string($names)) {
			$nnn = new ArrayList();
			$nnn->FromString($names, ",");
		}
		else 
			$nnn = $names;
        foreach($nnn as $name) {
            if(!Repository::$loaded->Exists(to_lower($name))) {
                Repository::$loaded->Add(to_lower($name));
                $lib = new Library(Repository::$cache->$name);
                $lib->Run();
            }
        }
    }
	public static function URL($name, $querystring = null) {
		$lib = new Library($name);
		return $lib->Url($querystring);
	}	
	public static function Tag($name, $querystring = null) {
		$lib = new Library($name);
		return $lib->Tag($querystring);
	}	
	static function Get($id){
		return new library($id);
	}
	public function ToXML($criteria){ 		if (is_array($criteria)){
			$libs = new collection();
			foreach ($criteria as $crit)
				$libs->add($crit, new Library($crit));
		} else {
			$libs = Repository::Enum();
		}
		$ret = "<repository>";
		foreach ($libs as $lib)
			$ret .= $lib->ToXML();
		$ret .= "</repository>";
		return $ret;
	}
	public function FromXML($el){
		$childs = $el->childNodes;
		foreach ($childs as $pair){
			$lib = new Library();
			$lib->FromXML($pair);
			$lib->id = -1;
			$this->Add($lib->name, $lib);
		}
	}
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("interface.repository.add", "Add the repository"));
		$operations->Add(new Operation("interface.repository.delete", "Delete the repository"));
		$operations->Add(new Operation("interface.repository.edit", "Edit the repository"));
		return $operations;
	}
	public function Save() {
		foreach($this as $l)
			$l->Save();
	}
    public function ToPHPScript() {
        $code = '/* Dumping repository */'."\n\n";
        foreach($this as $lib) {
            $code .= $lib->ToPhpScript()."\n";
        }
        return $code;
    }
}
class Library extends Object {
	private $_table;
	function Library($data = null){
		global $core;
		$this->_table = sys_table("repository");
		if(is_null($data)) {
			parent::__construct(null, "repository_");
			return;
		}
		if (is_object($data)){
			parent::__construct($data, "repository_");
			return;
		}
		global $BLOB_VIEWER, $RS_LOADER;		
		if($data == "blob" && !is_null($BLOB_VIEWER)) {
			parent::__construct(null, "repository_");
			$this->id = 999;
			$this->name = "blob";
			$this->type = PHP_CODE;
			$this->code = @$core->fs->readfile(substr($BLOB_VIEWER,5), CORE);
		}		
		elseif($data == "runtime_style" && !is_null($RS_LOADER)) {
			parent::__construct(null, "repository_");
			$this->id = 1999;
			$this->name = "runtime_style";
			$this->type = HTML_CSS;
			$this->code = $core->fs->readfile(substr($RS_LOADER,5), CORE);
		}		
		else {
			if (is_numeric($data)){
                $row = Repository::$cache->Item(Repository::$cache->IndexOf($data, 'repository_id'));
			} else if (is_string($data)){
                $row = Repository::$cache->$data;
			} else {
				parent::__construct(null, "repository_");
				return;
			}
			if (!$row) {
				parent::__construct(null, "repository_");
				return;
			}
			parent::__construct($row, "repository_");
		}
	}
	function Process() {
		$lastmodified = $this->datemodified;
		if(!$lastmodified)
			$lastmodified = time()+1;
		$etag = '"'.md5($this->name."?".$_SERVER["QUERY_STRING"]).'"';
		if(!modified_since($lastmodified)) {
			header("HTTP/1.0 304 Not Modified");
			header("Content-Length: 0");
			header("ETag: {$etag}");
			return;
		}
		$body = $this->Run(true);
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastmodified)." GMT");
		header("Expires: ".gmdate("D, d M Y H:i:s", $lastmodified + 86400)." GMT");
		header("Cache-Control: post-check=0, pre-check=0, must-revalidate, public");
				header("Content-Length: ".strlen($body) + 3);
		header("ETag: {$etag}");
		header("Pragma: !invalid");
		echo $body;
        exit;
	}
	function is_valid() {
		return count($this->ToArray()) > 0;
	}
	function __get($key){
		global $core;
		if($key == "ext") {
			switch($this->type) {
				case PHP_CODE: return "php";
				case HTML_SCRIPT: return "js";
				case HTML_CSS: return "css";
				case HTML_XSLT: return "xslt";
				case HTML_XML: return "xml";
				default:
					return "php";
			}
		} else if($key == "datemodified") {
			if(substr($this->code, 0, 9) == "LOADFILE:") {
				$datemodified = $core->fs->FileLastModified(strtolower(substr($this->code, 9, strlen($this->code))));
				$this->datemodified = db_datetime($datemodified);
				$this->Save(false);
			}
			else  {
                if(property_exists($this->_data, "repository_datemodified"))
				    $datemodified = strtotime($this->_data->repository_datemodified);
                else
                    $datemodified = false;
            }
			return $datemodified;
		} if($key == "cacheexpired") { 			if($this->CacheExists())
				return $this->datemodified >= $core->fs->FileLastModified($this->CacheName());
			else
				return true;
		} else if($key == 'isValid') {
            return !is_null($this->id);
        }
		return parent::__get($key);
	}
    public static function Create($name, $type, $code, $datemodified = null) {
        $l = new Library();
        $l->name = $name;
        $l->type = $type;
        $l->code = $code;
        $l->datemodified = db_datetime(is_null($datemodified) ? time() : $datemodified);
        $l->Save();
        return $l;
    }
	public function Save($changeMod = true){
		global $core;
		if($changeMod)
			$this->datemodified = db_datetime(time());
		$data = $this->ToCollection();
		$data->Delete("repository_id");
        $data->repository_name = strtolower($data->repository_name);
		if(is_empty($this->id) || $this->id == -1)
			$this->id = $core->dbe->insert($this->_table, $data);
		else {
			$core->dbe->set($this->_table, "repository_id", $this->id, $data);
		}
                $core->fs->DeleteFile('/_system/_cache/code/'.md5('library_'.$this->id."_".$this->name).'.php', SITE);
	}
	public function Run($tofile = false, $addheader = true){
		global $core;
		if (is_null($this->_data))
			return "";
		$ret = "";
        $context = new OutputContext($this->name);
		switch($this->type) {
			case PHP_CODE:
				if($this->code != "") {                         
                    $code = code_cache('/_system/_cache/code/'.md5('library_'.$this->id."_".$this->name).'.php', $this->code);       
										eval($code);
				}
				break;
			case HTML_CSS:
				if($tofile) {
					if($this->code != "") {    
						$code = "<".'?'."\n".($addheader ? 'header("content-type: text/css; charset=utf-8", false);' : '').' $context = new OutputContext("'.$this->name.'"); '."\n".'?'.'>'.load_from_file($this->code);
						$code = convert_php_context($code);
						eval($code);                       
					}
				}
				else {
					if(!function_exists($this->name)) {    
						$code = "function ".$this->name."(\$args) {\n\$ret = <<<FUNCT\n\n<style type=text/css>\n";
						$code .= load_from_file($this->code);
						$code .= "\n</style>\n\nFUNCT;\n\nreturn \$ret;\n}\n";
						eval($code);
					}				
				}
				break;
			case HTML_XML:
				if($tofile) {
					if($this->code != "") {
						$code = "<".'?'."\n".($addheader ? 'header("content-type: text/xml; charset=utf-8", false);' : '').' $context = new OutputContext("'.$this->name.'"); $context->Out("<'.'?xml version=\'1.0\' encoding=\'utf-8\' standalone=\'yes\' ?".'.'">");'."\n".'?'.'>'.load_from_file($this->code);
						$code = convert_php_context($code);
						eval($code);
					}
				}
				break;
			case HTML_SCRIPT:
				if($tofile) {
					$code = "<"."?\n".($addheader ? 'header("Content-Type: text/javascript; charset=utf-8");' : '').' $context = new OutputContext("'.$this->name.'"); '."\n?".">".load_from_file($this->code);
					$code = convert_php_context($code);
					eval($code);
				}
				else {
					if(!function_exists($this->name)) {
						$code = "function ".$this->name."(\$args) {\n\$ret = <<<FUNCT\n\n<script language=javascript type=text/javascript>\n";
						$code .= load_from_file($this->code);
						$code .= "\n</script>\n\nFUNCT;\n\nreturn \$ret;\n}\n";
						eval($code);
					}				
				}
				break;
			case HTML_XSLT:
				break;
		}
		return ($context->empty ? $ret : $context->content);
	}
	public function CacheExists() {
		global $core;
		return $core->fs->FileExists($this->CacheName());
	}
	public function Cache() {
		global $core;
		$core->fs->WriteFile($this->CacheName(), $this->Run(true, false));
	}
	public function CacheName() {
		global $core;
		$path = "/_system/_cache/repository/";
		if(!$core->fs->DirExists($path))
			$core->fs->CreateDir($path);
		if($this->type != PHP_CODE)
			return $path.to_lower($this->name.".".$this->ext);
		return "";
	}
	public function Tag($querystring = null) {
		switch($this->type) {
			case PHP_CODE:
				return '';
			case HTML_CSS:
				return '<link rel="stylesheet" type="text/css" href="'.$this->Url($querystring).'" />'."\n";
			case HTML_SCRIPT:
				return '<script type="text/javascript" src="'.$this->Url($querystring).'"></script>'."\n";
			default: 
				return '';
		}
	}
	public function Url($querystring = null) {
		global $core, $SERVICE_MODE;
        if($SERVICE_MODE == 'developing')
            return '/'.$this->name.'.php';
		switch($this->type) {
			case PHP_CODE:
				$rule = $core->sts->USE_MOD_REWRITE;
				if($rule == "") {
					if($querystring != null)
						$rule = "/?fr=%s&%s";
					else
						$rule = "/?fr=%s";
				}
				else {
					if($querystring != null)
						$rule = "/%s.php?%s";
					else
						$rule = "/%s.php";
				}
				if($querystring != null)
					return sprintf($rule, $this->name, $querystring);
				else
					return sprintf($rule, $this->name);
				break;
			default:
				if($querystring != null) {
					$rule = $core->sts->USE_MOD_REWRITE;
					if($rule == "") {
						if($querystring != null)
							$rule = "/?fr=%s&%s";
						else
							$rule = "/?fr=%s";
					}
					return sprintf($rule, $this->name, $querystring);
				}
				else {
					if($this->cacheexpired)
						$this->Cache();
					return $this->CacheName();
				}
				break;
		}
		return "";
	}
	public function Delete() {
		global $core;
		return $core->dbe->delete("sys_repository", "repository_name", $this->name);
	}
	public function ToXML(){
		return parent::ToXML("library", array(), array("code"), array("id"));
	}
    public function ToPHPScript() {
        return '
            /* Dumping library '.$this->name.' */
            $l = new Library("'.$this->name.'");
            if($l->isValid) 
                $l->Delete();
            Library::Create("'.$this->name.'", "'.$this->type.'", hex2bin("'.bin2hex(load_from_file($this->code)).'"), "'.$this->datemodified.'");
        ';
    }
}
class DesignTemplate extends Object {
    public function __construct($dt = null) {
        if(!is_object($dt) && !is_null($dt)) {
            global $core;
            $dtt = $core->dbe->ExecuteReader('select * from sys_templates where '.(is_numeric($dt) ? 'templates_id' : 'templates_name')." = '".strtolower($dt)."'");
            if($dtt->Count() == 0)
                trigger_error('can not find a design template by key');
            $dt = $dtt->Read();
        }
        parent::__construct($dt, "templates_");
    }
    public static function Create($name, $head, $body, $repositories, $title, $keywords, $description, $baseurl, $styles, $scripts, $additional, $doctype) { 
                $d = new DesignTemplate();
        $d->name = strtolower($name);
        $d->head = $head;
        $d->body = $body;
        $d->repositories = $repositories;
        $d->html_doctype = $doctype;
        $d->head_title = $title;
        $d->head_metakeywords = $keywords;
        $d->head_metadescription = $description;
        $d->head_baseurl = $baseurl;
        $d->head_styles = $styles;
        $d->head_scripts = $scripts;
        $d->head_aditionaltags = $additional;
        $d->Save();
        return $d;
    }
    public function Save() {
        global $core;
        $data = $this->ToCollection();
        $data->Delete("templates_id");
        $data->templates_name = strtolower($data->templates_name);
        if(!is_null($this->id))
            $core->dbe->set(sys_table('templates'), "templates_id", $this->id, $data);
        else
            $this->id = $core->dbe->insert(sys_table('templates'), $data); 
                @$core->fs->DeleteFile('/_system/_cache/code/'.md5('designtemplate'."_".strval($template->id)).'.php', SITE);
    }
    public function Delete() {
        global $core;
        return $core->dbe->delete(sys_table('templates'), "templates_id", $this->id);
    }
    public function ToPHPScript() {
        return '
            /* Dumping design template '.$this->name.' */
            $bkeepid = '.$this->id.';
            $d = new DesignTemplate("'.$this->name.'");
            if($d->isValid) $d->Delete();
            $'.$this->name.' = DesignTemplate::Create("'.$this->name.'", hex2bin("'.bin2hex($this->head).'"), hex2bin("'.bin2hex(load_from_file($this->body)).'"), "'.$this->repositories.'", hex2bin("'.bin2hex($this->head_title).'"), hex2bin("'.bin2hex($this->head_metakeywords).'"), hex2bin("'.bin2hex($this->head_metadescription).'"), hex2bin("'.bin2hex($this->head_baseurl).'"), hex2bin("'.bin2hex($this->head_styles).'"), hex2bin("'.bin2hex($this->head_scripts).'"), hex2bin("'.bin2hex($this->head_aditionaltags).'"), hex2bin("'.bin2hex($this->html_doctype).'"));
            $core->dbe->Update("sys_templates", "templates_id", $'.$this->name.'->id, Collection::Create("templates_id", $bkeepid), true);
        ';
    }
    public function __get($prop) {
        switch($prop) {
            case 'isValid':
                return !is_null($this->id);
        }
        return parent::__get($prop);
    }
}                        
class DesignTemplates extends IEventDispatcher  {
	private $table;
	function designTemplates() {
		$this->table = sys_table("templates");
	}
	function enum() {
		global $core;
        return $core->dbe->ExecuteReader("select * from ".$this->table);
	}
	function get_collection() {
		$ret = new collection();
		$rr = $this->enum();
		while($design = $rr->Read()) {
			$ret->add($design->templates_name, collection::create($design));
		}
		return $ret;
	}
	function from_id($tid) {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from ".$this->table." where templates_id=".$tid);
		return $r->Read();
	}
	function save($name, $data) {
		global $core;
		return $core->dbe->set($this->table, "templates_name", $name, $data);
	}
	function delete($name) {
		global $core;
		return $core->dbe->delete($this->table, "templates_name", $name);
	}
	function create($data) {
		global $core;
		return $core->dbe->insert($this->table, $data);
	}
	function run($name, $args) {
		global $core;
		if(is_numeric($name))
			$name = $this->from_id($name)->templates_name;
		$r = $this->enum();
		$r->disconnect();
		$template = $r->item($name);
		$ret = "";
		eval($template->head);
		eval($template->body);
		return $ret;
	}
	public static function apply($name, $args) {
		global $core;
		global $runtimeStyles;
		global $context;
        $context = new OutputContext($name);
        $runtimeStyles = new Collection();
        $dt = new designTemplates();
        $template = new DesignTemplate($name);
		$site = $args->site;
		$folder = $args->folder;
				$code = "";
		$code .= "\$context->Out(\"".addslashes($template->html_doctype)."\n\");\n";
		$code .= "\$context->Out(\"<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\">\n<head>\n\");\n";
		$code .= $dt->combine_libs($dt, $context, $template, $args->site, $args->folder);
		$code .= "\$context->StartBlockOutput(\"header\");\n";
		$code .= $dt->combine_header($dt, $context, $template, $args->site, $args->folder);
		$code .= "\$context->EndBlockOutput();\n";
		$code .= "\$context->Out(\"\n\n</head>\n\");\n";
		$code .= "\$context->Out(\"<body>\");\n";
		$code .= $dt->combine_html($dt, $context, $template, $args->site, $args->folder);
		$code .= "\$context->Out(\"\n</body>\n</html>\");\n"; 		
		eval($code);
		if($runtimeStyles->Count() > 0) {
			$styles = "";
			foreach($runtimeStyles as $style) {
				$styles .= ",".$style;
			}
			$context->Out('<link href="/runtime_style.php?location='.substr($styles, 1).'" rel="stylesheet" type="text/css" />'."\n", "header");
		}
		return $context->content;
	}
	private function combine_libs($dt, $context, $template, $site, $folder){
		$code = "";
		$code .= "\$dt->DispatchEvent(\"design.libraries.loading\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		if(!is_empty($template->repositories))
			$code .= "Repository::LoadBatch(\"".trim($template->repositories)."\");\n";
		$code .= "\$dt->DispatchEvent(\"design.libraries.loaded\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		return $code;
	}
	private function combine_header($dt, $context, $template, $site, $folder){
		$code = "";
		$code .= "\$dt->DispatchEvent(\"design.header.rendering\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
        $code .= convert_php_context('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'); 		$code .= convert_php_context($template->head); 		
		$code .= "if(\$template->head_title != \"\") {\n";
			$code .= "\$context->Out(\"\n\t\t<title>\");";
			$code .= "eval(convert_php_context(\$template->head_title));";
			$code .= "\$context->Out(\"</title>\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_metakeywords != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<meta name=\\\"Keywords\\\" content=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_metakeywords));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_metadescription != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<meta name=\\\"description\\\" content=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_metadescription));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_shortcuticon != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<link rel=\\\"shortcut icon\\\" href=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_shortcuticon));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_baseurl != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<base href=\\\"\");";
			$code .= "eval(convert_php_context(\$template->head_baseur));";
			$code .= "\$context->Out(\"\\\" />\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_styles != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<style type=\\\"text/css\\\">\");";
			$code .= "eval(convert_php_context(\$template->head_styles));";
			$code .= "\$context->Out(\"</style>\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_scripts != \"\") {\n";
			$code .= "\$context->Out(\"\t\t<script language=\\\"javascript\\\">\");";
			$code .= "eval(convert_php_context(\$template->head_scripts));";
			$code .= "\$context->Out(\"</script>\n\");\n";
		$code .= "}\n";
		$code .= "if(\$template->head_aditionaltags != \"\") {\n";
			$code .= "eval(convert_php_context(\$template->head_aditionaltags));";
		$code .= "}\n";
		$code .= "\$dt->DispatchEvent(\"design.header.rendered\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		return $code;
	}
	public function combine_html($dt, $context, $template, $site, $folder) {
		global $core;
		$code = "";
		$code .= "\$dt->DispatchEvent(\"design.body.rendering\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
        $code .= code_cache('/_system/_cache/code/'.md5('designtemplate'."_".strval($template->id)).'.php', $template->body);
		$code .= "\$dt->DispatchEvent(\"design.body.rendered\", Hashtable::Create(\"template\", \$template, \"site\", \$site, \"folder\", \$folder));\n";
		return $code;
	}
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("interface.designes.add", "Add the design template"));
		$operations->Add(new Operation("interface.designes.delete", "Delete the design template"));
		$operations->Add(new Operation("interface.designes.edit", "Edit the design template"));
		return $operations;
	}
    public function ToPHPScript() {
        $ret = '/* Dumping design templates */'."\n\n";
        $rps = new designTemplates();
        $rps = $rps->enum();
        while($d = $rps->FetchNext()) {
            $dd = new DesignTemplate($d);
            $ret .= $dd->ToPHPScript();
        }
        return $ret;
    }
}
?>
<?php
class TemplateCache {
	static $db;
	static $path;
	static $table;
	static $enabled;
	private $_data;
	private $_etag;
	private $_modified;
	private $_cachename;
	private $_cached;
	private $_content;
	private $_template;
	private $_params;
	private $_operation;
	public function __construct($template, $data, $params, $operation) {
		global $core;
		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_ENABLED"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_ENABLED", "check", "false", null, true, "System template cache settings"));
		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_DB"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_DB", "check", "false", null, true, "System template cache settings"));
		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_PATH"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_PATH", "text", "/_system/_cache/templates/", null, true, "System template cache settings"));
		if(!$core->sts->Exists("SETTING_TEMPLATECACHE_TABLE"))
			$core->sts->Add(new Setting("SETTING_TEMPLATECACHE_TABLE", "text", "sys_template_cache", null, true, "System template cache settings"));
		if($core->sts->SETTING_TEMPLATECACHE_DB == "true") {
			if(!$core->dbe->tableexists($core->sts->SETTING_TEMPLATECACHE_TABLE)) {
                $core->dbe->CreateTable('sys_template_cache', array(
                      'hash' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                      'datemodified' => array('type' => 'datetime', 'additional' => ' default NULL'),
                      'cache' => array('type' => 'longtext', 'additional' => '')
                ), array(
                    'sys_template_cache_hash' => array('fields' => 'hash', 'constraint' => 'PRIMARY KEY')
                ), '');
			}
		}
		if(is_null(TemplateCache::$enabled))
			TemplateCache::$enabled = $core->sts->SETTING_TEMPLATECACHE_ENABLED == "true" ? true : false;
		if(is_null(TemplateCache::$path))
			TemplateCache::$path = $core->sts->SETTING_TEMPLATECACHE_PATH;
		if(is_null(TemplateCache::$table))
			TemplateCache::$table = $core->sts->SETTING_TEMPLATECACHE_TABLE;
		if(is_null(TemplateCache::$db))
			TemplateCache::$db = $core->sts->SETTING_TEMPLATECACHE_DB;
		if(TemplateCache::$db != "true") {
			if(!$core->fs->DirExists(TemplateCache::$path)) {
				$core->fs->CreateDir(TemplateCache::$path);
			}
		}		
		$this->_data = $data;
		$this->_template = $template;
		$this->_params = $params;
		$this->_operation = $operation;
		$this->LoadInfo();
	}
	public function LoadInfo() {
		global $core;
		$dt = $this->_data;
		if($dt instanceOf Publication)
			$dt = is_null($dt->datarow) ? $dt->module : $dt->datarow;
		$this->_etag = md5(
				$this->_template->id."_".
				$this->_data->id."_".
				$dt->id."_".
				CleanCacheFromURL()
			);
		$cf = $core->nav->folder;
		$this->_cachename = TemplateCache::$path.'/'.$this->_etag.'.cache';
		if(TemplateCache::$db == "true") {
			$rs = $core->dbe->ExecuteReader("select * from ".TemplateCache::$table." where hash='".$this->_etag."'");
			$this->_exists = ($rs->Count() > 0);
			if($this->_data instanceOf Publication)
				$this->_modified = strtotime($this->_data->modifieddate);
			else
				$this->_modified = strtotime($cf->datemodified);
			if($this->_exists) {
				$row = $rs->Read();
				$this->_cached = strtotime($row->datemodified);
				$this->_content = $row->cache;
			}
			else { 
				$this->_cached = 0;
				$this->_content = null;
			}
		}
		else {
			$this->_exists = $core->fs->FileExists($this->_cachename);
			if($this->_data instanceOf Publication)
				$this->_modified = strtotime($this->_data->modifieddate);
			else
				$this->_modified = strtotime($cf->datemodified);
			if($this->_exists)
				$this->_cached = $core->fs->FileLastModified($this->_cachename);
			else 
				$this->_cached = 0;
		}
		if(!is_empty($this->_template->cachecheck)) {
			$arr = explode(",", $this->_template->cachecheck);
			foreach($arr as $f) {
				$f = Site::Fetch($f);
				if($this->_modified < strtotime($f->datemodified))
					$this->_modified = strtotime($f->datemodified);
			}
		}
	}
	private function _getContent() {
		global $core;
		if(TemplateCache::$db == "true") { 
			return $this->_content;
		}
		else {
			return $core->fs->ReadFile($this->_cachename);
		}
	}
	public function Process() {
		global $core;
		if(!TemplateCache::$enabled)
			return $this->_template->Render($this->_operation, $this->_data, $this->_params);
		$isGet = isset($_GET['recache']);
		if($this->_cached < $this->_modified || $isGet) {
						$body = $this->_template->Render($this->_operation, $this->_data, $this->_params);
			if(TemplateCache::$db == "true") {
				$data = Hashtable::Create("hash", $this->_etag, "datemodified", strftime("%Y-%m-%d %H:%M:%S", time()), "cache", $body);
				if($this->_exists) {
					$core->dbe->Update(TemplateCache::$table, "hash", $this->_etag, $data);
				}
				else {
					$core->dbe->Insert(TemplateCache::$table, $data);
				}
			}
			else {
				$core->fs->DeleteFile($this->_cachename);
				$core->fs->WriteFile($this->_cachename, $body);
			}
			return $body;
		}
		else {
						return $this->_getContent();
		}		
	}
}
class Template extends Object {
	private $_pref;
	private $_storage;
	private $_cname;
	private $_subitems;
	private $_list = null;
	public function __construct($data = null, $type = TEMPLATE_STORAGE, $storage = null, $list = null) {
		$this->_pref = $type;
		$this->_storage = $storage;
		$this->_list = $list;
		$this->_cname = "";
		parent::__construct($data, $this->_pref."_templates_");
		$this->RegisterEvent("template.create");
		$this->RegisterEvent("template.saveing");
		$this->RegisterEvent("template.saved");
		$this->RegisterEvent("template.deleting");
		$this->RegisterEvent("template.deleted");
		$this->RegisterEvent("template.rendering");
		$this->RegisterEvent("template.rendered");
		$this->RegisterEvent("template.getbody");		
		$this->RegisterEvent("template.body.convertion");
		$this->RegisterEvent("template.body.converted");
		$this->RegisterEvent("template.standart.rendering");
		$this->RegisterEvent("template.standart.rendered");
		$this->RegisterEvent("template.module.rendering");
		$this->RegisterEvent("template.module.rendered");
		$this->RegisterEvent("template.standart.field.rendering");
		$this->RegisterEvent("template.standart.field.rendered");
		$this->DispatchEvent("template.create", Hashtable::Create());
	}
	public static function Create($name, $storage = null) {
		if($storage instanceof CModule)
			$type = TEMPLATE_MODULE;
		else {
			if(!($storage instanceof storage))
				$storage = storages::get($storage);
			$type = TEMPLATE_STORAGE;
		}
		$t = new Templates($storage, $type);
				$n = $name == "" ? TEMPLATE_DEFAULT : $name;
		if($t->Exists($n))
			return $t->Item($n);
		else
			return new Template(null, $type, $storage);
	}
    public static function CreateTemplate($storage, $type, $name, $description, $composite, $list, $styles, $properties, $cache, $cachecheck) {
        $t = new Template(null, $type, $storage);
        $t->name = strtolower($name);
        $t->description = $description;
        $t->list = html_entity_decode($list, HTML_ENTITIES, "utf-8");
        $t->properties = $properties;
        $t->styles = $styles;
        $t->composite = ($composite ? 1 : 0);
        $t->cache = ($cache ? 1 : 0);
        $t->cachecheck = $cachecheck;
        $t->Save();
        return $t;
    }
	public static function FromId($id, $type) {
		global $core;
		$table = "sys_".$type."_templates";
		$idd = $type."_templates_id";
		$sname = $type."_templates_".$type."_id";
		$rs = $core->dbe->ExecuteReader("select * from ".$table." where ".$idd."='".$id."'");
		if($rs->count() > 0){
			$r = $rs->Read();
			if($type == TEMPLATE_STORAGE)
				return new Template($r, $type, storages::get($r->$sname));
			else
				return new Template($r, $type, new CModule($r->$sname));
		}
	}
	public function Storage() {
		return $this->_storage;
	}
	public function Data() {
		return $this->_data;
	}
	public function get_collection($loadFiles = true) {
		$d = clone $this->_data;
		if($loadFiles) {
			$lname = $this->_pref."_templates_list";
			$d->$lname = $this->getBody();
		}
		return collection::create($d);
	}
	public function __get($field) {
		$f = $this->_pref."_templates_".$field;
		return @$this->_data->$f;
	}
	public function __set($field, $value) {
		$f = $this->_pref."_templates_".$field;
		@$this->_data->$f = $value;
	}
	public function Save() {
		global $core;
		$args = $this->DispatchEvent("template.saveing", Hashtable::Create());
		if(@$args->cancel === true)
			return $this->id;
		$tp = $this->_pref."_id";
		$this->$tp = $this->_storage->id;
		$c = $this->get_collection(false);
		$idname = $this->_pref."_templates_id";
        $namename = $this->_pref."_templates_name";
        $c->$namename = strtolower($c->$namename);
                $core->fs->DeleteFile('/_system/_cache/code/'.md5($this->_pref."_".strval($this->_storage->id)."_".strval($this->id)).'.php', SITE);
		$id = $c->$idname;
		$c->Delete($idname);
		if($id == -1 || is_empty($id)){
			$id = $core->dbe->insert("sys_".$this->_pref."_templates", $c);
		} else {
			$core->dbe->set("sys_".$this->_pref."_templates", $this->_pref."_templates_id", $id, $c);
		}
		$this->id = $id;
		if(!is_null($this->_list)) {
			$this->_list->setModified();
		}
		$this->DispatchEvent("template.saved", Hashtable::Create());
		return $id;
	}
	public function Delete() {
		global $core;
		$args = $this->DispatchEvent("template.deleting", Hashtable::Create());
		if(@$args->cancel === true)
			return ;
		$core->dbe->delete("sys_".$this->_pref."_templates", $this->_pref."_templates_id", $this->id);
		if(!is_null($this->_list)) {
			$this->_list->setModified();
		}
		$this->DispatchEvent("template.deleted", Hashtable::Create());
	}
	public function SubTemplates() {
		if(is_null($this->_subitems)) {
			$body = $this->list;
			$s = new Hashtable();
			$s->FromString($body, "\n", ":");
			$this->_subitems = new Hashtable();
			$ppp = new Templates($this->_storage, $this->_pref);
			foreach($s as $k => $v) {
				$vv = $ppp->item(trim($v, "\r"));
				if(!is_null($vv) && $vv !== false)
					$this->_subitems->Add(strtolower($k), $vv);
			}
		}
		return $this->_subitems;
	}
    public function IsInFile() { return substr($this->list, 0, 9) == "LOADFILE:"; }
	public function getBody() {
		global $core;
		$args = $this->DispatchEvent("template.body.convertion", Hashtable::Create("body", $this->list));
		if(@$args->cancel === true)
			return @$args->body;
		        $body = code_cache('/_system/_cache/code/'.md5($this->_pref."_".strval($this->_storage->id)."_".strval($this->id)).'.php', $this->list);
		$args = $this->DispatchEvent("template.body.converted", Hashtable::Create("body", $body));
		if(@$args->apply === true)
			$body = @$args->body;
		return $body;
	}
	public static function getText($text = "toolbar_browse_publications_info", $id = null, $storage = "", $creationdate = null, $templates = null, $publication = null, $template = null) {
		global $postback;
		$uniq = "unique: %s, created: %s, template: %s";
		if(!is_null($postback))
			$uniq = $postback->lang->$text;
		if(!is_null($template)) {
			$args = $template->DispatchEvent("template.gettext", Hashtable::Create("text", $uniq, "id", $id, "storage", $storage, "creationdate", $creationdate, "templates", $templates, "publication", $publication));
			if(@$args->cancel === true)
				return @$args->text;
		}
		return sprintf($uniq, $id, $storage, $creationdate, $templates);
	}
	public function Out($operation = OPERATION_LIST, $data = null, $params = null) {
		global $core;
		$args = $this->DispatchEvent("template.rendering", Hashtable::Create("operation", $operation, "data", $data, "params", $params));
		if(@$args->cancel === true)
			return @$args->output;
		if($operation == OPERATION_ADMIN)
			return $this->ActiveOut($data, $params);
		if($this->_pref == TEMPLATE_STORAGE && (int)$this->composite === 1) {
			$subs = $this->SubTemplates();
			$ctempl = $subs->$operation;			
			if($ctempl === false)
				$ctempl = $subs->list;
			if ($ctempl == false)
				return;
			return $ctempl->Out($operation, $data, $params);
		}
				global $runtimeStyles;
		if(!is_null($runtimeStyles) && $this->id && !is_empty($this->styles))
			$runtimeStyles->Add($this->_pref.".".$this->_storage->id.".".$this->id, $this->_pref.".".$this->_storage->id.".".$this->id);
		$body = "";
		if($this->cache) {
			$tc = new TemplateCache($this, $data, $params, $operation);
			$content = $tc->Process();
		}
		else 
			$content = $this->Render($operation, $data, $params);
					return $content;
		return "";
	}
	public function Render($operation = OPERATION_LIST, $data = null, $params = null) { 
		global $core;
		global $gfolder;
		global $site;
		$folder = null;
		if(!is_null($core->nav->folder)) 
			$folder = $core->nav->folder;
        else
            $folder = $site;
		$this->_cname = $this->_pref."_".strval($this->_storage->id)."_".strval($this->id);
		$context = new OutputContext($this->_cname);
		$args = hashtable::create(
            "template", $this, 
            "folder", $folder, 
            "site", $site, 
            "userparams", is_null($params) ? new Hashtable() : $params
        );
		if($data instanceof Publication) {
			$args->Add("publication", $data);
			$this->_cname .= "_".$data->id;
			if (is_null($data->datarow)){
				$entry = $data->module->entry;
				if ($core->mm->activemodules->Exists($entry))
					$args->Add("module", $core->mm->activemodules->$entry);
				else
					$args->Add("module", $data->module);
			} else
				$args->Add("datarow", $data->datarow);
		}
		else if($data instanceof CModule) {
			$this->_cname .= "_".$data->id;
			$args->Add("module", $data);
		}
		else {
			$this->_cname .= "_".$data->id;
			$args->Add("datarow", $data);
		}
		$body = $this->getBody();
		$retargs = $this->DispatchEvent("template.getbody", Hashtable::Create("template", $this, "type", $this->_pref, "operation", $operation, "data", $data, "params", $params, "body", $body));
		if(@$retargs->apply === true)
			$body = $retargs->body;
		if(!is_empty($body)) {
            eval($body);
                        		}
		$args = $this->DispatchEvent("template.rendered", Hashtable::Create("template", $this, "type", $this->_pref, "operation", $operation, "data", $data, "params", $params, "context", $context));
		if(@$args->apply === true) {
			$context->Clear();
			$context->Out($args->output);
		}
		$c = $context->content;
		unset($context);
		return $c;
	}
	private function ActiveOut($data = null, $params = null, $recursioncheck = null) {
		if(!is_null($params)) {
			if(@$params->Exists("admin_checkboxes") && @$params->admin_checkboxes === false) {
				$v = null;
				if($data instanceof Publication)
					$v = (is_null($data->module)) ? $data->datarow : $data->module;
				return $this->StandartOut(is_null($v) ? $data : $v, !is_null($v) ? $v : null);
			}
		}
		if($data instanceof Publication) {
			$rr = "";
			$rr .= "<table class='admin-template' style='border-bottom:1px solid #c0c0c0' cellpadding=4><tr>";
			$rr .= "<td class='unique' style='background-color: ".$this->Storage()->color.";' colspan=2>".Template::getText("toolbar_browse_publications_info", $data->id, (is_null($data->module) ? $data->datarow->storage->name : $data->module->title), std_hformat_date($data->creationdate, "d.m.Y H:i:s"), Templates::Visualize($data, $params), $data, $this)."</td></tr>
			<tr onclick='javascript: setRowCheck(this);' id='data".$data->id."'><td style='width: 100%'>";
			$v = (is_null($data->module)) ? $data->datarow : $data->module;
			$rr .= $this->StandartOut($v, $data, $recursioncheck); 			$rr .= "</td><td class='checkbox'><input type=checkbox name=template_operation_id_".$data->id." value=".$data->id." class=checkbox hilitable=1></td></tr></table>";
		} 
		else {
			$rr = "";
			$rr .= "<table width='100%' class='admin-template' style='border-bottom:1px solid #c0c0c0' cellpadding='4'><tr><td><tr onclick='javascript: setRowCheck(this);' id='data".$data->id."'><td style='width: 100%;".($data->storage && $data->storage->istree ? 'padding-left: '.(($data->level-1) * 20).'px;' : '')."'>";
			$rr .= $this->StandartOut($data, null, $recursioncheck);
			$rr .= "</td><td valign='middle' width='20'><input type='checkbox' name='template_operation_id_".$data->id."' value='".$data->id."' class='checkbox' hilitable='1'></td></tr></table>";
		}
		return $rr;		
	}
	private function StandartOut($data, $pub = null, $recursioncheck = null) {
		global $core;
		$args = $this->DispatchEvent("template.standart.rendering", Hashtable::Create("data", $data, "publication", $pub));
		if(@$args->cancel === true)
			return $args->output;
		$ret = "";
		if ($this->_storage instanceof CModule){
			$args = $this->DispatchEvent("template.module.rendering", Hashtable::Create("data", $data, "publication", $pub));
			if(@$args->cancel === true)
				return @$args->output;
			$ret = "<table cellpadding=0 cellspacing=2 border=0 class='template-content-table'>";
			$ret .= "<tr>";
			$ret .= "<td class='template-value'><b>".$this->_storage->title." (".$this->_storage->version.")"."</b><br>".$this->_storage->description."</td>";
			$ret .= "</tr>";
			$ret .= "</table>";
			$args = $this->DispatchEvent("template.module.rendered", Hashtable::Create("output", $ret, "data", $data, "publication", $pub));
			if(@$args->cancel === true)
				$ret = @$args->output;
			return $ret;
		}
		$folders = "";
		if(method_exists($data, "Publications")) {
			$pubs = $data->Publications();
			if($pubs->Count() > 0) {
                $ff = array();
				foreach($pubs as $p) {
					$f = $p->FindFolder();
                    if(is_null(@$ff[$f->description]))
                        $ff[$f->description] = "";
                    $ff[$f->description] .= ",".$p->id;
				}
                foreach($ff as $f => $ps) {
                    $folders .= ",".$f."[".substr($ps, 1)."]";
                }
                $folders = substr($folders, 1);
			}
		}
		$ret .= "<table cellpadding=0 cellspacing=2 border=0 class='template-content-table'>";
		$ret .= "<tr>";
		$ret .= "<td class='template-field'>".Template::getText("toolbar_stoarge_data_id").":</td>";
		$ret .= "<td class='template-value'><strong>".$data->id." (".Template::getText("toolbar_stoarge_data_datecreated").": ".std_hformat_date($data->datecreated, "d.m.Y H:i:s").(!is_empty($folders) ? ",".Template::getText("toolbar_stoarge_data_publishedto").":&nbsp;".$folders : "").(@$data->storage->istree ? ", ".Template::getText("toolbar_stoarge_node_level").": ".@$data->level : "").")"."</strong></td>";
        $ret .= "</tr>";
		$fields = $this->_storage->fields;
		$i=0;
		foreach($fields as $field) {
			$args = $this->DispatchEvent("template.standart.field.rendering", Hashtable::Create("field", $field, "data", $data));
			if(!(@$args->cancel === true)) {
				if($field->showintemplate == 0)
					continue;
				$fname = $field->field;
				$fld = $field->name;
				$val = $data->$fname;
				if($field->lookup != "")
					$val = $this->ImplodeLookup($field, $val, $data);
				else if($field->onetomany != "" && $field->onetomany != "0")			
					$val = $this->ImplodeOneToMany($this->_storage, $field, $val, $data->id, $pub, $recursioncheck);
				else if($field->values != "")
					$val = $this->ImplodeValues($field, $val);
				else {
					switch(strtolower($field->type)) {
						case "text":
							$val = html_strip($val);
							break;
						case "file":
							$v = $val;
							if(!($v instanceof FileView))
								$v = new FileView($v);
                            if($v->isValid) {
							    $src = $v->Src();
                                $filename = basename($src);
                                $size = size_to_string($core->fs->FileSize($src));
							    $v = '<a target="_blank" href="'.$src.'"><img src="'.$v->mimetype->icon.'" style="border: 0px;"></a>';
							    $val = '<table><tr><td>'.$v.'</td><td><b>File: </b>'.$filename.'<br /><b>Path: </b>'.$src.'<br/><b>Size:</b> '.$size.'</td></tr></table>';
                            }
                            else {
                                $val = "";
                            }
							break;
						case "numeric":
						case "datetime": {
							$val = $val;
							break;
						}
						case "memo": {
							if($field->onetomany == "" || $field->onetomany == "0")
								$val =  wordwrap(FirstNWords(htmlentities($val, HTML_ENTITIES, "utf-8"), 50), 70, "<br>");
							break;
						}
						case "html": {
							$val = wordwrap(FirstNWords(htmlentities($val, HTML_ENTITIES, "utf-8"), 50), 70, "<br>");
							break;
						}
						case "check": {
							$val = ($val == 1 ? "checked" : "unchecked");
							break;
						}
						case "blob": {
							if($val)
								$val = $val->img(new Size(100, 75));
							else
								$val = "";
							break;
						}
						case "blob list": {
							if(!($val instanceof Bloblist))
								$val = new BlobList($val);
							$val = $this->ImplodeBlobList($this->_storage, $field, $val, $data->id, $pub, $recursioncheck);
							break;
						}
						case "file list": 
							if(!($val instanceof Filelist))
								$val = new Filelist($val);
							$val = str_replace(";", "<br />", $val->ToString());
							break;
					}
				}
			}				
			$fout = "<tr>";
			$fout .= "<td class='template-field'>".$fld."</td>";
			$fout .= "<td class='template-value'>".$val."</td>";
			$fout .= "</tr>";					  
			$args = $this->DispatchEvent("template.standart.field.rendered", Hashtable::Create("output", $fout, "data", $data, "field", $field, "value", $val));
			if(@$args->apply === true)
				$fout = @$args->output;	
			$ret .= $fout;
		}
		$ret .=  "</table>";
		$args = $this->DispatchEvent("template.standart.rendered", Hashtable::Create("output", $ret, "data", $data, "publication", $pub));
		if(@$args->apply === true)
			$ret = @$args->output;
		return $ret;		
	}
	private function ImplodeValues($field, $val) {
        if($field->type == "multiselect") {
            if($val->Count() > 0) {
                $col = $val;
            }
            else {
                global $postback;
                $col = new Collection();
                $col->Add("0", $postback->lang->empty_lookup);
            }
            $val = join(",", $col->Items());
            return $val;
        }
        else {		
		    $vv = explode("\n", $field->values);
		    foreach($vv as $v) {
			    $vvv = explode(":", $v);
			    if($vvv[0] == $val)
				    return $vvv[1];
		    }
        }
		return "Not selected";
	}
	private function ImplodeLookup($field, $val, $data) {
		global $core;
        global $postback;
        if($field->type == "multiselect") {
            if($val->Count() > 0) {
                $lookup = $field->SplitLookup();
                $condition = $lookup->condition;
                eval('$condition = "'.$condition.'";');
                $query = (!is_empty($lookup->query)) ? $lookup->query : "SELECT ".$lookup->fields." FROM ".$lookup->table." where ".$lookup->id." in (".join(",", $val->Keys()).")".(is_empty($condition) ? '' : ' and '.$condition);
                $r = $core->dbe->ExecuteReader($query);
                $vvvs = "";
                $col = new Collection();
                while($row = $r->Read()) {
                    $show  = $lookup->show;
                    $id = $lookup->id;
                    $col->Add($row->$id, $row->$show);
                }
            }
            else {
                $col = new Collection();
                $col->Add("0", $postback->lang->empty_lookup);
            }
            $val = join(",", $col->Items());
        }
        else {
            $lookup = $field->SplitLookup();
            if(!$lookup->isValid)
                $val = @$postback->lang->incorrect_lookup;             else {
                $condition = $lookup->condition;
                eval('$condition = "'.$condition.'";');
			    $error2 = false;
                if(is_empty($val))
                    $val = @$postback->lang->empty_lookup;
                else {
                    $fname = $data->storage->fname($field->field);
                    $query = (!is_empty($lookup->query)) ? $lookup->query : "SELECT ".$lookup->fields." FROM ".$lookup->table." where ".$lookup->id." = '".$data->data()->$fname."'".(is_empty($condition) ? '' : ' and '.$condition);
			        $result = $core->dbe->ExecuteReader($query);
                    if($result->Count() == 0) {
                        $val = @$postback->lang->incorrect_lookup;                     }
                    else {
                        $r = $result->Read();
                        $show = $lookup->show;
                        $val = $r->$show;
                    }
                }
		    }
        }
		return $val;
	}
	private function ImplodeOneToMany($storage, $field, $val, $id, $pub = null, $recursioncheck = null) {
		if(!$recursioncheck)
			$recursioncheck = new ArrayList();
		if($val instanceof MultilinkField) {
			$ret = "";
			$rows = $val->Rows();
			if($rows->Count() > 0) {
				$rid = "toggle_".uniqid();
				$ret .= '<div class="template-onetomany-title"><a href="#"><img class="toggler-collapsed" src="images/new/spacer1x1.gif" width="16" height="16" onclick="javascript: var obj = document.getElementById(\''.$rid.'\'); obj.style.display = obj.style.display == \'\' ? \'none\' : \'\'; this.className = this.className == \'toggler-collapsed\' ? \'toggler-expanded\' : \'toggler-collapsed\'; return false; "></a>';
				$ret .= ' -- multilink field -- rows count: '.$rows->Count();
				$ret .= '</div>';
				$ret .= "<div style='display: none; padding: 2px; border: 1px solid #f2f2f2; height: 320px; overflow: auto;' id='".$rid."'>";
				while($row = $rows->FetchNext()) {
					if ($recursioncheck->Contains($row->id."_".$row->storage->id)){
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Recursion detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					if($recursioncheck->Count() > 1) {
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Too mach nesting detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					$recursioncheck->Add($row->id."_".$row->storage->id);
					$tt = new Template(null, TEMPLATE_STORAGE, $row->storage);
					$ret .= $tt->ActiveOut($row, Hashtable::Create("admin_checkboxes", false), $recursioncheck);
					$recursioncheck->Delete($recursioncheck->IndexOf($row->id."_".$row->storage->id));
										$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
				}
				$ret .= "</div>";
				$val = $ret;
			}
			else {
				global $postback;
				$val = @$postback->lang->empty_multilink;
			}
		}
		else {
			global $postback;
			$val = @$postback->lang->incorrect_multilink; 		}
		return $val;
	}
	private function ImplodeBlobList($storage, $field, $val, $id, $pub = null, $recursioncheck = null) {
		if(!$recursioncheck)
			$recursioncheck = new ArrayList();
		if($val instanceof BlobList) {
			$ret = "";
			$rows = $val->Rows();
			if($rows->Count() > 0) {
				$rid = "toggle_".uniqid();
				$ret .= '<div class="template-onetomany-title"><a href="#"><img class="toggler-collapsed" src="images/new/spacer1x1.gif" width="16" height="16" onclick="javascript: var obj = document.getElementById(\''.$rid.'\'); obj.style.display = obj.style.display == \'\' ? \'none\' : \'\'; this.className = this.className == \'toggler-collapsed\' ? \'toggler-expanded\' : \'toggler-collapsed\'; return false; "></a>';
				$ret .= ' -- blob list -- blobs count: '.$rows->Count();
				$ret .= '</div>';
				$ret .= "<div style='display: none; padding: 2px; border: 1px solid #f2f2f2; height: 320px; overflow: auto;' id='".$rid."'>";
				while($row = $rows->FetchNext()) {
					if ($recursioncheck->Contains($row->id)){
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Recursion detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					if($recursioncheck->Count() > 1) {
						$ret .= '<div style="padding: 10px 0px 10px 10px; font-weight: bold;" class="warning">Too mach nesting detected</div>';
						$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
						continue;
					}
					$recursioncheck->Add($row->id);
															$ret .= $row->Out(TEMPLATE_ADMIN, Hashtable::Create("admin_checkboxes", false));
					$recursioncheck->Delete($recursioncheck->IndexOf($row->id));
										$ret .= '<div style="border-bottom: 1px solid #c0c0c0;"></div>';
				}
				$ret .= "</div>";
				$val = $ret;
			}
			else {
				global $postback;
				$val = @$postback->lang->empty_multilink;
			}
		}
		else {
			global $postback;
			$val = @$postback->lang->incorrect_multilink; 		}
		return $val;
	}	
	public function ToXML(){
		return parent::ToXML("template", array(), array("description", "list", "properties", "styles"), array("id"));
	}
	public function FromXML($node){
		parent::FromXML($node);
		$tp = $this->_pref."_id";
		if($this->_pref == TEMPLATE_STORAGE)
			$this->_storage = new Storage($this->$tp);
		else	
			$this->_storage = new CModule($this->$tp);
			}
    public function ToPHPScript($storageProperty) {
        return 'Template::CreateTemplate('.$storageProperty.', '.($this->_storage instanceOf Storage ? 'TEMPLATE_STORAGE' : 'TEMPLATE_MODULE').', "'.$this->name.'", hex2bin("'.bin2hex($this->description).'"), '.($this->composite ? 'true' : 'false').', hex2bin("'.bin2hex(load_from_file($this->list)).'"), hex2bin("'.bin2hex(load_from_file($this->styles)).'"), hex2bin("'.bin2hex($this->properties).'"), '.($this->cache ? 'true' : 'false').', "'.$this->cachecheck.'");'."\n";
    }
}
class Templates extends Collection {
	static $cache;
	private $type;
	private $storage;
	private $changed = true;
	public function __construct($storage = null, $type = TEMPLATE_STORAGE) {
		parent::__construct();
		if(!Templates::$cache)
			Templates::$cache = new Collection();
		$this->type = $type;
		$this->storage = $storage;
	}
	public function setModified() {
		$this->changed = true;
	}
	private function _reload() {
		global $core;
		if($this->changed) {
			$name = $this->type."_templates_name";
			$this->Clear();
			if(!Templates::$cache->Exists($this->type."_".$this->storage->id)) {
				$cache = new Collection();
				$t = $core->dbe->ExecuteReader("select * from sys_".$this->type."_templates where ".$this->type."_templates_".$this->type."_id=".$this->storage->id." order by ".$this->type."_templates_name");
				while($tt = $t->Read()) {
					$this->Add($tt->$name, new Template($tt, $this->type, $this->storage));
					$cache->Add($tt->$name, new Template($tt, $this->type, $this->storage));
				}
				Templates::$cache->Add($this->type."_".$this->storage->id, $cache);
			}
			else {
				$cache = Templates::$cache->Item($this->type."_".$this->storage->id);
				foreach($cache as $t) {
					$this->Add($t->name, $t);
				}
			}
			$this->setModified();
		}
	}
	public function Exists($key) {
		if($this->changed)
			$this->_reload();
		return parent::Exists($key);
	}
	public function Key($index) {
		if($this->changed)
			$this->_reload();
		return parent::Key($index);
	}
	public function Count() {
		if($this->changed)
			$this->_reload();
		return parent::Count();
	}
	public function Item($k) {
		if($this->changed)
			$this->_reload();
		return parent::Item($k);
	}
	public function getIterator() {
		if($this->changed)
			$this->_reload();
		return parent::getIterator();
	}
	public static function Visualize($p, $params) {
		global $postback;
		$default_text = "Default template";
		$empty_text = "Empty template";
		if(!is_empty($postback)) {
			$default_text = $postback->lang->development_storages_template_default;
			$empty_text = $postback->lang->development_storages_template_empty;
		}
		$t = new Templates($p->object_type == 1 ? $p->module : $p->datarow->storage, $p->object_type == 1 ? TEMPLATE_MODULE : TEMPLATE_STORAGE);
		$ret = "<select class='select-box' name='pub_template_".$p->id."' onchange='javascript: return PostBack(\"content\", \"post\", \"development\", \"structure\", null, createArray(\"pub_template\", this.options[this.selectedIndex].value, \"pub_id\", \"".$p->id."\", \"page\", \"".$params->page."\"))'>";
		$ret .= "<option value='' style='background-color: #D0D8E9'>".$default_text."</option>\n";
		$b = ($p->template == TEMPLATE_EMPTY);
		$ret .= "<option value='".TEMPLATE_EMPTY."' ".($b ? "selected" : "")." style='background-color: #D0D8E9'>".$empty_text."</option>\n";
		$nname = $t->type."_templates_name";
		foreach($t as $l) {
						if($l->name != TEMPLATE_DEFAULT) {
				$b = ($p->template == $l->name);
				$composite = $l->composite == 1 ? " style='background-color: #D0D8E9'" : "";
				$ret .= "<option value='".$l->name."' ".($b ? "selected" : "")." ".$composite.">".(is_empty($l->description) ? $l->name : $l->description)."</option>\n";
			}
		}
		$ret .= "</select>";
		return $ret;
	}
	public function Save() {
		foreach($this as $template)
			$template->Save();
	}
	public function ToXML(){
		$ret = '<templates storage="'.$this->storage->id.'" type="'.$this->type.'">';
		foreach ($this as $tpl)
			$ret .= $tpl->ToXML();
		$ret .= "</templates>";
		return $ret;
	}
	public function FromXML($el){
		$this->type = $el->getAttribute("type");
		$this->storage = null;
		$childs = $el->childNodes;
		foreach ($childs as $pair){
			switch ($pair->nodeName){
				case "template" :
					$t = new Template(null, $this->type);
					$t->FromXML($pair);
					parent::Add($t->name, $t);
					break;
			}
		}
		$this->setModified();
	}
    public function ToPHPScript($storageProperty) {
        $ret = '';
        foreach($this as $item) {
            $ret .= $item->ToPHPScript($storageProperty);
        }
        return $ret;
    }    
}
?><?php
class rc4crypt {
	static function encrypt($pwd, $data)
	{
		$key[] = '';
		$box[] = '';
		$cipher = '';
		$pwd_length = strlen($pwd);
		$data_length = strlen($data);
		for ($i = 0; $i < 256; $i++)
		{
			$key[$i] = ord($pwd[$i % $pwd_length]);
			$box[$i] = $i;
		}
		for ($j = $i = 0; $i < 256; $i++)
		{
			$j = ($j + $box[$i] + $key[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		for ($a = $j = $i = 0; $i < $data_length; $i++)
		{
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$k = $box[(($box[$a] + $box[$j]) % 256)];
			$cipher .= chr(ord($data[$i]) ^ $k);
		}
		return $cipher;
	}
	static function decrypt ($pwd, $data)
	{
		return rc4crypt::encrypt($pwd, $data);
	}
}
?><?php
class hashData
{
        var $hash = null;
}
class hashMessage
{
        function nextChunk()
    {
        trigger_error('hashMessage::nextChunk() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
        function currentChunk()
    {
        trigger_error('hashMessage::currentChunk() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
}
class hashMessageFile extends hashMessage
{
    function hashMessageFile( $filename )
    {
        trigger_error('hashMessageFile::hashMessageFile() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
}
class hashMessageURL extends hashMessage
{
    function hashMessageURL( $url )
    {
        trigger_error('hashMessageURL::hashMessageURL() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
}
class hash
{
        function hash($str, $mode = 'hex')
    {
        trigger_error('hash::hash() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
        static function hashChunk($str, $length, $mode = 'hex')
    {
        trigger_error('hash::hashChunk() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
        static function hashFile($filename, $mode = 'hex')
    {
        trigger_error('hash::hashFile() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
        static function hashChunkFile($filename, $length, $mode = 'hex')
    {
        trigger_error('hash::hashChunkFile() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
        static function hashURL($url, $timeout = null, $mode = 'hex')
    {
        trigger_error('hash::hashURL() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
        static function hashChunkURL($url, $length, $timeout = null, $mode = 'hex')
    {
        trigger_error('hash::hashChunkURL() NOT IMPLEMENTED', E_USER_WARNING);
        return false;
    }
}
class SHA256
{
        static function hash($str, $mode = 'hex')
    {
        return SHA256::_hash( '', $str, $mode );
    }
        static function hashFile($filename, $mode = 'hex')
    {
        return SHA256::_hash( 'File', $filename, $mode );
    }
        static function hashURL($url, $mode = 'hex')
    {
        return SHA256::_hash( 'URL', $url, $mode );
    }
        static function _hash( $type, $str, $mode )
    {
        $modes = array( 'hex', 'bin', 'bit' );
        $ret = false;
        if(!in_array(strtolower($mode), $modes))
        {
            trigger_error('mode specified is unrecognized: ' . $mode, E_USER_WARNING);
        }
        else
        {
            $data = new SHA256Data( $type, $str );
            SHA256::compute($data);
            $func = array('SHA256', 'hash' . $mode);
            if(is_callable($func))
            {
                $func = 'hash' . $mode;
                $ret = SHA256::$func($data);
                if( $mode === 'HEX' )
                {
                    $ret = strtoupper( $ret );
                }
            }
            else
            {
                trigger_error('SHA256::hash' . $mode . '() NOT IMPLEMENTED.', E_USER_WARNING);
            }
        }
        return $ret;
    }
        static function sum()
    {
        $T = 0;
        for($x = 0, $y = func_num_args(); $x < $y; $x++)
        {
                        $a = func_get_arg($x);
                        $c = 0;
            for($i = 0; $i < 32; $i++)
            {
                                $j = (($T >> $i) & 1) + (($a >> $i) & 1) + $c;
                                $c = ($j >> 1) & 1;
                                $j &= 1;
                                $T &= ~(1 << $i);
                                $T |= $j << $i;
            }
        }
        return $T;
    }
        static function compute(&$hashData)
    {
        static $vars = 'abcdefgh';
        static $K = null;
        if($K === null)
        {
            $K = array (
                 1116352408,     1899447441,    -1245643825,     -373957723,
                  961987163,     1508970993,    -1841331548,    -1424204075,
                 -670586216,      310598401,      607225278,     1426881987,
                 1925078388,    -2132889090,    -1680079193,    -1046744716,
                 -459576895,     -272742522,      264347078,      604807628,
                  770255983,     1249150122,     1555081692,     1996064986,
                -1740746414,    -1473132947,    -1341970488,    -1084653625,
                 -958395405,     -710438585,      113926993,      338241895,
                  666307205,      773529912,     1294757372,     1396182291,
                 1695183700,     1986661051,    -2117940946,    -1838011259,
                -1564481375,    -1474664885,    -1035236496,     -949202525,
                 -778901479,     -694614492,     -200395387,      275423344,
                  430227734,      506948616,      659060556,      883997877,
                  958139571,     1322822218,     1537002063,     1747873779,
                 1955562222,     2024104815,    -2067236844,    -1933114872,
                -1866530822,    -1538233109,    -1090935817,     -965641998,
                );
        }
        $W = array();
        while(($chunk = $hashData->message->nextChunk()) !== false)
        {
                        for($j = 0; $j < 8; $j++)
                ${$vars{$j}} = $hashData->hash[$j];
                        for($j = 0; $j < 64; $j++)
            {
                if($j < 16)
                {
                    $T1  = ord($chunk{$j*4  }) & 0xFF; $T1 <<= 8;
                    $T1 |= ord($chunk{$j*4+1}) & 0xFF; $T1 <<= 8;
                    $T1 |= ord($chunk{$j*4+2}) & 0xFF; $T1 <<= 8;
                    $T1 |= ord($chunk{$j*4+3}) & 0xFF;
                    $W[$j] = $T1;
                }
                else
                {
                    $W[$j] = SHA256::sum(((($W[$j-2] >> 17) & 0x00007FFF) | ($W[$j-2] << 15)) ^ ((($W[$j-2] >> 19) & 0x00001FFF) | ($W[$j-2] << 13)) ^ (($W[$j-2] >> 10) & 0x003FFFFF), $W[$j-7], ((($W[$j-15] >> 7) & 0x01FFFFFF) | ($W[$j-15] << 25)) ^ ((($W[$j-15] >> 18) & 0x00003FFF) | ($W[$j-15] << 14)) ^ (($W[$j-15] >> 3) & 0x1FFFFFFF), $W[$j-16]);
                }
                $T1 = SHA256::sum($h, ((($e >> 6) & 0x03FFFFFF) | ($e << 26)) ^ ((($e >> 11) & 0x001FFFFF) | ($e << 21)) ^ ((($e >> 25) & 0x0000007F) | ($e << 7)), ($e & $f) ^ (~$e & $g), $K[$j], $W[$j]);
                $T2 = SHA256::sum(((($a >> 2) & 0x3FFFFFFF) | ($a << 30)) ^ ((($a >> 13) & 0x0007FFFF) | ($a << 19)) ^ ((($a >> 22) & 0x000003FF) | ($a << 10)), ($a & $b) ^ ($a & $c) ^ ($b & $c));
                $h = $g;
                $g = $f;
                $f = $e;
                $e = SHA256::sum($d, $T1);
                $d = $c;
                $c = $b;
                $b = $a;
                $a = SHA256::sum($T1, $T2);
            }
                        for($j = 0; $j < 8; $j++)
                $hashData->hash[$j] = SHA256::sum(${$vars{$j}}, $hashData->hash[$j]);
        }
    }
        static function hashHex(&$hashData)
    {
        $str = '';
        reset($hashData->hash);
        do
        {
            $str .= sprintf('%08x', current($hashData->hash));
        }
        while(next($hashData->hash));
        return $str;
    }
        static function hashBin(&$hashData)
    {
        $str = '';
        reset($hashData->hash);
        do
        {
            $str .= pack('N', current($hashData->hash));
        }
        while(next($hashData->hash));
        return $str;
    }
        static function hashBit(&$hashData)
    {
        $str = '';
        reset($hashData->hash);
        do
        {
            $t = current($hashData->hash);
            for($i = 31; $i >= 0; $i--)
            {
                $str .= ($t & (1 << $i) ? '1' : '0');
            }
        }
        while(next($hashData->hash));
        return $str;
    }
}
class SHA256Data extends hashData
{
    function SHA256Data( $type, $str )
    {
        $type = 'SHA256Message' . $type;
        $this->message = new $type( $str );
                $this->hash = array
        (
             1779033703,    -1150833019,
             1013904242,    -1521486534,
             1359893119,    -1694144372,
              528734635,     1541459225,
        );
    }
}
class SHA256Message extends hashMessage
{
    function SHA256Message( $str )
    {
        $str .= $this->calculateFooter( strlen( $str ) );
                preg_match_all( '#.{64}#', $str, $this->chunk );
        $this->chunk = $this->chunk[0];
        $this->curChunk = -1;
    }
        function nextChunk()
    {
        if( is_array($this->chunk) && ($this->curChunk >= -1) && isset($this->chunk[$this->curChunk + 1]) )
        {
            $this->curChunk++;
            $ret =& $this->chunk[$this->curChunk];
        }
        else
        {
            $this->chunk = null;
            $this->curChunk = -1;
            $ret = false;
        }
        return $ret;
    }
        function currentChunk()
    {
        if( is_array($this->chunk) )
        {
            if( $this->curChunk == -1 )
            {
                $this->curChunk = 0;
            }
            if( ($this->curChunk >= 0) && isset($this->chunk[$this->curChunk]) )
            {
                $ret =& $this->chunk[$this->curChunk];
            }
        }
        else
        {
            $ret = false;
        }
        return $ret;
    }
        function calculateFooter( $numbytes )
    {
        $M =& $numbytes;
        $L1 = ($M >> 28) & 0x0000000F;            $L2 = $M << 3;            $l = pack('N*', $L1, $L2);
                                $k = $L2 + 64 + 1 + 511;
        $k -= $k % 512 + $L2 + 64 + 1;
        $k >>= 3;            
        $footer = chr(128) . str_repeat(chr(0), $k) . $l;
        assert('($M + strlen($footer)) % 64 == 0');
        return $footer;
    }
}
class SHA256MessageFile extends hashMessageFile
{
    function SHA256MessageFile( $filename )
    {
        $this->filename = $filename;
        $this->fp = false;
        $this->size = false;
        $this->append = '';
        $this->chunk = '';
        $this->more = true;
        $info = parse_url( $filename );
        if( isset( $info['scheme'] ) && !in_array(strtolower( $info['scheme'] ), array('php','file')) )
        {
            trigger_error('SHA256MessageFile(' . var_export($filename,true) . ' does not handle the ' . var_export( $info['scheme'], true ) . ' protocol.', E_USER_ERROR);
            return;
        }
        $this->fp = (is_readable( $filename ) ? @fopen( $filename, 'rb' ) : false);
        if( $this->fp === false )
        {
            trigger_error('SHA256MessageFile(' . var_export($filename,true) . '): unable to open file for SHA256 hashing.', E_USER_ERROR);
        }
        $stat = @fstat( $this->fp );
        if( $stat === false )
        {
            trigger_error('SHA256MessageFile(' . var_export($filename,true) . '): unable to pull file status information.', E_USER_ERROR);
            return;
        }
        $this->append = SHA256Message::calculateFooter($this->size = intval($stat['size']));
    }
        function nextChunk()
    {
        $ret = false;
        if( $this->fp !== false )
        {
            $ret = @fread( $this->fp, 64 );
            if( ($l = strlen($ret)) != 64 )
            {
                if(strlen($ret . $this->append) > 64)
                {
                    $ret = substr( $ret . $this->append, 0, 64 );
                    $this->append = substr( $this->append, 64 - $l );
                }
                else
                {
                    $ret .= $this->append;
                    $this->more = false;
                    assert('strlen($ret) % 64 == 0');
                }
            }
            if(!$this->more)
            {
                @fclose( $this->fp );
                $this->fp = false;
                $this->size = false;
                $this->append = '';
            }
        }
        $this->chunk = (string)$ret;
        return $ret;
    }
        function currentChunk()
    {
        if( $this->chunk === '' && $this->fp !== false )
        {
            return $this->nextChunk();
        }
        else
        {
            return ($this->chunk === '' ? false : $this->chunk);
        }
    }
}
class SHA256MessageURL extends hashMessageURL
{
        var $socket_timeout = 5;
    function SHA256MessageURL( $url )
    {
        $this->fp = false;
        $this->more = true;
        $this->first = true;
        $this->headers = false;
        $this->append = '';
        $this->chunk = '';
        $this->curChunk = 0;
        $this->size = 0;
        if( ini_get( 'allow_url_fopen' ) == false )
        {                $info = parse_url($url);
            if( !isset($info['scheme']) || (strcasecmp(trim($info['scheme']), 'http') == 0) )
            {                    
                if( !isset($info['scheme']) )
                {
                    $url = 'http://' . $url;
                    $info = parse_url($url);
                }
                if( function_exists( 'fsockopen' ) == false )
                {
                    trigger_error('SHA256MessageURL(): allow_url_fopen is off, fsockopen is disabled or not available.', E_USER_WARNING);
                    return;
                }
                elseif(empty($info['host']))
                {                        trigger_error('SHA256MessageURL(' . var_export($url,true) .') does not appear to be a url.', E_USER_NOTICE);
                    return;
                }
                $this->fp = @fsockopen( $info['host'], (isset($info['port']) ? $info['port'] : 80), $errno, $errstr, $this->socket_timeout );
                if(!$this->fp)
                {                        trigger_error('SHA256MessageURL(): fsockopen failure ' . $errno . ' - ' . $errstr, E_USER_WARNING);
                    return;
                }
                                @fwrite($this->fp, 'GET ' . (empty($info['path']) ? '/' : $info['path']) . " HTTP/1.0\r\nHost: " . strtolower($info['host']) . "\r\n\r\n");
                $this->headers = true;
            }
            else
            {
                trigger_error('SHA256MessageURL(' . var_export($url,true) . ') is using an unsupported protocol: ' . var_export($info['scheme']), E_USER_WARNING);
            }
        }
        else
        {                $info = parse_url( $url );
            if( !isset($info['scheme']) )
            {
                $url = 'http://' . $url;
            }
            $this->fp = fopen( $url, 'rb' );
            if( $this->fp === false )
            {                    trigger_error('SHA256MessageURL(' . var_export($url,true) . '): unable to open the url supplied.', E_USER_WARNING);
            }
        }
    }
        function nextChunk()
    {
        $this->tossHeader();
        $ret = false;
        if( is_array($this->chunk) )
        {
                        if( $this->first === true )
            {
                $this->first = false;
            }
            else
            {
                $this->curChunk++;
            }
            $ret = (isset($this->chunk[$this->curChunk]) ? $this->chunk[$this->curChunk] : false);
        }
        elseif( $this->fp !== false )
        {
            if( $this->first == true )
            {
                if( ($l = strlen($this->append)) > 64 )
                {
                    $ret = substr($this->append, 0, 64);
                    $this->append = substr($this->append, 64);
                }
                else
                {
                    $ret = $this->append . fread( $this->fp, 64 - $l );
                    $this->append = '';
                    $this->first = false;
                }
            }
            else
            {
                $ret = @fread( $this->fp, 64 );
            }
            $l = strlen($ret);
            $this->size += $l;
            if( $l != 64 )
            {
                if(empty($this->append))
                {
                    $this->append = SHA256Message::calculateFooter( $this->size );
                }
                if(strlen($ret . $this->append) > 64)
                {
                    $ret = substr( $ret . $this->append, 0, 64 );
                    $this->append = substr( $this->append, 64 - $l );
                }
                else
                {
                    $ret .= $this->append;
                    $this->more = false;
                    assert('strlen($ret) % 64 == 0');
                }
            }
            if(!$this->more)
            {
                @fclose( $this->fp );
                $this->fp = false;
                $this->size = false;
                $this->append = '';
            }
            $this->chunk = (string)$ret;
        }
        return $ret;
    }
        function currentChunk()
    {
        if( $this->chunk === '' && $this->fp !== false )
        {
            return $this->nextChunk();
        }
        else
        {
            return ($this->chunk === '' ? false : $this->chunk);
        }
    }
        function tossHeader()
    {
        if( $this->headers === true )
        {
            $buf = '';
            while(!feof($this->fp))
            {
                $buf .= fread($this->fp, 4);
                if( preg_match("#(\r\n|\n\r|\r|\n)\\1#s", $buf, $match, PREG_OFFSET_CAPTURE ) )
                {
                    $this->append = substr( $buf, $match[0][1] + strlen($match[0][0]) );
                    $this->headers = false;
                    break;
                }
            }
            if( $this->headers === true )
            {                    trigger_error('SHA256MessageURL::tossHeader(): no headers were sent. Falling back to string hashing', E_USER_NOTICE);
                                $this->headers = false;
                                $this->chunk = $buf . SHA256Message::calculateFooter( $this->size = strlen( $buf ) );
                preg_match_all( '#.{64}#', $str, $this->chunk );
                $this->chunk = $this->chunk[0];
            }
        }
    }
}
?><?php
class ImageEditor {
    public $x;
    public $y;
    public $type;
    public $img;  
    public $font;
    public $error;
    public $size;
                function ImageEditor($filename="", $path="", $data=NULL, $col=NULL) 
    {
        $this->font = false;
        $this->error = false;
        $this->size = 25;
        if(is_numeric($filename) && is_numeric($path) && is_null($data)){
            $this->x = $filename;
            $this->y = $path;
            if(gettype($col) == "string")
                $this->type = $col;
            else
                $this->type = "jpg";
            $this->img = imagecreatetruecolor($this->x, $this->y);
            if(is_array($col)) {
                                $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
                ImageFill($this->img, 0, 0, $colour);
            }
        }
        else { 
                                    if(!is_null($data)) {
                $this->img = @imagecreatefromstring($data);
                $this->setSaveAlphaBlending(true);
                if(empty($this->img))
                    $this->error = true;
                else {
                    $this->type = "";
                    $this->x = imagesx($this->img);
                    $this->y = imagesy($this->img);
                }
            }
            else {
                if(file_exists($path . $filename))
                {
                    $file = $path . $filename;
                }
                else if (file_exists($path . "/" . $filename))
                {
                    $file = $path . "/" . $filename;
                }
                else
                {
                    $this->errorImage("File Could Not Be Loaded");
                }
                if(!($this->error)) 
                {
                                        $this->type = strtolower(end(explode('.', $filename)));
                    if ($this->type == 'jpg' || $this->type == 'jpeg') 
                    {
                        $this->img = @imagecreatefromjpeg($file);
                    } 
                    else if ($this->type == 'png') 
                    {
                        $this->img = @imagecreatefrompng($file);
                                                                    } 
                    else if ($this->type == 'gif') 
                    {
                        $this->img = @imagecreatefromgif($file);
                    }
                                        $this->x = imagesx($this->img);
                    $this->y = imagesy($this->img);
                }
            }
        }
        if($this->type == "png")
            $this->setSaveAlphaBlending(false);
    }
    public function __destruct() {
        $this->Dispose();
    }
    public function Dispose() {
        @imagedestroy($this->img);
        unset($this->img);
    }
                function resize($width, $height) 
    {
        if(!$this->error) 
        {
            $tmpimage = imagecreatetruecolor($width, $height);
            ImageColorTransparent($tmpimage, imagecolorallocate($tmpimage, 0, 0, 0)); 
            imagealphablending($tmpimage, false);
            imagecopyresampled($tmpimage, $this->img, 0, 0, 0, 0,
                               $width, $height, $this->x, $this->y);
            imagedestroy($this->img);
            $this->img = $tmpimage;
            $this->y = $height;
            $this->x = $width;
        }
    }
                    function crop($x, $y, $width, $height) 
    {
        if(!$this->error) 
        {
            $tmpimage = imagecreatetruecolor($width, $height);
            imagecopyresampled($tmpimage, $this->img, 0, 0, $x, $y,
                               $width, $height, $width, $height);
            imagedestroy($this->img);
            $this->img = $tmpimage;
            $this->y = $height;
            $this->x = $width;
        }
    }
                    function addText($str, $x, $y, $col)
    {
        if(!$this->error) 
        {
            if($this->font) {
                $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
                if(!imagettftext($this->img, $this->size, 0, $x, $y, $colour, $this->font, $str)) {
                    $this->font = false;
                    $this->errorImage("Error Drawing Text");
                }
            }
            else {
                $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
                Imagestring($this->img, 5, $x, $y, $str, $colour);
            }
        }
    }
    function shadowText($str, $x, $y, $col1, $col2, $offset=2) {
        $this->addText($str, $x, $y, $col1);
        $this->addText($str, $x-$offset, $y-$offset, $col2);   
    }
                    function addLine($x1, $y1, $x2, $y2, $col) 
    {
        if(!$this->error) 
        {
            $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
            ImageLine($this->img, $x1, $y1, $x2, $y2, $colour);
        }
    }
                function addWatermark($img, $dst_x, $dst_y, $src_x, $src_y, $pct) {
        $img->setSaveAlphaBlending(false);
        $i = imagecopymerge($this->img, $img->img, $dst_x, $dst_y, $src_x, $src_y, $img->x, $img->y, $pct);
        $img->setSaveAlphaBlending(true);
        return $i;
    }
                function addFilter($filter, $arg1 = 0, $arg2 = 0, $arg3 = 0) {
        switch($filter) {
            case IMG_FILTER_NEGATE:
                return imagefilter($this->img, $filter);
            case IMG_FILTER_GRAYSCALE:
                return imagefilter($this->img, $filter);
            case IMG_FILTER_BRIGHTNESS:
                return imagefilter($this->img, $filter, $arg1);
            case IMG_FILTER_CONTRAST:
                return imagefilter($this->img, $filter, $arg1);
            case IMG_FILTER_COLORIZE:
                return imagefilter($this->img, $filter, $arg1, $arg2, $arg3);
            case IMG_FILTER_EDGEDETECT:
                return imagefilter($this->img, $filter);
            case IMG_FILTER_EMBOSS:
                return imagefilter($this->img, $filter);
            case IMG_FILTER_GAUSSIAN_BLUR:
                return imagefilter($this->img, $filter);
            case IMG_FILTER_SELECTIVE_BLUR:
                return imagefilter($this->img, $filter);
            case IMG_FILTER_MEAN_REMOVAL:
                return imagefilter($this->img, $filter);
            case IMG_FILTER_SMOOTH:
                return imagefilter($this->img, $filter, $arg1);
        }
        return false;
    }
                function outputImage() 
    {
        if ($this->type == 'jpg' || $this->type == 'jpeg') 
        {
            header("Content-type: image/jpeg");
            imagejpeg($this->img);
        } 
        else if ($this->type == 'png') 
        {
            header("Content-type: image/png");
            imagepng($this->img);
        } 
        else if ($this->type == 'gif') 
        {
            header("Content-type: image/png");
            imagegif($this->img);
        }
    }
                function outputFile($filename, $path) 
    {
        if ($this->type == 'jpg' || $this->type == 'jpeg') 
        {
            imagejpeg($this->img, ($path . $filename));
        } 
        else if ($this->type == 'png') 
        {
            $this->setSaveAlphaBlending(true);
            imagepng($this->img, ($path . $filename));
        } 
        else if ($this->type == 'gif') 
        {
            imagegif($this->img, ($path . $filename));
        }
    }
    function outputMem($type = "") {
        $filename = tempnam("","");
        if(!$filename) {
            global $core;
            $p = $core->fs->mappath("/assets/static");
            $filename = $p."/".str_random(20);
        }
        if(empty($type))
            $type = $this->type;
        $this->type = $type;
        if ($this->type == 'jpg' || $this->type == 'jpeg') 
        {
            imagejpeg($this->img, $filename);
        } 
        else if ($this->type == 'png') 
        {
            $this->setSaveAlphaBlending(true);
            imagepng($this->img, $filename);
        } 
        else if ($this->type == 'gif') 
        {
            imagegif($this->img, $filename);
        }
        else {
            imagegd2($this->img, $filename);
        }
        $content = file_get_contents($filename);
        unlink($filename);
        return $content;
    }
                    function setImageType($type)
    {
        $this->type = $type;
    }
                    function setFont($font) {
        $this->font = $font;
    }
                function setSize($size) {
        $this->size = $size;
    }
                function getWidth()                {return $this->x;}
    function getHeight()               {return $this->y;} 
    function getImageType()            {return $this->type;}
                function errorImage($str) 
    {
        $this->error = false;
        $this->x = 235;
        $this->y = 50;
        $this->type = "jpg";
        $this->img = imagecreatetruecolor($this->x, $this->y);
        $this->addText("AN ERROR OCCURED:", 10, 5, array(250,70,0));
        $this->addText($str, 10, 30, array(255,255,255));
        $this->error = true;
    }
    function addImage($imgSrc, $x, $y) {
        $src_im = $imgSrc->img;
        if($this->type == "png") {
            imagealphablending($this->img, false);
            imagealphablending($src_im, false);
        }
        imagecopy($this->img, $src_im, $x, $y, 0, 0, $imgSrc->x, $imgSrc->y);
    }
    function setTransparent($transparent) {
        $imgi = $transparent;
        if(!is_numeric($transparent))
            $imgi = imagecolorallocate($this->img, $transparent["red"], $transparent["green"], $transparent["blue"]);
        imagefill($this->img, 0, 0, $imgi);
        imagecolortransparent ( $this->img, $imgi );
    }
    function getTransparentColor() {
        return imagecolortransparent($this->img);
    }
    function colorAllocate($color) {
        return imagecolorallocate($this->img, $color["red"], $color["green"], $color["blue"]);
    }
    function setSaveAlphaBlending($savealpha = false) {
        if(!$savealpha)
            @imagealphablending($this->img, 1);
        if($savealpha)
            @imagesavealpha($this->img, 1);
    }
    function getColorAt($x, $y) {
        $rgb = ImageColorAt($this->img, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        return '#'.str_expand(dechex($r), 2, '0').
                    str_expand(dechex($g), 2, '0').
                    str_expand(dechex($b), 2, '0');
    }
    static function Merge($imgs, $type, $orientation = HORIZONTAL, $transparent = array()) {
        $img = null;
        if($orientation == HORIZONTAL) {
            $x = 0;
            $y = array();
            foreach($imgs as $img) {
                $x+=$img->x;
                $y[] = $img->y;
            }
            $y = max($y);
            if($type == "gif") {
                if(count($transparent) == 0)
                    $transparent = $imgs[0]->getTransparentColor();    
            }
            $img = new ImageEditor($x, $y, null, $type);
            if($type == "gif")
                $img->setTransparent($transparent);
            $xx = 0;
            foreach($imgs as $i) {
                $img->addImage($i, $xx, 0);
                $xx += $i->x;
            }
        }
        else {
            $x = array();
            $y = 0;
            foreach($imgs as $img) {
                $x[] = $img->x;
                $y+=$img->y;
            }
            $x = max($x);
            if($type == "gif")
                if(count($transparent) == 0)
                    $transparent = $imgs[0]->getTransparentColor();    
            $img = new ImageEditor($x, $y, null, $type);
            $img->type = $type;
            if($type == "gif")
                $img->setTransparent($transparent);
            $yy = 0;    
            foreach($imgs as $i) {
                $img->addImage($i, 0, $yy);
                $yy += $i->y;
            }
        }
        return $img;
    }
    public static function ImageInfo($path) {
        list($width, $height, $type, $attr) = getimagesize($path);
        $o = new Object();
        $o->size = new Size($width, $height);
        $o->type = $type;
        $o->attr = $attr;
        return $o;
    }
} 
?><?php
    class GraphicsBatch {
        private $_history;
        public function __construct($operations = array()) {
            $this->_history = $operations;
        }
        public function Add($operation = array()) {
            $this->_history[] = $operation;
        }
        private function _joinHistory() {
            $ret = '';
            foreach($this->_history as $operation => $op) {
                $ret .= '-'.strtolower($operation);
                foreach($op as $o) {
                    if($o instanceOf Size) 
                        $ret .= '.'.$o->width.'x'.$o->height;
                    else if($o instanceOf Point) 
                        $ret .= '.'.$o->x.'x'.$o->y;
                    else
                        $ret .= '.'.(string)$o;
                }
            }
            return is_empty($ret) ? '' : substr($ret, 1);
        }
        private function _cacheFolder() {
            global $core;
            $path = $core->sts->BLOB_CACHE_FOLDER."/";
            return str_replace('//', '/', $path);
        }
        public function Cache($g) {
            global $core;
            $path = $this->_cacheFolder().md5($g->name).'.'.$this->_joinHistory().'.'.$g->type;
            if(!$core->fs->FileExists($path)) {
                $this->Batch($g);
                $g->Save($path);
            }
            return $path;
        }
        public function Batch($g) {
            foreach($this->_history as $operation => $params) {
                $g->$operation(@$params[0], @$params[1], @$params[2], @$params[3], @$params[4], @$params[5]);
            }
        }
        public static function Operate($g, $operations = array()) {
            $gb = new GraphicsBatch($operations);
            return $gb->Cache($g);
        }
    }
    class Graphics {
        private $_img;
        private $_size;
        private $_type;
        private $_file;
        private $_history = array();
        public function __construct() {
            $this->_img = null;
            $this->_size = new Size(0, 0);
            $this->_type = 'unknown';
        }
        public function __destruct() {
            @imagedestroy($this->_img);
        }
        public function __get($property) {
            switch(strtolower($property)) {
                case 'isvalid':
                    return !is_null($this->_img);
                case 'size':
                    return $this->_size;
                case 'type':
                    return $this->_type;
                case 'data':
                    return $this->_getImageData();
                case 'transparency':
                    return !is_null($this->_img) ? @imagecolortransparent($this->_img) : false;
                case 'name':
                    return $this->_file;
            }
        }
        public function __set($property, $value) {
            switch(strtolower($property)) {
                case 'type':
                    $this->_type = $value;
                    break;
            }
        }
        public function LoadFromData($data) {
            $this->_file = basename(str_random(20));
            $this->_img = @imagecreatefromstring($data);
            $this->_size = new Size(imagesx($this->_img), imagesy($this->_img));
            $this->_history = array();
            $this->_safeAlpha();
        }
        public function LoadFromFile($file) {
            $this->_file = basename($file);
            $this->_type = strtolower(end(explode('.', $file)));
            switch($this->_type) {
                case 'png':
                    $this->_img = @imagecreatefrompng($file);
                    break;
                case 'gif':
                    $this->_img = @imagecreatefromgif($file);
                    break;
                case 'jpg':
                case 'jpeg':
                    $this->_img = @imagecreatefromjpeg($file);
                    break;
            }
            $this->_size = new Size(imagesx($this->_img), imagesy($this->_img));
            $this->_history = array();
            $this->_safeAlpha();
        }
        public function LoadEmptyImage($size) {
            $this->_type = "unknown";
            $this->_img = imagecreatetruecolor($size->width, $size->height);
            $this->_size = $size;
            $this->_history = array();
            $this->_safeAlpha();
        }
        public function Resize($size) {
            if($this->isValid) {
                $newImage = @ImageCreateTrueColor($size->width, $size->height);
                ImageColorTransparent($newImage, imagecolorallocate($newImage, 0, 0, 0)); 
                ImageCopyResampled($newImage, $this->_img, 0, 0, 0, 0, $size->width, $size->height, $this->_size->width, $this->_size->height);
                ImageDestroy($this->_img);
                $this->_img = $newImage;
                $this->_size = $size;
                $this->_history[] = array('operation' => 'resize', 'postfix' => 'resized-'.$size->width.'x'.$size->height);
            }
        }
        public function Crop($size, $start = null) {
            if($this->isValid) {
                if(is_null($start)) $start = new Point(0, 0);
                $newImage = ImageCreateTrueColor($size->width, $size->height);
                ImageCopyResampled($newImage, $this->_img, 0, 0, $start->x, $start->y,
                                   $size->width, $size->height, $size->width, $size->height);
                ImageDestroy($this->_img);
                $this->_img = $newImage;
                $this->size = $size;
                $this->_history[] = array('operation' => 'crop', 'postfix' => 'croped-'.$start->x.'x'.$start->y.'.'.$size->width.'x'.$size->height);
            }
        }
        public function ApplyFilter($filter, $arg1 = 0, $arg2 = 0, $arg3 = 0) {
            switch($filter) {
                case IMG_FILTER_NEGATE:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'negate');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_GRAYSCALE:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'grayscale');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_BRIGHTNESS:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'brightness-'.$arg1);
                    return imagefilter($this->_img, $filter, $arg1);
                case IMG_FILTER_CONTRAST:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'contrast-'.$arg1);
                    return imagefilter($this->_img, $filter, $arg1);
                case IMG_FILTER_COLORIZE:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'colorize-'.$arg1.'x'.$arg2.'x'.$arg3);
                    return imagefilter($this->_img, $filter, $arg1, $arg2, $arg3);
                case IMG_FILTER_EDGEDETECT:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'edgedetect');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_EMBOSS:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'emboss');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_GAUSSIAN_BLUR:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'gausian-blur');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_SELECTIVE_BLUR:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'blur');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_MEAN_REMOVAL:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'mean-removal');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_SMOOTH:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'smooth-'.$arg1);
                    return imagefilter($this->_img, $filter, $arg1);
            }
            return false;
        }        
        public function Save($file) {
            global $core;
            $file = $core->fs->MapPath($file);
            switch($this->_type) {
                case 'png':
                    imagepng($this->_img, $file);
                    break;
                case 'gif':
                    imagegif($this->_img, $file);
                    break;
                case 'jpg':
                case 'jpeg':
                    imagejpeg($this->_img, $file);
                    break;
                default:
                    imagegd2($this->_img, $file);
                    break;
            }            
        }
        public function Cache() {
            global $core;
            $path = $this->_cacheFolder().md5($this->name).'.'.$this->_joinHistory().'.'.$this->_type;
            if(!$core->fs->FileExists($path))
                $this->Save($path);
            return $path;
        }
        private function _cacheFolder() {
            global $core;
            $path = $core->fs->mappath($core->sts->BLOB_CACHE_FOLDER)."/";
            return str_replace('//', '/', $path);
        }
        private function _safeAlpha() {
                        imagealphablending($this->_img, 1);
            imagesavealpha($this->_img, 1);
        }
        private function _tryCreateTempFile() {
            $filename = tempnam("","");
            if(!$filename) $filename = $this->_cacheFolder().str_random(20);
            return $filename;
        }
        private function _getImageData() {
            $tempFile = $this->_tryCreateTempFile();
            switch($this->_type) {
                case 'png':
                    imagepng($this->_img, $tempFile);
                    break;
                case 'gif':
                    imagegif($this->_img, $tempFile);
                    break;
                case 'jpg':
                case 'jpeg':
                    imagejpeg($this->_img, $tempFile);
                    break;
                default:
                    imagegd2($this->_img, $tempFile);
                    break;
            }            
            $c = file_get_contents($tempFile);
            unlink($tempFile);
            return $c;
        }
        private function _joinHistory() {
            $ret = '';
            foreach($this->_history as $operation) {
                $ret .= '.'.$operation['postfix'];
            }
            return is_empty($ret) ? $ret : substr($ret, 1);
        }
        public static function Info($path) {
            list($width, $height, $type, $attr) = @getimagesize($path);
            $o = new Object();
            $o->size = new Size($width, $height);
            $o->type = $type;
            $o->attr = $attr;
            return $o;
        }
        public static function Create($data) {
            global $core;
            $g = new Graphics();
            if($data instanceOf Size)
                $g->LoadEmptyImage($data);
            else if(file_exists($core->fs->MapPath($data))) {
                $g->LoadFromFile($core->fs->MapPath($data));
            }
            else 
                $g->LoadFromData($data);
            return $g;
        }
    }
?>
<?php
class IconPack extends collection  {
	public $iconpack_path;
	public $iconpack_url;
	public $name;
	function IconPack($name = null, $pack_path = null) {
		parent::__construct();
		$this->init($name, $pack_path);
	}
    private function _getIconLocation($name = null, $pack_path = null) {
        global $core;
        if(is_empty($name)) $name = "default";
        if(is_empty($pack_path)) $pack_path = "/images/icons";
        $realpath = $core->fs->mappath("/images/icons", ADMIN);
        if($core->fs->DirExists($realpath."/".$name, ADMIN)) {
            $this->iconpack_path = $realpath."/".$name;
            $this->iconpack_url = "/admin/images/icons/".$name;
        }
        else {
            $realpath = $core->fs->mappath("/resources/icons", SITE);
            if($core->fs->DirExists($realpath."/".$name, ADMIN)) {
                $this->iconpack_path = $realpath."/".$name;
                $this->iconpack_url = "/resources/icons/".$name;
            }
            else {
                $realpath = $core->fs->mappath("/utils/images/", CORE);
                if($core->fs->DirExists($realpath."/".$name, CORE)) {
                    $this->iconpack_path = $realpath."/".$name;
                    $this->iconpack_url = "/core/utils/images/".$name;
                }
            }
        }
            }
	private function init($name = null, $pack_path = null){
		global $core;
		$this->_getIconLocation($name, $pack_path);
		$icons = @file_get_contents($this->iconpack_path."/icons.conf");
		if($icons) {
			$iconrows = explode("\n", $icons);
			foreach($iconrows as $icon) {
				if(trim($icon) != "") {
					list($name, $file) = explode("=", $icon);
					$this->add($name, $this->iconpack_url."/".$file);
				}
			}
		}
	}
	public function Save() {
		$content = "";
		foreach($this as $icon => $c) {
			$content .= $icon."=".(substr($c, strlen($this->iconpack_url."/")))."\n";
		}
		touch($this->iconpack_path."/icons.conf");
		$icons = file_put_contents($this->iconpack_path."/icons.conf", $content);
	}
	public function IconFromPack($str) {
		if(substr($str, 0, strlen("iconpack(")) == "iconpack(" ) {
			$str = substr($str, strlen("iconpack("));
			$str = trim(substr($str, 0, strlen($str) - 1), "\n");
			$str = trim($str, "\r");
			$str = $this->$str;
			$str = trim($str, "\r");
			$str = trim($str, "\n");
			return $str;
		}
		return $str;
	}
	function CreateToggleButton($imageCollapse, $imageExpand, $texts, $width, $height, $objectIds, $initialState = "collapsed", $name = null) {
		if(is_null($name))
			$name = "id".str_random(10);
		$ret  = '<img class="toggle-button" state="'.$initialState.'" id="'.$name.'" src="'.($initialState != "collapsed" ? $this->IconFromPack($imageCollapse) : $this->IconFromPack($imageExpand)).'" alt="'.($initialState == "collapsed" ? $texts[0] : $texts[1]).'" width="'.$width.'" height="'.$height.'" onclick="javascript: toggle_'.$name.'(this)" />';
		$collapseCmd = '';
		$expandCmd = '';
		if($objectIds != "rows") {
			if(is_array($objectIds)) {
				foreach($objectIds as $id) {
					$collapseCmd .= 'document.getElementById("'.$id.'").style.display = "none";'."\n";
					$expandCmd .= 'document.getElementById("'.$id.'").style.display = "";'."\n";
				}
			}
			else {
				$collapseCmd .= 'document.getElementById("'.$objectIds.'").style.display = "none";'."\n";
				$expandCmd .= 'document.getElementById("'.$objectIds.'").style.display = "";'."\n";
			}
		}		
		$scripts = '
			<script language="javascript">
				if("'.$initialState.'" == "collapsed") {
					'.($objectIds != 'rows' ? '
					'.$collapseCmd.'
					' : '
					window.setTimeout("togglerows_'.$name.'(document.getElementById(\"'.$name.'\").parentNode.parentNode.parentNode.parentNode, 1, document.getElementById(\"'.$name.'\").parentNode.parentNode.parentNode.parentNode.rows.length-1, \"collapse\")", 100);
					').
					'
				}
				function toggle_'.$name.'(img) {
					var command = img.getAttribute("state") == "collapsed" ? "expand" : "collapse";
					if(command == "collapse") {
						img.setAttribute("state", "collapsed");
						img.src = "'.$this->IconFromPack($imageExpand).'";
						img.alt = "'.$texts[1].'";
						'.($objectIds != 'rows' ? '
						'.$collapseCmd.'
						' : '
						var table = img.parentNode.parentNode.parentNode;
						togglerows_'.$name.'(table, 1, table.rows.length-1, "collapse");
						').
						'
					}
					else if(command == "expand") {
						img.setAttribute("state", "expanded");
						img.src = "'.$this->IconFromPack($imageCollapse).'";
						img.alt = "'.$texts[0].'";
						'.($objectIds != 'rows' ? '
						'.$expandCmd.'
						' : '
						var table = img.parentNode.parentNode.parentNode;
						togglerows_'.$name.'(table, 1, table.rows.length-1, "expand");
						').
						'
					}
				}
				function togglerows_'.$name.'(table, start, end, command) {
					for(var i=start; i<=end; i++) {
						table.rows[i].style.display = command == "collapse" ? "none" : "";
					}
				}
			</script>
		';
		return $ret.$scripts;
	}
	function CreateIconImage($image, $text, $width, $height, $ad = "") {
		global $core;
		$image = $this->IconFromPack($image);
		switch($core->browserInfo->name) {
			case "ie":
				if($core->browserInfo->version > 6)
					$img = '<img src="'.$image.'" width="'.$width.'" height="'.$height.'" border="0" alt="'.$text.'" '.$ad.' />';	
				else
					$img = '<img src="images/new/spacer1x1.gif" width="'.$width.'" height="'.$height.'" style="background-image: url('.$image.')" class="png" border="0" alt="'.$text.'" '.$ad.' />';		
				break;
			case "moz":
			default:
				$img = '<img src="'.$image.'" width="'.$width.'" height="'.$height.'" border="0" alt="'.$text.'" '.$ad.' />';	
				break;
		}
		return $img;
	}
	public function ToXML(){
		global $core;
		$ret = "<iconpack>";
		$ret .= "<name>".$this->name."</name>";
		$ret .= "<icons>";
		foreach ($this as $k => $v){
			$v = substr($v, 6);
			$path = $core->fs->mappath($v, ADMIN);
			if (!$core->fs->fileexists($path))
				continue;
			$ret .= "<icon>";
			$ret .= "<name>".$k."</name>";
			$ret .= "<filename>".basename($v)."</filename>";
			$ret .= "<data><![CDATA[".bin2hex($core->fs->readfile($v, ADMIN))."]]></data>";
			$ret .= "</icon>";
		}
		$ret .= "</icons>";
		$ret .= "</iconpack>";
		return $ret;
	}
	public function FromXML($el){
		global $core;
		$iconpack = $el;
		$this->init($iconpack->childNodes->item(0)->nodeValue);
		if (!$core->fs->direxists($this->iconpack_path))
			$core->fs->createdir($this->iconpack_path);
		global $ADMIN_PATH;
		$childs = $iconpack->childNodes->item(1)->childNodes;
		foreach ($childs as $pair){
			switch ($pair->nodeName){
				case "icon" :
					$name = $pair->childNodes->item(0)->nodeValue;
					$filename = $pair->childNodes->item(1)->nodeValue;
					$this->Add($name, $this->iconpack_url."/".$filename);
					if ($core->fs->fileexists($this->iconpack_path."/".$filename, ADMIN))
						break;
					$data = hex2bin($pair->childNodes->item(2)->nodeValue);
					$core->fs->writefile($this->iconpack_path."/".$filename, $data, ADMIN);
					break;
				default :
			}
		}
		$this->save();
	}
}
?>
<?php
class Alphabet {
	private $_folder;
	private $_list;
	private $_chartofile;
	private $_outputdir;
	public function __construct($folder = "default", $outputdir = "", $dontload = false) {
		$this->_folder = $folder;
		$this->_list = null;
		$this->_loadPre();
		$this->_outputdir = $outputdir;
		if(!$dontload)
			$this->_Load();
	}
	private function _loadPre() {
		$this->_chartofile = array(
			"0" => "0",
			"1" => "1",
			"2" => "2",
			"3" => "3",
			"4" => "4",
			"5" => "5",
			"6" => "6",
			"7" => "7",
			"8" => "8",
			"9" => "9",
			"9" => "9",			
			"00" => " ",
			"01" => "$",
			"02" => "/",
			"03" => "(",
			"04" => ")",
			"05" => "!",
			"06" => "?",
			"07" => "%",
			"08" => "@",
			"09" => ".",
			"10" => ",",						
			"11" => "|",
			"12" => "-",
			"13" => "_",
			"001" => "А",
			"002" => "Б",
			"003" => "В",
			"004" => "Г",
			"005" => "Д",
			"006" => "Е",
			"007" => "Ж",
			"008" => "З",
			"009" => "И",
			"010" => "К",
			"011" => "Л",
			"012" => "М",
			"013" => "Н",
			"014" => "О",
			"015" => "П",
			"016" => "Р",
			"017" => "С",
			"018" => "Т",
			"019" => "У",
			"020" => "Ф",
			"021" => "Х",
			"022" => "Ц",
			"023" => "Ч",
			"024" => "Ш",
			"025" => "Щ",
			"026" => "Ъ",
			"027" => "Ы",
			"028" => "Ь",
			"029" => "Э",
			"030" => "Ю",
			"031" => "Я",
			"032" => "Ё",
			"033" => "Й",
			"101" => "а",
			"102" => "б",
			"103" => "в",
			"104" => "г",
			"105" => "д",
			"106" => "е",
			"107" => "ж",
			"108" => "з",
			"109" => "и",
			"110" => "к",
			"111" => "л",
			"112" => "м",
			"113" => "н",
			"114" => "о",
			"115" => "п",
			"116" => "р",
			"117" => "с",
			"118" => "т",
			"119" => "у",
			"120" => "ф",
			"121" => "х",
			"122" => "ц",
			"123" => "ч",
			"124" => "ш",
			"125" => "щ",
			"126" => "ъ",
			"127" => "ы",
			"128" => "ь",
			"129" => "э",
			"130" => "ю",
			"131" => "я",
			"132" => "ё",
			"133" => "й",
			"A" => "A",
			"B" => "B",
			"C" => "C",
			"D" => "D",
			"E" => "E",
			"F" => "F",
			"G" => "G",
			"H" => "H",
			"I" => "I",
			"J" => "J",
			"K" => "K",
			"L" => "L",
			"M" => "M",
			"N" => "N",
			"O" => "O",
			"P" => "P",
			"Q" => "Q",
			"R" => "R",
			"S" => "S",
			"T" => "T",
			"U" => "U",
			"V" => "V",
			"W" => "W",
			"X" => "X",
			"Y" => "Y",
			"Z" => "Z",
			"aa" => "a",
			"bb" => "b",
			"cc" => "c",
			"dd" => "d",
			"ee" => "e",
			"ff" => "f",
			"gg" => "g",
			"hh" => "h",
			"ii" => "i",
			"jj" => "j",
			"kk" => "k",
			"ll" => "l",
			"mm" => "m",
			"nn" => "n",
			"oo" => "o",
			"pp" => "p",
			"qq" => "q",
			"rr" => "r",
			"ss" => "s",
			"tt" => "t",
			"uu" => "u",
			"vv" => "v",
			"ww" => "w",
			"xx" => "x",
			"yy" => "y",
			"zz" => "z"			
		);	
	}
	private function _Load() {
		global $core;
						if(!is_null($this->_list))
			array_splice($this->_list, 0, count($this->_list));
		else
			$this->_list = array();	
		if(is_empty($this->_outputdir))
			$this->_outputdir = $core->sts->ALPHABET_PATH.$this->_folder;
		$path = $core->fs->mappath($core->sts->ALPHABET_PATH.$this->_folder."/letters.ini", SITE);
		if($core->fs->fileexists($path)) {
			$contents = $core->fs->readfile($path);
			$contents = explode("\n", $contents);
			foreach($contents as $line) {
				$line = explode("=", $line);
				$letter = $line[0];
				if(!is_empty($line[0])) {
					$in = explode(",", @$line[1]);
					$info = new Object(null, "line_");
					$info->letter = $letter;
					$info->file = @$in[0];
					$info->width = @$in[1];
					$info->height = @$in[2];
					$this->_list[$letter] = $info;
				}
			}
		}
	}
	public function CreateAlphabetCollection() {
		global $core;
		$content = "";
		$path = $core->fs->mappath($core->sts->ALPHABET_PATH.$this->_folder."/", SITE);
		if($core->fs->direxists($path)) {
			$files = $core->fs->list_files($path, array("gif", "jpg", "png"));
			foreach($files as $file) {
				$i = new ImageEditor($file->file, $path);
				$width = $i->x;
				$height = $i->y;
                $i->Dispose();
				$content .= @$this->_chartofile[$file->file_name]."=".$file->file.",".$width.",".$height."\n";
			}
			$core->fs->writefile($path."letters.ini", $content);
		}
	}
	function ValidateChar($char) {
		switch(mb_strtolower($char, "UTF-8")) {
			default:
				return $char;
		}
	}
	public function Out($text, $spacer = " ", $imgclass = "", $prefix = "", $postfix = "") {
		global $core;
		$ret = "";
		$start = '<img src="';
		if($imgclass != "")
			$end = '" class="'.$imgclass.'" alt="'.$text.'" border="0" ';
		else
			$end = '" alt="'.$text.'" border="0" ';
		$width = ' width="';
		$height = ' height="';
		$sp = $this->_list[$spacer];
		$spacer = $start.$core->sts->ALPHABET_PATH.$this->_folder.'/'.$sp->file.$end.$width.$sp->width.'"'.$height.$sp->height.'" />';
				$len = mb_strlen($text, "UTF-8");
		for($i=0; $i<$len; $i++) {
			$char = mb_substr($text, $i, 1, "UTF-8");
			$letter = $this->_list[$char];
			$img = $start.$core->sts->ALPHABET_PATH.$this->_folder.'/'.$letter->file.$end.$width.$letter->width.'"'.$height.$letter->height.'" />';
			$ret .= $img.$spacer;
		}
		return $prefix.$ret.$postfix;
	}
	public function OutMerged($text, $spacer = " ", $imgclass = "", $prefix = "", $postfix = "", $orientation = HORIZONTAL, $type = "gif") {
		global $core;
		$images = array();
		if(!is_empty($spacer))
			$sp = $this->_list[$spacer];
		$rettext = "";
				$len = mb_strlen($text, "UTF-8");
		$path = $core->fs->mappath($core->sts->ALPHABET_PATH.$this->_folder);
		for($i=0; $i<$len; $i++) {
			$char = mb_substr($text, $i, 1, "UTF-8");
			$char = $this->ValidateChar($char);
			$rettext .= $char.(!is_empty($spacer) ? $spacer : "");
			$letter = @$this->_list[$char];
			@$images[] = new ImageEditor(@$letter->file, $path);
			if(!is_empty($spacer))
				@$images[] = new ImageEditor($sp->file, $path);
		}
		$fname = md5($this->_folder."/".$rettext).".".$type;
		$path = $core->fs->mappath($this->_outputdir);
		if($core->fs->fileexists($path."/".$fname)) {
			$merged = new ImageEditor($fname, $path);
			return $prefix.'<img src="'.$this->_outputdir."/".$fname.'" width="'.$merged->x.'" height="'.$merged->y.'" '.(!is_empty($imgclass) ? 'class="'.$imgclass.'"' : '').' alt="'.$text.'" />'.$postfix;
		}
		$merged = @ImageEditor::Merge($images, $type, $orientation);
		$merged->type = $type;
		$merged->outputFile($fname, $path."/");
        foreach($images as $ii) 
            $ii->Dispose();
		return $prefix.'<img src="'.$this->_outputdir."/".$fname.'" width="'.$merged->x.'" height="'.$merged->y.'" '.(!is_empty($imgclass) ? 'class="'.$imgclass.'"' : '').' alt="'.$text.'" />'.$postfix;
	}
}
?><?php
class Geo {
	static $databaseIpToCountry = "kernel/geoip/GeoIP.dat";
	static $databaseIpToRecord = "kernel/geoip/GeoLiteCity.dat";
	public static function CountryByIP($ip) {
		global $core, $CORE_PATH;
		require_once($CORE_PATH."/kernel/geoip/geoip.inc.php");
		if(is_numeric($ip))
			$ip = long2ip($ip);
		$output = new stdClass();
		$gi = geoip_open($core->fs->mappath(Geo::$databaseIpToCountry, CORE), GEOIP_STANDARD);
		$output->code = geoip_country_code_by_addr($gi, $ip);
		$output->name = geoip_country_name_by_addr($gi, $ip);
		geoip_close($gi);
		return Hashtable::Create($output);
	}
	public static function RecordByIP($ip) {
		global $core, $CORE_PATH;
		require_once($CORE_PATH."/kernel/geoip/geoipcity.inc.php");
		if(is_numeric($ip))
			$ip = long2ip($ip);
		$gi = geoip_open($core->fs->mappath(Geo::$databaseIpToRecord, CORE), GEOIP_STANDARD);
		$output = geoip_record_by_addr($gi,$ip);
		if(is_null($output))
			return new Hashtable();
		return Hashtable::Create($output);
	}
}
?><?php
class Encryption {
	static function Encrypt($key, $data) {
		$sha = sha256::hash($key);
		$data = rc4crypt::encrypt($sha, $data);
		$data = base64_encode($data);	
		return $data;
	}
	static function Decrypt($key, $data) {
		$sha = sha256::hash($key);
		$data = base64_decode($data);
		$data = rc4crypt::decrypt($sha, $data);
		return $data;
	}
}
?><?php
class GroupList extends arraylist {
	public $user;
	function __construct($user, $data = null){
		parent::__construct($data);
		$this->user = $user;
		$rs = UsersGroupsList::Groups($this->user, true);
		while($g = $rs->FetchNext()) {
			parent::Add($g->ug_group);
		}		
	}
    public function __destruct() {
        parent::__destruct();
    }    
	public function Add(Group $value, $index = -1) {
		if($value) {
			$g = $value->name;
			if(!parent::Contains($g)) {
				parent::Add($g, $index);
				UsersGroupsList::AttachToGroup(array($this->user), $value);
			}
		}
	}
	public function AddRange($values) {
		if($values) {
			foreach($values as $value) {
				if($value instanceof Group){
					$g = $value->name;
					if(!parent::Contains($g)) {
						parent::Add($g);
						UsersGroupsList::AttachToGroup(array($this->user), $value);
					}
				}
			}
		}
	}
	public function Delete(Group $value) {
		$index = parent::IndexOf($value->name);
		parent::Delete($index);
		UsersGroupsList::DetachFromGroup(array($this->user), $value);
	}
	public function DeleteRange($values) {
		foreach($values as $value) {
			$index = parent::IndexOf($value->name);
			if($index !== false) {
				parent::Delete($index);
				UsersGroupsList::DetachFromGroup(array($this->user), $value);
			}
		}
	}
	public function Item($index) {
		$g = parent::Item($index);
		return Group::Load($g);
	}
	public function FromString($data, $spl = ",", $callback = ""){
		if (is_empty($data))
			return $this->Clear();
		$data = explode($spl, $data);
		foreach($data as $item) {
			if (!is_empty($callback))
				$item = call_user_func($callback, $item);
			$this->Add(Group::Load($item));
		}
	}
	public function Clear() {
		UsersGroupsList::DetachFromGroup(array($this->user), null);
		parent::Clear();
	}
	public function Search($value, $key = null){
		$ret = array();
		foreach ($this as $k => $v){
			if (strtolower($v->name) == strtolower($value))
				$ret[] = $v;
		}
		return $ret;
	}
}
class User {
	private $_data;
	private $_callbacks;
	public function __construct($u = null) {        
		if($u == null)
			$this->_data = new stdClass();
		else {
			$uclass = strtolower(get_class($u));
			switch($uclass) {
				case "stdclass":
					$this->_data = $u;
					break;
                case "object":
					$this->_data = $u->Data();
					break;
				case "collection": 
					$this->_data = $u->to_object();
					break;
				default: 
								}
		}
		if($this->_data) {
			if(!($this->groups instanceof GroupList)) {
				$this->groups = new GroupList($this);
			}
			if(!($this->roles instanceof ArrayList))  {
				$r = $this->roles;
				$this->roles = new ArrayList();
			    $this->roles->FromString($r);
			}
            if(!($this->profile instanceof Hashtable)) {
                if(!is_null($this->profile))
                    $this->profile = new Hashtable(@unserialize($this->profile));
                else
                    $this->profile = new Hashtable();
            }
            $this->password = Encryption::Decrypt($this->name, $this->password);
        }
        $this->_callbacks = new Hashtable();        
    }
    public function __destruct() {
        if(!is_null($this->_callbacks))
            $this->_callbacks->Clear();
        unset($this->_data);
    }
	public function RegisterCallback($event, $callback) {
		$this->_callbacks->Add($event, $callback);
	}
	public function getRowData() {
		return $this->_data;
	}
	public function __get($property) {
		$property = "users_".$property;
        if(property_exists($this->_data, $property))
		    return @$this->_data->$property;
        else
            return false;
	}
	public function __set($property, $value) {
		$property = "users_".$property;
		@$this->_data->$property = $value;
	}
	public function Login($password) {
		return SecurityEx::$instance->Login($this, $password);
	}
	public function Logout() {
		SecurityEx::$instance->Logout();
	}
	public function isNobody() {
		return $this->name == "nobody";
	}
    public function isSupervisor() {
        return $this->name == "supervisor";
    }
	public function Save() {
		global $core;
		if(strtolower($this->name) == "supervisor") {
			return;
		}
		$d = clone $this->_data;
		$d->users_password = Encryption::Encrypt($d->users_name, $d->users_password);
		$d->users_roles = $d->users_roles->ToString();
		$data = Collection::Create($d);
		$data->Delete("users_groups");
		$data->users_profile = serialize($data->users_profile->Data());
		if(!User::Exists($this->name)) {
			$core->dbe->insert(US_USERS_TABLE, $data);
			SecurityEx::$users->Add($this->name);
		}
		else {
			$data->Delete("users_name");
			$core->dbe->set(US_USERS_TABLE, "users_name", $this->name, $data);
		}
	}
	public static function Load($name) {
		global $core;
		if($name == "supervisor") {
			return SecurityEx::$instance->Supervisor();
		}
		$rs = $core->dbe->ExecuteReader("select * from ".US_USERS_TABLE." where users_name='".$name."'", "users_name");
		if($rs->HasRows()) {
			return new User($rs->Read());
		}
		else {
			trigger_error(US_ERROR_USERCACHELOADFAILED.US_ERROR_INVALIDKEY, E_USER_ERROR);
			return null;
		}   
	}
	public static function Exists($name) {
		global $core;
		$rs = $core->dbe->ExecuteReader("select count(users_name) as c from ".US_USERS_TABLE." where users_name='".$name."'", "c");
		$count = $rs->Read();
		return $count->c > 0;
	}
	public static function Delete($user) {
		$name = $user;
		if($user instanceof User) {
			$name = $user->name;
		}
		global $core;
		$core->dbe->query("delete from sys_umusers where users_name='".$name."'");
		UsersGroupsList::DetachFromGroup(array($name), null);
		SecurityEx::$users->Delete($name);
	}
}
?><?php
class UserList extends ArrayList {
	public $group;
	function __construct($group){
		parent::__construct(null);
		$this->group = $group;
		$rs = UsersGroupsList::Users($this->group, true);
		while($u = $rs->FetchNext()) {
			parent::Add($u->ug_user);
		}		
	}
    public function __destruct() {
        parent::__destruct();
    }
	public function Add(User $value, $index = -1) {
		if($value) {
			$u = $value->name;
			if(!parent::Contains($u)) {
				parent::Add($u, $index);
				UsersGroupsList::AttachToGroup(array($value), $this->group);
			}
		}
	}
	public function AddRange($values) {
		if($values) {
			foreach($values as $value) {
				if($value instanceof User){
					$u = $value->name;
					if(!parent::Contains($u)) {
						parent::Add($u);
						UsersGroupsList::AttachToGroup(array($value), $this->group);
					}
				}
			}
		}
	}
	public function Delete(User $value) {
		$index = parent::IndexOf($value->name);
		parent::Delete($index);
		UsersGroupsList::DetachFromGroup(array($value), $this->group);
	}
	public function DeleteRange($values) {
		foreach($values as $value) {
			$index = parent::IndexOf($value->name);
			if($index !== false) {
				parent::Delete($index);
				UsersGroupsList::DetachFromGroup(array($value), $this->group);
			}
		}
	}
	public function Item($index) {
		$u = parent::Item($index);
		return User::Load($u);
	}
	public function FromString($data, $spl = ",", $callback = ""){
		if (is_empty($data))
			return $this->Clear();
		$data = explode($spl, $data);
		foreach($data as $item) {
			if (!is_empty($callback))
				$item = call_user_func($callback, $item);
			$this->Add(User::Load($item));
		}
	}
	public function Clear() {
		UsersGroupsList::DetachFromGroup(null, $this->group);
		parent::Clear();
	}
}
class Group {
	private $_data;
	public function __construct($g = false) {
		if($g) {
			if($g instanceof stdClass)
				$this->_data = $g;
			else if($g instanceof Object)
				$this->_data = $g->Data();	
		}
		else
			$this->_data = new stdClass();
		if($this->_data) {
			$this->users = new UserList($this);
		}
	}
    public function __destruct() {
        unset($this->_data);
    } 
	public function getRowData() {
		return $this->_data;
	}
	public function __get($property) {
		$property = "groups_".$property;
		return @$this->_data->$property;
	}
	public function __set($property, $value) {
		$property = "groups_".$property;
		@$this->_data->$property = $value;
	}
	public static function Exists($name) {
		global $core;
        $r = $core->dbe->ExecuteReader("select count(*) as c from ".US_GROUPS_TABLE." where lower(groups_name)='".to_lower($name)."'");
		$uc = $r->Read();
		return $uc->c > 0;
	}
	public function Save() {
		global $core;
		$c = clone $this->_data;
		$data = Collection::Create($c);
		$data->Delete("groups_users");
		if(!Group::Exists($this->name)) {
			$core->dbe->insert(US_GROUPS_TABLE, $data);
			SecurityEx::$groups->Add($this->name);
		}
		else {
			$data->Delete("groups_name");
			$core->dbe->set(US_GROUPS_TABLE, "groups_name", $this->name, $data);
		}
	}
	public static function Load($name) {
		global $core;
		if(Group::Exists($name)) {
			$r = $core->dbe->ExecuteReader("select * from ".US_GROUPS_TABLE." where lower(groups_name)='".to_lower($name)."'");
			$uc = $r->Read();
			return new Group($uc);
		}
		else {
					}
	}
	public static function Delete($group) {
		$name = $group;
		if($group instanceof Group) {
			$name = $group->name;
		}
		global $core;
		$core->dbe->query("delete from sys_umgroups where lower(groups_name)='".to_lower($name)."'");
		UsersGroupsList::DetachFromGroup(null, $name);
		SecurityEx::$groups->Delete($name);
	}
}
?><?php
class UsersGroupsList {
	public function __construct() {
	}
	public static function IsAttached($user, $group) {
		global $core;
		if($user instanceof User)
			$user = $user->name;
		if($group instanceof Group)
			$group = $group->name;
		$rs = $core->dbe->ExecuteReader("select count(*) as c from ".US_USERS_GROUPS_TABLE." where ug_user='".$user."' and ug_group='".$group."'");
		$c = $rs->Read();
		if($c !== false)
			return $c->c > 0;
		else 
			return false;
	}
	public static function AttachToGroup($users, $group) {
		global $core;
		if($group instanceof Group)
			$group = $group->name;
		foreach($users as $user) {
			if($user instanceof User)
				$user = $user->name;
			if(!UsersGroupsList::IsAttached($user, $group)) {
				$data = new Collection();
				$data->ug_user = $user;
				$data->ug_group = $group;
				$core->dbe->insert(US_USERS_GROUPS_TABLE, $data);
			}			
		}
	}
	public static function DetachFromGroup($users = null, $group = null) {
		global $core;
		if($group instanceof Group)
			$group = $group->name;
		if(is_null($users)){
			$core->dbe->query("delete from ".US_USERS_GROUPS_TABLE." where ug_group='".$group."'");
		}
		else{ 
			foreach($users as $user) {
				if($user instanceof User)
					$user = $user->name;
                if($user !== false)
				    $core->dbe->query("delete from ".US_USERS_GROUPS_TABLE." where ug_user='".$user."'".($group !== false ? " and ug_group='".$group."'" : ""));
			}
		}
	}
	public static function Users($group, $returnRowData = false) {
		global $core;
		if($group instanceof Group)
			$group = $group->name;
		$rs = $core->dbe->ExecuteReader("select * from ".US_USERS_GROUPS_TABLE." where ug_group='".$group."'");
		if($returnRowData)
			return $rs;
		$ret = new ArrayList();
		while($c = $rs->Read()) {
			$ret->Add(User::Load($c->ug_user));
		}
		return $ret;
	}
	public static function Groups($user, $returnRowData = false) {
		global $core;
		if($user instanceof User)
			$user = $user->name;
		$rs = $core->dbe->ExecuteReader("select * from ".US_USERS_GROUPS_TABLE." where ug_user='".$user."'");
		if($returnRowData)
			return $rs;
		$ret = new ArrayList();
		while($c = $rs->Read()) {
			$ret->Add(Group::Load($c->ug_group));
		}
		return $ret;
	}
}
?><?php
class Operations extends collection {
	public function __construct() {
		parent::__construct();
	}
    public function __destruct() {
        parent::__destruct();
    }
	public function Add(Operation $v) {
		parent::add($v->name, $v);
	}
	public function Merge($from) {
		foreach($from as $value) {
			$this->Add($value);
		}
	}
	private function SplitLevel($levels, $tolevel) {
        $l = array_splice($levels, 0, count($levels));
        $l = array_splice($l, 0, $tolevel+1);
        $s = join(".", $l);
		return $s.".";
	}
	private function CreateLevel($parent, $part, $level = 0) {
		$keys = $part->Keys();
		foreach($keys as $k) {
			$kp = preg_split("/\./", $k);
			if(count($kp) > $level + 1) {
				$item = $parent->Add($kp[$level], new Hashtable());
				                $sl = $this->SplitLevel($kp, $level);
                $sc = strlen($sl);
                $this->CreateLevel($item, $part->Part('substr($key, 0, '.$sc.') == "'.$sl.'"'), $level+1);
			}
			else
				$item = $parent->Add($kp[$level], $kp[$level]);
		}
	}
	public function CreateTree() {
		$c = clone $this;
        $tree = new Hashtable();
        $keys = $c->Keys();
        foreach($keys as $k) {
            $kp = preg_split("/\./", $k);
            if(count($kp) > 1) { 
                $parent = $tree;
                for($i=0; $i<count($kp); $i++) {
                    if(!$parent->Exists($kp[$i]))
                        $parent->Add($kp[$i], $i == count($kp)-1 ? $kp[$i] : new Hashtable());
                    $parent = $parent->Item($kp[$i]);
                    if(!($parent instanceOf Hashtable))
                        break;
                }                    
            }
            else
                $item = $tree->Add($kp[0], $kp[0]);
        }
		return $tree;
	}
}
class Operation {
	public $name;
	public $description;
	public function __construct($name, $description = null) {
		$this->name = $name;
		$this->description = $description;
	}
}
?><?php
class Role extends ArrayList {
	public $name;
	public $description;
	public function __construct($name, $description = null) {
		parent::__construct();
		$this->name = $name;
		$this->description = $description;
	}      
    public function __destruct() {
        parent::__destruct();
    }
	public function Add(RoleOperation $v) {
		parent::Add($v);
	}
	public function AddRange($values) {
		foreach($values as $value)
			if(!($value instanceof RoleOperation))
				trigger_error(US_ERROR_TYPEERROR, E_USER_ERROR);
			else
				$this->Add($value);
	}
	public function ToString($spl = ",", $kspl = ":") {
		if ($this->Count() == 0 || is_empty($spl))
			return "";	
		$ret = "";
		$i = 0;
		foreach ($this as $v){
			$ret .= (($i == 0) ? "" : $spl).((is_empty($kspl)) ? "" : $v->operation.$kspl).$v->permission;
			$i++;
		}
		return $ret;
	}
	public function FromString($data, $spl = ",", $kspl = ":") {
		if (is_empty($data) || is_empty($spl) || is_empty($kspl))
			return $this->Clear();
		$dt = explode($spl, $data);
		foreach ($dt as $t){
			$inf = explode($kspl, $t);
			$key = "";
			switch (count($inf)){
				case 2 :
					$key = $inf[0];
					$value = $inf[1];
					break;
				default: 
					return;
			}
			$this->Add(new RoleOperation($key, $value));
		}		
	}
}
class Roles extends Collection {
	public function __construct() {
		parent::__construct();
	}
	public function Add(Role $v) {
		parent::add($v->name, $v);
	}
}
class RoleOperation {
	public $permission;
	public $operation;
	public function __construct($operation = null, $permission = US_ROLE_DENY) {
		$this->operation = $operation;	
		$this->permission = $permission;
	}
}
?><?
define("US_ERROR_USERINITIALIZATIONFAILED", "The User initialization failed. ");
define("US_ERROR_USERCACHEINITFAILED", "Failed to crate cache from User. ");
define("US_ERROR_USERCACHELOADFAILED", "Failed to load cache from database. ");
define("US_ERROR_GROUPINITFAILED", "Failed to load group info. ");
define("US_ERROR_TYPEERROR", "The value is a wrong type. ");
define("US_ERROR_INVALIDUSER", "The value is a wrong type. ");
define("US_ERROR_INVALIDKEY", "The key is invalid. ");
define("US_ERROR_INVALID_OPERATION", "This operation is not valid. Please refer to the user manual.");
define("US_ERROR_CLASSISNOTMULTIINSTACE", "This class can not be initialized more than once.");
define("US_USERS_TABLE", "sys_umusers");
define("US_GROUPS_TABLE", "sys_umgroups");
define("US_USERS_GROUPS_TABLE", "sys_umusersgroups");
define("US_RETURN_ROW_DATA", 0);
define("US_RETURN_CONVERTED_DATA", 1);
define("US_SECTION_STRUCTURE", "structure");
define("US_SECTION_DATA", "data");
define("US_SECTION_INTERFACE", "interface");
define("US_SECTION_MODULES", "modules");
define("US_SECTION_TOOLS", "tools");
define("US_ROLE_ALLOW", 1);
define("US_ROLE_DENY", 0);
define("US_SECURITY_SERIALIZATION_SESSION", "serialized to session");
define("US_SECURITY_SERIALIZATION_COOKIE", "serialized to cookie");
define("US_SECURITY_SERIALIZATION_FILE", "serialized to file");
define("US_CACHE_PATH", "_system/_cache/security/");
define("US_GROUPS_CACHE", "grouplist.cache");
define("US_USERS_CACHE", "userlist.cache");
define("US_CUSTOMROLES_CACHE", "roles.cache");
class SecuritySystemInfoCache {
	static $instance = null;
	public $storage_path;
	public $roles;
	public $operations;
	public $operations_tree;
	public function __construct($storage_path = "/_system/_cache/security/") {
		$this->storage_path = $storage_path;
		$this->Load();	
	}
    public function __destruct() {
        $this->Dispose();
    }
    public function Dispose() {
         @$this->roles->Clear();
         @$this->operations->Clear();
         @$this->operations_tree->Clear();
    }
	public function Store() {
		global $core;
		$roles = serialize($this->roles);
		$operations = serialize($this->operations);
		$tree = serialize($this->operations_tree);
		$core->fs->writefile($this->storage_path."roles.cache", $roles, SITE);
		$core->fs->writefile($this->storage_path."operations.cache", $operations, SITE);
		$core->fs->writefile($this->storage_path."optree.cache", $tree, SITE);
        unset($roles);
        unset($operations);
        unset($tree);
	}
	public function Load() {
		global $core;
        if($core->fs->fileexists($this->storage_path."roles.cache", SITE))
			$this->roles = unserialize($core->fs->readfile($this->storage_path."roles.cache", SITE));
		else
			$this->roles = new Roles();
		if($core->fs->fileexists($this->storage_path."operations.cache", SITE))
			$this->operations = unserialize($core->fs->readfile($this->storage_path."operations.cache", SITE));
		else
			$this->operations = new Operations();
		if($core->fs->fileexists($this->storage_path."optree.cache", SITE))
			$this->operations_tree = unserialize($core->fs->readfile($this->storage_path."optree.cache", SITE));
		else
			$this->operations_tree = null;
	}
	public function RecreateCacheDatabase() {
        $this->operations->Clear();
		$global = new Operations();
		$global->Add(new Operation("structure.enter", "Add site"));
		$global->Add(new Operation("storages.enter", "Delete site"));
		$global->Add(new Operation("interface.enter", "Edit site properties"));
		$global->Add(new Operation("blobs.enter", "List the site content"));
		$global->Add(new Operation("notices.enter", "Add children"));
		$global->Add(new Operation("statistics.enter", "Delete children"));
		$global->Add(new Operation("settings.enter", "Edit children"));
		$global->Add(new Operation("sysrestore.enter", "Publish the entire site"));
		$global->Add(new Operation("usermanagement.enter", "Unpublish the entire site"));
        $global->Add(new Operation("modules.enter", "Unpublish the entire site"));
		$this->operations->Merge($global);
		$this->operations->Merge(Site::getOperations());
		$this->operations->Merge(Folder::getOperations());
		$this->operations->Merge(Storages::getOperations());
		$this->operations->Merge(Storage::getOperations());
		$this->operations->Merge(designTemplates::getOperations());
		$this->operations->Merge(Repository::getOperations());
		$this->operations->Merge(BlobCategories::getOperations());
		$this->operations->Merge(BlobCategory::getOperations());
		$this->operations->Merge(Notices::getOperations());
		$this->operations->Merge(Notice::getOperations());
		$this->operations->Merge(Statistics::getOperations());
		$this->operations->Merge(Settings::getOperations());
		$this->operations->Merge(Setting::getOperations());
		$this->operations->Merge(systemrestore::getOperations());
		$this->operations->Merge(SecurityEx::getOperations());
        $this->operations->Merge(CModuleManager::getOperations());
				$administrator = new Role("system_administrator", "System administrator");
		$administrator->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_ALLOW),
					new RoleOperation("interface.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_ALLOW),
					new RoleOperation("notices.*", US_ROLE_ALLOW),
					new RoleOperation("statistics.*", US_ROLE_ALLOW),
					new RoleOperation("settings.*", US_ROLE_ALLOW),
					new RoleOperation("sysrestore.*", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.*", US_ROLE_ALLOW),
                    new RoleOperation("modules.*", US_ROLE_ALLOW)
		));
		$backupAdministrator = new Role("backup_administrator", "Backup administrator");
		$backupAdministrator->Add(new RoleOperation("sysrestore.*", US_ROLE_ALLOW));
		$manager = new Role("manager", "Data manager");
		$manager->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_DENY),
					new RoleOperation("structure.enter", US_ROLE_ALLOW),
					new RoleOperation("structure.folders.publications.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_DENY),
					new RoleOperation("storages.enter", US_ROLE_ALLOW),
					new RoleOperation("storages.storage.data.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_DENY),
					new RoleOperation("blobs.enter", US_ROLE_ALLOW),
					new RoleOperation("blobs.items.*", US_ROLE_ALLOW),
                    new RoleOperation("modules.*", US_ROLE_ALLOW)
		));
		$powermanager = new Role("power_manager", "Powered manager");
		$powermanager->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_DENY),
					new RoleOperation("structure.enter", US_ROLE_ALLOW),
					new RoleOperation("structure.folders.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_DENY),
					new RoleOperation("storages.enter", US_ROLE_ALLOW),
					new RoleOperation("storages.storage.data.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_ALLOW),
					new RoleOperation("statistics.*", US_ROLE_ALLOW),
					new RoleOperation("settings.*", US_ROLE_DENY),
					new RoleOperation("settings.edit", US_ROLE_ALLOW),
					new RoleOperation("notices.*", US_ROLE_DENY),
					new RoleOperation("notices.notice.*", US_ROLE_DENY),
					new RoleOperation("notices.enter", US_ROLE_ALLOW),
					new RoleOperation("notices.send", US_ROLE_ALLOW), 
					new RoleOperation("notices.edit", US_ROLE_ALLOW),
                    new RoleOperation("modules.*", US_ROLE_ALLOW)
		));
		$usermanager = new Role("user_manager", "User manager");
		$usermanager->AddRange(array(
					new RoleOperation("usermanagement.*", US_ROLE_DENY),
					new RoleOperation("usermanagement.enter", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.users.*", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.groups.*", US_ROLE_ALLOW),
					new RoleOperation("usermanagement.permissions.*", US_ROLE_ALLOW)
		));
		$developer = new Role("developer", "Site developer");
		$developer->AddRange(array(
					new RoleOperation("structure.*", US_ROLE_ALLOW),
					new RoleOperation("storages.*", US_ROLE_ALLOW),
					new RoleOperation("interface.*", US_ROLE_ALLOW),
					new RoleOperation("blobs.*", US_ROLE_ALLOW),
					new RoleOperation("notices.*", US_ROLE_ALLOW),
					new RoleOperation("statistics.*", US_ROLE_ALLOW),
					new RoleOperation("settings.*", US_ROLE_ALLOW),
					new RoleOperation("sysrestore.*", US_ROLE_ALLOW),
					new RoleOperation("modules.*", US_ROLE_ALLOW)
		));
		$this->roles->Add($administrator);
		$this->roles->Add($backupAdministrator);
		$this->roles->Add($manager);
		$this->roles->Add($powermanager);
		$this->roles->Add($developer);
		$this->roles->Add($usermanager);
		$this->operations_tree = $this->operations->CreateTree();
		$this->Store();
	}
}
class UserListCache extends collection {
	function __construct(){
		parent::__construct();
	}
	public function Add($value) {
		if(!$value)
			return false;
		if($value instanceof User)
			$name = $value->name;
		else
			$name = $value;
		parent::Add($name, $name);
		$this->StoreCache();
	}
	public function Delete($value) {
		if(!$value)
			return false;		
		if($value instanceof User)
			$name = $value->name;
		else
			$name = $value;
		if(parent::exists($name)) {
			parent::Delete($name);
			User::Delete($name);
		}
		$this->StoreCache();
	}
	public function Item($key) {
		$key = $this->Key($key);
		if(!$this->exists($key))
			return false;
		return User::Load($key);
	}
	public function StoreCache() {
		global $core;		
					}
	public static function LoadCache() {
		global $core;
		$list = new UserListCache();
		$rs = $core->dbe->ExecuteReader("select users_name from ".US_USERS_TABLE);
		while($data = $rs->Read()) {
			$list->Add($data->users_name, $data->users_name);
		}
		return $list;
	}
}
class GroupListCache extends collection {
	function __construct(){
		parent::__construct();
	}
	public function Item($key) {
		$key = $this->Key($key);
		if(!$this->exists($key))
			return false;    
		return Group::Load($key);
	}
	public function Add($value) {
		if(!$value)
			return false;
		if($value instanceof Group)
			$name = $value->name;
		else
			$name = $value;
		parent::Add($name, $name);
		$this->StoreCache();
	}
	public function Delete($value) {
		if(!$value)
			return false;		
		if($value instanceof Group)
			$name = $value->name;
		else
			$name = $value;
		if(parent::exists($name)) {
			parent::Delete($name);
			Group::Delete($name);
		}		
		$this->StoreCache();
	}
	public function StoreCache() {
		global $core;		
					}
	public static function LoadCache() {
		global $core;
		$list = new GroupListCache();
		$rs = $core->dbe->ExecuteReader("select groups_name from ".US_GROUPS_TABLE);
		while($data = $rs->Read()) {
			$list->Add($data->groups_name, $data->groups_name);
		}
		return $list;
	}
}
class SecurityEx extends IEventDispatcher {
	static $instance = null;
	static $users = null;
	static $groups = null;
	public $systemInfo;
	public $serialization;
	private $_currentUser = null;
    private $_supervisor = null;
	public function __construct($systemCache = false, $serialization = US_SECURITY_SERIALIZATION_SESSION) {      
		if(!is_null(SecurityEx::$instance)) {
			throw new Exception(US_ERROR_CLASSISNOTMULTIINSTACE);
		}
        SecurityEx::$instance = $this;
		$this->_checkTables();
		$this->DispatchEvent("security.loading", null);
		$this->DispatchEvent("security.systeminfo.loading", null);
		if(!$systemCache)
			$this->systemInfo = new SecuritySystemInfoCache();
		else
			$this->systemInfo = $systemCache;
		$args = $this->DispatchEvent("security.systeminfo.loaded", Collection::Create($this->systemInfo));
		if(!is_null(@$args->systemInfo))
			$this->systemInfo = $args->systemInfo;
		$this->serialization = $serialization;
		$this->DispatchEvent("security.usermanagement.loading", null);
		SecurityEx::$users = UserListCache::LoadCache();
		SecurityEx::$groups = GroupListCache::LoadCache();
		$this->DispatchEvent("security.usermanagement.loaded", null);
		$this->DispatchEvent("security.loaded", null);
	}
    private function _loadCurrent() {
        if(is_null($this->_currentUser)) {
            if(@$_SESSION['CURRENT_USER'] != null)
                $this->_currentUser = User::Load($_SESSION['CURRENT_USER']);
            else
                $this->_currentUser = $this->Nobody();
        }
    }
    private function _loadSupervisor() {
        $this->_supervisor = $this->Supervisor();
    }
    public function __get($prop) {
        switch($prop) {
            case "currentUser":
                $this->_loadCurrent();
                return $this->_currentUser;
            case "supervisor":
                $this->_loadSupervisor();
                return $this->_supervisor;
        }
    }
    public function __set($prop, $value) {
        switch($prop) {
            case "currentUser":
                $this->_currentUser = $value;
        }
    }
    public function Dispose() {
                SecurityEx::$users->Clear();
        SecurityEx::$groups->Clear();
    }
	public function RegisterEvents() {
		$this->RegisterEvent("security.initializing");
		$this->RegisterEvent("security.initialized");
		$this->RegisterEvent("security.loading");
		$this->RegisterEvent("security.loaded");
		$this->RegisterEvent("security.systeminfo.loading");
		$this->RegisterEvent("security.systeminfo.loaded");
		$this->RegisterEvent("security.usermanagement.loading");
		$this->RegisterEvent("security.usermanagement.loaded");
		$this->RegisterEvent("security.user.loggingin");
		$this->RegisterEvent("security.user.logged");
		$this->RegisterEvent("security.user.loggingout");
		$this->RegisterEvent("security.user.loggedout");
		$this->RegisterEvent("security.permissions.checking");
		$this->RegisterEvent("security.permissions.checked");
		$this->RegisterEvent("security.permissions.batch.checking");
		$this->RegisterEvent("security.permissions.batch.checked");
		$this->RegisterEvent("security.permissions.role.checking");
		$this->RegisterEvent("security.permissions.role.checked");
	}
	public function RegisterEventHandlers() {
		$this->DispatchEvent("security.initializing", null);
		$this->DispatchEvent("security.initialized", null);
	}
	public function Initialize() {
	}
	public function Nobody() {
		$u = new User();
		$u->name = "nobody";
		$u->description = "Default uninitialized user";
		$u->password = "";
		return $u;
	}
	public function Supervisor() {
		$u = new User();
		$u->name = "supervisor";
		$u->description = "Super user";
		$u->password = Encryption::Decrypt("supervisor", "eogW/V/dQx5sRC8=");
		$u->roles->Add("system_administrator");
		return $u;
	}
	public function Login($userName, $password)	{
		$args = $this->DispatchEvent("security.user.loggingin", Collection::Create("username", $userName, "password", $password));
		if(@$args->cancel) 
			return @$args->logged;
		if($userName instanceof User)
			$currentUser = $userName;
		else {
			if(SecurityEx::$users->exists($userName) || $userName == "supervisor")
				$currentUser = User::Load($userName);
			else {
				$this->DispatchEvent("security.user.logged", Collection::Create("success", false));
				return false; 
			}
		}
		if($currentUser->password == $password) {
			$this->currentUser = $currentUser;
			$this->currentUser->LastLoginDate = time();
			$this->currentUser->LastLoginFrom = get_ip();
			$this->setLogged($this->currentUser);
			$this->currentUser->Save();
			$this->DispatchEvent("security.user.logged", Collection::Create("success", true));
			return true;
		}
		$this->currentUser = $this->Nobody();
		$this->DispatchEvent("security.user.logged", Collection::Create("success", false));
		return false;
	}
	public function Logout() {
		$this->DispatchEvent("security.user.loggingout", null);
		$this->setLoggedOut();
		$this->currentUser = $this->Nobody();		
		$this->DispatchEvent("security.user.loggedout", null);
	}
	public function setLogged($user) {
		global $core;
		$core->rq->CURRENT_USER = $user->name;
	}
	public function setLoggedOut() {
		global $core;
		$core->rq->CURRENT_USER = null;
	}
	private function _compareOperation($operation, $roleoperation) {
		$roleoperation = preg_quote($roleoperation);
		$roleoperation = str_replace("\*", "(.*?)", $roleoperation);
		return preg_match("/".$roleoperation."/", $operation) > 0;
	}
	public function CheckBatch($objects, $user = null) {
		if(is_null($user))
			$user = $this->currentUser;
		$arg = $this->DispatchEvent("security.permissions.batch.checking", Hashtable::Create("objects", $objects, "user", $user));
		if(@$arg->cancel)
			return (boolean)($args->rights == 1);
		foreach($objects as $item) {
			$object = $item["object"];
			$operation = $item["operation"];
			if(($rights = $this->_checkOwnPermissions($object, $operation, $user)) > -1) {
				$args = $this->DispatchEvent("security.permissions.batch.checked", Hashtable::Create("objects", $objects, "user", $user, "rights", $rights));
				if(@$args->cancel)
					return (boolean)($args->rights == 1);
				return (boolean)($rights == 1);
			}
		}
		foreach($objects as $item) {
			$operation = $item["operation"];
			if(($rights = $this->_checkRolePermissions($operation, $user)) > -1) {
				$args = $this->DispatchEvent("security.permissions.batch.checked", Hashtable::Create("objects", $objects, "user", $user, "rights", $rights));
				if(@$args->cancel)
					return (boolean)($args->rights == 1);
				return (boolean)($rights == 1);
			}
		}
		$args = $this->DispatchEvent("security.permissions.batch.checked", Hashtable::Create("objects", $objects, "user", $user, "rights", $rights));
		if(@$args->cancel)
			return $args->rights;
		return (boolean)($rights == 1);
	}
	public function Check($object = null, $operation = "", $user = null) {
		if($operation == "")
			return false;
		if(is_null($user))
			$user = $this->currentUser;
		$arg = $this->DispatchEvent("security.permissions.checking", Hashtable::Create("object", $object, "operation", $operation, "user", $user));
		if(@$arg->cancel)
			return $args->rights;
		if($object != null) {
			if(($rights = $this->_checkOwnPermissions($object, $operation, $user)) < 0) {
				$rights = $this->_checkRolePermissions($operation, $user);
			}	
		}
		else
			$rights = $this->_checkRolePermissions($operation, $user);
		$args = $this->DispatchEvent("security.permissions.checked", Hashtable::Create("object", $object, "operation", $operation, "user", $user, "rights", $rights));
		if(@$args->cancel)
			return (boolean)($args->rights == 1);
		return (boolean)($rights == 1);
	}
	private function _checkRolePermissions($operation, $user) {
		$roles = $user->roles;
		$permissions = new Collection();
		foreach($roles as $role) {
			$r = $this->systemInfo->roles->$role;
			if ($r == null)
				continue;
			foreach($r as $op)
				$permissions->Add($op->operation, $op->permission);
		}
				$rights = -1;
		foreach($permissions as $roleoperation => $permission) {
			if($this->_compareOperation($operation, $roleoperation)) {
				$rights = $permission;
			}
		}
		return $rights;
	}	
	private function _checkOwnPermissions($object, $operation, $user) {
		$permissions = new Collection();
				if($object->securitycache->Count() > 0) {
						foreach($object->securitycache as $key => $item) {
				if($user->name == $key) {
					foreach($item as $ro) {
						$permissions->Add($ro->operation, $ro->permission);
					}
					continue;
				}
				$founded = $user->groups->Search($key);
				if(count($founded) > 0) {
					foreach($item as $ro) {
						$permissions->Add($ro->operation, $ro->permission);
					}
					continue;
				}
			}
		}
		else {
			return -1;
		}
		if($permissions->Count() == 0) {
			return -1;
		}
		$rights = 0;
		foreach($permissions as $roleoperation => $permission) {
			if($this->_compareOperation($operation, $roleoperation)) {
				$rights  = $permission;
			}
		}
		return $rights;
	}
	public static function getOperations() {
		$operaions = new Operations();
		$operaions->Add(new Operation("usermanagement.users.add", "Add a new user"));
		$operaions->Add(new Operation("usermanagement.users.delete", "Delete the user"));
		$operaions->Add(new Operation("usermanagement.users.edit", "Edit main user info"));
		$operaions->Add(new Operation("usermanagement.groups.add", "Add a user group"));
		$operaions->Add(new Operation("usermanagement.groups.delete", "Delete the group"));
		$operaions->Add(new Operation("usermanagement.groups.edit", "Edit group properties"));
		$operaions->Add(new Operation("usermanagement.roles.create", "Create a role"));
		$operaions->Add(new Operation("usermanagement.roles.delete", "Remove the role"));
		$operaions->Add(new Operation("usermanagement.roles.edit", "Edit the role"));
		$operaions->Add(new Operation("usermanagement.persmissions.set", "Set the permissions"));
		$operaions->Add(new Operation("usermanagement.cache.recreate", "Edit the role"));
		return $operaions;
	}
	private function _checkTables() {
		global $core;
		if(!$core->dbe->tableexists("sys_umusers")) {
            $core->dbe->CreateTable('sys_umusers', array(
                'users_name' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                'users_created' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_modified' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_password' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
                'users_lastlogindate' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_lastloginfrom' => array('type' => 'datetime', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                'users_roles' => array('type' => 'longtext', 'additional' => ''),
                'users_profile' => array('type' => 'longtext', 'additional' => ''),
            ), array(
                'users_name' => array('fields' => 'users_name', 'constraint' => 'PRIMARY KEY')
            ), '');
        }
        if(!$core->dbe->tableexists("sys_umgroups")) {
            $core->dbe->CreateTable('sys_umgroups', array(
                'groups_name' => array('type' => 'longvarchar', 'additional' => 'NOT NULL default \'\''),
                'groups_description' => array('type' => 'tinytext', 'additional' => '')
            ), array(
                'groups_name' => array('fields' => 'groups_name', 'constraint' => 'PRIMARY KEY')
            ), '');
        }
        if(!$core->dbe->tableexists("sys_umusersgroups")) {
            $core->dbe->CreateTable('sys_umusersgroups', array(
                'user' => array('type' => 'varchar', 'additional' => 'NOT NULL default \'\''),
                'group' => array('type' => 'varchar', 'additional' => 'NOT NULL default \'\'')
            ), array(
                'user_group' => array('fields' => 'user,group', 'constraint' => 'PRIMARY KEY')
            ), '');
        }
	}
}
?>
<?php
	global $mime_types;
	$mime_types = array(
        "acx" =>  "application/internet-property-stream",
        "ai" =>  "application/postscript",
        "aif" =>  "audio/x-aiff",
        "aifc" =>  "audio/x-aiff",
        "aiff" =>  "audio/x-aiff",
        "asf" =>  "video/x-ms-asf",
        "asr" =>  "video/x-ms-asf",
        "asx" =>  "video/x-ms-asf",
        "au" =>  "audio/basic",
        "avi" =>  "video/x-msvideo",
        "flv" =>  "video/x-msvideo",
        "axs" =>  "application/olescript",
        "bas" =>  "text/plain",
        "bcpio" =>  "application/x-bcpio",
        "bin" =>  "application/octet-stream",
        "bmp" =>  "image/bmp",
        "c" =>  "text/plain",
        "cat" =>  "application/vnd.ms-pkiseccat",
        "cdf" =>  "application/x-cdf",
        "cer" =>  "application/x-x509-ca-cert",
        "class" =>  "application/octet-stream",
        "clp" =>  "application/x-msclip",
        "cmx" =>  "image/x-cmx",
        "cod" =>  "image/cis-cod",
        "cpio" =>  "application/x-cpio",
        "crd" =>  "application/x-mscardfile",
        "crl" =>  "application/pkix-crl",
        "crt" =>  "application/x-x509-ca-cert",
        "csh" =>  "application/x-csh",
        "css" =>  "text/css",
        "dcr" =>  "application/x-director",
        "der" =>  "application/x-x509-ca-cert",
        "dir" =>  "application/x-director",
        "dll" =>  "application/x-msdownload",
        "dms" =>  "application/octet-stream",
        "doc" =>  "application/msword",
        "docx" =>  "application/msword",
        "dot" =>  "application/msword",
        "dvi" =>  "application/x-dvi",
        "dxr" =>  "application/x-director",
        "eps" =>  "application/postscript",
        "etx" =>  "text/x-setext",
        "evy" =>  "application/envoy",
        "exe" =>  "application/octet-stream",
        "fif" =>  "application/fractals",
        "flr" =>  "x-world/x-vrml",
        "gif" =>  "image/gif",
        "gtar" =>  "application/x-gtar",
        "gz" =>  "application/x-gzip",
        "h" =>  "text/plain",
        "hdf" =>  "application/x-hdf",
        "hlp" =>  "application/winhlp",
        "hqx" =>  "application/mac-binhex40",
        "hta" =>  "application/hta",
        "htc" =>  "text/x-component",
        "htm" =>  "text/html",
        "html" =>  "text/html",
        "htt" =>  "text/webviewhtml",
        "ico" =>  "image/x-icon",
        "ief" =>  "image/ief",
        "iii" =>  "application/x-iphone",
        "ins" =>  "application/x-internet-signup",
        "isp" =>  "application/x-internet-signup",
        "jfif" =>  "image/pipeg",
        "jpe" =>  "image/jpeg",
        "jpeg" =>  "image/jpeg",
        "jpg" =>  "image/jpeg",
		"png" =>  "image/png",
        "js" =>  "application/x-javascript",
        "latex" =>  "application/x-latex",
        "lha" =>  "application/octet-stream",
        "lsf" =>  "video/x-la-asf",
        "lsx" =>  "video/x-la-asf",
        "lzh" =>  "application/octet-stream",
        "m13" =>  "application/x-msmediaview",
        "m14" =>  "application/x-msmediaview",
        "m3u" =>  "audio/x-mpegurl",
        "man" =>  "application/x-troff-man",
        "mdb" =>  "application/x-msaccess",
        "me" =>  "application/x-troff-me",
        "mht" =>  "message/rfc822",
        "mhtml" =>  "message/rfc822",
        "mid" =>  "audio/mid",
        "mny" =>  "application/x-msmoney",
        "mov" =>  "video/quicktime",
        "movie" =>  "video/x-sgi-movie",
        "mp2" =>  "video/mpeg",
        "mp3" =>  "audio/mpeg",
        "mpa" =>  "video/mpeg",
        "mpe" =>  "video/mpeg",
        "mpeg" =>  "video/mpeg",
        "mpg" =>  "video/mpeg",
        "mpp" =>  "application/vnd.ms-project",
        "mpv2" =>  "video/mpeg",
        "ms" =>  "application/x-troff-ms",
        "mvb" =>  "application/x-msmediaview",
        "nws" =>  "message/rfc822",
        "oda" =>  "application/oda",
        "p10" =>  "application/pkcs10",
        "p12" =>  "application/x-pkcs12",
        "p7b" =>  "application/x-pkcs7-certificates",
        "p7c" =>  "application/x-pkcs7-mime",
        "p7m" =>  "application/x-pkcs7-mime",
        "p7r" =>  "application/x-pkcs7-certreqresp",
        "p7s" =>  "application/x-pkcs7-signature",
        "pbm" =>  "image/x-portable-bitmap",
        "pdf" =>  "application/pdf",
        "pfx" =>  "application/x-pkcs12",
        "pgm" =>  "image/x-portable-graymap",
        "pko" =>  "application/ynd.ms-pkipko",
        "pma" =>  "application/x-perfmon",
        "pmc" =>  "application/x-perfmon",
        "pml" =>  "application/x-perfmon",
        "pmr" =>  "application/x-perfmon",
        "pmw" =>  "application/x-perfmon",
        "pnm" =>  "image/x-portable-anymap",
        "pot => ", "application/vnd.ms-powerpoint",
        "ppm" =>  "image/x-portable-pixmap",
        "pps" =>  "application/vnd.ms-powerpoint",
        "ppt" =>  "application/vnd.ms-powerpoint",
        "prf" =>  "application/pics-rules",
        "ps" =>  "application/postscript",
        "pub" =>  "application/x-mspublisher",
        "qt" =>  "video/quicktime",
        "ra" =>  "audio/x-pn-realaudio",
        "ram" =>  "audio/x-pn-realaudio",
        "ras" =>  "image/x-cmu-raster",
        "rgb" =>  "image/x-rgb",
        "rmi" =>  "audio/mid",
        "roff" =>  "application/x-troff",
        "rtf" =>  "application/rtf",
        "rtx" =>  "text/richtext",
        "scd" =>  "application/x-msschedule",
        "sct" =>  "text/scriptlet",
        "setpay" =>  "application/set-payment-initiation",
        "setreg" =>  "application/set-registration-initiation",
        "sh" =>  "application/x-sh",
        "shar" =>  "application/x-shar",
        "sit" =>  "application/x-stuffit",
        "snd" =>  "audio/basic",
        "spc" =>  "application/x-pkcs7-certificates",
        "spl" =>  "application/futuresplash",
        "src" =>  "application/x-wais-source",
        "sst" =>  "application/vnd.ms-pkicertstore",
        "stl" =>  "application/vnd.ms-pkistl",
        "stm" =>  "text/html",
        "sv4cpio" =>  "application/x-sv4cpio",
        "sv4crc" =>  "application/x-sv4crc",
        "t" =>  "application/x-troff",
        "tar" =>  "application/x-tar",
        "tcl" =>  "application/x-tcl",
        "tex" =>  "application/x-tex",
        "texi" =>  "application/x-texinfo",
        "texinfo" =>  "application/x-texinfo",
        "tgz" =>  "application/x-compressed",
        "tif" =>  "image/tiff",
        "tiff" =>  "image/tiff",
        "tr" =>  "application/x-troff",
        "trm" =>  "application/x-msterminal",
        "tsv" =>  "text/tab-separated-values",
        "txt" =>  "text/plain",
        "uls" =>  "text/iuls",
        "ustar" =>  "application/x-ustar",
        "vcf" =>  "text/x-vcard",
        "vrml" =>  "x-world/x-vrml",
        "wav" =>  "audio/x-wav",
        "wcm" =>  "application/vnd.ms-works",
        "wdb" =>  "application/vnd.ms-works",
        "wks" =>  "application/vnd.ms-works",
        "wmf" =>  "application/x-msmetafile",
        "wps" =>  "application/vnd.ms-works",
        "wri" =>  "application/x-mswrite",
        "wrl" =>  "x-world/x-vrml",
        "wrz" =>  "x-world/x-vrml",
        "xaf" =>  "x-world/x-vrml",
        "xbm" =>  "image/x-xbitmap",
        "xla" =>  "application/vnd.ms-excel",
        "xlc" =>  "application/vnd.ms-excel",
        "xlm" =>  "application/vnd.ms-excel",
        "xls" =>  "application/vnd.ms-excel",
        "xlsx" =>  "application/vnd.ms-excel",
        "xlt" =>  "application/vnd.ms-excel",
        "xlw" =>  "application/vnd.ms-excel",
        "xof" =>  "x-world/x-vrml",
        "xpm" =>  "image/x-xpixmap",
        "xwd" =>  "image/x-xwindowdump",
        "z" =>  "application/x-compress",
        "zip" =>  "application/zip", 
        "swf" => "application/x-shockwave-flash"
	);
	global $browserCapableTypes;
	$browserCapableTypes = array(
		"jpg", "png", "gif",
		"swf",
		"html", "htm",
		"css", "js",
		"xml", "xsl" 
	);
	global $fileicons; 	
	class MimeType {
		private $_type;
		public function __construct($type) {
			$this->_type = $type;
			global $fileicons;
			if(is_null($fileicons) || !($fileicons instanceOf IconPack))
				$fileicons = new IconPack("file_icons_50_gs", "/utils/images", CORE);
		}
		public function __get($field) {
			global $mime_types;
			global $browserCapableTypes;
			switch($field) {
				case "mime":
					return @$mime_types[$this->_type];
				case "isCapable":
					return array_search($this->_type, $browserCapableTypes) !== false;
				case "isValid":
					return array_key_exists($this->_type, $mime_types);
				case "isImage":
					return in_array(strtolower($this->_type), array("gif", "jpeg", "jpg", "png", "bmp", "dib"));
				case "isAudio":
					return in_array(strtolower($this->_type), array("mid", "mp3", "au"));
				case "isVideo":
					return in_array(strtolower($this->_type), array("wmv", "mpg", "mp4"));
				case "isViewable":
					return in_array(strtolower($this->_type), array("gif", "jpg", "jpeg", "png", "swf"));
				case "isFlashVideo":
					return in_array(strtolower($this->_type), array("flv"));
				case "isFlash":
					return in_array(strtolower($this->_type), array("swf"));
				case "icon":
					return $this->_getFileIcon();
				case "iconImage":
					return '<img src="'.$this->_getFileIcon().'" />';
				case "type" :
					return $this->_type;
				default :
			}
		}
		private function _getFileIcon() {
			global $core, $fileicons;
			$filename = "iconpack(".strtolower($this->_type).")";
			if(!$this->isValid)
				return $fileicons->IconFromPack("iconpack(bloken)");
			if(!$fileicons->Exists($this->_type))
				return $fileicons->IconFromPack("iconpack(unknown)");
			return $fileicons->IconFromPack($filename);
		}
		private function _getBrowseTag() {
			switch($this->_type) {
				case "jpg":
				case "png":
				case "gif":
					return "IMG";
				case "swf":
					return "OBJECT";
				case "css":
					return "STYLE";
			}
			return null;
		}
		public static function Get($filename) {
			return new MimeType(end(explode(".", basename($filename))));
		}
		public static function GetFileType($mimetype) {
			return new FileType($mimetype);
		}
	}
	class FileType {
		private $_mime;
		private $_types;
		public function ___construct($mime) {
			global $mime_types;
			if(is_string($mime)) {
				$this->_types = array_keys($mime_types, $mime);
				$this->_mime = $mime;
			}
			else if($mime instanceof MimeType) {
				$this->_types = array_keys($mime_types, $mime->mime);
				$this->_mime = $mime->mime;
			}
			else {
				$this->_types = array();
				$this->_mime = "";
			}
			global $fileicons;
			if(is_null($fileicons))
				$fileicons = new IconPack("file_icons_50", "/utils/images", CORE);
		}
		public function Item($index) {
			return $this->_types[$index];
		}
		public function __get($field) {
			global $mime_types;
			switch($field) {
				case "mimetype":
					if(count($this->_types) > 0)
						return MimeType($this->_types[0]);
					else	
						return null;
				case "isValid":
					foreach($this->_types as $type) {
						if(array_key_exists($type, $mime_types))	
							return false;
					}
					return true;
				case "isImage":
					foreach($this->_types as $type) {
						if(!in_array(strtolower($type), array("gif", "jpeg", "jpg", "png", "bmp", "dib")))
							return false;
					}
					return true;
				case "isFlash":
					foreach($this->_types as $type) {
						if(!in_array(strtolower($type), array("swf")))
							return false;
					}
					return true;
                case "isAudio":
                    foreach($this->_types as $type) {
                        if(!in_array(strtolower($type), array("au","mp3","wma")))
                            return false;
                    }
                    return true;
                case "isAudio":
                    foreach($this->_types as $type) {
                        if(!in_array(strtolower($type), array("flv","avi","mp2", "mpeg", "mpg")))
                            return false;
                    }
                    return true;
                case "icon":
					return $this->_getFileIcon();
				case "type" :
					return $this->_type;
				default :
			}
		}
		private function _getFileIcon($index = 0) {
			global $core, $fileicons;
			$filename = "iconpack(".strtolower($this->_types[$index]).")";
			if(!$this->isValid) {
				return $fileicons->IconFromPack("iconpack(bloken)");
			}
			if(!$fileicons->Exists($this->_types[$index]))
				return $fileicons->IconFromPack("iconpack(unknown)");
			return $fileicons->IconFromPack($filename);
		}
	}
?><?php
class Size {
	public $width;
	public $height;
	public function __construct($width = 0, $height = 0) {
		$this->width = $width;
		$this->height = $height;
	}
	public function __get($nm) {
		switch($nm) {
			case "style":
				return ($this->width != 0 ? "width:".intval($this->width)."px;" : "").($this->height != 0 ? "height:".intval($this->height)."px;" : "");
			case "attributes":
				return ($this->width != 0 ? " width=\"".intval($this->width)."\"" : "").($this->height != 0 ? " height=\"".intval($this->height)."\"" : "");
			case "params":
				return ($this->width != 0 ? "&w=".intval($this->width) : "").($this->height != 0 ? "&h=".intval($this->height) : "");
			case "isNull":
				return ($this->width == 0 && $this->height == 0);
		}
		return null;
	}
	public function TransformTo($size) {
		$width = $size->width;
		$height = $size->height;
		$rheight = null; 		$rwidth = null; 		$originalwidth = $this->width;
		$originalheight = $this->height;
		if($width == 0 && $height == 0) {
			$originalwidth = $width;
			$originalheight = $height;
		}
		else if($width == 0) {
			$rheight = ($height <= $originalheight ? $height : $originalheight);
			$otnoshenie = $originalheight / $originalwidth;
			$rwidth = $rheight / $otnoshenie;
		}
		else if($height == 0) {
			$rwidth = ($width <= $originalwidth ? $width : $originalwidth);
			$otnoshenie = $originalwidth / $originalheight;
			$rheight = $rwidth / $otnoshenie;
		}
        else {
	    if($originalwidth <= $width && $originalheight <= $height) {
                $rwidth = $originalwidth;
                $rheight = $originalheight;
			}
            else if($originalwidth / $width > $originalheight / $height) {
                $rwidth = $width;
                $rheight = $originalheight * ($width / $originalwidth);
            }
            else {
                $rheight = $height;
                $rwidth = $originalwidth * ($height / $originalheight);
			}
		}
        $originalwidth = $rwidth;
        $originalheight = $rheight;
        return new Size((int)$originalwidth, (int)$originalheight);
	}
	function TransformToFill($size) {
		$width = $size->width;
		$height = $size->height;
		$rheight = null; 		$rwidth = null; 		$originalwidth = $this->width;
		$originalheight = $this->height;
		if($width == 0 && $height == 0) { 
			$originalwidth = $width;
			$originalheight = $height;
		}
		else if($width == 0) {
			$rheight = ($height <= $originalheight ? $height : $originalheight);
			$otnoshenie = $originalheight / $originalwidth;
			$rwidth = $rheight / $otnoshenie;
		}
		else if($height == 0) {
			$rwidth = ($width <= $originalwidth ? $width : $originalwidth);
			$otnoshenie = $originalwidth / $originalheight;
			$rheight = $rwidth / $otnoshenie;
		}
        else {
			if($originalwidth <= $width && $originalheight <= $height) {
                $rwidth = $originalwidth;
                $rheight = $originalheight;
			}
            else if($originalwidth / $width > $originalheight / $height) {
                $rheight = $height;
                $rwidth = $originalwidth * ($height / $originalheight);
            }
            else {
                $rwidth = $width;
                $rheight = $originalheight * ($width / $originalwidth);
			}
		}
        $originalwidth = $rwidth;
        $originalheight = $rheight;
        return new Size((int)$originalwidth, (int)$originalheight);
	}
	public function Expand($w, $h) {
		$this->width += $w;
		$this->height += $h;
	}	
}
?><?php
class Point {
	public $x;
	public $y;
	public function __construct($x = 0, $y = 0) {
		$this->x = $x;
		$this->y = $y;
	}
}
?><?
	class Region extends ArrayList {
		public function __construct() {
			parent::__construct();
		}
	}
	class NamedRegion extends Collection {
		public function __construct() {
			parent::__construct();
		}
	}
	class Quadro extends NamedRegion {
		public function __construct() {
			parent::__construct();
			$this->Add("lowerleft", new Point(0,0));
			$this->Add("lowerright", new Point(0,0));
			$this->Add("upperright", new Point(0,0));
			$this->Add("upperleft", new Point(0,0));
		}
        public function Inscribe() {
            $r = clone $this;
            $this->lowerleft->x = $r->lowerleft->x;
            $this->lowerleft->y = $r->upperleft->y; 
            $this->lowerright->x = $r->lowerleft->x;
            $this->lowerright->y = $r->lowerright->y; 
            $this->upperright->x = $r->upperright->x;
            $this->upperright->y = $r->lowerright->y; 
            $this->upperleft->x = $r->upperright->x;
            $this->upperleft->y = $r->upperleft->y; 
        }
		public function __get($prop) {
			switch($prop) {
				case "size":
                    return new Size(abs($this->upperleft->x - $this->lowerleft->x), 
                                    abs($this->lowerright->y - $this->lowerleft->y));
				default: 
					return parent::__get($prop);
			}
		}
	}
?><?php
class Font {
	private $_file;
	private $_path;
    private $_angle;
	private $_fontSize;
	public function __construct($fontFile, $path = '', $fontSize = 0, $angle = 0) {
        global $core;
		$this->_file = $fontFile;
		$this->_path = $path;
        if(is_empty($this->_path))
            $this->_path = $core->sts->GDIFONTPATH;
		$this->_fontSize = $fontSize;
        if($this->_fontSize == 0)
            $this->_fontSize = 12;
        $this->_angle = $angle;
		if($this->_file == '') {
            $this->_file = basename($this->_path);
            $this->_path = dirname($this->_path);
        }
	}
	public function __get($prop) {
		switch($prop) {
			case "file":
				return $this->_file;
			case "path":
				return $this->_path;
            case "angle":
                return $this->_angle;
			case "src":
				global $core;
				return $core->fs->mappath($this->_path)."/".$this->_file;
			case "size":
				return $this->_fontSize;
		}
		return null;
	}
	public function MeasureText($text) {
		global $core;
		$ar = imagettfbbox($this->_fontSize, $this->_angle, $core->fs->mappath($this->_path)."/".$this->_file, $text);
		$r = new Quadro();
		$r->lowerleft->x = $ar[0];
		$r->lowerleft->y = $ar[1];
		$r->lowerright->x = $ar[2];
		$r->lowerright->y = $ar[3];
		$r->upperright->x = $ar[4];
		$r->upperright->y = $ar[5];
		$r->upperleft->x = $ar[6];
		$r->upperleft->y = $ar[7];
		return $r;
	}
    public function InscribeText($text, &$startAt, &$size) {
        global $core;
        $rect = imagettfbbox( $this->_fontSize, 0, $core->fs->mappath($this->_path)."/".$this->_file, $text.'|' );
        if( 0 == $this->_angle ) {
            $size->height = $rect[1] - $rect[7];
            $size->width = $rect[2] - $rect[0];
            $startAt->x = -1 - $rect[0];
            $startAt->y = -1 - $rect[7];
        } else {
            $rad = deg2rad( $this->_angle );
            $sin = sin( $rad );
            $cos = cos( $rad );
            if( $this->_angle > 0 ) {
                $tmp = $rect[6] * $cos + $rect[7] * $sin;
                $startAt->x = -1 - round( $tmp );
                $size->width = round( $rect[2] * $cos + $rect[3] * $sin - $tmp );
                $tmp = $rect[5] * $cos - $rect[4] * $sin;
                $startAt->y = -1 - round( $tmp );
                $size->height = round( $rect[1] * $cos - $rect[0] * $sin - $tmp );
            } else {
                $tmp = $rect[0] * $cos + $rect[1] * $sin;
                $startAt->x = abs(round( $tmp ));
                $size->width = round( $rect[4] * $cos + $rect[5] * $sin - $tmp ) + 2;
                $tmp = $rect[7] * $cos - $rect[6] * $sin;
                $startAt->y = abs(round( $tmp ));
                $size->height = round( $rect[3] * $cos - $rect[2] * $sin - $tmp ) + 5;
            }
        }
    }
}
?><?php
class Blobs extends ArrayList {
	public function __construct($parent = null, $sort = null, $page = -1, $pagesize = 10) {
		parent::__construct();
		$this->_parent = $parent;
		$this->Load($sort, $page, $pagesize);
	}
	public function Load($sort = null, $page = -1, $pagesize = 10) {
		global $core;
		$where = "";
		$parent = $this->_parent;
		if($parent instanceof BlobCategory)
			$parent = $parent->id;
		if($parent != BLOBS_ALL) {
			$where = "where blobs_parent=".( is_null($parent) ? -1 : $parent);
		}
		$r = $core->dbe->ExecuteReader("select * from sys_blobs ".$where, $page, $pagesize);	
		$this->affected = $r->affected;
		while($row = $r->Read()) {
			parent::Add(new Blob($row));
		}
	}
	public function Add($blob) {
		$blob->Save();
		parent::Add($blob);
	}
	public function Delete($blob) {
		$index = parent::IndexOf($blob);
		if($index)
			parent::Delete($index);
		$blob->Delete();
	}	
}
class BlobList extends ArrayList {
	private $_position;
	public function __construct($source = "") {
		parent::__construct();
		$a = new ArrayList();
		$a->FromString($source, ",");
		foreach($a as $id) {
			if(is_numeric($id))
				$this->Add(new Blob((int)$id));
		}
		$this->_position = -1;
	}
	public function Add(Blob $file) {
		parent::Add($file);
	}
	public function AddRange($values) {
		foreach($values as $v) {
			if(!($v instanceof Blob))
				return false;
		}
		parent::AddRange($values);
	}
	public function ToString() {
		$r = "";
		foreach($this as $b) {
			$r .= ",".$b->id;
		}
		return @substr($r, 1);
	}
	public function Rows() {
		return $this;
	}
	public function FetchNext() {
		if($this->_position == $this->Count())
			return false;
		return $this->Item(++$this->_position);
	}
}
class BlobData extends Object {
	private $_blob;
	public function __construct($obj = null, $blob = null) {
		global $core;
		$this->_blob = $blob;
		if(!is_object($obj) && !is_null($obj)) {
			$r = $core->dbe->ExecuteReader("select * from sys_blobs_data where blobs_id=".$obj);
			if(!$r->HasRows())
				$obj = null;
			else
				$obj = $r->Read();
		}	
		parent::__construct($obj, "blobs_");
	}
	public function __get($nm) {
		switch($nm) {
			case "isValid":
				return $this->data != null;
			case "size":
				return strlen($this->data);
			case "cached":
				return $this->_blob->CacheExists();
			default:
				return parent::__get($nm);
		}
	}
	public function Save() {
		global $core;
		$this->id = $this->_blob->id;
        $bdata = $this->data;
		$data = $this->ToCollection();
        $data->blobs_data = '';
        if(!$core->dbe->exists("sys_blobs_data", "blobs_id", $this->id))
			$core->dbe->insert("sys_blobs_data", $data);
        $core->dbe->SetBin("sys_blobs_data", "blobs_id", $this->id, "blobs_data", $bdata);
        unset($bdata);
        unset($data);
    }
	public function Delete() {
		global $core;
		$core->dbe->query("delete from sys_blobs_data where blobs_id=".$this->id);
	}
	public static function Download($url) {
        $handle = @fopen($url, "r");
        if($handle) {
			$contents = '';
			while (!feof($handle)) {
				$contents .= fread($handle, 8192);
			}
			fclose($handle);
			return $contents;
		}
		return null;
	}
}
class Blob extends Object {
	static $cache;
	private $_blobdata;
    private $_watermark;
    private $_usewatermark = false;
    private $_filter = null;
	public function __construct($obj = null) {
		global $core, $SYSTEM_USE_MEMORY_CACHE;
        if($SYSTEM_USE_MEMORY_CACHE) {
		    if(!Blob::$cache) {
			    Blob::$cache = $core->dbe->ExecuteReader("select * from sys_blobs")->ReadAll();
		    }
        }		
        if(!is_null(Blob::$cache) && Blob::$cache->Exists("".(is_object($obj) ? $obj->blobs_id : $obj))) {
			$obj = Blob::$cache->Item("".(is_object($obj) ? $obj->blobs_id : $obj));
		}
		else {
			if(!is_object($obj) && !is_null($obj)) {
				if(gettype($obj) == "integer")
					$r = $core->dbe->ExecuteReader("select * from sys_blobs where blobs_id=".$obj);
				elseif(gettype($obj) == "string")
					$r = $core->dbe->ExecuteReader("select * from sys_blobs where blobs_filename='".$obj."'");
				$obj = @$r->Read();
			}	
		}
		parent::__construct($obj, "blobs_");
	}
	public static function Search($filter) {
		global $core;
		if(gettype($obj) == "integer")
			$r = $core->dbe->ExecuteReader("select * from sys_blobs where blobs_id=".$filter);
		elseif(gettype($obj) == "string")
			$r = $core->dbe->ExecuteReader("select * from sys_blobs where ".$filter);
		if(@$r->HasRows())
			return $r;
		else
			return false;
	}
	public function __get($nm) {
		switch($nm) {
			case "isValid":
				return is_numeric($this->id);
			case "parent":
				return new BlobCategory(parent::__get($nm));
			case "data":
				if(!$this->_blobdata)
					$this->_blobdata = new BlobData(intval($this->id), $this);
				return $this->_blobdata;
			case "mimetype":
				return new MimeType($this->type);
			case "size":
				return new Size($this->width, $this->height);
			case "self":
				return $this;
			case "type":
				return strtolower(parent::__get("type"));
            case "watermark":
                return $this->_watermark;
            case "usewatermark":
                return $this->_usewatermark;
            case "filter":
                return $this->_filter;
			default:
				return parent::__get($nm);
		}
	}
	public function __set($nm, $value) {
		if($nm == "parent") {
			if($value instanceof BlobCategory) {
				$value = $value->id;
                return ;
            }
		}
        if($nm == "watermark") {
            $this->_watermark = $value;
            return ;
        }
        if($nm == "usewatermark") {
            $this->_usewatermark = $value;
            return ;
        }
        if($nm == "filter") {
            $this->_filter = $value;
            return ;
        }
		parent::__set($nm, $value);
	}
	public function Delete() {
		global $core;
		$this->data->Delete();
		$this->ClearCache();
		return $core->dbe->query("delete from sys_blobs where blobs_id=".$this->id);
	}
	public function Save($savedata = true, $savesizes = true) {
		global $core;
		$data = $this->ToCollection();
		$data->Delete("blobs_id");
        if($savesizes) {
		    if($this->data->isValid) {
			    if($this->mimetype->isImage) {
				    $img = new ImageEditor(0, 0, $this->data->data);
				    $data->blobs_width = $img->x;
				    $data->blobs_height = $img->y;
                    $img->Dispose();
			    }
		    }
        }
		$data->blobs_modified = strftime("%Y-%m-%d %H:%M:%S", time());
        $data->blobs_bsize = strlen($this->data->data);
		if(is_null($this->id) || $this->id == -1)
			$this->id = $core->dbe->insert("sys_blobs", $data);
		else 
			$core->dbe->set("sys_blobs", "blobs_id", $this->id, $data);
		if($savedata)
			$this->data->Save();
		$this->ClearCache();
		$this->Cache();
	}
	public function CacheName($size = null) {
		global $core;
		$cachefolder = $core->sts->BLOB_CACHE_FOLDER;
		if(!$size) $size = new Size();
        if(is_null($size)) $s = "0x0";
        else $s = $size->width."x".$size->height;
        $wtr = ($this->_usewatermark && !is_empty($this->watermark) ? $this->watermark->id."." : "");
        $g = !is_null($this->_filter) ? str_replace(")", "-", str_replace("(", "-", str_replace(",", "-", str_replace(";", "-", $this->_filter)))).'.' : '';
		$cachename = $this->id.".".$s.".".$wtr.$g.$this->type;
		return $cachefolder."/".$cachename;
	}
    private function CalcWatermarkPosition($ws, $is) {
        if(!is_empty($this->watermark)) {
            $o = new stdClass();
            global $_WATERMARKPOSITION, $_WATERMARKPADDING;
            $_WATERMARKPOSITION = is_empty($_WATERMARKPOSITION) ? "center" : $_WATERMARKPOSITION;
            $_WATERMARKPADDING = is_empty($_WATERMARKPADDING) ? 0 : $_WATERMARKPADDING;
            $x = 0;
            $y = 0;
            switch($_WATERMARKPOSITION) {
                case "lefttop":          
                    $x = $_WATERMARKPADDING;
                    $y = $_WATERMARKPADDING;
                    break;
                case "righttop":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = 0;
                    break;
                case "rightbottom":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "leftbottom":
                    $x = 0;
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "center":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
                case "centertop":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = 0;
                    break;
                case "centerbottom":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "leftcenter":
                    $x = 0;
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
                case "rightcenter":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
            }
            $o->x = $x;         
            $o->y = $y;
            return $o;
        }
        return new stdClass();
    }
	public function Cache($size = null) {
		global $core;
		$ff = $this->CacheName($size);
		$data = $this->data->data;
		if(!is_null($size))	{
			$s = $this->size->TransformTo($size);
			$img = new ImageEditor(0, 0, $data);
			if(!$img->error) {
                if(!$s->isNull){
					$img->resize( $s->width, $s->height );
                    $data = $img->outputMem($this->type);
				}
			}
			else {
				$img = new ImageEditor(10, 10);
				$img->errorImage("Type is not supplied.");
				$data = $img->outputMem("jpg");
			}		
            $img->Dispose();
		}
        if(!is_empty($this->watermark) && $this->_usewatermark) {
                            $img = new ImageEditor(0, 0, $data);
            $watermark = new ImageEditor(0, 0, $this->watermark->data->data);
            global $_WATERMARKVISIBILITY;
            $p = $this->CalcWatermarkPosition(new Size($watermark->x, $watermark->y), new Size($img->x, $img->y));
            $img->addWatermark($watermark,$p->x,$p->y,0,0, $_WATERMARKVISIBILITY);
            $data = $img->outputMem($this->type);
        }
        $data = $this->applyFilters($data);
		$core->fs->writefile($ff, $data);
	}
    private function applyFilters($data) {
        if (!is_null($this->_filter)){
            $af = array(
                'negative' => IMG_FILTER_NEGATE,
                'grayscale' => IMG_FILTER_GRAYSCALE,
                'brightness' => IMG_FILTER_BRIGHTNESS,
                'contrast' => IMG_FILTER_CONTRAST,
                'colorize' => IMG_FILTER_COLORIZE,
                'edgedetect' => IMG_FILTER_EDGEDETECT,
                'emboss' => IMG_FILTER_EMBOSS,
                'gaussian_blur' => IMG_FILTER_GAUSSIAN_BLUR,
                'selective_blur' => IMG_FILTER_SELECTIVE_BLUR,
                'mean_removal' => IMG_FILTER_MEAN_REMOVAL,
                'smooth' => IMG_FILTER_SMOOTH
            );            
            $filters = explode(";", $this->_filter);
            $img = new ImageEditor(0, 0, $data);
            foreach($filters as $filter) {
                preg_match_all('/([^\(]*)\(?([^\)]*)?\)?/im', $filter, $matches, PREG_SET_ORDER);
                $f = $af[$matches[0][1]];
                $argb = explode(",", $matches[0][2]);
                $img->addfilter($f, @$argb[0], @$argb[1], @$argb[2]);
            }
            return $img->outputMem($this->type);
        }
        return $data;   
    }
    public function Merge($obj, Point $position) {
    	global $core;
    	if(!($obj instanceof Blob))
    		$obj = new ImageEditor($core->fs->MapPath($obj), '');
    	else 
    		$obj = new ImageEditor($core->fs->MapPath($obj->Src()), '');
    	$i = new ImageEditor(0, 0, $this->data->data);
    	$i->addImage($obj, $position->x, $position->y);
    	$this->data->data = $i->outputMem($this->type);
    	$this->Cache();
	}
	public function ReadCache($size = null, $recache = false) {
		global $core;
		$ff = $this->CacheName($size);
		if($this->CacheExists($size) && !$recache)
			return $core->fs->readfile($ff);
		else {
			$this->Cache($size);
			return $this->ReadCache($size);
		}
	}
	public function CacheExists($size = null) {
		global $core;
		$ff = $this->CacheName($size);
		return $core->fs->fileexists($ff) === true;
	}
	public function ClearCache($size = null) {
		global $core;
		if(is_null($size)) {
			if(is_numeric($this->id)) {
				$files = $core->fs->list_files($core->sts->BLOB_CACHE_FOLDER, null, "/".$this->id."\.\d*x\d*\.".($this->watermark ? "\d\." : "").".*/");
				foreach($files as $file)
					$core->fs->deletefile($core->sts->BLOB_CACHE_FOLDER."/".$file->file);
			}
		}
		else {
			$core->fs->deletefile($this->CacheName($size));
		}
	}
    public function UpdateAccessTime() {
        global $core;
        $check = $core->rq->currentUrl;
        $currentUrl = $core->rq->currentUrl;
        if(strstr($currentUrl, "/core/utils/blob.php") !== false)
            $check = $core->rq->referer;
        if(strstr($check, "/admin/") === false) {
            $this->lastaccessed = db_datetime(time());
            $core->dbe->set("sys_blobs", "blobs_id", $this->id, Collection::Create("blobs_lastaccessed", $this->lastaccessed));
                    }
    }
	public function Src($size = null, $nocache = false, $download = false, $filter = null) {
        $this->UpdateAccessTime();
        $g = $this->filter;
        $this->filter = $filter;
		if(!$nocache) {
			if($this->CacheExists($size))
				$ret = $this->CacheName($size);
			else {
				$this->Cache($size);
				$ret = $this->CacheName($size);
			}
		}
		else {
			global $core;
			if(!is_empty($core->sts->USE_MOD_REWRITE) && !$core->isAdmin) {
				$ext = $this->type;
				if(is_empty($this->type))
					$ext = "jpg";	
				if($size)
					$ret = "/resources/blobs/".$this->id.".".$ext."?recache=true&".$size->params.($download ? "&mode=download" : "").($this->filter ? "&filter=".$this->filter : "");
				else
					$ret = "/resources/blobs/?recache=true&".$this->id.".".$ext.($download ? "?mode=download" : "");
			}
			else {
				if($size)
					$ret = "/core/utils/blob.php?blobid=".$this->id.$size->params.($download ? "&mode=download" : "");
				else
					$ret = "/core/utils/blob.php?blobid=".$this->id.($download ? "&mode=download" : "");
			}
		}
        $this->filter = $g;
        return $ret;
	}
		public function Bg($size = null, $nocache = false, $download = false, $filter = null) {
		return "background: url(".$this->Src($size, $nocache, $download, $filter).");";
	}
    public function ColorAt(Point $p) {
        if($this->mimetype->isImage) {
            $data = $this->data;
            $img = new ImageEditor(0, 0, $data);
            return $img->getColorAt($p->x, $p->y);
        }
        return null;                   
    }
	public function Img($size = null, $attributes = null) {
		$attr = "";
		if(!is_null($attributes)) {
			if(is_array($attributes)) {
				foreach($attributes as $name => $value) {
					$attr = " ".$name."=\"".$value."\"";
				}
			}
			else if(is_string($attributes)) 
				$attr = $attributes;
		}
		if (!$size)
			$size = new Size();
		if ($this->mimetype->isImage){
			$s = $this->size;
			$s = $s->TransformTo($size);
		} else {
			$s = $size;
		}
		if($this->data->isValid) {
			if($this->mimetype->isImage)
				return "<img src='".$this->Src($size)."' alt=\"".$this->alt."\" ".$s->attributes." ".$attr." border='0' />"; 			else if($this->mimetype->isFlash)
				return '<object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" '.
						$s->attributes.' 
						classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
						<param name="Movie" value="'.$this->Src().'" />
						<param name="Src" value="'.$this->Src().'" />
						<param name="WMode" value="Opaque" /> 
						<param name="Play" value="1" />
						<param name="Loop" value="-1" />
						<param name="Quality" value="High" />
						<param name="Scale" value="ShowAll" />
						<param name="EmbedMovie" value="0" />
						<param name="AllowNetworking" value="all" />
						<embed src="'.$this->Src().'" 
						quality="best" 
						bgcolor="#000" 
						'.$s->attributes.' 
						allowscriptaccess="sameDomain" 
						type="application/x-shockwave-flash" 
						wmode="opaque" 
						pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';
			else {
				return "<img src='".to_lower($this->mimetype->icon)."' alt=\"".(!is_null($this->alt) ? $this->alt: '')."\" ".$attr." border='0' />"; 			}
		}		
		else {
			return "Not selected";
		}
	}
	public function to_xml(){
		global $core;
		static $ids = array();
		$data = $this->ToCollection();
		if (array_search($this->id, $ids) !== false){
			$data->blobs_data = "";
			return $data->to_xml();
		} else {
			$ids[] = $data->blobs_id;
			$data->blobs_data = "[cdata]".bin2hex($this->data->data)."[/cdata]";
			$xml = $data->to_xml();
			$xml = str_replace("[cdata]", "<![CDATA[", $xml);
			return str_replace("[/cdata]", "]]>", $xml);
		}
	}
	public function from_xml($el){
		global $core;
		$c = new collection();
		$c->from_xml($el);
		$tbs = Blobs::Search("blobs_bsize='".$c->blobs_bsize."'", 
							"and blobs_filename='".$c->blobs_filename."'", 
							"and blobs_type='".$c->blobs_type."'", 
							"and blobs_alt='".$c->blobs_alt."'");
		if ($tbs->Count() > 0){
			$tb = $tbs->FetchNext();
			$this->id = $tb->blobs_id;
		} else {
			$this->bsize = $c->blobs_bsize;
			$this->filename = $c->blobs_filename;
			$this->type = $c->blobs_type;
			$this->alt = $c->blobs_alt;
			$this->data->data = hex2bin($c->blobs_data);
			$this->Save();
		}
	}
	public function Out($template = null , $params = null ) {
		$s = new storage(null);
		$s->name = "blobs";
		$s->id = -1;
		$f = new Field($s);
		$f->name = "File name";
		$f->field = "filename";
		$f->type = "memo";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
		$f = new Field($s);
		$f->name = "File type";
		$f->field = "type";
		$f->type = "text";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
		$f = new Field($s);
		$f->name = "File size";
		$f->field = "bsize";
		$f->type = "numeric";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
        $f = new Field($s);
        $f->name = "Alt";
        $f->field = "alt";
        $f->type = "html";
        $f->showintemplate = true;
        $f->lookup = "";
        $f->onetomany = "";
        $f->values = "";
        $s->fields->Add($f);
        $f = new Field($s);
		$f->name = "File";
		$f->field = "self";
		$f->type = "blob";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
		$t = template::create(null, $s);
		$t->cache = false;
		$t->composite = 0;
		$t->name = "icon";
		$t->list = '';
		return $t->Out(OPERATION_ADMIN, $this, $params);
	}
}
?>
<?php
class BlobCategory extends Object {
	public function __construct($obj = null) {
		global $core;
		if(!is_object($obj) && !is_null($obj)) {
			$where = "";
			if(gettype($obj) == "integer")
				$where = "category_id=".$obj;
			elseif(gettype($obj) == "string")
				$where = "category_description='".$obj."'";
			else 
				trigger_error("error loading blob category ", E_USER_ERROR);
			$r = $core->dbe->ExecuteReader("select *, 
									  (select count(*) from sys_blobs where sys_blobs.blobs_parent=sys_blobs_categories.category_id) as category_blobs, 
									  (select count(*) from sys_blobs_categories c1 where c1.category_parent=sys_blobs_categories.category_id) as category_children
									  from sys_blobs_categories where ".$where);
			$obj = @$r->Read();
		}
		parent::__construct($obj, "category_");
		if(!is_numeric($this->id))
			$this->id = -1;
		if(!($this->securitycache instanceof Hashtable)) {
			$this->securitycache = @unserialize($this->securitycache);
			if($this->securitycache === false || is_null($this->securitycache)) $this->securitycache = new Hashtable();
		}
	}
	public function Children() {
		return new BlobCategories($this);
	}
	public function Blobs($sort = null, $page = -1, $pagesize = 10) {
		return new Blobs($this, $sort, $page, $pagesize);
	}
	public function Delete() {
		global $core;
		if($this->children > 0) {
			$children = $this->Children();
			foreach($children as $category) {
				$category->Delete();
			}
		}
		$core->dbe->query("update sys_blobs set blobs_parent=-1 where blobs_parent=".$this->id);
		return $core->dbe->query("delete from sys_blobs_categories where category_id=".$this->id);
	}
	public function Save() {
		global $core;
		$data = $this->ToCollection();
		$data->Delete("category_id");
		$data->Delete("category_children");
		$data->Delete("category_blobs");
		if($data->category_securitycache instanceof Hashtable)
			$data->category_securitycache = serialize($data->category_securitycache);
		if(is_null($this->id) || $this->id == -1)
			$this->id = $core->dbe->insert("sys_blobs_categories", $data);
		else 
			$core->dbe->set("sys_blobs_categories", "category_id", $this->id, $data);
	}
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("blobs.categories.category.delete", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.category.edit", "Edit the blob category"));
		$operations->Add(new Operation("blobs.categories.category.items.add", "Add a blob"));
		$operations->Add(new Operation("blobs.categories.category.items.delete", "Delete the blob"));
		$operations->Add(new Operation("blobs.categories.category.items.edit", "Edit the blob"));
		$operations->Add(new Operation("blobs.categories.category.children.add", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.category.children.delete", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.category.children.edit", "Edit the blob category"));
		$operations->Add(new Operation("blobs.categories.category.children.items.add", "Add a blob"));
		$operations->Add(new Operation("blobs.categories.category.children.items.delete", "Delete the blob"));
		$operations->Add(new Operation("blobs.categories.category.children.items.edit", "Edit the blob"));
		return $operations;
	}
		public function createSecurityBathHierarchy($suboperation) {
		global $core;
		$prefixCategories = "blobs.categories.category.";
		$prefixBlobs = "blobs.";
		$tree = array();
		$bc = $this;
		while($bc->parent != -1 && !is_null($bc->parent)) {
			$tree[] = array("object" => $bc, "operation" => $prefixCategories.($bc->description != $this->description ? "children." : "").$suboperation);
			$bc = new BlobCategory(intval($bc->parent));
		}
		$tree[] = array("object" => new BlobCategories(), "operation" => $prefixBlobs.$suboperation);
		return $tree;
	}
}
class BlobCategories extends ArrayList {
	public $securitycache;
	private $_parent;
	public function __construct($parent = null) {
		parent::__construct();
		$this->securitycache = new Hashtable();
		$this->_parent = $parent;
		$this->Load();
	}
	public function Load() {
		global $core;
		$r = $core->dbe->ExecuteReader("select *, 
								  (select count(*) from sys_blobs where sys_blobs.blobs_parent=sys_blobs_categories.category_id) as category_blobs, 
								  (select count(*) from sys_blobs_categories c1 where c1.category_parent=sys_blobs_categories.category_id) as category_children
								  from sys_blobs_categories where category_parent=".(is_null($this->_parent) ? -1 : $this->_parent->id));
        while($row = $r->Read()) {
			$c = new BlobCategory($row);
			parent::Add($c);
		}
	}
	public function Add($category) {
		$category->Save();
		parent::Add($category->description, $category);
	}
	public function Delete($category) {
		parent::Delete($category->description);
		$category->Delete();
	}
	public static function TransformTables($parent = -1, $newparent = -1) {
				global $core;
		$q = "select * from sys_blobs where blobs_isfolder=1 and blobs_parent=".$parent;
		$r = $core->dbe->ExecuteReader($q);
		while($rr = $r->Read()) {
			$b = new BlobCategory();
			$b->description = $rr->blobs_category;
			$b->parent = $newparent;
			$b->Save();
			$qq = "update sys_blobs set blobs_parent=".$b->id." where blobs_isfolder=0 and blobs_parent=".$rr->blobs_id;
			$core->dbe->query($qq);
			BlobCategories::TransformTables($rr->blobs_id, $b->id);
		}
	}
	public static function WidthAndHeights() {
				$blobs = new Blobs(BLOBS_ALL);
		foreach($blobs as $blob) {
			$blob->Save(false);
		}
	}	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("blobs.categories.add", "Add a blobs category"));
		$operations->Add(new Operation("blobs.categories.delete", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.edit", "Edit the blob category"));
		$operations->Add(new Operation("blobs.categories.move", "Move category"));
		$operations->Add(new Operation("blobs.items.add", "Add a blob"));
		$operations->Add(new Operation("blobs.items.delete", "Delete the blob"));
		$operations->Add(new Operation("blobs.items.edit", "Edit the blob"));
		$operations->Add(new Operation("blobs.items.move", "Move blob"));
		return $operations;
	}
	public function createSecurityBathHierarchy($suboperation) {
		return array(array("object" => $this, "operation" => "blobs.".$suboperation));
	}
}
?><?php
class FileList extends ArrayList {
	public function __construct($source = "") {
		parent::__construct();
		$source = str_replace("\n", "", str_replace("\r", "", $source));
		$a = new ArrayList();
		$a->FromString($source, ";");
		foreach($a as $file) {
            if(!is_empty($file))                         
			    $this->Add(new FileView(trim($file, "\n")));
		}
	}
	public function Add(FileView $file) {
		parent::Add($file);
	}
	public function AddRange($values) {
		foreach($values as $v) {
			if(!($v instanceof FileView))
				return false;
		}
		parent::AddRange($values);
	}
	public function ToString() {
		$s = "";
		foreach($this as $file) {
			$s .= $file->Src().":".$file->alt.";\r\n";
		}
		return $s;
	}
}
class FileView {
	private $_src;
	private $_alt;
	private $_file;
    private $_where = SITE;
    private $_usewatermark = false;
    private $_watermark;
    private $_content;
	function __construct($src) {
        if(strstr($src, "http://")) {
                        $src = substr($src, strlen("http://"));
            if(strstr($src, ":"))
                $src = explode(":", $src);
            if(is_array($src))
                $src[0] = "http://".$src[0];
            else
                $src = "http://".$src;
        }
        else 
            		    if(strstr($src, ":"))
                $src = explode(":", $src);
		if(is_array($src)) {
			$this->_src = $src[0];
			$this->_alt = $src[1];
			$this->_file = split_fname($src[0]);
		}
		else { 
			$this->_src = $src;
			$this->_file = split_fname($src);
		}
        if(strstr($this->_src, '/core')) {
            $this->_src = substr($this->_src, 5);
            $this->_where = CORE;
        } else if(strstr($this->_src, '/admin')) {
            $this->_src = substr($this->_src, 6);
            $this->_where = ADMIN;
        }
	}
	public function __set($nm, $value) {
        if($nm == "watermark") {
            $this->_watermark = $value;
            return ;
        }
        if($nm == "usewatermark") {
            $this->_usewatermark = $value;
            return ;
        }
	}
	public function __get($nm) {
		global $core;
		switch($nm) {
            case "isOnline":
                return substr($this->_src, 0, strlen('http://')) == 'http://';
			case "isValid":
				return $core->fs->FileExists($this->_src);
			case "mimetype":
				return new MimeType($this->_file[2]);
			case "type":
				return $this->_file[2];
			case "data":
				if(is_null($this->_content))
					$this->_content = $core->fs->readfile($this->_src, $this->_where);
				return $this->_content;
			case "size":
                if($this->mimetype->isImage) {
                    $info = ImageEditor::ImageInfo($core->fs->MapPath($this->_src));
				    return $info->size;
                }
                else {
                    return null;
                }
			case "alt":
				return $this->_alt;
            case "watermark":
                return $this->_watermark;
            case "usewatermark":
                return $this->_usewatermark;
			case "id":
			case "name":
				return $this->_file[1].".".$this->_file[2];
			case "filesize":
                if($this->isOnline)
                    return 0;
				return @filesize($core->fs->mappath($this->_src));
		}
	}
    public function ToString(){
        return $this->Src().":".$this->alt;
    }
	public function CacheName($size = null, $crop = null) {
		global $core;
		$cachefolder = $core->sts->BLOB_CACHE_FOLDER;
		if(!$size)
			$size = new Size();
        if(is_null($size))
            $size = new Size(0,0);
		$cachename = md5($this->_src).".".$size->width."x".$size->height.".".$this->_file[2];
		return $cachefolder."/".$cachename;
	}
	public function Cache($size = null) {
		global $core;
		$ff = $this->CacheName($size);
		$data = $this->data;
		if($this->mimetype->isImage) {
			if(!is_null($size))	{
				$s = $this->size->TransformTo($size);
				$img = new ImageEditor(0, 0, $data);
				if(!$img->error) {
                    $img->resize( $s->width, $s->height );    
					$data = $img->outputMem($this->_file[2]);
				}
				else {
					$img = new ImageEditor(10, 10);
					$img->errorImage("Type is not supplied.");
					$data = $img->outputMem("jpg");
				}	
			}
		    if(!is_empty($this->watermark) && $this->_usewatermark) {
		        		        $img = new ImageEditor(0, 0, $data);
		        if ($this->watermark instanceOf FileView)
			        $watermark = new ImageEditor(0, 0, $this->watermark->data);
			    else if ($this->watermark instanceOf Blob)
			        $watermark = new ImageEditor(0, 0, $this->watermark->data->data);
		        global $_WATERMARKVISIBILITY;
		        $p = $this->CalcWatermarkPosition(new Size($watermark->x, $watermark->y), new Size($img->x, $img->y));
		        $img->addWatermark($watermark,$p->x,$p->y,0,0, $_WATERMARKVISIBILITY);
		        $data = $img->outputMem($this->type);
		    }
			$core->fs->writefile($ff, $data);
		}
	}
    private function applyFilters($data) {
        if (!is_null($this->_filter)){
            $af = array(
                'negative' => IMG_FILTER_NEGATE,
                'grayscale' => IMG_FILTER_GRAYSCALE,
                'brightness' => IMG_FILTER_BRIGHTNESS,
                'contrast' => IMG_FILTER_CONTRAST,
                'colorize' => IMG_FILTER_COLORIZE,
                'edgedetect' => IMG_FILTER_EDGEDETECT,
                'emboss' => IMG_FILTER_EMBOSS,
                'gaussian_blur' => IMG_FILTER_GAUSSIAN_BLUR,
                'selective_blur' => IMG_FILTER_SELECTIVE_BLUR,
                'mean_removal' => IMG_FILTER_MEAN_REMOVAL,
                'smooth' => IMG_FILTER_SMOOTH
            );            
            $filters = explode(";", $this->_filter);
            $img = new ImageEditor(0, 0, $data);
            foreach($filters as $filter) {
                preg_match_all('/([^\(]*)\(?([^\)]*)?\)?/im', $filter, $matches, PREG_SET_ORDER);
                $f = $af[$matches[0][1]];
                $argb = explode(",", $matches[0][2]);
                $img->addfilter($f, @$argb[0], @$argb[1], @$argb[2]);
            }
            return $img->outputMem($this->type);
        }
        return $data;   
    }
    private function CalcWatermarkPosition($ws, $is) {
        if(!is_empty($this->watermark)) {
            $o = new stdClass();
            global $_WATERMARKPOSITION, $_WATERMARKPADDING;
            $_WATERMARKPOSITION = is_empty($_WATERMARKPOSITION) ? "center" : $_WATERMARKPOSITION;
            $_WATERMARKPADDING = is_empty($_WATERMARKPADDING) ? 0 : $_WATERMARKPADDING;
            $x = 0;
            $y = 0;
            switch($_WATERMARKPOSITION) {
                case "lefttop":          
                    $x = $_WATERMARKPADDING;
                    $y = $_WATERMARKPADDING;
                    break;
                case "righttop":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = 0;
                    break;
                case "rightbottom":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "leftbottom":
                    $x = 0;
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "center":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
                case "centertop":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = 0;
                    break;
                case "centerbottom":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "leftcenter":
                    $x = 0;
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
                case "rightcenter":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
            }
            $o->x = $x;         
            $o->y = $y;
            return $o;
        }
        return new stdClass();
    }
	public function CacheExists($size = null) {
		global $core;
		if($this->mimetype->isImage) {
			$ff = $this->CacheName($size);
			return $core->fs->fileexists($ff) === true;
		}
		else
			return true;
	}
	public function ClearCache($size = null) {
		global $core;
		if(is_null($size)) {
			if(is_numeric($this->id)) {
				$files = $core->fs->list_files($core->sts->BLOB_CACHE_FOLDER, null, "/".md5($this->_src)."\..*/");
				foreach($files as $file)
					$core->fs->deletefile($core->sts->BLOB_CACHE_FOLDER."/".$file->file);
			}
		}
		else {
			$core->fs->deletefile($this->CacheName($size));
		}
	}
	public function Src($size = null, $nocache = false, $download = false) {
		if(!$nocache) {
			if($this->mimetype->isImage && !is_null($size)) {
				if(!$this->CacheExists($size))
					$this->Cache($size);
				return $this->CacheName($size);
			}
			else
				return $this->_src;
		}
		else {
			return $this->_src;
		}    
	}
		public function Bg($size = null, $nocache = false) {
		return "background: url(".$this->Src($size, $nocache).");";
	}
	public function Img($size = null, $attributes = null) {
		$attr = "";
		if(!is_null($attributes)) {
			if(is_array($attributes)) {
				foreach($attributes as $name => $value) {
					$attr = " ".$name."=\"".$value."\"";
				}
			}
			else if(is_string($attributes)) 
				$attr = $attributes;
		}
		if (!$size)
			$size = new Size();
		if($this->isValid) {
			if($this->mimetype->isImage)
				return "<img src='".$this->Src($size)."' alt=\"".htmlentities($this->alt)."\" ".$size->params." ".$attr." border='0' />";
			else if($this->mimetype->isFlash)
				return '<object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" '.
						$size->attributes.' 
						classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
						<param name="Movie" value="'.$this->Src().'" />
						<param name="Src" value="'.$this->Src().'" />
						<param name="WMode" value="Opaque" /> 
						<param name="Play" value="1" />
						<param name="Loop" value="-1" />
						<param name="Quality" value="High" />
						<param name="Scale" value="ShowAll" />
						<param name="EmbedMovie" value="0" />
						<param name="AllowNetworking" value="all" />
						<embed src="'.$this->Src().'" 
						quality="best" 
						bgcolor="#000" 
						'.$size->attributes.' 
						allowscriptaccess="sameDomain" 
						type="application/x-shockwave-flash" 
						wmode="opaque" 
						pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';
		}		
		else {
			return "Not selected";
		}
	}
	public function Save() {
		return;
		if(!is_null($this->_content)) {
			$core->fs->WriteFile($this->_content, $this->_src);
		}
	}
	public function Merge($obj, Point $position, $alpha = false) {
    	global $core;
    	if($obj instanceof Blob || $obj instanceof FileView)
    		$obj = new ImageEditor($core->fs->MapPath($obj->Src()), '');
    	else
    		$obj = new ImageEditor($core->fs->MapPath($obj), '');
    	$i = new ImageEditor(0, 0, $this->data);
        if($alpha)
            $i->addWatermark($obj, 0, 0, $position->x, $position->y, $alpha);
        else
    	    $i->addImage($obj, $position->x, $position->y);
    	$this->_content = $i->outputMem($this->type);
    	$this->ClearCache();
	}
    public function Delete() {
        global $core;
        $this->ClearCache();
        unlink($core->fs->MapPath($this->_src));
    }
    public function ColorAt(Point $p) {
        if($this->mimetype->isImage) {
            $data = $this->data;
            $img = new ImageEditor(0, 0, $data);
            return $img->getColorAt($p->x, $p->y);
        }
        return null;                   
    }
    public function ToXML() {
        return '<fileview>'.$this->Src().'</fileview>';    
    }
}
?><?php
    class AccessCode {
        public $code;
        private $_font;
        function AccessCode($code, $font = null){
            $this->_font = $font;
            if(is_null($this->_font))
                $this->_font = new Font('arial.ttf', '/resources/fonts', 14);
            $this->code = Encryption::Decrypt("123456789", $code);
        }
        public function Stream($type = 1){
            $f = "_Stream".$type;
            if (method_exists($this, $f))
                return $this->$f();
        }
        public static function Encode($code){
            return Encryption::Encrypt("123456789", $code);
        }
        public static function Src($code, $font = null){
            return "/resources/blobs/access".AccessCode::Encode($code).(!is_null($font) ? '*'.base64_encode($font->src.";".$font->size) : '').".access";
        }
        public static function Img($code, $font = null){
            return '<img src="'.AccessCode::Src($code, $font).'" alt="" />';
        }
        private function _Stream1(){
            $fontfile = $this->_font->src;
            $xkey = $this->code;
            $startAt = new Point(5, 10);
            $size = new Size();
            $this->_font->InscribeText($xkey, $startAt, $size);
            $im2 = imagecreate(
                $size->width+120,
                $size->height+15
            );
            $white=imagecolorallocate($im2,255,255,255);
            $c = array();
            for($i=0; $i<16; $i++) {
                srand((double)microtime()*1000000);
                $c[$i]=imagecolorallocate($im2,rand(0,160),rand(0,160),rand(0,160));
            }
            imagefill($im2, 0, 0,$white);
            $xwi=10;
            $i = 0;
            while($i < charCount($xkey)) {
                srand((double)microtime()*1000000);
                imagettftext($im2, $this->_font->size,rand(-50, 50),$xwi,$size->height + 5,$c[rand(0, 15)],$fontfile,charAt($xkey,$i));
                $xwi += 20;
                $i++;
            }
            header("Content-Type: image/png");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            imagepng($im2);
            imagedestroy($im2);
        }
        private function _Stream2(){
            $rand = $this->code;
            $r = $this->_font->MeasureText($rand);
            $s = new Size($r->size->width+10, $r->size->height+10);
            $image = imagecreate($s->width, $s->height);
            $bgColor = imagecolorallocate ($image, 255, 255, 255);
            $textColor = imagecolorallocate ($image, 10, 100, 10);
            for ($i = 0; $i < 10; $i++) {
                $rx1 = rand(0,$s->width);
                $rx2 = rand(0,$s->width);
                $ry1 = rand(0,$s->height);
                $ry2 = rand(0,$s->height);
                $rcVal = rand(0,255);
                $rc1 = imagecolorallocate($image, 
                                            rand(0,255), 
                                            rand(0,255), 
                                            rand(100,255));
                imageline ($image, $rx1, $ry1, $rx2, $ry2, $rc1);
            }
            imagettftext($image, $this->_font->size, 0, 0, $s->height-5, $textColor, $this->_font->src, $rand);
            header('Content-type: image/jpeg');
            imagejpeg($image);
            imagedestroy($image);
        }
    }
?><?php
class Text2Image {
	public $text;
	public $size;
	public $colors;
	public $startAt;
	public $type;
    public $alt;
	private $_uniq;
    private $_msize;
    private $_mstartAt;
    private $_mrheight;
	static $font; 
	function __construct($text, $colorBg, $colorFont, $startAt = null, $imageSize = null){
		$this->text = $text;
		$this->type = 'png';
		$this->size = $imageSize;
		$this->colors = array("bg" => $colorBg, "font" => $colorFont);
		$this->_uniq = md5($this->text.".".$this->colors["bg"].".".$this->colors["font"].Text2Image::$font->size.'.'.Text2Image::$font->angle);
		if(!(Text2Image::$font instanceof Font)) {
			Text2Image::$font  = new Font("arial.ttf");
		}
        $this->_msize = new Size();
        $this->_mstartAt = new Point();
        Text2Image::$font->InscribeText($text, $this->_mstartAt, $this->_msize);
        $this->_mrheight = $this->_msize->height;
        $br = '<br />';
       	if(stripos($this->text, $br) !== false )
			$this->text = explode('<br />', $this->text); 
		if(is_array($this->text))
			$this->size->height += $this->_mrheight*(count($this->text)-1);
        $this->startAt = $startAt;
        if(is_null($this->startAt))
            $this->startAt = $this->_mstartAt;
		$this->size = $imageSize;
		if(is_null($this->size))
			$this->size = $this->_msize;
	}
	public function Src(){
		$this->Cache();
		return $this->CacheName();
	}
	public function Img($attributes = null){
		$attr = "";
		if(!is_null($attributes)) {
			if(is_array($attributes)) {
				foreach($attributes as $name => $value) {
					$attr = " ".$name."=\"".$value."\"";
				}
			}
			else if(is_string($attributes)) 
				$attr = $attributes;
		}
		return "<img src='".$this->Src()."' alt=\"".htmlentities($this->alt)."\" ".$this->size->attributes." ".$attr." border='0' />";
	}
	public function CacheName() {
		global $core;
		$cachefolder = $core->sts->BLOB_CACHE_FOLDER;
		return $cachefolder."/".($this->_uniq.".".$this->type);
	}
	public function generateImage($fileName = null) {
		global $core;    
						$width = $this->size->width;
		$height = $this->size->height;
        $im = imagecreatetruecolor($width, $height);
		        if($this->colors["bg"] !== false) {
		    $rgbBg = html2rgb($this->colors["bg"]);
            $bgColor = imagecolorallocate($im, $rgbBg[0], $rgbBg[1], $rgbBg[2]);
            imagefilledrectangle($im, 0, 0, $width, $height, $bgColor);
        }
        else {
            imagealphablending($im,false);
            $col=imagecolorallocatealpha($im,0,0,0,127);
            imagefilledrectangle($im,0,0,$width, $height,$col);
            imagealphablending($im,true);            
        }
		$rgbFont = html2rgb($this->colors["font"]);
		$fontColor = imagecolorallocate($im, $rgbFont[0], $rgbFont[1], $rgbFont[2]);
		$font = Text2Image::$font->src;
				$startX = $this->startAt->x;
		$startY = $this->startAt->y;
		$br = '<br />';
		if(!is_array($this->text)) {
			imagettftext($im, Text2Image::$font->size, Text2Image::$font->angle, $startX, $startY, $fontColor, $font, $this->text);
		}
		else {
			foreach($this->text as $text) {
				imagettftext($im, Text2Image::$font->size, Text2Image::$font->angle, $startX, $startY, $fontColor, $font, $text);
				$startY += $this->_mrheight;
			}
		}
		        imagealphablending($im,false);
        imagesavealpha($im,true);
		if(!is_null($fileName))
			imagepng($im, $fileName);
		else
			imagepng($im);
		imagedestroy($im);
	}
	public function Cache() {
		global $core;
		$this->generateImage($core->fs->mappath($this->CacheName()));
	}
	public function ReadCache($recache = false) {
		global $core;
		$ff = $this->CacheName();
		if($this->CacheExists() && !$recache)
			return $core->fs->readfile($ff);
		else {
			$this->Cache();
			return $this->ReadCache();
		}
	}
	public function CacheExists() {
		global $core;
		$ff = $this->CacheName();
		return $core->fs->fileexists($ff);
	}
	public function ClearCache() {
		global $core;
		$core->fs->deletefile($this->CacheName());
	}	
	public static function t2iSrc($text, $colorBg, $colorFont, $startAt = null, $imageSize = null, $font = null) {
		if($font instanceof Font)
			Text2Image::$font = $font;
		else if(is_string($font)) {
			Text2Image::$font = new Font($font);
		}
		$t2i = new Text2Image($text, $colorBg, $colorFont, $startAt, $imageSize);
		return $t2i->Src();
	}
	public static function t2iImg($text, $colorBg, $colorFont, $startAt = null, $imageSize = null, $font = null, $attributes = null) {
		if($font instanceof Font)
			Text2Image::$font = $font;
		else if(is_string($font)) {
			Text2Image::$font = new Font($font);
		}
		$t2i = new Text2Image($text, $colorBg, $colorFont, $startAt, $imageSize);
		return $t2i->Img($attributes);
	}
}
?>
<?php
class Setting {
	public $name;
	public $type;
	public $value;
	public $securitycache;
	public $is_system;
	public $category;
	public function __construct($name = null, $type = null, $value = null, $securitycache = null, $is_system = 0, $category = null){
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
		$this->is_system = $is_system;
		$this->category = $category;
		$this->securitycache = $securitycache;
		if(!($this->securitycache instanceof Hashtable)) {
			$this->securitycache = @unserialize($this->securitycache);
			if($this->securitycache === false || is_null($this->securitycache)) $this->securitycache = new Hashtable();
		}
	}
	public function __get($name) {
        if(!is_null(@$this->$name))
			return $this->$name;
		else { 
			$nm = substr($name, strlen("setting_"));
			return $this->$nm;
		}
	}
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("settings.setting.delete", "Delete the setting"));
		$operations->Add(new Operation("settings.setting.edit", "Edit setting value"));
		return $operations;
	}
	public function createSecurityBathHierarchy($suboperation) {
		global $core;
		return array( 
			array("object" => $core->sts, "operation" => "settings.".$suboperation), 
			array("object" => $this, "operation" => "settings.setting.".$suboperation)
	    );
	}
    static function Create($name = null, $type = null, $value = null, $securitycache = null, $is_system = 0, $category = null) {
        return new Setting($name, $type, $value, $securitycache, $is_system, $category); 
    }
	public function Insert() {
        global $core;
        $core->dbe->insert('sys_settings', 
            new collection(array("setting_name" => $this->name, 
                                "setting_type" => $this->type,
                                "setting_value" => $this->value, 
                                "setting_issystem" => $this->is_system ? 1 : 0, 
                                "setting_category" => $this->category,
                                "setting_securitycache" => serialize($this->securitycache))));
    }
}
class Settings extends Collection {
	private $table;
	private $nocache;
	public $securitycache;
	public function __construct() {
		parent::__construct();
		$this->table = sys_table("settings");
		$this->securitycache = new Hashtable();
	}	
    public function Dispose() {
        parent::Clear();
    }
	public function RegisterEvents(){
	}
	public function RegisterEventHandlers(){
	}
	public function Initialize($nocache = true) {
		$this->nocache = $nocache;
		if(!$this->nocache)
			$this->sync();
	}
	private function sync() {
		global $core;
		$rss = $core->dbe->ExecuteReader("select * from ".$this->table);
		while($v = $rss->Read()) {
			parent::add($v->setting_name, new Setting($v->setting_name, $v->setting_type, $v->setting_value, $v->setting_securitycache, $v->setting_issystem, $v->setting_category));
		}
	}
	public function remove($name) {
		global $core;
		$core->dbe->delete($this->table, "setting_name", $name);
		if(!$this->nocache)
			parent::Delete($name); 		
	}
	public function add(Setting $v) {
		global $core;
		$core->dbe->insert($this->table, 
							new collection(array("setting_name" => $v->name, 
												"setting_type" => $v->type,
												"setting_value" => $v->value, 
												"setting_issystem" => $v->is_system ? 1 : 0, 
												"setting_category" => $v->category,
												"setting_securitycache" => serialize($v->securitycache))));
        if(!$this->nocache)
			parent::add($v->name, $v);
	}
	public function exists($index) {
		if(!$this->nocache)
			return parent::exists($index);
		else {
			global $core;
			$settings = $core->dbe->ExecuteReader("select count(*) as c from ".$this->table." where setting_name='".$index."'");
			$s = $settings->Read();
			return $s->c > 0;
		}
	}
	public function __set($name, $v) {
		global $core;
		if($v instanceof Setting) {
			if($this->exists($name)) {
				$core->dbe->set($this->table, "setting_name", $name, new collection(array("setting_type" => $v->type, "setting_value" => $v->value, "setting_securitycache" => serialize($v->securitycache), "setting_issystem" => $v->is_system, "setting_category" => $v->category)));
				if(!$this->nocache)
					parent::__set($name, $v);
			}
			else {
				$this->add($v);
			}
		}
		else {
			$core->dbe->set($this->table, "setting_name", $name, new collection(array("setting_value" => $v)));
			if(!$this->nocache)
				$this->item($name)->value = $v;
		}
	}
	public function item($index) {
		if(!$this->nocache) {
			return parent::item($index);
		}
		else {
			global $core;
			$settings = $core->dbe->ExecuteReader("select * from ".$this->table." where setting_name='".$index."'");
			if($settings->count() > 0)  {
				$s = $settings->Read();
				return new Setting($s->setting_name, $s->setting_type, $s->setting_value, $s->setting_securitycache, $s->setting_issystem, $s->setting_category);
			}
			else
				return null;
		}
	}
	public function __get($name) {
		if(!$this->nocache) {
			if(parent::exists($name)) {
				return parent::item(strtolower($name))->value;
			}
			else
				return null;
		}
		else {
			global $core;
			$settings = $core->dbe->ExecuteReader("select * from ".$this->table." where setting_name='".$name."'");
			if($settings->count() > 0)  {
				$s = $settings->Read();
				return $s->setting_value;
			}
			else
				return null;
		}
	}
	public function get_categories() {
		global $core;
		$ret = new ArrayList();
		$rss = $core->dbe->ExecuteReader("select distinct setting_category from ".$this->table);
		while($v = $rss->Read()) {
			$ret->Add($v->setting_category);
		}
		return $ret;
	}
	public function get_collection($category = null, $setting_type = -1) {
		global $core;
		$ret = new collection();			
		$crit = "";
		if(!is_null($category))
			$crit .= " where setting_category='".$category."'";
		if($setting_type >= 0)
			$crit .= " and setting_issystem='".$setting_type."'";
		$rss = $core->dbe->ExecuteReader("select * from ".$this->table.$crit." order by setting_issystem");
		while($v = $rss->Read()) {
			$ret->add($v->setting_name, new Setting($v->setting_name, $v->setting_type, $v->setting_value, $v->setting_securitycache, $v->setting_issystem, $v->setting_category));
		}
		return $ret;
	}
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("settings.add", "Add a setting"));
		$operations->Add(new Operation("settings.delete", "Delete the setting"));
		$operations->Add(new Operation("settings.edit", "Edit setting value"));
		return $operations;
	}
	public function createSecurityBathHierarchy($suboperation) {
		return array( 
						array("object" => $this, "operation" => "settings.".$suboperation)
				     );
	}
}
?>
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
	function Out() {
		header("ContentType: ".$this->mimetype);
		echo $this->Binary();
	}
	function Binary() {
        global $core;
        $size = $core->fs->FileSize($this->tmp_path, -1);
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
class Request {
	private $_postFiles;
	function __construct() {
		$this->_postFiles = array();
	}
	public function RegisterEvents(){
	}
	public function RegisterEventHandlers(){
	}
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
                if(!is_null(@$_SERVER['HTTP_REFERER'])) return @$_SERVER['HTTP_REFERER'];
                if(!is_null(@$_GET['referer'])) return @$_GET['referer'];
                if(!is_null(@$_POST['referer'])) return @$_POST['referer'];
                if(!is_null(@$_SESSION['referer'])) return @$_SESSION['referer'];
                if(!is_null(@$_GET['REFERER'])) return @$_GET['REFERER'];
                if(!is_null(@$_POST['REFERER'])) return @$_POST['REFERER'];
                if(!is_null(@$_SESSION['REFERER'])) return @$_SESSION['REFERER'];
				return null;
				break;
			case "currentUrl":
                                                                return @$_SERVER['REQUEST_URI'];
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
								break;
			}
		}
	}
}
?>
<?php
class FileSystem  {
	function __contstruct() {
	}
	public function Initialize(){
	}
    public function Dispose() {
    }
	private function _relpath($href, $siteroot) {
		if(substr($href, 1, 1) != "/") {
			$cd = strtolower(getcwd());
			$relpath = substr($cd, strlen($siteroot) + 1, strlen($cd) - strlen($siteroot)-1)."/";
			$relpath = str_replace("\\", "/", $relpath);
			$href = substr($href, 1, strlen($href) - 1);
		}		
		else {
			$relpath = "/";
		}
		return $relpath.$href;
	}
	function mappath($href, $where = SITE) {
        global $core;
        if(substr($href, 0, strlen('http://')) == "http://")
            return $href;
        if(file_exists($href))
            return $href;
        if(substr($href, 1, 1) == ":")
			return $href;
        if($where == SITE)
			$sitepath = strtolower($core->sitePath);
        elseif($where == ADMIN)
            $sitepath = strtolower($core->adminPath);
        elseif($where == CORE)
            $sitepath = strtolower($core->corePath);
        else
            $sitepath = "/";
        if(substr($href, 0, strlen($sitepath)) == $sitepath)
            return $href;
        if(substr($href, 0, 1) == "/" || substr($href, 0, 1) == "\\")
            $href = substr($href, 1);
        $href = $sitepath.$href;
        $href = str_replace("\\", "/", $href);
        return $href;
	}
	function relpath($path, $relto = '') {
		global $core;
		$sitepath = strtolower($core->sitePath);
		$relpath = "/".substr($path, strlen($sitepath));
		$path = str_replace("\\", "/", $relpath);
        if(!is_empty($relto)) {
            $path = '/'.str_replace($relto, '', $path);
        }
        return $path;
	}
	public function formatfilesize($Size) {
		$Range = 1024;
		$Postfixes = array("bytes", "Kb", "Mb", "Gb", "Tb");
		for($j = 0; $j < count($Postfixes); $j++) {
			if($Size <= $Range)
				break;
			else
				$Size = $Size / $Range;
		}
		$Size = round($Size, 2);
		$Info = $Size." ".$Postfixes[$j];
		return $Info;
	}
	public function siteroot() {
		global $core;
		return strtolower($core->sitePath);
	}
	public function ReadFile($fpath, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        return @file_get_contents($fpath);
	}
    public function SplitFile($fpath, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        return @file($fpath);
    }
	public function WriteFile($fpath, $data, $where = SITE) {
		$fpath = $this->mappath($fpath, $where);
		if(!$this->fileexists($fpath))
			touch($fpath);
		return file_put_contents($fpath, $data);
	}
	public function AppendFile($fpath, $data, $where = SITE) {
		$fpath = $this->mappath($fpath, $where);
		return file_put_contents($fpath, $data, FILE_APPEND);
	}
	public function DeleteFile($fpath, $where = SITE) {
		$fpath = $this->mappath($fpath, $where);
		@unlink($fpath);
	}
	public function MoveFile($fpath1, $fpath2, $where = SITE) {
		$fpath1 = $this->mappath($fpath1, $where);
		$fpath2 = $this->mappath($fpath2, $where);
		rename($fpath1, $fpath2);
	}
    public function BackupFile($fpath, $bkpostfix, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        if($this->FileExists($fpath.'.'.$bkpostfix)) $this->DeleteFile($fpath.'.'.$bkpostfix);
        $this->MoveFile($fpath, $fpath.'.'.$bkpostfix);
    }
    public function CopyFile($fpath1, $fpath2, $where = SITE) {
        $fpath1 = $this->mappath($fpath1, $where);
        $fpath2 = $this->mappath($fpath2, $where);
        copy($fpath1, $fpath2);
    }
	public function FileExists($fpath, $where = SITE) {
		if (is_empty($fpath))
			return false;
		$fpath = $this->mappath($fpath, $where);
		return file_exists($fpath);
	}
	public function DeleteDir($dpath, $where = SITE){
				if(strstr($dpath, "resources") === false)
			return;
		$dirs = $this->list_dir($dpath);
		$files = $this->list_files($dpath);
		if($files->Count() > 0 || $dirs->Count()) {
			foreach($dirs as $d) {
				$this->deletedir($dpath.'/'.$d, $where);
			}
			if($files->Count() > 0) {
				foreach($files as $f){ 
					$this->deletefile($dpath.'/'.$f->file, $where);
				}
			}
		}		
		$dpath = $this->mappath($dpath, $where);
		rmdir($dpath);
	}
	public function CreateDir($dpath, $where = SITE){
		$dpath = $this->mappath($dpath, $where);
		return mkdir($dpath, 0777, true);
	}
	public function DirExists($dpath, $where = SITE) {
		$dpath = $this->mappath($dpath, $where);
		return is_dir($dpath);
	}
	public function FileLastModified($fpath, $where = SITE){
		$fpath = $this->mappath($fpath, $where);
		return filemtime($fpath);
	}
    public function FileSize($fpath, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        return @filesize($fpath);
    }
	public function file_lastmodified($fpath, $where = SITE){ return $this->FileLastModified($fpath, $where); }
	function is_f($f, $exts = null) {
		if(!is_null($exts))
			return in_array(strtolower($f->file_ext), $exts);
		else	
			return true;
	}
	function is_pattern($f, $pattern) {
		if(is_null($pattern))
			return true;
		else {
			return preg_match($pattern, $f->file) > 0;
		}
	}
	public function ListFiles($p, $exts = null , $pattern = null, $sortField = "file_name", $sortType = SORT_ASC, $where = SITE) {
		if(!$this->DirExists($p, $where))
            return new ArrayList();
        $ret = array();
		$p = $this->mappath($p, $where);
		if ($handle = opendir($p)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && @filetype($p . '/' . $file) != "dir") {
					$f = $this->file($file);
					if($this->is_f($f, $exts) && $this->is_pattern($f, $pattern))
						$ret[] = $f;
				}
			}
			closedir($handle);
		}	
		$c = new ArrayList($ret);
		$c->sort($sortField, $sortType);
		return $c;
	}
	public function ListDir($p, $sortType = SORT_ASC, $where = SITE) {
        if(!$this->DirExists($p, $where))
            return new ArrayList();
		$ret = array();
		$p = $this->mappath($p, $where);
		if ($handle = opendir($p)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && filetype($p . '/'. $file) == "dir") {
					$ret[] = $file;
				}
			}
			closedir($handle);
		}	
		return new ArrayList($ret);
	}
	public function list_files($p, $exts = null , $pattern = null, $sortField = "file_name", $sortType = SORT_ASC, $where = SITE) { return $this->ListFiles($p, $exts, $pattern, $sortField, $sortType, $where); }
	public function list_dir($p, $sortType = SORT_ASC, $where = SITE) { return $this->ListDir($p, $sortType, $where); }
	public function file($f) {
		$s = explode(".", $f);
		$tmp = new stdClass();
		$tmp->file = $f;
		if(count($s) == 1) {
			$tmp->file_name = $s[0];
			$tmp->file_ext = "";
		}
		else {
			$tmp->file_ext = $s[count($s) - 1];
			array_splice($s, -1);
			$tmp->file_name = implode(".", $s);
		}
		return $tmp;
	}
}
class FinderResults extends ArrayList {
    public function __construct() { parent::__construct(); }
    public function Add(FinderResult $o) { parent::Add($o); }
    public function ReplaceWith($index, FinderResults $o) {
        $this->Delete($index);
        foreach($o as $item) {
            $this->Insert($item, $index);
        }
    }
}
class FinderResult {
    const DIRECTORY = true;
    const FILE = false;
    private $_type;
    private $_path;
    private $_directory;
    private $_file;
    private $_fileName;
    private $_fileType;
    private $_fileLength;
    private $_tag;
    public function __construct($path) {
        $this->_path = $path;
        $this->_type = is_dir($path);
        $this->_directory = dirname($path).'/';
        if(!$this->_type) {
            $this->_file = basename($path);
            $s = explode(".", $this->_file);
            if(count($s) == 1) {
                $this->_fileName = $s[0];
                $this->_fileType = '';
            }
            else {
                $this->_fileType = $s[count($s) - 1];
                array_splice($s, -1);
                $this->_fileName = implode(".", $s);
            }
            $this->_fileLength = filesize($path);
        }
    }
    public function __get($property) {
        switch($property) {            
            case 'type':
                return $this->_type;
            case 'path':
                return $this->_path;
            case 'directory':
                return $this->_directory;
            case 'file':
                return $this->_file;
            case 'name':
                return $this->_fileName;
            case 'extension':
                return $this->_fileType;
            case 'length':
                return $this->_fileLength;
            case 'tag':
                return $this->_tag;
            default: 
                break;
        }
        return false;
    }
    public function __set($property, $value) {
        switch($property) {
            case 'tag':
                $this->_tag = $value;
                break;
            default: 
                break;
        }
    }
}
class Finder {
    private $_root;
    public function __construct($root) {
        $this->_root = $root;
        if(!is_dir($this->_root)) {
            trigger_error('Folder does not exists');
            return;
        }
    }
    private function _checkPattern(FinderResult $f, $pattern) {
        if(is_null($pattern))
            return true;
        else {
            return preg_match($pattern, $f->name) > 0;
        }
    }
    private function _checkType(FinderResult $f, $types) {
        if(!is_null($types))
            return in_array(strtolower($f->extension), $types);
        else    
            return true;
    }
    private function _listAll($path) {
        $ret = new FinderResults();    
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
                    $ret->Add(new FinderResult(remove_end_slash($path).'/'.$file));
            }
            closedir($handle);
        }    
        return $ret;
    }
    public function Find($extensions = array(), $pattern = null) {
        $results = $this->_listAll($this->_root);
        $index = 0;
        while($index < $results->Count()) {
            $f = $results->Item($index);
            if($f->type == FinderResult::DIRECTORY) {
                $results->ReplaceWith($index, $this->_listAll($f->path));    
                continue;
            }
            else {
                if(!($this->_checkType($f, $extensions) && $this->_checkPattern($f, $pattern))) {
                    $results->Delete($index);
                    continue;
                }   
            }
            $index ++;
        }
        return $results;
    }
}
class GZFile {
	private $pointer;
	public function __construct($filename, $mode = MODE_READ) {
		$this->pointer = gzopen($filename, $mode);
	}
	public function read($length = 255) {
		return gzgets($this->pointer, $length);
	}
	public function readall() {
		$sret = "";
		while($s = $this->read()) {
			$sret .= $s;
		}
		return $sret;
	}
	public function write($string, $length = null) {
		if($length)
			return gzputs($this->pointer, $string, $length);
		else
			return gzputs($this->pointer, $string);
	}
	public function close() {
		gzclose($this->pointer);
	}
    public function uncompress($tofile) {
        @unlink($tofile);
        touch($tofile);
        $handle = fopen($tofile, MODE_WRITE);
        while($s = $this->read()) {
            fwrite($handle, $s);
        }
        fclose($handle);
    }
}
class FileStream {
    private $_name;
    public function __construct($name) {
        $this->_name = $name;
    }
    public function __destruct() {
    }
    public function Write($string) {
        return file_put_contents($this->_name, $string, FILE_APPEND);
    }
    public function WriteLine($line) {
        return $this->Write($line."\n");
    }
    public function ReadAll() {
        return file_get_contents($this->_name);
    }
}
class Zip
{
    public function InfosZip ($src, $data=true)
    {
        if (($zip = zip_open(realpath($src))))
        {
            while (($zip_entry = zip_read($zip)))
            {
                $path = zip_entry_name($zip_entry);
                if (zip_entry_open($zip, $zip_entry, "r"))
                {
                    $content[$path] = array (
                        'Ratio' => zip_entry_filesize($zip_entry) ? round(100-zip_entry_compressedsize($zip_entry) / zip_entry_filesize($zip_entry)*100, 1) : false,
                        'Size' => zip_entry_compressedsize($zip_entry),
                        'NormalSize' => zip_entry_filesize($zip_entry));
                    if ($data)
                        $content[$path]['Data'] = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    zip_entry_close($zip_entry);
                }
                else
                    $content[$path] = false;
            }
            zip_close($zip);
            return $content;
        }
        return false;
    }
    public function extractZip ($src, $dest)
    {
        $zip = new ZipArchive;
        if ($zip->open($src)===true)
        {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }
        return false;
    }
    public function makeZip ($src, $dest)
    {
        $zip = new ZipArchive;
        $src = is_array($src) ? $src : array($src);
        if ($zip->open($dest, ZipArchive::CREATE) === true)
        {
            foreach ($src as $item) {
                if (file_exists($item))
                    $this->addZipItem($zip, realpath(dirname($item)).'/', realpath($item));
            }
            $zip->close();
            return true;
        }
        return false;
    }
    private function addZipItem ($zip, $racine, $dir)
    {
        if (is_dir($dir))
        {
            $zip->addEmptyDir(str_replace($racine, '', $dir));
            $lst = scandir($dir);
                array_shift($lst);
                array_shift($lst);
            foreach ($lst as $item)
                $this->addZipItem($zip, $racine, $dir.$item.(is_dir($dir.$item)?'/':''));
        }
        elseif (is_file($dir))
            $zip->addFile($dir, str_replace($racine, '', $dir));
    }
}
?>
<?php
class mailsender {
    public $encoding;
    public $from;
    public $to;
    public $cc;
    public $bcc;
    public $subject;
    public $templ;
    public $smtp_server;
    private $rms;
    public $mailerObject;
    function mailsender($from = "", $to = "", $cc = "", $bcc = "", $subject = "", $template = "", $encoding = "") {
        global $core;
        $this->smtp_server = $core->sts->MAIL_SMTP;
        $this->from = $from;
        $this->to = $to;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->subject = $subject;
        $this->templ = $template;
        $this->encoding = $encoding;
        if($this->encoding == "")
            $this->encoding = $core->sts->MAIL_DEFAULT_ENCODING;
        $this->rms = new mailtemplate();
        $this->mailerObject = new PHPMailer();
                        $this->mailerObject->IsMail();
    }
    public function addrule($tag, $value) {
        $this->rms->add($tag, $value);
    }
    public function removerule($tag) {
        $this->rms->remove($tag);
    }
    public function addaddress($rec) {
        if(!empty($this->to)) {
            if(!is_array($this->to)) {
                $tto = $this->to;
                $this->to = array($tto);
            }
            $this->to[count($this->to)] = $rec;
        }
        else
            $this->to = $rec;
    }
    public function getBody() {
        return $this->rms->apply($this->templ); 
    }
    public function AddAttachment($path, $name = "", $encoding = "base64", $type = "application/octet-stream") {
        $this->mailerObject->AddAttachment($path, $name, $encoding, $type);
    }    
    public function send($actualysend = false) {
        global $core;
        $this->mailerObject->CharSet = $this->encoding;
        $this->mailerObject->Host     = $this->smtp_server;
        if(!is_empty($core->sts->MAIL_SMTP_DATA)) {
            $smtpdata = new Collection();
            $smtpdata->FromString($core->sts->MAIL_SMTP_DATA, "\r\n", "=");
            $this->mailerObject->IsSMTP();
            $this->mailerObject->SMTPAuth = $smtpdata->auth == "true" ? true : false;
            $this->mailerObject->Host = $smtpdata->server;
            $this->mailerObject->Port = $smtpdata->port;
            if($this->mailerObject->SMTPAuth) {
                $this->mailerObject->Username = $smtpdata->login;
                $this->mailerObject->Password = $smtpdata->password;
            }
            $this->mailerObject->SMTPSecure = $smtpdata->secure;
        }
        $tmp = $this->from;
        if(preg_match("/(\".*\")?(.*)/", $tmp, $matches) > 0) {
            $this->mailerObject->FromName = convert_string($this->encoding, trim($matches[1], "\""));
            $this->mailerObject->From = $matches[2];
        }
        if(!is_array($this->to))
            $this->mailerObject->AddAddress($this->to);
        else {
            for($i=0; $i < count($this->to); $i++) {
                $this->mailerObject->AddAddress($this->to[$i]);
            }
        }          
        $this->mailerObject->WordWrap = 50;
        $this->mailerObject->IsHTML(true);
        $this->mailerObject->Subject  =  convert_string($this->encoding, $this->subject);
                        $this->mailerObject->Body =  convert_string($this->encoding, $this->getBody());
        if(!$this->mailerObject->Send($actualysend)) {
           trigger_error("Message was not sent <p>Mailer Error: " . $this->mailerObject->ErrorInfo);
        }
    }
}
?><?php
if (version_compare(PHP_VERSION, '5.0.0', '<') ) exit("Sorry, this version of PHPMailer will only run on PHP version 5 or greater!\n");
class PHPMailer {
  public $Priority          = 3;
  public $CharSet           = 'iso-8859-1';
  public $ContentType       = 'text/plain';
  public $Encoding          = '8bit';
  public $ErrorInfo         = '';
  public $From              = 'root@localhost';
  public $FromName          = 'Root User';
  public $Sender            = '';
  public $Subject           = '';
  public $Body              = '';
  public $AltBody           = '';
  public $WordWrap          = 0;
  public $Mailer            = 'mail';
  public $Sendmail          = '/usr/sbin/sendmail';
  public $PluginDir         = '';
  public $ConfirmReadingTo  = '';
  public $Hostname          = '';
  public $MessageID         = '';
  public $Host          = 'localhost';
  public $Port          = 25;
  public $Helo          = '';
  public $SMTPSecure    = '';
  public $SMTPAuth      = false;
  public $Username      = '';
  public $Password      = '';
  public $Timeout       = 10;
  public $SMTPDebug     = false;
  public $SMTPKeepAlive = false;
  public $SingleTo      = false;
  public $SingleToArray = array();
  public $LE              = "\n";
  public $DKIM_selector   = 'phpmailer';
  public $DKIM_identity   = '';
  public $DKIM_domain     = '';
  public $DKIM_private    = '';
  public $action_function = ''; 
  public $Version         = '5.1';
  private   $smtp           = NULL;
  private   $to             = array();
  private   $cc             = array();
  private   $bcc            = array();
  private   $ReplyTo        = array();
  private   $all_recipients = array();
  private   $attachment     = array();
  private   $CustomHeader   = array();
  private   $message_type   = '';
  private   $boundary       = array();
  protected $language       = array();
  private   $error_count    = 0;
  private   $sign_cert_file = "";
  private   $sign_key_file  = "";
  private   $sign_key_pass  = "";
  private   $exceptions     = false;
  const STOP_MESSAGE  = 0;   const STOP_CONTINUE = 1;   const STOP_CRITICAL = 2; 
  public function __construct($exceptions = false) {
    $this->exceptions = ($exceptions == true);
  }
  public function IsHTML($ishtml = true) {
    if ($ishtml) {
      $this->ContentType = 'text/html';
    } else {
      $this->ContentType = 'text/plain';
    }
  }
  public function IsSMTP() {
    $this->Mailer = 'smtp';
  }
  public function IsMail() {
    $this->Mailer = 'mail';
  }
  public function IsSendmail() {
    if (!stristr(ini_get('sendmail_path'), 'sendmail')) {
      $this->Sendmail = '/var/qmail/bin/sendmail';
    }
    $this->Mailer = 'sendmail';
  }
  public function IsQmail() {
    if (stristr(ini_get('sendmail_path'), 'qmail')) {
      $this->Sendmail = '/var/qmail/bin/sendmail';
    }
    $this->Mailer = 'sendmail';
  }
  public function AddAddress($address, $name = '') {
    return $this->AddAnAddress('to', $address, $name);
  }
  public function AddCC($address, $name = '') {
    return $this->AddAnAddress('cc', $address, $name);
  }
  public function AddBCC($address, $name = '') {
    return $this->AddAnAddress('bcc', $address, $name);
  }
  public function AddReplyTo($address, $name = '') {
    return $this->AddAnAddress('ReplyTo', $address, $name);
  }
  private function AddAnAddress($kind, $address, $name = '') {
    if (!preg_match('/^(to|cc|bcc|ReplyTo)$/', $kind)) {
      echo 'Invalid recipient array: ' . kind;
      return false;
    }
    $address = trim($address);
    $name = trim(preg_replace('/[\r\n]+/', '', $name));     if (!self::ValidateAddress($address)) {
      $this->SetError($this->Lang('invalid_address').': '. $address);
      if ($this->exceptions) {
        throw new phpmailerException($this->Lang('invalid_address').': '.$address);
      }
      echo $this->Lang('invalid_address').': '.$address;
      return false;
    }
    if ($kind != 'ReplyTo') {
      if (!isset($this->all_recipients[strtolower($address)])) {
        array_push($this->$kind, array($address, $name));
        $this->all_recipients[strtolower($address)] = true;
        return true;
      }
    } else {
      if (!array_key_exists(strtolower($address), $this->ReplyTo)) {
        $this->ReplyTo[strtolower($address)] = array($address, $name);
      return true;
    }
  }
  return false;
}
  public function SetFrom($address, $name = '',$auto=1) {
    $address = trim($address);
    $name = trim(preg_replace('/[\r\n]+/', '', $name));     if (!self::ValidateAddress($address)) {
      $this->SetError($this->Lang('invalid_address').': '. $address);
      if ($this->exceptions) {
        throw new phpmailerException($this->Lang('invalid_address').': '.$address);
      }
      echo $this->Lang('invalid_address').': '.$address;
      return false;
    }
    $this->From = $address;
    $this->FromName = $name;
    if ($auto) {
      if (empty($this->ReplyTo)) {
        $this->AddAnAddress('ReplyTo', $address, $name);
      }
      if (empty($this->Sender)) {
        $this->Sender = $address;
      }
    }
    return true;
  }
  public static function ValidateAddress($address) {
    if (function_exists('filter_var')) {       if(filter_var($address, FILTER_VALIDATE_EMAIL) === FALSE) {
        return false;
      } else {
        return true;
      }
    } else {
      return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
    }
  }
    private static function WriteLog($message) {
        global $MAIL_QUEUE, $core;
        $core->fs->AppendFile($MAIL_QUEUE.'log.txt', $message."\n");
    }
    function AddToQueue() {
        global $MAIL_QUEUE, $core;
        $sender = trim($this->From);
        $sendermd5 = md5($sender);
        $queueName = $MAIL_QUEUE.$sendermd5.'/';
        if(!$core->fs->DirExists($queueName)) {
            $core->fs->CreateDir($queueName);
            $queue = XMLNode::Load($MAIL_QUEUE.'queue.xml', true);
            $queue->queues->Append(XMLNode::Load('<queue sender="'.$sender.'" path="'.$queueName.'" />', false));
            $queue->Save($MAIL_QUEUE.'queue.xml');
        }
        $fileName = $queueName.((string)microtime(true)).'.mail';
        $core->fs->WriteFile($fileName, serialize($this));
        PHPMailer::WriteLog('Mail '.$fileName.' saved to queue '.$queueName);
        return true;
    }
    public static function ParseQueues() {
        global $MAIL_QUEUE, $core;
        $queues = XMLNode::Load($MAIL_QUEUE.'queue.xml');
        $limit = $queues->limitperqueue->attributes->value->value;
        $items = $queues->queues->Items('queue');
        foreach($items as $item) {
            $path = $item->attributes->path->value;
            $sender = $item->attributes->sender->value;
            out('Sending queue '.$path.' sender '.$sender);
            $sent = PHPMailer::ActualSend($path, $sender, $limit);
            PHPMailer::WriteLog('Queue successfuly parsed. Sent items: '.$sent);
        }
    }
    public static function ActualSend($path, $sender, $limit) {
        global $core;
        if(!$core->fs->DirExists($path))
            $core->fs->CreateDir($path);
        $iSent = 0;
        $list = $core->fs->ListFiles($path, array('mail', 'error'));
        foreach($list as $file) {
            if($limit <= 0) break;
            $mail = $path.$file->file;
            $mailer = unserialize($core->fs->ReadFile($mail));
            $mailer->IsMail();
                        if($mailer) {
                if(!$mailer->Send(true)) {
                    out('mail sent error...'.$path.$file->file);
                    $core->fs->MoveFile($path.$file->file, $path.$file->file.'.error');
                                    }
                else {
                    out('mail sent ok...');
                    $core->fs->DeleteFile($mail);
                }
            }
            $limit --;
            $iSent ++;
        }
        return $iSent;
    }
  public function Send($actualSend = false) {
    if(!$actualSend)
        return $this->AddToQueue();
    try {
      if ((count($this->to) + count($this->cc) + count($this->bcc)) < 1) {
                return false;
      }
            if(!empty($this->AltBody)) {
        $this->ContentType = 'multipart/alternative';
      }
      $this->error_count = 0;       $this->SetMessageType();
      $header = $this->CreateHeader();
      $body = $this->CreateBody();
      if (empty($this->Body)) {
                return false;
      }
            if ($this->DKIM_domain && $this->DKIM_private) {
        $header_dkim = $this->DKIM_Add($header,$this->Subject,$body);
        $header = str_replace("\r\n","\n",$header_dkim) . $header;
      }
            switch($this->Mailer) {
        case 'sendmail':
          return $this->SendmailSend($header, $body);
        case 'smtp':
          return $this->SmtpSend($header, $body);
        default:
          return $this->MailSend($header, $body);
      }
    } catch (phpmailerException $e) {
      $this->SetError($e->getMessage());
      if ($this->exceptions) {
        throw $e;
      }
      echo $e->getMessage()."\n";
      return false;
    }
  }
  protected function SendmailSend($header, $body) {
    if ($this->Sender != '') {
      $sendmail = sprintf("%s -oi -f %s -t", escapeshellcmd($this->Sendmail), escapeshellarg($this->Sender));
    } else {
      $sendmail = sprintf("%s -oi -t", escapeshellcmd($this->Sendmail));
    }
    if ($this->SingleTo === true) {
      foreach ($this->SingleToArray as $key => $val) {
        if(!@$mail = popen($sendmail, 'w')) {
          throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
        }
        fputs($mail, "To: " . $val . "\n");
        fputs($mail, $header);
        fputs($mail, $body);
        $result = pclose($mail);
                $isSent = ($result == 0) ? 1 : 0;
        $this->doCallback($isSent,$val,$this->cc,$this->bcc,$this->Subject,$body);
        if($result != 0) {
          throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
        }
      }
    } else {
      if(!@$mail = popen($sendmail, 'w')) {
        throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
      }
      fputs($mail, $header);
      fputs($mail, $body);
      $result = pclose($mail);
            $isSent = ($result == 0) ? 1 : 0;
      $this->doCallback($isSent,$this->to,$this->cc,$this->bcc,$this->Subject,$body);
      if($result != 0) {
        throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
      }
    }
    return true;
  }
  protected function MailSend($header, $body) {
    $toArr = array();
    foreach($this->to as $t) {
      $toArr[] = $this->AddrFormat($t);
    }
    $to = implode(', ', $toArr);
    $params = sprintf("-oi -f %s", $this->Sender);
    if ($this->Sender != '' && strlen(ini_get('safe_mode'))< 1) {
      $old_from = ini_get('sendmail_from');
      ini_set('sendmail_from', $this->Sender);
      if ($this->SingleTo === true && count($toArr) > 1) {
        foreach ($toArr as $key => $val) {
          $rt = @mail($val, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
                    $isSent = ($rt == 1) ? 1 : 0;
          $this->doCallback($isSent,$val,$this->cc,$this->bcc,$this->Subject,$body);
        }
      } else {
        $rt = @mail($to, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
                $isSent = ($rt == 1) ? 1 : 0;
        $this->doCallback($isSent,$to,$this->cc,$this->bcc,$this->Subject,$body);
      }
    } else {
      if ($this->SingleTo === true && count($toArr) > 1) {
        foreach ($toArr as $key => $val) {
          $rt = @mail($val, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
                    $isSent = ($rt == 1) ? 1 : 0;
          $this->doCallback($isSent,$val,$this->cc,$this->bcc,$this->Subject,$body);
        }
      } else {
        $rt = @mail($to, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header);
                $isSent = ($rt == 1) ? 1 : 0;
        $this->doCallback($isSent,$to,$this->cc,$this->bcc,$this->Subject,$body);
      }
    }
    if (isset($old_from)) {
      ini_set('sendmail_from', $old_from);
    }
    if(!$rt) {
      throw new phpmailerException($this->Lang('instantiate'), self::STOP_CRITICAL);
    }
    return true;
  }
  protected function SmtpSend($header, $body) {
        $bad_rcpt = array();
    if(!$this->SmtpConnect()) {
      throw new phpmailerException($this->Lang('smtp_connect_failed'), self::STOP_CRITICAL);
    }
    $smtp_from = ($this->Sender == '') ? $this->From : $this->Sender;
    if(!$this->smtp->Mail($smtp_from)) {
      throw new phpmailerException($this->Lang('from_failed') . $smtp_from, self::STOP_CRITICAL);
    }
        foreach($this->to as $to) {
      if (!$this->smtp->Recipient($to[0])) {
        $bad_rcpt[] = $to[0];
                $isSent = 0;
        $this->doCallback($isSent,$to[0],'','',$this->Subject,$body);
      } else {
                $isSent = 1;
        $this->doCallback($isSent,$to[0],'','',$this->Subject,$body);
      }
    }
    foreach($this->cc as $cc) {
      if (!$this->smtp->Recipient($cc[0])) {
        $bad_rcpt[] = $cc[0];
                $isSent = 0;
        $this->doCallback($isSent,'',$cc[0],'',$this->Subject,$body);
      } else {
                $isSent = 1;
        $this->doCallback($isSent,'',$cc[0],'',$this->Subject,$body);
      }
    }
    foreach($this->bcc as $bcc) {
      if (!$this->smtp->Recipient($bcc[0])) {
        $bad_rcpt[] = $bcc[0];
                $isSent = 0;
        $this->doCallback($isSent,'','',$bcc[0],$this->Subject,$body);
      } else {
                $isSent = 1;
        $this->doCallback($isSent,'','',$bcc[0],$this->Subject,$body);
      }
    }
    if (count($bad_rcpt) > 0 ) {       $badaddresses = implode(', ', $bad_rcpt);
      throw new phpmailerException($this->Lang('recipients_failed') . $badaddresses);
    }
    if(!$this->smtp->Data($header . $body)) {
      throw new phpmailerException($this->Lang('data_not_accepted'), self::STOP_CRITICAL);
    }
    if($this->SMTPKeepAlive == true) {
      $this->smtp->Reset();
    }
    return true;
  }
  public function SmtpConnect() {
    if(is_null($this->smtp)) {
      $this->smtp = new SMTP();
    }
    $this->smtp->do_debug = $this->SMTPDebug;
    $hosts = explode(';', $this->Host);
    $index = 0;
    $connection = $this->smtp->Connected();
        try {
      while($index < count($hosts) && !$connection) {
        $hostinfo = array();
        if (preg_match('/^(.+):([0-9]+)$/', $hosts[$index], $hostinfo)) {
          $host = $hostinfo[1];
          $port = $hostinfo[2];
        } else {
          $host = $hosts[$index];
          $port = $this->Port;
        }
        $tls = ($this->SMTPSecure == 'tls');
        $ssl = ($this->SMTPSecure == 'ssl');
        if ($this->smtp->Connect(($ssl ? 'ssl://':'').$host, $port, $this->Timeout)) {
          $hello = ($this->Helo != '' ? $this->Helo : $this->ServerHostname());
          $this->smtp->Hello($hello);
          if ($tls) {
            if (!$this->smtp->StartTLS()) {
              throw new phpmailerException($this->Lang('tls'));
            }
                        $this->smtp->Hello($hello);
          }
          $connection = true;
          if ($this->SMTPAuth) {
            if (!$this->smtp->Authenticate($this->Username, $this->Password)) {
              throw new phpmailerException($this->Lang('authenticate'));
            }
          }
        }
        $index++;
        if (!$connection) {
          throw new phpmailerException($this->Lang('connect_host'));
        }
      }
    } catch (phpmailerException $e) {
      $this->smtp->Reset();
      throw $e;
    }
    return true;
  }
  public function SmtpClose() {
    if(!is_null($this->smtp)) {
      if($this->smtp->Connected()) {
        $this->smtp->Quit();
        $this->smtp->Close();
      }
    }
  }
  function SetLanguage($langcode = 'en', $lang_path = 'language/') {
        $PHPMAILER_LANG = array(
      'provide_address' => 'You must provide at least one recipient email address.',
      'mailer_not_supported' => ' mailer is not supported.',
      'execute' => 'Could not execute: ',
      'instantiate' => 'Could not instantiate mail function.',
      'authenticate' => 'SMTP Error: Could not authenticate.',
      'from_failed' => 'The following From address failed: ',
      'recipients_failed' => 'SMTP Error: The following recipients failed: ',
      'data_not_accepted' => 'SMTP Error: Data not accepted.',
      'connect_host' => 'SMTP Error: Could not connect to SMTP host.',
      'file_access' => 'Could not access file: ',
      'file_open' => 'File Error: Could not open file: ',
      'encoding' => 'Unknown encoding: ',
      'signing' => 'Signing Error: ',
      'smtp_error' => 'SMTP server error: ',
      'empty_message' => 'Message body empty',
      'invalid_address' => 'Invalid address',
      'variable_set' => 'Cannot set or reset variable: '
    );
        $l = true;
    if ($langcode != 'en') {       $l = @include $lang_path.'phpmailer.lang-'.$langcode.'.php';
    }
    $this->language = $PHPMAILER_LANG;
    return ($l == true);   }
  public function GetTranslations() {
    return $this->language;
  }
  public function AddrAppend($type, $addr) {
    $addr_str = $type . ': ';
    $addresses = array();
    foreach ($addr as $a) {
      $addresses[] = $this->AddrFormat($a);
    }
    $addr_str .= implode(', ', $addresses);
    $addr_str .= $this->LE;
    return $addr_str;
  }
  public function AddrFormat($addr) {
    if (empty($addr[1])) {
      return $this->SecureHeader($addr[0]);
    } else {
      return $this->EncodeHeader($this->SecureHeader($addr[1]), 'phrase') . " <" . $this->SecureHeader($addr[0]) . ">";
    }
  }
  public function WrapText($message, $length, $qp_mode = false) {
    $soft_break = ($qp_mode) ? sprintf(" =%s", $this->LE) : $this->LE;
            $is_utf8 = (strtolower($this->CharSet) == "utf-8");
    $message = $this->FixEOL($message);
    if (substr($message, -1) == $this->LE) {
      $message = substr($message, 0, -1);
    }
    $line = explode($this->LE, $message);
    $message = '';
    for ($i=0 ;$i < count($line); $i++) {
      $line_part = explode(' ', $line[$i]);
      $buf = '';
      for ($e = 0; $e<count($line_part); $e++) {
        $word = $line_part[$e];
        if ($qp_mode and (strlen($word) > $length)) {
          $space_left = $length - strlen($buf) - 1;
          if ($e != 0) {
            if ($space_left > 20) {
              $len = $space_left;
              if ($is_utf8) {
                $len = $this->UTF8CharBoundary($word, $len);
              } elseif (substr($word, $len - 1, 1) == "=") {
                $len--;
              } elseif (substr($word, $len - 2, 1) == "=") {
                $len -= 2;
              }
              $part = substr($word, 0, $len);
              $word = substr($word, $len);
              $buf .= ' ' . $part;
              $message .= $buf . sprintf("=%s", $this->LE);
            } else {
              $message .= $buf . $soft_break;
            }
            $buf = '';
          }
          while (strlen($word) > 0) {
            $len = $length;
            if ($is_utf8) {
              $len = $this->UTF8CharBoundary($word, $len);
            } elseif (substr($word, $len - 1, 1) == "=") {
              $len--;
            } elseif (substr($word, $len - 2, 1) == "=") {
              $len -= 2;
            }
            $part = substr($word, 0, $len);
            $word = substr($word, $len);
            if (strlen($word) > 0) {
              $message .= $part . sprintf("=%s", $this->LE);
            } else {
              $buf = $part;
            }
          }
        } else {
          $buf_o = $buf;
          $buf .= ($e == 0) ? $word : (' ' . $word);
          if (strlen($buf) > $length and $buf_o != '') {
            $message .= $buf_o . $soft_break;
            $buf = $word;
          }
        }
      }
      $message .= $buf . $this->LE;
    }
    return $message;
  }
  public function UTF8CharBoundary($encodedText, $maxLength) {
    $foundSplitPos = false;
    $lookBack = 3;
    while (!$foundSplitPos) {
      $lastChunk = substr($encodedText, $maxLength - $lookBack, $lookBack);
      $encodedCharPos = strpos($lastChunk, "=");
      if ($encodedCharPos !== false) {
                        $hex = substr($encodedText, $maxLength - $lookBack + $encodedCharPos + 1, 2);
        $dec = hexdec($hex);
        if ($dec < 128) {                               $maxLength = ($encodedCharPos == 0) ? $maxLength :
          $maxLength - ($lookBack - $encodedCharPos);
          $foundSplitPos = true;
        } elseif ($dec >= 192) {                     $maxLength = $maxLength - ($lookBack - $encodedCharPos);
          $foundSplitPos = true;
        } elseif ($dec < 192) {           $lookBack += 3;
        }
      } else {
                $foundSplitPos = true;
      }
    }
    return $maxLength;
  }
  public function SetWordWrap() {
    if($this->WordWrap < 1) {
      return;
    }
    switch($this->message_type) {
      case 'alt':
      case 'alt_attachments':
        $this->AltBody = $this->WrapText($this->AltBody, $this->WordWrap);
        break;
      default:
        $this->Body = $this->WrapText($this->Body, $this->WordWrap);
        break;
    }
  }
  public function CreateHeader() {
    $result = '';
        $uniq_id = md5(uniqid(time()));
    $this->boundary[1] = 'b1_' . $uniq_id;
    $this->boundary[2] = 'b2_' . $uniq_id;
    $result .= $this->HeaderLine('Date', self::RFCDate());
    if($this->Sender == '') {
      $result .= $this->HeaderLine('Return-Path', trim($this->From));
    } else {
      $result .= $this->HeaderLine('Return-Path', trim($this->Sender));
    }
        if($this->Mailer != 'mail') {
      if ($this->SingleTo === true) {
        foreach($this->to as $t) {
          $this->SingleToArray[] = $this->AddrFormat($t);
        }
      } else {
        if(count($this->to) > 0) {
          $result .= $this->AddrAppend('To', $this->to);
        } elseif (count($this->cc) == 0) {
          $result .= $this->HeaderLine('To', 'undisclosed-recipients:;');
        }
      }
    }
    $from = array();
    $from[0][0] = trim($this->From);
    $from[0][1] = $this->FromName;
    $result .= $this->AddrAppend('From', $from);
        if(count($this->cc) > 0) {
      $result .= $this->AddrAppend('Cc', $this->cc);
    }
        if((($this->Mailer == 'sendmail') || ($this->Mailer == 'mail')) && (count($this->bcc) > 0)) {
      $result .= $this->AddrAppend('Bcc', $this->bcc);
    }
    if(count($this->ReplyTo) > 0) {
      $result .= $this->AddrAppend('Reply-to', $this->ReplyTo);
    }
        if($this->Mailer != 'mail') {
      $result .= $this->HeaderLine('Subject', $this->EncodeHeader($this->SecureHeader($this->Subject)));
    }
    if($this->MessageID != '') {
      $result .= $this->HeaderLine('Message-ID',$this->MessageID);
    } else {
      $result .= sprintf("Message-ID: <%s@%s>%s", $uniq_id, $this->ServerHostname(), $this->LE);
    }
    $result .= $this->HeaderLine('X-Priority', $this->Priority);
    $result .= $this->HeaderLine('X-Mailer', 'PHPMailer '.$this->Version.' (phpmailer.sourceforge.net)');
    if($this->ConfirmReadingTo != '') {
      $result .= $this->HeaderLine('Disposition-Notification-To', '<' . trim($this->ConfirmReadingTo) . '>');
    }
        for($index = 0; $index < count($this->CustomHeader); $index++) {
      $result .= $this->HeaderLine(trim($this->CustomHeader[$index][0]), $this->EncodeHeader(trim($this->CustomHeader[$index][1])));
    }
    if (!$this->sign_key_file) {
      $result .= $this->HeaderLine('MIME-Version', '1.0');
      $result .= $this->GetMailMIME();
    }
    return $result;
  }
  public function GetMailMIME() {
    $result = '';
    switch($this->message_type) {
      case 'plain':
        $result .= $this->HeaderLine('Content-Transfer-Encoding', $this->Encoding);
        $result .= sprintf("Content-Type: %s; charset=\"%s\"", $this->ContentType, $this->CharSet);
        break;
      case 'attachments':
      case 'alt_attachments':
        if($this->InlineImageExists()){
          $result .= sprintf("Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s", 'multipart/related', $this->LE, $this->LE, $this->boundary[1], $this->LE);
        } else {
          $result .= $this->HeaderLine('Content-Type', 'multipart/mixed;');
          $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
        }
        break;
      case 'alt':
        $result .= $this->HeaderLine('Content-Type', 'multipart/alternative;');
        $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
        break;
    }
    if($this->Mailer != 'mail') {
      $result .= $this->LE.$this->LE;
    }
    return $result;
  }
  public function CreateBody() {
    $body = '';
    if ($this->sign_key_file) {
      $body .= $this->GetMailMIME();
    }
    $this->SetWordWrap();
    switch($this->message_type) {
      case 'alt':
        $body .= $this->GetBoundary($this->boundary[1], '', 'text/plain', '');
        $body .= $this->EncodeString($this->AltBody, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->GetBoundary($this->boundary[1], '', 'text/html', '');
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->EndBoundary($this->boundary[1]);
        break;
      case 'plain':
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        break;
      case 'attachments':
        $body .= $this->GetBoundary($this->boundary[1], '', '', '');
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE;
        $body .= $this->AttachAll();
        break;
      case 'alt_attachments':
        $body .= sprintf("--%s%s", $this->boundary[1], $this->LE);
        $body .= sprintf("Content-Type: %s;%s" . "\tboundary=\"%s\"%s", 'multipart/alternative', $this->LE, $this->boundary[2], $this->LE.$this->LE);
        $body .= $this->GetBoundary($this->boundary[2], '', 'text/plain', '') . $this->LE;         $body .= $this->EncodeString($this->AltBody, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->GetBoundary($this->boundary[2], '', 'text/html', '') . $this->LE;         $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->EndBoundary($this->boundary[2]);
        $body .= $this->AttachAll();
        break;
    }
    if ($this->IsError()) {
      $body = '';
    } elseif ($this->sign_key_file) {
      try {
        $file = tempnam('', 'mail');
        file_put_contents($file, $body);         $signed = tempnam("", "signed");
        if (@openssl_pkcs7_sign($file, $signed, "file://".$this->sign_cert_file, array("file://".$this->sign_key_file, $this->sign_key_pass), NULL)) {
          @unlink($file);
          @unlink($signed);
          $body = file_get_contents($signed);
        } else {
          @unlink($file);
          @unlink($signed);
          throw new phpmailerException($this->Lang("signing").openssl_error_string());
        }
      } catch (phpmailerException $e) {
        $body = '';
        if ($this->exceptions) {
          throw $e;
        }
      }
    }
    return $body;
  }
  private function GetBoundary($boundary, $charSet, $contentType, $encoding) {
    $result = '';
    if($charSet == '') {
      $charSet = $this->CharSet;
    }
    if($contentType == '') {
      $contentType = $this->ContentType;
    }
    if($encoding == '') {
      $encoding = $this->Encoding;
    }
    $result .= $this->TextLine('--' . $boundary);
    $result .= sprintf("Content-Type: %s; charset = \"%s\"", $contentType, $charSet);
    $result .= $this->LE;
    $result .= $this->HeaderLine('Content-Transfer-Encoding', $encoding);
    $result .= $this->LE;
    return $result;
  }
  private function EndBoundary($boundary) {
    return $this->LE . '--' . $boundary . '--' . $this->LE;
  }
  private function SetMessageType() {
    if(count($this->attachment) < 1 && strlen($this->AltBody) < 1) {
      $this->message_type = 'plain';
    } else {
      if(count($this->attachment) > 0) {
        $this->message_type = 'attachments';
      }
      if(strlen($this->AltBody) > 0 && count($this->attachment) < 1) {
        $this->message_type = 'alt';
      }
      if(strlen($this->AltBody) > 0 && count($this->attachment) > 0) {
        $this->message_type = 'alt_attachments';
      }
    }
  }
  public function HeaderLine($name, $value) {
    return $name . ': ' . $value . $this->LE;
  }
  public function TextLine($value) {
    return $value . $this->LE;
  }
  public function AddAttachment($path, $name = '', $encoding = 'base64', $type = 'application/octet-stream') {
    try {
      if ( !@is_file($path) ) {
        throw new phpmailerException($this->Lang('file_access') . $path, self::STOP_CONTINUE);
      }
      $filename = basename($path);
      if ( $name == '' ) {
        $name = $filename;
      }
      $this->attachment[] = array(
        0 => $path,
        1 => $filename,
        2 => $name,
        3 => $encoding,
        4 => $type,
        5 => false,          6 => 'attachment',
        7 => 0
      );
    } catch (phpmailerException $e) {
      $this->SetError($e->getMessage());
      if ($this->exceptions) {
        throw $e;
      }
      echo $e->getMessage()."\n";
      if ( $e->getCode() == self::STOP_CRITICAL ) {
        return false;
      }
    }
    return true;
  }
  public function GetAttachments() {
    return $this->attachment;
  }
  private function AttachAll() {
        $mime = array();
    $cidUniq = array();
    $incl = array();
        foreach ($this->attachment as $attachment) {
            $bString = $attachment[5];
      if ($bString) {
        $string = $attachment[0];
      } else {
        $path = $attachment[0];
      }
      if (in_array($attachment[0], $incl)) { continue; }
      $filename    = $attachment[1];
      $name        = $attachment[2];
      $encoding    = $attachment[3];
      $type        = $attachment[4];
      $disposition = $attachment[6];
      $cid         = $attachment[7];
      $incl[]      = $attachment[0];
      if ( $disposition == 'inline' && isset($cidUniq[$cid]) ) { continue; }
      $cidUniq[$cid] = true;
      $mime[] = sprintf("--%s%s", $this->boundary[1], $this->LE);
      $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $this->EncodeHeader($this->SecureHeader($name)), $this->LE);
      $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);
      if($disposition == 'inline') {
        $mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);
      }
      $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", $disposition, $this->EncodeHeader($this->SecureHeader($name)), $this->LE.$this->LE);
            if($bString) {
        $mime[] = $this->EncodeString($string, $encoding);
        if($this->IsError()) {
          return '';
        }
        $mime[] = $this->LE.$this->LE;
      } else {
        $mime[] = $this->EncodeFile($path, $encoding);
        if($this->IsError()) {
          return '';
        }
        $mime[] = $this->LE.$this->LE;
      }
    }
    $mime[] = sprintf("--%s--%s", $this->boundary[1], $this->LE);
    return join('', $mime);
  }
  private function EncodeFile($path, $encoding = 'base64') {
    try {
      if (!is_readable($path)) {
        throw new phpmailerException($this->Lang('file_open') . $path, self::STOP_CONTINUE);
      }
      if (function_exists('get_magic_quotes')) {
        function get_magic_quotes() {
          return false;
        }
      }
      if (PHP_VERSION < 6) {
        $magic_quotes = get_magic_quotes_runtime();
        set_magic_quotes_runtime(0);
      }
      $file_buffer  = file_get_contents($path);
      $file_buffer  = $this->EncodeString($file_buffer, $encoding);
      if (PHP_VERSION < 6) { set_magic_quotes_runtime($magic_quotes); }
      return $file_buffer;
    } catch (Exception $e) {
      $this->SetError($e->getMessage());
      return '';
    }
  }
  public function EncodeString ($str, $encoding = 'base64') {
    $encoded = '';
    switch(strtolower($encoding)) {
      case 'base64':
        $encoded = chunk_split(base64_encode($str), 76, $this->LE);
        break;
      case '7bit':
      case '8bit':
        $encoded = $this->FixEOL($str);
                if (substr($encoded, -(strlen($this->LE))) != $this->LE)
          $encoded .= $this->LE;
        break;
      case 'binary':
        $encoded = $str;
        break;
      case 'quoted-printable':
        $encoded = $this->EncodeQP($str);
        break;
      default:
        $this->SetError($this->Lang('encoding') . $encoding);
        break;
    }
    return $encoded;
  }
  public function EncodeHeader($str, $position = 'text') {
    $x = 0;
    switch (strtolower($position)) {
      case 'phrase':
        if (!preg_match('/[\200-\377]/', $str)) {
                    $encoded = addcslashes($str, "\0..\37\177\\\"");
          if (($str == $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str)) {
            return ($encoded);
          } else {
            return ("\"$encoded\"");
          }
        }
        $x = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);
        break;
      case 'comment':
        $x = preg_match_all('/[()"]/', $str, $matches);
              case 'text':
      default:
        $x += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);
        break;
    }
    if ($x == 0) {
      return ($str);
    }
    $maxlen = 75 - 7 - strlen($this->CharSet);
        if (strlen($str)/3 < $x) {
      $encoding = 'B';
      if (function_exists('mb_strlen') && $this->HasMultiBytes($str)) {
                        $encoded = $this->Base64EncodeWrapMB($str);
      } else {
        $encoded = base64_encode($str);
        $maxlen -= $maxlen % 4;
        $encoded = trim(chunk_split($encoded, $maxlen, "\n"));
      }
    } else {
      $encoding = 'Q';
      $encoded = $this->EncodeQ($str, $position);
      $encoded = $this->WrapText($encoded, $maxlen, true);
      $encoded = str_replace('='.$this->LE, "\n", trim($encoded));
    }
    $encoded = preg_replace('/^(.*)$/m', " =?".$this->CharSet."?$encoding?\\1?=", $encoded);
    $encoded = trim(str_replace("\n", $this->LE, $encoded));
    return $encoded;
  }
  public function HasMultiBytes($str) {
    if (function_exists('mb_strlen')) {
      return (strlen($str) > mb_strlen($str, $this->CharSet));
    } else {       return false;
    }
  }
  public function Base64EncodeWrapMB($str) {
    $start = "=?".$this->CharSet."?B?";
    $end = "?=";
    $encoded = "";
    $mb_length = mb_strlen($str, $this->CharSet);
        $length = 75 - strlen($start) - strlen($end);
        $ratio = $mb_length / strlen($str);
        $offset = $avgLength = floor($length * $ratio * .75);
    for ($i = 0; $i < $mb_length; $i += $offset) {
      $lookBack = 0;
      do {
        $offset = $avgLength - $lookBack;
        $chunk = mb_substr($str, $i, $offset, $this->CharSet);
        $chunk = base64_encode($chunk);
        $lookBack++;
      }
      while (strlen($chunk) > $length);
      $encoded .= $chunk . $this->LE;
    }
        $encoded = substr($encoded, 0, -strlen($this->LE));
    return $encoded;
  }
  public function EncodeQPphp( $input = '', $line_max = 76, $space_conv = false) {
    $hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
    $lines = preg_split('/(?:\r\n|\r|\n)/', $input);
    $eol = "\r\n";
    $escape = '=';
    $output = '';
    while( list(, $line) = each($lines) ) {
      $linlen = strlen($line);
      $newline = '';
      for($i = 0; $i < $linlen; $i++) {
        $c = substr( $line, $i, 1 );
        $dec = ord( $c );
        if ( ( $i == 0 ) && ( $dec == 46 ) ) {           $c = '=2E';
        }
        if ( $dec == 32 ) {
          if ( $i == ( $linlen - 1 ) ) {             $c = '=20';
          } else if ( $space_conv ) {
            $c = '=20';
          }
        } elseif ( ($dec == 61) || ($dec < 32 ) || ($dec > 126) ) {           $h2 = floor($dec/16);
          $h1 = floor($dec%16);
          $c = $escape.$hex[$h2].$hex[$h1];
        }
        if ( (strlen($newline) + strlen($c)) >= $line_max ) {           $output .= $newline.$escape.$eol;           $newline = '';
                    if ( $dec == 46 ) {
            $c = '=2E';
          }
        }
        $newline .= $c;
      }       $output .= $newline.$eol;
    }     return $output;
  }
  public function EncodeQP($string, $line_max = 76, $space_conv = false) {
    if (function_exists('quoted_printable_encode')) {       return quoted_printable_encode($string);
    }
    $filters = stream_get_filters();
    if (!in_array('convert.*', $filters)) {       return $this->EncodeQPphp($string, $line_max, $space_conv);     }
    $fp = fopen('php://temp/', 'r+');
    $string = preg_replace('/\r\n?/', $this->LE, $string);     $params = array('line-length' => $line_max, 'line-break-chars' => $this->LE);
    $s = stream_filter_append($fp, 'convert.quoted-printable-encode', STREAM_FILTER_READ, $params);
    fputs($fp, $string);
    rewind($fp);
    $out = stream_get_contents($fp);
    stream_filter_remove($s);
    $out = preg_replace('/^\./m', '=2E', $out);     fclose($fp);
    return $out;
  }
  public function EncodeQ ($str, $position = 'text') {
        $encoded = preg_replace('/[\r\n]*/', '', $str);
    switch (strtolower($position)) {
      case 'phrase':
        $encoded = preg_replace("/([^A-Za-z0-9!*+\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
        break;
      case 'comment':
        $encoded = preg_replace("/([\(\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
      case 'text':
      default:
                        $encoded = preg_replace('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/e',
              "'='.sprintf('%02X', ord('\\1'))", $encoded);
        break;
    }
        $encoded = str_replace(' ', '_', $encoded);
    return $encoded;
  }
  public function AddStringAttachment($string, $filename, $encoding = 'base64', $type = 'application/octet-stream') {
        $this->attachment[] = array(
      0 => $string,
      1 => $filename,
      2 => basename($filename),
      3 => $encoding,
      4 => $type,
      5 => true,        6 => 'attachment',
      7 => 0
    );
  }
  public function AddEmbeddedImage($path, $cid, $name = '', $encoding = 'base64', $type = 'application/octet-stream') {
    if ( !@is_file($path) ) {
      $this->SetError($this->Lang('file_access') . $path);
      return false;
    }
    $filename = basename($path);
    if ( $name == '' ) {
      $name = $filename;
    }
        $this->attachment[] = array(
      0 => $path,
      1 => $filename,
      2 => $name,
      3 => $encoding,
      4 => $type,
      5 => false,        6 => 'inline',
      7 => $cid
    );
    return true;
  }
  public function InlineImageExists() {
    foreach($this->attachment as $attachment) {
      if ($attachment[6] == 'inline') {
        return true;
      }
    }
    return false;
  }
  public function ClearAddresses() {
    foreach($this->to as $to) {
      unset($this->all_recipients[strtolower($to[0])]);
    }
    $this->to = array();
  }
  public function ClearCCs() {
    foreach($this->cc as $cc) {
      unset($this->all_recipients[strtolower($cc[0])]);
    }
    $this->cc = array();
  }
  public function ClearBCCs() {
    foreach($this->bcc as $bcc) {
      unset($this->all_recipients[strtolower($bcc[0])]);
    }
    $this->bcc = array();
  }
  public function ClearReplyTos() {
    $this->ReplyTo = array();
  }
  public function ClearAllRecipients() {
    $this->to = array();
    $this->cc = array();
    $this->bcc = array();
    $this->all_recipients = array();
  }
  public function ClearAttachments() {
    $this->attachment = array();
  }
  public function ClearCustomHeaders() {
    $this->CustomHeader = array();
  }
  protected function SetError($msg) {
    $this->error_count++;
    if ($this->Mailer == 'smtp' and !is_null($this->smtp)) {
      $lasterror = $this->smtp->getError();
      if (!empty($lasterror) and array_key_exists('smtp_msg', $lasterror)) {
        $msg .= '<p>' . $this->Lang('smtp_error') . $lasterror['smtp_msg'] . "</p>\n";
      }
    }
    $this->ErrorInfo = $msg;
  }
  public static function RFCDate() {
    $tz = date('Z');
    $tzs = ($tz < 0) ? '-' : '+';
    $tz = abs($tz);
    $tz = (int)($tz/3600)*100 + ($tz%3600)/60;
    $result = sprintf("%s %s%04d", date('D, j M Y H:i:s'), $tzs, $tz);
    return $result;
  }
  private function ServerHostname() {
    if (!empty($this->Hostname)) {
      $result = $this->Hostname;
    } elseif (isset($_SERVER['SERVER_NAME'])) {
      $result = $_SERVER['SERVER_NAME'];
    } else {
      $result = 'localhost.localdomain';
    }
    return $result;
  }
  private function Lang($key) {
    if(count($this->language) < 1) {
      $this->SetLanguage('en');     }
    if(isset($this->language[$key])) {
      return $this->language[$key];
    } else {
      return 'Language string failed to load: ' . $key;
    }
  }
  public function IsError() {
    return ($this->error_count > 0);
  }
  private function FixEOL($str) {
    $str = str_replace("\r\n", "\n", $str);
    $str = str_replace("\r", "\n", $str);
    $str = str_replace("\n", $this->LE, $str);
    return $str;
  }
  public function AddCustomHeader($custom_header) {
    $this->CustomHeader[] = explode(':', $custom_header, 2);
  }
  public function MsgHTML($message, $basedir = '') {
    preg_match_all("/(src|background)=\"(.*)\"/Ui", $message, $images);
    if(isset($images[2])) {
      foreach($images[2] as $i => $url) {
                if (!preg_match('#^[A-z]+://#',$url)) {
          $filename = basename($url);
          $directory = dirname($url);
          ($directory == '.')?$directory='':'';
          $cid = 'cid:' . md5($filename);
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          $mimeType  = self::_mime_types($ext);
          if ( strlen($basedir) > 1 && substr($basedir,-1) != '/') { $basedir .= '/'; }
          if ( strlen($directory) > 1 && substr($directory,-1) != '/') { $directory .= '/'; }
          if ( $this->AddEmbeddedImage($basedir.$directory.$filename, md5($filename), $filename, 'base64',$mimeType) ) {
            $message = preg_replace("/".$images[1][$i]."=\"".preg_quote($url, '/')."\"/Ui", $images[1][$i]."=\"".$cid."\"", $message);
          }
        }
      }
    }
    $this->IsHTML(true);
    $this->Body = $message;
    $textMsg = trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s','',$message)));
    if (!empty($textMsg) && empty($this->AltBody)) {
      $this->AltBody = html_entity_decode($textMsg);
    }
    if (empty($this->AltBody)) {
      $this->AltBody = 'To view this email message, open it in a program that understands HTML!' . "\n\n";
    }
  }
  public static function _mime_types($ext = '') {
    $mimes = array(
      'hqx'   =>  'application/mac-binhex40',
      'cpt'   =>  'application/mac-compactpro',
      'doc'   =>  'application/msword',
      'bin'   =>  'application/macbinary',
      'dms'   =>  'application/octet-stream',
      'lha'   =>  'application/octet-stream',
      'lzh'   =>  'application/octet-stream',
      'exe'   =>  'application/octet-stream',
      'class' =>  'application/octet-stream',
      'psd'   =>  'application/octet-stream',
      'so'    =>  'application/octet-stream',
      'sea'   =>  'application/octet-stream',
      'dll'   =>  'application/octet-stream',
      'oda'   =>  'application/oda',
      'pdf'   =>  'application/pdf',
      'ai'    =>  'application/postscript',
      'eps'   =>  'application/postscript',
      'ps'    =>  'application/postscript',
      'smi'   =>  'application/smil',
      'smil'  =>  'application/smil',
      'mif'   =>  'application/vnd.mif',
      'xls'   =>  'application/vnd.ms-excel',
      'ppt'   =>  'application/vnd.ms-powerpoint',
      'wbxml' =>  'application/vnd.wap.wbxml',
      'wmlc'  =>  'application/vnd.wap.wmlc',
      'dcr'   =>  'application/x-director',
      'dir'   =>  'application/x-director',
      'dxr'   =>  'application/x-director',
      'dvi'   =>  'application/x-dvi',
      'gtar'  =>  'application/x-gtar',
      'php'   =>  'application/x-httpd-php',
      'php4'  =>  'application/x-httpd-php',
      'php3'  =>  'application/x-httpd-php',
      'phtml' =>  'application/x-httpd-php',
      'phps'  =>  'application/x-httpd-php-source',
      'js'    =>  'application/x-javascript',
      'swf'   =>  'application/x-shockwave-flash',
      'sit'   =>  'application/x-stuffit',
      'tar'   =>  'application/x-tar',
      'tgz'   =>  'application/x-tar',
      'xhtml' =>  'application/xhtml+xml',
      'xht'   =>  'application/xhtml+xml',
      'zip'   =>  'application/zip',
      'mid'   =>  'audio/midi',
      'midi'  =>  'audio/midi',
      'mpga'  =>  'audio/mpeg',
      'mp2'   =>  'audio/mpeg',
      'mp3'   =>  'audio/mpeg',
      'aif'   =>  'audio/x-aiff',
      'aiff'  =>  'audio/x-aiff',
      'aifc'  =>  'audio/x-aiff',
      'ram'   =>  'audio/x-pn-realaudio',
      'rm'    =>  'audio/x-pn-realaudio',
      'rpm'   =>  'audio/x-pn-realaudio-plugin',
      'ra'    =>  'audio/x-realaudio',
      'rv'    =>  'video/vnd.rn-realvideo',
      'wav'   =>  'audio/x-wav',
      'bmp'   =>  'image/bmp',
      'gif'   =>  'image/gif',
      'jpeg'  =>  'image/jpeg',
      'jpg'   =>  'image/jpeg',
      'jpe'   =>  'image/jpeg',
      'png'   =>  'image/png',
      'tiff'  =>  'image/tiff',
      'tif'   =>  'image/tiff',
      'css'   =>  'text/css',
      'html'  =>  'text/html',
      'htm'   =>  'text/html',
      'shtml' =>  'text/html',
      'txt'   =>  'text/plain',
      'text'  =>  'text/plain',
      'log'   =>  'text/plain',
      'rtx'   =>  'text/richtext',
      'rtf'   =>  'text/rtf',
      'xml'   =>  'text/xml',
      'xsl'   =>  'text/xml',
      'mpeg'  =>  'video/mpeg',
      'mpg'   =>  'video/mpeg',
      'mpe'   =>  'video/mpeg',
      'qt'    =>  'video/quicktime',
      'mov'   =>  'video/quicktime',
      'avi'   =>  'video/x-msvideo',
      'movie' =>  'video/x-sgi-movie',
      'doc'   =>  'application/msword',
      'word'  =>  'application/msword',
      'xl'    =>  'application/excel',
      'eml'   =>  'message/rfc822'
    );
    return (!isset($mimes[strtolower($ext)])) ? 'application/octet-stream' : $mimes[strtolower($ext)];
  }
  public function set($name, $value = '') {
    try {
      if (isset($this->$name) ) {
        $this->$name = $value;
      } else {
        throw new phpmailerException($this->Lang('variable_set') . $name, self::STOP_CRITICAL);
      }
    } catch (Exception $e) {
      $this->SetError($e->getMessage());
      if ($e->getCode() == self::STOP_CRITICAL) {
        return false;
      }
    }
    return true;
  }
  public function SecureHeader($str) {
    $str = str_replace("\r", '', $str);
    $str = str_replace("\n", '', $str);
    return trim($str);
  }
  public function Sign($cert_filename, $key_filename, $key_pass) {
    $this->sign_cert_file = $cert_filename;
    $this->sign_key_file = $key_filename;
    $this->sign_key_pass = $key_pass;
  }
  public function DKIM_QP($txt) {
    $tmp="";
    $line="";
    for ($i=0;$i<strlen($txt);$i++) {
      $ord=ord($txt[$i]);
      if ( ((0x21 <= $ord) && ($ord <= 0x3A)) || $ord == 0x3C || ((0x3E <= $ord) && ($ord <= 0x7E)) ) {
        $line.=$txt[$i];
      } else {
        $line.="=".sprintf("%02X",$ord);
      }
    }
    return $line;
  }
  public function DKIM_Sign($s) {
    $privKeyStr = file_get_contents($this->DKIM_private);
    if ($this->DKIM_passphrase!='') {
      $privKey = openssl_pkey_get_private($privKeyStr,$this->DKIM_passphrase);
    } else {
      $privKey = $privKeyStr;
    }
    if (openssl_sign($s, $signature, $privKey)) {
      return base64_encode($signature);
    }
  }
  public function DKIM_HeaderC($s) {
    $s=preg_replace("/\r\n\s+/"," ",$s);
    $lines=explode("\r\n",$s);
    foreach ($lines as $key=>$line) {
      list($heading,$value)=explode(":",$line,2);
      $heading=strtolower($heading);
      $value=preg_replace("/\s+/"," ",$value) ;       $lines[$key]=$heading.":".trim($value) ;     }
    $s=implode("\r\n",$lines);
    return $s;
  }
  public function DKIM_BodyC($body) {
    if ($body == '') return "\r\n";
        $body=str_replace("\r\n","\n",$body);
    $body=str_replace("\n","\r\n",$body);
        while (substr($body,strlen($body)-4,4) == "\r\n\r\n") {
      $body=substr($body,0,strlen($body)-2);
    }
    return $body;
  }
  public function DKIM_Add($headers_line,$subject,$body) {
    $DKIMsignatureType    = 'rsa-sha1';     $DKIMcanonicalization = 'relaxed/simple';     $DKIMquery            = 'dns/txt';     $DKIMtime             = time() ;     $subject_header       = "Subject: $subject";
    $headers              = explode("\r\n",$headers_line);
    foreach($headers as $header) {
      if (strpos($header,'From:') === 0) {
        $from_header=$header;
      } elseif (strpos($header,'To:') === 0) {
        $to_header=$header;
      }
    }
    $from     = str_replace('|','=7C',$this->DKIM_QP($from_header));
    $to       = str_replace('|','=7C',$this->DKIM_QP($to_header));
    $subject  = str_replace('|','=7C',$this->DKIM_QP($subject_header)) ;     $body     = $this->DKIM_BodyC($body);
    $DKIMlen  = strlen($body) ;     $DKIMb64  = base64_encode(pack("H*", sha1($body))) ;     $ident    = ($this->DKIM_identity == '')? '' : " i=" . $this->DKIM_identity . ";";
    $dkimhdrs = "DKIM-Signature: v=1; a=" . $DKIMsignatureType . "; q=" . $DKIMquery . "; l=" . $DKIMlen . "; s=" . $this->DKIM_selector . ";\r\n".
                "\tt=" . $DKIMtime . "; c=" . $DKIMcanonicalization . ";\r\n".
                "\th=From:To:Subject;\r\n".
                "\td=" . $this->DKIM_domain . ";" . $ident . "\r\n".
                "\tz=$from\r\n".
                "\t|$to\r\n".
                "\t|$subject;\r\n".
                "\tbh=" . $DKIMb64 . ";\r\n".
                "\tb=";
    $toSign   = $this->DKIM_HeaderC($from_header . "\r\n" . $to_header . "\r\n" . $subject_header . "\r\n" . $dkimhdrs);
    $signed   = $this->DKIM_Sign($toSign);
    return "X-PHPMAILER-DKIM: phpmailer.worxware.com\r\n".$dkimhdrs.$signed."\r\n";
  }
  protected function doCallback($isSent,$to,$cc,$bcc,$subject,$body) {
    if (!empty($this->action_function) && function_exists($this->action_function)) {
      $params = array($isSent,$to,$cc,$bcc,$subject,$body);
      call_user_func_array($this->action_function,$params);
    }
  }
}
class phpmailerException extends Exception {
  public function errorMessage() {
    $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
    return $errorMsg;
  }
}
?><?php
class SMTP {
  public $SMTP_PORT = 25;
  public $CRLF = "\r\n";
  public $do_debug;       
  public $do_verp = false;
  private $smtp_conn;   private $error;       private $helo_rply; 
  public function __construct() {
    $this->smtp_conn = 0;
    $this->error = null;
    $this->helo_rply = null;
    $this->do_debug = 0;
  }
  public function Connect($host, $port = 0, $tval = 30) {
        $this->error = null;
        if($this->connected()) {
            $this->error = array("error" => "Already connected to a server");
      return false;
    }
    if(empty($port)) {
      $port = $this->SMTP_PORT;
    }
        $this->smtp_conn = @fsockopen($host,                                     $port,                                     $errno,                                    $errstr,                                   $tval);           if(empty($this->smtp_conn)) {
      $this->error = array("error" => "Failed to connect to server",
                           "errno" => $errno,
                           "errstr" => $errstr);
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": $errstr ($errno)" . $this->CRLF . '<br />';
      }
      return false;
    }
            if(substr(PHP_OS, 0, 3) != "WIN")
     socket_set_timeout($this->smtp_conn, $tval, 0);
        $announce = $this->get_lines();
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $announce . $this->CRLF . '<br />';
    }
    return true;
  }
  public function StartTLS() {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array("error" => "Called StartTLS() without being connected");
      return false;
    }
    fputs($this->smtp_conn,"STARTTLS" . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }
    if($code != 220) {
      $this->error =
         array("error"     => "STARTTLS not accepted from server",
               "smtp_code" => $code,
               "smtp_msg"  => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
        if(!stream_socket_enable_crypto($this->smtp_conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
      return false;
    }
    return true;
  }
  public function Authenticate($username, $password) {
        fputs($this->smtp_conn,"AUTH LOGIN" . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($code != 334) {
      $this->error =
        array("error" => "AUTH not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
        fputs($this->smtp_conn, base64_encode($username) . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($code != 334) {
      $this->error =
        array("error" => "Username not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
        fputs($this->smtp_conn, base64_encode($password) . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($code != 235) {
      $this->error =
        array("error" => "Password not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }
  public function Connected() {
    if(!empty($this->smtp_conn)) {
      $sock_status = socket_get_status($this->smtp_conn);
      if($sock_status["eof"]) {
                if($this->do_debug >= 1) {
            echo "SMTP -> NOTICE:" . $this->CRLF . "EOF caught while checking if connected";
        }
        $this->Close();
        return false;
      }
      return true;     }
    return false;
  }
  public function Close() {
    $this->error = null;     $this->helo_rply = null;
    if(!empty($this->smtp_conn)) {
            fclose($this->smtp_conn);
      $this->smtp_conn = 0;
    }
  }
  public function Data($msg_data) {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Data() without being connected");
      return false;
    }
    fputs($this->smtp_conn,"DATA" . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }
    if($code != 354) {
      $this->error =
        array("error" => "DATA command not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
        $msg_data = str_replace("\r\n","\n",$msg_data);
    $msg_data = str_replace("\r","\n",$msg_data);
    $lines = explode("\n",$msg_data);
    $field = substr($lines[0],0,strpos($lines[0],":"));
    $in_headers = false;
    if(!empty($field) && !strstr($field," ")) {
      $in_headers = true;
    }
    $max_line_length = 998; 
    while(list(,$line) = @each($lines)) {
      $lines_out = null;
      if($line == "" && $in_headers) {
        $in_headers = false;
      }
            while(strlen($line) > $max_line_length) {
        $pos = strrpos(substr($line,0,$max_line_length)," ");
                if(!$pos) {
          $pos = $max_line_length - 1;
          $lines_out[] = substr($line,0,$pos);
          $line = substr($line,$pos);
        } else {
          $lines_out[] = substr($line,0,$pos);
          $line = substr($line,$pos + 1);
        }
        if($in_headers) {
          $line = "\t" . $line;
        }
      }
      $lines_out[] = $line;
            while(list(,$line_out) = @each($lines_out)) {
        if(strlen($line_out) > 0)
        {
          if(substr($line_out, 0, 1) == ".") {
            $line_out = "." . $line_out;
          }
        }
        fputs($this->smtp_conn,$line_out . $this->CRLF);
      }
    }
        fputs($this->smtp_conn, $this->CRLF . "." . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }
    if($code != 250) {
      $this->error =
        array("error" => "DATA not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }
  public function Hello($host = '') {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array(
            "error" => "Called Hello() without being connected");
      return false;
    }
        if(empty($host)) {
            $host = "localhost";
    }
        if(!$this->SendHello("EHLO", $host)) {
      if(!$this->SendHello("HELO", $host)) {
        return false;
      }
    }
    return true;
  }
  private function SendHello($hello, $host) {
    fputs($this->smtp_conn, $hello . " " . $host . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER: " . $rply . $this->CRLF . '<br />';
    }
    if($code != 250) {
      $this->error =
        array("error" => $hello . " not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    $this->helo_rply = $rply;
    return true;
  }
  public function Mail($from) {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Mail() without being connected");
      return false;
    }
    $useVerp = ($this->do_verp ? "XVERP" : "");
    fputs($this->smtp_conn,"MAIL FROM:<" . $from . ">" . $useVerp . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }
    if($code != 250) {
      $this->error =
        array("error" => "MAIL not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }
  public function Quit($close_on_error = true) {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Quit() without being connected");
      return false;
    }
        fputs($this->smtp_conn,"quit" . $this->CRLF);
        $byemsg = $this->get_lines();
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $byemsg . $this->CRLF . '<br />';
    }
    $rval = true;
    $e = null;
    $code = substr($byemsg,0,3);
    if($code != 221) {
            $e = array("error" => "SMTP server rejected quit command",
                 "smtp_code" => $code,
                 "smtp_rply" => substr($byemsg,4));
      $rval = false;
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $e["error"] . ": " . $byemsg . $this->CRLF . '<br />';
      }
    }
    if(empty($e) || $close_on_error) {
      $this->Close();
    }
    return $rval;
  }
  public function Recipient($to) {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Recipient() without being connected");
      return false;
    }
    fputs($this->smtp_conn,"RCPT TO:<" . $to . ">" . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }
    if($code != 250 && $code != 251) {
      $this->error =
        array("error" => "RCPT not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }
  public function Reset() {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Reset() without being connected");
      return false;
    }
    fputs($this->smtp_conn,"RSET" . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }
    if($code != 250) {
      $this->error =
        array("error" => "RSET failed",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }
  public function SendAndMail($from) {
    $this->error = null; 
    if(!$this->connected()) {
      $this->error = array(
          "error" => "Called SendAndMail() without being connected");
      return false;
    }
    fputs($this->smtp_conn,"SAML FROM:" . $from . $this->CRLF);
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }
    if($code != 250) {
      $this->error =
        array("error" => "SAML not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }
  public function Turn() {
    $this->error = array("error" => "This method, TURN, of the SMTP ".
                                    "is not implemented");
    if($this->do_debug >= 1) {
      echo "SMTP -> NOTICE: " . $this->error["error"] . $this->CRLF . '<br />';
    }
    return false;
  }
  public function getError() {
    return $this->error;
  }
  private function get_lines() {
    $data = "";
    while($str = @fgets($this->smtp_conn,515)) {
      if($this->do_debug >= 4) {
        echo "SMTP -> get_lines(): \$data was \"$data\"" . $this->CRLF . '<br />';
        echo "SMTP -> get_lines(): \$str is \"$str\"" . $this->CRLF . '<br />';
      }
      $data .= $str;
      if($this->do_debug >= 4) {
        echo "SMTP -> get_lines(): \$data is \"$data\"" . $this->CRLF . '<br />';
      }
            if(substr($str,3,1) == " ") { break; }
    }
    return $data;
  }
}
?><?php
class StringSelector {
    private $_list;
    public function  __construct($string) {
        $this->_list = array();
        $arr = explode(',', $string);
        $i = 0;
        foreach($arr as $a) {
            $this->_list['a'.$i++] = $a;
        }
    }
    public function Create($string) {
        return new StringSelector($string);
    }
    public function ToString($withKeys = true, $splitter = "\n") {
        $ret = '';
        foreach($this as $k => $v) {
            $ret .= ($withKeys ? $v.':' : '').$v.$splitter;
        }
        return trim($ret, $splitter);
    }
    public function ToPHPScript() {
        return 'StringSelector::Create("'.$this->ToString(false, ",").'")->ToString()';
    }
    public function ToArray() {
        return $this->_list;
    }
    public function Item($index) {
        return $this->_list['a'.$index];
    }    
}    
class NumericSelector {
    private $_list;
    public function  __construct($string) {
        $this->_list = array();
        $arr = explode(',', $string);
        $i = 0;
        foreach($arr as $a) {
            $this->_list['a'.$i++] = $a;
        }
    }
    public function Create($string) {
        return new NumericSelector($string);
    }
    public function ToString($withKeys = true, $splitter = "\n") {
        $ret = '';
        foreach($this->_list as $k => $v) {
            if(is_empty($v))
                continue;
            $ret .= ($withKeys ? substr($k, 1).':' : '').$v.$splitter;
        }
        return trim($ret, $splitter);
    }
    public function ToPHPScript() {
        return 'NumericSelector::Create("'.$this->ToString(false, ",").'")->ToString()';
    }
    public function ToArray() {
        return $this->_list;
    }
    public function Item($index) {
        return $this->_list['a'.$index];
    }
}
class Selector {
    private $_list;
    public function  __construct($string) {
        $this->_list = array();
        $arr = explode(',', $string);
        foreach($arr as $a) {
            if(is_empty(trim($a)))
                continue;
            $b = explode(':', $a);
            $this->_list[$b[0]] = $b[1];
        }
    }
    public function Create($string) {
        return new Selector($string);
    }
    public function ToString($withKeys = true, $splitter = "\n") {
        $ret = '';
        foreach($this->_list as $k => $v) {
            $ret .= ($withKeys ? $k.':' : '').$v.$splitter;
        }
        return trim($ret, $splitter);
    }
    public function ToPHPScript() {
        return 'Selector::Create("'.$this->ToString(true, ",").'")->ToString()';
    }
    public function ToArray() {
        return $this->_list;
    }
    public function Item($index) {
        return $this->_list[$index];
    }
}
class TableInfo extends Object {
    public function __construct($table = null) {
        parent::__construct(null, 'tableinfo_');
        global $core;
        $this->name = $table;
        $this->rows = $core->dbe->CountRows($table);
    }
}
class Lookup extends Object {
    public function __construct($table="", $fields="", $id = "", $show = "", $condition = "", $order = "", $fullquery = "") {
        parent::__construct(null, 'default_');
        $this->table = $table;
        $this->fields = $fields;
        $this->id = $id;
        $this->show = $show;
        $this->condition = $condition;
        $this->order = $order;
        $this->fullquery = $fullquery;                                                                 
    }
    public function __get($prop) {
        if($prop == 'isValid') {
            return !is_empty($this->table) && 
                    !is_empty($this->fields) && 
                    !is_empty($this->id) && 
                    !is_empty($this->show);
        }
        return parent::__get($prop);
    }
    public function Exec() {
        global $core;
        $query = (!is_empty($this->fullquery)) ? $this->fullquery : "SELECT ".$this->fields." FROM ".$this->table."".(is_empty($this->condition) ? "" : " where ".$this->condition).(is_empty($this->order) ? '' : ' order by '.$this->order);
        return $core->dbe->ExecuteReader($query);
    }
    public function Create($table, $fields, $id = "", $show = "", $condition = "", $order = "", $fullquery = "")  {
        return new Lookup($table, $fields, $id, $show, $condition, $order, $fullquery);
    }
    public function ToString() {
        return $this->table.":".$this->fields.":".$this->id.":".$this->show.":".$this->condition.":".$this->order.":".$this->fullquery;
    }
    public function ToPHPScript() {
        return 'Lookup::Create("'.$this->table.'", "'.$this->fields.'", "'.$this->id.'", "'.$this->show.'", "'.$this->condition.'", "'.$this->fullquery.'")->ToString()';
    }
}
class Field extends Object {
	private $_storage;
	public function __construct($storage, $rrow = null) {
		parent::__construct($rrow, "storage_field_");
		$this->_storage = $storage;
		$this->storage_id = @$this->_storage->id;
		$this->field_old = $this->field;
	}
    public static function Create($storage, $name, $field, $type, $default, $required, $showintemplate, $lookup, $onetomany, $values, $group) {
        $f = new Field($storage);
        $f->name = $name;
        $f->field = $field;
        $f->type = $type;
        $f->default = $default;
        $f->required = $required ? 1 : 0;
        $f->showintemplate = $showintemplate ? 1 : 0;
        $f->lookup = $lookup;
        $f->onetomany = $onetomany;
        $f->values = $values;
        $f->group = $group;
        $storage->fields->Add($f);
        return $f;
    }
	public function SplitLookup() {
		$q = $this->lookup;
		if(is_empty($q))
			return false;
		$a = explode(":", $q);
                if(count($a) == 6) {
            $b = $a;
            $a[0] = $b[0];
            $a[1] = $b[1];
            $a[2] = $b[2];
            $a[3] = $b[3];
            $a[4] = $b[4];
            $a[5] = '';
            $a[6] = $b[5];
        }
		return new Lookup($a[0], $a[1], $a[2], $a[3], $a[4], $a[5], $a[6]);
	}
    public function GetValues() {
        if(is_empty($this->values))
            return false;
        $values = $this->values;
        $c = new Collection();
        $c->FromString($values, "\n", ":");
        $k = $c->Keys();
        if(is_numeric($k[0])) {             return new Selector(trim(str_replace("\r", "", str_replace("\n", ",", $values)), ","));
                    }
        else {
                        return new Selector(str_replace("\r", ",", str_replace("\n", ",", $values)));
        }
    }
	public function __get($prop) {
		if($prop == "isMultilink")
			return $this->onetomany != "" && $this->onetomany != "0";
		else if($prop == "isLookup")
			return !is_empty($this->lookup);
        else if($prop == "storage")
            return $this->_storage;
		else
			return parent::__get($prop);
	}
    public function __set($prop, $value) {
        switch($prop){ 
            case "storage":
                $this->_storage = $value;
            default: 
                parent::__set($prop, $value);
        }
    }
	public function Save() {
		global $core;
		if(!is_null($this->_storage) && $this->_storage->id > 0) {
			$core->dbe->StartTrans();
			$this->storage_id = $this->_storage->id;
			$types = $core->dbe->Type2System();
			$data = collection::create($this->data());
			$data->Delete("storage_field_id");
			if($this->id == -1 || is_null($this->id)) {
				$data->Delete("storage_field_id");
				$data->Delete("storage_field_field_old");
				$this->id = $core->dbe->insert("sys_storage_fields", $data);
				if($this->id < 0) {
					$core->dbe->FailTrans();
					return;
				}
				$c = Collection::Create("storage_field_order", $this->id);
				$core->dbe->set("sys_storage_fields", "storage_field_id", $this->id, $c);
				$this->order = $this->id;
				$t = $types->Item($this->type);
				if(!$core->dbe->AddField($this->_storage->table, $this->_storage->table."_".$this->field, $t, $this->required == 1 ? false : true, ($t == "LONGTEXT" || $t == "DATETIME") || is_empty($this->default) ? null : $this->default)){
					$core->dbe->FailTrans();
					return;
				}
			}
			else { 
				$data->Delete("storage_field_id");
				$data->Delete("storage_field_field_old");	
				$core->dbe->set("sys_storage_fields", "storage_field_id", $this->id, $data);
				$t = strtolower($types->Item($this->type));
                $default = $this->default;
                if($t == 'longtext') {
                    $default = null;
                }
                else if($t == 'bigint' || $t == 'real') {
                    if($this->required == 1 && is_empty($default))
                        $default = 0;
                    else
                        $default = null;
                }
                $core->dbe->AlterField2($this->_storage->table, $this->_storage->table."_".$this->field_old, $this->_storage->table."_".$this->field, $t, $this->required == 1 ? false : true, ($t == "LONGTEXT" || $t == "DATETIME") || is_empty($this->default) ? null : $this->default);
			}
			$core->dbe->CompleteTrans();
		}
	}
	public function Delete() {
		global $core;
		if(!is_null($this->_storage)) {
						if(!$core->dbe->query("delete from sys_storage_fields where storage_field_id=".$this->id)) {
								return;
			}
			if(!$core->dbe->RemoveField($this->_storage->table, $this->_storage->table."_".$this->field)) {
								return;
			}
					}
	}
	public function MoveUp() {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_storage_fields 
								  where storage_field_storage_id=".$this->_storage->id." and storage_field_order<".$this->order." 
								  order by storage_field_order desc 
								  limit 1");
		if($r->count() > 0){
			$rr = $r->Read();
			$c = Collection::Create("storage_field_order", $this->order);
			$this->order = $rr->storage_field_order;
			$core->dbe->set("sys_storage_fields", "storage_field_id", $rr->storage_field_id, $c);
			$this->Save();
		}
	}
	public function MoveDown() {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_storage_fields where 
								  storage_field_storage_id=".$this->_storage->id." and storage_field_order>".$this->order." 
								  order by storage_field_order limit 1");
		if($r->count() > 0){
			$rr = $r->Read();
			$c = Collection::Create("storage_field_order", $this->order);
			$this->order = $rr->storage_field_order;
			$core->dbe->set("sys_storage_fields", "storage_field_id", $rr->storage_field_id, $c);
			$this->Save();
		}
	}
	public function ToXML() {
		parent::ToXML("field", array(), array(), array("id"));
	}
	public function FromXML($node) {
		parent::FromXML($node);
		$this->_storage = new Storage($this->storage_id);
	}
    public function Copy($storage = null) {
        if(is_null($storage))
            $storage = $this->_storage;
        $f = new Field($storage);
        $f->name = $this->name;
        $f->field = $this->field;
        $f->type = $this->type;
        $f->default = $this->default;
        $f->required = $this->required;
        $f->showintemplate = $this->showintemplate;
        $f->lookup = $this->lookup;
        $f->onetomany = $this->onetomany;
        $f->values = $this->values;
        $f->group = $this->group;
        return $f;
    }
    public function ToPHPScript($fieldProperty, $storageProperty) {
        $lookup = $this->SplitLookup();
        if($lookup)
            $lookup = $lookup->ToPHPScript();
        else
            $lookup = '""';
        $values = $this->GetValues();
        if($values)
            $values = $values->ToPHPScript();
        else
            $values = '""';
        return $fieldProperty.' = Field::Create('.$storageProperty.', "'.$this->name.'", "'.$this->field.'", "'.to_lower($this->type).'", "'.$this->default.'", '.($this->required ? 'true' : 'false').', '.($this->showintemplate ? 'true' : 'false').', '.$lookup.', "'.$this->onetomany.'", '.$values.', "'.$this->group.'", "'.$this->order.'");'."\n";
    }
}
class Fields extends Collection {
	private $_storage;
    private $_group;
	public function __construct($storage, $group = null) {
		parent::__construct();
		$this->_storage = $storage;
        $this->_group = $group;
		$this->_loadFields();
	}
	private function _loadFields() {
		global $core;
		$rr = $core->dbe->ExecuteReader("select * from sys_storage_fields where storage_field_storage_id=".$this->_storage->id.(!is_null($this->_group) ? " and storage_field_group='".$this->_group."'" : "")." order by storage_field_order", "storage_field_field");
		while($rrow = $rr->Read()) {
			parent::Add($rrow->storage_field_field, new Field($this->_storage, $rrow->Data()));
		}
	}
	public function NewField() {
		return new Field($this->_storage);
	}
	public function Add(Field $value) {
		parent::Add($value->field, $value);
		$value->Save();
	}
	public function Delete($key) {
		if(!($key instanceof Field))
			$key = parent::Item($key);
		$key->Delete();
		parent::Delete($key->field);
	}
	public function Save() {
		foreach($this as $field) {
			$field->Save();
		}
	}
	public function ToXML() {
		$ret = '<fields storage="'.$this->_storage->id.'">';
		foreach($this as $value) {
			$ret .= $value->ToXML();
		}
		$ret .= '</fields>';
		return $ret;
	}
	public function FromXML($node) {
		$this->_storage = new Storage($node->getAttribute("storage"));
		$childs = $node->childNodes;
		foreach($childs as $pair) {
			if($pair->nodeName == "field") {
				$f = new Field();
				$f->FromXML($pair);
				parent::Add($f->field, $f);
			}
		}
	}
    public function ToPHPScript($storageProperty) {
        $ret = '';
        foreach($this as $item) {
            $ret .= $item->ToPHPScript('$field'.$item->field, $storageProperty);
        }
        return $ret;
    }
}
class FieldGroups extends Collection {
    private $_storage;
    public function __construct($storage) {
        parent::__construct();
        $this->_storage = $storage;
        $this->_loadGroups();
        $this->Lock();
    }         
    private function _loadGroups() {
        global $core;
        $rr = $core->dbe->ExecuteReader("select distinct storage_field_group from sys_storage_fields where storage_field_storage_id=".$this->_storage->id, "storage_field_group");
        while($rrow = $rr->Read()) {
            if($rrow->storage_field_group == "" || is_null($rrow->storage_field_group))
                $rrow->storage_field_group = "default";
            parent::Add($rrow->storage_field_group, new Fields($this->_storage, $rrow->storage_field_group));
        }
    }                
}
class Storage extends Object {
	static $fields;
    static $fieldgroups;
	private $_fields;
	private $_templates;
    private $_fieldgroups;
    private $_tableInfo;
	public function __construct($info = null) {
		global $core, $SYSTEM_USE_MEMORY_CACHE;	
        if($SYSTEM_USE_MEMORY_CACHE) {
		    if(!Storage::$fieldgroups)
			    Storage::$fieldgroups = new Collection();
            if(!Storage::$fields)
                Storage::$fields = new Collection();
		    if(!Storages::$cache) {
			    Storages::$cache = new Collection();
			    Storages::$cache->id = new Collection();
			    Storages::$cache->table = new Collection();
		    }
        }
		if(!is_object($info) && !is_null($info)) { 			
			$subcache = !is_numeric($info) ? "table" : "id";
			if( Storages::IsCached($info) ) {
				$info = Storages::$cache->$subcache->Item(!is_numeric($info) ? strtolower($info) : "id".$info);
			}
			else {
				if(is_numeric($info))
					$r = $core->dbe->ExecuteReader("select * from sys_storages where storage_id=".$info);
				else {
					$r = $core->dbe->ExecuteReader("select * from sys_storages where storage_table='".strtolower($info)."'");
				}
				if($r->Count() > 0)
					$info = $r->Read();
				else
					$info = null; 
			}
		}
		parent::__construct($info, "storage_");
		if(is_null($this->id)) {
			$this->id = -1;
						$this->_fields = null;
            $this->_fieldgroups = null;  
			$this->_templates = null;
		}
		if(!($this->securitycache instanceof Hashtable)) {
			$this->securitycache = @unserialize($this->securitycache);
			if(!($this->securitycache instanceof Hashtable))
				$this->securitycache = new Hashtable();
		}
        if($SYSTEM_USE_MEMORY_CACHE) {
		    Storages::$cache->id->Add("id".$this->id, $info);
		    Storages::$cache->table->Add(strtolower($this->table), $info);
        }
	}
    public static function Create($name, $table, $color, $group, $istree) {
        $s = new Storage();
        $s->id = -1;
        $s->name = $name;
        $s->table = strtolower($table);
        $s->color = $color;
        $s->group = $group;
        $s->istree = $istree;
        $s->Save();
        return $s;
    }
	private function _loadFields() {
		global $core;
		if(!is_null(Storage::$fields) && Storage::$fields->Exists($this->table))
			$this->_fields = Storage::$fields->Item($this->table);
		else {
			$this->_fields = new Fields($this);
            if(!is_null(Storage::$fields))
			    Storage::$fields->Add($this->table, $this->_fields);
		}
	}
    private function _loadFieldGroups() {
        global $core;
        if(!is_null(Storage::$fieldgroups) && Storage::$fieldgroups->Exists($this->table))
            $this->_fieldgroups = Storage::$fieldgroups->Item($this->table);
        else {
            $this->_fieldgroups = new FieldGroups($this);
            if(!is_null(Storage::$fieldgroups))
                Storage::$fieldgroups->Add($this->table, $this->_fieldgroups);
        }
    }
    private function _loadTableStats() {
        if(!$this->_tableInfo)
            $this->_tableInfo = Storages::TableStats()->Item($this->table);
    }
	public function __get($nm) {
		switch($nm) {
			case "isValid" :
				return Storages::IsValid($this);
			case "templates":
				if(!($this->_templates instanceof Templates))
					$this->_templates = new Templates($this, TEMPLATE_STORAGE);
				return $this->_templates;
			case "fields":
				if(!($this->_fields instanceof Fields))
					$this->_loadFields();
				return $this->_fields;
            case "fieldgroups":
                if(!($this->_fieldgroups instanceof FieldGroups))
                    $this->_loadFieldGroups();
                return $this->_fieldgroups;
            case "tableInfo":
                $this->_loadTableStats();
                return $this->_tableInfo;
			default:
				return parent::__get($nm);
		}
		return null;
	}
	public function fname($nm) {
		if($this->id > 0)
			return $this->table."_".$nm;
		else
			return $nm;
	}
	public function fromfname($nm) {
		if($this->id > 0)
			return substr($nm, strlen($this->table."_"));
		else 
			return $nm;
	}
		public function is_inlink() {
		global $core;
		$r = $core->dbe->ExecuteReader("select distinct storage_field_onetomany from sys_storage_fields where storage_field_onetomany <> ''");
		while($rr = $r->Read()) {
			$s = $rr->storage_field_onetomany;
			$ss = explode(":", $s);
			if($ss[0] == $this->id)
				return true;
		}
		return false;
	}
	public function ToCollection() {
		$c = new Collection();
		$c->add("name", $this->name);
		$c->add("table", $this->table);
		$c->add("id", $this->id);
		$c->add("sid", $this->sid);
        $c->add("istree", $this->istree);
		$f = new collection();
		foreach($this->fields as $key => $ff) {
			$f->add($key, collection::create($ff->data()));
		}
		$c->add("fields", $f);
		$templates = $this->templates;
		$t = new collection();
		foreach($templates as $tt)
			$t->add($tt->name, $tt->get_collection());
		$c->add("templates", $t);
		return $c;
	}
	public function FromCollection(collection $data){
	}
	public function ToXML(){
		return parent::ToXML("storage", array(), array(), array("id", "securitycache"));
	}
	public function FromXML($node) {
		parent::FromXML($node);
	}
	public function Save() {
		global $core;
		        if($this->id == -1) {
			$data = collection::create($this->_data);
			$data->Delete("storage_id");
            $data->storage_istree = (is_empty($data->storage_istree) ? 0 : $data->storage_istree);
			$data->storage_table = strtolower($data->storage_table);
			$data->storage_securitycache = serialize($data->storage_securitycache);
			$this->id = $core->dbe->insert("sys_storages", $data);
		}
		else {
			$data = collection::create($this->_data);
			$data->storage_securitycache = serialize($data->storage_securitycache);
            $data->storage_istree = (is_empty($data->storage_istree) ? 0 : $data->storage_istree);
			$data->Delete("storage_table");
			$data->Delete("storage_id");
			$core->dbe->set("sys_storages", "storage_id", $this->id, $data);
		}
		if(!$core->dbe->TableExists($this->table)) {
			$this->_createDefTable();
		}
		if($this->fields->Count() > 0)
			$this->fields->Save();
		if($this->templates->Count() > 0)
			$this->templates->Save();
	}
	private function _createDefTable() {
        global $core;
        if($this->istree) {
            if(!$core->dbe->CreateTable($this->table, array(
                    $this->table."_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                    $this->table.'_left_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                    $this->table.'_right_key' => array('type' => 'bigint', 'additional' => ' NOT NULL DEFAULT 0'),
                    $this->table.'_level' => array('type' => 'bigint', 'additional' => 'NOT NULL DEFAULT 0'),
                    $this->table."_datecreated" => array('type' => 'timestamp', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                ), array(
                    $this->table."_id" => array('constraint' => 'PRIMARY KEY', 'fields' => $this->table.'_id'),
                    $this->table."_levels" => array("constraint" => "", "fields" => $this->table."_left_key,".$this->table."_right_key,".$this->table."_level")
                ), ''))  {
                trigger_error("Can not create default table for storage");
            }
        }
        else {
            if(!$core->dbe->CreateTable($this->table, array(
                    $this->table."_id" => array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                    $this->table."_datecreated" => array('type' => 'timestamp', 'additional' => ' NOT NULL default CURRENT_TIMESTAMP'),
                ), array(
                    $this->table."_id" => array('constraint' => 'PRIMARY KEY', 'fields' => $this->table.'_id')
                ), ''))  {
			    trigger_error("Can not create default table for storage");
            }
        }
	}
	public function Delete() {
		global $core;
		$id = $this->id;
		$table = $this->table;
		$core->dbe->query("delete from sys_links where link_child_storage_id=".$id);
		$core->dbe->query("delete from sys_storage_fields where storage_field_storage_id=".$id);
		$core->dbe->query("delete from sys_storages where storage_id=".$id);
		$core->dbe->DropTable($table);
	}
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("storages.storage.delete", "Delete storage"));
		$operations->Add(new Operation("storages.storage.edit", "Edit storage"));
		$operations->Add(new Operation("storages.storage.recompile", "Recompile storage"));
		$operations->Add(new Operation("storages.storage.fields.add", "Add field to storage"));
		$operations->Add(new Operation("storages.storage.fields.delete", "Delete storage field"));
		$operations->Add(new Operation("storages.storage.fields.edit", "Edit storage field"));
		$operations->Add(new Operation("storages.storage.templates.add", "Add storage template"));
		$operations->Add(new Operation("storages.storage.templates.edit", "Edit storage template"));
		$operations->Add(new Operation("storages.storage.templates.delete", "Delete storage template"));
		$operations->Add(new Operation("storages.storage.data.publish", "Publish from storage"));
		$operations->Add(new Operation("storages.storage.data.add", "Add data to storage"));
		$operations->Add(new Operation("storages.storage.data.delete", "Delete the storage data"));
		$operations->Add(new Operation("storages.storage.data.edit", "Edit the storage data"));
		return $operations;
	}
	public function createSecurityBathHierarchy($suboperation) {
		return array( 
						array("object" => new storages(), "operation" => "storages.".$suboperation), 
						array("object" => $this, "operation" => "storages.storage.".$suboperation)
				     );
	}
    public function ToPHPScript() {
        return '
            /* Dumping storage '.$this->table.' */
            $bkeepid = '.$this->id.';
            $storage'.$this->table.' = new Storage("'.$this->table.'");
            if($storage'.$this->table.'->isValid)
                $storage'.$this->table.'->Delete();
            $storage'.$this->table.' = Storage::Create("'.$this->name.'", "'.$this->table.'", "'.$this->color.'", "'.$this->group.'", "'.$this->istree.'");
            $core->dbe->Update("sys_storages", "storage_id", $storage'.$this->table.'->id, Collection::Create("storage_id", $bkeepid), true);
            $storage'.$this->table.'->id = $bkeepid;
            '.$this->fields->ToPHPScript('$storage'.$this->table).'
            '.$this->templates->ToPHPScript('$storage'.$this->table).'
            ';
    }
    public function Copy($newTable = "", $copyFields = false, $copyTemplates = false, $copyData = false) {
        global $core;
        if(is_empty($newTable)) {
            $newTable = $this->table."_copy";
            if($core->dbe->TableExists($newTable))
                $newTable = $this->table."_copy_".str_random(4);
        }
        $s = new Storage();
        $s->name = $this->name;
        $s->table = $newTable;
        $s->color = $this->color;
        $s->group = $this->group;
        $s->istree = $this->istree;
        $s->Save();
        if($copyFields) {
            foreach($this->fields as $field) {
                $f = $field->Copy($s);
                $s->fields->Add($f);
            }
        }
        if($copyTemplates) {
            $templates = $this->templates;
            foreach($templates as $t) {
                $new = Template::Create($t->name, $s);
                $new->name = $t->name;
                $new->list = load_from_file($t->list);
                $new->composite = $t->composite;
                $new->properties = $t->properties;
                $new->styles = load_from_file($t->styles);
                $new->description = $t->description;
                $new->cache = $t->cache;
                $new->cachecheck = $t->cachecheck;
                $new->Save();
            }
        }
        if($copyData && $copyFields) {
                        $dtrs = new DataRows($this);
            $dtrs->Load();
            while($dtr = $dtrs->FetchNext()) {
                $dt = new DataRow($s, null);
                foreach($dtr->storage->fields as $f) {
                    $fname = $f->field;
                    $dt->$fname = $dtr->$fname;
                }
                $dt->Save();
            }
        }
        return $s;
    }
	static function Colors() {
		return array(
			"none" => "",
			"light-red" => "#e59a9a",
			"light-green" => "#9ae5b1",
			"light-blue" => "#9aace5"
		);
	}
}
class Storages extends Collection {
	static $cache;
    static $_tablestats;
	public $securitycache;
	function __construct() {
		$this->securitycache = new Hashtable();
		parent::__construct();
	}
    public static function Groups() {
        global $core;
        $data = new ArrayList();
        $r = $core->dbe->ExecuteReader("select distinct storage_group from sys_storages");
        while($row = $r->Read()) {
            $data->Add($row->storage_group);
        }
        return $data;
    }
	public static function Enum($group = null) {
		global $core;
		$data = new Storages();
        $where = (!is_null($group) ? " storage_group='".$group."'" : "");
        if(!is_empty($where))
            $where = " where".$where;
	    $r = $core->dbe->ExecuteReader("select * from sys_storages".$where);
        while($row = $r->Read()) {
			$data->Add($row->storage_table, new Storage($row));
		}
		return $data;
	}
	public static function IsCached($init) {
        global $SYSTEM_USE_MEMORY_CACHE;
        if($SYSTEM_USE_MEMORY_CACHE) {
            if(!Storages::$cache) {
                Storages::$cache = new Collection();
                Storages::$cache->id = new Collection();
                Storages::$cache->table = new Collection();
            }
		    $field = is_numeric($init) ? "id" : "table";
		    $ii = !is_numeric($init) ? $init : "id".$init;
		    return Storages::$cache->$field->Exists($ii);
        }
        else
            return false;
	}
	public static function IsExists($init){ 		global $core;
		if(Storages::IsCached($init))
			return true;
		$field = is_numeric($init) ? "id" : "table";
		$r = $core->dbe->ExecuteReader("select * from sys_storages where storage_".$field." = '".strtolower($init)."'");
		return $r->Count() > 0;
	}
	public static function IsValid($storage){ 				
		global $core;
		$table = $storage instanceof Storage ? $storage->table : $storage;
		$se = Storages::IsExists($table);
		$te = $core->dbe->TableExists($table); 
		return $se && $te;
	}
	public static function Get($id) {
		return new storage($id);
	}
    public static function TableStats() {
        if(!Storages::$_tablestats) {
            global $core;
            Storages::$_tablestats = new Hashtable();
            $tables = $core->dbe->Tables();
            foreach($tables as $table) {
                Storages::$_tablestats->Add($table, new TableInfo($table));
            }
        }
        return Storages::$_tablestats;
    }
	public function ToXML($criteria = null){
		$ret = "<storages>";
		if (is_array($criteria)){
			$sts = new Storages();
			foreach ($criteria as $crit)
				$sts->add($crit, storages::get($crit));
		} else {
			if($this->Count() == 0)
				$sts = Storages::Enum();
			else 
				$sts = $this;
		}
		foreach ($sts as $st) {
			$ret .= $st->ToXML();
		}
		$ret .= "</storages>";
		return $ret;
	}
	public function FromXML($node) {
		$childs = $node->childNodes;
		foreach ($childs as $pair){
			switch ($pair->nodeName){
				case "storage" :
					$s = new Storage();
					$s->FromXML($pair);
					$this->Add($s->table, $s);
					break;
			}
		}
	}
	public function Save() {
		foreach($this as $storage) {
			$storage->save();
		}
	}
	public function createSecurityBathHierarchy($suboperation) {
		return array(array("object" => $this, "operation" => "storages.".$suboperation));
	}
    public function ToPHPScript() {
        $ret = '';
        $list = Storages::Enum();
        foreach($list as $item) {
            $ret .= $list->ToPHPScript();
        }
        return $ret;
    }
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("storages.add", "Add storage applied to all storages"));
		$operations->Add(new Operation("storages.delete", "Delete storage applied to all storages"));
		$operations->Add(new Operation("storages.edit", "Edit storage applied to all storages"));
		$operations->Add(new Operation("storages.recompile", "Recompile storage applied to all storages"));
		return $operations;
	}
	public function to_xml($criteria = null){ return $this->ToXML($criteria); }
	public function from_xml($el){ $this->FromXML($el); }
}
?><?php
class path  {
	private $spath;
	private $cpath;
	function path() {
		$ks = array_keys($_GET);
		if(count($ks) > 0) {
			$this->spath = $ks[0];
			if(substr($this->spath, strlen($this->spath)-1, 1) == "/")
				$this->spath = substr($this->spath, 0, strlen($this->spath)-1);
			$this->parse();
		}
		else
			$this->cpath = new collection();
	}
	public function parse() {
		if(!is_null($this->spath))
			$this->cpath = new collection(explode("/", $this->spath));
		else
			$this->cpath = new collection();
	}
	public function __get($nm) {
		if($this->cpath->exists($nm)) 
			return $this->cpath->item($nm);
		else
			return null;
	}
	public function __set($nm, $val) {
		if($this->cpath->exists($nm)) {
			$this->cpath->add($nm, $val);
		}
	}
	public function item($k) {
		return $this->cpath->item($k);
	}
	public function last() {
		return $this->cpath->item($this->cpath->count()-1);
	}
	public function count() {
		return $this->cpath->count();
	}
	public function remove($k) {
		$this->cpath->remove($k);
	}
	public function join($c, $sep) {
		$ret = "";
		if($c > $this->cpath->count()) $c = $this->cpath->count()-1;
		for($i=0; $i<$c; $i++) {
			$ret .= $this->cpath->item($i).$sep;
		}
		return $ret;
	}	
}
?><?php
class Language  {
	private $lang;
	private $list;
	function Language() {
		$this->lang = array();
		$this->Load();
	}
	function Load() {
		global $core;
		$this->list = $core->dbe->ExecuteReader("select * from sys_languages")->ReadAll();
	}
	function __get($nm) {
		if (array_key_exists($nm, $this->lang))
			return $this->lang[$nm];
	}
	function __set($nm, $value) {
		$this->lang[$nm] = $value;
	}
	function get_list() {
		return $this->list->dublicate();
	}
	function get_collection() {
		return new collection($this->lang);
	}
}
?><?
class Statistics {
    private $statstable;
    private $statsarchtable;
    private $createstatement;
    private $createstatement1;
    function Statistics() {
    }
    public function RegisterEvents(){
    }
    public function RegisterEventHandlers(){
    }
    public function Dispose() {
    }
    public function Initialize(){
        global $core;
        $this->statstable = sys_table("statistics");
        $this->statsarchtable = sys_table("statsarchive");
        if(!$core->dbe->tableexists($this->statstable)){
            $core->dbe->CreateTable($this->statstable, array(
                    'stats_date' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_site' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_folder' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_publication' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_country_code' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_country_code3' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_country_name' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_region' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_city' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_remoteaddress' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_localaddress' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_session' => array('type' => 'longvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_os' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_os_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser_type' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_browser_version' => array('type' => 'shortvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_referer_domain' => array('type' => 'mediumvarchar', 'additional' => ' NOT NULL default \'\''),
                    'stats_referer_query' => array('type' => 'longtext', 'additional' => ' NOT NULL'),
                    'stats_querystring' => array('type' => 'longtext', 'additional' => ' NOT NULL'), 
                    'stats_cookie' => array('type' => 'longtext', 'additional' => ' NOT NULL')
                )
            , array(), '');
        }
        if(!$core->dbe->tableexists($this->statsarchtable)){
            $core->dbe->CreateTable($this->statsarchtable, array(
                    'stats_date' => array('type' => 'bigint', 'additional' => ' NOT NULL default \'0\''),
                    'stats_archive' => array('type' => 'longtext', 'additional' => '')
                )
            , array(), '');
        }
    }
    function Store($site, $folder, $publication) {
        global $core;
        if(is_object($publication))
            $publication = $publication->id;
        $svars = $core->rq->get_collection(VAR_SERVER);
        $binfo = $core->browserInfo;
        $cookie = $core->rq->get_collection(VAR_COOKIE);
        $uri = $svars->script_uri;
        if(preg_match("/\/admin/", $uri) > 0)
            return;
        $c = new Hashtable();
        $c->FromString($svars->query_string, "&", "=");
        $c->Delete("folder");
        $c->Delete("publication");
        $querystring = $c->ToString("&", "=");
        $data = new collection();
        $data->stats_date = microtime(true);
        $data->stats_site = $site->id;
        $data->stats_folder = $folder->id;
        $data->stats_publication = is_empty($publication) ? 0 : $publication;
        $data->stats_remoteaddress = remoteip();
        $data->stats_localaddress = localip();
        $geoInfo = Geo::RecordByIP($data->stats_remoteaddress);
        $data->stats_country_code = $geoInfo->country_code;
        $data->stats_country_code3 = $geoInfo->country_code3;
        $data->stats_country_name = $geoInfo->country_name;
        $data->stats_region = $geoInfo->region;
        $data->stats_city = $geoInfo->city;
        $data->stats_session = session_id();
        $data->stats_browser = $binfo->name;
        $data->stats_browser_version = $binfo->version;
        $data->stats_browser_type = $binfo->type;
        $data->stats_os = $binfo->os;
        $data->stats_os_version = $binfo->os_version;
        $referer1 = $svars->http_referer;
        $referer = preg_split("/\//", $referer1);
        if(count($referer) > 3) {
            $domain = @$referer[2];
            $query = substr($referer1, strlen($referer[0]."/".$referer[1]."/".$referer[2]));
            $data->stats_referer_domain = $domain;
            $data->stats_referer_query = $query;
        } else {
            $data->stats_referer_domain = "";
            $data->stats_referer_query = "";
        }
        $data->stats_querystring = $querystring;
        $data->stats_cookie = $cookie->ToString();
        $core->dbe->insert($this->statstable, $data);
    }
    function Clear($datestart = 0, $dateend = 9999999999) {
        global $core;
        $core->dbe->query("delete from ".$this->statstable." where stats_date > ".$datestart." and stats_date < ".$dateend);
    }
    public static function getOperations() {
        $operations = new Operations();
        $operations->Add(new Operation("statistics.view", "View statistics"));
        $operations->Add(new Operation("statistics.clear", "Clear statistics"));
        $operations->Add(new Operation("statistics.logs.view", "View server logs"));
        $operations->Add(new Operation("statistics.logs.clear", "Clear server logs"));
        return $operations;
    }
    public function getStatsByDate($time = null, $type = STATS_ALL, $period = STATS_TODAY, $getbots = false) {
        global $core;
         $now = $time;
        if(is_null($now))
            $now = time();
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$now."))";
        $r = $core->dbe->ExecuteReader("select count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where);
        if($r->Count() > 0) {
            $ret = Hashtable::Create($r->Read()->Data());
            $r = $core->dbe->ExecuteReader("select count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." and stats_browser_type='bot'");
            if($r->Count() > 0)
                $ret->bots = $r->Read()->Data();
            else {
                $ret->bots = new stdClass();
                $ret->bots->hits = 0;
                $ret->bots->hosts = 0;
                $ret->bots->sessions = 0;
            }        
            return $ret;
        }
        else
            return null;
    }
    public function getStatsByPage($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        $now = $time;
        if(is_null($now))
            $now = time();
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$now."))";
        $r = $core->dbe->ExecuteReader("select stats_site, stats_folder, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_site, stats_folder");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
    }
    public function getStatsByReferer($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        $now = $time;
        if(is_null($now))
            $now = time();
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$now."))";
        $r = $core->dbe->ExecuteReader("select stats_referer_domain, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_referer_domain");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
    }
    public function getStatsByBrowser($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        $now = $time;
        if(is_null($now))
            $now = time();
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$now."))";
        $r = $core->dbe->ExecuteReader("select stats_browser, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_browser");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
    }
    public function getStatsByOS($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        $now = $time;
        if(is_null($now))
            $now = time();
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$now."))";
        $r = $core->dbe->executeReader("select stats_os, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_os");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
    }
    public function getStatsByRegions($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        $now = $time;
        if(is_null($now))
            $now = time();
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$now."))";
        $r = $core->dbe->executeReader("select stats_country_code, stats_country_name, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_country_code, stats_country_name");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
    }
    public function getStatsBySearchQuery($time = null, $type = STATS_ALL, $period = STATS_TODAY) {
        global $core;
        $now = $time;
        if(is_null($now))
            $now = time();
        $secinday = 86400;
        $secinweek = $secinday*7;
        $secinmonth = $secinday*30;
        $secperiod = $secinday;
        if($period == STATS_LASTWEEK)
            $secperiod = $secinweek;
        elseif($period == STATS_LASTMONTH)
            $secperiod = $secinmonth;
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$now.")) and stats_querystring REGEXP '^q=[^&]*$'";
        global $INDEX_SEARCHFOLDER;
        $rrr = '';
        $rs = $core->dbe->executeReader("select distinct tree_id from sys_tree where tree_name='".$INDEX_SEARCHFOLDER."'");
        while($rr = $rs->Read()) {
            $rrr .= ",".$rr->tree_id;
        }
        if($rrr != "")
            $where .= " and stats_folder in (".substr($rrr, 1).")";
        $r = $core->dbe->executeReader("select stats_querystring, count(*) as hits, count(distinct stats_localaddress) as hosts, count(distinct stats_session) as sessions from sys_statistics where ".$where." group by stats_querystring");
        $r = $r->ReadAll();
        if($r->Count() > 0)
            return $r;
        else
            return null;
    }
    public function GetStatsArchive($time = null) {
        global $core;
        $tdstart = strtotime(strftime("%d.%m.%Y", time()));
        $dstart = strtotime(strftime("%d.%m.%Y", $time));
        if($tdstart == $dstart) {
                        return $this->GetCompleteStats($time);
        }
        $where = "DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$time."))";
        $r = $core->dbe->executeReader("select * from ".$this->statsarchtable." where ".$where);
        return @unserialize($r->Read()->stats_archive);
    }
    public function ArchiveAll($completedata = null) {
        global $core;
        $r = $core->dbe->ExecuteReader("select distinct UNIX_TIMESTAMP(DATE(FROM_UNIXTIME(stats_date))) as dd from ".$this->statstable." where not DATE(UNIX_TIMESTAMP(stats_date) = DATE(FROM_UNIXTIME(".time().")))");
        while($rr = $r->Read()) {
            if($rr->dd > 0)
                $this->ArchiveDayStats($rr->dd+86300);  
        }
    }
    public function GetCompleteStats($time) {
        $completedata = new Collection();
        $completedata->Add("daystats", $this->getStatsByDate($time ,STATS_ALL, STATS_TODAY));
                                $completedata->Add("pages", $this->getStatsByPage($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("domains", $this->getStatsByReferer($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("browsers", $this->getStatsByBrowser($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("os", $this->getStatsByOS($time, STATS_ALL, STATS_TODAY));
        $completedata->Add("regions", $this->getStatsByRegions($time, STATS_ALL, STATS_TODAY));
        global $INDEX_ANALIZESEARCHQUERIES;
        if($INDEX_ANALIZESEARCHQUERIES) {
            $completedata->Add("search", $this->getStatsBySearchQuery($time, STATS_ALL, STATS_TODAY));
        }
        return $completedata;
    }
    public function ArchiveDayStats($time = null, $completedata = null) {
        global $core;
        if(is_null($completedata)) {
            $completedata = $this->GetCompleteStats($time);
        }
        $completedata = serialize($completedata);
        $data = new collection();
        $data->stats_date = $time;
        $data->stats_archive = $completedata;
        $core->dbe->insert($this->statsarchtable, $data);
        $core->dbe->Query("delete from ".$this->statstable." where DATE(FROM_UNIXTIME(stats_date)) = DATE(FROM_UNIXTIME(".$time."))");
                return true;
    }
    public function GetStats($date, $period = STATS_LASTWEEK) {
        $istatPeriod = 8;
        if($period == STATS_LASTMONTH) {
            $istatPeriod = 31;
        }
        $todays = new Hashtable();
        for($i=1; $i<$istatPeriod; $i++) {
            $name = "today".$i;
            $todays->$name  = $this->GetStatsArchive($date-86400*$i);
        }
        $ret = new Hashtable();
        $ret->hits = 0;
        $ret->hosts = 0;
        $ret->sessions = 0;
        $ret->bots = new Hashtable();
        $ret->bots->sessions = 0;
        $ret->bots->sessions = 0;
        $ret->bots->sessions = 0;
        for($i=1; $i<$istatPeriod; $i++) {
            $name = "today".$i;
            $todays->$name  = $this->GetStatsArchive($date-86400*$i);
            $ret->hits += @$todays->$name->daystats->hits;
            $ret->hosts += @$todays->$name->daystats->hosts;
            $ret->sessions += @$todays->$name->daystats->sessions;
            $ret->bots->hits += @$todays->$name->daystats->bots->hits;
            $ret->bots->hosts += @$todays->$name->daystats->bots->hosts;
            $ret->bots->sessions += @$todays->$name->daystats->bots->sessions;
        }
        return $ret;
    }
}
?>
<?php
class StringTable extends Hashtable {
	public $selectedLanguage = "";
	public function __construct() {
		parent::__construct();
	}	
	public function AddLanguage($langId) {
		parent::Add($langId, new Hashtable());
	}	
	public function RemoveLanguage($langId) {
		parent::Delete($langId);
	}
	public function __get($nm) {
		if($this->selectedLanguage == ''){
			return @$this->Item($nm);
		}
		else {
			$l = $this->selectedLanguage;
			return @$this->Item($l)->$nm;
		}
	}
}
?><?php
class ErrorLogLine {
	public $date;
	public $client;
	public $errorType;
	public $errorMessage;
	public $errorInfo;
}
class AccessLogLine {
	public $date;
	public $client;
	public $method;
	public $path;
	public $proto;
	public $status;
	public $datalen;
	public $referer;
	public $useragent;
}
class LogParser {
	private $logpath;
	private $type;
	private $format; 
	public function __construct($logpath, $type = ACCESS_LOG, $format = null) {
		$this->logpath = $logpath;
		$this->type = $type;
		$this->format = $format;
	}
	public function Parse($logOrderBy = null) {
		if($this->type == ACCESS_LOG) {
			return $this->_parseAccessLog($logOrderBy);
		}
		else {
			return $this->_parseErrorLog($logOrderBy);
		}
	}
	private function _parseAccessLog($logOrderBy = null) {
				$pattern = is_null($this->format) ? "/^(.*?) .*? \[(.*?)\] \"([^\s]*) ([^\s]*) ([^\"]*)\" ([^\s]*) (.*?) (\".*\"?) (\".*\"?)$/i" : $this->format;
		$log_lines = file($this->logpath);
		if(is_null($logOrderBy))
			$log = new ArrayList();
		else
			$log = new Collection();
		if(count($log_lines) > 0) {
			foreach($log_lines as $line) {
								if(preg_match($pattern, $line, $matches) > 0) {
					$access = new AccessLogLine();
					$access->client = @$matches[1];
					$access->date = strtotime(@$matches[2]);
					$access->method = @$matches[3];
					$access->path = @$matches[4];
					$access->proto = @$matches[5];
					$access->status= @$matches[6];
					$access->datalen = @$matches[7];
					if(count($matches) > 7) {
						$access->referer = trim(@$matches[8], "\"");	
						$access->useragent = @$matches[9];	
						$access->useragent = substr($access->useragent, 1, strlen($access->useragent)-3);
					}
					if(strpos($access->path, "/admin/") === false && strpos($access->path, "/core/") === false) {
						if(is_null($logOrderBy))
							$log->Add($access);
						else {
							$k = $access->$logOrderBy;
							$ordered = $log->$k;
							if(is_null($ordered))
								$ordered = new ArrayList();
							$ordered->Add($access);
							$log->Add($access->$logOrderBy, $ordered);
						}
					}
					else {
						unset($access);
					}
				}		
			}
		}		
		return $log;	
	}
	private function _parseErrorLog($logOrderBy = null) {
				$pattern = is_null($this->format) ? "/\[(.*?)\] \[(.*?)\] \[client (.*?)\] ([^:]*?): (.*?)$/i" : $this->format;
		$log_lines = file($this->logpath);
		if(is_null($logOrderBy))
			$log = new ArrayList();
		else
			$log = new Collection();
		if(count($log_lines) > 0) {
			foreach($log_lines as $line) {
								if(preg_match($pattern, $line, $matches) > 0) {
					$error = new ErrorLogLine();
					$error->date = strtotime(@$matches[1]);
					$error->errorType = @$matches[2];
					$error->client = @$matches[3];
					$error->errorMessage = @$matches[4];
					$error->errorInfo = @$matches[5];
					if(is_null($logOrderBy))
						$log->Add($error);
					else {
						$k = $error->$logOrderBy;
						$ordered = $log->$k;
						if(is_null($ordered))
							$ordered = new ArrayList();
						$ordered->Add($error);
						$log->Add($error->$logOrderBy, $ordered);
					}
				}		
			}
		}
		return $log;		
	}
}
?>
<?php
class NavigatorCache {
    private $_paths;
    private $_data;
    private $_domains;
    public function __construct() {
        global $SYSTEM_USE_MEMORY_CACHE;
        $this->_data = new Collection();
        $this->_paths = new Collection();
        $this->_domains = new Collection();
    }
    public function Add($key, $item) {
        if(is_numeric($key)) {
            $this->_data->Add('id'.$key, $item);
        }
        else {
            if(!$this->_data->Exists('id'.$item->tree_id))
                $this->_data->Add('id'.$item->tree_id, $item);
            $this->_paths->Add($key, 'id'.$item->tree_id);
        }
        if($item->tree_level == 1)
            $this->_domains->Add($item->tree_domain, 'id'.$item->tree_id);
    }
    public function Delete($key) {
        if(is_numeric($key)) {
            $item = $this->Item($key);
            $this->_data->Delete('id'.$item->tree_id);
            $this->_paths->Delete($this->_paths->IndexOfFirst('id'.$item->tree_id));
        }
        else {
            $id = $this->_paths->Item($key);
            $this->_data->Delete($id);
            $this->_paths->Delete($key);
        }
    }
    public function Path($key) {
                $index = $this->_paths->IndexOfFirst('id'.$key);
                $r = $this->_paths->Key($index);
        return $r;
    }
    public function Domain($domain) {
        $domain = str_replace('www.', '', $domain);
        return $this->_data->Item($this->_domains->Item($domain));
    }
    public function Item($key) {
        if(is_numeric($key))
            return $this->_data->Item('id'.$key);
        else {
            return $this->_data->Item($this->_paths->Item($key));
        }
    }
    public function Clear() {
        $this->_data->Clear();
        $this->_paths->Clear();
        $this->_domains->Clear();
    }
    public function ByName($name) {
        $ret = new ArrayList();
        foreach($this->_paths as $key => $item) {
            $path = explode('/', $key);
            if( $path[count($path) - 1] == $name )
                $ret->Add($this->_data->Item($item));
        }
        return $ret;
    }    
    public function PrecacheTree() {
        global $core;
        $this->Clear();
        $last = null;
        $cpath = array();
        $dbt = new dbtree("sys_tree", "tree");
        $results = $core->dbe->ExecuteReader('select *, (select count(*) from sys_links where link_parent_storage_id=0 and link_parent_id=sys_tree.tree_id) as tree_publications from sys_tree where tree_level > 0 order by tree_left_key');
        while($result = $results->Read()) {
            $obj = $result;             if(!is_null($last)) {
                if(!$this->_IsChildOf($obj, $last)) {
                    if($last->tree_level == $obj->tree_level)
                        array_splice($cpath, count($cpath) - 1, 1);
                    else if($last->tree_level > $obj->tree_level) {
                        array_splice($cpath, count($cpath) - ($last->tree_level - $obj->tree_level + 1), ($last->tree_level - $obj->tree_level + 1));
                    }
                }
            }
            $cpath[] = $obj->tree_name;
            $this->Add($obj->tree_id, $obj);
            $this->Add(join("/", $cpath), $obj);
            if($obj->tree_level == 1)
                $this->_domains->Add($obj->tree_domain, 'id'.$obj->tree_id);
            $last = $obj;
        }
    }
    private function _IsChildOf($p, $f, $self = true){
        if(is_null($f))
            return false;
        if($self)
            return $f->tree_left_key >= $p->tree_left_key && $f->tree_right_key <= $p->tree_right_key;
        else
            return $f->tree_left_key > $p->tree_left_key && $f->tree_right_key < $p->tree_right_key;
    }
    public function Nodes($published_only = false) {
        $ret = new Branch();
        foreach($this->_data as $o) {
            if($o->tree_published && $published_only || !$published_only)
                $ret->Add('id'.$o->tree_id, Navigator::InitNode($o));
        }
        return $ret;
    }
    public function Sites($t = BYNAME) {
        $ret = new Collection();
        foreach($this->_data as $item) {
            if($item->tree_level == 1) {
                $ret->Add($t == BYNAME ? $item->tree_name : $item->tree_domain, Navigator::InitNode($item));
            }
        }
        return $ret;
    }
    public function Children($parent, $published_only = false) {
        $ret = new Branch();  
        $index = $this->_paths->IndexOfFirst('id'.$parent->tree_id);
        $o = $this->_data->Item($index);
        while($this->_IsChildOf($parent, $o)) {
            if($o->tree_level == $parent->tree_level + 1) {
                if($o->tree_published && $published_only || !$published_only) {
                    $ret->Add($o->tree_name, Navigator::InitNode($o));
                }
            }
            $o = $this->_data->Item(++$index);
        }
        return $ret;
    }
    public function Branch($parent, $published_only = false) {
        $ret = new Branch();
        $index = $this->_paths->IndexOfFirst('id'.$parent->tree_id);
        $o = $this->_data->Item($index);
        while($this->_IsChildOf($parent, $o)) {
            if($o->tree_published && $published_only || !$published_only)
                $ret->Add($o->tree_name, Navigator::InitNode($o));
            $o = $this->_data->Item(++$index);
        }
        return $ret;
    }
        public function Ajar($parent, $published_only = false, $forseLevels = 1) {
        $path = $this->Path($parent->tree_id);
        $parents = explode('/', $path);
        $p = '';
        $ret = new Collection();
        foreach($parents as $item) {
            $p = (is_empty($p) ? '' : $p.'/').$item;
            $o = $this->Item($p);
            $ret->Add($o->tree_name, Navigator::InitNode($o));
        }       
        $index = $this->_paths->IndexOfFirst('id'.$parent->tree_id);
        $o = $this->_data->Item($index);
        while($this->_IsChildOf($parent, $this->_data->Item($index))) {
            if($o->tree_level == $parent->tree_level + 1) {
                if($o->tree_published && $published_only || !$published_only)
                    $ret->Add($o->tree_name, Navigator::InitNode($o));
            }
            $o = $this->_data->Item(++$index);
        }
        return $ret;
    }
    public function Parents($node) {
        $path = $this->Path($node->tree_id);
        $parents = explode('/', $path);
        $p = '';
        $ret = new Collection();
        foreach($parents as $item) {
            $p = (is_empty($p) ? '' : $p.'/').$item;
            $o = $this->Item($p);
            $ret->Add($o->tree_name, $o);
        }
        return $ret;        
    }
}
class Navigator extends IEventDispatcher {
    static $cache = null;
    private $_dbt;
    private $_querypath;
    private $_folder;
    private $_fobj;
    private $_publication;
    private $_pobj;
    private $_site;
    private $_storage;
    private $_dataid;
    private $_datarow;
    public $e404 = false;
    public function __construct() {
        Navigator::$cache = new NavigatorCache();
        Navigator::$cache->PrecacheTree();
        $this->_dbt = new dbtree("sys_tree", "tree_");
        $this->_GetCurrentSite();
        $this->_GetCurrentFolder();
    }
    private function _GetCurrentFolder() {
        global $core;
        if($core->isAdmin)
            return;
        $this->DispatchEvent('navigator.getcurrentfolder.start', new Hashtable('navigator', $this));
        $path = $core->rq->REQUEST_URI;
        $path = str_replace(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']),'',$path);
        if(strstr($path, '?') !== false) {
            $parts = explode("?", $path);
            $path = $parts[0];
            $queryString = $parts[1];
            if(count($_GET) == 0) {
                $qs = explode("&", $queryString);
                foreach($qs as $v) {
                    $qss = explode("=", $v);
                    $_GET[$qss[0]] = $qss[1];
                }
            }
        }
        $path = trim($path, "/");
        if(preg_match('/\/(\d+)\.html/', $path, $matches) > 0) {
            $this->_publication = $matches[1];
            $path = str_replace($matches[0], '', $path);
        }
        if(preg_match('/\/([A-z]+)_(\d+)\.html/', $path, $matches) > 0) {
            $this->_storage = $matches[1];
            $this->_dataid = $matches[2];
            $path = str_replace($matches[0], '', $path);
        }                   
        $this->_querypath = $path;
        if(!is_empty($this->_querypath)) {
            $this->_fobj = $this->FindByPath($this->_site->name.'/'.$this->_querypath);
            if(is_null($this->_fobj))
                $this->_fobj = $this->FindByPath($this->_site->name.'/'.FOLDER404);
        }
        $this->DispatchEvent('navigator.getcurrentfolder.complete', new Hashtable('navigator', $this));
    }
    private function _GetCurrentSite() {
        $site_name = @$_SERVER["SERVER_NAME"];
        $site_port = @$_SERVER["SERVER_PORT"];
        $this->_site = new Site(Navigator::$cache->Domain($site_name), null);
        if(is_null($this->_site->id)) {
            $sites = Site::EnumSites(BYDOMAIN);
            if($sites->count() > 0)
                $this->_site = $sites->Item(0);
        }
        return $this->_site;
    }
    public function FindByPath($path = null) {
        if(is_null($path))
            $path = $this->_querypath;
        if(is_array($path))
            $path = join("/", $path);
        $path = trim($path, '/');
        $o = Navigator::$cache->Item($path);
        if(is_null($o))
            return null;
        return Navigator::InitNode($o);
    }
    public static function Fetch($id) {
        global $core;
        return $core->nav->FindByPath($id);
    }     
    public static function FolderExists($id) {
        global $core;
        return !is_null($core->nav->FindByPath($id)); 
    }
    public static function CheckFolderName($name, $parent = null) {
        if(is_null($parent)) {
            $sites = Navigator::$cache->Sites();
            return !$sites->Exists($name);
        }
        else {
            $sublinks = Navigator::$cache->Children($parent);
            return !$sublinks->Exists($name);
        }
    }
    public function Url($folder, $publication = null, $storage = null, $args = null, $lang = null) {
        global $core;
        global $page;
        global $glanguage;
        global $MULTILANGUAL;
        if(!is_null($args))        
            if(is_array($args))
                $args = Collection::Create($args);
        if(is_null($lang) && $MULTILANGUAL) {
            $lang = @$args->lang;
            if(is_null($lang))
                $lang = $glanguage;
            else {
                $args->Delete("lang");
            }
        }
        if($folder instanceof Site) {
            $r = 'http://'.$folder->domain;
        }
        else {
            $r = $folder->path;
            if(!is_null($publication))
                $r .= $publication->id.'.html';
            else {
                if(!is_null($storage))
                    $r .= $storage[0].'_'.$storage[1].".html";
            }
            if(!is_null($page))
                $r .= '?page='.$page;
            if(!is_null($lang))
                $r = '/'.$lang.'/'.$r;    
        }
        if(!is_null($args)) {
            $a = "";
            foreach($args as $k => $v) { 
                if($k == "lang" && !is_null($lang))
                    continue;
                $a .= "&".$k."=".urlencode($v);
            }
            $r .= (is_null($page) ? '?' : '&').substr($a, 1);
        }        
        return $r;
    }
    public function __get($property) {
        switch($property) {
            case "datarow":       
                if(is_null($this->_datarow)) {
                    if(!is_empty($this->_storage) && !is_empty($this->_dataid) && Storages::IsExists($this->_storage))
                        $this->_datarow = new DataRow(new Storage($this->_storage), $this->_dataid);
                }
                return $this->_datarow;
            case "folder":              
                return $this->_fobj;
            case "site":  
                return $this->_site;
            case "path":
                return $this->_folder;
            case "query":
                return $this->_querypath;
            case "publication":
                if(is_null($this->_pobj)) {
                    if(!Publications::Exists($this->_publication))
                        return null;
                    $this->_pobj = new Publication($this->_publication);
                }
                return $this->_pobj;
        }
        return null;
    }
    public function __set($property, $value) {
        switch($property) {
            case "datarow":
                $this->_datarow = $value;
                $this->_storage = $value->storage->name;
                $this->_dataid = $value->id;
                break;
            case "folder":              
                $this->_fobj = $value;
                break;
            case "site":  
                $this->_site = $value;
                break;
            case "publication":  
                if(is_numeric($value)) {
                    $this->_publication = $value;
                }
                else {
                    $this->_publication = $value->id;
                    $this->_pobj = $value;
                }
                break;
        }        
    }
    static function InitNode($dtr) {
        if(!$dtr)
            return false;
        return $dtr->tree_level == 1 ? new Site($dtr, null) : new Folder(null, $dtr);
    }
}
class Folder extends IEventDispatcher {
    public $dbt;
    private $folder = null;
    private $folderpath = null;
    private $tree_children = -1;
    private $_stringPath;
    private $_stringFullPath;
    private $_properties; 
    public function __construct($dbt, $name = null) {
        $this->dbt = $dbt;
        if(is_null($this->dbt))
            $this->dbt = new dbtree('sys_tree', 'tree');
        if(!is_null($name)) {
            $this->Load($name);
        }
        else {
            $this->folder = new Object();
        }
        $this->RegisterEvent("folder.save");
    }
    public function Load($name) {
        global $core;
        if(is_numeric($name)) {            
            $this->folder = Navigator::$cache->Item($name);
        }
        else if(is_string($name)) {
                        $this->folder = Navigator::$cache->Item($name);
        }
        else if(is_object($name)) {
            $this->folder = $name;
        }
        else {
            $this->folder = new Object();
        }
        $this->tree_children = -1;
        $this->folderpath = null;
    }
    public function __get($field) {
        if(is_null($this->folder))
            return null;
        $args = $this->DispatchEvent("folder.property.get", Hashtable::Create("field", $field, "data", $this->folder));
        if(@$args->cancel === true) {
            return @$args->value;
        }
        if($field == "children") {
            if($this->tree_children < 0) {
                if ($this->folder == null)
                    $this->tree_children = 0;
                else {
                    $this->tree_children = $this->Children()->count();                }
            }
            return $this->tree_children;
        }
        if($field == "children_published") {
            $ch = $this->Children();
            $co = 0;
            foreach($ch as $c){
                if($c->published) $co++;
            }
            return $co;
        }
        if($field == "properties") {
            $this->_loadProperties();
            return $this->_properties;
        }
        if($field == "path") {
            $this->_getStringPath();
            return $this->_stringPath;
        }
        if($field == "fullpath") {
            $this->_getFullStringPath();
            return $this->_stringFullPath;
        }
        if($field == "tree_properties") {
            return @$this->folder->tree_properties;
        }
        $nm = $field;
        if(strpos($nm, 'tree_') === false)
            $nm = "tree_".strtolower($nm);
        $vars = $this->folder->ToArray();
        if(@array_key_exists($nm, $vars)) {
            if($nm == "tree_securitycache") {
                if(!($this->folder->$nm instanceof Hashtable)) {                     $this->folder->$nm = @_unserialize($this->folder->$nm);
                    if($this->folder->$nm === false || is_null($this->folder->$nm))
                        $this->folder->$nm = new Hashtable();    
                    return $this->folder->$nm;
                }
                else { 
                    return $this->folder->$nm;
                }
            }
            else {
                return $this->folder->$nm;
            }
        }
        else {
            $this->_loadProperties();
            $prop = $this->_properties->$field;
            if($prop) {
                if($prop->type == "blob") {
                    global $core;
                    return new Blob(intval(@$prop->value));
                }
                else {
                    return @$prop->value;
                }
            }
            return null;
        }
    }
    public function __set($field, $value) {
        $this->_loadProperties();
        $args = $this->DispatchEvent("folder.property.set", Hashtable::Create("field", $field, "value", $value, "data", $this->folder));
        if(@$args->cancel === true) {
            return;
        }
        if($this->_properties->Exists($field))
            $this->_properties->$field->value = $value;
        else {
            $nm = "tree_".$field;
            $this->folder->$nm = $value;
        }
    }
    private function _getStringPath() {
        $this->_stringPath = Navigator::$cache->Path($this->tree_id);
        $this->_stringPath = explode('/', $this->_stringPath);
        array_splice($this->_stringPath, 0, 1);
        $this->_stringPath = '/'.join('/', $this->_stringPath).'/';
    }
    private function _getFullStringPath() {
        $this->_stringFullPath = Navigator::$cache->Path($this->tree_id);
    }
    public function actualTemplate() {
        $tname = "";
        if($this->template > 0)
            $tname = $this->template;
        else {
            $this->get_path();
            if(!is_null($this->folderpath)) {
                $i=-1;
                for($i=$this->folderpath->count()-1; $i >= 0; $i--) {
                    if((int)$this->folderpath->item($i)->tree_template > 0) {
                        $tname = $this->folderpath->item($i)->tree_template;
                        break;
                    }
                }
            }
        }
        return $tname;
    }
    public function IsChildOf($f, $self = true){
        if(is_null($f))
            return false;
        if($self)
            return $this->left_key >= $f->left_key && $this->right_key <= $f->right_key;
        else
            return $this->left_key > $f->left_key && $this->right_key < $f->right_key;
    }
    public function Parent() {
        $this->get_path();
        $r = $this->folderpath->item($this->folderpath->count()-2);
        if($r->tree_level == 1)
            return new Site($r, null);
        else
            return new Folder($this->dbt, $r);
    }
    public function SetModified($date = null) {
        global $core;
        if(is_null($date))
            $date = strftime("%Y-%m-%d %H:%M:%S", time());
        $s = "";         $this->get_path();
        foreach($this->folderpath as $f) {
            $s .= $f->tree_id.",";
        }
        $s = "in (".rtrim($s, ",").")";
        $core->dbe->Query("update sys_tree set tree_datemodified='".$date."' where tree_id ".$s);
    }
    public function Children($published_only = false) {
        return Navigator::$cache->Children($this, $published_only);
    }
    public function Child($id, $published_only = false, $path = false) {
        $p = Navigator::$cache->Path($this->id);
        $o = Navigator::$cache->Item($p.'/'.$id);
        if(is_null($o))
            return null;
        if($published_only && !$o->tree_published)
            return null;
        $n = Navigator::InitNode($o);
        return $n;
    }
    public function ChildBy($path, $published_only = false) {
        return $this->Child($path, $published_only, true);
    }
    public function Remove() {
        $this->SetModified();
        $branch = $this->Branch();
        foreach($branch as $item)
            $item->Publications()->Clear();
        $this->Publications()->Clear();
        $this->dbt->DeleteAll($this->id);
    }
    public function SetData($data) {
        $this->published = $data->tree_published;
        $this->name = $data->tree_name;
        $this->keyword = $data->tree_keyword;
        $this->description = $data->tree_description;
        $this->template = $data->tree_template;
        $this->notes = $data->tree_notes;
        $this->properties = $data->tree_properties;
        $this->header_statictitle = $data->tree_header_statictitle;
        $this->header_inlinescripts = $data->tree_header_inlinescripts;
        $this->header_inlinestyles = $data->tree_header_inlinestyles;
        $this->header_basehref = $data->tree_header_basehref;
        $this->header_shortcuticon = $data->tree_header_shortcuticon;
        $this->header_keywords = $data->tree_header_keywords;
        $this->header_description = $data->tree_header_description;
        $this->header_aditionaltags = $data->tree_header_aditionaltags;
    }
    public function Save() {
        $data = new collection();
        $data->add("tree_published", $this->published ? 1 : 0);
        $data->add("tree_datemodified", strftime("%Y-%m-%d %H:%M:%S", time()));
        $data->add("tree_name", $this->name);
        $data->add("tree_keyword", $this->keyword);
        $data->add("tree_description", $this->description);
        $data->add("tree_template", $this->template);
        $data->add("tree_notes", $this->notes);
        $data->add("tree_properties", $this->tree_properties);
        if($this->properties instanceof FolderProperties)
            $data->add("tree_propertiesvalues", _serialize($this->properties->get_array()));
        else
            $data->add("tree_propertiesvalues", "");
        $data->add("tree_header_statictitle", $this->header_statictitle);
        $data->add("tree_header_inlinescripts", $this->header_inlinescripts);
        $data->add("tree_header_inlinestyles", $this->header_inlinestyles);
        $data->add("tree_header_basehref", $this->header_basehref);
        $data->add("tree_header_shortcuticon", $this->header_shortcuticon);
        $data->add("tree_header_keywords", $this->header_keywords);
        $data->add("tree_header_description", $this->header_description);
        $data->add("tree_header_aditionaltags", $this->header_aditionaltags);
        if($this->folder->tree_securitycache instanceof Hashtable)
            $data->Add("tree_securitycache", _serialize($this->folder->tree_securitycache));
        else
            $data->Add("tree_securitycache", $this->folder->tree_securitycache);
        $args = $this->DispatchEvent("folder.save", collection::create("folder", $this, "data", $data));
        if (@$args->cancel === true)
            return;
        else if (!is_empty(@$args->data))
                $data = $args->data;
        $this->dbt->Update($this->id, $data);
        Navigator::$cache->PrecacheTree();
        $this->SetModified();
    }
    public function InsertChild($folder) {
        $data = $folder->ToCollection();
        $data->Delete("tree_children");
        $id = $this->dbt->Insert($this->id, '', $data);
        Navigator::$cache->PrecacheTree();
        $folder->Load($id);
        $this->SetModified();
        return $folder;
    }
    public function Copy($to) { 
        $new = new Folder($this->dbt);
        $new->SetData($this->folder);
        $to->InsertChild($new);
        $childs = $this->Children();
        foreach($childs as $c) {
            if(!$c->Copy($new))
                return false;
        }
        return true;
    }
    public function MoveTo($sf) {
        if( $sf->id != $this->id && 
            !$sf->IsChildOf($this))
            $this->dbt->moveAll($this->id, $sf->id);
        else
            return false;
        return true;
    }
    public function MoveUp() {
        $p = $this->Parent();
        $c = $p->Children();
        $f1 = null;
        foreach($c as $f) {
            if($f->id == $this->id) {
                break;
            }
            $f1 = $f;
        }
        return $this->dbt->ChangePositionAll($this->id, $f1->id, 'before');
    }
    public function MoveDown() {
        $p = $this->Parent();
        $c = $p->Children();
        for($i=0; $i<$c->count();$i++) {
            if($c->item($i)->id == $this->id) {
                break;
            }
        }
        return $this->dbt->ChangePositionAll($this->id, $c->item($i+1)->id, 'after');
    }
    public function FetchPublications($storageList = null , $crit = "", $order = "", $page = -1, $pagesize = 10) {
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);
        $order = ($order != "") ? $order : "link_order";
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }
    public function Publications($criteria = "", $order = "", $page = -1, $pagesize = 10) {
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }
    public function Uri($publication = null, $args = null) {
        $site = $this->Path()->Item(0);
        $surl = $site->Url();
        $furl = $this->Url($publication, $args);
        return $surl.$furl;
    }
    public function URL($p = null, $args = null, $lang = null, $storage = null){
        global $core;
        return $core->nav->Url($this, $p, $storage, $args, $lang);
    }
    public function ToCollection() {
        $col = collection::create($this->folder->data());
        $col->delete("nflag");
        $col->add("tree_children", $this->children);
        if(@$this->folder->tree_securitycache == null)
            $this->folder->tree_securitycache = new Hashtable();
        if($this->folder->tree_securitycache instanceof Hashtable)
            $col->Add("tree_securitycache", _serialize($this->folder->tree_securitycache));
        else
            $col->Add("tree_securitycache", $this->folder->tree_securitycache);
                return $col;
    }
    public function Path() {
        $this->get_path();
        $c = new Hashtable();
        foreach ($this->folderpath as $p){
            if($p->tree_level > 0) {
                if($p->tree_level > 1)
                    $f = new Folder($this->dbt, $p);
                else if($p->tree_level == 1)
                    $f = new Site($p, null);
                $c->add($p->tree_name, $f);
            }
        }
        return $c;
    }
    public function Ajar($published_only = false, $forseLevels = 1) {
        return Navigator::$cache->Ajar($this, $published_only, $forseLevels);
    }
    public function Branch($folder = null, $published_only = false, $cond = '') {
        return Navigator::$cache->Branch($this, $published_only);
    }
    public function createSecurityBathHierarchy($suboperation) {
        $prefixFolder = "structure.folders.";
        $prefixSite = "structure.sites.";
        $operations = Folder::getOperations();
        $path = $this->Path();
        $tree = array();        
        foreach($path as $item){
            if($item instanceof Folder)
                $tree[] = array("object" => $item, "operation" => $prefixFolder.($item->name != $this->name ? "children." : "").$suboperation);
            else
                $tree[] = array("object" => $item, "operation" => $prefixSite."children.".$suboperation);
        }
                $tree = array_reverse($tree);
        return $tree;
    }
    public function Sibling(){
    }
    public function ToXML($withBranch = false){
        $ret = "\n<folder>";
        $c = $this->get_collection();
        $c->delete("tree_id");
        $c->delete("tree_left_key");
        $c->delete("tree_right_key");
        $c->delete("tree_level");
        $c->delete("tree_sid");
        $ret .= "\n".$c->ToXML();
        $args = $this->DispatchEvent("folder.toxml.processxml", collection::create("xml", $c));
        if (!is_empty(@$args->xml))
            $ret .= $args->xml;
        if ($withBranch){
            $br = $this->Branch();
            $br->delete($this->name);
            $ret .= $br->ToXML();
        }
        $ret .= "\n</folder>";
        return $ret;
    }
    public function FromXML($el, $parent){         $p = null;
        foreach ($el->childNodes as $pair){
            $args = $this->DispatchEvent("folder.fromxml.processdata", collection::create("element", $pair));
            if ($pair->tagName == "collection"){
                $c = new collection();
                $c->FromXML($pair);
                $c->FromObject(crop_object_fields($c->get_array(), "/tree_.*/i"), true);
                $args = $this->DispatchEvent("folder.fromxml.setdata", collection::create("data", $c));
                if (!is_empty(@$args->data))
                    $c = $args->data;
                $this->folder = $c->ToObject();
                $parent->InsertChild($this);
            } else {
                $p = $pair;
            }
        }
        if ($p){
            $b = new Branch(array(), $this->dbt);
            $b->FromXML($p, $this);
        }
    }
    private function get_path() {
        $this->folderpath = Navigator::$cache->Parents($this);
        if(is_null($this->folderpath)) {
            $this->folderpath = $this->dbt->Parents($this->id, '', '', 'tree_name');
            $this->folderpath->disconnect();
        }        
    }
    private function _loadProperties() {
        if(!($this->_properties instanceof FolderProperties)) {
            $this->_properties = new FolderProperties($this);
        }
    }
    public function from_xml($el, $parent) { return $this->FromXml($el, $parent); }
    public function to_xml($withBranch = false) { return $this->ToXml($withBranch); }
    public function get_collection() { return $this->ToCollection(); }
    public static function getOperations() {
        $operaions = new Operations();
        $operaions->Add(new Operation("structure.folders.delete", "Delete folder"));
        $operaions->Add(new Operation("structure.folders.edit", "Edit folder"));
        $operaions->Add(new Operation("structure.folders.changeposition", "Change the folder position"));
        $operaions->Add(new Operation("structure.folders.publications.add", "Create publications in this folder"));
        $operaions->Add(new Operation("structure.folders.publications.delete", "Remove publications from this folder"));
        $operaions->Add(new Operation("structure.folders.publications.edit", "Edit publications properties"));
        $operaions->Add(new Operation("structure.folders.publications.changeposition", "Change the publications position"));
        $operaions->Add(new Operation("structure.folders.children.add", "Add child folder"));
        $operaions->Add(new Operation("structure.folders.children.delete", "Delete children"));
        $operaions->Add(new Operation("structure.folders.children.edit", "Edit children"));
        $operaions->Add(new Operation("structure.folders.children.changeposition", "Change the child folder position"));
        $operaions->Add(new Operation("structure.folders.children.publications.add", "Create publications in child folders"));
        $operaions->Add(new Operation("structure.folders.children.publications.delete", "Remove publications from child folders"));
        $operaions->Add(new Operation("structure.folders.children.publications.edit", "Edit publications in child folders"));
        $operaions->Add(new Operation("structure.folders.children.publications.changeposition", "Change the publications position in child folders"));
        return $operaions;
    }
    public static function Create($parent, $published, $name, $description, $template = 0, $notes = "") {
        $dbt = new dbtree("sys_tree", "tree");
        $f = new Folder($dbt);
        $f->published = intval($published);
        $f->name = $name;
        $f->keyword = null;
        $f->description = $description;
        $f->template = $template;
        $f->notes = $notes;
        $f->properties = null;
        $f->header_statictitle = null;
        $f->header_inlinescripts = null;
        $f->header_inlinestyles = null;
        $f->header_basehref = null;
        $f->header_shortcuticon = null;
        $f->header_keywords = null;
        $f->header_description = null;
        $f->header_aditionaltags = null;
        $parent->InsertChild($f);
        return $f;
    }
}
class Branch extends Collection {
    public $dbt;
    public function __construct($parent = null, $dbt = null){
        parent::__construct();
        $this->dbt = $dbt;
        if(!is_null($parent)) {
            $this->Merge($parent->Branch()->ToArray());
        }
    }
    public function FetchPublications($storageList = array() , $crit = "", $order = "", $page = -1, $pagesize = 10){
        return Publications::FetchPublications($this, $storageList, $crit, $order, $page, $pagesize);
    }
    public function ToXml($levelTag = "folders", $itemTag = "folder", $itemCallback = null, $params = array()){
        $count = $this->Count();
        if ($count == 0)
            return;
        $attrs = " ";
        foreach($params as $k => $v) {
            $attrs .= $k.'="'.$v.'"';
        }
        $ret = "\n<".$levelTag.$attrs.">";
        $parents = new ArrayList();
        foreach ($this as $folder){
            if($parents->Count() == 0)
                $parents->Add($folder);
            else if($folder->level > $parents->Last()->level) {
                $parents->Add($folder);
                $ret .= "\n<".$levelTag.">";
            } else if($folder->level < $parents->Last()->level) {
                while($folder->level < $parents->Last()->level) {
                    $ret .= "\n</".$itemTag."></".$levelTag.">";
                    $parents->Delete($parents->Count() - 1);
                }
                $ret .= "</".$itemTag.">";
            } else {
                $parents->Delete($parents->Count() - 1);
                $parents->Add($folder);
                $ret .= "\n</".$itemTag.">";
            }
            $ret .= "\n<".$itemTag.">";
            $c = $folder->ToCollection();
            if(is_null($itemCallback)) {
                $c->delete("tree_id");
                $c->delete("tree_left_key");
                $c->delete("tree_right_key");
                $c->delete("tree_level");
                $c->delete("tree_sid");
                $ret .= $c->ToXML();
            }
            else {
                $ret .= $itemCallback($folder);
            }
        }
        $parents->Delete($parents->Count() - 1);
        while($parents->Count() > 0) {
            $parents->Delete($parents->Count() - 1);
            $ret .= "\n</".$itemTag.">\n</".$levelTag.">";
        }
        $ret .= "\n</".$itemTag.">";
        $ret .= "\n</".$levelTag.">";
        return $ret;
    }
    public function FromXML($el, $parent){         $this->Add($parent->name, $parent);
        foreach($el->childNodes as $pair) {
            $args = $this->DispatchEvent("branch.from_xml.processdata", collection::create("element", $pair));
            if ($pair->tagName == "folder"){
                $f = new Folder($this->dbt, null);
                $f->from_xml($pair, $parent);
                $this->Add($f->name, $f);
            }
        }
    }
    function SubBranch($parent) {
        $newBranch = new Branch();
        $index = $this->IndexOf($parent->id, "id");
        $newBranch->Add($parent->name, $parent);
        $i = $index;
        do {
            $tmp = $this->Item($this->Key(++$i));
            if(!is_null($tmp)) {
                if($tmp->level <= $parent->level)
                    break;
                $newBranch->Add($tmp->name, $tmp);
            }
        } while (!is_null($tmp));
        return $newBranch;
    }
    function NextSible($item) {
        $index = $this->IndexOf($item->id, "id");
        $i = $index;
        do {
            $tmp = $this->Item($this->Key(++$i));
            if(!is_null($tmp)) {
                if($tmp->level < $item->level) {
                    return null;
                }
                else if($tmp->level == $item->level) {
                    return $tmp;
                }
            }
        } while (!is_null($tmp));
        return null;
    }
        public function from_xml($el, $parent){ $this->FromXML($el, $parent); }
        public function to_xml(){ $this->ToXML(); }
}
class Site extends IEventDispatcher  {
    public $dbt;
    public $domain = "";
    public $site_id = -1;
    public $sNode = null;
    private $tree_children = -1;
    public $folder = null;
    public $error = false;
    private $_properties;
    public function __construct($dns = null, $folder = null) {
        $this->dbt = new dbtree("sys_tree", "tree");
        $this->sNode = new Object();
        if(!is_null($dns)) {
            $this->Load($dns, $folder);
        }
        $this->RegisterEvent("site.save");
    }
    public function Load($dns, $folder = null) {
        global $core;
        if(is_object($dns))    {
            $this->domain = $dns->tree_domain;
            $this->sNode = $dns;
            $this->site_id = $dns->tree_id;
        }
        else {
            if(is_numeric($dns))
                $q = "select sys_tree.* from sys_tree where sys_tree.tree_id = '".$dns."'";
            else
                $q = "select sys_tree.* from sys_tree where sys_tree.tree_domain = '".$dns."'";
            $query = $core->dbe->ExecuteReader($q);
            if( $query->count() > 0 ) {
                $this->site_id = $query->Read()->tree_id;
                $this->sNode = $this->dbt->getNode($this->site_id);
                $this->domain = $dns;
                $this->error = false;
            }
            else {
                $this->error = true;
            }
        }
        $this->tree_children = -1;
        $this->LoadFolder($folder);
    }
    public function LoadFolder($folder = null) {
        $this->folder = null;
        if(!is_null($folder)) {
            if(!is_object($folder)) {
                if(is_numeric($folder))
                    $folder = Site::Fetch($folder)->name;
                $branch = @$this->Branch();
                $this->folder = @$branch->$folder;             }
            else 
                $this->folder = $folder;
        }                   
    }
    public function SetModified($date = null) {
        global $core;
        if(is_null($date))
            $date = strftime("%Y-%m-%d %H:%M:%S", time());
        $core->dbe->Query("update sys_tree set tree_datemodified='".$date."' where tree_id  = '".$this->id."'");
    }
    public function IsChildOf($f){
        return false;
    }
    public function MoveTo($sf) {
        if( $sf->id != $this->id && 
            !$sf->IsChildOf($this))
            $this->dbt->moveAll($this->id, $sf->id);
        else
            return false;
        return true;
    }
    public function MoveUp() {
        $c = Site::EnumSites(BYNAME);         $f1 = null;
        foreach($c as $f) {
            if($f->id == $this->id) {
                break;
            }
            $f1 = $f;
        }
        return $this->dbt->ChangePositionAll($this->id, $f1->id, 'before');
    }
    public function MoveDown() {
        $c = Site::EnumSites(BYNAME);         for($i=0; $i<$c->count();$i++) {
            if($c->item($i)->id == $this->id) {
                break;
            }
        }
        return $this->dbt->ChangePositionAll($this->id, $c->item($i+1)->id, 'after');
    }
    public function ToCollection() {
        $col = collection::create($this->sNode->data());
        $col->add("tree_children", $this->tree_children);
        return $col;
    }
    public function __get($field) {
        if(is_null($this->sNode))
            return null;
        $args = $this->DispatchEvent("site.property.get", Hashtable::Create("field", $field, "data", $this->sNode));
        if(@$args->cancel === true) {
            return @$args->value;
        }
        if($field == "children") {
            if($this->tree_children < 0)
                $this->tree_children = $this->Children()->Count();             return $this->tree_children;
        }
        if($field == "properties") {
            $this->_loadProperties();
            return $this->_properties;
        }
        if($field == "tree_properties") {
            return $this->sNode->tree_properties;
        }
        $nm = $field;
        if(strpos($nm, 'tree_') === false)
            $nm = "tree_".strtolower($nm);
        $vars = $this->sNode->ToArray();
        if(array_key_exists($nm, $vars)) {
            if($nm == "tree_securitycache") {
                if(!($this->sNode->$nm instanceof Hashtable)) {                     $this->sNode->$nm = @_unserialize($this->sNode->$nm);
                    if($this->sNode->$nm === false || is_null($this->sNode->$nm))
                        $this->sNode->$nm = new Hashtable();    
                    return $this->sNode->$nm;
                }
                else 
                    return $this->sNode->$nm;
            }
            else
                return $this->sNode->$nm;
            return $this->sNode->$nm;
        }
        else {
            $this->_loadProperties();
            $prop = $this->_properties->$field;
            if($prop){
                if($prop->type == "blob") {
                    global $core;
                    return new Blob(intval(@$prop->value));
                }
                else {
                    return @$prop->value;
                }
            }
            return null;
        }
    }
    public function __set($field, $value) {
        $this->_loadProperties();
        $args = $this->DispatchEvent("site.property.set", Hashtable::Create("field", $field, "value", $value, "data", $this->sNode));
        if(@$args->cancel === true) {
            return;
        }
        if($this->_properties->Exists($field))
            $this->_properties->$field->value = $value;    
        else {
            $nm = "tree_".$field;
            $this->sNode->$nm = $value;
        }
    }
    public function Render($designName = null) {
        global $gpublication;
        global $glanguage;
        if(is_null($this->sNode))
            return null;
        if(!is_null($designName))
            $tname = $designName;
        else {
            if(!is_null($this->folder))
                $tname = $this->folder->actualTemplate();
            else
                $tname = $this->sNode->tree_template;
        }
        $f = $this->folder;
        if(is_null($f))
            $f = $this;
        $pub = null;
        if(!is_null($gpublication))
            $pub = new Publication($gpublication);
        return designTemplates::apply($tname, collection::create("dbt", $this->dbt, "site", $this, "folder", $f, "language", $glanguage, "publication", $pub));
    }
    public function Children($published_only = false) {
        return Navigator::$cache->Children($this, $published_only);
    }
    public function Child($id, $published_only = false, $path = false) {
        $p = Navigator::$cache->Path($this->id);
        $o = Navigator::$cache->Item($p.'/'.$id);
        if(is_null($o))
            return null;
        if($published_only && $o->tree_published != 1)
            return null;
        return Navigator::InitNode($o);
    }
    public function ChildBy($path, $published_only = false) {
        return $this->Child($path, $published_only, true);
    }
    public function Remove() {
        $branch = $this->Branch();
        foreach($branch as $item)
            $item->Publications()->Clear();
        $this->Publications()->Clear();
        $this->SetModified();
        $this->dbt->DeleteAll($this->id);
        Navigator::$cache->PrecacheTree();
    }
    public function SetData($data) {
        $this->published = $data->tree_published;
        $this->name = $data->tree_name;
        $this->domain = $data->tree_domain;
        $this->description = $data->tree_description;
        $this->language = $data->tree_language;
        $this->template = $data->tree_template;
        $this->properties = $data->tree_properties;
        $this->header_statictitle = $data->tree_header_statictitle;
        $this->header_inlinescripts = $data->tree_header_inlinescripts;
        $this->header_inlinestyles = $data->tree_header_inlinestyles;
        $this->header_basehref = $data->tree_header_basehref;
        $this->header_shortcuticon = $data->tree_header_shortcuticon;
        $this->header_keywords = $data->tree_header_keywords;
        $this->header_description = $data->tree_header_description;
        $this->header_aditionaltags = $data->tree_header_aditionaltags;
    }
    public function Save() {
        $data = new collection();
        $data->add("tree_published", $this->published ? 1 : 0);
        $data->add("tree_datemodified", strftime("%Y-%m-%d %H:%M:%S", time()));
        $data->add("tree_name", $this->name);
        $data->add("tree_domain", $this->domain);
        $data->add("tree_description", $this->description);
        $data->add("tree_language", $this->language);
        $data->add("tree_template", $this->template);
        $data->add("tree_properties", $this->tree_properties);
        $data->add("tree_notes", $this->notes);
        if($this->properties instanceof FolderProperties)
            $data->add("tree_propertiesvalues", _serialize($this->properties->get_array()));
        else
            $data->add("tree_propertiesvalues", "");
        $data->add("tree_header_statictitle", $this->header_statictitle);
        $data->add("tree_header_inlinescripts", $this->header_inlinescripts);
        $data->add("tree_header_inlinestyles", $this->header_inlinestyles);
        $data->add("tree_header_basehref", $this->header_basehref);
        $data->add("tree_header_shortcuticon", $this->header_shortcuticon);
        $data->add("tree_header_keywords", $this->header_keywords);
        $data->add("tree_header_description", $this->header_description);
        $data->add("tree_header_aditionaltags", $this->header_aditionaltags);
        if(!isset($this->sNode->tree_securitycache))
            $data->Add("tree_securitycache", "");
        else
            if($this->sNode->tree_securitycache instanceof Hashtable)
                $data->Add("tree_securitycache", _serialize($this->sNode->tree_securitycache));
            else
                $data->Add("tree_securitycache", $this->sNode->tree_securitycache);        
        $args = $this->DispatchEvent("site.save", collection::create("site", $this, "data", $data));
        if (@$args->cancel === true)
            return;
        else if (!is_empty(@$args->data))
                $data = $args->data;
        if(is_null($this->id)) {
            $root = Site::FetchRoot();
            $id = $this->dbt->Insert($root->tree_id, '', $data);
            $this->Load($id);
        }
        else
            $this->dbt->Update($this->id, $data);
        Navigator::$cache->PrecacheTree();
    }
    public function InsertChild($folder) {
        $data = $folder->tocollection();
        $data->Delete("tree_children");
        $id = $this->dbt->Insert($this->id, '', $data);
        Navigator::$cache->PrecacheTree();
        $folder->Load($id);
        $folder->SetModified();
        return $folder;
    }
    public function FetchPublications($storageList = null , $crit = "", $order = "", $page = -1, $pagesize = 10) {
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);
        $order = ($order != "") ? $order : "link_order";
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }
    public function Publications($criteria = "", $order = "" ,$page = -1, $pagesize = 10) {
        return new Publications($this, $criteria, $order, $page, $pagesize);
    }
    public function Uri($folder = null, $publication = null, $args = null) {
        $surl = $this->Url();
        $furl = '';
        if(!is_null($folder))
            $furl = $folder->Url($publication, $args);
        return $surl.$furl;
    }
    public function URL($p = null, $args = null, $lang = null, $storage = null) {
        global $core;
        return $core->nav->Url($this, $p, $storage, $args, $lang);
    }
    public function Ajar($published_only = false, $forseLevels = 1) {
        return Navigator::$cache->Ajar($this, $published_only, $forseLevels);
    }
    public function Branch($folder = null, $published_only = false, $cond = '') {
        return Navigator::$cache->Branch($this, $published_only);
        $ret = new Branch();
        $condition = '';
        if(!is_null($folder)) {
            if(is_numeric($folder))
                $condition = array("and" => array("tree_id = '".$folder."'"));
            else
                $condition = array("and" => array("tree_name = '".$folder."'"));
        }
        else if($published_only) {
            $condition = array("and" => array("(SELECT count(distinct E.tree_published) FROM sys_tree E, sys_tree F  WHERE  F.tree_id = A.tree_id and E.tree_published=0 AND F.tree_left_key  BETWEEN E.tree_left_key AND E.tree_right_key) = 0"));
        }
        if(!is_empty($cond)) {
            if(!is_empty($condition))
                $condition['and'][] = $cond;
            else
                $condition = array("and" => array($cond));
        }
        $ajr = $this->dbt->Branch($this->sNode->tree_id, '', $condition);
        while($aj = $ajr->FetchNext()) {
            if($aj->tree_level == 1)
                $obj = new Site($aj, null);
            else
                $obj = new Folder($this->dbt, $aj);
            $ret->add($aj->tree_name, $obj);
        }
        return $ret;
    }
    public function createSecurityBathHierarchy($suboperation) {
        return array(array("object" => $this, "operation" => "structure.sites.".$suboperation));
    }
    public function ToXML($withBranch = false){
        $ret = "\n<site>";
        $c = $this->get_collection();
        $c->delete("tree_id");
        $c->delete("tree_left_key");
        $c->delete("tree_right_key");
        $c->delete("tree_level");
        $c->delete("tree_sid");
        $ret .= "\n".$c->ToXML();
        $args = $this->DispatchEvent("site.toxml.processxml", collection::create("xml", $c));
        if (!is_empty(@$args->xml))
            $ret .= $args->xml;
        if ($withBranch){
            $br = $this->Branch();
            $br->delete($this->name);
            $ret .= $br->ToXML();
        }
        $ret .= "\n</site>";
        return $ret;
    }
    public function FromXML($el){         $p = null;
        foreach ($el->childNodes as $pair){
            $args = $this->DispatchEvent("site.from_xml.processdata", collection::create("element", $pair));
            if ($pair->tagName == "collection"){
                $c = new Collection();
                $c->from_xml($pair);
                $args = $this->DispatchEvent("site.from_xml.setdata", collection::create("data", $c));
                if (!is_empty(@$args->data))
                    $c = $args->data;
                $this->sNode = $c->to_object();
                $this->Save();
            } else {
                $p = $pair;
            }
        }
        if ($p){
            $b = new Branch(array(), $this->dbt);
            $b->from_xml($p, $this);
        }
    }
    private function _loadProperties() {
        if(!($this->_properties instanceof FolderProperties))
            $this->_properties = new FolderProperties($this);
    }
    public static function FetchRoot() {
        $dbt = new dbtree("sys_tree", "tree");
        $root = $dbt->GetRootNode();
        return $root;
    }
    public static function FetchSite($name) {
        return Navigator::InitNode(Navigator::$cache->Item($name));
        global $core;                                                         
        $dtr = $core->dbe->ExecuteReader("select * from sys_tree where tree_name='".$name."' order by tree_level");
        $rr = $dtr->Read();
        if($rr) {             
            if($rr->tree_level == 1) {
                return new Site($rr);
            }       
        }
        return null;
    }
    public static function Fetch($id, $in_branch = null) {
        global $site, $MULTISITE;
        $dbt = new dbtree("sys_tree", "tree");
        $rr = false;
        if(is_numeric($id)) {
            $rr = Navigator::$cache->Item($id);
        }
        else if( is_string($id) ) {
            $ret = Navigator::$cache->ByName($id);
            $rr = $ret->First();
        }
        else if(is_object($id))
            $rr = $id;
        return Navigator::InitNode($rr);
    }
    public static function EnumSites($t = BYNAME) {
        return Navigator::$cache->Sites($t);
    }
    public static function EnumTree($published_only = false) {
        return Navigator::$cache->Nodes($published_only);
    }
    public static function FolderExists($folder, $in_branch = null) {
        global $core;
        if(is_null($in_branch)) {
            return $core->dbe->exists(sys_table("tree"), ( is_numeric($folder) ? "tree_id" : "tree_name"), $folder);
        }
        else {
            if(is_numeric($folder)) {
                $folder = Site::Fetch($folder);
                if(is_null($folder))
                    return false;
                return $folder->IsChildOf($in_branch);
            }
            else {
                if(!is_object($in_branch))
                    $in_branch = Site::Fetch($in_branch);
                $in_branch = $in_branch->Branch($folder);
                return $in_branch->Count() > 0;
            }    
        }
    }
    public static function getOperations() {
        $operaions = new Operations();
        $operaions->Add(new Operation("structure.sites.add", "Add site"));
        $operaions->Add(new Operation("structure.sites.delete", "Delete site"));
        $operaions->Add(new Operation("structure.sites.edit", "Edit site properties"));
        $operaions->Add(new Operation("structure.sites.children.add", "Add children"));
        $operaions->Add(new Operation("structure.sites.children.delete", "Delete children"));
        $operaions->Add(new Operation("structure.sites.children.edit", "Edit children"));
        $operaions->Add(new Operation("structure.sites.publish", "Publish the entire site"));
        $operaions->Add(new Operation("structure.sites.unpublish", "Unpublish the entire site"));
        return $operaions;
    }
    public static function Create($published, $name, $domain, $description, $language, $template, $notes = "") {
        $site = new Site();
        $site->published = intval($published);
        $site->name = $name;
        $site->domain = $domain;
        $site->description = $description;
        $site->language = $language;
        $site->template = $template;
        $site->notes = $notes;
        $site->properties = null;
        $site->header_statictitle = null;
        $site->header_inlinescripts = null;
        $site->header_inlinestyles = null;
        $site->header_basehref = null;
        $site->header_shortcuticon = null;
        $site->header_keywords = null;
        $site->header_description = null;
        $site->header_aditionaltags = null;
        $site->Save();   
        return $site; 
    }
        public function to_xml($withBranch = false){ return $this->ToXML($withBranch); }
    public function from_xml($el){ $this->FromXML($el); }
        public function get_collection() { return $this->ToCollection(); }
}
?>
<?php
class MultilinkField {
	private $storage;
	private $ids; 	private $datarows;
	private $criteria;
	private $tmpTable;
	public function __construct($storage, $ids) {
		$this->storage = $storage;
		$this->ids = new arraylist($ids);
		$this->datarows = null;
		$this->criteria = "";
	}
	public function __destruct(){
	}
	public function Clear(){
		if ($this->ids)
			$this->ids->Clear();
		if ($this->datarows)
			$this->datarows->Clear();
	}
	public function Count(){
		return $this->ids->Count();
	}
	public function Rows($fields = "", $condition = "", $order = "", $page = -1, $pagesize = 10) {
		global $core;
		if(is_empty($this->Values()))
			return new DataRows($this->storage, null);
		$crit = md5($fields."|".$condition."|".$order."|".$page."|".$pagesize);
		if($crit != $this->criteria) {
			$this->criteria = $crit;
			$filter = $this->storage->fname("id")." in (".$this->Values().")";
			if($condition != "")
				$filter .= " and (".$condition.")";
			$this->tmpTable = to_lower("tmp".str_random(20));
			$values = $this->ids->get_array();
			$tmpTableValues = explode(";", "insert into ".$this->tmpTable." (".$this->tmpTable."_id) "."values('".implode("'); insert into ".$this->tmpTable." (".$this->tmpTable."_id) values('", $values)."')");
            $core->dbe->CreateTable($this->tmpTable, array(
                $this->tmpTable."_order" => array("type" => "autoincrement", "additional" => "NOT NULL"),
                $this->tmpTable."_id" => array("type" => "bigint", "additional" => "NOT NULL")
            ), array(
                $this->tmpTable.'_id' => array('fields' => $this->tmpTable.'_order','constraint' => 'PRIMARY KEY')
            ), '', false);
			foreach($tmpTableValues as $q) {
				$core->dbe->query($q);
			}
			$reader = $core->dbe->ExecuteReader("select *".($fields != "" ? ", ".$fields : "").
				" from ".$this->storage->table." inner join ".$this->tmpTable." on ".$this->tmpTable."_id = ".$this->storage->table."_id ".
				($filter != "" ? " where ".$filter : "").
				($order != "" ? " order by ".$order : " order by ".$this->tmpTable."_order"), 
			$page, $pagesize);
            $core->dbe->DropTable($this->tmpTable);
			$this->datarows = new DataRows($this->storage, $reader);
			$this->datarows->pagesize = $pagesize;
		} else {
            out('datarows->rewind called', debug_backtrace());
					}
		return $this->datarows;
	}
	public function Storage() {
		return $this->storage;
	}
	public function Ids(){
		return $this->ids;
	}
	public function Fill($data){
		$this->ids->Append($data);
	}
	public function Values() {
		return implode(",", $this->ids->get_array());
	}
	public function Add($data) {
		if(!($data instanceof DataRow)) {
			if(is_numeric($data)) {
				$this->ids->Add($data);
			}
		}
		else {
			$this->ids->Add($data->id);
		}
		$this->criteria = "";
	}
	public function Remove($data) {
		if($data instanceOf DataRow) {
			$index = $this->ids->IndexOf($data->id);
			$this->ids->Delete($index);
		}
		else {
			if(is_numeric($data)) {
				$index = $this->ids->IndexOf($data, false);
				$this->ids->Delete($index);
			}
			else {
				return false;
			}
		}
		$this->criteria = "";
		return true;
	}
	public function ToXML() {
		return $this->Rows()->ToXML();
	}
	public function FromXML($el){
		$drs = new DataRows($this->storage);
		$drs->from_xml($el);
		$this->datarows = $drs;
		while ($dr = $drs->FetchNext())
			$this->add($dr);
	}
    public function ToString() {
        return $this->Values();
    }
	public function from_xml($el){ $this->FromXML($el); }
	public function to_xml(){ return $this->ToXML(); }
}
class DataRow extends Object {
	public $storage;
	public function __construct($storage, $dt = null) {
		global $core;
		$this->RegisterEvent("datarow.save");
		$this->RegisterEvent("datarow.saving");
		$this->RegisterEvent("datarow.delete");
		$this->RegisterEvent("datarow.deleted");
		$this->RegisterEvent("datarow.loading");
		$this->RegisterEvent("datarow.loaded");		
		$this->RegisterEvent("datarow.settyped");
		$this->RegisterEvent("datarow.dotypeexchange");
		$this->RegisterEvent("datarow.dotypeexchanged");
		$this->RegisterEvent("datarow.out");
		if(is_string($storage))
			$storage = new storage($storage);
		if(!$storage->isValid) { 
            iout(debug_backtrace());
            die("Error storage is not valid!"); 
        }
		$args = $this->DispatchEvent("datarow.loading", hashtable::create("data", $dt, "storage", $storage));
		if (@$args->cancel === true)
			return parent::__construct(null, $storage->table."_");
		else 
			$dt = !is_empty(@$args->data) ? $args->data : $dt;
		$this->storage = $storage;
        if(!is_null($dt)) {
		    if(is_numeric($dt)) {
			    $r = $core->dbe->ExecuteReader("select * from ".$storage->table." where ".$storage->fname("id")."='".$dt."'");
			    $dt = $r->Read();
		    }
        }
		$args = $this->DispatchEvent("datarow.loaded", collection::create("data", $dt));
		if (!is_empty(@$args->data)) $dt = $args->data;
		parent::__construct($dt, $storage->table."_");
	}
	public function isValid() {
				return true;
	}
	public function Defaults() {
		global $core;
		$dtrs = new DataRows($this->storage);
		$this->_data = $dtrs->EmptyRow(true);
	}
	public function Fill($obj) {
		if(!is_null($obj)) {
			foreach($this->storage->fields as $k => $field) {
				$f = $this->fname($field->field);
				if(!is_object($obj->$f) && $obj->$f == "{null}")
					@$this->$f = null;
				else
					@$this->$f = $obj->$f;
			}
		}
	}
	public function GetMultiFields() {
		$fs = new arraylist();
		foreach($this->storage->fields as $k => $field)
			if($field->isMultilink) 
				$fs->add($field);
		return $fs;		
	}
	public function Out($template = TEMPLATE_DEFAULT, $user_params = null, $operation = OPERATION_ITEM) {
		$t = template::create($template, $this->storage);
		$args = $this->DispatchEvent("datarow.out", collection::create("template", $t, "operation", $operation, 
			"user_params", $user_params, "data", $this->_data, "storage", $this->storage));
		if (@$args->cancel === true)
			return;
		else if (!is_empty(@$args->template))
				$t = $args->template;
		else if (!is_empty(@$args->operation))
				$operation = $args->operation;
		else if (!is_empty(@$args->user_params))
				$user_params = $args->user_params;
		else if (!is_empty(@$args->data))
				$this->_data = $args->data;
		return $t->Out($operation, $this, $user_params);
	}
	public function GetLookup($fname){
		$field = $this->storage->fields->$fname;
        if(!$field)
            return null;
		$lookup = $field->SplitLookup();
		if (!$lookup)
			return $this->$fname;
		else {
			$table = $lookup->table;
			$idfield = $lookup->id;
			$fname = $this->fname($fname);
            $data = $this;
            $condition = $lookup->condition;
            eval('$condition = "'.$condition.'";');
			if(Storages::IsExists($table)) {
				$s = new Storage($table);	
				$drs = new DataRows($s);
                if(is_empty(@$this->_data->$fname)) 
                    return null;
				$drs->Load("", $idfield." = '".@$this->_data->$fname."'".(is_empty($condition) ? '' : ' and '.$condition));
				return $drs->FetchNext();
			}
			else {
				global $core;
				$rs = $core->dbe->ExecuteReader("select * from ".$table." where ".$idfield." = '".$this->_data->$fname."'".(is_empty($condition) ? '' : ' and '.$condition));
				return $rs->Read();
			}
		}
	}
	public function Delete() {
		global $core;
		$args = $this->DispatchEvent("datarow.deleting", collection::create("datarow", $this, "data", $this->_data));
		if (@$args->cancel === true)
			return;
		else if (!is_empty(@$args->data))
				$this->_data = $args->data;
		Publications::ClearDataLinks($this->storage->id, $this->id);
		$core->dbe->delete($this->storage->table, $this->fname("id"), $this->id);
		$args = $this->DispatchEvent("datarow.deleted", collection::create("data", $this->_data));
	}
	public function Copy() {
		$data = $this->ToCollection();
		$dt = new DataRow($this->storage, null);
		$dt->Defaults();
		foreach($data as $name => $value) {
			$name = $this->fromfname($name);
			if($name != "id" && $name != "datecreated") {
				$dt->$name = $value;
			}
		}
		$dt->Save();
		return $dt;
	}
	public function Save() {
		global $core;
		$args = $this->DispatchEvent("datarow.saving", collection::create("data", $this->_data));
		if (@$args->cancel === true)
			return;
		else if (!is_empty(@$args->data))
			$this->_data = $args->data;
		$idf = $this->fname("id");
		$id = $this->id;
		$data = $this->ToCollection();
		foreach ($data as $k => $v){
			$kk = $this->storage->fromfname($k);
			$field = $this->storage->fields->$kk;
			if(!is_null($field)) {
				$type = strtolower($field->type);
				if($type == "blob") {
					if($v instanceof Blob)
						$data->$k = $v->id;
					elseif(!is_numeric($v)) {
						$data->$k = 0;
					}
                } else if ($type == "file"){
                    if ($v instanceof FileView)
                        $data->$k = $v->ToString();
				} else if ($type == "file list"){
                    if ($v instanceof FileList)
                        $data->$k = $v->ToString();
                } else if ($type == "blob list"){
                    if ($v instanceof BlobList)
                        $data->$k = $v->ToString();
                } 
				else if ($type == "text" || $type == "memo" || $type == "html") {
					if(!is_object($v))
						$data->$k = str_replace("\r\n", "\n", $v);
					else
						$data->$k = $v;
				} else if ($type == "datetime"){
					if (is_empty($v))
						$v = time();
					$data->$k = is_numeric($v) ? db_datetime($v) : $v;
				} else if ($type == "bigdate"){
					if (is_empty($v))
						$v = time();
					$data->$k = is_numeric($v) ? $v : strtotime($v);
				} else if ($type == "numeric"){
					if (is_null($v)) {
						if(!is_null($field->default))
							$v = $field->default;
						else
							$v = null;
					}
                    if($v == "")
                        $v = $field->required ? 0 : null;
                    $data->$k = $v;
				} 
				if($field->isMultilink && $type == "memo" && $v instanceof MultilinkField) {
					$data->$k = $v->Values();
				}
                if($field->isLookup && $type == "numeric" && $v instanceof DataRow) {
                    $data->$k = $v->id;
                }
            }
		}
		$data->Delete($idf);
		if(is_null($id) || $id <= 0) {
			$this->_data->$idf = $core->dbe->insert($this->storage->table, $data);
		}
		else {
            $core->dbe->set($this->storage->table, $idf, $id, $data);
		}
		$pubs = $this->Publications();
		foreach($pubs as $pub) {
			$pub->SetModified();
		}
		$args = $this->DispatchEvent("datarow.save", collection::create("storage", $this->storage, "data", $this->_data));
		if (!is_empty(@$args->data))
			$this->_data = $args->data;
	}
	public function Publications(){
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_links where link_child_storage_id=".$this->storage->id." and link_child_id=".$this->id." order by link_order");
		if($r) {
			$ret = new ArrayList();
			while($rr = $r->Read()) {
				$ret->add(new Publication($rr, $this));
			}
			return $ret;
		}
		else
			return false;
	}
    public function URL($s, $args = null){
        if(is_null($s)) {
            return false;
        }
        return $s->URL(null, $args, null, array($this->storage->table, $this->id));
    }
	public function ToXML() {
		$ret = "<row>";
		$data = $this->ToArray();
		foreach ($data as $k => $v){
			$fname = $this->storage->fromfname($k);
			$l = $this->GetLookup($fname);
			if ($l instanceof DataRow){
				$ret .= "<".$k.">".$l->ToXML()."</".$k.">";
			} else {
				if (is_object($l))
					$ret .= "<".$k.">".$l->ToXML()."</".$k.">";
				else {
					$ret .= "<".$k."><![CDATA[".$l."]]></".$k.">";
				}
			}
		}
		$ret .= "</row>";
		return $ret;
	}
	public function FromXML($el){
	    static $rows = array();
	    foreach($el->childNodes as $pair) {
			$name = $pair->nodeName;
						if ($pair->firstChild->nodeType != 1){ 				$value = $pair->nodeValue;
			} else {
				$item = $pair->firstChild;
				if ($item->nodeType == 1){ 					$nm = $this->storage->fromfname($name);
					$field = $this->storage->fields->$nm;
					if ($field->type == "blob"){
						$b = new blob();
						$b->from_xml($item);
						$value = $b->id;
					} else if ($field->onetomany != "" && $field->onetomany != "0") {
						$mlf = new MultilinkField(storages::get($field->onetomany), null);
						$mlf->from_xml($item);
						$value = $mlf->Values();
					} else if ($field->lookup != "") {
						$inf = explode(":", $field->lookup);
						if (count($inf) > 0){
							$idf = $inf[2];
							$dr = new DataRow(storages::get($inf[0]), null);
							$dr->from_xml($item);
							$vls = array();
							foreach ($dr->storage->fields as $field){
								$fname = $field->field;
								$vv = $dr->$fname;
								if(is_object($vv)) {
									if ($vv instanceof MultilinkField){
										$vv = $vv->Values();
									} else 
										$vv = $vv->id;
								}
								$vls[] = $dr->storage->fname($fname)." = '".addslashes(str_replace("\r\n", "\n", $vv))."'";
							}
							$tdrs = new DataRows($dr->storage);
							$tdrs->Load("", implode(" and ", $vls));
							unset($vls);
							if ($tdrs->Count() > 0){
																$value = $tdrs->FetchNext()->$idf;
							} else {
								$dr->Save();
								$value = $dr->$idf;
							}
						}
					}
				}
			}
			$this->$name = $value;
	    }
	    	    unset($this->id);
	}
	public function ToCreateScript($objectname, $proplist = array(), $exclude = array(), $newparams = array(), $class = null) {
		$o = new Object($this->_data, $this->storage->table."_");
		$exclude[] = "id";
		$exclude[] = "datecreated";
		return $o->ToCreateScript($objectname, $proplist, $exclude, $newparams, "DataRow");
	}
	protected function TypeExchange($fieldname , $mode = TYPEEXCHANGE_MODE_GET, $setValue = null) { 		
		$rowValue = $mode == TYPEEXCHANGE_MODE_GET ? @$this->_data->$fieldname : $setValue;
		$fname = $this->fromfname($fieldname);
		$field = $this->storage->fields->$fname;
		if($mode == TYPEEXCHANGE_MODE_GET) {
			$args = $this->DispatchEvent("datarow.dotypeexchange", Hashtable::Create("field", $fieldname, "value", $rowValue, "data", $this->_data));
			if (@$args->cancel === true)
				return @$args->value;
			else if (!is_null(@$args->data)) 				$this->_data = $args->data;
		}
		else {
			if(!is_null($field)) {
				$args = $this->DispatchEvent("datarow.settyped", Hashtable::Create("field", $field, "value", $rowValue, "data", $this->_data));
				if (@$args->cancel === true)
					return;
				else if (!is_empty(@$args->data))
					$this->_data = $args->data;
			}
		}
		if(is_null($field)) {
			if($mode == TYPEEXCHANGE_MODE_GET)
				return $rowValue;
			else {
				$this->_data->$fieldname = $rowValue;
				return;
			}
		}
		$value = null;
		if($mode == TYPEEXCHANGE_MODE_GET) {
			if($field->isMultilink && !($rowValue instanceof MultilinkField)) {
				$onetomany = $field->onetomany;
				if(Storages::IsExists($onetomany)) {
					$storage = new Storage($onetomany);
					$value = new MultilinkField($storage, $rowValue);
					$this->_data->$fieldname = $value;
					return $value;
				}
				else {
					return $rowValue;
				}
			}
			if($field->isLookup && $field->type != "multiselect") {
				return $this->GetLookup($field->field);
			}
            if($field->type == "multiselect") {
                if(!is_empty($rowValue)) {
                    if($field->isLookup) {
                        $lookup = $field->SplitLookup();
                        $query = (!is_empty($lookup->query)) ? $lookup->query : "SELECT ".$lookup->fields." FROM ".$lookup->table." where ".$lookup->id." in (".$rowValue.")";
                        global $core;
                        $r = $core->dbe->ExecuteReader($query);
                        $vvvs = "";
                        $col = new Collection();
                        while($row = $r->Read()) {
                            $show  = $lookup->show;
                            $id = $lookup->id;
                            $col->Add($row->$id, $row->$show);
                        }
                        return $col;
                    }
                    else {
                        $vv = new ArrayList();
                        $vv->FromString($rowValue);
                        $values = $field->GetValues()->ToArray();
                        $col = new Collection();
                        foreach($values as $k => $v) {
                            if($vv->IndexOf($k, false) !== false)
                                $col->Add($k, $v);
                        }
                        return $col;
                    }
                }
                else
                    return new Collection();
            }
		}
		switch(strtoupper($field->type)) {
			case "TEXT":
			case "MEMO":
			case "HTML":
				if($mode == TYPEEXCHANGE_MODE_GET) {
					if(!($rowValue instanceof MultilinkField) && !defined("MODE_ADMIN"))
						@eval(convert_php(load_from_file($rowValue), "\$value"));
					else
						$value = $rowValue;
				}
				else {
					if($field->isMultilink && strtoupper($field->type) == "MEMO") {
						if($rowValue instanceof MultilinkField)
							@$this->_data->$fieldname = $rowValue;
						else if(is_string($rowValue))
							@$this->_data->$fieldname = new MultilinkField($this->storage, $rowValue);
					}
					else
						@$this->_data->$fieldname = $rowValue;
				}
				break;
			case "CHECK":
			case "NUMERIC":
				if($mode == TYPEEXCHANGE_MODE_GET) {
					$value = $rowValue == ""  ? "" : ($rowValue == (int)$rowValue ? (int)$rowValue : $rowValue);
                }
				else
					$this->_data->$fieldname = $field->required ? ($rowValue == "" ? 0 : $rowValue) : ($rowValue=="" ? null : $rowValue); 
				break;
            case "BIGDATE":
				if($mode == TYPEEXCHANGE_MODE_GET)                  
					$value = $rowValue;
				else
					@$this->_data->$fieldname = is_numeric($rowValue) ? $rowValue : strtotime($rowValue);
                break;
			case "DATETIME":
				if($mode == TYPEEXCHANGE_MODE_GET)
					$value = $rowValue;
				else
					@$this->_data->$fieldname = is_numeric($rowValue) ? db_datetime($rowValue) : $rowValue;
				break;
			case "BLOB":
				if($mode == TYPEEXCHANGE_MODE_GET) {
                    if ($rowValue instanceof Blob)
                        $value = $rowValue;
                    else {
					    $value = new Blob( (int)$rowValue );
                        @$this->_data->$fieldname = $value;
                    }
				}
				else {
					if($rowValue instanceof Blob)
						@$this->_data->$fieldname = $rowValue->id;
					else {
						@$this->_data->$fieldname = $rowValue;
					}
				}
				break;
            case "FILE" :
                if($mode == TYPEEXCHANGE_MODE_GET) {
                    if ($rowValue instanceof FileView)
                        $value = $rowValue;
                    else {
                        $value = new FileView( $rowValue );
                        @$this->_data->$fieldname = $value;
                    }
                }
                else {
                    if($rowValue instanceof FileView)
                        @$this->_data->$fieldname = $rowValue->Src().":".$rowValue->alt.";";
                    else {
                        @$this->_data->$fieldname = $rowValue;
                    }
                }
                break;
			case "FILE LIST" :
				if($mode == TYPEEXCHANGE_MODE_GET) {
                    if ($rowValue instanceof FileList)
                        $value = $rowValue;
                    else {
                        $value = new FileList( $rowValue );
                        @$this->_data->$fieldname = $value;
                    }
				}
				else {
					if($rowValue instanceof FileList)
						@$this->_data->$fieldname = $rowValue->ToString();
					else {
						@$this->_data->$fieldname = $rowValue;
					}
				}				
				break;
			case "BLOB LIST" :
				if($mode == TYPEEXCHANGE_MODE_GET) {
                    if ($rowValue instanceof BlobList)
                        $value = $rowValue;
                    else {
					    $value = new BlobList( $rowValue );
                        @$this->_data->$fieldname = $value;
                    }
				}
				else {
					if($rowValue instanceof BlobList)
						@$this->_data->$fieldname = $rowValue->ToString();
					else {
						@$this->_data->$fieldname = $rowValue;
					}
				}				
				break;
			default: 
                $value = $rowValue;
				@$this->_data->$fieldname = $rowValue;
				break;
		}
		if($mode == TYPEEXCHANGE_MODE_GET) {
			$args = $this->DispatchEvent("datarow.dotypeexchanged", Hashtable::Create("field", $fieldname, "value", $value, "data", $this->_data, "return", null));
			if (@$args->cancel === true)
				return $value;
			else if (!is_empty(@$args->return))
				$value = $args->return;
		}
		return $value;
	}
	public function to_xml(){ return $this->ToXML(); }
	public function from_xml($el) { $this->FromXML($el); }
}
class DataRows {
    public $storage;
    public $pagesize = 10;
	protected $_data;
    protected $_reader;
    protected $_dtClass;
	function __construct($storage, $reader = null, $dtClass = 'DataRow') {
        $this->_reader = $reader;
		$this->storage = $storage;
		$this->_data = new ArrayList();
        $this->_dtClass = $dtClass;
	}
	public function LoadDefaults() {
        $this->_reader = null;
		$this->_data = new ArrayList();
		$this->_data->add($this->EmptyRow(true));
	}
	public function EmptyRow($rData = false) {
        $clsname = $this->_dtClass;
		$_data = new stdClass();
		foreach($this->storage->fields as $k => $field) {
			$f = $this->storage->fname($field->storage_field_field);
			$_data->$f = $field->storage_field_default;
		}
		if($rData)
			return $_data;
		else
			return @new $clsname($this->storage, $_data);
	}
    public function Load($fields = "", $filter = "", $order = "", $join = "") {
        global $core;
        $this->_reader = $core->dbe->ExecuteReader("select *".($fields != "" ? ", ".$fields : "")." from ".$this->storage->table.($join != "" ? " ".$join : "").($filter != "" ? " where ".$filter : "").($order != "" ? " order by ".$order : " order by ".$this->storage->table."_id"));
    }
    public function LoadPage($page, $fields = "", $filter = "", $order = "", $join = "") {
        global $core;
        $this->_reader = $core->dbe->ExecuteReader("select *".($fields != "" ? ", ".$fields : "")." from ".$this->storage->table.($join != "" ? " ".$join : "").($filter != "" ? " where ".$filter : "").($order != "" ? " order by ".$order : " order by ".$this->storage->table."_id"), $page, $this->pagesize);
    }
	public function Query($sql) {
		global $core;
		$this->_reader = $core->dbe->ExecuteReader($sql);
	}
   	public function Affected() {
		return $this->_reader->affected;
	}
	public function Count() {
        if(is_null($this->_reader)) {
            return 0;
        }
		return $this->_reader->count;
	}
    protected function _createRowObject() {
        $clsname = $this->_dtClass;
        return new $clsname($this->storage, $this->_reader->Read());
    }
	public function FetchNext() {
        $clsname = $this->_dtClass;
        if($this->_reader instanceof DataReader) {
            if($this->_reader->HasRows()) 
                return $this->_createRowObject();
        }
        elseif($this->_data->Count() > 0)
            return new $clsname($this->storage, $this->_data->Item(0));
        return false;
	}
	public function FetchAll(){
		$ret = new Collection();
		while ($item = $this->FetchNext()){
		    $ret->Add($item->id, $item);
		}
		return $ret;
	}
	public function Delete($drs = null){
                if(is_null($drs)) {
            while($dt = $this->FetchNext()) {
                $dt->Delete();
            }
            return;
        }
				if(!is_array($drs)) 
			$drs = array($drs);
		foreach($drs as $dr) {
			$dr->Delete();
		}
	}
	public function Out($template = "", $user_params = null, $create_checkbox = true) {
		$ret = "";
		$i = 0;
		if($this->Count() > 0) {
            if($user_params == null)
                $user_params = new collection();
			while($dr = $this->FetchNext()) {
				$user_params->Add("rendering_index", $i);
				$ret .= $dr->Out($template, $user_params, OPERATION_LIST);
				if($user_params->cancel)
					break;
				$i ++;
			}
		}
		return $ret;
	}
	public function ToXML(){
		$ret = "<rows storage=\"".$this->storage->table."\">";
		while ($row = $this->FetchNext())
			$ret .= $row->ToXML();
		$ret .= "</rows>";
		return $ret;
	}
	public function FromXML($el){
		$ids = array();
		$idf = "id";
		foreach ($el->childNodes as $pair){
			$dr = new DataRow($this->storage, null);
			$dr->FromXML($pair);
			$vls = array();
			foreach ($dr->storage->fields as $field){
				$fname = $field->field;
				$vv = $dr->$fname;
				if(is_object($vv)) {
					if ($vv instanceof MultilinkField){
						$vv = $vv->Values();
					} else 
						$vv = $vv->id;
				}
				$vls[] = $dr->storage->fname($fname)." = '".addslashes(str_replace("\r\n", "\n", $vv))."'";
			}
			$tdrs = new DataRows($dr->storage);
			$tdrs->Load("", implode(" and ", $vls));
			unset($vls);
			if ($tdrs->Count() > 0){
								$value = $tdrs->FetchNext()->$idf;
			} else {
				$dr->Save();
				$value = $dr->$idf;
			}
			$ids[] = $value;
								}
		$this->Load("", $this->storage->fname("id")." in (".implode(", ", $ids).")");
	}
	public function to_xml(){ return $this->ToXML(); }
	public function from_xml($el){ $this->FromXML($el); }
}
class DataNodes {
    private $_dbt;
    protected $_data;
    protected $_reader;
    protected $_dtClass;
    public $storage;
    public $pagesize = 10;
    function __construct($storage, $reader = null, $dtClass = 'DataNode') {
        $this->_reader = $reader;
        $this->storage = $storage;
        $this->_data = new ArrayList();
        $this->_dtClass = $dtClass;
        $this->_dbt = new dbtree($this->storage->table, $this->storage->table);
    }
    public function LoadDefaults() {
        $this->_data = new ArrayList();
        $this->_data->add($this->EmptyRow(true));
    }
    public function EmptyRow($rData = false) {
        $clsname = $this->_dtClass;
        $data = new stdClass();
        foreach($this->storage->fields as $k => $field) {
            $f = $this->storage->fname($field->storage_field_field);
            $data->$f = $field->storage_field_default;
        }
        if($rData)
            return $data;
        else
            return @new $clsname($this->storage, $data);
    }
    public function LoadPlain($fields = "", $filter = "", $order = "", $join = "", $page = -1, $pagesize = 10) {
        global $core;
        $this->_reader = $core->dbe->ExecuteReader("select *".($fields != "" ? ", ".$fields : "")." from ".$this->storage->table.($join != "" ? " ".$join : "").($filter != "" ? " where ".$filter : "").($order != "" ? " order by ".$order : " order by ".$this->storage->table."_id"), $page, $pagesize);
        $this->pagesize = $pagesize;
    }
    public function Load($fields = "", $filter = "", $order = "", $join = "", $parent = null, $page = -1, $pagesize = 10) {
        global $core;
        if(is_empty($filter))
            $condition = '';
        else {
            $condition = array('and' => array());
            if(is_string($filter))
                $condition['and'][] = $filter;
            else
                $condition = array("and" => $filter);    
        }
        if(is_null($parent)) {
            $idf = $this->storage->fname('id');
            $root = $this->_dbt->GetRootNode();
            $id = $root->$idf;    
        }   
        else 
            $id = $parent->id;
        if(!is_empty($fields) && !is_array($fields))
            $fields = explode(",", $fields);
        $this->pagesize = $pagesize;    
        $this->_reader = $this->_dbt->Branch($id, $fields, $condition, '', $join, $page, $pagesize);
    }
    public function LoadChildLevels($parent = null, $levels = 1, $fields = '') {
        global $core;
        $idf = $this->storage->fname('id');
        $levelf = $this->storage->fname('level');
        $childsf = $this->storage->fname('children');
        if(is_null($parent)) {
            $root = $this->_dbt->GetRootNode();
            $id = $root->$idf;    
            $condition["and"] = array($levelf." > ".$root->$levelf, $levelf." < ".($root->$levelf+$levels+1));
        }   
        else {
            $id = $parent->id;
            $condition["and"] = array($levelf." > ".$parent->level, $levelf." < ".($parent->level+$levels+1));
        }
        if(!is_empty($fields)) {
            if(!is_array($fields))
                $fields = explode(',', $fields);
            $fields[] = "(SELECT count(*) FROM ".$this->storage->table." AA, ".$this->storage->table." BB WHERE BB.".$this->storage->table."_id = A.".$this->storage->table."_id AND AA.".$this->storage->table."_left_key > BB.".$this->storage->table."_left_key AND AA.".$this->storage->table."_right_key < BB.".$this->storage->table."_right_key) as ".$childsf;
        }
        else
            $fields = array("(SELECT count(*) FROM ".$this->storage->table." AA, ".$this->storage->table." BB WHERE BB.".$this->storage->table."_id = A.".$this->storage->table."_id AND AA.".$this->storage->table."_left_key > BB.".$this->storage->table."_left_key AND AA.".$this->storage->table."_right_key < BB.".$this->storage->table."_right_key) as ".$childsf);
        $this->_reader = $this->_dbt->Branch($id, $fields, $condition, '', "");
    }
    public function LoadPage($page, $fields = "", $filter = "", $order = "", $join = "", $parent = null) {
        global $core;
        if(is_empty($filter))
            $condition = '';
        else {
            $condition = array('and' => array());
            if(is_string($filter))
                $condition['and'][] = $filter;
            else
                $condition = array("and" => $filter);    
        }
        if(is_null($parent)) {
            $idf = $this->storage->fname('id');
            $root = $this->_dbt->GetRootNode();
            $id = $root->$idf;
        }   
        else 
            $id = $parent->id;
        $fields = '';
        if(!is_empty($fields))
            $fields = explode(",", $fields);
        $this->_reader = $this->_dbt->Branch($id, $fields, $condition, '', $join, $page, $this->pagesize);
    }
    public function LoadRootLevel($fields = "", $filter = "", $page = -1, $pagesize = 10) {
        $treeRoot = $this->_dbt->GetRootNode();
        $id = $this->storage->fname('id');
        $fields = '';
        if(!is_empty($fields))
            $fields = explode(",", $fields);
        $this->_reader = $this->_dbt->Branch($treeRoot->$id, '', array("and" => array($this->storage->table."_level = 1")), '', '', $page, $pagesize);
    }
    public function LoadAjared($current, $fields = '', $filter = '', $join = '', $page = -1, $pagesize = 10) {
        $fields = '';
        if(!is_empty($fields))
            $fields = explode(",", $fields);
        $this->_reader = $this->_dbt->Ajar($current->id);
    }
    public function Affected() {
        return $this->_reader->affected;
    }
    public function Count() {
        return $this->_reader->count();
    }
    protected function _createRowObject() {
        $clsname = $this->_dtClass;
        return new $clsname($this->storage, $this->_reader->Read());
    }
    public function FetchNext() {
        $clsname = $this->_dtClass;
        if($this->_reader instanceof DataReader)
            return $this->_reader->HasRows() ? $this->_createRowObject() : false;
        elseif($this->_data->Count())
            return new $clsname($this->storage, $this->_data->Item(0));
        return false;
    }
    public function FetchAll($clsname = null){         $ret = new Collection();
        while ($item = $this->FetchNext()){
            if ($clsname == null){
                $ret->Add($item->id, $item);
            } else {
                $ret->Add($item->id, new $clsname($item));
            }
        }
        return $ret;
    }
    public function Delete($drs){
                if(!is_array($drs)) {
            $drs = array($drs);
        }
        foreach($drs as $dr) {
            $dr->Delete();
        }
    }    
    public function Out($template = "", $user_params = null, $create_checkbox = true) {
        $ret = "";
        $i = 0;
        if($this->Count() > 0) {
            while($dr = $this->FetchNext()) {
                if($user_params == null)
                    $user_params = new collection();
                $user_params->Add("rendering_index", $i);
                $ret .= $dr->Out($template, $user_params, OPERATION_LIST);
                if($user_params->cancel)
                    break;
                $i ++;
            }
        }
        return $ret;
    }
    public function ToXML(){
        $ret = "<rows storage=\"".$this->storage->table."\">";
        while ($row = $this->FetchNext())
            $ret .= $row->ToXML();
        $ret .= "</rows>";
        return $ret;
    }
    public function FromXML($el){
        $ids = array();
        $idf = "id";
        foreach ($el->childNodes as $pair){
            $dr = new DataRow($this->storage, null);
            $dr->FromXML($pair);
            $vls = array();
            foreach ($dr->storage->fields as $field){
                $fname = $field->field;
                $vv = $dr->$fname;
                if(is_object($vv)) {
                    if ($vv instanceof MultilinkField){
                        $vv = $vv->Values();
                    } else 
                        $vv = $vv->id;
                }
                $vls[] = $dr->storage->fname($fname)." = '".addslashes(str_replace("\r\n", "\n", $vv))."'";
            }
            $tdrs = new DataRows($dr->storage);
            $tdrs->Load("", implode(" and ", $vls));
            unset($vls);
            if ($tdrs->Count() > 0){
                                $value = $tdrs->FetchNext()->$idf;
            } else {
                $dr->Save();
                $value = $dr->$idf;
            }
            $ids[] = $value;
                                }
        $this->Load("", $this->storage->fname("id")." in (".implode(", ", $ids).")");
    }
    public function RootNode() {
        return new DataRow($this->storage, $this->_dbt->GetRootNode());
    }
} 
class DataNode extends DataRow {
    private $_dbt;
    public function __construct($storage, $dt = null, $dbt = null) {
        $this->_dbt = $dbt;
        if(is_null($this->_dbt))
            $this->_dbt = new dbtree($storage->table, $storage->table);
        parent::__construct($storage, $dt);
    }     
    public function Save($parent = null) {
        global $core;
        $args = $this->DispatchEvent("datarow.saving", collection::create("data", $this->_data));
        if (@$args->cancel === true)
            return;
        else if (!is_empty(@$args->data))
            $this->_data = $args->data;
        $idf = $this->fname("id");
        $idfl = $this->fname("left_key");
        $idfr = $this->fname("right_key");
        $id = $this->id;
        $data = $this->ToCollection();
        foreach ($data as $k => $v){
            $kk = $this->storage->fromfname($k);
            $field = $this->storage->fields->$kk;
            if(!is_null($field)) {
                $type = strtolower($field->type);
                if($type == "blob") {
                    if($v instanceof Blob)
                        $data->$k = $v->id;
                    elseif(!is_numeric($v)) {
                        $data->$k = 0;
                    }
                } else if ($type == "file"){
                    if ($v instanceof FileView)
                        $data->$k = $v->ToString();
                } else if ($type == "file list"){
                    if ($v instanceof FileList)
                        $data->$k = $v->ToString();
                } else if ($type == "blob list"){
                    if ($v instanceof BlobList)
                        $data->$k = $v->ToString();
                } 
                else if ($type == "text" || $type == "memo" || $type == "html") {
                    if(!is_object($v))
                        $data->$k = db_prepare($v);
                    else
                        $data->$k = $v;
                } else if ($type == "datetime"){
                    if (is_empty($v))
                        $v = time();
                    $data->$k = is_numeric($v) ? db_datetime($v) : $v;
                } else if ($type == "bigdate"){
                    if (is_empty($v))
                        $v = time();
                    $data->$k = is_numeric($v) ? $v : strtotime($v);
                } else if ($type == "numeric"){
                    if (is_null($v)) {
                        if(!is_null($field->default))
                            $v = $field->default;
                        else
                            $v = null;
                    }
                    if($v == "")
                        $v = $field->required ? 0 : null;
                    $data->$k = $v;
                } 
                if($field->isMultilink && $type == "memo" && $v instanceof MultilinkField) {
                    $data->$k = $v->Values();
                }
                if($field->isLookup && $type == "numeric" && $v instanceof DataRow) {
                    $data->$k = $v->id;
                }
            }
        }
        $data->Delete($idf);
        $data->Delete($idfl);
        $data->Delete($idfr);
        if(is_null($id) || $id <= 0) {
            if(is_null($parent)) {
                $root = $this->_dbt->GetRootNode();
                $id = $root->$idf;
            }
            else {
                $id = is_object($parent) ? $parent->id : $parent;
            }
            $this->_data->$idf = $this->_dbt->Insert($id, '', $data);
        }
        else {
            $this->_dbt->Update($this->id, $data);
        }
        $pubs = $this->Publications();
        foreach($pubs as $pub) {
            $pub->SetModified();
        }
        $args = $this->DispatchEvent("datarow.save", collection::create("storage", $this->storage, "data", $this->_data));
        if (!is_empty(@$args->data))
            $this->_data = $args->data;
    }
    public function Delete() {
        global $core;
        $args = $this->DispatchEvent("datarow.deleting", collection::create("datarow", $this, "data", $this->_data));
        if (@$args->cancel === true)
            return;
        else if (!is_empty(@$args->data))
                $this->_data = $args->data;
        Publications::ClearDataLinks($this->storage->id, $this->id);
        $this->_dbt->DeleteAll($this->id);
        $args = $this->DispatchEvent("datarow.deleted", collection::create("data", $this->_data));
    }
    public function CountChildNodes() {
        return $this->_dbt->CountAll($this->id);
    }
    public function Copy() {
        $data = $this->ToCollection();
        $dt = new DataRow($this->storage, null);
        $dt->Defaults();
        foreach($data as $name => $value) {
            $name = $this->fromfname($name);
            if($name != "id" && $name != "datecreated" && $name != "left_key" && $name != "right_key") {
                $dt->$name = $value;
            }
        }
        $idf = $this->storage->fname('id');
        $parent = $this->_dbt->GetParentInfo($this->id);
        $dt->Save($parent->$idf);
        return $dt;
    }
    public function Branch($fields = '', $filter = '', $join = '', $page = -1, $pagesize = 10) {
        $dtr = new DataNodes($this->storage);
        if($page < 0)
            $dtr->Load($fields, $filter, '', $join, $this);
        else {
            $dtr->pagesize = $pagesize;
            $dtr->LoadPage($page, $fields, $filter, '', $join, $this);
        }
        return $dtr;
    }
    public function Ajar($fields = '', $filter = '', $join = '') {
        $dtr = new DataNodes($this->storage);
        $dtr->LoadAjared($this, $fields, $filter, '', $join, $this);
        return $dtr;
    }
    public function Children($fields = '', $filter = '', $join = '', $page = -1, $pagesize = 10) {
        $dtr = new DataNodes($this->storage);
        if(!is_array($filter))
            $filter = array();
        if(!is_empty($filter)) {
            $filter[] = $this->storage->table."_level > ".$this->level;
            $filter[] = $this->storage->table."_level < ".($this->level+2);
        }
        else
            $filter = array("tree_level > ".$this->level, "tree_level < ".($this->level+2));
        if($page < 0)
            $dtr->Load($fields, $filter, '', $join, $this);
        else {
            $dtr->pagesize = $pagesize;
            $dtr->LoadPage($page, $fields, $filter, '', $join, $this);
        }
        return $dtr;
    }
    public function Parents() {
        $ret = new ArrayList();
        $c = $this->_dbt->Parents($this->id, '', array('and' => array($this->storage->table.'_level > 0')));
        while($cc = $c->FetchNext()) {
            $ret->Add(new DataNode($this->storage, $cc));
        }
        return $ret;
    }
    public function Parent() {
        $c = $this->_dbt->Parents($this->id, '', array('and' => array($this->storage->table.'_level = '.($this->level - 1))));
        return new DataNode($this->storage, $c->FetchNext());
    }
    public function MoveTo($dt) {
        if( $dt->id != $this->id && 
            !$dt->IsChildOf($this))
            $this->_dbt->moveAll($this->id, $dt->id);
        else
            return false;
        return true;
    }
    public function MoveUp() {
        $p = $this->Parent();
        $c = $p->Children()->FetchAll();
        $f1 = null;
        foreach($c as $f) {
            if($f->id == $this->id) {
                break;
            }
            $f1 = $f;
        }
        return $this->_dbt->ChangePositionAll($this->id, $f1->id, 'before'); 
    }
    public function MoveDown() {
        $p = $this->Parent();
        $c = $p->Children()->FetchAll();
        for($i=0; $i<$c->count();$i++) {
            if($c->item($i)->id == $this->id) {
                break;
            }
        }
        return $this->_dbt->ChangePositionAll($this->id, $c->item($i+1)->id, 'after');
    }
    public function IsChildOf($p, $self = true){
        if(is_null($p))
            return false;
        if($self)
            return $this->left_key >= $p->left_key && $this->right_key <= $p->right_key;
        else
            return $this->left_key > $p->left_key && $this->right_key < $p->right_key;
    }
}
?>
<?php
class Publication extends IEventDispatcher {
	private $pdata;
	public $datarow;
	public $module;
	public $error;
	private $_properties; 
	function __construct($l, $dt = null) {
		global $core;
		$this->error = false;
		if(is_numeric($l)) {
			$r = $core->dbe->ExecuteReader("select * from ".sys_table("links")." where link_id='".$l."'");
			$this->pdata = $r->Read();
			if (is_null($this->pdata)) {
				$this->error = true;
				$dt = null;
			}
		}
		else
			$this->pdata = $l;
		$this->init($dt);
		$this->RegisterEvent("publication.save");
		$this->RegisterEvent("publication.saving");
		$this->RegisterEvent("publication.discarding");
		$this->RegisterEvent("publication.discard");
	}
	public function __get($nm) {
		$lprop = "link_".$nm;
		if($nm == "properties") {
			$this->_loadProperties();
			return $this->_properties;
		}
		if($nm == "link_properties") {
			return $this->pdata->link_propertiesvalues;
		}
		$value = @$this->pdata->$lprop;
		if(is_null($value)) {
			$this->_loadProperties();
			$prop = $this->_properties->$nm;
			if($prop) {
				if($prop->type == "blob") {
					global $core;
					return new blob(intval(@$prop->value));
				}
				else {
					return @$prop->value;
				}
			}				
			return null;
		}
		return $value;
	}
	public function __set($nm, $val) {
		$lprop = "link_".$nm;
        if(!is_null(@$this->pdata->$lprop)) {
			if($nm == "template" && ($this->_properties instanceof PublicationProperties)) {
				$this->_properties->Clear();
				@$this->pdata->link_propertiesvalues = null;
			}
			@$this->pdata->$lprop = $val;
			return;
		}
		else {
			$this->_loadProperties();	
			if($this->_properties->Exists($nm))
				$this->_properties->$nm->value = $value;
		}
	}
	public function Publications($criteria = "", $order = "", $page = -1, $pagesize = 10, $joins = "") {
		return new Publications($this, $criteria, $order, $page, $pagesize, $joins);
	}
	public function FetchPublications($storageList = null , $crit = "", $order = "", $page = -1, $pagesize = 10) {
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);
		$order = ($order != "") ? $order : "link_order";
		return new Publications($this, $criteria, $order, $page, $pagesize);
	}
	public function MoveTo($parent) {
		$this->parent_id = $parent->id;
		$this->parent_storage_id = 0;
		$this->Save();
	}
	public function CopyTo($parent) {
		$pps = $this->Publications();
		$newNode = $this->_CopySingleNode($parent);
		if($pps->Count() > 0) {
			while($pp = $pps->FetchNext()) {
				$pp->CopyTo($newNode);
			}
		}
		return $newNode;
	}
	private function _CopySingleNode($parent) {
		$cp = clone $this->pdata;
		$cp = crop_object_fields($cp, "/link_.*/i");
		$p = new Publication($cp);
		$p->id = -1;
		$p->order = null;
		$p->parent_id = $parent->id;
		$p->Save();
		return $p;
	}
	public function Discard() {
		global $core;
		$args = $this->DispatchEvent("publication.discarding", collection::create("publication", $this));
		if (@$args->cancel === true)
			return;
		$pubs = $this->Publications();
		while($pub = $pubs->FetchNext()) {
			$pub->Discard();
		}
		$this->SetModified();
		$core->dbe->delete(sys_table("links"), "link_id", $this->id);
		$this->DispatchEvent("publication.discard", collection::create("publication", $this));
	}
	public function Save() {
		global $core;
		$args = $this->DispatchEvent("publication.saving", collection::create("publication", $this, "publicationdata", $this->pdata));
		if (@$args->cancel === true)
			return;
		else if(@$args->apply === true)  
			$this->pdata = $args->publicationdata;
		$data = collection::create($this->pdata);
		if($this->_properties instanceof PublicationProperties) {
			$data->link_propertiesvalues = serialize($this->_properties->get_array());
		}
		else
			$data->link_propertiesvalues = "";
		if (is_null($data->link_template))
			$data->link_template = "";
		$data->link_modifieddate = strftime("%Y-%m-%d %H:%M:%S", time());
		if (@$data->link_id > 0){
			$data->Delete("link_id");
			$core->dbe->set(sys_table("links"), "link_id", $this->pdata->link_id, $data);
		} else {
									if (!is_numeric($data->link_parent_id) || !is_numeric($data->link_parent_storage_id) ||
				!is_numeric($data->link_child_storage_id) || !is_numeric($data->link_child_id))
				return;
			$data->Delete("link_id");
			$data->Delete("link_order");
			$data->Delete("link_child_count");
			$id = $core->dbe->insert(sys_table("links"), $data);
						$core->dbe->set(sys_table("links"), "link_id", $id, new collection(array("link_order" => $id)));
			$this->pdata->link_id = $id;
			$this->init();
					}
		$this->SetModified();
		$this->DispatchEvent("publication.save", collection::create("publication", $this));
	}
    public function Next() {
        global $core;
        $r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order > ".$this->pdata->link_order." order by link_order limit 1");
        $rr = $r->Read();
        if($rr)
            return new Publication($rr->link_id);
        return null;
    }
    public function Previous() {
        global $core;
        $r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order < ".$this->pdata->link_order." order by link_order desc limit 1");
        $rr = $r->Read();
        if($rr)
            return new Publication($rr->link_id);
        return null;
    }
	public function FindFolder() {
		global $core;
		$p = $this->Parent();
		while($p instanceof Publication) {
			$p = $p->Parent();
		}
		return $p;
	}
	public function Parent(){
		global $core;
		if ($this->parent_storage_id == 0) {
			return Site::Fetch($this->parent_id);
		} else {
			$l = $this->pdata;
			$r = $core->dbe->ExecuteReader("select * from sys_links where link_id='".$l->link_parent_id."' limit 1");
			if(!$r->HasRows())
				return null;
			return new Publication($r->Read());
		}
	}
		public function SetModified() {
		$s = $this->id.",";
		$p = $this->Parent();
		while($p instanceof Publication) {
			$s .= $p->id.",";
			$p = $p->Parent();
		}
		$s = "in (".rtrim($s, ",").")";
		global $core;
		$core->dbe->query("update sys_links set link_modifieddate='".strftime("%Y-%m-%d %H:%M:%S", time())."' where link_id ".$s);
		if ($p) 			$p->SetModified();
	}
	public function Out($template = "", $user_params = null, $operation = OPERATION_ITEM) {
		$template = $this->getTemplate($template);
		return $template->Out($operation, $this, $user_params);
	}
	public function URL($s = null, $args = null){
		if(is_null($s)) {
			$s = $this->FindFolder();
		}
		return $s->URL($this, $args);
	}
	public function MoveUp() {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order < ".$this->pdata->link_order." order by link_order desc limit 1");
		$rr = $r->Read();
		$p2 = new Publication($rr->link_id);
		Publications::ChangeOrder($this, $p2);
	}
	public function MoveDown() {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_id='".$this->parent_id."' and link_parent_storage_id='".$this->parent_storage_id."' and link_order > ".$this->pdata->link_order." order by link_order limit 1");
		$rr = $r->Read();
		if($rr) {
			$p1 = new Publication($rr->link_id);
			Publications::ChangeOrder($p1, $this);
		}
	}
	public function getTemplate($template = null) {
		return template::create(is_empty($template) ? $this->template : $template, $this->object_type == 1 ? $this->module : $this->datarow->storage);
	}
	public function ToCollection() {
		$res = new collection();
		$res->add("publication", collection::create($this->pdata));
		$res->add("datarow", collection::create($this->datarow->data()));
		$res->add("module", ($this->module ? $this->module->GetData() : ''));
		$res->add("output", $this->Out(TEMPLATE_ADMIN, null, false));
		$pubs = $this->Publications();
		if($pubs->Count() > 0) {
			$res->add("publications", $pubs->ToCollection());
		}
		return $res;
	}
	public function ToXML($withBranch = false){
		$ret = "\n<publication>";
		$data = collection::create($this->pdata);
		$data->FromObject(crop_object_fields($data->ToArray(), "/link_.*/i"), true);
		$data->Delete("link_child_count");
		$ret .= "\n".$data->ToXML();
		$args = $this->DispatchEvent("publication.toxml.processxml", collection::create("xml", $c));
		if (!is_empty(@$args->xml))
			$ret .= $args->xml;
		if ($withBranch)
			$ret .= $this->Publications()->ToXML($withBranch);
		$ret .= "\n</publication>";
		return $ret;
	}
	public function FromXML($el, $parent){
		$p = null;
		foreach ($el->childNodes as $pair){
			$args = $this->DispatchEvent("publication.from_xml.processdata", collection::create("element", $pair));
			if ($pair->tagName == "collection"){
				$c = new collection();
				$c->FromXML($pair);
				$c->FromObject(crop_object_fields($c->ToArray(), "/link_.*/i"), true);
				$c->link_parent_id = (is_numeric($parent)) ? $parent : $parent->id;
				if ($parent instanceof Folder)
					$c->link_parent_storage_id = 0;
				else if ($parent instanceof Publication)
					$c->link_parent_storage_id = 1;
				$args = $this->DispatchEvent("publication.from_xml.setdata", collection::create("data", $c));
				if (!is_empty(@$args->data))
					$c = $args->data;
				$c->Delete("link_id");
				$c->Delete("link_child_count");
				$this->pdata = $c->ToObject();
				$this->Save();
			} else {
				$p = $pair;
			}
		}
		if ($p){
			$pubs = new Publications($this);
			$pubs->FromXML($p);
		}
	}
	private function init($dt = null){
		global $core;
		if(is_null($dt)){
			if ($this->pdata->link_object_type == "1"){
				$modules = $core->mm->modules;
				$this->module = $modules->search($this->pdata->link_child_storage_id, "id"); 			} else {
				$storage = new Storage($this->pdata->link_child_storage_id); 
				if(!is_null($storage)) {
					$dtr = new DataRows($storage);
					$dtr->Load("", $storage->table."_id='".$this->child_id."'", "");
					$this->datarow = $dtr->FetchNext();
				} else {
					$this->datarow = null;
				}
			}
		} else {
			if ($dt instanceof CModule)
				$this->module = $dt;
			else
				$this->datarow = $dt;
		}
	}
	private function _loadProperties() {
		if(!($this->_properties instanceof PublicationProperties)) {
			$this->_properties = new PublicationProperties($this);
		}
	}
	public function to_xml($withBranch = false){ return $this->ToXML($withBranch); }
	public function from_xml($el, $parent){ $this->FromXML($el, $parent); }
	public function get_collection() { return $this->ToCollection(); }
}
class Publications extends IEventDispatcher {
	private $links;
	private $pid;
	private $pstorage;
	private $storagesList;
	private $storages;
	private $disconnected;
	private $_initialParents;
	public function __construct($sp, $criteria = "", $order = "", $page = -1, $pagesize = 10, $joins = "") {
		$this->disconnected = false;
		$this->_initialParents = $sp;
		if(is_array($sp) || $sp instanceof IteratorAggregate) {
			$this->pid = array();
			$this->pstorage = array();
			foreach($sp as $ss){
				$this->pid[] = $ss->id;
				if($ss instanceof Publication) {
					$this->pstorage[] = 1;
				}
				else if($ss instanceof Site || $ss instanceof Folder) {
					$this->pstorage[] = 0; 				}
			}
		}
		else {
			if($sp instanceof Publication) {
				$this->pid = $sp->id;
				$this->pstorage = 1;
			}
			else if($sp instanceof Site || $sp instanceof Folder) {
				$this->pid = $sp->id;
				$this->pstorage = 0; 			}
		}
		$this->storagesList = new storages();
		$this->storages = new collection();
        $this->Load($criteria, $order, $page, $pagesize, $joins);
		$this->RegisterEvent("publication.adding");
		$this->RegisterEvent("publication.add");
	}
	function __get($key){
		switch (strtolower($key)){
			case "disconnected" :
				return $this->disconnected;
			default :
		}
	}
	function __set($key, $value){
	}
	public function Count() {
		if($this->links != null)
			return $this->links->count();
		else
			return 0;
	}
	public function Affected() {
		if($this->links != null)
			return $this->links->affected;
		else
			return 0;
	}
	public function Load($criteria = "", $order = "", $page = -1, $pagesize = 10, $joins = ""){
		global $core;
        if(is_array($this->pid)) {
			$parents = array();
			for($i=0; $i<count($this->pid); $i++ ) {
				$parents[] = array("pid" => $this->pid[$i], "pstorage" => $this->pstorage[$i]);
			}
		}
		else {
			$parents = array(array("pid" => $this->pid, "pstorage" => $this->pstorage));
		}
		$q = Publications::_getPublicationsQuery($parents, $criteria, $order, $joins);
		$this->links = $core->dbe->ExecuteReader($q, $page, $pagesize);
	}
	public function FetchNext() {
		if($r = $this->links->FetchNext()) {
			if ($r->link_object_type == "1"){
				$obj = new CModule($r->link_child_storage_id);
			} else {
				$storage = new Storage($r->link_child_storage_id);
				$rr = crop_object_fields($r, "/".$storage->table."_.*/i");
				$obj = new DataRow($storage, $rr);
			}
			return new Publication($r, $obj);
		} else {
			$this->disconnected = true;
			return false;
		}
	}
	public function Add($dt, $parent = null) {
		global $core;
		if(is_array($this->pid) && $parent == null)
			return null;
		$this->DispatchEvent("publication.adding", collection::create("publication", null, "datarow", $dt));
		$p = new stdClass();
		$p->link_id = -1;
		$p->link_order = 0;
		$p->link_object_type = ($dt instanceof CModule ? "1" : "0");
		$p->link_child_storage_id = ($dt instanceof CModule ? $dt->id : $dt->storage->id);
		$p->link_child_id = ($dt instanceof CModule ? 0 : $dt->id);
        $p->link_template = "";
        $p->link_propertiesvalues = null;
        $p->link_modifieddate = '0000-00-00 00:00:00';          
		if(is_array($this->pid)) {
			$p->link_parent_storage_id = ($parent instanceof Publication ? 1 : 0);
			$p->link_parent_id = $parent->id;
		}
		else {
			$p->link_parent_storage_id = $this->pstorage;
			$p->link_parent_id = $this->pid;
		}
		$p = new Publication($p, $dt);
		$p->Save();
		$p->SetModified();
		$this->DispatchEvent("publication.add", collection::create("publication", $p));
		return $p;
	}
    public function Clear() {
	    global $core;
	    while($pub = $this->FetchNext())
			$pub->Discard();
	}
	public function Out($template = "", $user_params = null, $create_checkbox = true) {
		$ret = "";
		$i = 0;
		if($this->Count() > 0) {
            if($user_params == null)
                $user_params = new collection();
            $user_params->Add("rendering_count", $this->Count());
			while($pub = $this->FetchNext()) {
								$user_params->Add("rendering_index", $i);
				$ret .= $pub->Out($template, $user_params, OPERATION_LIST);
				if($user_params->cancel)
					break;
				$i ++;
			}
		}
		return $ret;
	}
	public function FetchAll(){
		$res = new Collection();
		while ($p = $this->FetchNext())
			$res->Add($p->id, $p);
		return $res;
	}
	public function ToCollection() {
		$res = new collection();
		while ($p = $this->FetchNext())
			$res->add("p".$p->id, $p->ToCollection());
		return $res;
	}
	public function ToXML($withBranch = false){
		if(is_array($this->pid))
			return "";
		$count = $this->Count();
		if ($count == 0)
			return;
		$ret = "\n<publications>";
		while ($pub = $this->FetchNext())
			$ret .= $pub->ToXML($withBranch);
		$args = $this->DispatchEvent("publications.toxml.processxml", collection::create("xml", $c));
		if (!is_empty(@$args->xml))
			$ret .= $args->xml;
		$ret .= "\n</publications>";
		return $ret;
	}
	public function FromXML($el){
		if(is_array($this->pid))
			return "";
	    foreach($el->childNodes as $pair) {
			$args = $this->DispatchEvent("publications.fromxml.processdata", collection::create("element", $pair));
			if ($pair->tagName == "publication"){
				$p = new Publication(null);
				$p->FromXML($pair, $this->pid);
			}
		}
		$this->Load();
	}
	static function FetchPublications($parents, $storageList = array() , $crit = "", $order = "", $page = -1, $pagesize = 10) {
        $criteria = Publications::_getStoragesCriteria($storageList, $crit);
		$order = ($order != "") ? $order : "link_order";
		return new Publications($parents, $criteria, $order, $page, $pagesize);
	}
	static function ClearDataLinks($storage_id, $data_id) {
		global $core;
		$r = $core->dbe->ExecuteReader("select * from ".sys_table("links")." where (link_child_storage_id='".$storage_id."' and link_child_id='".$data_id."')", "link_id");
		while($rr = $r->Read()) {
			$p = new Publication($rr);
			$p->Discard();
		}
	}
	static function ChangeOrder($p1, $p2) {
		global $core;
		$id1 = $p1->id;
		$id2 = $p2->id;
		$order1 = $p1->order;
		$order2 = $p2->order;
		$core->dbe->Query("update sys_links set link_order=".$order1." where link_id=".$id2);
		$core->dbe->Query("update sys_links set link_order=".$order2." where link_id=".$id1);
		$p1->SetModified();
		$p2->SetModified();
	}
	static function PublishedStorages($parentid) {
		global $core;
		$storages = new ArrayList();
		$q1 = "select distinct link_child_storage_id, link_object_type from ".sys_table("links")." where link_parent_id=".$parentid;
		$r = $core->dbe->ExecuteReader($q1);
		while($rr = $r->Read()) {
			if($rr->link_object_type == 0)
				$storages->Add(storages::get($rr->link_child_storage_id));
			else 
				$storages->Add(new CModule($rr->link_child_storage_id));				
		}
		return $storages;
	}
    static function Exists($pid) {
        global $core;
        if(!is_numeric($pid)) $pid = 0;
        $r = $core->dbe->ExecuteReader("select count(*) as c from ".sys_table("links")." where link_id='".$pid."'");
        $row = $r->Read();
        return $row->c > 0;
    }
	public static function _getPublicationsQuery($parents = null,  
												 $criteria = "", 
												 $order = "", 
												 $joins = "") {
		global $core;
        if($order == "")
			$order = "link_order";
        $crit = null;
		$ord = null;
		if(is_array($order)) {
			$ord = $order;
			$order = "";
		}
        if(is_array($criteria)) {
            $crit = $criteria;
            $criteria = "";
        }
		$pids = "";
		$pstorages = "";
		foreach($parents as $parent) {
			$pids .= ",".$parent["pid"];
			$pstorages .= ",".$parent["pstorage"];
		}
		$pids = substr($pids, 1);
		$pstorages = substr($pstorages, 1);
		$q1 = "select distinct storage_table, link_child_storage_id from ".sys_table("links").", sys_storages where link_parent_id in (".$pids.")  and link_parent_storage_id in (".$pstorages.") and (link_child_storage_id=sys_storages.storage_id)";
		$r = $core->dbe->ExecuteReader($q1);
		$q = "select *, (select count(link_id) from sys_links as l1 where l1.link_parent_id=sys_links.link_id and l1.link_parent_storage_id=1) as link_child_count from sys_links ";
		$where = "(link_parent_id in (".$pids.") and link_parent_storage_id in (".$pstorages.")) and ";
        if(is_array($ord)) 
            if(isset($ord['sys_links']))
                $order .= ','.$ord['sys_links'];
        while($rr = $r->Read()) {
			$q .= " left outer join ".$rr->storage_table." on ".$rr->storage_table."_id=link_child_id and link_child_storage_id=".$rr->link_child_storage_id." ";
			if(is_array($ord)) {
				if(isset($ord[$rr->storage_table]))
					$order .= ','.$ord[$rr->storage_table];
			}
            if(is_array($crit)) {
                if(isset($crit[$rr->storage_table]))
                    $criteria .= ' or '.$crit[$rr->storage_table];             }
		}
		if(substr($order, 0, 1) == ",")		
			$order = substr($order, 1);
		$q .= " left outer join sys_modules on module_id=link_child_storage_id and link_child_id=0";
		if ($joins != "")
			$q .= " ".$joins;
		if(!is_empty($order))
			$order = " order by ".$order;
		else
			$order = " order by link_order";
        if($criteria != "") {             $criteria = substr($criteria, 0, 4) != " or " ? $criteria : substr($criteria, 4);
            $criteria = " and (".$criteria.")";
        }
        if(!is_null(@$crit["links"]) && !is_empty(@$crit["links"])){
            $criteria .= " and ".$crit["links"];
        }
	 	$q = $q." where ".substr($where, 0, strlen($where)-5).$criteria.$order;
		return $q;
	}
    public static function _getStoragesCriteria($storageList = null , $crit = "") {
        global $core;
        $criteria = array();
        $criteria["links"] = "";
        foreach($storageList as $storage) {
            if(!is_numeric($storage)){
                $op = '=';
                if(substr($storage, 0, 1) == "-") {
                    $op = '<>'; 
                    $storage = substr($storage, 1);
                }
                if(Storages::IsExists($storage)) {
                    $storage = new Storage($storage);
                    $storage = $storage->id;
                    if($op == "=")
                    	$criteria["links"] .= " or (link_child_storage_id ".$op." ".$storage." and link_object_type=0)";
                    else
                    	$criteria["links"] .= " and (link_child_storage_id ".$op." ".$storage." and link_object_type=0)";
                }
                else {
                    $storage = $core->mm->modules->$storage;
                    $storage = $storage->id;
                    if($op == "=")
                    	$criteria["links"] .= " or (link_child_storage_id ".$op." ".$storage." and link_object_type=1)";
                    else
                    	$criteria["links"] .= " and (link_child_storage_id ".$op." ".$storage." and link_object_type=1)";
                }
            }
            else {
                if($storage >= 0){
                                        $criteria["links"] .= " or link_child_storage_id = ".$storage." and link_object_type=0";
                }
                else{
                                        $criteria["links"] .= " and link_child_storage_id <> ".$storage." and link_object_type=0";
                }    
            }   
        }
        if(is_string($crit) && !is_empty($crit))
            $criteria["links"] .= " and ".$crit;
        if (!is_empty($criteria["links"])) {
            $criteria["links"] = "(". substr($criteria["links"], 4) . ")";
        }
        if(is_array($crit))
            $criteria = array_merge($criteria, $crit);        
        return $criteria;
    }
	function get_collection() { return $this->ToCollection(); }
	public function to_xml($withBranch = false){ return $this->ToXML($withBranch); }
	public function from_xml($el){
		$this->FromXML($el);
	}
}
?><?php
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
                $this->securitycache = @unserialize($this->securitycache);
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
        $data->add("notice_securitycache", serialize($this->securitycache));
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
?><?php
class CodeCollector {
	private $_corepath;
	private $_adminpath;
	private $_files;
	private $_code;
	private $_tables;
	public function __construct() {
		global $CORE_PATH, $ADMIN_PATH;
		$this->_corepath = $CORE_PATH;
		$this->_adminpath = $ADMIN_PATH;
		$this->_files = new ArrayList();
		$this->_code = new ArrayList();
		$this->_tables = new ArrayList();
	}
	public function __get($prop) {
		switch($prop) {
			case "tables":
				return $this->_tables;
			case "files":
				return $this->_files;
			case "codes":
				return $this->_codes;
		}
	} 
	public function Collect() {
		global $core;
		$includes = file_get_contents($this->_corepath."core.inc.php");
		preg_match_all("/include_once\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1])) {
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
		}
		preg_match_all("/include\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1]))
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
		preg_match_all("/require\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1]))
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
		preg_match_all("/require_once\(\"(.*)\"\);/", $includes, $matches);
		if(is_array($matches[1]))
			foreach($matches[1] as $m)
				$this->_files->Add($this->_corepath.$m);
		$adminfiles = $core->fs->ListFiles($this->_adminpath);
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath.$file->file);
		}
		$adminfiles = $core->fs->ListFiles($this->_adminpath."classes");
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath."classes/".$file->file);
		}
		$adminfiles = $core->fs->ListFiles($this->_adminpath."classes/lang");
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath."classes/lang/".$file->file);
		}
		$adminfiles = $core->fs->ListFiles($this->_adminpath."classes/scripts");
		foreach($adminfiles as $file) {
			$this->_files->Add($this->_adminpath."classes/scripts/".$file->file);
		}
		$tables = $core->dbe->Tables();
		foreach($tables as $table) {
			if(substr($table, 0, 4) == "sys_") {
				$query = $core->dbe->ExecuteReader("SHOW CREATE TABLE ".$table."")->Read();
				$name = "Create Table";
				$this->_tables->Add($query->$name);
			}
		}
	}
}
class Integrity {
	private $_collector;
	public function __construct() {
		$this->_collector = new CodeCollector();
	}
	public function Calc() {
		$md5s = new ArrayList();
		$this->_collector->Collect();
		foreach($this->_collector->tables as $table) {
			$md5s->Add(md5($table));
		}
		foreach($this->_collector->files as $file) {
			$md5s->Add(md5_file($file));
		}
		return md5($md5s->ToString(""));
	}
    public function createSchema() {
    }
}
?><?php
class Situation extends Object {
	public $profiler;
	public function __construct($obj = null) {
		parent::__construct($obj, "situation_");
	}
	public function __set($prop, $value){
		parent::__set($prop, $value);
		$this->profiler->user->Save();
	}
}
class Profiler extends Collection {
	public $user;
	public function __construct($user) {
		parent::__construct();
		$this->user = $user;
	}
    public function __get($prop) {
        if(!$this->Exists($prop)) {
            $this->AddSituation($prop);
        }
        $v = parent::__get($prop);
        if(!($v instanceof Situation)) {
            $this->Delete($prop);
            $this->AddSituation($prop);
        }
        return parent::__get($prop);
    }
	public function AddSituation($name) {
		$sit = parent::Add($name, new Situation());
		$sit->profiler = $this;
		$sit->name = $name;
        return $sit;
	}
	public function Delete($name) {
		parent::Delete($name);
		$this->user->Save();
	}
	public function Merge($from) { deprecate(); }
    public function Clear() {
        parent::Clear();
        $this->user->Save();
    }
}
?><?php
    class XMLNode {
        private $_document;
        private $_node;
        public function __construct(DOMNode $node, DOMDocument $dom = null) {
            $this->_node = $node;
            $this->_document = $dom;
        }
        public static function Load($xmlFile, $isFile = true) {
            $dom = new DOMDocument('1.0', 'utf-8');
            if(!$isFile)
                $dom->loadXML($xmlFile);
            else {
                if(file_exists($xmlFile))
                    $dom->load($xmlFile);
                else
                    throw new Exception('File '.$xmlFile.' does not exists');
            }
            return new XMLNode($dom->documentElement, $dom);
        }
        public static function LoadNode($xmlString, $encoding = 'utf-8') {
            $dom = new DOMDocument('1.0', $encoding);
            $dom->loadXML('<'.'?xml version="1.0" encoding="'.$encoding.'"?'.'>'.$xmlString);
            return new XMLNode($dom->documentElement, $dom);
        }        
        public function Save($filename = "") {
            if(!is_empty($filename))
                $this->_document->save($filename);
            else
                return $this->_document->saveXML();
        }
        public function __get($property) {
            switch(strtolower($property)) {
                case 'type':
                    return $this->_node->nodeType;
                case 'value':
                    return $this->_node->nodeValue;
                case 'name':
                    return $this->_node->nodeName;
                case 'data':
                    return $this->_node->data;
                case 'attributes':
                    if(!is_null($this->_node->attributes))
                        return new XMLNodeAttributeList($this->_node->attributes);
                    else
                        return null;
                case 'parent':
                    return new XMLNode($this->_node->parentNode, $this->_document);
                case 'nodes':
                    if($this->_node->childNodes)
                        return new XMLNodeList($this->_node->childNodes, $this->_document);
                    else
                        return null;
                case 'elements':                                                
                    return $this->Query('./child::*', true);
                case 'texts':                                                
                    return $this->Query('./child::text()');
                case 'document':
                    return $this->_document;
                case 'raw':
                    return $this->_node;
                case 'xml':
                    return $this->_document->saveXML($this->_node);
                default:
                    $item = $this->Item($property);
                    if(is_null($item)) {
                        $items = $this->getElementsByName($property);
                        if($items->count > 0)
                            $item = $items->first;
                        else {
                            if($this->type == 1)
                                $item = $this->attributes->$property;
                        }
                    }
                    return $item;
            }
            return null;
        }
        public function Item($name) {
            $list = $this->Items($name);
            if($list->count > 0)
                return $list->first;
            else
                return null;
        }
        public function Items($name) {
            return $this->Query('./child::'.$name);
        }
        public function Parents($name) { 
            return $this->Query('./ancestor::'.$name);
        }
        public function Append($nodes) {
            if($nodes instanceof XMLNode) {
                $this->_node->appendChild($this->_document->importNode($nodes->raw, true));
            }
            else if($nodes instanceof XMLNodeList) {
                foreach($nodes as $node) {
                    $this->_node->appendChild($this->_document->importNode($node->raw, true));
                }
            }
        }
        public function ReplaceTo($node) {
            $_node = $node->raw;
            $_node = $this->_document->importNode($_node, true);
            $this->_node->parentNode->replaceChild($_node, $this->_node);
            $this->_node = $_node;
        }
        public function getElementsByName($name) {
            return $this->Query('./child::*[@name="'.$name.'"]', true);
        }
        public function Query($query, $returnAsNamedMap = false) {
            $xq = new XMLQuery($this, $returnAsNamedMap);
            return $xq->query($query);
        }  
    }
    class XMLNodeListIterator implements Iterator {
        private $_class;
        private $_current = 0;
        public function __construct($class = null) {
            $this->_class = $class;
        }
        public function rewind() {
            $this->_current = 0;
            return $this->_current;
        }
        public function current() {
            if($this->valid())
                return $this->_class->Item($this->_current);
            else    
                return false;
        }
        public function key() {
            return $this->_current;
        }
        public function next() {
            $this->_current++;
            if($this->valid())
                return $this->_class->Item($this->_current);
            else    
                return false;
        }
        public function valid() {
            return $this->_current >= 0 && $this->_current < $this->_class->count;
        }
    } 
    class XMLAttribute {
        private $_data;
        public function __construct(DOMNode $data) {
            $this->_data = $data;
        }
        public function __get($property) {
            switch(strtolower($property)) {
                case 'value':
                    return $this->_data->nodeValue;
                case 'name':
                    return $this->_data->nodeName;
                case 'type':
                    return $this->_data->nodeType;
            }
            return null;
        }
    }
    class XMLNodeAttributeList implements IteratorAggregate {
        private $_data;
        private $_count;
        public function __construct(DOMNamedNodeMap $xmlattributes) {
            $this->_data = $xmlattributes;
            $this->_count = 0;
            foreach($xmlattributes as $xa) $this->_count++;
        }  
        public function getIterator() {
            return new XMLNodeListIterator($this);
        }
        public function Item($index) {
            if(is_numeric($index))
                return $this->_data->item($index);
            else
                return $this->_data->getNamedItem($index);
        }
        public function __get($property) {
            switch(strtolower($property)) {
                case 'count':
                    return $this->_count;
                default: 
                    $attr = $this->_data->getNamedItem($property);
                    if(!is_null($attr))
                        return new XMLAttribute($this->_data->getNamedItem($property));
                    return null;
            }
        }
    }
    class XMLNodeList implements IteratorAggregate {
        private $_data;
        private $_document;
        public function __construct(DOMNodeList $nodelist, DOMDocument $dom) {
            $this->_data = $nodelist;
            $this->_document = $dom;
        }
        public function getIterator() {
            return new XMLNodeListIterator($this);
        }
        public function Item($index) {
            return new XMLNode($this->_data->item($index), $this->_document);
        }
        public function __get($property) {
            switch(strtolower($property)) {
                case 'last':
                    return $this->Item($this->count-1);
                case 'first':
                    return $this->Item(0);
                case 'document':
                    return $this->_document;
                case 'count':
                    return $this->_data->length;
            }
            return null;
        }
    }
    class XMLNamedNodeList extends Hashtable {
        private $_document;
        public function __construct(DOMNodeList $nodelist, DOMDocument $dom) {
            $this->_document = $dom;
            $data = array();
            foreach($nodelist as $node) {
                $data[$node->nodeName] = $node;
            }
            parent::__construct($data);
        }
        public function Item($key) {
            return new XMLNode(parent::Item($key), $this->_document);
        }
        public function ItemAt($index) {             
            return new XMLNode(parent::ItemAt($index), $this->_document);
        }
        public function __get($property) {
            switch(strtolower($property)) {
                case 'document':
                    return $this->_document;
                default:
                    return parent::__get($property);
            }
        }
    }
    class XMLQuery {
        private $_contextNode;
        private $_operator;
        private $_returnAsNamedMap;
        public function __construct(XMLNode $node, $returnAsNamedMap = false) {
            $this->_returnAsNamedMap = $returnAsNamedMap;
            $this->_contextNode = $node;
            $this->_operator = new DOMXPath($this->_contextNode->document);
        }
        public function query($xpathQuery) {
            if($this->_returnAsNamedMap)
                return new XMLNamedNodeList($this->_operator->query($xpathQuery, $this->_contextNode->raw), $this->_contextNode->document);
            return new XMLNodeList($this->_operator->query($xpathQuery, $this->_contextNode->raw), $this->_contextNode->document);
        }
    }
    class XMLResource extends XMLNode {
        public function __construct(DOMNode $node, DOMDocument $dom = null) {
            parent::__construct($node, $dom);
        }
        public static function Load($xmlFile, $isFile = true) {
            $dom = new DOMDocument();
            if(!$isFile)
                $dom->loadXML($xmlFile);
            else
                $dom->load($xmlFile);
            return new XMLResource($dom->documentElement, $dom);
        }
        public function __get($property) {
            switch(strtolower($property)) {
                case 'attributes':
                    return parent::__get('attributes');
                case 'document':
                    return parent::__get('document');
                case 'raw':
                    return parent::__get('raw');
                case 'count':
                    return parent::__get('count');
                default:
                    return $this->Item($property);
            }
        }
        public function Item($name) {
            $elements = $this->Query("./descendant::*[@name='".$name."']");
            if($elements->count == 0)
                return '';
            $data = '';
            $element = $elements->first;
            if($element->attributes->value)
                $data = ContentProvider::Parse($element->attributes->value->value);
            else {
                $nodes = $element->raw->childNodes;
                $ret = '';
                foreach($nodes as $n) {
                    $d = trim($n->data);
                    if(!empty($d))
                        $ret .= $n->data;
                }
                $data = $ret;
            }
            return $data;
        }
    }
?>
<?php
class ToolbarButton {
	public $postbackform;
	public $name;
	public $image;
	public $text;
	public $alignment;
	public function __construct($name, $image = "", $text = "", $alignment = TOOLBAR_BUTTON_LEFT) {
		$this->name = $name;
		$this->image = $image;
		$this->text = $text;
		$this->alignment = $alignment;
	}
	public function Render() {
		return "Please derive the class and implement this function";
	}
}
class ToolbarImageButton extends ToolbarButton {
	public $command;
	public $method;
	public $section;
	public $action;
	public $message;
	public $movetopage;
	public $floating;
	public $width;
	public $height;
	public $resizablel;
	public $except;
	public function __construct($name, $image, $text, $alignment = TOOLBAR_BUTTON_LEFT, $command = null, $method = null, $section = null, $action = null, $message = null, $movetopage = 1) {
		parent::__construct($name, $image, $text, $alignment);
		$this->command = $command;
		$this->method = $method;
		$this->section = $section;
		$this->action = $action;
		$this->message = $message;
		$this->movetopage = $movetopage;
	}
	public function Render() {
		return '
			<div class="toolbar-button'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'">
				<a title="'.$this->text.'" href="'.$this->postbackform->CreatePostBack($this->command, $this->section, $this->action, $this->method, $this->message, $this->movetopage).'">'.$this->postbackform->iconpack->CreateIconImage($this->image, $this->text, 28, 28).'</a>
			</div>';
	}
}
class ToolbarImageFButton extends ToolbarImageButton  {
	public $floating;
	public $width;
	public $height;
	public $resizable;
	public $except;
	public function __construct($name, $image, $text, $alignment = TOOLBAR_BUTTON_LEFT, $command = null, $method = null, $section = null, $action = null, $message = null, $width = 600, $height = 400, $resizable = true, $except = null) {
		parent::__construct($name, $image, $text, $alignment, $command, $method, $section, $action, $message, 0);
		$this->width = $width;
		$this->height = $height;
		$this->resizable = $resizable;
		$this->except = $except;
	}
	public function Render() {
		return '
			<div class="toolbar-button'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'"><a title="'.$this->text.'" href="'.$this->postbackform->CreateFloatingPostBack($this->command, $this->section, $this->action, $this->method, $this->message, $this->width, $this->height, $this->resizable, $this->except).'">'.$this->postbackform->iconpack->CreateIconImage($this->image, $this->text, 28, 28).'</a></div>
		';
	}
}
class ToolbarComboButton extends ToolbarButton  {
    public $items;
    public $inputname;
    public $attributes;
    public $change;
    public function __construct($name, $items, $alignment = TOOLBAR_BUTTON_LEFT, $inputname, $attributes, $change = null) {
        parent::__construct($name, '', '', $alignment);
        $this->items = $items;
        $this->inputname = $inputname;
        $this->attributes = $attributes;
        $this->change = $change;
    }
    public function Render() {
        $ret = '
            <div class="toolbar-button'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'">
                <select name="'.$this->inputname.'" "'.$this->attributes.' '.(!is_empty($this->change) ? 'onchange="javascript: '.$this->change.'"' : '').'>
        ';
                foreach($this->items as $value) {
                    $ret .= '<option value="'.$value['value'].'">'.$value['text'].'</option>';
                }
        $ret .= '
                </select>
            </div>
        ';
        return $ret;
    }
}
class ToolbarTextboxButton extends ToolbarButton  {
    public $items;
    public $inputname;
    public $attrs;
    public $css;
    public function __construct($name, $value, $alignment = TOOLBAR_BUTTON_LEFT, $inputname = '', $attrs = '', $css = '') {
        parent::__construct($name, '', '', $alignment);
        $this->value = $value;
        $this->inputname = $inputname;
        $this->attrs = $attrs;
        $this->css = $css;
    }
    public function Render() {
        $ret = '
            <div class="toolbar-button tbtext'.($this->alignment == TOOLBAR_BUTTON_RIGHT ? '-right' : '').'">
                <input type="text" name="'.$this->inputname.'" "'.$this->attrs.' '.(!is_empty($this->css) ? 'style="'.$this->css.'"' : '').' value="'.$this->value.'" />
            </div>
        ';
        return $ret;
    }
}
class ToolbarPagerButton extends ToolbarButton {
	public $page;
	public $pagesize;
	public $affected;
	public $link;
	public function __construct($name, $page, $pagesize, $affected, $link) {
		parent::__construct($name, "", "", TOOLBAR_BUTTON_LEFT);
		$this->page = $page;
		$this->pagesize = $pagesize;
		$this->link = $link;
		$this->affected = $affected;
	}
	public function Render() {
		return '<div class="toolbar-free-content tbpager">'.$this->postbackform->Pager($this->page, $this->pagesize, $this->affected, $this->link, false).'</div>';
	}
}
class ToolbarSeparator extends ToolbarButton {
	public function __construct($name) {
		parent::__construct($name);
		$this->name = $name;
	}
	public function Render() {
		return '
				<!-- Tool bar item: separator -->
				<div class="tbseparator"><img src="images/new/spacer1x1.gif" width="1" height="1"></div>
		';
	}
}
class ToolbarLabel extends ToolbarButton {
    private $_text;
    public function __construct($name, $text) {
        parent::__construct($name);
        $this->name = $name;
        $this->_text = $text;
    }
    public function Render() {
        return '
                <div class="tblabel">'.$this->_text.'</div>
        ';
    }
}
class ToolbarButtonList extends Collection {
	private $postback;
	public function __construct($postback) {
		$this->postback = $postback;
		parent::__construct();
	}
	public function Add($button) {
		if($button instanceof ToolbarButton) {
			$button->postbackform = $this->postback;
			parent::Add($button->name, $button);
		}
		else {
			die("Error creating toolbar");
		}
	}
	public function Delete($button) {
		if(is_string($button))
			parent::Delete($button);
		else if($button instanceof ToolbarButton) {
			parent::Delete($button->name);
		}
	}
}
class Toolbar {
	private $_buttons;
	private $_postback;
	public function __construct($postbackform) {
		$this->_postback = $postbackform;
		$this->_buttons = new ToolbarButtonList($this->_postback);
	}
	public function __get($prop) {
		switch(strtolower($prop)) {
			case "buttons":
				return $this->_buttons;
			default:
				return null;
		}
	}
	public function Render($outto = null) {
		$tools = $this->_buttons;
		$args = $this->_postback->DispatchEvent("postbackform.createtoolbar", Hashtable::Create("buttons", $tools));
		if($args)
			if(@$args->buttons)
				$this->_buttons = $args->buttons;
		$ret = '
				<div class="toolbar">
					<div class="toolbar-left"></div>
		';
		foreach($this->_buttons as $button)
			$ret .= $button->Render();
		$ret .= '</div>';
		if($outto)
			$this->_postback->Out($outto, $ret, OUT_AFTER);
		return $ret;
	}
}
?><?php
class CommandBarContainer {
	public $name;
	public $content;
	public $postback;
	public function __construct($name, $content = "") {
		$this->name = $name;
		$this->content = $content;
	}
	public function Render() {
		return '<td>'.$this->content.'</td>';
	}
}
class CommandBarPopupContainer extends CommandBarContainer {
	public function __construct($name, $title, $content = "", $size = null, $openUp = false, $openLeft = false) {
		parent::__construct($name);
		$popup = new Popup($name, $title, $content, $size, $openUp, $openLeft);
		$this->content = $popup->Render();
	}
}
class CommandBarFilterPopupContainer extends CommandBarContainer {
	public function __construct($name, $filter, $lang, $command, $openUp = false, $openLeft = false) {
		parent::__construct($name);
		$popup = new FilterPopup($name, $filter, $lang, $command, $openUp, $openLeft);
		$this->content = $popup->Render();
	}
}
class CommandBarSortPopupContainer extends CommandBarContainer {
	public $popup;
	public function __construct($name, $fld_name, $fld_order, $pagerargs, $lang, $storages, $postbackto, $openUp = false, $openLeft = false) {
		parent::__construct($name);
		$this->popup = new SortPopup($name, $fld_name, $fld_order, $pagerargs, $lang, $storages, $postbackto, $openUp, $openLeft);
		$this->content = $this->popup->Render();
	}
}
class CommandBarLabelContainer extends CommandBarContainer {
	public function __construct($name, $label) {
		parent::__construct($name, $label);
	}
}
class CommandBarButtonContainer extends CommandBarContainer {
	public function __construct($name, $type, $label, $command, $method = "post", $className = COMMANDBAR_BUTTON_LONG) {
		parent::__construct($name, $label);
		$this->content = "<input type=\"".$type."\" name=\"".$this->name."\" value=\"".$label."\" onclick=\"return PostBack('".$command."', 'post')\" class=\"".($className == COMMANDBAR_BUTTON_LONG ? "small-button-long" : "small-button")."\" />";
	}
}
class CommandBarJButtonContainer extends CommandBarContainer {
	public function __construct($name, $type, $label, $action = "", $className = COMMANDBAR_BUTTON_LONG) {
		parent::__construct($name, $label);
		$this->content = "<input type=\"".$type."\" name=\"".$this->name."\" value=\"".$label."\" onclick=\"".$action."\" class=\"".($className == COMMANDBAR_BUTTON_LONG ? "small-button-long" : "small-button")."\" />";
	}
}
class CommandBarStoragesListContainer extends CommandBarContainer {
	public $storages, $storage, $postbackto, $disabled;
 	public function __construct($name, $storages, $storage, $postbackto, $disabled = false) {
		$this->name = $name;
		$this->storages = $storages;
		$this->storage = $storage; 
		$this->postbackto = $postbackto;
		$this->disabled = $disabled;
	}
	public function Render() {
		$this->content = "<select name=".$this->name." id=".$this->name." class=select-box style='width:120px;' onchange=\"return PostBack('".$this->postbackto."', 'get')\" ".($this->disabled ? " disabled" : "").">";
		foreach($this->storages as $st)
			$this->content .= "<option value='".$st->id."' ".((!is_null($this->storage) ? $this->storage->id == $st->id ? "selected" : "" : "")).">".$st->name."</option>";
		$this->content .= "<option value='-1' ".(is_null($this->storage) ? "selected" : "").">".$this->postback->lang->modules_title."</option>";
		$this->content .= "</select>";
		return parent::Render();		
	}
}
class CommandBarListContainer extends CommandBarContainer {
    public $list, $selected, $postbackto, $disabled;
     public function __construct($name, $list, $selected, $postbackto, $disabled = false) {
        $this->name = $name;
        $this->list = $list;
        $this->selected = $selected;
        $this->postbackto = $postbackto;
        $this->disabled = $disabled;
    }
    public function Render() {
        $this->content = "<select name=".$this->name." id=".$this->name." class=select-box style='width:120px;' onchange=\"return PostBack('".$this->postbackto."', 'get')\" ".($this->disabled ? " disabled" : "").">";
        foreach($this->list as $item)
            $this->content .= "<option value='".$item['value']."' ".((!is_null($this->selected) ? $this->selected == $item['value'] ? "selected" : "" : "")).">".$item['text']."</option>";
        $this->content .= "</select>";
        return parent::Render();        
    }
}
class CommandBarNodesTreeContainer extends CommandBarContainer {
 	public function __construct($name, $branch, $selectedFolder, $postbackto) {
		$this->name = $name;
		$this->content = '
				<select name="sf_id" class="select-box" style="width:200px" onchange="javascript: PostBack(\''.$postbackto.'\', \'get\', null, null, null, createArray(\'fld_name\', \'\', \'fld_order\', \'\'));">
			';
			foreach($branch as $folder) {
				$pad = intval($folder->level-1)*4;
				$selected = $folder->id == $selectedFolder->id ? ' selected' : '';
		$this->content .= '
					<option value="'.$folder->id.'" '.$selected.'>'.str_repeat("&nbsp;", $pad).$folder->description.'</option>
		';
			}
		$this->content .= '
				</select>
		';
	}
}
class CommandBarBlobsCategoriesContainer extends CommandBarContainer {
	public $onchange;
	public $categories;
	public $selectedCategory;
	public function __construct($name, $categories, $selectedCategory, $onchange = "this.form.submit();") {
		parent::__construct($name);
		$this->onchange = $onchange;
		$this->categories = $categories;
		$this->selectedCategory = $selectedCategory;
	}
	public function Render() {
		$this->content = '
						<select name="'.$this->name.'" onChange="'.$this->onchange.'">
							<option value="-1"></option>
		';
		$this->content .= $this->postback->RenderBlobCategoriesOptions($this->categories, $this->selectedCategory);
		$this->content .= '
						</select>
		';		
		return parent::Render();
	}
}
class CommandBarFileContainer extends CommandBarContainer {
	public $onchange;
	public $startPath;
	public $selectedPath;
	public function __construct($name, $startPath, $selectedPath, $onchange = "this.form.submit();") {
		parent::__construct($name);
		$this->onchange = $onchange;
		$this->startPath = $startPath;
		$this->selectedPath = $selectedPath;
	}
	public function Render() {
		$this->content = '
						<select name="'.$this->name.'" onChange="'.$this->onchange.'">
							<option value="">..</option>
		';
		$this->content .= $this->RenderDirectories();
		$this->content .= '
						</select>
		';		
		return parent::Render();
	}
	public function RenderDirectories($path = "", $level = 0) {
		global $core;
		$ret = '';
		$dirs = $core->fs->list_dir($this->startPath.$path);
		foreach($dirs as $dir) {
			$selected = $this->selectedPath == $this->startPath.$path.$dir.'/' ? ' selected="selected"' : '';
			$ret .= '<option value="'.$this->startPath.$path.$dir.'/" '.$selected.'>'.str_repeat("&nbsp;&nbsp;&nbsp;", $level).$dir.'</option>';
			$ret .= $this->RenderDirectories($path.$dir.'/', $level+1);
		}
		return $ret;
	}
}
class CommandBarBlobsSortContainer extends CommandBarContainer {
	public function __construct($name, $sort, $onchange = "this.form.submit();") {
		parent::__construct($name);
		$this->content = '
				<select name="sort" onChange="this.form.submit();">
					<option value="blobs_id" '.($sort == "blobs_id" ? "selected" : "").'>Id</option>
					<option value="blobs_filename" '.($sort == "blobs_filename" ? "selected" : "").'>Filename</option>
					<option value="blobs_length" '.($sort == "blobs_length" ? "selected" : "").'>Filesize</option>
					<option value="blobs_alt" '.($sort == "blobs_alt" ? "selected" : "").'>Alt</option>
				</select>
		';		
	}
}
class CommandBarTabContainer extends CommandBarContainer {
    public function __construct($name, $buttons) {
        parent::__construct($name);
        $this->content = '<div class="tab_container">';
        foreach($buttons as $value) {
                        $this->content .= '<input type="button" class="tab_button'.($value[2] ? ' selected' : '').'" onclick="'.$value[1].'" value="'.$value[0].'"'.($value[2] ? ' disabled="disabled"' : '').' />';
        }
        $this->content .= '</div>';
    }
}
class CommandBarContainerList extends Collection {
	private $postback;
	public function __construct($postback) {
		$this->postback = $postback;
		parent::__construct();
	}
	public function Add($container) {
		if($container instanceof CommandBarContainer) {
			$container->postback = $this->postback;
			parent::Add($container->name, $container);
		}
		else {
			die("Error creating commandbar");
		}
	}
	public function Delete($container) {
		if(is_string($container))
			parent::Delete($container);
		else if($container instanceof CommandBarContainer) {
			parent::Delete($container->name);
		}
	}
}
class CommandBar {
	private $_postback;
	private $_containers;
	public function __construct($postback) {
		$this->_postback = $postback;
		$this->_containers = new CommandBarContainerList($this->_postback);
	}
	public function __get($prop) {
		switch(strtolower($prop)) {
			case "containers":
				return $this->_containers;
			default:
				return null;
		}
	}
	public function Render($outto = null) {
		$args = $this->_postback->DispatchEvent("postbackform.createcommandbar", Hashtable::Create("containers", $this->_containers));
		if($args)
			if(@$args->containers)
				$this->_containers = $args->containers;
        $ret = '';
        if($this->_containers->Count() > 0) {
		    $ret .= '
			    <div class="commandbar-container"><table cellpadding=0 cellspacing=0 border=0 class="commandbar">
				    <tr>
		    ';
		    foreach($this->_containers as $container)
			    $ret .= $container->Render();
		    $ret .= '
				    </tr>
			    </table></div>
		    ';
        }
		if($outto)
			$this->_postback->Out($outto, $ret, OUT_AFTER);
		return $ret;
	}
}
?><?php
class LogItem {
	public $type;
	public $message;
	public function __construct($type, $message) {
		$this->type = $type;
		$this->message = $message;
	}
	public function Render() {
		return '<tr><td class="'.($this->type == "warning" ? "green" : ($this->type == "error" ? "red" : "")).'">'.$this->message.'</td></tr>';
	}
}
class LogView extends ArrayList {
	protected $_postback;
	public function __construct($postback) {
		$this->_postback = $postback;
	}
	public function Add(LogItem $logItem) {
		parent::Add($logItem);
	}
	public function Render($outto = null) {
		$ret = '<table class="log_viewer">';
		foreach($this as $item) {
			$ret .= $item->Render();
		}
		$ret .= '</table>';
		if($outto)
			$this->_postback->Out($outto, $ret, OUT_AFTER);
		return $ret;
	}
}
?>
<?
class Editor extends IEventDispatcher {
    public $dta;
    public $postback;
    public $state = EDITOR_NORMAL;
    public $action = EDITOR_ACTION_NONE;
    public $subactionfield = "";
    public $parentpostback = null;
    public $fields;
    public $fieldgroups;
    public $currentGroup;
    public $controls = null;
    public $name = null;
    public $withCommandBar = false;
    public $texts;
    public $blob_operations;
    public function __construct($dta, $postback_form, $name = null) {
        $this->dta = $dta;
        $this->postback = $postback_form;
        $this->RegisterEvent("editor.loading");
        $this->RegisterEvent("editor.loaded");
        $this->RegisterEvent("editor.validating");
        $this->RegisterEvent("editor.validated");
        $this->RegisterEvent("editor.rendering");
        $this->RegisterEvent("editor.rendered");
        $this->RegisterEvent("editor.commandbar.render");
        $this->RegisterEvent("editor.scripts.render");
        $this->RegisterEvent("editor.control.create");
        $this->RegisterEvent("editor.control.created");
        $this->RegisterEvent("editor.control.validating");
        $this->RegisterEvent("editor.control.validated");
        $this->RegisterEvent("editor.control.rendering");
        $this->RegisterEvent("editor.control.rendered");
        $this->RegisterEvent("editor.get_request");
        $args = $this->DispatchEvent("editor.loading", Hashtable::Create("data", $dta, "storage", $dta->storage));
        if(@$args->data)
            $dta = $args->data;
        $this->name = $name;
        if(is_null($this->name))
            $this->name = "f".str_random(10);
        $this->state = EDITOR_NORMAL;
        $this->controls = new Collection();
        $fields = null;
        if($this->dta instanceof Publication) {
            $fields = $this->dta->datarow->storage->fields;
        }
        else {
            $fields = $this->dta->storage->fields;
        }
        $this->fields = $fields;
        $this->fieldgroups = new ArrayList();
        if($this->dta instanceof Publication) {
            $this->fieldgroups = $this->dta->datarow->storage->fieldgroups;
        }
        else {
            $this->fieldgroups = $this->dta->storage->fieldgroups;
        }        
        $this->currentGroup = "";
        if($this->rq("currentGroup"))
            $this->currentGroup = $this->rq("currentGroup");
        if($this->rq("r_action"))
            $this->action = $this->rq("r_action");
        if($this->fieldgroups->Count() > 1) {
            if($this->currentGroup == "")
                $this->currentGroup = $this->fieldgroups->Item(0)->Item(0)->group;
            $this->fields = $this->fieldgroups->Item($this->currentGroup);
            foreach($this->fields as $field) {
                $this->controls->add($field->field, new EditorField($this, $field));
            }
        }
        else {
            foreach($fields as $field) {
                $this->controls->add($field->field, new EditorField($this, $field));
            }
        }
        $this->texts =  array(
            "save" => "Save",
            "cancel" => "Cancel",
            "apply" => "Apply",
            "subtable" => "Edit subtable",
            "remove" => "Remove"
        );
        $this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
        $this->file_operations = array("handlerObject" => $this, "function" => "getFileOperations");
        $this->DispatchEvent("editor.loaded", Hashtable::Create());
    }
    function ReCreateControls() {
        if(!is_null($this->controls))
            $this->controls->Clear();
        else
            $this->controls = new Collection();
        $fields = null;
        if($this->dta instanceof Publication) {
            $fields = $this->dta->datarow->storage->fields;
        }
        else {
            $fields = $this->dta->storage->fields;
        }
        $this->fields = $fields;
        foreach($fields as $field) {
            $this->controls->add($field->field, new EditorField($this, $field));
        }
    }    
    public function storage() {
        if($this->dta instanceof Publication)
            return $this->dta->datarow->storage;
        else {
            return $this->dta->storage;
        }
    }
    public function rq($name) {
        $n = $this->name."_".$name;
        $v = $this->postback->$n;
        if(is_serialized(base64_decode($v)))
            return base64_decode($v);
        return $v;
    }
    public function valueOf($name) {
        $v = null;
        if($this->controls instanceof Collection)
            if($this->controls->Exists($name))
                $v = $this->controls->$name->valueOf();
        if(!is_null($v))
            return $v;
        if(!is_null($this->rq($name)))
            $value = $this->rq($name);
        else {
            if($this->dta instanceof Publication)
                $value = $this->dta->datarow->$name;
            else {
                $value = $this->dta->$name;
            }
        }
        if (is_string($value) && $value == "{null}")
            $value = null;
        return $value;
    }
    public function get_request() {
        $fields = $this->storage()->fields;
        $values = new collection();
        foreach($fields as $field) {
            $values->add($this->dta->storage->fname($field->field), $this->valueOf($field->field));
        }
        $args = $this->DispatchEvent("editor.get_request", Hashtable::Create("storage", $this->dta->storage, "data", $values));
        if(@$args->data)
            $values = @$args->data;
        return $values;
    }
    public function Validate() {
        $this->state = EDITOR_VALIDATING;
        foreach($this->controls as $control) {
            $control->Validate();
        }
        if($this->state != EDITOR_ERROR)
            $this->state = EDITOR_NORMAL;
    }
    public function Render() {
        $this->state = EDITOR_RENDERING;
        $ret = "";
        $ret .= $this->RenderScripts();
        $ret .= $this->RenderContent();
        $this->state = EDITOR_NORMAL;
        return $ret;
    }
    public function TransferPostVars() {
        $fields = $this->storage()->fields;
        $ret = "";
        $name = $this->name."_postback";
        foreach($fields as $field) {
            if($this->currentGroup != $field->group) {
                $v = $this->valueOf($field->field);
                if(is_object($v)) {
                    if($v instanceOf DataRow) {                         $lookup = $field->SplitLookup();
                        $v = $v->{$lookup->id};
                    }
                    else {
                        if($field->type == "multiselect")
                            $v = join(",", $v->Keys());
                        else {
                            if(method_exists($v, "ToString"))
                                $v = $v->ToString();
                            else
                                $v = "";
                        }
                    }
                }
                if(is_serialized($v))
                    $v = base64_encode($v);                
                $ret .= $this->postback->SetPostVar($this->name."_".$field->field, $v);
            }
        }
        return $ret;
    }
    public function RenderScripts() {
        $output = '
                function changeMethod(method, obj) {
                    obj.form.method = method;
                }
                function setAction(obj, action, subactionfield, message) {
                    var b = true;
                    if(message)
                        b = window.confirm(message)
                    if(b) {
                        obj.form.elements[\''.$this->name.'_r_action\'].value = action;
                        obj.form.elements[\''.$this->name.'_subactionfield\'].value = subactionfield;
                        obj.form.method = "post";
                        obj.form.submit();
                    }
                    return false;
                }
        ';
        $args = $this->DispatchEvent("editor.scripts.render", Hashtable::Create("output", $output));
        if(@$args->output)
            $output = @$args->output;
        return '
            <script language="javascript">
            '.$output.'
            </script>
        ';
    }
    public function RenderEditorBar() {
        if($this->fieldgroups->Count() > 1) {
            $buttons = array();
            foreach($this->fieldgroups as $key => $value) {
                if($value->Item(0) instanceOf Field)
                    $buttons[] = array($value->Item(0)->group, 'javascript: changeMethod(\'post\', this); this.form.elements[\''.$this->name.'_currentGroup\'].value=\''.$value->Item(0)->group.'\'; this.form.submit();', ($this->currentGroup == $value->Item(0)->group ? true : false));
            }
            $cmd = new CommandBar($this->postback);
            $cmd->Containers->Add(new CommandBarLabelContainer("label0", "&nbsp;"));
            $cmd->Containers->Add(new CommandBarLabelContainer("label1", "Группы"));
            $cmd->Containers->Add(new CommandBarTabContainer("groups", $buttons));
            return $this->postback->SetPostVar($this->name."_currentGroup", $this->currentGroup).$cmd->Render();
        }
        else 
            return "";
    }
    public function RenderContent() {
        $ret = "";
        $ret .= '
            <input type="hidden" name="'.$this->name.'_r_action" value="none" >
            <input type="hidden" name="'.$this->name.'_subactionfield" value="" >
            <table width="100%" border="0" class="content-table" id="'.$this->name.'_table" cellspacing="0" cellpadding="0">
        ';
        $ret .= $this->TransferPostVars();
        $controls = '';
        $messages = "";
        foreach($this->controls as $control) {
            $controls .= $control->Render();
            if($control->error)
                $messages .= $control->field->name.'='.$control->message.'<br>';
        }
        if($messages != "")
            $ret .= '
                <!--editor row--><tr>
                    <td colspan="2">
                        <div class="warning">
                            <div class="warning-title">
                            You have an errors in your form<br>
                            Please check the fields marked with red box and try to recover value
                            </div>
                            '.$messages.'    
                        </div>
                    </td>
                </tr><!--editor row-->
            ';
        $ret .= $controls;
        $ret .= '
                <tr>
                    <td width="15%">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td height="50">
        ';
        if($this->withCommandBar)
            $ret .= $this->RenderCommandBar();
        $ret .= '
                    </td>
                </tr>
            </table>
            ';
        return $ret;
    }
    function RenderCommandBar() {
        $cmd = array();
        $cmd[] = array('button', $this->texts["save"], $this->name.'_save', 'javascript: return setAction(this, \'save\');');
        $cmd[] = array('button', $this->texts["cancel"], $this->name.'_cancel', 'javascript: return setAction(this, \'cancel\');');
        $cmd[] = array('button', $this->texts["apply"], $this->name.'_apply', 'javascript: return setAction(this, \'apply\');');
        $args = $this->DispatchEvent("editor.commandbar.render", Hashtable::Create("cmd", $cmd));
        if(@$args->cmd)
            $cmd = @$args->cmd;
        $output = '
            <table>
                <tr>
            ';
        foreach($cmd as $c) {
            if($c[0] == 'button') {
                $output .= '
                    <td>
                        <input type="submit" name="'.$c[2].'" value="'.$c[1].'" class="small-button-long" onclick="'.$c[3].'">
                    </td>
                ';
            }
            elseif($c[0] == 'html') {
                $output .= '
                    <td>
                        '.$c[1].'
                    </td>
                ';
            }
        }
        $output .= '
                </tr>
            </table>
            ';
        return $output;
    }
    function getBlobOperations($operation, $prefix, $field) {
        switch($operation) {
            case "add":
                return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle='.$prefix."_".$field->field.'_addBlob_complete';
                break;
            case "edit":
                return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle='.$prefix."_".$field->field.'_addBlob_complete&edit=';
                break;
            case "select":
                return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler='.$prefix."_".$field->field.'_addBlob_complete';
                break;
        }
    }
    function getFileOperations($operation, $prefix, $field) {
        switch($operation) {
            case "select":
                return 'floating.php?postback_section=publications&postback_action=files&postback_command=select&handler='.$prefix."_".$field->field.'_selectFile_complete';
                break;
        }
    }
}
class EditorField extends IEventDispatcher {
    public $editor;
    public $field;
    public $message;
    public $error = false;
    public $control;
    public function __construct($editor, $field) {
        $this->editor = $editor;
        $this->field = $field;
        $this->RegisterEvent("editor.control.initializing");
        $field = $this->field->field;
        $value = $this->editor->valueOf($field);
        if (is_null($value))
            if(!is_empty($this->field->default))
                $value = $this->field->default;
        $prefix = $this->editor->name;
        if($this->field->onetomany != "")
            $controlname = 'MultilinkFieldExControl';    
        else if($this->field->lookup != "" && $this->field->type != "multiselect")
            $controlname = 'LookupExControl';    
        else
            $controlname = $this->field->type.'ExControl';
        $args = $this->DispatchEvent("editor.control.initializing", Hashtable::Create("classname", $controlname, "field", $this->field));
        if(@$args->classname)
            $controlname = $args->classname;
        $controlname = str_replace(" ", "", $controlname);
        $this->control = new $controlname($prefix."_".$this->field->field, $value, $this->field->required, new Collection(array('editorObject' => $this->editor)));
        $this->control->values = $this->field->values;
        $this->control->lookup = $this->field->SplitLookup();
        $this->control->multilink = $this->field->onetomany;
        $this->control->field = $this->field;
        $this->control->args->Add("editor", $this->editor->name);
        $this->control->args->Add("field", $this->field->field);
        $this->control->args->Add("texts", $this->editor->texts);
        $this->control->args->Add("type", $this->field->type);
        $this->DispatchEvent("editor.control.creating", Hashtable::Create());
    }    
    function valueOf() {
        return $this->control->valueOf();
    }
    public function Validate($control = null) {
        global $core;
        $args = $this->DispatchEvent("editor.control.validating", Hashtable::Create("control", $this->control));
        if(@$args->cancel) {
            if(@$args->error) {
                $this->error = @$args->message;
                $this->editor->state = EDITOR_ERROR;
            }
            return;
        }
        $field = $this->field->field;
        $value = $this->editor->valueOf($field);
        $prefix = $this->editor->name;
        $this->error = !$this->control->Validate();
        $this->message = $this->control->message;
        if($this->error)
            $this->editor->state = EDITOR_ERROR;
        $this->DispatchEvent("editor.control.validated", Hashtable::Create());
    }
    public function Render() {
        $ret = "";
        $args = $this->DispatchEvent("editor.control.rendering", Hashtable::Create("field", $this->field->field, "output", $ret));
        if(@$args->changed === true) {
            $ret = $args->output;
        }
        $prefix = $this->editor->name;
        $field = $this->field->field;
        $value = $this->editor->valueOf($field);
        $required = $this->field->required ? "<span style='color:#ff0000'>*</span>" : "";
        $ret .= '
            <tr>
                <td class="field" valign="top" width="15%" ondblclick="javascript: hideRow(this);" onselectstart="return false;" title="Double click to toogle (hide/show row)">
        ';
        $ret .=    $this->field->name.$required;
        $ret .= '
                </td>
                <td width="85%" class="value'.(!$this->control->isValid ? ' errorbox' : '').'">
                <a name="'.$prefix."_".$this->field->field.'_link"></a>
        ';
        $ret .= $this->control->Render().'<div class="error">'.$this->control->message.'</div>';
        $ret .= '
                </td>                  
            </tr>
        ';
        $args = $this->DispatchEvent("editor.control.rendered", Hashtable::Create("output", $ret));
        if(@$args->output)
            $ret = @$args->output;
        return $ret;
    }
}
?>
<?php
	class Cache {
		static $path;
		static $enabled;
		static $exclutions;
		static $objects;
		private $_site;
		private $_etag;
		private $_modified;
		private $_exists;
		private $_cached;
		private $_cachename;
		public function __construct($site) {
			$this->_site = $site;
			$this->Initialize();
			$this->LoadInfo();
		}
		public function Initialize() {
			global $core;
			if(!$core->sts->Exists("SETTING_CACHE_ENABLED"))
				$core->sts->Add(new Setting("SETTING_CACHE_ENABLED", "check", 0, null, true, "System cache settings"));
			if(!$core->sts->Exists("SETTING_CACHE_EXCLUSSIONS"))
				$core->sts->Add(new Setting("SETTING_CACHE_EXCLUSSIONS", "memo", "", null, true, "System cache settings"));
			if(!$core->sts->Exists("SETTING_CACHE_PATH"))
				$core->sts->Add(new Setting("SETTING_CACHE_PATH", "text", "/_system/_cache/pages/", null, true, "System cache settings"));
			Cache::$path = $core->sts->SETTING_CACHE_PATH;
			Cache::$enabled = $core->sts->SETTING_CACHE_ENABLED == 1 ? true : false;
			Cache::$exclutions = explode(",", $core->sts->SETTING_CACHE_EXCLUSSIONS);
			if(!$core->fs->DirExists(Cache::$path)) {
				$core->fs->CreateDir(Cache::$path);
			}
		}
		public function LoadInfo() {
			global $core;
			$this->_etag = md5(
					is_null($this->_site->folder) ? 
						$this->_site->name
						 : 
						$this->_site->folder->name
					.
					CleanCacheFromURL()
					);
			$this->_modified = strtotime($this->_site->datemodified);
			$this->_cachename = Cache::$path.'/'.$this->_etag.'.cache';
			$this->_exists = $core->fs->FileExists($this->_cachename);
            if($this->_exists)
				$this->_cached = $core->fs->FileLastModified($this->_cachename);
			else 
				$this->_cached = 0;
			if(!Cache::$enabled)
				$this->_cached = 0;
		}
		function IsExcluded() {
			if(is_null($this->_site->folder))
				return array_search($this->_site->name, Cache::$exclutions) !== false;
			$f = $this->_site->folder;
			if(!is_array(Cache::$exclutions)) {
				return false;
			}
			foreach(Cache::$exclutions as $ff) {
				$ff = Site::Fetch($ff);
				if($f->IsChildOf($ff)) {
					return true;
				}
			}
			return false;
		}
		public function Render() {
			global $core;
			$___time = microtime(true);
			$body =  $this->Process();
			echo $body;
					}
		public function Process() {
			global $core;
			if(!Cache::$enabled) {
				return $this->_site->Render();
			}
			if($this->IsExcluded())
				return $this->_site->Render();
			$isGet = isset($_GET['recache']);
			if($this->_cached < $this->_modified || $isGet) {
								$body = $this->_site->Render();
				$core->fs->DeleteFile($this->_cachename);
				$core->fs->WriteFile($this->_cachename, $body);
				return $body;
			}
			else {
								return $core->fs->ReadFile($this->_cachename);
			}
		}
	}
?><?php 
global $CORE_PATH;
if ( version_compare( phpversion(), '5', '<' ) )
	include_once( $CORE_PATH.'extras/fckeditor/fckeditor_php4.php' ) ;
else
	include_once( $CORE_PATH.'extras/fckeditor/fckeditor_php5.php' ) ;
?><?
define("IE_TABLE", "sys_index");
define("IE_TABLE_WORDS", "sys_index_words");
class IndexEngine extends IEventDispatcher {
    private $_objects;
    private $_exclussions;
    public function __construct() {
    }
    public function RegisterEventHandlers() {
        $this->HandleEvent("publication.add", "HandleInterfaceEvent");
        $this->HandleEvent("publication.save", "HandleInterfaceEvent");
        $this->HandleEvent("publication.discarding", "HandleInterfaceEvent");
    }
    public function Dispose() {
        unset($this->_objects);
        unset($this->_exclussions);
    }
    public function HandleInterfaceEvent($event, $args) {
        switch($event->name) {
            case "publication.add":
                $folder = $args->publication->FindFolder();
                if($this->CheckIfInIndex($folder) && !$this->CheckExclussions($args->publication))
                    $this->createIndex($folder, $args->publication);
                break;
            case "publication.save":
                $folder = $args->publication->FindFolder();
                if($this->CheckIfInIndex($folder) && !$this->CheckExclussions($args->publication))
                    $this->createIndex($folder, $args->publication);
                break;
            case "publication.discarding":
                $folder = $args->publication->FindFolder();
                if($this->CheckIfInIndex($folder) && !$this->CheckExclussions($args->publication))
                    $this->clearIndex($folder, $args->publication);
                break;
        }
        return $args;
    }
    public function CheckExclussions($publication) {
        if(is_null($this->_exclussions))
            return true;
        if(is_numeric($publication))
            $publication = new Publication($publication);
        if(!is_null($publication->datarow))
            return in_array($publication->datarow->storage->table, $this->_exclussions);
        else    
            return true;
    }
    public function CheckIfInIndex($folder) {
        if(is_null($this->_objects))
            return true;
        if(!is_object($folder))
            $folder = Site::Fetch($folder);
        foreach($this->_objects as $object) {
            $o = Site::Fetch($object);
            if(!is_null($folder) && !is_null($o))
                if($folder->IsChildOf($o))
                    return true;
        }
        return false;
    }
    public function Initialize($objects = null , $exclussions = null) {
        $this->checkIntegrity();
        if(is_null($objects)) {
            global $indexengine_objects;
            $objects = $indexengine_objects;
        }
        $this->_objects = $objects;
        if(is_null($exclussions)) {
            global $indexengine_exclussions;
            $exclussions = $indexengine_exclussions;
        }
        $this->_exclussions = $exclussions;
    }
    public function checkIntegrity() {
        global $core;
        if(!$core->dbe->tableexists(IE_TABLE)) {
            if(!$core->dbe->CreateTable(IE_TABLE, array(
                'index_folder' =>  array('type' => 'BIGINT', 'additional' => ' NOT NULL'),
                'index_publication' =>  array('type' => 'BIGINT', 'additional' => ' NOT NULL'),
                'index_word' =>  array('type' => 'BIGINT', 'additional' => ' NOT NULL'),
                'index_language' => array('type' => 'LONGVARCHAR', 'additional' => ' NOT NULL')
            ), array(), '')) {
                die("Can not create required table ".IE_TABLE);
            }
        }
        if(!$core->dbe->tableexists(IE_TABLE_WORDS)) {
            if(!$core->dbe->CreateTable(IE_TABLE, array(
                'index_word_id' =>  array('type' => 'autoincrement', 'additional' => ' NOT NULL'),
                'index_word' =>  array('type' => 'longvarchar', 'additional' => '')
            ), array(
                'index_word_id' => array('fields' => 'index_word_id', 'constraint' => 'PRIMARY KEY'),
                'index_word_word' => array('fields' => 'index_word', 'constraint' => 'UNIQUE')
            ), '')) {
                die("Can not create required table ".IE_TABLE_WORDS);
            }
        }
        $cols = $core->dbe->Fields("sys_index");
        if(!$cols->Exists('index_site')) if(!$core->dbe->AddField("sys_index", "index_site", "BIGINT", false, null)) die("can not modify required field in table sys_index");
    }
    public function clearIndex($folder = null, $publication = null) {
        global $core;
        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        if(is_numeric($publication)) {
            $publication = new Publication($publication);
        }
        $where = "";
        if(!is_null($folder))
            $where = " and index_folder='".$folder->id."'";
        if(!is_null($publication))
            $where = " and index_publication='".$publication->id."'";
        if($where != "")    
            $where = " where ".substr($where, 5);
        $q = "delete from ".IE_TABLE.$where;
        return $core->dbe->query($q);
    }
    public function _trimword($word) {
        return trim($word, " ,.(){}[]:;_-!@#\$%^&*\n\r");
    }
    private function _splitwords($dt , $returnString = false) {
        if(is_null($dt) || is_null($dt->storage))
            return array();
        $fields = $dt->storage->fields;
        $data = $dt->data();
        $string = "";
        foreach($fields as $field) {
            $fld = $field->field;
            $value = $dt->$fld;
            if ($value instanceof MultilinkField){
                $drs = $value->Rows();
                while ($dr = $drs->FetchNext())
                    $string .= " ".$this->_splitwords($dr, true);
            } 
            else if($value instanceof DataRow) {
                $lookup = $field->SplitLookup();
                $show = $lookup->show;
                                $string .= " ".$value->$show;
            } 
            else if($value instanceof Blob) {
            }
            else if($value instanceof BlobList) {
            }
            else if($value instanceof FileView) {
            }                
            else if($value instanceof FileList) {
            } else {
                $string .= " ".$value;
            }
        }
        $string = html_strip($string);
        if ($returnString)
            return $string;
        $pattern = "/ |\,|\.|\(|\)|\{|\}|\[|\]|\:|\;|\_|\-|\!|\@|\#|\$|\%|\^|\&|\*|\\|\n|\r|\//im";
        $matches = preg_split($pattern, $string);
        $matches = array_unique($matches);  
        $matches = array_map(array($this, '_trimword'), $matches);
        return $matches;
    }
    public function createIndexAll() {
        $objects = $this->_objects;
        foreach($objects as $fld) {
            if(!$this->createFolderIndex($fld))
                return false;
        }
        return true;
    }
    public function createFolderIndex($folder) {
        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        if(!is_null($folder)) {
            $branch = $folder->Branch();
            foreach($branch as $f) {
                $publications = $f->Publications();
                while($pub = $publications->FetchNext()) {
                    if(!$this->createPublicationsIndex($f, $pub)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
    public function createPublicationsIndex($folder, $publication) {
        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        if(!$this->createIndex($folder, $publication))
            return false;
        $pubs = $publication->Publications();
        while($pub = $pubs->FetchNext()) {
            if(!$this->createPublicationsIndex($folder, $pub)) {
                return false;
            }
        }
        return true;
    }
    public function createIndex($folder, $publication) {
        global $core;
        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        if(is_numeric($publication)) {
            $publication = new Publication($publication);
        }
        $words = $this->_splitwords($publication->datarow);
        if(count($words) > 0) {
            $ws = $words;
            $w = " where index_word in ('".implode("', '", $words)."')";
            $q = "select * from ".IE_TABLE_WORDS.$w;
            $rr = $core->dbe->ExecuteReader($q);
            while($r = $rr->Read()) {
                if($key = array_search($r->index_word, $words))
                    unset($words[$key]);
            }
            foreach($words as $word) { 
                                if(mb_strlen($word) > 2) {
                                        $q = "INSERT INTO ".IE_TABLE_WORDS."(index_word) VALUES ('".$word."')";
                    $core->dbe->query($q);
                }
            }
            $wl = substr(implode("','", $ws), 2)."'";
            $wsq = $core->dbe->ExecuteReader("select * from ".IE_TABLE_WORDS." where index_word in (".$wl.")");
            if($wsq->Count() > 0) {
                $s = $folder instanceof Site ? $folder : $folder->Path()->Item(0);
                $fid = $folder->id;
                $pid = $publication->id;        
                $qq = "";
                $this->clearIndex($folder, $publication);
                if($wsq->Count() > 100) {
                    while($word = $wsq->Read()) {
                        $q = "INSERT INTO ".IE_TABLE."(index_site, index_folder, index_publication, index_word, index_language) VALUES ";
                        $qq = "('".$s->id."', '".$fid."', '".$pid."', '".$word->index_word_id."', 'ru')";
                        $q = $q.$qq;
                        if(!$core->dbe->query($q)) {
                            out("error", $q);
                            exit;
                        }
                    }
                }
                else {
                    $q = "INSERT INTO ".IE_TABLE."(index_site, index_folder, index_publication, index_word, index_language) VALUES ";
                    while($word = $wsq->Read()) {
                        $qq .= ", ('".$s->id."', '".$fid."', '".$pid."', '".$word->index_word_id."', 'ru')";
                    }
                    $qq = substr($qq, 2);
                    $q = $q.$qq;
                    if(!$core->dbe->query($q)) {
                        out("error", $q);
                        exit;
                    }
                }
                return true;
            }
            else 
                return true;
        }
        else {
            return true;
        }
    }
    public function createSearchCondition($s, $site = null) {
        $sRet = "";
        $s = trim($s);
        $s = preg_replace("/\./", " ", $s);
        $s = preg_replace("/,/", " ", $s);
        $s = preg_replace("/\(/", " ", $s);
        $s = preg_replace("/\)/", " ", $s);
        $sRetQs2 = "select distinct index_publication from sys_index where ";
        $sRetQ1 = "select distinct index_folder,index_publication, 0 as index_strict from sys_index where ";
        $sRetQ2 = "select distinct index_folder,index_publication, 1 as index_strict from sys_index where ";
        $sRetQe2 = " group by index_site, index_folder, index_publication having count(index_publication) > ";
        $sRet = "";
        $sRet1 = "";
        preg_match_all("/[^\s]*/", $s, $matches);
        $matches = array_unique($matches[0]);
        $icount = 0;                     
        foreach($matches as $match) {
            if($match != "") {
                $sRet = $sRet."index_word = '".$match."' or ";
                $sRet1 = $sRet1."index_word like '".$match."%' or ";
                $icount = $icount + 1;
            }
        }
        $sRet = substr($sRet, 0, strlen($sRet) - 4);
        $sRet1 = substr($sRet1, 0, strlen($sRet1) - 4);
        return "select * from (".$sRetQ2.$sRet.$sRetQe2.($icount-1)." union ".$sRetQ1.$sRet1." and index_publication not in (".$sRetQs2.$sRet.$sRetQe2.($icount-1).")) devtbl".(is_null($site) ? "" : " where index_site='".$site->id."'")." order by index_strict desc";
            }
    private function splitQueryString($s) {
        $s = trim($s);
        $s = preg_replace("/\./", " ", $s);
        $s = preg_replace("/,/", " ", $s);
        $s = preg_replace("/\(/", " ", $s);
        $s = preg_replace("/\)/", " ", $s);
        preg_match_all("/[^\s]*/", $s, $matches);
        $matches = array_unique($matches[0]);
        $ret = array();
        foreach($matches as $match) {
            if($match != "" && !is_null($match))
                $ret[] = trim($match);
        }
        return $ret;
    }
    public function DoSearch($s, $page = 1, $pagesize = 10, $joinWith = false, $site = null) {
        global $core;
                $matches = $this->splitQueryString($s);
        $icount = count($matches);
        $sRet = "";
        $sRet1 = "";
        foreach($matches as $match) {
            $sRet = $sRet."index_word = '".$match."' or ";
            $sRet1 = $sRet1."index_word like '".$match."%' or ";
        }
        $sRet = substr($sRet, 0, strlen($sRet) - 4);
        $sRet1 = substr($sRet1, 0, strlen($sRet1) - 4);
        $q1 = "select distinct index_word_id, (index_word_id in (select index_word_id from ".IE_TABLE_WORDS." where ".$sRet.")) as index_strict from ".IE_TABLE_WORDS." where ";
        $q = $q1."(".$sRet.") or ((".$sRet1.") and index_word_id not in (select index_word_id from ".IE_TABLE_WORDS." where ".$sRet."))";
        $core->dbe->CreateTableAs('sys_search_results', $q, true);
        $qj = "";
        $qqqqq = "";
        if($joinWith) {
            $qj = " left outer join sys_tree on sys_tree.tree_id=sys_index.index_folder";
            $qqqqq = ", sys_tree.*";
        }
        $q = "select distinct index_folder, index_publication, min(cast(index_strict as int)) as index_strict".$qqqqq."  from ".IE_TABLE." inner join sys_search_results on sys_search_results.index_word_id=sys_index.index_word ".$qj." ".(is_null($site) ? '' : " where (index_site='".$site->id."')")." group by index_folder, index_publication";
        $ret = $core->dbe->QueryPage($q, "", $page, $pagesize);
        $core->dbe->DropTable("sys_search_results");
        return $ret;
    }
}
?><?php
class BlobExControl extends Control {
    static $scriptsRendered;
	public $blob_operations;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $blob_operations = null) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = $blob_operations;
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
	}
	function getBlobOperations($operation, $prefix, $field) {
		switch($operation) {
			case "add":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle=Blob_complete';
				break;
			case "edit":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle=Blob_complete&edit=';
				break;
			case "select":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler=Blob_complete';
				break;
		}
	}
    public function RenderScripts($script = "") {
        $objHandler = $this->blob_operations["handlerObject"];
        $f = $this->blob_operations["function"];
        $addUrl = $objHandler->$f("add", "", $this->name);
        $editUrl = $objHandler->$f("edit", "", $this->name);
        $selectUrl = $objHandler->$f("select", "", $this->name);
        $script = '
            <script language="javascript">
                // Blob contol scripts
                // <!--
                function Blob_complete(name, window, blobid, alt, img) {
                    var hf = document.getElementById(name);
                    var container = document.getElementById("blob"+name);
                    container.innerHTML = "<img src=\'"+img+"\' alt=\'"+alt+"\' >";    
                    hf.value = blobid;
                }
                function addBlob(name) {
                    src = "'.$addUrl.'&field="+name;
                    wnd = window.open(src, "addblob", "status=0,help=0,resizable=0,scrollbars=0, width=420,height=280");
                    wnd.opener = window;
                }
                function editBlob(name) {
                    var hf = document.getElementById(name);
                    src = "'.$editUrl.'"+hf.value+"&field="+name;
                    wnd = window.open(src, "editblob", "status=0,help=0,resizable=0,scrollbars=0, width=480,height=280");
                    wnd.opener = window;
                }
                function selectBlob(name) {
                    var hf = document.getElementById(name);
                    src = "'.$selectUrl.'&field="+name;
                    wnd = window.open(src, "addblob", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }
                function deleteBlob(name) {
                    if(window.confirm("Are you sure to deselect blob?")) {
                        var hf = document.getElementById(name);
                        var container = document.getElementById("blob"+name);
                        container.innerHTML = "not selected";
                        hf.value = 0;
                    }
                }
                // -->
                // Blob contol scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
	public function Render() {
		global $core;
		$ret = "";
		$value = $this->value;
		if(!is_object($value))
			$value = new blob(intval($value));
		$ret .= $this->RenderScripts();
		$ret .= '<input type="hidden" name="'.$this->name.'" id="'.$this->name.'" value="'.($value->id).'">';
		$ret .= '
				<table>
					<tr>
						<td>
							<a href="javascript: addBlob(\''.$this->name.'\');"><img src="images/icons/op_add.gif" border="0" hspace="2"></a>
							<a href="javascript: deleteBlob(\''.$this->name.'\');"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
							<a href="javascript: editBlob(\''.$this->name.'\');"><img src="images/icons/op_edit.gif" border="0" hspace="2"></a>
							<a href="javascript: selectBlob(\''.$this->name.'\');"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
						</td>
					</tr>
					<tr>
						<td colspan="4" valign="middle" id="blob'.$this->name.'"  class="blob_value">
				';
		$ret .= $value->img(new Size(100, 100));
		$ret .= '
						</td>
					</tr>
				</table>
				';
		$disstart = '';
		$disend = '';
		if($this->disabled) {
			$disstart = '<div disabled="disabled">';
			$disend = '</div>';
		}
		return $disstart.$ret.$disend;		
	}
	public function Validate() {
		if($this->value instanceof Blob)
			$b = $this->value;
		else
			$b = new Blob((int)$this->value);
		if($this->required && is_null($b->id)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else {
			if(!is_null($b->id) && !$b->isValid)
				$this->message = "The selected blob does not exists.";
			$this->isValid = !(!is_null($b->id) && !$b->isValid);
		}
		return $this->isValid;
	}	
}
?><?php
class BloblistExControl extends Control {
    static $scriptsRendered;
	public $blob_operations;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
	}
	function getBlobOperations($operation, $prefix, $field) {
		switch($operation) {
			case "add":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle=bloblist_complete&return=html';
				break;
			case "edit":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=edit&return=html&handle=bloblist_complete';
				break;
			case "select":
				return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler=bloblist_complete&multiselect=true';
				break;
		}
	}
    public function RenderScripts($script = "") {
        $objHandler = $this->blob_operations["handlerObject"];
        $f = $this->blob_operations["function"];
        $addUrl = $objHandler->$f("add", "", $this->name);
        $editUrl = $objHandler->$f("edit", "", $this->name);
        $selectUrl = $objHandler->$f("select", "", $this->name);
        $script .= '
            <script language="javascript">
                // Blob list scripts
                // <!--
                function  bloblist_complete(name, operation, html, id) {
                    var objectlist = document.getElementById("id"+name+"viewtable");
                    var obj = document.getElementById(name);
                    switch(operation) {
                        case "add":
                            var row = objectlist.insertRow(objectlist.rows.length);
                            if(window.browserType == "IE")
                                row.setAttribute("onclick", new Function("javascript: return setRowCheck(this);"));
                            else
                                row.setAttribute("onclick", "javascript: return setRowCheck(this);");
                            row.setAttribute("id", name+"view_"+id+"row");
                            var cell = row.insertCell(row.cells.length);
                            cell.innerHTML = html;
                            var cell = row.insertCell(row.cells.length);
                            cell.innerHTML = "<input type=\"checkbox\" name=\""+name+"view_"+id+"\" value=\""+id+"\" hilitable=1>";
                            var arr = new Array();
                            if(obj.value != "")
                                arr = obj.value.split(",");
                            arr[arr.length] = id;
                            obj.value = arr.join(",");
                            break;
                        case "edit":
                            var row = document.getElementById(name+"view_"+id+"row");
                            row.cells[0].innerHTML = html;
                            break;
                        case "select":
                            var arr = new Array();
                            if(obj.value != "")
                                arr = obj.value.split(",");
                            for(var i=0; i<html.length; i++) {
                                var h=html[i];
                                var row = objectlist.insertRow(objectlist.rows.length);
                                if(window.browserType == "IE")
                                    row.setAttribute("onclick", new Function("javascript: return setRowCheck(this);"));
                                else
                                    row.setAttribute("onclick", "javascript: return setRowCheck(this);");
                                row.setAttribute("id", name+"view_"+h[0]+"row");
                                var cell = row.insertCell(row.cells.length);
                                cell.innerHTML = h[1];
                                var cell = row.insertCell(row.cells.length);
                                cell.innerHTML = "<input type=\"checkbox\" name=\""+name+"view_"+h[0]+"\" value=\""+h[0]+"\" hilitable=1>";
                                arr[arr.length] = h[0];
                            }
                            obj.value = arr.join(",");
                            break;
                    }
                }
                function  addItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    src = "'.$addUrl.'&field="+name;
                    wnd = window.open(src, "additem", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }
                function  editItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    src = "'.$editUrl.'&field="+name;
                    var selectedItems = countSelectedChecks(hf);
                    if(selectedItems.length > 1) {
                        alert("'.@$this->args->texts['em_multipleedit'].'");
                        return;
                    }
                    if(selectedItems.length == 0) {
                        alert("'.@$this->args->texts['em_noselection'].'");
                        return;
                    }
                    wnd = window.open(src+"&edit="+selectedItems[0].value, "edititem", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }
                function  deleteItem(name) {
                    if(window.confirm("Are you sure to remove blob from list?")) {
                        var hf = document.getElementById("id"+name+"viewtable");
                        var selectedItems = countSelectedChecks(hf);
                        var obj = document.getElementById(name);
                        var arr = new Array();
                        if(obj.value != "")
                            arr = obj.value.split(",");
                        for(var i=0; i<selectedItems.length;i++) {
                            var j = -1;
                            var r = selectedItems[i].parentNode.parentNode;
                            arr.splice(r.rowIndex, 1);
                            hf.deleteRow(r.rowIndex);
                        }
                        obj.value = arr.join(",");
                    }
                }
                function  selectItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    src = "'.$selectUrl.'&field="+name;
                    wnd = window.open(src, "selectitem", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
                    wnd.opener = window;
                }
                function  upItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    var selectedItems = countSelectedChecks(hf);
                    var obj = document.getElementById(name);
                    if(selectedItems.length > 1) {
                        alert("'.@$this->args->texts['em_multipleedit'].'");
                        return;
                    }
                    if(selectedItems.length == 0) {
                        alert("'.@$this->args->texts['em_noselection'].'");
                        return;
                    }
                    var arr = new Array();
                    if(obj.value != "")
                        arr = obj.value.split(",");
                    var selected = selectedItems[0];
                    var r = selected.parentNode.parentNode;
                    j = r.rowIndex;
                    if(j >= 0) {
                        val = arr[j];
                        arr.splice(j, 1);
                        arr.splice(j-1, 0, val);
                    }
                    obj.value = arr.join(",");
                    var row = hf.insertRow(r.rowIndex-1);
                    row.setAttribute("id", r.id);
                    row.setAttribute("onclick", r.getAttribute("onclick"));
                    var cell = row.insertCell(row.cells.length);
                    cell.innerHTML = r.cells[0].innerHTML;
                    var cell = row.insertCell(row.cells.length);
                    cell.innerHTML = r.cells[1].innerHTML;
                    hf.deleteRow(r.rowIndex);
                    setRowCheck(row, true);
                }
                function  downItem(name) {
                    var hf = document.getElementById("id"+name+"viewtable");
                    var selectedItems = countSelectedChecks(hf);
                    var obj = document.getElementById(name);
                    if(selectedItems.length > 1) {
                        alert("'.@$this->args->texts['em_multipleedit'].'");
                        return;
                    }
                    if(selectedItems.length == 0) {
                        alert("'.@$this->args->texts['em_noselection'].'");
                        return;
                    }
                    var arr = new Array();
                    if(obj.value != "")
                        arr = obj.value.split(",");
                    var selected = selectedItems[0];
                    var r = selected.parentNode.parentNode;
                    var j = r.rowIndex;
                    /*for(j=0; j<arr.length;j++) {
                        if(j == selected.getAttribute("index"))
                            break;
                    }*/
                    if(j >= 0 && j < arr.length) {
                        val = arr[j];
                        arr.splice(j, 1);
                        arr.splice(j+1, 0, val);
                    }
                    obj.value = arr.join(",");
                    //var r = selected.parentNode.parentNode;
                    if(r.rowIndex+1 < hf.rows.length) {
                        var row = hf.insertRow(r.rowIndex+2);
                        row.setAttribute("id", r.id);
                        row.setAttribute("onclick", r.getAttribute("onclick"));
                        var cell = row.insertCell(row.cells.length);
                        cell.innerHTML = r.cells[0].innerHTML;
                        var cell = row.insertCell(row.cells.length);
                        cell.innerHTML = r.cells[1].innerHTML;
                        hf.deleteRow(r.rowIndex);
                        setRowCheck(row, true);
                    }
                }
                // -->
                // Blob list scripts
            </script>
        ';
        return parent::RenderScripts($script);
    } 
	public function Render() {
		global $core;
		$ret = "";
		$required = $this->required;
		$value = $this->value;
		if(!($value instanceof BlobList))
			$value = new BlobList($value);
        $ret .= $this->RenderScripts();
        $ret .= '
			<table width="100%">
				<tr>
				<td>
					<a href="javascript: addItem(\''.$this->name.'\');"><img src="images/icons/op_add.gif" border="0" hspace="2"></a>
					<a href="javascript: editItem(\''.$this->name.'\');"><img src="images/icons/op_edit.gif" border="0" hspace="2"></a>
					<a href="javascript: deleteItem(\''.$this->name.'\');"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
					<a href="javascript: selectItem(\''.$this->name.'\');"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
					<img src="/admin/images/1x1.gif" width="15" height="10" />
					<a href="javascript: upItem(\''.$this->name.'\');"><img src="images/icons/op_moveup.gif" border="0" hspace="2"></a>
					<a href="javascript: downItem(\''.$this->name.'\');"><img src="images/icons/op_movedown.gif" border="0" hspace="2"></a>
				</td>
				</tr>
				<tr>
				<td>
					<textarea name="'.$this->name.'" id="'.$this->name.'" style="display: none">'.$value->ToString().'</textarea>
		';
		$ret .= RenderVerticalCheckboxes($this->name.'view', $value, "100%", "300px", $required);
		$ret .= '
				</td>
				</tr>
			</table>
		';
		return $ret;
	}	
}
?><?php
class ButtonExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
	}
	public function Render() {
		return 
		'
			<input type="button" name="'.$this->name.'" value="'.$this->value.'" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.' />
		';
	}
}
?><?php
class CheckExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "select-box";
		if(is_empty($this->styles))
			$this->styles = "";
	}
	public function Render() {
		$ret = "";
		$checked = $this->value == 1 ? " checked" : "";
		if(!$this->required) {
			$ret .= '
					<select name="'.$this->name.'" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.'>
					';
			$isnull = is_null($this->value);
			if(!$this->required)
				$ret .= '
						<option value="" '.($isnull ? 'selected' : '').'>Not selected</option>
						';
			$selected = false;
			if(!is_null($this->value))
				$selected = $this->value == 1 ? true : false;
			$ret .= '
					<option value="1" '.($selected ? 'selected' : '').'>Checked</option>
					<option value="0" '.(!$selected ? 'selected' : '').'>Unckecked</option>
					';	
			$ret .= '
					</select>
					';
		}
		else {
			$ret .= '
                <input type="hidden" name="'.$this->name.'" value="'.$this->value.'" />
				<input type="checkbox" name="'.$this->name.'_check" '.$checked.' '.($this->disabled ? 'disabled="disabled"' : '').'  '.$this->attributes.' onclick="javascript: this.form.elements[\''.$this->name.'\'].value=this.checked ? 1 : 0;" />
			';
		}
		return $ret;	
	}
	public function Validate() {
		$value = $this->value;
		$this->isValid = ($value == 1 || $value == 0 || (is_null($value) && !$this->required));
		if(!$this->isValid)
			$this->message = "This field must contain a true or false value";
		return $this->isValid;
	}
}
?><?php
class ComboExControl extends Control {
    static $scriptsRendered;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if($this->styles == "")
			$this->styles .= "width: 100%";
	}
    public function RenderScripts($script = "") {
        $script .= '
            <script language="javascript">
                function completeselect(obj, name) {
                    v = "";
                    for(var i=0; i<obj.options.length; i++){ 
                        if(obj.options[i].selected) { 
                            v = v + obj.options[i].value+","; 
                        } 
                    }
                    document.getElementById(name).value = v.substr(0, v.length-1);
                    return false;
                }
            </script>
        ';
        return parent::RenderScripts($script);
    }
	public function Render() {
		$valuesviewed = $this->value[0];
		$valuesselected = $this->value[1];
		$multiselect = @$this->args->multiselect; if(is_null($multiselect)) $multiselect = false;
		$ret = "";
		if($multiselect) {
            $ret .= $this->RenderScripts();
		    $ret .= '
			    <input type="hidden" name="'.$this->name.'" id="'.$this->name.'">
			    <select name="'.$this->name.'sel" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.' '.($multiselect ? ' size="10" multiple="yes" onchange="javascript: return completeselect(this, \''.$this->name.'\'); "' : '').'>
		    ';
		}
		else {
		    $ret .= '
			    <select name="'.$this->name.'" class="'.$this->class.'" style="'.$this->styles.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.'>
		    ';
		}
		foreach($valuesviewed as $key => $v) {
			$title = $key;
			$value = $v;
			$padleft = "";
			$ss = "";
			if(is_object($value)) {
				$titlefield = $this->args->titleField;
				$valuefield = $this->args->valueField;
                $istree = $this->args->istree;
				$padleft = $this->args->padleftField;
				if(!is_empty($padleft)) {
					$val = $padleft ? $v->$padleft : 2;
                    $val = ($val - 1) < 0 ? 1 : $val;
					$padleft = str_repeat("&nbsp;", ($val-1) * $this->args->padleftMultiplier);
				}
				else {
					$padleft = "";
				}
				$title = $value->$titlefield;
				$value = $value->$valuefield;
				$ss = "";
				if($this->args->denyObject) {
					$b = false;
					$expression = "\$b = ".$this->args->denyExpression.";";
					eval($expression);
					if($b) {
						$ss = $this->args->denyStyle; 
					}
				}
			}
			$selected = ($valuesselected == $value);
			$ret .= '
					<option value="'.$value.'" '.($selected ? 'selected="selected"' : "").' style="'.$ss.'">'.$padleft.$title.'</option>
			';
		}
		$ret .= '
			</select>
		';
		return $ret;
	}	
}
?><?php
class DateTimeExControl extends Control {
    static $scriptsRendered;
    private $_showlegend;
    private $_showtime;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $showLegend = true, $showTime = true) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
        $this->_showlegend = $showLegend;
        $this->_showtime = $showTime;
	}
    public function RenderScripts($script = "") {
        $script .= '
            <script language="javascript">
                // Date control scripts 
                // <!--
                function changeDate(name) {
                    var day = document.getElementById("day"+name);
                    var month = document.getElementById("month"+name);
                    var year = document.getElementById("year"+name);
                    var hour = document.getElementById("hour"+name);
                    var minute = document.getElementById("minute"+name);
                    var hidden = document.getElementById("hidden"+name);
                    if(hour)
                        if(hour.value == "")
                            hour.value = "00";
                    if(minute)
                        if(minute.value == "")
                            minute.value = "00";
                    hidden.value = year.value+"-"+month.value+"-"+day.value+(hour ? " "+hour.value : " 00")+(minute ? ":"+minute.value : ":00");
                }
                // -->
                // Date control scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
	public function Render() {
		if(is_numeric($this->value))
			$this->value = strftime("%Y-%m-%d %H:%M:%S", $this->value);
		if(is_empty($this->value))
			$this->value = strftime("%Y-%m-%d %H:%M:%S", time());
		if(is_date($this->value))
			$this->value = strtotime($this->value);
		$dn = $this->valueOf('day'.$this->name);
		$mn = $this->valueOf('month'.$this->name);
		$yn = $this->valueOf('year'.$this->name);
		$hh = $this->valueOf('hour'.$this->name);
		$mm = $this->valueOf('minute'.$this->name);
		if(is_date($this->value)) {
			$dn = strftime("%d", $this->value);
			$mn = strftime("%m", $this->value);
			$yn = strftime("%Y", $this->value);
			$hh = strftime("%H", $this->value);
			$mm = strftime("%M", $this->value);
		}
		$v = "";
		if(is_date($this->value))
			$v = strftime("%Y-%m-%d %H:%M", $this->value);
        $script = $this->RenderScripts();
		$hidden =	'<input type="hidden" id="hidden'.$this->name.'" name="'.$this->name.'" value="'.$v.'">';
		$day =		'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="day'.$this->name.'" name="'.$this->name.'_'.'day" value="'.$dn.'" maxlength="2" class="date-day-input">';
		$month =	'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="month'.$this->name.'" name="'.$this->name.'_'.'month" value="'.$mn.'" maxlength="2" class="date-month-input">';
		$year =		'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="year'.$this->name.'" name="'.$this->name.'_'.'year" value="'.$yn.'" maxlength="4" class="date-year-input">';
		$hour =		'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="hour'.$this->name.'" name="'.$this->name.'_'.'hour" value="'.$hh.'" maxlength="2" class="date-hour-input">';
		$minute =	'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="minute'.$this->name.'" name="'.$this->name.'_'.'minute" value="'.$mm.'" maxlength="2" class="date-minute-input">';
		$splitter = "<span class=\"date-spacer\">.</span>";
        if($this->_showlegend)
		    $help = "<div style=\"margin: 0px 0px 0px 0px;\" class=\"small-text\">".
			    "<span style=\"margin: 0px 0px 0px 5px;\">D</span><span style=\"margin: 0px 0px 0px 17px;\">M</span>".
			    "<span style=\"margin: 0px 0px 0px 21px;\">Y</span><span style=\"margin: 0px 0px 0px 21px;\">h</span>".
			    "<span style=\"margin: 0px 0px 0px 17px;\">m</span>".
			    "</div>";
        else
            $help = "";
		$disstart = '';
		$disend = '';
		if($this->disabled) {
			$disstart = '<div disabled="disabled">';
			$disend = '</div>';
		}
		return $disstart.$script.$hidden.$day.$splitter.
			$month.$splitter.$year.
			($this->_showtime ? $splitter.$hour.$splitter.$minute : "").$help.$disend;
	}
	public function Validate() {
		        if(is_numeric($this->value))
            $this->value = strftime("%Y-%m-%d %H:%M:%S", $this->value);
        if(is_empty($this->value))
            $this->value = strftime("%Y-%m-%d %H:%M:%S", time());
        if(is_date($this->value))
            $this->value = strtotime($this->value);
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)){ 
			if(!is_date($this->value))
				$this->message = "Invalid date";
			$this->isValid	= is_date($this->value);
		}
		return $this->isValid;
	}	
}
?><?php
class BigDateExControl extends Control {
    static $scriptsRendered;
    private $_showlegend;
    private $_showtime;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $showLegend = true, $showTime = true) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
        $this->_showlegend = $showLegend;
        $this->_showtime = $showTime;
	}
    public function RenderScripts($script = "") {
        $script .= '
            <script language="javascript">
                // Date control scripts 
                // <!--
                function changeDate(name) {
                    var day = document.getElementById("day"+name);
                    var month = document.getElementById("month"+name);
                    var year = document.getElementById("year"+name);
                    var hour = document.getElementById("hour"+name);
                    var minute = document.getElementById("minute"+name);
                    var hidden = document.getElementById("hidden"+name);
                    if(hour)
                        if(hour.value == "")
                            hour.value = "00";
                    if(minute)
                        if(minute.value == "")
                            minute.value = "00";
                    hidden.value = year.value+"-"+month.value+"-"+day.value+(hour ? " "+hour.value : " 00")+(minute ? ":"+minute.value : ":00");
                }
                // -->
                // Date control scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
	private function yearisleap($year){
		if ($year % 4 != 0) return false;
		if ($year % 400 == 0) {
			return true;
				} else if ($year > 1582 && $year % 100 == 0 ) {
			return false;
		}
		return true;
	}
	private function getdatearr($origd){
		static $YRS;
		$d = $origd;
		$_day_power = 86400;
		$_hour_power = 3600;
		$_min_power = 60;
		if ($d < -12219321600) $d -= 86400*10; 
		$_month_table_normal = array("",31,28,31,30,31,30,31,31,30,31,30,31);
		$_month_table_leaf = array("",31,29,31,30,31,30,31,31,30,31,30,31);
		$d366 = $_day_power * 366;
		$d365 = $_day_power * 365;
		if ($d < 0) {
			$YRS = array(
				1970 => 0,
				1960 => -315619200,
				1950 => -631152000,
				1940 => -946771200,
				1930 => -1262304000,
				1920 => -1577923200,
				1910 => -1893456000,
				1900 => -2208988800,
				1890 => -2524521600,
				1880 => -2840140800,
				1870 => -3155673600,
				1860 => -3471292800,
				1850 => -3786825600,
				1840 => -4102444800,
				1830 => -4417977600,
				1820 => -4733596800,
				1810 => -5049129600,
				1800 => -5364662400,
				1790 => -5680195200,
				1780 => -5995814400,
				1770 => -6311347200,
				1760 => -6626966400,
				1750 => -6942499200,
				1740 => -7258118400,
				1730 => -7573651200,
				1720 => -7889270400,
				1710 => -8204803200,
				1700 => -8520336000,
				1690 => -8835868800,
				1680 => -9151488000,
				1670 => -9467020800,
				1660 => -9782640000,
				1650 => -10098172800,
				1640 => -10413792000,
				1630 => -10729324800,
				1620 => -11044944000,
				1610 => -11360476800,
				1600 => -11676096000);
			$lastsecs = 0;
			$lastyear = 1970;
			foreach($YRS as $year => $secs) {
				if ($d >= $secs) {
					$a = $lastyear;
					break;
				}
				$lastsecs = $secs;
				$lastyear = $year;
			}
			$d -= $lastsecs;
			if (!isset($a)) $a = $lastyear;
			for (; --$a >= 0;) {
				$lastd = $d;
				if ($leaf = $this->yearisleap($a)) $d += $d366;
				else $d += $d365;
				if ($d >= 0) {
					$year = $a;
					break;
				}
			}
			$secsInYear = 86400 * ($leaf ? 366 : 365) + $lastd;
			$d = $lastd;
			$mtab = ($leaf) ? $_month_table_leaf : $_month_table_normal;
			for ($a = 13 ; --$a > 0;) {
				$lastd = $d;
				$d += $mtab[$a] * $_day_power;
				if ($d >= 0) {
					$month = $a;
					$ndays = $mtab[$a];
					break;
				}
			}
			$d = $lastd;
			$day = $ndays + ceil(($d+1) / ($_day_power));
			$d += ($ndays - $day+1)* $_day_power;
			$hour = floor($d/$_hour_power);
		} else {
			for ($a = 1970 ;; $a++) {
				$lastd = $d;
				if ($leaf = $this->yearisleap($a)) $d -= $d366;
				else $d -= $d365;
				if ($d < 0) {
					$year = $a;
					break;
				}
			}
			$secsInYear = $lastd;
			$d = $lastd;
			$mtab = ($leaf) ? $_month_table_leaf : $_month_table_normal;
			for ($a = 1 ; $a <= 12; $a++) {
				$lastd = $d;
				$d -= $mtab[$a] * $_day_power;
				if ($d < 0) {
					$month = $a;
					$ndays = $mtab[$a];
					break;
				}
			}
			$d = $lastd;
			$day = ceil(($d+1) / $_day_power);
			$d = $d - ($day-1) * $_day_power;
			$hour = floor($d /$_hour_power);
		}
		$d -= $hour * $_hour_power;
		$min = floor($d/$_min_power);
		$secs = $d - $min * $_min_power;
		return array(
			'seconds' => $secs,
			'minutes' => $min,
			'hours' => $hour,
			'mday' => $day,
			'mon' => $month,
			'year' => $year,
			'yday' => floor($secsInYear/$_day_power),
			'month' => gmdate('F',mktime(0,0,0,$month,2,1971)),
			0 => $origd
		);
	}
    private function zeroround($num){
    	if ($num < 10)
    		return '0'.$num;
    }
	public function Render() {
		$dn = $this->valueOf('day'.$this->name);
		$mn = $this->valueOf('month'.$this->name);
		$yn = $this->valueOf('year'.$this->name);
		$hh = $this->valueOf('hour'.$this->name);
		$mm = $this->valueOf('minute'.$this->name);
		if(is_numeric($this->value)){
			$datearr = $this->getdatearr($this->value);
			$dn = $this->zeroround($datearr['mday']);
			$mn = $this->zeroround($datearr['mon']);
			$yn = $datearr['year'];
			$hh = $this->zeroround($datearr['hours']);
			$mm = $this->zeroround($datearr['minutes']);
		}
		$v = "";
		if(is_date($this->value))
			$v = @strftime("%Y-%m-%d %H:%M", $this->value);
		if (!$v)
			$v = $dn.'-'.$mn.'-'.$yn.' '.$hh.':'.$mm;
        $script = $this->RenderScripts();
		$hidden =	'<input type="hidden" id="hidden'.$this->name.'" name="'.$this->name.'" value="'.$v.'">';
		$day =		'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="day'.$this->name.'" name="'.$this->name.'_'.'day" value="'.$dn.'" maxlength="2" class="date-day-input">';
		$month =	'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="month'.$this->name.'" name="'.$this->name.'_'.'month" value="'.$mn.'" maxlength="2" class="date-month-input">';
		$year =		'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="year'.$this->name.'" name="'.$this->name.'_'.'year" value="'.$yn.'" maxlength="4" class="date-year-input">';
		$hour =		'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="hour'.$this->name.'" name="'.$this->name.'_'.'hour" value="'.$hh.'" maxlength="2" class="date-hour-input">';
		$minute =	'<input type="text" onchange="javascript: changeDate(\''.$this->name.'\')" id="minute'.$this->name.'" name="'.$this->name.'_'.'minute" value="'.$mm.'" maxlength="2" class="date-minute-input">';
		$splitter = "<span class=\"date-spacer\">.</span>";
        if($this->_showlegend)
		    $help = "<div style=\"margin: 0px 0px 0px 0px;\" class=\"small-text\">".
			    "<span style=\"margin: 0px 0px 0px 5px;\">D</span><span style=\"margin: 0px 0px 0px 17px;\">M</span>".
			    "<span style=\"margin: 0px 0px 0px 21px;\">Y</span><span style=\"margin: 0px 0px 0px 21px;\">h</span>".
			    "<span style=\"margin: 0px 0px 0px 17px;\">m</span>".
			    "</div>";
        else
            $help = "";
		$disstart = '';
		$disend = '';
		if($this->disabled) {
			$disstart = '<div disabled="disabled">';
			$disend = '</div>';
		}
		return $disstart.$script.$hidden.$day.$splitter.
			$month.$splitter.$year.
			($this->_showtime ? $splitter.$hour.$splitter.$minute : "").$help.$disend;
	}
	public function Validate() {
		        if(is_empty($this->value))
            $this->value = time();
        if(is_date($this->value))
            $this->value = strtotime($this->value);
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)){ 
			if(!is_numeric($this->value))
				$this->message = "Invalid date";
			$this->isValid	= is_numeric($this->value);
		}
		return $this->isValid;
	}	
}
?><?php
class FileExControl extends Control {
	public $blob_operations;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $blob_operations = null) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = $blob_operations;
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
		$this->RegisterEvent("fileexcontrol.validate");
	}
	function getBlobOperations($operation, $prefix, $field) {
		switch($operation) {
			case "select":
				return 'floating.php?postback_section=publications&postback_action=files&postback_command=select&handler='.$field.'_selectFile_complete';
				break;
		}
	}
	public function Render() {
		global $core;
		$ret = "";
		$value = $this->value;
		if($value instanceof FileView)
			$value = $value->Src().":".$value->alt;
		$objHandler = $this->blob_operations["handlerObject"];
		$f = $this->blob_operations["function"];
		$selectUrl = $objHandler->$f("select", $this->args->editor, $this->name);
		$ret .= '
			<script>
				function '.$this->name.'_selectFile_complete(window, id, alt, img, filename, type_id, category, w, h, href, handler, hname) {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(href.join) {
						for(var i=0; i<href.length; i++) {
							h = href[i];
							hf.value=h;
						}
					}
					else {
						hf.value = href;
					}
				}
				function '.$this->name.'_deleteFile() {
					var hf = document.getElementById("'.$this->name.'");
					hf.value = "";
				}
				function '.$this->name.'_selectFile() {
					var hf = document.getElementById("'.$this->name.'");
					src = "'.$selectUrl.'";
					wnd = window.open(src, "selectfile", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
					wnd.opener = window;
				}
				function '.$this->name.'_descriptFile() {
					var hf = document.getElementById("'.$this->name.'");
					var selval = "";
					var v = hf.value.split(":");
					if(v.length > 1) { selval = v[0]; v = v[1]; } else { selval = v; v = ""; }
					var ret = window.prompt("Input description of the file please", v);
					if(ret != undefined) {
						if(ret == "")						
							hf.value = selval;
						else
							hf.value = selval+":"+ret;
					}
				}
			</script>
		';
		$valuess = explode(";", str_replace_ex($value, "\n\r", ""));
		$values = '';
		foreach($valuess as $v) {
			if(strlen(trim($v)) > 0) {
				$vv = explode(':', $v);
				if(count($vv) > 1) {
					$v = $vv[0];
					$v1 = ":".$vv[1];
				}
				else {
					$v = $v;
					$v1 = "";
				}
				$values .= '<option value="'.$v.'">'.$v.$v1.'</option>';
			}
		}
		$ret .= '
			<table width="100%">
				<tr>
					<td>
						<a href="javascript: '.$this->name.'_descriptFile();"><img src="images/icons/op_import.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_deleteFile();"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_selectFile();"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" readonly="readonly" name="'.$this->name.'" id="'.$this->name.'" value="'.$value.'" style="width: 100%;">
					</td>
				</tr>
			</table>
		';		
		return $ret;
	}
	public function Validate() {
		global $core;
		$this->isValid = true;
		$errofile = "";
		$file = $this->value;
		$args = $this->DispatchEvent("fileexcontrol.validate", collection::create("data", $file));
		if (@$args->cancel === true)
			return;
		else if (!is_empty(@$args->data))
			$file = $args->data;
		if(trim($file) != "" && trim($file) != ":") {
			$filev = explode(":", $file);
			if(!$core->fs->fileexists($filev[0])) {
				$this->isValid = false;
				$errofile = $file;
			}
		}
		if(!$this->isValid)
			$this->message = "Invalid file: path=".$errofile;
		return $this->isValid;
	}
}
?><?php
class FileListExControl extends Control {
	public $blob_operations;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $blob_operations = null) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = $blob_operations;
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
	}
	function getBlobOperations($operation, $prefix, $field) {
		switch($operation) {
			case "select":
				return 'floating.php?postback_section=publications&postback_action=files&postback_command=select&handler='.$field.'_selectFile_complete';
				break;
		}
	}
	public function Render() {
		global $core;
		$ret = "";
		$value = $this->value;
		if($value instanceof FileList)
			$value = $value->ToString();
		$objHandler = $this->blob_operations["handlerObject"];
		$f = $this->blob_operations["function"];
		$selectUrl = $objHandler->$f("select", $this->args->editor, $this->name);
		$ret .= '
			<script>
				function '.$this->name.'_selectFile_complete(window, id, alt, img, filename, type_id, category, w, h, href, handler, hname) {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(href.join) {
						for(var i=0; i<href.length; i++) {
							h = href[i];
							var opt = document.createElement("OPTION");
							hf.value += h+";\n";
							opt.innerHTML=h; 
							opt.value=h;
							try{
								hfselector.options.add(opt);
							}
							catch(ex) {
								hfselector.appendChild(opt);
							}
						}
					}
					else {
						hf.value += href+";\n";
						var opt = document.createElement("OPTION");
						opt.innerHTML=href;
						opt.value=href;
						try{
							hfselector.options.add(opt);
						}
						catch(ex) {
							hfselector.appendChild(opt);
						}
					}
				}
				function '.$this->name.'_deleteFile() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					var selected = hfselector.selectedIndex;
					selected = hfselector.options[selected];
					hfselector.removeChild(selected);
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
					}
				}
				function '.$this->name.'_selectFile() {
					var hf = document.getElementById("'.$this->name.'");
					src = "'.$selectUrl.'";
					wnd = window.open(src, "selectfile", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
					wnd.opener = window;
				}
				function '.$this->name.'_descriptFile() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(hfselector.selectedIndex < 0)
						return;
					var selected = hfselector.selectedIndex;
					selected = hfselector.options[selected];
					var v = selected.innerHTML.split(":");
					if(v.length > 1) { v = v[1]; } else { v = ""; }
					var ret = window.prompt("Input description of the file please", v);
					if(ret != undefined) {
						if(ret == "")
							selected.innerHTML = selected.value;
						else
							selected.innerHTML = selected.value+":"+ret;
					}
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
					}
				}
				function  '.$this->name.'_upItem() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(hfselector.selectedIndex < 0)
						return;
					var selected = hfselector.selectedIndex;
					var arr = new Array();
					for(var i=0; i<hfselector.options.length; i++) {
						arr[arr.length] = hfselector.options[i];
					}
					var removed = arr.splice(selected, 1);
					arr.splice(selected-1, 0, removed[0]);
					hfselector.innerHTML = "";
					for(var i=0; i<arr.length; i++) {
                        try{
                            hfselector.options.add(arr[i]);
                        }
                        catch(ex) {
                            hfselector.appendChild(arr[i]);
                        }                        
					}
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
					}
				}
				function  '.$this->name.'_downItem() {
					var hf = document.getElementById("'.$this->name.'");
					var hfselector = document.getElementById("'.$this->name.'selector");
					if(hfselector.selectedIndex < 0)
						return;
					var selected = hfselector.selectedIndex;
					var arr = new Array();
					for(var i=0; i<hfselector.options.length; i++) {
						arr[arr.length] = hfselector.options[i];
					}
					var removed = arr.splice(selected, 1);
					arr.splice(selected+1, 0, removed[0]);
					hfselector.innerHTML = "";
					for(var i=0; i<arr.length; i++) {
                        try{
                            hfselector.options.add(arr[i]);
                        }
                        catch(ex) {
                            hfselector.appendChild(arr[i]);
                        }                        
					}
					hf.value = "";
					for(var i=0; i<hfselector.options.length; i++) {
						hf.value += hfselector.options[i].innerHTML+";\n";
					}
				}				
			</script>
		';
		$valuess = explode(";", str_replace_ex($value, "\n\r", ""));
		$values = '';
		foreach($valuess as $v) {
			if(strlen(trim($v)) > 0) {
				$vv = explode(':', $v);
				if(count($vv) > 1) {
					$v = trim($vv[0], "\n\r");
					$v1 = ":".$vv[1];
				}
				else {
					$v = trim($v, "\r\n");
					$v1 = "";
				}
				$values .= '<option value="'.$v.'">'.$v.$v1.'</option>';
			}
		}
		$ret .= '
			<table width="100%">
				<tr>
					<td>
						<a href="javascript: '.$this->name.'_descriptFile();"><img src="images/icons/op_import.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_deleteFile();"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_selectFile();"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
						<img src="/admin/images/1x1.gif" width="15" height="10" />
						<a href="javascript: '.$this->name.'_upItem();"><img src="images/icons/op_moveup.gif" border="0" hspace="2"></a>
						<a href="javascript: '.$this->name.'_downItem();"><img src="images/icons/op_movedown.gif" border="0" hspace="2"></a>
					</td>
				</tr>
				<tr>
					<td>
						<select name="'.$this->name.'selector" id="'.$this->name.'selector" size="5" style="width: 98%; height: 120px; font-size: 11px; font-family: courier new" ondblclick="javascript: '.$this->name.'_descriptFile();">
						'.$values.'
						</select>
						<textarea name="'.$this->name.'" id="'.$this->name.'" style="width: 98%; height: 70px; display: none" wrap="On">'.$value.'</textarea>
					</td>
				</tr>
			</table>
		';
		return $ret;
	}
	public function Validate() {
		global $core;
		$this->isValid = true;
		$errofile = "";
        if($this->value instanceof FileList)
            $this->value = $this->value->ToString();
		$files = explode(";", str_replace("\r", "", str_replace("\n", "", $this->value)));
		if(!is_array($files)) $files = array($this->value);
		foreach($files as $file) {
			if(trim($file) != "") {
				$filev = explode(":", $file);
				if(!$core->fs->fileexists($filev[0])) {
					$this->isValid = false;
					$errofile = $file;
					break;
				}
			}
		}
		if(!$this->isValid)
			$this->message = "Invalid file: path=".$errofile;
		return $this->isValid;
	}
}
?><?php
class HtmlExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "";
		if(is_empty($this->styles))
			$this->styles = "width: 100%; height: 340px;";
	}
	public function Render() {
		$ret = '';
        global $core;
        $shh = $this->name."_showhtml";
        $ret .= $this->RenderScripts(); 
        if($core->rq->$shh == "1") {
            $ret .= $this->RenderHTMLControl();
        }
        else {
            $ret .= $this->RenderMemoBox();
        }
		return $ret;
	}
    public function RenderScripts($script = "") {
        $script .= '
            <script language="javascript">
                // HTML Control scripts
                // <!--
                function evtHTMLProcessTab(e) {
                    if(!e)
                        e = window.event;
                    if(window.browserType == "IE") {
                        if(e.keyCode == 9) { 
                            var r = document.selection.createRange();
                            r.text = \'\t\'; 
                            r.collapse(false);
                            r.select();
                            return false;
                        }
                    }
                    else {
                        if(e.keyCode == 9) {
                            var obj = e.target;
                            start = obj.selectionStart;
                            obj.value = obj.value.substr(0,start)+\'\t\'+obj.value.substr(start);
                            obj.setSelectionRange(start+1, start+1);
                            obj.focus();
                            return false;
                        }
                    }
                }
                // -->
                // HTML Contol scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
    function RenderMemoBox() {
        global $postback;
        $this->CheckValue();
        return '
            <input type="hidden" name="'.$this->name.'_showhtml" value="0">
            <table width="100%" cellpadding=0 cellspacing=0>
             <tr>
                <td style="padding:0px;">
                    <table cellpadding=0 cellspacing=0>
                    <tr><td><input type="image" valign="absmiddle" src="images/icons/word.gif" border="0" hspace="2" onclick="javascript: this.form.method = \'post\'; this.form.elements[\''.$this->name.'_showhtml\'].value=\'1\'; this.form.submit(); " title="'.$postback->lang->load_vseditor.'">
                    </td><td>'.$postback->lang->load_vseditor.'
                    </td></tr>
                    </table></td>
             </tr>
             <tr>
                <td style="padding:0px;"><textarea class="'.$this->class.'" style="'.$this->styles.'" wrap="off" name="'.$this->name.'" '.$this->attributes.' onkeydown="javascript: return evtHTMLProcessTab(event);">'.$this->value.'</textarea></td>
             </tr>
             </table>'; 
    }
    function RenderHTMLControl() {
        global $admin_html_styles;
        preg_match('/width:(.*); height:(.*)/', $this->styles, $matches);
        $c = FCKeditor::Instance($this->name, $this->value, $matches[1], $matches[2], array(
                "CustomConfigurationsPath" => "../pioneer/pioneer.config.js?t=".microtime(true),
                "EditorAreaCSS" => $admin_html_styles["style"],
                "StylesXmlPath" => $admin_html_styles["xml"]                
            ));
        return $c->CreateHtml();
    }
	public function Validate() {
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) { 
			if(!is_string($this->value))
				$this->message = "Value of this field must be a string";
			$this->isValid = is_string($this->value);
		}
		return $this->isValid;
	}
}
?><?php
class ListExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->styles .= "width: 100%; height: 120px; overflow: auto; border: 1px solid #c0c0c0";
	}
	public function Render() {
		$valuesviewed = $this->value[0];
		$valuesselected = $this->value[1];
		$selectedvalues = "";
		foreach($valuesselected as $v) {
			if(is_object($v)) {
				$valueField = $this->args->valueField;
				$v = $v->$valueField;
			}
			$selectedvalues .= ",".$v;
		}
		$selectedvalues = substr($selectedvalues, 1);
		$ret = '
			<script>
				function '.$this->name.'_setCheck(obj, e) {
					var srcElement = null;
					if(window.browserType == "IE")
						srcElement = e.srcElement;
					else 
						srcElement = e.currentTarget;
					{
						if(srcElement.tagName != "INPUT")
							obj.childNodes[0].childNodes[0].checked = !obj.childNodes[0].childNodes[0].checked;
						obj.className = obj.childNodes[0].childNodes[0].checked ? "selected" : "normal";
					}
					var value = "";
					var i=1;
					var o = document.getElementById("id'.$this->name.'[0]");
					while(o != null) {
						value += o.checked ? o.value+"," : "";
						o = document.getElementById("id'.$this->name.'["+i+"]");
						i++;
					}
					value = value.substr(0, value.length-1);
					document.getElementById("id'.$this->name.'hidden").value = value;
				}
				</script>
				<div style="'.$this->styles.'">
				<input type="hidden" name="'.$this->name.'" value="'.$selectedvalues.'" id="id'.$this->name.'hidden" />
				<table width="100%">
		';
		$i = 0;
		foreach($valuesviewed as $value) {
			$title = $value;
			if(is_object($value)) {
				$titlefield = $this->args->titleField;
				$valuefield = $this->args->valueField;
				$title = $value->$titlefield;
				$value = $value->$valuefield;
			}
			$selected = ($valuesselected->IndexOf($value) !== false);
			$ret .= '<tr class="'.($selected ? 'selected' : 'normal').'" onclick="javascript: '.$this->name.'_setCheck(this, event)"><td width="20"><input type="checkbox" id="id'.$this->name.'['.$i.']" value="'.$value.'" '.($selected ? 'checked="checked"' : '').'></td><td>'.$title.'</td></tr>';
			$i++;
		}
		$ret .= '
				</table>
				</div>
		';
		$disstart = '';
		$disend = '';
		if($this->disabled) {
			$disstart = '<div disabled="disabled">';
			$disend = '</div>';
		}
		return $disstart.$ret.$disend;
	}	
}
?><?
class MultiselectExControl extends Control {
    public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
        parent::__construct($name, $value, $required, $args, $className, $styles);
        $this->styles .= "width: 100%; height: 120px; overflow: auto; border: 1px solid #c0c0c0";
    }
    public function Render() {
                $valuesviewed = new Collection();
        $valuesviewed->FromString($this->values, "\n", ":");
        if(is_string($this->value)) {
            $v = $this->value;
            $this->value = new ArrayList();
            $this->value->FromString($v);
        }
        $selectedvalues = $this->value instanceOf Collection ? join(",", $this->value->Keys()) : $this->value->ToString();
        $valuesselected = $this->value;
        if($valuesselected instanceOf Collection)
            $valuesselected = new ArrayList($valuesselected->Keys());
        $field = $this->field;
        $ret = '
            <script>
                function '.$this->name.'_setCheck(obj, e) {
                    var srcElement = null;
                    if(window.browserType == "IE")
                        srcElement = e.srcElement;
                    else 
                        srcElement = e.currentTarget;
                    {
                        if(srcElement.tagName != "INPUT")
                            obj.childNodes[0].childNodes[0].checked = !obj.childNodes[0].childNodes[0].checked;
                        obj.className = obj.childNodes[0].childNodes[0].checked ? "selected" : "normal";
                    }
                    var value = "";
                    var i=1;
                    var o = document.getElementById("id'.$this->name.'[0]");
                    while(o != null) {
                        value += o.checked ? o.value+"," : "";
                        o = document.getElementById("id'.$this->name.'["+i+"]");
                        i++;
                    }
                    value = value.substr(0, value.length-1);
                    document.getElementById("id'.$this->name.'hidden").value = value;
                }
                </script>
                <div style="'.$this->styles.'">
                <input type="hidden" name="'.$this->name.'" value="'.$selectedvalues.'" id="id'.$this->name.'hidden" />
                <table width="100%">
        ';        
        if($field->isLookup) {
            $lookup = $field->SplitLookup();
            $query = (!is_empty($lookup->query)) ? $lookup->query : "SELECT ".$lookup->fields." FROM ".$lookup->table."".(is_empty($lookup->condition) ? "" : " where ".$lookup->condition).(is_empty($lookup->order) ? "" : " order by ".$lookup->order);
            global $core;
            $r = $core->dbe->ExecuteReader($query);
            $vvvs = "";
            $i = 0;
            while($row = $r->Read()) {
                $leveled = !is_null(@$row->level) ? 'style="padding-left: '.((@$row->level - 1)*20).'px;"' : '';
                $show  = $lookup->show;
                $id = $lookup->id;
                $selected = (boolean)($valuesselected->IndexOf($row->$id, false) !== false);
                $ret .= '
                <tr class="'.($selected ? 'selected' : 'normal').'" onclick="javascript: '.$this->name.'_setCheck(this, event)"><td width="20"'.$leveled.'><input type="checkbox" id="id'.$this->name.'['.$i.']" value="'.$row->$id.'" '.($selected ? 'checked="checked"' : '').' style="float:left; margin-right: 5px;"><label style="display: block; padding-top: 2px; ">'.$row->$show.'</label></td></tr>
                ';
                $i++; 
            }
        }
        else {
            $i = 0;
            foreach($valuesviewed as $k => $value) {
                $title = $value;
                $selected = (boolean)($valuesselected->IndexOf($k, false) !== false);
                $ret .= '<tr class="'.($selected ? 'selected' : 'normal').'" onclick="javascript: '.$this->name.'_setCheck(this, event)"><td width="20"><input type="checkbox" id="id'.$this->name.'['.$i.']" value="'.$k.'" '.($selected ? 'checked="checked"' : '').'></td><td>'.$title.'</td></tr>';
                $i++; 
            }
        }
        $ret .= '
                </table>
                </div>
        ';
        $disstart = '';
        $disend = '';
        if($this->disabled) {
            $disstart = '<div disabled="disabled">';
            $disend = '</div>';
        }
        return $disstart.$ret.$disend;
    }    
}
?>
<?php
class LookupExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
	}
	public function Render() {
		global $core;
		$ret = "";
		$required = $this->required;
		$value = $this->value;
		$lookup = $this->lookup;
        if(!($lookup instanceOf Lookup)) {
            $slookup = explode(":", $lookup);
            $lookup = new Lookup($slookup[0], $slookup[1], $slookup[2], $slookup[3], $slookup[4], $slookup[5], $slookup[6]);
        }
		$table = $lookup->table;
		$qfields = $lookup->fields;
		$idfield = $lookup->id;
		$sfields = $lookup->show;
		$cond = $lookup->condition;
        $order = $lookup->order;
		$query = $lookup->fullquery;
		if(is_object($value))
			$value = $value->$idfield;
		$query = (!is_empty($query)) ? $query : "SELECT ".$qfields." FROM ".$table."".(is_empty($cond) ? "" : " where ".$cond).(is_empty($order) ? '' : ' order by '.$order);
		$show_fields_list = explode(",", $sfields);
		for ($i = 0; $i < count($show_fields_list); $i++)
			$show_fields_list[$i] = trim($show_fields_list[$i]);
		$q = $query;
		$result = $core->dbe->ExecuteReader($q)->ReadAll();
		if(count($show_fields_list) == 1) {
			$ret .= RenderSelectCheck($this->name, $value, "60%", $required, $result, $idfield, $show_fields_list[0]);
		}
		else {
			$s = storages::get($table);
			$ret .= RenderVerticalCheck($this->name, $value, "100%", "300px", $required, $s, $s->fields, $show_fields_list, $result, $idfield);
		}
		return $ret;
	}
}
?><?php
class MemoExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "textbox";
		if(is_empty($this->styles))
			$this->styles = "width: 100%; height: 120px;";
	}
    public function RenderScripts($script = "") {
        $script .= '
            <script language="javascript">
                // HTML Control scripts
                // <!--
                function evtMEMOProcessTab(e) {
                    if(!e)
                        e = window.event;
                    if(window.browserType == "IE") {
                        if(e.keyCode == 9) { 
                            var r = document.selection.createRange();
                            r.text = \'\t\'; 
                            r.collapse(false);
                            r.select();
                            return false;
                        }
                    }
                    else {
                        if(e.keyCode == 9) {
                            var obj = e.target;
                            start = obj.selectionStart;
                            obj.value = obj.value.substr(0,start)+\'\t\'+obj.value.substr(start);
                            obj.setSelectionRange(start+1, start+1);
                            obj.focus();
                            return false;
                        }
                    }
                }
                // -->
                // HTML Contol scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
	public function Render() {
		if(!is_empty($this->values))
			return $this->RenderSelect();
        $this->CheckValue();
		return 	$this->RenderScripts().'<textarea class="'.$this->class.'" style="'.$this->styles.'" name="'.$this->name.'" '.$this->attributes.' onkeydown="javascript: return evtMEMOProcessTab(event);">'.$this->value.'</textarea>'; 
	}
	public function Validate() {
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) { 
			if(!is_string($this->value))
				$this->message = "Value of this field must be a string";
			$this->isValid = is_string($this->value);
		}
		return $this->isValid;
	}
}
?><?php
class MultilinkFieldExControl extends Control {
	public $blob_operations;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		$this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
	}
	function getBlobOperations($operation, $field, $storage, $data = null) {
		switch($operation) {
			case "select":
				$datas= "";
				if(!is_null($data))
					$datas = $data->Values();
				return 'floating.php?postback_section=publications&postback_action=multilink&postback_command=select&handler='.$field.'_multilink_complete&storage_id='.$storage->table.'&data_ids='.$datas;
			case "add":
				return 'floating.php?postback_section=publications&postback_action=multilink&postback_command=add&handler='.$field.'_multilink_complete&storage_id='.$storage->table;
			case "edit":
				return 'floating.php?postback_section=publications&postback_action=multilink&postback_command=edit&handler='.$field.'_multilink_complete&storage_id='.$storage->table;
		}
	}
	public function Render() {
		global $core;
		$ret = "";
		$required = $this->required;
		$value = $this->value;
		if($this->args->type != "memo") {
			$ret .= "-- invalid multilink --";
		}
		else { 
			$s = storages::get($this->multilink);
			if(!is_null($s)) {
				if(!($value instanceof MultilinkField))
					$value = new MultilinkField($s, $value);
				$objHandler = $this->blob_operations["handlerObject"];
				$f = $this->blob_operations["function"];
	 			$selectUrl = $objHandler->$f("select", $this->name, $s, $value);
				$addUrl = $objHandler->$f("add", $this->name, $s);
				$editUrl = $objHandler->$f("edit", $this->name, $s);
				$ret .= '
					<script>
						function  '.$this->name.'_multilink_complete(operation, html, id) {
							var objectlist = document.getElementById("id'.$this->name.'viewtable");
							var obj = document.getElementById("'.$this->name.'");
							switch(operation) {
								case "add":
									var row = objectlist.insertRow(objectlist.rows.length);
									if(window.browserType == "IE")
										row.setAttribute("onclick", new Function("javascript: return setRowCheck(this);"));
									else
										row.setAttribute("onclick", "javascript: return setRowCheck(this);");
									row.setAttribute("id", "'.$this->name.'view_"+id+"row");
									var cell = row.insertCell(row.cells.length);
									cell.innerHTML = html;
									var cell = row.insertCell(row.cells.length);
									cell.innerHTML = "<input type=\"checkbox\" name=\"'.$this->name.'view_"+id+"\" value=\""+id+"\" hilitable=1>";
									var arr = new Array();
									if(obj.value != "")
										arr = obj.value.split(",");
									arr[arr.length] = id;
									obj.value = arr.join(",");
									break;
								case "edit":
									var row = document.getElementById("'.$this->name.'view_"+id+"row");
									row.cells[0].innerHTML = html;
									break;
								case "select":
									var arr = new Array();
									if(obj.value != "")
										arr = obj.value.split(",");
									for(var i=0; i<html.length; i++) {
										var h=html[i];
										var row = objectlist.insertRow(objectlist.rows.length);
										if(window.browserType == "IE")
											row.setAttribute("onclick", new Function("javascript: return setRowCheck(this);"));
										else
											row.setAttribute("onclick", "javascript: return setRowCheck(this);");
										row.setAttribute("id", "'.$this->name.'view_"+h[0]+"row");
										var cell = row.insertCell(row.cells.length);
										cell.innerHTML = h[1];
										var cell = row.insertCell(row.cells.length);
										cell.innerHTML = "<input type=\"checkbox\" name=\"'.$this->name.'view_"+h[0]+"\" value=\""+h[0]+"\" hilitable=1>";
										arr[arr.length] = h[0];
									}
									obj.value = arr.join(",");
									break;
							}
						}
						function  '.$this->name.'_addItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							src = "'.$addUrl.'";
							wnd = window.open(src, "", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
							wnd.opener = window;
						}
						function  '.$this->name.'_editItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							src = "'.$editUrl.'";
							var selectedItems = countSelectedChecks(hf);
							if(selectedItems.length > 1) {
								alert("'.@$this->args->texts['em_multipleedit'].'");
								return;
							}
							if(selectedItems.length == 0) {
								alert("'.@$this->args->texts['em_noselection'].'");
								return;
							}
							wnd = window.open(src+"&data_id="+selectedItems[0].value, "", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
							wnd.opener = window;
						}
						function  '.$this->name.'_deleteItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							var selectedItems = countSelectedChecks(hf);
							var obj = document.getElementById("'.$this->name.'");
							var arr = new Array();
							if(obj.value != "")
								arr = obj.value.split(",");
							for(var i=0; i<selectedItems.length;i++) {
								var j = -1;
								for(j=0; j<arr.length;j++) {
									if(arr[j] == selectedItems[i].value)
										break;
								}
								if(j >= 0)
									arr.splice(j, 1);
								hf.deleteRow(selectedItems[i].parentNode.parentNode.rowIndex);
							}
							obj.value = arr.join(",");
						}
						function  '.$this->name.'_selectItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							src = "'.$selectUrl.'";
							wnd = window.open(src, "", "status=0,help=0,resizable=1,scrollbars=0, width=750,height=500");
							wnd.opener = window;							
						}
						function  '.$this->name.'_upItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							var selectedItems = countSelectedChecks(hf);
							var obj = document.getElementById("'.$this->name.'");
							if(selectedItems.length > 1) {
								alert("'.@$this->args->texts['em_multipleedit'].'");
								return;
							}
							if(selectedItems.length == 0) {
								alert("'.@$this->args->texts['em_noselection'].'");
								return;
							}
							var arr = new Array();
							if(obj.value != "")
								arr = obj.value.split(",");
							var selected = selectedItems[0];
							var j = -1;
							for(j=0; j<arr.length;j++) {
								if(arr[j] == selected.value)
									break;
							}
							if(j >= 0) {
								val = arr[j];
								arr.splice(j, 1);
								arr.splice(j-1, 0, val);
							}
							obj.value = arr.join(",");
							var r = selected.parentNode.parentNode;
							var row = hf.insertRow(r.rowIndex-1);
							row.setAttribute("id", r.id);
							row.setAttribute("onclick", r.getAttribute("onclick"));
							var cell = row.insertCell(row.cells.length);
							cell.innerHTML = r.cells[0].innerHTML;
							var cell = row.insertCell(row.cells.length);
							cell.innerHTML = r.cells[1].innerHTML;
							hf.deleteRow(r.rowIndex);
							setRowCheck(row, true);
						}
						function  '.$this->name.'_downItem() {
							var hf = document.getElementById("id'.$this->name.'viewtable");
							var selectedItems = countSelectedChecks(hf);
							var obj = document.getElementById("'.$this->name.'");
							if(selectedItems.length > 1) {
								alert("'.@$this->args->texts['em_multipleedit'].'");
								return;
							}
							if(selectedItems.length == 0) {
								alert("'.@$this->args->texts['em_noselection'].'");
								return;
							}
							var arr = new Array();
							if(obj.value != "")
								arr = obj.value.split(",");
							var selected = selectedItems[0];
							var j = -1;
							for(j=0; j<arr.length;j++) {
								if(arr[j] == selected.value)
									break;
							}
							if(j >= 0 && j < arr.length) {
								val = arr[j];
								arr.splice(j, 1);
								arr.splice(j+1, 0, val);
							}
							obj.value = arr.join(",");
							var r = selected.parentNode.parentNode;
							if(r.rowIndex+1 < hf.rows.length) {
								var row = hf.insertRow(r.rowIndex+2);
								row.setAttribute("id", r.id);
								row.setAttribute("onclick", r.getAttribute("onclick"));
								var cell = row.insertCell(row.cells.length);
								cell.innerHTML = r.cells[0].innerHTML;
								var cell = row.insertCell(row.cells.length);
								cell.innerHTML = r.cells[1].innerHTML;
								hf.deleteRow(r.rowIndex);
								setRowCheck(row, true);
							}
						}
					</script>
					<table width="100%">
						<tr>
						<td>
							<a href="javascript: '.$this->name.'_addItem();"><img src="images/icons/op_add.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_editItem();"><img src="images/icons/op_edit.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_deleteItem();"><img src="images/icons/op_remove.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_selectItem();"><img src="images/icons/folder_opened.gif" border="0" hspace="2"></a>
							<img src="/admin/images/1x1.gif" width="15" height="10" />
							<a href="javascript: '.$this->name.'_upItem();"><img src="images/icons/op_moveup.gif" border="0" hspace="2"></a>
							<a href="javascript: '.$this->name.'_downItem();"><img src="images/icons/op_movedown.gif" border="0" hspace="2"></a>
						</td>
						</tr>
						<tr>
						<td>
							<textarea name="'.$this->name.'" id="'.$this->name.'" style="display: none">'.$value->Values().'</textarea>
				';
				$ret .= RenderVerticalCheckboxes($this->name.'view', $value, "100%", "300px", $required);
				$ret .= '
						</td>
						</tr>
					</table>
				';
			}
			else {
				$ret .= "-- invalid multilink --";
			}
		}
		return $ret;
	}	
}
?><?php
class NumericExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value == (int)$value ? (int)$value : $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "textbox";
		if(is_empty($this->styles))
			$this->styles = "width: 200px; text-align: right";
	}
	public function Render() {
		if(!is_empty($this->values))
			return $this->RenderSelect();
		return '<input class="'.$this->class.'" style="'.$this->styles.';" type="text" name="'.$this->name.'" value="'.$this->value.'" '.($this->disabled ? 'disabled="disabled"' : '').' '.$this->attributes.'>';
	}
	public function Validate() {
		if($this->required && (is_empty($this->value) && $this->value != 0)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) { 
			if(!is_numeric($this->value))
				$this->message = "This field must contain a numeric value";
			$this->isValid = is_numeric($this->value);
		}
		return $this->isValid;
	}
}
?><?php
class TextExControl extends Control {
	public $isPassword;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "", $isPassword = false) {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "textbox";
		if(is_empty($this->styles))
			$this->styles = "width: 100%";
		$this->isPassword = $isPassword;
	}
	public function Render() {
		if(!is_empty($this->values))
			return $this->RenderSelect();
		return '<input class="'.$this->class.'" style="'.$this->styles.'; " type="'.($this->isPassword ? 'password' : 'text').'" name="'.$this->name.'" value="'.hide_char($this->value, "\"").'" '.($this->disabled ? ' disabled="disabled"' : '').' '.$this->attributes.'>';
			}
	public function Validate() {
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) {  
			if(!is_string($this->value))
				$this->message = "Value of this field must be a string";
			if(strlen($this->value) > 255)
				$this->message = "Value of this field must be less than 255 characters";
			$this->isValid = is_string($this->value) && strlen($this->value) <= 255;
		}
		return $this->isValid;
	}
}
?><?php
class TreeExControl extends Control {
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		preg_match('/width:(.*);?/', $this->styles, $matches);
		$width = "";
		if(count($matches) == 0)
			$width = "width:100%;";
		preg_match('/height:(.*);?/', $this->styles, $matches);
		$height = "";
		if(count($matches) == 0)
			$height = "height:240px;";
		$this->styles .= $width.$height."overflow: auto; border: 1px solid #c0c0c0";
		if(is_null($this->args->notselected))
			$this->args->notselected = "";
		if(is_null($this->args->checked))
			$this->args->checked = "+";
		if(is_null($this->args->unchecked))
			$this->args->unchecked = "-";
		if(is_null($this->args->joinnames))
			$this->args->joinnames = true;
		if(is_null($this->args->parseselected))
			$this->args->parseselected = true;
	}
	private function RenderLevel($nodes, $selected, &$i, $l) {
		$ret = '
            <style>
                .treecontrol tr td {
                    border-bottom: 1px dashed #f2f2f2;
                }
            </style>
			<table width="100%" class="treecontrol">
		';
		$cf = $this->args->checkField;
		$vf = $this->args->valueField;
		foreach($nodes as $key => $node) {
			$tt = "";
			if(is_object($node))
				$tt	= ".*";
			if($this->args->joinnames)	
				$vv = $l.".".$key.$tt;
			else
				$vv = $key.$tt;
			$s = -1;
			$rr = $selected->Search($cf, $vv);
			if(!is_null($rr)) {
				$s = intval($rr->$vf);
			}
			$ret .= '
					<tr>
					<td width="40">
						<input type="hidden" value="'.$l.".".$key.$tt.'" id="id_operation_'.$this->name.'['.$i.']" up="0" />
						<select id="id_permission_'.$this->name.'['.$i.']" onchange="javascript: '.$this->name.'setAllowDeny();">
							<option value="">'.$this->args->notselected.'</option>
							<option value="1" '.($s === 1 ? 'selected="selected"' : '').'>'.$this->args->checked.'</option>
							<option value="0" '.($s === 0 ? 'selected="selected"' : '').'>'.$this->args->unchecked.'</option>
						</select>
					</td>
					<td class="selected">
						'.$key.'
					</td>
					</tr>				 
			';
			$i++;
			if(is_object($node))
				$ret .= '	
					<tr>
						<td width="40">
						</td>
						<td>
						'.$this->RenderLevel($node, $selected, $i, $l.".".$key).'
						</td>
					</tr>			 
				';
		}
		$ret .= '
				</table>		
		';
		return $ret;
	}
	public function Render() {
		$tree = $this->value[0];
		$selected = $this->value[1];
		$selectedvalues = "";
		foreach($selected as $v) {
			$selectedvalues .= ",".$v->operation.":".$v->permission;
		}
		$selectedvalues = substr($selectedvalues, 1);
		$ret = '
			<script>
				function '.$this->name.'setAllowDeny() {
					var value = "";
					var i=1;
					var o = document.getElementById("id_operation_'.$this->name.'[0]");
					var v = document.getElementById("id_permission_'.$this->name.'[0]");
					while(o != null) {
						if(o.getAttribute("up") == 1)
							value += v.selectedIndex == 0 ? o.value+":1," : "";
						else {
							if(v.selectedIndex > 0)
								value += o.value+":"+(v.selectedIndex == 1 ? 1 : 0)+",";
						}
						o = document.getElementById("id_operation_'.$this->name.'["+i+"]");
						v = document.getElementById("id_permission_'.$this->name.'["+i+"]");
						i++;
					}
					value = value.substr(0, value.length-1);
					document.getElementById("id'.$this->name.'hidden").value = value;
				}
				</script>
				<div style="'.$this->styles.'">
				<input type="hidden" name="'.$this->name.'" value="'.$selectedvalues.'" id="id'.$this->name.'hidden" />
				<table width="100%">
		';
		$i = 0;
		$cf = $this->args->checkField;
		$vf = $this->args->valueField;
		foreach($tree as $key => $node) {
			$tt = "";
			if(is_object($node))
				$tt	= ".*";
			$vv = $key.$tt;
			$rr = $selected->Search($cf, $vv);
			$s=0;
			if(!is_null($rr)) {
				$s = intval($rr->$vf);
			}
			$ret .= '
					<tr>
					<td width="40">
						<input type="hidden" value="'.$key.$tt.'" id="id_operation_'.$this->name.'['.$i.']" up="1" />
						<select id="id_permission_'.$this->name.'['.$i.']" onchange="javascript: '.$this->name.'setAllowDeny(\'id_operation_'.$this->name.'['.$i.']\');">
							<option value="1" '.($s === 1 ? 'selected="selected"' : '').'>'.$this->args->checked.'</option>
							<option value="0" '.($s === 0 ? 'selected="selected"' : '').'>'.$this->args->unchecked.'</option>
						</select>
					</td>
					<td>
						'.$key.'
					</td>
					</tr>
			';
			$i++;
			if(is_object($node))
				$ret .= '	
					<tr>
						<td width="40">
						</td>
						<td>
							'.$this->RenderLevel($node, $selected, $i, $key).'
						</td>
					</tr>			 
				';
		}
		$ret .= '
				</table>
				</div>
		';
		$disstart = '';
		$disend = '';
		if($this->disabled) {
			$disstart = '<div disabled="disabled">';
			$disend = '</div>';
		}
		return $disstart.$ret.$disend;
	}	
}
?><?php
class Control extends IEventDispatcher {
    static $scriptsRendered;
	public $name;
	public $value;
	public $class;
	public $styles;
	public $required;
	public $args;
	public $disabled;
	public $attributes;
	public $values;
	public $lookup;
	public $multilink;
	public $message;
	public $isValid;
	public $showRequired;
	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		$this->showRequired = true;
		$this->name = $name;
		$this->value = $value;
		$this->class = $className;
		$this->styles = $styles;
		$this->required = $required;
		$this->args = $args;
		$this->values = null;
		$this->isValid = true;
		$this->message = "";
		if(is_null($this->args))
			$this->args = new Collection();
		$this->disabled = $this->args->disabled;
		if(is_null($this->disabled))
			$this->disabled = false;
		Control::$scriptsRendered = false;
		$this->attributes = $this->args->attributes;
	}
    function CheckValue() {
        $this->value = str_replace('</textarea>', '&lt/textarea>', $this->value);
    }
    public function RenderScripts($script = "") {
        $b = false;
        eval("\$b = ".get_class($this)."::\$scriptsRendered;");
        if(!$b) {
            eval(get_class($this)."::\$scriptsRendered = true;");
            return $script;
        }
        return "";
    }
	public function valueOf() {
		global $core;
        $name = $this->name;
		if(!is_null($core->rq->$name))
			return $core->rq->$name;
		else {
			return null;
		}
	}
	public function Render() {
		return "";
	}
	protected function RenderSelect() {
		$values = $this->values;
		$result = new Collection();
		$r = explode("\n", $values);
		foreach($r as $v) {
            if(!is_empty(trim($v))) {
			    $v = explode(":", $v);
			    $vv = new stdClass();
			    $vv->id = trim($v[0]);
			    $vv->text = @trim($v[1]);
			    $result->Add(null, $vv);
            }
		}	
		return RenderSelectCheck($this->name, $this->value, "60%", $this->required == 0 ? false : true, $result, "id", "text");
	}
	public function Validate() {
		return $this->isValid;
	}
}
?><?php
class Core {
	public $serviceMode;
	public $securityMode;
	public $sessionEnabled;
	public $moduleEnabled;
    public $driver;
	public $server;
	public $database;
	public $user;
	public $password;
	public $sitePath;
	public $corePath;
	public $adminPath;
	public $mysqlBinDir;
	public $blobViewerUrl;
	public $Language;
	public $obenabled;
	public $obenconding;
	public $browserInfo;
	public $dbe;
	public $sts;
	public $rq;
	public $fs;	
	public $debug;
    public $nav;
	public $security;
	public $ob;
	public $stats;
	public $ed;
	public $ie;
	public $isAdmin;
	public function Core($server = "", $database = "", $user = "", $password = "", $driver = 'mysql') {
		global $SERVICE_MODE, $SECURITY_MODE, $SESSION_ENABLED, $MODULE_ENABLED;
		$this->isAdmin = false;
		if(substr($_SERVER["SCRIPT_NAME"], 0, 6) == "/admin") {
			$this->serviceMode = DEVELOPING;
			if(isset($SERVICE_MODE)) 
				$this->serviceMode = $SERVICE_MODE;
			$this->securityMode = SECURITYMODE_EMBEDED;	
			$this->sessionEnabled = true;
			$this->moduleEnabled = true;
			$this->isAdmin = true;
		}
		else {
			if(isset($SERVICE_MODE)) 
				$this->serviceMode = $SERVICE_MODE;
			else
				$this->serviceMode = DEVELOPING;
			if(isset($SECURITY_MODE))
				$this->securityMode = $SECURITY_MODE;
			else
				$this->securityMode = SECURITYMODE_EMBEDED;	
			if(isset($SESSION_ENABLED))
				$this->sessionEnabled = $SESSION_ENABLED;
			else
				$this->sessionEnabled = true;
			if(isset($MODULE_ENABLED)) 
				$this->moduleEnabled = $MODULE_ENABLED;
			else
				$this->moduleEnabled = true;
		}
		if($this->sessionEnabled)
			@session_start();		
        $this->driver = $driver;
		$this->server = $server;
		$this->database = $database;
		$this->user = $user;
		$this->password = $password;
	}
	private function _detectBrowserInfo() {
		$this->browserInfo = new Object();
		$this->browserInfo->name = browser_detection('browser');
		$this->browserInfo->version = browser_detection('number');
		$this->browserInfo->os = browser_detection( 'os' );
		$this->browserInfo->os_version = browser_detection( 'os_number' );
		$this->browserInfo->type = browser_detection( 'type' );
		$this->browserInfo->isIE6 = ($this->browserInfo->name == "ie" && $this->browserInfo->version < 7);
        $this->browserInfo->isIE7 = ($this->browserInfo->name == "ie" && $this->browserInfo->version == 7);
        $this->browserInfo->isIE = ($this->browserInfo->isIE6 || $this->browserInfo->isIE7);
        $this->browserInfo->isOpera = ($this->browserInfo->name == "op");
	}
	public function initialize($server = "", $database = "", $user = "", $password = "", $driver = 'mysql') {
        global $SITE_PATH;
        chdir($SITE_PATH);
		$this->_detectBrowserInfo();
        if(!empty($driver)) $this->driver = $driver;
		if(!empty($server)) $this->server = $server;
		if(!empty($database)) $this->database = $database;
		if(!empty($user)) $this->user = $user;
		if(!empty($password)) $this->password = $password;
		        $drv = $this->driver == "mysql" ? "MySqlDriver" : "PgSqlDriver";
        $driver = new $drv();
		$this->dbe = new DBEngine($driver);         $this->dbe->Connect($this->server, $this->user, $this->password, $this->database, true);
        $tables = $this->dbe->Tables();
        if($tables->Count() == 0) {
                        $this->dbe->scheme->CreateScheme() or die('Can not create scheme in database. Core can not be initialized');
            $this->dbe->scheme->InsertInitialData() or die('Can not insert required data');
        }
        Repository::Cache();
				if($this->serviceMode == DEVELOPING)
			$this->debug = new Debug();
		else
			$this->debug = null;
		$this->ed = CEventDispatcher::Instance(); 		
		if($this->moduleEnabled)	
			$this->mm = CModuleManager::Instance(); 		
		$this->ob = new ob(); 		
		$this->rq = new Request(); 		
		$this->fs = new FileSystem(); 		
		$this->sts = New Settings(); 
        $this->nav = new Navigator();
		if($this->securityMode == SECURITYMODE_EMBEDED)
			$this->security = new SecurityEx(); 		else
			$this->security = null;
		$this->stats = new Statistics(); 		
		$this->ie = new IndexEngine();
				if (method_exists($this->ob, "RegisterEvents")) $this->ob->RegisterEvents();
		if (method_exists($this->rq, "RegisterEvents")) $this->rq->RegisterEvents();
		if (method_exists($this->fs, "RegisterEvents")) $this->fs->RegisterEvents();
		if (method_exists($this->dbe, "RegisterEvents")) $this->dbe->RegisterEvents();
		if (method_exists($this->sts, "RegisterEvents")) $this->sts->RegisterEvents();
		if($this->security) 
            if (method_exists($this->security, "RegisterEvents")) $this->security->RegisterEvents();
		if (method_exists($this->stats, "RegisterEvents")) $this->stats->RegisterEvents();
		if (method_exists($this->ie, "RegisterEvents")) $this->ie->RegisterEvents();
				if (method_exists($this->ob, "RegisterEventHandlers")) $this->ob->RegisterEventHandlers();
		if (method_exists($this->rq, "RegisterEventHandlers")) $this->rq->RegisterEventHandlers();
		if (method_exists($this->fs, "RegisterEventHandlers")) $this->fs->RegisterEventHandlers();
		if (method_exists($this->dbe, "RegisterEventHandlers")) $this->dbe->RegisterEventHandlers();
		if (method_exists($this->sts, "RegisterEventHandlers")) $this->sts->RegisterEventHandlers();
		if($this->security)
	 		if (method_exists($this->security, "RegisterEventHandlers")) $this->security->RegisterEventHandlers();
		if (method_exists($this->stats, "RegisterEventHandlers")) $this->stats->RegisterEventHandlers();
        if (method_exists($this->ie, "RegisterEventHandlers")) $this->ie->RegisterEventHandlers();
				$this->ob->Initialize();
		$this->rq->Initialize();
		$this->fs->Initialize();
		$this->dbe->Initialize();
		$this->sts->Initialize(true);
		if($this->security)
			$this->security->Initialize();
		$this->stats->Initialize();
        if($this->moduleEnabled)
			$this->mm->Initialize();
        $this->ie->Initialize();
		$this->languages = new collection(); 		$r = $this->dbe->ExecuteReader("select * from sys_languages");
		while($lang = $r->Read())
			$this->languages->add($lang->language_id, $lang->language_view);
	}
	public function __destruct() {
	    $this->Dispose();
	}
	public function serialize($bload = false) {
		if(!is_object($this->rq))
			$this->rq = new Request();
		if(!$bload) {
	  		$this->rq->sitePath = $this->sitePath;
			$this->rq->blobViewerUrl = $this->blobViewerUrl;
			$this->rq->siteLanguage = $this->Language;
			$this->rq->obenabled = $this->obenabled;
			$this->rq->obenconding = $this->obenconding;
			$this->rq->server = $this->server;
			$this->rq->database = $this->database;
			$this->rq->user = $this->user;
			$this->rq->password = $this->password;
		}
		else {
			$this->server = $this->rq->server;
			$this->database = $this->rq->database;
			$this->user = $this->rq->user;
			$this->password = $this->rq->password;
	  		$this->sitePath = $this->rq->sitePath;
			$this->blobViewerUrl = $this->rq->blobViewerUrl;
			$this->Language = $this->rq->siteLanguage;
			$this->obenabled = $this->rq->obenabled;
			$this->obenconding = $this->rq->obenconding;
		}
	}
	public function get_database() {
		return $this->database;
	}
	public function abandone() {
		@session_destroy();
	}
	function Dispose() {
        unset($this->browserInfo);
                $this->dbe->disconnect();
        if($this->debug)
            $this->debug->Dispose();
        $this->ed->Dispose();
        if($this->mm) $this->mm->Dispose();
        $this->ob->Dispose();
        $this->rq->Dispose();
        $this->fs->Dispose();
        $this->sts->Dispose();
        if($this->security)
            $this->security->Dispose();
        $this->stats->Dispose();
        $this->ie->Dispose();
    }
}
?>