jQuery(document).ready(function($){
	var Wh = $(window).height();
	var mh = Wh*0.9;
	var mv = mh*1.777778;
	jQuery("a[rel=fancyvideo]").fancybox({
		fitToView	:true,
		width		:mv,
		height		:mh,
		autoSize	: true,
		padding		:0,
		openEffect	: 'none',
		closeEffect	: 'none',
		helpers : {
			media : {},
             title : {
                type : 'inside'
            }   
		},
        beforeShow : function() {
            //this.title = '<a href="' + this.href + '" class="addthis_button" addthis:url="' + this.href + '" addthis:title="' + this.title + '"></a>' + (this.title ? ' ' + this.title : '');
            this.title = "<table><tr><td><a class='videosharelink' id='mlvideoshare' href='javascript:void(0);' onclick='sharevideourl(\"mail\")'><div></div></a></td><td><a class='videosharelink' id='fbvideoshare' href='javascript:void(0);' onclick='sharevideourl(\"facebook\")'><div></div></a></td><td><a class='videosharelink' id='twvideoshare' href='javascript:void(0);' onclick='sharevideourl(\"twitter\")'><div></div></a></td><td><a class='videosharelink' id='ptvideoshare' href='javascript:void(0);' onclick='sharevideourl(\"pinterest\")'><div></div></a></td></tr></table>"; 
        }
	});
});


function sharevideourl(sharetype)
{
    var shareurl = homeUrl + 'breathe';
    if(_curshareimgurl == '')
        _curshareimgurl = 'https://yogasmoga.com/yogasmoga_gold.jpg';
    _cursharedesc = "Did You Take a Breathe Today?";
    _currentshareurl = shareurl;
    _cursharesummary = "We are YOGASMOGA, We make things for life - One breathe at a time.";
    _curshareimg[0] = mediaUrl + 'wysiwyg/homepage/video/youtube_fbthumb02.jpg';
    switch(sharetype)
    {
    case 'mail':
        window.location = "mailto:?Subject=" + encodeURIComponent("YOGASMOGA | " + _cursharedesc) + "&body=" + encodeURIComponent("Check out the " + _cursharedesc + " at " + _currentshareurl);
        //window.location = "mailto:?Subject=" + encodeURIComponent("YOGASMOGA | Did You Take a Breathe Today?") + "&body=" + encodeURIComponent("Check Out Yogasmoga Video at " + shareurl);
        break;
    case 'facebook':
        //window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(shareurl) + '&p[images][0]=' + _curshareimgurl + '&p[title]=Yogasmoga Video' + '&p[summary]=Summary Here','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
        window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(_currentshareurl) + '&p[images][0]=' + _curshareimg[0] + '&p[title]=YOGASMOGA | ' + _cursharedesc + '&p[summary]=' + _cursharesummary,'Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
        break;
    case 'twitter':
        window.open('http://www.twitter.com/home?status=Check out the ' + _cursharedesc + ' via @yogasmoga at ' + encodeURIComponent(_currentshareurl),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
        //window.open('http://www.twitter.com/share?url=' + encodeURIComponent(shareurl),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
        break;
    case 'pinterest':
        window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(_currentshareurl) + '&media=' + _curshareimg[0] + '&description=Check out the ' + _cursharedesc + ' via @yogasmoga at ' + _currentshareurl,'Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
        //window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(shareurl) + '&media=' + _curshareimgurl + '&description=Yogasmoga Video','Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
        break;
    default:
    }
}