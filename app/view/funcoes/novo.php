<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastro de Função na Empresa</h6>
			</div>
			<div class="formRow">
				<label>Nome da Função:</label>
				<div class="formRight">
					<input type="text" name="nome" id="nome" value="<?php echo $this->nome ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Comissionado?</label>
				<div class="formRight">
					<input type="checkbox" name="comissao" value="1" <?php echo (($this->comissao=="0" || !$this->comissao)? "" : "checked"); ?>/>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Funcao" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
