<?

define("IE_TABLE", "sys_index");
define("IE_TABLE_WORDS", "sys_index_words");

class IndexEngine extends IEventDispatcher {
    private $_objects;
    private $_exclussions;
    
    public function __construct() {
    }
    
    public function RegisterEventHandlers() {
        
        $this->HandleEvent("publication.add", "HandleInterfaceEvent");
        $this->HandleEvent("publication.save", "HandleInterfaceEvent");
        $this->HandleEvent("publication.discarding", "HandleInterfaceEvent");
        
    }
    
    public function Dispose() {
        unset($this->_objects);
        unset($this->_exclussions);
    }
    
    public function HandleInterfaceEvent($event, $args) {
        switch($event->name) {
            case "publication.add":
                $folder = $args->publication->FindFolder();
                if($this->CheckIfInIndex($folder) && !$this->CheckExclussions($args->publication))
                    $this->createIndex($folder, $args->publication);
                break;
            case "publication.save":
                $folder = $args->publication->FindFolder();
                if($this->CheckIfInIndex($folder) && !$this->CheckExclussions($args->publication))
                    $this->createIndex($folder, $args->publication);
                break;
            case "publication.discarding":
                $folder = $args->publication->FindFolder();
                
                if($this->CheckIfInIndex($folder) && !$this->CheckExclussions($args->publication))
                    $this->clearIndex($folder, $args->publication);
                break;
        }
        return $args;
    }
    
    public function CheckExclussions($publication) {
        if(is_null($this->_exclussions))
            return true;

        if(is_numeric($publication))
            $publication = new Publication($publication);
        
        if(!is_null($publication->datarow))
            return in_array($publication->datarow->storage->table, $this->_exclussions);
        else    
            return true;
    }
    
    public function CheckIfInIndex($folder) {
        if(is_null($this->_objects))
            return true;

        if ($folder instanceOf Site){
        	if (in_array($folder->name, $this->_objects))
	            return true;
	        return false;
        }
        
        if(!is_object($folder))
            $folder = Site::Fetch($folder);
        
        foreach($this->_objects as $object) {
            $o = Site::Fetch($object);
            if(!is_null($folder) && !is_null($o))
                if($folder->IsChildOf($o))
                    return true;
        }
        
        return false;
        
    }
    
    public function Initialize($objects = null /* array of folders to index */, $exclussions = null) {
        $this->checkIntegrity();
        
        if(is_null($objects)) {
            global $indexengine_objects;
            $objects = $indexengine_objects;
        }
        $this->_objects = $objects;
            
        
        if(is_null($exclussions)) {
            global $indexengine_exclussions;
            $exclussions = $indexengine_exclussions;
        }
        $this->_exclussions = $exclussions;
        
    }
    
    public function checkIntegrity() {
        global $core;
        if(!$core->dbe->tableexists(IE_TABLE)) {
            
            if(!$core->dbe->CreateTable(IE_TABLE, array(
                'index_folder' =>  array('type' => 'BIGINT', 'additional' => ' NOT NULL'),
                'index_publication' =>  array('type' => 'BIGINT', 'additional' => ' NOT NULL'),
                'index_word' =>  array('type' => 'BIGINT', 'additional' => ' NOT NULL'),
                'index_language' => array('type' => 'LONGVARCHAR', 'additional' => ' NOT NULL')
            ), array(), '')) {
                die("Can not create required table ".IE_TABLE);
            }
        }

        if(!$core->dbe->tableexists(IE_TABLE_WORDS)) {

            if(!$core->dbe->CreateTable(IE_TABLE_WORDS, array(
                'index_word_id' =>  array('type' => 'autoincrement', 'additional' => ''),
                'index_word' =>  array('type' => 'longvarchar', 'additional' => '')
            ), array(
                'index_word_id' => array('fields' => 'index_word_id', 'constraint' => 'PRIMARY KEY'),
                'index_word_word' => array('fields' => 'index_word', 'constraint' => 'UNIQUE')
            ), '')) {
                die("Can not create required table ".IE_TABLE_WORDS);
            }
        }
        
        $cols = $core->dbe->Fields("sys_index");
        if(!$cols->Exists('index_site')) if(!$core->dbe->AddField("sys_index", "index_site", "BIGINT", false, null)) die("can not modify required field in table sys_index");
    }
    
    public function clearIndex($folder = null, $publication = null) {
        global $core;
        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        
        if(is_numeric($publication)) {
            $publication = new Publication($publication);
        }
        
        $where = "";
        if(!is_null($folder))
            $where = " and index_folder='".$folder->id."'";
        if(!is_null($publication))
            $where = " and index_publication='".$publication->id."'";
        
        if($where != "")    
            $where = " where ".substr($where, 5);
        
        $q = "delete from ".IE_TABLE.$where;

        return $core->dbe->query($q);

    }
    
    public function _trimword($word) {
        return trim($word, " ,.(){}[]:;_-!@#\$%^&*\n\r");
    }
    
