<?php
session_start();

//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//Import du site
require_once("./includes/constantes.php");      //constantes du site
require_once("./includes/config-bdd.php");      
include_once("./php/functions-DB.php");
include_once("./php/functions_query.php");
include_once("./php/functions_structure.php");

$my_sqli = connectionDB();
date_default_timezone_set('Europe/Paris');
?>

<!DOCTYPE html lang="fr">

    <head>
        <title>Gamecrit - Modification d'un article</title>
        <meta name="author" content="NORTON Thomas, JOSSO Célia">
        <meta name="author" content="ESIR, CUPGE">
        
        <link rel="icon" href="Images/icone.png">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/nav.css">
        <link rel="stylesheet" href="styles/footer.css">
        <link rel="stylesheet" href="styles/form.css">
    </head>

    <?php include("./static/header.php"); ?>
    <?php include("./static/nav.php"); ?>
    <?php displayModifArticleInfos($my_sqli) ?>
    <?php include("./static/footer.php"); ?>
</html>
<?php closeDB($my_sqli); ?>
