<?php
?>
  <div id="sideBarLeft" class="col-md-2 z-index-n1">
			<div class="d-flex flex-column" id="sidebar">
				<ul class="nav nav-pills flex-column mb-auto nav-item-container ">
					<li class="nav-item" >
						<a href="#" class="nav-link active" aria-current="page">
							<span class="bi bi-speedometer">Dashboard</span>
						</a>
					</li>
					<li>
						<a href="#" class="nav-link">
							<span class = "bi-person-vcard"></span><span class="bi has-text-grey">Perfil de Utilizador</span>
						</a>
					</li>
					<li>
						<a href="#" class="nav-link">
						<span class = "bi-card-list"></span><span class="bi has-text-grey">Pedidos</span>
						</a>
					</li>
					<li>
						<a href="#" class="nav-link">
						<span class = "bi-graph-up"></span><span class="bi has-text-grey">Estatisticas</span>
						</a>
					</li>
					<li>
						<a href="#" class="nav-link">
						<span class = "bi-credit-card-fill"></span><span class="bi has-text-grey">Método Pagamento</span>
						</a>
					</li>
				</ul>
				<button id="butSingOutSidebarLeft" class="btn btn-dark px-3" type="button">Terminar Sessão</button>
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
