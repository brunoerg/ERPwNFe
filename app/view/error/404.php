<!DOCTYPE html>
<html> 
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>Erro 404 - A p&aacute;gina <?php echo $_GET["var3"]; ?> n&atilde;o existe</title>
	<link href="<?php echo Folder ?>css/main.css" rel="stylesheet" type="text/css" />
</head>
<body class="nobg errorPage">
	<div class="errorWrapper">
		<span class="sadEmo"></span> 
		<span class="errorTitle">Desculpe, A p&aacute;gina <?php echo $_GET["var3"]; ?> n&atilde;o existe.</span> 
		<span class="errorNum offline">404</span> 
		<span class="errorDesc">Pe&ccedil;o que volte e desculpe-nos a inconveni&ecirc;ncia. Esta pagina pode ter mudado de nome ou n&atilde;o existir. <br>Contate o Desenvolvedor sobre este erro.</span> 
		<a href="<?php echo URL ?>" title="Voltar" class="wButton redwB ml15 m10" style="margin-left: 10px;">
			<span>Voltar para o in&iacute;cio</span> 
		</a>
	</div>
</body>
</html>
