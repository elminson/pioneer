<?php
/**
* @package  MySQLdumper
* @version  1.0
* @author   Dennis Mozes <opensource@mosix.nl>
* @url		http://www.mosix.nl/mysqldumper
* @since    PHP 4.0
* @copyright Dennis Mozes
* @license GNU/LGPL License: http://www.gnu.org/copyleft/lgpl.html
**/
class systemrestore {
	private $_isDroptables;
	
	function systemrestore() {
		// Don't drop tables by default.
		$this->setDroptables(false);
	}

	function setDroptables($state) {
		$this->_isDroptables = $state;
	}
	
	function isDroptables() {
		return $this->_isDroptables;
	}
    
    private function _dumpTable($gzfile, $table, $idfield = '') {
        global $core;
        $gzfile->write("\n\n");
        $gzfile->write('// dumping data for table '.$table."\n");
        $gzfile->write('$core->dbe->TruncateTable("'.$table.'");'."\n");
        $result = $core->dbe->ExecuteReader("SELECT * FROM ".$table);
        while($row = $result->Read()) {
            $row = $core->dbe->PrepareRowData($table, $row->Data());
            $row = bin2hex(serialize(get_object_vars($row)));
            $gzfile->write('$core->dbe->Insert("'.$table.'", Collection::Deserialize(hex2bin(\''.$row.'\')));'."\n");
        }
        if(!is_empty($idfield))
            $gzfile->write('$core->dbe->SetAutoincrement("'.$table.'", "'.$idfield.'");');
    }
    
    private function _dumpTable2($dbe, $gzfile, $table, $idfield = '') {
        global $core;
        $gzfile->write("\n\n");
        $gzfile->write('// dumping data for table '.$table."\n");
        $gzfile->write('$core->dbe->TruncateTable("'.$table.'");'."\n");
        $result = $dbe->ExecuteReader("SELECT * FROM ".$table);
        while($row = $result->Read()) {
            $row = $dbe->PrepareRowData($table, $row->Data());
            $row = bin2hex(serialize(get_object_vars($row)));
            $gzfile->write('$dbe->Insert("'.$table.'", Collection::Deserialize(hex2bin(\''.$row.'\')));'."\n");
        }
        if(!is_empty($idfield))
            $gzfile->write('$dbe->SetAutoincrement("'.$table.'", "'.$idfield.'");');
    }
    
