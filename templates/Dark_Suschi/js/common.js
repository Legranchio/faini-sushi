$(function() {

	//SVG Fallback
	if(!Modernizr.svg) {
		$("img[src*='svg']").attr("src", function() {
			return $(this).attr("src").replace(".svg", ".png");
		});
	};

	//E-mail Ajax Send
	//Documentation & Example: https://github.com/agragregra/uniMail
	$(".forms").submit(function() { //Change
		var th = $(this);
		$.ajax({
			type: "POST",
			url: "mail.php", //Change
			data: th.serialize()
		}).done(function() {
			alert("Thank you!");
			setTimeout(function() {
				// Done Functions
				th.trigger("reset");
			}, 1000);
		});
		return false;
	});


	//Chrome Smooth Scroll
	try {
		$.browserSelector();
		if($("html").hasClass("chrome")) {
			$.smoothScroll();
		}
	} catch(err) {

	};

	$("img, a").on("dragstart", function(event) { event.preventDefault(); });

///====TELEGRAM FORM FUNCTIONS===\\\

$(document).ready(function(){
	
		
	$("#cart_done_but").click(function(){
		  var tel = $("#kylshop_field_tel").val();
		   var name = $("#kylshop_field_name").val() ;
		   var adres_1 = $("#adres_1").val() ;
		   var adres_2 = $("#adres_2").val() ;
		   var adres_3 = $("#adres_3").val() ;
		   var adres_4 = $("#adres_4").val() ;
		   var person = $("#person").val() ;

	var costumer_coment_text = $("#kylshop_field_comment").val() ;



			$("#costumer_phone").val(tel);
			$("#costumer_name").val(name);
			$("#costumer_adres1").val(adres_1);
			$("#costumer_adres2").val(adres_2);
			$("#costumer_adres3").val(adres_3);
			$("#person_cont").val(person);

			var inputName = document.getElementById("kylshop_field_tel");
			if (!inputName.value.trim()|| !adres_3 || !adres_2 || !adres_1) {
				alert("Ви мусите вказати всі необхідін дані!!!");
			}else{
				if (adres_4.trim()) {
					$('#customer_room').html('<input type="hidden" class="tele_form_inp" name="Квартира" id="costumer_adres4" value="'+adres_4+'" />');
				};

				var inputName = document.getElementById("kylshop_field_comment");
				if (inputName.value.trim()) {
					$('form#teleform').append('<input type="hidden" class="tele_form_inp" name="Коментар замовника" id="costumer_coment" value="'+costumer_coment_text+'" />');
				};
				
			
$("#teleform").submit();			

}//кінець перевірки телефона на ввід
  
	})

//Підгружаєм вулиці згідно населеного пункту

$('#adres_1').bind('input', function(){

	switch ($(this).val()) {
		case "Березовиця":
		var xmlhttp;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4) {
				document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "/adress/berezovica.html", true);
		xmlhttp.send();
		  break;
	  case "Біла":                   
	  var xmlhttp;
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
		  if (xmlhttp.readyState == 4) {
			  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
		  }
	  }
	  xmlhttp.open("GET", "/adress/bila.html", true);
	  xmlhttp.send();
		  break;
		  case "Великі_Гаї":                   
		  var xmlhttp;
		  xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
			  if (xmlhttp.readyState == 4) {
				  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
			  }
		  }
		  xmlhttp.open("GET", "/adress/big_gayi.html", true);
		  xmlhttp.send();
			  break;
			  case "Гаї_Гречинські":                   
	  var xmlhttp;
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
		  if (xmlhttp.readyState == 4) {
			  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
		  }
	  }
	  xmlhttp.open("GET", "/adress/gayi_gre.html", true);
	  xmlhttp.send();
		  break;
		  case "Гаї_Ходоровські":                   
	  var xmlhttp;
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
		  if (xmlhttp.readyState == 4) {
			  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
		  }
	  }
	  xmlhttp.open("GET", "/adress/gayi_hod.html", true);
	  xmlhttp.send();
		  break;
		  case "Гаї_Шевченківські":                   
	  var xmlhttp;
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
		  if (xmlhttp.readyState == 4) {
			  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
		  }
	  }
	  xmlhttp.open("GET", "/adress/gayi_chev.html", true);
	  xmlhttp.send();
		  break;
		  case "Кутківці":                   
	  var xmlhttp;
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
		  if (xmlhttp.readyState == 4) {
			  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
		  }
	  }
	  xmlhttp.open("GET", "/adress/kutkivcy.html", true);
	  xmlhttp.send();
		  break;
		  case "Острів":                   
	  var xmlhttp;
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
		  if (xmlhttp.readyState == 4) {
			  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
		  }
	  }
	  xmlhttp.open("GET", "/adress/ostriv.html", true);
	  xmlhttp.send();
		  break;
		  case "Петриків":                   
	  var xmlhttp;
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
		  if (xmlhttp.readyState == 4) {
			  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
		  }
	  }
	  xmlhttp.open("GET", "/adress/petriki.html", true);
	  xmlhttp.send();
		  break;
		  case "Підгороднє":                   
		  var xmlhttp;
		  xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
			  if (xmlhttp.readyState == 4) {
				  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
			  }
		  }
		  xmlhttp.open("GET", "/adress/pidgorod.html", true);
		  xmlhttp.send();
			  break;
			  case "Пронятин":                   
			  var xmlhttp;
			  xmlhttp = new XMLHttpRequest();
			  xmlhttp.onreadystatechange = function() {
				  if (xmlhttp.readyState == 4) {
					  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
				  }
			  }
			  xmlhttp.open("GET", "/adress/pron.html", true);
			  xmlhttp.send();
				  break;
				  case "Смиківці":                   
				  var xmlhttp;
				  xmlhttp = new XMLHttpRequest();
				  xmlhttp.onreadystatechange = function() {
					  if (xmlhttp.readyState == 4) {
						  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
					  }
				  }
				  xmlhttp.open("GET", "/adress/smikivcy.html", true);
				  xmlhttp.send();
					  break;
					  case "Чистилів":                   
					  var xmlhttp;
					  xmlhttp = new XMLHttpRequest();
					  xmlhttp.onreadystatechange = function() {
						  if (xmlhttp.readyState == 4) {
							  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
						  }
					  }
					  xmlhttp.open("GET", "/adress/chistilov.html", true);
					  xmlhttp.send();
						  break;
						  case "с.Байківці":                   
						  var xmlhttp;
						  xmlhttp = new XMLHttpRequest();
						  xmlhttp.onreadystatechange = function() {
							  if (xmlhttp.readyState == 4) {
								  document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
							  }
						  }
						  xmlhttp.open("GET", "/adress/baykivci.html", true);
						  xmlhttp.send();
							  break;
							  
		default:
		var xmlhttp;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4) {
				document.getElementById("adres_street").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "/adress/ternopil.html", true);
		xmlhttp.send();
	  }
	
	   
	});


 })

 $("#teleform").submit(function() { //Change
	var th = $(this);
	$.ajax({
		type: "POST",
		url: "/bot.php", //Change
		data: th.serialize()
	}).done(function() {
		
		$("#cart_done_form").submit();		
		setTimeout(function() {
			
			th.trigger("reset");
		}, 1000);
	});
	return false;
});



