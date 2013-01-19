<?php

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
		// check date
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

?>