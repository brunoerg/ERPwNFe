
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
				<h6>Juros</h6>
			</div>

			<div class="formRow">
				<label>Valor de Juros:<span class="req">*</span> </label>
				<div class="formRight">
					R$ <input type="number" name="valor" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Sem Juros:</label>
				<div class="formRight">
					<input type='checkbox' name='ignorar' value="1" />
				</div>
				<div class="clear"></div>
			</div>

		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Vencimentos" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;">
	<span>Voltar</span> 
</a>
