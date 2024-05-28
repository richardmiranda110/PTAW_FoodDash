<!DOCTYPE html>
<html lang="pt">
<?php require_once __DIR__.'/session.php'; ?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <link rel="stylesheet" href="assets/styles/sitecss.css">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <link rel="stylesheet" href="assets/styles/dashboard_beatriz.css">
 <style>
    .card {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <?php
  require_once __DIR__.'/session.php';
  require_once __DIR__.'/database/credentials.php';
  require_once __DIR__.'/database/db_connection.php';

  if (isset($_SESSION['authenticated'])) {
	include __DIR__ . "/includes/header_logged_in.php";

  }else{
	include __DIR__ . "/includes/header_restaurantes_selected.php";
  }

  include __DIR__ . "/includes/navbar_tipos_de_comida.php";

  ?>


  <!-- TÍTULO PÁGINA E PROCURAR -->
  <h1 style="text-align: center;">Restaurantes</h1><br>
  <form class="input-group container text-center mb-5" style="max-width: 40%;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" class="form-control" placeholder="Procurar restaurante" name="restaurante" id="restaurante">
    <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
  </form>

  <br>

  <!-- LISTA DE RESTAURANTES -->
<?php

include __DIR__ . "/includes/sidebar_perfil.php"; 
$itemPorPagina = 10;
$pagAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagAtual - 1) * $itemPorPagina;

try {
    $query = "SELECT est.id_estabelecimento, est.nome, est.localizacao, est.telemovel, 
          est.taxa_entrega, est.tempo_medio_entrega, est.imagem, emp.nome AS empresa,
          COALESCE ((select sum(classificacao)/count(classificacao) from avaliacoes where avaliacoes.id_estabelecimento=est.id_estabelecimento),0) as avaliacao
          FROM estabelecimentos AS est
          INNER JOIN empresas AS emp ON emp.id_empresa = est.id_empresa";

	$params = [];
	$conditions = [];

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (!empty($_GET["restaurante"])) {
			$conditions[] = "lower(est.nome) LIKE ?";
			$params[] = "%" . strtolower($_GET['restaurante']) . "%";
		}
		if (!empty($_GET["categoria"])) {
			$conditions[] = "lower(replace(emp.tipo,' ','')) = ?";
			$params[] = $_GET['categoria'];
		}
	}

	if (count($conditions) > 0) {
		$query .= " WHERE " . implode(" AND ", $conditions);
	}

	// Contar total de registros para a paginação
	$total_query = "SELECT COUNT(*) FROM ($query) AS subquery";
	$stmt = $pdo->prepare($total_query);
	$stmt->execute($params);
	$nRegistos = $stmt->fetchColumn();
	$totalPages = ceil($nRegistos / $itemPorPagina);

	// Consulta para buscar os registros
	$queryDividida = $query . " LIMIT $itemPorPagina OFFSET $offset";
	$stmt = $pdo->prepare($queryDividida);
	$stmt->execute($params);


	echo "
    <div class=' container'>
		<h2 class='mb-4' id='txt_categoria'>";
		
		if (isset($_GET['restaurante'])){
			echo 'Pesquisa por: '.$_GET['restaurante'];
		} else if (isset($_GET['restaurante']) and isset($_GET['categoria']) ){
			echo 'Pesquisa por: '.$_GET['restaurante']. ' ' .$_GET['categoria']. ' ';
		} else if (isset($_GET['categoria']) ){
			echo 'Pesquisa por:'.$_GET['categoria']. '';
		}else {
			echo 'Todos';
		}
	echo "</h2>    ";
	if ($nRegistos == 0) {
		echo "
		<br>
		<h2>
			<i style='color:#c3c3c3';>Não foram encontrados restaurantes para a pesquisa indicada..</i>
		</h2>
		";
	}
	else {
		echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3'> ";
		foreach ($stmt as $row) {
			echo "
			<div class='col grid_restaurantes_btn'>
			<div class='card shadow-sm' id='" . $row['nome'] . "'>
				<img src='".$row['imagem']."' class='card-img-top' height='180' width='260' alt='" . $row['nome'] . "' style='border-radius: 5.5px;'>
				<div class='card-body'>
					<div class='justify-content-between align-items-center'>
						<h5 class='mb-0' style='height:2.8rem;'>" . $row['nome'] . "</h5>
						<p class='mb-0'>". $row['avaliacao']." ★</p>
					</div>
					<div class='d-flex justify-content-between align-items-center'>
						<p class='card-text mb-0' style='font-size: 12px;'>Taxa de Entrega: " . $row['taxa_entrega'] . " €</p>
						<small class='text-body-secondary mb-0' style='font-size: 12px;'>" . $row['tempo_medio_entrega'] . " mins</small>
					</div>
				</div>
			</div>
			</div>
			";
		}
		echo "</div>";
	}
	
    // Links de paginação
    echo "<nav aria-label='Page navigation example'>
			<ul class='pagination' style='justify-content: right; margin-top: 20px;'>";
			
    if ($pagAtual > 1) {
        echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($pagAtual - 1) . "'>Anterior</a></li>";
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<li class='page-item " . ($i == $pagAtual ? 'active' : '') . "'><a class='page-link' href='?pagina=" . $i . "'>" . $i . "</a></li>";
    }
    if ($pagAtual < $totalPages) {
        echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($pagAtual + 1) . "'>Próxima</a></li>";
    }
    echo "</ul></nav>";

} catch (Exception $e) {
    echo "Erro na conexão à BD: " . $e->getMessage();
    return null;
}
?>

    <br>
  </div>
  <br><br>
  <!-- Footer -->
  <?php
  include __DIR__ . "/includes/footer_2.php";
  ?>

  <!-- SCRIPT -->
  <script>
    document.getElementById("buttonPesquisarRestaurante").addEventListener("click", function() {
	  var form = document.querySelector("form");
	  form.submit();
	});
	
	// Seleciona todos os elementos com a classe 'grid_restaurantes_btn'
var buttons = document.querySelectorAll('.grid_restaurantes_btn');

// Adiciona um evento de clique a cada botão
buttons.forEach(function(button) {
    button.addEventListener('click', function(event) {
        // Encontra o elemento .card mais próximo do botão clicado
        var parentElement = event.target.closest('.card');

        // Verifica se o elemento .card foi encontrado e obtém o ID
        var childElementId = parentElement ? parentElement.id : '';

        // Remove todos os espaços em branco do ID
        var sanitizedId = childElementId.replace(/\s+/g, '');

        // Redireciona para a página desejada, passando o ID como parâmetro na URL
        window.location.href = 'menu_restaurante.php?restaurante=' + sanitizedId;
    });
});
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>