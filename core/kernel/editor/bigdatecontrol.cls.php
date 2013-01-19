<?php

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
		// if gregorian calendar (>1582), century not-divisible by 400 is not leap
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

		if ($d < -12219321600) $d -= 86400*10; // if 15 Oct 1582 or earlier, gregorian correction

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

			//echo ' yr=',$a,' ', $d,'.';

			for (; --$a >= 0;) {
				$lastd = $d;

				if ($leaf = $this->yearisleap($a)) $d += $d366;
				else $d += $d365;

				if ($d >= 0) {
					$year = $a;
					break;
				}
			}
			/**/

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
		/*if(is_numeric($this->value))
			$this->value = strftime("%Y-%m-%d %H:%M:%S", $this->value);

		if(is_empty($this->value))
			$this->value = strftime("%Y-%m-%d %H:%M:%S", time());*/
			
		$dn = $this->valueOf('day'.$this->name);
		$mn = $this->valueOf('month'.$this->name);
		$yn = $this->valueOf('year'.$this->name);
		$hh = $this->valueOf('hour'.$this->name);
		$mm = $this->valueOf('minute'.$this->name);
		
		if(is_numeric($this->value)){
			/*$datearr = $this->getdatearr($this->value);
			$dn = $this->zeroround($datearr['mday']);
			$mn = $this->zeroround($datearr['mon']);
			$yn = $datearr['year'];
			$hh = $this->zeroround($datearr['hours']);
			$mm = $this->zeroround($datearr['minutes']);*/

			$dn = date('d',$this->value);
			$mn = date('m',$this->value);
			$yn = date('Y',$this->value);
			$hh = date('H',$this->value);
			$mm = date('i',$this->value);

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
		// check date
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

?>