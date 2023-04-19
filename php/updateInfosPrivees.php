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
    $num = $_GET["numero"];

    if (isset($_GET["login"])) {
        $login = $_POST["login"];
        $login_unique = Is_loginUnique($my_sqli, $login);
        if (!$login_unique) {
            header("Location: ../profilPrive.php?numero=$num&erreur=login");
        }
        else {
            $sql_input = "UPDATE Utilisateur SET login_Utilisateur='$login' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            $_SESSION["username"] = $login;
            header("Location: ../profilPrive.php?numero=$num&success=Login");
        }
    }

    if (isset($_GET["nom"])) {
        $nom = $_POST["nom"];

        $sql_input = "UPDATE Utilisateur SET nom_Utilisateur='$nom' WHERE id_Utilisateur='$num'";
        $sql_input_res = writeDB($my_sqli, $sql_input);
        header("Location: ../profilPrive.php?numero=$num&success=Nom");
    }

    if (isset($_GET["prenom"])) {
        $prenom = $_POST["prenom"];

        $sql_input = "UPDATE Utilisateur SET prenom_Utilisateur='$prenom' WHERE id_Utilisateur='$num'";
        $sql_input_res = writeDB($my_sqli, $sql_input);
        header("Location: ../profilPrive.php?numero=$num&success=Prénom");
    }

    if (isset($_GET["mail"])) {
        $mail = $_POST["mail"];

        $sql_input = "UPDATE Utilisateur SET mail_Utilisateur='$mail' WHERE id_Utilisateur='$num'";
        $sql_input_res = writeDB($my_sqli, $sql_input);
        header("Location: ../profilPrive.php?numero=$num&success=Adresse mail");
    }

    if (isset($_GET["naissance"])) {
        $naissance = $_POST["naissance"];
        $age_valide = Is_enoughAged($naissance);
        if (!$age_valide) {
            header("Location: ../profilPrive.php?numero=$num&erreur=age");
        }
        else {
            $sql_input = "UPDATE Utilisateur SET dateNaissance_Utilisateur='$naissance' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            header("Location: ../profilPrive.php?numero=$num&success=Date de naissance");
        }
    }

    if (isset($_GET["password"])) {
        $mdp = $_POST["password"];
        $mdp_conf = $_POST["password_conf"];
        $mdp_valide = Is_samePassword($mdp, $mdp_conf);
        if (!$mdp_valide) {
            header("Location: ../profilPrive.php?numero=$num&erreur=mdp");
        }
        else {
            $sql_input = "UPDATE Utilisateur SET password_Utilisateur='$mdp' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            header("Location: ../profilPrive.php?numero=$num&success=Mot de passe");
        }
    }

    if (isset($_GET["pp"])) {
        $pp = $_POST["pp"];
        $img_path = "Images/PhotoProfil/" . $pp;

        $sql_input = "UPDATE Utilisateur SET photoProfil_Utilisateur='$img_path' WHERE id_Utilisateur='$num'";
        $sql_input_res = writeDB($my_sqli, $sql_input);
        header("Location: ../profilPrive.php?numero=$num&success=Photo de profil");
    }
?>