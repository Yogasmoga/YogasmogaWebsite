jQuery(document).ready(function($){
	$('#dressingroombottom .dritem:first, #dressingroomtop .dritem:first').css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 200).addClass('active');
	
	$('#dressingroombottom, #dressingroomtop').mouseenter(function(){
		$(this).find('a.prevBtn').stop(true,true).fadeIn(100);
		$(this).find('a.nextBtn').stop(true,true).fadeIn(100);
		$(this).find('.productdetail').stop(true,true).fadeIn(100);
	})
	$('#dressingroombottom, #dressingroomtop').mouseleave(function(){
		$(this).find('a.prevBtn').stop(true,true).fadeOut(100);
		$(this).find('a.nextBtn').stop(true,true).fadeOut(100);
		$(this).find('.productdetail').stop(true,true).fadeOut(100);
	})
	$("#dressingroombottom").swipe({
		swipeLeft	:function(){$('a.prevBtn', this).trigger('click')},
		swipeRight	:function(){$('a.nextBtn', this).trigger('click')},
		threshold	:100
	});
    $("#dressingroomtop").swipe({
		swipeLeft	:function(){$('a.prevBtn', this).trigger('click')},
		swipeRight	:function(){$('a.nextBtn', this).trigger('click')},
		threshold	:100
	});
	$('a.prevBtn').click(function(){
		var $ctr = $(this).parent();
		var cur = $ctr.find('.dritem.active');
		var last = $ctr.find('.dritem:last');
		var first = $ctr.find('.dritem:first');
		if($(first).hasClass('active')){
			var next = last;
		}else{
			var next = cur.prev();
		}
		cur.removeClass('active').animate({opacity: 0}, 100 ,function(){
			cur.css({visibility: "hidden"})
		});
		next.addClass('active').css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 50);
	})
	$('a.nextBtn').click(function(){
		var $ctr = $(this).parent();
		var cur = $ctr.find('.dritem.active');
		var last = $ctr.find('.dritem:last');
		var first = $ctr.find('.dritem:first');
		if($(last).hasClass('active')){
			var next = first;
		}else{
			var next = cur.next();
		}
		cur.removeClass('active').animate({opacity: 0}, 100 ,function(){
			cur.css({visibility: "hidden"})
		});
		next.addClass('active').css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 50);
	})
	
    $(".viewdetails").click(function(){
         _dressingroomselectedcolor = $(this).attr('color');
         showproductlightbox($(this).attr('pid'));
    });
	$("#productdetailpopup").dialog({
        autoOpen: false,
        show: "scale",
        hide: "scale",
        width : 920,
        minHeight : 530,
        modal : true,
        draggable : false,
        position: { my: "center top",at: "center top+80" },
        resizable : false,
        dialogClass : 'yogidialog'
    });
        
    
    $(".ui-widget-overlay, div#productdetailpopup img#closelightbox").live("click", function(){
        jQuery( "#productdetailpopup" ).dialog( "close" );
    });
	
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
        
    jQuery("#dressingroombottom td.imageholder img").fadeIn('fast');
    jQuery("#dressingroomtop td.imageholder img").fadeIn('fast');
    
    $("#dressingroomoptions").change(function(){
        _dressingroomcurrentbodytype = jQuery(this).val();
        InitializeDressingRoomCounts();
        changedress('top', 0);
        changedress('bottom', 0);
    });
	/*$("#dressingroombottom").swipe({
		swipeLeft	:function(){moveDressingBotLeft()},
		swipeRight	:function(){moveDressingBotRight()},
		threshold	:100
	});
    $("#dressingroomtop").swipe({
		swipeLeft	:function(){moveDressingroomLeft()},
		swipeRight	:function(){moveDressingroomRight()},
		threshold	:100
	});*/
    $("#dressingroomtop td.goleft img").click(function(){
        moveDressingroomLeft()
    });	
    $("#dressingroomtop td.goright img").click(function(){
        moveDressingroomRight()
    });
	$("#dressingroombottom td.goleft img").click(function(){
        moveDressingBotLeft()
    });
    
    $("#dressingroombottom td.goright img").click(function(){
        moveDressingBotRight()
    });
	
    function moveDressingroomLeft(){
		if(_isdressingroomanimating)
            return;
        if(_dressingroomtopindex > 0)
            _dressingroomtopindex--;
        else
            _dressingroomtopindex = _dressingroomtopcount - 1;
        _isdressingroomanimating = true;
        $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeOut('fast',function(){
            changedress('top', _dressingroomtopindex);
            $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeIn('fast', function(){
                _isdressingroomanimating = false;
            });
        });
	}
	
    function moveDressingroomRight(){
		if(_isdressingroomanimating)
            return;
        if(_dressingroomtopindex < _dressingroomtopcount - 1)
            _dressingroomtopindex++;
        else
            _dressingroomtopindex = 0;
        _isdressingroomanimating = true;
        $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeOut('fast',function(){
            changedress('top', _dressingroomtopindex);
            $("#dressingroomtop").find("div.productdetail,td.imageholder img").fadeIn('fast', function(){
                _isdressingroomanimating = false;
            });
        });
	}
    function moveDressingBotLeft(){
		if(_isdressingroomanimating)
            return;
        if(_dressingroombottomindex > 0)
            _dressingroombottomindex--;
        else
            _dressingroombottomindex = _dressingroombottomcount - 1;
        _isdressingroomanimating = true;
        $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeOut('fast',function(){
            changedress('bottom', _dressingroombottomindex);
            $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeIn('fast', function(){
                _isdressingroomanimating = false;
            });
        }); 
	}
	function moveDressingBotRight(){
		if(_isdressingroomanimating)
            return;
        if(_dressingroombottomindex < _dressingroombottomcount - 1)
            _dressingroombottomindex++;
        else
            _dressingroombottomindex = 0;
        _isdressingroomanimating = true;
        $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeOut('fast',function(){
            changedress('bottom', _dressingroombottomindex);
            $("#dressingroombottom").find("div.productdetail,td.imageholder img").fadeIn('fast', function(){
                _isdressingroomanimating = false;
            });
        });
	}
    
    
    
    
    $(window).resize(function(){
        //setTimeout(function(){ positiondressingroomtopimage(); }, 10);
        positiondressingroomtopimage();
    });
});

