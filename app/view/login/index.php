<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>Painel Administrativo</title>
	<link href="<?php echo Folder ?>css/main.css" rel="stylesheet" type="text/css" />
</head>
<body class="nobg loginPage">
	<div class="loginWrapper">
		<div class="loginLogo" style="margin-left: -150px; margin-top: 0px;">
			<img src="<?php echo Folder ?>images/logo.png" alt="" />
		</div>
		<div class="widget" style="margin-top: 70;">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/key.png" alt="" class="titleIcon" />
				<h6>
					Acesso Restrito
					<?php echo $this->info; ?>
				</h6>
			</div>
			<form action="" name="login" method="post" id="validate" class="form">
				<fieldset>
					<div class="formRow">
						<label for="login">Usu&aacute;rio:</label>
						<div class="loginInput">
							<input type="text" name="login" class="validate[required]" id="login" />
						</div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<label for="pass">Senha:</label>
						<div class="loginInput">
							<input type="password" name="password" class="validate[required]" id="pass" />
						</div>
						<div class="clear"></div>
					</div>

					<div class="loginControl">
						<div class="rememberMe">
							<input type="checkbox" id="remMe" name="remMe" /><label for="remMe">Manter Conectado</label>
						</div>
						<input type="submit" value="Logar" class="dredB logMeIn" />
						<div class="clear"></div>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="anuncio"></div>
	</div>
	<div id="footer">
		<div class="wrapper">
			Bruno Garcia - OpenSource
			<br> &copy;
			<?php echo date("Y")?>
			Todos os direitos reservados.
		</div>
	</div>
</body>
</html>
