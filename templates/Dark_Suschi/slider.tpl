<div class="slider_item" data-img="[xfvalue_image_url_main_img]">

<h2 class="slider_ttl">{title}</h2>
<p class="slider_text">{short-story}</p>
[xfgiven_end_date]
<div id="clockdiv">
	<div class="clock_item">
	  <span id="days"></span>
	  <div id="days_word" class="smalltext">Днів</div>
	</div>
	<div class="clock_item">
	  <span class="hours"></span>
	  <div class="smalltext">Годин</div>
	</div>
	<div class="clock_item">
	  <span class="minutes"></span>
	  <div class="smalltext">Хвилин</div>
	</div>
	<div class="clock_item">
	  <span class="seconds"></span>
	  <div class="smalltext">Секунд</div>
	</div>
  </div>
<div id="end_clock">Акція завершилась</div>
  <script>
		function getTimeRemaining(endtime) {
		  var t = Date.parse(endtime) - Date.parse(new Date());
		  var seconds = Math.floor((t / 1000) % 60);
		  var minutes = Math.floor((t / 1000 / 60) % 60);
		  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
		  var days = Math.floor(t / (1000 * 60 * 60 * 24));
		  return {
			'total': t,
			'days': days,
			'hours': hours,
			'minutes': minutes,
			'seconds': seconds
		  };
		}
		 
		function initializeClock(id, endtime) {
		  var clock = document.getElementById(id);
		  var daysSpan = clock.querySelector('#days');
		  var hoursSpan = clock.querySelector('.hours');
		  var minutesSpan = clock.querySelector('.minutes');
		  var secondsSpan = clock.querySelector('.seconds');
		 
		  function updateClock() {
			var t = getTimeRemaining(endtime);
		 
			daysSpan.innerHTML = t.days;
			hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
			minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
			secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
		 
			if (t.total <= 0) {
			  clearInterval(timeinterval);
			}
		  }
		 
		  updateClock();
		  var timeinterval = setInterval(updateClock, 1000);
		}
		 //[xfvalue_end_date]
		var deadline="[xfvalue_end_date]"; //for Ukraine
		//var deadline = new Date(Date.parse(new Date()) + 15 * 24 * 60 * 60 * 1000); // for endless timer
		initializeClock('clockdiv', deadline);
		
		var days_text = $('#days').text();

if (days_text==="2"&&"3"&&"4") {
	$('#days_word').text("Дні");
	
}else if(days_text==="1"){
	$('#days_word').text("День");

}else{
	$('#days_word').text("Днів");
}

if (Math.sign(days_text)===-1) {
	$('#clockdiv').css({'display':'none'});
	$('#end_clock').css({'display':'block'});
}

		
		</script>
[/xfgiven_end_date]
</div>
