<?php
include 'session.php';
include 'common.php';
include 'cat_forms.php';
include 'visualize.php';
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

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
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
  <input type='date' name='start' value='<?php  $dates->get_fy(); echo"-01-01";?>'
  And
  <input type='date' name= 'finish' value='<?php echo date('Y-m-d'); ?>'>
  <?php
if (!isset($_GET['noscript'])&&isset($_COOKIE['username'])) {
  $cat=new cats($db);
  echo"
  <div class = 'hidebutton'>
  <button type='button' onclick='toggleCase(".'"classifys", "bigwindow")'."' class='styled-button-srch'>Search By Classification</button>
  <div class='classifys bigwindow hide'>
  <button type='button' onclick='toggleCase(".'"classifys", "bigwindow")'."' class='styled-button-DV'>Hide</button>";
   $cat->cat();
   echo"
  </div>
  </div>";
}
  ?>
  <input type="hidden" name="searching" value="yes" />
  <input type="hidden" name="init" value="0" />
  <input type="hidden" name="limit" value="25" />
  <noscript> <input type="hidden" name="noscript" value="1" /> </noscript>
  <input type="submit" name="search" value="Search" />
  <?php if (isset($_GET['noscript'])||!isset($_COOKIE['username'])) {
  echo"<div id='multi'><p>Filter by Classification</p>";
  $cat = new cats($db, False, True);
  $cat->cat_multi();
  echo "<br><br></div>";
}?>
  </form>
    <h2>Data Visualization</h2>
    <p>Visualize what the FBI news is reporting on cyber crime. <a href='line2.php'> View Data Visualization </a></p>


    <h2>Crime Cases</h3>
    <p>Our database has compiled various cases of cyber crime from the FBI and
     other sources.
     <?php echo"<a id='cases' href='cases.php?init=0&count=$case_count&limit=25'>Browse Cases</a></p>" ?>

    <h2>Crime Techniques</h3>
    <p>There are various techniques to carry out cyber
      crime and corresponding defense mechanisms. Here is a list of some of them.

    <?php echo"<a id='techniques' href='techniques.php?init=0&count=$tech_count&limit=25'>Browse Techniques</a></p>" ?>

    <h2>Crime Categories</h3>
    <p>The categories used by the FBI may use a mix of cyber crime techniques.
      The categories are listed here for your convenience.
    <?php echo"<a id='classes' href='categories.php?init=0&count=$cat_count&limit=25'>Browse Categories</a></p>" ?>

  </div>
  <?php include 'footer.php' ?>
</div>
</body>
</html>

<script src="js/hilight.js" type="text/javascript"></script>
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

