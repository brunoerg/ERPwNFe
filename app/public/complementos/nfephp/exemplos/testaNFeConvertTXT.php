<?php

require_once('../libs/ConvertNFePHP.class.php');

$arq = 'xml/0008.txt';

//instancia a classe
$nfe = new ConvertNFePHP();

if ( is_file($arq) ){
    $xml = $nfe->nfetxt2xml($arq);
    if ($xml != ''){
        echo '<PRE>';
		$xml[0] = str_replace("><", ">\n<", $xml[0]);
		//$xml[0] = str_replace("</", "\n</", $xml[0]);
        echo htmlspecialchars($xml[0]);
        echo '</PRE><BR>';
        if (!file_put_contents('0008-nfe.xml',$xml)){
            echo "ERRO na gravação";
        }    
    }
}


?>
