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

<div id="footer-parent">
            <footer>
                <p id="footer-group">
                    <p id="author">Auteurs : NORTON Thomas, JOSSO Célia<br> Groupe B</p>
                    <p id="contact">Contact</p>
                </p>
                
                <p id="copyright">© 2023 CUPGE2</p>
            </footer>
        </div>
    </body>