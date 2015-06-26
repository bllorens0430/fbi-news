<?php
include 'session.php';
include 'common.php';
include 'visualize.php';
include 'cat_box.php';
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
      $data= new visualize( $array, $regres, $begin, $end, $db );
      $lines=count($array);
  }
  else{
     $array = array('all');
    $data= new visualize( $array, $regres, $begin, $end, $db);
    $lines=1;
  }


}
else{
      $begin=2003;
      $end=2015;
       $regres='';
        $array = array('all');
        $data= new visualize( $array, $regres, $begin, $end, $db);
        $lines=1;
}


    $data->set_regres($regres);
    $data->set_cat_names();
    $data->set_sql();
    $data->set_year();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
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
<div id="container">
 <?php include 'header.php' ?>

  <div id="content">
    <h2>FBI Reported Cyber Crime Cases <?php echo$begin."-".$end; ?></h2>
      <div id="chart_div"></div>
      <div id="donutchart"></div>

  <form method='post' action='line2.php'>
    <?php $data->get_error(); ?>
    <table id='vis-form'>
      <tr>
    <?php
          $data->set_dropdown();
          $data->get_dropdown();
          $data->kill_dropdown();
          $data->kill_the_cat();
       ?>
  <td>
   <b> Regression</b><br>
    <input type='radio' name='regression' value='None' checked> none<br>
     <input type='radio' name='regression' value='linear' <?php $data->get_linear();?> > linear<br>
      <input type='radio' name='regression' value='polynomial' <?php  $data->get_poly();?> > polynomial<br>
       <input type='radio' name='regression' value='exponential' <?php  $data->get_exp();?> > exponential<br>
  </td>

<td>
    <input type='submit' name='submit'></input>
  </td>
  </tr>
</table>
       <b>Cases</b><br>
       <?php cat_box($db); ?>

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
