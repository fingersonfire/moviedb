<?php
/**
 * This is the config file. Here you can adjust the site by changing the values below.
 */
$settings = array();

/**
 * Set the languages that are available for the user.
 */
$settings["languages"] = array("English" => "en_US", "French" => "fr_FR", "Nederlands" => "nl_NL");
$settings["defaultlanguage"] = "en_US";

/**
* Change your language and timezone here if required.
*/
setlocale(LC_ALL, $settings["defaultlanguage"]);
date_default_timezone_set('CET');

/**
 * The error level of PHP. Changing this is NOT needed.
 */
error_reporting(E_ALL);

/**
 * Development mode. If you want to develop your own template, get extra debug info when development is set to true.
 */
$settings["development"] = false;

/**
 * The location of php4dvd on your domain. This property sets itself automatically, but if it fails,
 * you can overwrite it manuall. If you run php4dvd on www.mydomain.com, leave this property empty.
 * If you run php4dvd on www.mydomain.com/php4dvd/, please fill out 'php4dvd'.
 */
$baseurl = $_SERVER["REQUEST_URI"];
$baseurl = preg_replace("/^\//", "", $baseurl);
$baseurl = preg_replace("/\?.*/", "", $baseurl);
$baseurl = preg_replace("/\/install\/?/i", "", $baseurl);
$settings["url"]["base"] = $baseurl;

/**
 * The database settings.
 * Fill in the hostname of the databse, the databse name and the username and password to connect. 
 */
$settings["db"] = array();
$settings["db"]["host"] = "localhost";
$settings["db"]["port"] = 3306;
$settings["db"]["name"] = "php4dvd";
$settings["db"]["user"] = "root";
$settings["db"]["pass"] = "";
$settings["db"]["utf8"] = true;

/**
 * The location of the images (movie image and cover)
 */
$settings["photo"]["movies"] = "./movies/";
$settings["photo"]["covers"] = $settings["photo"]["movies"]."covers/";

/**
 * Thumbnails are made of the covers you upload. These are resized to a maximum width and height.
 */
$settings["photo"]["tn_maxwidth"] = 200;
$settings["photo"]["tn_maxheight"] = 800;

/**
 * Can guest visitors view your movies? If you only want users with a login to view your movies, set this to false.
 */
$settings["user"]["guestview"] = false;

/**
 * Smarty settings. 
 * The directory of the template engine Smarty. Default values will do fine.
 */
if(!isset($template_name))
	$template_name = "php4dvd";

$settings["smarty"]						= array();
$settings["smarty"]["template_dir"]		= "tpl/";
$settings["smarty"]["template"]			= $template_name . "/";
$settings["smarty"]["compile_dir"]		= "compiled/";
$settings["smarty"]["debug"]			= $settings["development"];
$settings["smarty"]["development"]		= $settings["development"];
?>