    public function DumpDatabase($driver, $server, $db, $user, $password) {
        
        global $core;
        
        set_time_limit(999999);

        $dumpname = $db.'-'.strftime("%Y%m%d%H%M%S", time()).".srp.gz";
        $gzfile = new GZFile($core->fs->mappath("/system_restore/".$dumpname), MODE_CREATEWRITE);

        $lf = "\r\n";
        
        $output  = "<"."?". $lf;
        
        $output .= "/*". $lf;
        $output .= " * Pioneer System Restore" . $lf;
        $output .= " * Pioneer version: 6.8.0".$lf;
        $output .= " * Host: " . $server . $lf;
        $output .= " * Generation Time: " . date("M j, Y \a\\t H:i") . $lf;
        $output .= " * PHP Version: " . phpversion() . $lf;
        $output .= " * Database : " . $db . "" . $lf;
        $output .= " */". $lf. $lf;
        $gzfile->write($output);
        
        $gzfile->write('
            error_reporting(E_ALL);
            ini_set("display_errors", "On");
            set_time_limit(0);
            
            include_once("autoexec.inc.php");
            
            $driver = $core->rq->driver;
            $server = $core->rq->server;
            $db = $core->rq->db;
            $user = $core->rq->user;
            $password = $core->rq->password;
            
            $drv = $driver."Driver";
            
            $dbe = new DBEngine(new $drv());
            $dbe->Connect($server, $user, $password, $db);
            
            header("Content-type: text/html; charset=utf-8");
        
            if($core->rq->post_start != "true") {
                echo "
                    <p>Пожалуйста, удалите все системные таблицы и таблицы хранилищ из базы данных и нажмите на кнопку &lt;Восстановить&gt;</p>
                    
                    <form action=\"\" method=\"post\">
                        Драйвер: <input type="text" name="server" value="'.$driver.'" />
                        Сервер: <input type="text" name="server" value="'.$server.'" />
                        База данных: <input type="text" name="db" value="'.$db.'" />
                        Пользователь: <input type="text" name="user" value="'.$user.'" />
                        Пароль: <input type="text" name="password" value="'.$password.'" />
                        <p><input type=\"button\" value=\"Восстановить\" onclick=\"location=\'?post_start=true\';return false;\" /></p>
                    </form>
                    
                ";
            } 
            else {
                echo "
                    <p>Восстановление данных системы</p>
                    <p>Пожалуйста дождитесь окончания</p>
                ";
                flush();
        ');
        
        $drv = $driver."Driver";
        $dbe = new DBEngine(new $drv());
        $dbe->Connect($server, $user, $password, $db);
        
        $tables = $dbe->Tables(true);
        foreach($tables as $table) {
            $gzfile->write('if($driver == \'mssql\') $dbe->Query(\'set identity_insert '.$table.' on\');' . $lf);
            $this->_dumpTable2($dbe, $gzfile, $table);
            $gzfile->write('if($driver == \'mssql\') $dbe->Query(\'set identity_insert '.$table.' off\'); ' . $lf);
        }
        
        $gzfile->write('
                unlink(__FILE__);
            }
            exit;
        ');
        
        $gzfile->write("?".">". $lf);
        
        $gzfile->close();
        return $dumpname;        
        
    }                                    
    
    public function CreatePoint() {
        global $core;
        
        $dumpname = strftime("%Y%m%d%H%M%S", time()).".srp.gz";
        $gzfile = new GZFile($core->fs->mappath("/system_restore/".$dumpname), MODE_CREATEWRITE);

        // set the limit of time script run
        set_time_limit(999999);
        
        $lf = "\r\n";
        
        // Set header
        
        $output  = "<"."?". $lf;
        
        $output .= "/*". $lf;
        $output .= " * Pioneer System Restore" . $lf;
        $output .= " * Pioneer version: 1.5.0".$lf;
        $output .= " * Host: " . $core->server . $lf;
        $output .= " * Generation Time: " . date("M j, Y \a\\t H:i") . $lf;
        $output .= " * PHP Version: " . phpversion() . $lf;
        $output .= " * Database : " . $core->database . "" . $lf;
        $output .= " */". $lf. $lf;
        $gzfile->write($output);
        
        // надо сделать удаление таблиц
        
        $gzfile->write('
            error_reporting(E_ALL);
            ini_set("display_errors", "On");
            set_time_limit(0);
            
            include_once("autoexec.inc.php");
            
            header("Content-type: text/html; charset=utf-8");
            
        
            if($core->rq->post_start != "true") {
                echo "
                    <p>Пожалуйста, удалите все системные таблицы и таблицы хранилищ из базы данных и нажмите на кнопку &lt;Восстановить&gt;</p>
                    <p><input type=\"button\" value=\"Восстановить\" onclick=\"location=\'?post_start=true\';return false;\" /></p>
                ";
            } 
            else {
                echo "
                    <p>Восстановление данных системы</p>
                    <p>Пожалуйста дождитесь окончания</p>
                ";
                flush();
        ');
        
        
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_storages on\');' . $lf);
        $strgs = new Storages();
        $strgs = $strgs->Enum();
        foreach($strgs as $storage) {
            $gzfile->write($storage->ToPhpScript().$lf.$lf);
        }
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_storages off\');' . $lf);


        $gzfile->write(Repository::Enum()->ToPHPScript());
        
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_templates on\');' . $lf);
        $gzfile->write(designTemplates::ToPHPScript());
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_templates off\');' . $lf);
        
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_modules on\');' . $lf);
        $gzfile->write($core->mm->ToPHPScript());
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_modules off\');' . $lf);
        
        foreach($strgs as $storage) {
            $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert '.$storage->table.' on\');' . $lf);
            $this->_dumpTable($gzfile, $storage->table, $storage->table.'_id');
            $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert '.$storage->table.' off\');' . $lf);
        }
        
        foreach($core->dbe->scheme as $schemeTable) {
            $table = $schemeTable->name;
                if(in_array($table, array(
                    "sys_tree", "sys_links", "sys_blobs_cache", "sys_statistics", "sys_index", "sys_index_words", // cache tables
                    "sys_templates", "sys_storages", "sys_storage_fields", "sys_storage_templates", "sys_repository", "sys_modules", "sys_module_templates"// system tables that are allready dumped
                    ))) 
                    continue;
                    
                $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert '.$table.' on\');' . $lf);
                $this->_dumpTable($gzfile, $table);
                $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert '.$table.' off\'); ' . $lf);
                    
        }
            
        foreach($core->mm->activemodules as $m) {
            if(!is_null($m->datascheme)) {
                foreach($m->datascheme as $st) {
                    $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert '.$st->name.' on\');' . $lf);
                    $this->_dumpTable($gzfile, $st->name);
                    $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert '.$st->name.' off\');' . $lf);
                }
            }
        }

        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_links on\');' . $lf);
        $this->_dumpTable($gzfile, 'sys_links');
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_links off\'); ' . $lf);
        
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_tree on\');' . $lf);
        $this->_dumpTable($gzfile, 'sys_tree');
        $gzfile->write('if($core->driver == \'mssql\') $core->dbe->Query(\'set identity_insert sys_tree off\'); ' . $lf);
        
        $gzfile->write('
                unlink(__FILE__);
            }
            exit;
        ');
        
        $gzfile->write("?".">". $lf);
        
        $gzfile->close();
        return $dumpname;
    }
    
    public function RestoreFrom($dumpname) {
        
        global $core, $SITE_PATH;
        
        
        set_time_limit(999999);
        
        if(empty($dumpname) || $dumpname == "")
            return false;

        
        $uncompressed = $core->fs->mappath("/system_restore/".str_replace(".gz", "", $dumpname));
        
        if(strstr($dumpname, '.gz') !== false) {
            $gzfile = new GZFile($core->fs->mappath("/system_restore/".$dumpname), MODE_READ);
            $gzfile->uncompress($uncompressed);
            $gzfile->close();
        }        

        rename($uncompressed, $SITE_PATH.'restore.php');
        
        
        // $core->dbe->StartTrans();
        
        /*try {
            require_once($uncompressed);    
        }
        catch(Exception $e) {
            out($e);
            exit;
        }*/
        
        
        // $core->dbe->CompleteTrans();
        
        // unlink($uncompressed);
        return $SITE_PATH.'restore.php';
        
    }
    

    function Test() {
        global $core; 
        $file = strftime("%Y%m%d%H%M%S", time()).".srp.gz";
        $dumpname = $core->fs->MapPath("/system_restore/".$file);
        system('mysqldump --opt -u '.$core->user.' --password="'.$core->password.'" --hex-blob --default-character-set=utf8 --no-create-db --add-drop-table --database '.$core->database.' | gzip -9 > '.$dumpname);
        return $file;
        
        global $core;
        $script = '
/*
 *   Pioneer System Restore
 *   Pioneer version: 1.5.0
 *   Host: '.$core->server.'
 *   Generation Time: '.date("M j, Y \a\\t H:i").' 
 *   PHP Version: ' . phpversion().'
 *   Database : '.$core->database.'
 */
        ';
        
        $tables = $core->dbe->Tables();
        foreach($tables as $table) {
            if(substr($table, 0, 4) == 'sys_') {
                if(in_array($table, array("sys_blobs_cache", "sys_statistics", "sys_index", "sys_index_words"))) continue;
                
                $script .= "\n\n";
                $script .= '// dumping data for table '.$table."\n";
                $script .= '$core->dbe->TruncateTable($table);'."\n";
                    
                $result = $core->dbe->ExecuteReader("SELECT * FROM ".$table); //  limit 0, 101
                while($row = $result->Read()) {
                    $row = serialize(get_object_vars($row));
                    $script .= '$core->dbe->Insert("'.$table.'", Collection::Deserialize(\''.$row.'\'));'."\n";
                }
                                
            }
        }
        
        $tables = $core->dbe->Tables();
        foreach($tables as $table) {
            if(substr($table, 0, 4) != 'sys_') {
                
                $script .= "\n\n";
                $script .= '// dumping data for table '.$table."\n";
                $script .= '$core->dbe->TruncateTable($table);'."\n";
                    
                $result = $core->dbe->ExecuteReader("SELECT * FROM ".$table); //  limit 0, 101
                while($row = $result->Read()) {
                    $row = serialize(get_object_vars($row));
                    $script .= '$core->dbe->Insert("'.$table.'", Collection::Deserialize(\''.$row.'\'));'."\n";
                }
                                
            }
        }
        
        
        out($script);
        exit;
        
    }
    
	function createRestorePoint($multiFile = false, $partSize = 5 ) {/*mb*/
        global $core;
        
		$partSize = ($partSize * 1024)*1024;
		
		$max_execution_time = ini_get('max_execution_time');		
		ini_set('max_execution_time', '99999');
		
		$lf = "\r\n";
		
		// $dumpname = "Restore point ".date("d.m.Y.His", time()).".srp";
		$dumpname = strftime("%Y%m%d%H%M%S", time()).".srp.gz";
		$gzfile = new GZFile($core->fs->mappath("/system_restore/".($multiFile ? "part1." : "").$dumpname), MODE_CREATEWRITE);
		
		$result = $core->dbe->Tables();
		foreach($result as $tblval) {
			// $ctt = "Tables_in_".$core->database;
			$result1 = $core->dbe->ExecuteReader("SHOW CREATE TABLE ".$tblval."");
			$ct = "Create Table";
			$tbl = $result1->Read();
			$createtable[$tbl->Table] = $tbl->$ct;
		}
		
		// Set header
		$output  = "#". $lf;
		$output .= "# Pioneer System Restore" . $lf;
		$output .= "# Pioneer version: 1.5.0".$lf;
		$output .= "# Host: " . $core->server . $lf;
		$output .= "# Generation Time: " . date("M j, Y \a\\t H:i") . $lf;
		$output .= "# PHP Version: " . phpversion() . $lf;
		$output .= "# Database : " . $core->database . "" . $lf;
		$output .= "#";
		$gzfile->write($output);
		$output = "";
		
        $partS = 0;
        $iFile = 1;
		// Generate dumptext for the tables.
		foreach ($createtable as $tblval => $createtbl) {
			$output .= $lf . $lf . "# --------------------------------------------------------" . $lf . $lf;
			$output .= "#". $lf . "# Table structure for table $tblval" . $lf;
			$output .= "#" . $lf . $lf;
			// Generate DROP TABLE statement when client wants it to.
			if($this->isDroptables()) {
				$output .= "DROP TABLE IF EXISTS $tblval;" . $lf;
			}
			$output .= $createtbl.";" . $lf;

			if($tblval == "sys_blobs_cache" || $tblval == "sys_statistics" || $tblval == "sys_index" || $tblval == "sys_index_words")
				continue;
			
			$output .= $lf;
			$output .= "#". $lf . "# Dumping data for table $tblval". $lf . "#" . $lf;

			
			$result = $core->dbe->ExecuteReader("SELECT * FROM $tblval"); //  limit 0, 101
			$i=0;
			while($row = $result->Read()) {
			
				$insertdump = $lf;
				$insertdump .= "INSERT INTO $tblval VALUES (";
				$arr = new collection();
				$arr->from_object($row);
				foreach($arr as $key => $value) {
					$f = $result->fields[$key];
					if(is_null($value))
						$insertdump .= "null,";
					else {
						if($f->blob || $f->type == "string"){
							if($value == '')
								$value = "''";
							else
								$value = "0x".bin2hex($value);
						}
						else {
							$value = addslashes($value);
							$value = str_replace("\n", '\r\n', $value);
							$value = str_replace("\r", '', $value);
							$value = "'".$value."'";
						}
						$insertdump .= $value.",";
					}
				}
				$output .= rtrim($insertdump,',') . ");";
				$i++;

				$gzfile->write($output);
                //$partS += strlen($output);
				$output = "";
			}
			
			$gzfile->write($output);
			$output = "";
            
            if($multiFile) {
                $partS = 0;
                $iFile++;
                $gzfile->Close();
                $gzfile = new GZFile($core->fs->mappath("/system_restore/".($multiFile ? "part".$iFile."." : "").$dumpname), MODE_CREATEWRITE);
            }
			
		}
		$gzfile->close();			
		return $dumpname;
	}
	
	function listPoints($sort = "file_name", $sortType = SORT_ASC) {
		global $core;
		return $core->fs->list_files("/system_restore/", array("srp", "gz"), null, $sort, $sortType);
	}

	function parse_mysql_dump($content /*array*/, $ignoreerrors = false) {
		global $core;
		
		// $file_content = file($url);
		$file_content = $content;
		$query = "";
		foreach($file_content as $sql_line) {
			$tsl = trim($sql_line);
			if (($tsl != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "#")) {
				$query .= $sql_line;
				if(preg_match("/;\s*$/", $sql_line)) {
					//out($query);
					$result = $core->dbe->query($query);
					if (!$result && !$ignoreerrors) {
						return false;
					}
					$query = "";
				}
			}
		}
		return true;
	}	
	
	function restoreFromRestorePoint($dumpname) {
		global $core;
		
		$memlimit = ini_get('memory_limit');
		ini_set('memory_limit', '300M');		
		
		$max_execution_time = ini_get('max_execution_time');		
		ini_set('max_execution_time', '99999');

		if(empty($dumpname) || $dumpname == "")
			return false;

		$gzfile = new GZFile($core->fs->mappath("/system_restore/".$dumpname), MODE_READ);
		$content = $gzfile->readall();

		$content = preg_split("/\n/", $content);
		$core->dbe->Query("START TRANSACTION");
		$r = $this->parse_mysql_dump($content, false);
		if($r)
			$core->dbe->Query("COMMIT");
		else
			$core->dbe->Query("ROLLBACK");
		
		$gzfile->close();
		
		ini_set('memory_limit', $memlimit);
		ini_set('max_execution_time', $max_execution_time);
		
		return $r;

	}
	
	function clean_points($maxcount) {
		global $core;
		$files = $this->listPoints("file_name", SORT_ASC);
		if($maxcount > -1) {
			if($files->count() > $maxcount) {
				$delcount = $files->count() -  $maxcount;
				for ($i=0; $i<$delcount; $i++) {
					$core->fs->deletefile("/system_restore/".$files->item($i)->file);
				}
			}
		}
	}
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("sysrestore.create", "Create a restore point"));
		$operations->Add(new Operation("sysrestore.restore", "Restore a system from backup"));
		$operations->Add(new Operation("sysrestore.setschedule", "Set the CRONTAB schedule"));
		return $operations;
	}

}

