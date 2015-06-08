<?php
  require("../session.php");
  require("../check.php");
//  require("../common.php");
  
  $t = microtime(true);
  $micro = sprintf("%06d",($t - floor($t)) * 1000000);
  $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<title>Add FBI News</title>
</head>

<body>

<div id="container">
  <div id="banner">
    <h1>Xinwen Fu</h1>
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li><a target="_blank" href="http://www.cs.uml.edu/~xinwenfu/">HOMEPAGE</a></li>
      <li><a href="../index.php">LOGIN</a></li>
      <li id="active"><a id="current" href="../content.php">SYSTEM</a></li>
      <li><a href="../resources.html">RESOURCES</a></li>
      <li><a href="../service.html">SERVICE</a></li>
      <li><a href="../contact.html">CONTACT</a></li>
    </ul>
  </div>


  <div id="content">


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
			} else 
			if(regs[2] < 1 || regs[2] > 31) {
				errorMsg = "Invalid value for month: " + regs[2];
			} else 
			if(regs[3] < minYear || regs[3] > maxYear) { 
				errorMsg = "Invalid value for year: " + regs[3] + " - must be between " + minYear + " and " + maxYear; 
			}
		} else { 
			errorMsg = "Invalid date format: " + field.value + "must be mm.dd.yy!" ; 
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

<p><strong>FBI news input</strong></p>

<form id="fbi-news" name="FBI News" method="post" action="view.php" onsubmit="return checkDate();">
<table> 
<tr> 
<td> News Index </td>
<td> News Date (<font color="red">mm.dd.yy</font>) </td>
<td> News url </td>
</tr>
<tr>
<td>
  <input name="news_index" type="text" id="news_index" size="30" value="<?php echo $d->format("Y-m-d H:i:s.u") ?>" readonly/> </td>
  <td>
  <input name="news_date" type="text" id="news_date" size="25" /></td>
  <td><input name="news_url" type="text" id="news_url" size="55" style="display:table-cell; width:100%"/></td>
  </tr>
</table>

<p>News Title<br />
  <input name="news_title" type="text" id="news_title" style="display:table-cell; width:100%" />
</p>
  
<p>Crime<br />
  <textarea name="crime" id="crime" cols="100" rows="5" form="fbi-news" style="display:table-cell; width:100%"></textarea>
</p>

<p>Crime Classification<br />
  <input name="crime_classification" type="text" id="crime_classification" size="53" />
 </p>
 
<p>Investigation<br />
  <textarea name="investigation" id="investigation" cols="100" rows="5" form="fbi-news" style="display:table-cell; width:100%"></textarea>
</p>

<p>Notes<br />
  <textarea name="notes" id="notes" cols="100" rows="5" form="fbi-news" style="display:table-cell; width:100%"></textarea>
</p>
<table>
<tr>
<td>
  <input type="submit" name="Add" value="Add" />
  </td>
</tr>
</table>
</form>

<form action="view.php">
  <input type="submit" value="Cancel">
</form>

  </div>
  <div id="container-foot">
    <div id="footer">
      <p><a href="http://www.cs.uml.edu/~xinwenfu/">homepage</a> | <a href="mailto:xinwenfu@gmail.com">contact</a> | &copy; 2015 Xinwen Fu<a rel="license" href="http://creativecommons.org/licenses/by/3.0/"></a></p>
    </div>
  </div>
</div>


</body>
</html>
