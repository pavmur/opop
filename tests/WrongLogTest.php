<?php

abstract class WrongLogTest extends PHPUnit_Framework_TestCase
{
	/**
	* @param string $logs
	* @return void
	*/
	abstract public function receiveWrongLogs($logs);

	/**
	* @return array
	*/
	public function providerWrongLog()
	{
		return array(
			array(5),
			array("Хурма?145Батон?24|Коньяк?64|"),
			array("9813468906"),
			array(""),
			array("Яйцо?23"),
			array("Булка?|"),
			array("?780|"),
			array("Огурец?45")
		);
	}
}
