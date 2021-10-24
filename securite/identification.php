<?php 
    session_start();

    if(!(isset($_SESSION['id'])) && !(isset($_SESSION['mdp']))) {
        header("Location: index.php");
    } 
?>