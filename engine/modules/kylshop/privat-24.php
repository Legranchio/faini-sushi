<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: 
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

// $config["http_home_url"]

$details = "Пополнение личного счёта на сайте "; // название платежа

// функция для получения параметров

function GetParam($param){
    $return_payment = urldecode($_POST["payment"]);
    $first_param = explode("&", $return_payment);
    foreach($first_param as $val){
        if (preg_match("/".$param."="."/i", $val)){
            $result_param = explode($param."=", $val);
            return $result_param[1];
        }
    }
}

// принимаем данные после проведения платежа

if(!empty($_POST["payment"]) && !empty($_POST["signature"])){

    $signature1 = htmlspecialchars(strip_tags(trim($_POST["signature"])));
    $payment_sign = strip_tags($_POST["payment"]);

    $signature2 = sha1(md5($payment_sign.$kylshop_config["privat24_merchantPasword"])); // формирование подписи

    if($signature1 == $signature2){ // платёж прошёл успешно

        $post_order = GetParam("order");

        $post_login = GetParam("ext_details");

        $post_date = GetParam("date");

        $post_ref = GetParam("ref");

        $post_currency = GetParam("ccy");

        $post_sum = GetParam("amt");

        $post_status = GetParam("state");

        $sql_result = $db -> query( "SELECT * FROM " . PREFIX . "_privat_24 WHERE date = '{$post_date}'" );

        if($sql_result -> num_rows){

            $form = '<p style="color: #F15B56;"><b>Счёт уже оплачен!</b></p>';

        } else{

            $user_balance = $member_id['balance24'];
            $result_balance = $user_balance + 1; ///////////////////////////////////////////////////////////////////// НЕ РАБОТАЕТ
            // добавляем пользователю баланс
            $db->query( "UPDATE " . PREFIX . "_users SET balance24='$result_balance' WHERE name='$post_login'" );
            $db->query( "INSERT INTO " . PREFIX . "_privat_24 (`id`, `order`, `login`, `date`, `ref`, `currency`, `sum`, `status`) values (NULL, '{$post_order}', '{$post_login}', '{$post_date}', '{$post_ref}', '{$post_currency}', '{$post_sum}', '{$post_status}')" );
        }

    }

}

if(!empty($_POST["order"]) && is_numeric($_POST["order"])){

    $order = file_get_contents(ENGINE_DIR . '/modules/privat-24/count-24.txt'); //получаем номер покупки

	$fp = fopen(ENGINE_DIR . '/modules/privat-24/count-24.txt', 'w'); //перезаписываем номер покупки в файл count.txt
	fwrite($fp, $order+1);
	fclose($fp);

    $price = $_POST["order"]; // сумма платежа

    $payment = "amt=".$price."&ccy=".$kylshop_config["privat24_ccy"]."&details=".$details."&ext_details=".$member_id['name']."&pay_way=privat24&order=".$order."&merchant=".$kylshop_config["privat24_merchantId"];

    $signature = sha1(md5($payment.$kylshop_config["privat24_merchantPasword"]));

    $form .= '<p class="info-24">Заказа №: <b>'.$order.'</b>

        <br>Cумма: <b>'.$price.' грн</b>.

        <br>Получатель: <b>'.$member_id['name'].'</b></p>

        <form action="https://api.privatbank.ua/p24api/ishop" method="POST" accept-charset="UTF-8">

        <input type="hidden" name="amt" value="'.$price.'">

        <input type="hidden" name="ccy" value="'.$kylshop_config["privat24_ccy"].'">

        <input type="hidden" name="merchant" value="'.$kylshop_config["privat24_merchantId"].'">

        <input type="hidden" name="order" value="'.$order.'">

        <input type="hidden" name="details" value="'.$details.'">

        <input type="hidden" name="ext_details" value="'.$member_id['name'].'">

        <input type="hidden" name="pay_way" value="privat24">

        <input type="hidden" name="return_url" value="'.$config["http_home_url"].'privat-24.html">

        <input type="hidden" name="server_url" value="">

        <input type="hidden" name="signature" value="'.$signature.'">

        <input type="submit" value="Перейти к оплате">

    </form>';

} else{

    if(!empty($_POST["order"])){
        $form = '<p style="color: #F15B56;"><b>Введите число!</b></p>';
    }

    $form .= '<form action="" method="POST">
        <input type="text" name="order" value="" placeholder="Сумма пополнения" required>
        <input type="submit" value="Пополнить">
    </form>';
}

$tpl->set( '{form24}', $form );
$tpl->set( '{balance24}', $member_id['balance24']." грн." );

?>