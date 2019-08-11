<?php
/**
 * CONTROLLER
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * CONTROLLER
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

include (ENGINE_DIR . '/api/api.class.php');
require_once ENGINE_DIR . '/modules/kylshop/config.php';
require_once ENGINE_DIR . '/modules/kylshop/functions.php';

// Если был скрытый запрос от серверов платёжных систем
if(isset($_GET["payment"])){
    
    if($_GET["payment"] == "webmoney_success")        
        require_once ENGINE_DIR . '/modules/kylshop/webmoney_success.php';
    if($_GET["payment"] == "webmoney_result")
        require_once ENGINE_DIR . '/modules/kylshop/webmoney_result.php';
    if($_GET["payment"] == "freekassa_success")
        require_once ENGINE_DIR . '/modules/kylshop/freekassa_success.php';
    if($_GET["payment"] == "freekassa_result")
        require_once ENGINE_DIR . '/modules/kylshop/freekassa_result.php';
    
    /*if($_GET["payment"] == "privat24_success")        
        require_once ENGINE_DIR . '/modules/kylshop/privat24_success.php'; */                   
        
} else{ // подключаем главный файл модуля публичной части

    include ENGINE_DIR . '/modules/kylshop/index.php';
}

?>