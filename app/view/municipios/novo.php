<script type="text/javascript">
	$(function(){


		$("#nome").keyup(function(){
			var cidade = $(this).val();

			$.post("<?php echo URL; ?>Municipios/Pesquisar", 
				{cidade:cidade},
				function(result){
					$(".result").html(result);
				});
		});

	});


</script>
<!-- Validation form -->
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt="" class="titleIcon" />
				<h6>Cadastrar Municipio</h6>
			</div>

			

			<div class="formRow">
				<label>Codigo IBGE:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="codigo" id="codigo" value="<?php echo $this->codigo ?>" />
				</div>

				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Nome:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="nome" id="nome" value="<?php echo $this->nome ?>"  />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow" >
				<label>Pesquisa:</label>
				<div class="formRight result">
					
				</div>

				<div class="clear"></div>
			</div>
		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Municipios" title=""	class="wButton bluewB ml15 m10"	style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
