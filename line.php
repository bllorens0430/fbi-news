<?php
include 'session.php';
include 'common.php';
//get # of rows in each table to pass to browsing pages.

//initialize an array with zero values for all the years in question.
if (isset($_POST['submit'])) {
  $begin=$_POST['begin'];
  $end=$_POST['end'];
}
else{
$begin=2003;
$end=2015;
}
$datearr = array();
for ($i=$begin; $i <= $end ; $i++) { 
  $datearr[$i]=0;
}

//get the relevant data from the table
$sql=$db->prepare("SELECT crime_classification, news_date FROM cases  ORDER BY news_date");

  //these variables are going to be passed to a form to dynamically generate the first and last relevant years.
  //Note if it turns out cybercrim happened before 0 b.c. or after 3000, then these constants will need to be changed.
  $firstyear=3000;
  $lastyear=0;
if ($sql->execute()) {
  while($data=$sql->fetch(PDO::FETCH_ASSOC)){

    $date = htmlspecialchars($data['news_date']);
    $date=strval($date);
    $date=strtotime($date);
    $date = idate('Y', $date);

    if(isset($datearr[$date])){
    $datearr[$date]++;
  }

  if($date<$firstyear){
    $firstyear=$date;
  }
  if($date>$lastyear){
    $lastyear=$date;
  }

  }
}
$yeardropdown="";
for ($i=$firstyear; $i<=$lastyear; $i++) { 
  $yeardropdown.="<option value=$i>$i</option>";
}

//create a string full of data points for the chart
$graphdata="";
foreach ($datearr as $year => $count) {
  
  $graphdata.= "[$year,$count], ";  

}

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
      data.addColumn('number', 'X');
      data.addColumn('number', 'Cases');

      data.addRows([
      <?php echo $graphdata ?>
      ]);

      var options = {
        hAxis: {
          title: 'Year',
        },
        vAxis: {
          title: 'Cases',
        },
        colors: ['orange'],
        
       


      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
 </script>
</head>
<body>
<div id="container">
 <?php include 'header.php' ?>

  <div id="content">
    <h2>FBI Reported Cyber Crime Cases 2000-2015</h2>
      <div id="chart_div"></div>
	
  <form method='post' action='line.php'>
    Start Year
    <select name='begin'><?php echo $yeardropdown; ?></select><br>
    End Year
    <select name='end'><?php echo $yeardropdown; ?></select><br>
    <input type='submit' name='submit'></input>
  </form>
</div>
<?php include 'footer.php' ?>
</div>
</body>
</html>

<script src="js/hilightservice.js" type="text/javascript"></script>

