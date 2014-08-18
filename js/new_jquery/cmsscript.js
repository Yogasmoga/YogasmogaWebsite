jQuery(window).load(function($){
	block66height();
	headingBlock();
	block66heightbottom();
	joybalanceheight();
	ysbannertxtheight();
	equalBlockImgH();
	block50height();
	uifixes();

	setTimeout(function(){
		block66height();
		headingBlock();
		block66heightbottom();
		joybalanceheight();
		ysbannertxtheight();
		equalBlockImgH();
		block50height();
		uifixes();
	},100);
});

jQuery(document).ready(function($){
	$(window).resize(function(){
		block66height();
		headingBlock();
		block66heightbottom();
		joybalanceheight();
		ysbannertxtheight();
		equalBlockImgH();
		block50height();
		uifixes();
	});

$("#workersgif").live('click', function(){
    if($(this).hasClass('workersgif')){
		var storeGifValue = $(this).data("gif");
		$(this).attr("src", storeGifValue);
		$(this).removeClass("workersgif");
		$(this).addClass("stopworkersgif"); 
    }
    else{
		var storeSrcValue = $(this).data("src");
		$(this).attr("src", storeSrcValue);
		$(this).removeClass("stopworkersgif");
		$(this).addClass("workersgif");
    }
});


$("#streamlined").live('click', function(){
    if($(this).hasClass('streamlined')){
		var streamGifValue = $(this).data("gif");
		$(this).attr("src", streamGifValue);
		$(this).removeClass("streamlined");
		$(this).addClass("stopstreamlined"); 
    }
    else{
		var streamSrcValue = $(this).data("src");
		$(this).attr("src", streamSrcValue);
		$(this).removeClass("stopstreamlined");
		$(this).addClass("streamlined");
    }
});


$("#footprints").live('click', function(){
    if($(this).hasClass('footprints')){
		var footGifValue = $(this).data("gif");
		$(this).attr("src", footGifValue);
		$(this).removeClass("footprints");
		$(this).addClass("stopfootprints"); 
    }
    else{
		var footSrcValue = $(this).data("src");
		$(this).attr("src", footSrcValue);
		$(this).removeClass("stopfootprints");
		$(this).addClass("footprints");
    }
});


$("#wages").live('click', function(){
    if($(this).hasClass('wages')){
		var wagesGifValue = $(this).data("gif");
		$(this).attr("src", wagesGifValue);
		$(this).removeClass("wages");
		$(this).addClass("stopwages"); 
    }
    else{
		var wagesSrcValue = $(this).data("src");
		$(this).attr("src", wagesSrcValue);
		$(this).removeClass("stopwages");
		$(this).addClass("wages");
    }
});

});

// CalcBlocksHeight
function block66height(){	
	var block66height = jQuery(".ystopsection .block66").height();
	jQuery(".ystopsection .block33").css("height", block66height);
};

function block50height(){	
	var block50height = jQuery(".eqaulcontbg #imgcontb2").height();
	jQuery(".eqaulcontbg #imgcontb1").css("height", block50height);

	var imgcontb1H = jQuery(".eqaulcontbg #imgcontb1").height();
	var blocktxtheight = jQuery(".eqaulcontbg #imgcontb1 .textContainer").height();
	var calcheightNamskr = imgcontb1H-blocktxtheight;
	calcheightNamskr = calcheightNamskr/1.8;
	jQuery(".eqaulcontbg #imgcontb1 .textContainer").css("top", calcheightNamskr);
};

function headingBlock(){
	var headingBlock = jQuery(".headingBlock").height();
	var headingh4 = jQuery(".headingBlock h4").height();
	var calcheight = headingBlock-headingh4;
	calcheight = calcheight/2;
	jQuery(".headingBlock h4").css("top", calcheight);
};

function block66heightbottom(){	
	var block66height = jQuery(".ysbottomsection .block66").height();
	jQuery(".ysbottomsection .block33").css("height", block66height);
};

function joybalanceheight(){
	var joybalanceheight = jQuery(".joybalance").height();
	var headingheight = jQuery(".joybalance .cntntheading").height();
	var calcheightt = joybalanceheight-headingheight;
	calcheightt = calcheightt/1.8;
	jQuery(".joybalance .cntntheading").css("top", calcheightt);
	jQuery(".joybalance .cntntheading").css("margin", '0');
};

function ysbannertxtheight(){
	var ysbannertxtheight = jQuery(".ystopsection .block66").height();
	// OurStory
	var ystxtheight = jQuery(".ystopsection #ysbannertxt").height();
	var calcheighttt = ysbannertxtheight-ystxtheight;
	calcheighttt = calcheighttt/1.24;
	jQuery(".ystopsection #ysbannertxt").css("top", calcheighttt);

	// CoreValues
	var ystxtheight2 = jQuery(".ystopsection #ysbannertxtTwo").height();
	var calcheight2 = ysbannertxtheight-ystxtheight2;
	calcheight2 = calcheight2/1.34;
	jQuery(".ystopsection #ysbannertxtTwo").css("top", calcheight2);

	// Ethics
	var ystxtheight3 = jQuery(".ystopsection #ysbannertxtThree").height();
	var calcheight3 = ysbannertxtheight-ystxtheight3;
	calcheight3 = calcheight3/1.23;
	jQuery(".ystopsection #ysbannertxtThree").css("top", calcheight3);

	// PrinciplesYoga
	var ystxtheight4 = jQuery(".ystopsection #ysbannertxtFour").height();
	var calcheight4 = ysbannertxtheight-ystxtheight4;
	calcheight4 = calcheight4/2.3;
	jQuery(".ystopsection #ysbannertxtFour").css("top", calcheight4);

	// NamaskarFoundation
	var ysbannertxtheightNamaskar = jQuery(".namaskarblock1 .block66").height();
	var ystxtheight5 = jQuery(".namaskarblock1 #ysbannertxtSix").height();
	var calcheight5 = ysbannertxtheightNamaskar-ystxtheight5;
	calcheight5 = calcheight5/2.3;
	jQuery(".namaskarblock1 #ysbannertxtSix").css("top", calcheight5);
};

function madeinusagifs(){
	jQuery(".madeinusagifcontainer").find(".img-responsive:nth-child(1)").each("click", function(){
		jQuery(".img-responsive:nth-child(2)").show();
		jQuery(this).hide();
	});
};

function equalBlockImgH(){
	var height = jQuery(".gridFullWidth .block30:first-child img.img-responsive").height();
	jQuery(".gridFullWidth .block30:last-child img.img-responsive").css("height", height);
};

function uifixes(){
	jQuery(".colorFilterGrid a").each(function(){		
		var colorBoxHeight = jQuery(this).height();
		var colorTextHeight = jQuery(this).find("span").height();
		var calcColorheight = colorBoxHeight-colorTextHeight;
		calcColorheight = calcColorheight/2;
		jQuery(this).find("span").css("padding-top", calcColorheight);	
	});
};