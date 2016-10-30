<link rel="stylesheet" href="<?php echo Folder ?>css/boletos.css" type="text" />


<div id="container">


	<!-- id="instr_header" -->

<div id="instructions">
	<!--
  Use no lugar do <div id=""> caso queira imprimir sem o logotipo e instru��es
  <div id="instructions">
 -->
	<div id="instr_header">
		<h1>
		<?php echo $this->dadosboleto["identificacao"]; ?>
		<?php echo isset($this->dadosboleto["cpf_cnpj"]) ? $this->dadosboleto["cpf_cnpj"] : '' ?>
		</h1>
		<address>
		<?php echo $this->dadosboleto["endereco"]; ?>
			<br>
		</address>
		<address>
		<?php echo $this->dadosboleto["cidade_uf"]; ?>
		</address>
	</div>
	<br>
	<div id="instr_content">
		<p>O pagamento deste boleto tamb&eacute;m poder&aacute; ser efetuado
			nos terminais de Auto-Atendimento BB.</p>

		<h2>Instru&ccedil;&otilde;es</h2>
		<ol>
			<li>Imprima em impressora jato de tinta (ink jet) ou laser, em
				qualidade normal ou alta. N&atilde;o use modo econ&ocirc;mico.
				<p class="notice">Por favor, configure margens esquerda e direita
					para 17mm.</p>
			</li>
			<li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens
				m&iacute;nimas &agrave; esquerda e &agrave; direita do
				formul&aacute;rio.</li>
			<li>Corte na linha indicada. N&atilde;o rasure, risque, fure ou dobre
				a regi&atilde;o onde se encontra o c&oacute;digo de barras</li>
		</ol>
	</div>
	<!-- id="instr_content" -->
</div>
<!-- id="instructions" -->

