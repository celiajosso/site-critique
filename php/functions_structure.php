<?php
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site - A completer
include_once("./php/functions-DB.php");
include_once("./php/functions_query.php");
include_once("./php/functions_structure.php");
$my_sqli = connectionDB();

function displayArticles ($articles) {
    $i = 0;
    foreach ($articles as $cle => $val ) {
        $id = $articles[$i]["id_Article"];
        
        echo "<a href='article.php?numero=$id'>Article #$id</a>";
        echo "<br><br>";
        $i = $i + 1;
}
}

?>