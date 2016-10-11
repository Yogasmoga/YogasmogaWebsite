/*---header menu related --*/
jQuery(document).ready(function ($) {
	$('#welcome-name.logged-out').click(function(){
		$('#signin').trigger('click');
	});
});
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
	$('.selectedlength div[lengthtype="Regular"]').html('R');
	$('.selectedlength div[lengthtype="Tall"]').html('T');
	/*if($('div[lengthtype="Regular"]').hasClass('selected')){
			$('.length-name').html('Regular Length')
		}
		if($('div[lengthtype="Tall"]').hasClass('selected')){
			$('.length-name').html('Tall Length')
		}*/
	/*$('.selectedlength div').click(function(){
		//alert();
		if($(this).attr("[lengthtype='Tall']")){

			$('.length-name').html('Tall Length')
		}
		else if($(this).attr("[lengthtype='Regular']")) {
			$('.length-name').html('Regular Length')
		}
	});*/

});
/*
jQuery(document).ready(function($){
	var imgrowtr = $('.thumb-imgs table.smallimagecontiner tr td');
	if(imgrowtr.length){

	var windW = $(window).width();

	var imgrowh = $('.thumb-imgs table.smallimagecontiner tr td img').height();



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

	}


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

});*/
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

	var gProd = jQuery( ".gridProdCubix" );
	var gOffset = gProd.offset();
	//p.html( "left: " + offset.left + ", top: " + gOffset.top );
	//alert(gOffset.top);
	/*jQuery('.cat-name').css({
		top:gOffset.top	- 64
	});*/

});

/*--header scroll effect--*/

function header_scroll(){
//var jQ = jQuery.noConflict();
jQuery(document).ready(function(){


	 jQuery(window).scroll(function() {
        var mainbody = jQuery(window).scrollTop();

       if (mainbody > 40) {

		jQuery("#ysheader").removeClass("scrolled-effect");
		jQuery("#ysheader").addClass("showhide");

		jQuery("#ysheader").stop().animate({top:'-50'},{ duration: 300, queue: false });
		jQuery("#ysheader .posRel img").addClass("resizable");
		jQuery(".bagshow").removeClass("active");
		jQuery("#globalheader").addClass("color-change");

	   }

	   else{
		jQuery("#ysheader").addClass("scrolled-effect");
		jQuery("#ysheader").stop().animate({top:'0'},{ duration: 300, queue: false });
		jQuery("#ysheader .posRel img").removeClass("resizable");
		jQuery(".bagshow").addClass("active");
		jQuery("#globalheader").removeClass("color-change");
		jQuery("#ysheader").removeClass("showhide");

       }

    });
	 jQuery("#ysheader").mouseover(function(){
        if (!jQuery("#ysheader").hasClass("scrolled-effect")) {
            jQuery(this).stop().animate({top:'0'});
			jQuery("#ysheader .posRel img").removeClass("resizable");
		}
    });
	 jQuery("#ysheader").mouseout(function(){

        //move Nav back up
        if (!jQuery("#ysheader").hasClass("scrolled-effect")) {
            jQuery(this).stop().animate({top:'-50'});
           jQuery("#ysheader .posRel img").addClass("resizable");

        }
    });
	//alert(jQuery(".header-container").css('left'));
	/*var headContLeftOrigPos = jQuery(".header-container").css('left');
	jQuery(".header-container").css({
		'left': headContLeftOrigPos
		});
	jQuery(".header-container").animate({left: headContLeftOrigPos});*/
	
	jQuery("#shop-bag-count").click(function(){
		var shoppingWdth = jQuery(".shopping-cart").width();
		jQuery( ".open-cart" ).trigger( "click" );
		jQuery(".header-container").animate({left: -shoppingWdth});

	});
	jQuery(".pageoverlay,#continuelink").on("click", function () {
		jQuery(".header-container").animate({left: "0"});
	});

   });

}

// to fix elements which are going out of 1600px width
jQuery(document).ready(function(){
		var pageOffsetLeft = jQuery('.page').offset().left;
		var pageOffsetRight = (jQuery(window).width() - (jQuery('.page').offset().left + jQuery('.page').outerWidth()));		
		jQuery('.shopping-cart').css({
			'right':pageOffsetRight			
		});
		jQuery('#ysheader,.firstdialog,.ui-widget-overlay').css({
			'margin-left':pageOffsetLeft
		});
		
});

// to fix elements which are going out of 1600px width on resize
jQuery(window).resize(function(){
		var pageOffsetLeft = jQuery('.page').offset().left;
		var pageOffsetRight = (jQuery(window).width() - (jQuery('.page').offset().left + jQuery('.page').outerWidth()));		
		jQuery('.shopping-cart').css({
			'right':pageOffsetRight			
		});
		jQuery('#ysheader,.firstdialog,.ui-widget-overlay').css({
			'margin-left':pageOffsetLeft
		});
});
/*
jQuery(document).ready(function(){
	bktimgH = jQuery(".gridfull .grid65 img").height();
	alert(bktimgH);
	jQuery(".gridfull").css('min-height',bktimgH,'important');
});*/	
	

		
		
