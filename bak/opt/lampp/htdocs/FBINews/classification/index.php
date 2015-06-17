<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

require("../check.php");
		
if(isset($_POST['Add']))
{
	$varCrimeClassification = $_POST['crime_classification'];
	$varCatName = $_POST['cat_name'];
	$varCatExplanation = $_POST['cat_explanation'];
	$varNotes=$_POST['notes'];
	$errorMessage = "";
	
//	require("dbo.php");	  
	
	$sql = "INSERT INTO crime_category 
	(crime_classification, cat_name, cat_explanation, notes) 
	VALUES (:crime_classification, :cat_name, :cat_explanation, :notes)";
	  
	$array_param=array(':crime_classification'=>addslashes($varCrimeClassification), 
	':cat_name'=>addslashes($varCatName),
	':notes'=>addslashes($varNotes),
	':cat_explanation'=>addslashes($varCatExplanation));
	  
	$sth = $db->prepare($sql);
	$sth->execute($array_param);
//	$dbh=null;  
}

if(isset($_POST['Update']))
{	
  $varCatNumber = $_POST['cat_number'];
  $varCrimeClassification = $_POST['crime_classification'];
  $varCatName = $_POST['cat_name'];
  $varCatExplanation = $_POST['cat_explanation'];
  $varNotes=$_POST['notes'];
  $errorMessage = "";
	
  $sql = "UPDATE crime_category SET crime_classification=:crime_classification, cat_name=:cat_name,
  cat_explanation=:cat_explanation,
  notes=:notes
  WHERE cat_number=:cat_number";

  $array_param=array(':cat_name'=>addslashes($varCatName), 
  ':crime_classification'=>intval(addslashes($varCrimeClassification)), 
  ':cat_explanation'=>addslashes($varCatExplanation),
  ':notes'=>addslashes($varNotes),
  ':cat_number' =>intval(addslashes($varCatNumber)));
 
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
</head>

<body>

<script type="text/javascript">
    function DeleteOrNot () {
    	     return confirm("Delete?");
        // return true or false, depending on whether you want to allow the `href` property to follow through or not
    }
</script>

<table>
<tr>
<td>
<form action="add_cat.php">
  <input type="submit" value="Add">
</form>
</td>
<td>
<form action="../view.php">
  <input type="submit" value="Back to News">
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
  
  $sql="SELECT * FROM crime_category ORDER BY crime_classification";
  
  echo "<tr align='left'>";
  echo"<td><font color='black'> <b>ID</b> </font></td>";
      echo"<td><font color='black'> <b>Crime Classification</b> </font></td>";
      echo"<td><font color='black'> <b>Category Name</b> </font></td>";
      echo "</tr>";

  foreach ($db->query($sql) as $test)
  {
	  $id=$test['cat_number'];
  
      echo "<tr align='left'>";	
      echo"<td><font color='black'>" .$id."</font></td>";
      echo"<td><font color='black'>" . $test['crime_classification'] . "</font></td>";
      echo"<td><font color='black'>" . $test['cat_name'] . "</font></td>";
      echo"<td> <a href ='update_cat.php?cat_number=$id'>Edit</a>";
      echo"<td> <a href ='del_cat.php?cat_number=$id' onclick='return DeleteOrNot();'><center>Delete</center></a>";
//      echo "<td> <form onsubmit=' if (confirm(\" Delete? \")) {window.location.href=\" del_cat.php?cat_number=$id \";}; '><input type='submit' value='Delete'> </form>   </td>";
                          
      echo "</tr>";
  }
  $db=null;
  ?>
</table>
<img src="2010_IC3Report_ComplaintCategoties.png" width="100%"> 
</body>
</html>

