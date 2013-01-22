jQuery(document).ready(function($){
    $(window).resize(function(){
        //resizeproductgrid();
        //handlealwaysvisiblecontrols();
        //centerproductgrid();
        centermodalpopup();
    });
    //$("div.searchhead").click(function(){
//        h = jQuery(this).parent().height();
//        t = jQuery(this).parent().offset().top;
//        s = jQuery(window).scrollTop() + _headerHeight;
//        console.log('h = ' + h);
//         console.log('t = ' + t);
//         console.log('s = ' + s);
//    });
    $(window).load(function(){
        //resizeproductgrid();
        //centerproductgrid();
        //setTimeout(function(){centerproductgrid();}, 500); 
         $('div#mycategory_products.isotoped').isotope({
          itemSelector : '.item',
          onLayout : function(){
            if(typeof(handlealwaysvisiblecontrols) == typeof(Function))
            {
                handlealwaysvisiblecontrols();
                //console.log('called');
            }
            //centerproductgrid();
          }
        });
    });
    
    $("div.mylayerednavigation div.searchitems:last").addClass('colorfilters');
    $("div.mylayerednavigation div.searchhead:last").addClass('colorfilters');
    
    
    $("div.mylayerednavigation div.searchitems div").click(function(){
        var id = $(this).attr("id");
        var searchattr = id.substring(0, id.indexOf('|'));
        var searchval = id.substring(id.indexOf('|') + 1);
        
        if(searchattr == 'cat')
        {
            if(jQuery("div.mylayerednavigation div.subcategory." + searchval).length > 0)
            {
                if($(this).hasClass('closed'))
                {
                    $(this).removeClass('closed');    
                    jQuery("div.mylayerednavigation div.subcategory." + searchval).fadeIn('fast');    
                }
                else
                {
                    $(this).addClass('closed');
                    jQuery("div.mylayerednavigation div.subcategory." + searchval + " table").removeClass('active').addClass('inactive');
                    jQuery("div.mylayerednavigation div.subcategory." + searchval).fadeOut('fast');
                    filterproducts(searchattr);
                    $('div#mycategory_products').isotope({ filter: "div.filtered"}, function($items){ showvisibleproductcount($items.length);});
                }    
                return;
            }
        }
        
        if($(this).find("table:first").hasClass("inactive"))
        {
            //$("div#mycategory_products div[" + searchattr + "*='," + searchval + ",']").fadeOut('slow');
            //$("div#mycategory_products:not(div[" + searchattr + "*='," + searchval + ",'])").fadeOut('slow');
            $(this).parent().find("table").addClass('inactive').removeClass('active').addClass('grayed');            
            $(this).find("table:first").removeClass("inactive").removeClass('grayed');
            $(this).find("table:first").addClass("active");
            //$("div#mycategory_products div").not("[" + searchattr + "*='," + searchval + ",']").fadeOut('slow',function(){ showvisibleproductcount();});
            //$("div#mycategory_products div").not(getsearchattributes()).fadeOut('slow',function(){ showvisibleproductcount();});
            //$('div#mycategory_products').isotope({ filter: getsearchattributes()}, function($items){ showvisibleproductcount($items.length);});
            
            //$('div#mycategory_products').isotope({ filter: $('div#mycategory_products div.item')}, function($items){ showvisibleproductcount($items.length);});
            
            //if(searchattr == 'cat')
//            {
//                $("div.mylayerednavigation div[searchattr='color']").hide();
//                $("div.mylayerednavigation div[searchattr='color'] table").removeClass('active').addClass('inactive');
//                var itemcollection = jQuery('div#mycategory_products div.item').filter("[cat*='," + searchval + ",']");
//                itemcollection.each(function(){
//                    var colors = $(this).attr("color").split(",");
//                    for(i = 0; i < colors.length; i++)
//                    {
//                        $("div.mylayerednavigation div[searchattr='color'][searchval='" + colors[i] + "']").show();    
//                    }
//                });
//                if(itemcollection.length > 0)
//                    $("div.colorfilters").show();     
//            }
        }
        else
        {
            $(this).parent().find("table").addClass('inactive').removeClass('active').removeClass('grayed');
            $(this).find("table:first").addClass("inactive");
            $(this).find("table:first").removeClass("active").removeClass('grayed');
            //$("div#mycategory_products div").not(getsearchattributes()).fadeIn('slow',function(){ showvisibleproductcount();});
            //$("div#mycategory_products div" + getsearchattributes()).fadeIn('slow',function(){ showvisibleproductcount();});
            //$('div#mycategory_products').isotope({ filter: getsearchattributes()}, function($items){ showvisibleproductcount($items.length);});
            //$("div#mycategory_products div[" + searchattr + "*='," + searchval + ",']").fadeIn('slow');
            
            if(searchattr == 'cat')
            {
                $("div.mylayerednavigation div[searchattr='color'] table").removeClass('active').addClass('inactive').removeClass('grayed');
            }
            
            //if(searchattr == 'cat')
//            {
//                $("div.mylayerednavigation div[searchattr='color']").hide();
//                $("div.colorfilters").hide();
//                $("div.mylayerednavigation div[searchattr='color'] table").removeClass('active').addClass('inactive');
//            }
        }
        //if($("div.mylayerednavigation div[searchattr='cat']").has('table.active').length > 0)
//        {
//            var itemcollection = jQuery('div#mycategory_products div.item').filter("[cat*='," + $("div.mylayerednavigation div[searchattr='cat']").has('table.active').attr("searchval") + ",']");
//           if(itemcollection.length > 0)
//                $("div.colorfilters").show();
//        }
//        else
//        {
//            $("div.colorfilters").hide();
//        }
        filterproducts(searchattr);
        $('div#mycategory_products').isotope({ filter: "div.filtered"}, function($items){ showvisibleproductcount($items.length);});
    });    
    showvisibleproductcount($("div#mycategory_products div.item").length);
});

