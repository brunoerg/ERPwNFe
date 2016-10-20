<script>
$(function(){

	$("#NomeRemetente").keyup(function(){

		nome = $(this).val(); 


		if (nome=="") {
			$("#resultado").slideUp("slow");
		}else{
			$("#resultado").slideDown("slow");
			$("#resultado").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
			$.post("<?php echo URL; ?>NFe/GetRemetente",
				{nome: nome}, 
				function(data) { 
					$("#resultado").html(data); 


				});
		}
	});

	$("#chave").keyup(function(){

		var chave = $(this).val();
		
		if (chave[23]!="_") {
			var cnpj = chave.substr(7,17);
			cnpj = cnpj.replace(" ","");
			cnpj = cnpj.replace(" ","");
			cnpj = cnpj.replace(" ","");
			cnpj = cnpj.replace(" ","");
			$.post("<?php echo URL; ?>NFeEntrada/GetRemetenteCNPJ",
				{cnpj: cnpj}, 
				function(data) { 
					//alert(data);
					$("#idRemetente").val(parseInt(data)); 
				});
		}
		
		if (chave[30]!="_") {
			var serie = chave.substr(27,4).replace(" ","");
			$("#serie").val(parseInt(serie)); 
		}


		if (chave[30]!="_") {
			var Numero = chave.substr(31,11).replace(" ","");
			Numero = Numero.replace(" ","");
			Numero = Numero.replace(" ","");
			$("#numero").val(parseInt(Numero)); 
		}

	});


});
</script>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastrar NFe Entrada</h6>
			</div>
			<div class='formRow'>
				<label>Remetente:</label>
				<div class='formRight'>
					<input type='text' id="NomeRemetente"/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow' id="resultado">
			</div>
			<div class='formRow'>
				<label>ID Remetente:</label>
				<div class='formRight'>
					<input type='number' name='remetente' id='idRemetente' style='width:50px;' value='<?php echo $this->remetente; ?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>Numero NFe:</label>
				<div class='formRight'>
					<input type='number' name='numero' id='numero' style='width:50px;' value='<?php echo $this->numero; ?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>Serie NFe:</label>
				<div class='formRight'>
					<input type='number' name='serie'  id='serie' style='width:50px;' value='<?php echo $this->serie; ?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>Chave de Acesso:</label>
				<div class='formRight'>
					<input type='text' name='chave' id='chave' class="chaveNFe" value='<?php echo $this->chave; ?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<div class="formRow">
				<label>Data de Emiss&atilde;o:</label>
				<div class="formRight">
					<input type="text" name="emissao" class="datepicker" value='<?php echo $this->emissao; ?>'/>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>NFeEntrada/Listar" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
