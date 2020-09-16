<?php
//var_dump($_POST);
require("../../../config.php");
$database = "if20_margo_nar_2";
if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
	//loome andmebaasiga ühenduse
	$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	//valmistan ette SQL käsu andmete kirjutamiseks
	$stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES (?)");
	echo $conn->error;
	//i - integer, d - decimal, s - string
	$stmt->bind_param("s", $_POST ["ideainput"]);
	$stmt->execute();
	$stmt->close();
	$conn->close();
}

//loen andmebaasist senised mõtted
$ideahtml = "";
$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
$stmt = $conn->prepare("SELECT idea FROM myideas");
//seon tulemuse muutujaga
$stmt->bind_result($ideafromdb);
$stmt->execute();
while($stmt->fetch()){
	$ideahtml .= "<p>" .$ideafromdb ."</p>";
}
$stmt->close();
$conn->close();

$username = "Margo Narõškin";
$fulltimenow = date("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg";

$weekdaynameset = [
"esmaspäev", 
"teisipäev", 
"kolmapäev", 
"neljapäev", 
"reede", 
"laupäev", 
"pühapäev"
];
$monthnameset = [
"jaanuar", 
"veebruar", 
"märts", 
"aprill", 
"mai", 
"juuni", 
"juuli", 
"august", 
"september", 
"oktoober", 
"november", 
"detsember"
];
//echo $weekdaynameset[1];
$weekdaynow = date("N");

if ($hournow < 7) {
    $partofday = "uneaeg";
}
if ($hournow >= 8 and $hournow < 16) {
    $partofday = "akadeemilise aktiivsuse aeg";
}
if ($hournow >= 16 and $hournow < 18) {
    $partofday = "trenni aeg";
}	
if ($hournow >= 18 and $hournow < 20) {
    $partofday = "vaba aeg";
}
if ($hournow >= 22 and $hournow < 23) {
    $partofday = "hügieen";
}
if ($hournow >= 23) {
    $partofday = "magamaminek";
}

//vaatame semestri kulgemist
$semesterstart = new DateTime("2020-8-31");
$semesterend = new DateTime("2020-12-13");
//selgitame välja nende vahe ehk erinevuse
$semesterduration = $semesterstart->diff($semesterend);
//leiame päevade arvu
$semesterdurationdays = $semesterduration->format("%r%a");
//selgitame välja mitu protsenti semestrist on läbitud
$today = new DateTime("now");
$semesterpassed = $semesterstart->diff($today)->format("%r%a");
$semesterpercent = $semesterpassed * 100 / $semesterdurationdays;
//tänane päev
$today = new DateTime("now");
$fromsemesterstartdays = $semesterstart->diff($today)->format("%r%a");
//if($fromsemesterstartdays < 0){semeser pole peale hakanud}

//loeme kataloogist piltide nimekrija
$allfiles = scandir("../vp_pics/");
//echo $allfiles
//var_dump($allfiles);
$pickfiles = array_slice($allfiles, 2);
//var_dump($pickfiles);
$imghtml = "";
$pickcount = count($pickfiles);
//$i = $i +1;
//$i ++;
//$i += 3;
for($i = 0;$i < $pickcount; $i ++){
	//<img src="../img/pildifail" alt="tekst">
	$imghtml .= '<img src="../vp_pics/' .$pickfiles[$i] .'" alt="Tallinna Ülikool">';
}
require("header.php");
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammerimise kursue logo">
<h1><?php echo $username; ?></h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a>
    Digitehnoloogiate instituudis.</p>
<p>Lehe avamise hetkel oli: <?php echo $weekdaynameset[$weekdaynow - 1] .", " .$fulltimenow; ?>.</p>
<p><?php echo "Parajasti on " .$partofday . ".";?></p>
<p><?php echo "Semestri pikkus on " .$semesterdurationdays . " päeva.";?></p>
<p><?php echo "Semestri algusest on möödunud " .$fromsemesterstartdays . " päeva.";?></p>
<p><?php echo "Semestrist on läbitud " .$semesterpercent . "%";?></p>
<hr>
<?php echo $imghtml; ?>
<hr>
<form method="POST">
	<label>Kirjutage oma esimene pähe tulev mõte!</label>
	<input type="text" name="ideainput" placeholder="mõttekoht">
	<input type="submit" name="ideasubmit" value="Saada mõte teele">
</form>
<hr>
<?php echo $ideahtml; ?>
</body>
</html>