///====TELEGRAM FORM FUNCTIONS===\\\

$(".add_to_cart").click(function(){
	var more_scroll = $("#top_car_block").height();
	var tat_sum = $(".totalGoods b, #cart .total_amount b").text().substr(0, 1);
	console.log(more_scroll + "=====" + tat_sum + "==>" + $(window).scrollTop() );


if ($(window).scrollTop() >= more_scroll ) {
	$("#scr_crt").css({'right':'0'}); 
}else{
	$("#scr_crt").css({'right':'-220px'});
}


});


$(window).scroll(function(){ 
	var more_scroll = $("#top_car_block").height();
	var tat_sum = $(".totalGoods b, #cart .total_amount b").text().substr(0, 1);
	
if (tat_sum > 0) {
	if ( $(window).scrollTop() >= more_scroll ){ 
		$("#scr_crt").css({'right':'0'});                  
	   //console.log("AGA")         
	}else{
		$("#scr_crt").css({'right':'-220px'}); 
	}
}

	console.log(tat_sum);
 });



	
});
$("body").click(function(){

	$("#scr_crt").css({'right':'-220px'});



});
$(window).load(function() {

	$(".loader_inner").fadeOut();
	$(".loader").delay(400).fadeOut("slow");

});
$('#add_to_cr_fls').click(function(){
	var img = $(this).parents().find('.left_full');
	console.log(img);
    var cart = $('#scr_crt');
    var imgclone = img.clone()
            .offset({
                top: img.offset().top,
                left: img.offset().left
            })
            .css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 50,
                'height': 50
            }, 1300, 'linear');

        imgclone.animate({
            'width': 0,
            'height': 0
        }, function() {
            $(this).detach()
        });  
  });
$('.add_to_cart').click(function(){
	var img = $(this).parents('.grid-item').find('img');
	console.log(img);
    var cart = $('#scr_crt');
    var imgclone = img.clone()
            .offset({
                top: img.offset().top,
                left: img.offset().left
            })
            .css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 50,
                'height': 50
            }, 1300, 'linear');

        imgclone.animate({
            'width': 0,
            'height': 0
        }, function() {
            $(this).detach()
        });  
  });


  var top_block_h = $('#toooop').outerHeight();
console.log(top_block_h);

$("#dle-content").css({'marginTop':top_block_h+30});
$(".scroll_cart").css({'top':top_block_h});

  
    $.get("https://ipinfo.io", function (response) {
        console.log("IP: " + response.ip);   
        console.log("Location: " + response.city + ", " + response.region);
         console.log("Location: " + response.country + ", " + response.region); 
 
    
        console.log(JSON.stringify(response, null, 4));
        
}, "jsonp");
      
        
   