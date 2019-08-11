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
	<link href="https://fonts.googleapis.com/css?family=Jura|Montserrat+Alternates|Noto+Serif|Vollkorn+SC" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Anton|Fredoka+One|Indie+Flower|Luckiest+Guy" rel="stylesheet">
	<link href="/engine/editor/jscripts/froala/fonts/font-awesome.css?v=24" rel="stylesheet" type="text/css">
	
	<script src="{THEME}/libs/modernizr/modernizr.js"></script>

	<link media="screen" href="{THEME}/style/kylshop.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="{THEME}/js/kylshop.js"></script>
   [available=cat]
    <style>
        .grid {
	margin-top: 12%;
}
    </style>
    [/available]
</head>
{AJAX}
<body>
 <!--div id="alert"><p>Сайт працює в тестовому режимі!!!</p></div-->   
<div id="mob_menu_but">

	<img src="{THEME}/img/menu.svg" alt="mob_menu">
</div>
<div id="mob_menu">
		<ul class="mob_menu_it">
			<li><a href="/roli/"><img class="menu_icon" src="{THEME}/icon/sushi.svg" alt="Icon"> Роли</a>
				<ul class="rol_sub_men_mob">
					<li><a href="/roli/orignaln-roli/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">Оригінальні роли</a></li>
					<li><a href="/roli/kalfornja/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">Каліфорнія</a></li>
					<li><a href="/roli/fladelfja/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">філаделфія</a></li>
					<li><a href="/roli/drakoni/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">Дракони</a></li>
				</ul>
			</li>
		<li><a href="/ngr/"><img class="menu_icon" src="{THEME}/icon/unagi-nigiri.svg" alt="Icon">Суші</a></li>
		<li><a href="/nabori/"><img class="menu_icon" src="{THEME}/icon/nabir.svg" alt="Icon">Набори</a></li>
		<li><a href="/salati/"><img class="menu_icon" src="{THEME}/icon/salad-bowl-hand-drawn-food.svg" alt="Icon">Салати</a></li>
		<li><a href="/napoyi/"><img class="menu_icon" src="{THEME}/icon/soda.svg" alt="Icon">Напої</a></li>
		<li><a href="/podarunkov-sertifkati/"><img class="menu_icon" src="{THEME}/img/giftbox.png" alt="Icon">Сертифікати</a></li>
		<li><a class="tell hash" id="" href="/about.html"><img id="deliver_truck" src="{THEME}/icon/sushi-truck.svg" alt=""> Доставка/Контакти </a></li>
			</ul>

</div>
<div id="scr_crt" class="scroll_cart">
	<div class="inside_cart">
			{cart}
	</div>
		

</div>

	
<div class="main_screen">
<div id="toooop" class="top_content ">
<div  class="container-fluid">
	<div class="row">
		<div class="col-md-2">
			<a href="/">
				<img class="dark_logo" src="{THEME}/img/logo.svg" alt="logo">
			</a>
		</div>

		<div class="cont-inf col-md-7 col-xs-12 col-sm-12">
			<a class="tell hash" id="delivery-man" href="/about.html"><img id="deliver_truck" src="{THEME}/icon/sushi-truck.svg" alt=""> Доставка/Контакти </a>
			<a class="tell hash" href="https://www.instagram.com/explore/tags/%D1%84%D0%B0%D0%B9%D0%BD%D1%96_sushi/"><img id="round_phone" src="{THEME}/icon/hashtag.svg" alt=""> #файні_sushi </a>
			<a class="tell" href="tel:0989401010"><img id="round_phone" src="{THEME}/img/kyivstar.svg" alt=""> 0989401010</a>
			<a class="tell" href="tel:0669401010"><img id="round_phone" src="{THEME}/img/Vodafone_2017_logo.svg" alt=""> 0669401010</a>

			
	</div>

	<form id="q_search" class="col-md-3 col-xs-12 col-sm-12" method="post">
			
		<input type="hidden" name="do" value="search">
		<input type="hidden" name="subaction" value="search">
		<div class="sblock">
			<input id="story" name="story" placeholder="Пошук..." type="text" autocomplete="off">
			<button id="sw" type="submit"><span  class="fa fa-search"></span></button>
		</div>
		
	</form>	
