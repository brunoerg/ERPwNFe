<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Balan&ccedil;os</h6>
	</div>
	<form method="post" action="" name="cadastrar">
		<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
			<thead>
				<tr>
					<th></th>
					<th>Numero</th>
					<th>Destinat&aacute;rio</th>
					<th>Emiss&atilde;o</th>
					<th>Chave</th>
				</tr>
			</thead>
			<tbody>
				<?php echo $this->lista;?>
			</tbody>
		</table>
	</form>
</div>
<a href="javascript:document.cadastrar.submit()" title="" class="wButton greenwB ml15 m10" style="margin: 18px 0 0 0;"> 
	<span> Reproduzir NFe </span> 
</a>