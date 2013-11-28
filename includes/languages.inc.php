<?php
// Get main language
$language = $settings["defaultlanguage"];

// Does anyone try to specify a specific language
if(isset($_GET["lang"])) {
	if(existsLanguage($_GET["lang"])) {
		setcookie("lang", $_GET["lang"], time()+(365 * 24 * 60 * 60), "/", "");
	}
	back();
}
// Zoek of de gebruiker een voorkeurstaal heeft
else if(isset($_COOKIE["lang"])) {
	if(existsLanguage($_COOKIE["lang"]))
		$language = $_COOKIE["lang"];
}

// Check language
if(!existsLanguage($language))
	$language = $settings["defaultlanguage"];

// Load language
require_once($loc . "lang/" . $language . ".inc.php");
$Website->assign("language", $language);

// Load available languages
$languages = array();
if(is_array($settings["languages"])) {
	foreach($settings["languages"] as $lang=>$code) {
		if(existsLanguage($code)) {
			$languages[$lang] = $code;
		}
	}
}
$Website->assign("languages", $languages);

/**
 * Check if this language exists.
 * @param $lang
 * @return true if the language file exists on disk, otherwise false
 */
function existsLanguage($lang) {
	global $loc;
	return file_exists($loc . "lang/" . $lang . ".inc.php");
}
?>