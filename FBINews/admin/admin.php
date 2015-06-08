<?php
  // "require" is identical to include except upon failure 
  // it will also produce a fatal E_COMPILE_ERROR level error. 
  // In other words, it will halt the script whereas 
  // include only emits a warning (E_WARNING) which allows the script to continue. 
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database
  
  if (isset($_SESSION)) {
	  // if it is not root, the user is not allowed to perform admin tasks
	  if (strcmp($_SESSION['user']['username'], 'root')!=0) {
		header("Location: ../content.php");
		die("Redirecting to: ../content.php");
	  }
  }	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>

<body>
  <p>Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>!</p>
  <p><a href="memberlist.php">Memberlist</a></p>
  <p><a href="register.php">Register Account</a></p>

<table>
<tr>
<td>
<form action="../content.php">
  <input type="submit" value="Back">
</form>
</td>
<td>
   <form action="../logout.php">
  <input type="submit" value="Logout">
</form>
</td>
</tr>
</table>
</body>
</html> 