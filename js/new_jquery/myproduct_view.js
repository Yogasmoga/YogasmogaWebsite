jQuery(document).ready(function($){
    setTimeout(function(){ resizeDesignFeatures(); }, 100);
    setTimeout(function(){ resizeProductBigImage(); }, 100);
    $(window).resize(function(){
        setTimeout(function(){ resizeDesignFeatures(); }, 100);
        setTimeout(function(){ resizeProductBigImage(); }, 100);
        //setTimeout(function(){ positiondesignfeatureheadimage(); }, 10);
        //positiondesignfeatureheadimage();
    });

    $("#zoomoptions").on("click","#zoomin",function(){
        $("td#zoomedproductimage img[zoomurl]").trigger("click");        
    });

    // $("table.normalproductdetail div#colorcontainer table").live("click", function(){
    //     $("table.normalproductdetail div#colorcontainer > div").removeClass("selected");
    //     $(this).parent("div").addClass("selected");
    // });
    
    
    $("table.productdesignfeatures div[size]").hover(function(){
        if($(this).find("div.caption").is(':animated'))
            return;
        $(this).find("div.caption").height();
        //$(this).find("div.caption").css('margin-top', ($(this).find("div.caption").height() * -1) + 'px');
        $(this).find("div.caption").animate({
            'margin-top': ($(this).find("div.caption").height() * -1)
        }, 300);
    },
    function(){
        //$(this).find("div.caption").css('margin-top', '0px');
        $(this).find("div.caption").animate({
            'margin-top': 0
        }, 300);
    });
    clearEmptycaptions();
    
    $("table.tdbigimagecontainer img").live("click", function(){
        console.log($(".zoom-prd-det").height());
        if(!_canzoomimages)
            return;
        jQuery("#productdetailpopup").html("<table style='width:100%;height : 100%;'><tr><td style='text-align:center;vertical-align:middle;'>Loading. .</td></tr></table>");
        jQuery("div.wrapper").addClass('overflowhidden');
        jQuery("div.wrapper, div.ui-widget-overlay").height(_winH + _headerHeight);
        $("#zoomedfbdtl").hide();
        jQuery( "#zoompopup" ).dialog( "open" );
        var color = jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("color");
        changezoomColor(jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("color"), true);
        setTimeout(function(){ 
            jQuery("div.wrapper").addClass('overflowhidden');
            jQuery("div.wrapper, div.ui-widget-overlay").height(_winH + _headerHeight);
        }, 300);
    });
    setTimeout(function(){ InitializeZoomPopup(); }, 500);
    
    $(window).resize(function(){
        setTimeout(function(){ InitializeZoomPopup(); }, 100);    
    });
    //positiondesignfeatureheadimage();    
    $("div#zoompopup img#closelightbox").live("click", function(){
        jQuery("#zoompopup").dialog( "close" );
    });
    
    $("table.zoomproductdetail div#colorcontainer table").live("click", function(){
        changezoomColor($(this).attr("color"), false, 0);
    });
    
    $("table.zoomproductdetail table.zoomsmallimagecontainer td:not(.selectedimage)").live("click", function(){
		$('div#zoomoptions').fadeOut(50);
        jQuery("table.zoomproductdetail table.zoomsmallimagecontainer td").removeClass('selectedimage');
        $(this).addClass('selectedimage');
        jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage1' zoomurl='" + $(this).attr("zoomimageurl") + "' src='" + $(this).attr("bigimageurl") + "' alt='" + $(this).find("img:first").attr("alt") + "' style='display:none;' />");
		$j('#zoomedimage1').on('load',function(){
			$j(this).fadeIn(250);
		})
        return;
        jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage' src='" + $(this).attr("zoomimageurl") + "' />");
		$("img#zoomedimage").on('load', function(){
			StartZooming();	
		});
    });
    
     $("div#zoompopup div#zoomoptions img#zoomin:not(.disabled)").mousedown(function(){
        $('#zoomedimage').smoothZoom('zoomIn');
        //console.log($('#zoomedimage').smoothZoom('getZoomData').ratio);
    });
    
    $("div#zoompopup div#zoomoptions img#zoomout:not(.disabled)").mousedown(function(){
        $('#zoomedimage').smoothZoom('zoomOut');
        
    });
	/*$('td#zoomedproductimage').mouseup(function(){
		if($(this).hasClass('canzoomin')){
			if($(this).hasClass('lev0')){
				$('#zoomedimage').smoothZoom('focusTo', {zoom: initialzoom});
				$(this).removeClass('lev0').addClass('lev1');
			}else{
				$('#zoomedimage').smoothZoom('zoomIn');
				$(this).removeClass('med').addClass('max');
			}
		}
	})
	
	
    /*$("div#zoompopup div.noSel.smooth_zoom_preloader").live('mousedown', function(e){
        _oldmousex = e.pageX;
        _oldmousey = e.pageY;
        //console.log(e.pageX +', '+ e.pageY);
    });
    $("div#zoompopup div.noSel.smooth_zoom_preloader").live('mouseup', function(e){
       if(e.pageX == _oldmousex && e.pageY == _oldmousey)
        {
            //console.log('clicked');
            if($("img#zoomedimage").hasClass('fabricimage'))
            {
                var scale = jQuery('#zoomedimage').smoothZoom('getZoomData').ratio;
                jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage' src='" + $("table.zoomproductdetail table.zoomsmallimagecontainer td.selectedimage").attr('zoomimageurl') + "' />");
                StartZooming(scale);
                //$("img#zoomedimage").attr("src",$("table.zoomproductdetail table.zoomsmallimagecontainer td.selectedimage").attr('zoomimageurl')).addClass('fabricimage');
//                $("img#zoomedimage").smoothZoom('focusTo',{
//                    zoom : 100
//                });
            }
            else
            {
                if(_fabrictechnologyimage != "")
                {
                    var temp = _fabrictechnologyimage.split('|');
                    var scale = jQuery('#zoomedimage').smoothZoom('getZoomData').ratio;
                    jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage' class='fabricimage' src='" + temp[0] + "' />");
                    StartZooming(scale);
                    //$("img#zoomedimage").attr("src",_fabrictechnologyimage).addClass('fabricimage');
//                    $("img#zoomedimage").smoothZoom('focusTo',{
//                        zoom : 100
//                    });
                }
            }
        }
    });*/
	
	jQuery("#fabricImg1").live('mousedown',function(){
		var $this =jQuery(this);
		$this.fadeOut(500, function(){
			$this.remove();//addClass('setout').find('img').fadeIn(500);
			//$this.animate({backgroundColor:'rgba(255,255,255,1)'},500)
			$("#fbzoomtrigger").trigger('click');
			//jQuery("td#zoomedproductimage").removeClass('canzoomin');
			//jQuery("td#zoomedproductimage").addClass('canzoomout');
		});
	})
	jQuery("#fabricImg1").live('mousewheel.sz', function(){
		var $this =jQuery(this);
		$this.fadeOut(500, function(){
			$this.remove();
			FIstart = 0;
		})
	})
	/*jQuery("#fabricImg1.setout").live('mousedown',function(){
		jQuery(this).fadeOut(500, function(){
			jQuery("div#zoompopup div#zoomoptions img#zoomout").removeClass('disabled');
            jQuery("div#zoompopup div#zoomoptions img#zoomin").addClass('disabled');
		})
	});*/
    
    $("td#zoomedproductimage img[zoomurl]").live('click', function(){
        jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage' src='" + $(this).attr("zoomurl") + "' alt='" + $(this).attr("alt") + "' />");
        $("img#zoomedimage").on('load', function(){
			StartZooming();
			$('div#zoomoptions').fadeIn(400);
		});
    });
    
    $("#fbzoomtrigger").click(function(){
        $("#zoomedfbdtl").html($("#ftechimage div.ftboxzoom").html() + '<img id="zoomcloselightbox" src="' + skinUrl  + 'images/catalog/product/close.png" />');
        $("#zoomedfbdtl").width(_winW).height(_winH + _headerHeight).fadeIn('fast');
        
    });
    
    $("#zoomedfbdtl").live('click', function(){
        $("#zoomedfbdtl").fadeOut('fast');
		FIstart = 0;
    });
    
    if($("#ftechimage div.big_small.big_big").length == 0)
        $("a#fbzoomtrigger").hide();
        
    getfreshInventory();
    
    $("div.smogibuckcount").click(function(){
        //console.log(_productcolorinfo);
    });
    
});

