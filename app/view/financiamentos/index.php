<br><br><a href="<?php echo URL;?>Financiamentos/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>
		Novo Financiamento 
	</span> 
</a>

<a href="<?php echo URL;?>Financiamentos/Simular" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>
		Simular Financiamento 
	</span> 
</a>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Financiamentos</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Titulo</th>
				<th>Valor</th>
				<th>Parcela</th>
				<th>Data Inicial</th>
				<th>Data Final</th>
				<th>Banco</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>