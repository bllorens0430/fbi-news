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
 	$sql="SELECT * FROM cases WHERE case_index = '$id'";

 	$result= $db->query($sql);
 	$case= $result->fetch(PDO::FETCH_ASSOC);
 	$date=$date = DateTime::createFromFormat('Y-m-d h:i:s', $case['news_date']);

 	$date=$date->format('m.d.y');
 	$title=strip_tags($case['news_title']);
 	$crime=strip_tags($case['crime']);
 	$classification=strip_tags($case['crime_classification']);
 	$investigation=strip_tags($case['investigation']);
 	$notes=strip_tags($case['notes']);
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
 	echo"<a href='case/update.php?case_index=$u_id'>Edit</a>";
 	?>

 </div>

 <?php include 'footer.php' ?>
</div>
<script src="js/hilightservice.js" type="text/javascript"></script>
</body>
</html>

