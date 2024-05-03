<?php
require_once './credentials.php';

// Conexão ao banco de dados usando PDO
try {
    $pdo = new PDO("pgsql:host=".DBHOST.
                    "; port=".DBPORT.
                    ";dbname=".DBNAME,
                    DBUSER, DBPASS);

    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}