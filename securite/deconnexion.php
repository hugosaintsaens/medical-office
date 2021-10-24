<?php
    require 'identification.php';

    session_destroy();

    require '../bdd/fermeture.php';

    echo '<script type="text/javascript">';
    echo 'window.location.href = "../index.php";';
    echo '</script>';
?>