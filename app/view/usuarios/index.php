<br><br><a href="<?php echo URL;?>Usuarios/Novo" title=""
	class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> <span>
		Novo Usu&aacute;rio <!-- Ingles
		Edit Introduction--> <!-- Espanhol
		Editar Introducci&oacute;n--> </span> </a>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
			class="titleIcon" />
		<h6>
			Usu&aacute;rios
			<!-- Ingles
			Education-->
			<!-- Espanhol
			Educaci&oacute;n-->
		</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
		class="display dTable">
		<thead>
			<tr>
				<th>ID <!-- Ingles
            ID--> <!-- Espanhol
            ID-->
				</th>
				<th>Nome</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
		<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