    private function _splitwords($dt /*DataRow*/, $returnString = false) {
        
        if(is_null($dt) || is_null($dt->storage))
            return array();
            
        $fields = $dt->storage->fields;
        $data = $dt->data();
        
        $string = "";
        foreach($fields as $field) {
            $fld = $field->field;
            $value = $dt->$fld;
            if ($value instanceof MultilinkField){
                $drs = $value->Rows();
                while ($dr = $drs->FetchNext())
                    $string .= " ".$this->_splitwords($dr, true);
            } 
            else if($value instanceof DataRow) {
                $lookup = $field->SplitLookup();
                $show = $lookup->show;
                //out($dt->storage->table, $value->$show);
                $string .= " ".$value->$show;
            } 
            else if($value instanceof Blob) {
                
            }
            else if($value instanceof BlobList) {
                
            }
            else if($value instanceof FileView) {
                
            }                
            else if($value instanceof FileList) {
            
			}    
            else if($value instanceof Collection) {
                
            } else {
                $string .= " ".$value;
            }
        }
        
        $string = html_strip($string);
        
        if ($returnString)
            return $string;
            
        $pattern = "/ |\,|\.|\(|\)|\{|\}|\[|\]|\:|\;|\_|\-|\!|\@|\#|\$|\%|\^|\&|\*|\\|\n|\r|\//im";
        
        $matches = preg_split($pattern, $string);
        $matches = array_unique($matches);  
        
        $matches = array_map(array($this, '_trimword'), $matches);
                        
        return $matches;
    }
    
    public function createIndexAll() {
        $objects = $this->_objects;
        
        foreach($objects as $fld) {
            if(!$this->createFolderIndex($fld))
                return false;
        }
        
        return true;
    }
    
