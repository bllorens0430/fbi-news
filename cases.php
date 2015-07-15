<?php
include 'session.php';
require 'common.php';
require 'paging.php';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
 <?php include 'header.php' ?>
 <div id="content">
<?php
  #this code is from paging.php and echos a table of cases
  #as well as the buttons to navigate through cases
  echolinks($init, $num, 'cases', $limit);
  getdata($init, $limit, 'cases', $db);
  echolinks($init, $num, 'cases', $limit);
?>
</div>
<?php include 'footer.php' ?>
</div>
  <script src="js/hilightservice.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/ajax.js">
  </script>
</body>
</html>

