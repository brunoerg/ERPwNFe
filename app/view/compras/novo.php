<script type="text/javascript">
	$(function(){

		$("#banco").change(function(){

			
			var banco = $("#banco").val();

		//alert(banco);
		
		$.post("<?php echo URL?>Cheques/Numero", 
		{ 
			banco: banco 
		},function(data) {
			$(".numeroChq").val(data); 
		});
	});


		$(".pagamentos").hide();

		$.post("<?php echo URL; ?>Compras/ChequesCLientes",
		{
			pagamento:3,
			chqcliente: "<?php echo $this->chqcliente; ?>"
		},function(data){
			$("#listaCheques").html(data);
		});


		var atual = 0;
		$(".chqclientes").click(function(){
			var valor = $(this).attr("valor");
			if ($(this).attr('checked')) {
				atual = atual + parseFloat(valor);
			}else{
				atual = atual - parseFloat(valor);
			}

			var total = $("#valor").val();

			restante = (total)-(atual);

			$("#totalCheques").fadeIn("slow",function(){

				$("#total").text(atual);
				if (restante>=0) {
					$("#restante").css("color","red");
				}else{
					$("#restante").css("color","green");
				}
				$("#restante").text(restante);
			});
			
		});

		
		$("#valor").keyup(function(){
			var valor = $(this).val();

			var ValorCheques = $("#total").text();
			if (ValorCheques=="") {
				ValorCheques=0;
			}

			restante = valor-ValorCheques;
			

			$("#totalCheques").fadeIn("slow",function(){

				if (restante>=0) {
					$("#restante").css("color","red");
				}else{
					$("#restante").css("color","green");
				}
				$("#restante").text(restante);
			});
			
		});




	/// 0 = A Vista
	$("#pg0").click(function(){
		$(".pagamentos").slideUp("slow");

	});

	/// 1 = Boleto
	$("#pg1").click(function(){
		$(".pagamentos").slideUp("slow");
		$("#boleto").slideDown("slow");
	});

	/// 2 = Cheque
	$("#pg2").click(function(){
		$(".pagamentos").slideUp("slow");
		$("#cheque").slideDown("slow");
	});
	$("#ChqBanco").hide();
	$("#ChqNumero").hide();
	$("#ChqComp").hide();
	$("#tipoChqNv").click(function(){
		$("#ChqBanco").slideDown("slow");
		$("#ChqNumero").slideDown("slow");
		$("#ChqComp").slideDown("slow");
	});
	$("#tipoChqRl").click(function(){
		$("#ChqBanco").slideUp("slow");
		$("#ChqNumero").slideDown("slow");
		$("#ChqComp").slideUp("slow");
	});

	/// 3 = Cheque de Cliente
	$("#pg3").click(function(){
		$(".pagamentos").slideUp("slow");
		$("#chqcliente").slideDown("slow");

		$.post("<?php echo URL; ?>Compras/ChequesCLientes",
		{
			pagamento:3,
			chqcliente: "<?php echo $this->chqcliente; ?>"
		},function(data){
			$("#listaCheques").html(data);
		});
	});

	/// 4 = Cartao
	$("#pg4").click(function(){
		$(".pagamentos").slideUp("slow");
		$("#cartao").slideDown("slow");
	});




	$(".formaDePagamento").each(function() {
		if ($(this).is(":checked")) {

			switch ($(this).val()) {
				case '0':
				$("#avista").slideDown("slow");
				break;

				case '1':
				$("#boleto").slideDown("slow");
				break;

				case '2':
				$(".tipodeChq").hide();
				$("#cheque").slideDown("slow");
				$("#ChqBanco").slideDown("slow");
				$("#ChqNumero").slideDown("slow");
				$("#ChqComp").slideDown("slow");
				break;

				case '3':
				$("#chqcliente").slideDown("slow");
				break;

				case '4':
				$("#cartao").slideDown("slow");
				break;
			}
		}
	});

	
});
</script>
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
				<h6>Cadastro de Compra</h6>
			</div>



			<div class="formRow">
				<label>Fornecedor:<span class="req">*</span> </label>
				<div class="formRight">
					<select name="fornecedor">
						<option value="0">Selecione o Fornecedor</option>
						<?php echo $this->fornecedores ?>
					</select>
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
					<input type="text" name="data" class="datepicker"	value="<?php echo $this->data ?>" />
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
								<input type="text" name="vencimento" class="datepickerInline" value="<?php echo $this->vencimento ?>" />
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</fieldset>

				<!-- FIM PAGAMENTOS BOLETO -->

				<!-- PAGAMENTOS CHEQUE -->
				<fieldset>
					<div class="widget pagamentos" id="cheque">
						<div class="title">
							<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
							<h6>Pagamento Cheque</h6>
						</div>
						<div class="formRow tipodeChq">
							<label>Cheque:</label>
							<div class="formRight">
								<label><input type="radio" name="tipoChq" id="tipoChqNv" value="0">Novo</label>
								<label><input type="radio" name="tipoChq" id="tipoChqRl" value="1">Relacionado</label>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow" id="ChqBanco">
							<label>Banco:</label>
							<div class="formRight">
								<select name="banco" id="banco">
									<option value="0">Selecione o Banco</option>
									<?php echo $this->bancos ?>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow" id="ChqNumero">
							<label>N&uacute;mero:<span class="req">*</span> </label>
							<div class="formRight">
								<input type="text" style="width:50px;" class="validate[required] soma numeroChq" name="numero" id="numero" value="<?php echo $this->numero ?>"/>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow" id="ChqComp">
							<label>Compensa&ccedil;&atilde;o:</label>
							<div class="formRight">
								<input type="text" name="para" class="datepickerInline" value="<?php echo $this->para ?>" />
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</fieldset>

				<!-- FIM PAGAMENTOS CHEQUE -->


				<!-- PAGAMENTOS CHEQUE CLIENTE-->
				<fieldset>
					<div class="widget pagamentos" id="chqcliente">
						<div class="title">
							<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
							<h6>Pagamento Cheque de Clientes <span id="totalCheques">( Total: R$ <span id="total"></span> | Restante: R$ <span id="restante"></span> )</span></h6>
						</div>
						<div class="formRow">
							<label>Cheques:</label>
							<div class="formRight" id="listaCheques">
								
							</div>
							<div class="clear"></div>
						</div>
						
					</div>
				</fieldset>

				<!-- FIM PAGAMENTOS CHEQUE CLIENTE-->

				<!-- PAGAMENTOS CARTAO-->
				<fieldset>
					<div class="widget pagamentos" id="cartao">
						<div class="title">
							<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
							<h6>Pagamento Cart&atilde;o</h6>
						</div>
						<div class="formRow">
							<label>Cart&atilde;o:</label>
							<div class="formRight">
								<select name="cartao" id="cartao">
									<option value="0">Selecione o Cart&atilde;o</option>
									<?php echo $this->cartoes ?>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Parcelas:<span class="req">*</span> </label>
							<div class="formRight">
								<input type="number" name="parcelas" value="<?php echo $this->parcelas ?>"/>
							</div>
							<div class="clear"></div>
						</div>
						
					</div>
				</fieldset>

				<?php
				if (isset($_GET["var3"])) {
					echo "<input type='hidden' name='oldPagamento' value='".$this->pagamento."'/>";
				}
				?>

				<!-- FIM PAGAMENTOS CARTAO -->

			</div>

		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Compras" title="" class="wButton bluewB ml15 m10"	style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
