<?php

function getArticles ($my_sqli) {
    // retourne un tableau associatif
    // avec les identifiants des articles éligibles à la recherche

    // si la barre de recherche par nom de jeu est utilisée
    if(isset($_GET['q']) && !empty($_GET['q'])) {
        $q = htmlspecialchars($_GET['q']);
        $jeux = "SELECT id_Article FROM Article INNER JOIN Jeu ON Jeu.id_Jeu = Article.id_Jeu WHERE Jeu.nom LIKE '%$q%' ORDER BY dateCreation_Article DESC";
        $jeux_res = readDB($my_sqli, $jeux);
    }

    // si la barre de recherche par categorie de jeu est utilisée
    elseif (isset($_GET) && !empty($_GET) && !isset($_GET['q'])) {
        $sql_categorie = "SELECT id_Categorie FROM Categorie";
        $sql_categorie_res = readDB($my_sqli, $sql_categorie);
    
        $nb_categories = count($sql_categorie_res);
        
        $selected_categories = Array();
    
        for ($i=1; $i < $nb_categories+1; $i++) {
            if(isset($_GET["c_$i"])) {
                $selected_categories[] = 1;
            }
            else {
                $selected_categories[] = 0;
            }
        }
    
        $condition = " ";

        foreach($selected_categories as $cle => $val) {
            if ($val) {
                $index = $cle + 1;
                $condition = $condition . "id_Categorie = $index OR ";
            }
        }

        $condition = substr($condition, 1,-3);
    
        if (!empty($condition)) {
            $jeux = "SELECT id_Article FROM Article INNER JOIN Jeu ON Jeu.id_Jeu = Article.id_Jeu INNER JOIN est_Categorie ON est_Categorie.id_Jeu = Article.id_Jeu WHERE $condition GROUP BY id_Article ORDER BY dateCreation_Article DESC";
            $jeux_res = readDB($my_sqli, $jeux);
        }
        else {
            $jeux = "SELECT id_Article FROM Article ORDER BY dateCreation_Article DESC";
            $jeux_res = readDB($my_sqli, $jeux); 
        }    
    }

    // si aucune barre de recherche est utilisée
    else {
        $jeux = "SELECT id_Article FROM Article ORDER BY dateCreation_Article DESC";
        $jeux_res = readDB($my_sqli, $jeux);      
    }

    $sql_categorie_res = idCategories($my_sqli);

    return Array($jeux_res, $sql_categorie_res);    
}

