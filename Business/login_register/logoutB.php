<?php
    session_start();
    unset($_SESSION["authenticatedB"]);

    // Alterar depois
    header('location: login_business.php');
?>