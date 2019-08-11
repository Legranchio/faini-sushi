<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: ---
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
    die( "Hacking attempt!" );
}

// корзина min
$cart_min = new dle_template();
$cart_min -> dir = TEMPLATE_DIR . "/kylshop";

$cart_min -> load_template( 'cart_min.tpl' );
$cart_min -> set('{ccy}', $kylshop_config["ccy"]);
$cart_min -> set('{link-cart}', $config["http_home_url"] . "?do=cart");
$cart_min -> compile( 'content' );
$tpl -> set( '{cart}', $cart_min -> result['content'] );

// корзина min END

if($is_logged == "1" || $kylshop_config["guest_allow"] == true){

    $modal = '<div id="bg_0"></div>
	<div id="modalCart">
		<table class="listing-cart">
			<tr>
				<th>Назва</th>
				<th width="70">Кількість</th>
				<th width="90">Ціна / 1 шт.</th>
			</tr>
		</table>
		<div class="totalGoods">Разом: <b>0</b><span> грн.</span></div>
		<ul class="action_button_cart">
			<li><a href="#" class="cartClear">Очистити кошик</a></li>
			<li><a href="'.$config["http_home_url"].'?do=cart" class="cartOrder">Оформити замовлення</a></li>
		</ul>
		<a href="#" class="cartClose"></a>
	</div>';

    $tpl -> set( '</body>', $modal . '</body>' ); // добавляем модальное окно для корзины
}

if($dle_module == "showfull"){ // если мы в полной новости
    include ENGINE_DIR . '/modules/kylshop/showfull.php';
} else{ // для остальных
    include ENGINE_DIR . '/modules/kylshop/show.short.php';
}



?>