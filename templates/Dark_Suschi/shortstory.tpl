<div  class="grid-item item col-xs-12 col-sm-6 col-md-3 col-lg-4" >
	<img class="itm_img" src="[xfvalue_image_url_main_img]" alt="{title}" title="{title}" data-target-page="{full-link}" >
		

		<div class="item_detail">
[full-link]
				<h3 class="item_ttl">{title} </h3>	
		
				[kylshop]
				<span class="item_price big_price">{price} грн.</span>
				[not-category=21]	<span class="item_price"> {price} грн.</span>
				
				  	<ul class="item_desc">
					    <li>[xfvalue_files] - шт</li>
					<li>[xfvalue_ccy] - <span id="opttxt{news-id}">гр</span></li>
                    
				</ul>[/not-category]

			[/full-link]
								{add-to-cart}[/kylshop]
		</div>
		
	<script>
	var cat_name ="{category}";

	if (cat_name ==="Напої") {
		$("#opttxt{news-id}").text("мл");
	};
	
	</script>
</div>

