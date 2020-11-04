<?php

//käivitan sessiooni
session_start();
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