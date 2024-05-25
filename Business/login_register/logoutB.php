<?php
    session_start();
    session_destroy();
    // Alterar depois
    header('location: login_business.php');