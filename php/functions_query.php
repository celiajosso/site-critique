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

function Is_loginUnique ($my_sqli, $username) {
    // Vérifie si le login entre par le nouvel utilisateur est unique

    $sql_inscription = "SELECT login_Utilisateur FROM Utilisateur WHERE login_Utilisateur = '$username'";
    $res_inscription = readDB($my_sqli, $sql_inscription);
    return (empty($res_inscription));
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
?>