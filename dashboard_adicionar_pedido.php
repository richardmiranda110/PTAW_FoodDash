<?php
session_start();

// Verificar se o usuário está logado
//if (!isset($_SESSION['username'])) {
//    header("Location: login.php");
//    exit();
//}

// Exibir nome de usuário
//echo "Welcome, " . $_SESSION['username'];
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/sitecss.css">
	  <link rel="stylesheet" href="assets/styles/dashboard.css">
  </head>
  <body>
  <!--Zona do Header -->
  <div id="topHeader" class="container-xxl">
    <!-- Top/Menu da Página -->
    <?php include __DIR__."/includes/header_logged_in.php"; ?>
  </div>

  <!--Zona de Conteudo -->  
  <div id="contentPage" class="container-xxl">
    <?php include __DIR__."/includes/sidebar_perfil.php"; ?>

    <!--Zona de Conteudo da Página -->
    <div id="contentDiv" class="col-md-12">

    <nav style="font-size:1.4rem; z-index: 1;" class="navbar navbar-expand-lg gray-navbar navbar-light bg-light ">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link nav" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav" href="#">Sobre</a>
            </li>
            <li class="nav-item"> <!-- não me digas nada sobre o style, o css não gosta dele -->
                <a class="nav-link nav " style="border-bottom: 1vh solid black;" href="#">Serviços</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav" href="#">Contato</a>
            </li>
        </ul>
    </div>
</nav>
    


  <!--Zona do Footer -->
  <div class="container">
    <p class="mx-4 h2 font-weight-bold ">Novo Item</p>
    <div class="w-25">
      <p class="font-weight-bold">Nome</p>
      <input placeholder="Menu Big Mac"type="text">
    </div>
    <?php include __DIR__."/includes/footer_2.php"; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


