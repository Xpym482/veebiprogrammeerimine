<?php
  require("functions.php");
  $name = "";
  $surname = "";
  $email = "";
  $gender = "";
  $birthMonth = null;
  $birthYear = null;
  $birthDay = null;
  $birthDate = null;
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //muutujad võimalike veteadetega
  
  $nameerror = "";
  $surnameerror = "";
  $birthmontherror = "";
  $birthyearerror = "";
  $birthdayerror = "";
  $gendererror = "";
  $emailerror = "";
  $passworderror = "";
  
  //kui on uue kasutaja loomise nuppu on vajutatud
  if(isset($_POST["submitUserData"]))
  {
	  //var_dump($_POST);
	  if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
		//$name = $_POST["firstName"];
		$name = test_input($_POST["firstName"]);
	  } else {
		  $nameerror = "Palun sisesta eesnimi";
	  }
	  if (isset($_POST["surName"])){
		//$surname = $_POST["surName"];
		$surname = test_input($_POST["surName"]);
	  }
	  
	  if (isset($_POST["gender"])){
		  $gender = intval($_POST["gender"]);
	  } else {
		  $gendererror = "Palun märgi sugu";
	  }
	//kontrollime, kas sunniaeg sisestati ja kas on korrektne
	if(isset($_POST["birthDay"]))
	{
		$birthDay = $_POST["birthDay"];
	}
	if(isset($_POST["birthMonth"]))
	{
		$birthMonth = $_POST["birthMonth"];
	}
	if(isset($_POST["birthYear"]))
	{
		$birthYear = $_POST["birthYear"];
	}
	//kontrollin kuupaev õigsust
	if(isset($_POST["birthDay"]) and isset($_POST["birthMonth"]) and isset($_POST["birthYear"]))
	{
		//checkdate(paev, kuup, aasta)
		if(checkdate(intval($_POST["birthMonth"]),intval($_POST["birthDay"]), intval($_POST["birthYear"])))
		{
			$birthDate = date_create($_POST["birthMonth"] ."/" .$_POST["birthDay"] ."/" .$_POST["birthYear"]);
			$birthDate = date_format($birthDate, "Y-m-d");
			echo $birthDate;
			var_dump($birthDate);
		} else {
			$birthyearerror = "Kuupaev on vigane";
		}
	} //kui koik kolm kuupaev osad on olemas
	
	//kui koik on korras siis salvestame kasutaja
	if(empty($nameerror) and empty($surnameerror) and empty($birthmontherror) and empty($birthyearerror) and empty($birthyearerror) and empty($gendererror) and empty($emailerror) and empty($passworderror)){
		$notice = signup($name, $surname, $email, $gender, $birthDate, $_POST["password"]);
		echo $notice;
	}
	
} //kui on nuppu vajutatud lõppeb
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Kaitselise veebi uue kasutaja loomine</title>
  </head>
  <body>
    <h1>
	  Loo endale kasutaja konto
	</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Eesnimi:</label><br>
	  <input name="firstName" type="text" value="<?php echo $name ?>"><?php 
	  echo $nameerror;
	  ?><span>
	  <br>
      <label>Perekonnanimi:</label><br>
	  <input name="surName" type="text" value=""><?php 
	  echo $surnameerror;
	  ?></span><br>
	  
	  <input type="radio" name="gender" value="2"<?php if($gender == "2"){
	  echo " checked";} ?>
	  ><label>Naine</label><br>
	  <input type="radio" name="gender" value="1"<?php if($gender == "1"){
	  echo " checked";} ?>><label>Mees</label><br>
	  <span><?php echo $gendererror; ?></span><br>
	  
	  <label>Sünnipäev: </label>
	  <?php
	    echo '<select name="birthDay">' ."\n";
		echo '<option value="" selected disabled>paev</option>' . "\n";
		for ($i = 1; $i < 32; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthDay){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünnikuu: </label>
	  <?php
	    echo '<select name="birthMonth">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' . "\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthMonth){
				echo " selected ";
			}
			echo ">" .$monthNamesET[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünniaasta: </label>
	  <!--<input name="birthYear" type="number" min="1914" max="2003" value="1998">-->
	  <?php
	    echo '<select name="birthYear">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' . "\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 100; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <br>
	  <label>Email (kasutajatunnus):</label><br>
	  <input type="email" name="email"><br><span><?php echo $emailerror;?>
	  </span><br>
	  <label>Salasõna:</label><br>
	  <input name="password" type="text" value=""><span><?php 
	  echo $passworderror;
	  ?></span><br>
	  
	  <input name="submitUserData" type="submit" value="Saada andmed">
	</form>
	
	
	
  </body>
</html>