<?php
require("../session.php"); // start or resume a session
require("../check.php"); // check if there is a session ongoing
require("../common.php"); // connect to the database

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Crime Category</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div id='container'>
    <?php include '../header2.php' ?>
    <div id='content'>
<form id="crime_cat" name="Crime Category" method="post" action="index.php">
  <p>
    Crime classification: 
    <input name="crime_classification" type="text" id="crime_classification" size="25" />
    Category Name:
    <input name="cat_name" type="text" id="cat_name" size="48" />
</p>
  <p>Category Explanation</p>
  <p>
    <textarea name="cat_explanation" id="cat_explanation" cols="120" rows="15"></textarea>
  </p>
  <p>Notes</p>
  <p>
    <textarea name="notes" id="notes" cols="120" rows="15"></textarea>
  </p>

<table>
<tr>
<td>
    <input type="submit" name="Add" value="Add" />
  </td>
    <td>
 <form action="index.php">
  <input type="submit" value="Cancel">
</td>
</tr>
</table>

</form>
</div>
<?php include '../footer.php' ?>
</div>
</body>
</html>