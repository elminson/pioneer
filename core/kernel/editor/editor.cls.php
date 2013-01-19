<?

class Editor extends IEventDispatcher {
    
    public $dta;
    public $postback;
    
    public $state = EDITOR_NORMAL;
    public $action = EDITOR_ACTION_NONE;
    public $subactionfield = "";
    
    public $parentpostback = null;
    
    public $fields;
    public $fieldgroups;
    public $currentGroup;
    
    public $controls = null;
    
    public $name = null;
    
    public $withCommandBar = false;
    
    public $texts;
    
    public $blob_operations;
        
    public function __construct($dta, $postback_form, $name = null) {
        $this->dta = $dta;
        $this->postback = $postback_form;
        
        $this->RegisterEvent("editor.loading");
        $this->RegisterEvent("editor.loaded");
        $this->RegisterEvent("editor.validating");
        $this->RegisterEvent("editor.validated");
        $this->RegisterEvent("editor.rendering");
        $this->RegisterEvent("editor.rendered");
        $this->RegisterEvent("editor.commandbar.render");
        $this->RegisterEvent("editor.scripts.render");
        $this->RegisterEvent("editor.control.create");
        $this->RegisterEvent("editor.control.created");
        $this->RegisterEvent("editor.control.validating");
        $this->RegisterEvent("editor.control.validated");
        $this->RegisterEvent("editor.control.rendering");
        $this->RegisterEvent("editor.control.rendered");
        $this->RegisterEvent("editor.get_request");
        
        $args = $this->DispatchEvent("editor.loading", Hashtable::Create("data", $dta, "storage", $dta->storage));
        if(@$args->data)
            $dta = $args->data;
        
        $this->name = $name;
        if(is_null($this->name))
            $this->name = "f".str_random(10);
        
        $this->state = EDITOR_NORMAL;
        
        $this->controls = new Collection();
        $fields = null;
        if($this->dta instanceof Publication) {
            $fields = $this->dta->datarow->storage->fields;
        }
        else {
            $fields = $this->dta->storage->fields;
        }
        $this->fields = $fields;
        
        $this->fieldgroups = new ArrayList();
        if($this->dta instanceof Publication) {
            $this->fieldgroups = $this->dta->datarow->storage->fieldgroups;
        }
        else {
            $this->fieldgroups = $this->dta->storage->fieldgroups;
        }        
        
                
        $this->currentGroup = "";
        if($this->rq("currentGroup"))
            $this->currentGroup = $this->rq("currentGroup");
        
        if($this->rq("r_action"))
            $this->action = $this->rq("r_action");
          
        if($this->fieldgroups->Count() > 1) {
            if($this->currentGroup == "")
                $this->currentGroup = $this->fieldgroups->Item(0)->Item(0)->group;
                
            $this->fields = $this->fieldgroups->Item($this->currentGroup);
            
            foreach($this->fields as $field) {
                $this->controls->add($field->field, new EditorField($this, $field));
            }
        }
        else {
            foreach($fields as $field) {
                $this->controls->add($field->field, new EditorField($this, $field));
            }
        }
        
        $this->texts =  array(
            "save" => "Save",
            "cancel" => "Cancel",
            "apply" => "Apply",
            "subtable" => "Edit subtable",
            "remove" => "Remove"
        );
        
        $this->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
        $this->file_operations = array("handlerObject" => $this, "function" => "getFileOperations");
        
        $this->DispatchEvent("editor.loaded", Hashtable::Create());
    
    }
    
    function ReCreateControls() {
        
        if(!is_null($this->controls))
            $this->controls->Clear();
        else
            $this->controls = new Collection();
        
        $fields = null;
        if($this->dta instanceof Publication) {
            $fields = $this->dta->datarow->storage->fields;
        }
        else {
            $fields = $this->dta->storage->fields;
        }
        
        $this->fields = $fields;
        
        foreach($fields as $field) {
            $this->controls->add($field->field, new EditorField($this, $field));
        }

    }    
    
