<?php
require_once './../../../includes/session.php';

include __DIR__ . "/../database/empresa_estabelecimento.php";
include __DIR__ . "../database/credentials.php";
include __DIR__ . "../database/db_connection.php";

$pdo = new PDO(
    "pgsql:host=" . DBHOST .
    "; port=" . DBPORT .
    ";dbname=" . DBNAME,
    DBUSER,
    DBPASS
);

// cria o o atributo $Validacao com o valor true, pois não existem falhas
$Validacao = true;
$estabelecimentoModificado = null;

// Recebendo dados da BD de um determinado estabelecimento
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Obter dados do estabelecimento
    $estabelecimento = ObterEstabelecimento($pdo, 1); // ALTERAR O ID
}
// Enviando dados para a BD, ao editar dados de um determinado estabelecimento
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atribuir os dados do formulário à variável $estabelecimento
    // e, ao mesmo tempo, retirar carateres perigosos
    $estabelecimentoModificado = array(
        'nome' => htmlentities(trim($_POST['nome'])),
        'localizacao' => htmlentities(trim($_POST['localzacao'])),
        'telemovel' => htmlentities(trim($_POST['telemovel'])),
        'taxa_entrega' => htmlentities(trim($_POST['taxa_entrega'])),
        'tempo_medio_entrega' => htmlentities(trim($_POST['tempo_medio_entrega'])),
        'imagem' => htmlentities(trim($_POST['imagem']))
    );
}

