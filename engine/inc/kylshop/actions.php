<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: обработка пост и гет запросов
 * =================================
 **/

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
    die( "Hacking attempt!" );
}

$answer_server = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){ // был ли вообще како-то пост

    # Настройки системы оплаты
    if(!empty($_POST["payments"])){

        if($_POST["payments"] == "webmoney"){ // если система webmoney

            $settings = array(
                "purse" => $_POST["purse"],
            );

            $new_settings = serialize($settings);

            $db -> query( "UPDATE " . PREFIX . "_kylshop_settings SET settings='{$new_settings}' WHERE name='webmoney'" );


            if(!empty($_POST["freekassa_id"])){
                $new_config = array(
                    "freekassa_id" => $_POST["freekassa_id"],
                    "secret_word1" => $_POST["freekassa_secret1"],
                    "secret_word2" => $_POST["freekassa_secret2"]

                );
                editConfig($new_config);
            }


            msg("info", 'Налаштування збережено!', 'Налаштування webmoney успішно збережені!', '?mod=kylshop&addon=payments');
        }

    }

    # Общие настройки магазина
    if(!empty($_POST["main"])){

        /*print_r($_POST);
        exit;*/

        if($_POST["main"] == "general"){ // если система webmoney

            $settings = array(
                "moderation_buy" => $_POST["moderation_buy"],
                "online_payments" => $_POST["config_online_payments"],
            );

            $new_settings = serialize($settings);

            $db -> query( "UPDATE " . PREFIX . "_kylshop_settings SET settings='{$new_settings}' WHERE name='main'" );


            if(!empty($_POST["config_form"]) && $_POST["config_form"] == "on") $new_config = array( "form" => 1 );
            else $new_config = array( "form" => 0 );

            editConfig($new_config);


            msg("info", 'Налаштування збережено!', 'Налаштування збережено!', '?mod=kylshop&addon=settings');
        }

    }
}

if($_SERVER["REQUEST_METHOD"] == "GET"){ // был ли вообще како-то гет

    // на модерацию
    if(!empty($_GET["status_go_moderation"]) && ctype_digit($_GET["status_go_moderation"]) === true){
        $db -> query( "UPDATE " . PREFIX . "_kylshop_buy SET status='m' WHERE number='{$_GET["status_go_moderation"]}'" );
        $answer_server = '<p class="ok">Замовлення № <b>'.$_GET["status_go_moderation"].'</b> направлено на модерацію.</p>';
    }

    // одобрение
    if(!empty($_GET["status_go_ok"]) && ctype_digit($_GET["status_go_ok"]) === true){
        $db -> query( "UPDATE " . PREFIX . "_kylshop_buy SET status='1' WHERE number='{$_GET["status_go_ok"]}'" );
        $answer_server = '<p class="ok">Замовлення  № <b>'.$_GET["status_go_ok"].'</b> Підтверджено.</p>';
    }

    // удаление
    if(!empty($_GET["delete_order"]) && ctype_digit($_GET["delete_order"]) === true){
        $db -> query( "DELETE FROM " . PREFIX . "_kylshop_buy WHERE number='{$_GET["delete_order"]}'" );
        $answer_server = '<p class="error">Замовлення  № <b>'.$_GET["delete_order"].'</b> Було видалено!</p>';
    }
}

?>