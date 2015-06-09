<?php  
require("session.php"); // start or resume a session
require("check.php"); // check if there is a session ongoing
require("common.php"); // connect to the database
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
<title>View News</title>
</head>

<body>
  <div id='container'>
    <?php include 'header.php' ?>
  <div id='content'>
<table>
<tr>
<td>
<form action="content.php">
  <input type="submit" value="Back">
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
//		echo htmlspecialchars($test['notes'], ENT_QUOTES, 'UTF-8');
		// Since the assignment is given by admin, we assume admin is benign 
		// will not perform XSS 
		echo $test['notes'];
  }
  $db=null;
  ?>
</table>
</div>
<?php include 'footer.php' ?>
</div>
</body>
</html>

