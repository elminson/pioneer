<?php


class Blobs extends ArrayList {

	public function __construct($parent = null, $sort = null, $page = -1, $pagesize = 10) {
		parent::__construct();

		$this->_parent = $parent;
		$this->Load($sort, $page, $pagesize);
		
	}
	
	public function Load($sort = null, $page = -1, $pagesize = 10) {
		global $core;

		$where = "";
		
		$parent = $this->_parent;
		if($parent instanceof BlobCategory)
			$parent = $parent->id;
		
		if($parent != BLOBS_ALL) {
			$where = "where blobs_parent=".( is_null($parent) ? -1 : $parent);
		}

		$r = $core->dbe->ExecuteReader("select * from sys_blobs ".$where, $page, $pagesize);	
		$this->affected = $r->affected;
		while($row = $r->Read()) {
			parent::Add(new Blob($row));
		}
	}
	
	public function Add($blob) {
		$blob->Save();
		parent::Add($blob);
	}
	
	public function Delete($blob) {
		$index = parent::IndexOf($blob);
		if($index)
			parent::Delete($index);
		$blob->Delete();
	}	
	
}

class BlobList extends ArrayList {
	
	private $_position;
	
	public function __construct($source = "") {
		parent::__construct();

		$a = new ArrayList();
		$a->FromString($source, ",");
		foreach($a as $id) {
			if(is_numeric($id))
				$this->Add(new Blob((int)$id));
		}
		
		$this->_position = -1;
	}
	
	public function Add(Blob $file) {
		parent::Add($file);
	}
	
	public function AddRange($values) {
		foreach($values as $v) {
			if(!($v instanceof Blob))
				return false;
		}
		
		parent::AddRange($values);
		
	}
	
	public function ToString() {
		$r = "";
		foreach($this as $b) {
			$r .= ",".$b->id;
		}
		return @substr($r, 1);
	}

	public function Rows() {
		return $this;
	}
	
	public function FetchNext() {
		if($this->_position == $this->Count())
			return false;
			
		return $this->Item(++$this->_position);
	}
	
}

class BlobData extends Object {

	private $_blob;

	public function __construct($obj = null, $blob = null) {
		global $core;
		$this->_blob = $blob;
		if(!is_object($obj) && !is_null($obj)) {
			$r = $core->dbe->ExecuteReader("select * from sys_blobs_data where blobs_id=".$obj);
			if(!$r->HasRows())
				$obj = null;
			else
				$obj = $r->Read();
		}	
		parent::__construct($obj, "blobs_");
	}
	
	public function __get($nm) {
		switch($nm) {
			case "isValid":
				return $this->data != null;
			case "size":
				return strlen($this->data);
			case "cached":
				return $this->_blob->CacheExists();
			default:
				return parent::__get($nm);
		}
	}
	
	public function Save() {

		global $core;
		$this->id = $this->_blob->id;
        $bdata = $this->data;
        
		$data = $this->ToCollection();
        $data->blobs_data = null;
        $data->Delete('blobs_id');
        
        if(!$core->dbe->exists("sys_blobs_data", "blobs_id", $this->id))
			$core->dbe->Insert("sys_blobs_data", $data);
        
        $core->dbe->SetBin("sys_blobs_data", "blobs_id", $this->id, "blobs_data", $bdata);
        
        unset($bdata);
        unset($data);
    }
	
	public function Delete() {
		global $core;
		$core->dbe->query("delete from sys_blobs_data where blobs_id=".$this->id);
	}
	
	public static function Download($url) {
        $handle = @fopen($url, "r");
        if($handle) {
			$contents = '';
			while (!feof($handle)) {
				$contents .= fread($handle, 8192);
			}
			fclose($handle);
			return $contents;
		}
		return null;
	}
 
	
}

class Blob extends Object {

	static $cache;

	private $_blobdata;
    private $_watermark;
    private $_usewatermark = false;
    private $_filter = null;
	
