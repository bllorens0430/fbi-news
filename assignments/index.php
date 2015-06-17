<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database
  
		  
  if(isset($_POST['Add']))
  {
	  $varCrimeClassification = $_POST['crime_classification'];
	  $varCatName = $_POST['cat_name'];
	  $varCatExplanation = $_POST['cat_explanation'];
	  $errorMessage = "";
	  
	  $sql = "INSERT INTO crime_category (crime_classification, cat_name, cat_explanation) 
	  VALUES (:crime_classification, :cat_name, :cat_explanation)";
		
	  $array_param=array(':crime_classification'=>addslashes($varCrimeClassification), 
	  ':cat_name'=>addslashes($varCatName),
	  ':cat_explanation'=>addslashes($varCatExplanation));
		
	  $sth = $db->prepare($sql);
	  $sth->execute($array_param);
  }
  
  if(isset($_POST['Update']))
  {	
	$varCatNumber = $_POST['cat_number'];
	$varCrimeClassification = $_POST['crime_classification'];
	$varCatName = $_POST['cat_name'];
	$varCatExplanation = $_POST['cat_explanation'];
	$errorMessage = "";
	  
	$sql = "UPDATE crime_category SET crime_classification=:crime_classification, cat_name=:cat_name,
	cat_explanation=:cat_explanation
	WHERE cat_number=:cat_number";
  
	$array_param=array(':cat_name'=>$varCatName, 
	':crime_classification'=>intval($varCrimeClassification), 
	':cat_explanation'=>$varCatExplanation,
	':cat_number' =>intval($varCatNumber));
	
	$sth = $db->prepare($sql);
	$sth->execute($array_param);
  //  $dbh=null;  
  }
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View News</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id='container'>
	<?php include '../header2.php' ?>
	<div id='sidebar'>
		<h2>Assignments</h2>
	</div>
	<div id='content'>
<table>
<tr>
<td>
<form action="add_cat.php">
  <input type="submit" value="Add">
</form>
</td>
<td>
<form action="../content.php">
  <input type="submit" value="News">
</form>
</td>
<td>
 <form action="../logout.php">
  <input type="submit" value="Logout">
</form>
</td>
</tr>
</table>
<table border="1">
  <?php
  //include("dbo.php");
  
  $sql="SELECT * FROM crime_category";
          
  foreach ($db->query($sql) as $test)
  {
	  $id=$test['cat_number'];
  
      echo "<tr align='center'>";	
      echo"<td><font color='black'>" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8')."</font></td>";
      echo"<td><font color='black'>" . htmlspecialchars($test['crime_classification'], ENT_QUOTES, 'UTF-8') . "</font></td>";
      echo"<td><font color='black'>" . htmlspecialchars($test['cat_name'], ENT_QUOTES, 'UTF-8') . "</font></td>";
      echo"<td> <a href ='update_cat.php?cat_number=$id'>Edit</a>";
      echo"<td> <a href ='del_cat.php?cat_number=$id'><center>Delete</center></a>";
                          
      echo "</tr>";
  }
  $db=null;
  ?>
</table>
</div>
<?php include '../footer.php' ?>
</div>
</body>
</html>s
