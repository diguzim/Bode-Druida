<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Bode Druida Artesanais</title>
	<link rel="icon" href="_imagens/favicon.png" />
	<link href="css/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container" style="background-color: #FFFFFF">

<div class="row" style="border-bottom: 1px solid black;">
	<div id="loginECarrinho" class="col-sm-12 text-right">
		<p><span id="loginMsg">
			<?php
			if(!isset($_SESSION)) session_start();
			
			//Se é sessão de admin
			if (isset($_SESSION['admin'])) {
				echo 'Olá ' . $_SESSION['nome'] . '. Clique <a href="?pagina=menu_admin">aqui</a> para acessar o menu do administrador. <a href="?pagina=sair">Sair</a>.';
			}
			//Se é sessão de usuário logado
			elseif (isset($_SESSION['id'])) {
				echo
				'
				Olá ' . $_SESSION['nome'] . '. 
				Clique <a href="?pagina=login">aqui</a> para acessar sua conta. 
				<a href="?pagina=sair">Sair</a>.
				';
			}
			//Se for sessão de visitante
			else {
				echo
				'
				Olá Visitante.
				<a href="?pagina=novo_cadastro">Cadastre-se</a>
				ou <a href="?pagina=login">acesse sua conta</a>.
				';
			}
			?>
			<a href="?pagina=carrinho" style="text-decoration: none;"><img height="auto" width="auto%"
			src="_imagens/carrinho2.png" border="0"> (<span>
			<?php 
			if (!isset($_SESSION['produtos'])) {
				echo 'Carrinho vazio';
			}
			else {
				$num_produtos = 0;
				foreach($_SESSION['produtos'] as $id => $qtd) {
					$num_produtos++;
				}
				echo $num_produtos . ' itens no carrinho';
			}
			?>
			</span>)</a>
		</span></p>
	</div>
</div>

<div class="row">
	<div id="headerLogo" class="col-sm-2">
		<a href="index.php">
			<img src="_imagens/logo.png" border="0">
		</a>
	</div> <!-- headerLogo -->
	
	<div id="headerMenu" class="col-sm-7">
		<ul class="nav">
			<li><a href="?pagina=produtos">Produtos</a>
				<ul>
					<li><a href="?pagina=produtos&categoria=Cosmeticos">Cosméticos</a></li>
					<li><a href="?pagina=produtos&categoria=Licores">Licores</a></li>
					<li><a href="?pagina=produtos&categoria=Materia_prima">Matéria Prima</a></li>
					<li><a href="?pagina=produtos&categoria=Equipamentos">Equipamentos</a></li>
				</ul>
			</li>
			<li><a href="?pagina=cursos">Cursos</a></li>
			<li><a href="?pagina=blog">Blog</a></li>
			<li style="margin-right: 10px;"><a href="?pagina=contato">Contato</a></li>
		</ul>
	</div> <!-- headerMenu -->
	
	<div id="headerSearch" class="col-sm-3">
		<form action="" method="get">
			<input type="text" name="s" class="txt" />
			<input type="submit" value="" name="enviar" class="btn_search" />
		</form>
	</div><!-- HeaderSearch -->
	
</div>