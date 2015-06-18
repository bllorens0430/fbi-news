<?php

require 'session.php';
require 'check.php';
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
 	$sql="SELECT * FROM crime_category WHERE cat_number = '$id'";
 	
 	$result= $db->query($sql);
 	$cat= $result->fetch(PDO::FETCH_ASSOC);

 	$title=htmlspecialchars($cat['cat_name'], ENT_QUOTES, 'UTF-8');
 	$title=str_replace('?', '', $title);
    $title=str_replace('&lt;b&gt;', '', $title);
    $title=str_replace('&lt;/b&gt;', '', $title);
    $title=str_replace('*', '', $title);

 	$exp=htmlspecialchars($cat['cat_explanation'], ENT_QUOTES, 'UTF-8');
 	$classification=htmlspecialchars(stripslashes($cat['crime_classification']), ENT_QUOTES, 'UTF-8');
 	$notes=htmlspecialchars($cat['notes'], ENT_QUOTES, 'UTF-8');
 	$db=null;

 	echo "<h1>$title</h1>
 		<h2>Explanation</h2>
 		<p>$exp</p>
 		<p><span style='font-weight:bold'>Classification:</span> $classification</p>";
 	if($notes!=''){
 		echo"<h3>Notes</h2>
 			<p>$notes</p>";
 	}
 	else{
 		echo"<h3>Notes</h3>
 			<p>No notes.</p>";
 	}
 	echo"<a href='classification/update_cat.php?cat_number=$id'>Edit</a>";
 	?>
 </div>
 <?php include 'footer.php' ?>
</div>
</body>
</html>
  <script src="js/hilightservice.js" type="text/javascript"></script>