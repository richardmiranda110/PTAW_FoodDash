<?php
    session_start();
    unset($_SESSION["authenticated"]); 

    // Alterar depois
    header('location: ../index.php');
?>