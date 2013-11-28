<?php
require_once($loc . "lib/DatabaseManager.class.php");

class Database {
	protected static $database;

	/**
	 * Construct a new database object.
	 * @param $settings
	 */
	public function __construct($settings) {
		$this->database = DatabaseManager::connect(
			$settings["host"],
			$settings["port"],
			$settings["user"],
			$settings["pass"],
			$settings["name"],
			isset($settings["utf8"]) ? $settings["utf8"] : true);
		
		// Debug
		global $settings;
		R::debug($settings["development"]);
	}
	
	/**
	 * Get the database connection for direct quries.
	 */
	public function getDatabase() {
		return $this->database;
	}

	/**
	 * Fill this object with the row information.
	 * @param $obj
	 * @param $row
	 */
	protected function fillObject($obj, $row) {
		if(isset($row) && $row) {
			foreach($row as $key => $value)
				$obj->{$key} = stripslashes($value);
			return $obj;
		}
		return false;
	}
}