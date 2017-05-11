<?php
if (isset($_POST['login_admin'])) {
	$login = $_POST['login_admin'];
	$senha = $_POST['senha_admin'];
	$controller = new Controller();
	$resultado = $controller->acessarAdmin($login, $senha);
	if ($resultado) {
		if(!isset($_SESSION)) session_start();
		
		$_SESSION['nome'] = $resultado['login'];
		$_SESSION['id'] = $resultado['id'];
		$_SESSION['admin'] = true;
		header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . '/?pagina=menu_admin');
		//Mudar pro hostinger
		//header("Location: " . "http://rodrigomarcondes.esy.es/Bode-druida/?pagina=menu_admin");
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
				<legend>Sessão de administrador</legend>
				<?php
				//Caso a tentativa de login tenha falhado
				if ($loginFalho) {
					echo '<p style ="font-weight:bold; color: red">Admin/senha não encontrado. Tente novamente.</style></p>';
				}
				?>
				<label>
					<span>Login</span>
					<input type="text" name="login_admin" required/>
				</label>
				<label>
					<span>Senha</span>
					<input type="password" name="senha_admin" required/>
				</label>
				<div class="botaoEnviar">
					<input type="submit" value="Entrar" id="entrar" name ="entrar"/>
				</div>
			</form>
		</div>
	</div>
</div>