<?php

class Shop extends ReportFilter
{
	/**
	* @var IBookkeeping
	*/
	private $bookkeeping;

	/**
	* @var Seller
	*/
	private $seller;

	/**
	* @var string
	*/
	private $logs = "";

	/**
	* @var Warehouse
	*/
	private $warehouse = array();

	function __construct(IBookkeeping $bk)
	{
		$this->bookkeeping = $bk;
		$this->seller = new Seller();
		$this->warehouse = new Warehouse();
	}

	/**
	* @param integer $id
	* @param integer $count
	* @return void
	*/
	public function sellItem($id, $count)
	{
		$this->checkItemQty($count);
		$this->warehouse->checkItemExistence($id);
		$this->logs .= $this->seller->sellItem($this->warehouse->getItem($id), $count);
	}

	/**
	* @return integer
	*/
	public function countUp()
	{
		try {
			$this->setReport();
			$this->setLogs("");
			return 0;
		} catch (BookKeepingException $e) {
			return $this->seller->getWrongEntryNumber($this->logs);
		}
	}

	/**
	* @param string $value
	* @return void
	*/
	public function setLogs($value)
	{
		$this->logs = $value;
	}

	protected function setReport()
	{
		$this->lastReport = $this->bookkeeping->compute($this->logs);
	}

	/**
	* @param integer $count
	* @return void
	*/
	private function checkItemQty($count)
	{
		if ($count <= 0) {
			throw new SellException("Нельзя купить ноль товара.");
		}
	}
}