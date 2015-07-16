<?php
  // session_start — Start new or resume existing session
  // To use cookie-based sessions,
  // session_start() must be called before outputing anything to the browser.
  require("session.php");
  //require("common.php");
  require("check.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cyber Crime and Investigation System</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
 <?php include 'header.php'; ?>
  <div id="sidebar">
<h3>Cyber Crime and Investigation Classification System</h3>

  </div>
  <div id="content">
      <h3><img alt='' class="noborder" src="img/flower.png" width='25'><a href="case/view.php">Add, Edit and Delete Cases</a></h3>
      <h3><img alt='' class="noborder" src="img/flower.png" width='25'><a href="classification/index.php">Add, Edit and Delete Categories</a></h3>
      <h3><img alt='' class="noborder" src="img/flower.png" width='25'><a href="technique/index.php">Add and Edit Attack and Defense Techniques</a></h3>
	<?php
        //only root to perform admin work
        if (strcmp($_SESSION['user']['username'], 'root')==0) {
          echo "<img alt='' class='noborder' src='img/flower.png' width='25'><h3><a href='admin/admin.php'>Admin</a></h3>";
        }
    ?>

      <h3><img alt='' class="noborder" src="img/flower.png" width='25'><a href="notes/index.php">Notes</a></h3>

<form action="logout.php">
  <input type="submit" value="Logout" class="styled-button-1">
</form>

  </div>
 <?php include 'footer.php' ?>
</div>
<script src="js/hilight.js" type="text/javascript"></script>
</body>
</html>

