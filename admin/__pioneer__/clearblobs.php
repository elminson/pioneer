<?php

	set_time_limit(999999);

	include($_SERVER["DOCUMENT_ROOT"]."/autoexec.inc.php");

	$list = new ArrayList();
	$used = new ArrayList();
	
	$s = Storages::Enum();
	foreach($s as $storage) { 
		$fields = $storage->fields;
		foreach($fields as $field) {
			if($field->type == "blob") {
				$list->Add(array($storage->table, $field->field));
			}
		}
	}
	
	foreach($list as $a) {
		$table = $a[0];
		$field = $a[1];
		$f = $table."_".$field;
		$r = $core->dbe->ExecuteReader("select ".$f." from ".$table." where ".$f." != '' and ".$f." != '0'");
		while($row = $r->Read()) {
			$used->Add($row->$f);
		}
	}
	
	
	$usedString = $used->ToString(",");
	
	out($usedString);
	
	$blobs = $core->dbe->ExecuteReader("select * from sys_blobs where blobs_id not in (".$usedString.")");
	$blobsData = $core->dbe->ExecuteReader("select * from sys_blobs_data where blobs_id not in (".$usedString.")");
	
	out("Removing unused blobs : ".$blobs->Count());

	$blobs = $core->dbe->Query("delete from sys_blobs where blobs_id not in (".$usedString.")");
	$blobsData = $core->dbe->Query("delete from sys_blobs_data where blobs_id not in (".$usedString.")");

	$blobs = new Blobs(BLOBS_ALL);	
	out("Blobs in database is sized : ".$blobs->Count());

	$ss = 0;
	foreach($blobs as $blob) {
		if( $blob->mimetype->isImage && ($blob->size->width < $blob->size->height && ($blob->size->width > 450 || $blob->size->height > 600)) || ($blob->size->width > $blob->size->height && ($blob->size->width > 600 || $blob->size->height > 450)) 	) {
			out("Found big image ".$blob->id." ".$blob->filename." ".$blob->data->size." <a href='".$blob->Src(null, true)."'>link</a> - RESIZING");
			
			if($blob->size->width < $blob->size->height) {
				$size = $blob->size->TransformTo(new Size(450, 600));
			}
			else {
				$size = $blob->size->TransformTo(new Size(600, 450));
			}
			

			$data = $blob->ReadCache($size, true);
			
			$ss += ($blob->data->size - strlen($data));
			
			$blob->data->data = $data;
			$blob->Save();
			
		}
		
		if(!$blob->isValid || !$blob->data->isValid) {
			out("Founded invalid image ".$blob->id." ".$blob->filename." ".$blob->data->size." - DELETED");
			$blob->Delete();
		}
		
	}
	
	out("Cleared: ".$ss);

?>