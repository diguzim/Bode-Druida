<div class="row">
	<div class="col-sm-12">
		<?php 
		if (isset($_POST['nome'])) {
			$nome = $_POST['nome'];
			$login = $_POST['login'];
			$senha = $_POST['senha'];
			$email = $_POST['email'];
			$controller = new Controller();
			$resultado = $controller->cadastrarUsuario($nome, $login, $senha, $email);
			
			if ($resultado["cadastroComSucesso"]) {
				echo '
		<h2 style="text-align: center;">Cadastro realizado com sucesso!<br></h2>
		<p style="text-align: center; font-size: 18px;">Clique <a href=?pagina=login>aqui</a> para fazer o login.</p>
					';
			}
			else {
				echo '
		<h2 style="text-align: center;">Erro no cadastro. Por favor tente mais tarde.</h2>
				';
			}
		}
		else {
			echo '
		<div class="formularioGenerico">
			<form action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Informe seus dados</legend>
				<label>
					<span>Nome</span>
					<input type="text" name="nome" required/>
				</label>
				<label>
					<span>Login</span>
					<input type="text" name="login" required/>
				</label>
				<label>
					<span>Senha</span>
					<input type="password" name="senha" required/>
				</label>
				<label>
					<span>E-mail</span>
					<input type="email" name="email" required/>
				</label>
				<div class="botaoEnviar">
					<input type="submit" value="Finalizar cadastro" id="cadastrar" name ="cadastrar" class="btn_send" />
				</div>
			</fieldset>
			</form>
		</div>			
					';
		}
		?>
	</div>
</div>