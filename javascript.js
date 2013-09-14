function showurl(){
	document.getElementById("validate-by-url").style.display= 'block';
	document.getElementById("validate-by-upload").style.display= 'none';
	document.getElementById("validate-by-zip").style.display= 'none';
	document.getElementById("validate-by-input").style.display= 'none';
}

function showfile(){
	document.getElementById("validate-by-url").style.display= 'none';
	document.getElementById("validate-by-upload").style.display= 'block';
	document.getElementById("validate-by-zip").style.display= 'none';
	document.getElementById("validate-by-input").style.display= 'none';
}

function showzip(){
	document.getElementById("validate-by-url").style.display= 'none';
	document.getElementById("validate-by-upload").style.display= 'none';
	document.getElementById("validate-by-zip").style.display= 'block';
	document.getElementById("validate-by-input").style.display= 'none';
}

function showinput(){
	document.getElementById("validate-by-url").style.display= 'none';
	document.getElementById("validate-by-upload").style.display= 'none';
	document.getElementById("validate-by-zip").style.display= 'none';
	document.getElementById("validate-by-input").style.display= 'block';
}

