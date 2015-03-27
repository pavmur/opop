<?php

class WarehouseTest extends PHPUnit_Framework_TestCase
{
	/**
	* @var Warehouse
	*/
	protected $warehouse;

	/**
	* @return void
	*/
	public function setUp()
	{
		$this->warehouse = new Warehouse();
	}

	/**
	* @return void
	* @expectedException SellException
	* @expectedExceptionMessage Нет данного товара.
	* @test
	*/
	public function checkItemExistence()
	{
		$this->warehouse->checkItemExistence(100);
	}

	/**
	* @param integer $expectedName
	* @param integer $id
	* @return void
	* @dataProvider providerGetItem
	* @test
	*/
	public function getItem($expectedName, $id)
	{
		$this->assertEquals($expectedName, $this->warehouse->getItem($id)->name);
	}

	/**
	* @return array
	*/
	public function providerGetItem()
	{
		return array(
			array("Хлеб", 1),
			array("Яйцо", 3)
		);
	}
}
