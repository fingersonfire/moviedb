<?php
require_once($loc . "lib/Database.class.php");
require_once($loc . "lib/db/Movie.class.php");

class Movies extends Database { 
	/**
	* Save this movie.
	* @param Movie $movie
	*/
	public function save($movie) {
		$m = $this->database->load("movies", $movie->id);
		if(!$m)
			$m = $this->database->dispense("movies");
		$this->fillObject($m, $movie);
		$this->database->store($m);
		return $m->id;
	}
	
	/**
	 * Remove a movie.
	 * @param Movie $movie
	 * @param string $photopath
	 * @param string $coverpath
	 */
	public function remove($movie, $photopath = false, $coverpath = false) {
		if(!$photopath) {
			global $photopath;
		}
		if(!$coverpath) {
			global $coverpath;
		}
		$m = $this->database->load("movies", $movie->id);
		if($m) {
			$this->database->trash($m);
			
			// Remove its photo and cover
			$movie->removePhoto($photopath);
			$movie->removeCover($coverpath);
		}
	}
	
	/**
	 * Create a class from the database item.
	 * @param $dbItem
	 */
	private function create($dbItem) {
		return $this->fillObject(new Movie(), $dbItem);
	}
	
	/**
	 * Get a user by its id.
	 * @param int $id
	 * @return the user or false when the user was not found
	 */
	public function get($id) {
		return $this->create($this->database->load("movies", $id));
	}
	
	/**
	 * Search for movies.
	 * @param string $search
	 * @param string $sort
	 * @param string $category
	 * @param int $page
	 * @param int $amount
	 * @return the movies that match the search criteria
	 */
	function search($search, $sort = "name", $category = "", $page = 0, $amount = 0) {
		// Words
		$words = preg_split("/\s+/", $search);

		// Query
		$query  = "SELECT SQL_CALC_FOUND_ROWS * FROM `movies` WHERE 1 = 1";
		if(count($words) > 0 && $words[0] != "") {
			$query .= " AND ";
			for($i = 0; $i < count($words); $i++) {
				$word = $words[$i];
				
				$query .= "(";
				$query .= "`name` LIKE '%".addslashes($word)."%' OR ";
				$query .= "`aka` LIKE '%".addslashes($word)."%' OR ";
				$query .= "`year` LIKE '%".addslashes($word)."%' OR ";
				$query .= "`plotoutline` LIKE '%".addslashes($word)."%'";
				$query .= ")";
				
				// Next word
				if($i + 1 < count($words))
					$query .= " AND ";
			}
		}
		// Category
		if($category != "") {
			$query .= " AND `genres` LIKE '%" . addslashes($category) . "%'";
		}
		if($sort && strlen(trim($sort)) > 0)
			$query .= " ORDER BY ".addslashes($sort).", name";
		if($amount > 0)
			$query .= " LIMIT ".addslashes($page).",".addslashes($amount);
		
		// Get all movies
		$movies = array();
		foreach($this->database->getAll($query) as $movie) {
			$movies[] = $this->create($movie);
		}
		return $movies;
	}
	
	/**
	 * Get the amount of rows when doing the search limited.
	 * @return the number of rows in total
	 */
	public function getFoundRows() {
		return $this->database->getCell("SELECT FOUND_ROWS()");
	}
	
	/**
	 * Get a movie by its Imdb id.
	 * @param string $imdbid
	 * @return the movie with this IMDb number
	 */
	function getByImdb($imdbid) {
		return $this->create($this->database->findOne('movies', 'imdbid = ?', array( $imdbid )));
	}
	
	/**
	 * Get all distinct categories.
	 * @return the list of category names
	 */
	public function getCategories() {
		$categories = array();
		foreach($this->database->getCol("SELECT `genres` FROM `movies`") as $category) {
			// Split by , or newlines
			foreach(preg_split("/,|\n/", $category) as $category) {
				$category = trim($category);
				if(strlen($category) > 0)
					$categories[$category] = $category;
			}
		}
		$categories = array_keys($categories);
		sort($categories);
		return $categories;
	}
	
	/**
	 * Add some movie format to the possible formats.
	 * @param string $format
	 */
	function addMovieFormat($format) {
		$format = trim($format);
		
		// Search all movie formats
		$allformats = $this->getMovieFormats();
		$temp = array();
		foreach($allformats as $f) {
			if(!in_array("'".$f."'", $temp))
				$temp[] = "'".$f."'";
		}
		$allformats = $temp;
		
		// Already known as a format, no need to add
		if(in_array($format, $allformats))
			return;
		$allformats[] = "'".$format."'";
		
		// Update table
		$query = "ALTER TABLE `movies` MODIFY COLUMN `format` ENUM(" . join(",", $allformats) . ") NOT NULL DEFAULT 'DVD'";
		$this->database->exec($query);
	}
	
	/**
	 * Removie some movie format from the possible formats.
	 * @param string $format
	 * @param string $newformat
	 */
	function removeMovieFormat($format, $newformat = "DVD") {
		$format = trim($format);
		
		// Search all movie formats
		$allformats = $this->getMovieFormats();
		
		// Remove format
		$temp = array();
		foreach($allformats as $f) {
			if($f != $format) {
				$temp[] = "'".$f."'";
			}
		}
		$allformats = $temp;
		
		// Update movies
		$query = "UPDATE `movies` SET `format` = '" . $newformat . "' WHERE `format` = '" . $format . "'";
		$this->database->exec($query);
		
		// Update table
		$query = "ALTER TABLE `movies` MODIFY COLUMN `format` ENUM(" . join(",", $allformats) . ") NOT NULL DEFAULT 'DVD'";
		$this->database->exec($query);
	}
	
	/**
	 * Retrieve all distinct movie formats from the database.
	 * @return all movie formats
	 */
	function getFormats() {
		$formats = array();
		foreach($this->database->getCol("SELECT DISTINCT `format` FROM `movies`") as $format) {
			if(strlen($format) > 0)
				$formats[] = $format;
		}
		return $formats;
	}
}

?>