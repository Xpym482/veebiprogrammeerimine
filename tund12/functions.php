<?php
  require("../../../config.php");
  $database = "if18_maksim_je_1";
  
  //alustan sessiooni
  session_start();
  
  function readPreviousProfilePics($noId){
	$html = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename FROM vp_user_pictures3 WHERE userid=? AND id!= ? AND deleted IS NULL");
	echo $mysqli->error;
	$stmt->bind_param("ii", $_SESSION["userId"], $noId);
	$stmt->bind_result($filenameFromDb);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= '<img src="' .$GLOBALS["profilePicDir"] .$filenameFromDb .'" alt="Profiilipilt">' ."\n";
	}
	if(empty($html)){
		$html = "<p>Kahjuks profiilipilte pole!</p> \n";
	}
	
	$stmt->close();
	$mysqli->close();
	return $html;
  }
  
  function readAllPrivatePictureThumbsPage($page, $limit){
	$privacy = 3;
	$skip = ($page - 1) * $limit;
	$html = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, filename, alttext FROM vpphotos3 WHERE privacy=? AND userid=? AND deleted IS NULL LIMIT ?,?");
	echo $mysqli->error;
	$stmt->bind_param("iiii", $privacy, $_SESSION["userId"], $skip, $limit);
	$stmt->bind_result($idFromDb, $filenameFromDb, $altFromDb);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'" data-in="' . filenameFromDb. '" data-id="' . $idFromDb . '">' ."\n";
	}
	if(empty($html)){
		$html = "<p>Kahjuks pilte pole!</p> \n";
	}
	
	$stmt->close();
	$mysqli->close();
	return $html;  
  }
  
  function findTotalPrivateImages(){
	$privacy = 3;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM vpphotos3 WHERE privacy=? AND userid=? AND deleted IS NULL");
	$stmt->bind_param("ii", $privacy, $_SESSION["userId"]);
	$stmt->bind_result($imageCount);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$mysqli->close();
	return $imageCount;  
  }
  
  function findTotalPublicImages(){
	$privacy = 2;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM vpphotos3 WHERE privacy<=? AND deleted IS NULL");
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($imageCount);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$mysqli->close();
	return $imageCount;	
  }
  
  function readAllPublicPictureThumbsPage($page, $limit){
	$privacy = 2;
	$skip = ($page - 1) * $limit;
	$html = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos3 WHERE privacy<=? AND deleted IS NULL LIMIT ?,?");
	echo $mysqli->error;
	$stmt->bind_param("iii", $privacy, $skip, $limit);
	$stmt->bind_result($filenameFromDb, $altFromDb);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'" data-fn="' . $filenameFromDb.'">' ."\n";
	}
	if(empty($html)){
		$html = "<p>Kahjuks pilte pole!</p>";
	}
	
	$stmt->close();
	$mysqli->close();
	return $html;  
  }
  
  function readAllPublicPictureThumbs(){
	$privacy = 2;
	$html = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos3 WHERE privacy<=? AND deleted IS NULL");
	echo $mysqli->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($filenameFromDb, $altFromDb);
	$stmt->execute();
	
	while($stmt->fetch()){
	  $html .= '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">' ."\n";
	}
	if(empty($html)){
	  $html = "<p>Kahjuks pilte pole!</p> \n";
	}
	
	$stmt->close();
	$mysqli->close();
	return $html;
  }
  
  function latestPicture($privacy){
	$html = "<p>Pole pilti, mida näidata!";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos3 WHERE id=(SELECT MAX(id) FROM vpphotos3 WHERE privacy=? AND deleted IS NULL)");
	echo $mysqli->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($filenameFromDb, $altFromDb);
	$stmt->execute();
	if($stmt->fetch()){
		//<img src=" " alt="">
		//$GLOBALS["picDir"] .$filenameFromDb
		$html = '<img src="' .$GLOBALS["picDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">';
	}
	
	$stmt->close();
	$mysqli->close();
	return $html;
  }
  
  function addUserPhotoData($fileName){
	$addedId = null;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO vp_user_pictures3 (userid, filename) VALUES (?, ?)");
	echo $mysqli->error;
	$stmt->bind_param("is", $_SESSION["userId"], $fileName);
	if($stmt->execute()){
	  $addedId = $mysqli->insert_id;
	  //echo $addedId;
	} else {
	  echo $stmt->error;
	}
	return $addedId;
	$stmt->close();
	$mysqli->close();
  }
  
  function addPhotoData($fileName, $alt, $privacy){
    $notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO vpphotos3 (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
	echo $mysqli->error;
	$stmt->bind_param("issi", $_SESSION["userId"], $fileName, $alt, $privacy);
	if($stmt->execute()){
	  $notice = "Andmed lisati andmebaasi!";
	} else {
      echo "Foto lisamisel andmebaasi tekkis tehniline viga: " .$stmt->error;
	}
	
    $stmt->close();
	$mysqli->close();
    return $notice;
  }
  
  function readprofilecolors(){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($bgcolor, $txtcolor);
	$stmt->execute();
	$profile = new Stdclass();
	if($stmt->fetch()){
		$_SESSION["bgColor"] = $bgcolor;
		$_SESSION["txtColor"] = $txtcolor;
	} else {
		$_SESSION["bgColor"] = "#FFFFFF";
		$_SESSION["txtColor"] = "#000000";
	}
	$stmt->close();
	$mysqli->close();
  }
  
  //kasutajaprofiili salvestamine
  function storeuserprofile($desc, $bgcol, $txtcol, $picId){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($description, $bgcolor, $txtcolor);
	$stmt->execute();
	if($stmt->fetch()){
		//profiil juba olemas, uuendame
		$stmt->close();
		//kui on pilt lisatud
		if(!empty($picId)){
		  $stmt = $mysqli->prepare("UPDATE vpuserprofiles SET description=?, bgcolor=?, txtcolor=?, picture=? WHERE userid=?");
		  echo $mysqli->error;
		  $stmt->bind_param("sssii", $desc, $bgcol, $txtcol, $picId, $_SESSION["userId"]);
		} else {
		  $stmt = $mysqli->prepare("UPDATE vpuserprofiles SET description=?, bgcolor=?, txtcolor=? WHERE userid=?");
		  echo $mysqli->error;
		  $stmt->bind_param("sssi", $desc, $bgcol, $txtcol, $_SESSION["userId"]);
		}
		
		if($stmt->execute()){
			$notice = "Profiil edukalt uuendatud!";
			$_SESSION["bgColor"] = $bgcol;
		    $_SESSION["txtColor"] = $txtcol;
		} else {
			$notice = "Profiili uuendamisel tekkis tõrge! " .$stmt->error;
		}
	} else {
		//profiili pole, salvestame
		$stmt->close();
		//kui on pilt ka lisatud
		if(!empty($picId)){
		  $stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor, picture) VALUES(?,?,?,?,?)");
		  echo $mysqli->error;
		  $stmt->bind_param("isssi", $_SESSION["userId"], $desc, $bgcol, $txtcol, $picId);
		} else {
		  //INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)"
		  $stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
		  echo $mysqli->error;
		  $stmt->bind_param("isss", $_SESSION["userId"], $desc, $bgcol, $txtcol);
		}
		if($stmt->execute()){
			$notice = "Profiil edukalt salvestatud!";
			$_SESSION["bgColor"] = $bgcol;
		    $_SESSION["txtColor"] = $txtcol;
		} else {
			$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  //kasutajaprofiili väljastamine
  function showmyprofile(){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor, picture FROM vpuserprofiles WHERE userid=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($description, $bgcolor, $txtcolor, $picture);
	$stmt->execute();
	$profile = new Stdclass();
	if($stmt->fetch()){
		$profile->description = $description;
		$profile->bgcolor = $bgcolor;
		$profile->txtcolor = $txtcolor;
		$profile->pictureId = $picture;
		$profile->picture = "";
	} else {
		$profile->description = "";
		$profile->bgcolor = "";
		$profile->txtcolor = "";
		$profile->pictureId = null;
		$profile->picture = "";
	}
	$stmt->close();
	//kui on pilt olemas
	if(!empty($profile->pictureId)){
	  $stmt = $mysqli->prepare("SELECT filename FROM vp_user_pictures3 WHERE id=?");
	  echo $mysqli->error;
	  $stmt->bind_param("i", $profile->pictureId);
	  $stmt->bind_result($pictureFile);
	  $stmt->execute();
	  if($stmt->fetch()){
		$profile->picture = $pictureFile;  
	  }
	  $stmt->close();
	}
	$mysqli->close();
	return $profile;
  }
  
  function readallvalidatedmessagesbyuser(){
	$msghtml = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM vpusers");
	echo $mysqli->error;
	$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
	
	$stmt2 = $mysqli->prepare("SELECT message, valid FROM vpamsg WHERE validator=?");
	echo $mysqli->error;
	$stmt2->bind_param("i", $idFromDb);
	$stmt2->bind_result($msgFromDb, $validFromDb);
	
	$stmt->execute();
	$stmt->store_result();//jätab saadu pikemalt meelde, nii saab ka järgmine päring seda kasutada
	
	while($stmt->fetch()){
	  //panen valideerija nime paika
	  $msghtml .="<h3>" .$firstnameFromDb ." " .$lastnameFromDb ."</h3> \n";
	  $stmt2->execute();
	  while($stmt2->fetch()){
		$msghtml .= "<p><b>";
		if($validFromDb == 0){
		  $msghtml .= "Keelatud: ";
		} else {
		  $msghtml .= "Lubatud: ";
		}
		$msghtml .= "</b>" .$msgFromDb ."</p> \n";
	  }
	}
	$stmt->close();
	$stmt2->close();
	$mysqli->close();
	return $msghtml;
  }
  
  function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers WHERE id !=?");
	//$stmt = $mysqli->prepare("SELECT firstname, lastname, email, description FROM vpusers, vpuserprofiles WHERE vpuserprofiles.userid=vpusers.id");
	
	$mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $lastname, $email);
	//$stmt->bind_result($firstname, $lastname, $email, $description);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."</li> \n";
		  //$notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."<br>" .$description ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "<p>Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function allvalidmessages(){
	$html = "";
	$valid = 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE valid=? ORDER BY validated DESC");
	echo $mysqli->error;
	$stmt->bind_param("i", $valid);
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	if(empty($html)){
		$html = "<p>Kontrollitud sõnumeid pole.</p>";
	}
	return $html;
  }

function validatemsg($editId, $validation){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vpamsg SET validator=?, valid=?, validated=now() WHERE id=?");
	$stmt->bind_param("iii", $_SESSION["userId"], $validation, $editId);
	if($stmt->execute()){
	  echo "Õnnestus";
	  header("Location: validatemsg.php");
	  exit();
	} else {
	  echo "Tekkis viga: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
  }
  
  function readmsgforvalidation($editId){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
	$stmt->bind_param("i", $editId);
	$stmt->bind_result($msg);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = $msg;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function readallunvalidatedmessages(){
	$notice = "<ul> \n";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE valid IS NULL ORDER BY id DESC");
	echo $mysqli->error;
	$stmt->bind_result($id, $msg);
	$stmt->execute();
	
	while($stmt->fetch()){
		$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function signin($email, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
	echo $mysqli->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
	if($stmt->execute()){
		//kui päring õnnestus
	  if($stmt->fetch()){
		//kasutaja on olemas
		if(password_verify($password, $passwordFromDb)){
		  //kui salasõna klapib
		  $notice = "Logisite sisse!";
		  //määran sessioonimuutujad
		  $_SESSION["userId"] = $idFromDb;
		  $_SESSION["userFirstName"] = $firstnameFromDb;
		  $_SESSION["userLastName"] = $lastnameFromDb;
		  $_SESSION["userEmail"] = $email;
		  readprofilecolors();
		  //liigume kohe vaid sisselogitutele mõeldud pealehele
		  $stmt->close();
	      $mysqli->close();
		  header("Location: main.php");
		  exit();
		} else {
		  $notice = "Vale salasõna!";
		}
	  } else {
		$notice = "Sellist kasutajat (" .$email .") ei leitud!";  
	  }
	} else {
	  $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }//sisselogimine lõppeb
  
  //kasutaja salvestamine
  function signup($name, $surname, $email, $gender, $birthDate, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//kontrollime, ega kasutajat juba olemas pole
	$stmt = $mysqli->prepare("SELECT id FROM vpusers WHERE email=?");
	echo $mysqli->error;
	$stmt->bind_param("s",$email);
	$stmt->execute();
	if($stmt->fetch()){
		//leiti selline, seega ei saa uut salvestada
		$notice = "Sellise kasutajatunnusega (" .$email .") kasutaja on juba olemas! Uut kasutajat ei salvestatud!";
	} else {
		$stmt->close();
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
    	echo $mysqli->error;
	    $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	    $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	    $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	    if($stmt->execute()){
		  $notice = "ok";
	    } else {
	      $notice = "error" .$stmt->error;	
	    }
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }

  function saveAMsg($msg){
    $notice = ""; //see on teade, mis antakse salvestamise kohta
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
    echo $mysqli->error;
    $stmt->bind_param("s", $msg);//s - string, i - integer, d - decimal
    if ($stmt->execute()){
      $notice = 'Sõnum: "' .$msg .'" on salvestatud!';  
    } else {
	  $notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
    }
    $stmt->close();
    $mysqli->close();
    return $notice;
  }

  //funktsioon, mis loeb kõiki salvestatud sõnumeid (seda kutsub readmsg.php)
  function readallmessages(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
	echo $mysqli->error;
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$notice .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
     
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>



