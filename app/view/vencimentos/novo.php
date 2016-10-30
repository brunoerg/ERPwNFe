<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action=""
		name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt=""
					class="titleIcon" />
				<h6>Cadastro de Vencimento</h6>
			</div>



			<div class="formRow">
				<label>Cedente:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required] soma" name="cedente"
						id="cedente" value="<?php echo $this->cedente ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Valor:<span class="req">*</span> </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma"
						name="valor" id="valor" value="<?php echo $this->valor ?>"
						id="req" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Vencimento:</label>
				<div class="formRight">
					<input type="text" name="vencimento" class="datepicker"
						value="<?php echo $this->vencimento ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Fornecedor?</label>
				<div class="formRight">
					<input type="checkbox" name="fornecedor" class="" value="1"
					<?php echo $this->fornecedor ?> />
				</div>
				<div class="clear"></div>
			</div>


		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title=""
	class="wButton greenwB ml15 m10"
	style="margin: 18px 0 0 0; float: right;"> <span>Salvar</span> </a>

<a href="<?php echo URL ?>Vencimentos" title=""
	class="wButton bluewB ml15 m10"
	style="margin: 18px 18px 0 0; float: right;"> <span>Voltar</span> </a>
