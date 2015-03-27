<?php

class BookkeepingTest extends WrongLogTest
{
	/**
	 * @var Bookkeeping
	 */
	protected $bookkeeping;

	/**
	* @return void
	*/
	public function setUp()
	{
		$this->bookkeeping = new Bookkeeping();
	}

	/**
	* @param array $expected
	* @param string $logs
	* @return void
	* @dataProvider providerCompute
	* @test
	*/
	public function compute(array $expected, $logs)
	{
		$this->assertEquals($expected, $this->bookkeeping->compute($logs));
	}

	/**
	* @return array
	*/
	public function providerCompute()
	{
		return array(
			array(array(array("A", "B"), array(45, 75)), "A?45|B?75|"),
			array(array(array("T", "I"), array(85, 23)), "T?85|I?23|")
		);
	}

	/**
	* @expectedException BookKeepingException
	* @dataProvider providerWrongLog
	* @test
	*/
	public function receiveWrongLogs($logs)
	{
		$this->bookkeeping->compute($logs);
	}
}