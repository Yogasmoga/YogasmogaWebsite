// Font Replacement

jQuery(document).ready(function() {		
	// Cart Popout
	jQuery(".mycart").click(function() {
		jQuery(".mycart-block").slideToggle('medium');
	});

	//Cufon
	Cufon.replace('.page-title h1', {fontFamily: 'AlteHaasGroteskBold'});
	Cufon.replace('.page-head h3', {fontFamily: 'AlteHaasGroteskBold'});
	Cufon.replace('.category-head h2', {fontFamily: 'AlteHaasGroteskBold', textShadow: '1px 1px 1px #000'});
	Cufon.replace('#left-nav span ', {fontFamily: 'AlteHaasGroteskBold'});
	Cufon.replace('.mini-newsletter h4', {fontFamily: 'AlteHaasGroteskBold'});
	Cufon.replace('.mycart-block button span span', {fontFamily: 'AlteHaasGroteskBold',});

	// Featured Products
    jQuery('#featured').jcarousel();

	// Slider Homepage{ color: #f00; ...
	jQuery('#slider').cycle({
        fx: 'fade',
        speed: 2000,
		timeout: 5000,
        pager: '#controls',
		slideExpr: '.panel'
    });
 	// Custom Menu
	jQuery(".category").click(function() {
		// var open = jQuery(".category").attr("rel");
		var open = this.getAttributeNode('lang').value;
		jQuery(".subcategory_" + open).slideToggle(500);
	});	

	// FancyBox jQuery
	//$("a#preview").fancybox({
		//'titleShow'     : false,
		//'transitionIn'	: 'elastic',
		//'transitionOut'	: 'elastic',
		//'easingIn'      : 'easeOutBack',
		//'easingOut'     : 'easeInBack'
	//});
	

});



