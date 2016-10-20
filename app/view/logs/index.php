<fieldset>
	<form id="validate" class="form" method="post" action=""
		name="cadastrar" >

		<div class="widget">
			<div class="title">
				<img src="<?php echo Folder ?>images/icons/dark/priceTag.png" alt=""
					class="titleIcon" />
				<h6>Escolher Dia</h6>
			</div>

			<div class="formRow">
				<label>Data:</label>
				<div class="formRight">
					<input type="text" name="data" class="datepicker" />
				</div>
				<div class="clear"></div>
			</div>
	
	</form>

	<a href="javascript:document.cadastrar.submit()" title=""
		class="wButton greenwB ml15 m10"
		style="margin: 18px 0 0 0; float: right;"> <span>Ver</span> </a>
</fieldset>



<?php if($this->log==true){?>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
			class="titleIcon" />
		<h6>Log</h6>

	</div>

	<div>
		<ol
			style='margin-left: 20px;'>

			<?php echo $this->log ?>


		</ol>
	</div>
</div>
			<?php } ?>