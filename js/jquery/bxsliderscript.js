jQuery(document).ready(function($){
	_winH = $(window).height();
	jQuery('#slider').find('img.bximg').each(function(){
		$(this).height(_winH - 80)
	})
	  var slider=jQuery('#slider').bxSlider({
		  auto:true,
	      pause:4000,
	      speed:800,
		  controls:false,
		  onNextSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
		  jQuery("table.explore_nav td").removeClass('explore_nav_current');
		  		jQuery("table.explore_nav td:nth-child(" + (currentSlideNumber + 1) + ")").addClass('explore_nav_current');
		  		//nav();
		}
	  });
	  jQuery(window).resize(function(){
		_winH = $(window).height();
		if(window.location.hash == '#section-explore' || window.location.hash == '#section-fbimage'){
			var _expOfs = $('#explore').offset().top;
			$('body,html').scrollTop(_expOfs-_headerHeight);
		}
		jQuery('#slider').find('img.bximg').each(function(){
			$(this).height(_winH - _headerHeight)
		})
		  //var temp = slider.getCurrentSlide();
		  //slider.stopShow();
		  slider.reloadShow();
  		//slider.goToSlide(temp);
  		//slider.startShow();
	  });
	  
	// assign a click event to the external thumbnails
	  jQuery('.explore_nav td').click(function(){
	  	slider.stopShow();
	   var thumbIndex = jQuery('.explore_nav td').index(this);
	    // call the "goToSlide" public function
	    slider.goToSlide(thumbIndex);
	 
	    // remove all active classes
	    jQuery('.explore_nav td').removeClass('explore_nav_current');
	    // assisgn "pager-active" to clicked thumb
	    jQuery(this).addClass('explore_nav_current');
	    // very important! you must kill the links default behavior
	    slider.startShow();
	    return false;
	  });

	  // assign "pager-active" class to the first thumb
	  jQuery('.explore_nav td:first').addClass('explore_nav_current');
	  
		function nav() {
			var thumbIndex = jQuery('.explore_nav td').index(this);
		    // call the "goToSlide" public function
		    slider.goToSlide(thumbIndex);
		 
		    // remove all active classes
		    jQuery('.explore_nav td').removeClass('explore_nav_current');
		    // assisgn "pager-active" to clicked thumb
		    jQuery(this).addClass('explore_nav_current');
		    // very important! you must kill the links default behavior
		    return false;
		}
		

	  
	  
	  
  });
