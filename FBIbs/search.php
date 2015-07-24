<?php

require 'common.php';
require 'session.php';
require 'page.php';
require 'visualize.php';
require 'cat_forms.php';


//This is only displayed if they have submitted the form
if(isset($_GET['search'])){
	$searching=$_GET['searching'];

  $find=$_GET['find'];

	$table= $_GET['table'];
	$init=intval($_GET['init']);
	$limit=intval($_GET['limit']);
	$sum=$limit+$init;
	$search_result="";
	$temp_search_result="";
if($searching=="yes")  {
	$search_result.="<h2>Results</h2>";
	//If they did not enter a search term we give them an error
}

	// Otherwise we connect to our Database
	// We preform a bit of filtering
	$find=strip_tags($find);
	$find=trim ($find);
	$findme='%'.$find.'%';

	//Now we search for our search term, in the cases table using prepared statements
	if($table=="cases"){
		$sql="SELECT * FROM cases
			WHERE";
		$cats='';
		if (isset($_GET['cases'])){
			#set this and for dates since dates will not be the first in the query
			$catarr=$_GET['cases'];
			if($catarr[0]!='0'){
					$cats.=" (crime_classification LIKE :0";
					$catarr[0]="%".$catarr[0]."%";
				}
				else{
					$cats.=" (crime_classification = :0";
				}
			$len=count($catarr);
			for ($i=1; $i < $len; $i++) {
				if(strpos($catarr[$i], '0000')){
					$cats.=" OR crime_classification LIKE :$i";
					$catarr[$i]="%".$catarr[$i]."%";
				}
				else{
					$cats.=" OR crime_classification = :$i";
				}
			}
			$cats.=") AND";
		}
		if(isset($_GET['start'])&&isset($_GET['finish'])&&$_GET['finish']!=''){
        $buttonstart=$_GET['start'];
        $buttonfinish=$_GET['finish'];
				$start=date('Y-m-d H:i:s', strtotime($_GET['start']));
				$finish=date('Y-m-d H:i:s', strtotime($_GET['finish']));
				$sql.=$cats." news_date > :start
				AND news_date < :finish
				 AND (news_title LIKE :find
				OR  crime LIKE :find
				OR  investigation LIKE :find
				OR notes LIKE :find) ORDER BY news_date";

		}

		else{
			$sql.=$cats." news_title LIKE :find
				OR  crime LIKE :find
				OR  investigation LIKE :find
				OR notes LIKE :find";
		}
		$sql=$db->prepare($sql);
		if(isset($_GET['cases'])){
			for ($i=0; $i < $len; $i++) {
				$sql->bindParam(":$i", $catarr[$i], PDO::PARAM_STR);
			}
		}
		if (isset($_GET['start'])&&isset($_GET['finish'])&&$_GET['finish']!=''){

			$sql->bindParam(':start', $start, PDO::PARAM_STR);
			$sql->bindParam(':finish', $finish, PDO::PARAM_STR);
		}
			$sql->bindParam(':find', $findme, PDO::PARAM_STR);

		if($sql->execute()){
			$num = $sql->rowCount();
			$i=0;
			$count="evenrow";

			//we cycle through and get all the results
			while ($cases=$sql->fetch(PDO::FETCH_ASSOC)) {

					$date = htmlspecialchars($cases['news_date']);
			  		$date = DateTime::createFromFormat('Y-m-d h:i:s', $date);
			  			#echo $date->format('m.d.y.');
			  			#echo $cases['crime_classification'];
			  			#echo "<br>";
					$id=htmlspecialchars($cases['case_index'], ENT_QUOTES, 'UTF-8');
			  		$id=str_replace(' ', '', $id);
		      		if($count=="oddrow"){
		        		$count="evenrow";
		      		}
		      		else{
		        		$count="oddrow";
		      		}

		      		//but only show some of them to keep the page from displaying too many entries
		      		if((($init)<=$i && $i<$sum)){
		      			$temp_search_result.= "<tr class='$count' id='$i'>";
		      		}
		      		else{
		      			$temp_search_result.= "<tr class='$count hide' id='$i'>";
		      		}

		      		//we store them all in a temporary variable
		      		$temp_search_result.= "<td>" .$date->format('m.d.y')."</td>";
		      	    $temp_search_result.= "<td class=col-md-8>" . htmlspecialchars($cases['news_title'], ENT_QUOTES, 'UTF-8') . "</td>";
		      		$temp_search_result.="<td class='right'><a href='show_case.php?id=$id'>View</a></td>";



      		$i++;
      	}

      }
      	if(isset($temp_search_result)){
      	//now we sandwich the temp variable in a table
			$search_result.="<table class='table-striped'>
							<tr>
							    <th>Date</th>
							    <th class=col-md-8>Case</th>
                  <th>View</th>
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
	//Now we search for our search term in the crime_category table
	  elseif($table=="crime_category"){
		$sql=$db->prepare("SELECT * FROM crime_category
		WHERE  cat_name LIKE :find
			OR cat_explanation LIKE :find
			OR notes LIKE :find");

		$sql->bindParam(":find", $findme, PDO::PARAM_STR);
		if($sql->execute()) {
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
      		$temp_search_result.="<td>" . htmlspecialchars($crimes['crime_classification'], ENT_QUOTES, 'UTF-8') . "</td>";
	  		$cat_name=htmlspecialchars($crimes['cat_name'], ENT_QUOTES, 'UTF-8');
	  		$cat_name=str_replace('*', '', $cat_name);
	  		$cat_name=str_replace('?', '', $cat_name);
	  		$bold_cat_name=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "<b>", $cat_name));
      		$temp_search_result.="<td>" . $bold_cat_name . "</td>";
      		$temp_search_result.="<td class='right'><a href='show_cat.php?id=$id'>View</a></td>";

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
		//And we remind them what they searched for
		$search_result.="<b>Searched For:</b> " .$find;
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
				  technique_name LIKE :find
				OR  technique_details LIKE :find
				OR notes LIKE :find".$cats;

		$sql=$db->prepare($sql);
		$sql->bindParam(':find', $findme, PDO::PARAM_STR);
		//And we display the results
		if($sql->execute()) {

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

	  		$technique_name=htmlspecialchars($techniques['technique_name'], ENT_QUOTES, 'UTF-8');
	  		$bold_technique_name=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "</b>", $technique_name));
      		$temp_search_result.="<td>" . $bold_technique_name . "</td>";
          $temp_search_result.="<td>" . htmlspecialchars($techniques['technique_category'], ENT_QUOTES, 'UTF-8') . "</td>";
      		$temp_search_result.="<td class='right'><a href='show_technique.php?id=$id'>View</a></td>";
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

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-3.3.5-dist/css/hcisec.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<title>Welcome</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
</head>
<body>
<div class='container'>
 <?php include 'header.php' ?>
  <div id="sidebar">
    <h2>Crime Database</h2>
  </div>
  <div id="content">
    <h2>Search</h2>
	<form method="GET" action="search.php" onsubmit="return find" onchange="hidebutton()">
 	Search for: <input type="text" name="find" /> in
 	<Select NAME="table">
 	<Option VALUE="cases">Cases</option>
 	<Option VALUE="crime_category">Categories</option>
 	<Option VALUE="technique">Techniques</option>
 	</Select>
 	 <?php
    $dates = new visualize($db=$db);
    $dates->set_year();
  ?>
  <div class = 'hidebutton'>
  <br>
  Between
  <input type='date' name='start' value='<?php  $dates->get_fy(); echo"-01-01";?>'>
  And
  <input type='date' name= 'finish' value='<?php echo date('Y-m-d'); ?>'>

    </div>
 	<input type="hidden" name="searching" value="yes" />
 	<input type="hidden" name="init" value="0" />
 	<input type="hidden" name="limit" value="25" />
  <noscript> <input type="hidden" name="noscript" value="1" /> </noscript>
 	<input type="submit" name="search" value="Search" />
<?php if (isset($_GET['noscript'])) {
  echo"<div><p>Filter by Category</p>";
  $cat = new cats($db, False, True);
  $cat->cat_multi();
  $cat=null;
}
if (!isset($_GET['noscript'])) {
  $cat=new cats($db);
  echo"
  <div class='hidebutton'>
  <button type='button' onclick='toggleCase(".'"classifys", "bigwindow")'."' class='styled-button-srch'>Filter By Category</button>
  <div class='classifys bigwindow hide'>
  <button type='button' onclick='toggleCase(".'"classifys", "bigwindow")'."' class='styled-button-DV'>Hide</button>";
   $cat->cat();
   $cat=null;
   echo"
  </div>
";
}
  ?>
 	</form>
 	<?php

 	if(isset($search_result)){
 		echoDisplay($init, $num, $table, $limit);
 		echo $search_result;
 		echolinks($init, $num, $table, $limit, $find, $buttonstart="", $buttonfinish="");
 	}
 	?>
  </div>
  </div>
  <?php include 'footer.php' ?>


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
<script>
function hidebutton(){
  if (document.getElementsByName('table')[0].value == 'cases') {
     button = document.getElementsByClassName('hidebutton');
     for (var i = 0; i < button.length; i++) {
      button[i].className='hidebutton';
     };
  }
  else{
    button = document.getElementsByClassName('hidebutton');
     for (var i = 0; i < button.length; i++) {
      button[i].className='hidebutton hide';
     };
  };
};
</script>
<script type="text/javascript">update(<?php echo"$init, $num, $limit" ?>)</script>
<script type="text/javascript">
  unhide = document.getElementsByClassName('unhideme');
   for (var i = 0; i < unhide.length; i++) {
      unhide[i].className='styled-button-srch';
     };
</script>
<script src="js/hilight.js" type="text/javascript"></script>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
