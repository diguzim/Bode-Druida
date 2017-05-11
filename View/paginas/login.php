<?php 
	if (isset($_POST['login'])) {
		$login = $_POST['login'];
		$senha = $_POST['senha'];
		$controller = new Controller();
		$resultado = $controller->acessarUsuario($login, $senha);
		if ($resultado) {
			if(!isset($_SESSION)) session_start();
			
			$_SESSION['nome'] = $resultado['nome'];
			$_SESSION['id'] = $resultado['id'];
			header("Location: " . "http://" . $_SERVER['HTTP_HOST']);
			//Hostinger
			//header("Location: " . "http://rodrigomarcondes.esy.es/Bode-druida/");
			
		}
		else {
			$loginFalho = true;
		}
	}
?>

<div class="row">
	<div class="col-sm-12">
		<div class="formularioGenerico">
			<form method="POST" action="#">
				<legend>Acesse sua conta</legend>
				<?php
				//Caso a tentativa de login tenha falhado
				if ($loginFalho) {
					echo '<p style ="font-weight:bold; color: red">Usuário/senha não encontrado. Tente novamente.</style></p>';
				}
				?>
				<label>
					<span>Login</span>
					<input type="text" name="login" required/>
				</label>
				<label>
					<span>Senha</span>
					<input type="password" name="senha" required/>
				</label>
				<div class="botaoEnviar">
					<input type="submit" value="Entrar" id="entrar" name ="entrar" />
				</div>
			</form>
		</div>
		<div class="clear"></div>
		<p><br>Não tem cadastro? Clique <a href="?pagina=novo_cadastro">aqui</a>.</p>
	</div>
</div>