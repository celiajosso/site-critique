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
include_once("./php/functions_query.php");
include_once("./php/functions_structure.php");
$my_sqli = connectionDB();

?>

<!DOCTYPE html lang="fr">

    <head>
        <title>Gamecrit - Rédaction d'un article</title>
        <meta name="author" content="NORTON Thomas, JOSSO Célia">
        <meta name="author" content="ESIR, CUPGE">
        
        <link rel="icon" href="Images/icone.png">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/nav.css">
        <link rel="stylesheet" href="styles/footer.css">
        <link rel="stylesheet" href="styles/form.css">
    </head>

    <?php include("./static/header.php"); ?>
    <?php include("./static/nav.php"); ?>
    <?php
        if (isset($_GET["erreur"])) {
            if ($_GET["erreur"] == "jeu") {
                echo "<div class='erreur-inscription'><h2>Erreur !</h2>Un article a déjà été écrit sur ce jeu !<br><br></div>";
            }
        }
        if (isset($_GET["success"])) {
            echo "<div class='erreur-inscription'><h2>Article envoyé avec succès !</div>";
        }
    ?>
    <?php
        echo "<div class='form-style-5'>";
            echo "<form action='./php/ajoutArticle.php' method='POST'>";
              echo "<fieldset>";
                echo "<br>";
                echo "<legend>";
                    echo "<span class='number'>";
                        echo "1";
                    echo "</span>";
                    echo "Informations sur le jeu";
                echo "</legend>";
                    echo "<div class='form-content'>";
                        echo "<div class='left-column'>";

                        if (isset($_GET['titre_article'])) {
                            $titre_article = $_GET['titre_article'];
                            echo "<input type='text' maxlength='100' name='titre_article' placeholder='Titre article *' value='$titre_article' required>";
                        }
                        else {
                            echo "<input type='text' maxlength='100' name='titre_article' placeholder='Titre article *' required>";
                        } 

                            if (isset($_GET['date_sortie'])) {
                            $date_sortie = $_GET['date_sortie'];
                            echo "<input type='text' onfocus='(this.type=`date`)' name='date_sortie' placeholder='Date de sortie du jeu *' value='$date_sortie' required>";
                            }
                            else {
                                echo "<input type='text' onfocus='(this.type=`date`)' name='date_sortie' placeholder='Date de sortie du jeu *' required>";
                            }    
                        echo "</div>";
                    echo "<div class='right-column'>";

                    if (isset($_GET['nom_jeu'])) {
                        $nom_jeu = $_GET['nom_jeu'];
                        echo "<input type='text' maxlength='30' name='nom_jeu' placeholder='Nom du jeu *' value='$nom_jeu' required>";
                    }
                    else {
                        echo "<input type='text' maxlength='30' name='nom_jeu' placeholder='Nom du jeu *' required>";
                    } 

                    if (isset($_GET['prix'])) {
                        $prix = $_GET['prix'];
                        echo "<input type='number' min='0' step='0.01' name='prix' placeholder='Prix du jeu *' value='$prix' required>";
                        }
                        else {
                            echo "<input type='number' min='0' step='0.01' name='prix' placeholder='Prix du jeu *' required>";
                        }
                    
                    echo "</div>";
                echo "</div>";
                echo "<div class='form-content'>";
                if (isset($_GET['synopsis'])) {
                    $synopsis = $_GET['synopsis'];
                    echo "<textarea name='synopsis' maxlength='300' rows='5' placeholder='Synopsis' required='required'>$synopsis</textarea>";

                }
                else {
                    echo "<textarea name='synopsis' maxlength='300' rows='5' placeholder='Synopsis' required='required'></textarea>";
                } 
                echo "</div>";

                $sql_categorie = "SELECT id_Categorie FROM Categorie";
                $sql_categorie_res = readDB($my_sqli, $sql_categorie);
        
                $sql_support = "SELECT id_Support FROM Support";
                $sql_support_res = readDB($my_sqli, $sql_support);

                echo "<div class='form-content'>";
                        echo "<div class=left-column'>";
                            echo "<h3 class='a-centrer'>Catégories du jeu</h3>";

                            // boucle
                            $i = 1;
                            foreach ($sql_categorie_res as $cle => $val) {
                                foreach ($val as $cle1 => $val1) {
                                    $chemin_type = "Images/Categories/" . $val1 . ".png";
                                    $nom_champ = "categorie_" . "$i";

                                    echo "<div class='form-content'>";
                                        if (isset($_GET["cat_$i"])) {
                                            if ($_GET["cat_$i"] == 1) {
                                                echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ' checked/></div>";
                                            }
                                        }
                                        else {
                                            echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'/></div>";
                                        }
                                        
                                        echo "<div class='right-column-checkbox'><img class='icone-type' src='$chemin_type'></div>";
                                    echo "</div>";
                                    echo "<br><br>";
                                    $i = $i + 1;
                                }
                            }

                        echo "</div>";

                        echo "<div class=right-column'>";
                            echo "<h3 class='a-centrer'>Supports du jeu</h3>";

                            // boucle
                            $i = 1;
                            foreach ($sql_support_res as $cle => $val) {
                                foreach ($val as $cle1 => $val1) {
                                    $chemin_type = "Images/Supports/" . $val1 . ".png";
                                    $nom_champ = "support_" . "$i";

                                    echo "<div class='form-content'>";
                                        echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'/></div>";
                                        echo "<div class='right-column-checkbox'><img class='icone-type' src='$chemin_type'></div>";
                                    echo "</div>";
                                    echo "<br><br>";
                                    $i = $i + 1;
                                }
                            }



                    echo "</div>";  
                echo "</div>";

                echo "<br>";
                echo "<legend>";
                    echo "<span class='number'>";
                        echo "2";
                    echo "</span>";
                    echo "Votre critique";
                echo "</legend>";
                echo "<br>";
                    if (isset($_GET['note'])) {
                        $note = $_GET['note'];
                        echo "<input type='number' min='0' max='10' name='note' placeholder='Note du jeu (/10) *' value='$note' required>";
                    }
                    else {
                        echo "<input type='number' min='0' max='10' name='note' placeholder='Note du jeu (/10) *' required>";
                    }

                    if (isset($_GET['critique'])) {
                        $critique = $_GET['critique'];
                        echo "<textarea name='critique' maxlength='2000' rows='8' placeholder='Critique *' required='required'>$critique</textarea>";
                    }
                    else {
                        echo "<textarea name='critique' maxlength='2000' rows='8' placeholder='Critique *' required='required'></textarea>";
                    }


                    
            echo "</fieldset>";
            echo "<input type='submit' value='Envoyer'>";         
            echo "</form>";
        echo "</div>";
    echo "<br><br><br><br>";
    ?>
    <?php include("./static/footer.php"); ?>
<html>