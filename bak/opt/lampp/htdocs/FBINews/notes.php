  <?php
  
  // when we come to this php, it is root changing accounts.
	  // First we execute our common code to connection to the database and start the session
	  require("common.php");
 
	  // At the top of the page we check to see whether the user is logged in or not
	  if(empty($_SESSION['user']))
	  {
		  // If they are not, we redirect them to the login page.
		  header("Location: view.php");
		  
		  // Remember that this die statement is absolutely critical.  Without it,
		  // people can view your members-only content without logging in.
		  die("Redirecting to view.php");
	  }
	  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View News</title>
</head>

<body>
<table>
<tr>
<td>
<form action="view.php">
  <input type="submit" value="Back to News">
</form>
</td>
<td>
 <form action="logout.php">
  <input type="submit" value="Logout">
</form>
</td>
</tr>
</table>
<table border="1">
  <?php
  //include("classification/dbo.php");
  
  $sql="SELECT notes FROM users WHERE username='".$_SESSION['user']['username']."'";
          
  foreach ($db->query($sql) as $test)
  {
		echo $test['notes'];
  }
  $db=null;
  ?>
</table>

</body>
</html>

