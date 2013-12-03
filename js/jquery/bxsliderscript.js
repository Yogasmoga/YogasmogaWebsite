var slider;
jQuery(document).ready(function($){
	rescarousel();
	  slider=jQuery('#slider').bxSlider({
	       /*
		  auto:false,
		  //autoHover:true,
	      pause:7000,
		  touchEnabled:true,
		  swipeThreshold:50,
	      speed:800,
		  controls:false
          */
          auto:false,
	      pause:7000,
		  touchEnabled:false,
	      speed:800,
		  controls:false
	  });
	
    $("#slider").swipe({
            swipeLeft:function(event, direction, distance, duration, fingerCount) 
        {
            slider.stopAuto();
            slider.startAuto();                        
            slider.goToNextSlide();
        },
    swipeRight:function(event, direction, distance, duration, fingerCount) 
        {
            slider.stopAuto();
            slider.startAuto(); 
            slider.goToPrevSlide();
        }
        });
        
    if(_onipad)
    {
        $("button.btn-explore.button").swipe({
            swipeStatus:function(event, phase, direction, distance, duration, fingerCount) {
                if(phase=="start")
                {
                    window.location.href = $(this).attr('redirecturl');
                    
                }
               
              },
            threshold:1
        });    
    }
        
        
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
