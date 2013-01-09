jQuery(document).ready(function($){
	jQuery("a[rel=fancyvideo]").fancybox({
		width		: '100%',
		height		: '100%',
		fitToView	:true,
		autoSize	: true,
		openEffect	: 'none',
		closeEffect	: 'none',
		helpers : {
			media : {}
		}
	});
});

