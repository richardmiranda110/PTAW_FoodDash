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
                <a class="nav-link nav" href="#">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav" href="#">Menus</a>
            </li>
            <li class="nav-item"> <!-- não me digas nada sobre o style, o css não gosta dele -->
                <a class="nav-link nav " style="border-bottom: 1vh solid black;" href="#">Categorias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav" href="#">Contato</a>
            </li>
        </ul>
  </div>
  </nav>
    
  <div class="container">
    <p class="mx-4 my-4 h2 fw-bold ">Novo Item</p>
    <div class="w-25 mb-5">
      <p class="fw-bold">Nome</p>
      <input placeholder="Menu Big Mac"type="text">
    </div>
  </div>

  <div class="container ">
    <p class="fw-bold mb-1 purple-text">Foto</p>
    <div class="container mb-5">
     <form action="imageup.php" method="post" enctype="multipart/form-data">
      <div class="upload-box">
        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="banner" accept="image/*">
        <div>
          <p>Arraste uma imagem para fazer upload</p>
          <p>ou</p>
          <a href="#">Procurar ficheiro</a>
        </div>
      </div>
    </form>
  </div>
  
  <div class="container">
    <div class="w-25 mb-5">
      <label for="descricaoForm1 " class="fw-bold purple-text">Descrição</label>
      <div class="form-group w-100">
        <textarea placeholder="Introduza Descrição" class="form-control w-100" id="descricaoForm1" rows="3"></textarea>
      </div>
    </div>
  </div>

  <div class="container mb-5">
    <p class="m fw-bold purple-text ">Vendendo Item Sozinho?</p>
    <div class="w-25 mb-5">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="inlineRadio2" name="inlineRadioOptions" value="option1" checked>
        <label class="form-check-label" for="inlineCheckbox2">Sim</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="inlineRadio1" name="inlineRadioOptions" value="option2" >
        <label class="form-check-label" for="inlineCheckbox1">Não</label>
      </div>
    </div>
  </div>

  <div class="text-left">
    <input type="submit" value="GUARDAR" class="btn-xl btn btn-success w-25 h-25 btn-primary mt-3">
  </div>
  
  <!--Zona do Footer -->
  <?php include __DIR__."/includes/footer_2.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


