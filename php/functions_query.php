<?php

function getArticles ($my_sqli) {
    // retourne un tableau associatif
    // contenant pour chaque article
    //  - son titre
    //  - sa jaquette
    //  - la note du rédacteur
    //  - la note globale des utilisateurs
    //  - la date de création + utilisateur concerné
    //  - la date de dernière modification + utilisateur concerné
    //  /!\ => compléter code pour mettre toutes les infos
    $sql_input = "SELECT id_Article FROM Article";
    $result = readDB($my_sqli, $sql_input);
    return $result;
}

function getArticleInformations ($my_sqli) {
    // Retourne un tableau associatif
    // Contenant les informations suivantes sur l'article
    //      - fait : Titre de l'article
    //      - Catégories du jeu
    //      - Supports du jeu
    //      - fait : Date de sortie du jeu
    //      - fait : Nom du jeu
    //      - fait : Prix du jeu
    //      - fait : Synopsis du jeu
    //      - fait : Critique du rédacteur
    //      - fait : Image de jaquette
    //      - fait : Image de gameplay
    //      - /!\ AJOUTER AVIS QUAND DISPO
    //      - Login du rédacteur + date
    //      - Login du modifieur + date si existant
    if (!isset ($_GET['numero'])) {
        header("Location: index.php");
    }

    else {
        $num = $_GET['numero'];

        $sql_article = "SELECT titre_Article, dateCreation_Article, dateModification_Article, contenu_Article, noteRedacteur_Article FROM Article WHERE id_Article=$num";
        $sql_article_res = readDB($my_sqli, $sql_article);

        $sql_login_modif = "SELECT login_Utilisateur FROM Utilisateur INNER JOIN Article on Utilisateur.id_Utilisateur = Article.id_UtilisateurModifieur WHERE Article.id_Article=$num";
        $sql_login_modif_res = readDB($my_sqli, $sql_login_modif);

        $sql_login_crea = "SELECT login_Utilisateur FROM Utilisateur INNER JOIN Article on Utilisateur.id_Utilisateur = Article.id_UtilisateurCreateur WHERE Article.id_Article=$num";
        $sql_login_crea_res = readDB($my_sqli, $sql_login_crea);

        $sql_jeu = "SELECT nom, prix, date_sortie, synopsis FROM Jeu INNER JOIN Article ON Jeu.id_Jeu = Article.id_Jeu WHERE Article.id_Article=$num";
        $sql_jeu_res = readDB($my_sqli, $sql_jeu);

        // ajouter ici pour avis (INNER JOIN entre avis et utilisateur)

        $sql_images_article = "SELECT chemin_Image FROM Image INNER JOIN est_image ON Image.id_Image = est_Image.id_Image WHERE id_Article=$num";
        $sql_images_article_res = readDB($my_sqli, $sql_images_article);

        $sql_categorie = "SELECT id_Categorie FROM est_Categorie INNER JOIN Jeu ON est_Categorie.id_Jeu = Jeu.id_Jeu INNER JOIN Article on Jeu.id_Jeu=Article.id_Jeu WHERE Article.id_Article=$num";
        $sql_categorie_res = readDB($my_sqli, $sql_categorie);

        $sql_support = "SELECT id_Support FROM est_Support INNER JOIN Jeu ON est_Support.id_Jeu = Jeu.id_Jeu INNER JOIN Article on Jeu.id_Jeu=Article.id_Jeu WHERE Article.id_Article=$num";
        $sql_support_res = readDB($my_sqli, $sql_support);

        return Array ($sql_article_res, $sql_login_crea_res, $sql_login_modif_res, $sql_jeu_res, $sql_images_article_res, $sql_categorie_res, $sql_support_res);
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

function avis($mysqli,$id_Utilisateur,$id_Jeu){
    $tableau = readDB($mysqli,"SELECT avis.titre_Avis, avis.contenu_Avis, avis.dateCreation_Avis, avis.note_Avis, utilisateur.login_Utilisateur FROM avis JOIN utilisateur ON avis.id_Utilisateur=utilisateur.id_Utilisateur WHERE avis.id_Jeu=$id_Jeu AND avis.id_Utilisateur=$id_Utilisateur");
    return $tableau;
}

?>