<br><br><script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>

google.load('visualization', '1', {packages:['corechart']});

google.setOnLoadCallback(Graficos);


<?php echo $this->graficos; ?>

$(function(){

	var saldo = parseFloat($(".saldo").text());

	if (saldo>0) {
		$(".saldo").css({"color":"green"});
	}else{
		$(".saldo").css({"color":"red"});
	}

});

</script>
<style type="text/css">
.chart_div{
	width:95%;
	height: 120%;
	background: transparent;
}

/** Hide jGrowl when printing **/
@media print {

	#leftSide, #footer, .topNav, .resp, .titleArea, .statsRow {
		display: none;
	}
	.hidden{
		display: none;	
	}
	
	.wrapper {
		margin:0px 0px 0px 0px;
		width: 100%;
		height: 100%;
		background-color: #efefef;
	}
	.chart_div{
		width:50%;
		height:40%;
		float: left;
		display: block;
	}
}
</style>

<fieldset class="hidden">
	<form id="validate" class="form" method="post" action="" name="cadastrar">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/dayCalendar.png" alt="" class="titleIcon" />
				<h6>Escolher Periodo</h6>
			</div>

			<div class="formRow">
				<label>M&ecirc;s:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="mes" id="mes" value="<?=date("m")-1?>" /> ex: 03
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Ano:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="ano" id="ano" value="<?=date("Y")?>" /> ex: 2013
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>

	<a href="javascript:document.cadastrar.submit()" title="" class="wButton bluewB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
		<span>Detalhar</span> 
	</a>
</fieldset>


<a href="<?php echo URL;?>Pdf/Fechamento/<?php echo $this->mes."-". $this->ano;?>" target="_blank" title=""  style="margin: 18px 18px -13px 0;"> 
		<span>
			<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='36' /> 
		</span> 
	</a>

<div class="widget" style="width: 100%; float: left; padding: 10px;">
	<div class="title exp">
		<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
		<h6>Relat&oacute;rio de Despesas [ Clique para Detalhar ]</h6>
	</div>
	<div>
		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Administrativas</h6>
				</div>
				<ul>
					<?php echo $this->Administrativas["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Administrativas["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Fixa</h6>
				</div>
				<ul>
					<?php echo $this->Fixas["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Fixas["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Imposto</h6>
				</div>
				<ul>
					<?php echo $this->Imposto["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Imposto["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Juros / Taxas</h6>
				</div>
				<ul>
					<?php echo $this->Juros["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Juros["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Combust&iacute;vel</h6>
				</div>
				<ul>
					<?php echo $this->Combustivel["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Combustivel["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Viagem</h6>
				</div>
				<ul>
					<?php echo $this->Viagem["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Viagem["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Mec&acirc;nico</h6>
				</div>
				<ul>
					<?php echo $this->Mecanico["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Mecanico["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 100%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Folha de Pagamento</h6>
				</div>

				<div class="formRow">
					<?php echo $this->folha; ?>
					<div class="clear"></div>
				</div>
				
			</div>

		</fieldset>


		

	</div>
</div>













<div class="widget" style="width: 100%; float: left; padding: 10px;">
	<div class="title exp">
		<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
		<h6>Relat&oacute;rio de Compras [ Clique para Detalhar ]</h6>
	</div>
	<div>
		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">A Vista</h6>
				</div>
				<ul>
					<?php echo $this->avista["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->avista["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Cheque</h6>
				</div>
				<ul>
					<?php echo $this->cheque["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->cheque["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Cheques de Clientes</h6>
				</div>
				<ul>
					<?php echo $this->chequeCliente["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->chequeCliente["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Boleto</h6>
				</div>
				<ul>
					<?php echo $this->boleto["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->boleto["valor"],2,",","."); ?></h6>
				</div>
			</div>

		</fieldset>

		<fieldset style='width: 40%; min-width: 250px; float: left; padding: 10px;'>

			<div class='widget'>
				<div class='title exp'>
					<img src='<?php echo Folder ?>images/icons/dark/money2.png' alt='' class='titleIcon' />
					<h6 style='cursor:pointer;'>Cart&atilde;o</h6>
				</div>
				<ul>
					<?php echo $this->cartao['html']; ?>
				</ul>
				<div class='title'>
					<img src='<?php echo Folder ?>images/icons/dark/money2.png' alt='' class='titleIcon' />
					<h6 style='cursor:pointer;'>Total: R$ <?php echo number_format($this->cartao['valor'],2,',','.'); ?></h6>
				</div>
			</div>

		</fieldset>



	</div>
</div>













<fieldset style="width: 100%; float: left; padding: 10px;">

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
			<h6>Relat&oacute;rios Totais</h6>
		</div>

		

		<div class="formRow">
			<span>Total de Despesas</span>
			<div class="formRight"><?php echo "R$ ".number_format($this->TotalDespesas,2,",",".");?></div>
		</div>
		<div class="formRow">
			<span>Total de Compras</span>
			<div class="formRight"><?php echo "R$ ".number_format($this->TotalCompras,2,",",".");?></div>
		</div>
		<div class="formRow">
			<span>Total de Vendas</span>
			<div class="formRight"><?php echo "R$ ".number_format($this->TotalVendas,2,",",".");?></div>
		</div>
		<div class="formRow">
			<span>Saldo</span>
			<div class="formRight"><?php echo "R$ <span class='saldo'>".number_format(($this->TotalVendas-($this->TotalCompras+$this->TotalDespesas)),2,",",".")."</span>";?></div>
		</div>

	</div>

</fieldset>

<fieldset style="width: 100%; float: left; padding: 10px;">

	
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
			<h6>Gr&aacute;ficos</h6>
		</div>
		<div class='formRow chart_div' id="despesasTipo">

		</div>
		<div class='formRow chart_div' id="despesasPagamento">

		</div>
		<div class='formRow chart_div' id="comprasFornecedores">

		</div>
		<div class='formRow chart_div' id="comprasPagamento">

		</div>
		<div class='formRow chart_div' id="Vendas">

		</div>

	</div>

	
</fieldset><br><br><br><br>

