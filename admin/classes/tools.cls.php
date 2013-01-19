<?php


/**
    * class ManagementPageForm
    *
    * Description for class ManagementPageForm
    *
    * @author:
    */
class ToolsPageForm extends PostBackForm {
    /**
        * Constructor.
        *
        * @param
        * @return
        */
    function ToolsPageForm() {
        parent::__construct("tools", "main", "/admin/index.php", "get");
    }

    function RenderContent() {
        global $core;
        
        $ret = "";
        
        $this->Out("title", $this->lang->tools_title, OUT_AFTER);
        
        switch($this->action) {
            case 'recompile_core': {
                switch($this->command) {
                    case "recompile":
                        RecompileCore();
                        $ret .= $this->DoPostBack("complete", "recompile_core");
                        break;
                    case 'complete':
                        $ret .= 'Recompile compete';
                        break;
                }
            }
            case "usersex":
                if(!$core->security->Check(null, "usermanagement.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                $ret .= $this->RenderUserManager();
                break;
            case "systemrestore":
                if(!$core->security->Check(null, "sysrestore.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                $rp = new systemrestore();
                $rp->setDroptables(true);
                
                $this->Out("subtitle", $this->lang->tools_system_restore, OUT_AFTER);
                
                switch($this->command) {
                    case "message_ok":
                    case "view":
                        $ret .= $this->RenderSystemRestore($rp);
                        break;
                    case "restore":
                        if($core->security->Check(null, "sysrestore.restore")) {
                            $ret .= '<table class="content-table"><tr><td class="value">';
                            $ret .= "<h3>".$this->lang->tools_system_restore_message1."</h3>";

                            $ret .= $this->lang->tools_system_restore_message2;
                            $ret .= $this->lang->tools_system_restore_message3;

                            $name = $rp->RestoreFrom($this->resporepoint);
                            if($name) {
                                global $SITE_PATH;
                                $ret .= sprintf($this->lang->tools_system_restore_message4, '/'.str_replace($SITE_PATH, '', $name), '/'.str_replace($SITE_PATH, '', $name));
                                /*$core->abandone();
                                $ret .= "<script language=javascript>window.setTimeout('location=\'/admin/\'',1000);</script>";*/
                            }
                            else
                                $ret .= $this->lang->tools_system_restore_message5;
                            $ret .= '</td></tr></table>';
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "create":
                        if($core->security->Check(null, "sysrestore.create")) {
                            $ret .= '<table class="content-table"><tr><td class="value">';
                            
                            $ret .= "<h3>".$this->lang->tools_system_restore_message6."</h3>";
                            $ret .= $this->lang->tools_system_restore_message7;
                            $ret .= $this->lang->tools_system_restore_message8;

                            $dumpname = $rp->CreatePoint();

                            $ret .= $this->lang->tools_system_restore_message9;
                            $ret .= $this->lang->tools_system_restore_message10.'<a href="/system_restore/'.$dumpname.'" target="_blank">'.$dumpname."</a> ...";

                            $ret .= $this->lang->tools_system_restore_message11;
                            $ret .= '</td></tr></table>';

                            if(is_null($core->sts->SYSTEM_RESTORE_CRON_MAX))
                                $core->sts->SYSTEM_RESTORE_CRON_MAX = 10;
                                
                            // $rp->clean_points($core->sts->SYSTEM_RESTORE_CRON_MAX);
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "setschedule": {
                        if($core->security->Check(null, "sysrestore.setschedule")) {
                            global $SITE_PATH;
                            $cronfile = $SITE_PATH."cron/cron";
                            $logpath = $SITE_PATH."cron/log";                        
                            
                            $crontype = $core->rq->cron;
                            switch($crontype) {
                                case 0: 
                                    $c = "";
                                    break;
                                case 1: //dayly
                                    $c = "2-8 23 * * *";
                                    break;
                                case 2: //weekly
                                    $c = "2-8 * * * 0";
                                    break;
                                case 3: //monthly
                                    $c = "2-8 * */30 * *";
                                    break;
                            }
                            
                            $command_del = "> ".$logpath;
                            out($command_del);
                            system($command_del);
                            $command_del = "crontab -r >> ".$logpath;
                            out($command_del);
                            system($command_del);
                            if($c != "") {
                                $command = "echo \"".$c." wget -O /dev/null -q http://".$_SERVER['SERVER_NAME']."/admin/cron.php\" > ".$cronfile;
                                $command1 = "crontab ".$cronfile." >> ".$logpath;
                                out($command);                        
                                out($command1);
                                system($command);
                                system($command1);
                            }
                            $command = "crontab -l >> ".$logpath;
                            out($command);
                            system($command);
                            $ret .= $this->DoPostBack("view", "get");
                        }                            
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        
                    }

                }
                break;
            case "notices": {
                if(!$core->security->Check(null, "notices.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
            
                switch($this->command) {
                    case "message_ok":
                    case "view":
                        $this->Out("subtitle", $this->lang->tools_notice_view, OUT_AFTER);
                        $ret .= $this->ListNotices();
                        break;
                    case "remove":
                        $form = $this->post_vars("notice_id_");
                        $items = array();
                        $error = false;
                        foreach($form as $item) {
                            $notice = Notices::Get($item);
                            if($core->security->CheckBatch($notice->createSecurityBathHierarchy("delete")))
                                $items[] = $notice;
                            else {
                                $error = true;
                                break;
                            }
                        }
                        
                        if(!$error) {
                            foreach($items as $notice)    
                                $notice->Delete();
                            $ret .= $this->DoPostBack("view", "get");
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                }
                break;
            }
            case "settings":
                if(!$core->security->Check(null, "settings.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                switch($this->command) {
                    case "message_ok":
                    case "view":
                        $this->Out("subtitle", $this->lang->tools_settings_view, OUT_AFTER);
                        $ret .= $this->ListSettings();
                        break;
                    case "remove":
                        $form = $this->post_vars("setting_id_");
                        $items = array();
                        $error = false;
                        $settings = $core->sts->get_collection();
                        foreach($form as $item) {
                            $setting = $settings->$item;
                            if($core->security->CheckBatch($setting->createSecurityBathHierarchy("delete")))
                                $items[] = $setting;
                            else {
                                $error = true;
                                break;
                            }
                        }
                        
                        if(!$error) {
                            foreach($items as $setting)
                                $core->sts->remove($setting->name);
                            $ret .= $this->DoPostBack("view", "get");
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                }
                break;

            case "statistics":
                if(!$core->security->Check(null, "statistics.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                
                $this->Out("subtitle", $this->lang->tools_statistics, OUT_AFTER);
                
                if($core->security->Check(null, "statistics.view"))
                    $ret .= $this->RenderStats();
                else
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                break;
            case "sitestats":
                if(!$core->security->Check(null, "statistics.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                switch ($this->command) {
                    case "clearstats":
                            if($core->security->Check(null, "statistics.clear")) {
                                $this->ClearSiteStats();
                                $ret .= $this->DoPostBack("view", "get");
                            }
                            else {
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                            }
                        break;
                    case "prev":
                    case "next":
                        $this->operation = $this->command;
                    case "view":
                    default:
                        if($core->security->Check(null, "statistics.view")) {

                            $today = time();
                            if(!is_null($this->today))
                                $today = $this->today;
                            if($this->operation == "next")
                                $today = $today+86400;
                            elseif($this->operation == "prev")
                                $today = $today-86400;

                            $ret .= $this->SetPostVar("today", $today);

                            $this->Out("subtitle", "Статистика сайта на период ".strftime("%Y/%m/%d", $today), OUT_AFTER);

                            $ret .= $this->RenderSiteStats($today); //$this->lang->tools_statistics_message;
                        }
                        else 
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        break;
                }
                break;
            case "access_log":
                if(!$core->security->Check(null, "statistics.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                switch($this->command) {
                    case "clear_access_log":
                        if($core->security->Check(null, "statistics.logs.clear"))
                            $ret .= $this->ClearAccessLog();
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        break;
                    case "view":
                    default:
                        
                        $this->Out("subtitle",$this->lang->tools_view_access_log, OUT_AFTER);
                    
                        if($core->security->Check(null, "statistics.logs.view"))
                            $ret .= $this->ViewAccessLog();
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        break;
                }
                break;
            case "error_log":
                if(!$core->security->Check(null, "statistics.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                switch($this->command) {
                    case "clear_error_log":
                        if($core->security->Check(null, "statistics.logs.clear"))
                            $ret .= $this->ClearErrorLog();
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        break;
                    case "view":
                    default:
                        
                        $this->Out("subtitle",$this->lang->tools_view_error_log, OUT_AFTER);
                        
                        if($core->security->Check(null, "statistics.logs.view"))
                            $ret .= $this->ViewErrorLog();
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        break;
                }
                break;
            case "modules" : 
                $this->Out("subtitle", $this->lang->tools_modules_text, OUT_AFTER);
                switch ($this->command){
                    case "listtemplates" :
                        $form = $this->post_vars("module_id_");
                        $modules = $core->mm->modules;
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, "Request error");
                        else {
                            $value = ($this->module_id != "") ? $this->module_id : $form->item(0);
                            $module = $modules->search($value, "id");
                            if (!$module)
                                $ret .= $this->ErrorMessage($this->lang->module_form_empty, $this->lang->modules_select_empty);
                            else
                                $ret .= $this->ListModuleTemplates($modules, $module);
                        }
                        break;
                    case "removetemplate":
                        $storage = new CModule($this->module_id);

                        $form = $this->post_vars("module_template_id_");
                        foreach($form as $item) {
                            $t = template::create($item, $storage);
                            $t->Delete();
                        }
                        $ret .= $this->SetPostVar("module_id", $storage->id);
                        $ret .= $this->DoPostBack('listtemplates', 'get');
                        break;
                    case "exportmodule":
                        $ret .= $this->SetPostVar("module_id", $this->module_id);
                        
                        $form = $this->post_vars("module_id_");
                        foreach($form as $id) {
                            $mod = new CModule($id);
                            $content = $mod->code;
                            $info = $this->checkSourceInFile($content);
                            if ($info->infile){
                                if ($info->content == -1)
                                    continue;
                                
                                $info->content = convert_string("UTF-8", $info->content);
                                $mod->code = $info->content;
                                $mod->Save();
                            } else {
                                $path = strtolower($this->IOPath()->modules.$mod->entry."_".str_replace(".", "_", $mod->version).".mod.php");
                                $mod->code = "LOADFILE:".$path;
                                if (is_empty($content))
                                    $content = "<"."?\n\t//модуле хранилища ".$mod->entry."_".str_replace(".", "_", $mod->version)."\n?".">";
                                
                                //$content = convert_string("utf-8", $content);
                                $success = true;
                                
                                if($success)
                                    $success = ($core->fs->writefile($path, $content) > 0);
                                
                                if($success) {
                                    $mod->save();
                                    @system("chmod 777 ".$core->fs->mappath($path));
                                }
                                else
                                    out("The file was not saved! Files: ".$path.", ".$path_css);
                            }
                        }
                        
                        $ret .= $this->DoPostBack('view', 'get');
                        
                        break;
                    case "exporttemplate":
                        
                        $storage = new CModule($this->module_id);
                        $ret .= $this->SetPostVar("module_id", $this->module_id);
                        
                        $form = $this->post_vars("module_template_id_");
                        foreach($form as $id) {
                            $t = $storage->templates->$id;
                            $content = $t->list;
                            $content_css = $t->styles;
                            $info = $this->checkSourceInFile($content);
                            $info_css = $this->checkSourceInFile($content_css);
                            if ($info->infile){
                                if ($info->content == -1)
                                    continue;
                                
                                $info->content = convert_string("UTF-8", $info->content);
                                $info_css->content = convert_string("UTF-8", $info_css->content);
                                $t->list = $info->content;
                                $t->styles = $info_css->content;
                                $t->Save();
                            } else {
                                $mod = $t->Storage();
                                $path = strtolower($this->IOPath()->templates.'modules/'.$mod->entry."/".$t->name.".tpl.php");
                                $path_css = strtolower($this->IOPath()->templates.'modules/'.$mod->entry."/".$t->name.".tpl.css");
                                $t->list = "LOADFILE:".$path;
                                $t->styles = "LOADFILE:".$path_css;
                                if (is_empty($content))
                                    $content = "<"."?\n\t//шаблон хранилища ".$t->name."\n?".">";
                                if (is_empty($content_css))
                                    $content_css = "/* стилевой файл для шаблона ".$t->name."*/";
                                
                                //$content = convert_string("utf-8", $content);
                                $success = true;
                                
                                if(!$core->fs->DirExists(strtolower($this->IOPath()->templates.'modules'))) {
                                    $success = $core->fs->CreateDir(strtolower($this->IOPath()->templates.'modules'));
                                }
                                    
                                if(!$core->fs->DirExists(strtolower($this->IOPath()->templates.'modules/'.$mod->entry))) {
                                    $success = $core->fs->CreateDir(strtolower($this->IOPath()->templates.'modules/'.$mod->entry));
                                }
                                    
                                if($success)
                                    $success = ($core->fs->writefile($path, $content) > 0);
                                if($success)
                                    $success = ($core->fs->writefile($path_css, $content_css) > 0);
                                
                                if($success) {
                                    $t->save();
                                    @system("chmod 777 ".$core->fs->mappath($path));
                                    @system("chmod 777 ".$core->fs->mappath($path_css));
                                }
                                else
                                    out("The file was not saved! Files: ".$path.", ".$path_css);
                            }
                        }
                        
                        $ret .= $this->DoPostBack('listtemplates', 'get');
                     
                    case "message_cancel" :
                    case "message_ok" :
                    case "view" :
                        $ret .= $this->RenderModulesList();
                        break;
                    case "state" :
                        $ret .= $this->ActionModuleChangeState();
                        break;
                    case "remove" :
                        $ret .= $this->ActionModuleRemove();
                        break;
                    case "moveup" :
                        $ret .= $this->ActionModuleChangeOrder(MOVEUP);
                        break;
                    case "movedown" :
                        $ret .= $this->ActionModuleChangeOrder(MOVEDOWN);
                        break;
                    case "dumpscript":
                    
                        $script = '<'.'?'.
                                  "\n\n".
                                  '/* Dumping modules */'.
                                  "\n\n";
                        $form = $this->post_vars("module_id_");
                        foreach($form as $item) {
                            // $s = new Storage($item);
                            $mod = new CModule($item);
                            $script .= $mod->ToPHPScript();
                        }

                        $script .= "\n\n".'?'.'>';
                        
                        $ret .= '<textarea style="width: 100%; height: 400px;">'.$script.'</textarea>';
                        
                        break;
                        
                    default : 
                        break;
                }
                break;
            case "blobs": {
                if(!$core->security->Check(null, "blobs.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }
                
                switch($this->command) {
                    
                    case "message_ok":
                    case "view": 
                        $this->Out("subtitle", $this->lang->tools_blobmanager_text, OUT_AFTER);
                        $ret .= $this->RenderBlobManager();
                        break;
                    case "content":
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
                                $ret .= $this->SetPostVar("bc_id", $bc);
                                if($bc == -1)
                                    $this->Out("subtitle", $this->lang->tools_blobs_category_content_nocategory, OUT_AFTER);
                                else {
                                    
                                    $b = new BlobCategory(intval($bc));
                                    $this->Out("subtitle", $this->lang->tools_blobs_category_content."[".$b->description."]", OUT_AFTER);
                                }
                                $ret .= $this->BrowseCategoryBlobs(intval($bc));
                            }
                        }
                        break;
                    case "remove":
                        $form = $this->post_vars("category_id_");
                        if($form->count() == 0)
                            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                        else {
                            foreach($form as $id) {
                                $cat = new BlobCategory(intval($id));
                                $cat->Delete();
                            }
                            $ret .= $this->DoPostBack("view", "get");
                        }
                        break;
                    case "removeresource":
                        $form = $this->post_vars("blob_id_");
                        if($form->count() == 0)
                            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                        else {
                            foreach($form as $item) {
                                $b = new Blob(intval($item));
                                $b->Delete();
                            }

                            $ret .= $this->SetPostVar("bc_id", $this->bc_id);
                            $ret .= $this->DoPostBack("content", "get");
                        }
                        break;
                }
                break;
            }
            case "script": {
                
                switch($this->command) {
                    case "view":
                        
                        if($core->security->currentUser->isSupervisor()) {
                            
                            $toolbar = new Toolbar($this);
                            $toolbar->Buttons->Add(new ToolbarImageButton('exec', 'iconpack(recompile)', $this->lang->toolbar_exec, TOOLBAR_BUTTON_LEFT, 'exec', 'post'));
                            $toolbar->Render("toolbar");
                            
                            $cmd = new CommandBar($this);
                            $cmd->Render("toolbar_bottom");
                            
                            $ret .= $this->RenderFormHeader();
                            $ret .= $this->RenderFormRow($this->lang->script_text, "script", $this->script, false, null, "memo", false, "code", "width:100%; height: 400px;");
                            $ret .= $this->RenderFormFooter();
                            
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                    
                        break;
                    case "exec":
                    
                        $toolbar = new Toolbar($this);
                        $toolbar->Buttons->Add(new ToolbarImageButton('back', 'iconpack(go_back)', $this->lang->toolbar_back, TOOLBAR_BUTTON_RIGHT, 'view', 'post'));
                        $toolbar->Render("toolbar");
                    
                        $ret .= $this->SetPostVar("script", $this->script);
                        $ret .= '<div style="width: 100%; height: 400px; overflow: auto; border: 1px solid #c0c0c0;">';
                        $script = $this->script;
                        //$core->dbe->StartTrans();
                        eval(convert_php($script));
                        //$core->dbe->CompleteTrans();
                        $ret .= '</div>';
                        break;
                }
                
                break;
            }
        }
        return $ret;
    }

    public function MenuVisible() {
        return true;
    }

    function ListModuleTemplates($modules, $module){
        $ret = "";

        // $pt = new Templates($module, TEMPLATE_MODULE);
        $templates = $module->templates;

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton('add', 'iconpack(template_add)', $this->lang->toolbar_addtemplate, TOOLBAR_BUTTON_LEFT, 'addtemplate', 'post', 'editor', 'storages', null, 700, 520, false));
        $toolbar->Buttons->Add(new ToolbarImageFButton('edit', 'iconpack(template_edit)', $this->lang->toolbar_addtemplate, TOOLBAR_BUTTON_LEFT, 'edittemplate', 'post', 'editor', 'storages', null, 700, 520, false));
        $toolbar->Buttons->Add(new ToolbarImageButton('delete', 'iconpack(template_delete)', $this->lang->toolbar_addtemplate, TOOLBAR_BUTTON_LEFT, 'removetemplate', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageButton("export", 'iconpack(export)', $this->lang->toolbar_export, TOOLBAR_BUTTON_LEFT, 'exporttemplate', 'post', null, null, $this->lang->toolbar_exportmessage));
        $toolbar->Buttons->Add(new ToolbarSeparator('separator2'));
        $toolbar->Buttons->Add(new ToolbarImageButton('back', 'iconpack(go_back)', $this->lang->toolbar_addtemplate, TOOLBAR_BUTTON_RIGHT, 'view', 'get'));
        $toolbar->Render("toolbar");
        
        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");

        $ret .= $this->SetPostVar('module_id', $module->id);
        $ret .= $this->SetPostVar('template_type', "module");

        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->development_name,
                $this->lang->in_file
        ), true, true, null, array(null, 350));
        
        foreach ($templates as $tpl){
            $state = $this->checkSourceInFile($tpl->list);
            $state_css = $this->checkSourceInFile($tpl->styles);
            $ret .= $this->RenderContentTableContentRow(
                "iconpack(template)", 
                array(
                    is_empty($tpl->description) ? $tpl->name : $tpl->description.'('.$tpl->name.')',
                    null
                ), 
                "javascript: setCheckbox('module_template_id_".$tpl->name."'); PostBackToFloater('edittemplate', 'post', 'editor', 'storages', null, null, 700, 520, true);", 
                array(
                    $state->path."<br />".$state_css->path
                ), 
                $hasCheckbox = true, 
                $tpl->name, 
                "module_template_id_");
        }
        $ret .= $this->RenderContentTableFooter();
        return $ret;
    }
    
    function RenderModulesList($message = ""){
        global $core;
        
        $ret = "";
        
        $ret .= "<input type=\"hidden\" name=\"module_id\" id=\"module_id\" value=\"\">";
        $ret .= "<input type=\"hidden\" name=\"module_state\" id=\"module_state\" value=\"\">";
        
        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->development_name, 
                $this->lang->modules_version_text,
                "&nbsp;",
                $this->lang->in_file
        ), true, true, null, array(null, null, null, 350));
        
        $modules = $core->mm->modules;
        
        $user = $core->security->currentUser;
        
        /*    SPAWN COMMENTS LINES 686 - 687, 690 - 691 
            поменять $core->sr на $core->security ... понятие суперюзера ушло так что провять надо права
        */
        $toolbar = new Toolbar($this);
        
        // if ($core->sr->is_supervisor($user))
            $toolbar->Buttons->Add(new ToolbarImageFButton("add", "iconpack(module_new)", $this->lang->toolbar_add, TOOLBAR_BUTTON_LEFT, "add", "post", "editor", 'modules', null, 800, 600, true));
            
        if ($modules){
            // if ($core->sr->is_supervisor($user))
                $toolbar->Buttons->Add(new ToolbarImageFButton("edit", "iconpack(module_edit)", $this->lang->toolbar_edit, TOOLBAR_BUTTON_LEFT, "edit", "post", "editor", 'modules', null, 800, 600, true));
            
            $toolbar->Buttons->Add(new ToolbarImageButton("remove", "iconpack(module_delete)", $this->lang->toolbar_remove, TOOLBAR_BUTTON_LEFT, "remove", "post", null, null, $this->lang->toolbar_removemessage));
            $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
            $toolbar->Buttons->Add(new ToolbarImageButton("state", "iconpack(module_change_state)", $this->lang->toolbar_changestate, TOOLBAR_BUTTON_LEFT, "state", "post"));
            $toolbar->Buttons->Add(new ToolbarImageButton("moveup", "iconpack(module_up)", $this->lang->toolbar_moveup, TOOLBAR_BUTTON_LEFT, "moveup", "post"));
            $toolbar->Buttons->Add(new ToolbarImageButton("movedown", "iconpack(module_down)", $this->lang->toolbar_movedown, TOOLBAR_BUTTON_LEFT, "movedown", "post"));
            $toolbar->Buttons->Add(new ToolbarSeparator("separator2"));
            $toolbar->Buttons->Add(new ToolbarImageButton("to_file", 'iconpack(export)', $this->lang->toolbar_export, TOOLBAR_BUTTON_LEFT, 'exportmodule', 'post', null, null, $this->lang->toolbar_exportmessage));
            $toolbar->Buttons->Add(new ToolbarSeparator('separator3'));
            $toolbar->Buttons->Add(new ToolbarImageButton("listtemplates", "iconpack(edit_templates)", $this->lang->toolbar_modules_listtemplates, TOOLBAR_BUTTON_LEFT, "listtemplates", "get"));
            $toolbar->Buttons->Add(new ToolbarSeparator('separator3'));
            $toolbar->Buttons->Add(new ToolbarImageButton("dumpscript", "iconpack(module_export)", $this->lang->toolbar_modules_dumpscript, TOOLBAR_BUTTON_LEFT, "dumpscript", "get"));
        }
        
        //$toolbar->Buttons->Add(new ToolbarSeparator("separator3"));
        //$toolbar->Buttons->Add(new ToolbarImageFButton("import", "iconpack(module_import)", $this->lang->toolbar_modules_import, TOOLBAR_BUTTON_LEFT, "import", "post", "editor", 'modules', null, 350, 300, true));
        //$toolbar->Buttons->Add(new ToolbarImageFButton("export", "iconpack(module_export)", $this->lang->toolbar_modules_export, TOOLBAR_BUTTON_LEFT, "export", "post", "editor", 'modules', null, 800, 600, true));
        
        $toolbar->Render("toolbar");
        
        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");
        
        
        //$this->lang->modules_version_info.$mod->module_compat
        if (!$modules)
            return "<h5>".$this->lang->modules_non_exists."</h5>";
        
        foreach ($modules as $mod){
            $state = $this->checkSourceInFile($mod->code);
            //$img = (($mod->state == MODULE_ENABLED) || ($mod->state == MODULE_INSTALLED)) 
            $img = ($mod->state == MODULE_ENABLED)
                ? $this->iconpack->CreateIconImage("iconpack(module_enabled)", "", 24, 24) : "&nbsp;";
            $ret .= $this->RenderContentTableContentRow(
                "iconpack(module)", 
                array(
                    $mod->title,
                    $mod->description
                ), 
                "javascript: setCheckbox('module_id_".@$mod->id."'); PostBack('browse', 'get');", 
                array(
                    $mod->version, 
                    $img,
                    $state->path
                ), 
                $hasCheckbox = true, 
                $mod->id, 
                "module_id_", 0, false);
        }
        
        $ret .= $this->RenderContentTableFooter();
        
        return $ret;
    }
    
    function ActionModuleChangeState(){
        global $core;
        
        $ret = "";
        
        $id = $this->post_vars("module_id_");
        
        if (!($id instanceof collection))
            $id = Collection::create($id);
        
        /*
        out(4 >> 1, 8 >> 2)
        
        out(MODULE_DISABLED | MODULE_INSTALLED, 
            (MODULE_DISABLED | MODULE_INSTALLED) ^ MODULE_DISABLED, 
            (MODULE_DISABLED | MODULE_INSTALLED) & MODULE_INSTALLED);
        out(MODULE_DISABLED | MODULE_ENABLED, 
            (MODULE_DISABLED | MODULE_ENABLED) ^ MODULE_DISABLED, 
            (MODULE_DISABLED | MODULE_ENABLED) & MODULE_ENABLED);
        */
            
        foreach ($id as $i){
            $mod = new CModule($i);
            switch ($mod->state){
                /*case MODULE_CREATED :
                    $mod->state = MODULE_INSTALLED;
                    break;*/
                case MODULE_CREATED :
                    $mod->state = MODULE_ENABLED;
                    break;
                case MODULE_DISABLED :
                    $mod->state = MODULE_ENABLED;
                    break;
                case MODULE_ENABLED :
                    $mod->state = MODULE_DISABLED;
                    break;
                /*case MODULE_INSTALLED :
                    $mod->state = MODULE_DISABLED | MODULE_INSTALLED;
                    break;
                case (MODULE_DISABLED | MODULE_INSTALLED) :
                    $mod->state = (MODULE_DISABLED | MODULE_INSTALLED) ^ MODULE_DISABLED;
                    break;*/
                default :
                    break;
            }
            $mod->Save();
        }
        
        $ret .= $this->doPostBack("view");
        
        return $ret;
    }
    
    function ActionModuleRemove(){
        $ret = "";
        
        $id = $this->post_vars("module_id_");
        
        foreach ($id as $i)
            $inst = CModuleManager::Uninstall($i);
            
        $ret .= $this->doPostBack("view");
        
        return $ret;
    }
    
    function ActionModuleChangeOrder($mode){
        global $core;
        
        $ret = "";
        
        $id = $this->post_vars("module_id_");
        
        if (!($id instanceof collection))
            $id = Collection::create($id);
        
        $modules = $core->mm->modules;
        
        switch ($mode){
            case MOVEUP :
                foreach ($id as $i){
                    $t = $modules->search($i, "id");
                    $friend = "";
                    foreach ($modules as $mod)
                        if ($mod->order == $t->order - 1){
                            $friend = $mod->entry;
                            break;
                        }
                    if ($friend == "")
                        continue;
                        
                    $oo = $t->order;
                    $t->order = $modules->$friend->order;
                    $modules->$friend->order = $oo;
                    $t->Save();
                    $modules->$friend->Save();
                }
                break;
            case MOVEDOWN : 
                $count = $id->Count();
                for ($j = $count - 1; $j > -1; $j--){
                    $i = $id->item($j);
                    $t = $modules->search($i, "id");
                    
                    $friend = "";
                    foreach ($modules as $mod)
                        if ($mod->order == $t->order + 1){
                            $friend = $mod->entry;
                            break;
                        }
                    if ($friend == "")
                        continue;
                    
                    $oo = $t->order;
                    $t->order = $modules->$friend->order;
                    $modules->$friend->order = $oo;
                    $t->Save();
                    $modules->$friend->Save();
                }
                break;
            default :
                break;
        }
        
        return $ret .= $this->doPostBack("view");
    }

    function RenderSystemRestore($rp) {
        global $SITE_PATH;
        $logpath = $SITE_PATH."cron/log";
        $command = "crontab -l > ".$logpath;
        $scroncontent = @file_get_contents($logpath);
        
        $c = 0;
        if(strlen(trim($scroncontent)) == 0) {
        }
        else if(substr($scroncontent, 0, strlen("2-8 23 * * *")) == "2-8 23 * * *") {
            $c = 1;
        }
        else if(substr($scroncontent, 0, strlen("2-8 * * * 0")) == "2-8 * * * 0") {
            $c = 2;
        }
        else if(substr($scroncontent, 0, strlen("2-8 * */30 * *")) == "2-8 * */30 * *") {
            $c = 3;
        }

        $ret = "<div class='font12'>";
        $ret .= $this->lang->tools_system_restore_message;
        $ret .= "<p>";
        $ret .= "<input type=submit name=export value='".$this->lang->createpoint."' class='command-button' onclick=\"return PostBack('create', 'post');\">";
        $ret .= "<p>";
        $ret .= "<div class='font14 margin4bottom'><strong>".$this->lang->tools_restoremyrac."</strong></div>";
        $files = $rp->listPoints("file_name", SORT_DESC);
        $ret .= "<select name=resporepoint class=select-box>";
        $ret .= "<option value=''>".$this->lang->tools_select_restorepoint."</option>";
        foreach($files as $file) {
            $srpname = $file->file_name;
            $t = @str2date($srpname);
            $isarch = $file->file_ext != "gz" ? " (expanded)" : "";
            if($t) {
                $ret .= "<option value='".$file->file."'>".strftime("%d-%m-%Y %H:%M:%S", $t).$isarch."</option>";
            }
            else {
                if($file->file_ext != "gz")
                    $srpname .= " (expanded)";
                $ret .= "<option value='".$file->file."'>".$srpname."</option>";
            }
        }
        $ret .= "</select><p>";
        $ret .= "<input type=submit name=import value='".$this->lang->restorerac."' class='command-button' onclick=\"return PostBack('restore', 'post');\"><br>";
        $ret .= "
            <br />
            <hr>
            <span class='action-subtitle'>".$this->lang->tools_cron_setscheduler."</span><br />
            ".$this->lang->tools_cron_setscheduler_desc."
            <br />
            <br />
            <table class='content-table'>
            <tr>
            <td>
            <select name='cron' style='width:320px;'>
                <option value='0' ".($c == 0 ? "selected" : "").">-- Delete current (if exists)</option>            
                <option value='1' ".($c == 1 ? "selected" : "").">Set dayly</option>
                <option value='2' ".($c == 2 ? "selected" : "").">Set weekly</option>
                <option value='3' ".($c == 3 ? "selected" : "").">Set mountly</option>
            </select>
            </td>
            </tr>
            <tr>
            <td width='50'>
            <input type=submit name=scheduler value='".$this->lang->save."' class='command-button' onclick=\"return PostBack('setschedule', 'post');\">
            </td>
            </tr>
            </table>
            </div>
        ";
        return $ret;
    }

    function ListSettings() {
        global $core;
        
        $ret = "";

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", "iconpack(gear_add)", $this->lang->toolbar_add, TOOLBAR_BUTTON_LEFT, "add", "post", 'editor', 'settings', null, 700, 500, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("edit", "iconpack(gear_edit)", $this->lang->toolbar_edit, TOOLBAR_BUTTON_LEFT, "edit", "post", 'editor', 'settings', null, 700, 500, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("remove", "iconpack(gear_delete)", $this->lang->toolbar_remove, TOOLBAR_BUTTON_LEFT, "remove", "post", null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageFButton('permissions', 'iconpack(gear_permissions)', $this->lang->toolbar_permissions, 'set_permissions', 'post', 'editor', 'settings', null, 800, 600, false));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");
        
        $categories = $core->sts->get_categories();
        foreach($categories as $category) {
            

            $sets = $core->sts->get_collection($category);

            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    $category,
                    "",
                    ""
            ), true, true, '&nbsp;', null, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', ($category == "User settings" ? "expanded" : "collapsed") ));
            foreach($sets as $k => $v) {
                $ret .= $this->RenderContentTableContentRow(
                    "iconpack(setting)", 
                    array(
                        $v->setting_name.($v->is_system ? CONTROL_REQUIRED : ""),
                        null
                    ), 
                    "javascript: setCheckbox('setting_id_".$v->setting_name."'); PostBackToFloater('edit', 'post', 'editor', 'settings', null, null, 700, 500, true);", 
                    array(
                        $v->setting_type,
                        str_trim_length(html_encode_tags($v->setting_value), 140)
                    ), 
                    true, 
                    $v->setting_name, 
                    "setting_id_", 0, true, array(250, 50, "auto"));
            }
            $ret .= $this->RenderContentTableFooter();
        }
        return $ret;
    }

    function ListNotices() {
        $ret = "";


        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", "iconpack(notice_add)", $this->lang->toolbar_add, TOOLBAR_BUTTON_LEFT, "add", "post", 'editor', 'notices', null, 700, 670, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("edit", "iconpack(notice_edit)", $this->lang->toolbar_edit, TOOLBAR_BUTTON_LEFT, "edit", "post", 'editor', 'notices', null, 700, 670, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("remove", "iconpack(notice_delete)", $this->lang->toolbar_remove, TOOLBAR_BUTTON_LEFT, "remove", "post", null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageFButton('permissions', 'iconpack(notice_permissions)', $this->lang->toolbar_permissions, 'set_permissions', 'post', 'editor', 'notices', null, 800, 600, false));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");

        $nl = Notices::Enumerate();

        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->tools_notice_keyword,
                $this->lang->tools_notice_encoding,
                $this->lang->tools_notice_subject
        ), true, true);
        foreach($nl as $n) {
            $ret .= $this->RenderContentTableContentRow(
                "iconpack(notice)", 
                array(
                    $n->keyword,
                    null
                ), 
                "javascript: setCheckbox('notice_id_".$n->id."'); PostBackToFloater('edit', 'post', 'editor', 'notices', null, null, 700, 670, true);", 
                array(
                    $n->encoding,
                    $n->subject
                ), 
                $hasCheckbox = true, 
                $n->id, 
                "notice_id_");
        }
        $ret .= $this->RenderContentTableFooter();

        return $ret;
    }
    
    function RenderSiteStats($dttoday = null) {
        global $core, $INDEX_ANALIZESEARCHQUERIES;
        
        
        $date = time();
        if(!is_null($dttoday))
            $date = $dttoday;

        $core->stats->ArchiveAll();

        $stats = $core->stats->GetStatsArchive($date);

        $week = $core->stats->GetStats($date, STATS_LASTWEEK);
        $month = $core->stats->GetStats($date, STATS_LASTMONTH);
        $today = @$stats->daystats;

        $ystats = $core->stats->GetStatsArchive($date-86400);
        $yesterday = @$ystats->daystats;
        
        $todayPages = @$stats->pages;
        $todayDomains = @$stats->domains;
        $todayBrowsers = @$stats->browsers;
        $todayOS = @$stats->os;
        $todayRegions = @$stats->regions;
        $todaySearch = null;
        if($INDEX_ANALIZESEARCHQUERIES) $todaySearch  = @$stats->search;
        
          $ret = $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                "",
                "Сегодня(Боты)",
                "Вчера(Боты)",
                "За 7 дней(Боты)",
                "За 30 дней(Боты)"
        ),false, true, "&nbsp;", 
        array(
                "100%",
                "120",
                "120",
                "120",
                "120"
            ));
        
        $ret .= $this->RenderContentTableContentRow(
            null, 
            array(
                "Хитов"
            ), 
            null,
            array(                                   
                @$today->hits." (".@$today->bots->hits.")",
                @$yesterday->hits." (".@$yesterday->bots->hits.")" ,
                @$week->hits." (".@$week->bots->hits.")",
                @$month->hits." (".@$month->bots->hits.")"
            ), 
            false);
        $ret .= $this->RenderContentTableContentRow(
            null, 
            array(
                "Хостов"
            ), 
            null,
            array(                                   
                @$today->hosts." (".@$today->bots->hosts.")",
                @$yesterday->hosts." (".@$yesterday->bots->hosts.")",
                @$week->hosts." (".@$week->bots->hosts.")",
                @$month->hosts." (".@$month->bots->hosts.")"
            ), 
            false);
        $ret .= $this->RenderContentTableContentRow(
            null, 
            array(
                "Сессий"
            ), 
            null,
            array(                                   
                @$today->sessions." (".@$today->bots->sessions.")",
                @$yesterday->sessions." (".@$yesterday->bots->sessions.")",
                @$week->sessions." (".@$week->bots->sessions.")",
                @$month->sessions." (".@$month->bots->sessions.")"
            ), 
            false);
        
        
        $ret .= $this->RenderContentTableContentEmptyRow("", 4, false, true);
        $ret .= $this->RenderContentTableFooter();
        
        if(!is_null($todayPages)) {
            $currentSite = -1;
            foreach($todayPages as $td) {
                
                if($currentSite != $td->stats_site) {
                    $s = Site::Fetch($td->stats_site);
                    $ret .= $this->RenderContentTableHeader();
                    $ret .= $this->RenderContentTableHeaderRow(array(
                            "Просмотр по страницам: ".$s->description." (".$s->domain.")",
                            "Хитов",
                            "Хостов",
                            "Сессий"
                    ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
                    array(
                            "100%",
                            "80",
                            "80",
                            "80"
                        ));        
                    $currentSite = $td->stats_site;
                }

                $f = Site::Fetch($td->stats_folder);
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        !is_null($f) ? ($s->name == $f->name ? "/" : $f->description." (".$f->Url().")") : "Удален"
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
                    
            $ret .= $this->RenderContentTableFooter();            
        }
        
        
        if(!is_null($todayDomains)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по доменам",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayDomains as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_referer_domain == "" ? "По прямому адресу" : '<a href="http://'.$td->stats_referer_domain.'" target="_blank">'.$td->stats_referer_domain.'</a>'
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }
        
        if(!is_null($todayBrowsers)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по типу браузера",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayBrowsers as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_browser == "" ? "Неизвестен" : $td->stats_browser
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }
        
        if(!is_null($todayOS)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по операционной системе",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayOS as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_os == "" ? "Неизвестна" : $td->stats_os
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }        
        
        if(!is_null($todayRegions)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по операционной регионам",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayRegions as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_country_name == "" ? "Неизвестна" : $td->stats_country_name."(".$td->stats_country_code.")"
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }
    
        if(!is_null($todaySearch)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Поисковые запросы",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todaySearch as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_querystring == '' ? "пустой запрос" :  urldecode(substr($td->stats_querystring, 2))
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageButton("clear", "iconpack(sitestats_clear)", $this->lang->toolbar_clear, TOOLBAR_BUTTON_LEFT, "clearstats"));
        $toolbar->Buttons->Add(new ToolbarImageButton("prev", "iconpack(sitestats_prev)", $this->lang->toolbar_prev, TOOLBAR_BUTTON_LEFT, "prev", "get"));
        $toolbar->Buttons->Add(new ToolbarImageButton("next", "iconpack(sitestats_next)", $this->lang->toolbar_next, TOOLBAR_BUTTON_LEFT, "next", "get"));
        $toolbar->Render("toolbar");

        $control1 = new DateTimeExControl("today", $date, false);
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->filter_title));
        $cmd->Containers->Add(new CommandBarContainer("today", $control1->Render()));
        $cmd->Containers->Add(new CommandBarButtonContainer("filterGo", "submit", $this->lang->filter_go, "browse"));
        $cmd->Render("toolbar_bottom");


        return $ret;
    }
    
    function RenderStats() {
        $ret = "";
        $tc = 0;
        $ftwt = 0;
        $trt = 0;

        $pbc = 0;
        $pml = 0;
        $prt = 0;

        $sc = 0;
        $stl = "";
        $grps = "";
        $usrs = "";


        $this->TreeInfo($tc, $ftwt, $trt);

        $this->PublicationInfo($pbc, $pml, $prt);

        $this->StoragesInfo($sc, $stl);

        $s = "";
        $s = sprintf($this->lang->tools_statistics_info, $tc, $ftwt, $trt, $pbc, $pml, $prt, $sc, $stl);

        $ret .= $s;
        return $ret;
    } 

    function ClearSiteStats() {
        global $core;
        $core->stats->Clear();
    }


    /*function RenderSiteStats($dttoday = null) {
        global $core;
        
        
        $date = time();
        if(!is_null($dttoday))
            $date = $dttoday;

        $core->stats->ArchiveAll();


        $stats = $core->stats->GetStatsArchive($date);

        $week = $core->stats->GetStats($date, STATS_LASTWEEK);
        $month = $core->stats->GetStats($date, STATS_LASTMONTH);
        
        $today = $stats->daystats;

        $ystats = $core->stats->GetStatsArchive($date-86400);
        $yesterday = @$ystats->daystats;
        
        $todayPages = @$stats->pages;
        $todayDomains = @$stats->domains;
        $todayBrowsers = @$stats->browsers;
        $todayOS = @$stats->os;
        $todayRegions = @$stats->regions;
        
          $ret = $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                "",
                "Сегодня(Боты)",
                "Вчера(Боты)",
                "За 7 дней(Боты)",
                "За 30 дней(Боты)"
        ),false, true, "&nbsp;", 
        array(
                "100%",
                "120",
                "120",
                "120",
                "120"
            ));
        
        $ret .= $this->RenderContentTableContentRow(
            null, 
            array(
                "Хитов"
            ), 
            null,
            array(                                   
                @$today->hits." (".@$today->bots->hits.")",
                @$yesterday->hits." (".@$yesterday->bots->hits.")" ,
                @$week->hits." (".@$week->bots->hits.")",
                @$month->hits." (".@$month->bots->hits.")"
            ), 
            false);
        $ret .= $this->RenderContentTableContentRow(
            null, 
            array(
                "Хостов"
            ), 
            null,
            array(                                   
                @$today->hosts." (".@$today->bots->hosts.")",
                @$yesterday->hosts." (".@$yesterday->bots->hosts.")",
                @$week->hosts." (".@$week->bots->hosts.")",
                @$month->hosts." (".@$month->bots->hosts.")"
            ), 
            false);
        $ret .= $this->RenderContentTableContentRow(
            null, 
            array(
                "Сессий"
            ), 
            null,
            array(                                   
                @$today->sessions." (".@$today->bots->sessions.")",
                @$yesterday->sessions." (".@$yesterday->bots->sessions.")",
                @$week->sessions." (".@$week->bots->sessions.")",
                @$month->sessions." (".@$month->bots->sessions.")"
            ), 
            false);
        
        
        $ret .= $this->RenderContentTableContentEmptyRow("", 4, false, true);
        $ret .= $this->RenderContentTableFooter();
        
        if(!is_null($todayPages)) {
            $currentSite = -1;
            foreach($todayPages as $td) {
                
                if($currentSite != $td->stats_site) {
                    $s = Site::Fetch($td->stats_site);
                    $ret .= $this->RenderContentTableHeader();
                    $ret .= $this->RenderContentTableHeaderRow(array(
                            "Просмотр по страницам: ".$s->description." (".$s->domain.")",
                            "Хитов",
                            "Хостов",
                            "Сессий"
                    ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
                    array(
                            "100%",
                            "80",
                            "80",
                            "80"
                        ));        
                    $currentSite = $td->stats_site;
                }

                $f = Site::Fetch($td->stats_folder);
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        !is_null($f) ? ($s->name == $f->name ? "/" : $f->description." (".$f->Url().")") : "Удален"
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
                    
            $ret .= $this->RenderContentTableFooter();            
        }
        
        
        if(!is_null($todayDomains)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по доменам",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayDomains as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_referer_domain == "" ? "По прямому адресу" : '<a href="http://'.$td->stats_referer_domain.'" target="_blank">'.$td->stats_referer_domain.'</a>'
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }
        
        if(!is_null($todayBrowsers)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по типу браузера",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayBrowsers as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_browser == "" ? "Неизвестен" : $td->stats_browser
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }
        
        if(!is_null($todayOS)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по операционной системе",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayOS as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_os == "" ? "Неизвестна" : $td->stats_os
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }        
        
        if(!is_null($todayRegions)) {
            $ret .= "<br />";
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    "Просмотр по операционной регионам",
                    "Хитов",
                    "Хостов",
                    "Сессий"
            ),false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed") , 
            array(
                    "100%",
                    "80",
                    "80",
                    "80"
                ));        
            
            foreach($todayRegions as $td) {
                $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $td->stats_country_name == "" ? "Неизвестна" : $td->stats_country_name."(".$td->stats_country_code.")"
                    ), 
                    null,
                    array(                                   
                        $td->hits,
                        $td->hosts,
                        $td->sessions,
                    ), 
                    false);
            }
            $ret .= $this->RenderContentTableFooter();            
        }
    
        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageButton("clear", "iconpack(sitestats_clear)", $this->lang->toolbar_clear, TOOLBAR_BUTTON_LEFT, "clearstats"));
        $toolbar->Buttons->Add(new ToolbarImageButton("prev", "iconpack(sitestats_prev)", $this->lang->toolbar_prev, TOOLBAR_BUTTON_LEFT, "prev", "get"));
        $toolbar->Buttons->Add(new ToolbarImageButton("next", "iconpack(sitestats_next)", $this->lang->toolbar_next, TOOLBAR_BUTTON_LEFT, "next", "get"));
        $toolbar->Render("toolbar");

        $control1 = new DateTimeExControl("today", $date, false);
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->filter_title));
        $cmd->Containers->Add(new CommandBarContainer("today", $control1->Render()));
        $cmd->Containers->Add(new CommandBarButtonContainer("filterGo", "submit", $this->lang->filter_go, "browse"));
        $cmd->Render("toolbar_bottom");


        return $ret;
    }*/

    function RecurseTreeInfoSite($sf) {
        $folders = $sf->Children();
        foreach($folders as $folder) {
            $this->RecurseTreeInfoSite($folder);
        }

    }

    function TreeInfo(&$tc, &$ftwt, &$trt) {
        /*ftwt & tc*/
        $t = Site::EnumTree();
        $tm = microtime();
        foreach($t as $s) {$tc++;}
        $ftwt = round(abs(microtime() - $tm)*1000, 3); // ms
        unset($t);


        /*recurcing*/
        $trt = microtime();
        $sites = Site::EnumSites();
        foreach($sites as $site) {
            $this->RecurseTreeInfoSite($site);
        }
        $trt = round(abs(microtime() - $trt)*1000, 3); //ms

        return;
    }


    function RecursePublication($p, &$level) {
        if($level > 10)
            return;
        $pubs = $p->Publications();
        if($pubs->Count() > 0) {
            $level += 1;
            while($pub = $pubs->FetchNext()) {
                $this->RecursePublication($pub, $level);
            }
        }
    }

    function PublicationInfo(&$pbc, &$pml, &$prt) {
        global $core;
        
        $r = $core->dbe->ExecuteReader("select count(*) as c from sys_links");
        $pbc = $r->Read()->c;
        unset($r);
        $prt = microtime();
        $pml = 0;

        $r = $core->dbe->ExecuteReader("select * from sys_links where link_parent_storage_id=0 order by link_order", "link_id");
        while($link = $r->Read()) {
            $level = 1;
            $p = new Publication($link, null);
            $this->RecursePublication($p, $level);
            if($level > $pml)
                $pml = $level;
        }
        $prt = round(abs(microtime() - $prt)*1000, 3); //ms
        return;
    }

    function StoragesInfo(&$sc, &$stl) {
        global $core;
        
        $strgs = storages::enum();
        $sc = $strgs->count();
        $stl .= "";
        foreach($strgs as $storage) {
            $dtr = new DataRows($storage);
            $dtr->Load();

            $c = $storage->templates->count();

            $t = 0;
            if($dtr->Count() > 0) {
                $t = microtime();
                while($dt = $dtr->FetchNext()) {}
                $t = round(abs(microtime() - $t)*1000, 3);
            }

            $stl .= "<tr><td style='padding:5px;' class='value'><b>".$storage->name." (".$storage->table.")</b></td><td align=right style='padding:5px;' class='value'>".$storage->fields->count()."</td><td align=right style='padding:5px;' class='value'>".$dtr->Count()."</td><td align=right style='padding:5px;' class='value'>".$c."</td><td align=right style='padding:5px;' class='value'>".$t."</td></tr>"; // <td align=right style='padding:5px;' class='value'>".$info->Data_length."</td>
        }
        $stl .= "</table>";

    }
    
    function ViewAccessLog() {
        global $ACCESS_LOG;
        $logDevice = new LogParser($ACCESS_LOG, ACCESS_LOG);
        $log = $logDevice->Parse("client");
        $ret = "";

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageButton("clear_access_log", "iconpack(folder_delete)", $this->lang->toolbar_remove, TOOLBAR_BUTTON_LEFT, "clear_access_log", "get", null, null, $this->lang->toolbar_removemessage));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");
        
        
        if($log->Count() > 0) {
            foreach($log as $client => $accesses) {
                
                $hostname = gethostbyaddr($client);
                $geo = Geo::CountryByIP($client);
                $ret .= $this->RenderContentTableHeader();
                $ret .= $this->RenderContentTableHeaderRow(array(
                        $client,
                        $hostname,
                        $geo->code."(".$geo->name.")",
                ), false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed" ), 
                array(
                    150,
                    250, 
                    "100%"
                ));
                
                foreach($accesses as $access) {
                    $ret .= $this->RenderContentTableContentRow(
                        null, 
                        array(
                            strftime("%d.%m.%Y %H:%M:%S", $access->date),
                            $access->method." ".$access->proto." ".$access->status
                        ), 
                        null,
                        array(                                   
                            $access->path."<br />".$access->datalen." bytes",
                            str_trim_length($access->referer,50, "...")."<br />".browser_detection("browser", $access->useragent)." ".browser_detection("number", $access->useragent)
                        ), 
                        false);
                }
                $ret .= $this->RenderContentTableFooter();                
                
            }
        }
        else {
            $ret .= "Лог пуст";
        }
        
        
        
        return $ret;
    }

    function ViewErrorLog() {
        global $ERROR_LOG;
        $logDevice = new LogParser($ERROR_LOG, ERROR_LOG);
        $log = $logDevice->Parse("client");
        $ret = "";
        
        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageButton("clear_error_log", "iconpack(folder_delete)", $this->lang->toolbar_remove, TOOLBAR_BUTTON_LEFT, "clear_error_log", "get", null, null, $this->lang->toolbar_removemessage));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");
        
        
        if($log->Count() > 0) {
            foreach($log as $client => $errors) {
                
                $hostname = gethostbyaddr($client);
                $geo = Geo::CountryByIP($client);
                $ret .= $this->RenderContentTableHeader();
                $ret .= $this->RenderContentTableHeaderRow(array(
                        $client,
                        $hostname,
                        $geo->code."(".$geo->name.")",
                ), false, true, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', "collapsed" ), 
                array(
                    150,
                    250, 
                    "100%"
                ));
                foreach($errors as $error) {
                    $ret .= $this->RenderContentTableContentRow(
                        null, 
                        array(
                            strftime("%d.%m.%Y %H:%M:%S", $error->date),
                            $error->errorType
                        ), 
                        null,
                        array(
                            $error->errorMessage,
                            $error->errorInfo
                        ), 
                        false);
                }
                $ret .= $this->RenderContentTableFooter();                
                
            }
        }
        else {
            $ret .= "Лог пуст";
        }
        
        return $ret;
    }

    function ClearAccessLog() {
        global $ACCESS_LOG;
        @unlink($ACCESS_LOG);
        @touch($ACCESS_LOG);
        //file_put_contents($ACCESS_LOG, "");
        
        return "Лог файл очищен.";
    }

    function ClearErrorLog() {
        global $ERROR_LOG;
        @unlink($ERROR_LOG);
        @touch($ERROR_LOG);
        //file_put_contents($ERROR_LOG, "");
        return "Лог файл очищен.";
    }


    function RenderBlobCategories($categories, $level = 0) {
        
        $ret = "";

        foreach($categories as $category) {
        
            $content  = "<table cellpadding=0 cellspacing=0 border=0 class='content-table' style='margin-left: ".($level*20)."px'><tr>";
            $content .= "<td class='icon'>";
            $content .= $this->iconpack->CreateIconImage("iconpack(blob_folder)", "", 24, 24, 'align=absmiddle');
            $content .= "</td><td>";
            $content .= "<a class='tree-link' href=\"#\" onclick=\"javascript: setCheckbox('category_id_".$category->id."'); PostBack('content', 'get'); return false;\">".$category->description."</a><br>";
            $content .= "<span class='small-text'>Id: <b>".$category->id.", childs: <b>".$category->folders.", files: <b>".$category->blobs."</b></span>";
            $content .= "</td></tr></table>";
            
            $ret .= $this->RenderContentTableContentRow(
                    null, 
                    array(
                        $content,
                        null
                    ), 
                    null, 
                    array(), 
                    true, 
                    $category->id, 
                    "category_id_", 0, true);
            
            if($category->children > 0)    {
                $ret .= $this->RenderBlobCategories($category->Children(), $level+1);
            }
            
        }        
        return $ret;
    
    }

    function RenderBlobManager() {
        global $core;
        $lt = "\r\n";
        $ret = "";

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", "iconpack(folder_add)", $this->lang->toolbar_add, TOOLBAR_BUTTON_LEFT, "add", "post", 'editor', 'blobs', null, 500, 200, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("edit", "iconpack(folder_edit)", $this->lang->toolbar_edit, TOOLBAR_BUTTON_LEFT, "edit", "post", 'editor', 'blobs', null, 500, 200, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("remove", "iconpack(folder_delete)", $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, "remove", "post", null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageButton("browse", "iconpack(browse_blobs)", $this->lang->tools_blobmanager_browse, TOOLBAR_BUTTON_LEFT, "content", "get"));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");
        

        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->development_name
        ), false);

        $content  = "<table cellpadding=0 cellspacing=0 border=0 class='content-table' style='margin-left: 0px'><tr>";
        $content .= "<td class='icon'>";
        $content .= $this->iconpack->CreateIconImage("iconpack(blob_folder)", "", 24, 24, 'align=absmiddle');
        $content .= "</td><td>";
        $content .= "<a class='tree-link' href=\"#\" onclick=\"javascript: setCheckbox('category_id_-1'); PostBack('content', 'get'); return false;\">Uncategorized</a><br>";
        $content .= "<span class='small-text'>Id: <b>-1, childs: <b>0, files: <b>-1</b></span>";
        $content .= "</td></tr></table>";
        
        $ret .= $this->RenderContentTableContentRow(
                null, 
                array(
                    $content,
                    null
                ), 
                null, 
                array(), 
                true, 
                -1, 
                "category_id_", 0, true);

        $ret .= $this->RenderBlobCategories(new BlobCategories(null));
        $ret .= $this->RenderContentTableFooter();    

        return $ret;
    }
    
