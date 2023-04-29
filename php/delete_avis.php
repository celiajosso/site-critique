<?php
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
session_start()
?>

<?php
supprime_avis($my_sqli,$_GET['id_connected'],$_GET['numero']);
header("Location: ../article.php?numero=$_GET[numero]&del=$_GET[id_connected]");
?>