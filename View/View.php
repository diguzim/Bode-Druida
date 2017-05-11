<?php
class View {
	public function mostrarPagina($pagina) {
		//Incluindo o header da página e começo do código PHP
		include_once 'includes/header.php';
		
		switch ($pagina) {
			case 'inicio':
				include_once 'View/paginas/inicio.php';
				break;
			case 'produtos':
				include_once 'View/paginas/produtos.php';
				break;
			case 'produto':
				include_once 'View/paginas/produto.php';
				break;
			case 'carrinho':
				include_once 'View/paginas/carrinho.php';
				break;
			case 'cursos':
				include_once 'View/paginas/cursos.php';
				break;
			case 'blog':
				include_once 'View/paginas/blog.php';
				break;
			case 'contato':
				include_once 'View/paginas/contato.php';
				break;
			case 'novo_cadastro':
				include_once 'View/paginas/novo_cadastro.php';
				break;
			case 'cadastro_falha':
				include_once 'View/paginas/cadastro_falha.php';
				break;
			case 'login':
				include_once 'View/paginas/login.php';
				break;
			case 'sair':
				include_once 'View/paginas/sair.php';
				break;
			case 'sobre':
				include_once 'View/paginas/sobre.php';
				break;
			//Relativo ao admin
			case 'admin':
				include_once 'View/paginas/admin.php';
				break;
			case 'menu_admin':
				include_once 'View/paginas/menu_admin.php';
				break;
			case 'adicionar_produto':
				include_once 'View/paginas/adicionar_produto.php';
				break;
			//Página de erro, que é exibida pelo default
			case 'erro':
			default:
				include_once 'View/paginas/erro.php';
				
		}
		
		//Incluindo o footer da página e o fim do código PHP
		include_once 'includes/footer.php';
	}
	
	//Mostra um produto
	public function mostrarProduto($produto) {
		$id = $produto['id'];
		$nome = $produto['nome'];
		$preco = $produto['preco'];
		$img = $produto['img'];
		if (!$img) { //Caso não haja imagem, o valor dela no BD seja NULL
			$img = "imagemIndisponivel.png";
		}
		echo '
				<div class="produtoMiniatura">
					<a href="?pagina=produto&id=' . $id . '">
						<img src="_imagens/' . $img .'">
						<h1>' . $nome . '</h1>
						<h2>R$' . $preco . ',00</h2>
					</a>
				</div>';
	}
	
	//Mostrar uma categoria
	public function mostrarCategoria($categoria) {
		include_once 'Model.php';
		$model = new Model;
		
		$categoria_renomeada = preg_replace('/_/', ' ', $categoria);
		
		//Div que irá englobar toda uma categoria, a fins de formatação
		echo '<div class="categoriaMiniatura">';
		//HTML do titulo da categoria
		echo 
		'<div class="tituloCategoriaMiniatura">
			<a href="#">' . $categoria_renomeada . '</a>
		</div>';
		
		//HTML do conteúdo da categoria, os produtos
		$produtos = $model->retornarProdutosDaCategoria($categoria);
		foreach($produtos as $produto) {
			$this->mostrarProduto($produto);
		}
		echo '<div class="clear"></div>';
		echo '</div>';
	}
	
	//Mostrar uma categoria com a subcategoria
	public function mostrarSubcategoria($categoria, $subcategoria) {
		include_once 'Model.php';
		$model = new Model;
		
		//Essa variáve vai guardar o nome da categoria trocando sua sobrelinha original(devido ao DB e link) por um espaço
		$categoria_renomeada = preg_replace('/_/', ' ', $categoria);
		$subcategoria_renomeada = preg_replace('/_/', ' ', $subcategoria);
		
		//Div que irá englobar toda uma categoria, a fins de formatação
		echo '<div class="categoriaMiniatura">';
		//HTML do titulo da categoria
		echo
		'<div class="tituloCategoriaMiniatura">
			<a href="#">' . $categoria_renomeada . ' > ' . $subcategoria_renomeada . '</a>
		</div>';
		
		//HTML do conteúdo da categoria, os produtos
		$produtos = $model->retornarProdutosDaCategoria($subcategoria);
		foreach($produtos as $produto) {
			$this->mostrarProduto($produto);
		}
		echo '<div class="clear"></div>';
		echo '</div>';
	}
	
	//Mostrar página do produto, com todas suas informações
	
}