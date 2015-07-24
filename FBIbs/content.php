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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-3.3.5-dist/css/hcisec.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<title>Welcome</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
</head>
<body>
<div class='container'>
 <?php include 'header.php'; ?>
  <div id="sidebar">
<h3>Cyber Crime and Investigation Classification System</h3>

  </div>
  <div id="content">
      <h3><a href="case/index.php">Add, Edit and Delete Cases</a></h3>
      <h3><a href="classification/index.php">Add, Edit and Delete Categories</a></h3>
      <h3><a href="technique/index.php">Add and Edit Attack and Defense Techniques</a></h3>
	<?php
        //only root to perform admin work
        if (strcmp($_SESSION['user']['username'], 'root')==0) {
          echo "<h3><a href='admin/admin.php'>Admin</a></h3>";
        }
    ?>



<form action="logout.php">
  <input type="submit" value="Logout" class="styled-button-1">
</form>

  </div>
  </div>
 <?php include 'footer.php' ?>

<script src="js/hilight.js" type="text/javascript"></script>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>

