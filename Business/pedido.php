<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/../database/credentials.php';
require_once __DIR__ . '/../database/db_connection.php';

if (!isset($_SESSION['id_estabelecimento']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: /Business/login_register/login_business.php");
}

if(!isset($_GET['idpedido'])){
    header("Location: /Business/dashboard_home_page.php");
}

$idPedido = $_GET['idpedido'];
$idEstabelecimento = $_SESSION['id_estabelecimento'];

try {
    $sql =
        "SELECT cl.nome as nome, cl.apelido as apelido,
    cl.email as email , cl.telemovel as telemovel,
    cl.morada as morada, cl.cidade as cidade,
    cl.codpostal as codpostal,
    pi.id_pedido as id_pedido,
    pi.id_item as id_item_pedido,
    itens.nome as nome_item,
    pi.quantidade as quantidade_pedida,
    pedido.data as data, pedido.estado as estado,
    pedido.precototal as total,pedido.id_pedido as id_pedido
    FROM pedido_itens pi
    FULL JOIN itens 
    on itens.id_item=pi.id_item
    FULL JOIN pedidos pedido 
    on pedido.id_pedido=pi.id_pedido
    FULL JOIN clientes cl 
    on pedido.id_cliente = cl.id_cliente
    FULL JOIN pedido_item_opcoes pio
    on itens.id_item = pio.id_pedido_item
    where pedido.id_pedido = ? and pedido.id_estabelecimento = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idPedido,$idEstabelecimento]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 0) {
        exit("Pedido não encontrado");
    }

    $query =
        "SELECT item.nome as item_nome, item.preco as item_preco,         -- item_nome, item_preco,
        disponivel as item_disponivel, foto as item_foto, itemsozinho,    -- item_disponivel, item_foto
        personalizacoesativas, pi.id_pedido_item as id_item_no_pedido,    -- personalizacoesativas, id_item_no_pedido
        pi.id_item as item_id, pi.quantidade as item_quantidade,          -- id_item_no_pedido, item_id
        pio.id_pedido_item_opcao as id_opcao_no_item_pedido,              -- id_pedido_item_opcao
        pio.id_pedido_item as opcao_no_item_pedido,                       -- opcao_no_item_pedido
        pio.id_opcao, pio.quantidade                                      -- opcao de cada item do pedido
        FROM pedido_itens pi
        inner join itens item on item.id_item=pi.id_item
        inner join pedidos pedido on pedido.id_pedido=pi.id_pedido
        full join pedido_item_opcoes pio on pio.id_pedido_item = pi.id_pedido_item
        where pedido.id_pedido = ? and pedidos.id_estabelecimento = ?;";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$idPedido,$idEstabelecimento]);
    $itens = $stmt->fetchAll();

    $item_arr = array();
    foreach ($itens as &$item) {
        array_push($item_arr, $item['item_nome']);
    }

    $descricao = implode(' + ', $item_arr);
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FoodDash Business</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../business/styles/adicionar.css" />
    <link rel="stylesheet" href="../../assets/styles/sitecss.css" />
    <link rel="stylesheet" href="../../assets/styles/dashboard.css" />
    <link rel="stylesheet" href="./assets/styles/pedido_page.css" />
    <link rel="stylesheet" href="../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link rel="stylesheet" href="../assets/styles/responsive_styles.css">
    <script src="../../assets/js/dable.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            max-width: 50vw;
            border-radius: 15px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
        <?php include __DIR__ . "/includes/sidebar_business.php"; ?>
    </div>

    <!--Zona de Conteudo -->
    <div class="container" style="margin-top: 15vh;">
        <div class="card shadow-sm py-1" style="width: 115vh !important;max-width:100vw;margin: 0 auto;">
            <div class="container">
                <div class="card-body">
                    <h3 class="card-title fw-bold"><?php echo 'Pedido #' . $pedido['id_pedido'] . ', ' . $pedido['nome'] ?></h3>
                    <p><strong>Data e Hora:</strong> <?php echo $pedido['data'] ?></p>
                    <p><strong>Status do Pedido:</strong> <?php echo $pedido['estado'] ?></p>
                    <p><strong>Total: </strong><?php echo $pedido['total'] ?> €</p>
                </div>

                <div class="container mb-4">
                    <!-- grid caralho, tira isto por favor -->
                    <div class="grid gap-0 column-gap-3">
                        <!-- PRIMEIRO CARALHO, TIRA ISTO POR FAVOR
                            <div class="g-col-4 card p-0 rounded-3 shadow-sm">
                                <div class="card-header py-3">
                                    <h4 class="my-0 text-center  card-header-text">Menu Big King</h4>
                                </div>
                                <div class="card-body">
                                    <p class="card-title card-body-big-text pricing-card-title">5,99€</p>
                                    <p class="card-body-big-text"><? php // echo htmlspecialchars($descricao) 
                                                                    ?></p>
                                    
                                    <div class="div_personalizacoes">
                                        <p class="h5 card-body-huge-text">Personalizações:</p>
                                        <div>
                                            <p class="h6 card-body-text" style="margin-bottom: 0.5vh;">Big King:</p>
                                            <ul style="margin: 0;">
                                                <li class="card-body-small-text" style="padding: 0.2vh">0 picles</li>
                                                <li class="card-body-small-text" style="padding: 0.2vh">+1 Carne</li>
                                            </ul>
                                        </div>
                                        <div>
                                            <p class="h6 card-body-text"style="margin-bottom: 0.5vh;">Coca Cola Zero:</h6>
                                            <ul style="margin: 0;">
                                                <li class="card-body-small-text" style="padding: 0.2vh">Sem gelo</li>
                                            </ul>
                                        </div>
                                        <div>
                                            <p class="h6 card-body-text" style="margin-bottom: 0.5vh;">Batatas Médias:</p>
                                            <ul style="margin: 0;">
                                                <li class="card-body-small-text" style="padding: 0.2vh">Sem sal</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        <?php
                        foreach ($itens as &$item) {
                            echo '
                                <!-- SEGUNDO CARALHO -->
                                <div class="g-col-4 card p-0 rounded-3 shadow-sm">
                                    <div class="card-header py-3">
                                        <p class=" h4 my-0 card-header-text">' . $item['item_nome'] . '</p>
                                    </div>
                                    <div class="card-body">
                                        <p class=" h6 card-title card-body-big-text pricing-card-title">' . $item['item_preco'] . ' €</p>
                                        <p class="h6">' . $item['item_nome'] . '</h6>';

                            if ($item['personalizacoesativas']) {
                                echo
                                '<div class="div_personalizacoes mr-2">
                                    <p class="h5 card-body-huge-text">Personalizações:</p>';
                                if ($item['itemsozinho'] == false) {
                                    echo $descricao;
                                } else {
                                    $options = getItemPersonalizations($item['id_item_no_pedido']);
                                    echo '
                                        <div>
                                            <p class="h6 card-body-text" style="margin-bottom: 0.5vh;">' . $item['item_nome'] . '</p>
                                            <ul style="margin: 0;">';
                                    foreach ($options as &$option) {
                                        if ($option['quantidade'] == 0)
                                            echo ' <li class="card-body-small-text" style="padding: 0.2vh">' . ($option['quantidade'] == 0 ? 'Sem ' : 'Com ') . $option['nome'] . '</li>';
                                    }
                                    echo '</ul>
                                        </div>';
                                }
                                echo '</div>';
                            }

                            echo  '</div></div>';
                        }


                        function getItemPersonalizations($id_pedido_item)
                        {
                            global $pdo;
                            global $idEstabelecimento;

                            $query =
                                "SELECT pio.id_pedido_item as opcao_no_item_pedido,                       -- opcao_no_item_pedido
                                opcao.nome, pio.quantidade as quantidade, opcao.preco                     -- opcao de cada item do pedido
                                FROM pedido_itens pi
                                inner join itens item on item.id_item=pi.id_item
                                inner join pedidos pedido on pedido.id_pedido=pi.id_pedido
                                full join pedido_item_opcoes pio on pio.id_pedido_item = pi.id_pedido_item
                                inner join opcoes opcao on opcao.id_opcao =pio.id_opcao
                                where pio.id_pedido_item = ? and pedidos.id_estabelecimento = ?;";

                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$id_pedido_item,$idEstabelecimento]);
                            return $stmt->fetchAll();
                        }
                        ?>


                    </div>
                </div>

                <div class="customer-info mb-4">
                    <p class="text-center">Dados do Cliente</p>
                    <p><strong>Nome:</strong><?php echo $pedido['nome'] . ' ' . $pedido['apelido'] ?></p>
                    <p><strong>Telemóvel:</strong> <?php echo $pedido['telemovel'] ?></p>
                    <p><strong>Email:</strong> <?php echo $pedido['email'] ?></p>
                    <p><strong>Morada:</strong> <?php echo $pedido['morada'] ?>, <?php echo $pedido['codpostal'] ?>, <?php echo $pedido['cidade'] ?></p>
                </div>

                <?php
                switch ($pedido['estado']) {
                    case 'EFETUADO':
                        $step1 = 'active';
                        $step2 = '';
                        $step3 = '';
                        $step4 = '';
                        $width = '3%';
                        break;
                    case 'EM PREPARACAO':
                        $step1 = 'active';
                        $step2 = 'active';
                        $step3 = '';
                        $step4 = '';
                        $width = '33%';
                        break;
                    case 'A CAMINHO':
                        $step1 = 'active';
                        $step2 = 'active';
                        $step3 = 'active';
                        $step4 = '';
                        $width = '66%';
                        break;
                    case 'ENTREGUE':
                        $step1 = 'active';
                        $step2 = 'active';
                        $step3 = 'active';
                        $step4 = 'active';
                        $width = '100%';
                        break;
                    default:
                        exit('Algo de errado aconteceu');
                }
                ?>

                <div class="process-wrapper mb-3">
                    <div id="progress-bar-container">
                        <ul>
                            <li class="step step01 <?php echo $step1 ?>">
                                <div class="step-inner <?php echo $step1 ?>">PEDIDO EFETUADO</div>
                            </li>
                            <li class="step step02 <?php echo $step2 ?>">
                                <div class="step-inner <?php echo $step2 ?>">PREPARAÇÃO</div>
                            </li>
                            <li class="step step03 <?php echo $step3 ?>">
                                <div class="step-inner <?php echo $step3 ?>">VIAGEM ATÉ DESTINO</div>
                            </li>
                            <li class="step step04 <?php echo $step4 ?>">
                                <div class="step-inner <?php echo $step4 ?>">ENTREGUE</div>
                            </li>
                        </ul>
                        <div id="line">
                            <div id="line-progress" style="width:<?php echo $width ?>;"></div>
                        </div>
                    </div>
                    <div id="progress-content-section" style="height: 12vw;">
                        <div class="section-content efetuacao-pedido <?php echo $pedido['estado'] == 'EFETUADO' ? 'active' : '' ?>">
                            <h2>Efetuação do Pedido</h2>
                            <p>O pedido foi efetuado.</p>
                            <div class="d-flex justify-content-center mt-4 mb-4">
                                <button class="btn btn-outline-warning btn-block" id="btn_comecar_preparar" style="color: #343a40;">Começar a Preparar</button>
                            </div>
                        </div>
                        <div class="section-content preparacao  <?php echo $pedido['estado'] == 'EM PREPARACAO' ? 'active' : '' ?>">
                            <h2>Preparação</h2>
                            <p>O pedido está em fase de preparação. Assim que o pedido estiver pronto para entrega dê-o ao seu entregador e carregue no botão abaixo para iniciar a fase entrega.</p>
                            <label for="entregadores">Escolha um Zé disponível para entregar o pedido:</label><br>
                            <select name="entregadores" id="entregadores">
                                <option value="1">Zé 1</option>
                                <option value="2">Zé 2</option>
                                <option value="3">Zé 3</option>
                                <option value="4">Zé 4</option>
                            </select>

                            <?php
                            /* $query = "SELECT id_entregador, nome, veiculo FROM Entregadores WHERE disponivel = TRUE";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            $entregadoresDisponiveis = $stmt->fetchAll();

                            $entregadores_arr = array();
                            echo '<label for="entregadores">Escolha um Zé disponível para entregar o pedido:</label><br>
                            <select name="entregadores" id="entregadores">';
                            foreach ($entregadoresDisponiveis as &$entregador) { //para que serve o & ???
                                array_push($entregadores_arr, $entregador['id_entregador'], $entregador['nome'], $entregador['veiculo']);
                                echo '<option value="' . $entregador['id_entregador'] . '">' . $entregador['nome'] . ' ' . $entregador['veiculo'] . '</option>';
                            }
                            echo '</select>'; */
                            ?>

                            <div class="d-flex justify-content-center mt-4 mb-4">
                                <button class="btn btn-outline-warning btn-block" id="btn_pedido_pronto" style="color: #343a40;">Pedido Pronto</button>
                            </div>
                        </div>
                        <div class="section-content viagem <?php echo $pedido['estado'] == 'A CAMINHO' ? 'active' : '' ?>">
                            <h2>Viagem até ao Destino</h2>
                            <p>O pedido está a caminho do seu cliente.</p>
                        </div>
                        <div class="section-content entregue <?php echo $pedido['estado'] == 'ENTREGUE' ? 'active' : '' ?>">
                            <h2>Entregue</h2>
                            <p>O pedido foi entregue com sucesso. Parabéns. Muito obrigado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <br />
    <!--Zona do Footer -->
    <?php include __DIR__ . "../../includes/footer_2.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        let width = '<?php echo $width; ?>';
        $(".disabled");



        $(".step01").click(function() {
            if ($(this).hasClass("active")) {
                return;
            }

            $("#line-progress").css("width", '3%');
            $(".efetuacao-pedido").addClass("active").siblings().removeClass("active");
        });

        $("#btn_comecar_preparar").click(function() {
            if ($(this).hasClass("active") == true) {
                return;
            }

            $("#line-progress").css("width", "33%");
            $(".preparacao").addClass("active").siblings().removeClass("active");
            $(".step02").addClass("active");

            $.ajax({
                url: "/business/pedidos.php?id=<?php echo $pedido['id_pedido'] ?>&stage=2",
                success: function(result) {
                    console.log(result);
                }
            });
        });

        $("#btn_pedido_pronto").click(function() {
            if ($(this).hasClass("active") == true) {
                return
            }

            $("#line-progress").css("width", "66%");
            $(".viagem").addClass("active").siblings().removeClass("active");
            $(".step03").addClass("active");

            $.ajax({
                url: "/business/pedidos.php?id=<?php echo $pedido['id_pedido'] ?>&stage=3",
                success: function(result) {
                    console.log(result);
                }
            });

        });

        $(".step04").click(function() {
            if ($(this).hasClass("active") == true) {
                return;
            }

            $("#line-progress").css("width", "100%");
            $(".entregue").addClass("active").siblings().removeClass("active");
            $(".step04").addClass("active");

            $.ajax({
                url: "/business/pedidos.php?id=<?php echo $pedido['id_pedido'] ?>&stage=4",
                success: function(result) {
                    console.log(result);
                }
            });

        });
    </script>
</body>

</html>