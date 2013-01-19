<?php



class Popup {
	
	private $_name;
	private $_content;
	private $_size;
	private $_title;
	private $_openUp;
	private $_openLeft;
	
	static $scriptsRendered = false;
	static $stylesRendered = false;
	
	public function __construct($name, $title, $content = "", $size = null, $openUp = false, $openLeft = false) {
		$this->_name = $name;
		$this->_content = $content;
		$this->_size = $size;
		$this->_openUp = $openUp;
		$this->_openLeft = $openLeft;
		if($this->_size == null)
			$this->_size = new Size();
		$this->_title = $title;
	}
	
	public function Render() {
		$content = '';
		if(!Popup::$stylesRendered)
			$content .= $this->RenderStyles();
		if(!Popup::$scriptsRendered)
			$content .= $this->RenderScripts();
			
		$content .= '<div class="popup" style="'.$this->_size->style.'" id="'.$this->_name.'">';
		$content .= '	<div class="title">';
		$content .= '		<a href="#" onclick="javascript: popup__toggle(\''.$this->_name.'\'); '.($this->_openUp ? 'popup__moveup(\''.$this->_name.'\');' : '').'; '.($this->_openLeft ? 'popup__moveleft(\''.$this->_name.'\');' : '').'return false;"><span>'.$this->_title.'</span><img src="/admin/images/icons/popup_open.gif" border="0" /></a>';
		$content .= '	</div>';
		$content .= '	<div class="content" style="display: none;">';
		$content .= '		'.$this->_content;
		$content .= '	</div><div class="shadow" style="display: none;">&nbsp;</div>';
		$content .= '</div>';
		return $content;
	}
	
	private function RenderStyles() { 
		$content = '';
		$content = '
			<style type="text/css"> 
				.popup {
					float:left;
					white-space: nowrap;
					padding:0px;
					margin:0px 0px 0px 0px;
				}
				
				.popup .title {
					width: 100%;
					float:left;
					margin:3px 0px 0px 0px;
				}
				
				.popup .title span {
					display: block; 
					float: left;
					margin: 0px 0px 0px 5px;
					cursor: default;
					font-size: 11px;
				}
				
				.popup .title img {
					display: block; 
					float: right;
					margin: 1px 0px 0px 5px;
					cursor: default;
				}

				.popup .content {
					position: absolute;
					z-index: 1000;
					border: 1px solid #c0c0c0;
					background-color: #fff;
                    font-weight: normal;
				}
                
                .popup .shadow {
                    position: absolute;
                    z-index: 900;
                    background-color: #000;
                }
                
                .popup .shadow {
                    -moz-opacity: 0.5;
                    -opera-opacity: 0.5;
                    filter: alpha(opacity=50);
                }
				
				.popup .content div.popup-content { 
					padding: 2px;
				}
                
                .popup .content fieldset table tr td {
                    font-weight: normal;
                    color: #666666;
                }

				.popup-title {
					padding: 2px;
					white-space: nowrap;
					color: #fff;
					background-color: #5A6B7D;
				}
				.popup-row {
					white-space: nowrap;
					padding: 5px;
					clear: both;
				}

                .popup-row-c {
                    white-space: nowrap;
                    padding: 0px;
                    clear: both;
                    max-height: 200px;
                    overflow: auto;
                }
                
                .popup legend {
                    color:#000;
                }
                
			</style>
		';
		Popup::$stylesRendered = true;
		return $content;
	}

