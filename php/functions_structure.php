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
date_default_timezone_set('Europe/Paris');

function displayArticles ($my_sqli, $jeux_res) {
    // === RECHERCHE PAR NOM DE JEU ===
    echo "<br>";
    echo "<div class='search-content'>";

    echo "<form class='left' method='GET'>";
    echo "<h3>Recherche par nom de jeu :</h3><br><br><br>";
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        echo "<input type='search' size = '30' name='q' value='$q' placeholder='Recherche par nom de jeu' />";
    }
    else {
        echo "<input type='search' size = '30' name='q' placeholder='Recherche par nom de jeu' />";
    }
    echo "<input type='submit' value='Valider' />";
    echo "</form>";

    // === RECHERCHE PAR CATEGORIE DE JEU ===
    echo "<form class='right' method='GET'>";
    echo "<h3 class='a-centrer'>Recherche par catégorie :</h3>";
    $sql_categorie = "SELECT id_Categorie FROM Categorie";
    $sql_categorie_res = readDB($my_sqli, $sql_categorie);
    $i = 1;
    foreach ($sql_categorie_res as $cle => $val) {
        foreach ($val as $cle1 => $val1) {
            $chemin_type = "Images/Categories/" . $val1 . ".png";
            $nom_champ = "c_" . "$i";
            echo "<div class='form-content'>";
            if (isset($_GET[$nom_champ])) {
                echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'checked/></div>";
            }
            else {
                echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'/></div>";
            }        
            echo "<div class='right-column-checkbox'><img  class='icone-type' src='$chemin_type'></div>";
            echo "</div>";
            
            $i = $i + 1;
        }}
    
    echo "<input type='submit' value='Valider' />";
    echo "</form>";
    echo "</div>";

    // === AFFICHAGE POUR LA RECHERCHE PAR NOM DE JEU ===
    if (isset($_GET["q"])) {
        $q = $_GET ["q"];
        if (!empty($jeux_res) && !empty($q)) {
            $len = count($jeux_res);
            if ($len == 1) {
                echo "<h2 class='a-centrer'>$len résultat pour la recherche : <em>$q</em></h2>";
            }
            else {
                echo "<h2 class='a-centrer'>$len résultats pour la recherche : <em>$q</em></h2>";
            }
            echo "<hr>";
            displayArticlesBySearch($my_sqli, $jeux_res);
        }
        else {
            if (!empty($q)) {
                echo "<h2 class='a-centrer'>Aucun résultat pour la recherche : <em>$q</em></h2>";
            }
            else {
                echo "<hr>";
                displayArticlesBySearch($my_sqli, $jeux_res);
            }
            echo "<br>";
        }
    }
    // === AFFICHAGE POUR LA RECHERCHE PAR CATEGORIE DE JEU ===
    elseif (!isset($_GET["q"]) && !empty($_GET)) {
        if (!empty($jeux_res)) {
            $len = count($jeux_res);
            if ($len == 1) {
                echo "<h2 class='a-centrer'>$len résultat pour cette recherche par catégorie :</h2>";
            }
            else {
                echo "<h2 class='a-centrer'>$len résultats pour cette recherche par catégorie :</h2>";
            }
            echo "<hr>";
            displayArticlesBySearch($my_sqli, $jeux_res);
        }
        else {
            if (isset($jeux_res)) {
                echo "<h2 class='a-centrer'>Aucun résultat pour cette recherche</h2>";
            }
        }
    }
    else {
        echo "<hr>";
        displayArticlesBySearch($my_sqli, $jeux_res);
    }
    echo "<br>";
    echo "</section>";
}

