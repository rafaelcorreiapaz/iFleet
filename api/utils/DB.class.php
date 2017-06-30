<?php

class DB
{

	private static $con;

	private function __construct(){}

	public static function getConnection()
	{

		if(!isset(self::$con))
		{

			$db   = 'ifleet';
			$host = 'localhost';
			$user = 'root';
			$pass = '';

			self::$con = new PDO("mysql:dbname={$db};host={$host}", $user, $pass);
		}

		return self::$con;

	}

}