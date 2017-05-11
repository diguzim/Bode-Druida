<?php
include_once 'View/View.php';
include_once 'Model.php';
class Controller {
	public function mostrarPagina($pagina) {
		$view = new View;
		$view->mostrarPagina($pagina);
	}
	
	public function cadastrarUsuario($nome, $login, $senha, $email) {
		$tag = 0; //Essa tag sinaliza se há algum problema;
		$resultado = [
				"nome" => 0,
				"login" => 0,
				"senha" => 0,
				"email" => 0,
				"cadastroComSucesso" => 0,
		];
		$view = new View;
		
		//Isso abaixo é para validar os dados. Se tudo der certo a variável $tag irá permanecer zero.
		//Caso der algum erro, será armazenado na variável $resultado que enviará
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$resultado["email"] = 2;
			$tag=1;
		}
		if($nome == '') {
			$resultado["nome"] = 1;
			$tag=1;
		}
		if($login == '') {
			$resultado["login"] = 1;
			$tag=1;
		}
		if($senha == '') {
			$resultado["senha"] = 1;
			$tag=1;
		}
		if($email == '') {
			$resultado["email"] = 1;
			$tag=1;
		}
		
		if ($tag==0) {
			$model = new Model;
			//Chama o método do model que irá tentar adicionar na BD
			$resultado["cadastroComSucesso"] = $model->cadastrarUsuario($nome, $login, $senha, $email);
		} 
		
		return $resultado;
	}
	
	public function acessarUsuario($login, $senha) {
		$model = new Model();
		$resultado = $model->acessarUsuario($login, $senha);
		return $resultado;
	}
	
	//Relativo de admin
	public function acessarAdmin($login, $senha) {
		$model = new Model();
		$resultado = $model->acessarAdmin($login, $senha);
		return $resultado;
	}
	
	public function cadastrarProduto($nome, $preco, $qtd, $img, $categorias) {
		$model = new Model();
		$resultado = $model->cadastrarProduto($nome, $preco, $qtd, $img, $categorias);
		return $resultado;
	}
	
	public function retornarCategorias() {
		$model = new Model();
		$resultado = $model->retornarCategorias();
		return $resultado;
	}
	
	public function retornarProduto($id) {
		$model = new Model();
		$produto = $model->retornarProduto($id);
		return $produto;
	}
}