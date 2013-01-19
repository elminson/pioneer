<?php

/**
    * class Publications list
    *
    * Description for class PublicationsPageForm
    *
    * @author:
    */
class EditorPageForm extends PostBackForm {
    public $lang;
    /**
        * Constructor.
        *
        * @param
        * @return
        */
    function EditorPageForm($lang = null) {
        parent::__construct("editor", "main", "/admin/floating.php", "get");
        if(is_null($this->lang))
            $this->lang = new stdClass();
            
        $this->RegisterEvent("editorpageform.rendersitefolderform.additional");
    }

    public function MenuVisible() {
        return false;
    }                                 

    function RenderContent() {
        global $core;
        $ret = "";
/*        
        $this->Out("scripts", '
            <script language=javascript>    
                window.setTimeout("window.focus();", 2000);
            </script>
        ');
*/
        switch($this->action) {
            case "main":
                break;
            case "settings":
                switch($this->command) {
                    case "set_permissions": 
                        $ret .= $this->EditSettingPermissions();
                        break;
                    case "save_permissions":
                    
                        $setting = $core->sts->item($this->permissions_item);
                        
                        $setting->securitycache->Clear();
                        $permissions = new Collection();
                        $permissions->FromString($this->permissions);
                        foreach($permissions as $operation => $perm) {
                            $name = explode(".", $operation);
                            $name = $name[0];
                            $operation = substr($operation, strlen($name)+1);
                            if(!$setting->securitycache->Exists($name))
                                $setting->securitycache->Add($name, new ArrayList());
                            $setting->securitycache->$name->Add(new RoleOperation($operation, $perm));
                        }
                        $core->sts->{$this->permissions_item} = $setting;

                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                        
                    case "add":
                    case "edit":
                        $form = $this->post_vars("setting_id_");
                        if($form->count() > 1) {
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                            break;
                        } 
                        else if($form->count() == 0 && is_null($this->setting_id) && $this->command != "add") {
                            $ret .= $this->ErrorMessage($this->lang->error_select_item, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        $this->Out("subtitle", $this->lang->tools_settings_addedit.$form->item(0), OUT_AFTER);
                        
                        $setting_id = '';
                        if($this->command == 'edit') {
                            $setting_id = $form->item(0);
                            if(!is_null($this->setting_id) || $this->setting_id != "")
                                $setting_id = $this->setting_id;
                        }
                        
                        $ballow = true;
                        if($this->command = "add") {
                            $ballow = $core->security->Check(null, "settings.add");
                        }
                        else {
                            $setting = $core->sts->item($setting_id);
                            $ballow = $core->security->CheckBatch($setting->createSecurityBathHierarchy("edit"));
                        }
                    
                        if($ballow)
                            $ret .= $this->RenderSettingForm($setting_id);
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            
                        break;
                    case "message_cancel":    
                    case "message_ok":    
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    case "save":
                        $sname = $this->setting_name;
                        $setting = $core->sts->item($sname);
                        $ballow = true;
                        if($setting == null) {
                            $ballow = $core->security->Check(null, "settings.add");
                        }
                        else {
                            $ballow = $core->security->CheckBatch($setting->createSecurityBathHierarchy("edit"));
                        }
                        
                        if(!$ballow) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                    
                    
                        $stype = $this->setting_type;
                        if(strtolower($stype) == "datetime") {
                            /*
                            [day_setting_value] => 05
                            [month_setting_value] => 06
                            [year_setting_value] => 2006
                            [hour_setting_value] => 10
                            [minute_setting_value] => 03
                            */
                            //$t = mktime($this->hour_setting_value, $this->minute_setting_value, 0, $this->month_setting_value,$this->day_setting_value, $this->year_setting_value);
                            $sval = $this->setting_value;
                        }
                        else if(strtolower($stype) == "check") {
                            if(!$this->setting_value)
                                $sval = "false";
                            else 
                                $sval = "true";
                        }
                        else 
                            $sval = $this->setting_value;
                        
                        $s = new Setting($sname, $stype, $sval, null, $this->setting_issystem, $this->setting_category);
                        $core->sts->$sname = $s;

                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();

                        break;
                }
                break;
            case "notices":
                switch($this->command) {
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    case "set_permissions": 
                        $ret .= $this->EditNoticePermissions();
                        break;
                    case "save_permissions":
                    
                        $notice = Notices::Get($this->permissions_item);
                        
                        $notice->securitycache->Clear();
                        $permissions = new Collection();
                        $permissions->FromString($this->permissions);
                        foreach($permissions as $operation => $perm) {
                            $name = explode(".", $operation);
                            $name = $name[0];
                            $operation = substr($operation, strlen($name)+1);
                            if(!$notice->securitycache->Exists($name))
                                $notice->securitycache->Add($name, new ArrayList());
                            $notice->securitycache->$name->Add(new RoleOperation($operation, $perm));
                        }
                        $notice->Save();

                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                        
                    case "add":
                    case "edit":
                        $form = $this->post_vars("notice_id_");
                        if($form->count() > 1) {
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                            break;
                        } 
                        
                        $this->Out("subtitle", $this->lang->tools_notice_addedit, OUT_AFTER);
                        
                        $notice_id = '';
                        if($this->command == 'edit') {
                            $notice_id = $this->notice_id;
                            if($form->count() > 0)
                                $notice_id = $form->item(0);    
                        }
                        
                        if(is_null($notice_id))
                            $notice_id = -1;                            
                            
                        $ballow = true;
                        if($this->command = "add") {
                            $ballow = $core->security->Check(null, "notices.add");
                        }
                        else {
                            $notice = Notices::Get($notice_id);
                            $ballow = $core->security->CheckBatch($notice->createSecurityBathHierarchy("edit"));
                        }
                    
                        if($ballow)
                            $ret .= $this->RenderNoticeForm($notice_id);
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);

                        break;
                    case "save":
                        
                        $ballow = true;
                        if(!Notices::Exists($this->notice_id)) {
                            $ballow = $core->security->Check(null, "notices.add");
                        }
                        else {
                            $n = Notices::Get($this->notice_id);
                            $ballow = $core->security->CheckBatch($n->createSecurityBathHierarchy("edit"));
                        }
                        
                        if(!$ballow) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        
                                
                        $n = new Notice();
                        $n->id = $this->notice_id;
                        $n->keyword = $this->notice_keyword;
                        $n->encoding = $this->notice_encoding;
                        $n->body = $this->notice_body;
                        $n->subject = $this->notice_subject;
                        $n->Save();
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();

                        break;
                }
                break;
            case "repository":

                switch($this->command) {
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    case "add":
                    case "edit":
                        $form = $this->post_vars("repository_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, "Request errpor");
                        else {
                            $lib = '';
                            if($this->command == 'edit') {
                                $lib = $form->item(0);
                            }
                            $this->Out("subtitle", $this->lang->development_repository_addedit.$lib, OUT_AFTER);
                            if($core->security->Check(null, "interface.repository.".$this->command))
                                $ret .= $this->RenderRepositoryForm($lib);
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "save":
                    case "apply":
                        // module ? 
                        $lib = $this->repository_id;
                        if(!$core->security->Check(null, "interface.repository.".(!is_empty($lib) ? "edit" : "add"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                    
                        $code = preg_replace("/<\[\/textarea\]>/", "</textarea>", $this->repository_code);
                        if(!is_empty($lib))
                            $data = new Library($lib);
                        else
                            $data = new Library();
                        
                        $oldname = $data->name;
                        
                        if(is_empty($lib))
                            $data->name = $this->repository_name;
                        $data->type = $this->repository_type;
                        $data->code = $code;
                        $data->save();
                        
                        if ($oldname != $data->name && !is_empty($oldname)){
                            $mm = CModuleManager::Enum("module_libraries like '".$oldname."'", "", false);
                            if (!$mm)
                                continue;
                            foreach ($mm as $m){
                                $i = $m->libraries->indexof($oldname);
                                if ($i !== false){
                                    $m->libraries->add($data->name, $i);
                                    $m->Save();
                                }
                            }
                        }
                        if($this->command == "apply") {
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->SetPostVar("repository_id_".$data->name, $data->name);
                            $ret .= $this->DoPostBack("edit", "get");
                        }
                        else {
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        break;

                }
                break;
            case "designtemplates":
                $dtemplates = new designTemplates();
                switch($this->command) {
                    case "add":
                    case "edit":
                    
                        $form = $this->post_vars("design_template_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, "Request errpor");
                        else {
                            
                            $dtemplate = '';
                            if($this->command == 'edit')
                                $dtemplate = $form->item(0);
                            
                            $this->Out("subtitle", $this->lang->development_designtemplates_addedit.$dtemplate, OUT_AFTER);
                            if($core->security->Check(null, "interface.designes.".$this->command))
                                $ret .= $this->RenderDesignTemplatesForm($dtemplates, $dtemplate);
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    case "apply":
                    case "save":
                        $dtemplate = $this->template_id;
                        if(!$core->security->Check(null, "interface.repository.".(!is_empty($dtemplate) ? "edit" : "add"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }

                        $data = new collection();
                        $data->add("templates_name", $this->templates_name);
                        $data->add("templates_head", $this->templates_head);
                        $data->add("templates_body", $this->templates_body);

                        $data->add("templates_repositories", $this->templates_repositories);
                        $data->add("templates_html_doctype", $this->templates_html_doctype);
                        $data->add("templates_head_title", $this->templates_head_title);
                        $data->add("templates_head_metakeywords", $this->templates_head_metakeywords);
                        $data->add("templates_head_metadescription", $this->templates_head_metadescription);
                        $data->add("templates_head_baseurl", $this->templates_head_baseurl);
                        $data->add("templates_head_styles", $this->templates_head_styles);
                        $data->add("templates_head_scripts", $this->templates_head_scripts);
                        $data->add("templates_head_aditionaltags", $this->templates_head_aditionaltags);

                        if($dtemplate == "") {
                            $dtemplates->create($data);
                        }
                        else {
                            $dtemplates->save($dtemplate, $data);
                        }

                        $ret .= $this->ReloadOwner();
                        if($this->command == "save")
                            $ret .= $this->CloseMe();
                        else {
                            $ret .= $this->SetPostVar("design_template_id_".$this->templates_name, $this->templates_name);
                            $ret .= $this->DoPostBack("edit", "post");
                        }
                        break;
                }
                break;
            case "sitefolder":
                switch($this->command) {
                    case "addsite":
                        $this->Out("subtitle", $this->lang->development_structure_addsite, OUT_AFTER);
                        $ret .= $this->EditSite("add");
                        break;
                    case "editsite":
                        $this->Out("subtitle", $this->lang->development_structure_editsite, OUT_AFTER);
                        $ret .= $this->EditSite("edit");
                        break;
                    case "editproperties":
                        $this->Out("subtitle", $this->lang->development_structure_editsite, OUT_AFTER);
                        $ret .= $this->EditSite("editproperties");
                        break;
                    case "saveproperties":
                        if($this->site_id != "") {
                            $sf = Site::Fetch($this->site_id);
                            $properties = $sf->properties;
                            foreach($properties as $prop) {
                                $name = $prop->name;
                                $prop->value = $this->$name;
                            }
                            $sf->Save();
                        }
                        $ret .= $this->CloseMe();
                        break;
                    case "clearproperties":
                        if($this->site_id != "") {
                            $sf = Site::Fetch($this->site_id);
                            $properties = $sf->properties;
                            $properties->Clear();
                            $sf->Save();
                        }
                        $ret .= $this->CloseMe();
                        break;
                    case "savesite":
                        $dbt = new dbtree("sys_tree", "tree");
                        if($this->site_id == "")
                            $site = new Site();
                        else
                            $site = new Site($this->site_id);

                        $ballow    = false;
                        if($this->site_id == "") {
                            $ballow = $core->security->Check(null, "structure.sites.add");
                        }
                        else {
                            $ballow = $core->security->CheckBatch($site->createSecurityBathHierarchy("edit"));
                        }
                        
                        if(is_empty($this->name)) {
                            $ret .= $this->ErrorMessage($this->lang->error_nameisrequired, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        if(is_empty($this->site_id)) {
                            if(!Navigator::CheckFolderName($this->name, null)) {
                                $ret .= $this->ErrorMessage($this->lang->error_namedublicated, $this->lang->error_message_box_title);
                                break;
                            }
                        }
                        
                        if($ballow) {
                            
                            $site->published = intval($this->published);
                            $site->name = $this->name;
                            $site->domain = $this->domain;
                            $site->description = $this->description;
                            $site->language = $this->language;
                            $site->template = $this->template;
                            $site->notes = $this->notes;
                            $site->properties = $this->properties;
                            $site->header_statictitle = $this->header_statictitle;
                            $site->header_inlinescripts = $this->header_inlinescripts;
                            $site->header_inlinestyles = $this->header_inlinestyles;
                            $site->header_basehref = $this->header_basehref;
                            $site->header_shortcuticon = $this->header_shortcuticon;
                            $site->header_keywords = $this->header_keywords;
                            $site->header_description = $this->header_description;
                            $site->header_aditionaltags = $this->header_aditionaltags;

                            $site->Save();

                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "savefolder":
                        $dbt = new dbtree("sys_tree", "tree");
                        if($this->site_id == "")
                            $f = new Folder($dbt);
                        else
                            $f = new Folder($dbt, $this->site_id);
                        
                        $fp = null;
                        $ballow    = false;
                        if($this->parent_id != $this->site_id) {
                            $fp = new Folder($dbt, $this->parent_id);
                            $ballow = $core->security->CheckBatch($fp->createSecurityBathHierarchy("children.add"));
                        }
                        else {
                            $ballow = $core->security->CheckBatch($f->createSecurityBathHierarchy("edit"));
                        }
                        
                        if(is_empty($this->name)) {
                            $ret .= $this->ErrorMessage($this->lang->error_nameisrequired, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        if($this->parent_id != $this->site_id) {
                            if(!Navigator::CheckFolderName($this->name, $fp)) {
                                $ret .= $this->ErrorMessage($this->lang->error_namedublicated, $this->lang->error_message_box_title);
                                break;
                            }
                        }
                        
                        if($ballow) {
                            $f->published = intval($this->published);
                            $f->name = $this->name;
                            $f->keyword = null;
                            $f->description = $this->description;
                            $f->template = $this->template;
                            $f->notes = $this->notes;
                            $f->properties = $this->properties;
                            $f->header_statictitle = $this->header_statictitle;
                            $f->header_inlinescripts = $this->header_inlinescripts;
                            $f->header_inlinestyles = $this->header_inlinestyles;
                            $f->header_basehref = $this->header_basehref;
                            $f->header_shortcuticon = $this->header_shortcuticon;
                            $f->header_keywords = $this->header_keywords;
                            $f->header_description = $this->header_description;
                            $f->header_aditionaltags = $this->header_aditionaltags;
                            
                            if($this->parent_id != $this->site_id) {
                                $fp->InsertChild($f);
                            } else {
                                $f->Save();
                            }
                            
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    case "move":
                        $form = $this->post_vars("sites_id_");
                        //if($form->count() > 1)
                        //    $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        //else 
                        
                        if($form->count() == 0) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                        }
                        else {
                            
                            if($form->Count() > 0) {
                                foreach($form as $item) {
                                    $sf = Site::Fetch($item);
                                    if($sf instanceof Site) {
                                        $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                        break;
                                    }
                                    if(!$core->security->CheckBatch($sf->createSecurityBathHierarchy("move"))) {
                                        $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                        break;
                                    }
                                }
                            }
                            else {
                                $sf = $form->item(0);
                                $sf = Site::Fetch($sf);
                                if($sf instanceof Site) {
                                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                    break;
                                }
                                if(!$core->security->CheckBatch($sf->createSecurityBathHierarchy("move"))) {
                                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                    break;
                                }
                            }
                            
                            
                            $this->Out("subtitle", $this->lang->development_structure_moveto." [".$sf->description."]", OUT_AFTER);
                            $ret .= $this->RenderMoveForm($form->count() > 0 ? $form : $sf);
                            
                        }
                        break;
                    case "movefolder":
                        
                        $movetoid = $this->moveto;
                        $moveto = Site::Fetch($movetoid);
                        $form = $this->post_vars("sites_id_");
                        foreach($form as $item) {
                            $s = Site::Fetch($item);
                            if(!$core->security->CheckBatch($s->createSecurityBathHierarchy("delete")) ||
                                !$core->security->CheckBatch($moveto->createSecurityBathHierarchy("add"))) {
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                break;
                            }
                        }

                        $error = false;
                        foreach($form as $item) {
                            $s = Site::Fetch($item);
                            
                            if($this->copy) {
                                if(!$s->Copy($moveto)) {
                                    $ret .= $this->ErrorMessage($this->lang->error_incorrect_move, $this->lang->error_message_box_title);
                                    $error = true;
                                    break;
                                }
                            }
                            else {
                                if(!$s->MoveTo($moveto)) {
                                    $ret .= $this->ErrorMessage($this->lang->error_incorrect_move, $this->lang->error_message_box_title);
                                    $error = true;
                                    break;
                                }
                            }
                            if(!$error) {
                                $ret .= $this->ReloadOwner();
                                $ret .= $this->CloseMe();
                            }
                        }
                        
                        break;
                    case "set_permissions": 
                    
                        $ret .= $this->EditSiteFolderPermissions();
                    
                        break;
                        
                    case "save_permissions":
                    
                        $item = Site::Fetch($this->permissions_item);
                        
                        $item->securitycache->Clear();
                        $permissions = new Collection();
                        $permissions->FromString($this->permissions);
                        foreach($permissions as $operation => $perm) {
                            $name = explode(".", $operation);
                            $name = $name[0];
                            $operation = substr($operation, strlen($name)+1);

                            if(!$item->securitycache->Exists($name))
                                $item->securitycache->Add($name, new ArrayList());
                            $item->securitycache->$name->Add(new RoleOperation($operation, $perm));
                                
                        }
                        $item->Save();

                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();                        
                    
                        break;
                }
                break;
            case "publicationdata":
                switch($this->command) {
                    case "editproperties":
                        $form = $this->post_vars("template_operation_id");
                        if($form->count() > 1) {
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        }
                        else {
                            if($this->link_id != "")
                                $link = $this->link_id;
                            else
                                $link = $form->item(0);

                            if(is_null($link))
                                $ret .= $this->ErrorMessage($this->lang->error_select_data_edit, $this->lang->error_message_box_title);
                            else {
                                $p = new Publication($link, null);
                                $ret .= $this->SetPostVar("cmd", "data");
                                $ret .= $this->SetPostVar("sf_id", $this->sf_id);
                                $ret .= $this->SetPostVar("link_id", $link);
                                if(is_null($p->module))
                                    $ret .= $this->SetPostVar("storage_id", $p->datarow->storage->id);
                                else
                                    $ret .= $this->SetPostVar("storage_id", $p->module->id);
                                
                                $this->Out("subtitle", $this->lang->development_structure_editdata." unique: ".$p->id, OUT_AFTER);
                                if(!is_null($p->module))
                                    $ret .= $this->RenderPublicationPropertiesForm($p);
                                else
                                    if($core->security->CheckBatch($p->datarow->storage->createSecurityBathHierarchy("edit")))
                                        $ret .= $this->RenderPublicationPropertiesForm($p);
                                    else
                                        $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            }
                        }
                        break;
                    case "saveproperties":
                        if($this->pub_id != "") {
                            $pub = new Publication($this->pub_id);
                            $properties = $pub->properties;
                            if($properties->combined) {
                                foreach ($properties as $key => $value){
                                    foreach($value as $prop) {
                                        $name = $key.$prop->name;
                                        $prop->value = $this->$name;
                                    }
                                    $properties->$key = $value;
                                }
                            }
                            else {
                                $n = "list";
                                foreach($properties as $prop) {
                                    $name = $n.$prop->name;
                                    $prop->value = $this->$name;
                                }
                            }
                            $pub->Save();
                        }
                        
                        $ret .= $this->CloseMe();
                        break;
                    case "add":
                        $sf_id = $this->sf_id;
                        $storage_id = $this->storage_id;
                        if(is_empty($storage_id) || is_empty($sf_id)) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_storage, $this->lang->error_message_box_title);
                        }
                        else {
                            $form = $this->post_vars("template_operation_id");
                            if($form->count() > 1) {
                                $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                            }   
                            else {                         
                                $link = "";
                                if($form->count() > 0)
                                    $link = $form->Item(0);
                                else if($this->link_id)
                                    $link = $this->link_id;
                                    
                                    
                                $f = Site::Fetch($sf_id);
                                $storage = new Storage($storage_id);
                                
                                $ret .= $this->SetPostVar("cmd", "add");
                                $ret .= $this->SetPostVar("sf_id", $sf_id);
                                $ret .= $this->SetPostVar("link_id", $link);
                                $ret .= $this->SetPostVar("storage_id", $storage_id);
                                
                                $this->Out("subtitle", $this->lang->development_structure_adddata, OUT_AFTER);
                                
                                if($core->security->CheckBatch($f->createSecurityBathHierarchy("publications.add")) &&
                                    $core->security->CheckBatch($storage->createSecurityBathHierarchy("data.add")))
                                    $ret .= $this->RenderDataEditForm($storage, null);
                                else
                                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            }
                        }
                        break;
                    case "edit":
                        $form = $this->post_vars("template_operation_id");
                        if($form->count() > 1) {
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        }
                        else {
                            if($this->link_id != "")
                                $link = $this->link_id;
                            else
                                $link = $form->item(0);

                            if(is_null($link))
                                $ret .= $this->ErrorMessage($this->lang->error_select_data_edit, $this->lang->error_message_box_title);
                            else {
                                $p = new Publication($link, null);
                                if(is_null($p->datarow)) {
                                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_supported, $this->lang->error_message_box_title);
                                    break;
                                }
                                
                                $ret .= $this->SetPostVar("cmd", "data");
                                $ret .= $this->SetPostVar("sf_id", $this->sf_id);
                                $ret .= $this->SetPostVar("link_id", $link);
                                $ret .= $this->SetPostVar("storage_id", $p->datarow->storage->id);
                                
                                $this->Out("subtitle", $this->lang->development_structure_editdata." unique: ".$p->id, OUT_AFTER);
                                
                                $f = Site::Fetch($this->sf_id);
                                
                                if($core->security->CheckBatch($p->datarow->storage->createSecurityBathHierarchy("data.edit")) && 
                                    $core->security->CheckBatch($f->createSecurityBathHierarchy("publications.edit")))
                                    $ret .= $this->RenderDataEditForm($p->datarow->storage, $p->datarow->id);
                                else
                                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            }
                        }
                        break;
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    }
                break;
            case "storagedata":
                switch($this->command) {
                    case "add":
                    case "edit":
                        $storages = new storages();
                        //$storage = $storages->get_storage($this->storage_id);
                        
                        $storage = new storage($this->storage_id);
                        $form = $this->post_vars("template_operation_id");
                        if($form->count() > 1) {
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        }
                        else {
                        
                            if($this->command == "add") {
                                if($form->count() == 0)
                                    $this->Out("subtitle", $this->lang->development_structure_adddata." ".$storage->name, OUT_AFTER);
                                else
                                    $this->Out("subtitle", $this->lang->development_structure_adddubdata." ".$storage->name, OUT_AFTER);
                            }
                            else {
                                if($this->link_id != "")
                                    $link = $this->link_id;
                                else
                                    $link = $form->item(0);
                                
                                $p = new DataRow($storage, $link);
                                $this->Out("subtitle", $this->lang->development_structure_editdata." ".$storage->name.", unique: ".$p->id, OUT_AFTER);
                            }
                            
                            $ret .= $this->SetPostVar("cmd", "storagedata");
                            $ret .= $this->SetPostVar("pub_id", $this->pub_id);
                            $ret .= $this->SetPostVar("sf_id", $this->sf_id);
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            
                            if($core->security->CheckBatch($storage->createSecurityBathHierarchy("data.".$this->command)))
                                $ret .= $this->RenderDataEditForm($storage, $form->item(0));
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                }
                break;
            case "storages": 
                
                switch($this->command) {
                    case "set_permissions": 
                        $ret .= $this->EditStoragePermissions();
                        break;
                    case "save_permissions":
                    
                        $storage = new Storage($this->permissions_item);
                        
                        $storage->securitycache->Clear();
                        $permissions = new Collection();
                        $permissions->FromString($this->permissions);
                        foreach($permissions as $operation => $perm) {
                            $name = explode(".", $operation);
                            $name = $name[0];
                            $operation = substr($operation, strlen($name)+1);
                            if(!$storage->securitycache->Exists($name))
                                $storage->securitycache->Add($name, new ArrayList());
                            $storage->securitycache->$name->Add(new RoleOperation($operation, $perm));
                        }
                        $storage->Save();
//                        $storages->set_storage($storage);
                        
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        
                        break;
                    case "add":
                    case "edit":
                    
                        $this->Out("subtitle", $this->lang->development_storages_addeditstorage, OUT_AFTER);
                        $form = $this->post_vars("storages_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else {
                            if($form->count() > 0 && $this->command == 'edit')
                                $storage = new Storage($form->item(0));
                            else
                                $storage = null;
                            $ballow = false;
                            if(is_null($storage))
                                $ballow = $core->security->Check(null, "storages.add");
                            else    
                                $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("edit"));

                            if($ballow)
                                $ret .= $this->RenderStorageForm($storage);
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "copy":
                        $this->Out("subtitle", $this->lang->development_storages_copystorage, OUT_AFTER);
                        $form = $this->post_vars("storages_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else if($form->count() == 0)
                            $ret .= $this->ErrorMessage($this->lang->error_select_storage, $this->lang->error_message_box_title);
                        else {
                            $storage = new Storage($form->item(0));
                            $ballow = $core->security->Check(null, "storages.add");
                            if($ballow)
                                $ret .= $this->RenderStorageCopyForm($storage);
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "docopy":
                        $storage = new Storage($this->storage_id);
                        $s = $storage->Copy($this->table, (bool)$this->fields, (bool)$this->templates, (bool)$this->data);
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                    case "save":
                        $storage = null;
                        if($this->storage_id != "")
                            $storage = new Storage($this->storage_id);
                        
                        $ballow = false;
                        if($this->storage_id == "")
                            $ballow = $core->security->Check(null, "storages.add");
                        else    
                            $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("edit"));

                        if($ballow) {
                            if(is_empty($storage)) {
                                $storage = new storage();
                                $storage->name = $this->name;
                                $storage->table = $this->table;
                                $storage->color = $this->color;
                                $storage->istree = $this->istree;
                                //$storage->parent = $this->parent;
                                $storage->group = $this->group;
                                $storage->Save();
                            }
                            else {
                                $storage->name = $this->name;
                                $storage->color = $this->color;
                                //$storage->istree = $this->istree;
                                //$storage->parent = $this->parent;
                                $storage->group = $this->group;
                                $storage->Save();
                            }
                            
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                         }
                         else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                         }
                        break;
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;

                    /*field editor*/
                    case "addfield":
                    case "editfield":
                        $form = $this->post_vars("storage_fields_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else {
                            $storage = new Storage($this->storage_id);
                            
                            $field = null;
                            if($this->command == 'editfield')
                                $field = $form->item(0);

                            if(is_null($field))
                                $this->Out("subtitle", $this->lang->development_storages_addfield." [".$storage->name."]", OUT_AFTER);
                            else
                                $this->Out("subtitle", $this->lang->development_storages_editfield." [".$storage->name."].[".$storage->fields->$field->name."]", OUT_AFTER);

                            $ballow = false;
                            if(is_null($field))
                                $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("fields.add"));
                            else    
                                $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("fields.edit"));                            
                            
                            if($ballow)
                                $ret .= $this->RenderFieldForm($storage, $storage->fields->$field);
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "savefield":

                        $storage = new Storage($this->storage_id);
                        $field = $this->storage_field;
                        
                        $ballow = false;
                        if(is_empty($field))
                            $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("fields.add"));
                        else    
                            $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("fields.edit"));                            
                        
                        if(!$ballow) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        if (is_empty($this->lookup_table) && is_empty($this->lookup_qfields) && is_empty($this->lookup_idfield)
                            && is_empty($this->lookup_sfields) && is_empty($this->lookup_cond) && is_empty($this->lookup_query))
                            $lookup = "";
                        else {
                            $lookup = array();
                            $lookup[] = trim($this->lookup_table);
                            $lookup[] = trim($this->lookup_qfields);
                            $lookup[] = trim($this->lookup_idfield);
                            $lookup[] = trim($this->lookup_sfields);
                            $lookup[] = trim($this->lookup_cond);
                            $lookup[] = trim($this->lookup_order);
                            $lookup[] = trim($this->lookup_query);
                            $lookup = implode(":", $lookup);
                        }
                        
                        if(is_empty($field)) {
                            $field = $storage->fields->NewField();
                        }
                        else {
                            $field = $storage->fields->$field;
                        }
                        
                        $field->name = $this->storage_field_name;
                        $field->group = $this->storage_field_group;
                        $field->type = $this->storage_field_type;
                        $field->default = $this->storage_field_default;
                        $field->field = $this->storage_field_field;
                        $field->required = is_empty($this->storage_field_required) ? 0 : $this->storage_field_required;
                        $field->showintemplate = is_empty($this->storage_field_showintemplate) ? 0 : $this->storage_field_showintemplate;
                        $field->lookup = $lookup;
                        $field->onetomany = $this->storage_field_onetomany;
                        $field->values = $this->storage_field_values;
                        $field->comment = $this->storage_field_comment;

                        $field->Save();
                            
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                    case "addtemplate":
                    case "edittemplate":
                    
                        $type = ($this->template_type == "module") ? TEMPLATE_MODULE : TEMPLATE_STORAGE;
                        $ret .= $this->SetPostVar('template_type', $type);

                        $idname = $type."_id";
                        $storage = ($this->template_type == "module") ? $core->mm->modules->search($this->$idname, "id") : new Storage($this->$idname);
                        $form = $this->post_vars($type."_template_id_");

                        $name = ($this->template_type) ? "title" : "name";
                        if($form->count() == 0)
                            $this->Out("subtitle", $this->lang->development_storages_addtemplate.$storage->$name, OUT_AFTER);
                        else
                            $this->Out("subtitle", $this->lang->development_storages_edittemplate." [".$storage->$name."].[".$form->item(0)."]", OUT_AFTER);
                        
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, "Request errpor");
                        else {   
                            if($type == "storage") {
                                $ballow = false;
                                if(is_null($form->item(0)))
                                    $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("templates.add"));
                                else    
                                    $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("templates.edit"));
                            }
                            else {
                                $ballow = true;
                            }                
                                    
                            if(!$ballow) {
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                break;
                            }

                            $ret .= $this->RenderTemplateForm($storage, $this->command == 'edittemplate' ? $form->item(0) : '');
                        }
                        
                        break;
                    case "applytemplates":
                    case "savetemplates":
                        $type = ($this->template_type == "module") ? TEMPLATE_MODULE : TEMPLATE_STORAGE;
                        $storage = ($this->template_type == "module") ? new CModule($this->module_id) : new Storage($this->storage_id);
                        
                        if($type == "storage") {
                            $ballow = false;
                            if($this->template_id == "")
                                $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("templates.add"));
                            else    
                                $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("templates.edit"));
                        }
                        else {
                            $ballow = true;
                        }        
                        
                        if(!$ballow){
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        $ret .= $this->SetPostVar('template_type', $type);

                        $id = $type."_id";
                        $name = $type."_templates_name";
                        $description = $type."_templates_description";
                        $list = $type."_templates_list";
                        $styles = $type."_templates_styles";
                        $properties = $type."_templates_properties";
                        $composite = $type."_templates_composite";
                        $cache = $type."_templates_cache";
                        $cachecheck = $type."_templates_cachecheck";
                        $idname = $type."_templates_id";
                        $idname1 = $type."_templates_".$type."_id";
                        
                        if($this->template_id != "") {
                            $t = template::create($this->template_id, $storage);
                        }
                        else {
                            $t = new template(null, $type, $storage);
                        }
                        
                        $t->name = $this->$name;
                        $t->description = $this->$description;
                        $t->list = html_entity_decode($this->$list, HTML_ENTITIES, "utf-8");
                        $t->properties = $this->$properties;
                        $t->styles = $this->$styles;
                        $t->composite = ($this->$composite ? 1 : 0);
                        $t->cache = ($this->$cache ? 1 : 0);
                        $t->cachecheck = $this->$cachecheck;
                        $t->save();

                        $ret .= $this->ReloadOwner();
                        if($this->command != "applytemplates")
                            $ret .= $this->CloseMe();
                        else  {
                            $ret .= $this->SetPostVar($id, $this->$id);
                            $ret .= $this->SetPostVar($type."_template_id_".$this->$name, $this->$name);
                            $ret .= $this->DoPostBack("edittemplate", "post");
                        }
                        break;
                    case "adddata":
                    case "editdata":
                        $storage = new Storage($this->storage_id);
                        $form = $this->post_vars("template_operation_id");
                        if($form->count() > 1) {
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        }
                        else {
                            
                            // if the storage is a tree we must get the parent id
                            $parentid = '';
                            
                            $dataid = '';
                            if($this->command == 'editdata') {
                                $dataid = $form->item(0);
                                if($this->data_id != "")
                                    $dataid = $this->data_id;
                            }
                            else {
                                $parentid = $form->item(0);
                                if($this->parent_id)
                                    $parentid = $this->parent_id;
                            }
                                
                            $ret .= $this->SetPostVar("cmd", "actualdata");
                            $ret .= $this->SetPostVar("mode_command", $this->command);
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            
                            $this->Out("subtitle", $this->lang->development_storages_addeditdata.$storage->name, OUT_AFTER);
                            
                            $ballow = false;
                            if($dataid != "")
                                $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("data.add"));
                            else    
                                $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("data.edit"));
                            
                            if($ballow)
                                $ret .= $this->RenderDataEditForm($storage, $dataid, $parentid);
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            
                        }
                        break;
                    case "movetodata":
                        $storage = new Storage($this->storage_id);
                        $form = $this->post_vars("template_operation_id");
                        if($form->count() == 0) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_data_move, $this->lang->error_message_box_title);
                        }
                        else {
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            foreach($form as $item)
                                $ret .= $this->SetPostVar("template_operation_id_".$item, $item);
                            $ret .= $this->RenderMoveToDataForm();    
                        }
                        break;
                    case "domovetodata":
                        $storage = new Storage($this->storage_id);
                        $dtMove = new DataNode($storage, $this->data_node);
                        
                        $form = $this->post_vars("template_operation_id");
                        foreach($form as $item) {
                            if($dtMove->id != $item) {
                                $dt = new DataNode($storage, $item);
                                $dt->MoveTo($dtMove);
                            }
                        }
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        
                        break;    
                    case "copydata":
                        $storage = new Storage($this->storage_id);
                        $form = $this->post_vars("template_operation_id");
                        if($form->count() == 0) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_data_copy, $this->lang->error_message_box_title);
                        }
                        else {
                            $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("data.add"));
                            if($ballow) {
                                $ret .= $this->SetPostVar("storage_id", $storage->id);
                                foreach($form as $item)
                                    $ret .= $this->SetPostVar("template_operation_id_".$item, $item);
                                $ret .= $this->RenderCopyForm();
                            }
                        }                        
                        break;
                    case "docopydata":
                        
                        $storage = new Storage($this->storage_id);
                        $form = $this->post_vars("template_operation_id");

                        $ballow = $core->security->CheckBatch($storage->createSecurityBathHierarchy("data.add"));
                        if($ballow) {
                            foreach($form as $item) {
                                if(!$this->CopyItem($storage, $item, $this->copies))
                                    return $this->ErrorMessage($this->lang->error_cannotcopy, $this->lang->error_message_box_title);
                            }
                        }
                        
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();

                        break;
                    
                }
                break;
            case "files" : {
            
                switch($this->command) {
                    case "close":
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();                        
                        break;
                    case "uploadfile":
                        $ret .= $this->SetPostVar("folder_id_", $this->folder_id_);

                        $ret .= $this->RenderFilesBatchAddForm();
                        break;
                    case "saveajaxfile":
                        $folder_id = $this->folder_id_;
                        
                        $ff = "Filedata";
                        $f = $core->rq->$ff;

                        if($f->isValid) {
                            $fname = $f->name;
                            if($core->fs->FileExists($folder_id.'/'.$fname)) {
                                $afname = split_fname($fname);
                                $fname = $afname[1].'_'.str_random(5).'.'.$afname[2];
                            }           
                            $f->MoveTo($folder_id.'/'.$fname);
                        }  
                        exit(0);
                        break; 
                    case "saveuploadedfile":
                        $ret .= $this->SetPostVar("folder_id_", $this->folder_id_);
                        
                        $folder_id = $this->folder_id_;
                        $filescount = $core->rq->filescount;
                        for($i=1; $i<=$filescount; $i++) {
                            
                            $ff = "file".$i;
                            $f = $core->rq->$ff;                              
                            if($f->isValid) {
                                $fname = $f->name;
                                if($core->fs->FileExists($folder_id.'/'.$fname)) {
                                    $afname = split_fname($fname);
                                    $fname = $afname[1].'_'.str_random(5).'.'.$afname[2];
                                }           
                                $f->MoveTo($folder_id.'/'.$fname);
                            }
                            
                        }
                        
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        
                        break;
                    case 'addfolder':
                        $form = $this->post_vars("folder_id_");
                        $ret .= $this->SetPostVar("folder_id_", $form->Item(0));
                        $ret .= $this->RenderFilesFolderAddForm();
                        break;
                    case 'savefolder':
                        $ret .= $this->SetPostVar("folder_id_", $this->folder_id_);
                        $parentfolder = $this->folder_id_;
                        if(is_empty($parentfolder))
                            $parentfolder = '/resources';
                        $folder = $this->foldername;
                        $path = $parentfolder.'/'.$folder;
                        if($core->fs->CreateDir($path) === false) 
                            $ret .= $this->ErrorMessage($this->lang->error_cannotcreatefolder, $this->lang->error_message_box_title);
                        else {
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        break;
                }
                
                    
                break;
            }
            case "blobs": {
            	
                switch($this->command) {
                    
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    case "add":
                        $form = $this->post_vars("category_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else {
                            if($this->bc_id != "")
                                $bc = $this->bc_id;
                            else
                                $bc = $form->item(0);

                            $ret .= $this->SetPostVar("bc_id", $bc);
                            $ret .= $this->SetPostVar("mode", "add");
                            
                            $bcc = new BlobCategories();
                            $parent = new BlobCategory(is_empty($bc) ? null: intval($bc));
                            if($core->security->CheckBatch($bcc->createSecurityBathHierarchy("add")))
                                $ret .= $this->RenderCategoryAddEditForm($parent->id, null);
                            else
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "edit":
                        $form = $this->post_vars("category_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else {

                            if($this->bc_id != "")
                                $bc = $this->bc_id;
                            else
                                $bc = $form->item(0);

                            if(is_null($bc)) {
                                $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                            }
                            else {
                                $category = new BlobCategory(intval($bc));
                                $ret .= $this->SetPostVar("bc_id", $bc);
                                $ret .= $this->SetPostVar("mode", "edit");
                                if($core->security->CheckBatch($category->createSecurityBathHierarchy("edit")))
                                    $ret .= $this->RenderCategoryAddEditForm($category->parent, $category->id);
                                else
                                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            }

                        }
                        break;
                    case "savecategory":

                        if($this->mode == "add") {
                            $pid = $this->bc_id;
                            if(is_null($pid) || $pid == "")
                                $pid = -1;

                            $bcc = new BlobCategory(null);
                            if(!$core->security->CheckBatch($bcc->createSecurityBathHierarchy("add"))) {
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                break;
                            }

                            $bcc->description = $this->name;
                            $bcc->parent = $pid;
                            $bcc->Save();
                            // $newid = $core->bm->save_category(-1, $this->name, $pid);
                            
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        else if($this->mode == "edit") {
                            $bid = $this->bc_id;
                            $category = new BlobCategory(intval($bid));
                            if(!$core->security->CheckBatch($category->createSecurityBathHierarchy("edit"))) {
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                break;
                            }
                            
                            $category->description = $this->name;
                            $category->Save();
                            //$bid = $core->bm->save_category($bid, $this->name, $category->parent);
                            
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_unknown, $this->lang->error_message_box_title);
                        }
                        break;
                    case "moveresource":

                        $form = $this->post_vars("blob_id_");
                        foreach($form as $key => $item) {
                            $ret .= $this->SetPostVar($key, $item);                            
                        }
                        $ret .= $this->SetPostVar("bc_id", $this->bc_id);

                        $bc = $this->bc_id < 0 ? new BlobCategories() : new BlobCategory(intval($this->bc_id));
                        //$bc = $core->bm->Category($this->bc_id);
                        if(!$core->security->CheckBatch($bc->createSecurityBathHierarchy("items.delete"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }


                        $ret .= $this->RenderMoveBlobForm($this->bc_id);
                    
                        break;
                    case "moveresourcecomplete":
                    
                        $bc = intval($this->bc_id) == -1 ? new BlobCategory() : new BlobCategory(intval($this->bc_id));
                        $moveto = intval($this->moveto) == -1 ? new BlobCategory() : new BlobCategory(intval($this->moveto));
                        if(!$core->security->CheckBatch($bc->createSecurityBathHierarchy("items.delete")) ||
                            !$core->security->CheckBatch($moveto->createSecurityBathHierarchy("items.add"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                    
                        $form = $this->post_vars("blob_id_");
                        foreach($form as $item) {
                            $b = new Blob(intval($item));
                            $b->parent = intval($this->moveto);
                            $b->Save();
                        }
                        
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                    case "addresource":
                        $ret .= $this->SetPostVar("bc_id", $this->bc_id);

                        if(intval($this->bc_id) != -1)
                            $bc = new BlobCategory(intval($this->bc_id));
                        else
                            $bc = new BlobCategories();

                        if(!$core->security->CheckBatch($bc->createSecurityBathHierarchy("items.add"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }

                        $ret .= $this->RenderBlobsBatchAddForm();
                        break;
                    case "editresource":
                        $form = $this->post_vars("blob_id_");
                        if($form->count() == 0)
                            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                        else if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                        else {
                            $ret .= $this->SetPostVar("bc_id", $this->bc_id);
                            $ret .= $this->SetPostVar("blob_id", $form->item(0));
                            
                            if(intval($this->bc_id) != -1)
                                $bc = new BlobCategory(intval($this->bc_id));
                            else
                                $bc = new BlobCategories();
                            if(!$core->security->CheckBatch($bc->createSecurityBathHierarchy("items.edit"))) {
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                break;
                            }
                            
                            $ret .= $this->RenderBlobsBatchEditForm($form->item(0));
                        }                        
                        
                        break;
                    case "saveaddresources":
                        $bc_id = $this->bc_id;
                        if(intval($this->bc_id) != -1)
                            $bc = new BlobCategory(intval($this->bc_id));
                        else
                            $bc = new BlobCategories();
                        if(!$core->security->CheckBatch($bc->createSecurityBathHierarchy("items.add"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        $blobscount = $core->rq->blobscount;
                        for($i=1; $i<=$blobscount; $i++) {
                            
                            $alt = "alt".$i;
                            $alt = $core->rq->$alt;
                            $ff = "file".$i;
                            $f = $core->rq->$ff;
                            $url = "url".$i;
                            $fUrl = $core->rq->$url;
                            $bBlob = null;
                            
                            if($f->error == 0) {
                                $bBlob = $f->binary();
                                $strPath = $f->name;
                                $blobs_type = $f->ext;
                            }
                            else if(!is_null($fUrl)) {
                                $bBlob = BlobData::Download($fUrl);

                                $fname = basename($fUrl);
                                $strPath = $fname;
                                $af = preg_split("/\./", $fname);
                                $blobs_type = @$af[1];
                            }                    
                             
                            if($bBlob) {
                                $b = new Blob();
                                $b->filename = $strPath;
                                $b->type = $blobs_type;
                                $b->alt = $alt;
                                $b->parent = $bc instanceof BlobCategory ? $bc->id : -1;
                                $b->data->data = $bBlob;
                                $b->Save();
                            }    
                            else {
                                
                                $ret .= $this->lang->error_file_to_big;
                                
                            }
                            
                            
                            
                        }

                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        
                        break;
                    case "saveeditresource":
                        
                        $bc_id = $this->bc_id;
                        $blob_id = $this->blob_id;

                        if(intval($this->bc_id) != -1)
                            $bc = new BlobCategory(intval($this->bc_id));
                        else
                            $bc = new BlobCategories();
                        if(!$core->security->CheckBatch($bc->createSecurityBathHierarchy("items.edit"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        $b = new Blob(intval($blob_id));
                        $b->alt = $core->rq->alt;
                        
                        $fUrl = $core->rq->url;
                        $f = $core->rq->file;
                        if($f->error == 0 || !is_empty($fUrl)) {
                            if($f->error == 0) {
                                $b->data->data = $f->binary();
                                $b->filename = $f->name;
                                $b->type = $f->ext;
                            }
                            else {
                                $bBlob = BlobData::Download($fUrl);
                                $fname = basename($fUrl);
                                $af = preg_split("/\./", $fname);
                                $b->data->data = BlobData::Download($fUrl);
                                $b->filename = $fname;
                                $b->type = @$af[1];
                            }                      
                        }
                        $b->ClearCache();
                        $b->Save();
                        
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();                    
                        
                        break;
                }
                break;
            }
            case "modules":
                $id = $this->post_vars("module_id_");
                $title = "";
                if ($id->Count() > 0){
                    $m = new CModule($id->item(0));
                    $title = " \"".$m->title."\"";
                }
                
                switch($this->command) {
                    case "import" :
                        $this->Out("subtitle", $this->lang->toolbar_modules_import.$title, OUT_AFTER);
                        $ret .= $this->RenderImportModule();
                        break;
                    case "export" :
                        $this->Out("subtitle", $this->lang->toolbar_modules_export.$title, OUT_AFTER);
                        $ret .= $this->RenderExportModule();
                        break;
                    case "edit" :
                        $this->Out("subtitle", $this->lang->modules_edit.$title, OUT_AFTER);
                        $ret .= $this->RenderEditModule();
                        break;
                    case "add" :
                        $this->Out("subtitle", $this->lang->modules_add, OUT_AFTER);
                        $ret .= $this->RenderEditModule(true);
                        break;
                    case "ok" :
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                    case "message_cancel" :
                    case "message_ok" :
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    }
                break;
            case "users":
                switch($this->command) {
                    case "message_cancel":
                    case "message_ok":
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                    case "edit":
                    case "add":
                        if($this->command == "add")
                            $this->Out("subtitle", $this->lang->tools_usermanager_users_edit, OUT_AFTER);
                        else
                            $this->Out("subtitle", $this->lang->tools_usermanager_users_add, OUT_AFTER);
                        $ret .= $this->RenderUserEditForm();
                        break;
                    case "save":
                        $uname = $this->user_name;
                        
                        $ballow = false;
                        if($this->mode == "add")
                            $ballow = $core->security->Check(null, "usermanagement.users.add");
                        else
                            $ballow = $core->security->Check(null, "usermanagement.users.edit");
                        
                        if(!$ballow){
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        if($this->mode = "add") {
                            $user = new User();
                            $user->name = $this->login;
                        }
                        else
                            $user = User::Load($uname);
                        $user->password = $this->password;
                        $user->groups->Clear();
                        $user->groups->FromString($this->groups);
                        $user->roles->FromString($this->roles);
                        $user->Save();
                        
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                    
                    case "group_add":
                    case "group_edit":
                        $ret .= $this->RenderGroupEditForm();
                        break;
                    case "group_save":
                    
                        $gname = $this->group_name;
                        
                        $ballow = false;
                        if($this->mode == "add")
                            $ballow = $core->security->Check(null, "usermanagement.groups.add");
                        else
                            $ballow = $core->security->Check(null, "usermanagement.groups.edit");
                        
                        if(!$ballow){
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        if($this->mode = "add") {
                            $group = new Group();
                            $group->name = $this->name;
                        }
                        else 
                            $group = Group::Load($gname);
                    
                        $group->description = $this->description;
                        $group->users->Clear();
                        $group->users->FromString($this->users);
                        $group->Save();
                                  
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;

                    case "role_add":
                    case "role_edit":
                        $ret .= $this->RenderRoleEditForm();
                        break;
                    case "role_save":
                        global $core;
                        
                        $ballow = false;
                        if($this->mode == "add")
                            $ballow = $core->security->Check(null, "usermanagement.roles.add");
                        else
                            $ballow = $core->security->Check(null, "usermanagement.roles.edit");
                        
                        if(!$ballow){
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            break;
                        }
                        
                        $rname = $this->role_name;
                        
                        if($this->mode = "add") {
                            $role = new Role($this->name);
                        }
                        else 
                            $role = $core->security->systemInfo->roles->$rname;
                    
                        $role->description = $this->description;
                        $role->Clear();

                        $role->FromString($this->operations);
                        
                        if($this->mode = "add")
                            $core->security->systemInfo->roles->Add($role);
                        $core->security->systemInfo->Store();

                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                        break;
                    
                }
                
                break;
        }
        return $ret;
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

    function RenderDataEditForm($storage, $dataid, $parentid = null) {
        global $core;
        $ret = "";
        
        $class = $storage->istree ? 'DataNodes' : 'DataRows';
        $data = new $class($storage);
        
        if($dataid != 0 && !is_null($dataid))
            $data->Load("", $storage->fname("id")."=".$dataid, "");
        else
            $data->LoadDefaults();
        
        if($dataid == 0) {
            $dataid = $this->data_id;
            if(is_null($dataid))
                $dataid = 0;
        }
        
        $ret .= $this->SetPostVar("sf_id", $this->sf_id);
        $ret .= $this->SetPostVar("data_id", $dataid);
        $ret .= $this->SetPostVar("parent_id", $parentid);
        $ret .= $this->SetPostVar("storage_id", is_empty($this->storage_id) ? $storage->id : $this->storage_id);
        
        if($this->page)
            $ret .= $this->SetPostVar("page", $this->page);
        
        //temp
        $storages = new storages();
        $dd = $data->FetchNext();
        
        $editor = new Editor($dd, $this, "f1");
        $editor->blob_operations = array("handlerObject" => $this, "function" => "getBlobOperations");
        $editor->texts = array(
            "save" => $this->lang->save,
            "cancel" => $this->lang->cancel,
            "apply" => $this->lang->apply,
            "subtable" => $this->lang->edit_subtable,
            "remove" => $this->lang->remove,
            "em_multipleedit" => $this->lang->error_multiple_select_not_allowed,
            "em_noselection" => $this->lang->error_select_item
        );
        
        if($editor->action == EDITOR_ACTION_SAVE || $editor->action == EDITOR_ACTION_APPLY) {
            $editor->Validate();
            if($editor->state == EDITOR_ERROR) {
                $ret .= $editor->Render();
            }
            else {
                // save
                $storage = new Storage($this->storage_id);
                
                if(!$storage->istree)
                    $dt = new DataRow($storage, $this->data_id ? $this->data_id : null);
                else
                    $dt = new DataNode($storage, $this->data_id ? $this->data_id : null);
                
                $dt->Fill($editor->get_request());
                
                $dt->id = $this->data_id;
                
                if(!$storage->istree)
                    $dt->Save();
                else
                    $dt->Save($parentid);
                
                if($editor->action == EDITOR_ACTION_SAVE) {
                    if($this->action == "publicationdata") {
                        if($this->cmd == "data") {
                            
                            if(Publications::Exists($this->link_id)) {
                                $p = new Publication($this->link_id);
                                $p->Save();
                            }
                                                        
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        else if($this->cmd == "add") {
                            
                            $parent = is_empty($this->link_id) ? Site::Fetch($this->sf_id) : new Publication($this->link_id);
                            $pubs = $parent->Publications();
                            $pubs->Add($dt, $parent);
                            
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                        else {
                            $ret .= $this->ReloadOwner();
                            $ret .= $this->CloseMe();
                        }
                    }
                    else if($this->action == "storagedata" || $this->action == "storages"){
                        $ret .= $this->ReloadOwner();
                        $ret .= $this->CloseMe();
                    }
                }
                else if($editor->action == EDITOR_ACTION_APPLY) {
                    if($this->action == "publicationdata") {
                        if($this->cmd == "add") { 
                            $parent = is_empty($this->link_id) ? Site::Fetch($this->sf_id) : new Publication($this->link_id);
                            $pubs = $parent->Publications();
                            $pubs->Add($dt, $parent);
                        }
                    }
                    $ret .= $editor->Render();
                    $ret .= $this->ReloadOwner();
                }
                else {
                    $ret .= $editor->Render();
                }
                    
            }
        }
        else if($editor->action == EDITOR_ACTION_CANCEL) {
            $ret .= $this->CloseMe();
        }
        else {
            $ret .= $editor->Render();
        }
        
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $this->Out("toolbar_bottom", $editor->RenderCommandBar());
        $this->Out("editor_bar", $editor->RenderEditorBar());
        // exit;
        
        return $ret;
    }
    
    function RenderStorageCopyForm($storage) {
        global $core;
        $ret = "";
        
        $ret .= $this->SetPostVar('storage_id', $storage->id);

        $ret .= $this->RenderFormHeader();
        $ret .= $this->RenderFormRow($this->lang->development_storage_table_new, "table", $storage->table."_copy", true, null, "text", false, "", "width:50%");
        $ret .= $this->RenderFormRow($this->lang->development_storage_copy_fields, "fields", true, true, null, "check", false, "", "width:50%");
        $ret .= $this->RenderFormRow($this->lang->development_storage_copy_templates, "templates", false, true, null, "check", false, "", "width:50%");
        $ret .= $this->RenderFormRow($this->lang->development_storage_copy_data, "data", false, true, null, "check", false, "", "width:50%");
        $ret .= $this->RenderFormFooter();

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("docopy", "submit", $this->lang->save, "docopy"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);

        return $ret;
    }
    
    function RenderStorageForm($storage) {
        global $core;
        $ret = "";
        
        if(is_null($storage))
            $storage = new collection();
        
        $disabled = get_class($storage) <> "Collection" ? "disabled" : "";
        $ret .= $this->SetPostVar('storage_id', $storage->id);

        $colors = Storage::Colors();
        
        /*$strgs = Storages::Enum();
        $strgs->Delete($storage->table);*/
        
        /*$storages = array();
        $storages[''] = '';
        foreach($strgs as $st) {
            $storages[$st->name] = $st->table;
        }*/

        $ret .= $this->RenderFormHeader();
        $ret .= $this->RenderFormRow($this->lang->development_storage_group, "group", $storage->group, true, null, "text", false, "", "width:50%");    
        $ret .= $this->RenderFormRow($this->lang->development_storage_description, "name", $storage->name, true, null, "text");    
        $ret .= $this->RenderFormRow($this->lang->development_storage_table, "table", $storage->table, true, null, "text", false, "", "width:50%");    
        //$ret .= $this->RenderFormRow($this->lang->development_storage_color, "color", array($colors, $storage->color), true, null, "combo", false, "", "width:50%");    
        $ret .= $this->RenderFormRow($this->lang->development_storage_color, "color", $storage->color, true, null, "text", false, "", "width:50%");    
        $ret .= $this->RenderFormRow($this->lang->development_storage_istree, "istree", $storage->istree, true, null, "check", false, "", "width:50%");    
        $ret .= $this->RenderFormFooter();

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);

        return $ret;
    }

    function RenderFieldForm($storage, $field) {
        global $core;
        $ret = "";

        if(is_null($field))
            $field = new collection();

        $disabled = iif(!is_null($field), "-disabled", "");
        $required = iif($field->required==1, "checked", "");
        $viewintemplate = iif($field->showintemplate==1, "checked", "");

        // $field->storage_field_onetomany
        $storages = new storages();
        $s = $storages->enum();
        $ss = new Collection();
        $ss->Add("", "");
        foreach($s as $st) {
            //if($st->table != $storage->table)
                $ss->Add($st->table, $st->table); //$st->name
        }
        
        $tt = $core->dbe->SystemTypes();
        $t = new Collection();
        foreach($tt as $key => $value) {
            $t->Add($value, $key);
        }
        
        $lookup = new Lookup();
        if($field instanceOf Field)
            $lookup = $field->SplitLookup();

        
        /*$lookup = explode(":", $field->storage_field_lookup);
        $lookup_table = trim(@$lookup[0]);
        $lookup_qfields = trim(@$lookup[1]);
        $lookup_idfield = trim(@$lookup[2]);
        $lookup_sfields = trim(@$lookup[3]);
        $lookup_cond = trim(@$lookup[4]);
        $lookup_query = trim(@$lookup[5]);*/

        
        $ret .= $this->SetPostVar('storage_id', $storage->id);
        $ret .= $this->SetPostVar('storage_field', $field->storage_field_field);
        $ret .= $this->SetPostVar('storage_fields_id_'.$field->storage_field_field,$field->storage_field_field);
        
        $ret .= $this->RenderFormHeader();
        
        $ret .= $this->RenderFormRow($this->lang->development_field_description, "storage_field_name", $field->storage_field_name, true, null, "text", false, "", "width: 80%;");
            $ret .= $this->RenderFormRow($this->lang->development_field_description_desc, "storage_field_field", $field->storage_field_field, true, (!($field instanceof Collection) ? Hashtable::Create("readonly", false) : null), "text", false, "", "width: 50%;");
            $ret .= $this->RenderFormRow($this->lang->development_field_type, "storage_field_type", array($t, $field->storage_field_type), false, null, "combo", false, "selectbox", "width: 180px;");
            $ret .= $this->RenderFormRow($this->lang->development_field_default, "storage_field_default", $field->storage_field_default, true, Hashtable::Create("description", $this->lang->development_field_default_desc), "text", false, "", "width: 90%;");
            $ret .= $this->RenderFormRow($this->lang->development_field_values, "storage_field_values", $field->storage_field_values, true, Hashtable::Create("description", $this->lang->development_field_values_desc), "memo", false, "", "width: 90%;");
            $ret .= $this->RenderFormRow($this->lang->development_field_group, "storage_field_group", $field->storage_field_group, true, null, "text", false, "", "width: 50%;");
            $ret .= $this->RenderFormRow($this->lang->development_field_required, "storage_field_required", $field->storage_field_required, true, Hashtable::Create("description", $this->lang->development_field_required_desc), "check", false);        
            $ret .= $this->RenderFormRow($this->lang->development_field_viewindeftempl, "storage_field_showintemplate", $field->storage_field_showintemplate, true, Hashtable::Create("description", $this->lang->development_field_viewindeftempl_desc), "check", false);
            $ret .= $this->RenderFormRowStart();
                $ret .= $this->RenderFormTitleCell($this->lang->development_field_lookup);
                $controls  = $this->RenderFormHeader();
                $controls .= $this->RenderFormRow($this->lang->development_lookup_table, "lookup_table", @$lookup->table, false, null, "text", false, "", "width: 300px;", "150");
                $controls .= $this->RenderFormRow($this->lang->development_lookup_field_list, "lookup_qfields", @$lookup->fields, false, null, "text", false, "", "width: 300px;", "150");
                $controls .= $this->RenderFormRow($this->lang->development_lookup_field_id, "lookup_idfield", @$lookup->id, false, null, "text", false, "", "width: 300px;", "150");
                $controls .= $this->RenderFormRow($this->lang->development_lookup_field_view_list, "lookup_sfields", @$lookup->show, false, null, "text", false, "", "width: 300px;", "150");
                $controls .= $this->RenderFormRow($this->lang->development_lookup_field_cond, "lookup_cond", @$lookup->condition, false, null, "text", false, "", "width: 300px;", "150");
                $controls .= $this->RenderFormRow($this->lang->development_lookup_field_order, "lookup_order", @$lookup->order, false, null, "text", false, "", "width: 300px;", "150");
                $controls .= $this->RenderFormRow($this->lang->development_lookup_field_query, "lookup_query", @$lookup->fullquery, false, null, "text", false, "", "width: 300px;", "150");
                $controls .= $this->RenderFormFooter();
                $ret .= $this->RenderFormControlCell($controls, '', '<br /><span class="small-text">'.$this->lang->development_field_lookup_desc.'</span>');
            $ret .= $this->RenderFormRowEnd();
            $ret .= $this->RenderFormRow($this->lang->development_field_onetomany, "storage_field_onetomany", array($ss, $field->storage_field_onetomany), false, Hashtable::Create("description", $this->lang->development_field_onetomany_desc), "combo", false, "selectbox", "width: 120px;");
            $ret .= $this->RenderFormRow($this->lang->development_field_comment, "storage_field_comment", $field->storage_field_comment, true, Hashtable::Create("description", $this->lang->development_field_comment_desc), "html", false, "", "width: 90%; height: 220px;");
        $ret .= $this->RenderFormFooter();
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "savefield"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");

        return $ret;
    }

    function RenderTemplateForm($storage, $templ) { //storage|module, template name
        global $core;
        
        $ret = "";
        $type = ($this->template_type == "module") ? TEMPLATE_MODULE : TEMPLATE_STORAGE;
        $t = $storage->templates;
        if($templ != "") {
            $template = $t->Item($templ);
        }
        else
            $template = new collection();
        
        $name = $type."_templates_name";
        $description = $type."_templates_description";
        $properties = $type."_templates_properties";
        $list = $type."_templates_list";
        $styles = $type."_templates_styles";
        
        $admintemplate = ($template->name =='TEMPLATE_ADMIN' ? "checked" : "");
        $defaulttemplate = ($template->name=='TEMPLATE_DEFAULT' ? "checked" : "");
        $customtemplate = ($template->name != 'TEMPLATE_ADMIN' && $template->name !='TEMPLATE_DEFAULT' ? "checked" : "");
        $readonly = ($template->$name != 'TEMPLATE_ADMIN' && $template->name != 'TEMPLATE_DEFAULT' ? "" : "readonly");
        
        $ret .= $this->SetPostVar($type."_id", $storage->id);
        $ret .= $this->SetPostVar("template_id", $template->name);
        
        $ret .= $this->RenderFormHeader();
        
        $ret .= $this->RenderFormRowStart();
        //if($type == TEMPLATE_STORAGE)
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_composite, $type."_templates_composite", $template->composite, true, null, "check");
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_cache, $type."_templates_cache", $template->cache, true, null, "check");
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_cachecheck, $type."_templates_cachecheck", $template->cachecheck, true, null, "text");
        
        $ret .= $this->RenderFormTitleCell($this->lang->development_storages_template_type);
        $controls = '
                <table width="513"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="25" nowrap><input name="templatetype" id="templatetypeid1" type="radio" value="1" '.$admintemplate.' onclick="this.form.'.$name.'.value=\'TEMPLATE_ADMIN\'; this.form.'.$name.'.readonly=true"></td>
                    <td nowrap><label for="templatetypeid1">'.$this->lang->development_storages_template_admin.'</label</td>
                    <td width="25" nowrap><input name="templatetype" id="templatetypeid2" type="radio" value="2" '.$defaulttemplate.' onclick="this.form.'.$name.'.value=\'TEMPLATE_DEFAULT\'; this.form.'.$name.'.readonly=true"></td>
                    <td nowrap><label for="templatetypeid2">'.$this->lang->development_storages_template_default.'</label></td>
                    <td width="25" nowrap><input name="templatetype" id="templatetypeid3" type="radio" value="3" '.$customtemplate.' onclick="this.form.'.$name.'.value=\'\'; this.form.'.$name.'.readonly=false"></td>
                    <td nowrap><label for="templatetypeid3">'.$this->lang->development_storages_template_custom.'</label</td>
                </tr>
                </table>
        ';
        $ret .= $this->RenderFormControlCell($controls);
        $ret .= $this->RenderFormRowEnd();
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_name, $name, $template->name, true, ($templ != "" ? Hashtable::Create("readonly", true) : null), "text", false);
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_description, $description, $template->description, true, null, "text", false);
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_properties, $properties, $template->properties, true, null, "memo", false, "");
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_styles, $styles, $template->styles, true, Hashtable::Create("attributes", ' onkeydown="try{ return ProcessTab(event); } catch(e) {}" wrap="off"'), "memo", false, "", "width: 100%; height: 240px;");
        $ret .= $this->RenderFormRow($this->lang->development_storages_template_list, $list, htmlentities($template->list, HTML_ENTITIES, "utf-8"), true, Hashtable::Create("attributes", ' onkeydown="try{ return ProcessTab(event); } catch(e) {}" wrap="off"'), "memo", false, "", "width: 100%; height: 240px;");
        $ret .= $this->RenderFormFooter();
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "savetemplates"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Containers->Add(new CommandBarButtonContainer("apply", "submit", $this->lang->apply, "applytemplates"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;
    }
    
    function EditSite($mode) {
        global $core;
        $ret = "";
        $postdata = $this->post_vars("sites_id_");
        $ret .= $this->SetPostVar("mode", $mode);

        if($postdata->count() == 0 && is_null($this->site_id)) {
            $SiteRoot = Site::FetchRoot();
            if($core->security->Check(null, "structure.sites.add"))
                $ret .= $this->RenderSiteFolderForm(null, $mode, "site");
            else
                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
        }
        else if($postdata->count() > 1) {
            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
        }
        else {
            $item = Site::Fetch(is_null($this->site_id) ? $postdata->item(0) : $this->site_id);
            if($core->security->CheckBatch($item->createSecurityBathHierarchy($mode))) {
                $ret .= ($mode != "editproperties") ? $this->RenderSiteFolderForm($item, $mode, "folder") : $this->RenderSiteFolderPropertiesForm($item, $mode, "folder");
            }
            else
                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
        }
        
        return $ret;
    }

    function EditNoticePermissions() {
        global $core;
        $ret = "";
        
        /* form title */
        $this->Out("subtitle", $this->lang->setpermissions_title, OUT_AFTER);
        
        $postdata = $this->post_vars("notice_id_");
        if($postdata->count() == 0) {
            $ret .= $this->ErrorMessage($this->lang->error_select_notice, $this->lang->error_message_box_title);
        }
        else if($postdata->count() > 1) {
            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
        }
        else {
            $notice = Notices::Get($postdata->item(0));
            $ret .= $this->SetPostVar("permissions_item", $postdata->item(0));
            $ret .= $this->SetPermissionsForm($notice, true);
        }
        return $ret;
    }
    
    function EditSettingPermissions() {
        global $core;
        $ret = "";

        /* form title */
        $this->Out("subtitle", $this->lang->setpermissions_title, OUT_AFTER);
        
        $postdata = $this->post_vars("setting_id_");
        if($postdata->count() == 0) {
            $ret .= $this->ErrorMessage($this->lang->error_select_setting, $this->lang->error_message_box_title);
        }
        else if($postdata->count() > 1) {
            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
        }
        else {
            $setting = $core->sts->item($postdata->item(0));
            $ret .= $this->SetPostVar("permissions_item", $postdata->item(0));
            $ret .= $this->SetPermissionsForm($setting, true);
        }
        return $ret;
    }
    
    function EditStoragePermissions() {
        global $core;
        $ret = "";

        /* form title */
        $this->Out("subtitle", $this->lang->setpermissions_title, OUT_AFTER);
        
        $postdata = $this->post_vars("storages_id_");
        if($postdata->count() == 0) {
            $ret .= $this->ErrorMessage($this->lang->error_select_storage, $this->lang->error_message_box_title);
        }
        else if($postdata->count() > 1) {
            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
        }
        else {
            $storage = storages::get($postdata->item(0));
            $ret .= $this->SetPostVar("permissions_item", $postdata->item(0));
            $ret .= $this->SetPermissionsForm($storage, true);
        }
        return $ret;
    }
    
    function EditSiteFolderPermissions() {
        global $core;
        $ret = "";
        
        /* form title */
        $this->Out("subtitle", $this->lang->setpermissions_title, OUT_AFTER);
        
        $postdata = $this->post_vars("sites_id_");
        if($postdata->count() == 0) {
            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
        }
        else if($postdata->count() > 1) {
            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
        }
        else {
            $item = Site::Fetch($postdata->item(0));
            $ret .= $this->SetPostVar("permissions_item", $postdata->item(0));
            $ret .= $this->SetPermissionsForm($item, true);
        }
        return $ret;
    }

    function RenderPublicationPropertiesForm($pub) {
        $ret = '';
        
        $ret .= $this->SetPostVar('pub_id', $pub->id);
        
        $properties = $pub->properties;
        if($properties->Count() == 0) {
            $ret .= $this->lang->development_empty_propertylist;
        }
        else {
            if($properties->combined) {
                
                foreach($properties as $name => $fp) {
                    $ret .= $this->RenderFormHeader();
                    $ret .= $this->RenderFormRowStart();
                    $ret .= $this->RenderFormTitleCell("template ".$fp->name." for situation: ".$name, "200");
                    $ret .= $this->RenderFormTitleCell("&nbsp;", "70%");
                    $ret .= $this->RenderFormRowEnd();
                    foreach($fp as $prop) {
                        if($prop->type != "combo") {
                            $v = is_null($prop->value) ? $prop->defaultValue : $prop->value;
                        }
                        else {
                            $v = array($prop->set, is_null($prop->value) ? $prop->defaultValue : $prop->value); 
                        }

                        $ret .= $this->RenderFormRow($prop->description, 
                                                     $name.$prop->name, 
                                                     $v, 
                                                     false, 
                                                     null, 
                                                     $prop->type, 
                                                     false);
                    }
                    $ret .= $this->RenderFormFooter();
                }
                
            }
            else {
                $ret .= $this->RenderFormHeader();
                $name = "list";
                foreach($properties as $prop) {
                    if($prop->type != "combo") {
                        $v = is_null($prop->value) ? $prop->defaultValue : $prop->value;
                    }
                    else {
                        $v = array($prop->set, is_null($prop->value) ? $prop->defaultValue : $prop->value); 
                    }
        
                    $ret .= $this->RenderFormRow($prop->description, 
                                                 $name.$prop->name, 
                                                 $v, 
                                                 false, 
                                                 null, 
                                                 $prop->type, 
                                                 false);
                }
                $ret .= $this->RenderFormFooter();
            }
        }

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "saveproperties"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);
        

        return $ret;
    }

    function RenderSiteFolderPropertiesForm($sf, $mode) {
        $ret = '';
        
        $ret .= $this->SetPostVar('site_id', $sf->id);
        $ret .= $this->SetPostVar('mode', $mode);        
        
        $properties = $sf->properties;
        if($properties->Count() == 0) {
            $ret .= $this->lang->development_empty_propertylist;
        }
        else {
            $ret .= $this->RenderFormHeader();        
            foreach($properties as $key => $prop) {
                if($prop->type != "combo") {
                    $v = is_null($prop->value) ? $prop->defaultValue : $prop->value;
                }
                else {
                    $v = array($prop->set, is_null($prop->value) ? $prop->defaultValue : $prop->value); 
                }
    
                $ret .= $this->RenderFormRow($prop->description, 
                                             $prop->name, 
                                             $v, 
                                             false, 
                                             null, 
                                             $prop->type, 
                                             false);
            }
            $ret .= $this->RenderFormFooter();
        }
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "saveproperties"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Containers->Add(new CommandBarButtonContainer("clear", "submit", $this->lang->clear, "clearproperties"));
        $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);
        

        
        return $ret;
    }

    function RenderSiteFolderForm($sf, $mode, $what = "folder"){
        global $core;
        $ret = "";
        $parent = null;
        
        if($mode == "add" && is_null($sf)) {
            $b = true;
            $sf = new collection();
            $sf->tree_properties = "";
        }
        else if($mode == "add" && !is_null($sf)){
            $b = false;
            $parent = $sf;
            $sf = new collection();
            $sf->tree_properties = "[inherit]";            
        }
        else if($mode == "edit" && is_null($sf)){
            $b = true;
            $sf = new collection();
        }
        else if($mode == "edit" && !is_null($sf)){
            $b = ($sf instanceof Site);
            $parent = $sf;
        }

        $dt = new designTemplates();
        $templates = $dt->enum()->ReadAll();
        if($what != "site") {
            $tInherit = new stdClass();
            $tInherit->templates_id = 0;
            $tInherit->templates_name = "Inherit";
            $templates->Insert($tInherit, 0);
        }
        
        $langs = new Hashtable();
        foreach ($core->languages as $k => $v)
            $langs->Add($v, $k);
        if($b) {
        
            $ret .= $this->SetPostVar('site_id', $sf->id);
            $ret .= $this->SetPostVar('mode', $mode);

            $ret .= $this->RenderFormHeader();        
            
            $ret .= $this->RenderFormRow($this->lang->development_published, "published", $sf->published, true, null, "check");
            $ret .= $this->RenderFormRow($this->lang->development_sitename, "name", $sf->name, true, null, "text");
            $ret .= $this->RenderFormRow($this->lang->development_domainname, "domain", $sf->domain, true, null, "text");
            $ret .= $this->RenderFormRow($this->lang->development_description, "description", $sf->description, true, null, "text");
            
            $ret .= $this->RenderFormRow($this->lang->development_language, "language", array($langs, $sf->language), false, null, "combo", false, "selectbox", "width: 120px;");
            $ret .= $this->RenderFormRow($this->lang->development_template, "template", array($templates, $sf->template), false, Collection::Create("titleField", "templates_name", "valueField", "templates_id"), "combo", true, "selectbox", "width: 240px;");
            
            $ret .= $this->RenderFormRow($this->lang->development_notes, "notes", $sf->notes, false, null, "memo");
            
            $ret .= $this->RenderFormRow($this->lang->development_properties, "properties", $sf->tree_properties, false, null, "memo");
            
            $args = $this->DispatchEvent("editorpageform.rendersitefolderform.additional", collection::create("body", $ret, "folder", $sf));
            if (@$args->cancel === true)
                return;
            else if (!is_empty(@$args->body))
                    $ret = $args->body;
                    
            $ret .= $this->RenderFormRow("Static title", "header_statictitle", $sf->header_statictitle, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Meta keywords", "header_keywords", $sf->header_keywords, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Meta description", "header_description", $sf->header_description, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Shortcut icon", "header_shortcuticon", $sf->header_shortcuticon, false, null, "text", false, "code-box");
            $ret .= $this->RenderFormRow("Links base URL", "header_basehref", $sf->header_basehref, false, null, "text", false, "code-box");
            $ret .= $this->RenderFormRow("Inline styles", "header_inlinestyles", $sf->header_inlinestyles, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Inline scripts", "header_inlinescripts", $sf->header_inlinescripts, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Aditional tags", "header_aditionaltags", $sf->header_aditionaltags, false, null, "memo", false, "code-box");
            
            $ret .= $this->RenderFormFooter();
            
            $cmd = new CommandBar($this);
            $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "savesite"));
            $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
            $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);
            
        }
        else {
            $ret .= $this->SetPostVar('site_id', $sf->id);
            $ret .= $this->SetPostVar('mode', $mode);
            $ret .= $this->SetPostVar('parent_id', $parent->id);
            
            $ret .= $this->RenderFormHeader();        
            
            $ret .= $this->RenderFormRow($this->lang->development_published, "published", $sf->published, true, null, "check");
            $ret .= $this->RenderFormRow($this->lang->development_foldername, "name", $sf->name, true, null, "text");
            // $ret .= $this->RenderFormRow($this->lang->development_keyword, "keyword", $sf->keyword, true, null, "text");
            $ret .= $this->RenderFormRow($this->lang->development_description, "description", $sf->description, true, null, "text");
            $ret .= $this->RenderFormRow($this->lang->development_template, "template", array($templates, $sf->template), false, Collection::Create("titleField", "templates_name", "valueField", "templates_id"), "combo", true, "selectbox", "width: 240px;");
            $ret .= $this->RenderFormRow($this->lang->development_notes, "notes", $sf->notes, false, null, "memo");
            $ret .= $this->RenderFormRow($this->lang->development_properties, "properties", $sf->tree_properties, false, null, "memo");
            
            $args = $this->DispatchEvent("editorpageform.rendersitefolderform.additional", collection::create("body", $ret, "folder", $sf));
            if (@$args->cancel === true)
                return;
            else if (!is_empty(@$args->body))
                    $ret = $args->body;
                    
            $ret .= $this->RenderFormRow("Static title", "header_statictitle", $sf->header_statictitle, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Meta keywords", "header_keywords", $sf->header_keywords, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Meta description", "header_description", $sf->header_description, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Shortcut icon", "header_shortcuticon", $sf->header_shortcuticon, false, null, "text", false, "code-box");
            $ret .= $this->RenderFormRow("Links base URL", "header_basehref", $sf->header_basehref, false, null, "text", false, "code-box");
            $ret .= $this->RenderFormRow("Inline styles", "header_inlinestyles", $sf->header_inlinestyles, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Inline scripts", "header_inlinescripts", $sf->header_inlinescripts, false, null, "memo", false, "code-box");
            $ret .= $this->RenderFormRow("Aditional tags", "header_aditionaltags", $sf->header_aditionaltags, false, null, "memo", false, "code-box");
            
            $ret .= $this->RenderFormFooter();
            
            $cmd = new CommandBar($this);
            $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "savefolder"));
            $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
            $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);
            

        }
        
        return $ret;
    }

    function RenderMoveForm($sf, $okfunc = "movefolder", $cancelfunc = "close") {
        $ret = "";

        if(!($sf instanceof Folder)) {
            if(!is_object($sf))
                $ret .= $this->SetPostVar('sites_id_'.$sf, $sf);
            else
                foreach($sf as $ss) {
                    $ret .= $this->SetPostVar('sites_id_'.$ss, $ss);
                }
        }
        
        $folders = Site::EnumTree();
        
        $ret .= $this->RenderFormHeader();
        // , "denyStyle", "color:#f00", "denyObject", $s, "denyExpression", "\$v->isChildOf(\$this->args->denyObject) || \$v->id==\$this->args->denyObject->id"
        $ret .= $this->RenderFormRow($this->lang->development_copy, "copy", false, true, null, "check", false);
        $ret .= $this->RenderFormRow($this->lang->development_moveto, "moveto", array($folders, null), false, Hashtable::Create("titleField", "description", "valueField", "id", "padleftField", "level", "padleftMultiplier", 5), "combo");
        $ret .= $this->RenderFormFooter();
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->toolbar_move, $okfunc));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, $cancelfunc));
        $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);
        
        return $ret;

    }

    function RenderDesignTemplatesForm($dt, $t) {
        global $core;
        $ret = "";

        if(is_empty($t)) {
            $template = new collection();
        }
        else {
            $templates = $dt->enum();
            $templates = $templates->ReadAll("templates_name");
            $template = $templates->item($t);
        }

        $ret .= $this->SetPostVar("template_id", $template->templates_name);
        $ret .= $this->RenderFormHeader();

        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_name, "templates_name", $template->templates_name, true, null, "text", false, "text-box", "", "", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_libs, "templates_repositories", $template->templates_repositories, false, null, "memo", false, "code-box", "width: 90%; height: 40px;", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_header, "templates_head", $template->templates_head, false, null, "memo", false, "code-box", "", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_doctype, "templates_html_doctype", $template->templates_html_doctype, false, null, "memo", false, "code-box", "width: 90%; height: 40px;", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_title, "templates_head_title", $template->templates_head_title, false, null, "memo", false, "code-box", "width: 90%; height: 40px;", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_mkeywords, "templates_head_metakeywords", $template->templates_head_metakeywords, false, null, "memo", false, "code-box", "width: 90%; height: 60px;", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_mdescription, "templates_head_metadescription", $template->templates_head_metadescription, false, null, "memo", false, "code-box", "width: 90%; height: 60px;", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_baseurl, "templates_head_baseurl", $template->templates_head_baseurl, false, null, "text", false, "", "", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_styles, "templates_head_styles", $template->templates_head_styles, false,  Hashtable::Create("attributes", ' wrap="off" onkeydown="try{ return ProcessTab(event); } catch(e) {}"'), "memo", false, "code-box", "", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_scripts, "templates_head_scripts", $template->templates_head_scripts, false,  Hashtable::Create("attributes", ' wrap="off" onkeydown="try{ return ProcessTab(event); } catch(e) {}"'), "memo", false, "code-box", "", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_ad, "templates_head_aditionaltags", $template->templates_head_aditionaltags, false,  Hashtable::Create("attributes", ' wrap="off" onkeydown="try{ return ProcessTab(event); } catch(e) {}"'), "memo", false, "code-box", "width: 90%; height: 150px;", "180");
        $ret .= $this->RenderFormRow($this->lang->development_designtemplate_body, "templates_body", $template->templates_body, false, Hashtable::Create("attributes", ' wrap="off" onkeydown="try{ return ProcessTab(event); } catch(e) {}"'), "memo", false, "code-box", "width: 90%; height: 350px;", "180");
        $ret .= $this->RenderFormFooter();
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Containers->Add(new CommandBarButtonContainer("apply", "submit", $this->lang->apply, "apply"));
        $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);


        return $ret;
    }

    function RenderRepositoryForm($l) {
        global $core;
        $ret = "";
        if(is_empty($l)) {
            $lib = new collection();
        }
        else {
            $lib = new Library($l);// $libs->item($l);
        }
        $code = $lib->code;
            
        $types = new Collection();
        $types->Add("Php Code", "PHP_CODE");
        $types->Add("Css style", "HTML_CSS");
        $types->Add("Script block", "HTML_SCRIPT");
        $types->Add("Embed object", "HTML_OBJECT");
        $types->Add("XSlt Stylesheet", "HTML_XSLT");
        $types->Add("Xml page", "HTML_XML");
        

        $ret .= $this->SetPostVar("repository_id", $lib->name);

        $ret .= $this->RenderFormHeader();
        $ret .= $this->RenderFormRow($this->lang->development_repository_name, "repository_name", $lib->name, true, (is_empty($l) ? null : Hashtable::Create("disabled", true)), "text");
        $ret .= $this->RenderFormRow($this->lang->development_repository_codetype, "repository_type", array($types, $lib->type), true, null, "combo");
        $ret .= $this->RenderFormRow($this->lang->development_repository_body, "repository_code", $lib->code, true, Hashtable::Create("attributes", 'wrap="off" onkeydown="try{ return ProcessTab(event); } catch(e) {}"'), "memo", false, "code-box", "height: 320px; width: 90%;");
        $ret .= $this->RenderFormFooter();

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Containers->Add(new CommandBarButtonContainer("apply", "submit", $this->lang->apply, "apply"));
        $this->Out("toolbar_bottom", $cmd->Render(), OUT_AFTER);
        


        return $ret;
    }

    function RenderNoticeForm($id) {
        $ret = "";

        if($id < 0) {
            $s = new collection();
            $s->keyword = $this->notice_keyword;
            $s->encoding = $this->notice_encoding;
            $s->subject = $this->notice_subject;
            $s->body = $this->notice_body;
        }
        else
            $s = new Notice($id);
            
        $ret .= $this->SetPostVar("notice_id", $id);
        
        $ret .= $this->RenderFormHeader();
        
        $ret .= $this->RenderFormRow($this->lang->tools_notice_keyword, "notice_keyword", $s->keyword, true, null, "text");
        $ret .= $this->RenderFormRowStart();
            $ret .= $this->RenderFormTitleCell($this->lang->tools_notice_encoding);
            $ret .= $this->RenderFormControlCell(charsetCooser("notice_encoding", $s->encoding, "text-box", "width:220px;"), '', CONTROL_REQUIRED);
        $ret .= $this->RenderFormRowEnd();
        $ret .= $this->RenderFormRow($this->lang->tools_notice_subject, "notice_subject", $s->subject, true, null, "text");
        $ret .= $this->RenderFormRow($this->lang->tools_notice_body, "notice_body", $s->body, true, null, "html", false, "", "width: 90%; height: 350px;");
        $ret .= $this->RenderFormFooter();

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");        

        return $ret;
    }    
    
    function RenderSettingForm($sname) {
        global $core;
        
        $ret = "";       

        $ret .= $this->SetPostVar("setting_id", $sname);
        
        if(is_null($sname) || $sname == "")
            $s = new collection();
        else
            $s = $core->sts->item($sname);
        
        $stype = strtolower($s->setting_type);
        if(!is_null($this->setting_type))
            $stype = strtolower($this->setting_type);
        if(!$stype)
            $stype = "memo";
        
        $types = "";
        $tt = $core->dbe->SystemTypes();
        $t = new Collection();
        foreach($tt as $key => $value) {
            $t->Add($value, $key);
        }    
        
        $artypes = new Collection();
        $artypes->system = "1";
        $artypes->user = "0";
        
        $cats = new Collection();
        $categories = $core->sts->get_categories();
        foreach($categories as $category) {
            $cats->Add($category, new Hashtable(array("name" => $category, "value" => $category)));
        }
        
        if(!$s->is_system)
            $s->is_system = 0;
        
        $value = $s->value;
        if($s->type == "check")
            $value = $value == "true" ? true : false;
        
        $ret .= $this->RenderFormHeader();    

        $ret .= $this->RenderFormRow($this->lang->tools_setting_name, "setting_name", $sname, true, null, "text");
        $ret .= $this->RenderFormRow($this->lang->tools_setting_type, "setting_type", array($t, $stype), true, Hashtable::Create("attributes", 'onchange="javascript: return PostBack(\''.$this->command.'\', \'post\', \''.$this->section.'\', \''.$this->action.'\', null, createArray(\'setting_type\', this.options[this.selectedIndex].value, \'setting_id\', \''.$sname.'\'))"'), "combo", false, "", "width:220px;");
        $ret .= $this->RenderFormRow($this->lang->tools_setting_value, "setting_value", $value, false, null, $stype, false, "code-box");
        $ret .= $this->RenderFormRow($this->lang->tools_setting_settingtype, "setting_issystem", array($artypes, $s->is_system), true, null, "combo", false, "", "width: 120px;");
        $ret .= $this->RenderFormRow($this->lang->tools_setting_category, "setting_category", array($cats, $s->category), true, Hashtable::Create("titleField", "name", "valueField", "value"), "combo", false, "", "width: 220px;");
        
        $ret .= $this->RenderFormFooter();

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");        

        return $ret;
    }
    
    function RenderCategoryAddEditForm($parent_id, $category_id = null) {
        $ret = "";
        
        global $core;
        $ret = "";

        if(is_null($parent_id) || $parent_id < 0)
            $parent = new collection();
        else
            $parent = new BlobCategory(intval($parent_id));
        
        if(!is_null($category_id) && $category_id > 0)
            $category = new BlobCategory(intval($category_id));
        else    
            $category = new collection();
        
        $ret .= $this->RenderFormHeader();
        $ret .= $this->RenderFormRow($this->lang->tools_blobs_category_name, "name", $category->description, true, null, "text");
        $ret .= $this->RenderFormFooter();

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "savecategory"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");        
        
        return $ret;
    }
    
    function RenderBlobsBatchAddForm() {
        $ret = "";
        
        $ret .= '
            <script>
                function addBlob() {
                    
                    var blobscount = document.getElementById("blobscount").value;
                    blobscount ++;
                    document.getElementById("blobscount").value = blobscount;
                    
                    var table = document.getElementById("batchAdd");
                    table.insertRow(table.rows.length);
                    var row = table.rows[table.rows.length-1];
                    
                    row.insertCell(row.cells.length);
                    var cell = row.cells[row.cells.length-1];
                    
                    cell.innerHTML = \'\'+
                    \'    <table class="content-table" style="margin-top: 20px;">\'+
                    \'    <tr>\'+
                    \'    <td width="30%" class="field">'.$this->lang->tools_blobs_file.' </td>                                                              \'+
                    \'    <td class="value"><input name="file\'+blobscount+\'" type="file" class=text-box style="width:90%"></td>                                \'+
                    \'    </tr>                                                                                                                     \'+
                    \'    <tr>                                                                                                                  \'+
                    \'    <td class="field">'.$this->lang->tools_blobs_url.' </td>                                               \'+
                    \'    <td class="value"><input name="url\'+blobscount+\'" type="text" class=text-box value="" style="width:90%"></td>                 \'+
                    \'    </tr>                                                                                                      \'+
                    \'    <tr>                                                                                                   \'+
                    \'    <td class="field">'.$this->lang->tools_blobs_alt.' </td>                                \'+
                    \'    <td class="value"><input name="alt\'+blobscount+\'" type="text" class=text-box value="" style="width:90%"></td>\'+
                    \'    </tr>                                          \'+
                    \'    </table>                    \'+
                    \'\'+
                    \'\';
                    
                    
                }
            </script>
            <input type="hidden" name="blobscount" id="blobscount" value="0">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="content-table">
                <tr>
                    <td class="value">
                        '.$this->lang->tools_blobs_addresources_note.'
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:10px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="batchAdd">
                            <tr>
                                <td>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>            
            <script>
                addBlob();
            </script>
        ';

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarJButtonContainer("add", "button", $this->lang->addbatch, "return addBlob();"));
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "saveaddresources"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");

        return $ret;
    }
    
    function RenderFilesFolderAddForm() {
        $ret = '';
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "savefolder"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        $ret .= $this->RenderFormHeader();        
        $ret .= $this->RenderFormRow($this->lang->tools_foldername, "foldername", '[New folder]', true, null, "text");
        $ret .= $this->RenderFormFooter();
        
        return $ret;
    }
    
    function RenderFilesBatchAddForm1() {
        $ret = "";
        
        $ret .= '
            <script>
                function uploadFile() {
                    
                    var filescount = document.getElementById("filescount").value;
                    filescount ++;
                    document.getElementById("filescount").value = filescount;
                    
                    var table = document.getElementById("batchAdd");
                    table.insertRow(table.rows.length);
                    var row = table.rows[table.rows.length-1];
                    
                    row.insertCell(row.cells.length);
                    var cell = row.cells[row.cells.length-1];
                    
                    cell.innerHTML = \'\'+
                    \'    <table class="content-table" style="margin-top: 20px;">\'+
                    \'    <tr>\'+
                    \'    <td width="30%" class="field">'.$this->lang->tools_blobs_file.' </td>\'+
                    \'    <td class="value"><input name="file\'+filescount+\'" type="file" class=text-box style="width:90%"></td>\'+
                    \'    </tr>\'+
                    \'    </table>                    \'+
                    \'\'+
                    \'\';
                    
                    
                }
            </script>
            <input type="hidden" name="filescount" id="filescount" value="0">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="content-table">
                <tr>
                    <td class="value">
                        '.$this->lang->tools_files_upload_form.'
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:10px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="batchAdd">
                            <tr>
                                <td>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>            
            <script>
                uploadFile();
                uploadFile();
                uploadFile();
                uploadFile();
                uploadFile();
            </script>
        ';

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarJButtonContainer("add", "button", $this->lang->addbatch, "return uploadFile();"));
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "saveuploadedfile"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");

        return $ret;
    }    
    
