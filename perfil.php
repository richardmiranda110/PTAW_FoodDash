<?php
//include __DIR__ . "/database/db_connection.php";
//$pdo = include __DIR__ . "/database/db_connection.php";
//var_dump($pdo);
include __DIR__ . "/database/utilizadores.php";
?>

<?php
function ObterUmUtilizador($ID)
{
    try {
        //conexão ao banco de dados
        $pdo = new PDO(
            'mysql:host=localhost;port=3306;dbname=bd_ptaw_2024;charset=utf8',
            'root',
            ''
        );

        //query
        $stmt = $pdo->prepare('SELECT * FROM Clientes WHERE id = ?');
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        // Executar a query e verificar que não retornou false
        if ($stmt->execute()) {
            // Fetch retorna um único resultado, então usamos fetch() e não fetchAll()
            $registo = $stmt->fetch();
            // Retornar os dados
            return $registo;

        } else {
            // Se a consulta falhar, retornar null
            echo "AAAAAAAAAAAAAA";
            return null;
        }

    } catch (Exception $e) {
        echo "Erro na conexão à BD: " . $e->getMessage();
        // Se ocorrer um erro, retornar null
        return null;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Obter os dados do utilizador
    $utilizador = ObterUmUtilizador(1);
    echo var_dump($utilizador);
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

    <div class="perfil centro texto_perfil">
        <h3>Perfil do Utilizador</h3>
        <p>Esta é a tua página de perfil de utilizador. Aqui podes ver as tuas informações pessoais e editá-las</p>

        <div class="pedidos">
            <div class="align-items-md-stretch">
                <div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="esquerdo">A minha conta</h5>
                            <button id="btn_editar" class="btn btn-warning direito" style="width: auto;"> Editar
                            </button>
                        </div>
                        <div class="card-body">

                            <p class="cinzento" style="padding:5px">Informação do Utilizador</p>
                            <div class="esquerdo" style="padding:5px">
                                <span>Primeiro Nome</span>
                                <div class="input-group flex-nowrap">
                                    <input readonly type="text" class="form-control" placeholder="Primeiro Nome"
                                        aria-label="Primeiro Nome" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['nome']))
                                            echo $utilizador['nome']; ?>">
                                </div>
                                <br>
                                <span>Email</span>
                                <div class="input-group flex-nowrap">
                                    <input readonly type="text" class="form-control" placeholder="Email"
                                        aria-label="Email" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['email']))
                                            echo $utilizador['email']; ?>">
                                </div>
                            </div>
                            <div class="direito" style="padding:5px">
                                <span>Apelido</span>
                                <div class="input-group flex-nowrap">
                                    <input readonly type="text" class="form-control" placeholder="Apelido"
                                        aria-label="Apelido" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['apelido']))
                                            echo $utilizador['apelido']; ?>">
                                </div>
                                <br>
                                <span>Nº de Telemóvel</span>
                                <div class="input-group flex-nowrap">
                                    <input readonly type="text" class="form-control" placeholder="Telemóvel"
                                        aria-label="Telemovel" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['telemovel']))
                                            echo $utilizador['telemovel']; ?>">
                                </div>
                            </div>

                            &emsp;
                            <hr>&emsp;

                            <p class="cinzento">Morada</p>
                            <span>Morada</span>
                            <div class="input-group flex-nowrap">
                                <input readonly type="text" class="form-control" placeholder="Morada"
                                    aria-label="Morada" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['morada']))
                                        echo $utilizador['morada']; ?>">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12 esquerdo">
                                        <span>Cidade</span>
                                        <div class="input-group flex-nowrap">
                                            <input readonly type="text" class="form-control" placeholder="Cidade"
                                                aria-label="Cidade" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['cidade']))
                                                    echo $utilizador['cidade']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <span>País</span>
                                        <div readonly class="input-group flex-nowrap">
                                            <input readonly type="text" class="form-control" placeholder="País"
                                                aria-label="País" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['pais']))
                                                    echo $utilizador['pais']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <span>Código-Postal</span>
                                        <div class="input-group flex-nowrap">
                                            <input readonly type="text" class="form-control" placeholder="Código Postal"
                                                aria-label="Código Postal" aria-describedby="addon-wrapping" value="<?php if (!empty($utilizador['CodPostal']))
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
        <?php
        include __DIR__ . "/includes/footer_2.php";
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

<script>
    /*Se não clicar no botão editar,
     - dizer que todos os inputs são "readonly", isto é são visivéis e não editáveis
    se clicar
    - por o botão como guardar ou disabled
    - retirar as propriedades readonly
    - criar botão guardar*/

    document.addEventListener("DOMContentLoaded", function () {
        // Obtém os elementos
        var btnEditar = document.getElementById("btn_editar");
        var inputs = document.querySelectorAll(".form-control");

        // Adiciona evento de clique ao botão
        btnEditar.addEventListener("click", function () {
            // Alterar para modo de edição
            if (btnEditar.innerHTML === "Editar") {
                btnEditar.innerHTML = "Guardar";
                inputs.forEach(function (input) {
                    input.removeAttribute("readonly");
                });
            }
            // Alterar para modo de leitura
            else {
                btnEditar.innerHTML = "Editar";
                inputs.forEach(function (input) {
                    input.setAttribute("readonly", "readonly");
                });

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $Validacao = True;

                    // Atribuir os dados do formulário à variável $utilizador e, ao mesmo tempo,
                    // retirar carateres perigosos

                    // Sanitize and trim user input
                    $utilizador = array(
                        'Nome' => $_POST['Nome'],
                        'Apelido' => $_POST['Apelido'],
                        'Email' => $_POST['Email'],
                        'Telemovel' => $_POST['Telemovel'],
                        'Morada' => $_POST['Morada'],
                        'Cidade' => $_POST['Cidade'],
                        'Pais' => $_POST['Pais'],
                        'CodPostal' => $_POST['CodPostal']
                    );
                


                    // Se não ocorreram erros de validação, atualizar o produto
                    if ($Validacao) {
                        var_dump($utilizador);
                        // Atualiza os dados do utilizador
                        EditarUtilizador($pdo, 1, $utilizador);
                    }
                    ?>
                }
            }
        });
    });
}
</script>

</html>