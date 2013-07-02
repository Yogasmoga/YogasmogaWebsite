var _activedivid = '';
var _nextprimage = '';
var _nextrotimage = '';

var _hovercollection = new Array();

jQuery(document).ready(function($){
    InitializeHoverCollection();
    //jQuery("div.item td.animateimage").each(function(){
//        //if($(this).parents("div.item:first").find("td.productimage img").length > 0)
//            $(this).find("img:first").show();
//    });
    
    jQuery("div.item td.animateimage img:first-child").show();
    jQuery("area").click(function(){
        var temp = '';
        if($(this).hasClass('line1'))
        {
            //console.log('line 1');
            temp = 0;    
        }
        if($(this).hasClass('line2'))
        {
            //console.log('line 2');
            temp = 1;    
        }
        if($(this).hasClass('line3'))
        {
            //console.log('line 3');
            temp = 2;
        }
        if($(this).hasClass('line4'))
        {
            //console.log('line 3');
            temp = 3;
        }
        if($("div#" + _currentproductid + " td.productimage img.rotable").eq(temp).length > 0)
        {
            $("div#" + _currentproductid + " td.productimage img").removeClass('active').hide();
            $("div#" + _currentproductid + " td.productimage img.rotable").eq(temp).addClass('active').fadeIn('slow');
            
            $("div#" + _currentproductid + " td.animateimage img").hide().removeClass('active');
            $("div#" + _currentproductid + " td.animateimage img").eq(temp).show().addClass('active');
        }
    });
    
    jQuery("area").hover(function(){
        $("div#" + _currentproductid).find("span.price").css('display','inline');
        $("div#" + _currentproductid).find("td.productname").css('color','black');
    },
    function(){
        $("div#" + _currentproductid).find("span.price").removeAttr('style');
        $("div#" + _currentproductid).find("td.productname").removeAttr('style');
    });
    
    $(".mycategory-products div.item").hover(function(){
        _currentproductid = $(this).attr("id");
    });
    
    if(!_onipad)
    {
        jQuery(".mycategory-products div.item td.productimage").hover(function(){
            //var idd = jQuery(this).attr("id");
            if(jQuery(this).parents("div.item:first").find("table[color]").length > 0)
            {
                if(jQuery(this).parents("div.item:first").find("td.animateimage a.hideme").length > 0)
                    return;
            }
            else
            {
                if(!_rotateprimages)
                    return;   
            }
            var idd = jQuery(this).parents("div.item:first").attr("id");
            var pelement = $(this).parents("div.item:first"); 
            togglehover(idd, true);
            
            pelement.find("td.animateimage img.inactive").hide();
            pelement.find("td.animateimage img.active").show();
             //setTimeout(function(){ shownextimage(idd); }, 1000);
            //console.log(_hovercollection);
        },
        function(){
            if(jQuery(this).parents("div.item:first").find("table[color]").length > 0)
            {
                if(jQuery(this).parents("div.item:first").find("td.animateimage a.hideme").length > 0)
                    return;
            }
            else
            {
                if(!_rotateprimages)
                    return;   
            }
            //togglehover(jQuery(this).attr("id"), false);
            togglehover(jQuery(this).parents("div.item:first").attr("id"), false);
            var pelement = $(this).parents("div.item:first");
            //$(this).parents("div.item:first").find("td.animateimage img.inactive").show();
            pelement.find("td.animateimage img").hide();
            //if(pelement.find("td.productimage img").length > 0)
                pelement.find("td.animateimage img:first").show();
            //console.log(_hovercollection);
        });   
    }
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
                showfirstimage(id);
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

function showfirstimage(id)
{
    if(jQuery("#mycategory_products div#" + id + " td.productimage img.rotable:first").hasClass('active'))
        return;
    jQuery("#mycategory_products div#" + id + " td.productimage img.rotable.active").removeClass('active').hide();
    jQuery("#mycategory_products div#" + id + " td.productimage img.rotable:first").addClass('active').fadeIn();
    
    //jQuery("#mycategory_products div#" + id + " td.animateimage img.active").removeClass('active');
//    jQuery("#mycategory_products div#" + id + " td.animateimage img:not(.inactive):first").addClass('active');
    jQuery("#mycategory_products div#" + id + " td.animateimage img.active").removeClass('active').hide();
    //if(pelement.find("td.productimage img").length > 0)
        jQuery("#mycategory_products div#" + id + " td.animateimage img:first-child").addClass('active').show();
}

function shownextimage(id)
{
    if(isitemhovered(id))
    {
        //console.log(jQuery("#mycategory_products div#" + id + " td.productimage img.active").nextAll('.rotable').length);
        if(jQuery("#mycategory_products div#" + id + " td.productimage img.rotable").index(jQuery("#mycategory_products div#" + id + " td.productimage img.active")) < 3 && jQuery("#mycategory_products div#" + id + " td.productimage img.active").nextAll('.rotable').length > 0)
        {
            _nextprimage = jQuery("#mycategory_products div#" + id + " td.productimage img.active").nextAll('.rotable:first');
            _nextrotimage = jQuery("#mycategory_products div#" + id + " td.animateimage img.active").next();
            _activedivid = id;
            
            jQuery("#mycategory_products div#" + id + " td.productimage div").fadeOut(300, "easeInOutSine", function(){
                jQuery("#mycategory_products div#" + _activedivid + " td.productimage img.active").removeClass('active').hide();
                _nextprimage.addClass('active').fadeIn();
                jQuery("#mycategory_products div#" + _activedivid + " td.animateimage img.active").removeClass('active').hide();
                _nextrotimage.addClass('active').show();
                jQuery("#mycategory_products div#" + _activedivid + " td.productimage div").fadeIn(300, "easeInOutSine");
                resettimeobject(_activedivid);
            });
            
            
            //var nextimage = jQuery("#mycategory_products div#" + id + " td.productimage img.active").nextAll('.rotable:first');
//            jQuery("#mycategory_products div#" + id + " td.productimage img.active").removeClass('active');
//            nextimage.addClass('active');
//            
//            nextimage = jQuery("#mycategory_products div#" + id + " td.animateimage img.active").next();
//            jQuery("#mycategory_products div#" + id + " td.animateimage img.active").removeClass('active').hide();
//            nextimage.addClass('active').show();
        }
        else
        {
            _activedivid = id;
            jQuery("#mycategory_products div#" + id + " td.productimage div").fadeOut(300, "easeInOutSine", function(){
                
                jQuery("#mycategory_products div#" + _activedivid + " td.productimage img.active").removeClass('active').hide();
                jQuery("#mycategory_products div#" + _activedivid + " td.productimage img.rotable:first").addClass('active').fadeIn();
                
                jQuery("#mycategory_products div#" + _activedivid + " td.animateimage img.active").removeClass('active').hide();
                jQuery("#mycategory_products div#" + _activedivid + " td.animateimage img:first").addClass('active').show();
                
                jQuery("#mycategory_products div#" + _activedivid + " td.productimage div").fadeIn(300, "easeInOutSine");
                resettimeobject(_activedivid);
            });
            
            
            //console.log('sdf');
            //jQuery("#mycategory_products div#" + id + " td.productimage img.active").removeClass('active');
//            jQuery("#mycategory_products div#" + id + " td.productimage img.rotable:first").addClass('active');
//            
//            jQuery("#mycategory_products div#" + id + " td.animateimage img.active").removeClass('active').hide();
//            jQuery("#mycategory_products div#" + id + " td.animateimage img:first").addClass('active').show();
        }
        //resettimeobject(id);
    }
    return;
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

function showme(elem)
{
    //console.log(jQuery(elem).hasClass('active'));
    if(jQuery(elem).hasClass('active'))
    {
        jQuery(elem).fadeIn();
    }
}