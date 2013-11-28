<?php
/**
 * Some important variables for other users to work with in code or templates:
 * - 'users' are all users
 */
// Datamanagers
require_once($loc."/lib/db/Users.class.php");
$userdm = new Users($settings["db"]);

// Get all users if the user is allowed to
if($loggedin || $User->isAdmin()) {
	$users = $userdm->all();
	$Website->assign("users", $users);
}

// Add a new user
if($loggedin && $User->isAdmin() && isset($_POST["username"])) {
	$newuser = new User();
	$newuser = fillObject($newuser, $_POST, array(), array('password2', 'submit'));
	$newuser->password = md5($newuser->password);
		
	// No other user with this username?
	if($userdm->existsUser($newuser->username, $newuser->email)) {
		$Website->assign("username_error", DUPLICATE_USER_NAME_OR_EMAIL);
		$Website->assign("newuser", $newuser);
	} else {
		$userdm->save($newuser);
		reload();
	}
}
?>