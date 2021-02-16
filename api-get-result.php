<?php
function salvaLog($msg)
{
	//Configura o timezone para pegar data e hora corretos 
	date_default_timezone_set('America/Sao_Paulo');
	$dataLocal = date('d/m/Y H:i:s', time());
	$msg = isset($msg) && !empty($msg)? "[".$dataLocal."] ".$msg."\n" : "";

	//Grava o log
	if (!empty($msg))
	{
		// Abre ou cria o arquivo api-get-result2.log
		// "a" representa que o arquivo é aberto para ser escrito
		$fp = fopen("api-get-result2.log", "a");
		// Escreve a mensagem passada através da variável $msg
		$escreve = fwrite($fp, $msg);
		// Fecha o arquivo
		fclose($fp);
	}
}

//Verifica se algum JSON foi enviado para ele
$data = json_decode(file_get_contents('php://input'), true);

//TAG para identar o resultado e ficar legível
echo "<pre>";

//Se a informação for enviada por JSON ele salva o JSON no log
if ($data) 
{
	$msg_JSON = "\n";
	$variable = $data;
	foreach ($variable as $key => $value) 
	{
		$msg_JSON .= 'JSON_KEY: '.$key.' JSON_VALUE: '.$value."\n";
	}
	var_dump($msg_JSON); // Escreve o resultado na tela para teste
	salvaLog($msg_JSON);	
}

// -----------------------------------------------------------------------------------------------

//Se a informação for enviada por POST ou GET ele salva no LOG
if ($_REQUEST) 
{
	$msg_REQUEST="\n";
	$variable = $_REQUEST;
	foreach ($variable as $key => $value) 
	{
		$msg_REQUEST .= 'REQUEST_KEY: '.$key.' REQUEST_VALUE: '.$value."\n";
	}
	var_dump($msg_REQUEST); // Escreve o resultado na tela para teste
	salvaLog($msg_REQUEST);
}

// -----------------------------------------------------------------------------------------------

//Se a informação for enviada por COOKIE ele salva no LOG
if ($_COOKIE) 
{
	$msg_REQUEST="\n";
	$variable = $_COOKIE;
	foreach ($variable as $key => $value) 
	{
		$msg_REQUEST .= 'COOKIE_KEY: '.$key.' COOKIE_VALUE: '.$value."\n";
	}
	var_dump($msg_REQUEST); // Escreve o resultado na tela para teste
	salvaLog($msg_REQUEST);
}
	

?>

<br> Arquivo com o resultado do LOG é o "api-get-result2.log" que é listado abaixo <br>
<iframe src="api-get-result2.log" width="100%" height="100%"></iframe>