<?php

class SystemConfig
{

	private static $config;
	private static $data;

	const VARNAME = 'SystemConfig';

	private function __construct()
	{

		$varName = self::VARNAME;
		include_once SystemLibrary::getPath() . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "{$varName}.php";

		if(isset($$varName))
		{
			self::$data = $$varName;
			unset($$varName);
		}
		else
			throw new Exception("Config is undefined.");

	}

	public static function init()
	{
		if (self::$config == null)
			self::$config = new SystemConfig();

		if(isset($_SESSION["_sistema"]))
		{
			$sistema = self::getData($_SESSION["_sistema"]);
			if($sistema != "")
				date_default_timezone_set(self::getData($_SESSION["_sistema"])["timezone"]);
		}
		return self::$config;
	}

	public static function getData($key)
	{
		if(isset(self::$data[$key]))
			return self::$data[$key];
		else
			throw new Exception("Config key {$key} not found.");
	}


}