<?php

require 'common.php';
require 'paging.php'
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
    echolinks($init, $num, 'categories', $limit);
  ?>
<table id='dbtable'>
	<tr>
		<th>Category</th>
	</tr>
  <?php
    getdata($init, $limit, 'crime_category', $db);
  ?>
</table>
<?php
    echolinks($init, $num, 'categories', $limit);
  ?>
</div>
<?php include 'footer.php' ?>
</div>
</body>
</html>
  <script src="js/hilightservice.js" type="text/javascript"></script>