<?php

/**
	* class FileSystem
	*
	* Description for class FileSystem
	*
	* @author:
	*/

class FileSystem  {


	function __contstruct() {
		
	}

	public function Initialize(){
		
	}
    
    public function Dispose() {
        
    }

	private function _relpath($href, $siteroot) {
		if(substr($href, 1, 1) != "/") {
			$cd = strtolower(getcwd());
			$relpath = substr($cd, strlen($siteroot) + 1, strlen($cd) - strlen($siteroot)-1)."/";
			$relpath = str_replace("\\", "/", $relpath);
			$href = substr($href, 1, strlen($href) - 1);
		}		
		else {
			$relpath = "/";
		}
		return $relpath.$href;
		
	}

	function mappath($href, $where = SITE) {
        global $core;
        if(substr($href, 0, strlen('http://')) == "http://")
            return $href;

        if(file_exists($href))
            return $href;
            
        if(substr($href, 1, 1) == ":")
			return $href;
        
        if($where == SITE)
			$sitepath = strtolower($core->sitePath);
        elseif($where == ADMIN)
            $sitepath = strtolower($core->adminPath);
        elseif($where == CORE)
            $sitepath = strtolower($core->corePath);
        else
            $sitepath = "/";
        
        if(substr($href, 0, strlen($sitepath)) == $sitepath)
            return $href;
        
        
        if(substr($href, 0, 1) == "/" || substr($href, 0, 1) == "\\")
            $href = substr($href, 1);
		
        $href = $sitepath.$href;
        $href = str_replace("\\", "/", $href);
        return $href;

	}

	function relpath($path, $relto = '') {
		global $core;
		$sitepath = strtolower($core->sitePath);
		$relpath = "/".substr($path, strlen($sitepath));
		$path = str_replace("\\", "/", $relpath);
        
        if(!is_empty($relto)) {
            $path = '/'.str_replace($relto, '', $path);
        }
        return $path;
	}

	public function formatfilesize($Size) {
		$Range = 1024;
		$Postfixes = array("bytes", "Kb", "Mb", "Gb", "Tb");
		
		for($j = 0; $j < count($Postfixes); $j++) {
			if($Size <= $Range)
				break;
			else
				$Size = $Size / $Range;
		}
		$Size = round($Size, 2);
		$Info = $Size." ".$Postfixes[$j];
		return $Info;
	}

	public function siteroot() {
		global $core;
		return strtolower($core->sitePath);
	}

	public function ReadFile($fpath, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        return @file_get_contents($fpath);
	}

    public function SplitFile($fpath, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        return @file($fpath);
    }

	public function WriteFile($fpath, $data, $where = SITE) {
		$fpath = $this->mappath($fpath, $where);
		if(!$this->fileexists($fpath))
			touch($fpath);
		return file_put_contents($fpath, $data);
	}

	public function AppendFile($fpath, $data, $where = SITE) {
		$fpath = $this->mappath($fpath, $where);
		return file_put_contents($fpath, $data, FILE_APPEND);
	}

	public function DeleteFile($fpath, $where = SITE) {
		$fpath = $this->mappath($fpath, $where);
		@unlink($fpath);
	}

	public function MoveFile($fpath1, $fpath2, $where = SITE) {
		$fpath1 = $this->mappath($fpath1, $where);
		$fpath2 = $this->mappath($fpath2, $where);
		rename($fpath1, $fpath2);
	}

    public function BackupFile($fpath, $bkpostfix, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        if($this->FileExists($fpath.'.'.$bkpostfix)) $this->DeleteFile($fpath.'.'.$bkpostfix);
        $this->MoveFile($fpath, $fpath.'.'.$bkpostfix);
    }

    public function CopyFile($fpath1, $fpath2, $where = SITE) {
        $fpath1 = $this->mappath($fpath1, $where);
        $fpath2 = $this->mappath($fpath2, $where);
        copy($fpath1, $fpath2);
    }

	public function FileExists($fpath, $where = SITE) {
		if (is_empty($fpath))
			return false;
		$fpath = $this->mappath($fpath, $where);
		return file_exists($fpath);
	}

	public function DeleteDir($dpath, $where = SITE){
		
		// check 
		if(strstr($dpath, "resources") === false)
			return;
		
		$dirs = $this->list_dir($dpath);
		$files = $this->list_files($dpath);
		if($files->Count() > 0 || $dirs->Count()) {
			foreach($dirs as $d) {
				$this->deletedir($dpath.'/'.$d, $where);
			}
			if($files->Count() > 0) {
				foreach($files as $f){ 
					$this->deletefile($dpath.'/'.$f->file, $where);
				}
			}
		}		
		
		$dpath = $this->mappath($dpath, $where);
		rmdir($dpath);
		
	}

