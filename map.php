<?php
include 'session.php';
include 'common.php';
include 'visualize.php';
include 'cat_rad.php';
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<div id="container">
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
  <?php cat_rad($db) ?>
  </div>
</td>
<td>
    <input type='submit' name='submit'></input>
  </td>
  </tr>
</table>

  </form>
</div>
<?php include 'footer.php' ?>
</div>
</body>
</html>

<script src="js/hilightservice.js" type="text/javascript"></script>
<script src="js/toggle.js" type="text/javascript"></script>
<?php $data->db_close();
$db=null;
 ?>
