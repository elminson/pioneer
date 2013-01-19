<?php

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

?>