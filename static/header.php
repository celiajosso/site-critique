<?php
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site - A completer
require_once("./includes/constantes.php");      //constantes du site
date_default_timezone_set('Europe/Paris');
?>


<header>
    <a href="index.php">
        <img id="logo" src="Images/logo.png" alt="Image d'un pokedex">
    </a>
    <?php
    // if (isset ($_SESSION['username'])) {
    //     $username=$_SESSION['username'];
    //     $id=$_SESSION['id'];

    //     echo "<h2>Bonjour $username ! (dresseur #$id)</h2>";
    // }
    // else {
    //     echo "<h2>Connecte-toi !</h2>";
    // }
    //?>
</header>