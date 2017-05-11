<div class="row">
	<!-- Incluindo o menu de categorias que fica a esquerda da página -->
	<?php 
	include_once 'includes/menuCategorias.php';
	?>
	<div class="col-sm-9">
		
		<div id="conteudo">
			<?php
			include_once 'Model.php';
			include_once 'View/View.php';
			$model = new Model;
			$view = new View;
			
			$categorias = ["Cosmeticos", "Licores", "Materia_prima", "Equipamentos"];
			$categoria = (isset($_GET['categoria'])) ? $_GET['categoria'] : '';
			$subcategoria = (isset($_GET['subcategoria'])) ? $_GET['subcategoria'] : '';
			
			if (isset($categoria) && in_array($categoria, $categorias)) {
				if ($subcategoria != '') {
					$view->mostrarSubcategoria($categoria, $subcategoria);
				} else {
					$view->mostrarCategoria($categoria);
				}
			} else {
				foreach ($categorias as $categoria) {
					$view->mostrarCategoria($categoria);
				}
			}
			
			?>
		</div><!-- Conteúdo -->
		
	</div>
</div>