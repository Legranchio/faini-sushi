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

if(isset($_GET["payment"]) && $_GET["payment"] == "webmoney_success"){ // после успешной оплаты, показываем клиенту сообщение
    $fp = fopen('test.txt', "w");
    flock($fp, LOCK_EX);
    fwrite($fp, json_encode($_POST));
    flock($fp, LOCK_UN);

    //exit;
}