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
 	$sql="SELECT * FROM technique WHERE technique_index = '$id'";
 	
 	$result= $db->query($sql);
 	$techni= $result->fetch(PDO::FETCH_ASSOC);

 	$title=htmlspecialchars($techni['technique_name'], ENT_QUOTES, 'UTF-8');
 	$cat=htmlspecialchars($techni['technique_category'], ENT_QUOTES, 'UTF-8');
 	$details=htmlspecialchars($techni['technique_details'], ENT_QUOTES, 'UTF-8');
 	$notes=htmlspecialchars($techni['notes'], ENT_QUOTES, 'UTF-8');
 	$url=htmlspecialchars($techni['technique_url'], ENT_QUOTES, 'UTF-8');
 	$db=null;

 	echo "<a href='$url'><h1>$title</h1></a>
 		<h2>Details</h2>
 		<p>$detials</p>
 		<p><span style='font-weight:bold'>Category:</span> $cat</p>";
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