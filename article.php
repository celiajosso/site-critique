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
include_once("./php/functions_query.php");
include_once("./php/functions_structure.php");
$my_sqli = connectionDB();

?>

<!DOCTYPE html lang="fr">
    <head>
        <?php
            $num = $_GET['numero'];
            $sql_input = "SELECT nom from jeu WHERE id_Jeu=$num;";
            $res_sql_input = readDB($my_sqli, $sql_input);

            $titre = $res_sql_input[0]['nom'];

            echo "<title>Gamecrit - $titre</title>"
        ?>
        
        <meta name="author" content="JOSSO Célia">
        <meta name="author" content="ESIR, CUPGE">

        <link rel="icon" href="Images/icone.png">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/nav.css">
        <link rel="stylesheet" href="styles/footer.css">
        <link rel="stylesheet" href="styles/infosArticle.css">
    </head>

    <body>
        <?php include("./static/header.php"); ?>
        <?php include("./static/nav.php"); ?>
        <br>
        <?php
            $num = $_GET['numero'];
            $tab = getArticleInformations($my_sqli);
            displayArticleInformations($tab, $num);
        ?>
        <?php include("./static/footer.php"); ?>
    </body>            
    <?php closeDB($my_sqli); ?>
</html>