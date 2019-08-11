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
if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
    die( "Hacking attempt!" );
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    /*
    echo '<pre>';
    print_r($new_config);
    echo '</pre>';
    */
    $new_array = array();
    $i = 0;
    foreach ($_POST["fields_params"] as $key => $field) {
        $new_array[$field] = $_POST["fields_values"][$i];
        $i++;
    }
    $kylshop_config = array(
        "form_fields" => json_encode($new_array, JSON_UNESCAPED_UNICODE),
    );
    //echo $new_config["form_fields"];
    editConfig($kylshop_config);
}
$fields = (array)json_decode($kylshop_config["form_fields"]);
$my_fields = "";
foreach ($fields as $key => $item) {
    $fieldInfo = explode("|", $key);
    $fields_name = $item;
    $fields_other = "";
    $required = "";
    if($fieldInfo[0] == "text") $field_type = "Текстове поле (input[type=text])";
    if($fieldInfo[0] == "number") $field_type = "Числове поле (input[type=number])";
    if($fieldInfo[0] == "email") $field_type = "Поле E-mail (input[type=email])";
    if($fieldInfo[0] == "tel") $field_type = "Поле телефон (input[type=tel])";
    if($fieldInfo[0] == "password") $field_type = "Строкове поле (input[type=password])";
    if($fieldInfo[0] == "hidden") $field_type = "Строкове поле (input[type=hidden])";
    if($fieldInfo[0] == "textarea") $field_type = "Багатострокове поле (textarea)";
    if($fieldInfo[0] == "checkbox") $field_type = "Чекбокс (checkbox)";
    if($fieldInfo[0] == "radio") $field_type = "Радіо кнопка (radio)";
    if($fieldInfo[0] == "select") $field_type = "Список (select)";
    if($fieldInfo[0] == "select") {
        $fields_name = "";
        $fields_other = $item;
    }
    if($fieldInfo[2] == "required") $required = "required";
    $my_fields .= '<tr class="sort_tr">
        <td>'.$field_type.'<input type="hidden" name="fields_params[]" value="'.$key.'"><input type="hidden" name="fields_values[]" value="'.$item.'"></td>
        <td>'.$fieldInfo[1].'</td>
        <td>'.$fieldInfo[2].'</td>
        <td>'.$fields_name.'</td>
        <td>'.$fields_other.'</td>
        <td>'.$required.'</td>
        <td width="20"><a href="#" class="movetop"></a><a href="#" class="movebottom"></a><a href="#" class="deleteGoods"></a></td>
    </tr>';
}
echo '<div class="answer_server">'.$answer_server.'</div>
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
                <div class="title">Додаткові поля форми:</div>
            </div>
            <div class="box-content">
                <form action="#" method="POST" class="form_add_fields">
                    <table class="table table-normal form_content">
                        <tr>
                            <th>Тип поля:</th>
                            <th>Iм\'я поля:</th>
                            <th>Назва поля (адмінка):</th>
                            <th>Назва поля:</th>
                            <th>Інші параметри:</th>
                            <th>Обов\'язково?</th>
                            <th width="75"></th>
                        </tr>
                        '.$my_fields.'
                    </table>
                    <br>
                    <a href="#" class="add_field" data-toggle="modal" data-target="#add_field"><i class="icon-plus"></i></a>
                    <input type="submit" class="btn btn-success" value="Зберегти">
                    <a href="#" class="fields_help" data-toggle="modal" data-target="#fields_help">Допомога</a>
                </form>
            </div>
        </div>
    </div>
</div>';
echo '
<div class="modal fade" id="add_field" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Додавання полів в форму оплати</h4>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
                    <label for="field_type" class="col-sm-3 control-label">Тип поля:</label>
                    <div class="col-sm-9">
                        <select name="field_type" id="field_type" class="form-control">
                            <option value="text">Строкове поле (input[type=text])</option>
                            <option value="number">Числовое поле (input[type=number])</option>
                            <option value="email">Поле E-mail (input[type=email])</option>
                            <option value="tel">Поле телефон (input[type=tel])</option>
                            <option value="password">Строкове поле (input[type=password])</option>
                            <option value="hidden">Приховане поле (input[type=hidden])</option>
                            <option value="textarea">Багатострокове поле (textarea)</option>
                            <option value="checkbox">Чекбокс (checkbox)</option>
                            <option value="radio">Радіо кнопка (radio)</option>
                            <option value="select">Список (select)</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field_description" class="col-sm-3 control-label">Iм\'я поля:<br><span class="description_min">(Тільки латинські букви)</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="field_description" id="field_description" class="form-control inp_modal" placeholder="name">
                    </div>
                </div>
                
                <div class="form-group dn_d">
                    <label for="field_name_admin" class="col-sm-3 control-label">Назва поля:<br><span class="description_min">(в адмінпанелі)</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="field_name_admin" id="field_name_admin" class="form-control inp_modal" placeholder="Ім\'я покупця:">
                    </div>
                </div>
                
                <div class="form-group dn_d">
                    <label for="field_name" class="col-sm-3 control-label">Назва поля:<br><span class="description_min">(для користувача)</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="field_name" id="field_name" class="form-control inp_modal" placeholder="Ваше им\'я:">
                    </div>
                </div>
                
                <div class="form-group dn_n">
                    <label for="field_select" class="col-sm-3 control-label">Пункти списку:<br><span class="description_min">(роздыльний знак *)</span></label>
                    <div class="col-sm-9">
                        <textarea name="field_select" class="form-control inp_modal" id="field_select" rows="7" placeholder="Перший пункт*Другий пункт*Третій..."></textarea>
                    </div>
                </div>
                
                <div class="form-group">    
                    <label for="field_required" class="col-sm-3 control-label">Поле обов\'язкове?</label>
                    <div class="col-sm-9">
                        <input type="checkbox" dirname="field_required" id="field_required" name="field_required">
                    </div>
                </div>
                    
                <div class="clr"></div>
                    
                <br>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success add_fields" data-dismiss="modal">Додати</button>
			</div>
		</div>
	</div>
</div>';
// INFO WEBMONEY
echo '
<div class="modal fade" id="fields_help" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Додаткові поля - Допомога</h4>
			</div>
			<div class="modal-body">
				<p>Поле <b>(Ім\'я:)</b> може матитакі значення як:</p>
				<ul>
                    <li><b>user_id</b> - ID користувача (якщо авторизований)</li>
                    <li><b>user_name</b> - Логін користувача (якщо авторизований)</li>
                    <li><b>user_email</b> - E-mail користувача (якщо авторизований)</li>
                    <li><b>user_ip</b> - IP користувача</li>
				</ul>
				<p>Наприклад: <b>name=user_name</b></p>
				<p>- в такому випадку поле має значення name і позамовчуванню туди буде підставлятись логін користувача , якщо той авторизований на сайті</p>
				<br>
				<p>Якщо ви дозволяєте гостям робити покупки</p>
				<ul>
                    <li>Для того щоб в списку покупок було Ім\'я, а не напис ГОСТЬ, вкажіть поле <b>(Назва поля:)</b> таке значення <b>name=user_name</b></li>
                    <li>ЧДля того щоб в списку покупок був E-mail, а не пустота, вкажіть поле <b>(Назва поля:)</b> таке значення <b>email=user_email</b></li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
			</div>
		</div>
	</div>
</div>';