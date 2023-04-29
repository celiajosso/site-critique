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
session_start()
?>

<!DOCTYPE html lang="fr">

    <head>
        <title>Gamecrit - Acceuil</title>
        <meta name="author" content="NORTON Thomas, JOSSO Célia">
        <meta name="author" content="ESIR, CUPGE">
        
        <link rel="icon" href="Images/icone.png">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/nav.css">
        <link rel="stylesheet" href="styles/footer.css">
        <link rel="stylesheet" href="styles/index.css">
        <link rel="stylesheet" href="styles/modifie_ajout.css">
        <link rel="stylesheet" href="styles/form.css">
    </head>

    <?php include("./static/header.php"); ?>
    <?php include("./static/nav.php"); ?>
    <div class="onglet_titre"><div class="center"><p class="texte_titre">Modifier un avis :</p></div></div>
    <form action="php/change_review.php?numero=<?php echo $_GET['numero']; ?>&id_connected=<?php echo $_GET['id_connected']; ?>" method="POST" name="nomForm2" class="onglet_form">
    <div class="center"><label for="note" class="texte">Note sur 10 :</label>    
		<select id="note" name="note">
                <?php 
                foreach(range(0,10) as $numero){
                    if ($numero==get_avis($my_sqli,$_GET['id_connected'],$_GET['numero'])[0]['note_Avis']){
                        echo "<option selected>$numero</option>";

                    }
                    else{
                        echo "<option>$numero</option>";
                    }
                }
                ?>
            </select></div>
            <label for="avis_titre" class="center texte">Titre avis :</label>
            <div class="center"><textarea name="avis_titre" rows="1" cols="30"><?php $titre=get_avis($my_sqli,$_GET['id_connected'],$_GET['numero'])[0]['titre_Avis'];
                                                                echo $titre;
                                                            ?></textarea></div>
            <label for="avis_texte" class="center texte">Avis :</label>
            <div class="center"><textarea name="avis_texte" rows="10" cols="30"><?php $texte=get_avis($my_sqli,$_GET['id_connected'],$_GET['numero'])[0]['contenu_Avis'];
                                                                echo $texte;
                                                            ?></textarea></div>
            <div class="button_center"><input type="submit" class="text" value="Modifier" id="btn_submit"/></div>
            
	</form>
    <br><br><br><br>
    
    <?php include("./static/footer.php"); ?>

</html>