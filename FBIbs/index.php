<?php
  // "require" is identical to include except upon failure
  // it will also produce a fatal E_COMPILE_ERROR level error.
  // In other words, it will halt the script whereas
  // include only emits a warning (E_WARNING) which allows the script to continue.
  require("session.php"); // start or resume a session

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
    <link href="../bootstrap-3.3.5-dist/css/cover.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<title>HCISec Crime Database</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
</head>
<body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <img class="lock" alt="lock" src="../FBIbs/img/lock.png" >
              <h3 class="masthead-brand active"><a href="index.php">Human Computer Interaction Security Initiative</a></h3>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">FBI News Cyber Crime Database</h1>
            <h3 class="text-warning">Warning</h3>
            <p class="lead">
              The information on this website could be used to breach systems with security holes. Any such attempt is prosecutable and can lead to severe punishment in a court of law. Please use this site responsibly.
            </p>
            <p class="lead">
              <a href="service.php" class="btn btn-lg btn-default">Get Started</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p class="text-muted"><a href="mailto:xinwenfu@gmail.com">Contact</a> | &copy; 2015 <a href="http://www.cs.uml.edu/~xinwenfu/">Xinwen Fu</a> | James Palmer | Brea Llorens<a rel="license" href="http://creativecommons.org/licenses/by/3.0/"></a></p>            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
