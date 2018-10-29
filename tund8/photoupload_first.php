<?php
  require("functions.php");
  //kui pole sisse loginud
  
  //kui pole sisselogitud
  if(!isset($_SESSION["userId"])){
	header("Location: index_3.php");
    exit();	
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location:  index_3.php");
	exit();
  }
  $pagetitle = "Fotode uleslaadimine";

   
	$target_dir = "../uploads/";
	var_dump($_FILES);
	$target_file = "";
	$uploadOk = 1;
	imageFileType = "";
	// Check if image file is a actual image or fake image
	//kas vajutatu submit nupp
	if(isset($_POST["submit"])) {
		//kas failinimi ka olemas on
		if(!empty($_FILES["fileToUpload"]["name"]){
		//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
		$timestamp = microtime(1) * 10000;
		//echo $timestamp;
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]) . "_" . $timestamp . "." . $imageFileType;
		
		//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		if (file_exists($target_file)) {// Check if file already exists
			echo "Kahjuks pilt juba olemas";
			$uploadOk = 0;
		}
		if ($_FILES["fileToUpload"]["size"] > 500000) {	// Check file size
			echo "Kahjuks fail liiga suur";
			$uploadOk = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {	// Allow certain file formats
			echo "Kahjuks on lubatud ainult JPG, JPEG, PNG & GIF";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		//maarame faili nime
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on ules laetud";
		} else {
			echo "Vabandame faili uleslaadimine ebaonnestus";
			}
		}
		
	} //kas on submit nupp vajutatud
	
	}//ega failinimi tuhi pole
	
	// Check if $uploadOk is set to 0 by an error
	


  require("header.php");
?>


	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p><a href="?logout=1">Logi välja!</a></p>
	<h2>Foto uleslaadimine</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label>Vali uleslaetav pilt:</label>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Lae pilt ules" name="submitpic">
	</form>
  </body>
</html>