
<a href="<?php echo URL;?>WebService/TransferAll" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;float:left;"> 
	<span>Tranferir Tudo </span> 
</a>
<br><br>
<?=$this->arquivos?>

<script type="text/javascript">
$(function(){
	$(".Transferir").click(function () {




		var objeto = $(this);
		

		var tipo = objeto.attr("tipo");
		var arquivo = objeto.attr("arquivo");

		var parente = $(this).parent().parent().parent().parent();

		var url = "<?=URL?>WebService/Transferir";

		

		$.post( url,
		{
			tipo:tipo,
			arquivo:arquivo
		},
		function(data) {
			if (data=="ok") {
				parente.animate({backgroundColor:"rgba(0,255,0,0.7)", color: "#000"},1000,function(){
					$(".informacaoErro").html("Informações Transferidas com Sucesso!");
					$(this).slideUp(1000);
				});
			}else{
				parente.animate({backgroundColor:"rgba(255,0,0,0.7)", color: "#000"},1000,function(){
					//alert(data);
					$(".informacaoErro").html(data);
				});
			}
		});


	});
});
</script>