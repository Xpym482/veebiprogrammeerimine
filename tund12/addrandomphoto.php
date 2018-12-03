<?php
	require("../../../config.php");
	$database = "if18_maksim_je_1";
	$privacy = 2;
	$limit = 10;
	$photolist = [];
	
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos3 WHERE privacy=? ANDdeleted IS NULL LIMIT ?");
	$stmt->bind_param("ii", $privacy, $limit);
	$stmt->bind_result($filenameFromDb, $alttextFromDb);
	
	$stmt->execute();
	while($stmt->fetch()){
		$photo = new Stdclass();
		$photo->filename = $filenameFromDb;
		$photo->alttext = $alttextFromDb;
		array_push($photolist, $photo);
	}
	if(count($photolist)>0){
		$picNum = mt_rand(0, count($photolist) - 1);
		$html = '<img src="' . $picDir . $photolist[$picNum]->filename .'" alt="' . $photolist[$picNum]->alttext . '">' "\n";
		//lisame nimekirja koigist seekord leitud piltidest
		foreach($photolist as $myPhoto){
			$html . = "<p>" .$myPhoto->filename ."</p> \n";
		}
	}
	$stmt->close();
	$mysqli->close();
	echo $html;
?>