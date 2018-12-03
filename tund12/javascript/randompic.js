window.onload = function(){
	ajaxrandompic();
	
}

function ajaxrandompic(){
	let xmlhttp = new XMLHttpRequest();
	//soltuvalt paringu tulemusest tegusten
	xmlhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200){
			//kui paring onnestus ja tuli vastus, siis mida teha
			//paneme keskmise hinde hahtavale
			document.getElementById("pic").innerHTML = this.responseText;
			}
		}
		xmlhttp.open("GET", "addrandomphoto.php", true);
		xmlhttp.send();
}