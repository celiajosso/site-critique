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

function displayArticles ($my_sqli, $jeux) {
    $jeux_res = $jeux[0];
    $sql_categorie_res = $jeux[1];

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

    elseif (!isset($_GET["q"]) && !empty($_GET) && !isset($_GET["inscription"])) {

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
    
    $all_data = ArticlesBySearch($my_sqli, $jeux_res);

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

    if (isset($_GET["success"])) {
        echo "<div class='erreur-inscription'><h2>Article modifié avec succès !</div><br><br>";
    }
    
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

        $tab = connectedInfos($my_sqli, $login_connected);
        $id_connected = $tab[0];
        $role = $tab[1];

        $sql_avis_ecrit_res = avisEcrits($my_sqli, $id_connected, $num);

        $tab = createurModifieurArticle($my_sqli, $num);
        $id_createur = $tab[0];
        $id_modifieur = $tab[1];

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

        $tab = loginPpAvis($my_sqli, $id_user);
        $login = $tab[0];
        $pp = $tab[1];

        echo "<h1>========================</h1>";
        if (!empty($_SESSION)) {
            $tab = connectedInfos($my_sqli, $login_connected);
            $id_connected = $tab[0];
            $role = $tab[1];
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
        if (isset($id_connected)) {
            if ($id_user != $id_connected) {
                echo "<a href='profilPublic.php?numero=$id_user'><img src='$pp'/><a>";
            }
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

    $role = recupRole($my_sqli, $id_role);

    if (isset($_GET["erreur"])) {
        if ($_GET["erreur"] == "age") {
            echo "<div class='erreur-inscription'><h2>Erreur !</h2>Vous êtes trop jeune ! Vous devez avoir au moins 15 ans !<br><br></div>";
        }
        if ($_GET["erreur"] == "login"){
            echo "<div class='erreur-inscription'><h2>Erreur !</h2>Ce nom d'utilisateur est déjà pris !<br><br></div>";
        }
        if ($_GET["erreur"] == "unchanged"){
            echo "<div class='erreur-inscription'><h2>Aucun champ modifié.<h2></div>";
        }
    }

    if (isset($_GET["success"])) {
        $champ = $_GET["success"];
        echo "<div class='erreur-inscription'><h2>Champ « $champ » modifié avec succès !</div><br><br>";
    }

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
    echo "<br><br><br><br><br><br><br><br><br><br>";
}

function displayUserPublicInformations($my_sqli, $tab) {
    $login = $tab[0]["login_Utilisateur"];
    $pp = $tab[0]["photoProfil_Utilisateur"];
    $creation = $tab[0]["dateCreation_Utilisateur"];
    $connexion = $tab[0]["dateConnexion_Utilisateur"];
    $id_role = $tab[0]["id_Role"];

    $duree = Duration($connexion);
    $creation = writeDate($creation);

    $role = recupRole($my_sqli, $id_role);

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
    echo "<br><br><br><br><br><br><br><br><br><br>";
}

function displayInscription() {
    if (isset($_GET["erreur"])) {
        if ($_GET["erreur"] == "age") {
            echo "<div class='erreur-inscription'><h2>Erreur !</h2>Vous êtes trop jeune ! Vous devez avoir au moins 15 ans !<br><br></div>";
        }
        if ($_GET["erreur"] == "login"){
            echo "<div class='erreur-inscription'><h2>Erreur !</h2>Ce nom d'utilisateur est déjà pris !<br><br></div>";
        }
        if ($_GET["erreur"] == "mdp"){
            echo "<div class='erreur-inscription'><h2>Erreur !</h2>Le mot de passe confirmé est différent du mot de passe saisi !<br><br></div>";
        }
    }

    echo "<div class='form-style-5'>";

        echo "<form action='./php/inscription.php' method='POST'>";

            echo "<fieldset>";
            echo "<br>";

            echo "<legend>";
                echo "<span class='number'>1</span>";
                echo "Vos informations personnelles";
            echo "</legend>";

            echo "<div class='form-content'>";

                echo "<div class='left-column'>";

                    if (isset($_GET['nom'])) {
                        $nom = $_GET['nom'];
                        echo "<input type='text' maxlength='50' name='nom' placeholder='Nom *' value='$nom' required>";
                    }
                    else {
                        echo "<input type='text' maxlength='50' name='nom' placeholder='Nom *' required>";
                    }

                    if (isset($_GET['prenom'])) {
                        $prenom = $_GET['prenom'];
                        echo "<input type='text' maxlength='50' name='prenom' placeholder='Prénom *' value='$prenom' required>";
                    }
                    else {
                        echo "<input type='text' maxlength='50' name='prenom' placeholder='Prénom *' required>";
                    }

                echo "</div>";

                echo "<div class='right-column'>";

                if (isset($_GET['mail'])) {
                    $mail = $_GET['mail'];
                    echo "<input type='email' maxlength='50' name='mail' placeholder='Adresse mail *' value='$mail' required>";
                }
                else {
                    echo "<input type='email' maxlength='50' name='mail' placeholder='Adresse mail *' required>";
                }

                $today = date('Y-m-d'); 

                if (isset($_GET['naissance'])) {
                    $naissance = $_GET['naissance'];
                    echo "<input type='text' onfocus='(this.type=`date`)' max='$today' name='naissance' placeholder='Date de naissance *' value='$naissance' required>";
                }
                else {
                    echo "<input type='text' onfocus='(this.type=`date`)' max='$today' name='naissance' placeholder='Date de naissance *' required>";
                }
                
                echo "</div>";

            echo "</div>";
            echo "<br>";

            echo "<legend>";
                echo "<span class='number'>2</span>";
                echo "Vos identifiants";
            echo "</legend>";
            echo "<br>";

            echo "<div class='form-content'>";

                echo "<div class='left-column'>";

                if (isset($_GET['login'])) {
                    $login = $_GET['login'];
                    echo "<input type='text' maxlength='50' name='login' placeholder='Login *' value='$login' required>";
                }
                else {
                    echo "<input type='text' maxlength='50' name='login' placeholder='Login *' required>";
                }

                if (isset($_GET['mdp'])) {
                    $mdp = $_GET['mdp'];
                    echo "<input type='password' maxlength='50' name='mdp' placeholder='Mot de passe *' value='$mdp' required>";
                }
                else {
                    echo "<input type='password' maxlength='50' name='mdp' placeholder='Mot de passe *' required>";
                }

                if (isset($_GET['mdp_confirmation'])) {
                    $mdp_confirmation = $_GET['mdp_confirmation'];
                    echo "<input type='password' maxlength='50' name='mdp-confirmation' placeholder='Confirmation du mot de passe *' value='$mdp_confirmation' required>";
                }
                else {
                    echo "<input type='password' maxlength='50' name='mdp-confirmation' placeholder='Confirmation du mot de passe *' required>";
                }

                echo "</div>";

                echo "<div class='right-column'>";
                    echo "<h3 class='a-centrer'>Choisissez votre photo de profil</h3>";
                    echo "<p class='a-centrer'>(Répertoire : Images/PhotoProfil/)</p>";
                    echo "<input type=file name='choix-pp'required>";
                echo "</div>";   

        echo "</fieldset>";
        echo "<input type='submit' value='Inscription'>";       

    echo "</form>";

    echo "</div>";
    echo "<br><br><br><br>";
}

function displayRedacArticle ($my_sqli) {
    if (isset($_GET["erreur"])) {
        if ($_GET["erreur"] == "jeu") {
            echo "<div class='erreur-inscription'><h2>Erreur !</h2>Un article a déjà été écrit sur ce jeu !<br><br></div>";
        }
    }
    if (isset($_GET["success"])) {
        echo "<div class='erreur-inscription'><h2>Article envoyé avec succès !</div>";
    }

    echo "<div class='form-style-5'>";

        echo "<form action='./php/ajoutArticle.php' method='POST'>";

            echo "<fieldset>";
            echo "<br>";
            
                echo "<legend>";
                    echo "<span class='number'>1</span>";
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

                    $today = date('Y-m-d'); 

                    if (isset($_GET['date_sortie'])) {
                        $date_sortie = $_GET['date_sortie'];
                        echo "<input type='text' onfocus='(this.type=`date`)' max='$today' name='date_sortie' placeholder='Date de sortie du jeu *' value='$date_sortie' required>";
                    }
                    else {
                        echo "<input type='text' onfocus='(this.type=`date`)' max='$today' name='date_sortie' placeholder='Date de sortie du jeu *' required>";
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

            $sql_categorie_res = idCategories($my_sqli);
            $sql_support_res = idSupports($my_sqli);

            echo "<div class='form-content'>";

                echo "<div class=left-column'>";

                    echo "<h3 class='a-centrer'>Catégories du jeu</h3>";

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
                                    else {
                                        echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'/></div>";
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

                    $i = 1;

                    foreach ($sql_support_res as $cle => $val) {

                        foreach ($val as $cle1 => $val1) {
                            $chemin_type = "Images/Supports/" . $val1 . ".png";
                            $nom_champ = "support_" . "$i";

                            echo "<div class='form-content'>";

                            if (isset($_GET["sup_$i"])) {
                                if ($_GET["sup_$i"] == 1) {
                                    echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ' checked/></div>";
                                }
                                else {
                                    echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ'/></div>";
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
            echo "</div>";
            echo "<br>";

            echo "<legend>";
                echo "<span class='number'>2</span>";
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
}

function displayModifArticleInfos ($my_sqli) {
    $num = $_GET["numero"];

    $tab = modifArticleInfosArticleJeu($my_sqli, $num);
    $sql_article_res = $tab[0];
    $sql_jeu_res = $tab[1];

    $titre_article = $sql_article_res[0]["titre_Article"];
    $critique = $sql_article_res[0]["contenu_Article"];
    $note = $sql_article_res[0]["noteRedacteur_Article"];

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
                    echo "<span class='number'>1</span>";
                    echo "Informations sur le jeu";
                echo "</legend>";

                echo "<div class='form-content'>";

                    echo "<div class='left-column'>";

                        echo "<input type='text' maxlength='100' name='titre_article' placeholder='Titre article *' value='$titre_article' required>";
                        
                        $today = date('Y-m-d'); 
                        echo "<input type='text' onfocus='(this.type=`date`)' max='$today' name='date_sortie' placeholder='Date de sortie du jeu *' value='$date_sortie' required>";
                        
                    echo "</div>";
                
                    echo "<div class='right-column'>";

                        echo "<input type='text' maxlength='30' name='nom_jeu' placeholder='Nom du jeu *' value='$nom_jeu' required>";
                
                        echo "<input type='number' min='0' step='0.01' name='prix' placeholder='Prix du jeu *' value='$prix' required>";
                
                    echo "</div>";
            
                echo "</div>";
                
                echo "<div class='form-content'>";
                    echo "<textarea name='synopsis' maxlength='300' rows='5' placeholder='Synopsis' required='required'>$synopsis</textarea>";
                echo "</div>";

                $sql_categorie_res = idCategories($my_sqli);
                $sql_support_res = idSupports($my_sqli);

                $tab = modifArticleInfosCatSup($my_sqli, $num_jeu);
                $sql_selected_categories_res = $tab[0];
                $sql_selected_supports_res = $tab[1];

            echo "<div class='form-content'>";

                    echo "<div class=left-column'>";

                        echo "<h3 class='a-centrer'>Catégories du jeu</h3>";

                        $i = 1;

                        foreach ($sql_categorie_res as $cle => $val) {

                            foreach ($val as $cle1 => $val1) {
                                $chemin_type = "Images/Categories/" . $val1 . ".png";
                                $nom_champ = "categorie_" . "$i";

                                echo "<div class='form-content'>";
                                    $c = 0;

                                    foreach ($sql_selected_categories_res as $cle2 => $val2) {

                                        foreach ($val2 as $cle3 => $val3) {

                                            if ($val3 == $i) {
                                                echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ' checked/></div>";
                                                $c = 1;
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

                        $i = 1;

                        foreach ($sql_support_res as $cle => $val) {

                            foreach ($val as $cle1 => $val1) {

                                $chemin_type = "Images/Supports/" . $val1 . ".png";
                                $nom_champ = "support_" . "$i";

                                echo "<div class='form-content'>";

                                    $c = 0;

                                    foreach ($sql_selected_supports_res as $cle2 => $val2) {

                                        foreach ($val2 as $cle3 => $val3) {

                                            if ($val3 == $i) {
                                                echo "<div class='left-column-checkbox'><input type='checkbox' name='$nom_champ' checked/></div>";
                                                $c = 1;
                                            }
                                        }
                                    }

                                    if ($c == 0) {
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
                echo "<span class='number'>2</span>";
                echo "Votre critique";
            echo "</legend>";
            echo "<br>";

            echo "<input type='number' min='0' max='10' name='note' placeholder='Note du jeu (/10) *' value='$note' required>";
            echo "<textarea name='critique' maxlength='2000' rows='8' placeholder='Critique *' required='required'>$critique</textarea>";

        echo "</fieldset>";

        echo "<input type='submit' value='Modifier'>";         
    echo "</form>";
    echo "</div>";
    echo "<br><br><br><br>";
}

function displayGestionRoles ($my_sqli) {

    if (isset($_GET["erreur"])) {
        $login = $_GET["login"];
        echo "<div class='erreur-inscription'><h2>Erreur !</h2>$login possède déjà ce rôle.<br><br></div>";
    }
    if (isset($_GET["success"])) {
        echo "<div class='erreur-inscription'><h2>Rôle changé avec succès !</div>";
    }
    
    $login_admin = $_SESSION["username"];

    $sql_noms_res = usernamesChangementRole($my_sqli, $login_admin);

    echo "<div class='form-style-5'>";

        echo "<form action='./php/verifRole.php' method='POST'>";

            echo "<fieldset>";  

                echo "<div class='form-content'>";

                    echo "<div class='left-column'>";

                        echo "<h3 class='a-centrer'>Login Utilisateur</h3>";

                            echo "<select name='login' class='select-option'>";

                                foreach($sql_noms_res as $cle => $val) {
                                        $login = $val['login_Utilisateur'];
                                        echo "<option value='$login'>$login</option>";
                                }
        
                            echo "</select>";

                    echo "</div>";
                    
                    echo "<div class='right-column'>";

                        echo "<h3 class='a-centrer'>Rôle attribué</h3>";

                        echo "<select name='role' class='select-option'>";
                            echo "<option value='1'>Membre</option>";
                            echo "<option value='2'>Rédacteur</option>";
                            echo "<option value='3'>Administrateur</option>";
                        echo "</select>";

                    echo "</div>";

                echo "</div>";
            
            echo "</fieldset>";

            echo "<input type='submit' value='Changer le rôle'>";

        echo "</form>";
    echo "</div>";
    echo "<br><br><br><br>";
}

function displayConnection () {

    if (isset($_GET["erreur"])) {
        echo "<div class='erreur-inscription'><h2>Erreur !</h2>Utilisateur ou mot de passe incorrect.<br><br></div>";
    }

    echo "<div class='form-style-5'>";

        echo "<form action='./php/login.php' method='POST'>";

            echo "<fieldset>";
            echo "<br>";

                echo "<legend>";
                    echo "<h2 class='a-centrer'>Connexion</h2>";
                echo "</legend>";

                echo "<div class='form-content'>";

                    echo "<div class='left-column'>";

                        if (isset($_GET['login'])) {
                            $login = $_GET['login'];
                            echo "<input type='text' name='login' placeholder='Login *' value='$login' required>";
                        }
                        else {
                            echo "<input type='text' name='login' placeholder='Login *' required>";
                        }

                        if (isset($_GET['prenom'])) {
                            $mdp = $_GET['mdp'];
                            echo "<input type='text' name='mdp' placeholder='Mot de passe *' value='$mdp' required>";
                        }
                        else {
                            echo "<input type='password' name='mdp' placeholder='Mot de passe *' required>";
                        }
                        
                    echo "</div>";

                echo "</div>";
                echo "<br>";
                
            echo "</fieldset>";

            echo "<input type='submit' value='Connexion'>";   

        echo "</form>";
    echo "</div>";
    echo "<br><br><br><br>";
}

function displayAuthentification () {
    echo "<div class='authentification-buttons'>";
        echo "<div>";
            echo "<h2>Vous possédez déjà un compte Gamecrit ?</h2>";
            echo "<br>";
            echo "<a href='connection.php'><button>Se connecter</button></a>";
        echo "</div>";
    echo "<div>";
            echo "<h2>Vous êtes nouveau ?</h2>";
            echo "<br>";
            echo "<a href='registration.php'><button>S'inscrire</button></a>";
            echo "</div>";
    echo "</div>";
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