    function GetBlobUsing($blob, &$firstChains) {
        global $core;
        
        $r = $core->dbe->ExecuteReader("select * from sys_storage_fields where storage_field_type='blob' or storage_field_type='blob list'");
        while($row = $r->Read()) {
            
            $sid = $row->storage_field_storage_id;
            $field = $row->storage_field_field;
            
            $s = new Storage($sid);
            $table = $s->table;
            $field = $s->fname($field);
            
            if($row->storage_field_type == "blob") {
                $rr = $core->dbe->ExecuteReader("select count(*) as c from ".$table." where ".$field." = '".$blob->id."'");
                $count = $rr->Read()->c;
                if($count > 0) {
                    $firstChains = $s->name;
                    return true;
                }
            }
            else {
                $rr = $core->dbe->ExecuteReader("select count(*) as c from ".$table." where CONCAT(',',".$field.",',') LIKE ',".$blob->id.",'");
                $count = $rr->Read()->c;
                if($count > 0) {
                    $firstChains = $s->name;
                    return true;
                }
            }
            
            
        }
                                                                                             
        return false;
    }    
    
    function BrowseCategoryBlobs($blob_category_id) {

        global $core;
        $ret = "";
        $p = new collection();


        $page = $this->page;
        if($this->page == "") $page = 1;

        $pagesize = $this->rowsonpage;
        // $pagesize = $core->sts->SETTING_PAGESIZE;
        if(is_null($pagesize) || $pagesize=="") $pagesize = 10;

        if($blob_category_id > 0) {
            $bc = new BlobCategory(intval($blob_category_id));
            $blobs = $bc->Blobs(null, $page, $pagesize); //$core->bm->enumBlobs($blob_category_id, null, $page, $pagesize);
        }
        else {
            $blobs = new Blobs(null, null, $page, $pagesize); 
        }
        
        /*$pager = $this->Pager($page, $pagesize, $blobs->affected, "?postback_command=content&postback_action=blobs&postback_section=tools&category_id_".$blob_category_id."=".$blob_category_id);

        $this->RenderToolbar(array(
            array('add', 'iconpack(blob_add)', $this->lang->toolbar_addblob, 'addresource', 'post', 'editor', 'blobs', null, 1, true, 500, 600, false) ,
            array('edit', 'iconpack(blob_edit)', $this->lang->toolbar_editblob, 'editresource', 'post', 'editor', 'blobs', null, 1, true, 600, 280, false),
            array('remove', 'iconpack(blob_delete)', $this->lang->toolbar_removeblob, 'removeresource', 'post', null, null, $this->lang->toolbar_removemessage),
            array('separator'), 
            array('move', 'iconpack(blob_move)', $this->lang->toolbar_move, 'moveresource', 'post', 'editor', 'blobs', null, 1, true, 500, 200, true),
            array('separator'), 
            array('!back', 'iconpack(go_back)', $this->lang->toolbar_backtoblobcategories, 'view', 'get', null, null, null, 1)
        ), TOOLBAR_IMAGEONLY, $pager);
        */
        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton('add', 'iconpack(blob_add)', $this->lang->toolbar_addblob, TOOLBAR_BUTTON_LEFT, 'addresource', 'post', 'editor', 'blobs', null, 550, 600, false));
        $toolbar->Buttons->Add(new ToolbarImageFButton('edit', 'iconpack(blob_edit)', $this->lang->toolbar_editblob, TOOLBAR_BUTTON_LEFT, 'editresource', 'post', 'editor', 'blobs', null, 600, 280, false));
        $toolbar->Buttons->Add(new ToolbarImageButton('remove', 'iconpack(blob_delete)', $this->lang->toolbar_removeblob, TOOLBAR_BUTTON_LEFT, 'removeresource', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageFButton('move', 'iconpack(blob_move)', $this->lang->toolbar_move, TOOLBAR_BUTTON_LEFT, 'moveresource', 'post', 'editor', 'blobs', null, 500, 200, true));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator2"));
        $toolbar->Buttons->Add(new ToolbarPagerButton('pager', $page, $pagesize, $blobs->affected, "?postback_command=content&postback_action=blobs&postback_section=tools&category_id_".$blob_category_id."=".$blob_category_id));
        $toolbar->Buttons->Add(new ToolbarImageButton('!back', 'iconpack(go_back)', $this->lang->toolbar_backtoblobcategories, TOOLBAR_BUTTON_RIGHT, 'view', 'get', null, null, null, 1));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);
        $cmd->Render("toolbar_bottom");
        
