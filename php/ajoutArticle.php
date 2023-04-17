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

?>

<?php

$titre_article = $_POST["titre_article"];
$nom_jeu = $_POST["nom_jeu"];
$date_sortie = $_POST["date_sortie"];
$prix = $_POST["prix"];
$synopsis = $_POST["synopsis"];
$categorie = $_POST["categorie"];
$support = $_POST["support"];
$note = $_POST["note"];
$critique = $_POST["critique"];
$jaquette = $_POST["jaquette"];
$gameplay = $_POST["gameplay"];

$jeu_unique = Is_gameUnique($my_sqli, $nom_jeu);

echo "<pre>"; print_r($_POST); echo "</pre>";

if (!$jeu_unique) {
    header("Location: ../redacArticle.php?titre_article=$titre_article&nom_jeu=$nom_jeu&date_sortie=$date_sortie&prix=$prix&synopsis=$synopsis&categorie=$categorie&support=$support&note=$note&critique=$critique&jaquette=$jaquette&gameplay=$gameplay&erreur=jeu");
}
else{
    header("Location: ../index.php");
}
?>