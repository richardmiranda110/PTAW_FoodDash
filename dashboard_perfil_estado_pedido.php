<?php
require_once './session.php';
require_once './database/credentials.php';
require_once './database/db_connection.php';

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
  $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
  header("Location: ./index.php");
  exit();
}

$PEDIDO_ID = $_GET['id'];

$query = "SELECT clientes.morada as morada,clientes.nome as cliente,pedido.id_pedido as id, pedido.data as data, pedido.estado as estado, pedido.cancelado, pedido.precototal, pedido.id_cliente as id_cliente, pedido.id_entregador, id_estabelecimento
FROM pedidos pedido 
FULL JOIN pedido_itens pi on pedido.id_pedido = pi.id_pedido 
INNER JOIN CLIENTES ON pedido.ID_CLIENTE = CLIENTES.ID_CLIENTE
WHERE pedido.id_pedido = ? and pedido.id_cliente = ?;";

try {
$stmt = $pdo->prepare($query);
$stmt->execute([$PEDIDO_ID,$_SESSION['id_cliente']]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
echo "Erro na conexão: " . $e->getMessage();
}

$query = "SELECT item.nome as nome,pi.quantidade as qtd, pedido.id_cliente as id_cliente
FROM public.pedido_itens 
inner join itens item on pedido_itens.id_item = item.id_item
inner join pedidos pedido on pedido.id_pedido = pedido_itens.id_pedido 
INNER JOIN pedido_itens pi on pedido.id_pedido = pi.id_pedido
WHERE pedido.id_pedido = ? and pedido.id_cliente = ?";

try {
$stmts = $pdo->prepare($query);
$stmt->execute([$PEDIDO_ID,$_SESSION['id_cliente']]);
$items = $stmts->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
echo "Erro na conexão: " . $e->getMessage();
}

$item_arr = array();

if($stmt->rowCount() == 0){
  exit("not found!");
}

foreach($items as &$item){
  $result = $item['nome'].' ('.$item['qtd'].'x)';
  array_push($item_arr,$result);
}

$result = implode(' + ',$item_arr);

// echo $pedido['id_cliente'];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles/sitecss.css">
	<link rel="stylesheet" href="./assets/styles/dashboard.css">
  <link rel="stylesheet" href="./Business/assets/styles/pedido_page.css" />

  </head>
  <body>
  <!--Zona do Header -->
  <div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include "includes/header_logged_in.php"; ?>

  </div>

  <!--Zona de Conteudo -->
  <div id="contentPage" class="container-xxl">
  <?php include "includes/sidebar_perfil.php"; ?>

    <!--Zona de Conteudo da Página -->
    <div id="contentDiv" class="col-md-10">
      <div class="container ps-3 py-3  mt-0 pt-0" style="min-height: 77vh;">

        <div class="container pt-0 mt-0">
                <div class="row border my-3 mt-0 py-2 ">
                  <div class="col-sm-1 fs-1 ">
                  <a href="dashboard_perfil_pedidos.php">
                      <i style="cursor:pointer;" class="bi bi-arrow-left-short border border-2 rounded bg-light"></i>
                  </a>
                  </div>
                  <div class=" rounded-left rounded-right align-self-center py-2 fs-6" style="margin-left:3vw">
                      <p class="title display-6 fw-bold"><span><?php echo 'Pedido #'.$pedido['id'].', '.$pedido['cliente']?></span> em <span>
                        <?php
                                      $time = strtotime($pedido['data']);
                                      $date = date('j F',$time);
                                      $time = date('g:i',$time);  
                        echo $date.' ás '. $time;
                        ?></span></p>
                      <p class="text"><?php echo $result ?></p>
                      <p class="text">Status do pedido: <span><?php echo $pedido['estado'] ?></span></p>
                      <p class="text">Morada: <span><?php echo $pedido['morada'] ?></span></p>
                      <p class="text">Preço: <span><?php echo $pedido['precototal'] ?></span>€</p>
                  </div>  
                  <div class="container mt-5 mx-4 px-5 ">
                    <div class="d-flex justify-content-center align-items-center">

                <div class="process-wrapper mb-3 w-100">
                    <div id="progress-bar-container">
                        <ul>
                            <li class="step step01">
                                <div class="step-inner>">PEDIDO EFETUADO</div>
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
                            <div id="line-progress" style="width:<?php echo $width ?>;"></div>
                        </div>
                    </div>
                    <div id="progress-content-section">
                        <div class="section-content efetuacao-pedido">
                            <h2>Efetuação do Pedido</h2>
                            <p>O pedido foi efetuado.</p>
                        </div>
                        <div class="section-content preparacao">
                            <h2>Preparação</h2>
                            <p>O pedido está em fase de preparação. Assim que o pedido estiver pronto para entrega dê-o ao seu entregador e carregue no botão abaixo para iniciar a fase entrega.</p>
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

  <!--Limpa conteudo Float -->
  <div class="cleanFloat"></div>

  <!--Zona do Footer -->
  <div class="container">
    <?php include __DIR__."/includes/footer_2.php"; ?>
  </div>

  <script>
    let eSource = new EventSource("./seguir_pedido.php?id=<?php echo $PEDIDO_ID ?>");
    let lastState = "";
    const lineprogress = document.querySelector("#line-progress");

    const step1 = document.querySelector(".step01");
    const efetuacao = document.querySelector(".efetuacao-pedido ");

    const step2 = document.querySelector(".step02");
    const preparacao = document.querySelector(".preparacao");

    const step3 = document.querySelector(".step03");
    const viagem = document.querySelector(".viagem");

    const step4 = document.querySelector(".step04");
    const entregue = document.querySelector(".entregue");

    eSource.onmessage = function(e) {
      if(e.data != lastState.data){
        stateChanged(e.data);
      }
      lastState = e;
    };

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
                        alert("erro inesperado!");
                        eSource.close()
                }
    }

  </script>

  </body>
</html>


