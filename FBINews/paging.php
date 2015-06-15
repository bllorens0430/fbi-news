<?php

//initialize key variables 
//******SANITIZE GET********


	$num=intval($_GET['count']);
 	$init=intval($_GET['init']);
 	$limit=intval($_GET['limit']);
 	if (isset($_GET['table'])) {
 		$table=$_GET['table'];
 	}


function echolinks($init, $num, $page, $limit){
	//in case of negative init
	if ($init<0) {
		$init=0;
	}
	$limitplus=$limit+25;
	$limitless=$limit-25;
	//$more="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$init&count=$num&limit=$limitplus'>Show More</a>";
	$more=" <button class='styled-button-6' onclick='ajax($init, $num, $limitplus, \"$page\")'>Show More</button>";
	//$less="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$init&count=$num&limit=$limitless'>Show Less</a>";
	$less="<button class='styled-button-6' onclick='ajax($init, $num, $limitless, \"$page\")'>Show Less</button> ";
	//find the proper multiple of $limit for the last page
	$mod=$num;
	while ($mod%$limit!=0) {
		$mod--;
	};
	//$last="|<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$mod&count=$num&limit=$limit'>Last</a>";
	$last="<button class='styled-button-6' onclick='ajax($mod, $num, $limit, \"$page\")'> >>> </button>";
  if($init==0){
    $older='';
    $first='';
  }
  else{
    $minus=$init-$limit;
    //$first="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=0&count=$num&limit=$limit'>First</a>|";
    $first="<button class='styled-button-6' onclick='ajax(0, $num, $limit, \"$page\")'> <<< </button>";
    //$older="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$minus&count=$num&limit=$limit'>Earlier $limit</a>|";
  	$older="<button class='styled-button-6' onclick='ajax($minus, $num, $limit, \"$page\")'> < </button>";
  }
  if($limit<26){
  	$less='';
  }
  if($limit>$num){
  	$more='';
  	$cap=$num;
  }
  else{
  	$cap=$limit;
  }
  
  $init1=$init+1;
  $plus=$init+$limit;
  if($plus<$num){
  //$new="|<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$plus&count=$num&limit=$limit'>Next $limit</a>";
  $new="<button class='styled-button-6' onclick='ajax($plus, $num, $limit, \"$page\")'> > </button>";
  echo "<p>$less"."Displaying $init1 - $plus of $num entries$more</p>
 		$first$older$new$last";
  }
  else{
    echo "<p>$less"."Displaying $init1 - $num of $num entries$more</p>
    $first$older";
  }
}

//Produces a table on the page for browsing
//Needs to be sanitized
function getdata($init, $numentries, $table, $db){ 
	//in case of negative initial value
	if ($init<0) {
		$init=0;
	}

  $sql="SELECT * FROM $table LIMIT $init, $numentries";
  
  //count is used to alternately style tablerows, see css/style.css 
   $count='evenrow'; 
  	if($table=='cases'){
  	echo "<table id='dbtable'>
  <tr>
    <th>Date</th>
    <th>Case</th>
    <th>Classification</th>
  </tr>";
  }
  elseif ($table=='technique') {
  	echo"<table id='dbtable'>
	<tr>
		<th>Technique</th>
		<th>Category</th>
	</tr>";
  }
  elseif ($table=='crime_category');{
  	echo"
  	<table id='dbtable'>
	<tr>
		<th>Category</th>
	</tr>
  	";
  }
  foreach ($db->query($sql) as $result){

  	if ($count=="oddrow") {
      $count="evenrow";
    }
    else{
      $count="oddrow";
    }


    //Specific queries for each database:


    if($table=='cases'){

	  	$date = DateTime::createFromFormat('Y-m-d h:i:s', $result['news_date']);
	    $date = htmlspecialchars($date);
	      $id = htmlspecialchars($result['case_index']);
	      $id=str_replace(' ', '', $id);
	      echo "<tr class='$count' align='center'>";	
	      echo"<td><font color='black'>" .$date->format('m.d.y')."</font></td>";
	      echo"<td><font color='black'><a href='".htmlspecialchars($result['news_url'], ENT_QUOTES, 'UTF-8')."'>". htmlspecialchars($result['news_title'], ENT_QUOTES, 'UTF-8'). "<a/></font></td>";
	      echo"<td><font color='black'>". htmlspecialchars($result['crime_classification'], ENT_QUOTES, 'UTF-8'). "</font></td>";
	      echo"<td class='right'><a href=show_case.php?id=$id><button href=show_case.php?id=$id>View</button></a></td>";
	                          
	      echo "</tr>";
	  }
	  if($table=='crime_category'){
	  	$categg=htmlspecialchars($result['cat_name'], ENT_QUOTES, 'UTF-8');
	      $categg=str_replace('?', '', $categg);
	      $categg=str_replace('&lt;b&gt;', '', $categg);
	      $categg=str_replace('&lt;/b&gt;', '', $categg);
	      $categg=str_replace('*', '', $categg);
	      $id = $result['cat_number'];
	      echo "<tr class='$count'>";
	      echo"<td><font color='black'>". $categg. "</font></td>";
	      echo"<td class='right'><a href=show_cat.php?id=$id><button href=show_cat.php?id=$id>View</button></a></td>";
                          
      echo "</tr>";
	  }
	  if ($table=='technique') {
	  	  $id = $result['technique_index'];
	      $id=str_replace(' ', '', $id);
	      echo "<tr class='$count' align='center'>";	
	      echo"<td><font color='black'><a href='".htmlspecialchars($result['technique_url'], ENT_QUOTES, 'UTF-8')."'>". htmlspecialchars($result['technique_name'], ENT_QUOTES, 'UTF-8'). "<a/></font></td>";
	      echo"<td><font color='black'>". htmlspecialchars($result['technique_category'], ENT_QUOTES, 'UTF-8'). "</font></td>";
	      echo"<td class='right'><a href=show_technique.php?id=$id><button href=show_technique.php?id=$id>View</button></a></td>";
	                          
	      echo "</tr>";
	  }
	  
	}
	echo "</table>";
	$db=null;
}
  ?>