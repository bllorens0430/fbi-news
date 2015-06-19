<?php
include 'session.php';
include 'common.php';
//get # of rows in each table to pass to browsing pages.


$datearr = array(
      2000 => 0,
      2001 => 0,
      2002 => 0,
      2003 => 0,
      2004 => 0,
      2005 => 0,
      2006 => 0,
      2007 => 0,
      2008 => 0,
      2009 => 0,
      2010 => 0,
      2011 => 0,
      2012 => 0,
      2013 => 0,
      2014 => 0,
      2015 => 0

    );
$sql="SELECT crime_classification, news_date FROM cases  ORDER BY news_date";
foreach ($db->query($sql) as $data){

  $date = htmlspecialchars($data['news_date']);
  $date=strval($date);
  $date=strtotime($date);
  $date = idate('Y', $date);
  
  $datearr[$date]++;

}
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
      <div id="chart_div"><div>
	
</div>
</body>
</html>

<script src="js/hilight.js" type="text/javascript"></script>

