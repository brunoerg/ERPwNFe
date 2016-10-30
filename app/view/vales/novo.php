
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action=""
		name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt=""
					class="titleIcon" />
				<h6>Cadastro de Vale</h6>
			</div>



			<div class="formRow">
				<label>Funcion&aacute;rio:</label>
				<div class="formRight">
					<select name="funcionario">
						<option value="0">Selecione o Funcion&aacute;rio</option>
						<?php echo $this->funcionarios ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Descri&ccedil;&atilde;o:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required] soma" name="descricao"
						id="descricao" value="<?php echo $this->descricao ?>" id="req" />
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
				<label>Data:</label>
				<div class="formRight">
					<input type="text" name="data" class="datepicker"
						value="<?php echo $this->data ?>" />
				</div>
				<div class="clear"></div>
			</div>



		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title=""
	class="wButton greenwB ml15 m10"
	style="margin: 18px 0 0 0; float: right;"> <span>Salvar</span> </a>

<a href="<?php echo URL ?>Vales" title=""
	class="wButton bluewB ml15 m10"
	style="margin: 18px 18px 0 0; float: right;"> <span>Voltar</span> </a>
