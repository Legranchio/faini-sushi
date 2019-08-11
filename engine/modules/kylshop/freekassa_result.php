<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * Обработка скрытого ответа от
 * сервера WebMoney
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
    die( "Hacking attempt!" );
}

////////////////////////////////
///////////////////////////////
////////////////////////////////
// goods_link - оплата сразу
// goods_ids - оплата через корзину, когда известен секретный ключ

/**
 * @return LMI_PAYMENT_NO - Внутренний номер счёта продавца
 * @return LMI_SYS_INVS_NO - Внутренний номер счёта в системе webmoney
 * @return LMI_SYS_TRANS_NO - Внутренний номер платежа в системе WebMoney Transfer
 * @return LMI_SYS_TRANS_DATE - Дата и время выполнения платежа
 **/

// Скрытая реакция на получение запроса от сервера free-kassa
if(!empty($_GET["payment"]) && $_GET["payment"] == "freekassa_result"){

    include_once ENGINE_DIR . '/classes/mail.class.php';

    if(!empty($_POST["MERCHANT_ORDER_ID"]) && !empty($_POST["AMOUNT"]) && !empty($_POST["SIGN"])){

        function getIP() {
            if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
            return $_SERVER['REMOTE_ADDR'];
        }
        if (!in_array(getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98')))
            die("hacking attempt!");

        $sign = md5($kylshop_config["freekassa_id"].':'.$_REQUEST['AMOUNT'].':'.$kylshop_config["secret_word2"].':'.$_REQUEST['MERCHANT_ORDER_ID']);


        if ($sign != $_REQUEST['SIGN']) {
            die('wrong sign');
        }

        ############################################
        # отправлять на модерацию или сразу одобрить
        $main_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="main"', true, 0, 1);
        $_MS = unserialize($main_settings[0]["settings"]);
        if($_MS["moderation_buy"] == "on")
            $moderation_buy = 'm'; // на модерацию
        else
            $moderation_buy = '1'; // одобрить
        ############################################

        //$date = date("Y-m-d H:i:s", time());

        // NULL
        $paymentInfo = $db -> super_query( "SELECT secret_key_freekassa, email, sum, name FROM " . PREFIX . "_kylshop_buy WHERE number='{$_POST["MERCHANT_ORDER_ID"]}' LIMIT 1");

        if($paymentInfo && $paymentInfo["secret_key_freekassa"] == $sign && $paymentInfo["sum"] == $_POST["AMOUNT"]){
            // $paymentInfo["secret_key_freekassa"]
            $db -> query( "UPDATE " . PREFIX . "_kylshop_buy SET status='{$moderation_buy}' WHERE number='{$_POST["MERCHANT_ORDER_ID"]}'" );
            ####################################################
            header('HTTP/1.1 200 OK');

            $productInfo = $db -> super_query( "SELECT title FROM " . PREFIX . "_post WHERE number='{$_POST["MERCHANT_ORDER_ID"]}' LIMIT 1");

            $message = 'Сумма: <b>'.$paymentInfo["sum"].'</b> руб.<br>
            Логин пользователя: <b>'.$paymentInfo["name"].'</b><br>
            Наименование товара: <b><a href="'.$config["http_home_url"] . "index.php?newsid=" . $_POST["MERCHANT_ORDER_ID"].'">'.$productInfo["title"].'</a></b>';

            $admin_info = $dle_api -> take_user_by_id("1");

            //mail($admin_info['email'], $kylshop_config["send_theme"], $message, $headers);
            $mail = new dle_mail( $config,  "*");
            $mail->from = $admin_info['email'];
            $mail->send( $admin_info['email'], $kylshop_config["send_theme"], $message );

            // отправка письма пользователю
            if($_MS["moderation_buy"] == "on")
                $message_u = 'Ваш платёж принят. Как только мы проверим всё, Вы получите свой товар.';
            else
                $message_u = 'Спасибо за покупку!<br>
                Что бы получить купленый товар, перейдите на наш сайт: <b><a href="'.$config["http_home_url"].'">'.$config["http_home_url"].'</a></b>';

            //mail($paymentInfo["email"], "Ваша покупка", $message_u, $headers);

            $mail2 = new dle_mail( $config,  "*");
            $mail2->from = $admin_info['email'];
            $mail2->send( $paymentInfo["email"], "Ваша покупка", $message_u );

        }

//Так же, рекомендуется добавить проверку на сумму платежа и не была ли эта заявка уже оплачена или отменена
//Оплата прошла успешно, можно проводить операцию.

        /*$fp = fopen('test.txt', "w");
        flock($fp, LOCK_EX);
        fwrite($fp, json_encode($_POST) . "\n\r" . $sign . "\n\r" . $_SERVER["REMOTE_ADDR"]);
        flock($fp, LOCK_UN);*/

        die('YES');



    }
    exit;
}