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
        <title>Gamecrit</title>
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
        // if (isset($_GET["erreur"])) {
        //     if ($_GET["erreur"] == "age") {
        //         echo "<div class='erreur-inscription'><h2>Erreur !</h2>Vous êtes trop jeune ! Vous devez avoir au moins 15 ans !<br><br></div>";
        //     }
        //     if ($_GET["erreur"] == "login"){
        //         echo "<div class='erreur-inscription'><h2>Erreur !</h2>Ce nom d'utilisateur est déjà pris !<br><br></div>";
        //     }
        //     if ($_GET["erreur"] == "mdp"){
        //         echo "<div class='erreur-inscription'><h2>Erreur !</h2>Le mot de passe confirmé est différent du mot de passe saisi !<br><br></div>";
        //     }
    //}
    ?>
    <?php
        $sql_noms = "SELECT login_Utilisateur FROM Utilisateur";
        $sql_noms_res = readDB($my_sqli, $sql_noms);


        echo "<div class='form-style-5'>";
            echo "<form action='./php/verifRoles.php' method='POST'>";
              echo "<fieldset>";   
                echo "<div class='form-content'>";
                    echo "<div class='left-column'>";
                        echo "<h3 class='a-centrer'>Login Utilisateur</h3>";
                            echo "<select name='login' class='select-option'>";

                                foreach($sql_noms_res as $cle => $val) {
                                        $login = $val['login_Utilisateur'];
                                        echo "<option value='$login'>$login</option>";
                                }
        
                            echo "</select>";
                    echo "</div>";
                    echo "<div class='right-column'>";
                    echo "<h3 class='a-centrer'>Rôle attribué</h3>";
                    

                    echo "<select name='role' class='select-option'>";
                        echo "<option value='1'>Membre</option>";
                        echo "<option value='2'>Rédacteur</option>";
                        echo "<option value='3'>Administrateur</option>";
                    echo "</select>";


                    echo "</div>";
                echo "</div>";
                
            echo "</fieldset>";
            echo "<input type='submit' value='Changer le rôle'>";         
            echo "</form>";
        echo "</div>";
    echo "<br><br><br><br>";
    ?>
    <?php include("./static/footer.php"); ?>
<html>