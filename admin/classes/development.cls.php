<?php

/**
    * class DevelopmentPageForm
    *
    * Description for class DevelopmentPageForm
    *
    * @author:
    */
class DevelopmentPageForm extends PostBackForm {

    function DevelopmentPageForm() {
        parent::__construct("development", "main", "/admin/index.php", "get");
        
        if(is_null($this->lang))
            $this->lang = new stdClass();
    }

    public function MenuVisible() {
        return true;
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

    function RenderContent() {
        global $core;
        $ret = "";
        
        switch($this->action) {
            case "structure":
                $this->Out("title", $this->lang->development_structure, OUT_AFTER);
            
                if(!$core->security->Check(null, "structure.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }

                switch($this->command) {
                    case "message_ok":
                    case "message_cancel":
                    case "view":
                        $this->Out("subtitle", $this->lang->development_structure_view, OUT_AFTER);
                        $ret .= $this->ListSites();
                        break;
                    case "publish_folder":
                        $postdata = $this->post_vars("sites_id_");
                        if($postdata->count() == 0) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                        }
                        else {
                            $error = false;
                            $items = array();
                            foreach($postdata as $item) {
                                $sf = Site::Fetch($item);
                                if(!$core->security->CheckBatch($sf->createSecurityBathHierarchy("edit"))) {
                                    $error = true;
                                    break;
                                }
                                else
                                    $items[] = $sf;
                            }
                            if(!$error) {
                                foreach($items as $sf) {
                                    $sf->published = !$sf->published;
                                    $sf->Save();
                                }
                                $ret .= $this->DoPostBack("view", "get");
                            }
                            else    
                                $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "removesite":
                        $postdata = $this->post_vars("sites_id_");
                        if($postdata->count() == 0) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                        }
                        else {
                            
                            foreach($postdata as $id) {
                                $item = Site::Fetch($id);
                                if($core->security->CheckBatch($item->createSecurityBathHierarchy("delete"))) {
                                    $item->Remove();
                                }
                                else
                                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted." (".$item->description.")", $this->lang->error_message_box_title);
                            }
                            $ret .= $this->DoPostBack("view", "get");
                            
                        }

                        break;
                    case "moveup":
                        $form = $this->post_vars("sites_id_");
                        $items = array();
                        $error = false;
                        foreach($form as $sf) {
                            if($sf != "") {
                                $site = Site::Fetch($sf);
                                if($core->security->CheckBatch($site->createSecurityBathHierarchy("changeposition")))
                                    $items[] = $site;    
                                else {
                                    $error = true;
                                    break;
                                }
                            }
                        }
                        if(!$error) {
                            foreach($items as $site) {
                                $site->MoveUp();
                            }
                            $ret .= $this->DoPostBack('view', 'get');
                        }
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        break;
                    case "movedown":
                        $form = $this->post_vars("sites_id_");
                        $items = array();
                        $error = false;
                        for($i=$form->Count()-1; $i>=0; $i--) {
                            $sf = $form->Item($i);
//                        foreach($form as $sf) {
                            if($sf != "") {
                                $site = Site::Fetch($sf);
                                if($core->security->CheckBatch($site->createSecurityBathHierarchy("changeposition")))
                                    $items[] = $site;    
                                else {
                                    $error = true;
                                    break;
                                }
                            }
                        }
                        if(!$error) {          
                            foreach($items as $site) {
                                $site->MoveDown();
                            }
                            $ret .= $this->DoPostBack('view', 'get');
                        }
                        else
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        break;
                    case "content":
                        $form = $this->post_vars("sites_id_");

                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else {

                            if($this->sf_id != "")
                                $sf = $this->sf_id;
                            else
                                $sf = $form->item(0);

                            if(is_null($sf)) {
                                $ret .= $this->ErrorMessage($this->lang->error_select_node, $this->lang->error_message_box_title);
                            }
                            else {
                                $pt = "pub_template_".$this->pub_id;
                                if(!is_null($this->$pt) && !is_null($this->pub_id)) {
                                    $pub = new Publication($this->pub_id);
                                    $f = $pub->FindFolder();
                                    if($core->security->CheckBatch($f->createSecurityBathHierarchy("publications.edit"))) {
                                        $pub->template = $this->$pt;
                                        $pub->Save();
                                        $ret .= $this->SetPostVar("sf_id", $this->sf_id);
                                        $ret .= $this->DoPostBack("content", "get");
                                    }
                                    else {
                                        $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                                    }
                                }
                                
                                $sf = Site::Fetch($sf);
                                
                                $this->Out("subtitle", $this->lang->development_structure_content." [".html_strip($sf->description)."]", OUT_AFTER);
                                
                                $ret .= $this->BrowsePublishingRules($sf->id);
                            }

                        }
                        break;
                    case "pmovedown":
                        $form = $this->post_vars("template_operation_id");
                        $folder = Site::Fetch($this->sf_id);
                        if(!$core->security->CheckBatch($folder->createSecurityBathHierarchy("publications.changeposition"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        else {
                            for($i=$form->count()-1; $i>=0; $i--) {
                                $item = $form->item($i);
                                $p = new Publication($item);
                                if(!$p->error)
                                    $p->MoveDown();
                            }
                            $ret .= $this->SetPostVar("sf_id", $this->sf_id);
                            $ret .= $this->DoPostBack('content', 'get');
                        }
                        break;
                    case "pmoveup":
                        $form = $this->post_vars("template_operation_id");
                        $folder = Site::Fetch($this->sf_id);
                        if(!$core->security->CheckBatch($folder->createSecurityBathHierarchy("publications.changeposition"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        else {
                            foreach($form as $item) {
                                $p = new Publication($item, null);
                                if(!$p->error) {
                                    $p->MoveUp();
                                }
                            }
                            $ret .= $this->SetPostVar("sf_id", $this->sf_id);
                            $ret .= $this->DoPostBack('content', 'get');
                        }
                        break;
                    case "removedata":
                        $form = $this->post_vars("template_operation_id");
                        $folder = Site::Fetch($this->sf_id);
                        if(!$core->security->CheckBatch($folder->createSecurityBathHierarchy("publications.delete"))) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        else {
                            foreach($form as $item) {
                                $p = new Publication($item, null);
                                if(!$p->error)
                                    $p->Discard();
                            }
                            $ret .= $this->SetPostVar("sf_id", $this->sf_id);
                            $ret .= $this->DoPostBack('content', 'get');
                        }
                        break;
                }
                break;
            case "storages":
                $this->Out("title", $this->lang->development_storages, OUT_AFTER);
            
                if(!$core->security->Check(null, "storages.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }

                switch($this->command) {
                    case "message_ok":
                        if($this->storage_id == "") {
                            $this->Out("subtitle", $this->lang->development_storages_view, OUT_AFTER);
                            $ret .= $this->ListStorages();
                        }
                        else {
                            $storage = new Storage($this->storage_id);
                            $this->Out("subtitle", $this->lang->development_storages_browse.$storage->name, OUT_AFTER);
                            $ret .= $this->BrowseData($storage);
                        }
                        break;
                    case "view":
                        $this->Out("subtitle", $this->lang->development_storages_view, OUT_AFTER);
                        $ret .= $this->ListStorages();
                        break;
                    case "dumpscript":
                    
                        $script = '<'.'?'.
                                  "\n\n".
                                  '/* Dumping storages */'.
                                  "\n\n";
                        $form = $this->post_vars("storages_id_");
                        foreach($form as $item) {
                            $s = new Storage($item);
                            $script .= $s->ToPHPScript();
                        }

                        $script .= "\n\n".'?'.'>';
                        
                        $ret .= '<textarea style="width: 100%; height: 400px;">'.$script.'</textarea>';
                        
                        break;
                    case "recompile":
                        /*
                        $form = $this->post_vars("storages_id_");
                        $items = array();
                        $error = false;
                        foreach($form as $item) {
                            $s = new Storage($item);
                            if($core->security->CheckBatch($s->createSecurityBathHierarchy("recompile")))
                                $items[] = $s;
                            else {
                                $error = true;    
                                break;
                            }
                        }
                        if(!$error) {
                            foreach($items as $s) {
                                $storages->compile($s);
                            }
                            $ret .= $this->DoPostBack('view', 'get');
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        */
                        break;
                    case "removestorage":
                        $form = $this->post_vars("storages_id_");
                        $items = array();
                        $error = false;
                        
                        foreach($form as $item) {
                            $s = new Storage($item);
                            if($core->security->CheckBatch($s->createSecurityBathHierarchy("delete")))
                                $items[] = $s;
                            else {
                                $error = true;    
                                break;
                            }
                        }
                        if(!$error) {
                            foreach($items as $s) {
                                $s->Delete();
                                $mm = CModuleManager::Enum("module_storages like '".$s->table."'", "", false);
                                if (!$mm)
                                    continue;
                                foreach ($mm as $m){
                                    $i = $m->storages->indexof($s->table);
                                    if ($i !== false){
                                        $m->storages->delete($i);
                                        $m->Save();
                                    }
                                }
                            }
                            $ret .= $this->DoPostBack('view', 'get');
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "listfields":
                        $form = $this->post_vars("storages_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else if($form->count() == 0 && (is_null($this->storage_id) && is_null($this->storage_id_change))) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_storage, $this->lang->error_message_box_title);
                        }
                        else {
                            
                            if(!is_null($this->storage_id_change))
                                $storage = new Storage($this->storage_id_change);
                            else if(!is_null($this->storage_id))
                                $storage = new Storage($this->storage_id);
                            else
                                $storage = new Storage($form->item(0));
                                
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            $this->Out("subtitle", $this->lang->development_storages_listfields.$storage->name, OUT_AFTER);
                            $ret .= $this->ListFields($storage);
                        }
                        break;
                    case "removefield":
                        $storage = new Storage($this->storage_id);
                        if($core->security->CheckBatch($storage->createSecurityBathHierarchy("fields.delete"))) {
                            $form = $this->post_vars("storage_fields_id_");
                            foreach($form as $item) {
                                $f = $storage->fields->item($item);
                                $f->Delete();
//                                $storage->fields->remove($f->storage_field_field);
                            }
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            $ret .= $this->DoPostBack('listfields', 'get');
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "moveup":
                        $storage = new Storage($this->storage_id);
                        if($core->security->CheckBatch($storage->createSecurityBathHierarchy("fields.delete"))) {
                            $form = $this->post_vars("storage_fields_id_");
                            foreach($form as $item) {
                                $f = $storage->fields->item($item);
                                $f->MoveUp();
                            }
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            $ret .= $this->DoPostBack('listfields', 'get');
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "movedown":
                        $storage = new Storage($this->storage_id);
                        if($core->security->CheckBatch($storage->createSecurityBathHierarchy("fields.edit"))) {
                            $form = $this->post_vars("storage_fields_id_");
                            for($i=$form->Count()-1; $i >= 0; $i--) {
                                $f = $storage->fields->item($form->Item($i));
                                $f->MoveDown();
                            }
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            $ret .= $this->DoPostBack('listfields', 'get');
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "exporttemplate":
                        $storage = new Storage($this->storage_id);
                        if(!$this->storage_id) {
                            $form = $this->post_vars('storages_id_');
                            if($form->Count() > 0)
                                $storage = new Storage($form->Item(0));
                        }
                        $ret .= $this->SetPostVar("storage_id", $storage->id);
                        
                        $form = $this->post_vars("storage_template_id_");
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
                                $path = strtolower($this->IOPath()->templates.'storages/'.$storage->table."/".$t->name.".tpl.php");
                                $path_css = strtolower($this->IOPath()->templates.'storages/'.$storage->table."/".$t->name.".tpl.css");
                                $t->list = "LOADFILE:".$path;
                                $t->styles = "LOADFILE:".$path_css;
                                if (is_empty($content))
                                    $content = "<"."?\n\t//шаблон хранилища ".$storage->table.".".$t->name."\n?".">";
                                if (is_empty($content_css))
                                    $content_css = "/* стилевой файл для шаблона ".$storage->table.".".$t->name."*/";
                                
                                //$content = convert_string("utf-8", $content);
                                $success = true;
                                
                                if(!$core->fs->DirExists(strtolower($this->IOPath()->templates.'storages'))) {
                                    $success = $core->fs->CreateDir(strtolower($this->IOPath()->templates.'storages'));
                                }
                                if(!$core->fs->DirExists(strtolower($this->IOPath()->templates.'storages/'.$storage->table))) {
                                    $success = $core->fs->CreateDir(strtolower($this->IOPath()->templates.'storages/'.$storage->table));
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
                    
                        break;
                    case "listtemplates":
                        $form = $this->post_vars("storages_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, "Request errpor");
                        else if($form->count() == 0 && (is_null($this->storage_id) && is_null($this->storage_id_change))) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_storage, $this->lang->error_message_box_title);
                        }
                        else {
                            
                            if(!is_null($this->storage_id_change))
                                $storage = new Storage($this->storage_id_change);
                            else if(!is_null($this->storage_id))
                                $storage = new Storage($this->storage_id);
                            else
                                $storage = new Storage($form->item(0));

                            if(is_null($storage))
                                $ret .= $this->ErrorMessage($this->lang->error_select_storage, "Request errpor");
                            else {
                                $this->Out("subtitle", $this->lang->development_storages_listtemplates.$storage->name, OUT_AFTER);
                                $ret .= $this->ListTemplates($storage);
                            }
                        }

                        break;
                    case "removetemplate":
                        $storage = new Storage($this->storage_id);
                        if($core->security->CheckBatch($storage->createSecurityBathHierarchy("templates.delete"))) {
                            $form = $this->post_vars("storage_template_id_");
                            foreach($form as $item) {
                                $t = template::create($item, $storage);
                                $t->Delete();
                            }
                            $ret .= $this->SetPostVar("storage_id", $storage->id);
                            $ret .= $this->DoPostBack('listtemplateslisttemplates', 'get');
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "browse":
                        $form = $this->post_vars("storages_id_");
                        if($form->count() > 1)
                            $ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
                        else if($form->count() == 0 && is_null($this->storage_id) && is_null($this->storage_id_change)) {
                            $ret .= $this->ErrorMessage($this->lang->error_select_storage, $this->lang->error_message_box_title);
                        }
                        else {
                            if(!is_null($this->storage_id_change))
                                $storage = new Storage($this->storage_id_change);
                            else if(!is_null($this->storage_id))
                                $storage = new Storage($this->storage_id);
                            else
                                $storage = new Storage($form->item(0));
                            
                            $this->Out("subtitle", $this->lang->development_storages_browse.$storage->name, OUT_AFTER);
                            $ret .= $this->BrowseData($storage);
                        }
                        break;
                    case "export":
                        
                        $storage = new Storage($this->storage_id);
                        $ret .= $this->SetPostVar("storage_id", $this->storage_id);
                        
                        $form = $this->post_vars("template_operation_id_");
                        foreach($form as $id) {
                            $dt = new DataRow($storage, $id);
                            
                            foreach($storage->fields as $f) {
                                
                                if(to_lower($f->type) == "memo" || to_lower($f->type) == "html") {
                                    $fname = $f->field;
                                    $content = $dt->$fname;
                                    $info = $this->checkSourceInFile($content);
                                    if ($info->infile){
                                        if ($info->content == -1)
                                            continue;
                                        
                                        $info->content = convert_string("UTF-8", $info->content);
                                        
                                        $dt->$fname = $info->content;
                                        $dt->Save();
                                        
                                    }
                                    else {
                                        $path = strtolower($this->IOPath()->data.$storage->table."/".$dt->id."_".$f->field.".data.".(to_lower($f->type) == "memo" ? "txt" : "html"));
                                        $dt->$fname = "LOADFILE:".$path;
                                        if (is_empty($content)) {
                                            if(to_lower($f->type) == "memo")
                                                $content = "НА УДАЛЕНИЕ: данные поля ".$f->field." в хранилище ".$storage->table;
                                            else
                                                $content = "<!--НА УДАЛЕНИЕ: данные поля ".$f->field." в хранилище ".$storage->table."-->";
                                        }
                                        
                                        if(!$core->fs->DirExists(strtolower($this->IOPath()->data.$storage->table))) {
                                            $success = $core->fs->CreateDir(strtolower($this->IOPath()->data.$storage->table));
                                        }
                                            
                                        if($core->fs->writefile($path, $content) > 0) {
                                            $dt->save();
                                            @system("chmod 777 ".$core->fs->mappath($path));
                                        }
                                        else {
                                            out("The file was not saved! File: ".$path);
                                        }
                                        
                                    }
                                    
                                    
                                    
                                }
                                
                            }
                            
                        }

                        $ret .= $this->DoPostBack("browse", "get");
                        
                        break;
                    case "moveupdata": 
                        $storage = new Storage($this->storage_id);
                        if(!$storage->istree) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        else {
                            $form = $this->post_vars("template_operation_id");
                            foreach($form as $dataid) {
                                $class = $storage->istree ? 'DataNode' : 'DataRow';
                                $d = new $class($storage, $dataid);
                                $d->MoveUp();
                                
                            }
                            $ret .= $this->SetPostVar("storage_id", $this->storage_id);
                            $ret .= $this->DoPostBack("browse", "get");
                        }
                        break;
                    case "movedowndata": 
                        $storage = new Storage($this->storage_id);
                        if(!$storage->istree) {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        else {
                            $form = $this->post_vars("template_operation_id");
                            for($i=$form->Count()-1; $i>=0; $i--) {
                                $dataid = $form->Item($i);
                                $class = $storage->istree ? 'DataNode' : 'DataRow';
                                $d = new $class($storage, $dataid);
                                $d->MoveDown();
                                
                            }
                            $ret .= $this->SetPostVar("storage_id", $this->storage_id);
                            $ret .= $this->DoPostBack("browse", "get");
                        }
                        break;
                    case "removedata":
                        $storage = new Storage($this->storage_id);
                        if($core->security->CheckBatch($storage->createSecurityBathHierarchy("data.delete"))) {
                            $form = $this->post_vars("template_operation_id");
                            foreach($form as $dataid) {
                                $class = $storage->istree ? 'DataNode' : 'DataRow';
                                $d = new $class($storage, $dataid);
                                $d->Delete();
                            }
                            $ret .= $this->SetPostVar("storage_id", $this->storage_id);
                            $ret .= $this->DoPostBack("browse", "get");
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                }
                break;
            case "designtemplates":
                $this->Out("title", $this->lang->development_designtemplates, OUT_AFTER);
            
                if(!$core->security->Check(null, "interface.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }

                $dtemplates = new designTemplates();
                switch($this->command) {
                    case "message_ok":
                    case "view":
                        $this->Out("subtitle", $this->lang->development_designtemplates_view, OUT_AFTER);
                        $ret .= $this->ListDesignTemplates($dtemplates);
                        break;
                    case "remove":
                        if($core->security->Check(null, "interface.designes.delete")) {
                            $form = $this->post_vars("design_template_id_");
                            foreach($form as $item) {
                                $dtemplates->delete($item);
                            }
                            $ret .= $this->DoPostBack('view', 'get');
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "export":
                        
                        $form = $this->post_vars("design_template_id_");
                        $dt = new designTemplates();
                        $templates = $dt->enum();
                        $templates = $templates->ReadAll("templates_name");
                        foreach($form as $id) {
                            $d = $templates->item($id);
                            $content = $d->templates_body;
                            
                            $info = $this->checkSourceInFile($content);
                            if ($info->infile){
                                if ($info->content == -1)
                                    continue;
                                
                                $info->content = convert_string("UTF-8", $info->content);
                                $d->templates_body = $info->content;
                                $dt->save($d->templates_name, collection::create($d->Data()));
                            } else {
                                $path = strtolower($this->IOPath()->designes.$d->templates_name.".dsn.php");
                                $d->templates_body = "LOADFILE:".$path;
                                
                                if (is_empty($content))
                                    $content = "<"."?\n\t//макет дизайна\n?".">";
                                
                                if($core->fs->writefile($path, $content) > 0) {
                                    @system("chmod 777 ".$core->fs->mappath($path));
                                    $dt->save($d->templates_name, collection::create($d->Data()));
                                }
                                else {
                                    out("The file was not saved! File: ".$path);
                                }
                            }                        
                        }
                        
                        $ret .= $this->DoPostBack('view', 'get');
                        
                                                
                        break;
                }
                break;
            case "repository":
                $this->Out("title", $this->lang->development_repository, OUT_AFTER);
                
                if(!$core->security->Check(null, "interface.enter")) {
                    $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                    break;
                }

                switch($this->command) {
                    case "message_ok":
                    case "view":
                        $this->Out("subtitle", $this->lang->development_repository_view, OUT_AFTER);
                        $ret .= $this->ListRepository();
                        break;
                    case "remove":
                        if($core->security->Check(null, "interface.designes.delete")) {
                            $form = $this->post_vars("repository_id_");
                            foreach($form as $item) {
                                //Repository::Delete($item);
                                $lib = new Library($item);
                                $lib->Delete();
                                $mm = CModuleManager::Enum("module_libraries like '".$lib->name."'", "", false);
                                if (!$mm)
                                    continue;
                                foreach ($mm as $m){
                                    $i = $m->libraries->indexof($lib->name);
                                    if ($i !== false){
                                        $m->libraries->delete($i);
                                        $m->Save();
                                    }
                                }
                            }
                            $ret .= $this->DoPostBack("view", "get");
                        }
                        else {
                            $ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
                        }
                        break;
                    case "export":
                        
                        $form = $this->post_vars("repository_id_");

                        foreach($form as $id) {
                            
                            $lib = new Library($id);
                            $content = $lib->code;
                            $info = $this->checkSourceInFile($content);
                            if ($info->infile){ //save to db from file
                                if ($info->content == -1)
                                    continue;

                                $info->content = convert_string("UTF-8", $info->content);
                                $lib->code = $info->content;
                                $lib->Save();
                            } else { //save to file from db
                                $path = strtolower($this->IOPath()->repository.$lib->name.".inc.".$lib->ext);
                                $lib->code = "LOADFILE:".$path;

                                if (is_empty($content))
                                    $content = "<"."?\n\t//библиотека\n?".">";
                                
                                if($core->fs->writefile($path, $content) > 0){
                                    @system("chmod 777 ".$core->fs->mappath($path));
                                    $lib->Save();
                                }
                                else
                                    out("The file was not saved! File: ".$path);
                                    
                            }
                            
                        }
                        
                        $ret .= $this->DoPostBack('view', 'get');
                        
                                                
                        break;
                        
                }
                break;
        }
        return $ret;
    }

    function ListSites() {
        global $core;
        $lt = "\r\n";
        $ret = "";
        
        
        $dt = new designTemplates();
        $sites = Site::EnumTree();

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("addsdite", "iconpack(folder_add)", $this->lang->toolbar_add, TOOLBAR_BUTTON_LEFT, "addsite", "post", 'editor', 'sitefolder', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("editsite", "iconpack(folder_edit)", $this->lang->toolbar_edit, TOOLBAR_BUTTON_LEFT, "editsite", "post", 'editor', 'sitefolder', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("editproperties", "iconpack(folder_properties)", $this->lang->toolbar_properties, TOOLBAR_BUTTON_LEFT, "editproperties", "post", 'editor', 'sitefolder', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("removesite", "iconpack(folder_delete)", $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, "removesite", "post", null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarImageButton("publish", "iconpack(folder_publish)", $this->lang->toolbar_publishunpublish, TOOLBAR_BUTTON_LEFT, "publish_folder", "post"));
        $toolbar->Buttons->Add(new ToolbarImageFButton("permissions", "iconpack(folder_permissions)", $this->lang->toolbar_permissions, TOOLBAR_BUTTON_LEFT, "set_permissions", "post", 'editor', 'sitefolder', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageFButton("move", "iconpack(folder_move)", $this->lang->toolbar_move, TOOLBAR_BUTTON_LEFT, 'move', 'post', 'editor', 'sitefolder', null, 450, 200, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("up", "iconpack(folder_up)", $this->lang->toolbar_moveup, TOOLBAR_BUTTON_LEFT, 'moveup', 'post'));
        $toolbar->Buttons->Add(new ToolbarImageButton("down", "iconpack(folder_down)", $this->lang->toolbar_movedown, TOOLBAR_BUTTON_LEFT, 'movedown', 'post'));
        $toolbar->Buttons->Add(new ToolbarImageButton("browse", "iconpack(folder_publications)", $this->lang->toolbar_browse_publications, TOOLBAR_BUTTON_LEFT, "content", "get"));
        $toolbar->Render("toolbar");
        
        $cmd = new CommandBar($this);        
        $cmd->Render("toolbar_bottom");

        $parents = new ArrayList();
        $ret .= "
            <style>
                #tree ul {
                    list-style: none;
                    padding-left: 20px;    
                    margin: 0px 0px 0px 0px;
                }

            </style>
            <table border=0 cellspacing=0 cellpadding=0 class='content-table' id='tree' onselectstart='return false;' style='-moz-user-select: none'>
                <tr class='title'>
                    <td>".$this->lang->development_name."</td>
                </tr>
                <tr>
                    <td>
                        <ul style='padding-left: 0px;' id='tree_ul'>
        ".$lt;
        $i=0;
        foreach($sites as $site) {
            $w = 20;

            if($parents->Count() == 0)
                $parents->Add($site);
            elseif($site->level > $parents->Last()->level) {
                $parents->Add($site);
            }
            elseif($site->level < $parents->Last()->level) {
                while($site->level < $parents->Last()->level) {
                    $ret .= '
                        </ul>
                    </li>
                    ';
                    $parents->Delete($parents->Count() - 1);
                }
            }
            else {
                $parents->Delete($parents->Count() - 1);
                $parents->Add($site);
            }
            
            
            $ret .= '
                <li style="width: 100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr onclick="javascript: setRowCheck(this);" id="'.$site->name.$site->id.'" class="normal">
                            <td class="border">
                                '.$this->RenderFolderInfo($site, $dt).'
                            </td>
                            <td class="checkbox border">
                                '.$this->SetPostVar("sites_id_".$site->id, $site->id, "checkbox", "hilitable=1").'
                            </td>
                        </tr>
                    </table>
            ';
            if($site->children > 0)
                $ret .= '
                    <ul id="'.$site->name.'_childs" style="display: '.(!$site->published ? 'none' : '').'">
                ';
        }
        
        $parents->Delete($parents->Count() - 1);
        while($parents->Count() > 0) {
            $parents->Delete($parents->Count() - 1);
            $ret .= '
                    </ul>
                </li>
            ';
        }        
        
        
             
        $ret .= "
                        </ul>
                    </td>
                </tr>
            </table>
        ".$lt;
        $ret .= '
            <script>
                function ShowTreeNodes(ul) {
                    var i=0;
                    var lis = ul.childNodes;
                    for(i=0; i<lis.length; i++) {
                        if(lis[i].nodeName != "LI") 
                            continue;
                        
                        var t =    getFirstChildElement(lis[i]);
                        t =    getFirstChildElement(t.rows[0].cells[0]);
                            
                        var img = getFirstChildElement(t.rows[0].cells[0]);
                        if(img.getAttribute("normal")) {
                            var state = window.selectionInfo.getCookie("site_table_id_"+img.id);
                            if(state != null)
                                showBranch(img, state == "true");
                        }
                        
                        if(window.browserType == "IE") {
                            if(lis[i].childNodes[1] != undefined)
                                ShowTreeNodes(lis[i].childNodes[1]);
                        }
                        else { 
                            if(lis[i].childNodes[3] != undefined)
                                ShowTreeNodes(lis[i].childNodes[3]);    
                        }
                    }    
                }
                ShowTreeNodes(document.getElementById("tree_ul"));
            </script>
        ';        

        return $ret;

    }
    
    function RenderFolderInfo($site, $dt) {
        $lt = "\r\n";
        $sfp = "";
        if(!$site->published) {
            $sfp = "_closed";
        }
        
        $ret = "
                <table cellpadding=0 cellspacing=0 border=0 width=100%>
                    <tr>
                        <td class='icon'>".$lt;
                
                        if($site instanceof Site)
                            $ret .= $this->iconpack->CreateIconImage("iconpack(site".$sfp.")", '', 24, 24, 'closed="'.$this->iconpack->IconFromPack("iconpack(site_closed)").'" normal="'.$this->iconpack->IconFromPack("iconpack(site)").'" id="'.$site->id.'" onclick="javascript: return toggleBranch(this, event, \''.$site->id.'\')"').$lt;
                        else {
                            if($site->children > 0)
                                $ret .= $this->iconpack->CreateIconImage("iconpack(folder".$sfp."_ico)", '', 24, 24, 'closed="'.$this->iconpack->IconFromPack("iconpack(folder_closed_ico)").'" normal="'.$this->iconpack->IconFromPack("iconpack(folder_ico)").'" id="'.$site->id.'" onclick="javascript: return toggleBranch(this, event, \''.$site->id.'\')"').$lt;
                            else
                                $ret .= $this->iconpack->CreateIconImage("iconpack(folder)", '', 24, 24, 'id="'.$site->id.'"').$lt;
                        }
                    
        $ret .= "
                        </td>
                        <td>
                            <a class='tree-link".($site->published == 1 ? "" : "-disabled")."' href=\"#\" onclick=\"javascript: setCheckbox('sites_id_".$site->id."', true); PostBack('content', 'get'); event.cancelBubble=true; return false;\">".$site->description."</a>
                            ".$lt;

                            if($site instanceof Site)
                                $ret .= "<div class='small-text'>Domain name: <b>".($site->domain == "" ? "&lt;not set&gt;" : $site->domain)."</b>, ".($site->published ? "<b>published</b>, " : "<span style='color:red'>unpublished</span>")." template used: <b>".$dt->from_id($site->template)->templates_name.", last modified: ".$site->datemodified."</b></div>".$lt;
                            else
                                $ret .= "<div class='small-text'>Name: <b>".$site->name."</b>, ".($site->published ? "<b>published</b>" : "<span style='color:red'>unpublished</span>").", last modified: ".$site->datemodified."</b></div>".$lt;
        $ret .= "
                        </td>
                    </tr>
                </table>        
        ";
        return $ret;
    
    }

    function BrowseLevel($pubs, &$p) {
        global $core;
        $ret = "";
        $i=0;
        
        while($pub = $pubs->FetchNext()) {
            // if(!$p->exists("c".$pub->id)) {

            if(is_null($pub->datarow) && is_null($pub->module)) {
                $ret .= "";
            }
            else {

                $ret .= $pub->Out(null, hashtable::create("page", $this->page), OPERATION_ADMIN);

                if($pub->child_count > 0) {
                    $p->add("c".$pub->parent_id, $pub->parent_id);
                    $str = sprintf($this->lang->publication_children, $pub->child_count);
                    $ret .= "
                        <table cellpadding=0 cellspacing=0 border=0 class='subcontent-table'>
                            <tr>
                                <td class='collapseicon'>
                                    <img src='/admin/images/icons/treeview_expand.gif' normal='/admin/images/icons/treeview_expand.gif' hilited='/admin/images/icons/treeview_collapse.gif' onclick='javascript: toggleView(this);' alt='".$this->lang->expand_collapse_children_message."' style='cursor:hand'>
                                </td>
                                <td class='template-container' style='display:none;'>".$this->BrowseLevel($pub->Publications(), $p)."</td>
                                <td class='template-container small-text'>".$str."</td>
                            </tr>
                            <tr>
                                <td colspan='3' style='height: 1px; padding:0px; background-color: #C0C0C0; font-size: 1px'></td>
                            </tr>
                        </table>
                    ";
                    $p->Delete("c".$pub->parent_id, $pub->parent_id);
                }
            }
            /*
            }
            else {
                $ret .= "
                            <table cellpadding=0 cellspacing=0 border=0 class='subcontent-table'>
                                <tr>
                                    <td class='collapseicon'>
                                        <img height=1 width=30>
                                    </td>
                                    <td class='template-container' >
                                        <font color=red>RECURSION WITH ID=".$pub->child_id."</font>
                                        ".$this->SetPostVar("template_operation_id_".$pub->id, $pub->id, "checkbox", "hilitable=1")."
                                    </td>
                                </tr>
                                <tr>
                                    <td height=1></td>
                                    <td height=1 bgcolor='#C0C0C0'></td>
                                </tr>
                            </table>
                ";
            }
            */
            $i++;

        }

        return $ret;
    }

    function BrowsePublishingRules($sf) {
        global $core;
        $lt = "\r\n";
        $ret = "";
        $order = "";
        $pagerargs = "";
        
        $p = new collection();

        $page = $this->page;
        if($this->page == "") $page = 1;

        $pagesize = $this->rowsonpage;
        if(is_null($pagesize) || $pagesize=="") $pagesize = 10;

        $osf = Site::Fetch($sf);
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->move_to_other_issue.": "));
        $cmd->Containers->Add(new CommandBarNodesTreeContainer("sf_id", Site::EnumTree(), Site::Fetch($sf), "content"));
        $cmd->Containers->Add(new CommandBarSortPopupContainer("sortorder", $this->fld_name, $this->fld_order, $pagerargs, $this->lang, Publications::PublishedStorages($osf->id), "content"));
        $order = $cmd->Containers->sortorder->popup->order;
        $pagerargs = $cmd->Containers->sortorder->popup->pagerargs;
        $cmd->Render("toolbar_bottom");

        $filter = "";
        $args = $this->DispatchEvent("postbackform.structure.querycondition", collection::create(
                "folder", $osf, "condition", $filter
        ));
        $filter = @$args->condition;
        
        $tbst = new ArrayList();
        $tbst->Add(array('value' => '', 'text' => '...'));
        $storages = Storages::Enum();
        foreach($storages as $storage) {
            $tbst->Add(array('value' =>$storage->id, 'text' => $storage->name));
        }
        
        $publications = $osf->Publications($filter, $order, $page, $pagesize);
        
        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", 'iconpack(publication_add)', $this->lang->toolbar_addpublish, TOOLBAR_BUTTON_LEFT, 'view', 'get', 'publications', 'main', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("remove", 'iconpack(publication_delete)', $this->lang->toolbar_removepublication, TOOLBAR_BUTTON_LEFT, 'removedata', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarImageFButton("properties", 'iconpack(publication_properties)', $this->lang->toolbar_properties, TOOLBAR_BUTTON_LEFT, 'editproperties', 'post', 'editor', 'publicationdata', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageFButton("pmove", 'iconpack(publication_move)', $this->lang->toolbar_move, TOOLBAR_BUTTON_LEFT, 'pmoveto', 'post', 'publications', 'operations', null, 500, 420, false));
        $toolbar->Buttons->Add(new ToolbarImageButton("pmoveup", 'iconpack(publication_up)', $this->lang->toolbar_moveup, TOOLBAR_BUTTON_LEFT, 'pmoveup'));
        $toolbar->Buttons->Add(new ToolbarImageButton("pmovedown", 'iconpack(publication_down)', $this->lang->toolbar_movedown, TOOLBAR_BUTTON_LEFT, 'pmovedown'));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator0"));
        $toolbar->Buttons->Add(new ToolbarLabel("label1", $this->lang->toolbarlabel_quickedit));
        $toolbar->Buttons->Add(new ToolbarComboButton("storages", $tbst, TOOLBAR_BUTTON_LEFT, 'storage_id', ' style="width: 80px; margin-top: 5px;"', 'if(this.options[this.selectedIndex].value!=\'\') {'.$this->CreateFloatingPostBack('add', 'editor', 'publicationdata', 'post', null, 800, 600, true, null, false).'}'));
        $toolbar->Buttons->Add(new ToolbarImageFButton("adddata", 'iconpack(publication_edit_add)', $this->lang->toolbar_addpublished, TOOLBAR_BUTTON_LEFT, 'add', 'post', 'editor', 'publicationdata', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("editdata", 'iconpack(publication_edit_data)', $this->lang->toolbar_editpublished, TOOLBAR_BUTTON_LEFT, 'edit', 'post', 'editor', 'publicationdata', null, 800, 600, true));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator2"));
        $toolbar->Buttons->Add(new ToolbarPagerButton("pager", $page, $pagesize, $publications->Affected(), "?postback_command=content&postback_action=structure&postback_section=development&sites_id_".$osf->id."=".$osf->id.$pagerargs));
        $toolbar->Buttons->Add(new ToolbarImageButton("back", 'iconpack(go_back)', $this->lang->toolbar_backtofolders, TOOLBAR_BUTTON_RIGHT, 'view', 'get'));
        $toolbar->Render("toolbar");        
        
        $ret .= "
            <table width=100% border=0 cellspacing=0 cellpadding=4 class='content-table'>
                <tr class='title'>
                    <td>".$this->lang->development_publications."</td>
                    <td class='checkbox'>&nbsp;</td>
                </tr>
        ".$lt;

        if($publications->Count() > 0) {
            $ret .= "
                <tr class='normal'>
                    <td colspan='2'>";
            $ret .= $this->BrowseLevel($publications, $p);
            $ret .= "
                    </td>
                </tr>    
            ";
        }
        else {
            $ret .= "
                <tr class='normal'>
                    <td colspan='2'>
                        <span class='small-text'>".$this->lang->development_nopubs."</span>
                    </td>
                </tr>    
            ";
        }

        $ret .= "
            </table>
        ".$lt;
        
        return $ret;

    }

    function ListStorages() {
        global $core;
        $lt = "\r\n";
        $ret = "";
        $groups = Storages::Groups();

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("addstorage", "iconpack(storage_add)", $this->lang->toolbar_addstorage, TOOLBAR_BUTTON_LEFT, 'add', 'post', 'editor', 'storages', null, 500, 280, false));
        $toolbar->Buttons->Add(new ToolbarImageFButton("editstorage", "iconpack(storage_edit)", $this->lang->toolbar_editstorage, TOOLBAR_BUTTON_LEFT, 'edit', 'post', 'editor', 'storages', null, 500, 280, false));
        $toolbar->Buttons->Add(new ToolbarImageButton("remove", "iconpack(storage_delete)", $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, "removestorage", "post", null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator0"));
        $toolbar->Buttons->Add(new ToolbarImageFButton("copystorage", "iconpack(storage_copy)", $this->lang->copy_storage, TOOLBAR_BUTTON_LEFT, 'copy', 'post', 'editor', 'storages', null, 500, 280, false));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageButton("listfields", "iconpack(edit_fields)", $this->lang->toolbar_editfields, TOOLBAR_BUTTON_LEFT, "listfields", "get"));
        $toolbar->Buttons->Add(new ToolbarImageButton("templates", "iconpack(edit_templates)", $this->lang->toolbar_edittemplates, TOOLBAR_BUTTON_LEFT, "listtemplates", "get"));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator2"));
        $toolbar->Buttons->Add(new ToolbarImageFButton("permissions", "iconpack(storage_permissions)", $this->lang->toolbar_permissions, TOOLBAR_BUTTON_LEFT, 'set_permissions', 'post', 'editor', 'storages', null, 800, 600, false));
        if($core->security->currentUser->isSupervisor())
            $toolbar->Buttons->Add(new ToolbarImageButton("dumpscript", "iconpack(dumpscript)", $this->lang->toolbar_permissions, TOOLBAR_BUTTON_LEFT, 'dumpscript', 'post'));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator3"));
        $toolbar->Buttons->Add(new ToolbarImageButton("browse", "iconpack(browse_data)", $this->lang->toolbar_browse, TOOLBAR_BUTTON_LEFT, "browse", "get"));
        $toolbar->Render("toolbar");
        
        $cmd = new CommandBar($this);        
        $cmd->Render("toolbar_bottom");

        foreach($groups as $group) {
            
            $strgs = Storages::Enum($group); // all storages whitout parent , ''

            
            /*output*/
            $ret .= $this->RenderContentTableHeader();
            $ret .= $this->RenderContentTableHeaderRow(array(
                    is_empty($group) ? $this->lang->development_storage_default_group : $group
            ), true, true, '&nbsp;', null, $this->iconpack->CreateToggleButton("iconpack(node_collapse)", "iconpack(node_expand)", array($this->lang->toolbar_collapse, $this->lang->toolbar_expand), 16, 16, 'rows', ($group == "" ? "expanded" : "collapsed") ));
            
            foreach($strgs as $storage) {
                
                /*$dtrs = new Datarows($storage);
                $dtrs->Load();*/
                
                $ret .= $this->RenderContentTableContentRow(
                    "iconpack(storage)", 
                    array(
                        $storage->name." (".$storage->table.")",
                        "Fields count: <span class='green'>".$storage->fields->count()."</span>, Template count: <span class='green'>".$storage->templates->Count()."</span>, Rows count: <span class='red'>".$storage->tableInfo->rows."</span>"
                    ), 
                    "javascript: setCheckbox('storages_id_".$storage->id."'); PostBack('browse', 'get');", 
                    array(), 
                    true, 
                    $storage->id, 
                    "storages_id_");
            }
            $ret .= $this->RenderContentTableFooter()."<br />";
            
            
        }
        
        return $ret;

    }

    function ListFields($storage) {
        global $core;
        
        
        $lt = "\r\n";
        $ret = "";

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("addfield", 'iconpack(field_add)', $this->lang->toolbar_addfield, TOOLBAR_BUTTON_LEFT, 'addfield', 'post', 'editor', 'storages', null, 800, 600, false));
        $toolbar->Buttons->Add(new ToolbarImageFButton("editfield", 'iconpack(field_edit)', $this->lang->toolbar_editfield, TOOLBAR_BUTTON_LEFT, 'editfield', 'post', 'editor', 'storages', null, 800, 600, false));
        $toolbar->Buttons->Add(new ToolbarImageButton("removefield", 'iconpack(field_delete)', $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, 'removefield', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageButton("moveup", 'iconpack(field_up)', $this->lang->toolbar_moveup, TOOLBAR_BUTTON_LEFT, "moveup", "post"));
        $toolbar->Buttons->Add(new ToolbarImageButton("movedown", 'iconpack(field_down)', $this->lang->toolbar_movedown, TOOLBAR_BUTTON_LEFT, "movedown", "post"));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator2"));
        $toolbar->Buttons->Add(new ToolbarImageButton("templates", 'iconpack(edit_templates)', $this->lang->toolbar_edittemplates, TOOLBAR_BUTTON_LEFT, "listtemplates", "get"));
        $toolbar->Buttons->Add(new ToolbarImageButton("browse", 'iconpack(browse_data)', $this->lang->toolbar_browse, TOOLBAR_BUTTON_LEFT, "browse", "get"));
        $toolbar->Buttons->Add(new ToolbarImageButton("back", 'iconpack(go_back)', $this->lang->toolbar_backtostorages, TOOLBAR_BUTTON_RIGHT, 'view', 'get'));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);        
        $cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->development_select_storage.": "));
        $cmd->Containers->Add(new CommandBarStoragesListContainer("storage_id_change", Storages::Enum(), $storage, "listfields"));
        $cmd->Render("toolbar_bottom");


        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->development_field_name,
                $this->lang->development_field_group,
                $this->lang->development_field_type
        ), true, true);
        
        $fields = $storage->fields;
        foreach($fields as $field) {
            $typeText = $field->type;
            if($field->isLookup) {
                $l = $field->SplitLookup();
                $typeText = "<strong>lookup(".$l->table."; ".$field->type.")</strong>";
            }
            if($field->isMultilink) {
                $typeText = "<strong>multilink(".$field->onetomany.")</strong>";
            }
            
            $ret .= $this->RenderContentTableContentRow(
                "iconpack(field)", 
                array(
                    $field->name." (".$field->field.")",
                    "Requirement: ".($field->required == 1 ? "<b><span class='red'>required</span></b>" : "<b>can be passed</b>").
                    ", Template: ".($field->showintemplate == 1 ? "<span class='green'>Yes</span>" : "No")
                ), 
                "javascript: setCheckbox('storage_fields_id_".$field->storage_field_field."'); PostBackToFloater('editfield', 'post', 'editor', 'storages', null, null, 700, 520, true);", 
                array(
                    $field->group."&nbsp;",
                    $typeText
                ), 
                $hasCheckbox = true, 
                $field->field, 
                "storage_fields_id_");
        }
        $ret .= $this->RenderContentTableFooter();

        return $ret;
    }

    function ListTemplates($storage) {
        global $core;
        $lt = "\r\n";
        $ret = "";

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", 'iconpack(template_add)', $this->lang->toolbar_addtemplate, TOOLBAR_BUTTON_LEFT, 'addtemplate', 'post', 'editor', 'storages', null, 700, 520, false));
        $toolbar->Buttons->Add(new ToolbarImageFButton("edit", 'iconpack(template_edit)', $this->lang->toolbar_editselected, TOOLBAR_BUTTON_LEFT, 'edittemplate', 'post', 'editor', 'storages', null, 700, 520, false));
        $toolbar->Buttons->Add(new ToolbarImageButton("remove", 'iconpack(template_delete)', $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, 'removetemplate', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator1"));
        $toolbar->Buttons->Add(new ToolbarImageButton("export", 'iconpack(export)', $this->lang->toolbar_export, TOOLBAR_BUTTON_LEFT, 'exporttemplate', 'post', null, null, $this->lang->toolbar_exportmessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("separator2"));
        $toolbar->Buttons->Add(new ToolbarImageButton("listfields", 'iconpack(edit_fields)', $this->lang->toolbar_editfields, TOOLBAR_BUTTON_LEFT, "listfields", "get"));
        $toolbar->Buttons->Add(new ToolbarImageButton("browse", 'iconpack(browse_data)', $this->lang->toolbar_browse, TOOLBAR_BUTTON_LEFT, "browse", "get"));
        $toolbar->Buttons->Add(new ToolbarImageButton("back", 'iconpack(go_back)', $this->lang->toolbar_backtostorages, TOOLBAR_BUTTON_RIGHT, 'view', 'get'));
        $toolbar->Render("toolbar");

        $cmd = new CommandBar($this);        
        $cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->development_select_storage.": "));
        $cmd->Containers->Add(new CommandBarStoragesListContainer("storage_id_change", Storages::Enum(), $storage, "listtemplates"));
        $cmd->Render("toolbar_bottom");
        
        $ret .= $this->SetPostVar('storage_id', $storage->id);
        $ret .= $this->SetPostVar('template_type', "0");

        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->development_name,
                $this->lang->in_file
        ), true, true, null, array(null, 350));
        
        $templates = $storage->templates;
        foreach($templates as $template) {
            $state = $this->checkSourceInFile($template->list);
            $state_css = $this->checkSourceInFile($template->styles);
            $ii = $template->composite ? "iconpack(template_c)" : "iconpack(template)";
            $ret .= $this->RenderContentTableContentRow(
                $ii, 
                array(
                    !is_empty($template->description) ? $template->description.'('.$template->name.')' : $template->name,
                    null
                ), 
                "javascript: setCheckbox('storage_template_id_".$template->name."'); PostBackToFloater('edittemplate', 'post', 'editor', 'storages', null, null, 700, 520, true);", 
                array(
                    $state->path."<br/>".$state_css->path
                ), 
                $hasCheckbox = true, 
                $template->name, 
                "storage_template_id_");
        }
        $ret .= $this->RenderContentTableFooter();
        return $ret;
    }
    
    function BrowseData($storage) {
        global $core;
        $ret = "";
        $order = "";

        $pagerargs = "";
        $filter = FilterPopup::Query($this);
        if($filter)
            $pagerargs = "&".$filter;
        
        $ret .= $this->SetPostVar("storage_id", $storage->id);

        $strgs = Storages::Enum();

        $page = $this->page;
        if($this->page == "") $page = 1;
        
        $class = $storage->istree ? 'DataNodes' : 'DataRows';
        
        $data = new $class($storage);
        $data->pagesize = $this->rowsonpage; //$core->sts->SETTING_PAGESIZE;
        
        if(is_null($data->pagesize) || $data->pagesize=="") $data->pagesize = 10;

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->development_select_storage.": "));
        $cmd->Containers->Add(new CommandBarStoragesListContainer("storage_id_change", $strgs, $storage, "browse"));
        $cmd->Containers->Add(new CommandBarFilterPopupContainer("filter", $filter, $this->lang, "browse"));
        $cmd->Containers->Add(new CommandBarSortPopupContainer("sortorder", $this->fld_name, $this->fld_order, $pagerargs, $this->lang, array($storage), "browse"));
        
        $order = $cmd->Containers->sortorder->popup->order;
        $pagerargs = $cmd->Containers->sortorder->popup->pagerargs;
        // $cmd->Containers->Add(new CommandBarNodesTreeContainer("sf_id", Site::EnumTree(), Site::Fetch("site"), "browse"));
        $cmd->Render("toolbar_bottom");

        $cond = FilterPopup::Expression($this);
        
        $args = $this->DispatchEvent("postbackform.storage.querycondition", collection::create(
                "storage", $storage, "filter", "", "condition", $cond 
        ));

        $cond = @!is_empty($args->condition) ? $args->condition : $cond;
        if(!$cond) $cond = '';
        $data->LoadPage($page, "", $cond, $order);
        
        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", 'iconpack(data_add)', $this->lang->toolbar_adddata, TOOLBAR_BUTTON_LEFT, 'adddata', 'post', 'editor', 'storages', null, 700, 720, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("edit", 'iconpack(data_edit)', $this->lang->toolbar_editselected, TOOLBAR_BUTTON_LEFT, 'editdata', 'post', 'editor', 'storages', null, 700, 720, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("delete", 'iconpack(data_delete)', $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, 'removedata', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("sep1"));
        if($storage->istree) {
            $toolbar->Buttons->Add(new ToolbarImageFButton("moveto", 'iconpack(data_moveto)', $this->lang->toolbar_movetodata, TOOLBAR_BUTTON_LEFT, 'movetodata', 'post', 'editor', 'storages', null, 450, 150, true));
            $toolbar->Buttons->Add(new ToolbarImageButton("moveup", 'iconpack(data_moveup)', $this->lang->toolbar_moveupdata, TOOLBAR_BUTTON_LEFT, 'moveupdata', 'post'));
            $toolbar->Buttons->Add(new ToolbarImageButton("movedown", 'iconpack(data_movedown)', $this->lang->toolbar_movedowndata, TOOLBAR_BUTTON_LEFT, 'movedowndata', 'post'));
            $toolbar->Buttons->Add(new ToolbarSeparator("sep2"));
        }
        $toolbar->Buttons->Add(new ToolbarImageFButton("copy", 'iconpack(data_copy)', $this->lang->toolbar_copyrows, TOOLBAR_BUTTON_LEFT, 'copydata', 'post', 'editor', 'storages', null, 400, 250, true));
        $toolbar->Buttons->Add(new ToolbarSeparator("sep2"));        
        $toolbar->Buttons->Add(new ToolbarImageButton("export", 'iconpack(export)', $this->lang->toolbar_export, TOOLBAR_BUTTON_LEFT, 'export', 'post', null, null, $this->lang->toolbar_exportmessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("sep3"));
        $toolbar->Buttons->Add(new ToolbarPagerButton("pager", $page, $data->pagesize, $data->Affected(), "?postback_command=browse&postback_action=storages&postback_section=development&storages_id_".$storage->id."=".$storage->id.$pagerargs));
        $toolbar->Buttons->Add(new ToolbarImageButton("back", 'iconpack(go_back)', $this->lang->toolbar_backtostorages, TOOLBAR_BUTTON_RIGHT, 'view', 'get'));
        $toolbar->Render("toolbar");

        $ret .= $this->BrowseDataRows($data);

        return $ret;
    }
    
    function BrowseDataRows($dtrs) {
        $ret = "";
        while($row = $dtrs->FetchNext()) {
            $ret .= $row->Out(null, null, OPERATION_ADMIN);
        }    
        return $ret;    
        
        
    }

    function ListDesignTemplates($dt) {
        global $core;
        $lt = "\r\n";
        $ret = "";

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", 'iconpack(design_add)', $this->lang->toolbar_addtemplate, TOOLBAR_BUTTON_LEFT, 'add', 'post', 'editor', 'designtemplates', null, 700, 720, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("edit", 'iconpack(design_edit)', $this->lang->toolbar_editselected, TOOLBAR_BUTTON_LEFT, 'edit', 'post', 'editor', 'designtemplates', null, 700, 720, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("delete", 'iconpack(design_delete)', $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, 'remove', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("sep"));
        $toolbar->Buttons->Add(new ToolbarImageButton("export", 'iconpack(export)', $this->lang->toolbar_export, TOOLBAR_BUTTON_LEFT, 'export', 'post', null, null, $this->lang->toolbar_exportmessage));
        $toolbar->Render("toolbar");
        
        $cmd = new CommandBar($this);        
        $cmd->Render("toolbar_bottom");
        
        $r = $dt->enum();
        
        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->development_name,
                $this->lang->in_file,
        ), true, true, null, array(null, 350));
        
        while($template = $r->Read()) {
            $state = $this->checkSourceInFile($template->templates_body);
            $ret .= $this->RenderContentTableContentRow(
                "iconpack(dtemplate)", 
                array(
                    $template->templates_name,
                    null
                ), 
                "javascript: setCheckbox('design_template_id_".$template->templates_name."'); PostBackToFloater('edit', 'post', 'editor', 'designtemplates', null, null, 700, 720, true);", 
                array(
                    $state->path
                ), 
                $hasCheckbox = true, 
                $template->templates_name, 
                "design_template_id_");
        }
        $ret .= $this->RenderContentTableFooter();
        return $ret;
    }

    function ListRepository() {
        global $core;
        $lt = "\r\n";
        $ret = "";

        $libraries = Repository::Enum();

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("add", 'iconpack(component_add)', $this->lang->toolbar_addtemplate, TOOLBAR_BUTTON_LEFT, 'add', 'post', 'editor', 'repository', null, 700, 570, true));
        $toolbar->Buttons->Add(new ToolbarImageFButton("edit", 'iconpack(component_edit)', $this->lang->toolbar_editselected, TOOLBAR_BUTTON_LEFT, 'edit', 'post', 'editor', 'repository', null, 700, 570, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("delete", 'iconpack(component_delete)', $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, 'remove', 'post', null, null, $this->lang->toolbar_removemessage));
        $toolbar->Buttons->Add(new ToolbarSeparator("sep"));
        $toolbar->Buttons->Add(new ToolbarImageButton("export", 'iconpack(export)', $this->lang->toolbar_export, TOOLBAR_BUTTON_LEFT, 'export', 'post', null, null, $this->lang->toolbar_exportmessage));
        $toolbar->Render("toolbar");
        
        $cmd = new CommandBar($this);        
        $cmd->Render("toolbar_bottom");

        $a = array(    "PHP_CODE" => "Php code"
                    ,"HTML_CSS" => "Css style"
                    ,"HTML_SCRIPT" => "Script block"
                    ,"HTML_XSLT" => "Xslt stylesheet"
                    ,"HTML_XML" => "Xml page");
                   //                    , "HTML_OBJECT" => "Embed object"

        
        $ret .= $this->RenderContentTableHeader();
        $ret .= $this->RenderContentTableHeaderRow(array(
                $this->lang->development_name,
                $this->lang->development_repository_codetype,
                $this->lang->in_file
        ), true, true, null, array(null, null, 350));

        if($libraries->count() > 0) {
            foreach($libraries as $block) {
                $state = $this->checkSourceInFile($block->code);
                $ret .= $this->RenderContentTableContentRow(
                    "iconpack(".strtolower($block->type).")", 
                    array(
                        $block->name,
                        null
                    ), 
                    "javascript: setCheckbox('repository_id_".$block->name."'); PostBackToFloater('edit', 'post', 'editor', 'repository', null, null, 700, 570, true);", 
                    array(
                        $a[$block->type],
                        $state->path
                    ), 
                    $hasCheckbox = true, 
                    $block->name, 
                    "repository_id_");
            }
        }
        else {
            $ret .= $this->RenderContentTableContentEmptyRow($this->lang->development_nolibs, 2, true, true);
        }
        $ret .= $this->RenderContentTableFooter();

        return $ret;
    }

}
?>
