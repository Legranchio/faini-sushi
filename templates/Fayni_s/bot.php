<?php
/*if(isset($_POST['NAme'])){$name = $_POST['NAme'];}

if(isset($_POST['text'])){$text = $_POST['text'];}

$mess = "NAme: {$name}\nMesege: {$text}";*/


$method = $_SERVER['REQUEST_METHOD'];
//Script Foreach
$c = true;
if ( $method === 'POST' ) {
	$project_name = trim($_POST["project_name"]);
	$admin_email  = trim($_POST["admin_email"]);
	$form_subject = trim($_POST["form_subject"]);
	foreach ( $_POST as $key => $value ) {
		if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
			$message .= "
				<b>$key:</b>$value
							
			";
		}
	}
} else if ( $method === 'GET' ) {
	$project_name = trim($_GET["project_name"]);
	$admin_email  = trim($_GET["admin_email"]);
	$form_subject = trim($_GET["form_subject"]);
	foreach ( $_GET as $key => $value ) {
		if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
			$message .= "
			<b>$key:</b>$value						
		";
		}
	}
}
$message = $message;
function adopt($text) {
	return '=?UTF-8?B?'.Base64_encode($text).'?=';
}
$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
'Reply-To: '.$admin_email.'' . PHP_EOL;
mail($admin_email, adopt($form_subject), $message, $headers );






$token='671900615:AAFapq_51qMzksu-bWIdXk_-lrp4vnoEYd4';

$query = [
    'chat_id' => 426916642,
    'parse_mode' => 'HTML',
    'text' => $message
];
$query_2 = http_build_query($query);


$request = "https://api.telegram.org/bot".$token."/sendMessage?".$query_2;




file_get_contents($request);

echo($request);
?>