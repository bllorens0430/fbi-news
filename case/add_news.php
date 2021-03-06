<?php
  require("../session.php");
  require("../check.php");
  require("../common.php");
//  require("../common.php");

  $t = microtime(true);
  $micro = sprintf("%06d",($t - floor($t)) * 1000000);
  $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Add FBI News</title>
</head>

<body>

<div id="container">
  <?php include '../header2.php' ?>

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
<td> News Date (<span class='error'>mm.dd.yy</span>) </td>
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
<table>
<tr>
  <td>Crime Classification</td>
  <td>Techniques Used (use (<span class='error'>ctrl</span>) on windows and (<span class='error'>command</span>) on mac to select multiple options)</td>
</tr>
<tr>
  <td><input name="crime_classification" type="text" id="crime_classification" size="53" /></td>
  <td><select name="has_technique[]" multiple>
  <?php
  $sql="SELECT technique_name, technique_index FROM technique";
  $sth=$db->prepare($sql);
  if ($sth->execute()) {
      while($result=$sth->fetch(PDO::FETCH_ASSOC)){
        $id=strip_tags($result['technique_index']);
        $name=strip_tags($result['technique_name']);
        echo "<option value='$id'>$name</option>";
      }
    }
  ?>
  </select></td>
 </tr>
</table>
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
  <?php include '../footer.php' ?>
</div>


</body>
</html>
