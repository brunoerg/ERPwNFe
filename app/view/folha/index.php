<br><br><fieldset>
	<form id="validate" class="form" method="post" action=""name="cadastrar">
		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/dayCalendar.png" alt="" class="titleIcon" />
				<h6>Escolher Periodo</h6>
			</div>
			<div class="formRow">
				<label>M&ecirc;s:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="mes" id="mes"/> ex: 03
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Ano:<span class="req">*</span> </label>
				<div class="formRight">
					<input type="number" class="validate[required]" name="ano" id="ano"/> ex: 2012
						<a href="javascript:document.cadastrar.submit()" title="" class="wButton bluewB ml15 m10" style="margin: 18px 0 0 0; float: right;"> 
						<span>Detalhar</span> </a>
				</div>
				<div class="clear"></div>
			</div>
	</form>
</fieldset>
<a href="<?php echo URL;?>Pdf/Folha<?php if(isset($_POST["mes"])) {echo "/".$_POST["mes"]."-".$_POST["ano"];}?>" target="_blank" title="" class="wButton redwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>PDF </span> 
</a>
<br>
<br>
<hr>
<?php echo $this->folha ?>
<br>
<hr>
<?php echo $this->vendedores ?>