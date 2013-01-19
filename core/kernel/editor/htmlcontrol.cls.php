<?php

class HtmlExControl extends Control {

	public function __construct($name, $value, $required, $args = null, $className = "", $styles = "") {
		parent::__construct($name, $value, $required, $args, $className, $styles);
		if(is_empty($this->class))
			$this->class = "";
		if(is_empty($this->styles))
			$this->styles = "width: 100%; height: 340px;";
	}
	
	public function Render() {
		$ret = '';
        global $core;
        $shh = $this->name."_showhtml";
        
        $ret .= $this->RenderScripts(); 
        if($core->rq->$shh == "1") {
            $ret .= $this->RenderHTMLControl();
        }
        else {
            $ret .= $this->RenderMemoBox();
        }
		return $ret;
	}

    public function RenderScripts($script = "") {
        $script .= '
            <script language="javascript">
                // HTML Control scripts
                // <!--
                function evtHTMLProcessTab(e) {
                    if(!e)
                        e = window.event;

                    if(window.browserType == "IE") {
                        if(e.keyCode == 9) { 
                            var r = document.selection.createRange();
                            r.text = \'\t\'; 
                            r.collapse(false);
                            r.select();
                            return false;
                        }
                    }
                    else {
                        if(e.keyCode == 9) {
                            var obj = e.target;
                            start = obj.selectionStart;
                            obj.value = obj.value.substr(0,start)+\'\t\'+obj.value.substr(start);
                            obj.setSelectionRange(start+1, start+1);
                            obj.focus();
                            return false;
                        }
                    }
                    
                }
                // -->
                // HTML Contol scripts
            </script>        
        ';
        return parent::RenderScripts($script);
    }
    
    function RenderMemoBox() {
        global $postback;
        $this->CheckValue();
        return '
            <input type="hidden" name="'.$this->name.'_showhtml" value="0">
            <table width="100%" cellpadding=0 cellspacing=0>
             <tr>
                <td style="padding:0px;">
                    <table cellpadding=0 cellspacing=0>
                    <tr><td><input type="image" valign="absmiddle" src="images/icons/word.gif" border="0" hspace="2" onclick="javascript: this.form.method = \'post\'; this.form.elements[\''.$this->name.'_showhtml\'].value=\'1\'; this.form.submit(); " title="'.$postback->lang->load_vseditor.'">
                    </td><td>'.$postback->lang->load_vseditor.'
                    </td></tr>
                    </table></td>
             </tr>
             <tr>
                <td style="padding:0px;"><textarea class="'.$this->class.'" style="'.$this->styles.'" wrap="off" name="'.$this->name.'" '.$this->attributes.' onkeydown="javascript: return evtHTMLProcessTab(event);">'.$this->value.'</textarea></td>
             </tr>
             </table>'; 
    }
    
    function RenderHTMLControl() {
        global $admin_html_styles;
        preg_match('/width:(.*); height:(.*)/', $this->styles, $matches);
        $c = FCKeditor::Instance($this->name, $this->value, $matches[1], $matches[2], array(
                "CustomConfigurationsPath" => "../pioneer/pioneer.config.js?t=".microtime(true),
                "EditorAreaCSS" => $admin_html_styles["style"],
                "StylesXmlPath" => $admin_html_styles["xml"]                
            ));
        return $c->CreateHtml();
    }
	
	public function Validate() {
		if($this->required && is_empty($this->value)){
			$this->message = "This field is required";
			$this->isValid = false;
		}
		else if(!is_empty($this->value)) { 
			if(!is_string($this->value))
				$this->message = "Value of this field must be a string";
			$this->isValid = is_string($this->value);
		}
		return $this->isValid;
	}

}

?>