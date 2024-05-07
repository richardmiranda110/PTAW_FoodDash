<?php
include __DIR__ . "/database/db_connection.php";
$pdo = include __DIR__ . "/database/db_connection.php";
include __DIR__ . "/database/utilizadores.php";

// Recebendo dados da BD de um determinado utilizador
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Obter os dados do utilizador
    $utilizador = ObterUmUtilizador($pdo, 1); // ALTERAR O ID
    //var_dump($utilizador);
}

/*UPDATE Clientes
SET nome = 'novo_nome',
    apelido = 'novo_apelido',
    email = 'novo_email',
    telemovel = 987654321,
    morada = 'nova_morada',
    cidade = 'nova_cidade',
    pais = 'novo_pais',
    CodPostal = 'novo_codigo_postal',
    password = 'nova_password'
WHERE id = 1; */

// Enviando dados para a BD, ao editar dados de um determinado utilizador
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and trim user input
    $utilizadorModificado = array(
        /*'Nome' => $_POST['Nome'],
        'Apelido' => $_POST['Apelido'],
        'Email' => $_POST['Email'],
        'Telemovel' => $_POST['Telemovel'],
        'Morada' => $_POST['Morada'],
        'Cidade' => $_POST['Cidade'],
        'Pais' => $_POST['Pais'],
        'CodPostal' => $_POST['CodPostal']*/
        'Nome' => htmlentities(trim($_POST['Nome'])),
        'Apelido' => htmlentities(trim($_POST['Apelido'])),
        'Email' => htmlentities(trim($_POST['Email'])),
        'Telemovel' => htmlentities(trim($_POST['Telemovel'])),
        'Morada' => htmlentities(trim($_POST['Morada'])),
        'Cidade' => htmlentities(trim($_POST['Cidade'])),
        'Pais' => htmlentities(trim($_POST['Pais'])),
        'CodPostal' => htmlentities(trim($_POST['CodPostal']))
    );

    //EditarUtilizador($pdo, 1, $utilizadorModificado);
    // Editar o usuário no banco de dados
    $resultado = EditarUtilizador($pdo, 1, $utilizadorModificado);

    // Verificar se a edição foi bem-sucedida
    if ($resultado) {
        echo "SUCESSO";
        // Redirecionar o usuário para outra página ou exibir outra mensagem de sucesso
    } else {
        echo "ERRO";
        // Exibir uma mensagem de erro ou redirecionar o usuário para outra página
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
</head>

<body>
    <?php
    include __DIR__ . "/includes/header_logged_in.php";
    ?>

    <?php
    include __DIR__ . "/includes/sidebar_perfil.php";
    ?>

    <form class="perfil centro texto_perfil form_editar">
        <h3>Perfil do Utilizador</h3>
        <p>Esta é a tua página de perfil de utilizador. Aqui podes ver as tuas informações pessoais e editá-las</p>


        <div class="pedidos">
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
                            <div class="esquerdo" style="padding:5px">
                                <span>Primeiro Nome</span>
                                <div class="input-group flex-nowrap">
                                    <input name="nome" readonly type="text" class="form-control"
                                        placeholder="Primeiro Nome" aria-label="Primeiro Nome"
                                        aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['nome']))
                                            echo $utilizador['nome']; ?>">
                                </div>
                                <br>
                                <span>Email</span>
                                <div class="input-group flex-nowrap">
                                    <input name="email" readonly type="text" class="form-control" placeholder="Email"
                                        aria-label="Email" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['email']))
                                            echo $utilizador['email']; ?>">
                                </div>
                            </div>
                            <div class="direito" style="padding:5px">
                                <span>Apelido</span>
                                <div class="input-group flex-nowrap">
                                    <input name="apelido" readonly type="text" class="form-control"
                                        placeholder="Apelido" aria-label="Apelido" aria-describedby="addon-wrapping"
                                        value="<?php if (!empty($utilizador['apelido']))
                                            echo $utilizador['apelido']; ?>">
                                </div>
                                <br>
                                <span>Nº de Telemóvel</span>
                                <div class="input-group flex-nowrap">
                                    <input name="telemovel" readonly type="text" class="form-control"
                                        placeholder="Telemóvel" aria-label="Telemovel" aria-describedby="addon-wrapping"
                                        value="<?php if (!empty($utilizador['telemovel']))
                                            echo $utilizador['telemovel']; ?>">
                                </div>
                            </div>

                            &emsp;
                            <hr>&emsp;

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
                                        <span>Cidade</span>
                                        <div class="input-group flex-nowrap">
                                            <input name="cidade" readonly type="text" class="form-control"
                                                placeholder="Cidade" aria-label="Cidade"
                                                aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['cidade']))
                                                    echo $utilizador['cidade']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <span>País</span>
                                        <div class="input-group flex-nowrap">
                                            <input name="pais" readonly type="text" class="form-control"
                                                placeholder="País" aria-label="País" aria-describedby="addon-wrapping"
                                                value="<?php if (!empty($utilizador['pais']))
                                                    echo $utilizador['pais']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
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
        </div>
    </form>
    <?php
    include __DIR__ . "/includes/footer_2.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!--<script src="C:\xampp\htdocs\PTAW_FoodDash\assets\js\perfil.php"></script>-->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Obtém os elementos
            var btnEditar = document.getElementById("btn_editar");
            var inputs = document.querySelectorAll(".form-control");
            var form = document.querySelector(".form_editar");

            // Adiciona evento de clique ao botão
            btnEditar.addEventListener("click", function () {
                // Alterar para modo de edição
                if (btnEditar.innerHTML == "Editar") {
                    btnEditar.innerHTML = "Guardar";
                    btnEditar.setAttribute("type", "button");
                    btnEditar.style.backgroundColor = "green";
                    btnEditar.style.color = "white";
                    inputs.forEach(function (input) {
                        input.removeAttribute("readonly");
                    });
                }
                // Alterar para modo de leitura
                else {
                    btnEditar.innerHTML = "Editar";
                    btnEditar.setAttribute("type", "submit");
                    btnEditar.style.backgroundColor = "#FEBB41";
                    btnEditar.style.color = "black";
                    inputs.forEach(function (input) {
                        input.setAttribute("readonly", "readonly");
                    });
                }
            });


            // Função para exibir mensagem de pop-up
            /*function exibirMensagem(mensagem) {
                alert(mensagem);
            }
    
            // Submeter o formulário
            document.getElementById("form_editar").addEventListener("submit", function (event) {
                event.preventDefault(); // Impede o envio padrão do formulário
    
                // Realizar a submissão dos dados via AJAX ou fetch
    
                // Simular uma mensagem de sucesso ou erro
                var sucesso = true; // Altere para false para simular um erro
    
                if (sucesso) {
                    exibirMensagem("Dados alterados com sucesso!");
                } else {
                    exibirMensagem("Ocorreu um erro ao alterar os dados. Por favor, tente novamente.");
                }
            });*/
        });
    </script>

</html>
