<br><br><script type="text/javascript">
$(function(){

	$("#calcular").click(function(){

		

		var ValorFinanciado = $("#valor").val();
		var ValorParcela = $("#parcela").val();
		var Juros = (($("#juros").val())/100);
		var mes = $("#mes").val();
		var ano = $("#ano").val();

		

		$.post("<?php echo URL ?>Financiamentos/Simulacao",

		{
			ValorParcela: ValorParcela,
			ValorFinanciado: ValorFinanciado,
			Juros: Juros,
			mes: mes,
			ano: ano
		}, 

		function(data) { 

			//alert(data);
			$("tbody").html(data);
		}); 
	});	

});
</script>

<a href="<?php echo URL;?>Financiamentos" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>
		Voltar
	</span> 
</a>

<fieldset class="form">
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
			<h6>Simular Financiamento</h6>
		</div>
		<div class="formRow">
			<label>Valor Financiado:</label>
			<div class="formRight">
				R$ <input type="number" class="mudar" id="valor" name="valor" value="<?php echo $this->valor ?>" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Valor da Parcela:</label>
			<div class="formRight">
				R$ <input type="number" class="mudar" id="parcela" name="parcela" value="<?php echo $this->parcela ?>" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Juros:</label>
			<div class="formRight">
				<input type="number" class="mudar" id="juros" name="juros" value="<?php echo $this->juros ?>" /> %
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Data de Inicio:</label>
			<div class="formRight">
				<input type="number" class="mudar" name="mes" id="mes"/> /  .<input type="number" class="mudar" name="ano" id="ano"/> <input type="button" id="calcular" value="Calcular" >
			</div>

			<div class="clear"></div>
		</div>

	</div>


</fieldset>

<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Detalhes</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>N&ordm; Parcela</th>
				<th>Valor Parcela</th>
				<th>Data</th>
				<th>Restante</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div><br><br><br><br><br><br>