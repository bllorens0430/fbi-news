<?php

//initialize key variables 
//******SANITIZE GET********
	$num=intval($_GET['count']);
 	$init=intval($_GET['init']);
 	$limit=intval($_GET['limit']);

function echolinks($init, $num, $page, $limit){
	$limitplus=$limit+25;
	$limitless=$limit-25;
	$more="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$init&count=$num&limit=$limitplus'>Show More</a>";
	$less="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$init&count=$num&limit=$limitless'>Show Less</a>";
	//find the proper 
	$mod=$num;
	while ($mod%$limit!=0) {
		$mod--;
	};
	$last="|<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$mod&count=$num&limit=$limit'>Last</a>";
  if($init==0){
    $older='';
    $first='';
  }
  else{
    $minus=$init-$limit;
    $first="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=0&count=$num&limit=$limit'>First</a>|";
    $older="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$minus&count=$num&limit=$limit'>Earlier $limit</a>|";
  }
  if($limit<26){
  	$less='';
  }
  
  $init1=$init+1;
  $plus=$init+$limit;
  if($plus<$num){
  $new="|<a href='http://localhost:8888/HCISec/fbi-news/FBINews/$page.php?init=$plus&count=$num&limit=$limit'>Next $limit</a>";
  echo "<p>Displaying $init1 - $plus of $num entries</p>
 		$first$older$new$last<br>$less | $more";
  }
  else{
    echo "<p>Displaying $init1 - $num of $num entries</p>
    $first$older<br>$less | $more";
  }
}

//Produces a table on the page for browsing
//Needs to be sanitized
function getdata($init, $numentries, $table, $db){ 
  $sql="SELECT * FROM $table LIMIT $init, $numentries";
  
  //count is used to alternately style tablerows, see css/style.css 
   $count='evenrow'; 
  
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
	    
	      $id = $result['case_index'];
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
	$db=null;
}
  ?>