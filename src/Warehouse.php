<?php

class Warehouse
{
	/**
	* @var Item[]
	*/
	private $data = array();

	function __construct()
	{
		$this->setUpInitialItems();
	}

	/**
	* @param integer $id
	* @return void
	*/
	public function checkItemExistence($id)
	{
		if (!isset($this->data[$id])) {
			throw new SellException('Нет данного товара.');
		}
	}

	/**
	* @param integer $id
	* @return Item
	*/
	public function getItem($id)
	{
		return $this->data[$id];
	}

	/**
	* @return void
	*/
	private function setUpInitialItems()
	{
		array_push($this->data, new Item('Колбаса', 340));
		array_push($this->data, new Item('Хлеб', 37));
		array_push($this->data, new Item('Молоко', 65));
		array_push($this->data, new Item('Яйцо', 108));
		array_push($this->data, new Item('Рис', 45));
	}
}