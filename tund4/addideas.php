<?php
  //var_dump($_POST);
  require("../../../config.php");
  $database = "if20_margo_nar_2";
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
	  //loome andmebaasiga ühenduse
	  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	  //valmistan ette SQL käsu andmete kirjutamiseks
	  $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES(?)");
	  echo $conn->error;
	  //i - integer, d - decimal, s - string 
	  $stmt->bind_param("s", $_POST["ideainput"]);
	  $stmt->execute();
	  $stmt->close();
	  $conn->close();
  }
  
  $username = "Margo Narõškin";
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="home.php">Avalehele</a></p>
  <form method="POST">
    <label>Kirjutage oma esimene pähe tulev mõte!</label>
	<input type="text" name="ideainput" placeholder="mõttekoht">
	<input type="submit" name="ideasubmit" value="Saade mõte teele!">
  </form>
  <hr>

</body>
</html>