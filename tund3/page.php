<?php
	
	$name = "Tundmatu";
	$surname = "inimene";
	$birthyear = "";
	//var_dump($_POST);	
	if(isset($_POST["firstname"]))
	{
		$name = $_POST["firstname"];
	}
	if(isset($_POST["surname"]))
	{
		$surname = $_POST["surname"];
	}
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
	<form method="POST">
		<label>Eesnimi:</label>
		<input name="firstname" type="text" value="">
		<label>Perekonnanimi:</label>
		<input name="surname" type="text" value="">
		<input name "birthyear" type="number" min="1924" max="2003" value="1998">
		<br>
		<input name="submituserdata" type="submit" value="Saada andmed">
	</form>
	
	<?php
		if(isset($_POST["firstname"])) {
			echo "<br><p>Olete elananud järgnevatel aastatel:</p>";
			echo "<ul> \n";
			for($i = $_POST["birthyear"]; $i <= date("Y") + 1; $i++)
			{
					echo "<li>" . $i .  "</li> \n";
			}		
			echo "</ul> \n";
		}
	?>
  </body>
</html>
