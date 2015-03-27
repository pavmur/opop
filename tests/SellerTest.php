<?php

class SellerTest extends PHPUnit_Framework_TestCase
{
	/**
	* @var Seller
	*/
	protected $seller;

	/**
	* @return void
	*/
	public function setUp()
	{
		$this->seller = new Seller();
	}

	/**
	* @return void
	* @test
	*/
	public function sellItem()
	{
		$this->assertEquals('Хлеб ржаной?175|', $this->seller->sellItem(new Item('Хлеб ржаной', 35), 5));
		$this->assertEquals('Греча?0|', $this->seller->sellItem(new Item('Греча', 0), 3105));
	}

	/**
	* @param integer $expectedEntryNumber
	* @param string $logs
	* @return void
	* @dataProvider providerGetWrongEntryNumber
	* @test
	*/
	public function getWrongEntryNumber($expectedEntryNumber, $logs)
	{
		$this->assertEquals($expectedEntryNumber, $this->seller->getWrongEntryNumber($logs));
	}

	/**
	* @return array
	*/
	public function providerGetWrongEntryNumber()
	{
		return array(
			array(1, "A1|B?2|C?3|"),
			array(0, "A?100|BK?645|An?789|"),
			array(9, "A?1|B?2|C?3|A?1|B?2|C?3|A?1|B?2|C?3"),
			array(1, "A?1B?2|C?3|"),
			array(2, "A?1|B?2C?3|"),
			array(3, "A?1|B?2|C3|"),
			array(6, "A?1|B?2|C?3|A?1|B?2|C?3A?1|B?2|C?3|"),
			array(1, "1234567")
		);
	}
}