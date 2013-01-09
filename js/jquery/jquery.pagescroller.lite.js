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


eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('7 2={};(6(d){d.1q.V({2:6(h){h=d.V({y:0,I:"13",G:"1p",8:[],L:"1o 1n",1a:1r,o:0,K:!1},h);x=6(c,a){d.1s.1w=5;2.X=d(1v);2.v=d(16);2.M=d("15");2.p=2.v.E();2.14=2.v.17();2.3=a;2.3.o=A(2.3.o);7 e="1u";a.K&&(e="1t");2.3.8 W Z&&(c.B("<"+e+\' C="1m \'+a.L+\'"><O></O></\'+e+">"),2.J=d("."+a.L.1l(/\\s/g,"."),c),2.8=d("O",2.J),2.J.F("1d"),c.Y({10:"12"}));a.K?2.4=d("13",c):2.4=d("."+a.I,c);2.4.11(6(b){7 c=d(H),e=2.4.m(b).1f("1g"),f=a.G+" "+a.G+"T"+(b+1);b==2.4.l-1&&(f+=" "+a.G+"1j");c.Y({1h:"1x",10:"12","1H":"1I"});c.F(2.3.I+"T"+(b+1));2.3.8 W Z?2.3.8.l?2.8.B(\'<9 C="\'+f+\'"><a P="#x\'+b+\'">\'+2.3.8[b]+"</a></9>"):e&&""!=e?2.8.B(\'<9 C="\'+f+\'"><a P="#x\'+b+\'">\'+e+"</a></9>"):2.8.B(\'<9 C="\'+f+\'"><a P="#x\'+b+\'">1F \'+(b+1)+"</a></9>"):2.8=d(2.3.8)});2.q=d("a",2.8);2.q.11(6(b){d(H).U("1D",6(a){a.1C();2.M.Q(":R")||(2.q.t("9").18("r"),d(H).t("9").F("r"));j(c,2.4.m(b),b)})});2.1B=6(){7 b=2.3.y+1;n(b!=2.4.l){7 a=2.4.m(b);j(c,a,b)}};2.1z=6(){7 b=2.3.y-1;0>=b&&(b=0);7 a=2.4.m(b);j(c,a,b)};2.S=6(a){S(c,2.3.y,a)};2.v.U("1G",6(){k()});1i(6(){0==2.p&&k()},1E)};7 k=6(){2.p=2.v.E();2.1b=2.p+2.14;1e(i=0;i<2.4.l;i++){7 c=2.4.m(i).D().z;2.3.o&&c&&(c+=A(2.3.o));7 a=0;n(i<2.4.l-1){7 d=2.4.m(i+1);2.3.o?a=A(d.D().z+2.3.o):a=d.D().z;7 d=2.q.m(i).t("9"),b=2.q.m(2.4.l-1).t("9")}n(2.M.Q(":R"))w!1;n(2.X.17()==2.1b){n(!b.N("r"))w u=2.4.l-1,g(u),!1}19 n(a){n(2.p>=c&&2.p<a&&!d.N("r"))w u=i,g(u),!1}19 n(2.p>=c&&i==2.4.l-1&&!b.N("r"))w u=2.4.l-1,g(u),!1}},j=6(c,a,e){7 c=d("1A, 15"),b=d(16).E(),a=a.D().z;2.3.o&&(a+=A(2.3.o));0>a&&(a=0);a!=b&&!c.Q(":R")&&c.1J({E:a},2.3.1a,"1y").1k().1c(6(){g(e)})},g=6(c){2.q.t("9").18("r");2.q.m(c).t("9").F("r");2.3.y=c};n(!2.3)w x(H,h)}})})(1K);',62,109,'||pageScroller|options|sections||function|var|navigation|li||||||||||||length|eq|if|scrollOffset|scrollPosition|pageLinks|active||parent|updateTo|scrollWindow|return|pageScroll|currentSection|top|parseInt|append|class|offset|scrollTop|addClass|linkClass|this|sectionClass|wrapper|HTML5mode|navigationClass|scrollBody|hasClass|ul|href|is|animated|goTo|_|bind|extend|instanceof|scrollDocument|css|Array|position|each|relative|section|currentSectionHeight|body|window|height|removeClass|else|animationSpeed|scrollDistance|done|left|for|attr|title|display|setTimeout|_last|promise|replace|pageScrollerNav|light|standardNav|link|fn|500|fx|nav|div|document|interval|block|easeInOutExpo|prev|html|next|preventDefault|click|200|Navigation|scroll|float|none|animate|jQuery'.split('|'),0,{}))


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