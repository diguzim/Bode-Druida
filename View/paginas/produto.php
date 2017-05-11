<?php

$id = $_GET['id'];
$controller = new Controller();
$produto = $controller->retornarProduto($id);

$nome = $produto['nome'];
$img = $produto['img'];
if (!$img) { //Caso não haja imagem, o valor dela no BD seja NULL
	$img = "imagemIndisponivel.png";
}
$preco = $produto['preco'];
$descricao = $produto['descricao'];
?>

<div class="row">
	<div class="col-sm-12">
		<div id="produtoCompleto">
			<h1><?php echo $nome;?></h1>
			<img src="_imagens/<?php echo $img;?>" />
			<h2>R$<?php echo $preco;?>,00</h2>
			<p><?php echo $descricao;?></p>
			<div class="botaoEnviar">
				<form action="?pagina=carrinho" method="post" enctype="multipart/form-data">
					<img src="_imagens/carrinho.png" />
					<input type="hidden" value="<?php echo $id?>" name ="adicionar_produto_id" class="btn_send" />
					<input type="submit" value="Adicionar ao carrinho" name="adicionar_produto"/>
				</form>
			</div>
		</div>
	</div>
</div>