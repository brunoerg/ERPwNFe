<script type="text/javascript">
	$(function(){
		$("#gerando").hide();
		$(".formGerar").hide();


		$("#gerarDanfe").click(function(){

			$(".formGerar").hide("slow");


			$("#gerando").show("slow");
			$(".retorno").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
			var file = $(this).attr("file");


			$.post(
				"<?php echo URL.$_GET["var1"]?>/GerarDanfe",
				{file:file},
				function(data){
				//alert(data);
				$(".retorno").html(data);
				
			});

		});

		$("#buscarNfe").click(function(){

			$(".formGerar").hide("slow");


			$("#gerando").show("slow");
			$(".retorno").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");

			var chave = "<?php echo $this->chave ?>";


			$.post(
				"<?php echo URL.$_GET["var1"]?>/BuscarNFe",
				{chave:chave},
				function(data){
				//alert(data);
				$(".retorno").html(data);
				
			});

		});


		$("#gerar").click(function(){

			$(".formGerar").hide("slow");


			$("#gerando").show("slow");
			$("#resultado").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");

			$.ajax({
				url: "<?php echo URL.$_GET["var1"]?>/Gerar/<?php echo $_GET["var3"]?>",
				type: "post",
				data: "",
				dataType: "text",
				success: function(response, status) {
		       // acontece caso o servidor responder, aqui basicamente vais buscar os dados da response e metes onde quiseres na pagina
		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Gerando Txt...");
			    	  }, 500);

		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Gerando XML...");
			    	  }, 1000);

		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Assinando...");
			    	  }, 1500);
		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Validando...");
			    	  }, 2000);

		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Enviando...");


			    	  }, 2500);

		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Aguarde");
			    	  }, 3000);

		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Aguarde.");
			    	  }, 4500);

		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Aguarde..");
			    	  }, 5000);
		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Aguarde...");
			    	  }, 5500);
		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Aguarde....");
			    	  }, 6000);

		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Carregando Resultado.");
			    	  }, 6500);
		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Carregando Resultado...");
			    	  }, 7000);
		       setTimeout(function() {
			    	      // Do something after 5 seconds
			    	      $(".retorno").html("Carregando Resultado....");
			    	  }, 7500);

		       setTimeout(function() {
			    	      // Do something after 5 seconds

			    	      $(".retorno").html(response);
			    	      $(".formGerar").show("slow");

			    	  }, 8000);


		   },
		   error: function() {
		    // caso nao responda    
		}
	});
});

$("#Consultar").click(function(){

	$(".retorno").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");

	var html = $(".retorno").html();
	$(".retorno").html(html+"<br>Consultando");
	setTimeout(function() {
		$(".retorno").html(html+"<br>Consultando.");
	}, 1000);
	setTimeout(function() {
		$(".retorno").html(html+"<br>Consultando..");
	}, 1500);
	setTimeout(function() {
		$(".retorno").html(html+"<br>Consultando...");
	}, 2000);
	setTimeout(function() {
		$(".retorno").html(html+"<br>Preparando...");
	}, 3000);

	setTimeout(function() {
  	      // Do something after 5 seconds

  	      var file = $("#FormFile").val();
  	      var nRec = $("#FormRec").val();
  	      var chave = $("#FormChave").val();

  	      $.ajax({
  	      	url: "../Lote/<?php echo $_GET["var3"]?>",
  	      	type: "post",
  	      	data: {file:file, nRec:nRec, Chave:chave},
  	      	dataType: "text",
  	      	success: function(response, status) {
  	      		$(".retorno").html(response);
  	      	},
  	      	error: function() {
			    // caso nao responda    
			}
		});
  	  }, 5000);

});



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
		$("#resultadoBusca").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
		$.post("../Pesquisar/<?php echo $_GET["var3"]?>",
		// envia os dados do form nas variaveis nome e mail
		{produto: produto}, 
		// recupera as informacoes vindas do data.php
		function(data) { 
		// se retornou 1 entao os dados nao foram enviados
		// se nao retornou 1 entao os dados foram enviados
		// remove a classe error da div
		$("#resultadoBusca").removeClass("error").addClass("sucess").html(data); 
		// torna a div invisivel
		$("#resultadoBusca").css("display","none").slideDown("slow"); 
	}) 
		// efeito show na div
		$("#resultadoBusca").slideDown("slow");
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




	 $("#result").hide();


	//alert(0);

	$("#Enviar").click(function(e){

		var y = e.pageY ;

		var altura = $(window).height();

		var posY = y-altura;


		$("#bgDark").fadeIn("slow",function(){
			//alert(2);
			$("#result").animate({"margin-top":posY},500,function(){

				//alert(3);
				$("#retorno").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");

				$(this).slideDown("slow");

				//alert(4);

				$.post("<?php echo URL; ?>NFe/Email",
				{
					id: "<?php echo $_GET['var3']; ?>"
				}, 
				function(data) { 
					//alert(data);
					$("#retorno").html(data); 
				});
				

			});	
		});



	});

	$(".OKK").click(function(){

		$("#result").slideUp("slow",function(){
			$("#bgDark").fadeOut("slow"); 	
		});
		

	});

	$("#bgDark").click(function(){

		$("#result").slideUp("slow",function(){
			$("#bgDark").fadeOut("slow"); 	
		});
		

	});

	$("#result").click(function(){

		$("#result").slideUp("slow",function(){
			$("#bgDark").fadeOut("slow"); 	
		});
		

	});

	
});
</script>
<fieldset >
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/stats.png" alt="" class="titleIcon" />
			<h6>Dados da NFe</h6>
		</div>
		
		<div class="formRow">
			<label>Destinat&aacute;rio NFe:</label>
			<div class="formRight">
				<?=$this->destinatario?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Chave NFe:</label>
			<div class="formRight">
				<?=$this->chave?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Numero NFe:</label>
			<div class="formRight">
				<?=$this->numero?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Serie NFe:</label>
			<div class="formRight">
				<?=$this->serie?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Valor da Nota:</label>
			<div class="formRight">
				R$ <?= number_format($this->vTotal,2,",",".") ?>
			</div>
			<div class="clear"></div>
		</div>

		<?php if(($this->boletos)){
			foreach ($this->boletos as $value) {
				echo "
				<div class='formRow'>
					<label>Boleto ".$value.":</label>
					<div class='formRight'>
						<a href='".URL."Pdf/Boleto/".$value."' title='Pdf' target='_blank' >
							<img src='".Folder."images/icons/control/32/pdf.png' alt='' height='40' width='32' />
						</a>
					</div>
					<div class='clear'></div>
				</div>
				";
			}
		}
		?>
	</div>
