<!-- ESSE � O MENU LATERAL  Left side Destinatário content -->
<div id="leftSide">
	<div class="logo">
		<a href="<?php echo URL ?>Index">
			<img src="<?php echo Folder ?>images/logo.png" alt="" height="55" style="margin-left: -30" /> 
		</a>
	</div>
	<div class="sidebarSep mt0"></div>
	<div class="sideProfile">
		<a href="<?php echo URL ?>#" title=" " class="profileFace">
			<img src="<?php echo Folder ?>images/user.png" alt="" /> 
		</a> 
		<span>Olá <strong><?php echo $_COOKIE["usuario"]?>,</strong> </span>
		<div class="clear"></div>
		<div class="sidedd">
			<span class="goUser">Selecione a Ação</span>
			<ul class="sideDropdown">
				<li>
					<a class ="FullScreen" title="FullScreen">
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
				<li>
					<a href="<?php echo URL ?>Usuarios" title="">
						<img src="<?php echo Folder ?>images/icons/topnav/profile.png" alt="" />Usuários
					</a>
				</li>
				<li>
					<a href="<?php echo URL ?>Login/Logout" title="">
						<img src="<?php echo Folder ?>images/icons/topnav/logout.png" alt="" />Deslogar
					</a>
				</li>
                
				
				<li>
					<a href="<?php echo URL ?>Log" title="">
						<img src="<?php echo Folder ?>images/icons/topnav/tasks.png" alt="" />Logs
					</a>
				</li>
				
				
			</ul>
		</div>
	</div>
	<div class="sidebarSep"></div>
	<ul id="menu" class="nav">
		<li class="dash">
			<a href="<?php echo URL ?>" title="">
				<span>In&iacute;cio</span>
			</a>
		</li>
		<li class="files">
			<a href="javascript:;" title="" class="exp">
				<span>Produtos</span>
			</a>
			<ul class="sub">
				<li>
					<a href="javascript:;" title="" class="exp">Catálogo</a>
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
			<a href="javascript:;" title="" class="exp">
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
					<a href="javascript:;" title="" class="exp">Vales </a>
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
			<a href="javascript:;" title="" class="exp">
				<span>Administrativo</span>
			</a>
			<ul class="sub">
				<li>
					<a href="javascript:;" title="" class="exp">Clientes </a>
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
					<a href="javascript:;" title="" class="exp">Pedidos de Compra</a>
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
					<a href="javascript:;" title="" class="exp">Fornecedores</a>
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
					<a href="javascript:;" title="" class="exp">Fiado </a>
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
					<a href="javascript:;" title="" class="exp">Vendas </a>
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
			<a href="javascript:;" title="" class="exp">
				<span>Log&iacute;stica</span>
			</a>
			<ul class="sub">
            		
				<li>
					<a href="javascript:;" title="" class="exp">Balanços</a>
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
					<a href="javascript:;" title="" class="exp">Blocos de Pedidos</a>
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
					<a href="javascript:;" title="" class="exp">Municipios </a>
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
					<a href="javascript:;" title="" class="exp">Rotas</a>
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
					<a href="javascript:;" title="" class="exp">Veiculos </a>
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
			<a href="javascript:;" title="" class="exp">
				<span>Financeiro</span>
			</a>
			<ul class="sub">
				<li>
					<a href="javascript:;" title="" class="exp">Bancos </a>
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
					<a href="javascript:;" title="" class="exp">Cartões </a>
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
					<a href="javascript:;" title="" class="exp">Compras</a>
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
					<a href="javascript:;" title="" class="exp">Despesas </a>
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
			<a href="javascript:;" title="" class="exp">
				<span>Contas a Pagar</span>
			</a>
			<ul class="sub">
				<li>
					<a href="javascript:;" title="" class="exp">Cheques </a>
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
					<a href="javascript:;" title="" class="exp">Vencimentos</a>
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
					<a href="javascript:;" title="" class="exp">Prestações</a>
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
					<a href="javascript:;" title="" class="exp">Financiamentos</a>
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
			<a href="javascript:;" title="" class="exp">
				<span>Contas a Receber</span>
			</a>
			<ul class="sub">
				<li>
					<a href="javascript:;" title="" class="exp">Boletos </a>
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
					<a href="javascript:;" title="" class="exp">Cheques de Clientes </a>
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
			<a href="javascript:;" title="" class="exp"><span>Fiscal </span></a> 
			<ul class="sub">
				<li>
					<a href="javascript:;" title="" class="exp">Emissão</a>
					<ul class="sub">
						<li>
							<a href="javascript:;" title="" class="exp">NFe</a>
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
							<a href="javascript:;" title="" class="exp">Notas Avulsas</a>
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
							<a href="javascript:;" title="" class="exp">Reduções Z</a>
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
					<a href="javascript:;" title="" class="exp">Entrada</a>
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
					<a href="javascript:;" title="" class="exp">Cliente</a>
					<ul class="sub">
						<li>
							<a href="<?php echo URL ?>Destinatarios/Cadastrar" title="Cadastrar Destinatário">Cadastrar Clientes</a>
						</li>
						<li class="last">
							<a href="<?php echo URL ?>Destinatarios/Listar" title="Listar Destinatários">Listar Clientes</a>
						</li>
					</ul>
				</li>
                <li>
					<a href="javascript:;" title="" class="exp">Fornecedores</a>
					<ul class="sub">
						<li>
							<a href="<?php echo URL ?>Fornecedores/Adicionar" title="Adicionar">Adicionar</a>
						</li>

						<li class="last">
							<a href="<?php echo URL ?>Fornecedores/Lista" title="Lista de Fornecedores">Lista de Fornecedores</a>
						</li>
					</ul>
				</li>
			</ul>
		</li>
		<li class="charts">
			<a href="javascript:;" title="" class="exp"><span>Relatórios</span></a>
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
			<a href="javascript:;" title="" class="exp"><span>PDF</span></a>
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
	<div class="sidebarSep"></div>
</div>