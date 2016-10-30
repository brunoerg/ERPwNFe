<div style="width:100%; display:block; float:left;">
	<?=$this->lists?>	
</div>

<?php if(!$_GET["var3"]){?>
<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
			<h6>Relatório Bancário</h6>
		</div>
		<div class="formRow">
			<label>Movimentação Bancária</label>
			<div class="formRight">
				<ul>
					<li style="width:300px;float:left;display:block;margin:5px; border:solid 1px #CDCDCD;text-align:left;"><span style="margin-right:10px;padding:10px;background:#DFDFDF;width:15px;height:15px;text-align:center;color:green;display:block;float:left;">C</span><span style="margin-top:8px;display:block;" id="movimentacaoCredito">R$ 0,00</span></li>
					<li style="width:300px;float:left;display:block;margin:5px; border:solid 1px #CDCDCD;text-align:left;"><span style="margin-right:10px;padding:10px;background:#DFDFDF;width:15px;height:15px;text-align:center;color:red;display:block;float:left;">D</span><span style="margin-top:8px;display:block;" id="movimentacaoDebito">R$ 0,00</span></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Saldo de Movimentação Bancária:</label>
			<div class="formRight">
				<ul>
					<li style="width:300px;float:left;display:block;margin:5px; border:solid 1px #CDCDCD;text-align:left;" class="returnSaldos" id="saldoCredLi"><span style="margin-right:10px;padding:10px;background:#DFDFDF;width:15px;height:15px;text-align:center;color:green;display:block;float:left;">C</span><span style="margin-top:8px;display:block;" id="saldoCredito">R$ 0,00</span></li>
					<li style="width:300px;float:left;display:block;margin:5px; border:solid 1px #CDCDCD;text-align:left;" class="returnSaldos" id="saldoDebLi"><span style="margin-right:10px;padding:10px;background:#DFDFDF;width:15px;height:15px;text-align:center;color:red;display:block;float:left;">D</span><span style="margin-top:8px;display:block;" id="saldoDebito">R$ 0,00</span></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</fieldset>
<?php 
} ?>



<a href="<?php echo URL ?>Extratos" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: left;"> 
	<span>Voltar</span> 
</a>

<div id="Transferir" class="Transferir">
	<script type="text/javascript">
	$(function(){

		
		$(".pagamentos").hide();
		$("#divFornecedor").hide();


	/// mostra opcao de fornecedor
	$("#Compra").click(function(){
		$("#divFornecedor").slideDown("slow");
		$("#divTitulo").slideUp("slow");
		$("#divTipo").slideUp("slow");
	});

	/// elimina opçao Fornecedor
	$("#Despesa").click(function(){
		$("#divFornecedor").slideUp("slow");
		$("#divTitulo").slideDown("slow");
		$("#divTipo").slideDown("slow");
	});



	/// 0 = A Vista
	$("#pg0").click(function(){
		$(".pagamentos").slideUp("slow");

	});

	$("#pg5").click(function(){
		$(".pagamentos").slideUp("slow");

	});

	/// 1 = Boleto
	$("#pg1").click(function(){
		$(".pagamentos").slideUp("slow");
		$("#boleto").slideDown("slow");
	});

	
});
	</script>
	<!-- Validation form -->
	<fieldset>
		<form id="validate" class="form" method="post" action="" name="cadastrar">

			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
					<h6>Cadastrar Nova </h6>
				</div>
				<div class="formRow">
					<label>Modelo:<span class="req">*</span> </label>
					<div class="formRight">
						<input type="radio" name="modelo" id="Despesa" value="Despesas"/> <label for="Despesa">Despesa</label><input type="radio" name="modelo" id="Compra" value="Compras"/> <label for="Compra">Compra</label>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow" id="divFornecedor">
					<label>Fornecedor:<span class="req">*</span> </label>
					<div class="formRight">
						<select name="fornecedor" id="fornecedor">
							<option value="0">Selecione o Fornecedor</option>
							<?php echo $this->fornecedores ?>
						</select>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow" id="divTitulo">
					<label>Titulo:<span class="req">*</span> </label>
					<div class="formRight">
						<input type="text" class="validate[required]" name="titulo" id="titulo" value="<?php echo $this->titulo ?>"/>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Valor:<span class="req">*</span> </label>
					<div class="formRight">
						R$ <input type="number" name="valor" id="valor" value="<?php echo $this->valor ?>" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Data:</label>
					<div class="formRight">
						<input type="text" name="data" id="data" class="datepicker" value="<?php echo $this->data ?>" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow" id="divTipo">
					<label>Tipo:</label>
					<div class="formRight">
						<?php echo $this->tipos; ?>	
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Forma de Pagamento?</label>
					<div class="formRight">
						<?php echo $this->pagamentos ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">

					<!-- PAGAMENTOS BOLETO -->
					<fieldset>
						<div class="widget pagamentos" id="boleto">
							<div class="title">
								<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
								<h6>Pagamento Boleto</h6>
							</div>
							<div class="formRow">
								<label>Vencimento:</label>
								<div class="formRight">
									<input type="text" name="vencimento" id="vencimento" class="datepickerInline" value="<?php echo $this->vencimento ?>" />
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</fieldset>

					<!-- FIM PAGAMENTOS BOLETO -->
					<a title="" class="wButton greenwB ml15 m10 btSalvar" style="margin: 18px 0 0 0;cursor:pointer;">
						<span>Salvar</span> 
					</a>

					<a title="" class="wButton bluewB ml15 m10 btVoltar" style="margin: 18px 18px 0 0;cursor:pointer;">
						<span>Voltar</span> 
					</a>
				</div>

			</div>
		</form>

	</fieldset>

	

