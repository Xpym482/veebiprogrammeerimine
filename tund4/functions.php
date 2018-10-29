<?php
require("../../../config.php");
//echo $GLOBALS["serverhost"];
$database = "if18_maksim_je_1";
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


?>