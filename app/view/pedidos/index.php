<br><br><a href="<?php echo URL;?>Pedido/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Novo Pedido </span> 
</a>


<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Blocos</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
	<thead>
		<tr>
			<th>ID </th>
			<th>Fornecedor</th>
			<th>Data</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>

	</thead>
	<tbody>
		<?php echo $this->lista;?>
	</tbody>
</table>
</div>
