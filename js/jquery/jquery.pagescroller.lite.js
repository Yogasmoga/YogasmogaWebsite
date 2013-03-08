/*
 *	Page Scroller LITE - jQuery Plugin
 *	A simple plugin to add smooth scroll interaction to your website
 *
 *	Support at: http://www.pagescroller.com
 *
 *	Copyright (c) 2012 Dairien Boyd. All Rights Reserved
 *
 *	Version: 1.0.1 (6/6/2012)
 *	Requires: jQuery v1.4+
 *
 *	Page Scroller is released under the GNU General Public License
 *	(http://www.gnu.org/licenses/). By using Page Scroller, you 
 *	acknowledge and agree to the Terms of Service found here:
 *	(http://www.pagescroller.com/tos/)
 *
 */


var pageScroller = {};
(function (d) {
	d.fn.extend({
		pageScroller: function (h) {
			h = d.extend({
				currentSection: 0,
				sectionClass: "section",
				linkClass: "link",
				navigation: [],
				navigationClass: "standardNav light",
				animationSpeed: 500,
				scrollOffset: 0,
				HTML5mode: !1
			},
			h);
			pageScroll = function (c, a) {
				d.fx.interval = 5;
				pageScroller.scrollDocument = d(document);
				pageScroller.scrollWindow = d(window);
				pageScroller.scrollBody = d("body");
				pageScroller.scrollPosition = pageScroller.scrollWindow.scrollTop();
				pageScroller.currentSectionHeight = pageScroller.scrollWindow.height();
				pageScroller.options = a;
				pageScroller.options.scrollOffset = parseInt(pageScroller.options.scrollOffset);
				var e = "div";
				a.HTML5mode && (e = "nav");
				pageScroller.options.navigation instanceof Array && (c.append("<" + e + ' class="pageScrollerNav ' + a.navigationClass + '"><ul></ul></' + e + ">"), pageScroller.wrapper = d("." + a.navigationClass.replace(/\s/g, "."), c), pageScroller.navigation = d("ul", pageScroller.wrapper), pageScroller.wrapper.addClass("left"), c.css({
					position: "relative"
				}));
				a.HTML5mode ? pageScroller.sections = d("section", c) : pageScroller.sections = d("." + a.sectionClass, c);
				pageScroller.sections.each(function (b) {
					var c = d(this),
					e = pageScroller.sections.eq(b).attr("title"),
					f = a.linkClass + " " + a.linkClass + "_" + (b + 1);
					b == pageScroller.sections.length - 1 && (f += " " + a.linkClass + "_last");
					c.css({
						display: "block",
						position: "relative",
						"float": "none"
					});
					c.addClass(pageScroller.options.sectionClass + "_" + (b + 1));
					pageScroller.options.navigation instanceof Array ? pageScroller.options.navigation.length ? pageScroller.navigation.append('<li class="' + f + '"><a href="#pageScroll' + b + '">' + pageScroller.options.navigation[b] + "</a></li>") : e && "" != e ? pageScroller.navigation.append('<li class="' + f + '"><a href="#pageScroll' + b + '">' + e + "</a></li>") : pageScroller.navigation.append('<li class="' + f + '"><a href="#pageScroll' + b + '">Navigation ' + (b + 1) + "</a></li>") : pageScroller.navigation = d(pageScroller.options.navigation)
				});
				pageScroller.pageLinks = d("a", pageScroller.navigation);
				pageScroller.pageLinks.each(function (b) {
					d(this).bind("click", function (a) {
						a.preventDefault();
						pageScroller.scrollBody.is(":animated") || (pageScroller.pageLinks.parent("li").removeClass("active"), d(this).parent("li").addClass("active"));
						j(c, pageScroller.sections.eq(b), b)
					})
				});
				pageScroller.next = function () {
					var b = pageScroller.options.currentSection + 1;
					if (b != pageScroller.sections.length) {
						var a = pageScroller.sections.eq(b);
						j(c, a, b)
					}
				};
				pageScroller.prev = function () {
					var b = pageScroller.options.currentSection - 1;
					0 >= b && (b = 0);
					var a = pageScroller.sections.eq(b);
					j(c, a, b)
				};
				pageScroller.goTo = function (a) {
					goTo(c, pageScroller.options.currentSection, a)
				};
				pageScroller.scrollWindow.bind("scroll", function () {
					k()
				});
				setTimeout(function () {
					0 == pageScroller.scrollPosition && k()
				},
				200)
			};
			var k = function () {
				pageScroller.scrollPosition = pageScroller.scrollWindow.scrollTop();
				pageScroller.scrollDistance = pageScroller.scrollPosition + pageScroller.currentSectionHeight;
				for (i = 0; i < pageScroller.sections.length; i++) {
					var c = pageScroller.sections.eq(i).offset().top;
					pageScroller.options.scrollOffset && c && (c += parseInt(pageScroller.options.scrollOffset));
					var a = 0;
					if (i < pageScroller.sections.length - 1) {
						var d = pageScroller.sections.eq(i + 1);
						pageScroller.options.scrollOffset ? a = parseInt(d.offset().top + pageScroller.options.scrollOffset) : a = d.offset().top;
						var d = pageScroller.pageLinks.eq(i).parent("li"),
						b = pageScroller.pageLinks.eq(pageScroller.sections.length - 1).parent("li")
					}
					if (pageScroller.scrollBody.is(":animated")) return ! 1;
					if (pageScroller.scrollDocument.height() == pageScroller.scrollDistance) {
						if (!b.hasClass("active")) return updateTo = pageScroller.sections.length - 1,
						g(updateTo),
						!1
					} else if (a) {
						if (pageScroller.scrollPosition >= c && pageScroller.scrollPosition < a && !d.hasClass("active")) return updateTo = i,
						g(updateTo),
						!1
					} else if (pageScroller.scrollPosition >= c && i == pageScroller.sections.length - 1 && !b.hasClass("active")) return updateTo = pageScroller.sections.length - 1,
					g(updateTo),
					!1
				}
			},
			j = function (c, a, e) {
				var c = d("html, body"),
				b = d(window).scrollTop(),
				a = a.offset().top;
				pageScroller.options.scrollOffset && (a += parseInt(pageScroller.options.scrollOffset));
				0 > a && (a = 0);
				a != b && !c.is(":animated") && c.animate({
					scrollTop: a
				},
				pageScroller.options.animationSpeed, "easeInOutExpo").promise().done(function () {
					g(e)
				})
			},
			g = function (c) {
				pageScroller.pageLinks.parent("li").removeClass("active");
				pageScroller.pageLinks.eq(c).parent("li").addClass("active");
				pageScroller.options.currentSection = c;
				var curSection = pageScroller.sections.eq(c).attr('id');
				if(curSection.toLowerCase() == "explore"){
					slider.goToNextSlide();
					slider.startAuto();
				}
				if(c > 0){
					var hash = "#"+curSection.toLowerCase();
					var loc = window.location;
					history.replaceState("", document.title, loc.pathname + loc.search+hash);
					//.charAt(0).toUpperCase() + curSection.slice(1);
				}else{
					var loc = window.location;
					history.replaceState("", document.title, loc.pathname + loc.search);
				}
			};
			if (!pageScroller.options) return pageScroll(this, h)
		}
	})
})(jQuery);


// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});