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

?>