function getArticleInformations ($my_sqli) {
    // Retourne un tableau associatif
    // Contenant les informations suivantes
    //      - Titre de l'article
    //      - Catégories du jeu
    //      - Supports du jeu
    //      - Date de sortie du jeu
    //      - Nom du jeu
    //      - Prix du jeu
    //      - Synopsis du jeu
    //      - Critique du rédacteur
    //      - Image de jaquette
    //      - Image de gameplay
    //      - Login du rédacteur + date
    //      - Login du modifieur + date si existant
    //      - Les avis de l'article
    //          - Login
    //          - Note
    //          - Titre de l'avis
    //          - Contenu de l'avis
    //          - Date de rédaction de l'avis

    if (!isset ($_GET['numero'])) {
        header("Location: index.php");
    }

    else {
        $num = $_GET['numero'];

        $sql_article = "SELECT titre_Article, dateCreation_Article, dateModification_Article, contenu_Article, noteRedacteur_Article FROM Article WHERE id_Article=$num";
        $sql_article_res = readDB($my_sqli, $sql_article);

        $sql_login_modif = "SELECT login_Utilisateur, id_Utilisateur FROM Utilisateur INNER JOIN Article on Utilisateur.id_Utilisateur = Article.id_UtilisateurModifieur WHERE Article.id_Article=$num";
        $sql_login_modif_res = readDB($my_sqli, $sql_login_modif);

        $sql_login_crea = "SELECT login_Utilisateur, id_Utilisateur FROM Utilisateur INNER JOIN Article on Utilisateur.id_Utilisateur = Article.id_UtilisateurCreateur WHERE Article.id_Article=$num";
        $sql_login_crea_res = readDB($my_sqli, $sql_login_crea);

        $sql_jeu = "SELECT nom, prix, date_sortie, synopsis FROM Jeu INNER JOIN Article ON Jeu.id_Jeu = Article.id_Jeu WHERE Article.id_Article=$num";
        $sql_jeu_res = readDB($my_sqli, $sql_jeu);

        $sql_avis = "SELECT contenu_avis, dateCreation_avis, id_Utilisateur, note_Avis, titre_Avis FROM Avis INNER JOIN Article ON Article.id_Article = Avis.id_Article WHERE Article.id_Article=$num";
        $sql_avis_res = readDB($my_sqli, $sql_avis);

        $sql_moyenne = "SELECT AVG(note_avis) as moyenne FROM Avis INNER JOIN Article ON Article.id_Article = Avis.id_Article WHERE Article.id_Article=$num";
        $sql_moyenne_res = readDB($my_sqli, $sql_moyenne);

        $sql_images_article = "SELECT chemin_Image FROM Image INNER JOIN est_image ON Image.id_Image = est_Image.id_Image WHERE id_Article=$num";
        $sql_images_article_res = readDB($my_sqli, $sql_images_article);

        $sql_categorie = "SELECT id_Categorie FROM est_Categorie INNER JOIN Jeu ON est_Categorie.id_Jeu = Jeu.id_Jeu INNER JOIN Article on Jeu.id_Jeu=Article.id_Jeu WHERE Article.id_Article=$num";
        $sql_categorie_res = readDB($my_sqli, $sql_categorie);

        $sql_support = "SELECT id_Support FROM est_Support INNER JOIN Jeu ON est_Support.id_Jeu = Jeu.id_Jeu INNER JOIN Article on Jeu.id_Jeu=Article.id_Jeu WHERE Article.id_Article=$num";
        $sql_support_res = readDB($my_sqli, $sql_support);

        return Array ($sql_article_res, $sql_login_crea_res, $sql_login_modif_res, $sql_jeu_res, $sql_images_article_res, $sql_categorie_res, $sql_support_res, $sql_avis_res, $sql_moyenne_res);
    }
}

function getUserPrivateInformations($my_sqli, $id_user) {
    $sql_input = "SELECT * FROM Utilisateur WHERE id_Utilisateur = $id_user";
    $sql_input_res = readDB($my_sqli, $sql_input);

    // Bonus : mettre les avis rédigés par la personnne
    // Bonus : quand les avis seront fait -> mettre les avis rédigés par la personnne

    return $sql_input_res;
}

function Is_loginUnique ($my_sqli, $username) {
    // Vérifie si le login entre par le nouvel utilisateur est unique

    $username = htmlspecialchars($username, ENT_QUOTES);
    $sql_inscription = "SELECT login_Utilisateur FROM Utilisateur WHERE login_Utilisateur = '$username'";
    $res_inscription = readDB($my_sqli, $sql_inscription);

    return (empty($res_inscription));
}

function Is_gameUnique($my_sqli, $game) {
    // Vérifie si le jeu entre par l'utilisateur est unique

    $sql_game = "SELECT * FROM Jeu WHERE nom = '$game'";
    $res_game = readDB($my_sqli, $sql_game);

    return (empty($res_game));
}

function Is_enoughAged ($naissance) {
    // Vérifie si le nouvel utilisateur a plus de 15 ans
    $naissance = new DateTime($naissance);
    $today = new DateTime(date("Y-m-d"));

    $nb_annees = ($naissance->diff($today))-> format('%y');

    return $nb_annees > 14;
}

function Is_samePassword ($password, $password_conf) {
    // Vérifie si le nouvel utilisateur a plus de 15 ans
    return $password == $password_conf;
}

