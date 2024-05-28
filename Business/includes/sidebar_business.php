<div id="sideBarLeft" class="col-md-2 z-index-n1">
	<div class="d-flex flex-column" id="sidebar">
		<ul class="nav nav-pills flex-column mb-auto nav-item-container ">
			<!-- Home -->
			<li class="nav-item">
				<a href="/business/dashboard_home_page.php" class="nav-link active" aria-current="page">
					<span class="bi bi-house-door-fill">
						Home
					</span>
				</a>
			</li>

			<!-- Loja -->
			<li>
				<a href="/business/empresa_page.php" class="nav-link">
					<span class="bi-person-vcard"></span>
					<span class="bi bi-shop">
						Loja
					</span>
				</a>
			</li>

			<!-- Pedidos -->
			<li>
				<a href="/business/listapedidos.php" class="nav-link">
					<span class="bi-card-list"></span>
					<span class="bi has-text-grey">
						Pedidos
					</span>
				</a>
			</li>

			<!-- Performance -->
			<li>
				<a href="/business/performance.php" class="nav-link">
					<span class="bi-graph-up"></span>
					<span class="bi has-text-grey">
						Performance
					</span>
				</a>
			</li>

			<!-- Avaliações -->
			<li>
				<a href="/business/" class="nav-link">
					<span class="bi bi-stars"></span>
					<span class="bi has-text-grey">
						Avaliações
					</span>
				</a>
			</li>

			<!-- Menu -->
			<li>
				<a href="/business/dashboard_lista_items.php" class="nav-link">
					<span class=""></span>
					<span class="bi has-text-grey">
						Menu
					</span>
				</a>
			</li>

			<!-- Defenições -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi-gear-fill"></span>
					<span class="bi has-text-grey">
						Definições
					</span>
				</a>
			</li>
		</ul>
		<a id="butSingOutSidebarLeft" href="<?php echo '/Business/login_register/logoutB.php'?>" class="btn btn-dark px-3" type="button">Terminar Sessão</a>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		var sidebar = document.getElementById('sideBarLeft');
		var toggleButton = document.getElementById('toggleSidebar');
		var overlay = document.createElement('div');
		overlay.id = 'overlay';
		document.body.appendChild(overlay);

		toggleButton.onclick = function () {
			sidebar.classList.toggle('active');
			overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
		};

		overlay.onclick = function () {
			sidebar.classList.remove('active');
			overlay.style.display = 'none';
		};
	});
</script>