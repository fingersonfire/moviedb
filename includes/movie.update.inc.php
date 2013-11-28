<?php
require_once($loc . "includes/movie.inc.php");

// The movie formats
$movieformats = $moviedm->getFormats();
$Website->assign("movieformats", $movieformats);

// Automatic update?
$autoupdate = isset($_GET["autoupdate"]);
$Website->assign("autoupdate", $autoupdate);

// Find movies from IMDb
if(isset($_GET["imdbsearch"])) {
	// What is the search term?
	$imdbsearch = trim($_GET["imdbsearch"]);
	$Website->assign("imdbsearch", $imdbsearch);
	if(strlen($imdbsearch) > 0) {
		// IMDB engine
		require_once($loc."/lib/imdbphp/imdb.class.php");
		require_once($loc."/lib/imdbphp/imdbsearch.class.php");
	
		// Search IMDb for the movie
		$imdb = new imdbsearch();
		$imdb->setsearchname($imdbsearch);
		$imdbresults = $imdb->results();
	
		// Check if any of these results are allready added to our database
		$temp = array();
		foreach($imdbresults as $result) {
			$result->known = false;
			$imdbmovie = $moviedm->getByImdb($result->imdbid());
			if($imdbmovie)
				$result->known = true;
			$temp[] = $result;
		}
		$imdbresults = $temp;
		$Website->assign("imdbresults", $imdbresults);
	}
}

// Update movie
if(isset($_POST["movieid"])) {
	// Editing existing movie?
	$movieid = $_POST["movieid"];
	$movie = $moviedm->get($movieid);
	if(!$movie) {
		$movie = new Movie();
	}
	
	// Update movie
	$movie = fillObject($movie, $_POST, array(), array('movieid', 'autoupdate', 'submit'));
	
	// Save movie
	$movie->id = $moviedm->save($movie);
	
	// Save its image
	if(isset($movie->imdbid) && strlen(trim($movie->imdbid)) > 0) {
		// IMDB engine
		require_once($loc."/lib/imdbphp/imdb.class.php");
		$m = new imdb($movie->imdbid);
		$m->savephoto($photopath . $movie->id.".jpg");
	}
	// Save its cover
	if(isset($_FILES["cover"]) && isset($_FILES["cover"]["size"]) && $_FILES["cover"]["size"] > 0) {
		$movie->addCover("cover", $coverpath);
	}
	
	// Go to the next auto update step
	if(isset($_POST["autoupdate"]) && $_POST["autoupdate"]) {
		header("Location: ./?go=imdbupdate&lastid=" . $movie->id);
		exit();
	}
	// Go to movie
	else {
		
		header("Location: ./?go=movie&id=" . $movie->id);
		exit();
	}
}

// Update movie seen status
if(isset($movie) && isset($_GET["seen"])) {
	$movie->seen = $_GET["seen"];
	$moviedm->save($movie);
	header("Location: ./?go=movie&id=" . $movie->id);
	exit();
}

// Update movie own status
if(isset($movie) && isset($_GET["own"])) {
	$movie->own = $_GET["own"];
	$moviedm->save($movie);
	header("Location: ./?go=movie&id=" . $movie->id);
	exit();
}
?>