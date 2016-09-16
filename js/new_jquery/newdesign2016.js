/*------------product details related js-----------*/
jQuery(document).ready(function ($) {	
	$('.accord .h2').click(function(){
		//$('.accord-desc').slideUp();
		//$('.accord-desc').parent('.accord-item').removeClass('active');
		
		
		if($(this).parent('.accord-item').hasClass('active')){
			$(this).next('.accord-desc').slideUp(function(){
				$(this).parent('.accord-item').removeClass('active');
			});
			//
		}
		else{
			$('.accord-desc').slideUp();
			$('.accord-desc').parent('.accord-item').removeClass('active');
			$(this).next('.accord-desc').slideDown();
			$(this).parent('.accord-item').addClass('active');	
		}
	});
	
	
	
});


jQuery(document).ready(function($){
	$('.tdbigimagecontainer img').click(function(){
		
		
		if($('table.smallimagecontiner td:last-child').hasClass('selectedimage')){
				//alert();
			$('table.smallimagecontiner td:first-child').trigger('click');
			
		}
		else{
				$("table.smallimagecontiner td.selectedimage").removeClass('selectedimage').next('td').trigger('click');
		}
			
	});
});

/*----------------product grid related js--------------------*/
jQuery(document).ready(function(){
	var prodHt = jQuery('.productCont').width();
	jQuery('.prod-img').height(prodHt);	
	var gridwd = jQuery('.gridWrap').width();	
	if (jQuery(window).width() >= 1100) {
		
		jQuery('.productCont').width((gridwd-24)/3); // 24 is  total of gutter space in a row
		jQuery('.prodduct_horizontal').width((gridwd-12)/1.5);
	}
	else {
		
		jQuery('.productCont').width((gridwd-16)/2); // 24 is  total of gutter space in a row
		jQuery('.prodduct_horizontal').width((gridwd-8)/1);
	}
	
	
	
	var maxHeight = -1;
   jQuery('.productCont .caption').each(function() {
     maxHeight = maxHeight > jQuery(this).height() ? maxHeight : jQuery(this).height();
   });
   jQuery('.productCont .caption').each(function() {
     jQuery(this).height(maxHeight);
   });
	
});
jQuery(window).resize(function(){
	var prodHt = jQuery('.productCont').width();
	jQuery('.prod-img').height(prodHt);	
	
	var gridwd = jQuery('.gridWrap').width();	
	if (jQuery(window).width() >= 1100) {
		
		jQuery('.productCont').width((gridwd-24)/3); // 24 is  total of gutter space in a row
		jQuery('.prodduct_horizontal').width((gridwd-12)/1.5);
	}
	else {
		
		jQuery('.productCont').width((gridwd-16)/2); // 24 is  total of gutter space in a row
		jQuery('.prodduct_horizontal').width((gridwd-8)/1);
	}
	
	var maxHeight = -1;
   jQuery('.productCont .caption').each(function() {
     maxHeight = maxHeight > jQuery(this).height() ? maxHeight : jQuery(this).height();
   });
   jQuery('.productCont .caption').each(function() {
     jQuery(this).height(maxHeight);
   });
});

jQuery(document).ready(function(){
	if(jQuery('#div_sizes').length){
		jQuery('.bannerFluid').addClass('ds');		
	}
});