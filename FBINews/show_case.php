<?php

require 'common.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
 <?php include 'header.php' ?>
 <div id="content">
 	<?php
 	//get id from passed url
 	$id=$_GET['id'];
 	//add space in proper place
 	$id= substr($id, 0, 10) . ' ' . substr($id, 10);
 	//get case variables from db
 	$sql="SELECT * FROM cases WHERE case_index = '$id'";
 	
 	$result= $db->query($sql);
 	$case= $result->fetch(PDO::FETCH_ASSOC);
 	$date=$date = DateTime::createFromFormat('Y-m-d h:i:s', $case['news_date']);
 	
 	$date=$date->format('m.d.y');
 	$title=htmlspecialchars($case['news_title'], ENT_QUOTES, 'UTF-8');
 	$crime=htmlspecialchars($case['crime'], ENT_QUOTES, 'UTF-8');
 	$classification=htmlspecialchars($case['crime_classification'], ENT_QUOTES, 'UTF-8');
 	$investigation=htmlspecialchars($case['investigation'], ENT_QUOTES, 'UTF-8');
 	$notes=htmlspecialchars($case['notes'], ENT_QUOTES, 'UTF-8');
 	$url=htmlspecialchars($case['news_url'], ENT_QUOTES, 'UTF-8');
 	$db=null;

 	echo "<a href='$url'><h1>$title</h1></a>
 		<h3>$date</h3>
 		<h2>Crime</h2>
 		<p>$crime</p>
 		<p><span style='font-weight:bold'>Classification:</span> $classification</p>
 		<h2>Investigation</h2>
 		<p>$investigation</p>";
 	if($notes!=''){
 		echo"<h3>Notes</h2>
 			<p>$notes</p>";
 	}
 	else{
 		echo"<h3>Notes</h3>
 			<p>No notes.</p>";
 	}
 	?>
 </div>
 <?php include 'footer.php' ?>
</div>
</body>
</html>
<script src="js/hilightservice.js" type="text/javascript"></script>