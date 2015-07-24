<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

require("../session.php"); // start or resume a session
require("../dotcheck.php"); // check if there is a session ongoing
require("../common.php"); // connect to the database

if(isset($_POST['Add']))
{
	$varTechIndex = $_POST['tech_index'];
	$varTechName = $_POST['tech_name'];
	$varTechcat = $_POST['tech_cat'];
	$varTechDetails = $_POST['tech_details'];
	$varTechRefs = $_POST['tech_refs'];
	$varTechNotes = $_POST['tech_notes'];
	$errorMessage = "";

	$sql = "INSERT INTO technique (technique_index, technique_name, technique_category,
	technique_details, technique_url, notes)
	VALUES (:tech_index, :tech_name, :tech_cat, :tech_details, :tech_refs, :tech_notes)";

	$array_param=array(':tech_index'=>addslashes($varTechIndex),
	':tech_name'=>addslashes($varTechName),
	':tech_cat'=>intval($varTechcat),
	':tech_details'=>addslashes($varTechDetails),
	':tech_refs'=>addslashes($varTechRefs),
	':tech_notes' =>addslashes($varTechNotes));

	$sth = $db->prepare($sql);
	$sth->execute($array_param);
//	$dbh=null;
}

if(isset($_POST['Update']))
{
	$varTechIndex = $_POST['tech_index'];
	$varTechName = $_POST['tech_name'];
	$varTechcat = $_POST['tech_cat'];
	$varTechDetails = $_POST['tech_details'];
	$varTechRefs = $_POST['tech_refs'];
	$varTechNotes = $_POST['tech_notes'];
	$errorMessage = "";

	$sql = "UPDATE technique SET technique_name=:tech_name,
	technique_category=:tech_cat, technique_details=:tech_details, technique_url=:tech_refs, notes=:tech_notes
	WHERE technique_index=:tech_index";

	$array_param=array(':tech_index'=>$varTechIndex,
	':tech_name'=>$varTechName,
	':tech_cat'=>intval($varTechcat),
	':tech_details'=>$varTechDetails,
	':tech_refs'=>$varTechRefs,
	':tech_notes' =>$varTechNotes);

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
<title>Techniques</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
<title>View News</title>
</head>

<body>

<script type="text/javascript">
    function DeleteOrNot () {
             return confirm("Delete?");
        // return true or false, depending on whether you want to allow the `href` property to follow through or not
    }
</script>

<script>
function goBack() {
    window.history.back()
}
</script>


<div class='container'>
  <?php include '../header2.php' ?>
  <div id="content">
<table>
<tr>
<td>
<form action="add_tech.php">
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

  $sql="SELECT * FROM technique";
   $count='evenrow';
  echo"<tr><th style='display:none;' >Id</th><th>Technique</th><th>Category</th><th></th><th></th></tr>";
  foreach ($db->query($sql) as $test)
  {
    if ($count=="oddrow") {
      $count="evenrow";
    }
    else{
      $count="oddrow";
    }
      $id= str_replace(' ', '', $test['technique_index']);
      echo "<tr class='$count' >";
      echo"<td style='display:none;'>" .htmlspecialchars($test['technique_index'], ENT_QUOTES, 'UTF-8')."</td>";
      echo"<td>". htmlspecialchars($test['technique_name'], ENT_QUOTES, 'UTF-8'). "</td>";
      echo"<td>". htmlspecialchars($test['technique_category'], ENT_QUOTES, 'UTF-8'). "</td>";
      echo"<td> <a href ='update_tech.php?tech_index=$id'>Edit</a>";
      echo"<td> <a href ='del_tech.php?tech_index=$id' onclick='return DeleteOrNot();'>Delete</a>";

      echo "</tr>";
  }
  $db=null;
  ?>
</table>

  </div>
  <?php include '../footer.php'; ?>
</div>

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
