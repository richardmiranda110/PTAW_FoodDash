<?php
require_once __DIR__."/includes/session.php";
require_once __DIR__."/../database/credentials.php";
require_once __DIR__."/../database/db_connection.php";

$idEmpresa = $_SESSION['id_empresa'];

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ./login_register/login_business.php");
    exit();
}
$update = false;

// set_error_handler(function() {
//   exit("invalid item id!!");
// });


if(isset($_GET['itemid'])){
  $update = true;
  $query =  
  "SELECT id_item, item.nome, preco,
  descricao, disponivel, 
  foto, itemsozinho, 
  personalizacoesativas,
  c.nome as categoria, 
  c.id_categoria as id_categoria
  FROM public.itens item 
   JOIN categorias c 
  ON item.id_categoria = c.id_categoria
  where item.id_item = ? and item.id_empresa = ".$_SESSION['id_empresa']."";

  $stmt = $pdo->prepare($query);
  $stmt->execute([$_GET['itemid']]);
  $item = $stmt->fetch(PDO::FETCH_ASSOC);

  $type = trim('item');
  if( $item["personalizacoesativas"] ){
    $type = $type.'-personalizado';
  }

  if($type == "item-personalizado"){
    $query =  
    "SELECT opcao.id_opcao as id, opcao.nome as nome, opcao.max_quantidade , opcao.preco
    FROM public.opcoes opcao 
    INNER JOIN itens item ON opcao.id_item = item.id_item
	  where item.id_item = ? and item.id_empresa = ?";
  
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['itemid'],$_SESSION['id_empresa']]);
  
    $personalizacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  } else if(isset($_GET['menuid'])){
    $type = 'menu';
    $update = true;
    $query =  
    "SELECT id_menu, nome, preco,
    descricao, disponivel, foto
    FROM menus menu 
    where menu.id_menu = ? and menu.id_empresa = ?";
  
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['menuid'],$_SESSION['id_empresa']]);
  
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
  
      $query =  
      "SELECT item.*,categorias.nome as categoria
      FROM public.menus menu 
      INNER JOIN item_menus im 
      ON menu.id_menu = im.id_menu
      inner join itens item 
      on im.id_item = item.id_item
      inner join categorias
      on categorias.id_categoria = item.id_categoria
      where menu.id_menu = ? and menu.id_empresa = ?";
    
      $stmt = $pdo->prepare($query);
      $stmt->execute(
        [$_GET['menuid'],
        $_SESSION['id_empresa']
      ]);
    
      $menuitems = $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }

if(isset($item)){
  echo $item['id_categoria'];
  $final_item = array(
    "id" => (isset($item["id_item"]) ? $item["id_item"] : $item["id_menu"] ),
    "tipo" => $type,
    "idEmpresa" => $_SESSION['id_empresa'],
    "dados" => array(
      "disponivel" => $item["disponivel"],
      "nome" => $item["nome"],
      "categoria" =>  ($type == 'item' ?  $item['id_categoria'] : null ),
      "categoria_nome" =>  ($type == 'item' ? $item["categoria"] : null ),
      "preco" => $item["preco"],
      "descricao" => $item["descricao"],
      "foto" => $item["foto"],
      "personalizacoes" => (isset($personalizacoes) ? $personalizacoes : null),
      "menu_itens" =>(isset($menuitems) ? $menuitems : null)
    )
  );
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inserir Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles/sitecss.css">
  <link rel="icon" type="image/x-icon" href="../assets/stock_imgs/t_fd_logo_tab_business_icon.png">
  
  <link rel="stylesheet" href="../assets/styles/dashboard.css">
  <link rel="stylesheet" href="../assets/styles/responsive_styles.css">
  <link rel="stylesheet" href="./assets/styles/adicionar.css">
  <script src="../assets/js/dable.js"></script>
  <script>
    var idEmpresa = <?php echo $idEmpresa ?>;
    <?php
      echo 'var updateMode ='.($update ? 1: 0).';';
      echo 'var updateId ='.(isset($_GET['id']) ? $_GET['id'] : -1).';';
      if($update)
      echo 'var updateObject ='. json_encode($final_item).';';
    ?>
  </script>
</head>

<body class="d-flex flex-column min-vh-100">
  <header id="topHeader" class="container-xxl">
    <?php include __DIR__ . "/includes/header_business_logged.php"; ?>
  </header>

  <main id="contentPage" class="container-xxl flex-grow-1">
    <?php include __DIR__ . "/includes/sidebar_business.php"; ?>

    <div id="contentDiv" class="col-md-12">
      <div class="container mt-5">
        <h2 class="mb-4"><?php echo ($update ? 'Editar '.htmlspecialchars($type.' '.$final_item['dados']['nome']) :'Adicionar Novo Item'); ?></h2>
        <div class='alert alert-danger d-none' id="alert" role='alert'> O Ficheiro não é uma imagem.</div>
        <form action="" method="post" enctype="multipart/form-data" id="dataForm">
          <input type="hidden" id="idestabelecimento" name="idestabelecimento" value="<?php echo htmlspecialchars($idEmpresa);?>">

          <div class="mb-3 col-md-10">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control " id="nome" name="nome" value="<?php echo ($update ? htmlspecialchars($item['nome']) : "")?>" placeholder="Nome do item" required>
          </div>

          <div class="mb-3 col-md-10">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" file="" accept="image/*" <?php echo ($update ? "" : "required") ?>>
          </div>

          <div class="mb-3 col-md-10">
            <label for="descricaoForm1" class="purple-text">Descrição</label>
            <div class="form-group w-100">
              <textarea placeholder="Introduza Descrição" class="form-control w-100" id="descricao"  name="descricao" rows="3"><?php if($update) echo htmlspecialchars($item['descricao']) ?></textarea>
            </div>
          </div>

          <?php
          try {
            $stmt = $pdo->prepare("SELECT id_categoria, nome FROM categorias WHERE id_empresa = ?");
            $stmt->execute([$_SESSION['id_empresa']]);
            $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "
              <div class='mb-3 col-md-3' id='categoria-container'>
                <p class='fw-bold purple-text'>Categoria</p>
                <select class='mb-5 form-select' name='idcategoria' id='idcategoria'>";
            if(count($stmt) == 0){
              echo '<option value="null">Não existem opções disponíveis</option>';
            }

            if($update and (($type == 'item') or ($type == 'item') or ($type == 'item-personalizado'))){
              echo '<option value="' . htmlspecialchars($stmt['dados']['categoria']) . '">' . htmlspecialchars($item["categoria"]) . '</option>';
            }else{
              foreach ($stmt as $row) {
                echo '<option value="' . htmlspecialchars($row['id_categoria']) . '">' . htmlspecialchars($row['nome']) . '</option>';
              }
            }
            echo "</select>
              </div>";

          } catch(PDOException $e) {
            echo "Erro ao inserir registro: " . $e->getMessage();
          }
          ?>
      
          <div class="mb-3">
            <div id="menu-container">
              <p class="fw-bold purple-text">Menu</p>
              <div class="w-25 mb-4" id="itemsozinho-form">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="inlineRadio2" name="itemsozinho" value="true">
                  <label class="form-check-label" for="inlineCheckbox2">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="inlineRadio1" name="itemsozinho" value="false" checked>
                  <label class="form-check-label" for="inlineCheckbox1">Não</label>
                </div>
              </div>
            </div>
            <div class="container mb-5" style="display:none" id="complement-section">
              <p class="h5 fw-bold">Produtos</p>
              <button class="btn btn-custom text-left" id="btnNovoItemCategoria">+ Nova Categoria</button>
              <div class="complement-section" id="categoria-produtos-container">
              </div>
            </div>
    
            <div id="personalizacoes-container">
              <p class="fw-bold purple-text">Personalizações</p>
              <div class="w-25" id="personalizacoes-ativas-form">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="inlineRadio2" name="personalizacoesativas" value="true">
                  <label class="form-check-label" for="inlineCheckbox2">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" id="inlineRadio1" name="personalizacoesativas" value="false" checked>
                  <label class="form-check-label" for="inlineCheckbox1">Não</label>
                </div>
              </div>
            </div>
    
            <div class="container" id="personalizations-section" style="display:none">
              <p class="fw-bold purple-text">Personalizações</p>
              <div class="complement-header m-0">
                <p class="h5 m-0 fw-bold" id="item-name">Nome do Item</p>
                <button type="button" class="btn btn-custom modal_event" id="nova-personalizacao-btn">+ Nova Opção</button>
              </div>
              <hr class="m-0">
              <div class="option-list">
                <div id="costumization-dable" class="w-50"></div>
              </div>
            </div>
          </div>
    
          <div class="my-3 mt-5">
            <p class="fw-bold purple-text">Artigo Disponível?</p>
            <div class="w-25 my-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="disponivel" value="true" checked>
                <label class="form-check-label" for="inlineCheckbox2">Sim</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" name="disponivel" value="false">
                <label class="form-check-label" for="inlineCheckbox1">Não</label>
              </div>
            </div>

            <div class="form-group row mb-3">
              <div class="col-sm-2">
                <label for="nome" class="form-label purple-text fw-bold">Preço</label>
                <input type="number" min="0" class="form-control" id="preco" name="preco" value="<?php echo $update ? htmlspecialchars($item['preco']) : ""?>" placeholder="Introduza um valor (€)" step="0.10" required>
              </div>
            </div>
          </div>
    
          <button type="submit" class="btn btn-primary" id="submit-btn" style="width: 40%; margin: 2% 30%;"><?php echo $update ?'Actualizar Item':'Adicionar Item' ?></button>
        </form>
      </div>  

      <div id="modal" class="modal d-none w-50 justify-content-center" style="margin-left:25%">
        <div class="modal-content" id="modal-content">
          <span class="close">&times;</span>
          <p class="fw-bold mt-1 mb-2" id="modal-text"></p>
        </div>
      </div>
    </div>
  </main>

  <footer class="container">
    <?php include "./includes/footer_business_2.php"; ?>
  </footer>

  <script src="./assets/js/inserir_item.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
