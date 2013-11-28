<?php
require_once($loc . "includes/movie.inc.php");

// Remove a movie
if(isset($movie)) {
	switch($goremove) {
		case "movie":
			$moviedm->remove($movie);
			back();
			break;
		case "cover":
			$movie->removeCover();
			back();
			break;
	}
}
?>