<?php
$username = "Margo Narõškin";
$fulltimenow = date("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg";
if ($hournow < 7) {
    $partofday = "uneaeg";
}
if ($hournow >= 8 and $hournow < 18) {
    $partofday = "akadeemilise aktiivsuse aeg";
}

//vaatame semestri kulgemist
$semesterstart = new DateTime("2020-8-31");
$semesterend = new DateTime("2020-12-13");
//selgitame välja nende vahe ehk erinevuse
$semesterduration = $semesterstart->diff($semesterend);
$semesterdurationdays = $semesterduration->format("%r%a");
//tänane päev
$today = new DateTime();
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
<h1><?php echo $semesterdurationdays; ?></h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a>
    Digitehnoloogiate instituudis.</p>
<p>Lehe avamise hetkel oli: <?php echo $fulltimenow; ?>.</p>
<p><?php echo "Parajasti on " .$partofday . ".";?></p>
</body>
</html>