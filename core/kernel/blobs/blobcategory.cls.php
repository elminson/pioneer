<?php

class BlobCategory extends Object {
	
	public function __construct($obj = null) {
		global $core;
		if(!is_object($obj) && !is_null($obj)) {
			$where = "";
			if(gettype($obj) == "integer")
				$where = "category_id=".$obj;
			elseif(gettype($obj) == "string")
				$where = "category_description='".$obj."'";
			else 
				trigger_error("error loading blob category ", E_USER_ERROR);
			$r = $core->dbe->ExecuteReader("select *, 
									  (select count(*) from sys_blobs where sys_blobs.blobs_parent=sys_blobs_categories.category_id) as category_blobs, 
									  (select count(*) from sys_blobs_categories c1 where c1.category_parent=sys_blobs_categories.category_id) as category_children
									  from sys_blobs_categories where ".$where);
			$obj = @$r->Read();
		}
		
		parent::__construct($obj, "category_");
		
		if(!is_numeric($this->id))
			$this->id = -1;

		if(!($this->securitycache instanceof Hashtable)) {
			$this->securitycache = @unserialize($this->securitycache);
			if($this->securitycache === false || is_null($this->securitycache)) $this->securitycache = new Hashtable();
		}
		
	}
	
	public function Children() {
		return new BlobCategories($this);
	}

	public function Blobs($sort = null, $page = -1, $pagesize = 10) {
		return new Blobs($this, $sort, $page, $pagesize);
	}
	
	public function Delete() {
		global $core;
		if($this->children > 0) {
			$children = $this->Children();
			foreach($children as $category) {
				$category->Delete();
			}
		}
		
		$core->dbe->query("update sys_blobs set blobs_parent=-1 where blobs_parent=".$this->id);
		return $core->dbe->query("delete from sys_blobs_categories where category_id=".$this->id);
	}
	
	public function Save() {
		global $core;
		$data = $this->ToCollection();
		$data->Delete("category_id");
		$data->Delete("category_children");
		$data->Delete("category_blobs");
		if($data->category_securitycache instanceof Hashtable)
			$data->category_securitycache = serialize($data->category_securitycache);

		if(is_null($this->id) || $this->id == -1)
			$this->id = $core->dbe->insert("sys_blobs_categories", $data);
		else 
			$core->dbe->set("sys_blobs_categories", "category_id", $this->id, $data);
	}
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("blobs.categories.category.delete", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.category.edit", "Edit the blob category"));
		$operations->Add(new Operation("blobs.categories.category.items.add", "Add a blob"));
		$operations->Add(new Operation("blobs.categories.category.items.delete", "Delete the blob"));
		$operations->Add(new Operation("blobs.categories.category.items.edit", "Edit the blob"));

		$operations->Add(new Operation("blobs.categories.category.children.add", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.category.children.delete", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.category.children.edit", "Edit the blob category"));
		$operations->Add(new Operation("blobs.categories.category.children.items.add", "Add a blob"));
		$operations->Add(new Operation("blobs.categories.category.children.items.delete", "Delete the blob"));
		$operations->Add(new Operation("blobs.categories.category.children.items.edit", "Edit the blob"));
		return $operations;
	}

	// creates a back list for security check
	public function createSecurityBathHierarchy($suboperation) {
		global $core;
		$prefixCategories = "blobs.categories.category.";
		$prefixBlobs = "blobs.";

		$tree = array();
		$bc = $this;

		while($bc->parent != -1 && !is_null($bc->parent)) {
			$tree[] = array("object" => $bc, "operation" => $prefixCategories.($bc->description != $this->description ? "children." : "").$suboperation);
			$bc = new BlobCategory(intval($bc->parent));
		}
		$tree[] = array("object" => new BlobCategories(), "operation" => $prefixBlobs.$suboperation);

		return $tree;
	}
	
}

class BlobCategories extends ArrayList {
	
	public $securitycache;
	
	private $_parent;
	
	public function __construct($parent = null) {
		parent::__construct();
		
		$this->securitycache = new Hashtable();
		$this->_parent = $parent;
		$this->Load();
		
	}
	
	public function Load() {
		global $core;
		$r = $core->dbe->ExecuteReader("select *, 
								  (select count(*) from sys_blobs where sys_blobs.blobs_parent=sys_blobs_categories.category_id) as category_blobs, 
								  (select count(*) from sys_blobs_categories c1 where c1.category_parent=sys_blobs_categories.category_id) as category_children
								  from sys_blobs_categories where category_parent=".(is_null($this->_parent) ? -1 : $this->_parent->id));
        while($row = $r->Read()) {
			$c = new BlobCategory($row);
			parent::Add($c);
		}

	}
	
	public function Add($category) {
		$category->Save();
		parent::Add($category->description, $category);
	}
	
	public function Delete($category) {
		parent::Delete($category->description);
		$category->Delete();
	}
	
	public static function TransformTables($parent = -1, $newparent = -1) {
		//return ;
		global $core;
		$q = "select * from sys_blobs where blobs_isfolder=1 and blobs_parent=".$parent;
				
		$r = $core->dbe->ExecuteReader($q);
		while($rr = $r->Read()) {
			
			$b = new BlobCategory();
			$b->description = $rr->blobs_category;
			$b->parent = $newparent;
			$b->Save();
			
			$qq = "update sys_blobs set blobs_parent=".$b->id." where blobs_isfolder=0 and blobs_parent=".$rr->blobs_id;
			$core->dbe->query($qq);
			
			BlobCategories::TransformTables($rr->blobs_id, $b->id);
		}
		
	}
	
	public static function WidthAndHeights() {
		//return;
		$blobs = new Blobs(BLOBS_ALL);
		foreach($blobs as $blob) {
			$blob->Save(false);
		}
	}	
	
	public static function getOperations() {
		$operations = new Operations();
		$operations->Add(new Operation("blobs.categories.add", "Add a blobs category"));
		$operations->Add(new Operation("blobs.categories.delete", "Delete the blob category"));
		$operations->Add(new Operation("blobs.categories.edit", "Edit the blob category"));
		$operations->Add(new Operation("blobs.categories.move", "Move category"));
		$operations->Add(new Operation("blobs.items.add", "Add a blob"));
		$operations->Add(new Operation("blobs.items.delete", "Delete the blob"));
		$operations->Add(new Operation("blobs.items.edit", "Edit the blob"));
		$operations->Add(new Operation("blobs.items.move", "Move blob"));
		return $operations;
	}

	public function createSecurityBathHierarchy($suboperation) {
		return array(array("object" => $this, "operation" => "blobs.".$suboperation));
	}
	
	
}

?>