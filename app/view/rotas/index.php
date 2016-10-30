<br><br><a href="<?php echo URL;?>Rotas/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>	Cadastrar Rota </span> 
</a>
<a href="<?php echo URL;?>Municipios/Listar" title="" class="wButton redwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>	Listar Cidades </span> 
</a>

<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
			class="titleIcon" />
		<h6>Rotas</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
		class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Vendedor</th>
				<th>Descricao</th>
				<th>Cidades</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
		<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
