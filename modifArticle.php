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
        <title>Gamecrit - Modification d'un article</title>
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
        $num = $_GET["numero"];

        $sql_article = "SELECT * FROM Article WHERE id_Article=$num";
        $sql_article_res = readDB($my_sqli, $sql_article);

        $titre_article = $sql_article_res[0]["titre_Article"];
        $critique = $sql_article_res[0]["contenu_Article"];
        $note = $sql_article_res[0]["noteRedacteur_Article"];

        $sql_jeu = "SELECT * FROM Jeu INNER JOIN Article on Article.id_Jeu = Jeu.id_Jeu WHERE id_Article=$num";
        $sql_jeu_res = readDB($my_sqli, $sql_jeu);

        $num_jeu = $sql_jeu_res[0]["id_Jeu"];
        $nom_jeu = $sql_jeu_res[0]["nom"];
        $prix = $sql_jeu_res[0]["prix"];
        $date_sortie = $sql_jeu_res[0]["date_sortie"];
        $synopsis = $sql_jeu_res[0]["synopsis"];

        $titre_article = htmlspecialchars($titre_article, ENT_QUOTES);
        $nom_jeu = htmlspecialchars($nom_jeu, ENT_QUOTES);

        echo "<div class='form-style-5'>";
            echo "<form action='./php/verifModifArticle.php?numero=$num' method='POST'>";
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

                            echo "<input type='text' maxlength='100' name='titre_article' placeholder='Titre article *' value='$titre_article' required>";
                            
                            echo "<input type='text' onfocus='(this.type=`date`)' name='date_sortie' placeholder='Date de sortie du jeu *' value='$date_sortie' required>";
                            
                        echo "</div>";
                    
                        echo "<div class='right-column'>";

                            echo "<input type='text' maxlength='30' name='nom_jeu' placeholder='Nom du jeu *' value='$nom_jeu' required>";
                    
                            echo "<input type='number' min='0' step='0.01' name='prix' placeholder='Prix du jeu *' value='$prix' required>";
                    
                        echo "</div>";
                
                    echo "</div>";
                    
                    echo "<div class='form-content'>";
                        echo "<textarea name='synopsis' maxlength='300' rows='5' placeholder='Synopsis' required='required'>$synopsis</textarea>";
                    echo "</div>";

                    $sql_categorie = "SELECT id_Categorie FROM Categorie";
                    $sql_categorie_res = readDB($my_sqli, $sql_categorie);
            
                    $sql_support = "SELECT id_Support FROM Support";
                    $sql_support_res = readDB($my_sqli, $sql_support);

                    $sql_selected_categories = "SELECT id_Categorie FROM est_Categorie WHERE id_Jeu = $num_jeu";
                    $sql_selected_categories_res = readDB($my_sqli, $sql_selected_categories);

                    $sql_selected_supports = "SELECT id_Support FROM est_Support WHERE id_Jeu = $num_jeu";
                    $sql_selected_supports_res = readDB($my_sqli, $sql_selected_supports);

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
                                        $c=0;
                                        foreach ($sql_selected_categories_res as $cle2 => $val2) {
                                            foreach ($val2 as $cle3 => $val3) {
                                                if ($val3 == $i) {
                                                    echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ' checked/></div>";
                                                    $c=1;
                                                }
                                            }
                                        }
                                        if ($c==0) {
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

                                        $c=0;
                                        foreach ($sql_selected_supports_res as $cle2 => $val2) {
                                            foreach ($val2 as $cle3 => $val3) {
                                                if ($val3 == $i) {
                                                    echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ' checked/></div>";
                                                    $c=1;
                                                }
                                            }
                                        }
                                        if ($c==0) {
                                            echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'/></div>";
                                        }

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
                echo "<div class='form-content'>";
                    echo "<div class='left-column'>";
                    echo "<input type='number' min='0' max='10' name='note' placeholder='Note du jeu (/10) *' value='$note' required>";
                    
                    echo "<textarea name='critique' maxlength='2000' rows='14' placeholder='Critique *' required='required'>$critique</textarea>";

                    echo "</div>";
                    echo "<div class='right-column'>";
                        echo "<div>";
                            echo "<h3 class='a-centrer'>Choisissez l'image de jaquette</h3>";
                            echo "<p class='a-centrer'>(Répertoire : Images/Jeu/)</p>";
                            echo "<input type=file name='jaquette' required>";
                        echo "</div>";
                        echo "<div>";
                            echo "<h3 class='a-centrer'>Choisissez l'image de Gameplay</h3>";
                            echo "<p class='a-centrer'>(Répertoire : Images/Jeu/)</p>";
                            echo "<input type=file name='gameplay' required>";
                        echo "</div>";
                echo "</div>";   
            echo "</fieldset>";
            echo "<input type='submit' value='Modifier'>";         
            echo "</form>";
        echo "</div>";
    echo "<br><br><br><br>";
    ?>
    <?php include("./static/footer.php"); ?>
<html>