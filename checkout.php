<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'
        integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    <link rel='stylesheet' href='assets/styles/checkout.css'>
    <script src='assets/js/checkout.js'></script>
    <title>Checkout</title>
</head>

<body>
    <!-- NAVBAR -->
    <?php
	require_once __DIR__ . "/session.php";
	require_once __DIR__ . "/database/credentials.php";
	require_once __DIR__ . "/database/db_connection.php";
	
	if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['name']) || !isset($_SESSION['authenticated'])) {
		include __DIR__."/includes/header_restaurantes_selected.php";
	  }else{
		include __DIR__."/includes/header_logged_in.php";
		///validar id cliente por session
		$idCliente=$_SESSION['id_cliente'];
		$idIndex=240;
	}
	
	include __DIR__."/includes/deletePedido.php";
	include __DIR__."/includes/confirmPedido.php";

	///validar id cliente por session
	//$idCliente=$_SESSION['id_cliente'];
	$idCliente = 1;
	$totalPedido = 0;
	$idIndex=340;
	?>

    <div class='container' style='max-width: 100%;'>
        <div class='row justify-content-center'>
            <h1 class='checkout-title'>Checkout</h1>
        </div>

        <div class='d-flex flex-row align-items-center' style='margin-left: 15vw; margin-right: 15vw;'>
            <h2 class='burger-king-title' style='font-size: 2vw;'>Resumo do(s) pedido(s)</h2>
        </div>

        <div class='row justify-content-between' id='boxes' style='margin-left: 15vw; margin-right: 15vw;'>
            <div class='col-md-5 mb-3'>
                <div class='left-div'>
                    <div class='ResumoPedido'>
                        <?php	
