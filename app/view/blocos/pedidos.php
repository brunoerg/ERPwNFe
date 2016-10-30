<a href="<?php echo URL;?>Blocos/CriarPedido/<?php echo $_GET["var3"] ?>" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>	Criar Pedido </span> 
</a>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Bloco N&ordm; <?php echo $_GET["var3"]; ?> - Total: <?php echo number_format($this->total,2,",","."); ?>. </h6>
	</div>
	<div class="formRow">
		<h6>Relatorio Fiado: Pedidos Pagos: <?php echo $this->pagos; ?> | Pedidos em Aberto: <?php echo $this->abertos; ?> | Pedidos Parcialmente Pagos: <?php echo $this->parciais; ?></h6>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>N&ordm; </th>
				<th>Cliente</th>
				<th>Qnt. Produtos</th>
				<th>Valor</th>
				<th>Tipo</th>
				<th>Pago</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
<a href="<?php echo URL ?>Blocos/Lista" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>