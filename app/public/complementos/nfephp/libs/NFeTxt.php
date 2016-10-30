<?php


/**
 * Este arquivo é parte do projeto NFePHP - Nota Fiscal eletrônica em PHP.
 *
 * Este programa é um software livre: você pode redistribuir e/ou modificá-lo
 * sob os termos da Licença Pública Geral GNU como é publicada pela Fundação
 * para o Software Livre, na versão 3 da licença, ou qualquer versão posterior.
 *
 * Este programa é distribuído na esperança que será útil, mas SEM NENHUMA
 * GARANTIA; nem mesmo a garantia explícita do VALOR COMERCIAL ou ADEQUAÇÃO PARA
 * UM PROPÓSITO EM PARTICULAR, veja a Licença Pública Geral GNU para mais
 * detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Publica GNU junto com este
 * programa. Caso contrário consulte <http://www.fsfla.org/svnwiki/trad/GPLv3>.
 *
 *
 * Classe que recebe os parâmetros de uma NF e
 * transofrma em um txt padrão para ser usado em software emissor de
 * nfe
 *
 * @package     NFePHP
 * @name        NFeTXT
 * @version     1.0
 * @license     http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright   2010 &copy; NFePHP
 * @link        http://www.nfephp.org/
 * @author Daniel Lemes<dlemes@gmail.com>
 */
class NFeTXT {

	public $dadosA;
	public $dadosNFe;
	public $dadosEmitente;
	public $dadosDestino;
	public $NFeProdutos;
	public $dadosTotais;
	public $NFeFrete;
	public $dadosTransportador;
	public $dadosCobranca;




	private function A(){
		foreach ($this->dadosA as $k => $v) {
			$$k = $v;
		}
		$a =   "NOTAFISCAL|".$quantidade."|\n";
		$a .= "A|".$versao."|".$Id."\n";
		return $a;
	}

	private function B(){
		foreach ($this->dadosNFe as $k => $v) {
			$$k = $v;
		}

		return  "B|{$cUf}|{$cNF}|{$natOp}|{$indPag}|{$modelo}|{$serie}|{$nNF}|{$dEmi}|{$dSaiEnt}|{$hSaiEnt}|{$tpNF}|{$cMunFG}|{$tpImp}|{$tpEmis}|{$cDV}|{$tpAmb}|{$finNFe}|{$procEmi}|2\.0|\n";
	}

	private function C(){
		foreach ($this->dadosEmitente as $k => $v) {
			$$k = $v;
		}
		$c = "";
		$c.= "C|".$xNome."|".$xFant."|".$IE."|".$IEST."|";
		$c.= $IM."|"."0|".$CRT."|\n";


		if (!empty($CNPJ)) {
			$c .= "C02|".$CNPJ."|\n";
		}

		if(!empty($CPF)){
			$c .= "C02a|".$CPF."|\n";
		}


		$c .= "C05|".$xLgr."|".$nro."|".$xCpl."|".$xBairro."|";
		$c .= $cMun."|".$xMun."|".$UF."|".$CEP."|";
		$c .= $cPais."|".$xPais."|".$fone."|\n";


		return $c;
	}
	//Avulsa: Informações do fisco emitente, GRUPO DE USO EXCLUSIVO DO FISCO - *NÃO UTILIZAR*
	private function D(){
		return null;
	}

	private function E(){

		foreach ($this->dadosDestino as $k => $v) {
			$$k = $v;
		}

		$e = "";

		$e .= "E|{$xNome}|{$IE}|0|{$email}|\n";



		if(!empty($CNPJ)){
			$e .= "E02|".$CNPJ."|\n";
		}elseif(!empty($CPF)){

			$e .= "E03|".$CPF."|\n";

		}

		$e .= "E05|{$xLgr}|{$nro}|{$xCpl}|{$xBairro}|{$cMun}|{$xMun}|{$UF}|{$CEP}|{$cPais}|{$xPais}|{$fone}|\n";


		return $e;

	}

