<br><br><a href="<?php echo URL ?>Pdf/Estoque" title=""
	class="wButton rednwB ml15 m10" style="margin: 18px 18px -13px 0;"
	target="_blank"> <span> Gerar Controle de Estoque (PDF)</span> </a>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
			class="titleIcon" />
		<h6>
			Lista de Estoque ( R$
			<?php echo number_format($this->total,2) ?>
			em Estoque )
		</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
		class="display dTable">
		<thead>
			<tr>
				<th>ID </th>
				<th>Nome</th>
				<th>Quantidade</th>
				<th>Valor</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
		<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
