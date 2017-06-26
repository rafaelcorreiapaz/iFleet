<?php

class DB
{

	private static $con;

	private function __construct(){}

	public static function getConnection()
	{

		if(!isset(self::$con))
		{
			$host    = "localhost";
			$user    = "root";
			$pass    = "";
			$db      = "ifleet";

			self::$con = new PDO("mysql:dbname={$db};host={$host}", $user, "");
		}

		return self::$con;

	}

}