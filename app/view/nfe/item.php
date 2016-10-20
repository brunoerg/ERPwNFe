<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>
					Alterar &Iacute;tem -
					<?php echo $this->produto ?>
				</h6>
			</div>
			<div class="formRow">
				<label>Quantidade: </label> 
				<div class='formRight'>
					<input type="number" name="qCom" value="<?php echo $this->qCom ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Valor: </label> 
				<div class='formRight'>
					<input type="number" name="vUnCom" value="<?php echo $this->vUnCom ?>" id="req" />
				</div>
				<div class="clear"></div>
			</div>
			<div class='formRow'>
				<label>CFOP:</label>
				<div class='formRight'>
					<input type="number" name="CFOP" value="<?php echo $this->CFOP ?>" id="req" />
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>CST:</label>
				<div class='formRight'>
					<input type="number" name="CST" value="<?php echo $this->CST ?>" id="req" />
				</div>
				<div class='clear'></div>
			</div>
		</div>
	</form>
</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;">
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>NFe/Produtos/<?php echo $this->NFe ?>" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
