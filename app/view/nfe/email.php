<fieldset class="form">
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/user.png" alt="" class="titleIcon" />
			<h6>Cadastrar NFe Entrada</h6>
		</div>
		<div class='formRow'>
			<label>Remetente:</label>
			<div class='formRight'>
				<input type='text' id="assunto" value="NFe de numero <?php echo $_GET['var3']; ?> - Way Distribuição"/>
			</div>
			<div class='clear'></div>
		</div>
		<div class="formRow">
			<label>Mensagem:</label>
			<div class="formRight">
				<textarea id="mensagem" rows="10" cols="">
				</textarea>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow" id="result" style="text-align:center;">
			<div class="clear"></div>
		</div>
	</div>
</fieldset>

<a  title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0; float: right; cursor:pointer;" id="enviar"> 
	<span>Enviar</span> 
</a>

<a href="<?php echo URL ?>NFe/Recebidas" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
	<span>Voltar</span> 
</a>
