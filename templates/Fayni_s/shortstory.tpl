<div id="product{news-id}" class="item col-xs-12 col-sm-6 col-md-4 col-lg-3">
	[full-link]
	<div class="product-thumb">

		<div class="image wow zoomInUp">
			<img src="[xfvalue_image_url_main_img]" alt="{title}" title="{title}" class="img-responsive">
		</div>
		[/full-link]
		<div>
			<h3 class="item_ttl">{title}</h3>

			[kylshop]<span class="item_price">{price} грн.</span>

			<!--a href="#" class="b_but">До кошика</a-->
			{add-to-cart}[/kylshop]

		</div>

	</div>
	
</div>

<!--script type="text/javascript">
$(document).ready(function(){
    $("#toCartBtn{news-id}").click(function(){ 
			
top_cor =  Math.floor($("#itimg{news-id}").offset().top - $(window).scrollTop() );
 left_cor = Math.floor($("#itimg{news-id}").offset().left);
 var p = $("#itimg{news-id}");
var position = p.position();
var x_pos = position.top + $(window).scrollTop();
var y_pos = position.left - $(document).width();
 
console.log(x_pos);	
console.log(position);	
$("#itimg{news-id}")
.clone()
//.appendTo("body")
.css({'position' : 'absolute', 'z-index' : '9999999', 'width' : '150px', 'height' : 'auto', 'left' : ''+y_pos+'px', 'top': ''+x_pos+'px'})
.prependTo("#scr_crt")   
.animate({opacity: 0.8, top: 0 , left: 0,  width: 50,  height: 50}, 3800,
	 function() { 
                $(this).remove();
            });//anmf
        });//clf
    });//drf
</script-->