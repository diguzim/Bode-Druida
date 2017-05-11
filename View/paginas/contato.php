<div class="row">
	<div class="col-sm-12">
		<div class="formularioGenerico">
			<form action="" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Fale Conosco</legend>
					<label>
						<span>Nome</span>
						<input type="text" name="nome" />
					</label>
					<label>
						<span>E-mail</span>
						<input type="text" name="email" />
					</label>
					<label>
						<span>Assunto</span>
						<input type="text" name="nome" />
					</label>
					<label>
						<span>Mensagem</span>
						<textarea name="mensagem" value="" cols="30" rows="5"></textarea>
					</label>
					
					<input type="hidden" name="acao" value="sendmessage" />
					<div class="botaoEnviar">
						<input type="submit" value="Enviar Mensagem" />
					</div>
				</fieldset>
			</form>
		</div><!-- Formulário de Contato -->
	</div>
</div>