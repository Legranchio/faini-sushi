<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: список заказаов
 * =================================
 **/
// УСТАНОВКА МОДУЛЯ
// $dle_api->install_admin_module ( "file-inc.php", "Название модуля", "Описание модуля", "ico.pnh", "1" );
if (!defined('DATALIFEENGINE') OR !defined('LOGGED_IN')) {
    die("Hacking attempt!");
}
$id = $_GET["order"];
$rows_buy = $db->super_query("SELECT * FROM " . PREFIX . "_kylshop_buy WHERE id = '$id'");
$userInfo = $db->super_query("SELECT * FROM " . PREFIX . "_users WHERE name = '" . $rows_buy["name"] . "'");
/*echo '<pre>';
print_r($userInfo["foto"]);
echo '</pre>';*/
$fields = '';
if (!empty($rows_buy["fields"])) {
    $fieldsSource = (array)json_decode($kylshop_config["form_fields"]);
    $fieldsGet = (array)json_decode($rows_buy["fields"]);
    /*echo '<pre>';
    print_r($fieldsGet);
    echo '</pre>';*/
    foreach ($fieldsGet as $name => $value) {
        $_name = "";
        foreach ($fieldsSource as $key => $item) {
            if (strripos($key, "|".$name."|") || strripos($key, "|".$name."=user_id|") || strripos($key, "|".$name."=user_name|") || strripos($key, "|".$name."=user_email|") || strripos($key, "|".$name."=user_ip|")) {
                $k = explode("|", $key);
                $_name = $k[2];
            }
        }
        if($name != "productsIds" && $name != "productsAmount" && !empty($value))
            $fields .= '<p class="fields"><b>' . $_name . '</b> ' . $value . '</p>';
    }
    //$fields = $rows_buy["fields"];
}
echo '<div class="answer_server">' . $answer_server . '</div>
<div class="box">
<div class="row">
    <div class="col-md-2 col-sm-3 pad_no_r">
        <ul class="kylshop_menu">
            <li><a href="?mod=kylshop" class="k_active">Список замовлень</a></li>
            <li><a href="?mod=kylshop&addon=settings">Налаштування</a></li>
            <li><a href="?mod=kylshop&addon=payments">Системи оплати</a></li>
            <li><a href="?mod=kylshop&addon=fields">Додаткові поля форми</a></li>
        </ul>
    </div>
    <div class="col-md-10 col-sm-9 pad_no_l">
        <div class="box-header">
            <div class="title">Замовлення №' . $rows_buy["id"] . '</div>
        </div>
        <div class="box-content pad">
            <div class="row pad">
                <div class="fl">
                    <a href="' . $config["http_home_url"] . 'user/' . $rows_buy["name"] . '/" class="user_name" target="_blank">' . $rows_buy["name"] . '</a><br>
                    <a href="' . $config["http_home_url"] . 'user/' . $rows_buy["name"] . '/" target="_blank"><img src="' . $userInfo["foto"] . '" alt=""></a>
                </div>
                <div class="fl">' . $fields . '</div>
            </div>
        </div>
    </div>
</div>
</div>';