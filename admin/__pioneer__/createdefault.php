<?

set_time_limit(999999);

include($_SERVER["DOCUMENT_ROOT"]."/autoexec.inc.php");

$sr = $core->security;

$sr->systemInfo->operations->clear();
$sr->systemInfo->roles->clear();
$sr->systemInfo->operations->Merge(Site::getOperations());
$sr->systemInfo->operations->Merge(Folder::getOperations());
$sr->systemInfooperations->Merge(Storages::getOperations());
$sr->systemInfo->operations->Merge(designTemplates::getOperations());
$sr->systemInfo->operations->Merge(Repository::getOperations());
$sr->systemInfo->operations->Merge(blobs::getOperations());
$sr->systemInfo->operations->Merge(Notices::getOperations());
$sr->systemInfo->operations->Merge(Statistics::getOperations());
$sr->systemInfo->operations->Merge(Settings::getOperations());
$sr->systemInfo->operations->Merge(systemrestore::getOperations());
$sr->systemInfo->operations->Merge(SecurityEx::getOperations());

// roles
$administrator = new Role("system_administrator", "System administrator");
$administrator->AddRange(array(
			new RoleOperation("structure.*", US_ROLE_ALLOW),
			new RoleOperation("storages.*", US_ROLE_ALLOW),
			new RoleOperation("interface.*", US_ROLE_ALLOW),
			new RoleOperation("blobs.*", US_ROLE_ALLOW),
			new RoleOperation("notices.*", US_ROLE_ALLOW),
			new RoleOperation("statistics.*", US_ROLE_ALLOW),
			new RoleOperation("settings.*", US_ROLE_ALLOW),
			new RoleOperation("sysrestore.*", US_ROLE_ALLOW),
			new RoleOperation("usermanagement.*", US_ROLE_ALLOW)
));

$backupAdministrator = new Role("backup_administrator", "Backup administrator");
$backupAdministrator->Add(new RoleOperation("sysrestore.*", US_ROLE_ALLOW));

$manager = new Role("manager", "Data manager");
$manager->AddRange(array(
			new RoleOperation("structure.*", US_ROLE_ALLOW),
			new RoleOperation("storages.*", US_ROLE_ALLOW),
			new RoleOperation("blobs.*", US_ROLE_ALLOW),
			new RoleOperation("notices.*", US_ROLE_ALLOW)
));

$powermanager = new Role("power_manager", "Powered manager");
$powermanager->AddRange(array(
			new RoleOperation("structure.*", US_ROLE_ALLOW),
			new RoleOperation("storages.*", US_ROLE_ALLOW),
			new RoleOperation("blobs.*", US_ROLE_ALLOW),
			new RoleOperation("notices.*", US_ROLE_ALLOW),
			new RoleOperation("users.*", US_ROLE_ALLOW),
			new RoleOperation("statistics.*", US_ROLE_ALLOW)	
));

$usermanager = new Role("user_manager", "User manager");
$usermanager->AddRange(array(
			new RoleOperation("users.*", US_ROLE_ALLOW)
));

$developer = new Role("developer", "Site developer");
$developer->AddRange(array(
			new RoleOperation("structure.*", US_ROLE_ALLOW),
			new RoleOperation("structure.folders.publish", US_ROLE_DENY),
			new RoleOperation("storages.*", US_ROLE_ALLOW),
			new RoleOperation("storages.data.delete", US_ROLE_DENY),
			new RoleOperation("storages.data.edit", US_ROLE_DENY),
			new RoleOperation("storages.delete", US_ROLE_DENY),
			new RoleOperation("storages.fields.delete", US_ROLE_DENY),
			new RoleOperation("storages.templates.delete", US_ROLE_DENY),
			new RoleOperation("interface.*", US_ROLE_ALLOW),
			new RoleOperation("sysrestore.*", US_ROLE_ALLOW),
			new RoleOperation("settings.*", US_ROLE_ALLOW),
			new RoleOperation("settings.delete", US_ROLE_DENY),
			new RoleOperation("statistics.*", US_ROLE_DENY),
));

$mdeveloper = new Role("module_developer", "Module developer");
$mdeveloper->AddRange(array(
			new RoleOperation("storages.*", US_ROLE_ALLOW),
			new RoleOperation("settings.*", US_ROLE_ALLOW),
			new RoleOperation("modules.*", US_ROLE_ALLOW),
));

$sr->systemInfo->roles->Add($administrator);
$sr->systemInfo->roles->Add($backupAdministrator);
$sr->systemInfo->roles->Add($manager);
$sr->systemInfo->roles->Add($developer);
$sr->systemInfo->roles->Add($usermanager);
$sr->systemInfo->roles->Add($mdeveloper);


$sr->systemInfo->Store();

out($sr->systemInfo);


