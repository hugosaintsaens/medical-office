<?php
    try { 
        $link = new PDO('mysql:host=localhost;dbname=cabinet medical', 'root', '');
        $GLOBALS['bdd'] = $link;
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
?>