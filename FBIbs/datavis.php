<?php
include 'session.php';
include 'common.php';
include 'visualize.php';
include 'cat_forms.php';
//get # of rows in each table to pass to browsing pages.

//initialize an array with zero values for all the years in question.

if (isset($_POST['submit'])) {
  $begin=$_POST['begin'];
  $end=$_POST['end'];
  if(isset($_POST['regression'])){
    $regres=$_POST['regression'];
  }
  else{
    $regres='';
  }
  if(isset($_POST['cases'])){
      $array=$_POST['cases'];
      $data= new visualize($db, $array, $regres, $begin, $end);
      $lines=count($array);
  }
  else{
     $array = array('all');
    $data= new visualize($db, $array, $regres, $begin, $end);
    $lines=1;
  }


}
else{
      $begin=2003;
      $end=2015;
       $regres='';
        $array = array('all');
        $data= new visualize($db, $array, $regres, $begin, $end);
        $lines=1;
}


    $data->set_regres($regres);
    $data->set_cat_names();
    $data->set_sql();
    $data->set_year();

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
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

 <script type="text/javascript">
google.load('visualization', '1', {packages: ['corechart', 'line']});
google.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Year');

        <?php if($lines>1){
          for ($i=0; $i < $lines; $i++) {
            echo "data.addColumn('number', '$i');
            data.addColumn({type: 'string', role: 'tooltip', p: {'html': true}});";
          }
      }
      else{
        echo "data.addColumn('number', 'Cases');
        data.addColumn({type: 'string', role: 'tooltip', p: {'html': true}});";
      }
      ?>

      data.addRows([
      <?php
      $data->set_line();
      $data->get_mathdata();
      $data->kill_line();
      ?>
      ]);

      var options = {
        legend: 'none',
        tooltip: {isHtml: true},
        hAxis: {
          title: 'Year',
        },
        vAxis: {
          title: 'Cases',
        },

         <?php $data->get_regres();?>




      }


      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);

//donut
       var data = google.visualization.arrayToDataTable([
            ['Year', 'Cases'],
           <?php
           $data->set_pie();
           $data->get_stringdata();
           $data->kill_pie();
            ?>
        ]);

        var options = {
          title: 'Case Percentage',
          legend: {isHtml: true},
          pieSliceText: 'none',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    };
 </script>
</head>
<body>
<div class='container'>
 <?php include 'header.php' ?>

  <div id="content">
    <h2>FBI Cyber Crime News <?php echo$begin."-".$end; ?></h2>
      <div id="chart_div"></div>
      <div id="donutchart"></div>
    <noscript><h3 class='error'>Uh oh, you need javascript enabled to use our site's Data Visualization!</h3></noscript>
<div class='container'>
<div id='vis-form' class='row'>
  <form method='post' action='datavis.php'>
    <?php $data->get_error(); ?>
<div class='col-md-2'>
    <?php
          $data->set_dropdown();
          $data->get_dropdown();
          $data->kill_dropdown();
          $data->kill_the_cat();
       ?>
</div>
<div class='col-md-2'>
   <b> Regression</b><br>
    <input type='radio' name='regression' value='None' checked> none<br>
     <input type='radio' name='regression' value='linear' <?php $data->get_linear();?> > linear<br>
      <input type='radio' name='regression' value='polynomial' <?php  $data->get_poly();?> > polynomial<br>
       <input type='radio' name='regression' value='exponential' <?php  $data->get_exp();?> > exponential<br>
</div>
<div class='col-md-2'>
<b>Cases</b><br>
       <?php
       if(isset($_POST['cases'])&&!in_array('all', $_POST['cases'])){
      echo "<input type='checkbox' name='cases[]' value ='all'> All Cases <br>";
    }
    else{
      echo "<input type='checkbox' name='cases[]' value ='all' checked> All Cases <br>";
    }
    ?>
  <button type='button' onclick='toggleCase("classifys", "dvwindow")' class='styled-button-srch'>Filter By Classification</button>
  <div class='classifys dvwindow hide'>
  <button type='button' onclick='toggleCase("classifys", "dvwindow")' class='styled-button-DV'>Hide</button>
  <?php
  $cat=new cats($db);
  $cat->cat();
  $cat=null;
   ?>
  </div>

<div class='col-md-2'>

    <input type='submit' name='submit'>

</div>

  </form>
</div>
</div>
</div>
</div>


<?php include 'footer.php' ?>
<script src="js/hilight.js" type="text/javascript"></script>
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
