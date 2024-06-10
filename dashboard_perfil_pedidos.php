<?php
require_once __DIR__.'/database/credentials.php';
require_once __DIR__.'/database/db_connection.php';
require_once __DIR__.'/session.php';

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
  header("Location: /dashboard.php");
  exit();
}

$query = 
  "SELECT distinct pedido.data as data,
  pedido.id_pedido as id,
  cliente.nome as cliente,
  pedido.estado as status,
  pedido.precototal as preco,
  emp.nome as empresa
  FROM public.pedido_itens 
  INNER JOIN itens item on pedido_itens.id_item = item.id_item
  LEFT JOIN pedidos pedido on pedido.id_pedido = pedido_itens.id_pedido 
  INNER JOIN empresas emp on pedido.id_empresa = emp.id_empresa
  INNER JOIN clientes cliente ON pedido.ID_CLIENTE = cliente.id_cliente
  where pedido.id_cliente = ?;";

try {
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['id_cliente']]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
echo "Erro na conexão: " . $e->getMessage();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash - Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="./assets/styles/sitecss.css">
	<link rel="stylesheet" href="./assets/styles/dashboard.css">
  <link rel="icon" type="image/x-icon" href="./assets/stock_imgs/t_fd_logo_tab_icon.png">
  </head>
  <body>
  <!--Zona do Header -->
  <div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include __DIR__."/includes/header_logged_in.php"; ?>

  </div>

  <!--Zona de Conteudo -->  
  <div id="contentPage" class="container-xxl">
    <?php include __DIR__."/includes/sidebar_perfil.php"; ?>

    <!--Zona de Conteudo da Página -->
    <div id="contentDiv" class="col-md-12">
      <div class="container ps-3 py-3">
        <div class="row">
          <h1 class="title">Pedidos</h1>
              <p>Esta é a tua página de pedidos. Aqui podes ver o teu histórico de pedidos feitos, ver o estado dos pedidos, etc.</p>
          </div>
          <div class="container ">
            <?php
            if(count($pedidos) == 0)
              echo "Nenhum pedido registado!";

            foreach($pedidos as &$pedido){
              if($pedido['id_cliente'] != $_SESSION['id_cliente']){
                header("Location: /index.php");
              }
              
              $time = strtotime($pedido['data']);
              $date = date('j F',$time);
              $time = date('g:i',$time); 

              echo'
                <div id="ticket-info" class="row border border-2 border-secondary rounded my-3">
                  <div class="col-sm-1 text-center align-self-center py-2 fs-6 "><span>'.$time.'</span><br><span>'.$date.'</span></div>
                    <div class="col-sm-5 rounded-left rounded-right align-self-center py-2 px-5 fs-6">
                        <strong>Pedido #'.$pedido['id'].', '.$pedido['cliente'].'</span> em <span></strong>'.$pedido['empresa'].'<br>
                        <small></small>
                    </div>
                  <div class="col-sm-4 align-self-center py-2">
                        <span><strong>Status do pedido:</strong> '.$pedido['status'].'</span></small>
                  </div>
                  <div class="col-sm-1 text-center align-self-center fs-4 py-4 "><strong>'.$pedido['preco'].' €</strong></div>
                    <div class="col-sm-1 align-self-center text-center h-60">
                      <a href="dashboard_perfil_estado_pedido.php?id='.$pedido['id'].'">
                        <i class="bi bi-eye"></i>
                      </a>
                    </div>
                  </div>';
            };
            ?>  
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