	private function RenderScripts() { 
		$content = '';
		$content = '
			<script language="javascript"> 
				window.popup__last = null;
			
				function popup__moveup(name) {
					var popup = document.getElementById(name);
					var content = popup.childNodes[1];
					if(!document.all && !window.opera) content = popup.childNodes[3];
                    var shadow = popup.childNodes[2];
                    if(!document.all && !window.opera) shadow = popup.childNodes[4];
                    if(window.opera) shadow = popup.childNodes[3];

                    
					if(document.all && !window.opera) {
						content.style.marginTop = (-content.offsetHeight-popup.offsetHeight) + "px";
                        shadow.style.marginTop = (-content.offsetHeight-popup.offsetHeight-4) + "px";
                    }
					else {
						content.style.marginTop = (-content.offsetHeight) + "px";
                        shadow.style.marginTop = (-content.offsetHeight-4) + "px";
                    }
				}

				function popup__moveleft(name) {
					var popup = document.getElementById(name);
					var content = popup.childNodes[1];
					if(!document.all && !window.opera) content = popup.childNodes[3];
					if(document.all && !window.opera)
						content.style.marginLeft = (-content.offsetWidth+popup.offsetWidth) + "px";
					else
						content.style.marginLeft = (-content.offsetWidth+popup.offsetWidth) + "px";
				}
			
				function popup__toggle(name) {
					
					var popup = document.getElementById(name);
					var content = popup.childNodes[1];
					if(!document.all && !window.opera)
						content = popup.childNodes[3];
                    if(window.opera)
                        content = popup.childNodes[3];
					
                    var shadow = popup.childNodes[2]; 
                    if(!document.all && !window.opera)
                        shadow = popup.childNodes[4];
                    if(window.opera)
                        shadow = popup.childNodes[3];

					var isOpened = content.style.display == "";
					if(isOpened) {
						popup__closelast();
					}
					else {
						popup__closelast();
						content.style.display = "";
                        shadow.style.display = "";
						window.popup__last = popup;
					}
                    
					
					content.style.marginTop = popup.offsetHeight+"px";
                    if(document.all && !window.opera)
                        content.style.marginLeft = "-"+popup.offsetWidth+"px";
                    
                    shadow.style.marginTop = (parseInt(content.style.marginTop)+4)+"px";
                    shadow.style.marginLeft = "4px";
                    if(document.all && !window.opera)
                        shadow.style.marginLeft = "-"+(popup.offsetWidth-4)+"px";

                    shadow.style.width = content.offsetWidth+"px";
                    shadow.style.height = content.offsetHeight+"px";
					
				}
				
				function popup__closelast() {
					if(window.popup__last != null) {
						var content = window.popup__last.childNodes[1];
						if(!document.all && !window.opera)
							content = window.popup__last.childNodes[3];
                        if(window.opera)
                            content = window.popup__last.childNodes[3];
                            
                        var shadow = window.popup__last.childNodes[2];
                        if(!document.all && !window.opera)
                            shadow = window.popup__last.childNodes[4];
                        if(window.opera) 
                            shadow = window.popup__last.childNodes[3];

						content.style.display = "none";
                        shadow.style.display = "none";
                        window.popup__last = null; 
					}
				}
                
                function clearform(form) {
                    var len = form.elements.length;
                    for(var i=0; i<len; i++) {
                        var el = form.elements[i];
                        if(el.name && el.name.substr(0,4) == "flt_") {
                            if(el.options)
                                el.selectedIndex = -1;
                            else 
                                el.value = "";
                        }
                    }
                }
				
			</script>
		';
		Popup::$scriptsRendered = true;
		return $content;
	}
	
	public static function Create($name, $title, $content = "", $size = null) {
		$p = new Popup($name, $title, $content, $size);
		return $p->Render();
	}
	
}

class FilterPopup extends Popup {
	
