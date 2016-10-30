<script>
	$(function(){

		var op = <?php echo $this->opTransportador; ?>;

		if (op==1) {
			$("#outroTrans").show("slow");
		}else{
			$("#outroTrans").hide();	
		}
		
		$("#transOutro").click(function(){
			$("#outroTrans").show("slow");
		});
		$("#transMesmo").click(function(){
			$("#outroTrans").hide("slow");
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
	<form id="validate" class="form" method="post" action="" name="cadastrar" >
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Editar  NF-e de Numero: <?php echo $this->numero." e Serie: ".$this->serie; ?></h6>
			</div>
			<div class="formRow">
				<label>Data de Emiss&atilde;o:</label>
				<div class="formRight">
					<input type="text" name="dEmi" class="datepicker" value="<?php echo $this->dEmi; ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Data de Saida/Entrada:</label>
				<div class="formRight">
					<input type="text" name="dSaiEnt" class="datepicker" value="<?php echo $this->dSaiEnt; ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de NF-e:</label>
				<div class="formRight">
					<select name="tpNF">
						<option value="0" <?php if($this->tpNF=="0"){echo "selected";}else{} ?> >Entrada</option>
						<option value="1" <?php if($this->tpNF=="1"){echo "selected";}else{} ?>>Saida</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de Impress&atilde;o:</label>
				<div class="formRight">
					<select name="tpImp">
						<option value="1" <?php if($this->tpImp=="1"){echo "selected";}else{} ?>>Retrato</option>
						<option value="2" <?php if($this->tpImp=="2"){echo "selected";}else{} ?>>Paisagem</option>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de Ambiente:</label>
				<div class="formRight">
					<select name="tpAmb">
						<option value="1" <?php if($this->tpAmb=="1"){echo "selected";}else{} ?>>Produ&ccedil;&atilde;o</option>
						<option value="2" <?php if($this->tpAmb=="2"){echo "selected";}else{} ?>>Homologa&ccedil;&atilde;o</option>
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
					<textarea name="fiscoComplementares" rows="10" cols=""><?php echo $this->fiscoComplementares ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Informa&ccedil;&otilde;es Complementares ao Contribuinte:</label>
				<div class="formRight">
					<textarea name="contribuinteComplementares" rows="10" cols=""><?php echo $this->contribuinteComplementares ?></textarea>
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
					<label> <input type="radio" name="frete" value="0" <?php if($this->frete=="0"){echo "checked";}else{} ?>> Do Emitente </label>
					<label> <input type="radio" name="frete" value="1" <?php if($this->frete=="1"){echo "checked";}else{} ?>> Do Destinatario</label> 
					<label> <input type="radio" name="frete" value="2" <?php if($this->frete=="2"){echo "checked";}else{} ?>> De Terceiros </label> 
					<label> <input type="radio" name="frete" value="9" <?php if($this->frete=="9"){echo "checked";}else{} ?>> Sem Frete </label>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tranportador:</label>
				<div class="formRight">
					<input type="radio" id="transMesmo" name="opTransportador" value="0" <?php if($this->opTransportador=="0"){echo "checked";}else{} ?> > 
					<label> O Emissor </label> 
					<input type="radio" id="transOutro" name="opTransportador" value="1" <?php if($this->opTransportador=="1"){echo "checked";}else{} ?>> 
					<label> Outro </label>
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
								<input type="text" class="validate[required] " name="transxNome" id="transxNome" value="<?php echo $this->transxNome ?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Codigo ANTT:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" class="validate[required] " name="transAntt" id="transAntt" value="<?php echo $this->transAntt ?>"  />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Placa:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" class="validate[required] placa" name="transPlaca" id="transPlaca" value="<?php echo $this->transPlaca ?>"  />
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
								<input type="text" class="validate[required]" name="transCnpj" id="transCnpj" value="<?php echo $this->transCnpj ?>"  />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Inscri&ccedil;&atilde;o Estadual:<span class="req"></span>
							</label>
							<div class="formRight">
								<input type="text" class="validate[required]" name="transIE" id="transIE" value="<?php echo $this->transIE ?>"  />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Endere&ccedil;o:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" class="validate[required]" name="transEndereco" id="transEndereco" value="<?php echo $this->transEndereco ?>"  />
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label>Municipio:<span class="req"></span> </label>
							<div class="formRight">
								<input type="text" class="validate[required]" name="transMun" id="transMun" value="<?php echo $this->transMun ?>"  />
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

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>NFe" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
<br><br><br><br><br><br><br><br><br>