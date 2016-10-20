<a href="<?php echo URL;?>Reducoes/Cadastrar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Cadastrar Redu&ccedil;&atilde;o Z </span> 
</a>


<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Redu&ccedil;&otilde;es Z</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>Cod.</th>
				<th>Contador</th>
				<th>Data de Emiss&atilde;o</th>
				<th>Valor</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>