function getfreshInventory()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/inventory';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/inventory';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'id' : _productid},
        success : function(result){
            result = eval('(' + result + ')');
            //console.log(result);
            for(var i = 0; i < result.length; i++)
            {
                modifyinfo(result[i][0], result[i][1], result[i][2], result[i][3]);   
            }
            
            if(_defaultprcolor != '')
            {
                if(jQuery("div#colorcontainer table[value='" + _defaultprcolor + "']").length > 0)
                    changeColor(jQuery("div#colorcontainer table[value='" + _defaultprcolor + "']").attr("color"));
                else
                {
                    if(jQuery("div#colorcontainer table:first").length > 0)
                        changeColor($("div#colorcontainer table:first").attr("color"));
                }
                _defaultprcolor = '';
            }
            else
            {
                if(jQuery("div#colorcontainer table:first").length > 0)
                    changeColor(jQuery("div#colorcontainer table:first").attr("color"));    
            }
            //jQuery("div#colorcontainer table[color]:first").trigger('click');
            jQuery("div#absproductoptions div.disableproptions").remove();
        }
    });
}

function modifyinfo(color, size, value, instock)
{
    //console.log(color + size + value);
    for(var i = 0; i < _productcolorinfo.length; i++)
    {
        if(_productcolorinfo[i].color == color)
        {
            for(var j = 0; j < _productcolorinfo[i].sizes.length; j++)
            {
                arrsize = _productcolorinfo[i].sizes[j].split('|');
                if(arrsize[0] == size)
                {
                    arrsize[1] = value;
                    arrsize[4] = instock;
                    _productcolorinfo[i].sizes[j] = arrsize.join('|');
                    //console.log('found');
                    return;
                }    
            }
        }
    }
}

