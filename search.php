<?php

require 'common.php';
require 'session.php';
require 'page.php';
require 'visualize.php';
require 'cat_box.php';

//This is only displayed if they have submitted the form
if(isset($_GET['search'])){
	$searching=$_GET['searching'];
	$find= $_GET['find'];
	$table= $_GET['table'];
	$init=intval($_GET['init']);
	$limit=intval($_GET['limit']);
	$sum=$limit+$init;
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
	// We preform a bit of filtering
	$find=strip_tags($find);
	$find=trim ($find);

	//Now we search for our search term, in the cases table using prepared statements
	if($table=="cases"){
		$sql="SELECT * FROM cases
			WHERE";
		$cats='';
		if (isset($_GET['cases'])){
			$catarr=$_GET['cases'];
			$cats.=" AND (crime_classification = $catarr[0]";
			$len=count($catarr);
			for ($i=1; $i < $len; $i++) {
				$cats.=" OR crime_classification = $catarr[$i]";
			}
			$cats.=")";
		}
		if(isset($_GET['start'])&&isset($_GET['finish'])&&$_GET['finish']!=''){
				$start=date('Y-m-d H:i:s', strtotime($_GET['start']));
				$finish=date('Y-m-d H:i:s', strtotime($_GET['finish']));
				$sql.=" news_date > '$start'
				AND news_date < '$finish'
				AND (news_title LIKE ?
				OR  crime LIKE ?
				OR  investigation LIKE ?
				OR notes LIKE ?)".$cats."ORDER BY news_date";
				#echo $sql;
		}
		else{
			$sql.=" news_title LIKE ?
				OR  crime LIKE ?
				OR  investigation LIKE ?
				OR notes LIKE ?".$cats;
		}
		$sql=$db->prepare($sql);


		if($sql->execute(array("'%".$find."%'", "%".$find."%", "%".$find."%", "%".$find."%"))) {
			$num = $sql->rowCount();
			$i=0;
			$count="evenrow";

			//we cycle through and get all the results
			while ($cases=$sql->fetch(PDO::FETCH_ASSOC)) {

					$date = htmlspecialchars($cases['news_date']);
			  		$date = DateTime::createFromFormat('Y-m-d h:i:s', $date);

					$id=htmlspecialchars($cases['case_index'], ENT_QUOTES, 'UTF-8');
			  		$id=str_replace(' ', '', $id);
		      		if($count=="oddrow"){
		        		$count="evenrow";
		      		}
		      		else{
		        		$count="oddrow";
		      		}

		      		//but only show some of them to keep the page from displaying too many entries
		      		if(($init)<=$i && $i<$sum){
		      			$temp_search_result.= "<tr class='$count' id='$i'>";
		      		}
		      		else{
		      			$temp_search_result.= "<tr class='$count hide' id='$i'>";
		      		}

		      		//we store them all in a temporary variable
		      		$temp_search_result.= "<td><font color='black'>" .$date->format('m.d.y')."</font></td>";
		      	    $temp_search_result.= "<td><font color='black'>" . htmlspecialchars($cases['news_title'], ENT_QUOTES, 'UTF-8') . "</font></td>";
			  		$crime=htmlspecialchars($cases['crime'], ENT_QUOTES, 'UTF-8');
			  		$bold_crime=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "</b>", $crime));
		      		$temp_search_result.="<td><font color='black'>" . $bold_crime . "</font></td>";
		      		$temp_search_result.="<td class='right'><a href='show_case.php?id=$id'><button href='show_case.php?id=$id'>View</button></a></td>";



      		$i++;
      	}

      }
      	if(isset($temp_search_result)){
      	//now we sandwich the temp variable in a table
			$search_result.="<table class='dbtable'>
							<tr>
							    <th>Date</th>
							    <th>Case</th>
							    <th>Classification</th>
							  </tr>";
			$search_result.=$temp_search_result;
			$search_result.="</table>";
		}
		else{
			$search_result.="<p>No results found matching your query</p>";
		}
	}
	//Now we search for our search term in the crime_category table
	  elseif($table=="crime_category"){
		$sql=$db->prepare("SELECT * FROM crime_category
		WHERE  cat_name LIKE ?
			OR cat_explanation LIKE ?
			OR notes LIKE ?");

		if($sql->execute(array("%".$find."%", "%".$find."%", "%".$find."%"))) {
			$num = $sql->rowCount();

			$i=0;
			$count="evenrow";
			while ( $crimes=$sql->fetch(PDO::FETCH_ASSOC)) {
	  		$id=htmlspecialchars($crimes['cat_number'], ENT_QUOTES, 'UTF-8');
      		if($count=="oddrow"){
        		$count="evenrow";
      		}
      		else{
        		$count="oddrow";
      		}
      		if(($init)<=$i && $i<$sum){
		      			$temp_search_result.= "<tr class='$count' id='$i'>";
		      		}
		    else{
		      			$temp_search_result.= "<tr class='$count hide' id='$i'>";
		      		}
      		$temp_search_result.="<td><font color='black'>" . htmlspecialchars($crimes['crime_classification'], ENT_QUOTES, 'UTF-8') . "</font></td>";
	  		$cat_name=htmlspecialchars($crimes['cat_name'], ENT_QUOTES, 'UTF-8');
	  		$cat_name=str_replace('*', '', $cat_name);
	  		$cat_name=str_replace('?', '', $cat_name);
	  		$bold_cat_name=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "<b>", $cat_name));
      		$temp_search_result.="<td><font color='black'>" . $bold_cat_name . "</font></td>";
      		$temp_search_result.="<td class='right'><a href='show_cat.php?id=$id'><button href='show_cat.php?id=$id'>View</button></a></td>";

      		$i++;

		}}
		//Again we check for any results and print a message if we don't find any
		if(isset($temp_search_result)){
			$search_result.="
						  	<table class='dbtable'>
							<tr>
								<th>Classification</th>
								<th>Category</th>
							</tr>
					  		";
			$search_result.=$temp_search_result;
			$search_result.="</table>";
		}
		else{
			$search_result.="<p>No results found matching your query</p>";
		}
	}
	//Now we search for our search term in the technique table
	else if ($table=="technique"){
		$sql="SELECT * FROM technique
			WHERE";
		$cats='';
		if (isset($_GET['cases'])){
			$catarr=$_GET['cases'];
			$cats.=" AND (technique_category = $catarr[0]";
			$len=count($catarr);
			for ($i=1; $i < $len; $i++) {
				$cats.=" OR technique_category = $catarr[$i]";
			}
			$cats.=")";
		}

			$sql.="
				  technique_name LIKE ?
				OR  technique_details LIKE ?
				OR notes LIKE ?".$cats;

		$sql=$db->prepare($sql);

		//And we display the results
		if($sql->execute(array("%".$find."%", "%".$find."%", "%".$find."%"))) {

			$num = $sql->rowCount();
			$i=0;
			$count="evenrow";

			while ( $techniques=$sql->fetch(PDO::FETCH_ASSOC)) {
	  		$id=htmlspecialchars($techniques['technique_index'], ENT_QUOTES, 'UTF-8');
	  		$id=str_replace(' ', '', $id);
      		if($count=="oddrow"){
        		$count="evenrow";
      		}
      		else{
        		$count="oddrow";
      		}

      		if(($init)<=$i && $i<$sum){
		      			$temp_search_result.= "<tr class='$count' id='$i'>";
		      		}
		    else{
		      			$temp_search_result.= "<tr class='$count hide' id='$i'>";
		      		}
      		$temp_search_result.="<td><font color='black'>" . htmlspecialchars($techniques['technique_category'], ENT_QUOTES, 'UTF-8') . "</font></td>";
	  		$technique_name=htmlspecialchars($techniques['technique_name'], ENT_QUOTES, 'UTF-8');
	  		$bold_technique_name=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "</b>", $technique_name));
      		$temp_search_result.="<td><font color='black'>" . $bold_technique_name . "</font></td>";
      		$temp_search_result.="<td class='right'><a href='show_technique.php?id=$id'><button href='show_technique.php?id=$id'>View</button></a></td>";
      		$i++;
		}}

		//Again we check for any results and print a message if we don't find any
		if(isset($temp_search_result)){
			$search_result.="
						<table class='dbtable'>
						<tr>
							<th>Technique</th>
							<th>Category</th>
						</tr>";
			$search_result.=$temp_search_result;
			$search_result.="</table>";
		}
		else{
			$search_result.="<p>No results found matching your query</p>";
		}

	//And we remind them what they searched for
	$search_result.="<b>Searched For:</b> " .$find;
}
}
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
 	</Select><br>
 	 <?php
    $dates = new visualize($db=$db);
    $dates->set_year();
  ?>
  Between
  <input type='date' name='start' value='<?php $dates->get_fy(); ?>'></input>
  And
  <input type='date' name= 'finish' value='<?php $dates->get_ly(); ?>'></input><br>
  <button type='button' onclick='toggleCase("classifys", "bigwindow")' class='styled-button-srch'>Search By Classification</button>
  <div class='classifys bigwwindow hide'>
  <button type='button' onclick='toggleCase("classifys", "bigwindow")' class='styled-button-DV'>Hide</button>
  <?php cat_box($db)?>
  </div>
 	<input type="hidden" name="searching" value="yes" />
 	<input type="hidden" name="init" value="0" />
 	<input type="hidden" name="limit" value="25" />
 	<input type="submit" name="search" value="Search" />
 	</form>
 	<?php

 	if(isset($search_result)){
 		echoDisplay($init, $num, $table, $limit);
 		echo $search_result;
 		echolinks($init, $num, $table, $limit);
 	}
 	?>
  </div>
  <?php include 'footer.php' ?>
</div>
</body>
</html>

<script src="js/hilightservice.js" type="text/javascript"></script>
<script  src="js/paging.js" type="text/javascript"></script>
<script type="text/javascript">
	//Calls external js onclick of button
	function update (init, num, limit) {
		page(init, num, limit);
		getButtons(init, num, limit);
	}
</script>
<script src="js/toggle.js" type="text/javascript"></script>
