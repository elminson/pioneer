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
	public $Hilite = true; //bug
	public $Detailed = true;
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

		/*if (count($this->_items) == 0)
			$this->registerExtra();*/

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
					continue; //distinct
				$line = $this->_items[$a]->line;
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
					/*
					$value = addslashes("<pre>" . preg_replace("/\n/im", "<br>", $value) . "</pre>");
					$result[] = ((is_string($k)) ? $k . " = " : "") .
						$this->Styles["info"]->toString("<span style='cursor: hand;' id='linka'
							onclick='new HTMLToolTip(this, \"{$value}\").show();'>{$type}</span>");
					*/
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

		$result .= "\r\n<div id='st_{$id}' style='margin: 0px 0px 0px 5px; display: " . (($this->Roll) ? "" : "none;") . "'>\r\n"; //call stack DIV (3)

		for ($i = 0; $i < $scount; $i++){
			$result .=
				$this->Styles["line"]->toString("#{$call[$i]['line']}: ") . "\r\n" .
				$this->parseFunctionInfo($call[$i]) . "(" . ((isset($call[$i]['args'])) ? $this->formatArgs($call[$i]['args']) : "") . ")";

			if ($this->Detailed && $call[$i]['file'] != "")
				$result .= ", " .
					$this->Styles["keyword"]->toString("file ") .
					$this->Styles["string"]->toString("'{$call[$i]['file']}' ") . "\r\n<br>";
		}

		$result .= "\r\n</div>\r\n"; //(#3)
		return $result;
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

			$result .= "\r\n<div id='bp_{$id}' style='margin: 0px 0px 0px 5px; display: " . (($this->Roll) ? "" : "none;") . "'>\r\n"; //call breakpoints DIV (4)
		} else {
			$result = "\r\n<div style='margin: 3px 0px 3px 0px;'>";
		}

		$bps = array_object_search($data->_items, "call", $i + 1);

		$time0 = $this->_time0;
		$ptime0 = $time0;
		$bcount = count($bps);

		for ($k = 0; $k < $bcount; $k++){
			$bp = $data->_items[$bps[$k]];

			//out($time0, $ptime0, $bp->time, $bp->time - $time0);
			$time = sprintf("%01.3f", (($this->Relative) ? $bp->time - $ptime0 : $bp->time - $time0) * 1e3); //"%.3e"
			$nbp = ($line) ? $data->title->line : $k + 1;

			$result .=
				(($this->Hilite) ? $this->Styles["line"]->toString("#{$nbp}: ") : "#{$nbp}: ") . "\r\n" .
				(($this->Hilite) ? $this->Styles["integer"]->toString("{$time} ") : "{$time} ") . "\r\n" .
				" milliseconds" .
				(isset($bp->track) ? " (" . $this->formatArgs($bp->track) . ")" : "") . "\r\n<br>";

			$ptime0 = $bp->time;
		}

		$result .= "\r\n</div>\r\n"; //(#4)

		return $result;
	}

	private function stdOut($data){
		switch ($this->Target){
			case WEBPAGE :

				if (!$this->Hilite)
					foreach ($this->Styles as $k => $v)
						$v->enable = false;

				$result = "<div style='margin: 5px 0px 0px 0px; font-family: Courier New, Courier, monospace;
							font-size: 12px; white-space: nowrap;'>\r\n"; //style DIV (0)

				//title
				$result .= $this->formatTitle($data);

				//calls
				$count = count($data->calls);
				for ($i = 0; $i < $count; $i++){
					$result .= "\r\n<div style='margin: 5px 0px 0px 20px; padding: 0px 0px 0px 0px;
						width: 300px; border-left: 1px solid #A9ABAB;'>
						\r\n<div style='border-top: 1px solid #A9ABAB; font-size: 5px; width: 5px;'></div>\r\n";

					if($this->Stack)
						$result .= $this->formatStack($i, $data); //stack
					$result .= $this->formatBreakpoints($i, $data); //breakpoints

					$result .= "\r\n<div style='border-bottom: 1px solid #A9ABAB; font-size: 5px; width: 5px;'></div>\r\n</div>\r\n";
				}

				$result .= "\r\n</div>\r\n"; //(#0)

				echo $result;
				break;
			case FILE :
				//
				break;
			case DATABASE :
				//
				break;
			case EMAIL :
				//
				break;
		}
	}

	/***************************/

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
	
	

	/***************************/

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
