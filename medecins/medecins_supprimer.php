<?php 
    require '../securite/identification.php';
    require '../bdd/ouverture.php';
    
    $reqSupp = $GLOBALS['bdd']->prepare("DELETE FROM medecin WHERE ID_Medecin = ?");
    $reqSupp->execute(array($_GET['id']));

    $succes = "Suppresion effectuée avec succès !";
    echo '<font color = "green">'.$succes."</font>";

    require '../bdd/fermeture.php';

    sleep(2);

    echo '<script type="text/javascript">';
    echo 'window.location.href = "../medecins.php";';
    echo '</script>';
?>