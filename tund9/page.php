<?php
//var_dump($_POST);
//käivitan sessiooni
session_start();
//loeme andmebaasi login info muutujad
require("../../../config.php");
require("fnc_common.php");
require("fnc_user.php");

//$username = "Margo Narõškin";
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

//tänane päev
$today = new DateTime("now");
//if($fromsemesterstartdays < 0){semester pole peale hakanud}
$fromsemesterstart = $semesterstart->diff($today);
//saime aja erinevuse objektina, seda niisama näidata ei saa
$fromsemesterstartdays = $fromsemesterstart->format("%r%a");
$semesterpercentage = 0;

$semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
if ($semesterstart > $today) {
    $semesterinfo = "Semester pole veel alanud.";
}
if ($fromsemesterstartdays == 0) {
    $semesterinfo = "Semester algab täna.";
}
if ($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays) {
    $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
    $semesterinfo = "Semester on hetkel käimas ning " . $fromsemesterstartdays . " päeva on juba läbitud, mis moodustab " . $semesterpercentage . "% tervest semestrist.";
}
if ($fromsemesterstartdays == $semesterdurationdays) {
    $semesterinfo = "Tänasega saab semester läbi.";
}
if ($fromsemesterstartdays > $semesterdurationdays) {
    $semesterinfo = "Semester on läbi.";
}

//loeme kataloogist piltide nimekirja
$allfiles = scandir("../vp_pics/");
//echo $allfiles;
//var_dump($allfiles);
$picfiles = array_slice($allfiles, 2);
//var_dump($picfiles);
$imghtml = "";
$piccount = count($picfiles);
//$i = $i + 1;
//$i ++;
//$i += 3
/* for($i = 0;$i < $piccount; $i ++){
	  //<img src="../img/pildifail" alt="tekst">
	  $imghtml .= '<img src="../vp_pics/' .$picfiles[$i] .'" alt="Tallinna Ülikool">';
} */
//$randompicnum = mt_rand(0,($piccount - 1));
//$imghtml = '<img src="../vp_pics/' .$picfiles[$randompicnum] .'" alt="Tallinna Ülikool">';
$imghtml = '<img src="../vp_pics/' . $picfiles[mt_rand(0, ($piccount - 1))] . '" alt="Tallinna Ülikool">';

$email = "";

$emailerror = "";
$passworderror = "";
$notice = "";
if (isset($_POST["submituserdata"])) {
    if (!empty($_POST["emailinput"])) {
        //$email = test_input($_POST["emailinput"]);
        $email = filter_var($_POST["emailinput"], FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        } else {
            $emailerror = "Palun sisesta õige kujuga e-postiaadress!";
        }
    } else {
        $emailerror = "Palun sisesta e-postiaadress!";
    }

    if (empty($_POST["passwordinput"])) {
        $passworderror = "Palun sisesta salasõna!";
    } else {
        if (strlen($_POST["passwordinput"]) < 8) {
            $passworderror = "Liiga lühike salasõna (sisestasite ainult " . strlen($_POST["passwordinput"]) . " märki).";
        }
    }

    if (empty($emailerror) and empty($passworderror)) {
        //echo "Juhhei!" .$email .$_POST["passwordinput"];
        $notice = signin($email, $_POST["passwordinput"]);
    }
}

require("header.php");
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammerimise kursue logo">
<h1>Veebileht</h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a>
    Digitehnoloogiate instituudis.</p>

<hr>
<h3>Logi sisse</h3>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="emailinput">E-mail (kasutajatunnus):</label><br>
    <input type="email" name="emailinput" id="emailinput"
           value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
    <br>
    <label for="passwordinput">Salasõna:</label>
    <br>
    <input name="passwordinput" id="passwordinput" type="password"><span><?php echo $passworderror; ?></span>
    <br>
    <br>
    <input name="submituserdata" type="submit"
           value="Logi sisse"><span><?php echo "&nbsp; &nbsp; &nbsp;" . $notice; ?></span>
</form>

<p>Loo omale <a href="addnewuser.php">kasutajakonto</a>!</p>
<hr>
<p>Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow - 1] . ", " . $fulltimenow; ?>.</p>
<p><?php echo "Parajasti on " . $partofday . "."; ?></p>
<p><?php echo $semesterinfo; ?></p>
<hr>

<?php echo $imghtml; ?>

</body>
</html>