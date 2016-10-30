<!-- Validation form -->

<form id="validate" class="form" method="post" action=""
	name="cadastrar" >
	<fieldset>
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
					class="titleIcon" />
				<h6>Novo Veiculo</h6>
			</div>
			<div class="formRow">
				<label>Motorista:</label>
				<div class="formRight">
					<select name="motorista">
						<option value="0">Selecione o Motorista</option>
						<?php echo $this->funcionarios ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Descri&ccedil;&atilde;o do Veiculo:<span class="req">*</span>
				</label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="descricao"
						value="<?php echo $this->descricao ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Placa:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required] placa" name="placa"
						value="<?php echo $this->placa ?>" id="placa" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>UF:<span class="req">*</span> </label>
				<div class="formRight">
					<select name="uf">
						<option value="0">Selecione o Estado</option>
						<?php echo $this->ufs ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Renavam:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" id="renavam"
						name="renavam" value="<?php echo $this->renavam ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Chassi:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" id="chassi"
						name="chassi" value="<?php echo $this->chassi ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Ano Fabrica&ccedil;&atilde;o:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="fabricacao"
						id="fabricacao" value="<?php echo $this->fabricacao ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Ano Modelo:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" id="modelo"
						name="modelo" value="<?php echo $this->modelo ?>" />
				</div>
				<div class="clear"></div>
			</div>


		</div>


	</fieldset>

</form>
<a href="javascript:document.cadastrar.submit()" title=""
	class="wButton greenwB ml15 m10"
	style="margin: 18px 0 0 0; float: right;"> <span>Salvar</span> </a>

<a href="<?php echo URL ?>Veiculos" title=""
	class="wButton bluewB ml15 m10"
	style="margin: 18px 18px 0 0; float: right;"> <span>Voltar</span> </a>
<br><br><br><br><br><br>
