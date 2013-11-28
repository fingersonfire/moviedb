<?php
/**
 * Some important variables for other users to work with in code or templates:
 * - 'loggedin' is true when the user is logged in
 * - 'guestview' is true when guests can view movies
 * - 'User' is the logged in user and its information
 */
// Datamanagers
require_once($loc . "/lib/db/Users.class.php");
$userdm = new Users($settings["db"]);

// See if a user is logged in
if(isset($_SESSION["User"])) {
	$User = $_SESSION["User"];
	if(is_string($User)) {
		$User = unserialize($_SESSION["User"]);
	}
	if($User && isset($User->id)) {
		$User = $userdm->get($User->id);
		// If this user exists in the database, he/she is logged in
		if($User) {
			$Website->assign("User", $User);
		}
		// Otherwise log this user out
		else {
			logOut();
		}
	}
}

// Login
if(!isset($User) && isset($_POST["username"]) && isset($_POST["password"])) {
	$User = $userdm->getByName($_POST["username"]);
	// Correct information?
	if($User && $User->password == md5($_POST["password"])) {
		$User->lastlogin = date("Y-m-d H:i:s");
		$userdm->save($User);
		$_SESSION["User"] = serialize($User);
		
		// Logged in, go back to the ref page or back
		if(isset($_GET["ref"]) && strlen(trim($_GET["ref"])) > 0) {
			header("Location: " . $_GET["ref"]);
			exit();
		} else {
			back();
		}
	}
	// Wrong information
	else {
		unset($User);
		$Website->assign("login_error", true);
	}
}

// Logout
if(isset($_GET["logout"])) {
	logOut();
}

/**
 * Determine if someone is logged in
 */
$loggedin = isset($User);
$Website->assign("loggedin", $loggedin);

/**
 * Determine if guests can view the movies
 */
$guestview = $settings["user"]["guestview"];
$Website->assign("guestview", $guestview);

// Change password
if(isset($_POST["update"]) && $_POST["update"] == 1 && isset($_POST["password"])) {
	// Empty password is not allowed	
	if(isset($User) && trim($_POST["password"]) != "") {
		$User->password = md5($_POST["password"]);
		$userdm->save($User);
	}
}

// Log out
function logOut() {
	// Log out
	unset($_SESSION["User"]);
	unset($User);
	// Go back
	back();
}
?>