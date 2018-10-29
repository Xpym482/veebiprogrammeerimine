<?php
require("../../../config.php");
//echo $GLOBALS["serverhost"];
$database = "if18_maksim_je_1";

function signup($name, $surname, $email, $gender, $birthDate, $password)
{
	
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"],  $GLOBALS["serverpassword"],  $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO vpuseradd (firstname, surname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
	echo $mysqli->error;
	//krupteerin parooli, kasutades juhusliku soolamisfraasi (salting string);
	$options = [
	"cost" => 12, 
	"salt" => substr(sha1(rand()), 0, 22),
	];
	var_dump($options);
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	$stmt->bind_param("sssiss", $name, $surname, $email, $gender, $birthDate, $pwdhash);
	if($stmt->execute()){
		$notice = "OK"; 
	} else {
		$notice = "error";
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
}

function saveamsg($msg){
	//echo "Töötab";
	$notice = ""; //see on teade, mis antaksa salvastamise kohta
	//loome uhenduse andmebaasiserveriga
	$mysqli = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"],  $GLOBALS["serverpassword"],  $GLOBALS["database"]);
	//valmistame ette sql paringu
	$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
	echo $mysqli-> error;
	$stmt->bind_param("s", $msg); //s - string, i - integer, d - decimal
	if($stmt->execute()){
		$notice = 'Sõnum: "' . $msg . '"on salvestatud!';
	
	}
	else{
		$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	
	}
	$stmt->close();
	$mysqli->close();
	return $notice;		
}
function test_input($data) {
	  
	  //echo "Koristan"; 
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
}

?>