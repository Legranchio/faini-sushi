<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * работа с краткими новостями
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
    die( "Hacking attempt!" );
}

include (ENGINE_DIR . '/api/api.class.php');
include ENGINE_DIR . '/modules/kylshop/config.php';
require_once ENGINE_DIR . '/modules/kylshop/functions.php';

$news_id = $row["id"];

#######################################
#   получаем инфу из определённой новости
$row = $db -> super_query( "SELECT id, date, category, xfields, title, alt_name FROM " . PREFIX . "_post WHERE id='$news_id' LIMIT 1");

// массив с доп-полями
$xfields = xfieldsdataload( $row['xfields'] );

#######################################
#   получаем url новости
if( $config['allow_alt_url'] ) {
    if( $config['seo_type'] == 1 OR $config['seo_type'] == 2  ) {
        if( $row['category'] and $config['seo_type'] == 2 ) {
            $full_link = $config['http_home_url'] . get_url( $row['category'] ) . "/" . $row['id'] . "-" . $row['alt_name'] . ".html";
        } else {
            $full_link = $config['http_home_url'] . $row['id'] . "-" . $row['alt_name'] . ".html";
        }
    } else {
        $full_link = $config['http_home_url'] . date( 'Y/m/d/', $row['date'] ) . $row['alt_name'] . ".html";
    }
} else {
    $full_link = $config['http_home_url'] . "index.php?newsid=" . $row['id'];
}
#   получаем url новости end
#######################################

#######################################
#   если пользователь авторизован или разрешено покупать товары гостям
if($is_logged == "1" || $kylshop_config["guest_allow"] == true){


    if($is_logged != "1" && isset($_COOKIE["tmp_name"])){

        $is_buy = $dle_api -> load_table ( PREFIX."_kylshop_buy", "*", "name='{$_COOKIE["tmp_name"]}' and news_id LIKE '%{$news_id}%'", true, 0, 1);

    } else{

        $is_buy = $dle_api -> load_table ( PREFIX."_kylshop_buy", "*", "name='{$member_id["name"]}' and news_id LIKE '%{$news_id}%' and email='{$member_id["email"]}'", true, 0, 1);

    }

    if($is_buy !== false && $is_buy[0]["status"] !== "0"){ // если купил товар

        if($xfields["price"] !== NULL ){

            // getCurrency((int)$xfields["price"], 'RUB', 'UAH')
            $tpl->set ('{price}', $xfields["price"]);
            $tpl->set ('{ccy}', $kylshop_config["ccy"] );
            $tpl->set ( "[kylshop]", '' );
            $tpl->set ( "[/kylshop]", '' );

            if($is_buy[0]["status"] == "1"){
                # показываем товар пользователю
                $tpl->set ('{add-to-cart}', '<span class="kylshop_show">' . $xfields["main_img"] . '</span>' );
            } else if($is_buy[0]["status"] == "m"){
                # показываем товар пользователю
                $tpl->set ('{add-to-cart}', '<span class="kylshop_show_m"><b>Статус покупки:</b> на модерації.</span>' );
            } else{
                # показываем товар пользователю
                $tpl->set ('{add-to-cart}', '<span class="kylshop_show_m"><b>Статус покупки:</b> невідомо! Зверніться до адміністрації</span>' );
            }

        } else{ // если для новости не заданы доп.поля, то убираем всё

            $tpl->result['content'] = preg_replace( "'\[kylshop\](.*?)\[\/kylshop\]'si", "", $tpl->result['content'] );
        }

        //preg_match("#\[kylshop\](.*?)\[\/kylshop\]#", $tpl->result['content'], $l);
        //print_r($l);

    } else{ // если не купил товар
        
        if($xfields["price"] !== NULL ){

            $webmoney_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="webmoney"', true, 0, 1);
            $_WM = unserialize($webmoney_settings[0]["settings"]);

            $description = base64_encode($xfields["goods_description"]); // название товара, вернее его описание для оплаты

            $count_orders = file_get_contents(ENGINE_DIR . '/modules/kylshop/count_orders.txt'); // номер покупки
/*
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" accept-charset="utf-8">
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.(float)$xfields["price"].'" required>
    <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="'.$description.'">
    <input type="hidden" name="LMI_PAYMENT_NO" value="'.$count_orders.'">
    <input type="hidden" name="LMI_PAYEE_PURSE" value="'.$_WM["purse"].'">
    <input type="hidden" name="LMI_SIM_MODE" value="0">
    <input type="hidden" name="kylshop" value="true">
    <input type="hidden" name="payment_description" value="'.$xfields["goods_description"].'">
    <input type="hidden" name="user_id" value="'.$member_id["user_id"].'">
    <input type="hidden" name="name" value="'.$member_id["name"].'">
    <input type="hidden" name="user_email" value="'.$member_id["email"].'">
    <input type="hidden" name="goods_ids" value="'.$news_id.'">
    <input type="hidden" name="goods_link" value="'.$full_link.'">
    <input type="submit" class="go_buy" value="'.$kylshop_config["submit"].'">
</form>
*/
            $form_buy = '<div class="payment_buttons">
                <a id="toCartBtn'.$news_id.'" href="'.$full_link.'" class=" add_to_cart" data-goodsId="'.$news_id.'" data-goodsPrice="'.(float)$xfields["price"].'" data-goodsTitle="'.$xfields["goods_description"].'">До кошика</a>
            </div>';

            // getCurrency((int)$xfields["price"], 'RUB', 'UAH')
            $tpl->set ('{price}', $xfields["price"]);
            $tpl->set ('{add-to-cart}', $form_buy );
            $tpl->set ('{ccy}', $kylshop_config["ccy"] );

            $tpl->set ( "[kylshop]", '' );
            $tpl->set ( "[/kylshop]", '' );

        } else{ // если для новости не заданы доп.поля, то убираем всё

            $tpl->result['content'] = preg_replace( "'\[kylshop\](.*?)\[/kylshop\]'si", "", $tpl->result['content'] );
        }
    }

#######################################
#   если гость
} else{

    $info_logged = '<div class="kylshop_no_logged">Что бы купить товар, необходимо <a href="'.$config["http_home_url"].'index.php?do=register">зарегистрироваться</a>.</div>';

    // заменяем скрытые блоки на информацию о том, что нужно зарегистрироваться
    $tpl->result['content'] = preg_replace( "'\[kylshop\](.*?)\[/kylshop\]'si", $info_logged, $tpl->result['content'] );
}
#    если гость end
#######################################

?>