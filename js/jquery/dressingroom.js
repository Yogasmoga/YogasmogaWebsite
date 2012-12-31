jQuery(document).ready(function($){
    if($("div#dressingroom").length == 0)
        return;
    $("#dressingroomtop, #dressingroombottom").hover(function(){
        $(this).find("img.invisible, div.productdetail").fadeIn('fast');
        //$(this).find("img.invisible").fadeIn('fast');
    },function(){
        $(this).find("img.invisible, div.productdetail").fadeOut('fast');
        //$(this).find("img.invisible").fadeOut('fast');
    });
    
    $("img#imgdressingroomdivider").load(function(){
        $("#dressingroomdivider").css('left', (($("div#dressingroomholder").width() - $("div#dressingroomdivider").width()) / 2) + 'px');    
    }); 
           
    fillDressingroomOptions();
    InitializeDressingRoomCounts();
    changedress('top', 0);
    changedress('bottom', 0);
    
    $("#dressingroomoptions").change(function(){
        _dressingroomcurrentbodytype = jQuery(this).val();
        InitializeDressingRoomCounts();
        changedress('top', 0);
        changedress('bottom', 0);
    });
    
    $("#dressingroomtop td.goleft img").click(function(){
        if(_isdressingroomanimating)
            return;
        if(_dressingroomtopindex > 0)
            _dressingroomtopindex--;
        else
            _dressingroomtopindex = _dressingroomtopcount - 1;
        _isdressingroomanimating = true;
        $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeOut('slow',function(){
            changedress('top', _dressingroomtopindex);
            $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeIn('slow', function(){
                _isdressingroomanimating = false;
            });
        });
    });
    
    $("#dressingroomtop td.goright img").click(function(){
        if(_isdressingroomanimating)
            return;
        if(_dressingroomtopindex < _dressingroomtopcount - 1)
            _dressingroomtopindex++;
        else
            _dressingroomtopindex = 0;
        _isdressingroomanimating = true;
        $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeOut('slow',function(){
            changedress('top', _dressingroomtopindex);
            $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeIn('slow', function(){
                _isdressingroomanimating = false;
            });
        });
    });
    
    $("#dressingroombottom td.goleft img").click(function(){
        if(_isdressingroomanimating)
            return;
        if(_dressingroombottomindex > 0)
            _dressingroombottomindex--;
        else
            _dressingroombottomindex = _dressingroombottomcount - 1;
        _isdressingroomanimating = true;
        $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeOut('slow',function(){
            changedress('bottom', _dressingroombottomindex);
            $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeIn('slow', function(){
                _isdressingroomanimating = false;
            });
        }); 
    });
    
    $("#dressingroombottom td.goright img").click(function(){
        if(_isdressingroomanimating)
            return;
        if(_dressingroombottomindex < _dressingroombottomcount - 1)
            _dressingroombottomindex++;
        else
            _dressingroombottomindex = 0;
        _isdressingroomanimating = true;
        $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeOut('slow',function(){
            changedress('bottom', _dressingroombottomindex);
            $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeIn('slow', function(){
                _isdressingroomanimating = false;
            });
        });
    });
    
    $("#dressingroomtop div.viewdetails").click(function(){
         //$( "#productdetailpopup" ).dialog( "open" );
         _dressingroomselectedcolor = _dressingroomcollection[getdressingroomrealindex(_dressingroomcurrentbodytype, 'top', _dressingroomtopindex)].color;
         showproductlightbox(_dressingroomcollection[getdressingroomrealindex(_dressingroomcurrentbodytype, 'top', _dressingroomtopindex)].id);
         
        //console.log(_dressingroomcollection[getdressingroomrealindex(_dressingroomcurrentbodytype, 'top', _dressingroomtopindex)].id);
    });
    
    $("#productdetailpopup").dialog({
        autoOpen: false,
        show: "scale",
        hide: "scale",
        width : 920,
        height : 570,
        modal : true,
        draggable : false,
        position: { my: "center top",at: "center top+80" },
        resizable : false,
        dialogClass : 'yogidialog'
    });
        
    $("#dressingroombottom div.viewdetails").click(function(){
        _dressingroomselectedcolor = _dressingroomcollection[getdressingroomrealindex(_dressingroomcurrentbodytype, 'bottom', _dressingroomtopindex)].color; 
        showproductlightbox(_dressingroomcollection[getdressingroomrealindex(_dressingroomcurrentbodytype, 'bottom', _dressingroombottomindex)].id);
        //console.log(_dressingroomcollection[getdressingroomrealindex(_dressingroomcurrentbodytype, 'bottom', _dressingroombottomindex)].id);
    });
    
    $("div#productdetailpopup img#closelightbox").live("click", function(){
        jQuery( "#productdetailpopup" ).dialog( "close" );
    });
});