        $ret .= "
            <table cellpadding=0 cellspacing=0 border=0 width=100% class='content-table'>
                <tr class='title'>
                    <td>
                        ".$this->lang->tools_blobs."
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan='2' style='padding-top: 5px;'>
        ";

        if($blobs->Count() > 0) {
            //out($blobs);
            foreach($blobs as $blob) {
                
                // $firstChains = "";
                // $used = $this->GetBlobUsing($blob, $firstChains);
                
                $ret .= "<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td class=unique colspan=2>unique: ".$blob->id."</td></tr><tr onclick='javascript: setRowCheck(this);' id='blob".$blob->id."'><td style='cursor:default'>";
                
                // $optemplate .= $template->storage_templates_list;
                $ret .= '
                    <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="120" valign="middle" align="center">
                ';
                        $ret .= '<a target="_blank" href="'.$blob->src().'">'.$blob->Img(new Size(100, 100)).'</a>';
                
                $ret .= '
                        </td>
                        <td>
                            <table class="content-inner-table">
                            <tr>
                                <td>
                                    <strong>File name:</strong>
                                </td>
                                <td>
                                    '.$blob->filename.' ('.$blob->type.')
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Alternate text:</strong>
                                </td>
                                <td>
                                    '.$blob->alt.'
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Length:</strong>
                                </td>
                                <td>
                                    '.$blob->bsize.' bytes
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Modified:</strong>
                                </td>
                                <td>
                                    '.$blob->modified.'
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Accessed:</strong>
                                </td>
                                <td>
                                    '.$blob->lastaccessed.'
                                </td>
                            </tr>
                         
                            </table>
                        </td>
                    </tr>
                    </table>
                ';
                
                $ret .= "</td><td valign=middle width=20><input type=checkbox name=blob_id_".$blob->id." value=".$blob->id." class=checkbox hilitable=1></td></tr>";
            }
        }
        else {
            $ret .= "<tr><td><span class='small-text'>".$this->lang->tools_noblobs."</span></td></tr>";
        }
        
