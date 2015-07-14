<?php
function echolinks($init, $num, $page, $limit, $find, $start, $finish){
	$limitplus=$limit+25;
	$limitless=$limit-25;
  //find the proper multiple of $limit for the last page
	$mod=$num;
	while ($mod%$limit!=0) {
		$mod--;
	}
  $minus=$init-$limit;
  $init1=$init+1;
  $plus=$init+$limit;


  if($plus>$num){
    $new="<button id='new' class='styled-button-6 hide' onclick='update($plus, $num, $limit)'> > </button>";
    $last="<button id='last' class='styled-button-6 hide' onclick='update($mod, $num, $limit)'> >>> </button>";
    $thru=$num;
    echo"Thru $thru";
  }
  else{
    $new="<noscript><a class='button_link' href=search.php?find=$find&table=$page&start=$start&finish=$finish&searching=yes&init=$plus&limit=$limit&search=Search></noscript><button id='new' class='styled-button-6' onclick='update($plus, $num, $limit)'> > </button><noscript></a></noscript>";
    $last="<noscript><a class='button_link' href=search.php?find=$find&table=$page&start=$start&finish=$finish&searching=yes&init=$mod&limit=$limit&search=Search></noscript><button id='last' class='styled-button-6' onclick='update($mod, $num, $limit)'> >>> </button><noscript></a></noscript>";
    $thru=$plus;
  }

  if($init==0){
    $older="<button id='older' class='styled-button-6 hide' onclick='update($minus, $num, $limit)'> < </button>";
    $first="<button id='first' class='styled-button-6 hide' onclick='update(0, $num, $limit)'> <<< </button>";
  }
  else{
     $first="<noscript><a class='button_link' href=search.php?find=$find&table=$page&start=$start&finish=$finish&searching=yes&init=0&limit=$limit&search=Search></noscript><button id='first' class='styled-button-6' onclick='update(0, $num, $limit)'> <<< </button><noscript></a></noscript>";
    $older="<noscript><a class='button_link' href=search.php?find=$find&table=$page&start=$start&finish=$finish&searching=yes&init=$minus&limit=$limit&search=Search></noscript><button id='older' class='styled-button-6' onclick='update($minus, $num, $limit)'> < </button><noscript></a></noscript>";
  }
  if ($limit==25) {
    $less="<button id='less' class='styled-button-6 hide' onclick='update($init, $num, $limitless)'>Show Less</button>";
  }
  else{
    $less="<noscript><a class='button_link' href=search.php?find=$find&table=$page&start=$start&finish=$finish&searching=yes&init=$init&limit=$limitless&search=Search></noscript><button id='less' class='styled-button-6' onclick='update($init, $num, $limitless)'>Show Less</button><noscript></a></noscript>";
  }
  if($limit>=$num){
    $more="<button id='more'  class='styled-button-6 hide' onclick='update($init, $num, $limitplus)'>Show More</button>";
  }
  else{
    $more="<noscript><a class='button_link' href=search.php?find=$find&table=$page&start=$start&finish=$finish&searching=yes&init=$init&limit=$limitplus&search=Search></noscript><button id='more'  class='styled-button-6' onclick='update($init, $num, $limitplus)'>Show More</button><noscript></a></noscript>";
  }

  if ($num<25) {
    echo"<p><span class='innerText'>Displaying $init1 - $num of $num entries</span></p>";
  }
  else{
    echo "<p>$less"."<span class='innerText'>Displaying $init1 - $thru of $num entries</span>$more</p>
 		$last$new$older$first<br><br>";
  }
}
function echoDisplay($init, $num, $page, $limit){
  $init1=$init+1;
  $plus=$init+$limit;
   if($plus>$num){
    $thru=$num;
  }
  else{
    $thru=$plus;
  }
  if ($num<25) {
    echo"";
  }

  else{
    echo"<p><span class='innerText'>Displaying $init1 - $thru of $num entries</span></p>";
  }
}
?>
