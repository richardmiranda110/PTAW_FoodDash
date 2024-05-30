<?php
require_once __DIR__ . '/includes/session.php';

include __DIR__ . "/../database/empresa_estabelecimento.php";
include __DIR__ . "/../database/credentials.php";
include __DIR__ . "/../database/db_connection.php";

$id_empresa = $_SESSION['id_empresa'] ?? $_GET['id_empresa'] ?? null;

if (!$id_empresa) {
    echo "No company ID provided!";
    exit();
}

$estabelecimentos = ObterEstabelecimentosPorEmpresa($pdo, $id_empresa);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Estabelecimentos da Empresa</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="/../assets/styles/dashboard_beatriz.css">
    <link rel="stylesheet" href="/../assets/styles/sitecss.css">
    <link rel="stylesheet" href="/../assets/styles/dashboard.css">
    <link rel="stylesheet" href="/../assets/styles/responsive_styles.css">

    <style>
        /* Define a classe .container-75 com uma largura de 75% */
        .container {
            width: 75%;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        /* Define a classe .max-img-size com a largura e altura máximas desejadas */
        .max-img-size {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<>
    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
        <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
    </div>

    <!--Zona de Conteudo -->
    <br><br<<br>
    <div class="container direita">
        <h1>Estabelecimentos da Empresa</h1>
        <div class="card mb-3">
            <?php if (!empty($estabelecimentos)): ?>
                <ul class="list-group">
                    <?php foreach ($estabelecimentos as $estabelecimento): ?>
                        <img class="card-img-top max-img-size" src="<?php echo htmlentities($estabelecimento['imagem']); ?>"
                            alt=" <?php echo htmlentities($estabelecimento['nome']); ?>">
                        <br>
                        <h5 class="esquerdo"><?php echo htmlentities($estabelecimento['nome']); ?></h5>
                        <button id="btn_apagar" class="btn btn-danger direito" style="width: auto;" type="button"
                            value="Editar">Apagar</button>
                        <br>
                        <hr>
                        <li class="list-group-item">
                            <strong>Localização:</strong> <?php echo htmlentities($estabelecimento['localizacao']); ?><br>
                            <strong>Telemóvel:</strong> <?php echo htmlentities($estabelecimento['telemovel']); ?><br>
                            <strong>Taxa de Entrega:</strong> <?php echo htmlentities($estabelecimento['taxa_entrega']); ?><br>
                            <strong>Tempo Médio de Entrega:</strong>
                            <?php echo htmlentities($estabelecimento['tempo_medio_entrega']); ?><br>
                        </li>

                        
                    <br>
                    <br>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum estabelecimento encontrado para esta empresa.</p>
            <?php endif; ?>
        </div>
    </div>

    <!--Fim do conteúdo de página-->

    <!-- Footer-->
    <?php include __DIR__ . "/includes/footer_business.php"; ?>
    </body>

</html>