function IsMember ($my_sqli, $username, $password) {
    // Vérifie si un utilisateur existe dans la BDD
    //      - Vérifie le login
    //      - Vérifie le mdp
    //      - retourne un tableau associatif

    $sql_connexion = "SELECT id_Utilisateur FROM Utilisateur WHERE login_Utilisateur = '$username' AND password_Utilisateur = '$password'";
    $res_login = readDB($my_sqli, $sql_connexion);

    return (!empty($res_login));
}

function Is_ChangedRole ($my_sqli, $login, $chosen_role) {
    // Vérifie le role choisi est bien différent du role initial

    $role_utilisateur = "SELECT id_Role FROM Utilisateur WHERE login_Utilisateur='$login'";
    $role_utilisateur_res = readDB($my_sqli, $role_utilisateur);

    $changed_role = "SELECT * FROM Utilisateur WHERE login_Utilisateur='$login' AND id_Role='$chosen_role'";
    $changed_role_res = readDB($my_sqli, $changed_role);

    return (empty($changed_role_res));
}

function Duration($date) {
    // Renvoie le temps passe depuis la date en parametre
    // ex :
    // il y a moins d'une minute
    // il y a 2 minutes
    // il y a 1 heure
    // il y a 3 mois
    // il y a 2 ans

    $date = new DateTime($date);
    $today = new DateTime(date('Y-m-d H:i'));

    $interval = $date->diff($today);
    $min = $interval->format('%i');
    $hours = $interval->format('%h');
    $days = $interval->format('%a');
    $months = $interval->format('%m');
    $years = $interval->format('%y');

    if ($years == 0) {
        if ($months == 0) {
            if ($days == 0) {
                if ($hours == 0) {
                    if ($min == 0) {
                        $expr = "moins d'une minute.";
                    }
                    else {
                        if ($min == 1) {
                            $expr = "1 minute.";
                        }
                        else {
                            $expr = "$min minutes.";
                        }
                    }
                }
                else {
                    if ($hours == 1) {
                        $expr = "1 heure.";
                    }
                    else {
                        $expr = "$hours heures.";
                    }
                }
            }
            else {
                if ($days == 1) {
                    $expr = "1 jour.";
                }
                else {
                    $expr = "$days jours.";
                }
            }
        }
        else {
            $expr = "$months mois.";
        }
    }
    else {
        if ($years == 1) {
            $expr = "1 an.";
        }
        else {
            $expr = "$years ans.";
        }
    }

    return $expr;
}

function writeDate($date) {
    // Ecrit une date en format "français"
    // ex :
    // "2023-02-05" -> "5 février 2023"

    $date = date_create($date);
    $days = $date->format('j');
    $months = $date->format('m');
    $years = $date->format('y');

    if ($years < 50) {
        $years = "20$years";
    }
    else {
        $years = "19$years";
    }
    
    $months_list = Array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    $months = $months_list[$months-1];

    if ($days == 1) {
        return "$days". "er " . "$months $years";
    }
    else {
        return "$days $months $years";
    }
    
}

function idCategories($my_sqli) {
    // Renvoie les identifiants des categories

    $sql_categorie = "SELECT id_Categorie FROM Categorie";
    $sql_categorie_res = readDB($my_sqli, $sql_categorie);
    return $sql_categorie_res;
}

function idSupports($my_sqli) {
    // Renvoie les identifiants des supports

    $sql_support = "SELECT id_Support FROM Support";
    $sql_support_res = readDB($my_sqli, $sql_support);
    return $sql_support_res;
}

