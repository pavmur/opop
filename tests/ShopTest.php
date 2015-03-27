<?php

class ShopTest extends WrongLogTest
{
	/**
	 * @var Shop
	 */
	protected $shop;

	/**
	* @var Bookkeeping
	*/
	protected $bookkeeping;

	/**
	* @return void
	*/
	public function setUp()
	{
		$this->bookkeeping =
			$this->getMockBuilder('BookKeeping')
				->setMethods(array('compute', 'checkLogs', 'splitLogs'))
				->getMock();

		$this->shop = new Shop($this->bookkeeping);
	}

	/**
	 * @return void
	 * @test
	 */
	public function sellItem()
	{
		$this->shop->sellItem(2, 7);
		$this->shop->sellItem(3, 1);
		
		$this->assertEquals(0, $this->shop->countUp());

	}

	/**
	* @return void
	* @expectedException 		SellException
	* @expectedExceptionMessage Нельзя купить ноль товара.
	* @test
	*/
	public function sellItemNullItem()
	{
		$this->shop->sellItem(2, 0);
	}

	/**
	* @dataProvider providerWrongLog
	* @test
	*/
	public function receiveWrongLogs($logs)
	{
		$this->shop->setLogs($logs);
		$this->bookkeeping
			->expects($this->any())
			->method("compute")
			->will($this->throwException(new BookKeepingException()));

		$this->assertEquals(1, $this->shop->countUp());
	}

	/**
	* @return void
	* @test
	*/
	public function getFilteredEntriesVoidReport()
	{
		$this->assertEquals(array(), $this->shop->getFilteredEntries(10, 'filterLess'));
	}

	/**
	* @param array $expected
	* @param integer $sumValue
	* @param string $compareType
	* @return void
	* @dataProvider providerGetFilteredEntries
	* @test
	*/
	public function getFilteredEntries(array $expected, $sumValue, $compareType)
	{
		$this->bookkeeping
			->expects($this->any())
			->method("compute")
			->will($this->returnValue(array(array("A", "B", "C"), array(45, 56, 74))));

		$this->shop->countUp();

		$this->assertEquals($expected, $this->shop->getFilteredEntries($sumValue, $compareType));
	}

	/**
	 * @return array
	 */
	public function providerGetFilteredEntries()
	{
		return array(
			array(array(), 112, "filterGreater"),
			array(array(array("A", "B", "C"), array(45, 56, 74)), 39, "filterGreater"),
			array(array(array("B", "C"), array(56, 74)), 53, "filterGreater"),
			array(array(array("B", "C"), array(56, 74)), 56, "filterGreater"),
			array(array(), 40, "filterLess"),
			array(array(array("A", "B", "C"), array(45, 56, 74)), 116, "filterLess"),
			array(array(array("A", "B"), array(45, 56)), 60, "filterLess")
		);
	}

	/**
	* @return void
	* @expectedException 		ShopException
	* @expectedExceptionMessage Неверный тип сравнения.
	* @test
	*/
	public function filterWrong()
	{
		$this->shop->getFilteredEntries(10, "filterWrong");
	}
}