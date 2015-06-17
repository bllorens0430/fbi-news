function page(init, num, limit){

	var sum=limit+init;
	var initplus = init+1;
	for (var i = 0; i <= num-1; i++) {
		var get= i;
		if(initplus<=get&&get<=sum){
			if(get%2==0){
				document.getElementById(get).className='evenrow';
			}
			else{
				document.getElementById(get).className='oddrow';
			};

		}
		else{
			if(get%2==0){
				document.getElementById(get).className='evenrow hide';
			}
			else{
				document.getElementById(get).className='oddrow hide';
			}
		};
	}
};

//shows and hides buttons and updates the buttons function values accordingly.
function getButtons(init, num, limit){

	//in case we are at the first entries
	if (init<0) {
		init=0;

	}

	//now we initialize various permutations of variables for the various functions of each button	
	var initplus=init+1;
	var sum=init+limit;
	var minus=init-limit;
	var more=limit+25;
	var less=limit-25;
	
	//now we handle edge cases, both for variable values and button visibility

	//find the last entries with regards to limit size
	var mod=num;
	while(mod%limit!=0){
		mod--;
	}

	

	//in case we are at the last entries
	if (sum>num) {
		sum=num;
	};

	//show/hide "Next"+"Last" button
	if (sum<num){
		document.getElementById('new').className="styled-button-6";
		document.getElementById('last').className="styled-button-6";
	}
	else{
		document.getElementById('new').className="styled-button-6 hide";
		document.getElementById('last').className="styled-button-6 hide";
	}

	//show/hide "Older"+"First" button
	if (init>0){
		document.getElementById('older').className="styled-button-6";
		document.getElementById('first').className="styled-button-6";
	}
	else{
		document.getElementById('older').className="styled-button-6 hide";
		document.getElementById('first').className="styled-button-6 hide";
	}

	//show/hide "Show Less" button
	if (limit>25){
		document.getElementById('less').className="styled-button-6";
	}
	else{
		document.getElementById('less').className="styled-button-6 hide";
	}

	//show/hide "Show More Button"
	if(limit>=num){
		document.getElementById('more').className="styled-button-6 hide";
	}
	else{
		document.getElementById('more').className="styled-button-6";
	}

	//update all button function values
	document.getElementById('less').onclick=function(){update(init, num, less);}
	document.getElementById('more').onclick=function(){update(init, num, more);}
	document.getElementById('new').onclick=function(){update(sum, num, limit);}
	document.getElementById('older').onclick=function(){update(minus, num, limit);}
	document.getElementById('first').onclick=function(){update(0, num, limit);}
	document.getElementById('last').onclick=function(){update(mod, num, limit);}

	//update text

	var list=document.getElementsByClassName('innerText')
	for (var i = 0; i < list.length; i++) {
		list[i].innerText="Displaying "+initplus+"-"+sum+" of "+num+" entries.";
	};
	

};