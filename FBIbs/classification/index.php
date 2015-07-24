<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

  require("../session.php"); // start or resume a session
  require("../dotcheck.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  if(isset($_POST['Add']))
  {
	  $varCrimeClassification = $_POST['crime_classification'];
	  $varCatName = $_POST['cat_name'];
	  $varCatExplanation = $_POST['cat_explanation'];
	  $varNotes=$_POST['notes'];
	  $errorMessage = "";

	  $sql = "INSERT INTO crime_category
	  (crime_classification, cat_name, cat_explanation, notes)
	  VALUES (:crime_classification, :cat_name, :cat_explanation, :notes)";

	  $array_param=array(':crime_classification'=>addslashes($varCrimeClassification),
	  ':cat_name'=>addslashes($varCatName),
	  ':notes'=>addslashes($varNotes),
	  ':cat_explanation'=>addslashes($varCatExplanation));

	  $sth = $db->prepare($sql);
	  $sth->execute($array_param);
  //	$dbh=null;
  }

  if(isset($_POST['Update']))
  {
	$varCatNumber = $_POST['cat_number'];
	$varCrimeClassification = $_POST['crime_classification'];
	$varCatName = $_POST['cat_name'];
	$varCatExplanation = $_POST['cat_explanation'];
	$varNotes=$_POST['notes'];
	$errorMessage = "";

	$sql = "UPDATE crime_category SET crime_classification=:crime_classification, cat_name=:cat_name,
	cat_explanation=:cat_explanation,
	notes=:notes
	WHERE cat_number=:cat_number";

	$array_param=array(':cat_name'=>$varCatName,
	':crime_classification'=>intval($varCrimeClassification),
	':cat_explanation'=>$varCatExplanation,
	':notes'=>$varNotes,
	':cat_number' =>intval($varCatNumber));

	$sth = $db->prepare($sql);
	$sth->execute($array_param);
  //  $dbh=null;
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
    <link rel="icon" href="../favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../bootstrap-3.3.5-dist/css/hcisec.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../bootstrap-3.3.5-dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<title>Categories</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
</head>

<body>

<script type="text/javascript">
    function DeleteOrNot () {
    	     return confirm("Delete?");
        // return true or false, depending on whether you want to allow the `href` property to follow through or not
    }
</script>
<div class='container'>
  <?php include '../header2.php' ?>
  <div id='content'>
<table>
<tr>
<td>
<form action="add_cat.php">
  <input type="submit" value="Add">
</form>
</td>
<td>
<form action="../content.php">
  <input type="submit" value="Back">
</form>
</td>
<td>
 <form action="../logout.php">
  <input type="submit" value="Logout">
</form>
</td>
</tr>
</table>
<table class='table-striped'>
  <?php
  //include("dbo.php");

  $sql="SELECT * FROM crime_category ORDER BY crime_classification";

  echo "<tr>";
  echo"<th><b>ID</b></th>";
      echo"<th><b>Crime Classification</b></th>";
      echo"<th><b>Category Name</b></th><th></th><th></th>";
      echo "</tr>";
      $count="evenrow";
  foreach ($db->query($sql) as $test)
  {
	  $id=$test['cat_number'];
      if ($count=="oddrow") {
        $count="evenrow";
      }
      else{
        $count="oddrow";
      }
      echo "<tr class='$count'>";
      echo"<td>" .htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ."</td>";
      echo"<td>" . htmlspecialchars($test['crime_classification'], ENT_QUOTES, 'UTF-8') . "</td>";
	  $cat_name=htmlspecialchars($test['cat_name'], ENT_QUOTES, 'UTF-8');
	  $bold_cat_name=str_replace("&lt;/b&gt;", "</b>", str_replace("&lt;b&gt;", "<b>", $cat_name));
      echo"<td>" . $bold_cat_name . "</td>";
      echo"<td> <a href ='update_cat.php?cat_number=$id'>Edit</a>";
      echo"<td> <a href ='del_cat.php?cat_number=$id' onclick='return DeleteOrNot();'>Delete</a>";
//      echo "<td> <form onsubmit=' if (confirm(\" Delete? \")) {window.location.href=\" del_cat.php?cat_number=$id \";}; '><input type='submit' value='Delete'> </form>   </td>";

      echo "</tr>";
  }
  $db=null;
  ?>
</table>
<img alt='' src="2010_IC3Report_ComplaintCategoties.png">
</div>
</div>
<?php include '../footer.php';?>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
