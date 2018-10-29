<?php
$name = "Tundmatu";
$surname = "inimene";
$birthMonth = date("m");
$birthyear = date("Y") - 15;
$birthDay = date("d");
$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
$fullname = $name ." ". $surname;
//var_dump($_POST);	
if(isset($_POST["firstname"]))
	{
		//$name = $_POST["firstname"];
		$name = test_input($_POST["firstname"]);
	}
if(isset($_POST["surname"]))
	{
		//$surname = $_POST["surname"];
		$surname = test_input($_POST["surname"]);
	}
function test_input($data) {
	  
	  echo "Koristan"; 
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
}
function fullname(){
	$GLOBALS["fullname"] = $GLOBALS["name"] . " " . $GLOBALS["surname"];
	echo $fullname;
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
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Eesnimi:</label>
		<input name="firstname" type="text" value="">
		<label>Perekonnanimi:</label>
		<input name="surname" type="text" value="">
		 <label>Sünniaasta: </label>
	  <!--<input name="birthYear" type="number" min="1914" max="2003" value="1998">-->
	  <?php
	    echo '<select name="birthyear">' ."\n";
		for ($i = $birthyear; $i >= date("Y") - 100; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>	
		<br>
		<input name="submituserdata" type="submit" value="Saada andmed">
	</form>
	
	<?php
		if(isset($_POST["firstname"])) {
			//demoks
			fullname();
			echo "<br><p>" .$fullname .". Olete elananud järgnevatel aastatel:</p>";
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
