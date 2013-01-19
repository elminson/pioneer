<?php

    class AccessCode {
        
        public $code;
        private $_font;
        
        function AccessCode($code, $font = null){
            $this->_font = $font;
            if(is_null($this->_font))
                $this->_font = new Font('arial.ttf', '/resources/fonts', 14);
            $this->code = Encryption::Decrypt("123456789", $code);
        }
        
        public function Stream($type = 1){
            $f = "_Stream".$type;
            if (method_exists($this, $f))
                return $this->$f();
        }
        
        public static function Encode($code){
            return Encryption::Encrypt("123456789", $code);
        }
        
        public static function Src($code, $font = null){
            return "/resources/blobs/access".AccessCode::Encode($code).(!is_null($font) ? '*'.base64_encode($font->src.";".$font->size) : '').".access";
        }
        
        public static function Img($code, $font = null){
            return '<img src="'.AccessCode::Src($code, $font).'" alt="" />';
        }
        
        private function _Stream1(){

            $fontfile = $this->_font->src;

            $xkey = $this->code;
            
            /*$size[0]=imagettfbbox($this->_font->size+5, 0, $fontfile, $xkey);
            $size[1]=imagettfbbox($this->_font->size, 0, $fontfile, substr($xkey,0,1));
            $size[2]=imagettfbbox($this->_font->size, 0, $fontfile, substr($xkey,1,1));
            $size[3]=imagettfbbox($this->_font->size, 0, $fontfile, substr($xkey,2,1));
            $size[4]=imagettfbbox($this->_font->size, 0, $fontfile, substr($xkey,3,1));
            $size[5]=imagettfbbox($this->_font->size, 0, $fontfile, substr($xkey,4,1));
           
            $width[0] = $size[0][2] + $size[0][0];
            $width[1] = $size[1][2] + $size[1][0];  
            $width[2] = $size[2][2] + $size[2][0];  
            $width[3] = $size[3][2] + $size[3][0];  
            $width[4] = $size[4][2] + $size[4][0];  
            $width[5] = $size[5][2] + $size[5][0];  */
           
            $startAt = new Point(5, 10);
            $size = new Size();
            $this->_font->InscribeText($xkey, $startAt, $size);
            // $q = $this->_font->MeasureText($xkey);
            
            $im2 = imagecreate(
                $size->width+120,
                $size->height+15
            );
           
            $white=imagecolorallocate($im2,255,255,255);
            $c = array();
            for($i=0; $i<16; $i++) {
                srand((double)microtime()*1000000);
                $c[$i]=imagecolorallocate($im2,rand(0,160),rand(0,160),rand(0,160));
            }
           
            imagefill($im2, 0, 0,$white);
           
            $xwi=10;
           
            $i = 0;
            while($i < charCount($xkey)) {
                
                srand((double)microtime()*1000000);
                imagettftext($im2, $this->_font->size,rand(-50, 50),$xwi,$size->height + 5,$c[rand(0, 15)],$fontfile,charAt($xkey,$i));
                $xwi += 20;
                $i++;
            }
                      
            header("Content-Type: image/png");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            imagepng($im2);
           
            imagedestroy($im2);
            
        }
        
        private function _Stream2(){
            $rand = $this->code;

            /*$fw = imagefontwidth($font);
            $fh = imagefontheight($font);
            
            $width = $fw * strlen($rand) + 10; 
            $height = $fh + 10; 
            */
            
            $r = $this->_font->MeasureText($rand);
            
            $s = new Size($r->size->width+10, $r->size->height+10);
            
            $image = imagecreate($s->width, $s->height);
            $bgColor = imagecolorallocate ($image, 255, 255, 255);
            $textColor = imagecolorallocate ($image, 10, 100, 10);

            for ($i = 0; $i < 10; $i++) {
                $rx1 = rand(0,$s->width);
                $rx2 = rand(0,$s->width);
                $ry1 = rand(0,$s->height);
                $ry2 = rand(0,$s->height);
                $rcVal = rand(0,255);
                $rc1 = imagecolorallocate($image, 
                                            rand(0,255), 
                                            rand(0,255), 
                                            rand(100,255));

                imageline ($image, $rx1, $ry1, $rx2, $ry2, $rc1);
            }

            imagettftext($image, $this->_font->size, 0, 0, $s->height-5, $textColor, $this->_font->src, $rand);

            header('Content-type: image/jpeg');

            imagejpeg($image);
            imagedestroy($image);
            
        }
    }

?>