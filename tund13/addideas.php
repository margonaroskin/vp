<?php
require("usesession.php");
//loeme andmebaasi login ifo muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
$database = "if20_margo_nar_2";
if (isset($_POST["ideasubmit"])) {
    if (!empty($_POST["ideainput"])) {
        //andmebaasi lisamine
        //loome andmebaasi ühenduse
        $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
        //valmistame ette SQL käsu
        $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES(?)");
        echo $conn->error;
        //s - string, i -integer, d-decimal
        $stmt->bind_param("s", $_POST["ideainput"]);
        $stmt->execute();
        //käsk ja ühendus sulgeda
        $stmt->close();
        $conn->close();
    }
}

//$username = "Margo Narõškin";

require("header.php");
?>

<h1><?php echo $_SESSION["userfirstname"] . " " . $_SESSION["userlastname"]; ?></h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate
    instituudis.</p>

<ul>
    <li><a href="home.php">Avalehele</a></li>
    <li><a href="?logout=1">Logi välja</a>!</li>
</ul>

<form method="POST">
    <label>Sisesta oma tänane mõte!</label>
    <input type="text" name="ideainput" placeholder="mõttekoht">
    <input type="submit" value="Saada ära!" name="ideasubmit">
</form>

</body>
</html>