<?php
require_once('../libs/ToolsNFePHP.class.php');
$nfe = new ToolsNFePHP;

$file = 'xml/17140113234946000164550010000000031819567561-nfe.xml';
$arq = file_get_contents($file);

if ($xml = $nfe->signXML($arq, 'infNFe')){
    file_put_contents($file, $xml);
	echo 'Assinada';
} else {
    echo $nfe->errMsg;
}


?>
