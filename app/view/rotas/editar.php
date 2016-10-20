<fieldset>
	<form id="validate" class="form" method="post" action="" name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
				<h6>Cadastro de Venda</h6>
			</div>

			<div class="formRow">
				<label>Cidade:</label>
				<div class="formRight">
					<select name="cidade">
						<option value="0">Selecione a Cidade</option>
						<?php echo $this->selectCidades ?>
					</select>
					<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 0px 0px 0px 30px; float: left;"> 
						<span>Salvar</span> 
					</a>
				</div>

				<div class="clear"></div>
			</div>
		</form>
		<div class="formRow">
			<label>Nova Cidade:</label>
			<div class="formRight">
				<a href="<?php echo URL; ?>Municipios/Adicionar" target="_blank" class="wButton redwB ml15 m10" style="margin: -5px 0px 0px 30px; float: left;"> 
					<span>Adicionar Cidade</span> 
				</a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Cidades:</label>
			<div class="formRight">
				<ol style='list-style:decimal inside;'>
					<?php echo $this->cidades ?>
					<ol>
					</div>
					<div class="clear"></div>
				</div>


			</div>
			

		</fieldset>
		<a href="<?php echo URL ?>Rotas" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
			<span>Voltar</span> 
		</a>

		<a href="<?php echo URL ?>Rotas/Detalhes/<?php echo $_GET["var3"]?>" title="" class="wButton redwB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
			<span>Detalhes</span> 
		</a>
