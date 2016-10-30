<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/dayCalendar.png" alt="" class="titleIcon" />
				<h6>Escolher Periodo</h6>
			</div>
			<div class="formRow">
				<label>M&ecirc;s:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="mes" id="mes"/> ex: 03
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Ano:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="ano" id="ano"/> ex: 2012
					<a href="javascript:document.cadastrar.submit()" title="" class="wButton bluewB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
						<span>Detalhar</span> 
					</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>NFe's Entrada - Total: ( <?php echo number_format($this->TotalEntrada,2,",",".") ?> )</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Numero</th>
				<th>Serie</th>
				<th>Remetente</th>
				<th>Emiss&atilde;o</th>
				<th>Valor</th>
				<th>XML</th>
				<th>PDF</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->listaEntrada;?>
		</tbody>
	</table>
</div>

<a href="<?php echo URL ?>RelatorioFiscal/Zip/Entradas-<?php echo $_POST["mes"]."-".$_POST["ano"] ?>" title="" class="wButton redwB ml15 m10" style="margin: 18px; float: right;"> 
	<img src='<?php echo Folder;?>images/icons/control/new/zip.png' alt='' height='32' style="float:left; margin-right:-20px;" /><span>  Download NFe's Entrada (ZIP)</span> 
</a>

<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>NFe's Saida - Total: ( <?php echo number_format($this->TotalSaida,2,",",".") ?> )</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Numero</th>
				<th>Serie</th>
				<th>Destinat&aacute;rio</th>
				<th>Data de Emiss&atilde;o</th>
				<th>Tipo</th>
				<th>Valor</th>
				<th>XML</th>
				<th>PDF</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
<a href="<?php echo URL ?>RelatorioFiscal/Zip/Saidas-<?php echo $_POST["mes"]."-".$_POST["ano"] ?>" title="" class="wButton redwB ml15 m10" style="margin: 18px; float: right;"> 
	<img src='<?php echo Folder;?>images/icons/control/new/zip.png' alt='' height='32' style="float:left; margin-right:-20px;" /><span>  Download NFe's Saida (ZIP)</span> 
</a>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Notas Avulsas de Saida - Total: ( <?php echo number_format($this->TotalAvulsas,2,",",".") ?> )</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>Numero</th>
				<th>Data de Emiss&atilde;o</th>
				<th>Valor</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->listaAvulsas;?>
		</tbody>
	</table>
</div>

<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Redu&ccedil;&otilde;es Z - Total: ( <?php echo number_format($this->TotalReducoes,2,",",".") ?> )</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>Cod.</th>
				<th>Contador</th>
				<th>Data de Emiss&atilde;o</th>
				<th>Valor</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->listaReducoes;?>
		</tbody>
	</table>
</div>

<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
			<h6>Relat&oacute;rio Fiscal do M&ecirc;s</h6>
		</div>
		<div class='formRow'>
			<label>Total Entrada:</label>
			<div class='formRight'>
				<?php echo number_format($this->TotalEntrada,2,",",".");?>
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>
			<label>Saida Necess&aacute;ria Aprox.:</label><span class="req">* Total Entrada + 30%</span>
			<div class='formRight'>
				<?php echo number_format(($this->TotalEntrada+($this->TotalEntrada*0.3)),2,",",".");?>
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>
			<label>Total Saida:</label>
			<div class='formRight'>
				<?php echo number_format(($this->TotalSaida + $this->TotalAvulsas+$this->TotalReducoes),2,",",".");?>
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>
			<label>Saldo do M&ecirc;s:</label><span class="req">* Saldo > 0: Debito de Notas / Saldo < 0: Saldo de Notas </span>
			<div class='formRight'>
				<?php echo  number_format($this->Saldo,2,",",".");?>
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>
			<label>Saldo Anterior</label><span class="req">* Saldo > 0: Debito de Notas / Saldo < 0: Saldo de Notas </span>
			<div class='formRight'>
				<?php echo  number_format($this->saldoAnterior,2,",",".");?>
			</div>
			<div class='clear'></div>
		</div>
		<div class='formRow'>
			<label>Saldo Final:</label><span class="req">* Saldo > 0: Debito de Notas / Saldo < 0: Saldo de Notas </span>
			<div class='formRight'>
				<?php echo  number_format(($this->Saldo+$this->saldoAnterior),2,",",".");?>
			</div>
			<div class='clear'></div>
		</div>
	</div>

</fieldset>