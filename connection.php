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
date_default_timezone_set('Europe/Paris');

?>

<!DOCTYPE html lang="fr">

    <head>
        <title>Gamecrit - Connexion</title>
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
    <?php
        if (isset($_GET["erreur"])) {
            echo "<div class='erreur-inscription'><h2>Erreur !</h2>Utilisateur ou mot de passe incorrect.<br><br></div>";
        }
    ?>
    <?php
        echo "<div class='form-style-5'>";
            echo "<form action='./php/login.php' method='POST'>";
              echo "<fieldset>";
                echo "<br>";
                echo "<legend>";
                    echo "<h2 class='a-centrer'>Connexion</h2>";
                echo "</legend>";
                echo "<div class='form-content'>";
                    echo "<div class='left-column'>";
                        if (isset($_GET['login'])) {
                            $login = $_GET['login'];
                            echo "<input type='text' name='login' placeholder='Login *' value='$login' required>";
                        }
                        else {
                            echo "<input type='text' name='login' placeholder='Login *' required>";
                        }

                        if (isset($_GET['prenom'])) {
                            $mdp = $_GET['mdp'];
                            echo "<input type='text' name='mdp' placeholder='Mot de passe *' value='$mdp' required>";
                        }
                        else {
                            echo "<input type='password' name='mdp' placeholder='Mot de passe *' required>";
                        }
                        
                        
                    echo "</div>";
                echo "</div>";
                echo "<br>";
                
            echo "</fieldset>";
            echo "<input type='submit' value='Connexion'>";         
            echo "</form>";
        echo "</div>";
    echo "<br><br><br><br>";
    ?>
    <?php include("./static/footer.php"); ?>
<html>