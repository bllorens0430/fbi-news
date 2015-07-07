function toggleCase(caseClass, window){
	if (typeof(window)==='undefined') window = 'miniwindow';
	var boxArray=document.getElementsByClassName(caseClass);
	for (var i = 0; i < boxArray.length; i++) {
		if(boxArray[i].className==caseClass.concat(" ").concat(window)){
			boxArray[i].className=caseClass.concat(" ").concat(window).concat(" hide");
		}
		else{
			boxArray[i].className=caseClass.concat(" ").concat(window);
		}
	}
}

