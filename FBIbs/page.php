<?php
#>this php code is very similar to paging php and quite possibly could be merged into one
#>but paging php sets up browsing to use AJAX
#while page php sets up a page for using js that hides certain parts of the query
#>while this looks the same to the user the affect is inherently different
#>each approach also has different solutions for handling users with JS disabled
#>the reason for the different paging techniques is that browsing can easily
# be cut into bite size pieces and thus AJAX can make a small query every time
#searching however would require AJAX to fetch the entirety of the search results
#every time
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
  }
  else{
    $new="<noscript><a class='button_link' href='search.php?find=$find".htmlspecialchars('&')."table=$page".htmlspecialchars('&')."start=$start".htmlspecialchars('&')."finish=$finish".htmlspecialchars('&')."searching=yes".htmlspecialchars('&')."init=$plus".htmlspecialchars('&')."limit=$limit".htmlspecialchars('&')."search=Search'> > </a></noscript><button id='new' class='styled-button-6 unhideme' onclick='update($plus, $num, $limit)'> > </button>";
    $last="<noscript><a class='button_link' href='search.php?find=$find".htmlspecialchars('&')."table=$page".htmlspecialchars('&')."start=$start".htmlspecialchars('&')."finish=$finish".htmlspecialchars('&')."searching=yes".htmlspecialchars('&')."init=$mod".htmlspecialchars('&')."limit=$limit".htmlspecialchars('&')."search=Search'> >>> </a></noscript><button id='last' class='styled-button-6 unhideme' onclick='update($mod, $num, $limit)'> >>> </button>";
    $thru=$plus;
  }

  if($init==0){
    $older="<button id='older' class='styled-button-6 hide' onclick='update($minus, $num, $limit)'>".htmlspecialchars(' < ')."</button>";
    $first="<button id='first' class='styled-button-6 hide' onclick='update(0, $num, $limit)'>".htmlspecialchars(' <<< ')."</button>";
  }
  else{
     $first="<noscript><a class='button_link' href='search.php?find=$find".htmlspecialchars('&')."table=$page".htmlspecialchars('&')."start=$start".htmlspecialchars('&')."finish=$finish".htmlspecialchars('&')."searching=yes".htmlspecialchars('&')."init=0".htmlspecialchars('&')."limit=$limit".htmlspecialchars('&')."search=Search'>".htmlspecialchars(' <<< ')."</a></noscript><button id='first' class='styled-button-6 unhideme' onclick='update(0, $num, $limit)'>".htmlspecialchars(' <<< ')."</button>";
    $older="<noscript><a class='button_link' href='search.php?find=$find".htmlspecialchars('&')."table=$page".htmlspecialchars('&')."start=$start".htmlspecialchars('&')."finish=$finish".htmlspecialchars('&')."searching=yes".htmlspecialchars('&')."init=$minus".htmlspecialchars('&')."limit=$limit".htmlspecialchars('&')."search=Search'>".htmlspecialchars(' < ')."</a></noscript><button id='older' class='styled-button-6 unhideme' onclick='update($minus, $num, $limit)'>".htmlspecialchars(' < ')."</button>";
  }
  if ($limit==25) {
    $less="<button id='less' class='styled-button-6 hide' onclick='update($init, $num, $limitless)'>Show Less</button>";
  }
  else{
    $less="<noscript><a class='button_link' href='search.php?find=$find".htmlspecialchars('&')."table=$page".htmlspecialchars('&')."start=$start".htmlspecialchars('&')."finish=$finish".htmlspecialchars('&')."searching=yes".htmlspecialchars('&')."init=$init".htmlspecialchars('&')."limit=$limitless".htmlspecialchars('&')."search=Search'> Show Less </a></noscript><button id='less' class='styled-button-6 unhideme' onclick='update($init, $num, $limitless)'>Show Less</button>";
  }
  if($limit>=$num){
    $more="<button id='more'  class='styled-button-6 hide' onclick='update($init, $num, $limitplus)'>Show More</button>";
  }
  else{
    $more="<noscript><a class='button_link' href='search.php?find=$find".htmlspecialchars('&')."table=$page".htmlspecialchars('&')."start=$start".htmlspecialchars('&')."finish=$finish".htmlspecialchars('&')."searching=yes".htmlspecialchars('&')."init=$init".htmlspecialchars('&')."limit=$limitplus".htmlspecialchars('&')."search=Search'> Show More </a></noscript><button id='more'  class='styled-button-6 unhideme' onclick='update($init, $num, $limitplus)'>Show More</button>";
  }

  if ($num<25) {
    echo"<p><span class='innerText'>Displaying $init1 - $num of $num entries</span></p>";
  }
  else{
    echo "<p>$less"."<span class='innerText'>Displaying $init1 - $thru of $num entries</span>$more</p>
 		$first$older$new$last<br><br>";
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
