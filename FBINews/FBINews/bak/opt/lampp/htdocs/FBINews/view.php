<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

require("check.php");

if(isset($_POST['Add']))
{
	$varNewsIndex = $_POST['news_index'];
	$varNewsTitle = $_POST['news_title'];
	$varNewsUrl = $_POST['news_url'];
	# The DATE type is used for values with a date part but no time part.
	# MySQL retrieves and displays DATE values in 'YYYY-MM-DD' format. 
	# The supported range is '1000-01-01' to '9999-12-31'.
	# The DATETIME type is used for values that contain both date and time parts. 
	# MySQL retrieves and displays DATETIME values in 'YYYY-MM-DD HH:MM:SS' format. 
	# The supported range is '1000-01-01 00:00:00' to '9999-12-31 23:59:59'. 
	$varNewsDate = $_POST['news_date'];
	$varCrime = $_POST['crime'];
	$varCrimeClassification = $_POST['crime_classification'];
	$varInvestigation = $_POST['investigation'];
	$varNotes = $_POST['notes'];
	$errorMessage = "";
	
//	require("dbo.php");	  
	
	$sql = "INSERT INTO cases (case_index, news_date, news_title, news_url, 
	crime, crime_classification, investigation, notes) 
	VALUES (:case_index, :news_date, :news_title, :news_url, :crime, 
	:crime_classification, :investigation, :notes)";
	  
	$date = DateTime::createFromFormat('m.d.y', addslashes($varNewsDate));
	$array_param=array(':case_index'=>addslashes($varNewsIndex), 
	':news_date'=>$date->format('Y-m-d'),
	':news_title'=>addslashes($varNewsTitle),
	':news_url'=>addslashes($varNewsUrl),
	':crime' =>addslashes($varCrime),
	':crime_classification' => intval($varCrimeClassification),
	':investigation'=>addslashes($varInvestigation),
	':notes'=>addslashes($varNotes));
	  
	$sth = $db->prepare($sql);
	$sth->execute($array_param);
//	$dbh=null;  
}

if(isset($_POST['Update']))
{	
  $varNewsIndex = $_POST['news_index'];
  $varNewsTitle = $_POST['news_title'];
  $varNewsUrl = $_POST['news_url'];
  $varNewsDate = $_POST['news_date'];
  $varCrime = $_POST['crime'];
  $varCrimeClassification = $_POST['crime_classification'];
  $varInvestigation = $_POST['investigation'];
  $varNotes = $_POST['notes'];
  $errorMessage = "";
	
//  include 'dbo.php';
 
  $sql = "UPDATE cases SET news_date=:news_date, news_title=:news_title,
  news_url=:news_url, crime=:crime, crime_classification=:crime_classification,
  investigation=:investigation, notes=:notes 
  WHERE case_index=:case_index";

	$date = DateTime::createFromFormat('m.d.y', addslashes($varNewsDate));
  $array_param=array(':case_index'=>addslashes($varNewsIndex), 
  ':news_date'=>$date->format('Y-m-d'),
//  ':news_date'=>addslashes($varNewsDate),
  ':news_title'=>addslashes($varNewsTitle), // date( 'm.d.y', $phpdate )
  ':news_url'=>addslashes($varNewsUrl),
  ':crime' =>addslashes($varCrime),
  ':crime_classification' => intval($varCrimeClassification),
  ':investigation'=>addslashes($varInvestigation),
  ':notes'=>addslashes($varNotes));
  
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
<form action="add_news.php">
  <input type="submit" value="Add">
</form>
</td>
<td>
<form action="edit_account.php">
  <input type="submit" value="Edit Account">
</form>
</td>
<td>
<form action="notes.php">
  <input type="submit" value="Assignment">
</form>
</td>
<td>
<form action="classification/index.php">
  <input type="submit" value="Crime Category">
</form>
</td>
<td>
<form action="technique/index.php">
  <input type="submit" value="Technique">
</form>
</td>
<td>
 <form action="logout.php">
  <input type="submit" value="Logout">
</form>
</td>
</tr>
</table>
<table border="1">
  <?php
  //include("dbo.php");
  
  $sql="SELECT * FROM cases ORDER BY news_date DESC";
          
  foreach ($db->query($sql) as $test)
  {
	$date = DateTime::createFromFormat('Y-m-d h:i:s', $test['news_date']);
	  
      $id = $test['case_index'];	
      echo "<tr align='center'>";	
      echo"<td><font color='black'>" .$test['case_index']."</font></td>";
      echo"<td><font color='black'>" . $date->format('m.d.y') . "</font></td>";
      echo"<td><font color='black'> <a href='".$test['news_url']."'>" . $test['news_title']. "</a></font></td>";
      echo"<td> <a href ='update.php?case_index=$id'>Edit</a>";
      echo"<td> <a href ='del.php?case_index=$id' onclick='return DeleteOrNot();'><center>Delete</center></a>";
                          
      echo "</tr>";
  }
  $db=null;
  ?>
</table>

</body>
</html>

