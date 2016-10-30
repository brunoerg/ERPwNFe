<script type="text/javascript">

	$(function(){



		$(".soma").change(function(){

			dinheiro = Number($("#dinheiro").val());
			deposito = Number($("#deposito").val());
			boleto = Number($("#boleto").val());
			cheque = Number($("#cheque").val());
			combustivel = Number($("#combustivel").val());
			hotel = Number($("#hotel").val());
			mecanico = Number($("#mecanico").val());
			outros = Number($("#outros").val());


			total = dinheiro + deposito + boleto + cheque + combustivel + hotel + mecanico + outros;



			$("#valor").html(total);
			$("#total").val(total);

		});



	})

</script>
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastro de Venda</h6>
			</div>

			<div class="formRow">
				<label>Vendedor:</label>
				<div class="formRight">
					<select name="vendedor">
						<option value="0">Selecione o Vendedor</option>
						<?php echo $this->vendedores ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Dinheiro: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="dinheiro" id="dinheiro" value="<?php echo $this->dinheiro ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Dep&oacute;sito: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="deposito" id="deposito" value="<?php echo $this->deposito ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Boleto: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="boleto" id="boleto" value="<?php echo $this->boleto ?>"
					/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Cheque: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="cheque" id="cheque" value="<?php echo $this->cheque ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Combustivel: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="combustivel" id="combustivel" value="<?php echo $this->combustivel ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Hotel: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="hotel" id="hotel" value="<?php echo $this->hotel ?>"
					/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Mec&acirc;nico: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="mecanico" id="mecanico" value="<?php echo $this->mecanico ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Outros: </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="outros" id="outros" value="<?php echo $this->outros ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Total: </label>
				<div class="formRight">
					R$ <span id="valor"><?php echo $this->total ?> </span> 
					<input type="hidden" class="validate[required]" name="total" id="total" value="<?php echo $this->total ?>" />
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
				<label>Balanço: </label>
				<div class="formRight">
					<input type="number" class="int" name="balanco" value="<?php echo $this->balanco ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>

		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Vendas" title=""class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a><br><br><br><br><br><br><br><br>
