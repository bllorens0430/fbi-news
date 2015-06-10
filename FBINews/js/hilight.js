(function(){
var page=location.pathname;
var list=document.getElementsByClassName('hilight');

  function hilight(search, list){
    for (var i = list.length - 1; i >= 0; i--) {
      
      var node=list[i].childNodes[0];
      if (node.href.includes(search)) {
        node.id='current';
      }
      else{
        node.id='';
      };   
     };
   };
if (page.includes('contact')) {
  hilight('contact', list);
}
else if (page.includes('content')) {
  hilight('content', list);
}
else if (page.includes('resources')) {
  hilight('resources', list);
}
else if (page.includes('service')) {
  hilight('service', list);
}
//If the current page is not a nav page
else{
    for (var i = list.length - 1; i >= 0; i--) {
      
      var node=list[i].childNodes[0];
      if (node.href.includes('content')) {
        node.id='current';
      }
      else{
        node.id='';
      };   
     };
};
})();
