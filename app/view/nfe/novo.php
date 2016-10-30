<script>
	$(function(){
		$("#outroTrans").hide();
		$("#transOutro").click(function(){
			$("#outroTrans").show("slow");
		});
		$("#transMesmo").click(function(){
			$("#outroTrans").hide("slow");
		});



		$.post("<?php echo URL; ?>NFe/GetNumberNFe",
			{serie: $("#serie").val()}, 
			function(data) { 
				//alert(data);
				$("#numero").attr("value",data); 
			});

		$("#serie").change(function(){

			$.post("<?php echo URL; ?>NFe/GetNumberNFe",
				{serie: $("#serie").val()}, 
				function(data) { 
				//alert(data);
				$("#numero").attr("value",data); 
			});
		});

		$("#NomeDestinatario").keyup(function(){

			nome = $(this).val(); 


			if (nome=="") {
				$("#Destinatario").slideUp("slow");
			}else{
				$("#Destinatario").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
				$.post("<?php echo URL; ?>NFe/GetDestinatario",
					{nome: nome}, 
					function(data) { 
						$("#Destinatario").html(data); 

						$("#Destinatario").slideDown("slow");
					});
			}
		});


	});
</script>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Criar uma NF-e - Configurar Nota</h6>
			</div>
			<div class="formRow">
				<label>Natureza de Opera&ccedil;&atilde;o:</label>
				<div class="formRight">
					<select name="natOp" style="width:500px;">
						<option value="0">Selecione a Opera&ccedil;&atilde;o</option>
                        <?php
							@mysql_connect(HOST, USER, PASS);
							@mysql_select_db(DB);
						?>
						<option value="5104">Venda de mercadoria adquirida...</option>
						<option value="1904">Retorno de remessa para venda fora do estabelecimento</option>
						<option value="5904">Remessa para venda fora do estabelecimento</option>
                        <?php
                        	$readCfop = mysql_query("SELECT * FROM cfop ORDER BY codigo ASC");
							while($resCfop = mysql_fetch_array($readCfop)){
								echo '<option value="'.$resCfop['codigo'].'">'.$resCfop['codigo'].' - '.utf8_encode ($resCfop['descricao']).'</option>';
								
							}
						?>			
					</select>
                    
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Forma de Pagamento:</label>
				<div class="formRight">
					<select name="indPag">
						<option value="0">Selecione a Forma de Pagamento</option>
						<option value="0">A Vista</option>
						<option value="1">A Prazo</option>
						<option value="2">Outros</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>S&eacute;rie do Documento Fiscal:</label>
				<div class="formRight">
					<input type="number" class="int" name="serie" id="serie" value="1" style="width:50px;"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Numero da NFe:</label>
				<div class="formRight">
					<input type="text" class="int" name="numero" id="numero" value="1" style="width:50px;" disabled/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Data de Emiss&atilde;o:</label>
				<div class="formRight">
					<input type="text" style="width:150px;" name="dEmi" class="datepicker" value="<?php echo date("d-m-Y") ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Data de Saida/Entrada:</label>
				<div class="formRight">
					<input type="text" name="dSaiEnt" class="datepicker" value="<?php echo date("d-m-Y") ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de NF-e:</label>
				<div class="formRight">
					<select name="tpNF">
						<option value="1">Saida</option>
						<option value="0">Entrada</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de Impress&atilde;o:</label>
				<div class="formRight">
					<select name="tpImp">
						<option value="1">Retrato</option>
						<option value="2">Paisagem</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de Emiss&atilde;o:</label>
				<div class="formRight">
					<select name="tpEmis">
						<option value="1">Normal</option>
						<option value="2">Contig&ecirc;ncia</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de Ambiente:</label>
				<div class="formRight">
					<select name="tpAmb">
						<option value="1" <?php if($this->TipoDeAmbiente==1 ){echo"selected";}?> >Produ&ccedil;&atilde;o</option>
						<option value="2" <?php if($this->TipoDeAmbiente==2 ){echo"selected";}?>>Homologa&ccedil;&atilde;o</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Finalidade de Emiss&atilde;o:</label>
				<div class="formRight">
					<select name="finNFe">
						<option value="1">Normal</option>
						<option value="2">Complementar</option>
						<option value="3">de Ajuste</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class='formRow'>
				<label>Destinat&aacute;rio:</label>
				<div class='formRight'>
					<input type='text' id="NomeDestinatario"/>
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow' id="">
				<div class='formRight' id="Destinatario">
				</div>
				<div class='clear'></div>
			</div>
			<div class='formRow'>
				<label>ID Destinat&aacute;rio:</label>
				<div class='formRight'>
					<input type='number' name='destinatario' id='idDestinatario' style='width:50px;' value='<?php echo $this->destinatario; ?>'/>
				</div>
				<div class='clear'></div>
			</div>
			<div class="formRow">
				<label>Informa&ccedil;&otilde;es Complementares ao Fisco:</label>
				<div class="formRight">
					<textarea name="fiscoComplementares" rows="10" cols=""></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Informa&ccedil;&otilde;es Complementares ao Contribuinte:</label>
				<div class="formRight">
					<textarea name="contribuinteComplementares" rows="10" cols=""></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Veiculo Tranportador:</label>
				<div class="formRight">
					<select name="veiculo">
						<option value="0">Nenhum</option>
						<?php echo $this->veiculos ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Frete por Conta:</label>
				<div class="formRight">
					<label> <input type="radio" name="frete" value="0"> Do Emitente </label>
					<label> <input type="radio" name="frete" value="1"> Do Destinatario
					</label> <label> <input type="radio" name="frete" value="2"> De Terceiros </label> 
					<label> <input type="radio" name="frete" value="9" checked> Sem Frete </label>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tranportador:</label>
				<div class="formRight">
					<label> <input type="radio" id="transMesmo" name="opTransportador" value="0" checked> O Emissor </label> 
					<label> <input type="radio" id="transOutro" name="opTransportador" value="1"> Outro </label>
				</div>
				<fieldset>
					<div class="widget" id="outroTrans">
						<div class="title">
							<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
							<h6>Transportador</h6>
						</div>
						<div class="formRow">
							<label>Nome/Raz&atilde;o Social:</label>
							<div class="formRight">
								<input type="text" name="transxNome" id="transxNome" value="<?php echo $this->transxNome ?>"/>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Codigo ANTT:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" class="validate[required] " name="transAntt" id="transAntt" value="<?php echo $this->transAntt ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Placa:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" class="validate[required] placa" name="transPlaca" id="transPlaca" value="<?php echo $this->transPlaca ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Placa UF:</label>
							<div class="formRight">
								<select name="transPlacaUf">
									<option value="0">Selecione o Estado</option>
									<?php echo $this->ufs ?>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>CNPJ/CPF:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" name="transCnpj" id="transCnpj" value="<?php echo $this->transCnpj ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Inscri&ccedil;&atilde;o Estadual:<span class="req"></span>
							</label>
							<div class="formRight">
								<input type="text" name="transIE" id="transIE" value="<?php echo $this->transIE ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Endere&ccedil;o:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" name="transEndereco" id="transEndereco" value="<?php echo $this->transEndereco ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Municipio:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" name="transMun" id="transMun" value="<?php echo $this->transMun ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>UF Transportador:</label>
							<div class="formRight">
								<select name="transUf">
									<option value="0">Selecione o Estado</option>
									<?php echo $this->ufs ?>
								</select>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</fieldset>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB" style="margin: 18px 0 0 0; float: right;cursor:pointer;"><span>Salvar</span></a>

<a href="<?php echo URL ?>NFe" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a><br><br><br><br><br><br><br><br><br>