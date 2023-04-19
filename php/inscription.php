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
//include_once("../php/functions_structure.php");
$my_sqli = connectionDB();
date_default_timezone_set('Europe/Paris');
?>

<?php

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
    $img_path = "Images/PhotoProfil/" . $choix_pp;
    $today = date("Y-m-d");
    $today_with_h_m = date("Y-m-d h:i");
    $sql_input = "INSERT INTO Utilisateur (login_Utilisateur, password_Utilisateur, photoProfil_Utilisateur, nom_Utilisateur, prenom_Utilisateur, id_role, mail_Utilisateur, dateNaissance_Utilisateur, dateCreation_Utilisateur, dateConnexion_Utilisateur) VALUES ('$login', '$mdp', '$img_path', '$nom', '$prenom', 1, '$mail', '$naissance', '$today', '$today_with_h_m')";
    $sql_input_res = writeDB($my_sqli, $sql_input);

    $sql_id = "SELECT prenom_Utilisateur, id_Role FROM Utilisateur WHERE login_Utilisateur = '$login' AND password_Utilisateur= '$mdp'";
    $res_id = readDB($my_sqli, $sql_id);
    $prenom = $res_id[0]['prenom_Utilisateur'];
    $role = $res_id[0]['id_Role'];
     
    $_SESSION['username'] = $login;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['role'] = $role;
    $_SESSION['is_connected'] = 1;
    closeDB($my_sqli);

    header("Location: ../index.php?inscription=1");
}
?>