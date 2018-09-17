<?php
	$name = "Maksim";
	$surname = "Jelizarov";
	$dirtoread = "../../pics/";
	$allfiles = array_slice(scandir($dirtoread), 2);
	var_dump($allfiles);
	
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>
	<?php
	echo $name. " " .$surname;
		?>, õppetöö
		
	</title>
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
	  for ($i = 0; $i < count($allfiles); $i ++){
	    echo '<img src="' .$dirtoread .$allfiles[$i] .'" alt="pilt"><br>';
	  }
	
	/*echo '<img src="'.$allfiles[1].'" alt="pilt"';
	for($i = 0; $i < count($allfiles); $i++){
		echo '<img src="' .$dirtoread .$allfiles[$i] .'" alt="pilt"><br>';
	}*/
	?>
	<p>Mul on sõber, kes ka teeb mingi <a href="../../../../~erkksul">veebi</a>.</p>
  </body>
</html>
