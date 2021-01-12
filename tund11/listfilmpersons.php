<?php
require("usesession.php");
//loeme andmebaasi login ifo muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
//$database = "if20_margo_nar_2";
require("fnc_filmrelations.php");

$sortby = 0;
$sortorder = 0;

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

<hr>
<?php
if (isset($_GET["sortby"]) and isset($_GET["sortorder"])) {
    if ($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4) {
        $sortby = intval($_GET["sortby"]);
    }
    if ($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2) {
        $sortorder = intval($_GET["sortorder"]);
    }
}
echo readpersoninmovie($sortby, $sortorder);
?>
</body>
</html>