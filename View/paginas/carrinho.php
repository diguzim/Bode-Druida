<?php
//Se não foi iniciada a SESSION
if(!isset($_SESSION)) {
	session_start();
}

//Se não foi iniciada o array de produtos
if (!isset($_SESSION['produtos'])) {
	$_SESSION['produtos'] = array();
}

//Se acabou de ser submetido um produto ao carrinho
if (isset($_POST['adicionar_produto_id'])) {
	$adicionar_produto_id = $_POST['adicionar_produto_id'];
	$_SESSION['produtos'][$adicionar_produto_id] = 1;
} elseif (isset($_POST['atualizar_qtd'])) {
	$id = $_POST['atualizar_quantidade_id'];
	$_SESSION['produtos'][$id] = $_POST['qtd'];
} elseif (isset($_POST['remover'])) {
	$id = $_POST['atualizar_quantidade_id'];
	unset($_SESSION['produtos'][$id]);
}
?>

<div class="row">
	<div class="col-sm-12">
		<div id="carrinho">
			<h1>Carrinho de produtos</h1>
			<table style="border: 1px solid black; width: 100%">
				<tr id="cabecalho">
					<th>Produto</th>
					<th>Preço</th>
					<th>Quantia</th>
					<th>Total</th>
				</tr>
				<?php
				$controller = new Controller();
				$preco_final = 0;
				foreach($_SESSION['produtos'] as $id => $qtd) {
					$produto = $controller->retornarProduto($id);
					
					$nome = $produto['nome'];
					$preco = $produto['preco'];
					$preco_total = $qtd * $preco;
					$preco_final += $preco_total;
					
					//Criando a variável com um nome mais compreensível para pegar o resultado do formulário.
					//O id é passado por meio de um campo escondido no formulário com o nome $atualizar_quantidade_id
					//A quantidade também é passada por meio de um campo escondido, com o id do produto seguido de underline seguido da nova quantidade 
					$atualizar_quantidade_id = $id;
					echo '	<form action="" method="post" enctype="multipart/form-data">
								<tr>
									<td>' . $nome . '</td>
									<td>' . 'R$'.$preco.',00' . '</td>
									<td>
										<input type="text" name=qtd value=' . $qtd . ' style="width: 30px;">
										<input type="submit" name=atualizar_qtd value="Atualizar"/>
										<input type="submit" name=remover value="Remover"/>
									</td>
									<td>' . 'R$'.$preco_total.',00' . '</td>
									<input type="hidden" name=atualizar_quantidade_id value=' . $atualizar_quantidade_id . '>
								</tr>
							</form>';
				}
				?>
				<tr style="border: 1px solid black;">
					<td></td>
					<td></td>
					<td></td>
					<td style="font-weight: bold;">R$<?php echo $preco_final; ?>,00</td>
				</tr>
			</table>
			
		</div>
	</div>
</div>