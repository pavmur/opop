<?php

class LogsStandart
{
	/**
	* @var string
	*/
	private static $entryDelimiter = "|";

	/**
	* @var string
	*/
	private static $itemDelimiter = "?";

	/**
	* @var string
	*/
	private static $logsRegExp = "/[а-яА-Я\w\s\-_]+\?\d+\|/";

	/**
	* @return string
	*/
	public static function getEntryDelimiter()
	{
		return self::$entryDelimiter;
	}

	/**
	* @return string
	*/
	public static function getItemDelimiter()
	{
		return self::$itemDelimiter;
	}

	/**
	* @return string
	*/
	public static function getLogsRegExp()
	{
		return self::$logsRegExp;
	}
}