/*
			case "users":
				switch($this->command) {
					case "message_ok":
					case "view":
						$ret .= $this->ListGroups();
						break;
					case "add":
					case "edit":
						$form = $this->post_vars("groups_id_");
						if($form->count() > 1) {
							$ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
						}
						else {
							$group = $form->item(0);
							if($group <= 0 && $form->count() > 0)
								$ret .= $this->ErrorMessage($this->lang->error_cannotedit, $this->lang->error_message_box_title);
							else
								$ret .= $this->RenderGroupsForm($group);
						}

						break;
					case "cancel_edit":
						$ret .= $this->DoPostBack("view", "get");
						break;
					case "save_group_edit":

						$ret .= $this->SetPostVar("group_id", $this->group_id);
						$ret .= $this->SetPostVar("groups_name", $this->groups_name);
						$ret .= $this->DoPostBack("save", "post");

						break;
					case "save":
						$group = $this->group_id;
						if($group != "")
							$gid = $core->sr->updategroup($group, $this->groups_name);
						else
							$gid = $core->sr->addgroup($this->groups_name);

						$ret .= $this->DoPostBack("view", "get");
						break;
					case "remove":
						$form = $this->post_vars("groups_id_");
						foreach($form as $item)
							$core->sr->removegroup($item);
						$ret .= $this->DoPostBack("view", "get");
						break;
					case "listusers":
						$form = $this->post_vars("groups_id_");
						if($form->count() == 0 && $this->group_id == "")
							$ret .= $this->ListUsers(-1);
						else if($form->count() > 1)
							$ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
						else {
							if($this->group_id != "")
								$group = $this->group_id;
							else
								$group = $form->item(0);
							$ret .= $this->ListUsers($group);
						}
						break;
					case "adduser":
					case "edituser":
						$group = $this->group_id;
						$form = $this->post_vars("users_id_");
						if($form->count() > 1)
							$ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
						else {
							$user = $form->item(0);
							$ret .= $this->RenderUserEditForm($group, $user);
						}
						break;
					case "cancel_user_edit":
						$ret .= $this->SetPostVar("group_id", $this->group_id);
						$ret .= $this->DoPostBack("listusers", "get");
						break;
					case "saveuseragain":
						$group = $this->group_id;
						$user = $this->user_id;
						if($user === "")
							$user = -1;

						$user = $core->sr->user($user, collection::create("users_name", $this->users_name, "users_password", $this->users_password, "users_email", $this->users_email, "users_disabled", ($this->users_disabled == 1 ? 1 : 0), "users_issupervisor", ($this->users_issupervisor == 1 ? 1 : 0)));
						$core->sr->detachuserfromall($user);
						$argroups = explode(";", $this->users_groups);
						for($i=0; $i<count($argroups); $i++) {
							if(!empty($argroups[$i]))
								$core->sr->attachuser($argroups[$i], $user);
						}

						$ret .= $this->SetPostVar("group_id", $group);
						$ret .= $this->DoPostBack("listusers", "get");
						break;
					case "save_user":
						$group = $this->group_id;
						$user = $this->user_id;

						$ret .= $this->SetPostVar("group_id", $group);
						$ret .= $this->SetPostVar("user_id", $user);
						$form = $this->post_vars("users_");
						foreach($form as $k => $v)
							$ret .= $this->SetPostVar($k, $v);
						$ret .= $this->DoPostBack("saveuseragain", "post");

						break;
					case "removeuser":
						$form = $this->post_vars("users_id_");
						foreach($form as $item) {
							$core->sr->removeuser($item);
						}
						$ret .= $this->SetPostVar("group_id", $this->group_id);
						$ret .= $this->DoPostBack("listusers", "get");
						break;
					case "permissions":
						$form = $this->post_vars("groups_id_");
						if($form->count() > 1) {
							$ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
						}
						else {
							$group = $form->item(0);
							if($group <= 0)
								$ret .= $this->ErrorMessage($this->lang->error_cannotedit, $this->lang->error_message_box_title);
							else
								$ret .= $this->RenderPermissionsWizard($group);
						}
						break;
					case "save_permissions":

						$group = $this->group_id;

						$core->sr->permissions->deny_role($group, PERMISSION_NODE);

						$dbt = new dbtree("sys_tree", "tree");
						$root = $dbt->GetRootNode();
						$tree = $dbt->Branch($root->tree_id);

						$pp = GENERIC_DENY;
						$pn = "node_view_all";
						if($this->$pn == 1)
							$pp |= GENERIC_VIEW;
						$pn = "node_create_all";
						if($this->$pn == 1)
							$pp |= GENERIC_CREATE;
						$pn = "node_delete_all";
						if($this->$pn == 1)
							$pp |= GENERIC_DELETE;
						$pn = "node_modify_all";
						if($this->$pn == 1)
							$pp |= GENERIC_MODIFY;

						$core->sr->permissions->set_rolepermissions($root->tree_id, $group, $pp, PERMISSION_NODE);

						$p = array($pp);
						$lastlevel = 0;
						while($r = $tree->fetch_next()) {

							$pp = GENERIC_DENY;
							$pn = "node_view_".$r->tree_id;
							if($this->$pn == 1)
								$pp |= GENERIC_VIEW;
							$pn = "node_create_".$r->tree_id;
							if($this->$pn == 1)
								$pp |= GENERIC_CREATE;
							$pn = "node_delete_".$r->tree_id;
							if($this->$pn == 1)
								$pp |= GENERIC_DELETE;
							$pn = "node_modify_".$r->tree_id;
							if($this->$pn == 1)
								$pp |= GENERIC_MODIFY;

							$pn = "node_inherit_".$r->tree_id;
							if($this->$pn == 1)
								$pp = $p[$r->tree_level-1];

							if($r->tree_level > $lastlevel) {
								$p[] = $pp;
								$lastlevel = $r->tree_level;
							}
							else if($r->tree_level < $lastlevel) {
								array_splice($p, $r->tree_level, count($p) - $r->tree_level, $pp);
								$lastlevel = $r->tree_level;
							}
							else {
								array_splice($p, count($p)-1, 1, $pp);
							}

							$core->sr->permissions->set_rolepermissions($r->tree_id, $group, $pp, PERMISSION_NODE);

						}

						$core->sr->permissions->deny_role($group, PERMISSION_STORAGE);

						$st = new storages();
						$strgs = $st->enum();
						foreach($strgs as $k => $storage) {
							$pp = GENERIC_DENY;
							$pn = "storage_view_".$storage->id;
							if($this->$pn == 1)
								$pp |= GENERIC_VIEW;
							$pn = "storage_create_".$storage->id;
							if($this->$pn == 1)
								$pp |= GENERIC_CREATE;
							$pn = "storage_delete_".$storage->id;
							if($this->$pn == 1)
								$pp |= GENERIC_DELETE;
							$pn = "storage_modify_".$storage->id;
							if($this->$pn == 1)
								$pp |= GENERIC_MODIFY;


							$core->sr->permissions->set_rolepermissions($storage->id, $group, $pp, PERMISSION_STORAGE);
						}

						$ret .= $this->DoPostBack("view", "get");

						break;
				}
				break;
*/


