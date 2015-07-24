<?php include 'session.php'; include 'common.php';
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

<?php include 'footer.php' ?>

<div class='container'>
  <?php include 'header.php' ?>
</div>
<div class='container'>
    <div id='home'class="col-md-4">
      <div id='hometitle'>
      <h1>Cyber Crime Database</h1>
    <p>This is a secure website tracking FBI News on Cyber Crime managed by the <a href="http://ccf.cs.uml.edu/?q=node/113">HCI Security</a> initiative at <a href="http://www.uml.edu/Sciences/computer-science/default.aspx">UMass Lowell</a>.</p>
  </div>
    </div>
    <div id='floater'class="row">
    <div class="col-md-8">
    <h2>Data Visualization</h2>
    <p>Visualize what the FBI news is reporting on cyber crime. <a href='datavis.php'> View Data Visualization </a></p>


    <h2>Cyber Crime News</h3>
    <p>Our database has compiled various news stories of cyber crime from the FBI and
     other sources.
     <?php echo"<a id='cases' href='cases.php?init=0&count=$case_count&limit=25'>Browse News</a></p>" ?>

    <h2>Crime Techniques</h3>
    <p>These are various techniques to carry out cyber
      crime and corresponding defense mechanisms.

    <?php echo"<a id='techniques' href='techniques.php?init=0&count=$tech_count&limit=25'>Browse Techniques</a></p>" ?>

    <h2>Crime Categories</h3>
    <p>Our categorization system allows for useful classification of cyber crime cases and articles.
    <?php echo"<a id='classes' href='categories.php?init=0&count=$cat_count&limit=25'>Browse Categories</a></p>" ?>
    <h2>Search</h2>
     <form method="GET" action="search.php" onsubmit="return find" onchange="hidebutton()">
    Search for: <input type="text" name="find" /> in
    <Select NAME="table">
    <option VALUE="cases">Cases</option>
    <option VALUE="crime_category">Categories</option>
    <option VALUE="technique">Techniques</option>
    </Select>
     <?php
      $dates = new visualize($db=$db);
      $dates->set_year();
    ?>
    <span class = 'hidebutton'>
    <br>
    Between
    <input type='date' name='start' value='<?php  $dates->get_fy(); echo"-01-01";?>'>
    And
    <input type='date' name= 'finish' value='<?php echo date('Y-m-d'); ?>'>

      </span>
    <input type="hidden" name="searching" value="yes" />
    <input type="hidden" name="init" value="0" />
    <input type="hidden" name="limit" value="25" />
    <noscript> <input type="hidden" name="noscript" value="1" /> </noscript>
    <input type="submit" name="search" value="Search" />
      <?php
        if (!isset($_GET['noscript'])&&isset($_COOKIE['username'])) {
          $cat=new cats($db);
          echo"
        <span class='hidebutton'>
          <button type='button' onclick='toggleCase(".'"classifys", "bigwindow")'."' class='styled-button-srch'>Filter By Category</button></span>
          <div class='classifys bigwindow hide'>
          <button type='button' onclick='toggleCase(".'"classifys", "bigwindow")'."' class='styled-button-DV'>Hide</button>";
           $cat->cat();
           $cat=null;
           echo"
        ";
        }
    ?>
    <?php if (isset($_GET['noscript'])||!isset($_COOKIE['username'])) {
        echo"<div id='multi'><p>Filter by Category</p>";
        $cat = new cats($db, False, True);
        $cat->cat_multi();
        $cat=null;
        echo "<br><br></div>";
      }?>
    </form>
    </div>
    <div class="col-md-4">
      <h4>Favorite Links</h4>

    <p>Center for Internet Security and Forensics Education and Research (<a href="https://ccf.cs.uml.edu/">iSAFER</a>)</p>

  </div>


  </div>

<script src="js/hilight.js" type="text/javascript"></script>
<script src="js/toggle.js" type="text/javascript"></script>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
