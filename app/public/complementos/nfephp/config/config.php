<?php
/**
 * Parвmetros de configuraзгo do sistema
 * Ъltima alteraзгo em 12-01-2014 19:40:33 
 **/

//###############################
//########## GERAL ##############
//###############################
// tipo de ambiente esta informaзгo deve ser editada pelo sistema
// 1-Produзгo 2-Homologaзгo
// esta variбvel serб utilizada para direcionar os arquivos e
// estabelecer o contato com o SEFAZ
$ambiente=2;
//esta variбvel contкm o nome do arquivo com todas as url dos webservices do sefaz
//incluindo a versao dos mesmos, pois alguns estados nгo estгo utilizando as
//mesmas versхes
$arquivoURLxml="nfe_ws2.xml";
$arquivoURLxmlCTe="cte_ws1.xml";
//Diretуrio onde serгo mantidos os arquivos com as NFe em xml
//a partir deste diretуrio serгo montados todos os subdiretуrios do sistema
//de manipulaзгo e armazenamento das NFe e CTe
$arquivosDir="app/public/complementos/nfephp/nfe";
$arquivosDirCTe="app/public/complementos/nfephp/cte";
//URL base da API, passa a ser necessбria em virtude do uso dos arquivos wsdl
//para acesso ao ambiente nacional
$baseurl="http://www.inovaminas.com.br/nfe/app/public/complementos/nfephp";
//Versгo em uso dos shemas utilizados para validaзгo dos xmls
$schemes="PL_006r";
$schemesCTe="PL_CTE_104";

//###############################
//###### EMPRESA EMITENTE #######
//###############################
//Nome da Empresa
$empresa="FAZAO";
//Sigla da UF
$UF="MG";
//Cуdigo da UF
$cUF="00";
//Nъmero do CNPJ
$cnpj="0000000000";

//###############################
//#### CERITIFICADO DIGITAL #####
//###############################
//Nome do certificado que deve ser colocado na pasta certs da API
$certName="www_inovaminas_com_br.crt";
//Senha da chave privada
$keyPass="";
//Senha de decriptaзao da chave, normalmente nгo й necessaria
$passPhrase="";

//###############################
//############ DANFE ############
//###############################
//Configuraзгo do DANFE
$danfeFormato="P"; //P-Retrato L-Paisagem 
$danfePapel="A4"; //Tipo de papel utilizado 
$danfeCanhoto=1; //se verdadeiro imprime o canhoto na DANFE 
$danfeLogo="/home/inovamin/public_html/nfe/app/public/complementos/nfephp/images/logo.jpg"; //passa o caminho para o LOGO da empresa 
$danfeLogoPos="L"; //define a posiзгo do logo na Danfe L-esquerda, C-dentro e R-direta 
$danfeFonte="Helvetica"; //define a fonte do Danfe limitada as fontes compiladas no FPDF (Times) 
$danfePrinter="hpteste"; //define a impressora para impressгo da Danfe 

//###############################
//############ DACTE ############
//###############################
//Configuraзгo do DACTE
$dacteFormato="P"; //P-Retrato L-Paisagem 
$dactePapel="A4"; //Tipo de papel utilizado 
$dacteCanhoto=1; //se verdadeiro imprime o canhoto na DANFE 
$dacteLogo="/home/inovamin/public_html/nfe/app/public/complementos/nfephp/images/logo.jpg"; //passa o caminho para o LOGO da empresa 
$dacteLogoPos="L"; //define a posiзгo do logo na Danfe L-esquerda, C-dentro e R-direta 
$dacteFonte="Times"; //define a fonte do Danfe limitada as fontes compiladas no FPDF (Times) 
$dactePrinter="hpteste"; //define a impressora para impressгo da Dacte 

//###############################
//############ EMAIL ############
//###############################
//Configuraзгo do email
$mailAuth="1"; //ativa ou desativa a obrigatoriedade de autenticaзгo no envio de email, na maioria das vezes ativar 
$mailFROM="nfe@mm.com"; //identificaзгo do emitente 
$mailHOST="server5.mm.org"; //endereзo do servidor SMTP 
$mailUSER="nfe@mm.com"; //username para autenticaзгo, usando quando mailAuth й 1
$mailPASS="bb7oexty"; //senha de autenticaзгo do serviзo de email
$mailPROTOCOL="ssl"; //protocolo de email utilizado (classe alternate)
$mailPORT="465"; //porta utilizada pelo smtp (classe alternate)
$mailFROMmail="nfe@mm.com"; //para alteraзгo da identificaзгo do remetente, pode causar problemas com filtros de spam 
$mailFROMname="Way"; //para indicar o nome do remetente 
$mailREPLYTOmail="nfe@mm.com"; //para indicar o email de resposta
$mailREPLYTOname="Way "; //para indicar email de cуpia
$mailIMAPhost="mail.mm.com.br"; //url para o servidor IMAP
$mailIMAPport="143"; //porta do servidor IMAP
$mailIMAPsecurity="tls"; //esquema de seguranзa do servidor IMAP
$mailIMAPnocerts="novalidate-cert"; //desabilita verificaзгo de certificados do Servidor IMAP
$mailIMAPbox="INBOX"; //caixa postal de entrada do servidor IMAP
$mailLayoutFile=""; //layout da mensagem do email

//###############################
//############ PROXY ############
//###############################
//Configuraзгo de Proxy
$proxyIP=""; //ip do servidor proxy, se existir 
$proxyPORT=""; //numero da porta usada pelo proxy 
$proxyUSER=""; //nome do usuбrio, se o proxy exigir autenticaзгo
$proxyPASS=""; //senha de autenticaзгo do proxy 

?>