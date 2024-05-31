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

<ul>
    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
        <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
    </div>

    <!--Zona de Conteudo -->
    <div class="direita">
        <h1 class="container">Estabelecimentos da Empresa</h1>
        <?php if (!empty($estabelecimentos)): ?>
            <?php foreach ($estabelecimentos as $estabelecimento): ?>
                <div class="container">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="img-fluid max-img-size"
                                    src="<?php echo htmlentities($estabelecimento['imagem']); ?>"
                                    class="img-fluid rounded-start" alt="<?php echo htmlentities($estabelecimento['nome']); ?>">
                            </div>
                            <div class="col-md-8">
                                <br>
                                <h5 class="esquerdo"><?php echo htmlentities($estabelecimento['nome']); ?></h5>
                                <button id="btn_editar" class="btn btn-warning direito" style="width: auto;" type="button"
                                    value="Editar">Editar</button>
                                <br>
                                <hr>
                                <dl class="list-group list-group-flush">
                                    <dd name="id" disabled><strong>Localização:</strong>
                                        <?php echo htmlentities($estabelecimento['id_estabelecimento']); ?><br>
                                    </dd>
                                    <dd name="localizacao"><strong>Localização:</strong>
                                        <?php echo htmlentities($estabelecimento['localizacao']); ?><br>
                                    </dd>
                                    <dd name="telemovel"><strong>Telemóvel:</strong>
                                        <?php echo htmlentities($estabelecimento['telemovel']); ?><br>
                                    </dd>
                                    <dd name="taxa"><strong>Taxa de Entrega:</strong>
                                        <?php echo htmlentities($estabelecimento['taxa_entrega']); ?><br>
                                    </dd>
                                    <dd name="tempo"><strong>Tempo Médio de Entrega:</strong>
                                        <?php echo htmlentities($estabelecimento['tempo_medio_entrega']); ?>
                                    </dd>
                                    <br>
                                </dl>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum estabelecimento encontrado para esta empresa.</p>
        <?php endif; ?>
    </div>

    <!--Fim do conteúdo de página-->

    <!-- Footer-->
    <?php include __DIR__ . "/includes/footer_business.php"; ?>
    </body>

    <script>

        // Obtém os elementos
        //Geral
        var validacao = true;
        var btnEditar = document.getElementById("btn_editar");
        var localizacaoInput = document.querySelector("[name='localizacao']");
        var telemovelInput = document.querySelector("[name='telemovel']");


        // Função para validar o formulário da estabelcimento
        function a() {

        }

        document.addEventListener("DOMContentLoaded", function () {
            // Adiciona evento de clique ao botão
            btnEditar.addEventListener("click", function () {
                // Altera para modo de edição
                if (btnEditar.innerHTML == "Editar") {
                    btnEditar.innerHTML = "Guardar";
                    btnEditar.setAttribute("type", "button"); // tipo: botão
                    btnEditar.classList.remove("btn-warning");
                    btnEditar.classList.add("btn-success");
                    inputs.forEach(function (input) {
                        input.removeAttribute("readonly");
                    });
                    form.method = 'GET';
                    form.removeAttribute("action");
                }
                // Altera para modo de leitura
                else {
                    // Validar o formulário ao clicar em "Guardar"
                    validarFormulario();

                    // caso não haja erros, o formulário é submetido
                    if (validacao == true) {
                        validacao = true; // resetar a validação
                        erroNome.textContent = ""; // limpar mensagem de erro
                        erroLocalizacao.textContent = ""; // limpar mensagem de erro
                        erroTelemovel.textContent = ""; // limpar mensagem de erro
                        erroTaxaEntrega.textContent = ""; // limpar mensagem de erro
                        erroTempoMedioEntrega.textContent = ""; // limpar mensagem de erro
                        btnEditar.innerHTML = "Editar";
                        btnEditar.setAttribute("type", "submit");
                        btnEditar.classList.remove("btn-success"); // tipo: submissão
                        btnEditar.classList.add("btn-warning");
                        inputs.forEach(function (input) {
                            input.setAttribute("readonly", "readonly");
                        });
                        form.method = 'POST';
                        form.setAttribute("action", "perfil.php");
                    }
                }
            })
        });
    </script>

</html>