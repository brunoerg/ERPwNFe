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
				<img src="<?php echo Folder ?>images/icons/dark/dayCalendar.png" alt="" class="titleIcon" />
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

	<a href="<?php echo URL;?>Pdf/Despesas/<?php echo $this->mes."-". $this->ano;?>" target="_blank" title="" class="ml15 m10" style="margin: 18px 18px -13px 0;"> 
		<span>
			<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='36' /> 
		</span> 
	</a>

	<div class="widget" style="width: 100%; float: left; padding: 10px;">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
			<h6>Relat&oacute;rio de Despesas</h6>
		</div>

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
					<h6 style="cursor:pointer;">Escritório</h6>
				</div>
				<ul>
					<?php echo $this->Escritorio["html"]; ?>
				</ul>
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
					<h6 style="cursor:pointer;">Total: R$ <?php echo number_format($this->Escritorio["valor"],2,",","."); ?></h6>
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
	</fieldset>


	<fieldset style="width: 100%; float: left; padding: 10px;">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
				<h6>Relat&oacute;rios</h6>
			</div>

			<div>

				<div class="widget">
					<div class="formRow">
						<span>Total de Despesas</span>
						<div class="formRight"><?php echo "R$ ".number_format($this->TotalDespesas,2,",",".");?></div>
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
		</div>

	</fieldset>



</div>