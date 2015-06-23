function toggleCase(caseClass){

	var boxArray=document.getElementsByClassName(caseClass);
	for (var i = 0; i < boxArray.length; i++) {
		console.log(boxArray[i]);
		if(boxArray[i].className==caseClass.concat(" miniwindow")){
			boxArray[i].className=caseClass.concat(" miniwindow hide");
		}
		else{
			boxArray[i].className=caseClass.concat(" miniwindow");
		}
	}
}
