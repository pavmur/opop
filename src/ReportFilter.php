<?php

abstract class ReportFilter
{
	/**
	* @var array
	*/
	protected $lastReport = array();

	/**
	* @param integer $sumValue
	* @param string $compareType 'filterLess' or 'filterGreater'
	* @return array
	*/
	public function getFilteredEntries($sumValue, $compareType)
	{
		if (!method_exists($this, $compareType)) {
			throw new ShopException("Неверный тип сравнения.");
		}

		return $this->$compareType($sumValue);
	}

	/**
	* @return void
	*/
	abstract protected function setReport();

	/**
	* @param integer $sumValue
	* @return array
	*/
	private function filterGreater($sumValue)
	{
		try {
			$this->checkInclusion($sumValue);
		} catch (ReportFilterException $exception) {
			if ($exception->getCode() > 20) {
				return $this->lastReport;
			}

			return array();
		}

		return array(
			array_slice($this->lastReport[0], $this->getOffsetValue($sumValue)),
			array_slice($this->lastReport[1], $this->getOffsetValue($sumValue))
		);
	}

	/**
	* @param integer $sumValue
	* @return array
	*/
	private function filterLess($sumValue)
	{
		try {
			$this->checkInclusion($sumValue);
		} catch (ReportFilterException $exception) {
			if ($exception->getCode() == 20) {
				return $this->lastReport;
			}

			return array();
		}

		return array(
			array_slice($this->lastReport[0], 0, $this->getOffsetValue($sumValue)),
			array_slice($this->lastReport[1], 0, $this->getOffsetValue($sumValue))
		);
	}

	/**
	* @param integer $sumValue
	* @return integer
	*/
	private function getOffsetValue($sumValue)
	{
		$first = 0;
		$last = count($this->lastReport[1]);

		array_multisort($this->lastReport[1], $this->lastReport[0]);

		while ($first < $last) {
			$middle = (int) ($first + ($last - $first)/2);

			if ($sumValue <= $this->lastReport[1][$middle]) {
				$last = $middle;
			} else {
				$first = $middle + 1;
			}
		}

		return $last;
	}

	/**
	* @param integer $sumValue
	* @return void
	*/
	private function checkInclusion($sumValue)
	{
		if (empty($this->lastReport[1])) {
			throw new ReportFilterException("Массив пустой.", 10);
		}

		if ($sumValue > $this->lastReport[1][count($this->lastReport[1]) - 1]) {
			throw new ReportFilterException("Значение больше последнего.", 20);
		}

		if ($sumValue < $this->lastReport[1][0]) {
			throw new ReportFilterException("Значение меньше первого.", 30);
		}
	}
}
