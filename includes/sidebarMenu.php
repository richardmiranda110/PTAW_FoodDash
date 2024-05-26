<?php 
?>
<div id="sideBarLeft" class="col-md-2">
  <div class="d-flex flex-column">
	<ul class="nav nav-pills flex-column mb-auto">
	  <li class="nav-item">
		<a href="#" class="nav-link active" aria-current="page">
		  <span class="bi bi-speedometer">Dashboard</span>
		</a>
	  </li>
	  <li>
		<a href="#" class="nav-link">
		  <span class="bi bi-person-vcard">Perfil de Utilizador</span>
		</a>
	  </li>
	  <li>
		<a href="#" class="nav-link">
		  <span class="bi bi-card-list">Pedidos</span>
		</a>
	  </li>
	  <li>
		<a href="#" class="nav-link">
		  <span class="bi bi-graph-up">Estatísticas</span>
		</a>
	  </li>
	</ul>
	<hr>
	<div>
	  <button id="butSingOutSidebarLeft" class="btn btn-dark px-3" type="button">Terminar Sessão</button>
	</div>
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
