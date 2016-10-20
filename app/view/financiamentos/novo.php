<script type="text/javascript">
$(function() {

	$("#HidVendedor").hide();


	$("input[type=radio]").click(function() {

		$("#HidVendedor").hide("slow");

	});

	$("#1").click(function() {

		$("#HidVendedor").show("slow");

	});

});
</script>


<!-- Validation form -->

<form id="validate" class="form" method="post" action="" name="cadastrar">
	<fieldset>
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Novo Financiamento</h6>
			</div>
			<div class="formRow">
				<label>Titulo:</label>
				<div class="formRight">
					<input type="text" name="titulo" value="<?php echo $this->titulo ?>" id="req" />
				</div>
				<div class="clear"></div>
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
				<label>Valor Financiado:</label>
				<div class="formRight">
					R$ <input type="number" id="valor" name="valor" value="<?php echo $this->valor ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Valor da Parcela:</label>
				<div class="formRight">
					R$ <input type="number" id="parcela" name="parcela" value="<?php echo $this->parcela ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Taxas:</label>
				<div class="formRight">
					R$ <input type="number" name="taxas" id="taxas" value="<?php echo $this->taxas ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Juros:</label>
				<div class="formRight">
					<input type="number" id="juros" name="juros" value="<?php echo $this->juros ?>" /> %
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Data de Inicio:</label>
				<div class="formRight">
					<input type="text" name="dataInicial" id="dataInicial" class="datepicker" value="<?php echo $this->dataInicial ?>" />
				</div>

				<div class="clear"></div>
			</div>

		</div>


	</fieldset>
</form>
<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Financiamentos" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
