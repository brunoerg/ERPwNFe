<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>

	google.load('visualization', '1', {packages:['corechart']});

	google.setOnLoadCallback(charts);

	function charts(){

		despesasChart();
		fornecedoresChart();
		vendasChart();


	}

	<?php echo $this->graficosDespesas; ?>

	<?php echo $this->graficosFornecedores; ?>

	<?php echo $this->graficosVendas; ?>
</script>



<fieldset style="width: 30%; min-width: 200px; float: left; padding: 10px;">

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
			<h6>Cheques Ita&uacute; para o Dia</h6>
		</div>

		<?php echo $this->chequesitau?>

	</div>

</fieldset>
<fieldset style="width: 30%; min-width: 200px; float: left; padding: 10px;">

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
			<h6>Cheques BB para o Dia</h6>
		</div>
		<?php echo $this->chequesbb?>
	</div>

</fieldset>
<fieldset style="width: 30%; min-width: 200px; float: left; padding: 10px;">

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
			<h6>Vencimentos para o Dia</h6>
		</div>

		<?php echo $this->vencimentos?>
	</div>

</fieldset>

<fieldset style="width: 30%; min-width: 200px; float: left; padding: 10px;">

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
			<h6>Débitos em Conta para o Dia</h6>
		</div>
		<?php echo $this->debitos?>
	</div>

</fieldset>


<fieldset style="width: 30%; min-width: 200px; float: left; padding: 10px;">

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
			<h6>Boletos para o Dia</h6>
		</div>
		<?php echo $this->boletos?>
	</div>

</fieldset>

<fieldset style="width: 100%; float: left; padding: 10px;">

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
			<h6>Gr&aacute;ficos</h6>
		</div>

		<div>

			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
					<h6>Despesas</h6>
				</div>
				<div class='formRow'>
					
					<div class='formRight' id="despesasChart" style="width:95%;height:100%; margin:20px;">

					</div>
					<div class='clear'></div>
				</div>
				
			</div>

			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
					<h6>Fornecedores</h6>
				</div>
				<div class='formRow'>
					
					<div class='formRight' id="fornecedoresChart" style="width:95%;height:100%;margin:20px;">

					</div>
					<div class='clear'></div>
				</div>
			</div>

			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/graph.png" alt="" class="titleIcon" />
					<h6>Vendas</h6>
				</div>
				<div class='formRow'>
					
					<div class='formRight' id="vendasChart" style="width:95%;height:100%;margin:20px;">

					</div>
					<div class='clear'></div>
				</div>
			</div>


		</div>
	</div>

</fieldset>
<script type="text/javascript">
	$(function(){
		$("a.tipS").click(function () {

			var objeto = $(this);
			var parente = $(this).parent().parent().parent()

			url = $(this).attr("url");
			if ($(this).attr("vencido")) {
				Boxy.ask("Houve algum Juro/Tarifa devido ao atrazo?", ["Sim", "Não"], function(val) {
					if (val=="Não") {
						url = objeto.attr("url2");

						parente.animate({backgroundColor:"green", color: "#FFF"},1000,function(){
							$.get( url,function(data) {
								parente.slideUp(1000);
							});

						});
					}else{
						location.href=url
					}
				}, {
					title: 'Confirme a Operação!'
				});
			}else{
				parente.animate({backgroundColor:"green", color: "#FFF"},1000,function(){

					$.get( url,function(data) {

					});

					$(this).slideUp(1000);
				});
			}





		});
	});
</script>