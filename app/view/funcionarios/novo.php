<script type="text/javascript">
$(function() {

	$("#HidVendedor").hide();
	$(".diasExp").hide();

	$(".funcoes").click(function() {
		if ($(this).attr("comissao")=="0") {
			$("#HidVendedor").hide("slow");
			$("#comissao").val("0");
		}else{
			$("#HidVendedor").show("slow");
		}
	});
	<?php if($this->comissao>0){?>
		$("#HidVendedor").show("slow");
		<?php } ?>
		$(".experiencia").click(function() {
			if ($(this).val()==0) {
				$(".diasExp").hide("slow");
				var val = $("#admissao").val();
				$("#efetivado").val(val);
			}else{
				$(".diasExp").show("slow");
				$("#efetivado").val("");
			}
		});


		$("#diasExpVal").keyup(function(){
			var dias = $(this).val();
			var admissao = $("#admissao").val();
			if (admissao=="" || admissao==false) {
				$(".alertAdmi").html("Coloque uma data de Admissão!");
			}else{
				$.post("<?php echo URL?>Funcionarios/GetEfetivacao", 
				{ 
					admissao: admissao,
					dias: dias 
				},function(data) {
					$("#efetivado").val(data); 
				});
			}
		});



		$("#DeletarFoto").click(function(){
			var file = $(this).attr("file");
		//alert(file);
		$.post("<?php echo URL?>Funcionarios/DeletarFoto", 
		{ 
			file: file,
			id: "<?=$_GET['var3']?>"
		},function(data) {
			if (data=="false") {
				alert("Erro ao Tentar excluir a Foto. Tente Novamente!");
			}else{
				$(".fotoUp").slideUp(1000,function(){
					$(".foto").slideUp(1000);
					$(".audio").slideDown(1000);
				});
			}
			
		});
	});


		$(".DeletarDoc").click(function(){

			var file = $(this).attr("file");

			var element = $(this);

			$.post("<?php echo URL?>Funcionarios/DeletarDoc", 
			{ 
				file: file,
				id: "<?=$_GET['var3']?>"
			},function(data) {
				if (data=="false") {
					alert("Erro ao Tentar excluir o Arquivo "+file+". Tente Novamente!");
				}else{
					element.parent().parent().fadeOut(1000);	
				}

			});

		});





		$("#admissao").change(function() {
			$(".alertAdmi").html("");
			var val = $("#admissao").val();
			$("#efetivado").val(val);
		});

		$(".foto").hide();

		$(".uploader").pluploadQueue({
			runtimes : 'html5',
			url : '<?=URL?>Funcionarios/Upload',
			max_file_size : '100mb',
			unique_names : false,
			multi_selection:false,
			filters : [ {
				title : "Imagens",
				extensions : "png,jpeg,jpg"
			}
			],
			init:
			{
				FileUploaded: function(up, file, info) {
					$("#foto").val(info.response);
					$("#uploadedFile").html("<img src='<?=Folder?>funcionarios/"+info.response+"' width='200px'/>"); 
					$(".audio").slideUp(1000,function(){
						$(".foto").slideDown(1000);	
					});
				},
				UploadComplete: function (up, files) {

				},
				Error: function (uploader, error) {
					alert("Upload Error");
				}
			}
		});

		$(".documents").pluploadQueue({
			runtimes : 'html5',
			url : '<?=URL?>Funcionarios/UploadDocumentos/<?=$_GET["var3"]?>',
			max_file_size : '100mb',
			unique_names : false,
			multi_selection:true,
			filters : [ {
				title : "Imagens",
				extensions : "png,jpeg,jpg,pdf,doc,xls,xml,xlsx,docx"
			}
			],
			init:
			{
				FileUploaded: function(up, file, info) {
					var html = $(".documentosUp").html();
					$(".documentosUp").html(html+info.response);
				},
				UploadComplete: function (up, files) {

				},
				Error: function (uploader, error) {
					alert("Upload Error");
				}
			}
		});

	});
