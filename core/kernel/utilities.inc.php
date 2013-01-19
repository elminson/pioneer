<?

    define("WEBPAGE", 0);

    define("DEBUG_ENABLE_OUT", 128);
    define("DEBUG_ENABLE_BP", 64);

    define("DEBUG_SIMPLE_SET", 0);
    define("DEBUG_STANDART_SET", 1);
    define("DEBUG_DETAILED_SET", 2);



    if(!defined("LOG_ERROR"))
        define("LOG_ERROR", "error");
    //if(!defined("LOG_WARNING"))
        //define("LOG_WARNING", "warning");
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
    //define("MODULE_INSTALLED", 8);

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

    /*
    function __ml2num($ml) {
        eval("\$ml=".str_replace("M", "*1024*1024", (string)$ml).";");
        return $ml;
    }

    function __get_memory_limit() {
        return __ml2num(ini_get("memory_limit"));
    }
    */

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
            return $parts[0].'.'.$parts[1].($pres-strlen($parts[1]) > 0 ? str_repeat('0', $pres-strlen($parts[1])) : '');
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
        // srand(make_seed());
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

    function str_random_ex($l, $chars) { // chars = array(array('A', 'Z'), array('a', 'z'))
        $j = 0;
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
        if(!$time) $time = time();
        return strftime("%Y-%m-%d %H:%M:%S", $time);
    }

