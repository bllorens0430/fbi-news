<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

require("../check.php");

if(isset($_POST['Add']))
{
	$varTechIndex = $_POST['tech_index'];
	$varTechName = $_POST['tech_name'];
	$varTechcat = $_POST['tech_cat'];
	$varTechDetails = $_POST['tech_details'];
	$varTechRefs = $_POST['tech_refs'];
	$varTechNotes = $_POST['tech_notes'];
	$errorMessage = "";
	
	$sql = "INSERT INTO technique (technique_index, technique_name, technique_category, 
	technique_details, technique_url, notes) 
	VALUES (:tech_index, :tech_name, :tech_cat, :tech_details, :tech_refs, :tech_notes)";
	  
	$array_param=array(':tech_index'=>addslashes($varTechIndex), 
	':tech_name'=>addslashes($varTechName),
	':tech_cat'=>intval($varTechcat),
	':tech_details'=>addslashes($varTechDetails),
	':tech_refs'=>addslashes($varTechRefs),
	':tech_notes' =>addslashes($varTechNotes));
	  
	$sth = $db->prepare($sql);
	$sth->execute($array_param);
//	$dbh=null;  
}

if(isset($_POST['Update']))
{	
	$varTechIndex = $_POST['tech_index'];
	$varTechName = $_POST['tech_name'];
	$varTechcat = $_POST['tech_cat'];
	$varTechDetails = $_POST['tech_details'];
	$varTechRefs = $_POST['tech_refs'];
	$varTechNotes = $_POST['tech_notes'];
	$errorMessage = "";
	  
	$sql = "UPDATE technique SET technique_name=:tech_name,
	technique_category=:tech_cat, technique_details=:tech_details, technique_url=:tech_refs, notes=:tech_notes 
	WHERE technique_index=:tech_index";

	$array_param=array(':tech_index'=>addslashes($varTechIndex), 
	':tech_name'=>addslashes($varTechName),
	':tech_cat'=>intval($varTechcat),
	':tech_details'=>addslashes($varTechDetails),
	':tech_refs'=>addslashes($varTechRefs),
	':tech_notes' =>addslashes($varTechNotes));
	
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

<script>
function goBack() {
    window.history.back()
}
</script>

<table>
<tr>
<td>
<form action="add_tech.php">
  <input type="submit" value="Add">
</form>
</td>
<td>
 <button onclick="goBack()">Go Back</button>
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
  
  $sql="SELECT * FROM technique";
          
  foreach ($db->query($sql) as $test)
  {
  
      $id = $test['technique_index'];	
      echo "<tr align='center'>";	
      echo"<td><font color='black'>" .$test['technique_index']."</font></td>";
      echo"<td><font color='black'>". $test['technique_name']. "</font></td>";
      echo"<td><font color='black'>". $test['technique_category']. "</font></td>";
      echo"<td> <a href ='update_tech.php?tech_index=$id'>Edit</a>";
      echo"<td> <a href ='del_tech.php?tech_index=$id' onclick='return DeleteOrNot();'><center>Delete</center></a>";
                          
      echo "</tr>";
  }
  $db=null;
  ?>
</table>

</body>
</html>

