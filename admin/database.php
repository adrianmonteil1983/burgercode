<?php 

class Database
{
	private static $dbHost = "localhost";
	private static $dbName = "burger_code";
	private static $dbUser = "root";
	private static $dbPassword = "1111";
	
	private static $connection = NULL;


	public static function connect()
	{
		try
		{
			self::$connection = new PDO("mysql:host=" . self::$dbHost .";dbname=" . self::$dbName,self::$dbUser,self::$dbPassword);
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}

		return self::$connection;
	}

	public static function disconnect()
	{
		self::$connection = NULL;
	}
}


?>