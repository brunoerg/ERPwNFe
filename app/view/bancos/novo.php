
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastro de Banco</h6>
			</div>

			<div class="formRow">
				<label>Numero:</label>
				<div class="formRight">
					<input type="text" style="width:100px;" name="numero" id="numero" value="<?php echo $this->numero ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Nome:</label>
				<div class="formRight">
					<input type="text" class="" name="nome" id="nome" value="<?php echo $this->nome ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Sibla:</label>
				<div class="formRight">
					<input type="text" style="width:100px;" name="abv" id="abv" value="<?php echo $this->abv ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Agência:</label>
				<div class="formRight">
					<input type="text" style="width:100px;" name="agencia" value="<?php echo $this->agencia ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Conta Corrente:</label>
				<div class="formRight">
					<input type="text" style="width:100px;" name="conta" value="<?php echo $this->conta ?>"/>
				</div>
				<div class="clear"></div>
			</div>


		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Bancos" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
