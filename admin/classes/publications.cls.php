<?php

/**
	* class Publications list
	*
	* Description for class PublicationsPageForm
	*
	* @author:
	*/
class PublicationsPageForm extends PostBackForm {
	public $lang;

	function PublicationsPageForm($lang = null) {
		parent::__construct("publications", "main", "/admin/floating.php", "get");
		if(is_null($this->lang))
			$this->lang = new stdClass();
	}
	
	public function IsMultiLink() {
		return !is_null($this->multilink_data_id) && !is_null($this->multilink_data_field) && !is_null($this->multilink_data_storage);
	}

	public function MenuVisible() {
		return false;
	}

	function RenderContent() {
		global $core;
		$ret = "";

		/*check if the folder id or name is not passed to the form*/

		$postback_parent = null;
		if(!is_null($this->postback_parent))
			$postback_parent = $this->postback_parent;
		else if(!is_null($this->sf_id))
			$postback_parent = $this->sf_id;
		else {
			$form = $this->post_vars("template_operation_");
		}
		$this->SetPostVar("postback_parent", $postback_parent);

		switch($this->action) {
			case "main":
				switch($this->command) {
					case "message_ok":
					case "message_cancel":
					case "view":
						$publication = null;
						
						$form = $this->post_vars("template_operation_id");
						$pid = "";
						if($form->count() == 1) {
							$ret .= $this->SetPostVar("pub_id", $form->item(0));
							$pid = $form->item(0);
						}
						
						if($this->pub_id) {
							$ret .= $this->SetPostVar("pub_id", $this->pub_id);
							$pid = $this->pub_id;
						}
						
						$strgs = storages::enum();
						
						$storage = $this->storage_id;
						
						if($storage == "") {
                            $storage = $strgs->first;
							$storage = $storage->id;
							if (is_null($storage)){
								$storage = -1;
								$this->storage_id = $storage;
							}
						}
						
						$pagerargs = ($pid != "" ? "pub_id=".$pid."&" : "")."sf_id=".$this->sf_id."&storage_id=".$storage;
						
						if($this->sf_id) {
							$sf = Site::Fetch($this->sf_id);
							$this->Out("subtitle", $this->lang->development_structure_addpublish." [".$sf->description."]", OUT_AFTER);
						}

						$ret .= $this->SetPostVar("sf_id", $this->sf_id);
						$ret .= $this->SetPostVar("storage_id", $storage);
						
						$ret .= $this->BrowseStorageData($this->sf_id, $storage, $strgs, $pagerargs);
						                                     
						$ret .= $this->FocusMe();

						break;
					case "publish":
						
						$publication = null;
						
						if($this->pub_id != "") {
							$publication = new Publication($this->pub_id, null);
							$osf = $publication->FindFolder();
							$publications = $publication->Publications();
						}
						else {
							$osf = Site::Fetch($this->sf_id);
							$publications = $osf->Publications();
						}
						
						if(!$core->security->CheckBatch($osf->createSecurityBathHierarchy("publications.add"))) {
							$ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
							break;
						}
						
						$form = $this->post_vars("template_operation_id");
						if ($this->storage_id != -1) {
							$storage = new Storage($this->storage_id);
							if(!$core->security->CheckBatch($storage->createSecurityBathHierarchy("data.publish"))) {
								$ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
								break;
							}
						}

						if($form->count() == 0) {
							$ret .= $this->ErrorMessage($this->lang->error_select_data, $this->lang->error_message_box_title);
						}
						else {
							$in = "";
							foreach($form as $item) {
								$in .= ",".$item;
							}
							$in = "(".substr($in, 1, strlen($in)-1).")";
								
							if ($this->storage_id != -1){		
								$dtr = new DataRows($storage);
								$dtr->Load("", $storage->table."_id in ".$in, "");
							
								while($dt = $dtr->FetchNext()) {
									$publications->Add($dt);
								}
                                
							} else {
								$mods = CModuleManager::Enum("module_id in ".$in, "", false);
								foreach ($mods as $mod)
									$rez = $publications->Add($mod);
									//iout('tut',$rez,"module_id in ".$in);
							}
						}

						$ret .= $this->SetPostVar("storage_id", $this->storage_id);												
						$ret .= $this->SetPostVar("filter", $this->filter);						
						$ret .= $this->SetPostVar("sf_id", $this->sf_id);
						$ret .= $this->ReloadOwner();
						$ret .= $this->DoPostBack('view', 'get');

						break;
					case "removestoragedata":
						$storages = new storages();
						$storage = new Storage($this->storage_id);
						if(!$core->security->CheckBatch($storage->createSecurityBathHierarchy("data.delete"))) {
							$ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
							break;
						}

						$ret .= $this->SetPostVar("sf_id", $this->sf_id);
						$ret .= $this->SetPostVar("storage_id", $this->storage_id);
						$ret .= $this->SetPostVar("pub_id", $this->pub_id);
						$form = $this->post_vars("template_operation_id");
						foreach($form as $dataid) {
							$dt = new DataRow($storage, $dataid);
							$dt->Delete();
						}
						$ret .= $this->ReloadOwner();
						$ret .= $this->DoPostBack("view", "get");

						break;
						
					case "close":
						$ret .= $this->CloseMe();
						break;
					}
				break;
			case "operations":
				switch($this->command) {
					/*move to */
					case "pmoveto":
						$form = $this->post_vars("template_operation_id");
						foreach($form as $key => $item) {
							$ret .= $this->SetPostVar($key, $item);
						}
						$ret .= $this->SetPostVar("sf_id", $this->sf_id);
						
						if($this->sf_id != "") {
							$sf = Site::Fetch($this->sf_id);
							$this->Out("subtitle", $this->lang->development_structure_movepubs." [".$sf->description."]", OUT_AFTER);
							$ret .= $this->RenderMoveForm($this->sf_id, "movepubs", "content");
						}
						
						break;
					case "movepubs":
						$form = $this->post_vars("template_operation_id");
						foreach($form as $key => $item) {
							$ret .= $this->SetPostVar($key, $item);
						}

						// permissions sf - publications.delete
						// permissions moveto - publications.add
						
						if(strpos($this->moveto, ",") !== false) {
							$a = explode(",", $this->moveto);
							foreach($a as $mt) {
								$ret .= $this->MoveCopy($mt, $form);
							}
						}
						else {
							$ret .= $this->MoveCopy($this->moveto, $form);
						}
						
						$ret .= $this->ReloadOwner(array("postback_section" => "development",
														 "postback_action" => "structure",
														 "postback_command" => "content",
														 "sf_id" => $this->sf_id));
						$ret .= $this->CloseMe();
						break;

				}
				break;
                
			case "blobs":
				switch($this->command) {
					case "select":
						$this->Out("subtitle", $this->lang->tools_blobs_selectresource, OUT_AFTER);
						$ret .= $this->RenderBlobSelectForm();
						break;
					case "add":
                    case "edit":
						if($this->edit)
							$this->Out("subtitle", $this->lang->tools_blobs_editresource, OUT_AFTER);
						else
							$this->Out("subtitle", $this->lang->tools_blobs_addresources, OUT_AFTER);
						$ret .= $this->RenderBlobAddForm();
						break;
					case "close":
						$ret .= $this->CloseMe();
						break;
				}
				break;
            case "structure":
                switch($this->command) {
                    case "select":
                        $ret .= $this->RenderStructure();
                        break;
                    case "setselection":
                    
                        $site = $this->post_vars("sites_id_");
                        $publication = $this->post_vars("template_operation_id_");

                        if($site->Count() > 0) {
                            $osf = Site::Fetch($site->Item(0));
                            $url = $osf->Url();
                            if($publication->Count() > 0) {
                                $pub = new Publication($publication->Item(0));
                                $url = $pub->Url();
                            }
                        }
                        
                        $this->Out("scripts", '
                            <script language="javascript">
                                function makeSelection(alt, w, href, handler) {
                                        handler(href, parseInt(w), false, alt);
                                        window.close();
                                }
                                makeSelection("", null, "'.$url.'", window.opener.SetUrl);
                            </script>
                        ');                        
                        
                        break;
                    case "close":
                        $ret .= $this->CloseMe();
                        break;
                }
                break;
			case "files":
				switch($this->command) {
					case "setselection":
						$this->Out("subtitle", $this->lang->tools_blobs_selectresource, OUT_AFTER);
						$ret .= $this->RenderFileSelectFormSetSelection();
						break;
                    case "manage":
                        $this->Out("subtitle", $this->lang->tools_blobs_selectresource, OUT_AFTER);
                        $ret .= $this->RenderFileSelectFormFolders(false);
                        break;
					case "select":
						$this->Out("subtitle", $this->lang->tools_blobs_selectresource, OUT_AFTER);
						$ret .= $this->RenderFileSelectFormFolders();
						break;
					case "select_files":
						$this->Out("subtitle", $this->lang->tools_blobs_selectresource, OUT_AFTER);
						$ret .= $this->RenderFileSelectForm();
						break;
					case "deletefolder":
						$folders = $this->post_vars("folder_id_");
						foreach($folders as $folder) {    
							$core->fs->DeleteDir($folder);
						}
						
						$ret .= $this->SetPostVar("handle", $this->handle);
						$ret .= $this->DoPostBack("select", "get");
						
						break;

					case "deletefile":
                        $folder = $this->folder_id_;
                        $post = $this->post_vars("template_operation");
						foreach($post as $file) {
							$core->fs->DeleteFile($folder.'/'.$file);
						}
						
						$ret .= $this->SetPostVar("handle", $this->handle);
						$ret .= $this->SetPostVar("folder_id_", $this->folder_id_);
						$ret .= $this->DoPostBack("select_files", "get");
						
						break;
					case "close":
						$ret .= $this->CloseMe();
						break;
				}
				break;
			case "multilink":
				switch($this->command) {
					case "add":
					case "edit":
						$did = $this->data_id;
						$dt = null;
						$s = new Storage($this->storage_id);
						if(!is_empty($did))
							$dt = new DataRow($s, $did);
						$ret .= $this->RenderDataEditor($s, $dt);
						break;
					case "select":	
						$storage = new Storage($this->storage_id);
						$data_ids = $this->data_ids;
						$handler = $this->handler;
						
						$pagerargs = "storage_id=".$this->storage_id."&data_ids=".$this->data_ids.
									  "&showall=".$this->showall;
						
						$this->Out("subtitle", $this->lang->development_repository_choosemulti." [".$this->multilink_data_field."]", OUT_AFTER);
						
						$ret .= $this->SetPostVar("storage_id", $storage->id);
						$ret .= $this->SetPostVar("data_ids", $data_ids);
						$ret .= $this->SetPostVar("handler", $handler);
						
						$ret .= $this->BrowseStorageData("", $storage->id, Storages::Enum(), $pagerargs);
						
						break;
					case "choose": 
						
						$form = $this->post_vars("template_operation");
						$storage = new Storage($this->storage_id);
						$data_ids = $this->data_ids;
						$handler = $this->handler;
						
						$htmls = array();
						foreach($form as $item) {
							$dt = new DataRow($storage, $item);
							$htmls[] = '["'.$item.'", "'.str_replace("\r", "\\r", str_replace("\n", "\\n", str_replace("\"", "\\\"", $dt->Out("", Hashtable::Create("admin_checkboxes", false), OPERATION_ADMIN)))).'"]';
						}
						
						$htmls = '['.implode(', ', $htmls).']';
						$script = '
							<script>
							function Save() {
								var handler = window.opener.'.$handler.';
								handler("select", '.$htmls.');
								window.close();
							}
							Save();
							</script>
						';
						$this->Out("scripts", $script, OUT_AFTER);
						
						break;
						
				}
				
				break;
			
		}
		return $ret;
	}
	
	function MoveCopy($mt, $form) {
		
		global $core;
		$ret = "";
		$moveto = Site::Fetch($mt);
		$sf = Site::Fetch($this->sf_id);
		if(is_null($moveto)) {
			return "";
		}
		if(!$this->copy) {
			if(!$core->security->CheckBatch($sf->createSecurityBathHierarchy("publications.delete"))
				|| !$core->security->CheckBatch($moveto->createSecurityBathHierarchy("publications.add")) ) {
				$ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
				break;
			}
			
			foreach($form as $item) {
				$pub = new Publication($item);
				$pub->MoveTo($moveto);
			}
		}
		else {
			if(!$core->security->CheckBatch($moveto->createSecurityBathHierarchy("publications.add")) ) {
				$ret .= $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
				break;
			}

			foreach($form as $item) {
				$pub = new Publication($item);
				$pub->CopyTo($moveto);
			}
			
		}	
		return $ret;	
	}

	/*browse storage data - publication*/
	function BrowseStorageData($sf, $st_id, $strgs, $pagerargs = "") {
		global $core;
		$ret = "";
		$order = "";
		$datas = $this->data_ids;
		
		$modules = $core->mm->activemodules;
		
        $sStorageData = @$core->security->currentUser->profile->admin->publicationsStorageData;
        
        if(!is_null($this->page))
            @$sStorageData->page = $this->page;
        $page = @$sStorageData->page;
        if(is_empty($page)) $page = 1;
        
        if(!is_null($this->rowsonpage))
            @$sStorageData->pagesize = $this->rowsonpage;
        $pagesize = @$sStorageData->pagesize;
        if(is_empty($pagesize)) $pagesize = 10;
		
		$filter = FilterPopup::Query($this);
		$fld_name = $this->fld_name;
		$fld_order = $this->fld_order;
		
        if($filter)
            $pagerargs .= "&".$filter;
        $pagerargs .= '&sf_id='.$this->sf_id.'&storage_id='.$this->storage_id;
			
		if(!is_null($datas)) {
			$showall = $this->showall == 1 ? true : false;
			if(is_null($showall) || $showall == "")
				$showall = false;
		}
		
        if(!is_null(@$sStorageData->storage) && is_null($this->storage_id && @$sStorageData->storage != -1))
            $storage = new Storage(@$sStorageData->storage);
        else {
            $storage = null;
            if ($st_id != -1)
                $storage = new Storage($st_id);
            @$sStorageData->storage = $st_id;
        }
        
        
		$cmd = new CommandBar($this);
		
		if(!is_null($datas)) {
			$cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->toolbar_choosemulti, "choose", "post"));
			$cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, "close", "post"));
			$cmd->Containers->Add(new CommandBarLabelContainer("label2", $this->lang->filter_multilink));
			$cmd->Containers->Add(new CommandBarContainer("checkbox1", "<input type=checkbox name=showall value=1 ".($showall ? " checked selected" : "")." onclick='javascript: PostBack(\"select\", \"post\")'>"));
		}
		else {
			$cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->development_select_storage.": "));
			$cmd->Containers->Add(new CommandBarStoragesListContainer("storage_id", $strgs, $storage, "view", !is_null($datas)));
			if($storage) {
				$cmd->Containers->Add(new CommandBarFilterPopupContainer("filter", $filter, $this->lang, "view", true, false));	
				$cmd->Containers->Add(new CommandBarSortPopupContainer("sortorder", $this->fld_name, $this->fld_order, $pagerargs, $this->lang, array($storage), "view", true, false));	
				$order = $cmd->Containers->sortorder->popup->order;
				$pagerargs = $cmd->Containers->sortorder->popup->pagerargs;
			}
		}
		
		$cmd->Render("toolbar_bottom");		
		
		
		if ($st_id != -1){
			
            if(is_null($storage))
			    $storage = new Storage($st_id);		    
			
			$cond = FilterPopup::Expression($this);
			
			if(!is_null($datas) && !$showall) {
				if(trim($datas) != "")
					$cond .= "(".$storage->table."_id not in (".$datas.") )";
			}

			$data = new DataRows($storage);
			$data->pagesize = $pagesize;

			$data->LoadPage($page, "", $cond, $order);
			
			$pcount = $data->Affected();
		} else {
			$pcount = $modules->Count();
		}
		
		$toolbar = new Toolbar($this);
		if(!is_null($datas)) {
			//$toolbar->Buttons->Add(new ToolbarImageButton('choose', 'iconpack(save_multilink)', $this->lang->toolbar_choosemulti, TOOLBAR_BUTTON_LEFT, 'choose', 'post', null, null, null, 1));
			//$toolbar->Buttons->Add(new ToolbarImageFButton('add', 'iconpack(data_add)', $this->lang->toolbar_adddata, TOOLBAR_BUTTON_LEFT, 'add', 'get', 'editor', 'storagedata',null,800, 550, true, "data_id"));
			//$toolbar->Buttons->Add(new ToolbarImageFButton('edit', 'iconpack(data_edit)', $this->lang->toolbar_editselected, TOOLBAR_BUTTON_LEFT, 'edit', 'get', 'editor', 'storagedata',null,800, 550, true));
			//$toolbar->Buttons->Add(new ToolbarImageButton('remove', 'iconpack(data_delete)', $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, 'removestoragedata', 'post', null, null, $this->lang->toolbar_removemessage));
			//$toolbar->Buttons->Add(new ToolbarImageButton('cancel', 'iconpack(go_back)', $this->lang->toolbar_cancelchoose, TOOLBAR_BUTTON_RIGHT, 'close', 'get', null, null, null, 1));
			
			$toolbar->Buttons->Add(new ToolbarPagerButton("pager", $page, $pagesize, $pcount, "floating.php?postback_command=select&postback_action=multilink&postback_section=publications&".$pagerargs."&handler=".$this->handler));
		}
		else {
			if ($st_id == -1) {
				$toolbar->Buttons->Add(new ToolbarImageButton('publish', 'iconpack(publication_addpublish)', $this->lang->toolbar_publish, TOOLBAR_BUTTON_LEFT, 'publish', 'post', null, null, null, 1));
				$toolbar->Buttons->Add(new ToolbarImageButton('close', 'iconpack(go_back)', $this->lang->toolbar_close, TOOLBAR_BUTTON_RIGHT, 'close', 'get', null, null, null, 1));
			} else {
				$toolbar->Buttons->Add(new ToolbarImageButton('publish', 'iconpack(publication_addpublish)', $this->lang->toolbar_publish, TOOLBAR_BUTTON_LEFT, 'publish', 'post', null, null, null, 1));
				$toolbar->Buttons->Add(new ToolbarImageFButton('add', 'iconpack(data_add)', $this->lang->toolbar_adddata, TOOLBAR_BUTTON_LEFT, 'add', 'get', 'editor', 'storagedata',null,800, 550, true, "data_id"));
				$toolbar->Buttons->Add(new ToolbarImageFButton('edit', 'iconpack(data_edit)', $this->lang->toolbar_editselected, TOOLBAR_BUTTON_LEFT, 'edit', 'get', 'editor', 'storagedata',null,800, 550, true));
				$toolbar->Buttons->Add(new ToolbarImageButton('remove', 'iconpack(data_delete)', $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, 'removestoragedata', 'post', null, null, $this->lang->toolbar_removemessage));
				$toolbar->Buttons->Add(new ToolbarImageButton('close', 'iconpack(go_back)', $this->lang->toolbar_close, TOOLBAR_BUTTON_RIGHT, 'close', 'get', null, null, null, 1));
			}

			$toolbar->Buttons->Add(new ToolbarPagerButton("pager", $page, $pagesize, $pcount, "floating.php?postback_command=view&postback_action=main&postback_section=publications&storage_id=".$this->storage_id."&".$pagerargs));
		}
		
		$toolbar->Render("toolbar");

		$ret .= '<img src="images/new/spacer1x1.gif" width="750" height="1">';
		if ($st_id != -1){
			if($data->Count() > 0) {
				while($row = $data->FetchNext()) {
					$ret .= $row->Out(null, null, OPERATION_ADMIN);
				}
			}
			else {
				$ret .= "<div class='small-text' style='padding-left:5px;'>".$this->lang->development_nopubs.".</div>";
			}
		} else {
			if($modules->Count() > 0) {
				foreach ($modules as $mod){
					if (!$mod->publicated)
						continue;
					$ret .= $mod->Out(null, null, OPERATION_ADMIN);
				}
			}
			else {
				$ret .= "<div class='small-text' style='padding-left:5px;'>".$this->lang->development_nopubs.".</div>";
			}
		}

		return $ret;

	}

  	function RenderMoveForm($sf, $okfunc = "movefolder", $cancelfunc = "cancel_edit") {
		$ret = "";

		$ret .= $this->SetPostVar('site_id', $sf);
		
		$folders = Site::EnumTree();
		$s = Site::Fetch($sf);

		$ret .= $this->RenderFormHeader();
		$ret .= $this->RenderFormRow($this->lang->development_copy, "copy", false, true, null, "check", false);
		$ret .= $this->RenderFormRow($this->lang->development_moveto, "moveto", array($folders, $s->id), false, 
									Hashtable::Create(	"titleField", "description", 
														"valueField", "id", "padleftField", "level", 
														"padleftMultiplier", 5, 
														"denyStyle", "color:#f00", 
														"denyObject", $s, 
														"denyExpression", "\$v->isChildOf(\$this->args->denyObject) || \$v->id==\$this->args->denyObject->id",
														"multiselect", true), 
														"combo");
		$ret .= $this->RenderFormFooter();
		
		$cmd = new CommandBar($this);
		$cmd->Containers->Add(new CommandBarButtonContainer("save", "submit", $this->lang->toolbar_move, $okfunc, "post"));
		$cmd->Containers->Add(new CommandBarButtonContainer("cancel", "submit", $this->lang->cancel, $cancelfunc, "post"));
		$cmd->Render("toolbar_bottom");

		return $ret;

	}

	function EchoBlobs($blobs) {
		global $core;
		global $category, $view, $sort;
			
		$ret = '';

		$s = new storage(null);

		
		$t = template::create(null, $s);	
		$t->dontcache = true;
		$t->composite = 0;
		$t->name = "icon";
		//wordwrap(str_clip($args->datarow->filename, 30), 13, "\n")
		$t->list = '
		<table class="admin-template" style="border:1px solid #c0c0c0; margin:5px; display: block; float:left; width: 145px;" cellpadding=4>
		<tr onclick="javascript: setRowCheck(this);" id="data<'.'?=$data->id?'.'>">
		<td style="height: 180px; width: 145px;">
			<div onclick="javascript: setRowCheck(this);" id="data<'.'?=$args->datarow->id?'.'>" style="text-align: center; float:left; width: 100%;">
				<'.'?=$args->datarow->mimetype->isViewable ? $args->datarow->Img(new Size(110, 110), \'alt="" border="0" style="margin:5px"\') : $args->datarow->mimetype->iconImage ?'.'>
			</div>
			<div style="text-align: center; float:left; width: 100%;">
				<'.'?=clip_filename($args->datarow->filename, 20)?'.'><br />
			</div>
		</td>
		<td valign=middle width=20 style="display: none">
			<input type=checkbox name="template_operation_id_<'.'?=$args->datarow->id?'.'>" value="<'.'?=$args->datarow->id?'.'>" class=checkbox hilitable=1>
		</td>
		</tr></table>
		';
		
		foreach($blobs as $blob) {
			$ret .= $t->Out(OPERATION_LIST, $blob); // OPERATION_ADMIN
		}
		return $ret;
	}
    
	function RenderBlobSelectForm() {
		global $core;
		global $category, $view, $sort;
		$ret = '';
		
        $sSelectBlobData = @$core->security->currentUser->profile->admin->publicationsSelectBlobData;
        
		if(!is_null($this->page))
            $sSelectBlobData->page = $this->page;
        
		$page = @$sSelectBlobData->page;
        if(is_empty($page)) $page = 1;
        
        if(!is_null($this->rowsonpage))
            @$sSelectBlobData->pagesize = $this->rowsonpage;
            
		$pagesize = @$sSelectBlobData->pagesize;
        if(is_empty($pagesize)) $pagesize = 10;
		
        if(!is_null($this->bc_id))
            $sSelectBlobData->category = $this->bc_id;
		$category = @$sSelectBlobData->category;
		if(is_empty($category)) $category = -1;
		
        if(!is_null($this->sort))
            $sSelectBlobData->sort = $this->sort;
		
		$sort = @$sSelectBlobData->sort;
		if(is_empty($sort)) $sort = "blobs_id";
		
        if(!is_null($this->view))
            @$sSelectBlobData->view = $this->view;
		$view = @$sSelectBlobData->view;
		if(is_empty($view)) $view = "icons";
		
			
		$handler = "handle";
		if($core->rq->handler != "")
			$handler = $core->rq->handler;

        $field = "";
        if($core->rq->field != "")
            $field = $core->rq->field;
		
		if($category > 0) {
			$bc = new BlobCategory(intval($category));
			$blobs = $bc->Blobs($sort, $page, $pagesize);
		}
		else {
			$bc = new BlobCategory();
			$blobs = new Blobs(null, $sort, $page, $pagesize);
		}
		
		$this->Out("scripts", '
			<script language="javascript">
			function Reload(id) {
				location = "?category="+id;
			}
			
			function unselectAll() {
				for(var i=0; i<window.items.length;i++){
					window.items[i].className = "normal";
				}
			}
			
			function makeSelection(id, alt, img, filename, type_id, category, w, h, href, handler, hname) {
				//try {
					if(hname == "SetUrl") {
						handler(href, parseInt(w), false, alt);
					}
					else
						handler(hname, window, id, alt, img, filename, type_id, category, parseInt(w), parseInt(h), href);
					window.close();
				//}
				//catch(e) {
				//}
				
			}
			
			function selectItem(obj, id) {
				var selected = document.getElementById("selected");
				selected.value = id;
				unselectAll();
				obj.className = "selected";
			}
			
			window.items = new Array();
			
			</script>
			
		');
		
		$form = $this->post_vars("template_operation");
		
		$multiselect = $this->multiselect;
		$multiselect = (bool)($multiselect);

		if($form->count() > 0) {
			if(!$multiselect) {
				$b = new Blob(intval($form->item(0)));
				$size = $b->size->TransformTo(new Size(100, 100));
				$this->Out("scripts", '
						<script language="javascript">			
						makeSelection('.$b->id.', "'.$b->alt.'", "'.$b->src(new Size(100,100), true).'", "'.$b->filename.'", "'.$b->type.'", "", "'.$size->width.'.", "'.$size->height.'", "'.$b->src(null, true).'", window.opener.'.$handler.', "'.(is_empty($field) ? $handler : $field).'");
						</script>
				');
			}
			else {
				$htmls = array();
				foreach($form as $item) {
					$dt = new Blob((int)$item);
					$htmls[] = '["'.$item.'", "'.str_replace("\n", "\\n", str_replace("\"", "\\\"", $dt->Out(null, Hashtable::Create("admin_checkboxes", false)))).'"]';
				}
				$htmls = '['.implode(', ', $htmls).']';
				$script = '
					<script>
					function Save() {
						var handler = window.opener.'.$handler.';
						handler("'.$field.'", "select", '.$htmls.');
						window.close();
					}
					Save();
					</script>
				';
				$this->Out("scripts", $script, OUT_AFTER);
				
			}
			return;
		}
		
		$cmd = new CommandBar($this);
		$cmd->Containers->Add(new CommandBarButtonContainer("select", "submit", $this->lang->toolbar_select, "select"));
		$cmd->Containers->Add(new CommandBarButtonContainer("close", "submit", $this->lang->toolbar_close, "close"));
		$cmd->Containers->Add(new CommandBarLabelContainer("label1", $this->lang->tools_blobs_category));
		$cmd->Containers->Add(new CommandBarBlobsCategoriesContainer("bc_id", new BlobCategories(), $bc));
		$cmd->Containers->Add(new CommandBarLabelContainer("label2", $this->lang->development_select_order));
		$cmd->Containers->Add(new CommandBarBlobsSortContainer("sort", $sort));
		$cmd->Render("toolbar_bottom");
		
		$toolbar = new Toolbar($this);
		$toolbar->Buttons->Add(new ToolbarImageFButton('add', 'iconpack(blob_add)', $this->lang->toolbar_addblob, TOOLBAR_BUTTON_LEFT, 'addresource', 'post', 'editor', 'blobs', null, 550, 600, false));
		$toolbar->Buttons->Add(new ToolbarPagerButton('pager', $page, $pagesize, $blobs->affected, "floating.php?postback_command=select&postback_action=blobs&postback_section=publications&handler=".$handler."&bc_id=".$category."&field=".$field));
		$toolbar->Render("toolbar");

		$ret .= '
			<input type="hidden" name="selected" id="selected" value="-1">
			<input type="hidden" name="handler" value="'.$handler.'">
            <input type="hidden" name="field" value="'.$field.'">
			<input type="hidden" name="multiselect" value="'.$this->multiselect.'">
		';
		
		$ret .= $this->echoBlobs($blobs);
		
		
		return $ret;
	}

	function RenderBlobAddForm() {
		
		global $core;
		$ret = '';
		
		$handle = $core->rq->handle;
		if(is_null($handle))
			$handle = "handle";

        $field = $core->rq->field;
        if(is_null($field))
            $field = "field";
	
		$edit = $core->rq->edit;
		if($edit)
			$editb = new Blob(intval($edit));
		else
			$editb = new Blob();

		if(!$core->security->Check(null, "blobs.items.add")) {
			return $this->ErrorMessage($this->lang->error_operation_not_permitted, $this->lang->error_message_box_title);
		}
        
        if(!is_null($core->rq->upload)) {
			$alt = "alt";
			$alt = $core->rq->$alt;
			$ff = "file";
			$f = $core->rq->$ff;
			if(!is_null($f) && !is_empty($f)) {
				$bBlob = $f->binary();
				$strPath = $f->name;
				$blobs_type = $f->ext;
			}
			else {
				$url = "url";
				$fUrl = $core->rq->$url;
				$bBlob = BlobData::Download($fUrl);
	
				$fname = basename($fUrl);
				$strPath = $fname;
				$af = preg_split("/\./", $fname);
				$blobs_type = @$af[1];
			}					  
			$category = $core->rq->category;
			if(!$category)
				$category = -1;
				
			if(!is_empty($edit)) {
				$b = $editb;
				$b->alt = $alt;
                $b->parent = $category;
                if($bBlob) {
                    $b->filename = $strPath;
                    $b->type = $blobs_type;
                    $b->data->data = $bBlob;
                }
                $b->Save();
                    
				$blobid = $b->id;
			}								
			else {
				$b = new Blob();
				$b->filename = $strPath;
				$b->type = $blobs_type;
				$b->alt = $alt;
                $b->parent = $category;
				$b->data->data = $bBlob;
				$b->Save();
				$blobid = $b->id;
			}
            
		}
        
        if(isset($blobid)) {
            $b = new Blob((int)$blobid);
            $html = str_replace("\n", "\\n", str_replace("\"", "\\\"", $b->Out(null, Hashtable::Create("admin_checkboxes", false))));
        }
        else
            $html = "";
        

		$ret .= $this->SetPostVar("handle", $handle);
        $ret .= $this->SetPostVar("field", $field);
		$ret .= $this->SetPostVar("edit", $edit);
        $ret .= $this->SetPostVar("return", $core->rq->return);

		$this->Out("scripts", '
			<script language="javascript">
				function makeSelection(id, alt, img, filename, type_id, category, w, h, href, handler, hname) {
		');
        if($core->rq->return == "html") {
            $this->Out("scripts", '
                handler("'.$field.'", "'.($edit != "" ? "edit" : "add").'", "'.$html.'", id);
            ');                                                    
        }
        else 
            $this->Out("scripts", '
                handler(hname, window, id, alt, img, filename, type_id, category, w, h, href);
            ');
        $this->Out("scripts", '
					window.close();
				}
				
			</script>
		
		');
		
		if($core->rq->upload) {
			$b = new Blob(intval($blobid));
			$size = $b->size->TransformTo(new Size(100, 100));
			$this->Out("scripts", '
				<script language="javascript">
					makeSelection('.$b->id.', "'.$b->alt.'", "'.$b->src(new Size(100,100)).'", "'.$b->filename.'", "'.$b->type.'", "", "'.$size->width.'", "'.$size->height.'", "'.$b->src().'", window.opener.'.$handle.', "'.$field.'");
				</script>
			');
		}
				
			
		$ret .= '
		
			<table cellpadding=0 cellspacing=0 border=0 class="content-table">
				<tr>
		';
					if($edit) {
		$ret .= '
					<td width="120" align="center" valign="middle">
		';
					if($editb->mimetype->isImage) {
		$ret .= '
						<a target="_blank" href="'.$editb->src(new Size()).'"><img src="'.$editb->src(new Size(100, 100)).'" border="0" ></a>
		';
					}
					else {
		$ret .= '
						<a target="_blank"  href="'.$editb->src(new Size()).'">'.$editb->mimetype->iconImage.'</a>
		';
					}
		$ret .= '
						
					</td>
		';
					}
		$ret .= '			
					<td>
						<input type="hidden" name="upload" value="upload" />
						<table cellpadding="3" cellspacing="3" border="0" align="center" class="content-table">
							<tr>
								<td align="left" valign="top" nowrap width="70" class="field">File: </td>
								<td align="left" valign="top" nowrap class="value"><input id="input" name="file" type="file" value="" class="alter-input">
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" nowrap width="70" class="field">File (URL): </td>
								<td align="left" valign="top" nowrap class="value"><input id="file_url" name="url" type="text" value="" class="alter-input">
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" nowrap width="70" class="field">Alt: </td>
								<td align="left" valign="top" nowrap class="value"><input id="alt" name="alt" type="text" value="'.$editb->alt.'" class="alter-input">
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" nowrap width="70" class="field">category: </td>
								<td align="left" valign="top" nowrap class="value">
								<select name="category" class="alter-input">
										<option value="-1"></option>
		';                              
										$cats = new BlobCategories();
										$ret .= $this->RenderBlobCategoriesOptions($cats, new BlobCategory());
		$ret .= '
								</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>		
		';
		
		$this->Out("toolbar_bottom", '
			<input id="upload" name="upload" type="submit" value="upload" class="small-button-long" onclick="javascript: PostBack(\''.$this->command.'\', \'post\');">
			<input id="cancel" name="cancel" type="submit" value="cancel" class="small-button-long" onclick="javascript: PostBack(\'close\', \'post\');">
		');
		
		return $ret;
	}
	
	
	function RenderFolderInfo($path) {
		$lt = "\r\n";
		global $core;
		
		$childs = $core->fs->list_dir($path);
		
		$paths = explode("/", $path);
		$foldername = $paths[count($paths) - 1];
		$rid = str_random(20);
		$ret = "
			<li style='width: 100%'>

				<table width='100%' border='0' cellspacing='0' cellpadding='10'>
					<tr onclick='javascript: setRowCheck(this);' id='".$foldername."' class='normal'>
						<td class='border'>
							
							<table cellpadding=0 cellspacing=0 border=0 width=100%>
								<tr>
									<td class='icon'>".$lt;
							
									if($childs->Count() > 0)
										$ret .= $this->iconpack->CreateIconImage("iconpack(folder_closed_ico)", '', 24, 24, 'closed="'.$this->iconpack->IconFromPack("iconpack(folder_closed_ico)").'" normal="'.$this->iconpack->IconFromPack("iconpack(folder_ico)").'" onclick="javascript: return toggleBranch(this, event)"').$lt;
									else
										$ret .= $this->iconpack->CreateIconImage("iconpack(folder)", '', 24, 24).$lt;
								
		$ret .= "
									</td>
									<td>
										<a class='tree-link' href=\"#\" onclick=\"javascript: setCheckbox('folder_id_".$rid."', true); PostBack('select_files', 'get'); event.cancelBubble=true; return false;\">".$foldername."</a>
									</td>
								</tr>
							</table>
							
						</td>
						<td class='checkbox border'>
							".$this->SetPostVar("folder_id_".$rid, $path, "checkbox", "hilitable=1")."
						</td>
					</tr>
				</table>
		";
		if($childs->Count() > 0) {
		$ret .= "
				<ul style='display: none'>
		";
			foreach($childs as $child) {
				$ret .= $this->RenderFolderInfo($path."/".$child);
			}
		$ret .= "
				</ul>
		";
		}
		$ret .= "
			</li>		
		";
		return $ret;
	
	}	
	function RenderFolders() {
		$ret = "";
		$lt = "\r\n";
		global $core;

		$path = "/resources";

		$folders = $core->fs->list_dir($path);

		$ret .= "
			<style>
				#tree ul {
					
					list-style: none;
					padding-left: 40px;	
					margin: 0px 0px 0px 0px;
					
				}
				
			</style>
			<table border=0 cellspacing=0 cellpadding=0 class='content-table' id='tree'>
				<tr class='title'>
					<td>".$this->lang->development_name."</td>
				</tr>
				<tr>
					<td style='padding-top: 10px; padding-left: 10px;'>
						<ul style='padding-left: 0px;'>
		".$lt;
		
		foreach($folders as $folder) {
			$ret .= $this->RenderFolderInfo($path."/".$folder);
		}		
		
		$ret .= "
						</ul>
					</td>
				</tr>
			</table>
		".$lt;		
		
		
		return $ret;
	}
    
    function BrowseLevel($pubs, &$p) {
        global $core;
        $ret = "";
        $i=0;
        
        while($pub = $pubs->FetchNext()) {
            if(!$p->exists("c".$pub->id)) {
                if(is_null($pub->datarow) && is_null($pub->module)) {
                    $ret .= "";
                }
                else {

                    $ret .= $pub->Out(null, hashtable::create("page", $this->page), OPERATION_ADMIN);

                    if($pub->child_count > 0) {
                        $p->add("c".$pub->parent_id, $pub->parent_id);
                        
                        $ret .= "
                            <table cellpadding=0 cellspacing=0 border=0 class='subcontent-table'>
                                <tr>
                                    <td class='collapseicon'>
                                        <img src='/admin/images/icons/treeview_expand.gif' normal='/admin/images/icons/treeview_expand.gif' hilited='/admin/images/icons/treeview_collapse.gif' onclick='javascript: toggleView(this);' alt='".$this->lang->expand_collapse_children_message."' style='cursor:hand'>
                                    </td>
                                    <td class='template-container' style='display:none;'>".$this->BrowseLevel($pub->Publications(), $p)."</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td height=1 bgcolor='#C0C0C0'></td>
                                </tr>
                            </table>
                        ";
                        $p->Delete("c".$pub->parent_id, $pub->parent_id);
                    }
                }
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
                                    <td></td>
                                    <td height=1 bgcolor='#C0C0C0'></td>
                                </tr>
                            </table>
                ";
            }
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

        $pagerargs = "";
        
        $osf = Site::Fetch($sf);
        
        $publications = $osf->Publications("", "", $page, $pagesize);
        
        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarPagerButton("pager", $page, $pagesize, $publications->Affected(), "?postback_command=select&postback_action=structure&postback_section=publications&sites_id_".$osf->id."=".$osf->id.$pagerargs));
        $toolbar->Buttons->Add(new ToolbarImageButton("back", 'iconpack(go_back)', $this->lang->toolbar_backtofolders, TOOLBAR_BUTTON_RIGHT, 'select', 'get'));
        $toolbar->Render("toolbar");
        
        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("select", "submit", $this->lang->toolbar_select, "setselection"));
        $cmd->Containers->Add(new CommandBarButtonContainer("close", "submit", $this->lang->toolbar_close, "close"));
        $cmd->Render("toolbar_bottom");

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
    
        
    function RenderStructure() {
        
        global $core;
        $lt = "\r\n";
        $ret = "";
        
        $sites = Site::EnumTree();

        $form = $this->post_vars("sites_id_");
        if($form->Count() > 0) {
            $ret .= $this->SetPostVar("sites_id_".$form->Item(0), $form->Item(0));
            $ret .= $this->BrowsePublishingRules($form->Item(0));
            return $ret;
        }

        $cmd = new CommandBar($this);
        $cmd->Containers->Add(new CommandBarButtonContainer("select", "submit", $this->lang->toolbar_select, "setselection"));
        $cmd->Containers->Add(new CommandBarButtonContainer("close", "submit", $this->lang->toolbar_close, "close"));
        $cmd->Render("toolbar_bottom");

        $toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageButton("browse", "iconpack(folder_publications)", $this->lang->toolbar_browse_publications, TOOLBAR_BUTTON_LEFT, "select", "get"));
        $toolbar->Render("toolbar");
        
        $parents = new ArrayList();
        $ret .= "
            <style>
                #tree ul {
                    list-style: none;
                    padding-left: 20px;    
                    margin: 0px 0px 0px 0px;
                }

            </style>
            <table border=0 cellspacing=0 cellpadding=0 class='content-table' id='tree'>
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
                                '.$this->RenderSFolderInfo($site).'
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
    
    function RenderSFolderInfo($site) {
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
                            <a class='tree-link".($site->published == 1 ? "" : "-disabled")."' href=\"#\" onclick=\"javascript: setCheckbox('sites_id_".$site->id."', true); PostBack('select', 'get'); event.cancelBubble=true; return false;\">".$site->description."</a>
                            ".$lt;
                            
                            if($site instanceof Site)
                                $ret .= "<div class='small-text'>Domain name: <b>".($site->domain == "" ? "&lt;not set&gt;" : $site->domain)."</b>, ".($site->published ? "<b>published</b>, " : "<span style='color:red'>unpublished</span>").", last modified: ".$site->datemodified."</b></div>".$lt;
                            else
                                $ret .= "<div class='small-text'>Name: <b>".$site->name."</b>, ".($site->published ? "<b>published</b>" : "<span style='color:red'>unpublished</span>").", last modified: ".$site->datemodified."</b></div>".$lt;
        $ret .= "
                        </td>
                    </tr>
                </table>        
        ";
        return $ret;
    
    }    
    
	
	function RenderFileSelectFormSetSelection() {
		$vars = $this->post_vars("folder_id_");
		$category = $vars->Item(0);
		$handler = $this->handler;
		
		$this->Out("scripts", '
			<script language="javascript">
			function makeSelection(id, alt, img, filename, type_id, category, w, h, href, handler, hname) {
				
//				try {
					if(hname == "SetUrl") {
						handler(href, parseInt(w), false, alt);
					}
					else
						handler(window, id, alt, img, filename, type_id, category, parseInt(w), parseInt(h), href);
					window.close();
//				}
//				catch(e) {
//				}
				
			}
			</script>
			
		');
		
		$form = $this->post_vars("template_operation");
		if($form->count() > 0) {
			
			if($form->count() > 1) {
				$sHrefs = '[';
				$sImgs = '[';
				foreach($form as $f) {
					// $file = $list->Item($f-1);
					$f = new FileView($category.'/'.$f);
					$sHrefs	.= '"'.$f->Src().'",';
					$sImgs	.= '"'.$f->Src(new Size(100, 75)).'",';
					
				}
				$sImgs	= substr($sImgs, 0, strlen($sImgs)-1).']';
				$sHrefs	= substr($sHrefs, 0, strlen($sHrefs)-1).']';
				$this->Out("scripts", '
						<script language="javascript">
						makeSelection(0, "", '.$sImgs.', "", "", "", "", "", '.$sHrefs.', window.opener.'.$handler.', "'.$handler.'");
						</script>
				');
			}
			else {
				$f = new FileView($category.'/'.$form->Item(0));
				$this->Out("scripts", '
						<script language="javascript">
						makeSelection(0, "", "'.$f->Src(new Size(100, 75)).'", "'.$form->Item(0).'", "'.$f->type.'", "", "'.$f->size->width.'", "'.$f->size->height.'", "'.$f->Src().'", window.opener.'.$handler.', "'.$handler.'");
						</script>
				');
			}
			return;
		}
	}
	
	function RenderFileSelectFormFolders($showSelectButton = true) {
		$ret = "";
		$ret .= $this->RenderFolders($showSelectButton);

		$ret .= $this->SetPostVar("handler", $this->handler);
        $ret .= $this->SetPostVar("showselectbutton", $showSelectButton ? 'true' : 'false');

		$toolbar = new Toolbar($this);
		$toolbar->Buttons->Add(new ToolbarImageFButton("add", "iconpack(folder_add)", $this->lang->toolbar_addnew, TOOLBAR_BUTTON_LEFT, "addfolder", "post", 'editor', 'files', null, 400, 250, true));
        $toolbar->Buttons->Add(new ToolbarImageButton("delete", "iconpack(folder_delete)", $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, "deletefolder", "get", null, null, $this->lang->toolbar_removemessage));
		$toolbar->Buttons->Add(new ToolbarSeparator("sep1"));
		$toolbar->Buttons->Add(new ToolbarImageButton("content", "iconpack(folder_publications)", $this->lang->toolbar_browse_files, TOOLBAR_BUTTON_LEFT,"select_files", "get"));
		$toolbar->Render("toolbar");
	
		$cmd = new CommandBar($this);
		// $cmd->Containers->Add(new CommandBarButtonContainer("select", "submit", $this->lang->toolbar_select, "select"));
		$cmd->Containers->Add(new CommandBarButtonContainer("close", "submit", $this->lang->toolbar_close, "close"));
		$cmd->Render("toolbar_bottom");	
		return $ret;	
	}
	
	function RenderFileSelectForm() {
		global $core;
		global $category, $view, $sort;
		$ret = '';
		
		$vars = $this->post_vars("folder_id_");
        $show = $this->showselectbutton == 'true' ? true : false;
		

		$page = $this->page;
		if($this->page == "") { 
			$page = $core->sts->FILE_MANAGER_LASTPAGE;
			if(is_null($page) || $page < 1)
				$page = 1;
		}
		else {
			$core->sts->FILE_MANAGER_LASTPAGE = $page;
		}

		$pagesize = $core->sts->SETTING_PAGESIZE;
		if(is_null($pagesize) || $pagesize=="") $pagesize = 10;
		
		$category = $vars->Item(0);

		$view = $core->rq->view;
		if(is_null($view))
			$view = "icons";
			
		$handler = "handle";
		if($core->rq->handler != "")
			$handler = $core->rq->handler;
			

		$list = $core->fs->ListFiles($category);
		
		$ret .= $this->SetPostVar("folder_id_", $category);
		$ret .= $this->SetPostVar("handler", $handler);
		
		$cmd = new CommandBar($this);
		if($show)
            $cmd->Containers->Add(new CommandBarButtonContainer("select", "submit", $this->lang->toolbar_select, "setselection"));
		$cmd->Containers->Add(new CommandBarButtonContainer("close", "submit", $this->lang->toolbar_close, "close"));
		$cmd->Render("toolbar_bottom");
		
		$toolbar = new Toolbar($this);
        $toolbar->Buttons->Add(new ToolbarImageFButton("upload", "iconpack(blob_add)", $this->lang->toolbar_upload, TOOLBAR_BUTTON_LEFT, "uploadfile", "get", 'editor', 'files', null, 500, 600, true));
		$toolbar->Buttons->Add(new ToolbarImageButton("delete", "iconpack(file_delete)", $this->lang->toolbar_removeselected, TOOLBAR_BUTTON_LEFT, "deletefile", "get", null, null, $this->lang->toolbar_removemessage));
		$toolbar->Buttons->Add(new ToolbarImageButton("back", "iconpack(go_back)", $this->lang->toolbar_backtofilefolders, TOOLBAR_BUTTON_RIGHT, "select", "get"));
		$toolbar->Render("toolbar");
		
		$ret .= $this->echoFiles($list, $category);
		
		
		return $ret;
		

		
	}
	
	function EchoFiles($files, $path) {
		global $core;
		$ret = "";
		
		
		$s = new storage(null);
		$t = template::create(null, $s);
		$i = 1;
		
		foreach($files as $file) {
			$t = template::create(null, $s);
            $t->dontcache = true;
			$t->name = "icon";
            // <'.'?=$args->datarow->mimetype->isViewable ? $args->datarow->Img(new Size(110, 110)) : $args->datarow->mimetype->iconImage ?'.'>
			$t->list = '
			<'.'?
			
			?'.'>
			<table class="admin-template" style="border:1px solid #c0c0c0; margin:5px; display: block; float:left; width: 145px;" cellpadding=4>
			<tr onclick="javascript: setRowCheck(this);" id="data<'.'?=$data->id?'.'>">
			<td style="height: 180px;  width: 145px;">
				<div onclick="javascript: setRowCheck(this);" id="data<'.'?=$args->datarow->id?'.'>" style="text-align: center; float:left; width: 100%;">
					<a target="_blank" href="<'.'?=$args->datarow->Src()?'.'>"><img src="<'.'?=$args->datarow->mimetype->icon ?'.'>" style="border: 0px;"></a>
				</div>
				<div style="text-align: center; float:left; width: 100%;">
					<'.'?=str_clip($args->datarow->name, 15)?'.'><br />
					<'.'?=size_to_string($args->datarow->filesize)?'.'>
				</div>
			</td>
			<td valign=middle width=20 style="display: none">
				<input type=checkbox name="template_operation_id_<'.'?=$args->datarow->id?'.'>" value="<'.'?=$args->datarow->id?'.'>" class=checkbox hilitable=1>
			</td>
			</tr></table>
			';
			$f = new FileView($path.'/'.$file->file);
			
			$ret .= $t->Out(OPERATION_LIST, $f);
		}
		return $ret;

	}
	
	function RenderDataEditor($storage, $dt = null) {
		$ret = "";
			
		$did = -1;
		if(!is_null($dt))
			$did = $dt->id;
			
		if(is_null($dt))
			$dt = new DataRow($storage, null);
		
		$handler = $this->handler;
		$ret .= $this->SetPostVar("handler", $handler);
		$ret .= $this->SetPostVar("storage_id", $storage->table);
		$ret .= $this->SetPostVar("data_id", $did);
			
		$editor = new Editor($dt, $this, "f1");
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
				$dt = new DataRow($storage, null);
				$dt->Fill($editor->get_request());
				$dt->id = $did;
				$dt->Save();
				
				$html = $dt->Out("", Hashtable::Create("admin_checkboxes", false), OPERATION_ADMIN);
				$script = '
					<script>
					function Save() {
						var handler = window.opener.'.$handler.';
						handler("'.$this->command.'", "'.db_prepare($html).'", "'.$dt->id.'");
						window.close();
					}
					Save();
					</script>
				';
				$this->Out("scripts", $script, OUT_AFTER);
			}
		}
		else {
			$ret .= $editor->Render();
		}
		$this->Out("toolbar_bottom", $editor->RenderCommandBar());
		return $ret;		
	}
	


}
?>
