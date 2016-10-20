<br><br><a href="<?php echo URL;?>Extratos/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> Novo Extrato </span> 
</a>

<fieldset class="hidden">
	<form id="validate" class="form" method="post" action="<?=URL.$_GET['var1']?>/Visualizar" name="cadastrar">

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/dayCalendar.png" alt="" class="titleIcon" />
				<h6>Visualizar Relatório Bancário de:</h6>
			</div>

			<div class="formRow">
				<label>Mês:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required] int" value="<?=date("m")-1?>" name="mes" id="mes"/> ex: 03
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<label>Ano:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required] int" value="<?=date("Y")?>" name="ano" id="ano"/> ex: 2013
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>

	<a href="javascript:document.cadastrar.submit()" title="" class="wButton bluewB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
		<span>Detalhar</span> 
	</a>
</fieldset>

<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Extratos</h6>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Mês</th>
				<th>Ano</th>
				<th>Banco</th>
				<th>Agência</th>
				<th>Conta</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div><br><br><br><br><br><br>