function centermodalpopup()
{
    jQuery(".ui-dialog").each(function(){
        var left = (_winW - jQuery(this).width()) / 2;
        jQuery(this).css('left', left + 'px');    
    });
}

function filterproducts(searchattr)
{
    var sattr = new Array();
    jQuery.each(jQuery("div.mylayerednavigation div.searchitems table.active"), function(){
        var id = jQuery(this).parent().attr("id");
        var searchattr = id.substring(0, id.indexOf('|'));
        var searchval = id.substring(id.indexOf('|') + 1);
        var index = searchsrcarray(sattr, searchattr);
        if(index == -1)
        {
            index = sattr.length;
            sattr[index] = new Object();
            sattr[index].attr = searchattr;
            sattr[index].value = "[" + searchattr + "*='," + searchval + ",']";
        }
        else
        {
            sattr[index].value = sattr[index].value + ",[" + searchattr + "*='," + searchval + ",']";
        }
    });
    var itemcollection = jQuery('div#mycategory_products div.item');
    itemcollection.removeClass('filtered');
    for(i = 0; i < sattr.length; i++)
    {
        itemcollection = itemcollection.filter(sattr[i].value);
    }
    itemcollection.addClass('filtered');
    filternavigation(searchattr);
    filterimages();
}

function filterimages()
{
    var scat = '';
    var sbestfor = '';
    var scolor = '';
    //if(jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").length > 0)
//        scat = jQuery.trim(jQuery("div.mylayerednavigation div[searchattr='cat'] table.active td:first").html()).replace(" ","_").toLowerCase();
//    if(jQuery("div.mylayerednavigation div[searchattr='bestfor']").has("table.active").length > 0)
//        sbestfor = jQuery.trim(jQuery("div.mylayerednavigation div[searchattr='bestfor'] table.active td:first").html()).replace(" ","_").toLowerCase();
//    if(jQuery("div.mylayerednavigation div[searchattr='color']").has("table.active").length > 0)
//        scolor = jQuery.trim(jQuery("div.mylayerednavigation div[searchattr='color'] table.active td:first").html()).replace(" ","_").toLowerCase();

    if(jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").length > 0)
        scat = jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").attr("searchval");
    if(jQuery("div.mylayerednavigation div[searchattr='bestfor']").has("table.active").length > 0)
        sbestfor = jQuery("div.mylayerednavigation div[searchattr='bestfor']").has("table.active").attr("searchval");
    if(jQuery("div.mylayerednavigation div[searchattr='color']").has("table.active").length > 0)
        scolor = jQuery("div.mylayerednavigation div[searchattr='color']").has("table.active").attr("searchval");
    
    
    var temp = '';
    if(sbestfor != '')
        temp += "bestfor_" + sbestfor + ".";
    
    if(scolor != '' && sbestfor != '' && scat != '')
    //if(scolor != '')// && sbestfor != '')
    {
        _rotateprimages = false;
        jQuery("div#mycategory_products div.item td.animateimage a").hide();
    }
    else
    {
        _rotateprimages = true;
        jQuery("div#mycategory_products div.item td.animateimage a").show();
    }
    
    if(temp.length > 0)
    {
        temp = temp.substr(0, temp.length - 1);
        jQuery("div#mycategory_products div.item td.productimage img").removeClass('rotable').removeClass('active');
        console.log(temp);
        jQuery("div#mycategory_products div.item td.productimage img." + temp).addClass('rotable');
        //jQuery("div#mycategory_products div.item td.productimage img.rotable:first-child").addClass('active');
        jQuery("div#mycategory_products div.item td.productimage").each(function(){
            jQuery(this).find("img.rotable:first").addClass('active');
        });
        console.log(jQuery("div#mycategory_products div.item td.productimage img.rotable:first-child"));
    }
    else
    {
        jQuery("div#mycategory_products div.item td.productimage img").removeClass('rotable').removeClass('active');
        jQuery("div#mycategory_products div.item td.productimage img.default").addClass('rotable');
        jQuery("div#mycategory_products div.item td.productimage").each(function(){
            jQuery(this).find("img.default.rotable:first").addClass('active');
        });
        //jQuery("div#mycategory_products div.item td.productimage img.default.rotable:first-child").addClass('active');
    }
    
}

function filternavigation1(searchattr)
{
    //console.log(searchattr);
    var itemcollection = jQuery('div#mycategory_products div.item.filtered');
    jQuery("div.mylayerednavigation div[searchattr]").hide();
    //jQuery("div.mylayerednavigation div[searchattr][searchattr!='" + searchattr + "']").hide();
//    jQuery("div.mylayerednavigation div[searchattr][searchattr='" + searchattr + "']").show();
    jQuery("div.colorfilters").hide();
    
    
    //jQuery("div.mylayerednavigation div[searchattr='" + searchattr + "']").has("table.inactive").each(function(){
//        
//    });
    
    //console.log(jQuery("div.mylayerednavigation div[searchattr][searchattr!='" + searchattr + "']"));
    //jQuery("div.mylayerednavigation div[searchattr='" + searchattr + "']").show();
    itemcollection.each(function(){
        //if(searchattr != "color")
//        {
//            var colors = jQuery(this).attr("color").split(",");
//            for(i = 0; i < colors.length; i++)
//            {
//                jQuery("div.mylayerednavigation div[searchattr='color'][searchval='" + colors[i] + "']").show();    
//            }   
//        }
//        if(searchattr != "cat")
//        {
//            var category = jQuery(this).attr("cat").split(",");
//            for(i = 0; i < category.length; i++)
//            {
//                jQuery("div.mylayerednavigation div[searchattr='cat'][searchval='" + category[i] + "']").show();    
//            }   
//        }
//        if(searchattr != "bestfor")
//        {
//            var bestfor = jQuery(this).attr("bestfor").split(",");
//            for(i = 0; i < bestfor.length; i++)
//            {
//                jQuery("div.mylayerednavigation div[searchattr='bestfor'][searchval='" + bestfor[i] + "']").show();    
//            }   
//        }
            
            
            var colors = jQuery(this).attr("color").split(",");
            for(i = 0; i < colors.length; i++)
            {
                jQuery("div.mylayerednavigation div[searchattr='color'][searchval='" + colors[i] + "']").show();    
            }
            var category = jQuery(this).attr("cat").split(",");
            for(i = 0; i < category.length; i++)
            {
                jQuery("div.mylayerednavigation div[searchattr='cat'][searchval='" + category[i] + "']").show();    
            }
            var bestfor = jQuery(this).attr("bestfor").split(",");
            for(i = 0; i < bestfor.length; i++)
            {
                jQuery("div.mylayerednavigation div[searchattr='bestfor'][searchval='" + bestfor[i] + "']").show();
            }
    });
    if(jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").length > 0)
        jQuery("div.colorfilters").show();
}



function filternavigation(searchattr)
{
    //console.log(searchattr);
    var itemcollection = jQuery('div#mycategory_products div.item.filtered');
    //jQuery("div.mylayerednavigation div[searchattr]").hide();
    //jQuery("div.mylayerednavigation div[searchattr][searchattr!='" + searchattr + "']").hide();
//    jQuery("div.mylayerednavigation div[searchattr][searchattr='" + searchattr + "']").show();
    jQuery("div.mylayerednavigation div[searchattr]:not(.subcategory)").has("table.inactive").show();
    jQuery("div.mylayerednavigation div.pcategory").each(function(){
        if(!jQuery(this).hasClass('closed'))
            jQuery("div.mylayerednavigation div.subcategory." + jQuery(this).attr("searchval")).show();    
    });
    jQuery("div.colorfilters").hide();
    
    
    
    var scat = '';
    var sbestfor = '';
    var scolor = '';
    if(jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").length > 0)
        scat = jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").attr("searchval");
    if(jQuery("div.mylayerednavigation div[searchattr='bestfor']").has("table.active").length > 0)
        sbestfor = jQuery("div.mylayerednavigation div[searchattr='bestfor']").has("table.active").attr("searchval");
    if(jQuery("div.mylayerednavigation div[searchattr='color']").has("table.active").length > 0)
        scolor = jQuery("div.mylayerednavigation div[searchattr='color']").has("table.active").attr("searchval");
    
    //jQuery("div.mylayerednavigation div[searchattr][searchattr='" + searchattr + "']").has("table.inactive").each(function(){
//        //console.log(jQuery(this).attr("searchval"));
//        var sattr = '';
//        if(searchattr != 'cat' && scat != '')
//            sattr += "[cat*='," + scat + ",']";
//        if(searchattr != 'bestfor' && sbestfor != '')
//            sattr += "[bestfor*='," + sbestfor + ",']";
//        if(searchattr != 'color' && scolor != '')
//            sattr += "[color*='," + scolor + ",']";
//        if(sattr.length > 0)
//        {
//            sattr += "[" + searchattr + "*='," + jQuery(this).attr("searchval") + ",']";
//            console.log(sattr);
//            //sattr = sattr.substr(0, sattr.length - 1);
//            console.log(jQuery("div#mycategory_products div.item" + sattr));
//            if(jQuery("div#mycategory_products div.item" + sattr).length == 0)
//                jQuery(this).hide();
//        }
//    });
    
    
    jQuery("div.mylayerednavigation div[searchattr]").has("table.inactive").each(function(){
        //console.log(jQuery(this).attr("searchval"));
        var sattr = '';
        var csa = jQuery(this).attr("searchattr");
        if(csa != 'cat' && scat != '')
            sattr += "[cat*='," + scat + ",']";
        if(csa != 'bestfor' && sbestfor != '')
            sattr += "[bestfor*='," + sbestfor + ",']";
        if(csa != 'color' && scolor != '')
            sattr += "[color*='," + scolor + ",']";
        if(sattr.length > 0)
        {
            sattr += "[" + csa + "*='," + jQuery(this).attr("searchval") + ",']";
            //console.log(sattr);
            //sattr = sattr.substr(0, sattr.length - 1);
            //console.log(jQuery("div#mycategory_products div.item" + sattr));
            if(jQuery("div#mycategory_products div.item" + sattr).length == 0)
                jQuery(this).hide();
        }
    });
    if(jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").length > 0)
        jQuery("div.colorfilters").show();
    return;
    //console.log(jQuery("div.mylayerednavigation div[searchattr][searchattr!='" + searchattr + "']"));
    //jQuery("div.mylayerednavigation div[searchattr='" + searchattr + "']").show();
    itemcollection.each(function(){
        if(searchattr != "color")
        {
            var colors = jQuery(this).attr("color").split(",");
            for(i = 0; i < colors.length; i++)
            {
                jQuery("div.mylayerednavigation div[searchattr='color'][searchval='" + colors[i] + "']").show();    
            }   
        }
        if(searchattr != "cat")
        {
            var category = jQuery(this).attr("cat").split(",");
            for(i = 0; i < category.length; i++)
            {
                jQuery("div.mylayerednavigation div[searchattr='cat'][searchval='" + category[i] + "']").show();    
            }   
        }
        if(searchattr != "bestfor")
        {
            var bestfor = jQuery(this).attr("bestfor").split(",");
            for(i = 0; i < bestfor.length; i++)
            {
                jQuery("div.mylayerednavigation div[searchattr='bestfor'][searchval='" + bestfor[i] + "']").show();    
            }   
        }
            
            
            //var colors = jQuery(this).attr("color").split(",");
//            for(i = 0; i < colors.length; i++)
//            {
//                jQuery("div.mylayerednavigation div[searchattr='color'][searchval='" + colors[i] + "']").show();    
//            }
//            var category = jQuery(this).attr("cat").split(",");
//            for(i = 0; i < category.length; i++)
//            {
//                jQuery("div.mylayerednavigation div[searchattr='cat'][searchval='" + category[i] + "']").show();    
//            }
//            var bestfor = jQuery(this).attr("bestfor").split(",");
//            for(i = 0; i < bestfor.length; i++)
//            {
//                jQuery("div.mylayerednavigation div[searchattr='bestfor'][searchval='" + bestfor[i] + "']").show();    
//            }
    });
    if(jQuery("div.mylayerednavigation div[searchattr='cat']").has("table.active").length > 0)
        jQuery("div.colorfilters").show();
}

function getsearchattributes()
{
    var sattr = "";
    jQuery.each(jQuery("div.mylayerednavigation div.searchitems table.active"), function(){
        var id = jQuery(this).parent().attr("id");
        var searchattr = id.substring(0, id.indexOf('|'));
        var searchval = id.substring(id.indexOf('|') + 1);
        sattr = sattr + "[" + searchattr + "*='," + searchval + ",'],";
    });
    if(sattr.length > 0)
        sattr = sattr.substr(0, sattr.length - 1);
    console.log(sattr);
    return sattr;
}

function showvisibleproductcount(cnt)
{
    var str = "";
    if(cnt > 1)
        str = cnt + " ITEMS";
    else
        str = cnt + " ITEM";
    jQuery("div.mylayerednavigation div.search-result span").html(str);
}

function resizeproductgrid()
{
    jQuery(".mycategory-products div.item").width(Math.floor((jQuery("#mycategory_products").width() * 0.9) / 4));
    var margin = Math.floor((jQuery("#mycategory_products").width() * 0.1) / 4);
    if(margin > 20)
        jQuery(".mycategory-products div.item").css('margin-left', margin + 'px');
    else
        jQuery(".mycategory-products div.item").css('margin-left', '30px');
}

function centerproductgrid()
{
    //var itemmargin = (jQuery(this).css('margin-left').substr(0, jQuery(this).css('margin-left').length - 2) * 1);
    if(jQuery("#mycategory_products").length > 0)
    {
        var itemmargin = 30;
        var itemwidth = jQuery(".mycategory-products div.item").width() + itemmargin;
        var parentwidth = jQuery("#mycategory_products").width();
        //console.log(parentwidth);
        var numitems = Math.floor(parentwidth / itemwidth);
        if(numitems > jQuery(".mycategory-products div.item").length)
            numitems = jQuery(".mycategory-products div.item").length;
        var netmargin = Math.floor((parentwidth - (itemwidth * numitems) - itemmargin) / 2);
        jQuery("#mycategory_products").css('margin-right', netmargin + 'px');
        jQuery("#mycategory_products").css('margin-left', (netmargin - itemmargin) + 'px');   
    }
}

function removenotifications()
{
    jQuery(".notification").fadeOut();
}

function searchitems()
{
    console.log(jQuery(this).html());
}