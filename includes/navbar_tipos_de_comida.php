  <!-- BARRA DE TIPOS DE RESTAURANTES -->
  <div class="container" style="text-align: center;">
    <div class="d-inline-flex p-2 bd-highlight">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=pizza">
        <img src="./assets/stock_imgs/pizza_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Pizza
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=fastfood">
        <img src="./assets/stock_imgs/fastFood_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Fast Food
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=fastfood">
        <img src="./assets/stock_imgs/burger_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Hamburguer
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=sushi">
        <img src="./assets/stock_imgs/sushi_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Sushi
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=churrasco">
        <img src="./assets/stock_imgs/churrasco_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Churrasco
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=vegan">
        <img src="./assets/stock_imgs/vegan_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Vegan
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=portuguesa">
        <img src="./assets/stock_imgs/portuguesa_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Portuguesa
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=italiana">
        <img src="./assets/stock_imgs/italiana_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Italiana
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=sobremesas">
        <img src="./assets/stock_imgs/sobremesas_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Sobremesas
      </a>
    </div>
    <div class="d-inline-flex p-2 bd-highlight" style="padding: 0px 0px 0px 20px;">
      <a class="navbar-brand" href="./restaurantes_page.php?categoria=bebidas">
        <img src="./assets/stock_imgs/bebidas_menu_page.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Bebidas
      </a>
    </div>
  </div>
  
  <?php
  /*
require_once __DIR__.'/database/credentials.php';
require_once __DIR__.'/database/db_connection.php';

try {
    //$query = "SELECT DISTINCT tipo FROM empresas";
	$query = "SELECT tipo FROM empresas";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll();

    if (count($results) > 0) {
        echo "<div id='restaurantTypeCarousel' class='carousel slide' data-ride='carousel'>";
        echo "<div class='carousel-inner'>";
        
        $nIconsCategorias = 5;
        $tItens = count($results);
        $countItens = ceil($tItens / $nIconsCategorias);

        for ($i = 0; $i < $countItens; $i++) {
            $activeClass = ($i == 0) ? 'active' : '';
            echo "<div class='carousel-item $activeClass'>";
            echo "<div class='container d-flex justify-content-center'>";
            
            $start = $i * $nIconsCategorias;
            $end = min($start + $nIconsCategorias, $tItens);

            for ($j = $start; $j < $end; $j++) {
                $tipo = htmlspecialchars($results[$j]['tipo'], ENT_QUOTES);
                echo "
                <div class='p-2'>
                    <a class='navbar-brand' href='#'>
                        <img src='./assets/stock_imgs/categorias/$tipo.png' width='30' height='30' class='d-inline-block align-top' alt='$tipo'>
                        $tipo
                    </a>
                </div>
                ";
            }

            echo "</div></div>";
        }

        echo "</div>";
        echo "<a class='carousel-control-prev' href='#restaurantTypeCarousel' role='button' data-slide='prev' style='color: rgba(var(--bs-dark-rgb),var(--bs-bg-opacity))!important;'>
                <i class='bi bi-arrow-left-square-fill'></i>
              </a>";
        echo "<a class='carousel-control-next' href='#restaurantTypeCarousel' role='button' data-slide='next' style='color: rgba(var(--bs-dark-rgb),var(--bs-bg-opacity))!important;'>
                <i class='bi bi-arrow-right-square-fill'></i>
              </a>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "Erro na conexão à BD: " . $e->getMessage();
    return null;
}
*/
?>

