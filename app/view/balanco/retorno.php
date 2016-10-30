<script type="text/javascript">
	$(function(){

		diferenca = $("#diferencaVal").val();

		if(diferenca<0){

			$("#diferenca").css("color","red");

		}else{

			$("#diferenca").css("color","blue");
			
		}

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
		$("#resultado").html("<img src='<?php echo Folder?>images/icons/uploader/throbber.gif'>");
		$.post("<?php echo URL?>Balanco/Pesquisar-Retorno/<?php echo $_GET["var3"]?>",
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

	 




	});
</script>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Adicionar Retorno</h6>
			</div>
			<div class="formRow">
				<div class="formRight">
					Buscar: 
					<input type="text" name="busca" id="busca" style="width: 40%" autofocus="autofocus" />
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
<a href="<?php echo URL;?>Balanco/Carga/<?php echo $_GET["var3"]?>" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> Adicionar Carga </span> 
</a>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>
			Balan&ccedil;o
			<?php echo $this->vendedor." ( ".$this->data." )"?>
		</h6>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display xdTable">
		<thead>
			<tr>
				<th>Ord.</th>
				<th>ID</th>
				<th>Produto</th>
				<th>Peso</th>
				<th>Pre&ccedil;o</th>
				<th>Carga</th>
				<th>Retorno</th>
				<th>Vendido</th>
				<th>Lucro</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
	<div class="title">

		<h6>
			Lucro R$
			<?php echo number_format($this->lucro,2) ?>
		</h6>
	</div>
</div>
<div class="clear"></div>
<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/stats.png" alt="" class="titleIcon" />
			<h6>Detalhes do Balan&ccedil;o</h6>
		</div>
		<table cellpadding="0" cellspacing="0" border="0" class="display">
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>

			</thead>
			<tbody>
				<tr>
					<td>Produtos Levados: <?php echo $this->levados ?></td>
					<td>Valor Ida: R$ <?php echo number_format($this->ida,2) ?></td>
					<td>Valor Volta: R$ <?php echo number_format($this->volta,2) ?></td>
					<td>Estimativa de Venda: R$ <?php echo number_format($this->estimativa,2) ?></td>
				</tr>
				<tr>
					<td>Fiado Ida: R$ <?php echo number_format($this->fiadoi,2) ?></td>
					<td>Fiado Volta: R$ <?php echo number_format($this->fiadov,2) ?></td>
					<td>Venda: R$ <?php echo number_format($this->venda,2) ?></td>
					<td>Diferen&ccedil;a: R$ <span id="diferenca"><?php echo number_format($this->diferenca,2); ?></span></td>
					<input type="hidden" id="diferencaVal" value="<?php echo $this->diferenca; ?>">
				</tr>
				<tr>
					<td>Peso Levado: <?php echo number_format($this->pesoi,2) ?> Kg</td>
					<td>Peso Volta: <?php echo number_format($this->pesov,2) ?> Kg</td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</fieldset>
