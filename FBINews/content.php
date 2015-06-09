<?php
  // session_start — Start new or resume existing session
  // To use cookie-based sessions, 
  // session_start() must be called before outputing anything to the browser. 
  require("session.php");
  //require("common.php");
  require("check.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cyber Crime and Investigation System</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
  <div id="banner">
    <h1>Xinwen Fu</h1>
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li><a target="_blank" href="http://www.cs.uml.edu/~xinwenfu/">HOMEPAGE</a></li>
      <li id="active"><a href="index.php">LOGIN</a></li>
      <li><a href="content.php" id="current">SYSTEM</a></li>
      <li><a href="resources.html">RESOURCES</a></li>
      <li><a href="service.html">SERVICE</a></li>
      <li><a href="contact.html">CONTACT</a></li>
    </ul>
  </div>
  <div id="sidebar">
<h3>Cyber Crime and Investigation Classification System</h3>
    
  </div>
  <div id="content">
      <p><img class="noborder" src="img/flower.png" width='25'><a href="case/view.php"><h3>Add, Edit and Delete Cases</h3></a></p>
      <p><img class="noborder" src="img/flower.png" width='25'><a href="classification/index.php"><h3>Add, Edit and Delete Categories</h3></a></p>
      <p><img class="noborder" src="img/flower.png" width='25'><a href="technique/index.php"><h3>Add and Edit Attack and Defense Techniques</h3></a></p>
      <p><img class="noborder" src="img/flower.png" width='25'><a href="edit_account.php"><h3>Edit Account</h3></a></p>
      <p><img class="noborder" src="img/flower.png" width='25'><a href="notes.php"><h3>Check Assignment</h3></a></p>

	<?php 
        //only root to perform admin work
        if (strcmp($_SESSION['user']['username'], 'root')==0) {
          echo "<p><img class='noborder' src='img/flower.png' width='25'><a href='admin/admin.php'><h3>Admin</h3></a></p>";
        }
    ?>    

      <p><img class="noborder" src="img/flower.png" width='25'><a href="notes/index.php"><h3>Notes</h3></a></p>

<form action="logout.php">
  <input type="submit" value="Logout" class="styled-button-1">
</form>

  </div>
  <div id="container-foot">
    <div id="footer">
      <p><a href="http://www.cs.uml.edu/~xinwenfu/">homepage</a> | <a href="mailto:xinwenfu@gmail.com">contact</a> | &copy; 2015 Xinwen Fu<a rel="license" href="http://creativecommons.org/licenses/by/3.0/"></a></p>
    </div>
  </div>
</div>
</body>
</html>
