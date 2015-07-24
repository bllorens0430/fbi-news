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
 	$u_id=$_GET['id'];
 	//add space in proper place
 	$id= substr($u_id, 0, 10) . ' ' . substr($u_id, 10);
 	//get case variables from db
 	$sql="SELECT * FROM cases WHERE case_index = '$id'";

 	$result= $db->query($sql);
 	$case= $result->fetch(PDO::FETCH_ASSOC);
 	$date=$date = DateTime::createFromFormat('Y-m-d h:i:s', $case['news_date']);

 	$date=$date->format('m.d.y');
 	$title=strip_tags($case['news_title']);
 	$crime=strip_tags(stripslashes($case['crime']));
 	$classification=strip_tags($case['crime_classification']);
 	$investigation=strip_tags(stripslashes($case['investigation']));
 	$notes=strip_tags(stripslashes($case['notes']));
 	$url=strip_tags($case['news_url']);

  $sql="SELECT * FROM cases_has_technique
  INNER JOIN technique ON technique_technique_index = technique_index
  WHERE cases_case_index = '$id'";
  $techniques= $db->query($sql);
  $techs=[];
  while($row = $techniques->fetch(PDO::FETCH_ASSOC)){
    $name=$row['technique_name'];
    $t_id=$row['technique_index'];
    $t_id=str_replace(' ', '', $t_id);
    $techs[]=[$t_id, $name];
  }

 	$db=null;

 	echo "<a href='$url'><h1>$title</h1></a>
 		<h3>$date</h3>
 		<h2>Crime</h2>
 		<p>$crime</p>
 		<p><span style='font-weight:bold'>Classification:</span> $classification</p>
 		<h2>Investigation</h2>
 		<p>$investigation</p>";
 	if($notes!=''){
 		echo"<h3>Notes</h3>
 			<p>$notes</p>";
 	}
 	else{
 		echo"<h3>Notes</h3>
 			<p>No notes.</p>";
 	}

  if(!empty($techs)){
    echo "<h2>Techniques in Case</h2>";
          foreach ($techs as $tech) {
            echo "<h3><a href='show_technique.php?id=$tech[0]'>$tech[1]</a></h3>";
          }
  }
 	if(isset($_SESSION['user'])){
    echo"<a href='case/update.php?case_index=$u_id'>Edit</a>";
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

