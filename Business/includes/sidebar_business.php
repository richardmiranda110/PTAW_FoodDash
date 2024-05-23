<?php
?>
<div id="sideBarLeft" class="col-md-2 z-index-n1">
	<div class="d-flex flex-column" id="sidebar">
		<ul class="nav nav-pills flex-column mb-auto nav-item-container">
			<!-- Home -->
			<li class="nav-item">
				<a href="#" class="nav-link active" aria-current="page">
					<span class="bi bi-house-door-fill">
						Home
					</span>
				</a>
			</li>

			<!-- Loja -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi bi-shop">
						Loja
					</span>
				</a>
			</li>

			<!-- Pedidos -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi-card-list"></span>
					<span class="bi has-text-grey">
						Pedidos
					</span>
				</a>
			</li>

			<!-- Performance -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi-graph-up"></span>
					<span class="bi has-text-grey">
						Performance
					</span>
				</a>
			</li>

			<!-- Clientes -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi bi-people-fill"></span>
					<span class="bi has-text-grey">
						Clientes
					</span>
				</a>
			</li>

			<!-- Avaliações -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi bi-stars"></span>
					<span class="bi has-text-grey">
						Avaliações
					</span>
				</a>
			</li>

			<!-- Menu -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi bi-egg-fill"></span>
					<span class="bi has-text-grey">
						Menus
					</span>
				</a>
			</li>

			<!-- Pagamentos -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi-credit-card-fill"></span>
					<span class="bi has-text-grey">
						Pagamentos
					</span>
				</a>
			</li>

			<!-- Design -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi bi-pencil-square"></span>
					<span class="bi has-text-grey">
						Design
					</span>
				</a>
			</li>

			<!-- Defenições -->
			<li>
				<a href="#" class="nav-link">
					<span class="bi-gear-fill"></span>
					<span class="bi has-text-grey">
						Defenições
					</span>
				</a>
			</li>
		</ul>
		<button id="butSingOutSidebarLeft" class="btn btn-dark px-3" type="button">Terminar Sessão</button>
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