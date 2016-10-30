<br><br><a href="<?php echo URL;?>Cheques/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Cadastrar Cheque </span> 
</a>

<a href="<?php echo URL ?>Pdf/Cheques" target="_blank" class="wButton bluewB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> <img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='16' />Relat&oacute;rio de Cheques em PDF </span> 
</a>

<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
		class="titleIcon" />
		<h6>Cheques</h6>

	</div>

	<table cellpadding="0" cellspacing="0" border="0"
	class="display dTable">
	<thead>
		<tr>
			<th>N&uacute;mero</th>
			<th>Pago a</th>
			<th>Valor</th>
			<th>Data</th>
			<th>Compensa&ccedil;&atilde;o</th>
			<th>Banco</th>
			<th>Pago</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>

	</thead>
	<tbody>
		<?php echo $this->lista;?>
	</tbody>
</table>
<?php if (isset($this->total)) { ?>
<div class="title">

	<h6>
		Total: R$
		<?php echo number_format($this->total,2) ?>
	</h6>
</div>
<?php } ?>
</div>