function displayArticlesBySearch($my_sqli, $jeux_res) {
    $all_data = Array();
    foreach($jeux_res as $cle => $val) {
        foreach ($val as $cle1 => $id) {
        $sql_data_article = "SELECT id_Article, titre_Article, noteRedacteur_Article, dateCreation_Article FROM Article INNER JOIN Utilisateur ON Article.id_UtilisateurCreateur = Utilisateur.id_Utilisateur WHERE id_Article=$id";
        $sql_data_article_res = readDB($my_sqli, $sql_data_article);
        
        $sql_data_utilisateur = "SELECT login_Utilisateur FROM Utilisateur INNER JOIN Article ON Article.id_UtilisateurCreateur = Utilisateur.id_Utilisateur WHERE id_Article=$id";
        $sql_data_utilisateur_res = readDB($my_sqli, $sql_data_utilisateur);

        $sql_data_jaquette = "SELECT chemin_Image FROM Image INNER JOIN est_Image ON est_Image.id_Image = Image.id_Image INNER JOIN Article ON Article.id_Article = est_Image.id_Article WHERE Article.id_Article=$id AND chemin_Image LIKE '%jaquette%'";
        $sql_data_jaquette_res = readDB($my_sqli, $sql_data_jaquette);

        $sql_data_note = "SELECT AVG(note_Avis) as note_moy FROM Avis INNER JOIN Article ON Article.id_Article = Avis.id_Article WHERE Article.id_Article=$id";
        $sql_data_note_res = readDB($my_sqli, $sql_data_note);

        foreach ($sql_data_article_res as $cle => $val) {
            $login = Array("login_Utilisateur" => $sql_data_utilisateur_res[0]["login_Utilisateur"]);
            $jaquette = Array("chemin_Image" => $sql_data_jaquette_res[0]["chemin_Image"]);
            $note_moy = Array("note_moy" => $sql_data_note_res[0]["note_moy"]);
            array_push($sql_data_article_res[$cle], $login, $jaquette, $note_moy);
        }
        array_push($all_data, $sql_data_article_res);
        }
    }

    // formater les donnees de $all_data ici
    echo "<div class='boite-article'>";
    foreach($all_data as $cle => $val) {
        foreach ($val as $cle1 => $val1) {
            $id_article = $val1["id_Article"];
            $titre = $val1["titre_Article"];
            $note_redacteur = $val1["noteRedacteur_Article"];
            $date_crea = writeDate($val1["dateCreation_Article"]);
            $login_crea = $val1[0]["login_Utilisateur"];
            $chemin_jaquette = $val1[1]["chemin_Image"];
            $note_users = $val1[2]["note_moy"];

            echo "<div class='article-seul'>";
            
            echo "<div class='flex-content-index'>";
            echo "<div class='left-column-index'>";
            echo "<a href='article.php?numero=$id_article'><img class='acceuil-jaquette' src='$chemin_jaquette' /><a>";
            echo "</div>";

            echo "<div class='right-column-index'>";
            echo "<h3>$titre</h3>";
            echo "Note du rédacteur : <img class='image-note' src='Images/note/$note_redacteur.png' title='$note_redacteur/10'>";
            echo "<br><br>";
            if (!empty($note_users)) {
                $note_arrondie = round($note_users);
                echo "Note moyenne des utilisateurs : <img class='image-note' src='Images/note/$note_arrondie.png' title='$note_users/10'>";
                echo "<br><br>";
            }
            
            echo "Rédigé par $login_crea ($date_crea)";
            echo "</div>";
            
            echo "</div>";
            echo "</div>";
        }
    }
    echo "</div>";
    echo "<br><br>";
}

function displayArticleInformations($article, $num, $my_sqli) {

    $titre_article = $article[0][0]["titre_Article"];
    $dateCrea_article = $article[0][0]["dateCreation_Article"];
    $dateModif_article = $article[0][0]["dateModification_Article"];
    $contenu_article = $article[0][0]["contenu_Article"];
    $noteRedacteur_article = $article[0][0]["noteRedacteur_Article"];

    $dateCrea_article = writeDate($dateCrea_article);

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

    $avis = $article[7];
    $moyenne = $article[8][0]["moyenne"];

    echo "<div class='titre-article-individuel'><h1>$titre_article</h1></div>";
    echo "<br><br>";
    echo "<div class='infos-article'>";
    echo "<div class='flex-content'>";
    echo "<div class='left-column'>";

    echo "<img class='image-jaquette' src=$image_jaquette>";

    echo "</div>";
    echo "<div class='right-column'>";
    if (!empty($_SESSION)) {
            if ($_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
        echo "<a href='modifArticle.php?numero=$num'><img class='icone-modif' alt='Modifier article' title='Modifier article' src='Images/modif.png'></a>";
    }
    }

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

        echo "<h2 class='to-place-right'>Note du rédacteur : <img class='image-note' src='Images/note/$noteRedacteur_article.png' title='$noteRedacteur_article/10'></h2>";
        echo "<br>";
        
        echo "<img class='image-gameplay' src=$image_gameplay>";

        echo "<div class='to-place-right'>";
        echo "<h3>Rédigé par : $UtilisateurCrea_article ($dateCrea_article)</h3>";        
        if (!empty($UtilisateurModif_article)) {
            $dateModif_article = writeDate($dateModif_article);
            echo "<h3>Modifié par : $UtilisateurModif_article ($dateModif_article)</h3>";
        }
        echo "</div>";

        echo "</div>";
    echo "</div>";
    echo "</div>";

    if (!empty($avis)) {
        displayAvis($avis, $moyenne, $num, $my_sqli);
    }
    else {
        echo "Aucun avis pour cet article.";
        if (!empty($_SESSION)) {
            echo "<br>BOUTON AJOUTER";
        }
    }
    echo "<br><br><br><br><br><br>";
}

