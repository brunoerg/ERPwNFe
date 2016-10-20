<a href="<?php echo URL;?>Vendas/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Cadastrar Venda </span>
</a>


<fieldset>
	<form id="validate" class="form" method="post" target="_blank" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/dayCalendar.png" alt="" class="titleIcon" />
				<h6>Escolher Periodo para Relat&oacute;rio</h6>
			</div>
			<div class="formRow">
				<label>M&ecirc;s:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="mes" id="mes"	id="req" /> ex: 03
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Ano:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="ano" id="ano" id="req" /> ex: 2012
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
	<a href="javascript:document.cadastrar.submit()" title="" class="wButton bluewB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
		<span>Detalhar</span> 
	</a>
</fieldset>


<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Vendas</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID </th>
				<th>Vendedor</th>
				<th>Valor</th>
				<th>Data</th>
				<th>Balanço</th>
				<th width="10%">A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
