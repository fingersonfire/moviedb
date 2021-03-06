<?php
require_once($loc . "includes/movie.inc.php");

// Only update when the user has editor permissions
if($loggedin && $User->isEditor()) {
	// Get the last movie updated
	$lastMovieId = isset($_GET["lastid"]) ? $_GET["lastid"] : false;
	
	// Get the next movie to update
	$movies = $moviedm->search("", "id");
	$nextMovie = false;
	foreach($movies as $movie) {
		if(!$lastMovieId && isset($movie->imdbid) && $movie->imdbid > 0) {
			$nextMovie = $movie;
			break;
		}
		
		// When we hit the last movie, the next movie should be selected
		if($movie->id == $lastMovieId) {
			$lastMovieId = false;
		}
	}
	
	// Redirect to the update url which will automatically save and go back here
	if($nextMovie) {
		header("Location: ./?go=edit&id=" . $nextMovie->id . "&imdbid=" . $nextMovie->imdbid . "&autoupdate");
		exit();
	} else {
		home();
	}
}
?>