    public function storage() {
        if($this->dta instanceof Publication)
            return $this->dta->datarow->storage;
        else {
            return $this->dta->storage;
        }
    }
    
    public function rq($name) {
        $n = $this->name."_".$name;
        $v = $this->postback->$n;
        
        if(is_serialized(base64_decode($v)))
            return base64_decode($v);
        
        return $v;
    }
    
    public function valueOf($name) {
        
        $v = null;
        if($this->controls instanceof Collection)
            if($this->controls->Exists($name))
                $v = $this->controls->$name->valueOf();
        
        if(!is_null($v))
            return $v;
        
        if(!is_null($this->rq($name)))
            $value = $this->rq($name);
        else {
            if($this->dta instanceof Publication)
                $value = $this->dta->datarow->$name;
            else {
                $value = $this->dta->$name;
            }
        }
        
        if (is_string($value) && $value == "{null}")
            $value = null;
        
        return $value;
    }
    
    public function get_request() {
        $fields = $this->storage()->fields;
        $values = new collection();
        foreach($fields as $field) {
            $values->add($this->dta->storage->fname($field->field), $this->valueOf($field->field));
        }

        $args = $this->DispatchEvent("editor.get_request", Hashtable::Create("storage", $this->dta->storage, "data", $values));
        if(@$args->data)
            $values = @$args->data;
        
        return $values;
    }

    public function Validate() {
        $this->state = EDITOR_VALIDATING;
        
        foreach($this->controls as $control) {
            $control->Validate();
        }
        
        if($this->state != EDITOR_ERROR)
            $this->state = EDITOR_NORMAL;

    }

    public function Render() {
        $this->state = EDITOR_RENDERING;
        $ret = "";
        $ret .= $this->RenderScripts();
        $ret .= $this->RenderContent();
        $this->state = EDITOR_NORMAL;
        return $ret;
    }
    
    public function TransferPostVars() {
        $fields = $this->storage()->fields;

        $ret = "";
        $name = $this->name."_postback";
        foreach($fields as $field) {
            if($this->currentGroup != $field->group) {
                $v = $this->valueOf($field->field);
                if(is_object($v)) {
                    if($v instanceOf DataRow) { // means that the field is a lookup
                        $lookup = $field->SplitLookup();
                        $v = $v->{$lookup->id};
                    }
                    else {
                        if($field->type == "multiselect")
                            $v = join(",", $v->Keys());
                        else {
                            if(method_exists($v, "ToString"))
                                $v = $v->ToString();
                            else
                                $v = "";
                        }
                    }
                }
                if(is_serialized($v))
                    $v = base64_encode($v);                
                $ret .= $this->postback->SetPostVar($this->name."_".$field->field, $v);
            }
        }
       
        return $ret;
    }
    
