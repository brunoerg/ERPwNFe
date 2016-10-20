<script type="text/javascript">
	
	$(function(){
		$("#dias").keyup(function(e){

			dias = $(this).val(); 

			$(".titulo").html("<th>ID</th><th>N&uacute;mero</th><th>Cliente</th><th>Vendedor</th><th>Dias</th><th>Valor</th><th>Data</th><th>Compensa&ccedil;&atilde;o</th><th>A&ccedil;&otilde;es</th>");
			


			$(".resultado").html("<tr><th colspan='9' class='center'><img src='<?=Folder?>images/icons/uploader/throbber.gif' style='padding:20px;'></th></tr>");
			$.post("<?=URL.$_GET['var1']?>/LimiteDias",
	 		{dias: dias}, 
	 		function(data) { 
	 			//alert(data);
	 			$(".resultado").html(data); 
	 		});
			
		});
	});

</script><br><br>
<a href="<?php echo URL;?>ChequesClientes/Adicionar" title="" class="wButton greenwB ml15 m10" style="margin: 18px 18px -13px 0;"> 
	<span>Cadastrar Cheque </span> 
</a>



<!-- Dynamic table -->
<div class="widget">
	<div class="title">
		<img src="<?php echo Folder;?>images/icons/dark/pencil.png" alt="" class="titleIcon" />
		<h6>
			Cheques de Clientes - Em Caixa : R$
			<?php echo $this->total?>  |  Limite de Dias.: <input type="number" class="int" id='dias' style="width:50px;" />
		</h6>

	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
		<thead>
			<tr class="titulo">
				<th>ID</th>
				<th>N&uacute;mero</th>
				<th>Cliente</th>
				<th>Vendedor</th>
				<th>Pago a</th>
				<th>Valor</th>
				<th>Data</th>
				<th>Compensa&ccedil;&atilde;o</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>

		</thead>
		<tbody class="resultado">
			<?php echo $this->lista;?>
		</tbody>
	</table>
	<?php if (isset($this->total)) { ?>
	<div class="title">

		<h6>
			Total: R$
			<?php echo number_format($this->total,2,",",".") ?>
			- <?php echo $this->compensados ?> Cheques Compensados 
			( <?php echo substr($this->numeros, 1); ?> )
			: R$
			<?php echo number_format($this->vCompensados,2,",",".") ?>
		</h6>
	</div>
	<?php } ?>
</div>