// Se não ocorreram erros de validação, e o emprestimo tiver null
if ($Validacao == true && ($estabelecimentoModificado !== null)) {
    // Editar os dados do estabelecimento na base de dados
    if (EditarEstabelecimento($pdo, 1, $estabelecimentoModificado)) { // ALTERAR ID
        $estabelecimento = ObterEstabelecimento($pdo, 1); // ALTERAR ID
        echo "<div class='alert alert-success' role='alert'>
            Dados alterados com sucesso
        </div>";

        // Ocorreu um erro na alteração de dados, na base de dados
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            Ocorreu um erro ao alterar dados! Por favor, tente novamente.
        </div>";
    }
    // Se não existerem dadis a ser alterados 
} else {
    $estabelecimento = ObterEstabelecimento($pdo, 1);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Utilizador</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/sitecss.css">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <link rel="stylesheet" href="assets/styles/responsive_styles.css">
</head>

<!--Zona do Header -->
<div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include __DIR__ . "/includes/header_business.php"; ?>
    <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
</div>

<!--Zona de Conteudo -->
<div>
    <h3><strong>Loja</strong></h3>
    <!--Mapa-->
    <div>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18906.129712753736!2d6.722624160288201!3d60.12672284414915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x463e997b1b6fc09d%3A0x6ee05405ec78a692!2sJ%C4%99zyk%20trola!5e0!3m2!1spl!2spl!4v1672239918130!5m2!1spl!2spl"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Formulárop do Estabelecimento -->
    <form id="estabelcimento" class="centro esquerdo form_editar" method="GET">
        <h3><strong>Informações</strong></h3>

        <div class="align-items-md-stretch">
            <div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="esquerdo">Informações</h5>
                        <button id="btn_editar" class="btn btn-warning direito" style="width: auto;" type="button"
                            value="Editar">Editar</button>
                    </div>
                    <div class="card-body">
                        <!-- Informação da existência de campos obrigatórios -->
                        <div class="alert" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                            <strong> Campos marcados com <span style='color:#ff0000'>*</span> são
                                obrigatórios</strong>
                        </div>
                        <div class="esquerdo" style="padding:5px">
                            <!-- Nome -->
                            <span>Nome<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap">
                                <input name="nome" readonly type="text" class="form-control" placeholder="Nome"
                                    aria-label="Nome" aria-describedby="addon-wrapping" value="<?php if (!empty($estabelcimento['nome']))
                                        echo $estabelcimento['nome']; ?>">
                                <span id="erroNome" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>

                            <!-- localizacao -->
                            <span>Localização</span>
                            <div class="input-group flex-nowrap">
                                <input name="morada" readonly type="text" class="form-control" placeholder="Localização"
                                    aria-label="Localização" aria-describedby="addon-wrapping" value="<?php if (!empty($estabelcimento['localizacao']))
                                        echo $estabelcimento['localizacao']; ?>">
                                        <span id="erroLocalizacao" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>

                            &emsp;
                            <hr>&emsp;

                            <!-- Telemóvel -->
                            <span>Nº de Telemóvel<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap">
                                <input name="telemovel" readonly type="text" class="form-control"
                                    placeholder="Telemóvel" aria-label="Telemovel" aria-describedby="addon-wrapping"
                                    value="<?php if (!empty($estabelcimento['telemovel']))
                                        echo $estabelcimento['telemovel']; ?>">
                                <span id="erroTelemovel" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>
                            <!-- taxa_entrega -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12 esquerdo">
                                        <span>Taxa de Entrega<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <input name="taxa_entrega" readonly type="text" class="form-control"
                                                placeholder="Taxa de Entrega" aria-label="Taxa de Entrega"
                                                aria-describedby="addon-wrapping" value="<?php if (!empty($estabelcimento['taxa_entrega']))
                                                    echo $estabelcimento['taxa_entrega']; ?>">
                                                    <span id="erroTaxaEntrega" class="help-inline small" style="color:#ff0000"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- tempo_medio_entrega -->
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <span>Tempo médio de entrega<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <input name="tempo_medio_entrega" readonly type="text" class="form-control"
                                                placeholder="Tempo médio de entrega" aria-label="Tempo médio de entrega"
                                                aria-describedby="addon-wrapping" value="<?php if (!empty($estabelcimento['tempo_medio_entrega']))
                                                    echo $estabelcimento['tempo_medio_entrega']; ?>">
                                                    <span id="erroTempoMedioEntrega" class="help-inline small" style="color:#ff0000"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
<!--Fim do conteúdo de página-->
<?php
include __DIR__ . "/includes/footer_business.php";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script>

    // Obtém os elementos
    //Geral
    var inputs = document.querySelectorAll(".form-control");
    var validacao = true;
    var btnEditarEstabelcimento = document.getElementById("btn_editar_estabelcimento");
    var formEstabelcimento = document.querySelector(".form_editar");

    // dados inseridos no input
    var nomeInput = document.querySelector("[name='nome']");
    var localizacaoInput = document.querySelector("[name='localizacao']");
    var telemovelInput = document.querySelector("[name='telemovel']");
    var taxa_entregaInput = document.querySelector("[name='taxa_entrega']");
    var tempo_medio_entregaInput = document.querySelector("[name='tempo_medio_entrega']");

    // variáveis se ocurrerem erro
    var erroNome = document.getElementById("erroNome");
    var erroLocalizacao = document.getElementById("erroLocalizacao");
    var erroTelemovel = document.getElementById("erroTelemovel");
    var erroTaxaEntrega = document.getElementById("erroTaxaEntrega");
    var erroEmail = document.getElementById("erroEmail");
    var erroTempoMedioEntrega = document.getElementById("erroTempoMedioEntrega");


    // Função para validar o formulário da estabelcimento
    function validarFormulario() {
        validacao = true; // resetar a validação
        erroNome.textContent = ""; // limpar mensagem de erro
        erroLocalizacao.textContent = ""; // limpar mensagem de erro
        erroTelemovel.textContent = ""; // limpar mensagem de erro
        erroTaxaEntrega.textContent = ""; // limpar mensagem de erro
        erroTempoMedioEntrega.textContent = ""; // limpar mensagem de erro


        // Verificar se o campo de nome está vazio
        if (nomeInput.value.trim() === "") {
            nomeNome.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de e-mail está vazio
        if (localizacaoInput.value.trim() === "") {
            erroLocalizacao.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de Telemovel está vazio
        if (telemovelInput.value.trim() === "") {
            // Verificar se o campo de telemovel contém exatamente 9 números
            erroTelemovel.textContent = "Campo obrigatório";
        } else {
            // verficar se o campo contém só números
            var telemovel = telemovelInput.value.trim();
            if (!('/^\d+$/'.test(telemovel))) {
                erroTelemovel.textContent = "O campo só pode conter números.";
                validacao = false; // marcar validação como falsa
            } elseif
                (telemovel.length !== 9){
                erroTelemovel.textContent = "O campo deverá só conter números";
                validacao = false; // marcar validação como falsa
            }
        }

        // Verificar se o campo de e-mail está vazio
        if (taxaEntregaInput.value.trim() === "") {
            erroTaxaEntrega.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de e-mail está vazio
        if (tempoMedioEntregaInput.value.trim() === "") {
            erroTempoMedioEntrega.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }
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
</body>

</html>