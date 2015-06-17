<?php
function echolinks($init, $num, $page, $limit){
	$limitplus=$limit+25;
	$limitless=$limit-25;

	$more=" <button id='more'  class='styled-button-6' onclick='update($init, $num, $limitplus)'>Show More</button>";
	$less="<button id='less' class='styled-button-6 hide' onclick='update($init, $num, $limitless)'>Show Less</button> ";
	
  //find the proper multiple of $limit for the last page
	$mod=$num;
	while ($mod%$limit!=0) {
		$mod--;
	};
	$last="<button id='last' class='styled-button-6' onclick='update($mod, $num, $limit)'> >>> </button>";
    $minus=$init-$limit;
    $first="<button id='first' class='styled-button-6 hide' onclick='update(0, $num, $limit)'> <<< </button>";
  	$older="<button id='older' class='styled-button-6 hide' onclick='update($minus, $num, $limit)'> < </button>";
  
  $init1=$init+1;
  $plus=$init+$limit;

  $new="<button id='new' class='styled-button-6' onclick='update($plus, $num, $limit)'> > </button>";


  if ($num<25) {
    echo"<p><span class='innerText'>Displaying $init1 - $num of $num entries</span></p>";
  }
  else{

    echo "<p>$less"."<span class='innerText'>Displaying $init1 - $plus of $num entries</span>$more</p>
 		$first$older$new$last<br><br>";
  }
}
function echoDisplay($init, $num, $page, $limit){
  $init1=$init+1;
  $plus=$init+$limit;
  if ($num<25) {
    echo"";
  }
  else{
    echo"<p><span class='innerText'>Displaying $init1 - $plus of $num entries</span></p>";
  }
}
?>