<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $hostname = "estga-dev.ua.pt";
    $username = "ptaw-2024-gr2";
    $password = 'Hrw4zTS$[i\D_$vI';
    $database = "ptaw-2024-gr2";

    try {
        $pdo = new PDO("pgsql:host=$hostname; port=5432; dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<script>alert('Conectado com sucesso!')</script>";
    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
    }
    ?>
</body>

</html>