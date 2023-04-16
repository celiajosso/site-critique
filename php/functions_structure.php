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

    $titre_article = $article[0][0]["titre_Article"];
    $dateCrea_article = $article[0][0]["dateCreation_Article"];
    $dateModif_article = $article[0][0]["dateModification_Article"];
    $contenu_article = $article[0][0]["contenu_Article"];
    $noteRedacteur_article = $article[0][0]["noteRedacteur_Article"];

    $UtilisateurCrea_article = $article[1][0]["login_Utilisateur"];
    
    if (!empty($article[2])) {
        $UtilisateurModif_article = $article[2][0]["login_Utilisateur"];
    }
    else {
        $UtilisateurModif_article = "";
    }

    $titre_jeu = $article[3][0]["nom"];
    $prix_jeu = $article[3][0]["prix"];
    $dateSortie_Jeu = $article[3][0]["date_sortie"];
    $synopsis_jeu = $article[3][0]["synopsis"];

    $image_gameplay = $article[4][0]["chemin_Image"];
    $image_jaquette = $article[4][1]["chemin_Image"];

    $jeu_categories = $article[5];
    $jeu_supports = $article[6];
    
    // ajouter avis

    echo "<div class='titre-article-individuel'><h1>$titre_article</h1></div>";
    echo "<br><br>";
    echo "<div class='infos-article'>";
    echo "<div class='flex-content'>";
    echo "<div class='left-column'>";

    echo "<img class='image-jaquette' src=$image_jaquette>";

    echo "</div>";
    echo "<div class='right-column'>";
    echo "<h1>$titre_jeu</h1>";
    echo "<br><br>";

    echo "<div class='flex-content'>";
    foreach ($jeu_categories as $cle => $val) {
        foreach ($val as $cle1 => $val1) {
            $chemin_type = "Images/Categories/" . $val1 . ".png";
            echo "<img class='image-type' src='$chemin_type'>";
        }
    }
    echo "</div>";

    echo "<br>";

    echo "<div class='flex-content'>";

    foreach ($jeu_supports as $cle => $val) {
        foreach ($val as $cle1 => $val1) {
            $chemin_type = "Images/Supports/" . $val1 . ".png";
            echo "<img class='image-type' src='$chemin_type'>";
        }
    }

    echo "</div>";

    echo "</div>";

    echo "</div>";
    
    echo "<br><br>";

    echo "<div class='text-content'>";
    echo "<table>";
        echo "<tr>";
        echo "<th class='col1'>Date de sortie</th>";
        echo "<th class='col2'>Prix</th>";
        echo "<th class='col3'>Synopsis</th>";
        echo "</tr>";
    
        echo "<tr>";
            echo "<td>$dateSortie_Jeu</td>";
            echo "<td>$prix_jeu €</td>";
            echo "<td class='to-justify'>$synopsis_jeu</td>";
        echo "</tr>";
        
        echo "</table>";
        echo "<div>";

        echo "<br><br>";

        echo "<h1>Critique du rédacteur</h1>";
        echo "<p class='to-justify'>$contenu_article<p>";

        echo "<h2 class='to-place-right'>Note du rédacteur : $noteRedacteur_article</h2>";
        echo "<br>";
        
        echo "<img class='image-gameplay' src=$image_gameplay>";

        echo "<div class='to-place-right'>";
        echo "<h3>Rédigé par : $UtilisateurCrea_article ($dateCrea_article)</h3>";        
        if (!empty($UtilisateurModif_article)) {
            echo "<h3>Modifié par : $UtilisateurModif_article le $dateModif_article</h3>";
        }
        echo "</div>";

        echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "<br><br><br><br><br><br>";
}


?>