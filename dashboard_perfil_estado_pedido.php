<?php
require_once __DIR__.'/session.php';
require_once __DIR__.'/database/credentials.php';
require_once __DIR__.'/database/db_connection.php';

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
  header("Location: /index.php");
  exit();
}

$PEDIDO_ID = $_GET['id'];

$query = "SELECT clientes.morada as morada,clientes.nome as cliente,pedido.id_pedido as id, pedido.data as data, pedido.estado as estado, pedido.cancelado, pedido.precototal, pedido.id_cliente, pedido.id_entregador, id_estabelecimento
FROM pedidos pedido 
INNER JOIN pedido_itens pi on pedido.id_pedido = pi.id_pedido 
INNER JOIN CLIENTES ON pedido.ID_CLIENTE = CLIENTES.ID_CLIENTE
WHERE pedido.id_pedido = ?;";

try {
$stmt = $pdo->prepare($query);
$stmt->execute([$PEDIDO_ID]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
echo "Erro na conexão: " . $e->getMessage();
}

$query = "SELECT item.nome as nome,pi.quantidade as qtd
FROM public.pedido_itens 
inner join itens item on pedido_itens.id_item = item.id_item
inner join pedidos pedido on pedido.id_pedido = pedido_itens.id_pedido 
INNER JOIN pedido_itens pi on pedido.id_pedido = pi.id_pedido
WHERE pedido.id_pedido = ?";

try {
$stmts = $pdo->prepare($query);
$stmt->execute([$PEDIDO_ID]);
$stmts->execute();
$items = $stmts->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
echo "Erro na conexão: " . $e->getMessage();
}
$item_arr = array();

foreach($items as &$item){
  $result = $item['nome'].' ('.$item['qtd'].'x)';
  array_push($item_arr,$result);
}

$result = implode(' + ',$item_arr);

echo $result;

if($pedido['id_cliente'] != $_SESSION['id_cliente']){
  header("Location: /index.php");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/sitecss.css">
	<link rel="stylesheet" href="assets/styles/dashboard.css">

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
      <div class="container ps-3 py-3">
        <div class="row">
        <h1 class="text title">Pedidos</h1>
            <p class="text subtitle">Esta é a tua página de pedidos. Aqui podes ver o teu histórico de pedidos feitos, ver o estado dos pedidos, etc.</p>
        </div>
        <div class="container ">
                <div class="row border my-3 py-2">
                  <div class="col-sm-1 fs-1 ">
                  <a href="dashboard_perfil_pedidos.php">
                      <i style="cursor:pointer;" class="bi bi-arrow-left-short border border-2 rounded bg-light"></i>
                  </a>
                  </div>
                  <div class=" rounded-left rounded-right align-self-center py-2 fs-6" style="margin-left:3vw">
                      <p class="title display-6 fw-bold"><span><?php echo 'Pedido #'.$pedido['id'].', '.$pedido['cliente']?></span> em <span><?php echo $pedido['data'] ?></span></p>
                      <p class="text"><?php echo $result ?></p>
                      <p class="text">Status do pedido: <span><?php echo $pedido['estado'] ?></span></p>
                      <p class="text">Morada: <span><?php echo $pedido['morada'] ?></span></p>
                      <p class="text">Preço: <span><?php echo $pedido['precototal'] ?></span>€</p>
                  </div>  
                  <div class="container mt-5 mx-4 px-5 ">
                    <div class="d-flex justify-content-center align-items-center">

                        <div class="circle ">1</div>
                        <div class="line flex-grow-1 <?php echo (($pedido['estado'] == 'EFETUADO') == 1 ? "gradient-line" : "") ?>"></div>
                        <div class="circle <?php echo (($pedido['estado'] == 'EFETUADO') == 1 ? "black-circle text-light" : "") ?>" >2</div>
                        <div class="line flex-grow-1 <?php echo ($pedido['estado'] == 'EM PREPARACAO' ? " gradient-line" : "") ?>"></div>
                        <div class="circle <?php echo ($pedido['estado'] == 'EM PREPARACAO' ? "black-circle" : "") ?>">3</div>
                        <div class="line flex-grow-1 <?php echo ($pedido['estado'] == 'A CAMINHO' ? " gradient-line" : "") ?>"></div>
                        <div class="circle <?php echo ($pedido['estado'] == 'A CAMINHO' ? "black-circle text-light" : "") ?>">4</div>
                        <div class="line flex-grow-1 <?php echo ($pedido['estado'] == 'FINALIZADO' ? " gradient-line" : "") ?>"></div>
                        <div style="margin-right:5vw;" class="circle <?php echo ($pedido['estado'] == 'FINALIZADO' ? "black-circle text-light" : "") ?>">5</div>
                    </div>
                    <div class="d-flex justify-content-left align-items-left mb-4">
                      <div class="roadmap-item ten-percent-to-left align-items-top text-center"><span>Efetuação<br> do Pedido</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div class="roadmap-item align-items-top text-center"><span>Recebimento<br> do Pedido</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div class="roadmap-item ten-percent-to-left align-items-top text-center"><span>Em Preparação</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div class="roadmap-item ten-percent-to-left align-items-top text-center"><span>Viagem Até<br> Sua Casa</span></div>
                      <div class="roadmap-item flex-grow-1"></div>
                      <div style="margin-right:5vw;" class="roadmap-item ten-percent-to-right align-items-top text-center"><span>Entregue</span></div>
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

  </body>
</html>


