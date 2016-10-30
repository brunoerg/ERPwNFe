<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Nenhum retorno Selecionado ainda</h6>
			</div>
			<div class="formRow">
				<label>Selecione a ID de um Retorno:</label>
				<div class="formRight">
					<input type='number' class="int" name='retorno' />
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>
<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>
<a href="<?php echo URL ?>Balanco" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>