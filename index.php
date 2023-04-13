<?php
session_start();
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site - A completer
require_once("./includes/constantes.php");      //constantes du site
require_once("./includes/config-bdd.php");      //constantes du site
include_once("./php/functions-DB.php");
//include_once("./php/functions_query.php");
//include_once("./php/functions_structure.php");
$my_sqli = connectionDB();

?>

<!DOCTYPE html lang="fr">


<?php
    echo "<h1>Article</h1>";            
    $sql_input = "SELECT * FROM Article";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";
    echo "<br><br>";

    echo "<h1>Support</h1><br><br>";            
    $sql_input = "SELECT * FROM Support";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>est_Support</h1><br><br>";            
    $sql_input = "SELECT * FROM est_Support";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>Categorie</h1><br><br>";            
    $sql_input = "SELECT * FROM Categorie";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>est_Categorie</h1><br><br>";            
    $sql_input = "SELECT * FROM est_Categorie";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>Jeu</h1><br><br>";            
    $sql_input = "SELECT * FROM Jeu";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>Avis</h1><br><br>";            
    $sql_input = "SELECT * FROM Avis";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>Utilisateur</h1><br><br>";            
    $sql_input = "SELECT * FROM Utilisateur";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>Role</h1><br><br>";            
    $sql_input = "SELECT * FROM Role";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>Image</h1><br><br>";            
    $sql_input = "SELECT * FROM Image";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";

    echo "<h1>est_Image</h1><br><br>";            
    $sql_input = "SELECT * FROM est_Image";
    $sql_input_res = readDB($my_sqli, $sql_input);
    echo "<pre>";
    print_r($sql_input_res);
    echo "</pre>";


?>