function articlesBySearch($my_sqli, $jeux_res) {
    // retourne toutes les informations que doit faire retourner la recherche
    // informations sur : 
    //    - l'article
    //    - l'utilisateur créateur de l'article
    //    - l'utilisateur modifieur de l'article
    //    - le chemin vers la jaquette du jeu
    //    - la note globale des utilisateurs sur le jeu

    $all_data = Array();

    foreach($jeux_res as $cle => $val) {

        foreach ($val as $cle1 => $id) {

        $sql_data_article = "SELECT id_Article, titre_Article, noteRedacteur_Article, dateCreation_Article FROM Article INNER JOIN Utilisateur ON Article.id_UtilisateurCreateur = Utilisateur.id_Utilisateur WHERE id_Article=$id";
        $sql_data_article_res = readDB($my_sqli, $sql_data_article);

        $sql_data_utilisateur = "SELECT login_Utilisateur, id_Utilisateur FROM Utilisateur INNER JOIN Article ON Article.id_UtilisateurCreateur = Utilisateur.id_Utilisateur WHERE id_Article=$id";
        $sql_data_utilisateur_res = readDB($my_sqli, $sql_data_utilisateur);

        $sql_data_jaquette = "SELECT chemin_Image FROM Image INNER JOIN est_Image ON est_Image.id_Image = Image.id_Image INNER JOIN Article ON Article.id_Article = est_Image.id_Article WHERE Article.id_Article=$id AND chemin_Image LIKE '%jaquette%'";
        $sql_data_jaquette_res = readDB($my_sqli, $sql_data_jaquette);

        $sql_data_note = "SELECT AVG(note_Avis) as note_moy FROM Avis INNER JOIN Article ON Article.id_Article = Avis.id_Article WHERE Article.id_Article=$id";
        $sql_data_note_res = readDB($my_sqli, $sql_data_note);

        foreach ($sql_data_article_res as $cle => $val) {
            $login = Array("login_Utilisateur" => $sql_data_utilisateur_res[0]["login_Utilisateur"]);
            $id = Array("id_Utilisateur" => $sql_data_utilisateur_res[0]["id_Utilisateur"]);
            $jaquette = Array("chemin_Image" => $sql_data_jaquette_res[0]["chemin_Image"]);
            $note_moy = Array("note_moy" => $sql_data_note_res[0]["note_moy"]);

            array_push($sql_data_article_res[$cle], $login, $jaquette, $note_moy, $id);
        }

        array_push($all_data, $sql_data_article_res);
        }
    }

    return $all_data;
}

function articlesOnPrivatePage($my_sqli, $id_connected) {

    $all_data = Array();

    $sql_data_article = "SELECT id_Article, titre_Article, noteRedacteur_Article, dateCreation_Article FROM Article INNER JOIN Utilisateur ON Article.id_UtilisateurCreateur = Utilisateur.id_Utilisateur WHERE id_Utilisateur=$id_connected ORDER BY dateCreation_Article DESC";
    $sql_data_article_res = readDB($my_sqli, $sql_data_article);

    $sql_data_jaquette = "SELECT chemin_Image FROM Image INNER JOIN est_Image ON est_Image.id_Image = Image.id_Image INNER JOIN Article ON Article.id_Article = est_Image.id_Article WHERE Article.id_UtilisateurCreateur=$id_connected AND chemin_Image LIKE '%jaquette%' ORDER BY dateCreation_Article DESC";
    $sql_data_jaquette_res = readDB($my_sqli, $sql_data_jaquette);

    $sql_data_note = "SELECT Article.id_Article, AVG(Avis.note_Avis) as note_moy FROM Avis INNER JOIN Article ON Article.id_Article = Avis.id_Article WHERE Article.id_UtilisateurCreateur=$id_connected GROUP BY Article.id_Article ORDER BY Article.dateCreation_Article DESC";
    $sql_data_note_res = readDB($my_sqli, $sql_data_note);

    foreach ($sql_data_article_res as $cle => $val) {
        $jaquette = Array("chemin_Image" => $sql_data_jaquette_res[$cle]["chemin_Image"]);

        foreach ($sql_data_note_res as $cle1 => $val1) {
            if ($sql_data_article_res[$cle]["id_Article"] == $val1["id_Article"]) {
                $note_moy = Array("note_moy" => $val1["note_moy"]);
            }
        }
        
        if (isset($note_moy)) {
            array_push($sql_data_article_res[$cle], $jaquette, $note_moy);
        }
        else {
            array_push($sql_data_article_res[$cle], $jaquette);
        }
        
    }

    array_push($all_data, $sql_data_article_res);
    return $all_data;
}

