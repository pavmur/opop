<?php

class Item 
{
	/**
	* @var string 
	*/
	public $name;
	
	/**
	* @var integer
	*/
	public $price;

	function __construct($name, $price) 
	{
		$this->name = $name;
		$this->price = $price;
	}
}