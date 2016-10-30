
<fieldset>

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
			<h6>Detalhe do Financiamento</h6>
		</div>
		<div class="formRow">
			<label>Titulo: </label>
			<div class="formRight">
				<?php echo $this->titulo ?>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Banco: </label>
			<div class="formRight">
				<?php echo $this->banco ?>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Valor Financiado: </label>
			<div class="formRight">
				R$ <?php echo number_format($this->valor,2,",",".") ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Valor Parcela: </label>
			<div class="formRight">
				R$ <?php echo number_format($this->parcela,2,",",".") ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>N&ordm; de Parcelas: </label>
			<div class="formRight">
				<?php echo $this->nParcelas ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Taxas:</label>
			<div class="formRight">
				<?php echo $this->taxas; ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Juros/M&ecirc;s:</label>
			<div class="formRight">
				<?php echo $this->juros ?>%
			</div>
			<div class="clear"></div>
		</div>
		
	</div>

</fieldset>

<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
			<h6>Simula&ccedil;&atilde;o Financiamento</h6>
		</div>
		<div class='formRow'>
			<?php echo $this->simulacao; ?>
			<div class='clear'></div>
		</div>
		
	</div>
</fieldset>

<a href='<?php echo URL ?>Financiamentos' title='' class='wButton bluewB ml15 m10' style='margin: 18px 18px 0 0; float: right;'> 
	<span>Voltar</span> 
</a>
