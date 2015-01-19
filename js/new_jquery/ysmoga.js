    	jQuery(window).load(function($){
	homeContent();
	homeContent1();
	compressBoxHeight();
	colorBoxHeight();
	factorypart();
	namaskarpart();
            jQuery(".share-strip, .new-arrivals-block").animate({"opacity":1},200);
            jQuery(window).trigger("resize");
	// factorythreadHeight();

	setTimeout(function(){
		jQuery(".cubix").animate({"opacity":1},200);	
		// ctextVMiddle();
	},500);
});

jQuery(document).ready(function($){
		jQuery('body').css('overflow','auto');
	    jQuery('.namaskar-overlay1').fadeOut('slow');
	$(window).resize(function(){			
		homeContent();
		homeContent1();
		compressBoxHeightRes();
		colorBoxHeight();
		factorypartRes();
		namaskarpartRes();	
		// ctextVMiddle();	
	});	
	sliderHomeBx();
});

// sliderFunction
function sliderHomeBx(){
	jQuery('.gridslider1').bxSlider({
		mode: 'fade',
		auto: true,
		autoControls: true,
		pause: 5000,
		speed: 1250		
	});

	jQuery('.gridslider2').bxSlider({
		mode: 'fade',
		auto: true,
		autoControls: true,
		pause: 5000,
		speed: 1250
	});	
};

function compressBoxHeight(){	
	setTimeout(function(){
	    compressBoxHeightRes();
    },500);
};
function compressBoxHeightRes(){
		var conWid = jQuery(".cubix").width();
		var bigSide = jQuery(".cubix .grid65").width();
		jQuery(".cubix .grid35").css({"width": conWid - bigSide,"position":"absolute"});		
		var isSafari = browserTest();
	 	var gd1 = jQuery(".ysfabricpart .sliderImg").height();
	 	jQuery(".ysfabricpart .compressBox").css("height", gd1/2);
	    var gd2 = jQuery(".ysfabricpart .compressBox").height();
	    var gdHeight = gd1-gd2;	    
	    // jQuery("div.text").html("fabricpar---" + gd1 + "----" + gd2 + "---" + "---" + gdHeight );	       
	    jQuery(".ysfabricpart .iconspartone").css("height", gdHeight);
	    // jQuery(".ysfabricpart").animate({"opacity":1});	 	    	       	    
}
function colorBoxHeight(){
	setTimeout(function(){
	   colorBoxHeightRes();
    },500);
};
function colorBoxHeightRes(){
	var gd1 = jQuery(".yscolorpart .sliderImg").height();
	jQuery(".yscolorpart .multicolorcont").css("height", gd1/2);
    var gd2 = jQuery(".yscolorpart .multicolorcont").height();	        
    var gdHeight = gd1-gd2;	    
    // jQuery("div.text").html("icons---" + gd1 + "----" + gd2 + "---" + "---" + gdHeight );	       
    jQuery(".yscolorpart .iconspartone").css("height", gdHeight);
    // jQuery(".yscolorpart").animate({"opacity":1});
}
function factorypart(){	
	setTimeout(function(){
	    factorypartRes();
    },500);

};
function factorypartRes(){
	jQuery(".factorypart .grid35").css("right",0);
	var gd1 = jQuery(".factorypart .img-responsive").height();
	jQuery(".factorypart .factorythread").css("height", gd1/2);
    var gd2 = jQuery(".factorypart .factorythread").height();
    var gdHeight = gd1-gd2;	    
    // jQuery("div.text").html("factory---" + gd1 + "----" + gd2 + "---" + "---" + gdHeight );	       
    jQuery(".factorypart .usamap").css("height", gdHeight);
    // jQuery(".factorypart").animate({"opacity":1});
}
function namaskarpart(){	
	 setTimeout(function(){
	    namaskarpartRes();
    },500);
};
function namaskarpartRes(){
	var gd1 = jQuery(".namaskarpart .img-responsive").height(); 
    jQuery(".namaskarpart .supportnamaskar").css("height", gd1/2);
    var gd2 = jQuery(".namaskarpart .supportnamaskar").height();
    var gdHeight = gd1-gd2;	    
    // jQuery("div.text").html("namaskar---" + gd1 + "----" + gd2 + "---" + "---" + gdHeight );	       
    jQuery(".namaskarpart .raisingfunds").css("height", gdHeight);
    // jQuery(".namaskarpart").animate({"opacity":1});    
}
function homeContent(){
	// verticle center
	var imgH = jQuery("ul.gridslider1 li:visible").height();
	var contH = jQuery(".ysfabricpart").find("ul.gridslider1 li:visible .sliderContent").height();

	var hvalue = imgH - contH;
	var vH = hvalue/1.5;

};

function homeContent1(){
	// verticle center
	var imgH1 = jQuery("ul.gridslider2 li:visible").height();
	var contH1 = jQuery(".yscolorpart").find("ul.gridslider2 li:visible .contentSlider").height();

	var hvalue1 = imgH1 - contH1;
	var vH1 = hvalue1/1.5;
//	vH1 = vH1+51;

	// jQuery(".gridslider2 .contentSlider").css("top", vH1);
};

function ctextVMiddle(){
	jQuery(".multicolorcont .ctext, .factorythread .ctext, .raisingfunds .ctext").each(function(){
        var ctext_bl = jQuery(this).height();
        var parCtext = jQuery(this).parent().height();
        var topPosCtext = (parCtext - ctext_bl)/1.5;
        jQuery(this).css("top", topPosCtext);        
    }); 
}
