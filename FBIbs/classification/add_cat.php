<?php
require("../session.php"); // start or resume a session
require("../dotcheck.php"); // check if there is a session ongoing
require("../common.php"); // connect to the database

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
    <link rel="icon" href="../favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../bootstrap-3.3.5-dist/css/hcisec.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../bootstrap-3.3.5-dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<title>Add Category</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
</head>

<body>
  <div class='container'>
    <?php include '../header2.php' ?>
    <div id='content'>
<form id="crime_cat" name="Crime Category" method="post" action="index.php">
  <p>
    Crime classification:
    <input name="crime_classification" type="text" id="crime_classification" size="25" />
    Category Name:
    <input name="cat_name" type="text" id="cat_name" size="48" />
</p>
  <p>Category Explanation</p>
  <p>
    <textarea name="cat_explanation" id="cat_explanation" cols="120" rows="15"></textarea>
  </p>
  <p>Notes</p>
  <p>
    <textarea name="notes" id="notes" cols="120" rows="15"></textarea>
  </p>
    <input type="submit" name="Add" value="Add" />
  </form>
 <form action="index.php">
  <input type="submit" value="Cancel">
</form>
</div>
</div>
<?php include '../footer.php' ?>

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
