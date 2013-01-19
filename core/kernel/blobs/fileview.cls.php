<?php

class FileList extends ArrayList {
	
	public function __construct($source = "") {
		parent::__construct();

		$source = str_replace("\n", "", str_replace("\r", "", $source));
		$a = new ArrayList();
		$a->FromString($source, ";");
		foreach($a as $file) {
            if(!is_empty($file))                         
			    $this->Add(new FileView(trim($file, "\n")));
		}
		
	}
	
	public function Add(FileView $file) {
		parent::Add($file);
	}
	
	public function AddRange($values) {
		foreach($values as $v) {
			if(!($v instanceof FileView))
				return false;
		}
		
		parent::AddRange($values);
		
	}
	
	public function ToString() {
		$s = "";
		foreach($this as $file) {
			$s .= $file->Src().":".$file->alt.";\r\n";
		}
		return $s;
	}
	
}

class FileView {
	
	private $_src;
	private $_alt;
	private $_file;
    private $_where = SITE;
    private $_usewatermark = false;
    private $_watermark;
    
    private $_content;
    
    private $_fileerror;
	
	function __construct($src) {
		
        if(strstr($src, "http://")) {
            // this is a url
            $src = substr($src, strlen("http://"));
            if(strstr($src, ":"))
                $src = explode(":", $src);
            if(is_array($src))
                $src[0] = "http://".$src[0];
            else
                $src = "http://".$src;
        }
        else 
            // check for alt
		    if(strstr($src, ":"))
                $src = explode(":", $src);
        
		if(is_array($src)) {
			$this->_src = $src[0];
			$this->_alt = $src[1];
			$this->_file = split_fname($src[0]);
		}
		else { 
			$this->_src = $src;
			$this->_file = split_fname($src);
		}
        
        if(strstr($this->_src, '/core')) {
            $this->_src = substr($this->_src, 5);
            $this->_where = CORE;
        } else if(strstr($this->_src, '/admin')) {
            $this->_src = substr($this->_src, 6);
            $this->_where = ADMIN;
        }
        
	}
	
	
	public function __set($nm, $value) {
        if($nm == "watermark") {
            $this->_watermark = $value;
            return ;
        }
        if($nm == "usewatermark") {
            $this->_usewatermark = $value;
            return ;
        }
	}
	

	public function __get($nm) {
		global $core;
		switch($nm) {
            case "isOnline":
                return substr($this->_src, 0, strlen('http://')) == 'http://';
			case "isValid":
				return $core->fs->FileExists($this->_src);
            case 'isFileValid':
                return $this->_fileerror;
			case "mimetype":
				return new MimeType($this->_file[2]);
			case "type":
				return $this->_file[2];
			case "data":
				if(is_null($this->_content))
					$this->_content = $core->fs->readfile($this->_src, $this->_where);
				return $this->_content;
			case "size":
                if($this->mimetype->isImage) {
                    $info = ImageEditor::ImageInfo($core->fs->MapPath($this->_src));
				    return $info->size;
                }
                else {
                    return null;
                }
			case "alt":
				return $this->_alt;
            case "watermark":
                return $this->_watermark;
            case "usewatermark":
                return $this->_usewatermark;
			case "id":
			case "name":
				return $this->_file[1].".".$this->_file[2];
			case "filesize":
                if($this->isOnline)
                    return 0;
				return @filesize($core->fs->mappath($this->_src));
		}
	}

    
    public function ToString(){
        return $this->Src().":".$this->alt;
    }
    
	public function CacheName($size = null, $crop = null) {
		global $core;
		$cachefolder = $core->sts->BLOB_CACHE_FOLDER;
		if(!$size)
			$size = new Size();
            
        if(is_null($size))
            $size = new Size(0,0);
            
		$cachename = md5($this->_src).".".$size->width."x".$size->height.".".($this->_file[2] == 'jpeg' ? 'jpg' : $this->_file[2]);
        
		return $cachefolder."/".$cachename;
	}

