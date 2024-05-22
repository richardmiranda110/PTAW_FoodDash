<?php
session_start();

// Verificar se o usuário está logado
//if (!isset($_SESSION['username'])) {
//    header("Location: login.php");
//    exit();
//}

// Exibir nome de usuário
//conexão ao banco de dados
define("DBHOST", "localhost");
define("DBPORT", "5432");
define("DBNAME", "ptaw");
define("DBUSER", "postgres");
define("DBPASS", "test");

$pdo = new PDO(
    "pgsql:host=" . DBHOST .
    "; port=" . DBPORT .
    ";dbname=" . DBNAME,
    DBUSER,
    DBPASS
);

function ObterUmUtilizador($pdo, $ID)
{
	try {
		//query
		$stmt = $pdo->prepare('SELECT * FROM Clientes WHERE id = ?');
		$stmt->bindValue(1, $ID, PDO::PARAM_INT);
		// Executar a query e verificar que não retornou false
		if ($stmt->execute()) {
			// Fetch retorna um único resultado, então usamos fetch() e não fetchAll()
			$registo = $stmt->fetch();
			// Retornar os dados
			return $registo;
		} else {
			// Se a consulta falhar, retornar null
			echo "AAAAAAAAAAAAAA";
			return null;
		}

	} catch (Exception $e) {
		echo "Erro na conexão à BD: " . $e->getMessage();
		// Se ocorrer um erro, retornar null
		return null;
	}
}

// Recebendo dados da BD
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	// Obter os dados do utilizador
	$utilizador = ObterUmUtilizador($pdo, 1);
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Utilizador</title>
	<meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<link rel="stylesheet" href="assets/styles/sitecss.css">
	<link rel="stylesheet" href="assets/styles/dashboard.css">
	<link rel="stylesheet" href="assets/styles/dashboard_beatriz.css">
</head>

<body>

	<!--Zona do Header -->
	<div id="topHeader" class="container-xxl">
		<!-- Top/Menu da Página -->
		<?php include __DIR__ . "/includes/header_logged_in.php"; ?>


	</div>

	<!--Zona de Conteudo -->
	<div id="contentPage" class="container-xxl">
		<?php include __DIR__ . "/includes/sidebar_perfil.php"; ?>

		<!--Zona de Conteudo da Página -->
		<div id="contentDiv" class="col-md-12">
			<div class="container ps-3 py-3">
				<div class="dashboard  texto_perfil">
					<h3>Olá Maria!</h3>
					<p>Esta é a tua página de perfil. Aqui podes ver as tuas informções pessoais, ver estatísticas,
						sobre a tua
						conta, ver os teus pedidos e acompanhar o estado dos teus pedidos em tempo real</p>

					<div class="row align-items-md-stretch">
						<div class="col-md-6">
							<div class=" p-5 bg-body-tertiary border rounded-3">
								<h3 style="float:left">Perfil do utilizador</h3>
								<button class="btn btn-warning" style="float:right"> Visualizar </button>
								<br><br>
								<div class="esquerdo">
									<span class="dados">Nome:</span>
									<span class="dados_utilizador">
										<?php if (!empty($utilizador['nome']))
											echo $utilizador['nome']; ?>
										<?php if (!empty($utilizador['apelido']))
											echo $utilizador['apelido']; ?>
									</span>
									<br>
									<span class="dados">Email:</span>
									<span class="dados_utilizador">
										<?php if (!empty($utilizador['email']))
											echo $utilizador['email']; ?>
									</span>
									<br>
									<span class="dados">Nº de Telemóvel:</span>
									<span class="dados_utilizador"><span class="dados_utilizador">
											<?php if (!empty($utilizador['telemovel']))
												echo $utilizador['telemovel']; ?>
										</span>
								</div>
								<div class="direito">
									<span class="dados">Morada:</span>
									<span class="dados_utilizador">
										<?php if (!empty($utilizador['morada']))
											echo $utilizador['morada']; ?>
									</span>
									<br>
									<span class="dados">Cidade:</span>
									<span class="dados_utilizador">
										<?php if (!empty($utilizador['cidade']))
											echo $utilizador['cidade']; ?>
									</span>
									<br>
									<span class="dados">Código Postal:</span>
									<span class="dados_utilizador">
										<?php if (!empty($utilizador['CodPostal']))
											echo $utilizador['CodPostal']; ?>
									</span>
								</div>
								<button class="btn btn-outline-light" type="button">Example button</button>
							</div>
						</div>
						<div class="col-md-6 ">
							<div class="h-100 p-5 bg-body-tertiary border rounded-3">
								<h3 style="float:left">Estatísticas</h3>
								<button class="btn btn-warning" style="float:right"> Editar </button>
								<br><br>
								<div class="esquerdo">
									<span class="dados">Dinheiro Total Gasto:</span>
									<span class="dados_utilizador">489,27€</span>
									<br>
									<span class="dados">Total de Pedidos Realizados:</span>
									<span class="dados_utilizador">71</span>
									<br>
									<span class="dados">Restaurante Mais Pedido:</span>
									<span class="dados_utilizador">McDonald's</span>
								</div>
								<div class="direito">
									<canvas id="lineChart"></canvas>


								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="pedidos">
					<div class="align-items-md-stretch">
						<div class="h-100 p-5 bg-body-tertiary border rounded-3">
							<h2 class="esquerdo">Pedidos</h2>
							<button class="btn btn-warning" style="float:right"> Visualizar </button>
							<br><br>
							<div>
								<div class="card mb-3">
									<div class="card-body">
										<div class="esquerdo">
											<div class="esquerdo" style="width:25%">
												<p class="texto_pedido" style="text-align: center;">13:46</p>
												<p class="texto_pedido" style="text-align: center;">16/03/2024</p>
											</div>
											<div class="direito" style="width:75%">
												<h6>Menu Big King<span>(Burger King)</span></h6>
												<p class="texto_pedido">(Big King + Batatas Médias + Ice Tea Manga)
												</p>
											</div>
										</div>
										<div class="direito">
											<div class="esquerdo" style="width: 75%">
												<span class="texto_pedido_negrito">Método de Pagamento:</span>
												<span class="texto_pedido">VISA 102*********************</span>
												<br>
												<span class="texto_pedido_negrito">Status de Pedido:</span>
												<span class="texto_pedido">Entrgue</span>
											</div>
											<div class="direito" style="width: 25%; text-align: center;">
												<h6>9,28€</h6>
											</div>
										</div>
									</div>
								</div>
							<button class="btn btn-outline-light" type="button">Example button</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		include __DIR__ . "/includes/footer_2.php";
		?>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
			crossorigin="anonymous"></script>
		<script>
			var ctx = document.getElementById('lineChart').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: ["Dez", "Jan", "Fev", "Mar"],
					datasets: [{
						label: 'Total de Pedidos',
						data: [12, 18, 24, 30],
						backgroundColor: 'transparent',
						borderColor: '#d1c217',
						borderWidth: 2
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true,
								suggestedMax: 30
							}
						}]
					},
					title: {
						display: true,
						text: 'Total de Pedidos'
					}
				}
			});
		</script>
</body>

</html>