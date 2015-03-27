<?php

interface IBookkeeping
{
	/**
	* @param string $logs
	* @return array
	*/
	public function compute($logs);
}
