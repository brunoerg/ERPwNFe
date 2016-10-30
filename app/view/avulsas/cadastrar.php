<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastrar Nota Avulsa</h6>
			</div>
			<div class='formRow'>
				<label>Numero NFe:</label>
				<div class='formRight'>
					<input type='number' name='id' style='width:50px;' value='<?php echo $this->id; ?>'<?php  if($this->id){echo "disabled";} ?>/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>Valor:</label>
				<div class='formRight'>
					R$ <input type='number' style='width:50px;' name='valor' id='valor' value='<?php echo $this->valor; ?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<div class="formRow">
				<label>Data de Emiss&atilde;o:</label>
				<div class="formRight">
					<input type="text" name="data" class="datepicker" value='<?php echo $this->data; ?>'/>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Avulsas/Listar" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
