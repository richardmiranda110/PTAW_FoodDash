<?php
//include __DIR__ . "/database/db_connection.php";
//$pdo = include __DIR__ . "/database/db_connection.php";
include __DIR__ . "/database/utilizadores.php";

//conexão ao banco de dados
define("DBHOST", "localhost");
define("DBPORT", "5432");
define("DBNAME", "ptaw");
define("DBUSER", "postgres");
define("DBPASS", "test");

$pdo = new PDO(
    "pgsql:host=" . DBHOST .
    "; port=" . DBPORT .
    ";dbname=" . DBNAME,
    DBUSER,
    DBPASS
);

// Recebendo dados da BD de um determinado utilizador
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Obter os dados do utilizador
    $utilizador = ObterUmUtilizador($pdo, 1); // ALTERAR O ID
}

// Enviando dados para a BD, ao editar dados de um determinado utilizador
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Validacao = True;

    // Verificar que os campos obrigatórios estão preenchidos
    // Campo Email
    if (empty($_POST['email'])) {
        $ErroEmail = "Preenchimento obrigatório";
        $Validacao = False;
    }

    // Atribuir os dados do formulário à variável $utilizador e, ao mesmo tempo,
    // retirar carateres perigosos
    $utilizadorModificado = array(
        'nome' => htmlentities(trim($_POST['nome'])),
        'apelido' => htmlentities(trim($_POST['apelido'])),
        'email' => htmlentities(trim($_POST['email'])),
        'telemovel' => htmlentities(trim($_POST['telemovel'])),
        'morada' => htmlentities(trim($_POST['morada'])),
        'cidade' => htmlentities(trim($_POST['cidade'])),
        'pais' => htmlentities(trim($_POST['pais'])),
        'CodPostal' => htmlentities(trim($_POST['CodPostal']))
    );

    // Verificar que os campos numéricos apenas contêm números
    // Telemovel
    if ((!empty($_POST['Telemovel'])) && (!is_numeric($utilizador['Telemovel']))) {
        $ErroTelemovel = "Apenas pode conter números";
        $Validacao = False;
    }

    // Se não ocorreram erros de validação, atualizar o produto
    if ($Validacao == true) {
        // Editar o usuário no banco de dados
        if (EditarUtilizador($pdo, 1, $utilizadorModificado)) { // ALTERAR ID
            $utilizador = ObterUmUtilizador($pdo, 1); // ALTERAR ID
            echo "<script>
            $(document).ready(function(){
                $('#modal_sucesso').modal('show');
            });
        </script>";
        } else {
            echo "<script>
            $(document).ready(function(){
                $('#modal_erro').modal('show');
            });
        </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Perfil</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles/dashboard_beatriz.css">
    <link rel="stylesheet" href="./assets/styles/sitecss.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php
    include __DIR__ . "/includes/header_logged_in.php";
    ?>

    <?php
    include __DIR__ . "/includes/sidebar_perfil.php";
    ?>
    <!-- Modal de Sucesso -->
    <div class="modal fade" id="modal_sucesso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sucesso!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    O utilizador foi alterado com sucesso!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Erro -->
    <div class="modal fade" id="modal_erro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Erro!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ocorreu um erro ao editar o utilizador.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <form class="centro esquerdo form_editar" method="GET">
        <h3>Perfil do Utilizador</h3>
        <p>Esta é a tua página de perfil de utilizador. Aqui podes ver as tuas informações pessoais e editá-las</p>

        <div class="align-items-md-stretch">
            <div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="esquerdo">A minha conta</h5>
                        <button id="btn_editar" class="btn btn-warning direito" style="width: auto;" type="button"
                            value="Editar">Editar</button>
                    </div>
                    <div class="card-body">

                        <p class="cinzento" style="padding:5px">Informação do Utilizador</p>

                        <!-- Informação da existência de campos obrigatórios -->
                        <div class="alert" role="alert">
                            <i class="fas fa-info-circle" style="font-size:24px"></i>
                            <strong>Campos marcados com <span style='color:#ff0000'>*</span> são obrigatórios</strong>
                        </div>
                        <div class="esquerdo" style="padding:5px">
                            <!-- Nome -->
                            <span>Primeiro Nome</span>
                            <div class="input-group flex-nowrap">
                                <input name="nome" readonly type="text" class="form-control" placeholder="Primeiro Nome"
                                    aria-label="Primeiro Nome" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['nome']))
                                        echo $utilizador['nome']; ?>">
                            </div>
                            <br>

                            <!-- Email -->
                            <span>Email<span style='color:#ff0000'> *</span></span>
                            <div class="input-group flex-nowrap <?php if (!empty($ErroEmail)) { ?>has-error<?php } ?>">
                                <input name="email" readonly type="text" class="form-control" placeholder="Email"
                                    aria-label="Email" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['email']))
                                        echo $utilizador['email']; ?>">
                                <br>
                                <?php if (!empty($ErroEmail)) { ?>
                                    <span class="help-inline small" style="color:#ff0000"><?php echo $ErroEmail; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="direito" style="padding:5px">
                            <!-- Apelido -->
                            <span>Apelido</span>
                            <div class="input-group flex-nowrap">
                                <input name="apelido" readonly type="text" class="form-control" placeholder="Apelido"
                                    aria-label="Apelido" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['apelido']))
                                        echo $utilizador['apelido']; ?>">
                            </div>
                            <br>
                            <!-- Telemóvel -->
                            <span>Telemóvel</span>
                            <div class="input-group flex-nowrap">
                                <input name="telemovel" readonly type="text" class="form-control"
                                    placeholder="Telemóvel" aria-label="Telemovel" aria-describedby="addon-wrapping"
                                    value="<?php if (!empty($utilizador['telemovel']))
                                        echo $utilizador['telemovel']; ?>">
                            </div>
                        </div>

                        &emsp;
                        <hr>&emsp;

                        <!-- Morada -->
                        <p class="cinzento">Morada</p>
                        <span>Morada</span>
                        <div class="input-group flex-nowrap">
                            <input name="morada" readonly type="text" class="form-control" placeholder="Morada"
                                aria-label="Morada" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['morada']))
                                    echo $utilizador['morada']; ?>">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12 esquerdo">
                                    <!-- Cidade -->
                                    <span>Cidade</span>
                                    <div class="input-group flex-nowrap">
                                        <input name="cidade" readonly type="text" class="form-control"
                                            placeholder="Cidade" aria-label="Cidade" aria-describedby="addon-wrapping"
                                            value="<?php if (!empty($utilizador['cidade']))
                                                echo $utilizador['cidade']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <!-- País -->
                                    <span>País</span>
                                    <div class="input-group flex-nowrap">
                                        <input name="pais" readonly type="text" class="form-control" placeholder="País"
                                            aria-label="País" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['pais']))
                                                echo $utilizador['pais']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <!-- Código Postal -->
                                    <span>Código-Postal</span>
                                    <div class="input-group flex-nowrap">
                                        <input name="CodPostal" readonly type="text" class="form-control"
                                            placeholder="Código Postal" aria-label="Código Postal"
                                            aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['CodPostal']))
                                                echo $utilizador['CodPostal']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    include __DIR__ . "/includes/footer_2.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Obtém os elementos
            var btnEditar = document.getElementById("btn_editar");
            var inputs = document.querySelectorAll(".form-control");
            var form = document.querySelector(".form_editar");
            var validacao = <?php echo json_encode($Validacao); ?>;

            // Adiciona evento de clique ao botão
            btnEditar.addEventListener("click", function () {
                // Alterar para modo de edição
                if (btnEditar.innerHTML == "Editar") {
                    btnEditar.innerHTML = "Guardar";
                    btnEditar.setAttribute("type", "button");
                    btnEditar.classList.remove("btn-warning");
                    btnEditar.classList.add("btn-success");
                    inputs.forEach(function (input) {
                        input.removeAttribute("readonly");
                    });
                    form.method = 'GET';
                    form.removeAttribute("action");
                }
                // Alterar para modo de leitura
                else {
                    // se não houver erros no formulário, mudar para modo de leitura
                    if (validacao == true) {
                        btnEditar.innerHTML = "Editar";
                        btnEditar.setAttribute("type", "submit");
                        btnEditar.classList.remove("btn-success");
                        btnEditar.classList.add("btn-warning");
                        inputs.forEach(function (input) {
                            input.setAttribute("readonly", "readonly");
                        });
                        form.method = 'POST';
                        form.setAttribute("action", "perfil.php");
                    }
                }
            });
        });
    </script>

</html>