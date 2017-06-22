<?php

class DB
{

	private static $con;

	public static function getConection()
	{

		if(!isset(self::$con))
		{

			$host    = "189.90.40.21";
			$port    = "18035";
			$user    = "postgres";
			$pass    = "";
			$db      = "viaradio";
			$schemas = ['public'];
			if(isset($_SESSION['_sistema']) && $_SESSION['_sistema'] != "")
				$schemas[] = $_SESSION['_sistema'];

			self::$con = new PDO("pgsql:dbname={$db} host={$host} port={$port}", $user, "");
			self::$con->query("SET search_path TO " . implode(", ", $schemas));
			self::$con->beginTransaction();

		}

		return self::$con;

	}

}