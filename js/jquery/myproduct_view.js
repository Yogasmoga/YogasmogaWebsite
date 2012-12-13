jQuery(document).ready(function($){
    setTimeout(function(){ resizeDesignFeatures(); }, 100);
    setTimeout(function(){ resizeProductBigImage(); }, 100);
    $(window).resize(function(){
        setTimeout(function(){ resizeDesignFeatures(); }, 100);
        setTimeout(function(){ resizeProductBigImage(); }, 100);
    });
    
    $("table.productdesignfeatures div[size]").hover(function(){
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
    
    //$("table.tdbigimagecontainer img").live("click", function(){
//        //jQuery("#productdetailpopup").html("<table style='width:100%;height : 100%;'><tr><td style='text-align:center;vertical-align:middle;'>Loading. .</td></tr></table>");
//        //jQuery("body").addClass('overflowhidden');
//        jQuery( "#zoompopup" ).dialog( "open" );
//        //var color = jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("color");
//        changezoomColor(jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("color"), true);
//        setTimeout(function(){ 
//            jQuery("body").addClass('overflowhidden');
//        }, 300);
//    });
//    setTimeout(function(){ InitializeZoomPopup(); }, 100);
    
    $(window).resize(function(){
        setTimeout(function(){ InitializeZoomPopup(); }, 100);    
    });
    
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
});

function StartZooming()
{
    jQuery('img#zoomedimage').show();
    jQuery('img#zoomedimage').smoothZoom({
        initial_ZOOM : 100,
        zoom_MIN : 100,
        responsive : true,
        pan_BUTTONS_SHOW : false,
        pan_REVERSE : true
	});
}

function InitializeZoomPopup()
{
    var tempwidth = jQuery("div.fullscreen:first").width();
    var tempwidth = _winW;
    if(tempwidth < 960)
        tempwidth = 960;
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
    jQuery("div#zoompopup table.productzoomtable tr td:first").height(_winH + _headerHeight);
}

function resizeDesignFeatures()
{
    var globalcorrection = 170;
    var halfcorrection = 10;
    jQuery("table.productdesignfeatures div[size]").each(function(){
         if(jQuery(this).attr("size") == "full")
         {
            jQuery(this).css('height', (_winH - globalcorrection) + 'px');
         }
         else
         {
            jQuery(this).css('height', (((_winH - globalcorrection) / 2) - halfcorrection) + 'px');
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
        smallimagehtml = smallimagehtml + "<tr><td zoomimageurl='" + _productcolorinfo[colorindex].bigimages[i] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i] + "'></td></tr>";
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