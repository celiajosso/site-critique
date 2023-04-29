<?php
session_start();
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site - A completer
require_once("../includes/constantes.php");      //constantes du site
require_once("../includes/config-bdd.php");      //constantes du site
include_once("../php/functions-DB.php");
include_once("../php/functions_query.php");
include_once("../php/functions_structure.php");
$my_sqli = connectionDB();
date_default_timezone_set('Europe/Paris');
?>

<?php

$titre_article = $_POST["titre_article"];
$nom_jeu = $_POST["nom_jeu"];
$date_sortie = $_POST["date_sortie"];
$prix = $_POST["prix"];
$synopsis = $_POST["synopsis"];
$note = $_POST["note"];
$critique = $_POST["critique"];
$jaquette = $_POST["jaquette"];
$gameplay = $_POST["gameplay"];

$titre_article = addslashes($titre_article);
$nom_jeu = addslashes($nom_jeu);
$synopsis = addslashes($synopsis);
$critique = addslashes($critique);

$nb_rows_supports = "SELECT COUNT(*) FROM Support";
$nb_rows_supports_res = readDB($my_sqli, $nb_rows_supports);
$nb_sup = $nb_rows_supports_res[0];

$nb_rows_categories = "SELECT COUNT(*) FROM Support";
$nb_rows_categories_res = readDB($my_sqli, $nb_rows_categories);
$nb_cat = $nb_rows_categories_res[0];


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

$chaine_supports = "";
foreach($checked_supports as $cle => $val) {
    $chaine_supports = $chaine_supports . "&sup_$val=1";
}

if (empty($chaine_supports)) {
    $chaine_categories = "&";
}
else {
    $chaine_categories = "";
}

foreach($checked_categories as $cle => $val) {
    $chaine_categories = $chaine_categories . "&cat_$val=1";
}

$jeu_unique = Is_gameUnique($my_sqli, $nom_jeu);

if (!$jeu_unique) {
    $page = "../redacArticle.php?titre_article=$titre_article&nom_jeu=$nom_jeu&date_sortie=$date_sortie&prix=$prix&synopsis=$synopsis&note=$note&critique=$critique&jaquette=$jaquette&gameplay=$gameplay&erreur=jeu";
    $page = $page . $chaine_categories . $chaine_supports;
    header("Location: $page");
}
else{
    $sql_insert_jeu = "INSERT INTO Jeu (nom, prix, date_sortie, synopsis) VALUES ('$nom_jeu', '$prix', '$date_sortie', '$synopsis')";
    $sql_insert_jeu_res = writeDB($my_sqli, $sql_insert_jeu);

    $nb_rows_jeu_input = "SELECT COUNT(*) as nb_rows FROM Jeu";
    $nb_rows_jeu_res = readDB($my_sqli, $nb_rows_jeu_input);

    $nb_rows_jeu = $nb_rows_jeu_res[0]["nb_rows"];
    $today = date("Y-m-d");
    
    $login = $_SESSION["username"];
    $sql_input_id = "SELECT id_Utilisateur FROM Utilisateur WHERE login_Utilisateur='$login'";
    $sql_input_id_res = readDB($my_sqli, $sql_input_id);

    $id_utilisateur = $sql_input_id_res[0]["id_Utilisateur"];

    $sql_insert_article = "INSERT INTO Article (titre_Article, dateCreation_Article, id_Jeu, id_UtilisateurCreateur, contenu_Article, noteRedacteur_Article) VALUES ('$titre_article', '$today', $nb_rows_jeu, $id_utilisateur, '$critique', $note)";
    $sql_insert_article_res = writeDB($my_sqli, $sql_insert_article);

    foreach ($checked_categories as $cle => $val) {
        $sql_insert_categories = "INSERT INTO est_categorie (id_Jeu, id_Categorie) VALUES ($nb_rows_jeu, $val)";
        $sql_insert_categories_res = writeDB($my_sqli, $sql_insert_categories);
    }

    foreach ($checked_supports as $cle => $val) {
        $sql_insert_supports = "INSERT INTO est_support (id_Jeu, id_Support) VALUES ($nb_rows_jeu, $val)";
        $sql_insert_supports_res = writeDB($my_sqli, $sql_insert_supports);
    }

    $image_path = "Images/Jeu/$nb_rows_jeu/";
    $lien_gameplay = $image_path . 'gameplay.jpg';
    $lien_jaquette = $image_path . 'jaquette.jpg';

    $sql_insert_images = "INSERT INTO Image (chemin_image) VALUES ('$lien_gameplay'),('$lien_jaquette')";
    $sql_insert_images_res = writeDB($my_sqli, $sql_insert_images);

    $nb_rows_article_input = "SELECT COUNT(*) as nb_rows FROM Article";
    $nb_rows_article_res = readDB($my_sqli, $nb_rows_article_input);
    $nb_rows_article = $nb_rows_article_res[0]["nb_rows"];

    $nb_rows_image_input = "SELECT COUNT(*) as nb_rows FROM Image";
    $nb_rows_image_res = readDB($my_sqli, $nb_rows_image_input);
    $nb_rows_image = $nb_rows_image_res[0]["nb_rows"];

    $id_gameplay = $nb_rows_image - 1;
    $id_jaquette = $nb_rows_image;

    $sql_insert_assoc = "INSERT INTO est_image (id_Article, id_Image) VALUES ($nb_rows_article, $id_gameplay), ($nb_rows_article, $id_jaquette)";
    $sql_insert_assoc_res = writeDB($my_sqli, $sql_insert_assoc);

    header("Location: ../index.php?envoi=1");
}
?>
<?php closeDB($my_sqli); ?>
