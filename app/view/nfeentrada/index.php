<a href="<?php echo URL;?>NFeEntrada/Cadastrar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Entrada de NFe </span> 
</a>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>NFe's de Entrada</h6>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Numero</th>
				<th>Serie</th>
				<th>Remetente</th>
				<th>Emiss&atilde;o</th>
				<th>XML</th>
				<th>PDF</th>
				<th>Buscar NFe</th>
				<th>Editar</th>
				<th>Deletar NFe</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>