	//Local de Retirada - Informar apenas quando for diferente do endereço do remetente.
	private function F(){
		$f = "";

		if(empty($this->dadosRetirada)){
			return "";
		}
		foreach ($this->dadosRetirada as $k => $v){
			$$k = $v;
		}

		$f .= "F|{$CNPJ}|{$xLgr}|{$nro}|{$xCpl}|{$xBairro}|{$cMun}|{$xMun}|{$UF}|\n";


		if(!empty($this->dadosDestino["CNPJ"])){
			$f .= "F02|".$this->dadosDestino["CNPJ"]."|\n";
		}elseif(!empty($this->dadosDestino["CPF"])){

			$f .= "F02a|".$this->dadosDestino["CPF"]."|\n";

		}
		return $f;
	}
	//Local de entrega - Informar apenas quando for diferente do endereço do destinatário.
	function G(){
		$g = "";

		if(empty($this->dadosEntrega)){
			return "";
		}

		foreach ($this->dadosEntrega as $k => $v){
			$$k = $v;
		}

		$g .= "G|{$CNPJ}|{$xLgr}|{$nro}|{$xCpl}|{$xBairro}|{$cMun}|{$xMun}|{$UF}|\n";

		if(!empty($this->dadosDestino["CNPJ"])){
			$g .= "G02|".$this->dadosDestino["CNPJ"]."|\n";
		}elseif(!empty($this->dadosDestino["CPF"])){

			$g .= "G02a|".$this->dadosDestino["CPF"]."|\n";

		}
		return $g;


	}
	//Detalhamento de produtos e serviços - máximo = 990
	//grupo dos produtos, pegando todas as especificações dos produtos.
	function HProdutos(){
		$prod = $this->NFeProdutos;
		$txt = "";
		$txtIPI = "";
		$count = count($prod);
		for($i=1;$i<=$count;$i++){
			//$ii = $i+1;
			$txt .= "H|".$i."|\n";
			// tag principal dos produtos
			foreach ($prod[$i]['produto'] as $k => $v){
				$$k = $v;
			}
			/// Com campos opcionais $txt .= "I|{$cProd}|{$cEAN}|{$xProd}|{$NCM}|{$EXPIPI}|{$genero}|{$CFOP}|{$uCom}|{$qCom}|{$vUnCom}|{$vProd}|{$cEANTrib}|{$uTrib}|{$qTrib}|{$vUnTrib}|{$vFrete}|{$vSeg}|{$vDesc}|\n";
			/// Sem Campos Opcionais						repete as variaveis iguais	 $uTrib  $qTrib  $vUnTrib
			$txt .= "I|{$cProd}||{$xProd}|00|00|{$CFOP}|1|{$qCom}|{$vUnCom}|{$vProd}||1|{$qCom}|{$vUnCom}|0|0|0|0|1|\n";


			//declaração importação
			if(!empty($prod[$i]['importacao'])){
				foreach ($prod[$i]['importacao'] as $k => $v){
					$$k = $v;
				}
				$txt .= "I18|$nDI|$dDI|$xLocDesemb|$UFDesemb|$dDesemb|$cExportador|\n";
			}
			//adições das importações
			if(!empty($prod[$i]['adicao'])){
				foreach ($prod[$i]['adicao'] as $k => $v){
					$$k = $v;
				}
				$txt .= "I25|$nAdicao|$nSeqAdic|$cFabricante|$vDescDI|\n";
			}
			if(!empty($prod[$i]['veiculos'])){
				//veiculos novos
				foreach ($prod[$i]['veiculos'] as $k => $v){
					$$k = $v;
				}
				$txt .= "J|$tpOp|$chassi|$cCor|$xCor|$pot|$CM3|$pesoL|$pesoB|$nSerie|$tpComb|$nMotor|$CMKG|$dist|$RENAVAM|$anoMod|$anoFab|$tpPint|$tpVeic|$espVeic|$vIN|$condVeic|$cMod|\n";
			}
			//medicamentos
			if(!empty($prod[$i]['medicamentos'])){
				foreach ($prod[$i]['medicamentos'] as $k => $v){
					$$k = $v;
				}
				$txt .= "K|$nLote|$qLote|$dFab|$dVal|$vPMC|\n";
			}
			//armamentos
			if(!empty($prod[$i]['armamentos'])){
				foreach ($prod[$i]['armamentos'] as $k => $v){
					$$k = $v;
				}
				$txt .= "L|$tpArma|$nSerie|$nCano|$descr|\n";
			}
			//combustível
			if(!empty($prod[$i]['combustivel'])){
				foreach ($prod[$i]['combustivel'] as $k => $v){
					$$k = $v;
				}
				$txt .= "L01|$cProdANP|$CODIF|$qTemp|$UFCons|\n";

				$txt .= "L105|$QBCProd|$VAliqProd|$VCIDE|\n";

				//@todo CIDE
				//@todo ICMSComb
				//@todo finalizar os combustíveis, impostos dos combustiveis, aplicáveis apenas a TRR
			}

			

			if (!empty($prod[$i]['vTotTrib']) && $prod[$i]['vTotTrib']!=0) {
				$txt .= "M|".$prod[$i]['vTotTrib']."|\n";
			}else{
				$txt .= "M|\n";
			}

			$txt .= "N|\n";

			if(!empty($prod[$i]['CST'])){
				foreach ($prod[$i]['CST'] as $k => $v){
					$$k = $v;
				}
				switch ($CST) {
					case '00': //CST 00 TRIBUTADO INTEGRALMENTE
					$txt .= "N02|$orig|$CST|$modBC|$vBC|$pICMS|$vICMS|\n";
					break;
					case '10': //CST 10 TRIBUTADO E COM COBRANCA DE ICMS POR SUBSTUICAO TRIBUTARIA
					$txt .= "N03|$orig|$CST|$modBC|$vBC|$pICMS|$vICMS|$modBCST|$pMVAST|$pRedBCST|$vBCST|$pICMSST|$vICMSST|\n";
					break;
					case '20': //CST 20 COM REDUCAO DE BASE DE CALCULO
					$txt .= "N04|$orig|$CST|$modBC|$pRedBC|$vBC|$pICMS|$vICMS|\n";
					break;
					case '30': //CST 30 ISENTA OU NAO TRIBUTADO E COM COBRANCA DO ICMS POR ST
					$txt .= "N05|$orig|$CST|$modBCST|$pMVAST|$pRedBCST|$vBCST|$pICMSST|$vICMSST|\n";
					break;
					case '40': //CST 40-ISENTA 41-NAO TRIBUTADO E 50-SUSPENSAO
					$txt .= "N06|$orig|$CST|\n";
					break;
					case '41': //CST 40-ISENTA 41-NAO TRIBUTADO E 50-SUSPENSAO
					$txt .= "N10c|$orig|101|2.38|$CST|\n";
					break;
					case '50': //CST 40-ISENTA 41-NAO TRIBUTADO E 50-SUSPENSAO
					$txt .= "N06|$orig|$CST|\n";
					break;
					case '51': //CST 51 DIFERIMENTO - A EXIGENCIA DO PREECNCHIMENTO DAS INFORMAS DO ICMS DIFERIDO FICA A CRITERIO DE CADA UF
					$txt .= "N07|$orig|$CST|$modBC|$pRedBC|$vBC|$pICMS|$vICMS|\n";
					break;
					case '60': //CST 60 ICMS COBRADO ANTERIORMENTE POR ST
					$txt .= "N08|$orig|$CST|$vBCST|$vICMSST|\n";
					break;
					case '70': //CST 70 - Com redução de base de cálculo e cobrança do ICMS por substituição tributária
					$txt .= "N09|$orig|$CST|$modBC|$pRedBC|$vBC|$pICMS|$vICMS|$modBCST|$pMVAST|$pRedBCST|$vBCST|$pICMSST|$vICMSST|\n";
					break;
					case '90': //CST - 90 Outros
					$txt .= "N10c|$orig|101|$pCredSN|$vCredICMSSN|\n";
					break;
				}

			}
			if(!empty($prod[$i]['IPI'])){
				foreach ($prod[$i]['IPI'] as $k => $v){
					$$k = $v;
				}
				$txt .= "O|$clEnq|$CNPJProd|$cSelo|$qSelo|$cEnq\n";
			}else{
				//$txt .= "O|0|0|0|0|0|\n";

			}
			if(!empty($prod[$i]['IPITrib'])){
				foreach ($prod[$i]['IPITrib'] as $k => $v){
					$$k = $v;
				}

				switch ($CST){
					case '00': //CST 00, 49, 50 e 99
						//O07|CST|VIPI|
					$txtIPI = "O07|$CST|$vIPI";
					break;
					case '49': //CST 00, 49, 50 e 99
						//O07|CST|VIPI|
					$txtIPI = "O07|$CST|$vIPI\n";
					break;
					case '50': //CST 00, 49, 50 e 99
						//O07|CST|VIPI|
					$txtIPI = "O07|$CST|$vIPI\n";
					break;
					case '99': //CST 00, 49, 50 e 99
						//O07|CST|VIPI|
					$txtIPI = "O07|$CST|$vIPI\n";
					break;
					case '01': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '02': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '03': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '04': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '51': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '52': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '53': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '54': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '55': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;
					case '41': //CST 01, 02, 03,04, 51, 52, 53, 54 e 55
						//O08|CST|
					$txtIPI = "O08|$CST\n";
					break;

				}
				if (substr($txtIPI,0,3) == 'O007' ) {
					if ( $pIPI != '' ) {
						//O10|VBC|PIPI|
						$txtIPI .= "O10|$vBC|$pIPI\n";
					} else {
						//O11|QUnid|VUnid|
						$txtIPI .= "O11|$qUnid|$vUnid\n";
					}
				}
				$txt .= $txtIPI;

			}

			if(!empty($prod[$i]['II'])){
				foreach ($prod[$i]['II'] as $k => $v){
					$$k = $v;
				}
				$txt .= "P|$vBC|$vDespAdu|$vII|$vIOF\n";
			}else{
				//$txt .= "P|0|0|0|0|0|\n";
			}
			$txt .= "Q|\n";
			if(!empty($prod[$i]['PIS'])){
				foreach ($prod[$i]['PIS'] as $k => $v){
					$$k = $v;
				}

				if ( $CST == '01' || $CST == '02'){
					//Q02|CST|vBC|pPIS|vPIS| // PIS TRIBUTADO PELA ALIQUOTA
					$txt .= "Q02|$CST|$vBC|$pPIS|$vPIS\n";
				}
				if ( $CST == '03' ) {
					//Q03|CST|qBCProd|vAliqProd|vPIS| //PIS TRIBUTADO POR QTDE
					$txt .= "Q03|$CST|$qBCProd|$vAliqProd|$vPIS\n";
				}
				if ( $CST == '04' || $CST == '06' || $CST == '07' || $CST == '08' || $CST == '09') {
					//Q04|CST| //PIS não tributado
					$txt .= "Q04|$CST\n";
				}
				if ( $CST == '99' ) {
					//Q05|CST|vPIS| //PIS OUTRAS OPERACOES
					$txt .= "Q05|$CST|$vPIS\n";
					//Q07|vBC|pPIS|
					$txt .= "Q07|$vBC|$pPIS\n";
					//Q10|qBCProd|vAliqProd|
					$txt .= "Q10|$qBCProd|$vAliqProd\n";
				}
			}else{
				$txt .= "Q04|04|\n";
			}

			if(!empty($prod[$i]['PISST'])){
				foreach ($prod[$i]['PISST'] as $k => $v){
					$$k = $v;
				}
                //R|vPIS|
				$txt .= "R|$vPIS\n";
                //R02|vBC|pPIS|
				$txt .= "R02|$vBC|$pPIS\n";
                //R04|qBCProd|vAliqProd|
				$txt .= "R04|$qBCProd|$vAliqProd\n";
			}

			if(!empty($prod[$i]['COFINS'])){
				foreach ($prod[$i]['COFINS'] as $k => $v){
					$$k = $v;
				}
				$txt .= "S|\n";
				if ($CST == '01' || $CST == '02' ){
					//S02|CST|VBC|PCOFINS|VCOFINS|
					$txt .= "S02|$CST|$vBC|$pCOFINS|$vCOFINS\n";
				}
				if ( $CST == '03'){
					//S03|CST|QBCProd|VAliqProd|VCOFINS|
					$txt .= "S03|$CST|$qBCProd|$vAliqProd|$vCOFINS\n";
				}
				if ( $CST == '04' || $CST == '06' || $CST == '07' || $CST == '08' || $CST == '09' ){
					//S04|CST|
					$txt .= "S04|$CST\n";
				}
				if ( $CST == '99' ){
					//S05|CST|VCOFINS|
					$txt .= "S05|$CST|$vCOFINS\n";
					//S07|VBC|PCOFINS|
					$txt .= "S07|$vBC|$pCOFINS\n";
					//S09|QBCProd|VAliqProd|
					$txt .= "S09|$qBCProd|$vAliqProd\n";
				}
			}else{
				//S05|CST|VCOFINS|
				$txt .= "S05|$CST|$vCOFINS\n";
					//S07|VBC|PCOFINS|
				$txt .= "S07|$vBC|$pCOFINS\n";
					//S09|QBCProd|VAliqProd|
				$txt .= "S09|$qBCProd|$vAliqProd\n";
			}

			if(!empty($prod[$i]['COFINSST'])){
				foreach ($prod[$i]['COFINSST'] as $k => $v){
					$$k = $v;
				}
				//T|VCOFINS|
				$txt .= "T|$vCOFINS\n";
				//T02|VBC|PCOFINS|
				$txt .= "T02|$vBC|$pCOFINS\n";
				//T04|QBCProd|VAliqProd|
				$txt .= "T04|$qBCProd|$vAliqProd\n";
			}

			if(!empty($prod[$i]['ISSQN'])){
				foreach ($prod[$i]['ISSQN'] as $k => $v){
					$$k = $v;
				}
				$txt .= "U|$vBC|$vAliq|$vISSQN|$cMunFG|$cListServ\n";
			}

		}

		return $txt;
	}

