<?php
require_once($loc . "includes/user.inc.php");

// Remove a user
if(isset($user)) {
	// Deleting the admin user is not such a good idea!
	if($user->username != "admin") {
		$userdm->remove($user);
	}
	back();
}
?>