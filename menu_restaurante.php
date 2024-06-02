<?php require_once './session.php'; ?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/styles/sitecss.css">
  <link rel="stylesheet" href="/assets/styles/restaurants.css">
  <link rel="stylesheet" href="./assets/styles/rating_menu_restaurant.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<?php 
include __DIR__."/includes/insertAvaliationRestaurant.php"; 
include __DIR__."/includes/insertPedido.php"; 
?>

  <!-- NAVBAR -->
  <?php
  
  
  if (!isset($_GET['restaurante'])) {
    if (!empty($_SERVER['HTTP_REFERER'])) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
      header('Location: /restaurantes_page.php');
    }
    exit();
  }
	
  if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
    include __DIR__."/includes/header_restaurantes_selected.php";
  }else{
    include __DIR__."/includes/header_logged_in.php";
	///validar id cliente por session
	$idCliente=$_SESSION['id_cliente'];
	$idIndex=240;
  }
  
  $idCliente = 1;

  require_once 'database/credentials.php';
  require_once 'database/db_connection.php';

  function getImagePath($path, $default = './assets/stock_imgs/fd reduced logo.png')
  {
    return file_exists($path) ? $path : $default;
  }

  $fRestaurante = "%" . strtolower(str_replace(' ', '', $_GET['restaurante'])) . "%";

  $queryTop = "select id_empresa, nome,
		COALESCE ( 
			(select min(taxa_entrega) from estabelecimentos where estabelecimentos.id_empresa = estabelecimentos.id_empresa )
			,0) as taxa_entrega,
		COALESCE ( 
			(select avg(tempo_medio_entrega) from estabelecimentos where estabelecimentos.id_empresa = estabelecimentos.id_empresa )
			,'00:00:00') as tempo_medio_entrega,
			logotipo,
		COALESCE (
			(select sum(classificacao)/count(classificacao) from avaliacoes 
			 where avaliacoes.id_empresa=empresas.id_empresa)
			,0) as avaliacao
		from empresas
		WHERE REPLACE(LOWER(nome), ' ', '') LIKE ?";

  try {
    $stmtTop = $pdo->prepare($queryTop);
    $stmtTop->execute([$fRestaurante]);
    $infoRest = $stmtTop->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
  }
  ?>

  <!-- IDENTIFICAÇÃO DO RESTAURANTE -->
  <div class="p-4 p-md-5" style="background-color: #ffffff; border-bottom: 1vw ridge #febc41; border-radius: 15px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 px-0">
          <?php
		  $idEmpresa = $infoRest['id_empresa'] ;
          echo "<h3 class='display-6' style='font-weight: bolder;'>" . $infoRest['nome'] . "</h3>
          <h5 class='mb-0'>" . $infoRest['avaliacao'] . "★</h5>
          <p class='mb-0'>Taxa de Entrega: a partir de " . $infoRest['taxa_entrega'] . "€</p>
        </div>
        <div class='col-lg-4 text-center'>
          <img src='".$infoRest['logotipo']."' alt='" . $infoRest['nome'] . "' style='max-width: 20vw;'>
        </div>
		";
          ?>
          <div class="col-lg-4 px-4">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Procurar item" id="inputPesquisarRestaurante">
              <button class="btn btn-outline-primary" type="button" id="buttonPesquisarRestaurante">Procurar</button>
            </div>

            <!-- TOAST --->
            <button type="button" class="btn btn-primary" style="<?php echo $idCliente == 0 ? 'display: none;' : ''; ?>" id="liveToastBtn">Avaliar Empresa</button>
			<div class="toast-container position-fixed bottom-0 end-0 p-3">
			  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
				<div class="toast-header">
				  <img src="./assets/imgs/estrela_ilustrativa.png" class="rounded me-2" alt="star" style="width: 1.5vw;">
				  <strong class="me-auto">Avaliar Empresa</strong>
				  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body2" style="height: auto;">
				  <form id="ratingForm" method="POST"  enctype="multipart/form-data" action="">
					
					<div class="rating-box">
					  <header>Como foi a sua experiência?</header>
					  <div class="stars">
						<i class="fa-solid fa-star" data-value="1"></i>
						<i class="fa-solid fa-star" data-value="2"></i>
						<i class="fa-solid fa-star" data-value="3"></i>
						<i class="fa-solid fa-star" data-value="4"></i>
						<i class="fa-solid fa-star" data-value="5"></i>
					  </div>
					</div>
					<input type="hidden" name="idForm" id="idForm" value="insertAvaliation">
					<input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $idEmpresa; ?>">
					<input type="hidden" name="idCliente" id="idCliente" value="<?php echo $idCliente; ?>">
					<input type="hidden" name="estrelas" id="ratingValue">
					<textarea rows="4" cols="50" maxlength="100" name="input_text_comentario" id="input_text_comentario" placeholder="Insira um comentário (opcional) ..." style="margin-bottom: 1vh; width: 80%;"></textarea>
					<input class="btn btn-primary" type="submit" id="btn_enviar_avaliacao" value="Enviar">
				  </form>
				</div>
			  </div>
			</div>

			<script>
			  document.querySelectorAll('.stars i').forEach(star => {
				star.addEventListener('click', function() {
				  let rating = this.getAttribute('data-value');
				  document.getElementById('ratingValue').value = rating;
				});
			  });

			  document.getElementById('ratingForm').addEventListener('submit', function(event) {
				let estrelas = document.getElementById('ratingValue').value;
				if (!estrelas) {
				  event.preventDefault();
				  alert('Por favor, selecione uma classificação.');
				}
			  });
			</script>

          </div>

        </div>
      </div>
    </div>

   <?php 
   
   $query = "SELECT 'Menus' as nome 
			union
			SELECT DISTINCT categorias.nome FROM itens
			INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = itens.id_estabelecimento
			INNER JOIN empresas on empresas.id_empresa=estabelecimentos.id_empresa
			INNER JOIN categorias ON categorias.id_categoria = itens.id_categoria
			WHERE REPLACE(LOWER(empresas.nome), ' ', '') LIKE ? ";

       $stmt = $pdo->prepare($query);
       $stmt->execute([strtolower($fRestaurante)]);
       //$stmt->execute();
	   $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if(count($categorias) != 0){
    
      echo '<div class="container d-flex justify-content-start" style="margin: 0; padding: 0">
      <!-- SIDEBAR CATEGORIAS -->
      <div class="d-flex flex-column p-3 bg-body-tertiary" style="width: 17.7vw;">
        <a class="d-flex align-items-center me-md-auto link-body-emphasis text-decoration-none">
          <span class="fs-4">Categorias</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">';

        echo "<li class='nav-item'>
			  <a href='menu_restaurante.php?restaurante=".strtolower(str_replace(' ', '', $_GET['restaurante']))."' class='nav-link link-body-emphasis' aria-current='page'>
			  Ver Todos
			  </a>
			</li>";
    }


          foreach ($categorias as $row) {
			 $fcategoria = strtolower(str_replace(' ', '',$row['nome']));
            echo "<li class='nav-item'>
			  <a href='menu_restaurante.php?restaurante=".strtolower(str_replace(' ', '', $_GET['restaurante']))."&categoria=".$fcategoria."' class='nav-link link-body-emphasis' aria-current='page'>
				<text class='opcao'>" . $row['nome'] . "</text>
			  </a>
			</li>";
          }

          ?>
        </ul>
      </div>

      <div class="accordion p-3" id="listProds" style="width: 82.3vw;">
        <?php
        try {
          $dados = [];
		  
		  //filtro para aparecer só a categoria pretendido
		  if (!empty($_GET['categoria'])) {
			foreach ($categorias as $categoria) {
			  if ($_GET['categoria']==strtolower(str_replace(' ', '',$categoria['nome']))) {
				$categorias = [
					['nome' => $categoria['nome']]
				];
			  }		  
			}			 
		  }
        if(count($categorias) == 0){
          echo "Este Restaurante não pussui itens";
        }
          foreach ($categorias as $categoria) {
            $fCategoria = htmlspecialchars($categoria['nome']);

            echo "<div class='accordion-item' style='border:none;'>
				<h3 class='accordion-header' id='heading" . $fCategoria . "'>
					<button class='accordion-button bg-dark' type='button' data-bs-toggle='collapse' data-bs-target='#collapse" . $fCategoria . "' aria-expanded='true' aria-controls='collapse" . $fCategoria . "' style='color: white;'>
							" . $categoria['nome'] . "
					</button>
				</h3>";

			$queryProd = "select m.id_menu, m.nome, m.descricao, m.preco, m.foto, false itemsozinho, true personalizacoesativas
					from menus m 
					inner join empresas e on e.id_empresa=m.id_estabelecimento  
					and REPLACE(LOWER(e.nome), ' ', '') LIKE ? ";
			
            $queryProdOld = "SELECT itens.id_item, itens.nome, itens.descricao, itens.preco, itens.foto, itens.itemsozinho, itens.personalizacoesativas  
					FROM itens 
					INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = itens.id_estabelecimento 
					INNER JOIN categorias ON categorias.id_categoria = itens.id_categoria 
					WHERE itens.disponivel=true and REPLACE(LOWER(estabelecimentos.nome), ' ', '') LIKE ?";
					//? AND REPLACE(LOWER(categorias.nome), ' ', '') LIKE ? ";

            $idCategoria = str_replace(' ', '', $fCategoria);
            $fCat = "%" . strtolower(str_replace(' ', '', $fCategoria)) . "%";

            if (strtolower($idCategoria) == 'menus') {
			$queryProd = "select m.id_menu, m.nome, m.descricao, m.preco, m.foto, false itemsozinho, true personalizacoesativas
					from menus m 
					inner join empresas e on e.id_empresa=m.id_estabelecimento  
					and REPLACE(LOWER(e.nome), ' ', '') LIKE ? ";
					
					$stmtProd = $pdo->prepare($queryProd);
					$stmtProd->execute([$fRestaurante]);
					$produtos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
			} else {
            $queryProd = "SELECT itens.id_item, itens.nome, itens.descricao, itens.preco, itens.foto, itens.itemsozinho, itens.personalizacoesativas  
					FROM itens 
					INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = itens.id_estabelecimento 
					INNER JOIN categorias ON categorias.id_categoria = itens.id_categoria 
					WHERE itens.disponivel=true and REPLACE(LOWER(estabelecimentos.nome), ' ', '') LIKE ? AND REPLACE(LOWER(categorias.nome), ' ', '') LIKE ? ";
					
					$stmtProd = $pdo->prepare($queryProd);
					$stmtProd->execute([$fRestaurante,$fCat]);
					$produtos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
			}

            echo "<div id='collapse" . $idCategoria . "' class='accordion-collapse collapse show' aria-labelledby='heading" . $idCategoria . "' data-bs-parent='#listProds'>
              <div class='accordion-body'>";
              

            foreach ($produtos as $rowProd) {
			 
              $imagemPath = getImagePath($rowProd['foto']);
              $idProd = str_replace(' ', '', htmlspecialchars($rowProd['nome']));
              echo "<div>
                    <div class='card shadow-sm' id='" . $idProd . "' style='width:18%; margin: 0px 0.5% 1% 0.5%; float:left;'>
                    <div class='card-body'>
                        <div class='image-overlay' style='position: relative; border-radius: 5.5px; overflow: hidden;'>
                            <img src='" . $imagemPath . "' class='card-img-top' alt='" . $idProd . "' style='border-radius: 5.5px;'>
                            <div class='icon-overlay' id='liveToastBtn_".$idCategoria."_".$idProd. "' style='position: absolute; bottom: 10px; right: 10px;'>
                                <img src='./assets/stock_imgs/mais.png' id='iconAddItem' alt='Ícone de adição' style='width: 35px; height: 35px; transition: transform 0.3s, box-shadow 0.3s;'>
                            </div>
                        </div>
                        <div class='card-body' style='padding: 10px 0px;'>
                            <div class='d-flex justify-content-between align-items-center'>
                                <h6 class='mb-0' style='min-height: 2.5rem;'>" . htmlspecialchars($rowProd['nome']) . "</h6>
                            </div>
                            <div class='d-flex justify-content-between align-items-center'>
                                <p class='card-text mb-0' style='font-size: 12px;'>" . $rowProd['preco'] . "€</p>
                            </div>
                        </div>
                    </div>
                </div>";
                
                $dados[]  = ['id' => $rowProd['id_menu'] , 'trigger' => 'liveToastBtn_'.$idCategoria.'_'.$idProd, 'toast' => 'liveToast_'.$idCategoria.'_'.$idProd];
                //echo "<input type='hidden' name='idPedido' id='idPedido' value='".$idPedido."'>";
				echo "
				<div class='toast-container position-fixed bottom-0 end-0 p-3'>
				<form method='POST'  enctype='multipart/form-data' action='' id='pedidoForm'>
					<input type='hidden' name='idEstabelecimento' id='idEstabelecimento' value='".$idEmpresa."'>
					<input type='hidden' name='idCliente' id='idCliente' value='".$idCliente."'>
					<input type='hidden' name='idProd' id='idProd' value='".$rowProd['id_menu']."'>

					<input type='hidden' name='preco' id='preco' value='".$rowProd['preco']."'>
					<input type='hidden' name='idForm' id='idForm' value='insertPedido'>
					
					<div id='liveToast_".$idCategoria."_".$idProd."' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-bs-autohide='false' style='width: 40vw; max-height: 95vh; overflow-y: auto; padding-bottom: 10px;'>
					<div class='toast-header'>
						<img src='./assets/stock_imgs/burgerKing_marca.png' class='rounded me-2' alt='logotipo' style='width: 1.5vw;'>
						<strong class='me-auto'>" . htmlspecialchars($rowProd['nome']) . "</strong>
						<button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
					</div>
					<div class='toast-body' style='height: auto; align-items: unset;'>
						<div id='txt_item_title_price_description'>
						<h3>" . htmlspecialchars($rowProd['nome']) . "</h3>
						<h5>" . $rowProd['preco'] . "€</h5>
						<p>" . htmlspecialchars($rowProd['descricao']) . "</p>
						</div>
						<hr>
						<div>	
						<h5>Personaliza o teu " . htmlspecialchars($rowProd['nome']). "</h5>
						";
					
					if (strtolower($idCategoria) == 'menus') {
						$queryMenu = "select i.id_item, i.nome, i.descricao, i.preco, i.foto, i.itemsozinho, i.personalizacoesativas, m.id_menu
							from item_menus as im
							inner join menus m on m.id_menu=im.id_menu
							inner join itens i on i.id_item=im.id_item and i.itemsozinho = true
							inner join empresas e on e.id_empresa=m.id_estabelecimento 
							and REPLACE(LOWER(e.nome), ' ', '') LIKE LOWER(?) and m.id_menu=".$rowProd['id_menu'];

						$stmtMenu= $pdo->prepare($queryMenu);
						$stmtMenu->execute([$fRestaurante]);
						$itensMenus = $stmtMenu->fetchAll(PDO::FETCH_ASSOC);
					} else {
						$queryMenu = "SELECT itens.id_item, itens.nome, itens.descricao, itens.preco, itens.foto, itemsozinho, personalizacoesativas, 0 id_menu
							FROM itens 
							INNER JOIN estabelecimentos ON estabelecimentos.id_estabelecimento = itens.id_estabelecimento 
							INNER JOIN categorias ON categorias.id_categoria = itens.id_categoria 
							WHERE REPLACE(LOWER(estabelecimentos.nome), ' ', '') LIKE LOWER(?) and itens.id_item=".$rowProd['id_item'];
					
						$stmtMenu= $pdo->prepare($queryMenu);
						$stmtMenu->execute([$fRestaurante]);
						$itensMenus = $stmtMenu->fetchAll(PDO::FETCH_ASSOC);
					}
					
										
					foreach ($itensMenus as $rowit) {
						$idIndex++;
						echo "
						<div class='form-check form-switch product-item' style='display: flex; '>
							<input style=' width: 5%; height: 20px; margin-right: 15px; margin-top: -1px;' class='form-check-input' type='checkbox' name='itens[]' id='itens_".$idIndex."' value='".$idIndex."' checked>	
								<input type='hidden' name='itemid_".$idIndex ."' id='itemid_".$idIndex ."' value=".$rowit['id_item'] ."> 
								<label style='font-size: 1.5vh; font-weight: bold;  width: 74%;' class='form-check-label d-flex justify-content-start' for='itens_".$idIndex."'>".$rowit['nome']."</label>													
								<input style=' width: 10%; margin-top:-5px; height: 30px' class='form-control quantity-field' type='number' name='quantidade_".$idIndex."' id='quantidade_".$idIndex."' min='1' max='".$rowit['max_quantidade']."' value=1 >
								<input type='hidden' class='form-control' name='categoria_".$idIndex."' id='categoria_".$idIndex."' value='".$idCategoria."'> 
								<input type='hidden' class='form-control' name='idmenu_".$idIndex."' id='idmenu_".$idIndex."' value='".$rowit['id_menu']."'> 
								<input type='hidden' class='form-control price-field' name='preco_".$idIndex."' id='preco_".$idIndex."' value=".$rowit['preco']."> 
								<label style=' width: 10%; margin-left:2%; margin-bottom:1%;' class='form-check-label d-flex justify-content-start' >".$rowit['preco']." €</label>	
							</div>
						 
						";
						$queryOp = "select id_opcao, nome, max_quantidade, preco from opcoes where id_item='".$rowit['id_item']."'";

						
						$stmtExt= $pdo->prepare($queryOp);
						$stmtExt->execute();
						$opcoes = $stmtExt->fetchAll(PDO::FETCH_ASSOC);
							
						foreach ($opcoes as $rowop) {
							$idIndex++;
							echo "<div class='form-check form-switch product-item' style='display: flex; '>
							<input type='hidden' name='opcoes[]' id='opcao_".$idIndex."' value='".$rowop['id_opcao']."'> 
							<input style=' width: 4%; height: 20px; margin: 0px 10px 0px 5%;'  class='form-check-input' type='checkbox' name='opcao_".$idIndex."' id='opcao_".$idIndex."' value='".$rowop['id_opcao']."' checked>	
								<label style='width: 74%;' class='form-check-label d-flex justify-content-start' for='opcao_".$idIndex."'>".$rowop['nome']."</label>									
								<input type='hidden' class='form-control quantity-field' type='number' name='quantidade_".$idIndex."' id='quantidade_".$idIndex."' value=1 >								
								<input type='hidden' name='itemop_".$idIndex."' id='itemop_".$idIndex."' value=".$rowit['id_item']."> 
							</div>
							";
						}
						echo "<hr>";
					}
		
					echo "</div></div>
						<div class='justify-content-center mt-2' style='text-align: center;'>";
						if ($idCliente > 0) {
					echo 	" <label'>Total Pedido: <span  id='totalPedido'>" . $rowProd['preco'] . " </span> €</label> 
								<input type='hidden' class='total-item' name='valueItem' id='valueItem' value='" . $rowProd['preco'] . "'>
								<input type='hidden' class='total-container' name='valuePedido' id='valuePedido' value='" . $rowProd['preco'] . "'>
							<hr>
							<input class=' btn btn-primary btn-lg' type='submit' value='Adicionar ao carrinho'>
							</div>";
					
						}
						
					echo "</div>
					</div>
				</div>
				";
            }

            echo "  </div>
			</form>
            </div>

        </div>";
            }

        } catch (PDOException $e) {
          echo "Erro na conexão: " . $e->getMessage();
        }
        ?>
      </div>
	  
    </div>
  </div>
  </div>
  </div>
  </div> 


  <!-- Footer -->
  <?php
  include __DIR__ . "/includes/footer_1.php";
  ?>


  <!-- SCRIPT -->
  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>

        <?php foreach ($dados as $dado): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const toastTrigger<?php echo $dado['id']; ?> = document.getElementById('<?php echo $dado['trigger']; ?>');
            const toastLiveExample<?php echo $dado['id']; ?> = document.getElementById('<?php echo $dado['toast']; ?>');
            
            if (toastTrigger<?php echo $dado['id']; ?>) {
                const toastBootstrap<?php echo $dado['id']; ?> = bootstrap.Toast.getOrCreateInstance(toastLiveExample<?php echo $dado['id']; ?>);
                toastTrigger<?php echo $dado['id']; ?>.addEventListener('click', () => {
							
					 closeOtherToasts();
                    toastBootstrap<?php echo $dado['id']; ?>.show();
					
					
                });
            }
        });
        <?php endforeach; ?>

    document.querySelector("button#buttonPesquisarRestaurante").addEventListener("click", procurarRestaurante)

	function closeOtherToasts() {
		//para simplificar fexar todos os toast antes de abrir o que se pretende
        var closeButtons = document.querySelectorAll('button.btn-close');
		closeButtons.forEach(function(button) {
		  button.click();
		});
    }
	
    function procurarRestaurante() {
      let nomeRestaurante = document.querySelector("input#inputPesquisarRestaurante").value;
      console.log(nomeRestaurante)
      document.querySelector("input#inputPesquisarRestaurante").value = "";
    }


    let opcaoSelecionadaAnteriormente = null;

    function selecionarOpcao(event) {
      // Remove o sublinhado de todas as opções
      const links = document.querySelectorAll('.opcao');
      links.forEach(link => {
        link.style.textDecoration = 'none';
      });

      // Remove o negrito da opção anteriormente selecionada
      if (opcaoSelecionadaAnteriormente !== null) {
        opcaoSelecionadaAnteriormente.style.fontWeight = 'normal';
      }

      // Adiciona bold à opção selecionada e atualiza a referência para a opção selecionada anteriormente
      event.target.style.fontWeight = 'bold';
      opcaoSelecionadaAnteriormente = event.target;
    }


    // Adiciona o evento de clique a todas as opções
    const links = document.querySelectorAll('.opcao');
    links.forEach(link => {
      link.addEventListener('click', selecionarOpcao);
    });

    // Adiciona evento de clique a todas as opções do sidebar
    const sidebarOptions = document.querySelectorAll('.opcao');
    sidebarOptions.forEach(option => {
      option.addEventListener('click', selecionarOpcao);
    });



    //ISTO A PARTIR DE AGORA É DO TOAST DE AVALIAR ESTABELECIMENTO
    //SE PRECISARMOS DE COLOCAR ESTE SCRIPT NUM DOCUMENTO À PARTE TEMOS DE COLOCAR DEFER NO IMPORT DO SCRIPT PARA O HTML PARA O SCRIPT SER CORRIDO QUANDO ACABAR DE CARREGAR A PÁGINA HTML
    let avaliacao = 0;
    const stars = document.querySelectorAll(".stars i");
    stars.forEach((star, index1) => {
      star.addEventListener("click", () => {
        console.log(index1)
        avaliacao = index1 + 1;
        stars.forEach((star, index2) => {
          console.log(index2)
          index1 >= index2 ? star.classList.add("active") : star.classList.remove("active")
        })
      })
    })

    document.getElementById("btn_enviar_avaliacao").onclick = () => {
      console.log("Avaliação selecionada: " + avaliacao);
      
      const textarea = document.getElementById("input_text_comentario");
      let comentario = textarea.value;
      console.log("Comentário: " + comentario);

    }
	
	
	//Adicionar/atualizar valor do pedido
	// Adicione um ouvinte de evento para a mudança na quantidade
	const checkboxes = document.querySelectorAll('.form-check-input');
	const quantityFields = document.querySelectorAll('.quantity-field');

	// Adicione um ouvinte de evento para cada caixa de seleção
	checkboxes.forEach(function (checkbox) {
		checkbox.addEventListener('change', updateTotalPrice);
	});
	
	quantityFields.forEach(function (checkbox) {
		checkbox.addEventListener('input', updateTotalPrice);
	});

	function updateTotalPrice() {
		const totalPedido = parseFloat(document.querySelector('#totalPedido').textContent);   
		const valItem = parseFloat(document.querySelector('#valueItem').value);

		let total = valItem;
		// Verifique cada caixa de seleção
		checkboxes.forEach(function (checkbox, index) {
			//alert(JSON.stringify(checkboxes));
			if (checkbox.checked) {
				document.querySelector('#quantidade_' + checkbox.value).disabled =false;

				const quantity = parseFloat(document.querySelector('#quantidade_' + checkbox.value).value);

				if (quantity == 0) {
					document.querySelector('#quantidade_' + checkbox.value).value = 1;
					quantity = 1;
				}
				
				const catItem = document.querySelector('#categoria_' + checkbox.value).value;
				
				if (quantity > 1) {
					const price = parseFloat(document.querySelector('#preco_' + checkbox.value).value);
					total += (quantity * price);
				}
			} else {
				document.querySelector('#quantidade_' + checkbox.value).disabled =true;
				document.querySelector('#quantidade_' + checkbox.value).value = 0;
			}
		});

		// Atualize o preço total exibido
		document.querySelector('#totalPedido').textContent = total.toFixed(2);
		document.querySelector('#valuePedido').value = total.toFixed(2);
	}
		
	document.getElementById('pedidoForm').addEventListener('submit', function(event) {
        if (!confirm('Tem certeza de que deseja excluir este pedido?')) {
            event.preventDefault();
        }
    });	
  </script>

  <script src="./assets/js/toast.js"></script>
</body>

</html>