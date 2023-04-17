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

$login = $_POST["login"];

$role = $_POST["role"];

$changement_role = Is_changedRole($my_sqli, $login, $role);


if (!$changement_role) {
    header("Location: ../gestionRoles.php?login=$login&role=$role&erreur=1");
}
else{
    header("Location: ../index.php");
}
?>