function connectedInfos($my_sqli, $login_connected) {
    // retourne les identifiants de l'utilisateur
    //    - indentifiant personnel
    //    - indentifiant de rôle

    $sql_id_connected = "SELECT id_Utilisateur, id_role FROM Utilisateur WHERE login_Utilisateur='$login_connected'";
    $sql_id_connected_res = readDB($my_sqli, $sql_id_connected);

    $id_connected = $sql_id_connected_res[0]["id_Utilisateur"];
    $role = $sql_id_connected_res[0]["id_role"];

    return Array($id_connected, $role);
}

function avisEcrits($my_sqli, $id_connected, $num) {
    // retourne les informations sur l'avis
    // laissé par la personne connectée
    // pour un article donné

    $sql_avis_ecrit = "SELECT * FROM Avis WHERE id_Utilisateur=$id_connected AND id_Article=$num";
    $sql_avis_ecrit_res = readDB($my_sqli, $sql_avis_ecrit);

    return $sql_avis_ecrit_res;
}

function createurModifieurArticle($my_sqli, $num){
    // retourne les identifiants des créateur et modifieur
    // pour un article donné

    $sql_createur_modifieur = "SELECT id_UtilisateurCreateur, id_UtilisateurModifieur FROM Article WHERE id_Article=$num";
    $sql_createur_modifieur_res = readDB($my_sqli, $sql_createur_modifieur);
    $id_createur = $sql_createur_modifieur_res[0]["id_UtilisateurCreateur"];
    $id_modifieur = $sql_createur_modifieur_res[0]["id_UtilisateurModifieur"];

    return Array($id_createur, $id_modifieur);
}

function loginPpAvis($my_sqli, $id_user){
    // retourne le login et la pp pour un utilisateur donne
    // utile pour l'affichage des avis

    $sql_user = "SELECT login_Utilisateur, photoProfil_Utilisateur FROM Utilisateur WHERE id_Utilisateur=$id_user";
    $sql_user_res = readDB($my_sqli, $sql_user);

    $login = $sql_user_res[0]["login_Utilisateur"];
    $pp = $sql_user_res[0]["photoProfil_Utilisateur"];

    return Array($login, $pp);
}

function recupRole($my_sqli, $id_role) {
    // recupere le role a partir de l'id du role

    $sql_input = "SELECT nom_Role FROM Role WHERE id_Role=$id_role";
    $sql_input_res = readDB($my_sqli, $sql_input);

    $role = $sql_input_res[0]["nom_Role"];

    return $role;
}

function recupUsername($my_sqli, $id_user) {
    // recupere le pseudo a partir de l'id de l'utilisateur

    $sql_input = "SELECT login_Utilisateur FROM Utilisateur WHERE id_Utilisateur=$id_user";
    $sql_input_res = readDB($my_sqli, $sql_input);

    $login = $sql_input_res[0]["login_Utilisateur"];

    return $login;
}

function modifArticleInfosArticleJeu ($my_sqli, $num) {
    // retourne les infos necessaires à la modification d'un article

    $sql_article = "SELECT * FROM Article WHERE id_Article=$num";
    $sql_article_res = readDB($my_sqli, $sql_article);

    $sql_jeu = "SELECT * FROM Jeu INNER JOIN Article on Article.id_Jeu = Jeu.id_Jeu WHERE id_Article=$num";
    $sql_jeu_res = readDB($my_sqli, $sql_jeu);

    return Array($sql_article_res, $sql_jeu_res);
}

