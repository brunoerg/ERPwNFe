<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
google.load('visualization', '1', {packages:['corechart']});

google.setOnLoadCallback(charts);

function charts(){

	vendasChart();
	comprasChart();


}

<?php echo $this->graficosVendas; ?>
<?php echo $this->graficosCompras; ?>
</script>
<!-- Validation form -->
<fieldset>

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
			class="titleIcon" />
			<h6>Relat&oacute;rio do Cliente</h6>
		</div>
		<div class="formRow">
			<label>Nome:<span class="req">*</span> </label>
			<div class="formRight">
				<?php echo $this->nome ?>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Cidade:<span class="req">*</span> </label>
			<div class="formRight">
				<?php echo $this->cidade ?>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Fone: </label>
			<div class="formRight">
				<?php echo $this->fone ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>CPF/CNPJ: </label>

			<div class="formRight">
				<?php echo $this->cpf ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Endere&ccedil;o: </label>
			<div class="formRight">
				<?php echo $this->endereco ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Forma de Pagamento:</label>
			<div class="formRight">
				<?php echo $this->formas[$this->pagamento]; ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Vendedor:</label>
			<div class="formRight">
				<?php echo $this->vendedor ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Localizac&otilde;es:</label>
			<div class="formRight">
				<?php echo $this->localizacao ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>

</fieldset>

<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
			class="titleIcon" />
			<h6>Gr&aacute;fico de Compras do Cliente</h6>
		</div>
		<div class='formRow'>

			<div class='formRight' id="vendasChart" style="width:95%;height:100%;margin:20px;">

			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>

			<div class='formRight' id="chart_div" style="width:95%;height:100%;margin:20px;">

			</div>
			<div class='clear'></div>
		</div>
	</div>
</fieldset>

<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
			class="titleIcon" />
			<h6>Cheques do Cliente</h6>
		</div>
		<div class="formRow">
			<label>Total: R$ <?php echo number_format($this->chequesCliente["total"],2,",","."); ?>  </label>
			<div class="formRight">
				<?php echo $this->chequesCliente["html"] ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</fieldset>
<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
			class="titleIcon" />
			<h6>Pedidos do Cliente</h6>
		</div>
		<div class="formRow">
			<label>Total: R$ <?php echo number_format($this->pedidos["total"],2,",","."); ?></label>
			<div class="formRight">
				<?php echo $this->pedidos["html"] ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</fieldset>


<a href='<?php echo URL ?>Clientes' title='' class='wButton bluewB ml15 m10' style='margin: 18px 18px 0 0; float: right;'> 
	<span>Voltar</span> 
</a>
