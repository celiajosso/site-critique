<?php
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
session_start()
?>

<?php
modifie_avis($my_sqli,addslashes($_POST['avis_titre']),addslashes($_POST['avis_texte']),$_POST['note'],$_GET['id_connected'],$_GET['numero']);
header("Location: ../article.php?numero=$_GET[numero]&modif=on");
?>