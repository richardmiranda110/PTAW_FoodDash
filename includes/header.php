<?php 
?>

<nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="Second navbar example">
<div class="container-fluid">
	<button id="toggleSidebar" class="btn btn-primary">
		<i class="bi bi-list"></i> <!-- Ícone de hambúrguer -->
	</button>
	<a class="navbar-brand" href="#">
	<img src="../assets/imgs/FoodDash.png" class="img-fluid" alt="Responsive image">
	</a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02"
	aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarsExample02">
		<div class="input-group flex-nowrap">
		  <span class="input-group-text" id="addon-wrapping">&#128506</span>
		  <input type="text" class="form-control" placeholder="Inserir morada" aria-label="default input example"
			aria-describedby="addon-wrapping" value="Rua Doutor Lourenço Peixinho, 19" style="max-width: 400px;">
		</div>
		<button id="loginMenuBtn" type="button" class="loginBtn btn btn-primary">Login</button>
		<button id="registMenuBtn" type="button" class="loginBtn btn btn-secondary">Registar</button>
	</div>
</div>
</nav>