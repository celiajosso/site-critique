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


<header>
    <?php
    if (isset ($_SESSION['username'])) {

        $username=$_SESSION['username'];

        $sql_pp = "SELECT photoProfil_Utilisateur FROM Utilisateur WHERE login_Utilisateur='$username'";
        $sql_pp_res = readDB($my_sqli, $sql_pp);
        $pp = $sql_pp_res[0]["photoProfil_Utilisateur"];

        $sql_id_user = "SELECT id_Utilisateur FROM Utilisateur WHERE login_Utilisateur='$username'";
        $sql_id_user_res = readDB($my_sqli, $sql_id_user);
        $id_user = $sql_id_user_res[0]["id_Utilisateur"];

        echo "<div class='left-header'><a id='lien-logo' href='index.php'>";
            echo "<img id='logo-connected' src='Images/logo.png' alt='Logo de Gamecrit'>";
        echo "</a></div>";
        echo "<div id='separator'></div>";
        echo "<div class='right-header'>";
        echo "<a href='profilPrive.php?numero=$id_user'>";
        echo "<img id='pp-connected' src='$pp' alt='Photo de profil de l'utilisateur connecté'>";
        echo "</a>";
        echo "<p class='a-centrer'>Bonjour $username !</p>";
        echo "</div>";

    }
    else {
        echo "<a href='index.php'>";
            echo "<img id='logo' src='Images/logo.png' alt='Logo de Gamecrit'>";
        echo "</a>";
    }
    ?>
</header>