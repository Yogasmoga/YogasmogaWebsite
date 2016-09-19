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

jQuery(document).ready(function($){
	var windW = $(window).width(); 
	
	var imgrowh = $('.image-row img').height();
	$('.prod-col .pcol-right-content').height(imgrowh);
	$('.image-row-last img').appendTo('.pcol-right-content4 .pcol-right-content-inner');
	$('.product-row .img_madeinusa').appendTo('.image-row-first');
	$('.product-row .img_rnd').appendTo('.image-row4');
	
	var imgrow4H = $('.image-row4 img').height();
	$('.prod-col .pcol-right-content4').height(imgrow4H);
	
	var imgrow4W = $('.image-row4').css({
		'width': (66.125 * windW)/100		
	});
	var pcolRightContent4W = $('.pcol-right-content4').css({
		'width': (33.875 * windW)/100 - 10		
	});
	
	// for margin-left
	var pcolRightContent4Width = $('.pcol-right-content4').outerWidth();	
	pcolRightW = $('.product-row .pcol-right').outerWidth();
	
	var pcolRightContent4ML = pcolRightContent4Width - pcolRightW;
	
	$('.pcol-right-content4').css({
		'margin-left': -(pcolRightContent4Width - pcolRightW)
	});
	
	
});	

jQuery(window).resize(function(){
	var windW = jQuery(window).width();
	
	var imgrowh = jQuery('.image-row img').height();	
	jQuery('.prod-col .pcol-right-content').height(imgrowh);
	
	var imgrow4H = jQuery('.image-row4 img').height();
	jQuery('.prod-col .pcol-right-content4').height(imgrow4H);
	
	var imgrow4W = jQuery('.image-row4').css({
		'width': (66.125 * windW)/100		
	});
	var pcolRightContent4W = jQuery('.pcol-right-content4').css({
		'width': (33.875 * windW)/100 - 10		 
	});
	
	// for margin-left
	var pcolRightContent4Width = jQuery('.pcol-right-content4').outerWidth();	
	pcolRightW = jQuery('.product-row .pcol-right').outerWidth();
	
	var pcolRightContent4ML = pcolRightContent4Width - pcolRightW;
	
	jQuery('.pcol-right-content4').css({
		'margin-left': -(pcolRightContent4Width - pcolRightW)
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