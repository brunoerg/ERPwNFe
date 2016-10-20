<script type="text/javascript">

$(function(){


	$("#Fornecedor").keyup(function(){

		nome = $(this).val(); 
		
		
		
		if (nome=="") {
			$("#compra").slideUp("slow");
		}else{
			$("#compra").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
			$.post("<?php echo URL; ?>Pedido/GetFornecedor",
				{nome: nome}, 
				function(data) { 
					$("#compra").html(data); 

					$("#compra").slideDown("slow");
				});
		}
	});



});
</script>
<!-- Validation form -->
<fieldset>
	<form id='validate' class='form' method='post' action=''
	name='cadastrar' enctype='multipart/form-data'>

	<div class='widget'>
		<div class='title'>
			<img src='<?php echo Folder ?>images/icons/dark/user.png' alt=''
			class='titleIcon' />
			<h6>Criar Novo Pedido de Compra</h6>
		</div>

		<div class='formRow'>
			<label>Buscar Compra Por Fornecedor:</label>
			<div class='formRight'>
				<input type='text' id="Fornecedor" autofocus/>
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow' id="">
			<div class='formRight' id="compra">
				
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>
			<label>ID Compra:</label>
			<div class='formRight'>
				<input type='number' name='compra' id='idCompra' style='width:50px;' value='<?php echo $this->compra; ?>'/>
			</div>
			<div class='clear'></div>
		</div>
		
	</div>
</form>

</fieldset>

<a href='javascript:document.cadastrar.submit()' title='' class='wButton greenwB ml15 m10' style='margin: 18px 0 0 0; float: right;'> 
	<span>Salvar</span> 
</a>

<a href='<?php echo URL ?>Pedido' title='' class='wButton bluewB ml15 m10' style='margin: 18px 18px 0 0; float: right;'> 
	<span>Voltar</span> 
</a>