</script>
<form id="validate" class="form" method="post" name="cadastrar" >
	<fieldset>
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
				<h6>Novo Funcionário</h6>
			</div>
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
						<h6>Dados Pessoais</h6>
					</div>
					<input type="hidden" id="foto" name="foto" value="<?=$this->foto?>" />

					<div class="formRow audio" <?php if(is_file("app/public/funcionarios/".$this->foto)){ echo "style='display:none;'";}?> >
						<label><b>Foto:</b>:<span class="req">*</span> </label>
						<div class="formRight" >
							<div class="uploader" style="width:100%;"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow foto">
						<label><b>Foto:</b>:<span class="req">*</span> </label>
						<div class="formRight" id="uploadedFile">

						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow fotoUp" <?php if(!file_exists("app/public/funcionarios/".$this->foto) || $this->foto==false){ echo "style='display:none;'";}?>>
						<label><b>Foto:</b>:<span class="req">*</span> </label>
						<div class="formRight" id="uploadedFile">
							<img src='<?=Folder?>funcionarios/<?=$this->foto?>' height='200px' style='float:left;'/><input type="button" id='DeletarFoto' file='<?=$this->foto?>' style='float:left;' value="X">
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Nome:</label>
						<div class="formRight">
							<input type="text" name="nome" value="<?php echo $this->nome ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Sexo:</label>
						<div class="formRight">
							<input type="radio" name="sexo" id="masc" value="1" <?php echo (($this->sexo=="1")? "checked" : "" );?> ><label for="masc">Masculino</label>
							<input type="radio" name="sexo" id="fem" value="0" <?php echo (($this->sexo=="0")? "checked" : "" );?> ><label for="fem">Feminino</label>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Data de Nascimento:</label>
						<div class="formRight">
							<input type="text" name="nascimento" class="datepicker" value="<?php echo $this->nascimento ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Endereço:</label>
						<div class="formRight">
							<input type="text" name="endereco" value="<?php echo $this->endereco ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Estado Civil:</label>
						<div class="formRight">
							<input type="radio" name="estadoCivil" id="solt" value="0" <?php echo (($this->estadoCivil=="0")? "checked" : "" );?> ><label for="solt">Solteiro</label>
							<input type="radio" name="estadoCivil" id="cas" value="1" <?php echo (($this->estadoCivil=="1")? "checked" : "" );?> ><label for="cas">Casado</label>
							<input type="radio" name="estadoCivil" id="div" value="2" <?php echo (($this->estadoCivil=="2")? "checked" : "" );?> ><label for="div">Divorciado</label>
							<input type="radio" name="estadoCivil" id="out" value="3" <?php echo (($this->estadoCivil=="3")? "checked" : "" );?> ><label for="out">Outros</label>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Telefone:</label>
						<div class="formRight">
							<input type="tel" name="telefone" value="<?php echo $this->telefone ?>" class="telefone"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Celular:</label>
						<div class="formRight">
							<input type="tel" name="celular" value="<?php echo $this->celular ?>" class="telefone"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>CPF:</label>
						<div class="formRight">
							<input type="text" class="cpf" name="cpf" value="<?php echo $this->cpf ?>"/>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
						<h6>Dados Trabalhista</h6>
					</div>
					<div class="formRow">
						<label>PIS:</label>
						<div class="formRight">
							<input type="text" name="pis" class="pis" value="<?php echo $this->pis ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Número:</label>
						<div class="formRight">
							<input type="text" name="numeroCT" class="numeroCT" value="<?php echo $this->numeroCT ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Série:</label>
						<div class="formRight">
							<input type="text" name="serieCT" class="serieCT" value="<?php echo $this->serieCT ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>RG:<span class="req">ex: 4778617-DGPC-GO</span></label>
						<div class="formRight">
							<input type="text" name="rg" value="<?php echo $this->rg ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Número da CNH:</label>
						<div class="formRight">
							<input type="text" name="cnh" value="<?php echo $this->cnh ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Categoria da CNH:</label>
						<div class="formRight">
							<input type="text" name="cnhCat" style="width:60px" value="<?php echo $this->cnhCat ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Validade da CNH:</label>
						<div class="formRight">
							<input type="text" name="cnhVal" class="datepicker" value="<?php echo $this->cnhVal ?>" />
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
						<h6>Dados Bancários</h6>
					</div>
					<div class="formRow">
						<label>Banco:</label>
						<div class="formRight">
							<select name="banco" id="banco">
								<option value="0">Selecione o Banco</option>
								<?php echo $this->bancos ?>
							</select>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Agência:</label>
						<div class="formRight">
							<input type="text" name="agencia" id="agencia" value="<?php echo $this->agencia ?>"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Conta-Corrente:</label>
						<div class="formRight">
							<input type="text" id="conta" name="conta" value="<?php echo $this->conta ?>"/>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
						<h6>Dados de Contrato</h6>
					</div>
					<div class="formRow">
						<label>Função:</label>
						<div class="formRight">
							<?php echo $this->funcoes ?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Salário Fixo:</label>
						<div class="formRight">
							<input type="text" name="fixo" value="<?php echo $this->fixo ?>" id="fixo" style="width: 100;"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow" id="HidVendedor">
						<label>Comissão:</label>
						<div class="formRight">
							<input type="text" name="comissao" value="<?php echo $this->comissao ?>" id="comissao" style="width: 100;"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Data de Admissão:</label><span class="req alertAdmi"></span>
						<div class="formRight">
							<input type="text" name="admissao" id="admissao" class="datepicker" value="<?php echo $this->admissao ?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Contrato de Experiência?</label>
						<div class="formRight">
							<input type="radio" name="experiencia" class="experiencia" id="sim" value="1" <?php echo (($this->experiencia=="1")? "checked" : "" );?>><label for="sim">Sim</label>
							<input type="radio" name="experiencia" class="experiencia" id="nao" value="0" <?php echo (($this->experiencia=="0")? "checked" : "" );?>><label for="nao">Não</label>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow diasExp">
						<label>Dias de Experiência:</label>
						<div class="formRight">
							<input type="number" name="diasExp" id="diasExpVal" class="int" value="<?php echo $this->diasExp ?>" id="dias" style="width: 100;"/>
						</div>
						<div class="clear"></div>
					</div>
					<div class="formRow">
						<label>Data de Efetivação:</label>
						<div class="formRight">
							<input type="text" name="efetivado" class="datepicker" id="efetivado" value="<?php echo $this->efetivado ?>" />
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</fieldset>
		</div>
	</fieldset>
</form>
<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Funcionarios" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>