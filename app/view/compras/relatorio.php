<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
google.load('visualization', '1', {packages:['corechart']});

google.setOnLoadCallback(vendaChart);


<?php echo $this->graficosVenda; ?>


</script>
<style type="text/css">
#chart_div{
	width:95%;
	height: 100%;
}
#chart_div2{
	width:95%;
	height: 120%;
	background: transparent;
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

}
</style>

<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
				<h6>Escolher Periodo</h6>
			</div>

			<div class="formRow">
				<label>M&ecirc;s:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="mes" id="mes"
					id="req" /> ex: 03
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Ano:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="ano" id="ano"
					id="req" /> ex: 2013
				</div>
				<div class="clear"></div>
			</div>

		</form>

		<a href="javascript:document.cadastrar.submit()" title="" class="wButton bluewB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
			<span>Detalhar</span> 
		</a>
	</fieldset>
<a href="<?php echo URL;?>Pdf/Compras/<?php echo $this->mes."-". $this->ano;?>" target="_blank" title="" class="ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>
		<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='36' /> 
	</span> 
</a>
	<div class="widget" style="width: 100%; float: left; padding: 10px;">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
			<h6>Relat&oacute;rio de Compras</h6>
		</div>
		
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

		<fieldset style="width: 40%; min-width: 250px; float: left; padding: 10px;">

			<div class="widget">
				<div class="title exp">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Cart&atilde;o</h6>
				</div>
				<ul>
					<?php echo $this->cartao["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->cartao["valor"],2,",","."); ?></h6>
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


			<div class="widget">
				<div class="formRow">
					<span>Total de Compras</span>
					<div class="formRight"><?php echo "R$ ".number_format($this->TotalCompras,2,",",".");?></div>
				</div>
			</div>

			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
					<h6>Gr&aacute;fico</h6>
				</div>
				<div class='formRow' id="chart_div">
					
				</div>
				<div class='formRow' id="chart_div2">
					
				</div>
			</div>

		</div>


	</fieldset>



</div><br><br><br><br><br><br><br><br><br><br>