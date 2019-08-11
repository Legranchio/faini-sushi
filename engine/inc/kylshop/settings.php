<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: общие настройки
 * =================================
 **/

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
    die( "Hacking attempt!" );
}

$main_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="main"', true, 0, 1);

$_MS = unserialize($main_settings[0]["settings"]);

if($_MS["online_payments"] == "on") $online_payments = ' checked';
else $online_payments = '';

if($_MS["moderation_buy"] == "on") $moderation_buy = ' checked';
else $moderation_buy = '';

$form_checked = "";
if($kylshop_config["form"] == 1) $form_checked = ' checked';


echo '<div class="box">
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
		        <div class="title">Сторінка налаштувань</div>
		    </div>
		    <div class="box-content">
		    	<form method="post" action="" name="personal" class="form-horizontal">
			        <table class="table table-normal">
			        	<!--<tr>
					        <td class="col-xs-9"><h6>Назва</h6><span class="note large">Опис</span></td>
					        <td class="col-xs-3 settingstd"><input type="text" style="width: 100%" name=""></td>
				        </tr>-->
				        <tr>
					        <td class="col-xs-9"><h6>Увімкнути оплату онлайн</h6><span class="note large">Якщо включено то після оформлення замовлення будуть доступні способи оплати</span></td>
					        <td class="col-xs-3 settingstd"><input class="iButton-icons-tab" type="checkbox" name="config_online_payments"'.$online_payments.'></td>
				        </tr>
				        <tr>
					        <td class="col-xs-9"><h6>Що виводити після замовлення</h6><span class="note large">Якщо включено то після замовлення користувач побачить цей текст</span></td>
					        <td class="col-xs-3 settingstd"><textarea style="width: 100%;" name="config_text_after_offer">'.$kylshop_config["text_after_offer"].'</textarea></td>
				        </tr>
				        <tr>
					        <td class="col-xs-9"><h6>Відправляти замовлення на модерацію після оплати?</h6><span class="note large">Якщо це включено то користувач зможе бачитистатус замовлення на сторінці товару.</span></td>
					        <td class="col-xs-3 settingstd"><input class="iButton-icons-tab" type="checkbox" name="moderation_buy"'.$moderation_buy.'></td>
				        </tr>
				        <tr>
					        <td class="col-xs-9"><h6>Форма з полями при оформлені замовлення</h6><span class="note large">Якщо включено то користувач зможе залишити інформацію про себе <b>Додаткові поля</b></span></td>
					        <td class="col-xs-3 settingstd"><input class="iButton-icons-tab" type="checkbox" name="config_form"'.$form_checked.'></td>
				        </tr>
			        </table>
			        <div class="row box-section">
			        	<input type="hidden" name="main" value="general">
						<input type="submit" class="btn btn-green" value="Зберегти">
					</div>
		    	</form>
		    </div>
    	</div>
    </div>
</div>';