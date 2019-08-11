<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="ru">
<!--<![endif]-->

<head>

	<meta charset="utf-8">

	{headers}

	<link rel="shortcut icon" href="{THEME}/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="{THEME}/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="{THEME}/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="{THEME}/img/favicon/apple-touch-icon-114x114.png">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" href="{THEME}/libs/bootstrap/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="{THEME}/libs/animate/animate.css">

	<link rel="stylesheet" href="{THEME}/css/fonts.css">
	<link rel="stylesheet" href="{THEME}/css/main.css">
	<link rel="stylesheet" href="{THEME}/css/media.css">
	[available=cart]<link href="/engine/editor/jscripts/froala/fonts/font-awesome.css?v=24" rel="stylesheet" type="text/css">[/available]
	
	<script src="{THEME}/libs/modernizr/modernizr.js"></script>

	<link media="screen" href="{THEME}/style/kylshop.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="{THEME}/js/kylshop.js"></script>
</head>
{AJAX}
<body>
<div id="scr_crt" class="scroll_cart">
	<div class="inside_cart">
			{cart}
	</div>
		

</div>

	<div id="top_car_block"  class="top_block container-fluid">
		<div class="row">
				<form id="q_search" class="col-md-3 col-xs-12 col-sm-12" method="post">
						<input type="hidden" name="do" value="search">
						<input type="hidden" name="subaction" value="search">
						<div class="sblock">
							<input id="story" name="story" placeholder="Пошук..." type="text" autocomplete="off">
							<button id="sw" type="submit"><span  class="fa fa-search"></span></button>
						</div>
						
					</form>	
		<div class="cont-inf col-md-6 col-xs-12 col-sm-12">
				<a class="tell hash" id="delivery-man" href="#файні_sushi"><img id="round_phone" src="{THEME}/img/delivery-man.svg" alt=""> Доставка </a>
				<a class="tell hash" href="#файні_sushi"><img id="round_phone" src="{THEME}/img/hashtag.svg" alt=""> #файні_sushi </a>
				<a class="tell" href="tel:0989401010"><img id="round_phone" src="{THEME}/img/auricular-phone-symbol-in-a-circle.svg" alt=""> 0989401010</a>
<!--ul class="cont_inf">
	<li><a href=""></a></li>
	<li><a href=""></a></li>
	<li><a href="#">38097111-22-33</a></li>
</ul-->

		</div>			
					
		<div  class="cart col-md-3 col-xs-12 col-sm-12">
				{cart}
			
		</div>	
		</div>
			
	</div>



<div class="top_dark_line">
	<a href="/">
		<img class="dark_logo" src="{THEME}/img/logo.png" alt="logo">
	</a>	
</div>
<div class="menu_blok">
	<h4 class="menu_h4">МЕНЮ</h4>
	<ul class="top_menu">
		<li><a href="/roli/">Роли</a></li>
		<li><a href="/fladelfja/">Філадаельфія</a></li>
		<li><a href="/kalfornja/">каліфорнія</a></li>
		<li><a href="/orignaln-roli/">оригінальні роли</a></li>
		<li><a href="/ngr/">Нігірі</a></li>
		<li><a href="/gunkani/">Гункани</a></li>
		<li><a href="/seti/">Сети</a></li>

	</ul>

</div>
[available=cat|main]
<div class="fotorama" data-width="100%" data-autoplay="true" data-maxheight="550px" data-minheight="200px" data-fit="cover">
		<img src="{THEME}/img/263182-P4REUR-410.jpg" alt="sss">
		<img src="{THEME}/img/6016.jpg" alt="sss">
		<img src="{THEME}/img/OANUZZ0.jpg" alt="sss">
	</div>
	[/available]

<div class="container">
		
	<div class="row">

{info}{content}

	</div>
</div>
<footer>
<div class="container">
	<div class="row">
<div class="col-md-12 col-xs-12">
		<a class="footera" href="/">
			<img class="footer_logo" src="{THEME}/img/logo.png" alt="logo">
		</a>

<ul class="social">
		<li class="social__item"><a class="social__link" rel="nofollow" href="https://www.facebook.com/faini.sushi.te/"><i class="social__icon fa fa-facebook"></i></a></li>
		<li class="social__item"><a class="social__link" rel="nofollow" href=""><i class="social__icon fa fa-google-plus"></i></a></li>
		<li class="social__item"><a class="social__link" rel="nofollow" href="https://www.instagram.com/faini_sushi/"><i class="social__icon fa fa-instagram"></i></a></li>
		<li class="social__item"><a class="social__link" rel="nofollow" href=""><i class="social__icon fa fa-youtube"></i></a></li>                      
	</ul>
	
	<ul class="footer_menu">
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
			</ul>
			
</div>

	</div>
</div>

</footer>


	<div class="hidden">
<form id="teleform">
<input id="costumer_name" type="hidden" name="Ім'я замовника">
<input id="costumer_phone" type="hidden" name="Телефон">
<input id="teleform_total" type="hidden" name="Загальна вартість замовлення">

</form>

	</div>



	<div class="loader">
		<div class="loader_inner"></div>
	</div>

	<!--[if lt IE 9]>
	<script src="{THEME}/libs/html5shiv/es5-shim.min.js"></script>
	<script src="{THEME}/libs/html5shiv/html5shiv.min.js"></script>
	<script src="{THEME}/libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="{THEME}/libs/respond/respond.min.js"></script>
	<![endif]-->

	
	<script src="{THEME}/libs/waypoints/waypoints.min.js"></script>
	<script src="{THEME}/libs/animate/animate-css.js"></script>
	<script src="{THEME}/libs/plugins-scroll/plugins-scroll.js"></script>

	<script src="{THEME}/js/common.js"></script> 
	<script src="{THEME}/js/jquery.inputmask.js"></script>


	<link href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
	
	<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
	[available=cart]
	<script type="text/javascript">
		$(document).ready(function() {
			$("#kylshop_field_tel").inputmask("+38(999)999-99-99");

			 $('html, body').animate({ scrollTop: $("#dle-content").offset().top }, 500); 
			 $("#scr_crt").remove();
		});     
	    
  

		</script>
[/available]
		

</body>

</html>