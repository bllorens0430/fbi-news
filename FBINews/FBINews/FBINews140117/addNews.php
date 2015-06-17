
	<?php
	require("check.php");
	
    $t = microtime(true);
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
    ?> 
    
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Add FBI News</title>
      </head>
      
      <body>
      <p><strong>FBI news input</strong></p>
      
      <form id="fbi-news" name="FBI News" method="post" action="index.php">
      <table> 
      <tr> 
      <td> News Index </td>
      <td> News Date </td>
      <td> News url </td>
      </tr>
      <tr>
      <td>
        <input name="news_index" type="text" id="news_index" size="42" value="<?php echo $d->format("Y-m-d H:i:s.u") ?>"/> </td>
        <td>
        <input name="news_date" type="text" id="news_date" size="42" /></td>
        <td><input name="news_url" type="text" id="news_url" size="42" /></td>
        </tr>
      </table>
      <p>News Title<br />
        <input name="news_title" type="text" id="news_title" size="128" />
      </p>
        
      <p>Crime<br />
        <textarea name="crime" id="crime" cols="128" rows="5" form="fbi-news"></textarea>
      </p>
      
      <p>Crime Classification<br />
        <input name="crime_classification" type="text" id="crime_classification" size="53" />
       </p>
       
      <p>Investigation<br />
        <textarea name="investigation" id="investigation" cols="128" rows="5" form="fbi-news"></textarea>
      </p>
      
      <p>Notes<br />
        <textarea name="notes" id="notes" cols="128" rows="5" form="fbi-news"></textarea>
      </p>
      <table>
      <tr>
      <td>
        <input type="submit" name="Add" value="Add" />
        </td>
        <td>
        <FORM><INPUT Type="button" VALUE="Cancel" onClick="history.go(-1);return true;"></FORM>
        </td>
      </tr>
      </table>
      </form>
      </body>
      </html>
