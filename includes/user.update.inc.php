<?php
require_once($loc . "includes/user.inc.php");

// If the user is not logged in or when it is not editing its own account, send the user to the home page
if(!$loggedin || (!$User->isAdmin() && $User->id != $user->id)) {
	home();
} 

// Update the user information
if(isset($user) && isset($_POST["email"])) {
	$exclude = array('username', 'password2', 'submit');
	// Only admins can update permissions when they are not editing themselves
	if(!$User->isAdmin() || $User->id == $user->id) {
		$exclude[] = 'permission';
	}
	// Do not update password when there was no new password entered
	if(!isset($_POST["password"]) || empty($_POST["password"])) {
		$exclude[] = 'password';
	}
	// Update user
	$user = fillObject($user, $_POST, array(), $exclude);
	
	// Update password when a new password was entered
	if(isset($_POST["password"]) && !empty($_POST["password"])) {
		$user->password = md5($user->password);
	}
	
	// Check for duplicate users with the same e-mail address
	$duplicateUsers = $userdm->usersWithEmail($user->email);
	if($duplicateUsers > 1) {
		$Website->assign("username_error", DUPLICATE_USER_NAME_OR_EMAIL);
	} else {
		// Save to the database
		$userdm->save($user);
		
		// Go to user overview (when the user has no permissions, the page will send him back to the home page)
		header("Location: ./?go=users");
		exit();
	}
}
?>