function getZoomPercent(realwidth, realheight, orgwidth, orgheight)
{
    var nPercent = 0;
    var nPercentW = 0;
    var nPercentH = 0;
    
    nPercentW = realwidth / orgwidth;
    nPercentH = realheight / orgheight;
    if(nPercentH < nPercentW){
		nPercent = nPercentH;
    }else{
        nPercent = nPercentW;
	}
    return nPercent * 100;
}
var initialzoom;
var minzoom;
function StartZooming(scale)
{
    scale = (typeof scale === "undefined") ? false : scale;
    var td = jQuery("table.zoomproductdetail table.zoomsmallimagecontainer td.selectedimage");
    var temp = _fabrictechnologyimage.split('|'); 
    var orgwidth = td.attr("orgwidth") * 1;
    var orgheight = td.attr("orgheight") * 1;
    var realwidth = 0;
    var realheight = 0;
    if(scale)
    {
        if(jQuery("img#zoomedimage").hasClass('fabricimage'))
        {
            orgwidth = temp[1] * 1;
            orgheight = temp[2] * 1;
            realwidth = td.attr("orgwidth") * scale;
            realheight = td.attr("orgheight") * scale;    
        }
        else
        {
            orgwidth = td.attr("orgwidth") * 1;
            orgheight = td.attr("orgheight") * 1;
            realwidth = temp[1] * scale;
            realheight = temp[2] * scale;
        }
        //if(jQuery("img#zoomedimage").hasClass('fabricimage'))
//        {
//            orgwidth = temp[1] * 1;
//            orgheight = temp[2] * 1;
//        }
//        else
//        {
//            orgwidth = td.attr("orgwidth") * 1;
//            orgheight = td.attr("orgheight") * 1;    
//        }
//        realwidth = orgwidth * scale;
//        realheight = orgheight * scale;
//        console.log("realwidth = '" + realwidth + "', realheight = '" + realheight + "', orgwidth = '" + orgwidth + "', orgheight = '" + orgheight + "'");
    }
    else
    {
        
        realwidth = 700;
        realheight = 700;
    }
	
	var ImgScrRatio = ((_winH) / jQuery("img#zoomedimage").height())*1.2;
	if(ImgScrRatio < 1){
		minzoom = ImgScrRatio*100;
	}else{
		minzoom = 1*100;
	}
	//var ImgScrRatioW = ((_winW) / jQuery("img#zoomedimage").width());
	var ImgScrRatioW = ((_winH) / jQuery("img#zoomedimage").height())*1.6;
	if(ImgScrRatioW < 1){
		initialzoom = ImgScrRatioW*100;
	}else{
		initialzoom = 1*100;
	}
    //var initialzoom = Math.floor(Math.random() * (100 - 50 + 1)) + 50;
//    initialzoom = 150;
    //var initialzoom = getZoomPercent(realwidth, realheight, orgwidth, orgheight);
    /*if(jQuery("img#zoomedimage").hasClass('fabricimage'))
        _minzoomscale = getZoomPercent(700, 700, temp[1] * 1, temp[2] * 1);
    else
        _minzoomscale = getZoomPercent(700, 700, td.attr("orgwidth") * 1, td.attr("orgheight") * 1); 	*/
    jQuery('img#zoomedimage').show();
	jQuery('td#zoomedproductimage').addClass('lev0');
	_minzoomscale = 18;
    jQuery('img#zoomedimage').smoothZoom({
        width : _winW - 250,
        height : _winH + _headerHeight,
        max_WIDTH : _winW - 250,
        max_HEIGHT : _winH + _headerHeight,
        initial_ZOOM : initialzoom,
		zoom_MAX: 100,
        zoom_MIN : minzoom,
        responsive : true,
		animation_SMOOTHNESS:4,animation_SPEED_ZOOM:4,animation_SPEED_PAN:4,
        pan_BUTTONS_SHOW : false,
		//zoom_SINGLE_STEP: true,
		//mouse_DOUBLE_CLICK:false,
        pan_REVERSE : true,
        on_IMAGE_LOAD : function(){
            //setTimeout(function(){
//                var containerwidth = jQuery('td#zoomedproductimage').width();
//                var imgwidth = jQuery('img#zoomedimage').width();
//                var x = (containerwidth -700) / 2;
//                initialzoom = (700 / imgwidth) * 100;
//                initialzoom = 20;
//                console.log(jQuery('img#zoomedimage').width());
//                console.log('initialzoom = ' + initialzoom);
//                jQuery('#zoomedimage').smoothZoom('focusTo',{
//                    x : x,
//                	zoom: initialzoom
//                });
//            }, 100);
            //jQuery("img#zoomedimage").smoothZoom('focusTo',{
//                x : 0,
//                y : 0,
//                zoom : 156,
//                speed : 2
//            });
        },
        on_ZOOM_PAN_UPDATE : function(){
            //console.log('pan update');
//            console.log(jQuery("img#zoomedimage").width() + " > " + jQuery("td#zoomedproductimage").width());
//            if(jQuery("img#zoomedimage").width() > jQuery("td#zoomedproductimage").width())
//                jQuery("img#zoomedimage").css('margin-left','0px');
//            else
//                jQuery("img#zoomedimage").css('margin-left','-125px');
//            jQuery("img#zoomedimage").css('transform-origin','125px 0 0');
        },
        on_ZOOM_PAN_COMPLETE : function(){
            try{
                //console.log('current ratio = ' + jQuery('#zoomedimage').smoothZoom('getZoomData').ratio);
                var ratio = jQuery('#zoomedimage').smoothZoom('getZoomData').ratio;
                //console.log('curratio = ' + ratio + '<= minzoomscale' + _minzoomscale);
				if((ratio * 100) <= _minzoomscale){
                    jQuery("div#zoompopup div#zoomoptions img#zoomin").addClass('disabled');
                }else{
                    jQuery("div#zoompopup div#zoomoptions img#zoomout").removeClass('disabled');}
                if(ratio >= 1)
                    {
						if(_fabrictechnologyimage != ""){
							jQuery("div#zoompopup div#zoomoptions img#zoomout").addClass('disabled');
							showFabricImg();
						}else{
							jQuery(this).addClass('setout').find('img').fadeIn(500);
							jQuery("td#zoomedproductimage").removeClass('canzoomin');
							jQuery("td#zoomedproductimage").addClass('canzoomout');
							jQuery("div#zoompopup div#zoomoptions img#zoomout").removeClass('disabled');
							jQuery("div#zoompopup div#zoomoptions img#zoomin").addClass('disabled');
							showFabricImg();
						}
                        //jQuery("td#zoomedproductimage").removeClass('canzoomin');
                        //jQuery("td#zoomedproductimage").addClass('canzoomout');
                    }
                else
                    {
                        jQuery("div#zoompopup div#zoomoptions img#zoomin").removeClass('disabled');
                        jQuery("td#zoomedproductimage").addClass('canzoomin');
                        jQuery("td#zoomedproductimage").removeClass('canzoomout');
                    }
                
                //console.log('pan complete');
                //console.log($('#zoomedimage').smoothZoom('getZoomData').ratio);    
            }
            catch(err){
                
            }
        }
	});
}
var FIstart = 0;
function showFabricImg(){
	if(FIstart==0){
		FIstart = 1;
			//var temp = _fabrictechnologyimage.split('|');<img style='height:auto;width:100%;display:none;' src='" + temp[0] + "' />
			var scale = jQuery('#zoomedimage').smoothZoom('getZoomData').ratio;
			jQuery("div#zoompopup td#zoomedproductimage").append("<div style='position:absolute; top:0; display:none; bottom:0; left:250px; right:0; z-index:4;' id='fabricImg1'><span class='zoom-tx'>click again to learn more<br/>about our fabric technology</span></div>");
			jQuery('#fabricImg1').fadeIn(50)
	}
}
function InitializeZoomPopup()
{
    var tempwidth = jQuery("div.fullscreen:first").width();
    var tempwidth = _winW;
    if(tempwidth < 960)
        tempwidth = 960;
    //console.log(_winH + _headerHeight);
    jQuery("#zoompopup").dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        width : tempwidth,
        height : _winH + _headerHeight,
        modal : true,
        draggable : false,
        //position: { my: "center top",at: "center top+80" },
        resizable : false,
        dialogClass : 'yogidialog zoomdialog',
        open : function(){
            console.log("--   " + jQuery(".zoom-prd-det").css("height"));
            // jQuery("div#zoompopup table.productzoomtable>tbody>tr>td").css({'display':'block','margin-top':'50px'});
        },
        beforeClose : function(){
            jQuery("div.wrapper").removeClass('overflowhidden');
            jQuery("div.wrapper, div.ui-widget-overlay").css('height', 'auto');
            console.log("----   " + jQuery(".zoom-prd-det").css("height"));
        }
    });    
    // jQuery("div#zoompopup table.productzoomtable>tbody>tr>td#zoomproductoptions,div#zoompopup table.productzoomtable>tbody>tr>td#zoomedproductimage").height(_winH + _headerHeight);
    // jQuery("div#zoompopup table.productzoomtable>tbody>tr>td#zoomproductoptions,div#zoompopup table.productzoomtable>tbody>tr>td#zoomedproductimage").css('max-height', (_winH + _headerHeight) + 'px');    
    // jQuery("div#zoompopup div#zoomoptions").css('top', (((_winH) - jQuery("div#zoompopup div#zoomoptions").height()) / 2) + 'px');    
    try{
       jQuery('img#zoomedimage').smoothZoom('resize', {width: (_winW - 250), height: (_winH + _headerHeight)});    
    }
    catch(err)
    {
        //console.log('err');
    }
    jQuery("#zoomedfbdtl").width(_winW).height(_winH + _headerHeight);
}

