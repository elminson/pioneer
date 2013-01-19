<?

    // $this - $postback
               
    $f = $this->menu->FindItem($this->postback_section, $this->postback_action);
    if($f) {
               
        $imax = 0;
        $items = $f->children;
        foreach($items as $i) {
            if($i->icon)
                $this->favorites->items[$i->name] = new FavoritesMenuItem($i->name, $i->title, $i->description, $i->icon, $i->link);
                
            if(++$imax > 4) break;
        }
    
    }
    
    // $this->favorites->items = $this->menu->FindItem($this->postback_section, $this->postback_action)->children;
    /* 
    $this->favorites->items = array(
        "structure" =>  new FavoritesMenuItem("structure", $this->lang->development_structure_text, "", $this->iconpack->IconFromPack("iconpack(structure)"), $this->CreateLink('view', 'development', 'structure')),
        "storages" =>  new FavoritesMenuItem("storages", $this->lang->development_storages_text, "", $this->iconpack->IconFromPack("iconpack(storages)"), $this->CreateLink('view', 'development', 'storages')),
        "blobs" =>  new FavoritesMenuItem("blobs", $this->lang->tools_blobmanager_text, "", $this->iconpack->IconFromPack("iconpack(blobs)"), $this->CreateLink('view', 'tools', 'blobs'))
    );
    
    /*
    $modules = $core->mm->activemodules;
    $mcount = $modules->Count();
    
    if ($mcount > 0){
        $mvexists = false;
        for ($i = 0; $i < $mcount; $i++){
            $mod = $modules->Item($i);
            if ($mod->haseditor && $mod->favorite){
                $this->favorites->items[$mod->entry] = new FavoritesMenuItem($mod->entry, $mod->title, "", $this->iconpack->IconFromPack("iconpack(modules)"), $this->CreateLink('view', 'modules', $mod->entry));
            }
        }
    }
    */    
    
    if(isset($this->favorites->items[@$_GET['postback_action']]))
        $this->favorites->items[$_GET['postback_action']]->selected = true;
    
?>
 