<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.3
 * =================================
 * info: формирование заказа
 * и готовность к оплате
 * =================================
 **/

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

include ('engine/api/api.class.php');
require_once ENGINE_DIR . '/modules/kylshop/config.php';
require_once ENGINE_DIR . '/modules/kylshop/functions.php';

//header('HTTP/1.1 200 OK');

if(!empty($_POST["productsIds"]) && !empty($_POST["productsAmount"])){

	$fields = json_encode($_POST, JSON_UNESCAPED_UNICODE);

	#######################################
	#   получаем url новости
	function GetLink($id, $category, $alt_name, $date){
		if( $config['allow_alt_url'] ) {
			if( $config['seo_type'] == 1 OR $config['seo_type'] == 2  ) {
				if( $category and $config['seo_type'] == 2 ) {
					$full_link = $config['http_home_url'] . get_url( $category ) . "/" . $id . "-" . $alt_name. ".html";
				} else {
					$full_link = $config['http_home_url'] . $id . "-" . $alt_name . ".html";
				}
			} else {
				$full_link = $config['http_home_url'] . date( 'Y/m/d/', $date ) . $alt_name . ".html";
			}
		} else {
			$full_link = $config['http_home_url'] . "index.php?newsid=" . $id;
		}
		return $full_link;
	}
	#   получаем url новости end
	#######################################

	//productsIds - id новостей через запятую
	//productsAmount - количество товаров определённых id  в том же порядке как и productsIds

	//$rows_buy = $dle_api -> load_table (PREFIX."_kylshop_buy", '*', '1', true, 0, false, 'id', 'DESC');
	$general_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="general"', true, 0, 1);
	$webmoney_settings = $dle_api -> load_table (PREFIX."_kylshop_settings", 'settings', 'name="webmoney"', true, 0, 1);

	# приём и обработка данных с формы
	$_GS = unserialize($general_settings[0]["settings"]);
	$_WM = unserialize($webmoney_settings[0]["settings"]);

	$productsIds = trim(htmlspecialchars(strip_tags($_POST["productsIds"])));
	$productsAmount = trim(htmlspecialchars(strip_tags($_POST["productsAmount"])));
	$productsIds = str_replace(array("/", "'", '"', "UNION"), "", $productsIds);
	$productsAmount = str_replace(array("/", "'", '"', "UNION"), "", $productsAmount);

	$productsIdsArr = explode(",", $productsIds);
	$productsAmount = explode(",", $productsAmount);

	#####################
	# default
	$products = "";
	$tmp = 0;
	$tmp_count_news = 1;
	$price = 0;
	$productName = "";
	$total = 0;
	$clear_cart = '<script>
	localStorage.clear();
	$(".oneGoods").remove();
	$(".allPrice b").text("0");
	$("#cart .number_goods").html(\'<b>0</b> шт.\');
	$(".totalGoods b, #cart .total_amount b").text(\'0\');
	
	</script>';
	#####################

	# перебор всех переданных id
	foreach ($productsIdsArr as $val) {
		if(!empty($val)){
			if($tmp === 0){
				$products .= "`id`='" . $val . "'";
				$tmp = 1;
			} else{
				$products .= " OR `id`='" . $val ."'";
				$tmp_count_news++;
			}
		}
	}

	$news_info = $dle_api -> load_table (PREFIX."_post", '*', $products, true, 0, 0, 'id', 'DESC');

	if($tmp_count_news == 1){ # если чел покупает только один товар
		$xfields = xfieldsdataload($news_info[0]['xfields']);
		$description = base64_encode("Оплата товара: " . $xfields["goods_description"]); // название товара
	} else # если он покупает несколько товаров
		$description = base64_encode("Оплата товаров на сайте: " . $config["home_title"]); // название товара

	# перебираем товар
	$i = 0;
	foreach (array_reverse($news_info) as $row) {
		$xfields = xfieldsdataload($row['xfields']);
		$productName .= ' <a href="'.GetLink($row["id"], $row["category"], $row["alt_name"], $row["date"]).'">' . $xfields["goods_description"] . '</a> (' . $productsAmount[$i][0] . ' шт.)<br>';
		$total = (float)$total + ((float)$xfields["price"] * (float)$productsAmount[$i][0]);
		$i++;
	}

	$count_orders = file_get_contents(ENGINE_DIR . '/modules/kylshop/count_orders.txt'); // номер покупки

	$order_number = (int)$count_orders + 1;

	$fp = fopen(ENGINE_DIR . '/modules/kylshop/count_orders.txt', 'w'); //перезаписываем номер покупки в файл count.txt
	fwrite($fp, $order_number);
	fclose($fp);

	# генерируем уникальный идентификатор платежа
	$UNIQUE_ID_PAYMENT = sha1($_GS["secret_key"] . $total . $count_orders);

	# выборка новостей с id, который передан
	$isset_buy = $dle_api -> load_table (PREFIX."_kylshop_buy", 'status', "secret_key='".$UNIQUE_ID_PAYMENT."'", true, 0, 1);

	$date = date("Y-m-d H:i:s", time());

	$sign = md5($kylshop_config["freekassa_id"] . ':' . $total . ':' . $kylshop_config["secret_word1"] . ':' . $count_orders);
	$signdb = md5($kylshop_config["freekassa_id"].':'.$total.':'.$kylshop_config["secret_word2"].':'.$count_orders);

	$fields_json = json_decode($fields);
	/*echo '<pre>';
	print_r($fields -> email);
	echo '</pre>';
	exit;*/

	$tmp_name = "";

	if($is_logged == "1"){ // если пользователь авторизирован
		$user_name = $member_id["name"];
		$user_email = $member_id["email"];
	} else{ // если гость
		if($fields_json -> name != null) $user_name = $fields_json -> name."*";
		else $user_name = "Гость*";
		if($fields_json -> email != null) $user_email = $fields_json -> email;
		else $user_email = $fields_json -> tel;









		/**
		 * @description если гостю разрешено покупать товары, то заносим ID товаров в COOKIE
		 * */

		if(isset($_COOKIE["bought"])){

			$bought_array = json_decode($_COOKIE["bought"]);

			$bought_array = (array)$bought_array;

			foreach ($productsIdsArr as $item) {

				if(!in_array($item, $bought_array)){ // если такой id товара ещё нет в памяти

					$bought_array[$futer_arr] = $item;

					//array_push($electe_array, $_POST["electe"]); // добавляем новый id

				} else if(in_array($item, $bought_array)){ // если в массиве уже есть такой ключ

					$key = array_search($item, $bought_array);
					unset($bought_array[$key]); // удаление id из массива
				}
			}

			$result_bought = json_encode($productsIdsArr);

		} else {

			$result_bought = json_encode($productsIdsArr);

		}

		SetCookie("bought", $result_bought, time() + 3600 * 24 * 30, "/"); // на неделю


		/**
		 * @description для запоминания пользователя
		 * */
		if(!isset($_COOKIE["tmp_name"])){ // если нет ещё куков tmp_name, создаем их
			$tmp_name = date("H-i-s_".round(microtime(true) * 1000), time());
			SetCookie("tmp_name", $tmp_name, time() + 3600 * 24 * 30, "/"); // на неделю
		} else{ // или продливаем
			$tmp_name = $_COOKIE["tmp_name"];
		}
















	}

	$db -> query( "INSERT INTO " . PREFIX . "_kylshop_buy (number, name, tmp_name, email, description, fields, news_id, sum, date, secret_key, secret_key_freekassa, status)
		VALUES ('{$count_orders}', '{$user_name}', '{$tmp_name}', '{$user_email}', '{$productName}', '{$fields}', '{$productsIds}', '{$total}',
		'{$date}', '{$UNIQUE_ID_PAYMENT}', '{$signdb}', '0')" );


	if($_MS["online_payments"] == "on"){


		// FREE-KASSA
		$freekassa_url = "http://www.free-kassa.ru/merchant/cash.php?m=" . $kylshop_config["freekassa_id"] . "&oa=" . $total . "&o=" . $count_orders . "&s=" . $sign;

		$form = '<br><div class="clr"></div>
	<form method="POST" id="payment" action="https://merchant.webmoney.ru/lmi/payment.asp" accept-charset="utf-8">  
		<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$total.'" required>
		<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="'.$description.'">
		<input type="hidden" name="LMI_PAYMENT_NO" value="'.$count_orders.'">
		<input type="hidden" name="LMI_PAYEE_PURSE" value="'.$_WM["purse"].'">
		<input type="hidden" name="LMI_SIM_MODE" value="0">
		<input type="hidden" name="kylshop" value="true">
		<input type="hidden" name="payment_description" value="'.$xfields["goods_description"].'">
		<input type="hidden" name="user_id" value="'.$member_id["user_id"].'">
		<input type="hidden" name="name" value="'.$member_id["name"].'">
		<input type="hidden" name="user_email" value="'.$member_id["email"].'">
		<input type="hidden" name="goods_ids" value="'.$productsIds.'">
		<input type="submit" class="go_payments" value=""> 
	</form>
	<a href="'.$freekassa_url.'" target="_blank" class="free_kassa"></a>';

		/*
        <a href="#" class="free_kassa" onclick="load_form()"></a>
        <script src="//www.free-kassa.ru/widget/w.js"></script>

        <script type="text/javascript">
            function load_form() {
                var form = new FK();
                form.loadWidget({
                    merchant_id: "'.$kylshop_config["freekassa_id"].'",
                    amount: "'.$total.'",
                    order_id: "'.$count_orders.'",
                    email: "'.$member_id["email"].'",
                    sign: "'.md5($kylshop_config["freekassa_id"].$kylshop_config["secret_word1"]).'",
                    us_user: '.$member_id["user_id"].',
                    us_desc: "'.$xfields["goods_description"].'",
                });
            }
        </script>
        */


		/*
            $sign = md5($config["freeKassa_MerchantId"] . ':' . $total_sum . ':' . $config["freeKassa_word1"] . ':' . $number_order);

            header("Location: http://www.free-kassa.ru/merchant/cash.php?m=" . $config["freeKassa_MerchantId"] . "&oa=" . $total_sum . "&o=" . $number_order . "&s=" . $sign);
        */
		// md5('MerchantId:price:secretWord:numberOrder')
		// http://www.free-kassa.ru/merchant/cash.php?m=38920&oa=15&o=1&s=5778199f7b7d2bb79e4117d5e12285d9



		$cont = '<h1>Выбрать способ оплаты</h1>
    <div class="totalGoods paymentstotal">Всего к оплате: <b>0</b><span> руб.</span></div>
    ' . $form;

	} else{

		$cont = $kylshop_config["text_after_offer"];

	}
}







/*

// Скрытая реакция на получение запроса от сервера free-kassa
    if(!empty($_GET["payment"]) && $_GET["payment"] == "free-kassa" && !empty($_GET["responce"]) && $_GET["responce"] == "result"){

        if(!empty($_POST["MERCHANT_ORDER_ID"]) && !empty($_POST["AMOUNT"]) && !empty($_POST["SIGN"])){

            function getIP() {
                if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
                    return $_SERVER['REMOTE_ADDR'];
            }

            if (!in_array(getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189')))
                exit("hacking attempt!");

            // "ID Вашего магазина:Сумма платежа:Секретное слово 2:Номер заказа"
            $sign = md5($config['freeKassa_MerchantId'].':'.$_REQUEST['AMOUNT'].':'.$config["freeKassa_word2"].':'.$_REQUEST['MERCHANT_ORDER_ID']);

            $orderInfo = DB::run("SELECT * FROM " . PREFIX_ . "orders WHERE hash_sign = ?", array($sign)) -> fetch();

            $seller = json_decode($orderInfo["seller"]);
            $userInfo = DB::run("SELECT * FROM " . PREFIX_ . "users WHERE login = ?", array($seller -> seller)) -> fetch();

            if($orderInfo){

                $resultMoney = $userInfo["money"] + $_REQUEST['AMOUNT'];

                $query_user = array(
                    "money" => $resultMoney
                );

                if($seller -> service == "turboliker.ru")
                    $query_user["e_money_turboliker"] = $userInfo["e_money_turboliker"] + $_REQUEST['AMOUNT'];
                if($seller -> service == "likest.ru")
                    $query_user["e_money_likest"] = $userInfo["e_money_likest"] + $_REQUEST['AMOUNT'];
                if($seller -> service == "eliker.ru")
                    $query_user["e_money_eliker"] = $userInfo["e_money_eliker"] + $_REQUEST['AMOUNT'];

                // обновляем статус покупки если такой есть
                $result_order = DB::db_update(PREFIX_ . "orders", array(
                    "hash_sign" => json_encode($_POST),
                    "status" => "3",
                    "date" => date("d-m-Y H:i:s", time()),
                    "time" => time()
                ), array("hash_sign" => $sign));

                $result_update_goods = DB::db_update(PREFIX_ . "goods", array(
                    "status" => "2",
                    "who_bought" => $orderInfo["login"],
                    "time" => date("d-m-Y", time())
                ), array("id" => $orderInfo["goods_id"]));

                DB::db_update(PREFIX_ . "users", $query_user, array("login" => $seller -> seller));

                if($result_order && $result_update_goods){

                    // отправляем купленый товар покупателю
                    $body = 'Ваш товар: <b>' . $orderInfo["resulting_code"] . '</b>';
                    sendEmail($orderInfo["email"], $config["replyTo"], "Ваша покупка", $body, $config);

                    // отправляем купленый товар покупателю
                    $body2 = 'Только что купили Ваш товар от сервиса <b>' . $seller -> service . '</b> на сумму: <b>' . $_REQUEST['AMOUNT'] . ' рублей.</b><br>
                    Общий баланс составляет: <b>' . $resultMoney . ' рублей.</b>';
                    sendEmail($userInfo["email"], $config["replyTo"], "Вы заработали " . $_REQUEST['AMOUNT'] . " р.", $body2, $config);
                }

                //$fp = fopen(ROOT . 'test.txt', "w");
                //flock($fp, LOCK_EX);
                //fwrite($fp, json_encode($_POST) . "\n\r" . $sign . "\n\r" . $_SERVER["REMOTE_ADDR"]);
                //flock($fp, LOCK_UN);

header("HTTP/1.0 200 OK");

}

}
exit;
}

*/