	public function CreateDir($dpath, $where = SITE){
		$dpath = $this->mappath($dpath, $where);
		return mkdir($dpath, 0777, true);
	}
	
	public function DirExists($dpath, $where = SITE) {
		$dpath = $this->mappath($dpath, $where);
		return is_dir($dpath);
	}

	public function FileLastModified($fpath, $where = SITE){
		$fpath = $this->mappath($fpath, $where);
		return @filemtime($fpath);
	}
    
    public function FileSize($fpath, $where = SITE) {
        $fpath = $this->mappath($fpath, $where);
        return @filesize($fpath);
    }

	public function file_lastmodified($fpath, $where = SITE){ return $this->FileLastModified($fpath, $where); }

	function is_f($f, $exts = null) {
		if(!is_null($exts))
			return in_array(strtolower($f->file_ext), $exts);
		else	
			return true;
	}

	function is_pattern($f, $pattern) {
		if(is_null($pattern))
			return true;
		else {
			return preg_match($pattern, $f->file) > 0;
		}
	}

	public function ListFiles($p, $exts = null /*array*/, $pattern = null, $sortField = "file_name", $sortType = SORT_ASC, $where = SITE, $max = 100) {
		if(!$this->DirExists($p, $where))
            return new ArrayList();
            
        $ret = array();
		$p = $this->mappath($p, $where);

		if ($handle = opendir($p)) {
            $i = 0;
			while (false !== ($file = readdir($handle)) && $i < $max) {
				if ($file != "." && $file != ".." && @filetype($p . '/' . $file) != "dir") {
					$f = $this->file($file);
					if($this->is_f($f, $exts) && $this->is_pattern($f, $pattern))
						$ret[] = $f;
                    $i++;
				}
			}
			closedir($handle);
		}	
		$c = new ArrayList($ret);
		$c->sort($sortField, $sortType);
		return $c;
	}
	
	public function ListDir($p, $sortType = SORT_ASC, $where = SITE) {
        if(!$this->DirExists($p, $where))
            return new ArrayList();

		$ret = array();
		
		$p = $this->mappath($p, $where);
		if ($handle = opendir($p)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && filetype($p . '/'. $file) == "dir") {
					$ret[] = $file;
				}
			}
			closedir($handle);
		}	
		return new ArrayList($ret);
	}

	public function list_files($p, $exts = null /*array*/, $pattern = null, $sortField = "file_name", $sortType = SORT_ASC, $where = SITE) { return $this->ListFiles($p, $exts, $pattern, $sortField, $sortType, $where); }
	public function list_dir($p, $sortType = SORT_ASC, $where = SITE) { return $this->ListDir($p, $sortType, $where); }

	public function file($f) {
		$s = explode(".", $f);
		$tmp = new stdClass();
		$tmp->file = $f;
		if(count($s) == 1) {
			$tmp->file_name = $s[0];
			$tmp->file_ext = "";
		}
		else {
			$tmp->file_ext = $s[count($s) - 1];
			array_splice($s, -1);
			$tmp->file_name = implode(".", $s);
		}
		return $tmp;
	}
	
}

class FinderResults extends ArrayList {
    
    public function __construct() { parent::__construct(); }
    public function Add(FinderResult $o) { parent::Add($o); }
    
    public function ReplaceWith($index, FinderResults $o) {
        $this->Delete($index);
        foreach($o as $item) {
            $this->Insert($item, $index);
        }
    }
    
}

class FinderResult {
    
    const DIRECTORY = true;
    const FILE = false;
    
    private $_type;
    private $_path;
    private $_directory;
    private $_file;
    private $_fileName;
    private $_fileType;
    private $_fileLength;
    private $_tag;
        
    public function __construct($path) {
        $this->_path = $path;
        $this->_type = is_dir($path);
        $this->_directory = dirname($path).'/';
        if(!$this->_type) {
            $this->_file = basename($path);
            $s = explode(".", $this->_file);
            if(count($s) == 1) {
                $this->_fileName = $s[0];
                $this->_fileType = '';
            }
            else {
                $this->_fileType = $s[count($s) - 1];
                array_splice($s, -1);
                $this->_fileName = implode(".", $s);
            }
            $this->_fileLength = filesize($path);
        }
    }
    
    public function __get($property) {
        switch($property) {            
            case 'type':
                return $this->_type;
            case 'path':
                return $this->_path;
            case 'directory':
                return $this->_directory;
            case 'file':
                return $this->_file;
            case 'name':
                return $this->_fileName;
            case 'extension':
                return $this->_fileType;
            case 'length':
                return $this->_fileLength;
            case 'tag':
                return $this->_tag;
            default: 
                break;
        }
        return false;
    }
    