function showproductlightbox(productid)
{
    productid = productid.replace('&nbsp;','');
    jQuery("#productdetailpopup").html("<table style='width:100%;height : 530px;'><tr><td style='text-align:center;vertical-align:middle;'>Loading. .</td></tr></table>");
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
        jQuery("#dressingroomtop td.imageholder img").remove();
        jQuery("#dressingroomtop td.imageholder").html("<img src='" + skinUrl + "images/catalog/product/dressingroom/models/" + _dressingroomcollection[realindex].image + "' style='left : " + left + "px; bottom : -" + _dressingroomcollection[realindex].overlay + "px; display : none;' />");
        //jQuery("#dressingroomtop td.imageholder img").attr("src", skinUrl + 'images/catalog/product/dressingroom/models/' + _dressingroomcollection[realindex].image).css('left', left + 'px').css('bottom', '-' + _dressingroomcollection[realindex].overlay + 'px');
        jQuery("#dressingroomtop div.productdetail div.current").html((index + 1));
        jQuery("#dressingroomtop div.productdetail div.totalcount").html(_dressingroomtopcount);
        jQuery("#dressingroomtop div.productdetail div.productname").html(_dressingroomcollection[realindex].name);
        jQuery("#dressingroomtop div.productdetail div.productdescription").html(_dressingroomcollection[realindex].description);
    }
    else
    {
        jQuery("#dressingroombottom td.imageholder img").remove();
        jQuery("#dressingroombottom td.imageholder").html("<img src='" + skinUrl + "images/catalog/product/dressingroom/models/" + _dressingroomcollection[realindex].image + "' style='display:none;' />");
        //jQuery("#dressingroombottom td.imageholder img").attr("src", skinUrl + 'images/catalog/product/dressingroom/models/' + _dressingroomcollection[realindex].image);
        jQuery("#dressingroombottom div.productdetail div.current").html((index + 1));
        jQuery("#dressingroombottom div.productdetail div.totalcount").html(_dressingroombottomcount);
        jQuery("#dressingroombottom div.productdetail div.productname").html(_dressingroomcollection[realindex].name);
        jQuery("#dressingroombottom div.productdetail div.productdescription").html(_dressingroomcollection[realindex].description);
    }
}

function positiondressingroomtopimage()
{
    var realindex = getdressingroomrealindex(_dressingroomcurrentbodytype, 'top', _dressingroomtopindex);
    var left = (jQuery("div#dressingroomtop").width() - (_dressingroomcollection[realindex].width * 1)) / 2;
    jQuery("#dressingroomtop td.imageholder img").css('left', left + 'px');
}

var _dressingroomcollection = new Array();
var _dressingroomtopcount = 0;
var _dressingroombottomcount = 0;
var _dressingroomtopindex = 0;
var _dressingroombottomindex = 0;
var _dressingroomcurrentbodytype = '';
var _isdressingroomanimating = false;
var _dressingroomselectedcolor = '';

function chkfixposition(){
	var $topDress 	= $j('#dressingroomtop'),
		$botDress	= $j('#dressingroombottom'),
		$container	= $j('#dressingroomholder'),
		contWidth	= $container.attr('actWidth'),
		$topDH 		= parseInt($topDress.attr('actHeight')),
		$botDH		= parseInt($botDress.attr('actHeight'))
		$topSH 		= getScaledheight($topDH, contWidth),
		$botSH		= getScaledheight($botDH, contWidth);
	$j('.doverlay').fadeOut(250);
	$j('#dressingroomtop .dritem').each(function(){
		var dressimgpos = $j(this).attr('botpos');
		var newbpos = getScaledheight(dressimgpos, contWidth)
		$j(this).css({bottom: '-'+newbpos+'px'})
	})
	$topDress.height($topSH);
	$botDress.height($botSH);
	$j('#dressingroomholder img').each(function(){
		var NewLeft = $j(this).width()/2;
		$j(this).css({marginLeft: '-'+NewLeft+'px'})
	})
}
function getScaledheight(originalheight, originalwidth)
{
    //console.log('calculating');
    originalheight = originalheight * 1;
    originalwidth = originalwidth * 1;
	var h =((originalheight / originalwidth) * (jQuery("div#pagecontainer").width() * 1));
    return Math.ceil(h);
}

function getScaledwidth(originalheight, originalwidth)
{
    //console.log('calculating');
    originalheight = originalheight * 1;
    originalwidth = originalwidth * 1;
    w = ((originalwidth / originalheight) * _winH);
	return Math.ceil(w);
}
$j(window).load(function(){
	chkfixposition()
})
var id;
$j(window).resize(function() {
	$j('.doverlay').fadeIn(0);
    clearTimeout(id);
    id = setTimeout(chkfixposition, 500);
    
});