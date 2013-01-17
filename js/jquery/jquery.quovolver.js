/*
 * jQuery Quovolver v1.0 - http://sandbox.sebnitu.com/jquery/quovolver
 *
 * By Sebastian Nitu - Copyright 2009 - All rights reserved
 * 
 */

(function($) {
	$.fn.quovolver = function(speed, delay) {
		
		/* Sets default values */
		if (!speed) speed = 300;
		if (!delay) delay = 5000;
		
		// If "delay" is less than 4 times the "speed", it will break the effect 
		// If that's the case, make "delay" exactly 4 times "speed"
		var quaSpd = (speed*4);
		if (quaSpd > (delay)) delay = quaSpd;
		
		// Create the variables needed
		var	quote = $(this),
			firstQuo = $(this).filter(':first'),
			lastQuo = $(this).filter(':last'),
			nxtBtn = $('.next', this),
			preBtn = $('.prev', this),
			wrapElem = '<div id="quote_wrap"></div>';
		
		// Wrap the quotes
		$(this).wrapAll(wrapElem);
		
		// Hide all the quotes, then show the first
		$(this).hide();
		$(firstQuo).show();
		
		// Set the hight of the wrapper
		$(this).parent().css({height: $(firstQuo).height()});		
		
		// Where the magic happens
		setInterval(function(){
			doSlideQuo("next")
		}, delay);
		
		function doSlideQuo(dir){
			// Set required hight and element in variables for animation
			if($(lastQuo).is(':visible')) {
				var nextElem = $(firstQuo);
				var wrapHeight = $(nextElem).height();
			} else {
				var nextElem = $(quote).filter(':visible').next();
				var wrapHeight = $(nextElem).height();
			}
			
			// Fadeout the quote that is currently visible
			$(quote).filter(':visible').fadeOut(speed);
			
			// Set the wrapper to the hight of the next element, then fade that element in
			setTimeout(function() {
				$(quote).parent().animate({height: wrapHeight}, speed);
			}, speed);
			
			if($(lastQuo).is(':visible')) {
				setTimeout(function() {
					$(firstQuo).fadeIn(speed);
				}, speed*2);
				
			} else {
				setTimeout(function() {
					$(nextElem).fadeIn(speed);
				}, speed*2);
			}
		}
		nxtBtn.click(function(e){
			doSlideQuo("next");
		});
		
		preBtn.click(function(e){
			doSlideQuo("prev");
		});
	
	};
})(jQuery);

/*! jQuery.customSelect() - v0.2.1 - 2012-12-17 */

(function($){
 $.fn.extend({
 
 	customSelect : function(options) {
	  if(typeof document.body.style.maxHeight != "undefined"){ /* filter out <= IE6 */
	  var defaults = {
		  customClass: null,
		  mapClass:true,
		  mapStyle:true
	  };
	  var options = $.extend(defaults, options);
	  
	  return this.each(function() {
	  		var $this = $(this);
			var customSelectInnerSpan = $('<span class="customSelectInner" />');
			var customSelectSpan = $('<span class="customSelect" />').append(customSelectInnerSpan);
			$this.after(customSelectSpan);
			
			if(options.customClass)	{ customSelectSpan.addClass(options.customClass); }
			if(options.mapClass)	{ customSelectSpan.addClass($this.attr('class')); }
			if(options.mapStyle)	{ customSelectSpan.attr('style', $this.attr('style')); }
			
			$this.bind('updateit',function(){
				$this.change();
				var selectBoxWidth = parseInt($this.outerWidth()) - (parseInt(customSelectSpan.outerWidth()) - parseInt(customSelectSpan.width()) );			
				customSelectSpan.css({display:'inline-block'});
				customSelectInnerSpan.css({width:selectBoxWidth, display:'inline-block'});
				var selectBoxHeight = customSelectSpan.outerHeight();
				$this.css({'-webkit-appearance':'menulist-button',width:customSelectSpan.outerWidth(),position:'absolute', opacity:0,height:selectBoxHeight,fontSize:customSelectSpan.css('font-size')});
			}).change(function(){
				var currentSelected = $this.find(':selected');
				var html = currentSelected.html() || '&nbsp;';
				customSelectInnerSpan.html(html).parent().addClass('customSelectChanged');
				setTimeout(function(){customSelectSpan.removeClass('customSelectOpen');},60);
			}).bind('mousedown',function(){
				customSelectSpan.toggleClass('customSelectOpen');
			}).focus(function(){
				customSelectSpan.addClass('customSelectFocus');
			}).blur(function(){
				customSelectSpan.removeClass('customSelectFocus customSelectOpen');
			}).trigger('updateit');
			
	  });
	  }
	}
 });
})(jQuery);
