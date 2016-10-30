
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action=""
		name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
					class="titleIcon" />
				<h6>Novo Usu&aacute;rio</h6>
			</div>
			<div class="formRow">
				<label>Nome:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="nome"
						value="<?php echo $this->nome ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Login:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="login"
						value="<?php echo $this->login ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Senha:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="password" class="validate[required]" name="senha"
						id="password1" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Confirmar Senha:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="password" class="validate[required,equals[password]]"
						name="password2" id="password2" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title=""
	class="wButton greenwB ml15 m10"
	style="margin: 18px 0 0 0; float: right;"> <span>Salvar</span> </a>

<a href="<?php echo URL ?>Usuarios" title=""
	class="wButton bluewB ml15 m10"
	style="margin: 18px 18px 0 0; float: right;"> <span>Voltar</span> </a>
