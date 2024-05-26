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
$empresaModificado = null;
$estabelecimentoModificado = null;

// Recebendo dados da BD de um determinado utilizador
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Obter os dados da empresa
    $empresa = ObterEmpresa($pdo, 1); // ALTERAR O ID

    // Obter dados do estabelecimento
    $estabelecimento = ObterEstabelecimento($pdo, 1); // ALTERAR O ID
}
// Enviando dados para a BD, ao editar dados de um determinado utilizador
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atribuir os dados do formulário à variável $empresa
    // e, ao mesmo tempo, retirar carateres perigosos
    $empresaModificado = array(
        'nome' => htmlentities(trim($_POST['nome'])),
        'morada' => htmlentities(trim($_POST['morada'])),
        'telemovel' => htmlentities(trim($_POST['telemovel'])),
        'email' => htmlentities(trim($_POST['email'])),
        'tipo' => htmlentities(trim($_POST['tipo'])),
        'logotipo' => htmlentities(trim($_POST['logotipo']))
    );

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

// Se não ocorreram erros de validação, e se a empresa e o emprestimo tiver null
if ($Validacao == true && ($empresaModificado !== null || $estabelecimentoModificado !== null)) {
    // Editar a empresa na base de dados
    if (EditarEmpresa($pdo, 1, $empresaModificado)) { // ALTERAR ID
        $empresa = ObterEmpresa($pdo, 1); // ALTERAR ID
        echo "<div class='alert alert-success' role='alert'>
            Dados alterados com sucesso
        </div>";
    }

    // Editar a empresa na base de dados
    else if (EditarEstabelecimento($pdo, 1, $estabelecimentoModificado)) { // ALTERAR ID
        $estabelecimento = ObterEstabelecimento($pdo, 1); // ALTERAR ID
        echo "<div class='alert alert-success' role='alert'>
            Dados alterados com sucesso
        </div>";

        // Ocorreu um erro na alteração de dados
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            Ocorreu um erro ao alterar dados! Por favor, tente novamente.
        </div>";
    }
    // Se ocurrem erros 
} else {
    $empresa = ObterEmpresa($pdo, 1);
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

    <!-- Empresa -->
    <form id="empresa" class="centro esquerdo form_editar_empresa" method="GET">
        <h3><strong>Informações</strong></h3>

        <div class="align-items-md-stretch">
            <div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="esquerdo">Informações</h5>
                        <button id="btn_editar_empresa" class="btn btn-warning direito" style="width: auto;"
                            type="button" value="Editar">Editar</button>
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
                                    aria-label="Nome" aria-describedby="addon-wrapping" value="<?php if (!empty($empresa['nome']))
                                        echo $empresa['nome']; ?>">
                            </div>
                            <br>

                            <!-- Morada -->
                            <span>Morada</span>
                            <div class="input-group flex-nowrap">
                                <input name="morada" readonly type="text" class="form-control" placeholder="Morada"
                                    aria-label="Morada" aria-describedby="addon-wrapping" value="<?php if (!empty($empresa['morada']))
                                        echo $empresa['morada']; ?>">
                            </div>
                            <br>

                            &emsp;
                            <hr>&emsp;

                            <!-- Telemóvel -->
                            <span>Nº de Telemóvel<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap">
                                <input name="telemovel" readonly type="text" class="form-control"
                                    placeholder="Telemóvel" aria-label="Telemovel" aria-describedby="addon-wrapping"
                                    value="<?php if (!empty($empresa['telemovel']))
                                        echo $empresa['telemovel']; ?>">
                                <span id="erroTelemovel" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12 esquerdo">
                                        <!-- Email -->
                                        <span>Email<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <input name="email" readonly type="text" class="form-control"
                                                placeholder="Email" aria-label="Email" aria-describedby="addon-wrapping"
                                                value="<?php if (!empty($empresa['email']))
                                                    echo $empresa['email']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <!-- Tipo -->
                                        <span>Tipo<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <input name="tipo" readonly type="text" class="form-control"
                                                placeholder="Tipo" aria-label="Tipo" aria-describedby="addon-wrapping"
                                                value="<?php if (!empty($empresa['tipo']))
                                                    echo $empresa['tipo']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <!-- Logotipo -->
                                        <span>Logotipo<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <!--<input name="logotipo" readonly type="text" class="form-control"
                                                placeholder="Logotipo" aria-label="Logotipo"
                                                aria-describedby="addon-wrapping" value="<?php // if (!empty($utilizador['logotipo']))
                                                //echo $utilizador['logotipo']; ?>">-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>

    <!-- Estabelecimento -->
    <form id="estabelcimento" class="centro esquerdo form_editar_estabelcimento" method="GET">
        <h3><strong>Informações</strong></h3>

        <div class="align-items-md-stretch">
            <div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="esquerdo">Informações</h5>
                        <button id="btn_editar_estabelecimento" class="btn btn-warning direito" style="width: auto;"
                            type="button" value="Editar">Editar</button>
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
                                    aria-label="Nome" aria-describedby="addon-wrapping" value="<?php if (!empty($empresa['nome']))
                                        echo $empresa['nome']; ?>">
                            </div>
                            <br>

                            <!-- localizacao -->
                            <span>Localização</span>
                            <div class="input-group flex-nowrap">
                                <input name="morada" readonly type="text" class="form-control" placeholder="Localização"
                                    aria-label="Localização" aria-describedby="addon-wrapping" value="<?php if (!empty($empresa['localizacao']))
                                        echo $empresa['localizacao']; ?>">
                            </div>
                            <br>

                            &emsp;
                            <hr>&emsp;

                            <!-- Telemóvel -->
                            <span>Nº de Telemóvel<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap">
                                <input name="telemovel" readonly type="text" class="form-control"
                                    placeholder="Telemóvel" aria-label="Telemovel" aria-describedby="addon-wrapping"
                                    value="<?php if (!empty($empresa['telemovel']))
                                        echo $empresa['telemovel']; ?>">
                                <span id="erroTelemovel" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12 esquerdo">
                                        <!-- taxa_entrega -->
                                        <span>Taxa de Entrega<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <input name="taxa_entrega" readonly type="text" class="form-control"
                                                placeholder="Taxa de Entrega" aria-label="Taxa de Entrega"
                                                aria-describedby="addon-wrapping" value="<?php if (!empty($empresa['taxa_entrega']))
                                                    echo $empresa['taxa_entrega']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <!-- tempo_medio_entrega -->
                                        <span>Tempo médio de entrega<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <input name="tempo_medio_entrega" readonly type="text" class="form-control"
                                                placeholder="Tempo médio de entrega" aria-label="Tempo médio de entrega"
                                                aria-describedby="addon-wrapping" value="<?php if (!empty($empresa['tempo_medio_entrega']))
                                                    echo $empresa['tempo_medio_entrega']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <!-- imagem -->
                                        <span>Imagem<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <!--<input name="cidade" readonly type="text" class="form-control"
                                                placeholder="Imagem" aria-label="Imagem"
                                                aria-describedby="addon-wrapping" value="<?php // if (!empty($utilizador['Imagem']))
                                                //echo $utilizador['Imagem']; ?>">-->
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

    //Empresa
    var btnEditarEmpresa = document.getElementById("btn_editar_empresa");
    var formEmpresa = document.querySelector(".form_editar");
    var emailInput = document.querySelector("[name='email']");
    var telefoneInput = document.querySelector("[name='telemovel']");
    var erroEmail = document.getElementById("erroEmail");
    var erroTelemovel = document.getElementById("erroTelemovel");

    //Estabelecimento
    var btnEditarEmpresa = document.getElementById("btn_editar_empresa");
    var formEmpresa = document.querySelector(".form_editar");
    var emailInput = document.querySelector("[name='email']");
    var telefoneInput = document.querySelector("[name='telemovel']");
    var erroEmail = document.getElementById("erroEmail");
    var erroTelemovel = document.getElementById("erroTelemovel");


    // Função para validar o formulário da empresa
    function validarFormularioEmpresa() {
        validacao = true; // resetar a validação
        erroEmail.textContent = ""; // limpar mensagem de erro
        erroTelemovel.textContent = ""; // limpar mensagem de erro

        // Verificar se o campo de e-mail está preenchido e não vazio
        if (emailInput.value.trim() === "") {
            erroEmail.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de telefone contém exatamente 9 números
        var telefone = telefoneInput.value.trim();
        if (!(/^\d+$/.test(telefone)) || telefone.length !== 9) {
            erroTelemovel.textContent = "O campo só pode conter números.";
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
                console.log(validacao);

                // caso não haja erros, o formulário é submetido
                if (validacao == true) {
                    validacao = true; // resetar a validação
                    erroEmail.textContent = ""; // limpar mensagem de erro
                    erroTelemovel.textContent = ""; // limpar mensagem de erro
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