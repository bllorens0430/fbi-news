<?php
if(isset($_GET['msg'])){
$msg=$_GET['msg'];
echo "dshfsd";
}
?>
<button onclick='ajax()'>
Click
</button>
<script>
  
function ajax(){
	
  var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  alert('hiya');
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		   xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				    {
				    alert(xmlhttp.responseText);
				    }
				  }
		  xmlhttp.open("GET","dumb.php?msg='hi'",true);
		  //xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		  //xmlhttp.send("message='HI'");
		  xmlhttp.send();
 }
  </script>