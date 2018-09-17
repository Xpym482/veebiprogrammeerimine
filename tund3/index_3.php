<?php
	//echo "Siin on PHP hren";
	$name = "Maksim";
	$surname = "Jelizarov";
	$todaydate = date("d.m.Y");
	$hournow = date("H");
	$partofday = "";
	$weekdaynow = date("N");
	//echo $weekdaynow;
	$weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	//var_dump ($weekdaynameset);
	//echo $weekdaynameset[0];
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
	//loosime juhusliku pildi
	$picnum = mt_rand(2, 43); //random
	$picurl = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
	$picext = ".jpg";
	$picfilename = $picurl . $picnum . $picext;
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
		echo "<p>Täna on ".$weekdaynameset[$weekdaynow - 1]. ", " .$todaydate ."</p>\n";
		echo "<p> Lehe avamise hetkel oli kell " .date('H:i:s') .", käes on " .$partofday .".</p> \n";
	?>
	<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜTerra õppehoone">
	<!--../../~ringe/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg
	<img src="/home/ringe/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TL� Terra �ppehoone"-->
	<p>Mul on sõber, kes ka teeb mingi <a href="../../~erkksul">veebi</a>.</p>
	
	<img src="<?php echo $picfilename;  ?>" alt="Juhuslik pilt Tallinna Ülikoolis">
	
  </body>
</html>
