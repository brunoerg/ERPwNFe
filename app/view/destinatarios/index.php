<br><br><a href="<?php echo URL;?>Destinatarios/Cadastrar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> Adicionar </span> 
</a>

<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Destinat&aacute;rios</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Razao</th>
				<th>CNPJ</th>
				<th>E-mail</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
