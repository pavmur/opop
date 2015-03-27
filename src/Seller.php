<?php

class Seller
{
	/**
	* @param Item $item
	* @param integer $itemCount
	* @return string
	*/
	public function sellItem(Item $item, $itemCount)
	{
		return $item->name
			. LogsStandart::getItemDelimiter()
			. ($item->price * $itemCount)
			. LogsStandart::getEntryDelimiter();
	}

	/**
	* @param string $logs
	* @return integer
	*/
	public function getWrongEntryNumber($logs)
	{
		$match = array();
		$splicedEntries = "";

		preg_match_all(LogsStandart::getLogsRegExp(), $logs, $match);

		for ($i=0; $i<count($match[0]); $i++) {
			$splicedEntries .= $match[0][$i];
			if ($this->checkLogCorrespondence($logs, $splicedEntries) == 20) {
				return $i+1;
			}
		}

		if ($this->checkLogCorrespondence($logs, $splicedEntries) == 10) {
			return $i+1;
		}

		return 0;
	}

	/**
	 *
	 * @param string $logs
	 * @param string $splicedEntries
	 * @return integer
	 */
	private function checkLogCorrespondence($logs, $splicedEntries)
	{
		try {
			$this->compareLogStrings($logs, $splicedEntries);
		} catch (LogEntryException $exception) {
			return $exception->getCode();
		}

		return 0;
	}
	/**
	* @param string $logs
	* @param string $splicedEntries
	* @return void
	*/
	private function compareLogStrings($logs, $splicedEntries)
	{
		if (empty($splicedEntries)) {
			throw new LogEntryException("Error in first entry", 10);
		}

		if (strpos($logs, $splicedEntries) !== 0) {
			throw new LogEntryException("Entry error", 20);
		}

		if ($splicedEntries != $logs) {
			throw new LogEntryException("Error in last entry", 10);
		}
	}
}