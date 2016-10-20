<script>
$(function(){
	


	$("#retorno").hide();

	$("#Cancelar").click(function(){

		chNFe = $("#chNFe").val(); 
		nProt = $("#nProt").val(); 
		tpAmb = $("#tpAmb").val(); 
		motivo = $("#motivo").val(); 

		$("#retorno").slideDown("slow");
		$("#resultado").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");

		//alert(chNFe+" - "+nProt+" - "+tpAmb+" - "+motivo+"!");

		
		
		$.post("<?php echo URL; ?>NFe/CancelarNFe",
		{
			chNFe: chNFe,
			nProt: nProt,
			tpAmb: tpAmb,
			motivo: motivo
		}, 
		function(data) { 

			if (data==false) {

				$("#resultado").html("Confirmando Cancelamento... <img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");
				
				setTimeout(function() {
					receber();

				}, 2000);

			}else{
				$("#resultado").html(data); 
			}


		});

		
	});


	function receber(){

		chNFe = $("#chNFe").val(); 
		tpAmb = $("#tpAmb").val(); 
		
		$.post("<?php echo URL; ?>NFe/RetornoCanc",
		{
			chNFe: chNFe,
			tpAmb: tpAmb
		}, 
		function(data) {

			$("#resultado").html(data); 
		});
		
	}
	
});
</script>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cancelar Nota Fiscal</h6>
			</div>



			<div class="formRow">
				<label>Chave de Acesso da NFe:</label>
				<div class="formRight">
					<?php echo $this->chNFe; ?>
					<input type="hidden" id="chNFe"  value="<?php echo $this->chNFe; ?>" />

				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Numero de Protocolo:</label>
				<div class="formRight">
					<?php echo $this->nProt; ?>
					<input type="hidden" id="nProt" value="<?php echo $this->nProt; ?>" />

				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tipo de Ambiente:</label>
				<div class="formRight">
					<?php echo $this->tpAmb; ?>
					<input type="hidden" id="tpAmb" value="<?php echo $this->tpAmb; ?>" />

				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Motivo de Cancelamento:</label>
				<div class="formRight">
					<textarea id="motivo" rows="10" cols=""></textarea>
				</div>
				<div class="clear"></div>
			</div>
		</div>


		<div class="widget" id="retorno">
			<div class="formRow">
				<label>Retorno:</label>
				<div class='formRight' id="resultado" style="width:90%; display:block; white-space: normal;">


				</div>
				<div class="clear"></div>
			</div>

		</div>
	</form>

</fieldset>

<a id="Cancelar" class="wButton redwB ml15 m10" style="margin: 18px 0 0 0; float: right;cursor:pointer;"> 
	<span>Cancelar</span> 
</a>

<a href="<?php echo URL ?>NFe" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;">
	<span>Voltar</span> 
</a>
<br><br><br><br><br><br><br><br><br>