function modifArticleInfosCatSup ($my_sqli, $num_jeu) {
    // retourne les infos necessaires à la modification d'un article

    $sql_selected_categories = "SELECT id_Categorie FROM est_Categorie WHERE id_Jeu = $num_jeu";
    $sql_selected_categories_res = readDB($my_sqli, $sql_selected_categories);

    $sql_selected_supports = "SELECT id_Support FROM est_Support WHERE id_Jeu = $num_jeu";
    $sql_selected_supports_res = readDB($my_sqli, $sql_selected_supports);

    return Array($sql_selected_categories_res, $sql_selected_supports_res);
}

function usernamesChangementRole ($my_sqli, $login_admin) {
    $sql_noms = "SELECT login_Utilisateur FROM Utilisateur WHERE login_Utilisateur <> '$login_admin'";
    $sql_noms_res = readDB($my_sqli, $sql_noms);
    return $sql_noms_res;
}

function avis($mysqli,$id_Utilisateur,$id_Jeu){
    // Retourne l'avis d'un jeu. 
    $tableau = readDB($mysqli,"SELECT avis.titre_Avis, avis.contenu_Avis, avis.dateCreation_Avis, avis.note_Avis, utilisateur.login_Utilisateur, utilisateur.photoProfil_Utilisateur FROM avis JOIN utilisateur ON avis.id_Utilisateur=utilisateur.id_Utilisateur JOIN article ON avis.id_Article=article.id_Article WHERE avis.id_Article=$id_Jeu AND avis.id_Utilisateur=$id_Utilisateur");
    return $tableau;
}

function note_moyenne($mysqli,$id_Jeu){
    // Retourne la note moyenne d'un jeu.
    $tableau = readDB($mysqli,"SELECT AVG(note_Avis) FROM avis WHERE id_Article=$id_Jeu");
    return $tableau[0]["AVG(note_Avis)"];
}

function avis_totale($mysqli,$id_Utilisateur){
    // Retourne le nombre d'avis totale d'un utilisateur. 
    $tableau = readDB($mysqli,"SELECT COUNT(*) FROM avis WHERE avis.id_Utilisateur=$id_Utilisateur");
    return $tableau[0]['COUNT(*)'];
}

function utilisateurAvis ($my_sqli, $id_article) {
    // Retourne les id des utilisateurs ayant laissé leur avis sur un jeu
    $sql_utilisateur_avis = "SELECT id_Utilisateur FROM Avis WHERE id_Article=$id_article ORDER BY dateCreation_Avis DESC";
    $sql_utilisateur_avis_res = readDB($my_sqli, $sql_utilisateur_avis);
    return $sql_utilisateur_avis_res;
}

function add_review($mysqli,$titre_Avis,$contenu_Avis,$date,$note_Avis,$id_connected,$id_article){
    writeDB($mysqli,"INSERT INTO avis (titre_Avis, contenu_Avis, dateCreation_avis, note_Avis, id_Utilisateur, id_Article) VALUES ('$titre_Avis','$contenu_Avis','$date',$note_Avis,$id_connected,$id_article)");

}

function supprime_avis($mysqli,$id_user,$id_article){
    writeDB($mysqli,"DELETE FROM avis WHERE avis.id_Utilisateur=$id_user and avis.id_Article=$id_article");
}

function modifie_avis($mysqli,$titre_Avis,$contenu_Avis,$note_Avis,$id_connected,$id_article){
    writeDB($mysqli,"UPDATE avis SET avis.titre_Avis='$titre_Avis', avis.contenu_Avis='$contenu_Avis', avis.note_Avis=$note_Avis  WHERE avis.id_Utilisateur=$id_connected AND avis.id_Article=$id_article");
}

function get_avis($mysqli,$id_connected,$id_article){
    $tableau=readDB($mysqli,"SELECT avis.titre_Avis, avis.contenu_Avis, avis.note_Avis FROM avis WHERE avis.id_Utilisateur=$id_connected AND avis.id_Article=$id_article");
    return $tableau;
}
?>
