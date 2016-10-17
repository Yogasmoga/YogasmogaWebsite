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
		var slideit;
		var	quote = $(this),
			firstQuo = $(this).filter(':first'),
			lastQuo = $(this).filter(':last'),
			nxtBtn = $('.next', this),
			preBtn = $('.prev', this),
			wrapElem = '<div id="quote_wrap"></div>';
		$(this).wrapAll(wrapElem);
		$(this).hide();
		$(firstQuo).show();
		$(this).parent().css({height: $(firstQuo).height()});
		slideit = setTimeout(slideTime, delay)
		function slideTime() {
			doSlideQuo("next");
		}
		
		function doSlideQuo(dir){
			window.clearInterval(slideit);
			// Set required hight and element in variables for animation
			if(dir == "prev"){
				if($(firstQuo).is(':visible')) {
					var nextElem = $(lastQuo);
					var wrapHeight = $(nextElem).height();
				} else {
					var nextElem = $(quote).filter(':visible').prev();
					var wrapHeight = $(nextElem).height();
				}
			}else{
				if($(lastQuo).is(':visible')) {
					var nextElem = $(firstQuo);
					var wrapHeight = $(nextElem).height();
				} else {
					var nextElem = $(quote).filter(':visible').next();
					var wrapHeight = $(nextElem).height();
				}
			}
			$(quote).filter(':visible').fadeOut(speed);
			setTimeout(function() {
				$(quote).parent().animate({height: wrapHeight}, speed);
			}, speed);
			setTimeout(function() {nextElem.stop(true,true).fadeIn(speed)}, speed);
			slideit = setTimeout(slideTime, delay)
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
			if($this.is(':visible')){
			var customSelectInnerSpan = $('<span class="customSelectInner" />');
			var customSelectSpan = $('<div class="customSelect" />')
			if(!$this.attr('csel')){
				$this.attr('csel', 'true').wrap(customSelectSpan).after(customSelectInnerSpan);
			}
			
			if(options.customClass)	{ $this.parent().addClass(options.customClass); }
			if(options.mapClass)	{ $this.parent().addClass($this.attr('class')); }
			//if(options.mapStyle)	{ $this.parent().attr('style', $this.attr('style')); }
			
			$this.bind('updateit',function(){
				var html = ($('option:selected', $this).text()) || '&nbsp;';
				customSelectInnerSpan.html(html).parent().addClass('customSelectChanged');
				setTimeout(function(){$this.parent().removeClass('customSelectOpen');},60);
			
			
				var sboxW = $this.outerWidth();
				var cssMrg = $this.css('margin-top');
				var selectBoxWidth = parseInt(sboxW) - (parseInt($this.parent().outerWidth()) - parseInt($this.parent().width()) );			
				customSelectInnerSpan.css({width:selectBoxWidth, display:'inline-block'});
				$this.css({'-webkit-appearance':'menulist-button',width:sboxW,position:'absolute', opacity:0,fontSize:$this.parent().css('font-size')});
				$this.parent().css({width:sboxW-12, display:'block', marginTop:cssMrg});
			}).change(function(){
				var html = ($('option:selected', $this).text()) || '&nbsp;';
				customSelectInnerSpan.html(html).parent().addClass('customSelectChanged');
				setTimeout(function(){$this.parent().removeClass('customSelectOpen');},60);
			}).bind('mousedown',function(){
				$this.parent().toggleClass('customSelectOpen');
			}).focus(function(){
				$this.parent().addClass('customSelectFocus');
			}).blur(function(){
				$this.parent().removeClass('customSelectFocus customSelectOpen');
			}).trigger('updateit');
			}
	  });
	  }
	}
 });
})(jQuery);

/*! waitForImages jQuery Plugin - v1.4.2 - 2013-01-19
* https://github.com/alexanderdickson/waitForImages
* Copyright (c) 2013 Alex Dickson; Licensed MIT */
(function(e){var t="waitForImages";e.waitForImages={hasImageProperties:["backgroundImage","listStyleImage","borderImage","borderCornerImage"]},e.expr[":"].uncached=function(t){if(!e(t).is('img[src!=""]'))return!1;var n=new Image;return n.src=t.src,!n.complete},e.fn.waitForImages=function(n,r,i){var s=0,o=0;e.isPlainObject(arguments[0])&&(i=arguments[0].waitForAll,r=arguments[0].each,n=arguments[0].finished),n=n||e.noop,r=r||e.noop,i=!!i;if(!e.isFunction(n)||!e.isFunction(r))throw new TypeError("An invalid callback was supplied.");return this.each(function(){var u=e(this),a=[],f=e.waitForImages.hasImageProperties||[],l=/url\(\s*(['"]?)(.*?)\1\s*\)/g;i?u.find("*").andSelf().each(function(){var t=e(this);t.is("img:uncached")&&a.push({src:t.attr("src"),element:t[0]}),e.each(f,function(e,n){var r=t.css(n),i;if(!r)return!0;while(i=l.exec(r))a.push({src:i[2],element:t[0]})})}):u.find("img:uncached").each(function(){a.push({src:this.src,element:this})}),s=a.length,o=0,s===0&&n.call(u[0]),e.each(a,function(i,a){var f=new Image;e(f).bind("load."+t+" error."+t,function(e){o++,r.call(a.element,o,s,e.type=="load");if(o==s)return n.call(u[0]),!1}),f.src=a.src})})}})(jQuery);