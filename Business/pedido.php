<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/../database/credentials.php';
require_once __DIR__ . '/../database/db_connection.php';

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: /Business/login_register/login_business.php");
}

if(!isset($_GET['id_pedido'])){
    header("Location: /Business/dashboard_home_page.php");
}

$idPedido = $_GET['id_pedido'];
$idEmpresa = $_SESSION['id_empresa'];

// Cliente
try {
  $queryCliente =
  "SELECT cl.nome as nome, cl.apelido as apelido,
  cl.email as email , cl.telemovel as telemovel,
  cl.morada as morada, cl.cidade as cidade,
  cl.codpostal as codpostal
  FROM clientes cl
  FULL JOIN pedidos pedido 
  on pedido.id_cliente = cl.id_cliente
  where pedido.id_pedido = ? and pedido.id_empresa = ? ";
$stmt = $pdo->prepare($queryCliente);
$stmt->execute([$idPedido,$idEmpresa]);

if ($stmt->rowCount() == 0) {
  exit("cliente não encontrado ou invalido");
}

$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

// Pedido
    $sql ="SELECT
        pedido.id_pedido as id_pedido,
        pedido.data as data, pedido.estado as estado,
        pedido.precototal as total,pedido.id_pedido as id_pedido
        FROM pedidos pedido
    where pedido.id_pedido = ? and pedido.id_empresa = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idPedido,$idEmpresa]);

    if ($stmt->rowCount() == 0) {
        exit("Pedido não encontrado ou invalido");
    }

    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

