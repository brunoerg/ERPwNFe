<script type="text/javascript">


//desenvolve o sistema de lucro
$(function(){
	


	venda = $("#venda").attr("value");
	compra = $("#compra").attr("value");

	lucro = (venda - compra)/venda;
	valor = (venda-compra);	

	$("#lucrop").html((lucro*100));
	$("#lucror").html(valor);



	$("#venda").change(function(){
		
		venda = $("#venda").attr("value");
		compra = $("#compra").attr("value");

		lucro = (venda - compra)/venda;
		valor = (venda-compra);

		$("#lucrop").html((lucro*100));
		$("#lucror").html(valor);
		
	});

	$("#compra").change(function(){
		
		venda = $("#venda").attr("value");
		compra = $("#compra").attr("value");

		lucro = (venda - compra)/venda;
		valor = (venda-compra);

		$("#lucrop").html((lucro*100));
		$("#lucror").html(valor);
		
	});

	
})

</script>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Novo Produto</h6>
			</div>
			<div class="formRow">
				<label>Nome:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="nome" value="<?php echo $this->nome ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Quantidade:<span class="req"></span> </label>
				<div class="formRight">
					<input type="number" class="" name="quantidade" value="<?php echo $this->quantidade ?>" /> (x1)
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Unidade de Medida:<span class="req">(cx,pt,fd)</span> </label>
				<div class="formRight">
					<input type="text" class="" name="unidade" value="<?php echo $this->unidade ?>" />
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Peso:<span class="req"></span> </label>
				<div class="formRight">
					<input type="number" class="" name="peso" value="<?php echo $this->peso ?>" /> kg
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Pre&ccedil;o de Compra:<span class="req">*</span> </label>
				<div class="formRight">
					R$ <input type="number" class="" name="compra" id="compra" value="<?php echo $this->compra ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Pre&ccedil;o de Venda:<span class="req">*</span> </label>
				<div class="formRight">
					R$ <input type="number" class="" name="venda" id="venda" value="<?php echo $this->venda ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Lucro:<span class="req"></span> </label>
				<div class="formRight">
					&nbsp;% <span id="lucrop"></span><br> R$ <span id="lucror"></span>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Distribuidor:</label>
				<div class="formRight">
					<select name="distribuidor">
						<option value="0">Selecione o Distribuidor</option>
						<?php echo $this->distribuidor ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>


		</div>
	</form>

</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Catalogo" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a><br><br><br><br><br><br><br><br><br>
