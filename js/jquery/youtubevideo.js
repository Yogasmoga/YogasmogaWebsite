jQuery(document).ready(function($){
	jQuery("a[rel=fancyvideo]").fancybox({
		width		: '85%',
		fitToView	:true,
		autoSize	: true,
		padding		:0,
		openEffect	: 'none',
		closeEffect	: 'none',
		helpers : {
			media : {}
		}
	});
});

