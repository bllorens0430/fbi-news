<?php

require 'session.php';
require 'common.php';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
 <?php include 'header.php' ?>
 <div id="content">
 	<?php
 	//get id from passed url
 	$u_id=$_GET['id'];
 	//add space in proper place
 	$id= substr($u_id, 0, 10) . ' ' . substr($u_id, 10);
 	//get case variables from db
 	$sql="SELECT * FROM technique WHERE technique_index = :id";

 	$sql= $db->prepare($sql);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);
  if ($sql->execute()) {

   	$techni= $sql->fetch(PDO::FETCH_ASSOC);

   	$title=strip_tags($techni['technique_name']);
   	$cat=strip_tags($techni['technique_category']);
   	$details=strip_tags($techni['technique_details']);
   	$notes=strip_tags($techni['notes']);
   	$url=strip_tags($techni['technique_url']);
   	$db=null;

   	echo "<a href='$url'><h1>$title</h1></a>
   		<h2>Details</h2>
   		<p>$details</p>
   		<p><span style='font-weight:bold'>Category:</span> $cat</p>";
   	if($notes!=''){
   		echo"<h3>Notes</h3>
   			<p>$notes</p>";
   	}
   	else{
   		echo"<h3>Notes</h3>
   			<p>No notes.</p>";
   	}
   	echo"<a href='technique/update_tech.php?tech_index=$u_id'>Edit</a>";
   }
?>
 </div>
 <?php include 'footer.php' ?>
</div>
<script src="js/hilightservice.js" type="text/javascript"></script>
</body>
</html>