	private function Totais(){
		$txt = "W\n";
		$icms = $this->dadosTotais;
		if(!empty($icms)){
			foreach ($icms as $k => $v){

				$$k = $v;
			}
			if ($vBC==0) {
				$vBC="0";
			}
			if ($vICMS==0) {
				$vICMS="0";
			}
			if ($vBCST==0) {
				$vBCST="0";
			}
			if ($vST==0) {
				$vST="0";
			}
			if ($vProd==0) {
				$vProd="0";
			}
			if ($vFrete==0) {
				$vFrete="0";
			}
			if ($vSeg==0) {
				$vSeg="0";
			}
			if ($vDesc==0) {
				$vDesc="0";
			}
			if ($vII==0) {
				$vII="0";
			}
			if ($vIPI==0) {
				$vIPI="0";
			}
			if ($vPIS==0) {
				$vPIS="0";
			}
			if ($vCOFINS==0) {
				$vCOFINS="0";
			}
			if ($vOutro==0) {
				$vOutro="0";
			}

			$vNF = $vBC+$vICMS+$vBCST+$vST+$vProd+$vFrete+$vSeg+$vDesc+$vII+$vIPI+$vPIS+$vCOFINS+$vOutro;


			//W02|vBC|vICMS|vBCST|vST|vProd|vFrete|vSeg|vDesc|vII|vIPI|vPIS|vCOFINS|vOutro|vNF|
			$txt .= "W02|$vBC|$vICMS|$vBCST|$vST|$vProd|$vFrete|$vSeg|$vDesc|$vII|$vIPI|$vPIS|$vCOFINS|$vOutro|".number_format($vNF,2,".","")."|".$vTotTrib."|\n";

		}
		$retTrib = $this->NFeImposto["retidos"];
		if(!empty($retTrib)){
			foreach ($retTrib as $k => $v){
				$$k = $v;
			}
			//W23|VRetPIS|VRetCOFINS|VRetCSLL|VBCIRRF|VIRRF|VBCRetPrev|VRetPrev|
			$txt .= "W23|$vRetPIS|$vRetCOFINS|$vRetCSLL|$vBCIRRF|$vIRRF|$vBCRetPrev|$vRetPrev\n";
		}
		return $txt;
	}

