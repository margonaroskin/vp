<?php
  require("../../../config.php");
  $database = "if20_margo_nar_2";
    
  //loen andmebaasist filmide info
  $filmhtml = "";
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
  $stmt = $conn->prepare("SELECT * FROM film");
  //seon tulemuse muutujaga
  $stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
  $stmt->execute();
  $filmhtml = "<ol>";
  while($stmt->fetch()){
	  $filmhtml .= "<li>" .$titlefromdb ."</li>";
  }
  $filmhtml = "<ol>";
  $stmt->close();
  $conn->close();
  $username = "Andrus Rinde";
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <li><a href="home.php">Avalehele</li></p>
  <?php echo $filmhtml; ?>
  <ul>
</body>
</html>