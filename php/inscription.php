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

$login = $_POST["login"];

$mdp = $_POST["mdp"];

$mdp_confirmation = $_POST["mdp-confirmation"];

$choix_pp = $_POST["choix-pp"];

$login_unique = Is_loginUnique($my_sqli, $login);

$age_valide = Is_enoughAged($naissance);

$mdp_valide = Is_samePassword($mdp, $mdp_confirmation);


if ($login_unique) {
    echo "login unique";
}
else {
    echo "login pas unique";
}

echo "<br>";

if ($age_valide) {
    echo "age valide";
}
else {
    echo "age pas valide";
}

echo "<br>";

if ($mdp_valide) {
    echo "mdp valide";
}
else {
    echo "mdp pas valide";
}


// $is_dresseur = IsDresseur($my_sqli, $username, $password);

// if ($is_dresseur) {
//     $sql_id = "SELECT id_dresseur FROM dresseur WHERE nom_dresseur = '$username' AND mdp_dresseur= '$password'";
//     $res_id = readDB($my_sqli, $sql_id);
//     $id = $res_id[0]['id_dresseur'];
     
//     $_SESSION['username'] = $username;
//     $_SESSION['id'] = $id;
//     $_SESSION['is_connected'] = 1;
//     closeDB($my_sqli);
//     header("Location: ../index.php");
// }
// else {
//     header("Location: ../connection.php");
// }

// echo "$username";
// echo "$password";
// echo "$is_dresseur";

?>