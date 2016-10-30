<script type="text/javascript">

$(function(){
	$(".consultaCNPJ").click(function(){
		var cnpj = $("#cnpj").val();;
		$.ajax({
			type: "POST",
			url: '<?=URL?>Clientes/XML',
			dataType: "JSON",
			data: {
				cnpj:cnpj
			},
			success: function(xmls){
				
				if (xmls.false) {
					if (xmls.CodErro==1) {
						alert("Erro de Autenticacao!");
					}else if(xmls.CodErro==3){
						alert("Saldo de consultas acabou por hoje!");	
					}
					
				}else{
					$("#nome").val(xmls.NomeEmpresa);
					
					$("#cidade").val(xmls.Municipio+"/"+xmls.UF);
					
				}
			}
		});
	});
});
</script>
<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Novo Fornecedor</h6>
			</div>
			<div class="formRow">
				<label>Nome:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="nome" id="nome" value="<?php echo $this->nome ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Cidade:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="text" class="validate[required]" name="cidade" id="cidade" value="<?php echo $this->cidade ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Fone: </label>
				<div class="formRight">
					<input type="tel" name="fone" id="telefone" value="<?php echo $this->fone ?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>CNPJ/CPF: </label>
				<div class="formRight">
					<input type="text" name="cnpj" class="cnpj" id="cnpj" value="<?php echo $this->cnpj ?>" style="width:150px;"/>
					<input type='button' value='Buscar Dados do CNPJ' class='consultar consultaCNPJ' style='margin-left:20px;'>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Email: </label>
				<div class="formRight">
					<input type="text" name="email" value="<?php echo $this->email ?>"/>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</fieldset>

<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
	<span>Salvar</span> 
</a>

<a href="<?php echo URL ?>Fornecedores" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
