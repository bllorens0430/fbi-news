<?php  

require 'common.php';
require 'session.php';
//include ("dbo.php");


//$id = $_GET['id'];
//$result = $db->query($data);
//$case = $result->fetch(PDO::FETCH_ASSOC);

//This is only displayed if they have submitted the form  
if(isset($_GET['search'])){
	$searching=$_GET['searching'];
	$find= $_GET['find'];
	$table= $_GET['table'];

	$search_result="";
	$temp_search_result="";
if($searching=="yes")  {  
	$search_result.="<p><h2>Results</h2></p>";   
	//If they did not enter a search term we give them an error  
	if($find=="")  {  
		$search_result.="<p>You forgot to enter a search term</p>";  
		exit;  
	} 
}

	// Otherwise we connect to our Database  
	//mysql_connect("../common.php", "root", "fxw0528t") or die(mysql_error());  
	//mysql_select_db("mydb") or die(mysql_error());   
	// We preform a bit of filtering  
	$find=strip_tags($find);  
	$find=trim ($find);   

	//Now we search for our search term, in the cases table 
	if($table=="cases"){
		//Should news_url be included in the search as well? 
		$sql=$db->prepare("SELECT * FROM cases
			WHERE news_title LIKE ?
				OR  crime LIKE ?
				OR  investigation LIKE ? 
				OR notes LIKE ?");
	
			//$search=$find;

		//$counter=$db->query("SELECT COUNT(*) FROM cases");
		//$case=$sql->execute(array('%'.$find.'%'));
		//$cases= $case->fetch(PDO::FETCH_ASSOC);
	  		
		if($sql->execute(array("'%".$find."%'", "%".$find."%", "%".$find."%", "%".$find."%"))) {
			while ( $cases=$sql->fetch(PDO::FETCH_ASSOC)) {
			$id=htmlspecialchars($cases['case_index']);
	  		$id=str_replace(' ', '', $id);
      		if($count=="oddrow"){
        		$count="evenrow";
      		}
      		else{
        		$count="oddrow";
      		}
      		$temp_search_result.= "<tr class='$count' align='left'>";	
      	    $temp_search_result.= "<td><font color='black'>" . htmlspecialchars($cases['news_title'], ENT_QUOTES, 'UTF-8') . "</font></td>";
	  		$crime=htmlspecialchars($cases['crime'], ENT_QUOTES, 'UTF-8');
	  		$bold_crime=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "</b>", $crime));
      		$temp_search_result.="<td><font color='black'>" . $bold_crime . "</font></td>";
      		$temp_search_result.="<td><a href='show_case.php?id=$id'><button href='show_case.php?id=$id'>View Case</button></a></td>";
      	}}
			//This counts the number of results and sends a message if there weren't any 

		//	$anymatches= mysql_num_rows($sql); 
		/*	if($anymatches==0) {  
				$search_result.="<p>Sorry, but we can not find an entry to match your query</br></br></p>"; }
			else{*/
			$search_result.="<table id='dbtable'>";
			$search_result.=$temp_search_result;
			$search_result.="</table>";
		//}
		
	}
	//Now we search for our search term in the crime_category table
	  elseif($table=="crime_category"){
		$sql=$db->prepare("SELECT * FROM crime_category 
		WHERE  cat_name LIKE ?
			OR cat_explanation LIKE ?
			OR notes LIKE ?");   

		if($sql->execute(array("%".$find."%", "%".$find."%", "%".$find."%"))) {
			while ( $crimes=$sql->fetch(PDO::FETCH_ASSOC)) {
			//$cat_crime= $crimes->fetch(PDO::FETCH_ASSOC);
	  		$id=htmlspecialchars($crimes['cat_number']);
      		if($count=="oddrow"){
        		$count="evenrow";
      		}
      		else{
        		$count="oddrow";
      		}
      		$temp_search_result.="<tr class='$count' align='left'>";	
      		$temp_search_result.="<td><font color='black'>" . htmlspecialchars($crimes['crime_classification'], ENT_QUOTES, 'UTF-8') . "</font></td>";
	  		$cat_name=htmlspecialchars($crimes['cat_name'], ENT_QUOTES, 'UTF-8');
	  		$bold_cat_name=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "<b>", $cat_name));
      		$temp_search_result.="<td><font color='black'>" . $bold_cat_name . "</font></td>";
      		$temp_search_result.="<td><a href='show_cat.php?id=$id'><button href='show_cat.php?id=$id'>View Category</button></a></td>";
		}}
			//This counts the number of results and sends a message if there weren't any 
		
			$search_result.="<table id='dbtable'>";
			$search_result.=$temp_search_result;
			$search_result.="</table>";
		
	}
	//Now we search for our search term in the technique table
	else if ($table=="technique"){
		$sql=$db->prepare("SELECT * FROM technique
		WHERE technique_name LIKE ?
			OR technique_details LIKE ?
			OR notes LIKE ? ");   

		//And we display the results 
		if($sql->execute(array("%".$find."%", "%".$find."%", "%".$find."%"))) {
			while ( $techniques=$sql->fetch(PDO::FETCH_ASSOC)) {
	  		$id=htmlspecialchars($techniques['technique_index']);
	  		$id=str_replace(' ', '', $id);
      		if($count=="oddrow"){
        		$count="evenrow";
      		}
      		else{
        		$count="oddrow";
      		}
      		$temp_search_result.="<tr class='$count' align='left'>";	
      		$temp_search_result.="<td><font color='black'>" . htmlspecialchars($techniques['technique_category'], ENT_QUOTES, 'UTF-8') . "</font></td>";
	  		$technique_name=htmlspecialchars($techniques['technique_name'], ENT_QUOTES, 'UTF-8');
	  		$bold_technique_name=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "</b>", $technique_name));
      		$temp_search_result.="<td><font color='black'>" . $bold_technique_name . "</font></td>";
      		$temp_search_result.="<td><a href='show_technique.php?id=$id'><button href='show_technique.php?id=$id'>View Technique</button></a></td>";
		}}
			//This counts the number of results and sends a message if there weren't any 
			
			$search_result.="<table id='dbtable'>";
			$search_result.=$temp_search_result;
			$search_result.="</table>";
		}

	//And we remind them what they searched for  
	$search_result.="<b>Searched For:</b> " .$find;   
}
?>

<?php

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
</head>
<body>
<div id="container">
 <?php include 'header.php' ?>
  <div id="sidebar">
    <h2>Crime Database</h2>
  </div>
  <div id="content">
    <h2>Search</h2>
	<form method="GET" action="search.php" onsubmit="return find"> 
 	Search for: <input type="text" name="find" /> in  
 	<Select NAME="table"> 
 	<Option VALUE="cases">Cases</option> 
 	<Option VALUE="crime_category">Categories</option> 
 	<Option VALUE="technique">Techniques</option> 
 	</Select> 
 	<input type="hidden" name="searching" value="yes" /> 
 	<input type="submit" name="search" value="Search" /> 
 	</form>
 	<?php
 	if(isset($search_result)){
 		echo $search_result;
 	}
 	?>
    
  </div>
  <?php include 'footer.php' ?>
</div>
</body>
</html>

<script src="js/hilight.js" type="text/javascript"></script>