function resizeDesignFeatures()
{
    var globalcorrection = 170;
    var halfcorrection = 10;
    jQuery("table.productdesignfeatures div[size]").each(function(){
         if(jQuery(this).attr("size") == "full")
         {
            //jQuery(this).css('height', (_winH - globalcorrection) + 'px');
         }
         else
         {
            //jQuery(this).css('height', (((_winH - globalcorrection) / 2) - halfcorrection) + 'px');
         }
    });
    jQuery("table.productdesignfeatures div[size] img").each(function(){
        var height = jQuery(this).height();
        var parentheight = (jQuery(this).parent().css('height').substr(0, jQuery(this).parent().css('height').length - 2) * 1);
        if(height > parentheight)
        {
            //jQuery(this).css('margin-top',((parentheight - height) / 2) + 'px');
            //jQuery(this).parent().css('margin-top',((parentheight - height) / 2) + 'px');        
        }
        //jQuery(this).css('height',parentheight + 'px');
        //var height = jQuery(this).width();
//        var parentheight = jQuery(this).parent().width();// (jQuery(this).parent().css('height').substr(0, jQuery(this).parent().css('height').length - 2) * 1);
//        if(height > parentheight)
//        {
//            jQuery(this).css('margin-left',((parentheight - height) / 2) + 'px');        
//        }
    });
}

