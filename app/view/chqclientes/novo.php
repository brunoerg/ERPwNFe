<script type="text/javascript">

$(function(){


	$("#NomeCliente").keyup(function(){

		nome = $(this).val(); 
		

		
		if (nome=="") {
			$("#cliente").slideUp("slow");
		}else{
			$("#cliente").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
			$.post("<?php echo URL; ?>Clientes/GetCliente",
				{nome: nome}, 
				function(data) { 
					$("#cliente").html(data); 

					$("#cliente").slideDown("slow");
				});
		}
	});


	$("#Avista").click(function(){
		$("#para").val($("#data").val());
	});


});
</script>
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action=""
	name="cadastrar" >

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt=""
			class="titleIcon" />
			<h6>Cadastro de Cheque</h6>
		</div>

		<div class="formRow">
			<label>Banco:</label>
			<div class="formRight">
				<select name="banco" id="banco">
					<option value="0">Selecione o Banco</option>
					<?php echo $this->bancos ?>
				</select>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>N&uacute;mero:<span class="req">*</span> </label>
			<div class="formRight">
				<input type="number" class="validate[required] soma numero"
				name="numero" id="numero" value="<?php echo $this->numero ?>"
				id="req" />
			</div>
			<div class="clear"></div>
		</div>
		<div class='formRow'>
			<label>Cliente:</label>
			<div class='formRight'>
				<input type='text' id="NomeCliente"/>
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow' id="">
			<div class='formRight' id="cliente">

			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>
			<label>ID Cliente:</label>
			<div class='formRight'>
				<input type='number' name='cliente' id='idCliente' style='width:50px;' value='<?php echo $this->cliente; ?>'/>
			</div>
			<div class='clear'></div>
		</div>
		<div class="formRow">
			<label>Pago a:<span class="req">*</span> </label>
			<div class="formRight">
				<input type="text" class="validate[required] soma" name="quem" id="quem" value="<?php echo $this->quem ?>" id="req" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Valor:<span class="req">*</span> </label>
			<div class="formRight">
				R$ <input type="number" class="validate[required] soma" name="valor" id="valor" value="<?php echo $this->valor ?>" id="req" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Data:</label>
			<div class="formRight">
				<input type="text" name="data" id="data" class="datepicker" value="<?php echo $this->data ?>" />
			</div>

			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Compensa&ccedil;&atilde;o:</label>
			<div class="formRight">
				<input type="text" name="para" id="para" class="datepickerInline" value="<?php echo $this->para ?>" />
				<label for="Avista">A Vista <input type="checkbox" id="Avista"></label>
			</div>
			<div class="clear"></div>
		</div>

	</div>
</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>ChequesClientes" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a><br><br><br><br><br><br>
