<br><br><a href="<?php echo URL;?>Fiado/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> Cadastrar Fiado </span> 
</a>

<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Fiados</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID </th>
				<th>Vendedor</th>
				<th>Ida</th>
				<th>Volta</th>
				<th>Data</th>
				<th>Balanço</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
