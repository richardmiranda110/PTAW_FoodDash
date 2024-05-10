<?php
//PESQUISAR RESTAURANTE
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $restaurante = $_POST["input_pesquisar_restaurante"];

  try {
    if (!empty($restaurante)) {
      $q = "SELECT nome, imagem, avaliacao, taxa_entrega, tempo_medio_entrega FROM restaurantes WHERE nome LIKE ?";
      $statement = $pdo->prepare($q);
      $statement->execute(array("%$restaurante%"));

      if ($statement) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
          foreach ($result as $row) {
            echo '<div class="col">
                  <div class="card shadow-sm">
                    <img src="' . $row["imagem"] . '" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">' . $row["nome"] . '</h5>
                        <p class="mb-0">' . $row["avaliacao"] . '★</p>
                      </div>

                      <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: ' . $row["taxa_entrega"] . '€</p>
                        <small class="text-body-secondary mb-0" style="font-size: 12px;">' . $row["tempo_medio_entrega"] . ' mins</small>
                      </div>
                    </div>
                  </div>
                </div>';
          }
        } else {
          echo "Restaurante não encontrado :(";
        }
      } else {
        echo "Erro ao executar a consulta.";
      }
    }
  } catch (Exception $e) {
    echo "Erro na conexão à BD: " . $e->getMessage();
  }
}*/
?>

<?php
//POPULAR PÁGINA COM OS RESTAURANTES DA BASE DE DADOS
/*
try {

  $q = "SELECT nome, imagem, avaliacao, taxa_entrega, tempo_medio_entrega FROM restaurantes;";
  $statement = $pdo->prepare($q);
  $statement->execute();

  if ($statement) {
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
      foreach ($result as $row) {
        echo '<div class="col">
                <div class="card shadow-sm">
                  <img src="' . $row["imagem"] . '" class="card-img-top" alt="Imagem do restaurante" style="border-radius: 5.5px;">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">' . $row["nome"] . '</h5>
                      <p class="mb-0">' . $row["avaliacao"] . '★</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text mb-0" style="font-size: 12px;">Taxa de Entrega: ' . $row["taxa_entrega"] . '€</p>
                      <small class="text-body-secondary mb-0" style="font-size: 12px;">' . $row["tempo_medio_entrega"] . ' mins</small>
                    </div>
                  </div>
                </div>
              </div>';
      }
    }
  } else {
    echo "Nenhum restaurante encontrado :(";
  }
} catch (Exception $e) {
  echo "Erro na conexão à BD: " . $e->getMessage();
}*/
?>



<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .card {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <?php
  //require_once __DIR__."/database/db_connection.php";
  include __DIR__ . "/includes/header_restaurantes_selected.php";
  include __DIR__ . "/includes/navbar_tipos_de_comida.php";
  ?>


  <br><br>
  <!-- TÍTULO PÁGINA E PROCURAR -->
  <h1 style="text-align: center;">Restaurantes</h1><br>
  <form class="input-group container text-center mb-5" style="max-width: 40%;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" class="form-control" placeholder="Procurar restaurante" name="restaurante" id="restaurante">
    <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
  </form>

  <br>

  <!-- LISTA DE RESTAURANTES -->
      
<?php
require_once 'database/credentials.php';
require_once 'database/db_connection.php';

$itemPorPagina = 10;
$pagAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagAtual - 1) * $itemPorPagina;

try {
    $query = "SELECT est.id_estabelecimento, est.nome, est.localizacao, est.telemovel, 
          est.taxa_entrega, est.tempo_medio_entrega, est.logotipo, emp.nome AS empresa,
		  COALESCE ((select sum(classificacao)/count(classificacao) from avaliacoes where avaliacoes.id_estabelecimento=est.id_estabelecimento),0) as avaliacao
          FROM estabelecimentos AS est
          INNER JOIN empresas AS emp ON emp.id_empresa = est.id_empresa";
	$params = [];

	if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["restaurante"])) {
		$query .= " WHERE lower(est.nome) LIKE ?";
		$params[] = "%" . $_GET['restaurante'] . "%";
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
    <div class='container'>
		<h2 id='txt_categoria'>". (empty($_GET['restaurante']) ? 'Todos' : 'Pesquisa por: '.$_GET['restaurante'] )."</h2>
		<div class='row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3'>
    ";
	
    foreach ($stmt as $row) {
        echo "
        <div class='col'>
        <div class='card shadow-sm'>
            <img src='./assets/stock_imgs/" . $row['logotipo'] . "' class='card-img-top' alt='" . $row['nome'] . "' style='border-radius: 5.5px;'>
            <div class='card-body'>
                <div class='d-flex justify-content-between align-items-center'>
                    <h5 class='mb-0'>" . $row['nome'] . "</h5>
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
	
    // Links de paginação
    echo "<nav aria-label='Page navigation example'>
			<ul class='pagination' style='justify-content: right; margin-top: 20px;'>";
			
    if ($pagAtual > 1) {
        echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($pagAtual - 1) . "'>Anterior</a></li>";
    }
    for ($i = 1; $i <= $total_paginas; $i++) {
        echo "<li class='page-item " . ($i == $pagAtual ? 'active' : '') . "'><a class='page-link' href='?pagina=" . $i . "'>" . $i . "</a></li>";
    }
    if ($pagAtual < $total_paginas) {
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
  include __DIR__ . "/includes/footer_1.php";
  ?>

  <!-- SCRIPT -->
  <script>
    document.getElementById("buttonPesquisarRestaurante").addEventListener("click", function() {
	  var form = document.querySelector("form");
	  form.submit();
	});
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>