(function(){
//different case for the service pages.
var list=document.getElementsByClassName('hilight');

 
    for (var i = list.length - 1; i >= 0; i--) {
      
      var node=list[i].childNodes[0];
      if (node.href.includes('service')) {
        node.id='current';
      }
      else{
        node.id='';
      };   
     };
})();
