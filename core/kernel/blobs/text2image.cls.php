<?php

class Text2Image {

	public $text;
	public $size;
	public $colors;
	public $startAt;
	public $type;
    public $alt;
	
	private $_uniq;
    private $_msize;
    private $_mstartAt;
    private $_mrheight;
	
	static $font; /* class Font */
	
	function __construct($text, $colorBg, $colorFont, $startAt = null, $imageSize = null){
		$this->text = $text;
		$this->type = 'png';
		$this->size = $imageSize;
		$this->colors = array("bg" => $colorBg, "font" => $colorFont);
										   
		$this->_uniq = md5($this->text.".".$this->colors["bg"].".".$this->colors["font"].Text2Image::$font->size.'.'.Text2Image::$font->angle);
		    
		if(!(Text2Image::$font instanceof Font)) {
			Text2Image::$font  = new Font("arial.ttf");
		}

        $this->_msize = new Size();
        $this->_mstartAt = new Point();
        Text2Image::$font->InscribeText($text, $this->_mstartAt, $this->_msize);
        $this->_mrheight = $this->_msize->height;
        $br = '<br />';
       	if(stripos($this->text, $br) !== false )
			$this->text = explode('<br />', $this->text); 
		if(is_array($this->text))
			$this->size->height += $this->_mrheight*(count($this->text)-1);
        
			
        $this->startAt = $startAt;
        if(is_null($this->startAt))
            $this->startAt = $this->_mstartAt;

		$this->size = $imageSize;
		if(is_null($this->size))
			$this->size = $this->_msize;
	}
	
	public function Src(){
		$this->Cache();
		return $this->CacheName();
	}
	
	public function Img($attributes = null){
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
        
		return "<img src='".$this->Src()."' alt=\"".htmlentities($this->alt)."\" ".$this->size->attributes." ".$attr." border='0' />";
		
	}
	
	public function CacheName() {
		global $core;
		$cachefolder = $core->sts->BLOB_CACHE_FOLDER;
		return $cachefolder."/".($this->_uniq.".".$this->type);
	}
	
	public function generateImage($fileName = null) {
		global $core;    
        
		// Create the image
		// $im = imagecreatetruecolor($this->size->width, $this->size->height);
		$width = $this->size->width;
		$height = $this->size->height;
        $im = imagecreatetruecolor($width, $height);
		// Create some colors
        if($this->colors["bg"] !== false) {
		    $rgbBg = html2rgb($this->colors["bg"]);
            $bgColor = imagecolorallocate($im, $rgbBg[0], $rgbBg[1], $rgbBg[2]);
            imagefilledrectangle($im, 0, 0, $width, $height, $bgColor);
        }
        else {
            imagealphablending($im,false);
            $col=imagecolorallocatealpha($im,0,0,0,127);
            imagefilledrectangle($im,0,0,$width, $height,$col);
            imagealphablending($im,true);            
        }
        
		$rgbFont = html2rgb($this->colors["font"]);
		$fontColor = imagecolorallocate($im, $rgbFont[0], $rgbFont[1], $rgbFont[2]);

		$font = Text2Image::$font->src;
	
		// Add some shadow to the text
		$startX = $this->startAt->x;
		$startY = $this->startAt->y;
		$br = '<br />';
		
		if(!is_array($this->text)) {
			imagettftext($im, Text2Image::$font->size, Text2Image::$font->angle, $startX, $startY, $fontColor, $font, $this->text);
		}
		else {
			foreach($this->text as $text) {
				imagettftext($im, Text2Image::$font->size, Text2Image::$font->angle, $startX, $startY, $fontColor, $font, $text);
				$startY += $this->_mrheight;
			}
		}
		

		// Using imagepng() results in clearer text compared with imagejpeg()
        imagealphablending($im,false);
        imagesavealpha($im,true);
		if(!is_null($fileName))
			imagepng($im, $fileName);
		else
			imagepng($im);
		imagedestroy($im);
	}

	public function Cache() {
		global $core;
		$this->generateImage($core->fs->mappath($this->CacheName()));
	}
	
	public function ReadCache($recache = false) {
		global $core;
		$ff = $this->CacheName();
		if($this->CacheExists() && !$recache)
			return $core->fs->readfile($ff);
		else {
			$this->Cache();
			return $this->ReadCache();
		}
	}
	
	public function CacheExists() {
		global $core;
		$ff = $this->CacheName();
		return $core->fs->fileexists($ff);
	}
	
	public function ClearCache() {
		global $core;
		$core->fs->deletefile($this->CacheName());
	}	
    
	public static function t2iSrc($text, $colorBg, $colorFont, $startAt = null, $imageSize = null, $font = null) {
		if($font instanceof Font)
			Text2Image::$font = $font;
		else if(is_string($font)) {
			Text2Image::$font = new Font($font);
		}
        
		$t2i = new Text2Image($text, $colorBg, $colorFont, $startAt, $imageSize);
		return $t2i->Src();
	}

	public static function t2iImg($text, $colorBg, $colorFont, $startAt = null, $imageSize = null, $font = null, $attributes = null) {
		if($font instanceof Font)
			Text2Image::$font = $font;
		else if(is_string($font)) {
			Text2Image::$font = new Font($font);
		}
		
		$t2i = new Text2Image($text, $colorBg, $colorFont, $startAt, $imageSize);
		return $t2i->Img($attributes);
	}

}

?>
