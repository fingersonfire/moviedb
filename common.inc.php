<?php
/**
 * Common functionality needed by the site.
 *
 * Do not change this file unless you know exactly what you are doing!
 */
// Compression
ob_start("ob_gzhandler");

// UTF8 header
header('Content-type: text/html; charset=utf-8');

// Start session
session_start();

// Local path
$loc = dirname(__FILE__) . "/";

// Correct PHP version check
if(phpversion() < '5.3') {
	echo "<h1>Error</h1><p>php4dvd requires at least PHP 5.3. You are running PHP " . phpversion() . ". Please upgrade.</p>";
	exit();
}

// Load the default config file
if(!file_exists($loc . "config/config.default.php")) {
	echo "<h1>Error</h1>The file <tt>config/config.default.php</tt> is missing.";
	exit();
}
require_once($loc . "config/config.default.php");
$default_settings = $settings;

// Load the config file
if(file_exists($loc . "config/config.php")) {
	require_once($loc . "config/config.php");
	$custom_settings = $settings;

	// When installing, reset all to default settings, except the database
	if(isset($installer) && $installer) {
		$settings = $default_settings;
		foreach($custom_settings["db"] as $key=>$value) {
			$settings["db"][$key] = $value;
		}
		$settings["user"] = $custom_settings["user"];
	}
}

// Include util functions
require_once($loc . "lib/util.inc.php");

// Load smarty template parser
require_once($loc . "lib/Website.class.php");
$Website = new Website($settings);

// Base url
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
$Website->assign("baseurl", $baseurl);

// Current URL
$currentUrl = $baseurl . $_SERVER["REQUEST_URI"];
$Website->assign("currentUrl", $currentUrl);

// Webroot
$basepath = $settings["url"]["base"];
if(strlen($basepath) > 0 && !preg_match("/\/$/", $basepath)) {
	$basepath .= "/";
}
$webroot = $baseurl . "/" . $basepath;
$Website->assign("webroot", $webroot);

// Template directory
$tpl = $settings["smarty"]["template"];
$tpl_dir = $settings["smarty"]["template_dir"];
$tpl_include = $webroot . $tpl_dir . $tpl;
$Website->assign("tpl_include", $tpl_include);

// Version
require_once($loc . "config/version.default.inc.php");
$Website->assign("newversion", NEW_VERSION);
if(file_exists($loc . "config/version.inc.php")) {
	require_once($loc . "config/version.inc.php");
	$Website->assign("version", VERSION);
} else {
	define('VERSION', 0);
}
?>
