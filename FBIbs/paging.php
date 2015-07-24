<?php

//initialize key variables

	$num=intval($_GET['count']);
 	$init=intval($_GET['init']);
 	$limit=intval($_GET['limit']);
 	if (isset($_GET['table'])) {
 		$table=$_GET['table'];
 	}


function echolinks($init, $num, $page, $limit){
	//in case of negative init we set it to 0
	if ($init<0) {
		$init=0;
	}
  //these are for incrementing the # of shown entries
	$limitplus=$limit+25;
	$limitless=$limit-25;
	$more="<noscript><a class='button_link' href='cases.php?init=$init".htmlspecialchars('&')."count=$num".htmlspecialchars('&')."limit=$limitplus'> Show More </a></noscript><button class='styled-button-6 unhideme' onclick='ajax($init, $num, $limitplus, \"$page\")'>Show More</button>";
	$less="<noscript><a class='button_link' href='cases.php?init=$init".htmlspecialchars('&')."count=$num".htmlspecialchars('&')."limit=$limitless' > Show Less </a></noscript><button class='styled-button-6 unhideme' onclick='ajax($init, $num, $limitless, \"$page\")'>Show Less</button>";

  #this will find the correct init for someone skipping to the end
	$mod=$num;
	while ($mod%$limit!=0) {
		$mod--;
	};
	$last="<noscript><a class='button_link' href='cases.php?init=$mod".htmlspecialchars('&')."count=$num".htmlspecialchars('&')."limit=$limit'> >>> </a></noscript><button class='styled-button-6 unhideme' onclick='ajax($mod, $num, $limit, \"$page\")'> >>> </button>";

  #cant go backwasrds
  if($init==0){
    $older='';
    $first='';
  }
  else{
    #can go backwards so set a button with init-limit
    $minus=$init-$limit;
    $first="<noscript><a class='button_link' href='cases.php?init=0".htmlspecialchars('&')."count=$num".htmlspecialchars('&')."limit=$limit'> ".htmlspecialchars('<<<')." </a></noscript><button class='styled-button-6 unhideme' onclick='ajax(0, $num, $limit, \"$page\")'> <<< </button>";
  	$older="<noscript> <a class='button_link' href='cases.php?init=$minus".htmlspecialchars('&')."count=$num".htmlspecialchars('&')."limit=$limit'> ".htmlspecialchars('<')." </a></noscript><button class='styled-button-6 unhideme' onclick='ajax($minus, $num, $limit, \"$page\")'> < </button>";
  }
  #don't allow users to show 0 entries
  if($limit<26){
  	$less='';
  }

  $init1=$init+1;
  $plus=$init+$limit;

  //check to see if we are at the end then print our buttons
  if($plus<$num){
  $new="<noscript><a class='button_link' href='cases.php?init=$plus".htmlspecialchars('&')."count=$num".htmlspecialchars('&')."limit=$limit'> > </a></noscript><button class='styled-button-6 unhideme' onclick='ajax($plus, $num, $limit, \"$page\")'> > </button>";
  echo "<p>$less"."Displaying $init1 - $plus of $num entries$more </p>
 		$first$older$new$last";
  }
  else{
    echo "<p>$less"."Displaying $init1 - $num of $num entries</p>
    $first$older";
  }
}

//Produces a table on the page for browsing
function getdata($init, $numentries, $table, $db){
	//in case of negative initial value
	if ($init<0) {
		$init=0;
	}
if($table == 'cases' OR $table == 'technique' OR $table == 'crime_category'){
  $sql="SELECT * FROM $table";
  if($table=='crime_category'){
    $sql.=" ORDER BY crime_classification";
  }
  $sql.=" LIMIT :init, :numentries";
  $sql=$db->prepare($sql);
  $sql->bindParam(':init', $init, PDO::PARAM_INT);
  $sql->bindParam(':numentries', $numentries, PDO::PARAM_INT);
}

 //output proper table headers depending on db table
  	if($table=='cases'){
  	echo "<table class='table-striped'>
  <tr>
    <th>Date</th>
    <th>Story</th>
    <th>Classification</th>
    <th></th>
  </tr>";
  }
  elseif ($table=='technique') {
  	echo"<table class='table-striped'>
	<tr>
		<th>Technique</th>
		<th>Category</th>
    <th></th>
	</tr>";
  }
  elseif ($table=='crime_category')  {
  	echo"
  	<table class='table-striped'>
	<tr>
		<th>Category</th>
    <th></th>
	</tr>
  	";
  }
 //count is used to alternately style tablerows, see css/style.css oddrow/evenrow
 if ($sql->execute()) {
      while($result=$sql->fetch(PDO::FETCH_ASSOC)){

    //Specific queries for each database:
    //Take relevant data and use htmlspecialchars or strip_tags to get rid of any scripts

    if($table=='cases'){

      #the date needs some extra formatting.
    	$date = htmlspecialchars($result['news_date']);
	  	$date = DateTime::createFromFormat('Y-m-d h:i:s', $date);

	      $id = htmlspecialchars($result['case_index']);
	      $id=str_replace(' ', '', $id);
	      echo "<tr>";
	      echo"<td >" .$date->format('m.d.y')."</td>";
	      echo"<td ><a href='".strip_tags($result['news_url'])."'>".strip_tags(stripslashes($result['news_title']))."</a></td>";
	      echo"<td >". strip_tags(($result['crime_classification'])). "</td>";
	      echo"<td '><a href='show_case.php?id=$id'>View</a></td>";

	      echo "</tr>";
	  }
	  if($table=='crime_category'){
      # category names have a few odd characters that need to get removed for normal users
	  	$categg=strip_tags(stripslashes($result['cat_name']), '<b>');
      $categg=preg_replace('/[^\d\w\40<>]/', '', $categg);
      #indent non bold categories
      if(!strstr($categg, '<b>')){
        $categg="<span class='indent'>".$categg."</span>";
      }
	    	      $id = $result['cat_number'];
	      echo "<tr>";
	      echo"<td >".$categg. "</td>";
	      echo"<td ><a href='show_cat.php?id=$id'>View</a></td>";

      echo "</tr>";
	  }
	  if ($table=='technique') {
	  	  $id = strip_tags($result['technique_index']);
	      $id=str_replace(' ', '', $id);
	      echo "<tr>";
	      echo"<td ><a href='".strip_tags($result['technique_url'])."'>". strip_tags($result['technique_name']). "</a></td>";
	      echo"<td >". strip_tags($result['technique_category']). "</td>";
	      echo"<td><a href='show_technique.php?id=$id'>View</a></td>";

	      echo "</tr>";
	  }

	}
}
	echo "</table>

  <script type='text/javascript'>
  unhide = document.getElementsByClassName('unhideme');
   for (var i = 0; i < unhide.length; i++) {
      unhide[i].className='styled-button-6';
     };
  </script>";
	$db=null;
}


  ?>
