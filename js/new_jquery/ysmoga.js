jQuery(window).load(function($){
	homeContent();
	compressBoxHeight();
	colorBoxHeight();
	factorypart();
	namaskarpart();

	setTimeout(function(){
		homeContent();
		compressBoxHeight();
		colorBoxHeight();
	},100);
});

jQuery(document).ready(function($){
	sliderHomeBx();
	$(window).resize(function(){
		homeContent();
		compressBoxHeight();
		colorBoxHeight();
		factorypart();
		namaskarpart();
	});	
});

// sliderFunction
function sliderHomeBx(){
	jQuery('.gridslider1').bxSlider({
		mode: 'fade',
		auto: true,
		autoControls: true,
		pause: 5000
	});

	jQuery('.gridslider2').bxSlider({
		mode: 'fade',
		auto: true,
		autoControls: true,
		pause: 2000
	});	
};

function compressBoxHeight(){
	var sliderBoxHeight = jQuery(".ysfabricpart").height();
	jQuery(".ysfabricpart .grid35").css("height", sliderBoxHeight);
};

function colorBoxHeight(){
	var sliderBoxHeight2 = jQuery(".yscolorpart").height();
	jQuery(".yscolorpart .grid35").css("height", sliderBoxHeight2);
};

function factorypart(){
	var factoryHeight = jQuery(".factorypart .img-responsive").height();

	var mistext = jQuery(".mistext").height();
	var mstext = factoryHeight - mistext;
	mstext = mstext/2;

	jQuery(".factorypart .grid35").css("height", factoryHeight);
	jQuery(".mistext").css("top", mstext);
};

function namaskarpart(){
	var namaskarHeight = jQuery(".namaskarpart .img-responsive").height();

	var namaskartxt = jQuery(".namaskartxt").height();
	var nmtxt = namaskarHeight - namaskartxt;
	nmtxt = nmtxt/2;

	jQuery(".namaskarpart .grid35").css("height", namaskarHeight);
	jQuery(".namaskartxt").css("top", nmtxt);
};

function homeContent(){
	// verticle center
	var imgH = jQuery(".gridslider1 .img-responsive").height();
	var contH = jQuery(".sliderContent").height();

	var hvalue = imgH - contH;
	var vH = hvalue/2;

	jQuery(".sliderContent").css("top", vH);
};