function resizeProductBigImage()
{
    var correction = 100;
    var maxHeight = _winH - correction;
    if(maxHeight > 600)
        jQuery("table.tdbigimagecontainer img").css('max-height', 'auto');
        //jQuery("table.tdbigimagecontainer img").css('max-height', maxHeight + 'px');
    else
        jQuery("table.tdbigimagecontainer img").css('max-height', 'auto');
}

function clearEmptycaptions()
{
    jQuery("table.productdesignfeatures div[size] div.caption div").each(function(){
        if(jQuery(this).html() == "")
            jQuery(this).parent().css('display', 'none'); 
    });
}

function changezoomColor(clr, delay, imgindex)
{
    imgindex = (typeof imgindex === "undefined") ? jQuery("table.productimagecontainer table.smallimagecontiner td.selectedimage:first").index() : imgindex;
    imgindex++;
    var colorindex = searchproductcolorinfoarrray(clr);
    if(colorindex == -1)
        return;
    jQuery("table.zoomproductdetail table.selectedcolor td:last").html(clr);
    jQuery("table.zoomproductdetail div#colorcontainer table td").removeClass("tdselectedcolor");
    jQuery("table.zoomproductdetail div#colorcontainer > div").removeClass("selected");
    jQuery("table.zoomproductdetail div#colorcontainer table[color='" + clr + "'] tr:nth-child(2) td").addClass("tdselectedcolor");
    jQuery("table.zoomproductdetail div#colorcontainer table[color='" + clr + "']").parent("div").addClass("selected");
    var smallimagehtml = '';
    for(i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++)
    {
        var temp = _productcolorinfo[colorindex].zoomimages[i][0].split("|");
        smallimagehtml = smallimagehtml + "<tr><td bigimageurl='" + _productcolorinfo[colorindex].bigimages[i][0] + "' zoomimageurl='" + temp[0] + "' orgwidth='" + temp[1] + "' orgheight='" + temp[2] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i][0] + "' alt='" + _productcolorinfo[colorindex].smallimages[i][1] + "'></td></tr>";
    }
    //if(_fabrictechnologyimage != '')
