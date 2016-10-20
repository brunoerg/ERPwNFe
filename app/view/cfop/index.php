<br><br><a href="<?php echo URL;?>Municipios/Adicionar" title=""
	class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> <span>
		Cadastrar Cfop </span> </a>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
			class="titleIcon" />
		<h6>Municipios</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
		class="display dTable">
		<thead>
			<tr>
				<th>Codigo</th>
				<th>Nome</th>
				<th>Rota</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
		<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
