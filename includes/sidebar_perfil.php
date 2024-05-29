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

<body>
	<?php
	?>
	<div id="sideBarLeft" class="col-md-2 z-index-n1">
		<div class="d-flex flex-column" id="sidebar">
			<ul class="nav nav-pills flex-column mb-auto nav-item-container ">
				<li class="nav-item">
					<a href="dashboard.php" class="nav-link active" aria-current="page">
						<span class="bi bi-speedometer">Dashboard</span>
					</a>
				</li>
				<li>
					<a href="perfil.php" class="nav-link">
						<span class="bi-person-vcard"></span><span class="bi has-text-grey">Perfil de Utilizador</span>
					</a>
				</li>
				<li>
					<a href="dashboard_perfil_pedidos.php" class="nav-link">
						<span class="bi-card-list"></span><span class="bi has-text-grey">Pedidos</span>
					</a>
				</li>
				<li>
					<a href="dashboard_perfil_estatisticas.php" class="nav-link">
						<span class="bi-graph-up"></span><span class="bi has-text-grey">Estatísticas</span>
					</a>
				</li>
			</ul>
			<a href="./login_register/logout.php" id="butSingOutSidebarLeft" class="btn btn-dark px-3" type="button">Terminar Sessão</a>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>