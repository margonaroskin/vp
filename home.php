<?php
$username = "Margo Narõškin";
$fulltimenow = date("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg";
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
$fromsemesterstartdays = $semesterstart->diff($today)->format("%r%a")
//if($fromsemesterstartdays < 0){semeser pole peale hakanud}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title><?php echo $username; ?> programmeerib veebi</title>

</head>
<body>
<h1><?php echo $username; ?></h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a>
    Digitehnoloogiate instituudis.</p>
<p>Lehe avamise hetkel oli: <?php echo $fulltimenow; ?>.</p>
<p><?php echo "Parajasti on " .$partofday . ".";?></p>
<p><?php echo "Semestri pikkus on " .$semesterdurationdays . " päeva.";?></p>
<p><?php echo "Semestri algusest on möödunud " .$fromsemesterstartdays . " päeva.";?></p>
<p><?php echo "Semestrist on läbitud " .$semesterpercent . "%";?></p>
</body>
</html>