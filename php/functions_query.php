<?php

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