// SPAWN
/*
	function ListGroups() {
		global $core;
		
		$ret = "";

		$this->RenderToolbar(array(
			array("add", "iconpack(users_add)", $this->lang->toolbar_add, "add", "post", null, null, null),
			array("edit", "iconpack(users_properties)", $this->lang->toolbar_edit, "edit", "post", null, null, null),
			array("remove", "iconpack(users_delete)", $this->lang->toolbar_remove, "remove", "post", null, null, $this->lang->toolbar_removemessage),
			array("separator"),
			array("premissions", "iconpack(users_permissions)", $this->lang->toolbar_permissions, "permissions", "post", null, null, null),
			array("separator"),
			array("listusers", "iconpack(user_list)", $this->lang->toolbar_viewusers, "listusers", "get", null, null, null)
		), TOOLBAR_IMAGEONLY);

		$ret .= "<table border=0 cellspacing=0 cellpadding=8 class='content-table'>";
		$ret .= "<tr class='title'>";
		$ret .= "<td class='border icon'>";
		$ret .= "&nbsp;";
		$ret .= "</td>";
		$ret .= "<td class='border'>";
		$ret .= $this->lang->tools_usermanager_groupname;
		$ret .= "</td>";
		$ret .= "<td class='border icon'>";
		$ret .= "</td>";
		$ret .= "</tr>";
		$ret .= "<tr onclick='javascript: setRowCheck(this);' class=normal id='group-1'>";
		$ret .= "<td class='border icon'>";
		$ret .= "&nbsp;";
		$ret .= "</td>";
		$ret .= "<td class='border'>&nbsp;";
		$ret .= "<a class=tree-link href=\"javascript: setCheckbox('groups_id_-1'); PostBack('listusers', 'get');\">".$this->lang->tools_usermanager_allusers."</a>";
		$ret .= "</td>";
		$ret .= "<td class='border icon'>";
		$ret .= $this->SetPostVar("groups_id_-1", -1, "checkbox", "hilitable=1");
		$ret .= "</td>";
		$ret .= "</tr>";
		$ret .= "<tr onclick='javascript: setRowCheck(this);' class=normal>";
		$ret .= "<td class='border icon'>";
		$ret .= "&nbsp;";
		$ret .= "</td>";
		$ret .= "<td class='border'>&nbsp;";
		$ret .= "<a class=tree-link href=\"javascript: setCheckbox('groups_id_-2'); PostBack('listusers', 'get');\">".$this->lang->tools_usermanager_ungroupedusers."</a>";
		$ret .= "</td>";
		$ret .= "<td class='border icon'>";
		$ret .= $this->SetPostVar("groups_id_0", 0, "checkbox", "hilitable=1");
		$ret .= "</td>";
		$ret .= "</tr>";
		if($core->sr->groups->count() > 0) {
			foreach($core->sr->groups as $k => $group) {
				$ret .= "<tr onclick='javascript: setRowCheck(this);' class=normal id='group".$group->groups_id."'>";
				$ret .= "<td class='border icon'>";
				$ret .= $this->iconpack->CreateIconImage("iconpack(user_group)", "", 24, 24, 'align=absmiddle');
				$ret .= "</td>";
				$ret .= "<td class='border'>";
				$ret .= "<a class=tree-link href=\"javascript: setCheckbox('groups_id_".$group->groups_id."'); PostBack('listusers', 'get');\">".$group->groups_name."</a>";
				$ret .= "</td>";
				$ret .= "<td class='border icon'>";
				$ret .= $this->SetPostVar("groups_id_".$group->groups_id, $group->groups_id, "checkbox", "hilitable=1");
				$ret .= "</td>";
				$ret .= "</tr>";
			}
		}
		else {
			$ret .= "<tr>";
			$ret .= "<td class='border icon'>";
			$ret .= "&nbsp;";
			$ret .= "</td>";
			$ret .= "<td class='border small-text'>";
			$ret .= $this->lang->tools_nogroups;
			$ret .= "</td>";
			$ret .= "<td class='border'>";
			$ret .= "&nbsp;&nbsp;";
			$ret .= "</td>";
			$ret .= "</tr>";
		}

		$ret .= "</table>";

		return $ret;

	}

	function RenderGroupsForm($group) {
		global $core;
		
		$ret = "";

		if(is_null($group))
			$g = new collection();
		else
			$g = $core->sr->groups->item($group);

		$ret .= $this->SetPostVar("group_id", $group);
		$ret .= "<table><tr><td>".$this->lang->tools_usermanager_groupname.": </td><td><input type=text class=text-box style='width:120px;' name=groups_name value='".$g->groups_name."'></td>";
		$ret .= "<td>";
		$ret .= "<input type=submit class=command-button name=save value='".$this->lang->save."' onclick=\"return PostBack('save_group_edit', 'post')\">";
		$ret .= "<input type=submit class=command-button name=cancel value='".$this->lang->cancel."' onclick=\"return PostBack('cancel_edit', 'post')\">";
		$ret .= "</td></tr></table>";
		return $ret;
	}

	function ListUsers($gid) {
		global $core;
		
		$ret = "";

		$this->RenderToolbar(array(
			array("add", "iconpack(user_add)", $this->lang->toolbar_add, "adduser", "post", null, null, null),
			array("edit", "iconpack(user_preferences)", $this->lang->toolbar_edit, "edituser", "post", null, null, null),
			array("remove", "iconpack(user_delete)", $this->lang->toolbar_removeselected, "removeuser", "post", null, null, $this->lang->toolbar_removemessage),
			array("!back", "iconpack(go_back)", $this->lang->toolbar_backtogroups, "view", "get", null, null, null)
		), TOOLBAR_IMAGEONLY);

		$ret .= $this->SetPostVar("group_id", $gid);
		$ret .= "<table width=100% border=0 cellspacing=0 cellpadding=8 class='content-table'>";
		$ret .= "<tr class='title'>";
		$ret .= "<td class='border icon'>";
		$ret .= "&nbsp;";
		$ret .= "</td>";
		$ret .= "<td class='border'>";
		$ret .= $this->lang->tools_users_name;
		$ret .= "</td>";
		$ret .= "<td class='border'>";
		$ret .= $this->lang->tools_users_email;
		$ret .= "</td>";
		$ret .= "<td class='border'>";
		$ret .= $this->lang->tools_users_created;
		$ret .= "</td>";
		$ret .= "<td class='border'>";
		$ret .= $this->lang->tools_users_lastlogged;
		$ret .= "</td>";
		$ret .= "<td class='border icon'>";
		$ret .= "</td>";
		$ret .= "</tr>";

		if($gid < 0)
			$users = $core->sr->listusers();
		else
			$users = $core->sr->getgroupusers($gid);

		if($users->count() > 0) {
			$users->disconnect();
			foreach($users as $k => $user) {
				$image = "user";
				if($user->users_disabled == 1)
					$image = "user_disabled";
				elseif($user->users_issupervisor == 1)
					$image = "user_supervisor";
					
				$ret .= "<tr onclick='javascript: setRowCheck(this);' class=normal id='user".$user->users_id."'>";
				$ret .= "<td class='border icon'>";
				$ret .= $this->iconpack->CreateIconImage("iconpack(".$image.")", "", 24, 24, 'align=absmiddle');
				$ret .= "</td>";
				$ret .= "<td class='border'>";
				$ret .= "<a class=tree-link href=\"javascript: setCheckbox('users_id_".$user->users_id."'); PostBack('edituser', 'post');\">".$user->users_name;
				$ret .= "</td>";
				$ret .= "<td class='border'>";
				$ret .= $user->users_email."&nbsp;";
				$ret .= "</td>";
				$ret .= "<td class='border'>";
				$ret .= $user->users_datecreated."&nbsp;";
				$ret .= "</td>";
				$ret .= "<td class='border'>";
				$ret .= $user->users_lastlogged.($user->users_lastloggedfrom ? "<br>from: ".$user->users_lastloggedfrom : "")."&nbsp;";
				$ret .= "</td>";
				$ret .= "<td class='border icon'>";
				$ret .= $this->SetPostVar("users_id_".$user->users_id, $user->users_id, "checkbox", "hilitable=1");
				$ret .= "</td>";
				$ret .= "</tr>";
			}
		}
		else {
			$ret .= "<tr>";
			$ret .= "<td class='border icon'>";
			$ret .= "&nbsp;";
			$ret .= "</td>";
			$ret .= "<td class='border small-text'>";
			$ret .= "No users found in this group";
			$ret .= "</td>";
			$ret .= "<td class='border'>";
			$ret .= "&nbsp;&nbsp;";
			$ret .= "</td>";
			$ret .= "</tr>";
		}

		$ret .= "</table>";

		return $ret;
	}

	function RenderUserEditForm($gid, $user) {
		global $core;
		
		$ret = "";

		$g = $core->sr->groups->item("row".$gid);
		if($user > 0)
			$u = $core->sr->user($user);
		else
			$u = new collection();


		$ret .= $this->SetPostVar("group_id", $gid);
		$ret .= $this->SetPostVar("user_id", $user);
		$ret .= "<script language='javascript'>\n";
		$ret .= "function serializeselect(s, sret) {\n";
		$ret .= " sret.value='';\n";
		$ret .= " for(var i=0; i<s.options.length;i++) {\n";
		$ret .= " 		sret.value += (s.options[i].selected ? s.options[i].value+';' : '');\n";
		$ret .= " }\n";
		$ret .= "}\n";
		$ret .= "function removeselection() {\n";
		$ret .= " var s = document.getElementById('idsUsers_Groups');\n";
		$ret .= " for(var i=0; i<s.options.length;i++) {\n";
		$ret .= " 		s.options[i].selected = false;\n";
		$ret .= " }\n";
		$ret .= "}\n";
		$ret .= "</script>";

		$ret .= "<table>";
		$ret .= "<tr><td>".$this->lang->tools_users_name.": </td><td><input type=text class=text-box style='width:120px;' name=users_name value='".$u->users_name."'></td></tr>";
		$ret .= "<tr><td>".$this->lang->tools_users_password.": </td><td><input type=password class=text-box style='width:120px;' name=users_password value='".$u->users_password."'></td></tr>";
		$ret .= "<tr><td>".$this->lang->tools_users_email.": </td><td><input type=text class=text-box style='width:120px;' name=users_email value='".$u->users_email."'></td></tr>";
		$ret .= "<tr><td>".$this->lang->tools_users_disabled.": </td><td><input type=checkbox class=check-box name=users_disabled value=1 ".($u->users_disabled == 1 ? "checked" : "")."></td></tr>";
		$ret .= "<tr><td>".$this->lang->tools_users_developer.": </td><td><input type=checkbox class=check-box name=users_issupervisor value=1 ".($u->users_issupervisor == 1 ? "checked" : "")."></td></tr>";
		$ret .= "<tr><td valign=top>".$this->lang->tools_users_selectgroups.": </td><td valign=top>";
		$ret .= "<input type=hidden name=users_groups value=0 id='idUsers_Groups'>";
		$ret .= "<select rows=10 name=susers_groups id='idsUsers_Groups' multiple class='select-box' style='width:150px;height:120px'>";

		$usergroups = $core->sr->getusergroups($u->users_id);
		$usergroups->disconnect();

		if($core->sr->groups->count() > 0) {
			foreach($core->sr->groups as $k => $group) {
				$ret .= "<option value='".$group->groups_id."' ".($usergroups->exists($group->groups_id) || $gid == $group->groups_id ? "selected" : "").">".$group->groups_name."</option>";
			}
		}
		$ret .= "</select><br>";
		$ret .= "<a href='#' onclick='removeselection();'>[".$this->lang->tools_users_removeselection."]</a>";
		$ret .= "</td></tr>";
		$ret .= "<tr><td colspan='2'>&nbsp;";
		$ret .= "</td></tr>";
		$ret .= "<tr><td colspan='2'>";
		$ret .= "<input type=submit class=command-button name=save value='".$this->lang->save."' onclick=\"serializeselect(document.getElementById('idsUsers_Groups'), document.getElementById('idUsers_Groups'));return PostBack('save_user', 'post')\">";
		$ret .= "<input type=submit class=command-button name=cancel value='".$this->lang->cancel."' onclick=\"return PostBack('cancel_user_edit', 'post')\">";
		$ret .= "</td></tr>";
		$ret .= "</table>";


		return $ret;
	}

	function RenderPermissionsWizard($group) {
		global $core;
		
		$ret = "";

		$dbt = new dbtree("sys_tree", "tree");
		$root = $dbt->GetRootNode();
		$tree = $dbt->Branch($root->tree_id);
		$tree->fetch_next();

		$name = $core->sr->groups->item($group)->groups_name;
		$ret .= $this->SetPostVar("group_id", $group);
		$ret .= "<script language=javascript>";
		$ret .= "	function setinherit(f, id, inh) {";
		$ret .= "		if(inh) {";
		$ret .= "			eval('f.node_inherit_'+id+'.checked = true');";
		$ret .= "			eval('f.node_view_'+id+'.checked = false');";
		$ret .= "			eval('f.node_create_'+id+'.checked = false');";
		$ret .= "			eval('f.node_delete_'+id+'.checked = false');";
		$ret .= "			eval('f.node_modify_'+id+'.checked = false');";
		$ret .= "			eval('f.node_deny_'+id+'.checked = false');";
		$ret .= "		} else {";
		$ret .= "			eval('f.node_inherit_'+id+'.checked = false');";
		$ret .= "			eval('f.node_deny_'+id+'.checked = false');";
		$ret .= "		}";
		$ret .= "	}";
		$ret .= "	function deny(f, id, inh) {";
		$ret .= "		if(inh) {";
		$ret .= "			eval('f.node_inherit_'+id+'.checked = false');";
		$ret .= "			eval('f.node_view_'+id+'.checked = false');";
		$ret .= "			eval('f.node_create_'+id+'.checked = false');";
		$ret .= "			eval('f.node_delete_'+id+'.checked = false');";
		$ret .= "			eval('f.node_modify_'+id+'.checked = false');";
		$ret .= "			eval('f.node_deny_'+id+'.checked = true');";
		$ret .= "		} else {";
		$ret .= "			eval('f.node_deny_'+id+'.checked = false');";
		$ret .= "		}";
		$ret .= "	}";
		$ret .= "	function denystorage(f, id, inh) {";
		$ret .= "		if(inh) {";
		$ret .= "			eval('f.storage_view_'+id+'.checked = false');";
		$ret .= "			eval('f.storage_create_'+id+'.checked = false');";
		$ret .= "			eval('f.storage_delete_'+id+'.checked = false');";
		$ret .= "			eval('f.storage_modify_'+id+'.checked = false');";
		$ret .= "			eval('f.storage_deny_'+id+'.checked = true');";
		$ret .= "		} else {";
		$ret .= "			eval('f.storage_deny_'+id+'.checked = false');";
		$ret .= "		}";
		$ret .= "	}";
		$ret .= "</script>";


		$ret .= "<table cellspacing=0 cellpadding=5 border=0 width='100%'>";
		$ret .= "<tr class='section'>";
		$ret .= "<td>";
		$ret .= $this->lang->tools_permissions_sitefolder;
		$ret .= "</td>";
		$ret .= "<td align=center width=40>";
		$ret .= $this->lang->tools_permissions_inherit;
		$ret .= "</td>";
		$ret .= "<td align=center width=40>";
		$ret .= $this->lang->tools_permissions_view;
		$ret .= "</td>";
		$ret .= "<td align=center width=40>";
		$ret .= $this->lang->tools_permissions_create;
		$ret .= "</td>";
		$ret .= "<td align=center width=40>";
		$ret .= $this->lang->tools_permissions_delete;
		$ret .= "</td>";
		$ret .= "<td align=center width=40>";
		$ret .= $this->lang->tools_permissions_modify;
		$ret .= "</td>";
		$ret .= "<td align=center width=40>";
		$ret .= $this->lang->tools_permissions_deny;
		$ret .= "</td>";
		$ret .= "</tr>";
		$alinks = array();
		$lastlevel = 0;
		$allperms = $core->sr->permissions->get_rolepermissions($root->tree_id, $group, PERMISSION_NODE);
		$ret .= '<tr>';
		$ret .= '<td style="border-bottom:1px solid #F2F2F2">';
		$ret .= '<table cellpadding=0 cellspacing=0 border=0><tr>';
		$ret .= '<td>';
		$ret .= $this->lang->tools_permissions_allstructure;
		$ret .= '</td>';
		$ret .= '</tr>';
		$ret .= '</table>';
		$ret .= '</td>';
		$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
		$ret .= '&nbsp;';
		$ret .= '</td>';
		$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
		$ret .= '<input type=checkbox class=check-box value=1 name="node_view_all" '.($core->sr->permissions->check($allperms, GENERIC_VIEW) ? 'checked' : '').'>';
		$ret .= '</td>';
		$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
		$ret .= '<input type=checkbox class=check-box value=1 name="node_create_all" '.($core->sr->permissions->check($allperms, GENERIC_CREATE) ? 'checked' : '').'>';
		$ret .= '</td>';
		$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
		$ret .= '<input type=checkbox class=check-box value=1 name="node_delete_all" '.($core->sr->permissions->check($allperms, GENERIC_DELETE) ? 'checked' : '').'>';
		$ret .= '</td>';
		$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
		$ret .= '<input type=checkbox class=check-box value=1 name="node_modify_all" '.($core->sr->permissions->check($allperms, GENERIC_MODIFY) ? 'checked' : '').'>';
		$ret .= '</td>';
		$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
		$ret .= '&nbsp;';
		$ret .= '</td>';
		$ret .= '</tr>';
		while($r = $tree->fetch_next()) {

			$perms = $core->sr->permissions->get_rolepermissions($r->tree_id, $group, PERMISSION_NODE);

			$c = $dbt->Ajar($r->tree_id)->count();
			$image = "folder_closed";
			if($c > 0)
				$image = "folder_opened";

			if($r->tree_level == 1)
				$image = "site";

			$ret .= '<tr>';
			$ret .= '<td style="padding-left:'.(($r->tree_level)*20).'px; border-bottom:1px solid #F2F2F2">';
			$ret .= '<table cellpadding=0 cellspacing=0 border=0><tr>';
			$ret .= '<td style="padding-left:5px;"><img src="/admin/images/icons/'.$image.'.gif"></td><td style="padding-left:10px;">';
			$ret .= $r->tree_description;
			$ret .= '</td>';
			$ret .= '</tr>';
			$ret .= '</table>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="setinherit(this.form, '.$r->tree_id.', true);" value=1 name="node_inherit_'.$r->tree_id.'" '.(!$core->sr->permissions->is_permissionset($r->tree_id, PERMISSION_NODE) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="setinherit(this.form, '.$r->tree_id.', false);" value=1 name="node_view_'.$r->tree_id.'" '.($core->sr->permissions->check($perms, GENERIC_VIEW) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="setinherit(this.form, '.$r->tree_id.', false);" value=1 name="node_create_'.$r->tree_id.'" '.($core->sr->permissions->check($perms, GENERIC_CREATE) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="setinherit(this.form, '.$r->tree_id.', false);" value=1 name="node_delete_'.$r->tree_id.'" '.($core->sr->permissions->check($perms, GENERIC_DELETE) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="setinherit(this.form, '.$r->tree_id.', false);" value=1 name="node_modify_'.$r->tree_id.'" '.($core->sr->permissions->check($perms, GENERIC_MODIFY) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="deny(this.form, '.$r->tree_id.', true);" value=1 name="node_deny_'.$r->tree_id.'" '.($perms == GENERIC_DENY ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '</tr>';
		}
		$ret .= '<tr>';
		$ret .= '<td>&nbsp;</td>';
		$ret .= '</tr>';
		$ret .= "<tr class='section'>";
		$ret .= "<td colspan=7>";
		$ret .= $this->lang->tools_permissions_storages;
		$ret .= "</td>";
		$ret .= "</tr>";

		$st = new storages();
		$strgs = $st->enum();
		foreach($strgs as $k => $storage) {
			$image = "storage";
			$perms = $core->sr->permissions->get_rolepermissions($storage->id, $group, PERMISSION_STORAGE);

			$ret .= '<tr>';
			$ret .= '<td style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<table cellpadding=0 cellspacing=0 border=0><tr>';
			$ret .= '<td style="padding-left:5px;"><img src="/admin/images/icons/'.$image.'.gif"></td><td style="padding-left:10px;">';
			$ret .= $storage->name;
			$ret .= '</td>';
			$ret .= '</tr>';
			$ret .= '</table>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '&nbsp;';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="denystorage(this.form, '.$storage->id.', false);" value=1 name="storage_view_'.$storage->id.'" '.($core->sr->permissions->check($perms, GENERIC_VIEW) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="denystorage(this.form, '.$storage->id.', false);" value=1 name="storage_create_'.$storage->id.'" '.($core->sr->permissions->check($perms, GENERIC_CREATE) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="denystorage(this.form, '.$storage->id.', false);" value=1 name="storage_delete_'.$storage->id.'" '.($core->sr->permissions->check($perms, GENERIC_DELETE) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="denystorage(this.form, '.$storage->id.', false);" value=1 name="storage_modify_'.$storage->id.'" '.($core->sr->permissions->check($perms, GENERIC_MODIFY) ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '<td align=center style="border-bottom:1px solid #F2F2F2">';
			$ret .= '<input type=checkbox class=check-box onclick="denystorage(this.form, '.$storage->id.', true);" value=1 name="storage_deny_'.$storage->id.'" '.($perms == GENERIC_DENY ? 'checked' : '').'>';
			$ret .= '</td>';
			$ret .= '</tr>';

		}

		$ret .= '<tr>';
		$ret .= '<td>&nbsp;</td>';
		$ret .= '</tr>';
		$ret .= '<tr>';
		$ret .= '<td colspan=7 align=right>';
		$ret .= '<input type=submit name=save value="'.$this->lang->setpermissions.'" class=command-button onclick="return PostBack(\'save_permissions\', \'post\')">&nbsp;&nbsp;';
		$ret .= '<input type=reset name=reset value="'.$this->lang->reset.'" class=command-button>';
		$ret .= '<input type=reset name=cancel value="'.$this->lang->cancel.'" class=command-button onclick="return PostBack(\'cancel_edit\', \'post\')">';
		$ret .= '</td>';
		$ret .= '</tr>';
		$ret .= '</table>';


		return $ret;
	}
	
	
					/*
					case "add":
						$form = $this->post_vars("blob_category_id_");
						if($form->count() > 1)
							$ret .= $this->ErrorMessage($this->lang->error_multiple_select_not_allowed, $this->lang->error_message_box_title);
						else {
							if($this->bc_id != "")
								$bc = $this->bc_id;
							else
								$bc = $form->item(0);

							$ret .= $this->SetPostVar("bc_id", $bc);
							$ret .= $this->SetPostVar("mode", "add");
							$ret .= $this->RenderCategoryAddEditForm($bc, null);

						}
						break;
					case "edit":
						$form = $this->post_vars("blob_category_id_");
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
								$category = blobs::Category($bc);
								$ret .= $this->SetPostVar("bc_id", $bc);
								$ret .= $this->SetPostVar("mode", "edit");
								$ret .= $this->RenderCategoryAddEditForm($category->parent, $category->id);
							}

						}
						break;
					
					/*	
					case "addresource":
						$ret .= $this->SetPostVar("bc_id", $this->bc_id);
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
							$ret .= $this->RenderBlobsBatchEditForm($form->item(0));
						}						
						
						break;
					case "saveaddresources":
						$bc_id = $this->bc_id;
						$blobscount = $core->rq->blobscount;
						
						for($i=1; $i<=$blobscount; $i++) {
							
							$alt = "alt".$i;
							$alt = $core->rq->$alt;
							$ff = "file".$i;
							$f = $core->rq->$ff;
							if($f->error == 0) {
								$bBlob = $f->binary();
								$strPath = $f->name;
								$blobs_type = $f->ext;
							}
							else {
								$url = "url".$i;
								$fUrl = $core->rq->$url;
								$bBlob = $core->bm->download($fUrl);

								$fname = basename($fUrl);
								$strPath = $fname;
								$af = preg_split("/\./", $fname);
								$blobs_type = @$af[1];
							}					  
							
							$blobid = $core->bm->save_blob(-1, $bBlob, $strPath, $blobs_type, $todatabase = true);

							$core->bm->set_options($blobid, $strPath, $blobs_type, $alt, $bc_id);
							
						}
						
						$ret .= $this->SetPostVar("bc_id", $this->bc_id);
						$ret .= $this->DoPostBack("content", "get");						
						
						break;
					case "saveeditresource":
						
						$bc_id = $this->bc_id;
						$blob_id = $this->blob_id;
						
						$alt = "alt";
						$alt = $core->rq->$alt;
						$ff = "file";
						$f = $core->rq->$ff;
						if($f->error == 0) {
							$bBlob = $f->binary();
							$strPath = $f->name;
							$blobs_type = $f->ext;
						}
						else {
							$url = "url";
							$fUrl = $core->rq->$url;
							$bBlob = $core->bm->download($fUrl);

							$fname = basename($fUrl);
							$strPath = $fname;
							$af = preg_split("/\./", $fname);
							$blobs_type = @$af[1];
						}					  
						
						$blobid = $core->bm->save_blob($blob_id, $bBlob, $strPath, $blobs_type, $todatabase = true);
						$core->bm->set_options($blobid, $strPath, $blobs_type, $alt, $bc_id);
						
						$ret .= $this->SetPostVar("bc_id", $this->bc_id);
						$ret .= $this->DoPostBack("content", "get");						
						
						break;
					/*
					case "cancel_edit":
						$ret .= $this->DoPostBack("view", "get");
						break;
					case "cancel_editresource":
						$ret .= $this->SetPostVar("bc_id", $this->bc_id);
						$ret .= $this->DoPostBack("content", "get");
						break;
											
*/