        $ret .= "
                        </table>
                    </td>
                </tr>
            </table>
        ";


        return $ret;
    }
    
    
    function RenderUserManager() {
        global $core;

        $ret = "";
        switch($this->command) {
            case "message_ok":
            case "view":
                $this->Out("subtitle", $this->lang->tools_usermanager_users, OUT_AFTER);
                $ret .= $this->RenderUserList();
                break;
            case "remove":
                if($core->security->Check(null, "usermanagement.users.delete")) {
                    $users = $this->post_vars("user_name_");
                    $error = false;
                    foreach($users as $user) {
                        if($user != $core->security->currentUser->name)
                            SecurityEx::$users->Delete($user);
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_can_not_delete_logged_user, $this->lang->error_message_box_title);
                            $error = true;
                            break;
                        }
                    }
                    if(!$error)
                        $ret .= $this->DoPostBack("view", "get");
                }
                else {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                }
                break;
            case "groups": 
                $this->Out("subtitle", $this->lang->tools_users_groups, OUT_AFTER);
                $ret .= $this->RenderGroupsList();
                break;
            case "group_remove":
                global $core;
                if($core->security->Check(null, "usermanagement.groups.delete")) {
                    $groups = $this->post_vars("group_name");
                    foreach($groups as $group) {
                        SecurityEx::$groups->Delete($group);
                    }
                    $ret .= $this->DoPostBack("groups", "get");
                }
                else {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                }
                break;
            case "roles": 
                $this->Out("subtitle", $this->lang->tools_users_roles, OUT_AFTER);
                $ret .= $this->RenderRolesList();
                break;
            case "role_remove":
                if($core->security->Check(null, "usermanagement.groups.delete")) {
                    $roles = $this->post_vars("role_name");
                    foreach($roles as $role)
                        $core->security->systemInfo->roles->Delete($role);
                    $core->security->systemInfo->Store();
                    $ret .= $this->DoPostBack("roles", "get");
                }                
                else {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                }
                break;
            case "recreate":
                global $core;
                if($core->security->Check(null, "usermanagement.cache.recreate")) {
                    $core->security->systemInfo->RecreateCacheDatabase();
                    $ret .= $this->DoPostBack($this->mode, "get");
                }
                else {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                }
                break;
        }


        return $ret;        
    }
    
    function RenderUserList() {
        $ret = "";
        
        $users = SecurityEx::$users;
        
        $page = $this->page;
        if($this->page == "") $page = 1;
        
        $pagesize = $this->rowsonpage;
        // $pagesize = $core->sts->SETTING_PAGESIZE;
        if(is_null($pagesize) || $pagesize=="") $pagesize = 10;
        
        $ret .= $this->SetPostVar("mode", $this->command);
        
        $pager = $this->Pager($page, $pagesize, $users->Count(), "?postback_command=view&postback_action=usersex&postback_section=tools");
        $this->RenderToolbar(array(
            array('add', 'iconpack(user_add)', $this->lang->toolbar_add, 'add', 'post', 'editor', 'users', null, 1, true, 600, 500, false) ,
            array('edit', 'iconpack(user_preferences)', $this->lang->toolbar_edit, 'edit', 'post', 'editor', 'users', null, 1, true, 600, 500, false),
            array('remove', 'iconpack(user_delete)', $this->lang->toolbar_removeselected, 'remove', 'post', null, null, $this->lang->toolbar_removemessage),
            array('separator'), 
            array('groups', 'iconpack(groups)', $this->lang->tools_users_groups, 'groups', 'get', null, null, null),
            array('roles', 'iconpack(roles)', $this->lang->tools_users_roles, 'roles', 'get', null, null, null),
            array('separator'), 
            array('recreate', 'iconpack(recompile)', $this->lang->tools_users_recompile, 'recreate', 'get', null, null, $this->lang->toolbar_recreatemessage)
        ), 
        TOOLBAR_IMAGEONLY, 
        $pager);
        
        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                    $this->lang->tools_users_name, 
                    $this->lang->tools_users_groups,
                    $this->lang->tools_users_roles, 
                    $this->lang->tools_users_info
                ), true, true);
        foreach ($users as $user){
            $ret .= $this->RenderContentTableContentRow(
                    "iconpack(user)", 
                    array(
                        $user->name
                        ), 
                    "javascript: setCheckbox('user_name_".$user->name."'); PostBackToFloater('edit', 'post', 'editor', 'users', null, null, 700, 520, true);", 
                    array(                        
                        $user->groups->ToString()."&nbsp;",
                        $user->roles->ToString(", <br/>")."&nbsp;",
                        "last logged: ".@strftime("%d.%m.%Y %H:%M", $user->lastlogindate).",<br/> from: ".$user->lastloginfrom
                    ), 
                    $hasCheckbox = true, 
                    $user->name, 
                    "user_name_");
        }
        $ret .= $this->RenderContentTableFooter();
        
        
        return $ret;
        
        
        
    }

    function RenderGroupsList() {
        $ret = "";
        
        $groups = SecurityEx::$groups;
        
        $page = $this->page;
        if($this->page == "") $page = 1;
        
        $pagesize = $this->rowsonpage;
        // $pagesize = $core->sts->SETTING_PAGESIZE;
        if(is_null($pagesize) || $pagesize=="") $pagesize = 10;
        
        $ret .= $this->SetPostVar("mode", $this->command);
        
        $pager = $this->Pager($page, $pagesize, $groups->Count(), "?postback_command=view&postback_action=usersex&postback_section=tools");
        $this->RenderToolbar(array(
            array('add', 'iconpack(users_add)', $this->lang->toolbar_add, 'group_add', 'post', 'editor', 'users', null, 1, true, 600, 500, false) ,
            array('edit', 'iconpack(users_properties)', $this->lang->toolbar_edit, 'group_edit', 'post', 'editor', 'users', null, 1, true, 600, 500, false),
            array('remove', 'iconpack(users_delete)', $this->lang->toolbar_removeselected, 'group_remove', 'post', null, null, $this->lang->toolbar_removemessage),
            array('separator'), 
            array('users', 'iconpack(user_list)', $this->lang->tools_users_groups, 'view', 'get', null, null, null),
            array('roles', 'iconpack(roles)', $this->lang->tools_users_roles, 'roles', 'get', null, null, null),
            array('separator'), 
            array('recreate', 'iconpack(recompile)', $this->lang->tools_users_recompile, 'recreate', 'get', null, null, $this->lang->toolbar_recreatemessage)
        ), 
        TOOLBAR_IMAGEONLY, 
        $pager);
        
        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                    $this->lang->tools_usermanager_groupname, 
                    $this->lang->tools_usermanager_groupdescription
                ), true, true);

        foreach ($groups as $group){
            $ret .= $this->RenderContentTableContentRow(
                    "iconpack(user_group)", 
                    array(
                        $group->name
                        ), 
                    "javascript: setCheckbox('group_name_".$group->name."'); PostBackToFloater('group_edit', 'post', 'editor', 'users', null, null, 700, 520, true);", 
                    array(                        
                        $group->description."&nbsp;"
                    ), 
                    $hasCheckbox = true, 
                    $group->name, 
                    "group_name_");
        }
        $ret .= $this->RenderContentTableFooter();
        
        return $ret;
        
        
        
    }

    function RenderRolesList() {
        global $core;
        
        $ret = "";
        
        $ret .= $this->SetPostVar("mode", $this->command);
        
        $roles = $core->security->systemInfo->roles;
        
        $page = $this->page;
        if($this->page == "") $page = 1;
        
        $pagesize = $this->rowsonpage;
        // $pagesize = $core->sts->SETTING_PAGESIZE;
        if(is_null($pagesize) || $pagesize=="") $pagesize = 10;
        
        $pager = $this->Pager($page, $pagesize, $roles->Count(), "?postback_command=view&postback_action=usersex&postback_section=tools");
        $this->RenderToolbar(array(
            array('add', 'iconpack(role_add)', $this->lang->toolbar_add, 'role_add', 'post', 'editor', 'users', null, 1, true, 600, 500, false) ,
            array('edit', 'iconpack(role_edit)', $this->lang->toolbar_edit, 'role_edit', 'post', 'editor', 'users', null, 1, true, 600, 500, false),
            array('remove', 'iconpack(role_delete)', $this->lang->toolbar_removeselected, 'role_remove', 'post', null, null, $this->lang->toolbar_removemessage),
            array('separator'), 
            array('users', 'iconpack(user_list)', $this->lang->tools_users_name, 'view', 'get', null, null, null),
            array('groups', 'iconpack(groups)', $this->lang->tools_users_groups, 'groups', 'get', null, null, null),
            array('separator'), 
            array('recreate', 'iconpack(recompile)', $this->lang->tools_users_recompile, 'recreate', 'get', null, null, $this->lang->toolbar_recreatemessage)
        ), 
        TOOLBAR_IMAGEONLY, 
        $pager);
        
        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                    $this->lang->tools_usermanager_rolename, 
                    $this->lang->tools_usermanager_roledescription
                ), true, true);
        foreach ($roles as $role){
            $ret .= $this->RenderContentTableContentRow(
                    "iconpack(role)", 
                    array(
                        $role->name
                        ), 
                    "javascript: setCheckbox('role_name_".$role->name."'); PostBackToFloater('role_edit', 'post', 'editor', 'users', null, null, 700, 520, true);", 
                    array(                        
                        $role->description."&nbsp;"
                    ), 
                    $hasCheckbox = true, 
                    $role->name, 
                    "role_name_");
        }
        $ret .= $this->RenderContentTableFooter();
        
        return $ret;
        
        
        
    }

}




?>
