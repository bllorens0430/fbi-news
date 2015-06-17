	<?php
	require("check.php");
			
    if(isset($_POST['Add']))
    {
        $varNewsIndex = $_POST['news_index'];
        $varNewsTitle = $_POST['news_title'];
        $varNewsUrl = $_POST['news_url'];
        $varNewsDate = $_POST['news_date'];
        $varCrime = $_POST['crime'];
        $varCrimeClassification = $_POST['crime_classification'];
        $varInvestigation = $_POST['investigation'];
	    $varNotes = $_POST['notes'];
        $errorMessage = "";
        
        include 'db.php';
        
        $sql = "INSERT INTO cases (case_index, news_date, news_title, news_url, crime, crime_classification, investigation, notes) VALUES (".
           "'" . addslashes($varNewsIndex) . "'" . ", " .
           "'" . addslashes($varNewsDate) . " 00:00:00" ."'" . ", " .
           "'" . addslashes($varNewsTitle) . "'" . ", " .
           "'" . addslashes($varNewsUrl) . "'" . ", " .
           "'" . addslashes($varCrime) . "'" . ", " .
           $varCrimeClassification . ", " .
           "'" . addslashes($varInvestigation) . "'" . ", " .
		   "'" . addslashes($varNotes) . "'" . ")";
    
         # echo $sql;
          mysql_query($sql);
    }
    
    if(isset($_POST['Update']))
    {	
    $varNewsIndex = $_POST['news_index'];
    $varNewsTitle = $_POST['news_title'];
    $varNewsUrl = $_POST['news_url'];
    $varNewsDate = $_POST['news_date'];
    $varCrime = $_POST['crime'];
    $varCrimeClassification = $_POST['crime_classification'];
    $varInvestigation = $_POST['investigation'];
    $varNotes = $_POST['notes'];
    $errorMessage = "";
      
      include 'db.php';
     
      $sql = "UPDATE cases SET news_date="."'" . addslashes($varNewsDate) . " 00:00:00" ."'" . ", " .
      "news_title="."'" . addslashes($varNewsTitle) . "'" . ", " .
	  "news_url="."'" . addslashes($varNewsUrl) . "'" . ", " .
      "crime="."'" . addslashes($varCrime) . "'" . ", " .
      "crime_classification=". $varCrimeClassification . ", " .
      "investigation="."'" . addslashes($varInvestigation) . "'". ", " .
	  "notes="."'" . addslashes($varNotes) . "'". 
      " WHERE case_index="."'" . $varNewsIndex . "'";
    
    #      echo $sql;
		        mysql_query($sql);	
    }
    ?> 
    
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>View News</title>
    </head>
    
    <body>
    <table>
    <tr>
    <td>
    <form action="addNews.php">
      <input type="submit" value="Add">
    </form>
    </td>
    <td>
     <form action="logout.php">
      <input type="submit" value="Logout">
    </form>
    </td>
    </tr>
    </table>
    <table border="1">
      
              <?php
              include("db.php");
      
              $result=mysql_query("SELECT * FROM cases");
              
              while($test = mysql_fetch_array($result))
              {
                  $id = $test['case_index'];	
                  echo "<tr align='center'>";	
                  echo"<td><font color='black'>" .$test['case_index']."</font></td>";
                  echo"<td><font color='black'>" .$test['news_date']."</font></td>";
                  echo"<td><font color='black'>". $test['news_title']. "</font></td>";
                  echo"<td> <a href ='update.php?case_index=$id'>Edit</a>";
                  echo"<td> <a href ='del.php?case_index=$id'><center>Delete</center></a>";
                                      
                  echo "</tr>";
              }
              mysql_close($db);
              ?>
    </table>
    
    </body>
    </html>
    
