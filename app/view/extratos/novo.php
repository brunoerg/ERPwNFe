<script type="text/javascript">
$(function() {

	$(".foto").hide();

	$(".uploader").pluploadQueue({
		runtimes : 'html5',
		url : '<?=URL?>Extratos/Upload',
		max_file_size : '100mb',
		unique_names : false,
		multi_selection:false,
		filters : false,
		init:
		{	
			FilesAdded: function(up, files) {
                // Callced when files are added to queue
                var txt = "";
                var extension="";
                plupload.each(files, function(file) {
                	
                	extension = file.name.split(".");
                	//alert('  Detalhes:\n'+txt+"Extenção:"+extension[1]);
                	if (extension[1]=="txt" || extension[1]=="bbt"){

                	}else{
                		alert("Arquivo Invalido! Exclua e escolha outro!");
                	}
                });
            },
            FileUploaded: function(up, file, info) {
            	$("#doc").val(info.response);
				//alert(info.response);
				$(".audio").slideUp(1000,function(){
					
					$(".foto").slideDown(1000);	

					$(".returnUp").html(info.response);

				});
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
				<h6>Novo Extrato</h6>
			</div>	<input type="hidden" id="doc" name="doc" value="<?=$this->doc?>" />

			<div class="formRow audio" <?php if(is_file("app/public/funcionarios/".$this->foto)){ echo "style='display:none;'";}?> >
				<label><b>Arquivo do Extrato</b>:<span class="req">*</span> </label>
				<div class="formRight" >
					<div class="uploader" style="width:100%;"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow foto">
				<label><b>Arquivo do Extrato</b>:<span class="req">*</span> </label>
				<div class="formRight" id="uploadedFile">
					<h3 style="color:green;" class="returnUp">Upload Completo!</h3>
				</div>
				<div class="clear"></div>
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
				<label>Mês:</label>
				<div class="formRight">
					<input type="number" class="int" name="mes" style="width:60px" value="<?php echo (($this->mes)? $this->mes : date('m')-1); ?>"/>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Ano:</label>
				<div class="formRight">
					<input type="number" class="int" name="ano" style="width:60px" value="<?php echo (($this->ano)? $this->ano : date('Y')); ?>" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</fieldset>

</form>
<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Extratos" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>