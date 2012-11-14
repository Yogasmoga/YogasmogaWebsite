var _hovercollection = new Array();

jQuery(document).ready(function($){
    setTimeout(function(){ handlealwaysvisiblecontrols();}, 100); 
    $(window).scroll(function(){
        handlealwaysvisiblecontrols();
    });
    $(window).resize(function(){
        //resizeproductgrid();
        //handlealwaysvisiblecontrols();
        //centerproductgrid();
    });
    $("div.searchhead").click(function(){
        h = jQuery(this).parent().height();
        t = jQuery(this).parent().offset().top;
        s = jQuery(window).scrollTop() + _headerHeight;
        console.log('h = ' + h);
         console.log('t = ' + t);
         console.log('s = ' + s);
    });
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
    
    InitializeHoverCollection();
    
    jQuery(".mycategory-products div.item").hover(function(){
        var idd = jQuery(this).attr("id");
        togglehover(idd, true);
         //setTimeout(function(){ shownextimage(idd); }, 1000);
        //console.log(_hovercollection);
    },
    function(){
        togglehover(jQuery(this).attr("id"), false);
        //console.log(_hovercollection);
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

function searchsrcarray(obj, val)
{
    for(i = 0; i < obj.length; i++)
    {
        if(obj[i].attr == val)
            return i;
    }
    return -1;
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

function togglehover(id, state)
{
    for(i = 0; i < _hovercollection.length; i++)
    {
        if(_hovercollection[i].id == id)
        {
            if(state)
            {
                if(_hovercollection[i].timeobject == "")
                {
                    _hovercollection[i].hovered = true;
                    _hovercollection[i].timeobject = setTimeout(function(){ shownextimage(id); }, 1000);    
                }
                else
                {
                    _hovercollection[i].hovered = false;
                }
            }
            else
            {
                clearInterval(_hovercollection[i].timeobject);
                _hovercollection[i].timeobject = '';
                _hovercollection[i].hovered = false;
            }
            break;
        }
    }
}

function isitemhovered(id)
{
    for(i = 0; i < _hovercollection.length; i++)
    {
        if(_hovercollection[i].id == id)
        {            
            return _hovercollection[i].hovered;
        }
    }
}

function resettimeobject(id)
{
    for(i = 0; i < _hovercollection.length; i++)
    {
        if(_hovercollection[i].id == id)
        {            
            _hovercollection[i].timeobject = setTimeout(function(){ shownextimage(id); }, 1000);;
            return;
        }
    }
}

function shownextimage(id)
{
    if(isitemhovered(id))
    {
        if(jQuery("#mycategory_products div#" + id + " td.productimage img.active").next().length > 0)
        {
            var nextimage = jQuery("#mycategory_products div#" + id + " td.productimage img.active").next();
            jQuery("#mycategory_products div#" + id + " td.productimage img.active").removeClass('active');
            nextimage.addClass('active');
            
            nextimage = jQuery("#mycategory_products div#" + id + " td.animateimage img.active").next();
            jQuery("#mycategory_products div#" + id + " td.animateimage img.active").removeClass('active');
            nextimage.addClass('active');
        }
        else
        {
            jQuery("#mycategory_products div#" + id + " td.productimage img.active").removeClass('active');
            jQuery("#mycategory_products div#" + id + " td.productimage img:first-child").addClass('active');
            
            jQuery("#mycategory_products div#" + id + " td.animateimage img.active").removeClass('active');
            jQuery("#mycategory_products div#" + id + " td.animateimage img:first-child").addClass('active');
        }
        resettimeobject(id);
    }
}

function InitializeHoverCollection()
{
    jQuery.each(jQuery(".mycategory-products div.item"), function(){
        //_hovercollection[_hovercollection.length] = "{id:" + jQuery(this).attr("id") + ",hovered:false}";
        var l = _hovercollection.length;
        _hovercollection[l] = new Object();
        _hovercollection[l].id = jQuery(this).attr("id");
        _hovercollection[l].hovered = false;
        _hovercollection[l].timeobject = '';
        //_hovercollection[_hovercollection.length] = "{id:" + jQuery(this).attr("id") + ",hovered:false}";
    });
    //console.log(_hovercollection);
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

function handlealwaysvisiblecontrols()
{
    jQuery.each(jQuery(".topvisible"), function(){
            h = jQuery(this).parent().height();
            t = jQuery(this).parent().offset().top;
            s = jQuery(window).scrollTop() + _headerHeight;
            if(s > t)
            {
                if(h - (s - t) < _winH)
                {
                    //console.log('removed');
                    jQuery(this).removeClass('fixedposition');
                    //if(jQuery(this).height() > (_winH - (h - (s - t))))
//                        {
//                            console.log(jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1);
//                            //console.log(((jQuery(this).css('top') * 1) - (_winH - (h - (s - t)))));
//                            jQuery(this).css('top', ((jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1) - (_winH - (h - (s - t)))) + 'px');
//                        }
//                    else
//                        {
//                            jQuery(this).removeClass('fixedposition');
//                            jQuery(this).css('top', 'auto');
//                        }        
                }
                else
                {
                    //console.log('applied');
                    jQuery(this).addClass('fixedposition');
                }        
            }
            else
                jQuery(this).removeClass('fixedposition');
    });
    
    jQuery.each(jQuery(".alwaysvisible"), function(){
        h = jQuery(this).parent().height();
            t = jQuery(this).parent().offset().top;
            s = jQuery(window).scrollTop() + _headerHeight;
            if(s > t)
            {
                if(h - (s - t) < jQuery(this).height())
                //if(h - (s - t) < _winH)
                {
                    //jQuery(this).css('top', 80 + jQuery(this).height() - (h - (s - t)) + 'px'); 
                    
                    jQuery(this).removeClass('fixedposition');
                    jQuery(this).addClass('bottomposition');
                    //if(jQuery(this).height() > (_winH - (h - (s - t))))
//                    {
//                        console.log(jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1);
//                        console.log(((jQuery(this).css('top') * 1) - (_winH - (h - (s - t)))));
//                        jQuery(this).css('top', ((jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1) - (_winH - (h - (s - t)))) + 'px');
//                    }
//                    else
//                    {
//                        jQuery(this).removeClass('fixedposition');
//                        jQuery(this).css('top', 'auto');
//                    }        
                }
                else
                {
                    jQuery(this).addClass('fixedposition');
                    jQuery(this).removeClass('bottomposition');    
                }        
            }
            else
                jQuery(this).removeClass('fixedposition');
    });
    //((_winW - ($(".mycategory-products div.item").width() * 4)) / 4)mycategory_products
    //console.log(jQuery(".mycategory-products div.item").width());
}

function removenotifications()
{
    jQuery(".notification").fadeOut();
}

function searchitems()
{
    console.log(jQuery(this).html());
}