	public function Cache($size = null) {
		global $core;
		$ff = $this->CacheName($size);
		$data = $this->data;
		if($this->isValid && $this->mimetype->isImage) {
			if(!is_null($size))	{               
				
                $s = $this->size->TransformTo($size);                                                       
				$img = new ImageEditor(0, 0, $data);
                $this->_fileerror = $img->error;
				if(!$img->error) {
                    $img->resize( $s->width, $s->height );    
					$data = $img->outputMem($this->_file[2] == 'jpeg' ? 'jpg' : $this->_file[2]);
				}

            }

		    if(!is_empty($this->watermark) && $this->_usewatermark) {
		        //if(is_empty($img))
		        $img = new ImageEditor(0, 0, $data);
		        if ($this->watermark instanceOf FileView)
			        $watermark = new ImageEditor(0, 0, $this->watermark->data);
			    else if ($this->watermark instanceOf Blob)
			        $watermark = new ImageEditor(0, 0, $this->watermark->data->data);
			        
		        global $_WATERMARKVISIBILITY;
		        $p = $this->CalcWatermarkPosition(new Size($watermark->x, $watermark->y), new Size($img->x, $img->y));
		        $img->addWatermark($watermark,$p->x,$p->y,0,0, $_WATERMARKVISIBILITY);
		        
		        $data = $img->outputMem($this->type);
		    }
			
			
			$core->fs->writefile($ff, $data);
		}
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
	
	
	public function CacheExists($size = null) {
		global $core;
		if($this->mimetype->isImage) {
			$ff = $this->CacheName($size);
			return $core->fs->fileexists($ff) === true;
		}
		else
			return true;
	}
	
	public function ClearCache($size = null) {
		global $core;
		if(is_null($size)) {
			if(is_numeric($this->id)) {
				$files = $core->fs->list_files($core->sts->BLOB_CACHE_FOLDER, null, "/".md5($this->_src)."\..*/");
				foreach($files as $file)
					$core->fs->deletefile($core->sts->BLOB_CACHE_FOLDER."/".$file->file);
			}
		}
		else {
			$core->fs->deletefile($this->CacheName($size));
		}
	}

	public function Src($size = null, $nocache = false, $download = false) {
		if(!$nocache) {
			if($this->mimetype->isImage && !is_null($size)) {
				if(!$this->CacheExists($size))
					$this->Cache($size);
				return $this->CacheName($size);
			}
			else
				return $this->_src;
		}
		else {
			return $this->_src;
		}    
        
	}
	
	//compability
	public function Bg($size = null, $nocache = false) {
		return "background: url(".$this->Src($size, $nocache).");";
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
		
		if($this->isValid) {
			if($this->mimetype->isImage)
				return "<img src='".$this->Src($size)."' alt=\"".htmlentities($this->alt)."\" ".$size->params." ".$attr." border='0' />";
			else if($this->mimetype->isFlash)
				return '<object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" '.
						$size->attributes.' 
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
						'.$size->attributes.' 
						allowscriptaccess="sameDomain" 
						type="application/x-shockwave-flash" 
						wmode="opaque" 
						pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';
		}		
		else {
			return "Not selected";
		}
	}
	
	public function Save() {
		return;
		
		if(!is_null($this->_content)) {
			$core->fs->WriteFile($this->_content, $this->_src);
		}
	}
	
	public function Merge($obj, Point $position, $alpha = false) {
    	global $core;
    	if($obj instanceof Blob || $obj instanceof FileView)
    		$obj = new ImageEditor($core->fs->MapPath($obj->Src()), '');
    	else
    		$obj = new ImageEditor($core->fs->MapPath($obj), '');

    	$i = new ImageEditor(0, 0, $this->data);
        if($alpha)
            $i->addWatermark($obj, 0, 0, $position->x, $position->y, $alpha);
        else
    	    $i->addImage($obj, $position->x, $position->y);
    	
    	$this->_content = $i->outputMem($this->type);
    	$this->ClearCache();
	}

    public function Delete() {
        global $core;
        $this->ClearCache();
        unlink($core->fs->MapPath($this->_src));
    }
    
    public function ColorAt(Point $p) {
        if($this->mimetype->isImage) {
            $data = $this->data;
            $img = new ImageEditor(0, 0, $data);
            return $img->getColorAt($p->x, $p->y);
        }
        return null;                   
    }
    
    public function ToXML() {
        return '<fileview>'.$this->Src().'</fileview>';    
    }
    
    
	
}


?>