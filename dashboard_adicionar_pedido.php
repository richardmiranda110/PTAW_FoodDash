<?php
session_start();

// Verificar se o usuário está logado
//if (!isset($_SESSION['username'])) {
//    header("Location: login.php");
//    exit();
//}

// Exibir nome de usuário
//echo "Welcome, " . $_SESSION['username'];
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
  <link rel="stylesheet" href="./assets/styles/responsive_styles.css">
  <link rel="stylesheet" href="./Business/assets/styles/adicionar.css">
  <script src="./assets/js/dable.js"></script>
</head>

<body>
  <!--Zona do Header -->
    <div id="topHeader" class="container-xxl">
        <!-- Top/Menu da Página -->
        <?php include __DIR__ . "/Business/includes/header_business.php"; ?>
        
    </div>

    <!--Zona de Conteudo -->
    <div id="contentPage" class="container-xxl">
	<?php include __DIR__ . "/Business/includes/sidebar_business.php"; ?>
 

    <!--Zona de Conteudo da Página -->
    <div id="contentDiv" class="col-md-12">

      

      <?php
      /*
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (!empty($_GET["idEmpresa"])) {
		$idestabelecimento[] = $_GET['idEmpresa'];
	};
	
	$idEmpresa = 1;
}
*/
      $idEmpresa = 1;
      ?>

      <div class="container mt-5">
        <h2 class="mb-4">Adicionar Novo Item</h2>

        <?php// include __DIR__ . "/includes/uploadFotosItens.php"; ?>

        <form action="" method="post" enctype="multipart/form-data" id="dataForm">
            <input type="hidden" id="idestabelecimento" name="idestabelecimento" value="<?php echo htmlspecialchars($idEmpresa); ?>">

            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control " id="nome" name="nome" placeholder="Nome do item" required>
            </div>

            <div class="mb-3">
              <label for="foto" class="form-label">Foto</label>
              <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
            </div>

            <div class="mb-3">
              <label for="descricaoForm1 " class="purple-text">Descrição</label>
              <div class="form-group w-100">
                <textarea placeholder="Introduza Descrição" class="form-control w-100" id="descricao" name="descricao" rows="3"></textarea>
              </div>
            </div>


            <?php
            require_once "./database/credentials.php";
            require_once "./database/db_connection.php";

            try {

              $stmt = $pdo->prepare("select id_categoria, nome from categorias where id_empresa = ? ");
              $stmt->execute([$idEmpresa]);
              $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "
      <div class='mb-3' id='categoria-container'>
        <p class='m fw-bold purple-text'>Categoria</p>
        <select class='mb-5 form-select' name='idcategoria' id='idcategoria'>";

              foreach ($stmt as $row) {
                echo     '<option value="' . htmlspecialchars($row['id_categoria']) . '">' . htmlspecialchars($row['nome']) . '</option>';
              }

              echo "</select>
      </div>";


  } catch(PDOException $e) {
    echo "Erro ao inserir registro: " . $e->getMessage();
  }
  ?>
      
    <div class="mb-3">
      <div id="menu-container">
        <p class=" fw-bold purple-text">Menu</p>
        <div class="w-25 mb-4" id="itemsozinho-form">
          <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="inlineRadio2" name="itemsozinho" value="true" >
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
      <p class=" fw-bold purple-text ">Personalizações</p>
      <div class="w-25" id="personalizacoes-ativas-form">
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="inlineRadio2" name="personalizacoesativas" value="true" >
        <label class="form-check-label" for="inlineCheckbox2">Sim</label>
        </div>
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="inlineRadio1" name="personalizacoesativas" value="false" checked>
        <label class="form-check-label" for="inlineCheckbox1">Não</label>
        </div>
      </div>
    </div>

    <div class="container" id="personalizations-section" style="display:none">
      <p class="fw-bold purple-text ">Personalizações</p>
      <div class="complement-header m-0">
      <p class="h5 m-0 fw-bold " id="item-name-label">Nome do Item</p>
      <button type="button" class="btn btn-custom modal_event" id="nova-personalizacao-btn">+ Nova Opção</button>
      </div>
      <hr class="m-0">
      <div class="option-list">
      <div id="costumization-dable" class="w-50"></div>
  </div>

      </div>
    </div>
    
    <div class="my-3 mt-5">
      <p class="fw-bold purple-text ">Artigo Disponível?</p>
      <div class="w-25 my-3">
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="inlineRadio2" name="disponivel" value="true" checked>
        <label class="form-check-label" for="inlineCheckbox2">Sim</label>
        </div>
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="inlineRadio1" name="disponivel" value="false" >
        <label class="form-check-label" for="inlineCheckbox1">Não</label>
        </div>
      </div>

      <div class="">
  </div>
      
    <div class="form-group row mb-3">
      <div class="col-sm-2">
        <label for="nome" class="form-label purple-text fw-bold">Preço</label>
        <input type="number" min="0" class="form-control" id="preco" name="preco" placeholder="Introduza um valor (€)" step="0.10" min="0" required>  
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary" id="submit-btn" style="width: 40%; margin: 2% 30%;">Adicionar Item</button>
  </div>

</form>
</div>  
<!-- Modal -->
<div id="modal" class="modal d-none">
  <div class="modal-content" id="modal-content">
    <span class="close">&times;</span>
    <p class="fw-bold mt-1 mb-2" id="modal-text"></p>
  </div>
</div>

  <!--Limpa conteudo Float -->
  <div class="cleanFloat"></div>

  <!--Zona do Footer -->
  <div class="container">
    <?php include __DIR__."/includes/footer_2.php"; ?>
  </div>
  
  
<script src="./assets/js/adicionar_pedido.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>