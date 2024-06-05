<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<?php 
function UrlContains($word){
	return str_contains($_SERVER['REQUEST_URI'],$word);
}

?>

<body>
	<div id="sideBarLeft" class="col-md-2 z-index-n1">
	<div class="d-flex flex-column" id="sidebar">
		<ul class="nav nav-pills flex-column mb-auto nav-item-container ">
			<!-- Home -->
			<li class="nav-item">
				<a href="/Business/dashboard_home_page.php" class="nav-link <?php echo UrlContains("dashboard_home_page.php") ? "active" : "" ?>" aria-current="page">
					<span class="bi bi-house-door-fill">
						<?php ?>
						Home
					</span>
				</a>
			</li>


			<!-- Loja -->
			<li>
				<a href="/Business/empresa_page.php" class="nav-link <?php echo UrlContains("empresa_page.php") ? "active" : "" ?>">
					<span class="bi-person-vcard"></span>
					<span class="bi bi-shop">
						Loja
					</span>
				</a>
			</li>

			<!-- Pedidos -->
			<li>
				<a href="/Business/listapedidos.php" class="nav-link <?php echo UrlContains("listapedidos.php") ? "active" : "" ?>">
					<span class="bi-card-list"></span>
					<span class="bi has-text-grey">
						Pedidos
					</span>
				</a>
			</li>

			<!-- Performance -->
			<li>
				<a href="/Business/performance.php" class="nav-link <?php echo UrlContains("performance.php") ? "active" : "" ?>">
					<span class="bi-graph-up"></span>
					<span class="bi has-text-grey">
						Performance
					</span>
				</a>
			</li>

			<!-- Avaliações -->
			<li>
				<a href="/Business/avaliacoes.php" class="nav-link <?php echo UrlContains("avaliacoes.php") ? "active" : "" ?>">
					<span class="bi bi-stars"></span>
					<span class="bi has-text-grey">
						Avaliações
					</span>
				</a>
			</li>

			<!-- Menu -->
			<li>
				<a href="/Business/dashboard_lista_items.php" class="nav-link <?php echo UrlContains("dashboard_lista") ? "active" : "" ?>">
					<span class=""></span>
					<span class="bi has-text-grey">
						Menu
					</span>
				</a>
			</li>

			<!-- Defenições -->
			<li>
				<a href="#" class="nav-link <?php echo UrlContains("#") ? "active" : "" ?>">
					<span class="bi-gear-fill"></span>
					<span class="bi has-text-grey">
						Definições
					</span>
				</a>
			</li>
		</ul>
		<a id="butSingOutSidebarLeft" href="<?php echo '../Business/login_register/logoutB.php' ?>" class="btn btn-dark px-3" type="button">Terminar Sessão</a>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		var sidebar = document.getElementById('sideBarLeft');
		var toggleButton = document.getElementById('toggleSidebar');
		var overlay = document.createElement('div');
		overlay.id = 'overlay';
		document.body.appendChild(overlay);

		toggleButton.onclick = function() {
			sidebar.classList.toggle('active');
			overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
		};

		overlay.onclick = function() {
			sidebar.classList.remove('active');
			overlay.style.display = 'none';
		};
	});
</script>

</body>