function displayAvis($avis, $moyenne, $num, $my_sqli) {
    $note_arrondie = round($moyenne);
    echo "Note moyenne des utilisateurs : <img class='image-note' src='Images/note/$note_arrondie.png' title='$moyenne/10'>";
    echo "<br><br>";

    if (!empty($_SESSION)) {
        $login_connected = $_SESSION["username"];
        $sql_id_connected = "SELECT id_Utilisateur, id_role FROM Utilisateur WHERE login_Utilisateur='$login_connected'";
        $sql_id_connected_res = readDB($my_sqli, $sql_id_connected);
        $id_connected = $sql_id_connected_res[0]["id_Utilisateur"];
        $role = $sql_id_connected_res[0]["id_role"];

        $sql_avis_ecrit = "SELECT * FROM Avis WHERE id_Utilisateur=$id_connected AND id_Article=$num";
        $sql_avis_ecrit_res = readDB($my_sqli, $sql_avis_ecrit);

        $sql_createur_modifieur = "SELECT id_UtilisateurCreateur, id_UtilisateurModifieur FROM Article WHERE id_Article=$num";
        $sql_createur_modifieur_res = readDB($my_sqli, $sql_createur_modifieur);
        $id_createur = $sql_createur_modifieur_res[0]["id_UtilisateurCreateur"];
        $id_modifieur = $sql_createur_modifieur_res[0]["id_UtilisateurModifieur"];


        if (empty($sql_avis_ecrit_res) && $id_connected != $id_createur && $id_connected != $id_modifieur) {
            echo "BOUTON AJOUTER";
        } 
    }
    
    foreach ($avis as $cle => $val) {
        $titre = $val["titre_Avis"];
        $note = $val["note_Avis"];
        $id_user = $val["id_Utilisateur"];
        $date_crea_avis = $val["dateCreation_avis"];
        $contenu_avis = $val["contenu_avis"];

        $temps_avis = Duration($date_crea_avis);
        $date_avis = writeDate($date_crea_avis);

        $sql_user = "SELECT login_Utilisateur, photoProfil_Utilisateur FROM Utilisateur WHERE id_Utilisateur=$id_user";
        $sql_user_res = readDB($my_sqli, $sql_user);

        $login = $sql_user_res[0]["login_Utilisateur"];
        $pp = $sql_user_res[0]["photoProfil_Utilisateur"];


        echo "<h1>========================</h1>";
        if (!empty($_SESSION)) {
            if ($role == 3) {
                if ($id_user != $id_connected) {
                    echo "BOUTON SUPPRIMER<br>";
                }
                else {
                    echo "BOUTON MODIF + BOUTON SUPPRIMER<br>";
                }
                
            }
            else  {
                if ($id_user == $id_connected) {
                    echo "BOUTON MODIF + BOUTON SUPPRIMER<br>";
                }
                
            }            
        }
        echo "$login";
        echo "<br>";
        if ($id_user != $id_connected) {
            echo "<a href='profilPublic.php?numero=$id_user'><img src='$pp'/><a>";
        }
        else {
            echo "<a href='profilPrive.php?numero=$id_user'><img src='$pp'/><a>";
        }
        
        echo "<br>";        
        echo "$titre";
        echo "<br>";
        echo "<img class='image-note' src='Images/note/$note.png' title='$note/10'>";
        echo "<br>";
        echo "Il y a $temps_avis ($date_avis)";
        echo "<br><br>";
        echo "$contenu_avis";
    }
}