	private function Transportador(){

		$txt = "X|".$this->NFeFrete."\n";
		$trans = $this->dadosTransportador;
		if(!empty($trans)){
			foreach ($trans['transportador'] as $k => $v){
				$$k = $v;
			}
			$txt .= "X03|$xNome|$IE|$xEnder|$UF|$xMun|\n";
		}

		//$CNPJ = $trans['transportador'];
		if(!empty($CNPJ))
			$txt .= "X04|".$CNPJ."|\n";

		//$CPF=$this->getTranspCPF();
		if(!empty($CPF))
			$txt .= "X05|".$CPF."|\n";

		//$transICMS = $this->getTransportadorICSM();
		if(!empty($transICMS)){
			foreach ($transIMCS as $k => $v){
				$$k = $v;
			}
			//X11|VServ|VBCRet|PICMSRet|VICMSRet|CFOP|CMunFG|
			$txt .= "X11|$vServ|$vBCRet|$pICMSRet|$vICMSRet|$CFOP|$cMunFG\n";
		}


		//$veiculos = $this->getVeiculos();
		if(!empty($veiculos)){
			foreach ($veiculos as $k => $v){
				$$k = $v;
			}
			
			$txt .= "X18|$placa|$UF|$ANTT\n";

		}

		//$volumes = $this->getVolumes();
		if(!empty($volumes)){
			foreach ($volumes as $k => $v){
				$$k = $v;
			}
			$txt .= "X26|$qVol|$esp|$marca|$nVol|$pesoL|$pesoB|\n";
		}
		$lacre = $this->Lacres;
		if(!empty($lacre)){
			$txt .= "X33|".$lacre."|\n";
		}
		return $txt;
	}

	private function Cobranca(){

		$cobranca = $this->dadosCobranca;
		if(!empty($cobranca)){
			$txt = "Y|\n";
			if(isset($cobranca['Fatura'])){
				foreach ($cobranca['Fatura'] as $k => $v){
					$$k = $v;
				}
				$txt .= "Y02|$nFat|$vOrig|$vDesc|$vLiq|\n";
			}
			if(isset($cobranca['Duplicata'])){
				foreach ($cobranca['Duplicata'] as $value){
					foreach ($value as $k => $v){
						$$k = $v;
					}
					$txt .= "Y07|".$nDup."|".$dVenc."|".$vDup."|\n";
				}
				
			}
		}

		return $txt;
	}

	public function getTxt(){

		return $this->A().$this->B().$this->C().$this->D().$this->E().$this->F().$this->HProdutos().$this->Totais().$this->Transportador().$this->Cobranca().$this->infAdic;//.$this->getLivre();

	}

	public function saveAsTxt($arquivo=__DIR__){
		file_put_contents($arquivo,getTxt());
	}

	public function setInfAdic($fisco,$contribuinte) {
		$this->infAdic = "Z|".$fisco."|".$contribuinte."|\n";
	}







}