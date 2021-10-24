<?php
    require '../securite/identification.php';
    require '../bdd/ouverture.php';
    
    $reqSupp = $GLOBALS['bdd']->prepare("DELETE FROM prendrerdv
                                            WHERE DateRDV = ?
                                            AND HeureRDV = ?
                                            AND DureeRDV = ?
                                            AND ID_Medecin = ?");
    $reqSupp->execute(array($_GET['date'],$_GET['heure'],$_GET['duree'],$_GET['Mid']));

    $succes = "Suppresion effectuée avec succès !";
    echo '<font color = "green">'.$succes."</font>";

    require '../bdd/fermeture.php';

    sleep(2);

    echo '<script type="text/javascript">';
    echo 'window.location.href = "../consultations.php";';
    echo '</script>';
?>