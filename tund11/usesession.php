<?php
//käivitan sessiooni
//session_start();
require("classes/SessionManager.class.php");
//sessioonihaldus
SessionManager::sessionStart("vp", 0, "/~margnar/", "greeny.cs.tlu.ee");

//Logime välja
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: page.php");
    exit();
}

//Kas on sisseloginud, kui pole, saadame sisselogimise lehele
if (!isset($_SESSION["userid"])) {
    header("Location: page.php");
    exit();
}