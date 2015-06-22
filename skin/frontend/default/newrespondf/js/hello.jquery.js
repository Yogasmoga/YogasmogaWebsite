
jQuery.noConflict();	

/*
 * Copyright (c) 2009 Simo Kinnunen.
 * Licensed under the MIT license.
 *
 * @version 1.09
 */
var Cufon=(function(){var m=function(){return m.replace.apply(null,arguments)};var x=m.DOM={ready:(function(){var C=false,E={loaded:1,complete:1};var B=[],D=function(){if(C){return}C=true;for(var F;F=B.shift();F()){}};if(document.addEventListener){document.addEventListener("DOMContentLoaded",D,false);window.addEventListener("pageshow",D,false)}if(!window.opera&&document.readyState){(function(){E[document.readyState]?D():setTimeout(arguments.callee,10)})()}if(document.readyState&&document.createStyleSheet){(function(){try{document.body.doScroll("left");D()}catch(F){setTimeout(arguments.callee,1)}})()}q(window,"load",D);return function(F){if(!arguments.length){D()}else{C?F():B.push(F)}}})(),root:function(){return document.documentElement||document.body}};var n=m.CSS={Size:function(C,B){this.value=parseFloat(C);this.unit=String(C).match(/[a-z%]*$/)[0]||"px";this.convert=function(D){return D/B*this.value};this.convertFrom=function(D){return D/this.value*B};this.toString=function(){return this.value+this.unit}},addClass:function(C,B){var D=C.className;C.className=D+(D&&" ")+B;return C},color:j(function(C){var B={};B.color=C.replace(/^rgba\((.*?),\s*([\d.]+)\)/,function(E,D,F){B.opacity=parseFloat(F);return"rgb("+D+")"});return B}),fontStretch:j(function(B){if(typeof B=="number"){return B}if(/%$/.test(B)){return parseFloat(B)/100}return{"ultra-condensed":0.5,"extra-condensed":0.625,condensed:0.75,"semi-condensed":0.875,"semi-expanded":1.125,expanded:1.25,"extra-expanded":1.5,"ultra-expanded":2}[B]||1}),getStyle:function(C){var B=document.defaultView;if(B&&B.getComputedStyle){return new a(B.getComputedStyle(C,null))}if(C.currentStyle){return new a(C.currentStyle)}return new a(C.style)},gradient:j(function(F){var G={id:F,type:F.match(/^-([a-z]+)-gradient\(/)[1],stops:[]},C=F.substr(F.indexOf("(")).match(/([\d.]+=)?(#[a-f0-9]+|[a-z]+\(.*?\)|[a-z]+)/ig);for(var E=0,B=C.length,D;E<B;++E){D=C[E].split("=",2).reverse();G.stops.push([D[1]||E/(B-1),D[0]])}return G}),quotedList:j(function(E){var D=[],C=/\s*((["'])([\s\S]*?[^\\])\2|[^,]+)\s*/g,B;while(B=C.exec(E)){D.push(B[3]||B[1])}return D}),recognizesMedia:j(function(G){var E=document.createElement("style"),D,C,B;E.type="text/css";E.media=G;try{E.appendChild(document.createTextNode("/**/"))}catch(F){}C=g("head")[0];C.insertBefore(E,C.firstChild);D=(E.sheet||E.styleSheet);B=D&&!D.disabled;C.removeChild(E);return B}),removeClass:function(D,C){var B=RegExp("(?:^|\\s+)"+C+"(?=\\s|$)","g");D.className=D.className.replace(B,"");return D},supports:function(D,C){var B=document.createElement("span").style;if(B[D]===undefined){return false}B[D]=C;return B[D]===C},textAlign:function(E,D,B,C){if(D.get("textAlign")=="right"){if(B>0){E=" "+E}}else{if(B<C-1){E+=" "}}return E},textShadow:j(function(F){if(F=="none"){return null}var E=[],G={},B,C=0;var D=/(#[a-f0-9]+|[a-z]+\(.*?\)|[a-z]+)|(-?[\d.]+[a-z%]*)|,/ig;while(B=D.exec(F)){if(B[0]==","){E.push(G);G={};C=0}else{if(B[1]){G.color=B[1]}else{G[["offX","offY","blur"][C++]]=B[2]}}}E.push(G);return E}),textTransform:(function(){var B={uppercase:function(C){return C.toUpperCase()},lowercase:function(C){return C.toLowerCase()},capitalize:function(C){return C.replace(/\b./g,function(D){return D.toUpperCase()})}};return function(E,D){var C=B[D.get("textTransform")];return C?C(E):E}})(),whiteSpace:(function(){var D={inline:1,"inline-block":1,"run-in":1};var C=/^\s+/,B=/\s+$/;return function(H,F,G,E){if(E){if(E.nodeName.toLowerCase()=="br"){H=H.replace(C,"")}}if(D[F.get("display")]){return H}if(!G.previousSibling){H=H.replace(C,"")}if(!G.nextSibling){H=H.replace(B,"")}return H}})()};n.ready=(function(){var B=!n.recognizesMedia("all"),E=false;var D=[],H=function(){B=true;for(var K;K=D.shift();K()){}};var I=g("link"),J=g("style");function C(K){return K.disabled||G(K.sheet,K.media||"screen")}function G(M,P){if(!n.recognizesMedia(P||"all")){return true}if(!M||M.disabled){return false}try{var Q=M.cssRules,O;if(Q){search:for(var L=0,K=Q.length;O=Q[L],L<K;++L){switch(O.type){case 2:break;case 3:if(!G(O.styleSheet,O.media.mediaText)){return false}break;default:break search}}}}catch(N){}return true}function F(){if(document.createStyleSheet){return true}var L,K;for(K=0;L=I[K];++K){if(L.rel.toLowerCase()=="stylesheet"&&!C(L)){return false}}for(K=0;L=J[K];++K){if(!C(L)){return false}}return true}x.ready(function(){if(!E){E=n.getStyle(document.body).isUsable()}if(B||(E&&F())){H()}else{setTimeout(arguments.callee,10)}});return function(K){if(B){K()}else{D.push(K)}}})();function s(D){var C=this.face=D.face,B={"\u0020":1,"\u00a0":1,"\u3000":1};this.glyphs=D.glyphs;this.w=D.w;this.baseSize=parseInt(C["units-per-em"],10);this.family=C["font-family"].toLowerCase();this.weight=C["font-weight"];this.style=C["font-style"]||"normal";this.viewBox=(function(){var F=C.bbox.split(/\s+/);var E={minX:parseInt(F[0],10),minY:parseInt(F[1],10),maxX:parseInt(F[2],10),maxY:parseInt(F[3],10)};E.width=E.maxX-E.minX;E.height=E.maxY-E.minY;E.toString=function(){return[this.minX,this.minY,this.width,this.height].join(" ")};return E})();this.ascent=-parseInt(C.ascent,10);this.descent=-parseInt(C.descent,10);this.height=-this.ascent+this.descent;this.spacing=function(L,N,E){var O=this.glyphs,M,K,G,P=[],F=0,J=-1,I=-1,H;while(H=L[++J]){M=O[H]||this.missingGlyph;if(!M){continue}if(K){F-=G=K[H]||0;P[I]-=G}F+=P[++I]=~~(M.w||this.w)+N+(B[H]?E:0);K=M.k}P.total=F;return P}}function f(){var C={},B={oblique:"italic",italic:"oblique"};this.add=function(D){(C[D.style]||(C[D.style]={}))[D.weight]=D};this.get=function(H,I){var G=C[H]||C[B[H]]||C.normal||C.italic||C.oblique;if(!G){return null}I={normal:400,bold:700}[I]||parseInt(I,10);if(G[I]){return G[I]}var E={1:1,99:0}[I%100],K=[],F,D;if(E===undefined){E=I>400}if(I==500){I=400}for(var J in G){if(!k(G,J)){continue}J=parseInt(J,10);if(!F||J<F){F=J}if(!D||J>D){D=J}K.push(J)}if(I<F){I=F}if(I>D){I=D}K.sort(function(M,L){return(E?(M>=I&&L>=I)?M<L:M>L:(M<=I&&L<=I)?M>L:M<L)?-1:1});return G[K[0]]}}function r(){function D(F,G){if(F.contains){return F.contains(G)}return F.compareDocumentPosition(G)&16}function B(G){var F=G.relatedTarget;if(!F||D(this,F)){return}C(this,G.type=="mouseover")}function E(F){C(this,F.type=="mouseenter")}function C(F,G){setTimeout(function(){var H=d.get(F).options;m.replace(F,G?h(H,H.hover):H,true)},10)}this.attach=function(F){if(F.onmouseenter===undefined){q(F,"mouseover",B);q(F,"mouseout",B)}else{q(F,"mouseenter",E);q(F,"mouseleave",E)}}}function u(){var C=[],D={};function B(H){var E=[],G;for(var F=0;G=H[F];++F){E[F]=C[D[G]]}return E}this.add=function(F,E){D[F]=C.push(E)-1};this.repeat=function(){var E=arguments.length?B(arguments):C,F;for(var G=0;F=E[G++];){m.replace(F[0],F[1],true)}}}function A(){var D={},B=0;function C(E){return E.cufid||(E.cufid=++B)}this.get=function(E){var F=C(E);return D[F]||(D[F]={})}}function a(B){var D={},C={};this.extend=function(E){for(var F in E){if(k(E,F)){D[F]=E[F]}}return this};this.get=function(E){return D[E]!=undefined?D[E]:B[E]};this.getSize=function(F,E){return C[F]||(C[F]=new n.Size(this.get(F),E))};this.isUsable=function(){return !!B}}function q(C,B,D){if(C.addEventListener){C.addEventListener(B,D,false)}else{if(C.attachEvent){C.attachEvent("on"+B,function(){return D.call(C,window.event)})}}}function v(C,B){var D=d.get(C);if(D.options){return C}if(B.hover&&B.hoverables[C.nodeName.toLowerCase()]){b.attach(C)}D.options=B;return C}function j(B){var C={};return function(D){if(!k(C,D)){C[D]=B.apply(null,arguments)}return C[D]}}function c(F,E){var B=n.quotedList(E.get("fontFamily").toLowerCase()),D;for(var C=0;D=B[C];++C){if(i[D]){return i[D].get(E.get("fontStyle"),E.get("fontWeight"))}}return null}function g(B){return document.getElementsByTagName(B)}function k(C,B){return C.hasOwnProperty(B)}function h(){var C={},B,F;for(var E=0,D=arguments.length;B=arguments[E],E<D;++E){for(F in B){if(k(B,F)){C[F]=B[F]}}}return C}function o(E,M,C,N,F,D){var K=document.createDocumentFragment(),H;if(M===""){return K}var L=N.separate;var I=M.split(p[L]),B=(L=="words");if(B&&t){if(/^\s/.test(M)){I.unshift("")}if(/\s$/.test(M)){I.push("")}}for(var J=0,G=I.length;J<G;++J){H=z[N.engine](E,B?n.textAlign(I[J],C,J,G):I[J],C,N,F,D,J<G-1);if(H){K.appendChild(H)}}return K}function l(D,M){var C=D.nodeName.toLowerCase();if(M.ignore[C]){return}var E=!M.textless[C];var B=n.getStyle(v(D,M)).extend(M);var F=c(D,B),G,K,I,H,L,J;if(!F){return}for(G=D.firstChild;G;G=I){K=G.nodeType;I=G.nextSibling;if(E&&K==3){if(H){H.appendData(G.data);D.removeChild(G)}else{H=G}if(I){continue}}if(H){D.replaceChild(o(F,n.whiteSpace(H.data,B,H,J),B,M,G,D),H);H=null}if(K==1){if(G.firstChild){if(G.nodeName.toLowerCase()=="cufon"){z[M.engine](F,null,B,M,G,D)}else{arguments.callee(G,M)}}J=G}}}var t=" ".split(/\s+/).length==0;var d=new A();var b=new r();var y=new u();var e=false;var z={},i={},w={autoDetect:false,engine:null,forceHitArea:false,hover:false,hoverables:{a:true},ignore:{applet:1,canvas:1,col:1,colgroup:1,head:1,iframe:1,map:1,optgroup:1,option:1,script:1,select:1,style:1,textarea:1,title:1,pre:1},printable:true,selector:(window.Sizzle||(window.jQuery&&function(B){return jQuery(B)})||(window.dojo&&dojo.query)||(window.Ext&&Ext.query)||(window.YAHOO&&YAHOO.util&&YAHOO.util.Selector&&YAHOO.util.Selector.query)||(window.$$&&function(B){return $$(B)})||(window.$&&function(B){return $(B)})||(document.querySelectorAll&&function(B){return document.querySelectorAll(B)})||g),separate:"words",textless:{dl:1,html:1,ol:1,table:1,tbody:1,thead:1,tfoot:1,tr:1,ul:1},textShadow:"none"};var p={words:/\s/.test("\u00a0")?/[^\S\u00a0]+/:/\s+/,characters:"",none:/^/};m.now=function(){x.ready();return m};m.refresh=function(){y.repeat.apply(y,arguments);return m};m.registerEngine=function(C,B){if(!B){return m}z[C]=B;return m.set("engine",C)};m.registerFont=function(D){if(!D){return m}var B=new s(D),C=B.family;if(!i[C]){i[C]=new f()}i[C].add(B);return m.set("fontFamily",'"'+C+'"')};m.replace=function(D,C,B){C=h(w,C);if(!C.engine){return m}if(!e){n.addClass(x.root(),"cufon-active cufon-loading");n.ready(function(){n.addClass(n.removeClass(x.root(),"cufon-loading"),"cufon-ready")});e=true}if(C.hover){C.forceHitArea=true}if(C.autoDetect){delete C.fontFamily}if(typeof C.textShadow=="string"){C.textShadow=n.textShadow(C.textShadow)}if(typeof C.color=="string"&&/^-/.test(C.color)){C.textGradient=n.gradient(C.color)}else{delete C.textGradient}if(!B){y.add(D,arguments)}if(D.nodeType||typeof D=="string"){D=[D]}n.ready(function(){for(var F=0,E=D.length;F<E;++F){var G=D[F];if(typeof G=="string"){m.replace(C.selector(G),C,true)}else{l(G,C)}}});return m};m.set=function(B,C){w[B]=C;return m};return m})();Cufon.registerEngine("canvas",(function(){var b=document.createElement("canvas");if(!b||!b.getContext||!b.getContext.apply){return}b=null;var a=Cufon.CSS.supports("display","inline-block");var e=!a&&(document.compatMode=="BackCompat"||/frameset|transitional/i.test(document.doctype.publicId));var f=document.createElement("style");f.type="text/css";f.appendChild(document.createTextNode(("cufon{text-indent:0;}@media screen,projection{cufon{display:inline;display:inline-block;position:relative;vertical-align:middle;"+(e?"":"font-size:1px;line-height:1px;")+"}cufon cufontext{display:-moz-inline-box;display:inline-block;width:0;height:0;overflow:hidden;text-indent:-10000in;}"+(a?"cufon canvas{position:relative;}":"cufon canvas{position:absolute;}")+"}@media print{cufon{padding:0;}cufon canvas{display:none;}}").replace(/;/g,"!important;")));document.getElementsByTagName("head")[0].appendChild(f);function d(p,h){var n=0,m=0;var g=[],o=/([mrvxe])([^a-z]*)/g,k;generate:for(var j=0;k=o.exec(p);++j){var l=k[2].split(",");switch(k[1]){case"v":g[j]={m:"bezierCurveTo",a:[n+~~l[0],m+~~l[1],n+~~l[2],m+~~l[3],n+=~~l[4],m+=~~l[5]]};break;case"r":g[j]={m:"lineTo",a:[n+=~~l[0],m+=~~l[1]]};break;case"m":g[j]={m:"moveTo",a:[n=~~l[0],m=~~l[1]]};break;case"x":g[j]={m:"closePath"};break;case"e":break generate}h[g[j].m].apply(h,g[j].a)}return g}function c(m,k){for(var j=0,h=m.length;j<h;++j){var g=m[j];k[g.m].apply(k,g.a)}}return function(V,w,P,t,C,W){var k=(w===null);if(k){w=C.getAttribute("alt")}var A=V.viewBox;var m=P.getSize("fontSize",V.baseSize);var B=0,O=0,N=0,u=0;var z=t.textShadow,L=[];if(z){for(var U=z.length;U--;){var F=z[U];var K=m.convertFrom(parseFloat(F.offX));var I=m.convertFrom(parseFloat(F.offY));L[U]=[K,I];if(I<B){B=I}if(K>O){O=K}if(I>N){N=I}if(K<u){u=K}}}var Z=Cufon.CSS.textTransform(w,P).split("");var E=V.spacing(Z,~~m.convertFrom(parseFloat(P.get("letterSpacing"))||0),~~m.convertFrom(parseFloat(P.get("wordSpacing"))||0));if(!E.length){return null}var h=E.total;O+=A.width-E[E.length-1];u+=A.minX;var s,n;if(k){s=C;n=C.firstChild}else{s=document.createElement("cufon");s.className="cufon cufon-canvas";s.setAttribute("alt",w);n=document.createElement("canvas");s.appendChild(n);if(t.printable){var S=document.createElement("cufontext");S.appendChild(document.createTextNode(w));s.appendChild(S)}}var aa=s.style;var H=n.style;var j=m.convert(A.height);var Y=Math.ceil(j);var M=Y/j;var G=M*Cufon.CSS.fontStretch(P.get("fontStretch"));var J=h*G;var Q=Math.ceil(m.convert(J+O-u));var o=Math.ceil(m.convert(A.height-B+N));n.width=Q;n.height=o;H.width=Q+"px";H.height=o+"px";B+=A.minY;H.top=Math.round(m.convert(B-V.ascent))+"px";H.left=Math.round(m.convert(u))+"px";var r=Math.max(Math.ceil(m.convert(J)),0)+"px";if(a){aa.width=r;aa.height=m.convert(V.height)+"px"}else{aa.paddingLeft=r;aa.paddingBottom=(m.convert(V.height)-1)+"px"}var X=n.getContext("2d"),D=j/A.height;X.scale(D,D*M);X.translate(-u,-B);X.save();function T(){var x=V.glyphs,ab,l=-1,g=-1,y;X.scale(G,1);while(y=Z[++l]){var ab=x[Z[l]]||V.missingGlyph;if(!ab){continue}if(ab.d){X.beginPath();if(ab.code){c(ab.code,X)}else{ab.code=d("m"+ab.d,X)}X.fill()}X.translate(E[++g],0)}X.restore()}if(z){for(var U=z.length;U--;){var F=z[U];X.save();X.fillStyle=F.color;X.translate.apply(X,L[U]);T()}}var q=t.textGradient;if(q){var v=q.stops,p=X.createLinearGradient(0,A.minY,0,A.maxY);for(var U=0,R=v.length;U<R;++U){p.addColorStop.apply(p,v[U])}X.fillStyle=p}else{X.fillStyle=P.get("color")}T();return s}})());Cufon.registerEngine("vml",(function(){var e=document.namespaces;if(!e){return}e.add("cvml","urn:schemas-microsoft-com:vml");e=null;var b=document.createElement("cvml:shape");b.style.behavior="url(#default#VML)";if(!b.coordsize){return}b=null;var h=(document.documentMode||0)<8;document.write(('<style type="text/css">cufoncanvas{text-indent:0;}@media screen{cvml\\:shape,cvml\\:rect,cvml\\:fill,cvml\\:shadow{behavior:url(#default#VML);display:block;antialias:true;position:absolute;}cufoncanvas{position:absolute;text-align:left;}cufon{display:inline-block;position:relative;vertical-align:'+(h?"middle":"text-bottom")+";}cufon cufontext{position:absolute;left:-10000in;font-size:1px;}a cufon{cursor:pointer}}@media print{cufon cufoncanvas{display:none;}}</style>").replace(/;/g,"!important;"));function c(i,j){return a(i,/(?:em|ex|%)$|^[a-z-]+$/i.test(j)?"1em":j)}function a(l,m){if(m==="0"){return 0}if(/px$/i.test(m)){return parseFloat(m)}var k=l.style.left,j=l.runtimeStyle.left;l.runtimeStyle.left=l.currentStyle.left;l.style.left=m.replace("%","em");var i=l.style.pixelLeft;l.style.left=k;l.runtimeStyle.left=j;return i}function f(l,k,j,n){var i="computed"+n,m=k[i];if(isNaN(m)){m=k.get(n);k[i]=m=(m=="normal")?0:~~j.convertFrom(a(l,m))}return m}var g={};function d(p){var q=p.id;if(!g[q]){var n=p.stops,o=document.createElement("cvml:fill"),i=[];o.type="gradient";o.angle=180;o.focus="0";o.method="sigma";o.color=n[0][1];for(var m=1,l=n.length-1;m<l;++m){i.push(n[m][0]*100+"% "+n[m][1])}o.colors=i.join(",");o.color2=n[l][1];g[q]=o}return g[q]}return function(ac,G,Y,C,K,ad,W){var n=(G===null);if(n){G=K.alt}var I=ac.viewBox;var p=Y.computedFontSize||(Y.computedFontSize=new Cufon.CSS.Size(c(ad,Y.get("fontSize"))+"px",ac.baseSize));var y,q;if(n){y=K;q=K.firstChild}else{y=document.createElement("cufon");y.className="cufon cufon-vml";y.alt=G;q=document.createElement("cufoncanvas");y.appendChild(q);if(C.printable){var Z=document.createElement("cufontext");Z.appendChild(document.createTextNode(G));y.appendChild(Z)}if(!W){y.appendChild(document.createElement("cvml:shape"))}}var ai=y.style;var R=q.style;var l=p.convert(I.height),af=Math.ceil(l);var V=af/l;var P=V*Cufon.CSS.fontStretch(Y.get("fontStretch"));var U=I.minX,T=I.minY;R.height=af;R.top=Math.round(p.convert(T-ac.ascent));R.left=Math.round(p.convert(U));ai.height=p.convert(ac.height)+"px";var F=Y.get("color");var ag=Cufon.CSS.textTransform(G,Y).split("");var L=ac.spacing(ag,f(ad,Y,p,"letterSpacing"),f(ad,Y,p,"wordSpacing"));if(!L.length){return null}var k=L.total;var x=-U+k+(I.width-L[L.length-1]);var ah=p.convert(x*P),X=Math.round(ah);var O=x+","+I.height,m;var J="r"+O+"ns";var u=C.textGradient&&d(C.textGradient);var o=ac.glyphs,S=0;var H=C.textShadow;var ab=-1,aa=0,w;while(w=ag[++ab]){var D=o[ag[ab]]||ac.missingGlyph,v;if(!D){continue}if(n){v=q.childNodes[aa];while(v.firstChild){v.removeChild(v.firstChild)}}else{v=document.createElement("cvml:shape");q.appendChild(v)}v.stroked="f";v.coordsize=O;v.coordorigin=m=(U-S)+","+T;v.path=(D.d?"m"+D.d+"xe":"")+"m"+m+J;v.fillcolor=F;if(u){v.appendChild(u.cloneNode(false))}var ae=v.style;ae.width=X;ae.height=af;if(H){var s=H[0],r=H[1];var B=Cufon.CSS.color(s.color),z;var N=document.createElement("cvml:shadow");N.on="t";N.color=B.color;N.offset=s.offX+","+s.offY;if(r){z=Cufon.CSS.color(r.color);N.type="double";N.color2=z.color;N.offset2=r.offX+","+r.offY}N.opacity=B.opacity||(z&&z.opacity)||1;v.appendChild(N)}S+=L[aa++]}var M=v.nextSibling,t,A;if(C.forceHitArea){if(!M){M=document.createElement("cvml:rect");M.stroked="f";M.className="cufon-vml-cover";t=document.createElement("cvml:fill");t.opacity=0;M.appendChild(t);q.appendChild(M)}A=M.style;A.width=X;A.height=af}else{if(M){q.removeChild(M)}}ai.width=Math.max(Math.ceil(p.convert(k*P)),0);if(h){var Q=Y.computedYAdjust;if(Q===undefined){var E=Y.get("lineHeight");if(E=="normal"){E="1em"}else{if(!isNaN(E)){E+="em"}}Y.computedYAdjust=Q=0.5*(a(ad,E)-parseFloat(ai.height))}if(Q){ai.marginTop=Math.ceil(Q)+"px";ai.marginBottom=Q+"px"}}return y}})());

/*!
 * The following copyright notice may not be removed under any circumstances.
 * 
 * Copyright:
 * � 2008 Microsoft Corporation. All rights reserved.
 * 
 * Description:
 * Gautami is an OpenType font for the Indic script-Telugu. It is based on
 * Unicode, contains TrueType outlines and has been designed for use as a UI font.
 * 
 * Designer:
 * Raghunath Joshi (Type Director), Omkar Shende
 */
Cufon.registerFont({"w":184,"face":{"font-family":"Gautami","font-weight":400,"font-stretch":"normal","units-per-em":"360","panose-1":"2 11 5 2 4 2 4 2 2 3","ascent":"288","descent":"-72","x-height":"4","bbox":"-246 -381 551 145.151","underline-thickness":"16.875","underline-position":"-97.0312","unicode-range":"U+0020-U+25CC"},"glyphs":{" ":{"w":112},"\u200b":{"w":0},"\u00a0":{"w":112},"\u0c01":{"d":"39,-75v0,26,22,43,48,43r0,36v-66,3,-102,-88,-54,-133v15,-15,33,-22,54,-22r0,28v-26,-1,-49,22,-48,48","w":98},"\u0c02":{"d":"87,-151v41,0,75,36,75,76v0,43,-33,79,-75,79v-43,0,-76,-36,-76,-79v0,-41,35,-76,76,-76xm87,-32v25,0,47,-18,47,-43v0,-26,-21,-48,-47,-48v-26,-1,-49,22,-48,48v0,26,22,43,48,43","w":173},"\u0c03":{"d":"31,-53v18,0,30,12,30,30v0,17,-12,30,-30,30v-18,0,-30,-12,-30,-30v0,-18,13,-30,30,-30xm31,-42v-23,0,-25,38,0,37v27,0,21,-36,0,-37xm31,-147v18,0,30,12,30,30v0,17,-12,30,-30,30v-18,0,-29,-12,-30,-30v0,-18,12,-30,30,-30xm31,-136v-23,0,-25,38,0,37v11,0,18,-8,19,-18v-1,-10,-9,-19,-19,-19","w":61},"\u0c05":{"d":"189,-176v33,0,57,33,57,68v0,66,-50,112,-116,112v-65,1,-119,-47,-119,-112v0,-33,24,-68,56,-68v26,0,47,22,47,48v0,35,-44,62,-73,38v8,39,38,58,89,58v52,1,88,-26,88,-76v0,-22,-9,-40,-29,-40v-10,-1,-20,10,-19,20v-1,10,10,19,19,19r0,28r-62,0r0,-28r19,0v-15,-33,11,-67,43,-67xm42,-128v3,22,45,27,44,0v-1,-31,-39,-21,-44,0","w":257},"\u0c06":{"d":"207,-176v50,0,62,73,20,90v37,51,-40,92,-97,90v-69,-3,-117,-44,-119,-112v-1,-34,22,-68,55,-68v26,0,47,22,47,48v0,35,-44,62,-73,38v7,37,44,58,90,58v34,0,106,-17,68,-43r-60,0r0,-29r32,0v-28,-26,2,-72,37,-72xm207,-148v-23,0,-27,36,-5,44v30,0,31,-42,5,-44xm42,-128v3,21,43,27,43,0v0,-30,-39,-21,-43,0","w":265},"\u0c07":{"d":"124,-151v29,-47,113,-22,113,45v0,29,-12,54,-36,76v5,8,14,31,13,44r-28,0v0,-12,-2,-22,-7,-29v-31,29,-107,26,-104,-28v3,-56,83,-51,110,-10v26,-20,39,-94,-11,-95v-21,-1,-37,16,-36,37r-28,0v1,-21,-15,-37,-36,-37v-30,0,-45,39,-25,59r-19,20v-40,-36,-11,-107,44,-107v21,0,38,8,50,25xm104,-43v2,26,42,18,59,5v-12,-17,-53,-33,-59,-5","w":248},"\u0c08":{"d":"276,-117v1,-17,-24,-25,-32,-10r-19,-12v17,-30,76,-19,73,22v0,10,-3,18,-9,25v25,21,11,66,-23,65v-26,-1,-43,-24,-33,-50r-22,0v-7,47,-38,81,-87,81v-49,0,-80,-34,-87,-81r-26,0r0,-22r26,0v4,-34,24,-56,50,-69r-13,-15r16,-16v10,10,17,24,34,23v22,-1,46,-32,60,-51r19,17v-16,21,-29,35,-39,44v27,14,43,36,47,67v26,-2,64,8,65,-18xm183,-99v-4,-51,-87,-65,-110,-20v-4,6,-7,13,-8,20r118,0xm65,-77v3,50,90,60,111,18v4,-6,6,-11,7,-18r-118,0xm266,-49v7,0,14,-7,14,-14v0,-7,-7,-14,-14,-14v-7,0,-14,7,-14,14v0,7,7,14,14,14","w":313},"\u0c09":{"d":"209,-71v18,0,33,16,33,33v0,23,-26,43,-50,42v-28,0,-47,-13,-59,-37v-6,19,-28,36,-51,37v-43,0,-71,-37,-71,-81v0,-61,50,-99,111,-99r0,-35r22,0r0,35v23,0,46,5,70,16r-14,26v-48,-24,-142,-18,-155,26r192,0r0,22r-197,0v-5,32,11,54,42,54v24,0,36,-10,36,-32r28,0v0,20,11,33,33,40v-11,-23,7,-47,30,-47xm209,-50v-15,-1,-15,21,-5,28v19,3,23,-29,5,-28","w":248},"\u0c0a":{"d":"290,-128v1,-18,-24,-22,-32,-9r-19,-12v16,-29,74,-19,71,21v0,9,-3,16,-9,24v27,18,14,67,-21,65v-25,-1,-41,-21,-34,-47r-206,0v-5,32,11,54,42,54v24,0,36,-10,36,-32r28,0v0,20,11,33,33,40v-9,-24,5,-48,30,-47v20,0,33,13,33,33v0,29,-22,42,-50,42v-28,0,-47,-13,-59,-37v-8,21,-25,37,-51,37v-46,0,-71,-34,-71,-81v0,-58,39,-89,91,-97r0,-37r23,0r0,35r22,0r0,-35r22,0r0,37v16,1,31,6,45,14r-14,26v-42,-24,-145,-17,-154,26r226,0v11,-1,17,-10,18,-20xm280,-61v7,0,15,-7,14,-14v0,-19,-28,-17,-28,0v-1,7,7,14,14,14xm209,-50v-15,-1,-15,21,-5,28v19,3,23,-29,5,-28","w":327},"\u0c0b":{"d":"418,-81v-1,-40,-24,-62,-60,-68r6,-27v47,10,78,40,82,95v6,73,-82,115,-122,57v-27,37,-79,37,-104,0v-25,35,-76,38,-101,2v-32,56,-129,11,-103,-55v11,-27,66,-17,66,-53v0,-12,-6,-18,-17,-18v-9,0,-17,7,-17,18r-28,0v1,-28,18,-45,45,-46v52,-2,59,82,12,92v-14,7,-38,9,-38,27v0,17,11,25,32,25v21,0,33,-10,34,-30r28,0v0,20,12,30,35,30v27,0,41,-16,41,-49v0,-41,-25,-62,-61,-67r7,-28v53,11,88,49,81,117v15,48,82,26,78,-22v-3,-39,-24,-63,-61,-67r6,-28v54,10,89,51,81,116v3,19,15,28,35,28v28,1,44,-20,43,-49","w":457},"\u0c0c":{"d":"99,-99v26,2,76,16,74,-22v0,-14,-12,-27,-26,-27v-15,0,-27,12,-27,27r-28,0v0,-15,-12,-27,-27,-27v-19,-1,-33,24,-22,41v-7,6,-6,7,-20,19v-30,-33,0,-90,42,-88v16,0,29,7,41,20v30,-41,95,-13,95,35v0,49,-51,63,-102,51v-17,0,-25,4,-25,14v0,22,36,28,63,28v51,1,97,-39,96,-89v0,-16,-5,-27,-17,-31r0,-28v25,3,44,30,44,59v0,67,-57,122,-123,121v-46,0,-91,-20,-91,-60v0,-27,23,-45,53,-43","w":271},"\u0c0e":{"d":"67,-247v82,-2,149,66,149,147v0,58,-25,103,-78,104v-19,0,-33,-8,-41,-24v-24,37,-86,17,-86,-27v0,-26,22,-49,48,-48v43,-8,34,64,79,63v33,0,49,-22,49,-68v0,-69,-52,-120,-120,-119r0,-28xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":226},"\u0c0f":{"d":"37,-232v0,19,9,31,26,31r0,29v-44,1,-74,-66,-39,-99v11,-10,24,-16,39,-16r0,29v-14,-1,-26,11,-26,26xm67,-247v82,-2,149,66,149,147v0,58,-25,103,-78,104v-19,0,-33,-8,-41,-24v-24,37,-86,17,-86,-27v0,-26,22,-49,48,-48v24,0,39,13,46,39v5,16,16,24,33,24v33,0,49,-22,49,-68v0,-69,-52,-120,-120,-119r0,-28xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":235},"\u0c10":{"d":"120,-156v50,-50,117,2,117,71v0,73,-87,120,-140,65v-24,37,-86,17,-86,-27v0,-40,55,-66,80,-33v6,7,11,18,14,31v26,32,113,18,104,-36v2,-30,-18,-62,-41,-63v-15,0,-36,14,-36,27r-28,0v0,-19,-13,-27,-35,-27v-17,0,-30,11,-30,27r-28,0v-5,-54,79,-72,109,-35xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":248},"\u0c12":{"d":"174,-32v36,0,46,-45,22,-63r21,-20v41,39,15,120,-43,119v-24,0,-40,-10,-50,-29v-24,52,-130,28,-112,-43v8,-30,38,-29,65,-47v9,-10,6,-36,-12,-33v-9,1,-17,7,-17,18r-28,0v1,-28,18,-45,45,-46v52,-2,59,82,12,92v-14,7,-38,9,-38,27v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v-1,20,15,33,36,33","w":248},"\u0c13":{"d":"174,-32v36,0,46,-45,22,-63r21,-20v41,39,15,120,-43,119v-24,0,-40,-10,-50,-29v-24,52,-130,28,-112,-43v8,-30,38,-29,65,-47v9,-10,6,-36,-12,-33v-9,1,-17,7,-17,18r-28,0v0,-24,15,-37,32,-44v-11,-47,46,-73,78,-43r-20,20v-15,-15,-41,5,-28,25v28,8,37,59,11,79v-17,13,-49,12,-54,36v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v-1,20,15,33,36,33","w":248},"\u0c14":{"d":"174,-32v36,0,46,-45,22,-63r21,-20v41,39,15,120,-43,119v-24,0,-40,-10,-50,-29v-24,52,-130,28,-112,-43v8,-30,38,-29,65,-47v9,-10,6,-36,-12,-33v-9,1,-17,7,-17,18r-28,0v0,-9,2,-18,6,-23r-4,0r0,-23r79,0v8,0,11,-3,11,-11v0,-5,-5,-11,-11,-11r-97,0r0,-23r220,0v26,2,43,18,43,46v0,27,-17,44,-43,45v-34,2,-55,-40,-35,-68r-56,0v5,26,-8,42,-30,45v21,37,-10,70,-43,76v-10,5,-21,8,-21,20v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v-1,20,15,33,36,33xm224,-154v12,-1,22,-7,21,-21v0,-16,-10,-24,-28,-22v-23,3,-17,45,7,43","w":278},"\u0c15":{"d":"65,-199v37,45,56,19,101,-35r19,17v-12,16,-27,37,-42,48v17,9,28,22,29,46r-29,0v-1,-34,-95,-36,-95,0v0,23,26,21,51,21v45,1,83,5,83,49v0,77,-143,68,-167,18v-3,-5,-4,-11,-4,-18r31,0v4,36,116,32,112,0v-2,-23,-29,-21,-55,-21v-46,0,-80,-5,-79,-49v0,-27,16,-42,39,-49r-10,-11","w":198},"\u0c16":{"d":"171,-176v52,0,90,40,90,93v0,78,-90,115,-142,62v-27,34,-104,37,-104,-18v0,-50,69,-45,98,-18v14,-21,11,-55,-5,-72v-5,43,-76,38,-76,-8v0,-24,19,-39,44,-39v59,0,96,80,60,134v34,21,96,10,96,-41v0,-37,-26,-65,-63,-65xm119,43v-21,-5,-16,-29,0,-43v17,14,23,38,0,43xm74,-152v-20,-2,-24,28,-4,29v12,0,21,-9,21,-21v-6,-5,-12,-8,-17,-8xm96,-38v-14,-12,-51,-27,-56,-1v2,22,45,15,56,1","w":270},"\u0c17":{"d":"139,-166v53,25,61,109,27,166r-26,-14v35,-52,20,-134,-41,-134v-60,0,-77,83,-41,134r-26,14v-35,-59,-25,-143,31,-167v-2,-3,-3,-3,-14,-16r16,-16v32,56,84,-10,101,-35r19,17v-20,27,-26,35,-46,51","w":198},"\u0c18":{"d":"288,-176v41,0,81,46,81,91v0,47,-36,90,-82,89v-36,-1,-51,-11,-68,-34v-26,40,-93,47,-122,10v-24,37,-86,17,-86,-27v0,-41,55,-66,81,-32v6,8,11,18,13,30v30,32,104,18,104,-36v0,-34,-26,-63,-58,-63r5,-28v48,1,93,55,79,113v0,21,28,31,52,31v32,0,54,-22,54,-53v0,-34,-27,-63,-59,-63xm27,-195v33,50,75,3,101,-35r19,17v-34,52,-93,103,-136,34xm95,43v-21,-4,-16,-33,0,-43v10,10,15,19,15,28v1,8,-7,16,-15,15xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":379},"\u0c19":{"d":"174,-32v36,0,46,-45,22,-63r21,-20v41,39,15,120,-43,119v-24,0,-40,-10,-50,-29v-24,52,-130,28,-112,-43v8,-30,38,-29,65,-47v9,-10,6,-36,-12,-33v-9,1,-17,7,-17,18r-28,0v1,-28,18,-46,45,-46v24,0,39,16,44,36r31,0r0,-36r23,0r0,36r31,0r0,24r-86,0v-6,37,-59,28,-69,59v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v-1,20,15,33,36,33","w":248},"\u0c1a":{"d":"165,-169v44,11,72,46,72,103v0,66,-87,96,-113,41v-25,55,-113,24,-113,-40v0,-15,5,-28,14,-37r-23,0r0,-25r73,0r0,25v-20,0,-37,17,-36,37v0,20,15,33,35,33v19,0,37,-13,36,-33r28,0v0,19,16,33,36,33v22,0,35,-12,35,-34v1,-58,-32,-82,-90,-82v-26,0,-32,-13,-50,-35r16,-16v37,46,56,19,101,-35r19,17v-15,20,-27,35,-40,48","w":248},"\u0c1b":{"d":"165,-169v44,11,72,46,72,103v0,66,-87,96,-113,41v-25,55,-113,24,-113,-40v0,-15,5,-28,14,-37r-23,0r0,-25r73,0r0,25v-20,0,-37,17,-36,37v0,20,15,33,35,33v19,0,37,-13,36,-33r28,0v0,19,16,33,36,33v22,0,35,-12,35,-34v1,-58,-32,-82,-90,-82v-26,0,-32,-13,-50,-35r16,-16v37,46,56,19,101,-35r19,17v-15,20,-27,35,-40,48xm140,28v0,18,-30,19,-30,0v0,-10,5,-19,15,-28v10,10,15,19,15,28","w":248},"\u0c1c":{"d":"174,-32v36,0,46,-45,22,-63r21,-20v41,39,15,120,-43,119v-24,0,-40,-10,-50,-29v-24,52,-130,28,-112,-43v8,-30,38,-29,65,-47v9,-10,6,-36,-12,-33v-9,1,-17,7,-17,18r-28,0v1,-28,18,-46,45,-46v28,0,45,21,45,52v13,14,63,24,63,-5v0,-13,-10,-19,-29,-19r0,-28v32,1,55,14,55,45v0,47,-67,55,-99,31v-13,21,-54,17,-61,43v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v-1,20,15,33,36,33","w":248},"\u0c1d":{"d":"365,-176v41,-1,82,46,82,91v0,50,-34,91,-83,89v-34,-1,-47,-12,-64,-35v-25,46,-109,46,-132,-2v-10,20,-40,37,-69,37v-48,1,-89,-43,-88,-92v0,-37,24,-67,51,-80r-13,-15r16,-16v37,45,59,19,101,-35r19,17v-22,29,-25,34,-45,51v32,15,53,54,45,101v6,17,28,33,50,33v32,0,55,-21,55,-53v0,-34,-26,-63,-58,-63r5,-28v47,2,90,52,80,111v16,53,102,39,102,-20v0,-33,-28,-63,-59,-63xm300,43v-22,-5,-17,-30,0,-43v17,14,23,38,0,43xm99,-32v34,0,60,-24,60,-56v0,-33,-28,-60,-60,-60v-32,0,-60,28,-60,60v0,32,26,56,60,56","w":457},"\u0c1e":{"d":"124,-151v20,-35,94,-34,107,11r20,0r0,-36r24,0r0,36r25,0r0,24r-63,0v2,38,-10,60,-36,86v5,8,14,31,13,44r-28,0v0,-12,-2,-22,-7,-29v-32,31,-107,24,-104,-28v3,-56,83,-51,110,-10v26,-20,39,-94,-11,-95v-21,-1,-37,16,-36,37r-28,0v1,-21,-15,-37,-36,-37v-30,0,-45,39,-25,59r-19,20v-40,-36,-11,-107,44,-107v21,0,38,8,50,25xm104,-43v2,26,42,18,59,5v-12,-17,-53,-33,-59,-5","w":310},"\u0c1f":{"d":"165,-176v90,2,105,180,8,180v-22,0,-38,-9,-47,-26v-8,17,-22,26,-45,26v-87,0,-94,-161,-25,-178r0,-44r23,0r0,44v21,5,35,20,36,46v2,41,-51,62,-76,33v-5,33,9,64,42,63v18,-1,31,-11,31,-30r28,0v0,20,11,30,33,30v28,0,38,-22,39,-49v1,-37,-19,-62,-49,-68xm44,-128v2,21,44,28,43,0v-1,-31,-39,-20,-43,0","w":248},"\u0c20":{"d":"139,-166v28,14,47,41,48,78v1,52,-38,92,-88,92v-52,0,-88,-41,-88,-92v1,-37,23,-67,51,-80r-13,-15r16,-16v33,50,76,3,101,-35r19,17v-20,26,-26,35,-46,51xm99,-32v33,1,60,-22,60,-56v0,-33,-28,-60,-60,-60v-32,0,-60,28,-60,60v0,33,27,56,60,56xm99,-102v7,0,14,7,14,14v0,7,-7,14,-14,14v-7,0,-14,-7,-14,-14v0,-7,7,-14,14,-14","w":198},"\u0c21":{"d":"202,-71v18,0,33,16,33,33v0,25,-24,42,-51,42v-28,0,-46,-13,-58,-37v-9,24,-27,37,-52,37v-38,0,-63,-30,-63,-70v0,-50,35,-89,75,-103v-4,-5,-3,-5,-11,-14r16,-16v33,50,74,4,101,-35r19,17v-21,25,-25,34,-45,50v15,6,28,15,40,27r-19,19v-49,-55,-149,-16,-148,53v0,21,12,37,34,37v25,0,37,-11,37,-33r28,0v0,21,12,33,34,40v-13,-22,7,-47,30,-47xm202,-50v-16,0,-16,21,-5,28v19,3,23,-27,5,-28","w":248},"\u0c22":{"d":"202,-71v18,0,33,16,33,33v0,25,-24,42,-51,42v-28,0,-46,-13,-58,-37v-9,24,-27,37,-52,37v-39,1,-64,-30,-63,-70v0,-50,35,-89,75,-103v-4,-5,-3,-5,-11,-14r16,-16v33,50,74,4,101,-35r19,17v-21,25,-25,34,-45,50v15,6,28,15,40,27r-19,19v-49,-55,-149,-16,-148,53v0,21,12,37,34,37v25,0,37,-11,37,-33r28,0v0,21,12,33,34,40v-13,-22,7,-47,30,-47xm126,43v-21,-5,-16,-29,0,-43v17,14,23,38,0,43xm202,-50v-16,0,-16,21,-5,28v19,3,23,-27,5,-28","w":248},"\u0c23":{"d":"115,-151v46,-59,122,-6,122,68v0,44,-18,87,-58,87v-25,0,-46,-25,-46,-50v0,-38,49,-63,77,-33v2,-36,-14,-69,-45,-69v-19,0,-36,14,-35,34r-28,0v0,-20,-13,-32,-32,-34v-36,-4,-42,48,-10,49r6,0r0,28v-17,-2,-27,8,-27,22v1,11,9,21,21,21v14,0,21,-7,21,-21r28,0v0,29,-21,53,-49,53v-43,1,-66,-61,-33,-89v-35,-28,-8,-91,43,-91v18,0,33,8,45,25xm162,-46v0,10,7,18,17,18v15,0,24,-9,26,-25v-12,-15,-43,-16,-43,7","w":248},"\u0c24":{"d":"169,-174v44,-6,67,32,68,71v1,69,-44,107,-114,107v-59,0,-113,-33,-112,-90v0,-31,16,-58,46,-58v21,0,39,17,39,38v0,28,-31,50,-58,34v9,27,37,40,85,40v47,0,76,-13,87,-40v-26,16,-57,-6,-57,-34v0,-26,24,-40,51,-32v-22,-24,-88,5,-115,-21v-4,-4,-11,-12,-21,-24r16,-16v35,47,71,9,101,-35r19,17v-7,10,-19,24,-35,43xm176,-106v1,19,30,21,35,2v0,-20,-35,-23,-35,-2xm37,-104v2,18,35,19,35,-2v0,-14,-18,-20,-28,-10v-4,3,-6,7,-7,12","w":248},"\u0c25":{"d":"167,-168v40,15,70,48,70,102v0,63,-84,97,-113,41v-7,16,-28,28,-50,29v-36,0,-63,-32,-63,-70v-1,-55,33,-90,75,-103r-11,-14r16,-16v33,50,75,2,101,-35r19,17v-24,30,-23,31,-44,49xm125,46v-23,-3,-16,-28,0,-42v16,14,23,38,0,42xm174,-32v22,0,35,-12,35,-34v-1,-48,-30,-82,-85,-82v-55,0,-85,35,-85,82v0,21,13,34,35,34v21,1,37,-12,36,-33r28,0v0,20,14,34,36,33xm124,-115v7,0,14,7,14,14v0,7,-7,14,-14,14v-7,0,-14,-7,-14,-14v0,-7,7,-14,14,-14","w":248},"\u0c26":{"d":"167,-168v43,15,67,50,70,102v3,63,-84,97,-113,41v-7,16,-28,28,-50,29v-36,0,-63,-32,-63,-70v1,-54,29,-89,75,-103r-11,-14r16,-16v33,50,75,2,101,-35r19,17v-24,30,-23,31,-44,49xm174,-32v22,0,35,-12,35,-34v-1,-50,-30,-82,-85,-82v-55,0,-85,33,-85,82v0,21,13,34,35,34v21,1,37,-12,36,-33r28,0v0,20,14,34,36,33","w":248},"\u0c27":{"d":"167,-168v40,13,70,51,70,102v0,63,-84,97,-113,41v-7,16,-28,28,-50,29v-36,0,-63,-32,-63,-70v-1,-53,33,-91,75,-103r-11,-14r16,-16v34,50,74,3,101,-35r19,17v-25,31,-24,31,-44,49xm140,28v0,18,-30,19,-30,0v0,-9,5,-18,15,-28v10,10,15,19,15,28xm174,-32v22,0,35,-12,35,-34v-1,-50,-30,-82,-85,-82v-55,0,-85,33,-85,82v0,21,13,34,35,34v22,0,36,-11,36,-33r28,0v0,21,14,33,36,33","w":248},"\u0c28":{"d":"59,-199v27,51,81,0,101,-35r19,17r-36,42v57,5,89,39,94,100v6,73,-86,106,-123,50v-12,-19,-16,-46,-46,-48v-38,-2,-31,47,-7,56r-17,24v-14,-13,-32,-28,-32,-53v0,-34,19,-57,56,-57v61,0,48,73,101,73v27,0,40,-17,40,-45v2,-72,-65,-74,-134,-75v-16,-7,-23,-20,-35,-32","w":248},"\u0c2a":{"d":"16,-195v34,46,72,8,100,-35r19,17v-34,52,-91,104,-135,34xm146,-176v51,0,91,39,91,93v0,77,-88,115,-140,63v-24,37,-86,17,-86,-27v0,-39,51,-64,78,-34v10,11,16,38,39,45v40,12,81,-10,81,-47v0,-41,-29,-65,-69,-65xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":248},"\u0c2b":{"d":"16,-195v34,46,72,8,100,-35r19,17v-34,52,-91,104,-135,34xm146,-176v51,0,91,39,91,93v0,76,-88,115,-140,63v-24,37,-86,17,-86,-27v0,-26,22,-49,48,-48v20,0,36,15,48,44v24,35,102,18,102,-32v0,-41,-29,-65,-69,-65xm112,28v-1,18,-29,19,-30,0v0,-9,5,-18,15,-28v10,10,15,19,15,28xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":248},"\u0c2c":{"d":"209,-81v-1,-38,-18,-62,-51,-69r12,-26v40,13,67,45,67,95v0,46,-19,83,-66,84v-24,0,-39,-12,-47,-28v-21,49,-119,32,-113,-32v2,-20,10,-29,23,-38v-28,-24,-11,-81,31,-81v52,0,59,82,12,92v-14,7,-38,9,-38,27v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v0,20,13,33,33,33v27,-1,38,-21,38,-49xm49,-122v6,17,35,16,33,-8v0,-12,-6,-18,-17,-18v-12,1,-20,12,-16,26","w":248},"\u0c2d":{"d":"209,-81v0,-50,-31,-73,-81,-71v-18,-7,-26,-18,-39,-31r18,-18v10,17,41,38,59,12v13,-10,27,-30,39,-45r19,17r-39,47v29,17,52,44,52,89v0,46,-19,83,-66,84v-24,0,-39,-12,-47,-28v-24,52,-130,28,-112,-43v8,-30,38,-29,65,-47v9,-10,6,-36,-12,-33v-9,1,-17,7,-17,18r-28,0v1,-28,18,-45,45,-46v52,-2,59,82,12,92v-14,7,-38,9,-38,27v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v0,20,13,33,33,33v27,-1,38,-21,38,-49xm139,32v0,18,-30,18,-30,0v0,-9,5,-18,15,-28v10,10,15,19,15,28","w":248},"\u0c2e":{"d":"288,-176v41,0,81,46,81,91v0,49,-33,90,-82,89v-36,-1,-51,-12,-68,-34v-27,40,-92,46,-122,10v-24,37,-86,17,-86,-27v0,-26,22,-49,48,-48v51,2,33,63,95,63v32,0,56,-21,55,-53v0,-57,-53,-63,-116,-63v-25,0,-32,-15,-50,-35r16,-16v36,46,59,18,101,-35r19,17v-14,18,-26,31,-35,41v61,-2,103,50,91,114v9,20,26,30,52,30v32,1,53,-22,53,-53v0,-35,-26,-63,-58,-63xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":379},"\u0c2f":{"d":"365,-176v42,-1,82,46,82,91v0,84,-111,121,-147,54v-19,48,-117,46,-132,-2v-14,20,-38,36,-69,37v-50,1,-88,-41,-88,-92v0,-47,41,-89,88,-88v54,0,99,50,86,111v1,18,30,33,50,33v32,0,53,-21,53,-53v0,-35,-26,-62,-59,-63v-26,-1,-33,-14,-50,-35r16,-16v35,51,73,3,101,-35r19,17v-18,23,-34,40,-47,51v32,15,56,54,47,101v8,22,24,33,49,33v32,1,55,-22,55,-53v0,-34,-25,-64,-59,-63xm99,-32v33,0,60,-22,60,-56v0,-33,-28,-60,-60,-60v-32,0,-60,28,-60,60v0,31,26,56,60,56","w":457},"\u0c30":{"d":"140,-166v27,14,46,41,47,78v1,52,-37,92,-88,92v-51,0,-89,-40,-88,-92v0,-37,24,-67,51,-80r-13,-15r16,-16v36,44,60,19,101,-35r20,17v-18,22,-33,40,-46,51xm99,-32v33,1,60,-22,60,-56v0,-33,-28,-60,-60,-60v-32,0,-60,28,-60,60v0,33,27,56,60,56","w":198},"\u0c31":{"d":"191,-176v47,2,59,46,59,95v0,49,-23,85,-70,85v-25,0,-43,-9,-52,-26v-39,57,-124,10,-119,-59v4,-49,15,-95,61,-95v34,0,52,32,42,67r36,0v-15,-31,9,-69,43,-67xm191,-148v-27,0,-24,39,0,39r0,28v-51,-5,-118,12,-151,-11v-5,33,9,60,41,60v19,-1,32,-11,33,-30r28,0v0,20,13,30,38,30v55,0,55,-116,11,-116xm46,-129v1,21,41,29,41,1v0,-30,-38,-21,-41,-1","w":259},"\u0c32":{"d":"177,-176v36,3,60,35,60,75v0,58,-50,105,-108,105v-71,0,-118,-43,-118,-112v0,-35,24,-68,57,-68v26,0,47,22,47,48v0,37,-50,64,-75,35v5,82,173,81,169,-8v0,-22,-14,-44,-32,-47r0,-28xm43,-129v2,23,44,28,44,1v0,-25,-38,-27,-44,-1","w":248},"\u0c33":{"d":"109,-199v34,50,74,4,101,-35r19,17v-13,19,-27,34,-41,46v48,29,8,106,-40,110v15,29,-5,65,-38,65v-31,0,-52,-37,-37,-65v-33,-8,-61,-39,-62,-76v0,-20,19,-39,39,-39v44,0,52,72,8,76v30,29,126,19,124,-30v-1,-32,-52,-7,-68,-29v-5,-4,-12,-12,-21,-24xm43,-117v24,0,29,-32,7,-34v-21,-2,-19,27,-7,34xm110,-28v7,0,14,-7,14,-14v0,-7,-7,-14,-14,-14v-7,0,-14,7,-14,14v0,7,7,14,14,14","w":221},"\u0c35":{"d":"144,-176v53,-3,93,41,93,91v0,78,-92,117,-140,65v-24,37,-86,17,-86,-27v0,-26,22,-48,48,-48v51,0,32,73,95,63v31,1,55,-22,55,-53v0,-57,-53,-63,-116,-63v-25,0,-32,-15,-50,-35r16,-16v33,50,76,3,101,-35r19,17v-14,18,-26,31,-35,41xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":248},"\u0c36":{"d":"120,-176v64,-13,92,66,38,89v24,38,-2,92,-45,91v-36,0,-54,-19,-54,-55v0,-24,20,-41,42,-45v-29,-6,-56,3,-70,22r-20,-21v28,-34,90,-38,128,-13v26,-6,29,-40,-6,-40v-34,0,-72,8,-92,-11v-4,-4,-11,-12,-21,-24r16,-16v33,50,76,3,101,-35r19,17v-13,17,-25,30,-36,41xm113,-28v25,1,34,-35,17,-51v-25,7,-43,9,-43,30v0,14,9,21,26,21","w":198},"\u0c37":{"d":"49,-172v27,0,48,-34,67,-58r19,17v-32,55,-96,100,-135,34r18,-16v9,8,14,23,31,23xm209,-88v-3,-40,-30,-58,-69,-60r6,-28v79,-2,101,69,87,149v2,27,10,49,33,55r-15,29v-25,-12,-43,-38,-45,-72v-22,27,-91,22,-111,-2v-23,32,-84,14,-84,-30v0,-51,77,-65,90,-21v17,56,113,43,108,-20xm59,-67v-27,0,-24,40,0,39v12,-1,22,-8,22,-21v-4,-12,-11,-18,-22,-18","w":248},"\u0c38":{"d":"143,-176v58,5,88,40,94,101v7,73,-86,106,-123,50v-12,-19,-16,-46,-46,-48v-38,-2,-31,47,-7,56r-17,24v-14,-13,-32,-28,-32,-53v0,-34,19,-57,56,-57v61,0,48,73,101,73v27,0,40,-17,40,-45v-1,-49,-31,-71,-78,-73xm49,-172v27,0,48,-34,67,-58r19,17v-32,55,-96,100,-135,34r18,-16v9,8,14,23,31,23","w":248},"\u0c39":{"d":"298,-176v24,-1,43,22,43,46v0,24,-19,45,-43,45v-31,0,-53,-33,-40,-63r-47,0v50,47,25,159,-57,152v-30,-3,-38,-8,-57,-24v-24,37,-86,17,-86,-27v0,-26,22,-49,48,-48v48,0,33,63,95,63v29,0,55,-20,55,-49v0,-46,-35,-67,-84,-67r0,-28r173,0xm16,-195v34,49,71,7,100,-35r19,17v-34,52,-92,103,-135,34xm298,-109v12,0,21,-9,21,-21v0,-12,-10,-22,-21,-22v-12,0,-21,11,-22,22v0,11,10,21,22,21xm39,-47v2,28,41,22,42,-2v-5,-26,-41,-22,-42,2","w":352},"\u0c3e":{"d":"54,-176v24,-1,44,23,44,46v0,23,-20,45,-44,45v-30,0,-52,-34,-39,-63r-213,0r0,-28r252,0xm54,-109v12,0,22,-9,22,-21v0,-12,-10,-22,-22,-22v-11,0,-21,10,-21,22v0,12,9,21,21,21","w":108},"\u0c3f":{"d":"-190,-266v29,0,55,27,55,56v0,57,-75,75,-111,35r16,-16v26,29,83,12,70,-30v-12,37,-65,24,-65,-11v0,-18,17,-34,35,-34xm-202,-232v0,11,14,14,22,7v4,-3,7,-6,8,-11v-7,-9,-30,-11,-30,4","w":0},"\u0c40":{"d":"-191,-266v30,0,56,25,56,56v0,57,-75,75,-111,35r16,-16v26,29,83,12,70,-30v-9,37,-67,24,-65,-11v0,-8,3,-16,9,-22v-21,-20,-2,-57,25,-57v17,0,35,16,33,34r-22,0v0,-8,-3,-11,-11,-11v-6,0,-11,5,-11,11v0,8,3,11,11,11xm-202,-232v2,18,30,11,32,-4v-7,-8,-32,-12,-32,4","w":0},"\u0c41":{"d":"34,-176v48,-1,88,42,88,91v0,73,-82,116,-137,70v-17,-13,-24,-30,-24,-51r28,0v-1,21,28,34,51,34v32,0,54,-22,54,-53v0,-35,-26,-63,-60,-63r0,-28","w":133},"\u0c42":{"d":"183,-176v24,-1,44,22,43,46v0,23,-19,45,-43,45v-31,0,-53,-33,-40,-63r-45,0v50,51,18,152,-58,152v-41,0,-80,-32,-79,-70r28,0v-1,22,28,34,51,34v32,0,54,-22,54,-53v0,-35,-26,-63,-60,-63r0,-28r149,0xm183,-109v12,0,21,-9,21,-21v0,-12,-9,-22,-21,-22v-12,0,-22,10,-22,22v0,11,10,21,22,21","w":237},"\u0c43":{"d":"43,71v21,1,38,-29,38,-51v0,-47,-25,-90,-76,-129r15,-17v56,47,83,96,83,146v0,38,-31,75,-67,75v-28,0,-55,-22,-55,-51v0,-20,16,-37,37,-37v32,0,50,44,25,64xm18,29v-21,2,-17,36,2,39v15,-5,19,-39,-2,-39","w":112},"\u0c44":{"d":"140,-137v24,-1,44,22,44,45v0,23,-20,45,-44,45v-30,0,-52,-32,-39,-62r-63,0v43,41,65,84,65,129v0,38,-31,75,-67,75v-28,0,-55,-22,-55,-51v0,-20,16,-37,37,-37v32,0,50,44,25,64v21,1,38,-29,38,-51v0,-47,-25,-90,-76,-129r0,-28r135,0xm140,-71v12,0,22,-9,22,-21v0,-12,-10,-22,-22,-22v-11,0,-21,10,-21,22v0,12,9,21,21,21xm18,29v-21,2,-17,36,2,39v15,-5,19,-39,-2,-39","w":194},"\u0c46":{"d":"-81,-223v20,0,39,14,38,35v0,36,-41,38,-81,35r0,-23v20,-3,57,8,58,-12v0,-8,-5,-12,-15,-12r-127,0r0,-23r127,0","w":0},"\u0c47":{"d":"-91,-223v28,-3,47,11,48,35v1,37,-41,37,-81,35r0,-23v21,-3,59,9,59,-12v0,-8,-5,-12,-13,-12r-130,0r0,-23r89,0v-11,-40,25,-51,68,-46r0,23v-18,2,-48,-8,-48,12v0,8,3,11,8,11","w":0},"\u0c48":{"d":"-208,-223v60,7,161,-24,165,35v3,37,-41,37,-81,35r0,-23v20,-3,56,10,58,-12v0,-8,-4,-12,-12,-12r-130,0r0,-23xm-209,21v24,-1,44,26,33,51r171,0r0,22r-204,0v-20,1,-37,-16,-37,-36v0,-20,17,-37,37,-37xm-209,72v7,0,14,-7,14,-14v0,-7,-7,-14,-14,-14v-7,0,-14,7,-14,14v0,7,7,14,14,14","w":0},"\u0c4a":{"d":"-99,-240v24,-30,117,-36,117,20v0,24,-19,43,-42,43v-29,0,-51,-31,-38,-60v-17,5,-26,15,-26,30r-23,0v1,-17,-17,-34,-34,-34v-20,0,-34,15,-34,36v0,16,12,34,27,33r0,28v-25,1,-50,-35,-50,-61v0,-54,74,-82,103,-35xm-24,-200v10,0,21,-10,20,-20v0,-10,-10,-19,-20,-19v-9,0,-20,9,-19,19v-1,10,9,20,19,20","w":0},"\u0c4b":{"d":"-55,-260v-13,-35,29,-63,55,-37v7,7,10,15,10,24r-22,0v0,-8,-5,-11,-12,-11v-14,0,-15,20,0,22v59,4,51,84,0,85v-29,0,-51,-31,-38,-60v-17,5,-26,15,-26,30r-23,0v1,-17,-17,-34,-34,-34v-20,0,-34,15,-34,36v0,16,12,34,27,33r0,28v-25,1,-50,-35,-50,-61v0,-54,74,-82,103,-35v9,-10,24,-17,44,-20xm-24,-200v10,0,21,-10,20,-20v0,-10,-10,-19,-20,-19v-9,0,-20,9,-19,19v-1,10,9,20,19,20","w":0},"\u0c4c":{"d":"35,-221v23,0,42,19,42,42v0,24,-19,43,-42,43v-30,1,-53,-34,-37,-62r-31,0v13,48,-43,48,-91,45r0,-23r59,0v8,0,11,-3,11,-11v0,-6,-5,-11,-11,-11r-81,0r0,-23r181,0xm35,-159v10,0,21,-10,20,-20v0,-10,-10,-19,-20,-19v-10,0,-20,9,-20,19v-1,10,10,20,20,20","w":88},"\u0c4d":{"d":"-111,-212v-19,-22,-1,-56,29,-56r82,0r0,22r-82,0v-10,0,-15,5,-15,13v1,20,38,9,57,12r0,22v-20,2,-57,-8,-59,11v-1,10,13,13,27,12r0,28v-41,8,-65,-38,-39,-64","w":0},"\u0c55":{"d":"-68,-290v0,-28,38,-47,58,-24v7,7,10,15,10,24r-22,0v0,-8,-4,-12,-12,-12v-8,0,-11,4,-11,12v0,8,3,11,11,11r0,22v-17,1,-34,-16,-34,-33","w":0},"\u0c56":{"d":"-209,21v24,-1,44,26,33,51r171,0r0,22r-204,0v-20,1,-37,-16,-37,-36v0,-20,17,-37,37,-37xm-209,72v7,0,14,-7,14,-14v0,-7,-7,-14,-14,-14v-7,0,-14,7,-14,14v0,7,7,14,14,14","w":0},"\u0c60":{"d":"508,-176v24,-1,43,22,43,46v0,24,-19,45,-43,45v-31,0,-53,-33,-40,-63r-50,0v51,44,29,154,-43,152v-21,0,-38,-9,-51,-28v-27,37,-79,37,-104,0v-25,35,-76,38,-101,2v-28,49,-112,21,-108,-35v3,-36,17,-48,53,-57v24,-6,23,-34,1,-34v-9,0,-17,8,-17,18r-28,0v-1,-24,22,-46,45,-46v39,0,64,60,27,80v-18,10,-53,15,-53,39v0,17,11,25,32,25v20,0,34,-12,34,-30r28,0v0,20,12,30,35,30v27,0,41,-16,41,-49v0,-41,-31,-67,-72,-67r0,-28v61,0,99,49,99,115v0,19,12,29,35,29v27,0,43,-20,43,-49v1,-41,-32,-67,-73,-67r0,-28v61,0,99,47,99,115v0,20,12,29,35,29v28,0,43,-19,43,-49v0,-41,-31,-67,-72,-67r0,-28r162,0xm508,-109v12,0,21,-9,21,-21v0,-12,-10,-22,-21,-22v-12,0,-21,11,-22,22v0,11,10,21,22,21","w":562},"\u0c61":{"d":"99,-99v26,2,76,16,74,-22v0,-14,-12,-27,-26,-27v-15,0,-27,12,-27,27r-28,0v0,-15,-12,-27,-27,-27v-19,-1,-33,24,-22,41v-7,6,-6,7,-20,19v-30,-33,0,-90,42,-88v16,0,29,7,41,20v30,-41,95,-13,95,35v0,49,-51,63,-102,51v-17,0,-25,4,-25,14v0,22,36,28,63,28v56,0,96,-34,95,-89v0,-13,-4,-31,-15,-31r0,-28r111,0v24,-1,43,22,43,46v0,24,-19,45,-43,45v-31,0,-53,-33,-40,-63r-34,0v27,80,-42,152,-117,152v-46,0,-91,-20,-91,-60v0,-27,23,-45,53,-43xm328,-109v12,0,21,-9,21,-21v0,-12,-10,-22,-21,-22v-12,0,-21,11,-22,22v0,11,10,21,22,21","w":382},"\u0c66":{"d":"99,-176v47,0,88,41,88,88v0,49,-40,92,-88,92v-49,0,-88,-43,-88,-92v0,-47,41,-88,88,-88xm99,-32v33,0,60,-25,60,-56v0,-31,-29,-60,-60,-60v-31,0,-60,29,-60,60v0,31,26,56,60,56","w":198},"\u0c67":{"d":"103,-176v50,0,91,42,91,93v0,34,-11,62,-32,83r-22,-18v46,-38,27,-130,-37,-130v-64,0,-85,92,-38,130r-22,18v-21,-21,-32,-49,-32,-83v-1,-50,42,-93,92,-93","w":205},"\u0c68":{"d":"137,-176v47,-1,88,41,88,88v0,49,-39,92,-88,92r-126,0r0,-36v76,-5,186,23,186,-56v0,-17,-6,-31,-18,-41v-4,50,-84,48,-84,-5v0,-23,19,-42,42,-42xm123,-134v-1,7,7,15,14,14v12,0,19,-7,21,-22v-11,-8,-35,-9,-35,8","w":237},"\u0c69":{"d":"82,-176v55,0,94,53,56,88v38,33,-1,92,-56,92v-38,0,-71,-22,-71,-57r28,0v0,14,15,21,43,21v28,0,43,-7,43,-21v2,-30,-34,-19,-60,-21r0,-28v26,-1,61,6,60,-21v-1,-34,-84,-34,-86,0r-28,0v0,-35,33,-53,71,-53","w":163},"\u0c6a":{"d":"171,-176v75,17,25,107,-24,115v17,28,-5,65,-37,65v-32,0,-52,-36,-37,-65v-38,-8,-84,-65,-50,-103v8,-8,16,-12,27,-12r0,25v-7,-1,-15,7,-14,14v1,69,148,70,149,0v1,-7,-7,-15,-14,-14r0,-25xm110,-28v7,0,14,-7,14,-14v0,-7,-7,-14,-14,-14v-7,0,-14,7,-14,14v0,7,7,14,14,14","w":220},"\u0c6b":{"d":"11,-144v50,-58,179,-32,176,52v20,-20,21,-48,-2,-67r21,-17v27,24,32,62,11,88v21,26,16,64,-11,88r-21,-17v24,-18,20,-51,2,-68v7,89,-126,118,-176,53r18,-22v35,40,130,30,130,-34v0,-62,-93,-79,-130,-34","w":241},"\u0c6c":{"d":"62,-74v-31,0,-29,43,0,42r138,0r0,36r-138,0v-43,2,-70,-65,-34,-91v-35,-29,-11,-91,34,-89r32,0r0,28v-26,-1,-55,-2,-55,23v1,32,45,22,76,23r0,28r-53,0","w":210},"\u0c6d":{"d":"90,-74v-29,-1,-51,2,-51,21v0,14,16,21,49,21v34,0,52,-7,52,-21r28,0v0,38,-37,57,-78,57v-44,0,-80,-16,-79,-57v1,-41,30,-50,79,-49v29,0,50,-1,50,-21v0,-17,-16,-25,-50,-25v-22,0,-51,7,-51,25r-28,0v-1,-36,39,-53,79,-53v41,0,79,16,78,53v-1,41,-30,50,-78,49","w":179},"\u0c6e":{"d":"159,-88v0,-33,-28,-61,-60,-60r0,-28r117,0r0,28r-54,0v53,47,13,152,-63,152v-77,0,-118,-103,-62,-154r19,20v-36,35,-10,98,43,98v33,0,60,-22,60,-56","w":227},"\u0c6f":{"d":"28,-88v-35,-26,-10,-88,34,-88r136,0r0,28r-136,0v-12,0,-23,11,-23,23v1,31,44,22,76,23r0,28v-32,1,-76,-9,-76,24v0,23,31,18,55,18r0,36v-66,15,-108,-49,-66,-92","w":205},"\u0c58":{"d":"172,-313v17,0,32,16,32,33v0,17,-15,31,-32,32r-155,0r0,-22r125,0v-8,-22,9,-43,30,-43xm182,-281v0,-7,-3,-10,-10,-10v-7,0,-11,3,-11,10v0,7,4,11,11,11v7,0,10,-4,10,-11xm165,-169v44,11,72,46,72,103v0,66,-87,96,-113,41v-25,55,-113,24,-113,-40v0,-15,5,-28,14,-37r-23,0r0,-25r73,0r0,25v-20,0,-37,17,-36,37v0,20,15,33,35,33v19,0,37,-13,36,-33r28,0v0,19,16,33,36,33v22,0,35,-12,35,-34v1,-58,-32,-82,-90,-82v-26,0,-32,-13,-50,-35r16,-16v37,46,56,19,101,-35r19,17v-15,20,-27,35,-40,48","w":248},"\u0c59":{"d":"181,-262v17,0,32,16,32,33v0,17,-15,31,-32,32r-156,0r0,-22r125,0v-8,-22,10,-42,31,-43xm191,-230v0,-7,-3,-10,-10,-10v-7,0,-11,3,-11,10v0,7,4,11,11,11v7,0,10,-4,10,-11xm174,-32v36,0,46,-45,22,-63r21,-20v41,39,15,120,-43,119v-24,0,-40,-10,-50,-29v-24,52,-130,28,-112,-43v8,-30,38,-29,65,-47v9,-10,6,-36,-12,-33v-9,1,-17,7,-17,18r-28,0v1,-28,18,-46,45,-46v28,0,45,21,45,52v13,14,63,24,63,-5v0,-13,-10,-19,-29,-19r0,-28v32,1,55,14,55,45v0,47,-67,55,-99,31v-13,21,-54,17,-61,43v0,19,14,25,34,25v22,-1,36,-12,37,-33r28,0v-1,20,15,33,36,33","w":248},"\u0c62":{"d":"-94,123v46,-1,71,-26,72,-72r22,0v1,60,-36,90,-94,94v-64,4,-66,-73,-11,-70v18,1,43,3,43,-15v0,-8,-8,-16,-16,-15v-8,0,-16,8,-16,17r-22,0v0,-10,-6,-17,-16,-17v-9,0,-15,7,-15,17r-23,0v-2,-34,43,-54,65,-28v20,-24,67,-8,65,26v-2,36,-22,38,-67,38v-10,0,-16,3,-16,10v0,9,10,15,29,15","w":0},"\u0c63":{"d":"-83,32v32,3,82,-12,83,21v0,12,-9,21,-21,21v-11,0,-21,-9,-21,-20r-19,0v1,58,-37,91,-94,91v-64,0,-66,-70,-12,-69v19,0,44,2,44,-16v0,-8,-8,-16,-16,-15v-8,0,-16,8,-16,17r-22,0v0,-9,-7,-17,-16,-17v-9,0,-16,8,-16,17r-22,0v-4,-34,42,-52,65,-28v21,-25,67,-7,65,26v-2,36,-23,38,-67,38v-10,0,-16,4,-16,11v0,9,10,14,29,14v53,1,77,-34,72,-91","w":0},"\u25cc":{"d":"196,-169r-19,14v-6,-10,-14,-18,-24,-24r13,-19v12,8,22,17,30,29xm134,-212r-4,22v-11,-2,-23,-3,-34,0r-4,-22v14,-4,28,-4,42,0xm206,-140v4,14,4,28,0,42r-22,-4v2,-11,3,-23,0,-34xm196,-69v-8,12,-18,21,-30,29r-13,-19v10,-6,18,-14,24,-24xm74,-179v-10,6,-18,14,-24,24r-19,-14v8,-12,17,-21,29,-29xm43,-102r-23,4v-3,-14,-3,-28,0,-42r23,4v-2,11,-3,23,0,34xm134,-26v-14,4,-28,4,-42,0r4,-22v11,2,23,3,34,0xm74,-59r-14,19v-12,-8,-21,-17,-29,-29r19,-14v6,10,14,18,24,24","w":226},"\u200c":{"d":"38,-241r-8,9r-24,-24r0,304r-12,0r0,-304r-24,24r-8,-9r30,-29r-30,-30r8,-8r30,30r30,-30r8,8r-30,30","w":0},"\u200d":{"d":"6,48r-12,0r0,-326r12,0r0,326","w":0},"$":{"d":"18,-175v-1,-40,28,-64,65,-67r0,-25r18,0r0,25v38,3,59,23,63,59r-32,0v-2,-20,-12,-31,-31,-34r0,81v46,11,69,23,69,68v0,39,-28,71,-69,72r0,25r-18,0r0,-25v-44,-5,-67,-28,-70,-71r31,0v2,27,15,42,39,46r0,-90v-44,-9,-65,-30,-65,-64xm83,-139r0,-78v-40,1,-44,61,-14,73v4,2,9,4,14,5xm101,-21v35,1,46,-45,29,-71v-5,-6,-14,-11,-29,-15r0,86"},"A":{"d":"150,-98r-42,-110r-40,110r82,0xm222,0r-35,0r-28,-72r-100,0r-26,72r-33,0r91,-238r34,0","w":221},"B":{"d":"159,-127v27,8,45,25,46,58v1,80,-96,70,-178,69r0,-238v75,0,166,-12,166,61v0,27,-15,39,-34,50xm162,-174v0,-46,-59,-34,-104,-36r0,72v45,-1,104,10,104,-36xm172,-69v0,-53,-64,-39,-114,-41r0,82v49,1,114,6,114,-41","w":221},"C":{"d":"16,-119v-10,-116,138,-165,197,-78v5,9,9,19,10,31r-32,0v-4,-33,-28,-49,-64,-49v-56,0,-79,40,-79,96v0,56,23,95,78,96v39,1,60,-19,65,-52r32,0v-7,50,-40,79,-96,79v-74,0,-104,-48,-111,-123","w":239},"D":{"d":"223,-120v0,80,-40,120,-121,120r-75,0r0,-238r75,0v81,0,121,40,121,118xm58,-28v82,6,133,-12,133,-92v0,-79,-52,-96,-133,-90r0,182","w":239},"E":{"d":"204,0r-177,0r0,-238r172,0r0,28r-141,0r0,73r131,0r0,28r-131,0r0,81r146,0r0,28","w":221},"F":{"d":"187,-210r-129,0r0,74r112,0r0,28r-112,0r0,108r-31,0r0,-238r160,0r0,28","w":203},"G":{"d":"130,-23v36,1,62,-13,77,-34r0,-36r-63,0r0,-28r94,0r0,121r-23,0r-8,-25v-16,19,-42,29,-76,29v-74,0,-109,-48,-115,-123v-10,-118,146,-164,207,-78v6,9,9,19,10,31r-33,0v-4,-35,-32,-49,-70,-49v-55,0,-82,38,-82,96v0,57,26,95,82,96","w":258},"H":{"d":"214,0r-32,0r0,-112r-124,0r0,112r-31,0r0,-238r31,0r0,98r124,0r0,-98r32,0r0,238","w":239},"I":{"d":"62,0r-31,0r0,-238r31,0r0,238","w":92},"J":{"d":"73,-24v30,1,36,-20,35,-51r0,-163r32,0r0,162v-1,50,-17,81,-67,80v-44,0,-64,-27,-64,-72r32,0v0,29,10,44,32,44","w":166},"K":{"d":"221,0r-41,0r-85,-119r-37,36r0,83r-31,0r0,-238r31,0r0,118r116,-118r43,0r-100,98","w":221},"L":{"d":"174,0r-147,0r0,-238r31,0r0,210r116,0r0,28"},"M":{"d":"250,0r-30,0r0,-202r-68,202r-28,0r-68,-202r0,202r-29,0r0,-238r47,0r64,198r65,-198r47,0r0,238","w":277},"N":{"d":"214,0r-33,0r-125,-188r0,188r-29,0r0,-238r32,0r124,188r0,-188r31,0r0,238","w":239},"O":{"d":"16,-119v0,-76,42,-123,114,-123v72,0,113,49,113,123v0,74,-41,123,-113,123v-73,0,-114,-48,-114,-123xm48,-119v0,56,26,96,81,96v56,0,82,-39,82,-96v0,-57,-27,-96,-81,-96v-55,0,-82,39,-82,96","w":258},"P":{"d":"207,-168v0,73,-72,77,-149,73r0,95r-31,0r0,-238v82,2,180,-16,180,70xm175,-168v0,-54,-66,-40,-117,-42r0,87v54,0,117,10,117,-45","w":221},"Q":{"d":"130,-242v108,-6,145,140,82,211r35,28r-18,22r-40,-31v-79,43,-178,-10,-173,-107v4,-75,42,-119,114,-123xm48,-119v-2,69,51,114,117,88r-23,-19r18,-22r29,23v43,-52,22,-172,-59,-166v-54,3,-80,39,-82,96","w":258},"R":{"d":"217,-171v0,36,-23,56,-54,63v37,11,46,72,62,108r-34,0v-18,-40,-19,-102,-75,-102r-58,0r0,102r-31,0r0,-238r123,1v42,0,67,26,67,66xm184,-171v0,-57,-74,-36,-126,-40r0,81v52,-4,126,17,126,-41","w":239},"S":{"d":"173,-121v64,37,20,132,-57,125v-60,-5,-98,-24,-101,-81r30,0v-3,63,123,75,129,12v-12,-71,-147,-17,-151,-111v-4,-82,142,-84,168,-24v4,9,8,18,8,29r-31,0v-3,-29,-23,-43,-59,-43v-50,0,-78,52,-27,66v31,8,66,12,91,27","w":221},"T":{"d":"196,-210r-79,0r0,210r-31,0r0,-210r-79,0r0,-28r189,0r0,28","w":203},"U":{"d":"214,-238v-4,110,29,242,-94,242v-69,0,-93,-37,-93,-104r0,-138r31,0v9,84,-33,214,62,214v95,0,53,-130,62,-214r32,0","w":239},"V":{"d":"220,-238r-93,238r-33,0r-92,-238r34,0r75,204r75,-204r34,0","w":221},"W":{"d":"311,-238r-66,238r-31,0r-57,-207r-57,207r-30,0r-66,-238r33,0r48,194r53,-194r38,0r54,194r47,-194r34,0","w":313},"X":{"d":"220,0r-39,0r-70,-101r-71,101r-39,0r92,-125r-82,-113r38,0r62,88r61,-88r39,0r-82,113","w":221},"Y":{"d":"220,-238r-93,137r0,101r-32,0r0,-101r-94,-137r39,0r71,109r71,-109r38,0","w":221},"Z":{"d":"194,0r-188,0r0,-30r148,-180r-134,0r0,-28r170,0r0,30r-148,180r152,0r0,28","w":203},"`":{"d":"91,-197r-24,0r-36,-46r38,0","w":121},"a":{"d":"44,-47v4,42,75,27,88,2r0,-38v-45,-2,-91,6,-88,36xm92,-176v46,0,70,16,70,65r0,111r-30,0r0,-17v-33,32,-119,31,-119,-29v0,-44,49,-63,119,-60v2,-32,-8,-46,-41,-46v-27,0,-42,9,-43,29r-31,0v2,-36,27,-53,75,-53"},"b":{"d":"173,-88v5,73,-69,117,-120,75r0,13r-30,0r0,-238r30,0r0,86v12,-14,27,-24,49,-24v50,0,67,37,71,88xm99,-20v58,0,59,-133,1,-132v-17,0,-33,9,-47,29r0,82v13,14,29,21,46,21"},"c":{"d":"162,-51v-6,35,-29,56,-70,55v-53,-1,-80,-34,-80,-90v0,-85,98,-121,142,-59v4,7,7,15,8,24r-32,0v-1,-21,-16,-31,-38,-31v-36,0,-49,29,-49,66v0,37,13,66,49,66v22,0,36,-10,38,-31r32,0","w":166},"d":{"d":"85,-20v22,0,36,-14,47,-30r0,-81v-14,-14,-29,-21,-46,-21v-34,0,-42,31,-43,67v0,36,10,64,42,65xm12,-85v-7,-72,66,-116,120,-74r0,-79r30,0r0,238r-30,0r0,-20v-46,53,-131,11,-120,-65"},"e":{"d":"170,-51v-6,36,-32,55,-74,55v-56,-1,-83,-34,-84,-90v-1,-56,27,-90,80,-90v56,0,83,37,81,97r-129,0v2,35,17,59,52,59v22,0,40,-10,42,-31r32,0xm141,-103v1,-50,-72,-67,-91,-22v-3,6,-5,14,-6,22r97,0"},"f":{"d":"99,-214v-31,-6,-45,7,-40,42r32,0r0,24r-32,0r0,148r-31,0r0,-148r-25,0r0,-24r25,0v-5,-53,20,-80,71,-68r0,26","w":92},"g":{"d":"12,-85v-7,-72,66,-116,120,-74r0,-13r30,0v-5,107,34,274,-104,238v-24,-5,-40,-22,-41,-49r32,0v0,19,12,29,37,29v38,1,48,-26,46,-66v-46,53,-131,11,-120,-65xm85,-20v22,0,36,-14,47,-30r0,-81v-14,-14,-29,-21,-46,-21v-34,0,-42,31,-43,67v0,36,10,64,42,65"},"h":{"d":"132,-111v3,-56,-56,-47,-79,-12r0,123r-30,0r0,-238r30,0r0,88v28,-43,110,-33,110,37r0,113r-31,0r0,-111"},"i":{"d":"53,0r-30,0r0,-172r30,0r0,172xm53,-205r-30,0r0,-33r30,0r0,33","w":75},"j":{"d":"-12,42v26,9,35,-7,35,-34r0,-180r30,0r0,181v3,46,-18,67,-65,59r0,-26xm53,-205r-30,0r0,-33r30,0r0,33","w":75},"k":{"d":"165,0r-36,0r-57,-88r-19,20r0,68r-30,0r0,-238r30,0r0,135r67,-69r38,0r-65,64","w":166},"l":{"d":"53,0r-30,0r0,-238r30,0r0,238","w":75},"m":{"d":"150,-145v24,-45,105,-43,105,32r0,113r-31,0r0,-111v5,-54,-49,-47,-70,-12r0,123r-30,0r0,-111v4,-53,-50,-48,-71,-12r0,123r-30,0r0,-172r30,0r0,22v25,-35,83,-36,97,5","w":277},"n":{"d":"132,-111v3,-56,-56,-47,-79,-12r0,123r-30,0r0,-172r30,0r0,22v28,-43,110,-33,110,37r0,113r-31,0r0,-111"},"o":{"d":"12,-86v0,-56,27,-90,80,-90v54,0,81,34,81,90v0,56,-27,90,-81,90v-53,0,-80,-34,-80,-90xm43,-86v0,37,13,66,49,66v36,0,50,-29,50,-66v0,-37,-13,-66,-50,-66v-36,0,-49,29,-49,66"},"p":{"d":"173,-88v5,73,-69,117,-120,75r0,79r-30,0r0,-238r30,0r0,20v12,-14,27,-24,49,-24v50,0,67,37,71,88xm99,-20v58,0,59,-133,1,-132v-17,0,-33,9,-47,29r0,82v13,14,29,21,46,21"},"q":{"d":"12,-85v-7,-72,66,-116,120,-74r0,-13r30,0r0,238r-30,0r0,-86v-46,53,-131,11,-120,-65xm85,-20v22,0,36,-14,47,-30r0,-81v-14,-14,-29,-21,-46,-21v-34,0,-42,31,-43,67v0,36,10,64,42,65"},"r":{"d":"112,-144v-25,-6,-49,4,-59,22r0,122r-30,0r0,-172r30,0r0,24v17,-23,31,-31,59,-27r0,31","w":110},"s":{"d":"138,-85v37,34,0,89,-54,89v-47,0,-71,-18,-74,-55r31,0v0,21,15,31,43,31v38,0,55,-40,14,-50v-36,-9,-86,-10,-84,-57v2,-33,27,-49,64,-49v45,0,68,16,69,48r-30,0v-1,-16,-13,-24,-36,-24v-32,-7,-52,34,-15,42v24,5,56,10,72,25","w":166},"t":{"d":"57,-49v-1,21,8,33,32,26r0,23v-40,9,-62,-6,-62,-50r0,-98r-21,0r0,-24r21,0r0,-43r30,0r0,43r29,0r0,24r-29,0r0,99","w":92},"u":{"d":"53,-61v-3,54,58,48,79,12r0,-123r30,0r0,172r-30,0r0,-22v-34,44,-110,33,-110,-37r0,-113r31,0r0,111"},"v":{"d":"162,-172r-65,172r-28,0r-64,-172r33,0r45,134r46,-134r33,0","w":166},"w":{"d":"238,-172r-51,172r-30,0r-37,-127r-37,127r-30,0r-52,-172r35,0r31,131r39,-131r28,0r39,131r32,-131r33,0","w":239},"x":{"d":"164,0r-38,0r-43,-67r-43,67r-38,0r64,-89r-59,-83r38,0r38,60r38,-60r38,0r-59,83","w":166},"y":{"d":"17,39v29,9,38,-5,52,-39r-64,-172r33,0r45,134r46,-134r33,0r-76,200v-11,28,-29,49,-69,40r0,-29","w":166},"z":{"d":"159,0r-152,0r0,-26r107,-120r-101,0r0,-26r141,0r0,26r-107,120r112,0r0,26","w":166},"\u20ac":{"d":"147,-180v-3,-31,-17,-55,-47,-56v-27,0,-43,24,-48,72r54,0r-6,19r-49,0v0,11,-2,24,0,34r39,0r-6,19r-32,0v1,89,89,94,95,10r34,0v-5,58,-32,87,-81,87v-48,0,-75,-33,-82,-97r-18,0r0,-19v20,6,16,-14,16,-34r-16,0r0,-19r18,0v-2,-108,118,-127,154,-51v4,10,7,22,9,35r-34,0","w":200},"\u201a":{"d":"68,-36v0,40,4,85,-36,87r0,-17v12,0,17,-11,17,-34r-17,0r0,-36r36,0","w":99},"\u0192":{"d":"11,41v22,4,48,7,47,-22r29,-165r-32,0r3,-23r33,0v3,-47,23,-83,80,-67r0,28v-23,-6,-46,-6,-45,22r-4,17r33,0r-3,23r-34,0r-36,193v-8,24,-43,26,-71,19r0,-25"},"\u201e":{"d":"115,-36v0,40,5,85,-36,87r0,-17v12,0,18,-11,18,-34r-18,0r0,-36r36,0xm61,-36v0,40,5,85,-36,87r0,-17v12,0,18,-11,18,-34r-18,0r0,-36r36,0","w":140},"\u2020":{"d":"172,-140r-64,0r0,210r-31,0r0,-210r-64,0r0,-26r64,0r0,-72r31,0r0,72r64,0r0,26"},"\u2021":{"d":"172,-2r-64,0r0,72r-31,0r0,-72r-64,0r0,-26r64,0r0,-112r-64,0r0,-26r64,0r0,-72r31,0r0,72r63,0r0,26r-63,0r0,112r64,0r0,26"},"\u02c6":{"d":"114,-197r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0","w":125},"\u2030":{"d":"4,-179v1,-37,14,-63,50,-63v36,0,50,28,50,63v0,36,-13,63,-50,63v-34,0,-51,-26,-50,-63xm54,-136v16,0,24,-14,24,-43v0,-29,-8,-43,-24,-43v-16,0,-24,14,-24,43v0,29,8,43,24,43xm184,-238r-127,238r-23,0r126,-238r24,0xm228,-59v0,-36,13,-63,50,-63v36,0,50,26,50,63v0,37,-14,63,-50,63v-37,0,-50,-27,-50,-63xm278,-16v16,0,24,-14,24,-43v0,-29,-8,-43,-24,-43v-16,0,-24,14,-24,43v0,29,8,43,24,43xm114,-59v0,-36,13,-63,50,-63v36,0,50,26,50,63v0,37,-14,63,-50,63v-37,0,-50,-27,-50,-63xm164,-16v16,0,24,-14,24,-43v0,-29,-8,-43,-24,-43v-16,0,-24,14,-24,43v0,29,8,43,24,43","w":332},"\u0160":{"d":"159,-127v78,26,43,139,-43,131v-60,-6,-98,-24,-101,-81r30,0v-3,63,123,75,129,12v-12,-71,-147,-17,-151,-111v-4,-82,142,-84,168,-24v4,9,8,18,8,29r-31,0v-3,-29,-23,-43,-59,-43v-50,0,-78,52,-27,66xm159,-299r-36,46r-31,0r-36,-46r33,0r19,28r18,-28r33,0","w":220},"\u2039":{"d":"98,-13r-26,0r-56,-80r56,-80r26,0r-46,80","w":119},"\u0152":{"d":"115,-242v32,0,52,16,66,35r0,-31r128,0r0,28r-96,0r0,73r87,0r0,28r-87,0r0,81r102,0r0,28r-134,0r0,-31v-14,19,-34,35,-66,35v-70,0,-98,-52,-99,-123v0,-73,29,-123,99,-123xm48,-119v0,52,16,96,67,96v45,0,66,-32,66,-96v0,-64,-21,-96,-65,-96v-52,1,-68,43,-68,96","w":332},"\u017d":{"d":"194,0r-188,0r0,-30r148,-180r-134,0r0,-28r170,0r0,30r-148,180r152,0r0,28xm153,-299r-36,46r-31,0r-36,-46r33,0r18,28r19,-28r33,0","w":203},"\u2018":{"d":"47,-162r-33,0v0,-36,-5,-79,33,-80r0,16v-11,0,-17,10,-17,31r17,0r0,33","w":60},"\u2019":{"d":"47,-238v0,36,5,79,-33,80r0,-15v11,0,16,-11,16,-32r-16,0r0,-33r33,0","w":60},"\u201c":{"d":"97,-162r-33,0v0,-36,-5,-79,33,-80r0,16v-11,0,-16,10,-16,31r16,0r0,33xm47,-162r-33,0v0,-36,-5,-79,33,-80r0,16v-11,0,-17,10,-17,31r17,0r0,33","w":110},"\u201d":{"d":"97,-238v0,36,6,79,-33,80r0,-15v11,0,16,-11,16,-32r-16,0r0,-33r33,0xm47,-238v0,36,5,79,-33,80r0,-15v11,0,16,-11,16,-32r-16,0r0,-33r33,0","w":110},"\u2022":{"d":"72,-189v29,0,48,20,48,48v0,29,-20,49,-48,49v-29,0,-49,-20,-49,-49v0,-29,20,-48,49,-48","w":143},"\u2219":{"d":"72,-189v29,0,48,20,48,48v0,29,-20,49,-48,49v-29,0,-49,-20,-49,-49v0,-29,20,-48,49,-48","w":143},"\u02dc":{"d":"44,-239v19,-1,49,31,55,0r21,0v0,23,-12,35,-33,37v-19,1,-48,-31,-54,0r-22,0v2,-21,11,-37,33,-37","w":131},"\u2122":{"d":"210,-122r-20,0r0,-94r-22,94r-20,0r-21,-94r0,94r-21,0r0,-116r32,0r20,90r20,-90r32,0r0,116xm93,-218r-31,0r0,96r-22,0r0,-96r-32,0r0,-20r85,0r0,20","w":226},"\u0161":{"d":"138,-85v37,34,0,89,-54,89v-47,0,-71,-18,-74,-55r31,0v0,21,15,31,43,31v38,0,55,-40,14,-50v-36,-9,-86,-10,-84,-57v2,-33,27,-49,64,-49v45,0,68,16,69,48r-30,0v-1,-16,-13,-24,-36,-24v-32,-7,-52,34,-15,42v24,5,56,10,72,25xm128,-242r-36,46r-31,0r-36,-46r33,0r19,28r18,-28r33,0","w":166},"\u203a":{"d":"104,-93r-56,80r-26,0r46,-80r-46,-80r26,0","w":119},"\u0153":{"d":"221,-176v56,1,83,37,81,97r-130,0v3,34,17,59,52,59v23,0,41,-11,44,-31r31,0v-4,64,-110,73,-142,24v-14,21,-36,31,-65,31v-53,0,-80,-34,-80,-90v0,-88,101,-119,145,-59v15,-21,36,-31,64,-31xm270,-103v1,-50,-72,-67,-91,-22v-3,6,-5,14,-6,22r97,0xm43,-86v0,37,13,66,49,66v36,0,50,-29,50,-66v0,-37,-13,-66,-50,-66v-36,0,-49,29,-49,66","w":313},"\u017e":{"d":"159,0r-152,0r0,-26r107,-120r-101,0r0,-26r141,0r0,26r-107,120r112,0r0,26xm135,-242r-36,45r-31,0r-36,-45r33,0r18,27r19,-27r33,0","w":166},"\u0178":{"d":"220,-238r-93,137r0,101r-32,0r0,-101r-94,-137r39,0r71,109r71,-109r38,0xm158,-257r-30,0r0,-34r30,0r0,34xm95,-257r-30,0r0,-34r30,0r0,34","w":221},"\u00a1":{"d":"63,-139r-33,0r0,-33r33,0r0,33xm63,66r-33,0r6,-179r20,0r7,127r0,52","w":92},"\u00a2":{"d":"88,-21v26,5,47,-7,49,-30r31,0v-4,41,-40,62,-87,53r-11,39r-17,-5r11,-38v-30,-14,-46,-42,-46,-84v1,-58,33,-95,94,-89r11,-38r16,5r-10,37v23,9,36,25,39,50r-31,0v0,-11,-6,-19,-15,-25xm106,-152v-66,-11,-69,96,-35,123"},"\u00a3":{"d":"44,-32v43,-15,87,22,127,-2r0,31v-31,19,-76,-8,-106,-8v-18,0,-36,5,-57,15r0,-29v27,-11,39,-43,32,-82r-32,0r0,-24r25,0v-38,-81,46,-142,115,-95v13,9,21,26,22,46r-31,0v-2,-25,-16,-38,-41,-38v-45,2,-50,46,-33,87r51,0r0,24r-46,0v8,33,-4,59,-26,75"},"\u00a4":{"d":"142,-66v-23,18,-62,17,-83,0r-25,25r-21,-21r25,-24v-17,-25,-17,-56,0,-82v0,0,-9,-8,-25,-25r21,-20r25,24v24,-18,59,-17,83,0r24,-24r21,20r-25,25v16,23,16,59,0,82r25,24r-21,21xm54,-127v0,26,18,45,46,45v28,0,46,-19,46,-45v0,-27,-19,-46,-46,-46v-27,0,-46,19,-46,46","w":200},"\u00a5":{"d":"185,-238r-62,109r51,0r0,22r-66,0r0,30r66,0r0,22r-66,0r0,55r-30,0r0,-55r-67,0r0,-22r67,0r0,-30r-67,0r0,-22r52,0r-63,-109r35,0r57,105r58,-105r35,0"},"\u00a6":{"d":"60,75r-27,0r0,-134r27,0r0,134xm60,-123r-27,0r0,-134r27,0r0,134","w":93},"\u00a7":{"d":"50,-150v-51,-41,2,-112,66,-88v23,8,37,24,40,52r-31,0v3,-39,-66,-44,-66,-6v16,54,112,50,112,117v0,20,-12,35,-37,47v48,29,20,102,-39,98v-41,-3,-67,-20,-71,-59r32,0v-3,41,72,47,73,6v-18,-55,-112,-50,-115,-121v0,-20,12,-35,36,-46xm119,-40v59,-41,-26,-77,-54,-99v-58,40,23,82,54,99"},"\u00a8":{"d":"107,-204r-30,0r0,-34r30,0r0,34xm44,-204r-30,0r0,-34r30,0r0,34","w":120},"\u00a9":{"d":"0,-120v0,-73,48,-122,123,-122v75,0,122,49,122,122v0,74,-48,123,-122,123v-74,0,-123,-47,-123,-123xm20,-120v0,62,41,103,103,103v61,0,101,-42,101,-103v0,-61,-40,-102,-101,-102v-62,0,-103,41,-103,102xm81,-119v-6,50,66,71,77,25r23,0v-7,30,-27,45,-58,45v-42,-1,-60,-27,-64,-70v-8,-75,104,-94,121,-28r-23,0v-3,-16,-15,-24,-34,-24v-29,0,-38,22,-42,52","w":244},"\u00aa":{"d":"34,-168v3,27,55,15,61,-3r0,-21v-30,-2,-64,3,-61,24xm67,-262v67,0,52,69,53,128r-25,0r0,-13v-24,24,-86,22,-88,-20v-1,-32,36,-46,88,-44v1,-22,-9,-30,-29,-30v-19,0,-29,6,-29,18r-25,0v2,-26,20,-39,55,-39xm118,-91r-104,0r0,-21r104,0r0,21","w":132},"\u00ab":{"d":"175,-13r-26,0r-55,-80r55,-80r26,0r-46,80xm107,-13r-26,0r-56,-80r56,-80r26,0r-46,80","w":200},"\u00ac":{"d":"196,-118r0,72r-24,0r0,-48r-138,0r0,-24r162,0","w":226},"\u00ad":{"d":"187,-100r-149,0r0,-24r149,0r0,24","w":225},"\u00ae":{"d":"0,-120v0,-73,48,-122,123,-122v75,0,122,49,122,122v0,74,-48,123,-122,123v-74,0,-123,-47,-123,-123xm20,-120v0,62,41,103,103,103v61,0,101,-42,101,-103v0,-61,-40,-102,-101,-102v-62,0,-103,41,-103,102xm177,-52r-24,0v-9,-30,-17,-62,-62,-55r0,55r-21,0r0,-131v44,-1,102,-5,102,36v0,23,-11,35,-34,37v23,5,30,37,39,58xm91,-125v25,0,61,3,58,-20v3,-21,-33,-22,-58,-21r0,41","w":244},"\u00af":{"d":"182,-284r-184,0r0,-18r184,0r0,18","w":179},"\u00b0":{"d":"23,-212v0,-29,20,-49,49,-49v29,0,48,21,48,49v0,29,-19,49,-48,49v-29,0,-49,-20,-49,-49xm43,-212v0,18,12,30,29,30v17,0,30,-13,30,-30v0,-17,-12,-29,-30,-29v-18,0,-29,11,-29,29","w":143},"\u00b1":{"d":"190,-120r-70,0r0,71r-30,0r0,-71r-70,0r0,-29r70,0r0,-71r30,0r0,71r70,0r0,29xm190,0r-170,0r0,-29r170,0r0,29","w":210},"\u00b2":{"d":"113,-222v0,44,-49,46,-68,72r69,0r0,21r-109,0v-2,-38,71,-52,80,-91v0,-13,-8,-20,-24,-20v-15,0,-24,6,-27,18r-26,0v1,-51,105,-54,105,0","w":119},"\u00b3":{"d":"9,-226v2,-44,98,-48,98,-2v0,16,-8,26,-24,30v20,4,30,15,30,32v-1,29,-24,40,-53,41v-33,0,-50,-13,-54,-38r27,0v3,24,57,23,53,-6v2,-15,-17,-19,-37,-18r0,-20v35,4,43,-33,10,-33v-13,0,-21,4,-23,14r-27,0","w":119},"\u00b4":{"d":"91,-243r-36,46r-24,0r22,-46r38,0","w":121},"\u00b5":{"d":"162,-38v0,14,5,18,19,18r0,22v-26,2,-45,-3,-49,-24v-21,25,-51,34,-79,18r0,70r-30,0r0,-238r30,0r0,117v0,21,13,35,34,34v23,-1,34,-13,45,-28r0,-123r30,0r0,134"},"\u03bc":{"d":"162,-38v0,14,5,18,19,18r0,22v-26,2,-45,-3,-49,-24v-21,25,-51,34,-79,18r0,70r-30,0r0,-238r30,0r0,117v0,21,13,35,34,34v23,-1,34,-13,45,-28r0,-123r30,0r0,134"},"\u00b6":{"d":"0,-169v-3,-85,98,-68,179,-69r0,24r-23,0r0,280r-27,0r0,-280r-37,0r0,280r-27,0r0,-170v-40,-2,-64,-24,-65,-65","w":178},"\u00b7":{"d":"51,-113v-17,-2,-30,-12,-30,-31v0,-18,13,-30,30,-30v19,0,30,13,31,30v1,19,-14,29,-31,31","w":105},"\u00b8":{"d":"91,38v0,33,-35,35,-68,32r0,-20v16,2,42,3,42,-13v0,-9,-8,-13,-24,-13r0,-24r24,0r0,12v16,3,26,7,26,26","w":119},"\u00b9":{"d":"83,-129r-25,0r0,-86v-8,6,-21,9,-39,9r0,-22v30,0,46,-11,46,-33r18,0r0,132","w":119},"\u00ba":{"d":"8,-196v0,-40,20,-66,58,-66v38,0,58,28,58,66v0,38,-19,66,-58,66v-40,0,-58,-26,-58,-66xm66,-153v21,0,32,-14,32,-43v0,-28,-11,-42,-32,-42v-21,0,-32,14,-32,42v0,29,11,43,32,43xm118,-91r-104,0r0,-21r104,0r0,21","w":131},"\u00bb":{"d":"175,-93r-55,80r-26,0r45,-80r-45,-80r26,0xm107,-93r-56,80r-26,0r46,-80r-46,-80r26,0","w":200},"\u00bc":{"d":"81,-119r-24,0r0,-80v-8,6,-20,8,-37,8r0,-20v28,0,43,-10,43,-30r18,0r0,122xm239,-238r-158,238r-37,0r169,-238r26,0xm262,-25r-17,0r0,25r-23,0r0,-25r-62,0r0,-20r66,-77r19,0r0,76r17,0r0,21xm222,-46r0,-46r-39,46r39,0","w":277},"\u00bd":{"d":"81,-119r-24,0r0,-80v-8,6,-20,8,-37,8r0,-20v28,0,43,-10,43,-30r18,0r0,122xm233,-238r-169,238r-26,0r169,-238r26,0xm267,-86v0,41,-44,43,-62,66r63,0r0,20r-101,0v-3,-36,74,-46,74,-85v0,-12,-7,-18,-22,-18v-14,0,-22,6,-24,17r-25,0v0,-46,98,-51,97,0","w":277},"\u00be":{"d":"11,-209v1,-41,89,-44,91,-2v0,15,-7,24,-22,28v19,4,28,14,28,30v0,26,-22,37,-49,37v-31,0,-48,-12,-51,-35r26,0v1,11,9,16,24,16v17,0,25,-7,25,-22v0,-14,-17,-17,-35,-16r0,-18v33,4,40,-31,9,-31v-12,0,-19,4,-21,13r-25,0xm241,-238r-168,238r-26,0r169,-238r25,0xm262,-25r-17,0r0,25r-23,0r0,-25r-62,0r0,-20r66,-77r19,0r0,76r17,0r0,21xm222,-46r0,-46r-39,46r39,0","w":277},"\u00bf":{"d":"60,-25v-26,25,-7,71,32,71v26,0,42,-15,46,-45r31,0v-4,44,-31,69,-77,69v-44,0,-74,-23,-76,-65v-2,-61,70,-53,63,-119r29,0v3,50,-24,66,-48,89xm109,-139r-33,0r0,-33r33,0r0,33"},"\u00c0":{"d":"150,-98r-42,-110r-40,110r82,0xm222,0r-35,0r-28,-72r-100,0r-26,72r-33,0r91,-238r34,0xm141,-250r-24,0r-36,-46r38,0","w":221},"\u00c1":{"d":"150,-98r-42,-110r-40,110r82,0xm222,0r-35,0r-28,-72r-100,0r-26,72r-33,0r91,-238r34,0xm141,-296r-36,46r-24,0r22,-46r38,0","w":221},"\u00c2":{"d":"150,-98r-42,-110r-40,110r82,0xm222,0r-35,0r-28,-72r-100,0r-26,72r-33,0r91,-238r34,0xm162,-250r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0","w":221},"\u00c3":{"d":"150,-98r-42,-110r-40,110r82,0xm222,0r-35,0r-28,-72r-100,0r-26,72r-33,0r91,-238r34,0xm89,-292v19,-1,49,31,55,0r21,0v0,23,-12,35,-33,37v-19,1,-48,-31,-54,0r-22,0v2,-21,11,-37,33,-37","w":221},"\u00c4":{"d":"150,-98r-42,-110r-40,110r82,0xm222,0r-35,0r-28,-72r-100,0r-26,72r-33,0r91,-238r34,0xm158,-257r-30,0r0,-34r30,0r0,34xm95,-257r-30,0r0,-34r30,0r0,34","w":221},"\u00c5":{"d":"150,-98r-42,-110r-40,110r82,0xm222,0r-35,0r-28,-72r-100,0r-26,72r-33,0r91,-238r34,0xm79,-267v1,-18,12,-30,29,-30v17,0,29,13,30,30v-2,16,-12,29,-30,29v-17,0,-29,-12,-29,-29xm91,-267v0,10,7,17,17,17v11,0,17,-8,18,-17v-1,-10,-7,-19,-18,-18v-10,0,-17,7,-17,18","w":221},"\u00c6":{"d":"314,0r-155,0r0,-69r-84,0r-39,69r-36,0r137,-238r172,0r0,28r-119,0r0,73r109,0r0,28r-109,0r0,81r124,0r0,28xm159,-97r0,-113r-7,0r-63,113r70,0","w":332},"\u00c7":{"d":"16,-119v-10,-116,138,-165,197,-78v5,9,9,19,10,31r-32,0v-4,-33,-28,-49,-64,-49v-56,0,-79,40,-79,96v0,56,23,95,78,96v39,1,60,-19,65,-52r32,0v-7,50,-40,79,-96,79v-74,0,-104,-48,-111,-123xm154,38v0,33,-35,35,-68,32r0,-20v16,2,42,3,42,-13v0,-9,-8,-13,-24,-13r0,-24r24,0r0,12v16,3,26,7,26,26","w":239},"\u00c8":{"d":"204,0r-177,0r0,-238r172,0r0,28r-141,0r0,73r131,0r0,28r-131,0r0,81r146,0r0,28xm141,-250r-24,0r-36,-46r38,0","w":221},"\u00c9":{"d":"204,0r-177,0r0,-238r172,0r0,28r-141,0r0,73r131,0r0,28r-131,0r0,81r146,0r0,28xm141,-296r-36,46r-24,0r22,-46r38,0","w":221},"\u00ca":{"d":"204,0r-177,0r0,-238r172,0r0,28r-141,0r0,73r131,0r0,28r-131,0r0,81r146,0r0,28xm162,-250r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0","w":221},"\u00cb":{"d":"204,0r-177,0r0,-238r172,0r0,28r-141,0r0,73r131,0r0,28r-131,0r0,81r146,0r0,28xm158,-257r-30,0r0,-34r30,0r0,34xm95,-257r-30,0r0,-34r30,0r0,34","w":221},"\u00cc":{"d":"62,0r-31,0r0,-238r31,0r0,238xm75,-250r-24,0r-36,-46r38,0","w":92},"\u00cd":{"d":"62,0r-31,0r0,-238r31,0r0,238xm76,-296r-36,46r-24,0r22,-46r38,0","w":92},"\u00ce":{"d":"62,0r-31,0r0,-238r31,0r0,238xm98,-250r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0","w":92},"\u00cf":{"d":"62,0r-31,0r0,-238r31,0r0,238xm93,-257r-30,0r0,-34r30,0r0,34xm30,-257r-30,0r0,-34r30,0r0,34","w":92},"\u00d0":{"d":"223,-120v0,80,-40,120,-121,120r-75,0r0,-105r-27,0r0,-28r27,0r0,-105r75,0v81,0,121,40,121,118xm58,-28v82,6,133,-12,133,-92v0,-79,-52,-96,-133,-90r0,77r65,0r0,28r-65,0r0,77","w":239},"\u00d1":{"d":"214,0r-33,0r-125,-188r0,188r-29,0r0,-238r32,0r124,188r0,-188r31,0r0,238xm98,-292v19,-1,49,31,55,0r21,0v0,23,-12,35,-33,37v-19,1,-48,-31,-54,0r-22,0v2,-21,11,-37,33,-37","w":239},"\u00d2":{"d":"16,-119v0,-76,42,-123,114,-123v72,0,113,49,113,123v0,74,-41,123,-113,123v-73,0,-114,-48,-114,-123xm48,-119v0,56,26,96,81,96v56,0,82,-39,82,-96v0,-57,-27,-96,-81,-96v-55,0,-82,39,-82,96xm159,-250r-24,0r-36,-46r38,0","w":258},"\u00d3":{"d":"16,-119v0,-76,42,-123,114,-123v72,0,113,49,113,123v0,74,-41,123,-113,123v-73,0,-114,-48,-114,-123xm48,-119v0,56,26,96,81,96v56,0,82,-39,82,-96v0,-57,-27,-96,-81,-96v-55,0,-82,39,-82,96xm159,-296r-36,46r-24,0r22,-46r38,0","w":258},"\u00d4":{"d":"16,-119v0,-76,42,-123,114,-123v72,0,113,49,113,123v0,74,-41,123,-113,123v-73,0,-114,-48,-114,-123xm48,-119v0,56,26,96,81,96v56,0,82,-39,82,-96v0,-57,-27,-96,-81,-96v-55,0,-82,39,-82,96xm181,-250r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0","w":258},"\u00d5":{"d":"16,-119v0,-76,42,-123,114,-123v72,0,113,49,113,123v0,74,-41,123,-113,123v-73,0,-114,-48,-114,-123xm48,-119v0,56,26,96,81,96v56,0,82,-39,82,-96v0,-57,-27,-96,-81,-96v-55,0,-82,39,-82,96xm108,-292v19,-1,49,31,55,0r21,0v0,23,-12,35,-33,37v-19,1,-48,-31,-54,0r-22,0v2,-21,11,-37,33,-37","w":258},"\u00d6":{"d":"16,-119v0,-76,42,-123,114,-123v72,0,113,49,113,123v0,74,-41,123,-113,123v-73,0,-114,-48,-114,-123xm48,-119v0,56,26,96,81,96v56,0,82,-39,82,-96v0,-57,-27,-96,-81,-96v-55,0,-82,39,-82,96xm176,-257r-30,0r0,-34r30,0r0,34xm113,-257r-30,0r0,-34r30,0r0,34","w":258},"\u00d8":{"d":"130,-242v32,-1,54,10,72,26r28,-31r16,14r-29,32v17,22,26,49,26,82v-2,74,-41,121,-113,123v-32,1,-54,-10,-74,-25r-27,30r-16,-14r29,-31v-17,-23,-26,-50,-26,-83v1,-76,42,-120,114,-123xm130,-215v-76,-3,-101,93,-67,155r120,-135v-12,-13,-30,-19,-53,-20xm129,-23v78,0,100,-94,67,-155r-120,135v14,14,32,20,53,20","w":258},"\u00d9":{"d":"214,-238v-4,110,29,242,-94,242v-69,0,-93,-37,-93,-104r0,-138r31,0v9,84,-33,214,62,214v95,0,53,-130,62,-214r32,0xm150,-250r-24,0r-36,-46r38,0","w":239},"\u00da":{"d":"214,-238v-4,110,29,242,-94,242v-69,0,-93,-37,-93,-104r0,-138r31,0v9,84,-33,214,62,214v95,0,53,-130,62,-214r32,0xm150,-296r-36,46r-24,0r22,-46r38,0","w":239},"\u00db":{"d":"214,-238v-4,110,29,242,-94,242v-69,0,-93,-37,-93,-104r0,-138r31,0v9,84,-33,214,62,214v95,0,53,-130,62,-214r32,0xm171,-250r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0","w":239},"\u00dc":{"d":"214,-238v-4,110,29,242,-94,242v-69,0,-93,-37,-93,-104r0,-138r31,0v9,84,-33,214,62,214v95,0,53,-130,62,-214r32,0xm167,-257r-30,0r0,-34r30,0r0,34xm104,-257r-30,0r0,-34r30,0r0,34","w":239},"\u00dd":{"d":"220,-238r-93,137r0,101r-32,0r0,-101r-94,-137r39,0r71,109r71,-109r38,0xm140,-295r-36,46r-24,0r22,-46r38,0","w":221},"\u00de":{"d":"207,-122v0,74,-72,78,-149,74r0,48r-31,0r0,-238r31,0r0,47v77,-4,149,-2,149,69xm118,-77v64,13,77,-83,18,-85v-23,-2,-53,-1,-78,-1r0,86r60,0","w":221},"\u00df":{"d":"92,-218v-31,0,-39,24,-39,57r0,161r-30,0v8,-94,-33,-246,70,-242v34,1,59,16,61,47v2,25,-21,42,-25,66v10,35,63,32,63,79v0,65,-112,74,-117,10r29,0v5,30,60,25,57,-8v-3,-41,-62,-32,-62,-77v1,-20,27,-54,26,-67v-2,-18,-15,-26,-33,-26","w":203},"\u00e0":{"d":"44,-47v4,42,75,27,88,2r0,-38v-45,-2,-91,6,-88,36xm92,-176v46,0,70,16,70,65r0,111r-30,0r0,-17v-33,32,-119,31,-119,-29v0,-44,49,-63,119,-60v2,-32,-8,-46,-41,-46v-27,0,-42,9,-43,29r-31,0v2,-36,27,-53,75,-53xm122,-197r-24,0r-36,-46r38,0"},"\u00e1":{"d":"44,-47v4,42,75,27,88,2r0,-38v-45,-2,-91,6,-88,36xm92,-176v46,0,70,16,70,65r0,111r-30,0r0,-17v-33,32,-119,31,-119,-29v0,-44,49,-63,119,-60v2,-32,-8,-46,-41,-46v-27,0,-42,9,-43,29r-31,0v2,-36,27,-53,75,-53xm122,-243r-36,46r-24,0r22,-46r38,0"},"\u00e2":{"d":"44,-47v4,42,75,27,88,2r0,-38v-45,-2,-91,6,-88,36xm92,-176v46,0,70,16,70,65r0,111r-30,0r0,-17v-33,32,-119,31,-119,-29v0,-44,49,-63,119,-60v2,-32,-8,-46,-41,-46v-27,0,-42,9,-43,29r-31,0v2,-36,27,-53,75,-53xm144,-197r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0"},"\u00e3":{"d":"44,-47v4,42,75,27,88,2r0,-38v-45,-2,-91,6,-88,36xm92,-176v46,0,70,16,70,65r0,111r-30,0r0,-17v-33,32,-119,31,-119,-29v0,-44,49,-63,119,-60v2,-32,-8,-46,-41,-46v-27,0,-42,9,-43,29r-31,0v2,-36,27,-53,75,-53xm71,-239v19,-1,49,31,55,0r21,0v0,23,-12,35,-33,37v-19,1,-48,-31,-54,0r-22,0v2,-21,11,-37,33,-37"},"\u00e4":{"d":"44,-47v4,42,75,27,88,2r0,-38v-45,-2,-91,6,-88,36xm92,-176v46,0,70,16,70,65r0,111r-30,0r0,-17v-33,32,-119,31,-119,-29v0,-44,49,-63,119,-60v2,-32,-8,-46,-41,-46v-27,0,-42,9,-43,29r-31,0v2,-36,27,-53,75,-53xm139,-204r-30,0r0,-34r30,0r0,34xm76,-204r-30,0r0,-34r30,0r0,34"},"\u00e5":{"d":"44,-47v4,42,75,27,88,2r0,-38v-45,-2,-91,6,-88,36xm92,-176v46,0,70,16,70,65r0,111r-30,0r0,-17v-33,32,-119,31,-119,-29v0,-44,49,-63,119,-60v2,-32,-8,-46,-41,-46v-27,0,-42,9,-43,29r-31,0v2,-36,27,-53,75,-53xm63,-221v2,-16,12,-29,29,-29v18,1,29,12,30,29v0,18,-13,28,-30,30v-17,-2,-28,-13,-29,-30xm75,-221v0,9,6,18,17,18v11,0,18,-7,18,-18v-1,-25,-35,-20,-35,0"},"\u00e6":{"d":"78,-20v38,0,53,-23,51,-63v-44,-2,-85,6,-85,36v0,18,11,27,34,27xm281,-51v-3,64,-115,72,-139,22v-18,43,-129,50,-129,-17v0,-44,47,-63,116,-60v2,-31,-8,-46,-40,-46v-25,0,-39,9,-41,29r-31,0v-7,-58,106,-69,133,-31v14,-15,33,-22,55,-22v56,1,80,39,79,97r-125,0v3,34,15,59,49,59v22,0,39,-10,41,-31r32,0xm252,-103v-5,-33,-21,-49,-47,-49v-26,0,-41,16,-45,49r92,0","w":295},"\u00e7":{"d":"162,-51v-6,35,-29,56,-70,55v-53,-1,-80,-34,-80,-90v0,-85,98,-121,142,-59v4,7,7,15,8,24r-32,0v-1,-21,-16,-31,-38,-31v-36,0,-49,29,-49,66v0,37,13,66,49,66v22,0,36,-10,38,-31r32,0xm117,38v0,33,-35,35,-68,32r0,-20v16,2,42,3,42,-13v0,-9,-8,-13,-24,-13r0,-24r24,0r0,12v16,3,26,7,26,26","w":166},"\u00e8":{"d":"170,-51v-6,36,-32,55,-74,55v-56,-1,-83,-34,-84,-90v-1,-56,27,-90,80,-90v56,0,83,37,81,97r-129,0v2,35,17,59,52,59v22,0,40,-10,42,-31r32,0xm141,-103v1,-50,-72,-67,-91,-22v-3,6,-5,14,-6,22r97,0xm122,-197r-24,0r-36,-46r38,0"},"\u00e9":{"d":"170,-51v-6,36,-32,55,-74,55v-56,-1,-83,-34,-84,-90v-1,-56,27,-90,80,-90v56,0,83,37,81,97r-129,0v2,35,17,59,52,59v22,0,40,-10,42,-31r32,0xm141,-103v1,-50,-72,-67,-91,-22v-3,6,-5,14,-6,22r97,0xm122,-243r-36,46r-24,0r22,-46r38,0"},"\u00ea":{"d":"170,-51v-6,36,-32,55,-74,55v-56,-1,-83,-34,-84,-90v-1,-56,27,-90,80,-90v56,0,83,37,81,97r-129,0v2,35,17,59,52,59v22,0,40,-10,42,-31r32,0xm141,-103v1,-50,-72,-67,-91,-22v-3,6,-5,14,-6,22r97,0xm144,-197r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0"},"\u00eb":{"d":"170,-51v-6,36,-32,55,-74,55v-56,-1,-83,-34,-84,-90v-1,-56,27,-90,80,-90v56,0,83,37,81,97r-129,0v2,35,17,59,52,59v22,0,40,-10,42,-31r32,0xm141,-103v1,-50,-72,-67,-91,-22v-3,6,-5,14,-6,22r97,0xm139,-204r-30,0r0,-34r30,0r0,34xm76,-204r-30,0r0,-34r30,0r0,34"},"\u00ec":{"d":"53,0r-30,0r0,-172r30,0r0,172xm36,-243r21,46r-24,0r-36,-46r39,0","w":75},"\u00ed":{"d":"53,0r-30,0r0,-172r30,0r0,172xm80,-243r-36,46r-24,0r21,-46r39,0","w":75},"\u00ee":{"d":"53,0r-30,0r0,-172r30,0r0,172xm89,-197r-33,0r-18,-27r-18,27r-33,0r36,-45r31,0","w":75},"\u00ef":{"d":"53,0r-30,0r0,-172r30,0r0,172xm83,-204r-30,0r0,-34r30,0r0,34xm21,-204r-30,0r0,-34r30,0r0,34","w":75},"\u00f0":{"d":"86,-238r20,16r35,-16r8,15r-29,15v28,32,53,68,53,124v0,55,-28,88,-81,88v-52,0,-80,-33,-80,-88v0,-63,48,-102,106,-82v-5,-11,-12,-23,-21,-33r-40,19r-8,-15r35,-16v-10,-10,-20,-18,-33,-27r35,0xm43,-84v0,37,14,64,49,64v36,0,50,-27,50,-64v0,-37,-14,-64,-50,-64v-35,0,-49,27,-49,64"},"\u00f1":{"d":"132,-111v3,-56,-56,-47,-79,-12r0,123r-30,0r0,-172r30,0r0,22v28,-43,110,-33,110,37r0,113r-31,0r0,-111xm71,-239v19,-1,49,31,55,0r21,0v0,23,-12,35,-33,37v-19,1,-48,-31,-54,0r-22,0v2,-21,11,-37,33,-37"},"\u00f2":{"d":"12,-86v0,-56,27,-90,80,-90v54,0,81,34,81,90v0,56,-27,90,-81,90v-53,0,-80,-34,-80,-90xm43,-86v0,37,13,66,49,66v36,0,50,-29,50,-66v0,-37,-13,-66,-50,-66v-36,0,-49,29,-49,66xm122,-197r-24,0r-36,-46r38,0"},"\u00f3":{"d":"12,-86v0,-56,27,-90,80,-90v54,0,81,34,81,90v0,56,-27,90,-81,90v-53,0,-80,-34,-80,-90xm43,-86v0,37,13,66,49,66v36,0,50,-29,50,-66v0,-37,-13,-66,-50,-66v-36,0,-49,29,-49,66xm122,-243r-36,46r-24,0r22,-46r38,0"},"\u00f4":{"d":"12,-86v0,-56,27,-90,80,-90v54,0,81,34,81,90v0,56,-27,90,-81,90v-53,0,-80,-34,-80,-90xm43,-86v0,37,13,66,49,66v36,0,50,-29,50,-66v0,-37,-13,-66,-50,-66v-36,0,-49,29,-49,66xm145,-197r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0"},"\u00f5":{"d":"12,-86v0,-56,27,-90,80,-90v54,0,81,34,81,90v0,56,-27,90,-81,90v-53,0,-80,-34,-80,-90xm43,-86v0,37,13,66,49,66v36,0,50,-29,50,-66v0,-37,-13,-66,-50,-66v-36,0,-49,29,-49,66xm71,-239v19,-1,49,31,55,0r21,0v0,23,-12,35,-33,37v-19,1,-48,-31,-54,0r-22,0v2,-21,11,-37,33,-37"},"\u00f6":{"d":"12,-86v0,-56,27,-90,80,-90v54,0,81,34,81,90v0,56,-27,90,-81,90v-53,0,-80,-34,-80,-90xm43,-86v0,37,13,66,49,66v36,0,50,-29,50,-66v0,-37,-13,-66,-50,-66v-36,0,-49,29,-49,66xm139,-204r-30,0r0,-34r30,0r0,34xm76,-204r-30,0r0,-34r30,0r0,34"},"\u00f8":{"d":"12,-86v0,-75,69,-111,127,-77r17,-21r15,12r-18,22v13,16,20,37,20,64v0,75,-70,111,-127,77r-17,21r-15,-12r17,-22v-13,-16,-19,-37,-19,-64xm123,-141v-54,-40,-100,34,-73,94xm62,-31v51,39,103,-33,72,-94"},"\u00f9":{"d":"53,-61v-3,54,58,48,79,12r0,-123r30,0r0,172r-30,0r0,-22v-34,44,-110,33,-110,-37r0,-113r31,0r0,111xm122,-197r-24,0r-36,-46r38,0"},"\u00fa":{"d":"53,-61v-3,54,58,48,79,12r0,-123r30,0r0,172r-30,0r0,-22v-34,44,-110,33,-110,-37r0,-113r31,0r0,111xm122,-243r-36,46r-24,0r22,-46r38,0"},"\u00fb":{"d":"53,-61v-3,54,58,48,79,12r0,-123r30,0r0,172r-30,0r0,-22v-34,44,-110,33,-110,-37r0,-113r31,0r0,111xm144,-197r-33,0r-18,-27r-19,27r-33,0r36,-45r31,0"},"\u00fc":{"d":"53,-61v-3,54,58,48,79,12r0,-123r30,0r0,172r-30,0r0,-22v-34,44,-110,33,-110,-37r0,-113r31,0r0,111xm139,-204r-30,0r0,-34r30,0r0,34xm76,-204r-30,0r0,-34r30,0r0,34"},"\u00fd":{"d":"17,39v29,9,38,-5,52,-39r-64,-172r33,0r45,134r46,-134r33,0r-76,200v-11,28,-29,49,-69,40r0,-29xm113,-243r-36,46r-24,0r22,-46r38,0","w":166},"\u00fe":{"d":"173,-88v5,73,-69,117,-120,75r0,79r-30,0r0,-304r30,0r0,86v12,-14,27,-24,49,-24v50,0,67,37,71,88xm99,-20v58,0,59,-133,1,-132v-17,0,-33,9,-47,29r0,82v13,14,29,21,46,21"},"\u00ff":{"d":"17,39v29,9,38,-5,52,-39r-64,-172r33,0r45,134r46,-134r33,0r-76,200v-11,28,-29,49,-69,40r0,-29xm130,-204r-30,0r0,-34r30,0r0,34xm67,-204r-30,0r0,-34r30,0r0,34","w":166},"\u0964":{"d":"104,19r-31,0r0,-197r31,0r0,197","w":150},"\u0965":{"d":"174,19r-31,0r0,-197r31,0r0,197xm104,19r-31,0r0,-197r31,0r0,197","w":220},"\u0951":{"d":"-51,-260r-17,0r0,-121r17,0r0,121","w":0},"\u0952":{"d":"m2,79r-169,0r0,-16r169,0r0,16","w":0},"\u20a8":{"d":"217,-171v0,36,-23,56,-54,63v37,11,46,72,62,108r-34,0v-18,-40,-19,-102,-75,-102r-58,0r0,102r-31,0r0,-238r123,1v42,0,67,26,67,66xm184,-171v0,-57,-74,-36,-126,-40r0,81v52,-4,126,17,126,-41xm352,-85v37,34,0,89,-54,89v-47,0,-71,-18,-74,-55r31,0v0,21,15,31,43,31v38,0,55,-40,14,-50v-36,-9,-86,-10,-84,-57v2,-33,27,-49,64,-49v45,0,68,16,69,48r-30,0v-1,-16,-13,-24,-36,-24v-32,-7,-52,34,-15,42v24,5,56,10,72,25","w":380},"!":{"d":"38,0r0,-35r37,0r0,35r-37,0xm72,-60r-32,0r0,-169r32,0r0,169","w":112},"\"":{"d":"75,-263r-9,75r-20,0r-9,-75r38,0xm141,-263r-9,75r-20,0r-9,-75r38,0","w":178},"#":{"d":"199,-144r-13,53r43,0r-6,27r-44,0r-16,64r-28,0r16,-64r-47,0r-16,64r-28,0r16,-64r-42,0r5,-27r44,0r14,-53r-44,0r5,-27r45,0r16,-65r28,0r-16,65r47,0r16,-65r28,0r-16,65r42,0r-5,27r-44,0xm124,-145r-13,54r47,0r13,-54r-47,0","w":281},"%":{"d":"187,-6v11,1,19,-12,19,-22v0,-11,-8,-24,-19,-24v-12,0,-20,13,-20,24v0,11,8,23,20,22xm95,-159v11,0,20,-12,20,-23v0,-11,-9,-23,-20,-23v-11,0,-19,12,-19,23v0,11,8,23,19,23xm187,-75v24,0,42,22,42,47v0,24,-18,45,-42,45v-24,0,-43,-21,-43,-45v0,-24,19,-47,43,-47xm95,-228v25,0,43,22,43,46v0,24,-19,46,-43,46v-23,0,-42,-22,-42,-46v0,-25,18,-46,42,-46xm38,3r183,-235r23,18r-182,234","w":281},"&":{"d":"220,-143v1,41,-2,58,-14,82r41,40r-21,21r-36,-36v-43,68,-162,47,-161,-36v0,-34,15,-60,46,-78v-51,-41,-31,-108,31,-110v34,-1,63,23,62,57v0,21,-15,42,-45,60r61,61v6,-17,9,-38,9,-61r27,0xm103,-165v18,-12,32,-21,34,-38v2,-18,-14,-29,-32,-29v-42,0,-34,44,-2,67xm60,-73v-2,45,51,65,85,38v10,-7,18,-14,23,-22r-72,-72v-17,10,-35,32,-36,56","w":262},"'":{"d":"57,-263r-8,75r-21,0r-9,-75r38,0","w":76},"(":{"d":"111,49v-57,-50,-96,-159,-52,-249v13,-28,30,-53,52,-74r20,21v-31,33,-56,82,-56,140v0,58,23,108,57,139","w":150},")":{"d":"44,29v64,-90,66,-191,4,-282r26,-19v52,78,71,150,37,242v-11,28,-24,54,-42,77","w":150},"*":{"d":"99,-33r-18,0r0,-48r-36,36r-8,-8r36,-37r-48,0r0,-17r48,0r-36,-37r8,-8r36,36r0,-49r18,0r0,49r36,-36r9,8r-36,37r48,0r0,17r-48,0r36,37r-9,8r-36,-36r0,48","w":189},"+":{"d":"43,-86r0,-25r58,0r0,-62r24,0r0,62r58,0r0,25r-58,0r0,62r-24,0r0,-62r-58,0","w":225},",":{"d":"70,-39v6,43,-18,60,-33,86r-13,-9r25,-38r-20,0r0,-39r41,0","w":98},"-":{"d":"123,-99r-99,0r0,-28r99,0r0,28","w":147},"\u2010":{"d":"123,-99r-99,0r0,-28r99,0r0,28","w":147},".":{"d":"29,0r0,-39r41,0r0,39r-41,0","w":98},"\/":{"d":"27,4r148,-236r24,16r-148,236","w":225},"0":{"d":"107,-239v63,0,95,56,95,123v0,67,-32,123,-95,123v-63,0,-96,-56,-96,-123v0,-67,33,-123,96,-123xm107,-22v85,-1,85,-187,0,-188v-86,1,-86,186,0,188","w":214},"1":{"d":"100,-232r0,232r-31,0r0,-189r-21,20r-18,-20r43,-43r27,0","w":150},"2":{"d":"32,-201v24,-54,142,-50,139,26v-2,69,-106,74,-104,146r102,0r0,29r-133,0v-3,-75,18,-101,76,-136v36,-22,38,-72,-9,-73v-22,0,-40,9,-52,28","w":206},"3":{"d":"134,-125v67,29,34,132,-41,132v-23,0,-44,-6,-62,-19r0,-31v38,29,104,30,109,-20v3,-36,-28,-49,-67,-45r0,-30v59,16,75,-70,20,-72v-12,-1,-34,7,-42,12r0,-29v46,-30,109,-1,107,52v0,21,-8,37,-24,50","w":206},"4":{"d":"115,-98r0,-85r-59,85r59,0xm188,-69r-42,0r0,69r-31,0r0,-69r-95,0r0,-29r95,-134r31,0r0,134r42,0r0,29","w":206},"5":{"d":"140,-71v0,-45,-51,-47,-100,-44r0,-117r119,0r0,28r-88,0r0,59v57,-5,98,24,100,74v2,67,-76,95,-137,68r0,-32v41,22,106,12,106,-36","w":206},"6":{"d":"67,-115v41,-49,118,-14,118,49v0,38,-33,73,-69,73v-55,0,-80,-58,-80,-120v0,-79,51,-147,131,-120r0,30v-58,-28,-102,29,-100,88xm116,-22v20,0,39,-21,39,-44v0,-55,-71,-51,-85,-14v1,29,19,58,46,58","w":206},"7":{"d":"40,0v-7,-95,59,-147,102,-204r-104,0r0,-28r143,0r0,28v-45,57,-115,108,-109,204r-32,0","w":206},"8":{"d":"103,-212v-31,-1,-49,33,-23,54v8,6,15,12,23,16v13,-6,35,-24,36,-39v0,-19,-17,-31,-36,-31xm59,-59v0,22,21,39,44,39v24,0,43,-18,44,-39v0,-19,-15,-36,-44,-52v-29,16,-44,33,-44,52xm75,-126v-62,-30,-44,-113,28,-113v70,0,89,83,28,113v27,19,46,32,46,67v0,39,-33,66,-74,66v-42,0,-74,-27,-74,-66v0,-36,19,-49,46,-67","w":206},"9":{"d":"146,-116v-42,49,-116,13,-116,-51v0,-38,30,-72,68,-72v56,0,80,59,80,121v0,90,-59,148,-138,115r0,-30v60,27,110,-1,106,-83xm97,-210v-23,0,-38,20,-38,44v0,55,71,53,84,15v0,-30,-18,-59,-46,-59","w":206},":":{"d":"29,-103r0,-39r41,0r0,39r-41,0xm29,0r0,-39r41,0r0,39r-41,0","w":98},";":{"d":"70,-39v6,43,-18,60,-33,86r-13,-9r25,-38r-20,0r0,-39r41,0xm29,-103r0,-39r41,0r0,39r-41,0","w":98},"<":{"d":"217,-17r-182,-87r0,-21r182,-87r7,28r-146,69r146,70","w":262},"=":{"d":"169,-91r0,32r-113,0r0,-32r113,0xm169,-166r0,32r-113,0r0,-32r113,0","w":225},">":{"d":"39,-45r146,-70r-146,-69r7,-28r182,87r0,21r-182,87","w":262},"?":{"d":"73,0r0,-35r37,0r0,35r-37,0xm99,-263v56,0,98,67,55,107v-23,21,-56,36,-48,86r-30,0v-1,-31,0,-59,16,-73v18,-16,47,-26,47,-57v1,-18,-20,-34,-40,-34v-26,0,-39,15,-39,45r-30,0v-1,-44,26,-74,69,-74","w":206},"@":{"d":"178,-263v78,0,143,63,142,139v0,54,-16,106,-62,109v-21,1,-42,-19,-45,-35v-42,51,-115,5,-115,-58v0,-62,70,-106,112,-61r0,-21r28,0r0,125v0,17,7,25,20,25v29,0,37,-45,37,-84v1,-64,-52,-116,-117,-116v-65,0,-116,60,-116,127v0,93,84,157,179,121r0,25v-111,33,-204,-42,-204,-146v0,-80,62,-150,141,-150xm173,-55v54,-1,55,-105,1,-107v-26,0,-46,26,-46,53v-1,27,19,54,45,54","w":356},"[":{"d":"31,-278r100,0r0,29r-65,0r0,273r65,0r0,29r-100,0r0,-331","w":168},"\\":{"d":"175,20r-148,-236r24,-16r148,236","w":225},"]":{"d":"102,-249r-64,0r0,-29r99,0r0,331r-99,0r0,-29r64,0r0,-273","w":168},"^":{"d":"103,-276r63,51r-15,18r-48,-40r-48,40r-15,-18","w":206},"_":{"d":"-1,28r197,0r0,28r-197,0r0,-28","w":195},"{":{"d":"77,-31v0,-46,-18,-67,-65,-66r0,-31v47,1,65,-20,65,-66v0,-78,21,-85,94,-84r0,26v-44,-1,-65,1,-64,47v2,63,-8,72,-50,93v46,21,52,32,50,103v-1,40,26,36,64,36r0,26v-72,1,-94,-6,-94,-84","w":206},"|":{"d":"83,66r-28,0r0,-341r28,0r0,341","w":137},"}":{"d":"130,-194v0,46,18,67,65,66r0,31v-47,-1,-65,20,-65,66v0,78,-23,85,-95,84r0,-26v37,0,65,5,65,-36v0,-71,4,-81,49,-103v-42,-20,-51,-30,-49,-93v1,-47,-20,-47,-65,-47r0,-26v71,-1,95,6,95,84","w":206},"~":{"d":"85,-163v48,-3,52,54,94,66v30,-4,30,-24,31,-66r28,0v2,58,-8,94,-59,94v-41,0,-37,-12,-66,-49v-30,-37,-65,-11,-59,49r-28,0v-2,-58,8,-91,59,-94","w":262},"\u2026":{"d":"31,0r0,-39r41,0r0,39r-41,0xm139,0r0,-39r41,0r0,39r-41,0xm246,0r0,-39r41,0r0,39r-41,0","w":318},"\u2013":{"d":"-1,-155r197,0r0,28r-197,0r0,-28","w":195},"\u2014":{"d":"-1,-154r321,0r0,28r-321,0r0,-28","w":319},"\u00f7":{"d":"43,-86r0,-25r140,0r0,25r-140,0xm94,-139r0,-35r37,0r0,35r-37,0xm94,-23r0,-35r37,0r0,35r-37,0","w":225},"\u2212":{"d":"183,-86r-140,0r0,-25r140,0r0,25","w":225},"\u00d7":{"d":"174,-55r-17,17r-44,-43r-44,43r-17,-17r44,-43r-44,-44r17,-17r43,43r44,-43r17,17r-43,43","w":225},"\u0131":{"d":"53,0r-30,0r0,-172r30,0r0,172","w":75},"\u02c7":{"d":"78,-197r-31,0r-36,-45r33,0r19,27r18,-27r33,0","w":125},"\u02da":{"d":"18,-221v1,-17,11,-29,29,-29v17,1,28,12,29,29v0,18,-13,28,-29,30v-17,-1,-29,-12,-29,-30xm30,-221v0,10,6,18,17,18v11,0,17,-8,17,-18v0,-10,-7,-17,-17,-17v-10,0,-17,7,-17,17","w":93},"\u2044":{"d":"126,-238r-169,238r-26,0r170,-238r25,0","w":57},"\u2074":{"d":"111,-154r-16,0r0,25r-24,0r0,-25r-62,0r0,-19r66,-77r20,0r0,75r16,0r0,21xm71,-175r0,-46r-39,46r39,0","w":119},"\u0c3d":{"d":"134,-128v-8,-32,-66,-14,-85,-5r0,-28v34,-20,115,-22,113,32v-2,59,-76,47,-116,68v-4,3,-6,6,-6,10v9,20,46,16,74,16r164,0r0,35r-184,0v-71,12,-116,-67,-40,-93v28,-9,74,-2,80,-35","w":287},"\u0c78":{"d":"86,-232v73,-5,98,101,47,138v30,6,45,47,15,68v-21,15,-50,28,-75,38r-16,-20v27,-13,69,-22,81,-50v-6,-17,-30,-18,-52,-20v-47,-3,-75,-31,-75,-79v0,-46,31,-72,75,-75xm86,-113v27,0,47,-16,47,-44v0,-27,-20,-47,-47,-47v-27,0,-47,18,-47,47v0,29,18,44,47,44","w":182},"\u0c79":{"d":"39,-229r28,0r0,229r-28,0r0,-229","w":105},"\u0c7a":{"d":"46,-147v-4,35,42,37,63,22r0,-104r28,0r0,229r-28,0r0,-94v-42,15,-91,-1,-91,-50r0,-85r28,0r0,82","w":165},"\u0c7b":{"d":"137,-142v-1,31,45,31,63,17r0,-104r29,0r0,229r-29,0r0,-94v-24,9,-62,8,-77,-9v-34,27,-105,17,-105,-41r0,-85r28,0v5,43,-17,115,30,113v16,-1,33,-6,33,-25r0,-88r28,0r0,87","w":256},"\u0c7c":{"d":"14,-98r0,-29r217,0r0,29r-217,0","w":245},"\u0c7d":{"d":"60,-47v7,14,34,12,55,12r156,0r0,35r-175,0v-51,8,-89,-50,-43,-79v28,-16,74,-16,99,-36v7,-16,-8,-22,-26,-22r-90,0r0,-28v64,2,172,-16,141,62v-14,36,-78,28,-111,47v-4,3,-6,6,-6,9","w":281},"\u0c7e":{"d":"69,-44v7,12,31,9,51,9r176,0r0,35r-194,0v-45,6,-84,-38,-48,-68v13,-11,40,-10,62,-12v7,0,13,-1,13,-7v-18,-21,-93,9,-97,-39v-3,-39,37,-39,73,-41v8,0,15,-2,16,-8v-14,-16,-58,-6,-88,-9r0,-28v52,0,137,-10,111,53v-9,22,-44,19,-72,22v-6,0,-11,1,-12,6v25,18,98,-7,98,40v0,47,-56,34,-89,47","w":306},"\u0c7f":{"d":"128,-32v70,-3,107,-45,133,-90r22,16v-27,59,-72,110,-155,110v-64,0,-107,-35,-107,-99v0,-48,25,-84,74,-84v26,0,41,16,42,42v4,49,-76,56,-82,11v-19,52,15,97,73,94xm109,-137v0,-17,-24,-17,-35,-8v-1,25,33,30,35,8","w":297}}});
/*!
 * The following copyright notice may not be removed under any circumstances.
 * 
 * Copyright:
 * � 2008 Microsoft Corporation. All rights reserved.
 * 
 * Description:
 * Gautami is an OpenType font for the Indic script-Telugu. It is based on
 * Unicode, contains TrueType outlines and has been designed for use as a UI font.
 */
Cufon.registerFont({"w":194,"face":{"font-family":"Gautami","font-weight":700,"font-stretch":"normal","units-per-em":"360","panose-1":"2 11 8 2 4 2 4 2 2 3","ascent":"288","descent":"-72","x-height":"4","bbox":"-244 -333 537 142","underline-thickness":"16.875","underline-position":"-97.0312","unicode-range":"U+0020-U+25CC"},"glyphs":{" ":{"w":95},"\u200b":{"w":0},"\u00a0":{"w":95},"\u0c01":{"d":"44,-76v0,25,19,34,44,35r0,44v-88,9,-110,-124,-34,-149v10,-4,21,-6,34,-6r0,38v-26,0,-44,13,-44,38","w":98},"\u0c02":{"d":"84,-152v46,0,76,30,76,76v0,47,-29,79,-76,79v-47,0,-76,-31,-76,-79v0,-46,30,-76,76,-76xm84,-41v21,0,38,-13,38,-35v0,-23,-15,-38,-38,-38v-23,0,-39,15,-39,38v0,23,17,35,39,35","w":173},"\u0c03":{"d":"37,-61v20,0,34,14,34,34v0,20,-14,34,-34,34v-20,0,-34,-14,-34,-34v0,-20,14,-34,34,-34xm25,-28v1,15,23,15,24,0v0,-14,-24,-14,-24,0xm37,-149v20,0,34,14,34,34v0,20,-14,34,-34,34v-20,0,-34,-14,-34,-34v0,-20,14,-34,34,-34xm25,-115v0,14,24,14,24,0v-1,-15,-23,-15,-24,0","w":74},"\u0c05":{"d":"181,-176v37,0,59,31,59,69v0,69,-44,110,-115,110v-70,0,-116,-41,-116,-110v0,-39,21,-69,58,-69v30,0,50,21,50,50v0,34,-30,58,-65,48v10,24,35,37,73,37v46,-1,73,-20,77,-66v2,-25,-26,-43,-34,-19v2,8,9,13,18,13r0,38r-63,0r0,-38r9,0v-5,-37,15,-63,49,-63xm50,-125v2,15,29,16,29,-1v-1,-17,-27,-14,-29,1","w":256},"\u0c06":{"d":"197,-176v51,-2,65,70,28,91v4,6,7,12,7,18v-5,52,-50,70,-106,70v-69,0,-117,-40,-117,-110v0,-39,20,-69,57,-69v30,0,50,21,50,50v0,34,-30,58,-64,48v13,44,115,50,142,14v-9,-12,-44,-3,-63,-6r0,-38r20,0v-13,-34,12,-66,46,-68xm210,-126v-1,-15,-25,-15,-25,0v0,7,4,13,10,17v10,-2,15,-8,15,-17xm50,-125v2,15,29,17,28,-1v-1,-18,-26,-12,-28,1","w":265},"\u0c07":{"d":"120,-156v35,-40,118,-14,111,51v-3,32,-13,54,-32,72v6,12,11,28,11,46r-38,0v-1,-10,0,-18,-3,-25v-30,27,-103,20,-100,-34v3,-56,79,-56,108,-18v19,-16,28,-74,-10,-74v-20,0,-28,13,-28,34r-38,0v0,-21,-7,-34,-28,-34v-27,1,-35,33,-14,49r-27,27v-44,-38,-19,-115,41,-114v21,0,37,8,47,20xm107,-46v2,17,31,8,42,4v-7,-8,-39,-21,-42,-4","w":248},"\u0c08":{"d":"262,-115v0,-14,-18,-12,-22,-2r-27,-17v15,-36,84,-28,81,19v0,8,-5,17,-8,23v24,20,8,70,-27,67v-25,-1,-43,-20,-39,-47r-13,0v-9,42,-38,75,-86,75v-49,0,-76,-34,-86,-75r-25,0r0,-32r25,0v5,-29,21,-48,43,-60v-3,-3,-9,-9,-11,-13r23,-23v9,8,15,24,31,24v21,-5,40,-30,56,-50r26,23r-35,41v22,13,34,33,39,58v19,-3,55,9,55,-11xm168,-104v-9,-43,-86,-42,-94,0r94,0xm73,-72v9,31,68,43,88,12v3,-4,6,-7,8,-12r-96,0xm258,-56v5,1,9,-5,9,-9v0,-4,-5,-9,-9,-8v-4,-1,-9,4,-8,8v-1,4,3,10,8,9","w":313},"\u0c09":{"d":"199,-78v22,0,37,15,37,37v0,52,-86,57,-107,17v-10,15,-25,27,-49,27v-46,0,-71,-33,-71,-81v0,-62,43,-93,103,-98r0,-32r32,0r0,33v25,1,47,9,67,17r-18,35v-43,-22,-110,-20,-137,9r176,0r0,32r-185,0v-10,45,62,58,61,14r38,0v0,16,6,25,17,30v-1,-26,14,-40,36,-40xm196,-31v9,0,15,-17,3,-18v-10,0,-7,14,-3,18","w":248},"\u0c0a":{"d":"201,-78v21,0,35,14,36,37v0,54,-86,56,-107,17v-9,15,-25,27,-48,27v-48,0,-72,-34,-72,-81v0,-55,35,-86,85,-95r0,-35r32,0r0,32r10,0r0,-32r32,0r0,35v17,2,30,9,44,16r-19,33v-35,-22,-112,-17,-137,8r211,0v6,0,11,-6,11,-13v-1,-14,-18,-10,-22,-1r-27,-17v17,-36,80,-27,80,18v0,8,-3,15,-7,22v25,23,8,67,-27,67v-26,0,-42,-18,-39,-43r-189,0v-1,27,10,42,34,42v19,0,28,-11,28,-31r37,0v0,16,6,28,17,34v0,-25,14,-40,37,-40xm275,-70v11,0,11,-18,0,-18v-4,0,-9,5,-8,9v-1,4,4,9,8,9xm197,-31v11,2,14,-16,3,-18v-9,1,-8,13,-3,18","w":327},"\u0c0b":{"d":"392,-81v-2,-36,-24,-53,-57,-58r8,-37v49,9,82,40,87,95v6,70,-77,110,-120,62v-21,26,-74,32,-97,0v-25,28,-68,30,-94,2v-41,54,-141,-10,-96,-72v10,-12,33,-16,52,-28v5,-5,4,-23,-7,-21v-6,0,-13,8,-12,15r-38,0v2,-31,20,-51,50,-53v50,-2,64,75,21,94v-14,6,-34,8,-39,23v0,12,8,18,24,18v16,0,27,-11,26,-28r37,0v0,19,10,28,28,28v22,0,32,-13,32,-40v0,-36,-24,-54,-58,-58r9,-37v54,9,94,49,85,114v13,37,66,22,62,-19v-4,-35,-24,-54,-58,-58r8,-37v54,10,93,46,86,114v2,14,11,21,27,21v23,0,34,-16,34,-40","w":448},"\u0c0c":{"d":"200,-176v33,4,53,26,53,61v0,74,-48,118,-121,118v-49,0,-90,-16,-90,-61v0,-48,55,-48,100,-41v11,2,17,-9,18,-20v0,-12,-9,-17,-18,-19v-15,0,-19,9,-19,25r-38,0v4,-29,-37,-32,-38,-6v0,4,1,10,5,15r-27,24v-50,-50,29,-130,79,-80v33,-34,96,-8,94,41v-1,50,-48,65,-101,53v-12,0,-18,3,-18,8v4,19,29,20,53,20v50,0,81,-29,85,-77v0,-12,-6,-20,-17,-24r0,-37","w":271},"\u0c0e":{"d":"60,-242v94,2,151,54,151,143v0,57,-22,101,-79,102v-17,0,-31,-7,-38,-18v-29,31,-87,9,-85,-35v2,-30,20,-47,50,-50v31,-3,43,32,57,55v32,13,59,-8,57,-54v-2,-68,-43,-104,-113,-105r0,-38xm46,-50v0,17,27,14,28,0v-3,-15,-27,-16,-28,0","w":226},"\u0c0f":{"d":"78,-242v87,3,133,59,133,143v0,58,-22,100,-79,102v-17,0,-31,-7,-38,-18v-29,31,-88,9,-86,-35v1,-30,21,-50,51,-50v25,0,40,14,48,41v4,12,12,18,25,18v27,0,41,-19,41,-58v0,-62,-31,-104,-95,-105r0,-38xm44,-224v0,17,6,28,24,27r0,38v-66,4,-83,-99,-26,-120v8,-3,16,-5,26,-5r0,38v-15,0,-24,7,-24,22xm46,-50v0,17,27,15,29,0v-3,-13,-28,-17,-29,0","w":227},"\u0c10":{"d":"117,-158v50,-44,114,5,114,73v0,74,-83,112,-136,69v-29,33,-86,10,-86,-34v0,-41,49,-65,80,-39v8,7,14,19,18,35v22,25,92,14,87,-31v-3,-27,-9,-50,-33,-53v-15,1,-27,9,-28,25r-37,0v0,-18,-11,-25,-27,-25v-15,0,-23,8,-22,25r-38,0v-7,-62,73,-79,108,-45xm47,-50v-2,16,22,14,27,5v6,-9,-6,-17,-15,-17v-8,0,-12,4,-12,12","w":248},"\u0c12":{"d":"167,-41v31,1,36,-39,11,-53r29,-27v45,39,23,125,-40,124v-21,0,-36,-7,-47,-21v-34,47,-139,9,-107,-62v10,-22,40,-24,59,-37v5,-6,4,-23,-7,-21v-7,0,-11,8,-11,16r-37,0v1,-31,19,-52,48,-54v49,-4,64,75,20,93v-14,6,-38,7,-38,24v0,14,11,18,25,18v17,0,29,-10,29,-29r38,0v0,18,11,29,28,29","w":248},"\u0c13":{"d":"167,-41v31,1,36,-39,11,-53r29,-27v45,39,23,125,-40,124v-21,0,-36,-7,-47,-21v-35,49,-139,7,-106,-63v11,-20,38,-24,58,-36v5,-6,4,-23,-7,-21v-7,0,-11,8,-11,16r-37,0v0,-25,12,-41,29,-50v-4,-52,56,-73,87,-36r-26,27v-10,-16,-30,-4,-22,10v34,11,35,78,0,89v-15,5,-35,9,-38,23v0,14,11,18,25,18v17,0,30,-8,29,-27r38,0v0,19,11,27,28,27","w":248},"\u0c14":{"d":"167,-41v30,1,36,-38,12,-53r28,-27v47,39,24,125,-40,124v-21,0,-35,-7,-46,-21v-9,13,-25,21,-48,21v-63,0,-87,-85,-32,-106v9,-7,35,-6,34,-24v0,-7,-3,-11,-10,-11v-6,0,-10,9,-10,16r-38,0v2,-18,6,-32,4,-54r77,0v3,0,5,-2,5,-6v1,-2,-3,-8,-5,-7r-94,0r0,-32r210,0v28,1,46,21,46,48v0,28,-18,48,-46,48v-34,0,-54,-30,-44,-64r-35,0v2,25,-9,39,-26,45v18,47,-27,64,-58,78v-11,12,5,27,21,25v17,-1,29,-9,30,-27r37,0v0,19,11,27,28,27xm214,-159v7,1,15,-7,14,-14v-1,-10,-8,-16,-20,-14v-15,3,-10,31,6,28","w":278},"\u0c15":{"d":"16,-120v0,-26,15,-41,33,-49v-5,-5,-8,-11,-14,-15r27,-19v32,44,53,28,96,-30r26,24r-37,45v15,11,21,26,22,50r-38,0v0,-18,-15,-24,-35,-24v-21,1,-42,-1,-42,18v0,17,25,12,42,13v46,0,83,8,83,52v0,85,-175,72,-171,-6r40,0v1,31,93,29,93,6v0,-17,-26,-14,-45,-14v-47,0,-80,-6,-80,-51","w":196},"\u0c16":{"d":"76,-176v60,0,91,77,63,129v31,14,81,5,77,-36v-3,-30,-16,-53,-46,-55r0,-38v52,4,80,39,83,93v4,77,-82,110,-137,66v-31,31,-102,28,-103,-25v-1,-50,67,-50,95,-26v7,-13,6,-33,-1,-46v-15,35,-82,24,-79,-20v2,-27,21,-42,48,-42xm86,-41v-11,-7,-33,-14,-38,-1v1,13,31,7,38,1xm116,49v-29,-5,-21,-36,0,-54v22,19,30,47,0,54xm85,-137v-11,-12,-33,7,-14,11v7,-1,13,-4,14,-11","w":270},"\u0c17":{"d":"143,-161v48,30,51,106,17,163r-34,-19v31,-47,28,-114,-30,-121v-57,7,-61,74,-30,121r-35,19v-35,-59,-30,-137,22,-165r-18,-21r27,-19v12,12,24,37,48,23v19,-11,33,-36,48,-53r26,24v-14,16,-25,34,-41,48","w":201},"\u0c18":{"d":"266,-176v55,3,90,35,90,91v0,52,-30,86,-82,88v-32,1,-49,-10,-63,-28v-25,34,-87,38,-114,9v-26,31,-86,11,-86,-34v0,-50,72,-67,91,-24v3,6,5,12,7,20v26,24,90,14,87,-31v-2,-32,-15,-54,-49,-53r0,-38v60,2,94,46,84,111v3,19,22,24,43,24v28,0,45,-15,45,-44v0,-33,-19,-53,-53,-53r0,-38xm152,-205v-26,31,-69,99,-122,56r-21,-24r23,-23v10,19,38,33,58,9r35,-42xm49,-50v-2,16,22,14,27,5v6,-9,-6,-17,-15,-17v-6,0,-13,6,-12,12xm114,22v0,27,-36,21,-36,0v0,-9,6,-19,18,-31v12,12,18,22,18,31","w":374},"\u0c19":{"d":"167,-41v31,1,36,-39,11,-53r29,-27v45,39,23,125,-40,124v-21,0,-36,-7,-47,-21v-35,49,-139,7,-106,-63v11,-20,38,-24,58,-36v5,-6,4,-23,-7,-21v-7,0,-13,6,-13,14r-38,0v2,-30,21,-52,51,-52v23,0,38,15,45,34r19,0r0,-34r33,0r0,34r23,0r0,34r-75,0v-8,30,-49,26,-63,49v0,14,11,18,25,18v17,0,29,-10,29,-29r38,0v0,18,11,29,28,29","w":248},"\u0c1a":{"d":"73,3v-48,2,-76,-49,-58,-91r-15,0r0,-35r79,0r0,35v-21,1,-33,7,-33,25v0,14,12,22,27,22v20,1,28,-11,28,-31r38,0v0,20,7,32,28,31v18,0,26,-13,27,-30v1,-56,-42,-67,-95,-69v-16,-7,-26,-25,-38,-37r23,-23v10,8,13,24,31,24v26,-7,41,-31,62,-57r26,24r-35,43v38,14,60,43,63,95v4,62,-76,99,-111,54v-9,14,-25,20,-47,20","w":248},"\u0c1b":{"d":"120,49v-30,-5,-22,-38,0,-54v22,19,29,48,0,54xm73,3v-48,2,-76,-49,-58,-91r-15,0r0,-35r79,0r0,35v-21,1,-33,7,-33,25v0,14,12,22,27,22v20,1,28,-11,28,-31r38,0v0,20,7,32,28,31v18,0,26,-13,27,-30v1,-56,-42,-67,-95,-69v-16,-7,-26,-25,-38,-37r23,-23v10,8,13,24,31,24v26,-7,41,-31,62,-57r26,24r-35,43v38,14,60,43,63,95v4,62,-76,99,-111,54v-9,14,-25,20,-47,20","w":248},"\u0c1c":{"d":"150,-176v31,1,51,17,51,48v0,45,-67,59,-102,36v-12,16,-43,14,-52,33v0,14,11,18,25,18v17,0,29,-7,29,-25r38,0v0,18,9,25,28,25v27,0,35,-32,16,-43r28,-28v38,33,17,115,-44,115v-21,0,-36,-7,-47,-21v-29,40,-119,20,-111,-41v-6,-47,55,-37,66,-68v0,-7,-3,-11,-10,-11v-7,0,-12,7,-12,16r-38,0v2,-31,20,-54,50,-54v28,0,48,20,47,52v7,5,18,8,27,10v25,5,37,-24,11,-24r0,-38","w":248},"\u0c1d":{"d":"342,-176v54,3,88,34,88,91v0,53,-29,86,-82,88v-31,1,-47,-11,-60,-29v-20,38,-103,39,-123,0v-13,17,-36,29,-65,29v-53,0,-88,-37,-88,-91v0,-36,20,-61,45,-76r-11,-13r23,-23v10,8,13,24,31,24v26,-7,41,-31,62,-57r27,24v-13,16,-26,35,-41,48v27,17,45,49,38,94v13,37,90,34,86,-18v-2,-33,-17,-53,-52,-53r0,-38v62,2,95,42,89,108v5,16,19,27,39,27v28,1,45,-16,45,-44v-1,-32,-17,-53,-51,-53r0,-38xm100,-41v29,0,50,-17,50,-47v0,-29,-20,-50,-50,-50v-30,0,-50,21,-50,50v0,30,21,47,50,47xm286,40v-26,-5,-19,-32,0,-49v12,12,18,22,18,31v0,11,-7,18,-18,18","w":448},"\u0c1e":{"d":"121,-156v23,-29,93,-26,103,14r15,0r0,-34r33,0r0,34r18,0r0,34r-58,0v0,35,-12,57,-32,75v6,12,11,28,11,46r-38,0v-1,-10,0,-17,-3,-24v-33,25,-102,17,-100,-35v2,-56,79,-55,108,-18v19,-16,28,-74,-10,-74v-19,1,-28,10,-28,31r-38,0v1,-20,-10,-31,-28,-31v-26,0,-35,32,-15,49r-26,27v-44,-38,-19,-115,41,-114v21,0,37,8,47,20xm108,-46v2,17,31,8,42,4v-7,-8,-39,-21,-42,-4","w":310},"\u0c1f":{"d":"169,-41v53,0,39,-96,-8,-97r0,-38v53,3,76,41,80,95v5,66,-70,110,-115,66v-8,13,-22,17,-43,18v-88,5,-99,-153,-32,-175r0,-43r33,0r0,42v19,8,33,23,34,47v2,37,-40,64,-73,44v-6,39,60,59,62,15r37,0v0,18,8,26,25,26xm52,-125v2,14,29,17,28,-1v-1,-18,-26,-12,-28,1","w":259},"\u0c20":{"d":"143,-161v68,36,44,164,-47,164v-94,0,-114,-134,-44,-167r-17,-20r27,-18v12,12,24,36,48,22v19,-11,33,-36,48,-53r26,23v-13,17,-25,35,-41,49xm96,-41v30,0,50,-18,50,-47v0,-30,-21,-50,-50,-50v-30,0,-50,21,-50,50v0,29,19,47,50,47xm96,-69v-28,0,-22,-38,0,-38v23,0,25,39,0,38","w":200},"\u0c21":{"d":"238,-50v3,60,-92,68,-116,26v-28,51,-119,25,-113,-44v5,-51,30,-81,66,-98r-15,-18r26,-18v12,12,25,37,48,22v18,-12,33,-36,48,-53r26,24v-13,15,-24,33,-38,46v12,6,23,14,35,26r-27,27v-42,-51,-129,-25,-131,41v-1,17,11,28,26,28v19,0,28,-11,28,-31r38,0v-1,18,8,30,19,37v-7,-30,8,-54,38,-54v23,0,41,14,42,39xm194,-32v11,-2,16,-25,2,-27v-12,1,-11,23,-2,27","w":253},"\u0c22":{"d":"238,-50v3,60,-92,68,-116,26v-28,51,-119,25,-113,-44v5,-51,30,-81,66,-98r-15,-18r26,-19v11,12,25,38,48,23v18,-12,33,-36,48,-53r26,24v-13,15,-24,33,-38,46v12,6,23,14,35,26r-27,27v-42,-51,-129,-25,-131,41v-1,17,11,28,26,28v19,0,28,-11,28,-31r38,0v-1,18,8,30,19,37v-7,-30,8,-54,38,-54v23,0,41,14,42,39xm194,-32v11,-2,16,-25,2,-27v-12,1,-11,23,-2,27xm123,40v-28,0,-20,-32,0,-49v12,12,17,22,17,31v0,10,-7,18,-17,18","w":253},"\u0c23":{"d":"60,3v-45,2,-66,-59,-37,-88v-31,-33,-5,-91,46,-91v17,0,31,7,43,20v50,-49,125,1,119,73v-4,46,-16,86,-60,86v-30,0,-48,-21,-48,-52v-1,-38,38,-58,71,-42v-2,-25,-11,-47,-36,-47v-17,0,-27,9,-27,28r-38,0v1,-17,-8,-28,-24,-28v-26,0,-30,33,-9,34r11,0r0,38v-25,-8,-33,25,-11,28v11,1,14,-7,14,-16r38,0v-2,33,-18,56,-52,57xm161,-49v3,19,27,10,29,-4v-7,-7,-28,-11,-29,4","w":248},"\u0c24":{"d":"43,-102v3,9,24,8,23,-2v-1,-14,-23,-9,-23,2xm175,-174v35,5,56,33,56,72v0,71,-41,105,-112,105v-63,0,-110,-28,-110,-89v0,-33,15,-60,48,-60v26,0,41,17,43,42v-3,26,-19,42,-49,41v18,29,115,31,136,0v-45,6,-62,-58,-26,-75v-29,-2,-63,6,-78,-12r-23,-27r23,-23v11,23,43,32,63,6r30,-39r26,23xm174,-104v0,7,9,10,17,7v3,-1,5,-3,6,-6v-2,-11,-22,-14,-23,-1","w":247},"\u0c25":{"d":"120,-119v27,0,22,38,0,38v-23,0,-25,-39,0,-38xm121,40v-28,0,-20,-32,0,-49v12,12,18,22,18,31v-1,10,-8,18,-18,18xm167,-41v16,1,28,-11,27,-27v-1,-46,-28,-70,-74,-70v-45,0,-72,24,-73,70v-1,16,10,28,26,27v17,-1,27,-8,28,-25r38,0v0,18,10,25,28,25xm171,-164v35,17,57,45,60,96v3,63,-74,94,-111,50v-10,12,-25,22,-47,21v-41,-2,-64,-30,-64,-71v0,-53,28,-82,66,-98r-13,-16r23,-23v12,13,24,39,50,25v20,-11,32,-36,47,-53r26,24","w":248},"\u0c26":{"d":"167,-41v16,1,28,-11,27,-27v-1,-46,-28,-70,-74,-70v-45,0,-72,24,-73,70v-1,16,10,28,26,27v17,-1,27,-8,28,-25r38,0v0,18,10,25,28,25xm171,-164v35,17,57,45,60,96v3,63,-74,94,-111,50v-10,12,-25,22,-47,21v-41,-2,-64,-30,-64,-71v0,-53,28,-82,66,-98r-13,-16r23,-23v12,13,24,39,50,25v20,-11,32,-36,47,-53r26,24","w":248},"\u0c27":{"d":"120,40v-28,0,-20,-32,0,-49v12,12,18,22,18,31v-1,10,-8,18,-18,18xm167,-41v16,1,28,-11,27,-27v-1,-46,-28,-70,-74,-70v-45,0,-72,24,-73,70v-1,16,10,28,26,27v17,-1,27,-8,28,-25r38,0v0,18,10,25,28,25xm171,-164v35,17,57,45,60,96v3,63,-74,94,-111,50v-10,12,-25,22,-47,21v-41,-2,-64,-30,-64,-71v0,-53,28,-82,66,-98r-13,-16r23,-23v12,13,24,39,50,25v20,-11,32,-36,47,-53r26,24","w":248},"\u0c28":{"d":"150,-174v49,9,77,41,81,99v5,72,-88,106,-125,50v-8,-21,-36,-66,-58,-30v-4,16,10,26,21,32r-23,32v-18,-13,-33,-30,-36,-58v-6,-62,84,-78,110,-31v10,18,17,41,42,41v21,0,32,-14,32,-36v2,-65,-62,-62,-122,-66v-18,-7,-26,-22,-39,-35r26,-23v11,22,43,31,63,5r30,-39r27,24","w":248},"\u0c2a":{"d":"143,-205v-27,31,-63,96,-119,59r-23,-27r23,-23v11,22,40,32,62,5r31,-38xm139,-176v54,4,89,35,92,93v4,75,-84,109,-136,67v-29,33,-86,11,-86,-34v0,-48,66,-68,88,-28v9,17,19,40,50,37v26,-2,46,-16,46,-42v0,-35,-22,-52,-54,-55r0,-38xm46,-50v0,17,27,14,28,0v-3,-15,-27,-16,-28,0","w":248},"\u0c2b":{"d":"143,-205v-27,31,-63,96,-119,59r-23,-27r23,-23v11,22,40,32,62,5r31,-38xm139,-176v54,4,89,35,92,93v4,75,-84,109,-136,67v-29,33,-86,11,-86,-34v0,-48,66,-68,88,-28v9,17,19,40,50,37v26,-2,46,-16,46,-42v0,-35,-22,-52,-54,-55r0,-38xm46,-50v0,17,27,14,28,0v-3,-15,-27,-16,-28,0xm114,22v0,27,-36,21,-36,0v0,-9,6,-19,18,-31v12,12,18,22,18,31","w":248},"\u0c2c":{"d":"231,-81v6,68,-71,111,-111,63v-29,40,-118,20,-111,-41v2,-18,11,-30,23,-38v-30,-24,-10,-83,33,-79v27,3,47,18,47,47v1,41,-53,41,-65,70v0,14,11,18,25,18v17,0,30,-8,29,-27r38,0v1,17,8,27,25,27v21,0,30,-18,30,-40v0,-31,-13,-54,-42,-58r7,-37v46,9,67,43,72,95xm57,-120v6,9,18,1,18,-9v0,-7,-3,-11,-10,-11v-9,0,-15,13,-8,20","w":248},"\u0c2d":{"d":"194,-81v-1,-35,-15,-62,-51,-59v-33,2,-40,-23,-59,-37r25,-24v12,21,43,38,59,6r31,-38r26,24r-37,45v61,24,60,167,-24,167v-21,0,-35,-9,-44,-21v-29,40,-119,20,-111,-41v-3,-41,48,-38,57,-68v0,-7,-3,-11,-10,-11v-6,0,-10,9,-10,16r-38,0v2,-30,18,-52,48,-54v42,-2,63,55,33,83v-7,11,-41,16,-42,34v0,14,11,18,25,18v17,0,30,-8,29,-27r38,0v1,17,8,27,25,27v21,0,30,-18,30,-40xm121,40v-28,0,-20,-32,0,-49v12,12,18,22,18,31v0,11,-7,18,-18,18","w":248},"\u0c2e":{"d":"270,-176v54,3,86,35,86,91v0,53,-29,86,-82,88v-33,0,-48,-9,-64,-28v-24,34,-86,38,-113,9v-24,32,-90,11,-86,-34v2,-29,21,-49,50,-50v50,-1,34,63,89,59v29,-2,45,-16,46,-44v2,-59,-63,-53,-119,-55v-16,-7,-26,-25,-38,-37r23,-23v32,42,52,22,93,-33r27,24v-11,15,-18,21,-29,34v54,7,87,50,79,111v16,37,86,28,86,-21v0,-33,-14,-53,-48,-53r0,-38xm49,-50v-2,16,22,14,27,5v6,-9,-6,-17,-15,-17v-6,0,-13,6,-12,12","w":374},"\u0c2f":{"d":"340,-176v54,3,90,35,90,91v0,53,-29,86,-82,88v-27,1,-48,-12,-60,-27v-20,37,-107,36,-125,-2v-14,17,-34,29,-63,29v-55,-2,-88,-37,-88,-91v0,-52,36,-88,88,-88v58,0,95,45,86,109v5,16,21,26,41,26v28,0,44,-16,44,-44v0,-38,-29,-54,-66,-56v-17,-6,-26,-24,-38,-36r23,-23v11,22,41,32,62,6r31,-39r26,24v-15,20,-25,31,-41,47v26,17,47,52,39,94v7,18,21,27,41,27v28,-1,45,-17,45,-44v0,-33,-19,-53,-53,-53r0,-38xm100,-41v31,0,50,-18,50,-47v0,-29,-20,-50,-50,-50v-30,0,-50,21,-50,50v0,30,21,47,50,47","w":447},"\u0c30":{"d":"143,-162v22,15,41,38,41,74v0,55,-33,87,-88,91v-95,7,-114,-135,-44,-167r-11,-13r24,-23v31,43,52,22,93,-33r27,24xm96,-41v30,0,50,-18,50,-47v0,-30,-21,-50,-50,-50v-30,0,-50,21,-50,50v0,29,19,47,50,47","w":200},"\u0c31":{"d":"182,-176v48,0,57,45,61,95v6,71,-76,110,-120,64v-11,12,-23,20,-44,20v-94,4,-95,-179,-10,-179v34,0,53,27,48,63r17,0v-7,-35,15,-63,48,-63xm46,-83v-8,40,55,60,59,18r38,0v0,18,10,25,29,24v22,-1,34,-16,33,-40v-1,-26,0,-57,-23,-57v-6,0,-12,5,-12,12v0,8,7,13,16,13r0,36v-46,-3,-104,7,-140,-6xm53,-126v1,16,28,17,27,0v0,-17,-25,-13,-27,0","w":260},"\u0c32":{"d":"164,-176v42,5,67,31,67,77v0,64,-44,102,-107,102v-73,0,-115,-39,-115,-110v0,-39,22,-69,59,-69v30,0,48,21,49,50v1,36,-33,60,-68,47v23,52,145,52,145,-20v0,-22,-10,-36,-30,-39r0,-38xm50,-126v3,14,29,18,30,0v-2,-16,-27,-14,-30,0","w":247},"\u0c33":{"d":"51,-176v43,-2,54,62,21,79v31,17,97,10,96,-33v-8,-18,-49,2,-61,-20r-24,-27r23,-23v11,12,23,33,46,20v20,-12,32,-36,47,-53r26,23v-11,16,-22,32,-35,44v38,35,1,100,-40,107v7,33,-9,62,-43,62v-34,0,-51,-29,-43,-63v-29,-13,-55,-34,-55,-74v0,-26,18,-41,42,-42xm47,-119v10,0,17,-21,4,-22v-12,0,-11,17,-4,22xm107,-36v4,1,9,-4,8,-8v1,-4,-3,-10,-8,-9v-5,-1,-9,5,-9,9v0,4,5,9,9,8","w":221},"\u0c35":{"d":"231,-85v6,76,-86,113,-136,69v-24,32,-90,11,-86,-34v2,-29,21,-48,50,-50v50,-2,36,62,88,59v29,-1,46,-17,47,-44v2,-59,-63,-53,-119,-55v-16,-7,-26,-25,-38,-37r23,-23v10,23,42,31,62,6r31,-39r26,24v-11,14,-20,25,-28,34v48,6,76,39,80,90xm47,-50v-2,16,22,14,27,5v6,-9,-6,-17,-15,-17v-8,0,-12,4,-12,12","w":248},"\u0c36":{"d":"129,-176v53,-4,75,69,29,91v18,40,-4,88,-50,88v-51,0,-75,-66,-36,-94v-16,2,-28,11,-39,25r-27,-28v30,-36,87,-43,128,-19v15,-5,18,-25,-7,-25v-32,0,-72,7,-89,-12r-24,-27r23,-23v11,12,23,33,46,20v20,-12,32,-36,47,-53r27,24v-11,14,-20,24,-28,33xm90,-51v0,22,38,15,37,-5v0,-7,-2,-13,-5,-17v-14,4,-32,8,-32,22","w":198},"\u0c37":{"d":"145,-205v-24,47,-103,107,-141,32r24,-23v10,23,39,31,60,5r31,-38xm192,-8v-25,17,-79,14,-98,-6v-27,30,-85,8,-85,-36v0,-52,77,-67,95,-22v9,48,93,36,93,-15v0,-36,-22,-49,-56,-51r0,-38v81,-4,110,72,85,145v2,17,10,30,25,34r-14,34v-22,-8,-39,-22,-45,-45xm47,-50v0,17,28,14,29,0v-3,-14,-28,-17,-29,0","w":248},"\u0c38":{"d":"139,-176v62,2,87,39,92,101v5,72,-88,105,-126,50v-7,-22,-36,-65,-57,-30v-4,16,9,27,21,32r-23,32v-19,-12,-33,-32,-37,-58v-6,-62,85,-78,111,-31v10,17,16,41,41,41v21,0,32,-13,32,-36v-1,-39,-17,-62,-54,-63r0,-38xm58,-172v25,-4,45,-34,62,-57r26,24v-26,44,-91,105,-133,43v-3,-4,-6,-8,-8,-11r24,-23v7,8,15,23,29,24","w":248},"\u0c39":{"d":"298,-176v28,2,46,21,46,49v0,28,-18,48,-46,48v-32,0,-49,-26,-46,-59r-36,0v59,72,-35,191,-119,122v-25,32,-87,11,-87,-34v0,-50,70,-67,91,-25v10,19,19,35,48,34v26,-1,46,-14,46,-41v0,-38,-21,-55,-58,-56r0,-38r161,0xm60,-172v27,-5,43,-34,62,-57r26,24v-36,57,-97,104,-141,32r23,-23v13,12,12,22,30,24xm283,-127v0,17,29,19,29,0v0,-21,-28,-17,-29,0xm48,-50v0,18,28,13,29,0v-3,-14,-29,-17,-29,0","w":354},"\u0c3e":{"d":"49,-176v28,2,46,20,46,49v0,29,-19,48,-46,48v-31,0,-50,-26,-45,-59r-196,0r0,-38r241,0xm49,-113v20,0,16,-29,0,-29v-7,0,-14,7,-14,15v0,8,6,14,14,14","w":108},"\u0c3f":{"d":"-184,-263v34,0,55,23,57,58v4,68,-81,77,-117,36r23,-23v19,21,56,22,61,-6v-22,20,-64,4,-62,-28v1,-22,16,-37,38,-37xm-184,-232v-9,0,-10,13,0,13v15,0,17,-15,0,-13","w":0},"\u0c40":{"d":"-185,-263v34,3,56,23,58,58v4,68,-81,77,-117,36r23,-23v19,21,56,22,61,-6v-30,28,-82,-13,-55,-49v-21,-28,9,-73,48,-57v13,6,25,19,26,36r-33,0v1,-6,-3,-10,-9,-9v-2,0,-8,3,-7,7v0,3,1,8,5,7xm-184,-232v-9,0,-10,13,0,13v15,0,17,-15,0,-13","w":0},"\u0c41":{"d":"13,-176v56,3,89,36,94,91v8,88,-122,120,-155,44v-4,-9,-6,-20,-6,-32r36,0v0,24,18,32,41,32v29,0,46,-16,46,-44v0,-33,-21,-52,-56,-53r0,-38","w":124},"\u0c42":{"d":"166,-176v28,2,47,21,47,49v0,29,-19,48,-47,48v-31,0,-49,-27,-45,-59r-31,0v44,62,-7,170,-96,136v-26,-10,-45,-34,-46,-69r30,0v5,20,23,30,46,30v28,0,45,-16,45,-44v0,-33,-21,-53,-56,-53r0,-38r153,0xm152,-127v0,16,23,18,28,5v4,-10,-4,-20,-14,-20v-8,0,-14,6,-14,15","w":230},"\u0c43":{"d":"57,48v9,-8,14,-20,14,-35v0,-42,-24,-82,-73,-120r22,-24v56,47,84,95,84,144v0,42,-27,71,-69,75v-59,6,-80,-93,-17,-93v28,0,46,23,39,53xm20,51v8,-4,9,-24,-2,-24v-11,1,-8,22,2,24","w":112},"\u0c44":{"d":"1,-140v69,6,179,-25,179,48v0,28,-18,49,-46,49v-32,0,-49,-25,-45,-59r-37,0v35,37,53,75,53,115v0,43,-26,71,-69,75v-59,5,-80,-93,-16,-93v28,0,45,24,38,53v9,-8,14,-20,14,-35v0,-42,-24,-82,-71,-118r0,-35xm134,-78v8,-1,14,-5,14,-14v0,-8,-6,-14,-14,-14v-9,0,-13,6,-14,14v-1,7,7,15,14,14xm21,52v7,-5,11,-24,-1,-26v-13,1,-11,23,1,26"},"\u0c46":{"d":"-204,-223v61,7,163,-25,165,40v1,43,-41,48,-87,44r0,-37v18,-3,49,8,55,-7v-1,-5,-2,-7,-8,-7r-125,0r0,-33","w":0},"\u0c47":{"d":"-88,-223v31,-2,48,13,49,40v2,44,-41,47,-87,44r0,-37r48,0v5,1,7,-4,7,-7v0,-5,-2,-7,-7,-7r-126,0r0,-33r82,0v-7,-43,31,-50,76,-46r0,32v-16,1,-54,-7,-42,14","w":0},"\u0c48":{"d":"-204,-223v62,7,162,-24,165,40v2,42,-43,42,-87,40r0,-33v18,-3,49,8,55,-7v0,-4,-3,-7,-7,-7r-126,0r0,-33xm-199,9v25,0,40,18,39,46r157,0r0,33r-196,0v-24,-1,-40,-16,-40,-40v0,-24,16,-39,40,-39xm-208,48v0,11,18,11,18,0v0,-11,-18,-11,-18,0","w":0},"\u0c4a":{"d":"-197,-200v-4,-54,72,-82,100,-40v26,-29,119,-36,117,23v-1,27,-18,45,-45,45v-28,0,-46,-18,-45,-50v-9,3,-12,14,-11,26r-33,0v0,-18,-6,-33,-25,-32v-18,0,-26,12,-26,28v0,15,9,24,26,24r0,38v-37,-1,-56,-26,-58,-62xm-25,-204v7,1,12,-7,12,-13v0,-8,-5,-12,-12,-13v-8,1,-13,5,-13,13v0,8,5,12,13,13","w":0},"\u0c4b":{"d":"-197,-200v-4,-54,72,-82,100,-40v8,-7,19,-14,32,-17v-14,-38,39,-66,66,-37v7,6,12,16,13,27r-33,0v1,-6,-3,-10,-9,-9v-7,1,-10,9,-4,14v30,1,52,15,52,45v0,27,-18,45,-45,45v-28,0,-46,-18,-45,-50v-9,3,-12,14,-11,26r-33,0v0,-18,-6,-33,-25,-32v-18,0,-26,12,-26,28v0,15,9,24,26,24r0,38v-37,-1,-56,-26,-58,-62xm-25,-204v7,1,12,-7,12,-13v0,-8,-5,-12,-12,-13v-8,1,-13,5,-13,13v0,8,5,12,13,13","w":0},"\u0c4c":{"d":"32,-221v28,1,42,19,45,45v-2,26,-17,45,-45,45v-32,0,-51,-26,-44,-58v-6,1,-16,-4,-13,7v0,45,-52,40,-98,39r0,-33r60,0v9,0,6,-12,0,-13r-80,0r0,-32r175,0xm32,-163v8,0,12,-5,12,-13v0,-7,-4,-13,-12,-13v-6,-1,-14,7,-13,13v1,8,5,13,13,13","w":88},"\u0c4d":{"d":"-110,-208v-21,-23,-1,-61,31,-61r83,0r0,33r-83,0v-6,-1,-7,3,-8,7v4,14,36,4,53,7r0,33v-18,3,-50,-7,-55,7v1,6,10,6,18,6r0,38v-44,8,-63,-44,-39,-70","w":0},"\u0c55":{"d":"-72,-278v-4,-41,61,-54,76,-18v2,5,3,11,3,18r-30,0v0,-6,-5,-8,-9,-10v-4,0,-8,3,-7,8v0,4,5,9,11,8r1,32v-27,0,-43,-13,-45,-38","w":0},"\u0c56":{"d":"-199,23v25,0,40,18,39,46r157,0r0,33r-196,0v-24,-1,-40,-16,-40,-40v0,-24,16,-39,40,-39xm-200,71v6,1,10,-3,9,-9v1,-6,-4,-9,-9,-9v-5,0,-8,4,-8,9v-1,5,3,10,8,9","w":0},"\u0c60":{"d":"490,-176v29,1,47,21,47,49v0,28,-19,48,-47,48v-31,0,-50,-26,-45,-59r-33,0v40,48,16,143,-53,141v-21,0,-37,-10,-48,-22v-21,27,-74,31,-97,0v-25,28,-68,30,-93,2v-33,41,-107,14,-107,-42v0,-47,44,-48,66,-68v0,-7,-3,-11,-10,-11v-6,0,-13,8,-12,15r-38,0v0,-33,20,-51,50,-53v42,-2,64,57,31,83v-14,12,-48,11,-49,34v0,12,8,18,24,18v17,0,26,-7,25,-26r38,0v1,18,8,26,27,26v22,0,33,-13,33,-40v-1,-37,-23,-56,-60,-57r0,-38v64,3,96,44,96,114v0,14,9,21,27,21v22,-1,34,-16,34,-40v0,-38,-20,-56,-58,-57r0,-38v62,3,94,45,94,113v0,15,9,22,27,22v23,-1,35,-16,35,-40v-2,-35,-19,-56,-55,-57r0,-38r151,0xm476,-127v-1,16,23,18,28,5v4,-10,-5,-19,-14,-20v-8,-1,-15,7,-14,15","w":562},"\u0c61":{"d":"205,-176v65,4,161,-21,160,49v-1,29,-19,48,-46,48v-31,0,-50,-26,-45,-59r-20,0v11,83,-41,141,-120,141v-48,0,-90,-15,-90,-61v0,-48,55,-50,99,-41v27,0,22,-38,0,-39v-15,0,-18,11,-19,25r-37,0v-1,-15,-5,-25,-20,-25v-16,1,-24,20,-13,34r-27,24v-50,-50,28,-130,78,-80v34,-35,96,-7,95,41v-1,50,-48,65,-101,53v-12,0,-18,3,-18,8v4,19,30,19,53,20v54,0,89,-31,85,-85v-1,-9,-5,-15,-14,-15r0,-38xm319,-113v20,0,16,-29,0,-29v-7,0,-14,7,-14,15v0,8,6,14,14,14","w":382},"\u0c66":{"d":"96,-176v52,0,88,36,88,88v0,53,-35,91,-88,91v-54,0,-88,-37,-88,-91v0,-52,36,-88,88,-88xm96,-41v30,0,50,-18,50,-47v0,-30,-21,-50,-50,-50v-30,0,-50,21,-50,50v0,30,21,47,50,47","w":200},"\u0c67":{"d":"99,-176v92,0,118,122,57,178r-30,-24v39,-30,35,-116,-27,-116v-60,0,-65,86,-26,116r-30,24v-62,-56,-36,-178,56,-178","w":207},"\u0c68":{"d":"132,-176v51,0,88,36,88,88v0,53,-33,91,-88,91r-123,0r0,-44v67,-6,171,25,173,-47v0,-11,-3,-20,-9,-27v-10,44,-89,36,-86,-15v2,-28,18,-46,45,-46xm123,-130v4,13,22,10,24,-6v-8,-4,-25,-5,-24,6","w":237},"\u0c69":{"d":"140,-88v35,51,-21,109,-89,88v-26,-9,-43,-25,-43,-59r37,0v1,16,16,18,34,18v23,0,34,-5,34,-14v1,-23,-32,-11,-51,-14r0,-38v20,-2,54,8,51,-14v-3,-24,-70,-25,-68,6r-37,0v1,-42,29,-58,71,-61v54,-3,91,46,61,88","w":163},"\u0c6a":{"d":"157,-176v28,2,48,14,48,42v0,39,-25,63,-56,74v10,32,-8,63,-42,63v-35,0,-51,-29,-43,-63v-52,-8,-86,-111,-8,-116r0,35v-6,0,-13,2,-13,7v4,58,124,59,128,0v0,-5,-8,-7,-14,-7r0,-35xm107,-36v6,1,9,-4,9,-9v0,-11,-18,-11,-18,0v0,5,3,10,9,9","w":220},"\u0c6b":{"d":"182,-107v19,-14,0,-37,-14,-47r32,-24v31,28,36,62,14,90v22,28,17,64,-14,90r-28,-24v14,-11,25,-30,11,-46v-5,65,-101,93,-155,52v-6,-5,-13,-11,-21,-19r24,-30v31,37,116,36,116,-23v0,-57,-82,-65,-116,-23r-24,-30v48,-56,164,-41,175,34","w":241},"\u0c6c":{"d":"117,-69v-27,1,-86,-8,-66,25v42,8,98,1,145,3r0,44v-76,-5,-188,25,-188,-56v0,-15,4,-28,13,-35v-30,-33,-4,-88,40,-88r36,0r0,38v-21,1,-52,-7,-51,15v0,28,45,12,71,16r0,38","w":210},"\u0c6d":{"d":"85,-41v23,-1,41,-2,43,-20r38,0v-1,46,-32,64,-79,64v-45,0,-79,-14,-79,-58v0,-42,28,-50,71,-52v25,-2,44,4,49,-13v0,-12,-13,-18,-41,-18v-21,0,-41,3,-41,24r-38,0v0,-45,34,-62,79,-62v43,0,79,15,79,56v0,43,-33,51,-79,51v-18,0,-40,-3,-41,14v0,10,12,14,39,14","w":179},"\u0c6e":{"d":"146,-88v-1,-33,-22,-49,-55,-50r0,-38r120,0r0,38r-43,0v38,56,1,141,-72,141v-82,0,-115,-104,-58,-157r27,27v-35,29,-17,88,31,86v30,-1,50,-16,50,-47","w":227},"\u0c6f":{"d":"21,-88v-30,-30,-4,-88,40,-88r133,0r0,38r-133,0v-18,0,-20,31,0,31r56,0r0,38v-26,3,-71,-11,-71,16v0,19,32,10,51,12r0,44v-68,14,-112,-41,-76,-91","w":205},"\u0c58":{"d":"171,-310v21,0,35,14,35,36v0,22,-14,35,-35,35r-151,0r0,-31r115,0v0,-25,13,-40,36,-40xm177,-276v0,-4,-2,-6,-6,-6v-4,0,-5,2,-5,6v0,4,1,5,5,5v4,0,6,-1,6,-5xm73,3v-48,2,-76,-49,-58,-91r-15,0r0,-35r79,0r0,35v-21,1,-33,7,-33,25v0,14,12,22,27,22v20,1,28,-11,28,-31r38,0v0,20,7,32,28,31v18,0,26,-13,27,-30v1,-56,-42,-67,-95,-69v-16,-7,-26,-25,-38,-37r23,-23v10,8,13,24,31,24v26,-7,41,-31,62,-57r26,24r-35,43v38,14,60,43,63,95v4,62,-76,99,-111,54v-9,14,-25,20,-47,20","w":248},"\u0c59":{"d":"179,-265v22,0,36,14,36,36v0,21,-13,35,-36,35r-150,0r0,-31r115,0v0,-24,13,-40,35,-40xm186,-231v0,-4,-2,-6,-6,-6v-4,0,-6,2,-6,6v0,4,2,6,6,6v4,0,6,-2,6,-6xm150,-176v31,1,51,17,51,48v0,45,-67,59,-102,36v-12,16,-43,14,-52,33v0,14,11,18,25,18v17,0,29,-7,29,-25r38,0v0,18,9,25,28,25v27,0,35,-32,16,-43r28,-28v38,33,17,115,-44,115v-21,0,-36,-7,-47,-21v-29,40,-119,20,-111,-41v-6,-47,55,-37,66,-68v0,-7,-3,-11,-10,-11v-7,0,-12,7,-12,16r-38,0v2,-31,20,-54,50,-54v28,0,48,20,47,52v7,5,18,8,27,10v25,5,37,-24,11,-24r0,-38","w":248},"\u0c62":{"d":"-172,57v-5,-42,45,-61,71,-37v23,-23,67,-4,67,32v0,39,-29,46,-69,46v-6,0,-8,1,-8,4v0,5,6,8,20,8v40,1,67,-11,67,-51r32,0v1,62,-38,83,-99,83v-36,0,-53,-14,-53,-40v0,-29,25,-39,57,-36v18,2,30,-18,11,-24v-6,1,-9,6,-9,15r-31,0v0,-9,-3,-16,-11,-15v-8,0,-13,7,-13,15r-32,0","w":0},"\u0c63":{"d":"-153,110v55,3,71,-34,66,-92v36,4,91,-15,95,25v3,29,-45,34,-51,7r-11,0v-1,62,-37,92,-99,92v-31,0,-54,-12,-54,-40v0,-29,26,-39,58,-36v17,2,28,-17,11,-24v-7,1,-11,5,-10,15r-31,0v0,-9,-3,-16,-11,-15v-8,1,-12,8,-13,15r-32,0v-5,-42,45,-61,71,-37v23,-23,67,-4,67,32v0,40,-29,45,-68,46v-6,0,-9,1,-9,4v0,5,7,8,21,8","w":0},"\u25cc":{"d":"167,-142v-8,-12,-17,-22,-29,-30r19,-26v16,10,27,20,37,36xm83,-208v17,-5,35,-5,52,0r-5,32v-19,-4,-22,-4,-41,0xm201,-143v3,17,4,34,0,52r-33,-5v4,-12,5,-29,0,-41xm138,-62v12,-8,21,-17,29,-29r27,19v-10,15,-22,27,-37,37xm81,-172v-12,7,-22,17,-29,30r-28,-19v10,-15,23,-27,38,-37xm18,-91v-5,-23,-5,-29,0,-52r32,6v-4,19,-4,22,0,41xm135,-25v-17,3,-34,4,-52,0r6,-33v19,4,22,4,41,0xm52,-91v7,12,17,22,29,29r-19,27v-15,-10,-28,-22,-38,-37","w":226},"\u200c":{"d":"0,-274r28,-28r16,16r-28,28r28,28r-16,16r-16,-17r0,276r-24,0r0,-275r-16,16r-16,-16r28,-28v-9,-10,-21,-19,-28,-28r16,-16","w":0},"\u200d":{"d":"12,45r-24,0r0,-316r24,0r0,316","w":0},"$":{"d":"17,-173v0,-44,29,-65,71,-69r0,-25r20,0r0,25v40,4,66,25,69,66r-42,0v-2,-18,-10,-28,-27,-30r0,67v41,8,74,22,74,70v0,46,-30,69,-74,73r0,25r-20,0r0,-25v-47,-4,-74,-28,-77,-76r43,0v1,24,12,37,34,41r0,-74v-37,-9,-71,-23,-71,-68xm88,-207v-33,1,-37,49,-11,59v3,2,7,3,11,4r0,-63xm108,-31v34,2,42,-52,15,-64v-4,-2,-9,-3,-15,-5r0,69","w":196},"A":{"d":"144,-97r-34,-101r-33,101r67,0xm224,0r-48,0r-21,-61r-89,0r-21,61r-45,0r85,-238r50,0","w":223},"B":{"d":"162,-126v26,8,43,24,44,56v3,83,-98,70,-181,70r0,-238v76,1,172,-13,172,61v0,26,-15,42,-35,51xm152,-171v0,-38,-46,-29,-82,-30r0,60v36,-1,82,8,82,-30xm159,-70v0,-43,-49,-33,-89,-34r0,67v40,-1,89,8,89,-33","w":221},"C":{"d":"227,-81v-7,54,-40,85,-100,85v-75,0,-105,-49,-112,-123v-12,-117,146,-165,203,-76v6,9,9,22,10,35r-46,0v-5,-28,-23,-43,-55,-43v-47,0,-65,36,-65,84v0,47,17,83,65,84v33,1,52,-17,55,-46r45,0","w":243},"D":{"d":"103,-238v81,0,124,37,124,118v0,80,-41,120,-124,120r-78,0r0,-238r78,0xm180,-120v0,-66,-39,-86,-110,-79r0,160v71,6,110,-13,110,-81","w":243},"E":{"d":"206,0r-181,0r0,-238r176,0r0,39r-131,0r0,58r122,0r0,39r-122,0r0,63r136,0r0,39","w":221},"F":{"d":"190,-199r-120,0r0,63r103,0r0,39r-103,0r0,97r-45,0r0,-238r165,0r0,39","w":204},"G":{"d":"202,-21v-16,17,-40,25,-72,25v-76,-1,-108,-49,-115,-123v-11,-118,149,-165,208,-76v6,10,10,21,11,33r-46,0v-3,-29,-27,-41,-58,-41v-48,0,-68,36,-68,84v0,50,20,83,69,84v28,0,49,-9,62,-25r0,-29r-54,0r0,-36r98,0r0,125r-29,0","w":258},"H":{"d":"218,0r-45,0r0,-106r-103,0r0,106r-45,0r0,-238r45,0r0,94r103,0r0,-94r45,0r0,238","w":243},"I":{"d":"73,0r-46,0r0,-238r46,0r0,238","w":99},"J":{"d":"81,-36v24,0,30,-18,29,-42r0,-160r45,0v-9,97,36,246,-74,242v-48,-2,-72,-28,-71,-78r43,0v1,21,6,38,28,38","w":180},"K":{"d":"224,0r-54,0r-73,-112r-27,26r0,86r-45,0r0,-238r45,0r0,109r95,-109r56,0r-89,100","w":224},"L":{"d":"179,0r-154,0r0,-238r45,0r0,198r109,0r0,40","w":188},"M":{"d":"269,0r-42,0r1,-192r-60,192r-41,0r-61,-192r2,192r-43,0r0,-238r65,0r57,185r56,-185r66,0r0,238","w":293},"N":{"d":"218,0r-46,0r-106,-171r2,171r-43,0r0,-238r46,0r106,172r-1,-172r42,0r0,238","w":243},"O":{"d":"15,-119v0,-76,40,-123,115,-123v73,0,113,48,113,123v0,74,-39,123,-113,123v-75,0,-115,-48,-115,-123xm62,-119v0,47,20,84,67,84v48,0,68,-36,68,-84v0,-47,-19,-84,-67,-84v-48,0,-68,36,-68,84","w":258},"P":{"d":"208,-166v0,71,-63,81,-138,77r0,89r-45,0r0,-238v86,0,183,-15,183,72xm161,-165v0,-44,-49,-35,-91,-36r0,75v42,-2,91,8,91,-39","w":221},"Q":{"d":"243,-118v0,38,-11,67,-30,88r34,27r-25,31r-44,-35v-83,34,-167,-20,-163,-112v3,-75,40,-123,115,-123v74,0,113,49,113,124xm62,-119v-1,54,29,92,85,82r-17,-14r22,-27r26,21v34,-45,23,-150,-48,-146v-48,2,-67,36,-68,84","w":258},"R":{"d":"217,-170v0,37,-21,55,-51,62v40,15,45,70,63,108r-49,0v-18,-36,-15,-92,-66,-94r-44,0r0,94r-45,0r0,-238v85,3,192,-21,192,68xm171,-167v0,-47,-57,-33,-101,-35r0,71v44,-2,101,12,101,-36","w":238},"S":{"d":"183,-122v64,41,13,126,-66,126v-62,0,-101,-26,-105,-82r44,0v-2,53,104,63,111,11v-20,-63,-149,-11,-146,-112v2,-79,151,-81,177,-20v4,9,7,19,8,31r-44,0v-2,-24,-19,-37,-50,-37v-44,0,-66,46,-20,56v32,7,67,11,91,27","w":226},"T":{"d":"196,-198r-72,0r0,198r-46,0r0,-198r-71,0r0,-40r189,0r0,40","w":202},"U":{"d":"218,-100v2,68,-27,104,-96,104v-69,0,-97,-34,-97,-104r0,-138r45,0r0,137v0,41,11,65,52,65v41,0,52,-23,51,-65r0,-137r45,0r0,138","w":243},"V":{"d":"220,-238r-84,238r-51,0r-84,-238r48,0r62,196r62,-196r47,0","w":221},"W":{"d":"313,-238r-61,238r-47,0r-46,-190r-47,190r-48,0r-60,-238r45,0r40,189r46,-189r47,0r46,189r40,-189r45,0","w":316},"X":{"d":"226,0r-52,0r-60,-95r-60,95r-53,0r85,-125r-78,-113r52,0r54,84r53,-84r52,0r-78,113","w":227},"Y":{"d":"221,-238r-88,140r0,98r-45,0r0,-98r-87,-140r51,0r59,102r59,-102r51,0","w":221},"Z":{"d":"196,0r-190,0r0,-38r132,-161r-120,0r0,-39r174,0r0,38r-132,161r136,0r0,39","w":204},"`":{"d":"87,-196r-31,0r-40,-47r50,0","w":123},"a":{"d":"57,-49v0,37,63,25,73,4r0,-34v-36,0,-73,-1,-73,30xm97,-176v48,0,77,14,77,65r0,111r-44,0r0,-16v-31,31,-118,29,-118,-30v0,-44,48,-63,118,-60v2,-30,-8,-42,-35,-42v-22,0,-34,7,-36,25r-40,0v2,-35,28,-53,78,-53"},"b":{"d":"185,-87v6,73,-69,116,-120,74r0,13r-44,0r0,-238r45,0r-1,86v12,-14,28,-24,51,-24v50,1,65,39,69,89xm105,-143v-20,0,-29,11,-39,25r0,74v31,31,78,12,73,-43v-3,-32,-8,-56,-34,-56","w":196},"c":{"d":"172,-56v-6,37,-31,60,-74,60v-56,0,-83,-34,-86,-90v-5,-77,78,-114,137,-75v13,9,21,25,23,45r-42,0v-1,-16,-14,-28,-32,-27v-31,1,-41,24,-41,57v0,32,10,57,41,57v18,0,31,-10,32,-27r42,0","w":177},"d":{"d":"57,-85v-8,58,53,71,73,31r0,-73v-31,-33,-80,-11,-73,42xm12,-85v0,-73,68,-116,119,-74r-1,-79r45,0r0,238r-44,0r0,-21v-12,15,-26,25,-50,25v-50,-1,-69,-37,-69,-89","w":196},"e":{"d":"179,-52v-7,37,-36,56,-79,56v-58,0,-87,-33,-88,-90v0,-58,29,-90,86,-90v59,0,87,37,85,100r-126,0v-8,52,69,70,81,24r41,0xm138,-104v1,-38,-41,-57,-67,-33v-7,7,-11,18,-13,33r80,0"},"f":{"d":"111,-207v-28,-7,-44,2,-39,35r31,0r0,33r-31,0r0,139r-45,0r0,-139r-25,0r0,-33r25,0v-6,-58,27,-79,84,-69r0,34","w":104},"g":{"d":"12,-85v-10,-73,68,-116,119,-74r0,-13r44,0r0,160v9,79,-83,101,-139,67v-12,-7,-17,-22,-18,-39r43,0v2,18,12,25,33,25v35,0,38,-28,37,-63v-45,53,-130,14,-119,-63xm92,-30v18,0,28,-12,38,-25r0,-72v-31,-33,-73,-12,-73,42v0,31,9,55,35,55","w":196},"h":{"d":"133,-109v3,-49,-52,-35,-67,-10r0,119r-44,0r0,-238r44,0r-1,87v36,-44,112,-30,112,39r0,112r-44,0r0,-109","w":198},"i":{"d":"66,0r-45,0r0,-172r45,0r0,172xm66,-201r-45,0r0,-38r45,0r0,38","w":87},"j":{"d":"-11,33v24,7,32,-4,32,-29r0,-176r45,0r0,177v4,50,-26,73,-77,62r0,-34xm66,-201r-45,0r0,-38r45,0r0,38","w":87},"k":{"d":"180,0r-50,0r-48,-82r-16,14r0,68r-44,0r0,-238r44,0r0,134r58,-68r51,0r-60,66","w":180},"l":{"d":"66,0r-45,0r0,-238r45,0r0,238","w":87},"m":{"d":"165,-146v14,-15,27,-29,54,-30v77,-4,51,105,55,176r-44,0r0,-109v4,-48,-47,-36,-60,-10r0,119r-44,0r0,-109v4,-48,-47,-36,-60,-10r0,119r-45,0r0,-172r44,0r0,22v20,-33,87,-36,100,4","w":294},"n":{"d":"132,-109v4,-45,-47,-39,-66,-10r0,119r-45,0r0,-172r44,0r0,22v35,-44,112,-32,112,38r0,112r-45,0r0,-109","w":197},"o":{"d":"12,-86v0,-58,30,-90,86,-90v56,0,85,33,85,90v0,57,-29,90,-85,90v-56,0,-86,-32,-86,-90xm57,-86v0,32,10,57,41,57v31,0,40,-25,40,-57v0,-32,-9,-57,-40,-57v-31,0,-41,25,-41,57"},"p":{"d":"112,4v-21,0,-36,-6,-47,-17r1,79r-45,0r0,-238r44,0r0,21v11,-13,29,-26,52,-25v49,2,68,39,68,89v0,51,-21,90,-73,91xm105,-143v-20,0,-29,11,-39,25r0,74v31,31,78,12,73,-43v-3,-32,-8,-56,-34,-56","w":196},"q":{"d":"84,-176v22,0,35,6,47,17r0,-13r44,0r0,238r-45,0r1,-87v-12,15,-28,25,-53,24v-48,-2,-66,-36,-66,-88v1,-52,21,-89,72,-91xm57,-85v-8,58,53,71,73,31r0,-73v-31,-33,-80,-11,-73,42","w":196},"r":{"d":"65,-146v13,-19,31,-34,62,-29r0,40v-25,-7,-50,2,-61,20r0,115r-45,0r0,-172r44,0r0,26","w":127},"s":{"d":"145,-87v40,36,0,96,-58,91v-48,-4,-74,-16,-78,-56r42,0v0,20,14,30,36,29v25,4,45,-26,23,-38v-36,-19,-94,-10,-96,-63v-2,-56,87,-63,124,-39v12,8,18,21,19,37r-41,0v-1,-15,-11,-22,-31,-22v-30,0,-41,31,-10,37v23,5,55,11,70,24","w":172},"t":{"d":"102,-31r0,31v-53,13,-75,-11,-75,-73r0,-66r-23,0r0,-33r23,0r0,-43r44,0r0,43r28,0r0,33r-28,0v6,42,-20,121,31,108","w":104},"u":{"d":"65,-63v-4,45,48,39,66,10r0,-119r45,0r0,172r-43,0r0,-22v-30,42,-112,34,-112,-38r0,-112r44,0r0,109","w":197},"v":{"d":"172,-172r-63,172r-44,0r-62,-172r46,0r38,128r39,-128r46,0","w":174},"w":{"d":"253,-172r-50,172r-43,0r-33,-121r-32,121r-43,0r-50,-172r44,0r28,125r34,-125r39,0r34,125r28,-125r44,0","w":254},"x":{"d":"174,0r-49,0r-37,-62r-37,62r-49,0r59,-89r-54,-83r47,0r34,58r33,-58r48,0r-54,83","w":175},"y":{"d":"109,0v-12,43,-37,84,-93,66r0,-36v28,10,44,-6,50,-30r-63,-172r46,0r38,128r39,-128r46,0","w":174},"z":{"d":"167,0r-159,0r0,-33r97,-105r-91,0r0,-34r147,0r0,33r-97,105r103,0r0,34","w":174},"\u20ac":{"d":"139,-166v1,-35,-41,-56,-62,-28v-6,9,-10,23,-12,42r47,0r-6,20r-42,0v0,9,-2,19,0,27r34,0r-5,20r-28,0v4,30,11,56,45,50v17,-3,26,-15,29,-41r44,0v-6,48,-28,81,-80,80v-55,-1,-76,-37,-83,-89r-18,0r0,-20r17,0v0,-9,-2,-19,0,-27r-17,0r0,-20r18,0v-8,-90,121,-123,155,-45v4,9,6,20,8,31r-44,0","w":196},"\u201a":{"d":"65,-40v1,44,3,90,-44,89r0,-20v16,0,20,-11,20,-29r-21,0r0,-40r45,0","w":84},"\u0192":{"d":"94,34v-7,33,-46,42,-83,32r0,-33v28,9,41,-2,46,-29r25,-142r-30,0r5,-32r30,0v2,-52,29,-83,90,-69r0,36v-22,-6,-43,-5,-43,20r-3,13r32,0r-5,32r-32,0r-24,142v-2,12,-6,22,-8,30","w":196},"\u201e":{"d":"122,-40v1,44,4,91,-44,89r0,-20v16,0,21,-11,21,-29r-22,0r0,-40r45,0xm60,-40v1,43,4,90,-43,89r0,-20v17,0,19,-12,20,-29r-21,0r0,-40r44,0","w":137},"\u2020":{"d":"180,-135r-63,0r0,205r-37,0r0,-205r-64,0r0,-34r64,0r0,-69r37,0r0,69r63,0r0,34","w":196},"\u2021":{"d":"180,0r-63,0r0,70r-37,0r0,-70r-64,0r0,-34r64,0r0,-101r-64,0r0,-34r64,0r0,-69r37,0r0,69r63,0r0,34r-63,0r0,101r63,0r0,34","w":196},"\u02c6":{"d":"118,-196r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":123},"\u2030":{"d":"6,-179v0,-39,17,-63,55,-63v38,0,55,24,55,63v0,39,-17,63,-55,63v-38,0,-55,-24,-55,-63xm40,-179v0,21,3,39,21,39v17,0,21,-18,21,-39v0,-20,-5,-37,-21,-38v-17,0,-21,18,-21,38xm208,-238r-141,238r-28,0r141,-238r28,0xm256,-59v0,-38,17,-63,55,-63v39,0,56,24,56,63v0,38,-17,63,-56,63v-38,-1,-55,-26,-55,-63xm290,-59v0,21,4,38,21,38v19,0,22,-17,22,-38v0,-20,-2,-39,-22,-38v-18,0,-20,18,-21,38xm131,-59v0,-38,17,-63,56,-63v38,1,56,23,55,63v0,39,-17,63,-55,63v-39,0,-56,-25,-56,-63xm187,-97v-29,0,-31,76,0,76v16,-1,21,-17,21,-38v0,-20,-4,-38,-21,-38","w":372},"\u0160":{"d":"183,-122v64,41,13,126,-66,126v-62,0,-101,-26,-105,-82r44,0v-2,53,104,63,111,11v-20,-63,-149,-11,-146,-112v2,-79,151,-81,177,-20v4,9,7,19,8,31r-44,0v-2,-24,-19,-37,-50,-37v-44,0,-66,46,-20,56v32,7,67,11,91,27xm167,-299r-35,47r-43,0r-34,-47r36,0r20,24r19,-24r37,0","w":226},"\u2039":{"d":"101,-12r-36,0r-51,-74r51,-74r36,0r-43,74","w":118},"\u0152":{"d":"117,-242v25,0,44,12,56,27r0,-23r143,0r0,39r-97,0r0,58r88,0r0,39r-88,0r0,63r102,0r0,39r-148,0r0,-22v-13,14,-30,26,-56,26v-72,0,-102,-51,-102,-123v0,-72,32,-123,102,-123xm62,-119v0,44,10,84,55,84v45,0,56,-38,56,-84v0,-46,-10,-84,-55,-84v-44,0,-56,39,-56,84","w":336},"\u017d":{"d":"196,0r-190,0r0,-38r132,-161r-120,0r0,-39r174,0r0,38r-132,161r136,0r0,39xm159,-299r-35,47r-43,0r-34,-47r36,0r20,24r19,-24r37,0","w":204},"\u2018":{"d":"65,-152r-45,0v-2,-45,-2,-90,43,-90r0,20v-16,0,-19,12,-20,29r22,0r0,41","w":84},"\u2019":{"d":"65,-239v1,44,2,90,-44,89r0,-20v16,0,20,-11,20,-29r-21,0r0,-40r45,0","w":84},"\u201c":{"d":"122,-152r-45,0v-1,-44,-3,-91,44,-90r0,20v-16,0,-20,11,-20,29r21,0r0,41xm60,-152r-44,0v-2,-45,-3,-91,43,-90r0,20v-16,0,-19,12,-20,29r21,0r0,41","w":137},"\u201d":{"d":"122,-239v1,44,3,91,-44,89r0,-20v16,0,21,-11,21,-29r-22,0r0,-40r45,0xm60,-239v1,43,3,90,-43,89r0,-20v17,0,19,-12,20,-29r-21,0r0,-40r44,0","w":137},"\u2022":{"d":"16,-116v0,-28,18,-46,46,-46v29,0,47,19,47,46v0,28,-19,46,-47,46v-27,0,-46,-18,-46,-46","w":125},"\u2219":{"d":"16,-116v0,-28,18,-46,46,-46v29,0,47,19,47,46v0,28,-19,46,-47,46v-27,0,-46,-18,-46,-46","w":125},"\u02dc":{"d":"40,-241v20,-1,49,31,54,0r26,0v-1,24,-12,41,-36,42v-22,1,-47,-31,-55,0r-25,0v1,-25,11,-42,36,-42","w":123},"\u2122":{"d":"223,-122r-24,0r0,-91r-21,91r-25,0r-22,-91r0,91r-24,0r0,-116r38,0r20,86r20,-86r38,0r0,116xm94,-215r-31,0r0,93r-26,0r0,-93r-31,0r0,-23r88,0r0,23","w":240},"\u0161":{"d":"145,-87v40,36,0,96,-58,91v-48,-4,-74,-16,-78,-56r42,0v0,20,14,30,36,29v25,4,45,-26,23,-38v-36,-19,-94,-10,-96,-63v-2,-56,87,-63,124,-39v12,8,18,21,19,37r-41,0v-1,-15,-11,-22,-31,-22v-30,0,-41,31,-10,37v23,5,55,11,70,24xm138,-243r-35,47r-43,0r-34,-47r36,0r20,24r19,-24r37,0","w":172},"\u203a":{"d":"105,-86r-51,74r-36,0r42,-73r-42,-75r36,0","w":118},"\u0153":{"d":"210,-175v65,-5,103,30,98,99r-125,0v1,30,13,51,43,51v19,0,35,-8,35,-27r44,0v-5,63,-112,74,-145,27v-16,20,-35,30,-71,28v-50,-4,-77,-35,-77,-89v0,-58,30,-89,86,-90v29,-1,49,12,62,29v12,-15,27,-26,50,-28xm263,-104v1,-38,-41,-57,-67,-33v-7,7,-11,18,-13,33r80,0xm57,-86v0,32,10,57,41,57v31,0,40,-25,40,-57v0,-32,-9,-57,-40,-57v-31,0,-41,25,-41,57","w":319},"\u017e":{"d":"167,0r-159,0r0,-33r97,-105r-91,0r0,-34r147,0r0,33r-97,105r103,0r0,34xm144,-243r-35,47r-43,0r-34,-47r36,0r20,24r19,-24r37,0","w":174},"\u0178":{"d":"221,-238r-88,140r0,98r-45,0r0,-98r-87,-140r51,0r59,102r59,-102r51,0xm160,-257r-35,0r0,-37r35,0r0,37xm96,-257r-35,0r0,-37r35,0r0,37","w":221},"\u00a1":{"d":"72,-130r-46,0r0,-42r46,0r0,42xm72,66r-46,0v-1,-60,4,-114,7,-170r33,0","w":98},"\u00a2":{"d":"97,-30v20,3,39,-7,41,-26r41,0v-6,42,-40,65,-91,59r-11,39r-19,-5r11,-39v-33,-12,-50,-39,-50,-84v1,-60,35,-95,98,-89r11,-39r19,5r-11,38v24,10,40,26,43,55r-41,0v0,-10,-5,-17,-11,-21xm108,-143v-54,-7,-56,81,-29,105","w":196},"\u00a3":{"d":"60,-40v41,-10,88,19,124,-3r0,39v-53,24,-123,-25,-175,8r0,-36v26,-10,40,-38,32,-75r-32,0r0,-24r25,0v-41,-79,55,-147,126,-93v14,11,22,27,22,51r-42,0v-2,-21,-12,-34,-35,-34v-40,0,-38,47,-26,76r47,0r0,24r-41,0v7,31,-6,54,-25,67","w":196},"\u00a4":{"d":"138,-58v-20,16,-62,16,-80,-1r-23,24r-20,-20r24,-23v-15,-19,-16,-60,0,-79r-24,-23r20,-20v10,12,16,14,23,24v19,-17,62,-17,80,0r23,-24r21,20r-24,23v16,23,13,58,0,79r24,23r-21,20xm56,-118v0,25,17,43,42,43v25,0,42,-17,42,-43v0,-26,-17,-42,-42,-42v-25,0,-42,17,-42,42","w":196},"\u00a5":{"d":"196,-238r-60,109r48,0r0,23r-64,0r0,29r64,0r0,23r-64,0r0,54r-44,0r0,-54r-63,0r0,-23r63,0r0,-29r-63,0r0,-23r48,0r-61,-109r48,0r50,99r50,-99r48,0","w":196},"\u00a6":{"d":"64,70r-37,0r0,-126r37,0r0,126xm64,-114r-37,0r0,-125r37,0r0,125","w":91},"\u00a7":{"d":"50,-147v-43,-30,-15,-100,46,-95v42,3,68,19,73,57r-42,0v3,-34,-55,-40,-56,-8v19,54,110,43,110,115v0,24,-15,38,-35,47v47,30,18,101,-47,101v-45,0,-71,-21,-77,-60r43,0v-4,37,61,44,63,8v-22,-53,-113,-45,-113,-118v0,-24,16,-38,35,-47xm71,-133v-19,10,-20,47,2,55v14,12,36,22,51,32v44,-37,-25,-69,-53,-87","w":196},"\u00a8":{"d":"111,-201r-35,0r0,-37r35,0r0,37xm47,-201r-35,0r0,-37r35,0r0,37","w":123},"\u00a9":{"d":"4,-120v0,-75,48,-122,123,-122v74,0,122,48,122,122v0,75,-47,123,-122,123v-75,0,-123,-48,-123,-123xm26,-120v0,61,39,102,100,102v61,0,101,-41,101,-102v0,-60,-38,-100,-101,-100v-62,0,-100,40,-100,100xm127,-165v-47,0,-48,92,0,92v17,0,27,-9,30,-24r28,0v-7,32,-26,48,-58,48v-43,-1,-61,-28,-65,-70v-7,-75,110,-96,123,-24r-29,0v-3,-14,-12,-22,-29,-22","w":252},"\u00aa":{"d":"48,-158v0,19,30,15,38,7r0,-22v-18,0,-38,-2,-38,15xm85,-209v-2,-17,-40,-16,-37,3r-29,0v2,-25,23,-36,51,-36v65,0,48,64,50,120r-34,0r0,-9v-22,19,-77,14,-74,-24v2,-33,34,-41,74,-39","w":137},"\u00ab":{"d":"181,-12r-36,0r-51,-74r51,-74r36,0r-42,74xm106,-12r-36,0r-51,-74r51,-74r36,0r-42,74","w":200},"\u00ac":{"d":"176,-65r-34,0r0,-67r-125,0r0,-35r159,0r0,102"},"\u00ad":{"d":"105,-71r-93,0r0,-34r93,0r0,34","w":116},"\u00ae":{"d":"4,-120v0,-75,48,-122,123,-122v74,0,122,48,122,122v0,75,-47,123,-122,123v-75,0,-123,-48,-123,-123xm26,-120v0,61,39,102,100,102v61,0,101,-41,101,-102v0,-60,-38,-100,-101,-100v-62,0,-100,40,-100,100xm178,-147v0,22,-12,34,-31,37v24,7,27,37,38,58r-30,0v-10,-25,-13,-57,-54,-50r0,50r-28,0r0,-132v46,2,106,-11,105,37xm150,-144v0,-21,-27,-18,-49,-18r0,37v22,0,49,2,49,-19","w":252},"\u00af":{"d":"115,-206r-106,0r0,-28r106,0r0,28","w":123},"\u00b0":{"d":"18,-196v0,-28,18,-47,47,-47v30,0,48,19,48,47v0,29,-19,48,-48,48v-28,0,-47,-19,-47,-48xm65,-223v-30,-2,-36,43,-10,52v18,7,39,-4,38,-25v-1,-18,-11,-26,-28,-27","w":130},"\u00b1":{"d":"177,0r-160,0r0,-36r160,0r0,36xm177,-107r-62,0r0,63r-36,0r0,-63r-62,0r0,-35r62,0r0,-62r36,0r0,62r62,0r0,35"},"\u00b2":{"d":"105,-205v0,37,-38,42,-56,63r57,0r0,23r-101,0v4,-46,61,-45,71,-84v0,-22,-39,-21,-40,0r-27,0v4,-25,20,-38,49,-38v27,0,47,10,47,36","w":113},"\u00b3":{"d":"56,-241v41,-5,62,46,25,58v17,4,26,14,26,29v0,51,-101,51,-101,1r29,0v1,11,8,15,21,15v13,0,20,-5,21,-16v2,-17,-13,-17,-30,-17r0,-21v25,6,36,-27,8,-27v-11,0,-17,4,-18,13r-28,0v4,-23,21,-32,47,-35","w":113},"\u00b4":{"d":"108,-243r-40,47r-31,0r20,-47r51,0","w":123},"\u00b5":{"d":"66,-60v-3,43,56,32,66,7r0,-119r44,0r0,123v0,13,4,21,18,19r0,32v-25,6,-54,-3,-59,-25v-17,22,-40,32,-69,22r0,67r-45,0r0,-238r45,0r0,112","w":197},"\u03bc":{"d":"66,-60v-3,43,56,32,66,7r0,-119r44,0r0,123v0,13,4,21,18,19r0,32v-25,6,-54,-3,-59,-25v-17,22,-40,32,-69,22r0,67r-45,0r0,-238r45,0r0,112","w":197},"\u00b6":{"d":"3,-165v-3,-91,107,-71,194,-73r0,28r-26,0r0,276r-31,0r0,-276r-35,0r0,276r-30,0r0,-160v-44,-3,-70,-26,-72,-71","w":200},"\u00b7":{"d":"72,-94r-46,0r0,-45r46,0r0,45","w":98},"\u00b8":{"d":"65,37v-1,-10,-11,-12,-24,-11r2,-27r25,0r0,10v15,2,27,11,27,28v0,28,-33,37,-68,32r0,-22v12,3,39,6,38,-10","w":123},"\u00b9":{"d":"13,-213v25,1,37,-8,40,-28r21,0r0,122r-27,0r0,-79v-8,5,-20,8,-34,8r0,-23","w":103},"\u00ba":{"d":"11,-181v1,-38,20,-61,58,-61v38,0,57,23,58,61v0,39,-20,61,-58,61v-38,0,-58,-22,-58,-61xm45,-181v0,19,6,36,24,36v18,0,24,-17,24,-36v0,-19,-6,-36,-24,-36v-18,0,-24,17,-24,36","w":137},"\u00bb":{"d":"182,-86r-52,74r-36,0r43,-73r-43,-75r36,0xm107,-86r-51,74r-36,0r42,-73r-42,-75r36,0","w":200},"\u00bc":{"d":"23,-213v25,1,37,-8,40,-28r21,0r0,122r-27,0r0,-79v-8,5,-20,8,-34,8r0,-23xm242,-238r-169,238r-29,0r169,-238r29,0xm259,-26r-16,0r0,25r-27,0r0,-25r-60,0r0,-21r60,-75r27,0r0,74r16,0r0,22xm216,-48r0,-43r-34,43r34,0","w":277},"\u00bd":{"d":"23,-213v25,1,37,-8,40,-28r21,0r0,122r-27,0r0,-79v-8,5,-20,8,-34,8r0,-23xm236,-238r-169,238r-29,0r169,-238r29,0xm260,-87v0,37,-38,42,-56,63r57,0r0,23r-101,0v4,-46,61,-45,71,-84v0,-22,-39,-21,-40,0r-27,0v4,-25,20,-38,49,-38v27,0,47,10,47,36","w":277},"\u00be":{"d":"56,-241v41,-5,62,46,25,58v17,4,26,14,26,29v0,51,-101,51,-101,1r29,0v1,11,8,15,21,15v13,0,20,-5,21,-16v2,-17,-13,-17,-30,-17r0,-21v25,6,36,-27,8,-27v-11,0,-17,4,-18,13r-28,0v4,-23,21,-32,47,-35xm241,-238r-169,238r-29,0r169,-238r29,0xm259,-26r-16,0r0,25r-27,0r0,-25r-60,0r0,-21r60,-75r27,0r0,74r16,0r0,22xm216,-48r0,-43r-34,43r34,0","w":277},"\u00bf":{"d":"97,35v26,0,35,-16,39,-39r42,0v5,91,-159,100,-163,11v-3,-59,58,-57,60,-111r42,0v5,59,-52,57,-57,104v-2,23,13,35,37,35xm119,-130r-47,0r0,-42r47,0r0,42","w":192},"\u00c0":{"d":"144,-97r-34,-101r-33,101r67,0xm224,0r-48,0r-21,-61r-89,0r-21,61r-45,0r85,-238r50,0xm132,-252r-31,0r-40,-47r50,0","w":223},"\u00c1":{"d":"144,-97r-34,-101r-33,101r67,0xm224,0r-48,0r-21,-61r-89,0r-21,61r-45,0r85,-238r50,0xm159,-299r-40,47r-31,0r20,-47r51,0","w":223},"\u00c2":{"d":"144,-97r-34,-101r-33,101r67,0xm224,0r-48,0r-21,-61r-89,0r-21,61r-45,0r85,-238r50,0xm166,-252r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":223},"\u00c3":{"d":"144,-97r-34,-101r-33,101r67,0xm224,0r-48,0r-21,-61r-89,0r-21,61r-45,0r85,-238r50,0xm89,-297v20,-1,49,31,54,0r26,0v-1,24,-12,41,-36,42v-22,1,-47,-31,-55,0r-25,0v1,-25,11,-42,36,-42","w":223},"\u00c4":{"d":"144,-97r-34,-101r-33,101r67,0xm224,0r-48,0r-21,-61r-89,0r-21,61r-45,0r85,-238r50,0xm159,-257r-35,0r0,-37r35,0r0,37xm95,-257r-35,0r0,-37r35,0r0,37","w":223},"\u00c5":{"d":"144,-97r-34,-101r-33,101r67,0xm224,0r-48,0r-21,-61r-89,0r-21,61r-45,0r85,-238r50,0xm73,-257v0,-24,14,-38,38,-38v23,0,37,14,37,38v0,23,-13,37,-37,37v-25,0,-38,-14,-38,-37xm129,-257v0,-11,-7,-20,-18,-20v-12,1,-18,9,-19,20v1,10,8,19,19,19v11,0,18,-8,18,-19","w":223},"\u00c6":{"d":"314,0r-162,0r0,-58r-75,0r-30,58r-48,0r127,-238r183,0r0,39r-112,0r0,58r103,0r0,39r-103,0r0,63r117,0r0,39xm152,-97r0,-103v-23,31,-38,68,-57,103r57,0","w":330},"\u00c7":{"d":"227,-81v-7,54,-40,85,-100,85v-75,0,-105,-49,-112,-123v-12,-117,146,-165,203,-76v6,9,9,22,10,35r-46,0v-5,-28,-23,-43,-55,-43v-47,0,-65,36,-65,84v0,47,17,83,65,84v33,1,52,-17,55,-46r45,0xm130,37v-1,-10,-11,-12,-24,-11r2,-27r25,0r0,10v15,2,27,11,27,28v0,28,-33,37,-68,32r0,-22v12,3,39,6,38,-10","w":243},"\u00c8":{"d":"206,0r-181,0r0,-238r176,0r0,39r-131,0r0,58r122,0r0,39r-122,0r0,63r136,0r0,39xm136,-252r-31,0r-40,-47r50,0","w":221},"\u00c9":{"d":"206,0r-181,0r0,-238r176,0r0,39r-131,0r0,58r122,0r0,39r-122,0r0,63r136,0r0,39xm161,-299r-40,47r-31,0r20,-47r51,0","w":221},"\u00ca":{"d":"206,0r-181,0r0,-238r176,0r0,39r-131,0r0,58r122,0r0,39r-122,0r0,63r136,0r0,39xm170,-252r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":221},"\u00cb":{"d":"206,0r-181,0r0,-238r176,0r0,39r-131,0r0,58r122,0r0,39r-122,0r0,63r136,0r0,39xm164,-257r-35,0r0,-37r35,0r0,37xm100,-257r-35,0r0,-37r35,0r0,37","w":221},"\u00cc":{"d":"73,0r-46,0r0,-238r46,0r0,238xm72,-252r-31,0r-40,-47r50,0","w":99},"\u00cd":{"d":"73,0r-46,0r0,-238r46,0r0,238xm100,-299r-40,47r-31,0r20,-47r51,0","w":99},"\u00ce":{"d":"73,0r-46,0r0,-238r46,0r0,238xm107,-252r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":99},"\u00cf":{"d":"73,0r-46,0r0,-238r46,0r0,238xm100,-257r-35,0r0,-37r35,0r0,37xm36,-257r-35,0r0,-37r35,0r0,37","w":99},"\u00d0":{"d":"103,-238v81,0,124,37,124,118v0,80,-41,120,-124,120r-78,0r0,-101r-25,0r0,-36r25,0r0,-101r78,0xm180,-120v0,-66,-38,-85,-109,-79r0,62r53,0r0,36r-53,0r0,62v71,6,109,-13,109,-81","w":243},"\u00d1":{"d":"218,0r-46,0r-106,-171r2,171r-43,0r0,-238r46,0r106,172r-1,-172r42,0r0,238xm102,-297v20,-1,49,31,54,0r26,0v-1,24,-12,41,-36,42v-22,1,-47,-31,-55,0r-25,0v1,-25,11,-42,36,-42","w":243},"\u00d2":{"d":"15,-119v0,-76,40,-123,115,-123v73,0,113,48,113,123v0,74,-39,123,-113,123v-75,0,-115,-48,-115,-123xm62,-119v0,47,20,84,67,84v48,0,68,-36,68,-84v0,-47,-19,-84,-67,-84v-48,0,-68,36,-68,84xm153,-252r-31,0r-40,-47r50,0","w":258},"\u00d3":{"d":"15,-119v0,-76,40,-123,115,-123v73,0,113,48,113,123v0,74,-39,123,-113,123v-75,0,-115,-48,-115,-123xm62,-119v0,47,20,84,67,84v48,0,68,-36,68,-84v0,-47,-19,-84,-67,-84v-48,0,-68,36,-68,84xm179,-299r-40,47r-31,0r20,-47r51,0","w":258},"\u00d4":{"d":"15,-119v0,-76,40,-123,115,-123v73,0,113,48,113,123v0,74,-39,123,-113,123v-75,0,-115,-48,-115,-123xm62,-119v0,47,20,84,67,84v48,0,68,-36,68,-84v0,-47,-19,-84,-67,-84v-48,0,-68,36,-68,84xm186,-252r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":258},"\u00d5":{"d":"15,-119v0,-76,40,-123,115,-123v73,0,113,48,113,123v0,74,-39,123,-113,123v-75,0,-115,-48,-115,-123xm62,-119v0,47,20,84,67,84v48,0,68,-36,68,-84v0,-47,-19,-84,-67,-84v-48,0,-68,36,-68,84xm108,-297v20,-1,49,31,54,0r26,0v-1,24,-12,41,-36,42v-22,1,-47,-31,-55,0r-25,0v1,-25,11,-42,36,-42","w":258},"\u00d6":{"d":"15,-119v0,-76,40,-123,115,-123v73,0,113,48,113,123v0,74,-39,123,-113,123v-75,0,-115,-48,-115,-123xm62,-119v0,47,20,84,67,84v48,0,68,-36,68,-84v0,-47,-19,-84,-67,-84v-48,0,-68,36,-68,84xm179,-257r-35,0r0,-37r35,0r0,37xm115,-257r-35,0r0,-37r35,0r0,37","w":258},"\u00d8":{"d":"15,-119v0,-103,106,-155,184,-101r24,-28r22,17r-26,30v52,76,18,205,-89,205v-27,0,-50,-7,-69,-21r-25,28r-21,-18r26,-30v-17,-22,-26,-49,-26,-82xm172,-189v-65,-49,-140,34,-101,116xm129,-35v64,3,80,-74,59,-129r-101,115v10,10,23,14,42,14","w":258},"\u00d9":{"d":"218,-100v2,68,-27,104,-96,104v-69,0,-97,-34,-97,-104r0,-138r45,0r0,137v0,41,11,65,52,65v41,0,52,-23,51,-65r0,-137r45,0r0,138xm143,-252r-31,0r-40,-47r50,0","w":243},"\u00da":{"d":"218,-100v2,68,-27,104,-96,104v-69,0,-97,-34,-97,-104r0,-138r45,0r0,137v0,41,11,65,52,65v41,0,52,-23,51,-65r0,-137r45,0r0,138xm171,-299r-40,47r-31,0r20,-47r51,0","w":243},"\u00db":{"d":"218,-100v2,68,-27,104,-96,104v-69,0,-97,-34,-97,-104r0,-138r45,0r0,137v0,41,11,65,52,65v41,0,52,-23,51,-65r0,-137r45,0r0,138xm178,-252r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":243},"\u00dc":{"d":"218,-100v2,68,-27,104,-96,104v-69,0,-97,-34,-97,-104r0,-138r45,0r0,137v0,41,11,65,52,65v41,0,52,-23,51,-65r0,-137r45,0r0,138xm171,-257r-35,0r0,-37r35,0r0,37xm107,-257r-35,0r0,-37r35,0r0,37","w":243},"\u00dd":{"d":"221,-238r-88,140r0,98r-45,0r0,-98r-87,-140r51,0r59,102r59,-102r51,0xm160,-299r-40,47r-31,0r20,-47r51,0","w":221},"\u00de":{"d":"208,-123v0,72,-62,82,-138,78r0,45r-45,0r0,-238r45,0r0,44v74,-4,138,1,138,71xm161,-121v0,-44,-49,-35,-91,-36r0,74v43,-1,91,8,91,-38","w":221},"\u00df":{"d":"99,-211v-27,0,-33,21,-33,48r0,163r-45,0r0,-162v0,-55,26,-78,79,-81v57,-3,88,46,55,92v-34,48,48,45,48,99v0,63,-101,76,-119,23r26,-12v5,21,51,26,49,-3v-2,-39,-56,-33,-55,-77v0,-28,23,-39,24,-65v0,-17,-13,-24,-29,-25","w":213},"\u00e0":{"d":"57,-49v0,37,63,25,73,4r0,-34v-36,0,-73,-1,-73,30xm97,-176v48,0,77,14,77,65r0,111r-44,0r0,-16v-31,31,-118,29,-118,-30v0,-44,48,-63,118,-60v2,-30,-8,-42,-35,-42v-22,0,-34,7,-36,25r-40,0v2,-35,28,-53,78,-53xm119,-196r-31,0r-40,-47r50,0"},"\u00e1":{"d":"57,-49v0,37,63,25,73,4r0,-34v-36,0,-73,-1,-73,30xm97,-176v48,0,77,14,77,65r0,111r-44,0r0,-16v-31,31,-118,29,-118,-30v0,-44,48,-63,118,-60v2,-30,-8,-42,-35,-42v-22,0,-34,7,-36,25r-40,0v2,-35,28,-53,78,-53xm146,-243r-40,47r-31,0r20,-47r51,0"},"\u00e2":{"d":"57,-49v0,37,63,25,73,4r0,-34v-36,0,-73,-1,-73,30xm97,-176v48,0,77,14,77,65r0,111r-44,0r0,-16v-31,31,-118,29,-118,-30v0,-44,48,-63,118,-60v2,-30,-8,-42,-35,-42v-22,0,-34,7,-36,25r-40,0v2,-35,28,-53,78,-53xm155,-196r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0"},"\u00e3":{"d":"57,-49v0,37,63,25,73,4r0,-34v-36,0,-73,-1,-73,30xm97,-176v48,0,77,14,77,65r0,111r-44,0r0,-16v-31,31,-118,29,-118,-30v0,-44,48,-63,118,-60v2,-30,-8,-42,-35,-42v-22,0,-34,7,-36,25r-40,0v2,-35,28,-53,78,-53xm77,-241v20,-1,49,31,54,0r26,0v-1,24,-12,41,-36,42v-22,1,-47,-31,-55,0r-25,0v1,-25,11,-42,36,-42"},"\u00e4":{"d":"57,-49v0,37,63,25,73,4r0,-34v-36,0,-73,-1,-73,30xm97,-176v48,0,77,14,77,65r0,111r-44,0r0,-16v-31,31,-118,29,-118,-30v0,-44,48,-63,118,-60v2,-30,-8,-42,-35,-42v-22,0,-34,7,-36,25r-40,0v2,-35,28,-53,78,-53xm147,-201r-35,0r0,-37r35,0r0,37xm83,-201r-35,0r0,-37r35,0r0,37"},"\u00e5":{"d":"57,-49v0,37,63,25,73,4r0,-34v-36,0,-73,-1,-73,30xm97,-176v48,0,77,14,77,65r0,111r-44,0r0,-16v-31,31,-118,29,-118,-30v0,-44,48,-63,118,-60v2,-30,-8,-42,-35,-42v-22,0,-34,7,-36,25r-40,0v2,-35,28,-53,78,-53xm61,-228v0,-24,14,-38,38,-38v23,0,37,14,37,38v0,23,-13,37,-37,37v-25,0,-38,-14,-38,-37xm117,-228v0,-11,-7,-20,-18,-20v-12,1,-18,9,-19,20v1,10,8,19,19,19v11,0,18,-8,18,-19"},"\u00e6":{"d":"86,-25v31,0,44,-20,41,-54v-34,0,-70,-1,-70,30v0,16,12,24,29,24xm291,-52v-5,64,-115,73,-147,26v-22,39,-132,47,-132,-20v0,-44,46,-63,115,-60v1,-27,-4,-42,-33,-42v-20,0,-34,7,-34,25r-41,0v-8,-57,104,-68,137,-35v57,-42,153,-7,138,82r-122,0v1,29,12,51,41,51v18,0,33,-8,34,-27r44,0xm249,-104v-4,-27,-12,-43,-39,-44v-22,0,-35,14,-38,44r77,0","w":305},"\u00e7":{"d":"172,-56v-6,37,-31,60,-74,60v-56,0,-83,-34,-86,-90v-5,-77,78,-114,137,-75v13,9,21,25,23,45r-42,0v-1,-16,-14,-28,-32,-27v-31,1,-41,24,-41,57v0,32,10,57,41,57v18,0,31,-10,32,-27r42,0xm97,37v-1,-10,-11,-12,-24,-11r2,-27r25,0r0,10v15,2,27,11,27,28v0,28,-33,37,-68,32r0,-22v12,3,39,6,38,-10","w":177},"\u00e8":{"d":"179,-52v-7,37,-36,56,-79,56v-58,0,-87,-33,-88,-90v0,-58,29,-90,86,-90v59,0,87,37,85,100r-126,0v-8,52,69,70,81,24r41,0xm138,-104v1,-38,-41,-57,-67,-33v-7,7,-11,18,-13,33r80,0xm121,-196r-31,0r-40,-47r50,0"},"\u00e9":{"d":"179,-52v-7,37,-36,56,-79,56v-58,0,-87,-33,-88,-90v0,-58,29,-90,86,-90v59,0,87,37,85,100r-126,0v-8,52,69,70,81,24r41,0xm138,-104v1,-38,-41,-57,-67,-33v-7,7,-11,18,-13,33r80,0xm147,-243r-40,47r-31,0r20,-47r51,0"},"\u00ea":{"d":"179,-52v-7,37,-36,56,-79,56v-58,0,-87,-33,-88,-90v0,-58,29,-90,86,-90v59,0,87,37,85,100r-126,0v-8,52,69,70,81,24r41,0xm138,-104v1,-38,-41,-57,-67,-33v-7,7,-11,18,-13,33r80,0xm154,-196r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0"},"\u00eb":{"d":"179,-52v-7,37,-36,56,-79,56v-58,0,-87,-33,-88,-90v0,-58,29,-90,86,-90v59,0,87,37,85,100r-126,0v-8,52,69,70,81,24r41,0xm138,-104v1,-38,-41,-57,-67,-33v-7,7,-11,18,-13,33r80,0xm147,-201r-35,0r0,-37r35,0r0,37xm83,-201r-35,0r0,-37r35,0r0,37"},"\u00ec":{"d":"66,0r-45,0r0,-172r45,0r0,172xm66,-196r-31,0r-40,-47r50,0","w":87},"\u00ed":{"d":"66,0r-45,0r0,-172r45,0r0,172xm93,-243r-40,47r-31,0r20,-47r51,0","w":87},"\u00ee":{"d":"66,0r-45,0r0,-172r45,0r0,172xm100,-196r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":87},"\u00ef":{"d":"66,0r-45,0r0,-172r45,0r0,172xm93,-201r-35,0r0,-37r35,0r0,37xm29,-201r-35,0r0,-37r35,0r0,37","w":87},"\u00f0":{"d":"101,-239r16,13r33,-16r9,20r-26,12v27,32,51,65,50,123v-1,57,-29,91,-85,91v-56,0,-85,-32,-86,-88v-2,-62,45,-99,107,-84v-4,-10,-12,-20,-18,-27r-37,17r-10,-19r32,-15v-9,-11,-22,-19,-34,-27r49,0xm57,-84v0,31,10,55,41,55v28,0,40,-23,40,-55v0,-32,-12,-55,-40,-55v-31,0,-41,24,-41,55"},"\u00f1":{"d":"132,-109v4,-45,-47,-39,-66,-10r0,119r-45,0r0,-172r44,0r0,22v35,-44,112,-32,112,38r0,112r-45,0r0,-109xm77,-241v20,-1,49,31,54,0r26,0v-1,24,-12,41,-36,42v-22,1,-47,-31,-55,0r-25,0v1,-25,11,-42,36,-42","w":197},"\u00f2":{"d":"12,-86v0,-58,30,-90,86,-90v56,0,85,33,85,90v0,57,-29,90,-85,90v-56,0,-86,-32,-86,-90xm57,-86v0,32,10,57,41,57v31,0,40,-25,40,-57v0,-32,-9,-57,-40,-57v-31,0,-41,25,-41,57xm120,-196r-31,0r-40,-47r50,0"},"\u00f3":{"d":"12,-86v0,-58,30,-90,86,-90v56,0,85,33,85,90v0,57,-29,90,-85,90v-56,0,-86,-32,-86,-90xm57,-86v0,32,10,57,41,57v31,0,40,-25,40,-57v0,-32,-9,-57,-40,-57v-31,0,-41,25,-41,57xm147,-243r-40,47r-31,0r20,-47r51,0"},"\u00f4":{"d":"12,-86v0,-58,30,-90,86,-90v56,0,85,33,85,90v0,57,-29,90,-85,90v-56,0,-86,-32,-86,-90xm57,-86v0,32,10,57,41,57v31,0,40,-25,40,-57v0,-32,-9,-57,-40,-57v-31,0,-41,25,-41,57xm154,-196r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0"},"\u00f5":{"d":"12,-86v0,-58,30,-90,86,-90v56,0,85,33,85,90v0,57,-29,90,-85,90v-56,0,-86,-32,-86,-90xm57,-86v0,32,10,57,41,57v31,0,40,-25,40,-57v0,-32,-9,-57,-40,-57v-31,0,-41,25,-41,57xm77,-241v20,-1,49,31,54,0r26,0v-1,24,-12,41,-36,42v-22,1,-47,-31,-55,0r-25,0v1,-25,11,-42,36,-42"},"\u00f6":{"d":"12,-86v0,-58,30,-90,86,-90v56,0,85,33,85,90v0,57,-29,90,-85,90v-56,0,-86,-32,-86,-90xm57,-86v0,32,10,57,41,57v31,0,40,-25,40,-57v0,-32,-9,-57,-40,-57v-31,0,-41,25,-41,57xm147,-201r-35,0r0,-37r35,0r0,37xm83,-201r-35,0r0,-37r35,0r0,37"},"\u00f8":{"d":"12,-86v0,-76,70,-109,133,-79r15,-19r20,15r-16,21v40,55,15,159,-66,152v-19,-2,-34,-4,-47,-11r-15,20r-20,-16r16,-19v-13,-16,-20,-37,-20,-64xm123,-137v-43,-31,-85,24,-64,81xm73,-34v44,28,84,-28,63,-80"},"\u00f9":{"d":"65,-63v-4,45,48,39,66,10r0,-119r45,0r0,172r-43,0r0,-22v-30,42,-112,34,-112,-38r0,-112r44,0r0,109xm121,-196r-31,0r-40,-47r50,0","w":197},"\u00fa":{"d":"65,-63v-4,45,48,39,66,10r0,-119r45,0r0,172r-43,0r0,-22v-30,42,-112,34,-112,-38r0,-112r44,0r0,109xm148,-243r-40,47r-31,0r20,-47r51,0","w":197},"\u00fb":{"d":"65,-63v-4,45,48,39,66,10r0,-119r45,0r0,172r-43,0r0,-22v-30,42,-112,34,-112,-38r0,-112r44,0r0,109xm155,-196r-37,0r-19,-24r-20,24r-36,0r34,-47r43,0","w":197},"\u00fc":{"d":"65,-63v-4,45,48,39,66,10r0,-119r45,0r0,172r-43,0r0,-22v-30,42,-112,34,-112,-38r0,-112r44,0r0,109xm148,-201r-35,0r0,-37r35,0r0,37xm84,-201r-35,0r0,-37r35,0r0,37","w":197},"\u00fd":{"d":"109,0v-12,43,-37,84,-93,66r0,-36v28,10,44,-6,50,-30r-63,-172r46,0r38,128r39,-128r46,0xm136,-243r-40,47r-31,0r20,-47r51,0","w":174},"\u00fe":{"d":"112,4v-22,0,-35,-6,-47,-17r1,79r-45,0r0,-304r45,0r-1,86v12,-14,28,-24,51,-24v50,1,69,39,69,89v0,51,-21,90,-73,91xm105,-143v-20,0,-29,11,-39,25r0,74v31,31,78,12,73,-43v-3,-32,-8,-56,-34,-56","w":196},"\u00ff":{"d":"109,0v-12,43,-37,84,-93,66r0,-36v28,10,44,-6,50,-30r-63,-172r46,0r38,128r39,-128r46,0xm137,-201r-35,0r0,-37r35,0r0,37xm73,-201r-35,0r0,-37r35,0r0,37","w":174},"\u0964":{"d":"106,18r-41,0r0,-195r41,0r0,195","w":131},"\u0965":{"d":"173,18r-41,0r0,-195r41,0r0,195xm107,18r-40,0r0,-195r40,0r0,195","w":196},"\u0951":{"d":"-44,-243r-27,0r0,-90r27,0r0,90","w":0},"\u0952":{"d":"5,73r-169,0r0,-25r169,0r0,25","w":0},"\u20a8":{"d":"217,-170v0,37,-21,55,-51,62v40,15,45,70,63,108r-49,0v-18,-36,-15,-92,-66,-94r-44,0r0,94r-45,0r0,-238v85,3,192,-21,192,68xm171,-167v0,-47,-57,-33,-101,-35r0,71v44,-2,101,12,101,-36xm384,-87v40,36,0,96,-58,91v-48,-4,-74,-16,-78,-56r42,0v0,20,14,30,36,29v25,4,45,-26,23,-38v-36,-19,-94,-10,-96,-63v-2,-56,87,-63,124,-39v12,8,18,21,19,37r-41,0v-1,-15,-11,-22,-31,-22v-30,0,-41,31,-10,37v23,5,55,11,70,24","w":411},"!":{"d":"72,0r-46,0r0,-42r46,0r0,42xm72,-238v1,60,-4,114,-6,170r-33,0r-7,-170r46,0","w":98},"\"":{"d":"124,-238r-8,91r-28,0r-9,-91r45,0xm58,-238r-9,91r-27,0r-9,-91r45,0","w":137},"#":{"d":"190,-146r-35,0r-11,55r33,0r0,27r-39,0r-13,64r-28,0r13,-64r-46,0r-13,64r-28,0r13,-64r-30,0r0,-27r35,0r12,-55r-33,0r0,-27r38,0r13,-65r28,0r-13,65r46,0r14,-65r27,0r-13,65r30,0r0,27xm127,-146r-46,0r-11,55r46,0","w":196},"%":{"d":"17,-179v0,-41,21,-63,58,-63v37,0,58,24,58,63v0,39,-19,63,-58,63v-39,0,-58,-22,-58,-63xm50,-179v0,22,6,39,25,39v19,-1,24,-17,24,-39v0,-20,-6,-38,-24,-38v-19,0,-25,17,-25,38xm234,-238r-143,238r-28,0r144,-238r27,0xm165,-59v0,-39,19,-63,58,-63v39,0,58,24,58,63v0,39,-19,63,-58,63v-39,0,-58,-24,-58,-63xm199,-59v0,22,6,38,24,38v18,0,24,-17,24,-38v0,-20,-5,-38,-24,-38v-19,0,-24,18,-24,38","w":297},"&":{"d":"210,-113v-2,25,-7,47,-18,64r23,27r-30,27r-20,-23v-45,39,-157,27,-152,-49v2,-38,27,-52,52,-69v-38,-36,-20,-110,44,-106v36,3,62,19,62,54v0,34,-24,47,-47,61r40,48v3,-10,5,-22,6,-34r40,0xm108,-212v-33,-1,-26,50,-3,57v25,-6,37,-53,3,-57xm87,-108v-44,13,-32,90,22,77v13,-3,22,-7,31,-15","w":230},"'":{"d":"58,-238r-8,91r-28,0r-8,-91r44,0","w":72},"(":{"d":"64,-86v0,62,22,111,49,156r-37,0v-32,-43,-56,-91,-56,-156v0,-65,24,-113,56,-156r37,0v-27,45,-49,93,-49,156","w":123},")":{"d":"58,-86v0,-63,-21,-112,-48,-156r37,0v33,43,56,89,56,156v0,65,-24,113,-56,156r-37,0v27,-45,48,-93,48,-156","w":123},"*":{"d":"125,-189r-40,9r28,32r-24,17r-21,-37r-21,37r-24,-17r28,-32r-41,-9r9,-28r38,17r-3,-42r28,0r-4,42r38,-17","w":135},"+":{"d":"177,-100r-62,0r0,63r-36,0r0,-63r-62,0r0,-35r62,0r0,-62r36,0r0,62r62,0r0,35"},",":{"d":"72,-45v0,46,6,99,-45,98r0,-22v18,0,20,-12,21,-31r-22,0r0,-45r46,0","w":98},"-":{"d":"105,-71r-93,0r0,-34r93,0r0,34","w":116},"\u2010":{"d":"105,-71r-93,0r0,-34r93,0r0,34","w":116},".":{"d":"72,0r-46,0r0,-45r46,0r0,45","w":98},"\/":{"d":"105,-238r-69,238r-36,0r69,-238r36,0","w":104},"0":{"d":"14,-119v0,-73,20,-123,84,-123v65,0,84,51,84,123v0,73,-19,123,-84,123v-64,0,-84,-49,-84,-123xm98,-207v-56,0,-43,109,-30,156v4,13,15,19,30,21v38,-4,39,-46,39,-89v0,-43,0,-88,-39,-88","w":196},"1":{"d":"37,-199v39,0,61,-11,67,-43r35,0r0,242r-45,0r0,-178v-15,9,-32,14,-57,14r0,-35","w":196},"2":{"d":"99,-242v70,-5,102,71,61,120v-24,29,-66,51,-86,83r107,0r0,39r-172,0v6,-88,107,-90,124,-166v6,-25,-11,-41,-36,-41v-25,0,-35,17,-39,39r-42,0v4,-47,33,-71,83,-74","w":196},"3":{"d":"173,-178v0,27,-15,41,-34,49v26,7,43,26,45,58v6,85,-133,99,-164,35v-4,-9,-7,-20,-8,-31r44,0v2,23,16,37,41,37v26,0,41,-16,42,-42v1,-31,-24,-39,-58,-37r0,-33v29,1,46,-6,46,-34v0,-21,-12,-31,-32,-31v-21,0,-33,11,-36,34r-42,0v5,-44,33,-69,79,-69v44,0,77,20,77,64","w":196},"4":{"d":"183,-54r-31,0r0,54r-43,0r0,-54r-103,0r0,-34r104,-153r42,0r0,152r31,0r0,35xm109,-89r1,-96r-65,96r64,0","w":196},"5":{"d":"139,-78v4,-48,-59,-56,-83,-29r-34,0r11,-131r138,0r0,37r-102,0r-4,55v51,-32,119,1,119,65v0,91,-127,113,-164,45v-5,-9,-7,-19,-8,-31r43,0v3,22,17,37,41,37v28,0,41,-20,43,-48","w":196},"6":{"d":"133,-181v-1,-32,-48,-34,-61,-8v-6,12,-12,30,-13,55v45,-46,129,-15,125,56v-3,52,-31,82,-83,82v-65,0,-83,-48,-87,-116v-6,-97,61,-162,139,-114v14,8,21,25,24,45r-44,0xm139,-77v4,-50,-58,-56,-81,-25v2,40,10,72,43,72v26,0,36,-22,38,-47","w":196},"7":{"d":"181,-207r-86,207r-46,0r88,-201r-121,0r0,-37r165,0r0,31","w":196},"8":{"d":"174,-181v0,30,-18,44,-41,56v29,12,50,27,50,62v0,48,-37,66,-85,67v-51,1,-85,-21,-85,-67v0,-34,23,-50,50,-62v-24,-13,-41,-27,-41,-57v0,-41,34,-60,76,-60v43,0,76,19,76,61xm98,-209v-29,0,-44,31,-25,51v6,6,15,11,25,16v37,-6,48,-67,0,-67xm98,-29v44,3,51,-54,18,-69v-5,-3,-11,-6,-18,-9v-19,10,-38,16,-39,42v0,25,15,34,39,36","w":196},"9":{"d":"182,-125v0,99,-62,159,-143,114v-14,-8,-21,-26,-24,-46r44,0v13,50,74,20,75,-15v2,-9,4,-20,4,-32v-45,46,-130,15,-125,-55v3,-51,30,-83,82,-83v64,0,87,49,87,117xm57,-161v-4,49,57,57,81,25v0,-39,-10,-71,-43,-71v-27,0,-36,21,-38,46","w":196},":":{"d":"72,0r-46,0r0,-45r46,0r0,45xm72,-127r-46,0r0,-45r46,0r0,45","w":98},";":{"d":"72,-45v0,46,6,99,-45,98r0,-22v18,0,20,-12,21,-31r-22,0r0,-45r46,0xm72,-127r-46,0r0,-45r46,0r0,45","w":98},"<":{"d":"177,-35r-160,-66r0,-32r160,-66r0,35r-115,46r115,47r0,36"},"=":{"d":"177,-139r-160,0r0,-35r160,0r0,35xm177,-61r-160,0r0,-35r160,0r0,35"},">":{"d":"177,-101r-160,66r0,-36r115,-46r-115,-46r0,-36r160,66r0,32"},"?":{"d":"95,-207v-27,0,-35,14,-39,39r-42,0v4,-47,33,-74,81,-74v48,0,81,23,83,68v2,55,-61,52,-61,106r-42,0v-4,-58,49,-59,58,-104v-1,-22,-14,-35,-38,-35xm120,0r-46,0r0,-42r46,0r0,42","w":192},"@":{"d":"40,-88v-6,99,105,133,190,101r10,23v-116,45,-263,-22,-221,-167v19,-65,64,-113,146,-113v79,0,131,42,131,119v0,62,-27,106,-88,108v-17,0,-29,-9,-31,-24v-28,41,-112,25,-104,-38v-5,-72,70,-132,124,-83r3,-14r30,0r-27,122v-1,7,3,11,10,11v41,-4,57,-38,57,-82v0,-60,-43,-94,-105,-94v-79,0,-121,51,-125,131xm105,-80v-7,48,55,44,67,11v8,-20,12,-47,18,-70v-35,-37,-92,5,-85,59","w":309},"[":{"d":"101,66r-79,0r0,-304r79,0r0,33r-35,0r0,238r35,0r0,33","w":106},"\\":{"d":"105,0r-36,0r-69,-238r36,0","w":104},"]":{"d":"85,66r-80,0r0,-33r35,0r0,-238r-35,0r0,-33r80,0r0,304","w":106},"^":{"d":"157,-131r-38,0r-35,-70r-35,70r-38,0r58,-107r30,0","w":168},"_":{"d":"185,52r-187,0r0,-22r187,0r0,22","w":183},"{":{"d":"85,-17v2,32,-5,58,31,53r0,34v-59,5,-76,-26,-76,-86v0,-28,-4,-52,-32,-53r0,-34v39,1,33,-43,33,-79v0,-47,27,-63,75,-60r0,34v-34,-5,-31,19,-31,49v0,39,-8,65,-38,73v28,8,37,33,38,69","w":122},"|":{"d":"64,70r-37,0r0,-309r37,0r0,309","w":91},"}":{"d":"38,-155v-1,-32,4,-57,-31,-53r0,-34v67,-7,76,34,76,102v0,24,9,36,32,37r0,34v-33,-1,-33,30,-32,63v3,57,-19,80,-76,76r0,-34v28,4,31,-12,31,-37v0,-44,5,-76,37,-85v-28,-8,-36,-33,-37,-69","w":122},"~":{"d":"14,-126v44,-55,127,40,166,-19r0,36v-33,39,-85,5,-124,-3v-18,1,-30,11,-42,22r0,-36"},"\u2026":{"d":"270,0r-47,0r0,-45r47,0r0,45xm171,0r-46,0r0,-45r46,0r0,45xm72,0r-46,0r0,-45r46,0r0,45","w":296},"\u2013":{"d":"168,-71r-156,0r0,-34r156,0r0,34","w":180},"\u2014":{"d":"261,-71r-261,0r0,-34r261,0r0,34","w":261},"\u00f7":{"d":"117,-155r-40,0r0,-39r40,0r0,39xm177,-100r-160,0r0,-35r160,0r0,35xm117,-41r-40,0r0,-38r40,0r0,38"},"\u2212":{"d":"177,-100r-160,0r0,-35r160,0r0,35"},"\u00d7":{"d":"171,-68r-25,25r-49,-50r-50,50r-25,-25r50,-49r-50,-50r25,-25r50,50r49,-50r25,25r-49,50"},"\u0131":{"d":"66,0r-45,0r0,-172r45,0r0,172","w":87},"\u02c7":{"d":"118,-243r-35,47r-43,0r-34,-47r36,0r20,24r19,-24r37,0","w":123},"\u02da":{"d":"24,-225v0,-24,14,-38,38,-38v23,0,37,14,37,38v0,23,-13,37,-37,37v-25,0,-38,-14,-38,-37xm80,-225v0,-11,-7,-20,-18,-20v-12,1,-18,9,-19,20v1,10,8,19,19,19v11,0,18,-8,18,-19","w":123},"\u2044":{"d":"128,-238r-169,238r-29,0r169,-238r29,0","w":57},"\u2074":{"d":"109,-144r-16,0r0,25r-27,0r0,-25r-60,0r0,-21r60,-75r27,0r0,74r16,0r0,22xm66,-166r0,-43r-34,43r34,0","w":113},"\u0c3d":{"d":"124,-125v-8,-30,-62,-9,-79,-2r0,-39v40,-20,117,-17,117,40v0,60,-68,50,-110,67v-3,2,-4,4,-4,6v1,10,14,12,26,12r201,0r0,44r-203,0v-55,7,-85,-65,-36,-94v25,-15,75,-6,88,-34","w":290},"\u0c78":{"d":"141,-99v27,11,35,53,8,72v-21,15,-50,30,-76,39r-22,-28v26,-11,52,-22,74,-36v12,-18,-15,-24,-38,-25v-48,-2,-76,-31,-76,-79v0,-46,30,-73,76,-76v70,-4,98,89,54,133xm87,-121v23,0,38,-13,38,-35v0,-23,-15,-38,-38,-38v-23,0,-39,15,-39,38v0,22,16,35,39,35","w":184},"\u0c79":{"d":"35,-229r38,0r0,229r-38,0r0,-229","w":108},"\u0c7a":{"d":"55,-143v-2,27,34,26,52,18r0,-104r37,0r0,229r-37,0r0,-86v-45,12,-89,-4,-89,-54r0,-89r37,0r0,86","w":172},"\u0c7b":{"d":"144,-138v0,23,35,20,51,13r0,-104r38,0r0,229r-38,0r0,-86v-22,7,-56,5,-70,-9v-40,25,-107,13,-107,-45r0,-89r37,0v6,38,-18,109,23,109v12,0,27,-4,28,-17r0,-92r38,0r0,91","w":261},"\u0c7c":{"d":"14,-92r0,-38r217,0r0,38r-217,0","w":245},"\u0c7d":{"d":"70,-46v52,12,137,2,202,5r0,44r-175,0v-54,9,-89,-53,-44,-84v24,-17,77,-11,93,-37v-1,-8,-10,-10,-21,-10r-89,0r0,-38v70,-1,174,-11,143,70v-13,34,-69,30,-104,44v-4,2,-5,4,-5,6","w":289},"\u0c7e":{"d":"162,-87v0,45,-56,31,-83,44v65,5,143,0,212,2r0,44r-188,0v-32,-2,-62,-7,-62,-41v0,-45,50,-37,83,-46v-20,-16,-91,6,-91,-39v0,-36,26,-41,58,-43v10,1,35,-5,18,-11v-22,-2,-51,-1,-75,-1r0,-38v59,-2,142,-8,115,61v-10,25,-51,18,-79,26v26,13,92,-5,92,42","w":308},"\u0c7f":{"d":"127,-41v64,0,103,-41,128,-84r30,21v-29,57,-74,107,-158,107v-64,0,-106,-35,-106,-97v0,-49,26,-84,76,-85v32,-1,46,16,49,45v4,50,-61,64,-87,33v-2,43,28,60,68,60xm83,-139v-2,18,30,26,24,3v-4,-7,-16,-5,-24,-3","w":297}}});
/*!
 * jCarousel - Riding carousels with jQuery
 *   http://sorgalla.com/jcarousel/
 *
 * Copyright (c) 2006 Jan Sorgalla (http://sorgalla.com)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Built on top of the jQuery library
 *   http://jquery.com
 *
 * Inspired by the "Carousel Component" by Bill Scott
 *   http://billwscott.com/carousel/
 */

(function($){$.fn.jcarousel=function(o){if(typeof o=='string'){var instance=$(this).data('jcarousel'),args=Array.prototype.slice.call(arguments,1);return instance[o].apply(instance,args);}else
return this.each(function(){$(this).data('jcarousel',new $jc(this,o));});};var defaults={vertical:false,start:1,offset:1,size:null,scroll:3,visible:null,animation:'normal',easing:'swing',auto:0,wrap:null,initCallback:null,reloadCallback:null,itemLoadCallback:null,itemFirstInCallback:null,itemFirstOutCallback:null,itemLastInCallback:null,itemLastOutCallback:null,itemVisibleInCallback:null,itemVisibleOutCallback:null,buttonNextHTML:'<div></div>',buttonPrevHTML:'<div></div>',buttonNextEvent:'click',buttonPrevEvent:'click',buttonNextCallback:null,buttonPrevCallback:null};$.jcarousel=function(e,o){this.options=$.extend({},defaults,o||{});this.locked=false;this.container=null;this.clip=null;this.list=null;this.buttonNext=null;this.buttonPrev=null;this.wh=!this.options.vertical?'width':'height';this.lt=!this.options.vertical?'left':'top';var skin='',split=e.className.split(' ');for(var i=0;i<split.length;i++){if(split[i].indexOf('jcarousel-skin')!=-1){$(e).removeClass(split[i]);skin=split[i];break;}}if(e.nodeName=='UL'||e.nodeName=='OL'){this.list=$(e);this.container=this.list.parent();if(this.container.hasClass('jcarousel-clip')){if(!this.container.parent().hasClass('jcarousel-container'))this.container=this.container.wrap('<div></div>');this.container=this.container.parent();}else if(!this.container.hasClass('jcarousel-container'))this.container=this.list.wrap('<div></div>').parent();}else{this.container=$(e);this.list=this.container.find('ul,ol').eq(0);}if(skin!=''&&this.container.parent()[0].className.indexOf('jcarousel-skin')==-1)this.container.wrap('<div class=" '+skin+'"></div>');this.clip=this.list.parent();if(!this.clip.length||!this.clip.hasClass('jcarousel-clip'))this.clip=this.list.wrap('<div></div>').parent();this.buttonNext=$('.jcarousel-next',this.container);if(this.buttonNext.size()==0&&this.options.buttonNextHTML!=null)this.buttonNext=this.clip.after(this.options.buttonNextHTML).next();this.buttonNext.addClass(this.className('jcarousel-next'));this.buttonPrev=$('.jcarousel-prev',this.container);if(this.buttonPrev.size()==0&&this.options.buttonPrevHTML!=null)this.buttonPrev=this.clip.after(this.options.buttonPrevHTML).next();this.buttonPrev.addClass(this.className('jcarousel-prev'));this.clip.addClass(this.className('jcarousel-clip')).css({overflow:'hidden',position:'relative'});this.list.addClass(this.className('jcarousel-list')).css({overflow:'hidden',position:'relative',top:0,left:0,margin:0,padding:0});this.container.addClass(this.className('jcarousel-container')).css({position:'relative'});var di=this.options.visible!=null?Math.ceil(this.clipping()/this.options.visible):null;var li=this.list.children('li');var self=this;if(li.size()>0){var wh=0,i=this.options.offset;li.each(function(){self.format(this,i++);wh+=self.dimension(this,di);});this.list.css(this.wh,wh+'px');if(!o||o.size===undefined)this.options.size=li.size();}this.container.css('display','block');this.buttonNext.css('display','block');this.buttonPrev.css('display','block');this.funcNext=function(){self.next();};this.funcPrev=function(){self.prev();};this.funcResize=function(){self.reload();};if(this.options.initCallback!=null)this.options.initCallback(this,'init');if($.browser.safari){this.buttons(false,false);$(window).bind('load.jcarousel',function(){self.setup();});}else
this.setup();};var $jc=$.jcarousel;$jc.fn=$jc.prototype={jcarousel:'0.2.4'};$jc.fn.extend=$jc.extend=$.extend;$jc.fn.extend({setup:function(){this.first=null;this.last=null;this.prevFirst=null;this.prevLast=null;this.animating=false;this.timer=null;this.tail=null;this.inTail=false;if(this.locked)return;this.list.css(this.lt,this.pos(this.options.offset)+'px');var p=this.pos(this.options.start);this.prevFirst=this.prevLast=null;this.animate(p,false);$(window).unbind('resize.jcarousel',this.funcResize).bind('resize.jcarousel',this.funcResize);},reset:function(){this.list.empty();this.list.css(this.lt,'0px');this.list.css(this.wh,'10px');if(this.options.initCallback!=null)this.options.initCallback(this,'reset');this.setup();},reload:function(){if(this.tail!=null&&this.inTail)this.list.css(this.lt,$jc.intval(this.list.css(this.lt))+this.tail);this.tail=null;this.inTail=false;if(this.options.reloadCallback!=null)this.options.reloadCallback(this);if(this.options.visible!=null){var self=this;var di=Math.ceil(this.clipping()/this.options.visible),wh=0,lt=0;$('li',this.list).each(function(i){wh+=self.dimension(this,di);if(i+1<self.first)lt=wh;});this.list.css(this.wh,wh+'px');this.list.css(this.lt,-lt+'px');}this.scroll(this.first,false);},lock:function(){this.locked=true;this.buttons();},unlock:function(){this.locked=false;this.buttons();},size:function(s){if(s!=undefined){this.options.size=s;if(!this.locked)this.buttons();}return this.options.size;},has:function(i,i2){if(i2==undefined||!i2)i2=i;if(this.options.size!==null&&i2>this.options.size)i2=this.options.size;for(var j=i;j<=i2;j++){var e=this.get(j);if(!e.length||e.hasClass('jcarousel-item-placeholder'))return false;}return true;},get:function(i){return $('.jcarousel-item-'+i,this.list);},add:function(i,s){var e=this.get(i),old=0,add=0;if(e.length==0){var c,e=this.create(i),j=$jc.intval(i);while(c=this.get(--j)){if(j<=0||c.length){j<=0?this.list.prepend(e):c.after(e);break;}}}else
old=this.dimension(e);e.removeClass(this.className('jcarousel-item-placeholder'));typeof s=='string'?e.html(s):e.empty().append(s);var di=this.options.visible!=null?Math.ceil(this.clipping()/this.options.visible):null;var wh=this.dimension(e,di)-old;if(i>0&&i<this.first)this.list.css(this.lt,$jc.intval(this.list.css(this.lt))-wh+'px');this.list.css(this.wh,$jc.intval(this.list.css(this.wh))+wh+'px');return e;},remove:function(i){var e=this.get(i);if(!e.length||(i>=this.first&&i<=this.last))return;var d=this.dimension(e);if(i<this.first)this.list.css(this.lt,$jc.intval(this.list.css(this.lt))+d+'px');e.remove();this.list.css(this.wh,$jc.intval(this.list.css(this.wh))-d+'px');},next:function(){this.stopAuto();if(this.tail!=null&&!this.inTail)this.scrollTail(false);else
this.scroll(((this.options.wrap=='both'||this.options.wrap=='last')&&this.options.size!=null&&this.last==this.options.size)?1:this.first+this.options.scroll);},prev:function(){this.stopAuto();if(this.tail!=null&&this.inTail)this.scrollTail(true);else
this.scroll(((this.options.wrap=='both'||this.options.wrap=='first')&&this.options.size!=null&&this.first==1)?this.options.size:this.first-this.options.scroll);},scrollTail:function(b){if(this.locked||this.animating||!this.tail)return;var pos=$jc.intval(this.list.css(this.lt));!b?pos-=this.tail:pos+=this.tail;this.inTail=!b;this.prevFirst=this.first;this.prevLast=this.last;this.animate(pos);},scroll:function(i,a){if(this.locked||this.animating)return;this.animate(this.pos(i),a);},pos:function(i){var pos=$jc.intval(this.list.css(this.lt));if(this.locked||this.animating)return pos;if(this.options.wrap!='circular')i=i<1?1:(this.options.size&&i>this.options.size?this.options.size:i);var back=this.first>i;var f=this.options.wrap!='circular'&&this.first<=1?1:this.first;var c=back?this.get(f):this.get(this.last);var j=back?f:f-1;var e=null,l=0,p=false,d=0,g;while(back?--j>=i:++j<i){e=this.get(j);p=!e.length;if(e.length==0){e=this.create(j).addClass(this.className('jcarousel-item-placeholder'));c[back?'before':'after'](e);if(this.first!=null&&this.options.wrap=='circular'&&this.options.size!==null&&(j<=0||j>this.options.size)){g=this.get(this.index(j));if(g.length)this.add(j,g.children().clone(true));}}c=e;d=this.dimension(e);if(p)l+=d;if(this.first!=null&&(this.options.wrap=='circular'||(j>=1&&(this.options.size==null||j<=this.options.size))))pos=back?pos+d:pos-d;}var clipping=this.clipping();var cache=[];var visible=0,j=i,v=0;var c=this.get(i-1);while(++visible){e=this.get(j);p=!e.length;if(e.length==0){e=this.create(j).addClass(this.className('jcarousel-item-placeholder'));c.length==0?this.list.prepend(e):c[back?'before':'after'](e);if(this.first!=null&&this.options.wrap=='circular'&&this.options.size!==null&&(j<=0||j>this.options.size)){g=this.get(this.index(j));if(g.length)this.add(j,g.find('>*').clone(true));}}c=e;var d=this.dimension(e);if(d==0){alert('jCarousel: No width/height set for items. This will cause an infinite loop. Aborting...');return 0;}if(this.options.wrap!='circular'&&this.options.size!==null&&j>this.options.size)cache.push(e);else if(p)l+=d;v+=d;if(v>=clipping)break;j++;}for(var x=0;x<cache.length;x++)cache[x].remove();if(l>0){this.list.css(this.wh,this.dimension(this.list)+l+'px');if(back){pos-=l;this.list.css(this.lt,$jc.intval(this.list.css(this.lt))-l+'px');}}var last=i+visible-1;if(this.options.wrap!='circular'&&this.options.size&&last>this.options.size)last=this.options.size;if(j>last){visible=0,j=last,v=0;while(++visible){var e=this.get(j--);if(!e.length)break;v+=this.dimension(e);if(v>=clipping)break;}}var first=last-visible+1;if(this.options.wrap!='circular'&&first<1)first=1;if(this.inTail&&back){pos+=this.tail;this.inTail=false;}this.tail=null;if(this.options.wrap!='circular'&&last==this.options.size&&(last-visible+1)>=1){var m=$jc.margin(this.get(last),!this.options.vertical?'marginRight':'marginBottom');if((v-m)>clipping)this.tail=v-clipping-m;}while(i-->first)pos+=this.dimension(this.get(i));this.prevFirst=this.first;this.prevLast=this.last;this.first=first;this.last=last;return pos;},animate:function(p,a){if(this.locked||this.animating)return;this.animating=true;var self=this;var scrolled=function(){self.animating=false;if(p==0)self.list.css(self.lt,0);if(self.options.wrap=='circular'||self.options.wrap=='both'||self.options.wrap=='last'||self.options.size==null||self.last<self.options.size)self.startAuto();self.buttons();self.notify('onAfterAnimation');};this.notify('onBeforeAnimation');if(!this.options.animation||a==false){this.list.css(this.lt,p+'px');scrolled();}else{var o=!this.options.vertical?{'left':p}:{'top':p};this.list.animate(o,this.options.animation,this.options.easing,scrolled);}},startAuto:function(s){if(s!=undefined)this.options.auto=s;if(this.options.auto==0)return this.stopAuto();if(this.timer!=null)return;var self=this;this.timer=setTimeout(function(){self.next();},this.options.auto*1000);},stopAuto:function(){if(this.timer==null)return;clearTimeout(this.timer);this.timer=null;},buttons:function(n,p){if(n==undefined||n==null){var n=!this.locked&&this.options.size!==0&&((this.options.wrap&&this.options.wrap!='first')||this.options.size==null||this.last<this.options.size);if(!this.locked&&(!this.options.wrap||this.options.wrap=='first')&&this.options.size!=null&&this.last>=this.options.size)n=this.tail!=null&&!this.inTail;}if(p==undefined||p==null){var p=!this.locked&&this.options.size!==0&&((this.options.wrap&&this.options.wrap!='last')||this.first>1);if(!this.locked&&(!this.options.wrap||this.options.wrap=='last')&&this.options.size!=null&&this.first==1)p=this.tail!=null&&this.inTail;}var self=this;this.buttonNext[n?'bind':'unbind'](this.options.buttonNextEvent+'.jcarousel',this.funcNext)[n?'removeClass':'addClass'](this.className('jcarousel-next-disabled')).attr('disabled',n?false:true);this.buttonPrev[p?'bind':'unbind'](this.options.buttonPrevEvent+'.jcarousel',this.funcPrev)[p?'removeClass':'addClass'](this.className('jcarousel-prev-disabled')).attr('disabled',p?false:true);if(this.buttonNext.length>0&&(this.buttonNext[0].jcarouselstate==undefined||this.buttonNext[0].jcarouselstate!=n)&&this.options.buttonNextCallback!=null){this.buttonNext.each(function(){self.options.buttonNextCallback(self,this,n);});this.buttonNext[0].jcarouselstate=n;}if(this.buttonPrev.length>0&&(this.buttonPrev[0].jcarouselstate==undefined||this.buttonPrev[0].jcarouselstate!=p)&&this.options.buttonPrevCallback!=null){this.buttonPrev.each(function(){self.options.buttonPrevCallback(self,this,p);});this.buttonPrev[0].jcarouselstate=p;}},notify:function(evt){var state=this.prevFirst==null?'init':(this.prevFirst<this.first?'next':'prev');this.callback('itemLoadCallback',evt,state);if(this.prevFirst!==this.first){this.callback('itemFirstInCallback',evt,state,this.first);this.callback('itemFirstOutCallback',evt,state,this.prevFirst);}if(this.prevLast!==this.last){this.callback('itemLastInCallback',evt,state,this.last);this.callback('itemLastOutCallback',evt,state,this.prevLast);}this.callback('itemVisibleInCallback',evt,state,this.first,this.last,this.prevFirst,this.prevLast);this.callback('itemVisibleOutCallback',evt,state,this.prevFirst,this.prevLast,this.first,this.last);},callback:function(cb,evt,state,i1,i2,i3,i4){if(this.options[cb]==undefined||(typeof this.options[cb]!='object'&&evt!='onAfterAnimation'))return;var callback=typeof this.options[cb]=='object'?this.options[cb][evt]:this.options[cb];if(!$.isFunction(callback))return;var self=this;if(i1===undefined)callback(self,state,evt);else if(i2===undefined)this.get(i1).each(function(){callback(self,this,i1,state,evt);});else{for(var i=i1;i<=i2;i++)if(i!==null&&!(i>=i3&&i<=i4))this.get(i).each(function(){callback(self,this,i,state,evt);});}},create:function(i){return this.format('<li></li>',i);},format:function(e,i){var $e=$(e).addClass(this.className('jcarousel-item')).addClass(this.className('jcarousel-item-'+i)).css({'float':'left','list-style':'none'});$e.attr('jcarouselindex',i);return $e;},className:function(c){return c+' '+c+(!this.options.vertical?'-horizontal':'-vertical');},dimension:function(e,d){var el=e.jquery!=undefined?e[0]:e;var old=!this.options.vertical?el.offsetWidth+$jc.margin(el,'marginLeft')+$jc.margin(el,'marginRight'):el.offsetHeight+$jc.margin(el,'marginTop')+$jc.margin(el,'marginBottom');if(d==undefined||old==d)return old;var w=!this.options.vertical?d-$jc.margin(el,'marginLeft')-$jc.margin(el,'marginRight'):d-$jc.margin(el,'marginTop')-$jc.margin(el,'marginBottom');$(el).css(this.wh,w+'px');return this.dimension(el);},clipping:function(){return!this.options.vertical?this.clip[0].offsetWidth-$jc.intval(this.clip.css('borderLeftWidth'))-$jc.intval(this.clip.css('borderRightWidth')):this.clip[0].offsetHeight-$jc.intval(this.clip.css('borderTopWidth'))-$jc.intval(this.clip.css('borderBottomWidth'));},index:function(i,s){if(s==undefined)s=this.options.size;return Math.round((((i-1)/s)-Math.floor((i-1)/s))*s)+1;}});$jc.extend({defaults:function(d){return $.extend(defaults,d||{});},margin:function(e,p){if(!e)return 0;var el=e.jquery!=undefined?e[0]:e;if(p=='marginRight'&&$.browser.safari){var old={'display':'block','float':'none','width':'auto'},oWidth,oWidth2;$.swap(el,old,function(){oWidth=el.offsetWidth;});old['marginRight']=0;$.swap(el,old,function(){oWidth2=el.offsetWidth;});return oWidth2-oWidth;}return $jc.intval($.css(el,p));},intval:function(v){v=parseInt(v);return isNaN(v)?0:v;}});})(jQuery);
/*
 * 	Easy Slider 1.7 - jQuery plugin
 *	written by Alen Grakalic	
 *	http://cssglobe.com/post/4004/easy-slider-15-the-easiest-jquery-plugin-for-sliding
 *
 *	Copyright (c) 2009 Alen Grakalic (http://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
 
/*
 *	markup example for $("#slider").easySlider();
 *	
 * 	<div id="slider">
 *		<ul>
 *			<li><img src="images/01.jpg" alt="" /></li>
 *			<li><img src="images/02.jpg" alt="" /></li>
 *			<li><img src="images/03.jpg" alt="" /></li>
 *			<li><img src="images/04.jpg" alt="" /></li>
 *			<li><img src="images/05.jpg" alt="" /></li>
 *		</ul>
 *	</div>
 *
 */

(function($) {

	$.fn.easySlider = function(options){
	  
		// default configuration properties
		var defaults = {			
			prevId: 		'prevBtn',
			prevText: 		'Previous',
			nextId: 		'nextBtn',	
			nextText: 		'Next',
			controlsShow:	true,
			controlsBefore:	'',
			controlsAfter:	'',	
			controlsFade:	true,
			firstId: 		'firstBtn',
			firstText: 		'First',
			firstShow:		false,
			lastId: 		'lastBtn',	
			lastText: 		'Last',
			lastShow:		false,				
			vertical:		false,
			speed: 			1000,
			auto:			false,
			pause:			4000,
			continuous:		true, 
			numeric: 		false,
			numericId: 		'controls'
		}; 
		
		var options = $.extend(defaults, options);  
				
		this.each(function() {  
			var obj = $(this); 				
			var s = $("li", obj).length;
			var w = $("li", obj).width(); 
			var h = $("li", obj).height(); 
			var clickable = true;
			obj.width(w); 
			obj.height(h); 
			obj.css("overflow","hidden");
			var ts = s-1;
			var t = 0;
			$("ul", obj).css('width',s*w);			
			
			if(options.continuous){
				$("ul", obj).prepend($("ul li:last-child", obj).clone().css("margin-left","-"+ w +"px"));
				$("ul", obj).append($("ul li:nth-child(2)", obj).clone());
				$("ul", obj).css('width',(s+1)*w);
			};				
			
			if(!options.vertical) $("li", obj).css('float','left');
								
			if(options.controlsShow){
				var html = options.controlsBefore;				
				if(options.numeric){
					html += '<ol id="'+ options.numericId +'"></ol>';
				} else {
					if(options.firstShow) html += '<span id="'+ options.firstId +'"><a href=\"javascript:void(0);\">'+ options.firstText +'</a></span>';
					html += ' <span id="'+ options.prevId +'"><a href=\"javascript:void(0);\">'+ options.prevText +'</a></span>';
					html += ' <span id="'+ options.nextId +'"><a href=\"javascript:void(0);\">'+ options.nextText +'</a></span>';
					if(options.lastShow) html += ' <span id="'+ options.lastId +'"><a href=\"javascript:void(0);\">'+ options.lastText +'</a></span>';				
				};
				
				html += options.controlsAfter;						
				$(obj).after(html);										
			};
			
			if(options.numeric){									
				for(var i=0;i<s;i++){						
					$(document.createElement("li"))
						.attr('id',options.numericId + (i+1))
						.html('<a rel='+ i +' href=\"javascript:void(0);\">'+ (i+1) +'</a>')
						.appendTo($("#"+ options.numericId))
						.click(function(){							
							animate($("a",$(this)).attr('rel'),true);
						}); 												
				};							
			} else {
				$("a","#"+options.nextId).click(function(){		
					animate("next",true);
				});
				$("a","#"+options.prevId).click(function(){		
					animate("prev",true);				
				});	
				$("a","#"+options.firstId).click(function(){		
					animate("first",true);
				});				
				$("a","#"+options.lastId).click(function(){		
					animate("last",true);				
				});				
			};
			
			function setCurrent(i){
				i = parseInt(i)+1;
				$("li", "#" + options.numericId).removeClass("current");
				$("li#" + options.numericId + i).addClass("current");
			};
			
			function adjust(){
				if(t>ts) t=0;		
				if(t<0) t=ts;	
				if(!options.vertical) {
					$("ul",obj).css("margin-left",(t*w*-1));
				} else {
					$("ul",obj).css("margin-left",(t*h*-1));
				}
				clickable = true;
				if(options.numeric) setCurrent(t);
			};
			
			function animate(dir,clicked){
				if (clickable){
					clickable = false;
					var ot = t;				
					switch(dir){
						case "next":
							t = (ot>=ts) ? (options.continuous ? t+1 : ts) : t+1;						
							break; 
						case "prev":
							t = (t<=0) ? (options.continuous ? t-1 : 0) : t-1;
							break; 
						case "first":
							t = 0;
							break; 
						case "last":
							t = ts;
							break; 
						default:
							t = dir;
							break; 
					};	
					var diff = Math.abs(ot-t);
					var speed = diff*options.speed;						
					if(!options.vertical) {
						p = (t*w*-1);
						$("ul",obj).animate(
							{ marginLeft: p }, 
							{ queue:false, duration:speed, complete:adjust }
						);				
					} else {
						p = (t*h*-1);
						$("ul",obj).animate(
							{ marginTop: p }, 
							{ queue:false, duration:speed, complete:adjust }
						);					
					};
					
					if(!options.continuous && options.controlsFade){					
						if(t==ts){
							$("a","#"+options.nextId).hide();
							$("a","#"+options.lastId).hide();
						} else {
							$("a","#"+options.nextId).show();
							$("a","#"+options.lastId).show();					
						};
						if(t==0){
							$("a","#"+options.prevId).hide();
							$("a","#"+options.firstId).hide();
						} else {
							$("a","#"+options.prevId).show();
							$("a","#"+options.firstId).show();
						};					
					};				
					
					if(clicked) clearTimeout(timeout);
					if(options.auto && dir=="next" && !clicked){;
						timeout = setTimeout(function(){
							animate("next",false);
						},diff*options.speed+options.pause);
					};
			
				};
				
			};
			// init
			var timeout;
			if(options.auto){;
				timeout = setTimeout(function(){
					animate("next",false);
				},options.pause);
			};		
			
			if(options.numeric) setCurrent(0);
		
			if(!options.continuous && options.controlsFade){					
				$("a","#"+options.prevId).hide();
				$("a","#"+options.firstId).hide();				
			};				
			
		});
	  
	};

})(jQuery);
/*
 * FancyBox - jQuery Plugin
 * simple and fancy lightbox alternative
 *
 * Copyright (c) 2009 Janis Skarnelis
 * Examples and documentation at: http://fancybox.net
 * 
 * Version: 1.2.6 (16/11/2009)
 * Requires: jQuery v1.3+
 * 
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

;(function($) {
	$.fn.fixPNG = function() {
		return this.each(function () {
			var image = $(this).css('backgroundImage');

			if (image.match(/^url\(["']?(.*\.png)["']?\)$/i)) {
				image = RegExp.$1;
				$(this).css({
					'backgroundImage': 'none',
					'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=" + ($(this).css('backgroundRepeat') == 'no-repeat' ? 'crop' : 'scale') + ", src='" + image + "')"
				}).each(function () {
					var position = $(this).css('position');
					if (position != 'absolute' && position != 'relative')
						$(this).css('position', 'relative');
				});
			}
		});
	};

	var elem, opts, busy = false, imagePreloader = new Image, loadingTimer, loadingFrame = 1, imageRegExp = /\.(jpg|gif|png|bmp|jpeg)(.*)?$/i;
	var ieQuirks = null, IE6 = $.browser.msie && $.browser.version.substr(0,1) == 6 && !window.XMLHttpRequest, oldIE = IE6 || ($.browser.msie && $.browser.version.substr(0,1) == 7);

	$.fn.fancybox = function(o) {
		var settings		= $.extend({}, $.fn.fancybox.defaults, o);
		var matchedGroup	= this;

		function _initialize() {
			elem = this;
			opts = $.extend({}, settings);

			_start();

			return false;
		};

		function _start() {
			if (busy) return;

			if ($.isFunction(opts.callbackOnStart)) {
				opts.callbackOnStart();
			}

			opts.itemArray		= [];
			opts.itemCurrent	= 0;

			if (settings.itemArray.length > 0) {
				opts.itemArray = settings.itemArray;

			} else {
				var item = {};

				if (!elem.rel || elem.rel == '') {
					var item = {href: elem.href, title: elem.title};

					if ($(elem).children("img:first").length) {
						item.orig = $(elem).children("img:first");
					} else {
						item.orig = $(elem);
					}

					if (item.title == '' || typeof item.title == 'undefined') {
						item.title = item.orig.attr('alt');
					}
					
					opts.itemArray.push( item );

				} else {
					var subGroup = $(matchedGroup).filter("a[rel=" + elem.rel + "]");
					var item = {};

					for (var i = 0; i < subGroup.length; i++) {
						item = {href: subGroup[i].href, title: subGroup[i].title};

						if ($(subGroup[i]).children("img:first").length) {
							item.orig = $(subGroup[i]).children("img:first");
						} else {
							item.orig = $(subGroup[i]);
						}

						if (item.title == '' || typeof item.title == 'undefined') {
							item.title = item.orig.attr('alt');
						}

						opts.itemArray.push( item );
					}
				}
			}

			while ( opts.itemArray[ opts.itemCurrent ].href != elem.href ) {
				opts.itemCurrent++;
			}

			if (opts.overlayShow) {
				if (IE6) {
					$('embed, object, select').css('visibility', 'hidden');
					$("#fancy_overlay").css('height', $(document).height());
				}

				$("#fancy_overlay").css({
					'background-color'	: opts.overlayColor,
					'opacity'			: opts.overlayOpacity
				}).show();
			}
			
			$(window).bind("resize.fb scroll.fb", $.fn.fancybox.scrollBox);

			_change_item();
		};

		function _change_item() {
			$("#fancy_right, #fancy_left, #fancy_close, #fancy_title").hide();

			var href = opts.itemArray[ opts.itemCurrent ].href;

			if (href.match("iframe") || elem.className.indexOf("iframe") >= 0) {
				$.fn.fancybox.showLoading();
				_set_content('<iframe id="fancy_frame" onload="jQuery.fn.fancybox.showIframe()" name="fancy_iframe' + Math.round(Math.random()*1000) + '" frameborder="0" hspace="0" src="' + href + '"></iframe>', opts.frameWidth, opts.frameHeight);

			} else if (href.match(/#/)) {
				var target = window.location.href.split('#')[0]; target = href.replace(target, ''); target = target.substr(target.indexOf('#'));

				_set_content('<div id="fancy_div">' + $(target).html() + '</div>', opts.frameWidth, opts.frameHeight);

			} else if (href.match(imageRegExp)) {
				imagePreloader = new Image; imagePreloader.src = href;

				if (imagePreloader.complete) {
					_proceed_image();

				} else {
					$.fn.fancybox.showLoading();
					$(imagePreloader).unbind().bind('load', function() {
						$("#fancy_loading").hide();

						_proceed_image();
					});
				}
			} else {
				$.fn.fancybox.showLoading();
				$.get(href, function(data) {
					$("#fancy_loading").hide();
					_set_content( '<div id="fancy_ajax">' + data + '</div>', opts.frameWidth, opts.frameHeight );
				});
			}
		};

		function _proceed_image() {
			var width	= imagePreloader.width;
			var height	= imagePreloader.height;

			var horizontal_space	= (opts.padding * 2) + 40;
			var vertical_space		= (opts.padding * 2) + 60;

			var w = $.fn.fancybox.getViewport();
			
			if (opts.imageScale && (width > (w[0] - horizontal_space) || height > (w[1] - vertical_space))) {
				var ratio = Math.min(Math.min(w[0] - horizontal_space, width) / width, Math.min(w[1] - vertical_space, height) / height);

				width	= Math.round(ratio * width);
				height	= Math.round(ratio * height);
			}

			_set_content('<img alt="" id="fancy_img" src="' + imagePreloader.src + '" />', width, height);
		};

		function _preload_neighbor_images() {
			if ((opts.itemArray.length -1) > opts.itemCurrent) {
				var href = opts.itemArray[opts.itemCurrent + 1].href || false;

				if (href && href.match(imageRegExp)) {
					objNext = new Image();
					objNext.src = href;
				}
			}

			if (opts.itemCurrent > 0) {
				var href = opts.itemArray[opts.itemCurrent -1].href || false;

				if (href && href.match(imageRegExp)) {
					objNext = new Image();
					objNext.src = href;
				}
			}
		};

		function _set_content(value, width, height) {
			busy = true;

			var pad = opts.padding;

			if (oldIE || ieQuirks) {
				$("#fancy_content")[0].style.removeExpression("height");
				$("#fancy_content")[0].style.removeExpression("width");
			}

			if (pad > 0) {
				width	+= pad * 2;
				height	+= pad * 2;

				$("#fancy_content").css({
					'top'		: pad + 'px',
					'right'		: pad + 'px',
					'bottom'	: pad + 'px',
					'left'		: pad + 'px',
					'width'		: 'auto',
					'height'	: 'auto'
				});

				if (oldIE || ieQuirks) {
					$("#fancy_content")[0].style.setExpression('height',	'(this.parentNode.clientHeight - '	+ pad * 2 + ')');
					$("#fancy_content")[0].style.setExpression('width',		'(this.parentNode.clientWidth - '	+ pad * 2 + ')');
				}
			} else {
				$("#fancy_content").css({
					'top'		: 0,
					'right'		: 0,
					'bottom'	: 0,
					'left'		: 0,
					'width'		: '100%',
					'height'	: '100%'
				});
			}

			if ($("#fancy_outer").is(":visible") && width == $("#fancy_outer").width() && height == $("#fancy_outer").height()) {
				$("#fancy_content").fadeOut('fast', function() {
					$("#fancy_content").empty().append($(value)).fadeIn("normal", function() {
						_finish();
					});
				});

				return;
			}

			var w = $.fn.fancybox.getViewport();

			var itemTop		= (height	+ 60) > w[1] ? w[3] : (w[3] + Math.round((w[1] - height	- 60) * 0.5));
			var itemLeft	= (width	+ 40) > w[0] ? w[2] : (w[2] + Math.round((w[0] - width	- 40) * 0.5));

			var itemOpts = {
				'left':		itemLeft,
				'top':		itemTop,
				'width':	width + 'px',
				'height':	height + 'px'
			};

			if ($("#fancy_outer").is(":visible")) {
				$("#fancy_content").fadeOut("normal", function() {
					$("#fancy_content").empty();
					$("#fancy_outer").animate(itemOpts, opts.zoomSpeedChange, opts.easingChange, function() {
						$("#fancy_content").append($(value)).fadeIn("normal", function() {
							_finish();
						});
					});
				});

			} else {

				if (opts.zoomSpeedIn > 0 && opts.itemArray[opts.itemCurrent].orig !== undefined) {
					$("#fancy_content").empty().append($(value));

					var orig_item	= opts.itemArray[opts.itemCurrent].orig;
					var orig_pos	= $.fn.fancybox.getPosition(orig_item);

					$("#fancy_outer").css({
						'left':		(orig_pos.left	- 20 - opts.padding) + 'px',
						'top':		(orig_pos.top	- 20 - opts.padding) + 'px',
						'width':	$(orig_item).width() + (opts.padding * 2),
						'height':	$(orig_item).height() + (opts.padding * 2)
					});

					if (opts.zoomOpacity) {
						itemOpts.opacity = 'show';
					}

					$("#fancy_outer").animate(itemOpts, opts.zoomSpeedIn, opts.easingIn, function() {
						_finish();
					});

				} else {

					$("#fancy_content").hide().empty().append($(value)).show();
					$("#fancy_outer").css(itemOpts).fadeIn("normal", function() {
						_finish();
					});
				}
			}
		};

		function _set_navigation() {
			if (opts.itemCurrent !== 0) {
				$("#fancy_left, #fancy_left_ico").unbind().bind("click", function(e) {
					e.stopPropagation();

					opts.itemCurrent--;
					_change_item();

					return false;
				});

				$("#fancy_left").show();
			}

			if (opts.itemCurrent != ( opts.itemArray.length -1)) {
				$("#fancy_right, #fancy_right_ico").unbind().bind("click", function(e) {
					e.stopPropagation();

					opts.itemCurrent++;
					_change_item();

					return false;
				});

				$("#fancy_right").show();
			}
		};

		function _finish() {
			if ($.browser.msie) {
				$("#fancy_content")[0].style.removeAttribute('filter');
				$("#fancy_outer")[0].style.removeAttribute('filter');
			}

			_set_navigation();

			_preload_neighbor_images();

			$(document).bind("keydown.fb", function(e) {
				if (e.keyCode == 27 && opts.enableEscapeButton) {
					$.fn.fancybox.close();

				} else if(e.keyCode == 37 && opts.itemCurrent !== 0) {
					$(document).unbind("keydown.fb");
					opts.itemCurrent--;
					_change_item();
					

				} else if(e.keyCode == 39 && opts.itemCurrent != (opts.itemArray.length - 1)) {
					$(document).unbind("keydown.fb");
					opts.itemCurrent++;
					_change_item();
				}
			});

			if (opts.hideOnContentClick) {
				$("#fancy_content").click($.fn.fancybox.close);
			}

			if (opts.overlayShow && opts.hideOnOverlayClick) {
				$("#fancy_overlay").bind("click", $.fn.fancybox.close);
			}

			if (opts.showCloseButton) {
				$("#fancy_close").bind("click", $.fn.fancybox.close).show();
			}

			if (typeof opts.itemArray[ opts.itemCurrent ].title !== 'undefined' && opts.itemArray[ opts.itemCurrent ].title.length > 0) {
				var pos = $("#fancy_outer").position();

				$('#fancy_title div').text( opts.itemArray[ opts.itemCurrent ].title).html();

				$('#fancy_title').css({
					'top'	: pos.top + $("#fancy_outer").outerHeight() - 32,
					'left'	: pos.left + (($("#fancy_outer").outerWidth() * 0.5) - ($('#fancy_title').width() * 0.5))
				}).show();
			}

			if (opts.overlayShow && IE6) {
				$('embed, object, select', $('#fancy_content')).css('visibility', 'visible');
			}

			if ($.isFunction(opts.callbackOnShow)) {
				opts.callbackOnShow( opts.itemArray[ opts.itemCurrent ] );
			}

			if ($.browser.msie) {
				$("#fancy_outer")[0].style.removeAttribute('filter'); 
				$("#fancy_content")[0].style.removeAttribute('filter'); 
			}
			
			busy = false;
		};

		return this.unbind('click.fb').bind('click.fb', _initialize);
	};

	$.fn.fancybox.scrollBox = function() {
		var w = $.fn.fancybox.getViewport();
		
		if (opts.centerOnScroll && $("#fancy_outer").is(':visible')) {
			var ow	= $("#fancy_outer").outerWidth();
			var oh	= $("#fancy_outer").outerHeight();

			var pos	= {
				'top'	: (oh > w[1] ? w[3] : w[3] + Math.round((w[1] - oh) * 0.5)),
				'left'	: (ow > w[0] ? w[2] : w[2] + Math.round((w[0] - ow) * 0.5))
			};

			$("#fancy_outer").css(pos);

			$('#fancy_title').css({
				'top'	: pos.top	+ oh - 32,
				'left'	: pos.left	+ ((ow * 0.5) - ($('#fancy_title').width() * 0.5))
			});
		}
		
		if (IE6 && $("#fancy_overlay").is(':visible')) {
			$("#fancy_overlay").css({
				'height' : $(document).height()
			});
		}
		
		if ($("#fancy_loading").is(':visible')) {
			$("#fancy_loading").css({'left': ((w[0] - 40) * 0.5 + w[2]), 'top': ((w[1] - 40) * 0.5 + w[3])});
		}
	};

	$.fn.fancybox.getNumeric = function(el, prop) {
		return parseInt($.curCSS(el.jquery?el[0]:el,prop,true))||0;
	};

	$.fn.fancybox.getPosition = function(el) {
		var pos = el.offset();

		pos.top	+= $.fn.fancybox.getNumeric(el, 'paddingTop');
		pos.top	+= $.fn.fancybox.getNumeric(el, 'borderTopWidth');

		pos.left += $.fn.fancybox.getNumeric(el, 'paddingLeft');
		pos.left += $.fn.fancybox.getNumeric(el, 'borderLeftWidth');

		return pos;
	};

	$.fn.fancybox.showIframe = function() {
		$("#fancy_loading").hide();
		$("#fancy_frame").show();
	};

	$.fn.fancybox.getViewport = function() {
		return [$(window).width(), $(window).height(), $(document).scrollLeft(), $(document).scrollTop() ];
	};

	$.fn.fancybox.animateLoading = function() {
		if (!$("#fancy_loading").is(':visible')){
			clearInterval(loadingTimer);
			return;
		}

		$("#fancy_loading > div").css('top', (loadingFrame * -40) + 'px');

		loadingFrame = (loadingFrame + 1) % 12;
	};

	$.fn.fancybox.showLoading = function() {
		clearInterval(loadingTimer);

		var w = $.fn.fancybox.getViewport();

		$("#fancy_loading").css({'left': ((w[0] - 40) * 0.5 + w[2]), 'top': ((w[1] - 40) * 0.5 + w[3])}).show();
		$("#fancy_loading").bind('click', $.fn.fancybox.close);

		loadingTimer = setInterval($.fn.fancybox.animateLoading, 66);
	};

	$.fn.fancybox.close = function() {
		busy = true;

		$(imagePreloader).unbind();

		$(document).unbind("keydown.fb");
		$(window).unbind("resize.fb scroll.fb");

		$("#fancy_overlay, #fancy_content, #fancy_close").unbind();

		$("#fancy_close, #fancy_loading, #fancy_left, #fancy_right, #fancy_title").hide();

		__cleanup = function() {
			if ($("#fancy_overlay").is(':visible')) {
				$("#fancy_overlay").fadeOut("fast");
			}

			$("#fancy_content").empty();
			
			if (opts.centerOnScroll) {
				$(window).unbind("resize.fb scroll.fb");
			}

			if (IE6) {
				$('embed, object, select').css('visibility', 'visible');
			}

			if ($.isFunction(opts.callbackOnClose)) {
				opts.callbackOnClose();
			}

			busy = false;
		};

		if ($("#fancy_outer").is(":visible") !== false) {
			if (opts.zoomSpeedOut > 0 && opts.itemArray[opts.itemCurrent].orig !== undefined) {
				var orig_item	= opts.itemArray[opts.itemCurrent].orig;
				var orig_pos	= $.fn.fancybox.getPosition(orig_item);

				var itemOpts = {
					'left':		(orig_pos.left	- 20 - opts.padding) + 'px',
					'top': 		(orig_pos.top	- 20 - opts.padding) + 'px',
					'width':	$(orig_item).width() + (opts.padding * 2),
					'height':	$(orig_item).height() + (opts.padding * 2)
				};

				if (opts.zoomOpacity) {
					itemOpts.opacity = 'hide';
				}

				$("#fancy_outer").stop(false, true).animate(itemOpts, opts.zoomSpeedOut, opts.easingOut, __cleanup);

			} else {
				$("#fancy_outer").stop(false, true).fadeOut('fast', __cleanup);
			}

		} else {
			__cleanup();
		}

		return false;
	};

	$.fn.fancybox.build = function() {
		var html = '';

		html += '<div id="fancy_overlay"></div>';
		html += '<div id="fancy_loading"><div></div></div>';

		html += '<div id="fancy_outer">';
		html += '<div id="fancy_inner">';

		html += '<div id="fancy_close"></div>';

		html += '<div id="fancy_bg"><div class="fancy_bg" id="fancy_bg_n"></div><div class="fancy_bg" id="fancy_bg_ne"></div><div class="fancy_bg" id="fancy_bg_e"></div><div class="fancy_bg" id="fancy_bg_se"></div><div class="fancy_bg" id="fancy_bg_s"></div><div class="fancy_bg" id="fancy_bg_sw"></div><div class="fancy_bg" id="fancy_bg_w"></div><div class="fancy_bg" id="fancy_bg_nw"></div></div>';

		html += '<a href="javascript:;" id="fancy_left"><span class="fancy_ico" id="fancy_left_ico"></span></a><a href="javascript:;" id="fancy_right"><span class="fancy_ico" id="fancy_right_ico"></span></a>';

		html += '<div id="fancy_content"></div>';

		html += '</div>';
		html += '</div>';
		
		html += '<div id="fancy_title"></div>';
		
		$(html).appendTo("body");

		$('<table cellspacing="0" cellpadding="0" border="0"><tr><td class="fancy_title" id="fancy_title_left"></td><td class="fancy_title" id="fancy_title_main"><div></div></td><td class="fancy_title" id="fancy_title_right"></td></tr></table>').appendTo('#fancy_title');

		if ($.browser.msie) {
			$(".fancy_bg").fixPNG();
		}

		if (IE6) {
			$("div#fancy_overlay").css("position", "absolute");
			$("#fancy_loading div, #fancy_close, .fancy_title, .fancy_ico").fixPNG();

			$("#fancy_inner").prepend('<iframe id="fancy_bigIframe" src="javascript:false;" scrolling="no" frameborder="0"></iframe>');

			// Get rid of the 'false' text introduced by the URL of the iframe
			var frameDoc = $('#fancy_bigIframe')[0].contentWindow.document;
			frameDoc.open();
			frameDoc.close();
			
		}
	};

	$.fn.fancybox.defaults = {
		padding				:	10,
		imageScale			:	true,
		zoomOpacity			:	true,
		zoomSpeedIn			:	0,
		zoomSpeedOut		:	0,
		zoomSpeedChange		:	300,
		easingIn			:	'swing',
		easingOut			:	'swing',
		easingChange		:	'swing',
		frameWidth			:	560,
		frameHeight			:	340,
		overlayShow			:	true,
		overlayOpacity		:	0.3,
		overlayColor		:	'#666',
		enableEscapeButton	:	true,
		showCloseButton		:	true,
		hideOnOverlayClick	:	true,
		hideOnContentClick	:	true,
		centerOnScroll		:	true,
		itemArray			:	[],
		callbackOnStart		:	null,
		callbackOnShow		:	null,
		callbackOnClose		:	null
	};

	$(document).ready(function() {
		ieQuirks = $.browser.msie && !$.boxModel;

		if ($("#fancy_outer").length < 1) {
			$.fn.fancybox.build();
		}
	});

})(jQuery);

//
//  pop! for jQuery
//  v0.2 requires jQuery v1.2 or later
//  
//  Licensed under the MIT:
//  http://www.opensource.org/licenses/mit-license.php
//  
//  Copyright 2007,2008 SEAOFCLOUDS [http://seaofclouds.com]
//

(function($) {
  
  $.pop = function(options){
    
    // settings
    var settings = {
     pop_class : '.pop',
     pop_toggle_text : ''
    }
    
    // inject html wrapper
    function initpops (){
      $(settings.pop_class).each(function() {
        var pop_classes = $(this).attr("class");
        $(this).addClass("pop_menu");
        $(this).wrap("<div class='"+pop_classes+"'></div>");
        $(".pop_menu").attr("class", "pop_menu");
        $(this).before(" \
          <div class='pop_toggle'>"+settings.pop_toggle_text+"</div> \
          ");
      });
    }
    initpops();
    
    // assign reverse z-indexes to each pop
    var totalpops = $(settings.pop_class).size() + 1000;
    $(settings.pop_class).each(function(i) {
     var popzindex = totalpops - i;
     $(this).css({ zIndex: popzindex });
    });
    // close pops if user clicks outside of pop
    activePop = null;
    function closeInactivePop() {
      $(settings.pop_class).each(function (i) {
        if ($(this).hasClass('active') && i!=activePop) {
          $(this).removeClass('active');
          }
      });
      return false;
    }
    $(settings.pop_class).mouseover(function() { activePop = $(settings.pop_class).index(this); });
    $(settings.pop_class).mouseout(function() { activePop = null; });

    $(document.body).click(function(){ 
     closeInactivePop();
    });
    // toggle that pop
    $(".pop_toggle").click(function(){
      $(this).parent(settings.pop_class).toggleClass("active");
    });
  }

})(jQuery);

/*!
 * jQuery Cycle Plugin (with Transition Definitions)
 * Examples and documentation at: http://jquery.malsup.com/cycle/
 * Copyright (c) 2007-2010 M. Alsup
 * Version: 2.86 (05-APR-2010)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * Requires: jQuery v1.2.6 or later
 */
;(function($) {

var ver = '2.86';

// if $.support is not defined (pre jQuery 1.3) add what I need
if ($.support == undefined) {
	$.support = {
		opacity: !($.browser.msie)
	};
}

function debug(s) {
	if ($.fn.cycle.debug)
		log(s);
}		
function log() {
	if (window.console && window.console.log)
		window.console.log('[cycle] ' + Array.prototype.join.call(arguments,' '));
};

// the options arg can be...
//   a number  - indicates an immediate transition should occur to the given slide index
//   a string  - 'pause', 'resume', 'toggle', 'next', 'prev', 'stop', 'destroy' or the name of a transition effect (ie, 'fade', 'zoom', etc)
//   an object - properties to control the slideshow
//
// the arg2 arg can be...
//   the name of an fx (only used in conjunction with a numeric value for 'options')
//   the value true (only used in first arg == 'resume') and indicates
//	 that the resume should occur immediately (not wait for next timeout)

$.fn.cycle = function(options, arg2) {
	var o = { s: this.selector, c: this.context };

	// in 1.3+ we can fix mistakes with the ready state
	if (this.length === 0 && options != 'stop') {
		if (!$.isReady && o.s) {
			log('DOM not ready, queuing slideshow');
			$(function() {
				$(o.s,o.c).cycle(options,arg2);
			});
			return this;
		}
		// is your DOM ready?  http://docs.jquery.com/Tutorials:Introducing_$(document).ready()
		log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)'));
		return this;
	}

	// iterate the matched nodeset
	return this.each(function() {
		var opts = handleArguments(this, options, arg2);
		if (opts === false)
			return;

		opts.updateActivePagerLink = opts.updateActivePagerLink || $.fn.cycle.updateActivePagerLink;
		
		// stop existing slideshow for this container (if there is one)
		if (this.cycleTimeout)
			clearTimeout(this.cycleTimeout);
		this.cycleTimeout = this.cyclePause = 0;

		var $cont = $(this);
		var $slides = opts.slideExpr ? $(opts.slideExpr, this) : $cont.children();
		var els = $slides.get();
		if (els.length < 2) {
			log('terminating; too few slides: ' + els.length);
			return;
		}

		var opts2 = buildOptions($cont, $slides, els, opts, o);
		if (opts2 === false)
			return;

		var startTime = opts2.continuous ? 10 : getTimeout(opts2.currSlide, opts2.nextSlide, opts2, !opts2.rev);

		// if it's an auto slideshow, kick it off
		if (startTime) {
			startTime += (opts2.delay || 0);
			if (startTime < 10)
				startTime = 10;
			debug('first timeout: ' + startTime);
			this.cycleTimeout = setTimeout(function(){go(els,opts2,0,!opts2.rev)}, startTime);
		}
	});
};

// process the args that were passed to the plugin fn
function handleArguments(cont, options, arg2) {
	if (cont.cycleStop == undefined)
		cont.cycleStop = 0;
	if (options === undefined || options === null)
		options = {};
	if (options.constructor == String) {
		switch(options) {
		case 'destroy':
		case 'stop':
			var opts = $(cont).data('cycle.opts');
			if (!opts)
				return false;
			cont.cycleStop++; // callbacks look for change
			if (cont.cycleTimeout)
				clearTimeout(cont.cycleTimeout);
			cont.cycleTimeout = 0;
			$(cont).removeData('cycle.opts');
			if (options == 'destroy')
				destroy(opts);
			return false;
		case 'toggle':
			cont.cyclePause = (cont.cyclePause === 1) ? 0 : 1;
			checkInstantResume(cont.cyclePause, arg2, cont);
			return false;
		case 'pause':
			cont.cyclePause = 1;
			return false;
		case 'resume':
			cont.cyclePause = 0;
			checkInstantResume(false, arg2, cont);
			return false;
		case 'prev':
		case 'next':
			var opts = $(cont).data('cycle.opts');
			if (!opts) {
				log('options not found, "prev/next" ignored');
				return false;
			}
			$.fn.cycle[options](opts);
			return false;
		default:
			options = { fx: options };
		};
		return options;
	}
	else if (options.constructor == Number) {
		// go to the requested slide
		var num = options;
		options = $(cont).data('cycle.opts');
		if (!options) {
			log('options not found, can not advance slide');
			return false;
		}
		if (num < 0 || num >= options.elements.length) {
			log('invalid slide index: ' + num);
			return false;
		}
		options.nextSlide = num;
		if (cont.cycleTimeout) {
			clearTimeout(cont.cycleTimeout);
			cont.cycleTimeout = 0;
		}
		if (typeof arg2 == 'string')
			options.oneTimeFx = arg2;
		go(options.elements, options, 1, num >= options.currSlide);
		return false;
	}
	return options;
	
	function checkInstantResume(isPaused, arg2, cont) {
		if (!isPaused && arg2 === true) { // resume now!
			var options = $(cont).data('cycle.opts');
			if (!options) {
				log('options not found, can not resume');
				return false;
			}
			if (cont.cycleTimeout) {
				clearTimeout(cont.cycleTimeout);
				cont.cycleTimeout = 0;
			}
			go(options.elements, options, 1, 1);
		}
	}
};

function removeFilter(el, opts) {
	if (!$.support.opacity && opts.cleartype && el.style.filter) {
		try { el.style.removeAttribute('filter'); }
		catch(smother) {} // handle old opera versions
	}
};

// unbind event handlers
function destroy(opts) {
	if (opts.next)
		$(opts.next).unbind(opts.prevNextEvent);
	if (opts.prev)
		$(opts.prev).unbind(opts.prevNextEvent);
	
	if (opts.pager || opts.pagerAnchorBuilder)
		$.each(opts.pagerAnchors || [], function() {
			this.unbind().remove();
		});
	opts.pagerAnchors = null;
	if (opts.destroy) // callback
		opts.destroy(opts);
};

// one-time initialization
function buildOptions($cont, $slides, els, options, o) {
	// support metadata plugin (v1.0 and v2.0)
	var opts = $.extend({}, $.fn.cycle.defaults, options || {}, $.metadata ? $cont.metadata() : $.meta ? $cont.data() : {});
	if (opts.autostop)
		opts.countdown = opts.autostopCount || els.length;

	var cont = $cont[0];
	$cont.data('cycle.opts', opts);
	opts.$cont = $cont;
	opts.stopCount = cont.cycleStop;
	opts.elements = els;
	opts.before = opts.before ? [opts.before] : [];
	opts.after = opts.after ? [opts.after] : [];
	opts.after.unshift(function(){ opts.busy=0; });

	// push some after callbacks
	if (!$.support.opacity && opts.cleartype)
		opts.after.push(function() { removeFilter(this, opts); });
	if (opts.continuous)
		opts.after.push(function() { go(els,opts,0,!opts.rev); });

	saveOriginalOpts(opts);

	// clearType corrections
	if (!$.support.opacity && opts.cleartype && !opts.cleartypeNoBg)
		clearTypeFix($slides);

	// container requires non-static position so that slides can be position within
	if ($cont.css('position') == 'static')
		$cont.css('position', 'relative');
	if (opts.width)
		$cont.width(opts.width);
	if (opts.height && opts.height != 'auto')
		$cont.height(opts.height);

	if (opts.startingSlide)
		opts.startingSlide = parseInt(opts.startingSlide);

	// if random, mix up the slide array
	if (opts.random) {
		opts.randomMap = [];
		for (var i = 0; i < els.length; i++)
			opts.randomMap.push(i);
		opts.randomMap.sort(function(a,b) {return Math.random() - 0.5;});
		opts.randomIndex = 1;
		opts.startingSlide = opts.randomMap[1];
	}
	else if (opts.startingSlide >= els.length)
		opts.startingSlide = 0; // catch bogus input
	opts.currSlide = opts.startingSlide || 0;
	var first = opts.startingSlide;

	// set position and zIndex on all the slides
	$slides.css({position: 'absolute', top:0, left:0}).hide().each(function(i) {
		var z = first ? i >= first ? els.length - (i-first) : first-i : els.length-i;
		$(this).css('z-index', z)
	});

	// make sure first slide is visible
	$(els[first]).css('opacity',1).show(); // opacity bit needed to handle restart use case
	removeFilter(els[first], opts);

	// stretch slides
	if (opts.fit && opts.width)
		$slides.width(opts.width);
	if (opts.fit && opts.height && opts.height != 'auto')
		$slides.height(opts.height);

	// stretch container
	var reshape = opts.containerResize && !$cont.innerHeight();
	if (reshape) { // do this only if container has no size http://tinyurl.com/da2oa9
		var maxw = 0, maxh = 0;
		for(var j=0; j < els.length; j++) {
			var $e = $(els[j]), e = $e[0], w = $e.outerWidth(), h = $e.outerHeight();
			if (!w) w = e.offsetWidth || e.width || $e.attr('width')
			if (!h) h = e.offsetHeight || e.height || $e.attr('height');
			maxw = w > maxw ? w : maxw;
			maxh = h > maxh ? h : maxh;
		}
		if (maxw > 0 && maxh > 0)
			$cont.css({width:maxw+'px',height:maxh+'px'});
	}

	if (opts.pause)
		$cont.hover(function(){this.cyclePause++;},function(){this.cyclePause--;});

	if (supportMultiTransitions(opts) === false)
		return false;

	// apparently a lot of people use image slideshows without height/width attributes on the images.
	// Cycle 2.50+ requires the sizing info for every slide; this block tries to deal with that.
	var requeue = false;
	options.requeueAttempts = options.requeueAttempts || 0;
	$slides.each(function() {
		// try to get height/width of each slide
		var $el = $(this);
		this.cycleH = (opts.fit && opts.height) ? opts.height : ($el.height() || this.offsetHeight || this.height || $el.attr('height') || 0);
		this.cycleW = (opts.fit && opts.width) ? opts.width : ($el.width() || this.offsetWidth || this.width || $el.attr('width') || 0);

		if ( $el.is('img') ) {
			// sigh..  sniffing, hacking, shrugging...  this crappy hack tries to account for what browsers do when
			// an image is being downloaded and the markup did not include sizing info (height/width attributes);
			// there seems to be some "default" sizes used in this situation
			var loadingIE	= ($.browser.msie  && this.cycleW == 28 && this.cycleH == 30 && !this.complete);
			var loadingFF	= ($.browser.mozilla && this.cycleW == 34 && this.cycleH == 19 && !this.complete);
			var loadingOp	= ($.browser.opera && ((this.cycleW == 42 && this.cycleH == 19) || (this.cycleW == 37 && this.cycleH == 17)) && !this.complete);
			var loadingOther = (this.cycleH == 0 && this.cycleW == 0 && !this.complete);
			// don't requeue for images that are still loading but have a valid size
			if (loadingIE || loadingFF || loadingOp || loadingOther) {
				if (o.s && opts.requeueOnImageNotLoaded && ++options.requeueAttempts < 100) { // track retry count so we don't loop forever
					log(options.requeueAttempts,' - img slide not loaded, requeuing slideshow: ', this.src, this.cycleW, this.cycleH);
					setTimeout(function() {$(o.s,o.c).cycle(options)}, opts.requeueTimeout);
					requeue = true;
					return false; // break each loop
				}
				else {
					log('could not determine size of image: '+this.src, this.cycleW, this.cycleH);
				}
			}
		}
		return true;
	});

	if (requeue)
		return false;

	opts.cssBefore = opts.cssBefore || {};
	opts.animIn = opts.animIn || {};
	opts.animOut = opts.animOut || {};

	$slides.not(':eq('+first+')').css(opts.cssBefore);
	if (opts.cssFirst)
		$($slides[first]).css(opts.cssFirst);

	if (opts.timeout) {
		opts.timeout = parseInt(opts.timeout);
		// ensure that timeout and speed settings are sane
		if (opts.speed.constructor == String)
			opts.speed = $.fx.speeds[opts.speed] || parseInt(opts.speed);
		if (!opts.sync)
			opts.speed = opts.speed / 2;
		
		var buffer = opts.fx == 'shuffle' ? 500 : 250;
		while((opts.timeout - opts.speed) < buffer) // sanitize timeout
			opts.timeout += opts.speed;
	}
	if (opts.easing)
		opts.easeIn = opts.easeOut = opts.easing;
	if (!opts.speedIn)
		opts.speedIn = opts.speed;
	if (!opts.speedOut)
		opts.speedOut = opts.speed;

	opts.slideCount = els.length;
	opts.currSlide = opts.lastSlide = first;
	if (opts.random) {
		if (++opts.randomIndex == els.length)
			opts.randomIndex = 0;
		opts.nextSlide = opts.randomMap[opts.randomIndex];
	}
	else
		opts.nextSlide = opts.startingSlide >= (els.length-1) ? 0 : opts.startingSlide+1;

	// run transition init fn
	if (!opts.multiFx) {
		var init = $.fn.cycle.transitions[opts.fx];
		if ($.isFunction(init))
			init($cont, $slides, opts);
		else if (opts.fx != 'custom' && !opts.multiFx) {
			log('unknown transition: ' + opts.fx,'; slideshow terminating');
			return false;
		}
	}

	// fire artificial events
	var e0 = $slides[first];
	if (opts.before.length)
		opts.before[0].apply(e0, [e0, e0, opts, true]);
	if (opts.after.length > 1)
		opts.after[1].apply(e0, [e0, e0, opts, true]);

	if (opts.next)
		$(opts.next).bind(opts.prevNextEvent,function(){return advance(opts,opts.rev?-1:1)});
	if (opts.prev)
		$(opts.prev).bind(opts.prevNextEvent,function(){return advance(opts,opts.rev?1:-1)});
	if (opts.pager || opts.pagerAnchorBuilder)
		buildPager(els,opts);

	exposeAddSlide(opts, els);

	return opts;
};

// save off original opts so we can restore after clearing state
function saveOriginalOpts(opts) {
	opts.original = { before: [], after: [] };
	opts.original.cssBefore = $.extend({}, opts.cssBefore);
	opts.original.cssAfter  = $.extend({}, opts.cssAfter);
	opts.original.animIn	= $.extend({}, opts.animIn);
	opts.original.animOut   = $.extend({}, opts.animOut);
	$.each(opts.before, function() { opts.original.before.push(this); });
	$.each(opts.after,  function() { opts.original.after.push(this); });
};

function supportMultiTransitions(opts) {
	var i, tx, txs = $.fn.cycle.transitions;
	// look for multiple effects
	if (opts.fx.indexOf(',') > 0) {
		opts.multiFx = true;
		opts.fxs = opts.fx.replace(/\s*/g,'').split(',');
		// discard any bogus effect names
		for (i=0; i < opts.fxs.length; i++) {
			var fx = opts.fxs[i];
			tx = txs[fx];
			if (!tx || !txs.hasOwnProperty(fx) || !$.isFunction(tx)) {
				log('discarding unknown transition: ',fx);
				opts.fxs.splice(i,1);
				i--;
			}
		}
		// if we have an empty list then we threw everything away!
		if (!opts.fxs.length) {
			log('No valid transitions named; slideshow terminating.');
			return false;
		}
	}
	else if (opts.fx == 'all') {  // auto-gen the list of transitions
		opts.multiFx = true;
		opts.fxs = [];
		for (p in txs) {
			tx = txs[p];
			if (txs.hasOwnProperty(p) && $.isFunction(tx))
				opts.fxs.push(p);
		}
	}
	if (opts.multiFx && opts.randomizeEffects) {
		// munge the fxs array to make effect selection random
		var r1 = Math.floor(Math.random() * 20) + 30;
		for (i = 0; i < r1; i++) {
			var r2 = Math.floor(Math.random() * opts.fxs.length);
			opts.fxs.push(opts.fxs.splice(r2,1)[0]);
		}
		debug('randomized fx sequence: ',opts.fxs);
	}
	return true;
};

// provide a mechanism for adding slides after the slideshow has started
function exposeAddSlide(opts, els) {
	opts.addSlide = function(newSlide, prepend) {
		var $s = $(newSlide), s = $s[0];
		if (!opts.autostopCount)
			opts.countdown++;
		els[prepend?'unshift':'push'](s);
		if (opts.els)
			opts.els[prepend?'unshift':'push'](s); // shuffle needs this
		opts.slideCount = els.length;

		$s.css('position','absolute');
		$s[prepend?'prependTo':'appendTo'](opts.$cont);

		if (prepend) {
			opts.currSlide++;
			opts.nextSlide++;
		}

		if (!$.support.opacity && opts.cleartype && !opts.cleartypeNoBg)
			clearTypeFix($s);

		if (opts.fit && opts.width)
			$s.width(opts.width);
		if (opts.fit && opts.height && opts.height != 'auto')
			$slides.height(opts.height);
		s.cycleH = (opts.fit && opts.height) ? opts.height : $s.height();
		s.cycleW = (opts.fit && opts.width) ? opts.width : $s.width();

		$s.css(opts.cssBefore);

		if (opts.pager || opts.pagerAnchorBuilder)
			$.fn.cycle.createPagerAnchor(els.length-1, s, $(opts.pager), els, opts);

		if ($.isFunction(opts.onAddSlide))
			opts.onAddSlide($s);
		else
			$s.hide(); // default behavior
	};
}

// reset internal state; we do this on every pass in order to support multiple effects
$.fn.cycle.resetState = function(opts, fx) {
	fx = fx || opts.fx;

	opts.before = []; opts.after = [];
	opts.cssBefore = $.extend({}, opts.original.cssBefore);
	opts.cssAfter  = $.extend({}, opts.original.cssAfter);
	opts.animIn	= $.extend({}, opts.original.animIn);
	opts.animOut   = $.extend({}, opts.original.animOut);
	opts.fxFn = null;
	$.each(opts.original.before, function() { opts.before.push(this); });
	$.each(opts.original.after,  function() { opts.after.push(this); });

	// re-init
	var init = $.fn.cycle.transitions[fx];
	if ($.isFunction(init))
		init(opts.$cont, $(opts.elements), opts);
};

// this is the main engine fn, it handles the timeouts, callbacks and slide index mgmt
function go(els, opts, manual, fwd) {
	// opts.busy is true if we're in the middle of an animation
	if (manual && opts.busy && opts.manualTrump) {
		// let manual transitions requests trump active ones
		debug('manualTrump in go(), stopping active transition');
		$(els).stop(true,true);
		opts.busy = false;
	}
	// don't begin another timeout-based transition if there is one active
	if (opts.busy) {
		debug('transition active, ignoring new tx request');
		return;
	}

	var p = opts.$cont[0], curr = els[opts.currSlide], next = els[opts.nextSlide];

	// stop cycling if we have an outstanding stop request
	if (p.cycleStop != opts.stopCount || p.cycleTimeout === 0 && !manual)
		return;

	// check to see if we should stop cycling based on autostop options
	if (!manual && !p.cyclePause &&
		((opts.autostop && (--opts.countdown <= 0)) ||
		(opts.nowrap && !opts.random && opts.nextSlide < opts.currSlide))) {
		if (opts.end)
			opts.end(opts);
		return;
	}

	// if slideshow is paused, only transition on a manual trigger
	var changed = false;
	if ((manual || !p.cyclePause) && (opts.nextSlide != opts.currSlide)) {
		changed = true;
		var fx = opts.fx;
		// keep trying to get the slide size if we don't have it yet
		curr.cycleH = curr.cycleH || $(curr).height();
		curr.cycleW = curr.cycleW || $(curr).width();
		next.cycleH = next.cycleH || $(next).height();
		next.cycleW = next.cycleW || $(next).width();

		// support multiple transition types
		if (opts.multiFx) {
			if (opts.lastFx == undefined || ++opts.lastFx >= opts.fxs.length)
				opts.lastFx = 0;
			fx = opts.fxs[opts.lastFx];
			opts.currFx = fx;
		}

		// one-time fx overrides apply to:  $('div').cycle(3,'zoom');
		if (opts.oneTimeFx) {
			fx = opts.oneTimeFx;
			opts.oneTimeFx = null;
		}

		$.fn.cycle.resetState(opts, fx);

		// run the before callbacks
		if (opts.before.length)
			$.each(opts.before, function(i,o) {
				if (p.cycleStop != opts.stopCount) return;
				o.apply(next, [curr, next, opts, fwd]);
			});

		// stage the after callacks
		var after = function() {
			$.each(opts.after, function(i,o) {
				if (p.cycleStop != opts.stopCount) return;
				o.apply(next, [curr, next, opts, fwd]);
			});
		};

		debug('tx firing; currSlide: ' + opts.currSlide + '; nextSlide: ' + opts.nextSlide);
		
		// get ready to perform the transition
		opts.busy = 1;
		if (opts.fxFn) // fx function provided?
			opts.fxFn(curr, next, opts, after, fwd, manual && opts.fastOnEvent);
		else if ($.isFunction($.fn.cycle[opts.fx])) // fx plugin ?
			$.fn.cycle[opts.fx](curr, next, opts, after, fwd, manual && opts.fastOnEvent);
		else
			$.fn.cycle.custom(curr, next, opts, after, fwd, manual && opts.fastOnEvent);
	}

	if (changed || opts.nextSlide == opts.currSlide) {
		// calculate the next slide
		opts.lastSlide = opts.currSlide;
		if (opts.random) {
			opts.currSlide = opts.nextSlide;
			if (++opts.randomIndex == els.length)
				opts.randomIndex = 0;
			opts.nextSlide = opts.randomMap[opts.randomIndex];
			if (opts.nextSlide == opts.currSlide)
				opts.nextSlide = (opts.currSlide == opts.slideCount - 1) ? 0 : opts.currSlide + 1;
		}
		else { // sequence
			var roll = (opts.nextSlide + 1) == els.length;
			opts.nextSlide = roll ? 0 : opts.nextSlide+1;
			opts.currSlide = roll ? els.length-1 : opts.nextSlide-1;
		}
	}
	if (changed && opts.pager)
		opts.updateActivePagerLink(opts.pager, opts.currSlide, opts.activePagerClass);
	
	// stage the next transition
	var ms = 0;
	if (opts.timeout && !opts.continuous)
		ms = getTimeout(curr, next, opts, fwd);
	else if (opts.continuous && p.cyclePause) // continuous shows work off an after callback, not this timer logic
		ms = 10;
	if (ms > 0)
		p.cycleTimeout = setTimeout(function(){ go(els, opts, 0, !opts.rev) }, ms);
};

// invoked after transition
$.fn.cycle.updateActivePagerLink = function(pager, currSlide, clsName) {
   $(pager).each(function() {
       $(this).children().removeClass(clsName).eq(currSlide).addClass(clsName);
   });
};

// calculate timeout value for current transition
function getTimeout(curr, next, opts, fwd) {
	if (opts.timeoutFn) {
		// call user provided calc fn
		var t = opts.timeoutFn(curr,next,opts,fwd);
		while ((t - opts.speed) < 250) // sanitize timeout
			t += opts.speed;
		debug('calculated timeout: ' + t + '; speed: ' + opts.speed);
		if (t !== false)
			return t;
	}
	return opts.timeout;
};

// expose next/prev function, caller must pass in state
$.fn.cycle.next = function(opts) { advance(opts, opts.rev?-1:1); };
$.fn.cycle.prev = function(opts) { advance(opts, opts.rev?1:-1);};

// advance slide forward or back
function advance(opts, val) {
	var els = opts.elements;
	var p = opts.$cont[0], timeout = p.cycleTimeout;
	if (timeout) {
		clearTimeout(timeout);
		p.cycleTimeout = 0;
	}
	if (opts.random && val < 0) {
		// move back to the previously display slide
		opts.randomIndex--;
		if (--opts.randomIndex == -2)
			opts.randomIndex = els.length-2;
		else if (opts.randomIndex == -1)
			opts.randomIndex = els.length-1;
		opts.nextSlide = opts.randomMap[opts.randomIndex];
	}
	else if (opts.random) {
		opts.nextSlide = opts.randomMap[opts.randomIndex];
	}
	else {
		opts.nextSlide = opts.currSlide + val;
		if (opts.nextSlide < 0) {
			if (opts.nowrap) return false;
			opts.nextSlide = els.length - 1;
		}
		else if (opts.nextSlide >= els.length) {
			if (opts.nowrap) return false;
			opts.nextSlide = 0;
		}
	}

	var cb = opts.onPrevNextEvent || opts.prevNextClick; // prevNextClick is deprecated
	if ($.isFunction(cb))
		cb(val > 0, opts.nextSlide, els[opts.nextSlide]);
	go(els, opts, 1, val>=0);
	return false;
};

function buildPager(els, opts) {
	var $p = $(opts.pager);
	$.each(els, function(i,o) {
		$.fn.cycle.createPagerAnchor(i,o,$p,els,opts);
	});
	opts.updateActivePagerLink(opts.pager, opts.startingSlide, opts.activePagerClass);
};

$.fn.cycle.createPagerAnchor = function(i, el, $p, els, opts) {
	var a;
	if ($.isFunction(opts.pagerAnchorBuilder)) {
		a = opts.pagerAnchorBuilder(i,el);
		debug('pagerAnchorBuilder('+i+', el) returned: ' + a);
	}
	else
		a = '<a href="#">'+(i+1)+'</a>';
		
	if (!a)
		return;
	var $a = $(a);
	// don't reparent if anchor is in the dom
	if ($a.parents('body').length === 0) {
		var arr = [];
		if ($p.length > 1) {
			$p.each(function() {
				var $clone = $a.clone(true);
				$(this).append($clone);
				arr.push($clone[0]);
			});
			$a = $(arr);
		}
		else {
			$a.appendTo($p);
		}
	}

	opts.pagerAnchors =  opts.pagerAnchors || [];
	opts.pagerAnchors.push($a);
	$a.bind(opts.pagerEvent, function(e) {
		e.preventDefault();
		opts.nextSlide = i;
		var p = opts.$cont[0], timeout = p.cycleTimeout;
		if (timeout) {
			clearTimeout(timeout);
			p.cycleTimeout = 0;
		}
		var cb = opts.onPagerEvent || opts.pagerClick; // pagerClick is deprecated
		if ($.isFunction(cb))
			cb(opts.nextSlide, els[opts.nextSlide]);
		go(els,opts,1,opts.currSlide < i); // trigger the trans
//		return false; // <== allow bubble
	});
	
	if ( ! /^click/.test(opts.pagerEvent) && !opts.allowPagerClickBubble)
		$a.bind('click.cycle', function(){return false;}); // suppress click
	
	if (opts.pauseOnPagerHover)
		$a.hover(function() { opts.$cont[0].cyclePause++; }, function() { opts.$cont[0].cyclePause--; } );
};

// helper fn to calculate the number of slides between the current and the next
$.fn.cycle.hopsFromLast = function(opts, fwd) {
	var hops, l = opts.lastSlide, c = opts.currSlide;
	if (fwd)
		hops = c > l ? c - l : opts.slideCount - l;
	else
		hops = c < l ? l - c : l + opts.slideCount - c;
	return hops;
};

// fix clearType problems in ie6 by setting an explicit bg color
// (otherwise text slides look horrible during a fade transition)
function clearTypeFix($slides) {
	debug('applying clearType background-color hack');
	function hex(s) {
		s = parseInt(s).toString(16);
		return s.length < 2 ? '0'+s : s;
	};
	function getBg(e) {
		for ( ; e && e.nodeName.toLowerCase() != 'html'; e = e.parentNode) {
			var v = $.css(e,'background-color');
			if (v.indexOf('rgb') >= 0 ) {
				var rgb = v.match(/\d+/g);
				return '#'+ hex(rgb[0]) + hex(rgb[1]) + hex(rgb[2]);
			}
			if (v && v != 'transparent')
				return v;
		}
		return '#ffffff';
	};
	$slides.each(function() { $(this).css('background-color', getBg(this)); });
};

// reset common props before the next transition
$.fn.cycle.commonReset = function(curr,next,opts,w,h,rev) {
	$(opts.elements).not(curr).hide();
	opts.cssBefore.opacity = 1;
	opts.cssBefore.display = 'block';
	if (w !== false && next.cycleW > 0)
		opts.cssBefore.width = next.cycleW;
	if (h !== false && next.cycleH > 0)
		opts.cssBefore.height = next.cycleH;
	opts.cssAfter = opts.cssAfter || {};
	opts.cssAfter.display = 'none';
	$(curr).css('zIndex',opts.slideCount + (rev === true ? 1 : 0));
	$(next).css('zIndex',opts.slideCount + (rev === true ? 0 : 1));
};

// the actual fn for effecting a transition
$.fn.cycle.custom = function(curr, next, opts, cb, fwd, speedOverride) {
	var $l = $(curr), $n = $(next);
	var speedIn = opts.speedIn, speedOut = opts.speedOut, easeIn = opts.easeIn, easeOut = opts.easeOut;
	$n.css(opts.cssBefore);
	if (speedOverride) {
		if (typeof speedOverride == 'number')
			speedIn = speedOut = speedOverride;
		else
			speedIn = speedOut = 1;
		easeIn = easeOut = null;
	}
	var fn = function() {$n.animate(opts.animIn, speedIn, easeIn, cb)};
	$l.animate(opts.animOut, speedOut, easeOut, function() {
		if (opts.cssAfter) $l.css(opts.cssAfter);
		if (!opts.sync) fn();
	});
	if (opts.sync) fn();
};

// transition definitions - only fade is defined here, transition pack defines the rest
$.fn.cycle.transitions = {
	fade: function($cont, $slides, opts) {
		$slides.not(':eq('+opts.currSlide+')').css('opacity',0);
		opts.before.push(function(curr,next,opts) {
			$.fn.cycle.commonReset(curr,next,opts);
			opts.cssBefore.opacity = 0;
		});
		opts.animIn	   = { opacity: 1 };
		opts.animOut   = { opacity: 0 };
		opts.cssBefore = { top: 0, left: 0 };
	}
};

$.fn.cycle.ver = function() { return ver; };

// override these globally if you like (they are all optional)
$.fn.cycle.defaults = {
	fx:			  'fade', // name of transition effect (or comma separated names, ex: 'fade,scrollUp,shuffle')
	timeout:	   4000,  // milliseconds between slide transitions (0 to disable auto advance)
	timeoutFn:     null,  // callback for determining per-slide timeout value:  function(currSlideElement, nextSlideElement, options, forwardFlag)
	continuous:	   0,	  // true to start next transition immediately after current one completes
	speed:		   1000,  // speed of the transition (any valid fx speed value)
	speedIn:	   null,  // speed of the 'in' transition
	speedOut:	   null,  // speed of the 'out' transition
	next:		   null,  // selector for element to use as event trigger for next slide
	prev:		   null,  // selector for element to use as event trigger for previous slide
//	prevNextClick: null,  // @deprecated; please use onPrevNextEvent instead
	onPrevNextEvent: null,  // callback fn for prev/next events: function(isNext, zeroBasedSlideIndex, slideElement)
	prevNextEvent:'click.cycle',// event which drives the manual transition to the previous or next slide
	pager:		   null,  // selector for element to use as pager container
	//pagerClick   null,  // @deprecated; please use onPagerEvent instead
	onPagerEvent:  null,  // callback fn for pager events: function(zeroBasedSlideIndex, slideElement)
	pagerEvent:	  'click.cycle', // name of event which drives the pager navigation
	allowPagerClickBubble: false, // allows or prevents click event on pager anchors from bubbling
	pagerAnchorBuilder: null, // callback fn for building anchor links:  function(index, DOMelement)
	before:		   null,  // transition callback (scope set to element to be shown):	 function(currSlideElement, nextSlideElement, options, forwardFlag)
	after:		   null,  // transition callback (scope set to element that was shown):  function(currSlideElement, nextSlideElement, options, forwardFlag)
	end:		   null,  // callback invoked when the slideshow terminates (use with autostop or nowrap options): function(options)
	easing:		   null,  // easing method for both in and out transitions
	easeIn:		   null,  // easing for "in" transition
	easeOut:	   null,  // easing for "out" transition
	shuffle:	   null,  // coords for shuffle animation, ex: { top:15, left: 200 }
	animIn:		   null,  // properties that define how the slide animates in
	animOut:	   null,  // properties that define how the slide animates out
	cssBefore:	   null,  // properties that define the initial state of the slide before transitioning in
	cssAfter:	   null,  // properties that defined the state of the slide after transitioning out
	fxFn:		   null,  // function used to control the transition: function(currSlideElement, nextSlideElement, options, afterCalback, forwardFlag)
	height:		  'auto', // container height
	startingSlide: 0,	  // zero-based index of the first slide to be displayed
	sync:		   1,	  // true if in/out transitions should occur simultaneously
	random:		   0,	  // true for random, false for sequence (not applicable to shuffle fx)
	fit:		   0,	  // force slides to fit container
	containerResize: 1,	  // resize container to fit largest slide
	pause:		   0,	  // true to enable "pause on hover"
	pauseOnPagerHover: 0, // true to pause when hovering over pager link
	autostop:	   0,	  // true to end slideshow after X transitions (where X == slide count)
	autostopCount: 0,	  // number of transitions (optionally used with autostop to define X)
	delay:		   0,	  // additional delay (in ms) for first transition (hint: can be negative)
	slideExpr:	   null,  // expression for selecting slides (if something other than all children is required)
	cleartype:	   !$.support.opacity,  // true if clearType corrections should be applied (for IE)
	cleartypeNoBg: false, // set to true to disable extra cleartype fixing (leave false to force background color setting on slides)
	nowrap:		   0,	  // true to prevent slideshow from wrapping
	fastOnEvent:   0,	  // force fast transitions when triggered manually (via pager or prev/next); value == time in ms
	randomizeEffects: 1,  // valid when multiple effects are used; true to make the effect sequence random
	rev:		   0,	 // causes animations to transition in reverse
	manualTrump:   true,  // causes manual transition to stop an active transition instead of being ignored
	requeueOnImageNotLoaded: true, // requeue the slideshow if any image slides are not yet loaded
	requeueTimeout: 250,  // ms delay for requeue
	activePagerClass: 'activeSlide', // class name used for the active pager link
	updateActivePagerLink: null // callback fn invoked to update the active pager link (adds/removes activePagerClass style)
};

})(jQuery);


/*!
 * jQuery Cycle Plugin Transition Definitions
 * This script is a plugin for the jQuery Cycle Plugin
 * Examples and documentation at: http://malsup.com/jquery/cycle/
 * Copyright (c) 2007-2008 M. Alsup
 * Version:	 2.72
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
(function($) {

//
// These functions define one-time slide initialization for the named
// transitions. To save file size feel free to remove any of these that you
// don't need.
//
$.fn.cycle.transitions.none = function($cont, $slides, opts) {
	opts.fxFn = function(curr,next,opts,after){
		$(next).show();
		$(curr).hide();
		after();
	};
}

// scrollUp/Down/Left/Right
$.fn.cycle.transitions.scrollUp = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var h = $cont.height();
	opts.cssBefore ={ top: h, left: 0 };
	opts.cssFirst = { top: 0 };
	opts.animIn	  = { top: 0 };
	opts.animOut  = { top: -h };
};
$.fn.cycle.transitions.scrollDown = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var h = $cont.height();
	opts.cssFirst = { top: 0 };
	opts.cssBefore= { top: -h, left: 0 };
	opts.animIn	  = { top: 0 };
	opts.animOut  = { top: h };
};
$.fn.cycle.transitions.scrollLeft = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var w = $cont.width();
	opts.cssFirst = { left: 0 };
	opts.cssBefore= { left: w, top: 0 };
	opts.animIn	  = { left: 0 };
	opts.animOut  = { left: 0-w };
};
$.fn.cycle.transitions.scrollRight = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push($.fn.cycle.commonReset);
	var w = $cont.width();
	opts.cssFirst = { left: 0 };
	opts.cssBefore= { left: -w, top: 0 };
	opts.animIn	  = { left: 0 };
	opts.animOut  = { left: w };
};
$.fn.cycle.transitions.scrollHorz = function($cont, $slides, opts) {
	$cont.css('overflow','hidden').width();
	opts.before.push(function(curr, next, opts, fwd) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.cssBefore.left = fwd ? (next.cycleW-1) : (1-next.cycleW);
		opts.animOut.left = fwd ? -curr.cycleW : curr.cycleW;
	});
	opts.cssFirst = { left: 0 };
	opts.cssBefore= { top: 0 };
	opts.animIn   = { left: 0 };
	opts.animOut  = { top: 0 };
};
$.fn.cycle.transitions.scrollVert = function($cont, $slides, opts) {
	$cont.css('overflow','hidden');
	opts.before.push(function(curr, next, opts, fwd) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.cssBefore.top = fwd ? (1-next.cycleH) : (next.cycleH-1);
		opts.animOut.top = fwd ? curr.cycleH : -curr.cycleH;
	});
	opts.cssFirst = { top: 0 };
	opts.cssBefore= { left: 0 };
	opts.animIn   = { top: 0 };
	opts.animOut  = { left: 0 };
};

// slideX/slideY
$.fn.cycle.transitions.slideX = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$(opts.elements).not(curr).hide();
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.animIn.width = next.cycleW;
	});
	opts.cssBefore = { left: 0, top: 0, width: 0 };
	opts.animIn	 = { width: 'show' };
	opts.animOut = { width: 0 };
};
$.fn.cycle.transitions.slideY = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$(opts.elements).not(curr).hide();
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.animIn.height = next.cycleH;
	});
	opts.cssBefore = { left: 0, top: 0, height: 0 };
	opts.animIn	 = { height: 'show' };
	opts.animOut = { height: 0 };
};

// shuffle
$.fn.cycle.transitions.shuffle = function($cont, $slides, opts) {
	var i, w = $cont.css('overflow', 'visible').width();
	$slides.css({left: 0, top: 0});
	opts.before.push(function(curr,next,opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,true,true);
	});
	// only adjust speed once!
	if (!opts.speedAdjusted) {
		opts.speed = opts.speed / 2; // shuffle has 2 transitions
		opts.speedAdjusted = true;
	}
	opts.random = 0;
	opts.shuffle = opts.shuffle || {left:-w, top:15};
	opts.els = [];
	for (i=0; i < $slides.length; i++)
		opts.els.push($slides[i]);

	for (i=0; i < opts.currSlide; i++)
		opts.els.push(opts.els.shift());

	// custom transition fn (hat tip to Benjamin Sterling for this bit of sweetness!)
	opts.fxFn = function(curr, next, opts, cb, fwd) {
		var $el = fwd ? $(curr) : $(next);
		$(next).css(opts.cssBefore);
		var count = opts.slideCount;
		$el.animate(opts.shuffle, opts.speedIn, opts.easeIn, function() {
			var hops = $.fn.cycle.hopsFromLast(opts, fwd);
			for (var k=0; k < hops; k++)
				fwd ? opts.els.push(opts.els.shift()) : opts.els.unshift(opts.els.pop());
			if (fwd) {
				for (var i=0, len=opts.els.length; i < len; i++)
					$(opts.els[i]).css('z-index', len-i+count);
			}
			else {
				var z = $(curr).css('z-index');
				$el.css('z-index', parseInt(z)+1+count);
			}
			$el.animate({left:0, top:0}, opts.speedOut, opts.easeOut, function() {
				$(fwd ? this : curr).hide();
				if (cb) cb();
			});
		});
	};
	opts.cssBefore = { display: 'block', opacity: 1, top: 0, left: 0 };
};

// turnUp/Down/Left/Right
$.fn.cycle.transitions.turnUp = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.cssBefore.top = next.cycleH;
		opts.animIn.height = next.cycleH;
	});
	opts.cssFirst  = { top: 0 };
	opts.cssBefore = { left: 0, height: 0 };
	opts.animIn	   = { top: 0 };
	opts.animOut   = { height: 0 };
};
$.fn.cycle.transitions.turnDown = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.animIn.height = next.cycleH;
		opts.animOut.top   = curr.cycleH;
	});
	opts.cssFirst  = { top: 0 };
	opts.cssBefore = { left: 0, top: 0, height: 0 };
	opts.animOut   = { height: 0 };
};
$.fn.cycle.transitions.turnLeft = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.cssBefore.left = next.cycleW;
		opts.animIn.width = next.cycleW;
	});
	opts.cssBefore = { top: 0, width: 0  };
	opts.animIn	   = { left: 0 };
	opts.animOut   = { width: 0 };
};
$.fn.cycle.transitions.turnRight = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.animIn.width = next.cycleW;
		opts.animOut.left = curr.cycleW;
	});
	opts.cssBefore = { top: 0, left: 0, width: 0 };
	opts.animIn	   = { left: 0 };
	opts.animOut   = { width: 0 };
};

// zoom
$.fn.cycle.transitions.zoom = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,false,true);
		opts.cssBefore.top = next.cycleH/2;
		opts.cssBefore.left = next.cycleW/2;
		opts.animIn	   = { top: 0, left: 0, width: next.cycleW, height: next.cycleH };
		opts.animOut   = { width: 0, height: 0, top: curr.cycleH/2, left: curr.cycleW/2 };
	});
	opts.cssFirst = { top:0, left: 0 };
	opts.cssBefore = { width: 0, height: 0 };
};

// fadeZoom
$.fn.cycle.transitions.fadeZoom = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,false);
		opts.cssBefore.left = next.cycleW/2;
		opts.cssBefore.top = next.cycleH/2;
		opts.animIn	= { top: 0, left: 0, width: next.cycleW, height: next.cycleH };
	});
	opts.cssBefore = { width: 0, height: 0 };
	opts.animOut  = { opacity: 0 };
};

// blindX
$.fn.cycle.transitions.blindX = function($cont, $slides, opts) {
	var w = $cont.css('overflow','hidden').width();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.animIn.width = next.cycleW;
		opts.animOut.left   = curr.cycleW;
	});
	opts.cssBefore = { left: w, top: 0 };
	opts.animIn = { left: 0 };
	opts.animOut  = { left: w };
};
// blindY
$.fn.cycle.transitions.blindY = function($cont, $slides, opts) {
	var h = $cont.css('overflow','hidden').height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.animIn.height = next.cycleH;
		opts.animOut.top   = curr.cycleH;
	});
	opts.cssBefore = { top: h, left: 0 };
	opts.animIn = { top: 0 };
	opts.animOut  = { top: h };
};
// blindZ
$.fn.cycle.transitions.blindZ = function($cont, $slides, opts) {
	var h = $cont.css('overflow','hidden').height();
	var w = $cont.width();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		opts.animIn.height = next.cycleH;
		opts.animOut.top   = curr.cycleH;
	});
	opts.cssBefore = { top: h, left: w };
	opts.animIn = { top: 0, left: 0 };
	opts.animOut  = { top: h, left: w };
};

// growX - grow horizontally from centered 0 width
$.fn.cycle.transitions.growX = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true);
		opts.cssBefore.left = this.cycleW/2;
		opts.animIn = { left: 0, width: this.cycleW };
		opts.animOut = { left: 0 };
	});
	opts.cssBefore = { width: 0, top: 0 };
};
// growY - grow vertically from centered 0 height
$.fn.cycle.transitions.growY = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false);
		opts.cssBefore.top = this.cycleH/2;
		opts.animIn = { top: 0, height: this.cycleH };
		opts.animOut = { top: 0 };
	});
	opts.cssBefore = { height: 0, left: 0 };
};

// curtainX - squeeze in both edges horizontally
$.fn.cycle.transitions.curtainX = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,true,true);
		opts.cssBefore.left = next.cycleW/2;
		opts.animIn = { left: 0, width: this.cycleW };
		opts.animOut = { left: curr.cycleW/2, width: 0 };
	});
	opts.cssBefore = { top: 0, width: 0 };
};
// curtainY - squeeze in both edges vertically
$.fn.cycle.transitions.curtainY = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,false,true);
		opts.cssBefore.top = next.cycleH/2;
		opts.animIn = { top: 0, height: next.cycleH };
		opts.animOut = { top: curr.cycleH/2, height: 0 };
	});
	opts.cssBefore = { left: 0, height: 0 };
};

// cover - curr slide covered by next slide
$.fn.cycle.transitions.cover = function($cont, $slides, opts) {
	var d = opts.direction || 'left';
	var w = $cont.css('overflow','hidden').width();
	var h = $cont.height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts);
		if (d == 'right')
			opts.cssBefore.left = -w;
		else if (d == 'up')
			opts.cssBefore.top = h;
		else if (d == 'down')
			opts.cssBefore.top = -h;
		else
			opts.cssBefore.left = w;
	});
	opts.animIn = { left: 0, top: 0};
	opts.animOut = { opacity: 1 };
	opts.cssBefore = { top: 0, left: 0 };
};

// uncover - curr slide moves off next slide
$.fn.cycle.transitions.uncover = function($cont, $slides, opts) {
	var d = opts.direction || 'left';
	var w = $cont.css('overflow','hidden').width();
	var h = $cont.height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,true,true);
		if (d == 'right')
			opts.animOut.left = w;
		else if (d == 'up')
			opts.animOut.top = -h;
		else if (d == 'down')
			opts.animOut.top = h;
		else
			opts.animOut.left = -w;
	});
	opts.animIn = { left: 0, top: 0 };
	opts.animOut = { opacity: 1 };
	opts.cssBefore = { top: 0, left: 0 };
};

// toss - move top slide and fade away
$.fn.cycle.transitions.toss = function($cont, $slides, opts) {
	var w = $cont.css('overflow','visible').width();
	var h = $cont.height();
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,true,true,true);
		// provide default toss settings if animOut not provided
		if (!opts.animOut.left && !opts.animOut.top)
			opts.animOut = { left: w*2, top: -h/2, opacity: 0 };
		else
			opts.animOut.opacity = 0;
	});
	opts.cssBefore = { left: 0, top: 0 };
	opts.animIn = { left: 0 };
};

// wipe - clip animation
$.fn.cycle.transitions.wipe = function($cont, $slides, opts) {
	var w = $cont.css('overflow','hidden').width();
	var h = $cont.height();
	opts.cssBefore = opts.cssBefore || {};
	var clip;
	if (opts.clip) {
		if (/l2r/.test(opts.clip))
			clip = 'rect(0px 0px '+h+'px 0px)';
		else if (/r2l/.test(opts.clip))
			clip = 'rect(0px '+w+'px '+h+'px '+w+'px)';
		else if (/t2b/.test(opts.clip))
			clip = 'rect(0px '+w+'px 0px 0px)';
		else if (/b2t/.test(opts.clip))
			clip = 'rect('+h+'px '+w+'px '+h+'px 0px)';
		else if (/zoom/.test(opts.clip)) {
			var top = parseInt(h/2);
			var left = parseInt(w/2);
			clip = 'rect('+top+'px '+left+'px '+top+'px '+left+'px)';
		}
	}

	opts.cssBefore.clip = opts.cssBefore.clip || clip || 'rect(0px 0px 0px 0px)';

	var d = opts.cssBefore.clip.match(/(\d+)/g);
	var t = parseInt(d[0]), r = parseInt(d[1]), b = parseInt(d[2]), l = parseInt(d[3]);

	opts.before.push(function(curr, next, opts) {
		if (curr == next) return;
		var $curr = $(curr), $next = $(next);
		$.fn.cycle.commonReset(curr,next,opts,true,true,false);
		opts.cssAfter.display = 'block';

		var step = 1, count = parseInt((opts.speedIn / 13)) - 1;
		(function f() {
			var tt = t ? t - parseInt(step * (t/count)) : 0;
			var ll = l ? l - parseInt(step * (l/count)) : 0;
			var bb = b < h ? b + parseInt(step * ((h-b)/count || 1)) : h;
			var rr = r < w ? r + parseInt(step * ((w-r)/count || 1)) : w;
			$next.css({ clip: 'rect('+tt+'px '+rr+'px '+bb+'px '+ll+'px)' });
			(step++ <= count) ? setTimeout(f, 13) : $curr.css('display', 'none');
		})();
	});
	opts.cssBefore = { display: 'block', opacity: 1, top: 0, left: 0 };
	opts.animIn	   = { left: 0 };
	opts.animOut   = { left: 0 };
};

})(jQuery);
