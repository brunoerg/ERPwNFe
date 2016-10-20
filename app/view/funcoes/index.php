<br><br><a href="<?php echo URL;?>Funcao/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span> Nova Função na Empresa </span> 
</a>
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>Funções na Empresa</h6>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Comissionado</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->lista;?>
		</tbody>
	</table>
</div>