<div class="row">
	<!-- Incluindo o menu de categorias que fica a esquerda da página -->
	<?php 
	include_once 'includes/menuCategorias.php';
	?>
	<div class="col-sm-9">
		<div id="tituloDestaque">
			<a href="#">Em destaque</a>
		</div>
		
		<div id="conteudo">
			<?php
			include_once 'Model.php';
			include_once 'View/View.php';
			$view = new View();
			$model = new Model();
			$idProdutos = array(1, 13, 3, 10, 11, 7); //Esse vetor deve conter os IDs dos produtos em destaque no banco de dados.
			$produtos = $model->retornaProdutosDaLista($idProdutos);
			foreach($produtos as $produto) {
				$view->mostrarProduto($produto);
			}
			?>
		</div><!-- Conteúdo -->
		
	</div>
</div>