function showproductlightbox(productid)
{
    productid = productid.replace('&nbsp;','');
    jQuery("#productdetailpopup").html("<table style='width:100%;height : 100%;'><tr><td style='text-align:center;vertical-align:middle;'>Loading. .</td></tr></table>");
    jQuery( "#productdetailpopup" ).dialog( "open" );
    jQuery.ajax({
        type : 'POST',
        url : homeUrl + 'mycatalog/myproduct/details',
        data : {'id': productid},
        success : function(data){
            jQuery("#productdetailpopup").html(data);
            if(jQuery("div#colorcontainer table:first").length > 0)
                changeColor(_dressingroomselectedcolor);
        }
    });
}

function fillDressingroomOptions()
{
    for(i = 0; i < _dressingroomcollection.length; i++)
    {
        if(jQuery("#dressingroomoptions option[value='" + _dressingroomcollection[i].bodytype + "']").length == 0)
            jQuery("#dressingroomoptions").append("<option value='" + _dressingroomcollection[i].bodytype + "'>" + _dressingroomcollection[i].bodytype + "</option>");
    }
    _dressingroomcurrentbodytype = jQuery("#dressingroomoptions").val();
}

function InitializeDressingRoomCounts()
{
    _dressingroomtopcount = 0;
    _dressingroombottomcount = 0;
    _dressingroomtopindex = 0;
    _dressingroombottomindex = 0;
    for(i = 0; i < _dressingroomcollection.length; i++)
    {
        if(_dressingroomcollection[i].bodytype == _dressingroomcurrentbodytype && _dressingroomcollection[i].half == 'top')
            _dressingroomtopcount++;
        if(_dressingroomcollection[i].bodytype == _dressingroomcurrentbodytype && _dressingroomcollection[i].half == 'bottom')
            _dressingroombottomcount++;
    }
}

function getdressingroomrealindex(bodytype, half, index)
{
    var currentindex = -1;
    for(i = 0; i < _dressingroomcollection.length; i++)
    {
        if(_dressingroomcollection[i].bodytype != bodytype || _dressingroomcollection[i].half != half)
            continue;
        currentindex++;
        if(currentindex == index)
            return i;
    }
}

function changedress(half, index)
{
    var realindex = getdressingroomrealindex(_dressingroomcurrentbodytype, half, index);
    if(half == 'top')
    {
        var left = (jQuery("div#dressingroomtop").width() - (_dressingroomcollection[realindex].width * 1)) / 2;
        jQuery("#dressingroomtop td.imageholder img").attr("src", skinUrl + 'images/catalog/product/dressingroom/models/' + _dressingroomcollection[realindex].image).css('left', left + 'px').css('bottom', '-' + _dressingroomcollection[realindex].overlay + 'px');
        jQuery("#dressingroomtop div.productdetail div.current").html((index + 1));
        jQuery("#dressingroomtop div.productdetail div.totalcount").html(_dressingroomtopcount);
        jQuery("#dressingroomtop div.productdetail div.productname").html(_dressingroomcollection[realindex].name);
        jQuery("#dressingroomtop div.productdetail div.productdescription").html(_dressingroomcollection[realindex].description);
    }
    else
    {
        jQuery("#dressingroombottom td.imageholder img").attr("src", skinUrl + 'images/catalog/product/dressingroom/models/' + _dressingroomcollection[realindex].image);
        jQuery("#dressingroombottom div.productdetail div.current").html((index + 1));
        jQuery("#dressingroombottom div.productdetail div.totalcount").html(_dressingroombottomcount);
        jQuery("#dressingroombottom div.productdetail div.productname").html(_dressingroomcollection[realindex].name);
        jQuery("#dressingroombottom div.productdetail div.productdescription").html(_dressingroomcollection[realindex].description);
    }
}

var _dressingroomcollection = new Array();
var _dressingroomtopcount = 0;
var _dressingroombottomcount = 0;
var _dressingroomtopindex = 0;
var _dressingroombottomindex = 0;
var _dressingroomcurrentbodytype = '';
var _isdressingroomanimating = false;
var _dressingroomselectedcolor = '';