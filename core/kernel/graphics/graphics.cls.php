<?php

    class GraphicsBatch {
        
        private $_history;
        
        public function __construct($operations = array()) {
            $this->_history = $operations;
        }
        
        public function Add($operation = array()) {
            $this->_history[] = $operation;
        }
        
        private function _joinHistory() {
            $ret = '';
            foreach($this->_history as $operation => $op) {
                $ret .= '-'.strtolower($operation);
                foreach($op as $o) {
                    if($o instanceOf Size) 
                        $ret .= '.'.$o->width.'x'.$o->height;
                    else if($o instanceOf Point) 
                        $ret .= '.'.$o->x.'x'.$o->y;
                    else
                        $ret .= '.'.(string)$o;
                }
            }
            return is_empty($ret) ? '' : substr($ret, 1);
        }
        
        private function _cacheFolder() {
            global $core;
            $path = $core->sts->BLOB_CACHE_FOLDER."/";
            return str_replace('//', '/', $path);
        }
        
        public function Cache($g) {
            global $core;
            $path = $this->_cacheFolder().md5($g->name).'.'.$this->_joinHistory().'.'.$g->type;
            if(!$core->fs->FileExists($path)) {
                $this->Batch($g);
                $g->Save($path);
            }
            return $path;
        }
        
        public function Batch($g) {
            foreach($this->_history as $operation => $params) {
                $g->$operation(@$params[0], @$params[1], @$params[2], @$params[3], @$params[4], @$params[5]);
            }
        }
        
        public static function Operate($g, $operations = array()) {
            $gb = new GraphicsBatch($operations);
            return $gb->Cache($g);
        }
        
    }

    class Graphics {
        
        private $_img;
        private $_size;
        private $_type;
        private $_file;
        
        private $_history = array();
        
        public function __construct() {
            $this->_img = null;
            $this->_size = new Size(0, 0);
            $this->_type = 'unknown';
        }
        
        public function __destruct() {
            @imagedestroy($this->_img);
        }
        
        public function __get($property) {
            switch(strtolower($property)) {
                case 'isvalid':
                    return !is_null($this->_img);
                case 'size':
                    return $this->_size;
                case 'type':
                    return $this->_type;
                case 'data':
                    return $this->_getImageData();
                case 'transparency':
                    return !is_null($this->_img) ? @imagecolortransparent($this->_img) : false;
                case 'name':
                    return $this->_file;
            }
        }
        
        public function __set($property, $value) {
            switch(strtolower($property)) {
                case 'type':
                    $this->_type = $value;
                    break;
            }
        }
        
        public function LoadFromData($data) {
            $this->_file = basename(str_random(20));
            $this->_img = @imagecreatefromstring($data);
            $this->_size = new Size(imagesx($this->_img), imagesy($this->_img));
            $this->_history = array();
            $this->_safeAlpha();
        }
        
        public function LoadFromFile($file) {
            $this->_file = basename($file);
            $this->_type = strtolower(end(explode('.', $file)));
            
            switch($this->_type) {
                case 'png':
                    $this->_img = @imagecreatefrompng($file);
                    break;
                case 'gif':
                    $this->_img = @imagecreatefromgif($file);
                    break;
                case 'jpg':
                case 'jpeg':
                    $this->_img = @imagecreatefromjpeg($file);
                    break;
            }
            $this->_size = new Size(imagesx($this->_img), imagesy($this->_img));
            $this->_history = array();
            $this->_safeAlpha();
        }
        
        public function LoadEmptyImage($size) {
            $this->_type = "unknown";
            $this->_img = imagecreatetruecolor($size->width, $size->height);
            $this->_size = $size;
            $this->_history = array();
            $this->_safeAlpha();
        }
        
        public function Resize($size) {
            if($this->isValid) {
                $newImage = @ImageCreateTrueColor($size->width, $size->height);
                ImageColorTransparent($newImage, imagecolorallocate($newImage, 0, 0, 0)); 
                ImageCopyResampled($newImage, $this->_img, 0, 0, 0, 0, $size->width, $size->height, $this->_size->width, $this->_size->height);
                ImageDestroy($this->_img);
                $this->_img = $newImage;
                $this->_size = $size;
                
                $this->_history[] = array('operation' => 'resize', 'postfix' => 'resized-'.$size->width.'x'.$size->height);
                
            }
        }
        
        public function Crop($size, $start = null) {
            if($this->isValid) {
                if(is_null($start)) $start = new Point(0, 0);
                $newImage = ImageCreateTrueColor($size->width, $size->height);
                ImageCopyResampled($newImage, $this->_img, 0, 0, $start->x, $start->y,
                                   $size->width, $size->height, $size->width, $size->height);
                ImageDestroy($this->_img);
                $this->_img = $newImage;
                $this->size = $size;
                
                $this->_history[] = array('operation' => 'crop', 'postfix' => 'croped-'.$start->x.'x'.$start->y.'.'.$size->width.'x'.$size->height);
            }
        }

        public function ApplyFilter($filter, $arg1 = 0, $arg2 = 0, $arg3 = 0) {
            switch($filter) {
                case IMG_FILTER_NEGATE:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'negate');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_GRAYSCALE:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'grayscale');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_BRIGHTNESS:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'brightness-'.$arg1);
                    return imagefilter($this->_img, $filter, $arg1);
                case IMG_FILTER_CONTRAST:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'contrast-'.$arg1);
                    return imagefilter($this->_img, $filter, $arg1);
                case IMG_FILTER_COLORIZE:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'colorize-'.$arg1.'x'.$arg2.'x'.$arg3);
                    return imagefilter($this->_img, $filter, $arg1, $arg2, $arg3);
                case IMG_FILTER_EDGEDETECT:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'edgedetect');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_EMBOSS:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'emboss');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_GAUSSIAN_BLUR:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'gausian-blur');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_SELECTIVE_BLUR:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'blur');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_MEAN_REMOVAL:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'mean-removal');
                    return imagefilter($this->_img, $filter);
                case IMG_FILTER_SMOOTH:
                    $this->_history[] = array('operation' => 'filter', 'postfix' => 'smooth-'.$arg1);
                    return imagefilter($this->_img, $filter, $arg1);
            }
            return false;
        }        
        
        public function Save($file) {
            global $core;
            $file = $core->fs->MapPath($file);
            switch($this->_type) {
                case 'png':
                    imagepng($this->_img, $file);
                    break;
                case 'gif':
                    imagegif($this->_img, $file);
                    break;
                case 'jpg':
                case 'jpeg':
                    imagejpeg($this->_img, $file);
                    break;
                default:
                    imagegd2($this->_img, $file);
                    break;
            }            
        }
        
        public function Cache() {
            global $core;
            $path = $this->_cacheFolder().md5($this->name).'.'.$this->_joinHistory().'.'.$this->_type;
            if(!$core->fs->FileExists($path))
                $this->Save($path);
            return $path;
        }
        
