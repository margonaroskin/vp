<?php
  require("usesession.php");
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  $database = "if20_margo_nar_2";
  require("fnc_common.php");
  require("fnc_user.php");
  
  $notice = "";
  //$userdescription = ""; //edaspidi püüate andmebaasist lugeda, kui on, kasutate seda väärtust
if(!empty($_POST["descriptioninput"])){
    $userdescription = test_input($_POST["descriptioninput"]);
} else {
    $userdescription = readuserdescription();
}
  
  if(isset($_POST["profilesubmit"])){
	$description = test_input($_POST["descriptioninput"]);
	$result = storeuserprofile($description, $_POST["bgcolorinput"], $_POST["txtcolorinput"]);
	//sealt peaks tulema kas "ok" või mingi error
	if($result == "ok"){
		$notice = "Kasutajaprofiil on salvestatud!";
		$_SESSION["userbgcolor"] = $_POST["bgcolorinput"];
		$_SESSION["usertxtcolor"] = $_POST[txtcolorinput];
	} else {
		$notice = "Profiili salvetamine ebaõnnestus!";
	}
	
  }
  
  //$username = "Margo Narõškin";
  
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <ul>
    <li><a href="home.php">Avalehele</a></li>
	<li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="descriptioninput">Minu lühitutvustus</label>
	<br>
	<textarea name="descriptioninput" id="descriptioninput" rows="10" cols="80" placeholder="Minu tutvustus ..."><?php $userdescription ?></textarea>
	<br>
	<label for="bgcolorinput">Minu valitud taustavärv: </label>
	<input type="color" name="bgcolorinput" id="bgcolorinput" value="<?php echo $_SESSION["userbgcolor"]; ?>">
	<br>
	<label for="txtcolorinput">Minu valitud tekstivärv: </label>
	<input type="color" name="txtcolorinput" id="txtcolorinput" value="<?php echo $_SESSION["usertxtcolor"]; ?>">
	<br>
	<input type="submit" name="profilesubmit" value="Salvesta profiil!">
	<span><?php echo $notice; ?></span>
  </form>
  
</body>
</html>