	public function __construct($obj = null) {
		global $core, $SYSTEM_USE_MEMORY_CACHE;
		
        if($SYSTEM_USE_MEMORY_CACHE) {
		    if(!Blob::$cache) {
			    Blob::$cache = $core->dbe->ExecuteReader("select * from sys_blobs")->ReadAll();
		    }
        }		
		
        if(!is_null(Blob::$cache) && Blob::$cache->Exists("".(is_object($obj) ? $obj->blobs_id : $obj))) {
			$obj = Blob::$cache->Item("".(is_object($obj) ? $obj->blobs_id : $obj));
		}
		else {
			if(!is_object($obj) && !is_null($obj)) {
				if(gettype($obj) == "integer")
					$r = $core->dbe->ExecuteReader("select * from sys_blobs where blobs_id=".$obj);
				elseif(gettype($obj) == "string")
					$r = $core->dbe->ExecuteReader("select * from sys_blobs where blobs_filename='".$obj."'");
				
				$obj = @$r->Read();
			}	
		}
		parent::__construct($obj, "blobs_");
	}
	
	public static function Search($filter) {
		global $core;
		if(gettype($obj) == "integer")
			$r = $core->dbe->ExecuteReader("select * from sys_blobs where blobs_id=".$filter);
		elseif(gettype($obj) == "string")
			$r = $core->dbe->ExecuteReader("select * from sys_blobs where ".$filter);
		if(@$r->HasRows())
			return $r;
		else
			return false;
	}
	
	public function __get($nm) {
		switch($nm) {
			case "isValid":
				return is_numeric($this->id);
			case "parent":
				return new BlobCategory(parent::__get($nm));
			case "data":
				if(!$this->_blobdata)
					$this->_blobdata = new BlobData(intval($this->id), $this);
				return $this->_blobdata;
			case "mimetype":
				return new MimeType($this->type);
			case "size":
				return new Size($this->width, $this->height);
			case "self":
				return $this;
			case "type":
				return strtolower(parent::__get("type"));
            case "watermark":
                return $this->_watermark;
            case "usewatermark":
                return $this->_usewatermark;
            case "filter":
                return $this->_filter;
			default:
				return parent::__get($nm);
		}
	}

	public function __set($nm, $value) {
		if($nm == "parent") {
			if($value instanceof BlobCategory) {
				$value = $value->id;
                return ;
            }
		}
        if($nm == "watermark") {
            $this->_watermark = $value;
            return ;
        }
        if($nm == "usewatermark") {
            $this->_usewatermark = $value;
            return ;
        }
        if($nm == "filter") {
            $this->_filter = $value;
            return ;
        }
            
		parent::__set($nm, $value);
	}
	
	public function Delete() {
		global $core;
		$this->data->Delete();
		$this->ClearCache();
		return $core->dbe->query("delete from sys_blobs where blobs_id=".$this->id);
	}
	
	public function Save($savedata = true, $savesizes = true) {

		global $core;
		$data = $this->ToCollection();
		$data->Delete("blobs_id");
		
        if($savesizes) {
		    if($this->data->isValid) {
			    if($this->mimetype->isImage) {
				    $img = new ImageEditor(0, 0, $this->data->data);
				    $data->blobs_width = $img->x;
				    $data->blobs_height = $img->y;
                    $img->Dispose();
			    }
		    }
        }
        
		$data->blobs_modified = strftime("%Y-%m-%d %H:%M:%S", time());
		
        $data->blobs_bsize = strlen($this->data->data);

		if(is_null($this->id) || $this->id == -1)
			$this->id = $core->dbe->insert("sys_blobs", $data);
		else 
			$core->dbe->set("sys_blobs", "blobs_id", $this->id, $data);

		if($savedata)
			$this->data->Save();
		
		$this->ClearCache();
		$this->Cache();
	}
	
	public function CacheName($size = null) {
		global $core;
		$cachefolder = $core->sts->BLOB_CACHE_FOLDER;
		if(!$size) $size = new Size();
        if(is_null($size)) $s = "0x0";
        else $s = $size->width."x".$size->height;
        $wtr = ($this->_usewatermark && !is_empty($this->watermark) ? $this->watermark->id."." : "");
        $g = !is_null($this->_filter) ? str_replace(")", "-", str_replace("(", "-", str_replace(",", "-", str_replace(";", "-", $this->_filter)))).'.' : '';
		$cachename = $this->id.".".$s.".".$wtr.$g.$this->type;
		return $cachefolder."/".$cachename;
	}
    