// Itens

    $query =
        "SELECT distinct pi.id_pedido_item,id_menu,
        item.nome as item_nome, item.preco as item_preco,         
        personalizacoesativas, pi.quantidade as item_quantidade     
        FROM pedido_itens pi
        inner join itens item on item.id_item=pi.id_item
        inner join pedidos pedido on pedido.id_pedido=pi.id_pedido
        left join pedido_item_opcoes pio on pio.id_pedido_item = pi.id_pedido_item
        where pedido.id_pedido = ? and pedido.id_empresa = ? and pi.id_menu is null;";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$idPedido,$idEmpresa]);
    $itens = $stmt->fetchAll();

    // Item Array
    $item_arr = array();

    foreach ($itens as &$item) {
        array_push($item_arr, $item['item_nome']);
    }

    $menusInOrder = "SELECT distinct pi.id_menu,menus.nome,menus.preco FROM pedido_itens pi
    	inner join menus on menus.id_menu = pi.id_menu
        inner join pedidos pedido on pedido.id_pedido = pi.id_pedido
        where pedido.id_pedido = ? and pedido.id_empresa = ?";

    $stmt = $pdo->prepare($menusInOrder);
    $stmt->execute([$idPedido,$idEmpresa]);
    $menusIdInOrder = $stmt->fetchAll();

    $descricao = implode(' + ', $item_arr);

} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
function getItemOptions($id_pedido_item){
    global $pdo;

    $optionsQuery = "SELECT opcao.nome, pio.quantidade,menu.preco                                   -- opcao de cada item do pedido
    FROM pedido_itens pi
    inner join itens item on item.id_item=pi.id_item
    inner join menus menu on pi.id_menu = menu.id_menu
    inner join pedidos pedido on pedido.id_pedido=pi.id_pedido
    full join pedido_item_opcoes pio on pio.id_pedido_item = pi.id_pedido_item
    inner join opcoes opcao on pio.id_opcao=opcao.id_opcao
    where pi.id_pedido_item = ?;";

    $stmt = $pdo->prepare($optionsQuery);
    $stmt->execute([$id_pedido_item]);
    return $stmt->fetchAll();
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
    <link rel="icon" type="image/x-icon" href="../assets/stock_imgs/t_fd_logo_tab_business_icon.png">
    <link rel="stylesheet" href="./assets/styles/adicionar.css" />
    <link rel="stylesheet" href="../assets/styles/sitecss.css" />
    <link rel="stylesheet" href="../assets/styles/dashboard.css" />
    <link rel="stylesheet" href="./assets/styles/pedido_page.css" />
    <link rel="stylesheet" href="../assets/styles/sitecss.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link rel="stylesheet" href="../assets/styles/responsive_styles.css">
    <style>
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
    <div class="container" style="margin-top: 10vh;">
        <div class="card shadow-sm py-1" style="width: 115vh !important;max-width:100vw;margin: 0 auto;">
            <div class="container">
                <div class="card-body">
                    <h3 class="card-title fw-bold"><?php echo 'Pedido #' . $pedido['id_pedido'] . ', ' . $cliente['nome'] ?></h3>
                    <p><strong>Data e Hora:</strong> <?php
                                  $time = strtotime($pedido['data']);
                                  $date = date('j F',$time);
                                  $time = date('g:i',$time); 
                    echo $date.' ás '.$time?></p>
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
                        foreach($menusIdInOrder as &$menuInOrder){
                            echo '
                            <div class="g-col-4 card p-0 rounded-3 shadow-sm mb-2">
                                <div class="card-header py-3">
                                    <p class=" h4 my-0 card-header-text">' . $menuInOrder['nome'] . '</p>
                                </div>';

                            $Menuquery =
                            "SELECT distinct pi.id_pedido_item,
                            item.nome as item_nome, item.preco as item_preco,         
                            personalizacoesativas, pi.quantidade as item_quantidade     
                            FROM pedido_itens pi
                            inner join itens item on item.id_item=pi.id_item
                            inner join pedidos pedido on pedido.id_pedido=pi.id_pedido
                            left join pedido_item_opcoes pio on pio.id_pedido_item = pi.id_pedido_item
                            where pedido.id_pedido = ? and pedido.id_empresa = ? and id_menu = ?;";
                            
                            echo  '<div class="card-body"> <p class=" h6 card-title card-body-big-text pricing-card-title">' . $menuInOrder['preco'] . ' €</p></div>';
                        
                            $stmt = $pdo->prepare($Menuquery);
                            $stmt->execute([$idPedido,$idEmpresa,$menuInOrder['id_menu']]);
                            $menus = $stmt->fetchAll();

                            foreach ($menus as &$menu) {
                                        echo '<div class="card-body">
                                            <p class="h6">' . $menu['item_nome'] . '</h6>';

                                if ($menu['personalizacoesativas']) {
                                    echo
                                    '<div class="div_personalizacoes mr-2">
                                        <p class="h5 card-body-huge-text">Personalizações:</p>';

                                    $options = getItemOptions($menu['id_pedido_item']);
                                    echo '
                                        <div>
                                            <p class="h6 card-body-text" style="margin-bottom: 0.5vh;">' . $menu['item_nome'] . '</p>
                                            <ul style="margin: 0;">';
                                    foreach ($options as &$option) {
                                        // if ($option['quantidade'] == 0)
                                            echo ' <li class="card-body-small-text" style="padding: 0.2vh">' . ($option['quantidade'] == 0 ? 'Sem ' : 'Com ') . $option['nome'] . '</li>';
                                    }
                                    echo '</ul>
                                        </div>';
                                }
                                echo  '</div></div>';
                            } 
                        }

                        foreach ($itens as &$item) {
                            /*
                            -- item_nome, item_preco,
                            -- item_disponivel, item_foto
                            -- personalizacoesativas, id_item_no_pedido
                            -- id_item_no_pedido, item_id
                            -- id_pedido_item_opcao
                            -- opcao_no_item_pedido
                            -- opcao de cada item do pedido
                            */
                            echo '
                                <div class="g-col-4 card p-0 rounded-3 shadow-sm">
                                    <div class="card-header py-3">
                                        <p class=" h4 my-0 card-header-text">' . $item['item_nome'] . '</p>
                                    </div>
                                    <div class="card-body">
                                        <p class=" h6 card-title card-body-big-text pricing-card-title">' . $item['item_preco'] . ' €</p>
                                        <p class="h6">' . $item['item_nome'] . '</h6>';
                                        // echo var_dump($item);
                            if ($item['personalizacoesativas']) {
                                echo
                                '<div class="div_personalizacoes mr-2">
                                    <p class="h5 card-body-huge-text">Personalizações:</p>';
 {
                                    $options = getItemOptions($item['id_pedido_item']);
                                    echo '
                                        <div>
                                            <p class="h6 card-body-text" style="margin-bottom: 0.5vh;">' . $item['item_nome'] . '</p>
                                            <ul style="margin: 0;">';
                                    foreach ($options as &$option) {
                                        // if ($option['quantidade'] == 0)
                                            echo ' <li class="card-body-small-text" style="padding: 0.2vh">' . ($option['quantidade'] == 0 ? 'Sem ' : 'Com ') . $option['nome'] . '</li>';
                                    }
                                    echo '</ul>
                                        </div>';
                                }
                                echo '</div>';
                            }
                            echo  '</div></div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="customer-info mb-4">
                    <p class="text-center">Dados do Cliente</p>
                    <p><strong>Nome:</strong><?php echo $cliente['nome'] . ' ' . $cliente['apelido'] ?></p>
                    <p><strong>Telemóvel:</strong> <?php echo $cliente['telemovel'] ?></p>
                    <p><strong>Email:</strong> <?php echo $cliente['email'] ?></p>
                    <p><strong>Morada:</strong> <?php echo $cliente['morada'] ?>, <?php echo $cliente['codpostal'] ?>, <?php echo $cliente['cidade'] ?></p>
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
                    case 'FINALIZADO':
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
                            <?php
                             $query = "SELECT id_entregador, nome, veiculo FROM Entregadores WHERE disponivel = TRUE";
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
                            echo '</select>';
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
    <?php include "./includes/footer_business_2.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        const status = document.querySelector("#status");

const lineprogress = document.querySelector("#line-progress");

const step1 = document.querySelector(".step01");
const efetuacao = document.querySelector(".efetuacao-pedido ");

const step2 = document.querySelector(".step02");
const preparacao = document.querySelector(".preparacao");

const step3 = document.querySelector(".step03");
const viagem = document.querySelector(".viagem");

const step4 = document.querySelector(".step04");
const entregue = document.querySelector(".entregue");

let lastState = "";
setInterval(async () => 
  await fetch(`../seguir_pedido.php?id=<?php echo $idPedido ?>`)
  .then(answer => answer.json())
  .then(reply => {
    if(reply != lastState){
      stateChanged(reply.message);
    }

    lastState = reply.message;
  })
, "1000");


function stateChanged(newState){
  console.log("new state: "+newState);
  changeState(newState);
}

function changeState(newState)
{
  switch (newState) {
                case 'EFETUADO':
                    
                    step1.classList.add('active');
                    step2.classList.remove('active');
                    step3.classList.remove('active');
                    step4.classList.remove('active');
                    lineprogress.style.width = '3%';
            
                    efetuacao.classList.add('active')
                    preparacao.classList.remove('active')
                    viagem.classList.remove('active')
                    entregue.classList.remove('active')
                    break;
                case 'EM PREPARACAO':
                    step1.classList.add('active');
                    step2.classList.add('active');
                    step3.classList.remove('active');
                    step4.classList.remove('active');
                    lineprogress.style.width = '33%';
            
                    efetuacao.classList.remove('active')
                    preparacao.classList.add('active')
                    viagem.classList.remove('active')
                    entregue.classList.remove('active')
                    break;
                case 'A CAMINHO':
                    step1.classList.add('active');
                    step2.classList.add('active');
                    step3.classList.add('active');
                    step4.classList.remove('active');
                    lineprogress.style.width = '66%';
                    efetuacao.classList.remove('active')
                    preparacao.classList.remove('active')
                    viagem.classList.add('active')
                    entregue.classList.remove('active')
                    break;
                case 'FINALIZADO':
                case 'ENTREGUE':
                    step1.classList.add('active');
                    step2.classList.add('active');
                    step3.classList.add('active');
                    step4.classList.add('active');
                    lineprogress.style.width = '100%';
                    efetuacao.classList.remove('active')
                    preparacao.classList.remove('active')
                    viagem.classList.remove('active')
                    entregue.classList.add('active')
                    break;
                default:
                    console.log(newState);
                    alert("erro inesperado!");
            }
}


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
                url: "./pedidos.php?id=<?php echo $pedido['id_pedido'] ?>&stage=2",
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
            const deliveryman = parseInt(document.querySelector("#entregadores").options[document.querySelector("#entregadores").selectedIndex].value);
            $.ajax({
                url: "./pedidos.php?id=<?php echo $pedido['id_pedido'] ?>&stage=3&deliveryman="+deliveryman,
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
                url: "./pedidos.php?id=<?php echo $pedido['id_pedido'] ?>&stage=4",
                success: function(result) {
                    console.log(result);
                }
            });
        });
    </script>
</body>
</html>