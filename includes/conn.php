<?php

// Variáveis de conexão
$host = "localhost";
$username = "root";
$password = "";
$database = "app_db";

// Estabelecer a ligação
$conn = mysqli_connect($host, $username, $password, $database);

// Verificar se a ligação foi bem sucedida
if (!$conn) {
  die("Erro ao conectar à base de dados: " . mysqli_connect_error());
}

// Executar uma consulta
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Fechar a ligação
mysqli_close($conn);

?>
