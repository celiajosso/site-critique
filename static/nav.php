<?php
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site - A completer
require_once("./includes/constantes.php");      //constantes du site
date_default_timezone_set('Europe/Paris');
?>

<?php

$lien = $_SERVER['REQUEST_URI'];
$sep = explode('/', $lien);
$page_courante= end($sep);

if (isset ($_SESSION['username'])) {
    if ($_SESSION['role'] == 1){
        echo "<nav>";
        echo "<ul class='ul-navigation'>";

            if ($page_courante == 'index.php' || str_starts_with($page_courante, 'article.php')) {
                echo "<li class='li-navigation-twoparts' id='active'>";
            }
            else {
                echo "<li class='li-navigation-twoparts'>";
            }

                echo "<a href='index.php'>";
                    echo "Jeux Videos";
                echo "</a>";
            echo "</li>";

            echo "<li class='li-navigation-twoparts'>";
                echo "<a href='./php/logout.php'>";
                    echo "Déconnexion";
                echo "</a>";
            echo "</li>";
        echo "</ul>";
    echo "</nav>";
    }
    
    elseif ($_SESSION['role'] == 2){
        echo "<nav>";
        echo "<ul class='ul-navigation'>";

            if ($page_courante == 'index.php' || str_starts_with($page_courante, 'article.php')) {
                echo "<li class='li-navigation-threeparts' id='active'>";
            }
            else {
                echo "<li class='li-navigation-threeparts'>";
            }

                echo "<a href='index.php'>";
                    echo "Jeux Videos";
                echo "</a>";
            echo "</li>";

            

            if ($page_courante == 'redacArticle.php') {
                echo "<li class='li-navigation-threeparts' id='active'>";
            }
            else {
                echo "<li class='li-navigation-threeparts'>";
            }

                echo "<a href='redacArticle.php'>";
                    echo "Rédiger un article";
                echo "</a>";
            echo "</li>";

            echo "<li class='li-navigation-threeparts'>";
                echo "<a href='./php/logout.php'>";
                    echo "Déconnexion";
                echo "</a>";
            echo "</li>";
        echo "</ul>";
    echo "</nav>";
    }
    else {
        echo "<nav>";
        echo "<ul class='ul-navigation'>";

            if ($page_courante == 'index.php' || str_starts_with($page_courante, 'article.php')) {
                echo "<li class='li-navigation-fourparts' id='active'>";
            }
            else {
                echo "<li class='li-navigation-fourparts'>";
            }

                echo "<a href='index.php'>";
                    echo "Jeux Videos";
                echo "</a>";
            echo "</li>";

            if ($page_courante == 'redacArticle.php') {
                echo "<li class='li-navigation-fourparts' id='active'>";
            }
            else {
                echo "<li class='li-navigation-fourparts'>";
            }
                echo "<a href='redacArticle.php'>";
                    echo "Rédiger un article";
                echo "</a>";
            echo "</li>";


            if ($page_courante == 'gestionRoles.php') {
                echo "<li class='li-navigation-fourparts' id='active'>";
            }
            else {
                echo "<li class='li-navigation-fourparts'>";
            }
                echo "<a href='gestionRoles.php'>";
                    echo "Gérer les rôles";
                echo "</a>";
            echo "</li>";

            echo "<li class='li-navigation-fourparts'>";
                echo "<a href='./php/logout.php'>";
                    echo "Déconnexion";
                echo "</a>";
            echo "</li>";
        echo "</ul>";
    echo "</nav>";
    }
}

else {
    echo "<nav>";
    echo "<ul class='ul-navigation'>";

    if ($page_courante == 'index.php' || str_starts_with($page_courante, 'article.php')) {
        echo "<li class='li-navigation-twoparts' id='active'>";
    }
    else {
        echo "<li class='li-navigation-twoparts'>";
    }

        echo "<a href='index.php'>";
            echo "Jeux Videos";
        echo "</a>";
    echo "</li>";

    if ($page_courante == 'authentification.php' || $page_courante == 'registration.php' || $page_courante == 'connection.php') {
        echo "<li class='li-navigation-twoparts' id='active'>";
    }
    else {
        echo "<li class='li-navigation-twoparts'>";
    }

        echo "<a href='authentification.php'>";
            echo "Connexion | Inscription";
        echo "</a>";
    echo "</li>";

    echo "</ul>";
echo "</nav>";
}
?>