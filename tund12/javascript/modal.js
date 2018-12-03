let modal;
let modalImg;
let captionText;
let span;
let photoid;
let photoDir = "../picuploads/";
console.log("Jama");

window.onload = function(){
	console.log("Hakkas peale");
  modal = document.getElementById("myModal");
  modalImg = document.getElementById("modalImg");
  captionText = document.getElementById("caption");
  span = document.getElementsByClassName("close")[0];
  let allThumbs = document.getElementById("gallery").getElementsByTagName("img");
  let thumbCount = allThumbs.length;
  for(let i = 0;i < thumbCount; i ++){
	allThumbs[i].addEventListener("click", openModal); 
	console.log(allThumbs[i].src);
  }
  span.addEventListener("click", closeModal);
  modalImg.addEventListener("click", closeModal);
  document.getElementById("storeRating").addEventListener("click", storeRating); 
}

function storeRating(){
	let rating = 0;
	for(let i = 1; i < 6; i++){
		if(document.getElementById("rate" + i).checked)	{
			rating = document.getElementById("rate" + i).value;
		}
	}
	if(rating > 0){
		//AJAX
		//loome uhenduse, paringu serverile
		let xmlhttp = new XMLHttpRequest();
		//soltuvalt paringu tulemusest tegusten
		xmlhttp.onreadystatechange = function() {
			if(this.readyState == 4 && this.status == 200){
				//kui paring onnestus ja tuli vastus, siis mida teha
				//paneme keskmise hinde hahtavale
				document.getElementById("avgRating").innerHTML = this.responseText;
			}
		}
		xmlhttp.open("GET", "savephotorating.php?id=" + photoid + "&rating=" + rating, true);
		xmlhttp.send();
	}
}

function openModal(e){
  console.log(e);
  modal.style.display = "block";
  modalImg.src = photoDir + e.target.dataset.fn;
  photoid = e.target.dataset.id;
  captionText.innerHTML = "<p>" + e.target.alt + "</p>";
}

function closeModal(){
  modal.style.display = "none";
}