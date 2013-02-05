jQuery(document).ready(function($){
	rescarousel();
	  var slider=jQuery('#slider').bxSlider({
		  auto:true,
	      pause:9000,
		  touchEnabled:true,
		  swipeThreshold:50,
	      speed:800,
		  controls:false
	  });
	  jQuery(window).resize(function(){
		rescarousel();
	  });
	  function rescarousel(){
		_winW = $(window).width();
		_winH = $(window).height();
		var newH = (_winH - _headerHeight - 200);
		var imH = 550;
		if(newH < imH){
			$('#slider').find('div.carousel-img').each(function(){
				$(this).height(newH);
				jQuery('.bx-viewport').height(newH);
			});
		}else{
			$('#slider').find('div.carousel-img').each(function(){
				$(this).height(imH);
				jQuery('.bx-viewport').height(imH);
			});
		}
	  }
  });
