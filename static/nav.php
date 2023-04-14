<?php
//affichage des erreurs côté PHP et côté MYSQLI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Import du site - A completer
require_once("./includes/constantes.php");      //constantes du site
?>

<?php

$lien = $_SERVER['REQUEST_URI'];
$sep = explode('/', $lien);
$page_courante= end($sep);

if (isset ($_SESSION['username'])) {
    echo "<nav>";
    echo "<ul class='ul-navigation'>";

        if ($page_courante == 'index.php') {
            echo "<li class='li-navigation' id='active'>";
        }
        else {
            echo "<li class='li-navigation'>";
        }

            echo "<a href='index.php'>";
                echo "Jeux Videos";
            echo "</a>";
        echo "</li>";

        echo "<li class='li-navigation'>";
            echo "<a href='./php/logout.php'>";
                echo "Déconnexion";
            echo "</a>";
        echo "</li>";

        if ($page_courante == 'updatepokedex.php') {
            echo "<li class='li-navigation' id='active'>";
        }
        else {
            echo "<li class='li-navigation'>";
        }

            echo "<a href='updatepokedex.php'>";
                echo "Modifier";
            echo "</a>";
        echo "</li>";
    echo "</ul>";
echo "</nav>";
}

else {
    echo "<nav>";
    echo "<ul class='ul-navigation'>";

    if ($page_courante == 'index.php') {
        echo "<li class='li-navigation' id='active'>";
    }
    else {
        echo "<li class='li-navigation'>";
    }

        echo "<a href='index.php'>";
            echo "Jeux Videos";
        echo "</a>";
    echo "</li>";

    if ($page_courante == 'connection.php') {
        echo "<li class='li-navigation' id='active'>";
    }
    else {
        echo "<li class='li-navigation'>";
    }

        echo "<a href='connection.php'>";
            echo "Authentification";
        echo "</a>";
    echo "</li>";

    echo "</ul>";
echo "</nav>";
}
?>