<?php
include 'session.php';
include 'common.php';
include 'visualize.php';
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
  if(isset($_POST['cases'])&&$_POST['cases']=='2v3'){
      $array = array('1002', '1003' );
      $data= new visualize(2, $array, $regres, $begin, $end, $db ); 
      $lines=2;
  }
  else{
     $array = array('all');
    $data= new visualize(1, $array, $regres, $begin, $end, $db);
    $lines=1;
  }


}
else{
      $begin=2003;
      $end=2015;
       $regres='';
        $array = array('all');
        $data= new visualize(1, $array, $regres, $begin, $end, $db);
        $lines=1;
}

  $data->set_everything($regres);

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
      data.addColumn('number', 'Cases');
      <?php if($lines>1){
        echo "data.addColumn('number', '1003');";
      }
      ?>
      data.addColumn({type: 'string', role: 'tooltip', p: {'html': true}});

      data.addRows([
      <?php $data->get_mathdata();?>
      ]);

      var options = {
        tooltip: {isHtml: true},
        hAxis: {
          title: 'Year',
        },
        vAxis: {
          title: 'Cases',
        },
        colors: ['orange', 'blue'],
         <?php $data->get_regres(); ?>
        
        
     
  
      }
       

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);

//donut
       var data = google.visualization.arrayToDataTable([
            ['Year', 'Cases'],
           <?php $data->get_stringdata(); ?>
        ]);
 
        var options = {
          title: 'Case Percentage',
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
    <?php $data->get_dropdown(); ?>
  <td>
   <b> Regression</b><br>
    <input type='radio' name='regression' value='None' checked> none<br>
     <input type='radio' name='regression' value='linear' <?php $data->get_linear();?> > linear<br>
      <input type='radio' name='regression' value='polynomial' <?php  $data->get_poly();?> > polynomial<br>
       <input type='radio' name='regression' value='exponential' <?php  $data->get_exp();?> > exponential<br>
  </td>
  <td>
       <b>Cases</b><br>
       <input type='radio' name='cases' value ='all' checked> All Cases <br>
       <input type='radio' name='cases' value ='2v3'> 1002 vs 1003<br>
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

