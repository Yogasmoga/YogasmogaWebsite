jQuery(window).load(function($){
	setImageHeightSafari();
});

jQuery(document).ready(function($){
    // for macOS
    if(navigator.userAgent.indexOf('Mac') > 0) {
        $('body').addClass('mac-os');
    };

    // for chrome only
    if(navigator.userAgent.indexOf('Chrome') > 0) {
        $('body').addClass('chrome');
    };

    // for safari only
    if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
        $('body').addClass('safari');
    };

    //setImageHeightSafari();

});

function setImageHeightSafari(){
	// var blockImgH = jQuery("body.mac-os .gridFullWidth .block50:nth-child(1) img, body.safari .gridFullWidth .block50:nth-child(1) img").height();
	// jQuery(".gridFullWidth .block50:nth-child(2) img.img-responsive").css("height", blockImgH);


	jQuery("body.mac-os .gridFullWidth").each(function(){
		var blockImgH = jQuery(this).find(".block50:nth-child(1) img").height();
		jQuery(this).find(".block50:nth-child(2) img.img-responsive").css("height", blockImgH);
	});
	
	jQuery("body.safari .gridFullWidth").each(function(){
		var blockImgH = jQuery(this).find(".block50:nth-child(1) img").height();
		jQuery(this).find(".block50:nth-child(2) img.img-responsive").css("height", blockImgH);
	});



}