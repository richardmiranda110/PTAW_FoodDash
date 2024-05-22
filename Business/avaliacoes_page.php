<?php
session_start();

// Verificar se o utilizador está logado
//if (!isset($_SESSION['username'])) {
//    header("Location: login.php");
//    exit();
//}

// Exibir nome de utilizador
//echo "Welcome, " . $_SESSION['username'];
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash Business</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../business/styles/adicionar.css">
    <link rel="stylesheet" href="../../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
    <link rel="stylesheet" href="./assets/styles/pedido_page.css">
    <script src="../../assets/js/dable.js"></script>
</head>

<body>

    <?php
    require_once "./../database/db_connection.php";
    ?>

    <!--Zona do Header -->

    <div class="container mt-5">
        <div class="card p-4">
            <h1>Avaliações</h1>
            <div class="col-12 col-md-6 col-lg-4 p-4">
                <div class="card shadow border-1">
                    <div class="card-body text-center">
                        <h4 class="card-title fw-bold mb-3">Avaliação Média dos Clientes</h4>
                        <p class="display-5 mb-3 text-secondary fw-bold">
                        <?php 
                        
                        try {
                            $q = "SELECT ROUND(AVG(classificacao), 1) as media FROM Avaliacoes";
                            $statement = $pdo->prepare($q);
                            $statement->execute();
                            if ($statement) {
                                $result = $statement->fetch(PDO::FETCH_ASSOC);
                                echo htmlspecialchars($result["media"]);
                            } else {
                                echo "Erro ao executar a consulta.";
                            }
                        } catch (Exception $e) {
                            echo "Erro na conexão à BD: " . $e->getMessage();
                        };
                        ?>
                         ★</p>
                    </div>
                </div>
            </div>
            <div>
                <h3>Críticas</h3>
                <div class="scrollable-container" style="height: 40vh; overflow-y: auto;">
                    <ul class="list-group list-group-flush">

                        <?php
                        try {
                            $q = "SELECT classificacao, data, descricao, nome FROM Avaliacoes 
                            INNER JOIN Clientes ON Clientes.id_cliente = Avaliacoes.id_cliente ORDER BY data DESC;";
                            $statement = $pdo->prepare($q);
                            $statement->execute();
                            if ($statement) {
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    echo '
                                    <li class="list-group-item">
                                        <h6>' . htmlspecialchars($row["nome"]) . '</h6>
                                        <p class="mb-3 fw-bold">' . htmlspecialchars($row["classificacao"]) . '★ &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-secondary fw-medium">' . htmlspecialchars($row["data"]) . '</span></p>
                                        <p>' . htmlspecialchars($row["descricao"]) . '</p>
                                    </li>
                                    ';
                                }
                            } else {
                                echo "Erro ao executar a consulta.";
                            }
                        } catch (Exception $e) {
                            echo "Erro na conexão à BD: " . $e->getMessage();
                        };
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <br><br><br><br>

    <!--Zona do Footer -->
    <?php include __DIR__ . "../../includes/footer_2.php"; ?>

    <script src="./assets/js/adicionar_pedido.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</body>

</html>