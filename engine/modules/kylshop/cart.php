<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: Страница корзины
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
    die( "Hacking attempt!" );
}

include ('engine/api/api.class.php');

// корзина
require_once ENGINE_DIR . '/modules/kylshop/config.php';

$tpl -> load_template( 'kylshop/cart.tpl' );


$main_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="main"', true, 0, 1);

$_MS = unserialize($main_settings[0]["settings"]);

/*
echo '<pre>';
print_r($member_id);
echo '</pre>';
*/

/*
    [email] => master_z1zzz@mail.ru
    [password] => 0d992b6a7b094eaf1270474d430f814f
    [name] => Kylaksizov
    [user_id] => 1
    [news_num] => 46
    [comm_num] => 213
    [user_group] => 1
    [lastdate] => 1479279519
    [reg_date] => 1420641355
    [banned] =>
    [allow_mail] => 1
    [info] =>
    [signature] =>
    [foto] => http://kylaksizov.ru/uploads/fotos/foto_1.jpg
    [fullname] =>
    [land] =>
    [favorites] =>
    [pm_all] => 24
    [pm_unread] => 0
    [time_limit] => 1463286982
    [xfields] =>
    [allowed_ip] =>
    [hash] =>
    [logged_ip] => 46.118.219.12
    [restricted] => 0
    [restricted_days] => 0
    [restricted_date] =>
    [timezone] =>
    [payments_tag_hide] => script
    [user_balance] => 0
    [balance24] => 2
*/

