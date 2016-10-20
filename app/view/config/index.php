<script>
$(function() {

	$("#empresa.exp").click(function() {

		$("#boletos_bb").next(".close_boletos").slideUp();
		$("#nfe").next(".close_nfe").slideUp();

	});

	$("#boletos_bb.exp").click(function() {

		$("#empresa").next(".close_empresa").slideUp();
		$("#nfe").next(".close_nfe").slideUp();

	});
	$("#nfe.exp").click(function() {

		$("#empresa").next(".close_empresa").slideUp();
		$("#boletos_bb").next(".close_boletos").slideUp();

	});



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





});

</script>
<br><br>
<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder; ?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
			<h6>Configura&ccedil;&otilde;es</h6>
		</div>

		<!--ABAIXO DADOS DA EMPRESA PARA USO GERAL -->

		<ul>
			<form id="validate" class="form" method="post" action="" name="empresa">
				<li style='list-style: none; padding: 5px;' class='exp' id="empresa">
					<div class="widget">
						<div class="title">
							<img src="<?php echo Folder; ?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
							<h6>Dados da Empresa</h6>
						</div>
					</div>
				</li>
				<div class="close_empresa">
					<div class="formRow">
						<label>Nome: </label>
						<div class="formRight">
							<input type="text" name="nome" value="<?php echo $this->nome ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Raz&atilde;o Social: </label>
						<div class="formRight">
							<input type="text" name="razao" value="<?php echo $this->razao ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>CNPJ: </label>
						<div class="formRight">
							<input type="text" class="validate[required] cnpj" name="cnpj" value="<?php echo $this->cnpj ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Inscri&ccedil;&atilde;o Estadual: </label>
						<div class="formRight">
							<input type="text" name="ie" value="<?php echo $this->ie ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Email: </label>
						<div class="formRight">
							<input type="text" name="email" value="<?php echo $this->email ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Endere&ccedil;o: </label>
						<div class="formRight">
							<input type="text" name="endereco" value="<?php echo $this->endereco ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>CEP: </label>
						<div class="formRight">
							<input type="text" class="validate[required] cep" name="cep" value="<?php echo $this->cep ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Cidade: </label>
						<div class="formRight">
							<input type="text" name="cidade" value="<?php echo $this->cidade ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Estado:<span class="req">* ex: (SP,GO)</span> </label>
						<div class="formRight">
							<input type="text" name="estado" value="<?php echo $this->estado ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<div class="formRight">
							<a href="javascript:document.empresa.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
								<span>Salvar</span> 
							</a>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label><span class="req"></span> </label>
						<div class="formRight"></div>
						<div class="clear"></div>
					</div>
				</div>
			</form>
		</ul>


		<!--ABAIXO CONFIGURACAO DE DADOS BANCARIOS PARA BOLETO -->


		<form id="validate" class="form" method="post" action="" name="boletos_bb">
			<ul>
				<li style='list-style: none; padding: 5px;' class='exp' id="boletos_bb">
					<div class="widget">
						<div class="title">
							<img src="<?php echo Folder; ?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
							<h6>Configura&ccedil;&atilde;o de Boletos Banco do Brasil</h6>
						</div>
					</div>
				</li>
				<div class="close_boletos">
					<div class="formRow">
						<label>Agencia: </label>
						<div class="formRight">
							<input type="text" class="validate[required]" name="agencia" value="<?php echo $this->agencia ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Conta Corrente: </label>
						<div class="formRight">
							<input type="text" class="validate[required]" name="conta" value="<?php echo $this->conta ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Conv&ecirc;nio: </label>
						<div class="formRight">
							<input type="text" name="convenio" value="<?php echo $this->convenio ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>N&ordm; Contrato: </label>
						<div class="formRight">
							<input type="text" name="contrato" value="<?php echo $this->contrato ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Carteira: </label>
						<div class="formRight">
							<input type="text" name="carteira" value="<?php echo $this->carteira ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Varia&ccedil;&atilde;o: </label>
						<div class="formRight">
							<input type="text" name="variacao" value="<?php echo $this->variacao ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Juros:<span class="req">* (%)</span> </label>
						<div class="formRight">
							<input type="text" name="juros" value="<?php echo $this->juros ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Multa:<span class="req">* ( % ) ao m&ecirc;s</span> </label>
						<div class="formRight">
							<input type="text" name="multa" value="<?php echo $this->multa ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Multa ap&oacute;s atrazo de: </label>
						<div class="formRight">
							<input type="text" name="dias" size="30" value="<?php echo $this->dias ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<div class="formRight">
							<a href="javascript:document.boletos_bb.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
								<span>Salvar</span> 
							</a>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label><span class="req"></span> </label>
						<div class="formRight"></div>
						<div class="clear"></div>
					</div>
				</div>
			</ul>
		</form>


		<!-- CONFIGURACAO PARA EMISSAO DE NFE-->

		<ul>
			<form id="validate" class="form" method="post" action="" name="nfe">
				<li style='list-style: none; padding: 5px;' class='exp' id="nfe">
					<div class="widget">
						<div class="title">
							<img src="<?php echo Folder; ?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
							<h6>Dados para Emiss&atilde;o de NF-e</h6>
						</div>
					</li>
					<div class="close_nfe">
						<div class="formRow">
							<div class="formRight">
								<h6>Dados Fiscais da Empresa:</h6>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Nome Fantasia: </label>
							<div class="formRight">
								<input type="text" name="xFant" value="<?php echo $this->xFant ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Raz&atilde;o Social: </label>
							<div class="formRight">
								<input type="text" name="xNome" value="<?php echo $this->xNome ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>CNPJ: </label>
							<div class="formRight">
								<input type="text" name="CNPJ" value="<?php echo $this->CNPJ ?>" />
							</div>
							<div class="clear"></div>
							<label>ou CPF: </label>
							<div class="formRight">
								<input type="text" name="CPF" value="<?php echo $this->CPF ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Inscri&ccedil;&atilde;o Estadual: </label>
							<div class="formRight">
								<input type="text" name="IE" value="<?php echo $this->IE ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Inscri&ccedil;&atilde;o Estadual do <br>Substituto Tribut&aacute;rio: </label>
							<div class="formRight">
								<input type="text" name="IEST" value="<?php echo $this->IEST ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Inscri&ccedil;&atilde;o Municipal: </label>
							<div class="formRight">
								<input type="text" name="IM" value="<?php echo $this->IM ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>CNAE Fiscal: </label>
							<div class="formRight">
								<input type="text" name="CNAE" value="<?php echo $this->CNAE ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>C&oacute;digo de Regime Tribut&aacute;rio: </label>
							<div class="formRight">
								<select name="CRT" id="CRT">
									<option value="0">Selecione o CRT</option>
									<?php echo $this->CRT ?>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Alicota Simples Nacional: </label>
							<div class="formRight">
								<input type="text"  name="alicota" value="<?php echo $this->alicota ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Alicota de Credito: </label>
							<div class="formRight">
								<input type="text"  name="credito" value="<?php echo $this->credito ?>" />
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
								<input type="text" name="xLgr" value="<?php echo $this->xLgr ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Numero:</label>
							<div class="formRight">
								<input type="text" name="nro" value="<?php echo $this->nro ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Complemento:</label>
							<div class="formRight">
								<input type="text" name="xCpl" value="<?php echo $this->xCpl ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Bairro:</label>
							<div class="formRight">
								<input type="text" name="xBairro" value="<?php echo $this->xBairro ?>" />
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
								<input type="text" name="UF" value="<?php echo $this->UF ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>CEP:<span class="req">* sem formata&ccedil;&atilde;o</span>
							</label>
							<div class="formRight">
								<input type="text" name="CEP" value="<?php echo $this->CEP ?>" />
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
							<label>Fone:<span class="req">* DDD+Numero <br>Sem espa&ccedil;os
								ou formata&ccedil;&atilde;ao</span> </label>
								<div class="formRight">
									<input type="text" name="fone" value="<?php echo $this->fone ?>" />
								</div>
								<div class="clear"></div>
							</div>
							<div class="formRow">
								<div class="formRight">
									<a href="javascript:document.nfe.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
										<span>Salvar</span> 
									</a>
								</div>
								<div class="clear"></div>
							</div>
							<div class="formRow">
								<label><span class="req"></span> </label>
								<div class="formRight"></div>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</li>
			</form>
		</ul>
	</div>
</fieldset>
