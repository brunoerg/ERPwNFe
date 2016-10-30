<br><br>
<a href="<?php echo URL;?>Balanco/Criar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>
		Criar Balan&ccedil;o 
	</span>
</a>

<a href="<?php echo URL;?>Pdf/Balanco" title="" class="wButton redwB ml15 m10" style="margin: 18px 18px -13px 0;" target="_blank"> 
	<span>
		<img src='<?php echo Folder;?>images/icons/control/new/pdf.png' alt='' height='16' />
		Lista de Balan&ccedil;o 
	</span>
</a>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt=""
		class="titleIcon" />
		<h6>Balan&ccedil;os</h6>
	</div>

	<table cellpadding="0" cellspacing="0" border="0"
	class="display dTable">
	<thead>
		<tr>
				<th>ID <!-- Ingl�s
            ID--> <!-- Espanhol
            ID-->
        </th>
        <th>Vendedor</th>
        <th>Data</th>
        <th>A&ccedil;&otilde;es</th>
    </tr>

</thead>
<tbody>
	<?php echo $this->lista;?>
</tbody>
</table>
</div>