function displayUserPrivateInformations($my_sqli, $tab) {
    $num = $tab[0]["id_Utilisateur"];
    $login = $tab[0]["login_Utilisateur"];
    $password = $tab[0]["password_Utilisateur"];
    $pp = $tab[0]["photoProfil_Utilisateur"];
    $nom = $tab[0]["nom_Utilisateur"];
    $prenom = $tab[0]["prenom_Utilisateur"];
    $mail = $tab[0]["mail_Utilisateur"];
    $naissance = $tab[0]["dateNaissance_Utilisateur"];
    $creation = $tab[0]["dateCreation_Utilisateur"];
    $id_role = $tab[0]["id_Role"];

    $creation = writeDate($creation);

    $sql_input = "SELECT nom_Role FROM Role WHERE id_Role=$id_role";
    $sql_input_res = readDB($my_sqli, $sql_input);
    $role = $sql_input_res[0]["nom_Role"];

    echo "<div class='box-page-prive'>";

    echo "<div class='flex-content'>";

    echo "<div class='left-column'>";
    echo "<p class='table-title'>Photo de profil :</p><br>";
    echo "<img class='pp' src='$pp'><br><form action='./php/updateInfosPrivees.php?numero=$num&pp=1' method='POST'><input type = 'file' name='pp'><br><br><input type='submit' value='modifier'></form>";
    echo "<br><br>";

    echo "</div>";

    echo "<div class='right-column'>";

    $today = date('Y-m-d');

    echo "<table>";
        echo "<tr>";
            echo "<td class='table-title'>Login :</td>";
            echo "<td><form action='./php/updateInfosPrivees.php?numero=$num&login=1' method='POST'><input type = 'text' name='login' size= '30' maxlength = '50' value = '$login'> <input type='submit' value='modifier'></form></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Nom :</td>";
            echo "<td><form action='./php/updateInfosPrivees.php?numero=$num&nom=1' method='POST'><input type = 'text' name='nom' maxlength = '50' size= '30' value = '$nom'> <input type='submit' value='modifier'></form></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Prenom :</td>";
            echo "<td><form action='./php/updateInfosPrivees.php?numero=$num&prenom=1' method='POST'><input type = 'text' name='prenom' maxlength = '50' size= '30' value = '$prenom'> <input type='submit' value='modifier'></form></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Adresse mail :</td>";
            echo "<td><form action='./php/updateInfosPrivees.php?numero=$num&mail=1' method='POST'><input type = 'email' name='mail' maxlength = '50' size= '30' value = '$mail'> <input type='submit' value='modifier'></form></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Date de naissance :</td>";
            echo "<td><form action='./php/updateInfosPrivees.php?numero=$num&naissance=1' method='POST'><input type = 'text' size='30' onfocus='(this.type=`date`)' max='$today' name='naissance' value = '$naissance'> <input type='submit' value='modifier'></form></td>";
        echo "</tr>";
        
        echo "<tr>";
            echo "<td class='table-title'>Mot de passe :</td>";
            echo "<td><form action='./php/updateInfosPrivees.php?numero=$num&password=1' method='POST'><input type = 'password' name='password' maxlength = '50' size= '30' value = '$password'> <input type='submit' value='modifier'></form></td>";
        echo "</tr>";

        echo "</form>";

        echo "<tr>";
            echo "<td class='table-title'>Rôle :</td>";
            echo "<td>$role</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Date de création du compte :</td>";
            echo "<td>$creation</td>";
        echo "</tr>";

    echo "</table>";



    echo "</div>";

    echo "</div>";
    echo "</div>";


    echo "<br><br>";echo "<br><br>";echo "<br><br>";echo "<br><br>";echo "<br><br>";
}

function displayUserPublicInformations($my_sqli, $tab) {
    $login = $tab[0]["login_Utilisateur"];
    $pp = $tab[0]["photoProfil_Utilisateur"];
    $creation = $tab[0]["dateCreation_Utilisateur"];
    $connexion = $tab[0]["dateConnexion_Utilisateur"];
    $id_role = $tab[0]["id_Role"];

    $duree = Duration($connexion);
    $creation = writeDate($creation);

    $sql_input = "SELECT nom_Role FROM Role WHERE id_Role=$id_role";
    $sql_input_res = readDB($my_sqli, $sql_input);
    $role = $sql_input_res[0]["nom_Role"];

    echo "<div class='box-page-prive'>";

    echo "<div class='flex-content'>";

    echo "<div class='left-column'>";
    echo "<p class='table-title'>Photo de profil :</p>";
    echo "<img class='pp' src='$pp'>";

    echo "</div>";

    echo "<div class='right-column'>";

    $today = date('Y-m-d H:i');

    echo "<table>";
        echo "<tr>";
            echo "<td class='table-title'>Login :</td>";
            echo "<td>$login</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Rôle :</td>";
            echo "<td>$role</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Date de création du compte :</td>";
            echo "<td>$creation</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td class='table-title'>Dernière connexion :</td>";
            echo "<td>Il y a $duree</td>";
        echo "</tr>";

    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<br><br>";echo "<br><br>";echo "<br><br>";echo "<br><br>";echo "<br><br>";
}

function display_Avis($avis) {
    foreach($avis as $tableau){
        echo "$tableau[titre_Avis]<br>";
        echo "$tableau[contenu_Avis]<br>";
        echo "$tableau[dateCreation_Avis]<br>";
        echo "$tableau[note_Avis]<br>";
        echo "$tableau[id_Utilisateur]<br>";
    }
}
?>