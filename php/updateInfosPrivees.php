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

        $login = addslashes($_POST["login"]);
        $login_unique = Is_loginUnique($my_sqli, $login);

        if (!$login_unique) {
            $sql_login_initial = "SELECT login_Utilisateur FROM Utilisateur WHERE id_Utilisateur = $num";
            $sql_login_initial_res = readDB($my_sqli, $sql_login_initial);
            $login_initial = $sql_login_initial_res[0]["login_Utilisateur"];

            if ($login == $login_initial) {
                header("Location: ../profilPrive.php?numero=$num&erreur=unchanged");
            }
            else {
                header("Location: ../profilPrive.php?numero=$num&erreur=login");
            } 

        }
        else {
            $login = addslashes($_POST["login"]);
            $sql_input = "UPDATE Utilisateur SET login_Utilisateur='$login' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            $_SESSION["username"] = $login;
            header("Location: ../profilPrive.php?numero=$num&success=Login");
        }
    }

    if (isset($_GET["nom"])) {
        $nom = addslashes($_POST["nom"]);
        $sql_nom_initial = "SELECT nom_Utilisateur FROM Utilisateur WHERE id_Utilisateur = $num";
        $sql_nom_initial_res = readDB($my_sqli, $sql_nom_initial);
        $nom_initial = $sql_nom_initial_res[0]["nom_Utilisateur"];

        if ($nom == $nom_initial) {
            header("Location: ../profilPrive.php?numero=$num&erreur=unchanged");
        }
        else {
            $sql_input = "UPDATE Utilisateur SET nom_Utilisateur='$nom' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            header("Location: ../profilPrive.php?numero=$num&success=Nom");
        } 

    }

    if (isset($_GET["prenom"])) {
        $prenom = addslashes($_POST["prenom"]);

        $sql_prenom_initial = "SELECT prenom_Utilisateur FROM Utilisateur WHERE id_Utilisateur = $num";
        $sql_prenom_initial_res = readDB($my_sqli, $sql_prenom_initial);
        $prenom_initial = $sql_prenom_initial_res[0]["prenom_Utilisateur"];

        if ($prenom == $prenom_initial) {
            header("Location: ../profilPrive.php?numero=$num&erreur=unchanged");
        }
        else {
            $sql_input = "UPDATE Utilisateur SET prenom_Utilisateur='$prenom' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            header("Location: ../profilPrive.php?numero=$num&success=Prénom");
        }

    }

    if (isset($_GET["mail"])) {
        $mail = addslashes($_POST["mail"]);

        $sql_mail_initial = "SELECT mail_Utilisateur FROM Utilisateur WHERE id_Utilisateur = $num";
        $sql_mail_initial_res = readDB($my_sqli, $sql_mail_initial);
        $mail_initial = $sql_mail_initial_res[0]["mail_Utilisateur"];

        if ($mail == $mail_initial) {
            header("Location: ../profilPrive.php?numero=$num&erreur=unchanged");
        }
        else {
            $sql_input = "UPDATE Utilisateur SET mail_Utilisateur='$mail' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            header("Location: ../profilPrive.php?numero=$num&success=Adresse mail");
        }

    }

    if (isset($_GET["naissance"])) {
        $naissance = $_POST["naissance"];
        $age_valide = Is_enoughAged($naissance);

        if (!$age_valide) {
            header("Location: ../profilPrive.php?numero=$num&erreur=age");
        }
        else {
            $sql_naissance_initial = "SELECT dateNaissance_Utilisateur FROM Utilisateur WHERE id_Utilisateur = $num";
            $sql_naissance_initial_res = readDB($my_sqli, $sql_naissance_initial);
            $naissance_initial = $sql_naissance_initial_res[0]["dateNaissance_Utilisateur"];

            if ($naissance == $naissance_initial) {
                header("Location: ../profilPrive.php?numero=$num&erreur=unchanged");
            }
            else {
                $sql_input = "UPDATE Utilisateur SET dateNaissance_Utilisateur='$naissance' WHERE id_Utilisateur='$num'";
                $sql_input_res = writeDB($my_sqli, $sql_input);
                header("Location: ../profilPrive.php?numero=$num&success=Date de naissance");
            }

        }
    }

    if (isset($_GET["password"])) {
        $mdp = addslashes($_POST["password"]);

        $sql_mdp_initial = "SELECT password_Utilisateur FROM Utilisateur WHERE id_Utilisateur = $num";
        $sql_mdp_initial_res = readDB($my_sqli, $sql_mdp_initial);
        $mdp_initial = $sql_mdp_initial_res[0]["password_Utilisateur"];

        if ($mdp == $mdp_initial) {
            header("Location: ../profilPrive.php?numero=$num&erreur=unchanged");
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

        $sql_pp_initial = "SELECT photoProfil_Utilisateur FROM Utilisateur WHERE id_Utilisateur = $num";
        $sql_pp_initial_res = readDB($my_sqli, $sql_pp_initial);
        $pp_initial = $sql_pp_initial_res[0]["photoProfil_Utilisateur"];

        if ($img_path == $pp_initial || empty($pp)) {
            header("Location: ../profilPrive.php?numero=$num&erreur=unchanged");
        }
        else {
            $sql_input = "UPDATE Utilisateur SET photoProfil_Utilisateur='$img_path' WHERE id_Utilisateur='$num'";
            $sql_input_res = writeDB($my_sqli, $sql_input);
            header("Location: ../profilPrive.php?numero=$num&success=Photo de profil");
        }

    }
?>