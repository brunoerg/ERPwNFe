
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastro de Cart&atilde;o</h6>
			</div>

			<div class="formRow">
				<label>Bandeira:</label>
				<div class="formRight">
					<select name="bandeira">
						<option value="0">Selecione a Bandeira</option>
						<?php echo $this->bandeiras ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Nome:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="nome" id="nome" value="<?php echo $this->nome ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Dia de Vencimento:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required] " name="vencimento" value="<?php echo $this->vencimento ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Dia de Fechamento:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required] " name="fechamento" value="<?php echo $this->fechamento ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>


		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Cartao" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
