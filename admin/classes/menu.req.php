<?

    $this->menu->buttons['logout'] = new MenuItem('logout', $this->lang->tools_logout_text, $this->lang->tools_logout_desc, '<img src="images/v5/startmenu/logout.png" />', $this->CreatePostBack('logout', 'general', 'main', 'post'));
    $this->menu->buttons['options'] = new MenuItem('options', $this->lang->tools_settings_text, $this->lang->tools_settings_desc, '<img src="images/v5/startmenu/options.png" />', $this->CreateLink('view', 'tools', 'settings'));

    $this->menu->items["struct"] = new MenuItem("development", $this->lang->development_menu_text, $this->lang->development_menu_desc, $this->iconpack->IconFromPack("iconpack(struct)"), null);
	$this->menu->items["struct"]->children = array(
		"structure" =>  new MenuItem("structure", $this->lang->development_structure_text, $this->lang->development_structure_desc, $this->iconpack->IconFromPack("iconpack(structure)"), $this->CreateLink('view', 'development', 'structure')),
		"storages" =>  new MenuItem("storages", $this->lang->development_storages_text, $this->lang->development_storages_desc, $this->iconpack->IconFromPack("iconpack(storages)"), $this->CreateLink('view', 'development', 'storages')),
        "blobs" =>  new MenuItem("blobs", $this->lang->tools_blobmanager_text, $this->lang->tools_blobmanager_desc, $this->iconpack->IconFromPack("iconpack(blobs)"), $this->CreateLink('view', 'tools', 'blobs')),
        "files" =>  new MenuItem("files", $this->lang->tools_filemanager_text, $this->lang->tools_filemanager_desc, $this->iconpack->IconFromPack("iconpack(filemanager)"), $this->CreateFloatingPostBack('manage', 'publications', 'files', 'get', '', 800, 600, true)),
        "notices" =>  new MenuItem("notices", $this->lang->tools_notices_text, $this->lang->tools_notices_desc, $this->iconpack->IconFromPack("iconpack(notices)"), $this->CreateLink('view', 'tools', 'notices'))
	); 

    if($core->security->Check(null, "modules.enter")) {
        
        $modules = $core->mm->activemodules;
        $mcount = $modules->Count();

        if ($mcount > 0){
            $mvexists = false;
            for ($i = 0; $i < $mcount; $i++){
                $mod = $modules->Item($i);
                if ($mod->haseditor){
                    $mvexists = true;
                    break;
                }
            }
            
            if ($mvexists){
                $this->menu->items["mods"] = new MenuItem("mods", $this->lang->modules_menu_text, $this->lang->modules_menu_desc, $this->iconpack->IconFromPack("iconpack(mods)"), null);
                $this->menu->items["mods"]->children = array();
                for ($i = 0; $i < $mcount; $i++){
                    $mod = $modules->Item($i);
                    if (!$mod->haseditor)
                        continue;
                    $this->menu_link = $this->CreateLink('view', 'modules', $mod->entry);
                    $this->menu->items["mods"]->children[$mod->entry] = new MenuItem($mod->entry, $mod->title, $mod->description, $this->iconpack->IconFromPack("iconpack(modules)"), $this->menu_link);
                }
            }
        }
    
    }

    $this->menu->items["sep"] = new MenuItem("sep", null, "", null, null);

	$this->menu->items["devs"] = new MenuItem("devs", $this->lang->management_text, "", $this->iconpack->IconFromPack("iconpack(devs)"), null);
	$this->menu->items["devs"]->children = array(
        "designtemplates" =>  new MenuItem("designtemplates", $this->lang->development_design_templates_text, $this->lang->development_design_templates_desc, $this->iconpack->IconFromPack("iconpack(designtemplates)"), $this->CreateLink('view', 'development', 'designtemplates')),
        "repository" =>  new MenuItem("repository", $this->lang->development_repository_text, $this->lang->development_repository_desc, $this->iconpack->IconFromPack("iconpack(repository)"), $this->CreateLink('view', 'development', 'repository')),
        "modules" =>   new MenuItem("modules", $this->lang->tools_modules_text, $this->lang->tools_modules_desc, $this->iconpack->IconFromPack("iconpack(modules)"), $this->CreateLink('view', 'tools', 'modules'))
	);


	$this->menu->items["instruments"] = new MenuItem("instruments", $this->lang->tools_menu_text, $this->lang->tools_menu_desc, $this->iconpack->IconFromPack("iconpack(instruments)"), null);
	$this->menu->items["instruments"]->children = array(
		"usersex" =>  new MenuItem("usersex", $this->lang->tools_usermanager_text, $this->lang->tools_usermanager_desc, $this->iconpack->IconFromPack("iconpack(usermanager)"), $this->CreateLink('view', 'tools', 'usersex')),
		"settings" =>  new MenuItem("settings", $this->lang->tools_settings_text, $this->lang->tools_settings_desc, $this->iconpack->IconFromPack("iconpack(settings)"), $this->CreateLink('view', 'tools', 'settings')),
		"systemrestore" =>   new MenuItem("systemrestore", $this->lang->tools_systemrestore_text, $this->lang->tools_systemrestore_desc, $this->iconpack->IconFromPack("iconpack(systemrestore)"), $this->CreateLink('view', 'tools', 'systemrestore')),
	);
    if($core->security->currentUser->isSupervisor()) {
        $this->menu->items["instruments"]->children["script"] = new MenuItem("script", $this->lang->tools_exec_script, $this->lang->tools_exec_script_desc, $this->iconpack->IconFromPack("iconpack(execute_script)"), $this->CreateLink('view', 'tools', 'script'));
        $this->menu->items["instruments"]->children["recompile"] = new MenuItem("recompile", $this->lang->tools_recompile_core, $this->lang->tools_recompile_core_desc, $this->iconpack->IconFromPack("iconpack(execute_script)"), $this->CreateLink('recompile', 'tools', 'recompile_core'));
    }
    
    $this->menu->items["sep1"] = new MenuItem("sep", null, "", null, null);

    $this->menu->items["stats"] = new MenuItem("stats", $this->lang->tools_statistics_all_text, $this->lang->tools_statistics_all_desc, $this->iconpack->IconFromPack("iconpack(stats)"), null);
    $this->menu->items["stats"]->children = array(
        "statistics" =>  new MenuItem("statistics", $this->lang->tools_statistics_text, $this->lang->tools_statistics_desc, $this->iconpack->IconFromPack("iconpack(systemstats)"), $this->CreateLink('view', 'tools', 'statistics')),
        "sitestats" =>  new MenuItem("sitestats", $this->lang->tools_sitestats_text, $this->lang->tools_sitestats_desc, $this->iconpack->IconFromPack("iconpack(sitestats)"), $this->CreateLink('view', 'tools', 'sitestats')),
        "sep" =>  new MenuItem("sep", null, null, null, null),
        "access_log" =>  new MenuItem("access_log", $this->lang->tools_view_access_log, "", null, $this->CreateLink('view', 'tools', 'access_log')),
        "access_log_clear" =>  new MenuItem("access_log", $this->lang->tools_view_access_log.": ".$this->lang->toolbar_remove, "", null, $this->CreateLink('clear_access_log', 'tools', 'access_log')),
        "error_log" =>  new MenuItem("error_log", $this->lang->tools_view_error_log, "", null, $this->CreateLink('view', 'tools', 'error_log')), 
        "error_log_clear" =>  new MenuItem("error_log", $this->lang->tools_view_error_log.": ".$this->lang->toolbar_remove, "", null, $this->CreateLink('clear_error_log', 'tools', 'error_log'))
    );                 

?>