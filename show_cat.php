<?php

require 'session.php';
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
 	$sql="SELECT * FROM crime_category WHERE cat_number = :id";
  $sql=$db->prepare($sql);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);

if($sql->execute()){
 	$cat= $sql->fetch(PDO::FETCH_ASSOC);

 	$title=strip_tags($cat['cat_name']);
 	$title=str_replace('?', '', $title);
    $title=str_replace('*', '', $title);

 	$exp=strip_tags($cat['cat_explanation']);
 	$classification=strip_tags(stripslashes($cat['crime_classification']));
 	$notes=strip_tags($cat['notes']);
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
}
 	?>
 </div>
 <?php include 'footer.php' ?>
</div>
</body>
</html>
  <script src="js/hilightservice.js" type="text/javascript"></script>