<div class="new_top_menu col-md-12 col-xs-12">
	<ul class="top_menu">
		<li id="roli"><a href="/roli/"><img class="menu_icon" src="{THEME}/icon/sushi.svg" alt="Icon"> Роли</a>
		<ul class="rol_sub_men">
			<li><a href="/roli/orignaln-roli/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">Оригінальні роли</a></li>
			<li><a href="/roli/kalfornja/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">Каліфорнія</a></li>
			<li><a href="/roli/fladelfja/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">філаделфія</a></li>
			<li><a href="/roli/drakoni/"><img class="rol_sub_img" src="{THEME}/icon/sushi.svg" alt="Icon">Дракони</a></li>
		</ul>
		
		</li>
		<li><a href="/ngr/"><img class="menu_icon" src="{THEME}/icon/unagi-nigiri.svg" alt="Icon">Суші</a></li>
		<li><a href="/nabori/"><img class="menu_icon" src="{THEME}/icon/nabir.svg" alt="Icon">Набори</a></li>
		<li><a href="/salati/"><img class="menu_icon" src="{THEME}/icon/salad-bowl-hand-drawn-food.svg" alt="Icon">Салати</a></li>
		<li><a href="/napoyi/"><img class="menu_icon" src="{THEME}/icon/soda.svg" alt="Icon">Напої</a></li>
		<li><a href="/podarunkov-sertifkati/"><img class="menu_icon" src="{THEME}/img/giftbox.png" alt="Icon">Сертифікати </a></li>
		<!--<li><a href="/seti/">Сети</a></li-->

	</ul>

</div>

	</div>
</div>

</div>
<div class="arr_dovn">
	<img class="animated infinite bounce delay-2s" src="{THEME}/img/thin-arrowheads-pointing-down.svg" alt="Down">
