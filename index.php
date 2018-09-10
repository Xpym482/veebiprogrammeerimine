<?php
	//echo "Siin on PHP hren";
	$name = "Maksim";
	$surname = "Jelizarov";
	$todaydate = date("d.m.Y");
	$hournow = date("H");
	$partofday = "";
	if ($hournow < 8){
	
		$partofday = "varajane hommik";
	}
	if ($hournow >= 8 and $hournow < 16){
	
		$partofday = "kooliaeg";
	}
	/*if ($hournow >= 16)
	{
		$partofday = "vaba aeg";
	}*/
	else
	{
		$partofday = "vabaeg";
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php
	echo $name;
	echo ' ';
	echo $surname;
	?>, õppetöö</title>
  </head>
  <body>
    <h1>
	<?php
		echo $name ." ". $surname;
		
	?>
	</h1>
	<p>Ülikooli aadress <a href="http://www.tlu.ee" target="_blank">TLU</a>
	</p>
	<?php 
		echo "<p>Tänane kuupäev on: " .$todaydate ."</p>\n";
		echo "<p> Lehe avamise hetkel oli kell " .date('H:i:s') .", käes on " .$partofday .".</p> \n";
	?>
	<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜTerra õppehoone">
	<!--../../~ringe/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg
	<img src="/home/ringe/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TL� Terra �ppehoone"-->
	<p>Mul on sõber, kes ka teeb mingi <a href="../../~erkksul">veebi</a>.</p>
  </body>
</html>
