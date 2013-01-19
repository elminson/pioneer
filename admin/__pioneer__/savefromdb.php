<?php

    set_time_limit(999999);
    include($_SERVER["DOCUMENT_ROOT"]."/autoexec.inc.php");
  
    
    $bs = new Blobs(BLOBS_ALL);
    
    foreach($bs as $b) {
        
        out($b->id, "/assets/static/".$b->id.".0x0.".$b->type, $core->fs->FileExists("/assets/static/".$b->id.".0x0.".$b->type));
        if(!is_null($b->data->data)) {
            out($core->fs->WriteFile("/assets/static/".$b->id.".0x0.".$b->type, $b->data->data));
        }
        else {
            out($b->id, "/assets/static/".$b->id.".0x0.".$b->type, $core->fs->FileExists("/assets/static/".$b->id.".0x0.".$b->type));
        }
        
    }
   
   
  
?>
