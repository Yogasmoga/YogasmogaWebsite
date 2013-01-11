jQuery(document).ready(function($){
	$('.productdesignfeatures img').loupe({
	  width: 175, // width of magnifier
	  height: 175
	});

    setTimeout(function(){ resizeDesignFeatures(); }, 100);
    setTimeout(function(){ resizeProductBigImage(); }, 100);
    $(window).resize(function(){
        setTimeout(function(){ resizeDesignFeatures(); }, 100);
        setTimeout(function(){ resizeProductBigImage(); }, 100);
        //setTimeout(function(){ positiondesignfeatureheadimage(); }, 10);
        //positiondesignfeatureheadimage();
    });
    
    
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
        jQuery("#productdetailpopup").html("<table style='width:100%;height : 100%;'><tr><td style='text-align:center;vertical-align:middle;'>Loading. .</td></tr></table>");
        jQuery("body").addClass('overflowhidden');
        jQuery( "#zoompopup" ).dialog( "open" );
        var color = jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("color");
        changezoomColor(jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("color"), true);
        setTimeout(function(){ 
            jQuery("body").addClass('overflowhidden');
        }, 300);
    });
    setTimeout(function(){ InitializeZoomPopup(); }, 500);
    
    $(window).resize(function(){
        setTimeout(function(){ InitializeZoomPopup(); }, 100);    
    });
    positiondesignfeatureheadimage();    
    $("div#zoompopup img#closelightbox").live("click", function(){
        jQuery("#zoompopup").dialog( "close" );
    });
    
    $("table.zoomproductdetail div#colorcontainer table").live("click", function(){
        changezoomColor($(this).attr("color"), false, 0);
    });
    
    $("table.zoomproductdetail table.zoomsmallimagecontainer td:not(.selectedimage)").live("click", function(){
        jQuery("table.zoomproductdetail table.zoomsmallimagecontainer td").removeClass('selectedimage');
        $(this).addClass('selectedimage');
        jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage' src='" + $(this).attr("zoomimageurl") + "' />");
        StartZooming();
    });
    
     $("div#zoompopup div#zoomoptions img#zoomin:not(.disabled)").mousedown(function(){
        $('#zoomedimage').smoothZoom('zoomIn');
        //console.log($('#zoomedimage').smoothZoom('getZoomData').ratio);
    });
    
    $("div#zoompopup div#zoomoptions img#zoomout:not(.disabled)").mousedown(function(){
        $('#zoomedimage').smoothZoom('zoomOut');
        
    });
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
	
	jQuery("#fabricImg").live('mousedown',function(){
		var $this =jQuery(this);
		$this.addClass('setout').find('img').fadeIn(500);
		$this.animate({backgroundColor:'rgba(255,255,255,1)'},500)
		jQuery("td#zoomedproductimage").removeClass('canzoomin');
		jQuery("td#zoomedproductimage").addClass('canzoomout');
	})
	jQuery("#fabricImg.setout").live('mousedown',function(){
		jQuery(this).fadeOut(500, function(){
			jQuery("#fabricImg").remove();
			jQuery("div#zoompopup div#zoomoptions img#zoomout").removeClass('disabled');
            jQuery("div#zoompopup div#zoomoptions img#zoomin").addClass('disabled');
		})
		FIstart = 0;
	})
});

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
    //var initialzoom = Math.floor(Math.random() * (100 - 50 + 1)) + 50;
//    initialzoom = 150;
    var initialzoom = getZoomPercent(realwidth, realheight, orgwidth, orgheight);
    if(jQuery("img#zoomedimage").hasClass('fabricimage'))
        _minzoomscale = getZoomPercent(700, 700, temp[1] * 1, temp[2] * 1);
    else
        _minzoomscale = getZoomPercent(700, 700, td.attr("orgwidth") * 1, td.attr("orgheight") * 1); 	
    jQuery('img#zoomedimage').show();
	_minzoomscale = 18;
    jQuery('img#zoomedimage').smoothZoom({
        width : _winW - 250,
        height : _winH + _headerHeight,
        max_WIDTH : _winW - 250,
        max_HEIGHT : _winH + _headerHeight,
        //initial_ZOOM : initialzoom,
		zoom_MAX: 100,
        zoom_MIN : _minzoomscale,
        responsive : true,
		animation_SMOOTHNESS:4,animation_SPEED_ZOOM:4,animation_SPEED_PAN:4,
        pan_BUTTONS_SHOW : false,
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
			var temp = _fabrictechnologyimage.split('|');
			var scale = jQuery('#zoomedimage').smoothZoom('getZoomData').ratio;
			jQuery("div#zoompopup td#zoomedproductimage").append("<div style='position:absolute; top:0; background-color:rgba(255,255,255,0); bottom:0; left:250px; right:0; z-index:4; overflow:hidden;' id='fabricImg'><img style='height:auto;width:100%;display:none;' src='" + temp[0] + "' /></div>");
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
        show: "scale",
        hide: "scale",
        width : tempwidth,
        height : _winH + _headerHeight,
        modal : true,
        draggable : false,
        //position: { my: "center top",at: "center top+80" },
        resizable : false,
        dialogClass : 'yogidialog zoomdialog',
        beforeClose : function(){
            jQuery("body").removeClass('overflowhidden');    
        }
    });
    jQuery("div#zoompopup table.productzoomtable>tbody>tr>td").height(_winH + _headerHeight);
    jQuery("div#zoompopup table.productzoomtable>tbody>tr>td").css('max-height', (_winH + _headerHeight) + 'px');
    jQuery("div#zoompopup div#zoomoptions").css('top', (((_winH + _headerHeight) - jQuery("div#zoompopup div#zoomoptions").height()) / 2) + 'px');
    try{
       jQuery('img#zoomedimage').smoothZoom('resize', {width: (_winW - 250), height: (_winH + _headerHeight)});    
    }
    catch(err)
    {
        //console.log('err');
    }
    
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
        jQuery("table.tdbigimagecontainer img").css('max-height', maxHeight + 'px');
    else
        jQuery("table.tdbigimagecontainer img").css('max-height', '600px');
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
    jQuery("table.zoomproductdetail div#colorcontainer table[color='" + clr + "'] tr:nth-child(2) td").addClass("tdselectedcolor");
    var smallimagehtml = '';
    for(i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++)
    {
        var temp = _productcolorinfo[colorindex].zoomimages[i].split("|");
        smallimagehtml = smallimagehtml + "<tr><td zoomimageurl='" + temp[0] + "' orgwidth='" + temp[1] + "' orgheight='" + temp[2] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i] + "'></td></tr>";
    }
    jQuery("div#zoompopup table.zoomsmallimagecontainer").html(smallimagehtml);
    jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").addClass('selectedimage');
    jQuery("div#zoompopup td#zoomedproductimage").html("<img id='zoomedimage' src='" + jQuery("div#zoompopup table.zoomsmallimagecontainer tr:nth-child(" + imgindex + ") td").attr("zoomimageurl") + "' />");
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