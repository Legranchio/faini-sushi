<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: CONTROLLER
 * =================================
 **/

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
	die( "Hacking attempt!" );
}
// подключение API
include ('engine/api/api.class.php');
require_once ENGINE_DIR . '/modules/kylshop/config.php';

require_once ENGINE_DIR . '/inc/kylshop/functions.php';
// обработчик
require_once ENGINE_DIR . '/inc/kylshop/actions.php';

//$db -> query( "INSERT INTO " . PREFIX . "_kylshop_buy (number, name, email, description, news_id, news_link, sum, date) VALUES ('5', 'Владимир', 'master_z1zzz@mail.ru', 'Название товара', '3', 'http://test/3-news.html', '3100', '2016-02-24 12:00:00')" );

//msg("info", 'Информация о категории успешно сохранена!', 'Информация о категории успешно сохранена!', '?mod=catface');
echoheader( '<link href="engine/skins/kylshop/kylshop.css" rel="stylesheet" type="text/css">
<div class="pull-left header">
    <h3 class="title"><i class="logo_kyl-shop"></i>Магазин </h3>
    <!--h5>Автор: <a href="http://kylaksizov.ru/" target="_blank">Kylaksizov V.</a></h5-->
</div>' );

if(!isset($_GET["addon"])){

    include ('engine/inc/kylshop/index.php');

} else{

    switch ($_GET["addon"]) {

        case 'settings':
            include ('engine/inc/kylshop/settings.php');
            break;

        case 'payments':
            include ('engine/inc/kylshop/payments.php');
            break;

        case 'fields':
            include ('engine/inc/kylshop/fields.php');
            break;
        
        default:
            include ('engine/inc/kylshop/index.php');
            break;
    }
}


//msg("info", 'Информация о категории успешно сохранена!', 'Информация о категории успешно сохранена!', '?mod=catface');

echo '<p class="copyright">&copy; <a href="http://legranchio.com.ua" target="_blank">Legranchio</a>, 2018</p>
<script src="'.$config["http_home_url"].'engine/skins/kylshop/js/script.js"></script>';

echofooter();