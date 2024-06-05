<?php
require_once __DIR__ . '/includes/session.php';

include __DIR__ . "/../database/empresa_estabelecimento.php";
include __DIR__ . "/../database/credentials.php";
include __DIR__ . "/../database/db_connection.php";

$Validacao = True;
$estabelecimento = null;
$tipoArquivo = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atribuir os dados do formulário à variável $produto e, ao mesmo tempo, retirar carateres perigosos			
    $estabelecimento = array(
        'nome' => htmlspecialchars(trim($_POST['nome'])),
        'localizacao' => htmlspecialchars(trim($_POST['localizacao'])),
        'telemovel' => htmlspecialchars(trim($_POST['telemovel'])),
        'taxa_entrega' => htmlspecialchars(trim($_POST['taxa_entrega'])),
        'tempo_medio_entrega' => htmlspecialchars(trim($_POST['tempo_medio_entrega'])),
        'imagem' => $tipoArquivo
    );

    // Se não ocorreram erros de validação, inserir o produto
    if ($Validacao == true) {
        if (AdicionarEstabelecimento($pdo, $_SESSION['id_empresa'], $estabelecimento)) {
            // Se for adicionado corretamente há base de dados,
            // reencaminha para estabelecimento_page.php
            header("Location: estabelecimento_page.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Adicionar Estabelecimento</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link rel="stylesheet" href="../assets/styles/responsive_styles.css">
</head>

<!--Zona do Header -->
<div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
    <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
</div>

<!--Zona de Conteudo -->
<div style="margin-top: 10vh;">
    <!-- Formulárop do Estabelecimento -->
    <form id="estabelecimento" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-75 form_editar" style="margin:auto"
        method="POST">
        <p class="h4 pt-4">Informações</p>

        <div class="align-items-md-stretch">
            <div>
                <div class="card pb-2">
                    <div class="p-3 d-flex justify-content-between">
                        <p class="h5">Informações Pessoais</p>
                        <div>
                            <a href="estabelecimento_page.php" class="btn btn-light justify-content-end">Voltar</a>
                            <button id="btn_guardar" class="btn btn-success direito" style="width: auto;" type="submit"
                                value="Guardar">Guardar</button>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-1  ">
                        <!-- Informação da existência de campos obrigatórios -->
                        <div class="alert p-0" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                            <strong> Campos marcados com <span style='color:#ff0000'>*</span> são
                                obrigatórios</strong>
                        </div>
                        <!-- Nome -->
                        <span>Nome<span style='color:#ff0000'> *</span></span>
                        <div class="input-group flex-nowrap">
                            <input name="nome" type="text" class="form-control" placeholder="Nome" aria-label="Nome"
                                aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['nome']))
                                    echo $estabelecimento['nome']; ?>">
                            <?php if (!empty($ErroNome)) { ?>
                                <span class="help-block small" style="color:#ff0000"><?php echo $ErroNome; ?></span>
                            <?php } ?>
                        </div>
                        <br>

                        <!-- localizacao -->
                        <span>Localização<span style='color:#ff0000'> *</span></span>
                        <div class="input-group flex-nowrap">
                            <input name="localizacao" type="text" class="form-control mb-4" placeholder="Localização"
                                aria-label="Localização" aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['localizacao']))
                                    echo $estabelecimento['localizacao']; ?>">
                            <?php if (!empty($ErroLocalizacao)) { ?>
                                <span class="help-block small" style="color:#ff0000"><?php echo $ErroLocalizacao; ?></span>
                            <?php } ?>
                        </div>

                        <hr class="m-1"><br><br>

                        <!-- Telemóvel -->
                        <span>Nº de Telemóvel<span style='color:#ff0000'> *</span></span>
                        <div class="input-group flex-nowrap">
                            <input name="telemovel" type="text" class="form-control" placeholder="Telemóvel"
                                aria-label="Telemovel" aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['telemovel']))
                                    echo $estabelecimento['telemovel']; ?>">
                            <?php if (!empty($ErroTelemovel)) { ?>
                                <span class="help-block small" style="color:#ff0000"><?php echo $ErroTelemovel; ?></span>
                            <?php } ?>
                        </div>
                        <br>

                        <!-- taxa_entrega -->
                        <span>Taxa de Entrega<span style='color:#ff0000'> *</span></span>
                        <div class="input-group flex-nowrap">
                            <input name="taxa_entrega" type="text" class="form-control" placeholder="Taxa de Entrega"
                                aria-label="Taxa de Entrega" aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['taxa_entrega']))
                                    echo $estabelecimento['taxa_entrega']; ?>">
                            <br><br>
                            <?php if (!empty($ErroTaxa)) { ?>
                                <span class="help-block small" style="color:#ff0000">
                                    <?php echo $ErroTaxa; ?></span>
                            <?php } ?>
                        </div>

                        <br>

                        <!-- tempo_medio_entrega -->
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="input-group flex-nowrap">
                                    <label for="appt-time">Escolha o tempo médio de entrega: <span
                                            style='color:#ff0000'> *</span>
                                        &emsp; &emsp;</label>
                                    <input name="tempo_medio_entrega" id="appt-time" type="time" name="appt-time" value="<?php if (!empty($estabelecimento['tempo_medio_entrega']))
                                        echo $estabelecimento['tempo_medio_entrega']; ?>">
                                    <?php if (!empty($ErroTempo)) { ?>
                                        <span class="help-block small"
                                            style="color:#ff0000"><?php echo $ErroTempo; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                                        <br><br>
                        <!-- Imagem -->
                        <div>
                            <label for="inputImagem">Escolha uma imagem:</label>
                            <input name="imagem" type="file" id="inputImagem" name="inputImagem"
                                accept="image/png, image/jpeg, image/jpg, image/svg, image/gif">
                            <br>
                            <img id="preview" src="#" alt="Image preview"
                                style="display:none; max-width:200px; max-height:200px;">
                            <?php if (!empty($ErroImagem)) { ?>
                                <span class="help-block small" style="color:#ff0000"><?php echo $ErroImagem; ?></span>
                            <?php } ?>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br><br>
</div>
<!--Fim do conteúdo de página-->
<?php
include __DIR__ . "/includes/footer_business.php";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script>

    document.getElementById('inputImagem').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('preview');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
    // Obtém os elementos
    //Geral
    var inputs = document.querySelectorAll(".form-control");
    var validacao = true;
    var btnEditar = document.getElementById("btn_editar");
    var form = document.querySelector(".form_editar");

    // dados inseridos no input
    var nomeInput = document.querySelector("[name='nome']");
    var localizacaoInput = document.querySelector("[name='localizacao']");
    var telemovelInput = document.querySelector("[name='telemovel']");
    var taxaEntregaInput = document.querySelector("[name='taxa_entrega']");
    var tempoMedioEntregaInput = document.querySelector("[name='tempo_medio_entrega']");
    var imagemInput = document.querySelector("[name='imagem']");

    // variáveis se ocurrerem erro
    var erroNome = document.getElementById("erroNome");
    var erroLocalizacao = document.getElementById("erroLocalizacao");
    var erroTelemovel = document.getElementById("erroTelemovel");
    var erroTaxaEntrega = document.getElementById("erroTaxaEntrega");
    var erroEmail = document.getElementById("erroEmail");
    var erroTempoMedioEntrega = document.getElementById("erroTempoMedioEntrega");
    var erroImagem = document.getElementById("erroImagem");

    // Função para validar o formulário da estabelecimento
    function validarFormulario() {
        validacao = true; // resetar a validação
        erroNome.textContent = ""; // limpar mensagem de erro
        erroLocalizacao.textContent = ""; // limpar mensagem de erro
        erroTelemovel.textContent = ""; // limpar mensagem de erro
        erroTaxaEntrega.textContent = ""; // limpar mensagem de erro
        erroTempoMedioEntrega.textContent = ""; // limpar mensagem de erro


        // Verificar se o campo de nome está vazio
        if (nomeInput.value.trim() === "") {
            erroNome.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de e-mail está vazio
        if (localizacaoInput.value.trim() === "") {
            erroLocalizacao.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
        }

        // Verificar se o campo de Telemovel está vazio
        if (telemovelInput.value.trim() === "") {
            erroTelemovel.textContent = "Campo obrigatório";
            validacao = false; // marcar validação como falsa
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

        // Verificar se algum arquivo foi selecionado para a imagem
        const file = imagemInput.files[0];
        if (file) {
            const formatosPermitidos = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg', 'image/gif'];
            if (!formatosPermitidos.includes(file.type)) {
                erroImagem.textContent = "Formato de imagem inválido. Por favor, escolha um formato válido (PNG, JPEG, JPG, SVG, GIF).";
                validacao = false; // marcar validação como falsa
            }
        }
    }

</script>
</body>

</html>