<?php
/**
 * =================================
 * @copyright (c) 2015 Kylaksizov.ru
 * @link http://kylaksizov.ru/
 * =================================
 * @version 0.0.1
 * =================================
 * info: навигация
 * =================================
 **/

$result_count = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_kylshop_buy");

$start_from = @ceil( $result_count['count'] / $kylshop_config["limit_orders"] );

if(isset($_GET["page"]))
    $page = $_GET['page'] - 1;
else
    $page = 0;

$start_select = abs($page * $kylshop_config["limit_orders"]);


if($result_count['count'] > $kylshop_config["limit_orders"]){

	$previous = $config["http_home_url"] . "admin.php?mod=kylshop";

	$pagination = '<ul class="pagination">';

    for ($i = 1; $i <= $start_from; $i++) {

        if($i == 1){

        	if(isset($_GET["page"]) && $_GET["page"] != 1 && $_GET["page"] != 2)
            	$pagination .= '<li><a href="'.$previous.'&page='.($_GET["page"]-1).'">&laquo;</a></li>';
            else
            	$pagination .= '<li><a href="'.$previous.'">&laquo;</a></li>';
        } else{

            $pagination .= '<li><a href="'.$previous.'&page='.$i.'">'.$i.'</a></li>';
        }
    }

    if(!isset($_GET["page"]))
    	$pagination .= '<li><a href="'.$previous.'&page=2">&raquo;</a></li>';
    else if(isset($_GET["page"]) && $_GET["page"] != ($i-1))
    	$pagination .= '<li><a href="'.$previous.'&page='.($_GET["page"]+1).'">&raquo;</a></li>';
    else
    	$pagination .= '<li><a href="'.$previous.'&page='.($start_from).'">&raquo;</a></li>';

    $pagination .= '</ul>';

} else{

    $pagination = "";
}

?>