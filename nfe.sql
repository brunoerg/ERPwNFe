-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 27-Jul-2015 às 05:27
-- Versão do servidor: 5.6.20-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nfe`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `balancos`
--

CREATE TABLE IF NOT EXISTS `balancos` (
`id` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `data` varchar(10) NOT NULL,
  `retorno` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancos`
--

CREATE TABLE IF NOT EXISTS `bancos` (
`id` int(11) NOT NULL,
  `numero` varchar(11) NOT NULL,
  `nome` varchar(222) NOT NULL,
  `abv` varchar(222) NOT NULL,
  `agencia` varchar(10) NOT NULL DEFAULT '0',
  `conta` varchar(15) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bandeiras`
--

CREATE TABLE IF NOT EXISTS `bandeiras` (
`id` int(11) NOT NULL,
  `nome` varchar(222) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `bandeiras`
--

INSERT INTO `bandeiras` (`id`, `nome`) VALUES
(1, 'Visa'),
(2, 'Mastercard'),
(3, 'Cielo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `blocos`
--

CREATE TABLE IF NOT EXISTS `blocos` (
`id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `boletos`
--

CREATE TABLE IF NOT EXISTS `boletos` (
`id` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `valor` varchar(22) NOT NULL,
  `emissao` varchar(10) NOT NULL,
  `vencimento` varchar(10) NOT NULL,
  `nossoNumero` varchar(21) NOT NULL,
  `numeroTitulo` varchar(15) NOT NULL,
  `pago` mediumint(1) NOT NULL DEFAULT '0',
  `NFe` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartao`
--

CREATE TABLE IF NOT EXISTS `cartao` (
`id` int(11) NOT NULL,
  `nome` varchar(222) NOT NULL,
  `bandeira` int(2) NOT NULL,
  `vencimento` int(2) NOT NULL,
  `fechamento` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cfop`
--

CREATE TABLE IF NOT EXISTS `cfop` (
  `codigo` varchar(4) NOT NULL,
  `descricao` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cfop`
--

INSERT INTO `cfop` (`codigo`, `descricao`) VALUES
('1101', 'Compra para industrialização'),
('1102', 'Compra para comercialização'),
('1111', 'Compra para industrialização de mercadoria recebida anteriormente em consignação industrial'),
('1113', 'Compra para comercialização, de mercadoria recebida anteriormente em consignação mercantil'),
('1116', 'Compra para industrialização originada de encomenda para recebimento futuro'),
('1117', 'Compra para comercialização originada de encomenda para recebimento futuro'),
('1118', 'Compra de mercadoria para comercialização pelo adquirente originário, entregue pelo vendedor remetente ao destinatário, em venda à ordem'),
('1120', 'Compra para industrialização, em venda à ordem, já recebida do vendedor remetente'),
('1121', 'Compra para comercialização, em venda à ordem, já recebida do vendedor remetente'),
('1122', 'Compra para industrialização em que a mercadoria foi remetida pelo fornecedor ao industrializador sem transitar pelo estabelecimento adquirente'),
('1124', 'Industrialização efetuada por outra empresa'),
('1125', 'Industrialização efetuada por outra empresa quando a mercadoria remetida para utilização no processo de industrialização não transitou pelo estabelecimento adquirente da mercadoria'),
('1126', 'Compra para utilização na prestação de serviço'),
('1151', 'Transferência para industrialização'),
('1152', 'Transferência para comercialização'),
('1153', 'Transferência de energia elétrica para distribuição'),
('1154', 'Transferência para utilização na prestação de serviço'),
('1201', 'Devolução de venda de produção do estabelecimento'),
('1202', 'Devolução de venda de mercadoria adquirida ou recebida de terceiros'),
('1203', 'Devolução de venda de produção do estabelecimento, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('1204', 'Devolução de venda de mercadoria adquirida ou recebida de terceiros, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('1205', 'Anulação de valor relativo à prestação de serviço de comunicação'),
('1206', 'Anulação de valor relativo à prestação de serviço de transporte'),
('1207', 'Anulação de valor relativo à venda de energia elétrica'),
('1208', 'Devolução de produção do estabelecimento, remetida em transferência'),
('1209', 'Devolução de mercadoria adquirida ou recebida de terceiros, remetida em transferência'),
('1251', 'Compra de energia elétrica para distribuição ou comercialização'),
('1252', 'Compra de energia elétrica por estabelecimento industrial'),
('1253', 'Compra de energia elétrica por estabelecimento comercial'),
('1254', 'Compra de energia elétrica por estabelecimento prestador de serviço de transporte'),
('1255', 'Compra de energia elétrica por estabelecimento prestador de serviço de comunicação'),
('1256', 'Compra de energia elétrica por estabelecimento de produtor rural'),
('1257', 'Compra de energia elétrica para consumo por demanda contratada'),
('1301', 'Aquisição de serviço de comunicação para execução de serviço da mesma natureza'),
('1302', 'Aquisição de serviço de comunicação por estabelecimento industrial'),
('1303', 'Aquisição de serviço de comunicação por estabelecimento comercial'),
('1304', 'Aquisição de serviço de comunicação por estabelecimento de prestador de serviço de transporte'),
('1305', 'Aquisição de serviço de comunicação por estabelecimento de geradora ou de distribuidora de energia elétrica'),
('1306', 'Aquisição de serviço de comunicação por estabelecimento de produtor rural'),
('1351', 'Aquisição de serviço de transporte para execução de serviço da mesma natureza'),
('1352', 'Aquisição de serviço de transporte por estabelecimento industrial'),
('1353', 'Aquisição de serviço de transporte por estabelecimento comercial'),
('1354', 'Aquisição de serviço de transporte por estabelecimento de prestador de serviço de comunicação'),
('1355', 'Aquisição de serviço de transporte por estabelecimento de geradora ou de distribuidora de energia elétrica'),
('1356', 'Aquisição de serviço de transporte por estabelecimento de produtor rural'),
('1401', 'Compra para industrialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('1403', 'Compra para comercialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('1406', 'Compra de bem para o ativo imobilizado cuja mercadoria está sujeita ao regime de substituição tributária'),
('1407', 'Compra de mercadoria para uso ou consumo cuja mercadoria está sujeita ao regime de substituição tributária'),
('1408', 'Transferência para industrialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('1409', 'Transferência para comercialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('1410', 'Devolução de venda de produção do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('1411', 'Devolução de venda de mercadoria adquirida ou recebida de terceiros em operação com mercadoria sujeita ao regime de substituição tributária'),
('1414', 'Retorno de produção do estabelecimento, remetida para venda fora do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('1415', 'Retorno de mercadoria adquirida ou recebida de terceiros, remetida para venda fora do estabelecimento em operação com mercadoria sujeita ao regime de substituição tributária'),
('1451', 'Retorno de animal do estabelecimento produtor'),
('1452', 'Retorno de insumo não utilizado na produção'),
('1501', 'Entrada de mercadoria recebida com fim específico de exportação'),
('1503', 'Entrada decorrente de devolução de produto remetido com fim específico de exportação, de produção do estabelecimento'),
('1504', 'Entrada decorrente de devolução de mercadoria remetida com fim específico de exportação, adquirida ou recebida de terceiros'),
('1551', 'Compra de bem para o ativo imobilizado'),
('1552', 'Transferência de bem do ativo imobilizado'),
('1553', 'Devolução de venda de bem do ativo imobilizado'),
('1554', 'Retorno de bem do ativo imobilizado remetido para uso fora do estabelecimento'),
('1555', 'Entrada de bem do ativo imobilizado de terceiro, remetido para uso no estabelecimento'),
('1556', 'Compra de material para uso ou consumo'),
('1557', 'Transferência de material para uso ou consumo'),
('1601', 'Recebimento, por transferência, de crédito de ICMS'),
('1602', 'Recebimento, por transferência, de saldo credor de ICMS de outro estabelecimento da mesma empresa, para compensação de saldo devedor de ICMS'),
('1603', 'Ressarcimento de ICMS retido por substituição tributária'),
('1604', 'Lançamento do crédito relativo à compra de bem para o ativo imobilizado'),
('1605', 'Recebimento, por transferência, de saldo devedor de ICMS de outro estabelecimento da mesma empresa'),
('1650', 'ENTRADAS DE COMBUSTÍVEIS, DERIVADOS OU NÃO DE PETRÓLEO E LUBRIFICANTES'),
('1651', 'Compra de combustível ou lubrificante para industrialização subseqüente'),
('1652', 'Compra de combustível ou lubrificante para comercialização'),
('1653', 'Compra de combustível ou lubrificante por consumidor ou usuário final'),
('1658', 'Transferência de combustível e lubrificante para industrialização'),
('1659', 'Transferência de combustível e lubrificante para comercialização'),
('1660', 'Devolução de venda de combustível ou lubrificante destinado à industrialização'),
('1661', 'Devolução de venda de combustível ou lubrificante destinado à comercialização'),
('1662', 'Devolução de venda de combustível ou lubrificante destinado a consumidor ou usuário final'),
('1663', 'Entrada de combustível ou lubrificante para armazenagem'),
('1664', 'Retorno de combustível ou lubrificante remetido para armazenagem'),
('1901', 'Entrada para industrialização por encomenda'),
('1902', 'Retorno de mercadoria remetida para industrialização por encomenda'),
('1903', 'Entrada de mercadoria remetida para industrialização e não aplicada no referido processo'),
('1904', 'Retorno de remessa para venda fora do estabelecimento'),
('1905', 'Entrada de mercadoria recebida para depósito em depósito fechado ou armazém geral'),
('1906', 'Retorno de mercadoria remetida para depósito fechado ou armazém geral'),
('1907', 'Retorno simbólico de mercadoria remetida para depósito fechado ou armazém geral'),
('1908', 'Entrada de bem por conta de contrato de comodato'),
('1909', 'Retorno de bem remetido por conta de contrato de comodato'),
('1910', 'Entrada de bonificação, doação ou brinde'),
('1911', 'Entrada de amostra grátis'),
('1912', 'Entrada de mercadoria ou bem recebido para demonstração'),
('1913', 'Retorno de mercadoria ou bem remetido para demonstração'),
('1914', 'Retorno de mercadoria ou bem remetido para exposição ou feira'),
('1915', 'Entrada de mercadoria ou bem recebido para conserto ou reparo'),
('1916', 'Retorno de mercadoria ou bem remetido para conserto ou reparo'),
('1917', 'Entrada de mercadoria recebida em consignação mercantil ou industrial'),
('1918', 'Devolução de mercadoria remetida em consignação mercantil ou industrial'),
('1919', 'Devolução simbólica de mercadoria vendida ou utilizada em processo industrial, remetida anteriormente em consignação mercantil ou industrial'),
('1920', 'Entrada de vasilhame ou sacaria'),
('1921', 'Retorno de vasilhame ou sacaria'),
('1922', 'Lançamento efetuado a título de simples faturamento decorrente de compra para recebimento futuro'),
('1923', 'Entrada de mercadoria recebida do vendedor remetente, em venda à ordem'),
('1924', 'Entrada para industrialização por conta e ordem do adquirente da mercadoria, quando esta não transitar pelo estabelecimento do adquirente'),
('1925', 'Retorno de mercadoria remetida para industrialização por conta e ordem do adquirente da mercadoria, quando esta não transitar pelo estabelecimento do adquirente'),
('1926', 'Lançamento efetuado a título de reclassificação de mercadoria decorrente de formação de kit ou de sua desagregação'),
('1931', 'Lançamento efetuado pelo tomador do serviço de transporte quando a responsabilidade de retenção do imposto for atribuída ao remetente ou alienante da mercadoria, pelo serviço de transporte realizado por transportador autônomo ou por transportador não inscrito na Unidade da Federação onde iniciado o serviço'),
('1932', 'Aquisição de serviço de transporte iniciado em Unidade da Federação diversa daquela onde inscrito o prestador'),
('1933', 'Aquisição de serviço tributado pelo ISSQN'),
('1949', 'Outra entrada de mercadoria ou prestação de serviço não especificada'),
('2101', 'Compra para industrialização'),
('2102', 'Compra para comercialização'),
('2111', 'Compra para industrialização de mercadoria recebida anteriormente em consignação industrial'),
('2113', 'Compra para comercialização, de mercadoria recebida anteriormente em consignação mercantil'),
('2116', 'Compra para industrialização originada de encomenda para recebimento futuro'),
('2117', 'Compra para comercialização originada de encomenda para recebimento futuro'),
('2118', 'Compra de mercadoria para comercialização pelo adquirente originário, entregue pelo vendedor remetente ao destinatário, em venda à ordem'),
('2120', 'Compra para industrialização, em venda à ordem, já recebida do vendedor remetente'),
('2121', 'Compra para comercialização, em venda à ordem, já recebida do vendedor remetente'),
('2122', 'Compra para industrialização em que a mercadoria foi remetida pelo fornecedor ao industrializador sem transitar pelo estabelecimento adquirente'),
('2124', 'Industrialização efetuada por outra empresa'),
('2125', 'Industrialização efetuada por outra empresa quando a mercadoria remetida para utilização no processo de industrialização não transitou pelo estabelecimento adquirente da mercadoria'),
('2126', 'Compra para utilização na prestação de serviço'),
('2151', 'Transferência para industrialização'),
('2152', 'Transferência para comercialização'),
('2153', 'Transferência de energia elétrica para distribuição'),
('2154', 'Transferência para utilização na prestação de serviço'),
('2201', 'Devolução de venda de produção do estabelecimento'),
('2202', 'Devolução de venda de mercadoria adquirida ou recebida de terceiros'),
('2203', 'Devolução de venda de produção do estabelecimento, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('2204', 'Devolução de venda de mercadoria adquirida ou recebida de terceiros, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('2205', 'Anulação de valor relativo à prestação de serviço de comunicação'),
('2206', 'Anulação de valor relativo à prestação de serviço de transporte'),
('2207', 'Anulação de valor relativo à venda de energia elétrica'),
('2208', 'Devolução de produção do estabelecimento, remetida em transferência'),
('2209', 'Devolução de mercadoria adquirida ou recebida de terceiros, remetida em transferência'),
('2251', 'Compra de energia elétrica para distribuição ou comercialização'),
('2252', 'Compra de energia elétrica por estabelecimento industrial'),
('2253', 'Compra de energia elétrica por estabelecimento comercial'),
('2254', 'Compra de energia elétrica por estabelecimento prestador de serviço de transporte'),
('2255', 'Compra de energia elétrica por estabelecimento prestador de serviço de comunicação'),
('2256', 'Compra de energia elétrica por estabelecimento de produtor rural'),
('2257', 'Compra de energia elétrica para consumo por demanda contratada'),
('2301', 'Aquisição de serviço de comunicação para execução de serviço da mesma natureza'),
('2302', 'Aquisição de serviço de comunicação por estabelecimento industrial'),
('2303', 'Aquisição de serviço de comunicação por estabelecimento comercial'),
('2304', 'Aquisição de serviço de comunicação por estabelecimento de prestador de serviço de transporte'),
('2305', 'Aquisição de serviço de comunicação por estabelecimento de geradora ou de distribuidora de energia elétrica'),
('2306', 'Aquisição de serviço de comunicação por estabelecimento de produtor rural'),
('2351', 'Aquisição de serviço de transporte para execução de serviço da mesma natureza'),
('2352', 'Aquisição de serviço de transporte por estabelecimento industrial'),
('2353', 'Aquisição de serviço de transporte por estabelecimento comercial'),
('2354', 'Aquisição de serviço de transporte por estabelecimento de prestador de serviço de comunicação'),
('2355', 'Aquisição de serviço de transporte por estabelecimento de geradora ou de distribuidora de energia elétrica'),
('2356', 'Aquisição de serviço de transporte por estabelecimento de produtor rural'),
('2401', 'Compra para industrialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('2403', 'Compra para comercialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('2406', 'Compra de bem para o ativo imobilizado cuja mercadoria está sujeita ao regime de substituição tributária'),
('2407', 'Compra de mercadoria para uso ou consumo cuja mercadoria está sujeita ao regime de substituição tributária'),
('2408', 'Transferência para industrialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('2409', 'Transferência para comercialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('2410', 'Devolução de venda de produção do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('2411', 'Devolução de venda de mercadoria adquirida ou recebida de terceiros em operação com mercadoria sujeita ao regime de substituição tributária'),
('2414', 'Retorno de produção do estabelecimento, remetida para venda fora do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('2415', 'Retorno de mercadoria adquirida ou recebida de terceiros, remetida para venda fora do estabelecimento em operação com mercadoria sujeita ao regime de substituição tributária'),
('2501', 'Entrada de mercadoria recebida com fim específico de exportação'),
('2503', 'Entrada decorrente de devolução de produto remetido com fim específico de exportação, de produção do estabelecimento'),
('2504', 'Entrada decorrente de devolução de mercadoria remetida com fim específico de exportação, adquirida ou recebida de terceiros'),
('2551', 'Compra de bem para o ativo imobilizado'),
('2552', 'Transferência de bem do ativo imobilizado'),
('2553', 'Devolução de venda de bem do ativo imobilizado'),
('2554', 'Retorno de bem do ativo imobilizado remetido para uso fora do estabelecimento'),
('2555', 'Entrada de bem do ativo imobilizado de terceiro, remetido para uso no estabelecimento'),
('2556', 'Compra de material para uso ou consumo'),
('2557', 'Transferência de material para uso ou consumo'),
('2603', 'Ressarcimento de ICMS retido por substituição tributária'),
('2651', 'ENTRADAS DE COMBUSTÍVEIS, DERIVADOS OU NÃO DE PETRÓLEO E LUBRIFICANTES'),
('2652', 'Compra de combustível ou lubrificante para comercialização'),
('2653', 'Compra de combustível ou lubrificante por consumidor ou usuário final'),
('2658', 'Transferência de combustível e lubrificante para industrialização'),
('2659', 'Transferência de combustível e lubrificante para comercialização'),
('2660', 'Devolução de venda de combustível ou lubrificante destinado à industrialização'),
('2661', 'Devolução de venda de combustível ou lubrificante destinado à comercialização'),
('2662', 'Devolução de venda de combustível ou lubrificante destinado a consumidor ou usuário final'),
('2663', 'Entrada de combustível ou lubrificante para armazenagem'),
('2664', 'Retorno de combustível ou lubrificante remetido para armazenagem'),
('2901', 'Entrada para industrialização por encomenda'),
('2902', 'Retorno de mercadoria remetida para industrialização por encomenda'),
('2903', 'Entrada de mercadoria remetida para industrialização e não aplicada no referido processo'),
('2904', 'Retorno de remessa para venda fora do estabelecimento'),
('2905', 'Entrada de mercadoria recebida para depósito em depósito fechado ou armazém geral'),
('2906', 'Retorno de mercadoria remetida para depósito fechado ou armazém geral'),
('2907', 'Retorno simbólico de mercadoria remetida para depósito fechado ou armazém geral'),
('2908', 'Entrada de bem por conta de contrato de comodato'),
('2909', 'Retorno de bem remetido por conta de contrato de comodato'),
('2910', 'Entrada de bonificação, doação ou brinde'),
('2911', 'Entrada de amostra grátis'),
('2912', 'Entrada de mercadoria ou bem recebido para demonstração'),
('2913', 'Retorno de mercadoria ou bem remetido para demonstração'),
('2914', 'Retorno de mercadoria ou bem remetido para exposição ou feira'),
('2915', 'Entrada de mercadoria ou bem recebido para conserto ou reparo'),
('2916', 'Retorno de mercadoria ou bem remetido para conserto ou reparo'),
('2917', 'Entrada de mercadoria recebida em consignação mercantil ou industrial'),
('2918', 'Devolução de mercadoria remetida em consignação mercantil ou industrial'),
('2919', 'Devolução simbólica de mercadoria vendida ou utilizada em processo industrial, remetida anteriormente em consignação mercantil ou industrial'),
('2920', 'Entrada de vasilhame ou sacaria'),
('2921', 'Retorno de vasilhame ou sacaria'),
('2922', 'Lançamento efetuado a título de simples faturamento decorrente de compra para recebimento futuro'),
('2923', 'Entrada de mercadoria recebida do vendedor remetente, em venda à ordem'),
('2924', 'Entrada para industrialização por conta e ordem do adquirente da mercadoria, quando esta não transitar pelo estabelecimento do adquirente'),
('2925', 'Retorno de mercadoria remetida para industrialização por conta e ordem do adquirente da mercadoria, quando esta não transitar pelo estabelecimento do adquirente'),
('2931', 'Lançamento efetuado pelo tomador do serviço de transporte quando a responsabilidade de retenção do imposto for atribuída ao remetente ou alienante da mercadoria, pelo serviço de transporte realizado por transportador autônomo ou por transportador não inscrito na Unidade da Federação onde iniciado o serviço'),
('2932', 'Aquisição de serviço de transporte iniciado em Unidade da Federação diversa daquela onde inscrito o prestador'),
('2933', 'Aquisição de serviço tributado pelo ISSQN'),
('2949', 'Outra entrada de mercadoria ou prestação de serviço não especificado'),
('3101', 'Compra para industrialização'),
('3102', 'Compra para comercialização'),
('3126', 'Compra para utilização na prestação de serviço'),
('3127', 'Compra para industrialização sob o regime de “drawback”'),
('3201', 'Devolução de venda de produção do estabelecimento'),
('3202', 'Devolução de venda de mercadoria adquirida ou recebida de terceiros'),
('3205', 'Anulação de valor relativo à prestação de serviço de comunicação'),
('3206', 'Anulação de valor relativo à prestação de serviço de transporte'),
('3207', 'Anulação de valor relativo à venda de energia elétrica'),
('3211', 'Devolução de venda de produção do estabelecimento sob o regime de “drawback”'),
('3251', 'Compra de energia elétrica para distribuição ou comercialização'),
('3301', 'Aquisição de serviço de comunicação para execução de serviço da mesma natureza'),
('3351', 'Aquisição de serviço de transporte para execução de serviço da mesma natureza'),
('3352', 'Aquisição de serviço de transporte por estabelecimento industrial'),
('3353', 'Aquisição de serviço de transporte por estabelecimento comercial'),
('3354', 'Aquisição de serviço de transporte por estabelecimento de prestador de serviço de comunicação'),
('3355', 'Aquisição de serviço de transporte por estabelecimento de geradora ou de distribuidora de energia elétrica'),
('3356', 'Aquisição de serviço de transporte por estabelecimento de produtor rural'),
('3503', 'Devolução de mercadoria exportada que tenha sido recebida com fim específico de exportação'),
('3551', 'Compra de bem para o ativo imobilizado'),
('3553', 'Devolução de venda de bem do ativo imobilizado'),
('3556', 'Compra de material para uso ou consumo'),
('3650', 'ENTRADAS DE COMBUSTÍVEIS, DERIVADOS OU NÃO DE PETRÓLEO E LUBRIFICANTES'),
('3651', 'Compra de combustível ou lubrificante para industrialização subseqüente'),
('3652', 'Compra de combustível ou lubrificante para comercialização'),
('3653', 'Compra de combustível ou lubrificante por consumidor ou usuário final'),
('3930', 'Lançamento efetuado a título de entrada de bem sob amparo de regime especial aduaneiro de admissão temporária'),
('3949', 'Outra entrada de mercadoria ou prestação de serviço não especificado'),
('5101', 'Venda de produção do estabelecimento'),
('5102', 'Venda de mercadoria adquirida ou recebida de terceiros'),
('5103', 'Venda de produção do estabelecimento, efetuada fora do estabelecimento'),
('5104', 'Venda de mercadoria adquirida ou recebida de terceiros, efetuada fora do estabelecimento'),
('5105', 'Venda de produção do estabelecimento que não deva por ele transitar'),
('5106', 'Venda de mercadoria adquirida ou recebida de terceiros, que não deva por ele transitar'),
('5109', 'Venda de produção do estabelecimento, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('5110', 'Venda de mercadoria adquirida ou recebida de terceiros, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('5111', 'Venda de produção do estabelecimento remetida anteriormente em consignação industrial'),
('5112', 'Venda de mercadoria adquirida ou recebida de terceiros remetida anteriormente em consignação industrial'),
('5113', 'Venda de produção do estabelecimento remetida anteriormente em consignação mercantil'),
('5114', 'Venda de mercadoria adquirida ou recebida de terceiros remetida anteriormente em consignação mercantil'),
('5115', 'Venda de mercadoria adquirida ou recebida de terceiros, recebida anteriormente em consignação mercantil'),
('5116', 'Venda de produção do estabelecimento originada de encomenda para entrega futura'),
('5117', 'Venda de mercadoria adquirida ou recebida de terceiros, originada de encomenda para entrega futura'),
('5118', 'Venda de produção do estabelecimento entregue ao destinatário por conta e ordem do adquirente originário, em venda à ordem'),
('5119', 'Venda de mercadoria adquirida ou recebida de terceiros entregue ao destinatário por conta e ordem do adquirente originário, em venda à ordem'),
('5120', 'Venda de mercadoria adquirida ou recebida de terceiros entregue ao destinatário pelo vendedor remetente, em venda à ordem'),
('5122', 'Venda de produção do estabelecimento remetida para industrialização, por conta e ordem do adquirente, sem transitar pelo estabelecimento do adquirente'),
('5123', 'Venda de mercadoria adquirida ou recebida de terceiros remetida para industrialização, por conta e ordem do adquirente, sem transitar pelo estabelecimento do adquirente'),
('5124', 'Industrialização efetuada para outra empresa'),
('5125', 'Industrialização efetuada para outra empresa quando a mercadoria recebida para utilização no processo de industrialização não transitar pelo estabelecimento adquirente da mercadoria'),
('5151', 'Transferência de produção do estabelecimento'),
('5152', 'Transferência de mercadoria adquirida ou recebida de terceiros'),
('5153', 'Transferência de energia elétrica'),
('5155', 'Transferência de produção do estabelecimento, que não deva por ele transitar'),
('5156', 'Transferência de mercadoria adquirida ou recebida de terceiros, que não deva por ele transitar'),
('5201', 'Devolução de compra para industrialização'),
('5202', 'Devolução de compra para comercialização'),
('5205', 'Anulação de valor relativo a aquisição de serviço de comunicação'),
('5206', 'Anulação de valor relativo a aquisição de serviço de transporte'),
('5207', 'Anulação de valor relativo à compra de energia elétrica'),
('5208', 'Devolução de mercadoria recebida em transferência para industrialização'),
('5209', 'Devolução de mercadoria recebida em transferência para comercialização'),
('5210', 'Devolução de compra para utilização na prestação de serviço'),
('5251', 'Venda de energia elétrica para distribuição ou comercialização'),
('5252', 'Venda de energia elétrica para estabelecimento industrial'),
('5253', 'Venda de energia elétrica para estabelecimento comercial'),
('5254', 'Venda de energia elétrica para estabelecimento prestador de serviço de transporte'),
('5255', 'Venda de energia elétrica para estabelecimento prestador de serviço de comunicação'),
('5256', 'Venda de energia elétrica para estabelecimento de produtor rural'),
('5257', 'Venda de energia elétrica para consumo por demanda contratada'),
('5258', 'Venda de energia elétrica a não contribuinte'),
('5301', 'Prestação de serviço de comunicação para execução de serviço da mesma natureza'),
('5302', 'Prestação de serviço de comunicação a estabelecimento industrial'),
('5303', 'Prestação de serviço de comunicação a estabelecimento comercial'),
('5304', 'Prestação de serviço de comunicação a estabelecimento de prestador de serviço de transporte'),
('5305', 'Prestação de serviço de comunicação a estabelecimento de geradora ou de distribuidora de energia elétrica'),
('5306', 'Prestação de serviço de comunicação a estabelecimento de produtor rural'),
('5307', 'Prestação de serviço de comunicação a não contribuinte'),
('5351', 'Prestação de serviço de transporte para execução de serviço da mesma natureza'),
('5352', 'Prestação de serviço de transporte a estabelecimento industrial'),
('5353', 'Prestação de serviço de transporte a estabelecimento comercial'),
('5354', 'Prestação de serviço de transporte a estabelecimento de prestador de serviço de comunicação'),
('5355', 'Prestação de serviço de transporte a estabelecimento de geradora ou de distribuidora de energia elétrica'),
('5356', 'Prestação de serviço de transporte a estabelecimento de produtor rural'),
('5357', 'Prestação de serviço de transporte a não contribuinte'),
('5359', 'Prestação de serviço de transporte a contribuinte ou a não contribuinte quando a mercadoria transportada está dispensada de emissão de nota fiscal'),
('5401', 'Venda de produção do estabelecimento em operação com produto sujeito ao regime de substituição tributária, na condição de contribuinte substituto'),
('5402', 'Venda de produção do estabelecimento de produto sujeito ao regime de substituição tributária, em operação entre contribuintes substitutos do mesmo produto'),
('5403', 'Venda de mercadoria adquirida ou recebida de terceiros em operação com mercadoria sujeita ao regime de substituição tributária, na condição de contribuinte substituto'),
('5405', 'Venda de mercadoria adquirida ou recebida de terceiros em operação com mercadoria sujeita ao regime de substituição tributária, na condição de contribuinte substituído'),
('5408', 'Transferência de produção do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('5409', 'Transferência de mercadoria adquirida ou recebida de terceiros em operação com mercadoria sujeita ao regime de substituição tributária'),
('5410', 'Devolução de compra para industrialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('5411', 'Devolução de compra para comercialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('5412', 'Devolução de bem do ativo imobilizado, em operação com mercadoria sujeita ao regime de substituição tributária'),
('5413', 'Devolução de mercadoria destinada ao uso ou consumo, em operação com mercadoria sujeita ao regime de substituição tributária'),
('5414', 'Remessa de produção do estabelecimento para venda fora do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('5415', 'Remessa de mercadoria adquirida ou recebida de terceiros para venda fora do estabelecimento, em operação com mercadoria sujeita ao regime de substituição tributária'),
('5451', 'Remessa de animal e de insumo para estabelecimento produtor'),
('5501', 'Remessa de produção do estabelecimento, com fim específico de exportação'),
('5502', 'Remessa de mercadoria adquirida ou recebida de terceiros, com fim específico de exportação'),
('5503', 'Devolução de mercadoria recebida com fim específico de exportação'),
('5551', 'Venda de bem do ativo imobilizado'),
('5552', 'Transferência de bem do ativo imobilizado'),
('5553', 'Devolução de compra de bem para o ativo imobilizado'),
('5554', 'Remessa de bem do ativo imobilizado para uso fora do estabelecimento'),
('5555', 'Devolução de bem do ativo imobilizado de terceiro, recebido para uso no estabelecimento'),
('5556', 'Devolução de compra de material de uso ou consumo'),
('5557', 'Transferência de material de uso ou consumo'),
('5601', 'Transferência de crédito de ICMS acumulado'),
('5602', 'Transferência de saldo credor de ICMS para outro estabelecimento da mesma empresa, destinado à compensação de saldo devedor de ICMS'),
('5603', 'Ressarcimento de ICMS retido por substituição tributária'),
('5605', 'Transferência de saldo devedor de ICMS de outro estabelecimento da mesma empresa'),
('5650', 'SAÍDAS DE COMBUSTÍVEIS, DERIVADOS OU NÃO DE PETRÓLEO E LUBRIFICANTES'),
('5651', 'Venda de combustível ou lubrificante de produção do estabelecimento destinado à industrialização subseqüente'),
('5652', 'Venda de combustível ou lubrificante de produção do estabelecimento destinado à comercialização'),
('5653', 'Venda de combustível ou lubrificante de produção do estabelecimento destinado a consumidor ou usuário final'),
('5654', 'Venda de combustível ou lubrificante adquirido ou recebido de terceiros destinado à industrialização subseqüente'),
('5655', 'Venda de combustível ou lubrificante adquirido ou recebido de terceiros destinado à comercialização'),
('5656', 'Venda de combustível ou lubrificante adquirido ou recebido de terceiros destinado a consumidor ou usuário final'),
('5657', 'Remessa de combustível ou lubrificante adquirido ou recebido de terceiros para venda fora do estabelecimento'),
('5658', 'Transferência de combustível ou lubrificante de produção do estabelecimento'),
('5659', 'Transferência de combustível ou lubrificante adquirido ou recebido de terceiro'),
('5660', 'Devolução de compra de combustível ou lubrificante adquirido para industrialização subseqüente'),
('5661', 'Devolução de compra de combustível ou lubrificante adquirido para comercializaçã'),
('5662', 'Devolução de compra de combustível ou lubrificante adquirido por consumidor ou usuário final'),
('5663', 'Remessa para armazenagem de combustível ou lubrificante'),
('5664', 'Retorno de combustível ou lubrificante recebido para armazenagem'),
('5665', 'Retorno simbólico de combustível ou lubrificante recebido para armazenagem'),
('5666', 'Remessa por conta e ordem de terceiros de combustível ou lubrificante recebido para armazenagem'),
('5901', 'Remessa para industrialização por encomenda'),
('5902', 'Retorno de mercadoria utilizada na industrialização por encomenda'),
('5903', 'Retorno de mercadoria recebida para industrialização e não aplicada no referido processo'),
('5904', 'Remessa para venda fora do estabelecimento'),
('5905', 'Remessa para depósito fechado ou armazém geral'),
('5906', 'Retorno de mercadoria depositada em depósito fechado ou armazém geral'),
('5907', 'Retorno simbólico de mercadoria depositada em depósito fechado ou armazém geral'),
('5908', 'Remessa de bem por conta de contrato de comodato'),
('5909', 'Retorno de bem recebido por conta de contrato de comodato'),
('5910', 'Remessa em bonificação, doação ou brinde'),
('5911', 'Remessa de amostra grátis'),
('5912', 'Remessa de mercadoria ou bem para demonstração'),
('5913', 'Retorno de mercadoria ou bem recebido para demonstração'),
('5914', 'Remessa de mercadoria ou bem para exposição ou feira'),
('5915', 'Remessa de mercadoria ou bem para conserto ou reparo'),
('5916', 'Retorno de mercadoria ou bem recebido para conserto ou reparo'),
('5917', 'Remessa de mercadoria em consignação mercantil ou industrial'),
('5918', 'Devolução de mercadoria recebida em consignação mercantil ou industrial'),
('5919', 'Devolução simbólica de mercadoria vendida ou utilizada em processo industrial, recebida anteriormente em consignação mercantil ou industrial'),
('5920', 'Remessa de vasilhame ou sacaria'),
('5921', 'Devolução de vasilhame ou sacaria'),
('5922', 'Lançamento efetuado a título de simples faturamento decorrente de venda para entrega futura'),
('5923', 'Remessa de mercadoria por conta e ordem de terceiros, em venda à ordem'),
('5924', 'Remessa para industrialização por conta e ordem do adquirente da mercadoria,'),
('5925', 'Retorno de mercadoria recebida para industrialização por conta e ordem do adquirente da mercadoria, quando aquela não transitar pelo estabelecimento do adquirente'),
('5926', 'Lançamento efetuado a título de reclassificação de mercadoria decorrente de formação de kit ou de sua desagregação'),
('5927', 'Lançamento efetuado a título de baixa de estoque decorrente de perda, roubo ou deterioração'),
('5928', 'Lançamento efetuado a título de baixa de estoque decorrente do encerramento da atividade da empresa'),
('5929', 'Lançamento efetuado em decorrência de emissão de documento fiscal relativo a operação ou prestação também registrada em equipamento Emissor de Cupom Fiscal'),
('5931', 'Lançamento efetuado em decorrência da responsabilidade de retenção do imposto por substituição tributária, atribuída ao remetente ou alienante da mercadoria, pelo serviço de transporte realizado por transportador autônomo ou por transportador não inscrito na unidade da Federação onde iniciado o serviço'),
('5932', 'Prestação de serviço de transporte iniciada em unidade da Federação diversa daquela onde inscrito o prestador'),
('5933', 'Prestação de serviço tributado pelo ISSQN'),
('5949', 'Outra saída de mercadoria ou prestação de serviço não especificado'),
('6101', 'Venda de produção do estabelecimento'),
('6102', 'Venda de mercadoria adquirida ou recebida de terceiros'),
('6103', 'Venda de produção do estabelecimento, efetuada fora do estabelecimento'),
('6104', 'Venda de mercadoria adquirida ou recebida de terceiros, efetuada fora do estabelecimento'),
('6105', 'Venda de produção do estabelecimento que não deva por ele transitar'),
('6106', 'Venda de mercadoria adquirida ou recebida de terceiros, que não deva por ele transitar'),
('6107', 'Venda de produção do estabelecimento, destinada a não contribuinte'),
('6108', 'Venda de mercadoria adquirida ou recebida de terceiros, destinada a não contribuinte'),
('6109', 'Venda de produção do estabelecimento, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('6110', 'Venda de mercadoria adquirida ou recebida de terceiros, destinada à Zona Franca de Manaus ou Áreas de Livre Comércio'),
('6111', 'Venda de produção do estabelecimento remetida anteriormente em consignação industrial'),
('6112', 'Venda de mercadoria adquirida ou recebida de Terceiros remetida anteriormente em consignação industrial'),
('6113', 'Venda de produção do estabelecimento remetida anteriormente em consignação mercantil'),
('6114', 'Venda de mercadoria adquirida ou recebida de terceiros remetida anteriormente em consignação mercantil'),
('6115', 'Venda de mercadoria adquirida ou recebida de terceiros, recebida anteriormente em consignação mercantil'),
('6116', 'Venda de produção do estabelecimento originada de encomenda para entrega futura'),
('6117', 'Venda de mercadoria adquirida ou recebida de terceiros, originada de encomenda para entrega futura'),
('6118', 'Venda de produção do estabelecimento entregue ao destinatário por conta e ordem do adquirente originário, em venda à ordem'),
('6119', 'Venda de mercadoria adquirida ou recebida de terceiros entregue ao destinatário por conta e ordem do adquirente originário, em venda à ordem'),
('6120', 'Venda de mercadoria adquirida ou recebida de terceiros entregue ao destinatário pelo vendedor remetente, em venda à ordem'),
('6122', 'Venda de produção do estabelecimento remetida para industrialização, por conta e ordem do adquirente, sem transitar pelo estabelecimento do adquirente'),
('6123', 'Venda de mercadoria adquirida ou recebida de terceiros remetida para industrialização, por conta e ordem do adquirente, sem transitar pelo estabelecimento do adquirente'),
('6124', 'Industrialização efetuada para outra empresa'),
('6125', 'Industrialização efetuada para outra empresa quando a mercadoria recebida para utilização no processo de industrialização não transitar pelo estabelecimento adquirente da mercadoria'),
('6151', 'Transferência de produção do estabelecimento'),
('6152', 'Transferência de mercadoria adquirida ou recebida de terceiros'),
('6153', 'Transferência de energia elétrica'),
('6155', 'Transferência de produção do estabelecimento, que não deva por ele transitar'),
('6156', 'Transferência de mercadoria adquirida ou recebida de terceiros, que não deva por ele transitar'),
('6201', 'Devolução de compra para industrialização'),
('6202', 'Devolução de compra para comercialização'),
('6205', 'Anulação de valor relativo a aquisição de serviço de comunicação'),
('6206', 'Anulação de valor relativo a aquisição de serviço de transporte'),
('6207', 'Anulação de valor relativo à compra de energia elétrica'),
('6208', 'Devolução de mercadoria recebida em transferência para industrialização'),
('6209', 'Devolução de mercadoria recebida em transferência para comercialização'),
('6210', 'Devolução de compra para utilização na prestação de serviço'),
('6251', 'Venda de energia elétrica para distribuição ou comercialização'),
('6252', 'Venda de energia elétrica para estabelecimento industrial'),
('6253', 'Venda de energia elétrica para estabelecimento comercial'),
('6254', 'Venda de energia elétrica para estabelecimento prestador de serviço de transporte'),
('6255', 'Venda de energia elétrica para estabelecimento prestador de serviço de comunicação'),
('6256', 'Venda de energia elétrica para estabelecimento de produtor rural'),
('6257', 'Venda de energia elétrica para consumo por demanda contratada'),
('6258', 'Venda de energia elétrica a não contribuinte'),
('6301', 'Prestação de serviço de comunicação para execução de serviço da mesma natureza'),
('6302', 'Prestação de serviço de comunicação a estabelecimento industrial'),
('6303', 'Prestação de serviço de comunicação a estabelecimento comercial'),
('6304', 'Prestação de serviço de comunicação a estabelecimento de prestador de serviço de transporte'),
('6305', 'Prestação de serviço de comunicação a estabelecimento de geradora ou de distribuidora de energia elétrica'),
('6306', 'Prestação de serviço de comunicação a estabelecimento de produtor rural'),
('6307', 'Prestação de serviço de comunicação a não contribuinte'),
('6351', 'Prestação de serviço de transporte para execução de serviço da mesma natureza'),
('6352', 'Prestação de serviço de transporte a estabelecimento industrial'),
('6353', 'Prestação de serviço de transporte a estabelecimento comercial'),
('6354', 'Prestação de serviço de transporte a estabelecimento de prestador de serviço de comunicação'),
('6355', 'Prestação de serviço de transporte a estabelecimento de geradora ou de distribuidora de energia elétrica'),
('6356', 'Prestação de serviço de transporte a estabelecimento de produtor rural'),
('6357', 'Prestação de serviço de transporte a não contribuinte'),
('6359', 'Prestação de serviço de transporte a contribuinte ou a não contribuinte quando a mercadoria transportada está dispensada de emissão de nota fiscal'),
('6401', 'Venda de produção do estabelecimento em operação com produto sujeito ao regime de substituição tributária, na condição de contribuinte substituto'),
('6402', 'Venda de produção do estabelecimento de produto sujeito ao regime de substituição tributária, em operação entre contribuintes substitutos do mesmo produto'),
('6403', 'Venda de mercadoria adquirida ou recebida de terceiros em operação com mercadoria sujeita ao regime de substituição tributária, na condição de contribuinte substituto'),
('6404', 'Venda de mercadoria sujeita ao regime de substituição tributária, cujo imposto já tenha sido retido anteriormente'),
('6408', 'Transferência de produção do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('6409', 'Transferência de mercadoria adquirida ou recebida de terceiros em operação com mercadoria sujeita ao regime de substituição tributária'),
('6410', 'Devolução de compra para industrialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('6411', 'Devolução de compra para comercialização em operação com mercadoria sujeita ao regime de substituição tributária'),
('6412', 'Devolução de bem do ativo imobilizado, em operação com mercadoria sujeita ao regime de substituição tributária'),
('6413', 'Devolução de mercadoria destinada ao uso ou consumo, em operação com mercadoria sujeita ao regime de substituição tributária'),
('6414', 'Remessa de produção do estabelecimento para venda fora do estabelecimento em operação com produto sujeito ao regime de substituição tributária'),
('6415', 'Remessa de mercadoria adquirida ou recebida de terceiros para venda fora do estabelecimento, em operação com mercadoria sujeita ao regime de substituição tributária'),
('6501', 'Remessa de produção do estabelecimento, com fim específico de exportação'),
('6502', 'Remessa de mercadoria adquirida ou recebida de terceiros, com fim específico de exportação'),
('6503', 'Devolução de mercadoria recebida com fim específico de exportação'),
('6551', 'Venda de bem do ativo imobilizado'),
('6552', 'Transferência de bem do ativo imobilizado'),
('6553', 'Devolução de compra de bem para o ativo imobilizado'),
('6554', 'Remessa de bem do ativo imobilizado para uso fora do estabelecimento'),
('6555', 'Devolução de bem do ativo imobilizado de terceiro, recebido para uso no estabelecimento'),
('6556', 'Devolução de compra de material de uso ou consumo'),
('6557', 'Transferência de material de uso ou consumo'),
('6603', 'Ressarcimento de ICMS retido por substituição tributária'),
('6650', 'SAÍDAS DE COMBUSTÍVEIS, DERIVADOS OU NÃO DE PETRÓLEO E LUBRIFICANTES'),
('6651', 'Venda de combustível ou lubrificante de produção do estabelecimento destinado à industrialização subseqüente'),
('6652', 'Venda de combustível ou lubrificante de produção do estabelecimento destinado à comercialização'),
('6653', 'Venda de combustível ou lubrificante de produção do estabelecimento destinado a consumidor ou usuário final'),
('6654', 'Venda de combustível ou lubrificante adquirido ou recebido de terceiros destinado à industrialização subseqüente'),
('6655', 'Venda de combustível ou lubrificante adquirido ou recebido de terceiros destinado à comercialização'),
('6656', 'Venda de combustível ou lubrificante adquirido ou recebido de terceiros destinado a consumidor ou usuário final'),
('6657', 'Remessa de combustível ou lubrificante adquirido ou recebido de terceiros para venda fora do estabelecimento'),
('6658', 'Transferência de combustível ou lubrificante de produção do estabelecimento'),
('6659', 'Transferência de combustível ou lubrificante adquirido ou recebido de terceiro'),
('6660', 'Devolução de compra de combustível ou lubrificante adquirido para industrialização subseqüente'),
('6661', 'Devolução de compra de combustível ou lubrificante adquirido para comercialização'),
('6662', 'Devolução de compra de combustível ou lubrificante adquirido por consumidor ou usuário final'),
('6663', 'Remessa para armazenagem de combustível ou lubrificante'),
('6664', 'Retorno de combustível ou lubrificante recebido para armazenagem'),
('6665', 'Retorno simbólico de combustível ou lubrificante recebido para armazenagem'),
('6666', 'Remessa por conta e ordem de terceiros de combustível ou lubrificante recebido para armazenagem'),
('6901', 'Remessa para industrialização por encomenda'),
('6902', 'Retorno de mercadoria utilizada na industrialização por encomenda'),
('6903', 'Retorno de mercadoria recebida para industrialização e não aplicada no referido processo'),
('6904', 'Remessa para venda fora do estabelecimento'),
('6905', 'Remessa para depósito fechado ou armazém geral'),
('6906', 'Retorno de mercadoria depositada em depósito fechado ou armazém geral'),
('6907', 'Retorno simbólico de mercadoria depositada em depósito fechado ou armazém geral'),
('6908', 'Remessa de bem por conta de contrato de comodato'),
('6909', 'Retorno de bem recebido por conta de contrato de comodato'),
('6910', 'Remessa em bonificação, doação ou brinde'),
('6911', 'Remessa de amostra grátis'),
('6912', 'Remessa de mercadoria ou bem para demonstração'),
('6913', 'Retorno de mercadoria ou bem recebido para demonstração'),
('6914', 'Remessa de mercadoria ou bem para exposição ou feira'),
('6915', 'Remessa de mercadoria ou bem para conserto ou reparo'),
('6916', 'Retorno de mercadoria ou bem recebido para conserto ou reparo'),
('6917', 'Remessa de mercadoria em consignação mercantil ou industrial'),
('6918', 'Devolução de mercadoria recebida em consignação mercantil ou industrial'),
('6919', 'Devolução simbólica de mercadoria vendida ou utilizada em processo industrial, recebida anteriormente em consignação mercantil ou industrial'),
('6920', 'Remessa de vasilhame ou sacaria'),
('6921', 'Devolução de vasilhame ou sacaria'),
('6922', 'Lançamento efetuado a título de simples faturamento decorrente de venda para entrega futura'),
('6923', 'Remessa de mercadoria por conta e ordem de terceiros, em venda à ordem'),
('6924', 'Remessa para industrialização por conta e ordem do adquirente da mercadoria, quando esta não transitar pelo estabelecimento do adquirente'),
('6925', 'Retorno de mercadoria recebida para industrialização por conta e ordem do adquirente da mercadoria, quando aquela não transitar pelo estabelecimento do adquirente'),
('6929', 'Lançamento efetuado em decorrência de emissão de documento fiscal relativo a operação ou prestação também registrada em equipamento Emissor de Cupom Fiscal'),
('6931', 'Lançamento efetuado em decorrência da responsabilidade de retenção do imposto por substituição tributária, atribuída ao remetente ou alienante da mercadoria, pelo serviço de transporte realizado por transportador autônomo ou por transportador não inscrito na unidade da Federação onde iniciado o serviço'),
('6932', 'Prestação de serviço de transporte iniciada em unidade da Federação diversa daquela onde inscrito o prestador'),
('6933', 'Prestação de serviço tributado pelo ISSQN'),
('6949', 'Outra saída de mercadoria ou prestação de serviço não especificado'),
('7101', 'Venda de produção do estabelecimento'),
('7102', 'Venda de mercadoria adquirida ou recebida de terceiros'),
('7105', 'Venda de produção do estabelecimento, que não deva por ele transitar'),
('7106', 'Venda de mercadoria adquirida ou recebida de terceiros, que não deva por ele transitar'),
('7127', 'Venda de produção do estabelecimento sob o regime de “drawback”'),
('7201', 'Devolução de compra para industrialização'),
('7202', 'Devolução de compra para comercialização'),
('7205', 'Anulação de valor relativo à aquisição de serviço de comunicação'),
('7206', 'Anulação de valor relativo a aquisição de serviço de transporte'),
('7207', 'Anulação de valor relativo à compra de energia elétrica');
INSERT INTO `cfop` (`codigo`, `descricao`) VALUES
('7210', 'Devolução de compra para utilização na prestação de serviço'),
('7211', 'Devolução de compras para industrialização sob o regime de drawback”'),
('7251', 'Venda de energia elétrica para o exterior'),
('7301', 'Prestação de serviço de comunicação para execução de serviço da mesma natureza'),
('7358', 'Prestação de serviço de transporte'),
('7501', 'Exportação de mercadorias recebidas com fim específico de exportação'),
('7551', 'Venda de bem do ativo imobilizado'),
('7553', 'Devolução de compra de bem para o ativo imobilizado'),
('7556', 'Devolução de compra de material de uso ou consumo'),
('7650', 'Saídas de Combustíveis, Derivados ou não de Petróleo e Lubrificantes'),
('7651', 'Venda de combustível ou lubrificante de produção do estabelecimento'),
('7654', 'Venda de combustível ou lubrificante adquirido ou recebido de terceiros'),
('7930', 'Lançamento efetuado a título de devolução de bem cuja entrada tenha ocorrido sob amparo de regime especial aduaneiro de admissão temporária'),
('7949', 'Outra saída de mercadoria ou prestação de serviço não especificado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cheques`
--

CREATE TABLE IF NOT EXISTS `cheques` (
  `numero` int(11) NOT NULL,
  `valor` varchar(13) NOT NULL,
  `quem` varchar(80) NOT NULL,
  `data` varchar(10) NOT NULL,
  `para` varchar(10) NOT NULL,
  `banco` int(2) NOT NULL,
  `pago` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chqclientes`
--

CREATE TABLE IF NOT EXISTS `chqclientes` (
`id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `quem` varchar(222) NOT NULL,
  `data` varchar(10) NOT NULL,
  `para` varchar(10) NOT NULL,
  `valor` varchar(13) NOT NULL,
  `banco` int(11) NOT NULL,
  `voltou` int(1) NOT NULL DEFAULT '0',
  `compensado` int(1) NOT NULL DEFAULT '0',
  `pedido` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
`id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `fone` varchar(200) NOT NULL,
  `pagamento` varchar(200) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `cpf` varchar(222) NOT NULL,
  `endereco` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compras`
--

CREATE TABLE IF NOT EXISTS `compras` (
`id` int(11) NOT NULL,
  `fornecedor` int(11) NOT NULL,
  `valor` varchar(22) NOT NULL,
  `data` varchar(10) NOT NULL,
  `pagamento` int(1) NOT NULL DEFAULT '0',
  `cartao` int(11) NOT NULL,
  `parcelas` int(2) NOT NULL DEFAULT '1',
  `vencimento` varchar(10) NOT NULL,
  `cheque` int(11) NOT NULL,
  `chqcliente` varchar(500) NOT NULL,
  `boleto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config_boletos_bb`
--

CREATE TABLE IF NOT EXISTS `config_boletos_bb` (
  `id` int(1) NOT NULL,
  `agencia` varchar(10) NOT NULL,
  `conta` varchar(10) NOT NULL,
  `convenio` varchar(222) NOT NULL,
  `contrato` varchar(222) NOT NULL,
  `carteira` varchar(22) NOT NULL,
  `variacao` varchar(22) NOT NULL,
  `juros` varchar(10) NOT NULL,
  `multa` varchar(10) NOT NULL,
  `dias` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `config_boletos_bb`
--

INSERT INTO `config_boletos_bb` (`id`, `agencia`, `conta`, `convenio`, `contrato`, `carteira`, `variacao`, `juros`, `multa`, `dias`) VALUES
(1, '0000', '00000', '0000', '0000', '18', '19', '2,33', '3', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config_empresa`
--

CREATE TABLE IF NOT EXISTS `config_empresa` (
  `id` int(1) NOT NULL,
  `nome` varchar(222) NOT NULL,
  `razao` varchar(222) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `ie` varchar(15) NOT NULL,
  `email` varchar(222) NOT NULL,
  `endereco` mediumtext NOT NULL,
  `cep` varchar(9) NOT NULL,
  `cidade` varchar(222) NOT NULL,
  `estado` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `config_empresa`
--

INSERT INTO `config_empresa` (`id`, `nome`, `razao`, `cnpj`, `ie`, `email`, `endereco`, `cep`, `cidade`, `estado`) VALUES
(1, 'Empresa NFE', 'Empresa NFE LTDA ME', '02.388.678/0001-99', '103031650', 'megacomsistemas@gmail.com', 'Rua Fortaleza, N 70, Qd. 01 Lt. 04, Vila Paraiso - Fama', '74553-530', 'Goiania', 'GO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config_nfe`
--

CREATE TABLE IF NOT EXISTS `config_nfe` (
  `id` int(1) NOT NULL DEFAULT '1',
  `xNome` varchar(60) NOT NULL,
  `xFant` varchar(60) NOT NULL,
  `IE` varchar(22) NOT NULL,
  `IEST` varchar(22) NOT NULL DEFAULT '0',
  `IM` varchar(22) NOT NULL DEFAULT '0',
  `CNAE` varchar(22) NOT NULL,
  `CRT` int(1) NOT NULL,
  `alicota` varchar(10) NOT NULL,
  `credito` varchar(10) NOT NULL,
  `CNPJ` varchar(22) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `xLgr` varchar(60) NOT NULL,
  `nro` int(60) NOT NULL,
  `xCpl` varchar(60) NOT NULL,
  `xBairro` varchar(60) NOT NULL,
  `cMun` int(7) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `CEP` int(8) NOT NULL,
  `cPais` int(4) NOT NULL,
  `xPais` varchar(60) NOT NULL,
  `fone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `config_nfe`
--

INSERT INTO `config_nfe` (`id`, `xNome`, `xFant`, `IE`, `IEST`, `IM`, `CNAE`, `CRT`, `alicota`, `credito`, `CNPJ`, `CPF`, `xLgr`, `nro`, `xCpl`, `xBairro`, `cMun`, `UF`, `CEP`, `cPais`, `xPais`, `fone`) VALUES
(1, 'RAZAO', 'FANTASIA', '00000000000', '', '', '47.21-1-04', 1, '0', '0', '00000000000000', '', 'LOGRADOURO', 0, 'COMPLEMENTO', 'BAIRRO', 123456789, 'UF', 0, 1058, '', '0000000000');

-- --------------------------------------------------------

--
-- Estrutura da tabela `crt`
--

CREATE TABLE IF NOT EXISTS `crt` (
`id` int(1) NOT NULL,
  `descricao` varchar(222) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `crt`
--

INSERT INTO `crt` (`id`, `descricao`) VALUES
(1, 'Simples Nacional'),
(2, 'Simples Nacional - excesso de sublimite de receita bruta'),
(3, 'Regime Normal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `despesas`
--

CREATE TABLE IF NOT EXISTS `despesas` (
`id` int(11) NOT NULL,
  `titulo` varchar(222) NOT NULL,
  `valor` varchar(22) NOT NULL,
  `data` varchar(10) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '0',
  `pagamento` int(1) NOT NULL DEFAULT '0',
  `cartao` int(11) NOT NULL,
  `parcelas` int(2) NOT NULL DEFAULT '1',
  `vencimento` varchar(10) NOT NULL,
  `cheque` int(11) NOT NULL,
  `chqcliente` varchar(500) NOT NULL,
  `boleto` int(11) NOT NULL,
  `debito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destinatarios`
--

CREATE TABLE IF NOT EXISTS `destinatarios` (
`id` int(1) NOT NULL,
  `xNome` varchar(60) NOT NULL,
  `IE` varchar(22) NOT NULL,
  `CNPJ` varchar(22) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `email` varchar(222) NOT NULL,
  `xLgr` varchar(60) NOT NULL,
  `nro` int(60) NOT NULL,
  `xCpl` varchar(60) NOT NULL,
  `xBairro` varchar(60) NOT NULL,
  `cMun` int(7) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `CEP` int(8) NOT NULL,
  `cPais` int(4) NOT NULL,
  `fone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(2) NOT NULL,
  `sigla` varchar(5) NOT NULL,
  `nome` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`id`, `sigla`, `nome`) VALUES
(11, 'RO', 'Rond&ocirc;nia'),
(12, 'AC', 'Acre'),
(13, 'AM', 'Amazonas'),
(14, 'RR', 'Roraima'),
(15, 'PA', 'Par&aacute;'),
(16, 'AP', 'Amap&aacute;'),
(17, 'TO', 'Tocantis'),
(21, 'MA', 'Maranh&atilde;o'),
(22, 'PI', 'Piau&iacute;'),
(23, 'CE', 'Cear&aacute;'),
(24, 'RN', 'Rio Grande do Norte'),
(25, 'PB', 'Para&iacute;ba'),
(26, 'PE', 'Pernambuco'),
(27, 'AL', 'Alagoas'),
(28, 'SE', 'Sergipe'),
(29, 'BA', 'Bahia'),
(31, 'MG', 'Minas Gerais'),
(32, 'ES', 'Esp&iacute;rito Santo'),
(33, 'RJ', 'Rio de Janeiro'),
(35, 'SP', 'S&atilde;o Paulo'),
(41, 'PR', 'Paran&aacute;'),
(42, 'SC', 'Santa Catarina'),
(43, 'RS', 'Rio Grande do Sul'),
(50, 'MS', 'Mato Grosso do Sul'),
(51, 'MT', 'Mato Grosso'),
(52, 'GO', 'Goi&aacute;s'),
(53, 'DF', 'Distrito Federal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE IF NOT EXISTS `estoque` (
`id` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `quantidade` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `extratos`
--

CREATE TABLE IF NOT EXISTS `extratos` (
`id` int(11) NOT NULL,
  `doc` varchar(222) NOT NULL,
  `banco` int(11) NOT NULL,
  `mes` int(2) NOT NULL,
  `ano` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fiados`
--

CREATE TABLE IF NOT EXISTS `fiados` (
`id` int(11) NOT NULL,
  `vendedor` int(1) NOT NULL,
  `ida` varchar(12) NOT NULL DEFAULT '0',
  `volta` varchar(12) NOT NULL DEFAULT '0',
  `balanco` int(11) NOT NULL DEFAULT '0',
  `data` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `financiamentos`
--

CREATE TABLE IF NOT EXISTS `financiamentos` (
`id` int(11) NOT NULL,
  `titulo` varchar(222) NOT NULL,
  `banco` int(11) NOT NULL,
  `valor` varchar(10) NOT NULL,
  `parcela` varchar(10) NOT NULL,
  `nParcelas` int(4) NOT NULL,
  `taxas` varchar(10) NOT NULL,
  `juros` varchar(10) NOT NULL,
  `dataInicial` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE IF NOT EXISTS `fornecedores` (
`id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `fone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `cnpj` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE IF NOT EXISTS `funcionarios` (
`id` int(11) NOT NULL,
  `foto` varchar(222) NOT NULL DEFAULT '0',
  `nome` varchar(222) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `celular` varchar(14) NOT NULL DEFAULT '0',
  `cpf` varchar(15) NOT NULL,
  `banco` varchar(222) NOT NULL,
  `agencia` varchar(8) NOT NULL,
  `conta` varchar(10) NOT NULL,
  `funcao` int(11) NOT NULL,
  `fixo` varchar(22) NOT NULL DEFAULT '0',
  `comissao` varchar(2) NOT NULL DEFAULT '0',
  `sexo` int(1) NOT NULL DEFAULT '0',
  `nascimento` varchar(10) NOT NULL DEFAULT '0',
  `endereco` text NOT NULL,
  `estadoCivil` int(1) NOT NULL DEFAULT '0',
  `pis` varchar(14) NOT NULL,
  `numeroCT` int(11) NOT NULL,
  `serieCT` varchar(5) NOT NULL,
  `rg` int(11) NOT NULL,
  `cnh` int(11) NOT NULL DEFAULT '0',
  `cnhCat` varchar(4) NOT NULL,
  `cnhVal` varchar(10) NOT NULL DEFAULT '0',
  `admissao` varchar(10) NOT NULL DEFAULT '0',
  `experiencia` int(1) NOT NULL DEFAULT '0',
  `diasExp` int(5) NOT NULL DEFAULT '0',
  `efetivado` varchar(10) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '1',
  `demissao` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcoes`
--

CREATE TABLE IF NOT EXISTS `funcoes` (
`id` int(11) NOT NULL,
  `nome` varchar(222) NOT NULL,
  `comissao` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `localizacao`
--

CREATE TABLE IF NOT EXISTS `localizacao` (
`id` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `data` varchar(10) NOT NULL,
  `horario` varchar(10) NOT NULL,
  `location` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE IF NOT EXISTS `login` (
`id` int(1) NOT NULL,
  `nome` varchar(222) NOT NULL,
  `login` varchar(222) NOT NULL,
  `senha` varchar(222) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `nome`, `login`, `senha`) VALUES
(1, 'Administrador', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Estrutura da tabela `meses`
--

CREATE TABLE IF NOT EXISTS `meses` (
`id` int(11) NOT NULL,
  `mes` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `meses`
--

INSERT INTO `meses` (`id`, `mes`) VALUES
(1, 'Janeiro'),
(2, 'Fevereiro'),
(3, 'Mar&ccedil;o'),
(4, 'Abril'),
(5, 'Maio'),
(6, 'Junho'),
(7, 'Julho'),
(8, 'Agosto'),
(9, 'Setembro'),
(10, 'Outubro'),
(11, 'Novembro'),
(12, 'Dezembro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `municipios`
--

CREATE TABLE IF NOT EXISTS `municipios` (
`codigo` int(11) NOT NULL,
  `nome` varchar(222) NOT NULL,
  `rota` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5222215 ;

--
-- Extraindo dados da tabela `municipios`
--

INSERT INTO `municipios` (`codigo`, `nome`, `rota`) VALUES
(1301159, 'CAREIRO DA  VÁRZEA', 0),
(1301852, 'IRANDUBA', 0),
(1301902, 'ITACOATIARA', 0),
(1302504, 'MANACAPURU', 0),
(1302603, 'MANAUS', 0),
(1303205, 'NOVO AIRÃO', 0),
(1303536, 'PRESIDENTE FIGUEIREDO', 0),
(1303569, 'RIO PRETO DA EVA', 0),
(1500800, 'ANANINDEUA', 0),
(1501402, 'BELÉM', 0),
(1501501, 'BENEVIDES', 0),
(1504422, 'MARITUBA', 0),
(1506351, 'SANTA BÁRBARA DO PARÁ', 0),
(1506500, 'SANTA IZABEL DO PARÁ', 0),
(1600303, 'MACAPÁ', 0),
(1600600, 'SANTANA', 0),
(1721000, 'Palmas', 0),
(2100204, 'ALCÂNTARA', 0),
(2102358, 'BURITIRANA', 0),
(2103752, 'DAVINÓPOLIS', 0),
(2104552, 'GOVERNADOR EDISON LOBÃO', 0),
(2105302, 'IMPERATRIZ', 0),
(2105500, 'JOÃO LISBOA', 0),
(2107001, 'MONTES ALTOS', 0),
(2107506, 'PAÇO DO LUMIAR', 0),
(2109452, 'RAPOSA', 0),
(2109551, 'RIBAMAR FIQUENE', 0),
(2111201, 'SÃO JOSÉ DE RIBAMAR', 0),
(2111300, 'SÃO LUÍS', 0),
(2111763, 'SENADOR LA ROCQUE', 0),
(2112209, 'TIMON', 0),
(2200400, 'ALTOS', 0),
(2201606, 'BENEDITINOS', 0),
(2202737, 'COIVARAS', 0),
(2203255, 'CURRALINHO', 0),
(2203305, 'DEMERVAL LOBÃO', 0),
(2205508, 'JOSÉ DE FREITAS', 0),
(2205557, 'LAGOA ALEGRE', 0),
(2205581, 'LAGOA DO PIAUÍ', 0),
(2206308, 'MIGUEL LEÃO', 0),
(2206407, 'MONSENHOR GIL', 0),
(2206720, 'NAZÁRIA', 0),
(2211001, 'TERESINA', 0),
(2211100, 'UNIÃO', 0),
(2301000, 'AQUIRAZ', 0),
(2301901, 'BARBALHA', 0),
(2303204, 'CARIRIAÇU', 0),
(2303501, 'CASCAVEL', 0),
(2303709, 'CAUCAIA', 0),
(2303956, 'CHOROZINHO', 0),
(2304202, 'CRATO', 0),
(2304285, 'EUZÉBIO', 0),
(2304301, 'FARIAS BRITO', 0),
(2304400, 'FORTALEZA', 0),
(2304954, 'GUAIÚBA', 0),
(2305233, 'HORIZONTE', 0),
(2306256, 'ITAITINGA', 0),
(2307106, 'JARDIM', 0),
(2307304, 'JUAZEIRO DO NORTE', 0),
(2307650, 'MARACANAÚ', 0),
(2307700, 'MARANGUAPE', 0),
(2308401, 'MISSÃO VELHA', 0),
(2309201, 'NOVA OLINDA ', 0),
(2309607, 'PACAJUS', 0),
(2309706, 'PACATUBA', 0),
(2310852, 'PINDORETAMA', 0),
(2312106, 'SANTANA DO CARIRI', 0),
(2312403, 'SÃO GONÇALO DO AMARANTE', 0),
(2402600, 'CEARÁ-MIRIM', 0),
(2403251, 'PARNAMIRIM', 0),
(2403608, 'EXTREMOZ', 0),
(2407104, 'MACAÍBA', 0),
(2407807, 'MONTE ALEGE', 0),
(2408102, 'NATAL', 0),
(2408201, 'NÍZIA FLORESTA', 0),
(2412005, 'SÃO GONÇALO DO AMARANTE', 0),
(2412203, 'SÃO JOSÉ DE MIBIPÚ', 0),
(2414803, 'VERA CRUZ', 0),
(2500403, 'ALAGOA NOVA', 0),
(2500536, 'ALCANTIL', 0),
(2500601, 'ALHANDRA', 0),
(2501203, 'AREIAL', 0),
(2501302, 'AROEIRAS', 0),
(2501575, 'BARRA DE SANTANA', 0),
(2501807, 'BAYEUX', 0),
(2502151, 'BOA VISTA', 0),
(2502508, 'BOQUEIRÃO', 0),
(2503001, 'CAAPORÃ', 0),
(2503209, 'CABEDELO', 0),
(2504009, 'CAMPINA GRANDE', 0),
(2504355, 'CATURITÉ', 0),
(2504603, 'CONDE', 0),
(2504900, 'CRUZ DO ESPÍRITO SANTO', 0),
(2506004, 'ESPERANÇA', 0),
(2506103, 'FAGUNDES', 0),
(2506251, 'GADO BRAVO', 0),
(2506806, 'INGÁ', 0),
(2507200, 'ITATUBA', 0),
(2507507, 'JOÃO PESSOA', 0),
(2508307, 'LAGOA SECA', 0),
(2508604, 'LUCENA', 0),
(2508901, 'MAMANGUAPE', 0),
(2509206, 'MASSARANDUBA', 0),
(2509339, 'MATINHAS', 0),
(2509503, 'MONTADAS', 0),
(2509909, 'NATUBA', 0),
(2511202, 'PEDRAS DE FOGO', 0),
(2511905, 'PITIMBÚ', 0),
(2512002, 'POCINHOS', 0),
(2512408, 'PUXINANÃ', 0),
(2512507, 'QUEIMADAS', 0),
(2512705, 'REMÍGIO', 0),
(2512754, 'RIACHÃO DO BACAMARTE', 0),
(2512903, 'RIO TINTO', 0),
(2513158, 'SANTA CECÍLIA', 0),
(2513703, 'SANTA RITA', 0),
(2515104, 'SÃO SEBASTIÃO DE LAGOA DE ROÇA', 0),
(2515807, 'SERRA REDONDA', 0),
(2517001, 'UMBUZEIRO', 0),
(2600054, 'ABREU E LIMA', 0),
(2601052, 'ARAÇOIABA', 0),
(2602902, 'CABO DE SANTO AGOSTINHO', 0),
(2603454, 'CAMARAGIBE', 0),
(2606804, 'IGARASSU', 0),
(2607208, 'IPOJUCA', 0),
(2607604, 'ILHA DE ITAMARACÁ', 0),
(2607752, 'ITAPISSUMA', 0),
(2607901, 'JABOATÃO DOS GUARARAPES', 0),
(2608750, 'LAGOA GRANDE', 0),
(2609402, 'MORENO', 0),
(2609600, 'OLINDA', 0),
(2609808, 'OROCÓ', 0),
(2610707, 'PAULISTA', 0),
(2611101, 'PETROLINA', 0),
(2611606, 'RECIFE', 0),
(2612604, 'SANTA MARIA DA BOA VISTA', 0),
(2613701, 'SÃO LOURENÇO DA MATA', 0),
(2700300, 'ARAPIRACA', 0),
(2700508, 'BARRA DE SANTO ANTÔNIO', 0),
(2700607, 'BARRA DE SÃO MIGUEL', 0),
(2700805, 'BELÉM', 0),
(2701506, 'CAMPO GRANDE', 0),
(2702009, 'COITÉ DO NÓIA', 0),
(2702207, 'COQUEIRO SÊCO', 0),
(2702355, 'CRAÍBAS', 0),
(2702553, 'ESTRELA DE ALAGOAS', 0),
(2702603, 'FEIRA GRANDE', 0),
(2702900, 'GIRAU DO PONCIANO', 0),
(2703106, 'IGACI', 0),
(2703700, 'JARAMATAIA', 0),
(2704005, 'JUNQUEIRO', 0),
(2704104, 'LAGOA DA CANOA', 0),
(2704203, 'LIMOEIRO DE ANADIA', 0),
(2704302, 'MACEIÓ', 0),
(2704708, 'MARECHAL DEODORO', 0),
(2705200, 'MESSIAS', 0),
(2705903, 'OLHO D''ÁGUA GRANDE', 0),
(2706307, 'PALMEIRA DOS ÍNDIOS', 0),
(2706448, 'PARIPUEIRA', 0),
(2706901, 'PILAR', 0),
(2707701, 'RIO LARGO', 0),
(2707909, 'SANTA LUZIA DO NORTE', 0),
(2708204, 'SÃO BRÁS', 0),
(2708808, 'SÃO SEBASTIÃO', 0),
(2708907, 'SATUBA', 0),
(2709004, 'TANQUE D''ARCA', 0),
(2709103, 'TAQUARANA', 0),
(2709202, 'TRAIPU', 0),
(2800308, 'ARACAJU', 0),
(2800605, 'BARRA DOS COQUEIROS', 0),
(2804805, 'NOSSA SENHORA DO SOCORRO', 0),
(2806701, 'SÃO CRISTOVÃO', 0),
(2905701, 'CAMAÇARI', 0),
(2906501, 'CANDEIAS', 0),
(2907202, 'CASA NOVA', 0),
(2909901, 'CURAÇÁ', 0),
(2910057, 'DIAS D''ÁVILA', 0),
(2916104, 'ITAPARICA', 0),
(2918407, 'JUAZEIRO', 0),
(2919207, 'LAURO DE FREITAS', 0),
(2919926, 'MADRE DE DEUS', 0),
(2921005, 'MATA DE SÃO JOÃO', 0),
(2925204, 'POJUCA', 0),
(2927408, 'SALVADOR', 0),
(2929206, 'SÃO FRANCISCO DO CONDE', 0),
(2929503, 'SÃO SEBASTIÃO DO PASSÉ', 0),
(2930709, 'SIMÕES FILHO', 0),
(2930774, 'SOBRADINHO', 0),
(2933208, 'VERA CRUZ', 0),
(3100500, 'AÇUCENA', 0),
(3103009, 'ANTÔNIO DIAS', 0),
(3105004, 'BALDIM', 0),
(3105400, 'BARÃO DE COCAIS', 0),
(3106200, 'BELO HORIZONTE', 0),
(3106309, 'BELO ORIENTE', 0),
(3106408, 'BELO VALE', 0),
(3106705, 'BETIM', 0),
(3108107, 'BONFIM', 0),
(3108800, 'BRAÚNAS', 0),
(3109006, 'BRUMADINHO', 0),
(3109253, 'BUGRE', 0),
(3109303, 'BURITIS', 0),
(3110004, 'CAETÉ', 0),
(3112505, 'CAPIM BRANCO', 0),
(3117876, 'CONFINS', 0),
(3118601, 'CONTAGEM', 0),
(3119401, 'CORONEL FABRICIANO', 0),
(3120003, 'CÓRREGO NOVO', 0),
(3121803, 'DIONÍSIO', 0),
(3122504, 'DOM CAVATI', 0),
(3123858, 'ENTRE FOLHAS', 0),
(3124104, 'ESMERALDAS', 0),
(3126000, 'FLORESTAL', 0),
(3126406, 'FORTUNA DE MINAS', 0),
(3127206, 'FUNILÂNDIA', 0),
(3129301, 'IAPU', 0),
(3129806, 'IBIRITÉ', 0),
(3130101, 'IGARAPÉ', 0),
(3131000, 'INHAÚMA', 0),
(3131158, 'IPABA', 0),
(3131307, 'IPATINGA', 0),
(3131901, 'ITABIRITO', 0),
(3132206, 'ITAGUARA', 0),
(3133709, 'ITATIAIUÇU', 0),
(3133808, 'ITAÚNA', 0),
(3134608, 'JABOTICATUBAS', 0),
(3135001, 'JAGUARAÇU', 0),
(3136108, 'JOANÉSIA', 0),
(3136603, 'NOVA UNIÃO', 0),
(3136652, 'JUATUBA', 0),
(3137601, 'LAGOA SANTA', 0),
(3140159, 'MÁRIO CAMPOS', 0),
(3140308, 'MARLIÉRIA', 0),
(3140704, 'MATEUS LEME', 0),
(3141108, 'MATOZINHOS', 0),
(3141702, 'MESQUITA', 0),
(3142304, 'MOEDA', 0),
(3144359, 'NAQUE', 0),
(3144805, 'NOVA LIMA', 0),
(3147105, 'PARÁ DE MINAS', 0),
(3149309, 'PEDRO LEOPOLDO', 0),
(3149952, 'PERIQUITO', 0),
(3150539, 'PINGO D''ÁGUA', 0),
(3153608, 'PRUDENTE DE MORAIS', 0),
(3153905, 'RAPOSOS', 0),
(3154606, 'RIBEIRÃO DAS NEVES', 0),
(3154804, 'RIO ACIMA', 0),
(3155306, 'RIO MANSO', 0),
(3156700, 'SABARÁ', 0),
(3157203, 'SANTA BÁRBARA', 0),
(3157807, 'SANTA LUZIA', 0),
(3158953, 'SANTANA DO PARAÍSO', 0),
(3162609, 'SÃO JOÃO DO ORIENTE', 0),
(3162922, 'SÃO JOAQUIM DE BICAS', 0),
(3162955, 'SÃO JOSÉ DA LAPA', 0),
(3163102, 'SÃO JOSÉ DA VARGINHA', 0),
(3163409, 'SÃO JOSÉ DO GOIABAL', 0),
(3165537, 'SARZEDO', 0),
(3167202, 'SETE LAGOAS', 0),
(3167707, 'SOBRÁLIA', 0),
(3168309, 'TAQUARAÇU DE MINAS', 0),
(3168705, 'TIMÓTEO', 0),
(3170404, 'UNAÍ', 0),
(3170578, 'VARGEM ALEGRE', 0),
(3171204, 'VESPASIANO', 0),
(3201308, 'CARIACICA', 0),
(3202207, 'FUNDÃO', 0),
(3202405, 'GUARAPARI', 0),
(3205002, 'SERRA', 0),
(3205101, 'VIANA', 0),
(3205200, 'VILA VELHA', 0),
(3205309, 'VITÓRIA', 0),
(3300456, 'BELFORD ROXO', 0),
(3301702, 'DUQUE DE CAXIAS', 0),
(3301850, 'GUAPIMIRIM', 0),
(3301900, 'ITABORAÍ', 0),
(3302007, 'ITAGUAÍ', 0),
(3302270, 'JAPERI', 0),
(3302502, 'MAGÉ', 0),
(3302700, 'MARICÁ', 0),
(3302858, 'MESQUITA', 0),
(3303203, 'NILÓPOLIS', 0),
(3303302, 'NITERÓI', 0),
(3303500, 'NOVA IGUAÇU', 0),
(3303609, 'PARACAMBI', 0),
(3304144, 'QUEIMADOS', 0),
(3304557, 'RIO DE JANEIRO', 0),
(3304904, 'SÃO GONÇALO', 0),
(3305109, 'SÃO JOÃO DE MERITI', 0),
(3305554, 'SEROPÉDICA', 0),
(3305752, 'TANGUÁ', 0),
(3501608, 'AMERICANA', 0),
(3503802, 'ARTUR NOGUEIRA', 0),
(3503901, 'ARUJÁ', 0),
(3505708, 'BARUERI', 0),
(3506359, 'BERTIOGA', 0),
(3506607, 'BIRITIBA-MIRIM', 0),
(3509007, 'CAIEIRAS', 0),
(3509205, 'CAJAMAR', 0),
(3509502, 'CAMPINAS', 0),
(3510609, 'CARAPICUÍBA', 0),
(3512803, 'COSMÓPOLIS', 0),
(3513009, 'COTIA', 0),
(3513504, 'CUBATÃO', 0),
(3513801, 'DIADEMA', 0),
(3515004, 'EMBU', 0),
(3515103, 'EMBU-GUAÇU', 0),
(3515152, 'ENGENHEIRO COELHO', 0),
(3515707, 'FERRAZ DE VASCONCELOS', 0),
(3516309, 'FRANCISCO MORATO', 0),
(3516408, 'FRANCO DA ROCHA', 0),
(3518305, 'GUARAREMA', 0),
(3518701, 'GUARUJÁ', 0),
(3518800, 'GUARULHOS', 0),
(3519055, 'HOLAMBRA', 0),
(3519071, 'HORTOLÂNDIA', 0),
(3520509, 'INDAIATUBA', 0),
(3522109, 'ITANHAÉM', 0),
(3522208, 'ITAPECERICA DA SERRA', 0),
(3522505, 'ITAPEVI', 0),
(3523107, 'ITAQUAQUECETUBA', 0),
(3523404, 'ITATIBA', 0),
(3524709, 'JAGUARIÚNA', 0),
(3525003, 'JANDIRA', 0),
(3526209, 'JUQUITIBA', 0),
(3528502, 'MAIRIPORÃ', 0),
(3529401, 'MAUÁ', 0),
(3530607, 'MOGI DAS CRUZES', 0),
(3531100, 'MONGAGUÁ', 0),
(3531803, 'MONTE MOR', 0),
(3533403, 'NOVA ODESSA', 0),
(3534401, 'OSASCO', 0),
(3536505, 'PAULÍNIA', 0),
(3537107, 'PEDREIRA', 0),
(3537602, 'PERUÍBE', 0),
(3539103, 'PIRAPORA DO BOM JESUS', 0),
(3539806, 'POÁ', 0),
(3541000, 'PRAIA GRANDE', 0),
(3543303, 'RIBEIRÃO PIRES', 0),
(3544103, 'RIO GRANDE DA SERRA', 0),
(3545001, 'SALESÓPOLIS', 0),
(3545803, 'SANTA BÁRBARA D''OESTE', 0),
(3546801, 'SANTA ISABEL', 0),
(3547304, 'SANTANA DE PARNAÍBA', 0),
(3547809, 'SANTO ANDRÉ', 0),
(3548005, 'SANTO ANTÔNIO DE POSSE', 0),
(3548500, 'SANTOS', 0),
(3548708, 'SÃO BERNARDO DO CAMPO', 0),
(3548807, 'SÃO CAETANO DO SUL', 0),
(3549953, 'SÃO LOURENÇO DA SERRA', 0),
(3550308, 'SÃO PAULO', 0),
(3551009, 'SÃO VICENTE', 0),
(3552403, 'SUMARÉ', 0),
(3552502, 'SUZANO', 0),
(3552809, 'TABOÃO DA SERRA', 0),
(3556206, 'VALINHOS', 0),
(3556453, 'VARGEM GRANDE PAULISTA', 0),
(3556701, 'VINHEDO', 0),
(4100202, 'ADRIANÓPOLIS', 0),
(4100301, 'AGUDOS DO SUL', 0),
(4100400, 'ALMIRANTE TAMANDARÉ', 0),
(4100806, 'ALVORADA DO SUL', 0),
(4101150, 'ÂNGULO', 0),
(4101804, 'ARAUCÁRIA', 0),
(4101903, 'ASSAÍ', 0),
(4102109, 'ASTORGA', 0),
(4102208, 'ATALAIA', 0),
(4102307, 'BALSA NOVA', 0),
(4102802, 'BELA VISTA DO PARAÍSO', 0),
(4103107, 'BOCAIÚVA DO SUL', 0),
(4103206, 'BOM SUCESSO', 0),
(4103701, 'CAMBÉ', 0),
(4103800, 'CAMBIRA', 0),
(4104006, 'CAMPINA GRANDE DO SUL', 0),
(4104204, 'CAMPO LARGO', 0),
(4104253, 'CAMPO MAGRO', 0),
(4105201, 'CERRO AZUL', 0),
(4105805, 'COLOMBO', 0),
(4106209, 'CONTENDA', 0),
(4106902, 'CURITIBA', 0),
(4107306, 'DOUTOR CAMARGO', 0),
(4107652, 'FAZENDA RIO GRANDE', 0),
(4107801, 'FLORAÍ', 0),
(4107900, 'FLORESTA', 0),
(4108106, 'FLÓRIDA', 0),
(4109807, 'IBIPORÃ', 0),
(4110003, 'IGUARAÇU', 0),
(4111100, 'ITAMBÉ', 0),
(4111258, 'ITAPERUÇU', 0),
(4111605, 'IVATUBA', 0),
(4112108, 'JANDAIA DO SUL', 0),
(4112702, 'JATAIZINHO', 0),
(4113205, 'LAPA', 0),
(4113601, 'LOBATO', 0),
(4113700, 'LONDRINA', 0),
(4114104, 'MANDAGUAÇU', 0),
(4114203, 'MANDAGUARI', 0),
(4114302, 'MANDIRITUBA', 0),
(4114807, 'MARIALVA', 0),
(4115200, 'MARINGÁ', 0),
(4116307, 'MUNHOZ DE MELO', 0),
(4117404, 'OURIZONA', 0),
(4117503, 'PAIÇANDU', 0),
(4119152, 'PINHAIS', 0),
(4119509, 'PIRAQUARA', 0),
(4120408, 'PRESIDENTE CASTELO BRANCO', 0),
(4120507, 'PRIMEIRO DE MAIO', 0),
(4120804, 'QUATRO BARRAS', 0),
(4121208, 'QUITANDINHA', 0),
(4122206, 'RIO BRANCO DO SUL', 0),
(4122404, 'ROLÂNDIA', 0),
(4123402, 'SANTA FÉ', 0),
(4125308, 'SÃO JORGE DO IVAÍ', 0),
(4125506, 'SÃO JOSÉ DOS PINHAIS', 0),
(4126256, 'SARANDI', 0),
(4126504, 'SERTANÓPOLIS', 0),
(4126678, 'TAMARANA', 0),
(4127601, 'TIJUCAS DO SUL', 0),
(4127882, 'TUNAS DO PARANÁ', 0),
(4128633, 'DOUTOR ULYSSES', 0),
(4200507, 'ÁGUAS DE CHAPECÓ', 0),
(4200556, 'ÁGUAS FRIAS', 0),
(4200606, 'ÁGUAS MORNAS', 0),
(4200705, 'ALFREDO WAGNER', 0),
(4200903, 'ANGELINA', 0),
(4201000, 'ANITA GARIBALDI', 0),
(4201109, 'ANITÁPOLIS', 0),
(4201208, 'ANTÔNIO CARLOS', 0),
(4201257, 'APIÚNA', 0),
(4201307, 'ARAQUARI', 0),
(4201406, 'ARARANGUÁ', 0),
(4201505, 'ARMAZÉM', 0),
(4201653, 'ARVOREDO', 0),
(4201703, 'ASCURRA', 0),
(4201950, 'BALNEÁRIO ARROIO DO SILVA', 0),
(4202008, 'BALNEARIO CAMBORIU', 0),
(4202057, 'BALNEÁRIO DA BARRA DO SUL', 0),
(4202073, 'BALNEÁRIO GAIVOTA', 0),
(4202107, 'BARRA VELHA', 0),
(4202206, 'BENEDITO NOVO', 0),
(4202305, 'BIGUAÇU', 0),
(4202404, 'BLUMENAU', 0),
(4202438, 'BOCAINA DO SUL', 0),
(4202453, 'BOMBINHAS', 0),
(4202503, 'BOM JARDIM DA SERRA', 0),
(4202602, 'BOM RETIRO', 0),
(4202701, 'BOTUVERÁ', 0),
(4202800, 'BRAÇO DO NORTE', 0),
(4202909, 'BRUSQUE', 0),
(4203204, 'CAMBORIU', 0),
(4203253, 'CAPÃO ALTO', 0),
(4203303, 'CAMPO ALEGRE', 0),
(4203402, 'CAMPO BELO DO SUL', 0),
(4203709, 'CANELINHA', 0),
(4203956, 'CAPIVARI DE BAIXO', 0),
(4204103, 'CAXAMBU DO SUL', 0),
(4204178, 'CERRO NEGRO', 0),
(4204202, 'CHAPECÓ', 0),
(4204251, 'COCAL DO SUL', 0),
(4204400, 'CORONEL FREITAS', 0),
(4204509, 'CORUPÁ', 0),
(4204558, 'CORREIA PINTO', 0),
(4204608, 'CRICIUMA', 0),
(4204756, 'CUNHATAÍ', 0),
(4204806, 'CURITIBANOS', 0),
(4205159, 'DOUTOR PEDRINHO', 0),
(4205191, 'ERMO', 0),
(4205308, 'FAXINAL DOS GUEDES', 0),
(4205407, 'FLORIANÓPOLIS', 0),
(4205456, 'FORQUILHINHA', 0),
(4205555, 'FREI ROGÉRIO', 0),
(4205704, 'GAROPABA', 0),
(4205803, 'GARUVA', 0),
(4205902, 'GASPAR', 0),
(4206009, 'GOVERNADOR CELSO RAMOS', 0),
(4206108, 'GRÃO PARÁ', 0),
(4206207, 'GRAVATAL', 0),
(4206306, 'GUABIRUBA', 0),
(4206504, 'GUARAMIRIM', 0),
(4206652, 'GUATAMBÚ', 0),
(4207007, 'IÇARA', 0),
(4207106, 'ILHOTA', 0),
(4207205, 'IMARUÍ', 0),
(4207304, 'IMBITUBA', 0),
(4207502, 'INDAIAL', 0),
(4208005, 'ITÁ', 0),
(4208104, 'ITAIÓPOLIS', 0),
(4208203, 'ITAJAÍ', 0),
(4208302, 'ITAPEMA', 0),
(4208450, 'ITAPOÁ', 0),
(4208708, 'JACINTO MACHADO', 0),
(4208807, 'JAGUARUNA', 0),
(4208906, 'JARAGUÁ DO SUL', 0),
(4209102, 'JOINVILLE', 0),
(4209300, 'LAGES', 0),
(4209409, 'LAGUNA', 0),
(4209607, 'LAURO MULLER', 0),
(4209805, 'LEOBERTO LEAL', 0),
(4210001, 'LUIZ ALVES', 0),
(4210100, 'MAFRA', 0),
(4210209, 'MAJOR GERCINO', 0),
(4210407, 'MARACAJÁ', 0),
(4210555, 'MAREMA', 0),
(4210605, 'MASSARANDUBA', 0),
(4210803, 'MELEIRO', 0),
(4211108, 'MONTE CASTELO', 0),
(4211207, 'MORRO DA FUMAÇA', 0),
(4211256, 'MORRO GRANDE', 0),
(4211306, 'NAVEGANTES', 0),
(4211405, 'NOVA ERECHIM', 0),
(4211454, 'NOVA ITABERABA', 0),
(4211504, 'NOVA TRENTO', 0),
(4211603, 'NOVA VENEZA', 0),
(4211702, 'ORLEANS', 0),
(4211751, 'OTACÍLIO COSTA', 0),
(4211876, 'PAIAL', 0),
(4211892, 'PAINEL', 0),
(4211900, 'PALHOÇA', 0),
(4212056, 'PALMEIRA', 0),
(4212106, 'PALMITOS', 0),
(4212205, 'PAPANDUVA', 0),
(4212254, 'PASSO DE TORRES', 0),
(4212304, 'PAULO LOPES', 0),
(4212403, 'PEDRAS GRANDES', 0),
(4212502, 'PENHA', 0),
(4212809, 'PIÇARRAS', 0),
(4212908, 'PINHALZINHO', 0),
(4213153, 'PLANALTO ALEGRE', 0),
(4213203, 'POMERODE', 0),
(4213302, 'PONTE ALTA', 0),
(4213351, 'PONTE ALTA DO NORTE', 0),
(4213500, 'PORTO BELO', 0),
(4213807, 'PRAIA GRANDE', 0),
(4214201, 'QUILOMBO', 0),
(4214300, 'RANCHO QUEIMADO', 0),
(4214706, 'RIO DOS CEDROS', 0),
(4214904, 'RIO FORTUNA', 0),
(4215000, 'RIO NEGRINHO', 0),
(4215059, 'RIO RUFINO', 0),
(4215109, 'RODEIO', 0),
(4215455, 'SANGÃO', 0),
(4215505, 'SANTA CECÍLIA', 0),
(4215604, 'SANTA ROSA DE LIMA', 0),
(4215653, 'SANTA ROSA DO SUL', 0),
(4215703, 'SANTO AMARO DA IMPERATRIZ', 0),
(4215802, 'SÃO BENTO DO SUL', 0),
(4215901, 'SÃO BONIFÁCIO', 0),
(4216008, 'SÃO CARLOS', 0),
(4216057, 'SÃO CRISTOVÃO DO SUL', 0),
(4216206, 'SÃO FRANCISCO DO SUL', 0),
(4216305, 'SÃO JOÃO BATISTA', 0),
(4216354, 'SÃO JOÃO DO ITAPERIÚ', 0),
(4216404, 'SÃO JOÃO DO SUL', 0),
(4216503, 'SÃO JOAQUIM', 0),
(4216602, 'SÃO JOSÉ', 0),
(4216800, 'SÃO JOSÉ DO CERRITO', 0),
(4217006, 'SÃO LUDGERO', 0),
(4217105, 'SÃO MARTINHO', 0),
(4217253, 'SÃO PEDRO DE ALCÂNTARA', 0),
(4217303, 'SAUDADES', 0),
(4217402, 'SCHROEDER', 0),
(4217501, 'SEARA', 0),
(4217600, 'SIDERÓPOLIS', 0),
(4217709, 'SOMBRIO', 0),
(4218004, 'TIJUCAS', 0),
(4218103, 'TIMBÉ DO SUL', 0),
(4218202, 'TIMBÓ', 0),
(4218350, 'TREVISO', 0),
(4218400, 'TREZE DE MAIO', 0),
(4218707, 'TUBARÃO', 0),
(4218806, 'TURVO', 0),
(4218855, 'UNIÃO DO OESTE', 0),
(4218905, 'URUBICI', 0),
(4218954, 'URUPEMA', 0),
(4219002, 'URUSSANGA', 0),
(4219507, 'XANXERÊ', 0),
(4219606, 'XAVANTINA', 0),
(4219705, 'XAXIM', 0),
(4300604, 'ALVORADA', 0),
(4300877, 'ARARICÁ', 0),
(4301057, 'ARROIO DO SAL', 0),
(4301073, 'ARROIO DO PADRE', 0),
(4301107, 'ARROIO DOS RATOS', 0),
(4301636, 'BALNEÁRIO PINHAL', 0),
(4302105, 'BENTO GONÇALVES', 0),
(4303103, 'CACHOEIRINHA', 0),
(4303905, 'CAMPO BOM', 0),
(4304606, 'CANOAS', 0),
(4304630, 'CAPÃO DA CANOA', 0),
(4304663, 'CAPÃO DO LEÃO', 0),
(4304671, 'CAPIVARI DO SUL', 0),
(4304689, 'CAPELA DE SANTANA', 0),
(4304713, 'CARAÁ', 0),
(4304804, 'CARLOS BARBOSA', 0),
(4305108, 'CAXIAS DO SUL', 0),
(4305355, 'CHARQUEADAS', 0),
(4305454, 'CIDREIRA', 0),
(4306403, 'DOIS IRMÃOS', 0),
(4306551, 'DOM PEDRO DE ALCÂNTARA', 0),
(4306767, 'ELDORADO DO SUL', 0),
(4307609, 'ESTÂNCIA VELHA', 0),
(4307708, 'ESTEIO', 0),
(4307906, 'FARROUPILHA', 0),
(4308201, 'FLORES DA CUNHA', 0),
(4308607, 'GARIBALDI', 0),
(4309050, 'GLORINHA', 0),
(4309209, 'GRAVATAÍ', 0),
(4309308, 'GUAÍBA', 0),
(4310330, 'IMBÉ', 0),
(4310652, 'ITATI', 0),
(4310801, 'IVOTI', 0),
(4311734, 'MAMPITUBA', 0),
(4311775, 'MAQUINÉ', 0),
(4312385, 'MONTE BELO DO SUL', 0),
(4312401, 'MONTENEGRO', 0),
(4312443, 'MORRINHOS DO SUL', 0),
(4313060, 'NOVA HARTZ', 0),
(4313086, 'NOVA PÁDUA', 0),
(4313375, 'NOVA SANTA RITA', 0),
(4313409, 'NOVO HAMBURGO', 0),
(4313508, 'OSÓRIO', 0),
(4313656, 'PALMARES DO SUL', 0),
(4314050, 'PAROBÉ', 0),
(4314407, 'PELOTAS', 0),
(4314803, 'PORTÃO', 0),
(4314902, 'PORTO ALEGRE', 0),
(4315602, 'RIO GRANDE', 0),
(4317251, 'SANTA TEREZA', 0),
(4317608, 'SANTO ANTÔNIO DA PATRULHA', 0),
(4318408, 'SÃO JERÔNIMO', 0),
(4318507, 'SÃO JOSÉ DO NORTE', 0),
(4318705, 'SÃO LEOPOLDO', 0),
(4319000, 'SÃO MARCOS', 0),
(4319901, 'SAPIRANGA', 0),
(4320008, 'SAPUCAIA DO SUL', 0),
(4321204, 'TAQUARA', 0),
(4321436, 'TERRA DE AREIA', 0),
(4321501, 'TORRES', 0),
(4321600, 'TRAMANDAÍ', 0),
(4321667, 'TRÊS CACHOEIRAS', 0),
(4321832, 'TRÊS FORQUILHAS', 0),
(4322004, 'TRIUNFO', 0),
(4323002, 'VIAMÃO', 0),
(4323804, 'XANGRI-LÁ', 0),
(5100102, 'ACORIZAL', 0),
(5101605, 'BARÃO DO MELGAÇO', 0),
(5103007, 'CHAPADA DOS GUIMARÃES', 0),
(5103403, 'CUIABÁ', 0),
(5104906, 'JANGADA', 0),
(5105903, 'NOBRES', 0),
(5106109, 'NOSSA SENHORA DO LIVRAMENTO', 0),
(5106208, 'NOVA BRASILÂNDIA', 0),
(5106455, 'PLANALTO DA SERRA', 0),
(5106505, 'POCONÉ', 0),
(5107701, 'ROSÁRIO OESTE', 0),
(5107800, 'SANTO ANTÔNIO DO LEVERGER', 0),
(5108402, 'VÁRZEA GRANDE', 0),
(5200050, 'Abadia De Goias', 0),
(5200100, 'Abadiania', 0),
(5200111, 'Cachoeira, Orizona', 4),
(5200112, 'Caraiba', 0),
(5200134, 'Acreuna', 1),
(5200175, 'Agua Fria De Goias', 0),
(5200209, 'Agua Limpa', 6),
(5200258, 'Aguas Lindas De Goias', 0),
(5200308, 'Alexania', 0),
(5200902, 'Amorinopolis', 0),
(5201405, 'Aparecida De Goiania', 2),
(5201801, 'Aragoiania', 0),
(5202155, 'Araguapaz', 0),
(5203302, 'Bela Vista De Goias', 3),
(5203500, 'Bom Jesus de Goias', 6),
(5203559, 'Bonfinopolis', 0),
(5203609, 'BRAZABRANTES', 0),
(5203906, 'Buriti Alegre', 6),
(5204003, 'CABECEIRAS', 0),
(5204102, 'Cachoeira Alta', 6),
(5204409, 'Caiaponia', 0),
(5204508, 'Caldas Novas', 0),
(5204557, 'CALDAZINHA', 0),
(5205208, 'Caturai', 0),
(5205455, 'Cezarina', 1),
(5205497, 'CIDADE OCIDENTAL', 0),
(5205513, 'Cocalzinho De Goias', 0),
(5205802, 'Corumba De Goias', 0),
(5205901, 'Corumbaiba', 0),
(5206206, 'CRISTALINA', 0),
(5206305, 'Cristianopolis', 4),
(5207105, 'Diorama', 0),
(5207253, 'Doverlandia', 0),
(5207535, 'Faina', 0),
(5207600, 'Fazenda Nova', 0),
(5208004, 'FORMOSA', 0),
(5208400, 'Goianapolis', 0),
(5208707, 'GOIANIA', 2),
(5208806, 'GOIANIRA', 0),
(5208905, 'Goias', 0),
(5209101, 'Goiatuba', 6),
(5209200, 'Guapo', 1),
(5209705, 'Hidrolandia', 2),
(5209952, 'Indiara', 1),
(5210000, 'INHUMAS', 0),
(5210208, 'Ipora', 0),
(5210307, 'Israelandia', 0),
(5210562, 'Itaguari', 0),
(5210604, 'Itaguaru', 0),
(5211008, 'Itapirapua', 0),
(5211206, 'Itapuranga', 0),
(5211701, 'Jandaia', 0),
(5212006, 'Jaupaci', 0),
(5212204, 'Jussara', 0),
(5212501, 'Luziania', 0),
(5213053, 'Mimoso De Goias', 0),
(5213103, 'Mineiros', 0),
(5213756, 'Montividiu', 5),
(5213806, 'Morrinhos', 6),
(5214002, 'Mozarlandia', 0),
(5214507, 'Neropolis', 0),
(5214838, 'Nova CrixÃ¡s', 0),
(5215009, 'NOVA VENEZA', 0),
(5215231, 'NOVO GAMA', 0),
(5215306, 'Orizona', 4),
(5215603, 'PADRE BERNARDO', 0),
(5215652, 'Palestina de Goias', 0),
(5215702, 'PALMEIRAS DE GOIAS', 1),
(5215801, 'Palmelo', 4),
(5216304, 'Paranaiguara', 6),
(5216403, 'PARAUNA', 5),
(5217302, 'Pirenopolis', 0),
(5217401, 'Pires do Rio', 4),
(5217609, 'PLANALTINA', 0),
(5218391, 'Professor Jamil', 6),
(5218508, 'Quirinopolis', 6),
(5218805, 'Rio Verde', 5),
(5219308, 'Santa Helena de Goias', 5),
(5219712, 'Santo Antonio da Barra', 5),
(5219738, 'Santo Antonio De Goias', 0),
(5219753, 'Santo Antonio Do Descoberto', 0),
(5220108, 'Sao Luis de Montes Belos', 0),
(5220264, 'Sao Miguel Do Passa Quatro', 4),
(5220405, 'SAO SIMAO', 6),
(5220454, 'SENADOR CANEDO', 0),
(5220603, 'Silvania', 0),
(5221007, 'Taquaral de Goias', 0),
(5221197, 'Terezopolis De Goias', 0),
(5221403, 'TRINDADE', 0),
(5221700, 'Uruana', 0),
(5221858, 'Valparaiso De Goias', 0),
(5221908, 'Varjao', 5),
(5222005, 'Vianopolis', 4),
(5222203, 'VILA BOA', 0),
(5222204, 'Posselandia - BR-060, Guapo', 1),
(5222205, 'Montes Claros', 4),
(5222206, 'Sao Benedito, Varjao', 5),
(5222207, 'Uruita, Uruana', 0),
(5222208, 'Linda Vista', 0),
(5222209, 'Itaguacu, Sao Simao', 0),
(5222210, 'Rosalandia', 0),
(5222211, 'Piloandia', 0),
(5222212, 'Goiapora', 0),
(5222213, 'Ponte de Pedra', 0),
(5222214, 'Capivari', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `nfavulsas`
--

CREATE TABLE IF NOT EXISTS `nfavulsas` (
  `id` int(11) NOT NULL,
  `valor` varchar(11) NOT NULL,
  `data` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nfe`
--

CREATE TABLE IF NOT EXISTS `nfe` (
`id` int(9) NOT NULL,
  `numero` int(9) NOT NULL DEFAULT '0',
  `cUf` varchar(2) NOT NULL,
  `natOp` varchar(60) NOT NULL,
  `indPag` varchar(1) NOT NULL,
  `modelo` varchar(2) NOT NULL,
  `serie` varchar(3) NOT NULL,
  `dEmi` varchar(10) NOT NULL,
  `dSaiEnt` varchar(10) NOT NULL,
  `hSaiEnt` varchar(10) NOT NULL DEFAULT '00:00:00',
  `tpNF` int(1) NOT NULL DEFAULT '0',
  `cMunFG` varchar(7) NOT NULL,
  `tpImp` int(1) NOT NULL DEFAULT '1',
  `tpEmis` int(1) NOT NULL DEFAULT '1',
  `chave` varchar(50) NOT NULL,
  `cDV` varchar(1) NOT NULL,
  `tpAmb` int(1) NOT NULL DEFAULT '2',
  `finNFe` int(1) NOT NULL DEFAULT '1',
  `procEmi` int(1) NOT NULL DEFAULT '0',
  `destinatario` int(11) NOT NULL,
  `contribuinteComplementares` longtext NOT NULL,
  `fiscoComplementares` longtext NOT NULL,
  `veiculo` int(11) NOT NULL DEFAULT '0',
  `frete` int(1) NOT NULL DEFAULT '9',
  `opTransportador` int(1) NOT NULL DEFAULT '0',
  `transxNome` varchar(222) NOT NULL,
  `transAntt` varchar(222) NOT NULL,
  `transPlaca` varchar(8) NOT NULL,
  `transPlacaUf` varchar(4) NOT NULL,
  `transCnpj` varchar(22) NOT NULL,
  `transEndereco` varchar(300) NOT NULL,
  `transMun` varchar(222) NOT NULL,
  `transUf` varchar(4) NOT NULL,
  `transIE` varchar(15) NOT NULL,
  `cancelada` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nfeentrada`
--

CREATE TABLE IF NOT EXISTS `nfeentrada` (
`id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `serie` int(11) NOT NULL DEFAULT '1',
  `remetente` int(11) NOT NULL,
  `chave` varchar(44) NOT NULL,
  `emissao` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `paises`
--

INSERT INTO `paises` (`codigo`, `nome`) VALUES
(132, 'AFEGANISTAO'),
(175, 'ALBANIA, REPUBLICA  DA'),
(230, 'ALEMANHA'),
(370, 'ANDORRA'),
(400, 'ANGOLA'),
(477, 'ANTILHAS HOLANDESAS'),
(531, 'ARABIA SAUDITA'),
(590, 'ARGELIA'),
(639, 'ARGENTINA'),
(647, 'ARMENIA, REPUBLICA DA'),
(655, 'ARUBA'),
(698, 'AUSTRALIA'),
(728, 'AUSTRIA'),
(736, 'AZERBAIJAO, REPUBLICA '),
(779, 'BAHAMAS, ILHAS'),
(809, 'BAHREIN, ILHAS'),
(817, 'BANGLADESH'),
(833, 'BARBADOS'),
(850, 'BELARUS, REPUBLICA DA'),
(876, 'BELGICA'),
(884, 'BELIZE'),
(906, 'BERMUDAS'),
(930, 'MIANMAR (BIRMANIA)'),
(973, 'BOLIVIA, ESTADO PLURIN'),
(981, 'BOSNIA-HERZEGOVINA (RE'),
(1015, 'BOTSUANA'),
(1058, 'BRASIL'),
(1082, 'BRUNEI'),
(1112, 'BULGARIA, REPUBLICA DA'),
(1155, 'BURUNDI'),
(1198, 'BUTAO'),
(1279, 'CABO VERDE, REPUBLICA '),
(1376, 'CAYMAN, ILHAS'),
(1414, 'CAMBOJA'),
(1490, 'CANADA'),
(1538, 'CAZAQUISTAO, REPUBLICA'),
(1546, 'CATAR'),
(1589, 'CHILE'),
(1600, 'CHINA, REPUBLICA POPUL'),
(1619, 'FORMOSA (TAIWAN)'),
(1635, 'CHIPRE'),
(1694, 'COLOMBIA'),
(1732, 'COMORES, ILHAS'),
(1872, 'COREIA (DO NORTE), REP'),
(1902, 'COREIA (DO SUL), REPUB'),
(1937, 'COSTA DO MARFIM'),
(1953, 'CROACIA (REPUBLICA DA)'),
(1961, 'COSTA RICA'),
(1988, 'COVEITE'),
(1996, 'CUBA'),
(2321, 'DINAMARCA'),
(2399, 'EQUADOR'),
(2402, 'EGITO'),
(2437, 'ERITREIA'),
(2445, 'EMIRADOS ARABES UNIDOS'),
(2453, 'ESPANHA'),
(2461, 'ESLOVENIA, REPUBLICA D'),
(2470, 'ESLOVACA, REPUBLICA'),
(2496, 'ESTADOS UNIDOS'),
(2518, 'ESTONIA, REPUBLICA DA'),
(2534, 'ETIOPIA'),
(2550, 'FALKLAND (ILHAS MALVIN'),
(2674, 'FILIPINAS'),
(2712, 'FINLANDIA'),
(2755, 'FRANCA'),
(2852, 'GAMBIA'),
(2895, 'GANA'),
(2917, 'GEORGIA, REPUBLICA DA'),
(2933, 'GIBRALTAR'),
(3018, 'GRECIA'),
(3174, 'GUATEMALA'),
(3298, 'GUINE'),
(3344, 'GUINE-BISSAU'),
(3379, 'GUIANA'),
(3417, 'HAITI'),
(3450, 'HONDURAS'),
(3514, 'HONG KONG'),
(3557, 'HUNGRIA, REPUBLICA DA'),
(3573, 'IEMEN'),
(3611, 'INDIA'),
(3654, 'INDONESIA'),
(3697, 'IRAQUE'),
(3727, 'IRA, REPUBLICA ISLAMIC'),
(3751, 'IRLANDA'),
(3794, 'ISLANDIA'),
(3832, 'ISRAEL'),
(3867, 'ITALIA'),
(3913, 'JAMAICA'),
(3999, 'JAPAO'),
(4030, 'JORDANIA'),
(4200, 'LAOS, REP.POP.DEMOCR.D'),
(4260, 'LESOTO'),
(4278, 'LETONIA, REPUBLICA DA'),
(4316, 'LIBANO'),
(4340, 'LIBERIA'),
(4383, 'LIBIA'),
(4421, 'LITUANIA, REPUBLICA DA'),
(4456, 'LUXEMBURGO'),
(4472, 'MACAU'),
(4499, 'MACEDONIA, ANT.REP.IUG'),
(4502, 'MADAGASCAR'),
(4553, 'MALASIA'),
(4588, 'MALAVI'),
(4618, 'MALDIVAS'),
(4677, 'MALTA'),
(4740, 'MARROCOS'),
(4855, 'MAURICIO'),
(4880, 'MAURITANIA'),
(4936, 'MEXICO'),
(4944, 'MOLDAVIA, REPUBLICA DA'),
(4979, 'MONGOLIA'),
(5053, 'MOCAMBIQUE'),
(5070, 'NAMIBIA'),
(5177, 'NEPAL'),
(5215, 'NICARAGUA'),
(5282, 'NIGERIA'),
(5380, 'NORUEGA'),
(5452, 'PAPUA NOVA GUINE'),
(5487, 'NOVA ZELANDIA'),
(5517, 'VANUATU'),
(5568, 'OMA'),
(5738, 'PAISES BAIXOS (HOLANDA'),
(5762, 'PAQUISTAO'),
(5800, 'PANAMA'),
(5860, 'PARAGUAI'),
(5894, 'PERU'),
(5991, 'POLINESIA FRANCESA'),
(6033, 'POLONIA, REPUBLICA DA'),
(6076, 'PORTUGAL'),
(6238, 'QUENIA'),
(6254, 'QUIRGUIZ, REPUBLICA'),
(6289, 'REINO UNIDO'),
(6475, 'REPUBLICA DOMINICANA'),
(6653, 'ZIMBABUE'),
(6700, 'ROMENIA'),
(6750, 'RUANDA'),
(6769, 'RUSSIA, FEDERACAO DA'),
(6777, 'SALOMAO, ILHAS'),
(6874, 'EL SALVADOR'),
(6904, 'SAMOA'),
(7102, 'SANTA HELENA'),
(7200, 'SAO TOME E PRINCIPE, I'),
(7315, 'SEYCHELLES'),
(7358, 'SERRA LEOA'),
(7370, 'SERVIA'),
(7412, 'CINGAPURA'),
(7447, 'SIRIA, REPUBLICA ARABE'),
(7480, 'SOMALIA'),
(7501, 'SRI LANKA'),
(7544, 'SUAZILANDIA'),
(7560, 'AFRICA DO SUL'),
(7595, 'SUDAO'),
(7641, 'SUECIA'),
(7676, 'SUICA'),
(7706, 'SURINAME'),
(7722, 'TADJIQUISTAO, REPUBLIC'),
(7765, 'TAILANDIA'),
(7803, 'TANZANIA, REP.UNIDA DA'),
(7838, 'DJIBUTI'),
(7919, 'TCHECA, REPUBLICA'),
(7951, 'TIMOR LESTE'),
(8109, 'TONGA'),
(8150, 'TRINIDAD E TOBAGO'),
(8206, 'TUNISIA'),
(8249, 'TURCOMENISTAO, REPUBLI'),
(8273, 'TURQUIA'),
(8311, 'UCRANIA'),
(8338, 'UGANDA'),
(8451, 'URUGUAI'),
(8478, 'UZBEQUISTAO, REPUBLICA'),
(8508, 'VENEZUELA'),
(8583, 'VIETNA'),
(8702, 'FIJI'),
(8885, 'CONGO, REPUBLICA DEMOC'),
(8907, 'ZAMBIA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidocompra`
--

CREATE TABLE IF NOT EXISTS `pedidocompra` (
`id` int(11) NOT NULL,
  `compra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
`id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `bloco` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `data` varchar(10) NOT NULL,
  `vencimento` varchar(10) NOT NULL DEFAULT '0',
  `pagamento` int(1) NOT NULL DEFAULT '0',
  `pago` int(1) NOT NULL DEFAULT '0',
  `chqs` varchar(222) NOT NULL DEFAULT '0',
  `horario` varchar(10) NOT NULL DEFAULT '0',
  `location` varchar(222) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prestacoes`
--

CREATE TABLE IF NOT EXISTS `prestacoes` (
`id` int(11) NOT NULL,
  `descricao` mediumtext NOT NULL,
  `valor` varchar(15) NOT NULL,
  `parcelas` int(3) NOT NULL,
  `vencimento` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
`id` int(11) NOT NULL,
  `nome` varchar(36) DEFAULT NULL,
  `quantidade` int(1) DEFAULT NULL,
  `peso` varchar(10) NOT NULL DEFAULT '0',
  `compra` varchar(6) NOT NULL DEFAULT '1',
  `venda` varchar(6) NOT NULL DEFAULT '1',
  `lucro` varchar(5) NOT NULL DEFAULT '1',
  `distribuidor` int(2) DEFAULT NULL,
  `estoque` int(1) DEFAULT '1',
  `unidade` varchar(10) NOT NULL DEFAULT 'cx'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtosbalanco`
--

CREATE TABLE IF NOT EXISTS `produtosbalanco` (
`id` int(11) NOT NULL,
  `balanco` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `carga` varchar(11) NOT NULL,
  `retorno` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtosblocos`
--

CREATE TABLE IF NOT EXISTS `produtosblocos` (
`id` int(11) NOT NULL,
  `pedido` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `quantidade` varchar(11) NOT NULL DEFAULT '1',
  `valor` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtosnfe`
--

CREATE TABLE IF NOT EXISTS `produtosnfe` (
`id` int(11) NOT NULL,
  `NFe` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `CFOP` int(5) NOT NULL,
  `qCom` varchar(15) NOT NULL,
  `vUnCom` varchar(21) NOT NULL,
  `vProd` varchar(15) NOT NULL,
  `orig` int(1) NOT NULL DEFAULT '0',
  `CST` varchar(4) NOT NULL DEFAULT '41',
  `modBC` int(2) NOT NULL,
  `vBC` varchar(15) NOT NULL,
  `pICMS` varchar(5) NOT NULL,
  `vICMS` varchar(15) NOT NULL,
  `indTot` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtospedidos`
--

CREATE TABLE IF NOT EXISTS `produtospedidos` (
`id` int(11) NOT NULL,
  `pedido` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `valor` varchar(11) NOT NULL DEFAULT '0',
  `quantidade` varchar(11) NOT NULL DEFAULT '0',
  `data` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recebeupedido`
--

CREATE TABLE IF NOT EXISTS `recebeupedido` (
`id` int(11) NOT NULL,
  `pedido` int(11) NOT NULL,
  `data` varchar(10) NOT NULL,
  `valor` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reducoes`
--

CREATE TABLE IF NOT EXISTS `reducoes` (
  `id` int(11) NOT NULL,
  `contador` int(11) NOT NULL,
  `valor` varchar(11) NOT NULL,
  `data` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotas`
--

CREATE TABLE IF NOT EXISTS `rotas` (
`id` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `descricao` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saldos`
--

CREATE TABLE IF NOT EXISTS `saldos` (
  `data` varchar(7) NOT NULL,
  `saldo` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vales`
--

CREATE TABLE IF NOT EXISTS `vales` (
`id` int(11) NOT NULL,
  `funcionario` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `valor` varchar(22) NOT NULL,
  `data` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculos`
--

CREATE TABLE IF NOT EXISTS `veiculos` (
`id` int(11) NOT NULL,
  `motorista` int(11) NOT NULL,
  `descricao` varchar(222) NOT NULL,
  `placa` varchar(8) NOT NULL,
  `uf` varchar(4) NOT NULL,
  `renavam` varchar(10) NOT NULL,
  `chassi` varchar(22) NOT NULL,
  `fabricacao` varchar(4) NOT NULL,
  `modelo` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vencimentos`
--

CREATE TABLE IF NOT EXISTS `vencimentos` (
`id` int(11) NOT NULL,
  `cedente` varchar(222) NOT NULL,
  `valor` varchar(15) NOT NULL,
  `vencimento` varchar(10) NOT NULL,
  `pago` int(1) NOT NULL DEFAULT '0',
  `fornecedor` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE IF NOT EXISTS `vendas` (
`id` int(11) NOT NULL,
  `vendedor` varchar(200) NOT NULL,
  `dinheiro` varchar(22) NOT NULL DEFAULT '0',
  `deposito` varchar(22) NOT NULL DEFAULT '0',
  `boleto` varchar(22) NOT NULL DEFAULT '0',
  `cheque` varchar(22) NOT NULL DEFAULT '0',
  `combustivel` varchar(22) NOT NULL DEFAULT '0',
  `hotel` varchar(22) NOT NULL DEFAULT '0',
  `mecanico` varchar(22) NOT NULL DEFAULT '0',
  `outros` varchar(22) NOT NULL DEFAULT '0',
  `total` varchar(22) NOT NULL,
  `data` varchar(10) NOT NULL,
  `balanco` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balancos`
--
ALTER TABLE `balancos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bancos`
--
ALTER TABLE `bancos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bandeiras`
--
ALTER TABLE `bandeiras`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocos`
--
ALTER TABLE `blocos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boletos`
--
ALTER TABLE `boletos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartao`
--
ALTER TABLE `cartao`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheques`
--
ALTER TABLE `cheques`
 ADD PRIMARY KEY (`numero`);

--
-- Indexes for table `chqclientes`
--
ALTER TABLE `chqclientes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config_boletos_bb`
--
ALTER TABLE `config_boletos_bb`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config_empresa`
--
ALTER TABLE `config_empresa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config_nfe`
--
ALTER TABLE `config_nfe`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crt`
--
ALTER TABLE `crt`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `despesas`
--
ALTER TABLE `despesas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinatarios`
--
ALTER TABLE `destinatarios`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `produto` (`produto`);

--
-- Indexes for table `extratos`
--
ALTER TABLE `extratos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fiados`
--
ALTER TABLE `fiados`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financiamentos`
--
ALTER TABLE `financiamentos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecedores`
--
ALTER TABLE `fornecedores`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcoes`
--
ALTER TABLE `funcoes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `localizacao`
--
ALTER TABLE `localizacao`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meses`
--
ALTER TABLE `meses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipios`
--
ALTER TABLE `municipios`
 ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `nfavulsas`
--
ALTER TABLE `nfavulsas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nfe`
--
ALTER TABLE `nfe`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nfeentrada`
--
ALTER TABLE `nfeentrada`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paises`
--
ALTER TABLE `paises`
 ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `pedidocompra`
--
ALTER TABLE `pedidocompra`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestacoes`
--
ALTER TABLE `prestacoes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtosbalanco`
--
ALTER TABLE `produtosbalanco`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtosblocos`
--
ALTER TABLE `produtosblocos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtosnfe`
--
ALTER TABLE `produtosnfe`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtospedidos`
--
ALTER TABLE `produtospedidos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recebeupedido`
--
ALTER TABLE `recebeupedido`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reducoes`
--
ALTER TABLE `reducoes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rotas`
--
ALTER TABLE `rotas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldos`
--
ALTER TABLE `saldos`
 ADD PRIMARY KEY (`data`);

--
-- Indexes for table `vales`
--
ALTER TABLE `vales`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `veiculos`
--
ALTER TABLE `veiculos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vencimentos`
--
ALTER TABLE `vencimentos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balancos`
--
ALTER TABLE `balancos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bancos`
--
ALTER TABLE `bancos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bandeiras`
--
ALTER TABLE `bandeiras`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `blocos`
--
ALTER TABLE `blocos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `boletos`
--
ALTER TABLE `boletos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cartao`
--
ALTER TABLE `cartao`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chqclientes`
--
ALTER TABLE `chqclientes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crt`
--
ALTER TABLE `crt`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `despesas`
--
ALTER TABLE `despesas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `destinatarios`
--
ALTER TABLE `destinatarios`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estoque`
--
ALTER TABLE `estoque`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `extratos`
--
ALTER TABLE `extratos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fiados`
--
ALTER TABLE `fiados`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `financiamentos`
--
ALTER TABLE `financiamentos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `funcoes`
--
ALTER TABLE `funcoes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `localizacao`
--
ALTER TABLE `localizacao`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `meses`
--
ALTER TABLE `meses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `municipios`
--
ALTER TABLE `municipios`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5222215;
--
-- AUTO_INCREMENT for table `nfe`
--
ALTER TABLE `nfe`
MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nfeentrada`
--
ALTER TABLE `nfeentrada`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pedidocompra`
--
ALTER TABLE `pedidocompra`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prestacoes`
--
ALTER TABLE `prestacoes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produtosbalanco`
--
ALTER TABLE `produtosbalanco`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produtosblocos`
--
ALTER TABLE `produtosblocos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produtosnfe`
--
ALTER TABLE `produtosnfe`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produtospedidos`
--
ALTER TABLE `produtospedidos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `recebeupedido`
--
ALTER TABLE `recebeupedido`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rotas`
--
ALTER TABLE `rotas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vales`
--
ALTER TABLE `vales`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `veiculos`
--
ALTER TABLE `veiculos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vencimentos`
--
ALTER TABLE `vencimentos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
