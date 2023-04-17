<?php
session_start();
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site - A completer
require_once("./includes/constantes.php");      //constantes du site
require_once("./includes/config-bdd.php");      //constantes du site
include_once("./php/functions-DB.php");
//include_once("./php/functions_query.php");
//include_once("./php/functions_structure.php");
$my_sqli = connectionDB();

?>

<!DOCTYPE html lang="fr">

    <head>
        <title>Gamecrit - Authentification</title>
        <meta name="author" content="NORTON Thomas, JOSSO Célia">
        <meta name="author" content="ESIR, CUPGE">
        
        <link rel="icon" href="Images/icone.png">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/nav.css">
        <link rel="stylesheet" href="styles/footer.css">
        <link rel="stylesheet" href="styles/bouton.css">
    </head>

    <?php include("./static/header.php"); ?>
    <?php include("./static/nav.php"); ?>

    <?php
    echo "<div class='authentification-buttons'>";
    echo "<div>";
    echo "<h2>Vous possédez déjà un compte Gamecrit ?</h2>";
    echo "<br>";
    echo "<a href='connection.php'><button>Se connecter</button></a>";
    echo "</div>";
    echo "<div>";
    echo "<h2>Vous êtes nouveau ?</h2>";
    echo "<br>";
    echo "<a href='registration.php'><button>S'inscrire</button></a>";
    echo "</div>";
    echo "</div>";
    ?>

    <?php include("./static/footer.php"); ?>
<html>