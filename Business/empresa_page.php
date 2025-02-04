<?php
require_once './includes/session.php';

include  "../database/empresa_estabelecimento.php";
include  "../database/credentials.php";
include  "../database/db_connection.php";

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ./home_page.php");
    exit();
}

// cria o o atributo $Validacao com o valor true, pois não existem falhas
$Validacao = true;
$empresaModificado = null;
$empresa = ObterEmpresaLocal();
// Recebendo dados da BD de um determinado utilizador
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Obter os dados da empresa
    $empresa = ObterEmpresaLocal();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Empresa</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/sitecss.css">
    <link rel="icon" type="image/x-icon" href="../assets/stock_imgs/t_fd_logo_tab_business_icon.png">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link rel="stylesheet" href="../assets/styles/responsive_styles.css">
</head>
<body style="min-height:84vh">
<!--Zona do Header -->
<div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include  "./includes/header_business_logged.php"; ?>
    <?php include  "./includes/sidebar_business.php"; ?>
</div>

<!--Zona de Conteudo -->
<div style="margin-top: 5vh;">

    <!-- Empresa -->
    <form id="empresa" class="w-75 form_editar" style="margin:auto;min-height: 59.8vh!important;" method="POST" enctype="multipart/form-data">
        <p class="mt-3 h3 pt-5 fw-bold">Informações</p>

        <div class="align-items-md-stretch">
        <?php

// Enviando dados para a BD, ao editar dados de um determinado «empresa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isImageAttached = $_FILES['imagem']['name'] != '';
        
    if($isImageAttached == true)
    require_once '../uploadImagem.php';

    // Atribuir os dados do formulário à variável $empresa
    // e, ao mesmo tempo, retirar carateres perigosos
    $empresaModificado = array(
        'nome' => htmlentities(trim($_POST['nome'])),
        'morada' => htmlentities(trim($_POST['morada'])),
        'telemovel' => htmlentities(trim($_POST['telemovel'])),
        'email' => htmlentities(trim($_POST['email'])),
        'tipo' => htmlentities(trim($_POST['tipo'])),
        'logotipo' => htmlspecialchars( $isImageAttached == 1 ? $caminhoArquivo : $empresa['logotipo']) 
    );

    // Se não ocorreram erros de validação, e se a empresa e o emprestimo tiver null
    if ($Validacao == true && ($empresaModificado !== null)) {
        // Editar a empresa na base de dados
        if (EditarEmpresa($empresaModificado)) { // ALTERAR ID
            $empresa = ObterEmpresaLocal(); // ALTERAR ID
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
    } 
}

?>
            <div>
                <div class="card pb-0 mb-4">
                    <div class="p-3 d-flex justify-content-between">
                        <h5 class="esquerdo">Informações</h5>
                        <button id="btn_editar" class="btn btn-warning direito" style="width: auto;" type="button"
                            value="Editar">Editar</button>
                    </div>
                    <div class="card-body pt-0 mb-0 pb-0">
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
                                <span id="erroNome" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>

                            <!-- Morada -->
                            <span>Morada</span>
                            <div class="input-group flex-nowrap">
                                <input name="morada" readonly type="text" class="form-control" placeholder="Morada"
                                    aria-label="Morada" aria-describedby="addon-wrapping" value="<?php if (!empty($empresa['morada']))
                                        echo $empresa['morada']; ?>">
                                <span id="erroMorada" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>


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

                            <!-- Email -->
                            <div class="row">
                                <div class="col-md-4">
                                    <span>Email<span style='color:#ff0000'> *</span></span>
                                    <div class="input-group flex-nowrap">
                                        <input name="email" readonly type="text" class="form-control"
                                            placeholder="Email" aria-label="Email" aria-describedby="addon-wrapping"
                                            value="<?php if (!empty($empresa['email']))
                                                echo $empresa['email']; ?>">
                                        <span id="erroEmail" class="help-inline small" style="color:#ff0000"></span>
                                    </div>
                                </div>

                                <!-- Tipo -->
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <span>Tipo<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                            <input name="tipo" readonly type="text" class="form-control"
                                                placeholder="Tipo" aria-label="Tipo" aria-describedby="addon-wrapping"
                                                value="<?php if (!empty($empresa['tipo']))
                                                    echo $empresa['tipo']; ?>">
                                            <span id="erroTipo" class="help-inline small" style="color:#ff0000"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- ADICIONAR COMO ESCOLHER Logotipo-->
                                <div class="my-3">
                                    <label for="imagem" class="form-label">Imagem:
                                        <span style='color:#ff0000'> *</span>
                                    </label>
                                    <br>
                                    <input type="file" class="btn btn-light form-control w-50" name="imagem" id="imagem" file=""
                                        accept="image/*">
                                    <?php
                                    if (isset($_SESSION['erroImagem'])) {
                                        echo "<div class='alert alert-danger' role='alert'>
                                                    " . $_SESSION['erroImagem'] . "
                                                </div>";
                                    unset($_SESSION['erroImagem']);
                                    }
                                    ?>
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
    include "./includes/footer_business_2.php";
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
    var btnEditar = document.getElementById("btn_editar");
    var form = document.querySelector(".form_editar");
    // input
    var nomeInput = document.querySelector("[name='nome']");
    var moradaInput = document.querySelector("[name='morada']");
    var telemovelInput = document.querySelector("[name='telemovel']");
    var emailInput = document.querySelector("[name='email']");
    var tipoInput = document.querySelector("[name='tipo']");
    // erro
    var erroNome = document.getElementById("erroNome");
    var erroEmail = document.getElementById("erroEmail");
    var erroMorada = document.getElementById("erroMorada");
    var erroTelemovel = document.getElementById("erroTelemovel");
    var erroTipo = document.getElementById("erroTipo");


    // Função para validar o formulário da empresa
    function validarFormulario() {
        validacao = true; // resetar a validação
        erroNome.textContent = ""; // limpar mensagem de erro
        erroMorada.textContent = ""; // limpar mensagem de erro
        erroTelemovel.textContent = ""; // limpar mensagem de erro
        erroEmail.textContent = ""; // limpar mensagem de erro
        erroTipo.textContent = ""; // limpar mensagem de erro


        // Verificar se o campo de nome está vazio
        if (nomeInput.value.trim() === "") {
            nomeNome.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de e-mail está vazio
        if (moradaInput.value.trim() === "") {
            erroMorada.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de Telemovel está vazio
        if (telemovelInput.value.trim() === "") {
            // Verificar se o campo de telemovel contém exatamente 9 números
            erroTelemovel.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsaz  
        }

        // Verificar se o campo de e-mail está vazio
        if (emailInput.value.trim() === "") {
            erroEmail.textContent = "Campo obrigatório";
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
                    erroNome.textContent = ""; // limpar mensagem de erro
                    erroMorada.textContent = ""; // limpar mensagem de erro
                    erroTelemovel.textContent = ""; // limpar mensagem de erro
                    erroEmail.textContent = ""; // limpar mensagem de erro
                    erroTipo.textContent = ""; // limpar mensagem de erro
                    btnEditar.innerHTML = "Editar";
                    btnEditar.setAttribute("type", "submit");
                    btnEditar.classList.remove("btn-success"); // tipo: submissão
                    btnEditar.classList.add("btn-warning");
                    inputs.forEach(function (input) {
                        input.setAttribute("readonly", "readonly");
                    });
                    form.method = 'POST';
                }
            }
        })
    });
</script>
</body>

</html>