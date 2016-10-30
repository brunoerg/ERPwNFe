<a href="<?php echo URL;?>NFe/Criar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Criar NFe </span> 
</a>




<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>NFe's</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Numero</th>
				<th>Serie</th>
				<th>Destinat&aacute;rio</th>
				<th>Data de Emiss&atilde;o</th>
				<th>Emiss&atilde;o</th>
				<th>XML</th>
				<th>PDF</th>
				<th>Editar Prod.</th>
				<th>Editar NFe</th>
				<th>Cancelar NFe</th>
				<th>Deletar NFe</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