</div>

<script type="text/javascript">
$(function(){

	$(".returnSaldos").hide();

	function refresh(elementoBanco){
		if (elementoBanco) {
			$(".extrato"+elementoBanco).html("").slideUp(500);

			$(".load"+elementoBanco).html("<img src='<?=Folder?>images/icons/uploader/throbber.gif'>");
			var banco = $(".lista"+elementoBanco).attr("banco");
			$.post("<?=URL?>Extratos/"+elementoBanco,
			{
				banco:banco,
				id: <?=(($this->id==true) ? $this->id : 'false');?>,
				data: <?=(($this->id==false) ? "'".$_POST['mes']."-".$_POST['ano']."'" : 'false');?>

			},function(data){
				$(".load"+elementoBanco).html("<img src='<?=Folder?>images/icons/updateDone.png'>");
				$(".extrato"+elementoBanco).html(data);
				$(".topo"+elementoBanco).next().slideDown(500);
				totais();
			});
		}else{
			$(".extratos").html("").slideUp();

			$(".loadBB").html("<img src='<?=Folder?>images/icons/uploader/throbber.gif'>");
			var banco = $(".listaBB").attr("banco");
			$.post("<?=URL?>Extratos/BB",
			{
				banco:banco,
				id: <?=(($this->id==true) ? $this->id : 'false');?>,
				data: <?=(($this->id==false) ? "'".$_POST['mes']."-".$_POST['ano']."'" : 'false');?>

			},function(data){
				$(".loadBB").html("<img src='<?=Folder?>images/icons/updateDone.png'>");
				$(".extratoBB").html(data);
				$(".topoBB").next().slideDown(500);
				totais();

			});

			$(".loadItau").html("<img src='<?=Folder?>images/icons/uploader/throbber.gif'>");

			$.post("<?=URL?>Extratos/Itau",
			{
				banco:"Itau",
				id: <?=(($this->id==true) ? $this->id : 'false');?>,
				data: <?=(($this->id==false) ? "'".$_POST['mes']."-".$_POST['ano']."'" : 'false');?>

			},function(data){
				$(".loadItau").html("<img src='<?=Folder?>images/icons/updateDone.png'>");
				$(".extratoItau").html(data);
				$(".topoItau").next().slideDown(500);
				totais();
			});

		}

	}



	function totais(){
		if ( $("#bbCredTotal").text()!="" && $("#itauCredTotal").text()!="" ) {
			var bbcred =  parseFloat($("#bbCredTotal").attr("value"));
			var itaucred =  parseFloat($("#itauCredTotal").attr("value"));
			var totalCred = bbcred + itaucred;

			var campo = "#"

			formatarRs(totalCred,"#movimentacaoCredito");
		}

		if ( $("#bbDebTotal").text()!="" && $("#itauDebTotal").text()!="" ) {
			var bbDeb =  parseFloat($("#bbDebTotal").attr("value"));
			var itauDeb =  parseFloat($("#itauDebTotal").attr("value"));
			var totalDeb = bbDeb + itauDeb;

			var campo = "#"

			formatarRs(totalDeb,"#movimentacaoDebito");
		}
		var total =  totalCred - totalDeb;
		formatarTotalFinal(total);
	}

	function formatarRs(number,campo){
		if (number) {
			$.post("<?=URL?>Extratos/FormatRs",
			{
				number: number
			},function(data){
			//alert(data);
			$(campo).text("R$ "+data);
			return true;
		});
		}
	}

	function formatarTotalFinal(number){
		if (number) {
			$.post("<?=URL?>Extratos/FormatRs",
			{
				number: number
			},function(data){
			//alert(data);
			$(".returnSaldos").hide(500);
			if (number>=0) {
				$("#saldoCredito").text("R$ "+data);
				$("#saldoCredLi").show(1000);
			}else{
				$("#saldoDebito").text("R$ "+data);
				$("#saldoDebLi").show(1000);
			}
			return true;
		});
		}
		
	}

	refresh(false);

	$(".refresh").click(function(){
		var banco = $(this).attr("banco");
		refresh(banco);
	});

	$("#bgDark").click(function(){
		$('.Transferir').hide(1000,function(){
			$("#bgDark").fadeOut("slow");	
		});
	});

	$(".btVoltar").click(function(){
		$('.Transferir').hide(1000,function(){
			$("#bgDark").fadeOut("slow");	
		});
	});



	$(".btSalvar").click(function(){

		var modelo = $('input:radio[name=modelo]:checked').val();


		if($('input:radio[name=pagamento]').is(':checked')){
			var pagamento = parseInt($('input:radio[name=pagamento]:checked').val());

		}else{
			alert('Escolha um Tipo de Pagamento!');
			return false;
		}

		var data = $('#data').val();
		var valor = $('#valor').val();
		var vencimento = $('#vencimento').val();

		if (pagamento==1) {
			pago = 1;
		}else{
			pago=false;
		}

		if (modelo=="Compras") {
			var fornecedor = $("#fornecedor").val();


			$.post("<?=URL?>Compras/Adicionar",
			{
				data:data,
				valor:valor,
				fornecedor:fornecedor,
				pagamento:pagamento,
				vencimento:vencimento,
				pago:pago
			},
			function(retorno){
				alert("Compra Cadastrada com Sucesso!");
				$('.Transferir').hide(1000,function(){
					$("#bgDark").fadeOut("slow");	
				});
			});
		}else{
			var titulo = $('#titulo').val();

			if($('input:radio[name=tipo]').is(':checked')){
				var tipo = parseInt($('input:radio[name=tipo]:checked').val());

			}else{
				alert('Escolha um Tipo de Despesa!');
				return false;
			}

			if (pagamento==1) {
				pago = 1;
			}else{
				//pago=false;
			}


			$.post("<?=URL?>Despesas/Adicionar",
			{
				data:data,
				titulo:titulo,
				valor:valor,
				tipo:tipo,
				pagamento:pagamento,
				vencimento:vencimento,
				pago:pago
			},
			function(retorno){
				alert("Despesa Cadastrada com Sucesso!");
				$('.Transferir').hide(1000,function(){
					$("#bgDark").fadeOut("slow");	
				});
			});

		}
		
		
		
		
	});




});
</script>