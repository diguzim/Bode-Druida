<?php
include_once 'Controller.php';

//Vetor que define quais páginas poderão ser acessadas pelo campo pagina
$paginasPermitidas = array('inicio', 'produtos', 'produto', 'carrinho', 'cursos', 'blog', 'contato', 'sobre', 'novo_cadastro', 'login', 'sair', 'admin');

$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : '';

$controller = new Controller();

if(!isset($_SESSION)) {
		session_start();
}
//Caso seja uma sessão de administrador
if (isset($_SESSION['admin'])) {
	array_push($paginasPermitidas, 'menu_admin', 'adicionar_produto');
}
//Caso não seja sessão de administrador

//Caso uma ação esteja definida, primordialmente usada no caso do cadastro
if(isset($_GET['acao'])) {
	$nome = $_POST['nome'];
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	$email = $_POST['email'];
	$controller->cadastrarUsuario($nome, $login, $senha, $email);
} //Caso das páginas
elseif (!isset($pagina) || $pagina == '' || $pagina =='inicio') {
	$controller->mostrarPagina('inicio');
} elseif(isset($pagina) && in_array($pagina, $paginasPermitidas)) {
	$controller->mostrarPagina($pagina);
} else {
	$controller->mostrarPagina('erro');
}
