jQuery(window).load(function($){
	homeContent();
	homeContent1();
	compressBoxHeight();
	colorBoxHeight();
	factorypart();
	namaskarpart();
	// factorythreadHeight();

	setTimeout(function(){
		homeContent();
		homeContent1();
		compressBoxHeight();
		colorBoxHeight();
		factorypart();	
		namaskarpart();	
		ctextVMiddle();
	},100);
});

jQuery(document).ready(function($){
	sliderHomeBx();
	$(window).resize(function(){
		homeContent();
		homeContent1();
		compressBoxHeight();
		colorBoxHeight();
		factorypart();
		namaskarpart();	
		ctextVMiddle();	
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
	var sliderBoxHeight = jQuery(".ysfabricpart .grid65").height();
	jQuery(".ysfabricpart .grid35").css("height", sliderBoxHeight);
};

function colorBoxHeight(){
	var sliderBoxHeight2 = jQuery(".yscolorpart .grid65").height();
	jQuery(".yscolorpart .grid35").css("height", sliderBoxHeight2);
};

function factorypart(){
	
	var factoryHeight = jQuery(".factorypart .img-responsive").height();

	var mistext = jQuery(".mistext").height();
	var mstext = factoryHeight - mistext;
	mstext = mstext/2;
	
	jQuery(".mistext").css("top", mstext);
	jQuery(".factorypart .grid35").css("height", factoryHeight);
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
	var imgH = jQuery("ul.gridslider1 li:visible").height();
	var contH = jQuery(".ysfabricpart").find("ul.gridslider1 li:visible .sliderContent").height();

	var hvalue = imgH - contH;
	var vH = hvalue/2;
	console.log(imgH);
	console.log(contH);

	jQuery(".sliderContent").css("top", vH);
};

function homeContent1(){
	// verticle center
	var imgH1 = jQuery("ul.gridslider2 li:visible").height();
	var contH1 = jQuery(".yscolorpart").find("ul.gridslider2 li:visible .contentSlider").height();

	var hvalue1 = imgH1 - contH1;
	var vH1 = hvalue1/2;

	jQuery(".gridslider2 .contentSlider").css("top", vH1);
};

function ctextVMiddle(){
	jQuery(".compressBox .ctext, .multicolorcont .ctext, .factorythread .ctext, .raisingfunds .ctext").each(function(){
        var ctext_bl = jQuery(this).height();
        var parCtext = jQuery(this).parent().height();
        var topPosCtext = (parCtext - ctext_bl)/2;
        jQuery(this).css("top", topPosCtext);        
    }); 
}