</div>
	[available=main]
	<div class="fotorama" data-width="100%"  data-height="100%" data-minheight="200px" data-fit="cover"
	 data-nav="falase" data-loop="true" data-autoplay="3500" data-stopautoplayontouch="true">
			
	{custom  category="16"  template="slider"   from="0" limit="5 fixed="no" order="date" sort="desc" cache="no"}
		
		
		</div>
		[/available]
</div>






<div class="container">
		
	<div class="row">
        [available=main]
   <p id="seo_main_text" class="main_text">Всім привіт! Ми молода креативна команда поварів, які люблять свою справу, і саме цим підкоримо Вас. 
       Ми створили доставку «Файні_sushi» за допомогою якої здивуємо найсмачнішими суші у Тернополі Головний пріоритет – висока якість їжі та сервісу.
       Ми ретельно обираємо постачальників продуктів, а наші кухарі дбають про кожну деталь. 
       Ми не використовуємо повторну заморозку риби, в результаті чого вона зберігає насичений смак та свіжість. 
       Секретом дивного, неповторного смаку страв японської кулінарії є поєднання свіжих і якісних морепродуктів, найніжніших видів сиру, рису, 
       приготованого за східними традиціями і корисних овочів, багатими вітамінами. Ні для кожного не секрет , що у нашому місті є безліч різних доставок , 
       але саме ми запропонуємо для вас унікальні роли.Тому що ви варті цього
       
       
       <a href="https://www.instagram.com/explore/tags/%D1%84%D0%B0%D0%B9%D0%BD%D0%B8%D0%BC_%D0%BB%D1%8E%D0%B4%D1%8F%D0%BC_%D1%84%D0%B0%D0%B9%D0%BD%D1%96_%D1%81%D1%83%D1%88%D1%96/">#файним_людям_файні_суші</a>
       <br>
Дякуємо що обрали нас.... </p>     
        [/available]
        
			[available=cat|main|search]
<div class="grid">
		{info}{content}

</div>
[/available]


[available=showfull|cart|static]
{info}{content}
[/available]


	</div>
</div>
<footer>
<div class="container">
	<div class="row">
<div class="col-md-12 col-xs-12">
		<a class="footera" href="/">
			<img class="footer_logo" src="{THEME}/img/logo.svg" alt="logo">
		</a>

<ul class="social">
		<li class="social__item"><a class="social__link" rel="nofollow" href="https://www.facebook.com/faini.sushi.te/"><i class="social__icon fa fa-facebook"></i></a></li>
		<li class="social__item"><a class="social__link" rel="nofollow" href=""><i class="social__icon fa fa-google-plus"></i></a></li>
		<li class="social__item"><a class="social__link" rel="nofollow" href="https://www.instagram.com/faini_sushi/"><i class="social__icon fa fa-instagram"></i></a></li>
		<li class="social__item"><a class="social__link" rel="nofollow" href=""><i class="social__icon fa fa-youtube"></i></a></li>                      
	</ul>
	
	<!--ul class="footer_menu">
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
		<li><a href="">MENU</a></li>
			</ul-->
<div class="legran">Сайт створено у вебстудії <a href="https://t.me/legranchio">Legranchio</a> Тернопіль-2018</div>			
</div>

	</div>
</div>

</footer>


	<div class="hidden">
<form id="teleform">
<input id="costumer_name" type="hidden" name="Ім'я замовника">
<input id="costumer_phone" type="hidden" name="Телефон">
<input id="costumer_adres1" type="hidden" name="Місто/село">
<input id="costumer_adres2" type="hidden" name="Вулиця">
<input id="costumer_adres3" type="hidden" name="Будинок">
<span id="customer_room"></span>
<input id="person_cont" type="hidden" name="Кількість_персон">
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


	<link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
	
	<script src="{THEME}/js/masonry.pkgd.js"></script>
	<script src="{THEME}/js/imagesloaded.pkgd.js"></script>
	<script src="{THEME}/js/jquery-imagefill.js"></script>


	<script>
		// init Masonry after all images have loaded
		var $grid = $('.grid').imagesLoaded( function() {
		  $grid.masonry({
			itemSelector: '.grid-item',
			percentPosition: true,
			  originTop: true,
		   columnWidth: $grid.find('.grid-item')[0]
		  }); 
		});
		$(document).ready(function() {
		
			var $container = $(".masonry-container");
			$container.imagesLoaded(function () {
				$container.masonry({
					columnWidth: ".item",
					itemSelector: ".item"
				});
				//$(".item").imagefill();
			});
			});
		
		</script>


<script>
		$('.itm_img').click(function() {
			window.location = $(this).data('target-page');
		});
		</script>


	[available=cart]
	<script type="text/javascript">
		$(document).ready(function() {
			$("#kylshop_field_tel").inputmask("+38(999)999-99-99");

			 $('html, body').animate({ scrollTop: $("#dle-content").offset().top }, 500); 
			 $("#scr_crt").remove();
		});     
	    
  

		</script>
[/available]
		
<script>
$(document).ready(function(){

$( ".arr_dovn" ).on( "click", function() {
 
   var top = $("#seo_main_text").offset().top;
  $('body,html').animate({scrollTop: top}, 1500);
  
});			
		});
		</script>
<script>
$(document).ready(function () {
	$('#mob_menu_but').click(function (e) {
		var link = $('#smenu');
		$(this).toggleClass('active');           
		$('#mob_menu').toggle();                           
		e.stopPropagation();
		
		
	});		
	$('body').click(function () {
		var link = $('#mob_menu_but');
		if (link.hasClass('active')) {
			link.click();
			//$('#smenu').text('Показать еще');
		}
	});
});
</script>>

</body>

</html>