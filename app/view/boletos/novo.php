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


});
</script>
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
				<h6>Cadastro de Boleto</h6>
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
				<label>Valor:<span class="req">*</span> </label>
				<div class="formRight">
					R$ <input type="number" name="valor" id="valor" value="<?php echo $this->valor ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Data de Emiss&atilde;o:</label>
				<div class="formRight">
					<input type="text" name="emissao" class="datepicker" value="<?php echo $this->emissao ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Vencimento:</label>
				<div class="formRight">
					<input type="text" name="vencimento" class="datepickerInline" value="<?php echo $this->vencimento ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>NFe N&ordm;:</label>
				<div class="formRight">
					<input type="text" style='width:50px;' name="NFe" id="NFe" value="<?php echo $this->NFe ?>" />
				</div>
				<div class="clear"></div>
			</div>

		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" id="submit" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Boletos" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
