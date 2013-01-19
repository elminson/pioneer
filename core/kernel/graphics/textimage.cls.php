<?php
 
class Alphabet {
	
	private $_folder;
	private $_list;
	private $_chartofile;
	private $_outputdir;
	
	public function __construct($folder = "default", $outputdir = "", $dontload = false) {
		$this->_folder = $folder;
		$this->_list = null;
		$this->_loadPre();
		$this->_outputdir = $outputdir;
		if(!$dontload)
			$this->_Load();
	}
	
	private function _loadPre() {
		$this->_chartofile = array(
			"0" => "0",
			"1" => "1",
			"2" => "2",
			"3" => "3",
			"4" => "4",
			"5" => "5",
			"6" => "6",
			"7" => "7",
			"8" => "8",
			"9" => "9",
			"9" => "9",			
			"00" => " ",
			"01" => "$",
			"02" => "/",
			"03" => "(",
			"04" => ")",
			"05" => "!",
			"06" => "?",
			"07" => "%",
			"08" => "@",
			"09" => ".",
			"10" => ",",						
			"11" => "|",
			"12" => "-",
			"13" => "_",
			"001" => "А",
			"002" => "Б",
			"003" => "В",
			"004" => "Г",
			"005" => "Д",
			"006" => "Е",
			"007" => "Ж",
			"008" => "З",
			"009" => "И",
			"010" => "К",
			"011" => "Л",
			"012" => "М",
			"013" => "Н",
			"014" => "О",
			"015" => "П",
			"016" => "Р",
			"017" => "С",
			"018" => "Т",
			"019" => "У",
			"020" => "Ф",
			"021" => "Х",
			"022" => "Ц",
			"023" => "Ч",
			"024" => "Ш",
			"025" => "Щ",
			"026" => "Ъ",
			"027" => "Ы",
			"028" => "Ь",
			"029" => "Э",
			"030" => "Ю",
			"031" => "Я",
			"032" => "Ё",
			"033" => "Й",
			"101" => "а",
			"102" => "б",
			"103" => "в",
			"104" => "г",
			"105" => "д",
			"106" => "е",
			"107" => "ж",
			"108" => "з",
			"109" => "и",
			"110" => "к",
			"111" => "л",
			"112" => "м",
			"113" => "н",
			"114" => "о",
			"115" => "п",
			"116" => "р",
			"117" => "с",
			"118" => "т",
			"119" => "у",
			"120" => "ф",
			"121" => "х",
			"122" => "ц",
			"123" => "ч",
			"124" => "ш",
			"125" => "щ",
			"126" => "ъ",
			"127" => "ы",
			"128" => "ь",
			"129" => "э",
			"130" => "ю",
			"131" => "я",
			"132" => "ё",
			"133" => "й",
			"A" => "A",
			"B" => "B",
			"C" => "C",
			"D" => "D",
			"E" => "E",
			"F" => "F",
			"G" => "G",
			"H" => "H",
			"I" => "I",
			"J" => "J",
			"K" => "K",
			"L" => "L",
			"M" => "M",
			"N" => "N",
			"O" => "O",
			"P" => "P",
			"Q" => "Q",
			"R" => "R",
			"S" => "S",
			"T" => "T",
			"U" => "U",
			"V" => "V",
			"W" => "W",
			"X" => "X",
			"Y" => "Y",
			"Z" => "Z",
			"aa" => "a",
			"bb" => "b",
			"cc" => "c",
			"dd" => "d",
			"ee" => "e",
			"ff" => "f",
			"gg" => "g",
			"hh" => "h",
			"ii" => "i",
			"jj" => "j",
			"kk" => "k",
			"ll" => "l",
			"mm" => "m",
			"nn" => "n",
			"oo" => "o",
			"pp" => "p",
			"qq" => "q",
			"rr" => "r",
			"ss" => "s",
			"tt" => "t",
			"uu" => "u",
			"vv" => "v",
			"ww" => "w",
			"xx" => "x",
			"yy" => "y",
			"zz" => "z"			
		);	
	}
	
	
	private function _Load() {
		global $core;
		// each line must contain an info of a letter
		// letter=file,width,height
		if(!is_null($this->_list))
			array_splice($this->_list, 0, count($this->_list));
		else
			$this->_list = array();	
		
		if(is_empty($this->_outputdir))
			$this->_outputdir = $core->sts->ALPHABET_PATH.$this->_folder;
		
		$path = $core->fs->mappath($core->sts->ALPHABET_PATH.$this->_folder."/letters.ini", SITE);
		if($core->fs->fileexists($path)) {
			$contents = $core->fs->readfile($path);
			$contents = explode("\n", $contents);
			foreach($contents as $line) {
				$line = explode("=", $line);
				$letter = $line[0];
				if(!is_empty($line[0])) {
					$in = explode(",", @$line[1]);
					$info = new Object(null, "line_");
					$info->letter = $letter;
					$info->file = @$in[0];
					$info->width = @$in[1];
					$info->height = @$in[2];
					$this->_list[$letter] = $info;
				}
			}
		}
	}
	
