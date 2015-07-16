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
 <h2 id='browse'>Techniques</h2>
 <div id="content">

<?php
  echolinks($init, $num, 'technique', $limit);
  getdata($init, $limit, 'technique', $db);
  echolinks($init, $num, 'technique', $limit);
?>
</div>
<?php include 'footer.php' ?>
</div>
  <script src="js/hilightservice.js" type="text/javascript"></script>
  <script src="js/ajax.js" type="text/javascript"></script>
  <script type="text/javascript">
  unhide = document.getElementsByClassName('unhideme');
   for (var i = 0; i < unhide.length; i++) {
      unhide[i].className='styled-button-6';
     };
  </script>
</body>
</html>

