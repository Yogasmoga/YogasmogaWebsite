jQuery(document).ready(function($){
	jQuery("a[rel=fancyvideo]").fancybox({
		width		: '85%',
		fitToView	:true,
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
    var shareurl = 'http://192.168.2.110/yogasmoga/index.php?video=true';
    if(_curshareimgurl == '')
        _curshareimgurl = 'https://yogasmoga.com/yogasmoga_gold.jpg';
    switch(sharetype)
    {
    case 'mail':
        window.location = "mailto:?Subject=" + encodeURIComponent("Check it out!!") + "&body=" + encodeURIComponent("Check Out Yogasmoga Video at " + shareurl);
        break;
    case 'facebook':
        window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(shareurl) + '&p[images][0]=' + _curshareimgurl + '&p[title]=Yogasmoga Video' + '&p[summary]=Summary Here','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
        break;
    case 'twitter':
        window.open('http://www.twitter.com/share?url=' + encodeURIComponent(shareurl),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
        break;
    case 'pinterest':
        window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(shareurl) + '&media=' + _curshareimgurl + '&description=Yogasmoga Video','Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
        break;
    default:
    }
}