<script type="text/javascript">

$(function(){


	$("#NomeCliente").keyup(function(){

		nome = $(this).val(); 
		

		
		if (nome=="") {
			$("#cliente").slideUp("slow");
		}else{
			$("#cliente").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
			$.post("<?php echo URL; ?>Blocos/GetCliente",
				{nome: nome, bloco:<?php echo $_GET["var3"]; ?>}, 
				function(data) { 
					$("#cliente").html(data); 

					$("#cliente").slideDown("slow");
				});
		}
	});


	/**********************************************************************************/

	$("#vencimento").hide();

	$("#chqs").hide();
	
	$(".radios").click(function(){
			if ($(this).val()==1){
				$("#vencimento").slideDown(500);
				$("#chqs").slideUp(500);
			}else if ($(this).val()==2){
				$("#vencimento").slideUp(500);
				$("#chqs").slideDown(500);
			}else{
				$("#vencimento").slideUp(500);
				$("#chqs").slideUp(500);
			}
	});


});
</script>
<!-- Validation form -->
<fieldset>
	<form id='validate' class='form' method='post' action='' name='cadastrar'>

		<div class='widget'>
			<div class='title'>
				<img src='<?php echo Folder ?>images/icons/dark/user.png' alt='' class='titleIcon' />
				<h6>Criar Pedido</h6>
			</div>

			<div class='formRow'>
				<label>Cliente:</label>
				<div class='formRight'>
					<input type='text' id="NomeCliente" autofocus/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow' id="">
				<div class='formRight' id="cliente">
					
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>ID Cliente:</label>
				<div class='formRight'>
					<input type='number' name='cliente' id='idCliente' style='width:50px;' value='<?php echo $this->cliente; ?>'/>
				</div>
				<div class='clear'></div>
			</div>

			<div class='formRow'>
				<label>Numero:</label>
				<div class='formRight'>
					<input type='number' name='numero' style='width:50px;' step=1 value='<?php echo $this->numero; ?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>Data:</label>
				<div class='formRight'>
					<input type='text' name='data' class='datepicker'/>
				</div>
				<div class='clear'></div>
			</div>

			<div class='formRow'>
				<label>Forma de Pagamento:</label>
				<div class='formRight'>
					<input type='radio' class="radios" id="avista" name='pagamento' value="0" /><label for="avista">A Vista </label>

					<input type='radio' class="radios" id="aprazo" name='pagamento' value="1" /><label for="aprazo">A Prazo </label>

					<input type='radio' class="radios" id="cheque" name='pagamento' value="2" /><label for="cheque">Cheque </label>

					<input type='radio' class="radios" id="boleto" name='pagamento' value="3" /><label for="boleto">Boleto </label>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow' id="vencimento">
				<label>Vencimento:</label>
				<div class='formRight'>
					<input type='text' name='vencimento'  class='datepicker'/>
				</div>
				<div class='clear'></div>
			</div>

			<div class='formRow' id="chqs">
				<label>Numero do(s) Cheque(s):</label>
				<div class='formRight'>
					<input type='text' name='chqs' style="width:100px;float:left;"/><span class="req" style="float:left;"> Em caso de multiplos cheques, separar por virgula! </span>
				</div>
				<div class='clear'></div>
			</div>

		</div>
	</form>

</fieldset>

<a href='javascript:document.cadastrar.submit()' title='' class='wButton greenwB ml15 m10' style='margin: 18px 0 0 0; float: right;'> 
	<span>Salvar</span> 
</a>

<a href='<?php echo URL ?>Blocos/Pedidos/<?php echo $_GET["var3"]?>' title='' class='wButton bluewB ml15 m10' style='margin: 18px 18px 0 0; float: right;'> 
	<span>Voltar</span> 
</a>