//    {
//        var temp = _fabrictechnologyimage.split('|');
//        smallimagehtml = smallimagehtml + "<tr><td style='vertical-align:middle;text-align:left;' bigimageurl='" + _fabrictechnologyimagespcl + "' zoomimageurl='" + temp[0] + "' orgwidth='" + temp[1] + "' orgheight='" + temp[2] + "'>Fabric Image</td></tr>";
//    }
    jQuery("div#zoompopup table.zoomsmallimagecontainer").html(smallimagehtml);
    jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").addClass('selectedimage');
    jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage1' src='" + jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").attr("bigimageurl") + "' alt='" + jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").find('img:first').attr("alt") + "' zoomurl='" + jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").attr("zoomimageurl") + "' />");
    return;
    jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage' src='" + jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").attr("zoomimageurl") + "' alt='" + jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").find('img:first').attr("alt") + "' />");
    if(delay)
    {
        setTimeout(function(){
            StartZooming();
        }, 500);
    }
    else
    {
        StartZooming();
    }
}

function positiondesignfeatureheadimage()
{
    if(jQuery("div#pagecontainer").width() > 1478)
        jQuery("div.designfeaturesheadimage.potraitfeature").css('left', (((jQuery("div#pagecontainer").width() - 1478) / 2) + 540) + 'px');
    else
        jQuery("div.designfeaturesheadimage.potraitfeature").css('left', '540px');
     if(jQuery("div#pagecontainer").width() > 1500)
        jQuery("div.designfeaturesheadimage.landscapefeature").css('left', (((jQuery("div#pagecontainer").width() - 1500) / 2) + 675) + 'px');
    else
        jQuery("div.designfeaturesheadimage.landscapefeature").css('left', '675px');
}