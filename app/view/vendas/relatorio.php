<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
google.load('visualization', '1', {packages:['corechart']});

google.setOnLoadCallback(vendaChart);


<?php echo $this->graficosVenda; ?>

$(function(){

/*
	 * ///
	 * 
	 * 
	 * 
	 * 
	 * 
	 * sistema de busca para adicionar item ao balanco
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 */


	 
	 $("#busca").keyup(function(){

	 	var produto = $(this).val(); 

	 	if (produto!=0) {
	 		$("#resultado").html("<img src='../../app/public/images/icons/uploader/throbber.gif'>");
	 		$.post("../Pesquisar/<?php echo $_GET["var3"]?>", {
	 			produto: produto
	 		}, 

	 		function(data) { 
	 			$("#resultado").html(data); 

	 		}); //// ENCERRA POST
	 	}
	 });//// ENCERRA KEYUP	


	/*
	 * ///
	 * 
	 * 
	 * 
	 * 
	 * 
	 * FIM sistema de busca para adicionar item ao balanco
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 */

	});

</script>
<style type="text/css">
#chart_div, #chart_div2{
	width:95%;
	height:70%;
}

/** Hide jGrowl when printing **/
@media print {

	#leftSide, #footer, .topNav, .resp, .titleArea, .statsRow {
		display: none;
	}
	#chart_div, #chart_div2{
		width:95%;
		height:40%;
	}
	.wrapper {
		margin:0px 0px 0px 0px;
		width: 100%;
		height: 100%;
		background-color: #efefef;
	}

	}</style>


	<div class="widget" style="width: 100%; float: left; padding: 10px;">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
			<h6>Lista de Pedidos</h6>
		</div>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Fiado</h6>
				</div>
				<ul>
					<?php echo $this->venda["aprazo"]["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Total: R$ <?php echo number_format($this->venda["aprazo"]["total"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>A Vista</h6>
				</div>
				<ul>
					<?php echo $this->venda["avista"]["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Total: R$ <?php echo number_format($this->venda["avista"]["total"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Recebeu Fiado</h6>
				</div>
				<ul>
					<?php echo $this->venda["recebeu"]["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Total: R$ <?php echo number_format($this->venda["recebeu"]["total"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Cheque</h6>
				</div>
				<ul>
					<?php echo $this->venda["cheque"]["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Total: R$ <?php echo number_format($this->venda["cheque"]["total"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Boleto</h6>
				</div>
				<ul>
					<?php echo $this->venda["boleto"]["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6>Total: R$ <?php echo number_format($this->venda["boleto"]["total"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>
	</fieldset>


	<fieldset style="width: 100%; float: left; padding: 10px;">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
				<h6>Relat&oacute;rios</h6>
			</div>

			<div>

				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
						<h6>Dados</h6>
					</div>
					<div class='formRow'>
						<span>Vendas acima do preço: </span>
						<div class='formRight'>
							R$ <?php echo number_format($this->venda["acima"],2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>
					<div class='formRow'>
						<span>Descontos dados: </span>
						<div class='formRight'>
							R$ <?php echo number_format($this->venda["desconto"],2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>
					<div class='formRow'>
						<span>Diferen&ccedil;a:</span>
						<div class='formRight'>
							R$ <?php echo number_format(($this->venda["acima"]-$this->venda["desconto"]),2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>
					<div class='formRow'>
						<span>Faltou nos Pedidos:</span>
						<div class='formRight'>
							R$ <?php echo number_format(($this->diferencaDw),2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>
					<div class='formRow'>
						<span>Passou nos Pedidos:</span>
						<div class='formRight'>
							R$ <?php echo number_format(($this->diferencaUp),2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>
					<div class='formRow'>
						<span>Total da Venda Levada:</span>
						<div class='formRight'>
							R$ <?php echo number_format(($this->venda["totalGeral"]),2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>

					<div class='formRow'>
						<span>Total da Venda:</span>
						<div class='formRight'>
							R$ <?php echo number_format(($this->venda["total"]),2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>


					<div class='formRow'>
						<span>Lucro da Venda:</span>
						<div class='formRight'>
							R$ <?php echo number_format(($this->lucro),2,",","."); ?>
						</div>

						<div class='clear'></div>
					</div>

				</div>

				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
						<h6>Anota&ccedil;&atilde;o da Venda</h6>
					</div>
					
						<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
							<thead>
								<tr>
									<th>Descri&ccedil;&atilde;o </th>
									<th>Anota&ccedil;&atilde;o</th>
									<th>Pedidos</th>
									<th>Diferen&ccedil;a</th>
								</tr>

							</thead>
							<tbody>
								<tr class='gradeA'>
									<td class='center'>Dinheiro</td>
									<td class='center'>R$ <?php  echo number_format($this->VendaDinheiro,2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format(($this->venda["avista"]["total"]+$this->venda["recebeu"]["total"]),2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format(($this->venda["avista"]["total"]+$this->venda["recebeu"]["total"]-$this->VendaDinheiro),2,",","."); ?></td>
								</tr>
								<tr class='gradeB'>
									<td class='center'>Cheque</td>
									<td class='center'>R$ <?php  echo number_format($this->VendaCheque,2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format($this->venda["cheque"]["total"],2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format(($this->venda["cheque"]["total"]-$this->VendaCheque),2,",","."); ?></td>
								</tr>
								<tr class='gradeC'>
									<td class='center'>Boleto</td>
									<td class='center'>R$ <?php  echo number_format($this->VendaBoleto,2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format($this->venda["boleto"]["total"],2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format(($this->venda["boleto"]["total"]-$this->VendaBoleto),2,",","."); ?></td>
								</tr>
								<tr class='gradeD'>
									<td class='center'>Total</td>
									<td class='center'>R$ <?php  echo number_format(($this->VendaBoleto+$this->VendaCheque+$this->VendaDinheiro),2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format(($this->venda["boleto"]["total"]+$this->venda["avista"]["total"]+$this->venda["cheque"]["total"]+$this->venda["recebeu"]["total"]),2,",","."); ?></td>
									<td class='center'>R$ <?php  echo number_format((($this->venda["boleto"]["total"]+$this->venda["avista"]["total"]+$this->venda["cheque"]["total"]+$this->venda["recebeu"]["total"])-($this->VendaBoleto+$this->VendaCheque+$this->VendaDinheiro)),2,",","."); ?></td>
								</tr>
							</tbody>
						</table>
					

				</div>

				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
						<h6>Gr&aacute;fico</h6>
					</div>
					<div class='formRow charts'>

						<div  id="chart_div">

						</div>
						<div class='clear'></div>
					</div>
					<div class='formRow charts'>

						<div  id="chart_div2" class="charts">

						</div>
						<div class='clear'></div>
					</div>
				</div>


				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
						<h6>Produtos Vendidos</h6>
					</div>

					<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
						<thead>
							<tr>
								<th>ID </th>
								<th>Produto</th>
								<th>Quantidade</th>
								<th>Vendido Balan&ccedil;o</th>
								<th>Diferen&ccedil;a</th>
								<th>Diferen&ccedil;a R$</th>
							</tr>

						</thead>
						<tbody>
							<?php echo $this->produtosVendidos;?>
						</tbody>
					</table>
				</div>

			</div>
		</div>

	</fieldset>




	<fieldset style="width: 100%; float: left; padding: 10px;">


		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Buscar Produto por ID - ( <span id="nomeBuscado"></span> )</h6>
			</div>

			<div class="formRow">
				<div class="formRight form">
					Buscar: <input type="number" name="busca" id="busca" style="width: 40px;" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow"  id="resultado">
				
			</div>
		</div>
	</fieldset>


</div>