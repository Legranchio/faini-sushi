<?php

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
    die( "Hacking attempt!" );
}



function editConfig($newSettings){

    $new_settings = '';
    $file = ENGINE_DIR . '/modules/kylshop/config.php';

    $handle = @fopen($file, "r");
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {

            $divided = explode('=>', $buffer);

            preg_match('#\"(.+?)\"#is', $divided[0], $sets_name);

//FunctionPublic::Pre($sets_name);
//var_dump($sets_name);

            if($sets_name && isset($newSettings[$sets_name[1]]) && array_key_exists($sets_name[1], $newSettings)){ // если такая настройка найдена

                $newSettings[$sets_name[1]] = str_replace(array("\r\n", "\n", "\r"), array('\r\n', '\n', '\r'), $newSettings[$sets_name[1]]);

                if(is_numeric($newSettings[$sets_name[1]])){ // если чистое число

                    $new_settings .= "\t\"".$sets_name[1]."\" => " . $newSettings[$sets_name[1]] . ',' . PHP_EOL;

                } else if(is_bool($newSettings[$sets_name[1]])){

                    if($newSettings[$sets_name[1]] === true)
                        $new_settings .= "\t\"".$sets_name[1]."\" => true," . PHP_EOL;
                    if($newSettings[$sets_name[1]] === false)
                        $new_settings .= "\t\"".$sets_name[1]."\" => false," . PHP_EOL;

                } else if(is_array($newSettings[$sets_name[1]])){

                    $new_department = "";
                    foreach ($newSettings[$sets_name[1]] as $value) {
                        $new_department .= "\t\"".$value."\", ";
                    }

                    $new_department = substr($new_department, 0, -2);

                    $new_settings .= "\t\"".$sets_name[1]."\" => array('.$new_department.')," . PHP_EOL;

                } else{

                    $new_settings .= "\t\"".$sets_name[1]."\" => '" . $newSettings[$sets_name[1]] . "'," . PHP_EOL;
                }

            } else{
                $new_settings .= $buffer;
            }
        }

        /*echo '<pre>';
        print_r($new_settings);
        echo '</pre>';
        exit;*/


        fclose($handle);

        $fp = fopen($file, "w");
        fwrite($fp, $new_settings);
        fclose($fp);

        return true;

    } else{

        echo "Не могу найти файл по адресу: <b>" . $file . '</b> для изменения настроек!';
        return false;
    }
}

?>