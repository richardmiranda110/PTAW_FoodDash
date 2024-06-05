<!DOCTYPE html>
<html lang="pt">
<?php require_once __DIR__ . '/session.php'; ?>

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
	require_once __DIR__ . '/session.php';
	require_once __DIR__ . '/database/credentials.php';
	require_once __DIR__ . '/database/db_connection.php';

	if (isset($_SESSION['authenticated'])) {
		include __DIR__ . "/includes/header_logged_in.php";
	} else {
		include __DIR__ . "/includes/header_restaurantes_selected.php";
	}

	include __DIR__ . "/includes/navbar_tipos_de_comida.php";
	
	function getImagePath($path, $default = './assets/stock_imgs/fd reduced logo.png') {
		$path = "./assets/stock_imgs/".$path;

		return file_exists($path) ? $path : $default;
	}
	?>


	<!-- TÍTULO PÁGINA E PROCURAR -->
	<p class="h1 text-center pt-2 mb-2">Restaurantes</p>
	<form class="input-group container mb-5 w-50" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
		$query = "select empresas.id_empresa, empresas.nome, empresas.morada, empresas.telemovel,
		COALESCE ( 
			(select min(taxa_entrega) from estabelecimentos where estabelecimentos.id_empresa = empresas.id_empresa )
			,0) as taxa_entrega,
		COALESCE ( 
			(select avg(tempo_medio_entrega) from estabelecimentos where estabelecimentos.id_empresa = empresas.id_empresa )
			,'00:00:00') as tempo_medio_entrega,
			COALESCE ( logotipo,'') logotipo,
		COALESCE (
			(select sum(classificacao)/count(classificacao) from avaliacoes 
			 where avaliacoes.id_empresa=empresas.id_empresa)
			,0) as avaliacao
		from empresas inner join estabelecimentos on estabelecimentos.id_empresa = empresas.id_empresa
		group by empresas.id_empresa, empresas.nome, empresas.morada, empresas.telemovel";

		$params = [];
		$conditions = [];

		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			if (!empty($_GET["restaurante"])) {
				$conditions[] = "lower(empresas.nome) LIKE ?";
				$params[] = "%" . strtolower($_GET['restaurante']) . "%";
			}
			if (!empty($_GET["categoria"])) {
				$conditions[] = "lower(replace(tipo,' ','')) = ?";
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
    <div class=' container p-5 pt-0'>
		<h2 class='mb-4' id='txt_categoria'>";

		if (isset($_GET['restaurante'])) {
			echo 'Pesquisa por: ' . $_GET['restaurante'];
		} else if (isset($_GET['restaurante']) and isset($_GET['categoria'])) {
			echo 'Pesquisa por: ' . $_GET['restaurante'] . ' ' . $_GET['categoria'] . ' ';
		} else if (isset($_GET['categoria'])) {
			echo 'Pesquisa por:' . $_GET['categoria'] . '';
		} else {
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
		} else {
			echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3'> ";
			foreach ($stmt as $row) {
				$imagemPath = getImagePath($row['logotipo']);
				echo "
			<div class='col grid_restaurantes_btn'>
			<div class='card shadow-sm' id='" . $row['nome'] . "'>
				<img src='" . $imagemPath  . "' class='card-img-top' height='180' width='260' alt='" . $row['nome'] . "' style='border-radius: 5.5px;'>
				<div class='card-body'>
					<div class='justify-content-between align-items-center'>
						<h5 class='mb-0' style='height:2.8rem;'>" . $row['nome'] . "</h5>
						<p class='mb-0'>" . $row['avaliacao'] . " ★</p>
					</div>
					<div class='d-flex justify-content-between align-items-center'>
						<p class='card-text mb-0' style='font-size: 12px;'>Taxa de Entrega: a partir de " . $row['taxa_entrega'] . " €</p>
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