/*
    function date_diff($d1, $d2){
        $d1 = (is_string($d1) ? strtotime($d1) : $d1);
        $d2 = (is_string($d2) ? strtotime($d2) : $d2);

        $diff_secs = abs($d1 - $d2);
        $base_year = min(date("Y", $d1), date("Y", $d2));

        $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
        return array(
            "years" => date("Y", $diff) - $base_year,
            "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
            "months" => date("n", $diff) - 1,
            "days_total" => floor($diff_secs / (3600 * 24)),
            "days" => date("j", $diff) - 1,
            "hours_total" => floor($diff_secs / 3600),
            "hours" => date("G", $diff),
            "minutes_total" => floor($diff_secs / 60),
            "minutes" => (int) date("i", $diff),
            "seconds_total" => $diff_secs,
            "seconds" => (int) date("s", $diff)
        );
    }
*/

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
            $mins = $number % 60; //(int)($number / 60);
            $number = (int)($number / 60);
            if($number >= 60) {
                $hours = $number % 60;
                $number = (int)($number / 60);
            }
        }

        $txt = "";
    //    if( $hours > 0 )
            $txt .= str_expand($hours, 2, "0").":";
    //    if( $mins > 0 || $hours > 0 )
            $txt .= str_expand($number, 2, "0").":";
    //    if( $number > 0 || $mins > 0 || $hours > 0 )
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
            return $s.$labels[2]; //"лет"
        else {
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
           # Check for this year string in date
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
           $numLeapYears = 0;        # Work out number of leap years in period
           for ($j=$replYear; $j<=1969; $j++) {
               $thisYear = $j;
               $isLeapYear = false;
               # Is div by 4?
               if (($thisYear % 4) == 0) {
                   $isLeapYear = true;
               };
               # Is div by 100?
               if (($thisYear % 100) == 0) {
                   $isLeapYear = false;
               };
               # Is div by 1000?
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
    //    $arDt[0] - day
    //    $arDt[1] - month
    //    $arDt[2] - year
    //    $arDt[3] - hour
    //    $arDt[4] - monute
    //    $arDt[5] - second

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
           // Valid range: 0.0.0.0 -> 255.255.255.255
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
            //out("\$inst = new ".$cname."(".$vars.")");
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
    
    function coalesce($data, $field, $default) {
        if($data)
            return $data->$field;
        else
            return $default;
    }

    function crop_object_fields($o, $pattern) {
        $ret = new stdClass();
        if (is_array($o)){
            $vars = $o;
        } else if($o instanceof Object) {
            $vars = $o->ToArray();
        } else {
            $vars = @get_object_vars($o);
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

	function mssql_escape($data) {
		/*if(is_numeric($data))
			return $data;
		$unpacked = unpack('H*hex', $data);
		return '0x' . $unpacked['hex'];*/
		if ( !isset($data) or empty($data) ) return '';
        if ( is_numeric($data) ) return $data;

        $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
        );
        foreach ( $non_displayables as $regex )
            $data = preg_replace( $regex, '', $data );
        $data = str_replace("'", "''", $data );
        return $data;
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
/*                        '@&(lt|#60);@i',
                        '@&(gt|#62);@i',
                        '<',
                        '>',
*/
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

    function db_prepare2($data) {
        if ( !isset($data) || is_empty($data) ) return '';
        if ( is_numeric($data) ) return $data;

        $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
        );
        foreach ( $non_displayables as $regex )
            $data = preg_replace( $regex, '', $data );
        $data = str_replace("'", "''", $data );
        return $data;
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
            /*else 
                $n = $n-1;*/
            
            $l = 0;
            for($j=0; $j<$n;$j++) {
                $l = $l + mb_strlen($a[$j])+1;
            }
            
            // $ellipsis = (count($a) > $n + 1) ? $ellipsis : "";
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

    function add2url($args, $url = ""){ //array(), array(folder, publication)
        if (count($args) == 0)
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
        //iout($args);
        $rewr = "";
        $params = "";

        $fileExists = stripos($path, ".") === true;
        
        //
        $rewrited_path = "";
        
        $p = explode("&", $path);
        
        foreach ($p as $v){
            list($key, $value) = explode("=", $v);
            if (($key == "folder" || $key == "publication") && !$fileExists)
                $rewrited_path .= "/".$value;
        }
        
        if ($rewrited_path)
            $path = $rewrited_path."/";
        //
        
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
        //out($piece);
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
        // $text = str_replace("\r", "", $text);
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
        flush();
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

    #endregion

    #region GUID emulation functions

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
            mt_srand((double)microtime()*10000);  //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                    .substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12)
                    .chr(125);// "}"
            return $uuid; //hexdec($charid);
        }
    }

    #endregion

    #region Interface functions

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

    //
    // css rule must have a description at the right side
    // example: .bold /*bold style text*/
    //
    function getStyleScheet($fname, $additems = array()) {

        if (file_exists($fname))
            $content = file_get_contents($fname);
        else
            $content = file_get_contents("http://".$_SERVER['SERVER_NAME'].$fname);
        
        /*clear \n\r*/
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
        //sort($arRet, SORT_STRING);
        
        $arRet = array_merge($additems, $arRet);
        
        return $arRet;
    }

    function RenderVerticalCheck($name, $value, $width, $height, $required, $storage, $fields, $shows, $rows, $idfield, $classes = null /*array*/) {
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

    function RenderSelectCheck($name, $value, $width, $required, $rows, $idfield, $show, $classes = null /*array*/) {
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

    function RenderVerticalCheckboxes($name, $value, $width, $height, $required, $classes = null /*array*/) {
        $ret = "";
        
        $rows = $value->Rows();
        //$storage = $rows->storage;
        // $fields  = $storage->fields;
        //$idfield = $storage->fname("id");

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

        // Add Random noise
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

        // write the random number
        
        global $CORE_PATH;
        
        $font = imageloadfont($CORE_PATH."extras/fonts/anonymous.gdf");
        imagestring($image, $font, 3, 0, $rand, $textColor);

        // send several headers to make sure the image is not cached
        // Date in the past

        /* header("Expires: Mon, 23 Jul 1993 05:00:00 GMT");

        // always modified
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

        // HTTP/1.1
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);

        // HTTP/1.0
        header("Pragma: no-cache");*/

        // send the content type header so the image is displayed properly
        header('Content-type: image/jpeg');

        imagejpeg($image);
        imagedestroy($image);
    }

    #endregion

    #region Browser functions

    #region Redirection

    function redirect($url) {
        header("Location: $url");
    }

    function JsRedirect($url, $after = -1 /*in seconds*/, $out = true){
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

    #endregion

    #region Header functions

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

    #endregion

    #region Browser detection

    function browser_detection( $which_test, $useragent = null ) {
        /*
        uncomment the global variable declaration if you want the variables to be available on a global level
        throughout your php page, make sure that php is configured to support the use of globals first!
        Use of globals should be avoided however, and they are not necessary with this script
        */

        /*global $dom_browser, $safe_browser, $browser_user_agent, $os, $browser_name, $s_browser, $ie_version, 
        $version_number, $os_number, $b_repeat, $moz_version, $moz_version_number, $moz_rv, $moz_rv_full, $moz_release;*/

        static $dom_browser, $safe_browser, $browser_user_agent, $os, $browser_name, $s_browser, $ie_version, 
        $version_number, $os_number, $b_repeat = false, $moz_version, $moz_version_number, $moz_rv, $moz_rv_full, $moz_release, 
        $type, $math_version_number;

        /* 
        this makes the test only run once no matter how many times you call it
        since all the variables are filled on the first run through, it's only a matter of returning the
        the right ones 
        */
        
        if(!is_null($useragent))
            $b_repeat = false;
        
        if ( !$b_repeat )
        {
            //initialize all variables with default values to prevent error
            $dom_browser = false;
            $type = 'bot';// default to bot since you never know with bots
            $safe_browser = false;
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
            $b_success = false;// boolean for if browser found in main test

            //make navigator user agent string lower case to make sure all versions get caught
            // isset protects against blank user agent failure
            if(!is_null($useragent))
                $browser_user_agent = strtolower($useragent);
            else
                $browser_user_agent = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';
            
            /*
            pack the browser type array, in this order
            the order is important, because opera must be tested first, then omniweb [which has safari data in string],
            same for konqueror, then safari, then gecko, since safari navigator user agent id's with 'gecko' in string.
            note that $dom_browser is set for all  modern dom browsers, this gives you a default to use.

            array[0] = id string for useragent, array[1] is if dom capable, array[2] is working name for browser, 
            array[3] identifies navigator useragent type

            Note: all browser strings are in lower case to match the strtolower output, this avoids possible detection
            errors

            Note: There are currently 5 navigator user agent types: 
            bro - modern, css supporting browser.
            bbro - basic browser, text only, table only, defective css implementation
            bot - search type spider
            dow - known download agent
            lib - standard http libraries
            */
            // known browsers, list will be updated routinely, check back now and then
            $a_browser_types[] = array( 'opera', true, 'op', 'bro' );
            $a_browser_types[] = array( 'omniweb', true, 'omni', 'bro' );// mac osx browser, now uses khtml engine:
            $a_browser_types[] = array( 'msie', true, 'ie', 'bro' );
            $a_browser_types[] = array( 'konqueror', true, 'konq', 'bro' );
            $a_browser_types[] = array( 'safari', true, 'saf', 'bro' );
            // covers Netscape 6-7, K-Meleon, Most linux versions, uses moz array below
            $a_browser_types[] = array( 'gecko', true, 'moz', 'bro' );
            $a_browser_types[] = array( 'netpositive', false, 'netp', 'bbro' );// beos browser
            $a_browser_types[] = array( 'lynx', false, 'lynx', 'bbro' ); // command line browser
            $a_browser_types[] = array( 'elinks ', false, 'elinks', 'bbro' ); // new version of links
            $a_browser_types[] = array( 'elinks', false, 'elinks', 'bbro' ); // alternate id for it
            $a_browser_types[] = array( 'links ', false, 'links', 'bbro' ); // old name for links
            $a_browser_types[] = array( 'links', false, 'links', 'bbro' ); // alternate id for it
            $a_browser_types[] = array( 'w3m', false, 'w3m', 'bbro' ); // open source browser, more features than lynx/links
            $a_browser_types[] = array( 'webtv', false, 'webtv', 'bbro' );// junk ms webtv
            $a_browser_types[] = array( 'amaya', false, 'amaya', 'bbro' );// w3c browser
            $a_browser_types[] = array( 'dillo', false, 'dillo', 'bbro' );// linux browser, basic table support
            $a_browser_types[] = array( 'ibrowse', false, 'ibrowse', 'bbro' );// amiga browser
            $a_browser_types[] = array( 'icab', false, 'icab', 'bro' );// mac browser 
            $a_browser_types[] = array( 'crazy browser', true, 'ie', 'bro' );// uses ie rendering engine
            $a_browser_types[] = array( 'sonyericssonp800', false, 'sonyericssonp800', 'bbro' );// sony ericsson handheld
            
            // search engine spider bots:
            $a_browser_types[] = array( 'yandex', false, 'yandex', 'bot' );
            $a_browser_types[] = array( 'webalta crawler', false, 'altavista', 'bot' );
            $a_browser_types[] = array( 'googlebot', false, 'google', 'bot' );// google 
            $a_browser_types[] = array( 'mediapartners-google', false, 'adsense', 'bot' );// google adsense
            $a_browser_types[] = array( 'yahoo-verticalcrawler', false, 'yahoo', 'bot' );// old yahoo bot
            $a_browser_types[] = array( 'yahoo! slurp', false, 'yahoo', 'bot' ); // new yahoo bot 
            $a_browser_types[] = array( 'yahoo-mm', false, 'yahoomm', 'bot' ); // gets Yahoo-MMCrawler and Yahoo-MMAudVid bots
            $a_browser_types[] = array( 'inktomi', false, 'inktomi', 'bot' ); // inktomi bot
            $a_browser_types[] = array( 'slurp', false, 'inktomi', 'bot' ); // inktomi bot
            $a_browser_types[] = array( 'fast-webcrawler', false, 'fast', 'bot' );// Fast AllTheWeb
            $a_browser_types[] = array( 'msnbot', false, 'msn', 'bot' );// msn search 
            $a_browser_types[] = array( 'ask jeeves', false, 'ask', 'bot' ); //jeeves/teoma
            $a_browser_types[] = array( 'teoma', false, 'ask', 'bot' );//jeeves teoma
            $a_browser_types[] = array( 'scooter', false, 'scooter', 'bot' );// altavista 
            $a_browser_types[] = array( 'openbot', false, 'openbot', 'bot' );// openbot, from taiwan
            $a_browser_types[] = array( 'ia_archiver', false, 'ia_archiver', 'bot' );// ia archiver
            $a_browser_types[] = array( 'zyborg', false, 'looksmart', 'bot' );// looksmart 
            $a_browser_types[] = array( 'almaden', false, 'ibm', 'bot' );// ibm almaden web crawler 
            $a_browser_types[] = array( 'baiduspider', false, 'baidu', 'bot' );// Baiduspider asian search spider
            $a_browser_types[] = array( 'psbot', false, 'psbot', 'bot' );// psbot image crawler 
            $a_browser_types[] = array( 'gigabot', false, 'gigabot', 'bot' );// gigabot crawler 
            $a_browser_types[] = array( 'naverbot', false, 'naverbot', 'bot' );// naverbot crawler, bad bot, block
            $a_browser_types[] = array( 'surveybot', false, 'surveybot', 'bot' );// 
            $a_browser_types[] = array( 'boitho.com-dc', false, 'boitho', 'bot' );//norwegian search engine 
            $a_browser_types[] = array( 'objectssearch', false, 'objectsearch', 'bot' );// open source search engine
            $a_browser_types[] = array( 'answerbus', false, 'answerbus', 'bot' );
            $a_browser_types[] = array( 'sohu-search', false, 'sohu', 'bot' );
            $a_browser_types[] = array( 'iltrovatore-setaccio', false, 'il-set', 'bot' );

            // various http utility libaries 
            $a_browser_types[] = array( 'w3c_validator', false, 'w3c', 'lib' ); // uses libperl, make first
            $a_browser_types[] = array( 'wdg_validator', false, 'wdg', 'lib' ); // 
            $a_browser_types[] = array( 'libwww-perl', false, 'libwww-perl', 'lib' ); 
            $a_browser_types[] = array( 'jakarta commons-httpclient', false, 'jakarta', 'lib' );
            $a_browser_types[] = array( 'python-urllib', false, 'python-urllib', 'lib' ); 
            
            // download apps 
            $a_browser_types[] = array( 'getright', false, 'getright', 'dow' );
            $a_browser_types[] = array( 'wget', false, 'wget', 'dow' );// open source downloader, obeys robots.txt

            // netscape 4 and earlier tests, put last so spiders don't get caught
            $a_browser_types[] = array( 'mozilla/4.', false, 'ns', 'bbro' );
            $a_browser_types[] = array( 'mozilla/3.', false, 'ns', 'bbro' );
            $a_browser_types[] = array( 'mozilla/2.', false, 'ns', 'bbro' );
            
            //$a_browser_types[] = array( '', false ); // browser array template    
            /* 
            moz types array
            note the order, netscape6 must come before netscape, which  is how netscape 7 id's itself.
            rv comes last in case it is plain old mozilla 
            */
            $moz_types = array( 'firebird', 'phoenix', 'firefox', 'galeon', 'k-meleon', 'camino', 'epiphany', 
            'netscape6', 'netscape', 'multizilla', 'rv' );

            /*
            run through the browser_types array, break if you hit a match, if no match, assume old browser
            or non dom browser, assigns false value to $b_success.
            */
            for ($i = 0; $i < count($a_browser_types); $i++)
            {
                //unpacks browser array, assigns to variables
                $s_browser = $a_browser_types[$i][0];// text string to id browser from array
                if (stristr($browser_user_agent, $s_browser)) 
                {
                    // it defaults to true, will become false below if needed
                    // this keeps it easier to keep track of what is safe, only 
                    //explicit false assignment will make it false.
                    $safe_browser = true;

                    // assign values based on match of user agent string
                    $dom_browser = $a_browser_types[$i][1];// hardcoded dom support from array
                    $browser_name = $a_browser_types[$i][2];// working name for browser
                    $type = $a_browser_types[$i][3];// sets whether bot or browser

                    switch ( $browser_name )
                    {
                        // this is modified quite a bit, now will return proper netscape version number
                        // check your implementation to make sure it works
                        case 'ns':
                            $safe_browser = false;
                            $version_number = browser_version( $browser_user_agent, 'mozilla' );
                            break;
                        case 'moz':
                            /*
                            note: The 'rv' test is not absolute since the rv number is very different on 
                            different versions, for example Galean doesn't use the same rv version as Mozilla, 
                            neither do later Netscapes, like 7.x. For more on this, read the full mozilla numbering 
                            conventions here:
                            http://www.mozilla.org/releases/cvstags.html
                            */

                            // this will return alpha and beta version numbers, if present
                            $moz_rv_full = browser_version( $browser_user_agent, 'rv' );
                            // this slices them back off for math comparisons
                            $moz_rv = substr( $moz_rv_full, 0, 3 );

                            // this is to pull out specific mozilla versions, firebird, netscape etc..
                            for ( $i = 0; $i < count( $moz_types ); $i++ )
                            {
                                if ( stristr( $browser_user_agent, $moz_types[$i] ) ) 
                                {
                                    $moz_version = $moz_types[$i];
                                    $moz_version_number = browser_version( $browser_user_agent, $moz_version );
                                    break;
                                }
                            }
                            // this is necesary to protect against false id'ed moz'es and new moz'es.
                            // this corrects for galeon, or any other moz browser without an rv number
                            if ( !$moz_rv ) 
                            { 
                                $moz_rv = substr( $moz_version_number, 0, 3 ); 
                                $moz_rv_full = $moz_version_number; 
                                /* 
                                // you can use this instead if you are running php >= 4.2
                                $moz_rv = floatval( $moz_version_number ); 
                                $moz_rv_full = $moz_version_number;
                                */
                            }
                            // this corrects the version name in case it went to the default 'rv' for the test
                            if ( $moz_version == 'rv' ) 
                            {
                                $moz_version = 'mozilla';
                            }
                            
                            //the moz version will be taken from the rv number, see notes above for rv problems
                            $version_number = $moz_rv;
                            // gets the actual release date, necessary if you need to do functionality tests
                            $moz_release = browser_version( $browser_user_agent, 'gecko/' );
                            /* 
                            Test for mozilla 0.9.x / netscape 6.x
                            test your javascript/CSS to see if it works in these mozilla releases, if it does, just default it to:
                            $safe_browser = true;
                            */
                            if ( ( $moz_release < 20020400 ) || ( $moz_rv < 1 ) )
                            {
                                $safe_browser = false;
                            }
                            break;
                        case 'ie':
                            $version_number = browser_version( $browser_user_agent, $s_browser );
                            // first test for IE 5x mac, that's the most problematic IE out there
                            if ( stristr( $browser_user_agent, 'mac') )
                            {
                                $ie_version = 'ieMac';
                            }
                            // this assigns a general ie id to the $ie_version variable
                            elseif ( $version_number >= 5 )
                            {
                                $ie_version = 'ie5x';
                            }
                            elseif ( ( $version_number > 3 ) && ( $version_number < 5 ) )
                            {
                                $dom_browser = false;
                                $ie_version = 'ie4';
                                // this depends on what you're using the script for, make sure this fits your needs
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
                            if ( $version_number < 5 )// opera 4 wasn't very useable.
                            {
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
                    // the browser was id'ed
                    $b_success = true;
                    break;
                }
            }
            
            //assigns defaults if the browser was not found in the loop test
            if ( !$b_success ) 
            {
                /*
                    this will return the first part of the browser string if the above id's failed
                    usually the first part of the browser string has the navigator useragent name/version in it.
                    This will usually correctly id the browser and the browser number if it didn't get
                    caught by the above routine.
                    If you want a '' to do a if browser == '' type test, just comment out all lines below
                    except for the last line, and uncomment the last line. If you want undefined values, 
                    the browser_name is '', you can always test for that
                */
                // delete this part if you want an unknown browser returned
                $s_browser = substr( $browser_user_agent, 0, strcspn( $browser_user_agent , '();') );
                // this extracts just the browser name from the string
                preg_match('/[^0-9,a-z].*?-.*?[a-z].*?\s.*?[a-z].*?/i', $s_browser, $r );
                $s_browser = @$r[0];
                $version_number = browser_version( $browser_user_agent, $s_browser );

                // then uncomment this part
                //$s_browser = '';//deletes the last array item in case the browser was not a match
            }
            // get os data, mac os x test requires browser/version information, this is a change from older scripts
            $a_os_data = which_os( $browser_user_agent, $browser_name, $version_number );
            $os = $a_os_data[0];// os name, abbreviated
            $os_number = $a_os_data[1];// os number or version if available

            // this ends the run through once if clause, set the boolean 
            //to true so the function won't retest everything
            $b_repeat = true;

            // pulls out primary version number from more complex string, like 7.5a, 
            // use this for numeric version comparison
            $m = array();
            if ( preg_match('/[0-9]*\.*[0-9]*/', $version_number, $m ) )
            {
                $math_version_number = $m[0]; 
                //print_r($m);
            }
            
        }
        //$version_number = $_SERVER["REMOTE_ADDR"];
        /*
        This is where you return values based on what parameter you used to call the function
        $which_test is the passed parameter in the initial browser_detection('os') for example call
        */
        switch ( $which_test )
        {
            case 'safe':// returns true/false if your tests determine it's a safe browser
                // you can change the tests to determine what is a safeBrowser for your scripts
                // in this case sub rv 1 Mozillas and Netscape 4x's trigger the unsafe condition
                return $safe_browser; 
                break;
            case 'ie_version': // returns ieMac or ie5x
                return $ie_version;
                break;
            case 'moz_version':// returns array of all relevant moz information
                $moz_array = array( $moz_version, $moz_version_number, $moz_rv, $moz_rv_full, $moz_release );
                return $moz_array;
                break;
            case 'dom':// returns true/fale if a DOM capable browser
                return $dom_browser;
                break;
            case 'os':// returns os name
                return $os; 
                break;
            case 'os_number':// returns os number if windows
                return $os_number;
                break;
            case 'browser':// returns browser name
                return $browser_name; 
                break;
            case 'number':// returns browser number
                return $version_number;
                break;
            case 'full':// returns all relevant browser information in an array
                $full_array = array( $browser_name, $version_number, $ie_version, $dom_browser, $safe_browser, 
                    $os, $os_number, $s_browser, $type, $math_version_number );
                return $full_array;
                break;
            case 'type':// returns what type, bot, browser, maybe downloader in future
                return $type;
                break;
            case 'math_number':// returns numerical version number, for number comparisons
                return $math_version_number;
                break;
            default:
                break;
        }
    }

    // gets which os from the browser string
    function which_os ( $browser_string, $browser_name, $version_number  )
    {
        // initialize variables
        $os = '';
        $os_version = '';
        /*
        packs the os array
        use this order since some navigator user agents will put 'macintosh' in the navigator user agent string
        which would make the nt test register true
        */
        $a_mac = array( 'mac68k', 'macppc' );// this is not used currently
        // same logic, check in order to catch the os's in order, last is always default item
        $a_unix = array( 'unixware', 'solaris', 'sunos', 'sun4', 'sun5', 'suni86', 'sun', 
            'freebsd', 'openbsd', 'bsd' , 'irix5', 'irix6', 'irix', 'hpux9', 'hpux10', 'hpux11', 'hpux', 'hp-ux', 
            'aix1', 'aix2', 'aix3', 'aix4', 'aix5', 'aix', 'sco', 'unixware', 'mpras', 'reliant',
            'dec', 'sinix', 'unix' );
        // only sometimes will you get a linux distro to id itself...
        $a_linux = array( 'kanotix', 'ubuntu', 'mepis', 'debian', 'suse', 'redhat', 'slackware', 'mandrake', 'gentoo', 'linux' );
        $a_linux_process = array ( 'i386', 'i586', 'i686' );// not use currently
        // note, order of os very important in os array, you will get failed ids if changed
        $a_os = array( 'beos', 'os2', 'amiga', 'webtv', 'mac', 'nt', 'win', $a_unix, $a_linux );

        //os tester
        for ( $i = 0; $i < count( $a_os ); $i++ )
        {
            //unpacks os array, assigns to variable
            $s_os = $a_os[$i];

            //assign os to global os variable, os flag true on success
            //!stristr($browser_string, "linux" ) corrects a linux detection bug
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
                        elseif ( strstr( $browser_string, '2000' ) )// windows 2000, for opera ID
                        {
                            $os_version = 5.0;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, 'xp' ) )// windows 2000, for opera ID
                        {
                            $os_version = 5.1;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, '2003' ) )// windows server 2003, for opera ID
                        {
                            $os_version = 5.2;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, 'ce' ) )// windows CE
                        {
                            $os_version = 'ce';
                        }
                        break;
                    case 'nt':
                        if ( strstr( $browser_string, 'nt 5.2' ) )// windows server 2003
                        {
                            $os_version = 5.2;
                            $os = 'nt';
                        }
                        elseif ( strstr( $browser_string, 'nt 5.1' ) || strstr( $browser_string, 'xp' ) )// windows xp
                        {
                            $os_version = 5.1;//
                        }
                        elseif ( strstr( $browser_string, 'nt 5' ) || strstr( $browser_string, '2000' ) )// windows 2000
                        {
                            $os_version = 5.0;
                        }
                        elseif ( strstr( $browser_string, 'nt 4' ) )// nt 4
                        {
                            $os_version = 4;
                        }
                        elseif ( strstr( $browser_string, 'nt 3' ) )// nt 4
                        {
                            $os_version = 3;
                        }
                        break;
                    case 'mac':
                        if ( strstr( $browser_string, 'os x' ) ) 
                        {
                            $os_version = 10;
                        }
                        //this is a crude test for os x, since safari, camino, ie 5.2, & moz >= rv 1.3 
                        //are only made for os x
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
            // check that it's an array, check it's the second to last item 
            //in the main os array, the unix one that is
            elseif ( is_array( $s_os ) && ( $i == ( count( $a_os ) - 2 ) ) )
            {
                for ($j = 0; $j < count($s_os); $j++)
                {
                    if ( stristr( $browser_string, $s_os[$j] ) )
                    {
                        $os = 'unix'; //if the os is in the unix array, it's unix, obviously...
                        $os_version = ( $s_os[$j] != 'unix' ) ? $s_os[$j] : '';// assign sub unix version from the unix array
                        break;
                    }
                }
            } 
            // check that it's an array, check it's the last item 
            //in the main os array, the linux one that is
            elseif ( is_array( $s_os ) && ( $i == ( count( $a_os ) - 1 ) ) )
            {
                for ($j = 0; $j < count($s_os); $j++)
                {
                    if ( stristr( $browser_string, $s_os[$j] ) )
                    {
                        $os = 'lin';
                        // assign linux distro from the linux array, there's a default
                        //search for 'lin', if it's that, set version to ''
                        $os_version = ( $s_os[$j] != 'linux' ) ? $s_os[$j] : '';
                        break;
                    }
                }
            } 
        }

        // pack the os data array for return to main function
        $os_data = array( $os, $os_version );
        return $os_data;
    }

    // function returns browser number, gecko rv number, or gecko release date
    //function browser_version( $browser_user_agent, $search_string, $substring_length )
    function browser_version( $browser_user_agent, $search_string )
    {
        // 12 is the longest that will be required, handles release dates: 20020323; 0.8.0+
        $substring_length = 12;
        //initialize browser number, will return '' if not found
        $browser_number = '';

        // use the passed parameter for $search_string
        // start the substring slice right after these moz search strings
        // there are some cases of double msie id's, first in string and then with then number
        $start_pos = 0;  
        /* this test covers you for multiple occurrences of string, only with ie though
         with for example google bot you want the first occurance returned, since that's where the
        numbering happens */
        
        for ( $i = 0; $i < 4; $i++ )
        {
            //start the search after the first string occurrence
            if ( strpos( $browser_user_agent, $search_string, $start_pos ) !== false )
            {
                //update start position if position found
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

        // this is just to get the release date, not other moz information
        // also corrects for the omniweb 'v'
        if ( $search_string != 'gecko/' ) 
        { 
            if ( $search_string == 'omniweb' )
            {
                $start_pos += 2;// handles the v in 'omniweb/v532.xx
            }
            else
            {
                $start_pos++; 
            }
        }

        // Initial trimming
        $browser_number = substr( $browser_user_agent, $start_pos, $substring_length );

        // Find the space, ;, or parentheses that ends the number
        $browser_number = substr( $browser_number, 0, strcspn($browser_number, ' );') );

        //make sure the returned value is actually the id number and not a string
        // otherwise return ''
        if ( !is_numeric( substr( $browser_number, 0, 1 ) ) )
        { 
            $browser_number = ''; 
        }
        //$browser_number = strrpos( $browser_user_agent, $search_string );
        return $browser_number;
    }

    /* 
    Here are some typical navigator.userAgent strings so you can see where the data comes from
    Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.5) Gecko/20031007 Firebird/0.7 
    Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:0.9.4) Gecko/20011128 Netscape6/6.2.1
    */

    #endregion


    #endregion

    #region PHP code functions

    function code_cache($cachefile, $original) {
        global $core, $CODECACHE;
        
        if(is_null($CODECACHE))
            $CODECACHE = true;
        
        $name = load_file_name($original);
        if($name != '') {
            if($core->fs->FileExists($cachefile, SITE) && ($core->fs->FileLastModified($name, SITE) > $core->fs->FileLastModified($cachefile, SITE)))
                $core->fs->DeleteFile($cachefile, SITE);
        }
        
        /* else the cache file is deleted on template save */
        
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
        // $code = load_from_file($code);
    
        if(strpos($code, "<?") === false || strpos($code, "LOADFILE:") === 0) {
            // it mey be just a string and to be converted to <?= form
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

    #endregion

    #region DateTime functions

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

    #endregion

    #region File functions

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

    #endregion

    #region Namespace function

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

    #endregion

    #region DEPRECATED FUNCTIONS (NEVER USE THIS FUNCTIONS)

    /**
     * DEPRECATED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * NEVER USE THIS FUNCTION
     */
    function iif($condition, $truepart, $falsepart) {
        if($condition)
            return $truepart;
        else
            return $falsepart;
    }
    /**
     * DEPRECATED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * NEVER USE THIS FUNCTION
     */
    function uniqueid() {
    //    mt_srand((double)microtime()*10000);  //optional for php 4.2.0 and up.
    ///    $charid = strtoupper(md5(uniqid(rand(), true)));
    //    return hexdec($charid);

        mt_srand((double)microtime()*10000);  //optional for php 4.2.0 and up.
        $charid1 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);
        $charid2 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);
        $charid3 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);
        $charid4 = str_pad(mt_rand(0, 999), 3, "0", STR_PAD_RIGHT);

        list($usec, $sec) = explode(' ', microtime());

        return (floatval($charid1.$charid2.$charid3.$charid4) + $sec + $usec) * $usec;
    }
    /**
     * DEPRECATED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * NEVER USE THIS FUNCTION
     */
    function cbool($value){
        return boolval($value);
    }
    /**
     * DEPRECATED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * NEVER USE THIS FUNCTION
     */
    function timezone($time){
        global $_TIME_ZONE;
        return $time + ($_TIME_ZONE*60*60);
    }
    /**
     * DEPRECATED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * NEVER USE THIS FUNCTION
     */
    function timezoneundo($time){
        global $_TIME_ZONE;
        return $time - ($_TIME_ZONE*60*60);
    }
    /**
     * DEPRECATED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * NEVER USE THIS FUNCTION
     */
    function cout() {
        out(OUTTO_COMMENT);
    }
    /**
     * DEPRECATED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * NEVER USE THIS FUNCTION
     */
    function print_out($what) {
        out($what);
    }


    #endregion

    #region XML functions

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

    #endregion
    
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

        // Pick out the namespaces that apply to this doc.
        // We need to do this from DOM because simplexml does't see the
        // special xmlns attributes because of the way libxml2 handles them.
        $xpath = new DOMXPath($dom);
        $ns = array(''=>NULL);
        foreach($xpath->query("namespace::*") as $v) {
            if($v->localName!='xml') $ns[$v->localName] = $v->nodeValue;
        }
        if(in_array("http://www.w3.org/2005/Atom",$ns)) {
            $atom10 = true;
            unset($ns['xmlns']);
        } else $atom10 = false;

        // Ok, now we can switch to simplexml
        $xml = simplexml_import_dom($dom);

        // Pull out the root attributes - usually just version
        foreach($xml->attributes() as $k=>$v) $feed[$k] = (string)$v;

        // We will deal with the items separately, so start by only looking 
        // at the stuff leading up to the items checking each namespace.
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

        // Now we deal with the items
        // Atom and RSS1 have the feed items a level higher than RSS2
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
                            // Don't even try parsing this stuff, just pass it through.
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
        return @unserialize($string);
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
        /*$string = preg_replace("/\?>"."<\?php/im", "", $string);
        $string = preg_replace("/\?"."><"."\?/im", "", $string);*/
        
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
    
    /* services */
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
        // curl_setopt($handle, CURLOPT_COOKIEJAR, $this->_cookieFileLocation);
        // curl_setopt($handle, CURLOPT_COOKIEFILE, $this->_cookieFileLocation);

        if(!is_empty($user)){
            curl_setopt($handle, CURLOPT_USERPWD, $user.':'.$password);
            curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        }

        if($secure) {
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);                
            // curl_setopt($handle, CURLOPT_FTP_SSL, true);
        }

        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                "Connection: Keep-Alive"
            )
        );

        /*out($url, curlConvertData($postData));
        exit;*/
        if(count($postData) > 0) {
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, curlConvertData($postData));
        }

        $result = new Object();

        $result->data = curl_exec($handle);
        $result->status = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        curl_close($handle); 

        return $result;        
        
    }
    
    function transliterate ($string) { # Задаём функцию перекодировки кириллицы в транслит. 
        $string = mb_ereg_replace("ж","zh",$string);
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
    
        // constants
        const IGNORE = '$1';

        // validate parameters
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
            
            // go!
            return $this->_pack($this->_script);
        }
        
        // apply all parsing routines
        private function _pack($script) {
            for ($i = 0; isset($this->_parsers[$i]); $i++) {
                $script = call_user_func(array(&$this,$this->_parsers[$i]), $script);
            }
            return $script;
        }
        
        // keep a list of parsing functions, they'll be executed all at once
        private $_parsers = array();
        private function _addParser($parser) {
            $this->_parsers[] = $parser;
        }
        
        // zero encoding - just removal of white space and comments
        private function _basicCompression($script) {
            $parser = new ParseMaster();
            // make safe
            $parser->escapeChar = '\\';
            // protect strings
            $parser->add('/\'[^\'\\n\\r]*\'/', self::IGNORE);
            $parser->add('/"[^"\\n\\r]*"/', self::IGNORE);
            // remove comments
            $parser->add('/\\/\\/[^\\n\\r]*[\\n\\r]/', ' ');
            $parser->add('/\\/\\*[^*]*\\*+([^\\/][^*]*\\*+)*\\//', ' ');
            // protect regular expressions
            $parser->add('/\\s+(\\/[^\\/\\n\\r\\*][^\\/\\n\\r]*\\/g?i?)/', '$2'); // IGNORE
            $parser->add('/[^\\w\\x24\\/\'"*)\\?:]\\/[^\\/\\n\\r\\*][^\\/\\n\\r]*\\/g?i?/', self::IGNORE);
            // remove: ;;; doSomething();
            if ($this->_specialChars) $parser->add('/;;;[^\\n\\r]+[\\n\\r]/');
            // remove redundant semi-colons
            $parser->add('/\\(;;\\)/', self::IGNORE); // protect for (;;) loops
            $parser->add('/;+\\s*([};])/', '$2');
            // apply the above
            $script = $parser->exec($script);

            // remove white-space
            $parser->add('/(\\b|\\x24)\\s+(\\b|\\x24)/', '$2 $3');
            $parser->add('/([+\\-])\\s+([+\\-])/', '$2 $3');
            $parser->add('/\\s+/', '');
            // done
            return $parser->exec($script);
        }
        
        private function _encodeSpecialChars($script) {
            $parser = new ParseMaster();
            // replace: $name -> n, $$name -> na
            $parser->add('/((\\x24+)([a-zA-Z$_]+))(\\d*)/',
                         array('fn' => '_replace_name')
            );
            // replace: _name -> _0, double-underscore (__name) is ignored
            $regexp = '/\\b_[A-Za-z\\d]\\w*/';
            // build the word list
            $keywords = $this->_analyze($script, $regexp, '_encodePrivate');
            // quick ref
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
            // escape high-ascii values already in the script (i.e. in strings)
            if ($this->_encoding > 62)
                $script = $this->_escape95($script);
            // create the parser
            $parser = new ParseMaster();
            $encode = $this->_getEncoder($this->_encoding);
            // for high-ascii, don't encode single character low-ascii
            $regexp = ($this->_encoding > 62) ? '/\\w\\w+/' : '/\\w+/';
            // build the word list
            $keywords = $this->_analyze($script, $regexp, $encode);
            $encoded = $keywords['encoded'];
            
            // encode
            $parser->add($regexp,
                array(
                    'fn' => '_replace_encoded',
                    'data' => $encoded
                )
            );
            if (empty($script)) return $script;
            else {
                //$res = $parser->exec($script);
                //$res = $this->_bootStrap($res, $keywords);
                //return $res;
                return $this->_bootStrap($parser->exec($script), $keywords);
            }
        }
        
        private function _analyze($script, $regexp, $encode) {
            // analyse
            // retreive all words in the script
            $all = array();
            preg_match_all($regexp, $script, $all);
            $_sorted = array(); // list of words sorted by frequency
            $_encoded = array(); // dictionary of word->encoding
            $_protected = array(); // instances of "protected" words
            $all = $all[0]; // simulate the javascript comportement of global match
            if (!empty($all)) {
                $unsorted = array(); // same list, not sorted
                $protected = array(); // "protected" words (dictionary of word->"word")
                $value = array(); // dictionary of charCode->encoding (eg. 256->ff)
                $this->_count = array(); // word->count
                $i = count($all); $j = 0; //$word = null;
                // count the occurrences - used for sorting later
                do {
                    --$i;
                    $word = '$' . $all[$i];
                    if (!isset($this->_count[$word])) {
                        $this->_count[$word] = 0;
                        $unsorted[$j] = $word;
                        // make a dictionary of all of the protected words in this script
                        //  these are words that might be mistaken for encoding
                        //if (is_string($encode) && method_exists($this, $encode))
                        $values[$j] = call_user_func(array(&$this, $encode), $j);
                        $protected['$' . $values[$j]] = $j++;
                    }
                    // increment the word counter
                    $this->_count[$word]++;
                } while ($i > 0);
                // prepare to sort the word list, first we must protect
                //  words that are also used as codes. we assign them a code
                //  equivalent to the word itself.
                // e.g. if "do" falls within our encoding range
                //      then we store keywords["do"] = "do";
                // this avoids problems when decoding
                $i = count($unsorted);
                do {
                    $word = $unsorted[--$i];
                    if (isset($protected[$word]) /*!= null*/) {
                        $_sorted[$protected[$word]] = substr($word, 1);
                        $_protected[$protected[$word]] = true;
                        $this->_count[$word] = 0;
                    }
                } while ($i);
                
                // sort the words by frequency
                // Note: the javascript and php version of sort can be different :
                // in php manual, usort :
                // " If two members compare as equal,
                // their order in the sorted array is undefined."
                // so the final packed script is different of the Dean's javascript version
                // but equivalent.
                // the ECMAscript standard does not guarantee this behaviour,
                // and thus not all browsers (e.g. Mozilla versions dating back to at
                // least 2003) respect this. 
                usort($unsorted, array(&$this, '_sortWords'));
                $j = 0;
                // because there are "protected" words in the list
                //  we must add the sorted words around them
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
        
        // build the boot function used for loading and decoding
        private function _bootStrap($packed, $keywords) {
            $ENCODE = $this->_safeRegExp('$encode\\($count\\)');

            // $packed: the packed script
            $packed = "'" . $this->_escape($packed) . "'";

            // $ascii: base for encoding
            $ascii = min(count($keywords['sorted']), $this->_encoding);
            if ($ascii == 0) $ascii = 1;

            // $count: number of words contained in the script
            $count = count($keywords['sorted']);

            // $keywords: list of words contained in the script
            foreach ($keywords['protected'] as $i=>$value) {
                $keywords['sorted'][$i] = '';
            }
            // convert from a string to an array
            ksort($keywords['sorted']);
            $keywords = "'" . implode('|',$keywords['sorted']) . "'.explode('|')";

            $encode = ($this->_encoding > 62) ? '_encode95' : $this->_getEncoder($ascii);
            $encode = $this->_getJSFunction($encode);
            $encode = preg_replace('/_encoding/','$ascii', $encode);
            $encode = preg_replace('/arguments\\.callee/','$encode', $encode);
            $inline = '\\$count' . ($ascii > 10 ? '.toString(\\$ascii)' : '');

            // $decode: code snippet to speed up decoding
            if ($this->_fastDecode) {
                // create the decoder
                $decode = $this->_getJSFunction('_decodeBody');
                if ($this->_encoding > 62)
                    $decode = preg_replace('/\\\\w/', '[\\xa1-\\xff]', $decode);
                // perform the encoding inline for lower ascii values
                elseif ($ascii < 36)
                    $decode = preg_replace($ENCODE, $inline, $decode);
                // special case: when $count==0 there are no keywords. I want to keep
                //  the basic shape of the unpacking funcion so i'll frig the code...
                if ($count == 0)
                    $decode = preg_replace($this->_safeRegExp('($count)\\s*=\\s*1'), '$1=0', $decode, 1);
            }

            // boot function
            $unpack = $this->_getJSFunction('_unpack');
            if ($this->_fastDecode) {
                // insert the decoder
                $this->buffer = $decode;
                $unpack = preg_replace_callback('/\\{/', array(&$this, '_insertFastDecode'), $unpack, 1);
            }
            $unpack = preg_replace('/"/', "'", $unpack);
            if ($this->_encoding > 62) { // high-ascii
                // get rid of the word-boundaries for regexp matches
                $unpack = preg_replace('/\'\\\\\\\\b\'\s*\\+|\\+\s*\'\\\\\\\\b\'/', '', $unpack);
            }
            if ($ascii > 36 || $this->_encoding > 62 || $this->_fastDecode) {
                // insert the encode function
                $this->buffer = $encode;
                $unpack = preg_replace_callback('/\\{/', array(&$this, '_insertFastEncode'), $unpack, 1);
            } else {
                // perform the encoding inline
                $unpack = preg_replace($ENCODE, $inline, $unpack);
            }
            // pack the boot function too
            $unpackPacker = new JavaScriptPacker($unpack, 0, false, true);
            $unpack = $unpackPacker->pack();
            
            // arguments
            $params = array($packed, $ascii, $count, $keywords);
            if ($this->_fastDecode) {
                $params[] = 0;
                $params[] = '{}';
            }
            $params = implode(',', $params);
            
            // the whole thing
            return 'eval(' . $unpack . '(' . $params . "))\n";
        }
        
        private $buffer;
        private function _insertFastDecode($match) {
            return '{' . $this->buffer . ';';
        }
        private function _insertFastEncode($match) {
            return '{$encode=' . $this->buffer . ';';
        }
        
        // mmm.. ..which one do i need ??
        private function _getEncoder($ascii) {
            return $ascii > 10 ? $ascii > 36 ? $ascii > 62 ?
                   '_encode95' : '_encode62' : '_encode36' : '_encode10';
        }
        
        // zero encoding
        // characters: 0123456789
        private function _encode10($charCode) {
            return $charCode;
        }
        
        // inherent base36 support
        // characters: 0123456789abcdefghijklmnopqrstuvwxyz
        private function _encode36($charCode) {
            return base_convert($charCode, 10, 36);
        }
        
        // hitch a ride on base36 and add the upper case alpha characters
        // characters: 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ
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
        
        // use high-ascii values
        // characters: ¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþ
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
        
        // protect characters used by the parser
        private function _escape($script) {
            return preg_replace('/([\\\\\'])/', '\\\$1', $script);
        }
        
        // protect high-ascii characters already in the script
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
        
        // JavaScript Functions used.
        // Note : In Dean's version, these functions are converted
        // with 'String(aFunctionName);'.
        // This internal conversion complete the original code, ex :
        // 'while (aBool) anAction();' is converted to
        // 'while (aBool) { anAction(); }'.
        // The JavaScript functions below are corrected.
        
        // unpacking function - this is the boot strap function
        //  data extracted from this packing routine is passed to
        //  this function when decoded in the target
        // NOTE ! : without the ';' final.
        const JSFUNCTION_unpack =

    'function($packed, $ascii, $count, $keywords, $encode, $decode) {
        while ($count--) {
            if ($keywords[$count]) {
                $packed = $packed.replace(new RegExp(\'\\\\b\' + $encode($count) + \'\\\\b\', \'g\'), $keywords[$count]);
            }
        }
        return $packed;
    }';
    /*
    'function($packed, $ascii, $count, $keywords, $encode, $decode) {
        while ($count--)
            if ($keywords[$count])
                $packed = $packed.replace(new RegExp(\'\\\\b\' + $encode($count) + \'\\\\b\', \'g\'), $keywords[$count]);
        return $packed;
    }';
    */
        
        // code-snippet inserted into the unpacker to speed up decoding
        const JSFUNCTION_decodeBody =
    //_decode = function() {
    // does the browser support String.replace where the
    //  replacement value is a function?

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
    //};
    /*
    '    if (!\'\'.replace(/^/, String)) {
            // decode all the values we need
            while ($count--) $decode[$encode($count)] = $keywords[$count] || $encode($count);
            // global replacement function
            $keywords = [function ($encoded) {return $decode[$encoded]}];
            // generic match
            $encode = function () {return\'\\\\w+\'};
            // reset the loop counter -  we are now doing a global replace
            $count = 1;
        }';
    */
        
         // zero encoding
         // characters: 0123456789
         const JSFUNCTION_encode10 =
    'function($charCode) {
        return $charCode;
    }';//;';
        
         // inherent base36 support
         // characters: 0123456789abcdefghijklmnopqrstuvwxyz
         const JSFUNCTION_encode36 =
    'function($charCode) {
        return $charCode.toString(36);
    }';//;';
        
        // hitch a ride on base36 and add the upper case alpha characters
        // characters: 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ
        const JSFUNCTION_encode62 =
    'function($charCode) {
        return ($charCode < _encoding ? \'\' : arguments.callee(parseInt($charCode / _encoding))) +
        (($charCode = $charCode % _encoding) > 35 ? String.fromCharCode($charCode + 29) : $charCode.toString(36));
    }';
        
        // use high-ascii values
        // characters: ¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþ
        const JSFUNCTION_encode95 =
    'function($charCode) {
        return ($charCode < _encoding ? \'\' : arguments.callee($charCode / _encoding)) +
            String.fromCharCode($charCode % _encoding + 161);
    }'; 
        
    }


    class ParseMaster {
        public $ignoreCase = false;
        public $escapeChar = '';
        
        // constants
        const EXPRESSION = 0;
        const REPLACEMENT = 1;
        const LENGTH = 2;
        
        // used to determine nesting levels
        private $GROUPS = '/\\(/';//g
        private $SUB_REPLACE = '/\\$\\d/';
        private $INDEXED = '/^\\$\\d+$/';
        private $TRIM = '/([\'"])\\1\\.(.*)\\.\\1\\1$/';
        private $ESCAPE = '/\\\./';//g
        private $QUOTE = '/\'/';
        private $DELETED = '/\\x01[^\\x01]*\\x01/';//g
        
        public function add($expression, $replacement = '') {
            // count the number of sub-expressions
            //  - add one because each pattern is itself a sub-expression
            $length = 1 + preg_match_all($this->GROUPS, $this->_internalEscape((string)$expression), $out);
            
            // treat only strings $replacement
            if (is_string($replacement)) {
                // does the pattern deal with sub-expressions?
                if (preg_match($this->SUB_REPLACE, $replacement)) {
                    // a simple lookup? (e.g. "$2")
                    if (preg_match($this->INDEXED, $replacement)) {
                        // store the index (used for fast retrieval of matched strings)
                        $replacement = (int)(substr($replacement, 1)) - 1;
                    } else { // a complicated lookup (e.g. "Hello $2 $1")
                        // build a function to do the lookup
                        $quote = preg_match($this->QUOTE, $this->_internalEscape($replacement))
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
            // pass the modified arguments
            if (!empty($expression)) $this->_add($expression, $replacement, $length);
            else $this->_add('/^$/', $replacement, $length);
        }
        
        public function exec($string) {
            // execute the global replacement
            $this->_escaped = array();
            
            // simulate the _patterns.toSTring of Dean
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
            // clear the patterns collection so that this object may be re-used
            $this->_patterns = array();
        }

        // private
        private $_escaped = array();  // escaped characters
        private $_patterns = array(); // patterns stored by index
        
        // create and add a new pattern to the patterns collection
        private function _add() {
            $arguments = func_get_args();
            $this->_patterns[] = $arguments;
        }
        
        // this is the global replace function (it's quite complicated)
        private function _replacement($arguments) {
            if (empty($arguments)) return '';
            
            $i = 1; $j = 0;
            // loop through the patterns
            while (isset($this->_patterns[$j])) {
                $pattern = $this->_patterns[$j++];
                // do we have a result?
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
                
                // skip over references to sub-expressions
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
        
        
        // php : we cannot pass additional data to preg_replace_callback,
        // and we cannot use &$this in create_function, so let's go to lower level
        private $buffer;
        
        // encode escaped characters
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
        
        // decode escaped characters
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
