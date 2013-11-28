<?php
require_once($loc . "lib/redbean/rb.php");

class DatabaseManager {
	/**
	 * Multiple database connections are managed here.
	 */
	private static $_databaseNames = array();
	private static $_databaseConnections = array();

	/**
	 * Connect to a database and return the connection.
	 *
	 * @param $host
	 * @param $port
	 * @param $username
	 * @param $password
	 * @param $database
	 * @param $utf8
	 * @return the created connection
	 */
	public function connect($host, $port, $username, $password, $database, $utf8 = true) {
		// Database unique name
		$db_name = $username . ":" . $password . "@". $host . ":" . $port . "/" . $database;

		// Create a new connection
		if(!isset(self::$_databaseNames[$db_name])) {
			self::$_databaseNames[$db_name] = array(
				"dsn" 		=> "mysql:host=" . $host . ";port=" . $port . ";dbname=" . $database,
				"username" 	=> $username,
				"password"	=> $password,
				"frozen"	=> true);
			self::$_databaseConnections = R::setupMultiple(self::$_databaseNames);
		}
		if($utf8)
			self::$_databaseConnections[$db_name]->exec("SET NAMES 'utf8';");
		return self::$_databaseConnections[$db_name];
	}
}
