<?

class Recordset extends Collection {

	private $position;
	public $fields;
	public $resource;
	private $fetched_count;
	private $identity;

    public $affected = -1;

	public function __construct($r, $identity = "") {
		parent::__construct();
		
		global $core;
		
		$this->position = -1;
		$this->fields = array();
		$this->resource = $r;
		$this->fetched_count = 0;
		$this->identity = $identity;
       
		if($this->is_resource()) {
			$nf = $core->dbe->num_fields($this->resource);
			for($i=0; $i < $nf; $i++) {
				$f = $core->dbe->fetch_field($this->resource, $i);
				$this->fields[$f->name] = $f;
			}
			$this->fields = array_change_key_case($this->fields, CASE_LOWER);
		}
	}

    public function Dispose() {
        if($this->is_resource()) {
            global $core;
            $core->dbe->free_result($this->resource);
            unset($this->resource);
        }
    }
    
	public function __destruct() {
        $this->Dispose();
        parent::Dispose();
	}

	public function is_resource() {
		return isset($this->resource) && gettype($this->resource) == "resource";
	}

	public function Count() {
		global $core;
		if($this->connected()) {
			if($this->is_resource())
				return $core->dbe->num_rows($this->resource);
			else
				return 0;
		}
		else
			return count($this->get_array());

	}

	public function Connected() {
		return isset($this->resource);
	}

	public function Disconnect($copy = true, $page = -1, $pagesize = -1) {
		global $core;
		
		if(!$this->connected()) return false;
		
		if($copy && $this->is_resource()) {
            $paged = $page > 0 && $pagesize > 0;
            if($paged) {
                $i = 1;
                if($page > 1) {
                    while($retorno = $core->dbe->fetch_object($this->resource)) {
                        if($i >= ($page-1)*$pagesize)
                            break;
                        $i++;
                    }
                }
            }

            $i=0;
			while ($retorno = $core->dbe->fetch_object($this->resource)) {
				$ident = $this->identity;
				if(empty($ident))
					$ident = parent::count()+1;
				else
					$ident = $retorno->$ident;
				parent::add("row".$ident, $retorno);
                $i++;
                if($paged) {
                    if($i >= $pagesize)
                        break;
                }

			}
			
		}
		
		$this->Dispose();
		return true;
	}
	
    public function CopyFrom($r) {
		$this->fields = $r->fields;
		$this->append($r->get_array());
	}

	public function __get($col)
	{
		if($this->bof()) {
			$this->FetchNext();
		}

		if($this->eof()) {
			die ("Recordset is EOF");
		}

		$r = $this->item($this->position);
		if (isset($r->$col))
			return $r->$col;
		else
			return NULL;
	}

	public function __set($col, $val) {
		if($this->bof()) {
			$this->FetchNext();
		}

		if($this->eof()) {
			die ("Recordset is EOF");
		}
		$r = $this->item($this->position);
		$r->$col = $val;
	}

	public function Exists($k) {
		if(is_string($k))
			$k = strtolower($k);
		$k = "row".$k;
		return parent::exists($k);
	}

	public function Bof() {
		return $this->position < 0;
	}

	public function Eof() {
		return (boolean)($this->position > $this->count());
	}

	public function Rewind(){
		$this->position = -1;
	}

	public function Fetch($i) {
		global $core;
		if(is_string($i))
			$p = parent::_getindex("row".$i);
		else
			$p = $i;

		$ip = $this->position;
		if($i < $p && $this->is_resource()) {
			while ($retorno = $core->dbe->fetch_object($this->resource)) {
				$ident = $this->identity;
				if(empty($ident))
					$ident = parent::count()+1;
				else
					$ident = $retorno->$ident;
				parent::add("row".$ident, $retorno);
				if(++$ip<=$p)
					break;
			}
		}

		$this->position = $p;
		return $this->item($this->position);
	}

	public function FetchNext() {
		global $core;
		
		$this->position++;
		if($this->is_resource()) {
			if ($retorno = $core->dbe->fetch_object($this->resource)) {
				$ident = $this->identity;
				if(empty($ident))
					$ident = parent::count()+1;
				else
					$ident = $retorno->$ident;
				parent::add("row".$ident, $retorno);
			}
			else
				$this->disconnect(false);

		}
		
		if( $this->key($this->position) )
			return $this->item($this->position);
		else
			return false;
	}

	public function fetch_next() {
        deprecate();
		return $this->FetchNext();
	}

	public function Item($k) {
		if(gettype($k) == "integer") {
			$k = parent::Key($k);
			return parent::Item($k);
		}
		else {
			return parent::Item("row".$k);
		}
	}

	function CopyTo(&$arg, $idd = null) {
		while($row = $this->FetchNext()) {
			if ($idd == null)
				$arg->add($row);
			else
				$arg->add($row->$idd, $row);
		}
	}
	
	function FetchAll($idfield = "", $k_ex = ""){
		$tmp = ($idfield == "") ? new arraylist() : new collection();
		while($row = $this->FetchNext())
			if ($idfield == "")
				$tmp->add($row);
			else
				$tmp->add($k_ex.$row->{$idfield}, $row);
		
		return $tmp;
	}



}

?>