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

echo "<pre>";
print_r($_POST);
echo "</pre>";

$nom = $_POST["nom"];

$prenom = $_POST["prenom"];

$naissance = $_POST["naissance"];

$mail = $_POST["mail"];

$login = $_POST["login"];

$mdp = $_POST["mdp"];

$mdp_confirmation = $_POST["mdp-confirmation"];

$choix_pp = $_POST["choix-pp"];

$login_unique = Is_loginUnique($my_sqli, $login);

$age_valide = Is_enoughAged($naissance);

$mdp_valide = Is_samePassword($mdp, $mdp_confirmation);

if (!$age_valide) {
    header("Location: ../registration.php?nom=$nom&prenom=$prenom&mail=$mail&naissance=$naissance&login=$login&mdp=$mdp&mdp_confirmation=$mdp_confirmation&choix_pp=$choix_pp&erreur=age");
}
elseif (!$login_unique) {
    header("Location: ../registration.php?nom=$nom&prenom=$prenom&mail=$mail&naissance=$naissance&login=$login&mdp=$mdp&mdp_confirmation=$mdp_confirmation&choix_pp=$choix_pp&erreur=login");
}
elseif (!$mdp_valide) {
    header("Location: ../registration.php?nom=$nom&prenom=$prenom&mail=$mail&naissance=$naissance&login=$login&mdp=$mdp&mdp_confirmation=$mdp_confirmation&choix_pp=$choix_pp&erreur=mdp");
}
else{
    header("Location: ../index.php");
}
?>