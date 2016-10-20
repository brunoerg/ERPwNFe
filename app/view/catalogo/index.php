<br><br><a href="<?php echo URL;?>Catalogo/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> Novo Produto </span>
</a>

<a href="<?php echo URL ?>Pdf/CatalogoSimples" target="_blank" class="wButton bluewB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> 
		<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='16' />
		C&aacute;talogo Simples
	</span> 
</a>

<a href="<?php echo URL ?>Pdf/CatalogoCompleto" target="_blank" class="wButton redwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> 
		<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='16' />
		C&aacute;talogo Completo
	</span> 
</a>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>C&aacute;talogo de Produtos</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Fornecedor</th>
				<th>Peso</th>
				<th>Compra</th>
				<th>Venda</th>
				<th>Lucro</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
