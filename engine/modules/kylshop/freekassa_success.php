<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * Пользователь попадает сюда после
 * успешной оплаты
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
    die( "Hacking attempt!" );
}

if(isset($_GET["payment"]) && $_GET["payment"] == "freekassa_success" && !empty($_GET["MERCHANT_ORDER_ID"]) && ctype_digit($_GET["MERCHANT_ORDER_ID"])){ // после успешной оплаты, показываем клиенту сообщение

    $row = $db -> super_query( "SELECT news_id FROM " . PREFIX . "_kylshop_buy WHERE number='{$_GET["MERCHANT_ORDER_ID"]}' LIMIT 1");
    header("Location: " . $config["http_home_url"] . "index.php?newsid=" . $row["news_id"]);
    exit;
}