    public function __set($property, $value) {
        switch($property) {
            case 'tag':
                $this->_tag = $value;
                break;
            default: 
                break;
        }
    }
    
}

class Finder {
    
    private $_root;
    
    public function __construct($root) {
        $this->_root = $root;
        if(!is_dir($this->_root)) {
            trigger_error('Folder does not exists');
            return;
        }
    }
    
    private function _checkPattern(FinderResult $f, $pattern) {
        if(is_null($pattern))
            return true;
        else {
            return preg_match($pattern, $f->name) > 0;
        }
    }
    
    private function _checkType(FinderResult $f, $types) {
        if(!is_null($types))
            return in_array(strtolower($f->extension), $types);
        else    
            return true;
    }

    private function _listAll($path) {
        $ret = new FinderResults();    
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
                    $ret->Add(new FinderResult(remove_end_slash($path).'/'.$file));
            }
            closedir($handle);
        }    
        return $ret;
    }
    
    public function Find($extensions = array(), $pattern = null) {
        $results = $this->_listAll($this->_root);
        $index = 0;
        while($index < $results->Count()) {
            $f = $results->Item($index);
            if($f->type == FinderResult::DIRECTORY) {
                $results->ReplaceWith($index, $this->_listAll($f->path));    
                continue;
            }
            else {
                if(!($this->_checkType($f, $extensions) && $this->_checkPattern($f, $pattern))) {
                    $results->Delete($index);
                    continue;
                }   
            }
            $index ++;
        }
        return $results;
    }
    
}

class GZFile {
	
	private $pointer;
	
	public function __construct($filename, $mode = MODE_READ) {
		$this->pointer = gzopen($filename, $mode);
	}
	
	public function read($length = 255) {
		return gzgets($this->pointer, $length);
	}
	
	public function readall() {
		$sret = "";
		while($s = $this->read()) {
			$sret .= $s;
		}
		return $sret;
	}

	public function write($string, $length = null) {
		if($length)
			return gzputs($this->pointer, $string, $length);
		else
			return gzputs($this->pointer, $string);
	}
	
	public function close() {
		gzclose($this->pointer);
	}
    
    public function uncompress($tofile) {
        
        @unlink($tofile);
        touch($tofile);
        $handle = fopen($tofile, MODE_WRITE);
        while($s = $this->read()) {
            fwrite($handle, $s);
        }
        fclose($handle);
    }

}

class FileStream {
    
    private $_name;
    
    public function __construct($name) {
        $this->_name = $name;
    }
    
    public function __destruct() {
        
    }

    public function Write($string) {
        return file_put_contents($this->_name, $string, FILE_APPEND);
    }
    
    public function WriteLine($line) {
        return $this->Write($line."\n");
    }
    
    public function ReadAll() {
        return file_get_contents($this->_name);
    }

}

class Zip
{
    public function InfosZip ($src, $data=true)
    {
        if (($zip = zip_open(realpath($src))))
        {
            while (($zip_entry = zip_read($zip)))
            {
                $path = zip_entry_name($zip_entry);
                if (zip_entry_open($zip, $zip_entry, "r"))
                {
                    $content[$path] = array (
                        'Ratio' => zip_entry_filesize($zip_entry) ? round(100-zip_entry_compressedsize($zip_entry) / zip_entry_filesize($zip_entry)*100, 1) : false,
                        'Size' => zip_entry_compressedsize($zip_entry),
                        'NormalSize' => zip_entry_filesize($zip_entry));
                    if ($data)
                        $content[$path]['Data'] = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    zip_entry_close($zip_entry);
                }
                else
                    $content[$path] = false;
            }
            zip_close($zip);
            return $content;
        }
        return false;
    }
    public function extractZip ($src, $dest)
    {
        $zip = new ZipArchive;
        if ($zip->open($src)===true)
        {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }
        return false;
    }
    public function makeZip ($src, $dest)
    {
        $zip = new ZipArchive;
        $src = is_array($src) ? $src : array($src);
        if ($zip->open($dest, ZipArchive::CREATE) === true)
        {
            foreach ($src as $item) {
                if (file_exists($item))
                    $this->addZipItem($zip, realpath(dirname($item)).'/', realpath($item));
            }
            $zip->close();
            return true;
        }
        return false;
    }
    private function addZipItem ($zip, $racine, $dir)
    {
        if (is_dir($dir))
        {
            $zip->addEmptyDir(str_replace($racine, '', $dir));
            $lst = scandir($dir);
                array_shift($lst);
                array_shift($lst);
            foreach ($lst as $item)
                $this->addZipItem($zip, $racine, $dir.$item.(is_dir($dir.$item)?'/':''));
        }
        elseif (is_file($dir))
            $zip->addFile($dir, str_replace($racine, '', $dir));
    }
}

?>
