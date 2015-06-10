<?php

require 'common.php';

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
 <div id="content">
  <?php
$num=$_GET['count'];
  $init=intval($_GET['init']);
  if($init==0){
    $last='';
  }
  else{
    $minus=$init-25;
    $last="<a href='http://localhost:8888/HCISec/fbi-news/FBINews/categories.php?init=$minus&count=$num'>Last 25</a> <> ";
  }
  $init1=$init+1;
  $plus=$init+25;
  
  echo "<p>Displaying $init1 - $plus of $num entries</p>$last<a href='http://localhost:8888/HCISec/fbi-news/FBINews/categories.php?init=$plus&count=$num'>Next 25</a>";
  
?>
<table id='dbtable'>
	<tr>
		<th>Category</th>
	</tr>
  <?php
  
  $sql="SELECT * FROM crime_category LIMIT $init, 25";
   $count='evenrow';       
  foreach ($db->query($sql) as $cat)
  {
    if ($count=="oddrow") {
      $count="evenrow";
    }
    else{
      $count="oddrow";
    }
      $categg=htmlspecialchars($cat['cat_name'], ENT_QUOTES, 'UTF-8');
      $categg=str_replace('?', '', $categg);
      $categg=str_replace('&lt;b&gt;', '', $categg);
      $categg=str_replace('&lt;/b&gt;', '', $categg);
      $categg=str_replace('*', '', $categg);
      $id = $cat['cat_number'];
      echo "<tr class='$count'>";
      echo"<td><font color='black'>". $categg. "</font></td>";
      echo"<td><a href=show_cat.php?id=$id><button href=show_cat.php?id=$id>View</button></a></td>";
                          
      echo "</tr>";
  }
  $db=null;
  ?>
</table>
</div>
<?php include 'footer.php' ?>
</div>
</body>
</html>
  <script src="js/hilightservice.js" type="text/javascript"></script>