<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastro de Fiado</h6>
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
				<label>Ida:<span class="req">*</span> </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="ida" id="ida" value="<?php echo $this->ida ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Volta:<span class="req">*</span> </label>
				<div class="formRight">
					R$ <input type="number" class="validate[required] soma" name="volta" value="<?php echo $this->volta ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Balanço:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="int" name="balanco" value="<?php echo $this->balanco ?>" id="req" />
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

		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Fiado" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
