<script type="text/javascript">
$(function() {

	
	$(".docsView").click(function(e){

		var y = e.pageY ;

		var altura = $(window).height();
		
		if (y>altura) {
			var posY = y-altura;
		}else{
			var posY = altura-y;
		}
		

		var link = $(this).attr("link");

		$("#bgDark").fadeIn("slow",function(){
			
			$("#pageView").slideDown(1000);
			$("#pageView iframe").attr("src",link);

			$("#pageView").animate({"margin-top":posY},500,function(){

				if ($('#iframeView').contents().find('img').width()) {
					$('html,body').animate({scrollTop:(posY+300)}, 800);
					var widthPage = $('#iframeView').contents().find('img').width();
					var heightPage = $('#iframeView').contents().find('img').height();

					var largura = $(window).width();

					var posX = ((largura-widthPage)/4);

					$("#pageView").animate({"margin-top":posY,"margin-left":posX,"width":widthPage,"height":heightPage},500);
				}else{
					$('html,body').animate({scrollTop:(posY)}, 800);
					$("#pageView").animate({"margin-top":posY-300,"width":"80%","height":"auto"},500);
				}
				

			});
			
		});



	});



$("#bgDark").click(function(){
	$(this).fadeOut("slow");
	$("#pageView").slideUp(1000,function(){
		$("#pageView iframe").attr("src","");	
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
<fieldset class="form">
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
			<h6>Relatório do Funcionário</h6>
		</div>
		<fieldset>
			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
					<h6>Dados Pessoais</h6>
				</div>
				<input type="hidden" id="foto" name="foto" />

				<div class="formRow audio" <?php if(is_file("app/public/funcionarios/".$this->foto)){ echo "style='display:none;'";}?> >
					<label><b>Foto:</b>:<span class="req">*</span> </label>
					<div class="formRight" >
						<i>Nenhuma foto Cadastrada! 
							<a href="<?php echo URL ?>Funcionarios/Editar/<?=$_GET['var3']?>" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0;"> 
								<span>Editar esse Funcionário</span> 
							</a>
						</i>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow fotoUp" <?php if(!file_exists("app/public/funcionarios/".$this->foto) || $this->foto==false){ echo "style='display:none;'";}?>>
					<label><b>Foto:</b>:<span class="req">*</span> </label>
					<div class="formRight" id="uploadedFile">
						<img src='<?=Folder?>funcionarios/<?=$this->foto?>' class="docsView" link="<?=Folder?>funcionarios/<?=$this->foto?>" height='200px' style='float:left;'/>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Nome:</label>
					<div class="formRight">
						<?php echo $this->nome ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Sexo:</label>
					<div class="formRight">
						<?php echo (($this->sexo=="1")? "Masculino" : "Feminino" );?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Data de Nascimento:</label>
					<div class="formRight">
						<?php echo $this->nascimento ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Endereço:</label>
					<div class="formRight">
						<?php echo $this->endereco ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Estado Civil:</label>
					<div class="formRight">
						<?php echo $this->estadoCivil ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Telefone:</label>
					<div class="formRight">
						<?php echo $this->telefone ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>CPF:</label>
					<div class="formRight">
						<?php echo $this->cpf ?>
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
						<?php echo $this->pis ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>RG:</label>
					<div class="formRight">
						<?php echo $this->rg ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Número da CNH:</label>
					<div class="formRight">
						<?php echo $this->cnh ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Categoria da CNH:</label>
					<div class="formRight">
						<?php echo $this->cnhCat ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Validade da CNH:</label>
					<div class="formRight">
						<?php echo $this->cnhVal ?>
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
						<?php echo $this->banco ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Agência:</label>
					<div class="formRight">
						<?php echo $this->agencia ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Conta-Corrente:</label>
					<div class="formRight">
						<?php echo $this->conta ?>
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
						<?php echo $this->funcao ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Salário Fixo:</label>
					<div class="formRight">
						R$ <?php echo number_format($this->fixo,2,",",".") ?>
					</div>
					<div class="clear"></div>
				</div>
				<?php if($this->comissao!="0" || isset($this->comissao)){?>
				<div class="formRow" id="HidVendedor">
					<label>Comissão:</label>
					<div class="formRight">
						<?php echo $this->comissao ?> %
					</div>
					<div class="clear"></div>
				</div>
				<?php }?>
				<div class="formRow">
					<label>Data de Admissão:</label>
					<div class="formRight">
						<?php echo $this->admissao ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Contrato de Experiência?</label>
					<div class="formRight">
						<?php echo (($this->experiencia=="1")? "Sim" : "Não" );?>
					</div>
					<div class="clear"></div>
				</div>
				<?php if($this->experiencia=="1"){?>
				<div class="formRow diasExp">
					<label>Dias de Experiência:</label>
					<div class="formRight">
						<?php echo $this->diasExp ?>
					</div>
					<div class="clear"></div>
				</div>
				<?php }?>
				<div class="formRow">
					<label>Data de Efetivação:</label>
					<div class="formRight">
						<?php echo $this->efetivado ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</fieldset>
		<?php if($_GET["var3"]){?>
		<fieldset>
			<div class="widget">
				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
					<h6>Documentos do Funcionário</h6>
				</div>
				<input type="hidden" id="foto" name="foto" />
				<div class="formRow">
					<label><b>Upload de Documentos:</b>:<span class="req">*</span> </label>
					<div class="formRight" >
						<div class="documents" style="width:100%;"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label><b>Documentos:</b>:<span class="req">*</span> </label>
					<div class="formRight">
						<ul class="documentosUp">
							<?=$this->docs?>
						</ul>

					</div>
					<div class="clear"></div>
				</div>
			</div>
		</fieldset>
		<?php } ?>
	</div>
</fieldset>
<a href="<?php echo URL ?>Funcionarios" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
<?php if($this->ativo=="1"){?>
<a href="<?php echo URL ?>Funcionarios/Demitir/<?=$_GET['var3']?>" title="" class="wButton redwB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Demitir</span> 
</a>
<?php }else{ ?>
<a href="<?php echo URL ?>Funcionarios/Efetivar/<?=$_GET['var3']?>" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Efetivar</span> 
</a>
<?php } ?>
