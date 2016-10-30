<?php
require_once('../libs/ToolsNFePHP.class.php');
$arq = 'xml/17140113234946000164550010000000031819567561-nfe.xml';
//$arq = './35120358716523000119550000000162421280334154-nfe.xml';
$nfe = new ToolsNFePHP;
$docxml = file_get_contents($arq);
$xsdFile = '../schemes/PL_006r/nfe_v2.00.xsd';
$aErro = '';
$c = $nfe->validXML($docxml,$xsdFile,$aErro);
if (!$c){
    echo 'Houve erro --- <br>';
    foreach ($aErro as $er){
        echo $er .'<br>';
    }
} else {
    echo 'VALIDADA!';
}
?>