	public function __construct($name, $filter, $lang, $command, $openUp = false, $openLeft = false) {
        global $postback, $core;
        if(is_null($postback)) {
            $postback = new Object();
            $postback->lang = new Object();
            $postback->lang->filter_fulltext = "Fulltext search";
            $postback->lang->filter_fulltextsearch = "Query: ";
            $postback->lang->filter_dates = "Date created: ";
            $postback->lang->filter_field_contains = "contains";
            $postback->lang->filter_field_equals = "equals";
            $postback->lang->filter_datesearch = "Search by date modified";
            $postback->lang->filter_fields = "Search for field values";
        }
            
        
        $dstart = $postback->flt_dstart ? $postback->flt_dstart : "{null}";
        $dend = $postback->flt_dend ? $postback->flt_dend : "{null}";
        
        $dts = new DateTimeExControl("flt_dstart", $dstart, false);
        $dte = new DateTimeExControl("flt_dend", $dend, false);
        
		$content = '
			<div class="popup-row" style="width: 450px;">
                <fieldset> 
                    <legend>'.$postback->lang->filter_fulltext.'</legend>

                    <table width="100%">
                    <tr>
                        <td width="100">
                            '.$postback->lang->filter_fulltextsearch.'
                        </td>
                        <td style="padding-left: 11px;">
                            <input type="text" name="flt_fulltext" value="'.$postback->flt_fulltext.'" class="text-box" style="width: 180px;" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-left: 11px;">'.$postback->lang->filter_fulltextsearch_desc.'</td>
                    </tr>
                    </table>
                </fieldset>
            
                <fieldset> 
                    <legend>'.$postback->lang->filter_datesearch.'</legend>
                    <table width="100%">
                    <tr>
                        <td width="100">
                            '.$postback->lang->filter_dates.'
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>'.$dts->Render().'</td>
                                    <td>&nbsp;-&nbsp;</td>
                                    <td>'.$dte->Render().'</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </table>
                </fieldset>
                
        ';
        
        $storage = null;
        $form = $postback->post_vars("storages_id_");
        if(!is_empty($postback->storage_id_change))
            $storage = new Storage($postback->storage_id_change);
        else if(!is_empty($postback->storage_id))
            $storage = new Storage($postback->storage_id);
        else if($form->Count() > 0)
            $storage = new Storage($form->item(0));
        else {
            $strgs = Storages::Enum();
            $storage = $strgs->first;
        }
                
        if(!is_null($storage)) {
            $content .= '
                <fieldset> 
                    <legend>'.$postback->lang->filter_fields.'</legend>
                    
                    <div class="popup-row-c">
                
                    <table width="100%">
            ';
            foreach($storage->fields as $f) {
                if(!$f->isMultilink && 
                    (to_lower($f->type) == 'text' || 
                        to_lower($f->type) == 'memo' || 
                        to_lower($f->type) == 'html' || to_lower($f->type) == 'numeric' || 
                        to_lower($f->type) == 'datetime' || 
                        to_lower($f->type) == 'file' || to_lower($f->type) == 'file list')) {
                    $fname = 'flt_'.$storage->table.'_'.$f->field;
                $content .= '
                <tr>
                    <td width="100">
                        '.$f->name.'
                    </td>
                    <td style="padding-left: 11px;">
                        <select name="flt_'.$storage->table.'_'.$f->field.'_e">
                            <option value="%">'.$postback->lang->filter_field_contains.'</option>
                            <option value="=">'.$postback->lang->filter_field_equals.'</option>
                        </select>
                ';
                if($f->isLookup) {
                    $lookup = $f->SplitLookup();
                    //.(is_empty($lookup->condition) ? '' : ' where '.$lookup->condition)
                    $query = (!is_empty($lookup->query)) ? $lookup->query : "SELECT ".$lookup->fields." FROM ".$lookup->table.(is_empty($lookup->order) ? '' : ' order by '.$lookup->order);
        
                    $show_fields_list = explode(",", $lookup->show);
                    for ($i = 0; $i < count($show_fields_list); $i++)
                        $show_fields_list[$i] = trim($show_fields_list[$i]);
                    
                    $q = $query;
                    $result = $core->dbe->ExecuteReader($q);
                    $result = $result->ReadAll();
                    
                    $content .= RenderSelectCheck('flt_'.$storage->table.'_'.$f->field, $postback->$fname, "180px", false, $result, $lookup->id, $show_fields_list[0]);
                }
                else {
                    $content .= '<input type="text" name="flt_'.$storage->table.'_'.$f->field.'" value="'.$postback->$fname.'" class="text-box" style="width: 180px;" />';
                }
                $content .= '
                    </td>
                </tr>
                ';
                }
            }
            $content .= '
                </table>
                </div>
                </fieldset>
            ';
        }
        $content .= '
               <table width="100%">
               <tr>
                    <td align=right>
                        <input type="submit" name="filterClear" value="X" onclick="javascript: clearform(this.form); return PostBack(\''.$command.'\', \'post\')" class="small-button" />
                        <input type="submit" name="filterGo" value="'.$lang->filter_go.'" onclick="return PostBack(\''.$command.'\', \'post\')" class="small-button-long" />
                    </td>
                </tr>
                </table>
			</div>
		';
		parent::__construct($name, $lang->filter_title.": ".($filter == "" ? "none" : substr($filter, 0, 10)."..."), $content, null, $openUp, $openLeft);
	}
	
	public static function Create($name, $filter, $lang, $command, $openUp = false, $openLeft = false) {
		$p = new FilterPopup($name, $filter, $lang, $command, $openUp, $openLeft);
		return $p->Render();
	}
    
    public static function Query($postback) {
        
        if(is_null($postback)) {
            global $postback;
        }
        
        $q = "";
        $flt = $postback->post_vars("flt_");
        foreach($flt as $k => $item) {
            if(!is_empty($item))
                $q .= "&".$k."=".$item;
        }
        return substr($q, 1);
        
    }
    
