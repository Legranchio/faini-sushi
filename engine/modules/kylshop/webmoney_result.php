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

// {include file="engine/modules/webmoney.php?param=value1&variable2=value2"}

include ('engine/api/api.class.php');
include_once ENGINE_DIR . '/classes/mail.class.php';

##########################################################
// Это скрытый обработчик
if(isset($_GET["payment"]) && $_GET["payment"] == "webmoney_result" && !empty($_POST["goods_ids"]) && !empty($_POST["kylshop"]) && $_POST["kylshop"] == "true" && !empty($_POST["LMI_PAYMENT_AMOUNT"])){

    ############################################
    # отправлять на модерацию или сразу одобрить
    $main_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="main"', true, 0, 1);
    $_MS = unserialize($main_settings[0]["settings"]);
    if($_MS["moderation_buy"] == "on")
        $moderation_buy = 'm'; // на модерацию
    else
        $moderation_buy = '1'; // одобрить
    ############################################

    if(!empty($_POST["goods_link"])){ // сли покупка одного товара, то меняем номер покупки для следующего покупателя
        $count_orders = file_get_contents(ENGINE_DIR . '/modules/kylshop/count_orders.txt'); //получаем номер покупки
        $fp = fopen(ENGINE_DIR . '/modules/kylshop/count_orders.txt', 'w'); //перезаписываем номер покупки в файл count.txt
        fwrite($fp, (int)$count_orders + 1);
        fclose($fp);
    }

	$date = date("Y-m-d H:i:s", time());
    
    $total = (float)$_POST["LMI_PAYMENT_AMOUNT"]; // номер внутреннего номера заказа
    
    // NULL
    $row = $db -> super_query( "SELECT secret_key, sum, name FROM " . PREFIX . "_kylshop_buy WHERE number='{$_POST["LMI_PAYMENT_NO"]}' LIMIT 1");

    ####################################################
    # генерируем уникальный идентификатор платежа
    $general_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="general"', true, 0, 1);
    $_GS = unserialize($general_settings[0]["settings"]);
    $UNIQUE_ID_PAYMENT = sha1($_GS["secret_key"] . $total . $_POST["LMI_PAYMENT_NO"]);
    ####################################################


    if(!empty($_POST["goods_ids"])){
    
        //$cont = '1: ' . $_POST["LMI_PAYMENT_NO"] . PHP_EOL;
        //$cont .= '2: ' . $_POST["name"] . PHP_EOL;
        //$cont .= '3: ' . $_POST["user_email"] . PHP_EOL;
        //$cont .= '4: ' . $_POST["payment_description"] . PHP_EOL;
        //$cont .= '5: ' . $_POST["open_file_news_id"] . PHP_EOL;
        //$cont .= '6: ' . $_POST["goods_ids"] . PHP_EOL;
        //$cont .= '7: ' . $sum . PHP_EOL;
        //$cont .= '8: ' . $date . PHP_EOL;

        //$fp2 = fopen(ENGINE_DIR . '/modules/kylshop/test.txt', 'w'); //перезаписываем номер покупки в файл count.txt
        //fwrite($fp2, $cont);
        //fclose($fp2);
        
        ####################################################
        # если покупка через корзину
        if($row !== NULL && $row["secret_key"] == $UNIQUE_ID_PAYMENT && round($row["sum"]) == round($total) && $row["name"] == $_POST["name"]){

            # Обновляем стату покупки
            $db -> query( "UPDATE " . PREFIX . "_kylshop_buy SET status='{$moderation_buy}' WHERE number='{$_POST["LMI_PAYMENT_NO"]}'" );
            ####################################################
            header('HTTP/1.1 200 OK');
            
            $message = 'Сумма: <b>'.$total.'</b> руб.<br>
            Логин пользователя: <b>'.$_POST["name"].'</b><br>
            Наименование товара: <b><a href="'.$config["http_home_url"].'">'.$_POST["payment_description"].'</a></b>';
            
            $admin_info = $dle_api -> take_user_by_id("1");

            $mail = new dle_mail( $config,  "");
            $mail->from = $admin_info['email'];
            $mail->send( $admin_info['email'], $kylshop_config["send_theme"], $message );
            
            // отправка письма пользователю
            if($_MS["moderation_buy"] == "on")
                $message_u = 'Ваш платёж принят. Как только мы проверим всё, Вы получите свой товар.';
            else
                $message_u = 'Спасибо за покупку!<br>
                Что бы получить купленый товар, перейдите на наш сайт: <b><a href="'.$config["http_home_url"].'">'.$config["http_home_url"].'</a></b>';

            $mail2 = new dle_mail( $config,  "");
            $mail2->from = $admin_info['email'];
            $mail2->send( $paymentInfo["email"], "Ваша покупка", $message_u );

        } else{

            ####################################################
            # если покупка в один клик
            if(!empty($_POST["goods_link"])){

                # Обновляем стату покупки
                $db -> query( "UPDATE " . PREFIX . "_kylshop_buy SET status='{$moderation_buy}' WHERE number='{$_POST["LMI_PAYMENT_NO"]}'" );

                ####################################################
                # Заносим покупку в базу данных
                $db -> query( "INSERT INTO " . PREFIX . "_kylshop_buy (number, name, email, description, news_id, sum, date, status)
                    VALUES ('{$_POST["LMI_PAYMENT_NO"]}', '{$_POST["name"]}', '{$_POST["user_email"]}', '{$_POST["payment_description"]}', '{$_POST["goods_ids"]}', '{$total}', '{$date}', '{$moderation_buy}')" );
                ####################################################
                header('HTTP/1.1 200 OK');
                
                $message = 'Сумма: <b>'.$total.'</b> руб.<br>
                Логин пользователя: <b>'.$_POST["name"].'</b><br>
                Наименование товара: <b><a href="'.$_POST["goods_ids"].'">'.$_POST["payment_description"].'</a></b>';
                
                $admin_info = $dle_api -> take_user_by_id("1");

                $mail = new dle_mail( $config,  "");
                $mail->from = $admin_info['email'];
                $mail->send( $admin_info['email'], $kylshop_config["send_theme"], $message );
                
                // отправка письма пользователю
                if($_MS["moderation_buy"] == "on")
                    $message_u = 'Ваш платёж принят. Как только мы проверим всё, Вы получите свой товар.';
                else
                    $message_u = 'Спасибо за покупку!<br>Что бы получить купленый товар, перейдите по ссылке: <b><a href="'.$_POST["goods_link"].'">'.$_POST["payment_description"].'</a></b>';

                $mail2 = new dle_mail( $config,  "");
                $mail2->from = $admin_info['email'];
                $mail2->send( $paymentInfo["email"], "Ваша покупка", $message_u );
            }
        }

    }
    ####################################################

    $fp = fopen('test.txt', "w");
    flock($fp, LOCK_EX);
    fwrite($fp, json_encode($_POST));
    flock($fp, LOCK_UN);

    exit;
    
}