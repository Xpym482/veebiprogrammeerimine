<?php
require("functions.php");
$notice = null;

if(isset($_POST["submitmessage"])) {
	if ($_POST["message"] != "Kirjuta siia ona sõnum ..." and !empty($_POST["message"])){
		$notice = "Sõnum olemas!";
		$notice = saveamsg($_POST["message"]);
	} 
	else {
		$notice = "Palun kirjutage sõnum!";
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Sõnumi lisamine</title>
  </head>
  <body>
    <h1>Sõnumi lisamine</h1>
	<p>Ülikooli aadress <a href="http://www.tlu.ee" target="_blank">TLU</a>
	</p>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Sõnum (max 256 märki):</label>
	<br>
	<textarea rows="4" cols="64" name="message">Kirjuta siia ona sõnum ...
	</textarea>
	<br>
	<input name="submitmessage" type="submit" value="Salvesta sõnum">
	</form>
	<br>
	<p>
	<?php
		echo $notice;
	?>
	</p>
  </body>
</html>
