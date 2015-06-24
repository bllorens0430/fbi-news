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
        $data= new visualize( $array, '', $begin, $end, $db ); 
         $data->set_map_plus();
        $mapdata= $data->map();

    }
    else{

       $array = array('all');
      $data= new visualize( $array, '', $begin, $end, $db, 'all');
       $data->set_map_plus();
       $mapdata= $data->map();

    }
}
else{

       $begin=2003;
      $end=2015;
       $regres='';
        $array = array('all');
        $data= new visualize($array, $regres, $begin, $end, $db);
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
    <h2>FBI Reported Cyber Crime Cases <?php echo$begin."-".$end; ?></h2>
      <div id="map_canvas"></div>
      <div id="chart_div"></div>
      <div id="donutchart"></div>
	
  <form method='post' action='map.php'>
    <?php $data->get_error();
    echo $error; ?>
    <table id='vis-form'>
      <tr>
    <?php $data->get_dropdown(); ?>
 
<td>
    <input type='submit' name='submit'></input>
  </td>
  </tr>
</table>
       <b>Cases</b><br>
       <?php cat_rad($db); ?>

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
