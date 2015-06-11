<?php

require 'common.php';
require 'paging.php';

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
  echolinks($init, $num, 'techniques');
?>
<table id='dbtable'>
	<tr>
		<th>Technique</th>
		<th>Category</th>
	</tr>
  <?php
    getdata($init, 25, 'technique', $db)
  ?>
</table>
<?php
  echolinks($init, $num, 'techniques');
?>
</div>
<?php include 'footer.php' ?>
</div>
</body>
</html>
  <script src="js/hilightservice.js" type="text/javascript"></script>