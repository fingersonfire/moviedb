<?php
require_once($loc . "includes/movie.inc.php");

// If the user logged in, export the movies
if($loggedin || $guestview) {
	// Retrieve the movies
	$movies = $moviedm->search("");
	
	// Output CSV file
	$SEPARATOR = utf8_encode(";");
	$QUOTE = utf8_encode("\"");
	$NEWLINE = utf8_encode("\n");
	
	// Header
	$file = "";
	$file  = "ID".$SEPARATOR;
	$file .= IMDB_NUMBER.$SEPARATOR;
	$file .= TITLE.$SEPARATOR;
	$file .= AKA_TITLES.$SEPARATOR;
	$file .= YEAR.$SEPARATOR;
	$file .= DURATION_MINUTES.$SEPARATOR;
	$file .= RATING.$SEPARATOR;
	$file .= FORMAT.$SEPARATOR;
	$file .= OWN.$SEPARATOR;
	$file .= SEEN.$SEPARATOR;
	$file .= LOANED_OUT_TO.$SEPARATOR;
	$file .= LOANED_OUT_SINCE.$SEPARATOR;
	$file .= TRAILER_URL.$SEPARATOR;
	$file .= PERSONAL_NOTES.$SEPARATOR;
	$file .= TAGLINES.$SEPARATOR;
	$file .= PLOT_OUTLINE.$SEPARATOR;
	$file .= PLOTS.$SEPARATOR;
	$file .= LANGUAGES.$SEPARATOR;
	$file .= SUBTITLES.$SEPARATOR;
	$file .= AUDIO.$SEPARATOR;
	$file .= VIDEO.$SEPARATOR;
	$file .= COUNTRY.$SEPARATOR;
	$file .= GENRES.$SEPARATOR;
	$file .= DIRECTOR.$SEPARATOR;
	$file .= WRITER.$SEPARATOR;
	$file .= PRODUCER.$SEPARATOR;
	$file .= MUSIC.$SEPARATOR;
	$file .= CAST.$NEWLINE;
	
	// Movies
	foreach($movies as $movie) {
		$file .= makeData($movie->id);
		$file .= makeData($movie->imdbid);
		$file .= makeData($movie->name);
		$file .= makeData($movie->aka);
		$file .= makeData($movie->year);
		$file .= makeData($movie->duration);
		$file .= makeData($movie->rating ? $movie->rating : "");
		$file .= makeData($movie->format);
		$file .= makeData($movie->own);
		$file .= makeData($movie->seen);
		$file .= makeData($movie->loanname);
		$file .= makeData($movie->loaned ? $movie->loandate : "");
		$file .= makeData($movie->trailer);
		$file .= makeData($movie->notes);
		$file .= makeData($movie->taglines);
		$file .= makeData($movie->plotoutline);
		$file .= makeData($movie->plots);
		$file .= makeData($movie->languages);
		$file .= makeData($movie->subtitles);
		$file .= makeData($movie->audio);
		$file .= makeData($movie->video);
		$file .= makeData($movie->country);
		$file .= makeData($movie->genres);
		$file .= makeData($movie->director);
		$file .= makeData($movie->writer);
		$file .= makeData($movie->producer);
		$file .= makeData($movie->music);
		$file .= makeData($movie->cast);
		$file .= $NEWLINE;
	}
	$file = utf8_decode($file);
	
	ob_start();
	ob_clean();
	header("Content-Disposition: attachment; filename=\"export.csv\"");
	header("Content-type: application/csv; charset=utf-8");
	header("Pragma: cache");
	header("Cache-Control: public, must-revalidate, max-age=0");
	header("Connection: close");
	header("Expires: ".date("r", time()+60*60));
	header("Last-Modified: ".date("r", time()));
	header("Content-length: ".strlen($file)."\r\n");
	echo $file;	
	ob_flush();
	exit();
}

function makeData($content) {
	global $QUOTE, $SEPARATOR;
	return $QUOTE.utf8_encode(preg_replace("/\r?\n/", ", ", $content)).$QUOTE.$SEPARATOR;
}
?>