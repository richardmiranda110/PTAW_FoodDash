<?php
require_once __DIR__ . '/includes/session.php';

include __DIR__ . "/../database/empresa_estabelecimento.php";
include __DIR__ . "/../database/credentials.php";
include __DIR__ . "/../database/db_connection.php";

$id_estabelecimento = null;
$Validacao = true;
$estabelecimento = null;
$estabelecimentoModificado = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_estabelecimento'])) {
    $id_estabelecimento = $_GET['id_estabelecimento'];
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_estabelecimento'])) {
    $id_estabelecimento = $_POST['id_estabelecimento'];
} else {
    $id_estabelecimento = null;
}

if ($id_estabelecimento !== null) {
    $estabelecimento = ObterEstabelecimento($pdo, $id_estabelecimento);
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

    if ((empty($_POST['nome']))) {
        $ErroNome = "Campo obrigatório!";
        $Validacao = False;
    }

    if ((empty($_POST['localizacao']))) {
        $ErroLocalizacao = "Campo obrigatório!";
        $Validacao = False;
    }

    if ((empty($_POST['telemovel']))) {
        $ErroTelemovel = "Campo obrigatório!";
        $Validacao = False;
    } elseif (!preg_match("/^\d{9,20}$/", $_POST['telemovel'])) {
        $ErroTelemovel = "Formato inválido! O número de telefone deve ter entre 9 e 20 dígitos.";
        $Validacao = False;
    }

    if ((empty($_POST['taxa_entrega']))) {
        $ErroTaxa = "Campo obrigatório!";
        $Validacao = False;
    } elseif (!is_numeric($_POST['taxa_entrega'])) {
        $ErroTaxa = "Formato inválido! A taxa de entrega deve ser um número.";
        $Validacao = False;
    } elseif (strpos($_POST['taxa_entrega'], '.') === false) {
        $ErroTaxa = "Formato inválido! A taxa de entrega deve ser um número decimal. (Ex.: 2.5)";
        $Validacao = False;
    }

    if ((empty($_POST['tempo_medio_entrega']))) {
        $ErroTempo = "Campo obrigatório!";
        $Validacao = False;
    }
}

echo "id: " . $id_estabelecimento . " estabelecimento: ";
echo var_dump($estabelecimento);

// Se não ocorreram erros de validação, e o estabelecimento tiver null
if ($Validacao == true) {
    // Sucesso
    if (EditarEstabelecimento($pdo, $id_estabelecimento, $estabelecimentoModificado)) {
        header("Location: estabelecimento_page.php");
    // Erro
    } else {
        exit();
    }
    // Se não existerem dadis a ser alterados 
} else {
    $estabelecimento = ObterEstabelecimento($pdo, $_SESSION['id_estabelecimento']);
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
    <link rel="stylesheet" href="/../assets/styles/sitecss.css">
    <link rel="stylesheet" href="/../assets/styles/dashboard.css">
    <link rel="stylesheet" href="/../assets/styles/responsive_styles.css">
</head>

<!--Zona do Header -->
<div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
    <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
</div>

<!--Zona de Conteudo -->
<div>
    <!--Mapa-->


    <!-- Formulárop do Estabelecimento -->
    <form id="estabelcimento" class="w-75 form_editar" style="margin:auto" method="GET">
        <p class="h4 pt-4">Informações</p>

        <div class="align-items-md-stretch">
            <div>
                <div class="card pb-2">
                    <div class="p-3 d-flex justify-content-between">
                        <p class="h5">Informações Pessoais</p>
                        <button id="btn_guardar" class="btn btn-success direito" style="width: auto;" type="button"
                            value="Guardar">Guardar</button>

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
                        <div class="" style="">
                            <!-- Nome -->
                            <span>Nome<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap">
                                <input name="nome" type="text" class="form-control" placeholder="Nome"
                                    aria-label="Nome" aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['nome']))
                                        echo $estabelecimento['nome']; ?>">
                                <span id="erroNome" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>

                            <!-- localizacao -->
                            <span>Localização</span>
                            <div class="input-group flex-nowrap">
                                <input name="morada" type="text" class="form-control mb-4"
                                    placeholder="Localização" aria-label="Localização" aria-describedby="addon-wrapping"
                                    value="<?php if (!empty($estabelecimento['localizacao']))
                                        echo $estabelecimento['localizacao']; ?>">
                                <span id="erroLocalizacao" class="help-inline small" style="color:#ff0000"></span>
                            </div>

                            <!-- Mapa -->
                            <div>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18906.129712753736!2d6.722624160288201!3d60.12672284414915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x463e997b1b6fc09d%3A0x6ee05405ec78a692!2sJ%C4%99zyk%20trola!5e0!3m2!1spl!2spl!4v1672239918130!5m2!1spl!2spl"
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>

                            &emsp;
                            <hr class="m-1">&emsp;

                            <!-- Telemóvel -->
                            <span>Nº de Telemóvel<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap">
                                <input name="telemovel" type="text" class="form-control"
                                    placeholder="Telemóvel" aria-label="Telemovel" aria-describedby="addon-wrapping"
                                    value="<?php if (!empty($estabelecimento['telemovel']))
                                        echo $estabelecimento['telemovel']; ?>">
                                <span id="erroTelemovel" class="help-inline small" style="color:#ff0000"></span>
                            </div>
                            <br>
                            <!-- taxa_entrega -->
                            <div class="row">
                                <div class="col-md-4">
                                    <span>Taxa de Entrega<span style='color:#ff0000'> *</span></span>
                                    <div class="input-group flex-nowrap">
                                        <input name="taxa_entrega" type="text" class="form-control"
                                            placeholder="Taxa de Entrega" aria-label="Taxa de Entrega"
                                            aria-describedby="addon-wrapping" value="<?php if (!empty($estabelecimento['taxa_entrega']))
                                                echo $estabelecimento['taxa_entrega']; ?>">
                                        <span id="erroTaxaEntrega" class="help-inline small"
                                            style="color:#ff0000;padding-top:10px"></span>
                                    </div>
                                </div>

                                <!-- tempo_medio_entrega -->
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <span>Tempo médio de entrega<span style='color:#ff0000'> *</span></span>
                                        <div class="input-group flex-nowrap">
                                                    <input name="tempo_medio_entrega" id="appt-time" type="time" name="appt-time"
                                                    value="<?php if (!empty($estabelcimento['tempo_medio_entrega']))
                                                           echo $estabelcimento['tempo_medio_entrega']; ?>" required>
                                            <span id="erroTempoMedioEntrega" class="help-inline small"
                                                style="color:#ff0000;padding-top:10px"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<div class="d-grid gap-2">
            <form id="apagar_form" action="estabelecimento_page.php" method="post">
                <input type="hidden" name="id_estabelecimento"
                    value="<?php echo htmlentities($estabelecimento['id_estabelecimento']); ?>">
                <button id="apagar_btn" class="btn btn-danger direito" style="width: auto;">
                    Apagar Estabelecimento
                </button>
            </form>
        </div>-->
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
</body>

</html>