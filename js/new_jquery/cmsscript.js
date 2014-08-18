jQuery(window).load(function($){
	block66height();
	headingBlock();
	block66heightbottom();
	joybalanceheight();
	ysbannertxtheight();
	equalBlockImgH();
		block50height();
		uifixes();
	//madeinusagifs();

	setTimeout(function(){
		block66height();
		headingBlock();
		block66heightbottom();
		joybalanceheight();
		ysbannertxtheight();
		equalBlockImgH();
		block50height();
//		madeinusagifs();
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
//		madeinusagifs();
		uifixes();
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
	console.log(height);
	jQuery(".gridFullWidth .block30:last-child img.img-responsive").css("height", height);
	console.log(jQuery(".gridFullWidth .block30:last-child img.img-responsive").height());
};

function uifixes(){
	jQuery(".workersgif").click(function(){
		var storeGifValue = jQuery(this).attr("data-gif");
		jQuery(this).attr("src", storeGifValue);
		jQuery(this).addClass("stopworkersgif");
		jQuery(this).removeClass("workersgif");
	});
	jQuery(".stopworkersgif").click(function(){
		var storeSrcValue = jQuery(this).attr("data-src");
		jQuery(this).attr("src", storeSrcValue);
		jQuery(this).addClass("workersgif");
		jQuery(this).removeClass("stopworkersgif");
	});

	jQuery(".streamlined").click(function(){
		var storeGifValue1 = jQuery(this).attr("data-gif");
		jQuery(this).attr("src", storeGifValue1);
		jQuery(this).addClass("stopstreamlined");
		jQuery(this).removeClass("streamlined");
	});
	jQuery(".stopstreamlined").click(function(){
		var storeSrcValue1 = jQuery(this).attr("data-gif");
		jQuery(this).attr("src", storeSrcValue1);
		jQuery(this).addClass("streamlined");
		jQuery(this).removeClass("stopstreamlined");
	});

	jQuery(".footprints").click(function(){
		var storeGifValue2 = jQuery(this).attr("data-gif");
		jQuery(this).attr("src", storeGifValue2);
		jQuery(this).addClass("stopfootprints");
		jQuery(this).removeClass("footprints");
	});
	jQuery(".stopfootprints").click(function(){
		var storeSrcValue2 = jQuery(this).attr("data-gif");
		jQuery(this).attr("src", storeSrcValue2);
		jQuery(this).addClass("footprints");
		jQuery(this).removeClass("stopfootprints");
	});

	jQuery(".wages").click(function(){
		var storeGifValue3 = jQuery(this).attr("data-gif");
		jQuery(this).attr("src", storeGifValue3);
		jQuery(this).addClass("stopwages");
		jQuery(this).removeClass("wages");
	});
	jQuery(".stopwages").click(function(){
		var storeSrcValue3 = jQuery(this).attr("data-gif");
		jQuery(this).attr("src", storeSrcValue3);
		jQuery(this).addClass("wages");
		jQuery(this).removeClass("stopwages");
	});	
};