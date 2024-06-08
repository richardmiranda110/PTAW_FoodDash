<?php
require_once  './includes/session.php';

include  "../database/empresa_estabelecimento.php";
include  "../database/credentials.php";
include  "../database/db_connection.php";

$estabelecimento = isset($_GET['id']) ? ObterEstabelecimento($_GET['id']) : null;
$updateMode = ($estabelecimento != null);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome']) && isset($_POST['localizacao']) && isset($_POST['telemovel']) && isset($_POST['taxa_entrega']) && isset($_POST['tempo_medio_entrega'])) {
        
        if($_FILES['imagem']['name'] != '')
            require_once '../uploadImagem.php';
        
        $nome = htmlspecialchars(trim($_POST['nome']));
        $localizacao = htmlspecialchars(trim($_POST['localizacao']));
        $telemovel = htmlspecialchars(trim($_POST['telemovel']));
        $taxa_entrega = htmlspecialchars(trim($_POST['taxa_entrega']));
        $tempo_medio_entrega = htmlspecialchars(trim($_POST['tempo_medio_entrega']));
        $imagem = isset($caminhoArquivo) ? $caminhoArquivo : 'fd_logo_blackWhite.png'; // $caminhoArquivo contém o caminho completo do arquivo de imagem no servidor

        $idExistente = VerificarEstabExistente($nome, $localizacao);

        if($idExistente) {
            header("Location: editar_estabelecimento.php?id=" . $idExistente);
            exit();
        }

        $estabelecimento = array(
            'nome' => $nome,
            'localizacao' => $localizacao,
            'telemovel' => $telemovel,
            'taxa_entrega' => $taxa_entrega,
            'tempo_medio_entrega' => $tempo_medio_entrega,
            'imagem' => $imagem
        );

        if(AdicionarEstabelecimento($estabelecimento)) {
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
    <?php include "./includes/header_business_logged.php"; ?>
    <?php include "./includes/sidebar_business.php"; ?>
</div>

<!--Zona de Conteudo -->
<div style="margin-top: 10vh;">
    <!-- Formulárop do Estabelecimento -->
    <form id="estabelecimento" action="" class="w-75 form_editar" style="margin:auto"
        method="POST" enctype="multipart/form-data">
        <p class="h4 pt-3">Informações</p>

        <div class="align-items-md-stretch">
            <div>
                <div class="card pb-2 mb-5 mt-2">
                    <div class="p-3 d-flex justify-content-between">
                        <p class="h5">Informações Pessoais</p>
                        <div>
                            <a href="estabelecimento_page.php" class="btn btn-light justify-content-end">Voltar</a>
                            <button id="btn_guardar" class="btn btn-success direito" style="width: auto;" type="submit"
                                value="Guardar">Adicionar</button>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-0 ">
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
                                    echo $estabelecimento['nome']; ?>" required>
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
                                    echo $estabelecimento['localizacao']; ?>" required>
                            <?php if (!empty($ErroLocalizacao)) { ?>
                                <span class="help-block small" style="color:#ff0000"><?php echo $ErroLocalizacao; ?></span>
                            <?php } ?>
                        </div>

                        <div class="row">
                            <!-- Telemóvel -->
                            <div class="col-md-4">
                                <span>Nº de Telemóvel<span style='color:#ff0000'> *</span></span>
                                <div class="input-group flex-nowrap">
                                    <input name="telemovel" type="text" class="form-control" placeholder="Telemóvel"
                                        aria-label="Telemovel" aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['telemovel']))
                                            echo $estabelecimento['telemovel']; ?>" required>
                                    <?php if (!empty($ErroTelemovel)) { ?>
                                        <span class="help-block small"
                                            style="color:#ff0000"><?php echo $ErroTelemovel; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <br>

                            <!-- taxa_entrega -->
                            <div class="col-md-4">
                                <span>Taxa de Entrega<span style='color:#ff0000'> *</span></span>
                                <div class="input-group flex-nowrap">
                                    <input name="taxa_entrega" type="text" class="form-control"
                                        placeholder="Taxa de Entrega" aria-label="Taxa de Entrega"
                                        aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['taxa_entrega']))
                                            echo $estabelecimento['taxa_entrega']; ?>" required>
                                    <br><br>
                                    <?php if (!empty($ErroTaxa)) { ?>
                                        <span class="help-block small" style="color:#ff0000">
                                            <?php echo $ErroTaxa; ?></span>
                                    <?php } ?>
                                </div>
                            </div>


                            <!-- tempo_medio_entrega -->
                            <div class="">
                                <div class="input-group flex-nowrap my-3">
                                    <label for="appt-time">Escolha o tempo médio de entrega: <span
                                            style='color:#ff0000'>
                                            *</span>
                                        &emsp; &emsp;</label>
                                    <input name="tempo_medio_entrega" id="appt-time" type="time" name="appt-time" value="<?php if (!empty($estabelecimento['tempo_medio_entrega']))
                                        echo $estabelecimento['tempo_medio_entrega']; ?>" required>
                                    <?php if (!empty($ErroTempo)) { ?>
                                        <span class="help-block small"
                                            style="color:#ff0000"><?php echo $ErroTempo; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Imagem -->
                    <div class="mx-3">
                        <label for="imagem" class="form-label">Enviar Imagem:
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
    }

</script>
</body>

</html>