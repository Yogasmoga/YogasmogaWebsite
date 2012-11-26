var _hovercollection = new Array();

jQuery(document).ready(function($){
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