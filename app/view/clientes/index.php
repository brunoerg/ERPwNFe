<br><br><a href="<?php echo URL;?>Clientes/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Adicionar Cliente </span> 
</a>
<a href="<?php echo URL;?>Pdf/Clientes" title="" target="_blank" class="wButton bluewB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> 
		<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='16' />
		Relat&oacute;rio de Clientes
	</span>
</a>


<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
		class="titleIcon" />
		<h6>
			Clientes
		</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
	class="display dTable">
	<thead>
		<tr>
			<th>ID </th>
			<th>Nome</th>
			<th width="15%">CPF/CNPJ</th>
			<th>Cidade</th>
			<th>Vendedor</th>
			<th width="10%">A&ccedil;&otilde;es</th>
		</tr>

	</thead>
	<tbody>
		<?php echo $this->lista;?>
	</tbody>
</table>
</div>
