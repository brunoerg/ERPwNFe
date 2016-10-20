<br><br><a href="<?php echo URL;?>Vales/Adicionar" title=""
	class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> <span>
		Cadastrar Vales </span> </a>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
			class="titleIcon" />
		<h6>Vales</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
		class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Funcion&aacute;rio</th>
				<th>Descri&ccedil;&atilde;o</th>
				<th>Valor</th>
				<th>Data</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
		<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
