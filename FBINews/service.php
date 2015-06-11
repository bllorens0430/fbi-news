<?php  //This is only displayed if they have submitted the form  
if ($searching =="yes")  {  
	echo "<h2>Results</h2><p>";   
	//If they did not enter a search term we give them an error  
	if ($find == "")  {  
		echo "<p>You forgot to enter a search term";  
		exit;  
	}   
	// Otherwise we connect to our Database  
	mysql_connect("../common.php", "root", "fxw0528t") or die(mysql_error());  
	mysql_select_db("mydb") or die(mysql_error());   
	// We preform a bit of filtering  
	$find = strtoupper($find);  
	$find = strip_tags($find);  
	$find = trim ($find);   

	//Now we search for our search term, in the cases table 
	if ($table == cases) {
		//Should news_url be included in the search as well? 
		$data = mysql_query("SELECT * FROM $table WHERE (upper('news_date') OR upper('news_title') OR upper('crime') OR upper('crime_classification') OR upper('investigation') OR upper('notes')) LIKE'%$find%'");   
		//And we display the results  
		while($result = mysql_fetch_array( $data )) 
		 {  
			echo $result['news_title'];  
			echo " ";  
			echo $result['crime'];  
			echo "<br>";  
			echo $result['news_date']; 
			echo "<br>;"
			echo"<td><a href=show_case.php?id=$result['case_index']><button href=show_case.php?id=$result['case_index']>View Case</button></a></td>";
			echo "<br>";  
			echo "<br>";  
		}
			//This counts the number or results and sends a message if there weren't any  
			$anymatches=mysql_num_rows($data);  
			if ($anymatches == 0)  
			{  
				echo "Sorry, but we can not find an entry to match your query<br><br>";  
			}
	//Now we search for our search term in the crime_category table
	else if ($table == crime_category) {
		$data = mysql_query("SELECT * FROM $table WHERE (upper('crime_classification') OR upper('cat_name') OR upper('cat_explanation') OR upper('notes')) LIKE'%$find%'");    
		//And we display the results  
		while($result = mysql_fetch_array( $data )) 
		 {  
			echo $result['cat_name'];  
			echo " ";  
			echo $result['crime_classification'];  
			echo "<br>";  
			echo"<td><a href=show_case.php?id=$result['cat_number']><button href=show_case.php?id=$result['cat_number']>View Category</button></a></td>";
			echo "<br>";  
			echo "<br>";  
		}
			//This counts the number of results and sends a message if there weren't any 
			$anymatches=mysql_num_rows($data);  
			if ($anymatches == 0)  
			{  
				echo "Sorry, but we can not find an entry to match your query<br><br>";  
			}
	//Now we search for our search term in the technique table
	else {
		$data = mysql_query("SELECT * FROM $table WHERE (upper('technique_name') OR upper('technique_category') OR upper('technique_details') OR upper('notes')) LIKE'%$find%'");    
		//And we display the results  
		while($result = mysql_fetch_array( $data )) 
		 {  
			echo $result['technique_name'];  
			echo " ";  
			echo $result['technique_category'];  
			echo "<br>";  
			echo"<td><a href=show_case.php?id=$result['technique_index']> <button href=show_case.php?id=$result['technique_index']>View Technique</button></a></td>"; 
			echo "<br>";  
			echo "<br>";  
		}
			//This counts the number of results and sends a message if there weren't any
			$anymatches=mysql_num_rows($data);  
			if ($anymatches == 0)  
			{  
				echo "Sorry, but we can not find an entry to match your query<br><br>";  
			}
	}

	//And we remind them what they searched for  
	echo "<b>Searched For:</b> " .$find;    
		
?>

<?php

require 'common.php';

$limit=25;

//get # of rows in each table to pass to browsing pages.
$sql="SELECT COUNT(*) AS case_count FROM cases";
$cases= $db->query($sql);
$case= $cases->fetch(PDO::FETCH_ASSOC);
$case_count= $case['case_count'];

$sql="SELECT COUNT(*) AS tech_count FROM technique";
$tech= $db->query($sql);
$techni= $tech->fetch(PDO::FETCH_ASSOC);
$tech_count= $techni['tech_count'];

$sql="SELECT COUNT(*) AS cat_count FROM crime_category";
$cats= $db->query($sql);
$cat= $cats->fetch(PDO::FETCH_ASSOC);
$cat_count= $cat['cat_count'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
 <?php include 'header.php' ?>
  <div id="sidebar">
    <h2>Crime Database</h2>
  </div>
  <div id="content">
    <h2>Search</h2>
	<form method="GET" action="service.php" onsubmit="return find"> 
 	Search for: <input type="text" name="find" /> in  
 	<Select NAME="table"> 
 	<Option VALUE="cases">Cases</option> 
 	<Option VALUE="crime_category">Categories</option> 
 	<Option VALUE="technique">Techniques</option> 
 	</Select> 
 	<input type="hidden" name="searching" value="yes" /> 
 	<input type="submit" name="search" value="Search" /> 
 	</form>

    <h2>Crime Cases</h3>
    <p>Our database has compiled various cases of cyber crime from the FBI and
     other sources. 
     <?php echo"<a id='cases' href='cases.php?init=0&count=$case_count&limit=$limit'>Browse Cases</a></p>" ?>
    
    <h2>Crime Techniques</h3>
    <p>There are various techniques to carry out cyber 
      crime and corresponding defense mechanisms. Here is a list of some of them.

    <?php echo"<a id='techniques' href='techniques.php?init=0&count=$tech_count&limit=$limit'>Browse Techniques</a></p>" ?>

    <h2>Crime Categories</h3>
    <p>The categories used by the FBI may use a mix of cyber crime techniques.  
      The categories are listed here for your convenience.
    <?php echo"<a id='classes' href='categories.php?init=0&count=$cat_count&limit=$limit'>Browse Categories</a></p>" ?>
    
  </div>
  <?php include 'footer.php' ?>
</div>
</body>
</html>

<script src="js/hilight.js" type="text/javascript"></script>

