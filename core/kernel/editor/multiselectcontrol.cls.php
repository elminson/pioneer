<?

class MultiselectExControl extends Control {

    public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
        parent::__construct($name, $value, $required, $args, $className, $styles);
        $this->styles .= "width: 100%; height: 120px; overflow: auto; border: 1px solid #c0c0c0";
    }

    public function Render() {
         
        // $this->value array of values viewed values selected i.e. array($valuesselected, $valuesviewed)
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
