<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: тестовые функции для будущей версии
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

function getCurrency($amount, $fromCurrency, $toCurrency) {
    //https://www.google.com/finance/converter?a=100&from=RUB&to=UAH
    $html = file_get_contents("http://www.google.com/finance/converter?a={$amount}&from={$fromCurrency}&to={$toCurrency}");
    return preg_replace('/(^.+bld>)([^\s]+)(.+$)/s', '$2', $html);
}

?>