    public static function Expression($postback = null) {
        if(is_null($postback)) {
            global $postback;
        }
        
        $flt = $postback->post_vars("flt_");
        $cond = "";
        
        $storage = null;
        $form = $postback->post_vars("storages_id_");
        if(!is_null($postback->storage_id_change))
            $storage = new Storage($postback->storage_id_change);
        else if(!is_null($postback->storage_id))
            $storage = new Storage($postback->storage_id);
        else if($form->Count() > 0)
            $storage = new Storage($form->item(0));
        else {
            $strgs = Storages::Enum();
            $storage = $strgs->first;
        } 
        
        if(is_null($storage))
            return "";
        
        $prefix = $storage->istree ? 'A.' : '';
        if($flt->flt_fulltext) {
            $condit = array();
            foreach ($storage->fields as $k => $v){
                if ($v->type != "BLOB")
                    $condit[] = $prefix.$storage->table."_".$k;
            }
            if (count($cond) > 0){
                $condit[] = $prefix.$storage->table."_id";
                if($core->dbe->driver instanceOf MySqlDriver) {
                    $condit = implode(", ", $condit);
                    $condit = "concat(".$condit.") like '%".$flt->flt_fulltext."%'";
                }
                else if($core->dbe->driver instanceOf PgSqlDriver) {
                    $condit = implode("||' '||", $condit);
                    $condit = $condit." like '%".$flt->flt_fulltext."%'";
                }
            }
            
            $cond = " and ".$condit;
        }
        
        if(is_date($flt->flt_dstart) && !is_date($flt->flt_dend)) {
            // konkretnaja data
            $condit = "UNIX_TIMESTAMP(DATE(".$storage->table."_datecreated)) = UNIX_TIMESTAMP(DATE('".$flt->flt_dstart."'))";
            $cond = " and ".$condit;
        }
        
        if(is_date($flt->flt_dstart) && is_date($flt->flt_dend)) {
            // diapazon dat
            $condit = "( UNIX_TIMESTAMP(DATE(".$storage->table."_datecreated)) >= UNIX_TIMESTAMP(DATE('".$flt->flt_dstart."'))";
            $condit .= " and UNIX_TIMESTAMP(DATE(".$storage->table."_datecreated)) <= UNIX_TIMESTAMP(DATE('".$flt->flt_dend."')) )";
            $cond = " and ".$condit;
            
        }
        
        $fcond = "";
        $fltfields = $postback->post_vars("flt_".$storage->table."_");
        foreach($fltfields as $fname => $f) {
            if(!is_empty($f) && substr($fname, strlen($fname)-2, 2) != "_e" && $f != "{null}") {
                $fname = substr($fname, strlen("flt_"));
                $ename = 'flt_'.$fname.'_e';
                $type = $postback->$ename;
                $ffname = $storage->fromfname($fname);
                $field = $storage->fields->$ffname;
                
                if($type == "%" && (in_array($field->type, array('text', 'memo', 'html'))))
                    $fcond .= " and ".$prefix.$fname." LIKE '%".$f."%'";
                else
                    $fcond .= " and ".$prefix.$fname." = '".$f."'";
            }
        }
        
        if(!is_empty($fcond)) {
            $fcond = "(".substr($fcond, 4).")";
            $cond .= " and ".$fcond;
        }
        
        return substr($cond, 4);
        
    }

}

class SortPopup extends Popup {
	
	public $order;
	public $pagerargs;
	
	public function __construct($name, $fld_name, $fld_order, $pagerargs, $lang, $storages, $postbackto, $openUp = false, $openLeft = false) {

		if($fld_name) {
			$pagerargs .= "&fld_name=".$fld_name."&fld_order=".$fld_order;
		}
		
		$select = '<select name=fld_name id=fld_name class=select-box style="width:150px;" onchange="return PostBack(\''.$postbackto.'\', \'get\')">';
		foreach($storages as $storage) {
			$select .= '<option value="">...</option>';
			if($storage instanceof Storage) {
				$select .= '<optgroup label="'.$storage->name.'">';
				$fields = $storage->fields;
				foreach($fields as $field) {
					$select .= '<option value="'.$storage->fname($field->field).'" '.($fld_name == $storage->fname($field->field) ? "selected" : "").'>&nbsp;&nbsp;&nbsp;'.$field->name.'</option>';
				}
				$select .= '</optgroup>';
			}
		}
		$select .= '</select>';
		
		$content = '
			<table>
			<tr>
			<td nowrap="nowrap">
				'.$lang->development_select_orderby.'
			</td><td>'.$select.'</td>
			</tr>
			'.($fld_name != "" ? '
			<tr>
				<td nowrap="nowrap">'.$lang->development_select_direction.'</td><td>
					<select name=fld_order id=fld_order class=select-box style="width:35px;" onchange="return PostBack(\''.$postbackto.'\', \'get\')">
						<option value="desc" '.($fld_order == "desc" ? "selected" : "").'>/\</option>
						<option value="asc" '.($fld_order == "asc" || $fld_order=="" ? "selected" : "").'>\/</option>
					</select>
				</td>
			</tr>
			' : '').'
			</table>
		';
		
		$order = "";
		if($fld_name != "") {
			$order = $fld_name;
			if($fld_order != "")
				$order = $order." ".$fld_order;
		}

		$this->order = $order;
		$this->pagerargs = $pagerargs;

		parent::__construct($name, $lang->development_select_order.": ".($order == "" ? "none" : "sorted"), $content, null, $openUp, $openLeft);
	}	

	public static function Create($name, $fld_name, $fld_order, $pagerargs, $lang, $storages, $postbackto, $openUp = false, $openLeft = false) {
		$p = new SortPopup($name, $fld_name, $fld_order, $pagerargs, $lang, $storages, $openUp, $openLeft);
		return $p->Render();
	}

	
}


?>