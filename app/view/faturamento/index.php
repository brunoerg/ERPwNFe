<br><br><fieldset class="hidden">
	<form id="validate" class="form" method="post" action="" name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/dayCalendar.png" alt="" class="titleIcon" />
				<h6>Escolher Periodo</h6>
			</div>
			<div class="formRow">
				<label>Meses:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" name="meses" id="meses"/> ex: 03
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
		<h6>Faturamento</h6>
		<a href="<?php echo URL;?>Pdf/Faturamento/<?=$_POST['meses']?>" title="" target="_blank" > 
			<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' height="25" style="margin-top:5px;"/>
		</a>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>Ano</th>
				<th>Mês</th>
				<th>Venda A Vista</th>
				<th>Venda A Prazo</th>
				<th>Venda Total</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>