    private function CalcWatermarkPosition($ws, $is) {
        
        if(!is_empty($this->watermark)) {
            $o = new stdClass();
            
            global $_WATERMARKPOSITION, $_WATERMARKPADDING;
            $_WATERMARKPOSITION = is_empty($_WATERMARKPOSITION) ? "center" : $_WATERMARKPOSITION;
            $_WATERMARKPADDING = is_empty($_WATERMARKPADDING) ? 0 : $_WATERMARKPADDING;
            $x = 0;
            $y = 0;
            switch($_WATERMARKPOSITION) {
                case "lefttop":          
                    $x = $_WATERMARKPADDING;
                    $y = $_WATERMARKPADDING;
                    break;
                case "righttop":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = 0;
                    break;
                case "rightbottom":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "leftbottom":
                    $x = 0;
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "center":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
                case "centertop":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = 0;
                    break;
                case "centerbottom":
                    $x = (int)(($is->width - $ws->width) / 2);
                    $y = $is->height - $ws->height - $_WATERMARKPADDING;
                    break;
                case "leftcenter":
                    $x = 0;
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
                case "rightcenter":
                    $x = $is->width - $ws->width - $_WATERMARKPADDING;
                    $y = (int)(($is->height - $ws->height) / 2);
                    break;
            }
            $o->x = $x;         
            $o->y = $y;
            return $o;
            
        }
        
        return new stdClass();
    }

	public function Cache($size = null) {
		global $core;
		$ff = $this->CacheName($size);
		
		$data = $this->data->data;
		
		if(!is_null($size))	{
			$s = $this->size->TransformTo($size);
			
			$img = new ImageEditor(0, 0, $data);
			if(!$img->error) {
                if(!$s->isNull){
					$img->resize( $s->width, $s->height );
                    $data = $img->outputMem($this->type);
				}
			}
			else {
				$img = new ImageEditor(10, 10);
				$img->errorImage("Type is not supplied.");
				$data = $img->outputMem("jpg");
			}		
            $img->Dispose();
		}

        /*$_WATERMARK = 895;
        $_WATERMARKPOSITION = "centerbottom";
        $_WATERMARKPADDING = 10;
        $_WATERMARKVISIBILITY = 20;*/
        
        if(!is_empty($this->watermark) && $this->_usewatermark) {
            
            //if(is_empty($img))
                $img = new ImageEditor(0, 0, $data);
            
            $watermark = new ImageEditor(0, 0, $this->watermark->data->data);
            global $_WATERMARKVISIBILITY;
            $p = $this->CalcWatermarkPosition(new Size($watermark->x, $watermark->y), new Size($img->x, $img->y));
            $img->addWatermark($watermark,$p->x,$p->y,0,0, $_WATERMARKVISIBILITY);
            
            $data = $img->outputMem($this->type);
        }
        
        $data = $this->applyFilters($data);
		
		$core->fs->writefile($ff, $data);
	}
    
    private function applyFilters($data) {
        if (!is_null($this->_filter)){
            $af = array(
                'negative' => IMG_FILTER_NEGATE,
                'grayscale' => IMG_FILTER_GRAYSCALE,
                'brightness' => IMG_FILTER_BRIGHTNESS,
                'contrast' => IMG_FILTER_CONTRAST,
                'colorize' => IMG_FILTER_COLORIZE,
                'edgedetect' => IMG_FILTER_EDGEDETECT,
                'emboss' => IMG_FILTER_EMBOSS,
                'gaussian_blur' => IMG_FILTER_GAUSSIAN_BLUR,
                'selective_blur' => IMG_FILTER_SELECTIVE_BLUR,
                'mean_removal' => IMG_FILTER_MEAN_REMOVAL,
                'smooth' => IMG_FILTER_SMOOTH
            );            
            
            $filters = explode(";", $this->_filter);
            $img = new ImageEditor(0, 0, $data);
            foreach($filters as $filter) {
                preg_match_all('/([^\(]*)\(?([^\)]*)?\)?/im', $filter, $matches, PREG_SET_ORDER);
                $f = $af[$matches[0][1]];
                $argb = explode(",", $matches[0][2]);
                $img->addfilter($f, @$argb[0], @$argb[1], @$argb[2]);
            }
            return $img->outputMem($this->type);
        }
        return $data;   
    }
    
