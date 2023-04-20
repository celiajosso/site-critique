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
        <title>Gamecrit - Acceuil</title>
        <meta name="author" content="NORTON Thomas, JOSSO Célia">
        <meta name="author" content="ESIR, CUPGE">
        
        <link rel="icon" href="Images/icone.png">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/nav.css">
        <link rel="stylesheet" href="styles/footer.css">
        <link rel="stylesheet" href="styles/search.css">
    </head>

    <?php include("./static/header.php"); ?>
    <?php include("./static/nav.php"); ?>
    <?php

    $tab = getArticles($my_sqli);
    displayArticles($my_sqli, $tab);

    // debut script barre de recherche (par categorie)



    //$nb_categories = count($sql_categorie_res);

    
    // fin script barre de recherche

    // if (isset($_GET["inscription"])) {
    //     $login = $_SESSION["username"];
    //     echo "<div class='erreur-inscription'><h2>Bienvenue $login!</h2></div>";
    // }

    // // lien vers pages de profil privée et publiques (temporaire)
    // if (isset($_SESSION["username"])) {
    //     $login_user = $_SESSION["username"];
    //     $sql_id_user = "SELECT id_Utilisateur FROM Utilisateur WHERE login_Utilisateur='$login_user'";
    //     $sql_id_user_res = readDB($my_sqli, $sql_id_user);
    //     $id_user = $sql_id_user_res[0]["id_Utilisateur"];
    //     $sql_input_other_users = "SELECT id_Utilisateur, login_Utilisateur FROM Utilisateur WHERE id_Utilisateur <> $id_user ORDER BY id_Utilisateur";
    //     $sql_input_other_users_res = readDB($my_sqli, $sql_input_other_users);
    //     foreach($sql_input_other_users_res as $cle => $val) {
    //         $login_user = $val["login_Utilisateur"];
    //         $id_user = $val["id_Utilisateur"];
    //         echo "<a href='profilPublic.php?numero=$id_user'>Profil public de $login_user</a>";
    //         echo "<br>";
    //     }
    // }

    echo "<br>";



    echo "<br><br><br><br><br><br><br><br>";

    // echo "<h1>Article</h1>";            
    // $sql_input = "SELECT * FROM Article";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";
    // echo "<br><br>";

    // echo "<h1>Support</h1><br><br>";            
    // $sql_input = "SELECT * FROM Support";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>est_Support</h1><br><br>";            
    // $sql_input = "SELECT * FROM est_Support";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>Categorie</h1><br><br>";            
    // $sql_input = "SELECT * FROM Categorie";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>est_Categorie</h1><br><br>";            
    // $sql_input = "SELECT * FROM est_Categorie";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>Jeu</h1><br><br>";            
    // $sql_input = "SELECT * FROM Jeu";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>Avis</h1><br><br>";            
    // $sql_input = "SELECT * FROM Avis";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>Utilisateur</h1><br><br>";            
    // $sql_input = "SELECT * FROM Utilisateur";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>Role</h1><br><br>";            
    // $sql_input = "SELECT * FROM Role";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>Image</h1><br><br>";            
    // $sql_input = "SELECT * FROM Image";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";

    // echo "<h1>est_Image</h1><br><br>";            
    // $sql_input = "SELECT * FROM est_Image";
    // $sql_input_res = readDB($my_sqli, $sql_input);
    // echo "<pre>";
    // print_r($sql_input_res);
    // echo "</pre>";
?>

<?php include("./static/footer.php"); ?>

</html>
