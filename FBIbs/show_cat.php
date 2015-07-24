<?php

require 'session.php';
require 'common.php';

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
 <?php include 'header.php' ?>
 <div id="content">
 	<?php
 	//get id from passed url
 	$id=$_GET['id'];
 	$sql="SELECT * FROM crime_category WHERE cat_number = :id";
  $sql=$db->prepare($sql);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);

if($sql->execute()){
 	$cat= $sql->fetch(PDO::FETCH_ASSOC);

 	$title=strip_tags($cat['cat_name']);
 	$title=str_replace('?', '', $title);
    $title=str_replace('*', '', $title);

 	$exp=strip_tags(stripslashes($cat['cat_explanation']));
 	$classification=strip_tags(stripslashes($cat['crime_classification']));
 	$notes=strip_tags(stripslashes($cat['notes']));
 	$db=null;

 	echo "<h1>$title</h1>
 		<h2>Explanation</h2>
 		<p>$exp</p>
 		<p><span style='font-weight:bold'>Classification:</span> $classification</p>";
 	if($notes!=''){
 		echo"<h3>Notes</h3>
 			<p>$notes</p>";
 	}
 	else{
 		echo"<h3>Notes</h3>
 			<p>No notes.</p>";
 	}
  if(isset($_SESSION['user'])){
 	  echo"<a href='classification/update_cat.php?cat_number=$id'>Edit</a>";
 }
}
 	?>
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