    public function Merge($obj, Point $position) {
    	global $core;
    	if(!($obj instanceof Blob))
    		$obj = new ImageEditor($core->fs->MapPath($obj), '');
    	else 
    		$obj = new ImageEditor($core->fs->MapPath($obj->Src()), '');

    	$i = new ImageEditor(0, 0, $this->data->data);
    	$i->addImage($obj, $position->x, $position->y);
    	
    	$this->data->data = $i->outputMem($this->type);
    	$this->Cache();
	}
	
	public function ReadCache($size = null, $recache = false) {
		global $core;
        
		$ff = $this->CacheName($size);
		if($this->CacheExists($size) && !$recache)
			return $core->fs->readfile($ff);
		else {
			$this->Cache($size);
			return $this->ReadCache($size);
		}
	}
	
	public function CacheExists($size = null) {
		global $core;
		$ff = $this->CacheName($size);
		return $core->fs->fileexists($ff) === true;
	}
	
	public function ClearCache($size = null) {
		global $core;
		if(is_null($size)) {
			if(is_numeric($this->id)) {
				$files = $core->fs->list_files($core->sts->BLOB_CACHE_FOLDER, null, "/".$this->id."\.\d*x\d*\.".($this->watermark ? "\d\." : "").".*/");
				foreach($files as $file)
					$core->fs->deletefile($core->sts->BLOB_CACHE_FOLDER."/".$file->file);
			}
		}
		else {
			$core->fs->deletefile($this->CacheName($size));
		}
	}
    
    public function UpdateAccessTime() {
        global $core;
        
        $check = $core->rq->currentUrl;
        $currentUrl = $core->rq->currentUrl;
        if(strstr($currentUrl, "/core/utils/blob.php") !== false)
            $check = $core->rq->referer;

        if(strstr($check, "/admin/") === false) {
            $this->lastaccessed = db_datetime(time());
            
            $core->dbe->set("sys_blobs", "blobs_id", $this->id, Collection::Create("blobs_lastaccessed", $this->lastaccessed));
            
            // $this->Save(false, false);
        }
    }
	
	public function Src($size = null, $nocache = false, $download = false, $filter = null) {
        
        $this->UpdateAccessTime();

        $g = $this->filter;
        $this->filter = $filter;
		if(!$nocache) {
			if($this->CacheExists($size))
				$ret = $this->CacheName($size);
			else {
				$this->Cache($size);
				$ret = $this->CacheName($size);
			}
		}
		else {
			global $core;
			if(!is_empty($core->sts->USE_MOD_REWRITE) && !$core->isAdmin) {
				$ext = $this->type;
				if(is_empty($this->type))
					$ext = "jpg";	
				if($size)
					$ret = "/resources/blobs/".$this->id.".".$ext."?recache=true&".$size->params.($download ? "&mode=download" : "").($this->filter ? "&filter=".$this->filter : "");
				else
					$ret = "/resources/blobs/?recache=true&".$this->id.".".$ext.($download ? "?mode=download" : "");
			}
			else {
				if($size)
					$ret = "/core/utils/blob.php?blobid=".$this->id.$size->params.($download ? "&mode=download" : "");
				else
					$ret = "/core/utils/blob.php?blobid=".$this->id.($download ? "&mode=download" : "");
			}
			
		}
        $this->filter = $g;
        return $ret;
	}
	
	//compability
	public function Bg($size = null, $nocache = false, $download = false, $filter = null) {
		return "background: url(".$this->Src($size, $nocache, $download, $filter).");";
	}
    
    public function ColorAt(Point $p) {
        if($this->mimetype->isImage) {
            $data = $this->data;
            $img = new ImageEditor(0, 0, $data);
            return $img->getColorAt($p->x, $p->y);
        }
        return null;                   
    }