    public function RenderScripts() {
        
        $output = '
                function changeMethod(method, obj) {
                    obj.form.method = method;
                }
        
                function setAction(obj, action, subactionfield, message) {
                    var b = true;
                    if(message)
                        b = window.confirm(message)
                    if(b) {
                        obj.form.elements[\''.$this->name.'_r_action\'].value = action;
                        obj.form.elements[\''.$this->name.'_subactionfield\'].value = subactionfield;
                        obj.form.method = "post";
                        obj.form.submit();
                    }
                    return false;
                }
        ';
        
        $args = $this->DispatchEvent("editor.scripts.render", Hashtable::Create("output", $output));
        if(@$args->output)
            $output = @$args->output;

        return '
            <script language="javascript">
            '.$output.'
            </script>
        ';
    }
    
    public function RenderEditorBar() {
        
        if($this->fieldgroups->Count() > 1) {
            $buttons = array();
            foreach($this->fieldgroups as $key => $value) {
                if($value->Item(0) instanceOf Field)
                    $buttons[] = array($value->Item(0)->group, 'javascript: changeMethod(\'post\', this); this.form.elements[\''.$this->name.'_currentGroup\'].value=\''.$value->Item(0)->group.'\'; this.form.submit();', ($this->currentGroup == $value->Item(0)->group ? true : false));
            }
            
            $cmd = new CommandBar($this->postback);
            $cmd->Containers->Add(new CommandBarLabelContainer("label0", "&nbsp;"));
            $cmd->Containers->Add(new CommandBarLabelContainer("label1", "Группы"));
            $cmd->Containers->Add(new CommandBarTabContainer("groups", $buttons));
            return $this->postback->SetPostVar($this->name."_currentGroup", $this->currentGroup).$cmd->Render();
        }
        else 
            return "";
    }

    public function RenderContent() {
        $ret = "";
        
        $ret .= '
            <input type="hidden" name="'.$this->name.'_r_action" value="none" >
            <input type="hidden" name="'.$this->name.'_subactionfield" value="" >
            <table width="100%" border="0" class="content-table" id="'.$this->name.'_table" cellspacing="0" cellpadding="0">
        ';
        
        $ret .= $this->TransferPostVars();
        $controls = '';
        $messages = "";
        foreach($this->controls as $control) {
            $controls .= $control->Render();
            if($control->error)
                $messages .= $control->field->name.'='.$control->message.'<br>';
        }
        
        if($messages != "")
            $ret .= '
                <!--editor row--><tr>
                    <td colspan="2">
                        <div class="warning">
                            <div class="warning-title">
                            You have an errors in your form<br>
                            Please check the fields marked with red box and try to recover value
                            </div>
                            '.$messages.'    
                        </div>
                    </td>
                </tr><!--editor row-->
            ';
        
        $ret .= $controls;
        
        
        $ret .= '
                <tr>
                    <td width="15%">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td height="50">
        ';
        if($this->withCommandBar)
            $ret .= $this->RenderCommandBar();
        $ret .= '
                    </td>
                </tr>
            </table>
            ';
        return $ret;
    }
    
    function RenderCommandBar() {
        
        $cmd = array();
        
        $cmd[] = array('button', $this->texts["save"], $this->name.'_save', 'javascript: return setAction(this, \'save\');');
        $cmd[] = array('button', $this->texts["cancel"], $this->name.'_cancel', 'javascript: return setAction(this, \'cancel\');');
        $cmd[] = array('button', $this->texts["apply"], $this->name.'_apply', 'javascript: return setAction(this, \'apply\');');
        
        $args = $this->DispatchEvent("editor.commandbar.render", Hashtable::Create("cmd", $cmd));
        if(@$args->cmd)
            $cmd = @$args->cmd;
            
        $output = '
            <table>
                <tr>
            ';
            
        foreach($cmd as $c) {
            
            if($c[0] == 'button') {
                $output .= '
                    <td>
                        <input type="submit" name="'.$c[2].'" value="'.$c[1].'" class="small-button-long" onclick="'.$c[3].'">
                    </td>
                ';
            }
            elseif($c[0] == 'html') {
                $output .= '
                    <td>
                        '.$c[1].'
                    </td>
                ';
            }
        }
        
        $output .= '
                </tr>
            </table>
            ';
        
        return $output;
    }
    
    function getBlobOperations($operation, $prefix, $field) {
        switch($operation) {
            case "add":
                return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle='.$prefix."_".$field->field.'_addBlob_complete';
                break;
            case "edit":
                return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=add&handle='.$prefix."_".$field->field.'_addBlob_complete&edit=';
                break;
            case "select":
                return 'floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler='.$prefix."_".$field->field.'_addBlob_complete';
                break;
        }
    }

    function getFileOperations($operation, $prefix, $field) {
        switch($operation) {
            case "select":
                return 'floating.php?postback_section=publications&postback_action=files&postback_command=select&handler='.$prefix."_".$field->field.'_selectFile_complete';
                break;
        }
    }




    
}

class EditorField extends IEventDispatcher {

    public $editor;
    public $field;
    public $message;
    public $error = false;
    
    public $control;
    
    public function __construct($editor, $field) {
        $this->editor = $editor;
        $this->field = $field;
        
        $this->RegisterEvent("editor.control.initializing");

        /* new */
        $field = $this->field->field;
        
        $value = $this->editor->valueOf($field);
        
        if (is_null($value))
            if(!is_empty($this->field->default))
                $value = $this->field->default;
        
            
        $prefix = $this->editor->name;
        
        if($this->field->onetomany != "")
            $controlname = 'MultilinkFieldExControl';    
        else if($this->field->lookup != "" && $this->field->type != "multiselect")
            $controlname = 'LookupExControl';    
        else
            $controlname = $this->field->type.'ExControl';

        $args = $this->DispatchEvent("editor.control.initializing", Hashtable::Create("classname", $controlname, "field", $this->field));
        if(@$args->classname)
            $controlname = $args->classname;
        
        $controlname = str_replace(" ", "", $controlname);

        
        $this->control = new $controlname($prefix."_".$this->field->field, $value, $this->field->required, new Collection(array('editorObject' => $this->editor)));
        $this->control->values = $this->field->values;
        $this->control->lookup = $this->field->SplitLookup();
        $this->control->multilink = $this->field->onetomany;
        $this->control->field = $this->field;

        $this->control->args->Add("editor", $this->editor->name);
        $this->control->args->Add("field", $this->field->field);
        $this->control->args->Add("texts", $this->editor->texts);
        $this->control->args->Add("type", $this->field->type);
        /* new */        
        
        $this->DispatchEvent("editor.control.creating", Hashtable::Create());
    }    
    
    function valueOf() {
        return $this->control->valueOf();
    }
    
    public function Validate($control = null) {
        global $core;
        
        $args = $this->DispatchEvent("editor.control.validating", Hashtable::Create("control", $this->control));
        if(@$args->cancel) {
            if(@$args->error) {
                $this->error = @$args->message;
                $this->editor->state = EDITOR_ERROR;
            }
            return;
        }
        
        $field = $this->field->field;
        $value = $this->editor->valueOf($field);
        $prefix = $this->editor->name;
        
        $this->error = !$this->control->Validate();
        $this->message = $this->control->message;
        
        if($this->error)
            $this->editor->state = EDITOR_ERROR;
        
        $this->DispatchEvent("editor.control.validated", Hashtable::Create());
    }
    
    public function Render() {
        $ret = "";
        
        $args = $this->DispatchEvent("editor.control.rendering", Hashtable::Create("field", $this->field->field, "output", $ret));
        if(@$args->changed === true) {
            $ret = $args->output;
        }
        
        $prefix = $this->editor->name;
        $field = $this->field->field;
        $value = $this->editor->valueOf($field);
        
        $required = $this->field->required ? "<span style='color:#ff0000'>*</span>" : "";
        
        $ret .= '
            <tr>
                <td class="field" valign="top" width="15%" ondblclick="javascript: hideRow(this);" onselectstart="return false;" title="Double click to toogle (hide/show row)">
        ';
        $ret .=    $this->field->name.$required;
        $ret .= '
                </td>
                <td width="85%" class="value'.(!$this->control->isValid ? ' errorbox' : '').'">
                <a name="'.$prefix."_".$this->field->field.'_link"></a>
        ';
        
        $ret .= $this->control->Render().'<div class="error">'.$this->control->message.'</div>';
        
        $ret .= '
                </td>                  
            </tr>
        ';
        
        $args = $this->DispatchEvent("editor.control.rendered", Hashtable::Create("output", $ret));
        if(@$args->output)
            $ret = @$args->output;
            
        return $ret;
    }
    
        
}


        
        
?>
