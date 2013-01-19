<?php

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
