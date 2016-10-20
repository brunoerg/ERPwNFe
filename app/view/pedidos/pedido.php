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
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt=""
			class="titleIcon" />
			<h6>Adicionar Produto</h6>
		</div>

		<div class="formRow">

			<div class="formRight">
				Buscar: <input type="text" name="busca" id="busca" style="width: 40%" autofocus="autofocus" />
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
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>
			<?php echo $this->fornecedor;?> 
		</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
	class="display xdTable">
	<thead>
		<tr>
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
<a href="<?php echo URL;?>Pedido" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Voltar </span> 
</a>

<br><br>