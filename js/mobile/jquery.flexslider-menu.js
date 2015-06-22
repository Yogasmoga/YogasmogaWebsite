//jQuery.noConflict();
$j = jQuery.noConflict();
$j(function() {
    var html = $j('html, body'), navContainer = $j('.nav-container'),   navToggle = $j('.nav-toggle'),    navDropdownToggle = $j('.has-dropdown');
		
	// Nav toggle
    navToggle.on('click', function(e) {
        var $jthis = $j(this);
        e.preventDefault();
        $jthis.toggleClass('is-active');
        navContainer.toggleClass('is-visible');
        html.toggleClass('nav-open');
    });
  
    // Nav dropdown toggle
    navDropdownToggle.on('click', function() {
        var $jthis = $j(this);
        $jthis.toggleClass('').children('ul').toggleClass('is-visible');
    });
  $j( document ).ready(function() {
	     $j(".arrow-tag").click(function () {
		 $j(this).parent().toggleClass('is-active');
		 });
  });
    // Prevent click events from firing on children of navDropdownToggle
    navDropdownToggle.on('click', '*', function(e) {
        e.stopPropagation();
    });
	
	$j( document ).ready(function() {
   $j(".nav-toggle").click(function () {
	 $j(".cross-btn").fadeIn();
  $j('.nav-container').fadeIn();
});
 $j(".cross-btn").click(function () {   
   $j(".cross-btn").fadeOut();  
  $j('.nav-container').fadeOut();
});
});
});

 $j( document ).ready(function() {
 $j(".menu-item .arrow-tag").click(function() {
  $j(this).parent().children(".menu-item .nav-dropdown").slideToggle(); });
  
  $j("#menu_signup").click(function () {
     $j(".cross-btn").fadeOut();  
     $j('.nav-container').fadeOut();
	 $j("#popForm").show();
});

  });
 $j(document).ready(function() {
 $j(".description-block .arrow-tag").click(function() {
  $j(this).parent().children(".detail-view .inner-content").slideToggle();
  });

  $j("#opc-cart .arrow-tag").click(function() {
  $j("#checkout-step-cart").slideToggle();
  });
  /************** my account page nav  */
  
   $j(".my-account-block .sign-in-box .arrow-tag").click(function() {
  $j(".my-account-block .account-nav ").slideToggle();
  });
  /************** my account page nav end */
  
  

  });