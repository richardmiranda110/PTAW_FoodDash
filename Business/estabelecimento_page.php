<?php
require_once './includes/session.php';

include  "../database/empresa_estabelecimento.php";
include  "./database/credentials.php";
include  "./database/db_connection.php";

// if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
//     $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
//     header("Location: ./Business/login_register/login_business.php");
//     exit();
// }

$id_estabelecimento = $_POST['id_estabelecimento'];

// $estabelecimentos = ObterEstabelecimentosEmpresaLocal();

// Se não ocorreram erros de validação, atualizar o utilizador
if ($id_estabelecimento !== null) {
    // Editar o usuário no banco de dados
    if (ApagarEstabelecimento($id_estabelecimento)) {
        echo "<script>alert('Estabelecimento apagado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao apagar o estabelecimento.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Estabelecimentos da Empresa</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/dashboard_beatriz.css">
    <link rel="stylesheet" href="../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link rel="stylesheet" href="../assets/styles/responsive_styles.css">

    <style>
        /* Define a classe .container-75 com uma largura de 75% */
        .container {
            width: 75%;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
        }

        /* Define a classe .max-img-size com a largura e altura máximas desejadas */
        .max-img-size {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>


<!--Zona do Header -->
<div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include "./includes/header_business_logged.php"; ?>
    <?php include "./includes/sidebar_business.php"; ?>
</div>

<!--Zona de Conteudo -->
<br><br>
<div class="direita" style="margin-top: 10vh;">
    <h2 style="text-align: left;">Estabelecimentos da Empresa</h2>
    <div class="d-grid gap-2">
        <a href="adicionar_estabelecimento.php" class="btn btn-light">Adicionar Estabelecimento</a>
    </div>
    <br><br>
    <div class="container" style="justify-content: center;">
        <?php if (!empty($estabelecimentos)) : ?>
            <?php foreach ($estabelecimentos as $estabelecimento) : ?>
                <div class="d-flex" style="padding: 0vh 1vw;">
                    <div class="card mb-3 col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="img-fluid max-img-size" src="<?php echo htmlspecialchars($estabelecimento['imagem']); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($estabelecimento['nome']); ?>">
                            </div>
                            <div class="col-md-8 justify-content-between">
                                <br>
                                <h5 class="esquerdo"><?php echo htmlspecialchars($estabelecimento['nome']); ?></h5>
                                <div>
                                    <form id="editar_form" method="POST" action="editar_estabelecimento.php?id=<?php echo htmlspecialchars($estabelecimento['id_estabelecimento']); ?>">
                                        <input type="hidden" name="id_estabelecimento" value="<?php echo htmlspecialchars($estabelecimento['id_estabelecimento']); ?>">
                                        <button id="editar_btn" class="btn btn-warning direito" style="width: auto;">
                                            Editar
                                        </button>
                                    </form>
                                    <form id="apagar_form_<?php echo $estabelecimento['id_estabelecimento']; ?>" method="POST" action="">
                                        <input type="hidden" name="id_estabelecimento" value="<?php echo htmlspecialchars($estabelecimento['id_estabelecimento']); ?>">
                                        <input type="hidden" name="nome_estabelecimento" value="<?php echo htmlspecialchars($estabelecimento['nome']); ?>">
                                        <button type="button" class="btn btn-danger direito apagar_btn" data-id="<?php echo htmlspecialchars($estabelecimento['id_estabelecimento']); ?>" data-nome="<?php echo htmlspecialchars($estabelecimento['nome']); ?>" style="width: auto;">
                                            Apagar
                                        </button>
                                    </form>
                                </div>
                                <hr>
                                <dl class="list-group list-group-flush">
                                    <dd name="id" hidden><strong>Id do estabelcimento:</strong>
                                        <?php echo htmlspecialchars($estabelecimento['id_estabelecimento']); ?><br>
                                    </dd>
                                    <dd name="localizacao"><strong>Localização:</strong>
                                        <?php echo htmlspecialchars($estabelecimento['localizacao']); ?><br>
                                    </dd>
                                    <dd name="telemovel"><strong>Telemóvel:</strong>
                                        <?php echo htmlspecialchars($estabelecimento['telemovel']); ?><br>
                                    </dd>
                                    <dd name="taxa"><strong>Taxa de Entrega:</strong>
                                        <?php echo htmlspecialchars($estabelecimento['taxa_entrega']); ?><br>
                                    </dd>
                                    <dd name="tempo"><strong>Tempo Médio de Entrega:</strong>
                                        <?php echo htmlspecialchars($estabelecimento['tempo_medio_entrega']); ?>
                                    </dd>
                                    <br>
                                </dl>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Nenhum estabelecimento encontrado para esta empresa.</p>
        <?php endif; ?>
    </div>
</div>

<!--Fim do conteúdo de página-->
<br><br><br><br><br><br>
<!-- Footer-->
<?php require_once "./includes/footer_2.php"; ?>
</body>
<script>
    document.querySelectorAll('.apagar_btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var estabelecimentoId = this.getAttribute('data-id');
            var nomeEstabelecimento = this.getAttribute('data-nome');
            var confirmar = confirm("Pretende mesmo eliminar o estabelecimento " + nomeEstabelecimento + "?");

            if (confirmar) {
                var confirmar2 = confirm("Após eliminar, não é possível rever!");
            }

            if (confirmar && confirmar2) {
                document.getElementById('apagar_form_' + estabelecimentoId).submit();
            }
        });
    });
</script>

</html>