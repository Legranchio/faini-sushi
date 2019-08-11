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
	var costumer_coment_text = $("#kylshop_field_comment").val() ;



			$("#costumer_phone").val(tel);
			$("#costumer_name").val(name);

			var inputName = document.getElementById("kylshop_field_tel");
			if (!inputName.value.trim()) {
				alert("Ви мусите вказати ваш телефон");
			}else{
				var inputName = document.getElementById("kylshop_field_comment");
				if (inputName.value.trim()) {
					$('form#teleform').append('<input type="hidden" class="tele_form_inp" name="Коментар замовника" id="costumer_coment" value="'+costumer_coment_text+'" />');
				}

			
$("#teleform").submit();			

}//кінець перевірки телефона на ввід
  
	})
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

$(window).load(function() {

	$(".loader_inner").fadeOut();
	$(".loader").delay(400).fadeOut("slow");

});

$('.add_to_cart').click(function(){
    var img = $(this).parents('.product-thumb').find('img');
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