############################################
#	Если пользователь авторизован
if($is_logged == "1" || $kylshop_config["guest_allow"] == true){

    if(!isset($_GET["page"])){ // первая страница корзины

		$cont = '
		<a href="/" id="buy_more">Повернутись, і вибрати ще.</a>
		<h1 id="static_cart_ttl">Ваше замовлення</h1>
		
		
		<a href="#" class="cartClear">очистити</a>
		<table class="listing-cart staticCart">
			<tr>
				<th>Назва</th>
				<th width="70">Кількість</th>
				<th width="90">Ціна / 1 шт.</th>
			</tr>
		</table>
		<div class="totalGoods">Разом: <b>0</b><span> грн.</span></div>';

        $field = '';

        if($kylshop_config["form"] == true){

            if($kylshop_config["form_fields"]){

                $form_fields = json_decode($kylshop_config["form_fields"]);

                foreach ($form_fields as $key => $form_field) {

                    $fields_type = explode("|", $key);

                    // замена на существующие данные авторизированного пользователя
                    $replace_value = explode("=", $fields_type[1]);
                    if(!empty($replace_value[1])){

                        // Тут происходит замена
                        $input_name = $replace_value[0];

                        $input_value = str_replace(array("user_id", "user_name", "user_email", "user_ip"), array($member_id["user_id"], $member_id["name"], $member_id["email"], $_SERVER["REMOTE_ADDR"]), $replace_value[1]);
                        //$input_value = $replace_value[1];

                    } else{

                        $input_name = $fields_type[1];
                        $input_value = "";
                    }
                    //var_dump($replace_value);

                    if(!empty($fields_type[3])) $fields_type[3] = " " . $fields_type[3];
                    else $fields_type[3] = "";

                    if($fields_type[0] == "text" || $fields_type[0] == "number" || $fields_type[0] == "email" || $fields_type[0] == "tel" || $fields_type[0] == "password" || $fields_type[0] == "hidden"){
                        $field .= '<span class="one_field"><input type="'.$fields_type[0].'" name="'.$input_name.'" id="kylshop_field_'.$input_name.'" placeholder="'.$form_field.'" value="'.$input_value.'"'.$fields_type[3].'></span>';
                    } else if($fields_type[0] == "select"){
                        $options = explode("*", $form_field);
                        $field .= '<span class="one_field"><select name="'.$input_name.'" id="kylshop_field_'.$input_name.'">';
                        foreach ($options as $option) {
                            $field .= '<option value="'.$option.'">'.$option.'</option>';
                        }
                        $field .= '</select></span>';
                    } else if($fields_type[0] == "checkbox" || $fields_type[0] == "radio"){
                        $field .= '<label class="one_field"><input type="'.$fields_type[0].'" name="'.$input_name.'" id="kylshop_field_'.$input_name.'" value="'.$form_field.'"'.$fields_type[3].'> '.$form_field.'</label>';
                    } else if($fields_type[0] == "textarea"){
                        $field .= '<textarea name="'.$input_name.'" id="kylshop_field_'.$input_name.'" placeholder="'.$form_field.'"'.$fields_type[3].'>'.$input_value.'</textarea>';
                    }
                }
                $field .= '<div class="clr"></div>';
            }
        }

        //$field = str_replace(array("{}"), array(), $field);

        if($_MS["online_payments"] == "on") $button_name = 'Перейти до оплати';
        else $button_name = 'Оформити замовлення';

        $cont .= '<div class="action_button_cart">
            <form id="cart_done_form" method="POST" action="'.$config["http_home_url"].'?do=cart&page=payments">
				'.$field.'
				
				<span class="one_field">
				<p class="adres_fild_label">Населений пункт: <span class="req">*</span></p>
				<select name="Населений_пункт" id="adres_1"  >
                      <option value="с.Байківці">с.Байківці</option>
                      <option value="Березовиця">с.Березовиця</option>
                      <option value="Біла">с.Біла</option>
                      <option value="Великі_Гаї">с.Великі Гаї</option>
                      <option value="Гаї_Гречинські">с.Гаї Гречинські</option>
                      <option value="Гаї_Ходоровські">с.Гаї Ходоровські</option>
                      <option value="Гаї_Шевченківські">с.Гаї Шевченківські</option>
                      <option value="Кутківці">с.Кутківці</option>
                      <option value="Острів">с.Острів</option>
                      <option value="Петриків">с.Петриків</option>
                      <option value="Підгороднє">с.Підгороднє</option>
                      <option value="Пронятин">с.Пронятин</option>
                      <option value="Смиківці">с.Смиківці</option>
                      <option value="Чистилів">с.Чистилів</option>
                      <option value="Тернопіль" selected="selected">Тернопіль</option>
				  </select></span>
				  <span id="adres_street" class="one_field">
				  <p class="adres_fild_label">Вулиця: <span class="req">*</span></p>

				<select  name="Вулиця" id="adres_2"    aria-hidden="true">
				<option value="15 Квітня">15 Квітня</option>
				<option value="Багата">Багата</option>
				<option value="Балея">Балея</option>
				<option value="Банківська">Банківська</option>
				<option value="Безкоровайного">Безкоровайного</option>
				<option value="Бережанська">Бережанська</option>
				<option value="Березова">Березова</option>
				<option value="Білецька">Білецька</option>
				<option value="Білогірська">Білогірська</option>
				<option value="Бічна">Бічна</option>
				<option value="Богдана Хмельницького">Богдана Хмельницького</option>
				<option value="Богуна">Богуна</option>
				<option value="Бойківська">Бойківська</option>
				<option value="Бордуляка">Бордуляка</option>
				<option value="Братів Бойчуків">Братів Бойчуків</option>
				<option value="Братів Гжицьких">Братів Гжицьких</option>
				<option value="Братів Масулів, с.Гаї Чумакові">Братів Масулів, с.Гаї Чумакові</option>
				<option value="Броварна">Броварна</option>
				<option value="Бродівська">Бродівська</option>
				<option value="Брюкнера">Брюкнера</option>
				<option value="Будзиновського">Будзиновського</option>
				<option value="бульвар Данила Галицького">бульвар Данила Галицького</option>
				<option value="Бульвар Куліша(Сонячний)">Бульвар Куліша(Сонячний)</option>
				<option value="бульвар Шевченка">бульвар Шевченка</option>
				<option value="Вагилевича">Вагилевича</option>
				<option value="Валова">Валова</option>
				<option value="Вербицького">Вербицького</option>
				<option value="Вербова">Вербова</option>
				<option value="Вертепна">Вертепна</option>
				<option value="верхня Підлісна">верхня Підлісна</option>
				<option value="Весела">Весела</option>
				<option value="Виговського">Виговського</option>
				<option value="Винниченка">Винниченка</option>
				<option value="Вишнева">Вишнева</option>
				<option value="Вишневецького">Вишневецького</option>
				<option value="Вільхова">Вільхова</option>
				<option value="Вітовського">Вітовського</option>
				<option value="Волинська">Волинська</option>
				<option value="Володимира Великого">Володимира Великого</option>
				<option value="Володимира Гнатюка">Володимира Гнатюка</option>
				<option value="Вояків дивізії Галичина">Вояків дивізії "Галичина"</option>
				<!--option value="вул овочева 7 кв 54">вул овочева 7 кв 54</option-->
				<option value="Гагаріна">Гагаріна</option>
				<option value="Гайова">Гайова</option>
				<option value="Гайова-бічна">Гайова-бічна</option>
				<option value="Галицька">Галицька</option>
				<option value="Галицька-бічна">Галицька-бічна</option>
				<option value="Героїв Крут">Героїв Крут</option>
				<option value="Гірняка">Гірняка</option>
				<option value="Глибока">Глибока</option>
				<option value="Глиняна">Глиняна</option>
				<option value="Глінки">Глінки</option>
				<option value="Гніздовського">Гніздовського</option>
				<option value="Гоголя">Гоголя</option>
				<option value="Головацького">Головацького</option>
				<option value="Голубовича">Голубовича</option>
				<option value="Горбачевського">Горбачевського</option>
				<option value="Городна">Городна</option>
				<option value="Гоцульська">Гоцульська</option>
				<option value="Грабовського">Грабовського</option>
				<option value="Гребінки">Гребінки</option>
				<option value="Гріга">Гріга</option>
				<option value="Громницького">Громницького</option>
				<option value="Грушевського">Грушевського</option>
				<option value="Гуцульська">Гуцульська</option>
				<option value="Далека">Далека</option>
				<option value="Дальній пляж">Дальній пляж</option>
				<option value="Деповська">Деповська</option>
				<option value="Дівоча">Дівоча</option>
				<option value="Ділова">Ділова</option>
				<option value="Дністрянського">Дністрянського</option>
				<option value="Довбуша">Довбуша</option>
				<option value="Довга">Довга</option>
				<option value="Довженка">Довженка</option>
				<option value="Доли">Доли</option>
				<option value="Долі">Долі</option>
				<option value="Дорошенка">Дорошенка</option>
				<option value="Достоєвського">Достоєвського</option>
				<option value="Драгоманова">Драгоманова</option>
				<option value="Дружби">Дружби</option>
				<option value="Дубовецька">Дубовецька</option>
				<option value="Енергетична">Енергетична</option>
				<option value="Живова">Живова</option>
				<option value="За рудкою">За рудкою</option>
				<option value="Загородня">Загородня</option>
				<option value="Загребельна">Загребельна</option>
				<option value="Замкова">Замкова</option>
				<option value="Замонастирська">Замонастирська</option>
				<option value="Західна">Західна</option>
				<option value="Збаразька">Збаразька</option>
				<option value="Збаразький поворот">Збаразький поворот</option>
				<option value="Зелена">Зелена</option>
				<option value="Злуки">Злуки</option>
				<option value="Івана Франка">Івана Франка</option>
				<option value="Йосипа Сліпого">Йосипа Сліпого</option>
				<option value="Камінна">Камінна</option>
				<option value="Канадська">Канадська</option>
				<option value="Кармелюка">Кармелюка</option>
				<option value="Карпенка">Карпенка</option>
				<option value="Качали">Качали</option>
				<option value="Квітова">Квітова</option>
				<option value="Київська">Київська</option>
				<option value="Клима Савури">Клима Савури</option>
				<option value="Клінічна">Клінічна</option>
				<option value="Козацька">Козацька</option>
				<option value="Коллонтая">Коллонтая</option>
				<option value="Коновальця">Коновальця</option>
				<option value="Коперника">Коперника</option>
				<option value="Корольова">Корольова</option>
				<option value="Котляревського">Котляревського</option>
				<option value="Коцюбинського">Коцюбинського</option>
				<option value="Кривоноса">Кривоноса</option>
				<option value="Крушельницької">Крушельницької</option>
				<option value="Куліша">Куліша</option>
				<option value="Кульчицької">Кульчицької</option>
				<option value="Купчинського">Купчинського</option>
				<option value="Куток">Куток</option>
				<option value="Лемківська">Лемківська</option>
				<option value="Лепкого">Лепкого</option>
				<option value="Лесі Українки">Лесі Українки</option>
				<option value="Леся Курбаса">Леся Курбаса</option>
				<option value="Липова">Липова</option>
				<option value="Лисенка">Лисенка</option>
				<option value="Листопадова">Листопадова</option>
				<option value="Лісова">Лісова</option>
				<option value="Лозовецька">Лозовецька</option>
				<option value="Ломоносова">Ломоносова</option>
				<option value="Лук\'яновича">Лук\'яновича</option>
				<option value="Лучаківського">Лучаківського</option>
				<option value="Льва Толстого">Льва Толстого</option>
				<option value="Львівська">Львівська</option>
				<option value="Мазепи">Мазепи</option>
				<option value="майдан Волі">майдан Волі</option>
				<option value="майдан Героїв Євромайдану">майдан Героїв Євромайдану</option>
				<option value="майдан Мистецтв">майдан Мистецтв</option>
				<option value="майдан Перемоги">майдан Перемоги</option>
				<option value="майдан Театральний">майдан Театральний</option>
				<option value="Макаренка">Макаренка</option>
				<option value="Малишка">Малишка</option>
				<option value="Марка Вовчка">Марка Вовчка</option>
				<option value="Медова">Медова</option>
				<option value="Межова">Межова</option>
				<option value="Микулинецька">Микулинецька</option>
				<option value="Микулинецька-бічна">Микулинецька-бічна</option>
				<option value="Миру">Миру</option>
				<option value="Михалевича">Михалевича</option>
				<option value="Молодіжна">Молодіжна</option>
				<option value="Молодої гвардії">Молодої гвардії</option>
				<option value="Монастирського">Монастирського</option>
				<option value="Монюшко">Монюшко</option>
				<option value="Морозенка">Морозенка</option>
				<option value="Мостова">Мостова</option>
				<option value="Мостова-бічна">Мостова-бічна</option>
				<option value="Мстислава">Мстислава</option>
				<option value="Набережна">Набережна</option>
				<option value="Над Ставом">Над Ставом</option>
				<option value="Над Яром">Над Яром</option>
				<option value="Надзбручанська">Надзбручанська</option>
				<option value="Наливайка">Наливайка</option>
				<option value="Невського">Невського</option>
				<option value="Нечая">Нечая</option>
				<option value="Нова">Нова</option>
				<option value="Новий Світ">Новий Світ</option>
				<option value="Новий Світ-бічна">Новий Світ-бічна</option>
				<option value="Новосонячна">Новосонячна</option>
				<option value="Обїзна">Обїзна</option>
				<option value="Оболоня">Оболоня</option>
				<option value="Овочева">Овочева</option>
				<option value="Опільського">Опільського</option>
				<option value="Орлика">Орлика</option>
				<option value="Острозького">Острозького</option>
				<option value="Паращука">Паращука</option>
				<option value="Паркова">Паркова</option>
				<option value="Перля">Перля</option>
				<option value="Петлюри">Петлюри</option>
				<option value="Петриківська">Петриківська</option>
				<option value="Петрушевича">Петрушевича</option>
				<option value="Пирогова">Пирогова</option>
				<option value="Південна">Південна</option>
				<option value="Північна">Північна</option>
				<option value="Підволочиська">Підволочиська</option>
				<option value="Підволочиське шосе">Підволочиське шосе</option>
				<option value="Підгірна">Підгірна</option>
				<option value="Підгородня">Підгородня</option>
				<option value="Підкови">Підкови</option>
				<option value="Підлісна">Підлісна</option>
				<option value="Піскова">Піскова</option>
				<option value="Плотицька">Плотицька</option>
				<option value="площа Героїв євромайдану">площа Героїв євромайдану</option>
				<option value="Подільська">Подільська</option>
				<option value="Поліська">Поліська</option>
				<option value="Польова">Польова</option>				
				<option value="Польового">Польового</option>					
				<option value="Привокзальний майдан">Привокзальний майдан</option>
				<option value="Приміська">Приміська</option>
				<option value="пров. Дівочий">пров. Дівочий</option>
				<option value="пров. Збаразький">пров. Збаразький</option>
				<option value="пров. Цегельний">пров. Цегельний</option>
				<option value="провулок Броварний">провулок Броварний</option>
				<option value="провулок Замонастирський">провулок Замонастирський</option>
				<option value="провулок Куток">провулок Куток</option>
				<option value="провулок Садовий">провулок Садовий</option>
				<option value="провулок Шкільний, газопровід">провулок Шкільний, газопровід</option>
				<option value="Промислова">Промислова</option>
				<option value="Просвіти">Просвіти</option>
				<option value="Протасевича">Протасевича</option>
				<option value="Пулюя">Пулюя</option>
				<option value="Пушкіна">Пушкіна</option>
				<option value="Рєпіна">Рєпіна</option>
				<option value="Ринкова">Ринкова</option>
				<option value="Рівна">Рівна</option>
				<option value="Родини Барвінських">Родини Барвінських</option>
				<option value="Рудницького">Рудницького</option>
				<option value="Руська">Руська</option>					
				<option value="Сагайдачного">Сагайдачного</option>
				<option value="Садова">Садова</option>
				<option value="Самчука">Самчука</option>
				<option value="Самчука-бічна">Самчука-бічна</option>
				<option value="Сахарова">Сахарова</option>
				<option value="Симоненка">Симоненка</option>
				<option value="Сікорського">Сікорського</option>
				<option value="Сімовича">Сімовича</option>
				<option value="Сірка">Сірка</option>
				<option value="Січинського">Січинського</option>
				<option value="Січових Стрільців">Січових Стрільців</option>
				<option value="Слівенська">Слівенська</option>
				<option value="Словацького">Словацького</option>
				<option value="Смакули">Смакули</option>
				<option value="Смиківецька">Смиківецька</option>
				<option value="Сонячна">Сонячна</option>
				<option value="Спадиста">Спадиста</option>
				<option value="Спортивна">Спортивна</option>
				<option value="Стадникової">Стадникової</option>
				<option value="Старий ринок">Старий ринок</option>
				<option value="Степана Бандери">Степана Бандери</option>
				<option value="Степана Будного">Степана Будного</option>
				<option value="Степова">Степова</option>
				<option value="Стефаника">Стефаника</option>
				<option value="Стецька">Стецька</option>
				<option value="Стрімка">Стрімка</option>
				<option value="Студинського">Студинського</option>
				<option value="Стуса">Стуса</option>
				<option value="Танцорова">Танцорова</option>
				<option value="Тарнавського">Тарнавського</option>
				<option value="Татарська">Татарська</option>
				<option value="Тбіліська">Тбіліська</option>
				<option value="Текстильна">Текстильна</option>
				<option value="Текстильна 28ч">Текстильна 28ч</option>
				<option value="Тернопільська">Тернопільська</option>
				<option value="Тиха">Тиха</option>
				<option value="Тісна">Тісна</option>
				<option value="Транспортна">Транспортна</option>
				<option value="траса на Смиківці">траса на Смиківці</option>
				<option value="Тролейбусна">Тролейбусна</option>
				<option value="Трудова">Трудова</option>
				<option value="Тютюнника">Тютюнника</option>
				<option value="Урожайна">Урожайна</option>
				<option value="Фабрична">Фабрична</option>
				<option value="Федьковича">Федьковича</option>
				<option value="Фестивальна">Фестивальна</option>
				<option value="Циганка пляж">Циганка пляж</option>
				<option value="Циганська">Циганська</option>
				<option value="Чайковського">Чайковського</option>
				<option value="Чалдаєва">Чалдаєва</option>
				<option value="Чарнецького">Чарнецького</option>
				<option value="Чернівецька">Чернівецька</option>
				<option value="Черняховського">Черняховського</option>
				<option value="Чехова">Чехова</option>
				<option value="Чорновола">Чорновола</option>
				<option value="Чубинського">Чубинського</option>
				<option value="Чумацька">Чумацька</option>
				<option value="Шагайди">Шагайди</option>
				<option value="Шашкевича">Шашкевича</option>
				<option value="Шептицького">Шептицького</option>
				<option value="Шкільна">Шкільна</option>
				<option value="Шкільний перевулок">Шкільний перевулок</option>
				<option value="Шопена">Шопена</option>
				<option value="Шота Руставелі">Шота Руставелі</option>
				<option value="Шпитальна">Шпитальна</option>
				<option value="Шумська">Шумська</option>
				<option value="Шухевича">Шухевича</option>
				<option value="Юності">Юності</option>
				<option value="Юрчака">Юрчака</option>
				<option value="Яреми">Яреми</option>
				<option value="Яремчука">Яремчука</option>
				<option value="Ярмуша">Ярмуша</option>
				<option value="Ясна">Ясна</option>
			</select>
				  </span>
			
				  <span class="one_field">
				  <p class="adres_fild_label">Будинок: <span class="req">*</span></p>
				  <input name="Home" id="adres_3" placeholder="Номер будинку"   type="text">
				  </span>
				  <span class="one_field">
				  <p class="adres_fild_label">Квартира:</p>
				  <input name="room" id="adres_4" placeholder="Номер квартири"   type="text">
				  </span>
				  <span class="one_field">
				  <p class="adres_fild_label">Кількість персон</p>
				  <select name="Кількість_персон" id="person"  >
                      <option value="1" selected="selected">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
					  <option value="14">14</option>
					  <option value="15">15</option>
                      
				  </select>
				  </span>
				  <span class="one_field"><textarea name="comment" id="kylshop_field_comment" placeholder="Ваш комментар:"></textarea></span>
                <input type="hidden" name="productsIds" id="my_products" value="0" required>
                <input type="hidden" name="productsAmount" id="productsAmount" value="0" required>
                <input id="cart_done_but"  class="btn_buy"  value="'.$button_name.'"> 
			</form>
			<div class="note">Всі поля позначені <span class="req">*</span> мають бути вказані</div>
		</div>';
    }

    if(isset($_GET["page"]) && $_GET["page"] == "payments"){ // первая страница корзины

        require_once(ENGINE_DIR . '/modules/kylshop/payments.php');

    }

    $content = '<div id="staticCart">'.$cont.'</div>';
}

############################################
#	Если ГОСТЬ
else{

    $content = '<p>Пожалуйста авторизуйтесь, что бы купить товары на нашем сайте.</p>';
}

$tpl -> set('{listing-goods}', $content);

$tpl -> compile( 'content' );
$tpl -> clear();

?>