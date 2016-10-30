<script type="text/javascript">
$(function(){




	$("#Tcnpj").click(function(){
		
		$("#cpf").mask("99.999.999/9999-99");

		$(".consultar").attr("tipo","CNPJ").val("Buscar Dados do CNPJ");

	});

	$("#Tcpf").click(function(){


		$("#cpf").mask("999.999.999-99");
		$(".consultar").attr("tipo","CPF").val("Buscar Dados do CPF");
	});


	$("#fone").mask("(99) 9999-9999");
	

	$(".consultar").click(function(){
		
		if($(this).attr("tipo")=="CPF"){

			var cpf = $("#cpf").val();;
			$.ajax({
				type: "POST",
				url: '<?=URL?>Clientes/XML',
				dataType: "JSON",
				data: {
					cpf:cpf
				},
				success: function(xmls){
					if (xmls.false) {
						if (xmls.CodErro==1) {
							alert("Erro de Autenticacao!");
						}else if(xmls.CodErro==3){
							alert("Saldo de consultas acabou por hoje!");	
						}
						
					}else{

						$("#nome").val(xmls.Nome);
					}
				}
			});
			
		}else if($(this).attr("tipo")=="CNPJ"){
			var cnpj = $("#cpf").val();;
			$.ajax({
				type: "POST",
				url: '<?=URL?>Clientes/XML',
				dataType: "JSON",
				data: {
					cnpj:cnpj
				},
				success: function(xmls){
					if (xmls.false) {
						if (xmls.CodErro==1) {
							alert("Erro de Autenticacao!");
						}else if(xmls.CodErro==3){
							alert("Saldo de consultas acabou por hoje!");	
						}
						
					}else{

						$("#nome").val(xmls.NomeEmpresa);

						$.ajax({
							type: "POST",
							url: "<?=URL?>/Clientes/BuscaCidade",
							dataType: "JSON",
							data: {
								cidade:xmls.Municipio
							},
							success: function(cidade){
								if (cidade.false) {
									alert("Cidade não localizada. Cadastrar Manualmente!");
								}else{
									$("#cidade").val(cidade.codigo);
								}
							}
						});
						$("#endereco").val(xmls.Logradouro+", "+xmls.Numero+", "+xmls.Complemento+", Setor "+xmls.Bairro+" CEP:"+xmls.CEP);
					}
				}
			});
		}else{

		}
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

	 $("#clientes").hide();

	 
	 ////// VERIFICA CLIENTE
	 $("#nome").keyup(function(){

		// recupera os dados do form
		nome = $(this).val(); 
		

		
		if (nome=="") {
			$("#clientes").slideUp("slow");
		}else{
		// instancia o ajax via post informando o destino no caso data.php
		$("#clientes").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
		$.post("<?php echo URL; ?>Clientes/Cliente",
		// envia os dados do form nas variaveis nome e mail
		{nome: nome}, 
		// recupera as informacoes vindas do data.php
		function(data) { 
		// se retornou 1 entao os dados nao foram enviados
		// se nao retornou 1 entao os dados foram enviados
		// remove a classe error da div
		$("#clientes").html(data); 
		// torna a div invisivel

		$("#clientes").slideDown("slow");
		$("#clientes").css("display","none").slideDown("slow"); 
		
	});
	}
});	


	 ////// VERIFICA CPF
	 $("#cpf").keyup(function(){

		// recupera os dados do form
		cpf = $("#cpf").val(); 
		

		
		
		// instancia o ajax via post informando o destino no caso data.php
		$("#resultado").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
		$.post("<?php echo URL; ?>Clientes/Cpf",
		// envia os dados do form nas variaveis nome e mail
		{cpf: cpf}, 
		// recupera as informacoes vindas do data.php
		function(data) { 
		// se retornou 1 entao os dados nao foram enviados
		// se nao retornou 1 entao os dados foram enviados
		// remove a classe error da div
		$("#resultado").html(data); 
		// torna a div invisivel
		if(cpf==""){

		}else{
			$("#resultado").css("display","none").slideDown("slow"); 
		}
		
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
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Novo Cliente</h6>
			</div>
			<div class="formRow">
				<label>Nome:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="nome" id="nome" value="<?php echo $this->nome ?>" style="text-transform:capitalize" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow" id="clientes">


				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Cidade:<span class="req">*</span> </label>
				<div class="formRight">
					<select name="cidade" id="cidade">
						<option value="0">Selecione a Cidade</option>
						<?php echo $this->selectCidades ?>
					</select>
					<a href="<?php echo URL; ?>Municipios/Adicionar" target="_blank" class="wButton redwB ml15 m10" style="margin: -5px 0px 0px 30px; float: left;"> 
						<span>Adicionar Cidade</span> 
					</a>
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Fone: </label>
				<div class="formRight">
					<input type="tel" name="fone" value="<?php echo $this->fone ?>" id="fone" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>CPF/CNPJ: </label>

				<div class="formRight">
					<label><input type="radio" id="Tcnpj" name="tipo" /> CNPJ</label> <label>
					<input type="radio" id="Tcpf" class="fieldConsult" name="tipo" />CPF</label> 
					<input type="text" id="cpf" name="cpf" value="<?php echo $this->cpf ?>" style="width:150px;" />
					<input type='button' value='Buscar Dados do CPF' class='consultar consultaCPF' style='margin-left:20px;'>
					<div id="resultado"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Endere&ccedil;o: </label>
				<div class="formRight">
					<input type="text" name="endereco"
					value="<?php echo $this->endereco ?>" id="endereco" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Forma de Pagamento:</label>
				<div class="formRight">
					<select name="pagamento">
						<?php echo $this->pagamentos ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Vendedor:</label>
				<div class="formRight">
					<select name="vendedor">
						<option value="0">Selecione o Vendedor</option>
						<?php echo $this->vendedores ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Clientes" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
