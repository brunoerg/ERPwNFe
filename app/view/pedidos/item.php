
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action=""
		name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
					class="titleIcon" />
				<h6>
					Alterar &Iacute;tem -
					<?php echo $this->produto ?>
				</h6>
			</div>


			<div class="formRow">

				<label>Quantidade: </label> <input type="number"
					class="validate[required] soma" name="quantidade" id="carga"
					value="<?php echo $this->quantidade ?>" id="req" />
					

				<div class="clear"></div>
			</div>
			<div class="formRow">

				<label>Valor: </label> <input type="number"
					class="validate[required] " name="valor"
					value="<?php echo $this->valor ?>" id="req" />
					

				<div class="clear"></div>
			</div>

		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title=""
	class="wButton greenwB ml15 m10"
	style="margin: 18px 0 0 0; float: right;"> <span>Salvar</span> </a>

<a href="<?php echo URL ?>Blocos/Pedido/<?php echo $this->pedido ?>"
	title="" class="wButton bluewB ml15 m10"
	style="margin: 18px 18px 0 0; float: right;"> <span>Voltar</span> </a>
