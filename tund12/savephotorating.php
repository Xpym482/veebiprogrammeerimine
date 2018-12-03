<?php
	//GET metoodiga saadetavad parameetrid
	$id = $_REQUEST["id"];
	$rating = $_REQUEST["rating"];
	require("../../../config.php");
    $database = "if18_maksim_je_1";
	
	session_start();
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	$stmt = $mysqli->prepare("INSERT INTO vpphotoratings (photoid, userid, rating) VALUES (?, ?, ?)");
	$stmt->bind_param("iii", $id, $_SESSION["userid"], $rating);
	$stmt->execute();
	$stmt->close();
	//kusime uue keskmise hinde
	$stmt->mysqli->prepare("SELECT AVG(rating) as AvgValue FROM vpphotoratings WHERE photoid=?");
	$stmt->bind_param("i", $id);
	$stmt->bind_result($score);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$mysqli->close();
	// umardan keskmise hinde kaks
	echo roound($score, 2);
?>