class SystemBackup {
	
	public function __construct() {
		
	}
	
	public function CreateDataBackupScript($storages = null, $dumpData = true) {
		
		if(is_null($storages))
			$storages = Storages::Enum();
		
		$string = '';
		
		$string .= '
		/*
		*	Pioneer Data Backup
		*/
		';
		foreach($storages as $storage) {
			$string .= $storage->ToCreateScript($storage->table, array('name', 'table', 'color'));
			$fields = $storage->fields;
			foreach($fields as $field) {
				$string .= $field->ToCreateScript('field', array('name', 'type', 'default', 'field', 'required', 'showintemplate', 'lookup', 'onetomany', 'values'), array(), array('$'.$storage->table));
			}
			$templates = $storage->templates;
			foreach($templates as $template) {
				$string .= $template->ToCreateScript('template', array('name', 'description', 'list', 'properties', 'styles', 'composite', 'cache', 'cachecheck'), array(), array('null', 'TEMPLATE_STORAGE', '$'.$storage->table));
			}
			if($dumpData) {
				$datarows = new DataRows($storage);
				$datarows->Load();
				while($dtr = $datarows->FetchNext()) {
					$string .= $dtr->ToCreateScript("data", array(), array(), array('$'.$storage->table));
				}
				
			}
		}
				
		return $string;
	}
	
	private function _CreateBlobCategoriesBackupScript($parent = null) {
		$string = '';
		$bs = new BlobCategories($parent);
		foreach($bs as $bc) {
			$string .= $bc->ToCreateScript('c'.$bc->id, array(), array("id"));
			$string .= $this->_CreateBlobCategoriesBackupScript($bc);
		}
		return $string;
	}
	
	public function CreateBlobsBackupScript() {
		$string = $this-> _CreateBlobCategoriesBackupScript();
	
		$bs = new Blobs(BLOBS_ALL);
		foreach($bs as $b) {
			$string .= $b->ToCreateScript('b'.$b->id, array(), array("id"));
			$string .= 'b'.$b->id.'->data->data = "'.db_prepare($b->data->data).'";'."\n";
			$string .= 'b'.$b->id.'->Save();'."\n";
		}
		
		return $string;
	}
	
}

?>