<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  if(isset($_POST['Add']))
  {
	  $varNewsIndex = $_POST['news_index'];
	  $varNewsTitle = $_POST['news_title'];
	  $varNewsUrl = $_POST['news_url'];
	  # The DATE type is used for values with a date part but no time part.
	  # MySQL retrieves and displays DATE values in 'YYYY-MM-DD' format.
	  # The supported range is '1000-01-01' to '9999-12-31'.
	  # The DATETIME type is used for values that contain both date and time parts.
	  # MySQL retrieves and displays DATETIME values in 'YYYY-MM-DD HH:MM:SS' format.
	  # The supported range is '1000-01-01 00:00:00' to '9999-12-31 23:59:59'.
	  $varNewsDate = $_POST['news_date'];
	  $varCrime = $_POST['crime'];
	  $varCrimeClassification = $_POST['crime_classification'];
	  $varInvestigation = $_POST['investigation'];
	  $varNotes = $_POST['notes'];
	  $errorMessage = "";

	  $sql = "INSERT INTO cases (case_index, news_date, news_title, news_url,
	  crime, crime_classification, investigation, notes)
	  VALUES (:case_index, :news_date, :news_title, :news_url, :crime,
	  :crime_classification, :investigation, :notes)";


	  // Returns a string with backslashes before characters that need to be escaped.
	  // These characters are single quote ('), double quote ("),
	  // backslash (\) and NUL (the NULL byte).
	  $date = DateTime::createFromFormat('m.d.y', addslashes($varNewsDate));
	  $array_param=array(':case_index'=>addslashes($varNewsIndex),
	  ':news_date'=>$date->format('Y-m-d'),
	  ':news_title'=>addslashes($varNewsTitle),
	  ':news_url'=>addslashes($varNewsUrl),
	  ':crime' =>addslashes($varCrime),
	  ':crime_classification' => intval($varCrimeClassification),
	  ':investigation'=>addslashes($varInvestigation),
	  ':notes'=>addslashes($varNotes));

	  $sth = $db->prepare($sql);
	  $sth->execute($array_param);

    if(isset($_POST['has_technique'])){

      foreach($_POST['has_technique'] as $technique ){
        $sql="INSERT INTO cases_has_technique (cases_case_index, technique_technique_index) VALUES (:case_index, :tech_index)";
        $tech_array=array(':case_index'=>addslashes($varNewsIndex),':tech_index'=>addslashes($technique));
        $sth = $db->prepare($sql);
        $sth->execute($tech_array);
      }
    }
  //	$dbh=null;
  }

  if(isset($_POST['Update']))
  {
	$varNewsIndex = $_POST['news_index'];
	$varNewsTitle = $_POST['news_title'];
	$varNewsUrl = $_POST['news_url'];
	$varNewsDate = $_POST['news_date'];
	$varCrime = $_POST['crime'];
	$varCrimeClassification = $_POST['crime_classification'];
	$varInvestigation = $_POST['investigation'];
	$varNotes = $_POST['notes'];
	$errorMessage = "";


	$sql = "UPDATE cases SET news_date=:news_date, news_title=:news_title,
	news_url=:news_url, crime=:crime, crime_classification=:crime_classification,
	investigation=:investigation, notes=:notes
	WHERE case_index=:case_index";

	$date = DateTime::createFromFormat('m.d.y', addslashes($varNewsDate));
	$array_param=array(':case_index'=>addslashes($varNewsIndex),
	':news_date'=>$date->format('Y-m-d'),
	':news_title'=>addslashes($varNewsTitle), // date( 'm.d.y', $phpdate )
	':news_url'=>addslashes($varNewsUrl),
	':crime' =>addslashes($varCrime),
	':crime_classification' => intval($varCrimeClassification),
	':investigation'=>addslashes($varInvestigation),
	':notes'=>addslashes($varNotes));

	$sth = $db->prepare($sql);
	$sth->execute($array_param);
  //  $dbh=null;
  if(isset($_POST['has_technique'])){
        $sql="DELETE FROM cases_has_technique WHERE cases_case_index=:case_index";
        $del_array=array(':case_index'=>addslashes($varNewsIndex));
        $sth = $db->prepare($sql);
        $sth->execute($del_array);


      foreach($_POST['has_technique'] as $technique ){
        $sql="INSERT INTO cases_has_technique (cases_case_index, technique_technique_index) VALUES (:case_index, :tech_index)";
        $tech_array=array(':case_index'=>addslashes($varNewsIndex),':tech_index'=>addslashes($technique));
        $sth = $db->prepare($sql);
        $sth->execute($tech_array);
      }
    }
  }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>View News</title>
</head>

<body>

<script type="text/javascript">
    function DeleteOrNot () {
             return confirm("Delete?");
        // return true or false, depending on whether you want to allow the `href` property to follow through or not
    }
</script>

<div id="container">
  <?php include '../header2.php' ?>


  <div id="content">

<table>
<tr>
<td>
<form action="add_news.php">
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
<table id='dbtable'>
  <?php
  $sql="SELECT * FROM cases ORDER BY news_date DESC";
  $count="evenrow";
  echo "<tr><th style='display:none;' ></th><th>Date</th><th>Story</th><th></th><th></th></tr>";
  foreach ($db->query($sql) as $test)
  {
	$date = DateTime::createFromFormat('Y-m-d h:i:s', $test['news_date']);

	// In (X)HTML, attribute values should be enclosed by double or single quotes.
	// But a common source of errors and confusion arises
	// when those values themselves contain double or single quotes.
	// This is especially common for form input fields,
	// where the values might contain data obtained from a database
	// or supplied previously by the user. After encoding by htmlspecialchars,
	// although "O'Reilly" is now not in its literal form in the HTML code,
	// it will be displayed and sent properly from a form on an HTML page as seen in a browser
	if ($count=="oddrow") {
		$count="evenrow";
	}
	else{
		$count="oddrow";
	}
	$id =str_replace(' ', '',  $test['case_index']);
	echo "<tr class='$count'>";
	echo"<td style='display:none;'>" .htmlspecialchars(stripslashes($test['case_index']), ENT_QUOTES, 'UTF-8')."</td>";
	echo"<td>" . $date->format('m.d.y') . "</td>";
	echo"<td> <a target='_blank' href='".htmlspecialchars(stripslashes($test['news_url']), ENT_QUOTES, 'UTF-8')."'>" . htmlspecialchars(stripslashes($test['news_title']), ENT_QUOTES, 'UTF-8'). "</a></td>";
	echo"<td> <a href ='update.php?case_index=$id'>Edit</a>";
	echo"<td> <a href ='del.php?case_index=$id' onclick='return DeleteOrNot();'>Delete</a>";

	echo "</tr>";
  }
  $db=null;
  ?>
</table>

  </div>
  <?php include '../footer.php' ?>
</div>

</body>
</html>
