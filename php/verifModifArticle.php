<?php
session_start();
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site
require_once("../includes/constantes.php");      //constantes du site
require_once("../includes/config-bdd.php");      
include_once("../php/functions-DB.php");
include_once("../php/functions_query.php");
include_once("../php/functions_structure.php");
$my_sqli = connectionDB();
date_default_timezone_set('Europe/Paris');
?>

<?php

$num_article = $_GET["numero"];

$sql_id_jeu = "SELECT Jeu.id_Jeu FROM Jeu INNER JOIN Article ON Article.id_Jeu = Jeu.id_Jeu WHERE id_Article=$num_article";
$sql_id_jeu_res = readDB($my_sqli, $sql_id_jeu);
$num_jeu = $sql_id_jeu_res[0]["id_Jeu"];

$titre_article = $_POST["titre_article"];
$nom_jeu = $_POST["nom_jeu"];
$date_sortie = $_POST["date_sortie"];
$prix = $_POST["prix"];
$synopsis = $_POST["synopsis"];
$note = $_POST["note"];
$critique = $_POST["critique"];
$jaquette = $_POST["jaquette"];
$gameplay = $_POST["gameplay"];

$inspect_game = "SELECT id_Article FROM Article INNER JOIN Jeu ON Article.id_Jeu = Jeu.id_Jeu WHERE id_Article <> $num_article AND nom = '$nom_jeu'";
$inspect_game_res = readDB($my_sqli, $inspect_game);

if (empty($inspect_game_res)) {
    $titre_article = addslashes($titre_article);
    $critique = addslashes($critique);
    $nom_jeu = addslashes($nom_jeu);
    $synopsis = addslashes($synopsis);
    
    $sql_update_titre_article = "UPDATE Article SET titre_Article = '$titre_article' WHERE id_Article=$num_article";
    $sql_update_titre_article_res = writeDB($my_sqli, $sql_update_titre_article);
    
    $login = $_SESSION["username"];
    $sql_id_user = "SELECT id_Utilisateur FROM Utilisateur WHERE login_Utilisateur='$login'";
    $sql_id_user_res = readDB($my_sqli, $sql_id_user);
    $num_user = $sql_id_user_res[0]["id_Utilisateur"];
    
    $today = date("Y-m-d");
    
    $synopsis = strval($synopsis);
    $critique = strval($critique);
    
    $sql_change_modif = "UPDATE Article SET dateModification_Article='$today' WHERE id_Article=$num_article";
    $sql_change_modif_res = writeDB($my_sqli, $sql_change_modif);
    $sql_change_user = "UPDATE Article SET id_UtilisateurModifieur=$num_user WHERE id_Article=$num_article";
    $sql_change_user_res =  writeDB($my_sqli, $sql_change_user);
    
    $sql_update_critique_article = "UPDATE Article SET contenu_Article = '$critique' WHERE id_Article=$num_article";
    $sql_update_critique_article_res = writeDB($my_sqli, $sql_update_critique_article);
    
    $sql_update_note_article = "UPDATE Article SET noteRedacteur_Article = $note WHERE id_Article=$num_article";
    $sql_update_note_article_res = writeDB($my_sqli, $sql_update_note_article);
    
    $sql_update_nom_jeu = "UPDATE Jeu SET nom = '$nom_jeu' WHERE id_Jeu=$num_jeu";
    $sql_update_nom_jeu_res = writeDB($my_sqli, $sql_update_nom_jeu);
    
    $sql_update_sortie_jeu = "UPDATE Jeu SET date_sortie = '$date_sortie' WHERE id_Jeu=$num_jeu";
    $sql_update_sortie_jeu_res = writeDB($my_sqli, $sql_update_sortie_jeu);
    
    $sql_update_prix_jeu = "UPDATE Jeu SET prix = '$prix' WHERE id_Jeu=$num_jeu";
    $sql_update_prix_jeu_res = writeDB($my_sqli, $sql_update_prix_jeu);
    
    $sql_update_synopsis_jeu = "UPDATE Jeu SET synopsis ='$synopsis' WHERE id_Jeu=$num_jeu";
    $sql_update_synopsis_jeu_res = writeDB($my_sqli, $sql_update_synopsis_jeu);
    
    $sql_del_categories = "DELETE FROM est_categorie WHERE id_Jeu=$num_jeu";
    $sql_del_categories_res = writeDB($my_sqli, $sql_del_categories);
    
    $sql_del_support = "DELETE FROM est_support WHERE id_Jeu=$num_jeu";
    $sql_del_categories_res = writeDB($my_sqli, $sql_del_support);
    
    $checked_categories = Array();
    $checked_supports = Array();
    
    foreach ($_POST as $cle => $val) {
        if (str_starts_with($cle, 'categorie')) {
            $last_chr = substr($cle, -1);
            $checked_categories[] = $last_chr;
       }
        elseif (str_starts_with($cle, 'support')) {
            $last_chr = substr($cle, -1);
            $checked_supports[] = $last_chr;
        }
    }
    
    foreach ($checked_categories as $cle => $val) {
        $sql_insert_categories = "INSERT INTO est_categorie (id_Jeu, id_Categorie) VALUES ($num_jeu, $val)";
        $sql_insert_categories_res = writeDB($my_sqli, $sql_insert_categories);
    }
    
    foreach ($checked_supports as $cle => $val) {
        $sql_insert_supports = "INSERT INTO est_support (id_Jeu, id_Support) VALUES ($num_jeu, $val)";
        $sql_insert_supports_res = writeDB($my_sqli, $sql_insert_supports);
    }
    
    $image_path = "Images/Jeu/$num_jeu/";
    $lien_gameplay = $image_path . 'gameplay.jpg';
    $lien_jaquette = $image_path . 'jaquette.jpg';
    
    $id_gameplay = 2 * $num_jeu - 1;
    $id_jaquette = $id_gameplay + 1;
    
    $sql_modif_jaquette = "UPDATE Image SET chemin_image = '$lien_jaquette' WHERE id_Image = $id_jaquette";
    $sql_modif_jaquette_res = writeDB($my_sqli, $sql_modif_jaquette);
    
    $sql_modif_gameplay = "UPDATE Image SET chemin_image = '$lien_gameplay' WHERE id_Image = $id_gameplay";
    $sql_modif_gameplay_res = writeDB($my_sqli, $sql_modif_gameplay);
    
    header("Location: ../article.php?numero=$num_article&success=1");
}
else {
    header("Location: ../modifArticle.php?numero=$num_article&erreur=1");
}


?>