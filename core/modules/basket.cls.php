<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2006
 */


class Product {
	
	public $id;
	public $storage;
	public $count;
	public $price;
	
	function Product($storage, $id = null, $count = null, $price = null){
		$this->storage = $storage;
		$this->id = $id;
		$this->price = $price;
		$this->count = $count;
	}
}

class Basket extends Collection {
	
	private $basketId;

	function Basket(){
		global $core;
		
		$this->basketId = $core->rq->SESSIONID; //session_id();

		$this->Load();
		if($this->Count() == 0)
			$core->rq->SESSION_CHANGED = false;
	}

	function Add($id, Product $item){
		return parent::Add($id, $item);
	}

	function Save(){
		global $core;
		$core->rq->{$this->basketId} = serialize($this->ToArray());
		$core->rq->SESSION_CHANGED = $this->Count() > 0;
		session_write_close(); //session_commit();
	}

	function Load(){
		global $core;
		$this->data = new Collection(@unserialize($core->rq->{$this->basketId}));
	}

	function Sum(){
		$s = 0;
		foreach($this->data as $key => $product) {
			$s += $product->price * $product->count;
		}
		return $s;
	}

	function ItemsCount(){
		$s = 0;
		foreach($this->data as $key => $product) {
			$s += $product->count;
		}
		return $s;
	}

}

?>