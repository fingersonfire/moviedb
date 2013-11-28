<?php
/**
 * Some important variables for other users to work with in code or templates:
 * - 'movies' are all movies
 */
require_once($loc . "includes/movie.inc.php");

// The movie categories
$moviecategories = $moviedm->getCategories();
$Website->assign("categories", $moviecategories);

// The movie formats
$movieformats = $moviedm->getFormats();
$Website->assign("movieformats", $movieformats);

// The movie sort columns
$sortoptions = array('name', 'year', 'rating', 'format', 'seen', 'own', 'added', 'loaned');
$allsortoptions = array();
foreach($sortoptions as $so) {
	$allsortoptions[] = $so . " " . "asc";
	$allsortoptions[] = $so . " " . "desc";
}
$Website->assign("sortoptions", $allsortoptions);

// Number of results
$resultsperpage = array(4, 8, 12, 16, 20, 24, 28, 32);
$Website->assign("resultsperpage", $resultsperpage);

// If the user logged in or when a guest user is allowed to view movies, show them
if($loggedin || $guestview) {
	isset($_GET["q"]) 	? $q = $_GET["q"] 				: $q = "";
	isset($_GET["s"]) 	? $sort = $_GET["s"] 			: $sort = false;
	isset($_GET["c"])	? $category = $_GET["c"]		: $category = "";
	isset($_GET["n"]) 	? $amount = (int)$_GET["n"] 	: $amount = 0;
	isset($_GET["p"]) 	? $page = (int)$_GET["p"] 		: $page = 0;
		
	// Search the database for one more movie
	$movies = $moviedm->search($q, $sort, $category, $page * $amount, $amount);
		
	// If there are no movies found, reload
	while($page > 0 && count($movies) == 0) {
		$page--;
		$movies = $moviedm->search($q, $sort, $category, $page * $amount, $amount);
	}
	$Website->assign("movies", $movies);
		
	// Get the total amount of rows
	$totalmovies = $moviedm->getFoundRows();
	$Website->assign("totalmovies", $totalmovies);
	$pages = $amount > 0 ? ceil($totalmovies/$amount) : $pages = 1;
		
	// Navigation
	$Website->assign("pages", $pages);
	$Website->assign("next", $page + 1 < $pages);
	$Website->assign("previous", $page > 0);
	$Website->assign("amount", $amount);
		
	$page++;
	$Website->assign("page", $page);
		
	// The amount of pages shown (N before current and N after current)
	$N = 8;
		
	// Define the start value of the pages
	// Start at $page-N (or 1)
	$startAt = $page - $N;
	if($startAt < 1)
	$startAt = 1;
	// Stop at $startAt+2*$N (or $pages)
	$stopAt = $startAt+2*$N;
	if($stopAt > $pages) {
		$stopAt = $pages;
		// Recalculate $stopAt-2*$N
		$startAt = $stopAt-2*$N;
		if($startAt < 1)
		$startAt = 1;
			
	}
	$Website->assign("startAt", $startAt);
	$Website->assign("stopAt", $stopAt);
		
	// Statistics
	$numbertypes = array();
	foreach($movieformats as $format) {
		$numbertypes[] = array($format, 0);
	}
	$numberowned = 0;
	$numberseen = 0;
	foreach($movies as $m) {
		for($i = 0; $i < count($numbertypes); $i++) {
			if($numbertypes[$i][0] == $m->format)
			$numbertypes[$i][1] += 1;
		}
		if($m->own)
		$numberowned++;
		if($m->seen)
		$numberseen++;
	}
	$Website->assign("numbertypes", $numbertypes);
	$Website->assign("numberowned", $numberowned);
	$Website->assign("numberseen", $numberseen);
}