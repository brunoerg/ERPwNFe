<script type="text/javascript">
$(function(){
	$("#banco").change(function(){

		
		var banco = $("#banco").val();

		//alert(banco);
			
		$.post("<?php echo URL?>Cheques/Numero", 
			{ 
				banco: banco 
			},function(data) {
			$(".numeroChq").val(data); 
		});
			
	});
});
</script>
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
				<h6>Cadastro de Cheque</h6>
			</div>

			<div class="formRow">
				<label>Banco:</label>
				<div class="formRight">
					<select name="banco" id="banco">
						<option value="0">Selecione o Banco</option>
						<?php echo $this->vendedores ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>N&uacute;mero:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" style="width:50px;" class="validate[required] soma numeroChq" name="numero" id="numero" value="<?php echo $this->numero ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Pago a:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required] soma" name="quem"
					id="quem" value="<?php echo $this->quem ?>" id="req" />
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
					<input type="text" name="data" class="datepicker" value="<?php echo $this->data ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Compensa&ccedil;&atilde;o:</label>
				<div class="formRight">
					<input type="text" name="para" class="datepickerInline" value="<?php echo $this->para ?>" />
				</div>
				<div class="clear"></div>
			</div>

		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Cheques" title=""	class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
