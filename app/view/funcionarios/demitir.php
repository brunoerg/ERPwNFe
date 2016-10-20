<form id="validate" class="form" method="post" name="cadastrar" >
	<fieldset class="form">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon"/>
				<h6>Demitir Funcionário</h6>
			</div>

			<div class="formRow">
				<label>Nome:</label>
				<div class="formRight">
					<?php echo $this->nome ?>
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

			<div class="formRow">
				<label>PIS:</label>
				<div class="formRight">
					<?php echo $this->pis ?>
				</div>
				<div class="clear"></div>
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
			<div class="formRow">
				<label>Data da Demissão:</label>
				<div class="formRight">
					<input type="text" name="demissao" id="demissao" class="datepicker" value="<?php echo $this->demissao ?>" />
					<a href="javascript:document.cadastrar.submit()" title="" class="wButton redwB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
						<span>Efetivar Demissão</span> 
					</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</fieldset>
</form>
<a href="<?php echo URL ?>Funcionarios" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
<a href="<?php echo URL ?>Funcionarios/Relatorio/<?=$_GET['var3']?>" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Relatório do Funcionário</span> 
</a>
<br><br><br><br><br><br>
