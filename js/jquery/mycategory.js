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
            handlealwaysvisiblecontrols();
            //centerproductgrid();
          }
        });
    });
    
    $("div.mylayerednavigation div.searchitems div").click(function(){
        var id = $(this).attr("id");
        var searchattr = id.substring(0, id.indexOf('|'));
        var searchval = id.substring(id.indexOf('|') + 1);
        if($(this).find("table:first").hasClass("inactive"))
        {
            //$("div#mycategory_products div[" + searchattr + "*='," + searchval + ",']").fadeOut('slow');
            //$("div#mycategory_products:not(div[" + searchattr + "*='," + searchval + ",'])").fadeOut('slow');
            $(this).find("table:first").removeClass("inactive");
            $(this).find("table:first").addClass("active");
            //$("div#mycategory_products div").not("[" + searchattr + "*='," + searchval + ",']").fadeOut('slow',function(){ showvisibleproductcount();});
            //$("div#mycategory_products div").not(getsearchattributes()).fadeOut('slow',function(){ showvisibleproductcount();});
            //$('div#mycategory_products').isotope({ filter: getsearchattributes()}, function($items){ showvisibleproductcount($items.length);});
            filterproducts();
            $('div#mycategory_products').isotope({ filter: "div.filtered"}, function($items){ showvisibleproductcount($items.length);});
            //$('div#mycategory_products').isotope({ filter: $('div#mycategory_products div.item')}, function($items){ showvisibleproductcount($items.length);});
        }
        else
        {
            $(this).find("table:first").addClass("inactive");
            $(this).find("table:first").removeClass("active");
            //$("div#mycategory_products div").not(getsearchattributes()).fadeIn('slow',function(){ showvisibleproductcount();});
            //$("div#mycategory_products div" + getsearchattributes()).fadeIn('slow',function(){ showvisibleproductcount();});
            //$('div#mycategory_products').isotope({ filter: getsearchattributes()}, function($items){ showvisibleproductcount($items.length);});
            filterproducts();
            $('div#mycategory_products').isotope({ filter: "div.filtered"}, function($items){ showvisibleproductcount($items.length);});
            //$("div#mycategory_products div[" + searchattr + "*='," + searchval + ",']").fadeIn('slow');
        }
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

function filterproducts()
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