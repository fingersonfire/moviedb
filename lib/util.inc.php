<?php
/**
 * Check if the user is using an Internet Explorer browser.
 * @return true when the browser is IE, otherwise false
 */
function isIE() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	return preg_match("/msie/i", $agent) && !preg_match("/opera/i", $agent);
}

/**
 * Check if the user is using Internet Explorer 6.
 * @return true when the browser is IE 6, otherwise false
 */
function isIE6() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	
	return preg_match("/msie 6/i", $agent) && !preg_match("/opera/i", $agent);
}

/**
 * Check if the user is using Internet Explorer 7.
 * @return true when the browser is IE 7, otherwise false
 */
function isIE7() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	
	return preg_match("/msie 7/i", $agent) && !preg_match("/opera/i", $agent);
}

/**
 * Check if the user is using Internet Explorer 8.
 * @return true when the browser is IE 8, otherwise false
 */
function isIE8() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	
	return preg_match("/msie 8/i", $agent) && !preg_match("/opera/i", $agent);
}

/**
 * Check if the user is using Internet Explorer 9.
 * @return true when the browser is IE 9, otherwise false
 */
function isIE9() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	
	return preg_match("/msie 9/i", $agent) && !preg_match("/opera/i", $agent);
}

/**
 * Go to the home page.
 * @param unknown_type $add
 */
function home($add = array()) {
	global $webroot;
	$url = setQueryString($webroot, $add);
	header("Location: " . $url);
	exit();
}

/**
 * Reload the current page (when this information is available).
 * @param string $add what to add after the current url? (&reload=true for example)
 */
function reload($add = array()) {
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Mon, 01 Jan 1970 00:00:00 GMT"); 	// Date in the past
	
	if(isset($_SERVER["REQUEST_URI"])) {
		$url = setQueryString($_SERVER["REQUEST_URI"], $add);
		header("Location: " . $url);
	} else {
		header("Location: ./");
	}
	exit();
}

/**
 * Go one page back (when the referral information is available).
 * @param string $add what to add after the current url? (&back=true for example)
 */
function back($add = array()) {
	// Current url
	$protocol = "http";
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
		$potocol = "https";
	}
	if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']) {
		$potocol = "https";
	}
	$baseurl = $protocol . "://" . $_SERVER["HTTP_HOST"];
	if ($_SERVER["SERVER_PORT"] != "80") {
		$baseurl .= ":".$_SERVER["SERVER_PORT"];
	}
	$currentUrl = $baseurl . $_SERVER["REQUEST_URI"];
	
	// Reload the previous page if not the same
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Mon, 01 Jan 1970 00:00:00 GMT"); 	// Date in the past
	if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != $currentUrl) {
		$url = setQueryString($_SERVER["HTTP_REFERER"], $add);
		header("Location: " . $url);
	} else {
		header("Location: ./");
	}
	exit();
}

/**
 * Set the values as querystring values to the url.
 * @param string $url
 * @param array $values
 */
function setQueryString($url, $values) {
	$url = urldecode($url);
	$querystring = "";
	
	// Get url and querystring
	$parts = preg_split("/\?/", $url);
	if(count($parts) == 2) {
		$url = $parts[0];
		$querystring = $parts[1];
	}
	
	// Get querystring parts
	$queryparts = array();
	$qsparts = preg_split("/&/", $querystring);
	foreach($qsparts as $qspart) {
		$keyvalue = preg_split("/=/", $qspart);
		$key = $keyvalue[0];
		$value = count($keyvalue) == 2 ? $keyvalue[1] : false;
		$queryparts[$key] = $value;
	}
	
	// Overwrite querystring
	if(is_array($values)) {
		foreach($values as $key => $value) {
			$queryparts[$key] = $value;
		}
	}
	
	// Reconstruct url
	$valuePairs = array();
	foreach($queryparts as $qp => $v) {
		$valuePairs[] = $v ? urlencode($qp) . "=" . urlencode($v) : urlencode($qp);
	}
	if(!empty($valuePairs) && strlen(trim($valuePairs[0])) > 0) {
		$url .=  "?" . join("&", $valuePairs);
	}
	return $url;
}

/**
 * Find the extention of a filename.
 * @param string $filename
 */
function findExtention($filename) {
	$array = explode(".", $filename);
	$pos = count($array) - 1;
	$extention = $array[$pos];
	return $extention;
}

/**
 * Make a directory recursive.
 * @param string $path
 */
function mkpath($path) {
	$dirs=array();
	$path=preg_replace('/(\/){2,}|(\\\){1,}/','/',$path); //only forward-slash
	$dirs=explode("/",$path);
	$path="";
	foreach ($dirs as $element) {
		$path.=$element."/";
		if(!is_dir($path)) {
			mkdir($path);
		}
	}
}

/**
 * Read the contents of this file.
 * @param string $file
 * @return string
 */
function readFileContent($file) {
	if(file_exists($file)) {
		$handle = fopen($file, "r");
		if($handle) {
			return fread($handle, filesize($file));
		}
	}
	return false;
}

/**
 * Try to translate this text.
 * @param string $text
 * @return the translated text or the original
 */
function translate($text) {
	if(defined($text))
		return constant($text);
	else
		return $text;
}

/**
* Fill this object with the row information.
* @param $obj
* @param $row
* @param include
* @param exclude
*/
function fillObject($obj, $row, $include = array(), $exclude = array()) {
	$inc = array();
	foreach($include as $i)
		$inc[$i] = true;
	$include = $inc;
	$exc = array();
	foreach($exclude as $e)
		$exc[$e] = true;
	$exclude = $exc;
	
	if(isset($row) && $row) {
		foreach($row as $key => $value) {
			$allowed = true;
			if(count($include) > 0 && !isset($include[$key]))
				$allowed = false;
			if(count($exclude) > 0 && isset($exclude[$key])) {
				$allowed = false;
			}
			if($allowed)
				$obj->{$key} = stripslashes($value);
		}
		return $obj;
	}
	return false;
}
?>