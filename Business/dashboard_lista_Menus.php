<?php
require_once  __DIR__."/includes/session.php";

if (!isset($_SESSION['id_empresa']) || !isset($_SESSION['nome'])) {
  $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
  header("Location: ./login_register/login_business.php");
  exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodDash Menus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles/adicionar.css">
    <link rel="icon" type="image/x-icon" href="../assets/stock_imgs/t_fd_logo_tab_business_icon.png">
    <link rel="stylesheet" href="./../assets/styles/sitecss.css">
	  <link rel="stylesheet" href="./../assets/styles/dashboard.css">
    <script src="./../assets/js/dable.js"></script>
    <?php echo '<script>var idEmpresa="'.$_SESSION['id_estabelecimento'].'"</script>' ?>
  </head>
  <body>
    <div id="topHeader" class="container-xxl">
      <?php include "./includes/header_business_logged.php"; ?>
    </div>

    <div id="contentPage" class="container-xxl">

      <?php include "./includes/sidebar_business.php"; ?>

      <div id="contentDiv" class="col-md-12">
        <nav style="font-size:1.4rem; z-index: 1; text-align: center;" class="navbar navbar-expand-lg gray-navbar navbar-light fw-bold ">
          <div class="collapse navbar-collapse" style="width: 15vw;" id="navbarNav">
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a class="nav-link nav" style="border-bottom: 1vh solid black;"  href="./dashboard_lista_menus.php#">Menus</a>
                  </li>
                  <li class="nav-item"> <!-- não me digas nada sobre o style, o css não gosta dele -->
                      <a class="nav-link nav "  href="./dashboard_lista_categorias.php">Categorias</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link nav" href="./dashboard_lista_items.php#">Itens</a>
                  </li>
              </ul>
          </div>
        </nav>
        <p class="float:left fw-bold h2 mx-3  text-left">Menus</p> 
        <button class="float-end btn btn-custom fw-bold mt-1 " style="margin-right:4.5vw" onclick="window.open('./dashboard_inserir_item.php')">+ Novo Item</button>
        <div id="DefaultDable"></div>
      </div>	
    </div>

    <div id="modal" class="modal d-none">
      <div class="modal-content" id="modal-content">
      <p class="fw-bold mt-1 mb-2" id="modal-text"></p>
        <form id="category-input"  action='./lista_categorias.php?idEmpresa=<?php echo $_SESSION['id_empresa']?>' method="post">
          <input type="text" name ="category-input" class="mb-2 form-control" id="category-input">
        </form>
        <span class="close">&times;</span>
      </div>
    </div>
    <!--Zona do Footer -->
    <?php include "./includes/footer_business_2.php"; ?>
    <script src="./assets/js/lista_menus.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