	public function CreateAlphabetCollection() {
		global $core;

		$content = "";
		$path = $core->fs->mappath($core->sts->ALPHABET_PATH.$this->_folder."/", SITE);
		if($core->fs->direxists($path)) {
			$files = $core->fs->list_files($path, array("gif", "jpg", "png"));
			foreach($files as $file) {
				$i = new ImageEditor($file->file, $path);
				$width = $i->x;
				$height = $i->y;
                $i->Dispose();
				$content .= @$this->_chartofile[$file->file_name]."=".$file->file.",".$width.",".$height."\n";
			}
			
			$core->fs->writefile($path."letters.ini", $content);
		}
		
	}
	
	function ValidateChar($char) {
		switch(mb_strtolower($char, "UTF-8")) {
			/*case "й":
				return "и";
			case "ё":
				return "е";*/
			default:
				return $char;
		}
	}
	
	public function Out($text, $spacer = " ", $imgclass = "", $prefix = "", $postfix = "") {
		global $core;
		$ret = "";
		$start = '<img src="';
		if($imgclass != "")
			$end = '" class="'.$imgclass.'" alt="'.$text.'" border="0" ';
		else
			$end = '" alt="'.$text.'" border="0" ';
		$width = ' width="';
		$height = ' height="';
		$sp = $this->_list[$spacer];
		$spacer = $start.$core->sts->ALPHABET_PATH.$this->_folder.'/'.$sp->file.$end.$width.$sp->width.'"'.$height.$sp->height.'" />';
		
		//$text = mb_strtoupper($text,  "UTF-8");
		$len = mb_strlen($text, "UTF-8");
		for($i=0; $i<$len; $i++) {
			$char = mb_substr($text, $i, 1, "UTF-8");
			$letter = $this->_list[$char];
			
			$img = $start.$core->sts->ALPHABET_PATH.$this->_folder.'/'.$letter->file.$end.$width.$letter->width.'"'.$height.$letter->height.'" />';
			$ret .= $img.$spacer;
		}
		return $prefix.$ret.$postfix;
	}
	
	public function OutMerged($text, $spacer = " ", $imgclass = "", $prefix = "", $postfix = "", $orientation = HORIZONTAL, $type = "gif") {
		global $core;
		
		$images = array();
		if(!is_empty($spacer))
			$sp = $this->_list[$spacer];
		
		$rettext = "";
		// $text = mb_strtoupper($text,  "UTF-8");
		$len = mb_strlen($text, "UTF-8");
		$path = $core->fs->mappath($core->sts->ALPHABET_PATH.$this->_folder);
		for($i=0; $i<$len; $i++) {
			$char = mb_substr($text, $i, 1, "UTF-8");
			
			$char = $this->ValidateChar($char);
			
			$rettext .= $char.(!is_empty($spacer) ? $spacer : "");
			$letter = @$this->_list[$char];
			@$images[] = new ImageEditor(@$letter->file, $path);
			if(!is_empty($spacer))
				@$images[] = new ImageEditor($sp->file, $path);
		}
		
		$fname = md5($this->_folder."/".$rettext).".".$type;
		$path = $core->fs->mappath($this->_outputdir);
		if($core->fs->fileexists($path."/".$fname)) {
			$merged = new ImageEditor($fname, $path);
			return $prefix.'<img src="'.$this->_outputdir."/".$fname.'" width="'.$merged->x.'" height="'.$merged->y.'" '.(!is_empty($imgclass) ? 'class="'.$imgclass.'"' : '').' alt="'.$text.'" />'.$postfix;
		}
		
		$merged = @ImageEditor::Merge($images, $type, $orientation);
		$merged->type = $type;
		$merged->outputFile($fname, $path."/");
        
        foreach($images as $ii) 
            $ii->Dispose();
		
		return $prefix.'<img src="'.$this->_outputdir."/".$fname.'" width="'.$merged->x.'" height="'.$merged->y.'" '.(!is_empty($imgclass) ? 'class="'.$imgclass.'"' : '').' alt="'.$text.'" />'.$postfix;
	}
	
	
}

?>