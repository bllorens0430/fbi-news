<?php
  require("check.php"); // check.php provides $db
  
  $id =$_REQUEST['case_index'];
  
  $sql = "SELECT * FROM cases WHERE case_index  = :case_index";
  $array_param=array(':case_index'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);
  $row = $sth->fetch();

  if (!$row) 
  {
	  die("Error: Data not found..");
  }

  $case_index=$row['case_index'] ;
//  $news_date= $row['news_date'] ;		
	$date = DateTime::createFromFormat('Y-m-d h:i:s', $row['news_date'] );
	$news_date=$date->format('m.d.y');
			
  $news_url= $row['news_url'] ;					
  $news_title=$row['news_title'] ;
  $crime=$row['crime'] ;
  $crime_classification=$row['crime_classification'] ;
  $investigation=$row['investigation'] ;
  $notes=$row['notes'] ;
  
  //mysql_close($db);
  $db=null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit News</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<script type="text/javascript">

 // Original JavaScript code by Chirp Internet: www.chirp.com.au
 // Please acknowledge use of this code by including this header. 
 function checkDate() { 
 	  var field=document.getElementById("news_date");
 	  var allowBlank = false; 
	  var minYear = 0; 
	  var maxYear = 99; 
	  
	  var errorMsg = "";   
	  
 	  // regular expression to match required date format 
 	  re = /^(\d{1,2}).(\d{1,2}).(\d{2})$/;   
	  
	  if(field.value != '') {
	  		 if(regs = field.value.match(re)) {
			 	   if(regs[1] < 1 || regs[1] > 12) {
				   	      	  errorMsg = "Invalid value for day: " + regs[1];
						  	     } else if(regs[2] < 1 || regs[2] > 31) {
							       	    	       errorMsg = "Invalid value for month: " + regs[2];
 									       		  } else if(regs[3] < minYear || regs[3] > maxYear) { 
											    	 	    errorMsg = "Invalid value for year: " + regs[3] + " - must be between " + minYear + " and " + maxYear; 
 													    	       }
															} else { 
															       errorMsg = "Invalid date format: " + field.value + " must be in this format mm.dd.yy!" ; 
															       		}
																	} else if(!allowBlank) {
																	  errorMsg = "Empty date not allowed!"; 
																	  }
																	   
 																	   if(errorMsg != "") { 
																	   	       alert(errorMsg); 
																		       			field.focus(); 
																						       return false; 
																						       } 
																						       
																						       return true;  
 }

</script>  

<form id="fbi-news" name="FBI News" method="post" action="view.php" onsubmit="return checkDate();">
<table> 
<tr> 
<td> News Index </td>
<td> News Date </td>
</tr>
<tr>
<td>
  <input name="news_index" type="text" id="news_index" size="42" 
  value="<?php echo $case_index ?>", readonly/> </td>
  <td>
  <input name="news_date" type="text" id="news_date" size="42" 
  value="<?php echo $news_date ?>"/></td>
  <td>
  <input name="news_url" type="text" id="news_url" size="42" 
  value="<?php echo $news_url ?>"/></td>
	  </tr>
</table>

<p>News Title<br />
  <input name="news_title" type="text" id="news_title" size="128" value="<?php echo $news_title ?>"/>
</p>
  
<p>Crime<br />
  <textarea name="crime" id="crime" cols="128" rows="5" form="fbi-news"><?php echo $crime ?></textarea>
</p>

<p>Crime Classification<br />
  <input name="crime_classification" type="text" id="crime_classification" size="53" value="<?php echo $crime_classification ?>"/>
 </p>
 
<p>Investigation<br />
  <textarea name="investigation" id="investigation" cols="128" rows="5" form="fbi-news"><?php echo $investigation ?></textarea>
</p>

<p>Notes<br />
  <textarea name="notes" id="notes" cols="128" rows="5" form="fbi-news"><?php echo $notes ?></textarea>
</p>  

  <table>
  <tr>
  <td>
	<input type="submit" name="Update" value="Update" />
	</td>
  </tr>
  </table>    
</form>

<form action="view.php">
<input type="submit" value="Cancel">
</form>      


</body>
</html>
