
<script>
$(function() {

	$("#cMun").change(function(){

			// recupera os dados do form
			cMun = $("#cMun").val(); 

			$("#xMun").val(cMun);
			
		});

	$("#xMun").change(function(){

			// recupera os dados do form
			cMun = $("#xMun").val(); 

			$("#cMun").val(cMun);
			
		});


	$("#cPais").change(function(){

			// recupera os dados do form
			cMun = $("#cPais").val(); 

			$("#xPais").val(cMun);
			
		});

	$("#xPais").change(function(){

			// recupera os dados do form
			cMun = $("#xPais").val(); 

			$("#cPais").val(cMun);
			
		});	



	$(".consultaCPF").click(function(){
		

		var cpf = $("#CPF").val();;
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
					$("#xNome").val(xmls.Nome);
				}
			}
		});

	});
	$(".consultaCNPJ").click(function(){
		var cnpj = $("#CNPJ").val();;
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
					$("#xNome").val(xmls.NomeEmpresa);
					$("#IE").val(xmls.InscricaoEstadual);
					$("#xLgr").val(xmls.Logradouro);
					$("#nro").val(xmls.Numero);
					$("#xCpl").val(xmls.Complemento);
					$("#xBairro").val(xmls.Bairro);
					$("#CEP").val(xmls.CEP);
					$("#UF").val(xmls.UF);


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
								$("#xMun").val(cidade.codigo);
								$("#cMun").val(cidade.codigo);
							}
						}
					});
				}
			}
		});
});





});

</script>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Dados do Destinat&aacute;rio</h6>
			</div>
			<div class="formRow">
				<label>Nome/Raz&atilde;o Social: </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="xNome" id="xNome" value="<?php echo $this->xNome ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>CNPJ: </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="CNPJ" id="CNPJ" value="<?php echo $this->CNPJ ?>" style="width:150px;"/>
					<input type='button' value='Buscar Dados do CNPJ' class='consultar consultaCNPJ' style='margin-left:20px;'>
				</div>
				<div class="clear"></div>

				<label>ou CPF: </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="CPF" id="CPF" value="<?php echo $this->CPF ?>" style="width:150px;"/>
					<input type='button' value='Buscar Dados do CPF' class='consultar consultaCPF' style='margin-left:20px;'>
				</div>
				<div class="clear"></div>

			</div>
			<div class="formRow">
				<label>Inscri&ccedil;&atilde;o Estadual: </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="IE" id="IE" value="<?php echo $this->IE ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Email: </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="email" value="<?php echo $this->email ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">

				<div class="formRight">
					<h6>Endere&ccedil;o:</h6>
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Logradouro: </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="xLgr" id="xLgr" value="<?php echo $this->xLgr ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Numero:</label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="nro" id="nro" value="<?php echo $this->nro ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Complemento:</label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="xCpl" id="xCpl" value="<?php echo $this->xCpl ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Bairro:</label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="xBairro" id="xBairro" value="<?php echo $this->xBairro ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Codigo Municipio:</label>
				<div class="formRight">
					<select name="cMun" id="cMun">
						<option value="0">Selecione o Codigo do Municipio</option>
						<?php echo $this->cMun ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Nome Municipio:</label>
				<div class="formRight">
					<select name="" id="xMun">
						<option value="0">Selecione o Municipio</option>
						<?php echo $this->xMun ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Estado - UF:<span class="req">* ex: (SP,GO)</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="UF" id="UF" value="<?php echo $this->UF ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>CEP:<span class="req">* sem formata&ccedil;&atilde;o</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="CEP" id="CEP" value="<?php echo $this->CEP ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Codigo Pais:</label>
				<div class="formRight">
					<select name="cPais" id="cPais">
						<option value="0">Selecione o Codigo do Pais</option>
						<?php echo $this->cPais ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Nome do Pais:</label>
				<div class="formRight">
					<select name="" id="xPais">
						<option value="0">Selecione o Pais</option>
						<?php echo $this->xPais ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Fone:<span class="req">* DDD+Numero <br>Sem espa&ccedil;os ou
					formata&ccedil;&atilde;o</span> </label>
					<div class="formRight">
						<input type="text" class="validate[required]" name="fone" id="fone" value="<?php echo $this->fone ?>" />
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</form>
	</fieldset>

	<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
		<span>Salvar</span> 
	</a>

	<a href="<?php echo URL ?>Destinatarios/Listar" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
		<span>Voltar</span> 
	</a>

