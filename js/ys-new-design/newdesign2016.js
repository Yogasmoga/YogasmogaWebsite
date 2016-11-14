/*---header menu related --*/
jQuery(document).ready(function ($) {
	$('#welcome-name.logged-out').click(function(){
		$('#signin').trigger('click');
	});
	if(navigator.userAgent.indexOf('Mac') > 0){
		jQuery('body').addClass('mac-osys');
	}
});

/*-------------------------------------
 ####### product details related #######
 --------------------------------------*/
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

jQuery(window).load(function(){
	// detect if content overlows its parent element
	if(jQuery('.pcol-right-content1').length){
		var element = document.querySelector('.pcol-right-content1');
		//var element = jQuery('.pcol-right-content1');
		if( (element.offsetHeight < element.scrollHeight) || (element.offsetWidth < element.scrollWidth)){
			// your element have overflow
			//element.style.background = "yellow";
			jQuery('.product-det-tab-bottom').removeClass('show-related');
		}
		else{
			//your element don't have overflow
			//element.style.background = "red";
			jQuery('.product-det-tab-bottom').addClass('show-related');
		}
	}

});

/*-----------------------------------
 ######## product grid related ########
 ------------------------------------*/

jQuery(document).ready(function(){


	var gridwd = jQuery('.gridWrap').width();
	//alert(gridwd);
	if (jQuery(window).width() >= 767) {

		jQuery('.productCont').width((gridwd-24)/3); // 24 is  total of gutter space in a row

		var prodHt = jQuery('.productCont').width();
		//alert(prodHt);
		jQuery('.prod-img').height(prodHt);

		jQuery('.prodduct_horizontal').width((gridwd-12)/1.5);

	}
	else { // for two column

		jQuery('.productCont').width((gridwd-16)/2); // 24 is  total of gutter space in a row
		var prodHt = jQuery('.productCont').width();
		jQuery('.prod-img').height(prodHt);
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


	var gridwd = jQuery('.gridWrap').width();
	if (jQuery(window).width() >= 767) {

		jQuery('.productCont').width((gridwd-24)/3); // 24 is  total of gutter space in a row

		var prodHt = jQuery('.productCont').width();
		//alert(prodHt);
		jQuery('.prod-img').height(prodHt);

		jQuery('.prodduct_horizontal').width((gridwd-12)/1.5);
	}
	else { // for two column

		jQuery('.productCont').width((gridwd-16)/2); // 24 is  total of gutter space in a row
		var prodHt = jQuery('.productCont').width();
		jQuery('.prod-img').height(prodHt);
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

/*---sort color filters on grid page--*/
jQuery(document).ready(function () {
	if(jQuery("#div_cats").length){
		setTimeout(function(){
			//alert('div cats');
			var colrCats = jQuery('#div_cats');

			colrCats.find('.chk-cats').sort(function (a, b) {
				return b.getAttribute('rel') - a.getAttribute('rel');
			})
				.appendTo(colrCats);
			//alert('div cats2');
		},400);

	}

});

/*-----------------------------------
 ######### header related ##########
 ------------------------------------*/

/*--header scroll effect--*/

function header_scroll(){
//var jQ = jQuery.noConflict();
	jQuery(document).ready(function(){


		jQuery(window).scroll(function() {
			var mainbody = jQuery(window).scrollTop();

			if (mainbody > 40) {

				jQuery("#ysheader").removeClass("scrolled-effect");
				jQuery("#ysheader").addClass("showhide");
				jQuery("#ysheader").addClass("shrunk");
				//jQuery("#ysheader").stop().animate({top:'-50'},{ duration: 100, queue: false });
				jQuery("#ysheader .posRel img").addClass("resizable");
				jQuery(".bagshow").removeClass("active");
				jQuery("#globalheader").addClass("color-change");

			}

			else{
				jQuery("#ysheader").addClass("scrolled-effect");
				//jQuery("#ysheader").stop().animate({top:'0'},{ duration: 100, queue: false });
				jQuery("#ysheader .posRel img").removeClass("resizable");
				jQuery(".bagshow").addClass("active");
				jQuery("#globalheader").removeClass("color-change");
				jQuery("#ysheader").removeClass("showhide");
				jQuery("#ysheader").removeClass("shrunk");

			}

		});

		jQuery("#ysheader").mouseover(function(){
			if (!jQuery("#ysheader").hasClass("scrolled-effect")) {
				//  jQuery(this).stop().animate({top:'0'});
				//jQuery("#ysheader").removeClass("shrunk");
				//jQuery("#ysheader .posRel img").removeClass("resizable");
			}
		});
		jQuery("#ysheader").mouseout(function(){

			//move Nav back up
			if (!jQuery("#ysheader").hasClass("scrolled-effect")) {
				//jQuery(this).stop().animate({top:'-50'});
				//jQuery("#ysheader").addClass("shrunk");
				//jQuery("#ysheader .posRel img").addClass("resizable");

			}
		});

		//alert(jQuery(".header-container").css('left'));
		/*jQuery(".header-container").css({
		 'left': 0
		 });
		 var headContLeftOrigPos = jQuery(".header-container").css('left');

		 jQuery(".header-container").animate({left: headContLeftOrigPos});*/

		jQuery("#shop-bag-count").click(function(){
			var shoppingWdth = jQuery(".shopping-cart").width();
			jQuery( ".open-cart" ).trigger( "click" );
			//jQuery(".header-container").animate({left: -shoppingWdth});

		});
		jQuery(".pageoverlay,#continuelink").on("click", function () {
			//jQuery(".header-container").animate({left: "0"});
		});

	});

}

// to fix elements which are going out of 1600px width
jQuery(document).ready(function(){

	if(jQuery(window).width() > 767){
		var pageOffsetLeft = jQuery('.wrapper').offset().left;
		var pageOffsetRight = (jQuery(window).width() - (jQuery('.page').offset().left + jQuery('.wrapper').outerWidth()));
		jQuery('.shopping-cart').css({
			'right':pageOffsetRight
		});
		jQuery('#ysheader,.firstdialog,.ui-widget-overlay').css({
			'margin-left':pageOffsetLeft
		});


		/*jQuery(window).scroll(function(){
		 if(jQuery('#div_cats').hasClass('fixed_top')){
		 jQuery('#div_cats').css({
		 'right':pageOffsetRight
		 });
		 }
		 else{
		 jQuery('#div_cats').css({
		 'right':0
		 });
		 }
		 });*/

	}

	// show header after calculation of margin-left and css transition completion
	setTimeout(function(){
		jQuery('#ysheader').css({
			'opacity':1
		});
	},400);

});

// to fix elements which are going out of 1600px width on resize
jQuery(window).resize(function(){
	if(jQuery(window).width() > 767){
		var pageOffsetLeft = jQuery('.wrapper').offset().left;
		var pageOffsetRight = (jQuery(window).width() - (jQuery('.wrapper').offset().left + jQuery('.wrapper').outerWidth()));
		jQuery('.shopping-cart').css({
			'right':pageOffsetRight
		});
		jQuery('#ysheader,.firstdialog,.ui-widget-overlay').css({
			'margin-left':pageOffsetLeft
		});

		/*jQuery(window).scroll(function(){
		 if(jQuery('#div_cats').hasClass('fixed_top')){
		 jQuery('#div_cats').css({
		 'right':pageOffsetRight
		 });
		 }
		 else{
		 jQuery('#div_cats').css({
		 'right':0
		 });
		 }
		 });	*/
	}
});
// to fix elements which are going out of 1600px width on keyboard zoomin zoomout
jQuery(window).on('keypress keydown',function(e){
	//alert();
	if((e.which == 61 && 17) || (e.which == 43 && 17) || (e.which == 45 && 17) || (e.which == 48 && 17) || (e.which == 96 && 17)){
		// 17 is Ctrl Keycode
		//Ctrl + "+" is pressed, 61 is for =/+ anr 43 is for Numpad + key
		//Ctrl + "-" is pressed, 45 is for -/- anr 45 is for Numpad - key
		//Ctrl + "0" is pressed, 48 is for )/0 anr 96 is for Numpad 0 key
		//alert(e.which);

		var px = 0;

		var intervalID = setInterval(function () {
			// logic here			
			var pageOffsetLeft = jQuery('.wrapper').offset().left;
			var pageOffsetRight = (jQuery(window).width() - (jQuery('.wrapper').offset().left + jQuery('.wrapper').outerWidth()));
			jQuery('.shopping-cart').css({
				'right':pageOffsetRight
			});
			jQuery('#ysheader,.firstdialog,.ui-widget-overlay').css({
				'margin-left':pageOffsetLeft
			});

			jQuery(window).scroll(function(){
				if(jQuery('#div_cats').hasClass('fixed_top')){
					jQuery('#div_cats').css({
						'right':pageOffsetRight
					});
				}
				else{
					jQuery('#div_cats').css({
						'right':0
					});
				}
			});

			if (++px === 1) {
				console.info('px=' +px);
				window.clearInterval(intervalID);
			}
		}, 400);
	}



});

// home banner
jQuery(document).ready(function(){
	var hbanH = jQuery(window).height();
	jQuery('.home-banner').css({'min-height': hbanH});
});
jQuery(window).resize(function(){
	var hbanH = jQuery(window).height();
	jQuery('.home-banner').css({'min-height': hbanH});
});

// add remove class on page load
jQuery(document).ready(function(){
	jQuery('body').addClass('content-loading');
});
jQuery(window).load(function(){
	jQuery('body').removeClass('content-loading');
	jQuery('body').addClass('content-loaded');
});

/**********Sign up popup********/
jQuery(document).ready(function(){
	jQuery( ".ui-dialog-titlebar" ).before( "<div class='hoverbg'></div>" );

	jQuery(".sign-in-block").click(function(){
		jQuery(".signinDialog").addClass("moveleft");
	});
	jQuery(".sign-up-block").click(function(){
		jQuery(".signinDialog").removeClass("moveleft");


	});
	jQuery(".signinDialog #fake-pswd1").focusin(function(){
		jQuery(".signinDialog").addClass("moveleft");
	});

	jQuery(".signinDialog #fake-pswd2").focusin(function(){
		jQuery(".signinDialog").removeClass("moveleft");
	});




	/*--for hover effect--*/
	if(!jQuery(".signinDialog").hasClass('mouseleft')){
		jQuery(".sign-in-block").mouseover(function(){
			jQuery(".signinDialog").addClass("sign-in-hover");
		});
		jQuery(".ui-dialog-titlebar-close").mouseover(function(){
			jQuery(".signinDialog").addClass("sign-in-hover");
		});
		jQuery(".sign-in-block").mouseout(function(){
			jQuery(".signinDialog").removeClass("sign-in-hover");
		});

		jQuery(".sign-up-block").mouseover(function(){
			jQuery(".signinDialog").addClass("sign-up-hover");
		});
		jQuery(".sign-up-block").mouseout(function(){
			jQuery(".signinDialog").removeClass("sign-up-hover");
		});

	}

	if(jQuery(".signinDialog").hasClass('mouseleft')){
		jQuery(".sign-up-block").mouseover(function(){
			jQuery(".signinDialog").addClass("sign-up-hover");
		});
		jQuery(".sign-up-block").mouseout(function(){
			jQuery(".signinDialog").removeClass("sign-up-hover");
		});
	}



	jQuery('.logged-out').click(function(){
		var signInHT = jQuery(".sign-in-block").height();
		var signUpHT = jQuery(".sign-up-block").height();
		//alert(signInHT);
		//alert(signUpHT);
		if(signUpHT > signInHT ){
			jQuery(".sign-in-block").css({
				'min-height': signUpHT
			});
		}
		else{
			jQuery(".sign-up-block").css({
				'min-height': signInHT
			});
		}
	});



	/*---to make button gold if all fields are filled--*/
	jQuery('#sign-in-form #si_email,#sign-in-form #si_password').on('focus keyup',function(){
		if(jQuery('#si_email').val().length > 1 && jQuery('#si_password').val().length > 1){
			jQuery('#sign-in-button').addClass('button-on');
		}
		else{
			jQuery('#sign-in-button').removeClass('button-on');
		}
	});
	jQuery('#sign-up-form #fname,#sign-up-form #lname,#sign-up-form #signup_email,#sign-up-form #s_password').on('focus blur',function(){
		if(jQuery('#sign-up-form #fname').val().length > 1 && jQuery('#sign-up-form #lname').val().length > 1 && jQuery('#sign-up-form #signup_email').val().length > 1 && jQuery('#sign-up-form #s_password').val().length > 1 && jQuery('#sign-up-form .gender_radio').hasClass('selected') ){
			jQuery('#sign-up-button').addClass('button-on');
		}
		else{
			jQuery('#sign-up-button').removeClass('button-on');
		}
	});
	jQuery('#sign-up-form .gender_radio').on('click',function(){
		if(jQuery('#sign-up-form #fname').val().length > 1 && jQuery('#sign-up-form #lname').val().length > 1 && jQuery('#sign-up-form #signup_email').val().length > 1 && jQuery('#sign-up-form #s_password').val().length > 1 && jQuery('#sign-up-form .gender_radio').hasClass('selected') ){
			jQuery('#sign-up-button').addClass('button-on');
		}
		else{
			jQuery('#sign-up-button').removeClass('button-on');
		}
	});

});

// for hover animation
/*
 jQuery(document).ready(function(){
 jQuery('.gridfull .sliderImg img,.gridfull .compressBox,.gridfull .multicolorcont,.gridfull .featured-collection-top,.gridfull .featured-collection-bottom,.gridfull .iconspartone span,.gridfull .slider_li,.gridfull .slider_li .over-the-slide').addClass('ysanimate');
 jQuery('.gridfull .sliderImg').addClass('hoverscaleimg');
 jQuery('.gridfull .compressBox,.gridfull .multicolorcont,.gridfull .featured-collection-top,.gridfull .featured-collection-bottom').addClass('hoverscalebg');
 jQuery('.gridfull .iconspartone span').addClass('bubbleimg');
 jQuery('.gridfull .slides').addClass('slideritem_hover');

 });*/

		
		
