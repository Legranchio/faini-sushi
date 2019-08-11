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

$kylshop_config = array(

    // валюта
	"currency" => 'USD',
    // валюта
	"ccy" => 'грн.',
    // название кнопки
	"submit" => 'Перейти до оплати',
	"send_theme" => 'Нова покупка',

    // количество заказов на странице
	"limit_orders" => 15,

	"freekassa_id" => '',
	"secret_word1" => '',
	"secret_word2" => '',

    // разрешить гостью покупку товара
	"guest_allow" => 1,

    // показывать форму
	"form" => 1,

    // текст после оформления заказа
	"text_after_offer" => '<h1 id="end_mesage">Дякуємо за замовлення</h1>
	<p class="end_add_msg">Ви отримаєте інформацію про доставку від нашого оператора за декілька хвилин. <a id="be_back" href="/">Повернутись на головну</a>  </p>
	<script>
	localStorage.clear();
	$(".oneGoods").remove();
	$(".allPrice b").text("0");
	$("#cart .number_goods").html(\'<b>0</b> шт.\');
	$(".totalGoods b, #cart .total_amount b").text(\'0\');
	
	</script>
	',

    // поля формы
	"form_fields" => '{"text|name=user_name|Ім\'я покупця:|required":"Як вас звати:",
		"text|tel|Телефон користувача:|required":"Ваш телефон:",
		"hidden|ip=user_ip|IP покупця:|":""}',

);