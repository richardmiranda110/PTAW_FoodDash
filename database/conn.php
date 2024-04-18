<?php
$host = 'localhost'; // ou IP do servidor
$dbname = 'ptaw-2024-gr2';
$user = 'ptaw-2024-gr2';
$password = 'Hrw4zTS$[i\D_$vI';

$dsn = "pgsql:host=$host;dbname=$dbname";

try {
	// Criar uma conexão PDO
	$pdo = new PDO($dsn, $user, $password);

	// Configurações adicionais, como o tratamento de erros
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	echo "Conexão com o banco de dados PostgreSQL estabelecida com sucesso!";
} catch (PDOException $e) {
	// Tratamento de erro
	die('Erro de conexão: ' . $e->getMessage());
}
?>