    public function createFolderIndex($folder) {

        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        
        $args = $this->DispatchEvent("indexengine.folder.index", hashtable::create("folder", $folder));
        if (@$args->cancel === true)
            return true;

        if(!is_null($folder)) {
            $branch = $folder->Branch();
            foreach($branch as $f) {
                $publications = $f->Publications();
                while($pub = $publications->FetchNext()) {
                    if(!$this->createPublicationsIndex($f, $pub)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
    
    public function createPublicationsIndex($folder, $publication) {
        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        
        $args = $this->DispatchEvent("indexengine.publication.index", hashtable::create("folder", $folder, 'publication', $publication));
        if (@$args->cancel === true)
            return true;

        if(!$this->createIndex($folder, $publication))
            return false;
        
        $pubs = $publication->Publications();
        while($pub = $pubs->FetchNext()) {
            if(!$this->createPublicationsIndex($folder, $pub)) {
                return false;
            }
        }
            
        return true;
    }
    
    public function createIndex($folder, $publication) {
        global $core;
        if(is_numeric($folder) || is_string($folder)) {
            $folder = Site::Fetch($folder);
        }
        
        if(is_numeric($publication)) {
            $publication = new Publication($publication);
        }

        $args = $this->DispatchEvent("indexengine.index", hashtable::create("folder", $folder, 'publication', $publication));
        if (@$args->cancel === true)
            return true;

        $words = $this->_splitwords($publication->datarow);
        if(count($words) > 0) {
            $ws = $words;
            $w = " where index_word in ('".implode("', '", $words)."')";
            /*refresh word list*/
            $q = "select * from ".IE_TABLE_WORDS.$w;
            $rr = $core->dbe->ExecuteReader($q);
            while($r = $rr->Read()) {
                if($key = array_search($r->index_word, $words))
                    unset($words[$key]);
            }
            
            foreach($words as $word) { 
                // if the word length is up to 2 
                if(mb_strlen($word) > 2) {
                    //$word = trim($word, "\n\r\0 .");
                    $q = "INSERT INTO ".IE_TABLE_WORDS."(index_word) VALUES ('".$word."')";
                    $core->dbe->query($q);
                }
            }
    
            $wl = substr(implode("','", $ws), 2)."'";
            
            $wsq = $core->dbe->ExecuteReader("select * from ".IE_TABLE_WORDS." where index_word in (".$wl.")");
            if($wsq->Count() > 0) {
                $s = $folder instanceof Site ? $folder : $folder->Path()->Item(0);
                $fid = $folder->id;
                $pid = $publication->id;        
                $qq = "";
                
                $this->clearIndex($folder, $publication);
                
                if($wsq->Count() > 100) {
                    while($word = $wsq->Read()) {
                        $q = "INSERT INTO ".IE_TABLE."(index_site, index_folder, index_publication, index_word, index_language) VALUES ";
                        $qq = "('".$s->id."', '".$fid."', '".$pid."', '".$word->index_word_id."', 'ru')";
                        $q = $q.$qq;
                        if(!$core->dbe->query($q)) {
                            out("error", $q);
                            exit;
                        }
                    }
                }
                else {
                    $q = "INSERT INTO ".IE_TABLE."(index_site, index_folder, index_publication, index_word, index_language) VALUES ";
                    while($word = $wsq->Read()) {
                        $qq .= ", ('".$s->id."', '".$fid."', '".$pid."', '".$word->index_word_id."', 'ru')";
                    }
                    $qq = substr($qq, 2);
                    $q = $q.$qq;
                    if(!$core->dbe->query($q)) {
                        out("error", $q);
                        exit;
                    }
                }
                
                return true;
            }
            else 
                return true;
        }
        else {
            return true;
        }
    }

    public function createSearchCondition($s, $site = null) {

        $sRet = "";
        $s = trim($s);
        $s = preg_replace("/\./", " ", $s);
        $s = preg_replace("/,/", " ", $s);
        $s = preg_replace("/\(/", " ", $s);
        $s = preg_replace("/\)/", " ", $s);
        
        $sRetQs2 = "select distinct index_publication from sys_index where ";
        $sRetQ1 = "select distinct index_folder,index_publication, 0 as index_strict from sys_index where ";
        $sRetQ2 = "select distinct index_folder,index_publication, 1 as index_strict from sys_index where ";
        $sRetQe2 = " group by index_site, index_folder, index_publication having count(index_publication) > ";

        $sRet = "";
        $sRet1 = "";

        preg_match_all("/[^\s]*/", $s, $matches);
        $matches = array_unique($matches[0]);
        $icount = 0;                     
        foreach($matches as $match) {
            if($match != "") {
                $sRet = $sRet."index_word = '".$match."' or ";
                $sRet1 = $sRet1."index_word like '".$match."%' or ";
                $icount = $icount + 1;
            }
        }
        $sRet = substr($sRet, 0, strlen($sRet) - 4);
        $sRet1 = substr($sRet1, 0, strlen($sRet1) - 4);

        return "select * from (".$sRetQ2.$sRet.$sRetQe2.($icount-1)." union ".$sRetQ1.$sRet1." and index_publication not in (".$sRetQs2.$sRet.$sRetQe2.($icount-1).")) devtbl".(is_null($site) ? "" : " where index_site='".$site->id."'")." order by index_strict desc";
        //return $sRetQ2.$sRet.$sRetQe2.($icount-1)." order by index_strict desc";
    }
    
    private function splitQueryString($s) {
        $s = trim($s);
        $s = preg_replace("/\./", " ", $s);
        $s = preg_replace("/,/", " ", $s);
        $s = preg_replace("/\(/", " ", $s);
        $s = preg_replace("/\)/", " ", $s);

        preg_match_all("/[^\s]*/", $s, $matches);
        $matches = array_unique($matches[0]);
        
        $ret = array();
        foreach($matches as $match) {
            if($match != "" && !is_null($match))
                $ret[] = trim($match);
        }
        return $ret;
    }

    public function DoSearch($s, $page = 1, $pagesize = 10, $joinWith = false, $site = null) {
        global $core;
        
        $table = 'sys_search_results_'.md5(microtime(true));
        
        // $q = $this->createSearchCondition($s);
        $matches = $this->splitQueryString($s);
        $icount = count($matches);
        
        $sRet = "";
        $sRet1 = "";
        foreach($matches as $match) {
            $sRet = $sRet."index_word = '".$match."' or ";
            $sRet1 = $sRet1."index_word like '".$match."%' or ";
        }
        $sRet = substr($sRet, 0, strlen($sRet) - 4);
        $sRet1 = substr($sRet1, 0, strlen($sRet1) - 4);
        
        $q1 = "select distinct index_word_id, case when (index_word_id in (select index_word_id from ".IE_TABLE_WORDS." where ".$sRet.")) then 1 else 0 end as index_strict from ".IE_TABLE_WORDS." where ";
        $q = $q1."(".$sRet.") or ((".$sRet1.") and index_word_id not in (select index_word_id from ".IE_TABLE_WORDS." where ".$sRet."))";

        $core->dbe->CreateTableAs($table, $q, true, '(index_word_id int, index_strict bit)');
        
        // out($table, '(index_word_id int, index_strict bit)', $q);
        
        $qj = "";
        $qqqqq = "";
        if($joinWith) {
            $qj = " left outer join sys_tree on sys_tree.tree_id=sys_index.index_folder";
            $qqqqq = ", sys_tree.*";
        }
        
        if($core->dbe->driver instanceOf MsSqlDriver)
            $q = "select distinct index_folder, index_publication, min(index_strict) as index_strict".$qqqqq."  from ".IE_TABLE." inner join #".$table." on #".$table.".index_word_id=sys_index.index_word ".$qj." ".(is_null($site) ? '' : " where (index_site='".$site->id."')")." group by index_folder, index_publication";
        else
            $q = "select distinct index_folder, index_publication, min(index_strict) as index_strict".$qqqqq."  from ".IE_TABLE." inner join ".$table." on ".$table.".index_word_id=sys_index.index_word ".$qj." ".(is_null($site) ? '' : " where (index_site='".$site->id."')")." group by index_folder, index_publication";
        // out($q);
        $ret = $core->dbe->QueryPage($q, "", $page, $pagesize);
        
        if($core->dbe->driver instanceOf MsSqlDriver)
            $core->dbe->DropTable("#".$table);
        else
            $core->dbe->DropTable($table);
        
        return $ret;
        
    }
    
}




?>