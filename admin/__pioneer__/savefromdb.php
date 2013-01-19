<?php

    set_time_limit(999999);
    include($_SERVER["DOCUMENT_ROOT"]."/autoexec.inc.php");
  
    
    $bs = new Blobs(BLOBS_ALL);
    
    foreach($bs as $b) {
        
        out($b->id, "/resources/images/blob_cache/".$b->id.".0x0.".$b->type, $core->fs->FileExists("/resources/images/blob_cache/".$b->id.".0x0.".$b->type));
        if(!is_null($b->data->data)) {
            out($core->fs->WriteFile("/resources/images/blob_cache/".$b->id.".0x0.".$b->type, $b->data->data));
        }
        else {
            out($b->id, "/resources/images/blob_cache/".$b->id.".0x0.".$b->type, $core->fs->FileExists("/resources/images/blob_cache/".$b->id.".0x0.".$b->type));    
        }
        
    }
   
   
  
?>
