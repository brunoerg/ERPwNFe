
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action=""
		name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
					class="titleIcon" />
				<h6>Saida de Estoque</h6>
			</div>
			<div class="formRow">
				<label>Nome:<span class="req">*</span> </label>
				<div class="formRight">
				<?php echo $this->nome ?>
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Quantidade Atual:<span class="req"></span> </label>
				<div class="formRight">
				<?php echo $this->quantidade ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Saida:<span class="req"></span> </label>
				<div class="formRight">
					<input type="number" class="" name="quantidade" id="req"
						autofocus="autofocus" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title=""
	class="wButton greenwB ml15 m10"
	style="margin: 18px 0 0 0; float: right;"> <span>Salvar</span> </a>

<a href="<?php echo URL ?>Estoque" title=""
	class="wButton bluewB ml15 m10"
	style="margin: 18px 18px 0 0; float: right;"> <span>Voltar</span> </a>