    function RenderFilesBatchAddForm() {
        $ret = "";
        global $core;
        
        $ret .= '
            <link href="/core/extras/uploader/samples/css/default.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="/core/extras/uploader/plugins/swfupload.js"></script>
            <script type="text/javascript" src="/core/extras/uploader/plugins/swfupload.swfobject.js"></script>
            <script type="text/javascript" src="/core/extras/uploader/plugins/swfupload.queue.js"></script>
            <script type="text/javascript" src="/core/extras/uploader/plugins/fileprogress.js"></script>
            <script type="text/javascript" src="/core/extras/uploader/plugins/handlers.js"></script>
            <script type="text/javascript">
            var swfu;
            
            var wload = window.onload;
            window.onload = function () {
                  
                  wload();
                  
                var settings = {
                    flash_url : "/core/extras/uploader/flash/swfupload.swf",
                    upload_url: "/admin/floating.php",
                    post_params: {
                        "PHPSESSID" : "NONE",
                        "folder_id_" : "'.$core->rq->folder_id_.'",
                        "postback_section" : "editor",
                        "postback_action" : "files",
                        "postback_command" : "saveajaxfile"
                    },
                    file_size_limit : "400 MB",
                    file_types : "*.*",
                    file_types_description : "All Files",
                    file_upload_limit : 100,
                    file_queue_limit : 0,
                    custom_settings : {
                        progressTarget : "fsUploadProgress",
                        cancelButtonId : "btnCancel"
                    },
                    debug: true,

                    // Button Settings
                    button_image_url : "/core/extras/uploader/flash/XPButtonUploadText_61x22.png",
                    button_placeholder_id : "spanButtonPlaceholder",
                    button_width: 80,
                    button_height: 24,

                    // The event handler functions are defined in handlers.js
                    swfupload_loaded_handler : swfUploadLoaded,
                    file_queued_handler : fileQueued,
                    file_queue_error_handler : fileQueueError,
                    file_dialog_complete_handler : fileDialogComplete,
                    upload_start_handler : uploadStart,
                    upload_progress_handler : uploadProgress,
                    upload_error_handler : uploadError,
                    upload_success_handler : uploadSuccess,
                    upload_complete_handler : uploadComplete,
                    queue_complete_handler : queueComplete,    // Queue plugin event
                    
                    // SWFObject settings
                    minimum_flash_version : "9.0.28",
                    swfupload_pre_load_handler : swfUploadPreLoad,
                    swfupload_load_failed_handler : swfUploadLoadFailed
                };

                swfu = new SWFUpload(settings); 
                
            }
            

            </script>
            
            <div id="divSWFUploadUI">
                <p class="bar">
                    <span id="spanButtonPlaceholder"></span>
                    <input id="btnCancel" type="button" value="Отменить все загрузки" disabled="disabled" />
                    <br />
                </p>
                <p id="divStatus">Загружено 0 файлов</p>
                <div class="fieldset flash" id="fsUploadProgress">
                    <span class="legend">Список загрузок</span>
                </div>
            </div>
            <noscript>
                <div style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px;">
                    Пожалуйста включите скрипты для корректной работы загрузчика
                </div>
            </noscript>
            <div id="divLoadingContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
                Загрузка обьекта...
            </div>
            <div id="divLongLoading" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
                Загрузка обьекта длится слишком долго, пожалуйста убедитесь, что у вас настроен Adobe Flash Player
            </div>
            <div id="divAlternateContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
                Обьект Adobe Flash Player не установлен.
                Пожалуйста перейдите по <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">этой ссылке</a> чтобы его скачать.
            </div>
            
        ';

        $cmd = new CommandBar($this);
        /*$cmd->Containers->Add(new CommandBarJButtonContainer("add", "button", $this->lang->addbatch, "return uploadFile();"));
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "saveuploadedfile"));*/
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->toolbar_close, "close"));
        $cmd->Render("toolbar_bottom");

        return $ret;
    }    

    function RenderBlobsBatchEditForm($blobid) {
        $ret = "";
        global $core;
        
        $blob = new Blob((int) $blobid);
        
        $ret .= '
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="batchAdd" class="content-table">
                            <tr>
                                <td width="120" align="center">
                                ';
                                        if($blob->mimetype->isImage) {
        $ret .= '
                                            <a href="'.$blob->Src().'" target="_blank"><img src="'.$blob->Src(new Size(100, 100)).'" border="0" ></a>
        ';
                                        }
                                        else {
        $ret .= '                        
                                            <a href="'.$blob->Src().'"><img border="0" src="'.@$blob->mimetype->icon.'"></a>
        ';
                                        }
        $ret .= '
                                </td>
                                <td valign="top">
                                    <table class="content-table">
                                    <tr>
                                    <td width="30%" class="field">'.$this->lang->tools_blobs_file.' </td>                                            
                                    <td class="value"><input name="file" type="file" class=text-box style="width:90%"></td>            
                                    </tr>                                                                                                            
                                    <tr>                                                                                                            
                                    <td class="field">'.$this->lang->tools_blobs_url.' </td>                                            
                                    <td class="value"><input name="url" type="text" class=text-box value="" style="width:90%"></td>                 
                                    </tr>                                                                                            
                                    <tr>                                                                                            
                                    <td class="field">'.$this->lang->tools_blobs_alt.' </td>                            
                                    <td class="value"><input name="alt" type="text" class=text-box value="'.$blob->alt.'" style="width:90%"></td>
                                    </tr>                            
                                    </table>                    
                                </td>
                            </tr>
                        </table>
        ';

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarJButtonContainer("save", "submit", $this->lang->save, "UploadFile(true); return PostBack('saveeditresource', 'post');"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;
    }
    
    function RenderMoveBlobForm($bc_id) {
        $ret = "";
        
        $ret .= '
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="content-table">
            <tr>
            <td width="20%" class="field">'.$this->lang->development_moveto.'</td>
            <td class="value">
                <select name="moveto" class="select-box" style="width:90%">
            ';
            
            $categories = new BlobCategories();
            
            if(intval($bc_id) > 0)
                $s = new BlobCategory(intval($bc_id));
            else {
                $s = new BlobCategory();
            }

            $red = $s->id == -1 ? 'style="color: #ff0000;"' : '';
            $selected = $s->id == -1 ? ' selected' : '';
            $ret .= '
            <option value="'.$s->id.'" '.$red.' '.$selected.'>Uncategorized</option>
            ';
            
            $ret .= $this->RenderBlobCategoriesOptions($categories, $s);
                    
        $ret .= '
                </select>
            </td>
            </tr>
            </table>            
        ';

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "moveresourcecomplete"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;
            
    }
    
    function RenderImportModule(){
        //$ret = $this->SetPostVar("module_import", "1");
        
        $ret = "";
        
        if (!is_empty($this->module_file)){ //$core->rq->
            
            $file = $this->module_file;
            
            if (stripos($file->mimetype, "xml") === false || !$file->is_valid())
                return "<div class='warning-title'>".$this->lang->modules_install_fail_text."</div>
                    <div class='warning'>".$this->lang->error_module_install_file."</div>";
            
            $xml = $file->binary();
            
            try {
                $doc = @DOMDocument::loadXML($xml);
                if (!$doc)
                    return "<div class='warning-title'>".$this->lang->modules_install_fail_text."</div>
                        <div class='warning'>".$this->lang->error_module_install_file."</div>";
                
                /*$doc = new DomDocument();
                $doc->LoadXml($xml);*/
                //$doc->normalize();
                
                $el = $doc->documentElement;
                
                $mod = CModuleManager::NewModule();
                try {
                    global $core;
                    $core->dbe->StartTrans();
                    $mod->from_xml($el);
                    $inst = CModuleManager::CreateInstance($mod);
                    $core->dbe->CompleteTrans();
                } catch (exception $ex){
                    $core->dbe->FailTrans();
                }
                $ret .= $this->ReloadOwner();
                $ret .= $this->CloseMe();
            } catch (Exception $e){
                return "<div class='warning-title'>".$this->lang->modules_install_fail_text."</div>";
            }
        } else {
            $ret .= "<div class='module-prop'>";
            $ret .= "<div class='small-text'>".$this->lang->modules_module_import_info."</div>";
            $ret .= $this->SetPostVar("module_file", "", "file", "class=\"text-box w300\"");
            $ret .= "</div>";
            
            $cmd = new CommandBar($this);
            $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->accept, "import"));
            $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
            $cmd->Render("toolbar_bottom");
            
        }
        
        return $ret;
    }
    
    function RenderExportModule(){
        $id = (!$this->module_id) 
            ? $this->post_vars("module_id_")
            : collection::create(array($this->module_id));
        if ($id->Count() == 0)
            return $this->ErrorMessage($this->lang->modules_select_empty, $this->lang->error_message_box_title);
        else
            $ret = $this->SetPostVar("module_id", $id->item(0));
            
        $mod = new CModule($id->item(0));
        
        $with_data = (is_empty($this->module_with_data)) ? "0" : "1";
        $update_version = $this->module_update_version;
        $header = $this->module_header;
        
        $wdsel = ($with_data == "1") ? " checked='checked'" : "";
        
        global $core;
        
        if ($core->rq->download == "1"){
            //$stream = $mod->to_xml($with_data == "1", $update_version, $header);
            $stream = $this->module_xml;
            
            header("Content-Type: text/xml");
            header('Content-Disposition: attachment; filename=module_'.strtolower($mod->entry)."_".str_replace(".", "_", trim($mod->version)).'.xml');
            //header('Content-Length: '.strlen($stream)); //*2 -> ?
            /*header('Expires: '.(30*60*60*24));
            header('Cache-Control: max-age='.(30*60*60*24).', public');
            header("Last-Modified: ".gmdate("D, d M Y H:i:s", $modifydate)." GMT");*/
            echo '<?xml version="1.0" encoding="utf-8"?>'.$stream;
            exit;
            /*jsRedirect("http://bnet.grcom.ru/admin/floating.php?postback_section=editor&postback_action=modules&postback_command=export&module_id=&module_state=&module_id_1=1&module_export=1");*/
        } else if ($this->module_id){
            //$ret .= "<script language='javascript'>window.open('floating.php?download=1&postback_section=".$this->section."&postback_action=".$this->action."&postback_command=".$this->command."&module_id=".$this->module_id."');</script>";
            
            $stream = $mod->to_xml($with_data == "1", $update_version, $header);
            
            $ret .= $this->SetPostVar("download", 1);
            
            $ret .= "<div class='module-prop'>";
            //$ret .= "<div class=\"link\"><a href=\"floating.php?download=1&postback_section=".$this->section."&postback_action=".$this->action."&postback_command=".$this->command."&module_id=".$this->module_id."'\" target=\"_blank\" class=\"u\">".$this->lang->modules_module_exportlink."</a></div>";
            $ret .= "<div class=\"link\"><a href=\"javascript: document.getElementById('idfPostBack').method = 'post'; document.getElementById('idfPostBack').submit();\" class=\"u\">".$this->lang->modules_module_exportlink."</a></div>";
            $ret .= '<table width="100%" border="0" cellspacing="3" cellpadding="0" class="content-table">';
            $ret .= "
                <tr>
                    <td class='value'><textarea class='area w700' name='module_xml'>".$stream."</textarea></td>
                </tr>
            ";
            $ret .= '</table>';
            $ret .= "</div>";
            
            $cmd = new CommandBar($this);
            $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
            $cmd->Render("toolbar_bottom");
            
            
            //$ret .= $this->CloseMe();
        } else {
            $ret .= "<div class='module-prop'>";
            
            $ret .= '<table width="100%" border="0" cellspacing="3" cellpadding="0" class="content-table">';
            $ret .= "
                <tr>
                    <td class='field'>".$this->lang->modules_module_exportversion."</td>
                    <td class='value'><input class='text-box w200' name='module_update_version' value='".$update_version."'></td>
                    <td class='field'>".$this->lang->modules_module_exportwithdata."</td>
                    <td class='value wide'><input type='checkbox' name='module_with_data' class='check-box'".$wdsel." /></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_exportheader."</td>
                    <td class='value' colspan='3'><textarea class='area w600 h400' name='module_header'>".$header."</textarea></td>
                </tr>
            ";
            $ret .= '</table>';
            
            $ret .= "</div>";
            
            $cmd = new CommandBar($this);
            $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->accept, "export"));
            $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
            $cmd->Render("toolbar_bottom");            
            
        }
        
        return $ret;
    }
    
    function RenderEditModule($isnew = false){
        global $core;
        
        $id = false;
        $ret = $this->SetPostVar("action_command", "post");
        
        $posted = $this->action_command == "post";
        
        if ($isnew){
            
        } else {
            $id = (!$this->module_id) 
                ? $this->post_vars("module_id_")
                : collection::create(array($this->module_id));
            if ($id->Count() == 0)
                return $this->ErrorMessage($this->lang->modules_select_empty, $this->lang->error_message_box_title);
            else
                $ret .= $this->SetPostVar("module_id", $id->item(0));
            $mod = new CModule($id->item(0));
        }
        
        $error = "";
        
        $this->module_haseditor = (is_empty($this->module_haseditor)) ? "0" : "1";
        $this->module_publicated = (is_empty($this->module_publicated)) ? "0" : "1";
        
        if ($posted)
            if (is_empty($this->module_entry) || is_empty($this->module_title) || is_empty($this->module_type)
                || is_empty($this->module_compat) || is_empty($this->module_admincompat) 
                /* || is_empty($this->module_code) */ || is_empty($this->module_version))
                    $error = $this->lang->error_form_empty;
        
        $favorite = ($posted) ? (int)$this->module_favorite : (($isnew) ? "0" : $mod->favorite);
        $haseditor = ($posted) ? $this->module_haseditor : (($isnew) ? "0" : $mod->haseditor);
        $publicated = ($posted) ? $this->module_publicated : (($isnew) ? "0" : $mod->publicated);
        $type = ($posted) ? $this->module_type : (($isnew) ? "0" : $mod->type);
        $entry = ($posted) ? $this->module_entry : (($isnew) ? "" : $mod->entry);
        $title = ($posted) ? $this->module_title : (($isnew) ? "" : $mod->title);
        $description = ($posted) ? $this->module_description : (($isnew) ? "" : $mod->description);
        $version = ($posted) ? $this->module_version : (($isnew) ? "" : $mod->version);
        $admincompat = ($posted) ? $this->module_admincompat : (($isnew) ? "" : $mod->admincompat->ToString());
        $compat = ($posted) ? $this->module_compat : (($isnew) ? "" : $mod->compat->ToString());
        $storages = ($posted) ? $this->module_storages : (($isnew) ? "" : $mod->storages->ToString());
        $libraries = ($posted) ? $this->module_libraries : (($isnew) ? "" : $mod->libraries->ToString());
        $code = ($posted) ? $this->module_code : (($isnew) ? "" : $mod->code);
        $iconpackname = ($posted) ? $this->module_iconpack : (($isnew) ? "" : $mod->iconpack);
        
        $fsel = ($favorite == "1") ? " checked='checked'" : "";
        $hsel = ($haseditor == "1") ? " checked='checked'" : "";
        $psel = ($publicated == "1") ? " checked='checked'" : "";
        
        $al = new arraylist($storages);
        foreach ($al as $item){
            $s = storages::get($item);
            if ($s == null){
                $error = $this->lang->module_storage_nonexists;
                break;
            }
        }
        if (!$error){
            $al = new arraylist($libraries);
            foreach ($al as $item){
                $l = new Library($item);
                if (!$l->is_valid()){
                    $error = $this->lang->module_library_nonexists;
                    break;
                }
            }
        }
        
        // check the iconpack exists
        
        if (!$posted || $error){
            $types = CModuleManager::$types;
            $tp = "<select name='module_type' class='select'>";
            foreach ($types as $k => $v)
                $tp .= "<option value='".$k."'".(($k == $type) ? " selected='selected'" : "").">".$v."</option>";
            $tp .= "</select>";
            
            $ret .= "<div class='module-prop'>";
            
            $ret .= "<div class='warning'>".$error."</div>";
            $ret .= '<table width="100%" border="0" cellspacing="3" cellpadding="0" class="content-table">';
            $ret .= "
                <tr>
                    <td class='field'>".$this->lang->modules_module_favorite."</td>
                    <td class='value'><input type='checkbox' name='module_favorite' class='check-box'".$fsel." value='1' /></td>
                    <td colspan='2'></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_type."<span class='warning'>*</span></td>
                    <td class='value'>".$tp."</td>
                    <td class='field'>".$this->lang->modules_module_haseditor."</td>
                    <td class='value'><input type='checkbox' name='module_haseditor' class='check-box'".$hsel." /></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_entry."<span class='warning'>*</span></td>
                    <td class='value'><input class='text-box w200' name='module_entry' value='".$entry."'></td>
                    <td class='field'>".$this->lang->modules_module_publicated."</td>
                    <td class='value'><input type='checkbox' name='module_publicated' class='check-box'".$psel." /></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_title."<span class='warning'>*</span></td>
                    <td class='value'><input class='text-box w200' name='module_title' maxlength='255' value='".$title."'></td>
                    <td class='field'>".$this->lang->modules_module_version."<span class='warning'>*</span></td>
                    <td class='value'><input class='text-box w200' name='module_version' value='".$version."'></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_admincompat."<span class='warning'>*</span></td>
                    <td class='value'><input class='text-box w200' name='module_admincompat' value='".$admincompat."'></td>
                    <td class='field'>".$this->lang->modules_module_compat."<span class='warning'>*</span></td>
                    <td class='value'><input class='text-box w200' name='module_compat' value='".$compat."'></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_storages."</td>
                    <td class='value'><input class='text-box w200' name='module_storages' value='".$storages."'></td>
                    <td class='field'>".$this->lang->modules_module_libraries."</td>
                    <td class='value'><input class='text-box w200' name='module_libraries' value='".$libraries."'></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_iconpackname."</td>
                    <td class='value' colspan='3'><input class='text-box w200' name='module_iconpack' value='".$iconpackname."'></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_description."</td>
                    <td class='value' colspan='3'><textarea class='area w600 h100 code-box' style='width: 98%' name='module_description'>".$description."</textarea></td>
                </tr>
                <tr>
                    <td class='field'>".$this->lang->modules_module_code."<span class='warning'>*</span></td>
                    <td class='value' colspan='3'><textarea class='text-area h300 code-box' style='width: 98%' wrap='off' name='module_code'>".$code."</textarea></td>
                </tr>
            ";
            $ret .= '</table>';
            
            $ret .= "<div class='small-text'>".$this->lang->modules_module_edit_info."</div>";
            
            $ret .= "</div>";
        } else {
            if ($isnew)
                $mod = new CModule(-1);
            
            $mod->publicated = $publicated;
            $mod->favorite = $favorite;
            $mod->haseditor = $haseditor;
            $mod->type = $type;
            $mod->entry = $entry;
            $mod->title = $title;
            $mod->description = $description;
            $mod->version = $version;
            $mod->code = $code;
            $mod->iconpack = $iconpackname;
            
            $mod->admincompat->Clear();
            $mod->compat->Clear();
            $mod->libraries->Clear();
            $mod->storages->Clear();
            
            $mod->admincompat->FromString($admincompat);
            $mod->compat->FromString($compat);
            $mod->libraries->FromString($libraries);
            $mod->storages->FromString($storages);
            
            $mod->Save();

            $ret .= $this->ReloadOwner();
            $ret .= $this->CloseMe();
        }
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->accept, (($isnew) ? "add" : "edit")));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        
        return $ret;
    }
    
    function RenderAddModule(){
        global $core;
        
        $this->encbinary = true;
        
        $ret = "<div class=\"info-list\">";
        
        if (!is_empty($core->rq->module_file)){
            
            if (stripos($core->rq->module_file->mimetype, "xml") === false || !$core->rq->module_file->is_valid())
                return "<div class=\"title-message header\">".$this->lang->modules_install_fail_text.
                    "<div class=\"warning\">".$this->lang->error_module_install_file."</div>
                    </div>";
            
            $content = $core->rq->module_file->binary();
            
            /* if (stripos(strtolower($content), "extends cmodule") === false)
                return "<div class=\"title-message header\">".$this->lang->modules_install_fail_text."<br />
                    <div class=\"warning\">".$this->lang->error_module_bad."</div>
                    </div>"; */
            
            //$content = preg_replace("/\\r/mi", "", $content);
            //$content = preg_replace("/\\n/mi", "", $content);
            //$content = preg_replace("/>\s*</mi", "><", $content);
            
            try {
                $xml = @DOMDocument::loadXML($content);
                if (!$xml)
                    return "<div class=\"title-message\">".$this->lang->modules_install_fail_text.
                        "<div class=\"warning\">".$this->lang->error_module_install_file."</div>
                        </div>";
                
                if ($xml->documentElement->childNodes->length == 0)
                    return "<div class=\"title-message\">".$this->lang->modules_install_fail_text.
                        "<div class=\"warning\">".$this->lang->error_module_install_file."</div>
                        </div>";
                
                $nmoduls = $xml->documentElement->childNodes;
                
                $minfo = new stdClass();
                foreach ($nmoduls as $nmod){
                    if ($nmod->nodeType == 3)
                        continue;
                        
                    $xpath = new DOMXPath($xml);
                    
                    $minfo->module_name = $xpath->query("meta/name", $nmod)->item(0)->nodeValue;
                    $minfo->module_version = $xpath->query("meta/version", $nmod)->item(0)->nodeValue;
                    $minfo->module_description = $xpath->query("meta/description", $nmod)->item(0)->nodeValue;
                    $minfo->module_alias = $xpath->query("meta/alias", $nmod)->item(0)->nodeValue;
                    $minfo->module_code = addslashes($xpath->query("code", $nmod)->item(0)->nodeValue);
                    
                    $cvers = new Arraylist();
                    $entries = $xpath->query("meta/compatibility/version", $nmod);
                    
                    foreach ($entries as $cver)
                        $cvers->Add($cver->nodeValue);
                        
                    $minfo->module_compat = addslashes($cvers->Serialize());
                    $minfo->module_order = CModuleManager::NewOrder();
                    
                    $minfo->module_state = 2;
                    
                    $mod = new CModule($minfo);
                    CModuleManager::Save($mod->GetData());
                }
            } catch (Exception $e){
                return "<div class=\"title-message\">".$this->lang->modules_install_fail_text."</div>";
            }
            
            $ret .= "<div class=\"title-message\">".$this->lang->modules_install_success_text."</div>";
            $ret .= "<script language=javascript>window.setTimeout('PostBack(\'ok\', \'post\')', 1000);</script>";
        } else {
            $ret .= "<div class=\"title-message\"><strong>".$this->lang->modules_add_text."</strong></div>";
            $ret .= $this->SetPostVar("module_file", "", "file", "class=\"text-box\"");
        }

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->accept, "add"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
                
        return $ret."</div>";
    }
    
    function RenderUserEditForm() {
        global $core;
        $users = $this->post_vars("user_name");
        if($this->command != "add") {
            if($users->Count() > 1)
                return $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
            else if($users->Count() == 0)
                return $this->ErrorMessage($this->lang->error_select_user, $this->lang->error_message_box_title);        
        }
        
        $ret = "";
        
        $ballow = false;
        if($this->command == "add")
            $ballow = $core->security->Check(null, "usermanagement.users.add");
        else
            $ballow = $core->security->Check(null, "usermanagement.users.edit");
        
        if(!$ballow) {
            return $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
        }
        
        $uname = $users->item(0);
        
        $ret .= $this->SetPostVar("user_name", $uname);
        $ret .= $this->SetPostVar("mode", $this->command);
        
        if($this->command != "add")
            $user = SecurityEx::$users->$uname;
        else
            $user = new User();
        
        $ret .= $this->RenderFormHeader();        
        $ret .= $this->RenderFormRow($this->lang->tools_users_name, "login", $user->name, true, null, "text");
        $ret .= $this->RenderFormRow($this->lang->tools_users_password, "password", $user->password, true, null, "text", true);
        $ret .= $this->RenderFormRow($this->lang->tools_users_groups, "groups", array(SecurityEx::$groups, $user->groups), false, Collection::Create("titleField", "name", "valueField", "name"), "list", true);
        $ret .= $this->RenderFormRow($this->lang->tools_users_roles, "roles", array($core->security->systemInfo->roles, $user->roles), true, Collection::Create("titleField", "description", "valueField", "name"), "list", true);
        $ret .= $this->RenderFormFooter();
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;    
    }    
    
    function RenderGroupEditForm() {
        global $core;
        $groups = $this->post_vars("group_name");
        
        if($this->command != "group_add") {
            if($groups->Count() > 1)
                return $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
            else if($groups->Count() == 0)
                return $this->ErrorMessage($this->lang->error_select_group, $this->lang->error_message_box_title);
        }
        
        $ballow = false;
        if($this->command == "group_add")
            $ballow = $core->security->Check(null, "usermanagement.groups.add");
        else
            $ballow = $core->security->Check(null, "usermanagement.groups.edit");
        
        if(!$ballow) {
            return $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
        }
        
        $ret = "";
        
        $gname = '';
        if($this->command == 'group_edit')
            $gname = $groups->item(0);
        
        $ret .= $this->SetPostVar("group_name", $gname);
        $ret .= $this->SetPostVar("mode", $this->command);
        
        if($this->command != "group_add")
            $group = SecurityEx::$groups->$gname;
        else
            $group = new Group();
        
        $ret .= $this->RenderFormHeader();        
        $ret .= $this->RenderFormRow($this->lang->tools_usermanager_groupname, "name", $group->name, true, null, "text");
        $ret .= $this->RenderFormRow($this->lang->tools_usermanager_groupdescription, "description", $group->description, true, null, "text", false);
        $ret .= $this->RenderFormRow($this->lang->tools_usermanager_users, "users", array(SecurityEx::$users, $group->users), false, Collection::Create("titleField", "name", "valueField", "name"), "list", true);
        $ret .= $this->RenderFormFooter();
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "group_save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;    
    }        
    
    function RenderRoleEditForm() {
        global $core;
        $roles = $this->post_vars("role_name_");
        
        if($this->command != "role_add") {
            if($roles->Count() > 1)
                return $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
            else if($roles->Count() == 0)
                return $this->ErrorMessage($this->lang->error_select_role, $this->lang->error_message_box_title);
        }
        
        $ballow = false;
        if($this->command == "role_add")
            $ballow = $core->security->Check(null, "usermanagement.roles.add");
        else
            $ballow = $core->security->Check(null, "usermanagement.roles.edit");
        
        if(!$ballow) {
            return $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
        }
        
        $ret = "";
        
        $rname = '';
        if($this->command == 'role_edit')
            $rname = $roles->item(0);
        
        $ret .= $this->SetPostVar("role_name", $rname);
        $ret .= $this->SetPostVar("mode", $this->command);
        
        if($this->command != "role_add")
            $role = $core->security->systemInfo->roles->$rname;
        else
            $role = new Role("");
        
        $tree = $core->security->systemInfo->operations_tree;
        
        $ret .= $this->RenderFormHeader();        
        $ret .= $this->RenderFormRow($this->lang->tools_usermanager_rolename, "name", $role->name, true, null, "text");
        $ret .= $this->RenderFormRow($this->lang->tools_usermanager_roledescription, "description", $role->description, true, null, "text", false);
        $ret .= $this->RenderFormRow($this->lang->tools_usermanager_roleoperations, "operations", array($tree, $role), false, Collection::Create("checkField", "operation", "valueField", "permission"), "tree", true);
        $ret .= $this->RenderFormFooter();
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->save, "role_save"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;    
    }        
    
    function RenderCopyForm() {
    
        $ret = "";
        $ret .= $this->RenderFormHeader();        
        $ret .= $this->RenderFormRow($this->lang->copies, "copies", 1, true, null, "numeric");
        $ret .= $this->RenderFormFooter();
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("docopydata", "submit", $this->lang->copy_, "docopydata"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;
    }
    
    function RenderMoveToDataForm() {
    
        $storage = new Storage($this->storage_id);
        $nodes = new DataNodes($storage);
        $nodes->Load();
        $root = $nodes->RootNode();
        $nodes = $nodes->FetchAll();

        $field = 'description';
        if(is_empty($storage->fields->description))
            $field = $storage->fields->Item(0)->field;
        
        $root->$field = '...';
        
        $nodes->Insert("0", $root, 0);
        
        $ret = "";
        $ret .= $this->RenderFormHeader();        
        $ret .= $this->RenderFormRow($this->lang->development_field_type, "data_node", array($nodes, 0), false, Hashtable::Create('titleField', $field, 'valueField', 'id', "padleftField", "level", "padleftMultiplier", 5), "combo", false, "selectbox", "width: 320px;");
        $ret .= $this->RenderFormFooter();
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("domovetodata", "submit", $this->lang->moveto_, "domovetodata"));
        $cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close"));
        $cmd->Render("toolbar_bottom");
        
        return $ret;
    }
    
    function CopyItem($storage, $item, $copies) {
        $dt = new DataRow($storage, $item);
        if(!is_numeric($copies)) $copies = 1;
        $copies = (int)$copies;
        
        for($i=0; $i < $copies; $i++) {
            $dt->Copy();
        }
        return true;
    }
    
}
?>