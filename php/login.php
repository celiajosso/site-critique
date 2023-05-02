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

$my_sqli = connectionDB();
date_default_timezone_set('Europe/Paris');
?>

<?php
$login = addslashes($_POST["login"]);
$mdp = addslashes($_POST["mdp"]);
$isMember = IsMember($my_sqli, $login, $mdp);

if ($isMember) {
    $sql_id = "SELECT prenom_Utilisateur, id_Role FROM Utilisateur WHERE login_Utilisateur = '$login' AND password_Utilisateur= '$mdp'";
    $res_id = readDB($my_sqli, $sql_id);
    $prenom = $res_id[0]['prenom_Utilisateur'];
    $role = $res_id[0]['id_Role'];
     
    $_SESSION['username'] = $login;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['role'] = $role;
    $_SESSION['is_connected'] = 1;

    $sql_id_user = "SELECT id_Utilisateur FROM Utilisateur WHERE login_Utilisateur='$login'";
    $sql_id_user_res = readDB($my_sqli, $sql_id_user);
    $id_user = $sql_id_user_res[0]["id_Utilisateur"];

    $today_with_h_m = date("Y-m-d H:i");

    $sql_update_date_connexion = "UPDATE Utilisateur SET dateConnexion_Utilisateur='$today_with_h_m' WHERE id_Utilisateur=$id_user";
    $sql_update_date_connexion_res = writeDB($my_sqli, $sql_update_date_connexion);

    closeDB($my_sqli);
    header("Location: ../index.php");
}
else {
    header("Location: ../connection.php?login=$login&erreur=1");
}
?>