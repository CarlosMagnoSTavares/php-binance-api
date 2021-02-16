
<h4>ENVIA JSON</h4>
<form method="POST" action="#">
	<select name="url">
		<option value="http://pitako.online/api-get-result.php">http://pitako.online/api-get-result.php</option>
		<option value="http://localhost/pitako/api-get-result.php">http://localhost/pitako/api-get-result.php</option>
	</select>
	<input type="submit" name="submit">
</form>

<?php
/*
echo "<pre>";
//API Url
// $url = 'http://pitako.online/api-get-result.php';
// $url = 'http://localhost/pitako/api-get-result.php';
$url = $_REQUEST['url'];

//Initiate cURL.
$ch = curl_init($url);

//The JSON data.
$jsonData = array(
    'JSON_TESTE_NOME' => 'CARLOS',
    'JSON_TESTE_SENHA' => 'ADMIN'
);

//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);

echo "<br> Dados enviados INICIO <br>";
var_dump($jsonDataEncoded);
echo "<br> Dados enviados FIM <br>";

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

//Execute the request
$result = curl_exec($ch);

echo "<br>RESPOSTA DA: ".$url." <br> ";
var_dump($result);
*/


DEFINE('SERVIDOR', 'smtp.live.com'); 
DEFINE('PORTA', '465');
DEFINE('USUARIO', 'carloscrls@hotmail.com');
DEFINE('SENHA', 'C4rl05212121#5');

$mail_box = imap_open("{" . SERVIDOR . ":" . PORTA . "/pop3/novalidate-cert}INBOX", USUARIO, SENHA);

echo '<pre>';
print_r(imap_errors());
echo '</pre>';

if ($mail_box) {
    // $total_de_mensagens = imap_num_msg($mail_box);
    $total_de_mensagens = 1;
    if ($total_de_mensagens > 0) {
        for ($mensagem = 1; $mensagem <= $total_de_mensagens; $mensagem++) {

            echo '<pre>';
                print_r(imap_headerinfo($mail_box, $mensagem));
            echo '</pre>';

            /*
             *  o terceiro parametro pode ser
             *  0=> retorna o body da mensagem com o texto que o servidor recebe
             *  1=> retorna somente o conteudo da mensagem em plain-text
             *  2=> retorna o conteudo da mensagem em html
             */
            
            echo "<hr />";
            $body_1 = ( imap_fetchbody($mail_box, $mensagem, 1) );
            echo $body_1;

            echo "<hr />";
            $body_0 = ( imap_fetchbody($mail_box, $mensagem, 0) );
            echo $body_0;

            echo "<hr />";
            $body_2 = ( imap_fetchbody($mail_box, $mensagem, 2) );
            echo $body_2;

            echo "<hr />";
            // deixei comentando pra não dar problema e excluir todos seus e-mails
            
            //imap_delete($mail_box, $mensagem);
            //imap_expunge($mail_box);

        }
    }
    imap_close($mail_box);
}
?>