try {
$queryPedRestaurantes = "select distinct e.nome as nomeEmpresa, e.logotipo, e.id_empresa
			from pedidos as p
			inner join clientes as c on c.id_cliente=p.id_cliente
			inner join empresas as e on e.id_empresa = p.id_estabelecimento
			where p.estado ='EM CHECKOUT'  and p.id_cliente = ? ";
			
$stmtPedRestaurantes = $pdo->prepare($queryPedRestaurantes);
$stmtPedRestaurantes->execute([$idCliente]);
$pedRestaurantes = $stmtPedRestaurantes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "Erro na conexão: " . $e->getMessage();
}					
foreach ($pedRestaurantes as $rowRestaurantes) {
	echo "<div class='d-flex flex-row align-items-center' style='border: solid 1px #000000;border-radius: 5px;padding: 15px;background-color: #000000;color: #ffffff;'>
			<img src='" . htmlspecialchars($rowRestaurantes['logotipo']) . "' alt='" . htmlspecialchars($rowRestaurantes['nomeempresa']). "' style='width: 7%; height: auto;'>
			<p class='resumo-pedido' class='burger-king-title' style='font-size: 1vw;margin-bottom: 0px; margin-left:3%; width:80%'>" .htmlspecialchars($rowRestaurantes['nomeempresa']). "</p>
		</div><br>
		";
try {
$queryPedidos = "select p.id_pedido, p.data, p.precototal, 
			c.nome, e.nome as nomeEmpresa, e.logotipo, e.id_empresa
			from pedidos as p
			inner join clientes as c on c.id_cliente=p.id_cliente
			inner join empresas as e on e.id_empresa = p.id_estabelecimento
			where p.estado ='EM CHECKOUT'  and p.id_cliente = ? and e.id_empresa = ?";
			
$stmtPed = $pdo->prepare($queryPedidos);
$stmtPed->execute([$idCliente,$rowRestaurantes['id_empresa']]);
$pedidos = $stmtPed->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "Erro na conexão: " . $e->getMessage();
}		

echo "
<form method='POST' enctype='multipart/form-data' action='' id='checkoutForm'>
			<input type='hidden' name='idForm' id='idForm' value='checkoutForm'> 
";			
foreach ($pedidos as $rowPed) {
	$totalPedido += $rowPed['precototal'];
	$idIndex++;
	echo "
	<input type='hidden' name='pedidos[]' id='pedido_".$idIndex."' value='".$idIndex."'>
	<input type='hidden' name='id_pedido_".$idIndex ."' id='id_pedido_".$idIndex ."' value='".$rowPed['id_pedido']."'>
	<input type='hidden' name='pedidosEmpresa[]' id='pedidosEmpresa_".$rowPed['id_empresa']."' value='".$rowPed['id_pedido']."'>
	";

	echo "
	<div style='width: 100%; height: 45px;'>
		<div class='align-items-center' style='float:left;'>
			<span class='resumo-pedido' class='burger-king-title' style='font-size: 1.25vw;margin-bottom: 0px;'>Pedido nº " .$rowPed['id_pedido']. " | " .$rowPed['data']. "</span> <br>
			<span class='resumo-pedido' class='burger-king-title' style='font-size: 1vw;margin-bottom: 0px;'>" .$rowPed['precototal']. " €</span>
		</div>
		<button type='button' class='btn btn-outline-danger' style='float:right;' onclick='deletePedido(".$rowPed['id_pedido'].")'>
			<i class='bi bi-trash'></i>X
		</button>
		<div style='float:none;'></div>
	</div><br>
	";

	$queryItens = "select pi.id_pedido_item, i.nome, i.descricao, pi.quantidade, coalesce(m.nome,'') menu
					from pedido_itens as pi
					inner join itens as i on i.id_item=pi.id_item
					left join menus as m on m.id_menu=pi.id_menu
					where pi.id_pedido=? ";

	$stmtItems = $pdo->prepare($queryItens);
	$stmtItems->execute([$rowPed['id_pedido']]);
	$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

	$printMenu = 0;
		
	foreach ($items as $rowItem) {
		if ($printMenu == 0 && !empty($rowItem['menu'])) {
			$printMenu++;
			echo "<span style='font-weight: bold; margin-top: 1vw; font-size: 0.87vw;'>Menu: " . htmlspecialchars($rowItem['menu']) . " </span> <br>";
		}
		echo "<span style='font-weight: bold; margin-top: 1vw; font-size: 0.87vw;'>" . $rowItem['quantidade'] . " * " . htmlspecialchars($rowItem['nome']) . " : </span> <br>";

		$queryItens = "select i.nome, pio.quantidade
						from pedido_item_opcoes as pio
						inner join opcoes as i on i.id_opcao=pio.id_opcao
						where pio.id_pedido_item = ? ";
						
		$stmtOpcoes = $pdo->prepare($queryItens);
		$stmtOpcoes->execute([$rowPed['id_pedido_item']]);
		$opcoes = $stmtOpcoes->fetchAll(PDO::FETCH_ASSOC);

		if (empty($opcoes)) {
			echo "<span style='margin-top-0.4vw; margin-bottom: 0.5vw; font-size: 0.87vw; margin-left:0.7vw'><i>sem opção</i></span> <br>";
		}
		foreach ($opcoes as $rowopcao) {
			echo "<span style='margin-top-0.4vw; margin-bottom: 0.5vw; font-size: 0.87vw; margin-left:0.7vw'><i>" . htmlspecialchars($rowopcao['nome']) . " + " . $rowopcao['quantidade'] . "</i></span> ";
		}
	}
	echo "<br>";
	$queryRest = "select id_estabelecimento, nome, localizacao, taxa_entrega 
					from estabelecimentos
					where id_empresa = ? ";
						
	$stmtRest = $pdo->prepare($queryRest);
	$stmtRest->execute([$rowPed['id_empresa']]);
	$restaurantes = $stmtRest->fetchAll(PDO::FETCH_ASSOC);
}			
	$idIndex++;
	echo "<br>
	<input type='hidden' name='restaurantes[]' id='restaurante_".$idIndex."' value='".$idIndex."'>	
	<input type='hidden' name='pedidosRestaurante' id='pedidosRestaurante_".$idIndex."' value='".$idsPedidos."'>	

	<label for='estabelecimento'>Restaurante Pedido:</label>
	<select class='form-select' name='estabelecimento_".$rowPed['id_empresa']."' id='estabelecimento_".$rowPed['id_empresa']."'>
		<option value='0' data-taxa-entrega=0>Escolha o Restaurante pretendido...</option>";
	foreach ($restaurantes as $rowRest) {
		echo "<option value='".$rowRest['id_estabelecimento']."' data-taxa-entrega=".$rowRest['taxa_entrega'].">".$rowRest['nome']." - ".$rowRest['localizacao']."</option>";
	}
	echo "</select><hr>";
}
?>
                    </div>
                    <div class='row'>
                        <div class='col'>
                            <hr class='linha'>
                        </div>
                    </div>
                    <div class='DetalhesEntrega'>
                        <h4 class='detalhes-entrega' style='font-size: 1.25vw;'>Detalhes da Entrega</h4>
                        <div class='row align-items-center'>
                            <div class='col-auto' style='margin-top: 0.65vw;'>
                                <img src='assets/stock_imgs/iconLocalizacao.png' alt='Imagem Exemplo' class='img-fluid' style='width: 1.6vw;'>
                            </div>
                            <div id='morada' class='col' style='margin-top: 0.65vw;'>
                                <p id='textoMorada' class='m-0' contenteditable='false' style='font-size: 0.87vw;'>Rua exemplo, Nº1, Aveiro</p>
                            </div>
                            <div class='col-auto' style='margin-top: 0.65vw;'>
                                <button type='button' class='btn btn-primary' id='btnMorada' onclick='editarMorada()'>Editar</button>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col'>
                            <hr class='linha'>
                        </div>
                    </div>
                    <div class='EstimativaEntrega'>
                        <h4 class='estimativa-entrega' style='font-size: 1.25vw;'>Estimativa para Entrega</h4>
                        <div class='row align-items-center opcaoEntrega selected' style='margin: 0.75vw 0vh' onclick='toggleSelectionEntrega(this)'>
                            <div class='col-auto'>
                                <img src='assets/stock_imgs/iconStandard.png' alt='Imagem Exemplo' class='img-fluid' style='width: 1.6vw;'>
                            </div>
                            <div class='col'>
                                <p class='m-0' style='font-size: 0.8vw;'>Standard</p>
                                <p class='m-0' style='font-size: 0.6vw;'>20-30min</p>
                            </div>
                        </div>
                        <div class='row align-items-center opcaoEntrega' style='margin: 0.75vw 0vh; pointer-events: none;' onclick='toggleSelectionEntrega(this)'>
                            <div class='col-auto'>
                                <img src='assets/stock_imgs/iconAgenda.png' alt='Imagem Exemplo' class='img-fluid' style='width: 1.6vw;'>
                            </div>
                            <div class='col-auto'>
                                <p class='m-0' style='font-size: 0.8vw;'>Agendar</p>
                                <p class='m-0' style='font-size: 0.6vw;'>Selecionar uma hora</p>
                            </div>
                            <i style='font-size: 0.5vw;'>opção temporariamente indisponível</i>
                        </div>
                    </div>
                    <div id='agendarHoraCampos' style='display: none;'>
                        <div class='row'>
                            <div class='col'>
                                <input type='time' class='form-control' placeholder='Selecione a hora'>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col'>
                            <hr class='linha' style='margin-top: 1.2vw;'>
                        </div>
                    </div>
                    <div class='Pagamento'>
                        <h4 class='pagamento' style='font-size: 1.25vw;'>Pagamento</h4>
                        <p style='margin-top: 0.7vw; font-size: 0.87vw;'>Escolher forma de pagamento:</p>
                        <div class='row align-items-center opcao' onclick='toggleSelection(this, "cartao")' style='padding: 0.4vw 0vh; margin: 0.75vw 0vh;'>
                            <div class='col-auto'>
                                <img src='assets/stock_imgs/iconCartao.png' alt='Imagem Exemplo' class='img-fluid' style='width: 1.6vw;'>
                            </div>
                            <div class='col'>
                                <p class='m-0' style='font-size: 0.82vw;'>Cartão de Crédito ou Débito</p>
                            </div>
                        </div>
                        <div class='row align-items-center opcao' style='margin: 0.75vw 0vh' onclick='toggleSelection(this, "mbway")'>
                            <div class='col-auto'>
                                <img src='assets/stock_imgs/iconMBWAY.png' alt='Imagem Exemplo' class='img-fluid' style='width: 1.6vw;'>
                            </div>
                            <div class='col'>
                                <p class='m-0' style='font-size: 0.82vw;'>MBWAY</p>
                            </div>
                        </div>
                        <div class='row align-items-center opcao' style='margin: 0.75vw 0vh' onclick='toggleSelection(this, "paypal")'>
                            <div class='col-auto'>
                                <img src='assets/stock_imgs/iconPaypal.png' alt='Imagem Exemplo' class='img-fluid' style='width: 1.6vw;'>
                            </div>
                            <div class='col'>
                                <p class='m-0' style='font-size: 0.82vw;'>PayPal</p>
                            </div>
                        </div>
                        <div id='cartaoCampos' style='display: none;'>
                            <div class='row'>
                                <div class='col'>
                                    <input type='text' class='form-control' placeholder='Nome do titular'>
                                </div>
                                <div class='col'>
                                    <input type='number' class='form-control' placeholder='Numero do cartão'>
                                </div>
                            </div>
                            <div class='row' style='margin-top: 0.7vw;'>
                                <div class='col'>
                                    <input type='date' class='form-control' placeholder='Data Validade'>
                                </div>
                                <div class='col'>
                                    <input type='number' class='form-control' placeholder='CVC'>
                                </div>
                            </div>
                        </div>
                        <div id='MBWAYCampos' style='display: none;'>
                            <div class='row'>
                                <div class='col'>
                                    <input type='tel' class='form-control' placeholder='Numero Telemovel'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-md-5'>
                <div class='right-div'>
                    <div class='Total Pedido'>
                        <h4 class='total-pedido' style='font-size: 1.25vw;'>Total do pedido</h4>
                        <div class='row align-items-center'>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <p class='m-0' style='font-size: 0.87vw;'>Subtotal:</p>
                            </div>
                            <div class='col' style='margin-top: 0.6vw;'>
                                <p class='m-0'></p>
                            </div>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <p class='m-0' style='font-weight: bold; font-size: 0.87vw;' data-sub-total=<?php echo $totalPedido; ?> id='subtotal'><?php echo number_format((float)$totalPedido, 2); ?> €</p>
                            </div>
                        </div>
                        <div class='row align-items-center'>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <p class='m-0' style='font-size: 0.87vw;'>Serviço:</p>
                            </div>
                            <div class='col' style='margin-top: 0.6vw;'>
                                <p class='m-0'></p>
                            </div>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <p class='m-0' style='font-weight: bold; font-size: 0.87vw;' data-taxa-servico='0,99' id='taxaServico'>0.99€</p>
                            </div>
                        </div>
                        <div class='row align-items-center'>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <p class='m-0' style='font-size: 0.87vw;'>Entrega:</p>
                            </div>
                            <div class='col' style='margin-top: 0.6vw;'>
                                <p class='m-0'></p>
                            </div>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <p class='m-0' id='totalTaxaEntrega' style='font-weight: bold; font-size: 0.87vw;'>0€</p>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col'>
                            <hr class='linha'>
                        </div>
                    </div>
                    <div class='TotalCodigo'>
                        <div class='row align-items-center'>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <h4 class='m-0' style='font-size: 1.25vw;'>Total:</h4>
                            </div>
                            <div class='col' style='margin-top: 0.6vw;'>
                                <p class='m-0'></p>
                            </div>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <h4 class='m-0' style='font-weight: bold; font-size: 1.25vw;' id='totalPedido'>0€</h4>
                            </div>
                        </div>
                        <div class='row align-items-center' style='margin-top: 1vw;'>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <img src='assets/stock_imgs/iconPromotion.png' alt='Imagem Exemplo' class='img-fluid' style='width: 1.6vw;'>
                            </div>
                            <div class='col' style='margin-top: 0.6vw;'>
                                <p class='m-0' style='font-size: 0.87vw;'>Adicionar código promocional</p>
                            </div>
                            <div class='col-auto' style='margin-top: 0.6vw;'>
                                <button type='button' class='btn btn-primary' id='btnCodigo' onclick='adicionarPromoCode()'>Adicionar</button>
                            </div>
                        </div>
                        <div id='addPromoCode' style='display: none;'>
                            <div class='row'>
                                <div class='col'>
                                    <input type='text' class='form-control' placeholder='Insira o código'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='text-center'>
                    <button type='submit' class='btn btn-primary' id='btnConfirmPagamento'>Confirmar Pagamento</button>
                </div>
                </form>
            </div>
        </div>
        <br><br><br><br><br>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
    <script>
        /*	//Adicionar/atualizar valor do pedido
		const selectBox = document.querySelectorAll('.form-select');

	// Adicione um ouvinte de evento para cada caixa de seleção
	selectBox.forEach(function (select) {
		select.addEventListener('change', updateTaxesPedido);
	});

	function updateTaxesPedido() {
		let totalTaxaEntrega = 0;
		// Verifique cada caixa de seleção
		selectBox.forEach(function (select) {
			var taxaEntrega = parseFloat(select.options[select.selectedIndex].getAttribute("data-taxa-entrega"));
			if (!isNaN(taxaEntrega)) {
				totalTaxaEntrega += taxaEntrega;
			}
		});

		// Atualize o preço total exibido
		document.querySelector('#totalTaxaEntrega').textContent = totalTaxaEntrega.toFixed(2) + ' €';
		
		var subTotal = parseFloat(document.querySelector('#subtotal').getAttribute("data-sub-total"));
		var taxaServico = parseFloat(document.querySelector('#taxaServico').getAttribute("data-taxa-servico"));
		
		var somaTotal = totalTaxaEntrega + subTotal + taxaServico
		document.querySelector('#totalPedido').textContent = somaTotal.toFixed(2) + ' €';
	}
	
	
	 document.getElementById('formDeletePedido').addEventListener('submit', function(event) {
        if (!confirm('Tem certeza de que deseja excluir este pedido?')) {
            event.preventDefault();
        }
    });
	
	let opcaoSelecionada = '';

    function toggleSelection(element, opcao) {
        opcaoSelecionada = opcao;
        document.querySelectorAll('.opcao').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');

        document.getElementById('cartaoCampos').style.display = opcao === 'cartao' ? 'block' : 'none';
        document.getElementById('MBWAYCampos').style.display = opcao === 'mbway' ? 'block' : 'none';
    }
	
	function validarPagamento() {
        if (opcaoSelecionada === 'cartao') {
            const nomeTitular = document.getElementById('nomeTitular').value;
            const numeroCartao = document.getElementById('numeroCartao').value;
            const dataValidade = document.getElementById('dataValidade').value;
            const cvc = document.getElementById('cvc').value;
            if (!nomeTitular || !numeroCartao || !dataValidade || !cvc) {
                return false;
            }
        } else if (opcaoSelecionada === 'mbway') {
            const numeroTelemovel = document.getElementById('numeroTelemovel').value;
            if (!numeroTelemovel) {
                return false;
            }
        }
        return true;
    }
	
	document.getElementById('btnConfirmPagamento').addEventListener('submit', function(event) {	
        if (!confirm('Tem certeza de que deseja confirmar o pedido?')) {
            event.preventDefault();
        }
    });	
	
	document.getElementById('checkoutForm').addEventListener('submit', function(event) {
		if (!validateForm()) {
			event.preventDefault();
		} else if (!confirm('Tem certeza de que deseja confirmar o pedido?')) {
			event.preventDefault();
		}
	});
	
	function validateForm() {
		let allValid = true;
		selectBox.forEach(function (select) {
			const taxaEntrega = parseFloat(select.options[select.selectedIndex].getAttribute("data-taxa-entrega"));
			if (isNaN(taxaEntrega) || taxaEntrega <= 0) {
				allValid = false;
			}
		});
		
		if (!validarPagamento()){
			allValid = false;
		}

		if (!allValid) {
			alert("Todos os pedidos devem ter um restaurante selecionado com uma restaurante de envio.");
		}
		//return allValid;
		return true;
	}
	*/

        function deletePedido(id_pedido) {
            if (confirm('Tem certeza de que deseja excluir este pedido?')) {
                // Cria um formulário dinamicamente
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "");

                // Cria um campo de entrada para o ID do pedido
                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", "id_toDelete");
                input.setAttribute("value", id_pedido);

                // Adiciona o campo ao formulário e envia o formulário
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>

</html>
