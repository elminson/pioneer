<?php


class MultilinkField {

#region Properties

	private $storage;
	private $ids; // array
	private $datarows;
	private $criteria;
	private $tmpTable;
	
#endregion

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
                $this->tmpTable."_order" => array("type" => "autoincrement", "additional" => ""),
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
            //out('datarows->rewind called', debug_backtrace());
			// $this->datarows->Rewind();
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
    
	
#region Aliases	
	
	public function from_xml($el){ $this->FromXML($el); }
	
	public function to_xml(){ return $this->ToXML(); }
	
#endregion

}

class DataRow extends Object {
	
#region Properties	

	public $storage;
	
#endregion
	
	public function __construct($storage, $dt = null) {
		global $core;
		
		/*register events*/
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
		// return $this->data != null;
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
            $fields = $lookup->fields;
			$fname = $this->fname($fname);
            $data = $this;
            $condition = $lookup->condition;
            // out('$condition = "'.$condition.'";', $data->model);
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
			//out($name, $pair->firstChild->nodeName);
			if ($pair->firstChild->nodeType != 1){ //cdata
				$value = $pair->nodeValue;
			} else {
				$item = $pair->firstChild;
				if ($item->nodeType == 1){ //element
					$nm = $this->storage->fromfname($name);
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
								//$dr->storage->fromfname($idf)
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
	    //$idname = $this->storage->fname("id");
	    unset($this->id);
	}
	
	public function ToCreateScript($objectname, $proplist = array(), $exclude = array(), $newparams = array(), $class = null) {
		$o = new Object($this->_data, $this->storage->table."_");
		$exclude[] = "id";
		$exclude[] = "datecreated";
		return $o->ToCreateScript($objectname, $proplist, $exclude, $newparams, "DataRow");
	}

#region Privates

	protected function TypeExchange($fieldname /* with prefix */, $mode = TYPEEXCHANGE_MODE_GET, $setValue = null) { // __get or __set
		
		$rowValue = $mode == TYPEEXCHANGE_MODE_GET ? @$this->_data->$fieldname : $setValue;
		$fname = $this->fromfname($fieldname);
		
		$field = $this->storage->fields->$fname;
		
		if($mode == TYPEEXCHANGE_MODE_GET) {
			$args = $this->DispatchEvent("datarow.dotypeexchange", Hashtable::Create("field", $fieldname, "value", $rowValue, "data", $this->_data));
			if (@$args->cancel === true)
				return @$args->value;
			else if (!is_null(@$args->data)) // === true
				$this->_data = $args->data;
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
					if(!($rowValue instanceof MultilinkField) && !defined("MODE_ADMIN")){
                        if(!@eval(convert_php(load_from_file($rowValue), "\$value")))
                            $value = $rowValue;
                	} else
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

#endregion

#region Aliases

	public function to_xml(){ return $this->ToXML(); }
	
	public function from_xml($el) { $this->FromXML($el); }
	
#endregion

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

	/*public function __get($nm) {
		$fn = $this->storage->fname($nm);
		return @$this->_data->$fn;
	}

	public function __set($nm, $val) {
		$fn = $this->storage->fname($nm);
		@$this->_data->$fn = $val;
	}*/

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
	
	/*public function QueryRows($fields, $condition = "", $order = ""){
		global $core;
		
		$sql = "select ".$fields." from ".$this->storage->table;
		$sql .= ($condition == "") ? $condition : " where ".$condition;
		$sql .= ($order == "") ? $order : " order by ".$order;
		
		return $core->dbe->ExecuteReader($sql, $this->storage->fname("id"));
	}*/

	/*public function QueryPage($sql, $identity = "", $page = -1) {
		global $core;
		
		$this->data = $core->dbe->query_page($sql, $identity != "" ? $identity : $this->storage->fname("id"), $page, $this->pagesize);
	}*/

   	public function Affected() {
		return $this->_reader->affected;
	}

	public function Count() {
        if(is_null($this->_reader)) {
            return 0;
        }
		return $this->_reader->count;
	}
	
	/*public function Rewind() {
		$this->data->Rewind();
	}*/
	
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
        
        // if $drs is null, delete all datarows loaded
        if(is_null($drs)) {
            while($dt = $this->FetchNext()) {
                $dt->Delete();
            }
            return;
        }
        
		// $drs must be na array of DataRow-s or a single DataRow
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
				//$dr->storage->fromfname($idf)
				$value = $tdrs->FetchNext()->$idf;
			} else {
				$dr->Save();
				$value = $dr->$idf;
			}
			
			$ids[] = $value;
			
			//$dr->Save();
			//$ids[] = $dr->id;
		}
		$this->Load("", $this->storage->fname("id")." in (".implode(", ", $ids).")");
	}

#region Aliases	
	
	public function to_xml(){ return $this->ToXML(); }
	
	public function from_xml($el){ $this->FromXML($el); }
	
#endregion
	
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
    
    /*public function Rewind() {
        $this->_data->Rewind();
    }*/
    
    
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
    
    public function FetchAll($clsname = null){ ///
        $ret = new Collection();
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
        // $drs must be na array of DataRow-s or a single DataRow
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
                //$t = new phptemplate($pub->datarow->storage);
                
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
                //$dr->storage->fromfname($idf)
                $value = $tdrs->FetchNext()->$idf;
            } else {
                $dr->Save();
                $value = $dr->$idf;
            }
            
            $ids[] = $value;
            
            //$dr->Save();
            //$ids[] = $dr->id;
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
    
    /*    */
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
