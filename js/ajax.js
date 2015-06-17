function ajax(init, count, limit, table){
  var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
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
            document.getElementById("content").innerHTML = xmlhttp.responseText;
            }
          }
      xmlhttp.open("GET","pajax.php?init="+init+"&count="+count+"&limit="+limit+"&table="+table,true);
      xmlhttp.send();
 }