<div id="boleto">
	<div class="cut">
		<p>Corte na linha pontilhada</p>
	</div>
	<table cellspacing=0 cellpadding=0 width=90% border=0>
		<TBODY>
			<TR>
				<TD class=ct width=90%><div align=right>
						<b class=cp>Recibo do Sacado</b>
					</div></TD>
			</tr>
		</tbody>
	</table>
	<table class="header" border=0 cellspacing="0" cellpadding="0"
		width="90%">
		<tbody>
			<tr>
				<td width=150><IMG
					SRC="<?php echo Folder?>images/boletos/logobb.jpg">
				</td>
				<td width=50>
					<div class="field_cod_banco">
					<?php echo $this->dadosboleto["codigo_banco_com_dv"]?>
					</div>
				</td>
				<td class="linha_digitavel" style="min-width:600px;"><?php echo $this->dadosboleto["linha_digitavel"]?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
			<tr class="titulos">
				<td class="cedente">Cedente</td>
				<td class="ag_cod_cedente">Ag&ecirc;ncia / C&oacute;digo do Cedente</td>
				<td class="especie">Esp&eacute;cie</td>
				<td class="qtd">Quantidade</td>
				<td class="nosso_numero">Nosso n&uacute;mero</td>
			</tr>

			<tr class="campos">
				<td class="cedente"><?php echo $this->dadosboleto["cedente"]; ?>&nbsp;</td>
				<td class="ag_cod_cedente"><?php echo $this->dadosboleto["agencia_codigo"]?>
					&nbsp;</td>
				<td class="especie"><?php echo $this->dadosboleto["especie"]?>&nbsp;</td>
				<TD class="qtd"><?php echo $this->dadosboleto["quantidade"]?>&nbsp;</td>
				<TD class="nosso_numero"><?php echo $this->dadosboleto["nosso_numero"]?>&nbsp;</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
			<tr class="titulos">
				<td class="num_doc">N&uacute;mero do documento</td>
				<td class="contrato">Contrato</TD>
				<td class="cpf_cei_cnpj">CPF/CEI/CNPJ</TD>
				<td class="vencmento">Vencimento</TD>
				<td class="valor_doc">Valor documento</TD>
			</tr>
			<tr class="campos">
				<td class="num_doc"><?php echo $this->dadosboleto["numero_documento"]?>
				</td>
				<td class="contrato"><?php echo $this->dadosboleto["contrato"]?></td>
				<td class="cpf_cei_cnpj"><?php echo $this->dadosboleto["cpf_cnpj"]?>
				</td>
				<td class="vencimento"><?php echo $this->dadosboleto["data_vencimento"]?>
				</td>
				<td class="valor_doc"><?php echo $this->dadosboleto["valor_boleto"]?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
			<tr class="titulos">
				<td class="desconto">(-) Desconto / Abatimento</td>
				<td class="outras_deducoes">(-) Outras dedu&ccedil;&otilde;es</td>
				<td class="mora_multa">(+) Mora / Multa</td>
				<td class="outros_acrescimos">(+) Outros acr&eacute;scimos</td>
				<td class="valor_cobrado">(=) Valor cobrado</td>
			</tr>
			<tr class="campos">
				<td class="desconto">&nbsp;</td>
				<td class="outras_deducoes">&nbsp;</td>
				<td class="mora_multa">&nbsp;</td>
				<td class="outros_acrescimos">&nbsp;</td>
				<td class="valor_cobrado">&nbsp;</td>
			</tr>
		</tbody>
	</table>


	<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
			<tr class="titulos">
				<td class="sacado">Sacado</td>
			</tr>
			<tr class="campos">
				<td class="sacado"><?php echo $this->dadosboleto["sacado"]?></td>
			</tr>
		</tbody>
	</table>

	<div class="footer" style="margin-bottom:0px;">
		<p>Autentica&ccedil;&atilde;o mec&acirc;nica</p>
	</div>

	<div class="cut">
		<p>Corte na linha pontilhada</p>
	</div>


	<table class="header" border=0 width="100%" cellspacing="0"
		cellpadding="0">
		<tbody>
			<tr>
				<td width=150><IMG
					SRC="<?php echo Folder?>images/boletos/logobb.jpg">
				</td>
				<td width=50>
					<div class="field_cod_banco">
					<?php echo $this->dadosboleto["codigo_banco_com_dv"]?>
					</div>
				</td>
				<td class="linha_digitavel" style="min-width:600px;"><?php echo $this->dadosboleto["linha_digitavel"]?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
			<tr class="titulos">
				<td class="local_pagto">Local de pagamento</td>
				<td class="vencimento2">Vencimento</td>
			</tr>
			<tr class="campos">
				<td class="local_pagto">QUALQUER BANCO AT&Eacute; O VENCIMENTO</td>
				<td class="vencimento2"><?php echo $this->dadosboleto["data_vencimento"]?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
			<tr class="titulos">
				<td class="cedente2">Cedente</td>
				<td class="ag_cod_cedente2">Ag&ecirc;ncia/C&oacute;digo cedente</td>
			</tr>
			<tr class="campos">
				<td class="cedente2"><?php echo $this->dadosboleto["cedente"]?></td>
				<td class="ag_cod_cedente2"><?php echo $this->dadosboleto["agencia_codigo"]?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
			<tr class="titulos">
				<td class="data_doc">Data do documento</td>
				<td class="num_doc2">No. documento</td>
				<td class="especie_doc">Esp&eacute;cie doc.</td>
				<td class="aceite">Aceite</td>
				<td class="data_process">Data process.</td>
				<td class="nosso_numero2">Nosso n&uacute;mero</td>
			</tr>
			<tr class="campos">
				<td class="data_doc"><?php echo $this->dadosboleto["data_documento"]?>
				</td>
				<td class="num_doc2"><?php echo $this->dadosboleto["numero_documento"]?>
				</td>
				<td class="especie_doc"><?php echo $this->dadosboleto["especie_doc"]?>
				</td>
				<td class="aceite"><?php echo $this->dadosboleto["aceite"]?></td>
				<td class="data_process"><?php echo $this->dadosboleto["data_processamento"]?>
				</td>
				<td class="nosso_numero2"><?php echo $this->dadosboleto["nosso_numero"]?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
			<tr class="titulos">
				<td class="reservado">Uso do banco</td>
				<td class="carteira">Carteira</td>
				<td class="especie2">Esp&eacute;cie</td>
				<td class="qtd2">Quantidade</td>
				<td class="xvalor">x Valor</td>
				<td class="valor_doc2">(=) Valor documento</td>
			</tr>
			<tr class="campos">
				<td class="reservado">&nbsp;</td>
				<td class="carteira"><?php echo $this->dadosboleto["carteira"]?> <?php echo isset($this->dadosboleto["variacao_carteira"]) ? $this->dadosboleto["variacao_carteira"] : '&nbsp;' ?>
				</td>
				<td class="especie2"><?php echo $this->dadosboleto["especie"]?></td>
				<td class="qtd2"><?php echo $this->dadosboleto["quantidade"]?></td>
				<td class="xvalor"><?php echo $this->dadosboleto["valor_unitario"]?>
				</td>
				<td class="valor_doc2"><?php echo $this->dadosboleto["valor_boleto"]?>
				</td>
			</tr>
		</tbody>
	</table>


	<table class="line" cellspacing="0" cellpadding="0"  style='height:190px;'>
		<tbody>
			<tr>
				<td class="last_line" rowspan="6">
					<table class="line" cellspacing="0" cellpadding="0" >
						<tbody>
							<tr class="titulos" >
								<td class="instrucoes">Instru&ccedil;&otilde;es (Texto de
									responsabilidade do cedente)</td>
							</tr>
							<tr class="campos"  >
								<td class="instrucoes" rowspan="5" >
									<p style='margin-top:-50px;'>
									<?php echo $this->dadosboleto["demonstrativo1"]; ?>
									</p>
									<p>
									<?php echo $this->dadosboleto["demonstrativo2"]; ?>
									</p>
									<p>
									<?php echo $this->dadosboleto["demonstrativo3"]; ?>
									</p>
									<p>
									<?php echo $this->dadosboleto["instrucoes1"]; ?>
									</p>
									<p>
									<?php echo $this->dadosboleto["instrucoes2"]; ?>
									</p>
									<p>
									<?php echo $this->dadosboleto["instrucoes3"]; ?>
									</p>
									<p>
									<?php echo $this->dadosboleto["instrucoes4"]; ?>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<tr>
				<td >
					<table class="" cellspacing="0" cellpadding="0">
						<tbody>
							<tr class="titulos" >
								<td class="desconto2">(-) Desconto / Abatimento</td>
							</tr>
							<tr class="campos" style="margin-top:-30px;">
								<td class="desconto2">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<table class="line" cellspacing="0" cellpadding="0">
						<tbody>
							<tr class="titulos">
								<td class="outras_deducoes2">(-) Outras dedu&ccedil;&otilde;es</td>
							</tr>
							<tr class="campos">
								<td class="outras_deducoes2">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<table class="line" cellspacing="0" cellpadding="0">
						<tbody>
							<tr class="titulos">
								<td class="mora_multa2">(+) Mora / Multa</td>
							</tr>
							<tr class="campos">
								<td class="mora_multa2">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<table class="line" cellspacing="0" cellpadding="0">
						<tbody>
							<tr class="titulos">
								<td class="outros_acrescimos2">(+) Outros Acr&eacute;scimos</td>
							</tr>
							<tr class="campos">
								<td class="outros_acrescimos2">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<tr>
				<td class="last_line">
					<table class="line" cellspacing="0" cellpadding="0">
						<tbody>
							<tr class="titulos">
								<td class="valor_cobrado2">(=) Valor cobrado</td>
							</tr>
							<tr class="campos">
								<td class="valor_cobrado2">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>


	<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
			<tr class="titulos">
				<td class="sacado2">Sacado</td>
			</tr>
			<tr class="campos">
				<td class="sacado2">
					<p style="margin-top:-20px;">
					<?php echo $this->dadosboleto["sacado"]?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
			<tr class="titulos">
				<td class="sacador_avalista" colspan="2">Sacador/Avalista</td>
			</tr>
			<tr class="campos">
				<td class="sacador_avalista">&nbsp;</td>
				<td class="cod_baixa">C&oacute;d. baixa</td>
			</tr>
		</tbody>
	</table>
	<table cellspacing=0 cellpadding=0 width=666 border=0>
		<TBODY>
			<TR>
				<TD width=666 align=right><font style="font-size: 10px; margin-bottom:0px;">Autentica&ccedil;&atilde;o
						mec&acirc;nica - Ficha de Compensa&ccedil;&atilde;o</font></TD>
			</tr>
		</tbody>
	</table>
	<div class="barcode">
		<p>
		<?php echo $this->dadosboleto["barcode"]."<br>".$this->dadosboleto["codigo_barras"]; ?>
		</p>
	</div>
</div>

</div>
