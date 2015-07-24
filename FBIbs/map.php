<?php
include 'session.php';
include 'common.php';
include 'visualize.php';
include 'cat_forms.php';
//get # of rows in each table to pass to browsing pages.

//initialize an array with zero values for all the years in question.
$error='';
  if (isset($_POST['submit'])) {
    $begin=$_POST['begin'];
    $end=$_POST['end'];


    if(isset($_POST['cases'])){

        $array=array($_POST['cases']);
        $data= new visualize( $db, $array, '', $begin, $end);
         $data->set_map_plus();
        $mapdata= $data->map();

    }
    else{

       $array = array('all');
      $data= new visualize($db, $array, '', $begin, $end, 'all');
       $data->set_map_plus();
       $mapdata= $data->map();

    }
}
else{

       $begin=2003;
      $end=2015;
       $regres='';
        $array = array('all');
        $data= new visualize($db, $array, $regres, $begin, $end);
         $data->set_map_plus();
        $mapdata= $data->map( $begin, $end, $db, 'all');
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
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />--> />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

 <script type='text/javascript'>
   google.load('visualization', '1', {'packages': ['geochart']});
   google.setOnLoadCallback(drawMap);

    function drawMap() {

      var data = google.visualization.arrayToDataTable([

        <?php echo $mapdata; ?>

      ]);

      var options = {
        region: 'US',
        displayMode: 'regions',
        resolution: 'provinces',
        colorAxis: {colors: ['#D68533', '#CC6600', '#8F4700']},
        backgroundColor:{
                        fill: '#474747',
                        stroke: '#141414',
                        strokeWidth: 5}


      };

      var container = document.getElementById('map_canvas');
      var geomap = new google.visualization.GeoChart(container);
      geomap.draw(data, options);
    };

  </script>
</head>
<body>
<div class='container'>
 <?php include 'header.php' ?>

  <div id="content">
    <h2>FBI Cyber Crime News Location <?php echo$begin."-".$end; ?> (Data Fictitious)</h2>
      <div id="map_canvas"></div>
      <div id="chart_div"></div>
      <div id="donutchart"></div>
  <noscript><h3 class='error'>Uh oh, you need javascript enabled to use our site's Data Visualization!</h3></noscript>
  <form method='post' action='map.php'>
    <?php $data->get_error();
    echo $error; ?>
    <table id='vis-form'>
      <tr>
    <?php $data->get_dropdown(); ?>
  <td>
  <b>Cases</b><br>
       <?php
       if(isset($_POST['cases'])&&$_POST['cases']!='all'){
      echo "<input type='radio' name='cases' value ='all'> All Cases <br>";
    }
    else{
      echo "<input type='radio' name='cases' value ='all' checked> All Cases <br>";
    }
    ?>
  <button type='button' onclick='toggleCase("classifys", "dvwindow")' class='styled-button-srch'>Filter By Classification</button>
  <div class='classifys dvwindow hide'>
  <button type='button' onclick='toggleCase("classifys", "dvwindow")' class='styled-button-DV'>Hide</button>
  <?php
  $cat= new cats($db, $rad=True);
  $cat->cat();
   ?>
  </div>
</td>
<td>
    <input type='submit' name='submit'></input>
  </td>
  </tr>
</table>

  </form>
</div>
</div>
<?php include 'footer.php' ?>

<script src="js/hilightservice.js" type="text/javascript"></script>
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


<?php $data->db_close();
$db=null;
 ?>
