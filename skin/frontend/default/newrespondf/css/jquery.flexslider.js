$(function() {
    var html = $('html, body'), navContainer = $('.nav-container'),   navToggle = $('.nav-toggle'),    navDropdownToggle = $('.has-dropdown');
		
		
		

    // Nav toggle
    navToggle.on('click', function(e) {
        var $this = $(this);
        e.preventDefault();
        $this.toggleClass('is-active');
        navContainer.toggleClass('is-visible');
        html.toggleClass('nav-open');
    });
  
    // Nav dropdown toggle
    navDropdownToggle.on('click', function() {
        var $this = $(this);
        $this.toggleClass('is-active').children('ul').toggleClass('is-visible');
    });
  
  
  
    // Prevent click events from firing on children of navDropdownToggle
    navDropdownToggle.on('click', '*', function(e) {
        e.stopPropagation();
    });
	
	$( document ).ready(function() {
   $(".nav-toggle").click(function () {   
  $('.nav-container').toggle({width: 'toggle'}, "fast")
});
 $(".cross-btn").click(function () {   
 
  $('.nav-container').toggle({width: 'toggle'}, "fast")
});
});
});