</fieldset>


<a href="<?php echo URL ?>NFe/Reproduzir/<?php echo $_GET["var3"]; ?>" title="" class="wButton redwB ml15 m10" style="margin: 18px 18px 0 0;"> 
	<span>Reproduzir NFe</span> 
</a>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Adicionar Produtos</h6>
			</div>
			<div class="formRow">
				<div class="formRight">
					<label>Buscar: </label>
					<input type="text" name="busca" id="busca" style="width: 40%" autofocus="autofocus" />
				</div>
				<span id="resultadoBusca"></span>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Produtos Adicionados</h6>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display xdTable">
		<thead>
			<tr>
				<th>cProd</th>
				<th>xProd</th>
				<th>CFOP</th>
				<th>qCom</th>
				<th>vUnCom</th>
				<th>vProd</th>
				<th>CST</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
<div class="clear"></div>
<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/stats.png" alt="" class="titleIcon" />
			<h6>Detalhes da NFe</h6>
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
					<td></td>
					<td>Valor da Nota: R$ <?php echo number_format($this->vTotal,2,",",".") ?>
					</td>
					<td>
						<a style="cursor:pointer;" class="wButton redwB ml15 m10" id="Enviar"> 
							<span>Enviar NFe por Email</span> 
						</a>
						<a style="cursor:pointer;" class="wButton greenwB ml15 m10" id="buscarNfe"> 
							<span>Buscar NFe</span> 
						</a>
					</td>
					<td align="right">
						<?php 
						if (is_file($this->xml)) {

							echo "<a href='".URL."NFe/GerarDanfe/".$this->chave."' title='Pdf' target='_blank' >
							<img src='". Folder."images/icons/control/32/pdf.png' alt='' height='40' width='32' />
						</a>";

					}else{

						echo '<a style="cursor:pointer;" class="wButton bluewB ml15 m10" id="gerar"> 
						<span>Gerar NFe</span> 
					</a>';
				}
				?>
			</td>
		</tr>
	</tbody>
</table>
</div>
</fieldset>
<fieldset id="gerando">
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/stats.png" alt="" class="titleIcon" />
			<h6>Gerando NFe...</h6>
		</div>
		<div class="formRow">
			<span class="retorno"></span>
		</div>
		<div class="formRow">
			<span class="formGerar"> 
				<input type="hidden" name="FormFile" id="FormFile" value="<?php echo $this->FormFile ?>"> 
				<input type="hidden" name="FormRec" id="FormRec" value=""> 
				<input type="hidden" name="FormChave" id="FormChave" value=""> 
				<a title='' class='wButton bluewB ml15 m10' id='Consultar'> 
					<span>Consultar Recibo</span> 
				</a>
			</span>
		</div>
	</div>
</fieldset>
<a href="<?php echo URL ?>NFe/Selecionar" title="Voltar"  class="wButton greenwB ml15 m10"> 
	<span>Voltar</span>
</a>
<div id="result" >
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
			<h6>Enviando Email...</h6>
		</div>
		<div class="title" id="retorno" style="text-align:center;width:100%;height:150px;">
		</div>
	</div>
</div>