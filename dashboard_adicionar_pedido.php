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
    <link rel="stylesheet" href="assets/styles/sitecss.css">
	<link rel="stylesheet" href="assets/styles/dashboard.css">
  <script src="./assets/js/dable.js"></script>
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

    <nav style="font-size:1.4rem; z-index: 1;" class="navbar navbar-expand-lg gray-navbar navbar-light ">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link nav" href="#">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav" href="#">Menus</a>
            </li>
            <li class="nav-item"> <!-- não me digas nada sobre o style, o css não gosta dele -->
                <a class="nav-link nav " href="#">Categorias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav" style="border-bottom: 1vh solid black;" href="#">Itens</a>
            </li>
        </ul>
  </div>
  </nav>
    
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
	  
	  <?php include __DIR__."/includes/uploadFotosItens.php"; ?>
	  
    <form action="" method="post" enctype="multipart/form-data" id="dataForm">
      <input type="hidden" id="idestabelecimento" name="idestabelecimento" value="<?php echo htmlspecialchars($idEmpresa); ?>">

          <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do item" required>
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
      
      <div class="mb-3">
            <label for="nome" class="form-label">Preço</label>
            <input type="number" class="form-control" id="preco" name="preco" placeholder="Digite um número" step="0.01" required>
          </div>
		
<?php
require_once "database/credentials.php";
require_once "database/db_connection.php";

try {

	$stmt = $pdo->prepare("select id_categoria, nome from categorias where id_empresa = ? ");
	$stmt->execute([$idEmpresa]);
	$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo "
		<div class='mb-3'>
			<p class='m fw-bold purple-text '>Categoria</p>
			<select class='mb-5 form-select' name='idcategoria' id='idcategoria'>
				<option value=''>Selecione Categoria</option>";

	foreach ($stmt as $row) {
	  echo 		'<option value="' . htmlspecialchars($row['id_categoria']) . '">' . htmlspecialchars($row['nome']) . '</option>';
	}

	echo "</select>
		</div>";


} catch(PDOException $e) {
	echo "Erro ao inserir registro: " . $e->getMessage();
}
?>
		
	<div class="mb-3">
		<p class=" fw-bold purple-text">Vende-se Item Sozinho?</p>
		<div class="w-25 mb-4" id="itemsozinho-form">
			<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="inlineRadio2" name="itemsozinho" value="false" >
			<label class="form-check-label" for="inlineCheckbox2">Sim</label>
			</div>
			<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="inlineRadio1" name="itemsozinho" value="true" checked>
			<label class="form-check-label" for="inlineCheckbox1">Não</label>
			</div>
		</div>

		<div class="container mb-5" id="complement-section">
      <p class="h5 fw-bold">Complemento</p>
      <button class="btn btn-custom text-left" id="novoComplementoBtn">+ Novo Complemento</button>
			<div class="complement-section">
				<div class="complement-header mb-0">
					<p class="fw-bold m-0">Bebida</p>
					<button class="btn btn-custom modal_event" style="margin-left: auto;" id="add-drink-btn">+ Nova Opção</button>
          <span style="margin-left: 0.5vw;margin-right:0.5vw"> ou </span>
          <button class="btn btn-custom" id="import-drink-btn">Importar Existente</button>
				</div>
				<hr class="mt-0">
        <div id="add-drink-dable-container"></div>
    </div>

    <div class="complement-section">
      <div class="complement-header mb-0">
        <p class="fw-bold m-0">Acompanhamento</p>
        <button class="btn btn-custom modal_event" style="margin-left: auto;" id="add-acompanhamento-btn">+ Nova Opção</button>
        <span style="margin-left: 0.5vw;margin-right:0.5vw"> ou </span>
        <button class="btn btn-custom">Importar Existente</button>
      </div>

      <hr class="mt-0">
      <div id="add-personalization-dable-container"></div>

    </div>
  </div>
	
	<div>
		<p class="m fw-bold purple-text ">Personalizações Ativas?</p>
		<div class="w-25" id="personalizacoes-ativas-form">
			<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="inlineRadio2" name="personalizacoesativas" value="true" checked>
			<label class="form-check-label" for="inlineCheckbox2">Sim</label>
			</div>
			<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="inlineRadio1" name="personalizacoesativas" value="false" >
			<label class="form-check-label" for="inlineCheckbox1">Não</label>
			</div>
		</div>
	</div>

	<div class="container" id="personalizations-section">
    <p class="fw-bold purple-text ">Personalizações</p>
    <div class="section-title">
    <p class="h5 fw-bold ">Hamburguer</p>
    </div>
    <button type="button" class="btn btn-custom modal_event" id="nova-personalizacao-btn">+ Nova Opção</button>
    <hr>
    <div class="option-list">
      <div class="option-row">
        <span>Queijo</span>
        <div class="option-actions">
          <button type="button" class="btn btn-light btn-sm">✕</button>
          <span class="mr-2">Max.:</span>
          <input type="number" min="0" class="form-control form-control-sm" style="width: 50px;">
        </div>
      </div>
      <div class="option-row">
        <span>Cebola</span>
        <div class="option-actions">
          <button type="button" class="btn btn-light btn-sm">✕</button>
          <span class="mr-2">Max.:</span>
          <input type="number" min="0" class="form-control form-control-sm" style="width: 50px;">
        </div>
      </div>
      <div class="option-row">
        <span>Picles</span>
        <div class="option-actions">
          <button type="button" class="btn btn-light btn-sm">✕</button>
          <span class="mr-2">Max.:</span>
          <input type="number"  min="0" class="form-control form-control-sm" style="width: 50px;">
        </div>
      </div>
      <div class="option-row">
        <span>Molho</span>
        <div class="option-actions">
          <button type="button" class="btn btn-light btn-sm">✕</button>
          <span class="mr-2">Max.:</span>
          <input type="number" min="0" class="form-control form-control-sm" style="width: 50px;">
        </div>
      </div>
    </div>
  </div>
	
	<div class="my-3">
		<p class="fw-bold purple-text ">Artigo Disponível?</p>
		<div class="w-25 mb-5">
			<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="inlineRadio2" name="disponivel" value="true" checked>
			<label class="form-check-label" for="inlineCheckbox2">Sim</label>
			</div>
			<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="inlineRadio1" name="disponivel" value="false" >
			<label class="form-check-label" for="inlineCheckbox1">Não</label>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-primary" style="width: 40%; margin: 2% 30%;">Adicionar Item</button>
</div>
</form>
  
<!-- Modal -->
<div id="modal" class="modal d-none">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p class="fw-bold mt-1 mb-2" id="modal-text">a culpa é do richard</p>
    <input type="text" id="novoItemInput" placeholder="Digite o novo item">
    <button id="adicionarBtn">Adicionar</button>
  </div>
</div>

  <!--Zona do Footer -->
  <?php include __DIR__."/includes/footer_2.php"; ?>

  <script src="./assets/js/adicionar_pedido.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


