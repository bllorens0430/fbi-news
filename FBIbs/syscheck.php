<?php
	// At the top of the page we check to see whether the user is logged in or not
	if(empty($_SESSION['user']))
	{
		// If they are not, we redirect them to the login page.
		header("Location: ../login.php");

		// Remember that this die statement is absolutely critical.  Without it,
		// people can view your members-only content without logging in.
		die("Redirecting to login.php");
	}
	elseif (isset($_POST['username'])&&strcmp($_POST['username'], "root")==false) {
		//if the user is not root redirect to valid page
		header("Location: ../content.php");

		die("Please login as sysadmin to view page");
	}

?>
