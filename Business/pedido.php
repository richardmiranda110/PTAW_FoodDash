<?php
require_once __DIR__.'/includes/session.php';
require_once __DIR__.'/../database/credentials.php';
require_once __DIR__.'/../database/db_connection.php';

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    header("Location: /Business/login_register/login_business.php");
}

// if(!isset($_GET['idpedido'])){
//     header("Location: /Business/dashboard_home_page.php");
// }

//$idPedido = $_GET['idpedido'];

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
    pedido.precototal as total
    FROM pedido_itens pi
    FULL JOIN itens 
    on itens.id_item=pi.id_item
    FULL JOIN pedidos pedido 
    on pedido.id_pedido=pi.id_pedido
    FULL JOIN clientes cl 
    on pedido.id_cliente = cl.id_cliente
    FULL JOIN pedido_item_opcoes pio
    on itens.id_item = pio.id_pedido_item
    where pedido.id_pedido = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    // $stmt->execute([$idPedido]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($stmt->rowCount() == 0) {
        exit("Pedido não encontrado");
    }

    $query = "SELECT *
	FROM public.pedido_itens
	inner join itens on itens.id_item=pedido_itens.id_item
	inner join pedidos on pedidos.id_pedido=pedido_itens.id_pedido
	where pedidos.id_pedido = 1;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $itens = $stmt->fetchAll();

    $item_arr = array();
    foreach($itens as &$item){
        array_push($item_arr,$item['nome']);
    }

    $descricao = implode(' + ',$item_arr);

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
        <div class="container">
            <div class="card shadow-sm py-1" style="margin: 0 auto;">
                <div class="container">
                    <div class="card-body">
                        <h3 class="card-title fw-bold"><?php echo 'Pedido #'.$pedido['id_pedido'].', '.$pedido['nome'] ?></h3>
                        <p><strong>Data e Hora:</strong> <?php echo $pedido['data'] ?></p>
                        <p><strong>Status do Pedido:</strong> <?php echo $pedido['estado'] ?></p>
                        <p><strong>Total: </strong><?php echo $pedido['total'] ?> €</p>
                    </div>

                    <div class="container mb-4">
                        <!-- grid caralho -->
                        <div class="grid gap-0 column-gap-3">
                            <!-- PRIMEIRO CARALHO -->
                            <div class="g-col-4 card p-0 rounded-3 shadow-sm">
                                <div class="card-header py-3">
                                    <h4 class="my-0 text-center  card-header-text">Menu Big King</h4>
                                </div>
                                <div class="card-body">
                                    <p class="card-title card-body-big-text pricing-card-title">5,99€</p>
                                    <p class="card-body-big-text"><?php echo htmlspecialchars($descricao) ?></p>
                                    
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
                            </div>

                            <!-- SEGUNDO CARALHO -->
                            <div class="g-col-4 card p-0 rounded-3 shadow-sm">
                                <div class="card-header py-3">
                                    <h4 class="my-0 card-header-text"><?php echo $pedido['nome_item'] ?></h4>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title card-body-big-text pricing-card-title">1,49€</h6>
                                    <h6><?php echo $pedido['nome_item'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="customer-info mb-4">
                        <p class="text-center">Dados do Cliente</p>
                        <p><strong>Nome:</strong><?php echo $pedido['nome'].' '.$pedido['apelido'] ?></p>
                        <p><strong>Telemóvel:</strong> <?php echo $pedido['telemovel'] ?></p>
                        <p><strong>Email:</strong> <?php echo $pedido['email'] ?></p>
                        <p><strong>Morada:</strong> <?php echo $pedido['morada'] ?>, <?php echo $pedido['codpostal'] ?>, <?php echo $pedido['cidade'] ?></p>
                    </div>

                    <div class="process-wrapper mb-3">
                        <div id="progress-bar-container">
                            <ul>
                                <li class="step step01 active">
                                    <div class="step-inner">PEDIDO EFETUADO</div>
                                </li>
                                <li class="step step02">
                                    <div class="step-inner">PREPARAÇÃO</div>
                                </li>
                                <li class="step step03">
                                    <div class="step-inner">VIAGEM ATÉ DESTINO</div>
                                </li>
                                <li class="step step04">
                                    <div class="step-inner">ENTREGUE</div>
                                </li>
                            </ul>
                            <div id="line">
                                <div id="line-progress"></div>
                            </div>
                        </div>
                        <div id="progress-content-section">
                            <div class="section-content efetuacao-pedido <?php $pedido['estado'] == 'EFETUADO' ? 'active' : '' ?>">
                                <h2>Efetuação do Pedido</h2>
                                <p>O pedido foi efetuado.</p>
                                <div class="d-flex justify-content-center mt-4 mb-4">
                                    <button class="btn btn-outline-warning btn-block" id="btn_comecar_preparar" style="color: #343a40;">Começar a Preparar</button>
                                </div>
                            </div>
                            <div class="section-content preparacao">
                                <h2>Preparação</h2>
                                <p>O pedido está em fase de preparação. Assim que o pedido estiver pronto para entrega dê-o ao seu entregador e carregue no botão abaixo para iniciar a fase entrega.</p>
                                <div class="d-flex justify-content-center mt-4 mb-4">
                                    <button class="btn btn-outline-warning btn-block" id="btn_pedido_pronto" style="color: #343a40;">Pedido Pronto</button>
                                </div>
                            </div>
                            <div class="section-content viagem">
                                <h2>Viagem até ao Destino</h2>
                                <p>O pedido está a caminho do seu cliente.</p>
                            </div>
                            <div class="section-content entregue">
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
        <script src="./assets/js/adicionar_pedido.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(".disabled");

            $(".step").click(function () {
                $(this).addClass("active").prevAll().addClass("active");
                $(this).nextAll().removeClass("active");
            });

            $(".step01").click(function () {
                $("#line-progress").css("width", "3%");
                $(".efetuacao-pedido").addClass("active").siblings().removeClass("active");
            });

            $(".step02, #btn_comecar_preparar").click(function () {
                $("#line-progress").css("width", "33%");
                $(".preparacao").addClass("active").siblings().removeClass("active");
                $(".step02").addClass("active");
            });

            $(".step03, #btn_pedido_pronto").click(function () {
                $("#line-progress").css("width", "66%");
                $(".viagem").addClass("active").siblings().removeClass("active");
                $(".step03").addClass("active");
            });

            $(".step04").click(function () {
                $("#line-progress").css("width", "100%");
                $(".entregue").addClass("active").siblings().removeClass("active");
            });
        </script>
    </body>
</html>