	public function Img($size = null, $attributes = null) {
		
		$attr = "";
		if(!is_null($attributes)) {
			if(is_array($attributes)) {
				foreach($attributes as $name => $value) {
					$attr = " ".$name."=\"".$value."\"";
				}
			}
			else if(is_string($attributes)) 
				$attr = $attributes;
		}

		if (!$size)
			$size = new Size();
		
		if ($this->mimetype->isImage){
			$s = $this->size;
			$s = $s->TransformTo($size);
		} else {
			$s = $size;
		}
		
		if($this->data->isValid) {
			if($this->mimetype->isImage)
				return "<img src='".$this->Src($size)."' alt=\"".$this->alt."\" ".$s->attributes." ".$attr." border='0' />"; //htmlentities(
			else if($this->mimetype->isFlash)
				return '<object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" '.
						$s->attributes.' 
						classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
						<param name="Movie" value="'.$this->Src().'" />
						<param name="Src" value="'.$this->Src().'" />
						<param name="WMode" value="Opaque" /> 
						<param name="Play" value="1" />
						<param name="Loop" value="-1" />
						<param name="Quality" value="High" />
						<param name="Scale" value="ShowAll" />
						<param name="EmbedMovie" value="0" />
						<param name="AllowNetworking" value="all" />
						<embed src="'.$this->Src().'" 
						quality="best" 
						bgcolor="#000" 
						'.$s->attributes.' 
						allowscriptaccess="sameDomain" 
						type="application/x-shockwave-flash" 
						wmode="opaque" 
						pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';
			else {
				return "<img src='".to_lower($this->mimetype->icon)."' alt=\"".(!is_null($this->alt) ? $this->alt: '')."\" ".$attr." border='0' />"; //htmlentities(
			}
		}		
		else {
			return "Not selected";
		}
	}
	
	public function to_xml(){
		global $core;
		
		static $ids = array();
		
		$data = $this->ToCollection();
		if (array_search($this->id, $ids) !== false){
			$data->blobs_data = "";
			return $data->to_xml();
		} else {
			$ids[] = $data->blobs_id;
			$data->blobs_data = "[cdata]".bin2hex($this->data->data)."[/cdata]";
			$xml = $data->to_xml();
			$xml = str_replace("[cdata]", "<![CDATA[", $xml);
			return str_replace("[/cdata]", "]]>", $xml);
		}
	}
	
	public function from_xml($el){
		global $core;
		
		$c = new collection();
		$c->from_xml($el);

		$tbs = Blobs::Search("blobs_bsize='".$c->blobs_bsize."'", 
							"and blobs_filename='".$c->blobs_filename."'", 
							"and blobs_type='".$c->blobs_type."'", 
							"and blobs_alt='".$c->blobs_alt."'");

		if ($tbs->Count() > 0){
			$tb = $tbs->FetchNext();
			$this->id = $tb->blobs_id;
		} else {
			$this->bsize = $c->blobs_bsize;
			$this->filename = $c->blobs_filename;
			$this->type = $c->blobs_type;
			$this->alt = $c->blobs_alt;
			$this->data->data = hex2bin($c->blobs_data);
			$this->Save();
		}
	}
	
	public function Out($template = null /* not used */, $params = null /* just for admin_checkboxes */) {
		$s = new storage(null);
		$s->name = "blobs";
		$s->id = -1;
		
		$f = new Field($s);
		$f->name = "File name";
		$f->field = "filename";
		$f->type = "memo";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
		
		$f = new Field($s);
		$f->name = "File type";
		$f->field = "type";
		$f->type = "text";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
		
		$f = new Field($s);
		$f->name = "File size";
		$f->field = "bsize";
		$f->type = "numeric";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
		
        $f = new Field($s);
        $f->name = "Alt";
        $f->field = "alt";
        $f->type = "html";
        $f->showintemplate = true;
        $f->lookup = "";
        $f->onetomany = "";
        $f->values = "";
        $s->fields->Add($f);
        
        $f = new Field($s);
		$f->name = "File";
		$f->field = "self";
		$f->type = "blob";
		$f->showintemplate = true;
		$f->lookup = "";
		$f->onetomany = "";
		$f->values = "";
		$s->fields->Add($f);
		
		$t = template::create(null, $s);
		$t->cache = false;
		$t->composite = 0;
		$t->name = "icon";
		$t->list = '';
        
		return $t->Out(OPERATION_ADMIN, $this, $params);
	}
		
}







?>