/* privates */
        
        private function _cacheFolder() {
            global $core;
            $path = $core->fs->mappath($core->sts->BLOB_CACHE_FOLDER)."/";
            return str_replace('//', '/', $path);
        }
        
        private function _safeAlpha() {
            // save alpha
            imagealphablending($this->_img, 1);
            imagesavealpha($this->_img, 1);
        }
        
        private function _tryCreateTempFile() {
            $filename = tempnam("","");
            if(!$filename) $filename = $this->_cacheFolder().str_random(20);
            return $filename;
        }
        
        private function _getImageData() {
            $tempFile = $this->_tryCreateTempFile();
            switch($this->_type) {
                case 'png':
                    imagepng($this->_img, $tempFile);
                    break;
                case 'gif':
                    imagegif($this->_img, $tempFile);
                    break;
                case 'jpg':
                case 'jpeg':
                    imagejpeg($this->_img, $tempFile);
                    break;
                default:
                    imagegd2($this->_img, $tempFile);
                    break;
            }            
            
            $c = file_get_contents($tempFile);
            unlink($tempFile);
            return $c;
        }
        
        private function _joinHistory() {
            $ret = '';
            foreach($this->_history as $operation) {
                $ret .= '.'.$operation['postfix'];
            }
            return is_empty($ret) ? $ret : substr($ret, 1);
        }
        
/* statics */
        
        public static function Info($path) {
            list($width, $height, $type, $attr) = @getimagesize($path);
            $o = new Object();
            $o->size = new Size($width, $height);
            $o->type = $type;
            $o->attr = $attr;
            return $o;
            
            
        }
        
        public static function Create($data) {
            global $core;
            $g = new Graphics();
            
            if($data instanceOf Size)
                $g->LoadEmptyImage($data);
            else if(file_exists($core->fs->MapPath($data))) {
                $g->LoadFromFile($core->fs->MapPath($data));
            }
            else 
                $g->LoadFromData($data);
            
            return $g;
        }
        
    }

?>
