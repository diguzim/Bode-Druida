<?php
//Se foi enviado um novo produto
if (isset($_POST['nome'])) {
	$nome = $_POST['nome'];
	$preco = $_POST['preco'];
	$qtd = $_POST['qtd'];
	$img = $_FILES['img']['name'];
	
	$controller = new Controller();
	$todasCategorias = $controller->retornarCategorias();
	$categorias = array();
	foreach($todasCategorias as $categoria) {
		$id = $categoria['id'];
		if(isset($_POST[$id])) {
			array_push($categorias, $id);
		}
	}
	$resultado = $controller->cadastrarProduto($nome, $preco, $qtd, $img, $categorias);
	
	//variável que irá armazenar o resultado da tentativa de armazenar o arquivo enviado
	$arquivoResultado = -1;
	if ($resultado) {
		$produtoAdicionado = true;
		// verifica se foi enviado um arquivo
		if (isset( $_FILES['img']['name']) && $_FILES['img']['error'] == 0 ) {
			$arquivo_tmp = $_FILES['img']['tmp_name'];
			$nomeArquivo = $_FILES['img']['name'];
				
			// Pega a extensão
			$extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION );
				
			// Somente imagens, .jpg;.jpeg;.gif;.png
			if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {
				// Concatena a pasta com o nome
				$destino = '_imagens/' . $nomeArquivo;
				// tenta mover o arquivo para o destino
				if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {
					$arquivoResultado = $destino;
				}
			}
			else {
				$arquivoResultado = 2;
			}
		}
		else {
			if ($arquivoResultado == -1) {
				$arquivoResultado = 1;
			}
		}
	}
	else {
		$produtoAdicionado = false;
	}
}
?>

<div class="row">
	<div class="col-sm-12">
		<div class="formularioGenerico">
			<form action="#" method="post" enctype="multipart/form-data">
				<fieldset>
					<?php 
					if (isset($produtoAdicionado)) {
						if ($produtoAdicionado) {
							echo '<p style ="font-weight:bold; color: blue">Produto adicionado com sucesso.</style></p>';
							if ($arquivoResultado == 1) {
								echo '<p style ="font-weight:bold; color: red">Você não enviou nenhum arquivo.</style></p>';
							}
							elseif ($arquivoResultado == 2) {
								echo '<p style ="font-weight:bold; color: red">Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png".</style></p>';
							}
							else {
								echo '<p style ="font-weight:bold; color: blue">Arquivo salvo com sucesso em : <strong>' . $arquivoResultado . '</strong><br /></style></p>';
							}
						}
						else {
							echo '<p style ="font-weight:bold; color: red">Erro no cadastro do produto.</style></p>';
						}
					}
					?>
					<legend>Adicionar produto</legend>
					<label>
						<span>Nome</span>
						<input type="text" name="nome" required/>
					</label>
					<label>
						<span>Preço</span>
						<input type="text" name="preco" required />
					</label>
					<label>
						<span>Quantidade</span>
						<input type="text" name="qtd" required />
					</label>
					<label>
						<span>Categoria e subcategoria</span>
					</label>
					<?php 
					$controller = new Controller();
					$categorias = $controller->retornarCategorias();
					foreach ($categorias as $categoria) {
						echo '<input style="width: auto;" type="checkbox" name="' . $categoria['id'] . '"> ' . $categoria['nome'] . '<br><br>';
					}
					?>
					<label>
						<span>Selecione uma imagem</span>
						<input type="file" name="img" />
					</label>
					<div class="botaoEnviar">
						<input type="submit" value="Enviar Produto" />
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>