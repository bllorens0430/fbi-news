//hilights the proper nav link
(function(){
var page=location.pathname;
var list=document.getElementsByClassName('hilight');
//general highlighting function, uses nodes listed by class and compares href to desired href.
  function hilight(search, list){
    for (var i = list.length - 1; i >= 0; i--) {
      
      var node=list[i].childNodes[0];
      if (node.href.includes(search)) {
        node.id='current';
      };
     };
   };
//various cases
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
//If the current page is not a nav page, then assume in system somewhere
else{
    for (var i = list.length - 1; i >= 0; i--) {
      
      var node=list[i].childNodes[0];
      if (node.href.includes('content')) {
        node.id='current';
      }; 
     };
};
})();
