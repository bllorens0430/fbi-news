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
<table id='dbtable'>
	<tr>
		<th>Date</th>
		<th>Case</th>
		<th>Classification</th>
	</tr>
  <?php
  
  $sql="SELECT * FROM cases";
   $count='evenrow';       
  foreach ($db->query($sql) as $case)
  {
  	$date = DateTime::createFromFormat('Y-m-d h:i:s', $case['news_date']);
    if ($count=="oddrow") {
      $count="evenrow";
    }
    else{
      $count="oddrow";
    }
      $id = $case['case_index'];
      $id=str_replace(' ', '', $id);
      echo "<tr class='$count' align='center'>";	
      echo"<td><font color='black'>" .$date->format('m.d.y')."</font></td>";
      echo"<td><font color='black'><a href='".htmlspecialchars($test['news_url'], ENT_QUOTES, 'UTF-8')."'>". htmlspecialchars($case['news_title'], ENT_QUOTES, 'UTF-8'). "<a/></font></td>";
      echo"<td><font color='black'>". htmlspecialchars($case['crime_classification'], ENT_QUOTES, 'UTF-8'). "</font></td>";
      echo"<td><a href=show_case.php?id=$id><button href=show_case.php?id=$id>View Case</button></a></td>";
                          
      echo "</tr>";
  }
  $db=null;
  ?>
</table>
</div>
<?php include 'footer.php' ?>
</div>
</body>
</html>