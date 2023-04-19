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


    // debut script barre de recherche (par nom de jeu)
    echo "<br>";
    if(isset($_GET['q']) && !empty($_GET['q'])) {
        $q = htmlspecialchars($_GET['q']);
        $jeux = "SELECT DISTINCT nom FROM Jeu WHERE nom LIKE '%$q%'";
        $jeux_res = readDB($my_sqli, $jeux);
    }

    echo "<form method='GET'>";
    echo "<input type='search' size = '30' name='q' placeholder='Recherche par nom de jeu' />";
    echo "<input type='submit' value='Valider' />";
    echo "</form>";

    if (!empty($jeux_res)) {
        $len = count($jeux_res);
        echo "$len résultats pour la recherche : <em>$q</em>";
        echo "<ul>";
        foreach($jeux_res as $cle => $val) {
           echo "<li>";
           print_r($val["nom"]);
           echo "</li>";
        } 
        echo "</ul>";
     }
     else {
        if (isset($q)) {
            echo "Aucun résultat pour la recherche : <em>$q</em>";
        }
        
     }
     echo "<br>";
    // fin script barre de recherche

    // debut script barre de recherche (par categorie)
    echo "<br>";
    $sql_categorie = "SELECT id_Categorie FROM Categorie";
    $sql_categorie_res = readDB($my_sqli, $sql_categorie);

    $nb_categories = count($sql_categorie_res);
    
    $selected_categories = Array();

    for ($i=1; $i < $nb_categories+1; $i++) {
        if(isset($_GET["c_$i"])) {
            $selected_categories[] = 1;
        }
        else {
            $selected_categories[] = 0;
        }
    }

    $condition = " ";
    foreach($selected_categories as $cle => $val) {
        if ($val) {
            $index = $cle + 1;
            $condition = $condition . "id_Categorie = $index OR ";
        }
        }
    $condition = substr($condition, 1,-3);

    $jeux_1 = "SELECT DISTINCT id_Jeu FROM est_Categorie WHERE $condition";
    $jeux_1_res = readDB($my_sqli, $jeux_1);

    echo "<form method='GET'>";

    // boucle
    $i = 1;
    foreach ($sql_categorie_res as $cle => $val) {
        foreach ($val as $cle1 => $val1) {
            $chemin_type = "Images/Categories/" . $val1 . ".png";
            $nom_champ = "c_" . "$i";

            echo "<div class='form-content'>";
                
                    echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'/></div>";
                    echo "<div class='right-column-checkbox'><img  class='icone-type' src='$chemin_type'></div>";
            echo "</div>";
            echo "<br><br>";
            $i = $i + 1;
        }}
    echo "<input type='submit' value='Valider' />";
    echo "</form>";

    if (!empty($jeux_1_res)) {
        $len = count($jeux_1_res);
        echo "$len résultats pour cette recherche :";
        echo "<ul>";
        foreach($jeux_1_res as $cle => $val) {
           echo "<li>";
           print_r($val["id_Jeu"]);
           echo "</li>";
        } 
        echo "</ul>";
     }
     else {
        echo "Aucun résultat pour cette recherche";
        
     }
     echo "<br>";
    // fin script barre de recherche

    if (isset($_GET["inscription"])) {
        $login = $_SESSION["username"];
        echo "<div class='erreur-inscription'><h2>Bienvenue $login!</h2></div>";
    }

    // lien vers pages de profil privée et publiques (temporaire)
    if (isset($_SESSION["username"])) {
        $login_user = $_SESSION["username"];
        $sql_id_user = "SELECT id_Utilisateur FROM Utilisateur WHERE login_Utilisateur='$login_user'";
        $sql_id_user_res = readDB($my_sqli, $sql_id_user);
        $id_user = $sql_id_user_res[0]["id_Utilisateur"];
        $sql_input_other_users = "SELECT id_Utilisateur, login_Utilisateur FROM Utilisateur WHERE id_Utilisateur <> $id_user ORDER BY id_Utilisateur";
        $sql_input_other_users_res = readDB($my_sqli, $sql_input_other_users);
        foreach($sql_input_other_users_res as $cle => $val) {
            $login_user = $val["login_Utilisateur"];
            $id_user = $val["id_Utilisateur"];
            echo "<a href='profilPublic.php?numero=$id_user'>Profil public de $login_user</a>";
            echo "<br>";
        }
    }

    echo "<br>";

    $tab = getArticles($my_sqli);
    displayArticles($tab);

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
