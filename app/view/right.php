<!-- ESSE E O MENU EXPANSIVO ------ DE CIMA Right side -->
<div id="rightSide">
	<div class="topNav">
		<div class="wrapper">
			<div class="userNav">
				<ul>
					<li>
						<a id="urParent" title="Data/Hora">
							<img src="<?php echo Folder ?>images/icons/light/clock.png" alt="" />
							<span id="ur"></span>
						</a>
					</li>
					<li>
						<a class="FullScreen" title="FullScreen">
							<img src="<?php echo Folder ?>images/icons/light/fullscreen.png" alt="" />
							<span>FullScreen</span>
						</a>
					</li>
					<li>
						<a href="<?php echo URL ?>Config" title="Configurações">
							<img src="<?php echo Folder ?>images/icons/topnav/settings.png" alt="" />
							<span>Configurações</span>
						</a>
					</li>
					<li><a href="<?php echo URL ?>Usuarios" title="Criar Novo Usuário">
						<img src="<?php echo Folder ?>images/icons/topnav/profile.png" alt="" />
						<span>Usuários</span>
					</a></li>
					<li>
						<a href="<?php echo URL ?>Login/Logout" title="Deslogar">
							<img src="<?php echo Folder ?>images/icons/topnav/logout.png" alt="" />
							<span>Deslogar</span>
						</a>
					</li>
                
					
					
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="resp">
		<div class="respHead">
			<a href="<?php echo URL ?>" title="Logo">
				<img src="<?php echo Folder ?>images/logo.png" alt="" style="margin-left: -30" /> 
			</a>
		</div>
		<div class="cLine"></div>
		<div class="smalldd">
			<span class="goTo"><img src="<?php echo Folder ?>images/icons/light/frames.png" alt="" />Menu</span>
			<ul class="smallDropdown">	
				<li class="dash">
					<a href="<?php echo URL ?>" title="Início">
						<span>Início</span>
					</a>
				</li>
				<li class="files">
					<a href="javascript:;" title="Produtos" class="exp">
						<span>Produtos</span>
					</a>
					<ul class="sub">
						<li>
							<a href="javascript:;" class="exp" title="Catálogo">Catálogo</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Catalogo/Adicionar" title="Adicionar Produto">Adicionar Produto</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Catalogo/Lista" title="Lista de Produtos">Lista de Produtos</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="<?php echo URL ?>Estoque" title="Estoque ">Estoque </a>
						</li>
					</ul>
				</li>
				<li class="rh">
					<a href="javascript:;" class="exp" title="RH">
						<span>RH</span>
					</a>
					<ul class="sub">
						<li>
							<a href="<?php echo URL ?>Folha" title="Folha de Pagamento ">Folha de Pagamento </a>
						</li>
						<li>
							<a href="javascript:;" title="" class="exp">Funcionários</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Funcionarios/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Funcionarios/Lista" title="Lista de Funcionarios">Lista de Funcionários</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" title="" class="exp">Funcões na Empresa</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Funcao/Adicionar" title="Adicionar Funcão">Adicionar Funcão</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Funcao/Lista" title="Lista de Funcões na Empresa">Lista de Funcões na Empresa</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Vales ">Vales </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Vales/Adicionar" title="Adicionar">Adicionar</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Vales" title="Lista de Vales">Lista de Vales</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="admin">
					<a href="javascript:;" class="exp" title="Administrativo">
						<span>Administrativo</span>
					</a>
					<ul class="sub">
						<li>
							<a href="javascript:;" class="exp" title="Clientes ">Clientes </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Clientes/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Clientes/Lista" title="Lista de Clientes">Lista de Clientes</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Pedidos de Compra">Pedidos de Compra</a>
							<ul class="sub">

								<li>
									<a href="<?php echo URL ?>Pedido/Adicionar" title="Adicionar Pedido de Compra">Adicionar Pedido de Compra</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Pedido/Lista" title="Lista de Pedidos de Compras">Lista de Pedidos de Compras</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Fornecedores">Fornecedores</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Fornecedores/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Fornecedores/Lista" title="Lista de Fornecedores">Lista de Fornecedores</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Fiado ">Fiado </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Fiado/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Fiado/Lista" title="Lista de Fiado">Lista de Fiado</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Vendas ">Vendas </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Vendas/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Vendas/Lista" title="Lista de Vendas">Lista de Vendas</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>

				<li class="logic">
					<a href="javascript:;" class="exp" title="Logística">
						<span>Logística</span>
					</a>
					<ul class="sub">
						<li>
							<a href="javascript:;" class="exp" title="Balanços">Balanços</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Balanco/Criar" title="Criar">Criar</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Balanco/Selecionar" title="Selecionar">Selecionar</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Blocos de Pedidos">Blocos de Pedidos</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Blocos/Adicionar" title="Adicionar Bloco">Adicionar Bloco</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Blocos/Lista" title="Lista de Blocos">Lista de Blocos</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Municipios ">Municipios </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Municipios/Adicionar" title="Criar Municipio">Criar Municipio</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Municipios/Listar" title="Listar Municipios<">Listar Municipios</a> 
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Rotas">Rotas</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Rotas/Adicionar" title="Adicionar Rota">Adicionar Rota</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Rotas/Lista" title="Lista de Rotas">Lista de Rotas</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Veiculos ">Veiculos </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Veiculos/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Veiculos/Lista" title="Lista de Veiculos">Lista de Veiculos</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="money">
					<a href="javascript:;" class="exp" title="Financeiro">
						<span>Financeiro</span>
					</a>
					<ul class="sub">
						<li>
							<a href="javascript:;" class="exp" title="Bancos ">Bancos </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Bancos/Adicionar" title="Adicionar">Adicionar</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Bancos/Lista" title="Lista de Bancos">Lista de Bancos</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Cartões ">Cartões </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Cartao/Adicionar" title="Adicionar">Adicionar</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Cartao/Lista" title="Lista de Cartões">Lista de Cartões</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Compras">Compras</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Compras/Adicionar" title="Adicionar">Adicionar</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Compras/Lista" title="Lista de Compras">Lista de Compras</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Despesas ">Despesas </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Despesas/Adicionar" title="Adicionar">Adicionar</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Despesas/Lista" title="Lista de Despesas">Lista de Despesas</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" title="" class="exp">Extratos Bancários</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Extratos/Adicionar" title="Adicionar">Adicionar Extrato</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Extratos/Lista" title="Lista de Extratos">Lista de Extratos</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="<?php echo URL ?>Fechamento" title="Fechamento de Mês ">Fechamento de Mês </a>
						</li>
						<li>
							<a href="<?php echo URL ?>Faturamento" title="Faturamento">Faturamento</a>
						</li>
					</ul>
				</li>

				<li class="up">
					<a href="javascript:;" class="exp" title="Contas a Pagar">
						<span>Contas a Pagar</span>
					</a>
					<ul class="sub">
						<li>
							<a href="javascript:;" class="exp" title="Cheques ">Cheques </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Cheques/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Cheques/Lista" title="Lista de Cheques">Lista de Cheques</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Vencimentos">Vencimentos</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Vencimentos/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Vencimentos/Lista" title="Lista de Vencimentos">Lista de Vencimentos</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Prestações">Prestações</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Prestacoes/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Prestacoes/Lista" title="Lista de Prestações">Lista de Prestações</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Financiamentos">Financiamentos</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Financiamentos/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Financiamentos/Lista" title="Lista de Financiamentos">Lista de Financiamentos</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="down">
					<a href="javascript:;" class="exp" title="Contas a Receber">
						<span>Contas a Receber</span>
					</a>
					<ul class="sub">
						<li>
							<a href="javascript:;" class="exp" title="Boletos ">Boletos </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Boletos/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>Boletos/Lista" title="Lista de Boletos">Lista de Boletos</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Cheques de Clientes ">Cheques de Clientes </a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>ChequesClientes/Adicionar" title="Adicionar">Adicionar</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>ChequesClientes/Lista" title="Lista de Cheques">Lista de Cheques</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="brasil">
					<a href="javascript:;" class="exp" title="Fiscal <"><span>Fiscal </span></a> 
					<ul class="sub">
						<li>
							<a href="javascript:;" class="exp" title="Emissão">Emissão</a>
							<ul class="sub">
								<li>
									<a href="javascript:;" class="exp" title="NFe">NFe</a>
									<ul class="sub">
										<li>
											<a href="<?php echo URL ?>NFe/Criar" title="Criar NFe">Criar NFe</a>
										</li>
										<li class="last">
											<a href="<?php echo URL ?>NFe/Selecionar" title="Selecionar NFe">Selecionar NFe</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;" class="exp" title="Notas Avulsas">Notas Avulsas</a>
									<ul class="sub">
										<li>
											<a href="<?php echo URL ?>Avulsas/Cadastrar" title="Cadastrar Nota Avulsa">Cadastrar Nota Avulsa</a>
										</li>
										<li class="last">
											<a href="<?php echo URL ?>Avulsas/Listar" title="Listar Notas Avulsa">Listar Notas Avulsa</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;" class="exp" title="Reduções Z">Reduções Z</a>
									<ul class="sub">
										<li>
											<a href="<?php echo URL ?>Reducoes/Cadastrar" title="Cadastrar Redução Z">Cadastrar Redução Z</a>
										</li>
										<li class="last">
											<a href="<?php echo URL ?>Reducoes/Listar" title="Listar Reduções Z">Listar Reduções Z</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Entrada">Entrada</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>NFeEntrada/Cadastrar" title="Cadastrar NFe de Entrada">Cadastrar NFe de Entrada</a>
								</li>

								<li class="last">
									<a href="<?php echo URL ?>NFeEntrada/Listar" title="Listar NFe's de Entrada">Listar NFe's de Entrada</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="exp" title="Destinatário">Destinatário</a>
							<ul class="sub">
								<li>
									<a href="<?php echo URL ?>Destinatarios/Cadastrar" title="Cadastrar Destinatário">Cadastrar Destinatário</a>
								</li>
								<li class="last">
									<a href="<?php echo URL ?>Destinatarios/Listar" title="Listar Destinatários">Listar Destinatários</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="charts">
					<a href="javascript:;" class="exp" title="Relatórios"><span>Relatórios</span></a>
					<ul class="sub">
						<li>
							<a href="<?php echo URL ?>Compras/Relatorio" title="Relatório de Compras">Relatório de Compras</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Despesas/Relatorio" title="Relatório de Despesas">Relatório de Despesas</a>
						</li>
						<li>
							<a href="<?php echo URL ?>RelatorioFiscal" title="Relatório Fiscal">Relatório Fiscal</a>
						</li>
					</ul>
				</li>
				<li class="pdf">
					<a href="javascript:;" class="exp" title="PDF"><span>PDF</span></a>
					<ul class="sub">
						<li>
							<a href="<?php echo URL ?>Pdf/Clientes" title="Catálogo de Clientes" target="_blank">Catálogo de Clientes</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/CatalogoCompleto" title="Catálogo de Produtos Detalhado" target="_blank">Catálogo de Produtos Detalhado</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/CatalogoSimples" title="Catálogo de Produtos Simples" target="_blank">Catálogo de Produtos Simples</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Folha" title="Folha de Pagamento" target="_blank">Folha de Pagamento</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Cheques" title="Relatório de Cheques a Pagar" target="_blank">Relatório de Cheques a Pagar</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Compras" title="Relatório de Compras" target="_blank">Relatório de Compras</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Geral" title="Relatório Contas a Pagar" target="_blank">Relatório de Contas a Pagar</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Despesas" title="Relatório de Despesas" target="_blank">Relatório de Despesas</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Estoque" title="Relatório do Estoque" target="_blank">Relatório do Estoque</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Faturamento" title="Relatório de Faturamento Últimos 6 Meses" target="_blank">Relatório de Faturamento Últimos 6 Meses</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/Fechamento" title="Relatório de Fechamento de Mês" target="_blank">Relatório de Fechamento de Mês</a>
						</li>
						<li>
							<a href="<?php echo URL ?>Pdf/ContasAPagar" title="Relatório de Vencimentos" target="_blank">Relatório de Vencimentos</a>
						</li>
						<li class="last">
							<a href="<?php echo URL ?>Pdf/Vendas" title="Relatório de Vendas" target="_blank">Relatório de Vendas</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="cLine"></div>
	</div>
    <?php
	/*
	<div class="titleArea">
		<div class="pageTitles"></div>
		<div class="clear"></div>
	</div>
	<div class="line"></div>
    
	<div class="statsRow">
		<div class="wrapper">
			<div class="controlB">
				<ul>
					<li>
						<a href="<?php echo URL ?>Balanco/Criar" title="Criar Balanço">
							<img src="<?php echo Folder ?>images/icons/control/new/pencil-2.png" alt="" />
							<span>Criar Balanço</span> 
						</a>
					</li>
					<li>
						<a href="<?php echo URL ?>Pdf/Geral" title="Relatório Geral Contas" target="_blank">
							<img src="<?php echo Folder ?>images/icons/control/new/pdf.png" alt="" height="32" />
							<span>Relatório Geral Contas</span> 
						</a>
					</li>
					<li>
						<a href="<?php echo URL ?>Compras/Adicionar" title="Nova Compra">
							<img src="<?php echo Folder ?>images/icons/control/32/cart.png" alt="" height="32" />
							<span>Nova Compra</span> 
						</a>
					</li>
					<li>
						<a href="<?php echo URL ?>Pedido/Adicionar" title="Novo Pedido de Compra">
							<img src="<?php echo Folder ?>images/icons/control/32/basket.png" alt="" height="32" />
							<span>Novo Pedido de Compra</span> 
						</a>
					</li>
					<li>
						<a href="<?php echo URL ?>Despesas/Adicionar" title="Cadastrar Despesa">
							<img src="<?php echo Folder ?>images/icons/control/32/invoice.png" alt="" />
							<span>Cadastrar Despesa</span> 
						</a>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	*/
	?>
	<script type="text/javascript">

	function UR_Start() 
	{
		UR_Nu = new Date;
		UR_Indhold = showFilled(UR_Nu.getHours()) + ":" + showFilled(UR_Nu.getMinutes()) + ":" + showFilled(UR_Nu.getSeconds());
		document.getElementById("ur").innerHTML = "<?=date('d/m/Y')?> - "+UR_Indhold + "hs";
		document.getElementById("urParent").attributes["title"].value="Data/Hora ( "+"<?=date('d/m/Y')?> - "+UR_Indhold + "hs )";
		setTimeout("UR_Start()",1000);
	}
	function showFilled(Value) 
	{
		return (Value > 9) ? "" + Value : "0" + Value;
	}

	UR_Start(); 
	</script>
	
	<div class="line"></div>
	<div class="wrapper">
		<?php if ($this->erro!="") {?>
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMAÇÃO: </strong>
				<span class="informacaoErro"></span>
				<?php echo $this->erro;?>
			</b></b></p>
		</div>
		<?php }?>