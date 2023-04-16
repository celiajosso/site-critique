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

function displayArticleInformations($article) {
    echo "<pre>"; print_r($article); echo "</pre>";

    $titre_article = $article[0][0]["titre_Article"];
    $dateCrea_article = $article[0][0]["dateCreation_Article"];
    $dateModif_article = $article[0][0]["dateModification_Article"];
    $contenu_article = $article[0][0]["contenu_Article"];

    // ajouter nom des redacteur et modifieur
    // ajouter avis

    $titre_jeu = $article[1][0]["nom"];
    $prix_jeu = $article[1][0]["prix"];
    $dateSortie_Jeu = $article[1][0]["date_sortie"];
    $synopsis_jeu = $article[1][0]["synopsis"];

    echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
}

?>