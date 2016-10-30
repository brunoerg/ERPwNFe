<script>
$(function(){
	

	$("#resultado").hide();

	$("#receber").hide();

	$("#botao").click(function(){

		chave = $("#chave").val(); 

		$("#resultado").slideDown("slow");
		$("#resultado").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");

		
		
		$.post("<?php echo URL; ?>NFe/ConfirmNFe",
		{
			chave: chave,
			tpAmb: '1',
			SOAP: '2',
			numero: '<?php echo $this->numero; ?>'
		}, 
		function(data) { 
			$("#resultado").html(data); 
			
			

			$("#botao").fadeOut("slow",function(){
				$("#receber").fadeIn("slow");	
			});
			

		});
		
	});


	$("#receber").click(function(){

		$("#resultado").slideDown("slow");
		$("#resultado").html("<img src='<?php echo Folder; ?>images/icons/uploader/throbber.gif'>");


		chave = $("#chave").val(); 
		
		$.post("<?php echo URL; ?>NFe/GetNFe",
		{
			chave: chave
		}, 
		function(data) {

			//alert(data);

			$("#resultado").html(data); 
		});
		
	});
	
});
</script>



<!-- Validation form -->
<fieldset class="form">
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
			<h6>Buscar NFe no Sefaz</h6>
		</div>
		<div class='formRow'>
			<label>Chave:</label>
			<div class='formRight'>
				<input type='text' name="chave" id="chave"  value='<?php echo $this->chave; ?>'  style="width:80%;"/>

				<a title="" id="botao" class="wButton greenwB ml15 m10" style="margin: 0px 0px 0 0; float:right; cursor:pointer;"> 
					<span>Confirmar NFe</span> 
				</a>
				<a title="" id="receber" class="wButton greenwB ml15 m10" style="margin: 0px 0px 0 0; float:right; cursor:pointer;"> 
					<span>Receber XML</span> 
				</a>
			</div>

			<div class='clear'></div>		
		</div>
		<div class='formRow' id="resultado" style="width:90%; display:block; white-space: normal;">
			
			<div class='clear'></div>
		</div>

	</div>

</fieldset>


<a href="<?php echo URL ?>NFeEntrada/Listar" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: left;"> 
	<span>Voltar</span> 
</a>
