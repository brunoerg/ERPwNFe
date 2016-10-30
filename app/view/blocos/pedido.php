<script type="text/javascript">
	$(function(){


		

		$('.xdTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sDom": '<""lf><"F"p>'
		});


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

		// recupera os dados do form
		produto = $("#busca").attr("value"); 
		

		
		
		// instancia o ajax via post informando o destino no caso data.php
		$("#resultado").html("<img src='../../app/public/images/icons/uploader/throbber.gif'>");
		$.post("../Pesquisar/<?php echo $_GET["var3"]?>",
		// envia os dados do form nas variaveis nome e mail
		{produto: produto}, 
		// recupera as informacoes vindas do data.php
		function(data) { 
		// se retornou 1 entao os dados nao foram enviados
		// se nao retornou 1 entao os dados foram enviados
		// remove a classe error da div
		$("#resultado").removeClass("error").addClass("sucess").html(data); 
		// torna a div invisivel
		$("#resultado").css("display","none").slideDown("slow"); 
	}) 
		// efeito show na div
		$("#resultado").slideDown("slow");
	});	


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
	 <?php if($this->pagamento!=1){?>
	 	$("#vencimento").hide();
	 	<?php }?>
	 	
	 	$(".radios").click(function(){
	 		if ($(this).val()==1){
	 			$("#vencimento").slideDown(500);
	 		}else{
	 			$("#vencimento").slideUp(500);
	 		}
	 	});

	 });
</script>

<fieldset>
	<form id="" class="form" method="post" action="" name="mudar" >

		<div class="widget">

			<div class="formRow">
				<label>Alterar Forma de Pagamento</label>
				<div class='formRight'>
					<input type='radio' class="radios" id="avista" name='pagamento' value="0" /><label for="avista">A Vista </label>

					<input type='radio' class="radios" id="aprazo" name='pagamento' value="1" /><label for="aprazo">A Prazo </label>
					<div class='formRow' id="vencimento">
						<label>Vencimento:</label>
						<div class='formRight'>
							<input type='text' name='vencimento'  class='datepicker' value="<?php echo $this->vencimento; ?>"/>
						</div>
						<div class='clear'></div>
					</div>
					<input type='radio' class="radios" id="cheque" name='pagamento' value="2" /><label for="cheque">Cheque </label>

					<input type='radio' class="radios" id="boleto" name='pagamento' value="3" /><label for="boleto">Boleto </label>
				</div>

				<div class="clear"></div>
			</div>
			<div class='formRow' id="vencimento">
				<label>Vencimento:</label>
				<div class='formRight'>
					<input type='text' name='vencimento'  class='datepicker' value="<?php echo $this->vencimento; ?>"/>
				</div>
				<div class='clear'></div>
			</div>
			<a href='javascript:document.mudar.submit()' title='' class='wButton greenwB ml15 m10' style='margin: 18px 0 0 0; float: right;'> 
				<span>Salvar</span> 
			</a>

		</div>
	</form>

</fieldset>

<?php if($this->pagamento==1){?>
<fieldset>
	<form id="" class="form" method="post" action="" name="editar" >

		<div class="widget">

			<div class="formRow">
				<label>Pagamentos Efetuados</label>
				<div class="formRight">

					<?php echo $this->pagamentos; ?>

				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">

				<div class="formRight">
					<label>Recebeu</label>
					R$ <input type="text" name="recebeu" style="width: 20%; min-width:20px;"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class='formRow'>
				<div class='formRight'>
					<label>Data:</label>	
					<input type='text' name='data' class='datepicker'/>
				</div>
				<div class='clear'></div>
			</div>


			<div class="formRow">

				<div class="formRight">
					<label>Pagamento Total:</label>
					<input type="checkbox" name="pago" value="1" <?php if(isset($this->pago)){ echo "checked"; } ?>/>
					<a href='javascript:document.editar.submit()' title='' class='wButton greenwB ml15 m10' style='margin: 18px 0 0 0; float: right;'> 
						<span>Salvar</span> 
					</a>
				</div>
				<div class="clear"></div>
			</div>


		</div>
	</form>

</fieldset>
<?php }?>


<fieldset>
	<form id="validate" class="form" method="post" action=""
	name="cadastrar" >

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
			class="titleIcon" />
			<h6>Adicionar Mercadoria</h6>
		</div>

		<div class="formRow">

			<div class="formRight">
				Buscar: <input type="text" name="busca" id="busca"
				style="width: 40%" autofocus="autofocus" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<span id="resultado"></span>

			<div class="clear"></div>
		</div>

	</div>
</form>

</fieldset>


<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
		class="titleIcon" />
		<h6>
			Bloco N&ordm; <?php echo $this->bloco;?> Pedido N&ordm; <?php echo $this->pedido;?> ( <?php echo $this->cliente;?> )
		</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
	class="display xdTable">
	<thead>
		<tr>
			<th>ID</th>
			<th>Quantidade</th>
			<th>Produto</th>
			<th>Valor</th>
			<th>Total</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>

	</thead>
	<tbody>
		<?php echo $this->lista;?>
	</tbody>
</table>

<div class="title">

	<h6>Valor Total: 
		<?php echo number_format($this->total,2,",",".");?>
	</h6>
</div>

</div>
<a href="<?php echo URL;?>Blocos/Pedidos/<?php echo $this->bloco ?>" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Voltar </span> 
</a>
<a href="<?php echo URL;?>Blocos/CriarPedido/
	<?php 
	$id = explode("-", $_GET["var3"]);
	echo $id[0]; 
	?>
	" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>	Criar Novo Pedido </span> 
</a>

<a href="<?php echo URL ?>Pdf/Pedido/<?php echo $_GET["var3"] ?>" target="_blank"  style="margin: 18px 18px -13px 0; float:right;"> 
	<span> <img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='32' /> </span> 
</a>
<br><br>